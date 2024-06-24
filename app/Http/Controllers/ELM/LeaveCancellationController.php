<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/29/2019
 * Time: 10:40 AM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LeaveCancellationController extends Controller
{
    public function index(){

        $auth_id = Auth::user()->user_id;
        $employees = DB::select(
        "
          select distinct emp_id
          from leave_emp_info
          where head_of_dept = '$auth_id'
        "
        );

        return view('elm_portal.leave_cancellation',['employees' => $employees ]);
    }

    public function getEmployeesLeave(Request $request){

        $empLeave =  DB::select("
        select plant_id,emp_id,emp_name, emp_dept_name,to_char(leave_from,'DD-MON-RR') ||' to '|| to_char(leave_to,'DD-MON-RR') Leave, type_of_leave, purpose_of_leave
        from leave_emp_record
        where emp_id = '$request->emp_id'
        and line_id = (select max(line_id) from leave_emp_record where emp_id = '$request->emp_id' )
        
        ");

        return response()->json($empLeave);
    }

    public function LvCancelReq(Request $request){

        $mgr_info = DB::select("select emp.mail_address mgr_email, INITCAP( manager.sur_name) mgr_name,
                                      (select initcap(desig_name) desig_name from hrms.emp_designation@web_to_hrms                                       
                                       where desig_id = manager.desig_id) mgr_desig
                                from mis.leave_emp_info emp join hrms.emp_information@web_to_hrms manager
                                ON  (emp.emp_id = manager.emp_id)
                                where emp.emp_id =  ?", [$request->mgr_id]);
        if($request->plant_id == '1000'){
            $to_mail = array();
            array_push($to_mail,'jhasan@inceptapharma.com');
            array_push($to_mail,'rabbi@inceptapharma.com');
        }else {
            $to_mail = array();
           array_push($to_mail,'shaon@inceptapharma.com');
           array_push($to_mail,'smnazmul@inceptapharma.com');
           array_push($to_mail,'khasan@inceptapharma.com');
            // array_push($to_mail,'masroor@inceptapharma.com');
        }
        // application information
        $applicant_name = $request->ename;
        $applicant_id = $request->lv_emp_id;
        $applicant_dept = str_replace('&amp;', 'and', $request->edept);
        $applicant_tol = $request->lt;
        $applicant_lv = $request->dol;
        $applicant_rs = $request->lr;
        $mgr_name  = $mgr_info[0]->mgr_name;
        $mgr_email = $mgr_info[0]->mgr_email;
        $mgr_desig = $mgr_info[0]->mgr_desig;
        $comments = $request->comments;
        $data = array(
            'mgr_name' => $mgr_name,
            'mgr_email' => $mgr_email,
            'mgr_desig' => $mgr_desig,
            'applicant_name' => $applicant_name,
            'applicant_id' => $applicant_id,
            'applicant_dept' => $applicant_dept,
            'applicant_tol' => $applicant_tol,
            'applicant_lv' => $applicant_lv,
            'applicant_rs' => $applicant_rs,
            'comments' => $comments
        );
        // application information end
        Mail::send(['text' => 'elm_portal.mail.Leave_Cancellation_email'], $data,  function ($message) use($to_mail,$mgr_email,$mgr_name,$mgr_desig) {
            $message->to($to_mail, $to_mail)
                ->subject('Leave Cancellation Request');
            $message->from($mgr_email, $mgr_name);
        });

        return redirect()->back()->with('success', ' Records Save Successfully.');

    }

}