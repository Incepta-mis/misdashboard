<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 12/12/2018
 * Time: 3:17 PM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PlanHeadController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {


            DB::update('update MIS.leave_emp_record  set FORWARD_EMP = ? where line_id = ?', [$request->emp_id,$request->line_id]);

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = DB::select("
                                select pl_head_name,pl_email from mis.leave_plant_head
                                where plant_id =  (select plant_id
                                                  from mis.leave_emp_record
                                                  where emp_id = ? and line_id = ?)
                                ", [$request->emp_id,$request->line_id]);
            $data = array('name' => $request->emp_name,'accpt_emp' =>$auth_name,
                'url_link'=>'http://web.inceptapharma.com:5031/misdashboard/elm_portal/plan_headapproval/'.$request->emp_id.'/'.$request->line_id
            );


            // mail for applicant notification
            Mail::send(['text' => 'elm_portal.mail.hrsent_plant_head'], $data, function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail[0]->pl_email, 'Test Mail')
                    ->subject('Request for Approval');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });

            return response()->json(['success','Mail Send Successfully']);

        }
    }

    public function plan_headapproval($emp_id = null,$line_id = null){


        //        var_dump($emp_id);

        $uid = Auth::user()->user_id;
        // $emp_info = DB::select("select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        // from hrms.emp_information@WEB_TO_HRMS
        // where dept_id = (                        
        //     select trim(dept_id)
        //     from hrms.emp_information@WEB_TO_HRMS
        //     where emp_id = '$uid'
        //     and valid = 'YES'                        
        // )
        // order by emp_id");

        $emp_info = DB::select("select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        from hrms.emp_information@WEB_TO_HRMS
        where emp_id in (                        
        select distinct emp_id
        from mis.leave_emp_info
        where head_of_dept = '$uid'
        and valid = 'YES'                        
        )
        order by emp_id");

        $resp_data = DB::select("
                select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') application_date,to_char(leave_from,'DD-MON-RR') leave_from,
                to_char(leave_to,'DD-MON-RR') leave_to,type_of_leave,day_of_leave,rejected_id,purpose_of_leave,rsp_accept,sup_accept,head_rejected_id,sup_rejected_id,
                hr_rejected_id,status,to_char(rcm_approved_date,'DD-MON-RR') rcm_approved_date,status,plant_head_id,plant_head_rejected
                from mis.leave_emp_record where emp_id = ?
                and line_id = ?
                and forward_emp is not null
                and rejected_id is null
                order by create_date desc", [$emp_id, $line_id]);
//            return response()->json($resp_data);

                // $procedureName = 'P_LEAVE_PROCESS';
                // $result = DB::executeProcedure($procedureName);

        return view('elm_portal.plant_headapproval',['emp_info'=>$emp_info,'resp_data'=>$resp_data]);
    }

   public function getSPLeaveList(Request $request){
         $uid = $request->auth_id;

         $rs = DB::select("select plant_id
         from mis.leave_emp_info
         where emp_id = '$uid'" );


        if($rs[0]->plant_id == 1300){
            $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,to_char(rcm_approved_date,'DD-MON-RR') rcm_approved_date
            ,plant_head_id
            ,plant_head_approved,plant_head_rejected
            from mis.leave_emp_record where emp_id = decode( ?,'All',emp_id,?) 
            and rejected_id is null
            and plant_id in (1300,1400,2200,4100,5100,4000)
            and forward_emp is not null
            order by DECODE(plant_head_approved, '', plant_head_approved,plant_head_approved) DESC,create_date desc",
            [$request->emp_id, $request->emp_id]);
        }
        else if($rs[0]->plant_id == 1200){
            $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,to_char(rcm_approved_date,'DD-MON-RR') rcm_approved_date
            ,plant_head_id
            ,plant_head_approved,plant_head_rejected
            from mis.leave_emp_record where emp_id = decode( ?,'All',emp_id,?) 
            and rejected_id is null
            and plant_id in (1200)
            and forward_emp is not null
            order by DECODE(plant_head_approved, '', plant_head_approved,plant_head_approved) DESC,create_date desc",
            [$request->emp_id, $request->emp_id]);
        }
        else{
            $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,to_char(rcm_approved_date,'DD-MON-RR') rcm_approved_date
            ,plant_head_id
            ,plant_head_approved,plant_head_rejected
            from mis.leave_emp_record where emp_id = decode( ?,'All',emp_id,?) 
            and rejected_id is null
            and plant_id in (1100,2100)
            and forward_emp is not null
            order by DECODE(plant_head_approved, '', plant_head_approved,plant_head_approved) DESC,create_date desc",
                [$request->emp_id, $request->emp_id]);
        }
        return response()->json($resp_data);
    }

//     public function plantHeadAccept(Request $request){
// //        return response()->json($request->all());
//         $uid = Auth::user()->user_id;
//         $auth_name = Auth::user()->name;

//         if ($request->st == 'accept') {

//             $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//             $suc = LeaveEmpRecord::where('line_id', $request->line_id)
//             ->update([
//                 'STATUS' => 'YES',
//                 'APP_STATUS' => 'YES',
//                 'PLANT_HEAD_APPROVED' => $sys_time,
//                 'PLANT_HEAD_ID' => $uid
//             ]);
//         }

//         if ($suc) {

//             $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
//             $app_mail = DB::select("select emp_email,emp_id from mis.leave_emp_record where line_id = ?", [$request->line_id]);

//             $dept_mail = DB::select("select emp.head_of_dept,manager.mail_address head_email, emp.head_of_hr,hrm.mail_address hr_email
//                             from mis.leave_emp_info emp join mis.leave_emp_info manager
//                             ON  (emp.head_of_dept = manager.emp_id)
//                             join mis.leave_emp_info hrm
//                             ON  (emp.head_of_hr = hrm.emp_id) 
//                             where emp.emp_id = ?", [$app_mail[0]->emp_id]);

//             $to_mail = array();
//             array_push($to_mail,$app_mail[0]->emp_email);
//             array_push($to_mail,$dept_mail[0]->head_email);
//             array_push($to_mail,$dept_mail[0]->hr_email);
//             array_push($to_mail,'shaon@inceptapharma.com');
//             array_push($to_mail,'smnazmul@inceptapharma.com');
//             array_push($to_mail,'khasan@inceptapharma.com');

//             $data = array('accpt_emp' => $auth_name);
//             Mail::send(['text' => 'elm_portal.mail.plant_head_success'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
//                 $message->to($to_mail, $to_mail)
//                     ->subject('Leave Application');
//                 $message->from($frm_mail[0]->mail_address, $auth_name);
//             });

//             return response()->json(['success' => 'Record Save Successfully']);
//         }


//     }

//     public function plantHeadReject(Request $request){

//         $uid = Auth::user()->user_id;
//         $auth_name = Auth::user()->name;

//         if ($request->st == 'reject') {

//             $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//             $suc = LeaveEmpRecord::where('line_id', $request->line_id)
//                 ->update([
//                     'STATUS' => 'NO',
//                     'APP_STATUS' => 'YES',
//                     'PLANT_HEAD_REJECTED' => $sys_time,
//                     'PLANT_HEAD_ID' => $uid
//                 ]);
//         }

//         if ($suc) {

//             $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
//             $app_mail = DB::select("select emp_email,emp_id from mis.leave_emp_record where line_id = ?", [$request->line_id]);

//             $dept_mail = DB::select("select emp.head_of_dept,manager.mail_address head_email, emp.head_of_hr,hrm.mail_address hr_email
//                             from mis.leave_emp_info emp join mis.leave_emp_info manager
//                             ON  (emp.head_of_dept = manager.emp_id)
//                             join mis.leave_emp_info hrm
//                             ON  (emp.head_of_hr = hrm.emp_id) 
//                             where emp.emp_id = ?", [$app_mail[0]->emp_id]);

//             $to_mail = array();
//             array_push($to_mail,$app_mail[0]->emp_email);
//             array_push($to_mail,$dept_mail[0]->head_email);
//             array_push($to_mail,$dept_mail[0]->hr_email);
//             array_push($to_mail,'shaon@inceptapharma.com');
//             array_push($to_mail,'smnazmul@inceptapharma.com');
//             array_push($to_mail,'khasan@inceptapharma.com');

//             $data = array('accpt_emp' => $auth_name);
//             Mail::send(['text' => 'elm_portal.mail.plant_head_rejected'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
//                 $message->to($to_mail, $to_mail)
//                     ->subject('Leave Application');
//                 $message->from($frm_mail[0]->mail_address, $auth_name);
//             });

//             return response()->json(['success' => 'Record Save Successfully']);
//         }

//     }



public function plantHeadAccept(Request $request){
//        return response()->json($request->all());
        $uid = $request->auth_id;
        $auth_name = Auth::user()->name;

        $rs = DB::select("select plant_id
        from mis.leave_emp_info
        where emp_id = '$uid'" );

        if ($request->st == 'accept') {

            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = LeaveEmpRecord::where('line_id', $request->line_id)
            ->update([
                'STATUS' => 'YES',
                'APP_STATUS' => 'YES',
                'PLANT_HEAD_APPROVED' => $sys_time,
                'PLANT_HEAD_ID' => $uid
            ]);
        }

        if ($suc) {

            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $app_mail = DB::select("select emp_email,emp_id,emp_name,emp_dept_name,type_of_leave,concat(to_char(leave_from,'DD-MON-RR') ,concat( ' TO ', to_char(leave_to,'DD-MON-RR'))) leave
                                    from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            $dept_mail = DB::select("select emp.head_of_dept,manager.mail_address head_email, emp.head_of_hr,hrm.mail_address hr_email
                            from mis.leave_emp_info emp join mis.leave_emp_info manager
                            ON  (emp.head_of_dept = manager.emp_id)
                            join mis.leave_emp_info hrm
                            ON  (emp.head_of_hr = hrm.emp_id) 
                            where emp.emp_id = ?", [$app_mail[0]->emp_id]);

            $to_mail = array();
            array_push($to_mail,$app_mail[0]->emp_email);
            array_push($to_mail,$dept_mail[0]->head_email);
            array_push($to_mail,$dept_mail[0]->hr_email);
            if($rs[0]->plant_id == 1300){                
                array_push($to_mail,'muhin@inceptapharma.com');
            }else if($rs[0]->plant_id == 1200){                
                array_push($to_mail,'muhin@inceptapharma.com');
            }
            else{
                array_push($to_mail,'shaon@inceptapharma.com');
                array_push($to_mail,'smnazmul@inceptapharma.com');
                array_push($to_mail,'habiba@inceptapharma.com');
            }

            // application information
            $applicant_name = $app_mail[0]->emp_name;
            $applicant_id = $app_mail[0]->emp_id;
            $applicant_dept = $app_mail[0]->emp_dept_name;
            $applicant_tol = $app_mail[0]->type_of_leave;
            $applicant_lv = $app_mail[0]->leave;

            $data = array(
                'accpt_emp' => $auth_name,
                'applicant_name' => $applicant_name,
                'applicant_id' => $applicant_id,
                'applicant_dept' => $applicant_dept,
                'applicant_tol' => $applicant_tol,
                'applicant_lv' => $applicant_lv
            );
            // application information end

            Mail::send(['text' => 'elm_portal.mail.plant_head_success'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail, $to_mail)
                    ->subject('Leave Application');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });

            return response()->json(['success' => 'Record Save Successfully']);
        }


    }

    public function plantHeadReject(Request $request){

        $uid = $request->auth_id;
        $auth_name = Auth::user()->name;

        $rs = DB::select("select plant_id
        from mis.leave_emp_info
        where emp_id = '$uid'" );

        if ($request->st == 'reject') {

            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update([
                    'STATUS' => 'NO',
                    'APP_STATUS' => 'YES',
                    'PLANT_HEAD_REJECTED' => $sys_time,
                    'PLANT_HEAD_ID' => $uid
                ]);
        }

        if ($suc) {

            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $app_mail = DB::select("select emp_email,emp_id,emp_name,REPLACE(emp_dept_name, '&', 'AND') emp_dept_name,type_of_leave,concat(to_char(leave_from,'DD-MON-RR') ,concat( ' TO ', to_char(leave_to,'DD-MON-RR'))) leave
                                    from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            $dept_mail = DB::select("select emp.head_of_dept,manager.mail_address head_email, emp.head_of_hr,hrm.mail_address hr_email
                            from mis.leave_emp_info emp join mis.leave_emp_info manager
                            ON  (emp.head_of_dept = manager.emp_id)
                            join mis.leave_emp_info hrm
                            ON  (emp.head_of_hr = hrm.emp_id) 
                            where emp.emp_id = ?", [$app_mail[0]->emp_id]);

            $to_mail = array();
            array_push($to_mail,$app_mail[0]->emp_email);
            array_push($to_mail,$dept_mail[0]->head_email);
            array_push($to_mail,$dept_mail[0]->hr_email);
            if($rs[0]->plant_id == 1300){                
                array_push($to_mail,'muhin@inceptapharma.com');
            }else{
                array_push($to_mail,'shaon@inceptapharma.com');
                array_push($to_mail,'smnazmul@inceptapharma.com');
                array_push($to_mail,'habiba@inceptapharma.com');
            }


            // application information
            $applicant_name = $app_mail[0]->emp_name;
            $applicant_id = $app_mail[0]->emp_id;
            $applicant_dept = $app_mail[0]->emp_dept_name;
            $applicant_tol = $app_mail[0]->type_of_leave;
            $applicant_lv = $app_mail[0]->leave;

            $data = array(
                'accpt_emp' => $auth_name,
                'applicant_name' => $applicant_name,
                'applicant_id' => $applicant_id,
                'applicant_dept' => $applicant_dept,
                'applicant_tol' => $applicant_tol,
                'applicant_lv' => $applicant_lv
            );
            // application information end


//            $data = array('accpt_emp' => $auth_name);
            Mail::send(['text' => 'elm_portal.mail.plant_head_rejected'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail, $to_mail)
                    ->subject('Leave Application');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });

            return response()->json(['success' => 'Record Save Successfully']);
        }

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
//
            $emp_id = $resp_data[0]->emp_id;


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
                            order by emp_id", [$emp_id, $emp_id]);
            if ($rsp_emp[0]->gender == 'Male') {
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
                    'leaveStatus' => $leaveStatus, 'mgt_statsu' => $mgt_statsu]
            );
        }else {
            return response()->json('Check Data.');
        }


    }

}