<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NationalReportController extends Controller
{
    public function index()
    {
        $depot =
            DB::select('select distinct d_id,name from mis.DASH_NATIONAL_REPORT
                        order by d_id
                        ');

        $p_group =
            DB::select('select distinct p_group from mis.DASH_NATIONAL_REPORT');

        $sales_area_code =
            DB::select('select distinct dnr.sales_area_code,SALES_AREA_NAME
                        from mis.DASH_NATIONAL_REPORT dnr,dwh.OS_SALES_AREA_INFO
                        @WEB_TO_IPLDW2 sai
                        where DNR.SALES_AREA_CODE = sai.SALES_AREA_CODE
                        order by sales_area_code
                        ');

             // $summary = DB::select('select sum(nvl(val_sold,0)) sold,sum(nvl(val_int,0)) intr,sum(nvl(val_exp_sale,0)) exp_sale
             //                    from mis.DASH_NATIONAL_REPORT');    


        return view('sale_report_layout.national_report', compact('depot', 'p_group', 'sales_area_code'));
    }

    public function getSummary(Request $request){

        $records = DB::select("select sum(nvl(val_sold,0)) sold,sum(nvl(val_int,0)) intr,sum(nvl(val_exp_sale,0)) exp_sale
                                from(
                                select 'all' all_data,d_id,p_group,sales_area_code,sum(nvl(val_sold,0)) val_sold,sum(nvl(val_int,0)) val_int,
                                         sum(nvl(val_exp_sale,0)) val_exp_sale
                                from mis.dash_national_report
                                group by d_id,p_group,sales_area_code
                                )where ? = case when ? = 'all' then all_data else to_char(d_id) end
                                and ? = case when ? = 'all' then all_data else to_char(sales_area_code) end
                                and ? = case when ? = 'all' then all_data else to_char(p_group) end
                                ",[$request->d_id,$request->d_id,
                                    $request->sac_data,$request->sac_data,
                                   $request->pgroup,$request->pgroup]);

        return response()->json($records);
    }

    public function ss_processing(Request $request)
    {
        $params = $request->params;

        $whereClause = [
            'd_id' => null,
            'p_group' => null,
            'sales_area_code' => null
        ];

        if ($params['d_id'] == 'all') {
            unset($whereClause['d_id']);
        } else {
            $whereClause['d_id'] = $params['d_id'];
        }

        if ($params['pg'] == 'all') {
            unset($whereClause['p_group']);
        } else {
            $whereClause['p_group'] = $params['pg'];
        }

        if ($params['sac'] == 'all') {
            unset($whereClause['sales_area_code']);
        } else {
            $whereClause['sales_area_code'] = $params['sac'];
        }

        Log::info($whereClause);

        $query = DB::table('mis.dash_national_report')
            ->where($whereClause);

        return app('datatables')->queryBuilder($query)->toJson();



    }

     public function download_excel(Request $request){
//        Log::info($request->sac);
        set_time_limit(0);
        ini_set('memory_limit',-1);

        $output = DB::select("select* from(select * from mis.DASH_NATIONAL_REPORT
                            where d_id = decode('$request->depot','all',d_id,'$request->depot')
                            and sales_area_code = decode('$request->sales_area','all',sales_area_code,'$request->sales_area')
                            and p_group = decode('$request->pgroup','all',p_group,'$request->pgroup')
                            order by sales_area_code,d_id,p_group)");



        if (count($output) > 0) {
            $data = ['rdata' => $output];

//            Log::info($data);

            try{
                \Excel::create('National Report', function ($excel) use ($data) {
                    $excel->sheet('National Report', function ($sheet) use ($data) {
                        $sheet->loadView('sale_report_layout.excel_layout.national_report', $data);
                    });
                })->export('xls');

            }catch (\Exception $ex){
                Log::info($ex->getMessage());
                return response()->json(['status'=>$ex->getMessage()]);
            }

        } else {
            return response()->json(['status'=>'404']);
        }
    }
}
