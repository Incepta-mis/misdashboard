<?php

namespace App\Http\Controllers\SampleRequisition;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SampleReqVerificationController extends Controller
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

        return view('sample_requisition.sample_req_verification')->with(['month_name' => $month_name, 'rm_terr' => $rm_terr]);
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

            if ($request->mpo_terr) {

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
            } else {
                $brand_executive = DB::select("select be_id||' '||be_name id_name
                                            from
                                            (select iui.user_id be_id,NAME be_name 
                                            from mis.item_users_info iui,mis.item_group_verify_aproved igv
                                            where iui.p_group = igv.p_group
                                            and igv.user_id = ?
                                            and igv.verified_by is not null
                                            union all
                                            select iui.user_id be_id,NAME be_name 
                                            from mis.item_users_info iui,mis.item_group_verify_aproved igv
                                            where iui.p_group = igv.p_group
                                            and igv.user_id = ?
                                            and igv.APPROVED_BY is not null)", [Auth::user()->user_id, Auth::user()->user_id]);
                return response()->json(['brand_executive' => $brand_executive]);

            }


        }

    }

    public function display_data(Request $request)
    {

        $uid = Auth::user()->user_id;
        Log::info($request->all());

        $emp_status = DB::select("select emp_status
                                    from(
                                    select 'VERIFY' emp_status
                                    from mis.ITEM_GROUP_VERIFY_APROVED
                                    where user_id = ?
                                    and verified_by is not null
                                    union all
                                    select 'APPROVE' emp_status
                                    from mis.ITEM_GROUP_VERIFY_APROVED
                                    where user_id = ?
                                    and approved_by is not null)", [$uid, $uid]);


            if ($emp_status[0]->emp_status == 'VERIFY') {
                $summary_data = DB::select("select req_id, be_id,be_name,rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,unit_price,tot_value
                                    from
                                    (select 'ALL' all_data,req_id, be_id,be_name,rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,unit_price,tot_value
                                    from 
                                    (select irm.req_id, be_id,be_name,rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,ird.unit_price,tot_value
                                    from mis.item_requisition_d_app ird,mis.item_requisition_m irm,(select user_id be_id,name be_name from mis.item_users_info) ui
                                    where ird.req_id = irm.req_id
                                    and ird.create_user = ui.be_id
                                    and req_month = ?
                                    and verified_date is null) irda,(select iui.user_id from mis.item_users_info iui,mis.item_group_verify_aproved igv
                                                                     where iui.p_group = igv.p_group
                                                                     and igv.user_id = ?
                                                                     and igv.verified_by is not null) vuid
                                    where irda.be_id = vuid.user_id)
                                    where ? = case when ? = 'ALL' then all_data else be_id end
                                    and ? = case when ? = 'ALL' then all_data else rm_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else am_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else mpo_terr_id end",
                    [$request->reqMonth, $uid,
                        $request->be_id, $request->be_id,
                        $request->rmTerr, $request->rmTerr,
                        $request->amTerr, $request->amTerr,
                        $request->mpoTerr, $request->mpoTerr]);

                Log::info($summary_data);

            }
            else {
                $summary_data = DB::select("select req_id, be_id,be_name,rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,unit_price,tot_value
                                    from
                                    (select 'ALL' all_data, req_id, be_id,be_name,rm_terr_id,am_terr_id,mpo_terr_id,item_id,item_name,qty,unit_price,tot_value
                                    from 
                                    (select irm.req_id, be_id,be_name,rm_terr_id,am_terr_id,mpo_terr_id,ird.item_id,ird.item_name,ird.qty,ird.unit_price,tot_value
                                    from mis.item_requisition_d_app ird,mis.item_requisition_m irm,(select user_id be_id,name be_name from mis.item_users_info) ui
                                    where ird.req_id = irm.req_id
                                    and ird.create_user = ui.be_id
                                    and req_month = ?
                                    and approved_date is null
                                    and verified_date is not null) irda,(select iui.user_id from mis.item_users_info iui,mis.item_group_verify_aproved igv
                                                                     where iui.p_group = igv.p_group
                                                                     and igv.user_id = ?
                                                                     and igv.approved_by is not null) vuid
                                    where irda.be_id = vuid.user_id)
                                    where ? = case when ? = 'ALL' then all_data else be_id end
                                    and ? = case when ? = 'ALL' then all_data else rm_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else am_terr_id end
                                    and ? = case when ? = 'ALL' then all_data else mpo_terr_id end",
                    [$request->reqMonth, $uid,
                        $request->be_id, $request->be_id,
                        $request->rmTerr, $request->rmTerr,
                        $request->amTerr, $request->amTerr,
                        $request->mpoTerr, $request->mpoTerr]);
            }




        return response()->json(['summary_data' => $summary_data]);
    }

    public function summary_data_stock(Request $request)
    {


        $summary_data_stock = DB::select("select item_id, qty 
                                                from sample_new.v_v_stock@web_to_sample_msd 
                                                where item_id = ?",
            [$request->item_id]);

        return response()->json($summary_data_stock);
    }

    public function delete_row(Request $request)
    {
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

        Log::info(Auth::user());

        if ($request->ajax()){

//            dd($request->verifyData);

            foreach ($request->verifyData as $data){

                $insert_deleted = DB::insert("insert into mis.item_requisition_delete
                                        select d.*, '$uid', '$uname', (select sysdate from dual)
                                        from mis.item_requisition_d d
                                        where req_id = ?
                                        and item_id = ?",
                                        [$data['req_id'],$data['item_id']]);



                DB::delete("delete from mis.item_requisition_d_app
                            where req_id = ?
                            and item_id = ?",
                            [$data['req_id'],$data['item_id']]);

            }
        }

        return response()->json(['success' => 'Sample Requisition Deleted']);
    }

    public function update_row(Request $request)
    {

        Log::info($request->all());

        $update = DB::update("
                            update mis.item_requisition_d_app set
                            qty = ?,
                            tot_value = ?
                            where req_id = ?
                            and item_id = ?", [$request->qty, $request->tot_value, $request->req_id, $request->item_id]);

        return response()->json(['update' => $update]);

    }

    public function emp_access_status(Request $request)
    {
        $uid = Auth::user()->user_id;
//        $uname = Auth::user()->name;

        $emp_status = DB::select("select emp_status
                                    from(
                                    select 'VERIFY' emp_status
                                    from mis.ITEM_GROUP_VERIFY_APROVED
                                    where user_id = ?
                                    and verified_by is not null
                                    union all
                                    select 'APPROVE' emp_status
                                    from mis.ITEM_GROUP_VERIFY_APROVED
                                    where user_id = ?
                                    and approved_by is not null)", [$uid, $uid]);
//        dd($emp_status);
        foreach ($request->verifydata as $vd) {
            if ($emp_status[0]->emp_status == 'VERIFY') {
                $status = DB::update(
                    'update mis.item_requisition_d_app
                     set VERIFIED_ID = ?,
                         VERIFIED_NAME = ?,
                         VERIFIED_DATE = ?
                     where req_id = ?
                     and item_id = ?', [
                        Auth::user()->user_id,
                        Auth::user()->name,
                        Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        $vd['req_id'],
                        $vd['item_id']
                    ]
                );

            } else {
                $status = DB::update(
                    'update mis.item_requisition_d_app
                     set APPROVED_ID = ?,
                         APPROVED_NAME = ?,
                         APPROVED_DATE = ?
                     where req_id = ?
                     and item_id = ?', [
                        Auth::user()->user_id,
                        Auth::user()->name,
                        Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                        $vd['req_id'],
                        $vd['item_id']
                    ]
                );
            }

        }

        return response()->json(['emp_status' => $emp_status]);
    }

}
