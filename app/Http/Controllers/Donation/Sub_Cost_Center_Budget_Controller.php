<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 10/27/2019
 * Time: 11:41 AM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Sub_Cost_Center_Budget_Controller extends Controller{

    public function index(){

        $month_name = DB::select("select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
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
                            and gl not in (52010085, 52011200) 
                            order by gl desc
                                            ");

        $cc = DB::select("
                select distinct cost_center_id,cost_center_description,department
                from mis.donation_cost_center
                where budget_type = 'DONATION'                    
                order by cost_center_description                    
                              ");


        return view('donation.sub_cost_center_budget')->with(['month_name' => $month_name,'gl'=>$gl,'cc'=>$cc]);

    }


    public function scc_for_budget(Request $request)
    {

        $resp_data = DB::Select("
                            select cost_center_id,sub_cost_center_id,sub_cost_center_name
                            from mis.donation_sub_cost_center 
                            where cost_center_id = '$request->ccid'
                             order by sub_cost_center_name
                                    
                                    ");


        return response()->json($resp_data);
    }

    public function insert_scc_budget(Request $request)
    {
        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $uid = Auth::user()->user_id;
        $insert_data = json_decode($request->insertData);

            $resp_data =  DB::INSERT("
                        
                    insert into mis.don_sub_cost_center_budget ( budget_month,gl,cost_center_id,cost_center_name,
                    sub_cost_center_id,sub_cost_center_name,cur_month_amt,create_user,create_date )
                        values (?,?,?,?,?,?,?,?,?)",
            [$insert_data->budget_month,$insert_data->gl,$insert_data->cost_center_id,$insert_data->cost_center_name,$insert_data->sub_cost_center_id,
                $insert_data->sub_cost_center_name,$request->proposed_budget,$uid,$systime]);



        return response()->json($resp_data);
    }


    public function scc_budget_display(Request $request)
    {

        $uid = Auth::user()->user_id;

        $resp_data = DB::Select("
                        

select budget_month,cc.gl,cc.cost_center_id,cost_center_name,cc.sub_cost_center_id,sub_cost_center_name,avai_budget,scc_budget,sum_sm, (sum_sm-scc_budget) exp_sm
                        from  
                                            
                        (select  gl,dcc.cost_center_id,cost_center_description cost_center_name,sub_cost_center_id,sub_cost_center_name,be_emp_id
                        from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                        where budget_type = 'DONATION' 
                        and dcc.cost_center_id = dscc.cost_center_id
                        AND gl = '$request->gl'    
                        and dcc.cost_center_id = '$request->cc'
                        and dscc.sub_cost_center_id = '$request->scc'
                        and budget_emp_id = '$uid') cc,
                        
                    (select sum(approved_amount)sum_sm                                 
                    from
                    mis.donation_req_correction
                    where
                    cost_center_id= '$request->cc'
                    and sub_cost_center_id='$request->scc'
                    and payment_month = '$request->mon'
                    and gl =     '$request->gl'
                    AND sm_checked_date is not null)exp,
                                                
                                                
                            (select dccb.gl, dccb.cost_center_id,dsccb.sub_cost_center_id,cc_budget,sum(nvl(dsccb.cur_month_amt,0)) scc_budget   
                            from 
                            (select gl,budget_month,cost_center_id,cost_center_name,sum(nvl(lm_available_amt,0)+nvl(cur_month_amt,0)) cc_budget
                            from mis.don_cost_center_budget where budget_month = '$request->mon' AND BUDGET_OF_TYPE = 'DONATION'  AND gl = '$request->gl' 
                            group by budget_month,gl,cost_center_id,cost_center_name) dccb,mis.don_sub_cost_center_budget dsccb
                            where 
                            dccb.gl = dsccb.gl(+)
                            and dccb.budget_month = dsccb.budget_month(+) 
                            and dccb.cost_center_id = dsccb.cost_center_id(+)
                            group by dccb.cost_center_id,dccb.cost_center_name,dsccb.sub_cost_center_id,dsccb.sub_cost_center_name,cc_budget,dccb.gl
                            )ccb,

                        (select gl,budget_month,cost_center_id,sum(nvl(avai_amt,0)) avai_budget
                        from
                        (select GL, budget_month,cost_center_id,-sum(nvl(cur_month_amt,0)) avai_amt
                        from mis.don_sub_cost_center_budget
                        where budget_month = '$request->mon' group by budget_month,cost_center_id,gl
                        union all
                        select gl,budget_month,cost_center_id,sum(nvl(lm_available_amt,0)+nvl(cur_month_amt,0))
                        from mis.don_cost_center_budget where budget_month = '$request->mon'
                        and budget_of_type = 'DONATION'
                        group by budget_month,cost_center_id,gl
                        )where gl = '$request->gl' group by budget_month,cost_center_id,gl ) ccdb

                          where cc.cost_center_id = ccb.cost_center_id (+)
                                  
            and cc.sub_cost_center_id = ccb.sub_cost_center_id(+)
            and cc.cost_center_id = ccdb.cost_center_id
            and avai_budget > 0
                                    
                                    ");


        return response()->json($resp_data);
    }



}