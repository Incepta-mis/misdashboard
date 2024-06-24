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


class ItemTransferController extends Controller
{

   public function transferItem(){
        $uid= Auth::user()->user_id;
        $item_name = DB::SELECT("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $plant_id = Auth::user()->plant_id;

        $transItems = DB::SELECT("SELECT DISTINCT a.ITR_NO, b.id FROM IT_ITEM_TRANSFER_RECEIVE_M a 
        INNER JOIN IT_ITEM_TRANSFER_D b ON a.TRANSFER_ID = b.ID 
        INNER JOIN IT_ITEM_TRANSFER_M d ON a.IT_NO = d.IT_NO 
        INNER JOIN IT_ITEM_TRANSFER_RECEIVE_D c ON c.ITEM_ID = b.ITEM_ID 
        WHERE b.RECEIVE_DATE IS NOT NULL AND a.CREATE_USER = '$uid' AND b.UPDATE_USER = '$uid' AND d.PLANT_TO = '$plant_id' AND b.id NOT IN (SELECT REF_ID FROM MIS.IT_ITEM_TRANSFER_D WHERE REF_ID IS NOT NULL)");

        $plant = DB::select("select distinct plant_id,plant_name 
                            from hrms.plant_info@WEB_TO_HRMS
                            where com_id = 1 order by plant_id");

        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plant_id' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");

        return view('stationery.item_transfer', ['costCenter'=>$costCenter,'item_name'=>$item_name,'uid'=>$uid,
            'transItems'=>$transItems,'plant_id'=>$plant_id,'plants'=>$plant]);
    }

    public function getIt_no(Request $request){
        $uid= Auth::user()->user_id;
        $itr_no = $request->itr_no;
        $data = DB::SELECT("SELECT a.IT_NO FROM IT_ITEM_TRANSFER_RECEIVE_M a INNER JOIN IT_ITEM_TRANSFER_D b ON a.IT_NO = b.IT_NO WHERE a.CREATE_USER = '$uid' AND a.ITR_NO = '$itr_no'");
        return response()->json($data);
    }

    public function getStockQty(Request $request){

        $plant_id = Auth::user()->plant_id;
        $item_id = $request->item_id;

        $data = DB::SELECT("SELECT QTY FROM MIS.IT_ITEM_STOCK WHERE PLANT_ID = '$plant_id' AND ITEM_ID = '$item_id'");
        if(count($data) > 0){
            return response()->json(['status'=>1,'qty'=>$data[0]->qty]);
        }else{
            return response()->json(['status'=>0]);
        }
    }

    public function getRecvedItemDetails(Request $request){
        $itr_no = $request->itr_no;

        $itemDetails = DB::SELECT("SELECT b.*,a.IT_NO,c.IT_NAME FROM IT_ITEM_TRANSFER_RECEIVE_M a INNER JOIN IT_ITEM_TRANSFER_RECEIVE_D b on a.ITR_NO = b.ITR_NO INNER JOIN IT_ITEM_MASTER c on b.ITEM_ID = c.ITEM_ID WHERE  a.ITR_NO = '$itr_no'");
        return response()->json(['itemDetails'=>$itemDetails]);
    }

     public function itemTransferbyCDM(Request $request){

        $uid = Auth::user()->user_id;
        $finalARr = $request->finalARr;
        $itr_no = $request->itr_no;
        $it_no = $request->it_no;
        $plantId = Auth::user()->plant_id;

        $date = Carbon::now()->format('Y-m-d H:m:s');
        $status = 0;

        for ($i = 0; $i < count($finalARr); $i++){
            if($finalARr[$i]['it_name'] == 'STATIONERY'){
                if($finalARr[$i]['gl'] != null && $finalARr[$i]['cc'] != null && $finalARr[$i]['tr'] != null){
                    $status = 1;
                }else{
                    $status = 0;
                }
            }else if($finalARr[$i]['it_name'] == 'CAPEX'){
                if($finalARr[$i]['cwip'] != null && $finalARr[$i]['main'] != null && $finalARr[$i]['tr'] != null){
                    $status = 1;
                }else{
                    $status = 0;
                }
            }
            if($status === 0){
                break;
            }
        }
        if($status === 0){
            return response()->json(['response'=>5]);
        }else{
            $qry1 = DB::SELECT("SELECT * FROM MIS.IT_ITEM_TRANSFER_M WHERE IT_NO = '$it_no'");
            $plant_from = $qry1[0]->plant_from;
            $plant_to = $qry1[0]->plant_to;

            $data = DB::select("SELECT MAX(CAST(SUBSTR( IT_NO, 8 ) AS INT)) max_id FROM MIS.IT_ITEM_TRANSFER_M");
            $max_id = $data[0]->max_id;
            if($max_id != ""){
                $max_id++;
                $new_ID = "IT".$plantId."-".$max_id;
            }else{
                $new_ID = "IT".$plantId."-1";
            }

            $result =  DB::insert('insert into MIS.IT_ITEM_TRANSFER_M ( IT_NO, IT_DATE, COMPANY_CODE, PLANT_FROM, PLANT_TO, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?)',[$new_ID, $date,'1000',  $plantId, $plant_from, $date, $uid]);

            for ($i=0; $i<count($finalARr); $i++){

                $info = DB::SELECT("SELECT id FROM MIS.IT_ITEM_TRANSFER_D WHERE IT_NO='$it_no' AND ITEM_ID = '"
                    .$finalARr[$i]['item_id']."'");

                $result =  DB::insert('insert into MIS.IT_ITEM_TRANSFER_D ( IT_NO, ITEM_ID, ITEM_NAME, CWIP_ID, MAIN_ID, PO_NUMBER, PR_NUMBER, GL, COST_CENTER, TRANSFER_REASON, QTY, UNIT, REMARKS, CREATE_DATE, CREATE_USER, REF_ID )
                               values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$new_ID, $finalARr[$i]['item_id'],
                    $finalARr[$i]['item_name'],$finalARr[$i]['cwip'],$finalARr[$i]['main'],$finalARr[$i]['po'],
                    $finalARr[$i]['pr'],$finalARr[$i]['gl'],$finalARr[$i]['cc'],$finalARr[$i]['tr'],
                    $finalARr[$i]['qty'],$finalARr[$i]['unit'], $finalARr[$i]['remarks'],$date,$uid, $info[0]->id]);
            }
            return response()->json(['response'=>$result]);
        }
    }
    public function saveTransferItem(Request $request){
        $uid= Auth::user()->user_id;
        $plant_id= Auth::user()->plant_id;
        $transfer_to = $request->transfer_to;

        $data = DB::select("SELECT MAX(CAST(SUBSTR( IT_NO, 8 ) AS INT)) max_id FROM  MIS.IT_ITEM_TRANSFER_M");
        $max_id = $data[0]->max_id;
        $max_idd = (int)$max_id;

        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($max_id!=''){
            $max_idd++;
            $new_ir_no = "IT".$plant_id.'-'.$max_idd;
        }else{
            $new_ir_no = "IT".$plant_id.'-1';
        }

        $transferItemMaster['IT_NO']= $new_ir_no;
        $transferItemMaster['IT_DATE']= $date;
        $transferItemMaster['COMPANY_CODE']= '1000';
        $transferItemMaster['PLANT_FROM']= $plant_id;
        $transferItemMaster['PLANT_TO']= $transfer_to;
        $transferItemMaster['CREATE_USER']= Auth::user()->user_id;
        $transferItemMaster['CREATE_DATE']= $date;
        $transferItemMaster['RECEIVE_DATE']= '';


        $status = DB::table('MIS.IT_ITEM_TRANSFER_M')->insert($transferItemMaster);

        $transferItemData = json_decode($request->transferItemData, true);

        if($status){
            for($i=0;$i<sizeof($transferItemData);$i++){
                $transferItemData[$i]['IT_NO']= $new_ir_no;
                $transferItemData[$i]['CREATE_USER']= Auth::user()->user_id;
                $transferItemData[$i]['CREATE_DATE']= $date;
                $transferItemData[$i]['RECEIVE_DATE']= '';
            }
            $status = DB::table('MIS.IT_ITEM_TRANSFER_D')->insert($transferItemData);
            if($status){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
        }else{
            return response()->json("error");
        }
    }

    public function getMyTransferedItem(){
        $uid= Auth::user()->user_id;
        $displayMyItems = DB::SELECT("SELECT DISTINCT IT_NO FROM MIS.IT_ITEM_TRANSFER_D WHERE CREATE_USER='$uid' ORDER BY IT_NO DESC");
        return response()->json($displayMyItems);
    }

    public function displayTransferedData(Request $request){
        $transferedData = DB::SELECT("select * FROM  MIS.IT_ITEM_TRANSFER_D where it_no='$request->it_no' ");
        return response()->json(['transferedData'=>$transferedData]);
    }

    public function updateTransferedItem(Request $request){
        $table_id = $request->id;
        $decoded_data = json_decode($request->itemArray);
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_cwip_id = $decoded_data->edit_cwip_id;
        $edit_main_id = $decoded_data->edit_main_id;
        $edit_po = $decoded_data->edit_po;
        $edit_pr = $decoded_data->edit_pr;
        $edit_gl = $decoded_data->edit_gl;
        $edit_cc = $decoded_data->edit_cc;
        $edit_transfer_reason = $decoded_data->edit_transfer_reason;
        $edit_pr_qty = $decoded_data->edit_pr_qty;
        $edit_unit = $decoded_data->edit_unit;
        $edit_remarks = $decoded_data->edit_remarks;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


        // return response()->json("hhwllo update");


        if($edit_item_id!=''){

            //return response()->json("hhwllo update");

            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_TRANSFER_D 
                        SET
                            ITEM_ID = '$edit_item_id',
                            ITEM_NAME = '$edit_item_name',
                            CWIP_ID = '$edit_cwip_id',
                            MAIN_ID = '$edit_main_id',
                            PO_NUMBER = '$edit_po',
                            PR_NUMBER = '$edit_pr',
                            GL = '$edit_gl',
                            COST_CENTER = '$edit_cc',
                            TRANSFER_REASON = '$edit_transfer_reason',
                            QTY = '$edit_pr_qty',
                            UNIT = '$edit_unit',
                            REMARKS = '$edit_remarks',
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$table_id'");


            return response()->json(['result'=> "success"]);

        }else{

            return response()->json(['result'=> "error"]);

        }


    }

    public function deleteTransferItem(Request $request){
        $id = $request->id;
        $it_no = $request->it_no;

        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_TRANSFER_D WHERE ID = ?',[$id]);
            if($result){

                $result =  DB::SELECT('select it_no FROM MIS.IT_ITEM_TRANSFER_D WHERE IT_NO = ?',[$it_no]);
                if($result){
                    return response()->json(['result'=> 'true']);
                }else{
                    $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_TRANSFER_M WHERE IT_NO = ?',[$it_no]);
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
    /*Item transfer ends*/

}


