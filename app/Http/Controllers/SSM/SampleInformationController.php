<?php

namespace App\Http\Controllers\SSM;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SampleInformationController extends Controller
{
    public function Index()
    {
        $dosage = DB::select('select DF_NO,DF_NAME
from mis_fac.SSM_SAMPLE_DOSAGE_FORM');
        $export = DB::select('select EC_NO,EC_NAME
from mis_fac.SSM_SAMPLE_EXPORT_COUNTRY');
        $modp = DB::select('select MOP_NO,MOP_NAME
from mis_fac.SSM_SAMPLE_MOP');
        $psize = DB:: select('select  PS_NO,PS_NAME
from mis_fac.SSM_SAMPLE_PACK_SIZE');
        $ssreason = DB::select('select TTR_NO,TTR_NAME
from mis_fac.SSM_SAMPLE_STAB_STUDY_REASON');
        $stypes = DB:: select('select TT_NO,TT_NAME
from mis_fac.SSM_SAMPLE_STABILITY_TYPE');
        $scond = DB:: select('select SC_NO,SC_NAME
from mis_fac.SSM_SAMPLE_STORAGE_CONDITION');
        $stpunit = DB:: select('select  TPU_NO,TPU_NAME
from mis_fac.SSM_SAMPLE_TIME_POINT_UNIT');
        $sunit = DB:: select('select  SU_NO,SU_NAME
from mis_fac.SSM_SAMPLE_UNIT');
//         $productinfo = DB:: select('select PNAME,BATCH_NUMBER,chamber_stor_loc
// from mis_fac.ssm_sample_data');
         $chamber_id = DB::select('select distinct ci_name 
from mis_fac.ssm_sample_chamber_id 
order by 1 asc');
        return view('ssm_views.sample_info', compact('dosage', 'export', 'modp', 'psize', 'ssreason', 'stypes',
            'scond', 'stpunit', 'sunit', 'chamber_id'));

    }

    public function SaveRecord(Request $request)
    {
        //Log::info($request->fdata);

        $insert = [
            'PNAME' => trim($request->fdata['prdctname']),
            'MODE_OF_PACK' => trim($request->fdata['m_pack']),
            'P_SIZE' => $request->fdata['psize'],
            'UNIT' => $request->fdata['punit'],
            'ANA_TIME_PRO' => $request->fdata['anatp'],
            'ANA_TIME_NSB' => $request->fdata['anasb'],
            'TEST_DUR' => $request->fdata['testdu'],
            'TEST_DUR_UNIT' => $request->fdata['testduunit'],
            'EXPORT_COUNTRY' => $request->fdata['excountry'],
            'BATCH_NUMBER' => trim($request->fdata['btchnumber']),
            'KEPT_ON_DATE' => Carbon::parse( $request->fdata['keepdate'])->format('Y-m-d'),
            'DOSAGE_FORM' => $request->fdata['dosageform'],
            'CHAMBER_ID' => trim($request->fdata['chid']),
            'CHAMBER_STOR_LOC' => $request->fdata['chlocation'],
            'CHAMBER_STOR_COND' => $request->fdata['storagecond'],
            'TIME_POINT' => $request->fdata['timepoint'],
            'TIME_POINT_UNIT' => $request->fdata['timepointunit'],
            'STAB_TYPE' => $request->fdata['stabtype'],
            'STAB_STUDY_REASON' => $request->fdata['stabstudyreason'],
            'SAMPLE_QC_TEST' => $request->fdata['sampleqctest'],
            'SAMPLE_MB_TEST' => $request->fdata['samplembtest'],
            'REQ_QTY_PFT' => $request->fdata['reqqpftest'],
            'NOT_POINT' => $request->fdata['notestpoint'],
            'EXCESS_SAMPLE_QTY' => $request->fdata['excesssampleqty'],
            'TOT_SAMP_QTY_KFFT' => $request->fdata['tsqfulltest'],
            'SAMPLE_ORIENT' => $request->fdata['sampleorient'],
            'PULL1_SAMPLE_QTY' => $request->fdata['firstqty'],
            'PULL1_SAMPLE_DATE' => $request->fdata['firstdate'] ? Carbon::parse( $request->fdata['firstdate'])->format('Y-m-d') : null,
            'PULL2_SAMPLE_QTY' => $request->fdata['secondqty'],
            'PULL2_SAMPLE_DATE' => $request->fdata['seconddate'] ? Carbon::parse ($request->fdata['seconddate'])->format('Y-m-d') : null,
            'PULL3_SAMPLE_QTY' => $request->fdata['thirdqty'],
            'PULL3_SAMPLE_DATE' => $request->fdata['thirddate']? Carbon::parse ($request->fdata['thirddate'])->format('Y-m-d') : null,
            'PULL4_SAMPLE_QTY' => $request->fdata['fourthqty'],
            'PULL4_SAMPLE_DATE' => $request->fdata['fourthdate']? Carbon::parse ($request->fdata['fourthdate'])->format('Y-m-d') : null,
            'PULL5_SAMPLE_QTY' => $request->fdata['fifthqty'],
            'PULL5_SAMPLE_DATE' => $request->fdata['fifthdate']? Carbon::parse ($request->fdata['fifthdate'])->format('Y-m-d') : null,
            'PULL6_SAMPLE_QTY' => $request->fdata['sixthqty'],
            'PULL6_SAMPLE_DATE' => $request->fdata['sixthdate'] ? Carbon::parse ($request->fdata['sixthdate'])->format('Y-m-d') : null,
            'PULL7_SAMPLE_QTY' => $request->fdata['seventhqty'],
            'PULL7_SAMPLE_DATE' => $request->fdata['seventhdate']? Carbon::parse ($request->fdata['seventhdate'])->format('Y-m-d') :null,
            'PULL8_SAMPLE_QTY' => $request->fdata['eighthqty'],
            'PULL8_SAMPLE_DATE' => $request->fdata['eighthdate']? Carbon::parse ($request->fdata['eighthdate'])->format('Y-m-d') :null,
            'PULL9_SAMPLE_QTY' => $request->fdata['ninthqty'],
            'PULL9_SAMPLE_DATE' => $request->fdata['ninthdate']?Carbon::parse ($request->fdata['ninthdate'])->format('Y-m-d') :null,
            'PULL10_SAMPLE_QTY' => $request->fdata['tenthqty'],
            'PULL10_SAMPLE_DATE' => $request->fdata['tengthdate']? Carbon::parse ($request->fdata['tengthdate'])->format('Y-m-d') :null,
            'PULL11_SAMPLE_QTY' => $request->fdata['eleventhqty'],
            'PULL11_SAMPLE_DATE' => $request->fdata['eleventhdate']? Carbon::parse ( $request->fdata['eleventhdate'])->format('Y-m-d') :null,
            'PULL12_SAMPLE_QTY' => $request->fdata['twelvethqty'],
            'PULL12_SAMPLE_DATE' => $request->fdata['twelvethdate']? Carbon::parse ($request->fdata['twelvethdate'])->format('Y-m-d') :null,
            'PULL13_SAMPLE_QTY' => $request->fdata['thirteenthqty'],
            'PULL13_SAMPLE_DATE' => $request->fdata['thirteenthdate']?Carbon::parse ($request->fdata['thirteenthdate'])->format('Y-m-d') :null,
            'PULL14_SAMPLE_QTY' => $request->fdata['fourteenthqty'],
            'PULL14_SAMPLE_DATE' => $request->fdata['fourteenthdate']? Carbon::parse ($request->fdata['fourteenthdate'])->format('Y-m-d') :null,
            'REM_SAMPLE_QTY' => $request->fdata['rsquantity'],
            'REMARKS' => $request->fdata['premarks'],
            'CREATE_USER' => Auth::user()->user_id,
            'CREATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y-m-d')

        ];
        $status = DB::table('mis_fac.SSM_SAMPLE_DATA')->insert($insert);
        if ($status) {
            $productinfo = DB:: select('select PNAME,BATCH_NUMBER,chamber_stor_loc
from mis_fac.ssm_sample_data');
            return response()->json(['status' => 'SUCCESSFULLY', 'xyz' => $productinfo]);

        } else {
            return response()->json(['status' => 'ERROR 500']);
        }
    }

    public function RetrieveRecord(Request $request)
    {
        DB::setDateFormat('DD-MON-RR');
        $param = explode('|', $request->fdata);
        //Log::info($param);

        $result = DB::select('select  PNAME prdctname,
                                          MODE_OF_PACK m_pack,
                                          P_SIZE psize,
                                          UNIT  punit    ,
                                          ANA_TIME_PRO  anatp,
                                          ANA_TIME_NSB  anasb,
                                          TEST_DUR      testdu,
                                          TEST_DUR_UNIT testduunit,
                                          EXPORT_COUNTRY excountry,
                                          BATCH_NUMBER  btchnumber,
                                          KEPT_ON_DATE keepdate,
                                          DOSAGE_FORM  dosageform,
                                          CHAMBER_ID chid,
                                          CHAMBER_STOR_LOC  chlocation,
                                          CHAMBER_STOR_COND storagecond,
                                          TIME_POINT timepoint,
                                          TIME_POINT_UNIT timepointunit,
                                          STAB_TYPE   stabtype ,
                                          STAB_STUDY_REASON stabstudyreason,
                                          SAMPLE_QC_TEST sampleqctest,
                                          SAMPLE_MB_TEST samplembtest,
                                          REQ_QTY_PFT   reqqpftest,
                                          NOT_POINT     notestpoint,
                                          EXCESS_SAMPLE_QTY excesssampleqty,
                                          TOT_SAMP_QTY_KFFT tsqfulltest,
                                          SAMPLE_ORIENT sampleorient,
                                          PULL1_SAMPLE_QTY firstqty ,
                                          PULL1_SAMPLE_DATE firstdate,
                                          PULL2_SAMPLE_QTY secondqty,
                                          PULL2_SAMPLE_DATE seconddate,
                                          PULL3_SAMPLE_QTY thirdqty,
                                          PULL3_SAMPLE_DATE thirddate,
                                          PULL4_SAMPLE_QTY fourthqty,
                                          PULL4_SAMPLE_DATE fourthdate,
                                          PULL5_SAMPLE_QTY fifthqty ,
                                          PULL5_SAMPLE_DATE fifthdate,
                                          PULL6_SAMPLE_QTY sixthqty,
                                          PULL6_SAMPLE_DATE sixthdate,
                                          PULL7_SAMPLE_QTY seventhqty,
                                          PULL7_SAMPLE_DATE seventhdate,
                                          PULL8_SAMPLE_QTY eighthqty,
                                          PULL8_SAMPLE_DATE eighthdate,
                                          PULL9_SAMPLE_QTY ninthqty,
                                          PULL9_SAMPLE_DATE ninthdate,
                                          PULL10_SAMPLE_QTY tenthqty,
                                          PULL10_SAMPLE_DATE tengthdate,
                                          PULL11_SAMPLE_QTY eleventhqty,
                                          PULL11_SAMPLE_DATE eleventhdate,
                                          PULL12_SAMPLE_QTY twelvethqty,
                                          PULL12_SAMPLE_DATE twelvethdate,
                                         PULL13_SAMPLE_QTY thirteenthqty,
                                          PULL13_SAMPLE_DATE thirteenthdate,
                                          PULL14_SAMPLE_QTY fourteenthqty,
                                          PULL14_SAMPLE_DATE fourteenthdate,
                                          REM_SAMPLE_QTY rsquantity,
                                          REMARKS premarks
                                    from mis_fac.SSM_SAMPLE_DATA
                                    where PNAME = ?
                                    and BATCH_NUMBER = ?
                                    and chamber_stor_loc = ?', [$param[0], $param[1], $param[2]]);
        return response()->json($result);
        //Log::info($result);

    }

    public function UpdateRecord(Request $request)
    {

        $param = explode('|', $request->param);

        //Log::info($request->all());

        $update = [
            'PNAME' =>$request->fdata['prdctname'],
            'BATCH_NUMBER' =>$request->fdata['btchnumber'],
            'CHAMBER_ID' =>$request->fdata['chid'],
            'MODE_OF_PACK' => $request->fdata['m_pack'],
            'P_SIZE' => $request->fdata['psize'],
            'UNIT' => $request->fdata['punit'],
            'ANA_TIME_PRO' => $request->fdata['anatp'],
            'ANA_TIME_NSB' => $request->fdata['anasb'],
            'TEST_DUR' => $request->fdata['testdu'],
            'TEST_DUR_UNIT' => $request->fdata['testduunit'],
            'EXPORT_COUNTRY' => $request->fdata['excountry'],
            'KEPT_ON_DATE' => $request->fdata['keepdate'] ? Carbon::parse( $request->fdata['keepdate'])->format('Y-m-d'): null,
            'DOSAGE_FORM' => $request->fdata['dosageform'],
            'CHAMBER_STOR_LOC' => $request->fdata['chlocation'],
            'CHAMBER_STOR_COND' => $request->fdata['storagecond'],
            'TIME_POINT' => $request->fdata['timepoint'],
            'TIME_POINT_UNIT' => $request->fdata['timepointunit'],
            'STAB_TYPE' => $request->fdata['stabtype'],
            'STAB_STUDY_REASON' => $request->fdata['stabstudyreason'],
            'SAMPLE_QC_TEST' => $request->fdata['sampleqctest'],
            'SAMPLE_MB_TEST' => $request->fdata['samplembtest'],
            'REQ_QTY_PFT' => $request->fdata['reqqpftest'],
            'NOT_POINT' => $request->fdata['notestpoint'],
            'EXCESS_SAMPLE_QTY' => $request->fdata['excesssampleqty'],
            'TOT_SAMP_QTY_KFFT' => $request->fdata['tsqfulltest'],
            'SAMPLE_ORIENT' => $request->fdata['sampleorient'],
            'PULL1_SAMPLE_QTY' => $request->fdata['firstqty'],
            'PULL1_SAMPLE_DATE' => $request->fdata['firstdate'] ? Carbon::parse( $request->fdata['firstdate'])->format('Y-m-d') : null,
            'PULL2_SAMPLE_QTY' => $request->fdata['secondqty'],
            'PULL2_SAMPLE_DATE' => $request->fdata['seconddate'] ? Carbon::parse ($request->fdata['seconddate'])->format('Y-m-d') : null,
            'PULL3_SAMPLE_QTY' => $request->fdata['thirdqty'],
            'PULL3_SAMPLE_DATE' => $request->fdata['thirddate'] ? Carbon::parse ($request->fdata['thirddate'])->format('Y-m-d') : null,
            'PULL4_SAMPLE_QTY' => $request->fdata['fourthqty'],
            'PULL4_SAMPLE_DATE' => $request->fdata['fourthdate'] ? Carbon::parse ($request->fdata['fourthdate'])->format('Y-m-d') : null,
            'PULL5_SAMPLE_QTY' => $request->fdata['fifthqty'],
            'PULL5_SAMPLE_DATE' => $request->fdata['fifthdate'] ? Carbon::parse ($request->fdata['fifthdate'])->format('Y-m-d') : null,
            'PULL6_SAMPLE_QTY' => $request->fdata['sixthqty'],
            'PULL6_SAMPLE_DATE' => $request->fdata['sixthdate'] ? Carbon::parse ($request->fdata['sixthdate'])->format('Y-m-d') : null,
            'PULL7_SAMPLE_QTY' => $request->fdata['seventhqty'],
            'PULL7_SAMPLE_DATE' => $request->fdata['seventhdate'] ? Carbon::parse ($request->fdata['seventhdate'])->format('Y-m-d') :null,
            'PULL8_SAMPLE_QTY' => $request->fdata['eighthqty'],
            'PULL8_SAMPLE_DATE' => $request->fdata['eighthdate'] ? Carbon::parse ($request->fdata['eighthdate'])->format('Y-m-d') :null,
            'PULL9_SAMPLE_QTY' => $request->fdata['ninthqty'],
            'PULL9_SAMPLE_DATE' => $request->fdata['ninthdate']?Carbon::parse ($request->fdata['ninthdate'])->format('Y-m-d') :null,
            'PULL10_SAMPLE_QTY' => $request->fdata['tenthqty'],
            'PULL10_SAMPLE_DATE' =>$request->fdata['tengthdate'] ? Carbon::parse ($request->fdata['tengthdate'])->format('Y-m-d') :null,
            'PULL11_SAMPLE_QTY' => $request->fdata['eleventhqty'],
            'PULL11_SAMPLE_DATE' =>$request->fdata['eleventhdate'] ? Carbon::parse ( $request->fdata['eleventhdate'])->format('Y-m-d') :null,
            'PULL12_SAMPLE_QTY' => $request->fdata['twelvethqty'],
            'PULL12_SAMPLE_DATE' =>$request->fdata['twelvethdate'] ? Carbon::parse ($request->fdata['twelvethdate'])->format('Y-m-d') :null,
            'PULL13_SAMPLE_QTY' => $request->fdata['thirteenthqty'],
            'PULL13_SAMPLE_DATE' =>$request->fdata['thirteenthdate'] ?Carbon::parse ($request->fdata['thirteenthdate'])->format('Y-m-d') :null,
            'PULL14_SAMPLE_QTY' => $request->fdata['fourteenthqty'],
            'PULL14_SAMPLE_DATE' =>$request->fdata['fourteenthdate'] ? Carbon::parse ($request->fdata['fourteenthdate'])->format('Y-m-d') :null,
            'REM_SAMPLE_QTY' => $request->fdata['rsquantity'],
            'REMARKS' => $request->fdata['premarks'],
            'UPDATE_USER' => Auth::user()->user_id,
            'UPDATE_DATE' => Carbon::now('Asia/Dhaka')->format('Y-m-d')

        ];
        Log::info($request->all());
        $delete_status = DB::delete("delete from mis_fac.SSM_SAMPLE_DATA 
                                        where pname=?
                                        and batch_number =?
                                      and chamber_id=?",[$request->pname,$request->batch,$request->ch_id]);
//        $delete_status = DB::table('mis_fac.SSM_SAMPLE_DATA')->where(['pname'=>$request->pname,'batch_number'=>$request->batch,'chamber_id'=>$request->chid])->delete();
//        $status = DB::table('mis_fac.SSM_SAMPLE_DATA')->where(['pname'=> $param[0],'batch_number'=>$param[1],'chamber_stor_loc'=>$param[2]])->update($update);

        Log::info($delete_status);
        $status = null;
        if ($delete_status){
            $status = DB::table('mis_fac.SSM_SAMPLE_DATA')->insert($update);
        }
        if ($status) {
            return response()->json(['status' => 'SUCCESSFULLY']);

        } else {
            return response()->json(['status' => 'ERROR 500']);
        }
    }

    public function searchProduct(Request $request){
        try{
            if(strlen($request->search) > 2){
                $result = DB::select("           
                                 select rownum id, sample text 
                                 from (
                                 SELECT pname||'|'||batch_number||'|'||chamber_stor_loc sample
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
