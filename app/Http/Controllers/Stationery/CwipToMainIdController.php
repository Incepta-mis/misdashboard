<?php
namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PayUService\Exception;
use mysql_xdevapi\Table;



class CwipToMainIdController extends Controller
{
    /* CWIP to main id starts*/
    public function cwipIdToMainID(){

        $cwip_id = DB::select("SELECT ITEM_ID, SAP_CWIP_ID, UNIT FROM MIS.IT_CHALLAN_RECEIVE_D WHERE ITEM_ID IN 
                             (SELECT ITEM_ID FROM MIS.IT_ITEM_MASTER WHERE IT_NAME= 'CAPEX') AND SAP_CWIP_ID NOT IN(SELECT DISTINCT CWIP_ID FROM MIS.IT_UPGRADE_CWIPID_TO_MAINID)");


        $uid= Auth::user()->user_id;

        $plant_id= Auth::user()->plant_id;

        return view('stationery.cwipIdToMAinId', ['cwip_id'=>$cwip_id,'exist_plant'=>$plant_id]);

    }

    public function saveCwipIdToMainID(Request $request){
        $uid = Auth::user()->user_id;

        $data = DB::select("SELECT MAX(AU_ID) au_id FROM  MIS.IT_UPGRADE_CWIPID_TO_MAINID");
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if(!($data[0]->au_id)){
            $au_id = 1;
        }else{
            $au_id = $data[0]->au_id;
        }

        $cwipItemData = json_decode($request->cwipItemData,true);
        log::info($cwipItemData);

        for($i=0;$i<sizeof($cwipItemData);$i++){
            $cwipItemData[$i]['AU_ID']='1';
            $cwipItemData[$i]['COMPANY_CODE']= '1000';
            $cwipItemData[$i]['CREATE_USER']= $uid;
            $cwipItemData[$i]['UPDATE_USER']= '';
            $cwipItemData[$i]['CREATE_DATE']= $date;
            $cwipItemData[$i]['UPDATE_DATE']= '';
        }
        $status = DB::table('MIS.IT_UPGRADE_CWIPID_TO_MAINID')->insert($cwipItemData);
        if($status){
            return response()->json("success");
        }else{
            return response()->json("error");
        }

    }

    public function updateCwipIdToMainId(Request $request){

        $table_id = $request->id;

        $decoded_data = json_decode($request->itemArray);


        $edit_ist_id = $decoded_data->edit_ist_id;
        $edit_ist_name = $decoded_data->edit_ist_name;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_gr_qty = $decoded_data->edit_gr_qty;
        $edit_unit = $decoded_data->edit_unit;
        $edit_sap_pr = $decoded_data->edit_sap_pr;
        $edit_exist_plant = $decoded_data->edit_exist_plant;
        $edit_split_qty = $decoded_data->edit_split_qty;
        $edit_main_id = $decoded_data->edit_main_id;
        $edit_new_plant = $decoded_data->edit_new_plant;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


        if($edit_ist_id!=''){


            $result =  DB::UPDATE("
                        UPDATE MIS.IT_UPGRADE_CWIPID_TO_MAINID
                        SET
                            IST_ID = '$edit_ist_id',
                            IST_NAME = '$edit_ist_name',
                            ITEM_ID = '$edit_item_id',
                            GR_QTY = '$edit_gr_qty',
                            UNIT = '$edit_unit',
                            SAP_PR = '$edit_sap_pr',
                            EXIST_PLANT = '$edit_exist_plant',
                            SPLIT_QTY = '$edit_split_qty',
                            MAIN_ID = '$edit_main_id',
                            NEW_PLANT = '$edit_new_plant',
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$table_id'");


            return response()->json(['result'=> "success"]);

        }else{

            return response()->json(['result'=> "error"]);

        }


    }

    public function deleteCwipIdToMainId(Request $request){

        $table_id = $request->id;

        if($request->id!=''){

            $status =DB::DELETE("DELETE FROM  MIS.IT_UPGRADE_CWIPID_TO_MAINID WHERE id = '$table_id'");
            return response()->json(['status'=>'success']);

        }else{
            return response()->json(['status'=>'error']);
        }
    }


    public function getAllCwipNo(){
        $cwip_id = DB::select("Select distinct cwip_id from MIS.IT_UPGRADE_CWIPID_TO_MAINID");
        return response()->json($cwip_id);

    }

    public function getCwipRelatedData(Request $request){
        $cwip_id = $request->cwip_data;


        $cwip_details = DB::select("SELECT C.ITEM_ID,M.IST_ID,M.IST_NAME, C.QTY,C.UNIT, CR.SAP_PR FROM MIS.IT_CHALLAN_RECEIVE_D C INNER JOIN 
         MIS.IT_ITEM_MASTER M on C.ITEM_ID = M.ITEM_ID INNER JOIN MIS.IT_CHALLAN_RECEIVE_M CR on C.CHALLAN_NO=CR.CHALLAN_NO  where C.SAP_CWIP_ID='$cwip_id'");


        if($cwip_details){
            return response()->json(['result'=>$cwip_details]);
        }else{
            return response()->json(['result'=>"error"]);
        }
    }

    public function showCwipData(Request $request){

        $cwip_id = $request->cwip_id;

        $challan_id = DB::select("SELECT DISTINCT * FROM MIS.IT_UPGRADE_CWIPID_TO_MAINID where cwip_id= '$cwip_id'");
        return response()->json($challan_id);
    }

     /*CWIP to main id ends*/


}