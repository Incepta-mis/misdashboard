<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 3/12/2019
 * Time: 2:55 PM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Mail;

//Request $request

class FI_Process_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $month_name = DB::select("
                                   select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                    from
                                    (
                                    with data as (select level l from dual connect by level <= 4)
                                    select *
                                    from (select trunc(add_months(sysdate, -3)) dt from dual), data
                                    order by dt, l)
                                                                         ");

            $sum_id = DB::select("  select distinct summ_id from mis.donation_expense_budget where fi_doc_no is  null order by summ_id desc ");

            $sum_id_stp = DB::select("  select distinct summ_id from mis.donation_expense_budget where  create_date >=  sysdate - 60  order by summ_id desc ");

            $gl = DB::select("
                            select distinct  gl
                            from mis.donation_type_master
                            union all                      
                            select 52010085 gl
                            from dual
                            union all                      
                            select 52011200 gl
                            from dual
                            union all                      
                            select 15940040 gl
                            from dual
                              ");


            $cc = DB::select("
                select distinct cost_center_id,cost_center_description,department
from mis.donation_cost_center
where budget_type = 'DONATION'
order by department,cost_center_description

                              ");

            $scc = DB::Select("
                
select distinct dcc.cost_center_id,sub_cost_center_id,
case when dcc.cost_center_id ='1000101204' then  sub_cost_center_name||' SALES' else sub_cost_center_name end sub_cost_center_name
from mis.donation_cost_center dcc, mis.donation_sub_cost_center dscc
where budget_type = 'DONATION'
and dcc.cost_center_id = dscc.cost_center_id
order by cost_center_id, sub_cost_center_id
                                    
                                    ");


            return view('donation.fi_process')->with(['sumid_stp' =>$sum_id_stp,'month_name' => $month_name, 'sum_id' => $sum_id,'gl' => $gl, 'cc' => $cc, 'scc' => $scc]);

        }


    }

    public function rem_requests(Request $request)
    {

        if ($request->ajax()) {

            $dis_sum = DB::select(" 
                select count(*) tot_no_req
                from
                (select req_id
                from mis.donation_req_correction
                where case when donation_type in ('RESEARCH EXPENSE','DPGPE','REGION DEVELOPMENT','BRAND RESEARCH SALES') then
                gm_sales_checked_date else gm_msd_checked_date end is not null
                and payment_month = '$request->mon'
                and terr_id not like 'AHV%'
                union all
                select req_id
                from mis.donation_req_correction
                where gm_msd_checked_date is not null
                and payment_month = '$request->mon'
                and terr_id like 'AHV%' 
                minus
                select req_id
                from mis.donation_expense_budget
                )

                                            ");

            return response()->json($dis_sum);

        }
    }

    public function fi_req_data(Request $request)
    {
        Log::info($request->all());
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $uid = Auth::user()->user_id;
        if ($request->ajax()) {

            DB::DELETE("   delete from mis.donation_process ");

            DB::INSERT("
           insert into mis.donation_process
                select req_id
                from(
                select req_id,approved_amount
                from(
                select drc.req_id,approved_amount,gl,cost_center_id,sub_cost_center_id,'ALL' all_data,payment_mode,beneficiary_group
                from mis.donation_req_correction drc,(select req_id
                from mis.donation_req_correction
                where case when donation_type in ('RESEARCH EXPENSE','DPGPE','REGION DEVELOPMENT','BRAND RESEARCH SALES') then
                gm_sales_checked_date else gm_msd_checked_date end is not null
                and payment_month = '$request->mon'
                and terr_id not like 'AHV%'
                union all
                select req_id
                from mis.donation_req_correction
                where gm_msd_checked_date is not null
                and payment_month = '$request->mon'
                and terr_id like 'AHV%'
                minus
                select req_id
                from mis.donation_expense_budget) deb
                where drc.req_id = deb.req_id)
                where '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                and approved_amount between '$request->lower_limit' and '$request->upper_limit'
                and gl = '$request->gl'
                and '$request->scc' = case when '$request->scc' = 'ALL' then all_data else to_char(sub_cost_center_id) end
                and '$request->rqid' = case when '$request->rqid' = 'ALL' then all_data else to_char(req_id) end
                and '$request->pay_mode' = case when '$request->pay_mode' = 'ALL' then all_data else payment_mode end
                and '$request->bengroup'= case when '$request->bengroup'= 'ALL' then all_data else beneficiary_group end
                order by req_id
                )where rownum <= '$request->nor'
            ");

            $resp_data = DB::select("

            select md.gl,md.cost_center_id,cost_center_name,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,
                sum(nvl(total_budget,0)) total_budget,
                sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget
                from(
                select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
                from mis.research_expense where expense_month = '$request->mon'
                and cost_center_type = 'CC'
                union all
                select gl,cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
                from mis.donation_req_correction drc,mis.donation_process dp
                where drc.req_id = dp.req_id
                group by gl,cost_center_id
                union all
                select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where deb.req_id = dc.req_id
                and payment_month = '$request->mon'
                group by gl,cost_center_id
                )md,
                (select gl,cost_center_id,cost_center_description cost_center_name
                from mis.donation_cost_center
                where budget_type = 'DONATION') cc
                where md.cost_center_id = cc.cost_center_id
                and md.gl = cc.gl
                having sum(nvl(no_of_req,0)) > 0
                group by md.gl,md.cost_center_id,cost_center_name"
            );

            $dis_sum = DB::select("
                    select summ_id,tr total_no_req,tr_amount apv_amount,tot_cheq_req,tot_cheq_req_amt,tot_cash_req,tot_cash_req_amt,tot_beftn_req,tot_beftn_req_amt
                    from 
                    (select summ_id,
                    sum(case when payment_mode = 'CHEQUE' then 1 else 0 end) tot_cheq_req,
                    sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) tot_cheq_req_amt,
                    sum(case when payment_mode = 'CASH' then 1 else 0 end) tot_cash_req, 
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) tot_cash_req_amt, 
                    sum(case when payment_mode = 'BEFTN' then 1 else 0 end) tot_beftn_req, 
                    sum(case when payment_mode = 'BEFTN' then nvl(approved_amount,0) else 0 end) tot_beftn_req_amt 
                    from mis.donation_req_correction drc,mis.donation_process dp,
                    (select coalesce(max(summ_id), 0)+1 summ_id  from mis.donation_expense_budget)
                    where drc.req_id = dp.req_id group by summ_id),(select count(*) tr,sum(nvl(approved_amount,0)) tr_amount
                    from mis.donation_req_correction drc,mis.donation_process dp     
                    where drc.req_id = dp.req_id)  ");

            return response()->json(['resp_data' => $resp_data, 'dis_sum' => $dis_sum]);


        }
    }

    public function sum_save(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {

            try {

                $insert_proc = DB::INSERT("
        insert into mis.donation_expense_budget(req_id,summ_id,create_date,create_user)
        select drc.req_id,(select coalesce(max(summ_id), 0)+1 from mis.donation_expense_budget) summ_id,sysdate cd,'$uid' us
        from mis.donation_process dp,mis.donation_req_correction drc
        where dp.req_id = drc.req_id
            ");

                $sum_lov = DB::select(" select distinct summ_id from mis.donation_expense_budget where fi_doc_no is null order by summ_id desc ");


            } catch (Oci8Exception $e) {
                $insert_proc = $e->getMessage();
            }

            return response()->json(['insert_proc' => $insert_proc, 'sum_lov' => $sum_lov]);

        }
    }

    public function dis_summary(Request $request)
    {

        if ($request->ajax()) {

            $dis_sum = DB::select(" 
                select summ_id,tr,tr_amount,tot_cheq_req,tot_cheq_req_amt,tot_cash_req,tot_cash_req_amt,tot_beftn_req,tot_beftn_req_amt
                from 
                (select summ_id,sum(case when payment_mode = 'CHEQUE' then 1 else 0 end) tot_cheq_req,
                sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) tot_cheq_req_amt,
                sum(case when payment_mode = 'CASH' then 1 else 0 end) tot_cash_req, 
                sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) tot_cash_req_amt,
                sum(case when payment_mode = 'BEFTN' then 1 else 0 end) tot_beftn_req, 
                sum(case when payment_mode = 'BEFTN' then nvl(approved_amount,0) else 0 end) tot_beftn_req_amt  
                from mis.donation_req_correction drc,mis.donation_expense_budget deb
                where drc.req_id = deb.req_id
                and fi_doc_no is null
                and summ_id = '$request->sumid'
                group by summ_id),(select count(*) tr,sum(nvl(approved_amount,0)) tr_amount
                from mis.donation_req_correction drc,mis.donation_expense_budget deb    
                where drc.req_id = deb.req_id
                and fi_doc_no is null
                and summ_id = '$request->sumid') ");

            return response()->json($dis_sum);

        }
    }

    public function doc_update(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {

            DB::update("
                                update mis.donation_expense_budget
                                set fi_doc_no = '$request->docno',
                                update_user = '$uid',
                                update_date = (select sysdate from dual)
                                where summ_id = '$request->summid'

                                            ");

            return response()->json(['success' => 'Posted Successfully.']);


        }
    }

    public function print_fi_process(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
//        if ($request->ajax()) {

        $fi_val = DB::select("
                    select distinct fi_print from mis.donation_expense_budget
                    where summ_id= '$request->sum_id'
                    ");

        try {


            $result = DB::select("

                       select '$request->sum_id' summ_id,gl,md.cost_center_id,cost_center_name,sum(nvl(no_of_req,0)) no_of_req,
                       sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
                           sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget,
                           company_code,company_name
                    from(
                    select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
                    from mis.research_expense
                    where expense_month = '$request->bgt_month'
                    union all
                    select gl,cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
                    from mis.donation_req_correction drc,mis.donation_process dp
                    where drc.req_id = dp.req_id
                    group by gl,cost_center_id
                    union all
                    select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
                    from mis.donation_expense_budget deb,mis.donation_req_correction dc
                    where deb.req_id = dc.req_id
                    and payment_month = '$request->bgt_month'
                    group by gl,cost_center_id
                    )md,(select distinct cost_center_id,cost_center_description cost_center_name,
                    company_code,company_name
                    from mis.donation_cost_center
                    where budget_type = 'DONATION') cc
                    where md.cost_center_id = cc.cost_center_id
                    having sum(nvl(no_of_req,0)) > 0
                    group by gl,md.cost_center_id,cost_center_name,company_code,company_name
                ");

            $sub_total = DB::select("
            select sum(nvl(no_of_req,0)) tot_nor ,sum(nvl(total_req_amount,0)) total_amt,sum(nvl(total_budget,0)) total_bud,
            sum(nvl(expense_budget,0)) tot_expense,sum(nvl(available_budget,0)) tot_available
            from(
                
            select '$request->sum_id' summ_id,gl,md.cost_center_id,cost_center_name,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
            sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget
            from(
            select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
                    from mis.research_expense
                    where expense_month = '$request->bgt_month'
            union all
            select gl,cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
            from mis.donation_req_correction drc,mis.donation_process dp
            where drc.req_id = dp.req_id
            group by gl,cost_center_id
            union all
            select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
            from mis.donation_expense_budget deb,mis.donation_req_correction dc
            where deb.req_id = dc.req_id
            and payment_month = '$request->bgt_month'
            group by gl,cost_center_id
            )md,
            (select distinct cost_center_id,cost_center_description cost_center_name
            from mis.donation_cost_center
            where budget_type = 'DONATION') cc
            where md.cost_center_id = cc.cost_center_id
            having sum(nvl(no_of_req,0)) > 0
            group by gl,md.cost_center_id,cost_center_name
)
            
            ");


            $dis_sum = DB::select("
                    select summ_id,tr total_no_req,tr_amount apv_amount,tot_cheq_req,tot_cheq_req_amt,tot_cash_req,tot_cash_req_amt,tot_beftn_req,tot_beftn_req_amt
                    from 
                    (select summ_id,sum(case when payment_mode = 'CHEQUE' then 1 else 0 end) tot_cheq_req,
                    sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) tot_cheq_req_amt,
                    sum(case when payment_mode = 'CASH' then 1 else 0 end) tot_cash_req, 
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) tot_cash_req_amt,
                    sum(case when payment_mode = 'BEFTN' then 1 else 0 end) tot_beftn_req, 
                    sum(case when payment_mode = 'BEFTN' then nvl(approved_amount,0) else 0 end) tot_beftn_req_amt 
                    from mis.donation_req_correction drc,mis.donation_process dp,
                    (select coalesce(max(summ_id), 0)+1 summ_id  from mis.donation_expense_budget)
                    where drc.req_id = dp.req_id group by summ_id),(select count(*) tr,sum(nvl(approved_amount,0)) tr_amount
                    from mis.donation_req_correction drc,mis.donation_process dp     
                    where drc.req_id = dp.req_id) 
                                            ");

            DB::update( " update mis.donation_expense_budget
               set fi_print=1
               where summ_id= '$request->sum_id'
               ");


            $data = ['rs_data' => $result, 'fi_val' => $fi_val, 'sub' => $sub_total, 'dis_sum' => $dis_sum];

            if($fi_val[0]->fi_print=='1'){
                $pdf = \PDF::loadView('donation/fi_process_pdf_blank', $data);
                return $pdf->stream('fi_process_pdf_blank.pdf');
            }
            else{
                $pdf = \PDF::loadView('donation/fi_process_pdf', $data);
                return $pdf->setPaper('a4', 'landscape')->stream('fi_process_pdf.pdf');
            }

        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


//        }
    }

    public function print_fi_process_second(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
//        if ($request->ajax()) {

        $fi_val = DB::select("
                    select distinct fi_print from mis.donation_expense_budget
                    where summ_id= '$request->Id_select'
                    ");

//        $short = json_decode($request->bank);

        try {

            $result = DB::select("

                    select '$request->Id_select' summ_id,gl,md.cost_center_id,cost_center_name,
                    sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
                    sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget,
                    company_code,company_name
                    from(
                    select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
                    from mis.research_expense
                    where expense_month = '$request->bgt_month'
                    union all
                    select gl,cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
                    from mis.donation_req_correction drc,mis.donation_expense_budget deb
                    where drc.req_id = deb.req_id
                    and deb.summ_id = '$request->Id_select' 
                    group by gl,cost_center_id
                    union all
                    select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
                    from mis.donation_expense_budget deb,mis.donation_req_correction dc
                    where deb.req_id = dc.req_id
                    and fi_process is not null
                    and payment_month = '$request->bgt_month'
                    group by gl,cost_center_id
                    )md,(select distinct cost_center_id,cost_center_description cost_center_name,company_code,company_name
                    from mis.donation_cost_center
                    where budget_type = 'DONATION') cc
                    where md.cost_center_id = cc.cost_center_id
                    having sum(nvl(no_of_req,0)) > 0
                    group by gl,md.cost_center_id,cost_center_name,company_code,company_name
                ");


            $sub_total = DB::select("
            select sum(nvl(no_of_req,0)) tot_nor ,sum(nvl(total_req_amount,0)) total_amt,sum(nvl(total_budget,0)) total_bud,
            sum(nvl(expense_budget,0)) tot_expense,sum(nvl(available_budget,0)) tot_available
            from
            (
            select '$request->Id_select' summ_id,gl,md.cost_center_id,cost_center_name,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
            sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget
            from(
            select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
                    from mis.research_expense
                    where expense_month = '$request->bgt_month'
            union all
            select gl,cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
            from mis.donation_req_correction drc,mis.donation_expense_budget deb
            where drc.req_id = deb.req_id
            and deb.summ_id = '$request->Id_select' 
            group by gl,cost_center_id
            union all
            select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
            from mis.donation_expense_budget deb,mis.donation_req_correction dc
            where deb.req_id = dc.req_id
            and fi_process is not null
            and payment_month = '$request->bgt_month'
            group by gl,cost_center_id
            )md,(select  distinct cost_center_id,cost_center_description cost_center_name
            from mis.donation_cost_center
            where budget_type = 'DONATION') cc
            where md.cost_center_id = cc.cost_center_id
            having sum(nvl(no_of_req,0)) > 0
            group by gl,md.cost_center_id,cost_center_name 
                                
            )
            
            ");

            $dis_sum = DB::select("
                   select summ_id,tr total_no_req,tr_amount apv_amount,tot_cheq_req,tot_cheq_req_amt,tot_cash_req,tot_cash_req_amt,tot_beftn_req,tot_beftn_req_amt
                    from 
                    (select '$request->Id_select' summ_id ,sum(case when payment_mode = 'CHEQUE' then 1 else 0 end) tot_cheq_req,
                    sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) tot_cheq_req_amt,
                    sum(case when payment_mode = 'CASH' then 1 else 0 end) tot_cash_req, 
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) tot_cash_req_amt,
                    sum(case when payment_mode = 'BEFTN' then 1 else 0 end) tot_beftn_req, 
                    sum(case when payment_mode = 'BEFTN' then nvl(approved_amount,0) else 0 end) tot_beftn_req_amt
                    from mis.donation_req_correction drc,mis.donation_expense_budget dp
                                       
                    where drc.req_id = dp.req_id and summ_id='$request->Id_select' group by summ_id),(select count(*) tr,sum(nvl(approved_amount,0)) tr_amount
                    from mis.donation_req_correction drc,mis.donation_expense_budget dp    
                    where summ_id='$request->Id_select' and  drc.req_id = dp.req_id)
                                            ");

            DB::update(" update mis.donation_expense_budget 
               set fi_print=1 
               where summ_id= '$request->Id_select' 
               ");


//            if(empty($result)){
//              $result = 0;
//            }
//            dd($result);
//            exit;


//            DB::executeProcedure('mis.pro_print_view_payee_list');


            $data = ['rs_data' => $result, 'fi_val' => $fi_val, 'sub' => $sub_total, 'dis_sum' => $dis_sum];
//            $data = ['rs_data' => $result];


//            if($pa_val[0]->print_pl=='1'){
//                $pdf = \PDF::loadView('donation/payee_list', $data);
//                return $pdf->stream('payee_list.pdf');

//            }
//            else{

//                DB::executeProcedure('mis.pro_print_view_payee_list');
//                if (file_exists(storage_path('/donation/payee_list.pdf'))) {
//
//                    unlink(storage_path('donation/payee_list.pdf'));
//
//                }


            $pdf = \PDF::loadView('donation/fi_process_pdf', $data);
            return $pdf->setPaper('a4', 'landscape')->stream('fi_process_pdf.pdf');
//            }


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


//        }
    }

    public function print_fi_process_stp(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
//        if ($request->ajax()) {

        $fi_val = DB::select("
                    select distinct 0 fi_print from mis.donation_expense_budget
                    where summ_id= '$request->Id_select_stp'
                    ");

//        $short = json_decode($request->bank);

        try {

            $result = DB::select("

                    select '$request->Id_select_stp' summ_id,gl,md.cost_center_id,cost_center_name,
                    sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
                    sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget,
                    company_code,company_name
                    from(
                    select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
                    from mis.research_expense
                    where expense_month = '$request->bgt_month'
                    union all
                    select gl,cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
                    from mis.donation_req_correction drc,mis.donation_expense_budget deb
                    where drc.req_id = deb.req_id
                    and deb.summ_id = '$request->Id_select_stp' 
                    group by gl,cost_center_id
                    union all
                    select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
                    from mis.donation_expense_budget deb,mis.donation_req_correction dc
                    where deb.req_id = dc.req_id
                    and fi_process is not null
                    and payment_month = '$request->bgt_month'
                    group by gl,cost_center_id
                    )md,(select distinct cost_center_id,cost_center_description cost_center_name,company_code,company_name from mis.donation_cost_center) cc
                    where md.cost_center_id = cc.cost_center_id
                    having sum(nvl(no_of_req,0)) > 0
                    group by gl,md.cost_center_id,cost_center_name,company_code,company_name  
                ");


            $sub_total = DB::select("
            select sum(nvl(no_of_req,0)) tot_nor ,sum(nvl(total_req_amount,0)) total_amt,sum(nvl(total_budget,0)) total_bud,
            sum(nvl(expense_budget,0)) tot_expense,sum(nvl(available_budget,0)) tot_available
            from
            (
            select '$request->Id_select_stp' summ_id,gl,md.cost_center_id,cost_center_name,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,sum(nvl(total_budget,0)) total_budget,
            sum(nvl(expense_budget,0)) expense_budget,sum(nvl(total_budget,0)) - sum(nvl(expense_budget,0)) available_budget
            from(
            select gl,cost_center_id,0 no_of_req,0 total_req_amount,budget_amt total_budget,0 expense_budget
                    from mis.research_expense
                    where expense_month = '$request->bgt_month'
            union all
            select gl,cost_center_id,count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 total_budget,0 expense_budget
            from mis.donation_req_correction drc,mis.donation_expense_budget deb
            where drc.req_id = deb.req_id
            and deb.summ_id = '$request->Id_select_stp' 
            group by gl,cost_center_id
            union all
            select gl,cost_center_id,0 no_of_req,0 total_req_amount,0 total_budget,sum(nvl(approved_amount,0)) expense_budget
            from mis.donation_expense_budget deb,mis.donation_req_correction dc
            where deb.req_id = dc.req_id
            and fi_process is not null
            and payment_month = '$request->bgt_month'
            group by gl,cost_center_id
            )md,(select distinct cost_center_id,cost_center_description cost_center_name from mis.donation_cost_center) cc
            where md.cost_center_id = cc.cost_center_id
            having sum(nvl(no_of_req,0)) > 0
            group by gl,md.cost_center_id,cost_center_name 
                                
            )
            
            ");

            $dis_sum = DB::select("
                   select summ_id,tr total_no_req,tr_amount apv_amount,tot_cheq_req,tot_cheq_req_amt,tot_cash_req,tot_cash_req_amt,tot_beftn_req,tot_beftn_req_amt
                    from 
                    (select '$request->Id_select_stp' summ_id ,sum(case when payment_mode = 'CHEQUE' then 1 else 0 end) tot_cheq_req,
                    sum(case when payment_mode = 'CHEQUE' then nvl(approved_amount,0) else 0 end) tot_cheq_req_amt,
                    sum(case when payment_mode = 'CASH' then 1 else 0 end) tot_cash_req, 
                    sum(case when payment_mode = 'CASH' then nvl(approved_amount,0) else 0 end) tot_cash_req_amt,
                    sum(case when payment_mode = 'BEFTN' then 1 else 0 end) tot_beftn_req, 
                    sum(case when payment_mode = 'BEFTN' then nvl(approved_amount,0) else 0 end) tot_beftn_req_amt 
                    from mis.donation_req_correction drc,mis.donation_expense_budget dp
                                       
                    where drc.req_id = dp.req_id and summ_id='$request->Id_select_stp' group by summ_id),(select count(*) tr,sum(nvl(approved_amount,0)) tr_amount
                    from mis.donation_req_correction drc,mis.donation_expense_budget dp    
                    where summ_id='$request->Id_select_stp' and  drc.req_id = dp.req_id)
                                            ");

//            DB::update(" update mis.donation_expense_budget
//               set fi_print=1
//               where summ_id= '$request->Id_select'
//               ");


//            if(empty($result)){
//              $result = 0;
//            }
//            dd($result);
//            exit;


//            DB::executeProcedure('mis.pro_print_view_payee_list');


            $data = ['rs_data' => $result, 'fi_val' => $fi_val, 'sub' => $sub_total, 'dis_sum' => $dis_sum];
//            $data = ['rs_data' => $result];


//            if($pa_val[0]->print_pl=='1'){
//                $pdf = \PDF::loadView('donation/payee_list', $data);
//                return $pdf->stream('payee_list.pdf');

//            }
//            else{

//                DB::executeProcedure('mis.pro_print_view_payee_list');
//                if (file_exists(storage_path('/donation/payee_list.pdf'))) {
//
//                    unlink(storage_path('donation/payee_list.pdf'));
//
//                }


            $pdf = \PDF::loadView('donation/fi_process_pdf', $data);
            return $pdf->setPaper('a4', 'landscape')->stream('fi_process_pdf.pdf');
//            }


        } catch (Oci8Exception $e) {
            $result = $e->getMessage();
        }
        return response()->json($result);


//        }
    }

    public function sum_delete(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {

            $insert_action = DB::insert("
                            INSERT INTO DONATION_EXPENSE_BUDGET_DELETE 
                            
                            SELECT deb.*,'$uid',sysdate FROM DONATION_EXPENSE_BUDGET  deb
                            
                            WHERE SUMM_ID = '$request->summid'

                                            ");

            if($insert_action){

                $delete_action = DB::delete(" delete from DONATION_EXPENSE_BUDGET   WHERE SUMM_ID = '$request->summid'   ");
                    return response()->json(['success' => 'Deleted Successfully.']);
            };




        }
    }



}