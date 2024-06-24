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

class ItemRepairController extends Controller
{

    public function itemRepair()
    {

        $uid = Auth::user()->user_id;
        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $itr_no = DB::select("SELECT DISTINCT ITR_NO FROM MIS.IT_ITEM_TRANSFER_RECEIVE_D where item_id in (select item_id from MIS.IT_ITEM_MASTER_DEV where HO_CDM='$uid') ORDER BY ITR_NO ASC");
        $vendors = DB::select("SELECT * FROM MIS.IT_VENDOR_SUPPLIER where USER_TYPE='vendor'");
        return view('stationery.itemRepair', ['item_name' => $item_name, 'itr_no' => $itr_no, 'vendor' => $vendors]);
    }

    public function getRequisitionData(Request $request)
    {

        $itr_no = $request->itr_no;
        $plant_id = Auth::user()->plant_id;

        if ($itr_no != "") {
            $req_data = DB::select("SELECT * from  MIS.IT_ITEM_TRANSFER_RECEIVE_D where itr_no='$itr_no'");


            $item_id = $req_data[0]->item_id;

            $data = DB::SELECT("SELECT QTY FROM MIS.IT_ITEM_STOCK WHERE PLANT_ID = '$plant_id' AND ITEM_ID = '$item_id'");
            if (count($data) > 0) {
                return response()->json(['result' => $req_data, 'status' => 1, 'qty' => $data[0]->qty]);
            } else {
                return response()->json(['result' => $req_data, 'status' => 0]);
            }
        } else {
            return response()->json(['result' => 2]);
        }
    }

    public function getvendordata(Request $request)
    {


        $vendor_id = $request->vendor_id;

        if ($vendor_id != "") {
            $vendor_data = DB::select("SELECT * from  MIS.IT_VENDOR_SUPPLIER where id='$vendor_id'");
            if ($vendor_data) {
                return response()->json(['result' => $vendor_data]);

            } else {
                return response()->json(['result' => 'error']);
            }

        } else {
            return response()->json(['result' => 2]);
        }


    }

    public function saveItemRepair(Request $request)
    {
        $uid = Auth::user()->user_id;
        $plant_id = DB::select("Select PLANT_ID from MIS.EMP_HIS_INFO where EMP_ID='$uid'");
        $plant_id = $plant_id[0]->plant_id;


        $data = DB::select("SELECT MAX(SUBSTR( SERVICE_ID, 10 )) max_id FROM MIS.IT_ITEM_REPAIR");
        $max_id = $data[0]->max_id;
        $max_idd = (int)$max_id;


        $itemRepairData = json_decode($request->issueItemData, true);
        $date = Carbon::now()->format('Y-m-d H:m:s');

        $check = 0;
        if ($max_idd == '') {
            $max_idd = "SRVC" . $plant_id . '-1';
            $new_srvc_id = $max_idd;
            $check = 1;

        }

        for ($i = 0; $i < sizeof($itemRepairData); $i++) {

            if ($check == 1) {
                if ($i > 0) {
                    $new_srvc_id++;
                }
            } else {
                $max_idd++;
                $new_srvc_id = $max_idd;
                $new_srvc_id = "SRVC" . $plant_id . '-' . $max_idd;
            }


            $itemRepairData[$i]['CREATE_USER'] = Auth::user()->user_id;
            $itemRepairData[$i]['SERVICE_ID'] = $new_srvc_id;
            $itemRepairData[$i]['CREATE_DATE'] = $date;
        }

        $status = DB::table('MIS.IT_ITEM_REPAIR')->insert($itemRepairData);

        if ($status) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }

    }


    public function getRepaireItem()
    {
        $uid = Auth::user()->user_id;
        $service_id = DB::SELECT("SELECT DISTINCT service_id from MIS.IT_ITEM_REPAIR where item_id in (select item_id from MIS.IT_ITEM_MASTER_DEV where HO_CDM='$uid') ORDER BY service_id asc");
        if ($service_id != "") {
            return response()->json($service_id);
        } else {
            return response()->json("");
        }
    }

    public function getAllService(Request $request)
    {

        $all_services = DB::SELECT("SELECT DISTINCT * from MIS.IT_ITEM_REPAIR where service_id = '$request->service_no'");
        if ($all_services != "") {
            return response()->json($all_services);
        } else {
            return response()->json("no data here");
        }
    }

    public function updateRepairItem(Request $request)
    {

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

        if ($service_id != '') {

            $result = DB::UPDATE("
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

            if ($result) {
                return response()->json(['result' => "success"]);
            } else {
                return response()->json(['result' => "error"]);
            }

        } else {

            return response()->json(['result' => "2"]);

        }

    }

    public function deleteRepairdItem(Request $request)
    {
        $table_id = $request->id;

        if ($request->id != '') {

            $status = DB::DELETE("DELETE FROM  MIS.IT_ITEM_REPAIR WHERE id = '$table_id'");
            if ($status) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }


        } else {
            return response()->json(['status' => 'error']);

        }


    }


}
