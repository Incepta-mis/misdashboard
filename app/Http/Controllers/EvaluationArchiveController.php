<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class EvaluationArchiveController extends Controller
{
    public function index(){

        $currently_selected = date('Y');
        $earliest_year = 1990;
        $latest_year = date('Y');

        $yearList = range( $latest_year, $earliest_year );

        $group = DB::SELECT("select distinct case p_group 
        when 'CELLBIOTIC'  then 'GENERAL'
        when 'KINETIX' then 'GENERAL'
        when 'ZYMOS' then 'GENERAL'
        else
        p_group
       end p_group 
       from(

select distinct p_group 
from sample_new.product_info@web_to_sample_msd
where sap_code is not null
and brand_name is not null
)
order by p_group
");
        return view("quiz_portal/evalArchvUp",['group'=>$group,'year'=>$yearList,'currently_selected'=>$currently_selected]);
    }
    public function uploadEvalArchv(Request $request){

        $uid = Auth::user()->user_id;

        $file_name = Input::file('upload_file');
        $year = $request->year;
        $group = $request->group;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        //validation
        $rules = array('upload_file' => 'required'); //'required'
        $msg = array('upload_file.required' => 'This field is required');
        $validator_empty = Validator::make(array('upload_file' => $file_name), $rules, $msg);

        if ($validator_empty->fails()) {
            return Redirect::to('quiz/evalArchvUp')->withErrors($validator_empty);
        }else if ($validator_empty->passes()) {
            $valid = Validator::make($request->all(), [
                'year' => 'required',
                'group' => 'required',
            ]);
            if ($valid->fails()) {
                return Redirect::to('quiz/evalArchvUp')->withErrors($valid);
            }else {
                $ext = strtolower($file_name->getClientOriginalExtension());
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
                    return Redirect::to('quiz/evalArchvUp')->withErrors($validator)->with($notification);
                } else if ($validator->passes()) {
                    $data = Excel::load($file_name, function ($reader) {
                    })->get();

                    $mcq_num = 0;
                    $bq_num = 0;
                    $total_num = 0;

                    $keys = array_keys(json_decode($data[0],true));

                    $mcq = explode('_',$keys[4]);
                    $bq = explode('_',$keys[5]);
                    $total = explode('_',$keys[6]);

                    $mcq_key_val = $keys[4];
                    $bq_key_val = $keys[5];
                    $total_key_val = $keys[6];

                    if($mcq[0] == 'mcq'){
                        $mcq_num = $mcq[1];
                    }
                    if($bq[0] == 'broad'){
                        $bq_num = $bq[2];
                    }
                    if($total[0] == 'total'){
                        $total_num = $total[1];
                    }

                    if (!empty($data) && $data->count()) {
                        foreach ($data as $key => $value) {
                            if($value->emp_code != null){
                                $uniqueData[] = [
                                    'year' => trim($request->year),
                                    'emp_code' => trim($value->emp_code)
                                ];

                                $insert[] = [
                                    'emp_id' => trim($value->emp_code),
                                    'trr_code' => trim($value->trr_code),
                                    'am_name' => trim($value->name_of_am),
                                    'year' => trim($request->year),
                                    'p_group' => trim($request->group),
                                    'mcq_score' => trim($value->{$mcq_key_val}),
                                    'mcq_total' => trim($mcq_num),
                                    'broad_ques_score' => trim($value->{$bq_key_val}),
                                    'broad_ques_total' => trim($bq_num),
                                    'total_score' => trim($value->{$total_key_val}),
                                    'total_out_of' => trim($total_num),
                                    'percentage' => number_format($value->percentage,2)
                                ];
                            }
                        }
                        if (!empty($insert)) {
                            $count = count($insert);
                            $unique = array_map("unserialize", array_unique(array_map("serialize", $uniqueData)));

                            if ($count > count($unique)) {
                                $notification = array(
                                    'message' => 'Duplicate data found in the excel file!',
                                    'alert-type' => 'error'
                                );
                                return Redirect::to('quiz/evalArchvUp')->with($notification);
                            } else {
                                $date_year = $request->year;
                                $_group = trim($request->group);
                                $qryData = DB::select("SELECT * FROM MIS.MSD_EVALUATION_ARCHIVE WHERE YEAR = '$date_year' AND P_GROUP = '$_group'");

                                if (count($qryData) > 0) {
                                    DB::DELETE("DELETE FROM MIS.MSD_EVALUATION_ARCHIVE WHERE YEAR = '$date_year' AND P_GROUP = '$_group'");
                                }
                                try {
                                    foreach ($insert as $k => $row) {
                                        DB::insert('insert into MIS.MSD_EVALUATION_ARCHIVE ( EMP_ID, TRR_CODE, AM_NAME, YEAR, P_GROUP, MCQ_SCORE, MCQ_TOTAL, BROAD_QUES_SCORE, 
                                                BROAD_QUES_TOTAL, TOTAL_SCORE, TOTAL_OUT_OF, PERCENTAGE, CREATED_AT, CREATED_BY) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                                            [$row['emp_id'], $row['trr_code'], $row['am_name'], $row['year'], $row['p_group'], $row['mcq_score'],
                                                $row['mcq_total'], $row['broad_ques_score'], $row['broad_ques_total'], $row['total_score'],
                                                $row['total_out_of'], $row['percentage'],  $date, $uid]);
                                    }
                                    $data = DB::SELECT("SELECT * FROM MIS.MSD_EVALUATION_ARCHIVE WHERE YEAR = '$date_year' AND P_GROUP = '$_group'");
                                    $notification = array(
                                        'message' => 'File Uploaded successfully! ',
                                        'alert-type' => 'success',
                                        'data' => json_encode($data)
                                    );
                                    return Redirect::to('quiz/evalArchvUp')->with($notification);
                                } catch (\Exception $ee) {
                                    Log::info($ee);
                                    DB::rollBack();
                                    $notification = array(
                                        'message' => 'Database Error!',
                                        'alert-type' => 'error'
                                    );
                                    return Redirect::to('quiz/evalArchvUp')->with($notification);
                                }
                            }
                        } else {
                            $notification = array(
                                'message' => 'upload excel column format not valid!',
                                'alert-type' => 'error'
                            );
                            return Redirect::to('quiz/evalArchvUp')->with($notification);
                        }

                    }
                }
            }
        }
    }
    public function downloadFile(){
        $file = storage_path("app/public/sample_files/Area Manager's Evaluation Test-19(Aster).xlsx");
        return response()->download($file);
    }
    public function evalArchvReport(){
        $yearList = DB::SELECT("SELECT DISTINCT YEAR FROM MIS.MSD_EVALUATION_ARCHIVE");
        $group = DB::SELECT("SELECT DISTINCT P_GROUP FROM MIS.MSD_EVALUATION_ARCHIVE");
        $emp = DB::SELECT("SELECT DISTINCT a.EMP_ID, b.NAME FROM MIS.MSD_EVALUATION_ARCHIVE a INNER JOIN DASHBOARD_USERS_INFO b on b.USER_ID = a.EMP_ID");
        return view('quiz_portal/reports/evalArchiveReport',['group'=>$group,'year'=>$yearList,'emp'=>$emp]);
    }
    public function getEvalArchvReport(Request $request){
        $year = $request->year;
        $group = $request->group;

        $data = DB::SELECT("SELECT * FROM MIS.MSD_EVALUATION_ARCHIVE WHERE 
        YEAR = decode ('$year','All',YEAR,'$year') AND P_GROUP = decode ('$group','All',P_GROUP,'$group')");

        return response()->json($data);
    }
    public function getEvalArchvReportEmpWIse(Request $request){
        $emp = $request->emp;

        $data = DB::SELECT("SELECT * FROM MIS.MSD_EVALUATION_ARCHIVE WHERE 
        EMP_ID = decode ('$emp','All',EMP_ID,'$emp')");

        return response()->json($data);
    }
}
