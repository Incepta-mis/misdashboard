<?php

namespace App\Http\Controllers\Donation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Log;

class BEFTN_advice_Controller extends Controller
{
    public function index(){
        if (Auth::user()->desig === 'All' || Auth::user()->desig === 'HO') {
            $sumid = DB::SELECT("SELECT DISTINCT SUMM_ID,FI_DOC_NO 
                                 FROM MIS.DONATION_EXPENSE_BUDGET deb JOIN MIS.DONATION_REQ_CORRECTION drc
                                 ON deb.REQ_ID = drc.REQ_ID
                                 AND drc.PAYMENT_MODE = 'BEFTN'
                                 AND deb.FI_PROCESS IS  NULL
                                 ORDER BY SUMM_ID DESC");
            $bank_info = DB::SELECT("SELECT SHORT_NAME,FULL_NAME,EMAIL,ACCOUNT_NO,BRANCH_NAME,CITY,ADDRESS FROM MIS.DONATION_BANK_INFO");
            $refno = DB::SELECT("SELECT DISTINCT deb.SUMM_ID,deb.REF_NO
                                    FROM MIS.DONATION_EXPENSE_BUDGET deb JOIN MIS.DONATION_REQ_CORRECTION drc
                                    ON deb.REQ_ID = drc.REQ_ID
                                    AND drc.PAYMENT_MODE = 'BEFTN'
                                    AND deb.REF_NO IS NOT NULL
                                    AND deb.BANK_ACCOUNT_NO IS NOT NULL
                                    ORDER BY deb.SUMM_ID DESC,deb.REF_NO DESC");

            return view('donation.BEFTN_advice')->with(['sumid' => $sumid,'bank' => $bank_info,'refno'=>$refno]);
        }
    }

    public function beftn_sum_show(Request $request)
    {
        if ($request->ajax()) {
            $sumd = DB::select("select count(*) total_no_of_req,sum(nvl(approved_amount,0)) total_req_amount  
                            from mis.donation_expense_budget deb,mis.donation_req_correction dc
                            where deb.req_id = dc.req_id
                            and payment_mode = 'BEFTN'
                            and fi_doc_no = '$request->fidocno'");
            return response()->json($sumd);
        }
    }

    public function prepare_beftn_advice(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        if ($request->ajax()) {
            try{
                $result = DB::executeProcedure('mis.pro_donation_beftn_process',['fdno'=>$request->docno,'ban'=>$request->acno,'bsn'=>$request->shno]);
            }
            catch(Oci8Exception $e){
                $result=$e->getMessage();
            }
            $refno = DB::SELECT("SELECT DISTINCT deb.SUMM_ID,deb.REF_NO
                                    FROM MIS.DONATION_EXPENSE_BUDGET deb JOIN MIS.DONATION_REQ_CORRECTION drc
                                    ON deb.REQ_ID = drc.REQ_ID
                                    AND drc.PAYMENT_MODE = 'BEFTN'
                                    AND deb.REF_NO IS NOT NULL
                                    AND deb.BANK_ACCOUNT_NO IS NOT NULL
                                    ORDER BY deb.SUMM_ID DESC,deb.REF_NO DESC");
            return response()->json(['result'=>$result, 'refno'=>$refno]);
        }
    }

    public function print_beftn_advice(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $ba_val =  DB::select("
                       select  distinct print_ba from mis.donation_expense_budget 
                      where req_id in ( select req_id from mis.donation_process_beftn)");

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
                        from mis.donation_expense_budget deb,mis.donation_process_beftn dp,mis.donation_req_correction dc
                        where deb.req_id = dp.req_id
                        and dp.req_id = dc.req_id
                        and dc.payment_mode = 'BEFTN'
                        and print_ba is  null
                        group by ref_no,summ_id,cost_center_id)md,(select distinct cost_center_id,company_code,company_name
                        from mis.donation_cost_center
                        where budget_type = 'DONATION') cc
                        where md.cost_center_id = cc.cost_center_id");

            $count_payee = DB::select("select * from
                    (
                    select reqid,summ_id,to_char(sysdate, 'Month DD, YYYY') cd,ref_no,sl,upper(in_favour_of) in_favour_of,amount,total_amount,cost_center_id
                    from
                    (select summ_id,ref_no,sl,in_favour_of,approved_amount amount ,cost_center_id,dp.req_id reqid
                    from mis.donation_expense_budget deb,mis.donation_process_beftn dp,mis.donation_req_correction dc
                    where deb.req_id = dp.req_id
                    and dp.req_id = dc.req_id
                    and dc.payment_mode = 'BEFTN'
                    and bank_account_no = '$short->acno'
                    and print_pl is null),(select sum(nvl(approved_amount,0)) total_amount
                    from mis.donation_process_beftn dp,mis.donation_req_correction dc
                    where dp.req_id = dc.req_id and dc.payment_mode = 'BEFTN')                                               
                    order by sl
                    )md,
                    (select distinct cost_center_id,company_code,company_name
                    from mis.donation_cost_center          
                    where budget_type = 'DONATION') cc
                    where md.cost_center_id = cc.cost_center_id");

            $data = ['rs_data' => $result,'ba_val' => $ba_val, 'nos' => count($count_payee) ];

            if($ba_val[0]->print_ba=='1'){
                $pdf = \PDF::loadView('donation/bank_beftn_advice', $data);
                return $pdf->setPaper('a4','portrait')->stream('BEFTN Advice.pdf');
            }else{
                DB::executeProcedure('mis.pro_print_view_beftn_advice');
                if (file_exists(storage_path('/donation/BEFTN Advice.pdf'))) {
                    unlink(storage_path('donation/BEFTN Advice.pdf'));
                }
                $pdf = \PDF::loadView('donation/bank_beftn_advice', $data)->save(storage_path('donation/BEFTN Advice.pdf'));
                return $pdf->setPaper('a4','portrait')->stream('BEFTN Advice.pdf');
            }
        }
        catch(Oci8Exception $e){
            $result=$e->getMessage();
        }
        return response()->json($result);
    }

    public function print_beftn_payee(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $pa_val =  DB::select("
                    select  distinct print_pl from mis.donation_expense_budget 
                    where req_id in(select req_id from mis.donation_process_beftn)   
                    ");
//        dd($pa_val);

        $short = json_decode($request->bank);
//        dd($short);

        try{
            $result = DB::select("
                    
                select * from
                (
                select reqid,summ_id,to_char(sysdate, 'Month DD, YYYY') cd,ref_no,sl,upper(in_favour_of) in_favour_of,amount,total_amount,cost_center_id,
                bankaccno,bankname, bankbranchname, bankroutingnum, 
                beneficiaryname
                from
                (select summ_id,ref_no,deb.sl,in_favour_of,approved_amount amount ,cost_center_id,dp.req_id reqid,
                mas.bank_account_no bankaccno,mas.bank_name bankname,mas.bank_branch_name bankbranchname,mas.routing_number bankroutingnum, 
                mas.beneficiary_name beneficiaryname
                from mis.donation_expense_budget deb,mis.donation_process_beftn dp,mis.donation_req_correction dc,mis.donation_beftn_master mas
                where deb.req_id = dp.req_id
                and dp.req_id = dc.req_id
                and mas.territory_code = dc.terr_id
                and mas.beneficiary_id = dc.doctor_id
                and dc.payment_mode = 'BEFTN'
                and deb.bank_account_no = '$short->acno'
                and print_pl is null),(select sum(nvl(approved_amount,0)) total_amount
                from mis.donation_process_beftn dp,mis.donation_req_correction dc
                where dp.req_id = dc.req_id and dc.payment_mode = 'BEFTN')                                               
                order by sl
                )md,
                (select distinct cost_center_id,company_code,company_name
                from mis.donation_cost_center          
                where budget_type = 'DONATION') cc
                where md.cost_center_id = cc.cost_center_id");

//            dd($result);

                $dataArray = '';
                $totalVal = '';
                if(count($result)>0){
                    foreach($result as $value){
                        $dataArray = $dataArray."<tr><td>".$value->sl."</td><td>".$value->beneficiaryname."</td><td>".$value->bankaccno."</td><td>".$value->bankname."</td><td>".$value->bankbranchname."</td><td>".$value->bankroutingnum."</td><td style='text-align:right'>".number_format($value->amount)."</td></tr>";
                    }
                    
                    $totalVal = number_format($value->total_amount);
                }
            $data = ['rs_data' => $result,'pa_val'=>$pa_val,'acno'=>$short->acno,'bank_name'=>$short->fn,'branch_name'=>$short->bn,'dataArray'=>$dataArray,'totalVal'=>$totalVal];
//            dd($data);
            if($pa_val[0]->print_pl=='1'){
                $pdf = \PDF::loadView('donation/beftn_payee_list', $data);
                return $pdf->stream('beftn_payee_list.pdf');
            }
            else{
                DB::executeProcedure('mis.pro_print_view_beftn_payee');
                if (file_exists(storage_path('/donation/beftn_payee_list.pdf'))) {
                    unlink(storage_path('donation/beftn_payee_list.pdf'));
                }
                if (file_exists(storage_path('/donation/beftn_payee_list.xls'))) {
                    unlink(storage_path('donation/beftn_payee_list.xls'));
                }
                \Excel::create('beftn_payee_list', function ($excel) use ($data) {
                    $excel->sheet('Summary Data', function ($sheet) use ($data) {
                        $sheet->loadView('donation.excel_layout.beftn_payee_list_excel', $data);
                        $sheet->setColumnFormat(
                            array( 'C' => '0')
                        );
                        $sheet->protect('incepta_accounts');
                    });
                })->store('xls', storage_path('donation/'));

//                 $pdf = \PDF::loadView('donation/beftn_payee_list', $data);
               $pdf = \PDF::loadView('donation/beftn_payee_list', $data)->save(storage_path('donation/beftn_payee_list.pdf'));
                return $pdf->setPaper('a4','portrait')->stream('beftn_payee_list.pdf');
            }
        }
        catch(Oci8Exception $e){
            $result=$e->getMessage();
        }
        return response()->json($result);
    }

    public function send_mail_beftn(Request $request){
        $mail_val=  DB::select("
                  select  distinct send_mail from mis.donation_expense_budget 
                    where req_id in(select req_id from mis.donation_process_beftn)  
                    ");
        $sum_id=  DB::select("
                    select distinct summ_id,ref_no
                    from mis.donation_expense_budget deb,mis.donation_process_beftn dp
                    where deb.req_id = dp.req_id 
                    ");
        $summary_id = $sum_id[0]->summ_id;

        if($mail_val[0]->send_mail=='1'){
            return response()->json(['success' => 'true']);
        }
        else{
            $to_mail = $request->embank;
            $data_mail=[];
            Mail::send(['html' => 'donation.BEFTN_mail'], $data_mail,
                function ($message) use($to_mail,$summary_id) {
                    $message->to(explode(',',$to_mail));
                    $message->subject("BEFTN Advice Summary Id - ". $summary_id );
                    $message->from('mis@inceptapharma.com','MIS');
                    $message->attach(storage_path('/donation/beftn_payee_list.xls'));
                });
            DB::update(" 
               update mis.donation_expense_budget 
               set send_mail=1 
               where req_id in(select req_id from mis.donation_process_beftn)");
        }
    }
    public function print_beftn_advice_super(Request $request)
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
                    and dc.payment_mode = 'BEFTN'
                    and ref_no = '$request->ref_no'
                    group by ref_no,summ_id,cost_center_id)md,(select distinct cost_center_id,company_code,company_name
                    from mis.donation_cost_center
                    where budget_type = 'DONATION') cc
                    where md.cost_center_id = cc.cost_center_id");

            $count_payee = DB::select("
                select * from
                (select reqid,summ_id,to_char(sysdate, 'Month DD, YYYY') cd,ref_no,sl,upper(in_favour_of) in_favour_of,amount,total_amount,cost_center_id
                from
                (select summ_id,ref_no,sl,in_favour_of,approved_amount amount ,cost_center_id,dc.req_id reqid 
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where deb.req_id = dc.req_id
                and dc.payment_mode = 'BEFTN'
                and ref_no = '$request->ref_no'
                order by sl) ,
                (select sum(nvl(approved_amount,0)) total_amount
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where ref_no = '$request->ref_no' and deb.req_id = dc.req_id and dc.payment_mode = 'BEFTN')                                               
                order by sl)md,
                (select distinct cost_center_id,company_code,company_name
                from mis.donation_cost_center
                where budget_type = 'DONATION') cc
                where md.cost_center_id = cc.cost_center_id");
            
            $data = ['rs_data' => $result, 'nos'=>count($count_payee)];

            $pdf = \PDF::loadView('donation/bank_beftn_advice_super', $data);

            return $pdf->stream('Bank BEFTN Advice.pdf');
        }
        catch(Oci8Exception $e){
            $result=$e->getMessage();
        }
        return response()->json($result);
    }

    public function print_beftn_payee_super(Request $request)
    {
        ini_set('max_execution_time', 0);

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $short = json_decode($request->bank);

        try{
            $result = DB::select("
                select * from
                (select reqid,summ_id,to_char(sysdate, 'Month DD, YYYY') cd,ref_no,sl,upper(in_favour_of) in_favour_of,amount,total_amount,cost_center_id
                from
                (select summ_id,ref_no,sl,in_favour_of,approved_amount amount ,cost_center_id,dc.req_id reqid 
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where deb.req_id = dc.req_id
                and dc.payment_mode = 'BEFTN'
                and ref_no = '$request->ref_no'
                order by sl) ,
                (select sum(nvl(approved_amount,0)) total_amount
                from mis.donation_expense_budget deb,mis.donation_req_correction dc
                where ref_no = '$request->ref_no' and deb.req_id = dc.req_id and dc.payment_mode = 'BEFTN')                                               
                order by sl)md,
                (select distinct cost_center_id,company_code,company_name
                from mis.donation_cost_center
                where budget_type = 'DONATION') cc
                where md.cost_center_id = cc.cost_center_id");

            for ($i=0;$i<count($result);$i++){
                $req_id = $result[$i]->reqid;
                $qrYRes = DB::SELECT("select mas.bank_account_no bankaccno,mas.bank_name bankname,mas.bank_branch_name bankbranchname,mas.routing_number bankroutingnum, 
                                    mas.beneficiary_name beneficiaryname 
                                    from mis.donation_req_correction dc,mis.donation_beftn_master mas
                                    where dc.req_id = '$req_id'
                                    and dc.payment_mode = 'BEFTN'
                                    and mas.territory_code = dc.terr_id
                                    and mas.beneficiary_id = dc.doctor_id");

                if(count($qrYRes) > 0){
                    $result[$i]->bankaccno = $qrYRes[0]->bankaccno;
                    $result[$i]->bankname= $qrYRes[0]->bankname;
                    $result[$i]->bankbranchname= $qrYRes[0]->bankbranchname;
                    $result[$i]->bankroutingnum= $qrYRes[0]->bankroutingnum;
                    $result[$i]->beneficiaryname= $qrYRes[0]->beneficiaryname;
                }else{
                    $result[$i]->bankaccno = '';
                    $result[$i]->bankname= '';
                    $result[$i]->bankbranchname= '';
                    $result[$i]->bankroutingnum= '';
                    $result[$i]->beneficiaryname= '';
                }
            }

            $data = ['rs_data' => $result];

            $pdf = \PDF::loadView('donation/beftn_payee_list_super', $data);

            return $pdf->stream('BEFTN payee list.pdf');
        }
        catch(Oci8Exception $e){
            $result=$e->getMessage();
        }
        return response()->json($result);
    }
}
