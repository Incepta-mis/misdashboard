<?php

namespace App\Http\Controllers\ssm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalystWiseProdyctListController extends Controller
{
    public function index()
    {
        $pname = DB::select('select distinct pname from mis_fac.ssm_sample_data
        order by 1 asc');
        $batch_number = DB:: select('select distinct batch_number from mis_fac.ssm_sample_data
order by 1 asc');
        $m_a_to = DB:: select('select distinct m_a_to from mis_fac.ssm_daily_machine_run_status

order by 1 asc');
        $chamber_stor_cond = DB:: select('select distinct chamber_stor_cond from mis_fac.ssm_sample_data
order by 1 asc');
        $time_point = DB::select("select distinct analyst_result_time time_point  from mis_fac.analyst_result_data
        order by 1 asc");
        $test_parameters = DB::select("select distinct tp_name test_parameters  from mis_fac.ssm_result_test_parameter
order by 1 asc");
        return view('ssm_views.reports.sample.analystwiseproductlist', compact('pname', 'batch_number', 'm_a_to', 'chamber_stor_cond', 'time_point','test_parameters'));
    }

    public function getvalues(Request $request)
    {
        $batch = DB:: select('select distinct batch_number val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $m_a_to = DB:: select('select distinct m_a_to val from mis_fac.ssm_daily_machine_run_status where pname = ?
order by 1 asc', [$request->pname]);
        $cond = DB:: select('select distinct chamber_stor_cond val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $time_point = DB::select("select distinct analyst_result_time  val  from mis_fac.analyst_result_data where pname = ?
        order by 1 asc", [$request->pname]);
        $test_parameters = DB::select("select distinct tp_name val  from mis_fac.ssm_result_test_parameter
order by 1 asc");
        return response()->json(['batch' => $batch, 'm_a_to' => $m_a_to, 'cond' => $cond, 'time_point' => $time_point, 'm_a_to' => $m_a_to,'test_parameters'=>$test_parameters]);
    }


    public function displayrecord(Request $request)
    {
        DB::setDateFormat('MON-RR');


        $result = DB::select("select pname,batch_number,kept_on_date,analyst_name,time_point,chamber_stor_cond,stab_type
from
(
select 'ALL' all_data,rd.pname,rd.batch_number,kept_on_date,analyst_emp_name analyst_name,analyst_result_time time_point,
       rd.test_parameters,rd.chamber_stor_cond,rd.accept_criteria,stab_type,tp_no,sl
from mis_fac.ssm_result_data rd,mis_fac.analyst_result_data ard,( select distinct pname,batch_number,kept_on_date
                                                                  from mis_fac.ssm_sample_data                                  
                                                                ) sd
where rd.pname =  ard.pname 
and rd.batch_number = ard.batch_number
and rd.test_parameters = ard.test_parameters
and rd.chamber_stor_cond = ard.chamber_stor_cond
and rd.accept_criteria = ard.accept_criteria
and rd.pname(+) = sd.pname
and rd.batch_number(+) = sd.batch_number
)where ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else batch_number end
and ? = case when ? = 'ALL' then all_data else analyst_name end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
and ? = case when ? = 'ALL' then all_data else time_point end
and ? = case when ? = 'ALL' then all_data else test_parameters end
order by pname,tp_no,sl",
            [$request->pname, $request->pname,
                $request->batch_number, $request->batch_number, $request->m_a_to, $request->m_a_to, $request->chamber_stor_cond, $request->chamber_stor_cond, $request->time_point, $request->time_point, $request->test_parameters, $request->test_parameters]);
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


            $data_pr = DB::select("select pname,batch_number,kept_on_date,analyst_name,time_point,chamber_stor_cond,stab_type
from(
select 'ALL' all_data,rd.pname,rd.batch_number,kept_on_date,rd.chamber_id,test_parameters,time_point,chamber_stor_cond,stab_type,m_a_to analyst_name 

from mis_fac.ssm_result_data rd,( select distinct pname,batch_number,chamber_id,kept_on_date
                                  from mis_fac.ssm_sample_data) sd
where test_parameters = 'DESCRIPTION'
and rd.pname = sd.pname(+)
and rd.batch_number = sd.batch_number(+)
and rd.chamber_id = sd.chamber_id(+)
)where ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else batch_number end
and ? = case when ? = 'ALL' then all_data else analyst_name end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
and ? = case when ? = 'ALL' then all_data else to_char(time_point) end",
                [$parameters['pname'], $parameters['pname'], $parameters['batch_number'], $parameters['batch_number'], $parameters['m_a_to'],
                    $parameters['m_a_to'], $parameters['chamber_stor_cond'], $parameters['chamber_stor_cond'], $parameters['time_point'], $parameters['time_point']]);


            $data = ['pdata1' => $data_pr];
//            dd ($data);

            \Excel::create('Analyst Wise Product List', function ($excel) use ($data) {

                $excel->sheet('Analyst Wise Product List', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.sample.analystwiseproductlistexcellayout', $data);


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


            $data_pr = DB::select("select pname,batch_number,kept_on_date,analyst_name,time_point,chamber_stor_cond,stab_type
from(
select 'ALL' all_data,rd.pname,rd.batch_number,kept_on_date,rd.chamber_id,test_parameters,time_point,chamber_stor_cond,stab_type,m_a_to analyst_name 

from mis_fac.ssm_result_data rd,( select distinct pname,batch_number,chamber_id,kept_on_date
                                  from mis_fac.ssm_sample_data) sd
where test_parameters = 'DESCRIPTION'
and rd.pname = sd.pname(+)
and rd.batch_number = sd.batch_number(+)
and rd.chamber_id = sd.chamber_id(+)
)where ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else batch_number end
and ? = case when ? = 'ALL' then all_data else analyst_name end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
and ? = case when ? = 'ALL' then all_data else to_char(time_point) end",
                [$parameters['pname'], $parameters['pname'], $parameters['batch_number'], $parameters['batch_number'], $parameters['m_a_to'],
                    $parameters['m_a_to'], $parameters['chamber_stor_cond'], $parameters['chamber_stor_cond'], $parameters['time_point'], $parameters['time_point']]);


            $pdf = \SPDF::loadView('ssm_views.reports.sample.analystwiseproductlistpdflayout', ['pdata1' => $data_pr]);

            return $pdf->setPaper('a4', 'landscape')->download('Analyst Wise Product List.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }


}
