<?php
/**
 * Created by PhpStorm.
 * User: raqib
 * Date: 7/30/2018
 * Time: 11:07 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class docm_report_controller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('expense.doctor_maintenace_rpt');
    }

    public function searchDoctorById(Request $request)
    {
        $data = $request->json()->all();

        $doctor_info = DB::select(" select * from (
                                    select title,doctor_id,doctor_name name,m_terr_id terr_id
                                    from doctor_info.doctor_information@Web_To_Sample_Msd
                                    where doctor_id like '" . $data['param'] . "%' 
                                    order by doctor_id,doctor_name asc
                                    )where rownum < 25
                                    ");

        return response()->json($doctor_info);
    }

    public function getDoctorInformation(Request $request)
    {
        $data = $request->json()->all();
        Log::info('Displaying doctor id  --> '.$data['param'].' user --> '.Auth::user()->user_id);

        //selecting doctor information
        $doctor_info = DB::select("select *
                                        from(                                            
                                        select title,doctor_id,doctor_name name,position designation,ds.details spec_code,sex,qualification,doctor_status,m_terr_id terr_id,
                                               substr(m_terr_id,1,instr(m_terr_id,'-'))||'00' rm_terr_id,
                                               substr(m_terr_id,1,instr(m_terr_id,'-',1,1))||trunc(substr(m_terr_id,instr(m_terr_id,'-',-1,1)+1),-1) am_terr_id,
                                               hospital_name||hospital_address hospital_addr,chember_address,mailing_address,week_end_address,region
                                        from doctor_info.doctor_information@Web_To_Sample_Msd di,MIS.DASH_DOC_SPECIALITY ds
                                        where di.SPEC_CODE = DS.CODE
                                        ) where doctor_id =  ?", [$data['param']]);

        //doctor assigned terr
        $territoryData = DB::select("select dwt_id as rid,dwt.doctor_id as id,di.doctor_name as name,in_favour_of as ifo,terr_id as terr,hm.mpo_emp_id as eid,
                                            hm.mpo_name as ename,'' edesig,visiting_address as vaddr,guest,patient,valid,doctor_category as cata                                       
                                            from MIS.DOCTOR_WISE_TERRITORY dwt,doctor_info.doctor_information@web_to_sample_msd di,hrtms.hr_terr_list@web_to_hrtms hm
                                            where DWT.DOCTOR_ID = di.doctor_id 
                                            and dwt.terr_id = hm.mpo_terr_id
                                            and hm.emp_month = trunc(sysdate,'MM')
                                            and dwt.doctor_id = ?
                                            and valid = 'YES'", [$data['param']]);

        $info_arr = [
            'dd' => $doctor_info,
            'dt' => $territoryData
        ];

        return response()->json($info_arr);
    }
}