<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 18-Dec-18
 * Time: 12:28 PM
 */

namespace App\Http\Controllers\Scientific_Seminar;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

//Request $request

class Pending_Request_Controller extends Controller
{
    public function index()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $year = DB::select("

                    SELECT to_number(to_char(sysdate, 'RRRR'))-ROWNUM+1 year
                    FROM DUAL CONNECT BY ROWNUM <= 8
                           
                 ");

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");


        $gl = DB::select("
                                            select distinct gl
                                            from mis.ss_budget_cost_center
                                            ");

        return view('scientific.pending_request')->with(['year' => $year, 'rm_terr' => $rm_terr]);



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


    public function proposal_and_bill(Request $request)
    {

        $proposal = DB::select("
                    select prog_no
                    from(
                    select 'ALL' all_data,to_char(to_date('01-'||month_of_prog,'DD-MON-RR'),'RRRR') program_year,month_of_prog program_month,prog_team,
                    program_type,prog_no,bill_no,prog_date_time,rm_terr_id,am_terr_id,mpo_terr_id,depot_id,depot_name,rm_checked_date,
                    dsm_checked_date,ms_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date
                    from mis.ss_program_app
                    where ss_prog = 'PROPOSAL'
                    )where '$request->year' = case when '$request->year' = 'ALL' then all_data else program_year end
                    and '$request->month' = case when '$request->month' = 'ALL' then all_data else program_month end
                    and '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else rm_terr_id end
                    and prog_no is not null
                    order by  prog_no                                       
                         
                                            ");


        $bill = DB::select("
                    select bill_no
                    from(
                    select 'ALL' all_data,to_char(to_date('01-'||month_of_prog,'DD-MON-RR'),'RRRR') program_year,month_of_prog program_month,prog_team,
                    program_type,prog_no,bill_no,prog_date_time,rm_terr_id,am_terr_id,mpo_terr_id,depot_id,depot_name,rm_checked_date,
                    dsm_checked_date,ms_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date
                    from mis.ss_program_app
                    where ss_prog = 'BILL'
                    )where '$request->year' = case when '$request->year' = 'ALL' then all_data else program_year end
                    and '$request->month' = case when '$request->month' = 'ALL' then all_data else program_month end
                    and '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else rm_terr_id end 
                    and bill_no is not null
                    order by  bill_no                                          
                         
                                            ");


        return response()->json(['proposal' => $proposal,'bill' => $bill]);

    }


    public function pending_request_data(Request $request)
    {
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {
//            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $cc = DB::select("
               
            select program_year,program_month,prog_team,program_type,prog_no,bill_no,prog_date_time,rm_terr_id,am_terr_id,mpo_terr_id,depot_id,
            depot_name,rm_checked_date,dsm_checked_date,ms_checked_date,msd_manager_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,ssd_checked_date,
            advance_budget,actual_expenditure, voucher_no , voucher_date
            from(
            select 'ALL' all_data,to_char(to_date('01-'||month_of_prog,'DD-MON-RR'),'RRRR') program_year,month_of_prog program_month,prog_team,
            program_type,prog_no,bill_no,prog_date_time,rm_terr_id,am_terr_id,mpo_terr_id,spa.depot_id,depot_name,rm_checked_date,
            dsm_checked_date,ms_checked_date,msd_manager_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,ssd_checked_date,
            advance_budget,actual_expenditure,voucher_no , spv.create_date voucher_date
            from mis.ss_program_app spa, mis.ss_program_voucher spv
            where spv.proposal_bill_no(+) = case when spa.ss_prog = 'PROPOSAL' then spa.prog_no else spa.bill_no end
            )where '$request->year' = case when '$request->year' = 'ALL' then all_data else program_year end
            and '$request->month' = case when '$request->month' = 'ALL' then all_data else program_month end
            and '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else rm_terr_id end
            and '$request->proposal' = case when '$request->proposal' = 'ALL' then all_data else prog_no end
            and '$request->bill' = case when '$request->bill' = 'ALL' then all_data else bill_no end

                   ");

            return response()->json($cc);
        }
    }


}