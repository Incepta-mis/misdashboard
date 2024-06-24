<?php

namespace App\Http\Controllers\EMS;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function index()
    {
        return view('ems_layout.manage_event');

        //return "Hello";
    }

    public function search_room(Request $request)
    {
        Log::info($request->type);
        //return response()->json($request->all());


        if ($request->type == 'room_id') {

            $room_info = DB::select("select room_id, room_name, room_type, room_position,
                            room_location, room_capacity, room_accessories
                            from mis.conference_room_info
                            where room_id like '%$request->s_query%' and rownum <= 60");

            return response()->json(['results' => $room_info]);

        } elseif ($request->type == 'room_name') {


            //Log::info($request->query);

//            $room_name = $input['room_name'];
            $room_info = DB::select("select * from (select room_id, room_name, room_type, room_position,
                            room_location, room_capacity, room_accessories from mis.conference_room_info)
                            where upper(room_name) like  '%$request->s_query%' and rownum <= 60");

            return response()->json(['results' => $room_info]);
        }
    }

    public function roomCard_view(Request $request)
    {
        Log::info(Carbon::parse($request->start_time)->format('m/d/Y h:i:s A'));

        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);


        $complete_book = DB::update("update MIS.CONFERENCE_EVENT_BOOKING_INFO
                                        set booking_status = 'Completed'
                                        where end_time < sysdate");


        DB::setDateFormat('mm/dd/yy hh:mi am');

        $book_info = DB::select("SELECT A.*, B.BOOKING_STATUS, B.BOOK_ID, TO_CHAR(B.START_TIME, 'DD-MON-YY HH:MI AM') START_TIME, TO_CHAR(B.END_TIME, 'DD-MON-YY HH:MI AM') END_TIME, C_USER,NAME
                                FROM
                                (
                                SELECT *
                                FROM MIS.CONFERENCE_ROOM_INFO
                                WHERE ROOM_TYPE = DECODE(?, 'ALL', ROOM_TYPE, ?)
                                ) A,
                                                                    
                                (
                                SELECT ROOM_ID, START_TIME, END_TIME, BOOKING_STATUS, BOOK_ID, CREATE_USER C_USER
                                FROM MIS.CONFERENCE_EVENT_BOOKING_INFO
                                WHERE ? BETWEEN TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                          AND TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am')
                                OR ? BETWEEN TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') 
                                          AND TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am')          
                                OR  TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') BETWEEN ? 
                                          AND ?
                                OR TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') BETWEEN ?
                                          AND ?
                                ) B
                                ,(SELECT USER_ID,NAME FROM MIS.DASHBOARD_USERS_INFO) C
                                WHERE A.ROOM_ID = B.ROOM_ID (+)
                                AND B.C_USER = C.USER_ID (+)
                                AND A.COM_ID = ?
                                AND A.PLANT_ID = ?",
            [  $request->room_type,
                $request->room_type,
                Carbon::parse($request->start_time)->format('m/d/Y h:i A'),
                Carbon::parse($request->end_time)->format('m/d/Y h:i A'),
                Carbon::parse($request->start_time)->format('m/d/Y h:i A'),
                Carbon::parse($request->end_time)->format('m/d/Y h:i A'),
                Carbon::parse($request->start_time)->format('m/d/Y h:i A'),
                Carbon::parse($request->end_time)->format('m/d/Y h:i A'),
                $com_plant[0]->com_id,
                $com_plant[0]->plant_id
            ]);


        return response()->json(['b_info' => $book_info, 'complete_info' => $complete_book]);


    }

    public function book_event(Request $request)
    {

        Log::info( $request->all());

        Log::info($request->book_o['value'][0]);
        // $book_info = DB::select("SELECOUNT(*) booked
        //              FROM
        //              (
        //                     SELECT ROOM_ID, START_TIME, END_TIME, BOOKING_STATUS, BOOK_ID, ATE_USER C_USER
        //                 FROM MIS.CONFERENCE_NT_BOOKING_INFO
        //              WHERE
        //                 (

        //                 TO_DATE(?,'mm/dd/yyyy hh:mi am') BETWEEN TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/yyyy hh:mi am')
        //                     AND TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/yyyy hh:mi am')
        //                     OR TO_DATE(?,'mm/dd/yyyy hh:mi am') BETWEEN TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/yyyy hh:mi am')
        //                     AND TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/yyyy hh:mi am')
        //                     OR  TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') BETWEEN TO_DATE(?,'mm/yyyy hh:mi am')
        //                           AND TO_DATE(?,'mm/yyyy hh:mi am')
        //                 OR TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') BETWEEN TO_DATE(?,'mm/dyyy hh:mi am')
        //                           AND TO_DATE(?,'mm/dd/yyyy hh:mi am')

        //                 )

        //               D ROOM_ID = ?

        //              )"       //     [
        //         Carbon::parse($request->start_time)->form'm/d/Y h:i A'),
        //         Carbon::parse($request->end_time)->form'm/d/Y h:i A'),
        //         Carbon::parse($request->start_time)->form'm/d/Y h:i A'),
        //         Carbon::parse($request->end_time)->form'm/d/Y h:i A'),
        //         Carbon::parse($request->start_time)->form'm/d/Y h:i A'),
        //         Carbon::parse($request->end_time)->form'm/d/Y h:i A'),
        //         quest->room_id

        //  ]request->room_id
        // ];


        $book_info = DB::select("


        select count(*) booked
        from(
        select room_id,start_time,end_time,booking_status,book_id,create_user c_user,
               case when TO_DATE(?,'mm/dd/yyyy hh:mi:ss am') >= TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi:ss am'),'mm/dd/yyyy hh:mi:ss am')
               and  TO_DATE(?,'mm/dd/yyyy hh:mi:ss am') < TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi:ss am'),'mm/dd/yyyy hh:mi:ss am') then 'YES' else 'NO' end rbt
        FROM MIS.CONFERENCE_EVENT_BOOKING_INFO
        where room_id = ?
        )where rbt = 'YES'",
            [
                Carbon::parse($request->start_time)->format('m/d/Y h:i:s A'),
                Carbon::parse($request->start_time)->format('m/d/Y h:i:s A'),
                $request->room_id
            ]
        );

        $book_info_status = DB::select("
        select booking_status
        from(
        select room_id,start_time,end_time,booking_status,book_id,create_user c_user,
               case when TO_DATE(?,'mm/dd/yyyy hh:mi am') >= TO_DATE(TO_CHAR(START_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am')
               and  TO_DATE(?,'mm/dd/yyyy hh:mi am') < TO_DATE(TO_CHAR(END_TIME,'mm/dd/yyyy hh:mi am'),'mm/dd/yyyy hh:mi am') then 'YES' else 'NO' end rbt
        FROM MIS.CONFERENCE_EVENT_BOOKING_INFO
        where room_id = ? 
        )where rbt = 'YES'
                  ",
            [
                Carbon::parse($request->start_time)->format('m/d/Y h:i A'),
                Carbon::parse($request->start_time)->format('m/d/Y h:i A'),
                $request->room_id
            ]
        );

        $booking_status = 0;
        for ($i=0;$i<sizeof($book_info_status);$i++){
            if($book_info_status[$i]->booking_status=='Booked'){
                $booking_status++;
            }
        }

        if($book_info[0]->booked > 0 && $booking_status>0){
            return response()->json(['booked_info' => $book_info,'status' => 'booked']);
        }


        $book_id_temp = DB::select("select nvl(max(to_number(substr( book_id, 2 ))), 0)+1 mr_id from conference_event_booking_info");
        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);


        $book_id = 'B' . $book_id_temp[0]->mr_id;

        $insert = ['book_id' => $book_id,
            'room_id' => $request->room_id,
            'room_type' => $request->room_type,
            'start_time' => Carbon::parse($request->start_time)->format('Y-m-d H:i:s'),
            'end_time' => Carbon::parse($request->end_time)->format('Y-m-d H:i:s'),
            'purpose' => $request->book_info['value'][0],
            'person_assumption' => $request->book_info['value'][1],
            'guest_type' => $request->book_info['value'][2],
            'remark' => $request->book_info['value'][3],
            'booking_status' => $request->room_type == 'Dormitory' ? "Requested" : "Booked",
            'valid' => "YES",
            'create_user' => Auth::user()->user_id,
            'com_id' => $com_plant[0]->com_id,
            'plant_id' => $com_plant[0]->plant_id,
            'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')];


        $success_status = DB::table('mis.conference_event_booking_info')->insert($insert);

        //email request format
        if($success_status && $request->room_type == 'Dormitory'){
            $user = Auth::user();
            $url = url('event/admin_panel_view').'/'.$book_id;
            Log::info($url);
            Mail::send(['html' => 'ems_layout.request_mail'], ['user'=>$user,'url'=>$url], function ($message) use ($user) {
                $message->to('dipro@inceptapharma.com', 'Pabok Dipro')
                    ->cc($user->email)
                    ->subject('Requisition for booking The Dormitory');
//                $message->attachData($pdf->output(), 'Employee_history_form.pdf', [
//                    'mime' => 'application/pdf',
//                ]);
                $message->from($user->email);
            });
        }


        Log::info($success_status);

        return response()->json(['status' => $success_status,'book_info'=>$book_info]);
//        DB::insert("insert into mis.conferance_room_info (room_name, room_type, room_position, room_capacity, room_accessories)
//values (?, ?, ?, ?, ?)", []);
    }

    public function cancel_booking(Request $request)
    {

        $update = ['booking_status' => "Cancelled", 'valid' => "NO"];

        $success_status = DB::table('mis.conference_event_booking_info')->where('book_id', $request->booking_id)->update($update);

        return response()->json(['status' => $success_status]);
    }
}

