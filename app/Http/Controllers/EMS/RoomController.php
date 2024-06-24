<?php

namespace App\Http\Controllers\EMS;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index(){
        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);

        return view('ems_layout.manage_room_info')->with('plant',$com_plant[0]->plant_id);
    }
    public function insert_room(Request $request)
    {
        Log::info($request->room_name);

        $room_id_temp = DB::select("select nvl(max(to_number(substr( room_id, 2 ))), 0)+1 mr_id from conference_room_info");
        $com_plant = DB::select("select com_id, plant_id from hrms.emp_information@WEB_TO_HRMS where emp_id = ?", [Auth::user()->user_id]);

        //Log::info($com_plant);
        //Log::info($room_id_temp);

            $room_id = 'R'.$room_id_temp[0]->mr_id;
            $insert = [ 'room_id' => $room_id,
                'room_name' => $request->room_name,
                'room_type' => $request->room_type,
                'room_location' => $request->room_location,
                'room_position' => $request->room_position,
                'room_capacity' => $request->seat_capacity,
                'room_accessories' => $request->accessories,
                'valid' => "YES",
                'create_user' => Auth::user()->user_id,
                'com_id' => $com_plant[0]->com_id,
                'plant_id' => $com_plant[0]->plant_id,
                'create_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')];



            DB::table('mis.conference_room_info')->insert($insert);

//        DB::insert("insert into mis.conferance_room_info (room_name, room_type, room_position, room_capacity, room_accessories)
//values (?, ?, ?, ?, ?)", []);

    }

    public function search_room(Request $request){
        Log::info($request->type);
        //return response()->json($request->all());



        if ($request->type == 'room_id') {

            $room_info = DB::select("select room_id, room_name, room_type, room_position,
                            room_location, room_capacity, room_accessories
                            from mis.conference_room_info
                            where room_id like '%$request->s_query%' and rownum <= 60");

            return response()->json(['results' => $room_info]);

        }

        elseif ($request->type == 'room_name') {


            //Log::info($request->query);

//            $room_name = $input['room_name'];
            $room_info = DB::select("select * from (select room_id, room_name, room_type, room_position,
                            room_location, room_capacity, room_accessories from mis.conference_room_info)
                            where upper(room_name) like  '%$request->s_query%' and rownum <= 60");

            return response()->json(['results' => $room_info]);
        }


    }

    public function update_room(Request $request){
        Log::info($request->all());


        $update = [ 'room_name' => $request->room_name,
            'room_type' => $request->room_type,
            'room_location' => $request->room_location,
            'room_position' => $request->room_position,
            'room_capacity' => $request->seat_capacity,
            'room_accessories' => $request->accessories,
            'update_user' => Auth::user()->user_id,
            'update_date' => Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s')];

        DB::table('mis.conference_room_info')->where('room_id',$request->room_id)->update($update);
    }
}

