<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 3/5/2019
 * Time: 11:05 AM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Am_Gm_Approval_Controller extends Controller
{

    public function index()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {

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


        $gl = DB::select(" select gl,main_cost_center_name,gl||main_cost_center_name gl_cat
        from(
        select distinct gl,'MSD' main_cost_center_name
        from mis.donation_cost_center
        where gl =  '52010080'
        union all
        select distinct gl,'SALES' main_cost_center_name
        from mis.donation_cost_center
        where gl =  '52010080'
        union all
        select distinct gl,case when gl = 52010085 then 'ASSOCIATION' else 'CHEMIST' end main_cost_center_name
        from mis.donation_cost_center
         where gl not in  ( '52010080', '15940040')
        and budget_type = 'DONATION'
        )
                              ");

        $cc = DB::select("
                    select distinct cost_center_id,sub_cost_center_id,sub_cost_center_name from mis.donation_sub_cost_center
                    union all
                    select distinct cost_center_id,to_number('') sub_cost_center_id,cost_center_description
                    from mis.donation_cost_center where budget_type = 'DONATION'

                              ");

        $dtm = DB::select("
                        select type_name ,gl,main_cost_center_name,
                        type,type_name||'(' ||main_cost_center_name||')'  type_mct
                        from mis.donation_type_master 
                        ");


        $rm_terr = DB::select("
            select rm_terr_id
            from mis.rm_gm_info
            where rm_terr_id not in ('OO-00','HYGH-00') order by rm_terr_id
                                ");


        return view('donation.am_gm_approval')->with(['month_name' => $month_name, 'gl' => $gl, 'cc' => $cc, 'dtm' => $dtm, 'rm_terr' => $rm_terr]);

//        }


    }


//    public function get_don_type(Request $request)
//    {
//
//        $resp_data  = DB::Select("
//                        select type_name ,gl,main_cost_center_name,
//                        type, type_mct
//                        from(select 'ALL' all_data,type_name ,gl,main_cost_center_name,
//                        type,type_name||'(' ||main_cost_center_name||')'  type_mct
//                        from mis.donation_type_master)
//                        where '$request->glname' = case when '$request->glname' = 'ALL' then all_data else main_cost_center_name end
//                                    ");
//
//
//        return response()->json($resp_data);
//    }

    public function get_cc(Request $request)
    {

        $resp_data = DB::Select("
                                    select distinct cost_center_id,cost_center_description
                                    from(
                                    select 'ALL' all_data,cost_center_id,cost_center_description,department
                                    from mis.donation_cost_center
                                    where budget_type = 'DONATION'
                                    )where '$request->glname' = case when '$request->glname' = 'ALL' then all_data else department end 
                                      order by cost_center_id
                                    ");


        return response()->json($resp_data);
    }


    public function get_scc(Request $request)
    {

        $resp_data = DB::Select("
                                select DISTINCT sub_cost_center_id,sub_cost_center_name
from(
select 'ALL' all_data,dcc.cost_center_id,sub_cost_center_id,sub_cost_center_name
from mis.donation_cost_center dcc, mis.donation_sub_cost_center dscc
where dcc.cost_center_id = dscc.cost_center_id
and budget_type = 'DONATION' 
)where '$request->ccid' = case when '$request->ccid' = 'ALL' then all_data else to_char(cost_center_id) end
and ('$request->glval'='MSD' or '$request->glval'='ALL')  
order by sub_cost_center_id
                                    
                                    ");


        return response()->json($resp_data);
    }


    public function ccwiswe_req_data(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        if ($request->ajax()) {
//            return response()->json($request->all());

            if ($request->low_limit != '') {

                $resp_data = DB::select("

      select all_data,budget_month,cc.gl,case when '$request->scc' = 'ALL' then to_char(ed.cost_center_id) else to_char(ed.sub_cost_center_id) end cost_center_id,
        cost_center_name,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,
        total_budget,sum(nvl(expense_budget,0)) expense_budget,total_budget - sum(nvl(expense_budget,0)) available_budget
        from(
        select all_data,dd.budget_month,dd.gl,dd.cost_center_id,dd.sub_cost_center_id,no_of_req,total_req_amount,
        total_budget,expense_budget,nvl(total_budget,0)- nvl(expense_budget,0) available_budget,gl_type,region,donation_type,approved_amount,
       case when dd.gl in (52010085,15940040) and beneficiary_type = 'ASSOCIATION' then 'ASSOCIATION' else 
        case when  dd.gl in (52011200,15940040) and beneficiary_type = 'CHEMIST' then 'CHEMIST' else
        case when dd.gl in (52010080,15940040) and gl_type = 'SALES' then 'SALES' else
        case when dd.gl in (52010080,15940040) and gl_type = 'MSD' then 'MSD' else null end end end end gl_category      
        from
        (select 'ALL' all_data,budget_month,drc.gl,drc.cost_center_id,drc.sub_cost_center_id,no_of_req,total_req_amount,expense_budget,
        drc.cost_center_id||drc.sub_cost_center_id dcc_scc,gl_type,region,donation_type,approved_amount,beneficiary_type
        from
        (select emp_type,budget_month,gl,cost_center_id,sub_cost_center_id,region,donation_type,approved_amount,
        sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,
        sum(nvl(expense_budget,0)) expense_budget,main_cost_center_name gl_type,beneficiary_type
        from(  
        select 'GROUP_HEAD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon'
        and ssd_checked_date is not null and group_head_checked_date is null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all
        select 'GM_SALES' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,count(*) no_of_req,
        sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and payment_month = '$request->mon'
        and case when main_cost_center_name = 'MSD' then group_head_checked_date  else ssd_checked_date end is not null and terr_id not like 'AHV%'
        and ssd_checked_date is not null and gm_sales_checked_date is null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all
        select 'GM_MSD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,count(*) no_of_req,
        sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon' and ssd_checked_date is not null
        and gm_sales_checked_date is not null and gm_msd_checked_date is null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all  -- Animal Health
        select 'GM_SALES' emp_type,payment_month budget_month,gl,cost_center_id,sub_cost_center_id,count(*) no_of_req,
        sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,'SALES' main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount ,beneficiary_type
        from mis.donation_req_correction
        where payment_month = '$request->mon' and terr_id like 'AHV%'
        and ssd_checked_date is not null and gm_msd_checked_date is null
        group by payment_month,gl,cost_center_id,sub_cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all       
        select 'GROUP_HEAD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,0 no_of_req,
        0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type ,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon'
        and group_head_checked_date is not null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount ,beneficiary_type   
        union all        
        select 'GM_SALES' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        0 no_of_req,0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type       
        from mis.donation_req_correction drc,mis.donation_type_master dtm 
        where drc.donation_type = dtm.type_name  
        and payment_month = '$request->mon' and gm_sales_checked_date is not null
        and terr_id not like 'AHV%' 
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all        
        select 'GM_MSD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        0 no_of_req,0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount ,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon' and gm_msd_checked_date is not null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type        
        union all --Animal Health
        select 'GM_SALES' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        0 no_of_req,0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,'SALES' main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount ,beneficiary_type
        from mis.donation_req_correction drc
        where payment_month = '$request->mon' and gm_msd_checked_date is not null and terr_id like 'AHV%'
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        )group by emp_type,budget_month,gl,cost_center_id,sub_cost_center_id,main_cost_center_name,region,donation_type,approved_amount,beneficiary_type
        )drc,
        (select distinct p_type,gl,cost_center_id,cost_center_name,sub_cost_center_id,sub_cost_center_name,responsible_emp_id,responsible_emp_name
        from( 
        select distinct 'GROUP_HEAD' p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,sub_cost_center_id,sub_cost_center_name,
        dscc.responsible_emp_id,dscc.responsible_emp_name
        from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
        where dcc.cost_center_id = dscc.cost_center_id 
        and budget_type = 'DONATION' 
        union all
        select distinct 'GM_'||department p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
        sub_cost_center_id,sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
        from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
        where dcc.cost_center_id = dscc.cost_center_id
        and budget_type = 'DONATION'
        and department = 'MSD' 
        union all
        
          select distinct 'GM_'||department p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
            case when sub_cost_center_id is null then null else sub_cost_center_id end sub_cost_center_id, 
            case when sub_cost_center_id is null then null else sub_cost_center_name end sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
            from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
            where  dcc.cost_center_id = dscc.cost_center_id(+)
            and department = 'SALES'
            and budget_type = 'DONATION'
            
              union all
            select distinct 'GM_'||department p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
            null sub_cost_center_id,null sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
            from mis.donation_cost_center dcc
            where  department = 'SALES'
            and budget_type = 'DONATION' 
        
        union all
        select distinct 'GM_SALES' p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
                sub_cost_center_id,sub_cost_center_name,case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
                then 1000353 else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 1000001 else 1000298 end end responsible_emp_id,
                case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
                then 'Kh. Mainul Islam' else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 
                'EHSAN AZIZ'  else 'ASHRAF UDDIN AHMED' end  end responsible_emp_name
                from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                where dcc.cost_center_id = dscc.cost_center_id
                and budget_type = 'DONATION'
                and department = 'MSD'
                        )where responsible_emp_id = '$uid') emp_cc 
        where drc.emp_type =  emp_cc.p_type
        and drc.gl = emp_cc.gl
        and drc.cost_center_id||drc.sub_cost_center_id = emp_cc.cost_center_id||emp_cc.sub_cost_center_id) dd,
        (select expense_month budget_month,gl,cost_center_id main_cost_center_id,budget_amt total_budget,
        null sub_cost_center_id,cost_center_id||null bcc_scc
        from mis.research_expense where expense_month = '$request->mon'
        and cost_center_type = 'CC' ) bd
        where dd.gl = bd.gl(+)
        and dd.cost_center_id = bd.main_cost_center_id(+))ed,(select gl,cost_center_id,cost_center_description cost_center_name
        from mis.donation_cost_center where budget_type = 'DONATION'
        union all
        select gl,sub_cost_center_id cost_center_id,sub_cost_center_name cost_center_name 
        from mis.donation_cost_center dcc, mis.donation_sub_cost_center dscc
        where dcc.cost_center_id = dscc.cost_center_id) cc
        where ed.gl = cc.gl 
        and case when '$request->scc' = 'ALL' then to_char(ed.cost_center_id) else to_char(ed.sub_cost_center_id) end = cc.cost_center_id
        and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(ed.gl_category) end
        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(ed.cost_center_id) end
        and '$request->scc' = case when '$request->scc' = 'ALL' then all_data else to_char(ed.sub_cost_center_id) end
        and '$request->don_type' = case when '$request->don_type' = 'ALL' then all_data else donation_type end
        and '$request->region' = case when '$request->region' = 'ALL' then all_data else region end  
        and approved_amount between '$request->low_limit' and '$request->upper_limit'
        Group by all_data,budget_month,cc.gl,cost_center_name,total_budget,
        case when '$request->scc' = 'ALL' then to_char(ed.cost_center_id) else to_char(ed.sub_cost_center_id) end

    

");

                $second_table = DB::select("  
                                                            
select all_data,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,acp,acmp,acyp,gl,ssd_payment_date,frequency,group_brand_region_name,donation_type,
case when '$request->scc' = 'ALL' then to_char(cost_center_id) else to_char(sub_cost_center_id) end cost_center_id
from(
select 'ALL' all_data,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,drd.cost_center_id,drd.sub_cost_center_id,acp,acmp,acyp,gl,ssd_payment_date,gl_type,frequency,
region,donation_type,group_brand_region_name,
case when drd.gl in (52010085,15940040) and beneficiary_type = 'ASSOCIATION' then 'ASSOCIATION' else 
case when  drd.gl in (52011200,15940040) and beneficiary_type = 'CHEMIST' then 'CHEMIST' else
case when drd.gl in (52010080,15940040) and gl_type = 'SALES' then 'SALES' else
case when drd.gl in (52010080,15940040) and gl_type = 'MSD' then 'MSD' else null end end end end gl_category      
from
(select emp_type,req_id,req_date,terr_id,dd.doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,cost_center_id,sub_cost_center_id,acp,acmp,acyp,gl,ssd_payment_date,main_cost_center_name gl_type,frequency,
region,donation_type,group_brand_region_name,beneficiary_type
from
(
select 'GROUP_HEAD' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc,mis.donation_type_master dtm
where drc.donation_type = dtm.type_name 
and dtm.main_cost_center_name = 'MSD'
and payment_month = '$request->mon'
and ssd_checked_date is not null and group_head_checked_date is null
union all
select 'GM_SALES' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc,mis.donation_type_master dtm
where drc.donation_type = dtm.type_name 
and payment_month = '$request->mon' and terr_id not like 'AHV%'
and case when main_cost_center_name = 'MSD' then group_head_checked_date  else ssd_checked_date end is not null
and ssd_checked_date is not null and gm_sales_checked_date is null
union all
select 'GM_MSD' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc,mis.donation_type_master dtm
where drc.donation_type = dtm.type_name 
and dtm.main_cost_center_name = 'MSD'
and payment_month = '$request->mon' and ssd_checked_date is not null
and gm_sales_checked_date is not null and gm_msd_checked_date is null

union all
select 'GM_SALES' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,'SALES'main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc
where payment_month = '$request->mon' and terr_id like 'AHV%'
and ssd_checked_date is not null
and gm_msd_checked_date is null

) dd,(select doctor_id,sum(nvl(approved_amount,0)) acp
from mis.donation_req_correction drc,(select distinct emp_type from mis.donation_approved where emp_id = '$uid') le
where case emp_type  when 'GROUP_HEAD' then group_head_checked_date when 'GM_MSD'
then gm_msd_checked_date when 'GM_SALES' then gm_sales_checked_date end is null
and ssd_checked_date is not null and payment_month = '$request->mon'
group by doctor_id) dca,
(select doctor_id,sum(nvl(approved_amount,0)) acmp
from mis.donation_req_correction drc,(select distinct emp_type from mis.donation_approved where emp_id = '$uid') le
where case emp_type  when 'GROUP_HEAD' then group_head_checked_date when 'GM_MSD'
then gm_msd_checked_date when 'GM_SALES' then gm_sales_checked_date end is not null
and payment_month = '$request->mon' group by doctor_id) dcma,
(select doctor_id,sum(nvl(approved_amount,0)) acyp
from mis.donation_req_correction drc,(select distinct emp_type from mis.donation_approved where emp_id = '$uid') le
where case emp_type  when 'GROUP_HEAD' then group_head_checked_date when 'GM_MSD'
then gm_msd_checked_date when 'GM_SALES' then gm_sales_checked_date end is not null
and substr(payment_month,-2) = substr('$request->mon',-2 )
group by doctor_id) dcaa
where dd.doctor_id = dca.doctor_id(+) 
and dd.doctor_id = dcma.doctor_id(+)
and dd.doctor_id = dcaa.doctor_id(+)) drd,(select distinct p_type,cost_center_id,cost_center_name,sub_cost_center_id,sub_cost_center_name,responsible_emp_id,responsible_emp_name
from( 
select distinct 'GROUP_HEAD' p_type,dcc.cost_center_id,cost_center_description cost_center_name,sub_cost_center_id,sub_cost_center_name,
dscc.responsible_emp_id,dscc.responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where dcc.cost_center_id = dscc.cost_center_id 
and budget_type = 'DONATION'  
union all
select distinct 'GM_'||department p_type,dcc.cost_center_id,cost_center_description cost_center_name,
sub_cost_center_id,sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where dcc.cost_center_id = dscc.cost_center_id
and department = 'MSD' and budget_type = 'DONATION'  
union all

select distinct 'GM_'||department p_type,dcc.cost_center_id,cost_center_description cost_center_name,
case when sub_cost_center_id is null then null else sub_cost_center_id end sub_cost_center_id, 
case when sub_cost_center_id is null then null else sub_cost_center_name end sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where  dcc.cost_center_id = dscc.cost_center_id(+)
and department = 'SALES'
and budget_type = 'DONATION' 

union all
            select distinct 'GM_'||department p_type,dcc.cost_center_id,cost_center_description cost_center_name,
            null sub_cost_center_id,null sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
            from mis.donation_cost_center dcc
            where  department = 'SALES'
            and budget_type = 'DONATION' 

union all
select distinct 'GM_SALES' p_type,dcc.cost_center_id,cost_center_description cost_center_name,
sub_cost_center_id,sub_cost_center_name,case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
then 1000353 else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 1000001 else 1000298 end end responsible_emp_id,
case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
then 'Kh. Mainul Islam' else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 
'EHSAN AZIZ'  else 'ASHRAF UDDIN AHMED' end  end responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where dcc.cost_center_id = dscc.cost_center_id
and budget_type = 'DONATION'
and department = 'MSD'

)where responsible_emp_id = '$uid') emp_cc
where drd.emp_type =  emp_cc.p_type
and drd.cost_center_id||drd.sub_cost_center_id = emp_cc.cost_center_id||emp_cc.sub_cost_center_id
)where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl_category) end
and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
and '$request->scc' = case when '$request->scc' = 'ALL' then all_data else to_char(sub_cost_center_id) end
and '$request->don_type' = case when '$request->don_type' = 'ALL' then all_data else donation_type end
and '$request->region' = case when '$request->region' = 'ALL' then all_data else region end
and approved_amount between '$request->low_limit' and '$request->upper_limit'
            ");
            }


            else

            {

                $resp_data = DB::select("

     
  select all_data,budget_month,cc.gl,case when '$request->scc' = 'ALL' then to_char(ed.cost_center_id) else to_char(ed.sub_cost_center_id) end cost_center_id,
        cost_center_name,sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,
        total_budget,sum(nvl(expense_budget,0)) expense_budget,total_budget - sum(nvl(expense_budget,0)) available_budget
        from(
        select all_data,dd.budget_month,dd.gl,dd.cost_center_id,dd.sub_cost_center_id,no_of_req,total_req_amount,
        total_budget,expense_budget,nvl(total_budget,0)- nvl(expense_budget,0) available_budget,gl_type,region,donation_type,approved_amount,        
        case when dd.gl in (52010085,15940040) and beneficiary_type = 'ASSOCIATION' then 'ASSOCIATION' else 
        case when  dd.gl in (52011200,15940040) and beneficiary_type = 'CHEMIST' then 'CHEMIST' else
        case when dd.gl in (52010080,15940040) and gl_type = 'SALES' then 'SALES' else
        case when dd.gl in (52010080,15940040) and gl_type = 'MSD' then 'MSD' else null end end end end gl_category                
        from
        (select 'ALL' all_data,budget_month,drc.gl,drc.cost_center_id,drc.sub_cost_center_id,no_of_req,total_req_amount,expense_budget,
        drc.cost_center_id||drc.sub_cost_center_id dcc_scc,gl_type,region,donation_type,approved_amount,beneficiary_type
        from
        (select emp_type,budget_month,gl,cost_center_id,sub_cost_center_id,region,donation_type,approved_amount,
        sum(nvl(no_of_req,0)) no_of_req,sum(nvl(total_req_amount,0)) total_req_amount,
        sum(nvl(expense_budget,0)) expense_budget,main_cost_center_name gl_type,beneficiary_type
        from(  
        select 'GROUP_HEAD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        count(*) no_of_req,sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon'
        and ssd_checked_date is not null and group_head_checked_date is null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all
        select 'GM_SALES' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,count(*) no_of_req,
        sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and payment_month = '$request->mon'
        and case when main_cost_center_name = 'MSD' then group_head_checked_date  else ssd_checked_date end is not null and terr_id not like 'AHV%'
        and ssd_checked_date is not null and gm_sales_checked_date is null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all
        select 'GM_MSD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,count(*) no_of_req,
        sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon' and ssd_checked_date is not null
        and gm_sales_checked_date is not null and gm_msd_checked_date is null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all  -- Animal Health
        select 'GM_SALES' emp_type,payment_month budget_month,gl,cost_center_id,sub_cost_center_id,count(*) no_of_req,
        sum(nvl(approved_amount,0)) total_req_amount,0 expense_budget,'SALES' main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type 
        from mis.donation_req_correction
        where payment_month = '$request->mon' and terr_id like 'AHV%'
        and ssd_checked_date is not null and gm_msd_checked_date is null
        group by payment_month,gl,cost_center_id,sub_cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all       
        select 'GROUP_HEAD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,0 no_of_req,
        0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type ,approved_amount,beneficiary_type
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name 
        and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon'
        and group_head_checked_date is not null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type    
        union all        
        select 'GM_SALES' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        0 no_of_req,0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type       
        from mis.donation_req_correction drc,mis.donation_type_master dtm 
        where drc.donation_type = dtm.type_name  
        and payment_month = '$request->mon' and gm_sales_checked_date is not null
        and terr_id not like 'AHV%'            
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        union all        
        select 'GM_MSD' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        0 no_of_req,0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type 
        from mis.donation_req_correction drc,mis.donation_type_master dtm
        where drc.donation_type = dtm.type_name and dtm.main_cost_center_name = 'MSD'
        and payment_month = '$request->mon' and gm_msd_checked_date is not null
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,main_cost_center_name,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type        
        union all --Animal Health
        select 'GM_SALES' emp_type,payment_month budget_month,drc.gl,cost_center_id,sub_cost_center_id,
        0 no_of_req,0 total_req_amount,sum(nvl(approved_amount,0)) expense_budget,'SALES' main_cost_center_name,
        substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,approved_amount,beneficiary_type 
        from mis.donation_req_correction drc
        where payment_month = '$request->mon' and gm_msd_checked_date is not null and terr_id like 'AHV%'
        group by payment_month,drc.gl,cost_center_id,sub_cost_center_id,substr(terr_id,1,instr(terr_id,'-'))||'00',donation_type,approved_amount,beneficiary_type
        )group by emp_type,budget_month,gl,cost_center_id,sub_cost_center_id,main_cost_center_name,region,donation_type,approved_amount,beneficiary_type
        )drc,
        (select distinct p_type,gl,cost_center_id,cost_center_name,sub_cost_center_id,sub_cost_center_name,responsible_emp_id,responsible_emp_name
        from( 
        select distinct 'GROUP_HEAD' p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,sub_cost_center_id,sub_cost_center_name,
        dscc.responsible_emp_id,dscc.responsible_emp_name
        from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
        where dcc.cost_center_id = dscc.cost_center_id 
        and budget_type = 'DONATION' 
        union all
        select distinct 'GM_'||department p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
        sub_cost_center_id,sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
        from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
        where dcc.cost_center_id = dscc.cost_center_id
        and budget_type = 'DONATION'
        and department = 'MSD' 
        union all
            select distinct 'GM_'||department p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
            case when sub_cost_center_id is null then null else sub_cost_center_id end sub_cost_center_id, 
            case when sub_cost_center_id is null then null else sub_cost_center_name end sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
            from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
            where  dcc.cost_center_id = dscc.cost_center_id(+)
            and department = 'SALES'
            and budget_type = 'DONATION'
            
                 union all
            select distinct 'GM_'||department p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
            null sub_cost_center_id,null sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
            from mis.donation_cost_center dcc
            where  department = 'SALES'
            and budget_type = 'DONATION' 

        union all
        select distinct 'GM_SALES' p_type,dcc.gl,dcc.cost_center_id,cost_center_description cost_center_name,
                sub_cost_center_id,sub_cost_center_name,case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
                then 1000353 else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 1000001 else 1000298 end end responsible_emp_id,
                case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
                then 'Kh. Mainul Islam' else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 
                'EHSAN AZIZ'  else 'ASHRAF UDDIN AHMED' end  end responsible_emp_name
                from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                where dcc.cost_center_id = dscc.cost_center_id
                and budget_type = 'DONATION'
                and department = 'MSD'
                        )where responsible_emp_id = '$uid') emp_cc 
        where drc.emp_type =  emp_cc.p_type
        and drc.gl = emp_cc.gl
        and drc.cost_center_id||drc.sub_cost_center_id = emp_cc.cost_center_id||emp_cc.sub_cost_center_id) dd,
        (select expense_month budget_month,gl,cost_center_id main_cost_center_id,budget_amt total_budget,
        null sub_cost_center_id,cost_center_id||null bcc_scc
        from mis.research_expense where expense_month = '$request->mon'
        and cost_center_type = 'CC' ) bd
        where dd.gl = bd.gl(+)
        and dd.cost_center_id = bd.main_cost_center_id(+))ed,(select gl,cost_center_id,cost_center_description cost_center_name
        from mis.donation_cost_center where budget_type = 'DONATION'
        union all
        select gl,sub_cost_center_id cost_center_id,sub_cost_center_name cost_center_name 
        from mis.donation_cost_center dcc, mis.donation_sub_cost_center dscc
        where dcc.cost_center_id = dscc.cost_center_id) cc
        where ed.gl = cc.gl 
        and case when '$request->scc' = 'ALL' then to_char(ed.cost_center_id) else to_char(ed.sub_cost_center_id) end = cc.cost_center_id
        and '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(ed.gl_category) end
        and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(ed.cost_center_id) end
        and '$request->scc' = case when '$request->scc' = 'ALL' then all_data else to_char(ed.sub_cost_center_id) end
        and '$request->don_type' = case when '$request->don_type' = 'ALL' then all_data else donation_type end
        and '$request->region' = case when '$request->region' = 'ALL' then all_data else region end  
        Group by all_data,budget_month,cc.gl,cost_center_name,total_budget,
        case when '$request->scc' = 'ALL' then to_char(ed.cost_center_id) else to_char(ed.sub_cost_center_id) end   
       

");


                $second_table = DB::select("  
                                                            
select all_data,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,acp,acmp,acyp,gl,ssd_payment_date,frequency,group_brand_region_name,donation_type,
case when '$request->scc' = 'ALL' then to_char(cost_center_id) else to_char(sub_cost_center_id) end cost_center_id
from(
select 'ALL' all_data,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,drd.cost_center_id,drd.sub_cost_center_id,acp,acmp,acyp,gl,ssd_payment_date,gl_type,frequency,
region,donation_type,group_brand_region_name,
case when gl in (52010085,15940040) and beneficiary_type = 'ASSOCIATION' then 'ASSOCIATION' else 
case when  gl in (52011200,15940040) and beneficiary_type = 'CHEMIST' then 'CHEMIST' else
case when gl in (52010080,15940040) and gl_type = 'SALES' then 'SALES' else
case when gl in (52010080,15940040) and gl_type = 'MSD' then 'MSD' else null end end end end gl_category 
from
(select emp_type,req_id,req_date,terr_id,dd.doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,cost_center_id,sub_cost_center_id,acp,acmp,acyp,gl,ssd_payment_date,main_cost_center_name gl_type,frequency,
region,donation_type,group_brand_region_name,beneficiary_type
from
(
select 'GROUP_HEAD' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc,mis.donation_type_master dtm
where drc.donation_type = dtm.type_name 
and dtm.main_cost_center_name = 'MSD'
and payment_month = '$request->mon'
and ssd_checked_date is not null and group_head_checked_date is null
union all
select 'GM_SALES' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc,mis.donation_type_master dtm
where drc.donation_type = dtm.type_name 
and payment_month = '$request->mon' and terr_id not like 'AHV%'
and case when main_cost_center_name = 'MSD' then group_head_checked_date  else ssd_checked_date end is not null
and ssd_checked_date is not null and gm_sales_checked_date is null
union all
select 'GM_MSD' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc,mis.donation_type_master dtm
where drc.donation_type = dtm.type_name 
and dtm.main_cost_center_name = 'MSD'
and payment_month = '$request->mon' and ssd_checked_date is not null
and gm_sales_checked_date is not null and gm_msd_checked_date is null

union all -- Animal Health
select 'GM_SALES' emp_type,req_id,req_date,terr_id,doctor_id,doctor_name,in_favour_of,payment_mode,approved_amount,
payment_month,ssd_payment_date,cost_center_id,sub_cost_center_id,drc.gl,'SALES' main_cost_center_name,frequency,
substr(terr_id,1,instr(terr_id,'-'))||'00' region,donation_type,group_brand_region_name,beneficiary_type
from mis.donation_req_correction drc
where payment_month = '$request->mon' and ssd_checked_date is not null
and gm_msd_checked_date is null and terr_id like 'AHV%'


) dd,(select doctor_id,sum(nvl(approved_amount,0)) acp
from mis.donation_req_correction drc,(select distinct emp_type from mis.donation_approved where emp_id = '$uid') le
where case emp_type  when 'GROUP_HEAD' then group_head_checked_date when 'GM_MSD'
then gm_msd_checked_date when 'GM_SALES' then gm_sales_checked_date end is null
and ssd_checked_date is not null and payment_month = '$request->mon'
group by doctor_id) dca,
(select doctor_id,sum(nvl(approved_amount,0)) acmp
from mis.donation_req_correction drc,(select distinct emp_type from mis.donation_approved where emp_id = '$uid') le
where case emp_type  when 'GROUP_HEAD' then group_head_checked_date when 'GM_MSD'
then gm_msd_checked_date when 'GM_SALES' then gm_sales_checked_date end is not null
and payment_month = '$request->mon' group by doctor_id) dcma,
(select doctor_id,sum(nvl(approved_amount,0)) acyp
from mis.donation_req_correction drc,(select distinct emp_type from mis.donation_approved where emp_id = '$uid') le
where case emp_type  when 'GROUP_HEAD' then group_head_checked_date when 'GM_MSD'
then gm_msd_checked_date when 'GM_SALES' then gm_sales_checked_date end is not null
and substr(payment_month,-2) = substr('$request->mon',-2 )
group by doctor_id) dcaa
where dd.doctor_id = dca.doctor_id(+) 
and dd.doctor_id = dcma.doctor_id(+)
and dd.doctor_id = dcaa.doctor_id(+)) drd,(select distinct p_type,cost_center_id,cost_center_name,sub_cost_center_id,sub_cost_center_name,responsible_emp_id,responsible_emp_name
from( 
select distinct 'GROUP_HEAD' p_type,dcc.cost_center_id,cost_center_description cost_center_name,sub_cost_center_id,sub_cost_center_name,
dscc.responsible_emp_id,dscc.responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where dcc.cost_center_id = dscc.cost_center_id
and budget_type = 'DONATION'   
union all
select distinct 'GM_'||department p_type,dcc.cost_center_id,cost_center_description cost_center_name,
sub_cost_center_id,sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where dcc.cost_center_id = dscc.cost_center_id
and department = 'MSD' and budget_type = 'DONATION'
union all

select distinct 'GM_'||department p_type,dcc.cost_center_id,cost_center_description cost_center_name,
case when sub_cost_center_id is null then null else sub_cost_center_id end sub_cost_center_id, 
case when sub_cost_center_id is null then null else sub_cost_center_name end sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where  dcc.cost_center_id = dscc.cost_center_id(+)
and department = 'SALES'
and budget_type = 'DONATION'

  union all
            select distinct 'GM_'||department p_type,dcc.cost_center_id,cost_center_description cost_center_name,
            null sub_cost_center_id,null sub_cost_center_name,dcc.responsible_emp_id,dcc.responsible_emp_name
            from mis.donation_cost_center dcc
            where  department = 'SALES'
            and budget_type = 'DONATION' 


union all
select distinct 'GM_SALES' p_type,dcc.cost_center_id,cost_center_description cost_center_name,
sub_cost_center_id,sub_cost_center_name,case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
then 1000353 else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 1000001 else 1000298 end end responsible_emp_id,
case when cost_center_group in ('KINETIX','CELLBIOTIC','ZYMOS','GENERAL')
then 'Kh. Mainul Islam' else case when cost_center_group = 'ANIMAL HEALTH & VACCINE DIVISION' then 
'EHSAN AZIZ'  else 'ASHRAF UDDIN AHMED' end  end responsible_emp_name
from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
where dcc.cost_center_id = dscc.cost_center_id
and budget_type = 'DONATION'
and department = 'MSD'

)where responsible_emp_id = '$uid') emp_cc
where drd.emp_type =  emp_cc.p_type
and drd.cost_center_id||drd.sub_cost_center_id = emp_cc.cost_center_id||emp_cc.sub_cost_center_id
)where '$request->gl' = case when '$request->gl' = 'ALL' then all_data else to_char(gl_category) end
and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
and '$request->scc' = case when '$request->scc' = 'ALL' then all_data else to_char(sub_cost_center_id) end
and '$request->don_type' = case when '$request->don_type' = 'ALL' then all_data else donation_type end
and '$request->region' = case when '$request->region' = 'ALL' then all_data else region end

            ");

            }


            return response()->json(['resp_data' => $resp_data, 'second_table' => $second_table]);

        }
    }


    public function verify_agm(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $type = DB::select(" select distinct emp_type from mis.donation_approved where emp_id = '$uid' ");

            $verinfo = json_decode($request->verifyData);

            if ($type[0]->emp_type == 'GM_SALES') {
                foreach ($verinfo as $data) {

                    DB::UPDATE("
                        update mis.donation_req_correction 
                        set gm_sales_emp_id='$uid',
                        gm_sales_emp_name='$uname',
                        gm_sales_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }

            if ($type[0]->emp_type == 'GM_MSD') {
                foreach ($verinfo as $data) {

                    DB::UPDATE("
                        update mis.donation_req_correction 
                        set gm_msd_emp_id='$uid',
                        gm_msd_emp_name='$uname',
                        gm_msd_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }

            if ($type[0]->emp_type == 'GROUP_HEAD') {
                foreach ($verinfo as $data) {

                    DB::UPDATE("
                        update mis.donation_req_correction 
                        set group_head_emp_id='$uid',
                        group_head_emp_name='$uname',
                        group_head_checked_date= (select sysdate from dual)
                        where req_id=?
                    ", [$data->req_id]);
                }
            }


            return response()->json(['success' => 'Research Expense verified Successfully.']);
        }


    }

    public function delete_row_gm(Request $request)
    {
//        Before deleting from mis.donation_req_correction we are inserting that row in another table

        $uid = Auth::user()->user_id;

        $insert_action = DB::delete("insert into mis.donation_req_delete
                                        select d.*,'$uid',(select sysdate from dual)
                                        from mis.donation_req_correction d
                                        where req_id='$request->req_no' ");


        $delete_action = DB::delete("delete from mis.donation_req_correction   where req_id = '$request->req_no'   ");

        return response()->json($delete_action);

    }

}