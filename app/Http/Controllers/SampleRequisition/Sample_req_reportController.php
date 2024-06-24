<?php

namespace App\Http\Controllers\SampleRequisition;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Sample_req_reportController extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $month_name = DB::select("  select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                order by rm_terr_id asc
                                ");

        return view('sample_requisition.sample_requisition_report')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);
    }

    public function get_am_terr(Request $request)
    {
//        Log::info($request->all());
        DB::setDateFormat('DD-MON-RR');

        $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id = ?
                                    ", [$request->rm_terr]);

        return response()->json($am_terr);
    }

    public function regwMpoTerrList(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {


            $am_info = DB::select("select sur_name, emp_id,emp_contact_no from
                        (select distinct am_terr_id,am_emp_id
                        from  hrtms.hr_terr_list@web_to_hrtms hr
                        where hr.am_terr_id = ?
                        and to_date(emp_month, 'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'), 'DD-MON-RR')
                        ) hr, (select emp_id,sur_name,emp_contact_no from msfa.emp_info@web_to_imsfa ms) ms
                        where hr.am_emp_id = ms.emp_id", [$request->amTerr]);


            $resp_data = DB::Select("select DISTINCT tl.mpo_terr_id mpo_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms tl
                                    where tl.rm_terr_id = '$request->rmTerrId'
                                    and tl.am_terr_id =    '$request->amTerr'
                                    and tl.emp_month = trunc(sysdate,'MM')
                                    order by TO_NUMBER(SUBSTR( tl.mpo_terr_id,instr( tl.mpo_terr_id,'-', -1)+1))");


            return response()->json(['mpo_terr' => $resp_data, 'am_info' => $am_info]);
        }
    }

    public function be_and_terr(Request $request)
    {

        if ($request->ajax()) {
            DB::statement("Alter Session set nls_date_format = 'DD-MON-RR' ");

                $mpo_info = DB::select("select sur_name, emp_id,emp_contact_no
                                    from
                                    (select distinct mpo_terr_id,mpo_emp_id
                                    from  hrtms.hr_terr_list@web_to_hrtms hr
                                    where hr.mpo_terr_id = ?
                                    and to_date(emp_month, 'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'), 'DD-MON-RR')
                                    ) hr, (select emp_id,sur_name,emp_contact_no from msfa.emp_info@web_to_imsfa ms) ms
                                    where hr.mpo_emp_id = ms.emp_id", [$request->mpo_terr]);

                $depo = DB::select("
                        select di.d_id depot_id,name depot_name
                        from hrtms.hr_terr_list@web_to_hrtms tl,msfa.depot@web_to_imsfa di
                        where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                        and tl.d_id = di.d_id
                        and mpo_terr_id= '$request->mpo_terr'
                          ");

                return response()->json(['depo' => $depo, 'mpo_terr' => $mpo_info]);

        }

    }

    public function display_data_report(Request $request)
    {

        $uid = Auth::user()->user_id;
        Log::info($request->all());

            $summary_data_report = DB::select("select  req_id, rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,unit_price,tot_value, verified_id, approved_id
                                    from                                    
                                    (select 'ALL' all_data,irm.req_id, ird.create_user be_id, rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,ird.unit_price,tot_value, verified_id, approved_id
                                    from mis.item_requisition_d_app ird,mis.item_requisition_m irm
                                    where ird.req_id = irm.req_id
                                    and ird.create_user = irm.be_create_user
                                    and ird.create_user = ?
                                    and req_month = ?)  
                                    where ? = case when ? = 'ALL' then all_data else rm_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else am_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else mpo_terr_id end",
                                    [$uid, $request->reqMonth,
                                    $request->rmTerr, $request->rmTerr,
                                    $request->amTerr, $request->amTerr,
                                    $request->mpoTerr, $request->mpoTerr]);

            Log::info($summary_data_report);

        return response()->json(['summary_data' => $summary_data_report]);
    }

public function sample_req_report_pdf(Request $request){
    $uid = Auth::user()->user_id;

    $summary_data_report = DB::select("select  req_id, rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,unit_price,tot_value
                                    from                                    
                                    (select 'ALL' all_data,irm.req_id, ird.create_user be_id, rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,ird.unit_price,tot_value, upper(approved_name) approved_name, upper(verified_name) verified_name
                                    from mis.item_requisition_d_app ird,mis.item_requisition_m irm
                                    where ird.req_id = irm.req_id
                                    and ird.create_user = irm.be_create_user
                                    and ird.create_user = ?
                                    and req_month = ?)  
                                    where ? = case when ? = 'ALL' then all_data else rm_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else am_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else mpo_terr_id end",
        [$uid, $request->req_month,
            $request->rm_terr, $request->rm_terr,
            $request->am_terr, $request->am_terr,
            $request->mpo_terr, $request->mpo_terr]);
    dd($summary_data_report);

    $pdf = \PDF::loadView('sample_requisition.sample_req_report_pdf',['rdata' => $summary_data_report]);
    return $pdf->stream('sample_requisition_report.pdf');

}

}
