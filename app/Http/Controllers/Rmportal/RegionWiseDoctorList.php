<?php

namespace App\Http\Controllers\Rmportal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;


class RegionWiseDoctorList extends Controller
{
    public function regwMpoTerrList(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            // $resp_data = DB::Select("select distinct mpo_terr_id mpo_terr_id 
            //                     from hrtms.hr_terr_list@web_to_hrtms
            //                     where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            //                     and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from rm_gm_info  where rm_emp_id ||asm_emp_id in ('$request->rmTerrId') )  
            //                     and substr(mpo_terr_id,1,instr(mpo_terr_id,'-',1,1))||trunc(substr(mpo_terr_id,instr(mpo_terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
            //                     order by mpo_terr_id");

            $resp_data = DB::select("
                                select distinct case when mpo_terr_id not like '%-AG-%' 
                                and (mpo_terr_id like '%-A%' or mpo_terr_id like '%-B%' or mpo_terr_id like '%-G%') 
                                then substr(mpo_terr_id,1,instr(mpo_terr_id,'-',1,1))||substr(mpo_terr_id,instr(mpo_terr_id,'-',1,1)+1,1)||
                                '-'||substr(mpo_terr_id,instr(mpo_terr_id,'-',-1,1)+1,3) else mpo_terr_id end mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from rm_gm_info  where rm_emp_id ||asm_emp_id in ('$request->rmTerrId') )  
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-',1,1))||trunc(substr(mpo_terr_id,instr(mpo_terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
                                order by mpo_terr_id
                ");

            return response()->json($resp_data);
        }
    }

    public function regTerrDocList(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {
            // $resp_data = DB::Select("select distinct terr_id,doctor_id,doctor_name,hospital_name,hospital_addr,sex,spec_code
            //                         from
            //                         (select dt.terr_id,di.name doctor_name,di.hospital_name,di.hospital_addr,di.sex,di.spec_code,substr(dt.terr_id,1,instr(dt.terr_id,'-',1,1))||trunc(substr(dt.terr_id,instr(dt.terr_id,'-',-1,1)+1),-1) am_terr_id,
            //                                substr(dt.terr_id,1,instr(dt.terr_id,'-'))||'00' rm_terr_id,di.doctor_id
            //                         from msfa.doctor_info@web_to_imsfa di,msfa.doctor_terr@web_to_imsfa dt
            //                         where di.doctor_id = dt.doctor_id) dif,mis.RM_GM_INFO rgi
            //                         where dif.rm_terr_id = rgi.rm_terr_id
            //                         and rgi.rm_terr_id = '$request->smrmTerr'
            //                         and dif.am_terr_id = '$request->amTerrId'
            //                         and dif.terr_id = '$request->mpoId'
            //                         order by terr_id,doctor_id");

            //Updated at 05-MAR-18

            // $resp_data = DB::select("
            //     select distinct case when dif.terr_id not like '%-AG-%' and (dif.terr_id like '%-A%' or dif.terr_id like '%-B%' or dif.terr_id like '%-G%') 
            //        then substr(dif.terr_id,1,instr(dif.terr_id,'-',1,1))||substr(dif.terr_id,instr(dif.terr_id,'-',1,1)+1,1)||
            //        '-'||substr(dif.terr_id,instr(dif.terr_id,'-',-1,1)+1,3) else dif.terr_id end terr_id,doctor_id,doctor_name,hospital_name,hospital_addr,sex,spec_code
            //         from
            //         (select dt.terr_id,di.name doctor_name,di.hospital_name,di.hospital_addr,di.sex,di.spec_code,substr(dt.terr_id,1,instr(dt.terr_id,'-',1,1))||trunc(substr(dt.terr_id,instr(dt.terr_id,'-',-1,1)+1),-1) am_terr_id,
            //                substr(dt.terr_id,1,instr(dt.terr_id,'-'))||'00' rm_terr_id,di.doctor_id
            //         from msfa.doctor_info@web_to_imsfa di,msfa.doctor_terr@web_to_imsfa dt
            //         where di.doctor_id = dt.doctor_id) dif,mis.RM_GM_INFO rgi
            //         where dif.rm_terr_id = rgi.rm_terr_id
            //         and rgi.rm_terr_id = '$request->smrmTerr'
            //         and dif.am_terr_id = '$request->amTerrId'
            //         and case when dif.terr_id not like '%-AG-%' and (dif.terr_id like '%-A%' or dif.terr_id like '%-B%' or dif.terr_id like '%-G%') 
            //                then substr(dif.terr_id,1,instr(dif.terr_id,'-',1,1))||substr(dif.terr_id,instr(dif.terr_id,'-',1,1)+1,1)||
            //                '-'||substr(dif.terr_id,instr(dif.terr_id,'-',-1,1)+1,3) else dif.terr_id end = '$request->mpoId'
            //         order by terr_id,doctor_id
            //     ");

            $resp_data = DB::select("
                 select terr_id,doctor_id,doctor_name,hospital_name,hospital_addr,sex,details ||' (' ||spec_code||') ' as spec_code
                from
                (select dt.terr_id,di.doctor_name,di.hospital_address hospital_name,case when CHEMBER_ADDRESS is null then mailing_address else CHEMBER_ADDRESS end hospital_addr,
                di.sex,di.spec_code,pp.details,substr(dt.terr_id,1,instr(dt.terr_id,'-',1,1))||trunc(substr(dt.terr_id,instr(dt.terr_id,'-',-1,1)+1),-1) am_terr_id,
                substr(dt.terr_id,1,instr(dt.terr_id,'-'))||'00' rm_terr_id,di.doctor_id
                from doctor_info.doctor_information@WEB_TO_SAMPLE_MSD di,mis.doctor_wise_territory dt, p4aug.speciality_code@WEB_TO_SAMPLE_MSD pp
                where di.doctor_id = dt.doctor_id
                and nvl(di.doctor_status,'AA') <> 'DELETE'
                and di.spec_code = pp.code(+)
                ) dif,mis.RM_GM_INFO rgi
                where dif.rm_terr_id = rgi.rm_terr_id
                and rgi.rm_terr_id = '$request->smrmTerr'
                and dif.am_terr_id = '$request->amTerrId'
                and dif.terr_id = decode('$request->mpoId','All',dif.terr_id,'$request->mpoId')
                order by terr_id,doctor_id

                ");

            //var_dump($resp_data);
            return response()->json($resp_data);
            //return response()->json($request->all());
        }

    }

    // public function regWTerrAmList(Request $request){
    //     DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
    //     $uid = Auth::user()->user_id;
    //     if($request->ajax()){
    //         if( Auth::user()->desig === 'GM') {
    //             $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
    //                                 from hrtms.hr_terr_list@web_to_hrtms
    //                                 where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ('$uid') )  
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
    //                                 and am_terr_id not like '%-500%'
    //                                 order by am_terr_id");
    //         }

    //         if( Auth::user()->desig === 'NSM') {
    //             $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
    //                                 from hrtms.hr_terr_list@web_to_hrtms
    //                                 where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
    //                                 and am_terr_id not like '%-500%'
    //                                 order by am_terr_id");
    //         }

    //         if( Auth::user()->desig === 'SM') {
    //             $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
    //                                 from hrtms.hr_terr_list@web_to_hrtms
    //                                 where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ('$uid') )  
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
    //                                 and am_terr_id not like '%-500%'
    //                                 order by am_terr_id");
    //         }

    //         if( Auth::user()->desig === 'DSM') {
    //             $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
    //                                 from hrtms.hr_terr_list@web_to_hrtms
    //                                 where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
    //                                 and am_terr_id not like '%-500%'
    //                                 order by am_terr_id");
    //         }

    //        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
    //             $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
    //                                 from hrtms.hr_terr_list@web_to_hrtms
    //                                 where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
    //                                 and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
    //                                 and am_terr_id not like '%-500%'
    //                                 order by am_terr_id");
    //         }
    //     }

    //     return response()->json($resp_data);
    // }


public function regWTerrAmList(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        if($request->ajax()){
            if( Auth::user()->desig === 'GM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

            if( Auth::user()->desig === 'NSM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

            if( Auth::user()->desig === 'SM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

            if( Auth::user()->desig === 'DSM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

           if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }
        }

        return response()->json($resp_data);
    }
    
}
