<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 04-Dec-18
 * Time: 10:38 AM
 */

namespace App\Http\Controllers\Dcr;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Log;
//use DB;
use Input;
use Validator;
use File;

//use Illuminate\Support\Facades\Log;


class PrescriptionSurveyController extends controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                order by am_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 6)
                                    select *
                                      from (select trunc(add_months(sysdate, -6)) dt from dual), data
                                     order by dt, l
                                     )");

            $brand_name = DB::select("select distinct brand_name
                                        from product_info@web_to_sample_msd
                                        where brand_name is not null
                                        order by brand_name");


            return view('dcr_reports_layout/prescription_survey_report')->with(['am_terr'=>$am_terr,'month_name' => $month_name, 'brand_name' => $brand_name]);
        }

        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 6)
                                    select *
                                      from (select trunc(add_months(sysdate, -6)) dt from dual), data
                                     order by dt, l
                                     )");

            $brand_name = DB::select("select distinct brand_name
                                        from product_info@web_to_sample_msd
                                        where brand_name is not null
                                        order by brand_name");
            return view('dcr_reports_layout/prescription_survey_report')->with(['rm_terr'=>$rm_terr,'month_name' => $month_name, 'brand_name' => $brand_name]);

        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 6)
                                    select *
                                      from (select trunc(add_months(sysdate, -6)) dt from dual), data
                                     order by dt, l
                                     )");

            $brand_name = DB::select("select distinct brand_name
                                        from product_info@web_to_sample_msd
                                        where brand_name is not null
                                        order by brand_name");

            return view('dcr_reports_layout/prescription_survey_report')->with(['rm_terr'=>$rm_terr,'month_name' => $month_name, 'brand_name' => $brand_name]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 6)
                                    select *
                                      from (select trunc(add_months(sysdate, -6)) dt from dual), data
                                     order by dt, l
                                     )");

            $brand_name = DB::select("select distinct brand_name
                                        from product_info@web_to_sample_msd
                                        where brand_name is not null
                                        order by brand_name");

            return view('dcr_reports_layout/prescription_survey_report')->with(['rm_terr'=>$rm_terr,'month_name' => $month_name, 'brand_name' => $brand_name]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )
                                order by rm_terr_id");

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 6)
                                    select *
                                      from (select trunc(add_months(sysdate, -6)) dt from dual), data
                                     order by dt, l
                                     )");

            $brand_name = DB::select("select distinct brand_name
                                        from product_info@web_to_sample_msd
                                        where brand_name is not null
                                        order by brand_name");

            return view('dcr_reports_layout/prescription_survey_report')->with(['rm_terr'=>$rm_terr,'month_name' => $month_name, 'brand_name' => $brand_name]);
        }

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {

            $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 6)
                                    select *
                                      from (select trunc(add_months(sysdate, -6)) dt from dual), data
                                     order by dt, l
                                     )");

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            $brand_name = DB::select("select distinct brand_name
                                        from product_info@web_to_sample_msd
                                        where brand_name is not null
                                        order by brand_name");

            return view('dcr_reports_layout/prescription_survey_report')->with(['rm_terr' => $rm_terr, 'month_name' => $month_name, 'brand_name' => $brand_name]);
        }

    }


//     Region wise MPO territory list

    public function regwMpoTerrList(Request $request)
    {
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


//    region wise AM territory

    public function regWTerrAmList(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        if ($request->ajax()) {
            if (Auth::user()->desig === 'GM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

            if (Auth::user()->desig === 'NSM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

            if (Auth::user()->desig === 'SM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

            if (Auth::user()->desig === 'DSM') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }

            if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
                $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");
            }
        }

        return response()->json($resp_data);
    }


//    After submitting

    public function prescripSurveyReport(Request $request)
    {
//        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            $mon = $request->mon;
            $terr = $request->mpoId;

            $resp_data = DB::select(" select
                              report_month ,
                              terr_id ,
                              doctor_id,
                              doctor_name,
                              plan_brand,
                              visit_brand,
                              survey_brand
                                     from
                                       mis.terr_doctor_wise_brand_pvs 
                                     where  report_month= '$request->mon' and terr_id='$request->mpoId'
                                     and
                                     
                                     (
                     plan_brand = decode('$request->br_name','ALL',plan_brand,'$request->br_name') or 
                     visit_brand = decode('$request->br_name','ALL',visit_brand,'$request->br_name') or
                     survey_brand = decode('$request->br_name','ALL',survey_brand,'$request->br_name')
                     )
                                     
                                     
           
                                     ");




            //var_dump($resp_data);
            return response()->json($resp_data);
//            return response()->json('f',$resp_data);
//            return response()->json($request->all());
        }

    }


}


