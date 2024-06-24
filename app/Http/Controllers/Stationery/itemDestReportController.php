<?php

namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class itemDestReportController extends Controller
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

        return view('stationery.itemDestReport', ['items'=>$itemData,'cats'=>$catData,'types'=>$types,
            'plantId'=>$plantId,'uid'=>$uid,'allPlants'=>$allPlants,'costCenter'=>$costCenter,'units'=>$units]);
    }
    public function getItemDestReport(Request $request){
        DB::setDateFormat("DD-MON-RR");

        $uid = Auth::user()->user_id;

        $plant_id = $request->plant_id;
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
        if($plant_id == 'All'){
            $plant_id = 'ALL';
        }

        if($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150'){
            $qry = DB::SELECT("select * from(
                select 'ALL' all_data,it_name,ist_name,icat_name,company_code, service_id,plant_id,td.cwip_id,td.main_id,td.gl,
                    td.cost_center,im.item_id,im.item_name,qty,unit,unit_price,origin_plant,user_name,department,reason,status,remarks,td.create_date,td.create_user
                    from mis.IT_ITEM_DESTRUCTION td,mis.it_item_master im
                where td.item_id = im.item_id
            ) where '$plant_id' = case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
            and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
            and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
            and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
            and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')");
        }else{
            $qry = DB::SELECT("select * from(
                select 'ALL' all_data,it_name,ist_name,icat_name,company_code, service_id,plant_id,td.cwip_id,td.main_id,td.gl,
                td.cost_center,im.item_id,im.item_name,qty,unit,unit_price,origin_plant,user_name,department,reason,status,remarks,td.create_date,td.create_user
                from mis.IT_ITEM_DESTRUCTION td,mis.it_item_master im
                where td.item_id = im.item_id
                and td.create_user = '$uid'
            ) where '$plant_id' = case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')");
        }

        return response()->json(['res'=>$qry]);
    }
}
