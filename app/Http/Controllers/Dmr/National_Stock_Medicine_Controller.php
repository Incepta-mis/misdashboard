<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 1/26/2020
 * Time: 1:10 PM
 */

namespace App\Http\Controllers\Dmr;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class National_Stock_Medicine_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $tid = Auth::user()->terr_id;



//        return view('dmr.national_stock_medicine')->with(['product' =>$stock]);
            return view('dmr.national_stock_medicine');

    }

    public function data(Request $request){

        $stock = DB::select("
        
                     select ci.compnay_code company_code,ci.comany_name company_name,pi.material_number sap_code,pi.brand_name name,pi.pack_s,pi.p_group,s.*
                        from
                        (select *
                        from   (select ds.p_code,short_name,qty_stock
                        from   sample_new.daily_stock@web_to_sample_msd ds)
                        pivot  (sum(qty_stock) for (short_name) in ('ASH' ASH,'BBR' BBR,'BOG' BOG,'BSL' BSL,'COM' COM,'COX' COX,'CTG' CTG,'CTGS' CTGS,'DHK' DHK,'DHKS' DHKS,
                        'DNP' DNP,'FNI' FNI,'JSR' JSR,'KHL' KHL,'MAG' MAG,'MOU' MOU,'MPUR' MPUR,'MYM' MYM,
                        'NAR' NAR,'NOA' NOA,'PAB' PAB,'RAJ' RAJ,'RAN' RAN,'SLT' SYL,'TNG' TNG,'CHAD' CHAD,'GAZI' GAZI,'KUS' KUS,'CWH' CWH,'FAC' FAC))
                        ) s,dwh.product_info_m@web_to_ipldw2 pi,dwh.os_sales_organization_info@web_to_ipldw2 soc,
                        dwh.os_sales_area_info@web_to_ipldw2 sac,dwh.os_company_info@web_to_ipldw2 ci
                        where s.p_code = pi.p_code
                        and pi.sales_area_code = sac.sales_area_code
                        and sac.sales_org_code = soc.sales_org_code
                        and soc.company_code = ci.compnay_code 
                        
 
                                     ");

        return response()->json($stock);
    }

}