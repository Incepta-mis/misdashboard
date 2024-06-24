<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactoryManagerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyData = DB::select("select distinct com_id,com_name from hrms.company_info@WEB_TO_HRMS order by com_id ");
        return view('factoryManagerInfo.display', ['companyData' => $companyData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewFacMangr(Request $request)
    {
        $sel_plant_id = $request->sel_plant_id;
        $sel_dept_id = $request->sel_dept_id;
        $sel_emp_id = $request->sel_emp_id;
        $surname = $request->surname;
        $desig = $request->desig;

        $qry = DB::insert('insert into mis.leave_factory_mgr (plant_id, emp_id, name, designation, valid) 
               values (?, ?, ?, ?, ?)', [$sel_plant_id, $sel_emp_id, $surname, $desig, 'YES']);
        if($qry) {
            $res = array('status'=>'200');
        } else {
            $res = array('status'=>'300');
        }
        return response()->json($res);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function facManagerUpdate(Request $request)
    {
        $plant_id = $request->plant_id;
        $emp_id = $request->emp_id;
        $valid_txt = $request->valid_txt;
        $row_index = $request->row_index;

        $updateQry = DB::update("UPDATE mis.leave_factory_mgr set valid = ? WHERE plant_id = ? AND emp_id = ?",
            [$valid_txt , $plant_id, $emp_id]);
        $response =  array('status'=> $updateQry, 'eleID'=>'#valid_Idx_'.$row_index, 'valid_txt'=>$valid_txt);

        return response()->json($response);
    }
    public function getFacManagerData(Request $request)
    {
        $facManagerData = DB::select("select a.name,a.user_id,a.desig,c.desig_id,c.dept_id,b.plant_id,d.plant_name,b.valid from mis.dashboard_users_info a 
        INNER JOIN mis.leave_factory_mgr b ON a.user_id = b.emp_id
        INNER JOIN hrms.emp_information@web_to_hrms c ON b.emp_id = c.emp_id
        INNER JOIN hrms.plant_info@WEB_TO_HRMS d ON d.plant_id = b.plant_id
		WHERE a.user_id = decode ('$request->emp_id','All',a.user_id,'$request->emp_id') 
		AND b.plant_id = '$request->plant_id'
		AND c.dept_id = '$request->dept_id'
		AND c.valid = 'YES'");

        return response()->json($facManagerData);
    }
    public function getPlants(Request $request)
    {
        $co_id = $request->c_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS where com_id = ? 
                     AND plant_id IN (select distinct plant_id from mis.leave_factory_mgr) order by plant_id", [$co_id]);

        return response()->json(
            ['plant' => $allPlants]
        );
    }
    public function getAllPlants(Request $request)
    {
        $sel_comp_id = $request->sel_comp_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=? order by plant_id", [$sel_comp_id]);
        return response()->json(
            ['allPlants' => $allPlants]
        );
    }
    public function getDepts(Request $request)
    {
        $plant_id = $request->plant_id;
        $dept = DB::select("select distinct dept_id,dept_name from hrms.dept_information@WEB_TO_HRMS where plant_id=?", [$plant_id]);
        return response()->json(
            ['dept' => $dept]
        );
    }
    public function getAllDepts(Request $request)
    {
        $sel_plant_id = $request->sel_plant_id;
        $allDepts = DB::select("select distinct dept_id,dept_name from hrms.dept_information@WEB_TO_HRMS
                    where plant_id=?", [$sel_plant_id]);
        return response()->json(
            ['allDepts' => $allDepts]
        );
    }
    public function getEmployeeDataByID(Request $request)
    {
        $elemp_id = $request->selemp_id;
        $EmpData = DB::select("select a.emp_id,a.sur_name, b.desig from hrms.emp_information@WEB_TO_HRMS a INNER JOIN mis.dashboard_users_info b 
                   ON a.emp_id = b.user_id
                   WHERE a.emp_id=? and a.valid='YES'", [$elemp_id]);
        return response()->json(
            ['emp' => $EmpData]
        );
    }
    public function getDeptEmpData(Request $request){
        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;
        $employees = DB::select("select a.emp_id,a.sur_name from hrms.emp_information@WEB_TO_HRMS a INNER JOIN mis.leave_factory_mgr b ON a.emp_id = b.emp_id
                     where a.dept_id = ? 
                     and a.valid='YES'
                     and b.plant_id = ?
                     order by emp_id",[$dept_id,$plant_id]);

        return response()->json($employees);
    }
    public function getRestDeptEmpData(Request $request){
        $sel_dept_id = $request->sel_dept_id;
        $sel_pl = $request->sel_pl;

        $employees = DB::select("select a.emp_id,a.sur_name from hrms.emp_information@WEB_TO_HRMS a INNER JOIN hrms.dept_information@WEB_TO_HRMS b 
                     ON a.dept_id = b.dept_id
                     where a.dept_id = '".$sel_dept_id."'
                     and b.plant_id = '".$sel_pl."'
                     and a.valid='YES'
                     and a.emp_id NOT IN (
                         select a.emp_id from hrms.emp_information@WEB_TO_HRMS a 
                         INNER JOIN mis.leave_factory_mgr b ON a.emp_id = b.emp_id
                         where a.dept_id = '" . $sel_dept_id . "'
                         and a.valid='YES'
                         and b.plant_id = '" . $sel_pl . "'
                     )
                     order by a.emp_id");

        return response()->json($employees);
    }
}
