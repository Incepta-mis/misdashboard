<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Input;
use Validator;
use File;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Query\Builder as QueryBuilder;


class RmPortalController extends Controller
{
    public function regwTerrList(){

        $month_name = DB::select("select to_char(add_months(dt,l),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 6)
                                    select *
                                      from (select trunc(add_months(sysdate, -6)) dt from dual), data
                                     order by dt, l
                                     )");


       return view('rm_portal/regwise_terr_list')->with(['month_name'=>$month_name]);
    }

    public function regwDoclist_report(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

       // echo $uid;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");
            return view('rm_portal/regwise_doc_list')->with(['am_terr'=>$am_terr]);
        }

        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/regwise_doc_list')->with(['rm_terr'=>$rm_terr]);

        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/regwise_doc_list')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/regwise_doc_list')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/regwise_doc_list')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            return view('rm_portal/regwise_doc_list')->with(['rm_terr'=>$rm_terr]);
        }


    }

    public function terrListRearrange(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $cr_month = DB::select("select cr_month
                                from(
                                select to_char(sysdate,'MON-RR') cr_month
                                from dual
                                union
                                select TO_CHAR(
                                ADD_MONTHS(sysdate,1),
                                'MON-RR') cr_month
                                from dual) 
                                order by sysdate");

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select  distinct 
                    substr(mpo_terr_id,1,instr(mpo_terr_id,'-',1,1))||trunc(substr(mpo_terr_id,instr(mpo_terr_id,'-',-1,1)+1),-1)am_terr_id
                    from hrtms.hr_terr_list@web_to_hrtms 
                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from rm_gm_info  where rm_emp_id ||asm_emp_id in ('$uid') )   
                    order by am_terr_id");

            return view('rm_portal/terr_rearrange')->with(['cr_month' => $cr_month,'am_terr' => $am_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            $am_terr = DB::select("select  distinct 
                    substr(mpo_terr_id,1,instr(mpo_terr_id,'-',1,1))||trunc(substr(mpo_terr_id,instr(mpo_terr_id,'-',-1,1)+1),-1)am_terr_id
                    from hrtms.hr_terr_list@web_to_hrtms 
                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from rm_gm_info  where rm_emp_id ||asm_emp_id in ('$uid') )   
                    order by am_terr_id");

            return view('rm_portal/terr_rearrange')->with(['cr_month' => $cr_month,'rm_terr' => $rm_terr,'am_terr' => $am_terr]);
        }

    }

     public function doctorBrandReport(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

         if(Auth::user()->desig === 'MPO' || Auth::user()->desig === 'AM' ){

             if(Auth::user()->desig === 'MPO'){
                 $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_emp_id = ?",[$uid]);

                 $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?",[$uid]);

             }elseif (Auth::user()->desig === 'AM'){

                 $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_emp_id = ?",[$uid]);

                 $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_emp_id  =?",[$uid]);
             }


             return view('rm_portal/docWiseBrand_list')->with(['rm_terr'=>$rm_terr,'am_terr'=>$am_terr]);
         }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");
            return view('rm_portal/docWiseBrand_list')->with(['am_terr'=>$am_terr]);
        }

        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docWiseBrand_list')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docWiseBrand_list')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docWiseBrand_list')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docWiseBrand_list')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            return view('rm_portal/docWiseBrand_list')->with(['rm_terr'=>$rm_terr]);
       
        }
    }


 public function doctorVsPlan(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");

            $p_group = DB::select("select distinct p_group
                                    from msfa.TERRITORY_GROUP@WEB_TO_IMSFA");

            return view('rm_portal/doc_Visit_Plan')->with(['am_terr'=>$am_terr,'p_group'=>$p_group]);
        }

        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $p_group = DB::select("select distinct p_group
                                    from msfa.TERRITORY_GROUP@WEB_TO_IMSFA");

            return view('rm_portal/doc_Visit_Plan')->with(['rm_terr'=>$rm_terr,'p_group'=>$p_group]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $p_group = DB::select("select distinct p_group
                                    from msfa.TERRITORY_GROUP@WEB_TO_IMSFA");

            return view('rm_portal/doc_Visit_Plan')->with(['rm_terr'=>$rm_terr,'p_group'=>$p_group]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $p_group = DB::select("select distinct p_group
                                    from msfa.TERRITORY_GROUP@WEB_TO_IMSFA");

            return view('rm_portal/doc_Visit_Plan')->with(['rm_terr'=>$rm_terr,'p_group'=>$p_group]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $p_group = DB::select("select distinct p_group
                                    from msfa.TERRITORY_GROUP@WEB_TO_IMSFA");

            return view('rm_portal/doc_Visit_Plan')->with(['rm_terr'=>$rm_terr,'p_group'=>$p_group]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            $p_group = DB::select("select distinct p_group
                                    from msfa.TERRITORY_GROUP@WEB_TO_IMSFA");

            return view('rm_portal/doc_Visit_Plan')->with(['rm_terr'=>$rm_terr,'p_group'=>$p_group]);
        }
    }


    public function itemWiseDr(){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('rm_portal/item_wise_doctors')->with(['am_terr'=>$am_terr]);
        }

        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/item_wise_doctors')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/item_wise_doctors')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            return view('rm_portal/item_wise_doctors')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/item_wise_doctors')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");
            return view('rm_portal/item_wise_doctors')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO'){
            $rm_terr = DB::select("select distinct rm_terr_id, am_terr_id, mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id in (select distinct mpo_terr_id 
                                                    from hrtms.hr_terr_list@web_to_hrtms  
                                                    where  MPO_EMP_ID = '$uid' 
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                order by rm_terr_id");

            $brand_name = DB::select("select distinct brand_name
                                        from mis.DOCTOR_WISE_ITEM_UTILIZATION
                                        where TERR_ID = (
                                                        select distinct mpo_terr_id 
                                                        from hrtms.hr_terr_list@web_to_hrtms  
                                                        where  mpo_EMP_ID = '$uid'  
                                                        AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))");


            return view('rm_portal/item_wise_doctors')->with(['rm_terr'=>$rm_terr,'brand_name' => $brand_name]);
        }

        if( Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM'){
            $rm_terr = DB::select("select distinct rm_terr_id,mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_terr_id in (select distinct am_terr_id 
                                                    from hrtms.hr_terr_list@web_to_hrtms  
                                                    where  AM_EMP_ID = '$uid'  
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                    order by rm_terr_id");


            return view('rm_portal/item_wise_doctors')->with(['rm_terr'=>$rm_terr]);
        }

    }


    public function brandWiseDrDelete(){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");


            return view('rm_portal/brandWiseDocDelete')->with(['am_terr'=>$am_terr]);
        }

        if( Auth::user()->desig === 'GM') {

            Log::info(Auth::user()->user_id.' | '.Auth::user()->desig);
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/brandWiseDocDelete')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/brandWiseDocDelete')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            return view('rm_portal/brandWiseDocDelete')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/brandWiseDocDelete')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");
            return view('rm_portal/brandWiseDocDelete')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO'){
            $rm_terr = DB::select("select distinct rm_terr_id, am_terr_id, mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id in (select distinct mpo_terr_id 
                                                    from hrtms.hr_terr_list@web_to_hrtms  
                                                    where  MPO_EMP_ID = '$uid' 
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                order by rm_terr_id");

            $brand_name = DB::select("select distinct brand_name
                                        from mis.DOCTOR_WISE_ITEM_UTILIZATION
                                        where TERR_ID = (
                                                        select distinct mpo_terr_id 
                                                        from hrtms.hr_terr_list@web_to_hrtms  
                                                        where  mpo_EMP_ID = '$uid'  
                                                        AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')) order by brand_name ");


            return view('rm_portal/brandWiseDocDelete')->with(['rm_terr'=>$rm_terr,'brand_name' => $brand_name]);
        }

        if( Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM'){
            $rm_terr = DB::select("select distinct rm_terr_id,mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_terr_id in (select distinct am_terr_id 
                                                    from hrtms.hr_terr_list@web_to_hrtms  
                                                    where  AM_EMP_ID = '$uid'  
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                    order by rm_terr_id");


            return view('rm_portal/brandWiseDocDelete')->with(['rm_terr'=>$rm_terr]);
        }

    }

    public function terr_wise_brand_exposure(){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;


        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                and mpo_terr_id not like '%-501' 
                                order by rm_terr_id");


            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    and mpo_terr_id not like '%-501' 
                                    order by rm_terr_id");
            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr]);
        }


        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') ) 
                                and mpo_terr_id not like '%-501'  
                                order by rm_terr_id");


            $brand_name = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' = (select  rm_terr_id from rm_gm_info where rm_emp_id ||asm_emp_id  = '$uid')
                                order by brand_name asc
                            ");



            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr,'brand_name'=>$brand_name]);
        }



        if( Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO'){
            $rm_terr = DB::select("select distinct rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id in (select distinct mpo_terr_id 
                                                    from hrtms.hr_terr_list@web_to_hrtms  
                                                    where  MPO_EMP_ID = '$uid' 
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                                    and mpo_terr_id not like '%-501' 
                                order by rm_terr_id");

            $brand_name = DB::select("select distinct brand_name
                                        from mis.DOCTOR_WISE_ITEM_UTILIZATION
                                        where TERR_ID = (
                                                        select distinct mpo_terr_id 
                                                        from hrtms.hr_terr_list@web_to_hrtms  
                                                        where  mpo_EMP_ID = '$uid'  
                                                        AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))");


            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr,'brand_name' => $brand_name]);
        }

        if( Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM'){
            $rm_terr = DB::select("select distinct rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and am_terr_id in (select distinct am_terr_id 
                                                    from hrtms.hr_terr_list@web_to_hrtms  
                                                    where  AM_EMP_ID = '$uid'  
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))  
                                                    and mpo_terr_id not like '%-501'  
                                    order by rm_terr_id");


            $brand_name = DB::select("select distinct brand_name
                                        from mis.DOCTOR_WISE_ITEM_UTILIZATION
                                        where substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1)  = (
                                                        select distinct am_terr_id 
                                                        from hrtms.hr_terr_list@web_to_hrtms  
                                                        where  AM_EMP_ID = '$uid'  
                                                        AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))");


            return view('rm_portal/terrWiseBrandExposure')->with(['rm_terr'=>$rm_terr,'brand_name' => $brand_name]);
        }
    }

    public function day_wise_docVisit_plan(){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;


        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )
                                order by rm_terr_id");


            return view('rm_portal/day_wise_docVisit_plan')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )
                                order by rm_terr_id");


            return view('rm_portal/day_wise_docVisit_plan')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )
                                order by rm_terr_id");

            return view('rm_portal/day_wise_docVisit_plan')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )
                                order by rm_terr_id");


            return view('rm_portal/day_wise_docVisit_plan')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)                                       
                                    order by rm_terr_id");
            return view('rm_portal/day_wise_docVisit_plan')->with(['rm_terr'=>$rm_terr]);
        }


        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $rm_terr = DB::select("select distinct rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                and mpo_terr_id not like '%-501'  
                                order by rm_terr_id");

            $am_terr = DB::select("select distinct am_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                            and mpo_terr_id not like '%-501'  
                            order by am_terr_id");

            return view('rm_portal/day_wise_docVisit_plan')->with(['rm_terr'=>$rm_terr,'am_terr'=>$am_terr]);
        }



        if( Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO'){
            $all_terr = DB::select("select distinct rm_terr_id,am_terr_id,mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_terr_id in (select distinct mpo_terr_id
                                                        from hrtms.hr_terr_list@web_to_hrtms
                                                        where  mpo_emp_id = '$uid'
                                                        and to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))
                                                        and mpo_terr_id not like '-500%'                    
                                    order by mpo_terr_id");

            return view('rm_portal/day_wise_docVisit_plan')->with(['all_terr'=>$all_terr]);
        }

        if( Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM'){

            $all_terr = DB::select("select distinct rm_terr_id,am_terr_id,mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id in (select distinct mpo_terr_id
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where  AM_EMP_ID = '$uid'
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))
                                and mpo_terr_id not like '-500%'                    
                                order by rm_terr_id");

            return view('rm_portal/day_wise_docVisit_plan')->with(['all_terr'=>$all_terr]);
        }
    }

    
    public function docWiseTerrChange(){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)                                       
                                    order by rm_terr_id");
            return view('rm_portal/doc_Terr_Change')->with(['rm_terr'=>$rm_terr]);
        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $rm_terr = DB::select("select distinct rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                and mpo_terr_id not like '%-500%'
                                order by rm_terr_id");

            $am_terr = DB::select("select distinct am_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') between ADD_MONTHS(to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'),-1) and to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            --where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                            and mpo_terr_id not like '%-500%'
                            order by am_terr_id");

            return view('rm_portal/doc_Terr_Change')->with(['rm_terr'=>$rm_terr,'am_terr'=>$am_terr]);
        }

    }


    public function doc_wise_brand_assign(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;


        if( Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/doc_wise_brand_assign')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");


            return view('rm_portal/doc_wise_brand_assign')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            return view('rm_portal/doc_wise_brand_assign')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                and mpo_terr_id not like '%-501' 
                                order by rm_terr_id");


            return view('rm_portal/doc_wise_brand_assign')->with(['rm_terr'=>$rm_terr]);
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO' ) {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    and mpo_terr_id not like '%-501' 
                                    order by rm_terr_id");
            return view('rm_portal/doc_wise_brand_assign')->with(['rm_terr'=>$rm_terr]);
        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $rm_terr = DB::select("select distinct rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                order by rm_terr_id");

            $am_terr = DB::select("select distinct am_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                            order by am_terr_id");


            return view('rm_portal/doc_wise_brand_assign')->with(['rm_terr'=>$rm_terr,'am_terr'=>$am_terr]);
        }

        if( Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM'){

            $all_terr = DB::select("select distinct rm_terr_id,am_terr_id,mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id in (select distinct mpo_terr_id
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where  AM_EMP_ID = '$uid'
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))
                                and mpo_terr_id not like '-500%'                    
                                order by rm_terr_id");

            return view('rm_portal/doc_wise_brand_assign')->with(['all_terr'=>$all_terr]);
        }

        if( Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO'){
            $all_terr = DB::select("select distinct rm_terr_id,am_terr_id,mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_terr_id in (select distinct mpo_terr_id
                                                        from hrtms.hr_terr_list@web_to_hrtms
                                                        where  mpo_emp_id = '$uid'
                                                        and to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))
                                                        and mpo_terr_id not like '%-500%'                    
                                    order by mpo_terr_id");

            return view('rm_portal/doc_wise_brand_assign')->with(['all_terr'=>$all_terr]);
        }
    }


   //Doctor Brand Summary Report
    function doctorBrandSummary()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

        if (Auth::user()->desig === 'MPO' || Auth::user()->desig === 'AM') {

            if (Auth::user()->desig === 'MPO') {
                $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_emp_id = ?", [$uid]);

                $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);
                $mpo_terr = DB::select("select distinct mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and mpo_emp_id  =?", [$uid]);

            } elseif (Auth::user()->desig === 'AM') {

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
            }


            return view('rm_portal/docBrandSummary')->with(['rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr]);
        }

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                                order by am_terr_id");
            return view('rm_portal/docBrandSummary')->with(['am_terr' => $am_terr]);
        }

        if (Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docBrandSummary')->with(['rm_terr' => $rm_terr]);
        }

        if (Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docBrandSummary')->with(['rm_terr' => $rm_terr]);
        }

        if (Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docBrandSummary')->with(['rm_terr' => $rm_terr]);
        }

        if (Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            return view('rm_portal/docBrandSummary')->with(['rm_terr' => $rm_terr]);
        }

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            return view('rm_portal/docBrandSummary')->with(['rm_terr' => $rm_terr]);

        }
    }

function brand_wise_regdoc()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;


        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' =  (select rm_terr_id from rm_gm_info  where  rm_emp_id||asm_emp_id in ($uid) )
                                    and mpo_terr_id not like '%-501'
                                    order by rm_terr_id");
            $brand_name = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where  substr(terr_id,1,instr(terr_id,'-'))||'00'= (select rm_terr_id from rm_gm_info  where  rm_emp_id||asm_emp_id in ($uid))
                                order by brand_name asc            
                                ");
            return view('rm_portal/brandWiseRegionalDoc')->with(['rm_terr' => $rm_terr, 'brand_name' => $brand_name]);
        }

        if (Auth::user()->desig === 'GM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            $brand_name = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where  substr(terr_id,1,instr(terr_id,'-'))||'00'= (select rm_terr_id from rm_gm_info  where gm_emp_id in ($uid))
                                order by brand_name asc            
                                ");
            return view('rm_portal/brandWiseRegionalDoc')->with(['rm_terr' => $rm_terr, 'brand_name' => $brand_name]);
        }

        if (Auth::user()->desig === 'NSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");
            $brand_name = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where  substr(terr_id,1,instr(terr_id,'-'))||'00'= (select rm_terr_id from rm_gm_info  where  nsm_emp_id in ($uid))
                                order by brand_name asc            
                                ");
            return view('rm_portal/brandWiseRegionalDoc')->with(['rm_terr' => $rm_terr, 'brand_name' => $brand_name]);
        }

        if (Auth::user()->desig === 'SM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $brand_name = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where  substr(terr_id,1,instr(terr_id,'-'))||'00'= (select rm_terr_id from rm_gm_info  where  sm_emp_id in ($uid))
                                order by brand_name asc            
                                ");

            return view('rm_portal/brandWiseRegionalDoc')->with(['rm_terr' => $rm_terr,'brand_name' => $brand_name]);
        }

        if (Auth::user()->desig === 'DSM') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                                order by rm_terr_id");

            $brand_name = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where  substr(terr_id,1,instr(terr_id,'-'))||'00'= (select rm_terr_id from rm_gm_info  where  sm_emp_id in ($uid))
                                order by brand_name asc            
                                ");

            return view('rm_portal/brandWiseRegionalDoc')->with(['rm_terr' => $rm_terr , 'brand_name' => $brand_name]);
        }

        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                    order by rm_terr_id");

            return view('rm_portal/brandWiseRegionalDoc')->with(['rm_terr' => $rm_terr]);

        }
    }

    public function dwdvp()
{
    DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
    $uid = Auth::user()->user_id;

    // echo $uid;


    if (Auth::user()->desig === 'GM') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )
                            order by rm_terr_id");


        return view('rm_portal/dwdvp')->with(['rm_terr' => $rm_terr]);
    }

    if (Auth::user()->desig === 'NSM') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )
                            order by rm_terr_id");


        return view('rm_portal/dwdvp')->with(['rm_terr' => $rm_terr]);
    }

    if (Auth::user()->desig === 'SM') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )
                            order by rm_terr_id");

        return view('rm_portal/dwdvp')->with(['rm_terr' => $rm_terr]);
    }

    if (Auth::user()->desig === 'DSM') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )
                            order by rm_terr_id");


        return view('rm_portal/dwdvp')->with(['rm_terr' => $rm_terr]);
    }

    if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)                                       
                                order by rm_terr_id");
        return view('rm_portal/dwdvp')->with(['rm_terr' => $rm_terr]);
    }


    if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
        $rm_terr = DB::select("select distinct rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                            and mpo_terr_id not like '%-501'  
                            order by rm_terr_id");

        $am_terr = DB::select("select distinct am_terr_id
                        from hrtms.hr_terr_list@web_to_hrtms
                        where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                        and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                        and mpo_terr_id not like '%-501'  
                        order by am_terr_id");



        return view('rm_portal/dwdvp')->with(['rm_terr' => $rm_terr, 'am_terr' => $am_terr]);
    }


    if (Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO') {
        $all_terr = DB::select("select distinct rm_terr_id,am_terr_id,mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id in (select distinct mpo_terr_id
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where  mpo_emp_id = '$uid'
                                                    and to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))
                                                    and mpo_terr_id not like '-500%'                    
                                order by mpo_terr_id");

        return view('rm_portal/dwdvp')->with(['all_terr' => $all_terr]);
    }

    if (Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM') {

        $all_terr = DB::select("select distinct rm_terr_id,am_terr_id,mpo_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and mpo_terr_id in (select distinct mpo_terr_id
                                                from hrtms.hr_terr_list@web_to_hrtms
                                                where  AM_EMP_ID = '$uid'
                                                AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))
                            and mpo_terr_id not like '-500%'                    
                            order by rm_terr_id");

        return view('rm_portal/dwdvp')->with(['all_terr' => $all_terr]);
    }
}




public function terrWsalesAchIndex()
{

    DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
    $uid = Auth::user()->user_id;

    $workingDate = DB::select("select distinct wdate wdate
    from mis.daily_sales_achivement");

    $sales_area_name = DB::select("select distinct sales_area_name from mis.daily_sales_achivement");


    if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
        $am_terr = DB::select("select distinct am_terr_id am_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                            order by am_terr_id");


        return view('rm_portal/terrWise_Ach')->with(['am_terr' => $am_terr, 'workingDate' => $workingDate, 'sales_ar_name' => $sales_area_name]);
    }

    if (Auth::user()->desig === 'GM') {

        Log::info(Auth::user()->user_id . ' | ' . Auth::user()->desig);
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ($uid) )   
                            order by rm_terr_id");


        return view('rm_portal/terrWise_Ach')->with(['rm_terr' => $rm_terr, 'workingDate' => $workingDate, 'sales_ar_name' => $sales_area_name]);
    }

    if (Auth::user()->desig === 'NSM') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ($uid) )   
                            order by rm_terr_id");


        return view('rm_portal/terrWise_Ach')->with(['rm_terr' => $rm_terr, 'workingDate' => $workingDate, 'sales_ar_name' => $sales_area_name]);
    }

    if (Auth::user()->desig === 'SM') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ($uid) )   
                            order by rm_terr_id");

        return view('rm_portal/terrWise_Ach')->with(['rm_terr' => $rm_terr, 'workingDate' => $workingDate,'sales_ar_name' => $sales_area_name]);
    }

    if (Auth::user()->desig === 'DSM') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ($uid) )   
                            order by rm_terr_id");


        return view('rm_portal/terrWise_Ach')->with(['rm_terr' => $rm_terr, 'workingDate' => $workingDate,'sales_ar_name' => $sales_area_name]);
    }

    if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                order by rm_terr_id");
        return view('rm_portal/terrWise_Ach')->with(['rm_terr' => $rm_terr, 'workingDate' => $workingDate,'sales_ar_name' => $sales_area_name]);
    }

    if (Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO') {
        $rm_terr = DB::select("select distinct rm_terr_id, am_terr_id, mpo_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and mpo_terr_id in (select distinct mpo_terr_id 
                                                from hrtms.hr_terr_list@web_to_hrtms  
                                                where  MPO_EMP_ID = '$uid' 
                                                AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                            order by rm_terr_id");

        $p_group = DB::select("select distinct p_group
        from sample_new.product_info@web_to_sample_msd
        where sap_code is not null
        order by p_group");


        return view('rm_portal/terrWise_Ach')->with(['rm_terr' => $rm_terr, 'p_group' => $p_group, 'workingDate' => $workingDate,'sales_ar_name' => $sales_area_name]);
    }

    if (Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM') {
        $rm_terr = DB::select("select distinct rm_terr_id,mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_terr_id in (select distinct am_terr_id 
                                                from hrtms.hr_terr_list@web_to_hrtms  
                                                where  AM_EMP_ID = '$uid'  
                                                AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                order by rm_terr_id");


        return view('rm_portal/terrWise_Ach')->with(['rm_terr' => $rm_terr, 'workingDate' => $workingDate,'sales_ar_name' => $sales_area_name]);
    }

}

public function regWTerrAmDataList(Request $request)
{
    DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
    $uid = $request->auth_id;
    $desig = $request->desig;

    if ($request->ajax()) {
        if ($desig === 'GM') {
            $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  GM_EMP_ID in ('$uid') )  
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                and am_terr_id not like '%-500%'
                                order by am_terr_id");
        }

        if ($desig === 'NSM') {
            $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  NSM_EMP_ID in ('$uid') )  
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                and am_terr_id not like '%-500%'
                                order by am_terr_id");
        }

        if ($desig === 'SM') {
            $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  SM_EMP_ID in ('$uid') )  
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                and am_terr_id not like '%-500%'
                                order by am_terr_id");
        }

        if ($desig === 'DSM') {
            $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO  where  DSM_EMP_ID in ('$uid') )  
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
                                and am_terr_id not like '%-500%'
                                order by am_terr_id");
        }

        if ($desig === 'All' || $desig === 'HO') {
            $resp_data = DB::Select("select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )  
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = decode( '$request->rmTerr','All',rm_terr_id, '$request->rmTerr')
                                and am_terr_id not like '%-500%'
                                order by am_terr_id");
        }
    }
    return response()->json($resp_data);
}

public function getPgroup(Request $request)
{
    $resp_data = DB::select("select distinct p_group
    from sample_new.product_info@web_to_sample_msd
    where sap_code is not null
    and brand_name is not null
    order by p_group");
    return response()->json($resp_data);
}

public function getPgroupByBrand(Request $request)
{
    $resp_data = DB::select("select distinct brand_name
    from sample_new.product_info@web_to_sample_msd
    where sap_code is not null
    and p_group = decode(?,'All',p_group,?) 
    order by brand_name", [$request->p_group, $request->p_group]);

    return response()->json($resp_data);
}

public function getProudctNamebyPGroup(Request $request)
{
    $resp_data = DB::select("select distinct p_code,name
    from sample_new.product_info@web_to_sample_msd
    where sap_code is not null
    and p_group = decode(?,'All',p_group,?) 
    and brand_name = decode(?,'All',brand_name,?) 
    order by name", [$request->p_group, $request->p_group, $request->brand_name, $request->brand_name]);
    return response()->json($resp_data);
}

public function getAch(Request $request)
{

    if ($request->desig == 'GM' || $request->desig == 'NSM' || $request->desig == 'SM' ||
        $request->desig == 'DSM' || $request->desig == 'All' || $request->desig == 'HO') {

        $rs = DB::select("select terr_id,p_group,brand_name,p_code,p_name,pack_size,trunc(tp,2) tp,round(target_qty) target_qty, 
        round(target_value) target_value,int_qty,int_value,sold_qty,sold_value,exp_sale_qty,exp_sale_value,trunc(achivement,2) achivement
        from(
        select 'All' all_data,report_type,wdate,rm_terr_id,am_terr_id,ewt.terr_id,sales_area_code,sales_area_name,p_group,brand_name,p_code,p_name,pack_size,
               tp,target_qty,target_value,int_qty,int_value,sold_qty,sold_value,exp_sale_qty,exp_sale_value,achivement
        from mis.daily_sales_achivement dsa,(select mpo_terr_id,terr_id from mis.employee_wise_territory
                                             where emp_type = 'MPO') ewt
        where dsa.terr_id = ewt.mpo_terr_id    
        )where '$request->rm_terr' = case when '$request->rm_terr' = 'All' then All_data else rm_terr_id end
        and '$request->am_terr' = case when '$request->am_terr' = 'All' then All_data else am_terr_id end
        and '$request->mpo_terr' = case when '$request->mpo_terr' = 'All' then All_data else terr_id end
        and '$request->p_group' = case when '$request->p_group' = 'All' then All_data else p_group end
        and '$request->brand_name' = case when '$request->brand_name' = 'All' then All_data else brand_name end
        and '$request->p_code' = case when '$request->p_code' = 'All' then All_data else p_code end
        and '$request->sa_name' = case when '$request->sa_name' = 'All' then All_data else sales_area_name end
        order by rm_terr_id,am_terr_id,terr_id,p_name");

        return response()->json($rs);

    } else {


        $rs = DB::select("
        select terr_id,sales_area_code,sales_area_name,p_group,brand_name,p_code,p_name,pack_size, trunc(tp,2) tp,round(target_qty) target_qty, 
        round(target_value) target_value,int_qty,int_value,sold_qty,sold_value,exp_sale_qty,exp_sale_value,trunc(achivement,2) achivement
        from(
        select 'All' All_data,report_type,wdate,rm_terr_id,am_terr_id,sales_area_code, sales_area_name,ewt.terr_id,p_group,brand_name, p_code,p_name,pack_size,tp,target_qty, 
        target_value,int_qty,int_value,sold_qty,sold_value,exp_sale_qty,exp_sale_value,achivement
        from mis.daily_sales_achivement dsa,(select mpo_terr_id,terr_id from mis.employee_wise_territory
                                     where login_emp_id = '$request->auth_id') ewt
        where dsa.terr_id = ewt.mpo_terr_id
        )where '$request->rm_terr' = case when '$request->rm_terr' = 'All' then All_data else rm_terr_id end
        and '$request->am_terr' = case when '$request->am_terr' = 'All' then All_data else am_terr_id end
        and '$request->mpo_terr' = case when '$request->mpo_terr' = 'All' then All_data else terr_id end
        and '$request->p_group' = case when '$request->p_group' = 'All' then All_data else p_group end
        and '$request->p_code' = case when '$request->p_code' = 'All' then All_data else p_code end
        and '$request->brand_name' = case when '$request->brand_name' = 'All' then All_data else brand_name end
        and '$request->sa_name' = case when '$request->sa_name' = 'All' then All_data else sales_area_name end
        order by rm_terr_id,am_terr_id,terr_id,p_name
        ");


        return response()->json($rs);
    }





}

public function RmAmWsalesAchIndex()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        $workingDate = DB::select("select distinct wdate wdate from mis.daily_sales_achivement");

        if (Auth::user()->desig === 'GM') {
            $sm_terr = DB::table('mis.rm_gm_info')->where('gm_emp_id',$uid)->where('sm_emp_id','!=',null)->select('sm_emp_id','sm_name')->distinct()->get();
            $dsm_terr = DB::table('mis.rm_gm_info')->where('gm_emp_id',$uid)->where('dsm_emp_id','!=',null)->select('dsm_emp_id','dsm_name')->distinct()->get();
            $rm_terr = DB::table('mis.rm_gm_info')->where('gm_emp_id',$uid)->where('rm_terr_id','!=',null)->select('rm_terr_id')->distinct()->get();
            $brands = DB::table('mis.daily_sales_achivement')->select('brand_name')->distinct()->orderBy('brand_name')->get();
            return view('rm_portal/RmAmWise_AchUpdated')->with(['workingDate' => $workingDate,'sm_terr'=>$sm_terr,'dsm_terr'=>$dsm_terr,'rm_terr'=>$rm_terr,'brands'=>$brands]);
        }
        elseif (Auth::user()->desig === 'SM') {
            $dsm_terr = DB::table('mis.rm_gm_info')->where('sm_emp_id',$uid)->where('dsm_emp_id','!=',null)->select('dsm_emp_id','dsm_name')->distinct()->get();
            $rm_terr = DB::table('mis.rm_gm_info')->where('sm_emp_id',$uid)->where('rm_terr_id','!=',null)->select('rm_terr_id')->distinct()->get();
            $brands = DB::table('mis.daily_sales_achivement')->select('brand_name')->distinct()->orderBy('brand_name')->get();
            return view('rm_portal/RmAmWise_AchUpdated')->with(['workingDate' => $workingDate,'rm_terr'=>$rm_terr,'dsm_terr'=>$dsm_terr,'brands'=>$brands]);
        }
        elseif (Auth::user()->desig === 'DSM') {
            $sm_terr = DB::table('mis.rm_gm_info')->where('dsm_emp_id',$uid)->select('sm_emp_id','sm_name')->first();
            $rm_terr = DB::table('mis.rm_gm_info')->where('dsm_emp_id',$uid)->where('rm_terr_id','!=',null)->select('rm_terr_id')->distinct()->get();
            $brands = DB::table('mis.daily_sales_achivement')->select('brand_name')->distinct()->orderBy('brand_name')->get();
            return view('rm_portal/RmAmWise_AchUpdated')->with(['workingDate' => $workingDate,'rm_terr'=>$rm_terr,'sm_terr'=>$sm_terr,'brands'=>$brands]);
        }
        elseif (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {
            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                            from hrtms.hr_terr_list@web_to_hrtms
                            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )   
                            order by am_terr_id");


            return view('rm_portal/RmAmWise_Ach2')->with(['am_terr' => $am_terr, 'workingDate' => $workingDate]);
        }

        elseif (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO)   
                                order by rm_terr_id");
            return view('rm_portal/RmAmWise_Ach2')->with(['rm_terr' => $rm_terr, 'workingDate' => $workingDate]);
        }
        elseif (Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO') {
            $rm_terr = DB::select("select distinct rm_terr_id, am_terr_id, mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id in (select distinct mpo_terr_id 
                                                    from hrtms.hr_terr_list@web_to_hrtms  
                                                    where  MPO_EMP_ID = '$uid' 
                                                    AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                order by rm_terr_id");

            $p_group = DB::select("select distinct p_group
            from sample_new.product_info@web_to_sample_msd
            where sap_code is not null
            order by p_group");

            $brands = DB::table('mis.daily_sales_achivement')->where([['daily_sales_achivement.rm_terr_id',$rm_terr[0]->rm_terr_id], ['daily_sales_achivement.am_terr_id', $rm_terr[0]->am_terr_id],['terr_id',Auth::user()->terr_id]])->select('brand_name')->distinct()->get();
            return view('rm_portal/RmAmWise_Ach2')->with(['rm_terr' => $rm_terr,'brands'=>$brands, 'p_group' => $p_group, 'workingDate' => $workingDate]);
        }
        elseif (Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM') {
            $rm_terr = DB::select("select distinct rm_terr_id,mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and am_terr_id in (select distinct am_terr_id 
                                                from hrtms.hr_terr_list@web_to_hrtms  
                                                where  AM_EMP_ID = '$uid'  
                                                AND to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR'))   
                                order by rm_terr_id");

            // dd($rm_terr);
            $brands = DB::table('mis.daily_sales_achivement')->where([['daily_sales_achivement.rm_terr_id',$rm_terr[0]->rm_terr_id], ['daily_sales_achivement.am_terr_id', Auth::user()->terr_id]])->select('brand_name')->distinct()->get();
            return view('rm_portal/RmAmWise_Ach2')->with(['rm_terr' => $rm_terr,'brands'=>$brands, 'workingDate' => $workingDate]);
        }
    }

    public function regWDsmTerrAmDataList(Request $data){
        $dsm_terr = DB::table('mis.rm_gm_info')->where([['gm_emp_id',$data->auth_id]])
                    ->when(($data->smTerr!=''),function(QueryBuilder $query)use($data){
                        $query->where([['sm_emp_id',$data->smTerr]]);
                    })
                    ->where('dsm_emp_id','!=',null)->select('dsm_emp_id','dsm_name')->distinct()->get();
        $rm_terr = DB::table('mis.rm_gm_info')->where([['gm_emp_id',$data->auth_id]])
                    ->when(($data->smTerr!=''),function(QueryBuilder $query)use($data){
                        $query->where([['sm_emp_id',$data->smTerr]]);
                    })
                   ->where('rm_terr_id','!=',null)->select('rm_terr_id')->distinct()->get();

        return response()->json([
            'dsm_terr'=>$dsm_terr,
            'rm_terr'=>$rm_terr,
        ]);
    }

    public function regWRmTerrAmDataList(Request $data){
        if(Auth::user()->desig=='GM'){
            $getdata =  $data->dsmTerr==''?'All':($data->dsmTerr=='All'?'All':$data->dsmTerr);
            $dsm = DB::table('mis.rm_gm_info')
            ->where([['gm_emp_id',$data->auth_id]])
            ->when(($data->smTerr!=''),function(QueryBuilder $query)use($data){
                $query->where([['sm_emp_id',$data->smTerr]]);
            })
            ->when(($getdata!='All'),function(QueryBuilder $query)use($data){
                $query->where([['dsm_emp_id',$data->dsmTerr]]);
            });
           
            $rm_terr = $dsm->where('rm_terr_id','!=',null)->select('rm_terr_id')->distinct()->get();
    
            return response()->json([
                'rm_terr'=>$rm_terr,
            ]);
        }elseif(Auth::user()->desig=='SM'){
            $getdata =  $data->dsmTerr==''?'All':($data->dsmTerr=='All'?'All':$data->dsmTerr);
            $dsm = DB::table('mis.rm_gm_info')
            ->where([['sm_emp_id',$data->smTerr]])
            ->when(($getdata!='All'),function(QueryBuilder $query)use($data){
                $query->where([['dsm_emp_id',$data->dsmTerr]]);
            });
           
            $rm_terr = $dsm->where('rm_terr_id','!=',null)->select('rm_terr_id')->distinct()->get();
    
            return response()->json([
                'rm_terr'=>$rm_terr,
            ]);
        }
       
    }


    public function getRmAmPgroupByBrand(Request $request)
    {
        if($request->amTerr == ''){
            $resp_data = DB::table('mis.daily_sales_achivement')->where([['daily_sales_achivement.rm_terr_id',$request->rmTerrId]])->select('brand_name')->distinct()->get();
        }elseif ($request->amTerr == 'All') {
            $resp_data = DB::table('mis.daily_sales_achivement')->where([['daily_sales_achivement.rm_terr_id',$request->rmTerrId]])->select('brand_name')->distinct()->get();
        } else {
            $resp_data = DB::table('mis.daily_sales_achivement')->where([['daily_sales_achivement.rm_terr_id',$request->rmTerrId], ['daily_sales_achivement.am_terr_id', $request->amTerr]])->select('brand_name')->distinct()->get();
        }
        return response()->json($resp_data);
    }


    public function getRmAmAch(Request $data)
    {
        /** GM Part */


        if($data->desig=='GM' || $data->desig=='SM' || $data->desig=='DSM'){
            $dsm_terr = $data->dsm_terr==''?'All':($data->dsm_terr=='All'?'All':$data->dsm_terr);
            $rm_terr = $data->rm_terr==''?'All':($data->rm_terr=='All'?'All':$data->rm_terr);
            $query = DB::table('rm_gm_info')
                    // ->where('gm_emp_id',$data->auth_id)
                    ->when($data->desig=='GM',function(QueryBuilder $q)use($data,$dsm_terr,$rm_terr){
                        $q->where('gm_emp_id',$data->auth_id)
                        ->when($data->sm_terr!='',function(QueryBuilder $r)use($data){
                            $r->where('sm_emp_id',$data->sm_terr);
                        })
                        ->when($dsm_terr!='All',function(QueryBuilder $r)use($data){
                            $r->where('dsm_emp_id',$data->dsm_terr);
                        })
                        ->when($rm_terr!='All',function(QueryBuilder $r)use($data){
                            $r->where('rm_terr_id',$data->rm_terr);
                        });
                    })
                    ->when($data->desig=='SM',function(QueryBuilder $q)use($data,$dsm_terr,$rm_terr){
                        $q->where('sm_emp_id',$data->auth_id)
                        
                        ->when($dsm_terr!='All',function(QueryBuilder $r)use($data){
                            $r->where('dsm_emp_id',$data->dsm_terr);
                        })
                        ->when($rm_terr!='All',function(QueryBuilder $r)use($data){
                            $r->where('rm_terr_id',$data->rm_terr);
                        });
                    })
                    ->when($data->desig=='DSM',function(QueryBuilder $q)use($data,$dsm_terr,$rm_terr){
                        $q->where('dsm_emp_id',$data->auth_id)
                        ->when($rm_terr!='All',function(QueryBuilder $r)use($data){
                            $r->where('rm_terr_id',$data->rm_terr);
                        });
                    });
                    
           
            $allRM = $query->select('rm_terr_id','rm_name')->distinct()->get();
            
            $brandProducts = DB::table('daily_sales_achivement')->where('brand_name',$data->brand_name)->select('p_name','p_code')->distinct()->orderBy('p_code')->get();
            $productWise = [];
            $brandreport = [
                'brand'=>$data->brand_name,
                'target_qty'=>0,
                'sold_qty'=>0,
                'int_qty'=>0,
                'exp_sale_qty'=>0,
                'ach'=>0,
                'brandProductWise'=>[],
            ];
            foreach($brandProducts as $brandProduct){
                $finalData = [
                    'p_name'=>'',
                    'p_code'=>'',
                    'target_qty'=>0,
                    'sold_qty'=>0,
                    'int_qty'=>0,
                    'exp_sale_qty'=>0,
                    'ach'=>0,
                    'rtype'=>'',
                    'productWiseReport'=>[],
                ];
                $finalData['p_name']=$brandProduct->p_name;
                $finalData['p_code']=$brandProduct->p_code;
                
                if(count($allRM)>0){
                    foreach($allRM as $allRMValue){
                        $rmData = [
                            'terr_id'=>null,
                            'terr_emp_id'=>null,
                            'terr_emp_name'=>null,
                            'target_qty'=>0,
                            'sold_qty'=>0,
                            'int_qty'=>0,
                            'exp_sale_qty'=>0,
                            'ach'=>0,
                            'rtype'=>'',
                        ];
                        $rmSalesData = DB::table('daily_sales_achivement')->where([['rm_terr_id',$allRMValue->rm_terr_id],['p_code',$finalData['p_code']]])->get();
                        if(count($rmSalesData)>0){
                            $rmData['terr_id']=$allRMValue->rm_terr_id;
                            $rmData['target_qty']=round($rmSalesData->sum('target_qty'),2);
                            $rmData['sold_qty']=round($rmSalesData->sum('sold_qty'),2);
                            $rmData['int_qty']=round($rmSalesData->sum('int_qty'),2);
                            $rmData['exp_sale_qty']=round($rmSalesData->sum('exp_sale_qty'),2);
                            $rmData['rtype']=$rmSalesData[0]->report_type;
                            $rmData['ach']=round($rmData['rtype']=='DAILY'?(($rmData['exp_sale_qty']*100)/($rmData['target_qty']==0?1:$rmData['target_qty'])):(($brandreport['sold_qty']*100)/($rmData['target_qty']==0?1:$rmData['target_qty'])),2);
                            
                            
                        }else{
                            $rmData['terr_id']=$allRMValue->rm_terr_id;
                        }
                        array_push($finalData['productWiseReport'],$rmData);

                        $finalData['target_qty'] = round($finalData['target_qty']+$rmData['target_qty'],2);
                        $finalData['sold_qty'] = round($finalData['sold_qty']+$rmData['sold_qty'],2);
                        $finalData['int_qty'] = round($finalData['int_qty']+$rmData['int_qty'],2);
                        $finalData['exp_sale_qty'] = round($finalData['exp_sale_qty']+$rmData['exp_sale_qty'],2);
                        $finalData['rtype'] = $rmData['rtype'];
                    }
                }
                
               $finalData['ach'] = round($finalData['rtype']=='DAILY'?(($finalData['exp_sale_qty']*100)/($finalData['target_qty']==0?1:$finalData['target_qty'])):(($finalData['sold_qty']*100)/($finalData['target_qty']==0?1:$finalData['target_qty'])),2);


                $brandreport['target_qty'] = round($finalData['target_qty']+$brandreport['target_qty'],2);
                $brandreport['sold_qty'] = round($finalData['sold_qty']+$brandreport['sold_qty'],2);
                $brandreport['int_qty'] = round($finalData['int_qty']+$brandreport['int_qty'],2);
                $brandreport['exp_sale_qty'] = round($finalData['exp_sale_qty']+$brandreport['exp_sale_qty'],2);
                $brandreport['rtype'] = $finalData['rtype'];

               array_push($productWise,$finalData);
            }
            $brandreport['ach'] = round($brandreport['rtype']=='DAILY'?(($brandreport['exp_sale_qty']*100)/($brandreport['target_qty']==0?1:$brandreport['target_qty'])):(($brandreport['sold_qty']*100)/($brandreport['target_qty']==0?1:$brandreport['target_qty'])),2);
            array_push($brandreport['brandProductWise'],$productWise);
            
            // dd($brandreport);

            $responseData = '';

            $responseData = $responseData."<tr style='height:30px;' class='bg-primary ".$brandreport['brand']."' id='brandData' data-next='".$brandreport['brand']."'><td style='padding-top:.4%;text-align:center'>".$brandreport['brand']." <button class='btn btn-sm btn-primary' style='float:right;padding:0px 5px;margin-right:10px'>+</button></td><td style='padding-top:.4%;'>".$brandreport['target_qty']."</td><td style='padding-top:.4%;'>".$brandreport['sold_qty']."</td><td style='padding-top:.4%;'>".$brandreport['int_qty']."</td><td style='padding-top:.4%;'>".$brandreport['exp_sale_qty']."</td><td style='padding-top:.4%;'>".$brandreport['ach']."</td></tr>";

            if(count($brandreport['brandProductWise'][0])>0){
                foreach($brandreport['brandProductWise'][0] as $pwKey=>$pwValue){
                    $responseData = $responseData."<tr style='height:25px;display:none' class='bg-success ".$brandreport['brand']."-child next-".$brandreport['brand']."' data-next='".$pwValue['p_code']."'><td style='text-align:center'>".$pwValue['p_name']." <button class='btn btn-sm btn-light' style='float:right;padding:0px 5px;margin-right:15px'>+</button></td></td><td style='padding-top:.4%;'>".$pwValue['target_qty']."</td><td style='padding-top:.4%;'>".$pwValue['sold_qty']."</td><td style='padding-top:.4%;'>".$pwValue['int_qty']."</td><td style='padding-top:.4%;'>".$pwValue['exp_sale_qty']."</td><td style='padding-top:.4%;'>".$pwValue['ach']."</td></tr>";


                    if(count($pwValue['productWiseReport'])>0){
                        foreach($pwValue['productWiseReport'] as $rmKey=>$rmValue){
                            $responseData = $responseData."<tr style='height:25px;display:none' id='smROW' class='bg-danger ".$pwValue['p_code']."-child ".$brandreport['brand']."-child next-".$pwValue['p_code']."' data-next='".$pwValue['p_code'].$rmValue['terr_id']."'><td style='text-align:center'>".$rmValue['terr_id']."</td><td style='padding-top:.4%;'>".$rmValue['target_qty']."</td><td style='padding-top:.4%;'>".$rmValue['sold_qty']."</td><td style='padding-top:.4%;'>".$rmValue['int_qty']."</td><td style='padding-top:.4%;'>".$rmValue['exp_sale_qty']."</td><td style='padding-top:.4%;'>".$rmValue['ach']."</td></tr>";
                            
                        }
                    }
                }
            }

            return response()->json($responseData);
            

        }
        
    }

    public function getRmAmAchRM(Request $request){
        if($request->am_terr=='All'){
            $data = DB::table('mis.daily_sales_achivement')->where([['rm_terr_id',$request->rm_terr],['brand_name',$request->brand_name]]);
        }else{
            $data = DB::table('mis.daily_sales_achivement')->where([['rm_terr_id',$request->rm_terr],['am_terr_id',$request->am_terr],['brand_name',$request->brand_name]])
            ->when($request->mpo_terr,function(QueryBuilder $query)use($request){
                $query->where([['terr_id',$request->mpo_terr]]);
            });
        }
        

        // $target_qty = 0;
        $data = $data->orderBy('p_name','ASC')->get();
        $total_target_qty = round($data->sum('target_qty'),3);
        $total_target_value = round($data->sum('target_value'),3);

        $total_sold_qty = round($data->sum('sold_qty'),3);
        $total_sold_value = round($data->sum('sold_value'),3);

        $total_int_qty = round($data->sum('int_qty'),3);
        $total_int_value = round($data->sum('int_value'),3);

        $total_exp_sale_qty = round($data->sum('exp_sale_qty'),3);
        $total_exp_sale_value = round($data->sum('exp_sale_value'),3);

        $total_ach = round(($data[0]->report_type=='DAILY'?($total_exp_sale_qty*100)/($total_target_qty==0?1:$total_target_qty):($total_sold_qty*100)/($total_target_qty==0?1:$total_target_qty)),2);

        
        $product = array();
        $product_code = array();
        $product_data=array();
        foreach($data as $key=>$val){
            if(!in_array($val->p_name,$product)){
                array_push($product,$val->p_name);
                array_push($product_code,$val->p_code);
                $info = array();
                array_push($info,round($val->target_qty,3),round($val->target_value,3),round($val->sold_qty,3),round($val->sold_value,3),round($val->int_qty,3),round($val->int_value,3),round($val->exp_sale_qty,3),round($val->exp_sale_value,3));
                array_push($product_data,$info);
            }else{
                $index = array_search($val->p_name,$product);
                $product_data[$index][0]=round($product_data[$index][0]+round($val->target_qty,3),3);
                $product_data[$index][1]=round($product_data[$index][1]+round($val->target_value,3),3);
                $product_data[$index][2]=round($product_data[$index][2]+round($val->sold_qty,3),3);
                $product_data[$index][3]=round($product_data[$index][3]+round($val->sold_value,3),3);
                $product_data[$index][4]=round($product_data[$index][4]+round($val->int_qty,3),3);
                $product_data[$index][5]=round($product_data[$index][5]+round($val->int_value,3),3);
                $product_data[$index][6]=round($product_data[$index][6]+round($val->exp_sale_qty,3),3);
                $product_data[$index][7]=round($product_data[$index][7]+round($val->exp_sale_value,3),3);
            }
        }
        
        $product_wise_data = array();
        $product_wise_am_terr = array();
        foreach($product_code as $codeKey=>$code){
            $pwData = DB::table('mis.daily_sales_achivement')
            ->where([['rm_terr_id',$request->rm_terr],['brand_name',$request->brand_name],['p_code',$code]])
            ->when($request->am_terr!='All',function(QueryBuilder $query)use($request){
                $query->where([['am_terr_id',$request->am_terr]]);
            })
            ->when($request->mpo_terr,function(QueryBuilder $query)use($request){
                $query->where([['terr_id',$request->mpo_terr]]);
            })
            ->select('am_terr_id')
            ->orderBy('am_terr_id')
            ->distinct()
            ->get();
            $pwDataPushArray = [];
            foreach($pwData as $pwValue){
                $sumpwValue =  DB::table('mis.daily_sales_achivement')
                ->where([['rm_terr_id',$request->rm_terr],['brand_name',$request->brand_name],['p_code',$code],['am_terr_id',$pwValue->am_terr_id]])
                ->when($request->mpo_terr,function(QueryBuilder $query)use($request){
                    $query->where([['terr_id',$request->mpo_terr]]);
                })
                ->get();
                if(Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM' || Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO'){
                    foreach($sumpwValue as $keyAmMpo=>$valAmMpo){
                        $pwDataPush = array(
                            'terr_id'=>$valAmMpo->terr_id,
                            'target_qty'=>round($valAmMpo->target_qty,3),
                            'target_value'=>round($valAmMpo->target_value,3),
                            'sold_qty'=>round($valAmMpo->sold_qty,3),
                            'sold_value'=>round($valAmMpo->sold_value,3),
                            'int_qty'=>round($valAmMpo->int_qty,3),
                            'int_value'=>round($valAmMpo->int_value,3),
                            'exp_sale_qty'=>round($valAmMpo->exp_sale_qty,3),
                            'exp_sale_value'=>round($valAmMpo->exp_sale_value,3),
                            'achivement'=>round($valAmMpo->achivement,3),
                        );
                        array_push($pwDataPushArray,$pwDataPush);
                    }
                }else{
                    $pwDataPush = array(
                        'terr_id'=>$pwValue->am_terr_id,
                        'target_qty'=>round($sumpwValue->sum('target_qty'),3),
                        'target_value'=>round($sumpwValue->sum('target_value'),3),
                        'sold_qty'=>round($sumpwValue->sum('sold_qty'),3),
                        'sold_value'=>round($sumpwValue->sum('sold_value'),3),
                        'int_qty'=>round($sumpwValue->sum('int_qty'),3),
                        'int_value'=>round($sumpwValue->sum('int_value'),3),
                        'exp_sale_qty'=>round($sumpwValue->sum('exp_sale_qty'),3),
                        'exp_sale_value'=>round($sumpwValue->sum('exp_sale_value'),3),
                        'achivement'=>round($sumpwValue->sum('achivement'),3),
                    );
                    array_push($pwDataPushArray,$pwDataPush);
                }
               
            }
            
            array_push($product_wise_data,$pwDataPushArray);
        }
        return response()->json([
            'data'=>$data,
            'total_target_qty'=>$total_target_qty,
            'total_target_value'=>$total_target_value,
            'total_sold_qty'=>$total_sold_qty,
            'total_sold_value'=>$total_sold_value,
            'total_int_qty'=>$total_int_qty,
            'total_int_value'=>$total_int_value,
            'total_exp_sale_qty'=>$total_exp_sale_qty,
            'total_exp_sale_value'=>$total_exp_sale_value,
            'total_ach'=>$total_ach,
            'product'=>$product,
            'product_data'=>$product_data,
            'product_code'=>$product_code,
            'product_wise_data'=>$product_wise_data,
        ]);
    }

}



