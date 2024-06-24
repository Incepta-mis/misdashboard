<?php


namespace App\Http\Controllers\Travel;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Model\Travel\TravelIntlReqApproved;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use App\Model\Travel\TravelLocalAdvanceApproved;

class TravelApprovedByController extends Controller
{
    public function localIndex(){
        $uid = Auth::user()->user_id;
        $emp_info = DB::select("
        
        select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        from hrms.emp_information@web_to_hrms
        where emp_id in (
        
        select emp_id from mis.travel_emp_master
        where dept_head_emp_id =  '$uid'
                        
        )
        and emp_id != '$uid'
        order by emp_id
        
        ");
        return view('travel.local.approvedForm',compact('emp_info'));

    }

    public function getTravelEmpList(Request $request){
        $uid = Auth::user()->user_id;
        if($request->status == 'NO'){
            if ($request->type == 'Adjustment') {
                $travelList = DB::select("
                select apr.*, mis.GET_EMP_NAME(apr.sup_id) sup_name
                from travel_local_advance_appr apr
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_head_id = '$uid'
                and status = 'Adjustment'                 
                and dept_accept is null       
                ");
            }else {
                $travelList = DB::select("
                select apr.*, mis.GET_EMP_NAME(apr.sup_id) sup_name
                from travel_local_advance_appr apr
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_head_id = '$uid'                 
                and dept_accept is null       
                ");
            }

        }elseif ($request->status == 'YES'){
            if ($request->type == 'Adjustment') {
                $travelList = DB::select("
                    select apr.*, mis.GET_EMP_NAME(apr.sup_id) sup_name
                    from travel_local_advance_appr apr
                    where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                    and dept_head_id = '$uid'       
                    and status = 'Adjustment'           
                    and dept_accept = 'YES'
                ");
            }else{
                $travelList = DB::select("
                    select apr.*, mis.GET_EMP_NAME(apr.sup_id) sup_name
                    from travel_local_advance_appr apr
                    where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                    and dept_head_id = '$uid'                  
                    and dept_accept = 'YES'
            ");
            }
        }else{
            if ($request->type == 'Adjustment') {
                $travelList = DB::select("
                    select apr.*, mis.GET_EMP_NAME(apr.sup_id) sup_name
                    from travel_local_advance_appr apr
                    where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')  
                    and dept_head_id = '$uid'                
                    and emp_id != '$uid'
                    and status = 'Adjustment'                            
                ");
            }else{

                $travelList = DB::select("
                    select apr.*, mis.GET_EMP_NAME(apr.sup_id) sup_name
                    from travel_local_advance_appr apr
                    where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')  
                    and dept_head_id = '$uid'                
                    and emp_id != '$uid'     
                    and status is null                       
                ");
            }
        }
        return response()->json($travelList);
    }

    public function travelHeadApproved(Request $request){
        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = TravelLocalAdvanceApproved::where('id', $request->id)
                ->update([
                    'DEPT_ACCEPT' => 'YES',
                    'DEPT_DATE' => $sys_time,
                    'UPDATE_USER' => $uid
                ]);

            if($suc){
                return response()->json(['success' => 'Record Save Successfully']);
            }else{
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }

    public function travelHeadRejected(Request $request){
        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = TravelLocalAdvanceApproved::where('id', $request->id)
                ->update([
                    'DEPT_ACCEPT' => 'NO',
                    'DEPT_DATE' => $sys_time,
                    'UPDATE_USER' => $uid
                ]);
            if($suc){
                return response()->json(['success' => 'Record Save Successfully']);
            }else{
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }

    public function secondaryEmailApprovalLocal(Request $request){
        $rs = DB::select(" select * FROM MIS.TRAVEL_LOCAL_ADVANCE_APPR WHERE EMP_ID = ? AND ID = ?",[$request->empId,$request->id] );
        return view('travel.local.secondaryEmailApproved', compact('rs'));
    }


    /** Internation Travel */


   public function IntlIndex()
    {
        $uid = Auth::user()->user_id;
        $emp_info = DB::select("
        
        select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
        from hrms.emp_information@web_to_hrms
        where emp_id in (
        
        select emp_id from mis.travel_emp_master
        where dept_head_emp_id =  '$uid'
                        
        )
        and emp_id != '$uid'
        order by emp_id
        
        ");
        return view('travel.international.approvedForm', compact('emp_info'));
    }

    public function intlGetTraveler(Request $request)
    {

        $uid = Auth::user()->user_id;

        if ($request->status == 'All') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr 
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and emp_id in (
        
                select emp_id from mis.travel_emp_master
                where dept_head_emp_id =  '$uid'
                                        
                )"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'YES') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr 
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES' 
                and emp_id in (
        
                select emp_id from mis.travel_emp_master
                where dept_head_emp_id =  '$uid'
                                        
                )"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'NO') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr 
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept is null 
                and emp_id in (
        
                select emp_id from mis.travel_emp_master
                where dept_head_emp_id =  '$uid'                                        
                )"
            );
            return response()->json($travelList);
        }
    }

    public function intlTravelHeadApproved(Request $request)
    {

        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = TravelIntlReqApproved::where('id', $request->id)
                ->update([
                    'DEPT_ACCEPT' => 'YES',
                    'DEPT_DATE' => $sys_time,
                    'UPDATE_USER' => $uid
                ]);


            if ($suc) {

                $employeeApprovedData = DB::select('select * from mis.travel_intl_req_appr where id = ?', [$request->id]);

                $documentNo = $employeeApprovedData[0]->document_no;
                $empName = $employeeApprovedData[0]->emp_name;
                $empId = $employeeApprovedData[0]->emp_id;

                $empMasterData = DB::select('select * from mis.travel_emp_master where emp_id = ?', [$empId]);
                $siteHeadData = DB::select("select plant_id,emp_id, name, email from mis.travel_emp_master where emp_id = ? ", [$empMasterData[0]->site_head_id]);
                $plantHeadData = DB::select("select plant_id,emp_id, name, email from mis.travel_emp_master where emp_id = ? ", [$empMasterData[0]->plant_head_id]);

                //for Head Office
                if ($empMasterData[0]->plant_id == '1000' || $empMasterData[0]->plant_id == '5000') {

                    $email_data = array(
                        'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqHO/' . $empId . '/' . $documentNo,
                        'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqHO/' . $empId . '/' . $documentNo,
                        'empName' => $empName
                    );

                    if (!empty($empMasterData[0]->email)) {

                        //for sir
                        Mail::send(['text' => 'travel.emails.intl.chairman'], $email_data, function ($message) use ($empMasterData) {
                            // $message->to('masroor@inceptapharma.com', 'Masroor Hasan')
                            $message->to('fahim-ahmed@inceptapharma.com', 'Fahim Ahmed')                            
                                ->subject('Request for International Travel Approval');
                            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
                        });

                        //for madam
                        Mail::send(['text' => 'travel.emails.intl.chairman'], $email_data, function ($message) use ($empMasterData) {
                            $message->to('fahim-ahmed@inceptapharma.com', 'Fahim Ahmed') 
                                ->subject('Request for International Travel Approval');
                            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
                        });
                    }
                } //for Dhamrai
                elseif (
                    $empMasterData[0]->plant_id == '1300' ||
                    $empMasterData[0]->plant_id == '1400' ||
                    $empMasterData[0]->plant_id == '2200' ||
                    $empMasterData[0]->plant_id == '4100' ||
                    $empMasterData[0]->plant_id == '5100' 
                ) {
                    $email_data = array(
                        'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqFactory/' . $empId . '/' . $documentNo,
                        'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqFactory/' . $empId . '/' . $documentNo,
                        'empName' => $empName
                    );

                    if (!empty($empMasterData[0]->email)) {

                        //for Site Head
                        Mail::send(['text' => 'travel.emails.intl.site_head'], $email_data, function ($message) use ($siteHeadData, $empMasterData) {
                            $message->to($siteHeadData[0]->email, $siteHeadData[0]->name)
                                ->subject('Request for International Travel recommendation');
                            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
                        });
                    }
                }
                // Savar Plant
                elseif (
                    $empMasterData[0]->plant_id == '1100' ||
                    $empMasterData[0]->plant_id == '2100' 
                ) {
                    $email_data = array(
                        'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqFactoryHead/' . $empId . '/' . $documentNo,
                        'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqFactoryHead/' . $empId . '/' . $documentNo,
                        'empName' => $empName
                    );

                    if (!empty($empMasterData[0]->email)) {

                        //for Plant Head
                        Mail::send(['text' => 'travel.emails.intl.plant_head'], $email_data, function ($message) use ($plantHeadData, $empMasterData) {
                            $message->to($plantHeadData[0]->email, $plantHeadData[0]->name)
                                ->subject('Request for International Travel recommendation');
                            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
                        });
                    }
                }


                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }


    public function intlTravelHeadRejected(Request $request)
    {
        //        Log::info($request->all());
        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $suc = TravelIntlReqApproved::where('id', $request->id)
                ->update([
                    'DEPT_ACCEPT' => 'NO',
                    'DEPT_DATE' => $sys_time,
                    'UPDATE_USER' => $uid
                ]);
            if ($suc) {

                $employeeApprovedData = DB::select('select * from mis.travel_intl_req_appr where id = ?', [$request->id]);
                $empId = $employeeApprovedData[0]->emp_id;
                $empMasterData = DB::select('select * from mis.travel_emp_master where emp_id = ?', [$empId]);
                $senderData = DB::select('select * from mis.travel_emp_master where emp_id = ?', [$uid]);


                $email_data = array(
                    'empName' => $senderData[0]->name
                );

                Mail::send(['text' => 'travel.emails.intl.headRejected'], $email_data, function ($message) use ($senderData, $empMasterData) {
                    $message->to($empMasterData[0]->email, $empMasterData[0]->name)
                        ->subject('International Travel Not Approved');
                    $message->from($senderData[0]->email, $senderData[0]->name);
                });

                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }

        }
    }

    public function IntlIndexChairman()
    {
        $uid = Auth::user()->user_id;
        $emp_info = DB::select("
            select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
            from hrms.emp_information@web_to_hrms
            where emp_id in (
            
                select emp_id 
                from mis.travel_intl_req_appr 
                where (chairman_sir_id = '1013157' OR chairman_madam_id ='1013157')
                and ( chairman_sir_accept is null and chairman_madam_accept is null)
                            
            )
            
            order by emp_id
        ");
        return view('travel.international.chairmanApprovedForm', compact('emp_info'));
    }

    public function chairmanIntlGetTraveler(Request $request)
    {

        //        $empInfo = DB::select("select plant_id,emp_id, name email from mis.travel_emp_master where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id') ");

        //Head Office

        if ($request->status == 'All') {

            if ($request->slocation == 'HO') {
        //                $travelList = DB::select(
        //                    "select *
        //                        from mis.travel_intl_req_appr
        //                        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
        //                        and dept_accept = 'YES'
        //                        and site_head_id is null
        //                        and plant_head_id is null
        //                        "
        //                );

                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.dept_head_id) appr_name                 
                    from mis.travel_intl_req_appr a
                    where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                    and dept_accept = 'YES'
                    and site_head_id is null 
                    and plant_head_accept is null                                          
                    "
                );
                return response()->json($travelList);
            } elseif ($request->slocation == 'SF') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.plant_head_id) appr_name
                        from mis.travel_intl_req_appr a
                        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                        and dept_accept = 'YES'                
                        and plant_head_accept = 'YES'                
                        "
                );
                return response()->json($travelList);
            } elseif ($request->slocation == 'DF') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.plant_head_id) appr_name
                        from mis.travel_intl_req_appr a
                        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                        and dept_accept = 'YES'  
                        and site_head_accept = 'YES'                              
                        and plant_head_accept = 'YES'                
                        "
                );
                return response()->json($travelList);
            }
        } elseif ($request->status == 'YES') {

            if ($request->slocation == 'HO') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.dept_head_id) appr_name
                        from mis.travel_intl_req_appr a
                        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                        and dept_accept = 'YES'
                        and site_head_id is null 
                        and plant_head_id is null   
                        and ( chairman_sir_accept = 'YES' or chairman_madam_accept = 'YES') "
                );
                return response()->json($travelList);
            } elseif ($request->slocation == 'SF') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.plant_head_id) appr_name
                        from mis.travel_intl_req_appr a
                        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                        and dept_accept = 'YES'
                        and plant_head_accept = 'YES'
                        and ( chairman_sir_accept = 'YES' or chairman_madam_accept = 'YES') "
                );
                return response()->json($travelList);
            } elseif ($request->slocation == 'DF') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.plant_head_id) appr_name
                        from mis.travel_intl_req_appr a
                        where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                        and dept_accept = 'YES'
                        and plant_head_accept = 'YES'
                        and ( chairman_sir_accept = 'YES' or chairman_madam_accept = 'YES') "
                );
                return response()->json($travelList);
            }
        } elseif ($request->status == 'NO') {
            if ($request->slocation == 'HO') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.dept_head_id) appr_name 
                from mis.travel_intl_req_appr a
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES'
                and site_head_id is null 
                and plant_head_id is null   
                and ( chairman_sir_accept is null and chairman_madam_accept is null) "
                );
                return response()->json($travelList);
            } elseif ($request->slocation == 'SF') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.plant_head_id) appr_name
                from mis.travel_intl_req_appr a
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES'
                and plant_head_accept = 'YES'
                and ( chairman_sir_accept is null and chairman_madam_accept is null) "
                );
                return response()->json($travelList);
            } elseif ($request->slocation == 'DF') {
                $travelList = DB::select(
                    "select distinct a.*,
                    (select name from mis.travel_emp_master where emp_id = a.plant_head_id) appr_name
                from mis.travel_intl_req_appr a
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES'
                and plant_head_accept = 'YES'
                and ( chairman_sir_accept is null and chairman_madam_accept is null) "
                );
                return response()->json($travelList);
            }
        }
    }

    public function intlTravelChairmanApproved(Request $request)
    {
        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');


            if ($uid == '1016856') {

                $suc = null;
                try {

                    $suc = TravelIntlReqApproved::where('id', $request->id)
                        ->update([
                            'CHAIRMAN_SIR_ACCEPT' => 'YES',
                            'CHAIRMAN_SIR_DATE' => $sys_time,
                            'UPDATE_USER' => $uid
                        ]);





                //get all record, generate pdf and send email                
                 $rsac = DB::select('select a.*,b.*
                 from mis.travel_intl_req a, mis.travel_intl_req_appr b
                 where a.document_no = b.document_no
                 and ( b.chairman_sir_accept is not null
                 or b.chairman_madam_accept is not null)
                 and b.id = ?
                 and a.document_no = b.document_no', [ $request->id]);  


                 Session::put('empTravels', $rsac);

                 app()->call('App\Http\Controllers\Travel\TravelEmpMailController@generateEmpTravelPdf');



                } catch (\Exception $e) {
                    return response()->json($e->getMessage());
                }

                if ($suc) {
                    return response()->json(['success' => 'Record Save Successfully']);
                } else {
                    return response()->json(['error' => 'Record Not Save.']);
                }
            } else {
                $suc = TravelIntlReqApproved::where('id', $request->id)
                    ->update([
                        'CHAIRMAN_MADAM_ID' => Auth::user()->user_id,
                        'CHAIRMAN_MADAM_ACCEPT' => 'YES',
                        'CHAIRMAN_MADAM_DATE' => $sys_time,
                        'UPDATE_USER' => $uid
                    ]);

                //get all record, generate pdf and send email
                $rsac = DB::select('select a.*,b.*
                 from mis.travel_intl_req a, mis.travel_intl_req_appr b
                 where a.document_no = b.document_no
                 and ( b.chairman_sir_accept is not null
                 or b.chairman_madam_accept is not null)
                 and b.id = ?
                 and a.document_no = b.document_no', [ $request->id]);


                Session::put('empTravels', $rsac);

                app()->call('App\Http\Controllers\Travel\TravelEmpMailController@generateEmpTravelPdf');

                if ($suc) {
                    return response()->json(['success' => 'Record Save Successfully']);
                } else {
                    return response()->json(['error' => 'Record Not Save.']);
                }
            }
        }
    }

    public function intlTravelChairmanRejected(Request $request)
    {
        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');


            if ($uid == '1016856') {

                $suc = null;
                try {

                    $suc = TravelIntlReqApproved::where('id', $request->id)
                        ->update([
                            'CHAIRMAN_SIR_ACCEPT' => 'NO',
                            'CHAIRMAN_SIR_DATE' => $sys_time,
                            'UPDATE_USER' => $uid
                        ]);
                } catch (\Exception $e) {
                    return response()->json($e->getMessage());
                }

                if ($suc) {
                    $email_data = array(
                        'empName' => ''
                    );

                    Mail::send(['text' => 'travel.emails.intl.chairmanRejected'], $email_data, function ($message) {
                        $message->to('rahnuma@inceptapharma.com', 'Rahnuma Momotaj')
                            ->subject('International Travel Not Approved');
                        $message->from('muk@inceptapharma.com', 'Abdul Muktadir');
                    });

                    return response()->json(['success' => 'Record Save Successfully']);
                } else {
                    return response()->json(['error' => 'Record Not Save.']);
                }
            } else {
                $suc = TravelIntlReqApproved::where('id', $request->id)
                    ->update([
                        'CHAIRMAN_MADAM_ID' => Auth::user()->user_id,
                        'CHAIRMAN_MADAM_ACCEPT' => 'NO',
                        'CHAIRMAN_MADAM_DATE' => $sys_time,
                        'UPDATE_USER' => $uid
                    ]);

                if ($suc) {
                    $email_data = array(
                        'empName' => ''
                    );

                    Mail::send(['text' => 'travel.emails.intl.chairmanRejected'], $email_data, function ($message) {
                        $message->to('rahnuma@inceptapharma.com', 'Rahnuma Momotaj')
                            ->subject('International Travel Not Approved');
                        $message->from('hasneen@inceptapharma.com', 'Hasneen Muktadir');
                    });
                    return response()->json(['success' => 'Record Save Successfully']);
                } else {
                    return response()->json(['error' => 'Record Not Save.']);
                }
            }
        }
    }

    //Site Head

    public function IntlIndexsiteHead(){
        $uid = Auth::user()->user_id;
        $emp_info = DB::select("
            select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
            from hrms.emp_information@web_to_hrms
            where emp_id in (
            
                select emp_id
                from mis.travel_intl_req_appr
                where dept_accept = 'YES'
                and ( site_head_accept is null)
                and site_head_id = '$uid'
                            
            )
            and emp_id != '$uid'
            order by emp_id
        ");
        return view('travel.international.siteHeadApprovedForm', compact('emp_info'));
    }

    public function intlTravelSiteHeadApproved(Request $request)
    {
        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $employeeApprovedData = DB::select('select * from mis.travel_intl_req_appr where id = ?', [$request->id]);
            $documentNo = $employeeApprovedData[0]->document_no;
            $empName = $employeeApprovedData[0]->emp_name;
            $empId = $employeeApprovedData[0]->emp_id;
            $empMasterData = DB::select('select * from mis.travel_emp_master where emp_id = ?', [$empId]);
            $plantHeadData = DB::select("select plant_id,emp_id, name, email from mis.travel_emp_master where emp_id = ? ", [$empMasterData[0]->plant_head_id]);


            $suc = null;
            try {

                $suc = TravelIntlReqApproved::where('id', $request->id)
                    ->update([
                        'SITE_HEAD_ACCEPT' => 'YES',
                        'SITE_HEAD_DATE' => $sys_time,
                        'UPDATE_USER' => $uid
                    ]);
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }

            if ($suc) {

                $email_data = array(
                    'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqFactoryHead/' . $empId . '/' . $documentNo,
                    'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqFactoryHead/' . $empId . '/' . $documentNo,
                    'empName' => $empName
                );

                if (!empty($empMasterData[0]->email)) {

                    //for Site Head
                    Mail::send(['text' => 'travel.emails.intl.plant_head'], $email_data, function ($message) use ($plantHeadData, $empMasterData) {
                        $message->to($plantHeadData[0]->email, $plantHeadData[0]->name)
                            ->subject('Request for International Travel recommendation');
                        $message->from($empMasterData[0]->email, $empMasterData[0]->name);
                    });
                }

                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }

    public function intlTravelSiteHeadRejected(Request $request)
    {
        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

            $suc = null;
            try {

                $suc = TravelIntlReqApproved::where('id', $request->id)
                    ->update([
                        'SITE_HEAD_ACCEPT' => 'NO',
                        'SITE_HEAD_DATE' => $sys_time,
                        'UPDATE_USER' => $uid
                    ]);
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }

            if ($suc) {
                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }


    //site Head (Dhamrai plant)
    public function siteHeadIntlGetTraveler(Request $request){

        if ($request->status == 'All') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr
                 where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES' 
                and plant_id in ( '1300','1400','2200','4100','5100' )
               "
            );
            return response()->json($travelList);
        } elseif ($request->status == 'YES') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr                 
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES' 
                and plant_id in ( '1300','1400','2200','4100','5100' )
                and site_head_accept = 'YES' "
            );
            return response()->json($travelList);
        } elseif ($request->status == 'NO') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr 
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES' 
                and plant_id in ( '1300','1400','2200','4100','5100' )
                and site_head_accept is null "
            );
            return response()->json($travelList);
        }
    }

     //Plant Head (Savar & Dhamrai plant)
    public function plantHeadIntlGetTraveler(Request $request){

        $uid = Auth::user()->user_id;

        if ($request->status == 'All') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr
                 where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES' 
                and plant_head_id = '$uid'
               "
            );
            return response()->json($travelList);
        } elseif ($request->status == 'YES') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr                 
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES' 
                and plant_head_id = '$uid'
                and plant_head_accept = 'YES' "
            );
            return response()->json($travelList);
        } elseif ($request->status == 'NO') {
            $travelList = DB::select(
                "select * 
                from mis.travel_intl_req_appr 
                where emp_id = decode('$request->emp_id','All',emp_id,'$request->emp_id')
                and dept_accept = 'YES' 
                and plant_head_id = '$uid'
                and plant_head_accept is null "
            );
            return response()->json($travelList);
        }
    }

    public function intlIndexPlantHead(){
        $uid = Auth::user()->user_id;
        $emp_info = DB::select("
            select emp_id employee_id, emp_id ||'-' || sur_name as employee_name
            from hrms.emp_information@web_to_hrms
            where emp_id in (
            
                select emp_id
                from mis.travel_intl_req_appr
                where dept_accept = 'YES'
                and ( plant_head_accept is null)
                and plant_head_id = '$uid'
                            
            )
            and emp_id != '$uid'
            order by emp_id
        ");
        return view('travel.international.plantHeadApprovedForm', compact('emp_info'));
    }

    public function intlTravelPlantHeadApproved(Request $request){
        if ($request->st == 'accept') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
            $employeeApprovedData = DB::select('select * from mis.travel_intl_req_appr where id = ?', [$request->id]);
            $documentNo = $employeeApprovedData[0]->document_no;
            $empName = $employeeApprovedData[0]->emp_name;
            $empId = $employeeApprovedData[0]->emp_id;

            $empMasterData = DB::select('select * from mis.travel_emp_master where emp_id = ?', [$empId]);
            $chairmanSirData = DB::select("select plant_id,emp_id, name, email from mis.travel_emp_master where emp_id = ? ", [$empMasterData[0]->chairman_sir_id]);
            $chairmanMadamData = DB::select("select plant_id,emp_id, name, email from mis.travel_emp_master where emp_id = ? ", [$empMasterData[0]->chairman_madam_id]);


            $suc = null;
            try {

                $suc = TravelIntlReqApproved::where('id', $request->id)
                    ->update([
                        'PLANT_HEAD_ACCEPT' => 'YES',
                        'PLANT_HEAD_DATE' => $sys_time,
                        'UPDATE_USER' => $uid
                    ]);
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }

            if ($suc) {

                $email_data = array(
                    'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqPlant/' . $empId . '/' . $documentNo,
                    'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/intlReqPlant/' . $empId . '/' . $documentNo,
                    'empName' => $empName
                );

                if (!empty($empMasterData[0]->email)) {

                    if(!empty($chairmanSirData[0]->email)){
                        //for Chairman Sir
                        Mail::send(['text' => 'travel.emails.intl.chairman'], $email_data, function ($message) use ($chairmanSirData, $empMasterData) {
                            $message->to($chairmanSirData[0]->email, $chairmanSirData[0]->name)
                            ->subject('Request for International Travel Approval');
                            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
                        });
                    }

                    if(!empty($chairmanMadamData[0]->email)){
                        //for Chairman Madam
                        Mail::send(['text' => 'travel.emails.intl.chairman'], $email_data, function ($message) use ($chairmanMadamData, $empMasterData) {
                            $message->to($chairmanMadamData[0]->email, $chairmanMadamData[0]->name)
                            ->subject('Request for International Travel Approval');
                            $message->from($empMasterData[0]->email, $empMasterData[0]->name);
                        });
                    }

                }

                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }

    public function intlTravelPlantHeadRejected(Request $request){
        if ($request->st == 'reject') {
            $uid = Auth::user()->user_id;
            $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

            $employeeApprovedData = DB::select('select * from mis.travel_intl_req_appr where id = ?', [$request->id]);
            $documentNo = $employeeApprovedData[0]->document_no;
            $empName = $employeeApprovedData[0]->emp_name;
            $empId = $employeeApprovedData[0]->emp_id;
            $empMasterData = DB::select('select * from mis.travel_emp_master where emp_id = ?', [$empId]);
            $authEmail = DB::select('select name,email from mis.travel_emp_master where emp_id = ?', [$uid]);

            

            $suc = null;
            try {

                $suc = TravelIntlReqApproved::where('id', $request->id)
                    ->update([
                        'PLANT_HEAD_ACCEPT' => 'NO',
                        'PLANT_HEAD_DATE' => $sys_time,
                        'UPDATE_USER' => $uid
                    ]);
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }

            if ($suc) {

                if(!empty($empMasterData[0]->site_head_id)){
                    $site_head_email = DB::select('select email from mis.travel_emp_master where emp_id = ?',
                     [$empMasterData[0]->site_head_id]);
                    
                    $dept_head_email =  DB::select('select email from mis.travel_emp_master where emp_id = ?',
                     [$empMasterData[0]->dept_head_emp_id]);                   
                    
                    $emp_email =  $empMasterData[0]->email;
                    $authName = $authEmail[0]->name;


                    $emails = [$site_head_email, $dept_head_email,$emp_email];

                    Mail::send(['text' => 'travel.emails.intl.plant_head_reject'], ['authName'=> $authName], function ($message) use ($emails, $authEmail) {
                        $message->to($emails)
                            ->subject('International Travel Approved Rejected');
                        $message->from($authEmail[0]->email, $authEmail[0]->name);
                    });



                }else{
                    $dept_head_email =  DB::select('select email from mis.travel_emp_master where emp_id = ?',
                    [$empMasterData[0]->dept_head_emp_id]);                   
                    
                    $emp_email =  $empMasterData[0]->email;

                    $authName = $authEmail[0]->name;


                    $emails = [$dept_head_email,$emp_email];

                    Mail::send(['text' => 'travel.emails.intl.plant_head_reject'], ['authName'=> $authName], function ($message) use ($emails, $authEmail) {
                        $message->to($emails)
                            ->subject('International Travel Approved Rejected');
                        $message->from($authEmail[0]->email, $authEmail[0]->name);
                    });


                }

                return response()->json(['success' => 'Record Save Successfully']);
            } else {
                return response()->json(['error' => 'Record Not Save.']);
            }
        }
    }


}