<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('sites_layout.home');
    }
	
	public function profile()
    {
        $user_info = DB::select("select distinct sur_name name,
                                       case when ei.dept_id = 'D19999001' then 'NA' else d.desig_name end desig
                                from hrms.emp_information@web_to_hrms ei,hrms.emp_designation@web_to_hrms d
                                where emp_id = ?
                                and ei.desig_id = d.desig_id",[Auth::user()->user_id]);

        return view('sites_layout.profile')->with('user_info',$user_info);
    }

    public function changePassword(Request $request)
    {

       $user = User::find(Auth::user()->id);
       $message = '';

       if(count($user) > 0){

           $uid = Auth::user()->id;
           $newPass = Hash::make($request['n_pass']);
           $rawPass = $request['n_pass'];

           DB::table('MIS.DASHBOARD_USERS_INFO')->where('id',$uid)->update([
               'upassword' => $newPass,'raw_password' => $rawPass
           ]);

           $message = 'success';
       }
       else{
           $message = 'error';
       }
       return response()->json(['status'=>$message]);
    }
}
