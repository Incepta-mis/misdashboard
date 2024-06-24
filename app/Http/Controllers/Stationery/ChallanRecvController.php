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



class ChallanRecvController extends Controller
{
    /*Challan receive starts*/
    public function displayChalan(){
        $uid= Auth::user()->user_id;
        $plant_id=Auth::user()->plant_id;
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");


        $cost_center_id_name = DB::select("Select COST_CENTER_NAME,COST_CENTER_ID from MIS.IT_COST_CENTER where PLANT_ID='$plant_id'");


        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $suppliers = DB::select("SELECT DISTINCT NAME,CONTACT FROM MIS.IT_VENDOR_SUPPLIER where USER_TYPE='supplier'");
        return view('stationery.chalan_receive', ['item_name'=>$item_name,'supplier_name'=>$suppliers,'cost_center_id_name'=>$cost_center_id_name,
            'units'=>$units]);

    }

    public function saveReceivedChallan(Request $request){

        $uid= Auth::user()->user_id;
        $plant_id=Auth::user()->plant_id;
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

        //return response()->json($ChallanReceiveDataDetails);

        if($status){
            for($i=0;$i<sizeof($ChallanReceiveDataDetails);$i++){
                $ChallanReceiveData[$i]['CHALLAN_NO']= $ChallanReceiveDataDetails[$i]['challan_no'];
                $ChallanReceiveData[$i]['ITEM_ID']= $ChallanReceiveDataDetails[$i]['item_id'];
                $ChallanReceiveData[$i]['ITEM_NAME']= $ChallanReceiveDataDetails[$i]['item_name'];
                $ChallanReceiveData[$i]['UNIT']= $ChallanReceiveDataDetails[$i]['unit'];
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
        $edit_warrenty_unit = $decoded_data->edit_warrenty_unit;

        $edit_challan_no = $decoded_data->edit_challan_no;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_unit = $decoded_data->edit_unit;
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
                            UNIT = '$edit_unit',
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
    public function checkChallanNo(Request $request){


        $result =  DB::SELECT("select CHALLAN_NO FROM MIS.IT_CHALLAN_RECEIVE_M WHERE CHALLAN_NO = '$request->challan_no_master'");
        if($result){
            return response()->json(['status'=> 'true']);

        }else{
            return response()->json(['status'=> 'error']);

        }


    }
    /*Challan receive ends*/


}