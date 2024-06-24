<?php

namespace App\Http\Controllers\Rmportal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DoctorAnnivBdayReminderController extends Controller
{
    public function index(){
        return view('rm_portal.DoctorAnnivBdayReminder');
    }

    public function getDoctorInfo(){
        $doctor_data = DB::select("select sl,doctor_id,doctor_name,doctor_address,territory,email_id,
                                          mobile_no,to_char(marriage_day,'DD-MON') marriage_day,marriage_day mday,
                                          to_char(birthday,'DD-MON') birthday,birthday bday 
                                    from mis.dash_doc_anniv_bday
                                    order by sl");

            $bday = DB::select("select doctor_id id,doctor_name name,to_char(birthday,'DD-MON') edate,trunc(birthday-sysdate) day_diff
                            from MIS.DASH_DOC_ANNIV_BDAY_BK
                            where birthday is not null
                            and trunc(birthday-sysdate) between 0 and 3
                            order by birthday asc
                            ");

            $mday = DB::select("select doctor_id id,doctor_name name,to_char(MARRIAGE_DAY,'DD-MON') edate,trunc(marriage_day-sysdate) day_diff
                            from MIS.DASH_DOC_ANNIV_BDAY_BK
                            where marriage_day is not null
                            and trunc(marriage_day-sysdate) between 0 and 3
                            order by marriage_day asc
                            ");

        return response()->json(['drecords'=>$doctor_data,'brecords'=>$bday,'mrecords'=>$mday]);
    }

    public function getDoctorDetails(Request $request){
        $details = DB::select('Select * from mis.dash_doc_anniv_bday where doctor_id = ?',[$request->doc_id]);
        return response()->json($details);
    }

    public function exportdata($p){
        Log::info($p);
        $params = json_decode($p);
        $data = null;
        if($params->type === 'birth'){
             $bday = DB::select("select *
                            from(
                            select doctor_id,doctor_name,doctor_address,territory,email_id,
                                   mobile_no,to_char(birthday,'DD-MON') event_date,
                                   trunc(birthday-sysdate) day_diff
                            from MIS.DASH_DOC_ANNIV_BDAY_BK
                            where birthday is not null
                            and trunc(birthday-sysdate) between 0 and 3
                            order by birthday asc
                            )
                            ");

           $data = ['rdata' => $bday, 'event' => 'Birthday'];

        }elseif($params->type === 'marriage'){
             $mday = DB::select("select *
                            from(
                            select doctor_id ,doctor_name ,doctor_address,territory,email_id,
                                   mobile_no,to_char(MARRIAGE_DAY,'DD-MON') event_date,
                                   trunc(marriage_day-sysdate) day_diff
                            from MIS.DASH_DOC_ANNIV_BDAY_BK
                            where marriage_day is not null
                            and trunc(marriage_day-sysdate) between 0 and 3
                            order by marriage_day asc
                            )
                            ");

            $data = ['rdata' => $mday, 'event' => 'Marriage Day'];
        }

        \Excel::create('Doctor_'.$params->type.'Data', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->loadView('rm_portal.DoctorAnnivBdayDataExport', $data);
            });
        })->export('xls');
    }

}
