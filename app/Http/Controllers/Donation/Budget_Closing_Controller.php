<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 11/18/2019
 * Time: 11:13 AM
 */


namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Budget_Closing_Controller extends Controller{

    public function index(){

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");



        return view('donation.budget_closing')->with(['month_name' => $month_name]);

    }

    public function budget_closing_procedure(Request $request)
    {
        $uid = Auth::user()->user_id;

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            try {

                $result = DB::executeProcedure('mis.proc_research_expense_mclosing', ['bud_month' => $request->mon ]);

                DB::update("
                
                    UPDATE   mis.donation_expense_closing
                       SET   create_date = SYSDATE, create_user = '$uid'
                     WHERE   budget_month = '$request->mon'
                ");

            } catch (Oci8Exception $e) {
                $result = $e->getMessage();
            }
            return response()->json($result);


        }
    }


}