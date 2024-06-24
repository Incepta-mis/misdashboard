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


class ItemUsesController extends Controller
{


    /*Item uses starts*/
    public function displayItemUses(){

        $uid= Auth::user()->user_id;
        $plant_id= Auth::user()->plant_id;

        $cost_center_id_name = DB::select("Select COST_CENTER_NAME,COST_CENTER_ID from MIS.IT_COST_CENTER where PLANT_ID='$plant_id'");
        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID FROM MIS.IT_ITEM_MASTER");
        $ir_no = DB::select("SELECT DISTINCT IR_NO from MIS.IT_ITEM_REQUISITION_M");

        return view('stationery.item_uses',['item_name'=>$item_name,'cost_center_id_name'=>$cost_center_id_name,'ir_no'=>$ir_no]);

    }


   /* public function getItemDetails(Request $request){

        $item_details = DB::select("SELECT DISTINCT a.ITEM_ID,a.GL,b.IR_NO,b.GL,b.cost_center,c.CWIP_ID,c.MAIN_ID,c.SAP_PR FROM MIS.IT_ITEM_MASTER a 
    INNER JOIN  MIS.IT_ITEM_REQUISITION_D b ON a.ITEM_ID=b.ITEM_ID INNER JOIN MIS.IT_UPGRADE_CWIPID_TO_MAINID c ON b.ITEM_ID=c.ITEM_ID  WHERE a.ITEM_ID ='ITM-2'");


        if($item_details){
            return response()->json($item_details);
        }else{
            return response()->json("");
        }
    }
*/


    public function saveUseItem(Request $request){
        $itemdata = $request->data;

        $uid= Auth::user()->user_id;
        $plant_id= Auth::user()->plant_id;


        $data = DB::select("SELECT MAX(CAST(SUBSTR( IUR_NO, 9 ) AS INT)) max_id FROM MIS.IT_ITEM_ISSUE_USAGE_M");
        $max_id = $data[0]->max_id;
        $max_idd = (int)$max_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


        if($max_id!=''){
            $max_idd++;
            $new_iur_no = "IUR".$plant_id.'-'.$max_idd;
        }else{
            $new_iur_no = "IUR".$plant_id.'-1';
        }


        $issueItemData = json_decode($itemdata, true);
        $issueItemMaster['IUR_NO']= $new_iur_no;
        $issueItemMaster['IUR_DATE']= $date;
        $issueItemMaster['COMPANY_CODE']= '1000';
        $issueItemMaster['PLANT_ID']= $plant_id;
        $issueItemMaster['CREATE_USER']= Auth::user()->user_id;
        $issueItemMaster['CREATE_DATE']= $date;


        $status = DB::table('MIS.IT_ITEM_ISSUE_USAGE_M')->insert($issueItemMaster);
        if($status){
            for($i=0;$i<sizeof($issueItemData);$i++){
                $issueItemData[$i]['IUR_NO']= $new_iur_no;
                $issueItemData[$i]['CREATE_USER']= Auth::user()->user_id;
                $issueItemData[$i]['CREATE_DATE']= $date;
            }

            $status = DB::table('MIS.IT_ITEM_ISSUE_USAGE_D')->insert($issueItemData);
            if($status){

                return response()->json(['result'=>'success']);
            }else{

                return response()->json(['result'=>'error']);
            }
        }else{

            return response()->json(['result'=>'error']);
        }

    }

    public function getIURNo(){
        $user_id = Auth::user()->user_id;
        $iur_no = DB::SELECT("Select DISTINCT IUR_NO from  MIS.IT_ITEM_ISSUE_USAGE_M WHERE CREATE_USER ='$user_id'");
        if($iur_no){
            return response()->json($iur_no);
        }else{
            return response()->json("error");
        }
    }

    public function showIurdata(Request $request){
        $issuedItems= DB::SELECT("Select * from MIS.IT_ITEM_ISSUE_USAGE_D where IUR_NO = '$request->ir_no'");
        return response()->json(['usedItems'=>$issuedItems]);
    }

    public function updateIusedItem(Request $request){

        $table_id = $request->id;
        $decoded_data = json_decode($request->itemArray);


        $edit_iur_no = $decoded_data->edit_iur_no;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_ir_no = $decoded_data->edit_ir_no;
        $edit_cwip_id = $decoded_data->edit_cwip_id;
        $edit_main_id = $decoded_data->edit_main_id;
        $edit_po_number = $decoded_data->edit_po_number;
        $edit_pr_number = $decoded_data->edit_pr_number;
        $edit_gl = $decoded_data->edit_gl;
        $edit_cost_center = $decoded_data->edit_cost_center;
        $edit_use_qty = $decoded_data->edit_use_qty;
        $edit_remarks = $decoded_data->edit_remarks;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        $edit_iur_no = $decoded_data->edit_iur_no;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_ir_no = $decoded_data->edit_ir_no;
        $edit_cwip_id = $decoded_data->edit_cwip_id;
        $edit_main_id = $decoded_data->edit_main_id;
        $edit_po_number = $decoded_data->edit_po_number;
        $edit_pr_number = $decoded_data->edit_pr_number;
        $edit_gl = $decoded_data->edit_gl;
        $edit_cost_center = $decoded_data->edit_cost_center;
        $edit_use_qty = $decoded_data->edit_use_qty;
        $edit_remarks = $decoded_data->edit_remarks;

        if($edit_ir_no!=''){
            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_ISSUE_USAGE_D
                        SET
                            IR_NO = '$edit_ir_no',
                            ITEM_ID = '$edit_item_id',
                            ITEM_NAME = '$edit_item_name',
                            CWIP_ID = '$edit_cwip_id',
                            MAIN_ID = '$edit_main_id',
                            PO_NUMBER = '$edit_po_number',
                            PR_NUMBER = '$edit_pr_number',
                            GL = '$edit_gl',
                            COST_CENTER = '$edit_cost_center',
                            USE_QTY = '$edit_use_qty',
                            REMARKS = '$edit_remarks',
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$table_id'");
            return response()->json(['result'=> "success"]);

        }else{

            return response()->json(['result'=> "error"]);
        }

    }

    public function deleteItemUses(Request $request){

        $id = $request->id;
        $iur_no = $request->iur_no;

        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_ISSUE_USAGE_D WHERE ID = ?',[$id]);
            if($result){

                $result =  DB::SELECT('select iur_no FROM MIS.IT_ITEM_ISSUE_USAGE_D WHERE IUR_NO = ?',[$iur_no]);
                if($result){
                    return response()->json(['result'=> 'true']);
                }else{
                    $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_ISSUE_USAGE_M WHERE IUR_NO = ?',[$iur_no]);
                    if($result){
                        return response()->json(['result'=> 'true']);
                    }else{
                        return response()->json(['result'=> 'false']);
                    }
                }

            }else{
                return response()->json(['result'=> 'false']);
            }

        }else{
            return response()->json(['result'=> 2]);
        }

    }

    /*Item uses ends*/

}