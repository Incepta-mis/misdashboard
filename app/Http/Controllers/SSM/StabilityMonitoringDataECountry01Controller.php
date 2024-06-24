<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPExcel_Worksheet_Drawing;

class StabilityMonitoringDataECountry01Controller extends Controller
{
    public function index()
    {
        $pname = DB::select('select distinct pname from mis_fac.ssm_result_data
        order by 1 asc');
        $batch_number = DB::select('select distinct batch_number from mis_fac.ssm_result_data
        order by 1 asc');
        $export_country = DB::select('select distinct export_country from mis_fac.ssm_sample_data
        order by 1 asc');
        $test_parameters = DB::select('select distinct test_parameters from mis_fac.ssm_result_data
        order by 1 asc');
        return view('ssm_views.reports.result.stabilitymonitoringdataecountry01',compact('pname','batch_number','export_country','test_parameters'));
    }
    public function getvalues(Request $request)
    {


        $batch_number = DB::select('select distinct batch_number val from mis_fac.ssm_result_data where pname = ?
        order by 1 asc', [$request->pname]);
        $export_country = DB::select('select distinct export_country val from mis_fac.ssm_sample_data where pname = ?
        order by 1 asc',[$request->pname]);
        $test_parameters = DB::select('select distinct test_parameters val from mis_fac.ssm_result_data where pname = ?
        order by 1 asc', [$request->pname]);

        return response()->json(['batch_number'=>$batch_number,'export_country'=>$export_country,'test_parameters'=>$test_parameters]);
    }
    public function displayrecord(Request $request)
    {

        DB::setDateFormat('DD-MON-RR');


        $result = DB::select("select *
from
(select 'ALL' all_data,pname,Country_Name,batch_number,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,average_result,tp_no,
        row_number() over (partition by tp_no order by tp_no,csc,sl) as row_no
from(
select sd.pname,sd.batch_number,Country_Name,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,
       average_result,average_result_time,tp_no,sl,substr(chamber_stor_cond,1,2) csc 
from mis_fac.average_result_data ard,(select distinct pname,batch_number,export_country Country_Name,kept_on_date,mode_of_pack,p_size
                                       from mis_fac.ssm_sample_data) sd
where ard.pname = sd.pname
and ard.batch_number = sd.batch_number
and chamber_stor_cond = '30 °C ± 2 °C/65% RH ± 5% RH'
and average_result_time in ('INITIAL','3M','6M','9M','12M','18M','24M')
and sd.pname = ?
and sd.batch_number = ?
and sd.Country_Name = ?
union all
select sd.pname,sd.batch_number,Country_Name,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,
       average_result,average_result_time,tp_no,sl,substr(chamber_stor_cond,1,2) csc 
from mis_fac.average_result_data ard,(select distinct pname,batch_number,export_country Country_Name,kept_on_date,mode_of_pack,p_size
                                       from mis_fac.ssm_sample_data) sd
where ard.pname = sd.pname
and ard.batch_number = sd.batch_number
and chamber_stor_cond = '40 °C ± 2 °C/75% RH ± 5% RH'
and average_result_time in ('3M','6M')
and sd.pname = ?
and sd.batch_number = ?
and sd.Country_Name = ?
))pivot (max(average_result) for row_no in (1 as a,2 as b,3 as c,4 as d,5 as e,6 as f,7 as g,8 as h,9 as i))
where ? = case when ? = 'ALL' then all_data else test_parameters end
order by tp_no",
            [$request->pname,$request->batch_number,$request->export_country,$request->pname,$request->batch_number,$request->export_country,$request->test_parameters,$request->test_parameters]);
        return response()->json($result);
        Log::info($result);

    }
    public function exportexcel($querypara)
    {
        Log::info($querypara);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($querypara, $parameters);
            //Log::info($parameters);


            $data_pr = DB::select("select *
from
(select 'ALL' all_data,pname,Country_Name,batch_number,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,average_result,tp_no,
        row_number() over (partition by tp_no order by tp_no,csc,sl) as row_no
from(
select sd.pname,sd.batch_number,Country_Name,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,
       average_result,average_result_time,tp_no,sl,substr(chamber_stor_cond,1,2) csc 
from mis_fac.average_result_data ard,(select distinct pname,batch_number,export_country Country_Name,kept_on_date,mode_of_pack,p_size
                                       from mis_fac.ssm_sample_data) sd
where ard.pname = sd.pname
and ard.batch_number = sd.batch_number
and chamber_stor_cond = '30 °C ± 2 °C/65% RH ± 5% RH'
and average_result_time in ('INITIAL','3M','6M','9M','12M','18M','24M')
and sd.pname = ?
and sd.batch_number = ?
and sd.Country_Name = ?
union all
select sd.pname,sd.batch_number,Country_Name,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,
       average_result,average_result_time,tp_no,sl,substr(chamber_stor_cond,1,2) csc 
from mis_fac.average_result_data ard,(select distinct pname,batch_number,export_country Country_Name,kept_on_date,mode_of_pack,p_size
                                       from mis_fac.ssm_sample_data) sd
where ard.pname = sd.pname
and ard.batch_number = sd.batch_number
and chamber_stor_cond = '40 °C ± 2 °C/75% RH ± 5% RH'
and average_result_time in ('3M','6M')
and sd.pname = ?
and sd.batch_number = ?
and sd.Country_Name = ?
))pivot (max(average_result) for row_no in (1 as a,2 as b,3 as c,4 as d,5 as e,6 as f,7 as g,8 as h,9 as i))
where ? = case when ? = 'ALL' then all_data else test_parameters end
order by tp_no",
                [$parameters['pname'], $parameters['batch_number'],$parameters['export_country'],$parameters['pname'], $parameters['batch_number'],
                    $parameters['export_country'],
                    $parameters['test_parameters'],$parameters['test_parameters']]);


            $data = ['pdata1' => $data_pr,'pname'=>$parameters['pname'],'batch_number'=>$parameters['batch_number']
                ,'KOD'=>isset($data_pr[0]->kept_on_date) ? $data_pr[0]->kept_on_date : null,'PS'=>isset($data_pr[0]->p_size) ? $data_pr[0]->p_size : null,'MOP'=>isset($data_pr[0]->mode_of_pack) ? $data_pr[0]->mode_of_pack : null];
//            dd ($data);

            \Excel::create('Summary', function ($excel) use ($data) {

                $excel->sheet('Summary', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.result.stabilitymonitoringdataecountry01excellayout', $data);
                    $sheet->setWidth(array(
                        'A' => 30,
                        'B' => 30,
                        'C' => 30,
                        'D' => 10,
                        'E' => 10,
                        'F' => 10,
                        'G' => 10,
                        'H' => 10,
                        'I' => 10,
                        'J' => 10,
                        'K' => 10
                    ));
                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('site_resource/images/INCEPTALOGO.png'));
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setOffsetX(80);                       //setOffsetX works properly
                    $objDrawing->setOffsetY(10);
                    $objDrawing->setWidth(30);
                    $objDrawing->setHeight(40);
                    $objDrawing->setWorksheet($sheet);
                });

            })->export('xls');
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


            $data_pr = DB::select("select *
from
(select 'ALL' all_data,pname,Country_Name,batch_number,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,average_result,tp_no,
        row_number() over (partition by tp_no order by tp_no,csc,sl) as row_no
from(
select sd.pname,sd.batch_number,Country_Name,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,
       average_result,average_result_time,tp_no,sl,substr(chamber_stor_cond,1,2) csc 
from mis_fac.average_result_data ard,(select distinct pname,batch_number,export_country Country_Name,kept_on_date,mode_of_pack,p_size
                                       from mis_fac.ssm_sample_data) sd
where ard.pname = sd.pname
and ard.batch_number = sd.batch_number
and chamber_stor_cond = '30 °C ± 2 °C/65% RH ± 5% RH'
and average_result_time in ('INITIAL','3M','6M','9M','12M','18M','24M')
and sd.pname = ?
and sd.batch_number = ?
and sd.Country_Name = ?
union all
select sd.pname,sd.batch_number,Country_Name,kept_on_date,mode_of_pack,p_size,test_parameters,accept_criteria,
       average_result,average_result_time,tp_no,sl,substr(chamber_stor_cond,1,2) csc 
from mis_fac.average_result_data ard,(select distinct pname,batch_number,export_country Country_Name,kept_on_date,mode_of_pack,p_size
                                       from mis_fac.ssm_sample_data) sd
where ard.pname = sd.pname
and ard.batch_number = sd.batch_number
and chamber_stor_cond = '40 °C ± 2 °C/75% RH ± 5% RH'
and average_result_time in ('3M','6M')
and sd.pname = ?
and sd.batch_number = ?
and sd.Country_Name = ?
))pivot (max(average_result) for row_no in (1 as a,2 as b,3 as c,4 as d,5 as e,6 as f,7 as g,8 as h,9 as i))
where ? = case when ? = 'ALL' then all_data else test_parameters end
order by tp_no",
                [$parameters['pname'], $parameters['batch_number'],$parameters['export_country'],$parameters['pname'], $parameters['batch_number'],
                    $parameters['export_country'], $parameters['test_parameters'],$parameters['test_parameters']]);


//dd($data_pr);
            $pdf = \SPDF::loadView('ssm_views.reports.result.stabilitymonitoringdataecountry01pdflayout', ['pdata1' => $data_pr,'pname'=>$parameters['pname'],'batch_number'=>$parameters['batch_number']
                ,'KOD'=>isset($data_pr[0]->kept_on_date) ? $data_pr[0]->kept_on_date : null,'PS'=>isset($data_pr[0]->p_size) ? $data_pr[0]->p_size : null,'MOP'=>isset($data_pr[0]->mode_of_pack) ? $data_pr[0]->mode_of_pack : null]);


            return $pdf->setPaper('a4','landscape')->download('SUMMARY.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}
