<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPassController extends Controller
{
    public function check_send_mail(Request $request){
        if($request->ajax()){

            $user = DB::select('select user_id,name,email,raw_password
                                from mis.dashboard_users_info
                                where user_id = ?',[$request->uid]);

            $responseData = [];
            if($user){
                if(strpos($user[0]->email,'@') !== false && strpos($user[0]->email,'.com') !== false){
                    
                        Mail::send(['html' => 'sites_layout.password_mail'], ['user'=>$user], function ($message) use ($user) {
                            $message->to($user[0]->email, $user[0]->name)
                                ->subject('User login credential');
                            $message->from('missoft@inceptapharma.com');
                        });
                        $responseData = ['response'=>'Please check your email!'];
                   
                }else{
                    $responseData = ['response'=>'Email ID not valid! Please contact with System Admin'];
                }
            }else{
                $responseData = ['response'=>'Employee code not valid!'];
            }

            return response()->json($responseData);
        }
    }
}
