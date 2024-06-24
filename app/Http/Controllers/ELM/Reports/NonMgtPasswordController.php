<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/3/2019
 * Time: 10:08 AM
 */

namespace App\Http\Controllers\ELM\Reports;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NonMgtPasswordController extends Controller
{
    public function index(){

        $employees = DB::select("
        
            select a.emp_id emp_id, a.emp_id ||' - '|| b.name name
            from
            (select distinct emp_id 
            from leave_emp_info 
            where mgt_status ='NM') a , (select distinct user_id, name from dashboard_users_info ) b
            where a.emp_id = b.user_id
            order by a.emp_id
        
        ");

        return view('elm_portal.reports.nonMgt_Password',['employees'=>$employees]);
    }

    public function getNonMgtData(Request $request){

        $resp = DB::select("
        
            select distinct user_id,name,desig,raw_password
            from dashboard_users_info
            where user_id in (
            select distinct emp_id
            from leave_emp_info
            where mgt_status ='NM'
            and emp_id = '$request->emp_id'
            )
            and user_id = '$request->emp_id'

        
        ");

        return response()->json($resp);
    }

}