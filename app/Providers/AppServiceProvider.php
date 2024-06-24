<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){
            //doctor_marriage_birthday_reminder notification
            if(Auth::user() !== null){
                if(explode('|',Auth::user()->remark1)[0] === 'DBAR'){
                    $bday = DB::select("select count(*) tc
                                from (
                                     select doctor_id id,doctor_name name,to_char(birthday,'DD-MON') edate,trunc(birthday-sysdate) day_diff
                                    from MIS.DASH_DOC_ANNIV_BDAY_BK
                                    where birthday is not null
                                    and trunc(birthday-sysdate) between 0 and 3
                                    union all
                                    select doctor_id id,doctor_name name,to_char(MARRIAGE_DAY,'DD-MON') edate,trunc(marriage_day-sysdate) day_diff
                                    from MIS.DASH_DOC_ANNIV_BDAY_BK
                                    where marriage_day is not null
                                    and trunc(marriage_day-sysdate) between 0 and 3
                                )
                            ");

                    $view->with('dbmcnt',$bday);
                }
            }


        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
