<?php

namespace App\Http\Controllers\ImportManagement;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommittedReportController extends Controller
{
    public function index(){
        return view('import_portal.committedReport');
    }
    public function getCommittedReport(Request $request){
        $coms = DB::SELECT('SELECT DISTINCT a.COM_OR_PLANT,b.COM_NAME FROM MIS.SCM_MATERIAL_PURCHASE_INFO a INNER JOIN HRMS.COMPANY_INFO@WEB_TO_HRMS b ON a.COM_OR_PLANT = b.COM_ID ORDER BY a.COM_OR_PLANT');

        $prod_type = isset($request->prod_type) ? $request->prod_type : "";
        $acc_date = isset($request->acc_date) ? Carbon::parse($request->acc_date)->format('Y-m-d H:i:s') : "";
        $payment_status = isset($request->payment_status) ? $request->payment_status : "";
        $due_date_act_from = isset($request->due_date_act_from) ? Carbon::parse($request->due_date_act_from)->format('Y-m') : "";
        $due_date_act_to = isset($request->due_date_act_to) ? Carbon::parse($request->due_date_act_to)->format('Y-m') : "";

        if(count($coms) > 0){
            $company = [];
            foreach ($coms as $com){
                $company[$com->com_or_plant] = $com->com_name;
            }

            if($due_date_act_from != "" && $due_date_act_to != ""){

                $start    = new DateTime($due_date_act_from);
                $end      = new DateTime($due_date_act_to);
                $interval = DateInterval::createFromDateString('1 month');
                $period   = new DatePeriod($start, $interval, $end);

                $timeArr = [];
                foreach ($period as $dt) {
                    $temp = [];
                    $temp['month_year'] = $dt->format("M-y");
                    $temp['start'] = Carbon::parse(date("Y-m-01", strtotime($dt->format("Y-m"))))->format('Y-m-d');
                    $temp['end'] = Carbon::parse(date("Y-m-t", strtotime($dt->format("Y-m"))))->format('Y-m-d');
                    array_push($timeArr, $temp);
                }

                if(count($timeArr) > 0){
                    $temp = [];
                    $time = strtotime($timeArr[count($timeArr)-1]['month_year']);
                    $final = date("Y-m-d", strtotime("+1 month", $time));
                    $final = new DateTime($final);
                    $temp['month_year'] = $final->format("M-y");
                    $temp['start'] = Carbon::parse(date("Y-m-01", strtotime($final->format("Y-m"))))->format('Y-m-d');
                    $temp['end'] = Carbon::parse(date("Y-m-t", strtotime($final->format("Y-m"))))->format('Y-m-d');
                    array_push($timeArr, $temp);
                }else{
                    $temp = [];
                    $final = new DateTime($due_date_act_from);
                    $temp['month_year'] = $final->format("M-y");
                    $temp['start'] = Carbon::parse(date("Y-m-01", strtotime($final->format("Y-m"))))->format('Y-m-d');
                    $temp['end'] = Carbon::parse(date("Y-m-t", strtotime($final->format("Y-m"))))->format('Y-m-d');
                    array_push($timeArr, $temp);
                }

                $finalArr = [];
                foreach ($coms as $com){
                    $arrRes = [];
                    $arrRes['com_or_plant'] = $company[$com->com_or_plant];
                    $arrRes['result'] = [];
                    foreach ($timeArr as $time){
                        if($prod_type == 'capex'){
                            $qry = "SELECT '".$time['month_year']."',COM_OR_PLANT,ACCEPTANCE_VALUE_IN_BDT FROM MIS.SCM_MATERIAL_PURCHASE_INFO WHERE TYPE_OF_DOC = 'capital' AND";
                        }else{
                            $qry = "SELECT '".$time['month_year']."',COM_OR_PLANT,ACCEPTANCE_VALUE_IN_BDT FROM MIS.SCM_MATERIAL_PURCHASE_INFO WHERE TYPE_OF_DOC IN ('raw','pack') AND";
                        }

                        if($payment_status != ""){
                            if($payment_status == "blank"){
                                $qry .= " PAYMENT_STATUS = 'DUE' AND";
                            }else{
                                $qry .= " PAYMENT_STATUS = 'PAID' AND";
                            }
                        }else{
                            $qry .= " PAYMENT_STATUS = 'DUE' AND";
                        }
                        $qry .= " COM_OR_PLANT = '".$com->com_or_plant."' AND";
                        $qry .= " DUE_DATE_ACTU BETWEEN TO_DATE('".$time['start']."','YYYY-MM-DD') AND TO_DATE('".$time['end']."','YYYY-MM-DD') AND";

                        $qryArr = explode(" ",$qry);
                        if($qryArr[count($qryArr)-1] == "AND"){
                            array_pop($qryArr);
                        }

                        $newqry = implode(" ",$qryArr);

                        $qryRes = DB::SELECT($newqry);

                        $temp = [];
                        $temp['month_year'] = $time['month_year'];
                        $temp['result'] = $qryRes;

                        array_push($arrRes['result'],$temp);
                    }
                    array_push($finalArr,$arrRes);
                }
                $lastRow = [];
                array_push($lastRow,'Grand Total');
                $count = count($timeArr);
                for($j=0;$j<$count;$j++) {
                    $val = 0;
                    for ($i = 0; $i < count($finalArr); $i++) {
                        if (count($finalArr[$i]['result'][$j]['result']) > 0) {
                            foreach ($finalArr[$i]['result'][$j]['result'] as $finalArrRes) {
                                $val += $finalArrRes->acceptance_value_in_bdt;
                            }
                        }
                    }
                    if($val == 0){
                        array_push($lastRow, "");
                    }else{
                        array_push($lastRow, $val);
                    }
                }
                return response()->json(array('result'=>$finalArr,'timeArr'=>$timeArr,'lastRow'=>$lastRow,
                    'acc_date'=>0));
            }else if($acc_date != ""){
                $acc_date = Carbon::parse($acc_date)->format('Y-m-d');

                $timeArr = [];
                $temp = [];
                $temp['month_year'] = $acc_date;
                array_push($timeArr, $temp);

                $finalArr = [];
                foreach ($coms as $com){
                    $arrRes = [];
                    $arrRes['com_or_plant'] = $company[$com->com_or_plant];
                    $arrRes['result'] = [];

                    if($prod_type == 'capex'){
                        $qry = "SELECT '".$acc_date."' ACCEPTANCE_DATE,COM_OR_PLANT,ACCEPTANCE_VALUE_IN_BDT FROM MIS.SCM_MATERIAL_PURCHASE_INFO WHERE TYPE_OF_DOC = 'capital' AND";
                    }else{
                        $qry = "SELECT '".$acc_date."' ACCEPTANCE_DATE,COM_OR_PLANT,ACCEPTANCE_VALUE_IN_BDT FROM MIS.SCM_MATERIAL_PURCHASE_INFO WHERE TYPE_OF_DOC IN ('raw','pack') AND";
                    }

                    if($payment_status != ""){
                        if($payment_status == "blank"){
                            $qry .= " PAYMENT_STATUS = 'DUE' AND";
                        }else{
                            $qry .= " PAYMENT_STATUS = 'PAID' AND";
                        }
                    }else{
                        $qry .= " PAYMENT_STATUS = 'DUE' AND";
                    }
                    $qry .= " COM_OR_PLANT = '".$com->com_or_plant."' AND";
                    $qry .= " ACCEPTANCE_DATE = TO_DATE('".$acc_date."','YYYY-MM-DD') AND";

                    $qryArr = explode(" ",$qry);
                    if($qryArr[count($qryArr)-1] == "AND"){
                        array_pop($qryArr);
                    }

                    $newqry = implode(" ",$qryArr);

                    $qryRes = DB::SELECT($newqry);

                    $temp = [];
                    $temp['month_year'] = $acc_date;
                    $temp['result'] = $qryRes;

                    array_push($arrRes['result'],$temp);

                    array_push($finalArr,$arrRes);
                }
                $lastRow = [];
                array_push($lastRow,'Grand Total');
                $count = 1;
                for($j=0;$j<$count;$j++) {
                    $val = 0;
                    for ($i = 0; $i < count($finalArr); $i++) {
                        if (count($finalArr[$i]['result'][$j]['result']) > 0) {
                            foreach ($finalArr[$i]['result'][$j]['result'] as $finalArrRes) {
                                $val += $finalArrRes->acceptance_value_in_bdt;
                            }
                        }
                    }
                    if($val == 0){
                        array_push($lastRow, "");
                    }else{
                        array_push($lastRow, $val);
                    }
                }
                return response()->json(array('result'=>$finalArr,'timeArr'=>$timeArr,'lastRow'=>$lastRow,
                    'acc_date'=>1));
            }else{
                $maxMinDate = DB::SELECT('SELECT MIN(DUE_DATE_ACTU) min_date,MAX(DUE_DATE_ACTU) max_date FROM MIS.SCM_MATERIAL_PURCHASE_INFO');
                if(count($maxMinDate) > 0){
                    $min_date = $maxMinDate[0]->min_date;
                    $max_date = $maxMinDate[0]->max_date;
                    $start    = new DateTime($min_date);
                    $end      = new DateTime($max_date);
                    $interval = DateInterval::createFromDateString('1 month');
                    $period   = new DatePeriod($start, $interval, $end);

                    $timeArr = [];
                    foreach ($period as $dt) {
                        $temp = [];
                        $temp['month_year'] = $dt->format("M-y");
                        $temp['start'] = Carbon::parse(date("Y-m-01", strtotime($dt->format("Y-m"))))->format('Y-m-d');
                        $temp['end'] = Carbon::parse(date("Y-m-t", strtotime($dt->format("Y-m"))))->format('Y-m-d');
                        array_push($timeArr, $temp);
                    }

                    if(count($timeArr) > 0){
                        $temp = [];
                        $time = strtotime($timeArr[count($timeArr)-1]['month_year']);
                        $final = date("Y-m-d", strtotime("+1 month", $time));
                        $final = new DateTime($final);
                        $temp['month_year'] = $final->format("M-y");
                        $temp['start'] = Carbon::parse(date("Y-m-01", strtotime($final->format("Y-m"))))->format('Y-m-d');
                        $temp['end'] = Carbon::parse(date("Y-m-t", strtotime($final->format("Y-m"))))->format('Y-m-d');
                        array_push($timeArr, $temp);
                    }else{
                        $temp = [];
                        $final = new DateTime($min_date);
                        $temp['month_year'] = $final->format("M-y");
                        $temp['start'] = Carbon::parse(date("Y-m-01", strtotime($final->format("Y-m"))))->format('Y-m-d');
                        $temp['end'] = Carbon::parse(date("Y-m-t", strtotime($final->format("Y-m"))))->format('Y-m-d');
                        array_push($timeArr, $temp);
                    }

                    $finalArr = [];
                    foreach ($coms as $com){
                        $arrRes = [];
                        $arrRes['com_or_plant'] = $company[$com->com_or_plant];
                        $arrRes['result'] = [];
                        foreach ($timeArr as $time){
                            if($prod_type == 'capex'){
                                $qry = "SELECT '".$time['month_year']."',COM_OR_PLANT,ACCEPTANCE_VALUE_IN_BDT FROM MIS.SCM_MATERIAL_PURCHASE_INFO WHERE TYPE_OF_DOC = 'capital' AND";
                            }else{
                                $qry = "SELECT '".$time['month_year']."',COM_OR_PLANT,ACCEPTANCE_VALUE_IN_BDT FROM MIS.SCM_MATERIAL_PURCHASE_INFO WHERE TYPE_OF_DOC IN ('raw','pack') AND";
                            }

                            if($payment_status != ""){
                                if($payment_status == "blank"){
                                    $qry .= " PAYMENT_STATUS = 'DUE' AND";
                                }else{
                                    $qry .= " PAYMENT_STATUS = 'PAID' AND";
                                }
                            }else{
                                $qry .= " PAYMENT_STATUS = 'DUE' AND";
                            }
                            $qry .= " COM_OR_PLANT = '".$com->com_or_plant."' AND";
                            $qry .= " DUE_DATE_ACTU BETWEEN TO_DATE('".$time['start']."','YYYY-MM-DD') AND TO_DATE('".$time['end']."','YYYY-MM-DD') AND";

                            $qryArr = explode(" ",$qry);
                            if($qryArr[count($qryArr)-1] == "AND"){
                                array_pop($qryArr);
                            }

                            $newqry = implode(" ",$qryArr);

                            $qryRes = DB::SELECT($newqry);

                            $temp = [];
                            $temp['month_year'] = $time['month_year'];
                            $temp['result'] = $qryRes;

                            array_push($arrRes['result'],$temp);
                        }
                        array_push($finalArr,$arrRes);
                    }
                    $lastRow = [];
                    array_push($lastRow,'Grand Total');
                    $count = count($timeArr);
                    for($j=0;$j<$count;$j++) {
                        $val = 0;
                        for ($i = 0; $i < count($finalArr); $i++) {
                            if (count($finalArr[$i]['result'][$j]['result']) > 0) {
                                foreach ($finalArr[$i]['result'][$j]['result'] as $finalArrRes) {
                                    $val += $finalArrRes->acceptance_value_in_bdt;
                                }
                            }
                        }
                        if($val == 0){
                            array_push($lastRow, "");
                        }else{
                            array_push($lastRow, $val);
                        }
                    }
                    return response()->json(array('result'=>$finalArr,'timeArr'=>$timeArr,'lastRow'=>$lastRow,'acc_date'=>0));
                }else{
                    return response()->json(array('result'=>[]));
                }
            }
        }else{
            return response()->json(array('result'=>[]));
        }
    }
}
