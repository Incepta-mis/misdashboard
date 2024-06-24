<?php


namespace App\Http\Controllers\RMS;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeptWiseRecruitmentReportController extends Controller
{

    public function index()
    {

        $plant_name = DB::select("select distinct plant_name, plant_id from mis.rms_dept_recruitment");

        return view('rms.DeptWiseRecruitmentReport')->with(['plant_name' => $plant_name]);

    }

    public function get_dept_info(Request $request)
    {

        $get_dept_info = DB::select("select dept_name, dept_id from mis.rms_dept_recruitment
                                        where plant_id = decode(?,'ALL',plant_id,?)", [$request->plant_id, $request->plant_id]);

        $get_recruitment_info = DB::select("select recruitment_id from mis.rms_dept_recruitment
                                            where plant_id = decode(?,'ALL',plant_id,?)", [$request->plant_id, $request->plant_id]);

        return response()->json(['get_dept_info' => $get_dept_info, 'get_recruitment_info' => $get_recruitment_info]);

    }

    public function get_section_info(Request $request)
    {

        $get_section_info = DB::select("select section_id, section_name from mis.rms_dept_recruitment
                                    where dept_id = decode(?, 'ALL', dept_id, ?)", [$request->dept_id, $request->dept_id]);

        return response()->json(['get_section_info' => $get_section_info]);

    }

    public function get_data_recruitment_report(Request $request)
    {

        $get_data_recruitment_report = DB::select("select * from mis.rms_dept_recruitment
                                                    where plant_id = decode(?, 'ALL', plant_id, ?)
                                                    and dept_id = decode(?, 'ALL', dept_id, ?)
                                                    and section_id = decode(?, 'ALL', section_id, ?)
                                                    and recruitment_id = decode(?, 'ALL', recruitment_id, ?)
                                                    order by recruitment_id", [$request->plant_id,
                                                                               $request->plant_id,
                                                                               $request->dept_id,
                                                                               $request->dept_id,
                                                                               $request->section_id,
                                                                               $request->section_id,
                                                                               $request->recruitment_id,
                                                                               $request->recruitment_id]);

        return response()->json(['get_data_recruitment_report' => $get_data_recruitment_report]);

    }

}