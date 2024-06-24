<?php

namespace App\Http\Controllers\SCM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlockListApplicationReportController extends Controller
{
    public function index(){

        $cmp_data = DB::select("
            select distinct app_id,plant,create_user,get_scm_company_name(plant) company_name, to_char(create_date,'dd-mon-rr') app_date
            from mis.scm_app_blocklist
            where blocklist_no is null
            order by app_id desc
        ");

        $shipping_period = DB::select("
            select to_char(sysdate, 'YYYY') ||'-'|| (to_char(sysdate, 'YYYY') + 1)  shipping_period from dual
            union all   
            select to_char(sysdate, 'YYYY')-1 ||'-'|| (to_char(sysdate, 'YYYY') )  shipping_period from dual                        
        ");

        $signature = DB::select(" select emp_id,emp_name from mis.scm_signature_info order by sl");

        return view('scm_portal/BL_application_report', [
            'cmp_data' => $cmp_data,
            'shipping_period'=> $shipping_period,
            'signature'=> $signature
        ]); 
    }

    public function blockList_Apply_certificate(Request $request){

        Log::info($request->all());


        $pl = DB::select("
            select distinct plant
            from mis.scm_app_blocklist
            where app_id = '$request->app_id'
        ");

        $plant = $pl[0]->plant;

        $rs = DB::select("
            select *
            from mis.scm_company_info
            where plant = '$plant'
        ");



        $applicationData = DB::SELECT("
select  line_id, app_id, bl_type, sl_no, blocklist_year,blocklist_date, plant, blocklist_no,material_name, manufacturer_name, supplier_name,qty_uom,
in_word,  cf_price, cfp,  qimplyer, qapplyer, qrequired,air_price,road_price, sea_price,currency,(qty * tt_taka) tt_taka,
qty_finish_product, create_date, create_user,update_date, update_user, updated_at

from(


select line_id, app_id, bl_type, sl_no, blocklist_year,blocklist_date, plant, blocklist_no,material_name, manufacturer_name, supplier_name,qty_uom,
in_word, (currency_symbol ||''|| price) cf_price, cfp, ((nvl(qty,0) * 3) ||' '|| uom) qimplyer,((nvl(qty,0) / 2) ||' '|| uom)  qapplyer,((nvl(qty,0) * 5) ||' '|| uom) qrequired,
air_price,road_price, sea_price,currency,qty,
CASE 
    WHEN currency =  'USD' THEN CASE 
                                    WHEN nvl(air_price,0) <> 0 THEN nvl(air_price * 85.1,0)
                                    WHEN nvl(road_price,0) <> 0 THEN nvl(road_price * 85.1,0)
                                    WHEN nvl(sea_price,0) <> 0 THEN nvl(sea_price * 85.1,0)
                                ELSE 0
                                END 
    WHEN currency =  'EUR' THEN CASE 
                                    WHEN nvl(air_price,0) <> 0 THEN nvl(air_price * 96.53,0)
                                    WHEN nvl(road_price,0) <> 0 THEN nvl(road_price * 96.53,0)
                                    WHEN nvl(sea_price,0) <> 0 THEN nvl(sea_price * 96.53,0)
                                ELSE 0
                                END 
    WHEN currency =  'GBP' THEN CASE 
                                    WHEN nvl(air_price,0) <> 0 THEN nvl(air_price * 109.73,0)
                                    WHEN nvl(road_price,0) <> 0 THEN nvl(road_price * 109.73,0)
                                    WHEN nvl(sea_price,0) <> 0 THEN nvl(sea_price * 109.73,0)
                                ELSE 0
                                END 
    WHEN currency =  'JPY' THEN CASE 
                                    WHEN nvl(air_price,0) <> 0 THEN nvl(air_price * 0.81,0)
                                    WHEN nvl(road_price,0) <> 0 THEN nvl(road_price * 0.81,0)
                                    WHEN nvl(sea_price,0) <> 0 THEN nvl(sea_price * 0.81,0)
                                ELSE 0
                                END 
    WHEN currency =  'SEK' THEN CASE 
                                    WHEN nvl(air_price,0) <> 0 THEN nvl(air_price * 8.98,0)
                                    WHEN nvl(road_price,0) <> 0 THEN nvl(road_price * 8.98,0)
                                    WHEN nvl(sea_price,0) <> 0 THEN nvl(sea_price * 8.98,0)
                                ELSE 0
                                END 
                                
                                
    WHEN currency =  'CAD' THEN CASE 
                                    WHEN nvl(air_price,0) <> 0 THEN nvl(air_price * 67.52,0)
                                    WHEN nvl(road_price,0) <> 0 THEN nvl(road_price * 67.52,0)
                                    WHEN nvl(sea_price,0) <> 0 THEN nvl(sea_price * 67.52,0)
                                ELSE 0
                                END 
    
ELSE 0
end tt_taka,
  qty_finish_product, create_date, create_user,update_date, update_user, updated_at

from
(

select line_id, app_id,bl_type, sl_no, blocklist_year,blocklist_date, plant, blocklist_no,material_name, manufacturer_name, 
supplier_name,(qty||' '||uom) qty_uom, (mis.spell_number(qty) ||' '|| uom )in_word, cfp,qty,uom,
CASE 
    WHEN nvl(air_price,0) <> 0 THEN concat('A/',nvl(air_price,0))
    WHEN nvl(road_price,0) <> 0 THEN concat('R/',nvl(road_price,0))
    WHEN nvl(sea_price,0) <> 0 THEN concat('S/',nvl(sea_price,0))
ELSE ''
END price , 
CASE 
    WHEN currency =  'USD' THEN 'US$'
    WHEN currency =  'EUR' THEN 'EUR'
    WHEN currency =  'GBP' THEN 'GBP'
    WHEN currency =  'YEN' THEN 'YEN'
    WHEN currency =  'AUD' THEN 'AU$'
    WHEN currency =  'CAD' THEN 'CA$'
    WHEN currency =  'SKE' THEN 'SKE'
    WHEN currency =  'CHF' THEN 'CHF'
    WHEN currency =  'SIN' THEN 'SIN$'
    
ELSE ''
END currency_symbol ,
 air_price,road_price, sea_price,
currency,qty_finish_product, create_date, create_user,update_date, update_user, updated_at

from mis.scm_app_blocklist
where app_id =  '$request->app_id'
)
)
order by sl_no
        ");

        $signature =  DB::SELECT("
            select * from mis.scm_signature_info where emp_id = '$request->signature_id'
        ");

        $shipping = $request->shipping_period;


        $pdf = \PDF::loadView('scm_portal/Reports/blockList_apply_certificate',
            compact('signature','shipping','rs','applicationData'))
            ->setPaper('legal', 'landscape');
        return $pdf->stream('Application_certificate.pdf');
    }
}