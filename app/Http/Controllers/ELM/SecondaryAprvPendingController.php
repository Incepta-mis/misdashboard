<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/13/2019
 * Time: 9:07 AM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SecondaryAprvPendingController extends Controller
{
    public function index()
    {

//        DB::setDateFormat('DD-MON-RR');
        $uid = Auth::user()->user_id;

        $emp_info = DB::select("
        select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
                        from hrms.emp_information@WEB_TO_HRMS
                        where emp_id in (                        
                         select emp_id 
                         from mis.leave_emp_info
                         where head_of_dept = '$uid'                                                      
                         and valid='YES')
        
        ");

//        dd($emp_info);

        return view('elm_portal.secondary_aprv_pending', ['emps' => $emp_info]);

    }

    public function getLeaveList(Request $request)
    {
        $uid = Auth::user()->user_id;
        $empDetails = DB::select("select trim(plant_id) plant_id from mis.leave_emp_info where emp_id = '$uid'");
        $plant_id = $empDetails[0]->plant_id;


//        Log::info($plant_id);

        if ($plant_id != '1000') {

            /* ** Check Report Supervisor Absent ** */
            $x = DB::SELECT("SELECT distinct emp_id
                FROM leave_factory_rcm_user
                WHERE emp_id in (SELECT report_supervisor FROM mis.leave_emp_info WHERE emp_id = DECODE(?,'All',emp_id,?))", [$request->emp_id, $request->emp_id]);


           /* $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                    purpose_of_leave pol,rsp_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
                    from mis.leave_emp_record
                    where emp_id = decode( ?,'All',emp_id,?)     
                    and rejected_id is null
                    and emp_id != '$uid'
                    and rsp_accept != 'NO'  
                    and rcm_approved_date is null
                    and ( sup_accept = 'YES' or rpt_supervisor_id in (select emp_id from mis.leave_factory_rcm_user) )        
                    union all
                    select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
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
                    and rcm_approved_date is null
                    and ( sup_accept = 'YES' or rpt_supervisor_id in (select emp_id from mis.leave_factory_rcm_user) )

                ", [$request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id]); */

                $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                    purpose_of_leave pol,rsp_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
                    from mis.leave_emp_record
                    where emp_id = decode( ?,'All',emp_id,?)  
                    and emp_id in ( select emp_id
                                                from mis.leave_emp_info
                                               where head_of_dept = '$uid' )     
                    and rejected_id is null
                    and emp_id != '$uid'
                    and rsp_accept != 'NO'  
                    and rcm_approved_date is null
                    and ( sup_accept = 'YES' or rpt_supervisor_id in (select emp_id from mis.leave_factory_rcm_user) )        
                    union all
                    select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                    purpose_of_leave pol,rsp_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name,sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date
                    from mis.leave_emp_record
                    where emp_id = decode( ?,'All',emp_id,?)
                    and emp_id in ( select emp_id
                                                from mis.leave_emp_info
                                               where head_of_dept = '1000379' ) 
                    and emp_id in (select emp_id from mis.leave_emp_info where mgt_status = 'NM')                                       
                    and rejected_id is null
                    and emp_id != '$uid' 
                    and emp_id in ( select emp_id
                            from mis.leave_emp_info
                           where head_of_dept = '$uid' ) 
                    and rcm_approved_date is null
                    and ( sup_accept = 'YES' or rpt_supervisor_id in (select emp_id from mis.leave_factory_rcm_user) )

                ", [$request->emp_id, $request->emp_id, $request->emp_id, $request->emp_id]);

            return response()->json($resp_data);


        } else {


            /*$resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,sup_rejected_id,head_rejected_id,rcm_approved_date
            from mis.leave_emp_record 
            where emp_id = decode( ?,'All',emp_id,?) 
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
            and rcm_approved_date is null
            order by create_date desc", [$request->emp_id, $request->emp_id]); */

            $resp_data = DB::select("select line_id,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
            to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
            purpose_of_leave pol,rsp_accept,rpt_supervisor_id,MIS.LEAVE_EMP_NAME(rpt_supervisor_id) sup_name ,sup_accept,nvl(MIS.LEAVE_EMP_NAME(rsp_emp_id),'NM') rsp_name,sup_rejected_id,head_rejected_id,rcm_approved_date
            from mis.leave_emp_record 
            where emp_id = decode( ?,'All',emp_id,?)            
            and emp_id in ( select emp_id
                                                from mis.leave_emp_info
                                               where head_of_dept = '$uid' ) 
            and rejected_id is null
            and emp_id != '$uid'
            and rcm_approved_date is null
            order by create_date desc", [$request->emp_id, $request->emp_id]);


            return response()->json($resp_data);
        }


    }


}