<?php

namespace App\Http\Controllers\ImportManagement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MaterialPurchaseReportController extends Controller
{
    public function index(){
        $poData = DB::select('SELECT distinct ID,PO_NUM from SCM_MATERIAL_PURCHASE_INFO WHERE PO_NUM IS NOT NULL ORDER BY PO_NUM');
        $prData = DB::select('SELECT distinct ID,PR_NUM from SCM_MATERIAL_PURCHASE_INFO WHERE PR_NUM IS NOT NULL ORDER BY PR_NUM');

        return view('import_portal.mat_purchase_report',compact('poData','prData'));
    }
    public function getSCMpurchaseMatReport(Request $request){
        $po_num = $request->po_num;
        $type_of_doc = $request->type_of_doc;
        $pr_num = $request->pr_num;
        $lc_num = $request->lc_num;
        $note_sheet_receiving_date = $request->note_sheet_receiving_date;

        $qry = "SELECT * FROM MIS.SCM_MATERIAL_PURCHASE_INFO WHERE";

        if($po_num != null){
            $qry .= " PO_NUM = decode('$po_num','ALL',PO_NUM,'$po_num') AND";
        }
        if($type_of_doc != null){
            $qry .= " TYPE_OF_DOC = decode('$type_of_doc','ALL',TYPE_OF_DOC,'$type_of_doc') AND";
        }
        if($pr_num != null){
            $qry .= " PR_NUM = decode('$pr_num','ALL',PR_NUM,'$pr_num') AND";
        }
        if($lc_num != ""){
            $qry .= " LC_NUM = '$lc_num' AND";
        }
        if($note_sheet_receiving_date != ""){
            $receiving_date = Carbon::parse($note_sheet_receiving_date)->format('Y-m-d H:i:s');
            $qry .= " NOTE_SHEET_RECEIVING_DATE = '$receiving_date' AND";
        }

        $qryArr = explode(" ",$qry);
        if($qryArr[count($qryArr)-1] == "AND"){
            array_pop($qryArr);
        }

        $newqry = implode(" ",$qryArr);

        $qryRes = DB::SELECT($newqry);

        return response()->json(['result'=>$qryRes,'qry'=>$qry]);
    }
    public function updatePIReqSendDate(Request $request){
        $PIReqSendDate = Carbon::parse(trim($request->value))->format('Y-m-d');
        $rowID = $request->rowID;
        try {
            $data = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set PI_REQ_SEND_DATE = ? where ID = ?", [$PIReqSendDate,$rowID]);

            return response()->json(['status'=>$data]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function updateFinalpireceiveddate(Request $request){
        $Finalpireceiveddate = Carbon::parse(trim($request->value))->format('Y-m-d');
        $rowID = $request->rowID;
        try {
            $data = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set FINAL_PI_RECEIVED_DATE = ? where ID = ?", [$Finalpireceiveddate,$rowID]);

            return response()->json(['status'=>$data]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function updateReqforopenlcttcaddate(Request $request){
        $val = Carbon::parse(trim($request->value))->format('Y-m-d');
        $rowID = $request->rowID;
        try {
            $data = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set REQ_FOR_OPEN_LC_TT_CAD_DATE = ? where ID = ?", [$val,$rowID]);
            return response()->json(['status'=>$data]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function updateDraftShipDocRcvDate(Request $request){
        $val = Carbon::parse(trim($request->value))->format('Y-m-d');
        $rowID = $request->rowID;
        try {
            $data = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set DRAFT_SHIP_DOC_RCV_DATE = ? where ID = ?", [$val,$rowID]);
            return response()->json(['status'=>$data]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function updateFinalShipDocRcvDate(Request $request){
        $val = Carbon::parse(trim($request->value))->format('Y-m-d');
        $rowID = $request->rowID;
        try {
            $data = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set FINAL_SHIP_DOC_RCV_DATE = ? where ID = ?", [$val,$rowID]);
            return response()->json(['status'=>$data]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function updateSendForEndorsemntDate(Request $request){
        $val = Carbon::parse(trim($request->value))->format('Y-m-d');
        $rowID = $request->rowID;
        try {
            $data = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set SEND_FOR_ENDORSEMNT_DATE = ? where ID = ?", [$val,$rowID]);
            return response()->json(['status'=>$data]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function updateLcOpenStatus(Request $request){
        $lc_num = $request->lc_num;
        $val = $request->value;
        $rowID = $request->rowID;
        try {
            $data = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set LC_OPEN_STATUS = ?, LC_NUM = ? where ID = ?",
                [$val,$lc_num,$rowID]);
            return response()->json(['status'=>$data]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
}
