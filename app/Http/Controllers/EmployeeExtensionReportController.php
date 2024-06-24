<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeExtensionReportController extends Controller
{
    public function index(){
        $companyData = DB::select("select company_code com_id,company_name com_name from mis.emp_ext_info ");
        return view('emp_ext.empExtReport', ['companyData' => $companyData]);
    }

    public function getPlantData(Request $request)
    {
        $co_id = $request->c_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from mis.emp_ext_info where company_code = ? order by plant_id", [$co_id]);


        return response()->json(
            ['plant' => $allPlants]
        );
    }

    public function getDepts(Request $request)
    {
        $plant_id = $request->plant_id;
        $comp_id = $request->comp_id;

        $dept = DB::select("select distinct department_id dept_id,department_name dept_name
        from mis.emp_ext_info where plant_id= decode('$plant_id','All',plant_id,'$plant_id')
        and company_code='$comp_id'");
        return response()->json(
            ['dept' => $dept]
        );
    }

    public function getDeptEmpDatas(Request $request){

        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;

        $employees = DB::select("select employee_id emp_id,employee_name sur_name
        from mis.emp_ext_info
        where department_id=decode('$dept_id','All',department_id,'$dept_id')
        and plant_id = decode ( '$plant_id' ,'All', plant_id, '$plant_id' )
        order by employee_id");

        return response()->json($employees);
    }

    public function getEmpExtReport(Request $request){
        $plant_id = $request->plant_id;
        $dept_id = $request->dept_id;
        $emp_id = $request->emp_id;
        $comp_id = $request->comp_id;

        if($plant_id == "All"){
            $allPlants = DB::select("select distinct plant_id,plant_name from mis.emp_ext_info where company_code = '$comp_id' order by plant_id");
        }else{
            $allPlants = DB::select("select distinct plant_id,plant_name from mis.emp_ext_info where company_code = '$comp_id' and plant_id = '$plant_id' order by plant_id");
        }

        if($plant_id == "All"){
            $plant_id = "ALL";
        }
        if($dept_id == "All"){
            $dept_id = "ALL";
        }
        if($emp_id == "All"){
            $emp_id = "ALL";
        }

        $qry = DB::select("select plant_id, plant_name, department_id, department_name,employee_id, employee_name,pabx_number,ip_number from(
                                select 'ALL' all_data,plant_id,plant_name,department_id,department_name, employee_id,employee_name, pabx_number, ip_number from mis.emp_ext_info
                            ) where '$plant_id' = case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
                            and '$dept_id' = case when '$dept_id' = 'ALL' then all_data else to_char(department_id) end
                            and '$emp_id' = case when '$emp_id' = 'ALL' then all_data else to_char(employee_id) end");

        $plantWiseArr = [];
        foreach ($allPlants as $plant){
            $plant_name = $plant->plant_name;
            $temp = array_filter($qry, function($item) use ($plant_name) {
                if($item->plant_name == $plant_name){
                    return $item;
                }
            });
            if(count($temp) > 0){
                array_push($plantWiseArr, $temp);
            }
        }

        $deptWiseArr = [];
        foreach ($plantWiseArr as $plantData){
            $plantData = array_values($plantData);
            $temp = [];
            $temp['plant_name'] = $plantData[0]->plant_name;
            $temp['deptWiseEmps'] = [];

            $dept = array_column($plantData, 'department_name');
            $dept = array_unique($dept);
            $dept = array_values($dept);

            foreach ($dept as $d){
                $temp1 = [];
                $temp1['dept_name'] = $d;
                $temp1['empList'] = [];
                foreach ($plantData as $data){
                    if($data->department_name == $d){
                        $temp2 = [];
                        $temp2['employee_id'] = $data->employee_id;
                        $temp2['employee_name'] = $data->employee_name;
                        $temp2['pabx_number'] = $data->pabx_number;
                        $temp2['ip_number'] = $data->ip_number;
                        array_push($temp1['empList'],$temp2);
                    }
                }
                array_push($temp['deptWiseEmps'],$temp1);
            }
            array_push($deptWiseArr, $temp);
        }
        return response()->json(['result'=>$qry,'allPlants'=>$allPlants,'deptWiseArr'=>$deptWiseArr,'plantWiseArr'=>$plantWiseArr]);
    }
}