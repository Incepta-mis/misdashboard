<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 3/15/2020
 * Time: 11:18 AM
 */

namespace App\Http\Controllers\Dmr;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

//Request $request

class Ssd_Process_Dmr_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $month_name = DB::select("  select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

            $gl = DB::select("
                select DISTINCT gl from mis.DONATION_COST_CENTER
                where budget_type = 'MEDICINE'
                              ");

            $cc = DB::select("
               select distinct gl,
            cost_center_id,cost_center_group from mis.DONATION_COST_CENTER
            where budget_type = 'MEDICINE' 

                              ");

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");



            return view('dmr.ssd_process_medicine')->with(['month_name' => $month_name, 'gl' => $gl, 'cc' => $cc, 'rm_terr' => $rm_terr]);

        }


    }

    public function am_fetch_ssd(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");

        }

        return response()->json($resp_data);
    }

    public function mpo_fetch_ssd(Request $request)
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

    public function ssd_dmr_data(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());

            $resp_data = DB::select("
             
            select req_month,dcc.gl,dcc.cost_center_id,cost_center_name,sum(nvl(tot_req_qty,0)) tot_req_qty,
            round(sum(nvl(tot_req_amt,0))) tot_req_amt,nvl(budget_amt,0) total_budget,
            nvl(exp_amt,0) exp_amt, nvl(available_budget,0) available_amt
     from(
        select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
        terr_id,sum(nvl(app_qty,0)) tot_req_qty,sum(nvl(app_qty,0) * nvl(cogm,0)) tot_req_amt
 from mis.doctor_medicine_req_app dmr,mis.doctor_medicine_cogm dmc
 where req_month = '$request->mon'
 and dmr.req_month = dmc.cogm_month
 and dmr.p_code = dmc.p_code
 and gm_msd_checked_date is not null
 and ssd_checked_date is null
 group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',
 substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id
     ) dmr,(select expense_month,gl,cost_center_id,cost_center_name,budget_amt,cogm_amt exp_amt,round(nvl(budget_amt,0)- nvl(cogm_amt,0)) available_budget 
            from mis.medicine_expense where expense_month = '$request->mon') dcc         
             
            where dmr.gl = dcc.gl
            and dmr.cost_center_id = dcc.cost_center_id
            and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(dcc.gl) end     
            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(dcc.cost_center_id) end
            and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else dmr.rm_terr_id end
            and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
            and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
            group by req_month,dcc.gl,dcc.cost_center_id,cost_center_name,budget_amt,exp_amt,available_budget



 ");

            return response()->json($resp_data);

        }
    }
    

    public function verify_ssd(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $verinfo = json_decode($request->verifyData);



            if (Auth::user()->desig === 'HO') {

                DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
                if ($request->ajax()) {

                    try {

    $result = DB::executeProcedure('mis.pro_doc_medicine_req_process', [ 'dmr_month' => $request->mon,'gl_data' => $request->gl, 'cc_data' => $request->cc,
        'rm_data' => $request->rmTerrId, 'am_data' => $request->amTerr, 'mpo_data' => $request->mpoId,'log_emp_id' => $uid ,'log_emp_name' => $uname]);

                    } catch (Oci8Exception $e) {
                        $result = $e->getMessage();
                    }
                    return response()->json($result);


                }

            }


//            return response()->json(['success' => 'Research Expense verified Successfully.']);
        }


    }

    public function rm_dsm_pending_view(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");


        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");



        return view('dmr.rm_dsm_pending')->with(['month_name' => $month_name]);

    }

    public function rm_dsm_pending_data(Request $request)
    {

//        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        $uid = Auth::user()->user_id;

        $rm = DB::Select("
            
                    select SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' RM_TERR_ID,count(*) total
                    from mis.doctor_medicine_req_app 
                    where req_month = '$request->month'
                    and am_checked_date is not null
                    and rm_checked_date is null
                    group by SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00'
    
                                    ");

        $dsm = DB::Select("
            
                        select SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' RM_TERR_ID,count(*) total
                        from mis.doctor_medicine_req_app 
                        where req_month = '$request->month'
                        and rm_checked_date is not null
                        and dsm_checked_date is null
                        group by SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00'
    
                                    ");



        return response()->json(['rm'=>$rm,'dsm'=> $dsm]);
    }

 
    

}