<?php

namespace App\Http\Controllers\SCM;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseRequisitionController extends Controller
{
    public function index(){
        return view("scm_portal/pr_req_raw_mat");
    }
    public function req_for_raw_mat_update(){
        $req_data = DB::select("SELECT distinct plant_id FROM MIS.SCM_PR_RQ_RAW_MAT_UP order by plant_id asc");
        return view("scm_portal/req_for_raw_mat_update",['req_data'=>$req_data]);
    }
    public function downloadFile(){
        $file = storage_path("app/public/sample_files/rawMaterials.xlsx");
        return response()->download($file);
    }
    public function getMatGroups(Request $request){
        $plant_id = $request->plant_id;
        $data = DB::SELECT("SELECT DISTINCT a.MATERIAL_GROUP || ' - ' || b.DESCRIPTION MATERIAL_GROUP FROM MIS.SCM_PR_RQ_RAW_MAT_UP a INNER JOIN MIS.SCM_SAP_MATERIAL_GROUP b on a.MATERIAL_GROUP = b.MATERIAL_GROUP
WHERE a.PLANT_ID = decode ('$plant_id','All',a.PLANT_ID,'$plant_id') ORDER BY MATERIAL_GROUP ASC");
        return response()->json($data);
    }

    public function getReqReport(Request $request){

        $plant_id = $request->plant_id;
        $mat_group = $request->mat_group;

        $qry = "SELECT id, plant_id, purch_req, material, material_desc, material_group, quantity, unit, categories,to_char(req_date,'DD-MON-RR') req_date,delivery_date, requisnr, 
         tracking_no, created_at, updated_at, create_user, update_user FROM MIS.SCM_PR_RQ_RAW_MAT_UP WHERE ";
        if($plant_id != ''){
            $qry .= "PLANT_ID = decode ('$plant_id','All',PLANT_ID,'$plant_id') ";
        }
        if($plant_id != '' && $mat_group != ''){
            $qry .= ' AND ';
        }
        if($mat_group != ''){
            $mat = explode(' - ',$mat_group);
            $mat_group = $mat[0];
            $qry .= "MATERIAL_GROUP = decode ('$mat_group','All',MATERIAL_GROUP,'$mat_group')";
        }
        $data = DB::SELECT($qry);
        return response()->json($data);
    }
    public function qtyUpdate(Request $request)
    {
        $purchreq = $request->purchreq;
        $material = $request->material;
        $qty = $request->qty;
        $row_index = $request->row_index;

        $updateQry = DB::update("UPDATE MIS.SCM_PR_RQ_RAW_MAT_UP set QUANTITY = ? WHERE PURCH_REQ = ? AND MATERIAL = ?",
            [$qty , $purchreq, $material]);
        $response =  array('status'=> $updateQry, 'eleID'=>'#row_Idx_'.$row_index, 'quantity'=>$qty);

        return response()->json($response);
    }
    public function uploadRawMaterialList(Request $request){
        $uid = Auth::user()->user_id;
        $auth_name = Auth::user()->name;

        $file_name = Input::file('upload_file');
        $date = Carbon::now()->format('Y-m-d H:m:s');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if($validator_empty->fails()) {
            return Redirect::to('scm_portal/purchase_req_for_raw_mat')->withErrors($validator_empty);
        }else if($validator_empty->passes()) {
            $ext = strtolower($file_name->getClientOriginalExtension());
            $validator = Validator::make(
                array('ext' => $ext),
                array('ext' => 'in:xls,xlsx')
            );
            if ($validator->fails()) {
                $notification = array(
                    'message' => 'Please Upload excel file!',
                    'alert-type' => 'error'
                );
                return Redirect::to('scm_portal/purchase_req_for_raw_mat')->withErrors($validator)->with($notification);
            } else if ($validator->passes()) {
                $doc_id = DB::select("SELECT MAX(DOC_ID) max_id FROM MIS.SCM_PR_RQ_RAW_MAT_UP");
                if($doc_id == null){
                    $max_id = 1;
                }else{
                    $max_id = $doc_id[0]->max_id;
                    $max_id++;
                }

                $data = Excel::load($file_name, function ($reader) { })->get();

                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {
                        $uniqueData[] = [
                            'purch_req' => trim($value->purch_req),
                            'material' => trim($value->material)
                        ];
                        $insert[] = [
                            'plant_id' => trim($value->plant),
                            'purch_req' => trim($value->purch_req),
                            'material' => trim($value->material),
                            'material_desc' => trim($value->material_description),
                            'material_group' => trim($value->material_group),
                            'quantity' => trim($value->quantity),
                            'unit' => trim($value->unit),
                            'categories' => trim($value->categories),
                            'req_date' => Carbon::parse(trim($value->requsition_date))->format('Y-m-d'),
                            'delivery_date' => Carbon::parse(trim($value->delivery_dt))->format('Y-m-d'),
                            'requisnr' => trim($value->requisnr),
                            'tracking_no' => trim($value->tracking_no)
                        ];
                    }
                    if (!empty($insert)) {
                        $count = count($insert);
                        $unique = array_map("unserialize", array_unique(array_map("serialize", $uniqueData)));
                        if($count > count($unique)){
                            $notification = array(
                                'message' => 'Duplicate data found in the excel file!',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('scm_portal/purchase_req_for_raw_mat')->with($notification);
                        }else{
                            try {

                                $dup = array();

                                foreach ($insert as $k => $row) {

                                    $purch_req = $row['purch_req'];
                                    $material = $row['material'];

                                    $unqData = DB::SELECT("SELECT * FROM SCM_PR_RQ_RAW_MAT_UP WHERE PURCH_REQ = '$purch_req' AND MATERIAL = '$material'");

                                    if(count($unqData) > 0){
                                        $temp = array();
                                        $temp['plant_id'] = $row['plant_id'];
                                        $temp['purch_req'] = $row['purch_req'];
                                        $temp['material'] = $row['material'];
                                        $temp['material_desc'] = $row['material_desc'];
                                        $temp['material_group'] = $row['material_group'];
                                        $temp['quantity'] = $row['quantity'];
                                        $temp['unit'] = $row['unit'];
                                        $temp['categories'] = $row['categories'];
                                        $temp['req_date'] = $row['req_date'];
                                        $temp['delivery_date'] = $row['delivery_date'];
                                        $temp['requisnr'] = $row['requisnr'];
                                        $temp['tracking_no'] = $row['tracking_no'];
                                        array_push($dup,$temp);
                                    }
                                }
                                if(count($dup) > 0){
                                    $notification = array(
                                        'message' => "Data could not be uploaded!",
                                        'alert-type' => 'error',
                                        'dup_data' => json_encode($dup)
                                    );
                                }else{
                                    foreach ($insert as $k => $row) {
                                        DB::insert('insert into MIS.SCM_PR_RQ_RAW_MAT_UP ( PLANT_ID, PURCH_REQ, MATERIAL, MATERIAL_DESC, MATERIAL_GROUP, QUANTITY, UNIT, CATEGORIES, REQ_DATE,
                                          DELIVERY_DATE, REQUISNR, TRACKING_NO, CREATED_AT, CREATE_USER, DOC_ID) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$row['plant_id'], $row['purch_req'], $row['material'],
                                            $row['material_desc'], $row['material_group'], $row['quantity'],
                                            $row['unit'], $row['categories'], $row['req_date'], $row['delivery_date'], $row['requisnr'], $row['tracking_no'], $date, $uid, $max_id]);
                                    }

                                    $fileName = $request->file('upload_file')->getClientOriginalName();
                                    $name = pathinfo($fileName, PATHINFO_FILENAME);
                                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                                    $final = $name."_".$uid.strtotime("now").".".$extension;
                                    $path = Storage::putFileAs(
                                        'rawMaterials', $request->file('upload_file'), $final
                                    );

                                    $new_path = "app/".$path;
                                    $to_mail = 'rmcommercial@inceptapharma.com';
                                    $frm_mail = DB::select("select mail_address,contact_no from mis.leave_emp_info where emp_id = ?", [$uid]);

                                    if(count($frm_mail) == 0){
                                        Mail::send(['html' => 'scm_portal.pr_req_mail_body'], [], function ($message) use($to_mail,$new_path,$auth_name) {
                                            $message->to(explode(',',$to_mail));
                                            $message->subject("Purchase Requisition for Raw Materials");
                                            $message->from('nayemul@inceptapharma.com', $auth_name);
                                            $message->attach(storage_path($new_path));
                                        });
                                    }else{
                                        Mail::send(['html' => 'scm_portal.pr_req_mail_body'], [],function ($message) use($to_mail,$new_path,$frm_mail,$auth_name) {
                                            $message->to(explode(',',$to_mail));
                                            $message->subject("Purchase Requisition for Raw Materials");
                                            $message->from($frm_mail[0]->mail_address, $auth_name);
                                            $message->attach(storage_path($new_path));
                                        });
                                    }

                                    if (file_exists(storage_path($new_path))) {
                                        unlink(storage_path($new_path));
                                    }

                                    $notification = array(
                                        'message' => 'File uploaded successfully! ',
                                        'alert-type' => 'success'
                                    );
                                }
                                return Redirect::to('scm_portal/purchase_req_for_raw_mat')->with($notification);
                            } catch (\Exception $ee) {
                                DB::rollBack();
                                $notification = array(
                                    'message' => 'Database Error!',
                                    'alert-type' => 'error'
                                );
                                return Redirect::to('scm_portal/purchase_req_for_raw_mat')->with($notification);
                            }
                        }
                    }else{
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('scm_portal/purchase_req_for_raw_mat')->with($notification);
                    }
                }
            }
        }
    }
}
