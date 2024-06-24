<?php


namespace App\Http\Controllers\DisEmp;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class DissimiliarEmployeeController extends Controller
{

    public function getAllEmployee(Request $request)
    {

        if ($request->plant_id) {
            if ($request->plant_id == "all") {

                $result = DB::select("
        
                   select a.emp_id, a.sur_name ,a.dept_id,b.dept_name,a.section_id,c.section_name,a.email, a.plant_id
                    from 
                        (
                            select emp_id, sur_name , dept_id, section_id, RANK_ID, EMAIL, plant_id
                            from  hrms.emp_information@web_to_hrms
                            where emp_id in
                            (
                                select distinct emp_id
                                from hrms.emp_information@web_to_hrms
                                where valid = 'YES'
                                and plant_id = decode('All','All',plant_id,'All') -- filter option
                                minus
                                select distinct user_id 
                                from mis.dashboard_users_info
                                where valid = 'YES'
                                
                            )
                        )a ,
                        (
                            select dept_id, dept_name 
                            from hrms.dept_information@web_to_hrms
                            where valid = 'YES'
                        ) b,
                        (
                            select section_id, section_name 
                            from hrms.section_information@web_to_hrms
                            where valid = 'YES'
                        ) c
                    
                    where a.dept_id = b.dept_id(+)  
                    and a.section_id = c.section_id(+)   
                    order by plant_id
                 ");
                if ($result) {
                    return response()->json(['result' => $result]);
                } else {
                    return response()->json("");
                }
            } else {
                $result = DB::select("
                    
                    select a.emp_id, a.sur_name ,a.dept_id,b.dept_name,a.section_id,c.section_name,a.email, a.plant_id
            from 
                (
                    select emp_id, sur_name , dept_id, section_id, RANK_ID, EMAIL, plant_id
                    from  hrms.emp_information@web_to_hrms
                    where emp_id in
                    (
                        select distinct emp_id
                        from hrms.emp_information@web_to_hrms
                        where valid = 'YES'
                        and plant_id = decode('All','All','$request->plant_id','All') -- filter option
                        minus
                        select distinct user_id 
                        from mis.dashboard_users_info
                        where valid = 'YES'
                        
                    )
                )a ,
                (
                    select dept_id, dept_name 
                    from hrms.dept_information@web_to_hrms
                    where valid = 'YES'
                ) b,
                (
                    select section_id, section_name 
                    from hrms.section_information@web_to_hrms
                    where valid = 'YES'
                ) c
            
            where a.dept_id = b.dept_id(+)  
            and a.section_id = c.section_id(+)   
            order by plant_id
              
               ");
                if ($result) {
                    return response()->json(['result' => $result]);
                } else {
                    return response()->json("");
                }
            }
        } else {
            return response()->json("");
        }
    }


    public function index()
    {
        $plant_info = DB::select("select plant_id,  plant_name
                                    from hrms.plant_info@web_to_hrms
                                    order by plant_name asc");

        return view('DissimilarUser.dissimilarEmployee', ['plant_info' => $plant_info]);
    }


    public function leaveDelegate()
    {
        $plant_info = DB::select("select plant_id,  plant_name
        from hrms.plant_info@web_to_hrms
        order by plant_name asc");

        if(isset($_GET['department'])){
            if($_GET['department']=='All'){
                $department = '';
            }else{
                $department = $_GET['department'];
            }
            
        }else{
            $department = '';
        }
        
        $department_list = [];

        $leave_delegates =  DB::table('mis.leave_delegate')->orderBy('create_date')->get();
        foreach($leave_delegates as $key => $leave_delegate){
            
            $emp_info = DB::select("select MIS.GET_EMP_NAME('$leave_delegate->emp_id') ename, MIS.get_emp_desig('$leave_delegate->emp_id') desig, MIS.GET_EMP_DEPT('$leave_delegate->emp_id') dept ,MIS.GET_EMP_JOINING('$leave_delegate->emp_id') jdate from dual");
            if(!in_array($emp_info[0]->dept,$department_list,true)){
                if($emp_info[0]->dept!=null){
                    array_push($department_list,$emp_info[0]->dept);
                }  
            }
            $leave_delegate->emp_name = $emp_info[0]->ename;
            $leave_delegate->designation = $emp_info[0]->desig;
            $leave_delegate->department = $emp_info[0]->dept;
            $leave_delegate->joining_date = $emp_info[0]->jdate;
            if($department!=''){
                if($department!=$emp_info[0]->dept){
                    unset($leave_delegates[$key]);
                }
            }
        }

        // dd($department_list);
        // $leave_delegates =  DB::table("leave_delegate")
        //                     ->join('hrms.emp_information@web_to_hrms','leave_delegate.emp_id','emp_information.emp_id')
        //                     ->get();
        // $leave_delegates = $leave_delegates->groupBy('emp_name','designation');
        // dd($leave_delegates);
        return view('DissimilarUser.leaveDelegate', compact('plant_info', 'leave_delegates','department_list'));
    }


    public function leaveDelegateInsert(Request $data)
    {
        $this->validate($data, [
            'employee_id' => 'required|unique:leave_delegate,emp_id|integer',
            'delegate_id.*'=>'integer'
        ]);
        DB::beginTransaction();
        try {
            $rsp_person = implode(',',$data->delegate_id);
            DB::table('mis.leave_delegate')->insert([
                'plant_id' => $data->plant_id,
                'emp_id' => $data->employee_id,
                'rsp_person' =>$rsp_person,
                'valid' => 'Yes',
                'create_user' => Auth::user()->user_id,
                'update_user' => Auth::user()->user_id,
                'update_date' => date('Y-m-d'),
            ]);
            DB::commit();
            return response()->json('ok');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function leaveDelegateUpdate(Request $data){
        $emp_id = $data->employee_id;
        $this->validate($data, [
            'employee_id' => 'required|integer',
            'delegate_id.*'=>'integer'
        ]);
        DB::beginTransaction();
        try {
            $rsp_person = implode(',',$data->delegate_id);
            DB::table('mis.leave_delegate')->where('emp_id',$data->employee_id)->update([
                'plant_id' => $data->plant_id,
                'rsp_person' =>$rsp_person,
                'valid' => 'Yes',
                'update_user' => Auth::user()->user_id,
                'update_date' => date('Y-m-d'),
            ]);
            DB::commit();
            return response()->json('ok');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
