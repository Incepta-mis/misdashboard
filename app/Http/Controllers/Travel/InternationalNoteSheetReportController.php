<?php


namespace App\Http\Controllers\Travel;


use App\Http\Controllers\Controller;
use App\Model\Travel\TravelInternationalNoteSheet;
use App\Model\Travel\TravelInternationalNoteSheetApproved;
use App\Model\Travel\TravelInternationalNoteSheetDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use function GuzzleHttp\Promise\all;


class InternationalNoteSheetReportController extends Controller
{
    public function index()
    {
        return view('travel.international.reports.noteSheet');
    }

    public function noteSheetExportPDF(Request $request)
    {

        if (empty($request->document_no)) {
            $request->session()->flash('alert-warning', 'Please Enter Document Number!');
            return redirect()->route("international.noteSheetView");
        } else {
            $document_no = $request->document_no;

            $tvM = TravelInternationalNoteSheet::where('document_no', $document_no)->get();

            if (empty($tvM[0])) {
                $request->session()->flash('alert-warning', 'Please Enter Valid Document Number!');
                return redirect()->route("international.noteSheetView");
            } else {
                $tvD = TravelInternationalNoteSheetDetails::where('document_no', $document_no)->get();

                $tvReq = DB::select("select distinct document_no,emp_id,emp_name,desig_name,gl_code,cost_center_id
        from travel_intl_req 
        where document_no in (
            select distinct document_no
            from mis.travel_intl_note_sheet_details
            where group_no = ? )", [$tvM[0]->group_no]);


                $tvAms = DB::select('
        select sum (air_fare_bdt) air_fare, sum (hotel_bdt) hotel , sum (meals_bdt) meals,
 sum(incidentals_bdt) incidentals, sum(da_bdt) daily_allowance, sum(others_bdt) other, sum(linetotal) total
from( 
    select nvl(air_fare,0) * nvl(conversion_rate,0) air_fare_bdt,
           nvl(HOTEL,0) * nvl(hotel_night,0)  *  nvl(conversion_rate,0) hotel_bdt,
           nvl(meals,0) * nvl(day,0)  *  nvl(conversion_rate,0) meals_bdt,
           nvl(INCIDENTALS,0) * nvl(incidentals_night,0)  *  nvl(conversion_rate,0) incidentals_bdt,
           nvl(DA,0) * nvl(DA_night,0)  *  nvl(conversion_rate,0) da_bdt,
           nvl(OTHERS,0)  *  nvl(conversion_rate,0) others_bdt, linetotal
    from mis.travel_intl_note_sheet_details
    where document_no in (  
            select distinct document_no
            from mis.travel_intl_note_sheet_details
            where group_no = ?
     )
)
', [$tvM[0]->group_no]);


                $apprs = DB::select("
                select distinct checked_id,recommended_id,chairman_madam_id
                from MIS.TRAVEL_INTL_NOTE_SHEET_APPR
                where document_no = '$document_no'
        ");

                $pdf = \PDF::loadView('travel.international.reports.noteSheetReportPdf',
                    compact('tvM', 'tvD', 'tvReq', 'tvAms','apprs'));
                return $pdf->stream('NoteSheet.pdf');
            }


        }


    }

    public function noteSheetGroupExportPDF(Request $request)
    {

        if (empty($request->group_no)) {
            $request->session()->flash('alert-warning', 'Please Enter Group Number!');
            return redirect()->route("international.noteSheetView");
        } else {

            $group_no = $request->group_no;

            $docCount = DB::select(" select distinct document_no from mis.travel_intl_note_sheet_details where group_no = ? ", [$group_no]);

            if (empty($docCount)) {
                $request->session()->flash('alert-warning', 'Please Enter Valid Group Number!');
                return redirect()->route("international.noteSheetView");
            } elseif (count($docCount) > 1) {
                $tvM = TravelInternationalNoteSheet::where('document_no', $docCount[0]->document_no)->get();
            } else {
                $tvM = TravelInternationalNoteSheet::where('group_no', $group_no)->get();
            }

//        $tvM = TravelInternationalNoteSheet::where('group_no', $group_no)->get();
            $tvD = TravelInternationalNoteSheetDetails::where('group_no', $group_no)->get();

            $tvReq = DB::select("select distinct document_no,emp_id,emp_name,desig_name,gl_code,cost_center_id
        from travel_intl_req 
        where document_no in (
            select distinct document_no
            from mis.travel_intl_note_sheet_details
            where group_no = ? )", [$group_no]);


            $tvAms = DB::select('
        select sum (air_fare_bdt) air_fare, sum (hotel_bdt) hotel , sum (meals_bdt) meals,
 sum(incidentals_bdt) incidentals, sum(da_bdt) daily_allowance, sum(others_bdt) other, sum(linetotal) total
from( 
    select nvl(air_fare,0) * nvl(conversion_rate,0) air_fare_bdt,
           nvl(HOTEL,0) * nvl(hotel_night,0)  *  nvl(conversion_rate,0) hotel_bdt,
           nvl(meals,0) * nvl(day,0)  *  nvl(conversion_rate,0) meals_bdt,
           nvl(INCIDENTALS,0) * nvl(incidentals_night,0)  *  nvl(conversion_rate,0) incidentals_bdt,
           nvl(DA,0) * nvl(DA_night,0)  *  nvl(conversion_rate,0) da_bdt,
           nvl(OTHERS,0)  *  nvl(conversion_rate,0) others_bdt, linetotal
    from mis.travel_intl_note_sheet_details
    where document_no in (  
            select distinct document_no
            from mis.travel_intl_note_sheet_details
            where group_no = ?
     )
)
', [$group_no]);

            $apprs = DB::select("
                select distinct checked_id,recommended_id,chairman_madam_id
                from MIS.TRAVEL_INTL_NOTE_SHEET_APPR
                where group_no = '$group_no'
        ");


            $pdf = \PDF::loadView('travel.international.reports.noteSheetGroupReportPdf',
                compact('tvM', 'tvD', 'tvReq', 'tvAms','apprs'));
            return $pdf->stream('GroupNoteSheet.pdf');
        }

    }

    public function checkedByNoteSheet(Request $request)
    {
        $group_no = $request->id;

        $docCount = DB::select(" select distinct document_no from mis.travel_intl_note_sheet_details where group_no = ? ", [$group_no]);

        if (count($docCount) > 1) {
            $tvM = TravelInternationalNoteSheet::where('document_no', $docCount[0]->document_no)->get();
        } else {
            $tvM = TravelInternationalNoteSheet::where('group_no', $group_no)->get();
        }

        $tvD = TravelInternationalNoteSheetDetails::where('group_no', $group_no)->get();

        $tvReq = DB::select("select distinct document_no,emp_id,emp_name,desig_name,gl_code,cost_center_id
        from travel_intl_req 
        where document_no in (
        select distinct document_no
        from mis.travel_intl_note_sheet_details
        where group_no = ? )", [$group_no]);


        $tvAms = DB::select('
        select sum (air_fare_bdt) air_fare, sum (hotel_bdt) hotel , sum (meals_bdt) meals,
        sum(incidentals_bdt) incidentals, sum(da_bdt) daily_allowance, sum(others_bdt) other, sum(linetotal) total
        from( 
        select nvl(air_fare,0) * nvl(conversion_rate,0) air_fare_bdt,
        nvl(HOTEL,0) * nvl(hotel_night,0)  *  nvl(conversion_rate,0) hotel_bdt,
        nvl(meals,0) * nvl(meals_day,0)  *  nvl(conversion_rate,0) meals_bdt,
        nvl(INCIDENTALS,0) * nvl(INCIDENTALS_day,0)  *  nvl(conversion_rate,0) incidentals_bdt,
        nvl(DA,0) * nvl(DA_night,0)  *  nvl(conversion_rate,0) da_bdt,
        nvl(OTHERS,0)  *  nvl(conversion_rate,0) others_bdt, linetotal
        from mis.travel_intl_note_sheet_details
        where document_no in (  
        select distinct document_no
        from mis.travel_intl_note_sheet_details
        where group_no = ?
        )
        )
', [$group_no]);

        $apprs = DB::select("
            select distinct checked_id
            from MIS.TRAVEL_INTL_NOTE_SHEET_APPR
            where group_no = '$group_no'
        ");


        return view('travel.international.emailForm.noteSheet.checked', compact('tvM', 'tvD', 'tvAms', 'tvReq','apprs'));
    }


    public function noteSheetDetailsView(Request $request)
    {

        $document_no = $request->id;

        $tvM = TravelInternationalNoteSheet::where('document_no', $document_no)->orderBy('from_date', 'ASC')->get();
        $tvD = TravelInternationalNoteSheetDetails::where('document_no', $document_no)->get();

        $noOfDay = DB::select("
            select sum(nvl(day,0)) no_of_day, sum(nvl(da_day,0)) da_day, sum(nvl(linetotal,0)) linetotal,conversion_rate
            from mis.travel_intl_note_sheet_details
            where document_no = '$document_no'
            group by document_no,da_day,conversion_rate
        ");

        $tvReq = DB::select("select distinct document_no,emp_id,emp_name,desig_name,gl_code,cost_center_id
        from travel_intl_req 
        where document_no  = ?", [$document_no]);

        $tvAms = DB::select('
        select sum (air_fare_bdt) air_fare, sum (hotel_bdt) hotel , sum (meals_bdt) meals,
        sum(incidentals_bdt) incidentals, sum(da_bdt) daily_allowance, sum(others_bdt) other, sum(linetotal) total
        from( 
        select nvl(air_fare,0) * nvl(conversion_rate,0) air_fare_bdt,
        nvl(HOTEL,0) * nvl(hotel_night,0)  *  nvl(conversion_rate,0) hotel_bdt,
        nvl(meals,0) * nvl(meals_day,0)  *  nvl(conversion_rate,0) meals_bdt,
        nvl(INCIDENTALS,0) * nvl(INCIDENTALS_day,0)  *  nvl(conversion_rate,0) incidentals_bdt,
        nvl(DA,0) * nvl(DA_night,0)  *  nvl(conversion_rate,0) da_bdt,
        nvl(OTHERS,0)  *  nvl(conversion_rate,0) others_bdt, linetotal
        from mis.travel_intl_note_sheet_details
        where document_no in (  
        select distinct document_no
        from mis.travel_intl_note_sheet_details
        where group_no = ?
        )
        )
', [$tvM[0]->group_no]);



        $pdf = \PDF::loadView('travel.international.reports.noteSheetDetailsView',
            compact('tvM', 'tvD', 'tvReq', 'tvAms', 'noOfDay'));
        return $pdf->stream('noteSheetDetails.pdf');

    }


    public function intlTravelNoteSheetCheckedAppr(Request $request){

        $group_no = $request->group_id;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no)
                ->update([
                    'CHECKED_ACCEPT' => 'YES',
                    'CHECKED_DATE' => $sys_time,
                    'CHECKED_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/recommended/'.$group_no,
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/recommended/'.$group_no,
                'empName' =>$frm_mail[0]->emp_name );

            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.recommendedEmailBody'], $email_data, function ($message) use($frm_mail) {

                //                $message->to('anayet@inceptapharma.com', 'Anayet Hossain Nipu')
                $message->to('rahnuma@inceptapharma.com', 'Rahnuma Momotaj')
                    ->subject('International Travel Recommended Request');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }


    public function intlTravelNoteSheetCheckedNotAppr(Request $request){

        $group_no = $request->group_id;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no)
                ->update([
                    'CHECKED_ACCEPT' => 'NO',
                    'CHECKED_DATE' => $sys_time,
                    'CHECKED_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $emails = ['rahnuma@inceptapharma.com', 'rabbi@inceptapharma.com'];
            //            $emails = ['masroor@inceptapharma.com'];
            $email_data = array(
               'groupNo' => $group_no,
               'empName' => $frm_mail[0]->emp_name
            );


            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.hrHeadRejectNoteSheet'], $email_data,
                function($message) use ($emails,$frm_mail)
            {
                $message->to($emails)->subject('NoteSheet Not Approved');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }







    public function recommendedByNoteSheet(Request $request){
        $group_no = $request->id;

        $docCount = DB::select(" select distinct document_no from mis.travel_intl_note_sheet_details where group_no = ? ", [$group_no]);

        if (count($docCount) > 1) {
            $tvM = TravelInternationalNoteSheet::where('document_no', $docCount[0]->document_no)->orderBy('id')->get();
        } else {
            $tvM = TravelInternationalNoteSheet::where('group_no', $group_no)->orderBy('id')->get();
        }

        $tvD = TravelInternationalNoteSheetDetails::where('group_no', $group_no)->orderBy('id')->get();

        $tvReq = DB::select("select distinct document_no,emp_id,emp_name,desig_name,gl_code,cost_center_id
        from travel_intl_req 
        where document_no in (
        select distinct document_no
        from mis.travel_intl_note_sheet_details
        where group_no = ? )", [$group_no]);


        $tvAms = DB::select('
        select sum (air_fare_bdt) air_fare, sum (hotel_bdt) hotel , sum (meals_bdt) meals,
        sum(incidentals_bdt) incidentals, sum(da_bdt) daily_allowance, sum(others_bdt) other, sum(linetotal) total
        from( 
        select nvl(air_fare,0) * nvl(conversion_rate,0) air_fare_bdt,
        nvl(HOTEL,0) * nvl(hotel_night,0)  *  nvl(conversion_rate,0) hotel_bdt,
        nvl(meals,0) * nvl(meals_day,0)  *  nvl(conversion_rate,0) meals_bdt,
        nvl(INCIDENTALS,0) * nvl(INCIDENTALS_day,0)  *  nvl(conversion_rate,0) incidentals_bdt,
        nvl(DA,0) * nvl(DA_night,0)  *  nvl(conversion_rate,0) da_bdt,
        nvl(OTHERS,0)  *  nvl(conversion_rate,0) others_bdt, linetotal
        from mis.travel_intl_note_sheet_details
        where document_no in (  
        select distinct document_no
        from mis.travel_intl_note_sheet_details
        where group_no = ?
        )
        )
        ', [$group_no]);

        $apprs = DB::select("
            select distinct recommended_id
            from MIS.TRAVEL_INTL_NOTE_SHEET_APPR
            where group_no = '$group_no'
        ");


        return view('travel.international.emailForm.noteSheet.recommended', compact('tvM', 'tvD', 'tvAms', 'tvReq','apprs'));
    }


    public function intlTravelNoteSheetRecommAppr(Request $request){
        $group_no = $request->group_id;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no)
                ->update([
                    'RECOMMENDED_ACCEPT' => 'YES',
                    'RECOMMENDED_DATE' => $sys_time,
                    'RECOMMENDED_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/'.$group_no,
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/'.$group_no,
                'empName' =>$frm_mail[0]->emp_name );

            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.recommendedEmailBody'], $email_data, function ($message) use($frm_mail) {
            //                $message->to('anayet@inceptapharma.com', 'Anayet Hossain Nipu')
                $message->to('fahim-ahmed@inceptapharma.com', 'Fahim Ahmed')
                    ->subject('International Travel Approved Request');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }
    }

    public function intlTravelNoteSheetRecommNotAppr(Request $request){
        $group_no = $request->group_id;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no)
                ->update([
                    'RECOMMENDED_ACCEPT' => 'NO',
                    'RECOMMENDED_DATE' => $sys_time,
                    'RECOMMENDED_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $emails = ['rahnuma@inceptapharma.com', 'rabbi@inceptapharma.com'];
            //            $emails = ['masroor@inceptapharma.com'];
            $email_data = array(
                'groupNo' => $group_no,
                'empName' => $frm_mail[0]->emp_name
            );


            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.recommendedRejectNoteSheet'], $email_data,
                function($message) use ($emails,$frm_mail)
                {
                    $message->to($emails)->subject('NoteSheet Not Approved');
                    $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
                });

            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }



    public function approvedByNoteSheet(Request $request){
        $group_no = $request->id;

        $docCount = DB::select(" select distinct document_no from mis.travel_intl_note_sheet_details where group_no = ? ", [$group_no]);

        if (count($docCount) > 1) {
            $tvM = TravelInternationalNoteSheet::where('document_no', $docCount[0]->document_no)->orderBy('id')->get();
        } else {
            $tvM = TravelInternationalNoteSheet::where('group_no', $group_no)->orderBy('id')->get();
        }

        $tvD = TravelInternationalNoteSheetDetails::where('group_no', $group_no)->orderBy('id')->get();

        $tvReq = DB::select("select distinct document_no,emp_id,emp_name,desig_name,gl_code,cost_center_id
        from travel_intl_req 
        where document_no in (
        select distinct document_no
        from mis.travel_intl_note_sheet_details
        where group_no = ? )", [$group_no]);


        $tvAms = DB::select('
        select sum (air_fare_bdt) air_fare, sum (hotel_bdt) hotel , sum (meals_bdt) meals,
        sum(incidentals_bdt) incidentals, sum(da_bdt) daily_allowance, sum(others_bdt) other, sum(linetotal) total
        from( 
        select nvl(air_fare,0) * nvl(conversion_rate,0) air_fare_bdt,
        nvl(HOTEL,0) * nvl(hotel_night,0)  *  nvl(conversion_rate,0) hotel_bdt,
        nvl(meals,0) * nvl(meals_day,0)  *  nvl(conversion_rate,0) meals_bdt,
        nvl(INCIDENTALS,0) * nvl(INCIDENTALS_day,0)  *  nvl(conversion_rate,0) incidentals_bdt,
        nvl(DA,0) * nvl(DA_night,0)  *  nvl(conversion_rate,0) da_bdt,
        nvl(OTHERS,0)  *  nvl(conversion_rate,0) others_bdt, linetotal
        from mis.travel_intl_note_sheet_details
        where document_no in (  
        select distinct document_no
        from mis.travel_intl_note_sheet_details
        where group_no = ?
        )
        )
        ', [$group_no]);

        $apprs = DB::select("
            select distinct chairman_madam_id
            from MIS.TRAVEL_INTL_NOTE_SHEET_APPR
            where group_no = '$group_no'
        ");


        return view('travel.international.emailForm.noteSheet.approved', compact('tvM', 'tvD', 'tvAms', 'tvReq','apprs'));
    }

    public function intlTravelNoteSheetApprovedAppr(Request $request){


        $group_no = $request->group_id;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no)
                ->update([
                    'CHAIRMAN_MADAM_ACCEPT' => 'YES',
                    'CHAIRMAN_MADAM_DATE' => $sys_time,
                    'CHAIRMAN_MADAM_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/'.$group_no,
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/'.$group_no,
                'empName' =>$frm_mail[0]->emp_name );

            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.finalApprHRemailBody'], $email_data, function ($message) use($frm_mail) {
            //                $message->to('anayet@inceptapharma.com', 'Anayet Hossain Nipu')
                 $message->to('rahnuma@inceptapharma.com', 'Rahnuma Momotaj')
                    ->subject('Final Approved Travels');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }
    }




    public function intlTravelNoteSheetApprovedNotAppr(Request $request){


        $group_no = $request->group_id;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no)
                ->update([
                    'CHAIRMAN_MADAM_ACCEPT' => 'NO',
                    'CHAIRMAN_MADAM_DATE' => $sys_time,
                    'CHAIRMAN_MADAM_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $emails = ['rahnuma@inceptapharma.com', 'rabbi@inceptapharma.com'];
        //            $emails = ['masroor@inceptapharma.com'];
            $email_data = array(
                'groupNo' => $group_no,
                'empName' => $frm_mail[0]->emp_name
            );


            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.vcRejectNoteSheet'], $email_data,
                function($message) use ($emails,$frm_mail)
                {
                    $message->to($emails)->subject('NoteSheet Not Approved');
                    $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
                });

            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }
    }






    public function noteSheetDelete(Request $request){
        $document_no = $request->document_no;
        if(!empty($document_no)){
            try {
                $rs1 = DB::table('mis.travel_intl_note_sheet')->where('document_no', $document_no)->delete();
                $rs2 = DB::table('mis.travel_intl_note_sheet_appr')->where('document_no', $document_no)->delete();
                $rs3 = DB::table('mis.travel_intl_note_sheet_details')->where('document_no', $document_no)->delete();

                if($rs1 && $rs2 && $rs3){
                    $request->session()->flash('alert-warning', 'Record Deleted.!');
                    return redirect()->route("international.noteSheetView");
                }else{
                    $request->session()->flash('alert-danger', 'Document Number not Found.!');
                    return redirect()->route("international.noteSheetView");
                }
            }catch (Oci8Exception $e){
                $request->session()->flash('alert-danger', $e->getMessage());
                return redirect()->route("international.noteSheetView");
            }
        }else{
            $request->session()->flash('alert-danger', 'Document Number not Found.!');
            return redirect()->route("international.noteSheetView");
        }
    }







    //for menu purpose Note Sheet Checked By
    public function intlNoteSheetCheckedBy(){
        $uid = Auth::user()->user_id;
        $doc_info = DB::select("
        select distinct document_no
        from mis.travel_intl_note_sheet_appr
        ");
        return view('travel.international.reports.noteSheetCheckedBy', compact('doc_info'));
    }

    public function intlGetTravelerByDocument(Request $request)
    {

        $uid = Auth::user()->user_id;

        if ($request->status == 'All') {
            $travelList = DB::select(
                "select
                    id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                    listagg (location, ',')
                    within group
                    (order by location) location
                    from
                    (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                        ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                        from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                        where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                        and a.document_no = b.document_no
                        and a.document_no = c.document_no
                        and b.document_no = c.document_no
                        order by document_no
                        )
                    )
                    group by
                    id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'YES') {
            $travelList = DB::select(
                "select
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                listagg (location, ',')
                within group
                (order by location) location
                from
                (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                    ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                    from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                    where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                    and a.checked_accept = 'YES'
                    and a.document_no = b.document_no
                    and a.document_no = c.document_no
                    and b.document_no = c.document_no
                    order by document_no
                    )
                )
                group by
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'NO') {
            $travelList = DB::select(
                "select
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                listagg (location, ',')
                within group
                (order by location) location
                from
                (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                        ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                        from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                        where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                        and a.checked_accept is null
                        and a.document_no = b.document_no
                        and a.document_no = c.document_no
                        and b.document_no = c.document_no
                        order by document_no
                        )
                    )
                group by
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        }
    }

    public function intlNoteSheetCheckedApprBy(Request $request)
    {

        $document_no = $request->document_no;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $group_no = TravelInternationalNoteSheetApproved::where('document_no', $document_no)->pluck('group_no');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no[0])
                ->update([
                    'CHECKED_ACCEPT' => 'YES',
                    'CHECKED_DATE' => $sys_time,
                    'CHECKED_ID' => $uid
                ]);



        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/recommended/' . $group_no[0],
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/recommended/' . $group_no[0],
                'empName' => $frm_mail[0]->emp_name);

            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.recommendedEmailBody'], $email_data, function ($message) use ($frm_mail) {
                //                $message->to('anayet@inceptapharma.com', 'Anayet Hossain Nipu')
                // $message->to('masroor@inceptapharma.com', 'Zender Xilinc')
                $message->to('rahnuma@inceptapharma.com', 'Rahnuma Momotaj')
                    ->subject('International Travel Recommended Request');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }

    public function intlNoteSheetCheckedApprByNotAppr(Request $request)
    {

        $document_no = $request->document_no;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $group_no = TravelInternationalNoteSheetApproved::where('document_no', $document_no)->pluck('group_no');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no[0])
                ->update([
                    'CHECKED_ACCEPT' => 'NO',
                    'CHECKED_DATE' => $sys_time,
                    'CHECKED_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            
            // $emails = ['masroor@inceptapharma.com'];
            $emails = ['rahnuma@inceptapharma.com', 'rabbi@inceptapharma.com'];
            $email_data = array(
                'groupNo' => $group_no[0],
                'empName' => $frm_mail[0]->emp_name
            );


            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.hrHeadRejectNoteSheet'], $email_data,
                function ($message) use ($emails, $frm_mail) {
                    $message->to($emails)->subject('NoteSheet Not Approved');
                    $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
                });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }
    
    //for menu purpose Note Sheet Recommended By
    public function intlnoteSheetRecommendedBy(){
        $uid = Auth::user()->user_id;
        $doc_info = DB::select("
            select distinct document_no
            from mis.travel_intl_note_sheet_appr
        ");
        return view('travel.international.reports.noteSheetRecommendedBy', compact('doc_info')); 
    }

    public function intlGetTravelerRecByDocument(Request $request)
    {

        $uid = Auth::user()->user_id;

        if ($request->status == 'All') {
            $travelList = DB::select(
                "select
                    id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                    listagg (location, ',')
                    within group
                    (order by location) location
                    from
                    (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                        ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                        from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                        where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                        and a.document_no = b.document_no
                        and a.document_no = c.document_no
                        and b.document_no = c.document_no
                        order by document_no
                        )
                    )
                    group by
                    id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'YES') {
            $travelList = DB::select(
                "select
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                listagg (location, ',')
                within group
                (order by location) location
                from
                (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                    ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                    from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                    where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                    and a.recommended_accept = 'YES'
                    and a.document_no = b.document_no
                    and a.document_no = c.document_no
                    and b.document_no = c.document_no
                    order by document_no
                    )
                )
                group by
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'NO') {
            $travelList = DB::select(
                "select
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                listagg (location, ',')
                within group
                (order by location) location
                from
                (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                        ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                        from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                        where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                        and a.recommended_accept is null
                        and a.document_no = b.document_no
                        and a.document_no = c.document_no
                        and b.document_no = c.document_no
                        order by document_no
                        )
                    )
                group by
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        }
    }

    public function intlNoteSheetRecommendedApprBy(Request $request)
    {

        $document_no = $request->document_no;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $group_no = TravelInternationalNoteSheetApproved::where('document_no', $document_no)->pluck('group_no');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no[0])
                ->update([
                    'RECOMMENDED_ACCEPT' => 'YES',
                    'RECOMMENDED_DATE' => $sys_time,
                    'RECOMMENDED_ID' => $uid
                ]);



        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/' . $group_no[0],
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/' . $group_no[0],
                'empName' => $frm_mail[0]->emp_name);

            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.recommendedEmailBody'], $email_data, function ($message) use ($frm_mail) {
                //                $message->to('anayet@inceptapharma.com', 'Anayet Hossain Nipu')
                // $message->to('masroor@inceptapharma.com', 'Zender Xilinc')
                $message->to('fahim-ahmed@inceptapharma.com', 'Fahim Ahmed')
                    ->subject('International Travel Approved Request');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }

    public function intlNoteSheetRecommendedNotAppr(Request $request)
    {

        $document_no = $request->document_no;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $group_no = TravelInternationalNoteSheetApproved::where('document_no', $document_no)->pluck('group_no');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no[0])
                ->update([
                    'RECOMMENDED_ACCEPT' => 'NO',
                    'RECOMMENDED_DATE' => $sys_time,
                    'RECOMMENDED_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $emails = ['rahnuma@inceptapharma.com', 'rabbi@inceptapharma.com'];
            // $emails = ['masroor@inceptapharma.com'];
            $email_data = array(
                'groupNo' => $group_no[0],
                'empName' => $frm_mail[0]->emp_name
            );


            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.recommendedRejectNoteSheet'], $email_data,
                function ($message) use ($emails, $frm_mail) {
                    $message->to($emails)->subject('NoteSheet Not Approved');
                    $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
                });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }

    //for menu purpose Note Sheet Recommended By
    public function intlnoteSheetApprovedBy(){
        $uid = Auth::user()->user_id;
        $doc_info = DB::select("
            select distinct document_no
            from mis.travel_intl_note_sheet_appr
        ");
        return view('travel.international.reports.noteSheetApprovedBy', compact('doc_info')); 
    }

    public function intlGetTravelerAprByDocument(Request $request)
    {

        $uid = Auth::user()->user_id;

        if ($request->status == 'All') {
            $travelList = DB::select(
                "select
                    id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                    listagg (location, ',')
                    within group
                    (order by location) location
                    from
                    (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                        ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                        from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                        where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                        and a.document_no = b.document_no
                        and a.document_no = c.document_no
                        and b.document_no = c.document_no
                        order by document_no
                        )
                    )
                    group by
                    id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'YES') {
            $travelList = DB::select(
                "select
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                listagg (location, ',')
                within group
                (order by location) location
                from
                (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                    ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                    from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                    where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                    and a.chairman_madam_accept = 'YES'
                    and a.document_no = b.document_no
                    and a.document_no = c.document_no
                    and b.document_no = c.document_no
                    order by document_no
                    )
                )
                group by
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        } elseif ($request->status == 'NO') {
            $travelList = DB::select(
                "select
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept,
                listagg (location, ',')
                within group
                (order by location) location
                from
                (select id, document_no,emp_id,emp_name,desig_name,dept_name,location, checked_accept, recommended_accept, chairman_madam_accept
                        from(
                        select distinct a.id, a.document_no,c.emp_id,c.emp_name, c.desig_name,c.dept_name, a.checked_accept,a.recommended_accept,a.chairman_madam_accept,
                        ' #'|| b.from_loc || '->' || b.to_loc || ' ( ' || b.from_date || ' -> ' || b.to_date || ') ' location
                        from mis.travel_intl_note_sheet_appr a , mis.travel_intl_note_sheet b, mis.travel_intl_req c
                        where a.document_no = decode('$request->doc_no','All',a.document_no,'$request->doc_no')
                        and a.chairman_madam_accept is null
                        and a.document_no = b.document_no
                        and a.document_no = c.document_no
                        and b.document_no = c.document_no
                        order by document_no
                        )
                    )
                group by
                id,document_no,emp_id,emp_name,desig_name,dept_name,checked_accept, recommended_accept, chairman_madam_accept"
            );
            return response()->json($travelList);
        }
    }
    
    public function intlNoteSheetApprovedApprBy(Request $request)
    {

        $document_no = $request->document_no;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $group_no = TravelInternationalNoteSheetApproved::where('document_no', $document_no)->pluck('group_no');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no[0])
                ->update([
                    'CHAIRMAN_MADAM_ACCEPT' => 'YES',
                    'CHAIRMAN_MADAM_DATE' => $sys_time,
                    'CHAIRMAN_MADAM_ID' => $uid
                ]);



        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $email_data = array('url_link' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/' . $group_no,
                'local_url' => 'http://web.inceptapharma.com:5031/misdashboard/travel/international/emailForm/noteSheet/approved/' . $group_no,
                'empName' => $frm_mail[0]->emp_name);

            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.finalApprHRemailBody'], $email_data, function ($message) use ($frm_mail) {
            //                $message->to('anayet@inceptapharma.com', 'Anayet Hossain Nipu')
                // $message->to('masroor@inceptapharma.com', 'Zender Xilinc')
                $message->to('rahnuma@inceptapharma.com', 'Rahnuma Momotaj')
                    ->subject('Final Approved Travels');
                $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
            });


            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }

    public function intlNoteSheetApprovedNotAppr(Request $request)
    {

        $document_no = $request->document_no;
        $uid = Auth::user()->user_id;
        $sys_time = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

        $group_no = TravelInternationalNoteSheetApproved::where('document_no', $document_no)->pluck('group_no');

        $suc = null;
        try {

            $suc = TravelInternationalNoteSheetApproved::where('group_no', $group_no[0])
                ->update([
                    'CHAIRMAN_MADAM_ACCEPT' => 'NO',
                    'CHAIRMAN_MADAM_DATE' => $sys_time,
                    'CHAIRMAN_MADAM_ID' => $uid
                ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        if ($suc) {

            $frm_mail = DB::select("select emp_id,name emp_name,email from mis.travel_emp_master where emp_id = ?", [Auth::user()->user_id]);
            $emails = ['rahnuma@inceptapharma.com', 'rabbi@inceptapharma.com'];
            // $emails = ['masroor@inceptapharma.com'];
            $email_data = array(
                'groupNo' => $group_no[0],
                'empName' => $frm_mail[0]->emp_name
            );


            Mail::send(['text' => 'travel.emails.intl.noteSheetEmail.vcRejectNoteSheet'], $email_data,
                function ($message) use ($emails, $frm_mail) {
                    $message->to($emails)->subject('NoteSheet Not Approved');
                    $message->from($frm_mail[0]->email, $frm_mail[0]->emp_name);
                });

            return response()->json(['success' => 'Record Save Successfully']);
        } else {
            return response()->json(['error' => 'Record Not Save.']);
        }

    }

}