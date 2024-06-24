<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepotEmployeeController extends Controller
{
    public function index(){
        $depot_name = Auth::user()->name;
        $urole = Auth::user()->urole;
        $depots = DB::SELECT("SELECT D_ID,NAME DEPOT_NAME FROM DEPOT_ONLINE.DEPOT_INFO@WEB_TO_REPORT WHERE D_ID<50 ORDER BY D_ID"); 
        $desg = DB::select("SELECT DISTINCT DESIGNATION FROM MIS.DEPOT_EMPLOYEE WHERE DESIGNATION IS NOT NULL ORDER BY DESIGNATION ASC");
        return view('depotEmpList',['name'=>$depot_name,'desig'=>$desg,'depots'=>$depots,'urole'=>$urole]);
    }
    public function saveDepotEmp(Request $request){
        $depot = $request->depot;
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $desig = $request->desig;
        $mob = $request->mob;
        $ip_phone = $request->ip_phone;
        $tnt = $request->tnt;
        $group = $request->group;
        $date = Carbon::now()->format('Y-m-d H:m:s');
        $depot_new = "";

        if (strpos($depot, "'") !== FALSE){
            $depot_new = str_replace("'", "''", $depot);
        }

        if($depot_new == ""){
            $depotDetail = DB::SELECT("SELECT D_ID,NAME DEPOT_NAME FROM DEPOT_ONLINE.DEPOT_INFO@WEB_TO_REPORT WHERE NAME = '$depot' AND D_ID<50 ORDER BY D_ID");
        }else{
            $depotDetail = DB::SELECT("SELECT D_ID,NAME DEPOT_NAME FROM DEPOT_ONLINE.DEPOT_INFO@WEB_TO_REPORT WHERE NAME = '$depot_new' AND D_ID<50 ORDER BY D_ID");
        }
        

        if(count($depotDetail) > 0){
            $d_id = $depotDetail[0]->d_id;

            $data = DB::select("SELECT MAX(ID) max_id FROM MIS.DEPOT_EMPLOYEE");
            $max_id = $data[0]->max_id;
            $max_id++;
            $result =  DB::insert('insert into MIS.DEPOT_EMPLOYEE (ID, DEPOT_ID, DEPOT_NAME, EMP_ID, EMP_NAME, DESIGNATION, 
                                MOBILE_NUMBER, IP_PHONE, TNT_PHONE, WORK_GROUP, CREATE_DATE)
                               values (?,?,?,?,?,?,?,?,?,?,?)',[$max_id, $d_id, $depot, $emp_id,$emp_name,$desig,
                $mob,$ip_phone,$tnt,$group,$date]);
            return response()->json(['status'=>1,'res'=>$result]);
        }else{
            return response()->json(['status'=>0,'res'=>[]]);
        }
    }
    public function getDepotEmpList(){

        $depot_name = Auth::user()->name;
        $urole = Auth::user()->urole;
        $depot_name_new = "";

        if (strpos($depot_name, "'") !== FALSE){
            $depot_name_new = str_replace("'", "''", $depot_name);
        }

        if($depot_name == 'ALL DEPOT'){
            $qry = DB::SELECT("SELECT * FROM MIS.DEPOT_EMPLOYEE ORDER BY DEPOT_ID ASC");
        }else if($depot_name != 'ALL DEPOT' && $urole == 1){
            $qry = DB::SELECT("SELECT * FROM MIS.DEPOT_EMPLOYEE ORDER BY DEPOT_ID ASC");
        }else{
            if($depot_name_new == ""){
                $qry = DB::SELECT("SELECT * FROM MIS.DEPOT_EMPLOYEE WHERE DEPOT_NAME = '$depot_name' ORDER BY DEPOT_ID ASC");
            }else{
                $qry = DB::SELECT("SELECT * FROM MIS.DEPOT_EMPLOYEE WHERE DEPOT_NAME = '$depot_name_new' ORDER BY DEPOT_ID ASC");
            }
           
        }
        
        return response()->json(['data'=>$qry]);
    }
    public function editDepotEmpInfo(Request $request){

        $edit_tbl_id = $request->edit_tbl_id;
        $e_depot_id = $request->e_depot_id;
        $e_depot = $request->e_depot;
        $e_emp_id = $request->e_emp_id;
        $e_emp_name = $request->e_emp_name;
        $e_desig = $request->e_desig;
        $e_mob = $request->e_mob;
        $e_ip = $request->e_ip;
        $e_tnt = $request->e_tnt;
        $e_group = $request->e_group;

        $date = Carbon::now()->format('Y-m-d H:m:s');

        if($edit_tbl_id != "" && $e_depot_id != "" && $e_depot != "" && $e_emp_id != "" && $e_emp_name != "" && $e_desig != "" && $e_mob != "" && $e_ip != "" && $e_tnt != "" && $e_group != ""){
            $result =  DB::UPDATE("
                    UPDATE MIS.DEPOT_EMPLOYEE
                    SET EMP_ID = '$e_emp_id',
                        EMP_NAME = '$e_emp_name',
                        DESIGNATION = '$e_desig',
                        MOBILE_NUMBER = '$e_mob',
                        IP_PHONE = '$e_ip',
                        TNT_PHONE = '$e_tnt',
                        WORK_GROUP = '$e_group',
                        UPDATE_DATE = '$date'
                    WHERE ID = '$edit_tbl_id'");

            return response()->json(['response'=> $result]);
        }else{
            return response()->json(['response'=> 2]);
        }
    }
    public function deleteDepotEmpInfo(Request $request){
        $id = $request->id;
        if($id != ""){
            $result =  DB::DELETE('DELETE FROM MIS.DEPOT_EMPLOYEE WHERE ID = ?',[$id]);
            return response()->json(['result'=> $result]);
        }else{
            return response()->json(['result'=> 2]);
        }
    }
}
