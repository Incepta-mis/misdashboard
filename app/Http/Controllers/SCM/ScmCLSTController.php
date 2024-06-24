<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/21/2018
 * Time: 3:44 PM
 */

namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScmCLSTController extends Controller
{
    public function index(){

        return view('scm_portal/CL_statement');
    }

    public function CLstatementData(Request $request){
        if($request->ajax()) {
//             $resp_data = DB::select("select * 
// from
// (select c.lc_no,to_char(c.lc_date,'DD-MON-RRRR') lc_date,
//         c.inv_no,to_char(c.inv_date,'DD-MON-RRRR') inv_date,TO_CHAR(c.crtf_date,'DD-MON-RR') crtf_date,rate,currency,
//         c.sl,c.plant,c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,TO_CHAR(c.created_at,'DD-MON-RRRR') created_at
// from mis.scm_clearance c
// where to_char(created_at,'DD/MM/RRRR') = ?
// order by lc_no,inv_no,sl,plant ) a, (select distinct TO_CHAR(blocklist_date,'DD-MON-RRRR') blocklist_date,blocklist_no from mis.scm_blocklist_material) b
// where a.blocklist_no = b.blocklist_no", [$request->cl_date]);
            
             /*$resp_data = DB::select("select *
                from
                (select c.lc_no,to_char(c.lc_date,'DD-MON-RRRR') lc_date,
                c.inv_no,to_char(c.inv_date,'DD-MON-RRRR') inv_date,TO_CHAR(c.crtf_date,'DD-MON-RR') crtf_date,rate,currency,
                c.sl,c.plant,c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,TO_CHAR(c.created_at,'DD-MON-RRRR') created_at
                from mis.scm_clearance c
                where to_char(created_at,'DD/MM/RRRR') between ? and ?
                order by lc_no,inv_no,sl,plant ) a, (select distinct TO_CHAR(blocklist_date,'DD-MON-RRRR') blocklist_date,blocklist_no from mis.scm_blocklist_material) b
                where a.blocklist_no = b.blocklist_no", [$request->cl_date,$request->en_dt]);*/
              $resp_data = DB::select("select *
                from
                (select c.lc_no,to_char(c.lc_date,'DD-MON-RRRR') lc_date,
                c.inv_no,to_char(c.inv_date,'DD-MON-RRRR') inv_date,TO_CHAR(c.crtf_date,'DD-MON-RR') crtf_date,rate,currency,CASE 
                    WHEN currency =  'USD' THEN CASE 
                                                    WHEN nvl(rate,0) <> 0 THEN round(nvl(qty * rate * 85.1,0),2)                                   
                                                ELSE 0
                                                END 
                    WHEN currency =  'EUR' THEN CASE 
                                                    WHEN nvl(rate,0) <> 0 THEN round(nvl(qty * rate * 96.53,0),2)                                    
                                                ELSE 0
                                                END 
                    WHEN currency =  'GBP' THEN CASE 
                                                     WHEN nvl(rate,0) <> 0 THEN round(nvl(qty * rate * 109.73,0),2) 
                                                ELSE 0
                                                END 
                    WHEN currency =  'JPY' THEN CASE 
                                                     WHEN nvl(rate,0) <> 0 THEN round(nvl(qty * rate * 0.81,0),2) 
                                                ELSE 0
                                                END 
                    WHEN currency =  'SEK' THEN CASE 
                                                     WHEN nvl(rate,0) <> 0 THEN round(nvl(qty * rate * 8.98,0),2) 
                                                ELSE 0
                                                END 
                                                
                                                
                    WHEN currency =  'CAD' THEN CASE 
                                                     WHEN nvl(rate,0) <> 0 THEN round(nvl(qty * rate * 67.52,0),2) 
                                                ELSE 0
                                                END 
                    
                ELSE 0
                end bdt,                        
                c.sl,c.plant,c.blocklist_no,c.material_name,c.manufacturer_name,c.qty,c.uom,TO_CHAR(c.created_at,'DD-MON-RRRR') created_at
                from mis.scm_clearance c
                where to_char(created_at,'DD/MM/RRRR') between ? and ?
                order by lc_no,inv_no,sl,plant ) a, (select distinct TO_CHAR(blocklist_date,'DD-MON-RRRR') blocklist_date,blocklist_no from mis.scm_blocklist_material) b
                where a.blocklist_no = b.blocklist_no", [$request->cl_date,$request->en_dt]);
            return response()->json($resp_data);
        }
    }
}