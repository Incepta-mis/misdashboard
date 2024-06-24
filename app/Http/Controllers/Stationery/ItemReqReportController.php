<?php


namespace App\Http\Controllers\Stationery;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class itemReqReportController extends Controller
{
    /*reports*/
    public function reqReport(){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");

        return view('stationery.itemReqReport', ['items'=>$itemData,'cats'=>$catData,'types'=>$types,
            'plantId'=>$plantId,'uid'=>$uid,'allPlants'=>$allPlants,'costCenter'=>$costCenter,'units'=>$units]);


    }


    public function getItemReqData(Request $request){



        DB::setDateFormat("DD-MON-RR");

        $uid = Auth::user()->user_id;

        $plant_id = $request->plant_id;
        $it_name = $request->it_name;
        $ist_name = $request->ist_name;
        $icat_name = $request->icat_name;
        $date_from = Carbon::parse( $request->date_from )->format('Y-M-d');
        $date_to = Carbon::parse( $request->date_to )->format('Y-M-d');

        $test= [];
        $test['item_id'] =$plant_id;
        $test['plant_id'] =$plant_id;
        $test['it_name'] =$it_name;
        $test['ist_name'] =$ist_name;
        $test['date_from'] =$date_from;
        $test['date_to'] =$date_to;
        

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
            $qry = DB::SELECT("select it_name,ist_name,icat_name,company_code, plant_id,ir_no,item_id,item_name,gl,cost_center,
               req_qty,aprv_qty,issu_qty,pen_qty,unit,pr_date,receive_date,approved_date,issue_date
                from(
                select 'ALL' all_data,it_name,ist_name,icat_name,company_code, plant_id,rm.ir_no,im.item_id,im.item_name,rd.gl,rd.cost_center,
                       req_qty,aprv_qty,issu_qty,pen_qty,unit,pr_date,rd.receive_date,rd.approved_date,issue_date
                from mis.it_item_requisition_m rm,mis.it_item_requisition_d rd,mis.it_item_master im
                where rm.ir_no = rd.ir_no
                and rd.item_id = im.item_id
                )where '$plant_id'= case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$it_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(pr_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
            ");
        }else {
            $qry = DB::SELECT("select it_name,ist_name,icat_name,company_code, plant_id,ir_no,item_id,item_name,gl,cost_center,
               req_qty,aprv_qty,issu_qty,pen_qty,unit,pr_date,receive_date,approved_date,issue_date
                from(
                select 'ALL' all_data,it_name,ist_name,icat_name,company_code, plant_id,rm.ir_no,im.item_id,im.item_name,rd.gl,rd.cost_center,
                       req_qty,aprv_qty,issu_qty,pen_qty,unit,pr_date,rd.receive_date,rd.approved_date,issue_date
                from mis.it_item_requisition_m rm,mis.it_item_requisition_d rd,mis.it_item_master im
                where rm.ir_no = rd.ir_no
                and rd.item_id = im.item_id
                and rm.create_user = '$uid'
                )where '$plant_id'= case when '$plant_id' = 'ALL' then all_data else to_char(plant_id) end
                and '$it_name' = case when '$it_name' = 'ALL' then all_data else it_name end
                and '$ist_name' = case when '$it_name' = 'ALL' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = 'ALL' then all_data else icat_name end
                and to_date(pr_date,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
            ");
        }
        
        return response()->json(['res'=>$qry]);
    }


    

}
