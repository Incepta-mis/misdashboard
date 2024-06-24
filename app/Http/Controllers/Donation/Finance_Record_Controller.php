<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 18-Dec-18
 * Time: 12:28 PM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Finance_Record_Controller extends Controller
{
    public function index()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $month_name = DB::select("
                                     select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 2)
                                    select *
                                      from (select trunc(add_months(sysdate, -1)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");


        return view('donation.finance_record_monthly');


    }

    public function finance_record_data(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $data = DB::select("
            select payment_month,count(*) total_no_of_req,sum(nvl(APPROVED_AMOUNT,0)) app_amt,count(case when payment_mode = 'CASH' then drc.req_id else null end) cash_req,
            sum(case when payment_mode = 'CASH' then nvl(APPROVED_AMOUNT,0) else 0 end) cash_req_amt,
            count(case when payment_mode = 'CHEQUE' then drc.req_id else null end) cheque_req,
            sum(case when payment_mode = 'CHEQUE' then nvl(APPROVED_AMOUNT,0) else 0 end) cheque_req_amt
            from mis.donation_req_correction drc,mis.donation_expense_budget deb
            where to_date(payment_month,'MON-RR') between '$request->month_from' and '$request->month_to'
            and drc.req_id = deb.req_id
            and ref_no is not null
            group by payment_month
            order by to_date(payment_month,'MON-RR')
        ");


        return response()->json($data);
                        }


}