<?php


namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DepotPendingController extends Controller
{
    public function index()
    {
        return view('elm_portal.depot_pending');
    }

    public function getDepotLeave(Request $request)
    {
        $resp_data = DB::select("
                    select line_id,mis.leave_get_emp_plant_name(plant_id) plant_name ,emp_id,emp_name,emp_email,to_char(application_date,'DD-MON-RR') app_date,
                    to_char(leave_from,'DD-MON-RR') ||' To '||to_char(leave_to,'DD-MON-RR') lv_frm_to,type_of_leave,day_of_leave dol,rejected_id,
                    purpose_of_leave pol,rsp_accept,nvl(mis.leave_emp_name(rsp_emp_id),'NM') rsp_name,rpt_supervisor_id,mis.leave_emp_name(rpt_supervisor_id) sup_name ,
                    sup_accept,sup_rejected_id,head_rejected_id,rcm_approved_date,mis.leave_emp_name(head_of_dept_id) head_name , app_status head_status,status
                    from mis.leave_emp_record
                    where status = 'NO'  
                    and emp_id in ( select emp_id
                                    from mis.leave_emp_info
                                    where head_of_hr = ? )     
                    and rejected_id is null
                    and hr_rejected_id is null
                    and emp_id != ?
                    and rcm_approved_date is not null                    
        ", [$request->emp_id, $request->emp_id]);
        return response()->json($resp_data);
    }

    public function depotLeaveAccept(Request $request)
    {

        if ($request->ajax()) {


            $auth_name = Auth::user()->name;
            $auth_id = Auth::user()->user_id;
            $auth_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$auth_id]);
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $to_mail = $request->emp_email;

            $data = array('name' => $request->emp_name, 'auth_emp' => $auth_name);
            Mail::send(['text' => 'elm_portal.mail.leave_success_mail'], $data, function ($message) use ($to_mail, $auth_mail, $auth_name) {
                $message->to($to_mail, $to_mail)
                    ->subject('Leave Approved');
                $message->from($auth_mail[0]->mail_address, $auth_name);
            });


            $rs = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update(['STATUS' => 'YES', 'APP_STATUS' => 'YES', 'UPDATE_USER' => $auth_id]);
            if ($rs) {
                return response()->json(['success' => 'Successfully ! Application Accepted by User.']);
            } else {
                return response()->json(['error' => 'Please Contact Your Administrator.']);
            }


        }
    }

    public function depotLeaveReject(Request $request)
    {
        if ($request->ajax()) {


            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = $request->emp_email;
            $data = array('name' => $request->emp_name, 'reject_emp' => $auth_name);

            Mail::send(['text' => 'elm_portal.mail.sup_rejection_mail'], $data, function ($message) use ($to_mail, $frm_mail, $auth_name) {
                $message->to($to_mail, $to_mail)
                    ->subject('Leave  Reject');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });


            $rs = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update(['APP_STATUS' => 'YES', 'STATUS' => 'NO', 'HR_REJECTED_ID' => $uid, 'HR_REJECTED_DATE' => $sys_time, 'UPDATE_USER' => $uid]);
            if ($rs) {
                return response()->json(['success' => 'Successfully ! Application Rejected by User.']);
            } else {
                return response()->json(['error' => 'Please Contact Your Administrator.']);
            }


        }
    }
}