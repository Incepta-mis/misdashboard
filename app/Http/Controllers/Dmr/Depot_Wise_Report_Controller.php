<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 3/15/2020
 * Time: 11:18 AM
 */

namespace App\Http\Controllers\Dmr;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

//Request $request

class Depot_Wise_Report_Controller extends Controller
{

    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;


        $month_name = DB::select("  select to_char(trunc(add_months(dt,l),'MM'),'MON-RR') monthname 
                                from
                                (
                                with data as (select level l from dual connect by level <= 3)
                                    select *
                                      from (select trunc(add_months(sysdate, -2)) dt from dual), data
                                     order by dt, l
                                     )
                                     ");

        $depot_info = DB::select("
                                    select  depot_id, depot_name,email from mis.donation_depot_info
                                     ");

            $cc = DB::select("
            select cost_center_id,cost_center_description,department
            from mis.donation_cost_center
            where budget_type = 'MEDICINE'
            ORDER BY cost_center_description
            ");



        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {



            return view('dmr.depot_wise_report')->with(['month_name' => $month_name, 'depot' => $depot_info,'cc' =>$cc]);

        }

        // echo $uid;


    }

    public function depot_wise_data(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());

    $resp_data = DB::select("

    select req_month,depot_id,depot_name,rm_terr_id,rm_name,p_code,product_name,pack_size,nvl(total_qty,0) total_qty,unit_price,nvl(total_value,0) total_value  
    from(
    select 'ALL' all_data,req_month,dcc.gl,dcc.cost_center_id,di.d_id depot_id,name depot_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
    rm_name,p_code,product_name,pack_size,sum(nvl(app_qty,0)) total_qty,s_p unit_price,sum(nvl(tot_val,0)) total_value    
    from mis.doctor_medicine_req_app dmra,msfa.depot@web_to_imsfa di,(select gl,cost_center_id,cost_center_description cost_center_name 
    from mis.donation_cost_center where budget_type = 'MEDICINE') dcc
    where req_month = '$request->mon' 
    and ssd_checked_date is not null
    and dmra.gl = dcc.gl
    and dmra.cost_center_id = dcc.cost_center_id
    and dmra.d_id = di.d_id
    group by req_month,dcc.gl,dcc.cost_center_id,di.d_id,name,substr(terr_id,1,instr(terr_id,'-'))||'00',rm_name,
    p_code,product_name,pack_size,s_p order by product_name
    )
    where depot_id = '$request->depot'
    and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
    order by rm_terr_id


    ");

            return response()->json($resp_data);

        }
    }

    public function depot_wise_report_pdf(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

//        if ($request->ajax()) {
//            return response()->json($request->all());

$resp_data = DB::select("

select req_month,depot_id,depot_name,rm_terr_id,rm_name,p_code,product_name,pack_size,nvl(total_qty,0) total_qty,unit_price,nvl(total_value,0) total_value 
, rank () over ( partition by  rm_terr_id order by product_name) as sl   
from(
select 'ALL' all_data,req_month,dcc.gl,dcc.cost_center_id,di.d_id depot_id,name depot_name,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,
rm_name,p_code,product_name,pack_size,sum(nvl(app_qty,0)) total_qty,s_p unit_price,sum(nvl(tot_val,0)) total_value    
from mis.doctor_medicine_req_app dmra,msfa.depot@web_to_imsfa di,(select gl,cost_center_id,cost_center_description cost_center_name 
from mis.donation_cost_center where budget_type = 'MEDICINE') dcc
where req_month = '$request->bgt_month'
and ssd_checked_date is not null
and dmra.gl = dcc.gl
and dmra.cost_center_id = dcc.cost_center_id
and dmra.d_id = di.d_id
group by req_month,dcc.gl,dcc.cost_center_id,di.d_id,name,substr(terr_id,1,instr(terr_id,'-'))||'00',rm_name,
p_code,product_name,pack_size,s_p order by product_name
)
where depot_id = '$request->depot'
and '$request->cc' = case when '$request->cc' = 'ALL' then all_data else to_char(cost_center_id) end
order by rm_terr_id

");


//            dd($resp_data);

        $pdf = \SPDF::loadView('dmr/depot_wise_report_pdf',['rdata' => $resp_data] );
        return $pdf->download('depot_wise_report.pdf');

//        }
    }







}