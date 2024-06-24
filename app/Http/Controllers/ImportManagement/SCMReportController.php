<?php

namespace App\Http\Controllers\ImportManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SCMReportController extends Controller
{
    public function capex_report(){
        $poData = DB::select('SELECT distinct PO_NUM from SCM_MATERIAL_MANAGEMENT WHERE PO_NUM IS NOT NULL ORDER BY PO_NUM');
        $prData = DB::select('SELECT distinct PR_NUM from SCM_MATERIAL_MANAGEMENT WHERE PR_NUM IS NOT NULL ORDER BY PR_NUM');
        $lineItem = DB::select('SELECT distinct LINE_ITEM from SCM_MATERIAL_MANAGEMENT WHERE LINE_ITEM IS NOT NULL ORDER BY LINE_ITEM');
        $lcNo = DB::select('SELECT distinct LC_NUMBER from SCM_MATERIAL_MANAGEMENT WHERE LC_NUMBER IS NOT NULL ORDER BY LC_NUMBER');
        $concernPerson = DB::select('SELECT ID,NAME from CONCERN_PERSON_SCM ORDER BY NAME');
        $plants = DB::select("select distinct plant_id, plant_name from hrms.plant_info@web_to_hrms order by plant_id");
        $currency_rate = DB::select("select id,currency,rate from mis.currency_rate order by currency");
        $type_of_doc = DB::select("select id,type_of_doc from mis.type_of_document order by type_of_doc");
        $vendors = DB::select("select * from mis.VENDOR_MASTER_DATA WHERE VALID = 'YES' order by NAME");
        $agents = DB::select("select * from mis.AGENT_MASTER_DATA order by LOCAL_AGENT");
        return view('import_portal.capexReport',compact('plants','poData','prData','lineItem','lcNo','concernPerson','currency_rate','type_of_doc','vendors','agents'));
    }
    public function finance_report(){
        $plants = DB::select("select distinct plant_id, plant_name from hrms.plant_info@web_to_hrms order by plant_id");
        $poData = DB::select('SELECT distinct PO_NUM from SCM_MATERIAL_MANAGEMENT WHERE PO_NUM IS NOT NULL ORDER BY PO_NUM');
        $lineItem = DB::select('SELECT distinct LINE_ITEM from SCM_MATERIAL_MANAGEMENT WHERE LINE_ITEM IS NOT NULL ORDER BY LINE_ITEM');
        $lcNo = DB::select('SELECT distinct LC_NUMBER from SCM_MATERIAL_MANAGEMENT WHERE LC_NUMBER IS NOT NULL ORDER BY LC_NUMBER');
        return view('import_portal.financeReport',compact('plants','poData','lineItem','lcNo'));
    }
    public function retrieveFinanceReport(Request $request){
        $product_type = $request->product_type;
        $plant = $request->plant;
        $po_num = $request->po_num;
        $lc_num = $request->lc_num;
        $line_item = $request->line_item;
        $amount = $request->amount;

        if($product_type == 'capex'){
            $qry = "SELECT a.bank_name,a.currency,a.pr_num,a.lc_date,a.mat_heading,a.mat_desc,a.vendor_name,a.bank_deli_date,a.pi_num,a.pi_date,
                b.* FROM MIS.SCM_MATERIAL_MANAGEMENT a INNER JOIN SCM_FINANCE_MANAGEMENT b ON a.id = b.scm_mat_row_id 
                WHERE a.type_of_doc = 'CAPITAL' AND";
        }else{
            $qry = "SELECT a.bank_name,a.currency,a.pr_num,a.lc_date,a.mat_heading,a.mat_desc,a.vendor_name,a.bank_deli_date,a.pi_num,a.pi_date,
                b.* FROM MIS.SCM_MATERIAL_MANAGEMENT a INNER JOIN SCM_FINANCE_MANAGEMENT b ON a.id = b.scm_mat_row_id 
                WHERE a.type_of_doc in ('RAW','PACK','LAB','SERVICE','SPARE') AND";
        }

        if($plant != ''){
            $qry .= " b.PLANT = decode ('$plant','All',b.PLANT,'$plant') AND";
        }

        if($po_num != ''){
            $qry .= " b.PO_NUM = decode ('$po_num','All',b.PO_NUM,'$po_num') AND";
        }

        if($line_item != ''){
            $qry .= " b.LINE_ITEM = decode ('$line_item','All',b.LINE_ITEM,'$line_item') AND";
        }

        if($lc_num != ''){
            $qry .= " b.LC_NUMBER = decode ('$lc_num','All',b.LC_NUMBER,'$lc_num') AND";
        }

        if($amount != ''){
            $qry .= " b.PI_VALUE = '$amount' AND";
        }

        $qry= preg_replace('/\W\w+\s*(\W*)$/', '$1', $qry);

        $data = DB::SELECT($qry);

        foreach ($data as $value){
            if($value->bank_name != NULL){
                $bank_id = $value->bank_name;
                $bank = DB::select("SELECT * FROM MIS.BANK_INFORMATION WHERE ID = '$bank_id'");
                $value->bank_name = $bank[0]->bank_name;
            }
            if($value->currency != NULL){
                $currency = $value->currency;
                $currData = DB::select("SELECT * FROM MIS.CURRENCY_RATE WHERE CURRENCY = '$currency'");
                $value->currency_rate = $currData[0]->rate;
            }else{
                $value->currency_rate = '';
            }
        }

        return response()->json(['result'=>$data,'product_type'=>$product_type]);
    }
}
