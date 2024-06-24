<?php


namespace App\Http\Controllers;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class EmployeeExtentionController extends Controller
{
    /*Main Method*/
    public function displayEmpExt(Request $request)
    {

        /*$allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id"); */


        $allEmp = DB::select("select distinct emp_id,sur_name from hrms.emp_information@WEB_TO_HRMS
                            where com_id=1 order by emp_id");

        $companyData = DB::select("select distinct com_id,com_name,sap_com_id from hrms.company_info@WEB_TO_HRMS where sap_com_id='1000' ");

        return view('emp_ext.employee_extention', ['companyData' => $companyData,'allEmp' => $allEmp]);
    }

    public function getEmpInfo(Request $request){
        $emp_id = $request->employee_id;


        $allEmpData = DB::select("SELECT DISTINCT imf.SUR_NAME,dpi.dept_id,dpi.dept_name,pi.plant_id,pi.plant_name FROM  hrms.emp_information@WEB_TO_HRMS imf,
       hrms.dept_information@WEB_TO_HRMS dpi, hrms.plant_info@WEB_TO_HRMS pi  where imf.DEPT_ID = dpi.DEPT_ID   and  pi.plant_id = imf.plant_id 
       and imf.EMP_ID='$emp_id' AND imf.com_id=1");

        return response()->json(
            ['allEmpData' => $allEmpData]
        );
    }

    /*form methods*/
    public function getPlants(Request $request)
    {
        $com_code = $request->com_code;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS where SAP_CPM_ID = ? 
                     order by plant_id", [$com_code]);

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

    public function getDeptEmpData(Request $request){
        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;
        $employees = DB::select("select emp_id,sur_name from hrms.emp_information@WEB_TO_HRMS 
                     where dept_id = ? 
                     and valid='YES'
                     and plant_id = ?
                     order by emp_id",[$dept_id,$plant_id]);

        return response()->json($employees);
    }


    public function saveEmployee(Request $request)
    {

        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $empExtData = json_decode($request->employeeObject, true);

        $user_id =$empExtData['employee_id'];
        $companyData = DB::select("select distinct EMPLOYEE_ID from MIS.EMP_EXT_INFO where EMPLOYEE_ID='$user_id'");

        if($companyData){

            return response()->json(['result'=>'exists']);
        }

        $empExtData['create_user'] = $uid;
        $empExtData['create_date'] = $date;

        //return response()->json(['result'=>$empExtData]);

        $status = DB::table('MIS.EMP_EXT_INFO')->insert($empExtData);


        if ($status) {
            return response()->json(['result'=>'success']);
        } else {
            return response()->json(['result'=>'error']);

        }
    }
    /*Form method ends*/


    /*get datatable data*/
    public function getFacManagerData(Request $request)
    {
        $facManagerData =  DB::select("select id,plant_name,plant_id,COMPANY_CODE,COMPANY_NAME,DEPARTMENT_ID,DEPARTMENT_NAME,EMPLOYEE_ID,EMPLOYEE_NAME,
        PABX_NUMBER,IP_NUMBER from MIS.EMP_EXT_INFO
    
        WHERE EMPLOYEE_ID = decode ('$request->emp_id','All',EMPLOYEE_ID,'$request->emp_id') 
        AND plant_id = '$request->plant_id'
        AND DEPARTMENT_ID= '$request->dept_id'");
        return response()->json($facManagerData);
    }


    /*Selection form part*/
    public function getPlant(Request $request)
    {
        $co_id = $request->c_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from MIS.EMP_EXT_INFO where COMPANY_CODE = ? 
                      order by plant_id", [$co_id]);

        return response()->json(
            ['plant' => $allPlants]
        );
    }


    public function getDept(Request $request)
    {
        $plant_id = $request->plant_id;
        $dept = DB::select("select distinct DEPARTMENT_ID,DEPARTMENT_NAME from MIS.EMP_EXT_INFO where PLANT_ID=?", [$plant_id]);
        return response()->json(
            ['dept' => $dept]
        );
    }

    public function getDeptEmpDatas(Request $request){
        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;
        $employees = DB::select("select EMPLOYEE_ID,EMPLOYEE_NAME from MIS.EMP_EXT_INFO  
                     where department_id = ? 
                     and  plant_id = ?
                     order by employee_id",[$dept_id,$plant_id]);
        return response()->json($employees);
    }


    //delete and upadte emp ext data
    public function deleteEmpExtRecord(Request $request){

        //return $request->id;
        $id = $request->id;
        $company_code = $request->company_code;

        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.EMP_EXT_INFO WHERE ID = ?',[$id]);
            if($result){

                return response()->json(['status'=> 'success']);

            }else{
                return response()->json(['status'=> 'false']);
            }

        }else{
            return response()->json(['status'=> 2]);
        }
    }

    public function updateEmpExtData(Request $request){

        $table_id = $request->id;
        $decoded_data = json_decode($request->itemArray);


        /*$company_code = $decoded_data->company_code;
        $company_name = $decoded_data->company_name;
        $department_id = $decoded_data->department_id;
        $department_name = $decoded_data->department_name;
        $employee_name = $decoded_data->employee_name;
        $employee_id = $decoded_data->employee_id;*/
        $pabx_number = $decoded_data->pabx_number;
        $ip_number = $decoded_data->ip_number;

        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($pabx_number == ''){
            $pabx_number = NULL;
        }
        if($ip_number == ''){
            $ip_number = NULL;
        }

        $result =  DB::UPDATE("
                    UPDATE MIS.EMP_EXT_INFO
                    SET
                        PABX_NUMBER = '$pabx_number',
                        IP_NUMBER = '$ip_number',
                         UPDATE_USER = '$uid',
                        UPDATE_DATE = '$date'
                    WHERE ID = '$table_id'");

        return response()->json(['result'=> $result]);
    }
}