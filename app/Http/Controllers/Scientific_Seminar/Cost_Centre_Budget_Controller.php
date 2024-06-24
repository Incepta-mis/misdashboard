<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 11/6/2019
 * Time: 3:19 PM
 */


namespace App\Http\Controllers\Scientific_Seminar;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Cost_Centre_Budget_Controller extends Controller
{

    public function index()
    {

        $year = DB::select("select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");

        $gl = DB::select("
                                            select distinct gl
                                            from mis.ss_budget_cost_center
                                            ");

        return view('scientific.cost_center_budget')->with(['year' => $year, 'gl' => $gl]);

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

    public function cc_don(Request $request)
    {

        $cc = DB::select("
                    select cost_center_id,cc_team_name cost_center_description         
                    from
                    (
                    select 
                    'ALL' all_data,dcc.*
                    
                    from mis.ss_budget_cost_center dcc
                    )
                    WHERE '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
                    order by cost_center_id                                          
                         
                                            ");


        return response()->json($cc);

    }


    public function cc_budget_display(Request $request)
    {

//        $uid = Auth::user()->user_id;

        $resp_data = DB::Select("
            
  SELECT   '$request->mon' budget_month,dcc.gl,
                 dcc.cost_center_id,
                 cc_team_name cost_center_description,
                 SUM (NVL (lm_available_amt, 0)) AS lm_available_amt,
                 SUM (NVL (cur_month_amt, 0)) AS cur_month_amt,
                 SUM (NVL (cur_month_amt, 0) + NVL (lm_available_amt, 0))
                    AS total_budget,budget_amt,advance_amt,
                 bill_amt,
                 (budget_amt - advance_amt) AS subtract_adv_amount,
                 (budget_amt - bill_amt) AS subtract_bill_amount
          FROM mis.ss_budget_cost_center dcc
                    LEFT JOIN
                       mis.don_cost_center_budget dccb
                    ON dcc.gl = dccb.gl
                    and dcc.cost_center_id = dccb.cost_center_id
                    and dccb.budget_month = '$request->mon'
                 LEFT JOIN
                    mis.scientific_seminar_expense sse
                 ON  dcc.gl = sse.gl
                 and dcc.cost_center_id = sse.cost_center_id                        
                 AND sse.expense_month = '$request->mon'
         WHERE   dcc.cost_center_id = '$request->cc'
         and dcc.gl = '$request->gl'         
      GROUP BY   dcc.cost_center_id,dcc.gl,
                 cc_team_name,
                 budget_month,
                 bill_amt,
                 budget_amt,
                 advance_amt

                                    ");


        return response()->json($resp_data);
    }


    public function insert_cc_budget(Request $request)
    {
        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $uid = Auth::user()->user_id;
        $insert_data = json_decode($request->insertData);

        $resp_data = DB::INSERT("insert into mis.don_cost_center_budget ( gl,budget_month,cost_center_id,
cost_center_name,
lm_available_amt,cur_month_amt,budget_of_type,comment_text,
create_user,create_date )
 values (?,?,?,?,?,?,?,?,?,?)",
            [$insert_data->gl, $insert_data->budget_month, $insert_data->cost_center_id, $insert_data->cost_center_description, $request->add_carry_amount,
                $request->add_current_amount, 'SCIENTIFIC SEMINAR', $request->remarks, $uid, $systime]);


        return response()->json($resp_data);
    }

    public function cc_budget_history(Request $request)
    {
        $resp_data = DB::Select("
        select * from         
        (
        select   'ALL' all_data,dccb.*
        from   mis.don_cost_center_budget dccb,mis.ss_budget_cost_center dcc
        where dccb.gl = dcc.gl
        and dccb.cost_center_id = dcc.cost_center_id 
        )          
        WHERE '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl) end 
        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
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
            
  select   '$request->mon' budget_month,
                 dcc.cost_center_id,
                 cc_team_name cost_center_description,
                 budget_amt,advance_amt,
                 bill_amt,
                 (budget_amt - advance_amt) as subtract_adv_amount,
                 (budget_amt - bill_amt) as subtract_bill_amount
          from   mis.ss_budget_cost_center dcc
                    left join
                       mis.don_cost_center_budget dccb
                    on dcc.gl = dccb.gl
                    and dcc.cost_center_id = dccb.cost_center_id
                       and dccb.budget_month = '$request->mon'
                 join
                    mis.scientific_seminar_expense sse
                 on  dcc.gl = sse.gl
                 and dcc.cost_center_id = sse.cost_center_id         
         and sse.expense_month = '$request->mon'
         where   dcc.cost_center_id = '$request->cc'         
      group by   dcc.cost_center_id,
                 cc_team_name,
                 budget_month,
                 bill_amt,
                 budget_amt,
                 advance_amt
                                    ");


        return response()->json($resp_data);
    }


}