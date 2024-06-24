<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPExcel_Worksheet_Drawing;

class WorkLoadCalcController extends Controller
{
    public function index()
    {
        $pname = DB::select('select distinct pname from mis_fac.ssm_sample_data
                order by 1 asc');
              $batch_number =  DB::select('select distinct batch_number from mis_fac.ssm_sample_data
        order by 1 asc');
              $chamber_cond = DB::select ('select distinct chamber_stor_cond from mis_fac.ssm_sample_data
        order by 1 asc');
              $date = DB::select("select distinct to_char(kept_on_date,'MON-RR') kept_on_date  from mis_fac.ssm_sample_data
        order by 1 asc");
        return view('ssm_views.reports.sample.workloadcalc', compact('pname','batch_number','chamber_cond','date'));
    }

    public function getvalues(Request $request)
    {

       $batch = DB::select('select distinct batch_number val from mis_fac.ssm_sample_data where pname = ?
                order by 1 asc', [$request->pname]);

        $cond = DB::select('select distinct chamber_stor_cond val from mis_fac.ssm_sample_data where pname = ?
                order by 1 asc', [$request->pname]);

        $date = DB::select("select distinct to_char (kept_on_date,'MON-RR') val from mis_fac.ssm_sample_data where pname = ?
                order by 1 asc", [$request->pname]);


        return response()->json(['batch'=>$batch,'cond'=>$cond,'date'=>$date]);
    }

    public function displayrecord(Request $request)
    {
        DB::setDateFormat('MON-RR');


        $result = DB::select("select pname,batch_number,to_char(kept_on_date,'DD-MON-RR')kept_on_date,total_product,total_sample,
                       ana_time_pro,ana_time_nsb,tatpp,tatps,chamber_stor_cond,remarks
                from(
                select 'ALL' all_data,sd.pname,batch_number,kept_on_date,kept_on_month,total_product,total_sample,ana_time_pro,ana_time_nsb,
                       total_product * nvl(ana_time_pro,0) tatpp,nvl(total_sample,0) * nvl(ana_time_nsb,0) tatps,chamber_stor_cond,remarks  
                from
                (select pname,batch_number,kept_on_date,to_char(kept_on_date,'MON-RR') kept_on_month,1 total_product,ana_time_pro,ana_time_nsb,chamber_stor_cond,remarks      
                from mis_fac.ssm_sample_data) sd,(select pname,count(*) total_sample      
                                                  from mis_fac.ssm_sample_data group by pname) tsq
                where sd.pname = tsq.pname
                )where ? = case when ? = 'ALL' then all_data else pname end	 
                and ? = case when ? = 'ALL' then all_data else to_char(batch_number) end
                and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                and ? = case when ? = 'ALL' then all_data else kept_on_month end", [$request->pname, $request->pname, $request->batch_number,$request->batch_number,
            $request->chamber_stor_cond,$request->chamber_stor_cond, $request->kept_on_date,$request->kept_on_date]);
        return response()->json($result);
        Log::info($result);

    }
    public function exportexcel($querypara){
        Log::info($querypara);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($querypara, $parameters);
            //Log::info($parameters);



            $data_pr = DB::select("select pname,batch_number,kept_on_date,total_product,total_sample,
                       ana_time_pro,ana_time_nsb,tatpp,tatps,chamber_stor_cond,remarks
                from(
                select 'ALL' all_data,sd.pname,batch_number,kept_on_date,kept_on_month,total_product,total_sample,ana_time_pro,ana_time_nsb,
                       total_product * nvl(ana_time_pro,0) tatpp,nvl(total_sample,0) * nvl(ana_time_nsb,0) tatps,chamber_stor_cond,remarks  
                from
                (select pname,batch_number,kept_on_date,to_char(kept_on_date,'MON-RR') kept_on_month,1 total_product,ana_time_pro,ana_time_nsb,chamber_stor_cond,remarks      
                from mis_fac.ssm_sample_data) sd,(select pname,count(*) total_sample      
                                                  from mis_fac.ssm_sample_data group by pname) tsq
                where sd.pname = tsq.pname
                )where ? = case when ? = 'ALL' then all_data else pname end	 
                and ? = case when ? = 'ALL' then all_data else to_char(batch_number) end
                and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                [$parameters['pname'], $parameters['pname'],
                    $parameters['batch_number'], $parameters['batch_number'], $parameters['chamber_stor_cond'], $parameters['chamber_stor_cond'],
                    $parameters['kept_on_date'], $parameters['kept_on_date']]);

            $data = ['pdata' => $data_pr];

            \Excel::create('Work Load Calculation', function ($excel) use ($data) {

                $excel->sheet('Work Load', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.sample.workloadexcellayout', $data);

                });


            })->export('xls');

        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }

    public function exportpdf($querypara){
        Log::info($querypara);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($querypara, $parameters);
            //Log::info($parameters);

            $data_pr = DB::select("select pname,batch_number,kept_on_date,total_product,total_sample,
                       ana_time_pro,ana_time_nsb,tatpp,tatps,chamber_stor_cond,remarks
                from(
                select 'ALL' all_data,sd.pname,batch_number,kept_on_date,kept_on_month,total_product,total_sample,ana_time_pro,ana_time_nsb,
                       total_product * nvl(ana_time_pro,0) tatpp,nvl(total_sample,0) * nvl(ana_time_nsb,0) tatps,chamber_stor_cond,remarks  
                from
                (select pname,batch_number,kept_on_date,to_char(kept_on_date,'MON-RR') kept_on_month,1 total_product,ana_time_pro,ana_time_nsb,chamber_stor_cond,remarks      
                from mis_fac.ssm_sample_data) sd,(select pname,count(*) total_sample      
                                                  from mis_fac.ssm_sample_data group by pname) tsq
                where sd.pname = tsq.pname
                )where ? = case when ? = 'ALL' then all_data else pname end	 
                and ? = case when ? = 'ALL' then all_data else to_char(batch_number) end
                and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                [$parameters['pname'], $parameters['pname'],
                    $parameters['batch_number'], $parameters['batch_number'], $parameters['chamber_stor_cond'], $parameters['chamber_stor_cond'],
                    $parameters['kept_on_date'], $parameters['kept_on_date']]);




            $pdf = \SPDF::loadView('ssm_views.reports.sample.workloadpdflayout', ['pdata' => $data_pr]);

            return $pdf->setPaper('a4','landscape')->download('Work_Load.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }

}
