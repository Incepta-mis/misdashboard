<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 4/12/2018
 * Time: 11:34 AM
 */

namespace App\Http\Controllers\Rmportal;

//use App\ItemWiseDoctorAssign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;


class DoctorWiseBrandAssignController extends Controller
{
    function getDoctorBrand(Request $request)
    {

        $resp_data = DB::Select("select brand_name ||'('|| count(brand_name)||')' brand_name
                                    from doctor_wise_item_utilization
                                    WHERE terr_id = '$request->TerrId'
                                    group by brand_name");

        return response()->json($resp_data);
    }

    //get MPO terr wise pGroup
    function getTerrWisePGroup(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("select distinct mpo_terr_id,case when p_group in ('CELLBIOTIC','KINETIX','ZYMOS','GENERAL') then 'GENERAL' else p_group end p_group,
                                substr(mpo_terr_id,length(substr(mpo_terr_id,1,instr(mpo_terr_id,'-',1,1)))+1,1) terr_team
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                and mpo_terr_id = '$request->mpoTerr'");

        return response()->json($resp_data);
    }

    function getTerrWiseDoctorList(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $resp_data = DB::Select("select terr_id,doctor_id,doctor_name,case when terr_team in ('A','B') then terr_team else null end terr_team
                                from(
                                select distinct terr_id,di.doctor_id,di.doctor_name,substr(terr_id,length(substr(terr_id,1,instr(terr_id,'-',1,1)))+1,1) terr_team
                                from mis.doctor_wise_territory dwt,(select distinct doctor_id,doctor_name from doctor_info.doctor_information@web_to_sample_msd where nvl(DOCTOR_STATUS,'A') != 'DELETE') di 
                                where dwt.doctor_id = di.doctor_id
                                and terr_id = '$request->mpoTerr'
                                )
                                ");

        return response()->json($resp_data);
    }

    function getTerrWiseDoctorBrands(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");
        $resp_data = DB::Select("select brand,brand_group,product_team,0 chk
                                from
                                (select distinct brand,gt.p_group brand_group,product_team
                                from
                                (select distinct s_group p_group,brand,p_code,item_id,s_name item_name
                                from sample_new.item_info@web_to_hrtms
                                where type2 in ('CC','COMM.PACK') and valid = 'YES' and brand is not null 
                                )bg,(select distinct p_group,p_code,team product_team
                                from dwh.product_info_m@web_to_ipldw2) gt
                                where bg.p_code = gt.p_code
                                and gt.p_group = '$request->p_group'
                                and nvl2('$request->terrTeam',product_team,0) = nvl2('$request->terrTeam','$request->terrTeam',0)
                                minus
                                select distinct brand_name brand,brand_group,product_team
                                from (select distinct brand_name from mis.doctor_wise_item_utilization
                                      where terr_id = '$request->terrId' and doctor_id = '$request->docId') dwiu,(select distinct gt.p_group brand_group,brand,product_team 
                                                                                                 from
                                                                                                 (select distinct s_group p_group,brand,p_code,item_id,s_name item_name
                                                                                                 from sample_new.item_info@web_to_hrtms
                                                                                                 where type2 in ('CC','COMM.PACK') and valid = 'YES' and brand is not null
                                                                                                 )bg,(select distinct p_group,p_code,team product_team
                                                                                                  from dwh.product_info_m@web_to_ipldw2) gt
                                                                                                  where bg.p_code = gt.p_code
                                                                                                  and nvl2('$request->terrTeam',product_team,0) = nvl2('$request->terrTeam','$request->terrTeam',0)
                                                                                                  and gt.p_group = '$request->p_group') ib
                                
                                where dwiu.brand_name = ib.brand
                                and nvl2('$request->terrTeam',product_team,0) = nvl2('$request->terrTeam','$request->terrTeam',0))
                                union all
                                select distinct brand_name brand,brand_group,product_team,1 chk
                                from (select distinct brand_name from mis.doctor_wise_item_utilization
                                      where terr_id = '$request->terrId' and doctor_id = '$request->docId') dwiu,(select distinct gt.p_group brand_group,brand,product_team 
                                                                                                 from
                                                                                                 (select distinct s_group p_group,brand,p_code,item_id,s_name item_name
                                                                                                 from sample_new.item_info@web_to_hrtms
                                                                                                 where type2 in ('CC','COMM.PACK') and valid = 'YES' and brand is not null
                                                                                                 )bg,(select distinct p_group,p_code,team product_team
                                                                                                  from dwh.product_info_m@web_to_ipldw2) gt
                                                                                                  where bg.p_code = gt.p_code
                                                                                                  and nvl2('$request->terrTeam',product_team,0) = nvl2('$request->terrTeam','$request->terrTeam',0)
                                                                                                  and gt.p_group = '$request->p_group') ib
                                
                                where dwiu.brand_name = ib.brand
                                
                                ");

        return response()->json($resp_data);
    }

    // function docWiseBrandAssignUpdate(Request $request)
    // {
    //     $data = $request->usdata;
    //     $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
    //     $uid = Auth::user()->user_id;

    //     foreach ($data as $tbldata) {
    //         $rs = DB::insert('insert into DOCTOR_WISE_BRAND_ASSIGN
    //             (REG_TERR_ID , AM_TERR_ID, MPO_TERR_ID, P_GROUP, DOCTOR_ID,DOCTOR_NAME,BRAND_CHECKED,BRAND_NAME,CREATE_DATE,CREATE_USER)
    //             values (?, ?, ?,?, ?, ?,?, ?, ?, ?)',
    //             [$tbldata['reg_terr'], $tbldata['am_terr'], $tbldata['terr_id'], $tbldata['brand_group'], $tbldata['doc_id'],
    //                 $tbldata['doc_name'],  $tbldata['check'], $tbldata['brand'], $systime, $uid
    //             ]);

    //         if($tbldata['check'] == 0){
    //             DB::table('MIS.DOCTOR_WISE_ITEM_UTILIZATION')
    //                 ->where( 'TERR_ID', '=', $tbldata['terr_id'])
    //                 ->where( 'DOCTOR_ID', '=', $tbldata['doc_id'])
    //                 ->where( 'BRAND_NAME', '=', $tbldata['brand'])
    //                 ->delete();
    //         }





    //         if($tbldata['check'] == 1){

    //             $plan = DB::select('             
    //             SELECT TERR_ID,DOCTOR_ID,SUM(NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0)) EXPOSER_QTY
    //                         FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
    //                         WHERE DOCTOR_ID = ?
    //                         AND TERR_ID = ?
    //                         GROUP BY TERR_ID,DOCTOR_ID                
    //             ',[$tbldata['doc_id'], $tbldata['terr_id']]);

    //             if($plan){
    //                 DB::update("
    //                     UPDATE MIS.DOCTOR_WISE_BRAND_ASSIGN
    //                     SET UPDATE_SATAUS = 'YES'
    //                     WHERE MPO_TERR_ID = '".$tbldata['terr_id']."' 
    //                     AND DOCTOR_ID = '".$tbldata['doc_id']."' 
    //                     AND BRAND_NAME = '".$tbldata['brand']."'");

    //                 // DB::insert(" insert into MIS.DOCTOR_WISE_ITEM_UTILIZATION
    //                 //         (TERR_ID,DOCTOR_ID,DOCTOR_NAME,BRAND_NAME,ITEM_ID,ITEM_NAME,EXPOSER_QTY,CREATE_DATE, CREATE_USER)

    //                 //         SELECT TERR_ID,DOCTOR_ID,? ,BRAND,ITEM_ID,ITEM_NAME,EXPOSER_QTY,sysdate CREATE_DATE, 'MIS' CREATE_USER
    //                 //         FROM
    //                 //         (SELECT TERR_ID,DOCTOR_ID,SUM(NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0)) EXPOSER_QTY
    //                 //         FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
    //                 //         WHERE DOCTOR_ID = ?
    //                 //         AND TERR_ID = ?
    //                 //         GROUP BY TERR_ID,DOCTOR_ID) A, (SELECT DISTINCT  BRAND,ITEM_ID,S_NAME ITEM_NAME
    //                 //                                         FROM SAMPLE_NEW.ITEM_INFO@WEB_TO_HRTMS
    //                 //                                         WHERE TYPE2 IN ('CC','COMM.PACK') AND VALID = 'YES' 
    //                 //                                         AND BRAND = ?) B",[$tbldata['doc_name'],$tbldata['doc_id'], //$tbldata['terr_id'],$tbldata['brand']]);

    //                 $rs = DB::select("
    //                 select count(*) cnt
    //                 from mis.doctor_wise_item_utilization
    //                 where doctor_id =  '".$tbldata['doc_id']."'
    //                 and terr_id = '".$tbldata['terr_id']."' 
    //                 and brand_name = '".$tbldata['brand']."'
    //                 ");

    //                 if($rs[0]->cnt > 0 ){

    //                 }else{
    //                     DB::insert(" insert into MIS.DOCTOR_WISE_ITEM_UTILIZATION
    //                     (TERR_ID,DOCTOR_ID,DOCTOR_NAME,BRAND_NAME,EXPOSER_QTY,CREATE_DATE, CREATE_USER)                        
                        
    //                     (SELECT distinct TERR_ID,DOCTOR_ID,? , BRAND,EXPOSER_QTY,sysdate CREATE_DATE, 'MIS' CREATE_USER
    //                     FROM
    //                     (SELECT TERR_ID,DOCTOR_ID,SUM(NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0)) EXPOSER_QTY
    //                     FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
    //                     WHERE DOCTOR_ID = ?
    //                     AND TERR_ID = ?
    //                     GROUP BY TERR_ID,DOCTOR_ID),(SELECT DISTINCT  BRAND FROM SAMPLE_NEW.ITEM_INFO@WEB_TO_HRTMS
    //                                                 WHERE TYPE2 IN ('CC','COMM.PACK') AND VALID = 'YES' 
    //                                                 AND BRAND = ?) )",[$tbldata['doc_name'],$tbldata['doc_id'], $tbldata['terr_id'],$tbldata['brand']]);
    //                 }


    //             }

    //         }


    //     }

    //     if ($rs) {
    //         return response()->json(['success' => 'Change Successfully.']);
    //     } else {
    //         return response()->json(['error' => 'UnSuccessfully.']);
    //     }
    // }

    
    //hema
    function docWiseBrandAssignUpdate(Request $request)
    {
        $data = $request->usdata;
        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $uid = Auth::user()->user_id;


        $allBrands = [];
        foreach ($data as $d){
            array_push($allBrands,$d['brand']);
        }
        $flag = 0;
        $sameGroupBrand = [];
        foreach ($allBrands as $bdata){
            $pd = DB::select("select * from product_info@web_to_sample_msd where brand_name = ? AND TH_GROUP = 'PPI'", [$bdata]);
            if(count($pd)>0){
                $flag++;
                array_push($sameGroupBrand,$bdata);
            }
        }
        if($flag > 1){
            return response()->json(['response'=>'Error','sameBrand'=>implode(",",$sameGroupBrand),
                'flag'=>$flag]);
        }else {
            foreach ($data as $tbldata) {
                $rs = DB::insert('insert into DOCTOR_WISE_BRAND_ASSIGN
                    (REG_TERR_ID , AM_TERR_ID, MPO_TERR_ID, P_GROUP, DOCTOR_ID,DOCTOR_NAME,BRAND_CHECKED,BRAND_NAME,CREATE_DATE,CREATE_USER)
                    values (?, ?, ?,?, ?, ?,?, ?, ?, ?)',
                    [$tbldata['reg_terr'], $tbldata['am_terr'], $tbldata['terr_id'], $tbldata['brand_group'], $tbldata['doc_id'],
                        $tbldata['doc_name'], $tbldata['check'], $tbldata['brand'], $systime, $uid
                    ]);

                if ($tbldata['check'] == 0) {
                    DB::table('MIS.DOCTOR_WISE_ITEM_UTILIZATION')
                        ->where('TERR_ID', '=', $tbldata['terr_id'])
                        ->where('DOCTOR_ID', '=', $tbldata['doc_id'])
                        ->where('BRAND_NAME', '=', $tbldata['brand'])
                        ->delete();
                }

                if ($tbldata['check'] == 1) {

                    $plan = DB::select('             
                    SELECT TERR_ID,DOCTOR_ID,SUM(NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0)) EXPOSER_QTY
                                FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
                                WHERE DOCTOR_ID = ?
                                AND TERR_ID = ?
                                GROUP BY TERR_ID,DOCTOR_ID                
                    ', [$tbldata['doc_id'], $tbldata['terr_id']]);

                    if ($plan) {
                        DB::update("
                            UPDATE MIS.DOCTOR_WISE_BRAND_ASSIGN
                            SET UPDATE_SATAUS = 'YES'
                            WHERE MPO_TERR_ID = '" . $tbldata['terr_id'] . "' 
                            AND DOCTOR_ID = '" . $tbldata['doc_id'] . "' 
                            AND BRAND_NAME = '" . $tbldata['brand'] . "'");

                        $rs = DB::select("
                        select count(*) cnt
                        from mis.doctor_wise_item_utilization
                        where doctor_id =  '" . $tbldata['doc_id'] . "'
                        and terr_id = '" . $tbldata['terr_id'] . "' 
                        and brand_name = '" . $tbldata['brand'] . "'
                        ");

                        if ($rs[0]->cnt > 0) {

                        } else {
                            DB::insert(" insert into MIS.DOCTOR_WISE_ITEM_UTILIZATION
                            (TERR_ID,DOCTOR_ID,DOCTOR_NAME,BRAND_NAME,EXPOSER_QTY,CREATE_DATE, CREATE_USER)                        
                            
                            (SELECT distinct TERR_ID,DOCTOR_ID,? , BRAND,EXPOSER_QTY,sysdate CREATE_DATE, 'MIS' CREATE_USER
                            FROM
                            (SELECT TERR_ID,DOCTOR_ID,SUM(NVL(VISIT1,0)+NVL(VISIT2,0)+NVL(VISIT3,0)+NVL(VISIT4,0)) EXPOSER_QTY
                            FROM MIS.TERRITORY_WISE_DOCTOR_PLAN
                            WHERE DOCTOR_ID = ?
                            AND TERR_ID = ?
                            GROUP BY TERR_ID,DOCTOR_ID),(SELECT DISTINCT  BRAND FROM SAMPLE_NEW.ITEM_INFO@WEB_TO_HRTMS
                                                        WHERE TYPE2 IN ('CC','COMM.PACK') AND VALID = 'YES' 
                                                        AND BRAND = ?) )", [$tbldata['doc_name'], $tbldata['doc_id'], $tbldata['terr_id'], $tbldata['brand']]);
                        }
                    }
                }
            }
            if ($rs) {
                return response()->json(['response'=>'Success','success' => 'Change Successfully.','flag'=>$flag,'sameBrand'=>'']);
            } else {
                return response()->json(['response'=>'Error','error' => 'UnSuccessfully.','flag'=>$flag,'sameBrand'=>'']);
            }
        }
    }

}