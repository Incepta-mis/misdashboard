<?php

namespace App\Http\Controllers\ImportManagement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class MaterialPurchaseInfoController extends Controller
{
    public function index(){
        $poData = DB::select('SELECT distinct ID,PO_NUM from SCM_MATERIAL_PURCHASE_INFO WHERE PO_NUM IS NOT NULL ORDER BY PO_NUM');
        $prData = DB::select('SELECT distinct ID,PR_NUM from SCM_MATERIAL_PURCHASE_INFO WHERE PR_NUM IS NOT NULL ORDER BY PR_NUM');
        $plants = DB::select("select distinct plant_id, plant_name from hrms.plant_info@web_to_hrms order by plant_id");
        $companyData = DB::select("select distinct com_id,com_name from hrms.company_info@WEB_TO_HRMS order by com_id ");
        $currency_rate = DB::select("select id,currency,rate from mis.currency_rate order by currency");
        $type_of_doc = DB::select("select id,type_of_doc from mis.type_of_document order by type_of_doc");
        $concern_person = DB::select("select id,name from mis.concern_person_scm order by name");
        $bank_info = DB::select("select id,bank_name from mis.bank_information order by bank_name");
        $insu_info = DB::select("select id,insurance_name from mis.insurance_information order by insurance_name");
        $lc_type = DB::select("select id,lc_type from mis.types_of_lc order by lc_type");
        $c_and_f = DB::select("select id,c_and_f from mis.c_and_f order by c_and_f");

        return view('import_portal.mat_purchase_info',compact('c_and_f','lc_type','insu_info','bank_info','poData','prData','plants','companyData','currency_rate','type_of_doc','concern_person'));
    }
    public function getLatestPoPrList(){
        $poData = DB::select('SELECT distinct ID,PO_NUM from SCM_MATERIAL_PURCHASE_INFO WHERE PO_NUM IS NOT NULL ORDER BY PO_NUM');
        $prData = DB::select('SELECT distinct ID,PR_NUM from SCM_MATERIAL_PURCHASE_INFO WHERE PR_NUM IS NOT NULL ORDER BY PR_NUM');
        return response()->json(['poData'=>$poData, 'prData' => $prData]);
    }
    public function saveMaterialData(Request $request){
        $insert = $request->fdata;
        $user_id = Auth::user()->user_id;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $agent_email = $insert['agent_email'];
        $agent_name = $insert['agent_name'];
        $agent_num = $insert['agent_num'];
        $awb_or_bl_date = isset($insert['awb_or_bl_date']) ? Carbon::parse(trim($insert['awb_or_bl_date']))->format('Y-m-d') : "";
        $bank_delivery_date = isset($insert['bank_delivery_date']) ? Carbon::parse(trim($insert['bank_delivery_date']))->format('Y-m-d') : "";
        $bank_name = strtoupper($insert['bank_name']);
        $bill_of_entry_date = isset($insert['bill_of_entry_date']) ? Carbon::parse(trim($insert['bill_of_entry_date']))->format('Y-m-d') : "";
        $bill_of_entry_num = $insert['bill_of_entry_num'];
        $blocklist_status = $insert['blocklist_status'];
        $bnk_sndng_or_acptnce_dt = isset($insert['bnk_sndng_or_acptnce_dt']) ? Carbon::parse(trim($insert['bnk_sndng_or_acptnce_dt']))->format('Y-m-d') : "";
        $c_and_f = strtoupper($insert['c_and_f']);
        $c_and_f_date = isset($insert['c_and_f_date']) ? Carbon::parse(trim($insert['c_and_f_date']))->format('Y-m-d') : "";
        $cer_date = isset($insert['cer_date']) ? Carbon::parse(trim($insert['cer_date']))->format('Y-m-d') : "";
        $concern_person = strtoupper($insert['concern_person']);
        if($insert['currency']!=""){
            $currencyArr = explode('-',$insert['currency']);
            $currency = $currencyArr[0];
        }else{
            $currency = "";
        }
        $delivery_date = isset($insert['delivery_date']) ? Carbon::parse(trim($insert['delivery_date']))->format('Y-m-d') : "";
        $description = $insert['description'];
        $drug = $insert['drug'];
        $final_pi_received_date = isset($insert['final_pi_received_date']) ? Carbon::parse(trim($insert['final_pi_received_date']))->format('Y-m-d') : "";
        $freight = $insert['freight'];
        $hawb_no = $insert['hawb_no'];
        $hs_code = $insert['hs_code'];
        $insurance_name = strtoupper($insert['insurance_name']);
        $insurance_num = $insert['insurance_num'];
        $invoice_num = $insert['invoice_num'];
        $lc_date = isset($insert['lc_date']) ? Carbon::parse(trim($insert['lc_date']))->format('Y-m-d') : "";
        $lc_num = $insert['lc_num'];
        $lds_date = isset($insert['lds_date']) ? Carbon::parse(trim($insert['lds_date']))->format('Y-m-d') : "";
        $local_agent = $insert['local_agent'];
        $manufacturer_name = $insert['manufacturer_name'];
        $mat_code = $insert['mat_code'];
        $mat_desc = $insert['mat_desc'];
        $material_arrival_date = isset($insert['material_arrival_date']) ? Carbon::parse(trim($insert['material_arrival_date']))->format('Y-m-d') : "";
        $mawb_tr_or_bl_no = $insert['mawb_tr_or_bl_no'];
        $note_sheet_receiving_date = isset($insert['note_sheet_receiving_date']) ? Carbon::parse(trim($insert['note_sheet_receiving_date']))->format('Y-m-d') : "";
        $order_qty = $insert['order_qty'];
        $order_unit = $insert['order_unit'];
        $passing_days = $insert['passing_days'];
        $pi_date = isset($insert['pi_date']) ? Carbon::parse(trim($insert['pi_date']))->format('Y-m-d') : "";
        $pi_no = $insert['pi_no'];
        $pi_req_send_date = isset($insert['pi_req_send_date']) ? Carbon::parse(trim($insert['pi_req_send_date']))->format('Y-m-d') : "";
        $pi_req_send_or_correction = $insert['pi_req_send_or_correction'];
        $pi_value = $insert['pi_value'];
        $plant = $insert['plant'];
        $po_num = $insert['po_num'];
        $policy = $insert['policy'];
        $pr_date = isset($insert['pr_date']) ? Carbon::parse(trim($insert['pr_date']))->format('Y-m-d') : "";
        $pr_num = $insert['pr_num'];
        $receive_from_bank_date = isset($insert['receive_from_bank_date']) ? Carbon::parse(trim($insert['receive_from_bank_date']))->format('Y-m-d') : "";
        $received_date_of_pi_and_indent = isset($insert['received_date_of_pi_and_indent']) ? Carbon::parse(trim
        ($insert['received_date_of_pi_and_indent']))->format('Y-m-d') : "";
        $receiver_email = $insert['receiver_email'];
        $receiver_name = $insert['receiver_name'];
        $release_hs_code = $insert['release_hs_code'];
        $remarks = $insert['remarks'];
        $req_for_open_lc_tt_cad_date = isset($insert['req_for_open_lc_tt_cad_date']) ? Carbon::parse(trim($insert['req_for_open_lc_tt_cad_date']))->format('Y-m-d') : "";
        $sent_to_open_lc_tt_cad_dt = isset($insert['sent_to_open_lc_tt_cad_dt']) ? Carbon::parse(trim($insert['sent_to_open_lc_tt_cad_dt']))->format('Y-m-d') : "";
        $ship_or_org_doc_rcved_dt = isset($insert['ship_or_org_doc_rcved_dt']) ? Carbon::parse(trim($insert['ship_or_org_doc_rcved_dt']))->format('Y-m-d') : "";
        $shipment_mode = $insert['shipment_mode'];
        $status = $insert['status'];
        $tentative_revd_month = $insert['tentative_revd_month'];
        $tracking_num = $insert['tracking_num'];
        $type_of_doc = $insert['type_of_doc'];
        $type_of_lc = strtoupper($insert['type_of_lc']);
        $unit_price = $insert['unit_price'];
        $vendor_name = $insert['vendor_name'];
        $vendor_or_indenter_name = $insert['vendor_or_indenter_name'];
        $acceptance_date = isset($insert['acceptance_date']) ? Carbon::parse(trim($insert['acceptance_date']))->format('Y-m-d') : "";
        $acceptance_value = $insert['acceptance_value'];
        $acceptance_value_in_bdt = $insert['acceptance_value_in_bdt'];
        $com_or_plant = $insert['com_or_plant'];
        $country_of_origin = $insert['country_of_origin'];
        $division = $insert['division'];
        $due_month = $insert['due_month'];
        $draft_ship_doc_rcv_date = isset($insert['draft_ship_doc_rcv_date']) ? Carbon::parse(trim($insert['draft_ship_doc_rcv_date']))->format('Y-m-d') : "";
        $final_ship_doc_rcv_date = isset($insert['final_ship_doc_rcv_date']) ? Carbon::parse(trim($insert['final_ship_doc_rcv_date']))->format('Y-m-d') : "";
        $due_date_actu = isset($insert['due_date_actu']) ? Carbon::parse(trim($insert['due_date_actu']))->format('Y-m-d') : "";
        $final_ship_doc_received = $insert['final_ship_doc_received'];
        $lc_open_date = isset($insert['lc_open_date']) ? Carbon::parse(trim($insert['lc_open_date']))->format('Y-m-d') : "";
        $lc_open_month = $insert['lc_open_month'];
        $lc_open_status = $insert['lc_open_status'];
        $lc_open_year = $insert['lc_open_year'];
        $lc_tt_cad_share = $insert['lc_tt_cad_share'];
        $lc_type_trs = $insert['lc_type_trs'];
        $mat_rcv_status = $insert['mat_rcv_status'];
        $month = $insert['month'];
        $payment_date = isset($insert['payment_date']) ? Carbon::parse(trim($insert['payment_date']))->format('Y-m-d') : "";
        $payment_status = $insert['payment_status'];
        $payment_term = $insert['payment_term'];
        $pi_decision_date = isset($insert['pi_decision_date']) ? Carbon::parse(trim($insert['pi_decision_date']))->format('Y-m-d') : "";
        $pmt_mon = $insert['pmt_mon'];
        $shipment_value = $insert['shipment_value'];
        $tentative_due_month = isset($insert['tentative_due_month']) ? Carbon::parse(trim($insert['tentative_due_month']))->format('Y-m-d') : "";
        $terms_of_payment = $insert['terms_of_payment'];
        $year = $insert['year'];
        $send_for_endorsemnt_date = isset($insert['send_for_endorsemnt_date']) ? Carbon::parse(trim($insert['send_for_endorsemnt_date']))->format('Y-m-d') : "";
        $bdt_value = $insert['bdt_value'];
        $bdt_in_million = $insert['bdt_in_million'];

        try {
            if($insert['po_num'] == "" && $insert['pr_num'] == ""){
                return response()->json(['status'=>0, 'result' => 'Please input either a PR number, or a PO number, or both']);
            }else{
                $result =  DB::insert("insert into MIS.SCM_MATERIAL_PURCHASE_INFO ( PO_NUM,PR_NUM,PR_DATE,PLANT,DESCRIPTION,NOTE_SHEET_RECEIVING_DATE,PI_VALUE,CURRENCY,TYPE_OF_DOC,CER_DATE,TRACKING_NUM,VENDOR_NAME,LOCAL_AGENT,AGENT_NAME,AGENT_NUM,AGENT_EMAIL,RECEIVER_NAME,RECEIVER_EMAIL,CONCERN_PERSON,PI_REQ_SEND_OR_CORRECTION,PI_REQ_SEND_DATE,FINAL_PI_RECEIVED_DATE,REQ_FOR_OPEN_LC_TT_CAD_DATE,MAT_CODE,MAT_DESC,VENDOR_OR_INDENTER_NAME,MANUFACTURER_NAME,ORDER_QTY,ORDER_UNIT,PI_NO,PI_DATE,UNIT_PRICE,FREIGHT,BLOCKLIST_STATUS,SHIPMENT_MODE,HS_CODE,SENT_TO_OPEN_LC_TT_CAD_DT,RECEIVED_DATE_OF_PI_AND_INDENT,BANK_NAME,INSURANCE_NAME,INSURANCE_NUM,BANK_DELIVERY_DATE,TYPE_OF_LC,LC_NUM,LC_DATE,LDS_DATE,TENTATIVE_REVD_MONTH,SHIP_OR_ORG_DOC_RCVED_DT,PASSING_DAYS,MAWB_TR_OR_BL_NO,HAWB_NO,AWB_OR_BL_DATE,MATERIAL_ARRIVAL_DATE,BNK_SNDNG_OR_ACPTNCE_DT,RECEIVE_FROM_BANK_DATE,C_AND_F,C_AND_F_DATE,INVOICE_NUM,REMARKS,RELEASE_HS_CODE,BILL_OF_ENTRY_NUM,BILL_OF_ENTRY_DATE,DRUG,POLICY,STATUS,DELIVERY_DATE,ACCEPTANCE_DATE,ACCEPTANCE_VALUE,ACCEPTANCE_VALUE_IN_BDT,COM_OR_PLANT,COUNTRY_OF_ORIGIN,DIVISION,DUE_MONTH,DRAFT_SHIP_DOC_RCV_DATE,DUE_DATE_ACTU,FINAL_SHIP_DOC_RECEIVED,FINAL_SHIP_DOC_RCV_DATE,LC_OPEN_DATE,LC_OPEN_MONTH,LC_OPEN_STATUS,LC_OPEN_YEAR,LC_TT_CAD_SHARE,LC_TYPE_TRS,MAT_RCV_STATUS,MONTH,PAYMENT_DATE,PAYMENT_STATUS,PAYMENT_TERM, PI_DECISION_DATE,PMT_MON,SHIPMENT_VALUE,TENTATIVE_DUE_MONTH,TERMS_OF_PAYMENT,YEAR,SEND_FOR_ENDORSEMNT_DATE,BDT_VALUE,BDT_IN_MILLION,CREATED_AT,CREATED_BY) values ('".$po_num."','".$pr_num."','".$pr_date."','".$plant."','".$description."','".$note_sheet_receiving_date."','".$pi_value."','".$currency."','".$type_of_doc."','".$cer_date."','".$tracking_num."','".$vendor_name."','".$local_agent."','".$agent_name."','".$agent_num."','".$agent_email."','".$receiver_name."','".$receiver_email."','".$concern_person."','".$pi_req_send_or_correction."','".$pi_req_send_date."','".$final_pi_received_date."','".$req_for_open_lc_tt_cad_date."','".$mat_code."','".$mat_desc."','".$vendor_or_indenter_name."','".$manufacturer_name."','".$order_qty."','".$order_unit."','".$pi_no."','".$pi_date."','".$unit_price."','".$freight."','".$blocklist_status."','".$shipment_mode."','".$hs_code."','".$sent_to_open_lc_tt_cad_dt."','".$received_date_of_pi_and_indent."','".$bank_name."','".$insurance_name."','".$insurance_num."','".$bank_delivery_date."','".$type_of_lc."','".$lc_num."','".$lc_date."','".$lds_date."','".$tentative_revd_month."','".$ship_or_org_doc_rcved_dt."','".$passing_days."','".$mawb_tr_or_bl_no."','".$hawb_no."','".$awb_or_bl_date."','".$material_arrival_date."','".$bnk_sndng_or_acptnce_dt."','".$receive_from_bank_date."','".$c_and_f."','".$c_and_f_date."','".$invoice_num."','".$remarks."','".$release_hs_code."','".$bill_of_entry_num."','".$bill_of_entry_date."','".$drug."','".$policy."','".$status."','".$delivery_date."','".$acceptance_date."','".$acceptance_value."','".$acceptance_value_in_bdt."','".$com_or_plant."','".$country_of_origin."','".$division."','".$due_month."','".$draft_ship_doc_rcv_date."','".$due_date_actu."','".$final_ship_doc_received."','".$final_ship_doc_rcv_date."','".$lc_open_date."','".$lc_open_month."','".$lc_open_status."','".$lc_open_year."','".$lc_tt_cad_share."','".$lc_type_trs."','".$mat_rcv_status."','".$month."','".$payment_date."','".$payment_status."','".$payment_term."','".$pi_decision_date."','".$pmt_mon."','".$shipment_value."','".$tentative_due_month."','".$terms_of_payment."','".$year."','".$send_for_endorsemnt_date."','".$bdt_value."','".$bdt_in_million."','".$today."','".$user_id."')");
                return response()->json(['status'=>1, 'result' => $result]);
            }
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function updateMaterialData(Request $request){
        $insert = $request->fdata;
        $user_id = Auth::user()->user_id;
        $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $tblRowId = $insert['tblRowId'];

        $agent_email = $insert['agent_email'];
        $agent_name = $insert['agent_name'];
        $agent_num = $insert['agent_num'];
        $awb_or_bl_date = isset($insert['awb_or_bl_date']) ? Carbon::parse(trim($insert['awb_or_bl_date']))->format('Y-m-d') : "";
        $bank_delivery_date = isset($insert['bank_delivery_date']) ? Carbon::parse(trim($insert['bank_delivery_date']))->format('Y-m-d') : "";
        $bank_name = strtoupper($insert['bank_name']);
        $bill_of_entry_date = isset($insert['bill_of_entry_date']) ? Carbon::parse(trim($insert['bill_of_entry_date']))->format('Y-m-d') : "";
        $bill_of_entry_num = $insert['bill_of_entry_num'];
        $blocklist_status = $insert['blocklist_status'];
        $bnk_sndng_or_acptnce_dt = isset($insert['bnk_sndng_or_acptnce_dt']) ? Carbon::parse(trim($insert['bnk_sndng_or_acptnce_dt']))->format('Y-m-d') : "";
        $c_and_f = strtoupper($insert['c_and_f']);
        $c_and_f_date = isset($insert['c_and_f_date']) ? Carbon::parse(trim($insert['c_and_f_date']))->format('Y-m-d') : "";
        $cer_date = isset($insert['cer_date']) ? Carbon::parse(trim($insert['cer_date']))->format('Y-m-d') : "";
        $concern_person = strtoupper($insert['concern_person']);
        if($insert['currency']!=""){
            $currencyArr = explode('-',$insert['currency']);
            $currency = $currencyArr[0];
        }else{
            $currency = "";
        }
        $delivery_date = isset($insert['delivery_date']) ? Carbon::parse(trim($insert['delivery_date']))->format('Y-m-d') : "";
        $description = $insert['description'];
        $drug = $insert['drug'];
        $final_pi_received_date = isset($insert['final_pi_received_date']) ? Carbon::parse(trim($insert['final_pi_received_date']))->format('Y-m-d') : "";
        $freight = $insert['freight'];
        $hawb_no = $insert['hawb_no'];
        $hs_code = $insert['hs_code'];
        $insurance_name = strtoupper($insert['insurance_name']);
        $insurance_num = $insert['insurance_num'];
        $invoice_num = $insert['invoice_num'];
        $lc_date = isset($insert['lc_date']) ? Carbon::parse(trim($insert['lc_date']))->format('Y-m-d') : "";
        $lc_num = $insert['lc_num'];
        $lds_date = isset($insert['lds_date']) ? Carbon::parse(trim($insert['lds_date']))->format('Y-m-d') : "";
        $local_agent = $insert['local_agent'];
        $manufacturer_name = $insert['manufacturer_name'];
        $mat_code = $insert['mat_code'];
        $mat_desc = $insert['mat_desc'];
        $material_arrival_date = isset($insert['material_arrival_date']) ? Carbon::parse(trim($insert['material_arrival_date']))->format('Y-m-d') : "";
        $mawb_tr_or_bl_no = $insert['mawb_tr_or_bl_no'];
        $note_sheet_receiving_date = isset($insert['note_sheet_receiving_date']) ? Carbon::parse(trim($insert['note_sheet_receiving_date']))->format('Y-m-d') : "";
        $order_qty = $insert['order_qty'];
        $order_unit = $insert['order_unit'];
        $passing_days = $insert['passing_days'];
        $pi_date = isset($insert['pi_date']) ? Carbon::parse(trim($insert['pi_date']))->format('Y-m-d') : "";
        $pi_no = $insert['pi_no'];
        $pi_req_send_date = isset($insert['pi_req_send_date']) ? Carbon::parse(trim($insert['pi_req_send_date']))->format('Y-m-d') : "";
        $pi_req_send_or_correction = $insert['pi_req_send_or_correction'];
        $pi_value = $insert['pi_value'];
        $plant = $insert['plant'];
        $po_num = $insert['po_num'];
        $policy = $insert['policy'];
        $pr_date = isset($insert['pr_date']) ? Carbon::parse(trim($insert['pr_date']))->format('Y-m-d') : "";
        $pr_num = $insert['pr_num'];
        $receive_from_bank_date = isset($insert['receive_from_bank_date']) ? Carbon::parse(trim($insert['receive_from_bank_date']))->format('Y-m-d') : "";
        $received_date_of_pi_and_indent = isset($insert['received_date_of_pi_and_indent']) ? Carbon::parse(trim
        ($insert['received_date_of_pi_and_indent']))->format('Y-m-d') : "";
        $receiver_email = $insert['receiver_email'];
        $receiver_name = $insert['receiver_name'];
        $release_hs_code = $insert['release_hs_code'];
        $remarks = $insert['remarks'];
        $req_for_open_lc_tt_cad_date = isset($insert['req_for_open_lc_tt_cad_date']) ? Carbon::parse(trim($insert['req_for_open_lc_tt_cad_date']))->format('Y-m-d') : "";
        $sent_to_open_lc_tt_cad_dt = isset($insert['sent_to_open_lc_tt_cad_dt']) ? Carbon::parse(trim($insert['sent_to_open_lc_tt_cad_dt']))->format('Y-m-d') : "";
        $ship_or_org_doc_rcved_dt = isset($insert['ship_or_org_doc_rcved_dt']) ? Carbon::parse(trim($insert['ship_or_org_doc_rcved_dt']))->format('Y-m-d') : "";
        $shipment_mode = $insert['shipment_mode'];
        $status = $insert['status'];
        $tentative_revd_month = $insert['tentative_revd_month'];
        $tracking_num = $insert['tracking_num'];
        $type_of_doc = $insert['type_of_doc'];
        $type_of_lc = strtoupper($insert['type_of_lc']);
        $unit_price = $insert['unit_price'];
        $vendor_name = $insert['vendor_name'];
        $vendor_or_indenter_name = $insert['vendor_or_indenter_name'];
        $acceptance_date = isset($insert['acceptance_date']) ? Carbon::parse(trim($insert['acceptance_date']))->format('Y-m-d') : "";
        $acceptance_value = $insert['acceptance_value'];
        $acceptance_value_in_bdt = $insert['acceptance_value_in_bdt'];
        $com_or_plant = $insert['com_or_plant'];
        $country_of_origin = $insert['country_of_origin'];
        $division = $insert['division'];
        $due_month = $insert['due_month'];
        $draft_ship_doc_rcv_date = isset($insert['draft_ship_doc_rcv_date']) ? Carbon::parse(trim($insert['draft_ship_doc_rcv_date']))->format('Y-m-d') : "";
        $final_ship_doc_rcv_date = isset($insert['final_ship_doc_rcv_date']) ? Carbon::parse(trim($insert['final_ship_doc_rcv_date']))->format('Y-m-d') : "";
        $due_date_actu = isset($insert['due_date_actu']) ? Carbon::parse(trim($insert['due_date_actu']))->format('Y-m-d') : "";
        $final_ship_doc_received = $insert['final_ship_doc_received'];
        $lc_open_date = isset($insert['lc_open_date']) ? Carbon::parse(trim($insert['lc_open_date']))->format('Y-m-d') : "";
        $lc_open_month = $insert['lc_open_month'];
        $lc_open_status = $insert['lc_open_status'];
        $lc_open_year = $insert['lc_open_year'];
        $lc_tt_cad_share = $insert['lc_tt_cad_share'];
        $lc_type_trs = $insert['lc_type_trs'];
        $mat_rcv_status = $insert['mat_rcv_status'];
        $month = $insert['month'];
        $payment_date = isset($insert['payment_date']) ? Carbon::parse(trim($insert['payment_date']))->format('Y-m-d') : "";
        $payment_status = $insert['payment_status'];
        $payment_term = $insert['payment_term'];
        $pi_decision_date = isset($insert['pi_decision_date']) ? Carbon::parse(trim($insert['pi_decision_date']))->format('Y-m-d') : "";
        $pmt_mon = $insert['pmt_mon'];
        $shipment_value = $insert['shipment_value'];
        $tentative_due_month = isset($insert['tentative_due_month']) ? Carbon::parse(trim($insert['tentative_due_month']))->format('Y-m-d') : "";
        $terms_of_payment = $insert['terms_of_payment'];
        $year = $insert['year'];
        $send_for_endorsemnt_date = isset($insert['send_for_endorsemnt_date']) ? Carbon::parse(trim($insert['send_for_endorsemnt_date']))->format('Y-m-d') : "";
        $bdt_value = $insert['bdt_value'];
        $bdt_in_million = $insert['bdt_in_million'];

        try {
            if($insert['po_num'] == "" && $insert['pr_num'] == ""){
                return response()->json(['status'=>0, 'result' => 'Please input either a PR number, or a PO number, or both']);
            }else{
                if($tblRowId != ""){
                    $qry = DB::SELECT("SELECT * FROM MIS.SCM_MATERIAL_PURCHASE_INFO where id = $tblRowId");
                    if(count($qry) > 0){
                        $result = DB::UPDATE("UPDATE MIS.SCM_MATERIAL_PURCHASE_INFO set PO_NUM = ?,PR_NUM = ?,PR_DATE = ?,PLANT = ?,DESCRIPTION = ?,NOTE_SHEET_RECEIVING_DATE = ?,PI_VALUE = ?,CURRENCY = ?,TYPE_OF_DOC = ?,CER_DATE = ?, TRACKING_NUM = ?,VENDOR_NAME = ?,LOCAL_AGENT = ?,AGENT_NAME = ?,AGENT_NUM = ?,AGENT_EMAIL = ?,RECEIVER_NAME = ?,RECEIVER_EMAIL = ?,CONCERN_PERSON = ?,PI_REQ_SEND_OR_CORRECTION = ?,PI_REQ_SEND_DATE = ?,FINAL_PI_RECEIVED_DATE = ?,REQ_FOR_OPEN_LC_TT_CAD_DATE = ?,MAT_CODE = ?,MAT_DESC = ?,VENDOR_OR_INDENTER_NAME = ?,MANUFACTURER_NAME = ?,ORDER_QTY = ?,ORDER_UNIT = ?,PI_NO = ?,PI_DATE = ?,UNIT_PRICE = ?,FREIGHT = ?,BLOCKLIST_STATUS = ?,SHIPMENT_MODE = ?,HS_CODE = ?,SENT_TO_OPEN_LC_TT_CAD_DT = ?,RECEIVED_DATE_OF_PI_AND_INDENT = ?,BANK_NAME = ?,INSURANCE_NAME = ?,INSURANCE_NUM = ?,BANK_DELIVERY_DATE = ?,TYPE_OF_LC = ?,LC_NUM = ?,LC_DATE = ?,LDS_DATE = ?,TENTATIVE_REVD_MONTH = ?,SHIP_OR_ORG_DOC_RCVED_DT = ?,PASSING_DAYS = ?,MAWB_TR_OR_BL_NO = ?,HAWB_NO = ?,AWB_OR_BL_DATE = ?,MATERIAL_ARRIVAL_DATE = ?,BNK_SNDNG_OR_ACPTNCE_DT = ?,RECEIVE_FROM_BANK_DATE = ?,C_AND_F = ?,C_AND_F_DATE = ?,INVOICE_NUM = ?,REMARKS = ?,RELEASE_HS_CODE = ?,BILL_OF_ENTRY_NUM = ?,BILL_OF_ENTRY_DATE = ?,DRUG = ?,POLICY = ?,STATUS = ?,DELIVERY_DATE = ?,ACCEPTANCE_DATE = ?,ACCEPTANCE_VALUE = ?,ACCEPTANCE_VALUE_IN_BDT = ?,COM_OR_PLANT = ?,COUNTRY_OF_ORIGIN = ?,DIVISION = ?,DUE_MONTH = ?,DRAFT_SHIP_DOC_RCV_DATE = ?,DUE_DATE_ACTU = ?,FINAL_SHIP_DOC_RECEIVED = ?,FINAL_SHIP_DOC_RCV_DATE = ?,LC_OPEN_DATE = ?,LC_OPEN_MONTH = ?,LC_OPEN_STATUS = ?,LC_OPEN_YEAR = ?,LC_TT_CAD_SHARE = ?,LC_TYPE_TRS = ?,MAT_RCV_STATUS = ?,MONTH = ?,PAYMENT_DATE = ?,PAYMENT_STATUS = ?,PAYMENT_TERM = ?, PI_DECISION_DATE = ?,PMT_MON = ?,SHIPMENT_VALUE = ?,TENTATIVE_DUE_MONTH = ?,TERMS_OF_PAYMENT = ?,YEAR = ?,SEND_FOR_ENDORSEMNT_DATE = ?,BDT_VALUE = ?,BDT_IN_MILLION = ?,UPDATED_AT = ?,UPDATED_BY = ? where id = ?", [$po_num,$pr_num,$pr_date,$plant,$description,$note_sheet_receiving_date,$pi_value,$currency,$type_of_doc,$cer_date,$tracking_num,$vendor_name,$local_agent,$agent_name,$agent_num,$agent_email,$receiver_name,$receiver_email,$concern_person,$pi_req_send_or_correction,$pi_req_send_date,$final_pi_received_date,$req_for_open_lc_tt_cad_date,$mat_code,$mat_desc,$vendor_or_indenter_name,$manufacturer_name,$order_qty,$order_unit,$pi_no,$pi_date,$unit_price,$freight,$blocklist_status,$shipment_mode,$hs_code,$sent_to_open_lc_tt_cad_dt,$received_date_of_pi_and_indent,$bank_name,$insurance_name,$insurance_num,$bank_delivery_date,$type_of_lc,$lc_num,$lc_date,$lds_date,$tentative_revd_month,$ship_or_org_doc_rcved_dt,$passing_days,$mawb_tr_or_bl_no,$hawb_no,$awb_or_bl_date,$material_arrival_date,$bnk_sndng_or_acptnce_dt,$receive_from_bank_date,$c_and_f,$c_and_f_date,$invoice_num,$remarks,$release_hs_code,$bill_of_entry_num,$bill_of_entry_date,$drug,$policy,$status,$delivery_date,$acceptance_date,$acceptance_value,$acceptance_value_in_bdt,$com_or_plant,$country_of_origin,$division,$due_month, $draft_ship_doc_rcv_date,$due_date_actu,$final_ship_doc_received,$final_ship_doc_rcv_date,$lc_open_date,$lc_open_month,$lc_open_status, $lc_open_year,$lc_tt_cad_share,$lc_type_trs,$mat_rcv_status,$month,$payment_date,$payment_status,$payment_term,$pi_decision_date,$pmt_mon,$shipment_value,$tentative_due_month,$terms_of_payment,$year,$send_for_endorsemnt_date,$bdt_value,$bdt_in_million,$today,$user_id,$tblRowId]);

                        return response()->json(['status'=>1, 'result' => $result]);
                    }else{
                        return response()->json(['status'=>0, 'result' => 'There is no data available!']);
                    }
                }else{
                    return response()->json(['status'=>0, 'result' => 'Invalid request. Table row number not found!']);
                }
            }
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
    public function retrieveMatPurchaseInfo(Request $request){
        $po_id = $request->po;
        $pr_id = $request->pr;
        try {
            if($po_id != null){
                $qry = DB::SELECT("SELECT * FROM MIS.SCM_MATERIAL_PURCHASE_INFO where id = $po_id");
            }else{
                $qry = DB::SELECT("SELECT * FROM MIS.SCM_MATERIAL_PURCHASE_INFO where id = $pr_id");
            }
            $currency = $qry[0]->currency;
            if($currency != ""){
                $getRate = DB::SELECT("SELECT RATE FROM MIS.CURRENCY_RATE WHERE CURRENCY = '$currency'");
                $qry[0]->currency = $qry[0]->currency."-".$getRate[0]->rate;
            }
            return response()->json(['status'=>1, 'result' => $qry]);
        }catch(Exception $e){
            return response()->json(['status'=>0, 'result' => $e->getMessage()]);
        }
    }
}

