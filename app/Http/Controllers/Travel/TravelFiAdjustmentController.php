<?php


namespace App\Http\Controllers\Travel;


use App\Model\Travel\TravelLocalAdjustment;
use App\Model\Travel\TravelLocalFiAdjustment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class TravelFiAdjustmentController
{
    public function localIndex(){
        return view('travel.local.fi.fiAdjustmentForm');
    }

    public function getCompanyId(){
        $company = DB::select(" select distinct company_id,company_name from mis.travel_emp_master order by company_id ");
        return response()->json($company);
    }

    public function getCompWiseEmpAdjustment(Request $request){
        try{
            $data = DB::select("
                select adv.emp_id,adv.document_no,adv_amt,exp_amt, nvl(adv_amt,0) - nvl(exp_amt,0) emp_adjust_amt
                from
                    (select document_no,emp_id,sum(LINETOTAL) adv_amt
                    from mis.travel_local_advance
                    where emp_id in (
                    select emp_id from mis.travel_emp_master where company_id = '$request->company_id'
                    and emp_id = (select distinct emp_id from mis.travel_local_adjustment where adjustment_status is null)
                    )
                    --and document_no = '10101125804'
                    group by document_no,emp_id) adv,

                    (select document_no,sum(linetotal) exp_amt
                    from mis.TRAVEL_LOCAL_ADJUST_DETAILS
                    --where document_no = '10101125804'
                group by document_no) ex
                where adv.document_no = ex.document_no
            ");

            if($data){
                return response()->json($data);
            }

        }catch (Oci8Exception $exception){
            return redirect()->back()->with('alert-error', $exception->getMessage());
        }
    }


    public function storeFiAdjustData(Request $request){

        $uid = Auth::user()->user_id;

//        dd($request->all());

        $maxId = DB::select(" select nvl(max(id),0) max_id from mis.travel_local_fi_adjustment ");


        if($maxId[0]->max_id == 0){
            $id = 1;
        }else{
            $id = $maxId[0]->max_id+1;
        }

        $ts = TravelLocalFiAdjustment::where('emp_id',$request->fidata['emp_id'])
            ->where('document_no',$request->fidata['document_no'])->count();


        if($ts > 0){
            return response()->json(['error' => 'Already Inserted.']);
        }else{
            $data = [
                'id' => $id,
                'emp_id' => $request->fidata['emp_id'],
                'document_no' => $request->fidata['document_no'],
                'advance_amt' => $request->fidata['adv_amt'],
                'expense_amt' => $request->fidata['exp_amt'],
                'emp_adjust_amt' => $request->fidata['emp_adjust_amt'],
                'fi_adjust_amt' => $request->fidata['fi_adjust_amt'],
                'fi_sap_doc' => $request->fidata['fi_sap_doc'],
                'created_at' => Carbon::now(),
                'create_user' => $uid,
            ];
            TravelLocalFiAdjustment::insert($data);

            DB::table('mis.travel_local_adjustment')
                ->where('document_no', $request->fidata['document_no'])
                ->update(['adjustment_status' => "YES"]);

            return response()->json(['success' => 'Record Save Successfully']);
        }
    }

}
