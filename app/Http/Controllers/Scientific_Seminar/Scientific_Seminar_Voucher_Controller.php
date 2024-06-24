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


class Scientific_Seminar_Voucher_Controller extends Controller
{
    public function index()
    {

        $uid = Auth::user()->user_id;

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $program_no = DB::select("

                    select prog_no 
                    from 
                    mis.ss_program_app
                    where ss_prog = 'PROPOSAL'
                    and ssd_checked_date is not null
                    and DEPOT_ID = (
                    SELECT  depot_id FROM MIS.SS_DEPOT_EMP
                    where DEPOT_EMP_ID = '$uid'
                    )
                    minus
                    select proposal_bill_no 
                    from mis.ss_program_voucher
                    where voucher_type = 'PROPOSAL'
                    and voucher_status in (1,2)
              
        ");

        $program_no_duplicate = DB::select("
                
                select PROPOSAL_BILL_NO 
                from   mis.ss_program_voucher
                where  voucher_status = 1
                and  voucher_type =  'PROPOSAL' 
                  and DEPOT_ID = (
                    SELECT  depot_id FROM MIS.SS_DEPOT_EMP
                    where DEPOT_EMP_ID = '$uid'
                    )
            
              
        ");

        $bill_no = DB::select("
                        select bill_no from 
                        mis.ss_program_app
                        where ss_prog = 'BILL'
                        and ssd_checked_date is not null
                        and DEPOT_ID = (
                        SELECT  depot_id FROM MIS.SS_DEPOT_EMP
                        where DEPOT_EMP_ID = '$uid'
                        )
                        minus
                        select proposal_bill_no 
                        from mis.ss_program_voucher
                        where voucher_type = 'BILL'
                        and voucher_status in (1,2)
            ");

        $bill_no_duplicate = DB::select("
                
                select PROPOSAL_BILL_NO 
                from   mis.ss_program_voucher
                where  voucher_status = 1
                and  voucher_type =  'BILL' 
                 and DEPOT_ID = (
                    SELECT  depot_id FROM MIS.SS_DEPOT_EMP
                    where DEPOT_EMP_ID = '$uid'
                    )
            
              
        ");

        return view('scientific.seminar_voucher')->with(['month_name' => $month_name, 'program_no' => $program_no, 'bill_no' => $bill_no,
            'program_no_duplicate' => $program_no_duplicate,'bill_no_duplicate' =>$bill_no_duplicate]);


    }

    public function program_and_bill(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH12:MI:SS AM'");
        $uid = Auth::user()->user_id;

        try {

            $program_no = DB::select("
                
                    select prog_no from 
                    mis.ss_program_app
                    where ss_prog = 'PROPOSAL'
                    and ssd_checked_date is not null
                    minus
                    select proposal_bill_no 
                    from mis.ss_program_voucher
                    where voucher_type = 'PROPOSAL'
              
        ");

            $bill_no = DB::select("
                        select bill_no from 
                        mis.ss_program_app
                        where ss_prog = 'BILL'
                        and ssd_checked_date is not null
                        minus
                        select proposal_bill_no 
                        from mis.ss_program_voucher
                        where voucher_type = 'BILL'
            ");


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }

        return response()->json(['proposal' => $program_no, 'bill' => $bill_no]);

    }

    public function create_proposal_voucher(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH12:MI:SS AM'");
        $uid = Auth::user()->user_id;

        try {

            $occurance = '';
            $insert_proposal_voucher = '';

            $occurance = DB::select("
                
                    select count(*) times
                    from mis.ss_program_voucher where proposal_bill_no = '$request->proposal_no'
              
        ");
            if ($occurance[0]->times == 0) {

                $insert_proposal_voucher = DB::insert("
                insert into mis . SS_PROGRAM_VOUCHER
                (VOUCHER_NO, PROPOSAL_BILL_NO, VOUCHER_TYPE,DEPOT_ID,create_user)

                (
               
                select distinct prog_vno,'$request->proposal_no'  pb_no,'PROPOSAL' vtype, depot_id, '$uid'
                from
                (
                select (select distinct substr(voucher_no,1,instr(voucher_no,'-',1,1)-1)||'-'||(select max(to_number(substr(voucher_no,instr(voucher_no,'-',-1,1)+1)))+1
                from mis.ss_program_voucher where voucher_type = 'PROPOSAL') from mis.ss_program_voucher where voucher_type = 'PROPOSAL' 
                and substr('$request->proposal_no',1,4)||substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2) = substr(proposal_bill_no,1,4)||substr(proposal_bill_no,(instr(proposal_bill_no,'-',1,1)-2),2)) prog_vno        
                from dual
                union all
                select (select 'SSPV'||substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2)||'-1' from dual) prog_vno
                from dual
                where not exists (select proposal_bill_no from mis.ss_program_voucher
                where substr('$request->proposal_no',1,4)||substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2) = substr(proposal_bill_no,1,4)||substr(proposal_bill_no,(instr(proposal_bill_no,'-',1,1)-2),2))
                union all
                select (select 'SSPV'||substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2)||'-1' from dual) prog_vno
                from dual
                where not exists (select voucher_no from mis.ss_program_voucher where voucher_type = 'PROPOSAL')
                ),mis.ss_program_app  spa
                where prog_vno is not null
                and spa.prog_no = '$request->proposal_no'
                                )");

                return response()->json(['occurance' => $occurance, 'insert_proposal_voucher' => $insert_proposal_voucher]);

            } else {
                return response()->json(['occurance' => $occurance, 'insert_proposal_voucher' => $insert_proposal_voucher]);
            }

        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }

        return response()->json(['proposal' => $program_no, 'bill' => $result]);

    }

    public function print_proposal_voucher(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

        try {

            $print_check = DB::select("
            select voucher_status,proposal_bill_no from  mis.ss_program_voucher
            where voucher_type =  'PROPOSAL' 
            and proposal_bill_no = '$request->program_no_for_voucher' 
");

//            dd(count($print_check));

            $result = DB::select("

            select prog_no,advance_budget,ssp.depot_id,depot_name,rm_name,rm_terr_id,to_date(sspv.CREATE_DATE,'DD-MON-RR') v_date,'' duplicate,
            voucher_no
            from mis.ss_program_voucher sspv,mis.ss_program_app ssp
            where  proposal_bill_no = prog_no
            and sspv.proposal_bill_no = '$request->program_no_for_voucher' 
            and ss_prog =  'PROPOSAL'
 
                ");

            $print_update = DB::update("
               update  mis.ss_program_voucher
            set voucher_status = 1
            where voucher_type =  'PROPOSAL' 
             and proposal_bill_no = '$request->program_no_for_voucher' 
            ");


            $data = ['rs_data' => $result,'print_check' =>$print_check];
//            dd($data);


            $pdf = \PDF::loadView('scientific/proposal_voucher', $data);
            return $pdf->stream('scientific_seminar_proposal_voucher.pdf');


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


    }

    public function print_proposal_voucher_duplicate(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

        try {

            $print_check = DB::select("
            select voucher_status,proposal_bill_no from  mis.ss_program_voucher
            where voucher_type =  'PROPOSAL' 
            and proposal_bill_no = '$request->program_no_for_voucher_duplicate' 
");

//            dd(count($print_check));

            $result = DB::select("

            select prog_no,advance_budget,ssp.depot_id,depot_name,rm_name,rm_terr_id,to_date(sspv.CREATE_DATE,'DD-MON-RR') v_date,'DUPLICATE COPY' duplicate,
            voucher_no
            from mis.ss_program_voucher sspv,mis.ss_program_app ssp
            where  proposal_bill_no = prog_no
            and sspv.proposal_bill_no = '$request->program_no_for_voucher_duplicate' 
            and ss_prog =  'PROPOSAL'
 
                ");

            $print_update = DB::update("
               update  mis.ss_program_voucher
            set voucher_status = 2
            where voucher_type =  'PROPOSAL' 
             and proposal_bill_no = '$request->program_no_for_voucher_duplicate' 
            ");


            $data = ['rs_data' => $result,'print_check' =>$print_check];
//            dd($data);


            $pdf = \PDF::loadView('scientific/proposal_voucher', $data);
            return $pdf->stream('scientific_seminar_proposal_voucher.pdf');


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


    }

    public function create_bill_voucher(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH12:MI:SS AM'");
        $uid = Auth::user()->user_id;

        try {

            $occurance = '';
            $insert_proposal_voucher = '';

            $occurance = DB::select("
                
                    select count(*) times
                    from mis.ss_program_voucher where proposal_bill_no = '$request->proposal_no'
              
        ");
            if ($occurance[0]->times == 0) {

                $insert_proposal_voucher = DB::insert("
                insert into mis . SS_PROGRAM_VOUCHER
                (VOUCHER_NO, PROPOSAL_BILL_NO, VOUCHER_TYPE,DEPOT_ID,create_user)

                (
        select distinct bill_vno,'$request->proposal_no'  pb_no,'BILL' vtype, DEPOT_ID,'$uid'
        from
        (
        select (select distinct substr(voucher_no,1,instr(voucher_no,'-',1,1)-1)||'-'||(select max(to_number(substr(voucher_no,instr(voucher_no,'-',-1,1)+1)))+1
        from mis.ss_program_voucher where voucher_type = 'BILL') from mis.ss_program_voucher where voucher_type = 'BILL' 
        and substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2) = substr(proposal_bill_no,(instr(proposal_bill_no,'-',1,1)-2),2)) bill_vno        
        from dual
        union all
        
        --Year Wise       
        select (select 'SSBV'||substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2)||'-1' from dual) bill_vno
        from dual
        where not exists (select distinct substr(voucher_no,1,instr(voucher_no,'-',1,1)-1)||'-'||(select max(to_number(substr(voucher_no,instr(voucher_no,'-',-1,1)+1)))+1
        from mis.ss_program_voucher where voucher_type = 'BILL') from mis.ss_program_voucher where voucher_type = 'BILL' 
        and substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2) = substr(proposal_bill_no,(instr(proposal_bill_no,'-',1,1)-2),2))
        
        union all
        
        select (select 'SSBV'||substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2)||'-1' from dual) bill_vno
        from dual
        where not exists (select proposal_bill_no from mis.ss_program_voucher
        where substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2) = substr(proposal_bill_no,(instr(proposal_bill_no,'-',1,1)-2),2))
        union all
        select (select 'SSBV'||substr('$request->proposal_no',(instr('$request->proposal_no','-',1,1)-2),2)||'-1' from dual) bill_vno
        from dual
        where not exists (select voucher_no from mis.ss_program_voucher where voucher_type = 'BILL')
        ),mis.ss_program_app  spa
        where bill_vno is not null
        and spa.bill_no = '$request->proposal_no'
                )
   ");

                return response()->json(['occurance' => $occurance, 'insert_proposal_voucher' => $insert_proposal_voucher]);

            } else {
                return response()->json(['occurance' => $occurance, 'insert_proposal_voucher' => $insert_proposal_voucher]);
            }

        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }


    }

    public function print_bill_voucher(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

        try {

            $print_check = DB::select("
            select voucher_status,proposal_bill_no from  mis.ss_program_voucher
            where voucher_type =  'BILL' 
            and proposal_bill_no = '$request->bill_no_for_voucher' 
");

//            dd(count($print_check));

            $result = DB::select("

                select prog_no,bill_no,actual_expenditure,advance_budget,payable_refundable,ssp.depot_id,depot_name,
                rm_name,rm_terr_id,to_date(sspv.CREATE_DATE,'DD-MON-RR') v_date,'' duplicate,
                voucher_no
                from mis.ss_program_voucher sspv,mis.ss_program_app ssp
                where  proposal_bill_no = bill_no
                and sspv.proposal_bill_no = '$request->bill_no_for_voucher' 
                and ss_prog = 'BILL'
 
                ");

            $cost_center = DB::select("

                    select prog_no,bill_no,gl,cost_center_id,cc_team_name,pro_amt,bill_amt
                    from mis.ss_budget_details_app
                    where 
                    bill_no = '$request->bill_no_for_voucher' 
 
                ");

            $print_update = DB::update("
               update  mis.ss_program_voucher
            set voucher_status = 1
            where voucher_type =  'BILL'
             and proposal_bill_no = '$request->bill_no_for_voucher'
            ");


            $data = ['rs_data' => $result,'cc' => $cost_center, 'print_check' =>$print_check];
//            dd($data);


            $pdf = \PDF::loadView('scientific/bill_voucher', $data);
            return $pdf->stream('scientific_seminar_bill_voucher.pdf');


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


    }

    public function print_bill_voucher_duplicate(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

        try {

            $print_check = DB::select("
            select voucher_status,proposal_bill_no from  mis.ss_program_voucher
            where voucher_type =  'BILL' 
            and proposal_bill_no = '$request->bill_no_for_voucher_duplicate' 
");

//            dd(count($print_check));

            $result = DB::select("

                select prog_no,bill_no,actual_expenditure,advance_budget,payable_refundable,
                ssp.depot_id,depot_name,rm_name,rm_terr_id,to_date(sspv.CREATE_DATE,'DD-MON-RR') v_date,'DUPLICATE COPY' duplicate,
                voucher_no
                from mis.ss_program_voucher sspv,mis.ss_program_app ssp
                where  proposal_bill_no = bill_no
                and sspv.proposal_bill_no = '$request->bill_no_for_voucher_duplicate' 
                and ss_prog = 'BILL'
 
                ");

            $cost_center = DB::select("

                    select prog_no,bill_no,gl,cost_center_id,cc_team_name,pro_amt,bill_amt
                    from mis.ss_budget_details_app
                    where 
                    bill_no = '$request->bill_no_for_voucher_duplicate' 
 
                ");

            $print_update = DB::update("
               update  mis.ss_program_voucher
            set voucher_status = 2
            where voucher_type =  'BILL'
             and proposal_bill_no = '$request->bill_no_for_voucher_duplicate'
            ");


            $data = ['rs_data' => $result, 'cc' => $cost_center,'print_check' =>$print_check];
//            dd($data);


            $pdf = \PDF::loadView('scientific/bill_voucher', $data);
            return $pdf->stream('scientific_seminar_bill_voucher.pdf');


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


    }


}