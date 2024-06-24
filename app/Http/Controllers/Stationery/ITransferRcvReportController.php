<?php

namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ITransferRcvReportController extends Controller
{
    public function index(){
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;

        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $allPlants = DB::select("SELECT DISTINCT PLANT_ID,PLANT_NAME FROM HRMS.PLANT_INFO@WEB_TO_HRMS WHERE COM_ID = 1 ORDER BY PLANT_ID");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::select("SELECT DISTINCT UNIT FROM MIS.IT_OPENING_STOCK");

        return view('stationery.iTransferRcvReport', ['items'=>$itemData,'cats'=>$catData,'types'=>$types,
            'plantId'=>$plantId,'uid'=>$uid,'allPlants'=>$allPlants,'costCenter'=>$costCenter,'units'=>$units]);
    }
    public function getItemTransferRcvReport(Request $request){
        DB::setDateFormat("DD-MON-RR");

        $uid = Auth::user()->user_id;

        $plant_id = $request->plant_id;
        $it_name = $request->it_name;
        $ist_name = $request->ist_name;
        $icat_name = $request->icat_name;
        $date_from = Carbon::parse( $request->date_from )->format('Y-M-d');
        $date_to = Carbon::parse( $request->date_to )->format('Y-M-d');

        if($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150'){
            $qry = DB::SELECT("SELECT m.ITR_NO,m.IT_NO,m.IT_DATE,m.PLANT_ID,m.CREATE_DATE,m.CREATE_USER,d.ITEM_ID,d.ITEM_NAME,
d.CWIP_ID,d.MAIN_ID,d.PO_NUMBER,d.PR_NUMBER,d.GL,d.COST_CENTER, d.TRANSFER_REASON,d.QTY,d.UNIT,d.REMARKS,d.RECEIVE_DATE
FROM IT_ITEM_TRANSFER_RECEIVE_M m INNER JOIN IT_ITEM_TRANSFER_RECEIVE_D d ON m.ITR_NO = d.ITR_NO INNER JOIN IT_ITEM_MASTER i ON i.ITEM_ID = d.ITEM_ID 
WHERE m.PLANT_ID = decode('$plant_id','All',m.PLANT_ID,'$plant_id') 
AND i.IT_NAME = decode('$it_name','All',i.IT_NAME,'$it_name') 
AND i.IST_NAME = decode('$ist_name','All',i.IST_NAME,'$ist_name') 
AND i.ICAT_NAME = decode('$icat_name','All',i.ICAT_NAME,'$icat_name') 
AND to_date(d.CREATE_DATE,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')");
        }else{
            $qry = DB::SELECT("SELECT m.ITR_NO,m.IT_NO,m.IT_DATE,m.PLANT_ID,m.CREATE_DATE,m.CREATE_USER,d.ITEM_ID,d.ITEM_NAME,
d.CWIP_ID,d.MAIN_ID,d.PO_NUMBER,d.PR_NUMBER,d.GL,d.COST_CENTER, d.TRANSFER_REASON,d.QTY,d.UNIT,d.REMARKS,d.RECEIVE_DATE
FROM IT_ITEM_TRANSFER_RECEIVE_M m INNER JOIN IT_ITEM_TRANSFER_RECEIVE_D d ON m.ITR_NO = d.ITR_NO INNER JOIN IT_ITEM_MASTER i ON i.ITEM_ID = d.ITEM_ID 
WHERE m.PLANT_ID = decode('$plant_id','All',m.PLANT_ID,'$plant_id') 
AND m.CREATE_USER = '$uid'
AND i.IT_NAME = decode('$it_name','All',i.IT_NAME,'$it_name') 
AND i.IST_NAME = decode('$ist_name','All',i.IST_NAME,'$ist_name') 
AND i.ICAT_NAME = decode('$icat_name','All',i.ICAT_NAME,'$icat_name') 
AND to_date(d.CREATE_DATE,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')");
        }

        return response()->json(['res'=>$qry]);
    }
}
