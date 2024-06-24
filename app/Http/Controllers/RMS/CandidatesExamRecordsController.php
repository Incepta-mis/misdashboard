<?php


namespace App\Http\Controllers\RMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CandidatesExamRecordsController extends Controller
{

    public function index()
    {

        $search_plant_info = DB::select("select distinct plant_id, plant_name from mis.rms_dept_recruitment");

        $search_recruitment = DB::select("select distinct cv.recruitment_id
from mis.rms_cv_sorting cv,mis.rms_dept_recruitment dr
where cv.recruitment_id = dr.recruitment_id
and recruitm_status is null
                                            ");

        return view('RMS.CandidatesExamRecords')
            ->with(['search_recruitment' => $search_recruitment,'search_plant_info'=>$search_plant_info]);

    }

    public function cer_search_dept_info(Request $request){
        $cer_search_dept_info = DB::select("select distinct dept_id, dept_name from mis.rms_dept_recruitment
                                        where plant_id = decode(?, 'ALL', plant_id, ?)", [$request->plant_id, $request->plant_id]);

        return response()->json(['cer_search_dept_info'=>$cer_search_dept_info]);
    }

    public function cer_search_rec_id(Request $request){
        $cer_search_rec_id = DB::select("select recruitment_id from mis.rms_dept_recruitment
                                    where recruitm_status is null 
                                    and plant_id = decode(?, 'ALL', plant_id, ?)
                                    and dept_id = decode(?, 'ALL', dept_id, ?)", [$request->plant_id, $request->plant_id, $request->dept_id, $request->dept_id]);

        return response()->json(['cer_search_rec_id'=>$cer_search_rec_id]);
    }

    public function search_nid(Request $request)
    {
        $search_nid = null;
        if($request->type == 'srid'){
            $search_nid = DB::select("select distinct recruitment_id,nid
                                       from mis.rms_exam_record
                                       where recruitment_id = ?
                                       order by nid asc  
                                  ", [$request->rec_id]);
        }else{
            $search_nid = DB::select("select * from (select distinct recruitment_id,nid
                                            from mis.rms_cv_sorting
                                            where recruitment_id = ?                                  
                                            minus
                                            select distinct recruitment_id,nid
                                            from mis.rms_exam_record
                                            ) order by recruitment_id asc
                                  ", [$request->rec_id]);
        }

        return response()->json(['search_nid' => $search_nid]);

    }

    public function search_result(Request $request)
    {

        $search_result = DB::select("select * from mis.rms_cv_sorting
                                     where recruitment_id = ?
                                     and nid = ?
                                     order by nid asc", [$request->recruitment_id, $request->nid]);

        $search_recruitment = DB::select("select recruitment_id from mis.rms_dept_recruitment order by recruitment_id");

        $exam_point = DB::select("select nid,candidate_name,father_name,dob,(ssc_result/5)*(select maximum_point from mis.rms_academic_credential where categories = 'SSC') ssc_point,
                                (hsc_result/5)*(select maximum_point from mis.rms_academic_credential where categories = 'HSC') hsc_point,maximum_point University_Point
                                from
                                (
                                select nid,candidate_name,father_name,dob,ssc_result,hsc_result,g_subject,g_result,
                                       (select case when g_university in (select distinct university_name from mis.rms_academic_credential)
                                       then g_university else 'OTHERS' end from mis.rms_cv_sorting where nid = ?) g_university
                                from mis.rms_cv_sorting 
                                where nid = ?
                                ) cs,(select subject,university_name,maximum_point from mis.rms_academic_credential where subject is not null) ac
                                where cs.g_subject = ac.subject(+)
                                and cs.g_university = ac.university_name(+)", [$request->nid, $request->nid]);


        return response()->json(['search_result' => $search_result, 'search_recruitment' => $search_recruitment, 'exam_point' => $exam_point]);

    }

    public function update_search_result(Request $request)
    {

        $update_search_result = DB::select("select * from mis.rms_exam_record
                                            where recruitment_id = ?
                                            and nid = ?", [$request->recruitment_id, $request->nid]);

        $search_nid = DB::select("select * from mis.rms_cv_sorting
                                  order by nid asc");

        return response()->json(['update_search_result' => $update_search_result, 'nid_list' => $search_nid]);

    }

    public function written_exam_points(Request $request)
    {

        $written_exam_points = DB::select("select (?/?)*(select maximum_marks from mis.rms_marks_calculation
                                            where categories = 'WRITTEN') written_exam_point
                                            from dual", [$request->obtain_mark, $request->total_mark]);

        return response()->json(['written_exam_points' => $written_exam_points]);
    }

    public function first_interview_points(Request $request)
    {

        $first_interview_point = DB::select("select (?/?)*(select maximum_marks from mis.rms_marks_calculation
                                             where categories = '1ST INTERVIEW') first_interview_point
                                             from dual", [$request->i_mark_obtain, $request->i_total_mark]);

        return response()->json(['first_interview_point' => $first_interview_point]);

    }

    public function final_interview_points(Request $request)
    {

        $final_interview_point = DB::select("select (?/?)*(select maximum_marks from mis.rms_marks_calculation
                                             where categories = 'FINAL INTERVIEW') final_interview_point
                                             from dual", [$request->f_mark_obtain, $request->f_mark_total]);

        return response()->json(['final_interview_point' => $final_interview_point]);

    }


    public function salary_matrix(Request $request)
    {

        $salary_matrix = DB::select("select nid,cd.categories,salary,max_salary
                                        from
                                        (select nid,case when categories is null then 'GEOUP D' else categories end categories,
                                               case when categories is null then '0' else ? end total_point
                                        from
                                        (select nid,g_university,g_subject
                                        from mis.rms_cv_sorting 
                                        where nid = ?) cvs,(select categories,university_name,subject  -- need Outr join For Others department (Example- IT,HR, Etc)
                                                                from mis.rms_academic_credential) ac
                                        where cvs.g_university = ac.university_name(+)
                                        and cvs.g_subject = ac.subject(+)) cd,(select categories,points,salary,max_salary from mis.rms_salary_matrix) sd
                                        where cd.categories = sd.categories
                                        and cd.total_point = sd.points", [$request->total_point, $request->nid]);

        return response()->json(['salary_matrix' => $salary_matrix]);

    }

    public function cer_save_record(Request $request)
    {

        $uid = Auth::user()->user_id;
        $date = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $insert = [

            'nid' => $request->nid,
            'recruitment_id' => $request->recruitment_id,
            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'dob' => Carbon::parse($request->dob)->format('Y-m-d'),
            'ssc_point' => $request->ssc_point,
            'hsc_point' => $request->hsc_point,
            'university_point' => $request->university_point,
            'written_exam_marks' => $request->written_exam_marks,
            'total_exam_marks' => $request->total_exam_marks,
            'written_exam_point' => $request->written_exam_point,
            'written_exam_date' => Carbon::parse($request->written_exam_date)->format('Y-m-d'),
            'interview_marks' => $request->interview_marks,
            'interview_tot_marks' => $request->interview_tot_marks,
            'interview_point' => $request->interview_point,
            'interview_date' => Carbon::parse($request->interview_date)->format('Y-m-d'),
            'interview_pm' => $request->interview_pm,
            'f_interview_marks' => $request->f_interview_marks,
            'f_interview_tot_marks' => $request->f_interview_tot_marks,
            'f_interview_point' => $request->f_interview_point,
            'f_interview_date' => Carbon::parse($request->f_interview_date)->format('Y-m-d'),
            'f_interview_pm' => $request->f_interview_pm,
            'total_point' => $request->total_point,
            'salary' => $request->salary,
            'notes' => $request->notes,
            'remarks' => $request->remarks,
            'create_user' => $uid,
            'create_date' => $date
        ];

        DB::table('mis.rms_exam_record')->insert($insert);

    }


    public function cer_update_record (Request $request){

        $uid = Auth::user()->user_id;
        $date = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $update = [

            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'dob' => Carbon::parse($request->dob)->format('Y-m-d'),
            'ssc_point' => $request->ssc_point,
            'hsc_point' => $request->hsc_point,
            'university_point' => $request->university_point,
            'written_exam_marks' => $request->written_exam_marks,
            'total_exam_marks' => $request->total_exam_marks,
            'written_exam_point' => $request->written_exam_point,
            'written_exam_date' => Carbon::parse($request->written_exam_date)->format('Y-m-d'),
            'interview_marks' => $request->interview_marks,
            'interview_tot_marks' => $request->interview_tot_marks,
            'interview_point' => $request->interview_point,
            'interview_date' => Carbon::parse($request->interview_date)->format('Y-m-d'),
            'interview_pm' => $request->interview_pm,
            'f_interview_marks' => $request->f_interview_marks,
            'f_interview_tot_marks' => $request->f_interview_tot_marks,
            'f_interview_point' => $request->f_interview_point,
            'f_interview_date' => Carbon::parse($request->f_interview_date)->format('Y-m-d'),
            'f_interview_pm' => $request->f_interview_pm,
            'total_point' => $request->total_point,
            'salary' => $request->salary,
            'notes' => $request->notes,
            'remarks' => $request->remarks,
            'update_user' => $uid,
            'update_date' => $date

        ];

        DB::table('mis.rms_exam_record')->where(['nid'=>$request->nid, 'recruitment_id'=>$request->recruitment_id])->update($update);

    }



}