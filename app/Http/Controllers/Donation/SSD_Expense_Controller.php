<?php


namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SSD_Expense_Controller extends Controller{

    public function index(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 12)
                                    select *
                                      from (select trunc(add_months(sysdate, -11)) dt from dual), data
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

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

        return view('donation.ssd_expense_calculation')->with(['year' => $year,'month_name' => $month_name, 'gl' => $gl, 'dtm' => $dtm, 'dbt' => $dbt,'rm_terr' => $rm_terr]);

    }

    public function ssd_expense_data(Request $request)
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        $uid = Auth::user()->user_id;

        $resp_data = DB::Select("
            
                        select * from
                        (
                        select sub_cost_center_name,'ALL' all_data,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,drc.*
                        from mis.donation_req_correction drc, mis.donation_sub_cost_center_old dsc
                         where  drc.cost_center_id = dsc.cost_center_id(+)
                         and drc.sub_cost_center_id = dsc.sub_cost_center_id(+)
                        )
                        where
                        '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                        and '$request->region' = case when '$request->region' = 'ALL' then all_data else rm_terr_id end
                        
                        and to_date(payment_month,'MON-RR') between '$request->month' AND '$request->month_to'
                        
                        and '$request->beneficiary' = case when '$request->beneficiary' = 'ALL' then all_data else beneficiary_type end
                        and case when '$request->dsm' = 'ALL' then all_data else to_char(dsm_checked_date) end  is not null
                        and case when '$request->sm' = 'ALL' then all_data else to_char(sm_checked_date) end  is not null
                        and case when '$request->gm_sales' = 'ALL' then all_data else to_char(gm_sales_checked_date) end  is not null
                        and case when '$request->gm_msd' = 'ALL' then all_data else to_char(gm_msd_checked_date) end  is not null
                        order by  rm_terr_id 
    
                                    ");
//        dd($resp_data);

        $sum_data = DB::Select("
            
                        select sum(approved_amount) apt_amount  from
                        (
                        select 'ALL' all_data,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,drc.*
                        from mis.donation_req_correction drc
                        )
                        where
                        '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                          and '$request->region' = case when '$request->region' = 'ALL' then all_data else rm_terr_id end
                    
                         and to_date(payment_month,'MON-RR') between '$request->month' AND '$request->month_to'
                         
                        and '$request->beneficiary' = case when '$request->beneficiary' = 'ALL' then all_data else beneficiary_type end
                        and case when '$request->dsm' = 'ALL' then all_data else to_char(dsm_checked_date) end  is not null
                        and case when '$request->sm' = 'ALL' then all_data else to_char(sm_checked_date) end  is not null
                        and case when '$request->gm_sales' = 'ALL' then all_data else to_char(gm_sales_checked_date) end  is not null
                        and case when '$request->gm_msd' = 'ALL' then all_data else to_char(gm_msd_checked_date) end  is not null
                        order by  req_id 
    
                                    ");

        $budget_data = DB::Select("
            
                    select 
                    sum(nvl(lm_available_amt,0)+ nvl(cur_month_amt,0)) as bud_amount
                    from
                    (
                    select 'ALL' all_data,dcb.*
                    from mis.don_cost_center_budget dcb
                    )        
                    where        budget_of_type = 'DONATION'
                    and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                    and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                    and to_date(budget_month,'MON-RR') between  '$request->month' AND '$request->month_to'
    
                                    ");

//        and to_date(budget_month,'MON-RR') between to_date('$request->month','MON-RR') AND to_date('$request->month_to','MON-RR')
        return response()->json(['resp'=>$resp_data,'sum'=> $sum_data,'budget' =>$budget_data]);
    }


}