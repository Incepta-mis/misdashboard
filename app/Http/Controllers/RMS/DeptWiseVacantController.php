<?php


namespace App\Http\Controllers\RMS;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeptWiseVacantController
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

        $plant_name = DB::select("select distinct plant_name, plant_id from mis.rms_dept_vacant");

        return view('RMS.DeptWiseVacant')
            ->with(['plant_name' => $plant_name, 'plant_info' => $plant_info]);

    }

    public function search_vacant_id(Request $request)
    {
        $search_vacant = DB::SELECT("select * from rms_dept_vacant
                                            where vacant_id = ?", [$request->vacant_id]);

        $dept_info = DB::select("select dept_id, dept_name
                                    from hrms.dept_information@web_to_hrms
                                    where plant_id = ?", [$search_vacant[0]->plant_id]);

        $position_info = DB::select("select desig_id, desig_name
                                        from hrms.emp_designation@web_to_hrms
                                        where plant_id = ?", [$search_vacant[0]->plant_id]);

        $section_info = DB::select("select section_id, section_name
                                    from hrms.section_information@web_to_hrms
                                    where dept_id = ?
                                    and plant_id = ?", [$search_vacant[0]->dept_id, $search_vacant[0]->plant_id]);


        return response()->json(['search_vacant' => $search_vacant, 'dept' => $dept_info, 'sect' => $section_info, 'pos' => $position_info]);

    }

    public function dept_info(Request $request)
    {

        $dept_info = DB::select("select dept_id, dept_name
                                    from hrms.dept_information@web_to_hrms
                                    where plant_id = ?", [$request->plant_id]);

        return response()->json(['dept_info'=>$dept_info]);

    }

    public function dwv_get_dept_info_2(Request $request)
    {

        $dwv_get_dept_info_2 = DB::select("select distinct dept_name, dept_id from mis.rms_dept_vacant
                                        where plant_id = decode(?,'ALL',plant_id,?)", [$request->plant_id, $request->plant_id]);

        return response()->json(['dwv_get_dept_info_2'=>$dwv_get_dept_info_2]);

    }

    public function search_get_vacant_id(Request $request){

        $search_get_vacant_id = DB::select("select vacant_id from mis.rms_dept_vacant
                                            where dept_id = decode(?, 'ALL', dept_id, ?)
                                            and plant_id =  decode(?, 'ALL', plant_id, ?)", [$request->plant_id, $request->dept_id, $request->plant_id, $request->plant_id]);

        return response()->json(['search_get_vacant_id'=>$search_get_vacant_id]);

    }

    public function section_info(Request $request)
    {

        $section_info = DB::select("select section_id, trim(section_name) section_name
                                    from hrms.section_information@web_to_hrms
                                    where dept_id = ?
                                    and plant_id = ?", [$request->dept_id, $request->plant_id]);

        return response()->json(['section_info'=>$section_info]);

    }

    public function position_info(Request $request)
    {

        $position_info = DB::select("select desig_id, desig_name
                                        from hrms.emp_designation@web_to_hrms
                                        where plant_id = ?", [$request->plant_id]);

        return response()->json(['position_info'=>$position_info]);

    }

    public function dwv_save_record(Request $request)
    {
        Log::info($request->plant_id);

        $val = 'HR'.$request->plant_id.'V'.'-1';
        Log::info($val);
        $vacant_id = DB::select("select distinct substr(vacant_id,1,instr(vacant_id,'-',1,1))||
                               (select max(to_number(substr(vacant_id,instr(vacant_id,'-',-1,1)+1)))+1
                               from mis.rms_dept_vacant where plant_id = ?) vcnt_id
                               from mis.rms_dept_vacant where plant_id = ?
                               union all
                               select '$val' vacant_id
                               from dual
                               where not exists (select distinct plant_id  from mis.rms_dept_vacant where plant_id = ?)"
            , [$request->plant_id, $request->plant_id,  $request->plant_id]);


        $row =
            [
                'plant_id' => $request->plant_id,
                'plant_name' => $request->plant_name,
                'dept_id' => $request->dept_id,
                'dept_name' => $request->dept_name,
                'section_id' => $request->section_id,
                'section_name' => $request->section_name,
                'desig_id' => $request->desig_id,
                'desig_name' => $request->desig_name,
                'tnoe_organogram' => $request->position_no,
                'current_employee' => $request->presently_working,
                'total_vacant_number' => $request->total_vacant_number,
                'vacant_id' => $vacant_id[0]->vcnt_id,
                'remarks' => $request->remarks,
                'vacant_status' => $request->vacant_status,
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')

            ];

        $status = DB::table('mis.rms_dept_vacant')->insert($row);

        return response()->json(['vacant_id'=>$vacant_id]);
    }



    public function dwv_update_record (Request $request){

        $vid = $request->vacant_id;

        $row= [
            'plant_id' => $request->plant_id,
            'plant_name' => $request->plant_name,
            'dept_id' => $request->dept_id,
            'dept_name' => $request->dept_name,
            'section_id' => $request->section_id,
            'section_name' => $request->section_name,
            'desig_id' => $request->desig_id,
            'desig_name' => $request->desig_name,
            'desig_name' => $request->desig_name,
            'tnoe_organogram' => $request->position_no,
            'current_employee' => $request->presently_working,
            'total_vacant_number' => $request->total_vacant_number,
            'remarks' => $request->remarks,
            'vacant_status' => $request->vacant_status,
            'update_user' => Auth::user()->user_id,
            'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
        ];

        DB::table('mis.rms_dept_vacant')->where('vacant_id',$vid)->update($row);

    }

}