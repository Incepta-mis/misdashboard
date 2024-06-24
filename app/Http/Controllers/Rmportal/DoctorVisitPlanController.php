<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 13/01/18
 * Time: 15:54
 */

namespace App\Http\Controllers\Rmportal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;


class DoctorVisitPlanController extends Controller
{
    public function regwGetVisitPlan(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::select("
                         select twdp.terr_id,twdp.doctor_id,di.doctor_name name,tl.terr_group,twdp.plan_week,twdp.plan_day
from (select terr_id,doctor_id,plan_week,plan_day
      from(  
      select terr_id,doctor_id,1 plan_week,week1 plan_day
      from mis.TERRITORY_WISE_DOCTOR_PLAN
      where nvl(visit1,0) = 1
      union all
      select terr_id,doctor_id,2 plan_week,week1 plan_day
      from mis.TERRITORY_WISE_DOCTOR_PLAN
      where nvl(visit2,0) = 1
      union all
      select terr_id,doctor_id,3 plan_week,week1 plan_day
      from mis.TERRITORY_WISE_DOCTOR_PLAN
      where nvl(visit3,0) = 1
      union all
      select terr_id,doctor_id,4 plan_week,week1 plan_day
      from mis.TERRITORY_WISE_DOCTOR_PLAN
      where nvl(visit4,0) = 1)
      ) twdp,(select distinct doctor_id,doctor_name
              from doctor_info.doctor_information@web_to_sample_msd) di,(select distinct mpo_terr_id,p_group terr_group
                                                                         from hrtms.hr_terr_list@web_to_hrtms
                                                                         where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')) tl  
where twdp.doctor_id = di.doctor_id
and twdp.terr_id = tl.mpo_terr_id
and twdp.terr_id = '$request->TerrId'
and upper(twdp.plan_day) = decode(initcap('$request->plan_day'),'All',upper(twdp.plan_day),upper('$request->plan_day'))
and twdp.plan_week = decode('$request->plan_week','All',plan_week,'$request->plan_week')
and tl.terr_group  = decode('$request->prp_group','All',terr_group,'$request->prp_group')
            ");

            // $resp_data = DB::select("

            //    select distinct case when pl.terr_id not like '%-AG-%' and (pl.terr_id like '%-A%' or pl.terr_id like '%-B%' or pl.terr_id like '%-G%') 
            //            then substr(pl.terr_id,1,instr(pl.terr_id,'-',1,1))||substr(pl.terr_id,instr(pl.terr_id,'-',1,1)+1,1)||
            //            '-'||substr(pl.terr_id,instr(pl.terr_id,'-',-1,1)+1,3) else pl.terr_id end terr_id,pl.doctor_id,dc.name,pl.terr_group,pl.plan_week,pl.plan_day
            //     from msfa.terr_doctor_plan_info@WEB_TO_IMSFA pl
            //     inner join msfa.doctor_info@WEB_TO_IMSFA dc
            //     on (pl.doctor_id = dc.doctor_id)
            //     where case when pl.terr_id not like '%-AG-%' and (pl.terr_id like '%-A%' or pl.terr_id like '%-B%' or pl.terr_id like '%-G%') 
            //            then substr(pl.terr_id,1,instr(pl.terr_id,'-',1,1))||substr(pl.terr_id,instr(pl.terr_id,'-',1,1)+1,1)||
            //            '-'||substr(pl.terr_id,instr(pl.terr_id,'-',-1,1)+1,3) else pl.terr_id end =  '$request->TerrId'
            //     and  pl.plan_day = decode('$request->plan_day','All',pl.plan_day,'$request->plan_day')
            //     and pl.plan_week = decode('$request->plan_week','All',pl.plan_week,'$request->plan_week')
            //     and pl.terr_group =decode('$request->prp_group','All',pl.terr_group,'$request->prp_group')
            //     and pl.valid = 'YES'

            //     ");

            return response()->json($resp_data);
            //return response()->json($request->all());
        }
    }

}