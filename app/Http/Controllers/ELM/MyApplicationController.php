<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/25/2018
 * Time: 9:29 AM
 */


namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MyApplicationController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->user_id;
        // dd($uid);
       /* $appData = DB::select("select line_id,emp_id,application_date,application_date,leave_from,leave_to,day_of_leave,rejected_id,rsp_accept,head_rejected_id,sup_rejected_id,
        hr_rejected_id,status, rcm_approved_date,sup_accept
        from mis.leave_emp_record where emp_id = ?
        and leave_from between (select add_months(trunc(sysdate,'yyyy'),-12) from dual) 
        and (select add_months(trunc (sysdate ,'YEAR'),12)-1 from dual)
        order by line_id desc", [$uid]);
        return view('elm_portal/my_application', ['appData' => $appData]);*/

        $appData = DB::select("select  distinct to_char(leave_from,'YYYY') leave_year  
        from mis.leave_emp_record 
        where emp_id = ?
        order by to_char(leave_from,'YYYY') desc", [$uid]);
        return view('elm_portal/my_application_new', ['appData' => $appData]);
    }

    public function getMyLeaveHistory(Request $request){

        $emp_id = $request->emp_id;
        $emp_year = $request->req_year;

        // return response()->json($request->all());

        if($request->req_year == 'All'){
            $resp_data = DB::select("
            select line_id,emp_id,to_char(application_date,'DD-MON-RR') application_date,type_of_leave,to_char(leave_from,'DD-MON-RR') leave_from ,
            to_char(leave_to,'DD-MON-RR') leave_to ,day_of_leave,rejected_id,rsp_accept,head_rejected_id,sup_rejected_id,
                hr_rejected_id,status, rcm_approved_date,sup_accept,status
            from mis.leave_emp_record where emp_id = ?
            and to_date(to_char(leave_from,'YYYY'),'YYYY') =  decode( ?,'All',to_date(to_char(leave_from,'YYYY'),'YYYY'),?)
            order by line_id desc",[$emp_id,$emp_year,$emp_year]) ;

            //  Log::info($resp_data);

            return response()->json($resp_data);
        }else{
            $resp_data = DB::select("
            select line_id,emp_id,to_char(application_date,'DD-MON-RR') application_date,type_of_leave,to_char(leave_from,'DD-MON-RR') leave_from ,
            to_char(leave_to,'DD-MON-RR') leave_to ,day_of_leave,rejected_id,rsp_accept,head_rejected_id,sup_rejected_id,
                hr_rejected_id,status, rcm_approved_date,sup_accept,status
            from mis.leave_emp_record where emp_id = ?
            and to_char(leave_from,'YYYY') =  ?
            order by line_id desc
            ",[$emp_id,$emp_year]) ;

            // Log::info($resp_data);

            return response()->json($resp_data);
        }
        
    }


    public function getEditedEmpinfo(Request $request)
    {
        if ($request->ajax()) {



            DB::setDateFormat('DD-MON-RR');

            $uid = Auth::user()->user_id;
            
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
          head_of_dept_id, rcm_approved_date, status, add_during_leave,
          medicalimages,half_day,sp_medicalimages,maternityimage
          from mis.leave_emp_record where line_id = ?", [$request->line_id]);

            // $leaveTypes = DB::select("select distinct leave_type
            //                 from hrms.leave_information@web_to_hrms    
            //                 where valid = 'YES'    
            //                 order by leave_type asc");


            $rsp_emp = DB::select("select a.emp_id,a.sur_name,a.gender,b.desig_id,b.desig_name,c.dept_name
                            from
                            (select emp_id,sur_name,desig_id,dept_id,nvl(gender,'Male') gender
                            from hrms.emp_information@WEB_TO_HRMS
                            where dept_id = (
                            select dept_id
                            from hrms.emp_information@WEB_TO_HRMS
                            where emp_id = ?
                            and valid = 'YES')) a, (select distinct desig_id,desig_name
                            from hrms.emp_designation@web_to_hrms
                            where valid = 'YES') b, (select distinct dept_id,dept_name
                            from hrms.dept_information@web_to_hrms
                            where valid = 'YES') c
                            where a.desig_id = b.desig_id     
                            and a.dept_id = c.dept_id
                            and a.emp_id not in ?
                            order by emp_id", [$uid, $uid]);


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

            $leaveStatus = DB::select("SELECT    x.emp_id
      ,'Availed' TYPE 
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
      WHERE X.EMP_ID = '$uid'
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
      WHERE X.EMP_ID = '$uid'
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
      WHERE X.EMP_ID = '$uid'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
      GROUP BY x.emp_id ");


            return response()->json(['resp_data' => $resp_data, 'leavetypes' => $leaveTypes, 'rsp_emp' => $rsp_emp, 'leaveStatus' => $leaveStatus]);
        }


    }

    public function getRspInfo(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::select("select a.emp_id,a.sur_name,b.desig_id,b.desig_name,c.dept_id,c.dept_name,a.plant_id,
                                      d.report_supervisor,d.contact_no,d.mail_address
        from 
        (select emp_id,sur_name,desig_id,dept_id,plant_id
        from hrms.emp_information@WEB_TO_HRMS
        where emp_id = ?
        and valid = 'YES') a, (select distinct desig_id,desig_name
        from hrms.emp_designation@web_to_hrms
        where valid = 'YES') b, (select distinct dept_id,dept_name
        from hrms.dept_information@web_to_hrms
        where valid = 'YES') c,(select * from mis.leave_emp_info where emp_id = ?) d
        where a.desig_id = b.desig_id  
        and   a.dept_id = c.dept_id
        and   a.emp_id = d.emp_id", [$request->emp_id, $request->emp_id]);

            return response()->json($resp_data);
        }
    }

    public function updateApplication(Request $request)
    {
//      echo Carbon::parse(trim($request->st_dt))->format('m-d-Y');

//      $ss = Carbon::createFromFormat('d/m/Y', $request->st_dt);
//      $pp = Carbon::parse(trim($request->en_dt))->format('m-d-Y');
//
//      echo $ss;
//      echo $pp;


        $old_rsp = DB::select("select rsp_emp_id
        from mis.leave_emp_record
        where line_id = ".$request->line_id);


//      dd($old_rsp[0]->rsp_emp_id);



        $line_path = '';
        if ($request->tol == 'MEDICAL')
        {
            $this->validate($request, [
                'medicalFile' => 'required|file',
            ]);
            $file = $request->medicalFile; // get the validated file
            $extension = $file->getClientOriginalName();
            $filename = $request->emp_id . '_medical-photo-' . time() . '.' . $extension;

            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(492, 484);
            $image_resize->save(public_path('/medicalImage/' .$filename));

//            $path = $file->move(public_path() . '/medicalImage/', $filename);
            $line_path = '/medicalImage/'.$filename;
        }


        $matimg_path = '';
        if ($request->tol == 'MATERNITY')
        {
            if(!empty($request->mtrn_file)){
                $this->validate($request, [
                    'mtrn_file' => 'required|file',
                ]);
                $file = $request->mtrn_file; // get the validated file
                $extension = $file->getClientOriginalExtension();
                $filename = $request->emp_id . '_mat-photo-' . time() . '.' . $extension;
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(492, 484);
                $image_resize->save(public_path('/maternityImage/' .$filename));
//                    dd($image_resize);
                $matimg_path = '/maternityImage/'.$filename;
            }
        }


        $suc = LeaveEmpRecord::where('line_id', $request->line_id)
            ->update([
            'leave_from' => Carbon::parse(trim($request->st_dt))->format('Y-m-d'),
            'leave_to' => Carbon::parse(trim($request->en_dt))->format('Y-m-d'),
            'day_of_leave' => $request->dol,
            'type_of_leave' => $request->tol,
            'add_during_leave' => $request->adl,
            'emp_contact_no' => $request->mob,
            'emp_email' => $request->email,
            'purpose_of_leave' => $request->pol,
            'rsp_emp_id' => $request->rsp_emp_code,
            'rsp_emp_name' => $request->rsp_emp_name,
            'rsp_desig_id' => $request->rsp_desig_id,
            'rsp_desig_name' => $request->rsp_desig_name,
            'rsp_dept_id' => $request->rsp_dept_id,
            'rsp_contact_no' => $request->rsp_cnt_no,
            'rsp_email' => $request->rsp_email,
            'rsp_duties' => $request->rsp_duties,
            'rejected_id' => '',
            'rejected_date' => ''
        ]);

        if($line_path != ""){
            $suc1 = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update([
                    'medicalimages' => $line_path
                ]);
        }

        if($matimg_path != ""){
            $suc2 = LeaveEmpRecord::where('line_id', $request->line_id)
                ->update([
                    'maternityimage' => $matimg_path
                ]);
        }
        if ($suc) {
            $notification = array(
                'message' => 'Update Successfully.',
                'alert-type' => 'success'
            );



            if($request->rsp_emp_code != $old_rsp[0]->rsp_emp_id){
                $auth_name = Auth::user()->name;
                $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$request->rsp_emp_code]);
                $app_link = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/req_application',
                    'app_emp' => $auth_name,'app_mob' =>$request->mob,
                    'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/req_application'
                  );
                $applicant_emails = $request->email;
                Mail::send(['text' => 'elm_portal.mail.applicant_mail'], $app_link, function ($message) use ($applicant_emails, $frm_mail, $auth_name) {
                    $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
                        ->subject('Leave Application');
                    $message->from($applicant_emails, $auth_name);
                });
                // old rsp notificaton for change
                $mail_to = $request->rsp_oldemail;
                $data = array('app_emp' => $auth_name);
                $applicant_emails = $request->email;
                Mail::send(['text' => 'elm_portal.mail.rsp_change_notify'], $data, function ($message) use ($applicant_emails, $mail_to, $auth_name) {
                    $message->to($mail_to, $mail_to)
                        ->subject('Request For Changing Responsible Duties.');
                    $message->from($applicant_emails, $auth_name);
                });
            }


            return Redirect::to('elm_portal/my_application')->with($notification);
        }
    }


    public function medicalImageDelete(Request $request)
    {
        $image_string = $request->img_path;
        $d = substr($image_string, strpos($image_string, '/medicalImage'));
        $image_path = public_path() . $d;  // Value is not URL but directory file path

//        return response()->json( $image_path);


        if (File::exists($image_path)) {
            unlink(public_path($d ));
            DB::table('MIS.LEAVE_EMP_RECORD')
                ->where('line_id', $request->line_id)
                ->update(['medicalimages' => '']);
            return response()->json(['success' => 'success']);
        }
    }

    public function maternityImageDelete(Request $request)
    {


        $image_string = $request->img_path;



        $d = substr($image_string, strpos($image_string, '/maternityImage'));
        $image_path = public_path() . $d;  // Value is not URL but directory file path

//        return response()->json( $image_path);




        if (File::exists($image_path)) {
            unlink(public_path($d ));
            DB::table('MIS.LEAVE_EMP_RECORD')
                ->where('line_id', $request->line_id)
                ->update(['maternityimage' => '']);
            return response()->json(['success' => 'success']);
        }
    }


}