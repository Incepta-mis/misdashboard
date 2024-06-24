<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyMachineRunStatusController extends Controller
{
    public function index()
    {
        $m_name = DB::select('select distinct m_name from mis_fac.ssm_daily_machine_run_status

                order by 1 asc');
        $m_id = DB::select('select distinct m_id from mis_fac.ssm_daily_machine_run_status
                order by 1 asc');
        $m_start_date_time = DB:: select("select distinct to_char(m_start_date_time,'DD-MON-RR')m_start_date_time from mis_fac.ssm_daily_machine_run_status
order by 1 asc");
        $pname = DB::select('select distinct pname from mis_fac.ssm_daily_machine_run_status
        order by 1 asc');
        $m_a_to = DB::select("select distinct m_a_to  from mis_fac.ssm_daily_machine_run_status
        order by 1 asc");
        return view('ssm_views.reports.result.dailymachinerunstatus',compact('m_name','m_id','m_start_date_time','pname','m_a_to'));
    }
    public function getvalues(Request $request)
    {


        $m_id = DB::select('select distinct m_id val from mis_fac.ssm_daily_machine_run_status where m_name = ?
                order by 1 asc', [$request->m_name]);
        $m_start_date_time = DB:: select("select distinct to_char(m_start_date_time,'DD-MON-RR') val from mis_fac.ssm_daily_machine_run_status where m_name = ?
order by 1 asc", [$request->m_name]);
        $pname = DB::select('select distinct pname val from mis_fac.ssm_daily_machine_run_status where m_name = ?
        order by 1 asc', [$request->m_name]);
        $m_a_to = DB::select("select distinct m_a_to val  from mis_fac.ssm_daily_machine_run_status where m_name = ?
        order by 1 asc", [$request->m_name]);


        return response()->json(['m_id'=>$m_id,'m_start_date_time'=>$m_start_date_time,'pname' => $pname, 'm_a_to' => $m_a_to]);
    }
    public function displayrecord(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');


        $result = DB::select("select m_id,m_name,m_a_to,pname,m_start_date_time,m_stop_date_time,m_r_time_total,m_idle_time,jomi_time
                            from(
                            select 'ALL' all_data,m_id,m_name,m_a_to,pname,m_start_date_time,m_stop_date_time,m_r_time_total,m_idle_time,jomi_time
                            from mis_fac.ssm_daily_machine_run_status
                            where m_start_date_time is not null
                            )where ? = case when ? = 'ALL' then all_data else m_name end
                            and ? = case when ? = 'ALL' then all_data else pname end
                            and ? = case when ? = 'ALL' then all_data else m_id end
                            and ? = case when ? = 'ALL' then all_data else to_char(to_date(m_start_date_time,'DD-MON-RR'),'DD-MON-RR') end
                            and ? = case when ? = 'ALL' then all_data else m_a_to end",
            [$request->m_name, $request->m_name,$request->pname, $request->pname, $request->m_id, $request->m_id,
                strtoupper($request->m_start_date_time), strtoupper($request->m_start_date_time), $request->m_a_to, $request->m_a_to]);
        return response()->json($result);
        Log::info($result);

    }
    public function exportexcel($querypara)
    {
        //Log::info($querypara);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($querypara, $parameters);
            //Log::info($parameters);


            $data_pr = DB::select("select m_id,m_name,m_a_to,pname,m_start_date_time,m_stop_date_time,m_r_time_total,m_idle_time,jomi_time
from(
select 'ALL' all_data,m_id,m_name,m_a_to,pname,m_start_date_time,m_stop_date_time,m_r_time_total,m_idle_time,jomi_time
from mis_fac.ssm_daily_machine_run_status
where m_start_date_time is not null
)where ? = case when ? = 'ALL' then all_data else m_name end
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else m_id end
 and ? = case when ? = 'ALL' then all_data else to_char(to_date(m_start_date_time,'DD-MON-RR'),'DD-MON-RR') end
and ? = case when ? = 'ALL' then all_data else m_a_to end",
                [$parameters['m_name'], $parameters['m_name'],$parameters['pname'], $parameters['pname'],
                    $parameters['m_id'], $parameters['m_id'], strtoupper($parameters['m_start_date_time']),strtoupper($parameters['m_start_date_time']), $parameters['m_a_to'], $parameters['m_a_to']]);


            $data = ['pdata1' => $data_pr];
//            dd ($data);

            \Excel::create('Daily machine Run Status', function ($excel) use ($data) {

                $excel->sheet('Daily machine Run Status', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.result.dailymachinerunstatusexcellayout', $data);


                });

            })->export('xls');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
    public function exportpdf($querypara)
    {
        //Log::info($querypara);
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];
            parse_str($querypara, $parameters);
            //Log::info($parameters);


            $data_pr = DB::select("select m_id,m_name,m_a_to,pname,m_start_date_time,m_stop_date_time,m_r_time_total,m_idle_time,jomi_time
from(
select 'ALL' all_data,m_id,m_name,m_a_to,pname,m_start_date_time,m_stop_date_time,m_r_time_total,m_idle_time,jomi_time
from mis_fac.ssm_daily_machine_run_status
where m_start_date_time is not null
)where ? = case when ? = 'ALL' then all_data else m_name end
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else m_id end
 and ? = case when ? = 'ALL' then all_data else to_char(to_date(m_start_date_time,'DD-MON-RR'),'DD-MON-RR') end
and ? = case when ? = 'ALL' then all_data else m_a_to end",
                [$parameters['m_name'], $parameters['m_name'],$parameters['pname'], $parameters['pname'],
                    $parameters['m_id'], $parameters['m_id'], strtoupper($parameters['m_start_date_time']), strtoupper($parameters['m_start_date_time']), $parameters['m_a_to'], $parameters['m_a_to']]);



            $pdf = \SPDF::loadView('ssm_views.reports.result.dailymachinerunstatusexcellayout', ['pdata1' => $data_pr]);

            return $pdf->setPaper('a4','landscape')->download('Daily_Machine_Run_Status.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}
