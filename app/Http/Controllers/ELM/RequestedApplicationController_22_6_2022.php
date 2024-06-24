<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/27/2018
 * Time: 12:29 PM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class RequestedApplicationController extends Controller
{
    public function index(){

        $uid = Auth::user()->user_id;
        $applicantData = DB::select("select line_id,plant_id,emp_id,emp_name, status,emp_contact_no,emp_email,leave_from,leave_to,rsp_duties,rsp_accept,rejected_id
           from mis.leave_emp_record
           where rsp_emp_id = ? 
           --and leave_from between (select add_months(trunc(sysdate,'yyyy'),-12) from dual) and (select add_months(trunc (sysdate ,'YEAR'),12)-1 from dual)
           and leave_from between (select add_months(trunc(sysdate,'yyyy'),-12) from dual) and (select add_months(trunc (sysdate ,'YEAR'),12) from dual)
           order by create_date desc", [$uid]);

        return view('elm_portal/requested_application',['applicantData' => $applicantData]);  

    }

    public function application_confirmation (Request $request){

        if($request->ajax()){


//             return response()->json($request->all());
            // return response()->json($request->emp_email);
            // return response()->json( $frm_mail[0]->mail_address);


            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select plant_id,mail_address,contact_no from mis.leave_emp_info where emp_id = ?", [$uid]);



            $to_mail = $request->emp_email;
            $to_mail_name = $request->emp_name;

            $data = array('name' => $request->emp_name,'accpt_emp' =>$auth_name );



            /*  var_dump( Mail:: failures());  exit;*/
            // mail for applicant notification
           Mail::send(['text' => 'elm_portal.mail.rsp_accept_mail'], $data, function ($message) use($to_mail,$frm_mail,$auth_name) {
               $message->to($to_mail, $to_mail)
                   ->subject('Leave Approved');
               $message->from($frm_mail[0]->mail_address, $auth_name);
           });


           if($frm_mail[0]->plant_id !='1000'){

               $supvisor_mail = DB::select("select emp_id,mail_address
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(report_supervisor)
                                    from leave_emp_info
                                    where emp_id = '$request->emp_id')
                                ");

               $sup_present_id = $supvisor_mail[0]->emp_id;

               $emp_rcm = DB::SELECT(" SELECT distinct emp_id emp_id FROM mis.leave_factory_rcm_user WHERE emp_id = '$sup_present_id'");

               if(!empty($emp_rcm)){   // if supervisor absent
                   $head_mail = DB::select("select mail_address
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(head_of_dept)
                                    from leave_emp_info
                                    where emp_id = '$request->emp_id')
                                ");
                   if($head_mail) {
                       $hm = $head_mail[0]->mail_address;

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
               }else {
                   if($supvisor_mail) {
                       $sp = $supvisor_mail[0]->mail_address;
                       //mail for super visor
                       $app_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$request->line_id,
                           'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$request->line_id,
                           'accpt_emp' =>$auth_name, 'mob_no' => $frm_mail[0]->contact_no ,'application_user' => $to_mail_name );
                       $emails = [];
                       array_push( $emails, $sp);

                       Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use($emails,$to_mail,$to_mail_name) {
                           $message->to($emails, 'Mail')
                               ->subject('Leave Application');
                           $message->from($to_mail, $to_mail_name);
                       });
                   }
               }

           }else{
               $supvisor_mail = DB::select("select mail_address
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(report_supervisor)
                                    from leave_emp_info
                                    where emp_id = '$request->emp_id')
                                ");
               if($supvisor_mail) {
                   $sp = $supvisor_mail[0]->mail_address;
                   //mail for super visor
                   $app_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$request->line_id,
                       'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$request->line_id,
                       'accpt_emp' =>$auth_name, 'mob_no' => $frm_mail[0]->contact_no ,'application_user' => $to_mail_name );
                   $emails = [];
                   array_push( $emails, $sp);

                   Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use($emails,$to_mail,$to_mail_name) {
                       $message->to($emails, 'Mail')
                           ->subject('Leave Application');
                       $message->from($to_mail, $to_mail_name);
                   });
               }

               $head_mail = DB::select("select mail_address
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(head_of_dept)
                                    from leave_emp_info
                                    where emp_id = '$request->emp_id')
                                ");
                                
                if( $head_mail[0]->mail_address != 'ehsan@inceptapharma.com')  {
                   $hm = $head_mail[0]->mail_address;

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
                    ->update(['RSP_ACCEPT'=>'YES','RSP_ACCEPT_DATE'=>$sys_time,'UPDATE_USER' => $uid]);
                return response()->json(['success'=>'Successfully ! Application Accepted by User.']);
            }
        }
    }

    public function application_rejection (Request $request){

        if($request->ajax()){

            // return response()->json($request->all());

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;

            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$uid]);
            $to_mail = $request->emp_email;

            $data = array('name' => $request->emp_name,'accpt_emp' =>$auth_name );
            //mail for applicant notification
            Mail::send(['text' => 'elm_portal.mail.rejected_mail'], $data, function ($message) use($to_mail,$frm_mail,$auth_name) {
                $message->to($to_mail, $to_mail)
                    ->subject('Leave Request');
                $message->from($frm_mail[0]->mail_address, $auth_name);
            });
            
            if($request->reject_val == '0'){
                LeaveEmpRecord::where('emp_id',$request->emp_id )->where('line_id',$request->line_id )->update(['RSP_ACCEPT'=>'NO','REJECTED_ID'=>$uid,'REJECTED_DATE' => $sys_time,
                  'UPDATE_USER' => $uid,'APP_STATUS'=>'YES']);
                return response()->json(['success'=>'Successfully ! Application Rejected by User.']);
            }      
        }
    }

    public function saveRecommendUser(Request $request){

        $emp_id = $request->emp_id;
        $empDetails = DB::select("select plant_id from mis.leave_emp_info where emp_id = '$emp_id'");
        $plant_id = $empDetails[0]->plant_id;

        if($request->chk_val == '1'){
            $x = DB::table('MIS.LEAVE_FACTORY_RCM_USER')->insert(
                ['plant_id' => $plant_id, 'emp_id' => $emp_id]
            );
            if($x){
                return response()->json(['success'=>'Successfully Sign Off !!!']);
            }else {
                return response()->json(['error'=>'Contact Your Administrator.']);
            }
        }elseif ($request->chk_val == '0'){
            $x = DB::table('MIS.LEAVE_FACTORY_RCM_USER')->where('emp_id', $emp_id)->delete();
            if($x){
                return response()->json(['success'=>'Successfully Sign In !!!']);
            }else {
                return response()->json(['error'=>'Contact Your Administrator.']);
            }
        }

    }

}