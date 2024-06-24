<?php


namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use App\Model\SCM\ApplicationBlockList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class BlockListApplicationController extends Controller
{
    public function index(){
        $rs_data = DB::select("select plant,company_full_name_new ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        $sequence = DB::getSequence();
        $sequence->nextValue('MIS.SCM_APPLICATION_ID_SEQ');
        $appId = $sequence->nextValue('MIS.SCM_APPLICATION_ID_SEQ');

        // $appId = DB::select("select nvl(max(app_id),0)+1 apid from mis.scm_app_blocklist");
        return view('scm_portal/BL_application_form', ['cmp_data' => $rs_data,'appId'=>$appId]);
    }

    public function getMaterialName(Request $request)
    {
        $material = $request->term['term'];

        if ($material) {
            $mat = DB::select("                                
                select distinct material_name
                from mis.scm_mm_data
                where  UPPER(material_name) LIKE '%" . strtoupper($material) . "%'
                minus
                select distinct material_name
                from mis.scm_app_blocklist
                where  UPPER(material_name) LIKE '%" . strtoupper($material) . "%'
                order by material_name
            ");
            return response()->json($mat);
        }
    }

    public function getManufacturerName(Request $request)
    {
        $manufacturer = $request->term['term'];

        if ($manufacturer) {
            $mat = DB::select("
                select distinct manufacturer_name
                from mis.scm_mm_data
                where  UPPER(MANUFACTURER_NAME) LIKE '%" . strtoupper($manufacturer) . "%'
                minus
                select distinct manufacturer_name
                from mis.scm_app_blocklist
                where  UPPER(MANUFACTURER_NAME) LIKE '%" . strtoupper($manufacturer) . "%'
                order by manufacturer_name
            ");
            return response()->json($mat);
        }
    }

    public function getSupplierName(Request $request){
        $supplier = $request->term['term'];

        if ($supplier) {
            $mat = DB::select("                
                select distinct supplier_name
                from mis.scm_mm_data
                where  UPPER(supplier_name) LIKE '%" . strtoupper($supplier) . "%'
                minus
                select distinct supplier_name
                from mis.scm_app_blocklist
                where  UPPER(supplier_name) LIKE '%" . strtoupper($supplier) . "%'
                order by supplier_name
            ");
            return response()->json($mat);
        }
    }

    public function getFinishProductName(Request $request){
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

    public function saveScmAppForm(Request $request)
    {

        $uid = Auth::user()->user_id;
        $frmdata = $request->input();
        $appId = $frmdata['app_id'];
        $plant_id = $frmdata['cmp'];
        $bl_type = $frmdata['bl_type'];
        $lId = DB::select("select nvl(max(line_id),0)+1 line_id from mis.scm_app_blocklist");
        try {



            for ($i = 0; $i < count($frmdata['material']); $i++) {

                $data = [
                    'line_id' => $lId[0]->line_id + $i,
                    'sl_no' => $i+1,
                    'app_id' => $appId,
                    'plant' => $plant_id,
                    'bl_type' => $bl_type,
                    'material_name' => $frmdata['material'][$i],
                    'manufacturer_name' => $frmdata['manufacturer'][$i],
                    'supplier_name' => $frmdata['supplier'][$i],
                    'qty' => $frmdata['qty'][$i],
                    'uom' => $frmdata['uom'][$i],
                    'currency' => $frmdata['currency'][$i],
                    'cfp' => $frmdata['cfp'][$i],
                    'air_price' => $frmdata['air'][$i] ? $frmdata['air'][$i] : 0,
                    'sea_price' => $frmdata['sea'][$i] ? $frmdata['sea'][$i] : 0,
                    'road_price' => $frmdata['road'][$i] ? $frmdata['road'][$i] : 0,
                    'qty_finish_product' => $frmdata['qty_fp'][$i] ? $frmdata['qty_fp'][$i] : 0,
                    'create_user' => $uid
                ];
               $rs = ApplicationBlockList::insert($data);
            }
            if($rs){
                return redirect('scm_portal/bl_apply_from')->with('status', "Save successfully");
            }else{
                return redirect('scm_portal/bl_apply_from')->with('status', "operation failed");
            }


        } catch (Oci8Exception $e) {
            Log::info($e->getCode());
            Log::info($e->getMessage());
            return redirect('scm_portal/bl_apply_from')->with('failed', "operation failed");
        }


    }



    // Applied Block list Report Start

    public function applied_blocklist_rpt(){

        $emp = DB::select("
            select distinct create_user emp_id,get_emp_name(create_user) emp_name
            from mis.scm_app_blocklist
        ");

        return view('scm_portal.reports.appliedBlockList_rpt',compact('emp'));
    }

    public function getApplicationRpt(Request $request){

        DB::setDateFormat('DD-Mon-RR');

        $DT1 = date('d-M-y', strtotime("$request->dt_1 "));
        $DT2 = date('d-M-y', strtotime("$request->dt_2"));


        $applblokList =     DB::select("
            select  *
            from mis.scm_app_blocklist
            where create_user =  decode('$request->emp','All',create_user,'$request->emp')
            and to_date(to_char(create_date,'DD-Mon-RR'),'DD-Mon-RR') between '$DT1' and '$DT2' 
            order by app_id,sl_no
        ");

        return response()->json($applblokList);
    }


    // Applied Block list Report End



}