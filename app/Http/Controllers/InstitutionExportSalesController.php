<?php

namespace App\Http\Controllers;

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

class InstitutionExportSalesController extends Controller
{
    public function index(){
        return view("upload_institution_export_sales");
    }
    public function downloadSampleFile(){
        $file = storage_path("app/public/sample_files/Inst_ExportData_Oct-2022.xlsx");
        return response()->download($file);
    }
    public function uploadSalesReport(Request $request){
        $uid = Auth::user()->user_id;

        $auth_name = Auth::user()->name;

        $file_name = Input::file('upload_file');
        $date = Carbon::now()->format('Y-m-d H:m:s');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if($validator_empty->fails()) {
            return Redirect::to('upload_brand_sales_data')->withErrors($validator_empty);
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
                return Redirect::to('upload_brand_sales_data')->withErrors($validator)->with($notification);
            } else if ($validator->passes()) {

                $data = Excel::load($file_name, function ($reader) { })->get();

                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {
                        $uniqueData[] = [
                            'sales_month' => trim($value->sales_month),
                            'company_code' => trim($value->company_code),
                            'sap_code' => trim($value->sap_code),
                            'p_name' => trim($value->p_name),
                            'channel' => trim($value->channel)
                        ];
                        $insert[] = [
                            'sales_month' => strtoupper(trim($value->sales_month)),
                            'company_code' => strtoupper(trim($value->company_code)),
                            'company_name' => strtoupper(trim($value->company_name)),
                            'sap_code' => strtoupper(trim($value->sap_code)),
                            'p_name' => strtoupper(trim($value->p_name)),
                            'country' => strtoupper(trim($value->rm_terr_idregion)),
                            'sold_qty' => strtoupper(trim($value->sold_qty)),
                            'sold_value' => strtoupper(trim($value->sold_value)),
                            'sales_type' => strtoupper(trim($value->channel)),
                            'create_user' => $uid,
                            'create_date' => $date
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
                            return Redirect::to('upload_brand_sales_data')->with($notification);
                        }else{
                            try {

                                $dup = array();
                                $i = 1;
                                foreach ($insert as $k => $row) {

                                    $sales_month = $row['sales_month'];
                                    $company_code = $row['company_code'];
                                    $sap_code = $row['sap_code'];
                                    $channel = $row['sales_type'];

                                    $unqData = DB::SELECT("SELECT * FROM MIS.EXPORT_INSTITUTE_SALES_DETAILS WHERE SALES_MONTH = '$sales_month' AND COMPANY_CODE = '$company_code' AND SAP_CODE = '$sap_code' AND SALES_TYPE = '$channel'");

                                    if(count($unqData) > 0){
                                        $temp = array();
                                        $temp['sl'] = $i;
                                        $temp['sales_month'] = $row['sales_month'];
                                        $temp['company_code'] = $row['company_code'];
                                        $temp['company_name'] = $row['company_name'];
                                        $temp['sap_code'] = $row['sap_code'];
                                        $temp['p_name'] = $row['p_name'];
                                        $temp['country'] = $row['country'];
                                        $temp['sold_qty'] = $row['sold_qty'];
                                        $temp['sold_value'] = $row['sold_value'];
                                        $temp['sales_type'] = $row['sales_type'];
                                        array_push($dup,$temp);
                                    }
                                    $i++;
                                }
                                if(count($dup) > 0){
                                    $notification = array(
                                        'message' => "Data could not be uploaded!",
                                        'alert-type' => 'error',
                                        'dup_data' => json_encode($dup)
                                    );
                                }else{
                                    foreach ($insert as $k => $row) {
                                        DB::insert('insert into MIS.EXPORT_INSTITUTE_SALES_DETAILS ( SALES_MONTH, COMPANY_CODE, COMPANY_NAME, SAP_CODE, P_NAME, COUNTRY, SOLD_QTY, SOLD_VALUE, SALES_TYPE, CREATE_USER, CREATE_DATE) values (?,?,?,?,?,?,?,?,?,?,?)',[$row['sales_month'], $row['company_code'], $row['company_name'], $row['sap_code'], $row['p_name'], $row['country'], $row['sold_qty'], $row['sold_value'], $row['sales_type'], $uid, $date]);
                                    }
                                    $notification = array(
                                        'message' => 'File uploaded successfully! ',
                                        'alert-type' => 'success'
                                    );
                                }
                                return Redirect::to('upload_brand_sales_data')->with($notification);
                            } catch (\Exception $ee) {
                                DB::rollBack();
                                $notification = array(
                                    'message' => 'Database Error!',
                                    'alert-type' => 'error'
                                );
                                return Redirect::to('upload_brand_sales_data')->with($notification);
                            }
                        }
                    }else{
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('upload_brand_sales_data')->with($notification);
                    }
                }
            }
        }
    }
    public function getMonthWiseUploadedReport(Request $request){
        $monYear = strtoupper(date('M-y', strtotime($request->monthyear)));
        $getData = DB::select("SELECT * FROM MIS.EXPORT_INSTITUTE_SALES_DETAILS WHERE SALES_MONTH = '$monYear'");
        if(count($getData) > 0){
            return response()->json(['report'=>$getData]);
        }else{
            return response()->json(['report'=>[]]);
        }

    }
}