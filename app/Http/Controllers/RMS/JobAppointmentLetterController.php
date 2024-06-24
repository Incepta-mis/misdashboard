<?php


namespace App\Http\Controllers\RMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobAppointmentLetterController extends Controller
{

    public function index()
    {

        $search_plant_info = DB::select("select distinct plant_id, plant_name from mis.rms_dept_recruitment");

        // $search_nid = DB::select("select nid from mis.rms_job_offer_appointment");

        $recruit_id = DB::select("select * from rms_dept_recruitment where recruitm_status is null");

        $nid = DB::select("select nid from mis.rms_exam_record
                           minus 
                           select nid from mis.rms_job_offer_appointment
                           ");

        return view('rms.JobAppointmentLetter')
        ->with(['nid' => $nid, 
        'search_rid' => $recruit_id,
        'search_plant_info'=>$search_plant_info]);

    }

    public function jal_search_dept_info(Request $request){
        $jal_search_dept_info = DB::select("select distinct dept_id, dept_name from mis.rms_dept_recruitment
                                        where plant_id = decode(?, 'ALL', plant_id, ?)", [$request->plant_id, $request->plant_id]);

        return response()->json(['jal_search_dept_info'=>$jal_search_dept_info]);
    }

    public function jal_search_rec_id(Request $request){
        $jal_search_rec_id = DB::select("select recruitment_id 
                                    from mis.rms_dept_recruitment
                                    where recruitm_status is null 
                                    and plant_id = decode(?, 'ALL', plant_id, ?)
                                    and dept_id = decode(?, 'ALL', dept_id, ?)", [$request->plant_id, $request->plant_id, $request->dept_id, $request->dept_id]);

        return response()->json(['jal_search_rec_id'=>$jal_search_rec_id]);
    }

    public function jal_search_nid(Request $request)
    {
        return response()->json(['search_nid' => DB::select('select distinct nid from mis.rms_job_offer_appointment where  recruitment_id = ?',[$request->rec_id])]);
    }

    public function search_nid(Request $request)
    {

        $search_nid = DB::select("select rer.recruitment_id, rer.candidate_name, rer.father_name, rdr.dept_name, rdr.plant_id, rdr.plant_name
                                    from mis.rms_exam_record rer, mis.rms_dept_recruitment rdr
                                    where rer.nid = ?
                                    and rer.recruitment_id = rdr.recruitment_id", [$request->nid]);


        return response()->json(['search_nid' => $search_nid]);

    }

    public function save_record(Request $request)
    {

        Log::info('Saving');
        $uid = Auth::user()->user_id;
        $date = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $insert = [
            'nid' => $request->nid,
            'recruitment_id' => $request->recruitment_id,
            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'job_location' => $request->job_location,
            'dept_name' => $request->department_name,
            'joining_date' => Carbon::parse($request->joining_date)->format('Y-m-d'),
            'orientation_carried_by' => $request->orientation_carried,
            'evaluation_of_superv' => $request->supervisor_evaluation,
            'create_user' => $uid,
            'create_date' => $date
        ];

        DB::table('mis.rms_job_offer_appointment')->insert($insert);

    }

    public function search_nid_update(Request $request){

        $search_nid_update = DB::select("select * from mis.rms_job_offer_appointment where nid = ?", [$request->nid]);
//        dd($search_nid_update);
        return response()->json(['search_nid_update'=>$search_nid_update]);

    }

    public function update_record(Request $request){

        Log::info('Updating');

        $uid = Auth::user()->user_id;
        $date = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $update = [
            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'job_location' => $request->job_location,
            'dept_name' => $request->department_name,
            'joining_date' => Carbon::parse($request->joining_date)->format('Y-m-d'),
            'orientation_carried_by' => $request->orientation_carried,
            'evaluation_of_superv' => $request->supervisor_evaluation,
            'update_user' => $uid,
            'update_date' => $date
        ];

        DB::table('mis.rms_job_offer_appointment')->where('nid',$request->nid)->update($update);

    }

    public function get_rid(Request $request){
        return DB::select("select er.nid 
            from mis.rms_exam_record er,mis.rms_dept_recruitment dr,mis.rms_candidate_assessment ca
            where er.recruitment_id = dr.recruitment_id
            and er.recruitment_id = ca.recruitment_id
            and er.nid = ca.nid
            and recruitm_status is null
            and upper(nvl(candidate_assessment,'RMS')) = 'SELECTED'
            and er.recruitment_id = ?
            minus
            select nid from mis.rms_job_offer_appointment",[$request->rid]);
    }

}