<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductListMaturedWithinAnytimeController extends Controller
{
   public function index()
   {
       $pname = DB::select('select distinct pname from mis_fac.ssm_sample_data
        order by 1 asc');
       $batch_number = DB:: select('select distinct batch_number from mis_fac.ssm_sample_data
order by 1 asc');
       $chamber_id = DB:: select('select distinct chamber_id from mis_fac.ssm_sample_data
order by 1 asc');
       $chamber_stor_loc = DB:: select('select distinct chamber_stor_loc from mis_fac.ssm_sample_data
order by 1 asc');
       $chamber_stor_cond = DB:: select('select distinct chamber_stor_cond from mis_fac.ssm_sample_data
order by 1 asc');
       return view('ssm_views.reports.sample.productlistmaturedwithanytime',compact('pname','batch_number','chamber_id','chamber_stor_loc','chamber_stor_cond'));
   }

    public function getvalues(Request $request)
    {

        $batch = DB:: select('select distinct batch_number val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $chamber_id = DB:: select('select distinct chamber_id val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $loc = DB:: select('select distinct chamber_stor_loc val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $cond = DB:: select('select distinct chamber_stor_cond val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);

        return response()->json(['batch' => $batch, 'chamber_id' => $chamber_id, 'loc' => $loc, 'cond' => $cond]);
    }
    public function displayrecord(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');
        Log::info($request->all());

        $result = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
       pulling_date,pulling_time_point,Initial_sample_Qty,rem_sample_qty,remarks
from(
select 'ALL' all_data,sd.pname,sd.batch_number,sd.chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
       tot_samp_qty_kfft Initial_sample_Qty,rem_sample_qty,remarks,
       case when to_date(kept_on_date,'DD-MON-RR')+ ? is null then add_months(kept_on_date,?) 
       else to_date(kept_on_date,'DD-MON-RR')+ ? end pull_mat_date,pulling_date,pulling_time_point
from mis_fac.ssm_sample_data sd,(select pname,batch_number,chamber_id,pulling_date,pulling_time_point
                                 from mis_fac.sample_pulling_data) spd
where sd.pname = spd.pname
and sd.batch_number = spd.batch_number
and sd.chamber_id = spd.chamber_id  
and case when to_date(kept_on_date,'DD-MON-RR')+ ? is null then add_months(kept_on_date,?) 
       else to_date(kept_on_date,'DD-MON-RR')+ ? end = pulling_date
)where to_date(pulling_date,'DD-MON-RR') = to_date(sysdate,'DD-MON-RR') 
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else batch_number end
and ? = case when ? = 'ALL' then all_data else chamber_id end
and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end",
            [$request->days,$request->months,$request->days,$request->days, $request->months,$request->days, $request->pname, $request->pname,
                $request->batch_number, $request->batch_number, $request->chamber_id, $request->chamber_id, $request->chamber_stor_loc, $request->chamber_stor_loc, $request->chamber_stor_cond, $request->chamber_stor_cond]);
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


            $data_pr = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
       pulling_date,pulling_time_point,Initial_sample_Qty,rem_sample_qty,remarks
from(
select 'ALL' all_data,sd.pname,sd.batch_number,sd.chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
       tot_samp_qty_kfft Initial_sample_Qty,rem_sample_qty,remarks,
       case when to_date(kept_on_date,'DD-MON-RR')+ ? is null then add_months(kept_on_date,?) 
       else to_date(kept_on_date,'DD-MON-RR')+ ? end pull_mat_date,pulling_date,pulling_time_point
from mis_fac.ssm_sample_data sd,(select pname,batch_number,chamber_id,pulling_date,pulling_time_point
                                 from mis_fac.sample_pulling_data) spd
where sd.pname = spd.pname
and sd.batch_number = spd.batch_number
and sd.chamber_id = spd.chamber_id  
and case when to_date(kept_on_date,'DD-MON-RR')+ ? is null then add_months(kept_on_date,?) 
       else to_date(kept_on_date,'DD-MON-RR')+ ? end = pulling_date
)where to_date(pulling_date,'DD-MON-RR') = to_date(sysdate,'DD-MON-RR') 
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else batch_number end
and ? = case when ? = 'ALL' then all_data else chamber_id end
and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end",
                [$parameters['days'], $parameters['months'],$parameters['days'], $parameters['days'],$parameters['months'],$parameters['days'],$parameters['pname'], $parameters['pname'],$parameters['batch_number'], $parameters['batch_number'],  $parameters['chamber_id'], $parameters['chamber_id'],
                    $parameters['chamber_stor_loc'], $parameters['chamber_stor_loc'],$parameters['chamber_stor_cond'],$parameters['chamber_stor_cond']]);


            $data = ['pdata1' => $data_pr];
//            dd ($data);

            \Excel::create('Product List Matured Within Anytime', function ($excel) use ($data) {

                $excel->sheet('Product List matured Today', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.sample.productlistmaturedwithinanytimeexcellayout', $data);


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


            $data_pr = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
       pulling_date,pulling_time_point,Initial_sample_Qty,rem_sample_qty,remarks
from(
select 'ALL' all_data,sd.pname,sd.batch_number,sd.chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
       tot_samp_qty_kfft Initial_sample_Qty,rem_sample_qty,remarks,
       case when to_date(kept_on_date,'DD-MON-RR')+ ? is null then add_months(kept_on_date,?) 
       else to_date(kept_on_date,'DD-MON-RR')+ ? end pull_mat_date,pulling_date,pulling_time_point
from mis_fac.ssm_sample_data sd,(select pname,batch_number,chamber_id,pulling_date,pulling_time_point
                                 from mis_fac.sample_pulling_data) spd
where sd.pname = spd.pname
and sd.batch_number = spd.batch_number
and sd.chamber_id = spd.chamber_id  
and case when to_date(kept_on_date,'DD-MON-RR')+ ? is null then add_months(kept_on_date,?) 
       else to_date(kept_on_date,'DD-MON-RR')+ ? end = pulling_date
)where to_date(pulling_date,'DD-MON-RR') = to_date(sysdate,'DD-MON-RR') 
and ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else batch_number end
and ? = case when ? = 'ALL' then all_data else chamber_id end
and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end",
                [$parameters['days'], $parameters['months'],$parameters['days'], $parameters['days'],$parameters['months'],$parameters['days'],$parameters['pname'], $parameters['pname'],$parameters['batch_number'], $parameters['batch_number'],  $parameters['chamber_id'], $parameters['chamber_id'],
                    $parameters['chamber_stor_loc'], $parameters['chamber_stor_loc'],$parameters['chamber_stor_cond'],$parameters['chamber_stor_cond']]);


            $pdf = \SPDF::loadView('ssm_views.reports.sample.productlistmaturedwithinanytimepdflayout', ['pdata1' => $data_pr]);

            return $pdf->setPaper('a4','landscape')->download('Product List Matured Within Anytime.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}
