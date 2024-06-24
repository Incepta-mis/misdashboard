<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 24/2/2019
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\ELM\Reports;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{



    public function index()
    {
        $uid = Auth::user()->user_id;
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

        $absent = $tolemps[0]->total_emp - ( $pemps[0]->present_emp + $emp_osd[0]->osd + $l_emp[0]->leave_emp );
        $levEmp = $l_emp[0]->leave_emp;





        $barcharData = DB::select("


            select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
            from
                (select a.dept_id,b.dept_name,a.present_emp
                    from
                        (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final@web_to_hrms
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
                            from hrms.emp_work_status_final@web_to_hrms
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
                            from hrms.emp_work_status_final@web_to_hrms
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
                            from hrms.emp_work_status_final@web_to_hrms
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
        if(empty($barcharData))
        {
            // for factory current process purpose start
            if($plnat_id != '1000'){

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

                if(empty($barcharData)){
                    return view('elm_portal.reports.processNotComplete');
                }else{
                    return view('elm_portal.reports.Dashboard',['dept'=>$depts, 'tolemps'=>$tolemps, 'pemps'=>$pemps,
                        'absent'=>$absent,'emp_osd'=>$emp_osd,'lev_emp'=>$levEmp, 'barcharData'=> $barcharData]);
                }


            }else{
                return view('elm_portal.reports.processNotComplete');
            }
            // for factory current process purpose end

        }else{
            return view('elm_portal.reports.Dashboard',['dept'=>$depts, 'tolemps'=>$tolemps, 'pemps'=>$pemps,
                'absent'=>$absent,'emp_osd'=>$emp_osd,'lev_emp'=>$levEmp, 'barcharData'=> $barcharData]);
        }

    }






    public function indexChangeDate(Request $request)
    {

        $cng_date = $request->st_dt;

        $uid = Auth::user()->user_id;
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

        $absent = $tolemps[0]->total_emp - ( $pemps[0]->present_emp + $emp_osd[0]->osd + $l_emp[0]->leave_emp );
        $levEmp = $l_emp[0]->leave_emp;


        $plant = DB::select("select plant_id from hrms.emp_information@web_to_hrms where emp_id = '$uid' ");
        $plnat_id = $plant[0]->plant_id;

        //for factory current process purpose start
        if($plnat_id != '1000'){
                $curr_dt = Carbon::now()->format('d-M-Y');
               if( $cng_date == $curr_dt){
                   $barcharData = DB::select("

                    select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,
                    nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
                    from
                        (select a.dept_id,b.dept_name,a.present_emp
                            from
                                (
                                    select dept_id,count(emp_id) present_emp
                                    from hrms.emp_work_status_final_current@web_to_hrms
                                    where default_status = 'PRESENT'
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                                    and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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

               }else {
                   $barcharData = DB::select("


            select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
            from
                (select a.dept_id,b.dept_name,a.present_emp
                    from
                        (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'PRESENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'ABSENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'OSD'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'LEAVE'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
               }


            if(empty($barcharData)){
                return view('elm_portal.reports.processNotComplete');
            }else{
                return view('elm_portal.reports.Dashboard',['dept'=>$depts, 'tolemps'=>$tolemps, 'pemps'=>$pemps,
                    'absent'=>$absent,'emp_osd'=>$emp_osd,'lev_emp'=>$levEmp, 'barcharData'=> $barcharData]);
            }

        }else{

            $barcharData = DB::select("

            select x.dept_id,x.dept_name,nvl(x.present_emp,0) present_emp ,nvl(y.absent_emp,0) absent_emp ,nvl(z.emp_osd,0) emp_osd, nvl (l.emp_lev,0) emp_lev, nvl (x.present_emp,0) + nvl (y.absent_emp,0) + nvl (z.emp_osd,0) +nvl (l.emp_lev,0) total_emp
            from
                (select a.dept_id,b.dept_name,a.present_emp
                    from
                        (
                            select dept_id,count(emp_id) present_emp
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'PRESENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'ABSENT'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'OSD'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                            from hrms.emp_work_status_final@web_to_hrms
                            where default_status = 'LEAVE'
                            and to_char(working_date,'DD-Mon-RRRR') = '$cng_date'
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
                    'absent' => $absent, 'emp_osd' => $emp_osd, 'lev_emp' => $levEmp, 'barcharData' => $barcharData]);
            }
        }

    }

}