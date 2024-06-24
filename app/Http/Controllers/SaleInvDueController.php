<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class SaleInvDueController extends Controller
{
    //
    public function due_overdue_inv_view()
    {
//var_dump(Auth::user()->user_id);
        return view('sale_inv_due.sale_inv_due_overdue');

    }

    protected function display_overdue_inv(Request $request)
    {
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        if($request->ajax()){
            $uid = Auth::user()->user_id;
                $duedata = DB::select("select INV_TYPE,INV_NO,INV_DATE,SUM_NO ,CH_NO ,CH_NAME,
  AMOUNT ,DUE_DATE ,OVERDUE_DAYS from MIS.sales_Overdue_Invoice where emp_id = '$uid'");


            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($duedata),
                "iTotalDisplayRecords" => count($duedata),
                "aaData" => $duedata);

            return response()->json($results);

        }
    }


}
