<?php

namespace App\Http\Controllers\SSM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChamberWiseProductListController extends Controller
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
       $date = DB::select("select distinct to_char(kept_on_date,'MON-RR') kept_on_date  from mis_fac.ssm_sample_data
        order by 1 asc");
       return view ('ssm_views.reports.sample.chamberwiseproductlist',compact('pname','batch_number','chamber_id', 'chamber_stor_loc', 'chamber_stor_cond','date'));
   }
    public function getvalues(Request $request)

    {
//        DB::setDateFormat('MON-RR');
        $batch = DB:: select('select distinct batch_number val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $chamber_id = DB:: select('select distinct chamber_id val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $loc = DB:: select('select distinct chamber_stor_loc val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
       $cond = DB:: select('select distinct chamber_stor_cond val from mis_fac.ssm_sample_data where pname = ?
order by 1 asc', [$request->pname]);
        $date = DB::select("select distinct to_char(kept_on_date,'MON-RR') kept_on_date   from mis_fac.ssm_sample_data where pname = ?
        order by 1 asc", [$request->pname]);
        return response()->json(['batch' => $batch, 'chamber_id' => $chamber_id, 'loc' => $loc, 'cond' => $cond, 'date' => $date]);
    }


    public function displayrecord(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');
        Log::info($request->all());

        $result = [];
        if($request->pname == 'ALL'){
            $result = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,initial_sample_qty,rem_sample_qty,remarks
                        from(
                        select 'ALL' all_data,pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
                               to_char(kept_on_date,'MON-RR') kept_on_month,tot_samp_qty_kfft initial_sample_qty,rem_sample_qty,remarks       
                        from mis_fac.ssm_sample_data
                        )where ? = case when ? = 'ALL' then all_data else pname end
                        and ? = case when ? = 'ALL' then all_data else batch_number end
                        and ? = case when ? = 'ALL' then all_data else chamber_id end
                        and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
                        and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                        and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                [$request->pname, $request->pname,
                    $request->batch_number, $request->batch_number,
                    $request->chamber_id, $request->chamber_id,
                    $request->chamber_stor_loc, $request->chamber_stor_loc,
                    $request->chamber_stor_cond, $request->chamber_stor_cond,
                    $request->kept_on_date, $request->kept_on_date]);
        }else{
            $result = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,initial_sample_qty,rem_sample_qty,remarks
                        from(
                        select 'ALL' all_data,pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
                               to_char(kept_on_date,'MON-RR') kept_on_month,tot_samp_qty_kfft initial_sample_qty,rem_sample_qty,remarks       
                        from mis_fac.ssm_sample_data
                        )where pname in ('$request->pname')
                        and ? = case when ? = 'ALL' then all_data else batch_number end
                        and ? = case when ? = 'ALL' then all_data else chamber_id end
                        and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
                        and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                        and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                [
                    $request->batch_number, $request->batch_number,
                    $request->chamber_id, $request->chamber_id,
                    $request->chamber_stor_loc, $request->chamber_stor_loc,
                    $request->chamber_stor_cond, $request->chamber_stor_cond,
                    $request->kept_on_date, $request->kept_on_date]);
        }

        return response()->json($result);
//        Log::info($result);

    }


    public function exportexcel($querypara)
    {
        DB::setDateFormat('DD-MON-RR');

        try {
            $parameters = [];

            parse_str($querypara, $parameters);
            $data_pr = [];

            if($parameters['pname'] == 'ALL'){
                $data_pr = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,initial_sample_qty,rem_sample_qty,remarks
                                from(
                                select 'ALL' all_data,pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
                                       to_char(kept_on_date,'MON-RR') kept_on_month,tot_samp_qty_kfft initial_sample_qty,rem_sample_qty,remarks       
                                from mis_fac.ssm_sample_data
                                )where ? = case when ? = 'ALL' then all_data else pname end
                                and ? = case when ? = 'ALL' then all_data else batch_number end
                                and ? = case when ? = 'ALL' then all_data else chamber_id end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                                and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                    [$parameters['pname'], $parameters['pname'], $parameters['batch_number'], $parameters['batch_number'], $parameters['chamber_id'], $parameters['chamber_id'],
                        $parameters['chamber_stor_loc'], $parameters['chamber_stor_loc'], $parameters['chamber_stor_cond'],$parameters['chamber_stor_cond'],
                        $parameters['kept_on_date'], $parameters['kept_on_date']]);
            }else{
                $products = $parameters['pname'];
                $data_pr = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,initial_sample_qty,rem_sample_qty,remarks
                                from(
                                select 'ALL' all_data,pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
                                       to_char(kept_on_date,'MON-RR') kept_on_month,tot_samp_qty_kfft initial_sample_qty,rem_sample_qty,remarks       
                                from mis_fac.ssm_sample_data
                                )where pname in ('$products')
                                and ? = case when ? = 'ALL' then all_data else batch_number end
                                and ? = case when ? = 'ALL' then all_data else chamber_id end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                                and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                    [$parameters['batch_number'], $parameters['batch_number'], $parameters['chamber_id'], $parameters['chamber_id'],
                        $parameters['chamber_stor_loc'], $parameters['chamber_stor_loc'], $parameters['chamber_stor_cond'],$parameters['chamber_stor_cond'],
                        $parameters['kept_on_date'], $parameters['kept_on_date']]);
            }

            $data = ['pdata1' => $data_pr];

            \Excel::create('Chamber Wise Product List', function ($excel) use ($data) {

                $excel->sheet('Chamber Wise Product List', function ($sheet) use ($data) {
                    $sheet->loadView('ssm_views.reports.sample.chamberwiseproductlistexcellayout', $data);


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

            $data_pr = [];

            if($parameters['pname'] == 'ALL'){
                $data_pr = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,initial_sample_qty,rem_sample_qty,remarks
                                from(
                                select 'ALL' all_data,pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
                                       to_char(kept_on_date,'MON-RR') kept_on_month,tot_samp_qty_kfft initial_sample_qty,rem_sample_qty,remarks       
                                from mis_fac.ssm_sample_data
                                )where ? = case when ? = 'ALL' then all_data else pname end
                                and ? = case when ? = 'ALL' then all_data else batch_number end
                                and ? = case when ? = 'ALL' then all_data else chamber_id end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                                and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                    [$parameters['pname'], $parameters['pname'], $parameters['batch_number'], $parameters['batch_number'], $parameters['chamber_id'], $parameters['chamber_id'],
                        $parameters['chamber_stor_loc'], $parameters['chamber_stor_loc'], $parameters['chamber_stor_cond'],$parameters['chamber_stor_cond'],
                        $parameters['kept_on_date'], $parameters['kept_on_date']]);
            }else{
                $products = $parameters['pname'];
                $data_pr = DB::select("select pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,initial_sample_qty,rem_sample_qty,remarks
                                from(
                                select 'ALL' all_data,pname,batch_number,chamber_id,chamber_stor_loc,chamber_stor_cond,kept_on_date,
                                       to_char(kept_on_date,'MON-RR') kept_on_month,tot_samp_qty_kfft initial_sample_qty,rem_sample_qty,remarks       
                                from mis_fac.ssm_sample_data
                                )where pname in ('$products')
                                and ? = case when ? = 'ALL' then all_data else batch_number end
                                and ? = case when ? = 'ALL' then all_data else chamber_id end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_loc end
                                and ? = case when ? = 'ALL' then all_data else chamber_stor_cond end
                                and ? = case when ? = 'ALL' then all_data else kept_on_month end",
                    [$parameters['batch_number'], $parameters['batch_number'], $parameters['chamber_id'], $parameters['chamber_id'],
                        $parameters['chamber_stor_loc'], $parameters['chamber_stor_loc'], $parameters['chamber_stor_cond'],$parameters['chamber_stor_cond'],
                        $parameters['kept_on_date'], $parameters['kept_on_date']]);
            }


            $pdf = \SPDF::loadView('ssm_views.reports.sample.chamberwiseproductlistexcellayout', ['pdata1' => $data_pr]);

            return $pdf->setPaper('a4','landscape')->download('Chamber Wise Product List.pdf');
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }

    public function searchProduct(Request $request){
       try{
           if(strlen($request->search) > 1){
               $result = DB::select("           
                                 select rownum id, pname text 
                                 from (
                                 select 'ALL' pname from dual
                                 union all
                                 select distinct pname 
                                 from mis_fac.ssm_sample_data 
                                 where upper(pname) like ('%$request->search%')
                                 order by 1 asc)");

               //Log::info($result);
               return response()->json(['results' => $result],200);
           }else{
               return response()->json(['results' => []],200);
           }
       }catch (\Exception $ex){
           Log::info($ex->getMessage());
           return response()->json($ex->getMessage());
       }

    }
}
