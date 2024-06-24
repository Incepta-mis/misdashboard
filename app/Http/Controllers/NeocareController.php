<?php

namespace App\Http\Controllers;

use App\Mobi_service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NeocareController extends Controller
{
    public function neocare()
    {
        $s_size = DB::select('select distinct sample_size from mis.neo_sample_size
                        
                        ');
        return view('Neocare.neocare', compact('s_size'));
    }

    public function save(Request $request)
    {
       // Log::info($request->param);
        $myValue = [];
        parse_str($request->param, $myValue);

        $myValue['create_user'] = Auth::user()->user_id;
        $myValue['create_date'] = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');
        $myValue['email'] = $myValue['emailpart1'] . $myValue['emailpart2'];
        unset($myValue['emailpart1']);
        unset($myValue['emailpart2']);
        $result = DB::table('mis.neo_customer_info')->insert($myValue);
        if ($result) {
           // Log::info($result);
            $api = new Mobi_service();
            $api->sendMessage('88' . $myValue['contact_no'],
                'Thank you Mr./Ms. '.$myValue['name'].' for receiving the sample of NeoCare baby diaper. Please stay with us and feel the difference. For home delivery call 01976362273. Follow us on https://www.facebook.com/neocare.bd/');
        }

       // Log::info($myValue);
        return response()->json(['status' => $result]);
    }
}
