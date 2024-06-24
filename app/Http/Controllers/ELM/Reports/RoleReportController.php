<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 24/2/2019
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\ELM\Reports;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleReportController extends Controller{

	public function index(){
		$company = DB::select("select distinct com_id,com_name
		from hrms.company_info@WEB_TO_HRMS
		order by com_id ");
		return view('elm_portal.reports.RoleView', ['com' => $company]);
	}

	public function getElmRoleInfo(Request $request){

		$empRoleSummary = DB::select("select a.id,a.name,a.user_id,a.desig,a.email,a.urole
		from
		(select id,name,user_id,desig,email,urole
		from mis.dashboard_users_info
		where user_id = decode ('$request->emp_id','All',user_id,'$request->emp_id') ) a,
		                                (
		                                    select plant_id,emp_id,sur_name,desig_id,dept_id
		                                    from hrms.emp_information@web_to_hrms
		                                    where dept_id = '$request->dept_id'
		                                    and plant_id = '$request->plant_id'
		                                    and valid = 'YES'
		                                )b
		                            
		where a.user_id = b.emp_id
		and a.user_id = decode ('$request->emp_id','All',user_id,'$request->emp_id')");
		return response()->json($empRoleSummary);
	}

	public function elmUpRoleInfo(Request $request){
		// return response()->json($request->all());

		$empId 		= $request->empId;
		$newValue 	= $request->newValue;
		$colName 	= $request->colName;

		if($empId != '' && $newValue != '' && $colName != '')
		{
			$x = DB::table('MIS.DASHBOARD_USERS_INFO')
            ->where('user_id', $empId)
            ->update([$colName => $newValue]);          

              if($x){
            	return response()->json(['success'=>'Successfully Updated.']);
            }else{
            	return response()->json(['error'=>'ERROR! Not Updated.']);
            }       
		}else {
			return response()->json(['error'=> 'Please Contact Your Administrator.']);
		}

	}

	public function insElmRoleInfo(Request $request){

		if($request->ajax()){

			if(empty($request->e_id)){
				return response()->json(['error'=> 'Please Enter Employee Id.']);
			}elseif(empty($request->ename)){
				return response()->json(['error'=> 'Please Enter Employee Name.']);
			}elseif(empty($request->desig)){
				return response()->json(['error'=> 'Please Enter Designation.']);
			}elseif(empty($request->p_grp)){
				return response()->json(['error'=> 'Please Enter Product Group default NA.']);
			}elseif(empty($request->terr_id)){
				return response()->json(['error'=> 'Please Enter Territory default NA.']);
			}elseif(empty($request->email)){
				return response()->json(['error'=> 'Please Enter Email address.']);
			}elseif(empty($request->urole)){
				return response()->json(['error'=> 'Please Select User Role.']);
			}else{

				$maxx_id =  DB::select('select max(id) + 1 max_id from mis.dashboard_users_info');

				$auth_id = Auth::user()->user_id;
				$x = DB::table('MIS.DASHBOARD_USERS_INFO')->insert([
					'ID'				=> $maxx_id[0]->max_id,
					'NAME' 				=> $request->ename,
					'USER_ID'   		=> $request->e_id,
					'DESIG'				=> $request->desig,
					'P_GROUP'			=> $request->p_grp,
					'TERR_ID'			=> $request->terr_id,
					'EMAIL'				=> $request->email,
					'UPASSWORD'	 		=> '$2y$10$snB9YpWQTtnYni9mtOXDtukNpiiwTlbGj.SZzY1h/p2/McOAysMeC',
					'UROLE'  			=> $request->urole,
					'RAW_PASSWORD' 		=> '1234',
					'REMEMBER_TOKEN'	=> 'C3Pfsk2FkiXQt6c3hQvCT8WLkJV2j7Nvh2x0LY5NWlMpmFdJNkqH4J54r5VN',
					'CREATE_USER'  		=> $auth_id,
					'VALID'				=> 'YES'
				]);

				if ($x) {
					return response()->json(['success'=> 'Data Saved.']);
				}else{
					return response()->json(['error'=> 'Contact Your Administrator and say employee insert form error.']);
				}

			}

		}else {
				return response()->json(['error'=> 'Please Contact Your Administrator.']);
		}	
	}
}