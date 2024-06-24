<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 1/26/2020
 * Time: 1:10 PM
 */

namespace App\Http\Controllers\Dmr;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class Doctor_Medicine_Requisition_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $tid = Auth::user()->terr_id;


        $month_name = DB::select("  select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 2)
                                    select *
                                      from (select trunc(add_months(sysdate, -1)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $product = DB::select("
                    select pi.p_code,brand_name,pack_s,s_p
                    from msfa.product_info@web_to_imsfa pi,msfa.product_info_price@web_to_imsfa pip
                    where pi.p_code = pip.p_code
                    
                    order by brand_name 
                                     ");

                                     if (Auth::user()->user_id === '1016856' || Auth::user()->user_id === '1005975') {

                                        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                        from hrtms.hr_terr_list@web_to_hrtms
                                        where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                        order by rm_terr_id
                                        ");
                            
                                      
                            
                                        return view('dmr.doctor_medicine_requisition')->with(['rm_terr' => $rm_terr,'month_name' => $month_name, 'product' =>$product]);
                                    }


  

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and case when  rm_emp_id is null then asm_emp_id end = ?", [$uid]);

            $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from RM_GM_INFO  where RM_EMP_ID ||ASM_EMP_ID in ('$uid') )
                                and am_terr_id not like '%500%'   
                                order by am_terr_id");


            return view('dmr.doctor_medicine_requisition')->with(['rm_terr' => $rm_terr,'month_name' => $month_name, 'am_terr' => $am_terr , 'product' =>$product]);
        }




        if (Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM') {

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

            return view('dmr.doctor_medicine_requisition')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr,'product' =>$product]);


        }

        if (Auth::user()->desig === 'MPO'|| Auth::user() ->desig == 'Sr. MPO') {

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

            $depo = DB::select("        select depot_id,depot_name
                                    from mis.dashboard_users_info dui,(select distinct mpo_terr_id,mpo_emp_id,d_id from hrtms.hr_terr_list@web_to_hrtms
                                   where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')) tl,
                                   (select d_id depot_id,name depot_name  from msfa.depot@web_to_imsfa) di                                   
                                    where user_id = '$uid'
                                    and dui.terr_id = tl.mpo_terr_id
                                    and tl.d_id = di.depot_id
                                    order by depot_id");

            $dter = DB::select(" select   distinct dc.doctor_id, dc.doctor_name, dt.terr_id
                from   doctor_info.doctor_information@web_to_sample_msd dc,
                doctor_info.doctor_terr@web_to_sample_msd dt
                where       dc.doctor_id = dt.doctor_id
                and dt.valid = 'YES'
                and nvl (dc.doctor_status, 'VALID') != 'DELETE'
                and dt.terr_id = '$tid'
                order by doctor_id
            ");

            return view('dmr.doctor_medicine_requisition')->with(['product' =>$product,'month_name' => $month_name, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'mpo_terr' => $mpo_terr, 'depo' =>$depo,'dterr'=>$dter]);


        }

    }

    public function prod_code(Request $request) {

        $product = DB::select("
                     select pi.p_code,brand_name,pack_s,cogm
                    from msfa.product_info@web_to_imsfa pi,mis.doctor_medicine_cogm pip
                    where pi.p_code = pip.p_code
                    
                      and pip.cogm_month = '$request->month'
                     order by brand_name 
                                     ");

        return response()->json($product);
    }

    public function insert_row_dmr(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR HH24:MI:SS' ");
        $systime = DB::select("
        select sysdate from dual
        ");

        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        $reqid = DB::select("select max(req_id)+1 req_id
        from
        (
        select 0 req_id from dual
        union all 
        select max(req_id) from mis.DOCTOR_MEDICINE_REQ
        )");

        $mpo_info = DB::select("

            select mpo_emp_id,mpo_name  from hrtms.hr_terr_list@web_to_hrtms ht where mpo_terr_id = '$request->mpoterr'
             and
            to_char(ht.emp_month,'DD-MON-YY')= (select to_char(trunc(sysdate,'mm'),'DD-MON-YY')  from dual)

        "
        );

        $gl_cc = DB::select("

        select gl,cost_center_id
        from
        (select distinct mpo_terr_id,case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL'
        when p_group in ('ASTER','GYRUS','LUCENT') then 'ASTER-GYRUS' when p_group in ('OPERON-XENOVISION') then 'OPERON-XENOVISION'
        when p_group like ('ANIMAL HEALTH%VACCINE DIVISION') then 'AHVD' when p_group in ('HYGIENE') then 'IHHL' else null end p_group 
        from hrtms.hr_terr_list@web_to_hrtms
        where to_char(emp_month,'MON-RR') = '$request->month') tl,(select gl,cost_center_id,cost_center_group from mis.DONATION_COST_CENTER
        where budget_type = 'MEDICINE') ccg
        where tl.p_group = ccg.cost_center_group
        and mpo_terr_id = '$request->mpoterr'

        "
        );

        if ($request->ajax()) {

            $verinfo = json_decode($request->insertdata);

            try{

                foreach ($verinfo as $data) {

                    $insert=  DB::insert("
    
                    INSERT INTO MIS.DOCTOR_MEDICINE_REQ (GL,COST_CENTER_ID,REQ_ID,REQ_DATE,REQ_MONTH,TERR_ID,EMP_ID,EMP_NAME,D_ID,
                    DOCTOR_ID,DOCTOR_NAME,P_CODE,PRODUCT_NAME,PACK_SIZE,QTY,S_P,TOT_VAL,CREATE_USER,CREATE_DATE)
                    VALUES   (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                    ", [$gl_cc[0]->gl,$gl_cc[0]->cost_center_id,$reqid[0]->req_id,$systime[0]->sysdate,$request->month,$request->mpoterr,
                    $mpo_info[0]->mpo_emp_id,$mpo_info[0]->mpo_name,$request->depo,$request->doctor,$request->docname,$data->pcode,
                    $data->pname,$data->psize,$data->quant,$data->sp,$data->sp_total,$uid,$systime[0]->sysdate]);
                }
    
                if($insert) {
                    return response()->json(['success' => 'Medicine requisition Successful']);
                }
                else{
                    return response()->json(['error' => 'Failed to save data']);
                }

            } catch (Oci8Exception $e) {
                return response()->json(['error' => 'Failed to save data']);
            }

            
        }


    }

    public function regwMpoTerrList(Request $request)
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

}