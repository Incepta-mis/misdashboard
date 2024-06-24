<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmsModuleAuthenticate
{
    /*
     * Created By: Md. Raqib Hasan
     * Emp Code: 1012064
     */
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $verified = DB::select('select * 
                                from MIS.DASH_MENU_CATEGORY 
                                where user_role = ? 
                                and mcategory = ?',[Auth::user()->urole,12]);

        if(!$verified){
           return redirect('/');
        }
        return $next($request);
    }
}
