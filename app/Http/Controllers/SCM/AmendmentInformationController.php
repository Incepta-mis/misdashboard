<?php

namespace App\Http\Controllers\SCM;

use FontLib\EOT\File;
use FontLib\Table\Type\loca;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AmendmentInformationController extends Controller
{

    public function index(){
        $rs_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        return view('scm_portal/amendment/amendment_form', ['cmp_data' => $rs_data]);
    }

    /*New Functions*/
    public function get_stm_summary_data(Request $request){
        $resp_data = DB::Select("

           select blocklist_no,material_name, manufacturer_name,supplier_name,qty,
             (avl_qty -   mis.scm_avl_matqty(blocklist_no,material_name)) avl_qty,uom,out_qty,price, currency
            FROM 
            (
            select  distinct a.blocklist_no,a.material_name, a.manufacturer_name,a.supplier_name,a.qty,                            
                                      (  case when b.out_uom = 'GM'  then  nvl((a.qty-b.out_qty),0) 
                                              when b.out_uom = 'PCS' then nvl((a.qty-b.out_qty),0)
                                              when b.out_uom = 'MG'  then  nvl((a.qty-(b.out_qty)),0)  
                                              when b.out_uom = 'MT'  then  nvl((a.qty-(b.out_qty)),0)
                                              else nvl(a.qty,0)-nvl(b.out_qty,0)
                                      end ) avl_qty                                           
                            ,a.uom, nvl(b.out_qty,0) out_qty,
                            --b.out_uom,a.air_price,a.road_price,a.sea_price,
                            CASE 
                               WHEN nvl(a.air_price,0) <> 0 THEN concat('A/',nvl(a.air_price,0))
                               WHEN nvl(a.road_price,0) <> 0 THEN concat('R/',nvl(a.road_price,0))
                               WHEN nvl(a.sea_price,0) <> 0 THEN concat('S/',nvl(a.sea_price,0))
                               ELSE ''
                            END price                          
                            , a.currency      
                            from 
                            (select distinct blocklist_year,blocklist_date,plant,blocklist_no,material_name,manufacturer_name,supplier_name,qty,uom,air_price,road_price,sea_price,currency
                            from mis.scm_blocklist_material
                            where plant = ?
                            order by material_name asc) a ,(select plant,blocklist_no,material_name,sum(qty) out_qty,uom out_uom from mis.scm_clearance where plant = ? group by plant,blocklist_no,material_name,uom order by material_name asc) b
                            where a.plant = b.plant (+)
                            and a.blocklist_no   =   b.blocklist_no (+)
                            and a.material_name   = b.material_name (+)
                            and a.blocklist_no = decode(?,'All',a.blocklist_no,?)
                            and a.plant = decode(?,'All',a.plant,?)
                            and a.material_name = decode(?,'All',a.material_name,?)
                            
        ) ",
            [$request->plant, $request->plant, $request->blList, $request->blList
                , $request->plant, $request->plant, $request->materialName,$request->materialName]);
        return response()->json($resp_data);
    }

    /*Submit Amendment Data*/
    public function submitAmendmentData(Request $request){
        $upload_location = public_path('SCM/AmendmentFiles/');
        $data = $_POST['data'];
        $data = json_decode($data, true);
        $data_count = count($data);


        if(isset($_FILES['files']['name'])){
            $file_count = count($_FILES['files']['name']);
        }else{
            $file_count=null;
        }

        /* Get Exact Blockjlist Numbers With Files*/
        for ($j=0;$j<$data_count;$j++){
                if($data[$j]['filename']!=''){
                    $blocklist_names[] = $data[$j]['blocklist_no'];
                }
            }

        /*Upload File in Public Path*/
        $files_arr = array();
        for($i = 0; $i<$file_count; $i++){
                if(isset($_FILES['files']['name'][$i]) && $_FILES['files']['name'][$i] != ''){
                    $filename = $blocklist_names[$i].'_'.rand(10,10000)."_".$_FILES['files']['name'][$i];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $valid_ext = array("pdf","png","jpeg","jpg");
                    if(in_array($ext, $valid_ext)){
                        $path = $upload_location.$filename;
                        $name = $filename;
                        if(move_uploaded_file($_FILES['files']['tmp_name'][$i],$path)){
                            $files_arr[] = $name;
                        }
                    }
                }else{
                    $files_arr[] = '';
                }
            }

        /*Insert file path into data*/
        $k=0;
        for($i=0;$i<count($data);$i++){
                if($data[$i]['filename']!='' && count($files_arr)>0){
                    $data[$i]['file_path'] = $files_arr[$k];
                    $k++;
                }else{
                    $data[$i]['file_path'] = '';
                }
        }

        for($i=0; $i<sizeof($data);$i++){

            if($data[$i]['rate_type']=='by_air'){
                $data[$i]['AIR_PRICE'] = $data[$i]['next_rate'];

            }
            if($data[$i]['rate_type']=='by_road'){
                $data[$i]['ROAD_PRICE'] = $data[$i]['next_rate'];

            }
            if($data[$i]['rate_type']=='by_ship'){
                $data[$i]['SEA_PRICE'] = $data[$i]['next_rate'];

            }
            $data[$i]['CREATE_USER']= Auth::user()->user_id;

        }

        //log::info($data);


        for ($i=0;$i<count($data);$i++) {
            if ($data[$i]['supp_change'] !='' || $data[$i]['next_rate'] != '' || $data[$i]['file_path'] != '') {

                $status = DB::table('MIS.SCM_BL_Amendment_Information')->insert($data[$i]);

            }
        }


        /*   for ($j=0;$j<$data_count;$j++){
                   if($data[$j]['filename']!=''){
                       $file_index[] = $j;
                   }
               }
               for ($i=0;$i<sizeof($data);$i++){
                   if($data[$i]['file_path']='');
               }

               for ($i=0;$i<sizeof($files_arr);$i++){
                   $data[$file_index[$i]]['file_path'] = $files_arr[$i];
               }*/


    }


    /* New Function Ends*/

    public function plantBlockList(Request $request){
        $resp_data = DB::Select("select distinct blocklist_no
                from mis. scm_blocklist_material
                where plant = ?
                order by blocklist_no asc", [$request->plant]);
        return response()->json($resp_data);
    }

    public function plantBlockListWiseMaterials(Request $request){
        $resp_data = DB::Select("select distinct material_name
        from mis. scm_blocklist_material
        where plant = ?
        and blocklist_no = decode(?,'All',blocklist_no,?)
        order by material_name asc", [$request->plant,$request->blckListNo,$request->blckListNo]);
        return response()->json($resp_data);
    }



    public function indexWaring(){
        $rs_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        return view('scm_portal/BL_warning_meterial', ['cmp_data' => $rs_data]);
    }

    public function get_stm_warning_data(Request $request){
        $resp_data = DB::Select("
        SELECT *
        FROM(
            select blocklist_no,material_name, manufacturer_name,supplier_name,qty,
             (avl_qty -   mis.scm_avl_matqty(blocklist_no,material_name)) avl_qty,uom,price, currency
            FROM 
            (
            select  distinct a.blocklist_no,a.material_name, a.manufacturer_name,a.supplier_name,a.qty,                            
                                      (  case when b.out_uom = 'GM'  then  nvl((a.qty-b.out_qty),0) 
                                              when b.out_uom = 'PCS' then nvl((a.qty-b.out_qty),0)
                                              when b.out_uom = 'MG'  then  nvl((a.qty-(b.out_qty)),0)  
                                              when b.out_uom = 'MT'  then  nvl((a.qty-(b.out_qty)),0)
                                              else nvl(a.qty,0)-nvl(b.out_qty,0)
                                      end ) avl_qty                                           
                            ,a.uom, nvl(b.out_qty,0) out_qty,
                            --b.out_uom,a.air_price,a.road_price,a.sea_price,
                            CASE 
                               WHEN nvl(a.air_price,0) <> 0 THEN concat('A/',nvl(a.air_price,0))
                               WHEN nvl(a.road_price,0) <> 0 THEN concat('R/',nvl(a.road_price,0))
                               WHEN nvl(a.sea_price,0) <> 0 THEN concat('S/',nvl(a.sea_price,0))
                               ELSE ''
                            END price                          
                            , a.currency      
                            from 
                            (select distinct blocklist_year,blocklist_date,plant,blocklist_no,material_name,manufacturer_name,supplier_name,qty,uom,air_price,road_price,sea_price,currency
                            from mis.scm_blocklist_material
                            where plant = ?
                            order by material_name asc) a ,(select plant,blocklist_no,material_name,sum(qty) out_qty,uom out_uom from mis.scm_clearance 
                            where plant = ? 
                            group by plant,blocklist_no,material_name,uom order by material_name asc) b
                            where a.plant = b.plant (+)
                            and a.blocklist_no   =   b.blocklist_no (+)
                            and a.material_name   = b.material_name (+)
                            and a.blocklist_no = decode(?,'All',a.blocklist_no,?)
                            and a.plant = decode(?,'All',a.plant,?)
                            and a.material_name = decode(?,'All',a.material_name,?)                            
            ) 
            ) where avl_qty <= (qty/2.5)
            minus
            select blocklist_no,material_name, manufacturer_name,supplier_name,qty,avl_qty,uom,price,currency
            from mis.scm_warning_material
            ",
            [$request->plant, $request->plant, $request->blList, $request->blList
                , $request->plant, $request->plant, $request->materialName,$request->materialName]);
        return response()->json($resp_data);
    }

    public function insertWarningData(Request $request){

        $rs = DB::table('mis.scm_warning_material')->insert([
            'blocklist_no' => $request->data['blocklist_no'],
            'material_name' => $request->data['material_name'],
            'manufacturer_name' => $request->data['manufacturer_name'],
            'supplier_name' => $request->data['supplier_name'],
            'qty' => $request->data['qty'],
            'avl_qty' => $request->data['avl_qty'],
            'uom' => $request->data['uom'],
            'price' => $request->data['price'],
            'currency' => $request->data['currency'],
        ]);

        if($rs){
            return response()->json(['success' => 'Record Save Successfully']);
        }else{
            return response()->json(['error' => 'Record Not Saved.']);
        }
    }


}
