<?php

namespace App\Http\Controllers\SCM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class FinishProductController extends Controller
{
    public function index(){
        $fp = DB::select("select distinct dosage_form
            from mis.scm_fp_data
            order by dosage_form");
        return view('scm_portal/finishProduct_Entry',compact('fp'));
    }

    public function storeFinishProduct(Request $request){

        $uid = Auth::user()->user_id;

        $max_sl = DB::select(" select max(sl)+1 sl from mis.scm_fp_data ");

        try {
            $rs = DB::table('mis.scm_fp_data')->insert(
                [
                    'sl' => $max_sl[0]->sl,
                    'brand_name' => $request->brand_name,
                    'dosage_form' => $request->dosage_form,
                    'update_user' => $uid
                ]
            );

            if ($rs) {
                return response()->json(['success'=> 'Data Saved.']);
            }else{
                return response()->json(['error'=> 'Contact Your Administrator.']);
            }
        }
        catch (\Exception $exception) {
            return response()->json(['error'=> $exception.' Contact Your Administrator.']);
        }

    }

}