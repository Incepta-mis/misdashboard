<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPExcel_Worksheet_Drawing;

class MachineUtilizationCalculationController extends Controller
{
    public function index()
    {
        $m_id = DB::select('select distinct M_ID from mis_fac.ssm_daily_machine_run_status
                order by 1 asc');
        $pname = DB::select('select distinct pname from mis_fac.ssm_daily_machine_run_status
        order by 1 asc');
        $batch_number = DB:: select('select distinct batch_number from mis_fac.ssm_daily_machine_run_status
order by 1 asc');
        return view('ssm_views.reports.sample.machineuticalc', compact('m_id', 'pname', 'batch_number'));
    }

    public function getvalues(Request $request)
    {

        $pname = DB::select('select distinct pname val from mis_fac.SSM_DAILY_MACHINE_RUN_STATUS where m_id = ?
                order by 1 asc', [$request->m_id]);
        $batch = DB::select('select distinct batch_number val from mis_fac.SSM_DAILY_MACHINE_RUN_STATUS where m_id = ?
               order by 1 asc', [$request->m_id]);



        return response()->json(['pname' => $pname, 'batch' => $batch]);
    }

    public function displayrecord(Request $request)
    {
        DB::setDateFormat('MON-RR');


        $result = DB::select("select m_id,pname,batch_number,time_point,to_char(m_start_date_time,'DD-MON-RR HH:MI AM')m_start_date_time,to_char(m_stop_date_time,'DD-MON-RR HH:MI AM')m_stop_date_time,tot_min,tot_mh,remarks
from(

select 'ALL' all_data,rd.m_id,rd.pname,rd.batch_number,rd.time_point,rd.m_start_date_time,rd.m_stop_date_time,
       case when rd.m_r_time_total is null then (m_stop_date_time - m_start_date_time) * 24 * 60 else rd.m_r_time_total end tot_min, 
       case when rd.m_r_time_total is null then trunc(((m_stop_date_time-m_start_date_time)*24*60)/60)||':'||
       trunc(mod(((m_stop_date_time-m_start_date_time)*24*60),60)) else to_char(rd.m_r_time_total) end tot_mh,remarks 
from
(select dmr.m_id,dmr.pname,dmr.batch_number,srd.time_point,dmr.m_start_date_time,dmr.m_stop_date_time,dmr.m_r_time_total,remarks         
from mis_fac.ssm_result_data srd, MIS_FAC.SSM_DAILY_MACHINE_RUN_STATUS dmr
where srd.pname = dmr.PNAME
and srd.BATCH_NUMBER = dmr.BATCH_NUMBER ) rd,

(select m_id,dmr.pname,time_point,min(m_start_date_time) m_msdt
from mis_fac.ssm_result_data srd, MIS_FAC.SSM_DAILY_MACHINE_RUN_STATUS dmr
where srd.pname = dmr.PNAME
and srd.BATCH_NUMBER = dmr.BATCH_NUMBER 
and m_start_date_time is not null
group by m_id,dmr.pname,time_point
) rd_sdt

where rd.pname = rd_sdt.pname
and rd.m_id = rd_sdt.m_id
and rd.time_point = rd_sdt.time_point
and rd.m_start_date_time = rd_sdt.m_msdt
)where ? = case when ? = 'ALL' then all_data else m_id end
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else ? end
",
            [$request->m_id, $request->m_id, $request->pname, $request->pname,
                $request->batch_number, $request->batch_number, $request->batch_number]);
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


            $data_pr = DB::select("select m_id,pname,batch_number,time_point,m_start_date_time,m_stop_date_time,tot_min,tot_mh,remarks
from(

select 'ALL' all_data,rd.m_id,rd.pname,rd.batch_number,rd.time_point,rd.m_start_date_time,rd.m_stop_date_time,
       case when rd.m_r_time_total is null then (m_stop_date_time - m_start_date_time) * 24 * 60 else rd.m_r_time_total end tot_min, 
       case when rd.m_r_time_total is null then trunc(((m_stop_date_time-m_start_date_time)*24*60)/60)||':'||
       trunc(mod(((m_stop_date_time-m_start_date_time)*24*60),60)) else to_char(rd.m_r_time_total) end tot_mh,remarks 
from
(select dmr.m_id,dmr.pname,dmr.batch_number,srd.time_point,dmr.m_start_date_time,dmr.m_stop_date_time,dmr.m_r_time_total,remarks         
from mis_fac.ssm_result_data srd, MIS_FAC.SSM_DAILY_MACHINE_RUN_STATUS dmr
where srd.pname = dmr.PNAME
and srd.BATCH_NUMBER = dmr.BATCH_NUMBER ) rd,

(select m_id,dmr.pname,time_point,min(m_start_date_time) m_msdt
from mis_fac.ssm_result_data srd, MIS_FAC.SSM_DAILY_MACHINE_RUN_STATUS dmr
where srd.pname = dmr.PNAME
and srd.BATCH_NUMBER = dmr.BATCH_NUMBER 
and m_start_date_time is not null
group by m_id,dmr.pname,time_point
) rd_sdt

where rd.pname = rd_sdt.pname
and rd.m_id = rd_sdt.m_id
and rd.time_point = rd_sdt.time_point
and rd.m_start_date_time = rd_sdt.m_msdt
)where ? = case when ? = 'ALL' then all_data else m_id end
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else ? end",
                [$parameters['m_id'], $parameters['m_id'],
                    $parameters['pname'], $parameters['pname'], $parameters['batch_number'], $parameters['batch_number'], $parameters['batch_number']]);


            $data = ['pdata1' => $data_pr];
//            dd ($data);

            \Excel::create('Machine Utilization Calcultaion', function ($excel) use ($data) {

                $excel->sheet('Machine Utilization Calcultaion', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.sample.machineuticalcexcellayout', $data);


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


            $data_pr = DB::select("select m_id,pname,batch_number,time_point,to_char(m_start_date_time,'DD-MON-RR HH:MI AM')m_start_date_time,to_char(m_stop_date_time,'DD-MON-RR HH:MI AM')m_stop_date_time,tot_min,tot_mh,remarks
from(

select 'ALL' all_data,rd.m_id,rd.pname,rd.batch_number,rd.time_point,rd.m_start_date_time,rd.m_stop_date_time,
       case when rd.m_r_time_total is null then (m_stop_date_time - m_start_date_time) * 24 * 60 else rd.m_r_time_total end tot_min, 
       case when rd.m_r_time_total is null then trunc(((m_stop_date_time-m_start_date_time)*24*60)/60)||':'||
       trunc(mod(((m_stop_date_time-m_start_date_time)*24*60),60)) else to_char(rd.m_r_time_total) end tot_mh,remarks 
from
(select dmr.m_id,dmr.pname,dmr.batch_number,srd.time_point,dmr.m_start_date_time,dmr.m_stop_date_time,dmr.m_r_time_total,remarks         
from mis_fac.ssm_result_data srd, MIS_FAC.SSM_DAILY_MACHINE_RUN_STATUS dmr
where srd.pname = dmr.PNAME
and srd.BATCH_NUMBER = dmr.BATCH_NUMBER ) rd,

(select m_id,dmr.pname,time_point,min(m_start_date_time) m_msdt
from mis_fac.ssm_result_data srd, MIS_FAC.SSM_DAILY_MACHINE_RUN_STATUS dmr
where srd.pname = dmr.PNAME
and srd.BATCH_NUMBER = dmr.BATCH_NUMBER 
and m_start_date_time is not null
group by m_id,dmr.pname,time_point
) rd_sdt

where rd.pname = rd_sdt.pname
and rd.m_id = rd_sdt.m_id
and rd.time_point = rd_sdt.time_point
and rd.m_start_date_time = rd_sdt.m_msdt
)where ? = case when ? = 'ALL' then all_data else m_id end
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else ? end",
                [$parameters['m_id'], $parameters['m_id'],
                    $parameters['pname'], $parameters['pname'], $parameters['batch_number'], $parameters['batch_number'], $parameters['batch_number']]);


            $pdf = \SPDF::loadView('ssm_views.reports.sample.machineuticalcpdflayout', ['pdata1' => $data_pr]);

            return $pdf->setPaper('a4','landscape')->download('Machine_Utilization_Calculation.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}
