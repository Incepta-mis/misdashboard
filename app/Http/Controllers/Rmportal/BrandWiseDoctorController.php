<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 18/02/18
 * Time: 15:06
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



class BrandWiseDoctorController extends Controller
{

    public function regwMpoTerrList(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.am_terr_id = '$request->amTerr'
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");
            return response()->json($resp_data);
            //return response()->json($request->all());
        }
    }

    public function brandWiseDrData(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $brandName = $request->BrandName;

            $resp_data = DB::select("
                                select  distinct terr_id,dwiu.doctor_id,di.doctor_name,brand_name
                                from mis.doctor_wise_item_utilization dwiu,doctor_info.doctor_information@web_to_sample_msd di
                                where DWIU.DOCTOR_ID = di.doctor_id 
                                and terr_id =  '$request->TerrId'
                                and brand_name = decode('$brandName','All',brand_name,'$brandName')
                                order by doctor_id asc
                            ");

            return response()->json($resp_data);
            //return response()->json($request->all());
        }
    }

    public function terrWiseDrBrand(Request $request)
    {
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

    public function terrWiseDrBrandItems(Request $request)
    {
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

    // public function brandWiseDocDataDelete(Request $request)
    // {
    //     if ($request->ajax()) {

    //         //ini_set('max_execution_time', 600);


    //         foreach ($request->deleteData as $data) {

    //             if (ItemWiseDoctorAssign::where('TERR_ID', $data['terr_id'])
    //                 ->where('BRAND_NAME', $data['brand_name'])
    //                 ->where('DOCTOR_ID', $data['doctor_id'])->count() > 0) {
    //                 return response()->json(['error' => 'Your request has been approved by Admin, please wait for 1 hour.']);
    //             } else {
    //                 $dataArray = [
    //                     'TERR_ID' => $data['terr_id'],
    //                     'DOCTOR_ID' => $data['doctor_id'],
    //                     'DOCTOR_NAME' => $data['doctor_name'],
    //                     'BRAND_NAME' => $data['brand_name'],
    //                     'CREATE_USER' => Auth::user()->user_id
    //                 ];
    //                 ItemWiseDoctorAssign::insert($dataArray);
    //             }

    //         }

    //         return response()->json(['success' => 'Your request has been received and will be processed shortly, please check after 1 hour.']);
    //     }
    // }

  public function brandWiseDocDataDelete(Request $request)
    {
        if ($request->ajax()) {

            //ini_set('max_execution_time', 600);

            foreach ($request->deleteData as $data) {

                    $dataArray = [
                        'TERR_ID' => $data['terr_id'],
                        'DOCTOR_ID' => $data['doctor_id'],
                        'DOCTOR_NAME' => $data['doctor_name'],
                        'BRAND_NAME' => $data['brand_name'],
                        'CREATE_USER' => Auth::user()->user_id
                    ];
                    ItemWiseDoctorAssign::insert($dataArray);


                DB::DELETE("
                        delete from MIS.DOCTOR_WISE_ITEM_UTILIZATION
                        where TERR_ID||DOCTOR_ID||BRAND_NAME in(
                        SELECT   DISTINCT TERR_ID||DOCTOR_ID||BRAND_NAME
                        FROM   MIS.ITEM_WISE_DOCTOR_ASSIGN
                        where DELETE_STATUS = 'NO')
                    ");

                DB::UPDATE("
                        update MIS.ITEM_WISE_DOCTOR_ASSIGN
                        set DELETE_STATUS = 'YES'
                        where DELETE_STATUS = 'NO'
                        AND TERR_ID = ?
                        AND DOCTOR_ID = ?
                        AND BRAND_NAME = ?
                    " , [$data['terr_id'],$data['doctor_id'],$data['brand_name']]);
            }

            return response()->json(['success' => 'Brand Wise Doctor deleted Successfully.']);
        }
    }




}