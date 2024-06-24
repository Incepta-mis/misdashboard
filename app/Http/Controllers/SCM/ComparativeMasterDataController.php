<?php

namespace App\Http\Controllers\SCM;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class ComparativeMasterDataController extends Controller
{
    public function index(){
        $mat = DB::select(" select distinct material, material_desc from mis.scm_comparative_master_up ");

       return view("scm_portal/comparative_master_data",compact('mat'));
    }

    public function comparativeSample(){
        $file = storage_path("app/public/sample_files/comparative_master_sample.xlsx");
       return response()->download($file);
    }

    public function uploadComparativeRawMaterialList(Request $request)
    {



        $uid = Auth::user()->user_id;
        $auth_name = Auth::user()->name;

        $file_name = Input::file('upload_file');
        $date = Carbon::now()->format('Y-m-d H:m:s');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if ($validator_empty->fails()) {
            return Redirect::to('scm_portal/comparative_master_data')->withErrors($validator_empty);
        } else if ($validator_empty->passes()) {
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
                return Redirect::to('scm_portal/comparative_master_data')->withErrors($validator)->with($notification);
            } else if ($validator->passes()) {
//                return 'success..';

                $doc_id = DB::select("SELECT MAX(DOC_ID) max_id FROM MIS.SCM_COMPARATIVE_MASTER_UP");
                if($doc_id == null){
                    $max_id = 1;
                }else{
                    $max_id = $doc_id[0]->max_id;
                    $max_id++;
                }

                $data = Excel::load($file_name, function ($reader) { })->get();

//                Log::info($data);

                if (!empty($data) && $data->count()) {

                    foreach ($data as $key => $value) {
                        $uniqueData[] = [
                            'supplier_vendor' => trim($value->supplier_vendor),
                            'manufacturer' => trim($value->manufacturer),
                            'safety' => trim($value->safety),
                            'mode_of_shipment' => trim($value->mode_of_shipment),
                            'last_unit_price_kg' => trim($value->last_unit_price_kg),
                        ];
                        $insert[] = [
                            'material' => trim($value->material),
                            'material_desc' => trim($value->material_desc),
                            'supplier_vendor' => trim($value->supplier_vendor),
                            'manufacturer' => trim($value->manufacturer),
                            'safety' => trim($value->safety),
                            'mode_of_shipment' => trim($value->mode_of_shipment),
                            'last_unit_price_kg' => trim($value->last_unit_price_kg),
                        ];
                    }
                    if (!empty($insert)) {


                        $count = count($insert);
                        $unique = array_map("unserialize", array_unique(array_map("serialize", $uniqueData)));
                        if ($count > count($unique)) {
                            $notification = array(
                                'message' => 'Duplicate data found in the excel file!',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('scm_portal/comparative_master_data')->with($notification);
                        } else {


                            try {

                                $dup = array();

                                foreach ($insert as $k => $row) {

                                    $supplier_vendor = $row['supplier_vendor'];
                                    $manufacturer = $row['manufacturer'];
                                    $safety = $row['safety'];
                                    $mode_of_shipment = $row['mode_of_shipment'];
                                    $last_unit_price_kg = $row['last_unit_price_kg'];

                                   /* $unqData = DB::SELECT(" SELECT * FROM MIS.SCM_COMPARATIVE_MASTER_UP
                                    WHERE SUPPLIER_VENDOR = '$supplier_vendor' 
                                      AND MANUFACTURER = '$manufacturer' 
                                      AND SAFETY = '$safety' 
                                      AND MODE_OF_SHIPMENT = '$mode_of_shipment' 
                                      AND LAST_UNIT_PRICE_KG = '$last_unit_price_kg'");*/

//                                    ' " $c_street_adress " '


                                    $unqData = DB::table('MIS.SCM_COMPARATIVE_MASTER_UP')
                                        ->where("SUPPLIER_VENDOR",$supplier_vendor)
                                        ->where("MANUFACTURER",$manufacturer)
                                        ->where("SAFETY",$safety)
                                        ->where("MODE_OF_SHIPMENT",$mode_of_shipment)
                                        ->where("LAST_UNIT_PRICE_KG",$last_unit_price_kg)
                                        ->get();

                                   /* Log::info('I am in');
                                    Log::info($unqData);*/

                                   /* $unqData = DB::SELECT("
                                        SELECT *
                                        FROM MIS.SCM_COMPARATIVE_MASTER_UP
                                        WHERE SUPPLIER_VENDOR = q['$supplier_vendor']
                                          AND MANUFACTURER = q['$manufacturer']
                                          AND SAFETY = q['$safety']
                                          AND MODE_OF_SHIPMENT = q['$mode_of_shipment']
                                          AND LAST_UNIT_PRICE_KG = q['$last_unit_price_kg']
                                    ");*/

                                    if(count($unqData) > 0){
                                        $temp = array();
                                        $temp['material'] = $row['material'];
                                        $temp['material_desc'] = $row['material_desc'];
                                        $temp['supplier_vendor'] = $row['supplier_vendor'];
                                        $temp['manufacturer'] = $row['manufacturer'];
                                        $temp['safety'] = $row['safety'];
                                        $temp['mode_of_shipment'] = $row['mode_of_shipment'];
                                        $temp['last_unit_price_kg'] = $row['last_unit_price_kg'];

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
                                        DB::insert('insert into MIS.SCM_COMPARATIVE_MASTER_UP 
                                           (
                                               material, material_desc, supplier_vendor, manufacturer, safety, mode_of_shipment, 
                                               last_unit_price_kg,  created_at, create_user, doc_id
                                           ) 
                                           values (?,?,?,?,?,?,?,?,?,?)',
                                            [
                                                $row['material'], $row['material_desc'], $row['supplier_vendor'],
                                                $row['manufacturer'], $row['safety'], $row['mode_of_shipment'],
                                                $row['last_unit_price_kg'], $date, $uid, $max_id
                                            ]
                                        );
                                    }

                                    $fileName = $request->file('upload_file')->getClientOriginalName();
                                    $name = pathinfo($fileName, PATHINFO_FILENAME);
                                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                                    $final = $name."_".$uid.strtotime("now").".".$extension;
                                    $path = Storage::putFileAs(
                                        'comDatas', $request->file('upload_file'), $final
                                    );

                                    $new_path = "app/".$path;

                                    if (file_exists(storage_path($new_path))) {
                                        unlink(storage_path($new_path));
                                    }

                                    $notification = array(
                                        'message' => 'File uploaded successfully! ',
                                        'alert-type' => 'success'
                                    );



                                }
                                return Redirect::to('scm_portal/comparative_master_data')->with($notification);
                            } catch (\Exception $ee) {

                                Log::info('Error: Comparative Master Data Controller.');
                                Log::info($ee->getCode());
                                Log::info($ee->getMessage());

                                DB::rollBack();
                                $notification = array(
                                    'message' => 'Database Error!',
                                    'alert-type' => 'error'
                                );
                                return Redirect::to('scm_portal/comparative_master_data')->with($notification);
                            }

                        }
                    }else{
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('scm_portal/comparative_master_data')->with($notification);
                    }
                }



            }
        }
    }

    /*public function getComMaterialName(Request $request)
    {
        $material = $request->term['term'];

        if ($material) {
            $mat = DB::select("                                
                select distinct (MATERIAL ||' - '||material_desc) material_desc
                from mis.scm_comparative_master_up
                where  UPPER(material_desc) LIKE '%" . strtoupper($material) . "%'
                
            ");
            return response()->json($mat);
        }
    }*/

    public function getComMaterialData(Request $request)
    {


            $mat = DB::select(" select * from mis.scm_comparative_master_up 
                                where  material = decode('$request->matName','All',material,'$request->matName') ");
            return response()->json($mat);
    }




    /*################## Generate Comparative Statement ############################*/


    public function comStatementPage(){
        $selDate = DB::select(" 
        select distinct to_char(created_at,'DD-MON-RR') ddate from mis.scm_pr_rq_raw_mat_up 
        minus
        select distinct to_char(user_created_at,'DD-MON-RR') ddate from SCM_COMPARATIVE_FINAL_DATA	
    ");

        $rptDate = DB::select(" select distinct to_char(user_created_at,'DD-MON-RR') ddate from mis.SCM_COMPARATIVE_FINAL_DATA order by ddate desc");
        $plantDate = DB::select(" select distinct plant_id from mis.SCM_COMPARATIVE_FINAL_DATA");


        return view("scm_portal/comStatementPage",compact('selDate','rptDate','plantDate'));
    }

    public function getComparativeStatementData(Request $request){

        DB::setDateFormat('DD-MON-RR');

        $statement = DB::select(" 
            select pr.plant_id, pr.purch_req, pr.material, pr.material_desc, (pr.quantity||' '|| pr.unit)  PR_Quantity, to_date(pr.req_date,'DD-MON-RR') req_date, 
            to_date(pr.delivery_date,'DD-MON-RR') delivery_date, to_date(pr.created_at,'DD-MON-RR') create_date, com.supplier_vendor, com.manufacturer, 
            com.safety, com.mode_of_shipment, com.last_unit_price_kg, to_date(com.created_at,'DD-MON-RR') last_date
            from mis.scm_pr_rq_raw_mat_up pr , (
            
            WITH CTE AS
            (SELECT material,supplier_vendor, manufacturer, safety, mode_of_shipment, last_unit_price_kg,created_at,
                   ROW_NUMBER() OVER(PARTITION BY material,supplier_vendor, manufacturer order by created_at desc)
                   as RN
            FROM mis.scm_comparative_master_up com)
            SELECT  material,supplier_vendor, manufacturer, safety, mode_of_shipment, last_unit_price_kg, created_at
            FROM CTE 
            --where material = 11000239
            where RN=1 
            
            ) com
            where pr.material  =   com.material (+)
            --and pr.material = 11000239
            and to_date(pr.created_at,'DD-MON-RR') = '$request->ddate'
            order by material                
            ");
        return response()->json($statement);
    }

    public function saveComparativeStatementData(Request $request){

        $ComData = json_decode($request->ComData, true);
        //Log::info($ComData);

        $doc_id = DB::select("SELECT MAX(DOC_ID) max_id FROM MIS.SCM_COMPARATIVE_FINAL_DATA");
        if($doc_id == null){
            $max_id = 1;
        }else{
            $max_id = $doc_id[0]->max_id;
            $max_id++;
        }

//        Log::info($data[0]['material']);


        foreach ($ComData as $data) {

            $dataArray = [
                'doc_id' => $max_id,
                'plant_id' => $data['plant_id'],
                'purch_req' => $data['purch_req'],
                'material' => $data['material'],
                'material_desc' => $data['material_desc'],
                'pr_quantity' => $data['pr_quantity'],
                'req_date' => Carbon::parse($data['req_date'])->format('Y-m-d'),
                'delivery_date' =>  Carbon::parse($data['delivery_date'])->format('Y-m-d'),
                'user_created_at' => Carbon::parse($data['create_date'])->format('Y-m-d'),
                'supplier_vendor' => $data['supplier_vendor'],
                'manufacturer' => $data['manufacturer'],
                'safety' => $data['safety'],
                'mode_of_shipment' => $data['mode_of_shipment'],
                'last_unit_price_kg' => $data['last_unit_price_kg'],
                'qty_purchase' => $data['qty_purchase'],
                'new_unit_per_kg' => $data['new_unit_per_kg'],
                'CREATE_USER' => Auth::user()->user_id
            ];
            ScmComparativeData::insert($dataArray);

        }

        return response()->json(['success' => 'Successfully Added.']);

    }

    public function getFinalComparativeData(Request $request){

        $result = DB::select("        
        select 
            doc_id, plant_id, purch_req, 
           material, material_desc, pr_quantity, 
           req_date, delivery_date, user_created_at, 
           supplier_vendor, manufacturer, safety, 
           mode_of_shipment, last_unit_price_kg, qty_purchase, 
           new_unit_per_kg, comment_gm_scm, comment_vice_chairman, 
           dummy, create_user, updated_at, 
           update_user
        from mis.scm_comparative_final_data
        where to_char(user_created_at,'DD-MON-RR') = '$request->genDate'        
        ");

        // $r = DB::table('scm_comparative_final_data')->select('doc_id','plant_id','purch_req','material','material_desc','pr_quantity','req_date','delivery_date','user_created_at','supplier_vendor','manufacturer','safety','mode_of_shipment','last_unit_price_kg','qty_purchase','new_unit_per_kg','comment_gm_scm','comment_vice_chairman','dummy','create_user','updated_at','update_user')->limit(180)->get();

        // dd($r)
        // die();


        $data = ['rs_data' => $result];

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);


        $pdf = \PDF::loadView('scm_portal/comparative_pdf_statement',$data);
       $pdf->setPaper('a4', 'landscape');
        // $pdf->setPaper('L', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => true]);
//        return $pdf->stream('ComparativeStatement.pdf')->header('Content-Type','application/pdf');
        return $pdf->download('ComparativeStatement.pdf')->header('Content-Type','application/pdf');
    }

    public function getComparativeStatementByPlant(Request $request){
        $result = DB::select("        
        select 
            doc_id, plant_id, purch_req, 
           material, material_desc, pr_quantity, 
           to_char(req_date,'DD-MON-RR') req_date, to_char(delivery_date,'DD-MON-RR') delivery_date, to_char(user_created_at,'DD-MON-RR') user_created_at, 
           supplier_vendor, manufacturer, safety, 
           mode_of_shipment, last_unit_price_kg, qty_purchase, 
           new_unit_per_kg, comment_gm_scm, comment_vice_chairman, 
           dummy, create_user, updated_at, 
           update_user
        from mis.scm_comparative_final_data
        where to_char(user_created_at,'DD-MON-RR') = '$request->genDate' 
        and plant_id = decode( '$request->plant_id', 'All', plant_id, '$request->plant_id') 
        ");

        return response()->json($result);

    }


}