<?php

namespace App\Http\Controllers\SSM;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyMachineRunController extends Controller
{
    public function index()
    {
        $mname = DB:: select('select MN_NAME
                        from mis_fac.SSM_RESULT_MACHINE_NAME');

        $mid = DB:: select('select  MI_NAME
                         from mis_fac.SSM_RESULT_MACHINE_ID');

        $m_a_to = DB:: select("select sur_name emp_name
                        from hrms.emp_information @web_to_hrms
                        where plant_id in (1100,1200)
                        and dept_id in ('D11100011','D11100024','D11100001','D11100014')
                        and valid = 'YES' 
                        and nvl(EMP_TYPE,'FACTORY') = 'EXECUTIVE'
                        order by 1 asc");

        $productinfo = DB:: select('SELECT 
                        PNAME, BATCH_NUMBER, M_NAME, 
                           M_ID, M_A_TO, M_START_DATE_TIME, 
                           M_STOP_DATE_TIME, M_R_TIME_TOTAL, M_IDLE_TIME, 
                           JOMI_TIME, MB_HOUR
                        from mis_fac.ssm_daily_machine_run_status');

        $sampleinfo = DB:: select('select pname,batch_number,chamber_id
                        from mis_fac.ssm_sample_data
                        order by pname,batch_number,chamber_id
                        ');
        
        return view('ssm_views.dailymachinerun',compact('m_a_to','mname','mid','productinfo','sampleinfo'));
    }
    public function saverecord2(Request $request)
    {
        $insert1 = $request->fdata;

        Log::info($insert1);
        $insert1['pname']= explode('|',$insert1['pname'])[0];
        $insert1['CREATE_USER']= Auth::user()->user_id;
        $insert1['CREATE_DATE']= Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $insert1['m_stop_date_time']= Carbon::parse($insert1['m_stop_date_time'])->format('Y-m-d H:i:s');
        $insert1['m_start_date_time']= Carbon::parse($insert1['m_start_date_time'])->format('Y-m-d H:i:s');
        Log::info($insert1);

        $status = DB::table('mis_fac.SSM_DAILY_MACHINE_RUN_STATUS')->insert($insert1);
        if($status)
        {
            $productinfo = DB:: select('SELECT 
PNAME, BATCH_NUMBER, M_NAME, 
   M_ID, M_A_TO, M_START_DATE_TIME, 
   M_STOP_DATE_TIME, M_R_TIME_TOTAL, M_IDLE_TIME, 
   JOMI_TIME, MB_HOUR
from mis_fac.ssm_daily_machine_run_status');
            return response()->json(['status' => 'SAVED', 'xyz' => $productinfo]);

        }
        else{
            return response()->json(['status'=>'ERROR 500']);
        }
    }
    public function displayrun(Request $request)
    {
        $param = explode('|', $request->fdata);
        Log::info($param);

        $result = DB::select("SELECT 
PNAME, BATCH_NUMBER, M_NAME, 
   M_ID, M_A_TO, M_START_DATE_TIME, 
   M_STOP_DATE_TIME, M_R_TIME_TOTAL, M_IDLE_TIME, 
   JOMI_TIME, MB_HOUR
from mis_fac.ssm_daily_machine_run_status
where pname = ?
and batch_number = ?
and m_id = ?
and m_start_date_time = ?", [$param[0], $param[1], $param[2], $param[3]]);
        return response()->json($result);
        Log::info($result);

    }
    public function  updaterun (Request $request)
    {

        $param = explode('|', $request->param);

        $update = $request->fdata;
        $update['UPDATE_USER']= Auth::user()->user_id;
        $update['UPDATE_DATE']= Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $update['m_stop_date_time']= Carbon::parse($update['m_stop_date_time'])->format('Y-m-d H:i:s');
        $update['m_start_date_time']= Carbon::parse($update['m_start_date_time'])->format('Y-m-d H:i:s');
        Log::info($update);
        $status = DB::table('mis_fac.SSM_DAILY_MACHINE_RUN_STATUS')->where(['PNAME'=> $param[0],'BATCH_NUMBER'=>$param[1],'M_ID'=>$param[2],'M_START_DATE_TIME'=>$param[3]])->update($update);
        if($status)
        {
            return response()->json(['status'=>'SUCCESSFULLY']);

        }
        else{
            return response()->json(['status'=>'ERROR 500']);
        }
    }
    public function RetrieveSampleRecord(Request $request)
    {
        $param = explode('|', $request->param);
        $responseall = DB::select('select * from mis_fac.ssm_sample_data
        where pname=?
        and nvl2(?,batch_number,0)= nvl2(?,batch_number,0)
        and nvl2(?,chamber_id,0) = nvl2(?,chamber_id,0)
        
        ',[$param[0],$param[1],$param[1],$param[2],$param[2]]);
        return response()->json($responseall);
    }
}
