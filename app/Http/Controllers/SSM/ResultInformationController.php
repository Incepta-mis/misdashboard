<?php

namespace App\Http\Controllers\SSM;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultInformationController extends Controller
{
    public function Index()
    {
        $assay = DB:: select('select AM_NAME
from mis_fac.SSM_RESULT_ASSAY_METHOD');
        $diss = DB:: select('select DM_NAME
from mis_fac.SSM_RESULT_DISSOLUTION_METHOD');
        $imp = DB:: select('select IM_NAME
from mis_fac.SSM_RESULT_IMPURITY_METHOD');
//      $mid = DB:: select('select  MI_NAME
//from mis_fac.SSM_RESULT_MACHINE_ID');
//      $mname = DB:: select('select MN_NAME
//from mis_fac.SSM_RESULT_MACHINE_NAME');
        $psample = DB:: select('select PSI_NAME
from mis_fac.SSM_RESULT_PRO_SAMPLE_INFO');
        $resulttm = DB:: select('select TM_NAME
from mis_fac.SSM_RESULT_TEST_METHOD');
        $resulttp = DB:: select('select TP_NAME
from mis_fac.SSM_RESULT_TEST_PARAMETER');
        $productinfo = DB:: select('select PNAME,BATCH_NUMBER,CHAMBER_STOR_LOC,GENERIC_NAME,CHAMBER_STOR_COND,TEST_PARAMETERS,ACCEPT_CRITERIA,CHAMBER_ID
from mis_fac.ssm_result_data order by time_point asc');
        $sampleinfo = DB:: select('select PNAME,BATCH_NUMBER,CHAMBER_ID
from mis_fac.ssm_sample_data');
//      $m_a_to = DB:: select("select sur_name emp_name
//from hrms.emp_information @web_to_hrms
//where plant_id in (1100,1200)
//and dept_id in ('D11100011','D11100024','D11100001','D11100014')
//and valid = 'YES'
//and nvl(EMP_TYPE,'FACTORY') = 'EXECUTIVE'
//order by 1 asc");
        return view('ssm_views.result_info',compact('assay','diss','imp','psample',
            'resulttm','resulttp','productinfo','sampleinfo'));
    }
    public function SaveRecord1(Request $request)
    {

        $insert1 = $request->fdata;
        



        //Log::info($insert1);
        $insert1['pname']= explode('|',$insert1['pname'])[0];
        $insert1['accept_criteria']= strtoupper($insert1['accept_criteria']);
        $insert1['CREATE_USER']= Auth::user()->user_id;
        $insert1['CREATE_DATE']= Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
//            $insert1['m_stop_date_time']= Carbon::parse($insert1['m_stop_date_time'])->format('Y-m-d H:i:s');
//            $insert1['m_start_date_time']= Carbon::parse($insert1['m_start_date_time'])->format('Y-m-d H:i:s');
        //Log::info($insert1);

        $status = DB::table('mis_fac.SSM_RESULT_DATA')->insert($insert1);
        if($status)
        {
            $productinfo = DB:: select('select PNAME,BATCH_NUMBER,CHAMBER_STOR_LOC,TIME_POINT,CHAMBER_STOR_COND,TEST_PARAMETERS,ACCEPT_CRITERIA
from mis_fac.ssm_result_data');
            return response()->json(['status' => 'SAVED', 'xyz' => $productinfo]);

        }
        else{
            return response()->json(['status'=>'ERROR 500']);
        }
    }
    public function RetrieveRecord1(Request $request)
    {
        $param = explode('|', $request->fdata);
        //Log::info($param);

        $result = DB::select("select    PNAME                ,
                                                      GENERIC_NAME        ,
                                                      BATCH_NUMBER        ,
                                                      TIME_POINT          ,
                                                      TIME_POINT_TESTED   ,
                                                      TIME_POINT_UNIT     ,
                                                      CHAMBER_ID          ,
                                                      CHAMBER_STOR_LOC    ,
                                                      CHAMBER_STOR_COND   ,
                                                      PROD_SAMP_INFO      ,
                                                      MODE_OF_PACK        ,
                                                      TEST_PARAMETERS     ,
                                                      TEST_METHOD         ,
                                                      ACCEPT_CRITERIA     ,
                                                      STAB_TYPE          ,
                                                      STAB_STUDY_REASON   ,
                                                      AVA_INITIAL_RESULT  ,
                                                      AVA_WEEK1_RESULT    ,
                                                      AVA_WEEK2_RESULT    ,
                                                      AVA_WEEK3_RESULT    ,
                                                      AVA_MONTH1_RESULT   ,
                                                      AVA_MONTH2_RESULT   ,
                                                      AVA_MONTH3_RESULT   ,
                                                      AVA_MONTH6_RESULT   ,
                                                      AVA_MONTH9_RESULT   ,
                                                      AVA_MONTH12_RESULT  ,
                                                      AVA_MONTH18_RESULT  ,
                                                      AVA_MONTH24_RESULT  ,
                                                      AVA_MONTH36_RESULT  ,
                                                      AVA_MONTH48_RESULT  ,
                                                      AVA_MONTH60_RESULT  ,
                                                      AVA_OTHERS_RESULT   ,
                                                      MAX_INITIAL_RESULT  ,
                                                      MAX_WEEK1_RESULT    ,
                                                      MAX_WEEK2_RESULT    ,
                                                      MAX_WEEK3_RESULT    ,
                                                      MAX_MONTH1_RESULT   ,
                                                      MAX_MONTH2_RESULT   ,
                                                      MAX_MONTH3_RESULT   ,
                                                      MAX_MONTH6_RESULT   ,
                                                      MAX_MONTH9_RESULT   ,
                                                      MAX_MONTH12_RESULT  ,
                                                      MAX_MONTH18_RESULT  ,
                                                      MAX_MONTH24_RESULT  ,
                                                      MAX_MONTH36_RESULT  ,
                                                      MAX_MONTH48_RESULT  ,
                                                      MAX_MONTH60_RESULT  ,
                                                      MAX_OTHERS_RESULT   ,
                                                      MIN_INITIAL_RESULT  ,
                                                      MIN_WEEK1_RESULT    ,
                                                      MIN_WEEK2_RESULT    ,
                                                      MIN_WEEK3_RESULT    ,
                                                      MIN_MONTH1_RESULT   ,
                                                      MIN_MONTH2_RESULT   ,
                                                      MIN_MONTH3_RESULT   ,
                                                      MIN_MONTH6_RESULT   ,
                                                      MIN_MONTH9_RESULT   ,
                                                      MIN_MONTH12_RESULT  ,
                                                      MIN_MONTH18_RESULT  ,
                                                      MIN_MONTH24_RESULT  ,
                                                      MIN_MONTH36_RESULT  ,
                                                      MIN_MONTH48_RESULT  ,
                                                      MIN_MONTH60_RESULT  ,
                                                      MIN_OTHERS_RESULT   ,
                                                      EC_BR_INITIAL       ,
                                                      EC_BR1_WEEK         ,
                                                      EC_BR2_WEEK         ,
                                                      EC_BR3_WEEK         ,
                                                      EC_BR1_MONTH        ,
                                                      EC_BR2_MONTH        ,
                                                      EC_BR3_MONTH        ,
                                                      EC_BR6_MONTH        ,
                                                      EC_BR9_MONTH        ,
                                                      EC_BR12_MONTH       ,
                                                      EC_BR18_MONTH       ,
                                                      EC_BR24_MONTH       ,
                                                      EC_BR36_MONTH       ,
                                                      EC_BR48_MONTH       ,
                                                      EC_BR60_MONTH       ,
                                                      EC_BR_OTHERS        ,
                                                      MID_INITIAL         ,
                                                      MID_WEEK1           ,
                                                      MID_WEEK2           ,
                                                      MID_WEEK3           ,
                                                      MID_MONTH1          ,
                                                      MID_MONTH2          ,
                                                      MID_MONTH3          ,
                                                      MID_MONTH6          ,
                                                      MID_MONTH9          ,
                                                      MID_MONTH12         ,
                                                      MID_MONTH18         ,
                                                      MID_MONTH24         ,
                                                      MID_MONTH36         ,
                                                      MID_MONTH48         ,
                                                      MID_MONTH60         ,
                                                      MID_OTHERS          ,
                                                      MHOURE_INITIAL      ,
                                                      MHOURE_WEEK1        ,
                                                      MHOURE_WEEK2        ,
                                                      MHOURE_WEEK3        ,
                                                      MHOURE_MONTH1       ,
                                                      MHOURE_MONTH2       ,
                                                      MHOURE_MONTH3       ,
                                                      MHOURE_MONTH6       ,
                                                      MHOURE_MONTH9       ,
                                                      MHOURE_MONTH12      ,
                                                      MHOURE_MONTH18      ,
                                                      MHOURE_MONTH24      ,
                                                      MHOURE_MONTH36      ,
                                                      MHOURE_MONTH48      ,
                                                      MHOURE_MONTH60      ,
                                                      MHOURE_OTHERS       ,
                                                      ASSAY_METHOD        ,
                                                      DISSOLUTION_METHOD  ,
                                                      IMPURITY_METHOD     ,
                                                      ANA_TIME_PRO        ,
                                                      ANA_TIME_NSB        ,
                                                      MRUN_TIME_PRODUCT   ,
                                                      MRUN_TIME_BATCH     ,
                                                      TESTING_FREQUENCY   ,
                                                      CALCULATE_MHOURE    ,
                                                      ACTUAL_MHOURE       ,
                                                      SAMPLE_ORIENTATION  ,
                                                      REMARKS   
                                    from mis_fac.ssm_result_data
                                    where PNAME = ?
                                    and BATCH_NUMBER = ?
                                    and CHAMBER_STOR_COND = ?
                                    and TEST_PARAMETERS = ?
                                    and ACCEPT_CRITERIA = ?
                                    and GENERIC_NAME = ?", [$param[0], $param[1], $param[2], $param[3], $param[4],$param[5]]);
        return response()->json($result);
        //Log::info($result);

    }

    public function UpdateRecord1 (Request $request)
    {
        $param = explode('|', $request->param);
        $update = $request->fdata;

        unset($update['pname']);
        unset($update['generic_name']);
        unset($update['batch_number']);
        unset($update['chamber_stor_cond']);
        unset($update['test_parameters']);
        unset($update['accept_criteria']);

        $update['UPDATE_USER'] = Auth::user()->user_id;
        $update['UPDATE_DATE'] = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        try{
            $status = DB::table('mis_fac.SSM_RESULT_DATA')
                ->where(['PNAME'=> $param[0],
                    'GENERIC_NAME'=>$param[5],
                    'BATCH_NUMBER'=>$param[1],
                    'CHAMBER_STOR_COND'=>$param[2],
                    'TEST_PARAMETERS'=>$param[3],
                    'ACCEPT_CRITERIA'=>$param[4]])
                ->update($update);
            if($status){
                return response()->json(['status'=>'SUCCESSFULLY']);
            }
        }catch (\Exception $ex){
            return response()->json(['status' => $ex->getMessage()]);
        }
    }

    public function RetrieveSampleRecord(Request $request)
    {
        $param = explode('|', $request->param);
        $responseall = DB::select('select * from mis_fac.ssm_sample_data
        where pname=?
        and batch_number = case when ? is null then batch_number else ? end
        and chamber_id = case when ? is null then chamber_id else ? end  
        ',[$param[0],$param[1],$param[1],$param[2],$param[2]]);
        return response()->json($responseall);
    }



    public function get_accept(Request $request)
    {


        $param = explode('|', $request->param);



        if ($param) {
            $mat = DB::select("                                
                select distinct accept_criteria
                from mis_fac.ssm_result_data
                where  UPPER(PNAME) LIKE '%" . strtoupper($param[0]) . "%'
                
            ");

            return response()->json($mat);
        }

    }
}
