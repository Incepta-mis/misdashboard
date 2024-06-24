<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 3/23/2019
 * Time: 2:55 PM
 */

namespace App\Http\Controllers\Donation;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Mail;

//Request $request

class Cheq_Advice_Controller extends Controller
{
    public function index()
    {


        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {


            $sumid = DB::select("                               
                            SELECT   DISTINCT summ_id,fi_doc_no
                                    FROM      mis.donation_expense_budget deb
                                    JOIN
                                    MIS.DONATION_REQ_CORRECTION drc
                                    ON     deb.req_id = drc.req_id
                                    AND DRC.PAYMENT_MODE = 'CHEQUE'
                                    AND deb.fi_process IS NULL
                                    ORDER BY   summ_id DESC
         ");
            $bank_info = DB::select("
                                    select short_name,full_name,email,account_no,branch_name,city,address
                                    from mis.donation_bank_info
                                     ");

            $refno = DB::select("                               
                                   select distinct summ_id,ref_no
                                    from mis.donation_expense_budget
                                    where ref_no is not null
                                    and bank_account_no is not null
                                     and create_date >=  sysdate - 60                                  
                                    order by summ_id desc,ref_no desc
                                     ");




            return view('donation.cheque_advice')->with(['sumid' => $sumid,'bank' => $bank_info,'refno'=>$refno]);

        }


    }

    public function sum_show(Request $request)
    {
        if ($request->ajax()) {
            $sumd = DB::select("

                            select count(*) total_no_of_req,sum(nvl(approved_amount,0)) total_req_amount  
                            from mis.donation_expense_budget deb,mis.donation_req_correction dc
                            where deb.req_id = dc.req_id
                            and payment_mode = 'CHEQUE'
                            and fi_process is null
                            and fi_doc_no = '$request->fidocno'

                     
            ");

            return response()->json($sumd);
        }
    }

    public function prepare_advice(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {

            try{

                $result = DB::executeProcedure('mis.pro_donation_Cheque_Process',['fdno'=>$request->docno,'ban'=>$request->acno,'bsn'=>$request->shno]);

            }
            catch(Oci8Exception $e){
                $result=$e->getMessage();
            }
            return response()->json($result);


        }
    }

    public function print_advice(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");


        $ba_val =  DB::select("
                       select  distinct print_ba from mis.donation_expense_budget 
                      where req_id in ( select req_id from mis.donation_process_cheque)  
                    ");

//dd($ba_val);

//        if ($request->ajax()) {

        $short = json_decode($request->bank);

                $chkval ='';
                if( empty($_POST["ac_check"]) ) { $chkval='Bai-Muajjal TR facilities'; }

                else { $chkval= 'account no. '.$short->acno ; }




            try{

                $result = DB::select("
                        select summ_id,ref_no,cd, chk,ct,bn, fn, ac_no,no_of_req,
                        total_req_amount,company_name,
                        amountinwords,md.cost_center_id  from  
                        (
                        select summ_id,ref_no,count(*) no_of_req,to_char(sysdate, 'Month DD, YYYY') cd,
                        '$chkval' chk,'$short->ct' ct,'$short->bn' bn,'$short->fn' fn,'$short->acno' ac_no,
                        sum(nvl(approved_amount,0)) total_req_amount,
                        sum(nvl(approved_amount,0)) as amountinwords,cost_center_id
                        from mis.donation_expense_budget deb,mis.donation_process_cheque dp,mis.donation_req_correction dc
                        where deb.req_id = dp.req_id
                        and dp.req_id = dc.req_id
                        and print_ba is  null
                        group by ref_no,summ_id,cost_center_id)md,(select distinct cost_center_id,company_code,company_name
                        from mis.donation_cost_center
                        where budget_type = 'DONATION') cc
                        where md.cost_center_id = cc.cost_center_id
                ");




                $data = ['rs_data' => $result,'ba_val' => $ba_val ];

                if($ba_val[0]->print_ba=='1'){
                    $pdf = \PDF::loadView('donation/bank_advice', $data);
                    return $pdf->setPaper('a4','portrait')->stream('Bank Advice.pdf');
                }
                else{

                    DB::executeProcedure('mis.pro_print_view_bank_advice');
                    if (file_exists(storage_path('/donation/Bank Advice.pdf'))) {
                        unlink(storage_path('donation/Bank Advice.pdf'));

                    }
                    $pdf = \PDF::loadView('donation/bank_advice', $data)->save(storage_path('donation/Bank Advice.pdf'));

                    return $pdf->setPaper('a4','portrait')->stream('Bank Advice.pdf');


                }





            }
            catch(Oci8Exception $e){
                $result=$e->getMessage();
            }
            return response()->json($result);


//        }
    }

    public function print_payee(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
//        if ($request->ajax()) {

        $pa_val =  DB::select("
                    select  distinct print_pl from mis.donation_expense_budget 
                    where req_id in(select req_id from mis.donation_process_cheque)   
                    ");

        $short = json_decode($request->bank);

        try{

            $result = DB::select("

                    select * from
                    (
                    select summ_id,to_char(sysdate, 'Month DD, YYYY') cd,ref_no,sl,upper(in_favour_of) in_favour_of,amount,total_amount,cost_center_id
                    from
                    (select summ_id,ref_no,sl,in_favour_of,approved_amount amount  ,cost_center_id
                    from mis.donation_expense_budget deb,mis.donation_process_cheque dp,mis.donation_req_correction dc
                    where deb.req_id = dp.req_id
                    and dp.req_id = dc.req_id
                    and bank_account_no = '$short->acno'
                    and print_pl is null),(select sum(nvl(approved_amount,0)) total_amount
                    from mis.donation_process_cheque dp,mis.donation_req_correction dc
                    where dp.req_id = dc.req_id)                                               
                    order by sl
                    )md,
                    (select distinct cost_center_id,company_code,company_name
                    from mis.donation_cost_center
                    where budget_type = 'DONATION') cc
                    where md.cost_center_id = cc.cost_center_id
    
                ");

//            $result = DB::select("
//
//                       select to_char(sysdate, 'Month DD, YYYY') cd, ref_no, sl ,
//                        in_favour_of,approved_amount amount
//                        from mis.donation_expense_budget deb,mis.donation_process_cheque dp,mis.donation_req_correction dc
//                        where deb.req_id = dp.req_id
//                        and dp.req_id = dc.req_id
//                        and bank_account_no = '$short->acno'
//                        and print_pl is null
//                        order by sl
//                ");

//            if(empty($result)){
//              $result = 0;
//            }
//            dd($result);
//            exit;


//            DB::executeProcedure('mis.pro_print_view_payee_list');


            $data = ['rs_data' => $result,'pa_val'=>$pa_val];



            if($pa_val[0]->print_pl=='1'){
                $pdf = \PDF::loadView('donation/payee_list', $data);
                return $pdf->stream('payee_list.pdf');
            }
            else{

               DB::executeProcedure('mis.pro_print_view_payee_list');
                if (file_exists(storage_path('/donation/payee_list.pdf'))) {

                    unlink(storage_path('donation/payee_list.pdf'));

                }
                if (file_exists(storage_path('/donation/payee_list.xls'))) {

                    unlink(storage_path('donation/payee_list.xls'));

                }
                \Excel::create('payee_list', function ($excel) use ($data) {

                    $excel->sheet('Summary Data', function ($sheet) use ($data) {
                        $sheet->loadView('donation.excel_layout.cheque_payee_list_excel', $data);
//                    $sheet->setWidth(array(
//                        'A' => 10,
//                        'B' => 10,
//                        'D' => 10
//                    ));
                        $sheet->protect('incepta_accounts');
                    });

                })->store('xls', storage_path('donation/'));

                $pdf = \PDF::loadView('donation/payee_list', $data)->save(storage_path('donation/payee_list.pdf'));
                return $pdf->setPaper('a4','portrait')->stream('payee_list.pdf');
            }


        }
        catch(Oci8Exception $e){
            $result=$e->getMessage();
        }
        return response()->json($result);


//        }
    }

    public function send_mail_cheque(Request $request){


        $mail_val=  DB::select("
                  select  distinct send_mail from mis.donation_expense_budget 
                    where req_id in(select req_id from mis.donation_process_cheque)  
                    ");

 $sum_id=  DB::select("
                    select distinct summ_id,ref_no
                    from mis.donation_expense_budget deb,mis.donation_process_cheque dp
                    where deb.req_id = dp.req_id 
                    ");
        $summary_id = $sum_id[0]->summ_id;


        if($mail_val[0]->send_mail=='1'){
            return response()->json(['success' => 'true']);
        }
        else{


//        $mail_address = DB::select("select email from mis.donation_depot_info  where depot_id= '$request->did'   ");
            $to_mail = $request->embank;
//        $to_mail= 'sahadat@inceptapharma.com';
//        $data_mail= $to_mail;
            $data_mail=[];
//        $path =realpath("storage/donation/".'Bank Advice.pdf');
            Mail::send(['html' => 'donation.cheque_mail'], $data_mail,
             function ($message) use($to_mail,$summary_id) {
                 $message->to(explode(',',$to_mail));
                 $message->subject("Cheque Advice Summary Id - ". $summary_id );
                $message->from('mis@inceptapharma.com','MIS');
//                $message->attach(storage_path('/donation/Bank Advice.pdf'));
//            $message->attach($path);
//                $message->attach(storage_path('/donation/payee_list.pdf'));
                $message->attach(storage_path('/donation/payee_list.xls'));
            });

            DB::update(" 
               update mis.donation_expense_budget 
               set send_mail=1 
               where req_id in(select req_id from mis.donation_process_cheque) 
                ");

        }




    }

    public function print_advice_super(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $short = json_decode($request->bank);

        $chkval ='';
        if( empty($_POST["ac_check"]) ) { $chkval='Bai-Muajjal TR facilities'; }

        else { $chkval= 'account no. '.$short->acno ; }


        try{

            $result = DB::select("
                      
                    select summ_id,ref_no,cd, chk,ct,bn, fn, ac_no,no_of_req,
                    total_req_amount,company_name,
                    amountinwords,md.cost_center_id  from
                    ( select summ_id,ref_no,count(*) no_of_req,to_char(sysdate, 'Month DD, YYYY') cd,
                    '$chkval' chk,'$short->ct' ct,'$short->bn' bn,'$short->fn' fn,'$short->acno' ac_no,
                    sum(nvl(approved_amount,0)) total_req_amount,
                    sum(nvl(approved_amount,0)) as amountinwords,cost_center_id
                    from mis.donation_expense_budget deb,mis.donation_req_correction dc
                    where deb.req_id = dc.req_id
                    and ref_no = '$request->ref_no'
                    group by ref_no,summ_id,cost_center_id)md,(select distinct cost_center_id,company_code,company_name
                    from mis.donation_cost_center
                    where budget_type = 'DONATION') cc
                    where md.cost_center_id = cc.cost_center_id
                ");


            $data = ['rs_data' => $result];

//                if (file_exists(storage_path('/donation/Bank Advice.pdf'))) {
//                    unlink(storage_path('donation/Bank Advice.pdf'));
//
//                }
                $pdf = \PDF::loadView('donation/bank_advice_super', $data);

                return $pdf->stream('Bank Advice.pdf');

        }
        catch(Oci8Exception $e){
            $result=$e->getMessage();
        }
        return response()->json($result);


//        }
    }

    public function print_payee_super(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
//        if ($request->ajax()) {


        $short = json_decode($request->bank);

        try{


            $result = DB::select("

                select * from
                (select summ_id,to_char(sysdate, 'Month DD, YYYY') cd,ref_no,sl,upper(in_favour_of) in_favour_of,amount,total_amount,cost_center_id
                from
                (select summ_id,ref_no,sl,in_favour_of,approved_amount amount ,cost_center_id 
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where deb.req_id = dc.req_id
                and ref_no = '$request->ref_no'
                order by sl) ,
                (select sum(nvl(approved_amount,0)) total_amount
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where ref_no = '$request->ref_no' and deb.req_id = dc.req_id)                                               
                order by sl)md,
                (select distinct cost_center_id,company_code,company_name
                from mis.donation_cost_center
                where budget_type = 'DONATION') cc
                where md.cost_center_id = cc.cost_center_id

                ");


            $data = ['rs_data' => $result];



//                if (file_exists(storage_path('/donation/payee_list.xls'))) {
//
//                    unlink(storage_path('donation/payee_list.xls'));
//
//                }

//                \Excel::create('payee_list', function ($excel) use ($data) {
//
//                    $excel->sheet('Summary Data', function ($sheet) use ($data) {
//                        $sheet->loadView('donation.excel_layout.cheque_payee_list_excel', $data);
//                        $sheet->protect('incepta');
//                    });
//
//                })->store('xls', storage_path('donation/'));

                $pdf = \PDF::loadView('donation/payee_list_super', $data);
                return $pdf->stream('payee_list.pdf');



        }
        catch(Oci8Exception $e){
            $result=$e->getMessage();
        }
        return response()->json($result);


//        }
    }


}