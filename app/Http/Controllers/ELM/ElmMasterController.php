<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 19/2/2019
 * Time: 3:16 PM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ElmMasterController extends Controller{

    public function index(){

        $company = DB::select("select distinct com_id,com_name
		from hrms.company_info@WEB_TO_HRMS
		order by com_id ");
        return view('elm_portal/ElmMasterInfo', ['com' => $company]);
    }

     public function getElmMasterInfo(Request $request){

        $empSummary = DB::select("

            SELECT emp_id,report_supervisor ,head_of_dept ,hr_officer,hr_officer1,hr_officer2,head_of_hr,contact_no,mail_address,nvl(mgt_status,'M') mgt_status
            FROM LEAVE_EMP_INFO
            WHERE emp_id in (
            select emp_id from(    
            select plant_id,emp_id,sur_name,desig_id,dept_id
            from hrms.emp_information@WEB_TO_HRMS
            where dept_id in (
            select dept_id
            from hrms.emp_information@WEB_TO_HRMS
            where emp_id = decode ('$request->emp_id','All',emp_id,'$request->emp_id') 
            ) and valid = decode('$request->valid','All',valid,'$request->valid') and dept_id = '$request->dept_id') a,

            (select distinct desig_id,desig_name
            from hrms.emp_designation@web_to_hrms
            where valid = 'YES') b, 

            (select distinct dept_id,dept_name
            from hrms.dept_information@web_to_hrms
            where valid = 'YES') c

            where a.desig_id = b.desig_id     
            and a.dept_id = c.dept_id
            and a.emp_id = DECODE ('$request->emp_id','All',emp_id,'$request->emp_id') 
            and a.dept_id = '$request->dept_id'
            and a.plant_id = '$request->plant_id'
            )

        ");

        return response()->json($empSummary);
    }


    public function elmMasterDataUpdate(Request $request){


        // return response()->json($request->all());

        $empId 		= $request->empId;
        $newValue 	= $request->newValue;
        $colName 	= $request->colName;

        if($colName == 'APPROVED_BY' ){
            $colName = 'head_of_dept';
        }
        elseif ($colName == 'RECOMMENDED_BY'){
            $colName = 'report_supervisor';
        }else {
            $colName = $colName ;
        }

        if($empId != '' && $newValue != '' && $colName != '')
        {

            $x = DB::table('MIS.LEAVE_EMP_INFO')
                ->where('emp_id', $empId)
                ->update([$colName => $newValue]);
        }
    }

    // public function insertElmMasterInfo(Request $request){

    // 	if(!empty($request->plant_id)){

    // 		$x = DB::table('MIS.LEAVE_EMP_INFO')->insert([
    // 			'PLANT_ID' 				=> $request->plant_id,
    // 			'EMP_ID'   				=> $request->e_id,
    // 			'REPORT_SUPERVISOR'   	=> $request->rpt_sup,
    // 			'HEAD_OF_DEPT'   	    => $request->appr_id,
    // 			'HR_OFFICER'			=> $request->hr_id1,
    // 			'HR_OFFICER1'			=> $request->hr_id2,
    // 			'HR_OFFICER2'			=> $request->hr_id3,
    // 			'HEAD_OF_HR'			=> $request->hr_head,
    // 			'CONTACT_NO'			=> $request->mobile,
    // 			'MAIL_ADDRESS'			=> $request->email,
    // 			'VALID'					=> 'YES',
    // 		]);

    // 		if ($x) {
    // 			return response()->json(['success'=> 'Data Saved.']);
    // 		}else{
    // 			return response()->json(['error'=> 'Contact Your Administrator and say employee insert form error.']);
    // 		}
    // 	}else {
    // 		return response()->json(['error'=> 'Please Enter All field.']);
    // 	}



    // }

    public function insertElmMasterInfo_16FEB2022(Request $request){


        if(!empty($request->plant_id)){

            $mgt_status = '';
            if($request->urole == 60 ){
                $mgt_status = 'NM';
            }else {
                $mgt_status = '';
            }

            $auth_id = Auth::user()->user_id;

            $x = DB::table('MIS.LEAVE_EMP_INFO')->insert([
                'PLANT_ID' 				=> $request->plant_id,
                'EMP_ID'   				=> $request->e_id,
                'REPORT_SUPERVISOR'   	=> $request->rpt_sup,
                'HEAD_OF_DEPT'   	    => $request->appr_id,
                'HR_OFFICER'			=> $request->hr_id1,
                'HR_OFFICER1'			=> $request->hr_id2,
                'HR_OFFICER2'			=> $request->hr_id3,
                'HEAD_OF_HR'			=> $request->hr_head,
                'CONTACT_NO'			=> $request->mobile,
                'MAIL_ADDRESS'			=> $request->email,
                'MGT_STATUS'			=> $mgt_status,
                'CREATE_USER'  		    => $auth_id,
                'VALID'					=> 'YES',
            ]);

            $maxx_id =  DB::select('select max(id) + 1 max_id from mis.dashboard_users_info');


            $y = DB::table('MIS.DASHBOARD_USERS_INFO')->insert([
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
                'REMEMBER_TOKEN'	=> '',
                'CREATE_USER'  		=> $auth_id,
                'VALID'				=> 'YES',
                'PLANT_ID' 				=> $request->plant_id
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
    public function insertElmMasterInfo(Request $request){

        if(!empty($request->plant_id)){

            $mgt_status = '';
            if($request->urole == 60 ){
                $mgt_status = 'NM';
            }else {
                $mgt_status = '';
            }

            $auth_id = Auth::user()->user_id;

            $dataExists =  DB::select("select * from MIS.LEAVE_EMP_INFO WHERE EMP_ID = '$request->e_id' ");

            if(count($dataExists) > 0){

                $x = DB::table('MIS.LEAVE_EMP_INFO')
                    ->where('EMP_ID', $request->e_id)
                    ->update([
                        'PLANT_ID' => $request->plant_id,
                        'REPORT_SUPERVISOR' => $request->rpt_sup,
                        'HEAD_OF_DEPT' => $request->appr_id,
                        'HR_OFFICER' => $request->hr_id1,
                        'HR_OFFICER1' => $request->hr_id2,
                        'HR_OFFICER2' => $request->hr_id3,
                        'HEAD_OF_HR' => $request->hr_head,
                        'CONTACT_NO' => $request->mobile,
                        'MAIL_ADDRESS' => $request->email,
                        'MGT_STATUS' => $mgt_status,
                        'CREATE_USER' => $auth_id,
                        'VALID' => 'YES',
                    ]);

                $y = DB::table('MIS.DASHBOARD_USERS_INFO')
                    ->where('USER_ID', $request->e_id)
                    ->update([
                        'NAME' => $request->ename,
                        'DESIG' => $request->desig,
                        'P_GROUP' => $request->p_grp,
                        'TERR_ID' => $request->terr_id,
                        'EMAIL' => $request->email,
                        'UPASSWORD' => '$2y$10$snB9YpWQTtnYni9mtOXDtukNpiiwTlbGj.SZzY1h/p2/McOAysMeC',
                        'UROLE' => $request->urole,
                        'RAW_PASSWORD' => '1234',
                        'REMEMBER_TOKEN' => '',
                        'CREATE_USER' => $auth_id,
                        'VALID' => 'YES',
                        'PLANT_ID' => $request->plant_id
                    ]);

                if ($x) {
                    return response()->json(['success' => 'Data Successfully Updated.']);
                } else {
                    return response()->json(['error' => 'Contact Your Administrator and say employee insert form error.']);
                }
            }else {
                $x = DB::table('MIS.LEAVE_EMP_INFO')->insert([
                    'PLANT_ID' => $request->plant_id,
                    'EMP_ID' => $request->e_id,
                    'REPORT_SUPERVISOR' => $request->rpt_sup,
                    'HEAD_OF_DEPT' => $request->appr_id,
                    'HR_OFFICER' => $request->hr_id1,
                    'HR_OFFICER1' => $request->hr_id2,
                    'HR_OFFICER2' => $request->hr_id3,
                    'HEAD_OF_HR' => $request->hr_head,
                    'CONTACT_NO' => $request->mobile,
                    'MAIL_ADDRESS' => $request->email,
                    'MGT_STATUS' => $mgt_status,
                    'CREATE_USER' => $auth_id,
                    'VALID' => 'YES',
                ]);

                $maxx_id = DB::select('select max(id) + 1 max_id from mis.dashboard_users_info');


                $y = DB::table('MIS.DASHBOARD_USERS_INFO')->insert([
                    'ID' => $maxx_id[0]->max_id,
                    'NAME' => $request->ename,
                    'USER_ID' => $request->e_id,
                    'DESIG' => $request->desig,
                    'P_GROUP' => $request->p_grp,
                    'TERR_ID' => $request->terr_id,
                    'EMAIL' => $request->email,
                    'UPASSWORD' => '$2y$10$snB9YpWQTtnYni9mtOXDtukNpiiwTlbGj.SZzY1h/p2/McOAysMeC',
                    'UROLE' => $request->urole,
                    'RAW_PASSWORD' => '1234',
                    'REMEMBER_TOKEN' => '',
                    'CREATE_USER' => $auth_id,
                    'VALID' => 'YES',
                    'PLANT_ID' => $request->plant_id
                ]);

                if ($x) {
                    return response()->json(['success' => 'Data Saved.']);
                } else {
                    return response()->json(['error' => 'Contact Your Administrator and say employee insert form error.']);
                }
            }
        }else {
            return response()->json(['error'=> 'Please Enter All field.']);
        }
    }

}
