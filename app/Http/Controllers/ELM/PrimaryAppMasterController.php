<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 12/9/2018
 * Time: 11:28 AM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class PrimaryAppMasterController extends Controller
{
    public function index()
    {
        DB::setDateFormat('DD-MON-RR');

        $uid = Auth::user()->user_id;
        /*$emp_info = DB::select("select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        from hrms.emp_information@WEB_TO_HRMS
        where dept_id = (
        
        select dept_id
        from hrms.emp_information@WEB_TO_HRMS
        where emp_id = '$uid'
        and valid = 'YES'
        
        )
        and emp_id != '$uid'
        order by emp_id"); */

        $emp_info = DB::select("select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        from hrms.emp_information@WEB_TO_HRMS
        where emp_id in (
        
        select emp_id
        from mis.leave_emp_info
        where report_supervisor = '$uid'
        and valid = 'YES'
        
        )
        and emp_id != '$uid'
        order by emp_id");

        $appData = DB::select("select  distinct to_char(create_date,'RRRR') leave_year  
        from mis.leave_emp_record where create_date is not null
        order by to_char(create_date,'RRRR') desc"); 
        
        $emp_rcm = DB::SELECT(" SELECT distinct emp_id emp_id FROM mis.leave_factory_rcm_user WHERE emp_id = '$uid'");
        if ($emp_rcm){ $chk_val = 1;} else {$chk_val = 0;}

        return view('elm_portal/primary_aprv_master', ['emp_info' => $emp_info,'emp_rcm'=>$emp_rcm,'chk_val' =>$chk_val,'appData'=>$appData]);
    }

    public function getLeaveList(Request $request)
    {
        $uid = Auth::user()->user_id;
        $empDetails = DB::select("select trim(plant_id) plant_id from mis.leave_emp_info where emp_id = '$uid'");
        $plant_id = $empDetails[0]->plant_id;

        if ($plant_id != '1000') {

            $x = DB::SELECT("SELECT distinct emp_id
            FROM leave_factory_rcm_user
            WHERE emp_id in (SELECT report_supervisor FROM mis.leave_emp_info WHERE emp_id = DECODE(?,'All',emp_id,?))", [$request->emp_id, $request->emp_id]);
        if((!($plant_id == '1000') &&!($plant_id == '5000')) ){
            $resp_data =  DB::select( " 
                select * from
                (
                select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
                from mis.leave_emp_record
                where emp_id = decode( ?,'All',emp_id,?)   
                and sup_rejected_id is null 
                and emp_id in ( select emp_id
                from mis.leave_emp_info
                where report_supervisor = '$uid' )       
                and rejected_id is null
                and emp_id != '$uid'
                and rsp_accept != 'NO' 
                and sup_accept = decode(?,'All',sup_accept,?)   
                and to_char(leave_from,'YYYY') = ?                                     
                union 
                select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
                from mis.leave_emp_record
                where emp_id = decode( ?,'All',emp_id,?)      
                and sup_rejected_id is null 
                and emp_id in ( select emp_id
                from mis.leave_emp_info
                where report_supervisor = '$uid' and mgt_status = 'NM' )                    
                and rejected_id is null
                and emp_id != '$uid'
                and sup_accept = decode(?,'All',sup_accept,?)
                and to_char(leave_from,'RRRR') = ?
                )
                order by create_date desc", [$request->emp_id, $request->emp_id, $request->a_status, $request->a_status,$request->req_year,
                $request->emp_id, $request->emp_id,$request->a_status,$request->a_status, $request->req_year]);

            return response()->json($resp_data);
        }else{
            $resp_data =  DB::select( " 
    
                select * from
                (
                select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
                from mis.leave_emp_record
                where emp_id = decode( ?,'All',emp_id,?)      
                and sup_rejected_id is null 
                and emp_id in ( select emp_id
                from mis.leave_emp_info
                where report_supervisor = '$uid' )       
                and rejected_id is null
                and emp_id != '$uid'
                and rsp_accept != 'NO' 
                and sup_accept = decode(?,'All',sup_accept,?)   
                and to_char(leave_from,'YYYY') = ?                                     
                union 
                select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
                from mis.leave_emp_record
                where emp_id = decode( ?,'All',emp_id,?)
                and sup_rejected_id is null 
                --and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')                  
                and emp_id in ( select emp_id
                from mis.leave_emp_info
                where report_supervisor = '$uid' )                    
                and rejected_id is null
                and emp_id != '$uid'
                and rsp_accept = 'YES' 
                and sup_accept = decode(?,'All',sup_accept,?)
                and to_char(leave_from,'RRRR') = ?
                )
                order by create_date desc", [$request->emp_id, $request->emp_id, $request->a_status, $request->a_status,$request->req_year,
                $request->emp_id, $request->emp_id,$request->a_status,$request->a_status, $request->req_year]);



                return response()->json($resp_data);
        }} else {

            $resp_data = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name, emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
             from mis.leave_emp_record
             where emp_id = decode( ?,'All',emp_id,?)  
            and sup_rejected_id is null 
             and emp_id in ( select emp_id
            from mis.leave_emp_info
            where report_supervisor = '$uid' )
             and rejected_id is null
             and emp_id != '$uid'
             and sup_accept = decode(?,'All',sup_accept,?)
             and to_char(leave_from,'RRRR') = ?
             order by create_date desc", [$request->emp_id, $request->emp_id,$request->a_status,$request->a_status,$request->req_year]);

        }
        return response()->json($resp_data);
    }
// public function getLeaveList(Request $request)
//     {

        

//         $uid = Auth::user()->user_id;
//         $empDetails = DB::select("select trim(plant_id) plant_id from mis.leave_emp_info where emp_id = '$uid'");
//         $plant_id = $empDetails[0]->plant_id;

//         if ($plant_id != '1000') {



//             $x = DB::SELECT("SELECT distinct emp_id
//             FROM leave_factory_rcm_user
//             WHERE emp_id in (SELECT report_supervisor FROM mis.leave_emp_info WHERE emp_id = DECODE(?,'All',emp_id,?))", [$request->emp_id, $request->emp_id]);

// //             if ($x != NULL) {


// //                 $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// //                 to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,day_of_leave dol,rejected_id,
// //                 purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// //                 from mis.leave_emp_record
// //                 where emp_id = decode( ?,'All',emp_id,?)
// //                 and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// //                 and emp_id in
// //                 (select emp_id from hrms.emp_information@web_to_hrms
// //                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
// //                                 where emp_id = '$uid')
// //                 and emp_id in ( select emp_id
// //                                                 from mis.leave_emp_info
// //                                                 where report_supervisor = '$uid' )                                 
// //                 and valid='YES')
// //                 and rejected_id is null
// //                 and emp_id != '$uid'
// //                 and rsp_accept != 'NO'
                
// //                 union
// //                 select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// //                 to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,day_of_leave dol,rejected_id,
// //                 purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// //                 from mis.leave_emp_record
// //                 where emp_id = decode( ?,'All',emp_id,?)
// //                 and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// //                 and emp_id in
// //                 (select emp_id from mis.leave_emp_info where mgt_status = 'NM' )
// //                 and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// //                 and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
// //                                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
// //                                 where emp_id = '$uid')
// //                                 and valid='YES')
// //                 and emp_id in ( select emp_id
// //                                                 from mis.leave_emp_info
// //                                                 where report_supervisor = '$uid' )                   
// //                 and rejected_id is null
// //                 and emp_id != '$uid' 
                
// //                 union all

// //                 select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// //                 to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,day_of_leave dol,rejected_id,
// //                 purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// //                 from mis.leave_emp_record
// //                 where emp_id = decode( ?,'All',emp_id,?)
// //                 and rejected_id is null
// //                 and emp_id != '$uid'
// //                 and rpt_supervisor_id = '$uid'  
// //                 and plant_id !=  (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// //                 and emp_id in ( select emp_id
// //                                                 from mis.leave_emp_info
// //                                                 where report_supervisor = '$uid' )   
// //                 and rsp_accept != 'NO'
                   
// //                 order by line_id desc"
// //                     , [$request->emp_id, $request->emp_id,$request->emp_id, $request->emp_id,$request->emp_id, $request->emp_id]);


// // //                return response()->json($resp_data);


// //             } else {

// //                    $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// //                 to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,day_of_leave dol,rejected_id,
// //                 purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// //                 from mis.leave_emp_record
// //                 where emp_id = decode( ?,'All',emp_id,?)
// //                 and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// //                 and emp_id in
// //                 (select emp_id from hrms.emp_information@web_to_hrms
// //                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
// //                 where emp_id = '$uid')
// //                 and emp_id in ( select emp_id
// //                                                 from mis.leave_emp_info
// //                                                 where report_supervisor = '$uid' ) 
// //                 and valid='YES')
// //                 and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
// //                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
// //                 where emp_id = '$uid')
// //                 and valid='YES') 
// //                 and rejected_id is null
// //                 and emp_id != '$uid'
// //                 and rsp_accept != 'NO'          
// //                 union
// //                 select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
// //                 to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,day_of_leave dol,rejected_id,
// //                 purpose_of_leave pol,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
// //                 from mis.leave_emp_record
// //                 where emp_id = decode( ?,'All',emp_id,?)
// //                 and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// //                 and emp_id in
// //                 (select emp_id from mis.leave_emp_info where mgt_status = 'NM' )
// //                 and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
// //                 and emp_dept_id = (select distinct dept_id from hrms.emp_information@web_to_hrms
// //                                 where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
// //                                 where emp_id = '$uid')
// //                                 and valid='YES')
// //                 and emp_id in ( select emp_id
// //                                                 from mis.leave_emp_info
// //                                                 where report_supervisor = '$uid' )                 
// //                 and rejected_id is null
// //                 and emp_id != '$uid' 

// //                 ", [$request->emp_id, $request->emp_id,$request->emp_id, $request->emp_id]);
                



// //             }


// if(
//     (
//         !($plant_id == '1000') &&
//         // !($plant_id == '1100') &&
//         // !($plant_id == '2100') &&
//         // !($plant_id == '1300') &&
//         // !($plant_id == '1400') &&
//         // !($plant_id == '2200') &&
//         // !($plant_id == '4100') &&
//         // !($plant_id == '5100') &&
//         !($plant_id == '5000')
//     )
//     ){
//         $resp_data =  DB::select( " 

//             select * from
//             (
//             select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//             to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//             purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
//             from mis.leave_emp_record
//             where emp_id = decode( ?,'All',emp_id,?)                   
//             and emp_id in ( select emp_id
//             from mis.leave_emp_info
//             where report_supervisor = '$uid' )       
//             and rejected_id is null
//             and emp_id != '$uid'
//             and rsp_accept != 'NO' 
//             and sup_accept = decode(?,'All',sup_accept,?)   
//             and to_char(leave_from,'YYYY') = ?                                     
//             union 
//             select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//             to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//             purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
//             from mis.leave_emp_record
//             where emp_id = decode( ?,'All',emp_id,?)            
//             and emp_id in ( select emp_id
//             from mis.leave_emp_info
//             where report_supervisor = '$uid' and mgt_status = 'NM' )                    
//             and rejected_id is null
//             and emp_id != '$uid'
//             and sup_accept = decode(?,'All',sup_accept,?)
//             and to_char(leave_from,'RRRR') = ?
//             )
//             order by create_date desc", [$request->emp_id, $request->emp_id, $request->a_status, $request->a_status,$request->req_year,
//             $request->emp_id, $request->emp_id,$request->a_status,$request->a_status, $request->req_year]);

//         return response()->json($resp_data);
//     }else{
//         $resp_data =  DB::select( " 

//             select * from
//             (
//             select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//             to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//             purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
//             from mis.leave_emp_record
//             where emp_id = decode( ?,'All',emp_id,?)                   
//             and emp_id in ( select emp_id
//             from mis.leave_emp_info
//             where report_supervisor = '$uid' )       
//             and rejected_id is null
//             and emp_id != '$uid'
//             and rsp_accept != 'NO' 
//             and sup_accept = decode(?,'All',sup_accept,?)   
//             and to_char(leave_from,'YYYY') = ?                                     
//             union 
//             select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//             to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//             purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,create_date
//             from mis.leave_emp_record
//             where emp_id = decode( ?,'All',emp_id,?)
//             --and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')                  
//             and emp_id in ( select emp_id
//             from mis.leave_emp_info
//             where report_supervisor = '$uid' )                    
//             and rejected_id is null
//             and emp_id != '$uid'
//             and rsp_accept = 'YES' 
//             and sup_accept = decode(?,'All',sup_accept,?)
//             and to_char(leave_from,'RRRR') = ?
//             )
//             order by create_date desc", [$request->emp_id, $request->emp_id, $request->a_status, $request->a_status,$request->req_year,
//             $request->emp_id, $request->emp_id,$request->a_status,$request->a_status, $request->req_year]);



//             return response()->json($resp_data);
//     }

//         } else {


//             /*$resp_data = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
//             to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//             purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//             from mis.leave_emp_record
//             where emp_id = decode( ?,'All',emp_id,?)
//             and plant_id = (select plant_id from mis.leave_emp_info where emp_id = '$uid')
//             and emp_id in
//             (select emp_id from hrms.emp_information@web_to_hrms
//             where dept_id =(select dept_id from  hrms.emp_information@web_to_hrms
//             where emp_id = '$uid')
//             and emp_id in ( select emp_id
//                                                     from mis.leave_emp_info
//                                                     where report_supervisor = '$uid' ) 
//             and valid='YES')
//             and rejected_id is null
//             and emp_id != '$uid'
//             and rsp_accept != 'NO'
//             and sup_accept = decode(?,'All',sup_accept,?)
//             order by create_date desc", [$request->emp_id, $request->emp_id,$request->a_status,$request->a_status]);*/


//             $resp_data = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name, emp_email,to_char(application_date,'DD-MON-RR') app_date,
//             to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
//             purpose_of_leave pol,rsp_emp_id,rsp_emp_name,rsp_accept,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
//              from mis.leave_emp_record
//              where emp_id = decode( ?,'All',emp_id,?)            
//              and emp_id in ( select emp_id
//                                                     from mis.leave_emp_info
//                                                     where report_supervisor = '$uid' )
//              and rejected_id is null
//              and emp_id != '$uid'
//              and sup_accept = decode(?,'All',sup_accept,?)
//              and to_char(leave_from,'RRRR') = ?
//              order by create_date desc", [$request->emp_id, $request->emp_id,$request->a_status,$request->a_status,$request->req_year]);

//         }


//         return response()->json($resp_data);
//     }

    public function priAccept(Request $request)
    {

        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update([
                    'SUP_ACCEPT' => 'YES',
                    'SUP_ACCEPT_DATE' => $sys_time,
                    'UPDATE_USER' => $uid
                ]);
        }

        if ($suc) {

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $frm_mail = DB::select("select mail_address,contact_no from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = DB::select("select emp_id,emp_email,INITCAP(emp_name) emp_name from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            $data = array('accpt_emp' => $auth_name,'emp_name'=>$to_mail[0]->emp_name);
            Mail::send(['text' => 'elm_portal.mail.sup_accept'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail[0]->emp_email, $to_mail[0]->emp_email)
                    ->subject('Leave Application');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });   



            //TEST PLANT for primary to secondary mail  

            $to_mail_t = $to_mail[0]->emp_email;
            $to_mail_name_t = $to_mail[0]->emp_name;  
            $emp_id = $to_mail[0]->emp_id;   
            
            
            // Log::info($request->all());
            // Log::info($emp_id);
            
            $head_mail = DB::select("select distinct mail_address
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(head_of_dept)
                                    from leave_emp_info
                                    where emp_id = '$emp_id')
                                ");

            $plantId = DB::select("select plant_id from leave_emp_info where emp_id = '$emp_id'");

            Log::info($plantId);

            if( $head_mail[0]->mail_address != 'ehsan@inceptapharma.com' ) {

                $hm = $head_mail[0]->mail_address;

                if($plantId[0]->plant_id != 1000){
                    //mail for department head
                    $app_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/headapproval/'.$emp_id.'/'.$request->line_id,
                    'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/headapproval/'.$emp_id.'/'.$request->line_id,
                    'accpt_emp' =>$auth_name, 'mob_no' => $frm_mail[0]->contact_no ,'application_user' => $to_mail_name_t  );
                    $head_emails = [];
                    array_push( $head_emails, $hm);
                    Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use($head_emails,$to_mail_t,$to_mail_name_t) {
                    $message->to($head_emails, 'Mail')
                        ->subject('Leave Application');
                    $message->from($to_mail_t, $to_mail_name_t);
                    });
                }

               
            }




        }
        return response()->json(['success' => 'Record Save Successfully']);

    }

    public function priReject(Request $request)
    {

        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update([
                    'SUP_REJECTED_ID' => $uid,
                    'SUP_REJECTED_DATE' => $sys_time,
                    'APP_STATUS'=>'YES'
            ]);
        }

        if ($suc) {

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = DB::select("select emp_email,INITCAP(emp_name) emp_name from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            $data = array('accpt_emp' => $auth_name,'name'=> $to_mail[0]->emp_name);
            Mail::send(['text' => 'elm_portal.mail.rejected_mail'], $data,  function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail[0]->emp_email, $to_mail[0]->emp_email)
                    ->subject('Leave Application');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        }
    }

//     public function mastereappupdateApplication(Request $request)
//     {




//         $box = $request->all();
//         $myValue=  array();
//         parse_str($box['data'], $myValue);

// //        return response()->json( $myValue);
// //        return response()->json( $myValue );
// //        return response()->json( $myValue['st_dt'] );

//         if(empty($myValue['rsp_emp_code'])){
//             $suc = LeaveEmpRecord::where('line_id', $myValue['line_id'])
//                 ->update([
//                     'leave_from' => Carbon::parse(trim($myValue['st_dt']))->format('Y-m-d'),
//                     'leave_to' => Carbon::parse(trim($myValue['en_dt']))->format('Y-m-d'),
//                     'day_of_leave' => $myValue['dol'],
//                     'type_of_leave' => $myValue['tol'],
//                     'add_during_leave' => $myValue['adl'],
//                     'emp_contact_no' => $myValue['mob'],
//                     'emp_email' => $myValue['email'],
//                     'purpose_of_leave' => $myValue['pol']
//                 ]);
//         }else{
//             $suc = LeaveEmpRecord::where('line_id', $myValue['line_id'])
//                 ->update([
//                     'leave_from' => Carbon::parse(trim($myValue['st_dt']))->format('Y-m-d'),
//                     'leave_to' => Carbon::parse(trim($myValue['en_dt']))->format('Y-m-d'),
//                     'day_of_leave' => $myValue['dol'],
//                     'type_of_leave' => $myValue['tol'],
//                     'add_during_leave' => $myValue['adl'],
//                     'emp_contact_no' => $myValue['mob'],
//                     'emp_email' => $myValue['email'],
//                     'purpose_of_leave' => $myValue['pol'],
//                     'rsp_emp_id' => $myValue['rsp_emp_code'],
//                     'rsp_emp_name' => $myValue['rsp_emp_name'],
//                     'rsp_desig_id' => $myValue['rsp_desig_id'],
//                     'rsp_desig_name' => $myValue['rsp_desig_name'],
//                     'rsp_dept_id' => $myValue['rsp_dept_id'],
//                     'rsp_contact_no' => $myValue['rsp_cnt_no'],
//                     'rsp_email' => $myValue['rsp_email'],
//                     'rsp_duties' => $myValue['rsp_duties'],
//                 ]);
//         }



//         if ($suc) {

//             $line_id = $myValue['line_id'];
//             $auth_name = Auth::user()->name;
//             $auth_id = Auth::user()->user_id;

//             $nm = DB::select ("SELECT mgt_status
//             FROM mis.LEAVE_EMP_INFO
//             WHERE emp_id =  (SELECT emp_id FROM mis.leave_emp_record WHERE line_id = '$line_id')");

//             $mgt_st = $nm[0]->mgt_status;

//             if($mgt_st != 'NM') {
//                 $auth_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$auth_id]);
//                 $applicant_name = DB::select("select emp_name from mis.leave_emp_record where line_id = ?", [$myValue['line_id']]);
//                 $appli_name = $applicant_name[0]->emp_name;
//                 $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$myValue['rsp_emp_code']]);
//                 $datax = array('sup_emp' => $auth_name, 'app_user' => $appli_name);

//                 // $applicant_emails = $myValue['email'];
//                 // Mail::send(['text' => 'elm_portal.mail.applicant_notify_change'], $datax, function ($message) use ($auth_mail, $frm_mail, $auth_name) {
//                 //     $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
//                 //         ->subject('Leave Application');
//                 //     $message->from($auth_mail[0]->mail_address, $auth_name);
//                 // });

//                 // old rsp notificaton for change
//                 // $mail_to = $myValue['rsp_oldemail'];
//                 // $data = array('app_emp' => $auth_name);
//                 // $applicant_emails = $myValue['email'];
//                 // Mail::send(['text' => 'elm_portal.mail.rsp_change_notify'], $data, function ($message) use ($auth_mail, $mail_to, $auth_name) {
//                 //     $message->to($mail_to, $mail_to)
//                 //         ->subject('Request For Changing Responsible Duties.');
//                 //     $message->from($auth_mail[0]->mail_address, $auth_name);
//                 // });

//             }
//             return response()->json(['success' => 'Record Save Successfully.']);

//         }else {
//             return response()->json(['error' => 'Error in database']);

//         }
//     }


public function mastereappupdateApplication(Request $request)
    {

        $box = $request->all();
        $myValue = array();
        parse_str($box['data'], $myValue);

        $line_path = "";
        $maternityImage_path = "";

        if ($myValue['tol'] == 'MATERNITY') {
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $extension = $files[0]->getClientOriginalName();
                $filename = $request->emp_id . '_medical-photo-' . time() . '.' . $extension;
                $image_resize = Image::make($files[0]->getRealPath());
                $image_resize->resize(492, 484);
                $image_resize->save(public_path('/medicalImage/' . $filename));
                $maternityImage_path = '/medicalImage/' . $filename;
            }
        } else {
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $extension = $files[0]->getClientOriginalName();
                $filename = $request->emp_id . '_medical-photo-' . time() . '.' . $extension;
                $image_resize = Image::make($files[0]->getRealPath());
                $image_resize->resize(492, 484);
                $image_resize->save(public_path('/medicalImage/' . $filename));
//            $path = $file->move(public_path() . '/medicalImage/', $filename);
                $line_path = '/medicalImage/' . $filename;
            }
        }
//        return response()->json( $myValue );
//        return response()->json( $myValue['st_dt'] );

//        Log::info($myValue);
//        Log::info($myValue);


        if (empty($myValue['rsp_emp_code'])) {
            $suc = LeaveEmpRecord::where('line_id', $myValue['line_id'])
                ->update([
                    'leave_from' => Carbon::parse(trim($myValue['st_dt']))->format('Y-m-d'),
                    'leave_to' => Carbon::parse(trim($myValue['en_dt']))->format('Y-m-d'),
                    'day_of_leave' => $myValue['dol'],
                    'type_of_leave' => $myValue['tol'],
                    'add_during_leave' => $myValue['adl'],
                    'emp_contact_no' => $myValue['mob'],
                    'emp_email' => $myValue['email'],
                    'purpose_of_leave' => $myValue['pol']
                ]);
        } else {
            $suc = LeaveEmpRecord::where('line_id', $myValue['line_id'])
                ->update([
                    'leave_from' => Carbon::parse(trim($myValue['st_dt']))->format('Y-m-d'),
                    'leave_to' => Carbon::parse(trim($myValue['en_dt']))->format('Y-m-d'),
                    'day_of_leave' => $myValue['dol'],
                    'type_of_leave' => $myValue['tol'],
                    'add_during_leave' => $myValue['adl'],
                    'emp_contact_no' => $myValue['mob'],
                    'emp_email' => $myValue['email'],
                    'purpose_of_leave' => $myValue['pol'],
                    'rsp_emp_id' => $myValue['rsp_emp_code'],
                    'rsp_emp_name' => $myValue['rsp_emp_name'],
                    'rsp_desig_id' => $myValue['rsp_desig_id'],
                    'rsp_desig_name' => $myValue['rsp_desig_name'],
                    'rsp_dept_id' => $myValue['rsp_dept_id'],
                    'rsp_contact_no' => $myValue['rsp_cnt_no'],
                    'rsp_email' => $myValue['rsp_email'],
                    'rsp_duties' => $myValue['rsp_duties']
                ]);
        }

        if($line_path != ""){
            $suc1 = LeaveEmpRecord::where('line_id', $myValue['line_id'])
                ->update([
                    'medicalimages' => $line_path
                ]);
        }

        if($maternityImage_path != ""){
            $suc2 = LeaveEmpRecord::where('line_id', $myValue['line_id'])
                ->update([
                    'maternityimage' => $maternityImage_path
                ]);
        }

        if ($suc) {

            $line_id = $myValue['line_id'];
            $auth_name = Auth::user()->name;
            $auth_id = Auth::user()->user_id;

            $nm = DB::select("SELECT mgt_status
            FROM mis.LEAVE_EMP_INFO
            WHERE emp_id =  (SELECT emp_id FROM mis.leave_emp_record WHERE line_id = '$line_id')");

            $mgt_st = $nm[0]->mgt_status;

            if ($mgt_st != 'NM') {
                $auth_mail = DB::select("select distinct mail_address from mis.leave_emp_info where emp_id = ?", [$auth_id]);
                $applicant_name = DB::select("select distinct emp_name from mis.leave_emp_record where line_id = ?", [$myValue['line_id']]);
                $appli_name = $applicant_name[0]->emp_name;
                $frm_mail = DB::select("select distinct mail_address from mis.leave_emp_info where emp_id = ?", [$myValue['rsp_emp_code']]);
                $datax = array('sup_emp' => $auth_name, 'app_user' => $appli_name);

                $applicant_emails = $myValue['email'];
//                Mail::send(['text' => 'elm_portal.mail.applicant_notify_change'], $datax, function ($message) use ($auth_mail, $frm_mail, $auth_name) {
//                    $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
//                        ->subject('Leave Application');
//                    $message->from($auth_mail[0]->mail_address, $auth_name);
//                });

                // old rsp notificaton for change
//                $mail_to = $myValue['rsp_oldemail'];
//                $data = array('app_emp' => $auth_name);
//                $applicant_emails = $myValue['email'];
//                Mail::send(['text' => 'elm_portal.mail.rsp_change_notify'], $data, function ($message) use ($auth_mail, $mail_to, $auth_name) {
//                    $message->to($mail_to, $mail_to)
//                        ->subject('Request For Changing Responsible Duties.');
//                    $message->from($auth_mail[0]->mail_address, $auth_name);
//                });

            }
            return response()->json(['success' => 'Record Save Successfully.']);

        } else {
            return response()->json(['error' => 'Error in database']);

        }
    }

    public function mImageDelete(Request $request)
    {
        $box = $request->all();
        $myValue = array();
        parse_str($box['data'], $myValue);


        $record = DB::table('mis.leave_emp_record')
            ->where('line_id', $myValue['line_id'])
            ->get();

    

        $suc = LeaveEmpRecord::where('line_id', $myValue['line_id'])
            ->update([
                'medicalimages' => ''
            ]);

        $s = unlink(public_path() . $record[0]->medicalimages);

        if ($s) {
            return response()->json(['success' => 'Image Deleted Successfully.']);
        } else {
            return response()->json(['error' => 'Error in database']);
        }
    }

}