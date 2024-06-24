<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class MonthlyWorkingDayController extends Controller
{
    protected function index()
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $mfd = DB::select("select to_date(trunc(sysdate,'MM'),'DD-MON-RR') AS MFD from dual");
//        dd($mfd);
        return view("data_process.monthly_working_day")->with('fdm', $mfd);
    }

    protected function create_working_day(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $procedure = 'mis.pro_working_day';
        $bindings = [
            'sreport_month' => $request->fdm
        ];

        try {
            $result = DB::executeProcedure($procedure, $bindings);
            $status = 'done';
        } catch (Oci8Exception $e) {
            $status = $e->getMessage();
        }
        return response()->json($status);
    }

    protected function display_working_day(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        try {
            $twd = DB::select("select WORKING_DATE wd,DAY,WORKING_DAY_STATUS wds,
                                  WORKING_DAY wday,TOTAL_WORKING_DAY twd
                            from MIS.MONTHLY_WORKING_DAY 
                            where to_char(to_date(WORKING_DATE,'DD-MON-RR'),'MON-RR') = to_char(to_date(?,'DD-MON-RR'),'MON-RR')",
                [$request->fdm]);

        } catch (Oci8Exception $e) {
            $twd = $e->getMessage();
        }

        return response()->json($twd);
    }
    protected function update_working_day(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        Log::info($request->fdm);
//        return response()->json($request);
        try{
           foreach ($request->update as $qd){
               Log::info($qd['wd']);
               $uwds= DB::update("update MIS.MONTHLY_WORKING_DAY
               set WORKING_DAY_STATUS =?
          where to_date(WORKING_DATE,'DD-MON-RR') = to_date(?,'DD-MON-RR')",[$qd['wds'],$qd['wd']]);
           }
            $result = DB::executeProcedure('mis.pro_working_day_update',['sreport_month'=>$request->fdm]);


        }
        catch(Oci8Exception $e){
            $uwds=$e->getMessage();
        }
        return response()->json($uwds.'|'.$result);
    }
}
