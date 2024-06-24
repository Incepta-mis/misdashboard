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

class Pending_Request_Controller extends Controller
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






        return view('donation.pending_request', ['month_name' => $month_name]);

    }


    public function pending_request_data(Request $request)
    {
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {
//            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $cc = DB::select("
              
select  payment_month,req_id,emp_id,emp_name,terr_id,d_id||'-'||d_name as depot_info,donation_type,group_brand_region_name,doctor_id,doctor_name,
beneficiary_type,payment_mode,purpose,frequency,proposed_amount,approved_amount,am_checked_date,rm_checked_date,be_checked_date,dsm_checked_date,
sm_checked_date,ssd_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date
from(
select 'MPO' emp_type,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
beneficiary_type,payment_mode,purpose,frequency,proposed_amount ,approved_amount,am_checked_date,rm_checked_date,be_checked_date,dsm_checked_date,
sm_checked_date,ssd_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,emp_id login_emp_id
from mis.donation_req_correction
where emp_id is not null               --mpo checked
and payment_month = '$request->dcid'
union all
select 'AM' emp_type,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
beneficiary_type,payment_mode,purpose,frequency,proposed_amount ,approved_amount,am_checked_date,rm_checked_date,be_checked_date,dsm_checked_date,
sm_checked_date,ssd_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,am_emp_id login_emp_id
from mis.donation_req_correction
where am_checked_date is not null               --am check
and payment_month = '$request->dcid'
union all
select 'RM' emp_type,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
beneficiary_type,payment_mode,purpose,frequency,proposed_amount ,approved_amount,am_checked_date,rm_checked_date,be_checked_date,dsm_checked_date,
sm_checked_date,ssd_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,rm_emp_id login_emp_id
from mis.donation_req_correction
where rm_checked_date is not null              --rm check
and payment_month = '$request->dcid'
union all
select 'DSM' emp_type,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
beneficiary_type,payment_mode,purpose,frequency,proposed_amount ,approved_amount,am_checked_date,rm_checked_date,be_checked_date,dsm_checked_date,
sm_checked_date,ssd_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,dsm_emp_id login_emp_id
from mis.donation_req_correction
where dsm_checked_date is not null               --dsm check
and payment_month = '$request->dcid'
union all
select 'BE' emp_type,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
beneficiary_type,payment_mode,purpose,frequency,proposed_amount ,approved_amount,am_checked_date,rm_checked_date,be_checked_date,dsm_checked_date,
sm_checked_date,ssd_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,be_emp_id login_emp_id
from mis.donation_req_correction
where be_checked_date is not null              --BE check
and payment_month = '$request->dcid'
union all
select 'SM' emp_type,payment_month,req_id,emp_id,emp_name,terr_id,d_id,d_name,donation_type,group_brand_region_name,doctor_id,doctor_name,
beneficiary_type,payment_mode,purpose,frequency,proposed_amount ,approved_amount,am_checked_date,rm_checked_date,be_checked_date,dsm_checked_date,
sm_checked_date,ssd_checked_date,group_head_checked_date,gm_sales_checked_date,gm_msd_checked_date,sm_emp_id login_emp_id
from mis.donation_req_correction
where sm_checked_date is not null         --sm check
and payment_month = '$request->dcid'                
)where login_emp_id = '$uid'

order by terr_id,doctor_id

                            ");


            return response()->json($cc);
        }
    }


}