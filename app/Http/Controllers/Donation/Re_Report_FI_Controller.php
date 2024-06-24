<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 11/20/2019
 * Time: 1:48 PM
 */



namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Re_Report_FI_Controller extends Controller{

    public function index(){

        $year = DB::select("select distinct to_char(to_date(payment_month,'MON-RR'),'RRRR') year
                            from mis.donation_req_correction drc,mis.donation_expense_budget deb
                            where drc.req_id = deb.req_id
                                     ");

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $gl = DB::select("
                                     select   distinct gl
                                     from mis.donation_cost_center
                                     where budget_type = 'DONATION'

                                     ");

        $cc = DB::select("
                        select cost_center_id,cost_center_description,department
                    from mis.donation_cost_center
                    where budget_type = 'DONATION'
                    ORDER BY cost_center_description

                              ");


        return view('donation.re_report_fi')->with(['year' => $year,'gl' =>$gl,'cc'=>$cc]);

    }


    public function re_report_data(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        $uid = Auth::user()->user_id;

        $resp_data = DB::Select("
            
        select to_char(to_date(payment_month,'MON-RR'),'RRRR') re_year,payment_month,gl,
        cost_center_id,summ_id,fi_doc_no,payment_mode,amount,Date_of_fid_post
        from(                                
        select 'ALL' all_data,to_char(to_date(payment_month,'MON-RR'),'RRRR') re_year,payment_month,cost_center_id,gl,
        summ_id,fi_doc_no,payment_mode,sum(nvl(approved_amount,0)) amount,to_date(update_date,'DD-MON-RR') Date_of_fid_post
        from mis.donation_req_correction drc,mis.donation_expense_budget deb
        where drc.req_id = deb.req_id
        and to_char(to_date(payment_month,'MON-RR'),'RRRR') = '$request->year'
        group by to_char(to_date(payment_month,'MON-RR'),'RRRR'),payment_month,cost_center_id,gl,
        summ_id,fi_doc_no,payment_mode,to_date(update_date,'DD-MON-RR')
        )where '$request->month' =  case when '$request->month' = 'ALL' then all_data else payment_month end
        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
        and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end
        and '$request->sum' = case when '$request->sum' = 'ALL' then all_data else to_char(summ_id) end
        and '$request->fidoc' = case when '$request->fidoc' = 'ALL' then all_data else fi_doc_no end
        and '$request->ct' = case when '$request->ct' = 'ALL' then all_data else payment_mode end
        order by to_date(payment_month,'MON-RR'),summ_id
                                                                                                          
                                    ");

        return response()->json($resp_data);
    }

    public function re_year(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("
            
               select to_char(add_months(to_date(sysdate,'DD-MON-RRRR'),level -1),'MON') ||'-'||(select substr('$request->year',-2,2) from dual) payment_month
from dual connect by level <= 12
order by to_char(add_months(to_date(sysdate,'DD-MON-RRRR'),level -1),'MM')                                                                                                    
                                    ");

        return response()->json($resp_data);
    }

    public function re_month(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("
            
                select distinct cost_center_id
                from(
                select distinct 'ALL' all_data,payment_month,cost_center_id
                from mis.donation_req_correction drc,mis.donation_expense_budget deb
                where drc.req_id = deb.req_id
                and to_char(to_date(payment_month,'MON-RR'),'RRRR') = '$request->year'
                )where '$request->month' =  case when '$request->month' = 'ALL' then all_data else payment_month end                                                                                                    
                                    ");

        return response()->json($resp_data);
    }

    public function re_cc(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("
            
              select distinct summ_id
            from(
            select distinct 'ALL' all_data,payment_month,summ_id,cost_center_id
            from mis.donation_req_correction drc,mis.donation_expense_budget deb
            where drc.req_id = deb.req_id
            and to_char(to_date(payment_month,'MON-RR'),'RRRR') = '$request->year'
            )where '$request->month' =  case when '$request->month' = 'ALL' then all_data else payment_month end
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end                                                                                                   
                                    ");

        return response()->json($resp_data);
    }

    public function re_sum(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("
            
               select distinct fi_doc_no
            from(
            select distinct 'ALL' all_data,payment_month,summ_id,cost_center_id,fi_doc_no
            from mis.donation_req_correction drc,mis.donation_expense_budget deb
            where drc.req_id = deb.req_id
            and to_char(to_date(payment_month,'MON-RR'),'RRRR') = '$request->year'
            )where '$request->month' =  case when '$request->month' = 'ALL' then all_data else payment_month end
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
            and '$request->sum' = case when '$request->sum' = 'ALL' then all_data else to_char(summ_id) end                                                                                                   
                                    ");

        return response()->json($resp_data);
    }



}