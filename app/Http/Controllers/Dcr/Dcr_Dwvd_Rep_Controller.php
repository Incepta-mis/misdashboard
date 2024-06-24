<?php

namespace App\Http\Controllers\Dcr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dcr_Dwvd_Rep_Controller extends Controller
{
    protected function dwvd_view(){
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        if (Auth::user()->desig === 'RM') {

            $p_group = DB::select("Select distinct terr_GROUP PRODUCT_GROUP
                               from MIS.DASH_TERRITORY_GROUP
                               where terr_type = '" . Auth::user()->p_group . "'
                               order by terr_GROUP");

            $am_terr = DB::select("select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id
                                from mis.rm_gm_info rgi,MIS.DCR_DOC_WISE_ITEM_UTILIZATION dcs 
                                where (RM_EMP_ID = " . Auth::user()->user_id . " OR ASM_EMP_ID = " . Auth::user()->user_id . ")
                                and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                order by substr(am_terr_id,-3,2) asc");

            $terr_id = DB::select("select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                from mis.rm_gm_info rgi,MIS.DCR_DOC_WISE_ITEM_UTILIZATION dcs 
                                where (RM_EMP_ID = " . Auth::user()->user_id . " OR ASM_EMP_ID = " . Auth::user()->user_id . ")
                                and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'");

            $array = ['pgrp' => $p_group, 'am_terr' => $am_terr, 'terrs' => $terr_id];

        } else if (Auth::user()->desig === 'GM' || Auth::user()->desig === 'NSM' || Auth::user()->desig === 'SM' ||
            Auth::user()->desig === 'DSM' || Auth::user()->desig === 'ASM') {

            $p_group = DB::select("Select distinct terr_GROUP PRODUCT_GROUP
                               from MIS.DASH_TERRITORY_GROUP
                               where terr_type = '" . Auth::user()->p_group . "'
                               order by terr_GROUP");

            $emp_id = "";

            if (Auth::user()->desig === 'GM') {
                $emp_id = "rgi.gm_emp_id";
            } elseif (Auth::user()->desig === 'NSM') {
                $emp_id = "rgi.nsm_emp_id";
            } elseif (Auth::user()->desig === 'SM') {
                $emp_id = "rgi.sm_emp_id";
            } elseif (Auth::user()->desig === 'DSM') {
                $emp_id = "rgi.dsm_emp_id";
            } elseif (Auth::user()->desig === 'ASM') {
                $emp_id = "rgi.asm_emp_id";
            }

            $rm_terr = DB::select("select distinct rm_terr_id
                                 from mis.rm_gm_info rgi
                                 where " . $emp_id . " = " . Auth::user()->user_id . "
                                 order by rm_terr_id");

            $am_terr = DB::select("select am_terr_id from(
                                select distinct gai.rm_terr_id,am_terr_id
                                from
                                (select distinct rm_terr_id
                                from mis.rm_gm_info rgi
                                where " . $emp_id . " = " . Auth::user()->user_id . ") gai,
                                                                  (select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                                                    substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                                                                    from MIS.DCR_ITEM_WISE_UTILIZATION) dvs
                                where gai.rm_terr_id = dvs.rm_terr_id) order by substr(am_terr_id,-3,2) asc ");

            $terr_id = DB::select("select distinct terr_id
                                from(
                                select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                from mis.rm_gm_info rgi,MIS.DCR_ITEM_WISE_UTILIZATION dcs 
                                where " . $emp_id . " = " . Auth::user()->user_id . "
                                and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                ) order by terr_id");


            $array = ['pgrp' => $p_group, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'terrs' => $terr_id];


        } else if (Auth::user()->desig === 'AM') {

            $terr = Auth::user()->terr_id;

            $p_group = DB::select("Select distinct terr_GROUP PRODUCT_GROUP
                               from MIS.DASH_TERRITORY_GROUP
                               where terr_type = '" . Auth::user()->p_group . "'
                               order by terr_GROUP");


            $rm_terr = DB::select("select substr('$terr',1,instr('$terr','-'))||'00' rm_terr_id
                                   from dual");

            $am_terr = $terr;

            $terr_id = DB::select("Select terr_id from  MIS.DCR_ITEM_WISE_UTILIZATION 
                                  where substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$terr'");


            $array = ['pgrp' => $p_group, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'terrs' => $terr_id];

        }
        else if(Auth::user()->desig === 'All' || Auth::user()->desig === 'HO'){

            $p_group = DB::select("Select distinct terr_GROUP PRODUCT_GROUP
                               from MIS.DASH_TERRITORY_GROUP
                               order by terr_GROUP");


            $rm_terr = DB::select("select distinct rm_terr_id
                                 from mis.rm_gm_info rgi                                
                                 order by rm_terr_id");

            $am_terr = DB::select("select am_terr_id from(
                                select distinct gai.rm_terr_id,am_terr_id
                                from
                                (select distinct rm_terr_id
                                from mis.rm_gm_info rgi
                                ) gai,
                              (select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                                from MIS.DCR_ITEM_WISE_UTILIZATION) dvs
                                where gai.rm_terr_id = dvs.rm_terr_id) order by substr(am_terr_id,-3,2) asc ");

            $terr_id = DB::select("select distinct terr_id
                                from(
                                select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                from mis.rm_gm_info rgi,MIS.DCR_ITEM_WISE_UTILIZATION dcs 
                                where rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                ) order by terr_id");


            $array = ['pgrp' => $p_group, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'terrs' => $terr_id];

        }


        return view('dcr_reports_layout.v_doctor_wise_visit_details_v2')
            ->with($array);
    }

    protected function dwvd_data(Request $request){
        if($request->ajax()){
            $responses = DB::select("
                                Select PRODUCT_GROUP, TERR_ID, 
                                   EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, 
                                   DOCTOR_NAME,sum(NO_OF_CALL) NO_OF_CALL from (
                                SELECT PRODUCT_GROUP, TERR_ID, 
                                   EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, 
                                   DOCTOR_NAME, sum(NO_OF_CALL) NO_OF_CALL,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) AM_TERR_ID,
                                           substr(terr_id,1,instr(terr_id,'-'))||'00' RM_terr_id,dcr_date
                                FROM MIS.DCR_DOCTOR_WISE_VISIT_DETAILS
                                group by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME,
                                substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1),
                                           substr(terr_id,1,instr(terr_id,'-'))||'00',dcr_date
                                order by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME,NO_OF_CALL
                                )
                                where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                and rm_terr_id = decode('$request->rmterr','All',rm_terr_id,'$request->rmterr')
                                and am_terr_id = decode('$request->amterr','All',am_terr_id,'$request->amterr')
                                and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                and doctor_name = decode('$request->dname','All',doctor_name,'$request->dname')
                                and dcr_date between to_date('$request->dat1','DD-MM-RR') and to_date('$request->dat2','DD-MM-RR')
                                group by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME
                                order by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME,NO_OF_CALL
                                ");

            return response()->json($responses);
        }
    }

    protected function dwvd_terr_doc_list(Request $request){

        if($request->ajax()){


            if($request['type'] == 2)
            {

                $resp_doc_list = DB::select("select distinct doctor_name,doctor_id
                                         from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',doctor_name,'$request->pgrp')
                                         and terr_id = '$request->tid'
                                         order by doctor_name");

                return response()->json(['doctors'=>$resp_doc_list]);



            }
            else if($request['type'] == 1){

                $resp_terr_list = DB::select("select distinct terr_id
                                     from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                     where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                     order by terr_id");

                return response()->json(['terr'=>$resp_terr_list]);
            }
            else
            {
                $resp_terr_list = DB::select("select distinct terr_id
                                     from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                     where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                     order by terr_id");

                $resp_doc_list = DB::select("select distinct doctor_name,doctor_id
                                             from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                             where PRODUCT_GROUP = decode('$request->pgrp','All',doctor_name,'$request->pgrp')
                                             order by doctor_name");

                return response()->json(['terr'=>$resp_terr_list,'doctors'=>$resp_doc_list]);
            }



        }
    }

    protected function dwvd_terr_list(Request $request){
        if ($request->desig === 'RM') {

            $resp_terr_list = DB::select("Select terr_id 
                                                from ( 
                                                select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                                from mis.rm_gm_info rgi,MIS.DCR_DOC_WISE_ITEM_UTILIZATION dcs 
                                                where RM_EMP_ID = '$request->emp_id'
                                                and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                                )
                                                where am_terr_id = decode('$request->tid','All',am_terr_id,'$request->tid') 
                                                order by terr_id");
        } elseif ($request->desig === 'GM' || $request->desig === 'NSM' || $request->desig === 'SM' || $request->desig === 'DSM'
            || $request->desig === 'ASM') {

            $emp_id = "";

            if (Auth::user()->desig === 'GM') {
                $emp_id = "rgi.gm_emp_id";
            } elseif (Auth::user()->desig === 'NSM') {
                $emp_id = "rgi.nsm_emp_id";
            } elseif (Auth::user()->desig === 'SM') {
                $emp_id = "rgi.sm_emp_id";
            } elseif (Auth::user()->desig === 'DSM') {
                $emp_id = "rgi.dsm_emp_id";
            } elseif (Auth::user()->desig === 'ASM') {
                $emp_id = "rgi.asm_emp_id";
            }


            if ($request->type === 'am') {
                $resp_terr_list = DB::select("select am_terr_id
                                                from(
                                                select distinct gai.rm_terr_id,am_terr_id
                                                from
                                                (select distinct rm_terr_id
                                                from mis.rm_gm_info rgi
                                                where " . $emp_id . " = " . Auth::user()->user_id . ") gai,(select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                                                                    substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                                                                                    from MIS.DCR_DOC_WISE_ITEM_UTILIZATION) dvs
                                                where gai.rm_terr_id = dvs.rm_terr_id            
                                                )where rm_terr_id ='$request->tid' 
                                                order by substr(am_terr_id,-3,2) asc
                                                ");
            } elseif ($request->type === 'mpo') {

                $resp_terr_list = DB::select("select distinct terr_id
                                                from(
                                                select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                                from mis.rm_gm_info rgi,MIS.DCR_DOC_WISE_ITEM_UTILIZATION dcs 
                                                where " . $emp_id . " = " . Auth::user()->user_id . "
                                                and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                                and dcs.product_group = '$request->pgrp'
                                                ) 
                                                where am_terr_id = decode('$request->tid','All',am_terr_id,'$request->tid') 
                                                order by terr_id");

            }

        }
        elseif ($request->desig === 'All' || $request->desig === 'HO'){

            if ($request->type === 'am') {
                $resp_terr_list = DB::select("select am_terr_id
                                                from(
                                                select distinct gai.rm_terr_id,am_terr_id
                                                from
                                                (select distinct rm_terr_id
                                                from mis.rm_gm_info rgi
                                                ) gai,(select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                                                                    substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                                                                                    from MIS.DCR_DOCTOR_VISIT_SUMMARY) dvs
                                                where gai.rm_terr_id = dvs.rm_terr_id            
                                                )where rm_terr_id ='$request->tid'
                                                order by substr(am_terr_id,-3,2) asc");
            }
            elseif ($request->type === 'mpo')
            {

                $resp_terr_list = DB::select("select distinct terr_id
                                                    from(
                                                    select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                                    from mis.rm_gm_info rgi,MIS.DCR_DOCTOR_VISIT_SUMMARY dcs 
                                                    where rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                                    and dcs.product_group = '$request->pgrp'
                                                    ) 
                                                    where am_terr_id = decode('$request->tid','All',am_terr_id,'$request->tid') 
                                                    order by terr_id");

            }
        }


        return response()->json($resp_terr_list);
    }
}
