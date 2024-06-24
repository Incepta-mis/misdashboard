<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 19/2/2019
 * Time: 3:16 PM
 */

namespace App\Http\Controllers\ELM\Reports;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PLheadReportController extends Controller{

	public function index(){
		$company = DB::select("select distinct com_id,com_name
		from hrms.company_info@WEB_TO_HRMS
		order by com_id ");
		return view('elm_portal.reports.PlHeadView', ['com' => $company]);
	}

	public function getElmPLMasterInfo(Request $request){

		$plSummary = DB::select("select plant_id, pl_head_name, pl_emp_id, pl_email 
			from MIS.LEAVE_PLANT_HEAD where plant_id = DECODE(?,'All',plant_id,?)", [$request->plant_id,$request->plant_id]);
		return response()->json($plSummary);
	}

	public function elmPLMasterDataUpdate(Request $request){

		// return response()->json($request->all());

		$plantId 	= $request->plantId;
		$newValue 	= $request->newValue;
		$colName 	= $request->colName;

		// if($colName == 'APPROVED_BY' ){
		// 	$colName = 'head_of_dept';
		// }
		// elseif ($colName == 'RECOMMENDED_BY'){
		// 	$colName = 'report_supervisor';
		// }else {
		// 	$colName = $colName ;
		// }

		if($plantId != '' && $newValue != '' && $colName != '')
		{
			$x = DB::table('MIS.LEAVE_PLANT_HEAD')
            ->where('plant_id', $plantId)
            ->update([$colName => $newValue]);    
            if($x){
            	return response()->json(['success'=>'Successfully Updated.']);
            }else{
            	return response()->json(['error'=>'ERROR! Not Updated.']);
            }        
		}
	}

	public function insertElmPLMasterInfo(Request $request){
		if(!empty($request->plant_id)){

			$x = DB::table('MIS.LEAVE_PLANT_HEAD')->insert([
				'PLANT_ID' 				=> $request->plant_id,
				'PL_HEAD_NAME'   		=> $request->pl_h_name,
				'PL_EMP_ID'   				=> $request->e_id,
				'PL_EMAIL'				=> $request->pl_h_email
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