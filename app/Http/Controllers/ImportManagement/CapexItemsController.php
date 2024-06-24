<?php

namespace App\Http\Controllers\ImportManagement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CapexItemsController extends Controller
{
    //capex items
    public function index(){
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
        return view('import_portal.capexItems',compact('plants','poData','prData','lineItem','lcNo','concernPerson','currency_rate','type_of_doc','vendors','agents'));
    }
    public function getCapexSelectItems(){
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
        $countryList = DB::SELECT("SELECT UPPER(COUNTRY_NAME) COUNTRY_NAME FROM EXPO_COUNTRY_LIST WHERE COUNTRY_CODE IS NOT NULL");

        return response()->json(['poData'=>$poData,'prData'=>$prData,'lineItem'=>$lineItem,'lcNo'=>$lcNo,'concernPerson'=>$concernPerson,
            'plants'=>$plants,'currency_rate'=>$currency_rate,'type_of_doc'=>$type_of_doc,'vendors'=>$vendors,'agents'=>$agents,'countryList'=>$countryList]);
    }
    public function getAgentInfo(Request $request){
        $agentId = $request->agent_id;
        $data = DB::select("SELECT * FROM MIS.AGENT_MASTER_DATA WHERE id = '$agentId'");
        return response()->json(['result'=>$data]);
    }
    public function updateCapexData(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalData;
        $finalARr = json_decode($finalARr,true);
        $result = 0;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        try {
            foreach ($finalARr as $arr){
                $CapData = [];
                $CapData['pr_date'] = (isset($arr['pr_date']) && $arr['pr_date'] != '') ? Carbon::parse(trim($arr['pr_date']))->format('Y-m-d') : NULL;
                $CapData['cer_date'] = (isset($arr['cer_date']) && $arr['cer_date'] != '') ? Carbon::parse(trim($arr['cer_date']))->format('Y-m-d') : NULL;
                $CapData['tracking_num'] = $arr['track_no'];
                $CapData['description'] = $arr['descrp'];
                $CapData['pi_value'] = $arr['pi_value'];
                $CapData['currency'] = $arr['currency'];
                $CapData['note_send_date'] = (isset($arr['note_send_date']) && $arr['note_send_date'] != '') ? Carbon::parse(trim($arr['note_send_date']))->format('Y-m-d') : NULL;
                $CapData['priorty'] = $arr['priority'];
                $CapData['note_rcv_date'] = (isset($arr['note_rcv_date']) && $arr['note_rcv_date'] != '') ? Carbon::parse(trim($arr['note_rcv_date']))->format('Y-m-d') : NULL;
                $CapData['po_num'] = $arr['po_num'];
                $CapData['po_value'] = $arr['po_value'];
                $CapData['add_po'] = $arr['add_po'];
                $CapData['type_of_doc'] = strtoupper($arr['type_of_doc']);
                $CapData['mat_heading'] = $arr['mat_heading'];
                $CapData['ship_mode'] = $arr['shipment_mode'];
                $vendorId = $arr['vendor_name'];
                if ($vendorId != '') {
                    $getVendorData = DB::SELECT("SELECT * FROM MIS.VENDOR_MASTER_DATA WHERE id = '$vendorId'");
                    $CapData['vendor_name'] = $getVendorData[0]->name;
                }
                $agentId = $arr['local_agent'];
                if ($agentId != '') {
                    $getAgentData = DB::SELECT("SELECT * FROM MIS.AGENT_MASTER_DATA WHERE id = '$agentId'");
                    $CapData['local_agent'] = $getAgentData[0]->local_agent;
                }
                $CapData['agent_name'] = $arr['agent_name'];
                $CapData['agent_num'] = $arr['agent_num'];
                $CapData['agent_email'] = $arr['agent_email'];
                $CapData['user_rcv_name'] = $arr['rcv_name'];
                $CapData['user_rcv_email'] = $arr['rcv_email'];
                $t_concern_personID = $arr['t_concern_person'];
                if ($t_concern_personID != '') {
                    $getConcernData = DB::SELECT("SELECT * FROM MIS.CONCERN_PERSON_SCM WHERE id = '$t_concern_personID'");
                    $CapData['concern_person'] = $getConcernData[0]->name;
                }
                $CapData['pi_req_send'] = $arr['pi_req_send'];
                $CapData['pi_req_send_date'] = (isset($arr['pi_req_send_date']) && $arr['pi_req_send_date'] != '') ? Carbon::parse(trim($arr['pi_req_send_date']))->format('Y-m-d') : NULL;
                $CapData['final_pi_rcv_date'] = (isset($arr['final_pi_rcv_date']) && $arr['final_pi_rcv_date'] != '') ? Carbon::parse(trim($arr['final_pi_rcv_date']))->format('Y-m-d') : NULL;
                $CapData['req_lc_tt_cad_date'] = (isset($arr['req_for_open_lc_date']) && $arr['req_for_open_lc_date'] != '') ? Carbon::parse(trim($arr['req_for_open_lc_date']))->format('Y-m-d') : NULL;
                $CapData['lc_tt_cad_share'] = $arr['lc_share'];
                $CapData['draft_ship_doc_rcv_date'] = (isset($arr['draft_ship_doc_rcv_date']) && $arr['draft_ship_doc_rcv_date'] != '') ? Carbon::parse(trim
                ($arr['draft_ship_doc_rcv_date']))->format('Y-m-d') : NULL;
                $CapData['final_ship_doc_rcv_date'] = (isset($arr['final_ship_doc_rcved']) && $arr['final_ship_doc_rcved'] != '') ? Carbon::parse(trim
                ($arr['final_ship_doc_rcved']))->format('Y-m-d') : NULL;
                $CapData['send_for_endrsemnt_date'] = (isset($arr['send_endorsement_date']) && $arr['send_endorsement_date'] != '') ? Carbon::parse(trim
                ($arr['send_endorsement_date']))->format('Y-m-d') : NULL;
                $CapData['updated_at'] = $today;
                $CapData['updated_by'] = $uid;

                $result = DB::table('MIS.SCM_MATERIAL_MANAGEMENT')->where('id',$arr['id'])->update($CapData);
            }
            return response()->json(['result'=>$result]);
        }
        catch(Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['result'=>$e->getMessage()]);
        }
    }
    public function saveCapexData(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalData;
        $finalARr = json_decode($finalARr,true);
        $result = 0;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $id = 0;
        try {
            foreach ($finalARr as $arr){
                if($arr['plant'] == '' || $arr['pr_num'] == '' || $arr['line_item'] == ''){
                    $result = 5;
                    $id = $arr['id'];
                    break;
                }
            }
            if($id == 0) {
                foreach ($finalARr as $arr){
                    $CapData = [];
                    $CapData['plant'] = $arr['plant'];
                    $CapData['pr_num'] = $arr['pr_num'];
                    $CapData['line_item'] = $arr['line_item'];
                    $CapData['pr_date'] = (isset($arr['pr_date']) && $arr['pr_date'] != '') ? Carbon::parse(trim
                    ($arr['pr_date']))->format('Y-m-d') : NULL;
                    $CapData['cer_date'] = (isset($arr['cer_date']) && $arr['cer_date'] != '') ? Carbon::parse(trim
                    ($arr['cer_date']))->format
                    ('Y-m-d') : NULL;
                    $CapData['tracking_num'] = $arr['track_no'];
                    $CapData['description'] = $arr['descrp'];
                    $CapData['pi_value'] = $arr['pi_value'];
                    $CapData['currency'] = $arr['currency'];
                    $CapData['note_send_date'] = (isset($arr['note_send_date']) && $arr['note_send_date'] != '') ?
                    Carbon::parse(trim($arr['note_send_date']))->format('Y-m-d') : NULL;
                    $CapData['priorty'] = $arr['priority'];
                    $CapData['note_rcv_date'] = (isset($arr['note_rcv_date']) && $arr['note_rcv_date'] != '') ?
                        Carbon::parse(trim($arr['note_rcv_date']))->format('Y-m-d') : NULL;
                    $CapData['po_num'] = $arr['po_num'];
                    $CapData['po_value'] = $arr['po_value'];
                    $CapData['add_po'] = $arr['add_po'];
                    $CapData['type_of_doc'] = strtoupper($arr['type_of_doc']);
                    $CapData['mat_heading'] = $arr['mat_heading'];
                    $CapData['ship_mode'] = $arr['shipment_mode'];
                    $vendorId = $arr['vendor_name'];
                    if ($vendorId != '') {
                        $getVendorData = DB::SELECT("SELECT * FROM MIS.VENDOR_MASTER_DATA WHERE id = '$vendorId'");
                        $CapData['vendor_name'] = $getVendorData[0]->name;
                    }
                    $agentId = $arr['local_agent'];
                    if ($agentId != '') {
                        $getAgentData = DB::SELECT("SELECT * FROM MIS.AGENT_MASTER_DATA WHERE id = '$agentId'");
                        $CapData['local_agent'] = $getAgentData[0]->local_agent;
                    }
                    $CapData['agent_name'] = $arr['agent_name'];
                    $CapData['agent_num'] = $arr['agent_num'];
                    $CapData['agent_email'] = $arr['agent_email'];
                    $CapData['user_rcv_name'] = $arr['rcv_name'];
                    $CapData['user_rcv_email'] = $arr['rcv_email'];
                    $t_concern_personID = $arr['t_concern_person'];
                    if ($t_concern_personID != '') {
                        $getConcernData = DB::SELECT("SELECT * FROM MIS.CONCERN_PERSON_SCM WHERE id = '$t_concern_personID'");
                        $CapData['concern_person'] = $getConcernData[0]->name;
                    }
                    $CapData['pi_req_send'] = $arr['pi_req_send'];
                    $CapData['pi_req_send_date'] = (isset($arr['pi_req_send_date']) && $arr['pi_req_send_date'] !=
                        '') ? Carbon::parse(trim($arr['pi_req_send_date']))->format('Y-m-d') : NULL;
                    $CapData['final_pi_rcv_date'] = (isset($arr['final_pi_rcv_date']) && $arr['final_pi_rcv_date'] !=
                        '') ? Carbon::parse(trim($arr['final_pi_rcv_date']))->format('Y-m-d') : NULL;
                    $CapData['req_lc_tt_cad_date'] = (isset($arr['req_for_open_lc_date']) && $arr['req_for_open_lc_date'] != '') ? Carbon::parse(trim
                    ($arr['req_for_open_lc_date']))->format('Y-m-d') : NULL;
                    $CapData['lc_tt_cad_share'] = $arr['lc_share'];
                    $CapData['draft_ship_doc_rcv_date'] = (isset($arr['draft_ship_doc_rcv_date']) && $arr['draft_ship_doc_rcv_date'] != '') ? Carbon::parse
                    (trim($arr['draft_ship_doc_rcv_date']))->format('Y-m-d') : NULL;
                    $CapData['final_ship_doc_rcv_date'] = (isset($arr['final_ship_doc_rcved']) && $arr['final_ship_doc_rcved'] != '') ? Carbon::parse(trim
                    ($arr['final_ship_doc_rcved']))->format('Y-m-d') : NULL;
                    $CapData['send_for_endrsemnt_date'] = (isset($arr['send_endorsement_date']) && $arr['send_endorsement_date'] != '') ? Carbon::parse(trim
                    ($arr['send_endorsement_date']))->format('Y-m-d') : NULL;
                    $CapData['created_at'] = $today;
                    $CapData['created_by'] = $uid;

                    $result = DB::table('MIS.SCM_MATERIAL_MANAGEMENT')->insert($CapData);
                }
            }
            return response()->json(['result'=>$result,'id'=>$id]);
        }
        catch(Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['result'=>$e->getMessage(),'id'=>$id]);
        }
    }
    public function retrieveCapexInfo(Request $request){
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

        $plant = $request->plant;
        $po_num = $request->po_num;
        $pr_num = $request->pr_num;
        $line_item = $request->line_item;
        $lc_num = $request->lc_num;
        $concern_person = $request->concern_person;

        $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE";

        if($plant != ''){
            $qry .= " PLANT = decode ('$plant','All',PLANT,'$plant') AND";
        }

        if($po_num != ''){
            $qry .= " PO_NUM = decode ('$po_num','All',PO_NUM,'$po_num') AND";
        }

        if($pr_num != ''){
            $qry .= " PR_NUM = decode ('$pr_num','All',PR_NUM,'$pr_num') AND";
        }

        if($line_item != ''){
            $qry .= " LINE_ITEM = decode ('$line_item','All',LINE_ITEM,'$line_item') AND";
        }

        if($lc_num != ''){
            $qry .= " LC_NUMBER = decode ('$lc_num','All',LC_NUMBER,'$lc_num') AND";
        }
        if($concern_person != ''){
            if($concern_person != 'All'){
                $getConcernData = DB::SELECT("SELECT * FROM MIS.CONCERN_PERSON_SCM WHERE id = '$concern_person'");
                $concernPName = $getConcernData[0]->name;
                $qry .= " CONCERN_PERSON = decode ('$concernPName','All',CONCERN_PERSON,'$concernPName') AND";
            }else{
                $qry .= " CONCERN_PERSON = decode ('All','All',CONCERN_PERSON,'All') AND";
            }
        }

        $qry= preg_replace('/\W\w+\s*(\W*)$/', '$1', $qry);

        $data = DB::SELECT($qry);

        foreach ($data as $value){
            if($value->vendor_name != null){
                $vendorData = DB::SELECT("select * from mis.VENDOR_MASTER_DATA WHERE NAME = '".$value->vendor_name."'");
                $value->vendor_id = $vendorData[0]->id;
            }else{
                $value->vendor_id = null;
            }
            if($value->local_agent != null){
                $AgentData = DB::SELECT("select * from mis.AGENT_MASTER_DATA WHERE LOCAL_AGENT = '".$value->local_agent."'");
                $value->agent_id = $AgentData[0]->id;
            }else{
                $value->agent_id = null;
            }
        }

        return response()->json(['result'=>$data,'poData'=>$poData,'prData'=>$prData,'lineItem'=>$lineItem,'lcNo'=>$lcNo,'concernPerson'=>$concernPerson,
            'plants'=>$plants,'currency_rate'=>$currency_rate,'type_of_doc'=>$type_of_doc,'vendors'=>$vendors,'agents'=>$agents]);
    }

    //raw pack planning
    public function raw_pack_lab_planning(){
        $plants = DB::select("select distinct plant_id, plant_name from hrms.plant_info@web_to_hrms order by plant_id");
        $prData = DB::select('SELECT distinct PR_NUM from SCM_MATERIAL_MANAGEMENT WHERE PR_NUM IS NOT NULL ORDER BY PR_NUM');
        $lineItem = DB::select('SELECT distinct LINE_ITEM from SCM_MATERIAL_MANAGEMENT WHERE LINE_ITEM IS NOT NULL ORDER BY LINE_ITEM');
        $concernPerson = DB::select('SELECT ID,NAME from CONCERN_PERSON_SCM ORDER BY NAME');

        return view('import_portal.rawPackPlanning',compact('plants','prData','lineItem','concernPerson'));
    }
    public function retrieveRawPackInfo(Request $request){
        $concernPerson = DB::select('SELECT ID,NAME from CONCERN_PERSON_SCM ORDER BY NAME');
        $currency_rate = DB::select("select id,currency,rate from mis.currency_rate order by currency");
        $units = DB::select('SELECT ID,TECHNICAL,UNIT_OF_MEASUREMENT_TEXT FROM SCM_UNIT_LIST WHERE UNIT_OF_MEASUREMENT_TEXT IS NOT NULL ORDER BY UNIT_OF_MEASUREMENT_TEXT ASC');
        $manufacturer = DB::select("SELECT ID,CODE,CONCAT(CONCAT(CONCAT(CONCAT(NAME1,' '),NAME2),' '),NAME3) TITLE FROM SCM_MANUFACTURER_LIST 
                                    WHERE NAME1 IS NOT NULL 
                                    ORDER BY NAME1 ASC");
        $supplier = DB::select("SELECT ID,CODE,CONCAT(CONCAT(CONCAT(CONCAT(NAME1,' '),NAME2),' '),NAME3) TITLE FROM SCM_SUPPLIER_LIST 
                                    WHERE NAME1 IS NOT NULL 
                                    ORDER BY NAME1 ASC");

        $plant = $request->plant;
        $pr_num = $request->pr_num;
        $line_item = $request->line_item;
        $indent_num = $request->indent_num;
        $concern_person = $request->concern_person;

        $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE";

        if($plant != ''){
            $qry .= " PLANT = decode ('$plant','All',PLANT,'$plant') AND";
        }

        if($pr_num != ''){
            $qry .= " PR_NUM = decode ('$pr_num','All',PR_NUM,'$pr_num') AND";
        }

        if($line_item != ''){
            $qry .= " LINE_ITEM = decode ('$line_item','All',LINE_ITEM,'$line_item') AND";
        }

        if($indent_num != ''){
            $qry .= " PI_NUM = '$indent_num' AND";
        }

        if($concern_person != ''){
            if($concern_person != 'All'){
                $getConcernData = DB::SELECT("SELECT * FROM MIS.CONCERN_PERSON_SCM WHERE id = '$concern_person'");
                $concernPName = $getConcernData[0]->name;
                $qry .= " CONCERN_PERSON = decode ('$concernPName','All',CONCERN_PERSON,'$concernPName') AND";
            }else{
                $qry .= " CONCERN_PERSON = decode ('All','All',CONCERN_PERSON,'All') AND";
            }
        }

        $qry= preg_replace('/\W\w+\s*(\W*)$/', '$1', $qry);

        $data = DB::SELECT($qry);

        return response()->json(['result'=>$data,'concernPerson'=>$concernPerson,'currency_rate'=>$currency_rate,'units'=>$units,
            'manufacturer'=>$manufacturer,'supplier'=>$supplier]);
    }
    public function updateRawPackData(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalData;
        $finalARr = json_decode($finalARr,true);
        $result = 0;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        try {
            foreach ($finalARr as $arr){
                $CapData = [];
                $t_concern_personID = $arr['concern_person'];
                if ($t_concern_personID != '') {
                    $getConcernData = DB::SELECT("SELECT * FROM MIS.CONCERN_PERSON_SCM WHERE id = '$t_concern_personID'");
                    $CapData['concern_person'] = $getConcernData[0]->name;
                }
                $CapData['mat_code'] = $arr['mat_code'];
                $CapData['mat_desc'] = $arr['mat_desc'];
                $CapData['mat_heading'] = $arr['mat_heading'];
                $CapData['supp_name'] = $arr['supp_name'];
                $CapData['manufac_name'] = $arr['manufac_name'];
                $CapData['order_qty'] = $arr['order_qty'];
                $CapData['unit'] = $arr['unit'];
                $CapData['unit_price'] = $arr['unit_price'];
                $CapData['pi_num'] = $arr['pi_num'];
                $CapData['pi_date'] = (isset($arr['pi_date']) && $arr['pi_date'] != '') ?
                    Carbon::parse(trim($arr['pi_date']))->format('Y-m-d') : NULL;
                $CapData['currency'] = $arr['currency'];
                $CapData['pi_value'] = $arr['pi_value'];
                $CapData['freight'] = $arr['freight'];
                $CapData['blocklist_status'] = $arr['blocklist_status'];
                $CapData['blocklist_num'] = $arr['blocklist_num'];
                $CapData['ship_mode'] = $arr['shipment_mode'];
                $CapData['priorty'] = $arr['priority'];
                $CapData['exp_delivery_date'] = (isset($arr['exp_delivery_date']) && $arr['exp_delivery_date'] != '') ? Carbon::parse(trim($arr['exp_delivery_date']))->format('Y-m-d') : NULL;

                $row__ID = $arr['id'];
                $getData = DB::SELECT("SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE id = '$row__ID'");
                if($getData[0]->send_opn_lc_tt_cad_date == NULL){
                    $CapData['send_opn_lc_tt_cad_date'] = (isset($arr['send_opn_lc_tt_cad_date']) && $arr['send_opn_lc_tt_cad_date'] != '') ? Carbon::parse(trim($arr['send_opn_lc_tt_cad_date']))->format('Y-m-d') : NULL;
                    if( $CapData['send_opn_lc_tt_cad_date'] != NULL){
                        $CapData['opn_lcttcad_date_updated_by'] = $uid;
                    }
                }
                $CapData['updated_at'] = $today;
                $CapData['updated_by'] = $uid;

                $result = DB::table('MIS.SCM_MATERIAL_MANAGEMENT')->where('id',$arr['id'])->update($CapData);
            }
            return response()->json(['result'=>$result]);
        }
        catch(Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['result'=>$e->getMessage()]);
        }
    }

    //LC management
    public function lc_management(){
        $poData = DB::select('SELECT distinct PO_NUM from SCM_MATERIAL_MANAGEMENT WHERE PO_NUM IS NOT NULL ORDER BY PO_NUM');
        $prData = DB::select('SELECT distinct PR_NUM from SCM_MATERIAL_MANAGEMENT WHERE PR_NUM IS NOT NULL ORDER BY PR_NUM');
        $lineItem = DB::select('SELECT distinct LINE_ITEM from SCM_MATERIAL_MANAGEMENT WHERE LINE_ITEM IS NOT NULL ORDER BY LINE_ITEM');

        return view('import_portal.lcManagement',compact('poData','prData','lineItem'));
    }
    public function retrieveRawPackInfoForLC(Request $request){
        $po_num = $request->po_num;
        $pr_num = $request->pr_num;
        $line_item = $request->line_item;
        $indent_num = $request->indent_num;
        $indent_date = $request->indent_date;

        $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE";

        if($po_num != ''){
            $qry .= " PO_NUM = decode ('$po_num','All',PO_NUM,'$po_num') AND";
        }

        if($pr_num != ''){
            $qry .= " PR_NUM = decode ('$pr_num','All',PR_NUM,'$pr_num') AND";
        }

        if($line_item != ''){
            $qry .= " LINE_ITEM = decode ('$line_item','All',LINE_ITEM,'$line_item') AND";
        }

        if($indent_num != ''){
            $qry .= " PI_NUM = '$indent_num' AND";
        }

        if($indent_date != ''){
            $qry .= " PI_DATE = to_date('".Carbon::parse($indent_date)->format('m/d/Y')."','MM/DD/RR') AND";
        }

        $qry= preg_replace('/\W\w+\s*(\W*)$/', '$1', $qry);

        $data = DB::SELECT($qry);

        foreach ($data as $d){
            if($d->exp_delivery_date != NULL){
                $d->exp_delivery_date = Carbon::parse($d->exp_delivery_date)->format('Y-m-d');
            }
            if($d->supp_name != NULL){
                $supp_id = $d->supp_name;
                $supplier = DB::select("SELECT ID,CODE,CONCAT(CONCAT(CONCAT(CONCAT(NAME1,' '),NAME2),' '),NAME3) TITLE FROM SCM_SUPPLIER_LIST 
                                    WHERE NAME1 IS NOT NULL AND ID = '$supp_id'");
                $d->supp_name = $supplier[0]->code." - ".$supplier[0]->title;
            }

        }

        return response()->json(['result'=>$data]);
    }
    function getRawPackInfo(Request $request){
        $row_id = $request->row_id;
        $banks = DB::SELECT("SELECT * FROM MIS.BANK_INFORMATION ORDER BY BANK_NAME ASC");
        $insurances = DB::SELECT("SELECT * FROM MIS.INSURANCE_INFORMATION ORDER BY INSURANCE_NAME ASC");
        $qryData = DB::SELECT("SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE ID = '$row_id'");
        return response()->json(['result'=>$qryData,'banks'=>$banks,'insurances'=>$insurances]);
    }
    public function updateLCData(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalData;
        $finalARr = json_decode($finalARr,true);
        $result = 0;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        try {
            foreach ($finalARr as $arr){
                $CapData = [];

                $CapData['pi_rcv_date'] = (isset($arr['pi_rcv_date']) && $arr['pi_rcv_date'] != '') ?
                    Carbon::parse(trim($arr['pi_rcv_date']))->format('Y-m-d') : NULL;

                $CapData['po_num'] = $arr['t_po_num'];
                $CapData['pay_mode'] = $arr['type_of_pay_mode'];
                $CapData['bank_name'] = $arr['bank_name'];
                $CapData['insurance_name'] = $arr['insurance_name'];
                $CapData['insurance_num'] = $arr['insurance_num'];
                $CapData['bank_deli_date'] = (isset($arr['bank_deli_date']) && $arr['bank_deli_date'] != '') ?
                    Carbon::parse(trim($arr['bank_deli_date']))->format('Y-m-d') : NULL;
                $CapData['lc_number'] = $arr['lc_number'];
                $CapData['hs_code'] = $arr['hs_code'];
                $CapData['remarks'] = $arr['t_remarks'];
                $CapData['lc_date'] = (isset($arr['lc_date']) && $arr['lc_date'] != '') ?
                    Carbon::parse(trim($arr['lc_date']))->format('Y-m-d') : NULL;
                $CapData['lds_date'] = (isset($arr['lds_date']) && $arr['lds_date'] != '') ?
                    Carbon::parse(trim($arr['lds_date']))->format('Y-m-d') : NULL;
                $CapData['expiry_date'] = (isset($arr['expiry_date']) && $arr['expiry_date'] != '') ?
                    Carbon::parse(trim($arr['expiry_date']))->format('Y-m-d') : NULL;

                $CapData['updated_at'] = $today;
                $CapData['updated_by'] = $uid;

                $result = DB::table('MIS.SCM_MATERIAL_MANAGEMENT')->where('id',$arr['id'])->update($CapData);
            }
            return response()->json(['result'=>$result]);
        }
        catch(Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['result'=>$e->getMessage()]);
        }
    }

    //Documentation management
    public function doc_management(){
        return view('import_portal.doc_management');
    }
    public function retrieveAllInfo(Request $request){

        $lc_num = $request->lc_num;

        if($lc_num != '[]'){
            $newLcArr = [];
            $lc_num = json_decode($lc_num,true);
            foreach ($lc_num as $num){
                array_push($newLcArr,"'".$num."'");
            }
            $implodedLc = implode(",",$newLcArr);
            $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE LC_NUMBER IN (".$implodedLc.") ORDER BY LC_NUMBER";
        }else{
            $po_num = $request->po_num;
            $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE PO_NUM = '$po_num'";
        }

        $c_nd_f = DB::SELECT("SELECT * FROM C_AND_F ORDER BY C_AND_F ASC");

        $data = DB::SELECT($qry);

        foreach ($data as $d){
            if($d->bank_name != NULL){
                $bank_id = $d->bank_name;
                $bank = DB::select("SELECT * FROM MIS.BANK_INFORMATION WHERE ID = '$bank_id'");
                $d->bank_name = $bank[0]->bank_name;
            }
            if($d->insurance_name != NULL){
                $insu_id = $d->insurance_name;
                $insu_name = DB::select("SELECT * FROM MIS.INSURANCE_INFORMATION WHERE ID = '$insu_id'");
                $d->insurance_name = $insu_name[0]->insurance_name;
            }
        }
        return response()->json(['result'=>$data,'c_nd_f'=>$c_nd_f]);
    }
    public function updateDocumentData(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalData;
        $finalARr = json_decode($finalARr,true);
        $result = 0;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        try {
            foreach ($finalARr as $arr){
                $CapData = [];

                $CapData['ship_mode'] = $arr['shipment_mode'];
                $CapData['mawb_bl_tr_no'] = $arr['mawb_bl_tr_no'];
                $CapData['mawb_bl_tr_date'] = (isset($arr['mawb_bl_tr_date']) && $arr['mawb_bl_tr_date'] != '') ?
                    Carbon::parse(trim($arr['mawb_bl_tr_date']))->format('Y-m-d') : NULL;
                $CapData['invoice_value'] = $arr['invoice_value'];
                $CapData['bank_send_acc_date'] = (isset($arr['bank_send_acc_date']) && $arr['bank_send_acc_date'] != '') ?
                    Carbon::parse(trim($arr['bank_send_acc_date']))->format('Y-m-d') : NULL;
                $CapData['rcv_from_bank_date'] = (isset($arr['rcv_from_bank_date']) && $arr['rcv_from_bank_date'] != '') ?
                    Carbon::parse(trim($arr['rcv_from_bank_date']))->format('Y-m-d') : NULL;
                $CapData['c_nd_f'] = $arr['c_and_f'];
                $CapData['doc_date'] = (isset($arr['doc_date']) && $arr['doc_date'] != '') ?
                    Carbon::parse(trim($arr['doc_date']))->format('Y-m-d') : NULL;
                $CapData['item'] = $arr['t_item'];

                if($arr['rcv_from_bank_date'] != '' && $arr['passing_days'] != ''){
                    $rowID = $arr['id'];
                    $getData = DB::SELECT("SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE ID = '$rowID'");
                    if($getData[0]->passing_days == ''){
                        $CapData['passing_days'] = $arr['passing_days'];
                    }
                }

                $CapData['doc_remarks'] = $arr['t_remarks'];
                $CapData['deli_date'] = (isset($arr['deli_date']) && $arr['deli_date'] != '') ?
                    Carbon::parse(trim($arr['deli_date']))->format('Y-m-d') : NULL;
                $CapData['updated_at'] = $today;
                $CapData['updated_by'] = $uid;

                $result = DB::table('MIS.SCM_MATERIAL_MANAGEMENT')->where('id',$arr['id'])->update($CapData);
            }
            return response()->json(['result'=>$result]);
        }
        catch(Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['result'=>$e->getMessage()]);
        }
    }

    //duty management
    public function duty_management(){
        return view('import_portal.duty_management');
    }
    public function updateDutyData(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalData;
        $finalARr = json_decode($finalARr,true);
        $result = 0;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        try {
            foreach ($finalARr as $arr){
                $CapData = [];

                $CapData['duty_pay_mode'] = $arr['duty_pay_mode'];
                $CapData['customs_house'] = $arr['customs_house'];
                $CapData['b_e_no'] = $arr['b_e_no'];
                $CapData['b_e_date'] = (isset($arr['b_e_date']) && $arr['b_e_date'] != '') ?
                    Carbon::parse(trim($arr['b_e_date']))->format('Y-m-d') : NULL;
                $CapData['c_nd_f'] = $arr['c_and_f'];
                $CapData['declarant_no'] = $arr['declarant_no'];
                $CapData['duty_amount'] = $arr['duty_amount'];
                $CapData['duty_date'] = (isset($arr['duty_date']) && $arr['duty_date'] != '') ?
                    Carbon::parse(trim($arr['duty_date']))->format('Y-m-d') : NULL;
                $CapData['duty_time'] = $arr['duty_time'];
                $CapData['updated_at'] = $today;
                $CapData['updated_by'] = $uid;

                $result = DB::table('MIS.SCM_MATERIAL_MANAGEMENT')->where('id',$arr['id'])->update($CapData);
            }
            return response()->json(['result'=>$result]);
        }
        catch(Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['result'=>$e->getMessage()]);
        }
    }

    //finance management
    public function finance_management(){
        $plants = DB::select("select distinct plant_id, plant_name from hrms.plant_info@web_to_hrms order by plant_id");
        $poData = DB::select('SELECT distinct PO_NUM from SCM_MATERIAL_MANAGEMENT WHERE PO_NUM IS NOT NULL ORDER BY PO_NUM');
        $lineItem = DB::select('SELECT distinct LINE_ITEM from SCM_MATERIAL_MANAGEMENT WHERE LINE_ITEM IS NOT NULL ORDER BY LINE_ITEM');
        $lcNo = DB::select('SELECT distinct LC_NUMBER from SCM_MATERIAL_MANAGEMENT WHERE LC_NUMBER IS NOT NULL ORDER BY LC_NUMBER');
        return view('import_portal.finance_management',compact('plants','poData','lineItem','lcNo'));
    }
    public function getDataForFinance(Request $request){
        $plant = $request->plant;
        $po_num = $request->po_num;
        $line_item = $request->line_item;
        $lc_num = $request->lc_num;
        $amount = $request->amount;

        $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE";

        if($plant != ''){
            $qry .= " PLANT = decode ('$plant','All',PLANT,'$plant') AND";
        }

        if($po_num != ''){
            $qry .= " PO_NUM = decode ('$po_num','All',PO_NUM,'$po_num') AND";
        }

        if($line_item != ''){
            $qry .= " LINE_ITEM = decode ('$line_item','All',LINE_ITEM,'$line_item') AND";
        }

        if($lc_num != ''){
            $qry .= " LC_NUMBER = decode ('$lc_num','All',LC_NUMBER,'$lc_num') AND";
        }

        if($amount != ''){
            $qry .= " PI_VALUE = '$amount' AND";
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

        return response()->json(['result'=>$data]);
    }
    public function getFinanceInfo(Request $request){
        $row_id = $request->row_id;
        $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE ID = '$row_id'";
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

            $qry1 = "SELECT * FROM MIS.SCM_FINANCE_MANAGEMENT WHERE SCM_MAT_ROW_ID = '$row_id'";
            $data1 = DB::SELECT($qry1);
            if(count($data1) > 0){
                $value->finance_data = $data1;
            }else{
                $value->finance_data = [];
            }
        }
        $countryList = DB::SELECT("SELECT UPPER(COUNTRY_NAME) COUNTRY_NAME FROM EXPO_COUNTRY_LIST WHERE COUNTRY_CODE IS NOT NULL");
        return response()->json(['result'=>$data,'countryList'=>$countryList]);
    }
    public function getFinanceMainRowData(Request $request){
        $main_table_row_id = $request->main_table_row_id;
        $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE ID = '$main_table_row_id'";
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

        $countryList = DB::SELECT("SELECT UPPER(COUNTRY_NAME) COUNTRY_NAME FROM EXPO_COUNTRY_LIST WHERE COUNTRY_CODE IS NOT NULL");
        return response()->json(['result'=>$data,'countryList'=>$countryList]);
    }
     public function updateFinanceData(Request $request){
        $uid = Auth::user()->user_id;
        $finalARr = $request->finalData;
        $finalARr = json_decode($finalARr,true);
        $result = 0;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        try {
            $checkIfexists = DB::table('MIS.SCM_FINANCE_MANAGEMENT')
                ->where('scm_mat_row_id',$finalARr[0]['main_table_row_id'])->get();
            if(count($checkIfexists) > 0){
                DB::table('MIS.SCM_FINANCE_MANAGEMENT')
                    ->where('scm_mat_row_id',$finalARr[0]['main_table_row_id'])
                    ->delete();
            }
            foreach ($finalARr as $arr){
                $FinData = [];
                $FinData['scm_mat_row_id'] = $arr['main_table_row_id'];
                $FinData['pro_type'] = $arr['pro_type'];
                $FinData['plant'] = $arr['plant'];
                $FinData['lc_number'] = (isset($arr['lc_number']) && $arr['lc_number'] != '') ?
                    $arr['lc_number'] : '';
                $FinData['po_num'] = $arr['po_num'];
                $FinData['line_item'] = $arr['line_item'];
                $FinData['pi_dec_date'] = (isset($arr['pi_dec_date']) && $arr['pi_dec_date'] != '') ?
                    Carbon::parse(trim($arr['pi_dec_date']))->format('Y-m-d') : NULL;
                $FinData['origin_country'] = $arr['origin_country'];
                $FinData['com_facility'] = strtoupper($this->removeWhitespaces($arr['com_facility']));
                $FinData['division'] = $arr['division'];
                $FinData['terms_of_pay'] = strtoupper($arr['terms_of_pay']);
                $FinData['pay_terms'] = $arr['pay_terms'];
                $FinData['pi_value'] = $arr['pi_value'];
                $FinData['accept_val'] = $arr['accept_val'];
                $FinData['payment_val'] = $arr['payment_val'];
                $FinData['accept_date'] = (isset($arr['accept_date']) && $arr['accept_date'] != '') ?
                    Carbon::parse(trim($arr['accept_date']))->format('Y-m-d') : NULL;
                $FinData['due_date_actual'] = (isset($arr['due_date_actual']) && $arr['due_date_actual'] != '') ?
                    Carbon::parse(trim($arr['due_date_actual']))->format('Y-m-d') : NULL;
                $FinData['payment_date'] = (isset($arr['payment_date']) && $arr['payment_date'] != '') ?
                    Carbon::parse(trim($arr['payment_date']))->format('Y-m-d') : NULL;
                $FinData['payment_status'] = $arr['payment_status'];

                $main_table_row_id = $arr['main_table_row_id'];
                $qry = "SELECT * FROM MIS.SCM_MATERIAL_MANAGEMENT WHERE ID = '$main_table_row_id'";
                $data = DB::SELECT($qry);
                if($data[0]->currency != NULL){
                    $currency = $data[0]->currency;
                    $currData = DB::select("SELECT * FROM MIS.CURRENCY_RATE WHERE CURRENCY = '$currency'");
                    $currency_rate = $currData[0]->rate;
                }else{
                    $currency_rate = '';
                }
                if( $currency_rate != '' && $arr['accept_val'] != ''){
                    $getAccBDTval =  ((float)$arr['accept_val']*(float)$currency_rate);
                }else{
                    $getAccBDTval = 0.00;
                }
                if( $currency_rate != '' && $arr['pi_value'] != ''){
                    $getBDTval =  ((float)$arr['pi_value']*(float)$currency_rate);
                }else{
                    $getBDTval = 0.00;
                }

                $result = DB::insert('insert into MIS.SCM_FINANCE_MANAGEMENT ( SCM_MAT_ROW_ID, PLANT, LC_NUMBER, PO_NUM, LINE_ITEM, PRO_TYPE, PI_DEC_DATE, 
                                    ORIGIN_COUNTRY, COM_FACILITY, DIVISION, TERMS_OF_PAY, PAY_TERMS, PI_VALUE, ACCEPT_VAL, ACCEPT_DATE, PAYMENT_VAL,
                                    PAYMENT_DATE, DUE_DATE_ACTUAL, ACCEPT_VAL_BDT, PI_VAL_BDT, PAYMENT_STATUS, CREATED_AT, CREATED_BY ) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                    [$FinData['scm_mat_row_id'], $FinData['plant'], $FinData['lc_number'], $FinData['po_num'],
                        $FinData['line_item'], $FinData['pro_type'], $FinData['pi_dec_date'], $FinData['origin_country'], $FinData['com_facility'],
                        $FinData['division'], $FinData['terms_of_pay'], $FinData['pay_terms'], $FinData['pi_value'], $FinData['accept_val'],
                        $FinData['accept_date'],$FinData['payment_val'],$FinData['payment_date'],$FinData['due_date_actual'],$getAccBDTval,$getBDTval,$FinData['payment_status'], $today, $uid]);
            }
            return response()->json(['result'=>$result]);
        }
        catch(Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['result'=>$e->getMessage()]);
        }
    }
    public function removeWhitespaces($sentence){
        return  trim(preg_replace('/\s+/', ' ', $sentence));
    }
}

