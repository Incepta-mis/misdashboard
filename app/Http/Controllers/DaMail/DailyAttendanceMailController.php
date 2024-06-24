<?php

namespace App\Http\Controllers\DaMail;

use App\Traits\DailyAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyAttendanceMailController extends Controller
{
    use DailyAttendance;

    public function index()
    {
        return view('_damail.daily_attn_mail');
    }

    public function get_departments()
    {
        $departments = DB::select('select department dept,count(*) t_count
                                    from MIS.DEPT_WISE_MAIL_D
                                    group by department
                                    order by 1
                                    ');

        $section = DB::select('select distinct section
                               from mis.dept_wise_mail_d
                               order by 1');

        $pl = DB::select('select * from mis.dept_wise_mail_log');
        return response()->json(['dept' => $departments, 'pl' => $pl, 'sect' => $section]);
    }

    public function process_attendance_mail(Request $request)
    {

        DB::setDateFormat('DD-MON-RR');
        set_time_limit(0);

        $mail_to_cc = null;
        $attendance_data = null;
        $response = null;

        //Log::info($request->all());

        if ($request->dtype == 'ALL') {

            $mail_to_cc = DB::select('Select * 
                                 from mis.dept_wise_mail_m');

            $attendance_data = DB::select("Select * 
                                            from
                                            (select * 
                                            from MIS.DEPT_WISE_MAIL_D
                                            order by 1,2,3) dwm,(select emp_id,emp_name,ed.desig_name,si.section_name, di.dept_name,
                                                                      decode(first_in_time,'','--:--',to_char(first_in_time,'HH:MI AM')) time_in,
                                                                      shift_to_next_day next_day, 
                                                                      decode(last_out_time,'','--:--',to_char(last_out_time,'HH:MI AM')) time_out,
                                                                      decode(sign(ewsf.last_out_time-ewsf.first_in_time),-1,
                                                                       (lpad(floor(((ewsf.first_in_time-ewsf.last_out_time)*24*60*60)/3600),2,0)|| ':' 
                                                                       ||lpad(floor((((ewsf.first_in_time-ewsf.last_out_time)*24*60*60) -floor(((ewsf.first_in_time-ewsf.last_out_time)*24*60*60)/3600)*3600)/60),2,0))
                                                                       , 
                                                                       (lpad(floor(((ewsf.last_out_time-ewsf.first_in_time)*24*60*60)/3600),2,0)|| ':' 
                                                                       ||lpad(floor((((ewsf.last_out_time-ewsf.first_in_time)*24*60*60) -floor(((ewsf.last_out_time-ewsf.first_in_time)*24*60*60)/3600)*3600)/60),2,0))) 
                                                                       dutyhr,
                                                                      
                                                                       decode(sign(ewsf.first_in_time-ewsf.scedule_start_time_consider),-1,'00:00',
                                                                       (lpad(floor(((ewsf.first_in_time-ewsf.scedule_start_time_consider)*24*60*60)/3600),2,0)|| 
                                                                       ':' 
                                                                       ||lpad(floor((((ewsf.first_in_time-ewsf.scedule_start_time_consider)*24*60*60) -floor(((ewsf.first_in_time-ewsf.scedule_start_time_consider)*24*60*60)/3600)*3600)/60),2,0))) 
                                                                       late,
                                                                      working_status status
                                                                 from hrms.emp_work_status_final@web_to_hrms ewsf,
                                                                      hrms.emp_designation@web_to_hrms ed, 
                                                                      hrms.section_information@web_to_hrms si,
                                                                      hrms.dept_information@web_to_hrms di
                                                                 where ewsf.dept_id = di.dept_id(+)
                                                                 and ewsf.section_id = si.section_id(+)
                                                                 and ewsf.desig_id = ed.desig_id(+) 
                                                                 and to_date(working_date,'DD-MON-RR') = ?
                                                                 and ewsf.com_id = 1
                                                                 and ewsf.plant_id = 1000) ews                            
                                            where dwm.emp_id = ews.emp_Id
                                            order by dept_name,section_name,dwm.emp_id", [$request->wdate]);

        } else {


            $arrVal = explode(',', $request->dtype);
            $params = array_fill(0, sizeof($arrVal), '?');

            $mail_to_cc = DB::select("Select * 
                                 from mis.dept_wise_mail_m 
                                 where department in (" . implode(',', $params) . ")", $arrVal);

            $arrVal[] = $request->wdate;

            //Log::info($arrVal);
            $attendance_data = DB::select("Select * 
            from
            (select * 
            from MIS.DEPT_WISE_MAIL_D
            where department in (" . implode(',', $params) . ")
            order by 1,2,3) dwm,(select emp_id,emp_name,ed.desig_name,si.section_name, di.dept_name,
            decode(first_in_time,'','--:--',to_char(first_in_time,'HH:MI AM')) time_in,
            shift_to_next_day next_day, 
            decode(last_out_time,'','--:--',to_char(last_out_time,'HH:MI AM')) time_out,
            decode(sign(ewsf.last_out_time-ewsf.first_in_time),-1,
            (lpad(floor(((ewsf.first_in_time-ewsf.last_out_time)*24*60*60)/3600),2,0)|| ':' 
            ||lpad(floor((((ewsf.first_in_time-ewsf.last_out_time)*24*60*60) -floor(((ewsf.first_in_time-ewsf.last_out_time)*24*60*60)/3600)*3600)/60),2,0))
            , 
            (lpad(floor(((ewsf.last_out_time-ewsf.first_in_time)*24*60*60)/3600),2,0)|| ':' 
            ||lpad(floor((((ewsf.last_out_time-ewsf.first_in_time)*24*60*60) -floor(((ewsf.last_out_time-ewsf.first_in_time)*24*60*60)/3600)*3600)/60),2,0))) 
            dutyhr,
            
            decode(sign(ewsf.first_in_time-ewsf.scedule_start_time_consider),-1,'00:00',
            (lpad(floor(((ewsf.first_in_time-ewsf.scedule_start_time_consider)*24*60*60)/3600),2,0)|| 
            ':' 
            ||lpad(floor((((ewsf.first_in_time-ewsf.scedule_start_time_consider)*24*60*60) -floor(((ewsf.first_in_time-ewsf.scedule_start_time_consider)*24*60*60)/3600)*3600)/60),2,0))) 
            late,
            working_status status
            from hrms.emp_work_status_final@web_to_hrms ewsf,
            hrms.emp_designation@web_to_hrms ed, 
            hrms.section_information@web_to_hrms si,
            hrms.dept_information@web_to_hrms di
            where ewsf.dept_id = di.dept_id(+)
            and ewsf.section_id = si.section_id(+)
            and ewsf.desig_id = ed.desig_id(+) 
            and to_date(working_date,'DD-MON-RR') = ?
            and ewsf.com_id = 1
            and ewsf.plant_id = 1000) ews                            
            where dwm.emp_id = ews.emp_Id
            order by dept_name,section_name,dwm.emp_id", $arrVal);
        }

        if ($request->ptype == 'PS' || $request->ptype == 'P') {
            $response = $this->prepare_and_mail($mail_to_cc, $attendance_data, $request->wdate, $request->ptype);
            //Log::info($response);
        }

        return response()->json($response);
    }

    public function send_mail_to_dept(Request $request)
    {
        $data = $request->all();
        //Log::info($data);
        $this->send_mail(
            $data['mail_to'],
            $data['mail_cc'],
            $data['mail_bcc'],
            $data['filepath'],
            $data['dept'],
            $data['sect']);
        return response()->json(['message' => 'success']);
    }

    public function get_mail_records()
    {

        $mail_m = DB::select(
            "select department,section,mail_to,mail_cc,mail_bcc,mail_type,'0' d
                from MIS.DEPT_WISE_MAIL_M
                order by 1"
        );

        $mail_d = DB::select(
            "select department,section,d.emp_id,sur_name name,'0' d
                from MIS.DEPT_WISE_MAIL_d d,hrms.emp_information@web_to_hrms ei
                where D.EMP_ID = ei.emp_id(+)
                order by 1"
        );

        return response()->json(['master' => $mail_m, 'details' => $mail_d]);
    }

    public function save(Request $request)
    {
        //Log::info($request);
        $status = null;
        if($request->type === 'm'){
            $row = [
                'department' => strtoupper($request->department),
                'section' => strtoupper($request->section),
                'mail_to' => $request->mail_to,
                'mail_cc' => $request->mail_cc,
                'mail_bcc' => $request->mail_bcc,
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
            ];

            $status = DB::table('mis.dept_wise_mail_m')->insert($row);

        }else if($request->type === 'd'){
            $row = [
                'department' => strtoupper($request->department),
                'section' => strtoupper($request->section),
                'emp_id' => $request->emp_id,
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
            ];

            $status = DB::table('mis.dept_wise_mail_d')->insert($row);
        }

        return response()->json($status);
    }

    public function update(Request $request)
    {
        //Log::info($request);
        $update_s = null;
        if ($request->type === 'm') {

            $update_s = DB::update('update mis.dept_wise_mail_m 
                                    set mail_to = ?,
                                        mail_cc = ?,
                                        mail_bcc = ?,
                                        update_user = ?,
                                        update_date = ?
                                        where department = ?
                                        and section = ?
                                        ',
                [$request->mail_to,
                    $request->mail_cc,
                    $request->mail_bcc,
                    Auth::user()->user_id,
                    Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
                    $request->department,
                    $request->section]);

            $update_log = DB::update('update mis.dept_wise_mail_log 
                                    set mail_to = ?,
                                        mail_cc = ?,
                                        mail_bcc = ?           
                                        where dept = ?
                                        and sect = ?
                                        ',
                [$request->mail_to,
                    $request->mail_cc,
                    $request->mail_bcc,
                    $request->department,
                    $request->section]);

        }
//        else if ($request->type === 'd') {
//            $update_s = DB::update('update mis.dept_wise_mail_d
//                                    set emp_id = ?,
//                                        update_user = ?,
//                                        update_date = ?
//                                        where department = ?
//                                        and section = ?
//                                        and emp_id = ?
//                                        ', [$request->emp_id,
//                Auth::user()->user_id,
//                Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s'),
//                $request->department,
//                $request->section]);
//        }

        return response()->json($update_s);

    }

    public function delete(Request $request)
    {
        $delete_s = null;
        if ($request->type === 'm') {
            $delete_s = DB::delete('delete from mis.dept_wise_mail_m where department = ? and section = ?',
                [$request->department, $request->section]);
        } else if ($request->type === 'd') {
            $delete_s = DB::delete('delete from mis.dept_wise_mail_d where department = ? and section = ? and emp_id = ?',
                [$request->department, $request->section, $request->emp_id]);
        }

        return response()->json($delete_s);
    }
}
