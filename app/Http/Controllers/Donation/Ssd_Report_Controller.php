<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 14-Feb-19
 * Time: 12:28 PM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

//Request $request

class Ssd_Report_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


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
                            select distinct  gl||'-'||main_cost_center_name gl
                            from mis.donation_type_master
                            union all                      
                            select '52010085'||'-'||'SALES' gl
                            from dual
                            union all                      
                            select '52011200'||'-'||'SALES' gl
                            from dual
                            union all 
                            select '15940040'||'-'||'SALES' gl
                            from dual
                            union all 
                            select '15940040'||'-'||'MSD' gl
                            from dual
                              ");

            $cc = DB::select("
                        select cost_center_id,sub_cost_center_id,sub_cost_center_name from mis.donation_sub_cost_center
        union all
        select cost_center_id,to_number('') sub_cost_center_id,cost_center_description
        from mis.donation_cost_center
        where budget_type = 'DONATION'

                              ");

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            $dtm = DB::select("select type_name ,gl,main_cost_center_name,
                          type,type_name||case when main_cost_center_name = 'MSD' then ' (MARKETING)' else ' ('||main_cost_center_name||')'  end type_mct
                            from mis.donation_type_master");

            return view('donation.ssd_report')->with(['month_name' => $month_name, 'gl' => $gl, 'cc' => $cc, 'rm_terr' => $rm_terr, 'dtm' => $dtm]);

        }


    }

    public function am_fetch_ssd(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                    and am_terr_id not like '%-500%'
                                    order by am_terr_id");

        }

        return response()->json($resp_data);
    }

    public function mpo_fetch_ssd(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            if ($request->amTerr == 'ALL') {

                $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.emp_month = trunc(sysdate,'MM')                                    
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");


            } else {


                $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.am_terr_id =    '$request->amTerr'
                                    and tl.emp_month = trunc(sysdate,'MM')                                    
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            }


            return response()->json($resp_data);
        }
    }

    public function ccwiswe_req_data(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());


            DB::delete("delete from mis.donation_process_ssd where user_id =  '$uid'  ");

            DB::insert("
                        insert into mis.donation_process_ssd
                        select distinct req_id,'$uid'
                        from(
                        select  '$request->mon' budget_month,'ALL' all_data,dc.gl||'-'||main_cost_center_name mccn,donation_type,
                                case when sub_cost_center_id is null then
                                cost_center_id else sub_cost_center_id end cost_center_id,0 total_budget,0 expense_budget,terr_id,
                                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1)am_terr_id,
                                substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,req_id
                        from mis.donation_req_correction dc,mis.donation_type_master dtm
                        where case when length(terr_id) >= 7 then sm_checked_date else case when (terr_id like 'MABS%' or terr_id like 'G1%' or terr_id like 'G2%' or terr_id like 'G3%') then sm_checked_date else dsm_checked_date end end is not null 
                        and ssd_checked_date is null
                        and payment_month = '$request->mon'
                        and dc.donation_type = dtm.type_name
                        and case when main_cost_center_name = 'MSD' then be_checked_date else rm_checked_date end is not null
                        and substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rmTerrId'
                        )where '$request->amTerr' = case when '$request->amTerr' = 'ALL' then all_data else am_terr_id end
                        and '$request->mpoId' = case when '$request->mpoId' = 'ALL' then all_data else terr_id end
                        and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else mccn end
                        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
                        and '$request->don_type' = case when '$request->don_type' =  'ALL' then all_data else donation_type end
                    ");

            $resp_data = DB::select("
                 
                
                select budget_month,dd.gl,dd.cost_center_id,cost_center_name,sum(nvl(no_of_req,0)) no_of_req,
                sum(nvl(total_req_amount,0)) total_req_amount,budget_amt total_budget,
                sum(nvl(expense_budget,0)) expense_budget,budget_amt-sum(nvl(expense_budget,0))  available_budget,department
                from
                (select  payment_month budget_month,gl,case when sub_cost_center_id is null then
                cost_center_id else sub_cost_center_id end cost_center_id,count(*) no_of_req,
                sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget
                from mis.donation_req_correction drc,mis.donation_process_ssd dp
                where drc.req_id = dp.req_id
                and dp.user_id = '$uid'
                group by payment_month,gl,case when sub_cost_center_id is null then cost_center_id else sub_cost_center_id end
                union all
                select budget_month,gl,cost_center_id,no_of_req,total_req_amount,expense_budget
                from
                (select budget_month,dcc.gl,dcc.cost_center_id,no_of_req,total_req_amount,expense_budget
                from
                (select payment_month budget_month,gl,case when sub_cost_center_id is null then cost_center_id else sub_cost_center_id end cost_center_id,
                0 no_of_req,0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget
                from mis.donation_req_correction
                where  ssd_checked_date is not null
                and payment_month = '$request->mon'
                group by payment_month,gl, case when sub_cost_center_id is null then cost_center_id else sub_cost_center_id end
                ) drc,(select distinct gl,case when sub_cost_center_id is null then
                cost_center_id else sub_cost_center_id end cost_center_id  
                from mis.donation_req_correction drc,mis.donation_process_ssd dp
                where drc.req_id = dp.req_id
                and dp.user_id = '$uid' ) dcc                                                           
                where drc.gl = dcc.gl
                and drc.cost_center_id = dcc.cost_center_id)
                ) dd,(select ccn.gl,ccn.cost_center_id,cost_center_name,department,budget_amt
                from (select expense_month,gl,cost_center_id,budget_amt from mis.research_expense 
                where expense_month = '$request->mon') re,(select gl,sub_cost_center_id cost_center_id,sub_cost_center_name cost_center_name,department
                          from mis.donation_sub_cost_center dscc, donation_cost_center dcc
                          where dscc.cost_center_id = dcc.cost_center_id
                          union all select gl,cost_center_id,cost_center_description cost_center_name,department
                          from mis.donation_cost_center where budget_type = 'DONATION') ccn 
                where re.gl(+) = ccn.gl 
                and re.cost_center_id(+) = ccn.cost_center_id) ccbd
                where dd.gl = ccbd.gl
                and dd.cost_center_id = ccbd.cost_center_id
                group by budget_month,dd.gl,dd.cost_center_id,cost_center_name,budget_amt,department



 ");

            return response()->json($resp_data);

        }
    }

    public function detail_table_fetch(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());

            $resp_data = DB::select("
select req_id,req_date,terr_id,drc.doctor_id,doctor_name,in_favour_of,mode_of_Payment,Approved_Amount,payment_month,to_char(ssd_due_date,'DD-Mon-RR') ssd_due_date,
       gl,cost_center_id,acp,acmp,acyp,frequency,dsm_checked_date,sm_checked_date ,  mas.beneficiary_name beneficiaryname , beneficiary_bank_account_name 
from
(select gl,case when sub_cost_center_id is null then cost_center_id else sub_cost_center_id end cost_center_id,
        drc.req_id,req_date,doctor_id,doctor_name,in_favour_of,payment_mode Mode_of_Payment,payment_month,
        ssd_payment_date ssd_due_date,nvl(approved_amount,0) approved_amount,terr_id,frequency,dsm_checked_date,sm_checked_date                
from mis.donation_req_correction drc,mis.donation_process_ssd dps
where drc.req_id = dps.req_id
and dps.user_id = '$uid'
and gl = '$request->gl'
and case when sub_cost_center_id is null then cost_center_id else sub_cost_center_id end = '$request->cc') drc,
(select doctor_id,sum(nvl(approved_amount,0)) acp --Amount Current Process
from mis.donation_req_correction
where ssd_checked_date is null
and payment_month = '$request->mon'
group by doctor_id) dca,(select doctor_id,sum(nvl(approved_amount,0)) acmp  --Amount Current Month Process
                         from mis.donation_req_correction
                         where ssd_checked_date is not null
                         and payment_month = '$request->mon' group by doctor_id) dcma,
(select doctor_id,sum(nvl(approved_amount,0)) acyp  --Amount Current Year Process
from mis.donation_req_correction
where ssd_checked_date is not null
and substr(payment_month,-2) = substr('$request->mon',-2) group by doctor_id) dcaa , mis.donation_beftn_master mas
where drc.doctor_id = dca.doctor_id(+)
and drc.doctor_id = dcma.doctor_id(+)
and drc.doctor_id = dcaa.doctor_id(+) 
and mas.territory_code(+) = drc.terr_id
and mas.beneficiary_id(+)= drc.doctor_id
");


            return response()->json($resp_data);

        }
    }

    public function bengroup_update(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        if ($request->ajax()) {

            $verinfo = json_decode($request->insertdata);

            try {

                foreach ($verinfo as $data) {

                    $insert = DB::insert("
                        update mis.donation_req_correction set 
                        beneficiary_group= '$request->bengroup'
                        where req_id = '$data->req_id'
                    ");
                }

                if ($insert) {
                    return response()->json(['success' => 'Updated Successfully']);
                } else {
                    return response()->json(['error' => 'Failed to update data']);
                }

            } catch (Oci8Exception $e) {
                return response()->json(['error' => 'Failed to update data']);
            }


        }


    }

    public function verify_ssd(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $verinfo = json_decode($request->verifyData);


//            if (Auth::user()->desig === 'HO') {
//                foreach ($request->verifyData as $data) {
//
//                    DB::UPDATE("
//                        update mis.donation_req_correction
//                        set ssd_emp_id='$uid',
//                        ssd_name='$uname',
//                        ssd_checked_date= (select sysdate from dual)
//                        ssd_payment_date= to_date(?,'dd/mm/yyyy')
//                        where req_id=?
//                    ", [$data['ssd_due_date'], $data['req_id']]);
//                }
//            }

            if (Auth::user()->desig === 'HO') {
                foreach ($verinfo as $data) {

                    DB::UPDATE("
                        update mis.donation_req_correction 
                        set ssd_emp_id='$uid',
                        ssd_name='$uname',
                        ssd_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }


            return response()->json(['success' => 'Research Expense verified Successfully.']);
        }


    }

    public function infavor_update_ssd(Request $request)
    {

        $update_action = DB::update("   
   
                update mis.donation_req_correction set 
                                
                in_favour_of= upper('$request->newValue')
                where req_id = '$request->req_id' 
                ");

        return response()->json($update_action);


    }

    public function docname_update_ssd(Request $request)
    {
        $update_action = DB::update("   
   
                update mis.donation_req_correction set 
                                
                doctor_name= upper('$request->newValue')
                where req_id = '$request->req_id' 
                ");

        return response()->json($update_action);

    }

    /*-----------Pay List Report Selection View----------*/
    public function pay_list_view()
    {
        return view('donation.pay_list');
    }

    /*-----------Pay List Report Selection Data-----------*/
    public function selection_date(Request $request)
    {
        $terr = Auth::user()->terr_id;
        if ($request->ajax()) {
            $dates = null;
            $ref_no = null;
            $region = null;
            $sid = null;

            if ($request->date && !$request->sid) {

                $sid = DB::select('select distinct summ_id  
                                    from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                    where deb.req_id = dc.req_id
                                    and payment_month = ?
                                    and ref_no is not null
                                    order by summ_id desc', [$request->date]);

            } else if ($request->sid && $request->date) {

                if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
                    $ref_no = DB::select('select distinct ref_no  
                                     from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                     where deb.req_id = dc.req_id
                                     and payment_month = ?
                                     and summ_id = ?
                                     and substr(terr_id,1,instr(terr_id,\'-\'))||\'00\' = ?
                                     and ref_no is not null
                                     order by ref_no
                                     ', [$request->date, $request->sid, $terr]);
                } else {
                    $ref_no = DB::select('select distinct ref_no  
                                     from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                     where deb.req_id = dc.req_id
                                     and payment_month = ?
                                     and summ_id = ?
                                     and ref_no is not null
                                     order by ref_no
                                     ', [$request->date, $request->sid]);
                }

            } else if ($request->refno) {
                if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

                    $region = DB::select("select distinct substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id  
                                        from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                        where deb.req_id = dc.req_id
                                        and ref_no = ?
                                         and substr(terr_id,1,instr(terr_id,'-'))||'00' = ?
                                        order by substr(terr_id,1,instr(terr_id,'-'))||'00'
                                        ", [$request->refno, $terr]);
                } else {
                    $region = DB::select("select distinct substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id  
                                        from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                        where deb.req_id = dc.req_id
                                        and ref_no = ?
                                        order by substr(terr_id,1,instr(terr_id,'-'))||'00'
                                        ", [$request->refno]);
                }


            } else {
                $dates = DB::select("
                                select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') vdate
                                from
                                (
                                with data as (select level l from dual connect by level <= 20)
                                    select *
                                      from (select trunc(add_months(sysdate, -19)) dt from dual), data
                                     order by dt, l
                                )");
            }

            if ($sid) {
                return response()->json(['sid' => $sid]);
            } else if ($ref_no) {
                return response()->json(['ref_no' => $ref_no]);
            } else if ($region) {
                return response()->json(['region' => $region]);
            } else {
                return response()->json(['dates' => $dates, 'ref_no' => null, 'region' => null]);
            }
        }
    }

    /*-------------Pay List Report Output---------------*/
    public function print_paylist(Request $request)
    {

        //main query data all region
        $rdata = DB::select("select ref_no,sl,in_favour_of,amount,dtype,brand_region,terr_id,rm_terr_id,d_name
                                from(
                                select 'ALL' all_data,ref_no,sl,in_favour_of,approved_amount amount,donation_type dtype,
                                       substr(GROUP_BRAND_REGION_NAME,0,instr(GROUP_BRAND_REGION_NAME,'(')-1) brand_region,
                                        terr_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,d_name  
                                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                where deb.req_id = dc.req_id
                                and ref_no = ?
                                ) where ? = case when ? = 'ALL' then all_data else rm_terr_id end 
                                order by sl
                                ", [$request->refno, $request->region, $request->region,]);

        //distinct region for loop condition
        $dregion = DB::select("select distinct rm_terr_id
                                from(
                                select 'ALL' all_data,ref_no,sl,in_favour_of,approved_amount amount,
                                        terr_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id  
                                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                where deb.req_id = dc.req_id
                                and ref_no = ?
                                ) where ? = case when ? = 'ALL' then all_data else rm_terr_id end
                                order by rm_terr_id
                                ", [$request->refno, $request->region, $request->region]);


        $pdf = \PDF::loadView('donation.pay_list_report', ['rdata' => $rdata, 'dregion' => $dregion]);

        if ($request->atype === 'dl') {
            //download without stream
            return $pdf->setPaper('a4', 'potrait')
                ->download('Paylist.pdf');
        } else {
            //stream/display in browser
            return $pdf->setPaper('a4', 'potrait')
                ->stream('Paylist.pdf');
        }

    }


    /*-----------Doc wise Donation Selection View----------*/


    public function doc_wise_view()
    {


        // if(Auth::user()->desig ==='All'||Auth::user()->desig ==='HO'){

        $month_name = DB::select("
                                 select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                    with data as (select level l from dual connect by level <= 5)
                                    select *
                                    from (select trunc(add_months(sysdate, -4)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        return view('donation.doc_wise_donation')->with(['month_name' => $month_name]);
        // }
    }


    /*-----------Doc wise Donation Report output----------*/

    public function doc_wise_donation(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());

            $resp_data = DB::select("

                            select 
                            *
                            FROM
                            (select 'ALL' all_data,drc.req_id,terr_id,emp_id,emp_name,doctor_id,doctor_name,donation_type,payment_mode,frequency,payment_month,in_favour_of,
                            approved_amount,group_brand_region_name,am_checked_date,rm_checked_date,
                            be_checked_date,
                            dsm_checked_date,
                            sm_checked_date,
                            ssd_checked_date,
                            group_head_checked_date,
                            gm_sales_checked_date,
                            gm_msd_checked_date,ref_no,summ_id
                            from mis.donation_req_correction drc,mis.donation_expense_budget deb 
                            where drc.req_id = deb.req_id(+) 
                            )
                            
                            WHERE
                            '$request->mont' = case when '$request->mont' = 'ALL' then all_data else payment_month end
                            and doctor_id = '$request->doctor'
                            order by req_id desc 


");


            return response()->json($resp_data);

        }
    }

    /*-----------Infavor Of Correction View----------*/
    public function infavor_correction_view()
    {

        // if(Auth::user()->desig ==='All'||Auth::user()->desig ==='HO'){

        $month_name = DB::select("
                                    select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                    with data as (select level l from dual connect by level <= 2)
                                    select *
                                    from (select trunc(add_months(sysdate, -1)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        return view('donation.infavor_correction')->with(['month_name' => $month_name]);
        // }
    }

    /*-----------Infavor Of Correction data----------*/

    public function infavor_correction(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());

            $resp_data = DB::select("

                    select 
                    *
                    FROM
                    (select beneficiary_group,'ALL' all_data,drc.req_id,terr_id,emp_id,emp_name,doctor_id,doctor_name,in_favour_of,donation_type,payment_mode,frequency,payment_month,
                    approved_amount,group_brand_region_name,am_checked_date,rm_checked_date,
                    be_checked_date,
                    dsm_checked_date,
                    sm_checked_date,
                    ssd_checked_date,
                    group_head_checked_date,
                    gm_sales_checked_date,
                    gm_msd_checked_date,ref_no,summ_id
                    from mis.donation_req_correction drc,mis.donation_expense_budget deb 
                    where drc.req_id = deb.req_id(+) 
                    )
                    
                    WHERE
                    
                    req_id = '$request->doctor'
              
");

            $result = DB::SELECT("select * from mis.donation_beftn_master 
    where beneficiary_id||territory_code in (select doctor_id||terr_id from mis.donation_req_correction where req_id = '$request->doctor' )");

//            return response()->json($resp_data);

            if(count($result) > 0){
                return response()->json(['exists'=>1, 'resp_data' => $resp_data]);
            }else{
                return response()->json(['exists'=>0, 'resp_data' => $resp_data]);
            }

//            return response()->json($resp_data);

        }
    }

    /*-----------Infavor Of Update----------*/

    public function infavor_update(Request $request)
    {

        $update_action = DB::update("   
   
                update mis.donation_req_correction set 
                                
                in_favour_of= upper('$request->inf_of')
                where req_id = '$request->req_no' 
                and req_id not in ( select req_id from mis.donation_expense_budget)
                ");

        return response()->json($update_action);


    }

    public function doctor_name_update(Request $request)
    {

        $update_action = DB::update("   
   
                update mis.donation_req_correction set 
                                
                doctor_name= upper('$request->doctor_name')
                where req_id = '$request->req_no' 
                and req_id not in ( select req_id from mis.donation_expense_budget)
                ");

        return response()->json($update_action);


    }

    public function pay_mode_update(Request $request)
    {

        $update_action = DB::update("   
   
                update mis.donation_req_correction set 
                                
                payment_mode= '$request->pay_mode'
                where req_id = '$request->req_no' 
               and req_id not in ( select req_id from mis.donation_expense_budget)
                ");

        return response()->json($update_action);


    }

    public function pay_month_update(Request $request)
    {

        $update_action = DB::update("   
   
                update mis.donation_req_correction set 
                                
                payment_month= '$request->pay_month'
                where req_id = '$request->req_no' 
                and req_id not in ( select req_id from mis.donation_expense_budget)
                ");

        return response()->json($update_action);


    }

    public function update_bengroup(Request $request)
    {

        $update_action = DB::update(" 
 
                    update mis.donation_req_correction set 
                    beneficiary_group= '$request->bengroup'
                    where req_id = '$request->req_no' 
                    and req_id not in ( select req_id from mis.donation_expense_budget) 
   
                ");

        return response()->json($update_action);


    }

    public function ssd_check_date_remove(Request $request)
    {

        $update_action = DB::update("   
   
                update MIS.DONATION_REQ_CORRECTION
                set ssd_checked_date = '' ,GROUP_HEAD_CHECKED_DATE = '', GM_SALES_CHECKED_DATE = '',GM_MSD_CHECKED_DATE = ''
                where req_id = '$request->req_no' 
                and req_id not in ( select req_id from mis.donation_expense_budget)

                ");

        return response()->json($update_action);


    }


    /*-----------Pay List Report depot wise Selection View----------*/
    public function pay_list_view_dw()
    {
        return view('donation.pay_list_dwise');
    }

    /*-------------Pay List Report depot_wise Output---------------*/
    public function print_paylist_dw(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        //main query data all region
        $rdata = DB::select("select summ_id,ref_no,sl,in_favour_of,amount,dtype,brand_region,terr_id,rm_terr_id,am_name,d_name,d_id,cd,doctor_id
                                from(
                                select 'ALL' all_data,summ_id,ref_no,sl,in_favour_of,approved_amount amount,donation_type dtype,
                                       substr(GROUP_BRAND_REGION_NAME,0,instr(GROUP_BRAND_REGION_NAME,'(')-1) brand_region,to_char(update_date, 'DD-MON-YY hh12:mi:ss AM') cd,doctor_id,
                                        terr_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,am_name,d_name,dc.d_id   
                                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                                where deb.req_id = dc.req_id
                                and summ_id = ?  
                                and ref_no = ?
                                ) where ? = case when ? = 'ALL' then all_data else rm_terr_id end 
                                order by sl
                                ", [$request->summid, $request->refno, $request->region, $request->region]);

        //distinct region for loop condition
        $did = DB::select("
                select d_id,rm_terr_id
                from(
                select 'ALL' all_data,
                terr_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,dc.d_id
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where deb.req_id = dc.req_id
                and summ_id = '$request->summid'
                and ref_no = '$request->refno'
                 order by sl
                )
                where '$request->region' = case when '$request->region' = 'ALL' then all_data else rm_terr_id end

        "
        );

        $count = DB::select("
                select d_id,rm_terr_id
                , count(*) total_request
                from(
                select
                terr_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,dc.d_id
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where deb.req_id = dc.req_id
                and summ_id = '$request->summid'
                and ref_no = '$request->refno'
                )
                group by d_id,rm_terr_id
        "
        );

        $collection = new Collection($did);

        $pdf = \PDF::loadView('donation.pay_list_dwise_report', ['rdata' => $rdata, 'count' => $count, 'depots' => $collection->unique()]);

        if ($request->atype === 'dl') {
            //download without stream
            return $pdf->setPaper('a4', 'landscape')
                ->download('PayListDepotWise.pdf');
        } else {
            //stream/display in browser
            return $pdf->setPaper('a4', 'landscape')
                ->stream('PayListDepotWise.pdf');
        }

    }


}