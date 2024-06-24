<?php

namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemReceiveController extends Controller
{
    public function index(){
        $uid = Auth::user()->user_id;
        $plantId = Auth::user()->plant_id;

        $QRY = "SELECT * FROM MIS.IT_ITEM_REQUISITION_M WHERE COMPANY_CODE = '1000' AND PLANT_ID = '$plantId' AND CREATE_USER = '$uid' ORDER BY IR_NO";
        $mData = DB::SELECT($QRY);

        return view('stationery.itemReceive',['mdata'=>$mData]);
    }
    public function getItemRequisitions(Request $request){
        $uid = Auth::user()->user_id;
        $ir_no = $request->ir_no;
        $req_id = [];
        $rec_d_id = [];

//        $checkQry = DB::select("SELECT a.*,b.IRR_NO FROM MIS.IT_ITEM_REQUISITION_D a INNER JOIN MIS.IT_ITEM_RECEIVE_M b on a.IR_NO = b.IR_NO WHERE a.ISSUE_DATE IS NOT NULL AND a.CREATE_USER = '$uid' AND a.IR_NO = '$ir_no'");

        $checkQry = DB::SELECT("SELECT a.* FROM MIS.IT_ITEM_REQUISITION_D a WHERE a.ISSUE_DATE IS NOT NULL AND a.CREATE_USER = '$uid' AND a.IR_NO = '$ir_no'");

        if(count($checkQry) > 0){
            $mData = [];
            for ($i = 0;$i < count($checkQry); $i++){
                $req_id[$i] = $checkQry[$i]->id;

                $qry1_1 = DB::SELECT("SELECT a.*,b.IRR_NO,c.ID recev_d_row_id FROM MIS.IT_ITEM_REQUISITION_D a INNER JOIN IT_ITEM_RECEIVE_M b on a.IR_No = b.IR_NO INNER JOIN IT_ITEM_RECEIVE_D c on b.IRR_NO = c.IRR_NO WHERE a.IR_NO = '$ir_no' AND c.ITEM_ID = a.ITEM_ID AND a.ID = '$req_id[$i]'");

                if(count($qry1_1) > 0){
                    $recev_d_row_id = $qry1_1[0]->recev_d_row_id;
                    $qry1 = DB::SELECT("SELECT * FROM MIS.IT_ITEM_RECEIVE_D WHERE ID = '$recev_d_row_id'");
                    $qry2 = DB::SELECT("SELECT a.*,b.IT_NAME FROM MIS.IT_ITEM_REQUISITION_D a INNER JOIN MIS.IT_ITEM_MASTER b on a.ITEM_ID = b.ITEM_ID WHERE a.ID = '$req_id[$i]'");
                    if($qry2[0]->issu_qty > $qry1[0]->recev_qty){
                        $temp = array();
                        $temp['id'] = $qry2[0]->id;
                        $temp['item_id'] = $qry2[0]->item_id;
                        $temp['item_name'] = $qry2[0]->item_name;
                        $temp['it_name'] = $qry2[0]->it_name;
                        $temp['gl'] = $qry2[0]->gl;
                        $temp['cc'] = $qry2[0]->cost_center;
                        $temp['req_qty'] = $qry2[0]->req_qty;
                        $temp['aprv_qty'] = $qry2[0]->aprv_qty;
                        $temp['issu_qty'] = $qry2[0]->issu_qty;
                        $temp['received_qty'] = $qry1[0]->recev_qty;
                        $temp['receivable_qty'] = $qry2[0]->issu_qty-$qry1[0]->recev_qty;
                        $temp['pen_qty'] = $qry2[0]->aprv_qty-$qry2[0]->issu_qty;
                        $temp['remarks'] = $qry2[0]->remarks;
                        $temp['issue_date'] = $qry2[0]->issue_date;
                        $temp['create_date'] = $qry2[0]->create_date;
                        $temp['update_date'] = $qry2[0]->update_date;
                        $temp['recev_d_row_id'] = $recev_d_row_id;
                        array_push($mData,$temp);
                    }
                }else{
                    $qry2 = DB::SELECT("SELECT a.*,b.IT_NAME FROM MIS.IT_ITEM_REQUISITION_D a INNER JOIN MIS.IT_ITEM_MASTER b on a.ITEM_ID = b.ITEM_ID WHERE a.ID = '$req_id[$i]'");

                    $temp = array();
                    $temp['id'] = $qry2[0]->id;
                    $temp['item_id'] = $qry2[0]->item_id;
                    $temp['item_name'] = $qry2[0]->item_name;
                    $temp['it_name'] = $qry2[0]->it_name;
                    $temp['gl'] = $qry2[0]->gl;
                    $temp['cc'] = $qry2[0]->cost_center;
                    $temp['req_qty'] = $qry2[0]->req_qty;
                    $temp['aprv_qty'] = $qry2[0]->aprv_qty;
                    $temp['issu_qty'] = $qry2[0]->issu_qty;
                    $temp['received_qty'] = 0;
                    $temp['receivable_qty'] = $qry2[0]->issu_qty;
                    $temp['pen_qty'] = $qry2[0]->aprv_qty-$qry2[0]->issu_qty;
                    $temp['remarks'] = $qry2[0]->remarks;
                    $temp['issue_date'] = $qry2[0]->issue_date;
                    $temp['create_date'] = $qry2[0]->create_date;
                    $temp['update_date'] = $qry2[0]->update_date;
                    $temp['recev_d_row_id'] = 0;
                    array_push($mData,$temp);
                }
            }
        }else{
            $mData = DB::SELECT("SELECT a.*,0 received_qty, a.issu_qty receivable_qty, b.IT_NAME FROM MIS.IT_ITEM_REQUISITION_D a INNER JOIN MIS.IT_ITEM_MASTER b on a.ITEM_ID = b.ITEM_ID WHERE a.ISSUE_DATE IS NOT NULL AND a.CREATE_USER = '$uid' AND a.IR_NO = '$ir_no'");
        }

        $dData = [];

        $qry5 = DB::SELECT("SELECT * FROM MIS.IT_ITEM_REQUISITION_D WHERE ISSUE_DATE IS NULL AND RECEIVE_DATE IS NULL AND CREATE_USER = '$uid' AND IR_NO = '$ir_no'");
        $qry4 = DB::SELECT("SELECT * FROM MIS.IT_ITEM_REQUISITION_D WHERE ISSUE_DATE IS NOT NULL AND APRV_QTY > ISSU_QTY AND CREATE_USER = '$uid' AND IR_NO = '$ir_no'");

        if(count($qry5) > 0) {
            foreach ($qry5 as $record) {
                $record->recev_qty = 0;
                array_push($dData, $record);
            }
        }
        if(count($qry4) > 0) {
            foreach ($qry4 as $record) {
                $ir_no = $record->ir_no;
                $item_id = $record->item_id;
                $qry = DB::SELECT("SELECT b.RECEV_QTY FROM MIS.IT_ITEM_RECEIVE_M a INNER JOIN IT_ITEM_RECEIVE_D b ON a.IRR_NO = b.IRR_NO WHERE a.IR_NO = '$ir_no' AND b.ITEM_ID = '$item_id'");
                if(count($qry) > 0){
                    $record->recev_qty = $qry[0]->recev_qty;
                }else{
                    $record->recev_qty = 0;
                }
                array_push($dData, $record);
            }
        }
        $prData = DB::SELECT("SELECT PR_DATE FROM MIS.IT_ITEM_REQUISITION_M WHERE IR_NO = '$ir_no'");

        return response()->json(['mData'=>$mData,'dData'=>$dData,'prDate'=>$prData]);
    }
    public function updateReceivedItems(Request $request){

        $uid = Auth::user()->user_id;
        $rowIDs = json_decode($request->rowIDs, true);
        $finalARr = $request->finalARr;
        $ir_no = $request->ir_no;
        $pr_date = Carbon::parse($request->pr_date)->format('Y-m-d');
        $plantId = Auth::user()->plant_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $status = 0;

        for ($i = 0; $i < count($finalARr); $i++){

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
            $data = DB::SELECT("SELECT MAX(CAST(SUBSTR( IRR_NO, 9 ) AS INT)) max_id FROM MIS.IT_ITEM_RECEIVE_M");
            $max_id = $data[0]->max_id;

            if($max_id != ""){
                $max_id++;
                $new_ID = "IRR".$plantId."-".$max_id;
            }else{
                $new_ID = "IRR".$plantId."-1";
            }

            $result =  DB::insert('insert into MIS.IT_ITEM_RECEIVE_M ( IRR_NO, IR_NO, PR_DATE, COMPANY_CODE, PLANT_ID, RECEIVE_DATE, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?,?)',[$new_ID, $ir_no, $pr_date,'1000',  $plantId, $date, $date, $uid]);

            DB::UPDATE("UPDATE MIS.IT_ITEM_REQUISITION_M
                SET RECEIVE_DATE = '$date',
                    UPDATE_USER = '$uid',
                    UPDATE_DATE = '$date'
                WHERE IR_NO = '$ir_no' AND RECEIVE_DATE IS NULL");

            if(count($rowIDs) > 0){
                for ($i=0; $i<count($rowIDs); $i++){

                    DB::UPDATE(" UPDATE MIS.IT_ITEM_REQUISITION_D
                        SET RECEIVE_DATE = '$date',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$rowIDs[$i]' AND ISSUE_DATE IS NOT NULL AND RECEIVE_DATE IS NULL");

                    $cost_center = '';
                    $cwip_id = '';
                    $gl = '';
                    $main_id = '';
                    $po_number = '';
                    $pr_number = '';

                    for ($j = 0; $j < count($finalARr); $j++){
                        if($finalARr[$j]['id'] == $rowIDs[$i]){
                            $cost_center = $finalARr[$j]['cc'];
                            $cwip_id = $finalARr[$j]['cwip'];
                            $gl = $finalARr[$j]['gl'];
                            $main_id = $finalARr[$j]['main'];
                            $po_number = $finalARr[$j]['po'];
                            $pr_number = $finalARr[$j]['pr'];
                        }
                    }
                    $qry = DB::SELECT("SELECT ITEM_ID, ITEM_NAME, APRV_QTY, PR_QTY, UNIT, REMARKS 
                    FROM MIS.IT_ITEM_REQUISITION_D 
                    WHERE ID = '$rowIDs[$i]' AND ISSUE_DATE IS NOT NULL");

                    if(count($qry) > 0){
                        $item_id = $qry[0]->item_id;
                        $item_name = $qry[0]->item_name;
                        $aprv_qty = $qry[0]->aprv_qty;
                        $pr_qty = $qry[0]->pr_qty;
                        $unit = $qry[0]->unit;
                        $remarks = $qry[0]->remarks;

                        $result =  DB::insert('insert into MIS.IT_ITEM_RECEIVE_D ( IRR_NO, ITEM_ID, ITEM_NAME, CWIP_ID, MAIN_ID, PO_NUMBER, PR_NUMBER, GL,
                                   COST_CENTER, PR_QTY, APRV_QTY, UNIT, REMARKS, RECEIVE_DATE, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$new_ID, $item_id, $item_name,$cwip_id,
                            $main_id, $po_number, $pr_number, $gl, $cost_center, $pr_qty, $aprv_qty, $unit, $remarks,
                            $date, $date, $uid]);
                    }
                }
                return response()->json(['response'=>$result]);
            }else{
                return response()->json(['response'=>2]);
            }
        }
    }
    public function updateReceivedItem(Request $request){

        $uid = Auth::user()->user_id;

        $rowID = $request->rowID;
        $finalARr = $request->finalARr;
        $ir_no = $request->ir_no;
        $pr_date = Carbon::parse($request->pr_date)->format('Y-m-d');
        $plantId = Auth::user()->plant_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $status = 0;

        for ($i = 0; $i < count($finalARr); $i++){

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
        }else {
            $data = DB::SELECT("SELECT MAX(CAST(SUBSTR( IRR_NO, 9 ) AS INT)) max_id FROM MIS.IT_ITEM_RECEIVE_M");
            $max_id = $data[0]->max_id;

            if ($max_id != "") {
                $max_id++;
                $new_ID = "IRR" . $plantId . "-" . $max_id;
            } else {
                $new_ID = "IRR" . $plantId . "-1";
            }

            for ($j = 0; $j < count($finalARr); $j++) {
                if ($finalARr[$j]['id'] == $rowID) {
                    if($finalARr[$j]['recev_d_row_id'] == 0){
                        DB::insert('insert into MIS.IT_ITEM_RECEIVE_M ( IRR_NO, IR_NO, PR_DATE, COMPANY_CODE, PLANT_ID, RECEIVE_DATE, CREATE_DATE, CREATE_USER ) values (?,?,?,?,?,?,?,?)', [$new_ID, $ir_no, $pr_date, '1000', $plantId, $date, $date, $uid]);
                    }
                }
            }

            DB::UPDATE("UPDATE MIS.IT_ITEM_REQUISITION_M
                SET RECEIVE_DATE = '$date',
                    UPDATE_USER = '$uid',
                    UPDATE_DATE = '$date'
                WHERE IR_NO = '$ir_no' AND RECEIVE_DATE IS NULL");

            DB::UPDATE(" UPDATE MIS.IT_ITEM_REQUISITION_D
                SET RECEIVE_DATE = '$date',
                    UPDATE_USER = '$uid',
                    UPDATE_DATE = '$date'
                WHERE ID = '$rowID' AND ISSUE_DATE IS NOT NULL AND RECEIVE_DATE IS NULL");

            $cost_center = '';
            $cwip_id = '';
            $gl = '';
            $main_id = '';
            $po_number = '';
            $pr_number = '';
            $receivable_qty = 0;

            for ($j = 0; $j < count($finalARr); $j++) {
                if ($finalARr[$j]['id'] == $rowID) {
                    $cost_center = $finalARr[$j]['cc'];
                    $cwip_id = $finalARr[$j]['cwip'];
                    $gl = $finalARr[$j]['gl'];
                    $main_id = $finalARr[$j]['main'];
                    $po_number = $finalARr[$j]['po'];
                    $pr_number = $finalARr[$j]['pr'];
                    $receivable_qty = $finalARr[$j]['receivable_qty'];
                }
            }
            $qry = DB::SELECT("SELECT ITEM_ID, ITEM_NAME, ISSU_QTY, PEN_QTY, UNIT, REMARKS 
            FROM MIS.IT_ITEM_REQUISITION_D 
            WHERE ID = '$rowID' AND ISSUE_DATE IS NOT NULL");

            if (count($qry) > 0) {
                $item_id = $qry[0]->item_id;
                $item_name = $qry[0]->item_name;
                $issu_qty = $qry[0]->issu_qty;
                $pen_qty = $qry[0]->pen_qty;
                $unit = $qry[0]->unit;
                $remarks = $qry[0]->remarks;

                for ($j = 0; $j < count($finalARr); $j++) {
                    if ($finalARr[$j]['id'] == $rowID) {
                        if($finalARr[$j]['recev_d_row_id'] == 0){

                            $result = DB::insert('insert into MIS.IT_ITEM_RECEIVE_D ( IRR_NO, ITEM_ID, ITEM_NAME, CWIP_ID, MAIN_ID, PO_NUMBER, PR_NUMBER, GL,COST_CENTER, ISSU_QTY, RECEV_QTY, PEN_QTY, UNIT, REMARKS, RECEIVE_DATE, CREATE_DATE, CREATE_USER ) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$new_ID, $item_id, $item_name, $cwip_id, $main_id, $po_number, $pr_number, $gl, $cost_center, $issu_qty, $issu_qty,$pen_qty, $unit, $remarks,$date, $date, $uid]);

                            DB::insert('insert into MIS.IT_ITEM_RECEIVE_LOG ( IRR_NO, ITEM_ID, RECEV_QTY,CREATE_DATE, CREATE_USER )
                       values (?,?,?,?,?)', [$new_ID, $item_id, $receivable_qty, $date, $uid]);

                        }else{
                            $recevD_ID = $finalARr[$j]['recev_d_row_id'];
                            $result = DB::UPDATE("UPDATE MIS.IT_ITEM_RECEIVE_D
                            SET ISSU_QTY = '$issu_qty',RECEV_QTY = '$issu_qty',PEN_QTY = '$pen_qty',UPDATE_USER = '$uid', UPDATE_DATE = '$date' WHERE ID = '$recevD_ID'");

                            $qry2_2 = DB::SELECT("SELECT IRR_NO FROM MIS.IT_ITEM_RECEIVE_D WHERE ID = '$recevD_ID'");

                            DB::insert('insert into MIS.IT_ITEM_RECEIVE_LOG ( IRR_NO, ITEM_ID, RECEV_QTY,CREATE_DATE, CREATE_USER )
                       values (?,?,?,?,?)', [$qry2_2[0]->irr_no, $item_id, $receivable_qty, $date, $uid]);
                        }
                    }
                }
            }
            return response()->json(['response' => $result,'row_id'=>$rowID]);
        }
    }
}
