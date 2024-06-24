<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonthlyStabilitySamplePlannerController extends Controller
{
    public function index()
    {
        $pname = DB::select('select distinct pname from mis_fac.ssm_sample_data
        order by 1 asc');
        $chamber_stor_cond = DB:: select('select distinct chamber_stor_cond from mis_fac.ssm_sample_data
order by 1 asc');
        $date = DB::select("select distinct to_char(kept_on_date,'MON-RR') kept_on_date  from mis_fac.ssm_sample_data
        order by 1 asc");
        return view ('ssm_views.reports.sample.monthlystabilitysampleplanner',compact('pname','batch_number','chamber_id', 'chamber_stor_loc', 'chamber_stor_cond','date'));
    }
    public function getvalues(Request $request)

    {
        DB::setDateFormat('MON-RR');
        $pname = DB::select("select distinct pname val from mis_fac.ssm_sample_data where to_char(kept_on_date,'MON-RR') = ?
        order by 1 asc",[$request->kept_on_date]);
        return response()->json(['pname' => $pname]);
    }
    public function displayrecord(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');
        Log::info($request->all());

        $result = DB::select("select *
from
(select pname,batch_number,test_duration,kept_on_date,chamber_stor_loc,chamber_stor_cond,sample_qc_test
from(
select 'ALL' all_data,smd.pname,smd.batch_number,test_duration,kept_on_date,chamber_stor_loc,chamber_stor_cond,smrd.sample_qc_test,to_char(kept_on_date,'MON-RR') kom
from mis_fac.ssm_sample_data smd,(select distinct sd.pname,sd.batch_number,test_dur||' '||test_dur_unit test_duration,sdr.sample_qc_test
                                    from mis_fac.ssm_sample_data sd,(select pname,batch_number,max(sample_qc_test) sample_qc_test,
                                                                              max(case when test_dur_unit = 'YEAR' then test_dur * 12 else test_dur end) tdm 
                                                                       from mis_fac.ssm_sample_data
                                                                       group by pname,batch_number) sdr
                                    where sd.pname = sdr.pname
                                    and sd.batch_number = sdr.batch_number
                                    and case when test_dur_unit = 'YEAR' then test_dur * 12 else test_dur end = tdm) smrd
where smd.pname = smrd.pname
and smd.batch_number = smrd.batch_number
and chamber_stor_cond in ('30 °C ± 2 °C/65% RH ± 5% RH','30 °C ± 2 °C/75% RH ± 5% RH','40 °C ± 2 °C/75% RH ± 5% RH',
                          '25 °C ± 2 °C/60% RH ± 5% RH','5 °C ± 3 °C')
)where ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else kom end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
)pivot (max(chamber_stor_loc) for chamber_stor_cond in ('30 °C ± 2 °C/65% RH ± 5% RH' as a3065,'30 °C ± 2 °C/75% RH ± 5% RH' as b3075,'40 °C ± 2 °C/75% RH ± 5% RH' as c4075,
                                                        '25 °C ± 2 °C/60% RH ± 5% RH' as d2560,'5 °C ± 3 °C' as e53))
order by pname,batch_number                         ",
            [$request->pname, $request->pname,$request->kept_on_date, $request->kept_on_date,$request->chamber_stor_cond, $request->chamber_stor_cond]);
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
//dd($parameters);

            $data_pr = DB::select("select *
from
(select pname,batch_number,test_duration,kept_on_date,chamber_stor_loc,chamber_stor_cond,sample_qc_test
from(
select 'ALL' all_data,smd.pname,smd.batch_number,test_duration,kept_on_date,chamber_stor_loc,chamber_stor_cond,smrd.sample_qc_test,to_char(kept_on_date,'MON-RR') kom
from mis_fac.ssm_sample_data smd,(select distinct sd.pname,sd.batch_number,test_dur||' '||test_dur_unit test_duration,sdr.sample_qc_test
                                    from mis_fac.ssm_sample_data sd,(select pname,batch_number,max(sample_qc_test) sample_qc_test,
                                                                              max(case when test_dur_unit = 'YEAR' then test_dur * 12 else test_dur end) tdm 
                                                                       from mis_fac.ssm_sample_data
                                                                       group by pname,batch_number) sdr
                                    where sd.pname = sdr.pname
                                    and sd.batch_number = sdr.batch_number
                                    and case when test_dur_unit = 'YEAR' then test_dur * 12 else test_dur end = tdm) smrd
where smd.pname = smrd.pname
and smd.batch_number = smrd.batch_number
and chamber_stor_cond in ('30 °C ± 2 °C/65% RH ± 5% RH','30 °C ± 2 °C/75% RH ± 5% RH','40 °C ± 2 °C/75% RH ± 5% RH',
                          '25 °C ± 2 °C/60% RH ± 5% RH','5 °C ± 3 °C')
)where ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else kom end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
)pivot (max(chamber_stor_loc) for chamber_stor_cond in ('30 °C ± 2 °C/65% RH ± 5% RH' as a3065,'30 °C ± 2 °C/75% RH ± 5% RH' as b3075,'40 °C ± 2 °C/75% RH ± 5% RH' as c4075,
                                                        '25 °C ± 2 °C/60% RH ± 5% RH' as d2560,'5 °C ± 3 °C' as e53))
order by pname,batch_number",
                [$parameters['pname'],$parameters['pname'], $parameters['kept_on_date'], $parameters['kept_on_date'],$parameters['chamber_stor_cond'],$parameters['chamber_stor_cond']]);


            $data = ['pdata1' => $data_pr];
// dd ($data);

            \Excel::create('Monthly Stability Sample Planner', function ($excel) use ($data) {

                $excel->sheet('Monthly S.S.Planner', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.sample.monthlystabilitysampleplannerexcellayout', $data);


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
(select pname,batch_number,test_duration,kept_on_date,chamber_stor_loc,chamber_stor_cond,sample_qc_test
from(
select 'ALL' all_data,smd.pname,smd.batch_number,test_duration,kept_on_date,chamber_stor_loc,chamber_stor_cond,smrd.sample_qc_test,to_char(kept_on_date,'MON-RR') kom
from mis_fac.ssm_sample_data smd,(select distinct sd.pname,sd.batch_number,test_dur||' '||test_dur_unit test_duration,sdr.sample_qc_test
                                    from mis_fac.ssm_sample_data sd,(select pname,batch_number,max(sample_qc_test) sample_qc_test,
                                                                              max(case when test_dur_unit = 'YEAR' then test_dur * 12 else test_dur end) tdm 
                                                                       from mis_fac.ssm_sample_data
                                                                       group by pname,batch_number) sdr
                                    where sd.pname = sdr.pname
                                    and sd.batch_number = sdr.batch_number
                                    and case when test_dur_unit = 'YEAR' then test_dur * 12 else test_dur end = tdm) smrd
where smd.pname = smrd.pname
and smd.batch_number = smrd.batch_number
and chamber_stor_cond in ('30 °C ± 2 °C/65% RH ± 5% RH','30 °C ± 2 °C/75% RH ± 5% RH','40 °C ± 2 °C/75% RH ± 5% RH',
                          '25 °C ± 2 °C/60% RH ± 5% RH','5 °C ± 3 °C')
)where ? = case when ? = 'ALL' then all_data else pname end
and ? = case when ? = 'ALL' then all_data else kom end
and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
)pivot (max(chamber_stor_loc) for chamber_stor_cond in ('30 °C ± 2 °C/65% RH ± 5% RH' as a3065,'30 °C ± 2 °C/75% RH ± 5% RH' as b3075,'40 °C ± 2 °C/75% RH ± 5% RH' as c4075,
                                                        '25 °C ± 2 °C/60% RH ± 5% RH' as d2560,'5 °C ± 3 °C' as e53))
order by pname,batch_number",
                [$parameters['pname'], $parameters['pname'],$parameters['kept_on_date'], $parameters['kept_on_date'], $parameters['chamber_stor_cond'],$parameters['chamber_stor_cond']]);


            $pdf = \SPDF::loadView('ssm_views.reports.sample.monthlystabilitysampleplannerpdflayout', ['pdata1' => $data_pr]);

            return $pdf->setPaper('a4','landscape')->download('Chamber Wise Product List.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}
