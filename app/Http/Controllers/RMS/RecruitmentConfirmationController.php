<?php


namespace App\Http\Controllers\RMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecruitmentConfirmationController extends Controller
{

    public function index()
    {

        $recruitment_id = DB::select("select recruitment_id 
                                        from mis.rms_dept_recruitment 
                                        where recruitm_status is null
                                        order by recruitment_id asc");

        return view('rms.RecruitmentConfirmation')->with(['recruitment_id'=>$recruitment_id]);

    }

    public function search_result_recruitment(Request $request){

        $search_result_recruitment = DB::select("select * from mis.rms_dept_recruitment
                                            where recruitment_id = ?", [$request->recruitment_id]);

        return response()->json(['search_result_recruitment'=>$search_result_recruitment]);

    }

    public function complete_recruitment(Request $request){

        $update = [

            'recruitm_status' => $request->recruitm_status

        ];

        DB::table('mis.rms_dept_recruitment')->where('recruitment_id', $request->recruitment_id)->update($update);

    }

}