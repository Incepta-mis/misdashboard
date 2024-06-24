<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 5/13/2019
 * Time: 10:10 AM
 */

namespace App\Http\Controllers\ELM\Reports;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class ElmApplyLeaveDataController extends Controller
{
    public function index(){
        $company = DB::select("select distinct com_id,com_name
        from hrms.company_info@WEB_TO_HRMS
        order by com_id ");
        return view('elm_portal.reports.elmApplyInfo', ['com' => $company]);
    }

    public function getApplicantLeave(Request $request){
        try{
            $rs = DB::select("            
                select line_id,plant_id,emp_id,emp_name,emp_dept_name,emp_email,to_char(leave_from,'DD-MON-RR')leave_from,
                to_char(leave_to,'DD-MON-RR') leave_to,day_of_leave,type_of_leave
                from mis.leave_emp_record
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and emp_dept_id = '$request->dept_id'
                and plant_id = '$request->plant_id'
                order by create_date desc
            ");
            return response()->json($rs);
        }catch (Oci8Exception $e){
          $e->getMessage();
        }
    }

    public function deleteApplicantLeave(Request $request){
        try{

            DB::insert("
                insert into mis.leave_emp_record_delete
                select *
                from mis.leave_emp_record
                where line_id = '$request->line_id'
            ");


            $rs = DB::delete("delete from mis.leave_emp_record where line_id = '$request->line_id'");

            if($rs){
                return response()->json(['success'=>'Record delete successfully.']);
            }else{
                return response()->json(['error'=>'Contact Your Administrator']);
            }

        }catch (Oci8Exception $e){
           return $e->getMessage();
        }
    }


}