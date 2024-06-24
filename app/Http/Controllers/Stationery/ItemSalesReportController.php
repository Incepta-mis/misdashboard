<?php

namespace App\Http\Controllers\Stationery;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ItemSalesReportController extends Controller
{

    /*reports*/
    public function itemSalesReport()
    {
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");

        return view('stationery.itemSalesReport', ['items' => $itemData, 'cats' => $catData, 'types' => $types,
            'plantId' => $plantId, 'uid' => $uid, 'allPlants' => $allPlants, 'costCenter' => $costCenter, 'units' => $units]);

    }


    public function getItemSalesReport(Request $request)
    {

        DB::setDateFormat("DD-MON-RR");

        $uid = Auth::user()->user_id;

        $plant_id = $request->plant_id;
        $it_name = $request->it_name;
        $ist_name = $request->ist_name;
        $icat_name = $request->icat_name;
        $date_from = Carbon::parse($request->date_from)->format('Y-M-d');
        $date_to = Carbon::parse($request->date_to)->format('Y-M-d');

       /* $rr = [];
        $rr['plant_id']  =$plant_id;
        $rr['it_name']  =$it_name;
        $rr['ist_name']  =$ist_name;
        $rr['icat_name']  =$icat_name;
        $rr['date_from']  =$date_from;
        $rr['date_to']  =$date_to;

        return response()->json(['res' => $rr]);*/



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


      /*  $qry = DB::SELECT("select it_name,ist_name,icat_name,COMPANY_CODE,plant_id,ITEM_NAME,CWIP_ID,MAIN_ID,GL,COST_CENTER,QTY,UNIT,UNIT_PRICE,ORIGIN_PLANT,USER_NAME,DEPARTMENT,REASON,STATUS,REMARKS,create_date
                from(    
                 select 'ALL' all_data,it_name,ist_name,icat_name,COMPANY_CODE,its.plant_id,its.ITEM_NAME,its.CWIP_ID,its.MAIN_ID,its.GL,
                 its.COST_CENTER,its.QTY,its.UNIT,its.UNIT_PRICE,its.ORIGIN_PLANT,its.USER_NAME,its.DEPARTMENT,its.REASON,its.STATUS,its.REMARKS,its.create_date
               
                 from mis.IT_ITEM_SALES its, mis.it_item_master im
          
                 where its.ITEM_ID = im.ITEM_ID
                 
                )where '$plant_id'= case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
                
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')

            ");

        return response()->json(['res' => $qry]);
*/





        if ($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150') {
            $qry = DB::SELECT("select it_name,ist_name,icat_name,COMPANY_CODE,plant_id,ITEM_ID,ITEM_NAME,CWIP_ID,MAIN_ID,GL,COST_CENTER,QTY,UNIT,UNIT_PRICE,ORIGIN_PLANT,USER_NAME,DEPARTMENT,REASON,STATUS,REMARKS,create_date
                from(    
                 select 'ALL' all_data,it_name,ist_name,icat_name,COMPANY_CODE,its.plant_id,its.ITEM_NAME,its.CWIP_ID,its.MAIN_ID,its.GL,
                 its.COST_CENTER,its.QTY,its.UNIT,its.UNIT_PRICE,its.ORIGIN_PLANT,its.USER_NAME,its.DEPARTMENT,its.REASON,its.STATUS,its.REMARKS,its.create_date,its.item_id
               
                 from mis.IT_ITEM_SALES its, mis.it_item_master im
          
                 where its.ITEM_ID = im.ITEM_ID
                 
                )where '$plant_id'= case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
                
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')

            ");

        } else {

            $qry = DB::SELECT("select it_name,ist_name,icat_name,COMPANY_CODE,plant_id,ITEM_ID,ITEM_NAME,CWIP_ID,MAIN_ID,GL,COST_CENTER,QTY,UNIT,UNIT_PRICE,ORIGIN_PLANT,USER_NAME,DEPARTMENT,REASON,STATUS,REMARKS,create_date,create_user
                from(    
                 select 'ALL' all_data,it_name,ist_name,icat_name,COMPANY_CODE,its.plant_id,its.ITEM_NAME,its.CWIP_ID,its.MAIN_ID,its.GL,
                 its.COST_CENTER,its.QTY,its.UNIT,its.UNIT_PRICE,its.ORIGIN_PLANT,its.USER_NAME,its.DEPARTMENT,its.REASON,its.STATUS,its.REMARKS,its.create_date,its.item_id,its.create_user
                 from mis.IT_ITEM_SALES its, mis.it_item_master im
          
                 where its.ITEM_ID = im.ITEM_ID
                           and its.create_user = '$uid'
                 
                )where '$plant_id'= case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
                
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(create_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')

            ");

        }

        return response()->json(['res' => $qry]);
    }

}