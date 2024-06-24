<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 18-Dec-18
 * Time: 12:28 PM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

//Request $request

class Donation_exception_Controller extends Controller
{
    public function index()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $tid = Auth::user()->terr_id;




        $dtm = DB::select("select type_name ,gl,main_cost_center_name,
                          type,type_name||case when main_cost_center_name = 'MSD' then ' (MARKETING)' else ' ('||main_cost_center_name||')'  end type_mct
                            from mis.donation_type_master
                            ORDER BY MAIN_COST_CENTER_NAME DESC,type_name  
                            ");

        $dbt = DB::select("select dbt_description
                            from mis.donation_beneficiary_type
                            order by dbt_id");

        $dpm = DB::select("select distinct purpose_name
                    from mis.donation_purpose_master
                    where purpose_name NOT IN ('CANCELLATION CURRENT YEAR', 'CANCELLATION PREVIOUS YEAR')
                    ");

        $freq = DB::select("select df_description
                    from mis.donation_frequency
                    order by df_id");



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

        if (Auth::user()->desig === 'AM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?", [$uid]);

            return view('donation.donation_requisition_exception', [ 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr,'dtm' => $dtm, 'dpm' => $dpm,'dbt' => $dbt,'freq' => $freq,'month_name' => $month_name]);

        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'|| Auth::user()->desig === 'HO') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('donation.donation_requisition_exception', [ 'am_terr' => $am_terr,'dtm' => $dtm, 'dpm' => $dpm,'dbt' => $dbt,'freq' => $freq,'month_name' => $month_name]);
        }



    }

    public function depo_and_doc (Request $request)
    {


        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $docid = DB::select(" select   distinct dc.doctor_id, dc.doctor_name, dt.terr_id
                from   doctor_info.doctor_information@web_to_sample_msd dc,
                doctor_info.doctor_terr@web_to_sample_msd dt
                where       dc.doctor_id = dt.doctor_id
                and dt.valid = 'YES'
                and nvl (dc.doctor_status, 'VALID') != 'DELETE'
                and dt.terr_id = '$request->mpo_terr'
                order by doctor_id
            ");

            $depo = DB::select("       
            select di.d_id depot_id,name depot_name
            from hrtms.hr_terr_list@web_to_hrtms tl,msfa.depot@web_to_imsfa di
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and tl.d_id = di.d_id
            and mpo_terr_id= '$request->mpo_terr'
              ");



            return response()->json(['docid'=>$docid,'depo' => $depo]);
        }
    }


    public function brand_region_post(Request $request)
    {

        $uid = Auth::user()->user_id;
        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");
            if($request->rnbd=='BRAND'){
                $scn = DB::select("
                select cost_center_id,sub_cost_center_id,sub_cost_center_name
                    from
                    (select distinct dscc.cost_center_id cost_center_id,dscc.sub_cost_center_id sub_cost_center_id,dscc.sub_cost_center_name sub_cost_center_name,dcc.cost_center_group
                    from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                    where department = 'MSD'
                    and budget_type = 'DONATION'
                    and dcc.cost_center_id = dscc.cost_center_id
                    and sub_cost_center_type = 'BRAND') ccd,(select distinct p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region  
                    from hrtms.hr_terr_list@web_to_hrtms ht
                    where to_char(ht.emp_month,'DD-MON-YY') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and mpo_terr_id = '$request->mpo_terr' and p_group <> 'GENERAL'
                    union all
                    select case when l = 1 then 'CELLBIOTIC' else case when l = 2 then 'KINETIX' else
                    case when l = 3 then 'ZYMOS' else null end end end p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region  
                    from hrtms.hr_terr_list@web_to_hrtms ht,(select level l from dual connect by level <=3)
                    where to_char(ht.emp_month,'DD-MON-YY')= to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and mpo_terr_id = '$request->mpo_terr' and p_group = 'GENERAL') tgr
                    where cost_center_group = tgr.p_group
                ");
            }

               if($request->rnbd=='REGION'){
                $scn = DB::select("

                                    
                select distinct cost_center_id,sub_cost_center_id,sub_cost_center_name
                from
                (select distinct dscc.cost_center_id cost_center_id,dscc.sub_cost_center_id sub_cost_center_id,
                dscc.sub_cost_center_name sub_cost_center_name,cost_center_region,cost_center_region_name,cost_center_group,
                case when cost_center_group in ('CELLBIOTIC','KINETIX','ZYMOS') then 'GENERAL' else cost_center_group end cc_group
                from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                where department = 'MSD'
                and budget_type = 'DONATION'
                and dcc.cost_center_id = dscc.cost_center_id
                and sub_cost_center_type = 'REGION') dcc,(select distinct substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' terr_region  
                from hrtms.hr_terr_list@web_to_hrtms ht
                where to_char(ht.emp_month,'DD-MON-YY')= to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                and mpo_terr_id = '$request->mpo_terr') tr
                where dcc.cost_center_region = tr.terr_region


                                
                ");
            }


            return response()->json($scn);
        }
    }


    public function cc_sales (Request $request)
    {
        $uid = Auth::user()->user_id;

        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            if($request->type_name=='BRAND RESEARCH SALES'){

                $cc = DB::select("

                        select cost_center_id,sub_cost_center_id,sub_cost_center_name
                        from
                        (select distinct dscc.cost_center_id cost_center_id,dscc.sub_cost_center_id sub_cost_center_id,
                        dscc.sub_cost_center_name sub_cost_center_name,dcc.cost_center_group,
                        substr(sub_cost_center_name,instr(sub_cost_center_name,'(')+1,instr(sub_cost_center_name,')')- instr(sub_cost_center_name,'(')-1 ) scc 
                        from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                        where department = 'SALES'
                        and budget_type = 'DONATION'
                        and dcc.cost_center_id = dscc.cost_center_id
                        and sub_cost_center_type = 'BRAND') ccd,(select distinct p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region  
                        from hrtms.hr_terr_list@web_to_hrtms ht
                        where to_char(ht.emp_month,'DD-MON-YY') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                        and mpo_terr_id = '$request->mpo_terr' and p_group <> 'GENERAL'
                        union all
                        select case when l = 1 then 'CELLBIOTIC' else case when l = 2 then 'KINETIX' else
                        case when l = 3 then 'ZYMOS' else null end end end p_group,substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' region  
                        from hrtms.hr_terr_list@web_to_hrtms ht,(select level l from dual connect by level <=3)
                        where to_char(ht.emp_month,'DD-MON-YY')= to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                        and mpo_terr_id = '$request->mpo_terr' and p_group = 'GENERAL') tgr                  
                        where 
                        scc = tgr.p_group
                        ");

            }

            else if($request->type_name=='REGION DEVELOPMENT'){
                $cc = DB::select("
                   
                    select distinct cost_center_id,sub_cost_center_id,sub_cost_center_name
                    from
                    (select distinct dscc.cost_center_id cost_center_id,dscc.sub_cost_center_id sub_cost_center_id,
                    dscc.sub_cost_center_name sub_cost_center_name,cost_center_region,cost_center_region_name,cost_center_group,
                    case when cost_center_group in ('CELLBIOTIC','KINETIX','ZYMOS') then 'GENERAL' else cost_center_group end cc_group
                    from mis.donation_cost_center dcc,mis.donation_sub_cost_center dscc
                    where department = 'SALES'
                    and budget_type = 'DONATION'
                    and dcc.cost_center_id = dscc.cost_center_id
                    and sub_cost_center_type = 'REGION') dcc,(select distinct substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' terr_region  
                    from hrtms.hr_terr_list@web_to_hrtms ht
                    where to_char(ht.emp_month,'DD-MON-YY')= to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and mpo_terr_id = '$request->mpo_terr') tr
                    where dcc.cost_center_region = tr.terr_region                 
                 
                                
                ");
            }
            else{
                $cc = DB::select("
                           select cost_center_id,cost_center_description
                    from
                    (select distinct cost_center_id,cost_center_description,cost_center_group
from mis.donation_cost_center
where budget_type = 'DONATION' and department = 'SALES'  and cost_center_id not in (1000101014,1000101015,1000100109) ) dcc,(select distinct case when p_group in ('ASTER','GYRUS','LUCENT') then 'ASTER-GYRUS' else
                    case when p_group = 'OPERON-XENOVISION' then 'OPERON-XENOVISION' else
                    case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL' else case when p_group = 'ANIMAL HEALTH & VACCINE DIVISION'then p_group else null end end end end p_group  
                    from hrtms.hr_terr_list@web_to_hrtms ht
                    where to_char(ht.emp_month,'DD-MON-YY')= (select to_char(trunc(sysdate,'mm'),'DD-MON-YY')  from dual)
                    and mpo_terr_id = '$request->mpo_terr') hpg
                    where dcc.cost_center_group = hpg.p_group
                            ");
            }

            return response()->json($cc);
        }
    }


    public function doc_info_post(Request $request)
    {
//        $tid = Auth::user()->terr_id;
        if ($request->ajax()) {
            $dcn = DB::select("select distinct dc.doctor_id,dc.doctor_name,no_of_patient,nvl(mobile,phone) mobile,nvl(hospital_address,chember_address) address,
                                case when dt.in_favour_of is null then dc.doctor_name else dt.in_favour_of end in_favour_of,s.details speciality
                                from doctor_info.doctor_information@web_to_sample_msd dc,doctor_info.doctor_terr@web_to_sample_msd dt  ,p4aug.speciality_code@web_to_sample_msd s
                                where
                                dc.doctor_id= ?
                                and
                                dc.spec_code=s.code(+)
                                and  dt.terr_id= '$request->mpo_terr'
                                and dt.valid='YES'
                                and dc.doctor_id=  dt.doctor_id
                                order by in_favour_of", [$request->dcid]);

            return response()->json($dcn);
        }
    }

    public function donation_insert(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");

//        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $systime = DB::select("
        select sysdate from dual
        ");

        $tid = Auth::user()->terr_id;
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        $reqid = DB::select("
        select max(req_id)+1 req_id
        from
        (
        select 0 req_id from dual
        union all 
        select max(req_id) from mis.donation_requisition
        )
        ");

        $mpo_info = DB::select("

            select mpo_emp_id,mpo_name  from hrtms.hr_terr_list@web_to_hrtms ht where mpo_terr_id = '$request->mpo_terr'
             and
            to_char(ht.emp_month,'DD-MON-YY')= (select to_char(trunc(sysdate,'mm'),'DD-MON-YY')  from dual)

        "
        );


        $rq = DB::select("
        select count(*) req_npm
        from(
            select distinct payment_month,frequency,
            case when frequency = 'MONTHLY' then add_months(to_date(payment_month,'MON-RR'),1) else 
            case when frequency = 'BI-MONTHLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),2) else
            case when frequency = 'QUARTERLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),3) else
            case when frequency = 'HALF YEARLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),6) else
            case when frequency = 'YEARLY' then add_months(to_char(to_date(payment_month,'MON-RR'),'DD-MON-RR'),12) else null end end end end end np_month
            from mis.donation_req_correction
            where donation_type in ('BRAND RESEARCH','REGION DEVELOPMENT','BRAND RESEARCH SALES')
            and to_date(payment_month,'MON-RR') between add_months(to_char(to_date('$request->pay_dt','MON-RR'),'DD-MON-RR'),-11) and to_date('$request->pay_dt','MON-RR')
            and terr_id =  '$request->mpo_terr'
            and doctor_id = '$request->doc_id'
            and donation_type = '$request->don_type'
            and sub_cost_center_id = '$request->sccid'
            ) where np_month > to_date('$request->pay_dt','MON-RR')
        
        ");


        if($rq[0]->req_npm == '0') {


            $dcn = DB::insert(" insert into mis.donation_requisition (                
                in_favour_of_main,d_id,d_name,req_id,req_date,emp_id,emp_name,terr_id,donation_type,group_brand_region_name,beneficiary_type,payment_mode,purpose,frequency,payment_month,proposed_amount,
                doctor_id,doctor_name,no_of_patient,contact_no,in_favour_of,address,speciality,commitment,status,cost_center_id,sub_cost_center_id,create_date,create_user,gl
               
                )
                values 
                (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'YES',?,?,?,?,?)",
                [$request->inf_ori,$request->dpid,$request->dpname,$reqid[0]->req_id,$systime[0]->sysdate,
                    $mpo_info[0]->mpo_emp_id,$mpo_info[0]->mpo_name,$request->mpo_terr,$request->don_type,$request->group,$request->beneficiary,
                    $request->pay_mode,$request->purpose,$request->freq,$request->pay_dt,$request->amount,$request->doc_id,$request->dn,
                    $request->np,$request->cno,$request->infav,$request->adr,$request->specs,$request->comment,$request->ccid,$request->sccid,$systime[0]->sysdate,$uid,$request->gl]

            );



//            if ($dcn) {
//                return response()->json(['success' => 'Change Successfully.']);
//            } else {
//                return response()->json(['error' => 'UnSuccessfully.']);
//            }

//            return response()->json($reqid);
//            return response()->json($dcn);
            return response()->json(false);
        }
        else{
            return response()->json(true);
        }

    }


}