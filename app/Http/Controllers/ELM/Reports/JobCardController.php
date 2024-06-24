<?php


namespace App\Http\Controllers\ELM\Reports;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobCardController
{
    public function index(){
        $company = DB::select("select distinct com_id,com_name
        from hrms.company_info@WEB_TO_HRMS
        order by com_id ");
        return view('elm_portal.reports.jobCardReport', ['com' => $company]);
    }


    public function job_reports(Request $request){

//        return response()->json($request->all());


        DB::setDateFormat('DD-Mon-RR');

        $DT1 = date('d-M-y', strtotime("$request->dt_1 "));
        $DT2 = date('d-M-y', strtotime("$request->dt_2"));


        $empAttnSummary =     DB::select("
        select a.emp_id,a.emp_name,c.desig_name,b.dept_name,to_char(a.working_date,'DD-MON-RR') working_date ,to_char(a.working_date, 'DAY') day_name ,a.scedule_start_time,
        a.first_in_time,a.scedule_end_time,a.last_out_time,a.working_status,a.working_hour,a.completed
        from
        (
        select emp_id,emp_name,dept_id,desig_id,working_date, to_char(scedule_start_time,'DD-MON-RR HH12:MI:SS AM' ) scedule_start_time,to_char(first_in_time,'DD-MON-RR HH12:MI:SS AM' ) first_in_time ,
        to_char(scedule_end_time ,'DD-MON-RR HH12:MI:SS AM' ) scedule_end_time,to_char(last_out_time,'DD-MON-RR HH12:MI:SS AM' ) last_out_time,  working_status, round (24 * (scedule_end_time - scedule_start_time)) working_hour, round (24 * (last_out_time-first_in_time),2) completed
        from hrms.emp_work_status_final@web_to_hrms
        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
        and dept_id = '$request->dept_id'
        and plant_id = '$request->plant_id'
        and to_date(to_char(working_date,'DD-Mon-RR'),'DD-Mon-RR') between '$DT1' and '$DT2'
        union all
        select emp_id,emp_name,dept_id,desig_id,working_date, to_char(scedule_start_time,'DD-MON-RR HH12:MI:SS AM' ) scedule_start_time,to_char(first_in_time,'DD-MON-RR HH12:MI:SS AM' ) first_in_time ,
        to_char(scedule_end_time ,'DD-MON-RR HH12:MI:SS AM' ) scedule_end_time,to_char(last_out_time,'DD-MON-RR HH12:MI:SS AM' ) last_out_time,  working_status, round (24 * (scedule_end_time - scedule_start_time)) working_hour, round (24 * (last_out_time-first_in_time),2) completed
        from hrms.emp_work_status_final_current@web_to_hrms
        where  emp_id =  decode('$request->emp_id','All',emp_id,'$request->emp_id')
        and dept_id = '$request->dept_id'
         and plant_id = '$request->plant_id'
        and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)
        ) a, (select distinct dept_id,dept_name from hrms.dept_information@web_to_hrms) b,
        (select distinct desig_id,desig_name from hrms.emp_designation@web_to_hrms) c
        where a.dept_id = b.dept_id 
        and   a.desig_id = c.desig_id  
        order by a.working_date desc       
        ");

        return response()->json($empAttnSummary);
    }


    public function employeeWorkingStatus(Request $request){

        DB::setDateFormat('DD-Mon-RR');

        $DT1 = date('d-M-y', strtotime("$request->dt_1 "));
        $DT2 = date('d-M-y', strtotime("$request->dt_2"));


        $working_status = DB::select("
        select working_status,count(working_status) status
        from(
        select emp_id,emp_name,dept_id,desig_id,working_date, to_char(scedule_start_time,'DD-MON-RR HH12:MI:SS AM' ) scedule_start_time,to_char(first_in_time,'DD-MON-RR HH12:MI:SS AM' ) first_in_time ,
        to_char(scedule_end_time ,'DD-MON-RR HH12:MI:SS AM' ) scedule_end_time,to_char(last_out_time,'DD-MON-RR HH12:MI:SS AM' ) last_out_time,  working_status, round (24 * (scedule_end_time - scedule_start_time)) working_hour, round (24 * (last_out_time-first_in_time),2) completed
        from hrms.emp_work_status_final@web_to_hrms
        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
        and dept_id = '$request->dept_id'
        and plant_id = '$request->plant_id'
        and to_date(to_char(working_date,'DD-Mon-RR'),'DD-Mon-RR') between '$DT1' and '$DT2'
        union all
        select emp_id,emp_name,dept_id,desig_id,working_date, to_char(scedule_start_time,'DD-MON-RR HH12:MI:SS AM' ) scedule_start_time,to_char(first_in_time,'DD-MON-RR HH12:MI:SS AM' ) first_in_time ,
        to_char(scedule_end_time ,'DD-MON-RR HH12:MI:SS AM' ) scedule_end_time,to_char(last_out_time,'DD-MON-RR HH12:MI:SS AM' ) last_out_time,  working_status, round (24 * (scedule_end_time - scedule_start_time)) working_hour, round (24 * (last_out_time-first_in_time),2) completed
        from hrms.emp_work_status_final_current@web_to_hrms
        where  emp_id =  decode('$request->emp_id','All',emp_id,'$request->emp_id')
        and dept_id = '$request->dept_id'
        and plant_id = '$request->plant_id'
        and to_char(working_date,'DD-MON-RR') = (select to_char((sysdate),'DD-MON-RR') curr_date from dual)
        )
        group by working_status
        
        ");




        return response()->json($working_status);
    }



}