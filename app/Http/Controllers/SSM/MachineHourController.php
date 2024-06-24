<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPExcel_Worksheet_Drawing;

class MachineHourController extends Controller
{
    public function index()
    {
        $pname = DB::select('select distinct pname from mis_fac.ssm_sample_data
                order by 1 asc');
        $batch_number = DB::select('select distinct batch_number from mis_fac.ssm_sample_data
        order by 1 asc');
        $assay = DB:: select('select distinct assay_method from mis_fac.ssm_result_data
order by 1 asc');
//        $chamber_cond = DB::select('select distinct chamber_stor_cond from mis_fac.ssm_sample_data
//        order by 1 asc');
//        $date = DB::select("select distinct to_char(kept_on_date,'MON-RR') kept_on_date  from mis_fac.ssm_sample_data
//        order by 1 asc");
        return view(
        'ssm_views.reports.sample.machinehour',
              compact('pname', 'batch_number', 'assay')
        );
    }

    public function getvalues(Request $request)
    {

        $batch = DB::select('select distinct batch_number val from mis_fac.ssm_sample_data where pname = ?
                order by 1 asc', [$request->pname]);
        $assay = DB::select('select distinct assay_method val from mis_fac.ssm_sample_data where pname = ?
               order by 1 asc', [$request->pname]);
//        $cond = DB::select('select distinct chamber_stor_cond val from mis_fac.ssm_result_data where pname = ?
//               order by 1 asc', [$request->pname]);
//        $date = DB::select("select distinct to_char (kept_on_date,'MON-RR') val from mis_fac.ssm_sample_data where pname = ?
//                order by 1 asc", [$request->pname]);
//        $responsedata = null;

        return response()->json(['batch' => $batch, 'assay' => $assay]);
    }

    public function displayrecord(Request $request)
    {
        DB::setDateFormat('MON-RR');


        $result = DB::select("
                select pname,batch_number,assay_method,total_product,total_sample,sample_analysis_time,sample_analysis_time_average,
                       calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks
                from(
                select 'ALL' all_data,sample_data.pname,sample_data.batch_number,assay_method,total_product,total_sample,sample_analysis_time,sample_analysis_time_average,
                       calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks,sl
                from
                (select pname,batch_number,1 total_product,count(*) total_sample      
                from mis_fac.ssm_sample_data
                group by pname,batch_number) sample_data,
                (select rd.pname,rd.batch_number,assay_method,sample_analysis_time,sample_analysis_time_average,
                       calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks,sl
                from
                (select distinct pname,batch_number,assay_method,mhoure_result_time ,mhoure_result_data sample_analysis_time,calculate_mhoure,actual_mhoure,remarks,sl
                from mis_fac.mhoure_result_data
                where mhoure_result_data is not null) rd,
                (select pname,batch_number,sum(nvl(mhoure_result_data,0)) total_mh,count(*) total_rd,
                        sum(nvl(mhoure_result_data,0))/count(*) sample_analysis_time_average 
                from mis_fac.mhoure_result_data
                where mhoure_result_data is not null
                group by pname,batch_number) pb_av,
                (select pname,sum(nvl(calculate_mhoure,0)) total_cmh,sum(nvl(actual_mhoure,0)) total_amh,count(*) total_count,
                       sum(nvl(calculate_mhoure,0))/count(*) calculated_hour_average,sum(nvl(actual_mhoure,0)) / count(*) actual_machine_hour_average
                from
                (select distinct pname,batch_number,calculate_mhoure,actual_mhoure
                from mis_fac.mhoure_result_data
                where mhoure_result_data is not null
                )
                group by pname) p_av
                where rd.pname = pb_av.pname
                and rd.batch_number = pb_av.batch_number
                and rd.pname = p_av.pname) result_data
                where sample_data.pname = result_data.pname(+)
                and sample_data.batch_number = result_data.batch_number(+)
                )where ? = case when ? = 'ALL' then all_data else pname end     
                and ? = case when ? = 'ALL' then all_data else to_char(batch_number) end
                and ? = case when ? = 'ALL' then all_data else assay_method end
                order by pname,batch_number,sl",
            [$request->pname, $request->pname, $request->batch_number, $request->batch_number,
                $request->assay_method, $request->assay_method]);
        return response()->json($result);

    }

    public function exportexcel($querypara)
    {
        Log::info($querypara);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($querypara, $parameters);
            //Log::info($parameters);


            $data_pr = DB::select("
                            select pname,batch_number,assay_method,total_product,total_sample,sample_analysis_time,sample_analysis_time_average,
                                   calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks
                            from(
                            select 'ALL' all_data,sample_data.pname,sample_data.batch_number,assay_method,total_product,total_sample,sample_analysis_time,sample_analysis_time_average,
                                   calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks,sl
                            from
                            (select pname,batch_number,1 total_product,count(*) total_sample      
                            from mis_fac.ssm_sample_data
                            group by pname,batch_number) sample_data,
                            (select rd.pname,rd.batch_number,assay_method,sample_analysis_time,sample_analysis_time_average,
                                   calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks,sl
                            from
                            (select distinct pname,batch_number,assay_method,mhoure_result_time ,mhoure_result_data sample_analysis_time,calculate_mhoure,actual_mhoure,remarks,sl
                            from mis_fac.mhoure_result_data
                            where mhoure_result_data is not null) rd,
                            (select pname,batch_number,sum(nvl(mhoure_result_data,0)) total_mh,count(*) total_rd,
                                    sum(nvl(mhoure_result_data,0))/count(*) sample_analysis_time_average 
                            from mis_fac.mhoure_result_data
                            where mhoure_result_data is not null
                            group by pname,batch_number) pb_av,
                            (select pname,sum(nvl(calculate_mhoure,0)) total_cmh,sum(nvl(actual_mhoure,0)) total_amh,count(*) total_count,
                                   sum(nvl(calculate_mhoure,0))/count(*) calculated_hour_average,sum(nvl(actual_mhoure,0)) / count(*) actual_machine_hour_average
                            from
                            (select distinct pname,batch_number,calculate_mhoure,actual_mhoure
                            from mis_fac.mhoure_result_data
                            where mhoure_result_data is not null
                            )
                            group by pname) p_av
                            where rd.pname = pb_av.pname
                            and rd.batch_number = pb_av.batch_number
                            and rd.pname = p_av.pname) result_data
                            where sample_data.pname = result_data.pname(+)
                            and sample_data.batch_number = result_data.batch_number(+)
                            )where ? = case when ? = 'ALL' then all_data else pname end     
                            and ? = case when ? = 'ALL' then all_data else to_char(batch_number) end
                            and ? = case when ? = 'ALL' then all_data else assay_method end
                            order by pname,batch_number,sl",
                   [$parameters['pname'], $parameters['pname'],
                    $parameters['batch_number'], $parameters['batch_number'],
                       $parameters['assay_method'], $parameters['assay_method']]);


            $data = ['pdata1' => $data_pr];

            \Excel::create('Machine Hour Calculation', function ($excel) use ($data) {
                $excel->sheet('Machine Hour', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.sample.machinehourexcellayout', $data);
                });

            })->export('xls');
//            return view('ssm_views.reports.sample.machinehourexcellayout')->with($data);
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }

    public function exportpdf($querypara)
    {
        Log::info($querypara);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($querypara, $parameters);
            //Log::info($parameters);


            $data_pr = DB::select("
                                select pname,batch_number,assay_method,total_product,total_sample,sample_analysis_time,sample_analysis_time_average,
                                       calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks
                                from(
                                select 'ALL' all_data,sample_data.pname,sample_data.batch_number,assay_method,total_product,total_sample,sample_analysis_time,sample_analysis_time_average,
                                       calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks,sl
                                from
                                (select pname,batch_number,1 total_product,count(*) total_sample      
                                from mis_fac.ssm_sample_data
                                group by pname,batch_number) sample_data,
                                (select rd.pname,rd.batch_number,assay_method,sample_analysis_time,sample_analysis_time_average,
                                       calculate_mhoure,calculated_hour_average,actual_mhoure,actual_machine_hour_average,remarks,sl
                                from
                                (select distinct pname,batch_number,assay_method,mhoure_result_time ,mhoure_result_data sample_analysis_time,calculate_mhoure,actual_mhoure,remarks,sl
                                from mis_fac.mhoure_result_data
                                where mhoure_result_data is not null) rd,
                                (select pname,batch_number,sum(nvl(mhoure_result_data,0)) total_mh,count(*) total_rd,
                                        sum(nvl(mhoure_result_data,0))/count(*) sample_analysis_time_average 
                                from mis_fac.mhoure_result_data
                                where mhoure_result_data is not null
                                group by pname,batch_number) pb_av,
                                (select pname,sum(nvl(calculate_mhoure,0)) total_cmh,sum(nvl(actual_mhoure,0)) total_amh,count(*) total_count,
                                       sum(nvl(calculate_mhoure,0))/count(*) calculated_hour_average,sum(nvl(actual_mhoure,0)) / count(*) actual_machine_hour_average
                                from
                                (select distinct pname,batch_number,calculate_mhoure,actual_mhoure
                                from mis_fac.mhoure_result_data
                                where mhoure_result_data is not null
                                )
                                group by pname) p_av
                                where rd.pname = pb_av.pname
                                and rd.batch_number = pb_av.batch_number
                                and rd.pname = p_av.pname) result_data
                                where sample_data.pname = result_data.pname(+)
                                and sample_data.batch_number = result_data.batch_number(+)
                                )where ? = case when ? = 'ALL' then all_data else pname end     
                                and ? = case when ? = 'ALL' then all_data else to_char(batch_number) end
                                and ? = case when ? = 'ALL' then all_data else assay_method end
                                order by pname,batch_number,sl",
                [$parameters['pname'], $parameters['pname'],
                    $parameters['batch_number'], $parameters['batch_number'],
                    $parameters['assay_method'], $parameters['assay_method']]);


            $pdf = \SPDF::loadView('ssm_views.reports.sample.machinehourpdflayout', ['pdata1' => $data_pr]);

            return $pdf->setPaper('a4', 'landscape')->download('Machine_Hour.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}
