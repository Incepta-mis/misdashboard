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

class Rm_Wise_Report_Controller extends Controller
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

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $gl = DB::select("
                select DISTINCT gl from mis.DONATION_COST_CENTER
                where budget_type = 'MEDICINE'
                              ");

            $cc = DB::select("
               select distinct gl
            cost_center_id,cost_center_group from mis.DONATION_COST_CENTER
            where budget_type = 'MEDICINE' 

                              ");

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");



            return view('dmr.rm_wise_report')->with(['month_name' => $month_name, 'gl' => $gl, 'cc' => $cc, 'rm_terr' => $rm_terr]);

        }

        // echo $uid;

        if (Auth::user()->desig === 'RM' ) {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and RM_EMP_ID ||ASM_EMP_ID in ('$uid') ");


            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('dmr.rm_wise_report')->with(['month_name' => $month_name,  'rm_terr' => $rm_terr,'am_terr' => $am_terr]);


        }

        if ( Auth::user()->desig === 'ASM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and RM_EMP_ID ||ASM_EMP_ID in ('$uid') ");


            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('dmr.rm_wise_report')->with(['month_name' => $month_name,  'rm_terr' => $rm_terr,'am_terr' => $am_terr]);


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

            return view('dmr.rm_wise_report')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);
        }

        if (Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('dmr.rm_wise_report')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);
        }



    }

    public function rm_depot (Request $request)
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");


            $resp_data = DB::select("
             
                    select distinct d_id from 
                    hrtms.hr_terr_list@web_to_hrtms
                    where
                    to_date(emp_month,'DD-MON-RR') = to_date('$request->mon','MON-RR')
                    and 
                    RM_TERR_ID = '$request->rmTerr'
                    order by 
                    d_id

 ");

            return response()->json($resp_data);

    }

    public function rm_wise_data(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());

            $resp_data = DB::select("
             
            select req_month,d_id,rm_terr_id,rm_name,region_name,cost_center_name,'$request->amTerr','$request->mpoId',
            p_code,product_name,pack_size,sum(nvl(total_qty,0)) total_qty,unit_price,round(sum(nvl(total_value,0))) total_value       
            from(
            select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
            rm_name,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,d_id,
            terr_id,p_code,product_name,pack_size,sum(nvl(app_qty,0)) total_qty,s_p unit_price,sum(nvl(tot_val,0)) total_value
            from mis.doctor_medicine_req_app
            where req_month = '$request->mon' 
            and ssd_checked_date is not null
            group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',rm_name,
            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id,d_id,
            p_code,product_name,pack_size,s_p order by product_name
            ) dmr,(select gl,cost_center_id,cost_center_description cost_center_name
            from DONATION_COST_CENTER where  budget_type = 'MEDICINE')dcc,(select region_id,region_name from msfa.region_info@web_to_imsfa) ri        
            where dmr.gl = dcc.gl
            and dmr.cost_center_id = dcc.cost_center_id
            and dmr.rm_terr_id = ri.region_id
            and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else dmr.rm_terr_id end
            and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
            and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
            and '$request->depot' = case when '$request->depot' = 'ALL' then all_data else to_char(d_id) end
            group by req_month,rm_terr_id,rm_name,region_name,cost_center_name,p_code,product_name,pack_size,unit_price,d_id
            order by d_id

 ");

            return response()->json($resp_data);

        }
    }

    public function rm_wise_report_pdf(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        if ($request->ajax()) {
//            return response()->json($request->all());

            $resp_data = DB::select("
                select d_id,req_month,rm_terr_id,rm_name,region_name,cost_center_name,'$request->am_terr' am ,'$request->mpo_terr' mpo,p_code,product_name,pack_size,total_qty,
                unit_price,total_value,rank () over ( partition by  rm_terr_id order by product_name,d_id) as sl 
                from(
                select req_month,rm_terr_id,rm_name,region_name,cost_center_name,d_id,
                p_code,product_name,pack_size,sum(nvl(total_qty,0)) total_qty,unit_price,round(sum(nvl(total_value,0))) total_value       
                from(
                select 'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,d_id,
                rm_name,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,p_code,product_name,pack_size,sum(nvl(app_qty,0)) total_qty,s_p unit_price,sum(nvl(tot_val,0)) total_value
                from mis.doctor_medicine_req_app
                where req_month = '$request->bgt_month'
                and ssd_checked_date is not null
                group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',rm_name,d_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id,
                p_code,product_name,pack_size,s_p order by product_name
                ) dmr,(select gl,cost_center_id,cost_center_description cost_center_name
                from DONATION_COST_CENTER where  budget_type = 'MEDICINE')dcc,(select region_id,region_name from msfa.region_info@web_to_imsfa) ri        
                where dmr.gl = dcc.gl
                and dmr.cost_center_id = dcc.cost_center_id
                and dmr.rm_terr_id = ri.region_id
                and '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else dmr.rm_terr_id end
                and '$request->am_terr' = case when '$request->am_terr' = 'ALL' then all_data else am_terr_id end
                and '$request->mpo_terr' = case when '$request->mpo_terr' = 'ALL' then all_data else terr_id end
                and '$request->depot' = case when '$request->depot' = 'ALL' then all_data else to_char(d_id) end
                group by req_month,rm_terr_id,rm_name,region_name,cost_center_name,p_code,product_name,pack_size,unit_price,d_id
                
)

 ");

        $rm_terr = DB::select("
             
        select distinct rm_terr_id,rm_name,region_name,cost_center_name      
        from(
        select   'ALL' all_data,req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
        rn.rm_name,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
        terr_id,p_code,product_name,pack_size,sum(nvl(app_qty,0)) total_qty,s_p unit_price,sum(nvl(tot_val,0)) total_value
        from mis.doctor_medicine_req_app,(select distinct rm_terr_id,case when rm_emp_id is null then asm_name else rm_name end rm_name
        from hrtms.hr_terr_list@web_to_hrtms where to_char(emp_month,'MON-RR')= '$request->bgt_month') rn
        where req_month = '$request->bgt_month' 
        and ssd_checked_date is not null
        and substr(terr_id,1,instr(terr_id,'-'))||'00' = rn.rm_terr_id
        group by req_month,gl,cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',rn.rm_name,
        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),terr_id,
        p_code,product_name,pack_size,s_p order by product_name
        
        ) dmr,(select gl,cost_center_id,cost_center_description cost_center_name
        from DONATION_COST_CENTER where  budget_type = 'MEDICINE')dcc,(select region_id,region_name from msfa.region_info@web_to_imsfa) ri        
        where dmr.gl = dcc.gl
        and dmr.cost_center_id = dcc.cost_center_id
        and dmr.rm_terr_id = ri.region_id
        and '$request->rm_terr' = case when '$request->rm_terr' = 'ALL' then all_data else dmr.rm_terr_id end
        and '$request->am_terr' = case when '$request->am_terr' = 'ALL' then all_data else am_terr_id end
        and '$request->mpo_terr' = case when '$request->mpo_terr' = 'ALL' then all_data else terr_id end
        order by rm_terr_id
       
 ");

//            dd($rm_terr);

            $pdf = \PDF::loadView('dmr/rm_wise_report_pdf',['rdata' => $resp_data,'rm_terr' =>$rm_terr] );
            return $pdf->stream('rm_wise_report.pdf');

//        }
    }







}