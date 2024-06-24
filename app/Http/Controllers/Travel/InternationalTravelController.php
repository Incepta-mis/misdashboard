<?php

namespace App\Http\Controllers\Travel;

use App\Model\Travel\TravelAirport;
use App\Model\Travel\TravelGradeWiseAllowance;
use App\Model\Travel\TravelInternationalReq;
use App\Model\Travel\TravelIntlAllowanceGroup;
use App\Model\Travel\TravelIntlReqApproved;
use App\Model\Travel\TravelLocalAdvance;
use App\Model\Travel\TravelLocalAdvanceApproved;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InternationalTravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        DB::setDateFormat('DD-MON-RR');
        $uid = Auth::user()->user_id;
        $employeeInfo = DB::select("select a.plant_id,a.emp_id,a.sur_name,nvl(a.gender,'Male')
   gender,b.desig_id,b.desig_name,c.dept_id,c.dept_name
   ,a.plant_id,d.contact_no,d.mail_address,d.report_supervisor,d.head_of_dept,e.cost_center_id,e.cost_center_name,e.grade
from (select emp_id,sur_name,desig_id,dept_id,plant_id,gender from hrms.emp_information@web_to_hrms where emp_id = '$uid' and valid = 'YES') a,
     (select distinct desig_id,desig_name from hrms.emp_designation@web_to_hrms where valid = 'YES') b, 
     (select distinct dept_id,dept_name from hrms.dept_information@web_to_hrms where valid = 'YES') c,
     (select distinct emp_id,contact_no,mail_address,report_supervisor,head_of_dept from mis.leave_emp_info where emp_id = '$uid' ) d,
     (select distinct emp_id, cost_center_id,cost_center_name,grade from mis.travel_emp_master where emp_id = '$uid') e
 where a.desig_id = b.desig_id 
 and   a.dept_id = c.dept_id 
 and   a.emp_id = d.emp_id 
 and   a.emp_id = e.emp_id");

        $uid = Auth::user()->user_id;
        $number = mt_rand(1000, 9999);
        $randomNumber = $uid . $number;


        return view('travel.international.applicationForm', compact('employeeInfo', 'randomNumber'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getFromLocation(Request $request)
    {
        if ($request->term['term']) {
            //            $locations = TravelAirport::distinct()
            $locations = TravelIntlAllowanceGroup::distinct()
                ->whereRaw("UPPER(countries) LIKE '%" . strtoupper($request->term['term']) . "%'")->get(['countries']);
            //                ->whereRaw("UPPER(country) LIKE '%" . strtoupper($request->term['term']) . "%'")->get(['airport_name', 'country']);
            return response()->json($locations);
        }
    }


    public function getExpenditure(Request $request)
    {
        DB::setDateFormat("DD-Mon-RR");
        $fromDay = Carbon::createFromFormat('d/m/Y', $request->from_day)->format('d-m-Y');
        $toDay = Carbon::createFromFormat('d/m/Y', $request->to_day)->format('d-m-Y');
        $from_day = date('d-M-y', strtotime($fromDay));
        $to_day = date('d-M-y', strtotime($toDay));

        $holiday = DB::select("
            select count(*) cnt
            from v_holiday
            where to_date(holiday_date,'DD-Mon-RR') between '$from_day' and '$to_day' 
        ");


        //        return response()->json($holiday[0]->cnt);


        $expenditure = TravelGradeWiseAllowance::where('grade', $request->grade)
            ->where('location', $request->location)->distinct('grade')->get();

        $accommodation = (int)$expenditure[0]->accommodation * (int)$request->days;
        $meals = (int)$expenditure[0]->meals * (int)$request->days;
        $incidentals = (int)$expenditure[0]->incidentals * (int)$request->days;
        $da = '';

        if( ($holiday[0]->cnt > 0) && ((int)$request->days  < 11) &&
            ($request->grade == 'H00' || $request->grade == 'H01' || $request->grade == 'H02' || $request->grade == 'H03' || $request->grade == 'H04-1' || $request->grade == 'H04-2') )
        {
            $da = ((int)$expenditure[0]->da * (int)$request->days) + (300 * (int)($holiday[0]->cnt));
        }
        else if( ($holiday[0]->cnt > 0) && ((int)$request->days  < 11) &&
            ($request->grade == 'M01' || $request->grade == 'M01-1' || $request->grade == 'M01-2' || $request->grade == 'M02' || $request->grade == 'M03' || $request->grade == 'M04' || $request->grade == 'M05') )
        {
            $da = ((int)$expenditure[0]->da * (int)$request->days) + (250 * (int)($holiday[0]->cnt));
        }
        else if( ($holiday[0]->cnt > 0) && ((int)$request->days  < 11) && ($request->grade == 'L01' || $request->grade == 'L02' || $request->grade == 'L03') )
        {
            $da = ((int)$expenditure[0]->da * (int)$request->days) + (125 * (int)($holiday[0]->cnt));
        }
        elseif ( ($holiday[0]->cnt > 0) && ((int)$request->days  < 11) &&
            ($request->grade == 'L04' || $request->grade == 'L05' || $request->grade == 'N01' || $request->grade == 'N02' || $request->grade == 'N03' || $request->grade == 'N04' || $request->grade == 'N05' || $request->grade == 'N06' || $request->grade == 'N07' || $request->grade == 'N08' || $request->grade == 'N09' || $request->grade == 'N10' || $request->grade == 'N11' || $request->grade == 'N12' || $request->grade == 'V1' || $request->grade == 'V2' || $request->grade == 'V3' || $request->grade == 'V4' || $request->grade == 'V5') )
        {
            $da = ((int)$expenditure[0]->da * (int)$request->days) + (100 * (int)($holiday[0]->cnt));
        }
        //holiday with grater than 11
        else if( ($holiday[0]->cnt > 0) && ((int)$request->days  >= 11) &&
            ($request->grade == 'H00' || $request->grade == 'H01' || $request->grade == 'H02' || $request->grade == 'H03' || $request->grade == 'H04-1' || $request->grade == 'H04-2') )
        {
            $da = (((int)$expenditure[0]->da/2) * (int)$request->days) + (300 * (int)($holiday[0]->cnt));
        }
        else if( ($holiday[0]->cnt > 0) && ((int)$request->days  >= 11) &&
            ($request->grade == 'M01' || $request->grade == 'M01-1' || $request->grade == 'M01-2' || $request->grade == 'M02' || $request->grade == 'M03' || $request->grade == 'M04' || $request->grade == 'M05') )
        {
            $da = (((int)$expenditure[0]->da/2) * (int)$request->days) + (250 * (int)($holiday[0]->cnt));
        }
        else if( ($holiday[0]->cnt > 0) && ((int)$request->days  >= 11) && ($request->grade == 'L01' || $request->grade == 'L02' || $request->grade == 'L03') )
        {
            $da = (((int)$expenditure[0]->da/2) * (int)$request->days) + (125 * (int)($holiday[0]->cnt));
        }
        elseif ( ($holiday[0]->cnt > 0) && ((int)$request->days  >= 11) &&
            ($request->grade == 'L04' || $request->grade == 'L05' || $request->grade == 'N01' || $request->grade == 'N02' || $request->grade == 'N03' || $request->grade == 'N04' || $request->grade == 'N05' || $request->grade == 'N06' || $request->grade == 'N07' || $request->grade == 'N08' || $request->grade == 'N09' || $request->grade == 'N10' || $request->grade == 'N11' || $request->grade == 'N12' || $request->grade == 'V1' || $request->grade == 'V2' || $request->grade == 'V3' || $request->grade == 'V4' || $request->grade == 'V5') )
        {
            $da = (((int)$expenditure[0]->da/2) * (int)$request->days) + (100 * (int)($holiday[0]->cnt));
        }
        else{
            $da = (int)$expenditure[0]->da * (int)$request->days;
        }



        $transport = (int)$expenditure[0]->transport * (int)$request->days;

        $expenditureArray = array();
        $expenditureArray['accommodation'] = $accommodation;
        $expenditureArray['meals'] = $meals;
        $expenditureArray['incidentals'] = $incidentals;
        $expenditureArray['da'] = $da;
        $expenditureArray['transport'] = $transport;
        return response()->json($expenditureArray);

    }



    public function storeAdvance(Request $request)
    {

        //        dd($request->all());



        $uid = Auth::user()->user_id;
        $input = $request->all();


        if (empty($input['hotel_rent_born'])){
        $request->session()->flash('alert-danger', 'Please Select Hotel Born By');
            return redirect()->route("international.application");
        }elseif (empty($input['meal_expense_born'])){
        $request->session()->flash('alert-danger', 'Please Select Meal Born By');
            return redirect()->route("international.application");
        }elseif (empty($input['transport_born'])){
        $request->session()->flash('alert-danger', 'Please Select Transport Born By');
            return redirect()->route("international.application");
        }else if( empty($input['from_loc']) ) {
            $request->session()->flash('alert-danger', 'Please Enter From Country');
            return redirect()->route("international.application");
        }elseif (empty($input['to_loc'])){
            $request->session()->flash('alert-danger', 'Please Enter To Country');
            return redirect()->route("international.application");
        }elseif (empty($input['from_time'])){
            $request->session()->flash('alert-danger', 'Please Enter From Time');
            return redirect()->route("international.application");
        }elseif (empty($input['to_time'])){
            $request->session()->flash('alert-danger', 'Please Enter To Time');
            return redirect()->route("international.application");
        }else {




            $location = '';
            $amount = 0;
            $empReporters = DB::select(" 
         select distinct company_id,plant_id,sup_emp_id,dept_head_emp_id,site_head_id,plant_head_id,chairman_sir_id,chairman_madam_id 
         from mis.travel_emp_master 
         where emp_id = '$uid' ");

            $hotel_company = '';
            $hotel_vendor = '';
            $hotel_others = '';
            $meal_company = '';
            $meal_vendor = '';
            $meal_others = '';
            $transport_company = '';
            $transport_vendor = '';
            $transport_others = '';

            if (is_array($request->hotel_rent_born) || is_object($request->hotel_rent_born))
            {
                foreach ($request->hotel_rent_born as $hotel) {
                    if ($hotel == 'Company') {
                        $hotel_company = 'Company';
                    }
                    if ($hotel == 'Vendor') {
                        $hotel_vendor = 'Vendor';
                    }
                    if ($hotel == 'Others') {
                        $hotel_others = 'Others';
                    }
                }
            }



            if (is_array($request->meal_expense_born) || is_object($request->meal_expense_born)) {
                foreach ($request->meal_expense_born as $meal) {
                    if ($meal == 'Company') {
                        $meal_company = 'Company';
                    }
                    if ($meal == 'Vendor') {
                        $meal_vendor = 'Vendor';
                    }
                    if ($meal == 'Others') {
                        $meal_others = 'Others';
                    }
                }
            }

            if (is_array($request->transport_born) || is_object($request->transport_born)) {

                foreach ($request->transport_born as $transport) {
                    if ($transport == 'Company') {
                        $transport_company = 'Company';
                    }
                    if ($transport == 'Vendor') {
                        $transport_vendor = 'Vendor';
                    }
                    if ($transport == 'Others') {
                        $transport_others = 'Others';
                    }
                }
            }


            for ($i = 0; $i <= count($input['from_loc']); $i++) {


                $sequence = DB::getSequence();
                $id = $sequence->nextValue('MIS.TRAVEL_INTL_ID_SEQ');
                if (empty($input['from_loc'][$i])) continue;
                $location = $location . ' #' . $input['from_loc'][$i] . '->' . $input['to_loc'][$i] . ' ( ' . $input['from_time'][$i] . ' -> ' . $input['to_time'][$i] . ') ';

                if(!empty( $input['mrp_date'])){
                    $mrpDate =  Carbon::createFromFormat('d/m/Y', $input['mrp_date']);
                }else{ $mrpDate = '';}

                if(!empty( $input['sap_pr_date'])){
                    $sap_pr_date =  Carbon::createFromFormat('d/m/Y', $input['sap_pr_date']);
                }else{ $sap_pr_date = '';}

                if(!empty( $input['lc_date'])){
                    $lc_date =  Carbon::createFromFormat('d/m/Y', $input['lc_date']);
                }else{ $lc_date = '';}

                if(!empty( $input['po_date'])){
                    $po_date =  Carbon::createFromFormat('d/m/Y', $input['po_date']);
                }else{ $po_date = '';}


                $data = [
                    'id' => $id,
                    'document_no' => $input['document_no'],
                    'emp_id' => $input['emp_id'],
                    'emp_name' => $input['emp_name'],
                    'grade' => $input['grade'],
                    'desig_name' => $input['desig_name'],
                    'dept_name' => $input['dept_name'],
                    'purpose' => $input['purpose'],


                    'passport_no' => $input['passport_no'],
                    'date_of_issue' => Carbon::createFromFormat('d/m/Y', $input['date_of_issue'])->toDateTimeString(),
                    'date_of_expiry' => Carbon::createFromFormat('d/m/Y', $input['date_of_expiry'])->toDateTimeString(),

                    'travel_type' => $input['travel_type'],
                    'cost_center_id' => $input['cost_center_id'],
                    'cost_center_name' => $input['cost_center_name'],
                    'gl_code' => $input['gl_code'],
                    'from_loc' => $input['from_loc'][$i],
                    'to_loc' => $input['to_loc'][$i],
                    'from_time' => Carbon::createFromFormat('d/m/Y', $input['from_time'][$i])->toDateTimeString(),
                    'to_time' => Carbon::createFromFormat('d/m/Y', $input['to_time'][$i])->toDateTimeString(),
        //                'days' => $input['days'][$i],
                    'hotel_company' => $hotel_company,
                    'hotel_vendor' => $hotel_vendor,
                    'hotel_others' => $hotel_others,
                    'meal_company' => $meal_company,
                    'meal_vendor' => $meal_vendor,
                    'meal_others' => $meal_others,
                    'transport_company' => $transport_company,
                    'transport_vendor' => $transport_vendor,
                    'transport_others' => $transport_others,
                    'mrp_no' => $input['mrp_no'],
                    'mrp_date' => $mrpDate,
                    'sap_pr_no' => $input['sap_pr_no'],
                    'sap_pr_date' => $sap_pr_date,
                    'lc_no' => $input['sap_pr_no'],
                    'lc_date' => $lc_date,
                    'po_no' => $input['po_no'],
                    'po_date' => $po_date,
                    'cwip_asset_no' => $input['cwip_asset_no'],
                    'cwip_asset_name' => $input['cwip_asset_name'],
                    'created_at' => Carbon::now(),
                    'create_user' => $input['emp_id']
                ];


                TravelInternationalReq::create($data);
            }


            $sequence = DB::getSequence();
            $id = $sequence->nextValue('MIS.TRAVEL_INTL_ID_SEQ_APR');

            $dataApproved = [
                'id' => $id,
                'document_no' => $input['document_no'],
                'plant_id'=>$empReporters[0]->plant_id,
                'emp_id' => $input['emp_id'],
                'emp_name' => $input['emp_name'],
                'location' => $location,

                'dept_head_id' => $empReporters[0]->dept_head_emp_id,
                'site_head_id' => $empReporters[0]->site_head_id,
                'plant_head_id' => $empReporters[0]->plant_head_id,
                'chairman_sir_id' => $empReporters[0]->chairman_sir_id,
                'chairman_madam_id' => $empReporters[0]->chairman_madam_id,

                'created_at' => Carbon::now(),
                'create_user' => $uid,
                'updated_at' => Carbon::now(),
                'update_user' => $uid
            ];

            TravelIntlReqApproved::create($dataApproved);


            //mail for head
            $empId = $input['emp_id'];
            $empName = $input['emp_name'];
        //        $auth_name = Auth::user()->name;

            $frm_mail = DB::select("select emp_id,name emp_name,email,sup_emp_id,dept_head_emp_id from mis.travel_emp_master where emp_id = ?", [$empId]);
            $to_mail = '';


            if (!empty($frm_mail[0]->dept_head_emp_id)) {
                $to_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?",
                    [$frm_mail[0]->dept_head_emp_id]);
            }


            $documentNo = $input['document_no'];
            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/deptHead/' . $empId . '/' . $documentNo,
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/deptHead/' . $empId . '/' . $documentNo,
                'empName' => $empName);

            if ( !empty($frm_mail[0]->dept_head_emp_id)) {

                Mail::send(['text' => 'travel.emails.intl.dept_head'], $email_data, function ($message)
                use ($to_mail, $frm_mail) {
                    $message->to($to_mail[0]->email, $to_mail[0]->email)
                    ->subject('Request for International Travel recommendation');
                    $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
                });
            }


            $request->session()->flash('alert-success', 'Travel record added successfully!');
            return redirect()->route("international.application");












        }





    }

    public function getEmployeeName(Request $request){
      $r =  DB::select('select name from mis.travel_emp_master where emp_id = ?', 
      [$request->emp_id]);
      return response()->json($r);
    }


    public function getInfoByDocumentNo(Request $request){
        $r =  DB::select('
               select 
                t.id, t.document_no, t.emp_id, 
                   t.emp_name, t.grade, t.desig_name, 
                   t.dept_name, t.passport_no, to_char(t.date_of_issue,\'DD-MON-RR\') date_of_issue, 
                   to_char(t.date_of_expiry,\'DD-MON-RR\') date_of_expiry, t.purpose, t.cost_center_id, 
                   t.cost_center_name, t.gl_code, t.travel_type, 
                   t.from_loc, t.to_loc, to_char(t.from_time,\'DD-MON-RR\') from_time, 
                   to_char(t.to_time,\'DD-MON-RR\') to_time, t.days, t.hotel_company, 
                   t.hotel_vendor, t.hotel_others, t.meal_company, 
                   t.meal_vendor, t.meal_others, t.transport_company, 
                   t.transport_vendor, t.transport_others, t.mrp_no, 
                   to_char(t.mrp_date,\'DD-MON-RR\') mrp_date, t.sap_pr_no, to_char( t.sap_pr_date,\'DD-MON-RR\') sap_pr_date,
                   t.lc_no, to_char(t.lc_date,\'DD-MON-RR\') lc_date, t.po_no, 
                   to_char(t.po_date,\'DD-MON-RR\') po_date, t.cwip_asset_no, t.cwip_asset_name, mis.get_travel_emp_email(t.emp_id) emp_email, mis.get_travel_emp_mobile(t.emp_id) emp_mobile
                from mis.travel_intl_req t 
                where t.document_no = ?', [$request->document_no]);
        return response()->json($r);
    }


}
