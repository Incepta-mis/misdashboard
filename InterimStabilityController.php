<?php

namespace App\Http\Controllers\SSM;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InterimStabilityController extends Controller
{
    /**
     * Get sample data and return
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|mixed
     */
    public function Index()
    {
        $pname = DB:: select("select distinct pname from mis_fac.ssm_sample_data
        order by 1 asc");
        $batch_number = DB:: select("select distinct batch_number from mis_fac.ssm_sample_data
        order by 1 asc");

        return view('ssm_views.interim_info',compact('pname','batch_number'));
    }

    /**
     * Retrive record of select two
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function retriveInfo(Request $request) 
    {

        $param = explode('|', $request->fdata);
        $result = DB::select('select  PNAME pname,
                                          BATCH_NUMBER batch_number,
                                          RDA_REF_NO rda_ref_no,
                                          STOR_COND stor_cond,
                                          ASSAY assay,
                                          ASSAY_METHOD assay_method,
                                          DISSO disso,
                                          DISSO_METHOD disso_method,
                                          PH ph,
                                          DT dt,
                                          DESCRIPTION description,
                                          IMPURITIES impurities,
                                          IMPURITY_METHOD impurity_method,
                                          OPTION1 option1,
                                          OPTION2 option2,
                                          REMARKS remarks
                                          
                                    from mis_fac.ssm_interim_stability
                                    where PNAME = ?
                                    and BATCH_NUMBER = ?', [$param[0], $param[1]]);
        return response()->json($result);

    }

    /**
     * Search product for select two
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchproduct(Request $request){
        try{
            if(strlen($request->search) > 2){
                $result = DB::select("           
                                 select rownum id, sample text 
                                 from (
                                 SELECT pname||'|'||batch_number sample
                                 from mis_fac.ssm_interim_stability
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

    /**
     * Save products
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saverecord2(Request $request)
    {

        $insert1 = $request->fdata;
        $insert1['pname']= explode('|',$insert1['pname'])[0];
        $insert1['CREATE_USER']= Auth::user()->user_id;
        $insert1['CREATE_DATE']= Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $status = DB::table('mis_fac.SSM_INTERIM_STABILITY')->insert($insert1);
        if($status)
        {
            $interim = DB:: select('select PNAME,BATCH_NUMBER
                from mis_fac.ssm_interim_stability');
            return response()->json(['status' => 'SAVED', 'xyz' => $interim]);

        }
        else{
            return response()->json(['status'=>'ERROR 500']);
        }
    }


    /**
     * Update Products
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  UpdateRecord1 (Request $request)
    {

       // $param = explode('|', $request->param);

        $update = $request->fdata;
        $update['UPDATE_USER']= Auth::user()->user_id;
        $update['UPDATE_DATE']= Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $status = DB::table('mis_fac.ssm_interim_stability')->where(['PNAME'=> $request->name,'BATCH_NUMBER'=>$request->batch_number])->update($update);
        if($status)
        {
            return response()->json(['status'=>'SUCCESSFULLY']);

        }
        else{
            return response()->json(['status'=>'ERROR 500']);
        }
    }


}
