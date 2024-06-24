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
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class ExpoCountryWiseProductsController extends Controller
{
    public function index(){
        // return view('expo_database.expo_country_wise_products');
        $country = DB::select(" select country_code,initcap(country_name) country_name from mis.expo_country_list ");
        $plant = DB::select(" select distinct plant_id from mis.expo_plant order by plant_id ");
        return view('expo_database.expo_country_wise_products',['country'=>$country,'plant'=>$plant]);
    }
    
    public function getBulkCode(Request $request)
    {
        $pbcode =  DB::select(" select distinct product_code from mis.expo_plant_wise_products where plant_id = '$request->plant_id' order by product_code ");
        return response()->json($pbcode);
    }

    public function productName(Request $request)
    {
        $proName = DB::select(" select distinct product_code,product_name from mis.expo_plant_wise_products where product_code = '$request->prod_code' and plant_id = '$request->plant_id' order by product_code ");
        return response()->json($proName);
    }

    
    public function saveExpoCountryWise(Request $request){


        $box = $request->all();
            //        $myValue = array();
            //        parse_str($box['data'], $myValue);

            //        log::info($box['prod_code']);
                    // $sequence = DB::getSequence();
                    // $id = $sequence->nextValue('MIS.SEQ_EXPO_COUNTRYWISE');

        $id = DB::select("select max(id) + 1 mx 
        from mis.EXPO_COUNTRY_WISE_PRODUCTS");

        $expoData[] = [
            'CREATE_USER' => Auth::user()->user_id,
            'id' => $id[0]->mx,
            'plant_id' => $box['plant_id'],
            'FINISH_PRODUCT_CODE' => $box['fi_pcode'],
            'PRODUCT_CODE' => $box['prod_code'],
            'PRODUCT_NAME' => $box['prod_name'],
            'PRODUCT_GENERIC' => $box['prod_generic'],
            'EXPORT_COUNTRY' => $box['exp_country'],
            'PACK_SIZE' => $box['pack_size'],
            'COMPANY_AGENT_NAME' => $box['com_agentName'],
            'CONTACT_NAME' => $box['contact_name'],
            'ADDRESS' => $box['address']
        ];

        if (!empty($expoData)) {
            try{
                $rs = DB::table('MIS.EXPO_COUNTRY_WISE_PRODUCTS')->insert($expoData);
                if($rs){
                    return response()->json(['success'=>'Your record successfully submitted']);
                }else {
                    return response()->json(['error'=>'Unable to save record','resone']);
                }
            } catch (Oci8Exception $e){
                // Log::info($e->getMessage());
                return response()->json(['error'=>$e->getCode()]);
            }
        }
    }

    public function uploadExpoCountryWiseData(){
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");
        $uid = Auth::user()->user_id;

        if (Input::hasFile('import_file')) {
            $file_name = Input::file('import_file');
            //validation
            $rules = array('import_file' => 'required'); //'required'
            $msg = array('import_file.required' => 'This field is required');
            $validator_empty = Validator::make(array('import_file' => $file_name), $rules, $msg);
            if ($validator_empty->fails()) {
                return Redirect::to('expo/getPageExpoCountryWiseProducts')->withErrors($validator_empty);
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
                    return Redirect::to('expo/getPageExpoCountryWiseProducts')->withErrors($validator)->with($notification);

                } else if ($validator->passes()) {


                    $data = Excel::load($file_name, function ($reader) {})->get();


                    $rs = null;

                    if (!empty($data) && $data->count()) {
                        foreach ($data as $key => $value) {

                            $maxId = DB::select("select max(id) + 1 max_id from mis.expo_country_wise_products");
                            $insert= [];

                            if(!empty($value->finish_product_code)){
                                $pack_size = $value->pack_size;

                                DB::DELETE(" delete from MIS.EXPO_COUNTRY_WISE_PRODUCTS 
                                 where finish_product_code =? 
                                 and plant_id = ? 
                                 and product_code = ?
                                 and product_name = ?
                                 and export_country = ?
                                 and pack_size = (q'[$pack_size]')
                                 ", [
                                    $value->finish_product_code,
                                    $value->plant_id,
                                    $value->product_code,
                                    $value->product_name,
                                    $value->export_country
                                ]);

                                $insert[] = [
                                    'FINISH_PRODUCT_CODE' => trim($value->finish_product_code),
                                    'PLANT_ID' => trim($value->plant_id),
                                    'PRODUCT_CODE' => trim($value->product_code),
                                    'PRODUCT_NAME' => trim($value->product_name),
                                    'PRODUCT_GENERIC' => trim($value->product_generic),
                                    'EXPORT_COUNTRY' => trim($value->export_country),
                                    'PACK_SIZE' => trim($value->pack_size),
                                    'COMPANY_AGENT_NAME' => trim($value->company_agent_name),
                                    'CONTACT_NAME' => trim($value->contact_name),
                                    'ADDRESS' => trim($value->address),
                                    'CREATE_USER' => $uid,
                                    'id' => $maxId[0]->max_id
                                ];

                            }else{
                                $pack_size = $value->pack_size;

                                DB::DELETE(" delete from MIS.EXPO_COUNTRY_WISE_PRODUCTS 
                                 where plant_id = ? 
                                 and product_code = ?
                                 and product_name = ?
                                 and export_country = ?
                                 and pack_size = (q'[$pack_size]')
                                 ", [
                                    $value->plant_id,
                                    $value->product_code,
                                    $value->product_name,
                                    $value->export_country
                                ]);

                                $insert[] = [
                                    'FINISH_PRODUCT_CODE' => trim($value->finish_product_code),
                                    'PLANT_ID' => trim($value->plant_id),
                                    'PRODUCT_CODE' => trim($value->product_code),
                                    'PRODUCT_NAME' => trim($value->product_name),
                                    'PRODUCT_GENERIC' => trim($value->product_generic),
                                    'EXPORT_COUNTRY' => trim($value->export_country),
                                    'PACK_SIZE' => trim($value->pack_size),
                                    'COMPANY_AGENT_NAME' => trim($value->company_agent_name),
                                    'CONTACT_NAME' => trim($value->contact_name),
                                    'ADDRESS' => trim($value->address),
                                    'CREATE_USER' => $uid,
                                    'id' => $maxId[0]->max_id
                                ];
                            }

                            //Log::info($insert);

                            $rs =  DB::table('MIS.EXPO_COUNTRY_WISE_PRODUCTS')->insert($insert);

                        }
                    }



                    $notification = [];
                    if ($rs) {

                        $dt = Carbon::now()->format('d-m-Y');
                        $sl = DB::select("SELECT count(*) cnt
                                      FROM MIS.EXPO_COUNTRY_WISE_PRODUCTS
                                      WHERE to_char(CREATE_DATE,'DD-MM-RRRR') = ?
                                      AND CREATE_USER = ?", [$dt, $uid]);
                        $cnt = $sl[0]->cnt;
                        $notification = array(
                            'message' => 'File Uploaded successfully! ' . $cnt . ' rows inserted',
                            'alert-type' => 'success'
                        );
                    } else {
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                    }
                    return Redirect::to('expo/getPageExpoCountryWiseProducts')->with($notification);


                }


            }
        } else {
            $notification = array(
                'message' => 'Please Select Correct Excel File!',
                'alert-type' => 'error'
            );
            return Redirect::to('expo/getPageExpoCountryWiseProducts')->with($notification);
        }

    }

    public function getFinishProductInfo(Request $request){

        $rs = DB::select(" select finish_product_code,plant_id,product_code,product_name,product_generic,export_country,pack_size,company_agent_name,contact_name,address from mis.expo_country_wise_products where finish_product_code = '$request->finish_p_code' ");
        return response()->json($rs);

    }

}