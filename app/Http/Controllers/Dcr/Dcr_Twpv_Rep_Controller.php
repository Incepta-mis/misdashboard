<?php
namespace App\Http\Controllers\Dcr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dcr_Twpv_Rep_Controller extends Controller{

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////DCR TERR WISE PLANT VISIT REPORT///////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////

    protected function terr_wise_plan_vs_it()
    {

        if (Auth::user()->desig === 'RM') {

            $p_group = DB::select("Select distinct terr_GROUP PRODUCT_GROUP
                               from MIS.DASH_TERRITORY_GROUP
                               where terr_type = '".Auth::user()->p_group."'
                               order by terr_GROUP");

            $am_terr = DB::select("select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id
                                    from mis.rm_gm_info rgi,MIS.DCR_TERR_WISE_PLAN_VS_VISIT dcs 
                                    where RM_EMP_ID = " . Auth::user()->user_id . "
                                    and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                    order by substr(am_terr_id,-3,2) asc");

            $terr_id = DB::select("select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                    from mis.rm_gm_info rgi,MIS.DCR_TERR_WISE_PLAN_VS_VISIT dcs 
                                    where RM_EMP_ID = " . Auth::user()->user_id . "
                                    and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'");

            $dcr_month = DB::select("select distinct to_char(to_date(dcr_month,'MON-RR'),'MM-RR'),dcr_month mnth
                                    from MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                                    order by to_char(to_date(dcr_month,'MON-RR'),'MM-RR') desc");

            $array = ['pgrp' => $p_group, 'am_terr' => $am_terr, 'terr_id' => $terr_id, 'dcr_month' => $dcr_month];

        } else if (Auth::user()->desig === 'GM'|| Auth::user()->desig === 'NSM' || Auth::user()->desig === 'SM' ||
            Auth::user()->desig === 'DSM' || Auth::user()->desig === 'ASM') {

            $p_group = DB::select("Select distinct terr_GROUP PRODUCT_GROUP
                               from MIS.DASH_TERRITORY_GROUP
                               where terr_type = '".Auth::user()->p_group."'
                               order by terr_GROUP");

            $emp_id = "";

            if(Auth::user()->desig === 'GM')
            {
                $emp_id = "rgi.gm_emp_id";
            }
            elseif (Auth::user()->desig === 'NSM'){
                $emp_id = "rgi.nsm_emp_id";
            }
            elseif (Auth::user()->desig === 'SM'){
                $emp_id = "rgi.sm_emp_id";
            }
            elseif (Auth::user()->desig === 'DSM'){
                $emp_id = "rgi.dsm_emp_id";
            }
            elseif (Auth::user()->desig === 'ASM'){
                $emp_id = "rgi.asm_emp_id";
            }

            $rm_terr = DB::select("select distinct rm_terr_id
                                 from mis.rm_gm_info rgi
                                 where ".$emp_id." = " . Auth::user()->user_id . "
                                 order by rm_terr_id");

            $am_terr = DB::select("select am_terr_id from(
                                    select distinct gai.rm_terr_id,am_terr_id
                                    from
                                    (select distinct rm_terr_id
                                    from mis.rm_gm_info rgi
                                    where ".$emp_id." = " . Auth::user()->user_id . ") gai,
                                                                      (select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                                                        substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                                                                        from MIS.DCR_TERR_WISE_PLAN_VS_VISIT) dvs
                                    where gai.rm_terr_id = dvs.rm_terr_id) 
                                    order by substr(am_terr_id,-3,2) asc ");

            $terr_id = DB::select("select distinct terr_id
                                    from(
                                    select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                    from mis.rm_gm_info rgi,MIS.DCR_TERR_WISE_PLAN_VS_VISIT dcs 
                                    where ".$emp_id." = " . Auth::user()->user_id . "
                                    and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                    ) order by terr_id");

            $dcr_month = DB::select("select distinct to_char(to_date(dcr_month,'MON-RR'),'MM-RR'),dcr_month mnth
                                    from MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                                    order by to_char(to_date(dcr_month,'MON-RR'),'MM-RR') desc");

            $array = ['pgrp' => $p_group, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'terr_id' => $terr_id, 'dcr_month' => $dcr_month];

        } else if (Auth::user()->desig === 'AM') {

            $terr = Auth::user()->terr_id;

            $p_group = DB::select("Select distinct terr_GROUP PRODUCT_GROUP
                               from MIS.DASH_TERRITORY_GROUP
                               where terr_type = '".Auth::user()->p_group."'
                               order by terr_GROUP");


            $rm_terr = DB::select("select substr('$terr',1,instr('$terr','-'))||'00' rm_terr_id
                                   from dual");

            $am_terr = $terr;

            $terr_id = DB::select("Select terr_id from  MIS.DCR_TERR_WISE_PLAN_VS_VISIT 
                                  where substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) = '$terr'");

            $dcr_month = DB::select("select distinct to_char(to_date(dcr_month,'MON-RR'),'MM-RR'),dcr_month mnth
                                    from MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                                    order by to_char(to_date(dcr_month,'MON-RR'),'MM-RR') desc");

            $array = ['pgrp' => $p_group, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'terr_id' => $terr_id, 'dcr_month' => $dcr_month];

        }
        else if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO'){
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
                                                                        from MIS.DCR_TERR_WISE_PLAN_VS_VISIT) dvs
                                    where gai.rm_terr_id = dvs.rm_terr_id) 
                                    order by substr(am_terr_id,-3,2) asc ");

            $terr_id = DB::select("select distinct terr_id
                                    from(
                                    select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                    from mis.rm_gm_info rgi,MIS.DCR_TERR_WISE_PLAN_VS_VISIT dcs 
                                    where rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                    ) order by terr_id");

            $dcr_month = DB::select("select distinct to_char(to_date(dcr_month,'MON-RR'),'MM-RR'),dcr_month mnth
                                    from MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                                    order by to_char(to_date(dcr_month,'MON-RR'),'MM-RR') desc");

            $array = ['pgrp' => $p_group, 'rm_terr' => $rm_terr, 'am_terr' => $am_terr, 'terr_id' => $terr_id, 'dcr_month' => $dcr_month];

        }


        return view('dcr_reports_layout.v_terr_wise_plan_visit2')
            ->with($array);
    }

    protected function terr_wise_plan_vs_it_data(Request $request)
    {
        if ($request->ajax()) {

            $resp_data = DB::select("select PRODUCT_GROUP, TERR_ID, 
                                        EMPLOYEE_ID, EMPLOYEE_NAME,DOCTOR_ID,DOCTOR_NAME, 
                                        NO_OF_CALL,NO_OF_VISIT
                                    from (
                                     SELECT PRODUCT_GROUP, TERR_ID, 
                                        EMPLOYEE_ID, EMPLOYEE_NAME,DOCTOR_ID,DOCTOR_NAME, 
                                        NO_OF_CALL,NO_OF_VISIT,substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) AM_TERR_ID,
                                           substr(terr_id,1,instr(terr_id,'-'))||'00' RM_terr_id,dcr_month
                                    FROM MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                                    )
                                    where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                    and rm_terr_id = decode('$request->rmterr','All',rm_terr_id,'$request->rmterr')
                                    and am_terr_id = decode('$request->amterr','All',am_terr_id,'$request->amterr')
                                    and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                    and dcr_month = decode('$request->mnth','All',dcr_month,'$request->mnth') 
                                    ");

            return response()->json($resp_data);
        }

    }

    protected function terr_wise_plan_vs_it_list(Request $request)
    {
        if ($request->ajax()) {

            if ($request->desig === 'RM') {

                $resp_terr_list = DB::select("Select terr_id 
                                                from ( 
                                                select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                                from mis.rm_gm_info rgi,MIS.DCR_TERR_WISE_PLAN_VS_VISIT dcs 
                                                where RM_EMP_ID = '$request->emp_id'
                                                and rgi.RM_TERR_ID = substr(terr_id,1,instr(terr_id,'-'))||'00'
                                                )
                                                where am_terr_id = decode('$request->tid','All',am_terr_id,'$request->tid') 
                                                order by terr_id");
            }
            elseif ($request->desig === 'GM' || $request->desig === 'NSM'||$request->desig === 'SM'||$request->desig === 'DSM'
                || $request->desig === 'ASM')
            {

                $emp_id = "";

                if(Auth::user()->desig === 'GM')
                {
                    $emp_id = "rgi.gm_emp_id";
                }
                elseif (Auth::user()->desig === 'NSM'){
                    $emp_id = "rgi.nsm_emp_id";
                }
                elseif (Auth::user()->desig === 'SM'){
                    $emp_id = "rgi.sm_emp_id";
                }
                elseif (Auth::user()->desig === 'DSM'){
                    $emp_id = "rgi.dsm_emp_id";
                }
                elseif (Auth::user()->desig === 'ASM'){
                    $emp_id = "rgi.asm_emp_id";
                }


                if ($request->type === 'am') {
                    $resp_terr_list = DB::select("select am_terr_id
                                                from(
                                                select distinct gai.rm_terr_id,am_terr_id
                                                from
                                                (select distinct rm_terr_id
                                                from mis.rm_gm_info rgi
                                                where ".$emp_id." = " . Auth::user()->user_id . ") gai,(select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,
                                                                                    substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id
                                                                                    from MIS.DCR_TERR_WISE_PLAN_VS_VISIT) dvs
                                                where gai.rm_terr_id = dvs.rm_terr_id            
                                                )where rm_terr_id ='$request->tid'
                                                order by substr(am_terr_id,-3,2) asc");
                }
                elseif ($request->type === 'mpo')
                {

                    $resp_terr_list = DB::select("select distinct terr_id
                                                    from(
                                                    select distinct substr(terr_id,1,instr(terr_id,'-',1,1))||trunc(substr(terr_id,instr(terr_id,'-',-1,1)+1),-1) am_terr_id,terr_id
                                                    from mis.rm_gm_info rgi,MIS.DCR_TERR_WISE_PLAN_VS_VISIT dcs 
                                                    where ".$emp_id." = " . Auth::user()->user_id . "
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

}