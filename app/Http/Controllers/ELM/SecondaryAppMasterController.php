<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 12/11/2018
 * Time: 3:10 PM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SecondaryAppMasterController extends Controller
{
    public function index()
    {
        DB::setDateFormat('DD-MON-RR');

        $uid = Auth::user()->user_id;
        // $emp_info = DB::select("select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        //                 from hrms.emp_information@WEB_TO_HRMS
        //                 where dept_id = (                        
        //                     select trim(dept_id)
        //                     from hrms.emp_information@WEB_TO_HRMS
        //                     where emp_id = '$uid'
        //                     and valid = 'YES'                        
        //                 )
        //                 and emp_id != '$uid'
        //                 order by emp_id");
        $emp_info = DB::select("
        select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
                        from hrms.emp_information@WEB_TO_HRMS
                        where emp_id in (                        
                         select emp_id 
                         from mis.leave_emp_info
                         where head_of_dept = '$uid'                                                      
                         and valid='YES')
        
        ");
//        $mgt_status = Auth::user()->desig;
        return view('elm_portal/secondary_aprv_master', ['emp_info' => $emp_info]);
    }

    public function secAccept(Request $request)
    {

        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update([
                    'RCM_APPROVED_DATE' => $sys_time,
                    'APP_STATUS' => 'YES',
                    'UPDATE_USER' => $uid
                ]);
        }

        if ($suc) {

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;

            $emps = DB::select("select emp_id,INITCAP(emp_name) emp_name,emp_email,emp_contact_no from mis.leave_emp_record where line_id = ?", [$request->line_id]);
            // $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$emps[0]->emp_email]);

            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            
            $to_mail = DB::select("select emp_id,INITCAP(emp_name) emp_name,emp_email,emp_contact_no from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            $data = array('accpt_emp' => $auth_name,'emp_name'=>$to_mail[0]->emp_name);
            Mail::send(['text' => 'elm_portal.mail.head_accept'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail[0]->emp_email, $to_mail[0]->emp_email)
                    ->subject('Leave Application');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });


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
", [$to_mail[0]->emp_id,$to_mail[0]->emp_id,$to_mail[0]->emp_id]);


            $hr_mail_send = [];
            array_push($hr_mail_send,$hr_mail[0]->mail_address);
            array_push($hr_mail_send,$hr_mail[1]->mail_address);
            array_push($hr_mail_send,$hr_mail[2]->mail_address);

            $data = array('name' => $to_mail[0]->emp_name,'app_mob' => '0'.$to_mail[0]->emp_contact_no,'auth_emp' =>$auth_name,
                'url_link'=>'http://web.inceptapharma.com:5031/misdashboard/elm_portal/hrapproval/'.$to_mail[0]->emp_id.'/'.$request->line_id,
                'local_url'=>'http://web.inceptapharma.com:5031/misdashboard/elm_portal/hrapproval/'.$to_mail[0]->emp_id.'/'.$request->line_id);
            Mail::send(['text' => 'elm_portal.mail.mail_to_HR'], $data, function ($message) 
                use($hr_mail_send,$frm_mail,$auth_name) {
                $message->to($hr_mail_send, 'Apply for Leave')
                    ->subject('Leave Approval');
                $message->from($frm_mail[0]->mail_address, $auth_name);
                // $message->from($to_mail[0]->emp_email, $to_mail[0]->emp_name);
            });





//            return response()->json($hr_mail);
            return response()->json(['success' => 'Record Save Successfully']);
        }

    }

    public function secReject(Request $request)
    {


        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update([
                    'HEAD_REJECTED_ID' => $uid,
                    'HEAD_REJECTED_DATE' => $sys_time,
                    'APP_STATUS' => 'YES'
                ]);
        }

        if ($suc) {

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = DB::select("select emp_email,INITCAP(emp_name) emp_name from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            $data = array('accpt_emp' => $auth_name,'emp_name' =>$to_mail[0]->emp_name);
            Mail::send(['text' => 'elm_portal.mail.sup_accept'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail[0]->emp_email, $to_mail[0]->emp_email)
                    ->subject('Leave Application');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        }
    }

//     public function getLeaveList(Request $request)
//     {
//         $uid = Auth::user()->user_id;
//         $empDetails = DB::select("select trim(plant_id) plant_id from mis.leave_emp_info where emp_id = '$uid'");
//         $plant_id = $empDetails[0]->plant_id;

//         if ($plant_id != '1000') {

//                 $x = DB::SELECT("SELECT distinct emp_id
//                 FROM leave_factory_rcm_user
//                 WHERE emp_id in (SELECT report_supervisor FROM mis.leave_emp_info WHERE emp_id = DECODE(?,'All',emp_id,?))", [$request->emp_id, $request->emp_id]);
          

//               if ($x != NULL) {                
//                     //  $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     // to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                     // purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     // from mis.leave_emp_record 
//                     // where emp_id = decode( ?,'All',emp_id,?) 
//                     // and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//                     // and emp_id in 
//                     // (select emp_id from hrms.emp_information@web_to_hrms 
//                     // where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms 
//                     // where emp_id = '$uid') 
//                     // and valid='YES')
//                     // and rejected_id is null
//                     // and emp_id != '$uid'
//                     // and rsp_accept != 'NO'
//                     // order by create_date desc", [$request->emp_id, $request->emp_id]);

// $resp_data = DB::select("
                  
//                   select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
// purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// from mis.leave_emp_record 
// where emp_id = decode( ?,'All',emp_id,?) 
// and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and emp_id in 
// (select emp_id from hrms.emp_information@web_to_hrms 
// where  emp_id in ( select emp_id
//                                                 from mis.leave_emp_info
//                                                 where head_of_dept = '$uid' )                  
// and valid='YES')
// and rejected_id is null
// and emp_id != '$uid'
// and rsp_accept != 'NO'

// union all

// select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
// purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// from mis.leave_emp_record
// where emp_id = decode( ?,'All',emp_id,?)
// and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and emp_id in
// (select emp_id from mis.leave_emp_info where mgt_status = 'NM' )
// and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
//                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                 where emp_id = '$uid')
//                 and valid='YES')

// and emp_id in ( select emp_id
//                                                 from mis.leave_emp_info
//                                                 where head_of_dept = '$uid' )                 

// and rejected_id is null
// and emp_id != '$uid'
// and rsp_accept != 'NO'



// union all

// select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
// purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// from mis.leave_emp_record
// where emp_id = decode( ?,'All',emp_id,?)
// and rejected_id is null
// and emp_id != '$uid'
// and head_of_dept_id = '$uid'  
// and plant_id !=  (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and rsp_accept != 'NO'


// union all 
                    
//                     select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     from mis.leave_emp_record
//                     where emp_id = decode( ?,'All',emp_id,?)
//                     and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')
//                     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//                     and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
//                                     where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                                     where emp_id = '$uid')
//                                     and valid='YES')
//                     and emp_id in ( select emp_id
//                                                 from mis.leave_emp_info
//                                                 where head_of_dept = '$uid' )                                     
//                     and rejected_id is null
//                     and emp_id != '$uid' 


// order by line_id desc
                  
                  
//                   ",[$request->emp_id, $request->emp_id,$request->emp_id, $request->emp_id,$request->emp_id, $request->emp_id,$request->emp_id, $request->emp_id]);

                

//               }else {
//                     // $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     // to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,day_of_leave dol,rejected_id,
//                     // purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     // from mis.leave_emp_record 
//                     // where emp_id = decode( ?,'All',emp_id,?) 
//                     // and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//                     // and emp_id in 
//                     // (select emp_id from hrms.emp_information@web_to_hrms 
//                     // where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms 
//                     // where emp_id = '$uid') 
//                     // and valid='YES')
//                     // and rejected_id is null
//                     // and emp_id != '$uid'
//                     // and rsp_accept != 'NO'
//                     // and sup_accept != 'NO'
//                     // order by create_date desc", [$request->emp_id, $request->emp_id]);        


//                 // $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                 //     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                 //     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                 //     from mis.leave_emp_record
//                 //     where emp_id = decode( ?,'All',emp_id,?)
//                 //     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//                 //     and emp_id in
//                 //                 (select emp_id from hrms.emp_information@web_to_hrms
//                 //                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                 //                                 where emp_id = '$uid')
//                 //             and emp_id in ( select emp_id  from mis.leave_emp_info
//                 //                             where head_of_dept = '$uid'                                                      
//                 //                 and valid='YES')
//                 //     and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
//                 //                     where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                 //                     where emp_id = '$uid')
//                 //                     and valid='YES')            
//                 //     and rejected_id is null
//                 //     and emp_id != '$uid'
//                 //     and rsp_accept != 'NO'          
//                 //     union
//                 //     select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                 //     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                 //     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                 //     from mis.leave_emp_record
//                 //     where emp_id = decode( ?,'All',emp_id,?)
//                 //     and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')
//                 //     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//                 //     and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
//                 //                     where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                 //                     where emp_id = '$uid')
//                 //                     and valid='YES')
//                 //     and emp_id in ( select emp_id  from mis.leave_emp_info
//                 //                             where head_of_dept = '$uid'                 
//                 //     and rejected_id is null
//                 //     and emp_id != '$uid' 

//                 // ", [$request->emp_id, $request->emp_id,$request->emp_id, $request->emp_id]);       





// $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     from mis.leave_emp_record
//                     where emp_id = decode( ?,'All',emp_id,?)
//                     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')  
//                     and emp_id in ( select emp_id
//                         from mis.leave_emp_info
//                         where head_of_dept = '$uid' )       
//                     and rejected_id is null
//                     and emp_id != '$uid'
//                     and rsp_accept != 'NO'          
//                     union all
//                     select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     from mis.leave_emp_record
//                     where emp_id = decode( ?,'All',emp_id,?)
//                     and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')
//                     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//                     and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
//                                     where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                                     where emp_id = '$uid')
//                                     and valid='YES')
//                     and rejected_id is null
//                     and emp_id != '$uid' 

//                 ", [$request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id]);

//                 return response()->json($resp_data);





//               }

//         } else {


//             $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//             to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//             purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//             from mis.leave_emp_record 
//             where emp_id = decode( ?,'All',emp_id,?) 
//             and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//             and emp_id in 
        
//             and emp_id in ( select emp_id
//                                                 from mis.leave_emp_info
//                                                where head_of_dept = '$uid' ) 
//             and rejected_id is null
//             and rejected_id is null
//             and emp_id != '$uid'
//             and rsp_accept != 'NO'
//             order by create_date desc", [$request->emp_id, $request->emp_id]);


//         }


//         return response()->json($resp_data);
//     }



 public function getLeaveList(Request $request)
    {
        $uid = Auth::user()->user_id;
        $empDetails = DB::select("select trim(plant_id) plant_id from mis.leave_emp_info where emp_id = '$uid'");
        $plant_id = $empDetails[0]->plant_id;


        if ($plant_id != '1000') {

            /* ** Check Report Supervisor Absent ** */
            $x = DB::SELECT("SELECT distinct emp_id
                FROM leave_factory_rcm_user
                WHERE emp_id in (SELECT report_supervisor FROM mis.leave_emp_info WHERE emp_id = DECODE(?,'All',emp_id,?))", [$request->emp_id, $request->emp_id]);


//             if ($x[0]->emp_id != NULL) {



// //            if (!empty($x[0]->emp_id)) {

//                 $resp_data = DB::select("
                  
//                   select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
// purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// from mis.leave_emp_record 
// where emp_id = decode( ?,'All',emp_id,?) 
// and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and emp_id in 
// (select emp_id from hrms.emp_information@web_to_hrms 
// where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms 
//                 where emp_id = '$uid') 
// and emp_id in ( select emp_id
//                                                 from mis.leave_emp_info
//                                                 where head_of_dept = '$uid' )                  
// and valid='YES')
// and rejected_id is null
// and emp_id != '$uid'
// and rsp_accept != 'NO'

// union all

// select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
// purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// from mis.leave_emp_record
// where emp_id = decode( ?,'All',emp_id,?)
// and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and emp_id in
// (select emp_id from mis.leave_emp_info where mgt_status = 'NM' )
// and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
//                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                 where emp_id = '$uid')
//                 and valid='YES')

// and emp_id in ( select emp_id
//                                                 from mis.leave_emp_info
//                                                 where head_of_dept = '$uid' )                 

// and rejected_id is null
// and emp_id != '$uid'
// and rsp_accept != 'NO'



// union all

// select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
// purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// from mis.leave_emp_record
// where emp_id = decode( ?,'All',emp_id,?)
// and rejected_id is null
// and emp_id != '$uid'
// and head_of_dept_id = '$uid'  
// and plant_id !=  (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// and rsp_accept != 'NO'
// and sup_accept = 'YES' 


// union all 
                    
//                     select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     from mis.leave_emp_record
//                     where emp_id = decode( ?,'All',emp_id,?)
//                     and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')
//                     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')                    
//                     and emp_id in ( select emp_id
//                                                 from mis.leave_emp_info
//                                                 where head_of_dept = '$uid' )                                     
//                     and rejected_id is null
//                     and emp_id != '$uid' 
//                     and sup_accept = 'YES' 


// order by line_id desc
                  
//                   ", [$request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id]);

//                 return response()->json($resp_data);

//             } else {

//                 $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     from mis.leave_emp_record
//                     where emp_id = decode( ?,'All',emp_id,?)
//                     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')  
//                     and emp_id in ( select emp_id
//                         from mis.leave_emp_info
//                         where head_of_dept = '$uid' )       
//                     and rejected_id is null
//                     and emp_id != '$uid'
//                     and rsp_accept != 'NO'          
//                     union all
//                     select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//                     to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//                     purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//                     from mis.leave_emp_record
//                     where emp_id = decode( ?,'All',emp_id,?)
//                     and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')
//                     and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//                     and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
//                                     where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//                                     where emp_id = '$uid')
//                                     and valid='YES')
//                     and rejected_id is null
//                     and emp_id != '$uid' 

//                 ", [$request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id]);

//                 return response()->json($resp_data);

//             }


 // $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
 //                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
 //                    purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
 //                    from mis.leave_emp_record
 //                    where emp_id = decode( ?,'All',emp_id,?)
 //                    and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')  
 //                    and emp_id in ( select emp_id
 //                        from mis.leave_emp_info
 //                        where head_of_dept = '$uid' )       
 //                    and rejected_id is null
 //                    and emp_id != '$uid'
 //                    and rsp_accept != 'NO'          
 //                    union all
 //                    select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
 //                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
 //                    purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
 //                    from mis.leave_emp_record
 //                    where emp_id = decode( ?,'All',emp_id,?)
 //                    and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')
 //                    and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
 //                    and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
 //                                    where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
 //                                    where emp_id = '$uid')
 //                                    and valid='YES')
 //                    and rejected_id is null
 //                    and emp_id != '$uid' 

 //                ", [$request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id]);


$resp_data = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                    purpose_of_leave pol,rsp_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
                    from mis.leave_emp_record
                    where emp_id = decode( ?,'All',emp_id,?)
                   --and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')  
                    and emp_id in ( select emp_id
                        from mis.leave_emp_info
                        where head_of_dept = '$uid' )       
                    and rejected_id is null
                    and emp_id != '$uid'
                    and rsp_accept != 'NO'  
                    and ( sup_accept = 'YES' or rpt_supervisor_id in (select emp_id from mis.leave_factory_rcm_user) )  
                    and APP_STATUS = decode(?,'All',app_status,?)      
                    union all
                    select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                    purpose_of_leave pol,rsp_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
                    from mis.leave_emp_record
                    where emp_id = decode( ?,'All',emp_id,?)
                    and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')
                    --and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
                    and emp_id in ( select emp_id
                        from mis.leave_emp_info
                        where head_of_dept = '$uid' )                    
                    and rejected_id is null
                    and emp_id != '$uid' 
                    and ( sup_accept = 'YES' or rpt_supervisor_id in (select emp_id from mis.leave_factory_rcm_user) )
                    and APP_STATUS = decode(?,'All',app_status,?)

                ", [$request->emp_id, $request->emp_id,$request->a_status,$request->a_status, $request->emp_id, $request->emp_id,$request->a_status,$request->a_status]);

                return response()->json($resp_data);


        } else {


            /*$resp_data = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,sup_rejected_id,head_rejected_id,rcm_approved_date
            from mis.leave_emp_record 
            where emp_id = decode( '$request->emp_id','All',emp_id,'$request->emp_id') 
            and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
            and emp_id in 
            (select emp_id from hrms.emp_information@web_to_hrms 
            where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms 
            where emp_id = '$uid') 
            and valid='YES')
            and emp_id in ( select emp_id
                                                from mis.leave_emp_info
                                               where head_of_dept = '$uid' ) 
            and rejected_id is null
            and emp_id != '$uid'
            and rsp_accept != 'NO'
            and APP_STATUS = decode('$request->a_status','All',app_status,'$request->a_status')
            order by create_date desc");*/

            $resp_data = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,sup_rejected_id,head_rejected_id,rcm_approved_date
            from mis.leave_emp_record 
            where emp_id = decode( '$request->emp_id','All',emp_id,'$request->emp_id')             
            and emp_id in ( select emp_id
                                                from mis.leave_emp_info
                                               where head_of_dept = '$uid' ) 
            and rejected_id is null
            and emp_id != '$uid'
            and APP_STATUS = decode('$request->a_status','All',app_status,'$request->a_status')
            order by create_date desc");


            return response()->json($resp_data);
        }


    }



    

}