<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BeftnMaintainController extends Controller
{
    public function index()
    {
        $shortProduct_info = DB::select("select * from MIS.SCM_SHORT_PRODUCT_LIST");
        $product_source = DB::select("select distinct product_source from MIS.SCM_SHORT_PRODUCT_LIST");

        $data = array();
        $data['products'] = $shortProduct_info;
        $data['product_source'] = $product_source;

        return view('ShortProductList.view')->with('shortProduct_info',$data);
    }
    public function uploadDataFromExcel()
    {
        $uid = Auth::user()->user_id;
        $file_name = Input::file('upload_file');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if ($validator_empty->fails()) {
             $notification = array(
                'message' => 'Please upload a file!',
                'alert-type' => 'error'
            );
            return Redirect::to('sp_portal/shortProducts')->withErrors($validator_empty)->with($notification);
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
                return Redirect::to('sp_portal/shortProducts')->withErrors($validator)->with($notification);
            } else if ($validator->passes()) {
                $data = Excel::load($file_name, function ($reader) {
                })->get();
                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {
                        $report_date[] = trim($value->report_date);
                        $uniqueData[] = [
                            'report_date' => trim($value->report_date),
                            'product_source' => trim($value->product_source),
                            'sap_code' => trim($value->sap_code)
                        ];
                        $insert[] = [
                            'spl_date' => trim($value->report_date),
                            'product_source' => trim($value->product_source),
                            'sap_code' => trim($value->sap_code),
                            'p_code' => trim($value->p_code),
                            'p_name' => trim($value->name_of_product),
                            'national_stock' => trim($value->national_stock),
                            'required_qty' => trim($value->required_qty),
                            'forecast_qty' => trim($value->forecast_qty),
                            'national_stock_opening' => trim($value->national_stock_opening),
                            'factory_received' => trim(isset($value->factory_received)?$value->factory_received:""),
                            'factory_stock' => trim(isset($value->factory_stock)?$value->factory_stock:""),
                            'remarks' => trim(isset($value->remarks)?$value->remarks:""),
                            'create_user' => $uid
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
                            return Redirect::to('sp_portal/shortProducts')->with($notification);
                        }else{
                            $uniqueReportDate = array_map("unserialize", array_unique(array_map("serialize", $report_date)));
                            if(count($uniqueReportDate) == 1){
                                $spl_date = Carbon::parse($report_date[0])->format('m/d/Y');
                                $qryData = DB::select("SELECT * FROM MIS.SCM_SHORT_PRODUCT_LIST WHERE to_char(spl_date,'MM/DD/RRRR') = '$spl_date'");

                                if(count($qryData) > 0){
                                    DB::DELETE("DELETE FROM MIS.SCM_SHORT_PRODUCT_LIST where to_char(spl_date,'MM/DD/RRRR') = '$spl_date'");
                                }
                                try {
                                    DB::table('SCM_SHORT_PRODUCT_LIST')->insert($insert);

                                    $notification = array(
                                        'message' => 'File Uploaded successfully! ',
                                        'alert-type' => 'success'
                                    );
                                    return Redirect::to('sp_portal/shortProducts')->with($notification);

                                } catch (\Exception $ee) {
                                    DB::rollBack();
                                    $notification = array(
                                        'message' => 'Database Error!',
                                        'alert-type' => 'error'
                                    );
                                    return Redirect::to('sp_portal/shortProducts')->with($notification);
                                }
                            }else{
                                $notification = array(
                                    'message' => 'There exists two different dates in the excel file!',
                                    'alert-type' => 'error'
                                );
                                return Redirect::to('sp_portal/shortProducts')->with($notification);
                            }
                        }
                    }else{
                        $notification = array(
                            'message' => 'upload excel column format not valid!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('sp_portal/shortProducts')->with($notification);
                    }

                }
            }
        }
    }
    public function getShortProductsData(Request $request){

        DB::statement("alter session set nls_date_format = 'MM/DD/RR'");

        $pro_source = $request->pro_source;
        $spl_date = Carbon::parse($request->report_date)->format('m/d/Y');
        $qryData = DB::select("SELECT to_char(spl_date,'MM/DD/RRRR') spl_date,product_source,sap_code,p_code,p_name,national_stock,required_qty,forecast_qty,
                   national_stock_opening,factory_received,factory_stock,remarks
                   FROM MIS.SCM_SHORT_PRODUCT_LIST WHERE to_char(spl_date,'MM/DD/RRRR') = '$spl_date'
                   AND product_source = decode ('$pro_source','All',product_source,'$pro_source')");
        return response()->json($qryData);
    }
    public function getMonthWiseReport(){
        $prod_list = DB::select("select ap.p_code,ap.name from sample_new.product_info@web_to_sample_msd ap,(select p_code from sample_new.product_info@web_to_sample_msd
                                                     where sap_code is not null and t_p is not null
                                                     minus
                                                     select p_code from sample_new.product_stock_omitted@web_to_sample_msd) mp
                                                     where ap.p_code = mp.p_code order by ap.name");
        return view('ShortProductList.month_wise_report')->with('prod_list',$prod_list);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReport(Request $request){
        $p_code = $request->p_code;
        $monYear = strtoupper(date('M-y', strtotime($request->monthyear)));

        $getDaysNum = DB::select("select listagg(month_day, ',') within group (order by month_day) month_number
                        from(
                        select to_number(to_char(trunc(to_date('$monYear','MON-RR'), 'MM') + level - 1,'DD')) as month_day
                        from dual
                        connect by trunc(trunc(to_date('$monYear','MON-RR'), 'MM') + level - 1, 'MM') = trunc(to_date('$monYear','MON-RR'), 'MM')
                        )");

        $arr = explode(",",$getDaysNum[0]->month_number);
        $countDays = count($arr);

        $report = DB::select("select pi.*,spd.*
        from
        (select spl.*,tp.total
        from
        (select *
        from
        (select distinct sap_code sc,p_code pc,to_number(to_char(spl_date,'DD')) dd,1 spl_val
        from mis.scm_short_product_list
        where to_char(spl_date,'MON-RR') = '$monYear'
        )pivot( sum(spl_val) for dd in (".$getDaysNum[0]->month_number."))) spl,(select sap_code,p_code,count(*) total
                                                        from
                                                        (select distinct spl_date,sap_code,p_code
                                                        from mis.scm_short_product_list
                                                        where to_char(spl_date,'MON-RR') = '$monYear'
                                                        )group by sap_code,p_code) tp
        where spl.sc = tp.sap_code
        and spl.pc = tp.p_code) spd,(select p_code,sap_code,pack_size,description,t_p
                                     from
                                     (select 'ALL' all_data,ap.p_code,sap_code,pack_s pack_size,name description,t_p
                                      from sample_new.product_info@web_to_sample_msd ap,(select p_code from sample_new.product_info@web_to_sample_msd
                                                                                         where sap_code is not null and t_p is not null
                                                                                         minus
                                                                                         select p_code from sample_new.product_stock_omitted@web_to_sample_msd) mp
                                      where ap.p_code = mp.p_code)
                                     where '".$p_code."' = case when '".$p_code."' = 'ALL' then all_data else p_code end) pi
        where spd.sc(+) = pi.sap_code
        and spd.pc(+) = pi.p_code
        order by description");

        return response()->json(['report'=>$report,"countDays"=>$countDays]);
    }
    public function getYearlyMonthReport(Request $request){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $p_code = $request->p_code;
        $year = $request->year;

        $report = DB::select("select pi.*,spd.*
                from
                (select *
                from(
                select spl_mm,sc,pc,spl_val
                from(
                select to_char(spl_date,'MON-RR') spl_mon,to_number(to_char(spl_date,'MM')) spl_mm,sc,pc,sum(nvl(spl_val,0)) spl_val
                from(
                select distinct sap_code sc,p_code pc,to_date(spl_date,'DD-MON-RR') spl_date,1 spl_val
                from mis.scm_short_product_list
                where to_char(spl_date,'RRRR') = '$year'
                )group by  to_char(spl_date,'MON-RR') ,to_char(spl_date,'MM') ,sc,pc
                union all
                select to_char(spl_date,'MON-RR') spl_month,13 spl_mm,sap_code sc,p_code pc,count(*) spl_val
                 from
                (select distinct spl_date,sap_code,p_code
                from mis.scm_short_product_list
                where to_char(spl_date,'RRRR') = '$year'
                )group by to_char(spl_date,'MON-RR'),sap_code,p_code
                ))pivot (sum(spl_val) for spl_mm in (1,2,3,4,5,6,7,8,9,10,11,12,13))) spd,(select p_code,sap_code,pack_size,description,t_p
                         from
                         (select 'ALL' all_data,ap.p_code,sap_code,pack_s pack_size,name description,t_p
                          from sample_new.product_info@web_to_sample_msd ap,(select p_code from sample_new.product_info@web_to_sample_msd
                                                                             where sap_code is not null and t_p is not null
                                                                             minus
                                                                             select p_code from sample_new.product_stock_omitted@web_to_sample_msd) mp
                          where ap.p_code = mp.p_code)
                         where '$p_code' = case when '$p_code' = 'ALL' then all_data else p_code end) pi
                where spd.sc(+) = pi.sap_code
                and spd.pc(+) = pi.p_code
                order by description");

        return response()->json(['report'=>$report]);
    }
    public function downloadFile(){
        $file = storage_path("app\public\sample_files\sampleData.xlsx");
        return response()->download($file);
    }
    public function yearlyMonthSummaryReport(){
        $prod_list = DB::select("select ap.p_code,ap.name from sample_new.product_info@web_to_sample_msd ap,(select p_code from sample_new.product_info@web_to_sample_msd
                                                     where sap_code is not null and t_p is not null
                                                     minus
                                                     select p_code from sample_new.product_stock_omitted@web_to_sample_msd) mp
                                                     where ap.p_code = mp.p_code order by ap.name");
        return view('ShortProductList.yearly_month_report')->with('prod_list',$prod_list);
    }
}
