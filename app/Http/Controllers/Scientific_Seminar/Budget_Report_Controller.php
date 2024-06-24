<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 11/20/2019
 * Time: 1:48 PM
 */



namespace App\Http\Controllers\Scientific_Seminar;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Budget_Report_Controller extends Controller{

    public function index(){

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 9)
                                    select *
                                      from (select trunc(add_months(sysdate, -8)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

                                     $gl = DB::select(" select distinct gl
                                            from mis.ss_budget_cost_center
                                     
                                     ");

        $cc = DB::select("
                        select cost_center_id,cost_center_description,department
from mis.donation_cost_center
where budget_type = 'DONATION' 
ORDER BY cost_center_description

                              ");


        return view('scientific.budget_report')->with(['month_name' => $month_name,'gl' =>$gl,'cc'=>$cc]);

    }

    public function cc_don(Request $request){

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


    public function cc_budget_report(Request $request)
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        $uid = Auth::user()->user_id;

        $resp_data = DB::Select("
            
                    SELECT gl,
                    gl_name,
                    cost_center_id,
                    cost_center_name,
                    lma,
                    cma,
                    total_amt,
                    expense_amt,bill_amt,
                   (NVL (total_amt, 0) - NVL (case when expense_amt>bill_amt then expense_amt else bill_amt end, 0)) rem_amt,
                   (NVL (total_amt, 0) - NVL (case when expense_amt>bill_amt then expense_amt else bill_amt end, 0)) nmcf_amt
                    FROM (SELECT 'ALL' all_data,
                    cc.gl,
                    'Business Promotion' gl_name,
                    cc.cost_center_id,
                    cost_center_name,
                    lma,
                    cma,
                    budget_amt total_amt,
                    expense_amt,bill_amt
                    FROM (SELECT gl,cost_center_id,
                    cc_team_name cost_center_name
                    FROM mis.ss_budget_cost_center
                    ) cc,     
                    (SELECT gl,
                    ccb.cost_center_id,
                    lma,
                    cma,
                    budget_amt,
                    expense_amt,bill_amt
                    FROM ( SELECT dcc.cost_center_id,
                    SUM (NVL (lm_available_amt, 0)) lma,
                    SUM (NVL (cur_month_amt, 0)) cma
                    FROM mis.don_cost_center_budget dccb,mis.ss_budget_cost_center dcc
                    WHERE 
                     dccb.gl = dcc.gl and dccb.cost_center_id = dcc.cost_center_id
                    and TO_DATE (budget_month, 'MON-RR') BETWEEN
                    '$request->mon_from'
                    
                    AND
                    '$request->mon_to'
                    GROUP BY dcc.cost_center_id) ccb,
                    ( SELECT gl,
                    cost_center_id,
                    SUM (NVL (budget_amt, 0)) budget_amt,
                    SUM (NVL (advance_amt, 0)) expense_amt,
                    SUM (NVL (bill_amt, 0)) bill_amt
                    FROM mis.scientific_seminar_expense
                    WHERE cost_center_type = 'CC'
                    AND TO_DATE (expense_month, 'MON-RR') BETWEEN
                    '$request->mon_from'
                    
                    AND
                    '$request->mon_to'
                    GROUP BY gl, cost_center_id) re
                    WHERE ccb.cost_center_id = re.cost_center_id) ccb
                    WHERE cc.cost_center_id = ccb.cost_center_id(+) and cc.gl = ccb.gl )
                    WHERE '$request->cc' =
                    CASE
                    WHEN
                    '$request->cc' = 'ALL' THEN all_data
                    ELSE TO_CHAR (cost_center_id)
                    END
                    AND
                    '$request->gl' =
                    CASE
                    WHEN '$request->gl' = 'ALL' THEN all_data
                    ELSE TO_CHAR (GL)
                    END

                                    ");


        return response()->json($resp_data);
    }



}