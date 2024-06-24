<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NeoSurveyController extends Controller
{
    public function index()
    {
        return view('Neocare.Neo_survey');
    }

    public function neosurvey(Request $request)
    {
        $arr = [];
        parse_str($request->param, $arr);

        $c_name1 = DB::select('select cust_number val from mis.NEO_SURVEY_DATA
                                where cust_number = ?',[$arr['mobile']]);

        Log::info($c_name1);

        if(count($c_name1)>0){
            return response()->json(['status'=>'You have already participated in the survey']);
        }
        else{
            $neosurvey = [];

            parse_str($request->param, $neosurvey);

            $neosurvey['create_date'] = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
            $neosurvey['cust_number'] = $arr['mobile'];

            $c_name = DB::select('select distinct name from mis.NEO_CUSTOMER_INFO
                                where contact_no = ?',[$arr['mobile']]);

            if(count($c_name) > 0){
                Log::info($c_name);
                $neosurvey['cust_name'] =$c_name[0]->name;

                Log::info($neosurvey);
                $insert_str = DB::table('mis.NEO_SURVEY_DATA')->insert($neosurvey);

                if ($insert_str) {
                    return response()->json(['status'=>'Thanks for taking the survey']);
                }else{
                    return response()->json(['status'=>'Something went wrong']);
                }
            }else{
                return response()->json(['status'=>'Before taking the survey, please provide your information from the entry form.']);
            }
        }

    }


}
