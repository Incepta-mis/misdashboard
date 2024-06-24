<?php


namespace App\Http\Controllers\Travel;

use App\Http\Controllers\Controller;
use App\Model\Travel\TravelLocalAdvanceApproved;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TravelRecommendedController extends Controller
{
    public function localIndex()
    {
        $uid = Auth::user()->user_id;
        $emp_info = DB::select("
        
        select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        from hrms.emp_information@web_to_hrms
        where emp_id in (
        
        select emp_id from mis.travel_emp_master
        where sup_emp_id =  '$uid'
                        
        )
        and emp_id != '$uid'
        order by emp_id
        
        ");
        return view('travel.local.recommendedForm', compact('emp_info'));
    }

    /*public function InternationalIndex(){
        return view('travel.international.applicationForm', compact('employeeInfo', 'randomNumber'));
    }*/


    public function getTravelEmpList(Request $request)
    {
        $uid = Auth::user()->user_id;
        if ($request->status == 'NO') {

            if ($request->type == 'Adjustment') {
                $travelList = DB::select("
                    select *
                    from travel_local_advance_appr
                    where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                    and sup_id = '$uid' 
                    and status = 'Adjustment'
                    and sup_accept is null       
                ");
            } else {
                $travelList = DB::select("
                    select *
                    from travel_local_advance_appr
                    where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                    and sup_id = '$uid' 
                    and sup_accept is null       
                ");
            }

        } elseif ($request->status == 'YES') {

            if ($request->type == 'Adjustment') {
                $travelList = DB::select("
                select *
                from travel_local_advance_appr
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and sup_id = '$uid'
                and status = 'Adjustment'  
                and sup_accept = 'YES'
                ");
            } else {
                $travelList = DB::select("
                select *
                from travel_local_advance_appr
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and sup_id = '$uid'  
                and sup_accept = 'YES'
            ");

            }


        } else {


            if ($request->type == 'Adjustment') {
                $travelList = DB::select("
                select *
                from travel_local_advance_appr
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')  
                and sup_id = '$uid' 
                and status = 'Adjustment'
                and emp_id != '$uid'                            
                ");
            } else {
                $travelList = DB::select("
                select *
                from travel_local_advance_appr
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')  
                and sup_id = '$uid' 
                and emp_id != '$uid'
                and status is null
                                         
            ");
            }

        }
        return response()->json($travelList);
    }



    public function travelSupApproved(Request $request)
    {
        if ($request->st == 'accept') {

            $empId = $request->empID;
            $id = $request->id;

            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = TravelLocalAdvanceApproved::where('id', $request->id)
                ->update([
                    'SUP_ACCEPT' => 'YES',
                    'SUP_DATE' => $sys_time,
                    'UPDATE_USER' => $uid
                ]);

            if ($suc) {

                $frm_mail = DB::select("select emp_id,name emp_name,email,sup_emp_id,dept_head_emp_id from mis.travel_emp_master where emp_id = ?", [$empId]);
                $to_mail = '';

                if(!empty($frm_mail[0]->dept_head_emp_id)){
                    $to_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [$frm_mail[0]->dept_head_emp_id]);

                    $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/local/secondaryEmailApprovalLocal/'.$empId.'/'.$id,
                        'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/local/secondaryEmailApprovalLocal/'.$empId.'/'.$id,
                        'empName' =>$frm_mail[0]->emp_name );
                    if(!empty($frm_mail[0]->dept_head_emp_id )){

                        Mail::send(['text' => 'travel.emails.primary_mail'], $email_data, function ($message) use($to_mail,$frm_mail) {
                            $message->to($to_mail[0]->email, $to_mail[0]->email)
                                ->subject('Local Travel Approved Request');
                            $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
                        });
                    }
                }
                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }

    public function travelSupRejected(Request $request)
    {
        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = TravelLocalAdvanceApproved::where('id', $request->id)
                ->update([
                    'SUP_ACCEPT' => 'NO',
                    'SUP_DATE' => $sys_time,
                    'UPDATE_USER' => $uid
                ]);
            if ($suc) {
                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }

    public function primaryEmailApprovalLocal(Request $request){
        $rs = DB::select(" select * FROM MIS.TRAVEL_LOCAL_ADVANCE_APPR WHERE EMP_ID = ? AND ID = ?",[$request->empId,$request->id] );
        return view('travel.local.primaryEmailApproved', compact('rs'));
    }


    /* International Part */

    public function deptHead(Request $request)
    {
        $rs = DB::select(" select * FROM MIS.TRAVEL_INTL_REQ_APPR WHERE EMP_ID = ? AND DOCUMENT_NO = ?",[$request->empId,$request->documentNo] );
        return view('travel.international.deptHead', compact('rs'));
    }

    public function intlReqHO(Request $request){
        $rs = DB::select(" select id,document_no,plant_id,emp_id,emp_name,location,dept_accept,mis.get_travel_emp_name(dept_head_id) accept_name,
                    chairman_sir_accept,chairman_madam_accept
                    from mis.travel_intl_req_appr 
                    where emp_id = ? 
                    and document_no = ?",[$request->empId,$request->documentNo] );
        return view('travel.international.emailForm.ho.chairmanApprovedEmail', compact('rs'));
    }

    public function intlReqPlant(Request $request){
        $rs = DB::select(" select id,document_no,plant_id,emp_id,emp_name,location,dept_accept,mis.get_travel_emp_name(plant_head_id) accept_name,
                    plant_head_accept,chairman_sir_accept,chairman_madam_accept
                    from mis.travel_intl_req_appr 
                    where emp_id = ? 
                    and document_no = ?",[$request->empId,$request->documentNo] );
        return view('travel.international.emailForm.ho.chairmanApprovedEmail', compact('rs'));
    }

    public function intlReqFactory(Request $request){
        $rs = DB::select(" select id,document_no,plant_id,emp_id,emp_name,location,
                    dept_accept,mis.get_travel_emp_name(dept_head_id) accept_name,plant_head_accept,site_head_accept,
                    chairman_sir_accept,chairman_madam_accept
                    from mis.travel_intl_req_appr 
                    where emp_id = ? 
                    and document_no = ?",[$request->empId,$request->documentNo] );
        return view('travel.international.emailForm.dhamrai.siteHeadApprovedEmail', compact('rs'));
    }

    public function intlReqFactoryHead(Request $request){
        $rs = DB::select(" select id,document_no,plant_id,emp_id,emp_name,location,
                    dept_accept,mis.get_travel_emp_name(site_head_id) accept_name,plant_head_accept,site_head_accept,
                    chairman_sir_accept,chairman_madam_accept
                    from mis.travel_intl_req_appr 
                    where emp_id = ? 
                    and document_no = ?",[$request->empId,$request->documentNo] );
        return view('travel.international.emailForm.savar.plantHeadApprovedEmail', compact('rs'));
    }




}