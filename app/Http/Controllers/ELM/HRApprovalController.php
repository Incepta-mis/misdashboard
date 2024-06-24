<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 12/1/2018
 * Time: 4:38 PM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HRApprovalController extends Controller
{
    public function index(Request $request){
        // $appData = DB::select("select line_id,emp_id,emp_name,emp_dept_name,emp_email,application_date,application_date,leave_from,
        //     leave_to,day_of_leave,rejected_id,purpose_of_leave,type_of_leave,rsp_accept,sup_accept,head_rejected_id,sup_rejected_id,
        //     hr_rejected_id,status,MIS.LEAVE_EMP_NAME(head_of_dept_id) rcm_name,rcm_approved_date,status
        //  from mis.leave_emp_record where emp_id = ? 
        //  and line_id = ?
        //  and rejected_id is null
        //  order by create_date desc", [$request->id,$request->lineid]);

        

        $appData = DB::select("select line_id,emp_id,emp_name,mis.leave_get_emp_plant_name(plant_id) plant_name,emp_dept_name,emp_email,application_date,application_date,leave_from,
            leave_to,day_of_leave,rejected_id,purpose_of_leave,type_of_leave,rsp_accept,sup_accept,head_rejected_id,sup_rejected_id,
            hr_rejected_id,status,MIS.LEAVE_EMP_NAME(head_of_dept_id) rcm_name,rcm_approved_date,status
         from mis.leave_emp_record where emp_id = ?
         and line_id = ?
         and rejected_id is null
         order by create_date desc", [$request->id,$request->lineid]);

//        $mgt_status = $appData[0]->emp_id;

        $nm_st = DB::select(" SELECT mgt_status
        FROM mis.LEAVE_EMP_INFO
        WHERE emp_id = ? ",[$request->id]);

        return view('elm_portal.hr_approval',['appData' => $appData,'mgt_status' => $nm_st[0]->mgt_status]);
    }

    public function appl_hr_confirmation (Request $request){


        if($request->ajax()){

//             return response()->json($request->all());
            // return response()->json($request->emp_email);
            // return response()->json( $frm_mail[0]->mail_address);


            $auth_name = Auth::user()->name;
            $auth_id = Auth::user()->user_id;
            $auth_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$auth_id]);

            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');


            $to_mail = $request->emp_email;


            $data = array('name' => $request->emp_name,'auth_emp' =>$auth_name);
            Mail::send(['text' => 'elm_portal.mail.leave_success_mail'], $data, function ($message) use($to_mail,$auth_mail,$auth_name) {
                $message->to($to_mail, 'Apply for Leave')
                    ->subject('Leave Approved');
                $message->from($auth_mail[0]->mail_address, $auth_name);
            });



            if($request->accept_val == '1'){
                LeaveEmpRecord::where('emp_id',$request->emp_id )
                    ->where('line_id',$request->line_id )
                    ->update(['STATUS'=>'YES','APP_STATUS'=>'YES','UPDATE_USER' => $auth_id]);


            // $procedureName = 'P_LEAVE_PROCESS';
            // $result = DB::executeProcedure($procedureName);

                return response()->json(['success'=>'Successfully ! Application Accepted by User.']);
            }
        }
    }

    public function appl_hr_rejection (Request $request){


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
                $message->to($to_mail, 'Leave Application')
                    ->subject('Leave Reject');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });



            if($request->reject_val == '0'){
                LeaveEmpRecord::where('emp_id',$request->emp_id )
                    ->where('line_id',$request->line_id )
                    ->update(['APP_STATUS'=>'YES','STATUS'=>'YES','HR_REJECTED_ID'=>$uid,'HR_REJECTED_DATE' => $sys_time,'UPDATE_USER' => $uid]);
                return response()->json(['success'=>'Successfully ! Application Rejected by User.']);
            }
        }
    }


}