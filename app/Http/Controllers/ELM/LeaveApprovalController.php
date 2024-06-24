<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 07-Nov-18
 * Time: 3:29 PM
 * * Date: 26-DEC-18
 * Modify: Masroor
 * Time: 4:29 PM
 */

namespace App\Http\Controllers\ELM;

use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Log;

class LeaveApprovalController extends controller
{
    public function index()
    {
        $company = DB::select("select distinct com_id,com_name
        from hrms.company_info@WEB_TO_HRMS
        order by com_id ");
        return view('elm_portal/LeaveApproval', ['com' => $company]);
    }

    public function getPlant(Request $request)
    {
        $co_id = $request->c_id;
        $plant = DB::select("select distinct plant_id,plant_name 
                            from hrms.plant_info@WEB_TO_HRMS
                            where com_id=? order by plant_id", [$co_id]);
        return response()->json(
            ['plant' => $plant]
        );
    }

    public function getDept(Request $request)
    {

        $plant_id = $request->plant_id;
        $dept = DB::select("select distinct dept_id,dept_name 
                from hrms.dept_information@WEB_TO_HRMS
                where plant_id=?", [$plant_id]);
        return response()->json(
            ['dept' => $dept]
        );
    }

    public function listofLeave(Request $request)
    {
        $leave_record = DB::select("select line_id,emp_id,emp_name,emp_contact_no,emp_email,(TO_CHAR(leave_from,'DD-MM-YYYY') || ' to '|| TO_CHAR(leave_to,'DD-MM-YYYY')) dt,  
                            type_of_leave,day_of_leave, MIS.LEAVE_EMP_NAME(rpt_supervisor_id) recommended_by , MIS.LEAVE_EMP_NAME(head_of_dept_id) approved_by , status,hr_rejected_id,forward_emp, 
       medicalimages,maternityimage,sp_medicalimages
                            from mis.leave_emp_record
                            where plant_id='$request->plant_id'
                            and  emp_dept_id = decode('$request->dept_id','ALL',emp_dept_id,'$request->dept_id')
                            and rcm_approved_date is not null
                            and status = decode('$request->a_status','All',status,'$request->a_status')");

        return response()->json(
            ['leaverecord' => $leave_record]
        );
    }

    public function leaveAcceptance(Request $request)
    {
        $auth_id = Auth::user()->user_id;
        $line = $request->value_accept;
        
        try{
            $lq =DB::update("update mis.leave_emp_record 
                          set status='YES', app_status='YES', final_approved_by = '$auth_id'
                                            where line_id=?", [$line]);

            $auth_name = Auth::user()->name;
            $auth_id = Auth::user()->user_id;
            $auth_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$auth_id]);

            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

            $eemail = DB::select("select emp_email from mis.leave_emp_record where line_id = ?",[$line]);
            $to_mail = $eemail[0]->emp_email;

            $data = array('name' => $request->emp_name,'auth_emp' =>$auth_name);
            Mail::send(['text' => 'elm_portal.mail.leave_success_mail'], $data, function ($message) use($to_mail,$auth_mail,$auth_name) {
                $message->to($to_mail, 'Apply for Leave')
                    ->subject('Success Leave Approval');
                $message->from($auth_mail[0]->mail_address, $auth_name);
            });
        } catch (Oci8Exception $e) {
            $lq = $e->getMessage();
        }
        return response()->json($lq);
    }

    public function leaveRejection(Request $request)
    {
        $line = $request->value_reject;
        $uid = Auth::user()->user_id;
        try{
            $lq =db::update("update mis.leave_emp_record
                          set hr_rejected_id=?,app_status='YES',status = 'NO',hr_rejected_date=sysdate
                                            where line_id=?",[$uid,$line]);

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $eemail = DB::select("select emp_email from mis.leave_emp_record where line_id = ?",[$line]);
            $to_mail = $eemail[0]->emp_email;
            $data = array('name' => $request->emp_name,'reject_emp' =>$auth_name );

            Mail::send(['text' => 'elm_portal.mail.sup_rejection_mail'], $data, function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail, 'Test Mail')
                    ->subject('Leave Approved Reject');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });
        } catch (Oci8Exception $e) {
            $lq = $e->getMessage();
        }
        return response()->json($lq);
    }
}
