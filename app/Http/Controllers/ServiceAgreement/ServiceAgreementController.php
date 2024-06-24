<?php

namespace App\Http\Controllers\ServiceAgreement;

use Carbon\Carbon;
use http\Client\Curl\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class ServiceAgreementController extends Controller
{

    public function viewService(){

        $service_name = DB::select("select distinct SERVICE,ID from MIS.SERVICE_AGREEMENT_NOTIFICATION");

        return view('ServiceAgreement.serviceAgreementNotification')->with('service_name',$service_name);

    }

    public function savePost(Request $request)
    {

        DB::setDateFormat("DD-MON-RR");
        $uid = Auth::user()->user_id;
        //$date = Carbon::now()->format('Y-m-d H:m:s');
        $dataList = json_decode($request->dataListObject, true);

        $status = DB::table('MIS.SERVICE_AGREEMENT_NOTIFICATION')->insert($dataList);
        if ($status) {
            return response()->json(['result'=>'success']);
        } else {
            return response()->json(['result'=>'error']);
        }
    }

    /*
     *
     * tel gas uttolonkari shonstha er nam
     * thiland laous o myanmer
     * thiland laous myanmer
     *
     *
     *
     * */


    public function uploadServiceExcelData()
    {

        $uid = Auth::user()->user_id;
        $file_name = Input::file('upload_file');


        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);


        if ($validator_empty->fails()) {

            Log::info("empty validation fails");
            $notification = array(
                'message' => 'Please upload a file!',
                'alert-type' => 'error'
            );
            return Redirect::to('serviceAgreementNotification/viewService')->withErrors($validator_empty)->with($notification);


        }else if ($validator_empty->passes()) {
            $ext = strtolower($file_name->getClientOriginalExtension());

            Log::info("second validation");
            Log::info("here is file extension");
            Log::info($ext);


            $validator = Validator::make(
                array('ext' => $ext),
                array('ext' => 'in:xls,xlsx')
            );

            if ($validator->fails()) {
                // send back to the page with the input data and errors
                $notification = array(
                    'message' => 'Please Upload excel file!',
                    'alert-type' => 'error'
                );
                return Redirect::to('serviceAgreementNotification/viewService')->withErrors($validator)->with($notification);
            } else if ($validator->passes()) {

                Log::info("all validation passes");


                $data = Excel::load($file_name, function ($reader) {
                })->get();

                Log::info("file name");
                Log::info($data);


                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {

                        $uniqueData[] = [
                            'service' => trim($value->service),
                            'cetegory' => trim($value->cetegory),
                            'activity' => trim($value->activity),
                            'status' => trim($value->status),
                        ];

                        $insert[] = [
                            'service' => trim($value->service),
                            'cetegory' => trim($value->cetegory),
                            'activity' => trim($value->activity),
                            'dead_line' => trim($value->dead_line),
                            'status' => trim($value->status),

                        ];
                    }
                    if (!empty($insert)) {

                        $count = count($insert);
                        $unique = array_map("unserialize", array_unique(array_map("serialize", $uniqueData)));

                        Log::info("unique data log in the array");
                        Log::info($unique);
                        Log::info(count($unique));
                        Log::info($count);


                        if($count > count($unique)){
                            $notification = array(
                                'message' => 'Duplicate data found in the excel file!',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('serviceAgreementNotification/viewService')->with($notification);
                        }else{
                                try {
                                    DB::table('MIS.SERVICE_AGREEMENT_NOTIFICATION')->insert($insert);
                                    $notification = array(
                                        'message' => 'File Uploaded successfully! ',
                                        'alert-type' => 'success'
                                    );
                                    return Redirect::to('serviceAgreementNotification/viewService')->with($notification);

                                } catch (\Exception $ee) {
                                    DB::rollBack();
                                    $notification = array(
                                        'message' => 'Database Error!',
                                        'alert-type' => 'error'
                                    );
                                    return Redirect::to('serviceAgreementNotification/viewService')->with($notification);
                                }

                        }
                    }else{
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('serviceAgreementNotification/viewService')->with($notification);
                    }

                }


            }
        }
    }



    public function getDatatableData(Request $request)
    {

        DB::setDateFormat('DD-MON-RR');
        $service_id = $request->service_name;

        if($service_id=='all'){
            $serviceData = DB::select("select distinct * from MIS.SERVICE_AGREEMENT_NOTIFICATION order by service");

        }else{
            $serviceData = DB::select("select distinct * from MIS.SERVICE_AGREEMENT_NOTIFICATION where id='$service_id' order by service");

        }


        if ($serviceData) {
            return response()->json(['result'=>$serviceData]);
        } else {
            return response()->json(['result'=>'error']);

        }
    }



    public function updateServiceData(Request $request){

        DB::setDateFormat('DD-MON-RR');

        $table_id = $request->id;
        $decoded_data = json_decode($request->itemArray);

        $service = $decoded_data->service;
        $cetegory = $decoded_data->cetegory;
        $activity = $decoded_data->activity;
        $deadline = $decoded_data->deadline;


        $status = $decoded_data->status;
        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');


        $result =  DB::UPDATE("
                        UPDATE MIS.SERVICE_AGREEMENT_NOTIFICATION
                        SET
                            service = '$service',
                            cetegory = '$cetegory',
                            activity = '$activity',
                            dead_line = '$deadline',
                            status = '$status'
                        
                          
                        WHERE ID = '$table_id'
                        ");

            return response()->json(['result'=> $result]);

    }





    //delete and update emp ext
    public function deleteServiceData(Request $request){

        $id = $request->id;
        $company_code = $request->company_code;
        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.SERVICE_AGREEMENT_NOTIFICATION WHERE ID = ?',[$id]);
            if($result){

                return response()->json(['status'=> 'success']);

            }else{
                return response()->json(['status'=> 'false']);
            }

        }else{
            return response()->json(['status'=> 2]);
        }
    }


}