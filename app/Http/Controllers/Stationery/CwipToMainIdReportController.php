<?php

namespace App\Http\Controllers\Stationery;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CwipToMainIdReportController extends Controller
{

    /*reports*/
    public function cwipToMainIdReport()
    {
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
        $exists_plant = DB::select("select distinct exist_plant from mis.IT_UPGRADE_CWIPID_TO_MAINID order by exist_plant");

        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");

        return view('stationery.cwipToMainIdReport', ['items' => $itemData, 'cats' => $catData, 'types' => $types,
            'plantId' => $plantId, 'uid' => $uid, 'allPlants' => $allPlants, 'costCenter' => $costCenter, 'units' => $units,
             'exists_plant' => $exists_plant]);

    }


    public function getCwipToMainIdData(Request $request)
    {

       

        DB::setDateFormat("DD-MON-RR");

        $uid = Auth::user()->user_id;

        $plant_id = $request->plant_id;
        $it_name = $request->it_name;
        $ist_name = $request->ist_name;
        $icat_name = $request->icat_name;
        $date_from = Carbon::parse($request->date_from)->format('Y-M-d');
        $date_to = Carbon::parse($request->date_to)->format('Y-M-d');

        if ($it_name == 'All') {
            $it_name = 'ALL';
        }
        if ($ist_name == 'All') {
            $ist_name = 'ALL';
        }
        if ($icat_name == 'All') {
            $icat_name = 'ALL';
        }
        if ($plant_id == 'All') {
            $plant_id = 'ALL';
        }

        if ($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150') {
            $qry = DB::SELECT("
                select it_name,ist_name,icat_name,company_code,AU_ID,cwip_id,EXIST_PLANT,item_id,ITEM_NAME,GR_QTY,UNIT,SAP_PR,SPLIT_QTY,
                MAIN_ID,NEW_PLANT,create_date from(
                select 'ALL' all_data,im.it_name,im.ist_name,icat_name,cm.company_code,cm.EXIST_PLANT,AU_ID,cm.cwip_id,im.item_id,
                       im.ITEM_NAME,cm.GR_QTY,cm.UNIT,cm.SAP_PR,cm.SPLIT_QTY,
                cm.MAIN_ID,cm.NEW_PLANT,cm.create_date from mis.IT_UPGRADE_CWIPID_TO_MAINID cm,mis.it_item_master im
                where cm.ITEM_ID = im.ITEM_ID
                )where '$plant_id'= case when '$plant_id' = 'ALL' then all_data else to_char(EXIST_PLANT) end
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
            ");

        } else {

            $qry = DB::SELECT("
                select it_name,ist_name,icat_name,company_code,AU_ID,cwip_id,EXIST_PLANT,item_id,ITEM_NAME,GR_QTY,UNIT,SAP_PR,SPLIT_QTY,
                MAIN_ID,NEW_PLANT,create_date from(
                select 'ALL' all_data,im.it_name,im.ist_name,icat_name,cm.company_code,cm.EXIST_PLANT,AU_ID,cm.cwip_id,im.item_id,
                       im.ITEM_NAME,cm.GR_QTY,cm.UNIT,cm.SAP_PR,cm.SPLIT_QTY,
                cm.MAIN_ID,cm.NEW_PLANT,cm.create_date from mis.IT_UPGRADE_CWIPID_TO_MAINID cm,mis.it_item_master im
                where cm.ITEM_ID = im.ITEM_ID 
                and cm.create_user = '$uid'     
                )where '$plant_id'= case when '$plant_id' = 'ALL' then all_data else to_char(EXIST_PLANT) end
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
            ");
        }

        return response()->json(['res' => $qry]);
    }

}