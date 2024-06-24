<?php


namespace App\Http\Controllers\ELM;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DepotEmployeeTransfer extends Controller
{
    public function index()
    {
        $rs = DB::select("select distinct plant_id, plant_name from hrms.plant_info@web_to_hrms order by plant_id");
        return view('elm_portal.depot_transfer',compact('rs'));
    }

    public function getDepotEmployeeInfo(Request $request)
    {
        $emp_id = $request->emp_id;
        $rs = DB::select("
            select *
            from mis.leave_emp_info
            where emp_id = '$emp_id'
        ");

        return response()->json($rs);
    }

    public function setDepotEmployeeInfo(Request $request)
    {
        $auth_id = Auth::user()->user_id;

        // Log::info($request->all());
        // Log::info($request->t_mgt_status);

        if ($request->t_mgt_status == 'NM') {
            $mgt = 'NM';
        } else if ($request->t_mgt_status == 'M') {
            $mgt = '';
        }

        $rs = DB::table('mis.leave_emp_info')
            ->where('emp_id', $request->c_emp_id)
            ->update([
                'plant_id' => $request->t_plant_id,
                'mail_address' => $request->t_email,
                'contact_no' => $request->t_contact_no,
                'report_supervisor' => $request->t_report_supervisor,
                'head_of_dept' => $request->t_head_of_dept,
                'hr_officer' => $request->t_hr_officer,
                'hr_officer1' => $request->t_hr_officer1,
                'hr_officer2' => $request->t_hr_officer2,
                'head_of_hr' => $request->t_head_of_hr,
                'mgt_status' => $mgt,
                'valid' => $request->t_valid,
                'UPDATE_USER' => $auth_id
            ]);
            
            DB::table('mis.dashboard_users_info')
            ->where('user_id', $request->c_emp_id)
            ->update([
                'plant_id' => $request->t_plant_id,
                'email' => $request->t_email
            ]);

        if ($rs) {
            return response()->json(['success' => 'Successfully ! Application Updated by User.']);
        } else {
            return response()->json(['error' => 'Please Contact Your Administrator.']);
        }
    }
}