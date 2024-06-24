<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 11/20/2019
 * Time: 1:48 PM
 */

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class FI_Misc_Controller extends Controller{

    public function index(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");

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
                                             select   distinct gl
                                     from mis.donation_cost_center
                                     where budget_type = 'DONATION'
                                            
                                            ");


        $dtm = DB::select("select type_name ,gl,main_cost_center_name,
                          type,type_name||case when main_cost_center_name = 'MSD' then ' (MARKETING)' else ' ('||main_cost_center_name||')'  end type_mct
                            from mis.donation_type_master
                        
                            ");

        $dbt = DB::select("select dbt_description
                            from mis.donation_beneficiary_type
                            order by dbt_id");

        return view('donation.fi_misc')->with(['year' => $year,'month_name' => $month_name, 'gl' => $gl, 'dtm' => $dtm, 'dbt' => $dbt]);

    }



    public function pending_data(Request $request)
    {

//        $resp_data = DB::Select("
//
//                        select *
//                        from mis.donation_req_correction
//                        where req_id in (
//                        select req_id
//                        from mis.donation_req_correction
//                        where case when COST_CENTER_ID = 1000801205 then gm_msd_checked_date
//                        when donation_type = 'RESEARCH EXPENSE' OR donation_type='BRAND RESEARCH SALES' OR donation_type = 'DPGPE' OR donation_type = 'REGION DEVELOPMENT'  then gm_sales_checked_date  else gm_msd_checked_date end is not null
//                        and payment_month in ('$request->month')
//                        minus
//                        select dc.req_id
//                        from mis.donation_expense_budget deb,mis.donation_req_correction dc
//                        where deb.req_id = dc.req_id
//                        and payment_month in ('$request->month')
//                        )
//
//                                    ");


        $resp_data = DB::Select("

                     
                        select drc.* ,mas.beneficiary_name, mas.bank_account_no bankaccno,beneficiary_bank_account_name,mas.bank_name bankname,mas.bank_branch_name bankbranchname,mas.routing_number bankroutingnum from (

                        select *
                        from mis.donation_req_correction
                        where req_id in (
                        select req_id
                        from mis.donation_req_correction
                        where case when cost_center_id = 1000801205 then gm_msd_checked_date
                        when donation_type = 'RESEARCH EXPENSE' or donation_type='BRAND RESEARCH SALES' 
                        or donation_type = 'DPGPE' or donation_type = 'REGION DEVELOPMENT'  then gm_sales_checked_date  else gm_msd_checked_date end is not null
                        and payment_month in ('$request->month')
                        minus
                        select dc.req_id
                        from mis.donation_expense_budget deb,mis.donation_req_correction dc
                        where deb.req_id = dc.req_id
                        and payment_month in ('$request->month')
                        ) ) drc , mis.donation_beftn_master mas
                        
                        where drc.doctor_id = mas.beneficiary_id(+)
                        and drc.terr_id = mas.territory_code (+)

                                    ");


        $data = ['rs_data' => $resp_data];
        $month = $request->month;

//        dd($data);


        \Excel::create('Pending_data', function ($excel) use ($data) {

            $excel->sheet('Pending Data', function ($sheet) use ($data) {
                $sheet->loadView('donation.excel_layout.pending_excel', $data);

            });

        })->store('xls', storage_path('donation/'));


        $response = ['success' => true, 'path' => 'http://'.request()->server('HTTP_HOST').'/misdashboard/storage/donation/Pending_data.xls'];



        return response()->json($response);
    }

    public function processed_data(Request $request)
    {

//        $resp_data = DB::Select("
//
//                select * from mis.donation_req_correction drc,mis.donation_expense_budget deb
//                where payment_month = '$request->month'
//                AND drc.req_id = deb.req_id
//
//                                    ");

//        $resp_data = DB::Select("
//
//                            SELECT
//                            DRC.req_id  ,
//                            req_date ,
//                            emp_id ,
//                            emp_name ,
//                            terr_id ,
//                            drc.d_id,
//                            d_name ,
//                            donation_type ,
//                            group_brand_region_name ,
//                            gl ,
//                            cost_center_id ,
//                            sub_cost_center_id ,
//                            beneficiary_type ,
//                            payment_mode ,
//                            purpose ,
//                            frequency ,
//                            payment_month ,
//                            proposed_amount ,
//                            approved_amount ,
//                            doctor_id ,
//                            doctor_name ,
//                            no_of_patient ,
//                            contact_no ,
//                            in_favour_of ,
//                            address ,
//                            speciality ,
//                            commitment ,
//                            drc.create_user ,
//                            drc.create_date ,
//                            am_emp_id ,
//                            am_name ,
//                            am_checked_date ,
//                            rm_emp_id ,
//                            rm_name ,
//                            rm_checked_date ,
//                            be_emp_id ,
//                            be_name ,
//                            be_checked_date ,
//                            dsm_emp_id ,
//                            dsm_name ,
//                            dsm_checked_date ,
//                            sm_emp_id ,
//                            sm_name ,
//                            sm_checked_date ,
//                            ssd_emp_id ,
//                            ssd_name ,
//                            ssd_checked_date ,
//                            group_head_emp_id ,
//                            group_head_emp_name ,
//                            group_head_checked_date ,
//                            gm_sales_emp_id ,
//                            gm_sales_emp_name ,
//                            gm_sales_checked_date ,
//                            gm_msd_emp_id ,
//                            gm_msd_emp_name ,
//                            gm_msd_checked_date ,
//                            BENEFICIARY_GROUP,
//
//                            deb.req_id req_id_bud,
//                            summ_id ,
//                            fi_doc_no ,
//                            fi_process ,
//                            bank_account_no ,
//                            deb.d_id d_id_bud,
//                            sl ,
//                            ref_no ,
//                            print_ba ,
//                            print_pl ,
//                            send_mail ,
//                            fi_print ,
//                            deb.create_user create_user_bud,
//                            deb.create_date create_date_bud,
//                            update_user ,
//                            update_date
//                            from mis.donation_req_correction drc,mis.donation_expense_budget deb
//                            where payment_month = '$request->month'
//                            AND drc.req_id = deb.req_id
//
//                                    ");

        $resp_data = DB::Select("
                      
                             select
                            drc.req_id ,
                            req_date ,
                            emp_id ,
                            emp_name ,
                            terr_id ,
                            drc.d_id,
                            drc.d_name ,
                            donation_type ,
                            group_brand_region_name ,
                            gl ,
                            cost_center_id ,
                            sub_cost_center_id ,
                            beneficiary_type ,
                            payment_mode ,
                            purpose ,
                            frequency ,
                            payment_month ,
                            proposed_amount ,
                            approved_amount ,
                            doctor_id ,
                            doctor_name ,
                            no_of_patient ,
                            contact_no ,
                            in_favour_of ,
                            address ,
                            speciality ,
                            commitment ,
                            drc.create_user ,
                            drc.create_date ,
                            am_emp_id ,
                            am_name ,
                            am_checked_date ,
                            rm_emp_id ,
                            drc.rm_name ,
                            rm_checked_date ,
                            be_emp_id ,
                            be_name ,
                            be_checked_date ,
                            dsm_emp_id ,
                            drc.dsm_name ,
                            dsm_checked_date ,
                            sm_emp_id ,
                            sm_name ,
                            sm_checked_date ,
                            ssd_emp_id ,
                            ssd_name ,
                            ssd_checked_date ,
                            group_head_emp_id ,
                            group_head_emp_name ,
                            group_head_checked_date ,
                            gm_sales_emp_id ,
                            gm_sales_emp_name ,
                            gm_sales_checked_date ,
                            gm_msd_emp_id ,
                            gm_msd_emp_name ,
                            gm_msd_checked_date ,
                            beneficiary_group,
                                                              
                            deb.req_id req_id_bud,
                            summ_id ,
                            fi_doc_no ,
                            fi_process ,
                            deb.bank_account_no bank_account_no,
                            deb.d_id d_id_bud,
                            deb.sl ,
                            ref_no ,
                            print_ba ,
                            print_pl ,
                            send_mail ,
                            fi_print ,
                            deb.create_user create_user_bud,
                            deb.create_date create_date_bud,
                            update_user ,
                            update_date ,
                            to_char(mas.bank_account_no) bankaccno,mas.beneficiary_name,beneficiary_bank_account_name,mas.bank_name bankname,mas.bank_branch_name bankbranchname,mas.routing_number bankroutingnum
                            from mis.donation_req_correction drc,mis.donation_expense_budget deb, mis.donation_beftn_master mas
                            where payment_month = '$request->month'
                            and drc.req_id = deb.req_id
                            and drc.doctor_id = mas.beneficiary_id(+)
                        and drc.terr_id = mas.territory_code (+)
                               
                                    ");

        $data = ['rs_data' => $resp_data];

//        \Excel::create('Processed_data', function ($excel) use ($data) {
//
//            $excel->sheet('Processed Data', function ($sheet) use ($data) {
//                $sheet->loadView('donation.excel_layout.processed_excel', $data);
//
//            });
//
//        })->store('xls', storage_path('donation/'));


        \Excel::create('Processed_data', function ($excel) use ($data) {
            $excel->sheet('Processed_data', function ($sheet) use ($data) {
                $sheet->loadView('donation.excel_layout.processed_excel', $data);

//                $sheet->setCellValueExplicit('BW'.count($data),$data);

            });
        })->store('xls', storage_path('donation/'));



        $response = ['success' => true, 'path' => 'http://'.request()->server('HTTP_HOST').'/misdashboard/storage/donation/Processed_data.xls'];

        return response()->json($response);
    }


}