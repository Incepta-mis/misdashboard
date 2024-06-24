<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2019
 * Time: 4:30 PM
 */

namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use App\ScmAvailableQtyClear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScmBLSTUController extends Controller
{
    public function index()
    {
        $rs_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        return view('scm_portal/BL_statement_update', ['cmp_data' => $rs_data]);
    }

    public function plantBlockList(Request $request){
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct blocklist_no
                    from mis. scm_blocklist_material
                    where plant = ?
                    order by blocklist_no asc", [$request->plant]);
            return response()->json($resp_data);
        }
    }

    public function statementGetData(Request $request){
        if ($request->ajax()) {

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
                            
) ",
                [$request->plant, $request->plant, $request->blList, $request->blList
                    , $request->plant, $request->plant]);
            return response()->json($resp_data);
        }
    }

    public function postMaterialData(Request $request){
        if($request->ajax()){

            $blist = $request->blkListNO;
            $TaxIds = $request->matQty;
            $TaxIds = array_map(function($elem) { return floatval($elem); }, $TaxIds);

            
            foreach($request->matData as $key =>$value){
//                    $x =  ScmBlockListMaterial::where('blocklist_no',$blist)
//                    ->where('material_name',$value)
//                    ->decrement('QTY', $TaxIds[$key]);

                $sequence = DB::getSequence();
                $r_id = $sequence->nextValue('MIS.SCM_CLR_SQE');

                if ($TaxIds[$key] > 0){
                    $dataArray = [
                        'R_ID'  => $r_id,
                        'BLOCKLIST_NO'  => $blist,
                        'MATERIAL_NAME' => $value,
                        'CLEAR_QTY'     => $TaxIds[$key],
                        'CREATE_USER'   => Auth::user()->user_id
                    ];
                    $x = ScmAvailableQtyClear::insert($dataArray);
                }
            }

            if($x){
                return response()->json(['success' => 'Change Successfully']);
            }else {
                return response()->json(['error' => 'Data Base Error Contact your administrator']);
            }


        }
    }

    public function get_clearQty(Request $request){

        $resp_data = DB::select("
                            select to_char(created_at,'DD-MON-RR') clear_dt, clear_qty 
                            from mis.scm_available_qty_clear
                            where blocklist_no = ?
                            and material_name = ?
                            ",[$request->blklist_no,$request->mat_name]);
        return response()->json($resp_data);
//        return response()->json($request->all());
    }



}