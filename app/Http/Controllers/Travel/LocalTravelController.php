<?php

namespace App\Http\Controllers\Travel;

use App\Model\Travel\TravelGradeWiseAllowance;
use App\Model\Travel\TravelLocalAdvance;
use App\Model\Travel\TravelLocalAdvanceApproved;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LocalTravelController extends Controller
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


        return view('travel.local.applicationForm', compact('employeeInfo', 'randomNumber'));
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
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

//        $category = new Category();
//        $category->name = $request->name;
//        $category->save();
//        Toastr::success('Category Successfully Saved :)' ,'Success');
//        return redirect()->route('admin.category.index');

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
            $locations = TravelGradeWiseAllowance::distinct()
                ->whereRaw("UPPER(location) LIKE '%" . strtoupper($request->term['term']) . "%'")->get(['location']);
            return response()->json($locations);
        }
    }

    public function getExpenditure(Request $request)
    {
        DB::setDateFormat("DD-Mon-RR");
        $fromDay = Carbon::createFromFormat('d/m/Y H:i:s A', $request->from_day)->format('d-m-Y');
        $toDay = Carbon::createFromFormat('d/m/Y H:i:s A', $request->to_day)->format('d-m-Y');
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

        $uid = Auth::user()->user_id;
        $input = $request->all();
        $location = '';
        $amount = 0;
        $empReporters = DB::select(" select distinct sup_emp_id,dept_head_emp_id from mis.travel_emp_master where emp_id = '$uid' ");

        for ($i = 0; $i <= count($input['accommodation']); $i++) {
            $sequence = DB::getSequence();
            $id = $sequence->nextValue('MIS.TRAVEL_LOCAL_ID_SEQ');
            if (empty($input['accommodation'][$i]) || !is_numeric($input['accommodation'][$i])) continue;
            $location = $location . ' #' . $input['from_loc'][$i] . '->' . $input['to_loc'][$i] . ' ( ' . $input['from_time'][$i] . ' -> ' . $input['to_time'][$i] . ') ';
            $amount = $amount + $input['linetotal'][$i];

            $data = [
                'id' => $id,
                'document_no' => $input['document_no'],
                'emp_id' => $input['emp_id'],
                'emp_name' => $input['emp_name'],
                'grade' => $input['grade'],
                'desig_name' => $input['desig_name'],
                'dept_name' => $input['dept_name'],
                'purpose' => $input['purpose'],
                'cost_center_id' => $input['cost_center_id'],
                'cost_center_name' => $input['cost_center_name'],
                'gl_code' => $input['gl_code'],
                'from_loc' => $input['from_loc'][$i],
                'to_loc' => $input['to_loc'][$i],
                'from_time' => Carbon::createFromFormat('d/m/Y H:i:s A', $input['from_time'][$i])->toDateTimeString(),
                'to_time' => Carbon::createFromFormat('d/m/Y H:i:s A', $input['to_time'][$i])->toDateTimeString(),
                'days' => $input['days'][$i],
                'accommodation' => $input['accommodation'][$i],
                'meals' => $input['meals'][$i],
                'incidentals' => $input['incidentals'][$i],
                'da' => $input['da'][$i],
                'means_of_transport' => $input['means_of_transport'][$i],
                'transport' => $input['transport'][$i],
                'others' => $input['others'][$i],
                'linetotal' => $input['linetotal'][$i],
                'created_at' => Carbon::now(),
                'created_user' => $input['emp_id']
            ];

//            dd($data);

            TravelLocalAdvance::create($data);
        }

        $sequence = DB::getSequence();
        $id = $sequence->nextValue('MIS.TRAVEL_LOCAL_ID_SEQ');

        $dataApproved = [
            'id' => $id,
            'document_no' => $input['document_no'],
            'emp_id' => $input['emp_id'],
            'emp_name' => $input['emp_name'],
            'location' => $location,
            'amount' => $amount,
            'sup_id' => $empReporters[0]->sup_emp_id,
            'dept_head_id' => $empReporters[0]->dept_head_emp_id,
            'created_at' => Carbon::now(),
            'create_user' => $uid
        ];
        TravelLocalAdvanceApproved::create($dataApproved);


        //mail for supervisor
        $empId = $input['emp_id'];
        $empName = $input['emp_name'];
//        $auth_name = Auth::user()->name;

        $frm_mail = DB::select("select emp_id,name emp_name,email,sup_emp_id,dept_head_emp_id from mis.travel_emp_master where emp_id = ?", [$empId]);
        $to_mail = '';


            if(!empty($frm_mail[0]->sup_emp_id)){
                $to_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [$frm_mail[0]->sup_emp_id]);
            }else {
                if(!empty($frm_mail[0]->dept_head_emp_id)){
                    $to_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [$frm_mail[0]->dept_head_emp_id]);
                }
            }


            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/local/primaryEmailApprovalLocal/'.$empId.'/'.$id,
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/local/primaryEmailApprovalLocal/'.$empId.'/'.$id,
                'empName' =>$empName );
        if(!empty($frm_mail[0]->sup_emp_id) || !empty($frm_mail[0]->dept_head_emp_id )){

            Mail::send(['text' => 'travel.emails.primary_mail'], $email_data, function ($message) use($to_mail,$frm_mail) {
                $message->to($to_mail[0]->email, $to_mail[0]->email)
                    ->subject('Local Travel Approved Request');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });
        }

        $request->session()->flash('alert-success', 'Travel record added successfully!');
        return redirect()->route("local.application");
    }


}
