<?php


namespace App\Http\Controllers\Travel;


use App\Http\Controllers\Controller;
use App\Model\Travel\TravelLocalAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocalTravelHistoryController extends Controller
{
    public function index(){
        return view('travel.local.reports.localHistory');
    }

    public function getMyLocalDocumentNO(Request $request){
        $document_no = TravelLocalAdvance::select('document_no','created_at')->distinct()->where('emp_id',$request->emp_id)
                ->orderBy('created_at','desc')->get();
        return response()->json($document_no);
    }

    public function getMyLocalTravel(Request $request){

        if($request->status == 'Advance'){
            $data = DB::select("
        select m.id,m.document_no,from_loc||' -> '|| to_loc || ' ( ' || from_time ||' -> ' || to_time ||' ) ' location,days,linetotal ,p.sup_accept,p.dept_accept
        from travel_local_advance m, mis.travel_local_advance_appr p
        where m.document_no = p.document_no
        and m.emp_id = decode('$request->emp_id','All',m.emp_id,'$request->emp_id')
        and m.document_no = decode('$request->document_no','All',m.document_no,'$request->document_no')     
        and p.status is null               
        ");
        }else{
            $data = DB::select("
        select m.id,m.document_no,from_loc||' -> '|| to_loc || ' ( ' || from_time ||' -> ' || to_time ||' ) ' location,days,linetotal ,p.sup_accept,p.dept_accept
        from travel_local_advance m, mis.travel_local_advance_appr p
        where m.document_no = p.document_no
        and m.emp_id = decode('$request->emp_id','All',m.emp_id,'$request->emp_id')
        and m.document_no = decode('$request->document_no','All',m.document_no,'$request->document_no')  
        and p.status = 'Adjustment'                 
        ");
        }


        return response()->json($data);
    }

    public function getMyLocalExpenditure(Request $request){
        $expenditure = TravelLocalAdvance::where('id',$request->id)->get();
        return response()->json($expenditure);
    }
}