<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 11/18/2018
 * Time: 4:21 PM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class PrimaryApprovalController extends Controller
{
    public function index(Request $request){


        DB::setDateFormat('DD-MON-RR');

        $appData = DB::select("select line_id,emp_id,emp_name,emp_email,application_date,application_date,leave_from,
            leave_to,type_of_leave,day_of_leave,rejected_id,purpose_of_leave,rsp_accept,sup_accept,head_rejected_id,sup_rejected_id,
            hr_rejected_id,status,rcm_approved_date
       from mis.leave_emp_record where emp_id = ? 
       and line_id = ?
       and rejected_id is null
       order by create_date desc", [$request->id,$request->lineid]);

        $nm_st = DB::select(" SELECT mgt_status
        FROM mis.LEAVE_EMP_INFO
        WHERE emp_id = ? ",[$request->id]);

//        dd($nm_st[0]->mgt_status);

         $leaveStatus = DB::select("
    
    SELECT    x.emp_id
    ,'Eligibility' TYPE
    ,MAX(DECODE(x.leave_type, 'ANNUAL', x.total_allowed_leave)) ANNUAL
    ,MAX(DECODE(x.leave_type, 'CASUAL', x.total_allowed_leave)) CASUAL
    ,MAX(DECODE(x.leave_type, 'LWP', x.total_allowed_leave)) LWP
    ,MAX(DECODE(x.leave_type, 'MATERNITY', x.total_allowed_leave)) MATERNITY
    ,MAX(DECODE(x.leave_type, 'MEDICAL', x.total_allowed_leave)) MEDICAL
    ,MAX(DECODE(x.leave_type, 'SL', x.total_allowed_leave)) SL
    ,MAX(DECODE(x.leave_type, 'ADVANCE', x.total_allowed_leave)) ADVANCE
    ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.total_allowed_leave)) SPECIAL_MEDICAL
    FROM    (
      SELECT   r.emp_id
      ,r.leave_type
      ,r.total_allowed_leave
      ,r.leave_year
      FROM    hrms.v_employee_leave_status@web_to_hrms r
      ) x
      WHERE X.EMP_ID = '$request->id'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)
      GROUP BY x.emp_id
      
      UNION ALL
      
      SELECT    x.emp_id
      ,'Enjoyed' TYPE
      ,MAX(DECODE(x.leave_type, 'ANNUAL', x.TOTAL_ENJOYED_LEAVE)) ANNUAL
      ,MAX(DECODE(x.leave_type, 'CASUAL', x.TOTAL_ENJOYED_LEAVE)) CASUAL
      ,MAX(DECODE(x.leave_type, 'LWP', x.TOTAL_ENJOYED_LEAVE)) LWP
      ,MAX(DECODE(x.leave_type, 'MATERNITY', x.TOTAL_ENJOYED_LEAVE)) MATERNITY
      ,MAX(DECODE(x.leave_type, 'MEDICAL', x.TOTAL_ENJOYED_LEAVE)) MEDICAL
      ,MAX(DECODE(x.leave_type, 'SL', x.TOTAL_ENJOYED_LEAVE)) SL
      ,MAX(DECODE(x.leave_type, 'ADVANCE', x.TOTAL_ENJOYED_LEAVE)) ADVANCE
      ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.TOTAL_ENJOYED_LEAVE)) SPECIAL_MEDICAL
      FROM    (
        SELECT   r.emp_id
        ,r.leave_type
        ,r.TOTAL_ENJOYED_LEAVE
        ,r.leave_year
        FROM    hrms.v_employee_leave_status@web_to_hrms r
        ) x
        WHERE X.EMP_ID = '$request->id'
        AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)
        GROUP BY x.emp_id
        
        UNION ALL
        
        SELECT    x.emp_id
        ,'Balance' TYPE
        ,MAX(DECODE(x.leave_type, 'ANNUAL', x.total_available_leave)) ANNUAL
        ,MAX(DECODE(x.leave_type, 'CASUAL', x.total_available_leave)) CASUAL
        ,MAX(DECODE(x.leave_type, 'LWP', x.total_available_leave)) LWP
        ,MAX(DECODE(x.leave_type, 'MATERNITY', x.total_available_leave)) MATERNITY
        ,MAX(DECODE(x.leave_type, 'MEDICAL', x.total_available_leave)) MEDICAL
        ,MAX(DECODE(x.leave_type, 'SL', x.total_available_leave)) SL
        ,MAX(DECODE(x.leave_type, 'ADVANCE', x.total_available_leave)) ADVANCE
        ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.total_available_leave)) SPECIAL_MEDICAL
        FROM    (
          SELECT   r.emp_id
          ,r.leave_type
          ,r.total_available_leave
          ,r.leave_year
          FROM    hrms.v_employee_leave_status@web_to_hrms r
          ) x
          WHERE X.EMP_ID = '$request->id'
          AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)
          GROUP BY x.emp_id
          
          ");

        $gender = DB::select("
            select nvl(gender,'MALE') sex
            from hrms.emp_information@WEB_TO_HRMS
            where emp_id = '$request->id'
        ");

        $sex = $gender[0]->sex ;



        return view('elm_portal.primary_approval',['appData' => $appData,'mgt_status' => $nm_st[0]->mgt_status,'leaveStatus'=>$leaveStatus,'sex'=>$sex]);
    }

    public function getapprovedEditedEmpinfo(Request $request)
    {


        DB::setDateFormat('DD-MON-RR');

        if ($request->ajax()) {

            $uid = Auth::user()->user_id;
            $mgt_statsu = Auth::user()->desig;

            $resp_data = DB::select("select 
          line_id, plant_id, emp_id, 
          emp_name, emp_dept_id, emp_dept_name, 
          emp_desig_id, emp_desig_name, emp_contact_no, 
          emp_email, initcap(to_char(leave_from,'DD-MON-RRRR')) leave_from , initcap(to_char(leave_to,'DD-MON-RRRR'))  leave_to,
          day_of_leave, type_of_leave, purpose_of_leave, 
          application_date, rsp_emp_id, rsp_emp_name, 
          rsp_desig_id, rsp_desig_name, rsp_dept_id, 
          rsp_dept_name, rsp_contact_no, rsp_email, 
          rsp_duties, rsp_accept, rsp_accept_date, 
          rejected_id, rejected_date, sup_rejected_id, 
          sup_rejected_date, head_rejected_id, head_rejected_date, 
          hr_rejected_id, hr_rejected_date, rpt_supervisor_id, 
          head_of_dept_id, rcm_approved_date, status, add_during_leave,medicalimages,sp_medicalimages,maternityimage
          from mis.leave_emp_record where line_id = ?", [$request->line_id]);

           



            $rsp_emp = DB::select("select a.emp_id,a.sur_name,a.gender,b.desig_id,b.desig_name,c.dept_name
                            from
                            (select emp_id,sur_name,desig_id,dept_id,nvl(gender,'Male') gender
                            from hrms.emp_information@WEB_TO_HRMS
                            where dept_id = (
                                            select dept_id
                                            from hrms.emp_information@WEB_TO_HRMS
                                            where emp_id = ?
                                            and valid = 'YES')
                            and valid = 'YES'
                            AND EMP_ID IN
                                        (
                                        select emp_id
                                        from hrms.emp_information@WEB_TO_HRMS
                                        where dept_id = (
                                                        select dept_id
                                                        from hrms.emp_information@WEB_TO_HRMS
                                                        where emp_id = ?
                                                        and valid = 'YES')
                                        and valid = 'YES'
                                        minus 
                                        select distinct emp_id emp_id
                                        from mis.leave_emp_info
                                        where mgt_status = 'NM'
                                        )
                            
                            
                            ) a, (select distinct desig_id,desig_name
                            from hrms.emp_designation@web_to_hrms
                            where valid = 'YES') b, (select distinct dept_id,dept_name
                            from hrms.dept_information@web_to_hrms
                            where valid = 'YES') c
                            where a.desig_id = b.desig_id     
                            and a.dept_id = c.dept_id                            
                            order by emp_id", [$uid,$uid]);


            // if ($rsp_emp[0]->gender == 'Male') {
            //     $leaveTypes = DB::select("select distinct leave_type
            //                 from hrms.leave_information@web_to_hrms
            //                 where valid = 'YES'
            //                 and leave_type != 'MATERNITY'
            //                 order by leave_type asc");
            // } else {
            //     $leaveTypes = DB::select("select distinct leave_type
            //     from hrms.leave_information@web_to_hrms
            //     where valid = 'YES'
            //     order by leave_type asc");
            // }



           $genderData =  DB::select("
            select  emp_id,sur_name,desig_id,dept_id,nvl(gender,'Male') gender
            from hrms.emp_information@WEB_TO_HRMS
            where dept_id = (
                            select dept_id
                            from hrms.emp_information@WEB_TO_HRMS
                            where emp_id = ?
                            and valid = 'YES')
            and valid = 'YES'
            and emp_id = ?
            
            ",[$resp_data[0]->emp_id,$resp_data[0]->emp_id]);


            if ($genderData[0]->gender == 'Male') {
                $leaveTypes = DB::select("select distinct leave_type
                            from hrms.leave_information@web_to_hrms
                            where valid = 'YES'
                            and leave_type != 'MATERNITY'
                            order by leave_type asc");
            } else {
                $leaveTypes = DB::select("select distinct leave_type
                from hrms.leave_information@web_to_hrms
                where valid = 'YES'
                order by leave_type asc");
            }



            $appEmpID = $resp_data[0]->emp_id;

            $leaveStatus = DB::select("SELECT    x.emp_id
      ,'Eligibility' TYPE 
      ,MAX(DECODE(x.leave_type, 'ANNUAL', x.total_allowed_leave)) ANNUAL
      ,MAX(DECODE(x.leave_type, 'CASUAL', x.total_allowed_leave)) CASUAL
      ,MAX(DECODE(x.leave_type, 'LWP', x.total_allowed_leave)) LWP
      ,MAX(DECODE(x.leave_type, 'MATERNITY', x.total_allowed_leave)) MATERNITY          
      ,MAX(DECODE(x.leave_type, 'MEDICAL', x.total_allowed_leave)) MEDICAL
      ,MAX(DECODE(x.leave_type, 'SL', x.total_allowed_leave)) SL
      ,MAX(DECODE(x.leave_type, 'ADVANCE', x.total_allowed_leave)) ADVANCE 
      ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.total_allowed_leave)) SPECIAL_MEDICAL
      FROM    (
      SELECT   r.emp_id
      ,r.leave_type
      ,r.total_allowed_leave
      ,r.leave_year
      FROM    hrms.v_employee_leave_status@web_to_hrms r
      ) x
      WHERE X.EMP_ID = '$appEmpID'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
      GROUP BY x.emp_id
      
      UNION ALL
      
      SELECT    x.emp_id
      ,'Enjoyed' TYPE
      ,MAX(DECODE(x.leave_type, 'ANNUAL', x.TOTAL_ENJOYED_LEAVE)) ANNUAL
      ,MAX(DECODE(x.leave_type, 'CASUAL', x.TOTAL_ENJOYED_LEAVE)) CASUAL
      ,MAX(DECODE(x.leave_type, 'LWP', x.TOTAL_ENJOYED_LEAVE)) LWP
      ,MAX(DECODE(x.leave_type, 'MATERNITY', x.TOTAL_ENJOYED_LEAVE)) MATERNITY          
      ,MAX(DECODE(x.leave_type, 'MEDICAL', x.TOTAL_ENJOYED_LEAVE)) MEDICAL
      ,MAX(DECODE(x.leave_type, 'SL', x.TOTAL_ENJOYED_LEAVE)) SL
      ,MAX(DECODE(x.leave_type, 'ADVANCE', x.TOTAL_ENJOYED_LEAVE)) ADVANCE 
      ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.TOTAL_ENJOYED_LEAVE)) SPECIAL_MEDICAL
      FROM    (
      SELECT   r.emp_id
      ,r.leave_type
      ,r.TOTAL_ENJOYED_LEAVE
      ,r.leave_year
      FROM    hrms.v_employee_leave_status@web_to_hrms r
      ) x
      WHERE X.EMP_ID = '$appEmpID'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
      GROUP BY x.emp_id  
      
      UNION ALL
      
      SELECT    x.emp_id
      ,'Balance' TYPE
      ,MAX(DECODE(x.leave_type, 'ANNUAL', x.total_available_leave)) ANNUAL
      ,MAX(DECODE(x.leave_type, 'CASUAL', x.total_available_leave)) CASUAL
      ,MAX(DECODE(x.leave_type, 'LWP', x.total_available_leave)) LWP
      ,MAX(DECODE(x.leave_type, 'MATERNITY', x.total_available_leave)) MATERNITY          
      ,MAX(DECODE(x.leave_type, 'MEDICAL', x.total_available_leave)) MEDICAL
      ,MAX(DECODE(x.leave_type, 'SL', x.total_available_leave)) SL
      ,MAX(DECODE(x.leave_type, 'ADVANCE', x.total_available_leave)) ADVANCE 
      ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.total_available_leave)) SPECIAL_MEDICAL
      FROM    (
      SELECT   r.emp_id
      ,r.leave_type
      ,r.total_available_leave
      ,r.leave_year
      FROM    hrms.v_employee_leave_status@web_to_hrms r
      ) x
      WHERE X.EMP_ID = '$appEmpID'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
      GROUP BY x.emp_id ");


            return response()->json(
                ['resp_data' => $resp_data, 'leavetypes' => $leaveTypes, 'rsp_emp' => $rsp_emp,
                    'leaveStatus'=>$leaveStatus,'mgt_statsu'=>$mgt_statsu]
            );
        }


    }

  public function appupdateApplication(Request $request)
      {
  //        echo Carbon::parse(trim($request->st_dt))->format('m-d-Y');

  //        $ss = Carbon::createFromFormat('d/m/Y', $request->st_dt);
  //        $pp = Carbon::parse(trim($request->en_dt))->format('m-d-Y');
  //
  //        echo $ss;
  //        echo $pp;
//         dd($request->all());
//         return response()->json($request->all());


        $suc = LeaveEmpRecord::where('line_id', $request->line_id)
            ->update([
                'leave_from' => Carbon::parse(trim($request->st_dt))->format('Y-m-d'),
                'leave_to' => Carbon::parse(trim($request->en_dt))->format('Y-m-d'),
                'day_of_leave' => $request->dol,
                'type_of_leave' => $request->tol,
                'add_during_leave' => $request->adl,
                'emp_contact_no' => $request->mob,
                'emp_email' => $request->email,
                'purpose_of_leave' => $request->pol,
                'rsp_emp_id' => $request->rsp_emp_code,
                'rsp_emp_name' => $request->rsp_emp_name,
                'rsp_desig_id' => $request->rsp_desig_id,
                'rsp_desig_name' => $request->rsp_desig_name,
                'rsp_dept_id' => $request->rsp_dept_id,
                'rsp_contact_no' => $request->rsp_cnt_no,
                'rsp_email' => $request->rsp_email,
                'rsp_duties' => $request->rsp_duties,
            ]);

        if ($suc) {
            $notification = array(
                'message' => 'Update Successfully.',
                'alert-type' => 'success'
            );




            $nm_st = DB::select(" SELECT mgt_status
            FROM mis.leave_emp_info
            WHERE emp_id  = (
            SELECT trim(emp_id)
            FROM mis.LEAVE_EMP_record
            WHERE line_id = ?
            )",[$request->line_id]);


            $auth_name = Auth::user()->name;
            $auth_id = Auth::user()->user_id;
//            $mgt_st = Auth::user()->desig;



            if($nm_st[0]->mgt_status != 'NM'){
                $auth_mail = DB::select("select distinct mail_address from mis.leave_emp_info where emp_id = ?", [$auth_id]);


                $appli_name = $request->applicant_name;
                $frm_mail = DB::select("select distinct mail_address from mis.leave_emp_info where emp_id = ?", [$request->rsp_emp_code]);
                $datax = array('sup_emp' => $auth_name, 'app_user'=>$appli_name);

                // $applicant_emails = $request->email;
                // Mail::send(['text' => 'elm_portal.mail.applicant_notify_change'], $datax, function ($message) use ($auth_mail, $frm_mail, $auth_name) {
                //     $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
                //         ->subject('Leave Application');
                //     $message->from($auth_mail[0]->mail_address, $auth_name);
                // });

                // old rsp notificaton for change
                // $mail_to = $request->rsp_oldemail;
                // $data = array('app_emp' => $auth_name);
                // $applicant_emails = $request->email;
                // Mail::send(['text' => 'elm_portal.mail.rsp_change_notify'], $data, function ($message) use ($auth_mail, $mail_to, $auth_name) {
                //     $message->to($mail_to, $mail_to)
                //         ->subject('Request For Changing Responsible Duties.');
                //     $message->from($auth_mail[0]->mail_address, $auth_name);
                // });

            }



            return Redirect::back()->with($notification);

        }
    }

    public function appl_primary_confirmation (Request $request){


        if($request->ajax()){

//             return response()->json($request->emp_email);
            // return response()->json( $frm_mail[0]->mail_address);


            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select mail_address,contact_no from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = $request->emp_email;
            $to_mail_name = $request->emp_name;

//            return response()->json( $frm_mail[0]->mail_address);



            $data = array('emp_name' => $request->emp_name,'accpt_emp' =>$auth_name );
            /*            var_dump( Mail:: failures());
            exit;*/
            // mail for applicant notification
            Mail::send(['text' => 'elm_portal.mail.sup_accept'], $data, function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail, $to_mail)
                    ->subject('Primary Approval');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });

            //TEST PLANT for primary to secondary mail          
            
            $head_mail = DB::select("select distinct mail_address ,contact_no
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(head_of_dept)
                                    from leave_emp_info
                                    where emp_id = '$request->emp_id')
                                ");

            $plantId = DB::select("select plant_id from leave_emp_info where emp_id = '$request->emp_id'");

            if( $head_mail[0]->mail_address != 'ehsan@inceptapharma.com')  {

                $hm = $head_mail[0]->mail_address;

                if($plantId[0]->plant_id != 1000){
                    //mail for department head
                    $app_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/headapproval/'.$request->emp_id.'/'.$request->line_id,
                        'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/headapproval/'.$request->emp_id.'/'.$request->line_id,
                        'accpt_emp' =>$auth_name, 'mob_no' => $frm_mail[0]->contact_no ,'application_user' => $to_mail_name  );
                    $head_emails = [];
                    array_push( $head_emails, $hm);
                    Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use($head_emails,$to_mail,$to_mail_name) {
                        $message->to($head_emails, 'Mail')
                            ->subject('Leave Application');
                        $message->from($to_mail, $to_mail_name);
                    });
                }
            }






            if($request->accept_val == '1'){
                LeaveEmpRecord::where('emp_id',$request->emp_id )
                    ->where('line_id',$request->line_id )
                    ->update(['SUP_ACCEPT'=>'YES','SUP_ACCEPT_DATE'=>$sys_time,'UPDATE_USER' => $uid]);
                return response()->json(['success'=>'Successfully ! Application Accepted by User.']);
            }
        }
    }

    public function appl_primary_rejection (Request $request){


        if($request->ajax()){

            // return response()->json($request->emp_email);
            // return response()->json( $frm_mail[0]->mail_address);


            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = $request->emp_email;

            $data = array('name' => $request->emp_name,'reject_emp' =>$auth_name );
/*var_dump( Mail:: failures());
exit;*/
// mail for applicant notification
            Mail::send(['text' => 'elm_portal.mail.sup_rejection_mail'], $data, function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail, $to_mail)
                    ->subject('Leave Approved Reject');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });



            if($request->reject_val == '0'){
                LeaveEmpRecord::where('emp_id',$request->emp_id )
                    ->where('line_id',$request->line_id )
                    ->update(['SUP_ACCEPT'=>'NO','SUP_REJECTED_ID'=>$uid,'SUP_REJECTED_DATE' => $sys_time,'UPDATE_USER' => $uid,'APP_STATUS'=>'YES']);
                return response()->json(['success'=>'Successfully ! Application Rejected by User.']);
            }
        }
    }




}