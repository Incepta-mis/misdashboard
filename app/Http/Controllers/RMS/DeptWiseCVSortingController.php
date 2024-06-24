<?php


namespace App\Http\Controllers\RMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeptWiseCVSortingController extends Controller
{

    public function index(){

        $search_plant_info = DB::select("select distinct plant_id, plant_name from mis.rms_dept_recruitment");

        $search_nid = DB::select("select * from mis.rms_cv_sorting
                                  order by nid asc");

        $g_subject = DB::select("select distinct subject from mis.rms_academic_credential
                                 order by subject asc");

        $g_university = DB::select("select distinct university_name from mis.rms_academic_credential
                                    order by university_name asc");

        $recruitment_id = DB::select("select * from mis.rms_dept_recruitment where recruitm_status is null order by recruitment_id");

        return view('rms.DeptWiseCVSorting')->with(['search_plant_info'=>$search_plant_info, 'search_nid'=>$search_nid, 'g_subject'=>$g_subject, 'g_university'=>$g_university, 'recruitment_id'=>$recruitment_id]);
    }

    public function dwcs_search_dept_info(request $request){

        $dwcs_search_dept_info = DB::select("select dept_id, dept_name from mis.rms_dept_recruitment
                                        where plant_id = decode(?, 'ALL', plant_id, ?)", [$request->plant_id, $request->plant_id]);

        return response()->json(['dwcs_search_dept_info'=>$dwcs_search_dept_info]);

    }

    public function dwcs_search_rec_id(Request $request){

        $dwcs_search_rec_id = DB::select("select recruitment_id from mis.rms_dept_recruitment
                                    where recruitm_status is null 
                                    and plant_id = decode(?, 'ALL', plant_id, ?)
                                    and dept_id = decode(?, 'ALL', dept_id, ?)", [$request->plant_id, $request->plant_id, $request->dept_id, $request->dept_id]);

        return response()->json(['dwcs_search_rec_id'=>$dwcs_search_rec_id]);
    }

    public function dwcs_search_n_id(Request $request){

        $dwcs_search_n_id = DB::select("select rcs.nid, rcs.recruitment_id, rdr.recruitment_id 
                                    from mis.rms_dept_recruitment rdr, mis.rms_cv_sorting rcs
                                    where rcs.recruitment_id = ?
                                    and rcs.recruitment_id = rdr.recruitment_id", [$request->recruitment_id]);

        return response()->json(['dwcs_search_n_id'=>$dwcs_search_n_id]);

    }

    public function search_nid(Request $request){

        $search_nid = DB::select("select * from mis.rms_cv_sorting
                                    where nid = ?
                                    order by nid asc", [$request->nid]);

        $subjects = DB::select("select subject from mis.rms_academic_credential
                                    where university_name = ?", [$search_nid[0]->g_university]);

        return response()->json(['search_nid'=>$search_nid,'subjects'=>$subjects]);

    }

    public function get_subject(Request $request){

        $get_subject = DB::select("select subject from mis.rms_academic_credential
                                    where university_name = ?", [$request->university_name]);

        return response()->json(['get_subject'=>$get_subject]);

    }

    public function save_record(Request $request){

        $uid = Auth::user()->user_id;
        $create_date = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $insert = [

            'nid' => $request->nid,
            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'dob' => Carbon::parse($request->birth_date)->format('Y-m-d'),
            'ssc_result' => $request->ssc_result,
            'ssc_passing_year' => $request->ssc_passing_year,
            'hsc_result' => $request->hsc_result,
            'hsc_passing_year' => $request->hsc_passing_year,
            'g_subject' => $request->g_subject,
            'g_result' => $request->g_result,
            'g_university' => $request->g_university,
            'g_passing_year' => $request->g_passing_year,
            'pg_subject' => $request->pg_subject,
            'pg_result' => $request->pg_result,
            'pg_university' => $request->pg_university,
            'pg_passing_year' => $request->pg_passing_year,
            'o_subject' => $request->o_subject,
            'o_result' => $request->o_result,
            'o_university' => $request->o_university,
            'o_passing_year' => $request->o_passing_year,
            'email_address' => $request->email_address,
            'contact_no' => $request->contact_no,
            'experience' => $request->experience,
            'recruitment_id' => $request->recruitment_id,
            'source_reference' => $request->source_reference,
            'create_user' => $uid,
            'create_date' => $create_date
        ];

        DB::table('mis.rms_cv_sorting')->insert($insert);
    }

    public function update_record(Request $request){

        $uid = Auth::user()->user_id;
        $update_date = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
    
        $update = [
            'nid' => $request->nid,
            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'dob' => Carbon::parse($request->birth_date)->format('Y-m-d'),
            'ssc_result' => $request->ssc_result,
            'ssc_passing_year' => $request->ssc_passing_year,
            'hsc_result' => $request->hsc_result,
            'hsc_passing_year' => $request->hsc_passing_year,
            'g_subject' => $request->g_subject,
            'g_result' => $request->g_result,
            'g_university' => $request->g_university,
            'g_passing_year' => $request->g_passing_year,
            'pg_subject' => $request->pg_subject,
            'pg_result' => $request->pg_result,
            'pg_university' => $request->pg_university,
            'pg_passing_year' => $request->pg_passing_year,
            'o_subject' => $request->o_subject,
            'o_result' => $request->o_result,
            'o_university' => $request->o_university,
            'o_passing_year' => $request->o_passing_year,
            'email_address' => $request->email_address,
            'contact_no' => $request->contact_no,
            'experience' => $request->experience,
            'recruitment_id' => $request->recruitment_id,
            'source_reference' => $request->source_reference,
            'update_user' => $uid,
            'update_date' => $update_date
        ];

         DB::table('mis.rms_cv_sorting')->where('nid',$request->nid)->update($update);
       

    }

    public function upload_records(Request $request)
    {
        try {

            $isValid = true;
            $count = 0;
            $totalRows = 0;
            $totalRowsValid = true;
            $columnsExist = true;
            $duplicateNid = [];

            \Excel::load($request->file, function ($reader) use (&$totalRowsValid, &$columnsExist, &$count, &$isValid, &$duplicateNid, &$totalRows) {

                $totalColumns = count($reader->first()->toArray());
                $totalRows = count($reader->get()->toArray());
                $firstRowArr = $reader->first()->toArray();

                if ($totalColumns === 25) {
                    if (array_key_exists('nid', $firstRowArr) && array_key_exists('recruitment_id', $firstRowArr)) {
                        $reader->each(function ($sheet) use (&$isValid) {
                            if ($sheet->nid === null || $sheet->nid === '' || $sheet->recruitment_id === null
                                || $sheet->recruitment_id === '') {
                                $isValid = false;
                            }
                        });
                        if ($isValid) {
                            $reader->each(function ($sheet) use (&$count,&$duplicateNid) {
//                                Log::info($sheet->dob);
                                $chkNid = DB::select("select nid from mis.rms_cv_sorting where nid = ?",[$sheet->nid]);
                                if(count($chkNid) > 0){
                                    $duplicateNid[] = $chkNid[0]->nid;
                                }else{
                                    $stat = DB::table('mis.rms_cv_sorting')->insert([
                                        'nid' => $sheet->nid,
                                        'candidate_name' => strtoupper($sheet->candidate_name),
                                        'father_name' => strtoupper($sheet->father_name),
                                        'dob' => Carbon::parse($sheet->dob)->format('Y-m-d'),
                                        'ssc_result' => $sheet->ssc_result,
                                        'ssc_passing_year' => $sheet->ssc_passing_year,
                                        'hsc_result' => $sheet->hsc_result,
                                        'hsc_passing_year' => $sheet->hsc_passing_year,
                                        'g_subject' => strtoupper($sheet->g_subject),
                                        'g_result' => $sheet->g_result,
                                        'g_university' => strtoupper($sheet->g_university),
                                        'g_passing_year' => $sheet->g_passing_year,
                                        'pg_subject' => strtoupper($sheet->pg_subject),
                                        'pg_result' => $sheet->pg_result,
                                        'pg_university' => strtoupper($sheet->pg_university),
                                        'pg_passing_year' => $sheet->pg_passing_year,
                                        'o_subject' => strtoupper($sheet->o_subject),
                                        'o_result' => $sheet->o_result,
                                        'o_university' => strtoupper($sheet->o_university),
                                        'o_passing_year' => $sheet->o_passing_year,
                                        'email_address' => $sheet->email_address,
                                        'contact_no' => $sheet->contact_no,
                                        'experience' => strtoupper($sheet->experience),
                                        'recruitment_id' => strtoupper($sheet->recruitment_id),
                                        'source_reference' => strtoupper($sheet->source_reference),
                                        'create_user' => Auth::user()->user_id,
                                        'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d h:i:s')
                                    ]);

                                    if ($stat) {
                                        $count++;
                                    }
                                }

                            });
                        }
                    } else {
                        $columnsExist = false;
                    }
                } else {
                    $totalRowsValid = false;
                }
            });

            if (!$totalRowsValid) {
                return response()->json(['status' => 'Total Column must be 25!', 'type' => 'error']);
            }

            if (!$columnsExist) {
                return response()->json(['status' => 'NID/ Recruitment ID column missing', 'type' => 'error']);
            }

            return response()->json(['status' => $isValid === true ? 'Excel uploaded| Total ' . $count . ' of '.$totalRows.' rows inserted' : 'No value found in Nid/Recruitment ID column!',
                'type' => $isValid === true ? 'success' : 'error','duplicate_nid' => $duplicateNid
            ]);

        } catch (\Exception $ex) {
            return response()->json(['status' => $ex->getMessage(),'type' => 'error']);
        }
    }

}