<?php

namespace App\Http\Controllers\ImportManagement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SCMMasterDataModificationController extends Controller
{
   public function index(){
       return view('import_portal.scmMasterDataModification');
   }
   public function getSCMMasterData(Request $request){
       $type = $request->type;
       $table_name = "";
       if($type == 'currency'){
           $table_name = 'CURRENCY_RATE';
       }else if($type == 'type_of_doc'){
           $table_name = 'TYPE_OF_DOCUMENT';
       }else if($type == 'concern_person'){
           $table_name = 'CONCERN_PERSON_SCM';
       }else if($type == 'bank_name'){
           $table_name = 'BANK_INFORMATION';
       }else if($type == 'insurance_name'){
           $table_name = 'INSURANCE_INFORMATION';
       }else if($type == 'types_of_lc'){
           $table_name = 'TYPES_OF_LC';
       }else if($type == 'c_and_f'){
           $table_name = 'C_AND_F';
       }else if($type == 'vendor'){
           $table_name = 'VENDOR_MASTER_DATA';
       }else if($type == 'agent'){
           $table_name = 'AGENT_MASTER_DATA';
       }
       if($table_name != ""){
           $result = DB::SELECT("SELECT * FROM MIS.".$table_name." ORDER BY ID");
           return response()->json(['result'=>$result]);
       }else{
           return response()->json(['result'=>[]]);
       }
   }
   public function getVendorMasterData(Request $request){
       $id = $request->id;
       $result = DB::SELECT("SELECT * FROM MIS.VENDOR_MASTER_DATA WHERE id = ".$id." ORDER BY ID");
       return response()->json(['result'=>$result]);
   }
   public function getAgentMasterData(Request $request){
       $id = $request->id;
       $result = DB::SELECT("SELECT * FROM MIS.AGENT_MASTER_DATA WHERE id = ".$id." ORDER BY ID");
       return response()->json(['result'=>$result]);
   }
   public function updateCurrData(Request $request){
       $edit_curr_id = $request->edit_curr_id;
       $edit_rate = $request->edit_rate;
       $edit_curr = strtoupper($request->edit_curr);
       try{
           $result =  DB::UPDATE("UPDATE MIS.CURRENCY_RATE SET CURRENCY = '$edit_curr', RATE = '$edit_rate' WHERE ID = '$edit_curr_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateBankData(Request $request){
       $edit_bank_id = $request->edit_bank_id;
       $edit_bank_add = $request->edit_bank_add;
       $edit_bank_name = strtoupper($request->edit_bank_name);
       try{
           $result =  DB::UPDATE("UPDATE MIS.BANK_INFORMATION SET BANK_NAME = '$edit_bank_name', ADDRESS = '$edit_bank_add' WHERE ID = '$edit_bank_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateDocTypeData(Request $request){
       $edit_doctype = strtoupper($request->edit_doctype);
       $edit_docType_id = $request->edit_docType_id;
       try{
           $result =  DB::UPDATE("UPDATE MIS.TYPE_OF_DOCUMENT SET TYPE_OF_DOC = '$edit_doctype' WHERE ID = '$edit_docType_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateCandFData(Request $request){
       $edit_candf = strtoupper($request->edit_candf);
       $edit_candf_id = $request->edit_candf_id;
       try{
           $result =  DB::UPDATE("UPDATE MIS.C_AND_F SET C_AND_F = '$edit_candf' WHERE ID = '$edit_candf_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateLCTypeData(Request $request){
       $edit_lctype = strtoupper($request->edit_lctype);
       $edit_lcType_id = $request->edit_lcType_id;
       try{
           $result =  DB::UPDATE("UPDATE MIS.TYPES_OF_LC SET LC_TYPE = '$edit_lctype' WHERE ID = '$edit_lcType_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateInsuNameData(Request $request){
       $edit_insu_name = strtoupper($request->edit_insu_name);
       $edit_insu_name_id = $request->edit_insu_name_id;
       try{
           $result =  DB::UPDATE("UPDATE MIS.INSURANCE_INFORMATION SET INSURANCE_NAME = '$edit_insu_name' WHERE ID = '$edit_insu_name_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateConcernPersonData(Request $request){
       $edit_concernPName = strtoupper($request->edit_concernPName);
       $edit_concernP_id = $request->edit_concernP_id;
       try{
           $result =  DB::UPDATE("UPDATE MIS.CONCERN_PERSON_SCM SET NAME = '$edit_concernPName' WHERE ID = '$edit_concernP_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateVendorData(Request $request){
       $edit_ven_name = str_replace("'","''",strtoupper($request->edit_ven_name));
       $edit_ven_valid = strtoupper($request->edit_ven_valid);
       $edit_ven_code = $request->edit_ven_code;
       $edit_ven_add = str_replace("'","''",$request->edit_ven_add);
       $edit_vendor_id = $request->edit_vendor_id;
       try{
           $result =  DB::UPDATE("UPDATE MIS.VENDOR_MASTER_DATA SET NAME = '$edit_ven_name', 
                                  CODE = '$edit_ven_code', ADDRESS = '$edit_ven_add', 
                                  VALID = '$edit_ven_valid' WHERE ID = '$edit_vendor_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function updateAgentData(Request $request){
       $edit_local_agent = str_replace("'","''",strtoupper($request->edit_local_agent));
       $edit_concern_name = strtoupper($request->edit_concern_name);
       $edit_mob_no = $request->edit_mob_no;
       $edit_email = strtolower($request->edit_email);
       $edit_agent_id = $request->edit_agent_id;
       try{
           $result =  DB::UPDATE("UPDATE MIS.AGENT_MASTER_DATA SET LOCAL_AGENT = '$edit_local_agent', 
                                  CONCERN_NAME = '$edit_concern_name', MOB_NO = '$edit_mob_no', 
                                  EMAIL = '$edit_email' WHERE ID = '$edit_agent_id'");
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteCurrData(Request $request){
       $edit_curr_id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.CURRENCY_RATE WHERE ID = ?',[$edit_curr_id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteBankData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.BANK_INFORMATION WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteDocTypeData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.TYPE_OF_DOCUMENT WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteCandFData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.C_AND_F WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteLCTypeData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.TYPES_OF_LC WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteInsuNameData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.INSURANCE_INFORMATION WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteConcernPersonData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.CONCERN_PERSON_SCM WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteVendorData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.VENDOR_MASTER_DATA WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function deleteAgentData(Request $request){
       $id = $request->id;
       try{
           $result =  DB::DELETE('DELETE FROM MIS.AGENT_MASTER_DATA WHERE ID = ?',[$id]);
           return response()->json(['status'=>1,'result'=>$result]);
       }catch (\Exception $e){
           return response()->json(['status'=>0,'result'=>$e->getMessage()]);
       }
   }
   public function addCurrData(Request $request){
       $add_curr = strtoupper($request->add_curr);
       $add_rate = $request->add_rate;
       $user_id = Auth::user()->user_id;
       $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

       $maxId = DB::select("SELECT max(id)+1 max_id FROM MIS.CURRENCY_RATE");
       if($maxId[0]->max_id == null){
           $max_id = 1;
       }else{
           $max_id = $maxId[0]->max_id;
       }
       try {
           $result =  DB::insert("INSERT INTO MIS.CURRENCY_RATE ( ID,CURRENCY,RATE,CREATED_AT,CREATED_BY) values (".$max_id.",'".$add_curr."','".$add_rate."','".$today."','".$user_id."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addBankData(Request $request){
       $add_bank_name = strtoupper($request->add_bank_name);
       $add_bank_add = $request->add_bank_add;
       $user_id = Auth::user()->user_id;
       $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

       $maxId = DB::select("SELECT max(id)+1 max_id FROM MIS.BANK_INFORMATION");
       if($maxId[0]->max_id == null){
           $max_id = 1;
       }else{
           $max_id = $maxId[0]->max_id;
       }
       try {
           $result =  DB::insert("INSERT INTO MIS.BANK_INFORMATION ( ID,BANK_NAME,ADDRESS,CREATED_AT,CREATED_BY) values ("
               .$max_id.",'".$add_bank_name."','".$add_bank_add."','".$today."','".$user_id."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addDocTypeData(Request $request){
       $add_docType = strtoupper($request->add_docType);
       $user_id = Auth::user()->user_id;
       $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

       $maxId = DB::select("SELECT max(id)+1 max_id FROM MIS.TYPE_OF_DOCUMENT");
       if($maxId[0]->max_id == null){
           $max_id = 1;
       }else{
           $max_id = $maxId[0]->max_id;
       }

       try {
           $result =  DB::insert("INSERT INTO MIS.TYPE_OF_DOCUMENT ( ID,TYPE_OF_DOC,CREATED_AT,CREATED_BY) values (".$max_id.",'".$add_docType."','".$today."','".$user_id."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addCandFData(Request $request){
       $add_candf = strtoupper($request->add_candf);
       $user_id = Auth::user()->user_id;
       $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

       $maxId = DB::select("SELECT max(id)+1 max_id FROM MIS.C_AND_F");
       if($maxId[0]->max_id == null){
           $max_id = 1;
       }else{
           $max_id = $maxId[0]->max_id;
       }

       try {
           $result =  DB::insert("INSERT INTO MIS.C_AND_F ( ID,C_AND_F,CREATED_AT,CREATED_BY) values (".$max_id.",'".$add_candf."','".$today."','".$user_id."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addLCTypeData(Request $request){
       $add_lcType = strtoupper($request->add_lcType);
       $user_id = Auth::user()->user_id;
       $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

       $maxId = DB::select("SELECT max(id)+1 max_id FROM MIS.TYPES_OF_LC");
       if($maxId[0]->max_id == null){
           $max_id = 1;
       }else{
           $max_id = $maxId[0]->max_id;
       }

       try {
           $result =  DB::insert("INSERT INTO MIS.TYPES_OF_LC ( ID,LC_TYPE,CREATED_AT,CREATED_BY) values (".$max_id.",'".$add_lcType."','".$today."','".$user_id."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addInsuNameData(Request $request){
       $add_insu_name = strtoupper($request->add_insu_name);
       $user_id = Auth::user()->user_id;
       $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

       $maxId = DB::select("SELECT max(id)+1 max_id FROM MIS.INSURANCE_INFORMATION");
       if($maxId[0]->max_id == null){
           $max_id = 1;
       }else{
           $max_id = $maxId[0]->max_id;
       }

       try {
           $result =  DB::insert("INSERT INTO MIS.INSURANCE_INFORMATION ( ID,INSURANCE_NAME,CREATED_AT,CREATED_BY) values (".$max_id.",'".$add_insu_name."','".$today."','".$user_id."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addConcernPersonData(Request $request){
       $add_concernPerson = strtoupper($request->add_concernPerson);
       $user_id = Auth::user()->user_id;
       $today = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

       $maxId = DB::select("SELECT max(id)+1 max_id FROM MIS.CONCERN_PERSON_SCM");
       if($maxId[0]->max_id == null){
           $max_id = 1;
       }else{
           $max_id = $maxId[0]->max_id;
       }

       try {
           $result =  DB::insert("INSERT INTO MIS.CONCERN_PERSON_SCM ( ID,NAME,CREATED_AT,CREATED_BY) values (".$max_id
               .",'".$add_concernPerson."','".$today."','".$user_id."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addVendorData(Request $request){
       $add_ven_name = str_replace("'","''",strtoupper($request->add_ven_name));
       $add_ven_code = $request->add_ven_code;
       $add_ven_add = str_replace("'","''",$request->add_ven_add);
       $add_ven_valid = strtoupper($request->add_ven_valid);
       try {
           $result =  DB::insert("INSERT INTO MIS.VENDOR_MASTER_DATA (NAME,CODE,ADDRESS,VALID) values ('".$add_ven_name."','".$add_ven_code."','".$add_ven_add."','".$add_ven_valid."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
   public function addAgentData(Request $request){
       $add_local_agent = str_replace("'","''",strtoupper($request->add_local_agent));
       $add_concern_name = strtoupper($request->add_concern_name);
       $add_mob_no = $request->add_mob_no;
       $add_agent_email = strtolower($request->add_agent_email);
       try {
           $result =  DB::insert("INSERT INTO MIS.AGENT_MASTER_DATA (LOCAL_AGENT,CONCERN_NAME,MOB_NO,EMAIL) values ('".$add_local_agent."','".$add_concern_name."','".$add_mob_no."','".$add_agent_email."')");
           return response()->json(['status'=>1, 'result' => $result]);
       }catch(Exception $e){
           return response()->json(['status'=>0, 'result' => $e->getMessage()]);
       }
   }
}
