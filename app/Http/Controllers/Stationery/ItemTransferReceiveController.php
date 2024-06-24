<?php

namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemTransferReceiveController extends Controller
{
    public function index(){

        $uid = Auth::user()->user_id;
        $plant_id = Auth::user()-> plant_id;

        $arr = [];

        $QRY = "SELECT DISTINCT b.IT_NO FROM MIS.IT_ITEM_TRANSFER_M a INNER JOIN MIS.IT_ITEM_TRANSFER_D b on a.IT_NO = b.IT_NO WHERE a.CREATE_USER <> '$uid' AND a.PLANT_TO = '$plant_id' AND b.RECEIVE_DATE IS NULL ORDER BY b.IT_NO ASC";
        $mData = DB::SELECT($QRY);

        for($i=0; $i<count($mData); $i++){
            $it_no = $mData[$i]->it_no;
            $qry2 = DB::SELECT("SELECT * FROM MIS.IT_ITEM_TRANSFER_D WHERE IT_NO = '$it_no'");
            for($j=0; $j<count($qry2); $j++){
                if($qry2[$j]->ref_id != null){
                    $ref_id = $qry2[$j]->ref_id;
                    $qry3 = DB::SELECT("SELECT IT_NO FROM MIS.IT_ITEM_TRANSFER_D WHERE ID = '$ref_id' AND RECEIVE_DATE IS NOT NULL");
                    if(count($qry3) > 0){
                        array_push($arr,$qry3[0]->it_no);
                    }
                }else{
                    array_push($arr,$it_no);
                }
            }
        }
        $arr = array_unique($arr);

        return view('stationery.itemTransferReceive',['mdata'=>$arr,'uid'=>$uid]);
    }
       public function getItemTransfers(Request $request){


        $uid = Auth::user()->user_id;
        $plant_id = Auth::user()->plant_id;
        $it_no = $request->it_no;

        if($it_no != ""){
            $QRY2 = "SELECT IT_DATE FROM MIS.IT_ITEM_TRANSFER_M WHERE IT_NO = '$it_no' ";
            $itData = DB::select($QRY2);
        }else{
            $itData = [];
        }

        $notRcvd1 = DB::SELECT("SELECT a.*,b.IT_NAME FROM MIS.IT_ITEM_TRANSFER_D a INNER JOIN IT_ITEM_MASTER b on a.ITEM_ID = b.ITEM_ID WHERE a.IT_NO = '$it_no' AND a.RECEIVE_DATE IS NULL AND a.CREATE_USER <> '$uid' and a.item_id in (select item_id from MIS.IT_ITEM_MASTER_DEV where HO_CDM='$uid')  AND a.ID NOT IN (SELECT REF_ID FROM MIS.IT_ITEM_TRANSFER_D WHERE REF_ID IS NOT NULL) ORDER BY a.RECEIVE_DATE ASC");



        $qry1 = DB::SELECT("SELECT PLANT_TO FROM MIS.IT_ITEM_TRANSFER_M WHERE IT_NO = '$it_no'");
        $plant_to = $qry1[0]->plant_to;

        $notRcvd =  DB::SELECT("SELECT a.*,b.IT_NAME FROM MIS.IT_ITEM_TRANSFER_D a INNER JOIN IT_ITEM_MASTER b on a.ITEM_ID = b.ITEM_ID WHERE a.IT_NO = '$it_no' AND a.RECEIVE_DATE IS NOT NULL AND a.UPDATE_USER <> '$uid' AND a.ID IN (SELECT REF_ID FROM MIS.IT_ITEM_TRANSFER_D WHERE REF_ID IS NOT NULL) ORDER BY a.RECEIVE_DATE ASC");



        $arr = [];
        if(count($notRcvd) > 0){
            for($i=0; $i<count($notRcvd); $i++){

                $id = $notRcvd[$i]->id;
                $update_user = $notRcvd[$i]->update_user;

                if($update_user != null){

                    $checkUser = DB::SELECT("SELECT PLANT_ID FROM DASHBOARD_USERS_INFO WHERE USER_ID = '$update_user'");

                    if($checkUser[0]->plant_id == $plant_to) {
                        $qry = DB::SELECT("SELECT CWIP_ID,MAIN_ID,PO_NUMBER,PR_NUMBER,GL,COST_CENTER,TRANSFER_REASON,QTY,UNIT,REMARKS,RECEIVE_DATE,CREATE_USER FROM MIS.IT_ITEM_TRANSFER_D WHERE REF_ID = '$id'");

                        if (count($qry) > 0) {
                            if ($qry[0]->receive_date == "" && $qry[0]->create_user == $update_user) {
                                $notRcvd[$i]->cdmtransfer_reason = $qry[0]->transfer_reason;
                                $notRcvd[$i]->transfer_qty = $qry[0]->qty;
                                $notRcvd[$i]->transfer_unit = $qry[0]->unit;
                                $notRcvd[$i]->transfer_remarks = $qry[0]->remarks;

                                $notRcvd[$i]->cwip_id = $qry[0]->cwip_id;
                                $notRcvd[$i]->main_id = $qry[0]->main_id;
                                $notRcvd[$i]->po_number = $qry[0]->po_number;
                                $notRcvd[$i]->pr_number = $qry[0]->pr_number;
                                $notRcvd[$i]->gl = $qry[0]->gl;
                                $notRcvd[$i]->cost_center = $qry[0]->cost_center;

                                $notRcvd[$i]->userreceive_date = $qry[0]->receive_date;
                                $notRcvd[$i]->create_usercdm = $qry[0]->create_user;

                                array_push($arr, $notRcvd[$i]);
                            }
                        }
                    }
                }
            }
        }
        return response()->json(['pending2nd'=>$arr,'notRcvd'=>$notRcvd1,'uid'=>$uid,'it_date'=>$itData,
            'plant_id'=>$plant_id]);

    }
    public function updateTransferReceivedItems(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalARr;
        $it_no = $request->it_no;
        $it_date = $request->it_date;
        $queue = $request->queue;

        $plantId = Auth::user()->plant_id;


        $date = Carbon::now()->format('Y-m-d H:m:s');
        $status = 0;

        $row_id = 0;

        for ($i = 0; $i < count($finalARr); $i++){
            $row_id = $finalARr[$i]['id'];
            if($finalARr[$i]['it_name'] == 'STATIONERY'){
                if($finalARr[$i]['gl'] != null && $finalARr[$i]['cc'] != null){
                    $status = 1;
                }else{
                    $status = 0;
                }
            }else if($finalARr[$i]['it_name'] == 'CAPEX'){
                if($finalARr[$i]['cwip'] != null && $finalARr[$i]['main'] != null){
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
            $data = DB::select("SELECT MAX(CAST(SUBSTR( ITR_NO, 9 ) AS INT)) max_id FROM MIS.IT_ITEM_TRANSFER_RECEIVE_M");
            $max_id = $data[0]->max_id;
            if($max_id != ""){
                $max_id++;
                $new_ID = "ITR".$plantId."-".$max_id;
            }else{
                $new_ID = "ITR".$plantId."-1";
            }

            $result =  DB::insert('insert into MIS.IT_ITEM_TRANSFER_RECEIVE_M ( ITR_NO, IT_NO, IT_DATE, COMPANY_CODE, PLANT_ID, RECEIVE_DATE, CREATE_DATE, CREATE_USER, TRANSFER_ID )
                               values (?,?,?,?,?,?,?,?,?)',[$new_ID, $it_no, $it_date,'1000', $plantId, $date,  $date, $uid, $row_id]);

            for ($i=0; $i<count($finalARr); $i++){

                $qryRes = DB::SELECT("SELECT IT_NO FROM MIS.IT_ITEM_TRANSFER_D WHERE REF_ID = '".$finalARr[$i]['id']."'");

                if($queue == 'first'){
                    DB::UPDATE("UPDATE MIS.IT_ITEM_TRANSFER_M
                    SET RECEIVE_DATE = '$date',
                        UPDATE_USER = '$uid',
                        UPDATE_DATE = '$date'
                    WHERE IT_NO = '$it_no' AND RECEIVE_DATE IS NULL");

                    DB::UPDATE(" UPDATE MIS.IT_ITEM_TRANSFER_D
                        SET RECEIVE_DATE = '$date',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '".$finalARr[$i]['id']."' AND RECEIVE_DATE IS NULL");
                }else{
                    DB::UPDATE("UPDATE MIS.IT_ITEM_TRANSFER_M
                    SET RECEIVE_DATE = '$date',
                        UPDATE_USER = '$uid',
                        UPDATE_DATE = '$date'
                    WHERE IT_NO = '".$qryRes[0]->it_no."' AND RECEIVE_DATE IS NULL");

                    DB::UPDATE(" UPDATE MIS.IT_ITEM_TRANSFER_D
                        SET RECEIVE_DATE = '$date',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE REF_ID = '".$finalARr[$i]['id']."' AND RECEIVE_DATE IS NULL");
                }

                $cost_center = $finalARr[$i]['cc'];
                $cwip_id = $finalARr[$i]['cwip'];
                $gl = $finalARr[$i]['gl'];
                $main_id = $finalARr[$i]['main'];
                $po_number = $finalARr[$i]['po'];
                $pr_number = $finalARr[$i]['pr'];
                $cdmtransfer_reason = $finalARr[$i]['cdmtransfer_reason'];

                $qry = DB::SELECT("SELECT ITEM_ID, ITEM_NAME, TRANSFER_REASON, QTY, UNIT, REMARKS 
                FROM MIS.IT_ITEM_TRANSFER_D 
                WHERE ID = '".$finalARr[$i]['id']."'");

                if(count($qry) > 0){
                    $item_id = $qry[0]->item_id;
                    $item_name = $qry[0]->item_name;
                    $transfer_reason = $qry[0]->transfer_reason;
                    $qty = $qry[0]->qty;
                    $unit = $qry[0]->unit;
                    $remarks = $qry[0]->remarks;

                    if($queue != 'first'){
                        $result = DB::insert('insert into MIS.IT_ITEM_TRANSFER_RECEIVE_D ( ITR_NO, ITEM_ID, ITEM_NAME, CWIP_ID, MAIN_ID, PO_NUMBER, PR_NUMBER, GL,
                               COST_CENTER, TRANSFER_REASON, QTY, UNIT, REMARKS, RECEIVE_DATE, CREATE_DATE, CREATE_USER )
                           values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$new_ID, $item_id, $item_name, $cwip_id,
                            $main_id, $po_number, $pr_number, $gl, $cost_center, $cdmtransfer_reason, $qty,
                            $unit, $remarks,$date, $date, $uid]);
                    }else {
                        $result = DB::insert('insert into MIS.IT_ITEM_TRANSFER_RECEIVE_D ( ITR_NO, ITEM_ID, ITEM_NAME, CWIP_ID, MAIN_ID, PO_NUMBER, PR_NUMBER, GL,
                               COST_CENTER, TRANSFER_REASON, QTY, UNIT, REMARKS, RECEIVE_DATE, CREATE_DATE, CREATE_USER )
                           values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$new_ID, $item_id, $item_name, $cwip_id,
                            $main_id, $po_number, $pr_number, $gl, $cost_center, $transfer_reason, $qty,
                            $unit, $remarks,$date, $date, $uid]);
                    }
                }
            }
            return response()->json(['response'=>$result,'row_id'=>$row_id]);
        }
    }
}
