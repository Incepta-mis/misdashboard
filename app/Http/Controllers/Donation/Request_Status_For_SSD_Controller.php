<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 07-Dec-19
 * Time: 12:28 PM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

//Request $request

class Request_Status_For_SSD_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;


        $month_name = DB::select("  select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 12)
                                    select *
                                      from (select trunc(add_months(sysdate, -11)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");




        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            $don_type = DB::select("select type_name
                                from mis.donation_type_master order by type_name");


            return view('donation.request_status_for_ssd')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr,'don_type'=>$don_type]);

        }


    }


    public function brandRegion_be(Request $request)
    {
        $uid = Auth::user()->user_id;

        if($request->don_type == 'ALL') {
            $brand = DB::select("
                                     select sub_cost_center_id,sub_cost_center_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where budget_type = 'DONATION'
and dcc.cost_center_id = dscc.cost_center_id
order by  sub_cost_center_name");
        }
        else if ($request->don_type == 'BRAND RESEARCH'){
            $brand = DB::select("
                                     select sub_cost_center_id,sub_cost_center_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where  budget_type = 'DONATION'
and dcc.cost_center_id = dscc.cost_center_id
and sub_cost_center_type = 'BRAND'  
order by  sub_cost_center_name");
        }

        else if ($request->don_type == 'REGION DEVELOPMENT'){
            $brand = DB::select("
                                     select sub_cost_center_id,sub_cost_center_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where budget_type = 'DONATION'
and dcc.cost_center_id = dscc.cost_center_id
and sub_cost_center_type = 'REGION'
order by  sub_cost_center_name");
        }

        return response()->json($brand);
    }

    public function brandRegion()
    {
        $brand = DB::select("select sub_cost_center_id,sub_cost_center_name from mis.donation_sub_cost_center  order by sub_cost_center_name asc");

        return response()->json($brand);
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

// region wise MPO territory
    public function regwMpoTerrList(Request $request)
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

    public function requisition_data_ssd(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {

            if (Auth::user()->desig === 'HO') {

                $resp_data = DB::select("
                
                            select *
                            from
                            (
                            select approved_amount approved,'ALL' all_data,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,dd.* , summ_id , ref_no
                            from mis.donation_req_correction dd, mis.donation_expense_budget deb 
                            where dd.req_id = deb.req_id(+) 
                            and  dd.payment_month = '$request->mont'  
                
                            )where '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else rm_terr_id end
                            and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                            and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                            and '$request->don_type'  = case when '$request->don_type' = 'ALL' then all_data else donation_type end   --- new addition
                            and '$request->br_name' = case when '$request->br_name' = 'ALL' then all_data else to_char(sub_cost_center_id) end
                            order by substr(terr_id,1,instr(terr_id,'-'))||'00',trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
                            to_number(substr(terr_id,instr(terr_id,'-', -1)+1))
        "
                );




            }


            return response()->json(['resp_data' => $resp_data]);

//            return response()->json($resp_data);
        }
    }



}