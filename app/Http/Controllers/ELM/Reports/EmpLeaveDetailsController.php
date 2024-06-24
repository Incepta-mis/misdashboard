<?php

namespace App\Http\Controllers\ELM\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmpLeaveDetailsController extends Controller
{
    public function index()
    {
        $company = DB::select("select distinct com_id,com_name
        from hrms.company_info@WEB_TO_HRMS
        order by com_id ");
        return view('elm_portal/reports/EmpLeaveDetails', ['com' => $company]);
    }

    public function getDeptEmp(Request $request){

        $employees = DB::select("select emp_id,sur_name
        from hrms.emp_information@WEB_TO_HRMS
        where dept_id = ?
        order by emp_id",[$request->dept_id]);

        return response()->json($employees);
    }

    public function getEmpDetails(Request $request){

        //ALTER SESSION SET 'NLS_DATE_FORMAT' = 'DD-MM-YYYY HH24:MI:SS';

        $employees = DB::select("
        select a.line_id,a.emp_id,a.emp_name,a.emp_desig_name,a.emp_dept_name,to_char(a.application_date,'DD-MON-RR') application_date,
        to_char(a.leave_from,'DD-MON-RR') leave_from,to_char(a.leave_to,'DD-MON-RR') leave_to,a.emp_contact_no,a.emp_email,a.type_of_leave,
        a.add_during_leave,a.purpose_of_leave,a.rsp_emp_name,a.rsp_desig_name,to_char(a.rsp_accept_date,'DD-MON-RR') rsp_accept_date,
        a.rsp_duties,mis.leave_emp_name(rpt_supervisor_id) recommended_by,to_char(a.sup_accept_date,'DD-MON-RR') sup_accept_date ,mis.leave_emp_name(head_of_dept_id) approved_by,to_char(a.rcm_approved_date,'DD-MON-RR') rcm_accept
        from mis.leave_emp_record a INNER JOIN hrms.emp_information@web_to_hrms b on a.emp_id = b.emp_id
        where a.emp_id = decode('$request->emp_id','All',a.emp_id,'$request->emp_id')
        and a.emp_dept_id = '$request->dept_id'
        and a.plant_id = '$request->plant_id'
        and b.valid = decode('$request->valid','All',b.valid,'$request->valid')
        order by a.create_date desc        
        ");

        return response()->json($employees);

    }
    public function getApplicationFormPdf($line_id){
        DB::setDateFormat('DD-MON-RR');

        $data = array();

        $dbData = DB::SELECT("select a.line_id, to_char(a.application_date,'RRRR') leave_year,a.emp_id,a.emp_name,a.emp_desig_name,a.emp_dept_name,to_char(a.application_date,'DD-MON-RR') application_date,
        to_char(a.leave_from,'DD-MON-RR') leave_from,to_char(a.leave_to,'DD-MON-RR') leave_to,a.day_of_leave,a.emp_contact_no,a.emp_email,a.type_of_leave,
        a.add_during_leave,a.purpose_of_leave,a.rsp_emp_name,a.rsp_desig_name,to_char(a.rsp_accept_date,'DD-MON-RR') rsp_accept_date,a.app_status,a.updated_at,a.final_approved_by,mis.leave_emp_name(final_approved_by) final_approved_by_name,
        a.rsp_duties,mis.leave_emp_name(rpt_supervisor_id) recommended_by,to_char(a.sup_accept_date,'DD-MON-RR') sup_accept_date ,mis.leave_emp_name(head_of_dept_id) approved_by,to_char(a.rcm_approved_date,'DD-MON-RR') rcm_accept
        from mis.leave_emp_record a WHERE a.line_id = '$line_id'");

        $data['emp_id'] = $dbData[0]->emp_id;
        $data['emp_name'] = $dbData[0]->emp_name;
        $data['emp_desig_name'] = $dbData[0]->emp_desig_name;
        $data['emp_dept_name'] = $dbData[0]->emp_dept_name;
        $data['leave_from'] = $dbData[0]->leave_from;
        $data['leave_to'] = $dbData[0]->leave_to;
        $data['purpose_of_leave'] = $dbData[0]->purpose_of_leave;
        $data['add_during_leave'] = $dbData[0]->add_during_leave;
        $data['emp_contact_no'] = $dbData[0]->emp_contact_no;
        if($dbData[0]->rsp_emp_name == null){
            $data['rsp_emp_name'] = 'N/A';
        }else{
            $data['rsp_emp_name'] = $dbData[0]->rsp_emp_name;
        }
        $data['application_date'] = $dbData[0]->application_date;
        $data['day_of_leave'] = $dbData[0]->day_of_leave;
        $data['type_of_leave'] = $dbData[0]->type_of_leave;
        $data['leave_year'] = $dbData[0]->leave_year;
        $data['recommended_by'] = $dbData[0]->recommended_by;
        $data['approved_by'] = $dbData[0]->approved_by;
        $data['sup_accept_date'] = $dbData[0]->sup_accept_date;
        $data['rcm_accept'] = $dbData[0]->rcm_accept;
        $data['updated_at'] = $dbData[0]->updated_at;
        $data['final_approved_by'] = $dbData[0]->final_approved_by;
        $data['final_approved_by_name'] = $dbData[0]->final_approved_by_name;

        $leaveStatus = DB::select("SELECT x.emp_id
          ,MAX(DECODE(x.leave_type, 'ANNUAL', x.total_allowed_leave)) ANNUAL
          ,MAX(DECODE(x.leave_type, 'CASUAL', x.total_allowed_leave)) CASUAL
          ,MAX(DECODE(x.leave_type, 'LWP', x.total_allowed_leave)) LWP
          ,MAX(DECODE(x.leave_type, 'MATERNITY', x.total_allowed_leave)) MATERNITY
          ,MAX(DECODE(x.leave_type, 'MEDICAL', x.total_allowed_leave)) MEDICAL
          ,MAX(DECODE(x.leave_type, 'ADVANCE', x.total_allowed_leave)) ADVANCE
          ,MAX(DECODE(x.leave_type, 'SPECIAL MEDICAL', x.total_allowed_leave)) SPECIAL_MEDICAL
          FROM (
          SELECT   r.emp_id
          ,r.leave_type
          ,r.total_allowed_leave
          ,r.leave_year
          FROM hrms.v_employee_leave_status@web_to_hrms r
          ) x
          WHERE X.EMP_ID = '".$data['emp_id']."'
          AND X.leave_year = '".$data['leave_year']."'
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
          FROM hrms.v_employee_leave_status@web_to_hrms r
          ) x
          WHERE X.EMP_ID = '".$data['emp_id']."'
          AND X.leave_year = '".$data['leave_year']."'
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
          FROM  hrms.v_employee_leave_status@web_to_hrms r
          ) x
          WHERE X.EMP_ID = '".$data['emp_id']."'
          AND X.leave_year = '".$data['leave_year']."'
          GROUP BY x.emp_id ");

        $data['leaveStatus'] = $leaveStatus;

        $uid = $data['emp_id'];
        $qryy = DB::SELECT("SELECT * FROM MIS.LEAVE_EMP_INFO WHERE EMP_ID = '$uid'");
        $hr_officer1 = $qryy[0]->hr_officer1;
        $hr_officer2 = $qryy[0]->hr_officer2;
        $rand = rand(1,2);
        if($rand == 1){
            $hr_name = DB::SELECT("SELECT MIS.LEAVE_EMP_NAME('".$hr_officer1."') hr_name from dual");
        }else{
            $hr_name = DB::SELECT("SELECT MIS.LEAVE_EMP_NAME('".$hr_officer2."') hr_name from dual");
        }
        $data["hr_name"] = $hr_name[0]->hr_name;

        $permaOrCasual = DB::SELECT("SELECT MGT_STATUS FROM MIS.LEAVE_EMP_INFO WHERE EMP_ID= '$uid'");
        $data["permaOrCasual"] = $permaOrCasual[0]->mgt_status;

        $data["app_status"] = $dbData[0]->app_status;

        $pdf = \PDF::loadView('elm_portal/reports/leaveApplicationForm', $data);
        return $pdf->setPaper('a4','portrait')->stream($line_id."pdf");
    }


}
