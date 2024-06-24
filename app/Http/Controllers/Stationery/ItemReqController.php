<?php
namespace App\Http\Controllers\Stationery;

use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PayUService\Exception;
use mysql_xdevapi\Table;



class ItemReqController extends Controller
{

    /* public function getCostCenter(){
         $plant_id= Auth::user()->plant_id;
         return response()->json($plant_id);


         $cost_center_id_name = DB::select("Select COST_CENTER_NAME,COST_CENTER_ID from MIS.IT_COST_CENTER where PLANT_ID='$plant_id'");
         if($cost_center_id_name){
             return response()->json($cost_center_id_name);
         }else{
             return response()->json('error');
         }


     }*/

    public function issueItem(){

        $uid= Auth::user()->user_id;
        $plant_id= Auth::user()->plant_id;
        $cost_center_id_name = DB::select("Select COST_CENTER_NAME,COST_CENTER_ID from MIS.IT_COST_CENTER where PLANT_ID='$plant_id'");

        $units = DB::SELECT("SELECT DISTINCT unit FROM MIS.IT_OPENING_STOCK");
        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL FROM MIS.IT_ITEM_MASTER");
        $it_name = DB::select("SELECT DISTINCT IT_NAME FROM MIS.IT_ITEM_MASTER");

        return view('stationery.issue_item', ['item_name'=>$item_name,'cost_center_id_name'=>$cost_center_id_name,'it_name'=>$it_name,'units'=>$units]);


    }
    public function displayIssueItem(Request $request){

        try {

            $item_details = DB::select("SELECT DISTINCT ITEM_NAME,ITEM_ID,GL,COST_CENTER,PR_NUMBER,UNIT  FROM MIS.IT_OPENING_STOCK where ITEM_ID='$request->item_id_search'");

            if($item_details){
                return response()->json($item_details);
            }else{
                return response()->json('error');
            }

        }
        catch (customException $e) {
            echo $e->errorMessage();
        }

    }

    public function createIssue(Request $request){

        $itemdata = $request->data;
        $uid= Auth::user()->user_id;
        $plant_id= Auth::user()->plant_id;


        $data = DB::select("SELECT MAX(CAST(SUBSTR( IR_NO, 8 ) AS INT)) max_id FROM MIS.IT_ITEM_REQUISITION_M");
        $max_id = $data[0]->max_id;
        $max_idd = (int)$max_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($max_id!=''){
            $max_idd++;
            $new_ir_no = "IR".$plant_id.'-'.$max_idd;
        }else{
            $new_ir_no = "IR".$plant_id.'-1';
        }

        //file upload assentials
        $upload_path='';
        $upload_location = public_path('stationary/itemRequisition');
        $errors=[];
        $success=[];
        if(isset($_FILES['file'])){

            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];

            $extensions = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $valid_ext = array("jpg","png","jpeg");
            if(in_array($extensions,$valid_ext)=== false){
                $errors["error"]="ext_error";
                return response()->json($errors);
            }

            if(empty($errors)==true){
                $fineName = basename($file_name);
                $fulFileName =rand(10,10000)."_".$new_ir_no."_".$fineName;
                $fullPath ="$upload_location/$fulFileName";
                $upload_path = 'stationary/itemRequisition/'.$fulFileName;
                move_uploaded_file($file_tmp,$fullPath );

            }

        }


        $issueItemData = json_decode($itemdata, true);
        for($i=0;$i<sizeof($issueItemData);$i++){
            $issueItemData[$i]['IR_NO']= $new_ir_no;
            $issueItemData[$i]['CREATE_USER']= Auth::user()->user_id;
            $issueItemData[$i]['CREATE_DATE']= $date;
            $issueItemData[$i]['RECEIVE_DATE']= '';
            $issueItemData[$i]['APPROVED_DATE']= '';
        }

        $issueItemMaster['IR_NO']= $new_ir_no;
        $issueItemMaster['PR_DATE']= $date;
        $issueItemMaster['COMPANY_CODE']= '1000';
        $issueItemMaster['PLANT_ID']= $plant_id;
        $issueItemMaster['IMAGE_PATH']= $upload_path;
        $issueItemMaster['CREATE_USER']= Auth::user()->user_id;
        $issueItemMaster['CREATE_DATE']= $date;
        $issueItemMaster['RECEIVE_DATE']= '';
        $issueItemMaster['APPROVED_DATE']= '';

        $status = DB::table('MIS.IT_ITEM_REQUISITION_M')->insert($issueItemMaster);
        if($status){
            for($i=0;$i<sizeof($issueItemData);$i++){
                $issueItemData[$i]['IR_NO']= $new_ir_no;
                $issueItemData[$i]['PEN_QTY']= $issueItemData[$i]['req_qty'];
                $issueItemData[$i]['CREATE_USER']= Auth::user()->user_id;
                $issueItemData[$i]['CREATE_DATE']= $date;
                $issueItemData[$i]['RECEIVE_DATE']= '';
                $issueItemData[$i]['APPROVED_DATE']= $date;

            }
            $status = DB::table('MIS.IT_ITEM_REQUISITION_D')->insert($issueItemData);
            if($status){
                $success["success"]="success";
                return response()->json($success);
            }else{
                $errors["error"]="error";
                return response()->json($errors);
            }
        }else{
            $errors["error"]="error";
            return response()->json($errors);
        }

    }

    public function showMyIssue(){
        $uid = Auth::user()->user_id;

        $issue_year = DB::select(" select distinct EXTRACT(YEAR FROM Create_date) leave_year from MIS.IT_ITEM_REQUISITION_M where  CREATE_USER='$uid' ");

        return view('stationery.display_my_issue', ['appData' => $issue_year]);
    }

    public function getMyIssues(Request $request){
        $user_id = Auth::user()->user_id;
        $req_year = $request->req_year;

        if($req_year=='all'){
            $issue_year = DB::select(" select ID,IR_NO,ITEM_ID,ITEM_NAME,GL,COST_CENTER,PR_QTY,APRV_QTY,UNIT,REMARKS,APRV_QTY,APPROVED_DATE from MIS.IT_ITEM_REQUISITION_D 
            where create_user = '$user_id' order by  IR_NO");

        }else{
            $issue_year = DB::select(" select ID,IR_NO,ITEM_ID,ITEM_NAME,GL,COST_CENTER,PR_QTY,APRV_QTY,UNIT,REMARKS,APRV_QTY,APPROVED_DATE from MIS.IT_ITEM_REQUISITION_D where 
            EXTRACT(YEAR FROM Create_date) = '$req_year' and create_user = '$user_id' order by  IR_NO");
        }

        return response()->json($issue_year);

    }

    public function updateIssuedItem(Request $request){




        $table_id = $request->id;

        $decoded_data = json_decode($request->itemArray);


        $edit_ir_no = $decoded_data->edit_ir_no;
        $edit_item_id = $decoded_data->edit_item_id;
        $edit_item_name = $decoded_data->edit_item_name;
        $edit_gl = $decoded_data->edit_gl;
        $edit_cost_center = $decoded_data->edit_cost_center;
        $edit_pr_qty = $decoded_data->edit_pr_qty;
        $unit = $decoded_data->edit_unit;
        $remarks = $decoded_data->edit_remarks;


        $uid = Auth::user()->user_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        $rr =[];
        $rr['ir_no']=$edit_ir_no;
        $rr['item_id']=$edit_item_id;
        $rr['item_name']=$edit_item_name;
        $rr['edit_gl']=$edit_gl;
        $rr['cost_center']=$edit_cost_center;
        $rr['pr_qty']=$edit_pr_qty;
        $rr['unit']=$unit;
        $rr['remarks']=$remarks;


        if($edit_ir_no!=''){
            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_D
                        SET
                            ITEM_ID = '$edit_item_id',
                            ITEM_NAME = '$edit_item_name',
                            GL = '$edit_gl',
                            COST_CENTER = '$edit_cost_center',
                            REQ_QTY = '$edit_pr_qty',
                            APRV_QTY = '$edit_pr_qty',
                            UNIT = '$unit',
                            REMARKS = '$remarks',
                             UPDATE_USER = '$uid',
                            UPDATE_DATE = '$date'
                        WHERE ID = '$table_id'");

            return response()->json(['result'=> $result]);

        }else{

            return response()->json(['result'=> 'error']);
        }

    }

    public function deleteMyIssue(Request $request){

        $id = $request->id;
        $ir_no = $request->ir_no;

        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_REQUISITION_D WHERE ID = ?',[$id]);
            if($result){

                $result =  DB::SELECT('select ir_no FROM MIS.IT_ITEM_REQUISITION_D WHERE IR_NO = ?',[$ir_no]);
                if($result){
                    return response()->json(['result'=> 'true']);
                }else{
                    $result =  DB::DELETE('DELETE FROM MIS.IT_ITEM_REQUISITION_M WHERE IR_NO = ?',[$ir_no]);
                    if($result){
                        return response()->json(['result'=> 'true']);
                    }else{
                        return response()->json(['result'=> 'false']);
                    }
                }

            }else{
                return response()->json(['result'=> 'false']);
            }

        }else{
            return response()->json(['result'=> 2]);
        }
    }

    public function getIssuedItem(){
        $user_id = Auth::user()->user_id;
        if(Auth::user()->user_id == 'CDM_IT'||Auth::user()->user_id == 'CDMDB_7150'){
            $ir_no = DB::SELECT("Select distinct IR_NO from MIS.IT_ITEM_REQUISITION_D");
        }else{

            $ir_no = DB::SELECT("Select DISTINCT ir_no from  MIS.IT_ITEM_REQUISITION_D WHERE CREATE_USER ='$user_id'");
        }

        if($ir_no){
            return response()->json($ir_no);
        }else{
            return response()->json("error");
        }
    }


    public function showIrdata(Request $request){

        $uid = Auth::user()->user_id;
        if($uid=='CDM_IT'|| $uid =='1020386'){

            $issuedItems= DB::SELECT(" Select * from MIS.IT_ITEM_REQUISITION_D where ir_no = '$request->ir_no' and item_id in (select item_id from MIS.IT_ITEM_MASTER_DEV where HO_CDM='$uid')");
            $image_path= DB::SELECT("Select IMAGE_PATH from MIS.IT_ITEM_REQUISITION_M where ir_no = '$request->ir_no'");

            return response()->json(['issuedItems'=>$issuedItems,'image_path'=>$image_path]);
        }

        $issuedItems= DB::SELECT("Select * from MIS.IT_ITEM_REQUISITION_D where ir_no = '$request->ir_no'");
        $image_path= DB::SELECT("Select IMAGE_PATH from MIS.IT_ITEM_REQUISITION_M where ir_no = '$request->ir_no'");
        return response()->json(['issuedItems'=>$issuedItems,'image_path'=>$image_path]);
    }

    public function approveQtyItem(Request $request){
        $table_id = $request->id;
        $approve_qty = $request->aprv_qty;
        $req_qty = $request->req_qty;
        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($approve_qty!=''||$approve_qty!=''){

            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_D 
                        SET
                            APRV_QTY = '$approve_qty',
                            REQ_QTY = '$req_qty',
                              APPROVED_DATE='$date',
                              
                              
                           
                        WHERE ID = '$table_id'");


            return response()->json(['result'=> "success"]);

        }else{

            return response()->json(['result'=> "error"]);

        }
    }
    public function issueQtyItem(Request $request){

        $table_id = $request->id;
        $approve_qty = $request->aprv_qty;
        $issu_qty = $request->issu_qty;
        $ir_no = $request->ir_no;
        $item_id = $request->item_id;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $uid = Auth::user()->user_id;

        $already_issued = DB::SELECT("Select issu_qty from MIS.IT_ITEM_REQUISITION_D where id = '$table_id'");


        $issue_qty = abs($issu_qty+$already_issued[0]->issu_qty);
        $pen_qty = abs($approve_qty-$issue_qty);

        if($approve_qty!=''||$approve_qty!=''){
            $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_D 
                        SET
                            APRV_QTY = '$approve_qty',
                            ISSU_QTY = '$issue_qty',
                            PEN_QTY = '$pen_qty',
                            ISSUE_DATE = '$date'
                          
                           
                        WHERE ID = '$table_id'");

            if($result){
                $log_issue['IR_NO']= $ir_no;
                $log_issue['ITEM_ID']= $item_id;
                $log_issue['ISSU_QTY']= $issu_qty;
                $log_issue['CREATE_DATE']= $date;
                $log_issue['CREATE_USER']= $uid;

                $log_result =  DB::table('MIS.IT_ITEM_REQUISITION_LOG')->insert($log_issue);

                if($log_result){
                    return response()->json(['result'=> "success"]);

                }else{
                    return response()->json(['result'=> "error"]);
                }

            }
            return response()->json(['result'=> "error"]);

        }else{

            return response()->json(['result'=> "error"]);

        }
    }

    public function getProductQty(Request $request){
        $item_id = $request->item_id;
        $table_id = $request->id;
        $uid = Auth::user()->user_id;
        $item_qty=[];
        $item_type=[];

        $plant_id= Auth::user()->plant_id;

        $item_qty = DB::select("SELECT QTY
                        FROM MIS.IT_ITEM_STOCK WHERE ITEM_ID = '$item_id' AND PLANT_ID='$plant_id'");
        if($item_qty){
            $item_qty  =  $item_qty[0]->qty;
        }else{
            $item_qty=null;
        }

        $item_type =  DB::SELECT("select IT_NAME FROM MIS.IT_ITEM_MASTER WHERE ITEM_ID = '$request->item_id'");
        $already_issued = DB::SELECT("Select issu_qty from MIS.IT_ITEM_REQUISITION_D where id = '$table_id'");


        if($item_qty || $item_type ||$already_issued){
            return response()->json(['item_qty'=>$item_qty,'item_type'=> $item_type[0]->it_name,
                'already_issued'=> $already_issued[0]->issu_qty]);
        }else{
            return response()->json(['result'=> 0]);
        }

    }

    public function getItemName(Request $request){

        $it_name = $request->it_name;
        $item_name = DB::select("SELECT DISTINCT ITEM_NAME,IT_ID,GL,ITEM_ID FROM MIS.IT_ITEM_MASTER WHERE IT_NAME = '$it_name'");

        if($item_name){
            return response()->json(['result'=>$item_name]);

        }else{
            return response()->json(['result'=>$item_name]);
        }
    }

    public function updateIssueImg(Request $request){
        $new_ir_no=$request->ir_no;


        //file upload assentials
        $upload_path='';
        $upload_location = public_path('stationary/itemRequisition');
        $errors=[];
        $success=[];
        if(isset($_FILES['file'])){

            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];

            $extensions = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $valid_ext = array("jpg","png","jpeg");
            if(in_array($extensions,$valid_ext)=== false){
                $errors["error"]="ext_error";
                return response()->json($errors);
            }


            if(empty($errors)==true){

                $fineName = basename($file_name);
                $fulFileName =rand(10,10000)."_".$new_ir_no."_".$fineName;
                $fullPath ="$upload_location/$fulFileName";
                $upload_path = 'stationary/itemRequisition/'.$fulFileName;
                move_uploaded_file($file_tmp,$fullPath );

                $result =  DB::UPDATE("
                        UPDATE MIS.IT_ITEM_REQUISITION_M 
                        SET
                            IMAGE_PATH = '$upload_path'
                            
                           
                        WHERE  IR_NO = '$new_ir_no'");


                if($request){
                    $success["success"]="success";
                    return response()->json($success);
                }else{
                    $errors["error"]="error";
                    return response()->json($errors);
                }

            }
        }
    }


}