<?php



namespace App\Http\Controllers\Stationery;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




class itemUsesReportController
{
    /*reports*/
    public function item_uses_report(){
        return view('stationery.itemUsesReport');
    }

    public function getUsesDetails(Request $request){

        $user_id = Auth::user()->user_id;

        $reportData = DB::SELECT("SELECT DISTINCT d.ITEM_ID, b.CREATE_USER user_id, a.COMPANY_CODE, a.PLANT_ID, b.IUR_NO, b.IR_NO,d.ITEM_NAME,d.ISSU_QTY,d.RECEV_QTY,b.USE_QTY,d.RECEIVE_DATE,b.CREATE_DATE  FROM 
        IT_ITEM_ISSUE_USAGE_M a INNER JOIN IT_ITEM_ISSUE_USAGE_D b ON a.IUR_NO = b.IUR_NO 
        INNER JOIN IT_ITEM_RECEIVE_M c ON c.IR_NO = b.IR_NO 
        INNER JOIN IT_ITEM_RECEIVE_D d on d.ITEM_ID = b.ITEM_ID WHERE b.CREATE_USER='$user_id'");

        if($reportData){
            return response()->json(['result'=>$reportData]);

        }else{
            return response()->json(['result'=>'error']);

        }
    }



    public function getIssuedItem(){
        $user_id = Auth::user()->user_id;
        if(Auth::user()->user_id == 'CDMHO'){
            $ir_no = DB::SELECT("Select distinct IR_NO from MIS.IT_ITEM_REQUISITION_D");
        }else{

            $ir_no = DB::SELECT("Select DISTINCT ir_no from  MIS.IT_ITEM_REQUISITION_D WHERE APPROVED_DATE IS NULL AND CREATE_USER ='$user_id'");
        }

        if($ir_no){
            return response()->json($ir_no);
        }else{
            return response()->json("error");
        }
    }


    /*Item Uses Two*/
    public function item_uses_report_two(){
        $catData = DB::select("SELECT * FROM MIS.IT_CATEGORY");
        $types = DB::select("SELECT DISTINCT(IT_NAME) TYPE,IT_ID  FROM MIS.IT_ITEM_TYPE_MASTER");
        $itemData = DB::select("SELECT * FROM MIS.IT_ITEM_MASTER ORDER BY ITEM_ID");
        $plantId = Auth::user()->plant_id;
        $uid = Auth::user()->user_id;
        $allPlants = DB::select("select distinct plant_id,plant_name from hrms.plant_info@WEB_TO_HRMS
                            where com_id=1 order by plant_id");
        $costCenter = DB::select("SELECT * FROM MIS.IT_COST_CENTER WHERE PLANT_ID = '$plantId' AND COMPANY_CODE = 1000 ORDER BY COST_CENTER_ID ASC");
        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");

        return view('stationery.itemUseReport', ['items' => $itemData, 'cats' => $catData, 'types' => $types,
            'plantId' => $plantId, 'uid' => $uid, 'allPlants' => $allPlants, 'costCenter' => $costCenter, 'units' => $units]);

    }

    /*Item Uses two*/
    public function gteItemUsesDetails(Request $request){

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


      /*  if($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150'){

            $reportData = DB::SELECT("  
        select it_name,ist_name,icat_name,ITEM_ID,CREATE_USER,COMPANY_CODE,PLANT_ID,IUR_NO,IR_NO,ITEM_NAME,ISSU_QTY,RECEV_QTY,USE_QTY,RECEIVE_DATE,CREATE_DATE 
                from(    
                   
                select 'ALL' all_data,im.it_name,im.ist_name,im.icat_name, d.ITEM_ID, b.CREATE_USER , a.COMPANY_CODE, a.PLANT_ID, b.IUR_NO, b.IR_NO,d.ITEM_NAME,d.ISSU_QTY,d.RECEV_QTY,b.USE_QTY,d.RECEIVE_DATE,b.CREATE_DATE  FROM 
                IT_ITEM_ISSUE_USAGE_M a,mis.it_item_master im
                , IT_ITEM_ISSUE_USAGE_D b,IT_ITEM_RECEIVE_M c,IT_ITEM_RECEIVE_D d where  b.item_id = im.item_id and a.IUR_NO = b.IUR_NO and c.IR_NO = b.IR_NO and d.ITEM_ID = b.ITEM_ID 
    
                )where '$plant_id'= case when '$plant_id' = '$plant_id' then all_data else to_char(plant_id) end
                
                and '$it_name' = case when '$it_name' = '$it_name' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = '$ist_name' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = '$icat_name' then all_data else icat_name end
                and to_date(CREATE_DATE,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
                  
            ");

        }else {

            $reportData = DB::SELECT("  
            select it_name,ist_name,icat_name,ITEM_ID,CREATE_USER,COMPANY_CODE,PLANT_ID,IUR_NO,IR_NO,ITEM_NAME,ISSU_QTY,RECEV_QTY,USE_QTY,RECEIVE_DATE,CREATE_DATE 
                from(    
                   
                select 'ALL' all_data,im.it_name,im.ist_name,im.icat_name, d.ITEM_ID, b.CREATE_USER , a.COMPANY_CODE, a.PLANT_ID, b.IUR_NO, b.IR_NO,d.ITEM_NAME,d.ISSU_QTY,d.RECEV_QTY,b.USE_QTY,d.RECEIVE_DATE,b.CREATE_DATE  FROM 
                IT_ITEM_ISSUE_USAGE_M a,mis.it_item_master im
                , IT_ITEM_ISSUE_USAGE_D b,IT_ITEM_RECEIVE_M c,IT_ITEM_RECEIVE_D d where  b.item_id = im.item_id and a.IUR_NO = b.IUR_NO and c.IR_NO = b.IR_NO and d.ITEM_ID = b.ITEM_ID
                                                                                    and b.CREATE_USER='$uid'
    
                )where '$plant_id'= case when '$plant_id' = '$plant_id' then all_data else to_char(plant_id) end
                
                and '$it_name' = case when '$it_name' = '$it_name' then all_data else it_name end
                and '$ist_name' = case when '$ist_name' = '$ist_name' then all_data else ist_name end
                and '$icat_name' = case when '$icat_name' = '$icat_name' then all_data else icat_name end
                and to_date(CREATE_DATE,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
                  
            ");

        }*/

        if($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150'){

            $reportData = DB::SELECT("  
            SELECT im.it_name,im.ist_name,im.icat_name, d.ITEM_ID, b.CREATE_USER , a.COMPANY_CODE, a.PLANT_ID, b.IUR_NO, b.IR_NO,d.ITEM_NAME,d.ISSU_QTY,d.RECEV_QTY,b.USE_QTY,d.RECEIVE_DATE,b.CREATE_DATE  FROM 
                IT_ITEM_ISSUE_USAGE_M a,mis.it_item_master im
                , IT_ITEM_ISSUE_USAGE_D b,IT_ITEM_RECEIVE_M c,IT_ITEM_RECEIVE_D d 
                WHERE  b.item_id = im.item_id and a.IUR_NO = b.IUR_NO and c.IR_NO = b.IR_NO and d.ITEM_ID = b.ITEM_ID 
                AND a.PLANT_ID = decode('$plant_id','ALL',a.PLANT_ID,'$plant_id') 
                AND im.IT_NAME = decode('$it_name','ALL',im.IT_NAME,'$it_name') 
                AND im.IST_NAME = decode('$ist_name','ALL',im.IST_NAME,'$ist_name') 
                AND im.ICAT_NAME = decode('$icat_name','ALL',im.ICAT_NAME,'$icat_name') 
                AND to_date(b.CREATE_DATE,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
                  
            ");

        }else {

            $reportData = DB::SELECT("  
            SELECT im.it_name,im.ist_name,im.icat_name, d.ITEM_ID, b.CREATE_USER , a.COMPANY_CODE, a.PLANT_ID, b.IUR_NO, b.IR_NO,d.ITEM_NAME,d.ISSU_QTY,d.RECEV_QTY,b.USE_QTY,d.RECEIVE_DATE,b.CREATE_DATE  FROM 
                IT_ITEM_ISSUE_USAGE_M a,mis.it_item_master im
                , IT_ITEM_ISSUE_USAGE_D b,IT_ITEM_RECEIVE_M c,IT_ITEM_RECEIVE_D d 
                WHERE  b.item_id = im.item_id and a.IUR_NO = b.IUR_NO and c.IR_NO = b.IR_NO and d.ITEM_ID = b.ITEM_ID and  b.CREATE_USER='$uid'
                AND a.PLANT_ID = decode('$plant_id','ALL',a.PLANT_ID,'$plant_id') 
                AND im.IT_NAME = decode('$it_name','ALL',im.IT_NAME,'$it_name') 
                AND im.IST_NAME = decode('$ist_name','ALL',im.IST_NAME,'$ist_name') 
                AND im.ICAT_NAME = decode('$icat_name','ALL',im.ICAT_NAME,'$icat_name') 
                AND to_date(b.CREATE_DATE,'DD-MON-RR') between to_date('$date_from','RRRR-MON-DD') AND to_date('$date_to','RRRR-MON-DD')
                  
            ");
        }

        return response()->json(['res'=>$reportData]);

    }

}
