<?php


namespace App\Http\Controllers\Travel;


use App\Model\Travel\TravelInternationalNoteSheetApproved;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Model\Travel\TravelInternationalNoteSheet;
use App\Model\Travel\TravelInternationalNoteSheetDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use View;

class InternationalNoteSheetController extends Controller
{
    public function index()
    {
        return view('travel.international.createNoteSheet');
    }

    public function getDocumentNO(Request $request)
    {
        $document_no = DB::select("select distinct document_no
            from mis.travel_intl_req_appr");
        return response()->json($document_no);
    }

    public function getGrpNo(Request $request)
    {
        $document_no = $request->docNo;
        $rs =  DB::select("select count (document_no) cnt
            from mis.travel_intl_note_sheet_appr where document_no = '$document_no'");

      //  Log::info($rs);

        if ($rs[0]->cnt > 0) {
            return response()->json(['error' => 'Document Already Exist']);
        } else {
            $grpNo = DB::select("select nvl(max(group_no),0) + 1 group_no from mis.travel_intl_note_sheet");
            return response()->json($grpNo);
        }
    }

    public function getCheckDocument(Request $request)
    {
        $document_no = $request->docNo;
        $rs =  DB::select("select count (document_no) cnt
            from mis.travel_intl_note_sheet_appr where document_no = '$document_no'");

        if ($rs[0]->cnt > 0) {
            return response()->json(['error' => 'Document Already Exist']);
        } else {
            return response()->json(['success' => 'success']);
        }
    }



    public function storeNoteSheet(Request $request)
    {
        $sl = DB::select("select nvl(max(id),0) + 1 sl from mis.travel_intl_note_sheet");
        DB::insert('insert into mis.travel_intl_note_sheet (id, document_no,group_no) values (?, ?, ?)', [$sl[0]->sl, $request->document_no, $request->group_no]);
        return response()->json($request->all());
    }



    public function getGradeWiseAllowance(Request $request)
    {

        // $emps = DB::select('select distinct emp_id,grade,travel_type from mis.travel_intl_req
        // where document_no = ?', [$request->document_no]);

        // $coutries = $request->countries;


        // foreach ($coutries as $k => $obj) {
        //     if ($k < 1) continue;
        //     $rs = DB::select('select group_name from mis.travel_intl_allowance_group  where countries = ?', [$obj]);

        //     if ($emps[0]->travel_type == 'Training') {
        //         $countryArray[] = DB::select('select id,grade, desig_name, 
        //         group_name, accommodation, meals, 
        //         incidentals,  da_training da, 
        //         transport from travel_intl_allowance_group_d where grade = ? and group_name = ?', [$emps[0]->grade, $rs[0]->group_name]);
        //     } else {
        //         $countryArray[] = DB::select('select id,grade, desig_name, 
        //         group_name, accommodation, meals, 
        //         incidentals, da, 
        //         transport from travel_intl_allowance_group_d where grade = ? and group_name = ?', [$emps[0]->grade, $rs[0]->group_name]);
        //     }
        // }

        // return response()->json($countryArray);


        $document_no = $request->document_no;
        $rs = DB::select("select count (document_no) cnt
            from mis.travel_intl_req_appr where document_no = '$document_no'");

        // $check_doc = DB::select("select count (document_no) cnt
        // from mis.travel_intl_note_sheet_appr where document_no = '$document_no'") ;   

        if ($rs[0]->cnt < 1) {
            return response()->json(['error' => 'Please Enter Valid Document']);
        } else {
            $emps = DB::select('select distinct emp_id,grade,travel_type from mis.travel_intl_req
        where document_no = ?', [$request->document_no]);

        $coutries = $request->countries;


        foreach ($coutries as $k => $obj) {
            if ($k < 1) continue;
            $rs = DB::select('select group_name from mis.travel_intl_allowance_group  where countries = ?', [$obj]);

            if ($emps[0]->travel_type == 'Training') {
                $countryArray[] = DB::select('select id,grade, desig_name, 
                group_name, accommodation, meals, 
                incidentals,  da_training da, 
                transport from travel_intl_allowance_group_d where grade = ? and group_name = ?', [$emps[0]->grade, $rs[0]->group_name]);
            } else {
                $countryArray[] = DB::select('select id,grade, desig_name, 
                group_name, accommodation, meals, 
                incidentals, da, 
                transport from travel_intl_allowance_group_d where grade = ? and group_name = ?', [$emps[0]->grade, $rs[0]->group_name]);
            }
        }

        return response()->json($countryArray);
        }
    }


    public function updateNoteSheet(Request $request)
    {
        $box = $request->all();
        //        Log::info($box);
        //        Log::info($box['conversion_rate'][0]);
        //        $document_no = $box['document_no'];
        $group_no = $box['group_no'];
        $acctualDay = explode(',', $box['acctualDay']);
        $sequence = DB::getSequence();
        //        $id = $sequence->nextValue('MIS.TRAVEL_INTL_NOTE_SHEET_SEQ');


        //        Log::info($acctualDay);


        for ($i = 0; $i <= count($box['from_loc']); $i++) {
            if (empty($box['from_loc'][$i])) continue;

            $data = [
                'id' => $sequence->nextValue('MIS.TRAVEL_INTL_NOTE_SHEET_SEQ'),
                'document_no' => $box['document_no'],
                'group_no' => $box['group_no'],
                'from_loc' => $box['from_loc'][$i],
                'to_loc' => $box['to_loc'][$i],
                'from_loc_text' => $box['from_loc_text'][$i],
                'to_loc_text' => $box['to_loc_text'][$i],
                'from_date' => Carbon::createFromFormat('d/m/Y', $box['from_date'][$i])->toDateString(),
                'to_date' => Carbon::createFromFormat('d/m/Y', $box['to_date'][$i])->toDateString(),
                'bd_from_time' => $box['bd_from_time'][$i],
                'bd_to_time' => $box['bd_to_time'][$i],
                'fg_from_time' => $box['visit_from_time'][$i],
                'fg_to_time' => $box['visit_to_time'][$i],
                'created_at' => Carbon::now(),
                'create_user' => Auth::user()->user_id,
                'updated_at' => Carbon::now()
            ];
            TravelInternationalNoteSheet::create($data);
        }




        for ($i = 0; $i < count($box['accommodation']); $i++) {
            if (empty($box['accommodation'][$i])) continue;

            if (!empty($box['hotel_day'][$i])) {
                $hotel_day = $box['hotel_day'][$i];
            } else {
                $hotel_day = '';
            }


            $data2 = [
                'id' => $sequence->nextValue('MIS.TRAVEL_INTL_NOTESHEETDTL_SEQ'),
                'document_no' => $box['document_no'],
                'group_no' => $box['group_no'],
                'day' => $acctualDay[$i],
                'conversion_rate' => $box['conversion_rate'][$i],

                'air_fare' => $box['air_fare'][$i],


                'hotel' => $box['accommodation'][$i],
                'hotel_day' => $hotel_day,
                'hotel_night' => $box['hotel_night'][$i],

                'meals' => $box['meal'][$i],
                'meals_day' => $box['meal_day'][$i],
                'meals_night' => $box['meal_night'][$i],

                'incidentals' => $box['incidentals'][$i],
                'incidentals_day' => $box['incidentals_day'][$i],
                'incidentals_night' => $box['incidentals_night'][$i],

                'da' => $box['da_allow'][$i],
                'da_day' => $box['da_day'][$i],
                'da_night' => $box['da_night'][$i],

                'others' => $box['other'][$i],
                'linetotal' => $box['linetotal'][$i],
                'created_at' => Carbon::now(),
                'create_user' => Auth::user()->user_id,
                'updated_at' => Carbon::now()
            ];
            TravelInternationalNoteSheetDetails::create($data2);
        }


        $data3 = [
            'id' => $sequence->nextValue('MIS.TRAVEL_INTL_NOTESHEETAPR_SEQ'),
            'document_no' => $box['document_no'],
            'group_no' => $box['group_no'],
            'created_at' => Carbon::now(),
            'create_user' => Auth::user()->user_id,
            'updated_at' => Carbon::now()
        ];
        TravelInternationalNoteSheetApproved::create($data3);

        return response()->json(['success' => 'Recoard Saved Successfully.']);
    }





    public function noteSheetPreViewDetails(Request $request)
    {


        if (empty($request->document_no)) {
            $request->session()->flash('alert-warning', 'Please Enter Document Number!');
            return redirect()->route("international.noteSheetView");
        } else {

            $document_no = $request->document_no;

            $docCount = DB::select(" select count(document_no) cnt from mis.travel_intl_note_sheet_appr where document_no = ? ", [$document_no]);


            if ($docCount[0]->cnt < 1) {
                $request->session()->flash('alert-warning', 'Please Enter Valid Document Number!');
                return redirect()->route("international.noteSheetView");
            } else {
                $tvM = TravelInternationalNoteSheet::where('document_no', $document_no)->orderBy('from_date', 'ASC')->get();
                $tvD = TravelInternationalNoteSheetDetails::where('document_no', $document_no)->get();

                $tvReq = DB::select("select distinct document_no, emp_id,emp_name,desig_name,gl_code,cost_center_id
                from travel_intl_req
                where document_no  = ?", [$document_no]);

                $tvAms = DB::select('
                select sum (air_fare_bdt) air_fare, sum (hotel_bdt) hotel , sum (meals_bdt) meals,
                sum(incidentals_bdt) incidentals, sum(da_bdt) daily_allowance, sum(others_bdt) other, sum(linetotal) total
                from(
                    select nvl(air_fare,0) * nvl( air_fare_day,0) * nvl(conversion_rate,0) air_fare_bdt,
                        nvl(HOTEL,0) * nvl(da_day,0)  *  nvl(conversion_rate,0) hotel_bdt,
                        nvl(meals,0) * nvl(day,0)  *  nvl(conversion_rate,0) meals_bdt,
                        nvl(INCIDENTALS,0) * nvl(day,0)  *  nvl(conversion_rate,0) incidentals_bdt,
                        nvl(DA,0) * nvl(DA_DAY,0)  *  nvl(conversion_rate,0) da_bdt,
                        nvl(OTHERS,0)  *  nvl(conversion_rate,0) others_bdt, linetotal
                        from mis.travel_intl_note_sheet_details
                        where document_no in (
                            select distinct document_no
                            from mis.travel_intl_note_sheet_details
                            where group_no = ?
                        )
                    )', [$tvM[0]->group_no]);


                return view('travel.international.noteSheetPreview', compact('tvM', 'tvD', 'tvReq', 'tvAms', 'noOfDay'));
            }
        }
    }

    public function updatefinalNoteSheet(Request $request)
    {
        $box = $request->all();
        $document_no = $box['document_no'];
        $result = array_values(array_unique($box['id']));

        for ($i = 0; $i < count($box['from_loc']); $i++) {

            DB::table('mis.TRAVEL_INTL_NOTE_SHEET')
                ->where('id', $box['sl'][$i])
                ->where('document_no', $document_no)
                ->update([
                'from_date' => Carbon::createFromFormat('d/m/Y', $box['from_date'][$i])->toDateString(),
                'to_date' => Carbon::createFromFormat('d/m/Y', $box['to_date'][$i])->toDateString(),
                'bd_from_time' => $box['bd_from_time'][$i],
                'bd_to_time' => $box['bd_to_time'][$i],
                'fg_from_time' => $box['visit_from_time'][$i] ,
                'fg_to_time' => $box['visit_to_time'][$i] ,
                'update_user' => Auth::user()->user_id,
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < count($result); $i++) {
            DB::table('mis.travel_intl_note_sheet_details')
                ->where('id', $result[$i])
                ->where('document_no', $document_no)
                ->update([
                    'conversion_rate' => $box['conversion_rate'][$i],
                    'air_fare' => $box['air_fare'][$i],
                    'hotel' => $box['hotel'][$i],
                    'hotel_night' => $box['hotel_night'][$i],
                    'meals' => $box['meal'][$i],
                    'meals_day' => $box['meal_day'][$i],
                    'incidentals' => $box['incidental'][$i],
                    'incidentals_day' => $box['incidental_day'][$i],
                    'da' => $box['da'][$i],
                    'da_night' => $box['da_night'][$i],
                    'others' => $box['other'][$i],
                    'linetotal' => $box['linetotal'][$i],
                    'update_user' => Auth::user()->user_id,
                    'updated_at' => Carbon::now()
                ]);
        }
        return response()->json(['success' => 'Recoard Saved Successfully.']);
    }

    public function getTravelFacilities(Request $request)
    {
        // $document_no = $request->document_no;
        // try {
        //     $rs = DB::select("select distinct rtrim((transport_company||','|| transport_vendor ||','||transport_others), ',') transport,
        //     rtrim((hotel_company||','|| hotel_vendor ||','||hotel_others), ',') accommodation,
        //     rtrim((meal_company||','|| meal_vendor ||','||meal_others), ',') meal
        //     from mis.travel_intl_req
        //     where document_no = '$document_no'");
        //     return response()->json($rs);
        // } catch (\Exception $e) {
        //     Log::info('Error: InternationalNoteSheetController functionName getTravelFacilites =', $e);
        // }

        $document_no = $request->document_no;
        $rs = DB::select("select count (document_no) cnt
        from mis.travel_intl_req_appr where document_no = '$document_no'");

        if ($rs[0]->cnt < 1) {
            return response()->json(['error' => 'Please Enter Valid Document']);
        } else {
           
            try {
                $rs = DB::select("select distinct rtrim((transport_company||','|| transport_vendor ||','||transport_others), ',') transport,
                rtrim((hotel_company||','|| hotel_vendor ||','||hotel_others), ',') accommodation,
                rtrim((meal_company||','|| meal_vendor ||','||meal_others), ',') meal
                from mis.travel_intl_req
                where document_no = '$document_no'");
                return response()->json($rs);
            } catch (\Exception $e) {
                Log::info('Error: InternationalNoteSheetController functionName getTravelFacilites =', $e);
            }
        }
    }

    public function sendHrHeadEmail(Request $request)
    {
        $group_no = $request->group_no;
        $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
        $email_data = array(
            'url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/checked/' . $group_no,
            'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/checked/' . $group_no,
            'empName' => $frm_mail[0]->emp_name
        );

        DB::table('mis.travel_intl_note_sheet_appr')
        ->where('group_no', $group_no)
        ->update([
            'checked_id' => '',
            'checked_accept' => '',
            'checked_date' => '',
            'recommended_id'=> '',
            'recommended_accept'=> '',
            'recommended_date'=> '',
            'chairman_madam_id'=> '',
            'chairman_madam_accept'=> '',
            'chairman_madam_date'=> '',
            'update_user' => Auth::user()->user_id,
            'updated_at' => Carbon::now()
        ]);

        Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.checkedEmailBody'], $email_data, function ($message) use ($frm_mail) {
            // $message->to('anayet@inceptapharma.com', 'Anayet Hossain Nipu')
            $message->to('manir@inceptapharma.com', 'Md. Manirujjaman')
            // $message->to('masroor@inceptapharma.com', 'Zender Xilinc')
                ->subject('Travel Approved Request');
            $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
        });

        return response()->json(['success' => 'Send Email Successfully.']);

    }

    public function getTravelHistory(){

        $uid = Auth::user()->user_id;
        $plants = DB::select('select plant_id from mis.travel_emp_master where emp_id = ?', [$uid]);
 

        //HO
        if($plants[0]->plant_id == '1000' || $plants[0]->plant_id == '5000'){
            $history = DB::select(
                "select distinct r.plant_id, r.document_no,r.dept_accept, r.chairman_sir_accept || r.chairman_madam_accept chairman_accept,
                checked_accept hr_accept,recommended_accept finance_accept,n.chairman_madam_accept nchairman_accept
                from mis.travel_intl_req_appr r ,mis.travel_intl_note_sheet_appr n
                where r.document_no = n.document_no 
                and r.emp_id = ?
                --and to_date(r.created_at,'DD-MON-RR') between  (SELECT to_date(TRUNC (SYSDATE , 'YEAR'),'DD-MON-RR') FROM DUAL) and (SELECT to_date(ADD_MONTHS(TRUNC (SYSDATE ,'YEAR'),12)-1,'DD-MON-RR') FROM DUAL)
                order by r.document_no desc"
                , [$uid]);

            return view('travel.international.myIntlTravelHistory', compact('history'));
        }
            //  Dhamrai
        else if(
            $plants[0]->plant_id == '1300' || $plants[0]->plant_id == '1400'||
            $plants[0]->plant_id == '2200' || $plants[0]->plant_id == '4100'||
            $plants[0]->plant_id == '5100'            
            ){

            $history = DB::select(
                "select distinct r.plant_id, r.document_no,r.dept_accept, r.site_head_accept , r.plant_head_accept,r.chairman_sir_accept || r.chairman_madam_accept chairman_accept,
                checked_accept hr_accept,recommended_accept finance_accept,n.chairman_madam_accept nchairman_accept
                from mis.travel_intl_req_appr r ,mis.travel_intl_note_sheet_appr n
                where r.document_no = n.document_no 
                and r.emp_id = ?
                --and to_date(r.created_at,'DD-MON-RR') between   (SELECT to_date(TRUNC (SYSDATE , 'YEAR'),'DD-MON-RR') FROM DUAL) and (SELECT to_date(ADD_MONTHS(TRUNC (SYSDATE ,'YEAR'),12)-1,'DD-MON-RR') FROM DUAL) 
                order by r.document_no desc"
                , [$uid]); 

            return view('travel.international.myIntlTravelHistory', compact('history'));
        } 
            // Savar        
        if($plants[0]->plant_id == '1100' || $plants[0]->plant_id == '2100'){
            $history = DB::select(
                "select distinct r.plant_id, r.document_no,r.dept_accept, r.plant_head_accept, r.chairman_sir_accept || r.chairman_madam_accept chairman_accept,
                checked_accept hr_accept,recommended_accept finance_accept,n.chairman_madam_accept nchairman_accept
                from mis.travel_intl_req_appr r ,mis.travel_intl_note_sheet_appr n
                where r.document_no = n.document_no 
                and r.emp_id = ?
                --and to_date(r.created_at,'DD-MON-RR') between     (SELECT to_date(TRUNC (SYSDATE , 'YEAR'),'DD-MON-RR') FROM DUAL) and (SELECT to_date(ADD_MONTHS(TRUNC (SYSDATE ,'YEAR'),12)-1,'DD-MON-RR') FROM DUAL) 
                order by r.document_no desc"
                , [$uid]); 

            return view('travel.international.myIntlTravelHistory', compact('history'));
        }
        
        
    }

}
