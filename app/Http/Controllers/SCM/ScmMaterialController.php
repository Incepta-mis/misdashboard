<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 5/29/2018
 * Time: 12:58 PM
 */

namespace App\Http\Controllers\SCM;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\ScmBlockListMaterial;
use Illuminate\Support\Facades\Validator;

class ScmMaterialController extends Controller
{
    public function index()
    {
        // $materials = DB::select("select blocklist_year,blocklist_date,plant,blocklist_no,material_name,manufacturer_name,supplier_name,qty,uom,air_price,road_price,sea_price,currency
        //                         from mis.scm_blocklist_material");
        // return view('scm_portal/material_upload')->with('materials',$materials);
        return view('scm_portal/material_upload');
    }

    public function importExcel()
    {
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");
        $uid = Auth::user()->user_id;

       // if(Input::hasFile('import_file')){

            $file_name = Input::file('import_file');

            //validation
            $rules = array('import_file' => 'required'); //'required'
            $msg = array('import_file.required' => 'This field is required');
            $validator_empty = Validator::make(array('import_file' => $file_name), $rules, $msg);
            if ($validator_empty->fails()) {
                return Redirect::to('scm_portal/material_upload_page')->withErrors($validator_empty);
            }else if ($validator_empty->passes()) {

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
                    return  Redirect::to('scm_portal/material_upload_page')->withErrors($validator)->with($notification);

                }else if ($validator->passes()) {

                    $data = Excel::load($file_name, function($reader){})->get();

                    if(!empty($data) && $data->count()){
                        foreach ($data as $key => $value) {


                            // echo '<pre>';
                            // print_r($value->date);
                            // print_r( Carbon::parse(trim($value->date))->format('d-m-Y') );
                            // exit;





                            if(ScmBlockListMaterial::where('BLOCKLIST_NO', $value->blocklist_no)->count() > 0) {

//                                dd('passed 1');

                                DB::insert("insert into mis.scm_blocklist_material_bkup (blocklist_year, blocklist_date, plant, 
                                               blocklist_no, material_name, manufacturer_name, 
                                               supplier_name, qty, uom, 
                                               air_price, road_price, sea_price, 
                                               currency, create_date, create_user, 
                                               update_date, update_user)
                                            select 
                                            blocklist_year, blocklist_date, plant, 
                                               blocklist_no, material_name, manufacturer_name, 
                                               supplier_name, qty, uom, 
                                               air_price, road_price, sea_price, 
                                               currency, create_date, create_user, 
                                               update_date, update_user
                                            from mis.scm_blocklist_material 
                                            where BLOCKLIST_NO = ?",[$value->blocklist_no]);

                                DB::DELETE("
                                delete from MIS.SCM_BLOCKLIST_MATERIAL
                                where BLOCKLIST_NO = ?",[$value->blocklist_no]);
                            }

//                            $insert[] = [
//                                'BLOCKLIST_YEAR'    => trim($value->year),
//                                'BLOCKLIST_DATE'    => Carbon::parse(trim($value->date))->format('d-m-Y'),
//                                'PLANT'             => trim($value->plant),
//                                'BLOCKLIST_NO'      => trim($value->blocklist_no),
//                                'MATERIAL_NAME'     => trim($value->material_name),
//                                'MANUFACTURER_NAME' => trim($value->name_of_the_manufacturer),
//                                'SUPPLIER_NAME'     => trim($value->name_of_the_supplier),
//                                'QTY'               => trim($value->quantity),
//                                'UOM'               => trim($value->uom),
//                                'AIR_PRICE'         => trim($value->air_price),
//                                'ROAD_PRICE'        => trim($value->road_price),
//                                'SEA_PRICE'         => trim($value->sea_price),
//                                'CURRENCY'          => trim($value->price_currency),
//                                'CREATE_USER'       => $uid
//                            ];


                            $dataArr = $this->excelDataConvert($value->uom, $value->price);

//                        dd($dataArr);






                            $insert[] = [
                                'BLOCKLIST_YEAR' => trim($value->year),
                                'BLOCKLIST_DATE' => Carbon::parse(trim($value->date))->format('d-m-Y'),
                                'PLANT' => trim($value->plant),
                                'BLOCKLIST_NO' => trim($value->blocklist_no),
                                'MATERIAL_NAME' => trim($value->material_name),
                                'MANUFACTURER_NAME' => trim($value->name_of_the_manufacturer),
                                'SUPPLIER_NAME' => trim($value->name_of_the_supplier),
                                'QTY' => trim($dataArr[0]->qty),
                                'UOM' => trim($dataArr[0]->uom),
                                'AIR_PRICE' => trim($dataArr[0]->air_price),
                                'ROAD_PRICE' => trim($dataArr[0]->road_price),
                                'SEA_PRICE' => trim($dataArr[0]->sea_price),
                                'CURRENCY' => trim($dataArr[0]->currency),
                                'CREATE_USER' => $uid
                            ];



                        }


                        if(!empty($insert)){
                            DB::table('SCM_BLOCKLIST_MATERIAL')->insert($insert);

//                            dd($insert);

                            $dt =Carbon::now()->format('d-m-Y');
                            $sl = DB::select("SELECT count(*) cnt
                                      FROM mis.SCM_BLOCKLIST_MATERIAL
                                      WHERE to_char(CREATE_DATE,'DD-MM-RRRR') = ?
                                      AND CREATE_USER = ?",[$dt,$uid]);
                            $cnt = $sl[0]->cnt;
//                            dd('passed 3');

                            $procedureName = 'MIS.line_breaks';
                            $result = DB::executeProcedure($procedureName,[]);


                            $notification = array(
                                'message' => 'File Uploaded successfully! '.$cnt.' rows inserted',
                                'alert-type' => 'success'
                            );
                            return  Redirect::to('scm_portal/material_upload_page')->with($notification);
                        }else{
                            $notification = array(
                                'message' => 'upload excel column format not valid!',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('scm_portal/material_upload_page')->with($notification);
                        }
                    }
                }
            }

       // }
    }

    public function excelDataConvert($uom, $price)
    {
        return DB::select("
            select regexp_replace('$uom', '[^0-9]', '') qty, regexp_replace('$uom', '[^a-z and ^A-Z]', '') as uom, substr(regexp_replace('$price', '[^0-9]', ''),1) as amount,
     case 
        when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),1,2) ='US' then 'USD' 
        when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),1,2) ='EU' then 'EUR'
        when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),1,2) ='GB' then 'GBP'
        when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),1,2) ='BD' then 'BDT'
        else 'Not Found' 
     end currency,
         
     case
       when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),1,2) ='US' then  
         case
          when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),3,3) = 'S' then  regexp_replace('$price', '[^.0-9]', '')
         else '0'
         end     
     else 
     
        case
          when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),4,4) = 'S' then  regexp_replace('$price', '[^.0-9]', '')
         else '0'
        end 

     end sea_price,
     
     case
       when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),1,2) ='US' then  
         case
          when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),3,3) = 'R' then  regexp_replace('$price', '[^.0-9]', '')
         else '0'
         end     
     else 
          case
            when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),4,4) = 'R' then  regexp_replace('$price', '[^.0-9]', '')
            else '0'
          end           
     end road_price,
     
     case
       when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),1,2) ='US' then  
         case
          when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),3,3) = 'A' then  regexp_replace('$price', '[^.0-9]', '')
         else '0'
         end     
     else      
        case
          when substr(regexp_replace('$price', '[^a-z and ^A-Z]', ''),4,4) = 'A' then  regexp_replace('$price', '[^.0-9]', '')
        else '0'
        end           
     end air_price
     
      from dual");
    }

}