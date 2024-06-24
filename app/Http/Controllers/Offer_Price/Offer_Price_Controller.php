<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 14-Feb-19
 * Time: 12:28 PM
 */

namespace App\Http\Controllers\Offer_Price;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

//Request $request

class Offer_Price_Controller extends Controller
{
    public function index()
    {

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;

        // echo $uid;

                $month_name = DB::select("  select proposal_no,inv_id,ch_id,ch_name,d_id,p_code,product_name,t_p,vat,offered_percent,offered_price,                        
                case when qty is null then estimated_qty else qty end qty_pak,                        
                total_sales_at_offer_price,total_variable_cost,total_blp,profit_loss_at_vc,profit_loss_at_blp,margin                            
                from mis.discount_approval_verify                        
                where special_check_date is null 
                ");


            return view('offer_price.discount_approval')->with(['month_name' => $month_name ]);

    }

    public function detail_table_fetch(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {
//            return response()->json($request->all());

            if($uid=='1006603'){
                $resp_data = DB::select("
                select proposal_no,inv_id,ch_id,ch_name,d_id,dav.p_code,product_name,dav.t_p,dav.vat,offered_percent,offered_price,                        
                case when qty is null then estimated_qty else qty end qty_pak,                        
                total_sales_at_offer_price,total_variable_cost,total_blp,profit_loss_at_vc,profit_loss_at_blp,margin ,
                raw_cost, pack_cost,labour,qc,process_loss,job_work,dav.blp,dav.blp_vat                   
                from mis.discount_approval_verify dav ,depot_report.discount_blp_master@web_to_depot_report dbm                       
                where dav.p_code = dbm.p_code    and  special_check_date is null and general_check_date is null
                ");
            }

            if($uid=='1000725'){
                $resp_data = DB::select("
                select proposal_no,inv_id,ch_id,ch_name,d_id,dav.p_code,product_name,dav.t_p,dav.vat,offered_percent,offered_price,                        
                case when qty is null then estimated_qty else qty end qty_pak,                        
                total_sales_at_offer_price,total_variable_cost,total_blp,profit_loss_at_vc,profit_loss_at_blp,margin ,
                raw_cost, pack_cost,labour,qc,process_loss,job_work,dav.blp,dav.blp_vat                   
                from mis.discount_approval_verify dav ,depot_report.discount_blp_master@web_to_depot_report dbm                       
                where dav.p_code = dbm.p_code and  p_group in ('ASTER','GYRUS','OPERON-XENOVISION') and  special_check_date is null   
                ");
            }

            if($uid=='1000353'){

                $resp_data = DB::select("
              
                    select proposal_no,inv_id,ch_id,ch_name,d_id,dav.p_code,product_name,dav.t_p,dav.vat,offered_percent,offered_price,                        
                    case when qty is null then estimated_qty else qty end qty_pak,                        
                    total_sales_at_offer_price,total_variable_cost,total_blp,profit_loss_at_vc,profit_loss_at_blp,margin ,
                    raw_cost, pack_cost,labour,qc,process_loss,job_work,dav.blp,dav.blp_vat                   
                    from mis.discount_approval_verify dav ,depot_report.discount_blp_master@web_to_depot_report dbm                       
                    where dav.p_code = dbm.p_code and p_group in ('ASTER','GYRUS','OPERON-XENOVISION')                        
                    and special_check_date is not null                        
                    and general_check_date is null                        
                    union all                        
                    select proposal_no,inv_id,ch_id,ch_name,d_id,dav.p_code,product_name,dav.t_p,dav.vat,offered_percent,offered_price,                        
                    case when qty is null then estimated_qty else qty end qty_pak,                        
                    total_sales_at_offer_price,total_variable_cost,total_blp,profit_loss_at_vc,profit_loss_at_blp,margin ,
                    raw_cost, pack_cost,labour,qc,process_loss,job_work,dav.blp,dav.blp_vat                   
                    from mis.discount_approval_verify dav ,depot_report.discount_blp_master@web_to_depot_report dbm                       
                    where dav.p_code = dbm.p_code and p_group in ('CELLBIOTIC','KINETIX','ZYMOS')                        
                    and general_check_date is null                        
   
                ");

            }


            return response()->json($resp_data);

        }
    }

    public function discount_blp_data(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");


        $resp_data = DB::Select("    
                    select *
                    from depot_report.discount_blp_master@web_to_depot_report
                    where p_code = '$request->p_code' ");



        return response()->json($resp_data);
    }

    public function verify_and_update(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $verinfo = json_decode($request->verifyData);

//            dd($verinfo);


            $update = '';

            if($uid=='1006603') {
                foreach ($verinfo as $data) {

                    $update = DB::UPDATE("
                        update mis.discount_approval_verify
                        set offered_percent = '$data->offered_percent', offered_price = '$data->offered_price',
                        total_sales_at_offer_price = '$data->total_sales_at_offer_price', profit_loss_at_vc = '$data->profit_loss_at_vc',
                        profit_loss_at_blp = '$data->profit_loss_at_blp', margin = '$data->margin',
                        special_check_user = '$uid', special_check_date = (select sysdate from dual),
                        blp_status =  case when '$data->margin'>=0 then  'Y' else 'N' end ,
                        ed_check = 'YES'
                        where inv_id||ch_id||p_code = '$data->inv_id'||'$data->ch_id'||'$data->p_code'
                        and  p_group in ('ASTER','GYRUS','OPERON-XENOVISION')

                    ");

                    $update = DB::UPDATE("
                        update mis.discount_approval_verify
                        set offered_percent = '$data->offered_percent', offered_price = '$data->offered_price',
                        total_sales_at_offer_price = '$data->total_sales_at_offer_price', profit_loss_at_vc = '$data->profit_loss_at_vc',
                        profit_loss_at_blp = '$data->profit_loss_at_blp', margin = '$data->margin',
                        general_check_user = '$uid', general_check_date = (select sysdate from dual),
                        blp_status =  case when '$data->margin'>=0 then  'Y' else 'N' end ,
                        ed_check = 'YES'
                        where inv_id||ch_id||p_code = '$data->inv_id'||'$data->ch_id'||'$data->p_code'
                        and p_group in ('CELLBIOTIC','KINETIX','ZYMOS')  

                    ");


                }
            }

            if($uid=='1000725') {
                foreach ($verinfo as $data) {

                    $update = DB::UPDATE("
                        update mis.discount_approval_verify
                        set offered_percent = '$data->offered_percent', offered_price = '$data->offered_price',
                        total_sales_at_offer_price = '$data->total_sales_at_offer_price', profit_loss_at_vc = '$data->profit_loss_at_vc',
                        profit_loss_at_blp = '$data->profit_loss_at_blp', margin = '$data->margin',
                        special_check_user = '$uid', special_check_date = (select sysdate from dual),
                        blp_status =  case when '$data->margin'>=0 then  'Y' else 'N' end  ,
                        ed_check = 'YES'
                        where inv_id||ch_id||p_code = '$data->inv_id'||'$data->ch_id'||'$data->p_code'

                    ");
                }
            }

            if($uid=='1000353') {
                foreach ($verinfo as $data) {

                    $update = DB::UPDATE("
                        update mis.discount_approval_verify
                        set offered_percent = '$data->offered_percent', offered_price = '$data->offered_price',
                        total_sales_at_offer_price = '$data->total_sales_at_offer_price', profit_loss_at_vc = '$data->profit_loss_at_vc',
                        profit_loss_at_blp = '$data->profit_loss_at_blp', margin = '$data->margin',
                        general_check_user = '$uid', general_check_date = (select sysdate from dual),
                        blp_status =  case when '$data->margin'>=0 then  'Y' else 'N' end  ,
                        ed_check = 'YES'
                        where inv_id||ch_id||p_code = '$data->inv_id'||'$data->ch_id'||'$data->p_code'

                    ");
                }
            }
            return response()->json($update);

        }


    }


}