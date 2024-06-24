<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/17/2018
 * Time: 2:31 PM
 */

namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScmBLSTController extends Controller
{
    public function index()
    {
        $rs_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        return view('scm_portal/BL_statement', ['cmp_data' => $rs_data]);
    }

    public function materialName(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("select distinct material_name
                    from mis. scm_blocklist_material
                    where plant = ?
                    order by material_name asc", [$request->plant]);
            return response()->json($resp_data);
        }
    }

    public function statementData(Request $request)
    {
        if ($request->ajax()) {
            $resp_data = DB::Select("

                select blocklist_year,blocklist_date,plant,blocklist_no,material_name,
                            manufacturer_name,supplier_name,qty,(avl_qty -   mis.scm_avl_matqty(blocklist_no,material_name)) avl_qty ,uom,out_qty,out_uom,air_price,road_price,sea_price,currency
from(  

select a.blocklist_year,to_char(a.blocklist_date,'DD-MON-RR') blocklist_date,a.plant,a.blocklist_no,a.material_name,
                            a.manufacturer_name,a.supplier_name,a.qty,
                            
                                      (  case when b.out_uom = 'GM'  then  nvl((a.qty-(b.out_qty*0.001)),0) 
                                              when b.out_uom = 'PCS' then nvl((a.qty-b.out_qty),0)
                                              when b.out_uom = 'MG'  then  nvl((a.qty-(b.out_qty*1000000)),0)  
                                              when b.out_uom = 'MT'  then  nvl((a.qty-(b.out_qty*1000)),0)


                                              --when b.out_uom = 'MG'  then  nvl((a.qty-(b.out_qty*1000000)),0)  
                                              --when b.out_uom = 'MT'  then  nvl((a.qty-(b.out_qty*1000)),0)
                                              else nvl(a.qty,0)-nvl(b.out_qty,0)
                                      end ) avl_qty                
                            
                            ,a.uom, nvl(b.out_qty,0) out_qty,b.out_uom,a.air_price,a.road_price,a.sea_price,a.currency      
                            from 
                            (select distinct blocklist_year,blocklist_date,plant,blocklist_no,material_name,manufacturer_name,supplier_name,qty,uom,air_price,road_price,sea_price,currency
                            from mis. scm_blocklist_material
                            where plant = ?
                            order by material_name asc) a ,(select plant,blocklist_no,material_name,sum(qty) out_qty,uom out_uom from mis.scm_clearance where plant = ? group by plant,blocklist_no,material_name,uom order by material_name asc) b
                            where a.plant = b.plant (+)
                            and a.blocklist_no   =   b.blocklist_no (+)
                            and a.material_name   = b.material_name (+)
                            and a.material_name = decode(?,'All',a.material_name,?)
                            and a.plant = decode(?,'All',a.plant,?) )",
                [$request->plant, $request->plant, $request->matName, $request->matName
                    , $request->plant, $request->plant]);
            return response()->json($resp_data);
        }

//       return response()->json($request->all());

    }
}