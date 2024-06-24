<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 1/26/2020
 * Time: 1:10 PM
 */

namespace App\Http\Controllers\SampleRequisition;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SampleRequisitionController extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $month_name = DB::select("select to_char(sysdate, 'DD-MON-YYYY') monthname from dual");

        $rm_terr = DB::select("select distinct rm_terr_id rm_terr_id
                                from hrtms.hr_terr_list@web_to_hrtms
                                where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                order by rm_terr_id asc
                                ");

        $item_sample = null;

        return view('sample_requisition.sample_requisition')
            ->with(['month_name' => $month_name, 'rm_terr' => $rm_terr, 'item_sample' => $item_sample == null ? [] : $item_sample]);


    }

    public function get_am_terr(Request $request)
    {
        //Log::info($request->all());
        DB::setDateFormat('DD-MON-RR');

        $rm_info = DB::select("select sur_name, emp_id,emp_contact_no 
                                from (select distinct rm_terr_id, case nvl(rm_emp_id,0)  when 0 then asm_emp_id else rm_emp_id end rm_emp_id from  hrtms.hr_terr_list@web_to_hrtms hr
                                where hr.rm_terr_id = ?
                                and to_date(emp_month, 'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'), 'DD-MON-RR')
                                ) hr, (select emp_id,sur_name,emp_contact_no from msfa.emp_info@web_to_imsfa ms) ms
                                where hr.rm_emp_id = ms.emp_id", [$request->rm_terr]);

//        dd($rm_info);

        $depo = DB::select("
            select distinct di.d_id depot_id,name depot_name
            from hrtms.hr_terr_list@web_to_hrtms tl,msfa.depot@web_to_imsfa di
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and tl.d_id = di.d_id
            and rm_terr_id= '$request->rm_terr'
              ");

        $am_terr = DB::select("select distinct am_terr_id am_terr_id
                                    from hrtms.hr_terr_list@web_to_hrtms
                                    where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
                                    and rm_terr_id = ?
                                    ", [$request->rm_terr]);


        return response()->json(['rm_info' => $rm_info, 'depo' => $depo, 'am_terr' => $am_terr]);
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


    public function depo_and_doc(Request $request)
    {

        if ($request->ajax()) {
            DB::statement("alter session set nls_date_format = 'DD-MON-RR' ");

            $docid = DB::select(" select   distinct dc.doctor_id, dc.doctor_name, dt.terr_id
                from   doctor_info.doctor_information@web_to_sample_msd dc,
                doctor_info.doctor_terr@web_to_sample_msd dt
                where       dc.doctor_id = dt.doctor_id
                and dt.valid = 'YES'
                and nvl (dc.doctor_status, 'VALID') != 'DELETE'
                and dt.terr_id = '$request->mpo_terr'
                order by doctor_id
            ");

            $depo = DB::select("
            select di.d_id depot_id,name depot_name
            from hrtms.hr_terr_list@web_to_hrtms tl,msfa.depot@web_to_imsfa di
            where to_date(emp_month,'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'),'DD-MON-RR')
            and tl.d_id = di.d_id
            and mpo_terr_id= '$request->mpo_terr'
              ");

            $mpo_info = DB::select("select sur_name, emp_id,emp_contact_no 
                                    from
                                    (select distinct mpo_terr_id,mpo_emp_id
                                    from  hrtms.hr_terr_list@web_to_hrtms hr
                                    where hr.mpo_terr_id = ?
                                    and to_date(emp_month, 'DD-MON-RR') = to_date(trunc(sysdate,'MONTH'), 'DD-MON-RR')
                                    ) hr, (select emp_id,sur_name,emp_contact_no from msfa.emp_info@web_to_imsfa ms) ms
                                    where hr.mpo_emp_id = ms.emp_id", [$request->mpo_terr]);


            return response()->json(['docid' => $docid, 'depo' => $depo, 'mpo_terr' => $mpo_info]);
        }
    }

    public function item_sample(Request $request)
    {

//        if (Auth::user()->user_id === '1018280') {
//
//            $item_sample = DB::select("select ii.item_id item_id, ip.item_id, ii.s_name item_name, ii.type sample_type, ip.verson_no version_no,
//                                             ii.s_group, ip.cogm + ip.vat as price
//                                                from sample_new.item_info@web_to_sample_msd ii, sample_new.item_info_price@web_to_sample_msd ip
//                                                where ii.item_id = ip.item_id
//                                                and ii.type in ('PPM', 'SAMPLE', 'GIFT')
//                                                order by ii.s_group
//            ");
//        } else {
        $uid = Auth::user()->user_id;
//        $p_group = DB::select('select p_group from mis.item_users_info where user_id = ?', [Auth::user()->user_id]);

        $item_sample = DB::select("select ii.item_id item_id, ip.item_id, ii.s_name item_name, ii.type sample_type, ip.verson_no version_no,
                                             ii.s_group, ip.cogm + ip.vat as price
                                                from sample_new.item_info@web_to_sample_msd ii, sample_new.item_info_price@web_to_sample_msd ip
                                                where ii.item_id = ip.item_id
                                                and ii.s_group in ((select case p_group when 'CELLBIOTIC' then p_group when 'KINETIX' then p_group when 'ZYMOS' then p_group
                                                                           when 'HYGIENE' then p_group when 'ANIMAL HEALTH' then p_group else null end p_group
                                                                    from mis.item_users_info
                                                                    where user_id = ? and p_group <> 'SPECIAL' 
                                                                    union all
                                                                    select case l when 1 then 'ASTER' when 2 then 'GYRUS' else 'OPERON-XENOVISION' end p_group 
                                                                    from mis.item_users_info iui,(select level l from dual connect by level <=3)
                                                                    where p_group = 'SPECIAL'  and user_id = ?))
                                                and ii.type in ('PPM', 'SAMPLE', 'GIFT')
                                                order by ii.s_group", [$uid, $uid]);
//        }


        return response()->json($item_sample);


    }

    public function insert_requisition_info(Request $request)
    {


        $req_id_temp = DB::select("select nvl(max(to_number(substr( req_id, 3 ))), 0)+1 req_id from item_requisition_m");
        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);
        $p_group = DB::select('select p_group from mis.item_users_info where user_id = ?', [Auth::user()->user_id]);

        $req_id = 'R-' . $req_id_temp[0]->req_id;
        $insert = [
            'req_id' => $req_id,
            'req_type' => $request->req_type,
            'p_group' => $p_group[0]->p_group,
            'rm_terr_id' => $request->rm_terr,
            'am_terr_id' => $request->am_terr,
            'mpo_terr_id' => $request->mpo_terr,
            'emp_id' => $request->emp_id,
            'emp_name' => $request->emp_name,
            'emp_phone' => $request->emp_no,
            'cause' => $request->remarks,
            'depot_id' => explode('|', $request->depo)[0],
            'depot_name' => explode('|', $request->depo)[1],
            'req_month' => strtoupper(Carbon::now('Asia/Dhaka')->format('M-y')),
            'be_create_user' => Auth::user()->user_id,
            'be_create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
            'com_id' => $com_plant[0]->com_id,
            'plant_id' => $com_plant[0]->plant_id
        ];

        DB::table('mis.item_requisition_m')->insert($insert);


        foreach ($request->insertdata as $row) {


            $insert_details = [
                'req_id' => $req_id,
                'item_id' => $row['i_code'],
                'item_name' => $row['item_name'],
                'qty' => $row['quant'],
                'unit_price' => $row['price'],
                'tot_value' => $row['total_price'],
                'p_group' => $p_group[0]->p_group,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                'create_user' => Auth::user()->user_id,
                'com_id' => $com_plant[0]->com_id,
                'plant_id' => $com_plant[0]->plant_id,
                'type' => $request->type,
                'version_no' => $request->version_no,
            ];

            DB::table('mis.item_requisition_d')->insert($insert_details);

            Log::info($insert_details);
        }


    }

    public function item_sample_stock(Request $request)
    {
        $item_sample_stock = DB::select("select item_id, qty 
                                                from sample_new.v_v_stock@web_to_sample_msd 
                                                where item_id = ?",
            [$request->item_id]);

        return response()->json($item_sample_stock);
    }

}