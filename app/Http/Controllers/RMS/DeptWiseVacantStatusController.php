<?php


namespace App\Http\Controllers\RMS;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeptWiseVacantStatusController extends Controller
{

    public function index()
    {

        $plant_name = DB::select("select distinct plant_name, plant_id from mis.rms_dept_vacant");

        return view('rms.DeptWiseVacantStatus')->with(['plant_name' => $plant_name]);
    }

    public function get_dept_name(Request $request)
    {

        $get_dept_name = DB::select("select distinct dept_name from mis.rms_dept_vacant where plant_id = ? order by dept_name asc", [$request->plant_id]);
        $present = DB::select("select dept_name, sum(current_employee) current_employee
                                from mis.rms_dept_vacant 
                                where plant_id = ?
                                group by dept_name
								order by dept_name asc", [$request->plant_id]);
        $vacant = DB::select("select dept_name, sum(total_vacant_number) total_vacant_number
                                from mis.rms_dept_vacant 
                                where plant_id = ?
                                group by dept_name
								order by dept_name asc", [$request->plant_id]);
        $total = DB::select("select dept_name, sum(tnoe_organogram) tnoe_organogram
                                from mis.rms_dept_vacant 
                                where plant_id = ?
                                group by dept_name
								order by dept_name asc", [$request->plant_id]);

        $presentEmp = [];
        $vacantEmp = [];
        $totalEmp = [];

        foreach ($present as $p) {
            $presentEmp[] = (int)$p->current_employee;
        }

        foreach ($vacant as $v) {
            $vacantEmp[] = (int)$v->total_vacant_number;
        }

        foreach ($total as $t) {
            $totalEmp[] = (int)$t->tnoe_organogram;
        }

        $series = [
            [
                'name' => 'Presently Working',
                'data' => $presentEmp
            ],
            [
                'name' => 'Vacant',
                'data' => $vacantEmp
            ],
            [
                'name' => 'Total Employee',
                'data' => $totalEmp
            ]
        ];

        return response()->json(['get_dept_name' => $get_dept_name,'series'=>$series]);

    }

}