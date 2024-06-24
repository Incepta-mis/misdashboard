<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 4/13/2019
 * Time: 11:13 AM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Mail;

//Request $request

class Cash_Advice_Controller extends Controller
{
    public function index()
    {


        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $sumid = DB::select("
                                    select distinct summ_id,fi_doc_no
                                    from mis.donation_expense_budget
                                    where fi_process is null
                                     ");


            $emp_info = DB::select("
                       select emp_id user_id,emp_name name from MIS.DONATION_CASH_APPROVE_EMP
            where emp_id in ( 1004184, 	1007284)
            order by emp_id 
                                        ");


            $depot_info = DB::select("
                                    select  depot_id, depot_name,email from mis.donation_depot_info
                                     ");

            $refno = DB::select("                               
                                  select distinct summ_id,ref_no
                                    from mis.donation_expense_budget
                                    where ref_no is not null
                                    and bank_account_no is null
                                    and create_date >=  sysdate - 380 
                                     order by summ_id DESC,ref_no 

                                     ");


//            return view('donation.cash_advice');
            return view('donation.cash_advice')->with(['sumid' => $sumid,'employee' =>$emp_info, 'depot' => $depot_info,'refno'=>$refno]);

        }


    }

    public function depot_detail(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {
            $sumd = DB::select("
                           
                        select *
                        from(
                        select 'ALL' all_depot,depot_id,depot_name,
                        substr(terr_id,1,instr(terr_id,'-'))||'00' terr,
                        count(*) no_of_req,sum(nvl(approved_amount,0)) appro_amount
                        from
                        (select drc.req_id,drc.d_id,terr_id,approved_amount,to_date(payment_month,'MON-RR') pay_month
                        from mis.donation_expense_budget deb,mis.donation_req_correction drc
                        where deb.req_id = drc.req_id
                        and payment_mode = 'CASH'
                        and fi_process is null
                       and fi_doc_no = '$request->fidocno') pm,
                                                        (select d_id depot_id,name depot_name from msfa.depot@web_to_imsfa) di
                        where pm.d_id = di.depot_id
                        group by depot_id,depot_name, substr(terr_id,1,instr(terr_id,'-'))||'00' 
                        order by depot_id
                        )
                        where '$request->dpo' = case when '$request->dpo' = 'ALL' then all_depot else to_char(depot_id) end
            ");

            return response()->json($sumd);
        }
    }

    public function det_process(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            try {

                DB::delete("delete from mis.donation_process_cash");

                DB::insert("
                insert into mis.donation_process_cash
                                select req_id
                                from
                    (select drc.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount,to_date(payment_month,'MON-RR')  pay_month
                    from mis.donation_expense_budget deb,mis.donation_req_correction drc
                    where deb.req_id = drc.req_id
                    and payment_mode = 'CASH'
                    and fi_process is null
                    and fi_doc_no = '$request->fidocno'
                     and drc.d_id = '$request->dpid' 
                    and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->terr') 
                ");

                $result = DB::select("
                           
                        select d_id,req_id,terr_id,doctor_name,in_favour_of,approved_amount
                        from
                        (select drc.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount,to_date(payment_month,'MON-RR')  pay_month
                        from mis.donation_process_cash dpc,mis.donation_req_correction drc
                        where dpc.req_id = drc.req_id) pm,
                                                        (select d_id depot_id,name depot_name from msfa.depot@web_to_imsfa) di
                        where pm.d_id = di.depot_id 
            ");

//                $result = DB::executeProcedure('mis.pro_donation_Cheque_Process',['fi_doc_no'=>$request->docno,'ban'=>$request->acno]);

            } catch (Oci8Exception $e) {
                $result = $e->getMessage();
            }
            return response()->json($result);


        }
    }

    public function save_proc(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            try {

                $result = DB::executeProcedure('mis.pro_donation_cash_process_n', ['fi_doc_no' => $request->fidoc, 
                'did' => $request->depoid, 'terr' => $request->terr, 'dn' => $request->dpn, 'mail_user' => $request->mail_user ]);

            } catch (Oci8Exception $e) {
                $result = $e->getMessage();
            }
            return response()->json($result);


        }
    }

    public function print_summary(Request $request)
        {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        try {

            $result = DB::select("
                  
            select rownum sl,cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,
            depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount 
            from(                
            select to_char(sysdate, 'DD-MON-YY hh12:mi:ss AM') cd,rs_exp_month,summ_id,fi_doc_no,ref_no,sl,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,
            depot_id,depot_name,dr.terr_id,am_name,rm_name,gl,total_amount
            from 
            (select sum(nvl(approved_amount,0)) total_amount
            from mis.donation_process_cash dpc,mis.donation_req_correction dc
            where dpc.req_id = dc.req_id) total,(select to_char(to_date(payment_month,'MON-RR'),'Mon-RRRR') rs_exp_month,sl,summ_id,fi_doc_no,ref_no,deb.req_id,terr_id,
            doctor_name,in_favour_of,approved_amount amount,purpose,responsible_emp_name budget_owner,am_name,rm_name,dcc.gl
            from mis.donation_process_cash dpc,mis.donation_expense_budget deb,mis.donation_req_correction drc,mis.donation_cost_center dcc
            where dpc.req_id = deb.req_id 
            and deb.req_id = drc.req_id
            and budget_type = 'DONATION'
            and drc.gl = dcc.gl
            and drc.cost_center_id = dcc.cost_center_id) dr,
            (select distinct terr_id,depot_id,depot_name
            from
            (select distinct terr_id, to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR') pay_month,d_id
            from mis.donation_process_cash deb,mis.donation_req_correction drc
            where deb.req_id = drc.req_id
            )pm,(select d_id depot_id,name depot_name from msfa.depot@web_to_imsfa) di
            where pm.d_id = di.depot_id) ti
            where dr.terr_id = ti.terr_id
            order by substr(terr_id,1,instr(terr_id,'-'))||'00',trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
            to_number(substr(terr_id,instr(terr_id,'-', -1)+1)),req_id                
            )
                ");

            $general = DB::select("
                                            
                select rownum sl,cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,
                depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount,frequency,responsible_emp_id,
                cost_center_id,company_code,company_name,ct
                from( 
                select cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,
                depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount ,frequency,responsible_emp_id,
                cost_center_id,company_code,company_name,ct
                from               
                (select pay_month,to_char(sysdate, 'DD-MON-YY hh12:mi:ss AM') cd,rs_exp_month,summ_id,fi_doc_no,ref_no,sl,req_id,doctor_name,
                in_favour_of,amount,purpose,budget_owner,d_id,terr_id,am_name,rm_name,gl,total_amount,frequency,responsible_emp_id,
                cost_center_id,company_code,company_name,ct
                from
                (select sum(nvl(approved_amount,0)) total_amount, count(*) ct
                from mis.donation_process_cash dpc,mis.donation_req_correction dc
                where dpc.req_id = dc.req_id
                and length(terr_id) <> 5),
                (select to_char(to_date(payment_month,'MON-RR'),'Mon-RRRR') rs_exp_month,sl,summ_id,fi_doc_no,ref_no,responsible_emp_id,
                deb.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount amount,purpose,frequency,
                responsible_emp_name budget_owner,am_name,rm_name,dcc.gl,to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR') pay_month,
                drc.cost_center_id,company_code,company_name
                from mis.donation_process_cash dpc,mis.donation_expense_budget deb,mis.donation_req_correction drc,mis.donation_cost_center dcc
                where dpc.req_id = deb.req_id and deb.req_id = drc.req_id
                and budget_type = 'DONATION'
                and drc.gl = dcc.gl
                and drc.cost_center_id = dcc.cost_center_id
                and length(terr_id) <> 5  and  terr_id not like ('MABS%')  )) dr,(select d_id depot_id,name depot_name from msfa.depot@web_to_imsfa) di
                where dr.d_id = di.depot_id
                order by substr(terr_id,1,instr(terr_id,'-'))||'00',trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
                to_number(substr(terr_id,instr(terr_id,'-', -1)+1)),req_id)

                ");

            $special = DB::select("
                  
             select rownum sl,cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,
            depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount,frequency,responsible_emp_id,
            cost_center_id,company_code,company_name,ct
            from(
            select cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,
            depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount,frequency,responsible_emp_id,
            cost_center_id,company_code,company_name,ct
            from               
            (select pay_month,to_char(sysdate, 'DD-MON-YY hh12:mi:ss AM') cd,rs_exp_month,summ_id,fi_doc_no,ref_no,sl,req_id,doctor_name,
            in_favour_of,amount,purpose,budget_owner,d_id,terr_id,am_name,rm_name,gl,total_amount,frequency,responsible_emp_id,
            cost_center_id,company_code,company_name,ct
            from
            (
            select sum(total_amount) total_amount , sum(ct) ct
            from
            (
            select sum(nvl(approved_amount,0)) total_amount, count(*) ct
            from mis.donation_process_cash dpc,mis.donation_req_correction dc
            where dpc.req_id = dc.req_id
            and length(terr_id) = 5 
            union
            select sum(nvl(approved_amount,0)) total_amount, count(*) ct
            from mis.donation_process_cash dpc,mis.donation_req_correction dc
            where dpc.req_id = dc.req_id
            and  terr_id  like ('MABS%')
            )
            ),
            (
            select to_char(to_date(payment_month,'MON-RR'),'Mon-RRRR') rs_exp_month,sl,summ_id,fi_doc_no,ref_no,
            deb.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount amount,purpose,frequency,responsible_emp_id,
            responsible_emp_name budget_owner,am_name,rm_name,dcc.gl,to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR') pay_month,
             drc.cost_center_id,company_code,company_name
            from mis.donation_process_cash dpc,mis.donation_expense_budget deb,mis.donation_req_correction drc,mis.donation_cost_center dcc
            where dpc.req_id = deb.req_id and deb.req_id = drc.req_id
            and budget_type = 'DONATION'
            and drc.gl = dcc.gl
            and drc.cost_center_id = dcc.cost_center_id
            and length(terr_id) = 5
        
               union 
              
            select to_char(to_date(payment_month,'MON-RR'),'Mon-RRRR') rs_exp_month,sl,summ_id,fi_doc_no,ref_no,
            deb.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount amount,purpose,frequency,responsible_emp_id,
            responsible_emp_name budget_owner,am_name,rm_name,dcc.gl,to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR') pay_month,
             drc.cost_center_id,company_code,company_name
            from mis.donation_process_cash dpc,mis.donation_expense_budget deb,mis.donation_req_correction drc,mis.donation_cost_center dcc
            where dpc.req_id = deb.req_id and deb.req_id = drc.req_id
            and budget_type = 'DONATION'
            and drc.gl = dcc.gl
            and drc.cost_center_id = dcc.cost_center_id
            and  terr_id  like ('MABS%')
            
            )) dr,(select d_id depot_id,name depot_name from msfa.depot@web_to_imsfa) di
            where dr.d_id = di.depot_id
            order by substr(terr_id,1,instr(terr_id,'-'))||'00',trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
            to_number(substr(terr_id,instr(terr_id,'-', -1)+1)),req_id)

                ");

            $prepared_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    initcap(di.dept_name) dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name      
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di       
                    where ui.user_id = '$uid'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

            $verified_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    initcap(di.dept_name) dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name      
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di       
                    where ui.user_id = '$request->ver_employee'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

            if(count($general)>0){
                $approval = $general[0]->responsible_emp_id;
                $cost_center_id = $general[0]->cost_center_id;


                if($cost_center_id == 1000101201){

                    $approved_by = DB::select("
                    select user_id,'' emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    case when di.dept_name = 'MARKETING STRATEGY' then 'Marketing' else  initcap(di.dept_name) end dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

                else if($cost_center_id == 1000801205 || $cost_center_id == 5000701008 ){

                    $approved_by = DB::select("
                      select user_id,' ' emp_name,' ' desig,
                    ' ' dept_name,' ' com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

                else{

                    $approved_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    case when di.dept_name = 'MARKETING STRATEGY' then 'Marketing' else  initcap(di.dept_name) end dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }


            }
            else{

                $approval = $special[0]->responsible_emp_id;
                $cost_center_id = $special[0]->cost_center_id;


            if($cost_center_id == 1000101201){

                $approved_by = DB::select("
                    select user_id,'' emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    case when di.dept_name = 'MARKETING STRATEGY' then 'Marketing' else  initcap(di.dept_name) end dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

}

            else if($cost_center_id == 1000801205 || $cost_center_id == 5000701008 ){

                $approved_by = DB::select("
                      select user_id,' ' emp_name,' ' desig,
                    ' ' dept_name,' ' com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

            }

            elseif($approval == 1000298){

                $approved_by = DB::select("
                      select user_id,' ' emp_name,' ' desig,
                    ' ' dept_name,' ' com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

            }
            else{

                $approved_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    case when di.dept_name = 'MARKETING STRATEGY' then 'Marketing' else  initcap(di.dept_name) end dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

            }




            }

            $data = ['rs_data' => $result];

            $datapdf = ['rs_data' => $general,'special' => $special,'prepared' => $prepared_by, 'verified' => $verified_by,'approved' => $approved_by];

            if (file_exists(storage_path('/donation/summary_report.pdf'))) {

                unlink(storage_path('donation/summary_report.pdf'));

            }

            $pdf = \PDF::loadView('donation/summary_report', $datapdf)->setPaper('a4','landscape')->save(storage_path('donation/summary_report.pdf'));
//            $pdf = \PDF::loadView('donation/summary_report', $data);

//            unlink(storage_path('donation/Field Expense Summary.xls'));

//            Storage::put('summary_report.pdf', $pdf->output());

//            $pdf->save('pdf', storage_path('donation/'));

            if (file_exists(storage_path('/donation/Cash Advice Summary.xls'))) {

                unlink(storage_path('donation/Cash Advice Summary.xls'));

            }

            \Excel::create('Cash Advice Summary', function ($excel) use ($data) {

                $excel->sheet('Summary Data', function ($sheet) use ($data) {
                    $sheet->loadView('donation.excel_layout.cash_excel', $data);
                    $sheet->setWidth(array(
                        'A' => 20,
                        'B' => 20,
                            'D' => 30
                    ));
                    $sheet->protect('incepta');
                });

            })->store('xls', storage_path('donation/'));

//            $pdf = \PDF::loadView('donation/summary_report', $data)->save('donation/'.'.pdf');
//            $pdf = \PDF::loadView('donation/summary_report');
//            return $pdf->streamsetPaper('a4','landscape')->('summary_report.pdf');
            return $pdf->setPaper('a4','landscape')->stream('summary_report.pdf');
//            return $pdf->setPaper('a4','landscape')->stream('summary_report.pdf')->store('pdf', storage_path('donation/'));
            //mail for super visor
//            $app_data = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$line_id,'accpt_emp' =>$auth_name );
//            $emails = [];
//            array_push( $emails, $sp);
//
//            Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use($emails,$to_mail,$to_mail_name) {
//                $message->to($emails, 'Test Mail')
//                    ->subject('Leave Approved Request');
//                $message->from($to_mail, $to_mail_name);
//            });

        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
//        return response()->json($result);


//        }
    }

    public function send_mail_cash(Request $request)
    {

        $mail_val = DB::select("
                  select  distinct send_mail,summ_id from mis.donation_expense_budget 
                    where req_id in(select req_id from mis.donation_process_cash)  
                    ");
        if ($mail_val[0]->send_mail == '1') {
            return response()->json(['success' => 'true']);
        } else {
            $summary_id = $mail_val[0]->summ_id;



//        mail for super visor
//            $app_data = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$line_id,'accpt_emp' =>$auth_name );
//            $emails = [];
//            array_push( $emails, $sp);
//
//            Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use($emails,$to_mail,$to_mail_name) {
//                $message->to($emails, 'Test Mail')
//                    ->subject('Leave Approved Request');
//                $message->from($to_mail, $to_mail_name);
//            });


//        second  version of the mail

        $mail_address = DB::select("select email from mis.donation_depot_info  where depot_id= '$request->did'   ");
        $to_mail = $mail_address[0]->email;
//        $to_mail= 'sahadat@inceptapharma.com';
//        $data_mail= $to_mail;
        $data_mail = [];
//        $path =realpath("storage/donation/".'Bank Advice.pdf');
        Mail::send(['html' => 'donation.mail'], $data_mail, function ($message) use ($to_mail,$summary_id) {
            $message->to(explode(',',$to_mail));
            $message->subject("Cash Summary Id - ". $summary_id );
            $message->from('mis@inceptapharma.com', 'MIS');
            $message->attach(storage_path('/donation/summary_report.pdf'));
//            $message->attach($path);
            $message->attach(storage_path('/donation/Cash Advice Summary.xls'));
        });

            DB::update(" 
               update mis.donation_expense_budget 
               set send_mail=1 
               where req_id in(select req_id from mis.donation_process_cash) 
                ");



    }

        //        second  version of the mail

//        $message->to(['sahadat@inceptapharma.com'])
//        $message->to($to_mail,'sahadat')

//        \Excel::create('Field Expense Summary', function ($excel) use ($data) {
//
//            $excel->sheet('Summary Data', function ($sheet) use ($data) {
//                $sheet->loadView('expense.excel_layout.summaryv', $data);
//                $sheet->setWidth(array(
//                    'A' => 20
//                ));
//                $sheet->protect('incepta');
//            });
//
//        })->store('xls', storage_path('donation/'));

//        if (file_exists(storage_path('/donation/Field Expense Summary.xls'))) {
//            Log::info(storage_path('/donation/Field Expense Summary.xls'));
//            $data=[];
//            Mail::send(['html' => 'donation.mail'], $data, function ($message) {
//                $message->to(['sahadat@inceptapharma.com'])
//                    ->subject('Success donation mail');
//                $message->from('sahadat@inceptapharma.com','Sahadat');
////                $message->attach(storage_path('/donation/Field Expense Summary.xls'));
//            });
//        }
//        ->cc('shajadur@inceptapharma.com')

    }

    public function print_summary_super(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        try {

           $general = DB::select("
            
            select rownum sl,cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,responsible_emp_id,
            depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount ,frequency,
            cost_center_id,company_code,company_name,ct
            from(
            select cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,responsible_emp_id,
            depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount ,frequency,
            cost_center_id,company_code,company_name,ct
            from 
            (select pay_month,to_char(sysdate, 'DD-MON-YY hh12:mi:ss AM') cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,
            in_favour_of,amount,purpose,budget_owner,d_id,terr_id,am_name,rm_name,gl,total_amount,frequency,responsible_emp_id,
            cost_center_id,company_code,company_name,ct
            from 
            (select sum(nvl(approved_amount,0)) total_amount, count(*) ct
            from mis.donation_expense_budget deb,mis.donation_req_correction dc
            where deb.req_id = dc.req_id and ref_no = '$request->ref_no' and length(terr_id) != 5),
            (select to_char(to_date(payment_month,'MON-RR'),'Mon-RRRR') rs_exp_month,summ_id,fi_doc_no,
            ref_no,deb.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount amount,frequency,responsible_emp_id,
            purpose,responsible_emp_name budget_owner,am_name,rm_name,dcc.gl,to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR') pay_month,
            drc.cost_center_id,company_code,company_name
            from mis.donation_expense_budget deb,mis.donation_req_correction drc,mis.donation_cost_center dcc
            where deb.req_id = drc.req_id and ref_no = '$request->ref_no'  
            and budget_type = 'DONATION'
            and drc.gl = dcc.gl
            and drc.cost_center_id = dcc.cost_center_id
            and length(terr_id) != 5 and  terr_id not like ('MABS%')  )) dr,
            (select d_id depot_id,name depot_name from msfa.depot@web_to_imsfa) di
            where dr.d_id = di.depot_id
            order by substr(terr_id,1,instr(terr_id,'-'))||'00',trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
            to_number(substr(terr_id,instr(terr_id,'-', -1)+1)),req_id)


                ");

            $special = DB::select("
                  
           select rownum sl,cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,responsible_emp_id,
            depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount ,frequency,
            cost_center_id,company_code,company_name,ct
            from(
            select cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,in_favour_of,amount,purpose,budget_owner,
            depot_id,depot_name,terr_id,am_name,rm_name,gl,total_amount ,frequency,responsible_emp_id,
            cost_center_id,company_code,company_name,ct
            from 
            (select pay_month,to_char(sysdate, 'DD-MON-YY hh12:mi:ss AM') cd,rs_exp_month,summ_id,fi_doc_no,ref_no,req_id,doctor_name,
            in_favour_of,amount,purpose,budget_owner,d_id,terr_id,am_name,rm_name,gl,total_amount,frequency,responsible_emp_id,
            cost_center_id,company_code,company_name,ct
            from 
              (
             select sum(total_amount) total_amount , sum(ct) ct
            from
            (
            select sum(nvl(approved_amount,0)) total_amount,count(*) ct
            from mis.donation_expense_budget deb,mis.donation_req_correction dc
            where deb.req_id = dc.req_id and ref_no = '$request->ref_no' and length(terr_id) = 5
            union
            select sum(nvl(approved_amount,0)) total_amount,count(*) ct
            from mis.donation_expense_budget deb,mis.donation_req_correction dc
            where deb.req_id = dc.req_id and ref_no = '$request->ref_no' and  terr_id  like ('MABS%')
            )
            ),
            (select to_char(to_date(payment_month,'MON-RR'),'Mon-RRRR') rs_exp_month,summ_id,fi_doc_no,
            ref_no,deb.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount amount,frequency,responsible_emp_id,
            purpose,responsible_emp_name budget_owner,am_name,rm_name,dcc.gl,to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR') pay_month,
            drc.cost_center_id,company_code,company_name
            from mis.donation_expense_budget deb,mis.donation_req_correction drc,mis.donation_cost_center dcc
            where deb.req_id = drc.req_id and ref_no = '$request->ref_no'  
            and budget_type = 'DONATION'
            and drc.gl = dcc.gl
            and drc.cost_center_id = dcc.cost_center_id
            and length(terr_id) = 5
            
              union 
              
            select to_char(to_date(payment_month,'MON-RR'),'Mon-RRRR') rs_exp_month,summ_id,fi_doc_no,
            ref_no,deb.req_id,drc.d_id,terr_id,doctor_name,in_favour_of,approved_amount amount,frequency,responsible_emp_id,
            purpose,responsible_emp_name budget_owner,am_name,rm_name,dcc.gl,to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR') pay_month,
            drc.cost_center_id,company_code,company_name
            from mis.donation_expense_budget deb,mis.donation_req_correction drc,mis.donation_cost_center dcc
            where deb.req_id = drc.req_id and ref_no = '$request->ref_no'  
            and budget_type = 'DONATION'
            and drc.gl = dcc.gl
            and drc.cost_center_id = dcc.cost_center_id
            and  terr_id  like ('MABS%')
            
            )) dr,
            (select d_id depot_id,name depot_name from msfa.depot@web_to_imsfa) di
            where dr.d_id = di.depot_id
            order by substr(terr_id,1,instr(terr_id,'-'))||'00',trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
            to_number(substr(terr_id,instr(terr_id,'-', -1)+1)),req_id)


                ");

            $prepared_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    initcap(di.dept_name) dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name      
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di       
                    where ui.user_id = '$uid'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

            $verified_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    initcap(di.dept_name) dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name      
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di       
                    where ui.user_id = '$request->ver_employee'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

            if(count($general)>0){
                $approval = $general[0]->responsible_emp_id;
                $cost_center_id = $general[0]->cost_center_id;


                if($cost_center_id == 1000101201){

                    $approved_by = DB::select("
                    select user_id,'' emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    case when di.dept_name = 'MARKETING STRATEGY' then 'Marketing' else  initcap(di.dept_name) end dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

                else if($cost_center_id == 1000801205 || $cost_center_id == 5000701008 ){

                    $approved_by = DB::select("
                      select user_id,' ' emp_name,' ' desig,
                    ' ' dept_name,' ' com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

                else{

                    $approved_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    case when di.dept_name = 'MARKETING STRATEGY' then 'Marketing' else  initcap(di.dept_name) end dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

            }

            else{

                $approval = $special[0]->responsible_emp_id;
                $cost_center_id = $special[0]->cost_center_id;

//                dd($approval);


                if($cost_center_id == 1000101201){

                    $approved_by = DB::select("
                      select user_id,' ' emp_name,' ' desig,
                    ' ' dept_name,' ' com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

                else if($cost_center_id == 1000801205 || $cost_center_id == 5000701008 ){

                    $approved_by = DB::select("
                      select user_id,' ' emp_name,' ' desig,
                    ' ' dept_name,' ' com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }


                elseif($approval == 1000298 ){

                    $approved_by = DB::select("
                      select user_id,' ' emp_name,' ' desig,
                    ' ' dept_name,' ' com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

                else{

                    $approved_by = DB::select("
                    select user_id,initcap(sur_name) emp_name,initcap(substr(desig_name,1,instr(desig_name,',',1,1)-1)) desig,
                    case when di.dept_name = 'MARKETING STRATEGY' then 'Marketing' else  initcap(di.dept_name) end dept_name,initcap('INCEPTA PHARMACEUTICALS LTD.') com_name
                    from mis.dashboard_users_info ui,hrms.emp_information@web_to_hrms ei, hrms.emp_designation@web_to_hrms ed,
                    hrms.dept_information@web_to_hrms di
                    where ui.user_id = '$approval'
                    and ui.user_id = ei.emp_id
                    and ei.desig_id = ed.desig_id
                    and ei.dept_id = di.dept_id
            ");

                }

            }


            $data = ['rs_data' => $general,'special' => $special,'prepared' => $prepared_by, 'verified' => $verified_by,'approved' => $approved_by];

//            $pdf = \PDF::loadView('donation/summary_report', $data)->setPaper('a4','landscape')->save(storage_path('donation/summary_report.pdf'));
            $pdf = \PDF::loadView('donation/summary_report_super', $data);


//            $pdf = \PDF::loadView('donation/summary_report', $data)->save('donation/'.'.pdf');
//            $pdf = \PDF::loadView('donation/summary_report');
//            return $pdf->streamsetPaper('a4','landscape')->('summary_report.pdf');
            return $pdf->setPaper('a4','landscape')->stream('summary_report.pdf');


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
//        return response()->json($result);


//        }
    }


}
