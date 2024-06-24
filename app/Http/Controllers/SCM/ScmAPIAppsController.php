<?php

namespace App\Http\Controllers\SCM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScmAPIAppsController extends Controller
{
    public function index(Request $request)
    {
        $rs = DB::select("
            select count(*) cnt
            from mis.dashboard_users_info
            where user_id = '$request->email'
            and raw_password = '$request->password'
       ");

        if ($rs[0]->cnt > 0) {
            return [
                "token" => 'iamApiuser_909',
                "email" => $request->email
            ];
        } else {
            return ["token" => null];
        }

    }

    public function getSCMNotice(){
        // $rs = DB::select(" select * from mis.msd_exam_document ");
        $rs = DB::select(" select * from mis.scm_notice_upload ");
        return response()->json($rs);
    }

}