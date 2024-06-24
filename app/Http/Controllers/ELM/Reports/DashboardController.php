<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 24/2/2019
 * Time: 9:36 AM
 * Update: 22/07/2019
 * Update Time: 12:20 PM
 */

namespace App\Http\Controllers\ELM\Reports;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $plantID = Auth::user()->plant_id;

        $holiday_info = DB::SELECT("SELECT a.HOLIDAY_NAME, to_char(b.HOLIDAY_DATE,'RRRR-MM-DD') create_date 
        FROM HRMS.HOLIDAY_INFORMATION@web_to_hrms a INNER JOIN HRMS.HOLIDAY_INFORMATION_D@web_to_hrms b ON a.HOLIDAY_ID = b.HOLIDAY_ID
        WHERE b.VALID = 'YES' AND b.PLANT_ID = '$plantID' ORDER BY create_date ASC");

        $uid = Auth::user()->user_id;

        $plant_info = DB::SELECT("SELECT DISTINCT PLANT_ID FROM hrms.plant_info@web_to_hrms ORDER BY PLANT_ID");

        if ($uid == '1001628') {
            $depts = DB::select("select  plant_id,count(dept_id) total_dept
                    from hrms.dept_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = 1100
                    group by plant_id");

            $tolemps = DB::select("select plant_id,count(emp_id) total_emp
                    from hrms.emp_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = 1100
                    group by plant_id");

            $pemps = DB::select("
                    select count(emp_id) present_emp
                    from   hrms.v_emp_status@web_to_hrms
                    where  plant_id = 1100
                    and  main_status = 'PRESENT'
                    and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)
            ");

            $emp_osd = DB::select("
                select count(emp_id) osd
                from   hrms.v_emp_status@web_to_hrms
                where  plant_id = 1100
                and  main_status = 'OFFICIAL WORK'
                and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)

             ");

            $l_emp = DB::select("

            select count(emp_id) leave_emp
            from   hrms.v_emp_status@web_to_hrms
            where  plant_id = 1100
            and  main_status = 'LEAVE'
            and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)

            ");

            $absent = $tolemps[0]->total_emp - ($pemps[0]->present_emp + $emp_osd[0]->osd + $l_emp[0]->leave_emp);
            $levEmp = $l_emp[0]->leave_emp;

            $barcharData = DB::select("

                    select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                        (select a.dept_id,b.dept_name,a.present_emp
                            from
                                (
                                    select dept_id,count(emp_id) present_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'PRESENT'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id
        
        
                                )a, (select * from hrms.dept_information@web_to_hrms) b
                            where a.dept_id = b.dept_id
                          ) x,
                            (
                                select a.dept_id,a.absent_emp
                                from
                                    (select dept_id,count(emp_id) absent_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'ABSENT'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) y,
        
                            (
                                select a.dept_id,a.emp_osd
                                from
                                    (select dept_id,count(emp_id) emp_osd
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'OSD'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) z,
                            (
                                select a.dept_id,a.emp_lev
                                from
                                    (select dept_id,count(emp_id) emp_lev
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'LEAVE'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) l
        
        
                    where x.dept_id = y.dept_id (+)
                    and   x.dept_id = z.dept_id(+)
                    and   x.dept_id = l.dept_id(+)
                    order by x.dept_id


                  ");

            $curr_dt = Carbon::now()->format('d-M-Y');


            if (empty($barcharData)) {
                return view('elm_portal.reports.processNotComplete');
            } else {
                return view('elm_portal.reports.Dashboard', ['dept' => $depts, 'tolemps' => $tolemps, 'pemps' => $pemps,
                    'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData,
                    'curr_dt' => $curr_dt,'plant_info'=>$plant_info,'holidays'=>$holiday_info]);
            }


        }
        else if($uid == 'C100001'){
            return view('elm_portal.reports.Dashboard_Maintainance');
        }
        else {

            $curr_dt = Carbon::now()->format('d-M-Y');

            $depts = DB::select("select  plant_id,count(dept_id) total_dept
                    from hrms.dept_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = (select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' )
                    group by plant_id");
            $tolemps = DB::select("select plant_id,count(emp_id) total_emp
                    from hrms.emp_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = (select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' )
                    group by plant_id");


            $pemps = DB::select("
                    select count(emp_id) present_emp
                    from   hrms.v_emp_status@web_to_hrms
                    where  plant_id = (
                                        select plant_id
                                        from hrms.emp_information@web_to_hrms
                                        where emp_id = '$uid'
                                        and valid = 'YES'
                                     )
                    and  main_status = 'PRESENT'
                    and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)
            ");

            $totalWidth = $tolemps[0]->total_emp;

            $percentage = $pemps[0]->present_emp;
            $totalPresentP = ($percentage / $totalWidth) * 100;

            $emp_osd = DB::select("
                select count(emp_id) osd
                from   hrms.v_emp_status@web_to_hrms
                where  plant_id = (
                                    select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                 )
                and  main_status = 'OFFICIAL WORK'
                and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)

            ");

            $percentage = $emp_osd[0]->osd;
            $totalOsdP = ($percentage / $totalWidth) * 100;

            $l_emp = DB::select("

            select count(emp_id) leave_emp
            from   hrms.v_emp_status@web_to_hrms
            where  plant_id = (
                        select plant_id
                        from hrms.emp_information@web_to_hrms
                        where emp_id = '$uid'
                        and valid = 'YES'
                     )
            and  main_status = 'LEAVE'
            and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)

             ");

            $absent = $tolemps[0]->total_emp - ($pemps[0]->present_emp + $emp_osd[0]->osd + $l_emp[0]->leave_emp);
            $levEmp = $l_emp[0]->leave_emp;

            $percentage = $absent;
            $totalAbsentP = ($percentage / $totalWidth) * 100;

            $percentage = $levEmp;
            $totalLeaveP = ($percentage / $totalWidth) * 100;

            $totalP = 100 - ($totalPresentP+$totalOsdP+$totalAbsentP+$totalLeaveP);

            $barcharData = DB::select("
            select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
            from
                (select a.dept_id,b.dept_name,a.present_emp
                    from
                        (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final_current@web_to_hrms
                            where default_status = 'PRESENT'
                            and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)
                            and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                                )
                            and valid = 'YES'
                            )
                            group by dept_id


                        )a, (select * from hrms.dept_information@web_to_hrms) b
                    where a.dept_id = b.dept_id
                  ) x,
                    (
                        select a.dept_id,a.absent_emp
                        from
                            (select dept_id,count(emp_id) absent_emp
                            from hrms.emp_work_status_final_current@web_to_hrms
                            where default_status = 'ABSENT'
                            and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                            and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) y,

                    (
                        select a.dept_id,a.emp_osd
                        from
                            (select dept_id,count(emp_id) emp_osd
                            from hrms.emp_work_status_final_current@web_to_hrms
                            where default_status = 'OSD'
                            and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                            and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) z,
                    
                    (
                        select a.dept_id,a.emp_lev
                        from
                            (select dept_id,count(emp_id) emp_lev
                            from hrms.emp_work_status_final_current@web_to_hrms
                            where default_status = 'LEAVE'
                            and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                            and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) l


            where x.dept_id = y.dept_id (+)
            and   x.dept_id = z.dept_id(+)
            and   x.dept_id = l.dept_id(+)
            order by x.dept_id
            ");

            $plant = DB::select("select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' ");
            $plnat_id = $plant[0]->plant_id;

            if (empty($barcharData)) {
                // for factory current process purpose start
                if ($plnat_id != '1000') {

                    $barcharData = DB::select("

                    select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                        (select a.dept_id,b.dept_name,a.present_emp
                            from
                                (
                                    select dept_id,count(emp_id) present_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'PRESENT'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                        )
                                    and valid = 'YES'
                                    )
                                    group by dept_id
        
        
                                )a, (select * from hrms.dept_information@web_to_hrms) b
                            where a.dept_id = b.dept_id
                          ) x,
                            (
                                select a.dept_id,a.absent_emp
                                from
                                    (select dept_id,count(emp_id) absent_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'ABSENT'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                    )
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) y,
        
                            (
                                select a.dept_id,a.emp_osd
                                from
                                    (select dept_id,count(emp_id) emp_osd
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'OSD'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                    )
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) z,
                            (
                                select a.dept_id,a.emp_lev
                                from
                                    (select dept_id,count(emp_id) emp_lev
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'LEAVE'
                                    and to_char(working_date,'DD-MON-RR') = (select to_char(sysdate,'DD-MON-RR') curr_date from dual)
                                    and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                    )
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) l
        
        
                    where x.dept_id = y.dept_id (+)
                    and   x.dept_id = z.dept_id(+)
                    and   x.dept_id = l.dept_id(+)
                    order by x.dept_id


                  ");
                    if (empty($barcharData)) {
                        return view('elm_portal.reports.processNotComplete');
                    } else {
                        return view('elm_portal.reports.Dashboard', ['dept' => $depts, 'tolemps' => $tolemps, 'pemps' => $pemps,
                            'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData,
                            'curr_dt' => $curr_dt,'totalWidth'=>$totalWidth, 'totalPresentP'=>$totalPresentP, 'totalOsdP'=>$totalOsdP,'totalAbsentP'=>$totalAbsentP,
                            'totalLeaveP'=>$totalLeaveP,'plant_info'=>$plant_info,'holidays'=>$holiday_info]);
                    }
                } else {
                    return view('elm_portal.reports.processNotComplete');
                }
                // for factory current process purpose end
            } else {
                return view('elm_portal.reports.Dashboard', ['dept' => $depts, 'tolemps' => $tolemps, 'pemps' => $pemps,
                    'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData,
                    'curr_dt' => $curr_dt,'totalWidth'=>$totalWidth, 'totalPresentP'=>$totalPresentP, 'totalOsdP'=>$totalOsdP,'totalAbsentP'=>$totalAbsentP,
                    'totalLeaveP'=>$totalLeaveP,'plant_info'=>$plant_info,'holidays'=>$holiday_info]);
            }
        }
    }

    public function indexChangeDate(Request $request)
    {
        $plantID = Auth::user()->plant_id;
        $holiday_info = DB::SELECT("SELECT a.HOLIDAY_NAME, to_char(b.HOLIDAY_DATE,'RRRR-MM-DD') create_date 
        FROM HRMS.HOLIDAY_INFORMATION@web_to_hrms a INNER JOIN HRMS.HOLIDAY_INFORMATION_D@web_to_hrms b ON a.HOLIDAY_ID = b.HOLIDAY_ID
        WHERE b.VALID = 'YES' AND b.PLANT_ID = '$plantID' ORDER BY create_date ASC");

        $plant_info = DB::SELECT("SELECT DISTINCT PLANT_ID FROM hrms.plant_info@web_to_hrms ORDER BY PLANT_ID");
        $cng_date = $request->st_dt;

        $plant = $request->plant;
        $section = $request->section;
        $shift = $request->shift;

        $uid = Auth::user()->user_id;

        if ($uid == '1001628') {

            $depts = DB::select("select  plant_id,count(dept_id) total_dept
                    from hrms.dept_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = 1100
                    group by plant_id");

            $tolemps = DB::select("select plant_id,count(emp_id) total_emp
                    from hrms.emp_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = 1100
                    group by plant_id");


            $pemps = DB::select("
                    select count(emp_id) present_emp
                    from   hrms.v_emp_status@web_to_hrms
                    where  plant_id = 1100
                    and  main_status = 'PRESENT'
                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
                ");


            $emp_osd = DB::select("
                select count(emp_id) osd
                from   hrms.v_emp_status@web_to_hrms
                where  plant_id = 1100
                and  main_status = 'OFFICIAL WORK'
                and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
    
            ");


            $l_emp = DB::select("

                select count(emp_id) leave_emp
                from   hrms.v_emp_status@web_to_hrms
                where  plant_id = 1100
                and  main_status = 'LEAVE'
                and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
    
            ");

            $absent = $tolemps[0]->total_emp - ($pemps[0]->present_emp + $emp_osd[0]->osd + $l_emp[0]->leave_emp);
            $levEmp = $l_emp[0]->leave_emp;


            //   $plant = DB::select("select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' ");
            //   $plnat_id = $plant[0]->plant_id;
            $plant_id = 1100;

            //   for factory current process purpose start
            if ($plant_id != '1000') {

                $curr_dt = Carbon::now()->format('d-M-Y');

                if ($cng_date == $curr_dt) {

                    $barcharQry = "select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,
                    nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                        (select a.dept_id,b.dept_name,a.present_emp
                            from
                                (
                                    select dept_id,count(emp_id) present_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'PRESENT'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id
                                )a, (select * from hrms.dept_information@web_to_hrms) b
                            where a.dept_id = b.dept_id
                          ) x,
                            (
                                select a.dept_id,a.absent_emp
                                from
                                    (select dept_id,count(emp_id) absent_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'ABSENT'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }
                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) y,

                            (
                                select a.dept_id,a.emp_osd
                                from
                                    (select dept_id,count(emp_id) emp_osd
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'OSD'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) z,
                            (
                                select a.dept_id,a.emp_lev
                                from
                                    (select dept_id,count(emp_id) emp_lev
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'LEAVE'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = 1100
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) l
                    where x.dept_id = y.dept_id (+)
                    and   x.dept_id = z.dept_id(+)
                    and   x.dept_id = l.dept_id(+)
                    order by x.dept_id";

                    $barcharData = DB::select($barcharQry);
                } else {
                    $barcharQry = "select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                        from(select a.dept_id,b.dept_name,a.present_emp
                        from
                        (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'PRESENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = 1100
                            and valid = 'YES'
                            )
                            group by dept_id


                        )a, (select * from hrms.dept_information@web_to_hrms) b
                    where a.dept_id = b.dept_id
                  ) x,
                    (
                        select a.dept_id,a.absent_emp
                        from
                            (select dept_id,count(emp_id) absent_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'ABSENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = 1100
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) y,

                    (
                        select a.dept_id,a.emp_osd
                        from
                            (select dept_id,count(emp_id) emp_osd
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'OSD'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = 1100
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) z,
                    
                    (
                        select a.dept_id,a.emp_lev
                        from
                            (select dept_id,count(emp_id) emp_lev
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'LEAVE'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = 1100
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) l
                        where x.dept_id = y.dept_id (+)
                        and   x.dept_id = z.dept_id(+)
                        and   x.dept_id = l.dept_id(+)
                        order by x.dept_id
                    ";

                    $barcharData = DB::select($barcharQry);
                }


                if (empty($barcharData)) {
                    return view('elm_portal.reports.processNotComplete');
                } else {
                    return view('elm_portal.reports.Dashboard', ['dept' => $depts, 'tolemps' => $tolemps, 'pemps' => $pemps,
                        'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData,
                        'curr_dt' => $cng_date,'plant_info'=>$plant_info,'holidays'=>$holiday_info]);
                }

            } else {

                $barcharQry = "select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                    ( select a.dept_id,b.dept_name,a.present_emp
                        from
                            (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'PRESENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                                )
                            and valid = 'YES'
                            )
                            group by dept_id


                        )a, (select * from hrms.dept_information@web_to_hrms) b
                    where a.dept_id = b.dept_id
                  ) x,
                    (
                        select a.dept_id,a.absent_emp
                        from
                            (select dept_id,count(emp_id) absent_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'ABSENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) y,

                    (
                        select a.dept_id,a.emp_osd
                        from
                            (select dept_id,count(emp_id) emp_osd
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'OSD'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) z,

                    (
                        select a.dept_id,a.emp_lev
                        from
                            (select dept_id,count(emp_id) emp_lev
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'LEAVE'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) l
                    where x.dept_id = y.dept_id (+)
                    and   x.dept_id = z.dept_id(+)
                    and   x.dept_id = l.dept_id(+)
                    order by x.dept_id";

                $barcharData = DB::select($barcharQry);

                if (empty($barcharData)) {
                    return view('elm_portal.reports.processNotComplete');
                } else {

                    return view('elm_portal.reports.Dashboard', ['dept' => $depts, 'tolemps' => $tolemps, 'pemps' => $pemps,
                        'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData,
                        'curr_dt' => $cng_date,'plant_info'=>$plant_info,'holidays'=>$holiday_info]);
                }
            }
        } else {
            $depts = DB::select("select  plant_id,count(dept_id) total_dept
                    from hrms.dept_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = (select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' )
                    group by plant_id");

            $tolemps = DB::select("select plant_id,count(emp_id) total_emp
                    from hrms.emp_information@web_to_hrms
                    where valid = 'YES'
                    and plant_id = (select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' )
                    group by plant_id");


            $pemps = DB::select("
                select count(emp_id) present_emp
                from   hrms.v_emp_status@web_to_hrms
                where  plant_id = (
                                    select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                 )
                and  main_status = 'PRESENT'
                and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
            ");


            $emp_osd = DB::select("
                select count(emp_id) osd
                from   hrms.v_emp_status@web_to_hrms
                where  plant_id = (
                                    select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                 )
                and  main_status = 'OFFICIAL WORK'
                and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'

            ");


            $l_emp = DB::select("

                select count(emp_id) leave_emp
                from   hrms.v_emp_status@web_to_hrms
                where  plant_id = (
                            select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                         )
                and  main_status = 'LEAVE'
                and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
    
            ");

            $absent = $tolemps[0]->total_emp - ($pemps[0]->present_emp + $emp_osd[0]->osd + $l_emp[0]->leave_emp);
            $levEmp = $l_emp[0]->leave_emp;


            $plant = DB::select("select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' ");
            $plnat_id = $plant[0]->plant_id;

            //for factory current process purpose start
            if ($plnat_id != '1000') {

                $curr_dt = Carbon::now()->format('d-M-Y');
                if ($cng_date == $curr_dt) {

                    $barcharQry = "select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,
                    nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                        (select a.dept_id,b.dept_name,a.present_emp
                            from
                                (
                                    select dept_id,count(emp_id) present_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'PRESENT'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                        )
                                    and valid = 'YES'
                                    )
                                    group by dept_id


                                )a, (select * from hrms.dept_information@web_to_hrms) b
                            where a.dept_id = b.dept_id
                          ) x,
                            (
                                select a.dept_id,a.absent_emp
                                from
                                    (select dept_id,count(emp_id) absent_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'ABSENT'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                    )
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) y,

                            (
                                select a.dept_id,a.emp_osd
                                from
                                    (select dept_id,count(emp_id) emp_osd
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'OSD'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                    )
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) z,
                            (
                                select a.dept_id,a.emp_lev
                                from
                                    (select dept_id,count(emp_id) emp_lev
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'LEAVE'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                                    from hrms.emp_information@web_to_hrms
                                    where plant_id = ( select plant_id
                                    from hrms.emp_information@web_to_hrms
                                    where emp_id = '$uid'
                                    and valid = 'YES'
                                    )
                                    and valid = 'YES'
                                    )
                                    group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                                where a.dept_id = b.dept_id
                            ) l


                    where x.dept_id = y.dept_id (+)
                    and   x.dept_id = z.dept_id(+)
                    and   x.dept_id = l.dept_id(+)
                    order by x.dept_id";

                    $barcharData = DB::select($barcharQry);

                } else {
                    $barcharQry = "select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                    (select a.dept_id,b.dept_name,a.present_emp
                    from
                        (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'PRESENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                                )
                            and valid = 'YES'
                            )
                            group by dept_id


                        )a, (select * from hrms.dept_information@web_to_hrms) b
                    where a.dept_id = b.dept_id
                  ) x,
                    (
                        select a.dept_id,a.absent_emp
                        from
                            (select dept_id,count(emp_id) absent_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'ABSENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) y,

                    (
                        select a.dept_id,a.emp_osd
                        from
                            (select dept_id,count(emp_id) emp_osd
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'OSD'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) z,
                    
                    (
                        select a.dept_id,a.emp_lev
                        from
                            (select dept_id,count(emp_id) emp_lev
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'LEAVE'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                    if($section != null){
                        $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                    }

                    if($shift != null){
                        $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                    }

                    $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) l

        
                    where x.dept_id = y.dept_id (+)
                    and   x.dept_id = z.dept_id(+)
                    and   x.dept_id = l.dept_id(+)
                    order by x.dept_id";

                    $barcharData = DB::select($barcharQry);
                }

                if (empty($barcharData)) {
                    return view('elm_portal.reports.processNotComplete');
                } else {
                    return view('elm_portal.reports.Dashboard', ['dept' => $depts, 'tolemps' => $tolemps, 'pemps' => $pemps,
                        'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData,
                        'curr_dt' => $cng_date,'plant_info'=>$plant_info,'holidays'=>$holiday_info]);
                }

            } else {

                $barcharQry = "select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                    (select a.dept_id,b.dept_name,a.present_emp
                    from
                        (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'PRESENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                                )
                            and valid = 'YES'
                            )
                            group by dept_id


                        )a, (select * from hrms.dept_information@web_to_hrms) b
                    where a.dept_id = b.dept_id
                  ) x,
                    (
                        select a.dept_id,a.absent_emp
                        from
                            (select dept_id,count(emp_id) absent_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'ABSENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) y,
 
                    (
                        select a.dept_id,a.emp_osd
                        from
                            (select dept_id,count(emp_id) emp_osd
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'OSD'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) z,

                    (
                        select a.dept_id,a.emp_lev
                        from
                            (select dept_id,count(emp_id) emp_lev
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'LEAVE'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'";

                if($section != null){
                    $barcharQry .= " and section_id = decode ('$section','$section',section_id,'$section')";
                }

                if($shift != null){
                    $barcharQry .= " and shift_id = decode ('$shift','$shift',shift_id,'$shift')";
                }

                $barcharQry .= " and emp_id in (select emp_id
                            from hrms.emp_information@web_to_hrms
                            where plant_id = ( select plant_id
                            from hrms.emp_information@web_to_hrms
                            where emp_id = '$uid'
                            and valid = 'YES'
                            )
                            and valid = 'YES'
                            )
                            group by dept_id)a, (select * from hrms.dept_information@web_to_hrms) b
                        where a.dept_id = b.dept_id
                    ) l
                    where x.dept_id = y.dept_id (+)
                    and   x.dept_id = z.dept_id(+)
                    and   x.dept_id = l.dept_id(+)
                    order by x.dept_id";

                $barcharData = DB::select($barcharQry);

                if (empty($barcharData)) {
                    return view('elm_portal.reports.processNotComplete');
                } else {
                    return view('elm_portal.reports.Dashboard', ['dept' => $depts, 'tolemps' => $tolemps, 'pemps' => $pemps,
                        'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData,
                        'curr_dt' => $cng_date,'plant_info'=>$plant_info,'holidays'=>$holiday_info]);
                }
            }
        }

    }
    public function getSHiftndSectionInfo(Request $request){
        $date = $request->date;
        $plant = $request->plant;
        $qry = DB::SELECT("SELECT DISTINCT a.SHIFT_ID,a.SHIFT_NAME FROM HRMS.SHIFT_INFORMATION@web_to_hrms a 
                        INNER JOIN HRMS.EMP_WORK_STATUS_FINAL@web_to_hrms b ON a.SHIFT_ID = b.SHIFT_ID
                        WHERE to_char(b.working_date,'DD-Mon-RRRR') = '$date' AND a.PLANT_ID = $plant ORDER BY a.SHIFT_NAME ASC");

        $qry2 = DB::SELECT("SELECT DISTINCT SECTION_ID FROM HRMS.SECTION_INFORMATION@web_to_hrms WHERE PLANT_ID = '$plant' ORDER BY SECTION_ID ASC");
        return response()->json(['shift_info'=>$qry,'sec_info'=>$qry2]);
    }

}