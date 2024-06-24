<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 1/26/2020
 * Time: 1:10 PM
 */

namespace App\Http\Controllers\Dmr;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class Medicine_Requisition_Verification_Controller extends Controller
{

    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;


        $month_name = DB::select("  select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        // echo $uid;

        if (Auth::user()->desig === 'AM' ||Auth::user()->desig === 'Sr. AM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);


        return view('dmr.medicine_requisition_verification')->with(['month_name' => $month_name,  'rm_terr' => $rm_terr,'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);


        }


        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");


            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('dmr.medicine_requisition_verification')->with(['month_name' => $month_name,  'rm_terr' => $rm_terr,'am_terr' => $am_terr]);


        }

        if (Auth::user()->desig === 'GM') {

            $rm_terr = DB::select("
                            select rm_terr_id
                            from mis.rm_gm_info
                            order by rm_terr_id
                                ");

            return view('dmr.medicine_requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);

        }



        if (Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            return view('dmr.medicine_requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);
        }

        if (Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('dmr.medicine_requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);
        }



    }

    public function fetch_am_dmr(Request $request)
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
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ('$uid') )  
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

    public function fetch_mpo_dmr(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            if ($request->amTerr == 'ALL') {

                $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.emp_month = trunc(sysdate,'MM')                                    
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");


            } else {


                $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.am_terr_id =    '$request->amTerr'
                                    and tl.emp_month = trunc(sysdate,'MM')                                    
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            }


            return response()->json($resp_data);
        }
    }

    public function gl_cc (Request $request) {


            $uid = Auth::user()->user_id;

//            $gl = DB::select("
//            select distinct gl
//            from
//            (
//            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
//            when p_group in ('ASTER','GYRUS') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
//            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group
//            from hrtms.hr_terr_list@web_to_hrtms
//            where to_char(emp_month,'MON-RR') = '$request->mon'
//            and  am_emp_id  = '$uid'
//            union all
//
//            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
//            when p_group in ('ASTER','GYRUS') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
//            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group
//            from hrtms.hr_terr_list@web_to_hrtms
//            where to_char(emp_month,'MON-RR') = '$request->mon'
//            and case when asm_emp_id is null then rm_emp_id else asm_emp_id end = '$uid'
//            union all
//            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
//            when p_group in ('ASTER','GYRUS') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
//            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group
//            from hrtms.hr_terr_list@web_to_hrtms
//            where to_char(emp_month,'MON-RR') = '$request->mon'
//            and case when dsm_emp_id is null then sm_emp_id else dsm_emp_id end = '$uid'
//            union all
//            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
//            when p_group in ('ASTER','GYRUS') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
//            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group
//            from hrtms.hr_terr_list@web_to_hrtms
//            where to_char(emp_month,'MON-RR') = '$request->mon'
//            and gm_emp_id = '$uid'
//            union all
//            select cost_center_group from mis.DONATION_COST_CENTER
//            where budget_type = 'MEDICINE'
//            and responsible_emp_id = '$uid') aeg,(select gl,cost_center_id,cost_center_group from mis.DONATION_COST_CENTER
//            where budget_type = 'MEDICINE') ccg
//            where aeg.p_group = ccg.cost_center_group
//      ");

        $gl = DB::select("         
         
           select distinct gl from mis.DONATION_COST_CENTER
          where budget_type = 'MEDICINE'
           
      ");

            $cc = DB::select("
            select distinct cost_center_id,cost_center_group
            from
            (
            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
            when p_group in ('ASTER','GYRUS','LUCENT') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group 
            from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->mon'
            and  am_emp_id  = '$uid'
            union all
            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
            when p_group in ('ASTER','GYRUS','LUCENT') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group 
            from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->mon'
            and case when asm_emp_id is null then rm_emp_id else asm_emp_id end = '$uid'
            union all
            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
            when p_group in ('ASTER','GYRUS','LUCENT') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group 
            from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->mon'
            and case when dsm_emp_id is null then sm_emp_id else dsm_emp_id end = '$uid'
            union all
            select distinct case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
            when p_group in ('ASTER','GYRUS','LUCENT') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
            when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group 
            from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->mon'
            and gm_emp_id = '$uid'
            union all
            select cost_center_group from mis.DONATION_COST_CENTER
            where budget_type = 'MEDICINE'
            and responsible_emp_id = '$uid') aeg,(select gl,cost_center_id,cost_center_group from mis.DONATION_COST_CENTER
            where budget_type = 'MEDICINE') ccg
            where aeg.p_group = ccg.cost_center_group
      ");
            return response()->json(['gl'=>$gl,'cc'=>$cc]);




    }

    public function display_data (Request $request) {


        $uid = Auth::user()->user_id;

        if (Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM') {

            $summary_data = DB::select("

               select req_month,dcc.gl,dcc.cost_center_id,cost_center_name,sum(nvl(tot_req_qty,0)) tot_req_qty,
                round(sum(nvl(tot_req_amt,0))) tot_req_amt,0 total_budget,round(sum(nvl(exp_req_amt,0))) exp_req_amt, 0    available_budget
                from(
                select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,sum(nvl(app_qty,0)) tot_req_qty,sum(nvl(tot_val,0)) tot_req_amt
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont'
                and am_checked_date is null
                and  substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
                group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
                ) dmr,(select substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,sum(nvl(tot_val,0)) exp_req_amt
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont' and am_checked_date is not null
                and  substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1)  = '$request->amTerr' 
                group by substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1)) dmra,
                (select gl,cost_center_id,cost_center_description cost_center_name
                from mis.donation_cost_center where budget_type = 'MEDICINE') dcc 
                where dmr.am_terr_id = dmra.am_terr_id(+)
                and dmr.gl = dcc.gl
                and dmr.cost_center_id = dcc.cost_center_id
                and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(dcc.gl) end     
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(dcc.cost_center_id) end 
                and dmr.rm_terr_id = '$request->rmTerrId'
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                group by req_month,dcc.gl,dcc.cost_center_id,cost_center_name

      ");

            $detail_data = DB::select("

                select req_id,terr_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
                from(
                select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                req_id,terr_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont'
                and  substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1)  = '$request->amTerr'
                and am_checked_date is null
                )where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end     
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end 
                and rm_terr_id = '$request->rmTerrId'
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                order by req_id,p_code

      ");
        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $summary_data = DB::select("

                select req_month,gl,cost_center_id,cost_center_name,sum(nvl(tot_req_qty,0)) tot_req_qty,
                round(sum(nvl(tot_req_amt,0))) tot_req_amt,0 total_budget,round(sum(nvl(exp_req_amt,0))) exp_req_amt,0 available_budget
                from(
                select 'ALL' all_data,req_month,dcc.gl,dcc.cost_center_id,cost_center_name,rm_terr_id,am_terr_id,terr_id,sum(nvl(tot_req_qty,0)) tot_req_qty,
                sum(nvl(tot_req_amt,0)) tot_req_amt,sum(nvl(exp_req_amt,0)) exp_req_amt  
                from( 
                select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,sum(nvl(app_qty,0)) tot_req_qty,sum(nvl(tot_val,0)) tot_req_amt,0 exp_req_amt
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont'
                and rm_checked_date is null and am_checked_date is not null
                group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
                union all
                select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id,
                0 tot_req_qty,0 tot_req_amt,sum(nvl(tot_val,0)) exp_req_amt
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont' and rm_checked_date is not null
                group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
                )dmr,(select gl,cost_center_id,cost_center_description cost_center_name
                from mis.donation_cost_center where budget_type = 'MEDICINE') dcc
                where dmr.gl = dcc.gl
                and dmr.cost_center_id = dcc.cost_center_id
                group by req_month,dcc.gl,dcc.cost_center_id,cost_center_name,rm_terr_id,am_terr_id,terr_id
                )where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end     
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end 
                and rm_terr_id = '$request->rmTerrId'
                and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                group by req_month,gl,cost_center_id,cost_center_name


      ");

            $detail_data = DB::select("

                select req_id,terr_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
                from(
                select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                req_id,terr_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont'
                and rm_checked_date is null and am_checked_date is not null
                )where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end     
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end 
                and rm_terr_id = '$request->rmTerrId'
                and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                order by req_id,p_code

      ");
        }

        if (Auth::user()->desig === 'DSM'||Auth::user()->desig === 'SM') {

            $summary_data = DB::select("
    
            select req_month,gl,cost_center_id,cost_center_name,sum(nvl(tot_req_qty,0)) tot_req_qty,
            round(sum(nvl(tot_req_amt,0))) tot_req_amt,0 total_budget,round(sum(nvl(exp_req_amt,0))) exp_req_amt,0 available_budget
            from(
            select 'ALL' all_data,req_month,dcc.gl,dcc.cost_center_id,cost_center_name,ei.rm_terr_id,am_terr_id,terr_id,sum(nvl(tot_req_qty,0)) tot_req_qty,
            sum(nvl(tot_req_amt,0)) tot_req_amt,sum(nvl(exp_req_amt,0)) exp_req_amt  
            from( 
            select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
            terr_id,sum(nvl(app_qty,0)) tot_req_qty,sum(nvl(tot_val,0)) tot_req_amt,0 exp_req_amt
            from mis.doctor_medicine_req_app
            where req_month = '$request->mont'
            and rm_checked_date is not null
            and dsm_checked_date is null
            group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
            union all
            select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id,
            0 tot_req_qty,0 tot_req_amt,sum(nvl(tot_val,0)) exp_req_amt
            from mis.doctor_medicine_req_app
            where req_month = '$request->mont' and dsm_checked_date is not null
            group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
            )dmr,(select gl,cost_center_id,cost_center_description cost_center_name
            from mis.donation_cost_center where budget_type = 'MEDICINE') dcc,
            (select rm_terr_id from mis.rm_gm_info
            where case when dsm_emp_id is null then sm_emp_id else dsm_emp_id end = '$uid') ei 
            where dmr.gl = dcc.gl
            and dmr.cost_center_id = dcc.cost_center_id
            and dmr.rm_terr_id = ei.rm_terr_id
            group by req_month,dcc.gl,dcc.cost_center_id,cost_center_name,ei.rm_terr_id,am_terr_id,terr_id
            )where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end     
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end 
            and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else rm_terr_id end
            and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
            and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
            group by req_month,gl,cost_center_id,cost_center_name

      ");

            $detail_data = DB::select("

        
            select req_id,terr_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
            from(
            select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
            terr_id,req_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
            from mis.doctor_medicine_req_app
            where req_month = '$request->mont'
            and rm_checked_date is not null
            and dsm_checked_date is null
            )dmr,(select rm_terr_id from mis.rm_gm_info
            where case when dsm_emp_id is null then sm_emp_id else dsm_emp_id end = '$uid') ei
            where dmr.rm_terr_id = ei.rm_terr_id 
            and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end     
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
            and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else ei.rm_terr_id end 
            and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
            and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
            order by req_id,p_code

      ");

        }

        if (Auth::user()->user_id === '1000353'||Auth::user()->user_id === '1000298') {

//            GM sales query
            $summary_data = DB::select("

           
        select req_month,gl,cost_center_id,cost_center_name,sum(nvl(tot_req_qty,0)) tot_req_qty,
        round(sum(nvl(tot_req_amt,0))) tot_req_amt,budget_amt total_budget,round(sum(nvl(exp_req_amt,0))) exp_req_amt,
        budget_amt- round(sum(nvl(exp_req_amt,0))) available_budget
        from(
        select 'ALL' all_data,req_month,dcc.gl,dcc.cost_center_id,cost_center_name,ei.rm_terr_id,am_terr_id,terr_id,sum(nvl(tot_req_qty,0)) tot_req_qty,
        sum(nvl(tot_req_amt,0)) tot_req_amt,sum(nvl(exp_req_amt,0)) exp_req_amt, budget_amt  
        from( 
        select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
        terr_id,sum(nvl(app_qty,0)) tot_req_qty,sum(nvl(tot_val,0)) tot_req_amt,0 exp_req_amt
        from mis.doctor_medicine_req_app
        where req_month = '$request->mont'
        and dsm_checked_date is not null
        and gm_sales_checked_date is null
        group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
        union all
        select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id,
        0 tot_req_qty,0 tot_req_amt,sum(nvl(tot_val,0)) exp_req_amt
        from mis.doctor_medicine_req_app
        where req_month = '$request->mont' and gm_sales_checked_date is not null
        group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
        )dmr,(select expense_month,gl,cost_center_id,cost_center_name,budget_amt
        from mis.medicine_expense where expense_month = '$request->mont') dcc,
        (select rm_terr_id from mis.rm_gm_info
        where case when dsm_emp_id is null then sm_emp_id else gm_emp_id end = '$uid') ei 
        where dmr.gl = dcc.gl(+)
        and dmr.cost_center_id = dcc.cost_center_id(+)
        and dmr.rm_terr_id = ei.rm_terr_id
        group by req_month,dcc.gl,dcc.cost_center_id,cost_center_name,ei.rm_terr_id,am_terr_id,terr_id,budget_amt
        )where '$request->gl'= case when '$request->gl'= 'ALL' then all_data else to_char(gl) end     
        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end 
        and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else rm_terr_id end
        and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
        and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
        group by req_month,gl,cost_center_id,cost_center_name,budget_amt


      ");

            $detail_data = DB::select("

        select req_id,terr_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
        from(
        select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
        terr_id,req_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
        from mis.doctor_medicine_req_app
        where req_month = '$request->mont'
        and dsm_checked_date is not null
        and gm_sales_checked_date is null
        )dmr,(select rm_terr_id from mis.rm_gm_info where gm_emp_id = '$uid') ei 
        where dmr.rm_terr_id = ei.rm_terr_id 
        and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end     
        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
        and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else ei.rm_terr_id end 
        and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
        and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end

      ");

        }

        if (Auth::user()->user_id === '1000001'||Auth::user()->user_id === '1000085'){

            //            GM MSD query
            $summary_data = DB::select("

                select req_month,gl,cost_center_id,cost_center_name,sum(nvl(tot_req_qty,0)) tot_req_qty,
                round(sum(nvl(tot_req_amt,0))) tot_req_amt,budget_amt total_budget,round(sum(nvl(exp_req_amt,0))) exp_req_amt,
                budget_amt- round(sum(nvl(exp_req_amt,0))) available_budget
                from(
                select 'ALL' all_data,req_month,dcc.gl,dcc.cost_center_id,cost_center_name,rm_terr_id,am_terr_id,terr_id,sum(nvl(tot_req_qty,0)) tot_req_qty,
                sum(nvl(tot_req_amt,0)) tot_req_amt,sum(nvl(exp_req_amt,0)) exp_req_amt, budget_amt  
                from( 
                select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,sum(nvl(app_qty,0)) tot_req_qty,sum(nvl(tot_val,0)) tot_req_amt,0 exp_req_amt
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont'
                and gm_sales_checked_date is not null
                and gm_msd_checked_date is null
                group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
                union all
                select req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id,
                0 tot_req_qty,0 tot_req_amt,sum(nvl(tot_val,0)) exp_req_amt
                from mis.doctor_medicine_req_app
                where req_month = '$request->mont' and gm_msd_checked_date is not null
                group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
                )dmr,(select expense_month,gl,cost_center_id,cost_center_name,budget_amt
                from mis.medicine_expense where responsible_emp_id = '$uid'
                and expense_month = '$request->mont') dcc     
                where dmr.gl = dcc.gl(+)
                and dmr.cost_center_id = dcc.cost_center_id(+)
                group by req_month,dcc.gl,dcc.cost_center_id,cost_center_name,rm_terr_id,am_terr_id,terr_id,budget_amt
                )where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end     
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end 
                and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else rm_terr_id end
                and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                group by req_month,gl,cost_center_id,cost_center_name,budget_amt



      ");

            $detail_data = DB::select("

            select req_id,terr_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
            from(
            select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
            terr_id,req_id,doctor_id,doctor_name,p_code,product_name,qty,app_qty,s_p,tot_val
            from mis.doctor_medicine_req_app
            where req_month = '$request->mont'
            and gm_sales_checked_date is not null
            and gm_msd_checked_date is null
            )dmr,(select gl,cost_center_id,cost_center_description cost_center_name
            from mis.DONATION_COST_CENTER where budget_type = 'MEDICINE' and responsible_emp_id = '$uid') dcc
            where dmr.gl = dcc.gl
            and dmr.cost_center_id = dcc.cost_center_id 
            and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(dcc.gl) end     
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(dcc.cost_center_id) end
            and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else dmr.rm_terr_id end 
            and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
            and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end

      ");

        }


        return response()->json(['summary_data'=>$summary_data,'detail_data'=>$detail_data]);




    }

    public function verify_row(Request $request)
    {
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $verinfo = json_decode($request->verifyData);
            //ini_set('max_execution_time', 600);

            if ( Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM') {
                foreach ($verinfo as $data) {

                    DB::UPDATE("
                       update mis.doctor_medicine_req_app
                        set am_emp_id ='$uid',
                        am_name ='$uname',
                        am_checked_date = (select sysdate from dual)
                        where req_id=?
                        and p_code = ?
                    ", [$data->req_id,$data->p_code]);
                }
            }

            if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
                foreach ($verinfo as $data) {

                    DB::UPDATE("
                       update mis.doctor_medicine_req_app
                        set rm_emp_id ='$uid',
                        rm_name ='$uname',
                        rm_checked_date = (select sysdate from dual)
                        where req_id=?
                        and p_code = ?
                    ", [$data->req_id,$data->p_code]);
                }
            }

            if (Auth::user()->desig === 'DSM'||Auth::user()->desig === 'SM') {
                foreach ($verinfo as $data) {

                    DB::UPDATE("
                        update mis.doctor_medicine_req_app
                        set dsm_emp_id='$uid',
                        dsm_name='$uname',
                        dsm_checked_date= (select sysdate from dual)
                        where req_id=?
                        and p_code = ?
                    ", [$data->req_id,$data->p_code] );
                }
            }

            // if (Auth::user()->desig === 'SM' ) {
            //     foreach ($verinfo as $data) {

            //         DB::UPDATE("
            //             update mis.doctor_medicine_req_app
            //             set sm_emp_id='$uid',
            //             sm_name='$uname',
            //             sm_checked_date= (select sysdate from dual)
            //             where req_id=?
            //             and p_code = ?
            //         ", [$data->req_id,$data->p_code]);
            //     }
            // }

//            if (Auth::user()->user_id === '1000353'||Auth::user()->user_id === '1000298'){
////GM Sales verification
//                foreach ($verinfo as $data) {
//
//                    DB::UPDATE("
//                        update mis.doctor_medicine_req_app
//                        set gm_sales_emp_id='$uid',
//                        gm_sales_emp_name='$uname',
//                        gm_sales_checked_date= (select sysdate from dual)
//                        where req_id= ?
//                        and p_code = ?
//                    ", [$data->req_id,$data->p_code]);
//                }
//
//            }

            if (Auth::user()->user_id === '1000353'||Auth::user()->user_id === '1000298'){
//GM Sales verification
//                foreach ($verinfo as $data) {

                    DB::UPDATE("
                        update mis.doctor_medicine_req_app
                        set gm_sales_emp_id='$uid',
                        gm_sales_emp_name='$uname',
                        gm_sales_checked_date= (select sysdate from dual)
                            where req_month = '$request->mont'
                            and dsm_checked_date is not null
                            and gm_sales_checked_date is null
                            and substr(terr_id,1,instr(terr_id,'-'))||'00'  in (select rm_terr_id from mis.rm_gm_info where gm_emp_id = '$uid')
                            
                    ");
//                }

            }



//            if (Auth::user()->user_id === '1000001'||Auth::user()->user_id === '1000085'){
////GM MSD verification
//                foreach ($verinfo as $data) {
//
//                    DB::UPDATE("
//                        update mis.doctor_medicine_req_app
//                         set gm_msd_emp_id='$uid',
//                        gm_msd_emp_name='$uname',
//                        gm_msd_checked_date= (select sysdate from dual)
//                        where req_id=?
//                        and p_code = ?
//                    ", [$data->req_id,$data->p_code]);
//                }
//
//            }


            if (Auth::user()->user_id === '1000001'||Auth::user()->user_id === '1000085'){
//GM MSD verification

                DB::UPDATE("
                         update mis.doctor_medicine_req_app
                        set gm_msd_emp_id='$uid',
                        gm_msd_emp_name='$uname',
                        gm_msd_checked_date= (select sysdate from dual)
                        where req_month = '$request->mont'
                        and gm_sales_checked_date is not null
                        and gm_msd_checked_date is  null
                        and gl||cost_center_id in (select gl||cost_center_id
                    from mis.DONATION_COST_CENTER where budget_type = 'MEDICINE' and responsible_emp_id = '$uid')
                    ");

            }

            return response()->json(['success' => 'Medicine Requisition Approved']);
        }


    }

    public function delete_row(Request $request)
    {
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $verinfo = json_decode($request->verifyData);

                foreach ($verinfo as $data) {

                    $insert_action = DB::INSERT("

                                        insert into mis.doctor_medicine_req_delete
                                        select d.*,'$uid','$uname',(select sysdate from dual)
                                        from mis.doctor_medicine_req_app d
                                        where req_id= ? 
                                        and p_code = ?
                                        ",[$data->req_id,$data->p_code]);


                    DB::UPDATE("
                     delete from mis.doctor_medicine_req_app     
                                        where req_id= ? 
                                        and p_code = ?
                    ", [$data->req_id,$data->p_code]);
                }






            return response()->json(['success' => 'Medicine Requisition Deleted']);
        }


    }

    public function update_row(Request $request)
    {

        $update_action = DB::update("            
       
        update mis.doctor_medicine_req_app set 
        app_qty ='$request->approved_quant',
        tot_val='$request->total_value'
                           
        where req_id = '$request->req_no'   
        and p_code =  '$request->prod_code'
                ");

        return response()->json($update_action);


    }



}