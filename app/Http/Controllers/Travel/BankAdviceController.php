<?php


namespace App\Http\Controllers\Travel;


use App\Http\Controllers\Controller;
use App\Model\Travel\TravelBankMaster;
use App\Model\Travel\TravelLocalFiAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAdviceController extends Controller
{
    public function index(){
        return view('travel.local.reports.bank_advice_details');
    }

    public function getDocumentNo(Request $request){
        $adviceNo = TravelLocalFiAdvance::select('advice_no')->distinct()->get();
        return response()->json($adviceNo);
    }

    public function getDocumentCmpId(Request $request){
        $adviceNo = TravelLocalFiAdvance::select('company_id','company_name')->distinct()->where('advice_no',$request->advice_no)->get();
        return response()->json($adviceNo);
    }



//    public function companyWiseAdviceLetter(Request $request){
//        $subtotal = TravelLocalFiAdvance::where('advice_no',$request->advice_no)
//            ->sum('amount') ;
//        $arrData = TravelLocalFiAdvance::where('advice_no',$request->advice_no)
//            ->where('company_id',$request->company_id)->get();
//        $pdf = \PDF::loadView('travel/local/fi/adviceLetter' , array('data' => $arrData,'subtotal'=>$subtotal));
//        return $pdf->stream('Advice.pdf');
//    }


    public function getAdviceCompany(){
        $adviceNo = TravelBankMaster::select('company_id','company_name')->distinct()->get();
        return response()->json($adviceNo);
    }
    public function getAdviceBankName(Request $request){
        $adviceNo = TravelBankMaster::select('bank_name')->distinct()->where('company_id',$request->company_id)->orderBy('bank_name')->get();
        return response()->json($adviceNo);
    }

    public function getAdviceBranch(Request $request){
        $adviceNo = TravelBankMaster::select('branch')->distinct()->where('bank_name',$request->bank_name)->orderBy('bank_name')->get();
        return response()->json($adviceNo);
    }

    public function getAdviceAccNo(Request $request){
        $adviceNo = TravelBankMaster::select('acc_no')->distinct()
            ->where('company_id',$request->company_id)
            ->where('branch',$request->branch)->orderBy('company_id')->get();
        return response()->json($adviceNo);
    }


    public function getAdviceCompanyWise(Request $request){
        $subtotal = TravelLocalFiAdvance::where('advice_no',$request->advice_no)
            ->where('company_id',$request->company_id)->sum('amount') ;

        $arrData = TravelLocalFiAdvance::where('advice_no',$request->advice_no)
            ->where('company_id',$request->company_id)->get();
        $pdf = \PDF::loadView('travel/local/reports/fiAdvanceComWGenerate' , array('data' => $arrData,'subtotal'=>$subtotal));
        return $pdf->stream('AdviceDetails.pdf');
    }


    public function comAdviceLetter(Request $request){

//        dd($request->all());

        $input = $request->all();

        $adviceNo =  $input['advice_no_letter'];
        $bank_name =  $input['bank_name'];
        $acc_no =  $input['acc_no'];
        $branch =  $input['branch'];

        $total = TravelLocalFiAdvance::where('advice_no',$adviceNo)->sum('amount') ;
        $noOfPeople = TravelLocalFiAdvance::distinct()->count('document_no');
        $spellNumber = DB::select("select SPELL_NUMBER('$total') amt from dual ");
        $companyName = TravelBankMaster::select('company_name')->distinct()->where('company_id',$input['company_name'])->get() ;

        //dd($companyName);

        $pdf = \PDF::loadView('travel/local/reports/fiAdviceLetter',
            array(
                'adviceNo' => $adviceNo,
                'bank_name' => $bank_name,
                'branch' => $branch,
                'acc_no' => $acc_no,
                'total' => $total,
                'spellNumber' => $spellNumber[0]->amt,
                'noOfPeople' => $noOfPeople,
                'companyName' => $companyName[0]->company_name,
            )
        );
        return $pdf->stream('AdviceLetter.pdf');
    }



}