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


class Budget_Monthly_Report_Controller extends Controller{

    public function index(){

        $month_name = DB::select("
                        SELECT TO_CHAR(SYSDATE,'YYYY')-LEVEL+1 AS yr FROM
                        DUAL
                        CONNECT BY LEVEL <= 10
                        order by yr DESC
                                     ");

                                     $gl = DB::select("
                                     select   distinct gl
                                     from mis.donation_cost_center
                                     where budget_type = 'DONATION'

                                     ");

        $cc = DB::select("
                        select cost_center_id,cost_center_description,department
from mis.donation_cost_center
where budget_type = 'DONATION' 
ORDER BY cost_center_description

                              ");


        return view('donation.budget_monthly_report')->with(['month_name' => $month_name,'gl'=>$gl,'cc'=>$cc]);

    }


    public function budget_monthly_report_display(Request $request)
    {


        $resp_data = DB::Select("
            
 

SELECT   ymon,
         ym,
         gl,
         cost_center_id,
         cost_center_name,
         nvl(cmiba,0) cmiba,
         nvl(expense_amt,0) expense_amt,
         nvl(avail_amt,0) avail_amt,
         to_date(ymon,'mm/dd/yyyy') ysort
  FROM   (SELECT   'ALL' all_data,
                   ymon,
                   ym,
                   ytm.gl,
                   ytm.cost_center_id,
                   cost_center_name,
                   cmiba,
                   expense_amt,
                   avail_amt
            FROM   (SELECT   ymon,
                             ym,
                             gl,
                             cost_center_id,
                             cost_center_description cost_center_name
                      FROM   (    SELECT   TO_CHAR (
                                              ADD_MONTHS (SYSDATE, (LEVEL + 0)),
                                              'MON'
                                           )
                                              ym,
                                              LEVEL
                                           || '/01/'
                                           || '$request->bgt_year'
                                              ymon
                                    FROM   DUAL
                              CONNECT BY   LEVEL <= 12) ytm,
                             mis.donation_cost_center dcc
                             where budget_type = 'DONATION') ytm,
                   (SELECT   exp_month,
                            re.gl,
                             re.cost_center_id,
                             cmiba,
                             expense_amt,
                             NVL (cmiba, 0) - NVL (expense_amt, 0) avail_amt
                      FROM   (  SELECT   TO_CHAR (
                                            TO_DATE (budget_month, 'MON-RR'),
                                            'MON'
                                         )
                                            budget_month,
                                            dcc.gl,
                                         dcc.cost_center_id,
                                         SUM (NVL (lm_available_amt, 0)) lma,
                                         SUM (NVL (cur_month_amt, 0)) cmiba
                                  FROM   mis.don_cost_center_budget dccb,mis.donation_cost_center dcc
                                 WHERE   budget_type = 'DONATION'
                                 and dccb.gl = dcc.gl and dccb.cost_center_id = dcc.cost_center_id
                                 and   TO_CHAR (
                                            TO_DATE (budget_month, 'MON-RR'),
                                            'RRRR'
                                         ) = '$request->bgt_year'
                              GROUP BY   TO_CHAR (
                                            TO_DATE (budget_month, 'MON-RR'),
                                            'MON'
                                         ),
                                         dcc.cost_center_id,dcc.gl) ccb,
                             (  SELECT   TO_CHAR (
                                            TO_DATE (expense_month, 'MON-RR'),
                                            'MON'
                                         )
                                            exp_month,
                                         gl,
                                         cost_center_id,
                                         SUM (NVL (budget_amt, 0)) budget_amt,
                                         SUM (NVL (expense_amt, 0)) expense_amt
                                  FROM   mis.research_expense
                                 WHERE   cost_center_type = 'CC'
                                         AND TO_CHAR (
                                               TO_DATE (expense_month,
                                                        'MON-RR'),
                                               'RRRR'
                                            ) = '$request->bgt_year'
                              GROUP BY   TO_CHAR (
                                            TO_DATE (expense_month, 'MON-RR'),
                                            'MON'
                                         ),
                                         gl,
                                         cost_center_id) re
                     WHERE   ccb.budget_month = re.exp_month
                             AND ccb.cost_center_id = re.cost_center_id and ccb.gl = re.gl) ccbe
           WHERE   ytm.ym = ccbe.exp_month(+)
                   AND ytm.cost_center_id = ccbe.cost_center_id(+)
                   and ytm.gl = ccbe.gl(+)
                   )
                   
 WHERE   '$request->cc' =
            CASE
               WHEN '$request->cc' = 'ALL' THEN all_data
               ELSE TO_CHAR (cost_center_id)
            END
              and 
            '$request->gl' =
            CASE
               WHEN '$request->gl'= 'ALL' THEN all_data
               ELSE TO_CHAR (gl)
            END
            order by cost_center_id, ysort
                     
          

                                    ");


        return response()->json($resp_data);
    }



}