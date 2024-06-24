<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 5/26/2019
 * Time: 11:34 AM
 */

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
Use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class Budget_Expense_Report_Controller extends controller
{
    public function index(){
        if(Auth::user()->desig ==='All'||Auth::user()->desig ==='HO'){

            $month_name = DB::select("

                                  select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                    with data as (select level l from dual connect by level <= 3)
                                    select *
                                    from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     
                                     ");



            $gl = DB::select("
                            select distinct gl,main_cost_center_name
                            from mis.donation_type_master
                            where main_cost_center_name = 'MSD'
                              ");

            $cc = DB::select("
                select cost_center_id,sub_cost_center_id,sub_cost_center_name from mis.donation_sub_cost_center
union all
select cost_center_id,to_number('') sub_cost_center_id,cost_center_description
from mis.donation_cost_center
where budget_type = 'DONATION' 
                              ");


            return view('donation.budget_expense_report')->with(['month_name' => $month_name, 'gl' => $gl, 'cc' => $cc]);
        }
    }


    public function budget_expense_report(Request $request){
//         $ber = DB::select("
//                     select gl,bd.cost_center_id,cost_center_name,total_budget,expense_budget,available_budget
// from
// (select 'ALL' all_data,gl,cost_center_id,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
//         sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0))- sum(nvl(expense_budget,0)) available_budget
// from(
// select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
// from mis.research_expense where expense_month = '$request->mon'
// and cost_center_type = 'CC'
// union all
// select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
// from mis.research_expense
// where expense_month = '$request->mon' and cost_center_type = 'SCC'
// union all
// select gl,drc.cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
// from mis.donation_req_correction drc,mis.donation_cost_center dcc
// where drc.cost_center_id = dcc.cost_center_id
// and be_checked_date is not null
// and dcc.department = 'MSD' and budget_type = 'DONATION'
// and payment_month = '$request->mon'
// group by gl,drc.cost_center_id
// union all
// select gl,drc.sub_cost_center_id cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
// from mis.donation_req_correction drc,mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
// where drc.sub_cost_center_id = dscc.sub_cost_center_id
// and dcc.cost_center_id = dscc.cost_center_id
// and dcc.department = 'MSD' and budget_type = 'DONATION'
// and be_checked_date is not null
// and payment_month = '$request->mon'
// group by gl,drc.sub_cost_center_id
// union all
// select gl,drc.cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
// from mis.donation_req_correction drc,mis.donation_cost_center dcc
// where drc.cost_center_id = dcc.cost_center_id
// and be_checked_date is not null
// and dcc.department = 'MSD' and budget_type = 'DONATION'
// and payment_month = '$request->mon'
// group by gl,drc.cost_center_id
// union all
// select gl,drc.sub_cost_center_id cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
// from mis.donation_req_correction drc,mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
// where drc.sub_cost_center_id = dscc.sub_cost_center_id
// and dcc.cost_center_id = dscc.cost_center_id
// and dcc.department = 'MSD' and budget_type = 'DONATION'
// and be_checked_date is not null
// and payment_month = '$request->mon'
// group by gl,drc.sub_cost_center_id
// )group by gl,cost_center_id) bd,(select sub_cost_center_id cost_center_id,sub_cost_center_name cost_center_name
//                              from mis.donation_sub_cost_center
//                              union all select cost_center_id,cost_center_description cost_center_name
//                              from mis.donation_cost_center where department ='MSD' and budget_type = 'DONATION') cc
// where bd.cost_center_id = cc.cost_center_id
// and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end
// and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(bd.cost_center_id) end
// order by bd.cost_center_id

//           ");
        $ber = DB::select("
                    select gl,bd.cost_center_id,cost_center_name,total_budget,expense_budget,available_budget
from
(select 'ALL' all_data,gl,cost_center_id,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
        sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0))- sum(nvl(expense_budget,0)) available_budget
from(
select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
from mis.research_expense where expense_month = '$request->mon'
and cost_center_type = 'CC'
union all
select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
from mis.research_expense
where expense_month = '$request->mon' and cost_center_type = 'SCC'
union all
select drc.gl,drc.cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
from mis.donation_req_correction drc,mis.donation_cost_center dcc
where drc.cost_center_id = dcc.cost_center_id
and be_checked_date is not null
and dcc.department = 'MSD' and budget_type = 'DONATION'
and payment_month = '$request->mon'
group by drc.gl,drc.cost_center_id
union all
select drc.gl,drc.sub_cost_center_id cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
from mis.donation_req_correction drc,mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where drc.sub_cost_center_id = dscc.sub_cost_center_id
and dcc.cost_center_id = dscc.cost_center_id
and dcc.department = 'MSD' and budget_type = 'DONATION'
and be_checked_date is not null
and payment_month = '$request->mon'
group by drc.gl,drc.sub_cost_center_id
union all
select drc.gl,drc.cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
from mis.donation_req_correction drc,mis.donation_cost_center dcc
where drc.cost_center_id = dcc.cost_center_id
and be_checked_date is not null
and dcc.department = 'MSD' and budget_type = 'DONATION'
and payment_month = '$request->mon'
group by drc.gl,drc.cost_center_id
union all
select drc.gl,drc.sub_cost_center_id cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
from mis.donation_req_correction drc,mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where drc.sub_cost_center_id = dscc.sub_cost_center_id
and dcc.cost_center_id = dscc.cost_center_id
and dcc.department = 'MSD' and budget_type = 'DONATION'
and be_checked_date is not null
and payment_month = '$request->mon'
group by drc.gl,drc.sub_cost_center_id
)group by gl,cost_center_id) bd,(select sub_cost_center_id cost_center_id,sub_cost_center_name cost_center_name
                             from mis.donation_sub_cost_center
                             union all select cost_center_id,cost_center_description cost_center_name
                             from mis.donation_cost_center where department ='MSD' and budget_type = 'DONATION') cc
where bd.cost_center_id = cc.cost_center_id
and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end
and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(bd.cost_center_id) end
order by bd.cost_center_id

          ");
        return response()->json($ber);

    }

//    public function budget_expense_report(Request $request){
//          $ber = DB::select("
//          select gl,cost_center_id,cost_center_name,total_budget,expense_budget,available_budget
//            from(
//            select 'ALL' all_data,gl,bd.cost_center_id,cost_center_name,sum(nvl(total_budget,0)) total_budget,sum(nvl(expense_budget,0)) expense_budget,
//                   sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget
//            from(
//            select gl,cost_center_id,0 no_of_req,0 total_req_amount,total_budget,0 expense_budget
//            from budget.v_budget_all@web_to_sample_msd
//            --from budget.v_budget_main@web_to_sample_msd
//            where to_char(budget_date,'MON-RR') = '$request->mon'
//            union all
//            select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
//            from mis.donation_expense_budget deb,mis.donation_req_correction dc
//            where deb.req_id = dc.req_id
//            and to_char(ssd_payment_date,'MON-RR') = '$request->mon'
//            group by gl,cost_center_id
//            ) bd,(select sub_cost_center_id cost_center_id,sub_cost_center_name cost_center_name
//                  from mis.donation_sub_cost_center
//                  union all select cost_center_id,cost_center_description cost_center_name
//                  from mis.donation_cost_center) cc
//            where bd.cost_center_id = cc.cost_center_id
//            group by gl,bd.cost_center_id,cost_center_name
//            )where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end
//            and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
//          ");
//          return response()->json($ber);
//
//    }

}



