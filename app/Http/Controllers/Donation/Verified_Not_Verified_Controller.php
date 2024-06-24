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

class Verified_Not_Verified_Controller extends Controller
{
    public function index()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $month_name = DB::select("
                                     select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 14)
                                    select *
                                      from (select trunc(add_months(sysdate, -13)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $dtm = DB::select("select type_name ,gl,main_cost_center_name,
                          type,type_name||case when main_cost_center_name = 'MSD' then ' (MARKETING)' else ' ('||main_cost_center_name||')'  end type_mct
                            from mis.donation_type_master");

//        $dbt = DB::select(" select dbt_description from MIS.donation_beneficiary_type"  );


        return view('donation.verified_not_verified_report', ['dtm' => $dtm,'month_name' => $month_name]);

    }


    public function verified_not_verified_data(Request $request)
    {
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {
//            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");
            $cc = DB::select("
                
            select payment_month,vf_ntf,emp_id,emp_name,terr_id,d_id||'-'||d_name as depot,donation_type,group_brand_region_name,req_id,
            doctor_id,doctor_name,beneficiary_type,payment_mode,purpose,frequency,amount,check_date
            from(
            select 'ALL' all_data,'AM' emp_type,case when am_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,rm_checked_date check_date,am_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and am_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select 'ALL' all_data,'RM' emp_type,case when rm_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf, 
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,dsm_checked_date check_date,rm_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and rm_emp_id  = '$uid' 
            union all
            select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and asm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select 'ALL' all_data,'DSM' emp_type,case when dsm_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,sm_checked_date check_date,dsm_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and dsm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select distinct 'ALL' all_data,emp_type,vf_ntf,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,
            doctor_id,doctor_name,beneficiary_type,payment_mode,purpose,frequency,amount,check_date,login_emp_id
            from(
            select 'SM' emp_type,case when gm_sales_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,gm_sales_checked_date check_date,sm_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and sm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select 'SM' emp_type,case when gm_msd_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,gm_msd_checked_date check_date,sm_emp_id login_emp_id
            from mis.donation_req_correction drc, (select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and sm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            ))where '$request->ver_data' = case when '$request->ver_data' = 'ALL' then all_data else vf_ntf end
            and '$request->don_typ' = case when '$request->don_typ' = 'ALL' then all_data else donation_type end


                            ");


            $total_amt= DB::select("
            select sum(nvl(amount,0)) tot_amount from
            (            
            select payment_month,vf_ntf,emp_id,emp_name,terr_id,d_id||'-'||d_name as depot,donation_type,group_brand_region_name,req_id,
            doctor_id,doctor_name,beneficiary_type,payment_mode,purpose,frequency,amount,check_date
            from(
            select 'ALL' all_data,'AM' emp_type,case when am_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,rm_checked_date check_date,am_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and am_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select 'ALL' all_data,'RM' emp_type,case when rm_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf, 
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,dsm_checked_date check_date,rm_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and rm_emp_id  = '$uid' 
            union all
            select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and asm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select 'ALL' all_data,'DSM' emp_type,case when dsm_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,sm_checked_date check_date,dsm_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and dsm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select distinct 'ALL' all_data,emp_type,vf_ntf,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,
            doctor_id,doctor_name,beneficiary_type,payment_mode,purpose,frequency,amount,check_date,login_emp_id
            from(
            select 'SM' emp_type,case when gm_sales_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,gm_sales_checked_date check_date,sm_emp_id login_emp_id
            from mis.donation_req_correction drc,(select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and sm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            union all
            select 'SM' emp_type,case when gm_msd_checked_date is not null then 'VERIFIED' else 'NOT VERIFIED' end vf_ntf,
            payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
            beneficiary_type,payment_mode,purpose,frequency,approved_amount amount,gm_msd_checked_date check_date,sm_emp_id login_emp_id
            from mis.donation_req_correction drc, (select distinct mpo_terr_id from hrtms.hr_terr_list@web_to_hrtms
            where to_char(emp_month,'MON-RR') = '$request->dcid' and sm_emp_id  = '$uid' )
            where payment_month = '$request->dcid'
            and terr_id = mpo_terr_id
            ))where '$request->ver_data' = case when '$request->ver_data' = 'ALL' then all_data else vf_ntf end
            and '$request->don_typ' = case when '$request->don_typ' = 'ALL' then all_data else donation_type end
            
)
            
            ");

            return response()->json(['cc' => $cc,'total_amt'=> $total_amt]);
        }
    }


}