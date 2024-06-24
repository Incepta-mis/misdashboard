<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 18-Dec-18
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

class Requisition_Controller extends Controller
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

        $don_type = DB::select("select type_name
                                from mis.donation_type_master  order by main_cost_center_name desc,type_name");

        // echo $uid;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('donation.requisition_verification')->with(['month_name' => $month_name, 'am_terr' => $am_terr,'don_type'=>$don_type]);
        }

        if (Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            return view('donation.requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);

        }

        if (Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('donation.requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);
        }

        if (Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            return view('donation.requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr,'don_type'=>$don_type]);
        }

        if (Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('donation.requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr,'don_type'=>$don_type]);
        }

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

                $don_type = DB::select("select type_name
                                from mis.donation_type_master where main_cost_center_name = 'MSD' order by type_name");
            $freq = DB::select("select df_description
                    from mis.donation_frequency
                    order by df_id");

            return view('donation.requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr,'don_type'=>$don_type,'freq'=>$freq]);

        }
        if (Auth::user()->desig === 'AM') {

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

            return view('donation.requisition_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr,'don_type'=>$don_type]);


        }

    }


    public function brandRegion_be(Request $request)
    {
        $uid = Auth::user()->user_id;
        $desig = Auth::user()->desig;

        if($desig !='HO'){
            if ($request->don_type == 'BRAND RESEARCH'){
                $brand = DB::select("
            select distinct sub_cost_center_id,sub_cost_center_name
            from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
            where budget_type = 'DONATION' 
            and dcc.cost_center_id = dscc.cost_center_id
            and sub_cost_center_type = 'BRAND'  
            and DEPARTMENT = 'MSD'
            order by  sub_cost_center_name");
            }

            else if ($request->don_type == 'BRAND RESEARCH SALES'){
                $brand = DB::select("
            select distinct sub_cost_center_id,sub_cost_center_name
            from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
            where budget_type = 'DONATION' 
            and dcc.cost_center_id = dscc.cost_center_id
            and sub_cost_center_type = 'BRAND'  
            and DEPARTMENT = 'SALES'
            order by  sub_cost_center_name");
            }

            else if ($request->don_type == 'REGION DEVELOPMENT'){
                $brand = DB::select("
                select distinct sub_cost_center_id,sub_cost_center_name
                from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                where budget_type = 'DONATION' 
                and dcc.cost_center_id = dscc.cost_center_id
                and sub_cost_center_type = 'REGION'  
                and DEPARTMENT = 'SALES'
                order by  sub_cost_center_name");
            }
        }
else{
    if($request->don_type == 'ALL') {
        $brand = DB::select("
                                     select distinct sub_cost_center_id,sub_cost_center_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where budget_type = 'DONATION' 
and dcc.cost_center_id = dscc.cost_center_id
and be_emp_id = '$uid' order by  sub_cost_center_name");
    }
    else if ($request->don_type == 'BRAND RESEARCH'){
        $brand = DB::select("
                                     select distinct sub_cost_center_id,sub_cost_center_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where budget_type = 'DONATION' 
and dcc.cost_center_id = dscc.cost_center_id
and be_emp_id = '$uid' and sub_cost_center_type = 'BRAND'  
order by  sub_cost_center_name");
    }

    else if ($request->don_type == 'REGION DEVELOPMENT'){
        $brand = DB::select("
                                     select distinct sub_cost_center_id,sub_cost_center_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where budget_type = 'DONATION' 
and dcc.cost_center_id = dscc.cost_center_id
and be_emp_id = '$uid' and sub_cost_center_type = 'REGION'
order by  sub_cost_center_name");
    }
}


        return response()->json($brand);
    }

    public function brandRegion(Request $request)
    {
        if($request->team =='MSD'){
            $brand = DB::select("select sub_cost_center_id,sub_cost_center_name from mis.donation_sub_cost_center where cost_center_id != '1000101204'  order by sub_cost_center_name asc");
        }
        else if ($request->team ==  'SALES'){
            $brand = DB::select("select sub_cost_center_id,sub_cost_center_name from mis.donation_sub_cost_center where cost_center_id = '1000101204'  
                        order by sub_cost_center_name asc");
        }

        return response()->json($brand);
    }

    //    region wise AM territory

    public function regWTerrAmList(Request $request)
    {

           // return response()->json("hello world");

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

    public function requisition_data(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {

            if (Auth::user()->desig === 'AM') {

                $resp_data = DB::select("
                            select *
                            from
                            (
                            select decode(approved_amount,null,proposed_amount,approved_amount)approved,'ALL' mpo_all,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                            dd.*,dtm.main_cost_center_name,dlp.*
                            from mis.donation_req_correction dd,mis.donation_type_master dtm,(select doctor_id ld,approved_amount lam,frequency lf,payment_month lp
                            from( select doctor_id,frequency,approved_amount,to_date(payment_month,'MON-RR') payment_month,
                            row_number() over (partition by doctor_id order by payment_month desc) dd
                            from mis.donation_expense_budget deb,mis.donation_req_correction dd
                            where fi_process is not null 
                            and deb.req_id = dd.req_id)where dd = 1) dlp
                            where dd.donation_type = dtm.type_name
                            and dd.payment_month = '$request->mont'
                            and dd.doctor_id = dlp.ld(+)
                            and am_checked_date is null  and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rmTerrId'
                            and substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
                            
                            )where '$request->mpoId' = case when '$request->mpoId' = 'ALL' then mpo_all else terr_id end
                            and '$request->team' = case when '$request->team' = 'ALL' then mpo_all else main_cost_center_name end
                            and '$request->don_type'  = case when '$request->don_type' = 'ALL' then mpo_all else donation_type end 
                            and '$request->br_name' = case when '$request->br_name' = 'ALL' then mpo_all else to_char(sub_cost_center_id) end
                            order by terr_id,req_id
                            
                            "
                );


                $balance = DB::select("
                
                select sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                sum(nvl(cheque_pend_amt,0)) cheque_pend_amt,sum(nvl(cash_pend_amt,0)) cash_pend_amt
                from
                (select 'ALL' all_data,rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                sum(nvl(cheque_pend_amount,0)) cheque_pend_amt,sum(nvl(cash_pend_amount,0)) cash_pend_amt,donation_type
                from(
                select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_app_amt,
                sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_app_amt,0 cheque_pend_amount,0 cash_pend_amount,donation_type
                from mis.donation_req_correction drc,mis.donation_type_master dtm
                where drc.donation_type = dtm.type_name
                and payment_month = '$request->mont'
                and substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
                and am_checked_date is not null
                group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                union all
                select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,0 cheque_app_amt,0 cash_app_amt,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_pend_amount,
                sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_pend_amount,donation_type
                from mis.donation_req_correction drc,mis.donation_type_master dtm
                where drc.donation_type = dtm.type_name
                and payment_month = '$request->mont'
                and am_checked_date is null
                and substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->amTerr'
                group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                )group by rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,donation_type)
                where '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                and '$request->team' = case when '$request->team' = 'ALL' then all_data else main_cost_center_name end
                and '$request->don_type'  = case when '$request->don_type' = 'ALL' then all_data else donation_type end
                and '$request->br_name' = case when '$request->br_name' = 'ALL' then all_data else to_char(sub_cost_center_id) end



                
                ");

            }
            if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
                $resp_data = DB::select("

            select *
            from
            (
                select decode(approved_amount,null,proposed_amount,approved_amount)approved,'ALL' mpo_all,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                dd.*,dtm.main_cost_center_name,dlp.*
                from mis.donation_req_correction dd,mis.donation_type_master dtm,(select doctor_id ld,approved_amount lam,
                frequency lf,payment_month lp
                from( select doctor_id,frequency,approved_amount,to_date(payment_month,'MON-RR') payment_month,
                row_number() over (partition by doctor_id order by to_date(payment_month,'MON-RR') desc) dd
                from mis.donation_expense_budget deb,mis.donation_req_correction dd
                where fi_process is not null 
                and deb.req_id = dd.req_id)where dd = 1) dlp
                where dd.donation_type = dtm.type_name
                and dd.payment_month = '$request->mont'
                and dd.doctor_id = dlp.ld(+)
                and rm_checked_date is null and am_checked_date is not null
                and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rmTerrId' )
                where '$request->amTerr' = case when '$request->amTerr' = 'ALL' then mpo_all else am_terr_id end
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then mpo_all else terr_id end
                and '$request->team' = case when '$request->team' = 'ALL' then mpo_all else main_cost_center_name end
                and '$request->don_type'  = case when '$request->don_type' = 'ALL' then mpo_all else donation_type end  
                and '$request->br_name' = case when '$request->br_name' = 'ALL' then mpo_all else to_char(sub_cost_center_id) end
                order by terr_id,req_id
                "
                );

                $balance = DB::select("
                
                                           
                    select sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                    sum(nvl(cheque_pend_amt,0)) cheque_pend_amt,sum(nvl(cash_pend_amt,0)) cash_pend_amt
                    from
                    (select 'ALL' all_data,rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                    sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                    sum(nvl(cheque_pend_amount,0)) cheque_pend_amt,sum(nvl(cash_pend_amount,0)) cash_pend_amt,donation_type
                    from(
                    select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    terr_id,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_app_amt,
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_app_amt,0 cheque_pend_amount,0 cash_pend_amount,donation_type
                    from mis.donation_req_correction drc,mis.donation_type_master dtm
                    where drc.donation_type = dtm.type_name
                    and payment_month = '$request->mont'
                    and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rmTerrId'
                    and rm_checked_date is not null
                    group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                    union all
                    select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    terr_id,0 cheque_app_amt,0 cash_app_amt,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_pend_amount,
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_pend_amount,donation_type
                    from mis.donation_req_correction drc,mis.donation_type_master dtm
                    where drc.donation_type = dtm.type_name
                    and payment_month = '$request->mont'
                    and rm_checked_date is null and am_checked_date is not null
                    and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rmTerrId'
                    group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                    )group by rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,donation_type)
                    where '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                    and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                    and '$request->team' = case when '$request->team' = 'ALL' then all_data else main_cost_center_name end
                    and '$request->don_type'  = case when '$request->don_type' = 'ALL' then all_data else donation_type end
                    and '$request->br_name' = case when '$request->br_name' = 'ALL' then all_data else to_char(sub_cost_center_id) end
 

                
                ");



            }

            if (Auth::user()->desig === 'HO') {

                $resp_data = DB::select("
                
                            select *
                            from
                            (select approved_amount approved,'ALL' all_data,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,dd.*,dlp.*
                            from mis.donation_req_correction dd,(select distinct dcc.cost_center_id,sub_cost_center_id
                            from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                            where budget_type = 'DONATION'
                            and dcc.cost_center_id = dscc.cost_center_id
                            and be_emp_id = '$uid') ecc,
                            (select lp,ld,lf,lgb,lam
                            from(select payment_month lp,doctor_id ld,frequency lf,group_brand_region_name lgb,lam,dd
                            from(select payment_month,doctor_id,frequency,group_brand_region_name,lam,
                                   row_number() over (partition by doctor_id,group_brand_region_name order by payment_month desc) dd
                            from
                            (select to_date(payment_month,'MON-RR') payment_month,doctor_id,frequency,group_brand_region_name,sum(nvl(approved_amount,0)) lam
                            from mis.donation_expense_budget deb,mis.donation_req_correction dd
                            where deb.req_id = dd.req_id
                            and donation_type in ('BRAND RESEARCH','REGION DEVELOPMENT')
                            and frequency not in ('OCCASIONAL','ONE TIME')
                            group by payment_month,doctor_id,frequency,group_brand_region_name ))where dd = 1)) dlp        
                            where dd.payment_month = '$request->mont'  
                            and dd.cost_center_id||dd.sub_cost_center_id = ecc.cost_center_id||ecc.sub_cost_center_id
                            and dd.doctor_id = dlp.ld(+)
                            and dd.group_brand_region_name = dlp.lgb(+) 
                            and rm_checked_date is not null and be_checked_date is null
                            )where '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else rm_terr_id end
                            and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                            and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                            and '$request->don_type'  = case when '$request->don_type' = 'ALL' then all_data else donation_type end   --- new addition
                            and '$request->br_name' = case when '$request->br_name' = 'ALL' then all_data else to_char(sub_cost_center_id) end
                            and '$request->frequency' = case when '$request->frequency' = 'ALL' then all_data else frequency end
                            order by substr(terr_id,1,instr(terr_id,'-'))||'00',trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
                            to_number(substr(terr_id,instr(terr_id,'-', -1)+1)),req_id
        "
                );


                $balance = DB::select("
                
                select sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                sum(nvl(cheque_pend_amt,0)) cheque_pend_amt,sum(nvl(cash_pend_amt,0)) cash_pend_amt
                from
                (select 'ALL' all_data,rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,donation_type,frequency,
                sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                sum(nvl(cheque_pend_amount,0)) cheque_pend_amt,sum(nvl(cash_pend_amount,0)) cash_pend_amt
                from
                (select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,drc.sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,donation_type,frequency,
                terr_id,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_app_amt,
                sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_app_amt,0 cheque_pend_amount,0 cash_pend_amount
                from mis.donation_req_correction drc,mis.donation_type_master dtm,(select distinct dcc.cost_center_id,sub_cost_center_id
                from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                where budget_type = 'DONATION' 
                and dcc.cost_center_id = dscc.cost_center_id
                and be_emp_id = '$uid') ecc
                where drc.donation_type = dtm.type_name
                and payment_month = '$request->mont'
                and main_cost_center_name = 'MSD'
                and be_checked_date is not null
                and rm_checked_date is not null
                and drc.cost_center_id||drc.sub_cost_center_id = ecc.cost_center_id||ecc.sub_cost_center_id
                group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,drc.sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type,frequency
                union all
                select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,drc.sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,donation_type,frequency,
                terr_id,0 cheque_app_amt,0 cash_app_amt,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_pend_amount,
                sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_pend_amount
                from mis.donation_req_correction drc,mis.donation_type_master dtm,(select distinct dcc.cost_center_id,sub_cost_center_id
                from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                where budget_type = 'DONATION' 
                and dcc.cost_center_id = dscc.cost_center_id
                and be_emp_id = '$uid') ecc
                where drc.donation_type = dtm.type_name
                and payment_month = '$request->mont'
                and main_cost_center_name = 'MSD'
                and be_checked_date is null
                and rm_checked_date is not null
                and drc.cost_center_id||drc.sub_cost_center_id = ecc.cost_center_id||ecc.sub_cost_center_id
                group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,drc.sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type,frequency
                )group by rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,donation_type,frequency
                )where '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else rm_terr_id end
                and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                and '$request->don_type' = case when '$request->don_type' = 'ALL' then all_data else donation_type end
                and '$request->br_name' = case when '$request->br_name' = 'ALL' then all_data else to_char(sub_cost_center_id) end
                and '$request->frequency' = case when '$request->frequency' = 'ALL' then all_data else frequency end


                ");


            }

            if (Auth::user()->desig === 'DSM') {

                $resp_data = DB::select("
           
                    select terr_id,doctor_id,doctor_name,proposed_amount,approved,payment_mode,in_favour_of,frequency,payment_month,
                    lam,lf,lp,speciality,req_id,address,beneficiary_type,purpose,no_of_patient,contact_no,req_date,in_favour_of_main,group_brand_region_name,
                    commitment,donation_type,dsm_checked_date,sub_cost_center_id
                    
                    from
                    (       
                    select mpo_all,terr_id,doctor_id,doctor_name,proposed_amount,approved,payment_mode,in_favour_of,frequency,payment_month,
                    lam,lf,lp,speciality,req_id,address,beneficiary_type,purpose,no_of_patient,contact_no,req_date,in_favour_of_main,
                    group_brand_region_name,rd.rm_terr_id,am_terr_id,main_cost_center_name,commitment,donation_type,dsm_checked_date,sub_cost_center_id
                    from
                    (select decode(approved_amount,null,proposed_amount,approved_amount)approved,
                    'ALL' mpo_all,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    dd.*,dtm.main_cost_center_name,dlp.* 
                    from mis.donation_req_correction dd,mis.donation_type_master dtm,(select doctor_id ld,approved_amount lam,
                    frequency lf,payment_month lp
                    from( select doctor_id,frequency,approved_amount,to_date(payment_month,'MON-RR') payment_month,
                    row_number() over (partition by doctor_id order by to_date(payment_month,'MON-RR') desc) dd
                    from mis.donation_expense_budget deb,mis.donation_req_correction dd
                    where fi_process is not null 
                    and deb.req_id = dd.req_id)where dd = 1) dlp
                    where dd.donation_type = dtm.type_name
                    and dd.payment_month = '$request->mont'
                    and dd.doctor_id = dlp.ld(+)
                    and rm_checked_date is not null
                    and main_cost_center_name = 'MSD' and be_checked_date is not null and dsm_checked_date is null 
                    and group_head_checked_date is null
                    union all
                    select decode(approved_amount,null,proposed_amount,approved_amount)approved,
                    'ALL' mpo_all,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    dd.*,dtm.main_cost_center_name,dlp.*  
                    from mis.donation_req_correction dd,mis.donation_type_master dtm,(select doctor_id ld,approved_amount lam,
                    frequency lf,payment_month lp
                    from( select doctor_id,frequency,approved_amount,to_date(payment_month,'MON-RR') payment_month,
                    row_number() over (partition by doctor_id order by to_date(payment_month,'MON-RR') desc) dd
                    from mis.donation_expense_budget deb,mis.donation_req_correction dd
                    where fi_process is not null 
                    and deb.req_id = dd.req_id)where dd = 1) dlp
                    where dd.donation_type = dtm.type_name
                    and dd.payment_month = '$request->mont'
                    and dd.doctor_id = dlp.ld(+)
                    and rm_checked_date is not null
                    and main_cost_center_name <> 'MSD' and dsm_checked_date is null
                    and gm_sales_checked_date is null
                    ) rd,(select distinct 'ALL' rm_all,rm_terr_id rm_terr_id
                    from hrtms.hr_terr_list@web_to_hrtms
                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) ) ) rtd
                    where rd.rm_terr_id = rtd.rm_terr_id   
                    )where '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then mpo_all else rm_terr_id end
                    and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then mpo_all else am_terr_id end
                    and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then mpo_all else terr_id end
                    and '$request->team' = case when '$request->team' = 'ALL' then mpo_all else main_cost_center_name end
                    and '$request->don_type'  = case when '$request->don_type' = 'ALL' then mpo_all else donation_type end   
                    and '$request->br_name' = case when '$request->br_name' = 'ALL' then mpo_all else to_char(sub_cost_center_id) end
                    order by terr_id,req_id  
 "
                );


                $balance = DB::select("                           
                                    
                  select sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                sum(nvl(cheque_pend_amt,0)) cheque_pend_amt,sum(nvl(cash_pend_amt,0)) cash_pend_amt
                from
                (select 'ALL' all_data,rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                sum(nvl(cheque_pend_amount,0)) cheque_pend_amt,sum(nvl(cash_pend_amount,0)) cash_pend_amt,donation_type
                from
                (
                select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_app_amt,
                sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_app_amt,0 cheque_pend_amount,0 cash_pend_amount,donation_type
                from mis.donation_req_correction drc,mis.donation_type_master dtm
                where drc.donation_type = dtm.type_name 
                and payment_month = '$request->mont'
                and dsm_checked_date is not null
                and case when main_cost_center_name = 'MSD' then be_checked_date else rm_checked_date end is not null
                 
                group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                
                union all
                
                select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                terr_id,0 cheque_app_amt,0 cash_app_amt,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_pend_amount,
                sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_pend_amount,donation_type
                from mis.donation_req_correction drc,mis.donation_type_master dtm
                where drc.donation_type = dtm.type_name
                and payment_month = '$request->mont'
                and dsm_checked_date is null
                and case when main_cost_center_name = 'MSD' then be_checked_date else rm_checked_date end is not null
                
                 and case when main_cost_center_name = 'MSD' then group_head_checked_date else gm_sales_checked_date end is  null
                 
                 
                group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                         
                                  
                )group by rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,donation_type) drc,(select distinct rm_terr_id,am_terr_id,mpo_terr_id
                from hrtms.hr_terr_list@web_to_hrtms
                where to_char(emp_month,'MON-RR') = '$request->mont'
                and dsm_emp_id = '$uid' ) ei
                where drc.rm_terr_id = ei.rm_terr_id
                and drc.am_terr_id = ei.am_terr_id
                and drc.terr_id = ei.mpo_terr_id
                and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else drc.rm_terr_id end
                and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else drc.am_terr_id end
                and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else drc.terr_id end
                and '$request->team' = case when '$request->team' = 'ALL' then all_data else main_cost_center_name end
               and '$request->don_type'  = case when '$request->don_type' = 'ALL' then all_data else donation_type end  
                and '$request->br_name' = case when '$request->br_name' = 'ALL' then all_data else to_char(sub_cost_center_id) end


                
                ");

//                return response()->json(['resp_data' => $resp_data,'balance' => $balance]);

            }

            if (Auth::user()->desig === 'SM' || Auth::user()->desig === 'AGM') {


                $resp_data = DB::select("
        
                                        
                    select terr_id,doctor_id,doctor_name,proposed_amount,approved,payment_mode,in_favour_of,frequency,payment_month,
                    lam,lf,lp,speciality,req_id,address,beneficiary_type,purpose,no_of_patient,contact_no,req_date,in_favour_of_main,
                    group_brand_region_name,commitment,donation_type,dsm_checked_date,sub_cost_center_id
                    from
                    ( 
                    select mpo_all,terr_id,doctor_id,doctor_name,proposed_amount,approved,payment_mode,in_favour_of,in_favour_of_main,
                    frequency,payment_month,lam,lf,lp,speciality,req_id,address,beneficiary_type,purpose,no_of_patient,contact_no,
                    req_date,group_brand_region_name,rd.rm_terr_id,am_terr_id,main_cost_center_name,commitment,donation_type,dsm_checked_date,sub_cost_center_id
                    from
                    (
                    select decode(approved_amount,null,proposed_amount,approved_amount)approved, 
                    'ALL' mpo_all,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    dd.*,dtm.main_cost_center_name,dlp.* 
                    from mis.donation_req_correction dd,mis.donation_type_master dtm,(select doctor_id ld,approved_amount lam,
                    frequency lf,payment_month lp
                    from( select doctor_id,frequency,approved_amount,to_date(payment_month,'MON-RR') payment_month,
                    row_number() over (partition by doctor_id order by to_date(payment_month,'MON-RR') desc) dd
                    from mis.donation_expense_budget deb,mis.donation_req_correction dd
                    where fi_process is not null 
                    and deb.req_id = dd.req_id)where dd = 1) dlp
                    where dd.donation_type = dtm.type_name
                    and payment_month = '$request->mont'
                    and dd.doctor_id = dlp.ld(+)
                    and rm_checked_date is not null and main_cost_center_name = 'MSD' 
                    and be_checked_date is not null  and sm_checked_date is null 
                    and group_head_checked_date is null
                    union all
                    select decode(approved_amount,null,proposed_amount,approved_amount)approved,
                    'ALL' mpo_all,substr(terr_id,1,instr(terr_id,'-'))||'00'  rm_terr_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    dd.*,dtm.main_cost_center_name,dlp.* 
                    from mis.donation_req_correction dd,mis.donation_type_master dtm,(select doctor_id ld,approved_amount lam,
                    frequency lf,payment_month lp
                    from( select doctor_id,frequency,approved_amount,to_date(payment_month,'MON-RR') payment_month,
                    row_number() over (partition by doctor_id order by to_date(payment_month,'MON-RR') desc) dd
                    from mis.donation_expense_budget deb,mis.donation_req_correction dd
                    where fi_process is not null 
                    and deb.req_id = dd.req_id)where dd = 1) dlp
                    where dd.donation_type = dtm.type_name
                    and payment_month = '$request->mont'
                    and dd.doctor_id = dlp.ld(+)
                    and rm_checked_date is not null
                    and main_cost_center_name <> 'MSD' and sm_checked_date is null
                    and gm_sales_checked_date is null
                    ) rd,(select distinct rm_terr_id rm_terr_id
                    from hrtms.hr_terr_list@web_to_hrtms
                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) ))  rtd
                    where rd.rm_terr_id = rtd.rm_terr_id
                    )where '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then mpo_all else rm_terr_id end
                    and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then mpo_all else am_terr_id end
                    and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then mpo_all else terr_id end
                    and '$request->team' = case when '$request->team' = 'ALL' then mpo_all else main_cost_center_name end
                    and '$request->don_type'  = case when '$request->don_type' = 'ALL' then mpo_all else donation_type end
                    and '$request->br_name' = case when '$request->br_name' = 'ALL' then mpo_all else to_char(sub_cost_center_id) end
                    order by terr_id,req_id 

              "
                );


                $balance = DB::select("
                                                                 
                                          
                     select sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                    sum(nvl(cheque_pend_amt,0)) cheque_pend_amt,sum(nvl(cash_pend_amt,0)) cash_pend_amt
                    from
                    (select 'ALL' all_data,rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                    sum(nvl(cheque_app_amt,0)) cheque_app_amt,sum(nvl(cash_app_amt,0)) cash_app_amt,
                    sum(nvl(cheque_pend_amount,0)) cheque_pend_amt,sum(nvl(cash_pend_amount,0)) cash_pend_amt,donation_type
                    from
                    (select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    terr_id,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_app_amt,
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_app_amt,0 cheque_pend_amount,0 cash_pend_amount,donation_type
                    from mis.donation_req_correction drc,mis.donation_type_master dtm
                    where drc.donation_type = dtm.type_name
                    and payment_month = '$request->mont'
                    and sm_checked_date is not null
                    and case when main_cost_center_name = 'MSD' then be_checked_date else rm_checked_date end is not null
                    group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                    union all
                    select main_cost_center_name,group_brand_region_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                    terr_id,0 cheque_app_amt,0 cash_app_amt,sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) cheque_pend_amount,
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) cash_pend_amount,donation_type
                    from mis.donation_req_correction drc,mis.donation_type_master dtm
                    where drc.donation_type = dtm.type_name
                    and payment_month = '$request->mont'
                    and sm_checked_date is null
                    and case when main_cost_center_name = 'MSD' then be_checked_date else rm_checked_date end is not null
                    
                     and case when main_cost_center_name = 'MSD' then group_head_checked_date else gm_sales_checked_date end is  null
                    
                    group by substr(terr_id,1,instr(terr_id,'-'))||'00',terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,
                    substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),donation_type
                    )group by rm_terr_id,am_terr_id,terr_id,main_cost_center_name,group_brand_region_name,sub_cost_center_id,donation_type) drc,(select distinct rm_terr_id,am_terr_id,mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
                    where to_char(emp_month,'MON-RR') = '$request->mont'
                    and sm_emp_id = '$uid' ) ei
                    where drc.rm_terr_id = ei.rm_terr_id
                    and drc.am_terr_id = ei.am_terr_id
                    and drc.terr_id = ei.mpo_terr_id
                    and '$request->rmTerrId' = case when '$request->rmTerrId' = 'ALL' then all_data else drc.rm_terr_id end
                    and '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else drc.am_terr_id end
                    and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else drc.terr_id end
                    and '$request->team' = case when '$request->team' = 'ALL' then all_data else main_cost_center_name end
                    and '$request->don_type'  = case when '$request->don_type' = 'ALL' then all_data else donation_type end
                    and '$request->br_name' = case when '$request->br_name' = 'ALL' then all_data else to_char(sub_cost_center_id) end



                
                ");


            }


//        else {
//                //  without any selection of option from form you'll get data with this query
//                $resp_data = DB::select("
//select decode(approved_amount,null,proposed_amount,approved_amount)approved, m.*
//from mis.donation_req_correction m  order by req_id
//                ");
//            }


            return response()->json(['resp_data' => $resp_data, 'balance' => $balance]);

//            return response()->json($resp_data);
        }
    }

    public function freq_edit(Request $request)
    {

        $freq = DB::select("select df_description
                    from mis.donation_frequency
                    order by df_id");
        return response()->json($freq);
    }


//select * from mis.donation_req_correction
    public function update_row(Request $request)
    {

        $update_action = DB::update("    update mis.donation_req_correction set 
                  approved_amount='$request->apr_amount',
                  payment_mode='$request->pay_mode',
                  frequency='$request->frequency',
                  in_favour_of= upper('$request->inf_of')
                                  where req_id = '$request->req_no' 
                ");

        return response()->json($update_action);


    }

    public function delete_row(Request $request)
    {
//        Before deleting from mis.donation_req_correction we are inserting that row in another table

        $uid = Auth::user()->user_id;

        $insert_action = DB::delete("insert into mis.donation_req_delete
                                        select d.*,'$uid',(select sysdate from dual)
                                        from mis.donation_req_correction d
                                        where req_id='$request->req_no' ");

        $delete_action = DB::delete("delete from mis.donation_req_correction   where req_id = '$request->req_no'   ");

        return response()->json($delete_action);

    }

    public function verify_row(Request $request)
    {
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $verinfo = json_decode($request->verifyData);
            //ini_set('max_execution_time', 600);
            if (Auth::user()->desig === 'AM') {
                foreach ($verinfo as $data) {


                    DB::UPDATE("
                        update mis.donation_req_correction
                        set am_emp_id='$uid',
                        am_name='$uname',
                        am_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }

            if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
                foreach ($verinfo as $data) {


                    DB::UPDATE("
                        update mis.donation_req_correction
                        set rm_emp_id='$uid',
                        rm_name='$uname',
                        rm_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }

            if (Auth::user()->desig === 'HO') {
                foreach ($verinfo as $data) {


                    DB::UPDATE("
                        update mis.donation_req_correction
                        set be_emp_id='$uid',
                        be_name='$uname',
                        be_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }

            if (Auth::user()->desig === 'DSM') {
                foreach ($verinfo as $data) {


                    DB::UPDATE("
                        update mis.donation_req_correction
                        set dsm_emp_id='$uid',
                        dsm_name='$uname',
                        dsm_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }

            if (Auth::user()->desig === 'SM' || Auth::user()->desig === 'AGM') {
                foreach ($verinfo as $data) {


                    DB::UPDATE("
                        update mis.donation_req_correction
                        set sm_emp_id='$uid',
                        sm_name='$uname',
                        sm_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }

            return response()->json(['success' => 'Research Expense verified Successfully.']);
        }


    }

    public function vacant_territory_view()

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

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('donation.vacant_territory')->with(['month_name' => $month_name, 'am_terr' => $am_terr]);
        }


        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");


            return view('donation.vacant_territory')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);

        }


    }

    public function verify_donation(Request $request)
    {

        $update_action = DB::update("   
   
                            update MIS.DONATION_REQ_CORRECTION 
                            set am_checked_date = (select sysdate from dual)
                            where 
                            substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->am_terr'
                            and payment_month = '$request->month'
                            and am_checked_date is null

                ");

        return response()->json($update_action);

    }

    public function verify_medicine(Request $request)
    {

        $update_action = DB::update("   
   
                        update MIS.DOCTOR_MEDICINE_REQ_APP 
                        set am_checked_date = (select sysdate from dual)
                        where 
                        substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$request->am_terr'
                        and req_month = '$request->month'
                        and am_checked_date is null

                ");

        return response()->json($update_action);


    }

    public function get_BrandBy_docId(Request $request){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $data = DB::select("select  doctor_id,doctor_name,listagg(brand, ', ') within group (order by doctor_id) brand
            from(
            select distinct m.doctor_id, m.doctor_name,p.brand
            from doctor_info.prescription_survey_master@web_to_sample_msd m,
            doctor_info.prescription_survey_details@web_to_sample_msd d,
            doctor_info.product_info@web_to_sample_msd p
            where m.survey_id=d.survey_id
            and d.p_code=p.p_code
            and p.company='INCEPTA'
            and m.doctor_id = '$request->docID'
            and to_date(m.survey_date,'DD-MON-RR') between to_date(add_months(sysdate,-3),'DD-MON-RR')  and to_date(sysdate,'DD-MON-RR')
            ) group by doctor_id,doctor_name
            ");
        return response()->json($data);
    }

    
}