<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/8/2018
 * Time: 5:16 PM
 */

namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use App\LeaveEmpRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;


//use Illuminate\Support\Facades\Validator;


class ApplyLeaveController extends Controller
{
    public function index()
    {
        DB::setDateFormat('DD-MON-RR');

        $uid = Auth::user()->user_id;


        $chkEmp = DB::select("
            select count(emp_id) cnt from mis.leave_emp_balance_over
            where emp_id = '$uid'
        ");
        if($chkEmp[0]->cnt > 0){
            return view('elm_portal.reports.elm_unauthorized');
        }

        $emp_info = DB::select("select a.plant_id,a.emp_id,a.sur_name,nvl(a.gender,'MALE') gender,b.desig_id,b.desig_name,c.dept_id,c.dept_name,a.plant_id,d.contact_no,d.mail_address,d.report_supervisor,d.head_of_dept
      from 
      (select emp_id,sur_name,desig_id,dept_id,plant_id,gender
      from hrms.emp_information@WEB_TO_HRMS
      where emp_id = '$uid'
      and valid = 'YES') a, (select distinct desig_id,desig_name
      from hrms.emp_designation@web_to_hrms
      where valid = 'YES') b, (select distinct dept_id,dept_name
      from hrms.dept_information@web_to_hrms
      where valid = 'YES') c, (select distinct emp_id,contact_no,mail_address,report_supervisor,head_of_dept
      from mis.leave_emp_info
      where emp_id = '$uid'
      ) d
      where a.desig_id = b.desig_id  
      and   a.dept_id = c.dept_id
      and   a.emp_id = d.emp_id");


        if (empty($emp_info)) {
            return view('elm_portal.reports.error_page');
        }


        /*$employees = DB::select("select a.emp_id,a.sur_name,b.desig_id,b.desig_name,c.dept_name
        from
        (


        select emp_id,sur_name,desig_id,dept_id
        from hrms.emp_information@WEB_TO_HRMS
        where dept_id = (
        select dept_id
        from hrms.emp_information@WEB_TO_HRMS
        where emp_id = '$uid'
        and valid = 'YES')
        and valid='YES'
        AND EMP_ID IN
            (
                select l.emp_id emp_i
                from hrms.emp_information@WEB_TO_HRMS h,mis.leave_emp_info l
                where dept_id = (
                        select dept_id
                        from hrms.emp_information@WEB_TO_HRMS
                        where emp_id = '$uid'
                        and valid = 'YES'
                    )
                and h.valid = 'YES'
                and h.emp_id = l.emp_id
                minus
                select distinct emp_id emp_id
                from mis.leave_emp_info
                where mgt_status = 'NM'
            )


        ) a, (select distinct desig_id,desig_name
        from hrms.emp_designation@web_to_hrms
        where valid = 'YES') b, (select distinct dept_id,dept_name
        from hrms.dept_information@web_to_hrms
        where valid = 'YES') c
        where a.desig_id = b.desig_id     
        and a.dept_id = c.dept_id
        and a.emp_id not in '$uid'");

        //   $leaveTypes = DB::select("select distinct leave_type
        // from hrms.leave_information@web_to_hrms
        // where valid = 'YES'
        // order by leave_type asc");
        */            

        // $employees = DB::select("
        //     select a.emp_id,a.sur_name,b.desig_id,b.desig_name,c.dept_name
        //     from hrms.emp_information@web_to_hrms a,hrms.emp_designation@web_to_hrms b,
        //          hrms.dept_information@web_to_hrms c,
        //     (select emp_id
        //     from hrms.emp_information@web_to_hrms ei,(select dept_id,section_id
        //                                               from hrms.emp_information@web_to_hrms                                              
        //                                               where emp_id = '$uid') edi
        //     where ei.dept_id = edi.dept_id
        //     and ei.section_id = edi.section_id
        //     and ei.valid = 'YES'
        //     minus
        //     select distinct emp_id emp_id from mis.leave_emp_info where mgt_status = 'NM') rei
        //     where a.desig_id = b.desig_id
        //     and a.dept_id =c.dept_id
        //     and a.emp_id = rei.emp_id
        //     and a.emp_id != '$uid'  
        // ");

        // $employees = DB::select("
        //                 select a.emp_id,a.sur_name,b.desig_id,b.desig_name,c.dept_name
        //                 from hrms.emp_information@web_to_hrms a,hrms.emp_designation@web_to_hrms b,
        //                 hrms.dept_information@web_to_hrms c,mis.leave_emp_info lei,
        //                 (
        //                 (select emp_id
        //                 from hrms.emp_information@web_to_hrms ei,(select dept_id,section_id
        //                                                   from hrms.emp_information@web_to_hrms                                              
        //                                                   where emp_id = '$uid') edi
        //                 where ei.dept_id = edi.dept_id
        //                 and ei.section_id = edi.section_id
        //                 and ei.valid = 'YES'
        //                 and emp_id <> '$uid'
        //                 minus
        //                 select distinct emp_id emp_id from mis.leave_emp_info where mgt_status = 'NM')
        //                 union all
        //                 select emp_id from
        //                 (select emp_id
        //                 from hrms.emp_information@web_to_hrms ei,(select dept_id,section_id
        //                                                   from hrms.emp_information@web_to_hrms                                              
        //                                                   where emp_id = '$uid') edi
        //                 where ei.dept_id = edi.dept_id
        //                 and ei.valid = 'YES'
        //                 and emp_id <> '$uid'
        //                 minus
        //                 select distinct emp_id emp_id from mis.leave_emp_info where mgt_status = 'NM')
        //                 where not exists
        //                 (select emp_id
        //                 from hrms.emp_information@web_to_hrms ei,(select dept_id,section_id
        //                                                   from hrms.emp_information@web_to_hrms                                              
        //                                                   where emp_id = '$uid') edi
        //                 where ei.dept_id = edi.dept_id
        //                 and ei.section_id = edi.section_id
        //                 and ei.valid = 'YES'
        //                 and emp_id <> '$uid'
        //                 minus
        //                 select distinct emp_id emp_id from mis.leave_emp_info where mgt_status = 'NM'))rei
        //                 where a.desig_id = b.desig_id
        //                 and a.dept_id =c.dept_id
        //                 and a.emp_id = rei.emp_id
        //                 and a.emp_id = lei.emp_id
        // ");


        if(
            (
            !($emp_info[0]->plant_id == '1000') &&
            !($emp_info[0]->plant_id == '1100') &&
            !($emp_info[0]->plant_id == '2100') &&
            !($emp_info[0]->plant_id == '1300') &&
            !($emp_info[0]->plant_id == '1400') &&
            !($emp_info[0]->plant_id == '2200') &&
            !($emp_info[0]->plant_id == '4100') &&
            !($emp_info[0]->plant_id == '5100') &&
            !($emp_info[0]->plant_id == '5000')
            )
        ){
            $employees = DB::select("select a.emp_id,a.sur_name,b.desig_id,b.desig_name,c.dept_name
              from
              (
            
            
              select emp_id,sur_name,desig_id,dept_id
              from hrms.emp_information@WEB_TO_HRMS
              where dept_id = (
              select dept_id
              from hrms.emp_information@WEB_TO_HRMS
              where emp_id = '$uid'
              and valid = 'YES')
              and valid='YES'
              AND EMP_ID IN
                  (
                      select l.emp_id emp_i
                      from hrms.emp_information@WEB_TO_HRMS h,mis.leave_emp_info l
                      where dept_id = (
                              select dept_id
                              from hrms.emp_information@WEB_TO_HRMS
                              where emp_id = '$uid'
                              and valid = 'YES'
                          )
                      and h.valid = 'YES'
                      and h.emp_id = l.emp_id
                      minus
                      select distinct emp_id emp_id
                      from mis.leave_emp_info
                      where mgt_status = 'NM'
                  )
            
            
              ) a, (select distinct desig_id,desig_name
              from hrms.emp_designation@web_to_hrms
              where valid = 'YES') b, (select distinct dept_id,dept_name
              from hrms.dept_information@web_to_hrms
              where valid = 'YES') c
              where a.desig_id = b.desig_id
              and a.dept_id = c.dept_id
              and a.emp_id not in '$uid'");




        }else{


            $employees = DB::select("
                        select a.emp_id,a.sur_name,b.desig_id,b.desig_name,c.dept_name
                        from hrms.emp_information@web_to_hrms a,hrms.emp_designation@web_to_hrms b,
                        hrms.dept_information@web_to_hrms c,mis.leave_emp_info lei,
                        (
                        (select emp_id
                        from hrms.emp_information@web_to_hrms ei,(select dept_id,section_id
                                                          from hrms.emp_information@web_to_hrms                                              
                                                          where emp_id = '$uid') edi
                        where ei.dept_id = edi.dept_id
                        and ei.section_id = edi.section_id
                        and ei.valid = 'YES'
                        and emp_id <> '$uid'
                        minus
                        select distinct emp_id emp_id from mis.leave_emp_info where mgt_status = 'NM')
                        union all
                        select emp_id from
                        (select emp_id
                        from hrms.emp_information@web_to_hrms ei,(select dept_id,section_id
                                                          from hrms.emp_information@web_to_hrms                                              
                                                          where emp_id = '$uid') edi
                        where ei.dept_id = edi.dept_id
                        and ei.valid = 'YES'
                        and emp_id <> '$uid'
                        minus
                        select distinct emp_id emp_id from mis.leave_emp_info where mgt_status = 'NM')
                        where not exists
                        (select emp_id
                        from hrms.emp_information@web_to_hrms ei,(select dept_id,section_id
                                                          from hrms.emp_information@web_to_hrms                                              
                                                          where emp_id = '$uid') edi
                        where ei.dept_id = edi.dept_id
                        and ei.section_id = edi.section_id
                        and ei.valid = 'YES'
                        and emp_id <> '$uid'
                        minus
                        select distinct emp_id emp_id from mis.leave_emp_info where mgt_status = 'NM'))rei
                        where a.desig_id = b.desig_id
                        and a.dept_id =c.dept_id
                        and a.emp_id = rei.emp_id
                        and a.emp_id = lei.emp_id
        ");
        }





        if ($emp_info[0]->gender == 'MALE') {
            $leaveTypes = DB::select("select distinct leave_type
                            from hrms.leave_information@web_to_hrms    
                            where valid = 'YES' 
                            and leave_type != 'MATERNITY'   
                            order by leave_type asc");
        } else {
            $leaveTypes = DB::select("select distinct leave_type
            from hrms.leave_information@web_to_hrms    
            where valid = 'YES'    
            order by leave_type asc");
        }


        $leaveStatus = DB::select("SELECT    x.emp_id 
      ,MAX(DECODE(x.leave_type, 'ANNUAL', x.total_allowed_leave)) ANNUAL
      ,MAX(DECODE(x.leave_type, 'CASUAL', x.total_allowed_leave)) CASUAL
      ,MAX(DECODE(x.leave_type, 'LWP', x.total_allowed_leave)) LWP
      ,MAX(DECODE(x.leave_type, 'MATERNITY', x.total_allowed_leave)) MATERNITY          
      ,MAX(DECODE(x.leave_type, 'MEDICAL', x.total_allowed_leave)) MEDICAL
      ,MAX(DECODE(x.leave_type, 'ADVANCE', x.total_allowed_leave)) ADVANCE 
      ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.total_allowed_leave)) SPECIAL_MEDICAL
      FROM    (
      SELECT   r.emp_id
      ,r.leave_type
      ,r.total_allowed_leave
      ,r.leave_year
      FROM    hrms.v_employee_leave_status@web_to_hrms r
      ) x
      WHERE X.EMP_ID = '$uid'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
      GROUP BY x.emp_id
      
      UNION ALL
      
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
      WHERE X.EMP_ID = '$uid'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
      GROUP BY x.emp_id  
      
      UNION ALL
      
      SELECT    x.emp_id
      ,MAX(DECODE(x.leave_type, 'ANNUAL', x.total_available_leave)) ANNUAL
      ,MAX(DECODE(x.leave_type, 'CASUAL', x.total_available_leave)) CASUAL
      ,MAX(DECODE(x.leave_type, 'LWP', x.total_available_leave)) LWP
      ,MAX(DECODE(x.leave_type, 'MATERNITY', x.total_available_leave)) MATERNITY          
      ,MAX(DECODE(x.leave_type, 'MEDICAL', x.total_available_leave)) MEDICAL
      ,MAX(DECODE(x.leave_type, 'ADVANCE', x.total_available_leave)) ADVANCE 
      ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.total_available_leave)) SPECIAL_MEDICAL
      FROM    (
      SELECT   r.emp_id
      ,r.leave_type
      ,r.total_available_leave
      ,r.leave_year
      FROM    hrms.v_employee_leave_status@web_to_hrms r
      ) x
      WHERE X.EMP_ID = '$uid'
      AND X.leave_year = (select to_char(sysdate,'RRRR') from dual)          
      GROUP BY x.emp_id ");

        // $absentStatus = DB::select("
        //             SELECT emp_id,emp_name,working_status, to_char(working_date,'dd-Mon-rrrr') wk_date
        //             FROM hrms.emp_work_status_final@web_to_hrms
        //             WHERE emp_id = '$uid'
        //             AND to_date(to_char(working_date,'DD-MON-RR'),'DD-MON-RR') 
        //             BETWEEN to_char(trunc(sysdate - 1,'YEAR'),'DD-MON-RR') AND to_char(sysdate,'DD-MON-RR')    
        //             AND working_status = 'ABSENT'
        //             ORDER BY working_date ASC                             
        // ");

        $absentStatus = DB::select("
                    SELECT emp_id,emp_name,working_status, to_char(working_date,'dd-Mon-rrrr') wk_date
                    FROM hrms.emp_work_status_final@web_to_hrms
                    WHERE emp_id = '$uid'   
                    AND to_date(to_char(working_date,'DD-MON-RR'),'DD-MON-RR') BETWEEN add_months(trunc(sysdate,'mm'),-12)  AND to_char(sysdate,'DD-MON-RR')                     
                    AND working_status = 'ABSENT'
                    ORDER BY working_date ASC                             
        ");


        $matStatus = DB::select("
                    SELECT no_of_leave
                    FROM mis.leave_maternity_info
                    WHERE emp_id = '$uid'
    ");


        $mgt_status = DB::select("
                        SELECT mgt_status
                        FROM mis.leave_emp_info
                        WHERE emp_id = '$uid'
                    ");

        $exception_emp = DB::select("
            select count (emp_id) emp_cnt
            from mis.leave_emp_exception
            where emp_id = '$uid'
            and valid = 'YES'
        ");                     

         $factMgr = DB::select("select emp_id from mis.leave_factory_mgr");

        return view('elm_portal/apply_leave', ['emp_info' => $emp_info, 'employees' => $employees,
            'leaveTypes' => $leaveTypes, 'leaveStatus' => $leaveStatus, 'absentStatus' => $absentStatus,
            'matStatus' => $matStatus, 'mgt_status' => $mgt_status[0]->mgt_status,
             'factMgr' => $factMgr,'exception_emp' =>$exception_emp
        ]);
    }


    public function checkDeptHead(Request $request){
        try{
            $rs = DB::select("
                select count(*) cnt
                from mis.leave_factory_mgr
                where emp_id = '$request->emp_id'
            ");
            return response()->json($rs);
        } catch (Oci8Exception $e){
            return response()->json($e);
        }
    }

    public function getEmpInfo(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::select("select a.emp_id,a.sur_name,b.desig_id,b.desig_name,c.dept_id,c.dept_name,a.plant_id,d.report_supervisor,d.contact_no,d.mail_address
        from 
        (select emp_id,sur_name,desig_id,dept_id,plant_id
        from hrms.emp_information@WEB_TO_HRMS
        where emp_id = ?
        and valid = 'YES') a, (select distinct desig_id,desig_name
        from hrms.emp_designation@web_to_hrms
        where valid = 'YES') b, (select distinct dept_id,dept_name
        from hrms.dept_information@web_to_hrms
        where valid = 'YES') c,(select * from mis.leave_emp_info where emp_id = ?) d
        where a.desig_id = b.desig_id  
        and   a.dept_id = c.dept_id
        and   a.emp_id = d.emp_id", [$request->emp_id, $request->emp_id]);

            return response()->json($resp_data);
        }

    }

    public function applicantData(Request $request)
    {

       

//      Validator::make($request->all(), [
//          'st_dt' => 'required|date',
//          'en_dt' => 'required|date',
//      ])->validate();


//        $empLeaveEnjoy = DB::select("
//        select    x.emp_id
//        ,max(decode(x.leave_type, 'ANNUAL', x.total_enjoyed_leave)) annual
//        ,max(decode(x.leave_type, 'CASUAL', x.total_enjoyed_leave)) casual
//        ,max(decode(x.leave_type, 'LWP', x.total_enjoyed_leave)) lwp
//        ,max(decode(x.leave_type, 'MATERNITY', x.total_enjoyed_leave)) maternity
//        ,max(decode(x.leave_type, 'MEDICAL', x.total_enjoyed_leave)) medical
//        ,max(decode(x.leave_type, 'ADVANCE', x.total_enjoyed_leave)) advance
//        ,max(decode(x.leave_type, 'SPECIAL MEDICAL', x.total_enjoyed_leave)) special_medical
//        from    (
//        select   r.emp_id
//        ,r.leave_type
//        ,r.total_enjoyed_leave
//        ,r.leave_year
//        from    hrms.v_employee_leave_status@web_to_hrms r
//        ) x
//        where x.emp_id = '$request->emp_id'
//        and x.leave_year = (select to_char(sysdate,'RRRR') from dual)
//        group by x.emp_id
//        ");

        // DB::setDateFormat('DD-MON-RRRR');
        // $curr_date = Carbon::now()->format('Y');

        // $empLeaveBalance = DB::select("
                
        //     SELECT    x.emp_id
        //         ,MAX(DECODE(x.leave_type, 'ANNUAL', nvl(x.total_available_leave,0))) ANNUAL
        //         ,MAX(DECODE(x.leave_type, 'CASUAL', nvl(x.total_available_leave,0))) CASUAL
        //         ,MAX(DECODE(x.leave_type, 'LWP', nvl(x.total_available_leave,0))) LWP
        //         ,MAX(DECODE(x.leave_type, 'MATERNITY', nvl(x.total_available_leave,0))) MATERNITY
        //         ,MAX(DECODE(x.leave_type, 'MEDICAL', nvl(x.total_available_leave,0))) MEDICAL
        //         ,MAX(DECODE(x.leave_type, 'ADVANCE', nvl(x.total_available_leave,0))) ADVANCE
        //         ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', nvl(x.total_available_leave,0))) SPECIAL_MEDICAL
        //     FROM    (
        //     SELECT   r.emp_id
        //     ,r.leave_type
        //     ,r.total_available_leave
        //     ,r.leave_year
        //     FROM    hrms.v_employee_leave_status@web_to_hrms r
        //     where r.emp_id = '$request->emp_id'
        
        //     ) x
        //     WHERE X.EMP_ID = '$request->emp_id'
        //     AND X.leave_year = '$curr_date'         
        //     GROUP BY x.emp_id
        // ");

        // $empLeaveBalance = DB::select("

        // SELECT x.emp_id
        // ,MAX(DECODE(x.leave_type, 'ANNUAL', nvl(x.total_available_leave,0))) ANNUAL
        // ,MAX(DECODE(x.leave_type, 'CASUAL', nvl(x.total_available_leave,0))) CASUAL
        // ,MAX(DECODE(x.leave_type, 'LWP', nvl(x.total_available_leave,0))) LWP
        // ,MAX(DECODE(x.leave_type, 'MATERNITY', nvl(x.total_available_leave,0))) MATERNITY
        // ,MAX(DECODE(x.leave_type, 'MEDICAL', nvl(x.total_available_leave,0))) MEDICAL
        // ,MAX(DECODE(x.leave_type, 'ADVANCE', nvl(x.total_available_leave,0))) ADVANCE
        // ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', nvl(x.total_available_leave,0))) SPECIAL_MEDICAL
        // FROM (
        // SELECT r.emp_id
        // ,r.leave_type
        // ,r.total_available_leave
        // ,r.leave_year
        // ,r.leave_year_date
        // FROM hrms.v_employee_leave_status@web_to_hrms r
        // where r.emp_id = '$request->emp_id'
        
        // ) x
        // WHERE X.EMP_ID = '$request->emp_id'
        // AND to_char(X.leave_year_date,'RRRR')= (select to_char(sysdate,'RRRR') from dual)
        // GROUP BY x.emp_id
              


        // ");


////        Log::info($empLeaveEnjoy);
        // Log::info($empLeaveBalance);
//
//
//
//        Log::info($request);
//
//
//        Log::info($empLeaveBalance[0]->medical);
//        Log::info($request->dol);
//        Log::info($request->tol);




        // if($request->tol == 'CASUAL'){
        //     if($request->dol > $empLeaveBalance[0]->casual ){
        //         return redirect()->back()->with('error', 'Leave Already Over.');
        //     }
        // }else if($request->tol == 'ANNUAL'){
        //     if($request->dol > $empLeaveBalance[0]->annual ){
        //         return redirect()->back()->with('error', 'Leave Already Over.');
        //     }
        // }else if($request->tol == 'LWP'){
        //     if($request->dol > $empLeaveBalance[0]->lwp ){
        //         return redirect()->back()->with('error', 'Leave Already Over.');
        //     }
        // }else if($request->tol == 'ADVANCE'){
        //     if($request->dol > $empLeaveBalance[0]->advance ){
        //         return redirect()->back()->with('error', 'Leave Already Over.');
        //     }
        // }else if($request->tol == 'SPECIAL MEDICAL'){
        //     if($request->dol > $empLeaveBalance[0]->special_medical ){
        //         return redirect()->back()->with('error', 'Leave Already Over.');
        //     }
        // }else if($request->tol == 'MEDICAL'){
        //     if($request->dol > $empLeaveBalance[0]->medical ){
        //         return redirect()->back()->with('error', 'Leave Already Over.');
        //     }
        // }



        if (empty($request->st_dt)) {
            return redirect()->back()->with('error', ' Leave Start Date can\'t be empty')->withInput(Input::all());
        } else if (empty($request->en_dt)) {
            return redirect()->back()->with('error', ' Leave End Date can\'t be empty')->withInput(Input::all());
        } else if ($request->hd == 'on') {

            try {
                $s = Carbon::parse($request->st_dt)->format('Y-m-d');
                $d = Carbon::parse($request->en_dt)->format('Y-m-d');

                // $s = date('d-M-y', strtotime("$request->st_dt"));
                // $d = date('d-M-y', strtotime("$request->en_dt"));

                $rs = DB::select("
                select count(*) cnt
                from mis.leave_emp_record
                where emp_id = '$request->emp_id'
                and '$s' between leave_from and leave_to
                and '$d' between leave_from and leave_to
               ");
                if ($rs[0]->cnt == 1) {
                    return redirect()->back()->with('error', 'You have already applied this date. Please check My application');
                }
            } catch (Oci8Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }


            $line_path = '';
            if ($request->tol == 'MEDICAL') {
                if (!empty($request->medicalFile)) {
                    $this->validate($request, [
                        'medicalFile' => 'required|file',
                    ]);

                    $file = $request->medicalFile; // get the validated file
                    $extension = $file->getClientOriginalExtension();
                    $filename = $request->emp_id . '_medical-photo-' . time() . '.' . $extension;

                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->resize(492, 484);
                    $image_resize->save(public_path('/medicalImage/' . $filename));

//                $path = $file->move(public_path() . '/medicalImage/', $filename);
                    $line_path = '/medicalImage/' . $filename;
//                $line_path = '/medicalImage/'.'_'. time().$filename;
                }
            }

            $matimg_path = '';
            if ($request->tol == 'MATERNITY') {
                if (!empty($request->mtrn_file)) {
                    $this->validate($request, [
                        'mtrn_file' => 'required|file',
                    ]);
                    $file = $request->mtrn_file; // get the validated file
                    $extension = $file->getClientOriginalExtension();
                    $filename = $request->emp_id . '_mat-photo-' . time() . '.' . $extension;
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->resize(492, 484);
                    $image_resize->save(public_path('/maternityImage/' . $filename));
//                    dd($image_resize);
                    $matimg_path = '/maternityImage/' . $filename;
                }
            }

            $imagesPath = '';
            if ($request->tol == 'SPECIAL MEDICAL') {
                if ($request->hasfile('filename')) {
                    foreach ($request->file('filename') as $image) {
                        $filename = $request->emp_id . '_' . time() . '_' . $image->getClientOriginalName();
                        $image_resize = Image::make($image->getRealPath());
                        $image_resize->resize(492, 484);
                        $image_resize->save(public_path('/medicalImage_sp/' . $filename));
                        $data[] = '/medicalImage_sp/' . $filename;
                    }
                    $imagesPath = implode('|', $data);
    //                dd(explode('|',$imagesPath));

                }
            }

            $cnt = DB::select("
                            select count(*) x
                            from mis.leave_emp_record
                            where emp_id = '$request->emp_id'
                            and app_status  = 'NO'
                          ");

            $line_id = DB::select('select mis.leave_emp_record_seq.NEXTVAL lid from dual');


            if ($cnt[0]->x >= 1) {
                return redirect()->back()->with('error', ' Already you  have a pending leave.Please Check My Application.');
            }
            else {
                $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $uid = Auth::user()->user_id;

                if ($request->period != 'NULL') {
                    $period = $request->period;

                }
                if ($request->period == 'FIRST' || $request->period == 'SECOND') {
                    $dol = 0.5;
                } else {
                    $dol = $request->dol;
                }


                try {
                    $dataArray = [
                        'LINE_ID' => $line_id[0]->lid,
                        'PLANT_ID' => $request->plant_id,
                        'EMP_ID' => $request->emp_id,
                        'EMP_NAME' => $request->sur_name,
                        'EMP_DEPT_ID' => $request->dept_id,
                        'EMP_DEPT_NAME' => $request->dept_name,
                        'EMP_DESIG_ID' => $request->desig_id,
                        'ADD_DURING_LEAVE' => $request->adl,
                        'EMP_DESIG_NAME' => $request->desig_name,
                        'EMP_CONTACT_NO' => $request->mob,
                        'EMP_EMAIL' => $request->email,
                        'LEAVE_FROM' => Carbon::parse($request->st_dt)->format('Y-m-d'),
                        'LEAVE_TO' => Carbon::parse($request->en_dt)->format('Y-m-d'),
                        'DAY_OF_LEAVE' => $dol,
                        'TYPE_OF_LEAVE' => $request->tol,
                        'PURPOSE_OF_LEAVE' => $request->pol,
                        'APPLICATION_DATE' => $sys_time,
                        'RSP_EMP_ID' => $request->rsp_emp_code,
                        'RSP_EMP_NAME' => $request->rsp_emp_name,
                        'RSP_DESIG_ID' => $request->rsp_desig_id,
                        'RSP_DESIG_NAME' => $request->rsp_desig_name,
                        'RSP_DEPT_ID' => $request->rsp_dept_id,
                        'RSP_DEPT_NAME' => $request->rsp_dept_name,
                        'RSP_CONTACT_NO' => $request->rsp_cnt_no,
                        'RSP_EMAIL' => $request->rsp_email,
                        'RSP_DUTIES' => $request->rsp_duties,
                        'RSP_ACCEPT' => 'YES',
                        'RSP_ACCEPT_DATE' => Carbon::now()->format('Y-m-d'),
                        'SUP_ACCEPT' => 'YES',
                        'SUP_ACCEPT_DATE' => Carbon::now()->format('Y-m-d'),
                        'RCM_APPROVED_DATE' => Carbon::now()->format('Y-m-d'),
                        'APP_STATUS' => 'YES',
                        'FORWARD_EMP' => $request->emp_id,
                        'RPT_SUPERVISOR_ID' => $request['rpt_visor_id'],
                        'HEAD_OF_DEPT_ID' => $request['rpt_head_id'],
                        'CREATE_USER' => $uid,
                        'MEDICALIMAGES' => $line_path,
                        'HALF_DAY' => $period,
                        'SP_MEDICALIMAGES' => $imagesPath,
                        'MATERNITYIMAGE' => $matimg_path,
                        'ST_TIME' => $request->st_time,
                        'EN_TIME' => $request->en_time
                    ];
                    $suc = LeaveEmpRecord::insert($dataArray);

                    if ($suc) {

                        $uid = Auth::user()->user_id;
                        $rs = DB::select("
                          select max(line_id) line_id from mis.leave_emp_record where emp_id = '$request->emp_id'
                          ");
                        $line_id = $rs[0]->line_id;


                        $user_name = Auth::user()->name;
                        $plHeademail = DB::select("select pl_email
                                    from leave_plant_head
                                    where plant_id = (
                                      select distinct plant_id
                                      from mis.leave_emp_record
                                      where emp_id = '$request->emp_id')");
                        $app_link = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/plan_headapproval/' . $request->emp_id . '/' . $line_id,
                            'name' => $user_name, 'app_mob' => $request->mob,
                            'local_url' => 'http://192.168.1.221:5031/misdashboard/elm_portal/plan_headapproval/' . $request->emp_id . '/' . $line_id
                        );

                        $applicant_emails = $request->email;
                        
                        Mail::send(['text' => 'elm_portal.mail.mail_to_HR'], $app_link, function ($message) use ($applicant_emails, $plHeademail, $user_name) {
                            $message->to($plHeademail[0]->pl_email, $plHeademail[0]->pl_email)
                                ->subject('Leave Application');
                            $message->from($applicant_emails, $user_name);
                        });

                        return redirect()->back()->with('success', ' Records Save Successfully.');

                    } else {
                        return redirect()->back()->with('error', ' Record Not Saved.');
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
//                    dd($ex->getMessage());
                    return redirect()->back()->with('error', 'Contact Your Administrator.');
                }


            }


        } else {

            try {
                $s = Carbon::parse($request->st_dt)->format('Y-m-d');
                $d = Carbon::parse($request->en_dt)->format('Y-m-d');

                // $s = date('d-M-y', strtotime("$request->st_dt"));
                // $d = date('d-M-y', strtotime("$request->en_dt"));

                $rs = DB::select("
                select count(*) cnt
                from mis.leave_emp_record
                where emp_id = '$request->emp_id'
                and '$s' between leave_from and leave_to
                and '$d' between leave_from and leave_to
               ");
                if ($rs[0]->cnt == 1) {
                    return redirect()->back()->with('error', 'You have already applied this date. Please check My application');
                }
            } catch (Oci8Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }


            $line_path = '';
            if ($request->tol == 'MEDICAL') {
                if (!empty($request->medicalFile)) {
                    $this->validate($request, [
                        'medicalFile' => 'required|file',
                    ]);

                    $file = $request->medicalFile; // get the validated file
                    $extension = $file->getClientOriginalExtension();
                    $filename = $request->emp_id . '_medical-photo-' . time() . '.' . $extension;

                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->resize(492, 484);
                    $image_resize->save(public_path('/medicalImage/' . $filename));

//                $path = $file->move(public_path() . '/medicalImage/', $filename);
                    $line_path = '/medicalImage/' . $filename;
//                $line_path = '/medicalImage/'.'_'. time().$filename;
                }
            }


            $matimg_path = '';
            if ($request->tol == 'MATERNITY') {
                if (!empty($request->mtrn_file)) {
                    $this->validate($request, [
                        'mtrn_file' => 'required|file',
                    ]);
                    $file = $request->mtrn_file; // get the validated file
                    $extension = $file->getClientOriginalExtension();
                    $filename = $request->emp_id . '_mat-photo-' . time() . '.' . $extension;
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->resize(492, 484);
                    $image_resize->save(public_path('/maternityImage/' . $filename));
//                    dd($image_resize);
                    $matimg_path = '/maternityImage/' . $filename;
                }
            }

            $imagesPath = '';

            if ($request->hasfile('filename')) {

                foreach ($request->file('filename') as $image) {

                    $filename = $request->emp_id . '_' . time() . '_' . $image->getClientOriginalName();
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize(492, 484);
                    $image_resize->save(public_path('/medicalImage_sp/' . $filename));
                    $data[] = '/medicalImage_sp/' . $filename;


//                    $sp_medical=$request->emp_id.'_'. time().'_'.$image->getClientOriginalName();
//                    $sp_medical->resize(300, 300);
//                    $image->move(public_path().'/medicalImage_sp/', $sp_medical);
//                    $data[] = '/medicalImage_sp/'.$sp_medical;
                }
                $imagesPath = implode('|', $data);
//                dd(explode('|',$imagesPath));

            }


            $cnt = DB::select("
                            select count(*) x
                            from mis.leave_emp_record
                            where emp_id = '$request->emp_id'
                            and app_status  = 'NO'
                          ");

            $line_id = DB::select('select mis.leave_emp_record_seq.NEXTVAL lid from dual');


            if ($cnt[0]->x >= 1) {
                return redirect()->back()->with('error', ' Already you  have a pending leave.Please Check My Application.');
            } else {
                $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $uid = Auth::user()->user_id;

                if ($request->period != 'NULL') {
                    $period = $request->period;

                }

                if ($request->period == 'FIRST' || $request->period == 'SECOND') {
                    $dol = 0.5;
                } else {
                    $dol = $request->dol;
                }


                // Log::info("Passed 2");

                

                try {
                    $dataArray = [
                        'LINE_ID' => $line_id[0]->lid,
                        'PLANT_ID' => $request->plant_id,
                        'EMP_ID' => $request->emp_id,
                        'EMP_NAME' => $request->sur_name,
                        'EMP_DEPT_ID' => $request->dept_id,
                        'EMP_DEPT_NAME' => $request->dept_name,
                        'EMP_DESIG_ID' => $request->desig_id,
                        'ADD_DURING_LEAVE' => $request->adl,
                        'EMP_DESIG_NAME' => $request->desig_name,
                        'EMP_CONTACT_NO' => $request->mob,
                        'EMP_EMAIL' => $request->email,
                        'LEAVE_FROM' => Carbon::parse($request->st_dt)->format('Y-m-d'),
                        'LEAVE_TO' => Carbon::parse($request->en_dt)->format('Y-m-d'),
                        'DAY_OF_LEAVE' => $dol,
                        'TYPE_OF_LEAVE' => $request->tol,
                        'PURPOSE_OF_LEAVE' => $request->pol,
                        'APPLICATION_DATE' => $sys_time,
                        'RSP_EMP_ID' => $request->rsp_emp_code,
                        'RSP_EMP_NAME' => $request->rsp_emp_name,
                        'RSP_DESIG_ID' => $request->rsp_desig_id,
                        'RSP_DESIG_NAME' => $request->rsp_desig_name,
                        'RSP_DEPT_ID' => $request->rsp_dept_id,
                        'RSP_DEPT_NAME' => $request->rsp_dept_name,
                        'RSP_CONTACT_NO' => $request->rsp_cnt_no,
                        'RSP_EMAIL' => $request->rsp_email,
                        'RSP_DUTIES' => $request->rsp_duties,
                        'RPT_SUPERVISOR_ID' => $request['rpt_visor_id'],
                        'HEAD_OF_DEPT_ID' => $request['rpt_head_id'],
                        'CREATE_USER' => $uid,
                        'MEDICALIMAGES' => $line_path,
                        'HALF_DAY' => $period,
                        'SP_MEDICALIMAGES' => $imagesPath,
                        'MATERNITYIMAGE' => $matimg_path,
                        'ST_TIME' => $request->st_time,
                        'EN_TIME' => $request->en_time
                    ];
                    $suc = LeaveEmpRecord::insert($dataArray);

                    if ($suc) {
                        $uid = Auth::user()->user_id;
                        $mstatus = DB::select("
                        SELECT mgt_status
                        FROM mis.leave_emp_info
                        WHERE emp_id = '$uid'
                    ");
                        if ($mstatus[0]->mgt_status == 'NM') {

                            $line_id = $line_id[0]->lid;
                            $auth_name = Auth::user()->name;
                            $to_mail = $request->email;
                            $to_mail_name = $request->sur_name;

                            $supvisor_mail = DB::select("select mail_address
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(report_supervisor)
                                    from leave_emp_info
                                    where emp_id = '$request->emp_id')
                                ");


                            // $head_mail = DB::select("select mail_address
                            //         from leave_emp_info
                            //         where emp_id = (
                            //         select trim(head_of_dept)
                            //         from leave_emp_info
                            //         where emp_id = '$request->emp_id')
                            //     ");


                            $sp = $supvisor_mail[0]->mail_address;
                            // $hm = $head_mail[0]->mail_address;

//                      return response()->json($supvisor_mail[0]->mail_address);
//
//
                            //mail for super visor
                            $app_data = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
                                'local_url' => 'http://192.168.1.221:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
                                'application_user' => $auth_name, 'mob_no' => $request->mob
                            );

                            $emails = [];
                            array_push($emails, $sp);

                            Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use ($emails, $to_mail, $to_mail_name) {
                                $message->to($emails, $emails)
                                    ->subject('Leave Application');
                                $message->from($to_mail, $to_mail_name);
                            });

                            //mail for department head
                            // $app_data = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/headapproval/' . $request->emp_id . '/' . $line_id,
                            //     'local_url' => 'http://192.168.1.221:5031/misdashboard/elm_portal/headapproval/' . $request->emp_id . '/' . $line_id,
                            //     'application_user' => $auth_name, 'mob_no' => $request->mob
                            // );
                            // $head_emails = [];
                            // array_push($head_emails, $hm);
                            // Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use ($head_emails, $to_mail, $to_mail_name) {
                            //     $message->to($head_emails, $head_emails)
                            //         ->subject('Leave Application');
                            //     $message->from($to_mail, $to_mail_name);
                            // });


                            return redirect()->back()->with('success', ' Records Save Successfully.');

                        } else {


                            if($request->emp_id == '5000043' || $request->emp_id == 'FE001'){
                                $auth_name = Auth::user()->name;
                                $frm_mail = $request->email;
                                $frm_mail_name = $request->sur_name;
                                $line_id = $line_id[0]->lid;
                                $supvisor_mail = DB::select("select mail_address
                                    from leave_emp_info
                                    where emp_id = (
                                    select trim(report_supervisor)
                                    from leave_emp_info
                                    where emp_id = '$request->emp_id')
                                ");


                                $sp = $supvisor_mail[0]->mail_address;


                                //mail for super visor
                                $app_data = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
                                    'local_url' => 'http://192.168.1.221:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
                                    'application_user' => $auth_name, 'mob_no' => $request->mob
                                );

                                $emails = [];
                                array_push($emails, $sp);

                                Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use ($emails, $frm_mail, $frm_mail_name) {
                                    $message->to($emails, $emails)
                                        ->subject('Leave Application');
                                    $message->from($frm_mail, $frm_mail_name);
                                });

                            }else{

                               /* $auth_name = Auth::user()->name;
                                $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$request->rsp_emp_code]);
                                $app_link = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/req_application',
                                    'app_emp' => $auth_name, 'app_mob' => $request->mob,
                                    'local_url' => 'http://192.168.1.221:5031/misdashboard/elm_portal/req_application'
                                );
                                $applicant_emails = $request->email;
                                Mail::send(['text' => 'elm_portal.mail.applicant_mail'], $app_link, function ($message) use ($applicant_emails, $frm_mail, $auth_name) {
                                    $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
                                        ->subject('Leave Application');
                                    $message->from($applicant_emails, $auth_name);
                                });*/



                                //Responsible Person Email
                                $auth_name = Auth::user()->name;
                                if(!empty($request->rsp_emp_code)){
                                    $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$request->rsp_emp_code]);
                                    $app_link = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/req_application',
                                        'app_emp' => $auth_name, 'app_mob' => $request->mob,
                                        'local_url' => 'http://192.168.1.221:5031/misdashboard/elm_portal/req_application'
                                    );
                                    $applicant_emails = $request->email;
                                    Mail::send(['text' => 'elm_portal.mail.applicant_mail'], $app_link, function ($message) use ($applicant_emails, $frm_mail, $auth_name) {
                                        $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
                                            ->subject('Leave Application');
                                        $message->from($applicant_emails, $auth_name);
                                    });
                                }else{
                                    //Management Employee but responsible person empty. then email to supervisor
                                    //Supervisor Email
                                    $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$request->rpt_visor_id]);
                                    $applicant_emails = $request->email;
                                    $line_id = DB::select("select max(line_id) lid from mis.leave_emp_record where emp_id = ?",[$request->emp_id]);

                                    $app_data = array('url_link' => 'http://202.84.43.214:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$line_id[0]->lid,
                                        'local_url' => 'http://192.168.1.221:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$line_id[0]->lid,
                                        'accpt_emp' =>$auth_name, 'mob_no' => $request->mob ,'application_user' => $frm_mail[0]->mail_address );


                                    Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use($applicant_emails,$frm_mail,$auth_name) {
                                        $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
                                            ->subject('Leave Application');
                                        $message->from($applicant_emails, $auth_name);
                                    });


                                }
                            }

                            return redirect()->back()->with('success', ' Records Save Successfully.');

                        }
                    } else {
                        return redirect()->back()->with('error', ' Contact Your Administrator.');
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
//                    dd($ex->getCode());
                    return redirect()->back()->with('error', 'Contact Your Administrator.');
                }


            }
        }


    }

    public function holiday(Request $request)
    {
        DB::setDateFormat("DD-MON-RR");


        // $holiday_dates = DB::select("
        //     select count(*) holiday_cnt
        //     from v_holiday
        //     where to_date(holiday_date,'DD-MON-RR') between
        //     to_date('$request->st_dt','DD-MON-RR')
        //     and to_date('$request->en_dt','DD-MON-RR')
        // ");

        $holiday_dates = DB::select("
            select count(*) holiday_cnt
            from (
                    select distinct d.holiday_date                          --, m.holiday_name
                    from hrms.holiday_information@web_to_hrms    m,
                    hrms.holiday_information_d@web_to_hrms  d
                    where     m.holiday_id = d.holiday_id
                    and to_char (holiday_date, 'yyyy') =
                    (select to_char (sysdate, 'yyyy') from dual)
                    and d.valid = 'YES'
                    and m.plant_id = '$request->plant_id'    
                    union
                    select holiday_date
                    from mis.v_holiday   
                 
            )
            where to_date(holiday_date,'DD-MON-RR') between
            to_date('$request->st_dt','DD-MON-RR')
            and to_date('$request->en_dt','DD-MON-RR')
        ");




        return response()->json($holiday_dates);
    }

}