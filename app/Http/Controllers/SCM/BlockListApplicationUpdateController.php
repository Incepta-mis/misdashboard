<?php

namespace App\Http\Controllers\SCM;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class BlockListApplicationUpdateController extends Controller
{
    public function index(){
        $cmp_data = DB::select("
            select distinct app_id,plant,create_user,get_scm_company_name(plant) company_name, to_char(create_date,'dd-mon-rr') app_date
            from mis.scm_app_blocklist
            where transfer is null
            order by app_id desc
        ");
        return view('scm_portal/BL_application_form_update', ['cmp_data' => $cmp_data]);
    }

    public function getAppUpdate(Request $request){
        $app_id = $request->app_id;
        $rs = DB::select("select line_id, app_id, bl_type, sl_no , blocklist_year , to_char(blocklist_date,'mm/dd/rrrr') blocklist_date, plant , blocklist_no, material_name , manufacturer_name, supplier_name, qty , uom  , air_price    , road_price , sea_price , currency  , cfp   , qty_finish_product, create_date, create_user, update_date, update_user from mis.scm_app_blocklist a where app_id = '$app_id'");
        return response()->json($rs);
    }


    public function getUpMaterialName(Request $request)
    {
        $material = $request->term['term'];

        if ($material) {
            $mat = DB::select("                                
                select distinct material_name
                from mis.scm_mm_data
                where  UPPER(material_name) LIKE '%" . strtoupper($material) . "%'
                union
                select distinct material_name
                from mis.scm_app_blocklist
                where  UPPER(material_name) LIKE '%" . strtoupper($material) . "%'
                order by material_name
            ");
            return response()->json($mat);
        }
    }

    public function getUpManufacturerName(Request $request)
    {
        $manufacturer = $request->term['term'];

        if ($manufacturer) {
            $mat = DB::select("
                select distinct manufacturer_name
                from mis.scm_mm_data
                where  UPPER(MANUFACTURER_NAME) LIKE '%" . strtoupper($manufacturer) . "%'
                union
                select distinct manufacturer_name
                from mis.scm_app_blocklist
                where  UPPER(MANUFACTURER_NAME) LIKE '%" . strtoupper($manufacturer) . "%'
                order by manufacturer_name
            ");
            return response()->json($mat);
        }
    }

    public function getUpSupplierName(Request $request){
        $supplier = $request->term['term'];

        if ($supplier) {
            $mat = DB::select("                
                select distinct supplier_name
                from mis.scm_mm_data
                where  UPPER(supplier_name) LIKE '%" . strtoupper($supplier) . "%'
                union
                select distinct supplier_name
                from mis.scm_app_blocklist
                where  UPPER(supplier_name) LIKE '%" . strtoupper($supplier) . "%'
                order by supplier_name
            ");
            return response()->json($mat);
        }
    }

    public function getUpFinishProductName(Request $request){
        $product = $request->term['term'];

        if ($product) {
            $mat = DB::select("
                select product_name
                from(
                select brand_name ||' '||dosage_form product_name
                from mis.scm_fp_data
                )
                where UPPER(product_name) LIKE '%" . strtoupper($product) . "%'
                order by product_name
            ");
            return response()->json($mat);
        }
    }


    public function frmApplicationUpdate(Request $request){


        // return response()->json($request->all());

        $line_id 	= $request->line_id;
        $newValue 	= $request->newValue;
        $colName 	= $request->colName;
        $uid = Auth::user()->user_id;
        $update_date = date('Y-m-d H:i:s');


        // Log::info($line_id);
        // Log::info($newValue);
        // Log::info($colName);


        if($colName == 'BLOCKLIST_DATE' ){
            $newValue =  $s = Carbon::parse($newValue)->format('Y-m-d');
        }
        elseif ($colName == 'FINISHED_PRODUCT'){
            $colName = 'CFP';
        }
        elseif ($colName == 'QTY_OF_FP'){
            $colName = 'QTY_FINISH_PRODUCT';
        }else {
            $colName = $colName ;
        }

        if($colName != 'SL_NO'  ){
            if($line_id != '' && $newValue != '' && $colName != '')
            {

                $x = DB::table('MIS.SCM_APP_BLOCKLIST')
                    ->where('line_id', $line_id)
                    ->update([$colName => $newValue, 'update_user' => $uid, 'UPDATE_DATE' => $update_date]);
                if($x){
                    return response()->json(['success' => 'true']);
                }

            }
            else if($line_id != '' && empty($newValue) && $colName != ''){
                $x = DB::table('MIS.SCM_APP_BLOCKLIST')
                    ->where('line_id', $line_id)
                    ->update([$colName => $newValue, 'update_user' => $uid, 'UPDATE_DATE' => $update_date]);
                if($x){
                    return response()->json(['success' => 'true']);
                }
            }
        }else{
            return response()->json(['error' => 'Data not Saved.']);
        }



    }


    public function send_apply_rejected_data(Request $request){

        $uid = Auth::user()->user_id;
        $update_date = date('Y-m-d H:i:s');

        $rs = DB::table('mis.scm_apply_rejected_data')->insert([
            'line_id' => $request->data['line_id'],
            'app_id' => $request->data['app_id'],
            'sl_no' => $request->data['sl_no'],
            'plant' => $request->data['plant'],
            'material_name' => $request->data['material_name'],
            'manufacturer_name' => $request->data['manufacturer_name'],
            'supplier_name' => $request->data['supplier_name'],
            'qty' => $request->data['qty'],
            'uom' => $request->data['uom'],
            'air_price' => $request->data['air_price'],
            'road_price' => $request->data['road_price'],
            'sea_price' => $request->data['sea_price'],
            'currency' => $request->data['currency'],
            'cfp' => $request->data['cfp'],
            'qty_finish_product' => $request->data['qty_finish_product'],
            'update_user' => $uid ,
            'update_date' => $update_date ,
        ]);

        if($rs){
            DB::table('MIS.SCM_APP_BLOCKLIST')->where('line_id', $request->data['line_id'])->delete();
            return response()->json(['success' => 'Record Save Successfully']);
        }else{
            return response()->json(['error' => 'Record Not Saved.']);
        }
    }

    public function scm_transfer_data_to_master(Request $request)
    {

        $app_id = $request->app_id;
        $select = DB::select("  select BLOCKLIST_YEAR, BLOCKLIST_DATE, PLANT  , BLOCKLIST_NO, MATERIAL_NAME , MANUFACTURER_NAME , SUPPLIER_NAME , QTY   , UOM , AIR_PRICE, ROAD_PRICE , SEA_PRICE , CURRENCY  , CREATE_DATE , CREATE_USER , UPDATE_DATE , UPDATE_USER from MIS.SCM_APP_BLOCKLIST where app_id = $app_id");
        if($select){
            try{

                $rs = DB::insert("insert into mis.scm_blocklist_material (blocklist_year, blocklist_date, plant, 
                                               blocklist_no, material_name, manufacturer_name, 
                                               supplier_name, qty, uom, 
                                               air_price, road_price, sea_price, 
                                               currency, create_date, create_user, 
                                               update_date, update_user)
                                            select 
                                            blocklist_year, blocklist_date, plant, 
                                               blocklist_no, material_name, manufacturer_name, 
                                               supplier_name, qty, uom, 
                                               air_price, road_price, sea_price, 
                                               currency, create_date, create_user, 
                                               update_date, update_user
                                            from MIS.SCM_APP_BLOCKLIST
                                            where app_id = ?",[$app_id]);


                    DB::table('MIS.SCM_APP_BLOCKLIST')
                    ->where('app_id', $app_id)
                    ->update(['transfer' => 'YES']);

                if($rs){
                    return response()->json(['success' => 'true']);
                }else{
                    return response()->json(['error' => 'true']);
                }
            }catch (Oci8Exception $exception){
                Log::info("Error: BlockList Update Controller, Function: scm_transfer_data_to_master");
            }
        }

    }

    public function insScmApplicationFRM(Request $request){

        if($request->ajax()){

            if(empty($request->bl_type)){
                return response()->json(['error'=> 'Please Enter BL TYPE.']);
            }elseif(empty($request->material)){
                return response()->json(['error'=> 'Please Enter Material Name.']);
            }elseif(empty($request->manufacturer)){
                return response()->json(['error'=> 'Please Enter Manufacturer Name.']);
            }elseif(empty($request->supplier)){
                return response()->json(['error'=> 'Please Enter Supplier.']);
            }elseif(empty($request->qty)){
                return response()->json(['error'=> 'Please Enter Quantity.']);
            }elseif(empty($request->uom)){
                return response()->json(['error'=> 'Please Enter UOM.']);
            }elseif(empty($request->currency)){
                return response()->json(['error'=> 'Please Select Currency.']);
            }elseif(empty($request->qty_fp)){
                return response()->json(['error'=> 'Please Enter Quantity of Finish Product.']);
            }else{


                $maxx_id =  DB::select('select max(line_id) + 1 max_id from mis.SCM_APP_BLOCKLIST');
                $geSlNo = DB::select("select max(sl_no) + 1 sl_id from mis.SCM_APP_BLOCKLIST where app_id = '$request->apply_id' ");
                $Pl = DB::select("select distinct plant from mis.SCM_APP_BLOCKLIST where app_id = '$request->apply_id' ");
                $auth_id = Auth::user()->user_id;

                $x = DB::table('MIS.SCM_APP_BLOCKLIST')->insert([
                    'LINE_ID'			=> $maxx_id[0]->max_id,
                    'APP_ID'			=> $request->apply_id,
                    'PLANT'			    => $Pl[0]->plant,
                    'SL_NO'			    => $geSlNo[0]->sl_id,
                    'BL_TYPE' 			=> $request->bl_type,
                    'MATERIAL_NAME'		=> $request->material,
                    'MANUFACTURER_NAME'	=> $request->manufacturer,
                    'SUPPLIER_NAME'		=> $request->supplier,
                    'QTY'				=> $request->qty,
                    'UOM'				=> $request->uom,
                    'AIR_PRICE'			=> $request->air ? $request->air : 0,
                    'SEA_PRICE'			=> $request->sea ? $request->sea  : 0,
                    'ROAD_PRICE'		=> $request->road ? $request->road : 0,
                    'CURRENCY'			=> $request->currency,
                    'CFP'				=> $request->cfp,
                    'QTY_FINISH_PRODUCT' => $request->qty_fp,
                    'UPDATE_USER'  		=> $auth_id,
                ]);

                if ($x) {
                    return response()->json(['success'=> 'Data Saved.']);
                }else{
                    return response()->json(['error'=> 'Contact Your Administrator.']);
                }

            }

        }else {
            return response()->json(['error'=> 'Please Contact Your Administrator.']);
        }
    }


}