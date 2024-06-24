<?php


namespace App\Http\Controllers\RMS;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use const Sodium\CRYPTO_BOX_NONCEBYTES;

class CVSortingReportController
{

    public function index()
    {

        $dept_name = DB::select("select distinct dept_name from rms_dept_recruitment order by dept_name asc");

        return view('rms.CVSortingReport')->with(['dept_name' => $dept_name]);

    }

    public function get_sorting_data_report(Request $request)
    {

        $get_sorting_data_report = DB::select("select recruitment_id,plant_id,plant_name,dept_name,section_name,desig_name,nid,candidate_name,father_name,to_char(dob, 'DD-MON-YYYY') dob,
                                                ssc_result,hsc_result,g_result,pg_result,o_result,email_address,contact_no,experience,source_reference
                                                from(
                                                select cvs.recruitment_id,plant_id,plant_name,dept_name,section_name,desig_name,nid,candidate_name,father_name,dob,
                                                       ssc_result,hsc_result,g_result,pg_result,o_result,email_address,contact_no,experience,source_reference
                                                from mis.rms_cv_sorting cvs,mis.rms_dept_recruitment dr
                                                where cvs.recruitment_id = dr.recruitment_id
                                                and nvl(recruitm_status,'RMS') <> 'COMPLETED'
                                                )where dept_name = decode(?, 'ALL', dept_name, ?)
                                                order by dept_name,recruitment_id,nid", [$request->dept_name, $request->dept_name]);

        return response()->json(['get_sorting_data_report'=>$get_sorting_data_report]);

    }

}