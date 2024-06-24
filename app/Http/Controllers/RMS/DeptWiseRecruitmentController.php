<?php

namespace App\Http\Controllers\RMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeptWiseRecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $plant_info = DB::select("select plant_id,  plant_name
                                    from hrms.plant_info@web_to_hrms
                                    order by plant_name asc");

        $plant_name = DB::select("select distinct plant_name, plant_id from mis.rms_dept_recruitment");

        $search_recruitment = DB::SELECT("select * from rms_dept_recruitment where recruitm_status is null");

        return view('RMS.DeptWiseRecruitment')
            ->with(['plant_name'=>$plant_name, 'plant_info' => $plant_info, 'search_recruitment' => $search_recruitment]);

    }

    public function search_rec_id(Request $request)
    {
        $search_recruitment = DB::SELECT("select * from rms_dept_recruitment
                                            where recruitment_id = ?", [$request->recruitment_id]);

        $dept_info = DB::select("select dept_id, dept_name
                                    from hrms.dept_information@web_to_hrms
                                    where plant_id = ?", [$search_recruitment[0]->plant_id]);

        $presently_working = [];
        if($search_recruitment){
            $presently_working = DB::select("select CURRENT_EMPLOYEE pw,TNOE_ORGANOGRAM torgan
                                        from mis.RMS_DEPT_VACANT
                                        where plant_id = ?
                                        and dept_id = ?
                                        and SECTION_ID = ?",[$search_recruitment[0]->plant_id,$search_recruitment[0]->dept_id,$search_recruitment[0]->section_id]);
        }
//        dd($dept_info);

        $position_info = DB::select("select desig_id, desig_name
                                        from hrms.emp_designation@web_to_hrms
                                        where plant_id = ?", [$search_recruitment[0]->plant_id]);

        $section_info = DB::select("select section_id, section_name
                                    from hrms.section_information@web_to_hrms
                                    where dept_id = ?
                                    and plant_id = ?", [$search_recruitment[0]->dept_id, $search_recruitment[0]->plant_id]);


        return response()->json(['search_recruitment' => $search_recruitment, 'dept' => $dept_info, 'sect' => $section_info, 'pos' => $position_info,'pworking'=>$presently_working]);

    }

    public function dwr_get_dept_info_2(Request $request){

        $dwr_get_dept_info_2 = DB::select("select distinct dept_name, dept_id from mis.rms_dept_recruitment
                                        where plant_id = decode(?,'ALL',plant_id,?)",  [$request->plant_id, $request->plant_id]);

        return response()->json(['dwr_get_dept_info_2'=>$dwr_get_dept_info_2]);

    }

    public function search_get_rec_id(Request $request){

        $search_get_rec_id = DB::SELECT("select * from mis.rms_dept_recruitment where recruitm_status is null 
                                         and plant_id = decode(?,'ALL',plant_id,?) 
                                         and dept_id = decode(?,'ALL',dept_id,?)",
                                        [$request->plant_id, $request->plant_id, $request->dept_id, $request->dept_id]);


        return response()->json(['search_get_rec_id'=>$search_get_rec_id]);

    }

    public function dept_info(Request $request)
    {

        $dept_info = DB::select("select dept_id, dept_name
                                    from hrms.dept_information@web_to_hrms
                                    where plant_id = ?", [$request->plant_id]);

        return response()->json(['dept_info'=>$dept_info]);

    }

    public function section_info(Request $request)
    {

        $section_info = DB::select("select section_id, section_name
                                    from hrms.section_information@web_to_hrms
                                    where dept_id = ?
                                    and plant_id = ?", [$request->dept_id, $request->plant_id]);

        return response()->json(['section_info'=>$section_info]);

    }

    public function position_info(Request $request)
    {
        $position_info = DB::select("select desig_id, desig_name
                                        from hrms.emp_designation@web_to_hrms
                                        where plant_id = ?
                                        order by 2", [$request->plant_id]);


        $presently_working = DB::select("select CURRENT_EMPLOYEE pw,TNOE_ORGANOGRAM torgan
                                        from mis.RMS_DEPT_VACANT
                                        where plant_id = ?
                                        and dept_id = ?
                                        and SECTION_ID = ?",[$request->plant_id,$request->dept_id,$request->sect_id]);

        return response()->json(['position_info'=>$position_info,'presently_working'=>$presently_working]);

    }

    public function save_record(Request $request){
        $params = json_decode($request->formData);
        $plant_info = explode('|', $params->plant_info);
        $dept_info = explode('|', $params->dept_info);
        $section_info = explode('|', $params->section_info);
        $position = explode('|', $params->position);


        $recruitment_id = DB::select("select distinct substr(recruitment_id,1,instr(recruitment_id,'-',1,1))||
                               (select max(to_number(substr(recruitment_id,instr(recruitment_id,'-',-1,1)+1)))+1 
                               from mis.rms_dept_recruitment where plant_id = ?) rtm_id
                               from mis.rms_dept_recruitment where plant_id = ?
                               union all
                               select 'HR'||?||'-1' recruitment_id
                               from dual
                               where not exists (select distinct plant_id  from mis.rms_dept_recruitment where plant_id = ?)",
            [$plant_info[0], $plant_info[0], $plant_info[0], $plant_info[0]]);

        $imagePath = '';
        if($request->file('file')){
            $imageFile = $request->file('file');
            $imageName = $recruitment_id[0]->rtm_id.'_'.Carbon::now()->getTimestamp().'_'.'_organogram.'.$imageFile->getClientOriginalExtension();
            $imageFile->move(storage_path('/rms_docs/'),$imageName);
            $imagePath = 'storage/rms_docs/'.$imageName;
        }

        $row = [
            'plant_id' => $plant_info[0],
            'plant_name' => $plant_info[1],
            'dept_id' => $dept_info[0],
            'dept_name' => $dept_info[1],
            'section_id' => $section_info[0],
            'section_name' => $section_info[1],
            'desig_id' => $position[0],
            'desig_name' => $position[1],
            'recruitment_id' => $recruitment_id[0]->rtm_id,
            'cur_emp' => $params->presently_working,
            'tnoe_organogram' => $params->position_no,
            'recruitm_tnoe' => $params->req_tnoe,
            'recruitm_type' => $params->req_status,
            'image' => $imagePath,
            'create_user' => Auth::user()->user_id,
            'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

        ];

        $status = DB::table('mis.rms_dept_recruitment')->insert($row);


//        dd($imageName);

        return response()->json(['status'=>$status,'rid'=>$recruitment_id[0]->rtm_id]);

    }

    public function update_record (Request $request){
        Log::info($request->all());
        $params = json_decode($request->formData);
        $plant_info = explode('|', $params->plant_info);
        $dept_info = explode('|', $params->dept_info);
        $section_info = explode('|', $params->section_info);
        $position = explode('|', $params->position);
        $rid = $params->req_id;

        $imagePath = null;
        if($request->file('file')){
            $imageFile = $request->file('file');
            $imageName = $rid.'_'.Carbon::now()->getTimestamp().'_'.'_organogram.'.$imageFile->getClientOriginalExtension();
            $imageFile->move(storage_path('/rms_docs/'),$imageName);
            $imagePath = 'storage/rms_docs/'.$imageName;
        }


        $update= [
            'plant_id' => $plant_info[0],
            'plant_name' => $plant_info[1],
            'dept_id' => $dept_info[0],
            'dept_name' => $dept_info[1],
            'section_id' => $section_info[0],
            'section_name' => $section_info[1],
            'desig_id' => $position[0],
            'desig_name' => $position[1],
            'cur_emp' => $params->presently_working,
            'tnoe_organogram' => $params->position_no,
            'recruitm_tnoe' => $params->req_tnoe,
            'recruitm_type' => $params->req_status,
            'image' => $imagePath,
            'update_user' => Auth::user()->user_id,
            'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
        ];

        if($imagePath == null){
            unset($update['image']);
        }

        DB::table('mis.rms_dept_recruitment')->where('recruitment_id',$rid)->update($update);

    }

}
