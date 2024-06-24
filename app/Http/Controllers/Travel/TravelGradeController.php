<?php

namespace App\Http\Controllers\Travel;

use App\Model\Travel\TravelGradeWiseAllowance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class TravelGradeController extends Controller
{

    public function index()
    {
        $grades = TravelGradeWiseAllowance::get();
        return view('travel.masterData.gradeWiseAllowance', compact('grades'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $uid = Auth::user()->user_id;
        $box = $request->all();
        $myValue = array();
        parse_str($box['form_data'], $myValue);

        $sequence = DB::getSequence();
        $grade_id = $sequence->nextValue('MIS.SEQ_TRAVEL_GRADE');

        $grades = new TravelGradeWiseAllowance();
        $grades->id = $grade_id;
        $grades->grade = $myValue['grade'];
        $grades->grade_name = $myValue['grade_name'];
        $grades->location = $myValue['location'];
        $grades->accommodation = $myValue['accommodation'];
        $grades->meals = $myValue['meals'];
        $grades->incidentals = $myValue['incidentals'];
        $grades->da = $myValue['da'];
        $grades->transport = $myValue['transport'];
        $grades->create_user = $uid;
        $grades->save();
        return response()->json(['success' => ' Record Saved.']);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $grade = TravelGradeWiseAllowance::where($where)->first();
        return Response::json($grade);
    }

    public function update(Request $request)
    {

        $uid = Auth::user()->user_id;
        $box = $request->all();
        $myValue = array();
        parse_str($box['form_data'], $myValue);

        TravelGradeWiseAllowance::where('id', $myValue['grade_id'])->update(
            [
                'grade' => $myValue['grade'],
                'grade_name' => $myValue['grade_name'],
                'location' => $myValue['location'],
                'accommodation' => $myValue['accommodation'],
                'meals' => $myValue['meals'],
                'incidentals' => $myValue['incidentals'],
                'da' => $myValue['da'],
                'transport' => $myValue['transport'],
                'update_user' => $uid
            ]
        );

        return response()->json(['success' => ' Record Updated Successfully.']);

    }

    public function destroy($id)
    {
        $delete = TravelGradeWiseAllowance::where('id', $id)->delete();

        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = "Grade deleted successfully";
        } else {
            $success = true;
            $message = "Grade not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
