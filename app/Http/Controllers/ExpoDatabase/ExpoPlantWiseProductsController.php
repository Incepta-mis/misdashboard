<?php


namespace App\Http\Controllers\ExpoDatabase;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ExpoPlantWiseProductsController extends Controller
{
    public function index()
    {
        return view('expo_database.expo_plant_wise_products');
    }

    public function uploadExpoPlantWiseData()
    {
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");
        $uid = Auth::user()->user_id;

        if (Input::hasFile('import_file')) {
            $file_name = Input::file('import_file');
            //validation
            $rules = array('import_file' => 'required'); //'required'
            $msg = array('import_file.required' => 'This field is required');
            $validator_empty = Validator::make(array('import_file' => $file_name), $rules, $msg);
            if ($validator_empty->fails()) {
                return Redirect::to('expo/getPageExpoPlantWiseDataUpload')->withErrors($validator_empty);
            } else if ($validator_empty->passes()) {
                $ext = strtolower($file_name->getClientOriginalExtension());
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
                    return Redirect::to('expo/getPageExpoPlantWiseDataUpload')->withErrors($validator)->with($notification);

                } else if ($validator->passes()) {


                    $data = Excel::load($file_name, function ($reader) {
                    })->get();

                    if (!empty($data) && $data->count()) {
                        foreach ($data as $key => $value) {
                            DB::DELETE(" delete from MIS.EXPO_PLANT_WISE_PRODUCTS where plant_id = ? and product_code = ?", [$value->plant_id, $value->product_code]);
                            $insert[] = [
                                'PLANT_ID' => trim($value->plant_id),
                                'PRODUCT_CODE' => trim($value->product_code),
                                'PRODUCT_NAME' => trim($value->product_name),
                                'PRODUCT_GENERIC' => trim($value->product_generic),
                                'CREATE_USER' => $uid
                            ];
                        }
                    }

                    if (!empty($insert)) {
                        DB::table('MIS.EXPO_PLANT_WISE_PRODUCTS')->insert($insert);
                        $dt = Carbon::now()->format('d-m-Y');
                        $sl = DB::select("SELECT count(*) cnt
                                      FROM MIS.EXPO_PLANT_WISE_PRODUCTS
                                      WHERE to_char(CREATE_DATE,'DD-MM-RRRR') = ?
                                      AND CREATE_USER = ?", [$dt, $uid]);
                        $cnt = $sl[0]->cnt;
                        $notification = array(
                            'message' => 'File Uploaded successfully! ' . $cnt . ' rows inserted',
                            'alert-type' => 'success'
                        );
                        return Redirect::to('expo/getPageExpoPlantWiseDataUpload')->with($notification);
                    } else {
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('expo/getPageExpoPlantWiseDataUpload')->with($notification);
                    }


                }
            }
        } else {
            $notification = array(
                'message' => 'Please Select Correct Excel File!',
                'alert-type' => 'error'
            );
            return Redirect::to('expo/getPageExpoPlantWiseDataUpload')->with($notification);
        }


    }


    public function getProductInfo(Request $request){
        $rs = DB::select("select plant_id,product_code,product_name,product_generic
        from mis.expo_plant_wise_products where product_code = '$request->product_code'");
        return response()->json($rs);
    }

}