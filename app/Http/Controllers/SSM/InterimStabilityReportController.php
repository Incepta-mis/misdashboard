<?php

namespace App\Http\Controllers\SSM;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InterimStabilityReportController extends Controller
{
    public function index(){

        $pname = DB:: select("select distinct pname from mis_fac.ssm_interim_stability
        order by 1 asc");
        $batch_number = DB:: select("select distinct batch_number from mis_fac.ssm_interim_stability
        order by 1 asc");


        return view('ssm_views.reports.interim.interimstability',compact('pname','batch_number'));
    }
    public function getvalues(Request $request)
    {
        DB::setDateFormat('MON-RR');
        $pname = DB::select("select DISTINCT  pname val from mis_fac.ssm_sample_data where to_char(kept_on_date,'MON-RR') = ?
        order by 1 asc",[$request->kept_on_date]);
        return response()->json(['pname' => $pname]);
    }
    public function getInterimData(Request $request)
    {


        DB::setDateFormat('DD-MON-RR');
        $result = DB::select("select DISTINCT pname,batch_number,rda_ref_no,stor_cond,assay,assay_method,disso,disso_method,ph,dt,
                            description,impurities,impurity_method,option1,option2,analyst_name, report_date, create_user, create_date   
                            from (select 'ALL' all_data,pname,batch_number,
                            rda_ref_no,stor_cond,assay,assay_method,disso,disso_method,ph,dt,
                            description,impurities,impurity_method,option1,option2,analyst_name,report_date, create_user, create_date
                            from mis_fac.ssm_interim_stability)where ? = case when ? = 'ALL' then all_data else pname end
                                                            and ? = case when ? = 'ALL' then all_data else batch_number end",
            [$request->name,$request->name,$request->batch_number,$request->batch_number]);

        return response()->json($result);

    }



}
