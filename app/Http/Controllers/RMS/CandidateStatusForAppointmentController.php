<?php


namespace App\Http\Controllers\RMS;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;


class CandidateStatusForAppointmentController extends Controller
{
    public function index()
    {
        $plant_info = DB::select("select plant_id,  plant_name
                                    from hrms.plant_info@web_to_hrms
                                    order by plant_name asc");

        $plant_name = DB::select("select distinct plant_name, plant_id from mis.rms_dept_recruitment");

        $search_recruitment = DB::select("select * from rms_dept_recruitment where recruitm_status is null");

        return view('rms.candidateAppointmentStatus')
            ->with(['plant_name' => $plant_name, 'plant_info' => $plant_info, 'search_recruitment' => $search_recruitment]);
    }

    public function csfGetDeptInfo(Request $request)
    {

        $csfGetDeptInfo = DB::select("select distinct dept_name, dept_id from mis.rms_dept_recruitment
                                        where plant_id = decode(?,'ALL',plant_id,?)", [$request->plant_id, $request->plant_id]);

        return response()->json(['csfGetDeptInfo' => $csfGetDeptInfo]);
    }

    public function csf_search_get_rec_id(Request $request)
    {

        $csf_search_get_rec_id = DB::SELECT(
            "select * from mis.rms_dept_recruitment where recruitm_status is null 
                                         and plant_id = decode(?,'ALL',plant_id,?) 
                                         and dept_id = decode(?,'ALL',dept_id,?)",
            [$request->plant_id, $request->plant_id, $request->dept_id, $request->dept_id]
        );

        return response()->json(['csf_search_get_rec_id' => $csf_search_get_rec_id]);
    }

    public function csf_search1_get_rec_id(Request $request)
    {
        $csf_search1_get_rec_id = DB::SELECT(
            "select distinct ca.recruitment_id
            from mis.rms_candidate_assessment ca,mis.rms_dept_recruitment dr
            where ca.recruitment_id = dr.recruitment_id
            and nvl(recruitm_status,'TITUMIR') <> 'COMPLETED' 
            and plant_id = decode(?,'ALL',plant_id,?) 
            and dept_id = decode(?,'ALL',dept_id,?)",
            [$request->plant_id, $request->plant_id, $request->dept_id, $request->dept_id]
        );

        return response()->json(['csf_search1_get_rec_id' => $csf_search1_get_rec_id]);
    }

    public function csf_source_reference(Request $request)
    {

        $csf_source_reference = DB::SELECT(
            "select distinct reference source_reference
             from mis.rms_candidate_assessment ca,mis.rms_dept_recruitment dr
             where ca.recruitment_id = decode(?,'ALL',dr.recruitment_id,?)
             and nvl(recruitm_status,'TITUMIR') <> 'COMPLETED'
            ",
            [$request->recrut_id, $request->recrut_id]
        );

        return response()->json(['csf_source_reference' => $csf_source_reference]);
    }

    public function csf_nid(Request $request)
    {

        $csf_nid = DB::SELECT(
            "select distinct nid
            from(
            select 'ALL' all_data,er.recruitment_id,cvs.source_reference,er.nid,ssc_point,hsc_point,university_point,written_exam_point,
               interview_point,f_interview_point,total_point
            from mis.rms_exam_record er,mis.rms_cv_sorting cvs
            where er.recruitment_id = cvs.recruitment_id
            and er.nid = cvs.nid
            and er.recruitment_id = ?
            )where ? = case when ? = 'ALL' then all_data else source_reference end",
            [$request->recrut_id, $request->sou_ref, $request->sou_ref]
        );

        return response()->json(['csf_nid' => $csf_nid]);
    }

    public function getDataForInsert(Request $request)
    {
        $csf_ins = DB::select("select recruitment_id,candidate_name,source_reference,nid,ssc_point,hsc_point,university_point,written_exam_point,interview_point,f_interview_point,total_point
        from(
        select 'ALL' all_data,er.recruitment_id,er.candidate_name,cvs.source_reference,er.nid,ssc_point,hsc_point,university_point,written_exam_point,
               interview_point,f_interview_point,total_point
        from mis.rms_exam_record er,mis.rms_cv_sorting cvs
        where er.recruitment_id = cvs.recruitment_id
        and er.nid = cvs.nid
        and er.nid in (select nid from mis.rms_exam_record where recruitment_id = ?
             minus
             select nid from mis.RMS_CANDIDATE_ASSESSMENT where recruitment_id = ?)
        and er.recruitment_id = ?
        )", [$request->recrut_id, $request->recrut_id, $request->recrut_id]);

        return response()->json($csf_ins);
    }

    public function subDataForInsert(Request $request)
    {

        // Log::info($request->all());
        $uid = Auth::user()->user_id;
        $dataArr = json_decode($request['ar']);
        $len = $request->total_length;

        $filename = [];
        $nidArr = [];
        $test = [];
        $test2 = [];
        foreach ($request->except('_token', 'ar', 'total_length') as $key => $part) {

            if (file_exists($part)) {
                //Log::info($part);
                $f_name = time() . '_' . $part->getClientOriginalName();
                $image_resize = Image::make($part->getRealPath());
                //$image_resize->resize(492, 484);
                $image_resize->save(public_path('/rms_medical_images/' . $f_name));
                // Log::info($part);
                $test[] = [
                    'sl' => $key,
                    'fname' => time() . '_' . $part->getClientOriginalName()
                ];
                array_push($filename, time() . '_' . $part->getClientOriginalName());
            } else {
                if ($part !== 'undefined') {
                    $test2[] = [
                        'sl' => $key,
                        'nid' => $part
                    ];
                    array_push($nidArr, $part);
                }
            }
        }


        /*Log::info($test);
        Log::info($test2);
        Log::info($dataArr);
        Log::info($filename);
        Log::info($nidArr);
        Log::info($dataArr[0]->recruitment_id);*/
        $final = [];

        foreach ($test2 as $t2) {
            foreach ($test as $t) {
                //    Log::info(substr($t2['sl'],12));
                //    Log::info(substr($t['sl'],9));
                if (substr($t2['sl'], 12) == substr($t['sl'], 9)) {
                    $final[] = [
                        'nid' => $t2['nid'],
                        'fname' => $t['fname']
                    ];
                }
            }
        }

        //Log::info($final);


        for ($i = 0; $i < count($dataArr); $i++) {

            if (!empty($dataArr[$i]->source_reference)) {
                $source_reference = $dataArr[$i]->source_reference;
            } else {
                $source_reference = '';
            }

            $_image_path = '';
            foreach ($final as $f) {
                if ($dataArr[$i]->nid == $f['nid']) {
                    $_image_path = '/rms_medical_images/' . $f['fname'];
                }
            }

            $dataSet[] = [
                'recruitment_id' => $dataArr[$i]->recruitment_id,
                'reference' => $source_reference,
                'medical_result_image' => $_image_path,
                'nid' => $dataArr[$i]->nid,
                'ssc_point' => $dataArr[$i]->ssc_point,
                'hsc_point' => $dataArr[$i]->hsc_point,
                'university_point' => $dataArr[$i]->university_point,
                'written_exam_point' => $dataArr[$i]->written_exam_point,
                'first_intrview' => $dataArr[$i]->interview_point,
                'final_intrview' => $dataArr[$i]->f_interview_point,
                'total_point' => $dataArr[$i]->total_point,
                'medical_result' => $dataArr[$i]->medical_result,
                'candidate_assessment' => $dataArr[$i]->assessment,
                'create_user' => $uid
            ];
        }


        try {
            $rs = DB::table('mis.rms_candidate_assessment')->insert($dataSet);
            if ($rs) {
                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Contact Your Administrator.']);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            //dd($ex->getCode());
            return response()->json(['error' => 'Contact Your Administrator.']);
        }
    }


    public function getCandidateResult(Request $request)
    {
        DB::select(
            "select recruitment_id,source_reference,nid,ssc_point,hsc_point,university_point,written_exam_point,interview_point,f_interview_point,total_point
        from(
        select 'ALL' all_data,er.recruitment_id,cvs.source_reference,er.nid,ssc_point,hsc_point,university_point,written_exam_point,
               interview_point,f_interview_point,total_point
        from mis.rms_exam_record er,mis.rms_cv_sorting cvs
        where er.recruitment_id = cvs.recruitment_id
        and er.nid = cvs.nid
        and er.recruitment_id = ?
        )where ? = case when ? = 'ALL' then all_data else source_reference end
        and  ? = case when ? = 'ALL' then all_data else nid end",
            [$request->recrut_id, $request->sou_ref, $request->sou_ref, $request->nid, $request->nid]
        );
    }

    public function getDataForUpdate(Request $request)
    {
        $csf_ins = DB::select("
        select recruitment_id,candidate_name,reference,nid,ssc_point,hsc_point,university_point,written_exam_point,first_intrview,
        final_intrview,total_point,medical_result,medical_result_image,candidate_assessment
        from
        (
        select 'ALL' all_data,ca.recruitment_id,cs.candidate_name, reference, ca.nid,ssc_point, hsc_point,university_point,written_exam_point,first_intrview,final_intrview, 
            total_point,medical_result,medical_result_image,candidate_assessment
        from mis.rms_candidate_assessment ca,mis.rms_dept_recruitment dr,MIS.RMS_CV_SORTING cs
        where ca.recruitment_id = dr.recruitment_id
        and ca.recruitment_id = cs.recruitment_id(+)
        and ca.nid = cs.nid(+)
        and nvl(recruitm_status,'TITUMIR') <> 'COMPLETED'
        and ca.recruitment_id = ?
        )where '$request->source_reference1' = case when '$request->source_reference1' = 'ALL' then all_data else reference end
        and '$request->nid' = case when '$request->nid' = 'ALL' then all_data else nid end
        ", [$request->recrut_id]);

        return response()->json($csf_ins);
    }

    public function csf_post_cas_data(Request  $request)
    {
        //$uid = Auth::user()->user_id;
        $_image_path = '';
        if($request->hasFile('file')){
            try {
                $candidate_nid = $request->candidateNID;
                $ms = DB::select("select medical_result_image from mis.rms_candidate_assessment where nid = '$candidate_nid'");
                if(!empty($ms[0]->medical_result_image)){
                    unlink(public_path().$ms[0]->medical_result_image);
                }
            }catch (Oci8Exception $exception){
                Log::info('Candidate Status for Appointment Controller');
                Log::info($exception->getMessage());
            }

            $file = $request->file; // get the validated file
            //$extension = $file->getClientOriginalExtension();
            $mName = $file->getClientOriginalName();
            $filename = time() . '_' . $mName;
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(492, 484);
            $image_resize->save(public_path('/rms_medical_images/'  . $filename),40);
            $_image_path = '/rms_medical_images/' .$filename;
            $dataArray = [
                'medical_result_image' => $_image_path,
                'medical_result' => $request->medical_result,
                'candidate_assessment' => $request->candidate_assessment,
            ];

            try {
                $rs = DB::table('mis.rms_candidate_assessment')
                    ->where('nid', $request->candidateNID)
                    ->update($dataArray);
                if($rs){ return response()->json(['success'=>'Successfully Updated. ! ']);}
                else{return response()->json(['error'=>'Contact Your Administrator. ! ']);}

            }catch (Oci8Exception $exception){
                Log::info('Candidate Status for Appointment Controller');
                Log::info($exception->getMessage());
            }

        }else{

            $dataArray = [
                'medical_result' => $request->medical_result,
                'candidate_assessment' => $request->candidate_assessment,
            ];

            try {
                $rs = DB::table('mis.rms_candidate_assessment')
                    ->where('nid', $request->candidateNID)
                    ->update($dataArray);
                if ($rs) {
                    return response()->json(['success' => 'Successfully Updated. ! ']);
                } else {
                    return response()->json(['error' => 'Contact Your Administrator. ! ']);
                }
            }catch (Oci8Exception $exception){
                Log::info('Candidate Status for Appointment Controller');
                Log::info($exception->getMessage());
            }
        }

    }


}
