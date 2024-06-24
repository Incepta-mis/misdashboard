<?php


namespace App\Http\Controllers\RMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WrittenInterviewResultReportController extends Controller
{

    public function index()
    {

        $plant_name = DB::select("select distinct plant_name, plant_id from mis.rms_dept_recruitment");

        return view('RMS.WrittenInterviewResultReport')->with(['plant_name' => $plant_name]);

    }

    public function get_dept_info(Request $request)
    {

        $get_dept_info = DB::select("select distinct dept_name, dept_id from mis.rms_dept_recruitment
                                        where plant_id = decode(?,'ALL',plant_id,?)", [$request->plant_id, $request->plant_id]);

        $get_recruitment_info = DB::select("select distinct dr.recruitment_id, er.recruitment_id 
                                            from mis.rms_dept_recruitment dr, mis.rms_exam_record er
                                            where plant_id = decode(?, 'ALL', plant_id, ?)
                                            and dr.recruitment_id = er.recruitment_id", [$request->plant_id, $request->plant_id]);

        return response()->json(['get_dept_info' => $get_dept_info, 'get_recruitment_info' => $get_recruitment_info]);

    }

    public function get_section_info(Request $request)
    {

        $get_section_info = DB::select("select distinct section_id, section_name from mis.rms_dept_recruitment
                                    where dept_id = decode(?, 'ALL', dept_id, ?)", [$request->dept_id, $request->dept_id]);

        return response()->json(['get_section_info' => $get_section_info]);

    }

    public function get_n_id(Request $request)
    {

        $get_n_id = DB::select("select nid from mis.rms_exam_record
                                where recruitment_id = decode(?, 'ALL', recruitment_id, ?)", [$request->rec_id, $request->rec_id]);

        return response()->json(['get_n_id' => $get_n_id]);

    }

    public function get_data_exam_record(Request $request)
    {

        //Log::info($request->all());

        $get_data_exam_record = DB::select("select er.*,to_char(er.written_exam_date,'DD-MON-RR') format_written_exam_date, to_char(er.interview_date,'DD-MON-RR') format_interview_date, to_char(er.f_interview_date,'DD-MON-RR') format_f_interview_date, cs.g_university, cs.nid, cs.recruitment_id, dr.plant_name, dr.recruitment_id, dr.dept_name, dr.section_name, dr.desig_name
                                            from mis.rms_exam_record er, mis.rms_cv_sorting cs, mis.rms_dept_recruitment dr
                                            where er.recruitment_id = cs.recruitment_id
                                            and er.recruitment_id = dr.recruitment_id
                                            and er.nid = cs.nid
                                            and er.recruitment_id = decode(?, 'ALL', er.recruitment_id, ?)
                                            and er.nid = decode(?, 'ALL', er.nid, ?)
                                            and dr.plant_id = decode(?,'ALL',dr.plant_id,?)
                                            and dr.section_id = decode(?,'ALL',dr.section_id,?)
                                            and dr.dept_id = decode(?,'ALL',dr.dept_id,?)",
                                            [$request->rec_id, $request->rec_id,
                                             $request->nid, $request->nid,
                                             $request->plant_id,$request->plant_id,
                                             $request->section_id,$request->section_id,
                                             $request->dept_id,$request->dept_id]);

        return response()->json(['get_data_exam_record'=>$get_data_exam_record]);

    }

}
