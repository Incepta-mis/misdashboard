<?php


namespace App\Http\Controllers\Scientific_Seminar;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Mail;


class Reports_Controller extends Controller
{

    public function outstanding_proposal_view()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

//        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
//                            union all
//                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
//                 ");

        $month_name = DB::select("
                        select distinct month_of_prog from 
                        mis.ss_program_app
                                     ");

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

        $depot_info = DB::select("
                                    select  depot_id, depot_name,email from mis.donation_depot_info
                                     ");

        $gl = DB::select("
                                            select distinct gl
                                            from mis.ss_budget_cost_center
                                            ");

        return view('scientific.outstanding_proposal')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr,'depot' => $depot_info, 'gl' => $gl]);



    }

    public function opdata_display(Request $request)
    {
            $cc = DB::select("
            select * from         
            (
            select   'ALL' all_data,prog_team,gl,cost_center_id,cc_team_name,rm_terr_id,rm_name,spa.prog_no,prog_date_time,
            spa.depot_id,depot_name,pro_amt,spv.create_date,month_of_prog
            from   mis.ss_program_app spa, mis.ss_program_voucher spv,mis.ss_budget_details_app sba
            where spa.prog_no = spv.proposal_bill_no(+)
            and  sba.prog_no = spa.prog_no 
            and spa.ss_prog = 'PROPOSAL'
            )          
            where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id)end
            and '$request->month' = case when '$request->month' = 'ALL' then all_data else month_of_prog end
            and  '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else rm_terr_id end
            and  '$request->depot' = case when '$request->depot' = 'ALL' then all_data else to_char(depot_id) end        
            order by prog_no,cost_center_id
                            ");

            return response()->json($cc);
    }

    public function bill_settlement_view()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

//        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
//                            union all
//                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
//                 ");

        $month_name = DB::select("
                        select distinct month_of_prog from 
                        mis.ss_program_app
                                     ");

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

        $depot_info = DB::select("
                                    select  depot_id, depot_name,email from mis.donation_depot_info
                                     ");

        $gl = DB::select("
                                            select distinct gl
                                            from mis.ss_budget_cost_center
                                            ");

        return view('scientific.bill_settlement')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr,'depot' => $depot_info, 'gl' => $gl]);



    }

    public function bsdata_display(Request $request)
    {
        $cc = DB::select("
            select * from         
            (
            select   'ALL' all_data,prog_team,gl,cost_center_id,cc_team_name,rm_terr_id,rm_name,spa.prog_no,spa.bill_no,
            prog_date_time,spa.depot_id,depot_name,pro_amt,bill_amt
            ,month_of_prog, spv.create_date bill_date,
            (select create_date withdraw_date from  mis.ss_program_voucher where proposal_bill_no= spa.prog_no) withdraw_date,
            (select create_date withdraw_date from  mis.ss_program_voucher where proposal_bill_no= spa.bill_no) settle_date
            from   mis.ss_program_app spa, mis.ss_program_voucher spv,mis.ss_budget_details_app sba
            where spa.bill_no = spv.proposal_bill_no(+)
            and  sba.bill_no = spa.bill_no 
            and spa.ss_prog = 'BILL'
            )           
            where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id)end
            and '$request->month' = case when '$request->month' = 'ALL' then all_data else month_of_prog end
            and  '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else rm_terr_id end
            and  '$request->depot' = case when '$request->depot' = 'ALL' then all_data else to_char(depot_id) end        
            order by prog_no,cost_center_id

                            ");

        return response()->json($cc);
    }

    public function budget_actual_consumption_view()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");

        $gl = DB::select("
                                            select distinct gl
                                            from mis.ss_budget_cost_center
                                            ");

//        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
//                                    from hrtms.hr_terr_list@web_to_hrtms
//                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
//                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)
//                                    order by rm_terr_id");
//
//        $depot_info = DB::select("
//                                    select  depot_id, depot_name,email from mis.donation_depot_info
//                                     ");
//
//        $program_team = DB::select("
//               select distinct prog_team_name from mis.ss_program_team order by  prog_team_name
//        ");

        return view('scientific.budget_actual_consumption')->with(['year' => $year, 'gl' => $gl]);

//        return view('scientific.budget_actual_consumption')->with(['year' => $year, 'rm_terr' => $rm_terr,'depot' => $depot_info,'pteam' => $program_team]);

    }

    public function budget_actual_consumption_data (Request $request)
    {
        $cc = DB::select("

                select * from
                (select 'ALL' all_data,sse.expense_month ,to_char(to_date(expense_month,'MON-RR'),'RRRR') yr,
                ssbcc.gl,ssbcc.cost_center_id,ssbcc.cc_team_name,budget_amt,cf_amt, (budget_amt + cf_amt) as total_amt ,bill_amt 
                from scientific_seminar_expense sse,
                mis.ss_budget_cost_center ssbcc
                where sse.cost_center_id(+) = ssbcc.cost_center_id
                )
                where
                '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                and '$request->month' = case when '$request->month' = 'ALL' then all_data else to_char(expense_month) end
                and '$request->year' = yr
                order by  to_date(expense_month,'MON-RR')

                            ");

        return response()->json($cc);
    }

    public function teamwise_budget_expense_view()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $year = DB::select("
                            select to_number(to_char(sysdate, 'RRRR'))-1 year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");

        $gl = DB::select("
                                            select distinct gl
                                            from mis.ss_budget_cost_center
                                            ");

        return view('scientific.team_wise_budget_expense')->with(['year' => $year, 'gl' => $gl]);

    }

    public function tbedata_display(Request $request)
    {
        $cc = DB::select("
                select * from
                (
                select 'ALL' all_data,prog_team,gl,cost_center_id,cc_team_name,rm_terr_id,rm_name,spa.prog_no,spa.bill_no,
                prog_date_time,spa.depot_id,depot_name,pro_amt,bill_amt,to_char(to_date(month_of_prog,'MON-RR'),'RRRR') yr
                ,month_of_prog, spv.create_date bill_date,
                (select create_date withdraw_date from mis.ss_program_voucher where proposal_bill_no= spa.prog_no) withdraw_date,
                (select create_date withdraw_date from mis.ss_program_voucher where proposal_bill_no= spa.bill_no) settle_date
                from mis.ss_program_app spa, mis.ss_program_voucher spv,mis.ss_budget_details_app sba
                where spa.bill_no = spv.proposal_bill_no
                and sba.bill_no = spa.bill_no
                and spa.ss_prog = 'BILL'
                )   
                where
                '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                and '$request->month' = case when '$request->month' = 'ALL' then all_data else to_char(month_of_prog) end
                and '$request->year' = yr
                order by   to_date(month_of_prog,'MON-RR') ,
                prog_no,cost_center_id

                            ");

        return response()->json($cc);
    }

    public function depotwise_actual_view()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");
        $gl = DB::select("
                                            select distinct gl
                                            from mis.ss_budget_cost_center
                                            ");

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

        $depot_info = DB::select("
                                    select  depot_id, depot_name,email from mis.donation_depot_info
                                     ");

        $program_team = DB::select("
               select distinct prog_team_name from mis.ss_program_team order by  prog_team_name
        ");

        return view('scientific.depot_wise_actual')->with(['year' => $year, 'rm_terr' => $rm_terr,'depot' => $depot_info,'pteam' => $program_team,'gl' => $gl]);

    }

    public function depot_wise_data_display(Request $request)
    {
        $cc = DB::select("
                select * from
                (
                select 'ALL' all_data,prog_team,gl,cost_center_id,cc_team_name,rm_terr_id,rm_name,spa.prog_no,spa.bill_no,
                prog_date_time,spa.depot_id,depot_name,pro_amt,bill_amt,to_char(to_date(month_of_prog,'MON-RR'),'RRRR') yr
                ,month_of_prog, spv.create_date bill_date,
                (select create_date withdraw_date from mis.ss_program_voucher where proposal_bill_no= spa.prog_no) withdraw_date,
                (select create_date withdraw_date from mis.ss_program_voucher where proposal_bill_no= spa.bill_no) settle_date
                from mis.ss_program_app spa, mis.ss_program_voucher spv,mis.ss_budget_details_app sba
                where spa.bill_no = spv.proposal_bill_no
                and sba.bill_no = spa.bill_no
                and spa.ss_prog = 'BILL'
                )   
                where
                '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                and '$request->month' = case when '$request->month' = 'ALL' then all_data else to_char(month_of_prog) end
                and '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else to_char(rm_terr_id) end
                and '$request->depot' = case when '$request->depot' = 'ALL' then all_data else to_char(depot_id) end
                and '$request->year' = yr
                  order by   to_date(month_of_prog,'MON-RR') , 
                prog_no,cost_center_id

                            ");

        return response()->json($cc);
    }

}