<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MealInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sites_layout.meal_info');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  char  $type
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$type)
    {
        //Log::info($id.'|'.$type);
        $meal_data = DB::select("select emp_id,desig_name,sur_name,meal_type,meal_status,token_status
                                    from hrms.meal_information@web_to_hrms
                                    where EMP_ID = ?
                                    and meal_type = decode(?,'ALL',meal_type,?)
                                    and valid = 'YES'",[$id,$type,$type]);

        return response()->json($meal_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Log::info($request->all());
        $status = null;
        if($request->statType === 'MEAL'){

            $status = DB::update('update hrms.meal_information@web_to_hrms
                                  set meal_status = ?
                                  where emp_id = ?
                                  and meal_type = ?',[$request->status,$request->eid,$request->mtype]);

        }else if($request->statType === 'TOKEN'){
            $status = DB::update('update hrms.meal_information@web_to_hrms
                                  set token_status = ?
                                  where emp_id = ?
                                  and meal_type = ?',[$request->status,$request->eid,$request->mtype]);
        }
        return response()->json(['status'=>$status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
