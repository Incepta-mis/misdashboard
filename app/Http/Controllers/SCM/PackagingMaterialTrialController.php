<?php

namespace App\Http\Controllers\SCM;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class PackagingMaterialTrialController extends Controller
{
    public function index()
    {
        $rs_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        $rnd_email = DB::select("select distinct emp_email from mis.scm_factory_personnel_email");
        $rcm_email = DB::select("select emp_id,emp_name,emp_email from mis.SCM_TRIAL_RECOMMENDED where remarks = 'Recommender'");
        $ref_no = DB::select("
            select 'Reference: PACK/'|| sl_no || '/' || to_char(sysdate,'RRRR') reference
            from(
                select max(to_number(substr(substr(trial_ref_no,instr(trial_ref_no,'/')+1),1,instr(substr(trial_ref_no,instr(trial_ref_no,'/')+1),'/')-1)))+1 sl_no
                from mis.scm_trial_req
            )
        ");
        return view('scm_portal/Packaging_Material/pack_trial_form',
            ['cmp_data' => $rs_data, 'ref_no' => $ref_no,'rnd_email'=>$rnd_email,'rcm_email' => $rcm_email]);
    }

    public function getItemDescription(Request $request){
        $item = $request->term['term'];

        if ($item) {
            $mat = DB::select("
                select distinct item_desc
                from mis.scm_trial_req
                where upper(item_desc) like '%" . strtoupper($item) . "%'
                order by item_desc
            ");
            return response()->json($mat);
        }
    }

    public function getLocalSupplierName(Request $request){
        $supplier = $request->term['term'];

        if ($supplier) {
            $mat = DB::select("                
                
                select distinct supplier_name
                from mis.scm_trial_req
                where  upper(supplier_name) like '%" . strtoupper($supplier) . "%'
                union
                select distinct supplier_name
                from mis.scm_local_supplier
                where  upper(supplier_name) like '%" . strtoupper($supplier) . "%'                
                order by supplier_name
            ");
            return response()->json($mat);
        }
    }

    public function saveScmTrialReq(Request $request){
        $frmdata = $request->input();
        //return response()->json($frmdata);

        try {

            $fileNameToStore = '';
            if ($request->hasFile('file_source')) {
                $files = $request->file('file_source');
                $filenameWithExt = $files->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $files->getClientOriginalExtension();
                $fileNameToStore = $filename . '.' . $extension;
                $files->move(public_path() . '/SCM/TrialReq', $files->getClientOriginalName());
            }

            $uid = Auth::user()->user_id;
            $lId = DB::select("select max(to_number(substr(substr(trial_ref_no,instr(trial_ref_no,'/')+1),1,instr(substr(trial_ref_no,instr(trial_ref_no,'/')+1),'/')-1)))+1 line_id from mis.scm_trial_req");
            $curr_year = date("Y");
            $ref_no = 'Reference: PACK/'.$lId[0]->line_id.'/'.$curr_year;

            $frmdata = $request->input();

            if(!empty($frmdata['cfp'])){
                $product_name = $frmdata['cfp'];
            }else{
                $product_name = '';
            }

            if(!empty($frmdata['ccf_status'])){
                $ccf_status = $frmdata['ccf_status'];
            }else{
                $ccf_status = '';
            }



            $data = [
                'line_id' => $lId[0]->line_id ,
                'plant_id' => $frmdata['cmp'] ,
                'trial_ref_no' => $ref_no,
                'product_name' => $product_name ,
                'item_desc' => $frmdata['item_desc'] ,
                'qty' => $frmdata['qty'] ,
                'uom' => $frmdata['uom'] ,
                'supplier_name' => $frmdata['supplier'] ,
                'concern_product' => $frmdata['concern_product'] ,
                'scm_remarks'    => $frmdata['scm_remarks'] ,
                'qua_file'       => $fileNameToStore,
                'rcm_emp_id'     => $frmdata['recommend_emp_id'] ,
                'test_request_for'     => $frmdata['test_request_for'] ,
                'packaging_material_rtef_no'     => $ref_no ,
                'ccf_status'     => $ccf_status,
                'change_control_form'     => $frmdata['change_control_form'] ,
                'ccf_ref_no'     => $frmdata['ccf_ref_no'] ,
                'attached_document'     => $frmdata['attached_document'] ,
                'create_user'    => $uid,
                'material_type'    => $frmdata['mat_type']
            ];

            $rs = DB::table('mis.scm_trial_req')->insert($data);

            for ($i = 0; $i < count($frmdata['rnd_email']); $i++) {
                $concern_email = [
                    'ref_no' => $frmdata['ref_no'] ,
                    'rnd_email' => $frmdata['rnd_email'][$i],
                    'create_user'    => $uid
                ];
                DB::table('mis.scm_trial_concerned')->insert($concern_email);
            }

            $rcmEmp_id =  $frmdata['recommend_emp_id'] ;

            $rcm_email = DB::select("select emp_name,emp_email from mis.scm_trial_recommended where emp_id = '$rcmEmp_id'");
            $applicant_emails = DB::select("select emp_name,emp_email from mis.scm_trial_recommended where emp_id = '$uid' ");


            if($rs){

                $app_link = array(
                    'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/scm_portal/recommendApproval/' .  $lId[0]->line_id,
                    'name' => $applicant_emails[0]->emp_name,

                    'ref_no' => $ref_no,
                    'product_name' => $product_name ,
                    'item_desc' => $frmdata['item_desc'] ,
                    'qty' => $frmdata['qty'] ,
                    'uom' => $frmdata['uom'] ,
                    'supplier_name' => $frmdata['supplier'] ,
                    'concern_product' => $frmdata['concern_product'] ,
                    'scm_remarks'    => $frmdata['scm_remarks'] ,

                    'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/scm_portal/recommendApproval/' . $lId[0]->line_id
                );

                Mail::send(['html' => 'scm_portal.scm_trial_email_body.trial_recommend_email'], $app_link, function ($message) use ($rcm_email, $applicant_emails) {
                             $message->to($rcm_email[0]->emp_email, $rcm_email[0]->emp_name)
//                             $message->to('masroor@inceptapharma.com', 'Masroor')
                                 ->subject('Request for Trial Recommendation');
                             $message->from($applicant_emails[0]->emp_email, $applicant_emails[0]->emp_name);
                });

                return redirect('scm_portal/scm_pac_req')->with('status', "Save successfully with reference no: \" $ref_no \" ");
            }
            else{
                return redirect('scm_portal/scm_pac_req')->with('status', "operation failed");
            }


        } catch (Oci8Exception $e) {
            Log::info("Error : Packaging Material Controller - saveScmTrialReq");
            Log::info($e->getMessage());
            return redirect('scm_portal/scm_pac_req')->with('failed', "operation failed");
        }
    }

    public function trialRecommendedPage($lineid){

        $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$lineid]);
        return view('scm_portal/trail_recommended',['applicantData' => $trialData]);
    }

    public function trialRecommendedApproved(Request $request){

        if($request->ajax()){

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $auth_email = Auth::user()->email;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $frm_mail = DB::select("select emp_email from mis.scm_trial_recommended where emp_id = ?", [$uid]);
            $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$request->line_id]);
            $concernedPerson = DB::select("select rnd_email from mis.scm_trial_concerned where ref_no = ? ", [$trialData[0]->trial_ref_no]);
            $requestPerson = DB::select("select emp_name,emp_email from mis.scm_trial_recommended where emp_id = ? ", [$trialData[0]->create_user]);
            $ref_no = $trialData[0]->trial_ref_no ;





            // mail for concerned person
            $app_link = array(
                'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/scm_portal/concernedApproval/' .  "$request->line_id",
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/scm_portal/concernedApproval/' . "$request->line_id",
                'name' => $requestPerson[0]->emp_name,

                'ref_no' => $ref_no,
                'product_name' =>$trialData[0]->product_name,
                'item_desc' =>$trialData[0]->item_desc ,
                'qty' => $trialData[0]->qty ,
                'uom' => $trialData[0]->uom,
                'supplier_name' => $trialData[0]->supplier_name ,
                'concern_product' => $trialData[0]->concern_product ,
                'scm_remarks'    => $trialData[0]->scm_remarks ,


            );


            $concernedPersonEmails = array();
            foreach($concernedPerson as $username) {
                $concernedPersonEmails[] = $username->rnd_email;
            }



           

            

            if($request->accept_val == '1'){
               DB::table('mis.scm_trial_req')
                    ->where('line_id',$request->line_id )
                    ->update(['rcm_app_date'=>$sys_time,'UPDATE_USER' => $uid]);


                //again trialData Called because rcm_app_date needed.    
                $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$request->line_id]);

                Mail::send(['html' => 'scm_portal.scm_trial_email_body.trial_concerned_email'], $app_link, function ($message) use ($concernedPersonEmails, $ref_no, $requestPerson) {
                    $message->to($concernedPersonEmails, $concernedPersonEmails)
//                             $message->to('masroor@inceptapharma.com', 'Masroor')
                        ->subject("$ref_no, Request for Trial form Received");
                    $message->from($requestPerson[0]->emp_email, $requestPerson[0]->emp_name);
                });



                //Feedback mail to Applicant
                $pdf = \PDF::loadView('scm_portal.scm_trial_pdf.req_trial_form_pdf', compact(''), compact('trialData'))->setPaper('a4', 'portrait');
                Mail::send(['html'=>'scm_portal.scm_trial_email_body.sample_blank'], $requestPerson, function($message) use ($requestPerson,$pdf,$auth_name,$ref_no, $auth_email){
                    $message->from($auth_email,$auth_name);
                    $message->to($requestPerson[0]->emp_email, $requestPerson[0]->emp_name);
                    $message->subject("copy of $ref_no, Request for Trial form Received");
                    //Attach PDF doc
                    $message->attachData($pdf->output(),"$ref_no.pdf");
                    // $message->setBody("$ref_no, Your Machine Trial Request form successfully send to RND.");
                });

                // Mail::send([], [], $requestPerson, function($message) use ($requestPerson,$pdf,$auth_name,$ref_no, $auth_email){
                //     $message->from($auth_email,$auth_name);
                //     $message->to($requestPerson[0]->emp_email, $requestPerson[0]->emp_name);
                //     $message->subject("copy of $ref_no, Request for Trial form Received");
                //     //Attach PDF doc
                //     $message->attachData($pdf->output(),"$ref_no.pdf");
                //     $message->setBody("$ref_no, Your Machine Trial Request form successfully send to RND.");
                // });

                // // mail for request notification
                // Mail::send([], [], function ($message) use($ref_no,$requestPerson,$frm_mail,$auth_name,$trialData ) {
                //     $message->to($requestPerson[0]->emp_email, $requestPerson[0]->emp_email)
                //         ->subject("$ref_no");
                //     $message->from($frm_mail[0]->emp_email, $auth_name);
                //     $message->setBody("$ref_no, Recommended Successfully.");
                // });


               return response()->json(['success'=>'Successfully ! Accepted by User.']);
            }
        }
    }

    public function trialConcernedApprovalPage($lineid){
        $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$lineid]);
        return view('scm_portal/trial_concernedApprovalPage',['applicantData' => $trialData]);
    }

    public function trialFormPdf(Request $request){

        $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$request->line_id]);

        $pdf = \PDF::loadView('scm_portal.scm_trial_pdf.req_trial_form_pdf', compact(''),
            compact('trialData')
        )->setPaper('a4', 'portrait');
        $refName = $trialData[0]->trial_ref_no;
        return $pdf->stream($refName.'.pdf');
        // return $pdf->stream('Request_Form_For_Packaging_Material.pdf');
    }

    public function trialRndConcernedApproved(Request $request){
        if($request->ajax()){

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $auth_email = Auth::user()->email;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

            $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$request->line_id]);
            $requestPerson = DB::select("select emp_name,emp_email from mis.scm_trial_recommended where emp_id = ? ", [$trialData[0]->create_user]);
            $ref_no = $trialData[0]->trial_ref_no;


            if($request->accept_val == '1'){
                DB::table('mis.scm_trial_req')
                    ->where('line_id',$request->line_id )
                    ->update(['rnd_con_date'=>$sys_time,'rnd_emp_id' => $uid]);

                // mail for request notification
                Mail::send([], [], function ($message) use($ref_no,$requestPerson,$auth_email,$auth_name,$trialData ) {
                    $message->to($requestPerson[0]->emp_email, $requestPerson[0]->emp_email)
                        ->subject("$ref_no");
                    $message->from($auth_email, $auth_name);
                    $message->setBody("$ref_no, Received Successfully.");
                });


                return response()->json(['success'=>'Successfully ! Accepted by User.']);
            }
        }
    }

    public function attachmenShareIndexPage(){
        $scm_email = DB::select(" select distinct emp_email from mis.scm_trial_recommended order by emp_email ");
        $ref_no = DB::select(" select distinct trial_ref_no from mis.scm_trial_req order by trial_ref_no desc ");
        return view('scm_portal/Packaging_Material/pack_trial_attachment',compact('ref_no','scm_email'));
    }

    public function getConcernedList(Request $request){
        $resp_data = DB::select(" select * from mis.scm_trial_req where trial_ref_no = '$request->ref_no' ");
        return response()->json($resp_data);
    }

    public function concernedAccept(Request $request)
    {

        if ($request->st == 'accept') {

            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $auth_email = Auth::user()->email;

            $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$request->line_id]);
            $requestPerson = DB::select("select emp_name,emp_email from mis.scm_trial_recommended where emp_id = ? ", [$trialData[0]->create_user]);
            $ref_no = $trialData[0]->trial_ref_no;

            // mail for request notification
            Mail::send([], [], function ($message) use($ref_no,$requestPerson,$auth_email,$auth_name,$trialData ) {
                $message->to($requestPerson[0]->emp_email, $requestPerson[0]->emp_email)
                    ->subject("$ref_no");
                $message->from($auth_email, $auth_name);
                $message->setBody("$ref_no, Received Successfully.");
            });


            $suc = DB::table('mis.scm_trial_req')->where('line_id', $request->line_id)
                ->update([
                    'rnd_emp_id' => $uid,
                    'rnd_con_date' => $sys_time,
                    'update_user' => $uid
            ]);

            $rs= DB::table('mis.scm_trial_req')->where('line_id', $request->line_id)->get();
//            return response()->json(['success' => 'Record Save Successfully','rs'=>$rs]);
            if ($suc) {
                return response()->json(['success' => 'Record Save Successfully','rs'=>$rs]);
            }
        }


    }


    public function saveSCMShareAttachment(Request $request){

        try {

            $fileNameToStore = '';
            $sendFiles = '';
            if ($request->hasFile('final_pdf')) {
                $files = $request->file('final_pdf');
                $filenameWithExt = $files->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $files->getClientOriginalExtension();
                $fileNameToStore = $filename . '.' . $extension;
                $sendFiles =  $files->move(public_path() . '/SCM/TrialReq/FinalTrialFile', $files->getClientOriginalName());

            }

            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $auth_email = Auth::user()->email;
            $lId = DB::select("select  distinct to_number(substr(substr('$request->ref_no',instr('$request->ref_no','/')+1),1,instr(substr('$request->ref_no',instr('$request->ref_no','/')+1),'/')-1)) line_id from dual");
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');


            $data = [
                'line_id' => $lId[0]->line_id ,
                'trial_ref_no' => $request->ref_no,
                'final_trila_file' => $fileNameToStore,
                'remarks'     => $request->remarks,
                'create_user'    => $uid
            ];

            $rs = DB::table('mis.scm_trial_final')->insert($data);

            $m_emails = array();

            for ($i = 0; $i < count($request->scm_email); $i++) {
                $scms_email = [
                    'ref_no' => $request->ref_no,
                    'scm_email' => $request->scm_email[$i],
                    'remarks'     => $request->remarks,
                    'create_date'    => $sys_time,
                    'create_user'    => $uid
                ];
                $m_emails[] = $request->scm_email[$i];
                DB::table('mis.scm_trial_scm_email')->insert($scms_email);
            }

            $ref_no = $request->ref_no;

            $trialData = DB::select("select * from mis.scm_trial_req where trial_ref_no = ? ", [$ref_no]);

            if($rs){

                // mail for concerned person
                $app_link = array(
                    'name' => $auth_name,
                    'ref_no' => $ref_no,
                    'product_name' =>$trialData[0]->product_name,
                    'item_desc' =>$trialData[0]->item_desc ,
                    'qty' => $trialData[0]->qty ,
                    'uom' => $trialData[0]->uom,
                    'supplier_name' => $trialData[0]->supplier_name ,
                    'concern_product' => $trialData[0]->concern_product ,
                    'scm_remarks'    => $request->remarks,
                );

                Mail::send(['html' => 'scm_portal.scm_trial_email_body.trial_factory_attachment_email'], $app_link, function ($message)
                use ($ref_no,$m_emails, $sendFiles, $auth_name, $auth_email) {
                    $message->to($m_emails, $m_emails)
//                     $message->to('masroor@inceptapharma.com', 'Masroor')
                        ->subject("$ref_no, Request for Trial Report");
                    $message->from($auth_email, $auth_name);
                    $message->attach($sendFiles);

                });

                return redirect('scm_portal/scm_att_share')->with('status', "Send successfully");
            }else{
                return redirect('scm_portal/scm_att_share')->with('failed', "Not successfully");
            }


        } catch (Oci8Exception $e) {
            Log::info("Error : Packaging Material Controller - saveSCMShareAttachment");
            Log::info($e->getMessage());
            return redirect('scm_portal/scm_att_share')->with('failed', "operation failed");
        }
    }

    public function machineReportIndex(){
        $cmp_data = DB::select("select plant,company_full_name ||' ('|| company_short_name ||')' company from mis.scm_company_info order by  company_full_name");
        $p_data = DB::select("select distinct  product_name from mis.scm_trial_req");
        return view('scm_portal/Packaging_Material/Reports/machineTrialStatement',compact('cmp_data','p_data'));
    }

    public function getAllTrialReference(Request $request){

        $resp_date = DB::select("
            select distinct trial_ref_no from mis.scm_trial_req where plant_id = '$request->plant' order by trial_ref_no desc
        ");
        return response()->json($resp_date);
    }

    public function getScmTrialStatement(Request $request){


        if($request->date1 && $request->p_name =='All'){
            $resp_data = DB::select("
            select distinct a.trial_ref_no,to_char(a.create_date,'DD-MON-RR') req_date,a.product_name,a.item_desc, a.supplier_name ,
            get_emp_name(a.create_user) scm_concern, a.scm_remarks, get_emp_name(a.rcm_emp_id) rcm_name,to_char(a.rcm_app_date,'DD-MON-RR') rcm_app_date , get_emp_name(a.rnd_emp_id) rnd_concern, b.FINAL_TRILA_FILE,
            to_char(a.rnd_con_date,'DD-MON-RR') sample_received ,to_char(b.create_date,'DD-MON-RR') rpt_date,b.REMARKS rnd_remarks
            from mis.scm_trial_req a , mis.scm_trial_final b
            where a.line_id = b.line_id(+)
            and a.trial_ref_no = decode('$request->ref_no','All',a.trial_ref_no,'$request->ref_no')            
            --and a.product_name = decode('$request->p_name','All',a.product_name,'$request->p_name')
            and to_date(to_char(a.create_date,'DD-MM-RRRR'),'DD/MM/RRRR') between to_date('$request->date1','DD/MM/RRRR') and to_date('$request->date2','DD/MM/RRRR')     ");
        }else if($request->date1 && $request->p_name !='All'){
            $resp_data = DB::select("
            select distinct a.trial_ref_no,to_char(a.create_date,'DD-MON-RR') req_date,a.product_name,a.item_desc, a.supplier_name ,
            get_emp_name(a.create_user) scm_concern, a.scm_remarks, get_emp_name(a.rcm_emp_id) rcm_name,to_char(a.rcm_app_date,'DD-MON-RR') rcm_app_date ,get_emp_name(a.rnd_emp_id) rnd_concern, b.FINAL_TRILA_FILE,
            to_char(a.rnd_con_date,'DD-MON-RR') sample_received ,to_char(b.create_date,'DD-MON-RR') rpt_date,b.REMARKS rnd_remarks
            from mis.scm_trial_req a , mis.scm_trial_final b
            where a.line_id = b.line_id(+)
            and a.trial_ref_no = decode('$request->ref_no','All',a.trial_ref_no,'$request->ref_no')            
            and a.product_name = decode('$request->p_name','All',a.product_name,'$request->p_name')
            and to_date(to_char(a.create_date,'DD-MM-RRRR'),'DD/MM/RRRR') between to_date('$request->date1','DD/MM/RRRR') and to_date('$request->date2','DD/MM/RRRR')     ");
        }else if($request->p_name !='All'){
            $resp_data = DB::select("
            select distinct a.trial_ref_no,to_char(a.create_date,'DD-MON-RR') req_date,a.product_name,a.item_desc, a.supplier_name ,
            get_emp_name(a.create_user) scm_concern, a.scm_remarks, get_emp_name(a.rcm_emp_id) rcm_name,to_char(a.rcm_app_date,'DD-MON-RR') rcm_app_date ,get_emp_name(a.rnd_emp_id) rnd_concern, b.FINAL_TRILA_FILE,
            to_char(a.rnd_con_date,'DD-MON-RR') sample_received ,to_char(b.create_date,'DD-MON-RR') rpt_date,b.REMARKS rnd_remarks
            from mis.scm_trial_req a , mis.scm_trial_final b
            where a.line_id = b.line_id(+)
            and a.trial_ref_no = decode('$request->ref_no','All',a.trial_ref_no,'$request->ref_no')            
            and a.product_name = decode('$request->p_name','All',a.product_name,'$request->p_name')
            ");
        }else{
            $resp_data = DB::select("
            select distinct a.trial_ref_no,to_char(a.create_date,'DD-MON-RR') req_date,a.product_name,a.item_desc, a.supplier_name ,
            get_emp_name(a.create_user) scm_concern, a.scm_remarks,get_emp_name(a.rcm_emp_id) rcm_name,to_char(a.rcm_app_date,'DD-MON-RR') rcm_app_date , get_emp_name(a.rnd_emp_id) rnd_concern, b.FINAL_TRILA_FILE,
            to_char(a.rnd_con_date,'DD-MON-RR') sample_received ,to_char(b.create_date,'DD-MON-RR') rpt_date,b.REMARKS rnd_remarks
            from mis.scm_trial_req a , mis.scm_trial_final b
            where a.line_id = b.line_id(+)
            and a.trial_ref_no = decode('$request->ref_no','All',a.trial_ref_no,'$request->ref_no')
           
            ");
        }

        return response()->json($resp_data);
    }


    public function sendSupplierInfo(Request $request){


        $ref_no = $request->referenceNO;
        $subject = $request->subject;
        $frm_email = $request->frm_email;
        $msg = $request->body_message;
        $supplierPersonEmails = array();

        foreach($request->to_email as $s_email) {
            $supplierPersonEmails[] = $s_email;
        }

        $uid = Auth::user()->user_id;
        $auth_name = Auth::user()->name;
        $auth_email = Auth::user()->email;

        $trialData = DB::select("select * from mis.scm_trial_req where trial_ref_no = ? ", [$ref_no]);
        $product_name = '';
        if(!empty($trialData[0]->product_name)){
            $product_name = $trialData[0]->product_name;
        }else{
            $product_name = '';
        }


            $app_link = array(
                'name' => $auth_name,
                'ref_no' => $ref_no,
                'product_name' =>$product_name,
                'item_desc' =>$trialData[0]->item_desc ,
                'qty' => $trialData[0]->qty ,
                'uom' => $trialData[0]->uom,
                'supplier_name' => $trialData[0]->supplier_name,
                'concern_product' => $trialData[0]->concern_product ,
                'msg'=>$msg
            );

            $finalFile = DB::select("select final_trila_file from mis.scm_trial_final where trial_ref_no = ? ", [$ref_no]);
            $sendFiles =  public_path() . '/SCM/TrialReq/FinalTrialFile/'.$finalFile[0]->final_trila_file;

            Mail::send(['html' => 'scm_portal.scm_trial_email_body.trial_supplier_email'], $app_link, function ($message)
            use ($ref_no,$supplierPersonEmails,$subject, $sendFiles, $auth_name, $auth_email) {
                $message->to($supplierPersonEmails, $supplierPersonEmails)
                    ->subject("$subject");
                $message->from($auth_email, $auth_name);
                $message->attach($sendFiles);

            });

    }




    // Packaging Trial Recommended
    public function packTrialRcmPageIndex(){

        return view('scm_portal.Packaging_Material.pack_trial_recommend');

    }

    public function getTrialPackRcmData(Request $request){
        $uid = Auth::user()->user_id;
        $rs = DB::select(" select * from mis.scm_trial_req where rcm_emp_id = '$uid' and rownum <= 100 order by trial_ref_no desc ");
        return response()->json($rs);
    }


    public function pacTrialrcmAccept(Request $request)
    {


        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $auth_name = Auth::user()->name;
            $auth_email = Auth::user()->email;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

            $frm_mail = DB::select("select emp_email from mis.scm_trial_recommended where emp_id = ?", [$uid]);
            $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$request->line_id]);
            $concernedPerson = DB::select("select rnd_email from mis.scm_trial_concerned where ref_no = ? ", [$trialData[0]->trial_ref_no]);
            $requestPerson = DB::select("select emp_name,emp_email from mis.scm_trial_recommended where emp_id = ? ", [$trialData[0]->create_user]);
            $ref_no = $trialData[0]->trial_ref_no ;

            

            // mail for concerned person
            $app_link = array(
                'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/scm_portal/concernedApproval/' .  "$request->line_id",
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/scm_portal/concernedApproval/' . "$request->line_id",
                'name' => $requestPerson[0]->emp_name,

                'ref_no' => $ref_no,
                'product_name' =>$trialData[0]->product_name,
                'item_desc' =>$trialData[0]->item_desc ,
                'qty' => $trialData[0]->qty ,
                'uom' => $trialData[0]->uom,
                'supplier_name' => $trialData[0]->supplier_name ,
                'concern_product' => $trialData[0]->concern_product ,
                'scm_remarks'    => $trialData[0]->scm_remarks ,


            );


            $concernedPersonEmails = array();
            foreach($concernedPerson as $username) {
                $concernedPersonEmails[] = $username->rnd_email;
            }



            $suc = DB::table('mis.scm_trial_req')
                ->where('line_id',$request->line_id)
                ->update(
                    array(
                        'rcm_app_date'=>$sys_time,
                        'rcm_emp_id'=>$uid
                    )
                );

            //again trialData Called because rcm_app_date needed.    
            $trialData = DB::select("select * from mis.scm_trial_req where line_id = ? ", [$request->line_id]);

            Mail::send(['html' => 'scm_portal.scm_trial_email_body.trial_concerned_email'], $app_link, function ($message) use ($concernedPersonEmails, $ref_no, $requestPerson) {
                $message->to($concernedPersonEmails, $concernedPersonEmails)
                // $message->to('masroor@inceptapharma.com', 'Masroor')
                    ->subject("$ref_no, Request for Trial Received");
                $message->from($requestPerson[0]->emp_email, $requestPerson[0]->emp_name);
            });


            //Feedback mail to Applicant
            $pdf = \PDF::loadView('scm_portal.scm_trial_pdf.req_trial_form_pdf', compact(''), compact('trialData'))->setPaper('a4', 'portrait');
            Mail::send(['html'=>'scm_portal.scm_trial_email_body.sample_blank'], $requestPerson, function($message) use ($requestPerson,$pdf,$auth_name,$ref_no, $auth_email){
                $message->from($auth_email,$auth_name);
                $message->to($requestPerson[0]->emp_email, $requestPerson[0]->emp_name);
                $message->subject("copy of $ref_no, Request for Trial form Received");
                //Attach PDF doc
                $message->attachData($pdf->output(),"$ref_no.pdf");
            });

        }




        if ($suc) {
            
            return response()->json(['success' => 'Record Save Successfully']);
        }

    }

}