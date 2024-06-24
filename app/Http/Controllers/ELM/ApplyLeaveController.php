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
use stdClass;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;


//use Illuminate\Support\Facades\Validator;


class ApplyLeaveController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->user_id;

        DB::setDateFormat('DD-MON-RR');

        $chkEmp = DB::select("
            select count(emp_id) cnt from mis.leave_emp_balance_over
            where emp_id = '$uid'
        ");
        if ($chkEmp[0]->cnt > 0) {
            // print_r($chkEmp);
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

        $resp_persons = DB::SELECT("SELECT * FROM MIS.LEAVE_DELEGATE WHERE EMP_ID='$uid'");
        if (count($resp_persons) > 0) {
            $employees = [];
            $rsp_person = $resp_persons[0]->rsp_person;
            $rsp_person_arr = explode(",", $rsp_person);
            foreach ($rsp_person_arr as $person){
                $temp = new stdClass();
                $temp->emp_id = $person;
                $getData = DB::SELECT("select emp_id,sur_name from hrms.emp_information@WEB_TO_HRMS
                  where valid='YES' and emp_id = '$person'");
                if(count($getData) > 0){
                    $temp->sur_name = $getData[0]->sur_name;
                }else{
                    $temp->sur_name = "";
                }
                array_push($employees,$temp);
            }
        } else {
            if (
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
            ) {
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


            } else {


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
        }

        $employees = (array)$employees;



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
      ,MAX(DECODE(x.leave_type, 'HAJJ', x.total_allowed_leave)) HAJJ
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
      ,MAX(DECODE(x.leave_type, 'HAJJ', x.TOTAL_ENJOYED_LEAVE)) HAJJ
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
      ,MAX(DECODE(x.leave_type, 'HAJJ', x.total_available_leave)) HAJJ
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
    public function checkFacLeaveData(Request $request){
        DB::setDateFormat("DD-MON-RR");

        $st_dt = $request->st_dt;
        $modStartDate = Carbon::parse($request->st_dt)->format('Y-M-d');

        $uid = Auth::user()->user_id;

        $lastLeaveData = DB::select("
            select line_id,emp_id,to_char(application_date,'DD-MON-RR') application_date,type_of_leave,to_char(leave_from,'DD-MON-RR') leave_from ,
            to_char(leave_to,'DD-MON-RR') leave_to ,day_of_leave,rejected_id,rsp_accept,head_rejected_id,sup_rejected_id,
                hr_rejected_id,status, rcm_approved_date,sup_accept,status
            from mis.leave_emp_record where emp_id = '$uid' and app_status  = 'YES' AND leave_to <= to_date('$modStartDate', 'RRRR-MON-DD')
            order by line_id desc");

        if(count($lastLeaveData) > 0){

            $lastleave = $lastLeaveData[0]->leave_to;
            $dates = $this->getBetweenDates($lastleave,$st_dt);

            $lastleave = date("Y-M-d", strtotime($lastleave));
            $st_dt = date("Y-M-d",strtotime($st_dt));

//            $holiday_dates = DB::select("
//                select count(*) holiday_cnt
//                from (
//                        select distinct d.holiday_date
//                        from hrms.holiday_information@web_to_hrms m,
//                        hrms.holiday_information_d@web_to_hrms d
//                        where m.holiday_id = d.holiday_id
//                        and to_char (holiday_date, 'yyyy') =
//                        (select to_char (sysdate, 'yyyy') from dual)
//                        and d.valid = 'YES'
//                        and m.plant_id = '$request->plant_id'
//                        union
//                        select holiday_date
//                        from mis.v_holiday
//                )
//                where to_date(holiday_date,'DD-MON-RR') between
//                to_date('$lastleave','RRRR-MON-DD')
//                and to_date('$st_dt','RRRR-MON-DD')
//            ");


            $holiday_dates = DB::select("select count(*) holiday_cnt
from (

select distinct d.holiday_date                        
from hrms.holiday_information@web_to_hrms m,
hrms.holiday_information_d@web_to_hrms d
where m.holiday_id = d.holiday_id
and to_char (holiday_date, 'yyyy') =
(select to_char (sysdate, 'yyyy') from dual)
and d.valid = 'YES'
and m.plant_id = '$request->plant_id'
and to_date(holiday_date,'DD-MON-RR') between
            to_date('$lastleave','RRRR-MON-DD')
            and to_date('$st_dt','RRRR-MON-DD') 

union 

select holiday_date
from
(
select distinct to_date(a.date_r,'MM/DD/RR') holiday_date, b.day_name
from
(
    select to_char(date_r,'MM/DD/RR') date_r,trim(upper(to_char( date_r, 'Day'))) day_name
    from(
    select to_date('$lastleave', 'RRRR-MON-DD') + rownum - 1 date_r
    from all_objects
    where rownum <= to_date('$st_dt', 'RRRR-MON-DD') 
        - to_date('$lastleave', 'RRRR-MON-DD') + 1
    )
) a, (

   
    select distinct d.day_name, d.holiday                   
    from hrms.weekly_holiday_m@web_to_hrms m,
    hrms.weekly_holiday_d@web_to_hrms d
    where m.weekly_holiday_id = d.weekly_holiday_id
    and m.plant_id = '$request->plant_id'
    and m.holiday_type = 'Y'  
    and d.holiday = 'YES'
         
    
)b
where a.day_name = b.day_name
)

)where to_date(holiday_date,'DD-MON-RR') between
            to_date('$lastleave','RRRR-MON-DD')
            and to_date('$st_dt','RRRR-MON-DD')");

            if(count($dates) == $holiday_dates[0]->holiday_cnt){
                $frst_holiday = date('d-M-Y', strtotime('+1 day', strtotime($lastleave)));
                return response()->json(['count'=>count($dates),'status'=>1,'holiday_cnt'=>$holiday_dates[0]->holiday_cnt,
                    'frst_holiday'=>$frst_holiday,'lastleave'=>$lastleave,'$st_dt'=>$st_dt,'$dates'=>$dates]);
            }else{
                return response()->json(['status'=>0,'lastleave'=>$lastleave,'$st_dt'=>$st_dt,'$dates'=>$dates,'holiday_cnt'=>$holiday_dates[0]->holiday_cnt]);
            }
        }else{
            return response()->json(['status'=>0]);
        }
    }
    public function getBetweenDates($startDate, $endDate)
    {
        $rangArray = [];

        $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
        $endDate = date('Y-m-d', strtotime('-1 day', strtotime($endDate)));

        $NstartDate = strtotime($startDate);
        $NendDate = strtotime($endDate);

        for ($currentDate = $NstartDate; $currentDate <= $NendDate;
             $currentDate += (86400)) {

            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }

        return $rangArray;
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



        if (empty($request->st_dt)) {
            return redirect()->back()->with('error', ' Leave Start Date can\'t be empty')->withInput(Input::all());
        } else if (empty($request->en_dt)) {
            return redirect()->back()->with('error', ' Leave End Date can\'t be empty')->withInput(Input::all());
        } else if ($request->hd == 'on') {
            try {
                if($request->plant_id == '1100' || $request->plant_id == '2100'){
                    if($request->tol != 'MEDICAL' && $request->cus_st_dt != ""){
                        $s = Carbon::parse($request->cus_st_dt)->format('Y-m-d');
                    }else{
                        $s = Carbon::parse($request->st_dt)->format('Y-m-d');
                    }
                }else{
                    $s = Carbon::parse($request->st_dt)->format('Y-m-d');
                }

                $d = Carbon::parse($request->en_dt)->format('Y-m-d');
                $rs = DB::select("
                    select count(*) cnt
                    from mis.leave_emp_record
                    where emp_id = '$request->emp_id'
                    and '$s' between leave_from and leave_to
                    and '$d' between leave_from and leave_to ");
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

                    $line_path = '/medicalImage/' . $filename;
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

                if($request->plant_id == '1100' || $request->plant_id == '2100'){
                    if($request->tol != 'MEDICAL' && $request->cus_st_dt != ""){
                        $start_date = Carbon::parse($request->cus_st_dt)->format('Y-m-d');
                    }else{
                        $start_date = Carbon::parse($request->st_dt)->format('Y-m-d');
                    }
                }else{
                    $start_date = Carbon::parse($request->st_dt)->format('Y-m-d');
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
                        'LEAVE_FROM' => $start_date,
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
                                      from mis.leave_emp_info
                                      where emp_id = '$request->emp_id')");
                        $app_link = array(
                            'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/plan_headapproval/' . $request->emp_id . '/' . $line_id,
                            'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/plan_headapproval/' . $request->emp_id . '/' . $line_id,
                            'name' => $user_name, 'app_mob' => $request->mob,
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
                if($request->plant_id == '1100' || $request->plant_id == '2100'){
                    if($request->tol != 'MEDICAL' && $request->cus_st_dt != ""){
                        $s = Carbon::parse($request->cus_st_dt)->format('Y-m-d');
                    }else{
                        $s = Carbon::parse($request->st_dt)->format('Y-m-d');
                    }
                }else{
                    $s = Carbon::parse($request->st_dt)->format('Y-m-d');
                }

                $d = Carbon::parse($request->en_dt)->format('Y-m-d');
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
                    $line_path = '/medicalImage/' . $filename;
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
                }
                $imagesPath = implode('|', $data);

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
                if($request->plant_id == '1100' || $request->plant_id == '2100'){
                    if($request->tol != 'MEDICAL' && $request->cus_st_dt != ""){
                        $start_date = Carbon::parse($request->cus_st_dt)->format('Y-m-d');
                    }else{
                        $start_date = Carbon::parse($request->st_dt)->format('Y-m-d');
                    }
                }else{
                    $start_date = Carbon::parse($request->st_dt)->format('Y-m-d');
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
                        'LEAVE_FROM' => $start_date,
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

                            $sp = $supvisor_mail[0]->mail_address;

                            $app_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
                                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
                                'application_user' => $auth_name, 'mob_no' => $request->mob
                            );

                            $emails = [];
                            array_push($emails, $sp);

                            Mail::send(['text' => 'elm_portal.mail.sup_mail'], $app_data, function ($message) use ($emails, $to_mail, $to_mail_name) {
                                $message->to($emails, $emails)
                                    ->subject('Leave Application');
                                $message->from($to_mail, $to_mail_name);
                            });
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

                                $app_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
                                    'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/' . $request->emp_id . '/' . $line_id,
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
                                $auth_name = Auth::user()->name;
                                if(!empty($request->rsp_emp_code)){



                                    $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$request->rsp_emp_code]);
                                    $app_link = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/req_application',
                                        'app_emp' => $auth_name, 'app_mob' => $request->mob,
                                        'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/req_application'
                                    );
                                    $applicant_emails = $request->email;
                                    Mail::send(['text' => 'elm_portal.mail.applicant_mail'], $app_link, function ($message) use ($applicant_emails, $frm_mail, $auth_name) {
                                        $message->to($frm_mail[0]->mail_address, $frm_mail[0]->mail_address)
                                            ->subject('Leave Application');
                                        $message->from($applicant_emails, $auth_name);
                                    });
                                }else{
                                    $frm_mail = DB::select("select mail_address from mis.leave_emp_info where emp_id = ?", [$request->rpt_visor_id]);
                                    $applicant_emails = $request->email;
                                    $line_id = DB::select("select max(line_id) lid from mis.leave_emp_record where emp_id = ?",[$request->emp_id]);

                                    $app_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$line_id[0]->lid,
                                        'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/elm_portal/papproval/'.$request->emp_id.'/'.$line_id[0]->lid,
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
                    return redirect()->back()->with('error', 'Contact Your Administrator.');
                }
            }
        }
    }

    // public function holiday(Request $request)
    // {
    //     DB::setDateFormat("DD-MON-RR");
    //     $holiday_dates = DB::select("
    //         select count(*) holiday_cnt
    //         from (
    //                 select distinct d.holiday_date                          --, m.holiday_name
    //                 from hrms.holiday_information@web_to_hrms m,
    //                 hrms.holiday_information_d@web_to_hrms d
    //                 where m.holiday_id = d.holiday_id
    //                 and to_char (holiday_date, 'yyyy') =
    //                 (select to_char (sysdate, 'yyyy') from dual)
    //                 and d.valid = 'YES'
    //                 and m.plant_id = '$request->plant_id'
    //                 union
    //                 select holiday_date
    //                 from mis.v_holiday
    //         )
    //         where to_date(holiday_date,'DD-MON-RR') between
    //         to_date('$request->st_dt','DD-MON-RR')
    //         and to_date('$request->en_dt','DD-MON-RR')
    //     ");
    //     return response()->json($holiday_dates);
    // }

    public function holiday(Request $request)
    {
        DB::setDateFormat("DD-MON-RR");
        /*$holiday_dates = DB::select("
            select count(*) holiday_cnt
            from (
                    select distinct d.holiday_date                          --, m.holiday_name
                    from hrms.holiday_information@web_to_hrms m,
                    hrms.holiday_information_d@web_to_hrms d
                    where m.holiday_id = d.holiday_id
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
        ");*/

        $holiday_dates = DB::select("select count(*) holiday_cnt
from (

select distinct d.holiday_date                        
from hrms.holiday_information@web_to_hrms m,
hrms.holiday_information_d@web_to_hrms d
where m.holiday_id = d.holiday_id
and to_char (holiday_date, 'yyyy') =
(select to_char (sysdate, 'yyyy') from dual)
and d.valid = 'YES'
and m.plant_id = '$request->plant_id'
and to_date(holiday_date,'DD-MON-RR') between
            to_date('$request->st_dt','DD-MON-RR')
            and to_date('$request->en_dt','DD-MON-RR') 

union 

select holiday_date
from
(
select distinct to_date(a.date_r,'MM/DD/RR') holiday_date, b.day_name
from
(
    select to_char(date_r,'MM/DD/RR') date_r,trim(upper(to_char( date_r, 'Day'))) day_name
    from(
    select to_date('$request->st_dt', 'DD/MM/RR') + rownum - 1 date_r
    from all_objects
    where rownum <= to_date('$request->en_dt', 'DD/MM/RR') 
        - to_date('$request->st_dt', 'DD/MM/RR') + 1
    )
) a, (

   
    select distinct d.day_name, d.holiday                   
    from hrms.weekly_holiday_m@web_to_hrms m,
    hrms.weekly_holiday_d@web_to_hrms d
    where m.weekly_holiday_id = d.weekly_holiday_id
    and m.plant_id = '$request->plant_id'
    and m.holiday_type = 'Y'  
    and d.holiday = 'YES'
         
    
)b
where a.day_name = b.day_name
)

)where to_date(holiday_date,'DD-MON-RR') between
            to_date('$request->st_dt','DD-MON-RR')
            and to_date('$request->en_dt','DD-MON-RR')");


        return response()->json($holiday_dates);
    }

}