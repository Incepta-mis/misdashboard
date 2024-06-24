<?php

namespace App\Http\Controllers\SSM;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use http\Env\Response;
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

        $result = DB::select("select DISTINCT PNAME pname,
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
                                          REMARKS remarks,
                                          to_char(REPORT_DATE,'DD-MON-RR') report_date,
                                          CREATE_USER create_user,
                                          ANALYST_NAME analyst_name

                                          
                                    from mis_fac.ssm_interim_stability
                                    where PNAME = ?
                                    and BATCH_NUMBER = ? and RDA_REF_NO = ? and STOR_COND = ? and ASSAY = ?", [$param[0], $param[1], $param[2], $param[3], $param[4]]);
        return response()->json($result);

    }

    /**
     * Search product for prosuct in interim table
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchproduct(Request $request){
        try{
            if(strlen($request->search) > 2){
                $result = DB::select("           
                                 select rownum id, sample text 
                                 from (
                                 SELECT distinct pname||'|'||batch_number||'|'||rda_ref_no||'|'||stor_cond||'|'||assay sample
                                 from mis_fac.ssm_interim_stability
                                 where upper(pname) like ('%$request->search%')
                                 order by 1 asc)");

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
     * Gey Sample Product Name
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductName(Request $request){
        try{
            if(strlen($request->search) > 2){
                $result = DB::select("           
                                 select DISTINCT rownum id, sample text 
                                 from (
                                 SELECT pname sample
                                 from mis_fac.ssm_sample_data
                                 where upper(pname) like ('%$request->search%')
                                 order by 1 asc)");

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
        $old_data =  DB::Select("select pname,batch_number,rda_ref_no from mis_fac.ssm_interim_stability
                                        where pname=?
                                        and batch_number =?
                                    and rda_ref_no=? and stor_cond=? and assay=?",[$request->pname,$request->fdata['batch_number'],
                                    $request->fdata['rda_ref_no'],$request->fdata['stor_cond'],$request->fdata['assay']]);

        if($old_data){
            return response()->json(['status'=>'EXISTS']);
        }else{
            DB::setDateFormat('DD-MON-RR');
            $insert1 = $request->fdata;
            $insert1['CREATE_USER']= Auth::user()->user_id;
            $insert1['pname']= $request->pname;
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

    }


    /**
     * Update Products
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  UpdateRecord1 (Request $request)
    {


        $if_exists =  DB::Select("select pname,batch_number,rda_ref_no from mis_fac.ssm_interim_stability
                                        where pname=?
                                        and batch_number =?
                                    and rda_ref_no=? and stor_cond=? and assay=?",[$request->pname,$request->fdata['batch_number'],$request->fdata['rda_ref_no']
            ,$request->fdata['stor_cond'] ,$request->fdata['assay']]);


        $update = $request->fdata;
        $update['UPDATE_USER']= Auth::user()->user_id;
        $update['pname']= $request->pname;
        $update['UPDATE_DATE']= Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $status = null;
        if($if_exists){
            return response()->json(['status' => 'EXISTS']);
        }else{
            $delete_status = DB::delete("delete from mis_fac.ssm_interim_stability
                                        where pname=?
                                        and batch_number =?
                                    and rda_ref_no=? and stor_cond=? and assay=?",[$request->old_pname,$request->old_batch_number,
                $request->old_rda_ref_no,$request->old_stor_cond,$request->old_assay]);

        }
        if($delete_status){
            $status = DB::table('mis_fac.ssm_interim_stability')->insert($update);
        }else{
            return response()->json(['status' => 'ERROR 500']);
        }

        if($status){
            return response()->json(['status' => 'SUCCESSFULLY']);
        }else{
            return response()->json(['status' => 'ERROR 500']);
        }

    }

}
