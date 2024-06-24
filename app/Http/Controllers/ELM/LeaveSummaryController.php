<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 2/6/2019
 * Time: 9:19 AM
 */

namespace App\Http\Controllers\ELM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveSummaryController extends Controller
{
    public function index()
    {
        $company = DB::select("select distinct com_id,com_name
        from hrms.company_info@WEB_TO_HRMS
        order by com_id ");
        return view('elm_portal/Leave_summary', ['com' => $company]);
    }

    public function getDeptEmp(Request $request){

        $employees = DB::select("select emp_id,sur_name
        from hrms.emp_information@WEB_TO_HRMS
        where dept_id = ?
        and valid='YES'
        order by emp_id",[$request->dept_id]);

        return response()->json($employees);

    }


    public function applicantSummary(Request $request){
        
    DB::statement("alter session set nls_date_format = 'DD-MON-RRRR'");
    $empSummary =     DB::select("select x.plant_id,x.emp_id,sur_name name,desig_name,dept_name,annual,casual,lwp,maternity,medical,advance,special_medical,total_leave,nvl(mis.fun_absent_emp(x.emp_id),0) absent
from
(
    select a.plant_id,a.emp_id,a.sur_name,a.dept_id,b.desig_id,b.desig_name,c.dept_name
    from
    (select plant_id,emp_id,sur_name,desig_id,dept_id
    from hrms.emp_information@WEB_TO_HRMS
    where dept_id in (
    select dept_id
    from hrms.emp_information@WEB_TO_HRMS
    where emp_id = DECODE ('$request->emp_id','All',emp_id,'$request->emp_id')
    and valid = 'YES')
    and valid = 'YES') a, (select distinct desig_id,desig_name
    from hrms.emp_designation@web_to_hrms
    where valid = 'YES') b, (select distinct dept_id,dept_name
    from hrms.dept_information@web_to_hrms
    where valid = 'YES') c
    where a.desig_id = b.desig_id     
    and a.dept_id = c.dept_id
    and a.emp_id = DECODE ('$request->emp_id','All',emp_id,'$request->emp_id') ) x,
           (
            SELECT emp_id,ANNUAL,CASUAL,LWP,MATERNITY,MEDICAL,ADVANCE,SPECIAL_MEDICAL, 
            SUM ( nvl (ANNUAL,0) + nvl (CASUAL,0) + nvl (LWP,0) + nvl (MATERNITY,0) + nvl (MEDICAL,0) + nvl (ADVANCE,0) + nvl (SPECIAL_MEDICAL,0) ) TOTAL_LEAVE
            FROM
            (
            SELECT    x.emp_id
            ,MAX(DECODE(x.leave_type, 'ANNUAL', x.TOTAL_ENJOYED_LEAVE)) ANNUAL
            ,MAX(DECODE(x.leave_type, 'CASUAL', x.TOTAL_ENJOYED_LEAVE)) CASUAL
            ,MAX(DECODE(x.leave_type, 'LWP', x.TOTAL_ENJOYED_LEAVE)) LWP
            ,MAX(DECODE(x.leave_type, 'MATERNITY', x.TOTAL_ENJOYED_LEAVE)) MATERNITY          
            ,MAX(DECODE(x.leave_type, 'MEDICAL', x.TOTAL_ENJOYED_LEAVE)) MEDICAL
            ,MAX(DECODE(x.leave_type, 'ADVANCE', x.TOTAL_ENJOYED_LEAVE)) ADVANCE 
            ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.TOTAL_ENJOYED_LEAVE)) SPECIAL_MEDICAL
            FROM    (
            SELECT   r.emp_id
            ,r.leave_type
            ,r.TOTAL_ENJOYED_LEAVE
            ,r.leave_year
            FROM    hrms.v_employee_leave_status@web_to_hrms r
            ) x
            WHERE X.EMP_ID = decode('$request->emp_id','All',emp_id,'$request->emp_id')
            AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
            GROUP BY x.emp_id 
            )
            group by emp_id,ANNUAL,CASUAL,LWP,MATERNITY,MEDICAL,ADVANCE,SPECIAL_MEDICAL
              
            )y
            
where x.emp_id = y.emp_id 
and x.dept_id = ?
and x.plant_id = ?
and x.emp_id = decode(?,'All',x.emp_id,?)",[$request->dept_id,$request->plant_id,$request->emp_id,$request->emp_id]);

        return response()->json($empSummary);
    }


}