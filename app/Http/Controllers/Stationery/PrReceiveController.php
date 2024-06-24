<?php

namespace App\Http\Controllers\Stationery;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrReceiveController extends Controller
{
    public function index(){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");

        return view('stationery.prReceiveReport', ['items'=>$itemData,'cats'=>$catData,'types'=>$types,
            'plantId'=>$plantId,'uid'=>$uid,'allPlants'=>$allPlants,'costCenter'=>$costCenter,'units'=>$units]);
    }
    public function getPrReceiveReport(Request $request){
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
            select 'ALL' all_data,it_name,ist_name,icat_name,company_code, plant_id,rm.irr_no,ir_no,cwip_id,rd.gl,rd.cost_center,im.item_id,im.item_name,
                   issu_qty,recev_qty,pen_qty,unit,rd.receive_date,rd.create_user from mis.it_item_receive_m rm,mis.it_item_receive_d rd,mis.it_item_master im
            where rm.irr_no = rd.irr_no
            and rd.item_id = im.item_id
            ) where '$plant_id' = case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
            and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
            and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
            and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
            and to_date(receive_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')");
        }else{
            $qry = DB::SELECT("select * from(
            select 'ALL' all_data,it_name,ist_name,icat_name,company_code, plant_id,rm.irr_no,ir_no,cwip_id,rd.gl,rd.cost_center,im.item_id,im.item_name,
                   issu_qty,recev_qty,pen_qty,unit,rd.receive_date,rd.create_user from mis.it_item_receive_m rm,mis.it_item_receive_d rd,mis.it_item_master im
            where rm.irr_no = rd.irr_no
            and rd.item_id = im.item_id
            and rm.create_user = '$uid'
            ) where '$plant_id' = case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
            and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
            and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
            and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
            and to_date(receive_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')");
        }


        return response()->json(['res'=>$qry]);
    }
}