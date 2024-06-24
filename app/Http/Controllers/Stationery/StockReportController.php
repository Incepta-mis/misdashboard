<?php

namespace App\Http\Controllers\Stationery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
{
    public function index(){
        return view('stationery.plantWiseStockReport');
    }
    public function item_stock_ledger(){
        return view('stationery.plantWiseStockLedgerReport');
    }
    public function getItemStockData(){
        $plant_id = Auth::user()->plant_id;
        $qry = DB::SELECT("SELECT * FROM MIS.IT_ITEM_STOCK WHERE PLANT_ID = '$plant_id'");
        return response()->json(['data'=>$qry]);
    }
    public function getItemStockLedgerData(){
        $plant_id = Auth::user()->plant_id;
        $qry = DB::SELECT("SELECT * FROM MIS.IT_ITEM_STOCK_LEDGER WHERE PLANT_ID = '$plant_id'");
        return response()->json(['data'=>$qry]);
    }
}
