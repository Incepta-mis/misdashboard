<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 26/09/2020
 * Time: 1:19 PM
 */

namespace App\Http\Controllers\Scientific_Seminar;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;


class Scientific_Seminar_Report_Controller extends Controller
{
    public function index()
    {

        $uid = Auth::user()->user_id;

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 30)
                                    select *
                                      from (select trunc(add_months(sysdate, -29)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $program_no = DB::select("
                
               select distinct prog_no 
                        from 
                        (select am_terr_id,prog_no 
                        from mis.ss_program_app
                        where  gm_msd_checked_date is not null
                        and ss_prog = 'PROPOSAL') ssp,(select am_terr_id from hrtms.hr_terr_list@web_to_hrtms 
                        where case when rm_emp_id is null then asm_emp_id else rm_emp_id end = '$uid' and emp_month = trunc(sysdate,'MM')) ei
                        where ssp.am_terr_id = ei.am_terr_id
                        
                        union 
                        
                        select prog_no
                        from mis.ss_program_app
                        where create_user = '$uid'
                        AND gm_msd_checked_date is not null
                        and ss_prog = 'PROPOSAL'

              
        ");

        $bill_no = DB::select("
                   select bill_no
                    from mis.ss_program_app
                    where create_user = '$uid'
                     AND gm_msd_checked_date is not null
                    and bill_no is not null
                    order by bill_no
            ");

        $budget = DB::select("
            select * from
            mis.ss_budget_details_app  program_no_for_report
            where prog_no = 'SSPN-2'
            
            ");

        $cost = DB::select("
                    select * from 
                    mis.ss_cost_details_app
                    where prog_no = 'SSPN-2'
                                            ");

        return view('scientific.scientific_seminar_reports')->with(['month_name' => $month_name,'program_no' => $program_no, 'bill_no' => $bill_no, 'budget' => $budget, 'cost' => $cost]);


    }

    public function program_and_bill(Request $request)
{
    DB::statement("alter session set nls_date_format = 'DD-MON-RR HH12:MI:SS AM'");
    $uid = Auth::user()->user_id;

    try {

        if (Auth::user()->urole == '46'){

            $program_no = DB::select("

                        select prog_no
                        from mis.ss_program_app
                        where   month_of_prog = '$request->mon'
                        and ss_prog = 'PROPOSAL'
                        order by prog_no
  
        ");

            $bill_no = DB::select("
                   select bill_no
                    from mis.ss_program_app
                    where  month_of_prog = '$request->mon'
                    and ss_prog = 'BILL'
                    order by bill_no
            ");


        }

       else if (Auth::user()->urole == '11'|| Auth::user()->urole == '32'){

           $program_no = DB::select("
                           
                        select prog_no
                        from 
                        (select prog_team,prog_no 
                        from mis.ss_program_app
                        where ms_checked_date is not null
                        and group_head_checked_date is not null
                        and prog_team <> 'AHVD'
                        and ss_prog = 'PROPOSAL'
                        and month_of_prog = '$request->mon'
                        union all
                        select prog_team,prog_no 
                        from mis.ss_program_app
                        where dsm_checked_date is not null
                        and month_of_prog = '$request->mon'
                        and group_head_checked_date is not null
                        and prog_team = 'AHVD' and ss_prog = 'PROPOSAL') pa,(select prog_team_name from mis.ss_program_team 
                        where group_head_id = '$uid') pt
                        where pa.prog_team = pt.prog_team_name 
                           
                            ");

           $bill_no = DB::select("
                           
                        select bill_no
                        from 
                        (select prog_team,bill_no 
                        from mis.ss_program_app
                        where bill_no is not null 
                        and ms_checked_date is not null
                        and group_head_checked_date is not null
                        and prog_team <> 'AHVD'
                        and month_of_prog = '$request->mon'
                        union all
                        select prog_team,bill_no 
                        from mis.ss_program_app
                        where bill_no is not null 
                        and month_of_prog = '$request->mon'
                        and dsm_checked_date is not null
                        and group_head_checked_date is not null
                        and prog_team = 'AHVD') pa,(select prog_team_name from mis.ss_program_team 
                        where group_head_id = '$uid') pt
                        where pa.prog_team = pt.prog_team_name 
                           
                            ");


        }
       else if (Auth::user()->urole == '30'){

           $program_no = DB::select("

                        select prog_no
                        from mis.ss_program_app
                        where   month_of_prog = '$request->mon'
                        and ss_prog = 'PROPOSAL'
                        and prog_team = 'AHVD'
                        order by prog_no
  
        ");

           $bill_no = DB::select("
                   select bill_no
                    from mis.ss_program_app
                    where  month_of_prog = '$request->mon'
                    and ss_prog = 'BILL'
                    and prog_team = 'AHVD'
                    order by bill_no
            ");


       }

        else {

            $program_no = DB::select("
                
               select distinct prog_no 
                        from 
                        (select am_terr_id,prog_no 
                        from mis.ss_program_app
                        where  ssd_checked_date is not null
                        and  month_of_prog = '$request->mon'
                        and ss_prog = 'PROPOSAL') ssp,(select am_terr_id from hrtms.hr_terr_list@web_to_hrtms 
                        where case when rm_emp_id is null then asm_emp_id else rm_emp_id end = '$uid' and emp_month = to_date('$request->mon','MON-RR') ) ei
                        where ssp.am_terr_id = ei.am_terr_id
                        
                        union 
                        
                        select prog_no
                        from mis.ss_program_app
                        where create_user = '$uid'
                        and  month_of_prog = '$request->mon'
                        AND ssd_checked_date is not null
                        and ss_prog = 'PROPOSAL'

              
        ");

            $bill_no = DB::select("
                  
                select distinct bill_no 
                from 
                (select am_terr_id,bill_no 
                from mis.ss_program_app
                where  ssd_checked_date is not null
                and  month_of_prog = '$request->mon'
                and ss_prog = 'BILL') ssp,(select am_terr_id from hrtms.hr_terr_list@web_to_hrtms 
                where case when rm_emp_id is null then asm_emp_id else rm_emp_id end = '$uid' and emp_month = to_date('$request->mon','MON-RR') ) ei
                where ssp.am_terr_id = ei.am_terr_id  
                union               
                select bill_no
                from mis.ss_program_app
                where create_user = '$uid'
                and  month_of_prog = '$request->mon'
                and ssd_checked_date is not null
                and bill_no is not null
                order by bill_no
                                  
            ");

        }


    } catch (Oci8Exception $e) {
        $result = $e->getMessage();
    }

    return response()->json(['proposal' => $program_no,'bill' => $bill_no]);

}

    public function print_proposal_report(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH12:MI:SS AM'");

        try {

            $result = DB::select("

                select to_char(sysdate,'dd-MON-rrrr') as dat,spa.* from 
                mis.ss_program_app spa
                where prog_no = '$request->program_no_for_report'
 
                ");


            $budget = DB::select("
            select * from
            mis.ss_budget_details_app  
            where prog_no = '$request->program_no_for_report'
            
            ");

            $gl = DB::select("
            select distinct gl from
            mis.ss_budget_details_app  
            where prog_no = '$request->program_no_for_report'
            
            ");

            $cost = DB::select("
                    select * from 
                    mis.ss_cost_details_app
                    where prog_no = '$request->program_no_for_report'
                                            ");


            $data = ['rs_data' => $result, 'budget' => $budget, 'cost' => $cost,'gl' =>$gl];
//            dd($data);


            $pdf = \PDF::loadView('scientific/proposal_report', $data);
            return $pdf->stream('scientific_seminar_proposal.pdf');



        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


    }

    public function print_bill_report(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH12:MI:SS AM'");

        try {

            $result = DB::select("

                select to_char(sysdate,'dd-MON-rrrr') as dat,spa.* from 
                mis.ss_program_app spa
                where bill_no = '$request->bill_no_for_report'
 
                ");


            $budget = DB::select("
            select * from
            mis.ss_budget_details_app  
            where bill_no = '$request->bill_no_for_report'
            
            ");

            $gl = DB::select("
            select distinct gl from
            mis.ss_budget_details_app  
            where bill_no = '$request->bill_no_for_report'
            
            ");

            $cost = DB::select("
                    select * from 
                    mis.ss_cost_details_app
                    where bill_no = '$request->bill_no_for_report'
                                            ");


            $data = ['rs_data' => $result, 'budget' => $budget, 'cost' => $cost,'gl' =>$gl];
//            dd($data);


            $pdf = \PDF::loadView('scientific/bill_report', $data);
            return $pdf->stream('scientific_seminar_bill.pdf');



        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


    }


}