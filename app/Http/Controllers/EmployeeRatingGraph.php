<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeRatingGraph extends Controller
{

    public function index(){

        $logged_uid = Auth::user()->user_id;
        
        $company = [];
        $department = [];
          
        $acess_all = DB::select("SELECT EMPLOYEE_ALL FROM MIS.EMPLOYEE_SUPERVISOR where emp_id = ?",[$logged_uid]);
         
        // if(count($acess_all) > 0){
            
        //     if($acess_all[0]->employee_all=='YES'){
        //         //            echo "laravel lili";
        //     $company=DB::select("select * from hrms.company_info@web_to_hrms ci");
        //     //return view('emp_competency.erg_view')->with(['company'=>$company,'acess_all'=>$acess_all]);
        //     }

        // }else{
            
            Log::info('inside');
            $company = DB::select(" Select DISTINCT COMPANY_CODE,company_name from (
                select distinct COMPANY_CODE,company_name
                from mis.employee_supervisor
                where supervisor_emp_id  = '$logged_uid'
                union all
                select distinct COMPANY_CODE,company_name
                from mis.employee_supervisor
                where emp_id  = '$logged_uid'
                )");

            $department = DB::select("Select DISTINCT DEPT_ID,dept_name from (
                            select distinct DEPT_ID,dept_name
                            from mis.employee_supervisor
                            where supervisor_emp_id  = '$logged_uid'
                            union all
                            select distinct DEPT_ID,dept_name
                            from mis.employee_supervisor
                            where emp_id  = '$logged_uid'
                            )");
            
            
        // }
        
        Log::info(['company'=>$company,'department'=>$department,'acess_all'=>$acess_all]);

        return view('emp_competency.erg_view')->with(['company'=>$company,'department'=>$department,'acess_all'=>[]]);
    }

    //fatema 
    public function getDeptList(Request $request){
        if($request->ajax()){

            $com_id=$request->com_id;

             $department = DB::select("select distinct di.dept_id id,dept_name,di.plant_id, pii.plant_name plant_name
                                  from hrms.emp_information@web_to_hrms ei,hrms.dept_information@web_to_hrms di,hrms.plant_info@web_to_hrms pii
                                  where ei.dept_id = di.dept_id
                                            and di.plant_id = pii.plant_id
                                            and di.com_id=? order by dept_name", [$com_id]);

            // $department = DB::select("select distinct di.dept_id id,dept_name name
            //                         from hrms.emp_information@web_to_hrms ei,hrms.dept_information@web_to_hrms di
            //                         where ei.dept_id = di.dept_id
            //                         and di.com_id=?", [$com_id]);


            return response()->json([  'department'=>$department ]);
        }

    }

    //fatema

    public function getEmpListByDept(Request $request){
        if($request->ajax()){

            $dep_id=$request->dept_id;
            $emplist = DB::select("select emp_id id,sur_name||' '||emp_id name
                                      from hrms.emp_information@web_to_hrms
                                      where dept_id = ? order by sur_name", [$dep_id]);


            return response()->json([  'emplist'=>$emplist ]);
        }

    }


    public function get_selection_data(Request $request){
        if($request->ajax()){

           if($request['type'] == 'E') {

               $logged_uid = Auth::user()->user_id;
               $comid = $request->input('cid');
               $depid = $request->input('cdept');

               $employees = DB::select("select distinct emp_id,emp_name
                                            from mis.employee_supervisor
                                            where supervisor_emp_id  = '$logged_uid'
                                            and COMPANY_CODE = '$comid'
                                            and dept_id = '$depid'
                                            union all
                                            select distinct emp_id,emp_name
                                            from mis.employee_supervisor
                                            where emp_id  = '$logged_uid'
                                            and COMPANY_CODE = '$comid'
                                            and dept_id = '$depid'
                                            ");

               return response()->json(['results'=>$employees]);
           }
        }
    }
    

    public function get_rating_data(Request $request){
        if($request->ajax()){

            $user_id = $request['uid'];
            $cid = $request['cid'];
            $dept = $request['cdept'];



            $employee_info = DB::select("select distinct to_char(RATING_DATE,'DD-MON-RR') rating_Date,COMPANY_NAME,EMP_ID,EMP_NAME,DESIG_NAME,DEPT_NAME,
                                                   CREATE_USER_ID acrid,create_user_name acrname,case when CREATE_USER_ID <> '$user_id' then 'SUPER' else 'OWN' end utype
                                            from MIS.EMP_COMPETENCY_RATING_MASTER
                                            where EMP_ID = '$user_id'
                                            ");

            $rating_data = DB::select("select ecc.ecompc_sl,erd.ECOMPC,initcap(erd.ECOMPC_DESC) description,rmaster||well_developed||developing||to_be_developed||poor as cval
                                              ,case when emp_id = create_user_id then 'EMPLOYEE' else 'SUPERVISOR' end rating_status
                                        from mis.emp_competency_rating_master erm,mis.emp_competency_rating_details erd,mis.emp_competence_category ecc
                                        where erm.ecrm_id = erd.ecrm_id
                                        and erd.ecompc = ecc.ecompc
                                        and erd.ecompc_desc = ecc.ecompc_desc
                                        and erm.emp_id = '$user_id'
                                        and erm.COMPANY_CODE = '$cid'
                                        and erm.dept_id = '$dept'
                                        and rmaster||well_developed||developing||to_be_developed||poor > 0
                                        order by ecompc_sl,ecompc_desc_sl");

            return response()->json(['rdata'=>$rating_data,'edata'=>$employee_info]);
        }
    }

}
