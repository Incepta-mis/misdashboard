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


class Business_Promotion_Controller extends Controller{

    public function index(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
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

        return view('donation.business_promotion')->with(['year' => $year, 'gl' => $gl, 'dtm' => $dtm, 'dbt' => $dbt]);

    }



    public function business_promotion_data(Request $request)
    {

//        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        $uid = Auth::user()->user_id;

        $resp_data = DB::Select("
            
                select * from
                (
                select 'ALL' all_data,to_char(to_date(payment_month,'MON-RR'),'RRRR') yr,payment_month,gl,cost_center_id, terr_id,emp_id,
                rm_emp_id,rm_name, donation_type,doctor_id,doctor_name,address,beneficiary_type,approved_amount,payment_mode,frequency
                FROM MIS.DONATION_REQ_CORRECTION
                where req_id in ( select req_id from mis.donation_expense_budget)
                )
                where
                '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                and '$request->month' = case when '$request->month' = 'ALL' then all_data else to_char(payment_month) end
                and '$request->year' = yr    
                and '$request->don_type' = case when '$request->don_type' = 'ALL' then all_data else to_char(donation_type)end
                and '$request->beneficiary' = case when '$request->beneficiary' = 'ALL' then all_data else beneficiary_type end
                and '$request->pay_mode' = case when '$request->pay_mode' = 'ALL' then all_data else payment_mode end
                order by   to_date(payment_month,'MON-RR')      
                           
                                    ");


        return response()->json($resp_data);
    }



}