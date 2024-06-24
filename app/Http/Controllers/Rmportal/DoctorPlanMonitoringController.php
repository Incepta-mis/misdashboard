<?php


namespace App\Http\Controllers\Rmportal;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class DoctorPlanMonitoringController
{
    public function index(){
        $queryRs = '';
        try {
            $queryRs = DB::select("select distinct gm_id, upper(gm_name) gm_name from mis.rm_gm_info order by gm_id");
        }catch ( Oci8Exception $e){
            $e->getMessage();
        }
        return view('rm_portal.doctorPlanMonitoring',['gmInfo'=>$queryRs]);
    }

    public function getRmAsm(Request $request){
        $queryRs = '';
        try {
            $queryRs = DB::select(" select distinct rm_terr_id, case when rm_emp_id is null then asm_name else rm_name end rm_name from mis.rm_gm_info where gm_id = '$request->gm_id' order by rm_terr_id");
        }catch ( Oci8Exception $e){
            $e->getMessage();
        }
        return response()->json($queryRs);
    }

    public function getDocPlanData(Request $request){
        $queryRS = '';
        try{
            $queryRS = DB::select("
            select rm_terr_id,rm_name,am_terr_id,terr_id,total_doc,plan_doctor,brand_doctor
            from(     
            select 'ALL' all_data,gm_id,gm_name,dd.rm_terr_id,rm_name,am_terr_id,terr_id,total_doc,plan_doctor,brand_doctor
            from
            (select substr(dwt.terr_id,1,instr(dwt.terr_id,'-'))||'00' rm_terr_id,
                    substr(dwt.terr_id,1,instr(dwt.terr_id,'-',1,1))||trunc(substr(dwt.terr_id,instr(dwt.terr_id,'-',-1,1)+1),-1)am_terr_id,
                    dwt.terr_id,total_doc,plan_doctor,no_of_brand brand_doctor
            from
            (select terr_id,count(di.doctor_id) total_doc
            from mis.doctor_wise_territory dwt,doctor_info.doctor_information@web_to_sample_msd di
            where dwt.doctor_id = di.doctor_id
            and nvl(doctor_status,'AA') <> 'DELETE'
            group by terr_id) dwt,( select terr_id,count(*) plan_doctor
                                    from
                                    (select distinct terr_id,doctor_id
                                     from mis.territory_wise_doctor_plan
                                     where (nvl(visit1,0)+nvl(visit2,0)+nvl(visit3,0)+nvl(visit4,0)) > 0                         
                                    )group by terr_id) twdp,(select terr_id,count(*) no_of_brand from
                                                            (select distinct terr_id,doctor_id from mis.doctor_wise_item_utilization                                                
                                                             )group by terr_id) dwba
            where dwt.terr_id = twdp.terr_id(+)
            and dwt.terr_id = dwba.terr_id(+)
            )dd,(select gm_id,gm_name,rm_terr_id,case when rm_emp_id is null then asm_name else rm_name end rm_name
                 from mis.rm_gm_info) rgi
            where dd.rm_terr_id = rgi.rm_terr_id
            )where '$request->gm_id' = case when '$request->gm_id' = 'ALL' then all_data else gm_id end
            and '$request->rm_id' = case when '$request->rm_id' = 'ALL' then all_data else rm_terr_id end 
            order by rm_terr_id,am_terr_id,terr_id          
            ");
        }catch (Oci8Exception $exception){
           log::info( $exception->getMessage());
        }
        return response()->json($queryRS);

    }

}