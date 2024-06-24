<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FactoryRCMuserInfoController extends Controller
{
    public function index()
    {
        $companyData = DB::select("select distinct com_id,com_name from hrms.company_info@WEB_TO_HRMS order by com_id ");
        return view('factoryManagerInfo.rcmUserView', ['companyData' => $companyData]);
    }
    public function getPlants(Request $request)
    {
        $co_id = $request->c_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS where com_id = ? 
                     AND plant_id IN (select distinct plant_id from mis.leave_factory_rcm_user) order by plant_id", [$co_id]);

        return response()->json(
            ['plant' => $allPlants]
        );
    }
    public function getDeptEmpData(Request $request){
        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;

        $employees = DB::select("select a.emp_id,a.sur_name from hrms.emp_information@WEB_TO_HRMS a INNER JOIN mis.leave_factory_rcm_user b ON a.emp_id = b.emp_id
                     where a.dept_id = ? 
                     and a.valid='YES'
                     and b.plant_id = ?
                     order by emp_id",[$dept_id,$plant_id]);

        return response()->json($employees);
    }
    public function getFacRCMuserData(Request $request)
    {
        $facRCMuserData = DB::select("select a.name,a.user_id,a.desig,c.desig_id,c.dept_id,b.plant_id,d.plant_name,b.valid from mis.dashboard_users_info a 
        INNER JOIN mis.leave_factory_rcm_user b ON a.user_id = b.emp_id
        INNER JOIN hrms.emp_information@web_to_hrms c ON b.emp_id = c.emp_id
        INNER JOIN hrms.plant_info@WEB_TO_HRMS d ON d.plant_id = b.plant_id
		WHERE a.user_id = decode ('$request->emp_id','All',a.user_id,'$request->emp_id') 
		AND b.plant_id = '$request->plant_id'
		AND c.dept_id = '$request->dept_id'
		AND c.valid = 'YES'");

        return response()->json($facRCMuserData);
    }
    public function facRCMuserUpdate(Request $request)
    {
        $uid = Auth::user()->user_id;
        $plant_id = $request->plant_id;
        $emp_id = $request->emp_id;
        $valid_txt = $request->valid_txt;
        $row_index = $request->row_index;
        $datetime = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $updateQry = DB::update(" UPDATE mis.leave_factory_rcm_user set valid = ? , update_user = ? , update_date = ? 
                     WHERE plant_id = ? AND emp_id = ?",[$valid_txt , $uid, $datetime, $plant_id, $emp_id]);
        $response =  array('status'=> $updateQry, 'eleID'=>'#valid_Idx_'.$row_index, 'valid_txt'=>$valid_txt);

        return response()->json($response);
    }
    public function getOtherDeptEmpData(Request $request){
        $sel_dept_id = $request->sel_dept_id;
        $sel_pl = $request->sel_pl;

        $employees = DB::select("select a.emp_id,a.sur_name from hrms.emp_information@WEB_TO_HRMS a INNER JOIN hrms.dept_information@WEB_TO_HRMS b 
                     ON a.dept_id = b.dept_id
                     where a.dept_id = '".$sel_dept_id."'
                     and b.plant_id = '".$sel_pl."'
                     and a.valid='YES'
                     and a.emp_id NOT IN (
                         select a.emp_id from hrms.emp_information@WEB_TO_HRMS a 
                         INNER JOIN mis.leave_factory_rcm_user b ON a.emp_id = b.emp_id
                         where a.dept_id = '" . $sel_dept_id . "'
                         and a.valid='YES'
                         and b.plant_id = '" . $sel_pl . "'
                     )
                     order by a.emp_id");

        return response()->json($employees);
    }
    public function createNewFacRCMuser(Request $request)
    {
        $uid = Auth::user()->user_id;
        $sel_plant_id = $request->sel_plant_id;
        $sel_emp_id = $request->sel_emp_id;
        $datetime = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $qry = DB::insert('insert into mis.leave_factory_rcm_user (plant_id, emp_id, create_user, create_date, valid)
               values (?, ?, ?, ?, ?)', [$sel_plant_id, $sel_emp_id, $uid, $datetime, 'YES']);
        if($qry) {
            $res = array('status'=>'200');
        } else {
            $res = array('status'=>'300');
        }
        return response()->json($res);
    }
}
