<?php

namespace App\Http\Controllers\SSM;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Input;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Session;
use Redirect;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class DataUploadController extends Controller
{
    public function index()
    {
//        return "hello";
        return view('ssm_views.sample_dataupload');
    }

    public function postSampleData()
    {

        $file = Input::file('export_sales_data_name');

        $rules = array('export_sales_data_name' => 'required'); //'required'
        $msg = array('export_sales_data_name.required' => 'This file is required');
        $validatorempty = Validator::make(array('export_sales_data_name' => $file), $rules, $msg);

        if ($validatorempty->fails()) {

            return Redirect::to('ssm/dataupload')->withErrors($validatorempty);

        } else if ($validatorempty->passes()) {
            /////////////////////////////////////////////////////////////////////////


            $ext = strtolower($file->getClientOriginalExtension());

            $validator = Validator::make(
                array('ext' => $ext),
                array('ext' => 'in:xls,xlsx')
            );


            if ($validator->fails()) {


                // send back to the page with the input data and errors
                $notification = array(
                    'message' => 'Please Upload excel file!',
                    'alert-type' => 'error'
                );

                return Redirect::to('ssm/dataupload')->withErrors($validator)->with($notification);

            } else if ($validator->passes()) {
//                $headers = $this->getHeader(Input::file('export_sales_data_name'));
//                Log::info($header);

                $uid = Auth::user()->user_id;
                $data = Excel::load($file, function ($reader) {
                })->get();

                $flag = 0;

                if (!empty($data) && $data->count()) {
                    foreach ($data as $key => $value) {


                        $rs = DB::table('MIS_FAC.SSM_SAMPLE_DATA')
                            ->where('pname',$value->pname)
                            ->where('batch_number',$value->batch_number)
                            ->where('chamber_id',$value->chamber_id)
                            ->get();
                        Log::info($rs);

                        if($rs->isEmpty())
                        {

//                            Log::info(" I am in");
                            $insert[] = [
                                'PNAME' => trim(strtoupper($value->pname)),
                                'MODE_OF_PACK' => trim(strtoupper($value->mode_of_pack)),
                                'P_SIZE' => trim(strtoupper($value->p_size)),
                                'UNIT' => trim(strtoupper($value->unit)),
                                'ANA_TIME_PRO' => trim(strtoupper($value->ana_time_pro)),
                                'ANA_TIME_NSB' => trim(strtoupper($value->ana_time_nsb)),
                                'TEST_DUR' => trim(strtoupper($value->test_dur)),
                                'TEST_DUR_UNIT' => trim(strtoupper($value->test_dur_unit)),
                                'EXPORT_COUNTRY' => trim(strtoupper($value->export_country)),
                                'BATCH_NUMBER' => trim(strtoupper($value->batch_number)),
                                'KEPT_ON_DATE' => trim(strtoupper($value->kept_on_date)),
                                'DOSAGE_FORM' => trim(strtoupper($value->dosage_form)),
                                'CHAMBER_ID' => trim(strtoupper($value->chamber_id)),
                                'CHAMBER_STOR_LOC' => trim(strtoupper($value->chamber_stor_loc)),
                                'CHAMBER_STOR_COND' => trim(strtoupper($value->chamber_stor_cond)),
                                'TIME_POINT' => trim(strtoupper($value->time_point)),
                                'TIME_POINT_UNIT' => trim(strtoupper($value->time_point_unit)),
                                'STAB_TYPE' => trim(strtoupper($value->stab_type)),
                                'STAB_STUDY_REASON' => trim(strtoupper($value->stab_study_reason)),
                                'SAMPLE_QC_TEST' => trim(strtoupper($value->sample_qc_test)),
                                'SAMPLE_MB_TEST' => trim(strtoupper($value->sample_mb_test)),
                                'REQ_QTY_PFT' => trim(strtoupper($value->req_qty_pft)),
                                'NOT_POINT' => trim(strtoupper($value->not_point)),
                                'EXCESS_SAMPLE_QTY' => trim(strtoupper($value->excess_sample_qty)),
                                'TOT_SAMP_QTY_KFFT' => trim(strtoupper($value->tot_samp_qty_kfft)),
                                'SAMPLE_ORIENT' => trim(strtoupper($value->sample_orient)),
                                'PULL1_SAMPLE_QTY' => trim(strtoupper($value->pull1_sample_qty)),
                                'PULL1_SAMPLE_DATE' => trim(strtoupper($value->pull1_sample_date)),
                                'PULL2_SAMPLE_QTY' => trim(strtoupper($value->pull2_sample_qty)),
                                'PULL2_SAMPLE_DATE' => trim(strtoupper($value->pull2_sample_date)),
                                'PULL3_SAMPLE_QTY' => trim(strtoupper($value->pull3_sample_qty)),
                                'PULL3_SAMPLE_DATE' => trim(strtoupper($value->pull3_sample_date)),
                                'PULL4_SAMPLE_QTY' => trim(strtoupper($value->pull4_sample_qty)),
                                'PULL4_SAMPLE_DATE' => trim(strtoupper($value->pull4_sample_date)),
                                'PULL5_SAMPLE_QTY' => trim(strtoupper($value->pull5_sample_qty)),
                                'PULL5_SAMPLE_DATE' => trim(strtoupper($value->pull5_sample_date)),
                                'PULL6_SAMPLE_QTY' => trim(strtoupper($value->pull6_sample_qty)),
                                'PULL6_SAMPLE_DATE' => trim(strtoupper($value->pull6_sample_date)),
                                'PULL7_SAMPLE_QTY' => trim(strtoupper($value->pull7_sample_qty)),
                                'PULL7_SAMPLE_DATE' => trim(strtoupper($value->pull7_sample_date)),
                                'PULL8_SAMPLE_QTY' => trim(strtoupper($value->pull8_sample_qty)),
                                'PULL8_SAMPLE_DATE' => trim(strtoupper($value->pull8_sample_date)),
                                'PULL9_SAMPLE_QTY' => trim(strtoupper($value->pull9_sample_qty)),
                                'PULL9_SAMPLE_DATE' => trim(strtoupper($value->pull9_sample_date)),
                                'PULL10_SAMPLE_QTY' => trim(strtoupper($value->pull10_sample_qty)),
                                'PULL10_SAMPLE_DATE' => trim(strtoupper($value->pull10_sample_date)),
                                'PULL11_SAMPLE_QTY' => trim(strtoupper($value->pull11_sample_qty)),
                                'PULL11_SAMPLE_DATE' => trim(strtoupper($value->pull11_sample_date)),
                                'PULL12_SAMPLE_QTY' => trim(strtoupper($value->pull12_sample_qty)),
                                'PULL12_SAMPLE_DATE' => trim(strtoupper($value->pull12_sample_date)),
                                'PULL13_SAMPLE_QTY' => trim(strtoupper($value->pull13_sample_qty)),
                                'PULL13_SAMPLE_DATE' => trim(strtoupper($value->pull13_sample_date)),
                                'PULL14_SAMPLE_QTY' => trim(strtoupper($value->pull14_sample_qty)),
                                'PULL14_SAMPLE_DATE' => trim(strtoupper($value->pull14_sample_date)),
                                'REM_SAMPLE_QTY' => trim(strtoupper($value->rem_sample_qty)),
                                'REMARKS' => trim(strtoupper($value->remarks)),
                                'CREATE_USER' => $uid
                            ];
                        }
                        else{
                            $flag = 1;
                            $notification = array(
                            'message' => "Duplicate Row found in excel! $value->pname , $value->batch_number, $value->chamber_id",
                            'alert-type' => 'error'
                        );
                        return Redirect::to('ssm/dataupload')->with($notification);

                        }


                    }
                }

                if ( $flag != 1) {

                    try {
                        DB::table('MIS_FAC.SSM_SAMPLE_DATA')->insert($insert);
                    } catch (Oci8Exception $ee) {
                        Log::info($ee->getLine());
                        Log::info($ee->getCode());
                        Log::info($ee->getMessage());
//                        Log::info($ee->getTrace());
                        DB::rollBack();
                        $notification = array(
                            'message' => 'Duplicate Row found in excel!',
                            'alert-type' => 'error'
                        );
                        return Redirect::to('ssm/dataupload')->with($notification);
                    }

                    $dt = Carbon::now()->format('d-m-Y');
                    $sl = DB::select("SELECT count(*) cnt
                          FROM MIS_FAC.SSM_SAMPLE_DATA
                          WHERE to_char(CREATE_DATE,'DD-MM-RRRR') = ?
                          AND CREATE_USER = ?", [$dt, $uid]);
                    $cnt = $sl[0]->cnt;

                    $notification = array(
                        'message' => 'File Uploaded successfully! ' . $cnt . ' rows inserted',
                        'alert-type' => 'success'
                    );
                    return Redirect::to('ssm/dataupload')->with($notification);

                } else {
                    $notification = array(
                        'message' => 'upload excel column format not valid!',
                        'alert-type' => 'error'
                    );
                    return Redirect::to('ssm/dataupload')->with($notification);
                }




            }
        }
    }


}
