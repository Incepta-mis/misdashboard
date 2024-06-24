<?php
/**
 * Created by PhpStorm.
 * User: raqib
 * Date: 1/14/2018
 * Time: 9:05 AM
 */


namespace App\Http\Controllers;

use App\EMPLOYEE_SUPERVISOR;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Employee_Supervisor_Controller extends Controller
{
    /**
     * @return $this
     */
    public function index(){

//       $desig = auth()->user()->desig;
//       $id = auth()->user()->user_id;

//       if($desig === 'HO' || strtoupper($desig) === 'ALL'){
//           $emp_company = DB::select('select com_name name,com_id id
//                                        from hrms.company_info@web_to_hrms ci
//                                        order by com_id');
//
//           $emp_department = DB::select("select di.dept_id id,dept_name||' '||'('||pi.plant_id||'-'||pi.plant_name||')' name
//                                            from hrms.dept_information@web_to_hrms di,hrms.plant_info@web_to_hrms pi
//                                            where di.plant_id = pi.plant_id
//                                            and di.com_id = 1
//                                            order by dept_name");
//       }
//       else{
//           $emp_company = DB::select('select ci.com_id id,com_name name
//                                    from hrms.emp_information@web_to_hrms ei,hrms.company_info@web_to_hrms ci
//                                    where ei.com_id = ci.com_id
//                                    and emp_id = ?',[$id]);
//
//           $emp_department = DB::select('select di.dept_id id,dept_name name
//                                            from hrms.emp_information@web_to_hrms ei,hrms.dept_information@web_to_hrms di
//                                            where ei.dept_id = di.dept_id
//                                            and emp_id = ?',[$id]);
//       }

        $login_emp_id=Auth::user()->user_id;

//        $user_infos=DB::select("select EMP_ID,DESIG_NAME, EMP_NAME, COMPANY_NAME,COMPANY_CODE,PLANT_ID,PLANT_NAME,DEPT_ID,DEPT_NAME,SUPERVISOR_EMP_ID,SUPERVISOR_EMP_NAME
//                        from mis.employee_supervisor
//                        where supervisor_emp_id  = ?
//                        union all
//                        select EMP_ID,DESIG_NAME, EMP_NAME, COMPANY_NAME,COMPANY_CODE,PLANT_ID,PLANT_NAME,DEPT_ID,DEPT_NAME,SUPERVISOR_EMP_ID,SUPERVISOR_EMP_NAME
//                        from mis.employee_supervisor
//                        where emp_id  = ?",[$login_emp_id,$login_emp_id]);

        $user_infos=DB::select("select ei.emp_id,ei.dept_id,ei.com_id,di.dept_name,ci.com_name company_name
                    from hrms.emp_information@web_to_hrms ei,hrms.dept_information@web_to_hrms di,hrms.company_info@web_to_hrms ci
                    where ei.dept_id=di.dept_id
                    and ei.com_id=ci.com_id
                    and ei.emp_id=?",[$login_emp_id]);

        $user_dept_id=$user_infos[0]->dept_id;
        $user_com_id=$user_infos[0]->com_id;

        $emp_list=DB::select("select emp_id,sur_name
            from hrms.emp_information@web_to_hrms
            where dept_id=? and com_id=?",[$user_dept_id,$user_com_id]);

//        dd($user_infos);

//        $dsd="dsds";
//        var_dump($dsd);
//        var_dump($user_dept_id);

//        dd( $emp_list);



        return view('emp_competency.es_view',compact('user_infos','emp_list'));


//        return view('emp_competency.es_view')->with(['company'=>$emp_company,'department'=>$emp_department]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_dept_data(Request $request){
        $fetchedReq = $request->json()->all();

        $emp_department = DB::select("select di.dept_id id,dept_name||' '||'('||pi.plant_id||'-'||pi.plant_name||')' name
                                            from hrms.dept_information@web_to_hrms di,hrms.plant_info@web_to_hrms pi
                                            where di.plant_id = pi.plant_id
                                            and di.com_id = ?
                                            order by dept_name",[$fetchedReq['ccode']]);

        return response()->json(['results'=>$emp_department]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_param_data(Request $request){
        $fetchedReq = $request->json()->all();
        if($fetchedReq['type'] == 'D'){
            return response()->json(['results'=>$fetchedReq]);
        }
        elseif($fetchedReq['type'] == 'E'){

            $employees = DB::select("select emp_id id,sur_name||' '||emp_id name
                                        from hrms.emp_information@web_to_hrms
                                        where dept_id = ?
                                        and emp_id <> ?
                                        order by sur_name",[$fetchedReq['dept'],Auth::user()->user_id]);

            return response()->json(['results'=>$employees]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_data_from_tab(Request $request){
        $fetchedReq = $request->json()->all();

        if($fetchedReq['type'] ==='NEW'){

            $uid = auth()->user()->user_id;
            $uname = auth()->user()->name;

            if($fetchedReq['eid'] === 'All'){
                $emp_data = DB::select("select sap_com_id ccode,com_name cname,pi.plant_id pid,pi.plant_name pname,di.dept_id did,di.dept_name dname,
                                               emp_id eid,sur_name ename,DESIG_NAME edesig,'$uid' seid,upper('$uname') sename,'YES' valid,0 r,0 d,0 h
                                        from hrms.emp_information@web_to_hrms ei,hrms.company_info@web_to_hrms ci,hrms.plant_info@web_to_hrms pi,
                                             hrms.dept_information@web_to_hrms di,hrms.EMP_DESIGNATION@web_to_hrms dgi
                                        where ei.com_id = ci.com_id
                                        and ei.plant_id = pi.plant_id
                                        and ei.dept_id = di.dept_id
                                        and ei.DESIG_ID = dgi.DESIG_ID
                                        and ei.dept_id = ?
                                        and ei.emp_id not in (select to_char(emp_id) from mis.EMPLOYEE_SUPERVISOR where SUPERVISOR_EMP_ID = ?)
                                        and emp_id <> to_char(?)
                                        order by sur_name",
                                        [$fetchedReq['did'],Auth::user()->user_id,Auth::user()->user_id]);
                return response()->json(['results'=>$emp_data]);
            }
            else{
                $data = DB::select('Select * from mis.EMPLOYEE_SUPERVISOR 
                                where EMP_ID = ? and SUPERVISOR_EMP_ID = ?'
                    ,[$fetchedReq['eid'],Auth::user()->user_id]);

                if(count($data) == 0){
                    $emp_data = DB::select("select sap_com_id ccode,com_name cname,pi.plant_id pid,pi.plant_name pname,di.dept_id did,di.dept_name dname,
                                               emp_id eid,sur_name ename,DESIG_NAME edesig,'$uid' seid,upper('$uname') sename,'YES' valid,0 r,0 d,0 h
                                        from hrms.emp_information@web_to_hrms ei,hrms.company_info@web_to_hrms ci,hrms.plant_info@web_to_hrms pi,
                                             hrms.dept_information@web_to_hrms di,hrms.EMP_DESIGNATION@web_to_hrms dgi
                                        where ei.com_id = ci.com_id
                                        and ei.plant_id = pi.plant_id
                                        and ei.dept_id = di.dept_id
                                        and ei.DESIG_ID = dgi.DESIG_ID
                                        and emp_id = ?",[$fetchedReq['eid']]);
                    return response()->json(['results'=>$emp_data]);
                }
                else{
                    return response()->json(['results'=>'Employee Supervisor Already Assigned']);
                }
            }

        }elseif($fetchedReq['type'] ==='EXT'){

            if($fetchedReq['eid'] === 'All'){
                $emp_data = DB::select('select company_code ccode,company_name cname,plant_id pid,plant_name pname,dept_id did,dept_name dname,
                                           emp_id eid,emp_name ename,desig_name edesig,supervisor_emp_id seid,supervisor_emp_name sename,valid,1 r,1 d,1 h
                                    from MIS.EMPLOYEE_SUPERVISOR
                                    where dept_ID = ? and SUPERVISOR_EMP_ID = ?',[$fetchedReq['did'],Auth::user()->user_id]);

                if(count($emp_data) > 0){
                    return response()->json(['results'=>$emp_data]);
                }
                else{
                    return response()->json(['results'=>'No Assigned Employees Found']);
                }

            }
            else{
                $emp_data = DB::select('select company_code ccode,company_name cname,plant_id pid,plant_name pname,dept_id did,dept_name dname,
                                           emp_id eid,emp_name ename,desig_name edesig,supervisor_emp_id seid,supervisor_emp_name sename,valid,1 r,1 d,1 h
                                    from MIS.EMPLOYEE_SUPERVISOR
                                    where EMP_ID = ? and SUPERVISOR_EMP_ID = ?',[$fetchedReq['eid'],Auth::user()->user_id]);

                if(count($emp_data) > 0){
                    return response()->json(['results'=>$emp_data]);
                }
                else{
                    return response()->json(['results'=>'Employee Supervisor Not Assigned']);
                }
            }

        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveRecord(Request $request){
        $fetchedReq = $request->json()->all();

        $message = '';
        foreach ($fetchedReq as $fr){
            $check = DB::select('select * from mis.EMPLOYEE_SUPERVISOR where emp_id = ?',[$fr['eid']]);
            if(count($check) == 0){
                $max_id = DB::select('Select nvl(max(es_id),0)+1 mval from mis.EMPLOYEE_SUPERVISOR');
                $irecord = [
                    'ES_ID' => $max_id[0]->mval,
                    'COMPANY_CODE' => $fr['ccode'],
                    'COMPANY_NAME' => $fr['cname'],
                    'PLANT_ID' => $fr['pid'],
                    'PLANT_NAME' => $fr['pname'],
                    'DEPT_ID' => $fr['did'],
                    'DEPT_NAME' => $fr['dname'],
                    'EMP_ID' => $fr['eid'],
                    'EMP_NAME' => $fr['ename'],
                    'DESIG_NAME' => $fr['edesig'],
                    'SUPERVISOR_EMP_ID' => $fr['seid'],
                    'SUPERVISOR_EMP_NAME' => strtoupper($fr['sename']),
                    'VALID' => $fr['valid'],
                    'CREATE_USER_ID' => Auth::user()->user_id,
                    'CREATE_USER_NAME' => strtoupper(Auth::user()->name),
                    'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
                ];

                EMPLOYEE_SUPERVISOR::insert($irecord);
                $message = 'Record Saved Successfully';
            }
            else{
                $message = 'Record Already Saved';
            }

        }

        return response()->json(['response'=>$message]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRecord(Request $request){
        $fetchedReq = $request->json()->all();

        $message = '';
        foreach ($fetchedReq as $fr){
            $urecord = [
                'SUPERVISOR_EMP_ID' => $fr['seid'],
                'SUPERVISOR_EMP_NAME' => strtoupper($fr['sename']),
                'VALID' => $fr['valid'],
                'UPDATE_USER' => Auth::user()->user_id,
                'UPDATE_DATE' =>  Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s')
            ];

            EMPLOYEE_SUPERVISOR::where(['EMP_ID'=>$fr['eid']])
                ->update($urecord);
            $message = 'Record Updated Successfully';
        }

        return response()->json(['response'=>$message]);
    }
}
