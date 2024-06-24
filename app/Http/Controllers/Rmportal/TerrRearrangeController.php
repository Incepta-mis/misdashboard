<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 12/23/2017
 * Time: 4:28 PM
 */

namespace App\Http\Controllers\Rmportal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;

class TerrRearrangeController extends Controller
{

    public function regWTerrRMList(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $emonth = $request->input('empMonth');
        if($request->ajax()){

                $resp_data = DB::Select("select distinct rm_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_char(emp_month,'MON-RR') = '$emonth'
                                    and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' in (select rm_terr_id from RM_GM_INFO )
                                    order by rm_terr_id");

        }
        return response()->json($resp_data);

    }



    public function regwMpoTerrList(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

                $emonth = $request->input('emp_month');

        if ($request->ajax()) {


            $resp_data = DB::Select("select distinct mpo_terr_id mpo_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms 
                                where to_char(emp_month,'MON-RR') = '$emonth'
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = (select rm_terr_id from rm_gm_info  where rm_emp_id ||asm_emp_id in ('$request->rmTerrId') )
                                and substr(mpo_terr_id,1,instr(mpo_terr_id,'-',1,1))||trunc(substr(mpo_terr_id,instr(mpo_terr_id,'-',-1,1)+1),-1) = (select '$request->amTerr' from dual)
                                order by mpo_terr_id");


            return response()->json($resp_data);
        }
    }



    protected function amWiseData(Request $request)
    {

        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        $uid = Auth::user()->user_id;
        $emonth = $request->input('empMonth');
        $rterr = $request->input('rmTerr');
        $aterr = $request->input('amTerr');

        $am_data = DB::select("select  am_terr_id terr_id,am_emp_id emp_id,am_name emp_name,AM_DESIG emp_desig,sum( mpo_tgt_share) emp_tgt_share
                                from  hrtms.hr_terr_list@web_to_hrtms 
                                where AM_TERR_ID = decode('$aterr','All',am_terr_id,'$aterr')
                                and   to_char(emp_month,'MON-RR') = '$emonth'
                                and   rm_terr_id = '$rterr'
                                group by am_terr_id,am_emp_id,am_name,AM_DESIG");

        return response()->json($am_data);
        //        return response()->json($request->all());
    }

    protected function mpoWiseData(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");
        $uid = Auth::user()->user_id;
        $emonth = $request->input('empMonth');
        $rterr = $request->input('rmTerr');
        $aterr = $request->input('amTerr');
        $mpoterr = $request->input('mpoTerr');

        $mpodata = DB::select("select  mpo_terr_id terr_id,mpo_emp_id emp_id,mpo_name emp_name,DESIG emp_desig,sum(mpo_tgt_share) emp_tgt_share
                                from  hrtms.hr_terr_list@web_to_hrtms 
                                where AM_TERR_ID = decode('$aterr','All',am_terr_id,'$aterr')
                                and   to_char(emp_month,'MON-RR') = '$emonth'
                                and   rm_terr_id = '$rterr'
                                and   mpo_terr_id =  decode('$mpoterr','All',mpo_terr_id,'$mpoterr')
                                group by mpo_terr_id,mpo_emp_id ,mpo_name,DESIG ");
        return response()->json($mpodata);
        //return response()->json($request->all());
    }

    protected function changeTerrHistory(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");


        $uid = Auth::user()->user_id;
        $emonth = $request->input('empMonth');
        $cngType = $request->input('cngType');
        $terrId = $request->input('terrId');
        $xEmpId = $request->input('xEmpId');
        $xEmpName = $request->input('xEmpNmae');
        $xDesigId = $request->input('xEmpDesig');
        $tgt = $request->input('xtgt');
        $newEmpId = $request->input('newEmpId');
        $newEmpName = $request->input('newEmpName');
        $newDesig = $request->input('newDesig');
        $joinDate = $request->input('joinDate');
        $cngReason = $request->input('cngReason');
        $cngEfDate = $request->input('cngEfDate');
        $mobNo = $request->input('mobNo');
        $mobSt = $request->input('mobStatus');

        $chk = DB::select("select terr_id
                from mis.territory_change_history
                where to_char(terr_month,'MON-RR') = '$emonth'
                and terr_id = '$terrId'");

        // $chk = DB::select("select mpo_terr_id
        // from HRTMS.HR_TERR_LIST@web_to_hrtms
        // where to_char(emp_month,'MON-RR') = '$emonth'
        // and mpo_terr_id = '$terrId'");


        $dt = '01-' . $emonth;
        $time = strtotime($dt);

        $newformat = date('d-m-Y', $time);
        $curr = $date = date('d-m-Y');
        $update = $date = date('d-m-Y');



        try {

            if (count($chk) == 0) {
                $values = array(
                    'TERR_MONTH' => $newformat,
                    'TERR_ID' => $terrId,
                    'PRESENT_EMP_ID' => $xEmpId,
                    'PRESENT_EMP_NAME' => $xEmpName,
                    'PRESENT_DESIG' => $xDesigId,
                    'TGT_SHARE' => $tgt,
                    'NEW_EMP_ID' => $newEmpId,
                    'NEW_EMP_NAME' => $newEmpName,
                    'MOBILE_NO' => $mobNo,
                    'MOBILE_STATUS' => $mobSt,
                    'NEW_DESIG' => $newDesig,
                    'JOIN_DATE' => $joinDate,
                    'CHANGE_REASON' => $cngReason,
                    'CHANGE_EFFECTIVE_DATE' => $cngEfDate,
                    'CHANGE_TYPE' => $cngType,
                    'CREATE_DATE' => $curr,
                    'CREATE_USER' => $uid,
                    'UPDATE_DATE' => $update,
                    'UPDATE_USER' => $uid
                );

                DB::table('mis.TERRITORY_CHANGE_HISTORY')->insert($values);


                try {


                    if ($cngType == 'MPO') {

                        DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set   mpo_emp_id  = '$newEmpId',
                                                  mpo_name    = '$newEmpName',
                                                  desig       = '$newDesig' 
                                            where mpo_terr_id = '$terrId'
                                            and   to_char(emp_month,'MON-RR') ='$emonth'
                                            and   to_char(emp_month,'MON-RR') = to_char(to_date('$cngEfDate','DD/MM/RRRR'),'MON-RR')
                                        ");

                        //..........................next month terr update MPO if exist.................//
                        $nxtMonthMPO = DB::select("select   count( distinct emp_month) mnt
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where mpo_terr_id =  '$terrId'
                                                    and to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)");

                        if ($nxtMonthMPO[0]->mnt == "1") {
                             DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set   mpo_emp_id  = '$newEmpId',
                                                  mpo_name    = '$newEmpName',
                                                  desig       = '$newDesig' 
                                            where mpo_terr_id = '$terrId'
                                            and   to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)                              
                                        ");
                        }
                        //..........................next month terr update MPO if exist.................//




                    }

                    if ($cngType == 'AM') {

                        DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set   am_emp_id  = '$newEmpId',
                                                  am_name    = '$newEmpName',
                                                  am_desig   = '$newDesig' 
                                            where am_terr_id = '$terrId'
                                            and   to_char(emp_month,'MON-RR') ='$emonth'
                                            and   to_char(emp_month,'MON-RR') = to_char(to_date('$cngEfDate','DD/MM/RRRR'),'MON-RR')
                                        ");

                        //..........................next month terr update if exist.................//
                        $nxtMonthAM = DB::select("select   count( distinct emp_month) mnt
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where am_terr_id =  '$terrId'
                                                    and to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)");

                        if ($nxtMonthAM[0]->mnt == "1") {
                            $xx = DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set   
                                                  am_emp_id  = '$newEmpId',
                                                  am_name    = '$newEmpName',
                                                  am_desig   = '$newDesig' 
                                            where am_terr_id = '$terrId'
                                            and   to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)                              
                                        ");
                        }

                        // return response()->json(['nxtMonthAm'=>$nxtMonthAM[0]->mnt,'xx'=>$xx]);

                        //..........................next month terr update if exist.................//
                    }


                } catch (\Exception $ee) {
                    DB::rollBack();
                    return response()->json($ee->getMessage());
                }

                return response()->json($request->all());
            } else {

                DB::table('mis.TERRITORY_CHANGE_HISTORY')
                    ->where('TERR_ID', $terrId)
                     ->where('TERR_MONTH' , $newformat)
                    ->update(array(                        
                        'PRESENT_EMP_ID' => $xEmpId,
                        'PRESENT_EMP_NAME' => $xEmpName,
                        'PRESENT_DESIG' => $xDesigId,
                        'TGT_SHARE' => $tgt,
                        'NEW_EMP_ID' => $newEmpId,
                        'NEW_EMP_NAME' => $newEmpName,
                        'MOBILE_NO' => $mobNo,
                        'MOBILE_STATUS' => $mobSt,
                        'NEW_DESIG' => $newDesig,
                        'JOIN_DATE' => $joinDate,
                        'CHANGE_REASON' => $cngReason,
                        'CHANGE_EFFECTIVE_DATE' => $cngEfDate,
                        'CHANGE_TYPE' => $cngType,
                        'UPDATE_DATE' => $update,
                        'UPDATE_USER' => $uid
                    ));  // update the record in the DB.

                try {

                    if ($cngType == 'MPO') {

                        DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set   mpo_emp_id  = '$newEmpId',
                                                  mpo_name    = '$newEmpName',
                                                  desig       = '$newDesig' 
                                            where mpo_terr_id = '$terrId'
                                            and   to_char(emp_month,'MON-RR') ='$emonth'
                                            and   to_char(emp_month,'MON-RR') = to_char(to_date('$cngEfDate','DD/MM/RRRR'),'MON-RR')
                                        ");

                        //..........................next month terr update MPO if exist.................//
                        $nxtMonthUMPO = DB::select("select   count( distinct emp_month) mnt
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where mpo_terr_id =  '$terrId'
                                                    and to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)");

                        if ($nxtMonthUMPO[0]->mnt == "1") {
                            DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set
                                                  MPO_EMP_ID  = '$newEmpId',
                                                  MPO_NAME    = '$newEmpName',
                                                  DESIG       = '$newDesig' 
                                            where MPO_TERR_ID = '$terrId'
                                            and   to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)                              
                                        ");
                        }
                        //..........................next month terr update MPO if exist.................//
                    }

                    if ($cngType == 'AM') {

                        DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set am_emp_id  = '$newEmpId',
                                                am_name    = '$newEmpName',
                                                am_desig   = '$newDesig' 
                                            where am_terr_id = '$terrId'
                                            and to_char(emp_month,'MON-RR') ='$emonth'
                                            and to_char(emp_month,'MON-RR') = to_char(to_date('$cngEfDate','DD/MM/RRRR'),'MON-RR')
                                        ");

                        //..........................next month terr update if exist.................//
                        $nxtMonthAM = DB::select("select   count( distinct emp_month) mnt
                                                    from hrtms.hr_terr_list@web_to_hrtms
                                                    where am_terr_id =  '$terrId'
                                                    and to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)");

                        if ($nxtMonthAM[0]->mnt == "1") {
                            $xx = DB::statement("update hrtms.hr_terr_list@web_to_hrtms
                                            set   
                                                  am_emp_id  = '$newEmpId',
                                                  am_name    = '$newEmpName',
                                                  am_desig   = '$newDesig' 
                                            where am_terr_id = '$terrId'
                                            and   to_char(emp_month,'MON-RR') = (SELECT to_char(ADD_MONTHS(TO_DATE('$newformat'), 1),'MON-RR') FROM dual)                              
                                        ");
                        }

                        // return response()->json(['nxtMonthAm'=>$nxtMonthAM[0]->mnt,'xx'=>$xx]);

                        //..........................next month terr update if exist.................//


                    }


                } catch (\Exception $ee) {
                    DB::rollBack();
                    return response()->json($ee->getMessage());
                }

                return response()->json($request->all());
            }


        } catch (\Exception $e) {
            // echo $e->getMessage();
            DB::rollBack();
            return response()->json($e->getMessage());
        }


    }



    public function regWiseTerrAMListNew(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::select("         

            select distinct am_terr_id am_terr_id, rm_name || asm_name rmsm_name, RM_EMP_ID||ASM_EMP_ID rmsm_id
            from hrtms.hr_terr_list@web_to_hrtms
            where to_date(emp_month,'DD-MON-RR')= (select to_date(trunc(sysdate,'MONTH'),'DD-MON-RR') from dual )
            and substr(mpo_terr_id,1,instr(mpo_terr_id,'-'))||'00' = '$request->rmTerr'
            and am_terr_id not like '%-500%'
            order by am_terr_id
        
        ");

        return response()->json($resp_data);

    }

}