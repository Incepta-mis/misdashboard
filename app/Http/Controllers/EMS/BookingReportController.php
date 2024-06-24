<?php

namespace App\Http\Controllers\EMS;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingReportController extends Controller
{
    public function bookingreportview()
    {
        return view('ems_layout.booking_report');
    }

    public function bookingreportdata(Request $request)
    {

        Log::info($request->all());
        DB::setDateFormat('DD-MM-RR');

        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);

        $complete_book = DB::update("update MIS.CONFERENCE_EVENT_BOOKING_INFO
                                        set booking_status = 'Completed', valid = 'NO'
                                        where end_time < sysdate");

        $booking_info_report = DB::select("select book_id, room_id, room_type, to_char(start_time, 'dd-mon-yy hh:mi am') start_time, to_char(end_time, 'dd-mon-yy hh:mi am') end_time, purpose, person_assumption, guest_type, booking_status from mis.conference_event_booking_info
                                            where room_type = decode(?, 'ALL', room_type, ?)
                                            and com_id = ?
                                            and plant_id = ?
                                            and to_date(start_time, 'DD-MM-RR')
                                            between to_date(?, 'DD-MM-RR')
                                            and to_date(?, 'DD-MM-RR')", [
                                                $request->room_type,
                                                $request->room_type,
                                                $com_plant[0]->com_id,
                                                $com_plant[0]->plant_id,
                                                $request->date_from,
                                                $request->date_to
        ]);

        return response()->json(['b_r_info' => $booking_info_report, 'complete_info' => $complete_book]);
    }

}

