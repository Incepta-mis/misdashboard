<?php


namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BLSummaryController extends Controller
{
    public function index(){
        $rs_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        return view('scm_portal/BL_statement_summary', ['cmp_data' => $rs_data]);
    }

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

   
    public function get_stm_summary_data(Request $request){
  $resp_data = DB::Select("
          select blocklist_no,material_name, manufacturer_name,supplier_name,currency,qty,(avl_qty -   mis.scm_avl_matqty(blocklist_no,material_name)) avl_qty,uom,price,create_date,'' FILE_PATH
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
                            , a.currency,create_date
                            from
                            (select distinct blocklist_year,blocklist_date,plant,blocklist_no,material_name,manufacturer_name,supplier_name,qty,uom,air_price,road_price,sea_price,currency,create_date
                            from mis.scm_blocklist_material
                            where plant ='$request->plant'
                            order by material_name asc) a ,(select plant,blocklist_no,material_name,sum(qty) out_qty,uom out_uom from mis.scm_clearance where plant = '$request->plant'  group by plant,blocklist_no,material_name,uom order by material_name asc) b
                            where a.plant = b.plant (+)
                            and a.blocklist_no   =   b.blocklist_no (+)
                            and a.material_name   = b.material_name (+)
                            and a.blocklist_no = decode('$request->blList','All',a.blocklist_no,'$request->blList')
                            and a.plant = decode('$request->plant','All',a.plant,'$request->plant')
                            and a.material_name = decode('$request->materialName','All',a.material_name,'$request->materialName')

        ) 
            UNION ALL select  blocklist_no,material_name, manufacturer_name,supplier_name, currency,null qty, null avl_qty, '' uom,
            CASE RATE_TYPE
                WHEN 'by_air'  THEN concat('A/',nvl(air_price,0))
                WHEN 'by_sea'  THEN concat('S/',nvl(sea_price,0))
                WHEN 'by_road' THEN concat('R/',nvl(road_price,0))
            ELSE ''
            END price,create_date , FILE_PATH

                    from mis.SCM_BL_AMENDMENT_INFORMATION
                    where blockList_no = decode('$request->blList','All',blocklist_no,'$request->blList')
                    and plant_id = decode('$request->plant','All',plant_id,'$request->plant')
                    and material_name = decode('$request->materialName','All',material_name,'$request->materialName')
           
            
        order by blocklist_no,material_name,create_date
           
            
            ");
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