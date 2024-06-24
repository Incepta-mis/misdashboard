<?php


namespace App\Http\Controllers\Travel;


use App\Http\Controllers\Controller;
use App\Model\Travel\TravelLocalFiAdvance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TravelFiAdvanceController extends Controller
{
    public function  localIndex(){
        $emp_info = DB::select(" select * from mis.v_travel_local_fi_advance ");
        return view('travel.local.fi.fiAdvanceForm',compact('emp_info'));
    }

    public function storeFiAdvance(Request $request)
    {

//        return response()->json($request->all());

        $uid = Auth::user()->user_id;
        $input = $request->all();



        if(!empty($input['document_no'])){

            for ($i = 0; $i <= count($input['document_no']); $i++) {
                $sequence = DB::getSequence();
                $id = $sequence->nextValue('MIS.TRAVEL_LOCAL_FiID_SEQ');
                if (empty($input['document_no'][$i])) continue;

                $data = [
                    'id' => $id,
                    'advice_no' => $input['advice_no'],
                    'document_no' => $input['document_no'][$i],
                    'company_id' => $input['company_id'][$i],
                    'company_name' => $input['company_name'][$i],
                    'emp_id' => $input['emp_id'][$i],
                    'emp_name' => $input['emp_name'][$i],
                    'bank_acc_no' => $input['bank_acc_no'][$i],
                    'bank_name' => $input['bank_name'][$i],
                    'routing_number' => $input['routing_number'][$i],
                    'amount' => $input['amount'][$i],
                    'fi_process' => $uid,
                    'created_at' => Carbon::now(),
                    'create_user' => $uid
                ];

//                dd($data);

                try {
                    TravelLocalFiAdvance::insert($data);
                } catch(\Illuminate\Database\QueryException $ex){
//                    dd($ex->getMessage());
                    $request->session()->flash('alert-danger', 'You are trying to re-insert same data!');
                    return redirect()->route("local.fi_advance");
                }

            }
            $arrData = TravelLocalFiAdvance::where('advice_no',$input['advice_no'])
                ->orderBy('company_id')->get();
            $pdf = \PDF::loadView('travel/local/fi/fiAdvanceGenerate' , array('data' => $arrData));
            return $pdf->stream('FiAdvance.pdf');

        }else{
            $request->session()->flash('alert-danger', 'Travel Advance Fi Document not Saved!');
            return redirect()->route("local.fi_advance");
        }

    }



}