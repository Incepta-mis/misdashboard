<?php

namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index(){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        return view('stationery.itemcat', ['catData' => $catData]);
    }
    public function itemTypes(){
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        return view('stationery.itemTypes', ['types'=>$types]);
    }

    public function getItems(){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        return view('stationery.items', ['types'=>$types,'cats'=>$catData]);
    }

    public function getCategory(Request $request){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY
        WHERE ICAT_NO = decode ('$request->cat_no','All',ICAT_NO,'$request->cat_no')");
        return response()->json($catData);
    }

    public function stockReport(){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");

        return view('stationery.stockReport', ['items'=>$itemData,'cats'=>$catData,'types'=>$types,
            'plantId'=>$plantId,'uid'=>$uid,'allPlants'=>$allPlants,'costCenter'=>$costCenter,'units'=>$units]);
    }

    public function getStockReport(Request $request){
        $plantId = $request->plant_id;
        $item_id = $request->item_id;

        DB::setDateFormat("DD-MM-RR");

        $QRY = "SELECT * FROM MIS.IT_OPENING_STOCK
        WHERE COMPANY_CODE = '1000' AND PLANT_ID = decode ('$plantId','All',PLANT_ID,'$plantId')";

        if($item_id != "") {
            $QRY .= "AND ITEM_ID = decode ('$item_id','All',ITEM_ID,'$item_id') ";
        }

        $stockData = DB::select($QRY);
        return response()->json($stockData);
    }

    public function openingStock(){
        $plant_id = Auth::user()->plant_id;
        $companyData = DB::select("select distinct com_id,com_name,sap_com_id from hrms.company_info@WEB_TO_HRMS  WHERE sap_com_id = '1000' order by com_id ");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plant_id' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");

        $stckData = DB::select("SELECT * FROM MIS.IT_OPENING_STOCK");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");
        return view('stationery.openingStock', ['stckData'=>$stckData,'companyData' => $companyData,
            'plant_id'=>$plant_id,'item_data'=>$itemData,'costCenter'=>$costCenter,'units'=>$units]);
    }
    public function downloadFile(){
        $file = storage_path("app\public\sample_files\openingStockReport.xlsx");
        return response()->download($file);
    }
    public function uploadStockData()
    {
        $uid = Auth::user()->user_id;
        $file_name = Input::file('upload_file');
        $date = Carbon::now()->format('Y-m-d H:m:s');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if ($validator_empty->fails()) {
            $notification = array(
                'message' => 'Please upload a file!',
                'alert-type' => 'error'
            );
            return Redirect::to('stationery/form/openingStock')->withErrors($validator_empty)->with($notification);
        }else if ($validator_empty->passes()) {
            $ext = strtolower($file_name->getClientOriginalExtension());
            $validator = Validator::make(
                array('ext' => $ext),
                array('ext' => 'in:xls,xlsx')
            );
            if ($validator->fails()) {
                $notification = array(
                    'message' => 'Please Upload excel file!',
                    'alert-type' => 'error'
                );
                return Redirect::to('stationery/form/openingStock')->withErrors($validator)->with($notification);
            } else if ($validator->passes()) {
                $data = Excel::load($file_name, function ($reader) {})->get();
                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {
                        $uniqueData[] = [
                            'plant_id' => trim($value->plant_id),
                            'item_id' => trim($value->item_id)
                        ];
                        $insert[] = [
                            'company_code' => '1000',
                            'plant_id' => trim($value->plant_id),
                            'main_id' => trim($value->main_id),
                            'cwip_id' => trim($value->cwip_id),
                            'po_number' => trim($value->po_number),
                            'pr_number' => trim($value->pr_number),
                            'gl' => trim($value->gl),
                            'cost_center' => trim($value->cost_center),
                            'item_id' => trim($value->item_id),
                            'item_name' => trim($value->item_name),
                            'opening_quantity' => trim($value->opening_quantity),
                            'unit' => trim($value->unit),
                            'received_date' => Carbon::parse(trim($value->received_date))->format('Y-m-d'),
                            'create_user' => $uid,
                            'cretae_date' => $date
                        ];
                    }
                    if (!empty($insert)) {
                        $count = count($insert);
                        $unique = array_map("unserialize", array_unique(array_map("serialize", $uniqueData)));
                        if($count > count($unique)){
                            $notification = array(
                                'message' => 'Duplicate data found in the excel file! Plant ID and item ID cannot be same in multiple rows.',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('stationery/form/openingStock')->with($notification);
                        }else{
                            try {
                                $missingItem = [];

                                foreach ($insert as $k => $row) {
                                    $item_id = $row['item_id'];

                                    $qryData = DB::SELECT("SELECT * FROM MIS.IT_ITEM_MASTER WHERE ITEM_ID = '$item_id'");

                                    if(count($qryData) == 0){
                                        $temp = array();
                                        $temp['plant_id'] = $row['plant_id'];
                                        $temp['main_id'] = $row['main_id'];
                                        $temp['cwip_id'] = $row['cwip_id'];
                                        $temp['po_number'] = $row['po_number'];
                                        $temp['pr_number'] = $row['pr_number'];
                                        $temp['gl'] = $row['gl'];
                                        $temp['cost_center'] = $row['cost_center'];
                                        $temp['item_id'] = $row['item_id'];
                                        $temp['item_name'] = $row['item_name'];
                                        $temp['opening_quantity'] = $row['opening_quantity'];
                                        $temp['unit'] = $row['unit'];
                                        $temp['received_date'] = $row['received_date'];
                                        array_push($missingItem,$temp);
                                    }
                                }
                                if(count($missingItem) > 0){
                                    $notification = array(
                                        'message' => "Data could not be uploaded! Items weren't found in the database!",
                                        'alert-type' => 'error',
                                        'missingItem' => json_encode($missingItem)
                                    );
                                    return Redirect::to('stationery/form/openingStock')->with($notification);
                                }

                                $dup = array();
                                foreach ($insert as $k => $row) {
                                    $plant_id = $row['plant_id'];
                                    $item_id = $row['item_id'];

                                    $unqData = DB::SELECT("SELECT * FROM MIS.IT_OPENING_STOCK WHERE PLANT_ID = '$plant_id' AND ITEM_ID = '$item_id'");
                                    if(count($unqData) > 0){
                                        $temp = array();
                                        $temp['plant_id'] = $row['plant_id'];
                                        $temp['main_id'] = $row['main_id'];
                                        $temp['cwip_id'] = $row['cwip_id'];
                                        $temp['po_number'] = $row['po_number'];
                                        $temp['pr_number'] = $row['pr_number'];
                                        $temp['gl'] = $row['gl'];
                                        $temp['cost_center'] = $row['cost_center'];
                                        $temp['item_id'] = $row['item_id'];
                                        $temp['item_name'] = $row['item_name'];
                                        $temp['opening_quantity'] = $row['opening_quantity'];
                                        $temp['unit'] = $row['unit'];
                                        $temp['received_date'] = $row['received_date'];
                                        array_push($dup,$temp);
                                    }
                                }
                                if(count($dup) > 0){
                                    $notification = array(
                                        'message' => "Data could not be uploaded! Duplicate data found in the database!",
                                        'alert-type' => 'error',
                                        'dup_data' => json_encode($dup)
                                    );
                                }else{
                                    foreach ($insert as $k => $row) {
                                        DB::insert('insert into MIS.IT_OPENING_STOCK ( COMPANY_CODE, PLANT_ID, MAIN_ID, CWIP_ID, PO_NUMBER, PR_NUMBER, GL, COST_CENTER, ITEM_ID, ITEM_NAME, OPENING_QTY, UNIT, RECEIVED_DATE, CREATE_DATE, CREATE_USER ) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',['1000', $row['plant_id'], $row['main_id'], $row['cwip_id'], $row['po_number'], $row['pr_number'], $row['gl'], $row['cost_center'], $row['item_id'], $row['item_name'], $row['opening_quantity'], $row['unit'], $row['received_date'], $date, $uid]);
                                    }
                                    $notification = array(
                                        'message' => 'File Uploaded successfully! ',
                                        'alert-type' => 'success'
                                    );
                                }
                                return Redirect::to('stationery/form/openingStock')->with($notification);
                            } catch (\Exception $ee) {
                                DB::rollBack();
                                $notification = array(
                                    'message' => 'Database Error!',
                                    'alert-type' => 'error'
                                );
                                return Redirect::to('stationery/form/openingStock')->with($notification);
                            }
                        }
                    }else{
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('stationery/form/openingStock')->with($notification);
                    }
                }
            }
        }
    }
    public function getISTnames(Request $request){
        $istData = DB::select("SELECT * FROM MIS.IT_ITEM_TYPE_MASTER
        WHERE IT_ID = decode ('$request->it_id','All',IT_ID,'$request->it_id')");
        return response()->json($istData);
    }

    public function getItemGL(Request $request){
        if($request->item_id != ""){
            $glData = DB::select("SELECT IT_NAME, GL FROM MIS.IT_ITEM_MASTER WHERE ITEM_ID = '$request->item_id'");
            return response()->json($glData);
        }else{
            return "";
        }
    }

    public function getItemNames(Request $request){
        $it_id = $request->it_id;
        $ist_id = $request->ist_id;
        $icat_no = $request->icat_no;

        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER
        WHERE IT_ID = decode ('$it_id','All',IT_ID,'$it_id') AND 
              IST_ID = decode ('$ist_id','All',IST_ID,'$ist_id') AND 
              ICAT_NO = decode ('$icat_no','All',ICAT_NO,'$icat_no')
        ");

        return response()->json($itemData);
    }

    public function getTypeSubtypeData(Request $request){
        $istData = DB::select("SELECT * FROM MIS.IT_ITEM_TYPE_MASTER
        WHERE IT_ID = decode ('$request->it_id','All',IT_ID,'$request->it_id') AND IST_ID = decode ('$request->ist_id','All',IST_ID,'$request->ist_id')");
        return response()->json($istData);
    }

    public function getItemReport(Request $request){
        $it_id = $request->it_id;
        $ist_id = $request->ist_id;
        $icat_no = $request->icat_no;
        $item_id = $request->item_id;

        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER
        WHERE IT_ID = decode ('$it_id','All',IT_ID,'$it_id') AND 
              IST_ID = decode ('$ist_id','All',IST_ID,'$ist_id') AND 
              ICAT_NO = decode ('$icat_no','All',ICAT_NO,'$icat_no') AND
              ITEM_ID = decode ('$item_id','All',ITEM_ID,'$item_id')
        ");
        return response()->json($itemData);
    }

    public function editICategory(Request $request){
        $uid = Auth::user()->user_id;
        $icat_no = $request->icat_no;
        $icat_name = $request->icat_name;
        $icat_id = $request->icat_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        if($icat_no != "" && $icat_name != "" && $icat_id != ""){
            $result =  DB::UPDATE("
                        UPDATE MIS.IT_CATEGORY
                        SET ICAT_NAME = '$icat_name',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ICAT_NO = '$icat_no'");
            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function updateStockReport(Request $request){

        $uid = Auth::user()->user_id;
        $stock_id = $request->stock_id;
        $main_id = $request->main_id;
        $cwip_id = $request->cwip_id;
        $po_number = $request->po_number;
        $pr_number = $request->pr_number;
        $rdate = Carbon::parse($request->rdate)->format('Y-m-d');
        $cost_center = $request->cost_center;
        $opening_qty = $request->opening_qty;
        $unit = $request->unit;

        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($stock_id != "" && $rdate != "" && $cost_center != "" && $opening_qty != "" && $unit != ""){
            $result =  DB::UPDATE("
                        UPDATE MIS.IT_OPENING_STOCK
                        SET MAIN_ID = '$main_id',
                            CWIP_ID = '$cwip_id',
                            PO_NUMBER = '$po_number',
                            PR_NUMBER = '$pr_number',
                            COST_CENTER = '$cost_center',
                            OPENING_QTY = '$opening_qty',
                            UNIT = '$unit',
                            RECEIVED_DATE = '$rdate',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$stock_id'");

            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function editItemData(Request $request){
        $uid = Auth::user()->user_id;
        $edit_item_tbl_id = $request->edit_item_tbl_id;
        $edit_item_name = $request->edit_item_name;
        $edit_gl = $request->edit_gl;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        if($edit_item_tbl_id != "" && $edit_item_name != ""){
            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_MASTER
                        SET ITEM_NAME = '$edit_item_name',
                            GL = '$edit_gl',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$edit_item_tbl_id'");
            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function createItype(Request $request){
        $uid = Auth::user()->user_id;
        $itype_name = $request->itype_name;
        $create_istID = $request->create_istID;
        $create_istName = $request->create_istName;
        $create_gl = $request->create_gl;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        $data = DB::select("SELECT MAX(SUBSTR( IT_ID, 4 )) max_id FROM MIS.IT_ITEM_TYPE_MASTER");
        $max_id = $data[0]->max_id;

        if($max_id != ""){
            $max_id++;
            $new_it_no = "IT-".$max_id;
        }else{
            $new_it_no = "IT-1";
        }
        if($itype_name != ""){
            $result =  DB::insert('insert into MIS.IT_ITEM_TYPE_MASTER ( IT_ID, IT_NAME, IST_ID, IST_NAME, GL, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?)',[$new_it_no, $itype_name, $create_istID, $create_istName, $create_gl, $date, $uid]);
            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function insertStockData(Request $request){
        $uid = Auth::user()->user_id;
        $com_code = $request->com_code;
        $plant_id = $request->plant_id;
        $main_id = $request->main_id;
        $cwip_id = $request->cwip_id;
        $po_number = $request->po_number;
        $pr_number = $request->pr_number;
        $rdate = Carbon::parse($request->rdate)->format('Y-m-d');
        $cost_center = $request->cost_center;
        $item_id = $request->item_id;
        $item_name = $request->item_name;
        $oqty = $request->oqty;
        $unit = $request->unit;
        $gl = $request->gl;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($com_code != "" && $plant_id != "" && $rdate != "" && $item_id != "" && $item_name != "" && $oqty != "" && $unit != ""){
            $result =  DB::insert('insert into MIS.IT_OPENING_STOCK ( COMPANY_CODE, PLANT_ID, MAIN_ID, CWIP_ID, PO_NUMBER, PR_NUMBER, GL, COST_CENTER,
                                  ITEM_ID, ITEM_NAME, OPENING_QTY, UNIT, RECEIVED_DATE, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$com_code, $plant_id, $main_id, $cwip_id, $po_number, $pr_number, $gl, $cost_center, $item_id, $item_name, $oqty, $unit, $rdate, $date, $uid]);
            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function createItem(Request $request){
        $uid = Auth::user()->user_id;
        $itype_id = $request->itype_id;
        $itype_name = $request->itype_name;
        $istID = $request->istID;
        $istName = $request->istName;
        $icatNo = $request->icatNo;
        $icatName = $request->icatName;
        $itemName = $request->itemName;
        $gl = $request->gl;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        $data = DB::select("SELECT MAX(SUBSTR( ITEM_ID, 5 )) max_id FROM MIS.IT_ITEM_MASTER");
        $max_id = $data[0]->max_id;

        if($max_id != ""){
            $max_id++;
            $new_item_id = "ITM-".$max_id;
        }else{
            $new_item_id = "ITM-1";
        }
        if($itype_name != ""){
            $result =  DB::insert('insert into MIS.IT_ITEM_MASTER ( IT_ID, IT_NAME, IST_ID, IST_NAME, ICAT_NO, ICAT_NAME, ITEM_ID, ITEM_NAME, GL, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?,?,?,?,?)',[$itype_id, $itype_name, $istID, $istName, $icatNo,
                $icatName, $new_item_id, $itemName,$gl, $date, $uid]);
            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function createISubtype(Request $request){
        $uid = Auth::user()->user_id;
        $create_oitID = $request->create_oitID;
        $create_oitName = $request->create_oitName;
        $create_oistID = $request->create_oistID;
        $create_oistName = $request->create_oistName;
        $create_ogl = $request->create_ogl;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($create_oitID != "" || $create_oitName != "" || $create_oistName != ""){

            if($create_oitName == "STATIONERY"){
                $data = DB::select("SELECT MAX(IST_ID) max_id FROM MIS.IT_ITEM_TYPE_MASTER WHERE IT_NAME = 'STATIONERY'");
                $max_id = $data[0]->max_id;

                if($max_id != ""){
                    $max_id++;
                    $new_ist_no = $max_id;
                }else{
                    $new_ist_no = 1;
                }
                $result =  DB::insert('insert into MIS.IT_ITEM_TYPE_MASTER ( IT_ID, IT_NAME, IST_ID, IST_NAME, GL, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?)',[$create_oitID, $create_oitName, $new_ist_no, $create_oistName, $create_ogl, $date, $uid]);
            }else{
                $result =  DB::insert('insert into MIS.IT_ITEM_TYPE_MASTER ( IT_ID, IT_NAME, IST_ID, IST_NAME, GL, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?,?,?,?)',[$create_oitID, $create_oitName, $create_oistID, $create_oistName, $create_ogl, $date, $uid]);
            }
            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function editTypeSubtypeData(Request $request){
        $uid = Auth::user()->user_id;
        $edit_it_ID = $request->edit_it_ID;
        $edit_ist_id = $request->edit_ist_id;
        $edit_ist_name = $request->edit_ist_name;
        $edit_gl = $request->edit_gl;
        $edit_it_name = $request->edit_it_name;
        $row_ID = $request->row_ID;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($edit_it_ID != "" && $edit_ist_id != "" && $edit_ist_name != "" && $edit_it_name != "" && $row_ID != ""){
            if($edit_it_name === "CAPEX"){
                $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_TYPE_MASTER
                        SET IST_NAME = '$edit_ist_name',
                            IST_ID = '$edit_ist_id',
                            GL = '$edit_gl',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$row_ID'");
            }else{
                $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_TYPE_MASTER
                        SET IST_NAME = '$edit_ist_name',
                            GL = '$edit_gl',
                            UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$row_ID' AND IT_ID = '$edit_it_ID' AND IST_ID = '$edit_ist_id'");
            }

            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function deleteICategory(Request $request){
        $icat_no = $request->icat_no;
        $icat_name = $request->icat_name;

        if($icat_no != "" && $icat_name != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_CATEGORY WHERE ICAT_NO = ? AND ICAT_NAME = ?',[$icat_no,$icat_name]);
            return response()->json(['result'=> $result]);
        }else{
            return response()->json(['result'=> 2]);
        }
    }
    public function deleteStockData(Request $request){
        $stock_id = $request->stock_id;
        if($stock_id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_OPENING_STOCK WHERE ID = ?',[$stock_id]);
            return response()->json(['result'=> $result]);
        }else{
            return response()->json(['result'=> 2]);
        }
    }
    public function deleteItem(Request $request){
        $id = $request->id;

        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_MASTER WHERE ID = ?',[$id]);
            return response()->json(['result'=> $result]);
        }else{
            return response()->json(['result'=> 2]);
        }
    }
    public function deleteItypeSubtype(Request $request){
        $id = $request->id;
        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_TYPE_MASTER WHERE ID = ?',[$id]);
            return response()->json(['result'=> $result]);
        }else{
            return response()->json(['result'=> 2]);
        }
    }
    public function createIcategory(Request $request){
        $uid = Auth::user()->user_id;
        $icat_name = $request->icat_name;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $data = DB::select("SELECT MAX(SUBSTR( ICAT_NO, 5 )) max_id FROM MIS.IT_CATEGORY");
        $max_id = $data[0]->max_id;

        if($max_id != ""){
            $max_id++;
            $new_icat_no = "ICT-".$max_id;
        }else{
            $new_icat_no = "ICT-1";
        }
        if($icat_name != ""){
            $result =  DB::insert('insert into MIS.IT_CATEGORY ( ICAT_NO, ICAT_NAME, CREATE_DATE, CREATE_USER )
                               values (?,?,?,?)',[$new_icat_no, $icat_name, $date, $uid]);
            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }

    /* sayla starts*/
    public function getProductQty(Request $request){
        $item_id = $request->item_id;   $uid = Auth::user()->user_id;

        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;

        $item_qty = DB::select("SELECT QTY
                        FROM MIS.IT_ITEM_STOCK WHERE ITEM_ID = '$item_id' AND PLANT_ID='$plant_id'");
        if($item_qty){
            return response()->json(['result'=> $item_qty[0]->qty]);
        }else{
            return response()->json(['result'=> 0]);
        }

    }
    

    public function getItemName(Request $request){

        $it_name = $request->it_name;
        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,IT_ID,GL FROM MIS.IT_ITEM_MASTER WHERE IT_NAME = '$it_name'");

        if($item_name){
            return response()->json(['result'=>$item_name]);

        }else{
            return response()->json(['result'=>$item_name]);
        }
    }

    public function issueQtyItem(Request $request){

        $table_id = $request->id;
        $approve_qty = $request->aprv_qty;
        $issu_qty = $request->issu_qty;
        $ir_no = $request->ir_no;
        $item_id = $request->item_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $uid = Auth::user()->user_id;

        $pen_qty = abs($approve_qty-$issu_qty);

        if($approve_qty!=''||$approve_qty!=''){
            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_D 
                        SET
                            APRV_QTY = '$approve_qty',
                            ISSU_QTY = '$issu_qty',
                            PEN_QTY = '$pen_qty',
                            ISSUE_DATE = '$date'
                          
                           
                        WHERE ID = '$table_id'");

            if($result){
                $log_issue['IR_NO']= $ir_no;
                $log_issue['ITEM_ID']= $item_id;
                $log_issue['ISSU_QTY']= $issu_qty;
                $log_issue['CREATE_DATE']= $date;
                $log_issue['CREATE_USER']= $uid;

                $log_result =  DB::table('MIS.IT_ITEM_REQUISITION_LOG')->insert($log_issue);

                if($log_result){
                    return response()->json(['result'=> "success"]);

                }else{
                    return response()->json(['result'=> "error"]);
                }

            }
            return response()->json(['result'=> "error"]);

        }else{

            return response()->json(['result'=> "error"]);

        }
    }
    
    public function approveQtyItem(Request $request){
        $table_id = $request->id;
        $approve_qty = $request->aprv_qty;
        $req_qty = $request->req_qty;

        if($approve_qty!=''||$approve_qty!=''){

            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_D 
                        SET
                            APRV_QTY = '$approve_qty',
                            REQ_QTY = '$req_qty'
                           
                        WHERE ID = '$table_id'");


            return response()->json(['result'=> "success"]);

        }else{

            return response()->json(['result'=> "error"]);

        }
    }
    
    public function issueItem(){

        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;

        $cost_center_id_name = DB::select("Select COST_CENTER_NAME,COST_CENTER_ID from MIS.IT_COST_CENTER where PLANT_ID='$plant_id'");

        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $it_name = DB::select("SELECT DISTINCT IT_NAME FROM MIS.IT_ITEM_MASTER");

        return view('stationery.issue_item', ['item_name'=>$item_name,'cost_center_id_name'=>$cost_center_id_name,'it_name'=>$it_name]);

    }

    
    public function updateIssueImg(Request $request){
        $new_ir_no=$request->ir_no;


        //file upload assentials
        $upload_path='';
        $upload_location = public_path('stationary/itemRequisition');
        $errors=[];
        $success=[];
        if(isset($_FILES['file'])){

            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];

            $extensions = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $valid_ext = array("jpg","png","jpeg");
            if(in_array($extensions,$valid_ext)=== false){
                $errors["error"]="ext_error";
                return response()->json($errors);
            }

            if(empty($errors)==true){
                $fineName = basename($file_name);
                $fulFileName =rand(10,10000)."_".$new_ir_no."_".$fineName;
                $fullPath ="$upload_location/$fulFileName";
                $upload_path = 'stationary/itemRequisition/'.$fulFileName;
                move_uploaded_file($file_tmp,$fullPath );


                $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_M 
                        SET
                            IMAGE_PATH = '$upload_path'
                            
                           
                        WHERE  IR_NO = '$new_ir_no'");


                if($request){
                     $success["success"]="success";
                     return response()->json($success);
                 }else{
                     $errors["error"]="error";
                     return response()->json($errors);
                 }

            }
        }
    }
  
    public function displayIssueItem(Request $request){

        try {

            $item_details = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL,COST_CENTER,PR_NUMBER,UNIT  FROM MIS.IT_OPENING_STOCK where ITEM_ID='$request->item_id_search'");

            if($item_details){
                return response()->json($item_details);
            }else{
                return response()->json('error');
            }

        }
        catch (customException $e) {
            echo $e->errorMessage();
        }

    }
    /*public function createIssue(Request $request){

        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;


        $data = DB::select("SELECT MAX(CAST(SUBSTR( IR_NO, 8 ) AS INT)) max_id FROM MIS.IT_ITEM_REQUISITION_M");
        $max_id = $data[0]->max_id;
        $max_idd = (int)$max_id;

        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($max_id!=''){
            $max_idd++;
            $new_ir_no = "IR".$plant_id.'-'.$max_idd;
        }else{
            $new_ir_no = "IR".$plant_id.'-1';
        }

        $issueItemData = json_decode($request->issueItemData, true);

        for($i=0;$i<sizeof($issueItemData);$i++){
               $issueItemData[$i]['IR_NO']= $new_ir_no;
               $issueItemData[$i]['CREATE_USER']= Auth::user()->user_id;
               $issueItemData[$i]['CREATE_DATE']= $date;
               $issueItemData[$i]['RECEIVE_DATE']= '';
               $issueItemData[$i]['APPROVED_DATE']= '';

        }

        $issueItemMaster['IR_NO']= $new_ir_no;
        $issueItemMaster['PR_DATE']= $date;
        $issueItemMaster['COMPANY_CODE']= '2000';
        $issueItemMaster['PLANT_ID']= $plant_id;
        $issueItemMaster['CREATE_USER']= Auth::user()->user_id;
        $issueItemMaster['CREATE_DATE']= $date;
        $issueItemMaster['RECEIVE_DATE']= '';
        $issueItemMaster['APPROVED_DATE']= '';

        $status = DB::table('MIS.IT_ITEM_REQUISITION_M')->insert($issueItemMaster);
        if($status){
                for($i=0;$i<sizeof($issueItemData);$i++){
                    $issueItemData[$i]['IR_NO']= $new_ir_no;
                    $issueItemData[$i]['PEN_QTY']= $issueItemData[$i]['req_qty'];
                    $issueItemData[$i]['CREATE_USER']= Auth::user()->user_id;
                    $issueItemData[$i]['CREATE_DATE']= $date;
                    $issueItemData[$i]['RECEIVE_DATE']= '';
                    $issueItemData[$i]['APPROVED_DATE']= '';

                }
                $status = DB::table('MIS.IT_ITEM_REQUISITION_D')->insert($issueItemData);
                if($status){
                    return response()->json("success");
                }else{
                    return response()->json("error");
                }
            }else{
            return response()->json("error");
        }

    }*/
  
    public function createIssue(Request $request){


        $itemdata = $request->data;

        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;


        $data = DB::select("SELECT MAX(CAST(SUBSTR( IR_NO, 8 ) AS INT)) max_id FROM MIS.IT_ITEM_REQUISITION_M");
        $max_id = $data[0]->max_id;
        $max_idd = (int)$max_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($max_id!=''){
            $max_idd++;
            $new_ir_no = "IR".$plant_id.'-'.$max_idd;
        }else{
            $new_ir_no = "IR".$plant_id.'-1';
        }

        //file upload assentials
        $upload_path='';
        $upload_location = public_path('stationary/itemRequisition');
        $errors=[];
        $success=[];
        if(isset($_FILES['file'])){

            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];

            $extensions = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $valid_ext = array("jpg","png","jpeg");
            if(in_array($extensions,$valid_ext)=== false){
                $errors["error"]="ext_error";
                return response()->json($errors);
            }

            if(empty($errors)==true){
                $fineName = basename($file_name);
                $fulFileName =rand(10,10000)."_".$new_ir_no."_".$fineName;
                $fullPath ="$upload_location/$fulFileName";
                $upload_path = 'stationary/itemRequisition/'.$fulFileName;
                move_uploaded_file($file_tmp,$fullPath );

            }

        }


        $issueItemData = json_decode($itemdata, true);
        for($i=0;$i<sizeof($issueItemData);$i++){
            $issueItemData[$i]['IR_NO']= $new_ir_no;
            $issueItemData[$i]['CREATE_USER']= Auth::user()->user_id;
            $issueItemData[$i]['CREATE_DATE']= $date;
            $issueItemData[$i]['RECEIVE_DATE']= '';
            $issueItemData[$i]['APPROVED_DATE']= '';
        }

        $issueItemMaster['IR_NO']= $new_ir_no;
        $issueItemMaster['PR_DATE']= $date;
        $issueItemMaster['COMPANY_CODE']= '2000';
        $issueItemMaster['PLANT_ID']= $plant_id;
        $issueItemMaster['IMAGE_PATH']= $upload_path;
        $issueItemMaster['CREATE_USER']= Auth::user()->user_id;
        $issueItemMaster['CREATE_DATE']= $date;
        $issueItemMaster['RECEIVE_DATE']= '';
        $issueItemMaster['APPROVED_DATE']= '';

        $status = DB::table('MIS.IT_ITEM_REQUISITION_M')->insert($issueItemMaster);
        if($status){
            for($i=0;$i<sizeof($issueItemData);$i++){
                $issueItemData[$i]['IR_NO']= $new_ir_no;
                $issueItemData[$i]['PEN_QTY']= $issueItemData[$i]['req_qty'];
                $issueItemData[$i]['CREATE_USER']= Auth::user()->user_id;
                $issueItemData[$i]['CREATE_DATE']= $date;
                $issueItemData[$i]['RECEIVE_DATE']= '';
                $issueItemData[$i]['APPROVED_DATE']= '';

            }
            $status = DB::table('MIS.IT_ITEM_REQUISITION_D')->insert($issueItemData);
            if($status){
                $success["success"]="success";
                return response()->json($success);
            }else{
                $errors["error"]="error";
                return response()->json($errors);
            }
        }else{
            $errors["error"]="error";
            return response()->json($errors);
        }

    }
    
    public function showMyIssue(){
        $uid = Auth::user()->user_id;

        $issue_year = DB::select(" select distinct EXTRACT(YEAR FROM Create_date) leave_year from MIS.IT_ITEM_REQUISITION_M where  CREATE_USER='$uid' ");

        return view('stationery.display_my_issue', ['appData' => $issue_year]);
    }
    
    public function getMyIssues(Request $request){
        $user_id = Auth::user()->user_id;
        $req_year = $request->req_year;

        if($req_year=='all'){
            $issue_year = DB::select(" select ID,IR_NO,ITEM_ID,ITEM_NAME,GL,COST_CENTER,PR_QTY,APRV_QTY,UNIT,REMARKS,APRV_QTY,APPROVED_DATE from MIS.IT_ITEM_REQUISITION_D 
            where create_user = '$user_id' order by  IR_NO");

        }else{
            $issue_year = DB::select(" select ID,IR_NO,ITEM_ID,ITEM_NAME,GL,COST_CENTER,PR_QTY,APRV_QTY,UNIT,REMARKS,APRV_QTY,APPROVED_DATE from MIS.IT_ITEM_REQUISITION_D where 
            EXTRACT(YEAR FROM Create_date) = '$req_year' and create_user = '$user_id' order by  IR_NO");
        }

        return response()->json($issue_year);

    }
 
    public function deleteMyIssue(Request $request){

            $id = $request->id;
            $ir_no = $request->ir_no;

            if($id != ""){
                $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_REQUISITION_D WHERE ID = ?',[$id]);
                if($result){

                    $result =  DB::SELECT('select ir_no FROM MIS.IT_ITEM_REQUISITION_D WHERE IR_NO = ?',[$ir_no]);
                    if($result){
                        return response()->json(['result'=> 'true']);
                    }else{
                        $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_REQUISITION_M WHERE IR_NO = ?',[$ir_no]);
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
  
    public function getIssuedItem(){
        $user_id = Auth::user()->user_id;
        if(Auth::user()->user_id == 'IPLCDM1050'){
            $ir_no = DB::SELECT("Select distinct IR_NO from MIS.IT_ITEM_REQUISITION_D");
        }else{

            $ir_no = DB::SELECT("Select DISTINCT ir_no from  MIS.IT_ITEM_REQUISITION_D WHERE APPROVED_DATE IS NULL AND CREATE_USER ='$user_id'");

        }

        if($ir_no){
            return response()->json($ir_no);
        }else{
            return response()->json("error");
        }
    }
   
    public function updateIssuedItem(Request $request){


        $table_id = $request->id;

        $decoded_data = json_decode($request->itemArray);


        $edit_ir_no = $decoded_data->edit_ir_no;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_gl = $decoded_data->edit_gl;
        $edit_cost_center = $decoded_data->edit_cost_center;
        $edit_pr_qty = $decoded_data->edit_pr_qty;
        $unit = $decoded_data->edit_unit;
        $remarks = $decoded_data->edit_remarks;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


       // return response()->json("hhwllo update");


        if($edit_ir_no!=''){

            //return response()->json("hhwllo update");

            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_D
                        SET
                            ITEM_ID = '$edit_item_id',
                            ITEM_NAME = '$edit_item_name',
                            GL = '$edit_gl',
                            COST_CENTER = '$edit_cost_center',
                            REQ_QTY = '$edit_pr_qty',
                            UNIT = '$unit',
                            REMARKS = '$remarks',
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$table_id'");


            return response()->json(['result'=> "success"]);

        }else{

            return response()->json(['result'=> "error"]);

        }

    }
    
    public function showIrdata(Request $request){
        $issuedItems= DB::SELECT("Select * from MIS.IT_ITEM_REQUISITION_D where ir_no = '$request->ir_no'");
        $image_path= DB::SELECT("Select IMAGE_PATH from MIS.IT_ITEM_REQUISITION_M where ir_no = '$request->ir_no'");
        return response()->json(['issuedItems'=>$issuedItems,'image_path'=>$image_path]);

    }
    /*Issue Item sayla ends*/

    /*Item transfer starts*/
    public function transferItem(){
        $uid= Auth::user()->user_id;
        $item_name = DB::SELECT("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $plant_id = Auth::user()->plant_id;

        $transItems = DB::SELECT("SELECT DISTINCT a.ITR_NO, b.id FROM IT_ITEM_TRANSFER_RECEIVE_M a 
        INNER JOIN IT_ITEM_TRANSFER_D b ON a.TRANSFER_ID = b.ID 
        INNER JOIN IT_ITEM_TRANSFER_M d ON a.IT_NO = d.IT_NO 
        INNER JOIN IT_ITEM_TRANSFER_RECEIVE_D c ON c.ITEM_ID = b.ITEM_ID 
        WHERE b.RECEIVE_DATE IS NOT NULL AND a.CREATE_USER = 'IPLCDM1050' AND b.UPDATE_USER = 'IPLCDM1050' AND d.PLANT_TO = '$plant_id' AND b.id NOT IN (SELECT REF_ID FROM MIS.IT_ITEM_TRANSFER_D WHERE REF_ID IS NOT NULL)");

        $plant = DB::select("select distinct plant_id,plant_name 
                            from hrms.plant_info@WEB_TO_HRMS
                            where com_id = 1 order by plant_id");

        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plant_id' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");

        return view('stationery.item_transfer', ['costCenter'=>$costCenter,'item_name'=>$item_name,'uid'=>$uid,
            'transItems'=>$transItems,'plant_id'=>$plant_id,'plants'=>$plant]);
    }


    public function getIt_no(Request $request){
        $itr_no = $request->itr_no;
        $data = DB::SELECT("SELECT a.IT_NO FROM IT_ITEM_TRANSFER_RECEIVE_M a INNER JOIN IT_ITEM_TRANSFER_D b ON a.IT_NO = b.IT_NO WHERE a.CREATE_USER = 'IPLCDM1050' AND a.ITR_NO = '$itr_no'");
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
        if($uid == 'IPLCDM1050'){
            $plantId = '1050';
        }
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
    /*Item repair starts*/
    public function itemRepair(){
        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $itr_no = DB::select("SELECT DISTINCT ITR_NO FROM MIS.IT_ITEM_TRANSFER_RECEIVE_D ORDER BY ITR_NO ASC");
        $vendors = DB::select("SELECT * FROM MIS.IT_VENDOR_SUPPLIER where USER_TYPE='vendor'");
        return view('stationery.itemRepair',['item_name'=>$item_name,'itr_no'=>$itr_no,'vendor'=>$vendors]);
    }

    public function getRequisitionData(Request $request){

        $itr_no = $request->itr_no;
        $plant_id = Auth::user()->plant_id;

        if($itr_no!=""){
            $req_data = DB::select("SELECT * from  MIS.IT_ITEM_TRANSFER_RECEIVE_D where itr_no='$itr_no'");


            $item_id = $req_data[0]->item_id;

            $data = DB::SELECT("SELECT QTY FROM MIS.IT_ITEM_STOCK WHERE PLANT_ID = '$plant_id' AND ITEM_ID = '$item_id'");
            if(count($data) > 0){
                return response()->json(['result'=>$req_data,'status'=>1,'qty'=>$data[0]->qty]);
            }else{
                return response()->json(['result'=>$req_data,'status'=>0]);
            }
        }else{
            return response()->json(['result'=>2]);
        }
    }
    public function getvendordata(Request $request){


    $vendor_id = $request->vendor_id;

    if($vendor_id!=""){
        $vendor_data = DB::select("SELECT * from  MIS.IT_VENDOR_SUPPLIER where id='$vendor_id'");
        if($vendor_data){
            return response()->json(['result'=>$vendor_data]);

        }else{
            return response()->json(['result'=>'error']);
        }

    }else{
        return response()->json(['result'=>2]);
    }


}

    public function saveItemRepair(Request $request){
        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;


        $data = DB::select("SELECT MAX(SUBSTR( SERVICE_ID, 10 )) max_id FROM MIS.IT_ITEM_REPAIR");
        $max_id = $data[0]->max_id;
        $max_idd = (int)$max_id;


        $itemRepairData = json_decode($request->issueItemData,true);
        $date = Carbon::now()->format('Y-m-d H:m:s');

        $check =0;
        if($max_idd == ''){
            $max_idd = "SRVC".$plant_id.'-1';
            $new_srvc_id = $max_idd;
            $check = 1;

        }

        for($i=0;$i<sizeof($itemRepairData);$i++){

            if($check==1){
                if($i>0){
                    $new_srvc_id++;
                }
            }else
            {
                $max_idd++;
                $new_srvc_id = $max_idd;
                $new_srvc_id = "SRVC".$plant_id.'-'.$max_idd;
            }


            $itemRepairData[$i]['CREATE_USER']= Auth::user()->user_id;
            $itemRepairData[$i]['SERVICE_ID']=$new_srvc_id;
            $itemRepairData[$i]['CREATE_DATE']= $date;
        }

        $status = DB::table('MIS.IT_ITEM_REPAIR')->insert($itemRepairData);

        if($status){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }

    }


     public function getRepaireItem(){
        $service_id = DB::SELECT("SELECT DISTINCT service_id from MIS.IT_ITEM_REPAIR ORDER BY service_id asc");
        if($service_id!=""){
            return response()->json($service_id);
        }else{
            return response()->json("");
        }
    }

    public function getAllService(Request $request){

        $all_services = DB::SELECT("SELECT DISTINCT * from MIS.IT_ITEM_REPAIR where service_id = '$request->service_no'");
        if($all_services!=""){
            return response()->json($all_services);
        }else{
            return response()->json("no data here");
        }
    }

    public function updateRepairItem(Request $request){

        $service_id = $request->id;

        $decoded_data = json_decode($request->itemArray);


        $edit_req_no = $decoded_data->edit_req_no;
        $edit_vendor_id = $decoded_data->edit_vendor_id;
        $edit_vendor_name = $decoded_data->edit_vendor_name;
        $edit_vendor_mobile = $decoded_data->edit_vendor_mobile;
        $edit_vendor_address = $decoded_data->edit_vendor_address;
        $edit_bill_no = $decoded_data->edit_bill_no;
        $edit_description = $decoded_data->edit_description;
        $edit_user_name = $decoded_data->edit_user_name;
        $edit_repair_type = $decoded_data->edit_repair_type;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_product_serial_no = $decoded_data->edit_product_serial_no;
        $edit_prev_srvc_date = $decoded_data->edit_prev_srvc_date;
        $edit_cwip_id_or_main_id = $decoded_data->edit_cwip_id_or_main_id;
        $edit_gl = $decoded_data->edit_gl;
        $edit_cost_center = $decoded_data->edit_cost_center;
        $edit_quantity = $decoded_data->edit_quantity;
        $edit_unit_cost = $decoded_data->edit_unit_cost;
        $edit_total_cost = $decoded_data->edit_total_cost;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $table_id = $request->table_id;

        if($service_id!=''){

            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REPAIR
                        SET
                           REQUISITION_NO = '$edit_req_no',
                            VENDOR_ID = '$edit_vendor_id',
                            VENDOR_NAME = '$edit_vendor_name',
                            VENDOR_MOBILE = '$edit_vendor_mobile',
                            VENDOR_ADDRESS = '$edit_vendor_address',
                            BILL_NO = '$edit_bill_no',
                            DESCRIPTION = '$edit_description',
                            REPAIR_TYPE = '$edit_repair_type',
                            ITEM_ID = '$edit_item_id',
                            ITEM_NAME = '$edit_item_name',
                            PRODUCT_SERIAL_NO = '$edit_product_serial_no',
                            PREVIOUS_SERVICE_DATE = '$edit_prev_srvc_date',
                            CWIP_ID_OR_MAIN_ID = '$edit_cwip_id_or_main_id',
                            GL = '$edit_gl',
                            COST_CENTER = '$edit_cost_center',
                            QUANTITY = '$edit_quantity',
                            UNIT_COST = '$edit_unit_cost',
                            TOTAL_COST = '$edit_total_cost',
                   
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        
                        WHERE ID = '$service_id'");

            if($result){
                return response()->json(['result'=> "success"]);
            }else{
                return response()->json(['result'=> "error"]);
            }

        }else{

            return response()->json(['result'=> "2"]);

        }

    }

    public function deleteRepairdItem(Request $request){
        $table_id = $request->id;

        if($request->id!=''){

            $status =DB::DELETE("DELETE FROM  MIS.IT_ITEM_REPAIR WHERE id = '$table_id'");
            if ($status){
                return response()->json(['status'=>'success']);
            }
            else{
                return response()->json(['status'=>'error']);
            }



        }else{
            return response()->json(['status'=>'error']);

        }


    }
    /*Item Transfer Ends*/



    /* CWIP to main id starts*/

    public function cwipIdToMainID(){
        $cwip_id = DB::select("SELECT ITEM_ID, SAP_CWIP_ID FROM MIS.IT_CHALLAN_RECEIVE_D WHERE  ITEM_ID IN (SELECT ITEM_ID FROM MIS.IT_ITEM_MASTER WHERE IT_NAME= 'CAPEX')");

        $uid= Auth::user()->user_id;

        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;

        return view('stationery.cwipIdToMAinId', ['cwip_id'=>$cwip_id,'exist_plant'=>$plant_id]);

    }

    public function getAllCwipNo(){
        $cwip_id = DB::select("Select distinct cwip_id from MIS.IT_UPGRADE_CWIPID_TO_MAINID");
        return response()->json($cwip_id);

    }

    public function getCwipRelatedData(Request $request){
        $cwip_id = $request->cwip_data;


        $cwip_details = DB::select("SELECT C.ITEM_ID,M.IST_ID,M.IST_NAME FROM MIS.IT_CHALLAN_RECEIVE_D C INNER JOIN MIS.IT_ITEM_MASTER M on C.ITEM_ID = M.ITEM_ID where C.SAP_CWIP_ID='$cwip_id'");
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

            // return response()->json($edit_new_plant);

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
    /*CWIP to main id ends*/


   /*Challan receive starts*/
    public function displayChalan(){

        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;

        $cost_center_id_name = DB::select("Select COST_CENTER_NAME,COST_CENTER_ID from MIS.IT_COST_CENTER where PLANT_ID='$plant_id'");


        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $suppliers = DB::select("SELECT DISTINCT NAME,CONTACT FROM MIS.IT_VENDOR_SUPPLIER where USER_TYPE='supplier'");
        return view('stationery.chalan_receive', ['item_name'=>$item_name,'supplier_name'=>$suppliers,'cost_center_id_name'=>$cost_center_id_name]);


    }
    public function saveReceivedChallan(Request $request){

        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


        $challanReceiveMasterData = $request->challanReceiveMaster;

        $challanReceiveMaster['PLANT_ID']= $plant_id;
        $challanReceiveMaster['CHALLAN_NO']= $challanReceiveMasterData['challan_no'];
        $challanReceiveMaster['COMPANY_CODE']= '1000';
        $challanReceiveMaster['SAP_PR']= $challanReceiveMasterData['sap_pr'];
        $challanReceiveMaster['SAP_PO']= $challanReceiveMasterData['sap_po'];
        $challanReceiveMaster['SUP_INVOICE_OR_CH_NO']= $challanReceiveMasterData['sup_invoice_or_ch_no'];
        $challanReceiveMaster['SUPPLIER_NAME']= $challanReceiveMasterData['supplier_name'];
        $challanReceiveMaster['REMARKS']= $challanReceiveMasterData['remarks'];
        $challanReceiveMaster['CREATE_USER']= Auth::user()->user_id;
        $challanReceiveMaster['UPDATE_USER']= Auth::user()->user_id;
        $challanReceiveMaster['CREATE_DATE']= $date;
        $challanReceiveMaster['UPDATE_DATE']= '';





        $status = DB::table('MIS.IT_CHALLAN_RECEIVE_M')->insert($challanReceiveMaster);

        $ChallanReceiveDataDetails = json_decode($request->challanReceiveDetails, true);



        //return response()->json($ChallanReceiveDataDetails[0]['product_serial']);

        if($status){
            for($i=0;$i<sizeof($ChallanReceiveDataDetails);$i++){
                $ChallanReceiveData[$i]['CHALLAN_NO']= $ChallanReceiveDataDetails[$i]['challan_no'];
                $ChallanReceiveData[$i]['ITEM_ID']= $ChallanReceiveDataDetails[$i]['item_id'];
                $ChallanReceiveData[$i]['ITEM_NAME']= $ChallanReceiveDataDetails[$i]['item_name'];
                $ChallanReceiveData[$i]['QTY']= $ChallanReceiveDataDetails[$i]['qty'];
                $ChallanReceiveData[$i]['UNIT_PRICE']= $ChallanReceiveDataDetails[$i]['unit_price'];
                $ChallanReceiveData[$i]['TOTAL_PRICE']= $ChallanReceiveDataDetails[$i]['total_price'];
                $ChallanReceiveData[$i]['EXPIRE_DATE']= $ChallanReceiveDataDetails[$i]['expire_date'];
                $ChallanReceiveData[$i]['WARRANTY_UNIT']= $ChallanReceiveDataDetails[$i]['warrenty_unit'];
                $ChallanReceiveData[$i]['WARRENTY']= $ChallanReceiveDataDetails[$i]['warrenty'];
                $ChallanReceiveData[$i]['SAP_CWIP_ID']= $ChallanReceiveDataDetails[$i]['sap_cwip_id'];
                $ChallanReceiveData[$i]['SAP_GL']= $ChallanReceiveDataDetails[$i]['sap_gl'];
                $ChallanReceiveData[$i]['SAP_CC']= $ChallanReceiveDataDetails[$i]['sap_cc'];
                $ChallanReceiveData[$i]['PRODUCT_SERIAL']= $ChallanReceiveDataDetails[$i]['product_serial'];
                $ChallanReceiveData[$i]['CREATE_USER']= Auth::user()->user_id;
                $ChallanReceiveData[$i]['UPDATE_USER']= Auth::user()->user_id;
                $ChallanReceiveData[$i]['CREATE_DATE']= $date;
                $ChallanReceiveData[$i]['UPDATE_DATE']= '';

            }
            $status = DB::table('MIS.IT_CHALLAN_RECEIVE_D')->insert($ChallanReceiveData);

            if($status){
                return response()->json("success");
            }else{
                return response()->json("error");
            }
            return response()->json("success");

        }else{
            return response()->json("error");

        }

    }

    public function getChallanNo(){

        $challan_no = DB::select("SELECT DISTINCT CHALLAN_NO FROM MIS.IT_CHALLAN_RECEIVE_D");
         if($challan_no){
             return response()->json(['challan_no'=>$challan_no]);

         }else{
             return response()->json(['challan_no'=>""]);
         }

    }

    public function getChallanDetails(Request $request){
        //return response()->json($request->challan_no);


        $challan_details = DB::select("SELECT CM.*,CD.* FROM MIS.IT_CHALLAN_RECEIVE_M CM  INNER JOIN  MIS.IT_CHALLAN_RECEIVE_D  CD
            ON CM.CHALLAN_NO = CD.CHALLAN_NO WHERE CD.CHALLAN_NO='$request->challan_no'");

        if($challan_details){
            return response()->json($challan_details);

        }else{
            return response()->json($challan_details);
        }


    }

    public function updateChallanReceive(Request $request){


        $table_id = $request->id;
        $decoded_data = json_decode($request->itemArray);


        $edit_challan_no = $decoded_data->edit_challan_no;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_sap_pr = $decoded_data->edit_sap_pr;
        $edit_sap_po = $decoded_data->edit_sap_po;
        $edit_sap_gl = $decoded_data->edit_sap_gl;
        $edit_sap_cc = $decoded_data->edit_sap_cc;
        $edit_unit_price = $decoded_data->edit_unit_price;
        $edit_total_price = $decoded_data->edit_total_price;
        $edit_expire_date = $decoded_data->edit_expire_date;
        $edit_product_searial = $decoded_data->edit_product_searial;
        $edit_warrenty_unit = $decoded_data->edit_warrenty_unit;
        $edit_warrenty = $decoded_data->edit_warrenty;
        $edit_sap_cwip_id = $decoded_data->edit_sap_cwip_id;
        $edit_supp_inv_or_chal_no = $decoded_data->edit_supp_inv_or_chal_no;
        $edit_supplier_name = $decoded_data->edit_supplier_name;
        $edit_remarks = $decoded_data->edit_remarks;
        $edit_pr_qty = $decoded_data->edit_pr_qty;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


        if($edit_challan_no!=''){

            $result =  DB::UPDATE("
                        UPDATE MIS.IT_CHALLAN_RECEIVE_M
                        SET
                            CHALLAN_NO = '$edit_challan_no',
                            SAP_PR = '$edit_sap_pr',
                            SAP_PO = '$edit_sap_po',
                            SUP_INVOICE_OR_CH_NO = '$edit_supp_inv_or_chal_no',
                            SUPPLIER_NAME = '$edit_supplier_name',
                            REMARKS = '$edit_remarks',
                    
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE CHALLAN_NO = '$edit_challan_no'");

            if($result){

                $result =  DB::UPDATE("
                        UPDATE MIS.IT_CHALLAN_RECEIVE_D
                        SET
                            CHALLAN_NO = '$edit_challan_no',
                            ITEM_ID = '$edit_item_id',
                            ITEM_NAME = '$edit_item_name',
                            UNIT_PRICE = '$edit_unit_price',
                            TOTAL_PRICE = '$edit_total_price',
                            EXPIRE_DATE = '$edit_expire_date',
                            WARRANTY_UNIT = '$edit_warrenty_unit',
                            WARRENTY = '$edit_warrenty',
                            SAP_CWIP_ID = '$edit_sap_cwip_id',
                            SAP_GL = '$edit_sap_gl',
                            SAP_CC = '$edit_sap_cc',
                            QTY = '$edit_pr_qty',
                            PRODUCT_SERIAL = '$edit_product_searial',
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$table_id'");

                if($result){
                    return response()->json(['result'=> "success"]);

                }else{
                    return response()->json(['result'=> $result]);
                }


            }else{
                return response()->json(['result'=> $result]);
            }
        }else{
            return response()->json(['result'=> "not sufficient"]);
        }

    }

    public function deleteChalanReceive(Request $request){
        $id = $request->id;
        $challan_no = $request->challan_no;


        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_CHALLAN_RECEIVE_D WHERE ID = ?',[$id]);
            if($result){

                $result =  DB::SELECT('select CHALLAN_NO FROM MIS.IT_CHALLAN_RECEIVE_D WHERE CHALLAN_NO = ?',[$challan_no]);
                if($result){
                    return response()->json(['status'=> 'success']);
                }else{
                    $result =  DB::DELETE('DELETE FROM MIS.IT_CHALLAN_RECEIVE_M WHERE CHALLAN_NO = ?',[$challan_no]);
                    if($result){
                        return response()->json(['status'=> 'success']);
                    }else{
                        return response()->json(['status'=> 'false']);
                    }
                }

            }else{
                return response()->json(['status'=> 'false']);
            }

        }else{
            return response()->json(['status'=> 2]);
        }

    }

    public function getProductItName(Request $request){
        $result =  DB::SELECT("select IT_NAME FROM MIS.IT_ITEM_MASTER WHERE ITEM_ID = '$request->item_id'");
        if($result){
            return response()->json(['status'=> $result]);

        }else{
            return response()->json(['status'=> 'error']);

        }



    }

 
    /*Challan receive ends*/
    
    /*Item uses starts*/
    public function displayItemUses(){
        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;

        $cost_center_id_name = DB::select("Select COST_CENTER_NAME,COST_CENTER_ID from MIS.IT_COST_CENTER where PLANT_ID='$plant_id'");
        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");

        return view('stationery.item_uses',['item_name'=>$item_name,'cost_center_id_name'=>$cost_center_id_name]);

    }
    
    public function saveUseItem(Request $request){
        $itemdata = $request->data;

        $uid= Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id= $plant_id[0]->plant_id;


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
        $issueItemMaster['COMPANY_CODE']= '2000';
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
    /*sayla ends*/


}
