<?php

namespace App\Http\Controllers\EMS;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminPanelController extends Controller
{
    public function adminpanelview($eid = 'Not Applicable')
    {
        Log::info($eid);
        return view('ems_layout.admin_panel', compact('eid'));
    }

    public function adminpaneldata(Request $request)
    {
        Log::info($request->all());
        DB::setDateFormat('DD-MM-RR');

        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);

        $complete_book = DB::update("update MIS.CONFERENCE_EVENT_BOOKING_INFO
                                        set booking_status = 'Completed', valid = 'NO'

                                       where end_time < sysdate");

        $dorm_request_data = DB::select("select book_id, room_id, room_type, to_char(start_time, 'MM/DD/YYYY HH:MI AM') start_time, to_char(end_time, 'MM/DD/YYYY HH:MI AM') end_time, purpose, person_assumption, 
                                            guest_type, remark, booking_status, valid, create_date, create_user, update_date, update_user, com_id, plant_id, apprv_user, 
                                            apprv_date from mis.conference_event_booking_info
                                            where room_type = decode(?, 'ALL', room_type, ?)
                                            and com_id = ?
                                            and plant_id = ?
                                            and booking_status <> 'Completed'
                                            and booking_status <> 'Rejected' 
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

        return response()->json(['b_r_info' => $dorm_request_data]);

    }

    public function approvedormbooking(Request $request)
    {

//        Log::info($request->all());
//        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);

        $dorm_book_info = DB::select("select room_id, start_time, end_time, booking_status, book_id 
                                        from mis.CONFERENCE_EVENT_BOOKING_INFO
                                        
                                        where room_id = ?
                                        and booking_status <> 'Completed'
                                        and (? between to_date(to_char(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                        and to_date(to_char(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am')
                                        
                                        or ? between to_date(to_char(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                        and to_date(to_char(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am'))
                                        
                                        
                                        and com_id = ?
                                        and plant_id = ?",
            [
                $request->room_id,
                Carbon::parse($request->start_time)->format('Y-m-d H:i:s'),
                Carbon::parse($request->end_time)->format('Y-m-d H:i:s'),
                $request->com_id,
                $request->plant_id
            ]);

        $updateStr = null;
        $success_status = 0;

        Log::info(count($dorm_book_info));

        if (count($dorm_book_info) > 1) {
            Log::info('inside if block');
            $isBooked = false;

            for ($i = 0; $i < count($dorm_book_info); $i++) {
                if ($dorm_book_info[$i]->booking_status === 'Booked') {
                    $isBooked = true;
                }

                Log::info($dorm_book_info[$i]->booking_status);
            }

            if ($isBooked) {
                $updateStr = 'Approval is not possible for same room and same time!';

            } else {
                Log::info('inside else');
                $update = ['booking_status' => "Booked", 'apprv_user' => Auth::user()->user_id, 'apprv_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')];
                $success_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);

                //email confirmation format
                if ($success_status) {
                    $user = Auth::user();
                    $book = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->get();

                    Mail::send(['html' => 'ems_layout.confirmation_mail'], ['user' => $user, 'booking' => $book], function ($message) use ($user) {
                        $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
//                    ->cc($user->email)
                            ->subject('Approval for booking The Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                        $message->from($user->email);
                    });
                }
                $updateStr = 'Booked';

            }


        } else {
            Log::info('inside else block');
            $update = ['booking_status' => "Booked", 'apprv_user' => Auth::user()->user_id, 'apprv_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')];

            //Log::info($request->booking_id);

            $success_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);


            //email confirmation format
            if ($success_status) {
                $user = Auth::user();
                $book = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->get();

                Mail::send(['html' => 'ems_layout.confirmation_mail'], ['user' => $user, 'booking' => $book], function ($message) use ($user) {
                    $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
//                    ->cc($user->email)
                        ->subject('Approval for booking The Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                    $message->from($user->email);
                });
            }
            $updateStr = 'Booked';
        }


        return response()->json(['status' => $success_status, 'update' => $updateStr]);


    }

    public function canceldormbooking(Request $request)
    {
        $update = ['booking_status' => "Rejected", 'valid' => "NO"];
        $select2_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);

        $select_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->get()->toArray();
        //$select_status[0]["del_user"] = Auth::user()->user_id;
        $select_status[0]->del_user = Auth::user()->user_id;
        $select_status[0]->del_date = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s');

        $str = json_encode($select_status[0]);
        $insertStat = DB::table('mis.conference_event_book_inf_del')->insert(json_decode($str, true));
        Log::info($str);


        //email rejection format
        if ($select2_status) {
            $user = Auth::user();
            Mail::send(['html' => 'ems_layout.rejection_mail'], ['user' => $user], function ($message) use ($user) {
                $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
//                    ->cc($user->email)
                    ->subject('Rejection of the booking of the Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                $message->from($user->email);
            });
        }

        return response()->json(['status' => $select_status, 'update' => 'Rejected']);
    }

    public function updateeventtime(Request $request)
    {


        $dataArray = [];
        parse_str($request->fdata, $dataArray);

        $dorm_book_info = DB::select("select room_id, start_time, end_time, booking_status, book_id 
                                        from mis.CONFERENCE_EVENT_BOOKING_INFO
                                        
                                        where room_id = ?
                                        and booking_status <> 'Completed'
                                        and (? between to_date(to_char(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                        and to_date(to_char(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am')
                                        
                                        or ? between to_date(to_char(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                        and to_date(to_char(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am'))
                                        
                                        
                                        and com_id = ?
                                        and plant_id = ?",
            [
                $request->room_id,
                Carbon::parse($dataArray['start_time'])->format('Y-m-d H:i:s'),
                Carbon::parse($dataArray['end_time'])->format('Y-m-d H:i:s'),
                $request->com_id,
                $request->plant_id
            ]);

        $updateStr = null;
        $update_time_info = null;

        if (count($dorm_book_info) > 1) {

            Log::info('inside if block');
            $isBooked = false;

            for ($i = 0; $i < count($dorm_book_info); $i++) {
                if ($dorm_book_info[$i]->booking_status == 'Booked') {
                    $isBooked = true;
                    Log::info('inside iteration');
                }
                Log::info($dorm_book_info[$i]->booking_status);
            }

            if ($isBooked) {
                $updateStr = 'Edit is not possible for same room and same time!';

            } else {

                $user = Auth::user();

                $update_time_info = DB::update("update MIS.CONFERENCE_EVENT_BOOKING_INFO
                                        set start_time = ?, end_time = ?,booking_status = ?, apprv_user = ?, apprv_date = ?
                                        where book_id = ?
                                        and com_id = ?
                                        and plant_id = ?", [
                    Carbon::parse($dataArray['start_time'])->format('Y-m-d H:i:s'),
                    Carbon::parse($dataArray['end_time'])->format('Y-m-d H:i:s'),
                    "Booked",
                    $user->email,
                    Carbon::parse(time())->format('Y-m-d H:i:s'),
                    $request->booking_id,
                    $request->com_id,
                    $request->plant_id
                ]);
//        $update = ['booking_status' => "Booked"];
//        $success_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);

                if ($update_time_info) {

                    $user = Auth::user();
                    $book = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->get();


                    //Email Formaty
                    Mail::send(['html' => 'ems_layout.update_mail'], ['user' => $user, 'book' => $book], function ($message) use ($user) {
                        $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
//                  ->cc($user->email)
                            ->subject('Approval of the booking of the Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                        $message->from($user->email);
                    });

                    $updateStr = 'Booked';
                }
            }

        } else {
//            $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);
            Log::info('inside else block');

            Log::info($request->all());
            Log::info($dataArray);
            $user = Auth::user();

            $update_time_info = DB::update("update MIS.CONFERENCE_EVENT_BOOKING_INFO
                                        set start_time = ?, end_time = ?,booking_status = ?, apprv_user = ?, apprv_date = ?
                                        where book_id = ?", [
                Carbon::parse($dataArray['start_time'])->format('Y-m-d H:i:s'),
                Carbon::parse($dataArray['end_time'])->format('Y-m-d H:i:s'),
                "Booked",
                $user->user_id,
                Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s'),
                $request->booking_id
            ]);

//        $update = ['booking_status' => "Booked"];
//        $success_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);
            Log::info($update_time_info);
            if ($update_time_info) {

                $user = Auth::user();
                $book = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->get();


                //Email Formaty
                Mail::send(['html' => 'ems_layout.update_mail'], ['user' => $user, 'book' => $book], function ($message) use ($user) {
                    $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
//                  ->cc($user->email)
                        ->subject('Approval of the booking of the Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                    $message->from($user->email);
                });
                $updateStr = 'Booked';
            }
        }

        return response()->json(['status' => $update_time_info, 'update' => $updateStr]);
    }

    public function adminpanelsingledata(Request $request)
    {
        $dorm_request_data = DB::select("select book_id, room_id, room_type, to_char(start_time, 'MM/DD/YYYY HH:MI AM') start_time, to_char(end_time, 'MM/DD/YYYY HH:MI AM') end_time, purpose, person_assumption, 
                                            guest_type, remark, booking_status, valid, create_date, create_user, update_date, update_user, com_id, plant_id, apprv_user, 
                                            apprv_date from mis.conference_event_booking_info
                                            where book_id = ?", [
            $request->book_id
        ]);

        return response()->json(['b_r_info' => $dorm_request_data]);
    }

    public function dormbookinfo(Request $request)
    {

//        $dataArray = [];
//        parse_str($request->fdata, $dataArray);

        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);

        $dorm_book_info = DB::select("select room_id, start_time, end_time, booking_status, book_id 
                                        from mis.CONFERENCE_EVENT_BOOKING_INFO
                                        
                                        where room_id = ?
                                        and booking_status <> 'Completed'
                                        and (? between to_date(to_char(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                        and to_date(to_char(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am')
                                        
                                        or ? between to_date(to_char(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                        and to_date(to_char(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am'))
                                        
                                        
                                        and com_id = ?
                                        and plant_id = ?",
            [
                $request->room_id,
                Carbon::parse($request->start_time)->format('Y-m-d H:i:s'),
                Carbon::parse($request->end_time)->format('Y-m-d H:i:s'),
                $com_plant[0]->com_id,
                $com_plant[0]->plant_id
            ]);

        $updateStr = null;
        $success_status = 0;

        if (count($dorm_book_info) > 1) {

            $isBooked = false;

            for ($i = 0; $i < count($dorm_book_info); $i++) {
                if ($dorm_book_info[$i]->booking_status == 'Booked') {
                    $isBooked = true;

                }

                Log::info($dorm_book_info[$i]->booking_status);
            }

            if ($isBooked) {
                $updateStr = 'Approval is not possible for same room and same time!';

            } else {

                $update = ['booking_status' => "Booked"];
                $success_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);

                //email confirmation format
                if ($success_status) {
                    $user = Auth::user();
                    $book = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->get();

                    Mail::send(['html' => 'ems_layout.confirmation_mail'], ['user' => $user, 'booking' => $book], function ($message) use ($user) {
                        $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
//                    ->cc($user->email)
                            ->subject('Approval for booking The Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                        $message->from($user->email);
                    });
                }
                $updateStr = 'Booked';
            }


        } else {
            $update = ['booking_status' => "Booked"];

            //Log::info($request->booking_id);

            $success_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);

            //email confirmation format
            if ($success_status) {
                $user = Auth::user();
                $book = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->get();

                Mail::send(['html' => 'ems_layout.confirmation_mail'], ['user' => $user, 'booking' => $book], function ($message) use ($user) {
                    $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
//                    ->cc($user->email)
                        ->subject('Approval for booking The Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                    $message->from($user->email);
                });
            }
            $updateStr = 'Booked';
        }

        return response()->json(['status' => $success_status, 'update' => $updateStr]);
    }
}

