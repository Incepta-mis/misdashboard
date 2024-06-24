<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 11/6/2019
 * Time: 3:19 PM
 */

namespace App\Http\Controllers\Dmr;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Cost_Centre_Budget_Controller extends Controller{

    public function index(){

        $year = DB::select("
                        select to_number(to_char(sysdate, 'RRRR')) year from dual
                        union all
                        select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                         union all
                        select to_number(to_char(sysdate, 'RRRR'))-1 year from dual
                        order by year
                 ");

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $cc = DB::select("
                        select cost_center_id,cost_center_description,department
from mis.donation_cost_center
where budget_type = 'MEDICINE'
ORDER BY cost_center_description
                              ");


        return view('dmr.cost_center_budget')->with(['year' => $year,'month_name' => $month_name,'cc'=>$cc]);

    }

    public function re_year(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("
            
            select to_char(add_months(to_date(sysdate,'DD-MON-RRRR'),level -1),'MON') ||'-'||(select substr('$request->year',-2,2) from dual) payment_month
            from dual connect by level <= 12
            order by to_char(add_months(to_date(sysdate,'DD-MON-RRRR'),level -1),'MM')                                                                                                     
                                    ");

        return response()->json($resp_data);
    }


    public function cc_budget_display(Request $request)
{

//        $uid = Auth::user()->user_id;

    $resp_data = DB::Select("
            
  SELECT  '$request->mon' budget_month,dcc.gl,dcc.cost_center_id,cost_center_description,
        SUM (NVL (lm_available_amt, 0)) AS lm_available_amt,
        SUM (NVL (cur_month_amt, 0)) AS cur_month_amt,
        SUM (NVL (cur_month_amt, 0) + NVL (lm_available_amt, 0)) AS total_budget,budget_amt,0 dist_budget_amt,
        expense_amt,0 subtract_dist_amount,
        (budget_amt - expense_amt) AS subtract_exp_amount
FROM mis.donation_cost_center dcc
LEFT JOIN
mis.don_cost_center_budget dccb
ON  dcc.gl = dccb.gl
and dcc.cost_center_id = dccb.cost_center_id
and budget_type = 'MEDICINE'
AND dccb.budget_month = '$request->mon'
LEFT JOIN
mis.medicine_expense re
ON  dcc.gl = re.gl
and dcc.cost_center_id = re.cost_center_id
and dcc.budget_type = 'MEDICINE'
AND re.expense_month = '$request->mon'
WHERE   dcc.cost_center_id = '$request->cc'
and dcc.budget_type = 'MEDICINE' 
GROUP BY   dcc.gl,dcc.cost_center_id,cost_center_description,budget_month,
expense_amt,budget_amt

                                    ");


    return response()->json($resp_data);
}


public function insert_cc_budget(Request $request)
{
    $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
    $uid = Auth::user()->user_id;
    $insert_data = json_decode($request->insertData);

        $resp_data =  DB::INSERT("insert into mis.don_cost_center_budget ( gl,budget_month,cost_center_id,
cost_center_name,
lm_available_amt,cur_month_amt,budget_of_type,comment_text,
create_user,create_date )
values (?,?,?,?,?,?,?,?,?,?)",
            [$insert_data->gl,$insert_data->budget_month,$insert_data->cost_center_id,$insert_data->cost_center_description,$request->add_carry_amount,
                $request->add_current_amount,'MEDICINE', $request->remarks,$uid,$systime]);


    return response()->json($resp_data);
}


    public function cc_budget_history(Request $request)
    {

        $resp_data = DB::Select("
            
        select * from
        (
        select   'ALL' all_data, dccb.*
        from   mis.don_cost_center_budget dccb,mis.donation_cost_center dcc
        where dccb.gl = dcc.gl
        and dccb.cost_center_id = dcc.cost_center_id 
        and dcc.budget_type = 'MEDICINE' 
        )
        
        WHERE 
        '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
        AND  '$request->mon' = case when '$request->mon' = 'ALL' then all_data else budget_month end
        and to_char(to_date(budget_month,'MON-RR'),'RRRR') = '$request->year'          
        order by to_date(budget_month,'MON-RR'),cost_center_id 

                                    ");


        return response()->json($resp_data);
    }


    public function subtract_budget_calc(Request $request)
    {

//        $uid = Auth::user()->user_id;

        $resp_data = DB::Select("
            
  SELECT   '$request->mon' budget_month,
                 dcc.cost_center_id,
                 cost_center_description,
                 budget_amt,0 dist_budget_amt,
                 expense_amt,
                 0 subtract_dist_amount,
                 (budget_amt - ed_cogm_amt) AS subtract_exp_amount
          FROM         mis.donation_cost_center dcc
                    LEFT JOIN
                       mis.don_cost_center_budget dccb
                    ON dcc.gl = dccb.gl
                    and dcc.cost_center_id = dccb.cost_center_id
                    and budget_type = 'MEDICINE'
                       AND dccb.budget_month = '$request->mon'
                 JOIN
                    mis.medicine_expense re
                 ON  dcc.gl = re.gl
                 and dcc.cost_center_id = re.cost_center_id                 
                 AND re.expense_month = '$request->mon'
         WHERE   dcc.cost_center_id = '$request->cc'
         and dcc.budget_type = 'MEDICINE'
      GROUP BY   dcc.cost_center_id,
                 cost_center_description,
                 budget_month,
                 expense_amt,
                 budget_amt,ed_cogm_amt
                 

                                    ");


        return response()->json($resp_data);
    }



}