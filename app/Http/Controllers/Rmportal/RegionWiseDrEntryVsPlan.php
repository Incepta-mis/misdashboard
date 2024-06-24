<?php

namespace App\Http\Controllers\Rmportal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;


class RegionWiseDrEntryVsPlan extends Controller
{

    protected function regionWiseTerrList(Request $request){

        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        $uid = Auth::user()->user_id;
        $emonth = $request->input('empMonth');
        $eterr = $request->input('rmTerr');

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

            $rm_sm_data = DB::select("select tl.mpo_terr_id,tl.mpo_base,tl.mpo_base_type,tl.mpo_tgt_share,tl.mpo_emp_id,tl.mpo_name,tl.desig,tl.p_group,tl.d_id,tl.am_terr_id,tl.am_base,tl.am_emp_id,tl.am_name,tl.am_desig
                               from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where RM_EMP_ID ||ASM_EMP_ID in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth'
                               order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");

            return response()->json($rm_sm_data);

            /*return view('rm_portal.regwise_terr_list')
                ->with($array);*/
        }

        if( Auth::user()->desig === 'GM'){

            $rm_sm_data = DB::select("select tl.mpo_terr_id,tl.mpo_base,tl.mpo_base_type,tl.mpo_tgt_share,tl.mpo_emp_id,tl.mpo_name,tl.desig,tl.p_group,tl.d_id,tl.am_terr_id,tl.am_base,tl.am_emp_id,tl.am_name,tl.am_desig
                               from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where GM_EMP_ID in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and tl.rm_terr_id = '$eterr'
                                and to_char(tl.emp_month,'MON-RR') ='$emonth'
                                order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");

            return response()->json($rm_sm_data);

        }

        if( Auth::user()->desig === 'NSM'){
            $rm_sm_data = DB::select("select tl.mpo_terr_id,tl.mpo_base,tl.mpo_base_type,tl.mpo_tgt_share,tl.mpo_emp_id,tl.mpo_name,tl.desig,tl.p_group,tl.d_id,tl.am_terr_id,tl.am_base,tl.am_emp_id,tl.am_name,tl.am_desig
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where NSM_EMP_ID in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and tl.rm_terr_id = '$eterr'
                                and to_char(tl.emp_month,'MON-RR') ='$emonth'
                                order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            return response()->json($rm_sm_data);
        }

        if( Auth::user()->desig === 'SM'){
            $rm_sm_data = DB::select("select tl.mpo_terr_id,tl.mpo_base,tl.mpo_base_type,tl.mpo_tgt_share,tl.mpo_emp_id,tl.mpo_name,tl.desig,tl.p_group,tl.d_id,tl.am_terr_id,tl.am_base,tl.am_emp_id,tl.am_name,tl.am_desig
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where SM_EMP_ID in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and tl.rm_terr_id = '$eterr'
                                and to_char(tl.emp_month,'MON-RR') ='$emonth'
                                order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            return response()->json($rm_sm_data);
        }

        if( Auth::user()->desig === 'DSM'){
            $rm_sm_data = DB::select("select tl.mpo_terr_id,tl.mpo_base,tl.mpo_base_type,tl.mpo_tgt_share,tl.mpo_emp_id,tl.mpo_name,tl.desig,tl.p_group,tl.d_id,tl.am_terr_id,tl.am_base,tl.am_emp_id,tl.am_name,tl.am_desig
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where DSM_EMP_ID in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and tl.rm_terr_id = '$eterr'
                                and to_char(tl.emp_month,'MON-RR') ='$emonth'
                                order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            return response()->json($rm_sm_data);
        }

        if( Auth::user()->desig === 'HO' || Auth::user()->desig === 'All'){

            $rm_sm_data = DB::select("select tl.mpo_terr_id,tl.mpo_base,tl.mpo_base_type,tl.mpo_tgt_share,tl.mpo_emp_id,tl.mpo_name,tl.desig,tl.p_group,tl.d_id,tl.am_terr_id,tl.am_base,tl.am_emp_id,tl.am_name,tl.am_desig
                               from hrtms.hr_terr_list@web_to_hrtms tl
                               -- where tl.rm_terr_id = '$eterr'
                               where tl.rm_terr_id = decode('$eterr','All',tl.rm_terr_id,'$eterr') 
                                and to_char(tl.emp_month,'MON-RR') ='$emonth'
                                order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");

            return response()->json($rm_sm_data);

        }

    }


    public function regwTerrListGmRm(Request $request)
    {
        $uid = Auth::user()->user_id;
        $emonth = $request->input('empMonth');

        if(Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where RM_EMP_ID ||ASM_EMP_ID in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'GM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where gm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'NSM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where nsm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'SM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where sm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if(Auth::user()->desig === 'DSM') {
            $gmrmTerr = DB::select("select DISTINCT tl.rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO
                                                                         where dsm_emp_id in ('$uid')) lei
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' order by tl.rm_terr_id asc");
        }

        if( Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
            $gmrmTerr = DB::Select("select distinct rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_char(emp_month,'MON-RR') = '$emonth'
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO ) order by rm_terr_id");
        }

        return response()->json($gmrmTerr);
    }

    public function regwTerrListSmRmNameId(Request $request)
    {
        $uid = Auth::user()->user_id;
        $emonth = $request->input('empMonth');
        $smrmTerr = $request->input('rmTerr');

        if(Auth::user()->desig === 'HO' || Auth::user()->desig === 'All'  ) {
            $gmrmTerr = DB::select("select distinct rm_terr_id rm_sm_id,rm_name || asm_name rm_sm_name
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_char(emp_month,'MON-RR') = '$emonth'
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )
                                    and rm_terr_id = '$smrmTerr'");
        }

        if(Auth::user()->desig === 'GM') {
            $gmrmTerr = DB::select("select distinct DECODE(asm_emp_id,'',rm_emp_id,asm_emp_id) rm_sm_id,DECODE(asm_name,'',rm_name,asm_name) rm_sm_name
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO 
                                                                         where gm_emp_id in ('$uid')) lei 
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' 
                                and tl.rm_terr_id = '$smrmTerr'");
        }

        if(Auth::user()->desig === 'NSM') {
            $gmrmTerr = DB::select("select distinct DECODE(asm_emp_id,'',rm_emp_id,asm_emp_id) rm_sm_id,DECODE(asm_name,'',rm_name,asm_name) rm_sm_name
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO 
                                                                         where nsm_emp_id in ('$uid')) lei 
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' 
                                and tl.rm_terr_id = '$smrmTerr'");
        }

        if(Auth::user()->desig === 'SM') {
            $gmrmTerr = DB::select("select distinct DECODE(asm_emp_id,'',rm_emp_id,asm_emp_id) rm_sm_id,DECODE(asm_name,'',rm_name,asm_name) rm_sm_name
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO 
                                                                         where sm_emp_id in ('$uid')) lei 
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' 
                                and tl.rm_terr_id = '$smrmTerr'");
        }

        if(Auth::user()->desig === 'DSM') {
            $gmrmTerr = DB::select("select distinct DECODE(asm_emp_id,'',rm_emp_id,asm_emp_id) rm_sm_id,DECODE(asm_name,'',rm_name,asm_name) rm_sm_name
                                from hrtms.hr_terr_list@web_to_hrtms tl,(select rm_terr_id from RM_GM_INFO 
                                                                         where dsm_emp_id in ('$uid')) lei 
                                where tl.rm_terr_id = lei.rm_terr_id
                                and to_char(tl.emp_month,'MON-RR') ='$emonth' 
                                and tl.rm_terr_id = '$smrmTerr'");
        }


        return response()->json($gmrmTerr);
    }

}
