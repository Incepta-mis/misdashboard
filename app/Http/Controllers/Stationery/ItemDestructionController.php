<?php

namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemDestructionController extends Controller
{
    public function index(){
        $plant_id = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;

        $companyData = DB::select("select distinct com_id,com_name,sap_com_id from hrms.company_info@WEB_TO_HRMS  WHERE sap_com_id = '1000' order by com_id ");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $department = DB::select("select distinct dept_id,dept_name from hrms.dept_information@WEB_TO_HRMS order by dept_name");
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
     /*   $services = DB::SELECT("SELECT DISTINCT SERVICE_ID FROM MIS.IT_ITEM_DESTRUCTION ORDER BY SERVICE_ID ASC");*/

        $services = DB::SELECT("SELECT DISTINCT SERVICE_ID FROM MIS.IT_ITEM_DESTRUCTION where item_id in (select item_id from MIS.IT_ITEM_MASTER_DEV where HO_CDM='$uid') ORDER BY SERVICE_ID ASC");

        
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plant_id' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");

        return view('stationery.itemDestruction', ['costCenter'=>$costCenter,'companyData' => $companyData,
            'plants'=>$allPlants,'item_data'=>$itemData,'department'=>$department,'services'=>$services]);
    }
    public function insertDestructionData(Request $request){
        $uid = Auth::user()->user_id;
        $com_code = $request->com_code;
        $plant_id = $request->plant_id;
        $main_id = $request->main_id;
        $cwip_id = $request->cwip_id;
        $gl = $request->gl;
        $cost_center = $request->cost_center;
        $item_id = $request->item_id;
        $item_name = $request->item_name;
        $qty = $request->qty;
        $unit = $request->unit;
        $unit_price = $request->unit_price;
        $origin_plant = $request->origin_plant;
        $username = $request->username;
        $dept = $request->dept;
        $reason = $request->reason;
        $status = $request->status;
        $remarks = $request->remarks;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($com_code != "" && $plant_id != "" && $item_id != "" && $item_name != "" && $qty != "" && $unit != "" && $unit_price != ""
            && $origin_plant != "" && $dept != "" && $reason != "" && $status != ""){


            $data = DB::select("SELECT MAX(SUBSTR( SERVICE_ID, 10 )) max_id FROM MIS.IT_ITEM_DESTRUCTION");
            $max_id = $data[0]->max_id;

            if($max_id != ""){
                $max_id++;
                $new_srvc_id = "SRVC".$plant_id."-".$max_id;
            }else{
                $new_srvc_id = "SRVC".$plant_id."-1";
            }

            $result =  DB::insert('insert into MIS.IT_ITEM_DESTRUCTION ( SERVICE_ID, COMPANY_CODE, PLANT_ID, MAIN_ID, CWIP_ID, GL, COST_CENTER,ITEM_ID, ITEM_NAME, QTY, UNIT, UNIT_PRICE, ORIGIN_PLANT, USER_NAME, DEPARTMENT, REASON, STATUS, REMARKS, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$new_srvc_id, $com_code, $plant_id, $main_id, $cwip_id, $gl, $cost_center, $item_id, $item_name, $qty, $unit, $unit_price, $origin_plant, $username, $dept, $reason,  $status, $remarks, $date, $uid]);

            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function editDestructionData(Request $request){
        $uid = Auth::user()->user_id;

        $table_id = $request->table_id;
        $main_id = $request->main_id;
        $cwip_id = $request->cwip_id;
        $cost_center = $request->cost_center;
        $gl = $request->gl;
        $qty = $request->qty;
        $unit = $request->unit;
        $unit_price = $request->unit_price;
        $origin_plant = $request->origin_plant;
        $username = $request->username;
        $reason = $request->reason;
        $status = $request->status;
        $remarks = $request->remarks;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($main_id != "" && $cwip_id != "" &&
            $cost_center != "" &&  $qty != "" && $unit != "" && $unit_price != ""
            && $origin_plant != "" && $reason != "" && $status != ""){

            $result =  DB::UPDATE("UPDATE MIS.IT_ITEM_DESTRUCTION SET MAIN_ID = '$main_id', CWIP_ID = '$cwip_id', GL = '$gl', COST_CENTER = '$cost_center', QTY = '$qty',
                                   UNIT = '$unit', UNIT_PRICE = '$unit_price', ORIGIN_PLANT = '$origin_plant', USER_NAME = '$username', REASON = '$reason', 
                                   STATUS = '$status', REMARKS = '$remarks', UPDATE_DATE = '$date', UPDATE_USER = '$uid' WHERE ID = '$table_id'");

            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function getItemDestReport(Request $request){
        $service_id = $request->service_id;
        $data = DB::select("SELECT * FROM MIS.IT_ITEM_DESTRUCTION WHERE SERVICE_ID = decode ('$service_id','All',SERVICE_ID,'$service_id')");
        return response()->json($data);
    }
    public function deleteDestructionData(Request $request){
        $id = $request->id;

        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_DESTRUCTION WHERE ID = ?',[$id]);
            return response()->json(['result'=> $result]);
        }else{
            return response()->json(['result'=> 2]);
        }
    }
}
