<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 11/20/2019
 * Time: 1:48 PM
 */



namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class Pay_Order_Status_Controller extends Controller{

    public function index(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;


        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){


            $sum_id = DB::Select("
                                select distinct summ_id 
                                from mis.donation_cheque_cash_status
                                where ssd_send_date is not null
                                and rm_received_date is null
                                and rm_emp_id = '$uid'
                                order by summ_id                                                                   
                                    ");

            return view('donation.pay_order_status')->with(['sum_id' => $sum_id]);

        }

        else{

            $year = DB::select("
                            select to_number(to_char(sysdate, 'RRRR'))-1 year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");


            return view('donation.pay_order_status')->with(['year' => $year]);
        }

    }


    public function sum_id_list(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){


                $resp_data = DB::Select("
                                select distinct summ_id 
                                from mis.donation_cheque_cash_status
                                where ssd_send_date is not null
                                and rm_received_date is null
                                and rm_emp_id = '$uid'
                                order by summ_id                                                                   
                                    ");

            }

          else {

              $resp_data = DB::Select("
                            select distinct summ_id
                            from(
                            select distinct summ_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,drc.d_id
                            from donation_req_correction drc,donation_expense_budget deb
                            where drc.req_id = deb.req_id
                            and payment_mode = 'CHEQUE'
                            and payment_month = '$request->month'
                            minus
                            select distinct summ_id,rm_terr_id,d_id from mis.donation_cheque_cash_status
                            where payment_month = '$request->month'
                            )
                            order by summ_id  
                                                                                        
                                    ");
            }


            return response()->json($resp_data);
        }
    }

    public function sum_id_list_report(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

//            if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){
//
//
//                $resp_data = DB::Select("
//                                select distinct summ_id
//                                from mis.donation_cheque_cash_status
//                                where ssd_send_date is not null
//                                and rm_received_date is null
//                                and rm_emp_id = '$uid'
//                                order by summ_id
//                                    ");
//
//            }
//
//            else {

                $resp_data = DB::Select("
                        
                            select distinct rm_terr_id from mis.donation_cheque_cash_status
                            where payment_month = '$request->month'
                            order by rm_terr_id  
                                                                                        
                                    ");
//            }


            return response()->json($resp_data);
        }
    }

    public function region_list(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::Select("

                    select distinct rm_terr_id
                    from(
                    select distinct summ_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,drc.d_id
                    from donation_req_correction drc,donation_expense_budget deb
                    where drc.req_id = deb.req_id
                    and payment_mode = 'CHEQUE'
                    and payment_month = '$request->month'
                    minus
                    select distinct summ_id,rm_terr_id,d_id from mis.donation_cheque_cash_status
                    where payment_month = '$request->month'
                    )where summ_id = '$request->sum_id'
                    order by  rm_terr_id
                                                                                        
                                    ");


            return response()->json($resp_data);
        }
    }

    public function region_list_report(Request $request)
    {
        $uid = Auth::user()->user_id;
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if ($request->ajax()) {

            $resp_data = DB::Select("

                    select distinct summ_id
                    from(
                    select distinct summ_id,rm_terr_id,d_id from mis.donation_cheque_cash_status
                    where payment_month = '$request->month'
                    )where rm_terr_id = '$request->region'
                    order by  summ_id
                                                                                        
                                    ");


            return response()->json($resp_data);
        }
    }

    public function pay_order_data(Request $request)
    {

//        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $uid = Auth::user()->user_id;

        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){

            $resp_data = DB::Select("
            
                        select  payment_month,d_id,depot_name,rm_terr_id,rm_emp_id,name,desig,payment_mode,summ_id,ssd_nopo,
                        ssd_send_date,' ' rm_nopo,' ' remarks,' ' rm_received_date 
                        from 
                        (
                        select 'ALL' all_data, payment_month,d_id,depot_name,rm_terr_id,rm_emp_id,rm_name as name,desig,payment_mode,summ_id,ssd_nopo,
                        ssd_send_date,rm_nopo,remarks,rm_received_date  
                        from mis.donation_cheque_cash_status
                        where
                        rm_emp_id = '$uid'
                        minus
                        select 'ALL' all_data, payment_month,d_id,depot_name,rm_terr_id,rm_emp_id,rm_name as name,desig,payment_mode,summ_id,ssd_nopo,
                        ssd_send_date,rm_nopo,remarks,rm_received_date  
                        from mis.donation_cheque_cash_status
                        where
                        rm_received_date is not null
                        and rm_emp_id = '$uid'
                        )
                        where  
                        '$request->sum_id' = case when '$request->sum_id' = 'ALL' then all_data else to_char(summ_id) end 
                        order by summ_id

                                  
                                    ");
        }

        else{

//            dd($request->region);

            $resp_data = DB::Select("
            
                    select payment_month,d_id,depot_name,rm_terr_id,rm_emp_id,name,desig,payment_mode,summ_id,ssd_nopo,
                    ssd_send_date,rm_nopo,remarks,rm_received_date 
                    from(
                    select payment_month,drc.d_id,d_name depot_name,rm_terr_id,case when rgi.rm_emp_id is null then asm_emp_id else rgi.rm_emp_id end rm_emp_id,
                    case when rgi.rm_emp_id is null then asm_name else rgi.rm_name end name,
                    case when rgi.rm_emp_id is null then 'ASM' else 'RM' end desig,payment_mode,summ_id, count(*) ssd_nopo,
                    ' ' ssd_send_date,count(*) rm_nopo,' ' remarks,' ' Rm_received_date,
                    summ_id||rm_terr_id||drc.d_id rsid
                    from donation_req_correction drc,donation_expense_budget deb,rm_gm_info rgi   
                    where drc.req_id = deb.req_id
                    and payment_month = '$request->month'
                    and summ_id = '$request->sum_id'
                    and payment_mode = 'CHEQUE'
                    and substr(terr_id,1,instr(terr_id,'-'))||'00' = rm_terr_id
                    group by payment_month,drc.d_id,d_name,rm_terr_id,case when rgi.rm_emp_id is null then asm_name else rgi.rm_name end,summ_id||rm_terr_id||drc.d_id,
                    case when rgi.rm_emp_id is null then asm_emp_id else rgi.rm_emp_id end,case when rgi.rm_emp_id is null then 'ASM' else 'RM' end,payment_mode,summ_id
                    )dd,(select distinct summ_id||rm_terr_id||d_id sri
                    from(
                    select distinct summ_id,substr(terr_id,1,instr(terr_id,'-'))||'00' rm_terr_id,drc.d_id
                    from donation_req_correction drc,donation_expense_budget deb
                    where drc.req_id = deb.req_id
                    and payment_mode = 'CHEQUE'
                    and payment_month = '$request->month'
                    and summ_id = '$request->sum_id'
                    minus
                    select distinct summ_id,rm_terr_id,d_id from mis.donation_cheque_cash_status
                    where payment_month = '$request->month'
                    and summ_id = '$request->sum_id'
                    )where rm_terr_id in ('$request->region')) sd
                    where dd.rsid = sd.sri 
                    order by rm_terr_id
                        
                                    ");

        }

        return response()->json($resp_data);
    }

    public function ssd_send(Request $request)
    {
        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;
        if ($request->ajax()) {

            $data = $request->tblData;
//            dd($data);

            if (Auth::user()->desig === 'HO') {

                    DB::INSERT("
                       insert into mis.donation_cheque_cash_status 
                       (payment_month,d_id,depot_name,rm_terr_id,rm_emp_id,rm_name,desig,payment_mode,summ_id,ssd_nopo,ssd_send_date,ssd_send_emp_id)
                        values(?,?,?,?,?,?,?,?,?,?,?,?)
                    ",    [  $data['payment_month'], $data['d_id'],$data['depot_name'],$data['rm_terr_id'],
                        $data['rm_emp_id'], $data['name'],$data['desig'],$data['payment_mode'],
                        $data['summ_id'],$data['ssd_nopo'],$systime, $uid
                        ]);
            }

            return response()->json(['success' => 'Success']);
        }


    }

    public function remark_update(Request $request)
    {

        $data = $request->remarks_update;
//        dd($data);

        $update_action = DB::update("   
   
                    update mis.donation_cheque_cash_status 
                    set remarks = '$request->newValue'
                    where
                    payment_month = ?
                    and d_id = ?
                    and rm_terr_id = ? 
                    and summ_id = ?
                    ",
                      [  $data['payment_month'], $data['d_id'],$data['rm_terr_id'], $data['summ_id']
                        ]
                );

        return response()->json($update_action);


    }

    public function rm_receive(Request $request)
    {
        $systime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
        $uid = Auth::user()->user_id;
        $uname = Auth::user()->name;

            $data = $request->tblData;

            if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM') {

                $update_action = DB::update("   
   
                    update mis.donation_cheque_cash_status 
                    set rm_received_date = '$systime',
                    rm_received_emp_id =  '$uid',
                    rm_nopo = ?
                    where
                    payment_month = ?
                    and d_id = ?
                    and rm_terr_id = ? 
                    and summ_id = ?
                    ",
                    [  $data['ssd_nopo'],$data['payment_month'], $data['d_id'],$data['rm_terr_id'], $data['summ_id']
                    ]
                );

//                return response()->json($update_action);
                return response()->json(['success' => 'Success']);
            }




    }

    public function pay_order_report_view(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $uid = Auth::user()->user_id;


        if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM'){


            $sum_id = DB::Select("
                                select distinct summ_id 
                                from mis.donation_cheque_cash_status
                                where ssd_send_date is not null
                                and rm_received_date is null
                                and rm_emp_id = '$uid'
                                order by summ_id                                                                   
                                    ");

            return view('donation.pay_order_status')->with(['sum_id' => $sum_id]);

        }

        else{

            $year = DB::select("
                            select to_number(to_char(sysdate, 'RRRR'))-1 year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR')) year from dual
                            union all
                            select to_number(to_char(sysdate, 'RRRR'))+1 year from dual
                 ");


            return view('donation.pay_order_report')->with(['year' => $year]);
        }

    }

    public function pay_order_report_data(Request $request)
    {

//        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $uid = Auth::user()->user_id;

//        select payment_mont,d_id,depot_name,rm_terr_id,rm_emp_id,rm_name,desig,payment_mode,summ_id,ssd_nopo,
//                            ssd_send_date,rm_nopo,remarks,rm_received_date
//                            from mis.donation_cheque_cash_status
//                            where payment_month = '$request->month'
//    and summ_id = '$request->sum_id'
//    and rm_terr_id in ('$request->region')
//                            order by rm_terr_id


//            dd($request->region);

            $resp_data = DB::Select("

                    select payment_month,d_id,depot_name,rm_terr_id,rm_emp_id,rm_name,desig,payment_mode,summ_id,ssd_nopo,
                    ssd_send_date,rm_nopo,remarks,rm_received_date
                    from(
                    select 'ALL' all_data,payment_month,d_id,depot_name,rm_terr_id,rm_emp_id,rm_name,desig,payment_mode,summ_id,ssd_nopo,
                    ssd_send_date,rm_nopo,remarks,rm_received_date
                    from mis.donation_cheque_cash_status
                    where payment_month = '$request->month'
                    )where '$request->sum_id' = case when '$request->sum_id' = 'ALL' then all_data else to_char(summ_id) end 
                    and '$request->region' in case when '$request->region' = 'ALL' then all_data else rm_terr_id end
                    order by rm_terr_id,summ_id,d_id

                                    ");


        return response()->json($resp_data);
    }



}