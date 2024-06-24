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

class MaternityReportController extends Controller{

	public function index(){
		$company = DB::select("select distinct com_id,com_name
		from hrms.company_info@WEB_TO_HRMS
		order by com_id ");
		return view('elm_portal.reports.MaternityView', ['com' => $company]);
	}

	public function getElmMaternityMasterInfo(Request $request){

		$empMatSummary = DB::select("select plant_id,emp_id,no_of_leave
		from mis.leave_maternity_info
		where emp_id =  decode('$request->emp_id','All',emp_id,'$request->emp_id')
		and plant_id = '$request->plant_id'");
		return response()->json($empMatSummary);
	}




	public function elmMatMasterDataUpdate(Request $request){

		$empId 		= $request->empId;
		$newValue 	= $request->newValue;
		$colName 	= $request->colName;

		if($empId != '' && $newValue != '' && $colName != '')
		{

			$x = DB::table('MIS.LEAVE_MATERNITY_INFO')
            ->where('emp_id', $empId)            
            ->update([$colName => $newValue]);  

             if($x){
            	return response()->json(['success'=>'Successfully Updated.']);
            }else{
            	return response()->json(['error'=>'ERROR! Not Updated.']);
            }       
		}
	}

	public function insElmMatMasterInfo(Request $request){

		if(!empty($request->plant_id)){

  			$auth_id = Auth::user()->user_id;
			$x = DB::table('MIS.LEAVE_MATERNITY_INFO')->insert([
				'PLANT_ID' 				=> $request->plant_id,
				'EMP_ID'   				=> $request->e_id,
				'NO_OF_LEAVE'			=> $request->no_of_lv,
				'CREATE_USER'			=> $auth_id
			]);

			if ($x) {
				return response()->json(['success'=> 'Data Saved.']);
			}else{
				return response()->json(['error'=> 'Contact Your Administrator and say employee insert form error.']);
			}
		}else {
			return response()->json(['error'=> 'Please Enter All field.']);
		}
	}

}