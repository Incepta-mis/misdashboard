<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 11/27/2018
 * Time: 2:25 PM
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


class SecondaryApprovalController extends Controller
{
     public function index(Request $request){

        DB::setDateFormat('DD-MON-RR');

        $appData = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,application_date,application_date,leave_from,
            leave_to,day_of_leave,rejected_id,purpose_of_leave,rsp_accept,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,head_rejected_id,sup_rejected_id,
            hr_rejected_id,status,rcm_approved_date,status
        from mis.leave_emp_record where emp_id = ? 
        and line_id = ?
        and rejected_id is null
        order by create_date desc", [$request->id,$request->lineid]);

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



          return view('elm_portal.secondary_approval',
            ['appData' => $appData, 'leaveStatus'=>$leaveStatus,'sex'=>$sex]);
    }



    public function appl_secondary_confirmation (Request $request){


        if($request->ajax()){

//             return response()->json($request->all());
            // return response()->json($request->emp_email);
            // return response()->json( $frm_mail[0]->mail_address);


            $auth_name = Auth::user()->name;
            $auth_id = Auth::user()->user_id;
            $auth_mail = DB::select("select mail_address,contact_no from mis.leave_emp_info where emp_id = ?", [$auth_id]);

            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');


            $hr_mail = DB::select("select mail_address
                                from mis.leave_emp_info 
                                where emp_id in (
                                select trim(hr_officer)
                                from mis.leave_emp_info 
                                where emp_id = ?)
                                union all
                                select mail_address
                                from mis.leave_emp_info 
                                where emp_id in (
                                select trim(hr_officer1)
                                from mis.leave_emp_info 
                                where emp_id = ?)
                                union all
                                select mail_address
                                from mis.leave_emp_info 
                                where emp_id in (
                                select trim(hr_officer2)
                                from mis.leave_emp_info 
                                where emp_id = ?)
", [$request->emp_id,$request->emp_id,$request->emp_id]);



            $emps = DB::select("select emp_id,INITCAP(emp_name) emp_name,emp_email,emp_contact_no from mis.leave_emp_record where line_id = ?", [$request->line_id]);


            $to_mail = [];
            array_push($to_mail,$hr_mail[0]->mail_address);
            array_push($to_mail,$hr_mail[1]->mail_address);
            array_push($to_mail,$hr_mail[2]->mail_address);

            $data = array('name' => $request->emp_name,'auth_emp' =>$auth_name,'app_mob' => '0'.$emps[0]->emp_contact_no,
                'url_link'=>'http://web.inceptapharma.com:5031/misdashboard/elm_portal/hrapproval/'.$request->emp_id.'/'.$request->line_id ,
                'local_url'=>'http://web.inceptapharma.com:5031/misdashboard/elm_portal/hrapproval/'.$request->emp_id.'/'.$request->line_id);
            Mail::send(['text' => 'elm_portal.mail.mail_to_HR'], $data, function ($message) use($to_mail,$auth_mail,$auth_name) {
                $message->to($to_mail, 'Apply for Leave')
                    ->subject('Leave Approval');
                $message->from($auth_mail[0]->mail_address, $auth_name);
            });





            if($request->accept_val == '1'){


            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$auth_id]);

            $to_mail = DB::select("select emp_id,INITCAP(emp_name) emp_name,emp_email,emp_contact_no from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            $data = array('accpt_emp' => $auth_name,'emp_name'=>$to_mail[0]->emp_name);
            Mail::send(['text' => 'elm_portal.mail.head_accept'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail[0]->emp_email, $to_mail[0]->emp_email)
                    ->subject('Leave Application');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });


                
                LeaveEmpRecord::where('emp_id',$request->emp_id )
                    ->where('line_id',$request->line_id )
                    ->update(['RCM_APPROVED_DATE'=>$sys_time,'UPDATE_USER' => $auth_id,'APP_STATUS' =>'YES']);
                return response()->json(['success'=>'Successfully ! Application Accepted by User.']);
            }
        }
    }

    public function appl_secondary_rejection (Request $request){


        if($request->ajax()){

//             return response()->json($request->all());
//             return response()->json($request->emp_email);
            // return response()->json( $frm_mail[0]->mail_address);


            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select mail_address,contact_no from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = $request->emp_email;

            $data = array('name' => $request->emp_name,'reject_emp' =>$auth_name );
            /*var_dump( Mail:: failures());
            exit;*/
// mail for applicant notification
            Mail::send(['text' => 'elm_portal.mail.sup_rejection_mail'], $data, function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail, 'Test Mail')
                    ->subject('Leave Approved Reject');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });



            if($request->reject_val == '0'){
                LeaveEmpRecord::where('emp_id',$request->emp_id )
                    ->where('line_id',$request->line_id )
                    ->update(['HEAD_REJECTED_ID'=>$uid,'HEAD_REJECTED_DATE' => $sys_time,'UPDATE_USER' => $uid,'APP_STATUS' =>'YES']);
                return response()->json(['success'=>'Successfully ! Application Rejected by User.']);
            }
        }
    }

}