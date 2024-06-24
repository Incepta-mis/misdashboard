<?php


namespace App\Http\Controllers\RMS;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeptWiseVacantReportController extends Controller
{

    public function index()
    {

        $plant_name = DB::select("select distinct plant_name, plant_id from mis.rms_dept_vacant");

        return view('rms.DeptWiseVacantReport')->with(['plant_name' => $plant_name]);

    }

    public function dwv_get_dept_info(Request $request)
    {

        $get_dept_info = DB::select("select distinct dept_name, dept_id from mis.rms_dept_vacant
                                        where plant_id = decode(?,'ALL',plant_id,?)", [$request->plant_id, $request->plant_id]);

        $get_vacant_info = DB::select("select vacant_id from mis.rms_dept_vacant
                                        where plant_id = decode(?, 'ALL', plant_id, ?)
                                        and dept_id = decode(?, 'ALL', dept_id, ?)
                                        and section_id = decode(?, 'ALL', section_id, ?)", [$request->plant_id, $request->plant_id,
            $request->dept_id, $request->dept_id,
            $request->section_id, $request->section_id]);

        return response()->json(['get_dept_info' => $get_dept_info, 'get_vacant_info' => $get_vacant_info]);

    }

    public function dwv_get_section_info(Request $request)
    {

        $get_section_info = DB::select("select distinct section_id, trim(section_name) section_name from mis.rms_dept_vacant
                                    where dept_id = decode(?, 'ALL', dept_id, ?)", [$request->dept_id, $request->dept_id]);

        return response()->json(['get_section_info' => $get_section_info]);

    }

    public function dwv_get_vacant_info(Request $request)
    {

        $dwv_get_vacant_info = DB::select("select vacant_id from mis.rms_dept_vacant
                                        where plant_id = decode(?, 'ALL', plant_id, ?)
                                        and dept_id = decode(?, 'ALL', dept_id, ?)
                                        and section_id = decode(?, 'ALL', section_id, ?)", [$request->plant_id, $request->plant_id,
                                                                                            $request->dept_id, $request->dept_id,
                                                                                            $request->section_id, $request->section_id]);

        return response()->json(['get_vacant_info'=>$dwv_get_vacant_info]);

    }

    public function dwv_get_data_vacant_report(Request $request)
    {

        $get_data_vacant_report = DB::select("select * from mis.rms_dept_vacant
                                                    where plant_id = decode(?, 'ALL', plant_id, ?)
                                                    and dept_id = decode(?, 'ALL', dept_id, ?)
                                                    and section_id = decode(?, 'ALL', section_id, ?)
                                                    and vacant_id = decode(?, 'ALL', vacant_id, ?)
                                                    order by vacant_id", [$request->plant_id,
                                                                                $request->plant_id,
                                                                                $request->dept_id,
                                                                                $request->dept_id,
                                                                                $request->section_id,
                                                                                $request->section_id,
                                                                                $request->vacant_id,
                                                                                $request->vacant_id]);

        return response()->json(['get_data_vacant_report' => $get_data_vacant_report]);

    }

}