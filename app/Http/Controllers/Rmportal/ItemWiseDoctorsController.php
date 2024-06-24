<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 07/02/18
 * Time: 16:12
 */

namespace App\Http\Controllers\Rmportal;


use App\ItemWiseDoctorAssign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Input;
use Validator;
use File;


class ItemWiseDoctorsController extends Controller
{



    public function regwMpoTerrList(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = decode('$request->rmTerrId','All',tl.rm_terr_id,'$request->rmTerrId') 
                                    and tl.am_terr_id = decode('$request->amTerr','All',tl.am_terr_id,'$request->amTerr')
                                    and tl.emp_month = trunc(sysdate,'MM')
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            return response()->json($resp_data);
            //return response()->json($request->all());
        }
    }

    public function itemWiseDrData(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $item_id = $request->Itemid;

            $resp_data = DB::select("
                                select  distinct terr_id,doctor_id,doctor_name,brand_name,item_id,item_name,exposer_qty
                                from mis.doctor_wise_item_utilization
                                where terr_id =  '$request->TerrId'
                                and brand_name = '$request->BrandName'
                                and item_id =  decode('$item_id','All',item_id,'$item_id')
                                order by doctor_id asc
                            ");

            return response()->json($resp_data);
            //return response()->json($request->all());
        }
    }

    public function terrWiseDrBrand(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where terr_id = '$request->mpoTerr'
                                order by brand_name asc
                            ");

            return response()->json($resp_data);
        }
    }

    public function terrWiseDrBrandItems(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::select("
                                select distinct item_id,item_name
                                from mis.doctor_wise_item_utilization
                                where terr_id = '$request->mpoTerr'
                                and brand_name = '$request->brandName'
                                order by item_id asc
                            ");

            return response()->json($resp_data);
        }
    }

    public function itemWiseDocDataDelete(Request $request){
        if ($request->ajax()) {

            ini_set('max_execution_time', 600);


            foreach ($request->deleteData as $data){

                if(ItemWiseDoctorAssign::where('TERR_ID',$data['terr_id'])->where('DOCTOR_ID',$data['doctor_id'])->where('ITEM_ID',$data['item_id'])->count() > 0) {
                    return response()->json(['error'=>'Your request has been approved by Admin, please wait for one day.']);
                }else{
                    $dataArray = [
                        'TERR_ID'       => $data['terr_id'],
                        'DOCTOR_ID'     => $data['doctor_id'],
                        'DOCTOR_NAME'   => $data['doctor_name'],
                        'BRAND_NAME'    => $data['brand_name'],
                        'ITEM_ID'       => $data['item_id'],
                        'ITEM_NAME'     => $data['item_name'],
                        'EXPOSER_QTY'   => $data['exposer_qty'],
                        'CREATE_USER'   => Auth::user()->user_id
                    ];
                    ItemWiseDoctorAssign::insert($dataArray);
                }

//                $whereArray = array('TERR_ID' => $data['terr_id'],'DOCTOR_ID' => $data['doctor_id'],'ITEM_ID'=> $data['item_id']);
//                ItemWiseDoctorAssign::whereArray($whereArray)->delete();
            }

           return response()->json(['success'=>'Delete successfully.']);
        }
    }


    // for brand wise exposure report
    public function rmTerrWiseDrBrand(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::select("
                                select distinct brand_name
                                from mis.doctor_wise_item_utilization
                                where SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' = decode('$request->rmTerr','All',SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00','$request->rmTerr')
                                order by brand_name asc
                            ");

            return response()->json($resp_data);
        }
    }

    public function brandWiseDocExposure(Request $request){
        ini_set('max_execution_time', 300);
        if ($request->ajax()) {
            // $resp_data = DB::select("
            //                     SELECT A.TERR_ID,NO_OF_DOCTOR,NO_OF_EXPO_QTY
            //                     FROM
            //                         (SELECT TERR_ID,COUNT(DOCTOR_ID) NO_OF_DOCTOR
            //                         FROM
            //                         (SELECT DISTINCT TERR_ID,DOCTOR_ID
            //                         FROM MIS.DOCTOR_WISE_ITEM_UTILIZATION
            //                         WHERE SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' =  decode('$request->rmTerr','All',SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00','$request->rmTerr')
            //                         AND BRAND_NAME = '$request->brandName')
            //                         GROUP BY TERR_ID) A,
            //                             (
            //                                     SELECT TERR_ID,BRAND_NAME,SUM(EXPOSER_QTY) NO_OF_EXPO_QTY
            //                                     FROM
            //                                     (SELECT DISTINCT TERR_ID,BRAND_NAME,DOCTOR_ID,EXPOSER_QTY
            //                                     FROM MIS.DOCTOR_WISE_ITEM_UTILIZATION 
            //                                     WHERE SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' = decode('$request->rmTerr','All',SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00','$request->rmTerr')
            //                                     AND BRAND_NAME = '$request->brandName'
            //                                     )
            //                                     GROUP BY TERR_ID,BRAND_NAME
            //                             ) B
            //                     WHERE A.TERR_ID = B.TERR_ID
            //                 ");

            $resp_data = DB::select("
                                SELECT A.TERR_ID,NO_OF_DOCTOR,NO_OF_EXPO_QTY
                                FROM
                                    (SELECT TERR_ID,COUNT(DOCTOR_ID) NO_OF_DOCTOR
                                    FROM
                                    (SELECT DISTINCT TERR_ID,DOCTOR_ID
                                    FROM MIS.DOCTOR_WISE_ITEM_UTILIZATION
                                    WHERE  decode('$request->rmTerr','All',TERR_ID,SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00') =  decode('$request->rmTerr','All',TERR_ID,'$request->rmTerr')
                                    AND BRAND_NAME = '$request->brandName')
                                    GROUP BY TERR_ID) A,
                                        (
                                                SELECT TERR_ID,BRAND_NAME,SUM(EXPOSER_QTY) NO_OF_EXPO_QTY
                                                FROM
                                                (SELECT DISTINCT TERR_ID,BRAND_NAME,DOCTOR_ID,EXPOSER_QTY
                                                FROM MIS.DOCTOR_WISE_ITEM_UTILIZATION 
                                                WHERE decode('$request->rmTerr','All',TERR_ID,SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00') =  decode('$request->rmTerr','All',TERR_ID,'$request->rmTerr')
                                                AND BRAND_NAME = '$request->brandName'
                                                )
                                                GROUP BY TERR_ID,BRAND_NAME
                                        ) B
                                WHERE A.TERR_ID = B.TERR_ID
                ");

            // $resp_data = DB::select("
            //     SELECT A.TERR_ID,NO_OF_DOCTOR,NO_OF_EXPO_QTY
            //     FROM
            //     (SELECT TERR_ID,COUNT(DOCTOR_ID) NO_OF_DOCTOR
            //     FROM
            //     (SELECT DISTINCT case when p_group = 'ZYMOS' and (terr_id like '%-Z-%' or terr_id like '%-A-%' or terr_id like '%-B-%'
            //     or terr_id like '-G-%') then terr_id else case when p_group = 'CELLBIOTIC' and (terr_id like '%-C-%' or terr_id like '%-A-%'
            //     or terr_id like '%-B-%' or terr_id like '-G-%') then terr_id else case when p_group = 'KINETIX' and (terr_id like '%-K-%' or terr_id like '%-A-%'
            //     or terr_id like '%-B-%' or terr_id like '-G-%') then terr_id else case when p_group = 'ASTER' and terr_id like '%A-%' then terr_id else
            //     case when p_group = 'GYRUS' and (terr_id like 'G1-%' or terr_id like 'G2-%') then terr_id else
            //     case when p_group = 'OPERON-XENOVISION' and terr_id like '%O-%' then terr_id else null end end end end end end TERR_ID,DOCTOR_ID
            //     FROM MIS.DOCTOR_WISE_ITEM_UTILIZATION dwiu,(select distinct s_group p_group,brand from sample_new.item_info@web_to_hrtms
            //                                                 where TYPE2 in ('COMM.PACK','CC')) bg
            //     WHERE SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' =  '$request->rmTerr'
            //     and dwiu.brand_name = bg.brand
            //     and brand_name = '$request->brandName')
            //     where terr_id is not null
            //     GROUP BY TERR_ID) A,(select terr_id,brand_name,sum(exposer_qty) no_of_expo_qty
            //                          from (select distinct case when p_group = 'ZYMOS' and (terr_id like '%-Z-%' or terr_id like '%-A-%' or terr_id like '%-B-%'
            //                                       or terr_id like '-G-%') then terr_id else case when p_group = 'CELLBIOTIC' and (terr_id like '%-C-%'
            //                                       or terr_id like '%-A-%' or terr_id like '%-B-%' or terr_id like '-G-%') then terr_id else
            //                                       case when p_group = 'KINETIX' and (terr_id like '%-K-%' or terr_id like '%-A-%' or terr_id like '%-B-%' 
            //                                       or terr_id like '-G-%') then terr_id else case when p_group = 'ASTER' and terr_id like '%A-%' then terr_id else
            //                                       case when p_group = 'GYRUS' and (terr_id like 'G1-%' or terr_id like 'G2-%') then terr_id else
            //                                       case when p_group = 'OPERON-XENOVISION' and terr_id like '%O-%' then terr_id else null end end end end end end terr_id,
            //                                       brand_name,doctor_id,exposer_qty
            //                                from mis.doctor_wise_item_utilization iu,(select distinct s_group p_group,brand from sample_new.item_info@web_to_hrtms
            //                                                                          where TYPE2 in ('COMM.PACK','CC')) bg
            //                                where substr(terr_id,1,instr(terr_id,'-'))||'00' = '$request->rmTerr'
            //                                and iu.brand_name = bg.brand
            //                                and brand_name = '$request->brandName'
            //                                )where terr_id is not null group by terr_id,brand_name
            //                         ) b
            //     where a.terr_id = b.terr_id

            // ");

            return response()->json($resp_data);
        }
    } 

function brandWiseRegionalDoc(Request $request){
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::select("
                                SELECT A.TERR_ID,B.DOCTOR_ID,B.DOCTOR_NAME,B.ADDRESS
                                FROM 
                                (SELECT DISTINCT TERR_ID,DOCTOR_ID
                                FROM MIS.DOCTOR_WISE_ITEM_UTILIZATION
                                WHERE  SUBSTR(TERR_ID,1,INSTR(TERR_ID,'-'))||'00' = ?
                                AND BRAND_NAME = ?
                                ORDER BY DOCTOR_ID) A, (SELECT DISTINCT REGION,DOCTOR_ID,DOCTOR_NAME,DECODE(HOSPITAL_NAME,HOSPITAL_NAME,CHEMBER_ADDRESS) ADDRESS FROM doctor_info.doctor_information@web_to_sample_msd) B
                                WHERE A.DOCTOR_ID = B.DOCTOR_ID
                                ORDER BY B.DOCTOR_ID    
                                 ", [$request->rmTerr, $request->brandName]);
            return response()->json($resp_data);
        }
    }


}