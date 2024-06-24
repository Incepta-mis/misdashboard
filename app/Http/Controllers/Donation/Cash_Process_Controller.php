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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use App\Currency_To_Word;


class Cash_Process_Controller extends Controller{

    public function cash_process_view(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

            $month_name = DB::select("
                                        select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                        from
                                        (
                                        with data as (select level l from dual connect by level <= 3)
                                        select *
                                        from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                        order by dt, l)
                                                                         ");

            return view('donation.cash_process')->with(['month' => $month_name]);

    }

    public function fi_doc_list(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::Select("

                            select distinct fi_doc_no,summ_id
                            from
                            (
                            select fi_doc_no,drc.req_id,summ_id
                            from mis.donation_req_correction drc,mis.donation_expense_budget deb
                            where drc.req_id = deb.req_id
                            and payment_month = '$request->month'
                            and payment_mode = 'CASH'
                            and ref_no is not null
                            minus
                            select deb.fi_doc_no,deb.req_id,deb.summ_id
                            from mis.donation_cash_process_fi dcp,mis.donation_expense_budget deb
                            where dcp.payment_month = '$request->month'
                            and dcp.req_id = deb.req_id
                            ) 
                            order by summ_id,fi_doc_no
                                                                                        
                                    ");



            return response()->json($resp_data);
        }
    }

    public function depot_list(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");


        $emp_status = DB::select("
                    select  emp_status
                    from mis.donation_cash_approve_emp
                    where emp_id = '$uid'
                    union 
                    select
                   'zz' emp_status 
                   from dual
                   order by emp_status 
                            ");

        if ($emp_status[0]->emp_status == 'PREPARED') {

            $resp_data = DB::Select("

                        select distinct d_id,depot_name
                        from
                        (select 'ALL' all_data,drc.d_id,drc.d_name depot_name, drc.req_id,fi_doc_no
                        from mis.donation_req_correction drc,mis.donation_expense_budget deb
                        where drc.req_id = deb.req_id
                        and payment_mode = 'CASH'
                        and ref_no is not null
                        minus
                        select 'ALL' all_data,drc.d_id,drc.d_name depot_name,deb.req_id,fi_doc_no
                        from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_cash_process_fi dcp
                        where 
                        drc.req_id = deb.req_id
                        and drc.req_id = dcp.req_id
                        )where '$request->fi_doc' = case when '$request->fi_doc'  = 'ALL' then all_data else fi_doc_no end 
                        order by d_id");


            return response()->json($resp_data);
        }

        else if ($emp_status[0]->emp_status == 'VERIFIED') {
            $resp_data = DB::Select("

                        select distinct d_id,depot_name
                        from
                        (
                        select 'ALL' all_data,drc.d_id,drc.d_name depot_name,deb.req_id,fi_doc_no
                        from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_cash_process_fi dcp
                        where 
                        drc.req_id = deb.req_id
                        and drc.req_id = dcp.req_id
                        and prepared_date is not null
                        and verified_date is null
                        )where '$request->fi_doc' = case when '$request->fi_doc'  = 'ALL' then all_data else fi_doc_no end 
                        order by d_id
                                                        
                                    ");

            return response()->json($resp_data);


        }

        else if ($emp_status[0]->emp_status == 'APPROVED') {
            $resp_data = DB::Select("

                        select distinct d_id,depot_name
                        from
                        (
                        select 'ALL' all_data,drc.d_id,drc.d_name depot_name,deb.req_id,fi_doc_no
                        from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_cash_process_fi dcp
                        where 
                        drc.req_id = deb.req_id
                        and drc.req_id = dcp.req_id
                        and verified_date is not null
                        and approved_date is null
                        )where '$request->fi_doc' = case when '$request->fi_doc'  = 'ALL' then all_data else fi_doc_no end 
                        order by d_id
                                                        
                                    ");

            return response()->json($resp_data);


        }
    }

    public function cash_summary_detail_data(Request $request)
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $uid = Auth::user()->user_id;

            DB::DELETE("   delete from mis.donation_fi_cash ");

            DB::INSERT("
                    insert into mis.donation_fi_cash
                    select ded.req_id
                    from
                    (select 'ALL' all_data,payment_month,gl,cost_center_id cc,drc.d_id,d_name,fi_doc_no,drc.req_id,approved_amount
                    from mis.donation_req_correction drc,mis.donation_expense_budget deb
                    where drc.req_id = deb.req_id
                    and payment_month = '$request->month'
                    and payment_mode = 'CASH') ded,(select drc.req_id
                    from mis.donation_req_correction drc,mis.donation_expense_budget deb
                    where drc.req_id = deb.req_id
                    and payment_month = '$request->month'
                    and payment_mode = 'CASH'
                    and ref_no is not null
                    minus
                    select req_id
                    from mis.donation_cash_process_fi
                    where payment_month = '$request->month') dcp    
                    where ded.req_id = dcp.req_id
                    and '$request->fi_doc' = case when '$request->fi_doc' = 'ALL' then all_data else fi_doc_no end
                    and '$request->depot' = case when '$request->depot' = 'ALL' then all_data else to_char(d_id) end
            ");

            $resp_data = DB::select("

                           select payment_month,summ_id,ref_no,fi_doc_no,drc.req_id,doctor_name,in_favour_of,frequency,approved_amount donation_amount,
                            purpose, case when donation_type in ('DPGPE','RESEARCH EXPENSE') then  gm_sales_emp_name else gm_msd_emp_name end budget_owner,
                            d_name depot,terr_id,am_name,rm_name rm_asm
                            from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_fi_cash dfic
                            where drc.req_id = deb.req_id
                            and drc.req_id = dfic.req_id 

                "
            );

            $dis_sum = DB::select("select ref_no,payment_month,gl,cc,d_id,d_name,substr(terr_id,1,instr(terr_id,'-'))||'00' terr_id,count(*) tnor,sum(nvl(approved_amount,0)) total_value
                                    from
                                    (
                                    select  payment_month,gl,cost_center_id cc,drc.d_id,terr_id,d_name,fi_doc_no,drc.req_id,approved_amount,deb.ref_no
                                    from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_fi_cash dfic
                                    where drc.req_id = deb.req_id
                                    and drc.req_id = dfic.req_id 
                                        and deb.C_MAIL is null and deb.MAIL_SENDER ='$uid'
                                    )group by ref_no, payment_month,gl,cc,d_name,d_id,substr(terr_id,1,instr(terr_id,'-'))||'00' 
                                            ");

            return response()->json(['resp_data' => $resp_data, 'dis_sum' => $dis_sum]);


    }

    public function cash_insert_data(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        $emp_status = DB::select("
                    select  emp_status
                    from mis.donation_cash_approve_emp
                    where emp_id = '$uid'
                    union 
                    select
                   'zz' emp_status 
                   from dual
                   order by emp_status 
                            ");

        $verinfo = json_decode($request->insertdata);


        if ($emp_status[0]->emp_status == 'PREPARED') {

            foreach ($verinfo as $data) {

                $insert=  DB::insert("

    INSERT INTO MIS.DONATION_CASH_PROCESS_FI (PAYMENT_MONTH,REQ_ID,PREPARED_BY,PREPARED_DATE)
    VALUES   (?,?,?,?)
    ", [$data->month,$data->request_id,$uid,$systime[0]->sysdate]);

            }

            if($insert) {
                return response()->json(['success' => 'Processed Successfully']);
            }
            else{
                return response()->json(['error' => 'Failed to process']);
            }
        }


        else if ($emp_status[0]->emp_status == 'VERIFIED') {

            foreach ($verinfo as $data) {

                $insert=  DB::UPDATE("
                        update mis.donation_cash_process_fi
                        set verified_by='$uid',
                        verified_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->request_id]);
            }
            if($insert) {
                return response()->json(['success' => 'Verified Successfully']);
            }
            else{
                return response()->json(['error' => 'Failed']);
            }
        }

        else if ($emp_status[0]->emp_status == 'APPROVED') {


            foreach ($verinfo as $data) {

                $insert=  DB::UPDATE("
                        update mis.donation_cash_process_fi
                        set approved_by='$uid',
                        approved_date = (select sysdate from dual)
                        where req_id=?
                    ", [$data->request_id]);
            }

            if($insert) {
                return response()->json(['success' => 'Approved Successfully']);
            }
            else{
                return response()->json(['error' => 'Failed']);
            }
        }


    }

    public function cash_process_rm_view(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM' ||  Auth::user()->desig === 'HO'){


            $month_name = DB::select("
                                        select distinct payment_month monthname
                                        from mis.donation_cash_process_fi
                                        where rm_process_date is null
                                        and approved_date is not null
                                                                         ");


            return view('donation.cash_process_rm')->with(['month' => $month_name]);

        }

    }

    public function depot_list_rm(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("

                        select distinct d_id,d_name
                        from mis.donation_cash_process_fi dcp,mis.donation_req_correction drc
                        where drc.payment_month = '$request->month'
                        and dcp.req_id = drc.req_id
                        and rm_process_date is null
                        and approved_date is not null
                        and drc.rm_emp_id = '$uid'
                                                        
                                    ");

        $assigned = DB::select("
                                    select distinct am_emp_id||' '||am_name am,am_terr_id,am_name
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_char(emp_month,'MON-RR') = '$request->month'
                                    and case when rm_emp_id is null then asm_emp_id else rm_emp_id end = '$uid'
                                    and am_name is not null
                                    order by am_terr_id
                                                         
                                                                         ");


        return response()->json(['depot' => $resp_data,'assigned' => $assigned]);

    }

    public function cash_process_rm_data(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");

        $resp_data = DB::select("

                    select payment_month,req_id,terr_id,depot,doctor_id,doctor_name,in_favour_of,frequency,amount,purpose, '$request->assigned' assigned 
                    from(
                    select 'ALL' all_data,drc.payment_month,drc.req_id,terr_id,d_id,d_name depot,doctor_id,doctor_name,in_favour_of,frequency,approved_amount amount,purpose 
                    from mis.donation_cash_process_fi dcp,mis.donation_req_correction drc
                    where drc.payment_month = '$request->month' 
                    and dcp.req_id = drc.req_id
                    and rm_process_date is null
                    and approved_date is not null
                    and drc.rm_emp_id = '$uid'
                    and substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->am_terr'
                    )where '$request->depot' = case when '$request->depot' = 'ALL' then all_data else to_char(d_id) end

                "
        );

        return response()->json(['resp_data' => $resp_data]);

    }

    public function cash_process_rm_update(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        $verinfo = json_decode($request->insertdata);

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            foreach ($verinfo as $data) {

                $insert=  DB::UPDATE("
                        update mis.donation_cash_process_fi
                        set rm_emp_id='$uid',
                        rm_assigned_person = ?,
                        rm_process_date = (select sysdate from dual)
                        where req_id=?
                    ", [$data->assigned,$data->request_id]);
            }

            if($insert) {
                return response()->json(['success' => ' Successfull']);
            }
            else{
                return response()->json(['error' => 'Failed']);
            }
        }


    }

    public function cash_process_depot_view(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $depot = DB::select("
                        select  depot_id,depot_name from mis.ss_depot_emp
                        where depot_emp_id = '$uid'
                            ");


        $month_name = DB::select("
                                        select distinct payment_month monthname
                                        from mis.donation_cash_process_fi
                                        where rm_process_date is not null
                                        and depot_process_date is null
                                                                         ");

        $month_name_seocnd = DB::select("
                                        select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                        from
                                        (
                                        with data as (select level l from dual connect by level <= 3)
                                        select *
                                        from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                        order by dt, l)
                                                                         ");

        return view('donation.cash_process_depot')->with(['month' => $month_name, 'depot' =>$depot, 'month_second' => $month_name_seocnd,]);


    }

    public function rm_list(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("

                        select distinct substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                        from mis.donation_cash_process_fi dcp,mis.donation_req_correction drc
                        where drc.payment_month = '$request->month'
                        and drc.d_id = '$request->depot'
                        and dcp.req_id = drc.req_id
                        and rm_process_date is not null
                        and depot_process_date is null
                                                        
                                    ");


        return response()->json($resp_data);

    }

    public function cash_process_depot_data(Request $request)
    {
//        Log::info($request->all());
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $uid = Auth::user()->user_id;

//            return response()->json($request->all());


        $resp_data = DB::select("
                        
                                select drc.payment_month,summ_id,ref_no,fi_doc_no,drc.req_id,doctor_name,in_favour_of,frequency,approved_amount donation_amount,
                                purpose,drc.d_id,
                                d_name depot,terr_id,am_name,rm_name rm_asm, rm_assigned_person
                                from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_cash_process_fi dcp
                                where rm_process_date is not null
                                and depot_process_date is null 
                                and drc.payment_month = '$request->month'
                                and drc.d_id = '$request->depot'
                                and drc.req_id = dcp.req_id
                                and drc.req_id = deb.req_id
                                and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rm_terr'
                                order by terr_id
                                             
                "
        );

        $dis_sum = DB::select("
                            
                            select drc.payment_month,d_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,count(*) total_req,sum(nvl(approved_amount,0)) total_amount 
                            from mis.donation_cash_process_fi dcp,mis.donation_req_correction drc
                            where rm_process_date is not null
                            and depot_process_date is null 
                            and drc.payment_month = '$request->month'
                            and drc.d_id = '$request->depot'
                            and drc.req_id = dcp.req_id
                            and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rm_terr'
                            group by drc.payment_month,d_name,substr(terr_id,1,instr(terr_id,'-'))||'00'
                                            ");
        return response()->json(['resp_data' => $resp_data, 'dis_sum' => $dis_sum]);

    }

    public function cash_process_depot_update(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        $verinfo = json_decode($request->insertdata);

//        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

        foreach ($verinfo as $data) {

            $insert=  DB::UPDATE("
                        update mis.donation_cash_process_fi
                        set depot_emp_id='$uid',
                        depot_process_date = (select sysdate from dual)
                        where req_id=?
                    ", [$data->request_id]);
        }

        if($insert) {
            return response()->json(['success' => ' Successfull']);
        }
        else{
            return response()->json(['error' => 'Failed']);
        }
//        }


    }

    public function print_depot_report(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        try {

            $result = DB::select("
                  
                     select row_number () over (partition by dd.am_terr_id order by  substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
         to_number(substr(terr_id,instr(terr_id,'-', -1)+1))) sl,
                     payment_month,summ_id,ref_no,fi_doc_no,req_id,doctor_name,in_favour_of,frequency, donation_amount,
            purpose,d_id, budget_owner, depot,terr_id,am_name,rm_asm, rm_assigned_person,
            prepared_by, verified_by,approved_by,total_amount,dd.am_terr_id,
            (select name 
            from MIS.DASHBOARD_USERS_INFO
            where USER_ID = prepared_by ) prepared_name,
            (select name 
            from MIS.DASHBOARD_USERS_INFO
            where USER_ID = verified_by ) verified_name,   
            (select name  
            from MIS.DASHBOARD_USERS_INFO
            where USER_ID = approved_by ) approved_name,
            company_name,
            (select DEPOT_EMP_NAME 
            from MIS.SS_DEPOT_EMP
            where DEPOT_ID = '$request->depot' and INCHARGE = 'Y') depot_incharge
            from   

            (select drc.payment_month,summ_id,ref_no,fi_doc_no,drc.req_id,doctor_name,in_favour_of,frequency,approved_amount donation_amount,
            purpose,drc.d_id,case when donation_type in ('DPGPE','RESEARCH EXPENSE') then  gm_sales_emp_name else gm_msd_emp_name end budget_owner,
            d_name depot,terr_id,am_name,rm_name rm_asm, rm_assigned_person,
            prepared_by, verified_by,approved_by,company_name,
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id
            from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_cash_process_fi dcp, mis.donation_cost_center dcc
            where rm_process_date is not null
            and depot_process_date is not null 
            and drc.payment_month = '$request->bgt_month'
            and drc.d_id = '$request->depot'
            and drc.req_id = dcp.req_id
            and drc.req_id = deb.req_id
            and drc.gl = dcc.gl
            and drc.cost_center_id = dcc.cost_center_id
            and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rm'            
            ) dd,
            (select  substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
            sum(nvl(approved_amount,0)) total_amount 
                      
            from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_cash_process_fi dcp
            where rm_process_date is not null
            and depot_process_date is not null 
            and drc.payment_month = '$request->bgt_month'
            and drc.d_id = '$request->depot'
            and drc.req_id = dcp.req_id
            and drc.req_id = deb.req_id
            and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rm'
            group by substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) 
            )dsd
            where dd.am_terr_id = dsd.am_terr_id 
                                         
                ");

            $am_territory = DB::select("
               select  substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                       sum(nvl(approved_amount,0)) total_amount 
          
            from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_cash_process_fi dcp
            where rm_process_date is not null
            and depot_process_date is not null 
            and drc.payment_month = '$request->bgt_month'
            and drc.d_id = '$request->depot'
            and drc.req_id = dcp.req_id
            and drc.req_id = deb.req_id
            and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rm'
            group by substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1)
            order by am_terr_id
                                
            ");
            $data = ['rs_data' => $result, 'am_territory' => $am_territory];
            $pdf = \PDF::loadView('donation/depot_cash_report', $data)->setPaper('a4','landscape');

            return $pdf->setPaper('a4','landscape')->stream('depot_cash_report.pdf');

        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }

    }

    public function send_email(Request $request){

        //$date = Carbon::now()->format('Y-m-d H:m:s');
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("select sysdate from dual");
        $time_stamp = $systime[0]->sysdate;

        Log::info("system adte=");
        Log::info($systime);


        /*get DATE*/
        $date = date('Y-m-d');
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $year = substr($year, 2);
        $month_name =date("F", strtotime($date));
        $month_name = strtoupper($month_name);
        $current_date =  $day.'-'.$month_name.'-'.$year;


        /* Depot Info starts*/
        $depot_id = $request->d_id;
        $total_value = $request->total_value;
        $terr_id = $request->terr_id;
        $ref_no = $request->ref_no;
        $total_val_in_words =$this->numToWords($total_value);
        $currency = new \App\Currency_To_Word();
        $total_val_in_words = $currency->get_bd_amount_in_text($total_value);
        $total_val_in_money = $currency->get_bd_money_format($total_value);

        $depot_info =   DB::select("select DEPOT_MAIL,DEPOT_NAME,AUTHORISED_PERSON,AUTH_DESIG,SENDER_NAME,SENDER_DESIG,SENDER_EMAIL,SENDER_MOB from MIS.DONATION_CASH_EMAIL_MASTER where DEPOT_ID = '$depot_id'  AND RM_TERR='$terr_id' ");

        $mail_response=array();
        $mail_response['depot_id']=$depot_id;
        $mail_response['terr_id']=$terr_id;

        if(!$depot_info){
            return response()->json("null");
        }

        $in_charge_mail = $depot_info['0']->depot_mail;
        $depot_name = $depot_info['0']->depot_name;
        $authorised_person = $depot_info['0']->authorised_person;
        $auth_desig = $depot_info['0']->auth_desig;


        $sender_name = $depot_info['0']->sender_name;
        $sender_desig = $depot_info['0']->sender_desig;
        $sender_email = $depot_info['0']->sender_email;
        $sender_mob = $depot_info['0']->sender_mob;
        /*depot info ends*/

        /*mail senders info starts*/
        $mail_sender_id =  Auth::user()->user_id;

        $mail_sender_info =  DB::select(" select EMP_NAME,MAIL_ADDRESS,EMP_STATUS,DESIG,DEPARTMENT,EXTENSION,MOBILE  from MIS.DONATION_CASH_APPROVE_EMP  
            where emp_id='$mail_sender_id' ");
        Log::info("mail senderes info=");
        Log::info($mail_sender_info);


        if(!$mail_sender_info){
           return response()->json('null');
        }

        $mail_sender_name =  $mail_sender_info[0]->emp_name;
        $mail_sender_email =  $mail_sender_info[0]->mail_address;
        $mail_sender_desig =  $mail_sender_info[0]->desig;
        $mail_sender_dept =  $mail_sender_info[0]->department;
        $mail_sender_ext =  $mail_sender_info[0]->extension;
        $mail_sender_mob =  $mail_sender_info[0]->mobile;

        $user_email = array();
        $user_email[]=$mail_sender_email;

         /*Mail Format
        To: [Depot-In-Charge]
        CC: naimul@inceptapharma.com; mahmed@inceptapharma.com; shafiul@inceptapharma.com;
        kaziainal@inceptapharma.com ; asad@inceptapharma.com; alamgir@inceptapharma.com;
        msarowar@inceptapharma.com; tabassumneela@inceptapharma.com;
        skabir@inceptapharma.com; a.islam@inceptapharma.com; tkislam@inceptapharma.com;
        mollick@inceptapharma.com; subhan@inceptapharma.com; [Sender Mail ID]; [RM Mail ID]
                */
        $cc_mail = array();
        $cc_mail[]=  'tasnimhema@inceptapharma.com';
       /* $cc_mail[]=  'naimul@inceptapharma.com';
        $cc_mail[]=  'shafiul@inceptapharma.com';
        $cc_mail[]=  'kaziainal@inceptapharma.com';
        $cc_mail[]=  'asad@inceptapharma.com';
        $cc_mail[]=  'alamgir@inceptapharma.com';
        $cc_mail[]=  'msarowar@inceptapharma.com';
        $cc_mail[]=  'tabassumneela@inceptapharma.com';
        $cc_mail[]=  'skabir@inceptapharma.com';
        $cc_mail[]=  'a.islam@inceptapharma.com';
        $cc_mail[]=  'tkislam@inceptapharma.com';
        $cc_mail[]=  'mollick@inceptapharma.com';
        $cc_mail[]=  'subhan@inceptapharma.com';
        $cc_mail[]=  $sender_email;
        $cc_mail[]=  $in_charge_mail;*/

        try {
            $to_mail= array();
            $to_mail[]=  'sahadat@inceptapharma.com';
            $to_mail[]=  'sayla@inceptapharma.com';

            $data = array(
                'mail_sender_name' => $mail_sender_id,
                'mail_sender_name' => $mail_sender_name,
                'mail_sender_desig' => $mail_sender_desig,
                'mail_sender_dept' => $mail_sender_dept,
                'mail_sender_ext' => $mail_sender_ext,
                'mail_sender_mob' => $mail_sender_mob,

                'sender_name' => $sender_name,
                'sender_desig' => $sender_desig,
                'sender_email' => $sender_email,

                'in_charge_mail' => $in_charge_mail,
                'depot_name' => $depot_name,
                'authorised_person' => $authorised_person,
                'auth_desig' => $auth_desig,
                'total_val_in_money' => $total_val_in_money,
                'total_val_in_words' => $total_val_in_words,
                'ref_no' => $ref_no,
                'current_date' => $current_date,

            );

            $req_id =   DB::select("
            select deb.req_id,payment_month,gl,cost_center_id cc,drc.d_id,terr_id,d_name,fi_doc_no,drc.req_id,approved_amount
                                    from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_fi_cash dfic
                                    where drc.req_id = deb.req_id
            and drc.req_id = dfic.req_id
            and deb.C_MAIL is null
            and substr(drc.terr_id,1,instr(drc.terr_id,'-'))||'00' = '$terr_id' and drc.d_id =$depot_id");

            if (!empty($req_id)) {

                $req_id_ar =array();
                for ($i=0;$i<sizeof($req_id);$i++){
                    $req_id_ar[] = $req_id[$i]->req_id;
                }
            }else{

                return response()->json("error");
            }

            $subject = 'Disbursement Advice BDT'.$total_value;
            $mail_send = Mail::send(['text' => 'donation/cash_process_mail'], $data,  function ($message) use($subject,$to_mail,$user_email,$cc_mail) {
                $message->cc($cc_mail)->to($to_mail)->subject($subject);
                $message->from($user_email);

            });

            $result =  DB::UPDATE("
                        UPDATE MIS.donation_expense_budget 
                        SET C_MAIL = 1 , MAIL_TIME =  '$time_stamp'  WHERE req_id IN('".implode("','",$req_id_ar)."')");

            return response()->json("success");

        }

        //catch exception
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

    }

    public function numToWords($num) {
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }

    public function cash_process_mail_report() {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $month_name = DB::select("
                                        select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                        from
                                        (
                                        with data as (select level l from dual connect by level <= 3)
                                        select *
                                        from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                        order by dt, l)
                                                                         ");

        return view('donation.cash_process_mail_send_report')->with(['month' => $month_name]);
    }

    public function cash_process_mail_display_data(){

        $uid = Auth::user()->user_id;

        $resp_data = DB::select("
select ref_no,ben_name,BEN_DESIG,BEN_EMAIL,d_name,sum(nvl(approved_amount,0)) total_value,AUTHORISED_PERSON,AUTH_DESIG,MAIL_SENDER issued_by,MAIL_TIME,SUMM_ID,cc_code,cc_owner,FI_PERSON from(                               
        select  deb.ref_no,ben_name,BEN_DESIG,BEN_EMAIL,d_name,AUTHORISED_PERSON,AUTH_DESIG,MAIL_SENDER,MAIL_TIME,deb.SUMM_ID,drc.gl,drc.cost_center_id cc_code,dcc.RESPONSIBLE_EMP_NAME cc_owner,drc.d_id,terr_id,fi_doc_no,drc.req_id,
        approved_amount,drc.payment_month,ddi.FI_PERSON from mis.donation_req_correction drc,mis.donation_expense_budget deb,mis.donation_fi_cash dfic,mis.DONATION_CASH_EMAIL_MASTER dcem,MIS.DONATION_COST_CENTER dcc, MIS.DONATION_DEPOT_INFO ddi
                                    
                                    where drc.req_id = deb.req_id
                                    and drc.cost_center_id = dcc.cost_center_id
                                    and drc.req_id = dfic.req_id and deb.D_ID=ddi.DEPOT_ID and deb.C_MAIL ='1' and deb.MAIL_SENDER ='$uid'
                                    and substr(drc.terr_id,1,instr(drc.terr_id,'-'))||'00'= dcem.RM_TERR and drc.d_id =dcem.DEPOT_ID
                                    
                                    )group by ref_no,ben_name,BEN_DESIG,BEN_EMAIL, payment_month,gl,cc_code,d_name,d_id,substr(terr_id,1,instr(terr_id,'-'))||'00',AUTHORISED_PERSON,AUTH_DESIG,MAIL_SENDER,MAIL_TIME,SUMM_ID,cc_owner,FI_PERSON");

        return response()->json(['resp_data' => $resp_data]);

    }

}