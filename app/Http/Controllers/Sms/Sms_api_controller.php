<?php

namespace App\Http\Controllers\sms;

use App\Mobi_service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Sms_api_controller extends Controller
{
    /**
     * sms_api_controller constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('sms_layout.view_sms');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request){
        set_time_limit(0);
        
        $req_data = $request->json()->all();
        Log::info($req_data);
        $status='';
        $status_log = '';
        $group = '';
        $contactsList = '';

        $api = new Mobi_service();
        if($request['type'] === 'S'){
            $contactsList = explode(',',$request['to']);
            //Log::info(explode(',',$request['to']));
            //$status = $api->sendMultiMessage(implode(',',$contactsList),$request['content']);
            $status = $api->sendMultiMessage($contactsList,$request['content']);
            Log::info($status);

            $status_log = [
                'triggerd_from' => 'Sms_Api_Controller|SingleSMS',
                'status_text' => 'Y',
                'sms_count' => '1',
                'sms_group' => 'Sms Gateway:Send SMS: '. $request['to'] ,
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ];

            DB::table('mis.sms_send_status_log')->insert($status_log);


        }elseif($request['type'] === 'M'){
            $contactsList = Helper::prepare_contacts($request['to']);
            $totalSentSms = 0;
            foreach ($contactsList as $contacts){
                //Log::info(implode(',',$contacts));
//                $status = $api->sendMultiMessage(implode(',',$contacts),$request['content']);
                $status = $api->sendMultiMessage($contacts,$request['content']);
                Log::info($status);
                //sleep(2);

            }

            foreach ($request['to'] as $gp){

                $group = $group .' | ' . $gp['grp_name'];
                $totalSentSms = $totalSentSms + $gp['t_count'] ;
            }

            $status_log = [
                'triggerd_from' => 'Sms_Api_Controller|MultipleSMS',
                'status_text' => 'Y',
                'sms_count' => $totalSentSms,
                'sms_group' => 'Sms Gateway:Send SMS: ' . $group ,
                'create_user' => Auth::user()->user_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')
            ];

            DB::table('mis.sms_send_status_log')->insert($status_log);

        }

        return response()->json($status);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload_save(Request $request){
       if($request->file){
           $status = Helper::save_data_from_xl($request->file);
           return response()->json($status);
       }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function grp_list(){
        $grps = Helper::get_groups_list();
        return response()->json($grps);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_record(Request $request){
        $request_data = $request->json()->all();
        if($request->grp === 'NEW'){
            $response_text = Helper::create_contact_with_group($request_data);
            return response()->json($response_text);
        }
        else{
            $response_text = Helper::create_contact($request_data);
            return response()->json($response_text);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_contacts_data(Request $request){
        $request_data = $request->json()->all();
        $response = Helper::get_contacts($request_data);
        return response()->json($response);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $out_response = Helper::update_contact($request->json()->all());
        return response()->json($out_response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request){
        $out_response = Helper::delete_contact($request->json()->all());
        return response()->json($out_response);
    }

    public function delete_grp(Request $request){
        $out_response = Helper::delete_group($request->json()->all());
        return response()->json($out_response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_sms_text(Request $request){
        $smstext = Helper::sms_text();
        return response()->json($smstext);
    }
}
