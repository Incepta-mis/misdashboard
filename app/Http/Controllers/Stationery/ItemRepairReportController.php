<?php


namespace App\Http\Controllers\Stationery;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class ItemRepairReportController extends Controller
{

    /*reports*/
    public function itemRepairReport(){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");

        return view('stationery.itemRepairReport', ['items'=>$itemData,'cats'=>$catData,'types'=>$types,
            'plantId'=>$plantId,'uid'=>$uid,'allPlants'=>$allPlants,'costCenter'=>$costCenter,'units'=>$units]);

    }


    public function getItemRepairData(Request $request){

        DB::setDateFormat("DD-MON-RR");

        $uid = Auth::user()->user_id;

        //$plant_id = $request->plant_id;
        $it_name = $request->it_name;
        $ist_name = $request->ist_name;
        $icat_name = $request->icat_name;
        $date_from = Carbon::parse( $request->date_from )->format('Y-M-d');
        $date_to = Carbon::parse( $request->date_to )->format('Y-M-d');


        if($it_name == 'All'){
            $it_name = 'ALL';
        }
        if($ist_name == 'All'){
            $ist_name = 'ALL';
        }
        if($icat_name == 'All'){
            $icat_name = 'ALL';
        }
        if($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150'){
            $qry = DB::SELECT("select it_name,ist_name,icat_name,service_id,requisition_no,bill_no,item_name,item_id,gl,cost_center,vendor_name,vendor_address, PRODUCT_SERIAL_NO,CWIP_ID_OR_MAIN_ID,QUANTITY,UNIT_COST,TOTAL_COST
                from(
                 select 'ALL' all_data,it_name,ist_name,icat_name,service_id,requisition_no,bill_no,ir.item_name,ir.item_id,ir.gl,ir.cost_center,vendor_name,
                 vendor_address, PRODUCT_SERIAL_NO,CWIP_ID_OR_MAIN_ID,QUANTITY,UNIT_COST,TOTAL_COST,ir.create_date
                 from mis.IT_ITEM_REPAIR ir,mis.it_item_master im
                where ir.item_id = im.item_id
                )where '$it_name' = case when 'ALL' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when 'ALL' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when 'ALL' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
            ");

        }else {
            $qry = DB::SELECT("select it_name,ist_name,icat_name,service_id,requisition_no,bill_no,item_name,item_id,gl,cost_center,vendor_name,vendor_address, PRODUCT_SERIAL_NO,CWIP_ID_OR_MAIN_ID,QUANTITY,UNIT_COST,TOTAL_COST
                from(
                 select 'ALL' all_data,it_name,ist_name,icat_name,service_id,requisition_no,bill_no,ir.item_name,ir.item_id,ir.gl,ir.cost_center,vendor_name,
                 vendor_address, PRODUCT_SERIAL_NO,CWIP_ID_OR_MAIN_ID,QUANTITY,UNIT_COST,TOTAL_COST,ir.create_date
                 from mis.IT_ITEM_REPAIR ir,mis.it_item_master im
           
                where ir.item_id = im.item_id
                     and ir.create_user = '$uid'
                )where '$it_name' = case when 'ALL' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when 'ALL' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when 'ALL' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
            ");

        }

        return response()->json(['res'=>$qry]);
    }

}