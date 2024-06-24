<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class BrandRankingReportController extends Controller
{
    public function index(){
        return view('brand_ranking_report');
    }

    public function processBrandData(Request $request){


        set_time_limit(0);
        ini_set('memory_limit',-1);

        DB::setDateFormat('DD-MON-RR');

        $uid = Auth::user()->user_id;

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $date1 = Carbon::parse($date_from)->format('d-M-y');
        $date2 = Carbon::parse($date_to)->format('d-M-y');

//        $date1 = Carbon::parse('01-JAN-21')->format('d-M-y');
//        $date2 = Carbon::parse('01-AUG-22')->format('d-M-y');

        try{
            $procedure = 'MIS.pro_com_product_brand_ranking';

            $bindings = [
                'date1' => $date1,
                'date2' => $date2,
                'log_user' => $uid
            ];

            $result = DB::executeProcedure($procedure,$bindings);

            $sales_type = DB::SELECT("select distinct sales_type from mis.brand_wise_sales_data");
            $rm_terr_id = DB::SELECT("select distinct rm_terr_id from mis.brand_wise_sales_data");
            $am_terr_id = DB::SELECT("select distinct am_terr_id from mis.brand_wise_sales_data");
            $terr_id = DB::SELECT("select distinct terr_id from mis.brand_wise_sales_data");
            $brand_name = DB::SELECT("select distinct brand_name from mis.brand_wise_sales_data order by brand_name asc");

//            DB::delete("delete from mis.brand_wise_sales_data where create_user = '$uid'");

            return response()->json(['response'=>$result,'sales_type'=>$sales_type, 'rm_terr_id'=>$rm_terr_id,
                'am_terr_id'=>$am_terr_id, 'terr_id'=>$terr_id, 'brand_name'=>$brand_name]);

        }catch (Oci8Exception $e){
            $result = $e->getMessage();
            return response()->json(['response'=>$result,'sales_type'=>"", 'rm_terr_id'=>"", 'am_terr_id'=>"", 'terr_id'=>""]);
        }
    }
    public function previewBrandData(Request $request){

        set_time_limit(0);
        ini_set('memory_limit',-1);

        $uid = Auth::user()->user_id;

        $channel = $request->channel;
        $region = $request->region;
        $terr1 = $request->terr1;
        $terr2 = $request->terr2;
        $brand_name = $request->brand_name;

        DB::delete("delete from mis.brand_wise_sales_report where create_user = '$uid'");

        $result = DB::INSERT("insert into mis.brand_wise_sales_report
                        select pc_sd.company_name,pc_sd.brand_name,pc_sd.product_strength,pc_sd.sap_code,pc_sd.p_code,pc_sd.p_name,
                               p_cmr_sold_qty,p_pmr_sold_qty,p_cmr_sold_value,p_pmr_sold_value,       
                               case when nvl(p_cmr_sold_value,0) - nvl(p_pmr_sold_value,0) = 0 then 'EQUAL'
                               else case when nvl(p_cmr_sold_value,0) - nvl(p_pmr_sold_value,0) > 0 then 'UP' else 'DOWN' end end p_growth_indicate,       
                               case when nvl(ps_cmr_sold_value,0) - nvl(ps_pmr_sold_value,0) = 0 then 'EQUAL'       
                               else case when nvl(ps_cmr_sold_value,0) - nvl(ps_pmr_sold_value,0) > 0 then 'UP' else 'DOWN' end end ps_growth_indicate,       
                               case when nvl(pb_cmr_sold_value,0) - nvl(pb_pmr_sold_value,0) = 0 then 'EQUAL'
                               else case when nvl(pb_cmr_sold_value,0) - nvl(pb_pmr_sold_value,0) > 0 then 'UP' else 'DOWN' end end pb_growth_indicate,              
                               pcode_cmr_sl,pcode_pmr_sl,ps_cmr_sl,ps_pmr_sl,pb_cmr_sl,pb_pmr_sl,       
                               round(((p_cmr_sold_value * 100) / cmr_sold_value),2) p_cmr_contribution,round(((p_pmr_sold_value * 100) / pmr_sold_value),2) p_pmr_contribution,       
                               round(((ps_cmr_sold_value * 100) / cmr_sold_value),2) ps_cmr_contribution,round(((ps_pmr_sold_value * 100) / pmr_sold_value),2) ps_pmr_contribution,       
                               round(((pb_cmr_sold_value * 100) / cmr_sold_value),2) pb_cmr_contribution,round(((pb_pmr_sold_value * 100) / pmr_sold_value),2) pb_pmr_contribution,
                               cur_month_range,pre_month_range,sysdate,'$uid'
                        from
                        (select sum(nvl(cmr_sold_qty,0)) cmr_sold_qty,sum(nvl(cmr_sold_value,0)) cmr_sold_value,
                               sum(nvl(pmr_sold_qty,0)) pmr_sold_qty,sum(nvl(pmr_sold_value,0)) pmr_sold_value 
                        from(
                        select 'ALL' all_data,sales_type,cur_month_range,pre_month_range,company_code,company_name,p_group,brand_name,product_strength,sap_code,p_code,p_name,
                               rm_terr_id,am_terr_id,terr_id,cmr_sold_qty,cmr_sold_value,pmr_sold_qty,pmr_sold_value
                        from mis.brand_wise_sales_data where create_user = '$uid'
                        )where '$channel' = case when '$channel' = 'ALL' then all_data else sales_type end
                        and '$region' = case when '$region' = 'ALL' then all_data else rm_terr_id end
                        and '$terr1' = case when '$terr1' = 'ALL' then all_data else am_terr_id end
                        and '$terr2' = case when '$terr2' = 'ALL' then all_data else terr_id end
                        and '$brand_name' = case when '$brand_name' = 'ALL' then all_data else brand_name end
                       
                        ) tot_sale,
                        (select brand_name,sum(nvl(cmr_sold_qty,0)) pb_cmr_sold_qty,sum(nvl(cmr_sold_value,0)) pb_cmr_sold_value,sum(nvl(pmr_sold_qty,0)) pb_pmr_sold_qty,
                               sum(nvl(pmr_sold_value,0)) pb_pmr_sold_value,sum(nvl(pb_cmr_sl,0)) pb_cmr_sl,sum(nvl(pb_pmr_sl,0)) pb_pmr_sl
                        from
                        (select brand_name,cmr_sold_qty,cmr_sold_value,0 pmr_sold_qty,0 pmr_sold_value,rownum pb_cmr_sl,0 pb_pmr_sl
                        from(
                        select brand_name,cmr_sold_qty,cmr_sold_value
                        from
                        (
                        select brand_name,sum(nvl(cmr_sold_qty,0)) cmr_sold_qty,sum(nvl(cmr_sold_value,0)) cmr_sold_value
                        from(
                        select 'ALL' all_data,sales_type,cur_month_range,pre_month_range,company_code,company_name,p_group,brand_name,product_strength,sap_code,p_code,p_name,
                               rm_terr_id,am_terr_id,terr_id,cmr_sold_qty,cmr_sold_value,pmr_sold_qty,pmr_sold_value
                        from mis.brand_wise_sales_data where create_user = '$uid'
                        )where '$channel' = case when '$channel' = 'ALL' then all_data else sales_type end
                        and '$region' = case when '$region' = 'ALL' then all_data else rm_terr_id end
                        and '$terr1' = case when '$terr1' = 'ALL' then all_data else am_terr_id end
                        and '$terr2' = case when '$terr2' = 'ALL' then all_data else terr_id end
                        and '$brand_name' = case when '$brand_name' = 'ALL' then all_data else brand_name end
                        group by brand_name
                        )order by cmr_sold_value desc)
                        union all
                        select brand_name,0 cmr_sold_qty,0 cmr_sold_value,pmr_sold_qty,pmr_sold_value,0 pb_cmr_sl,rownum pb_pmr_sl
                        from(
                        select brand_name,pmr_sold_qty,pmr_sold_value
                        from
                        (
                        select brand_name,sum(nvl(pmr_sold_qty,0)) pmr_sold_qty,sum(nvl(pmr_sold_value,0)) pmr_sold_value 
                        from(
                        select 'ALL' all_data,sales_type,cur_month_range,pre_month_range,company_code,company_name,p_group,brand_name,product_strength,sap_code,p_code,p_name,
                               rm_terr_id,am_terr_id,terr_id,cmr_sold_qty,cmr_sold_value,pmr_sold_qty,pmr_sold_value
                        from mis.brand_wise_sales_data where create_user = '$uid'
                        )where '$channel' = case when '$channel' = 'ALL' then all_data else sales_type end
                        and '$region' = case when '$region' = 'ALL' then all_data else rm_terr_id end
                        and '$terr1' = case when '$terr1' = 'ALL' then all_data else am_terr_id end
                        and '$terr2' = case when '$terr2' = 'ALL' then all_data else terr_id end
                        and '$brand_name' = case when '$brand_name' = 'ALL' then all_data else brand_name end
                        group by brand_name
                        )order by pmr_sold_value desc)
                        )group by brand_name) pb_sd,
                        (select brand_name,product_strength,sum(nvl(cmr_sold_qty,0)) ps_cmr_sold_qty,sum(nvl(cmr_sold_value,0)) ps_cmr_sold_value,sum(nvl(pmr_sold_qty,0)) ps_pmr_sold_qty,
                               sum(nvl(pmr_sold_value,0)) ps_pmr_sold_value,sum(nvl(ps_cmr_sl,0)) ps_cmr_sl,sum(nvl(ps_pmr_sl,0)) ps_pmr_sl 
                        from(
                        select brand_name,product_strength,cmr_sold_qty,cmr_sold_value,0 pmr_sold_qty,0 pmr_sold_value,rownum ps_cmr_sl,0 ps_pmr_sl
                        from(
                        select brand_name,product_strength,cmr_sold_qty,cmr_sold_value
                        from
                        (
                        select brand_name,product_strength,sum(nvl(cmr_sold_qty,0)) cmr_sold_qty,sum(nvl(cmr_sold_value,0)) cmr_sold_value        
                        from(
                        select 'ALL' all_data,sales_type,cur_month_range,pre_month_range,company_code,company_name,p_group,brand_name,product_strength,sap_code,p_code,p_name,
                               rm_terr_id,am_terr_id,terr_id,cmr_sold_qty,cmr_sold_value,pmr_sold_qty,pmr_sold_value
                        from mis.brand_wise_sales_data where create_user = '$uid'
                        )where '$channel' = case when '$channel' = 'ALL' then all_data else sales_type end
                        and '$region' = case when '$region' = 'ALL' then all_data else rm_terr_id end
                        and '$terr1' = case when '$terr1' = 'ALL' then all_data else am_terr_id end
                        and '$terr2' = case when '$terr2' = 'ALL' then all_data else terr_id end
                        and '$brand_name' = case when '$brand_name' = 'ALL' then all_data else brand_name end
                        group by brand_name,product_strength
                        )order by cmr_sold_value desc)
                        union all
                        select brand_name,product_strength,0 cmr_sold_qty,0 cmr_sold_value,pmr_sold_qty,pmr_sold_value,0 ps_cmr_sl,rownum ps_pmr_sl
                        from(
                        select brand_name,product_strength,pmr_sold_qty,pmr_sold_value
                        from
                        (
                        select brand_name,product_strength,sum(nvl(pmr_sold_qty,0)) pmr_sold_qty,sum(nvl(pmr_sold_value,0)) pmr_sold_value 
                        from(
                        select 'ALL' all_data,sales_type,cur_month_range,pre_month_range,company_code,company_name,p_group,brand_name,product_strength,sap_code,p_code,p_name,
                               rm_terr_id,am_terr_id,terr_id,cmr_sold_qty,cmr_sold_value,pmr_sold_qty,pmr_sold_value
                        from mis.brand_wise_sales_data where create_user = '$uid'
                        )where '$channel' = case when '$channel' = 'ALL' then all_data else sales_type end
                        and '$region' = case when '$region' = 'ALL' then all_data else rm_terr_id end
                        and '$terr1' = case when '$terr1' = 'ALL' then all_data else am_terr_id end
                        and '$terr2' = case when '$terr2' = 'ALL' then all_data else terr_id end
                        and '$brand_name' = case when '$brand_name' = 'ALL' then all_data else brand_name end
                        group by brand_name,product_strength
                        )order by pmr_sold_value desc)
                        )group by brand_name,product_strength) ps_sd,
                        (select company_name,brand_name,product_strength,sap_code,p_code,p_name,sum(nvl(cmr_sold_qty,0)) p_cmr_sold_qty,
                                sum(nvl(cmr_sold_value,0)) p_cmr_sold_value,sum(nvl(pmr_sold_qty,0)) p_pmr_sold_qty,sum(nvl(pmr_sold_value,0)) p_pmr_sold_value,
                                sum(nvl(pcode_cmr_sl,0)) pcode_cmr_sl,sum(nvl(pcode_pmr_sl,0)) pcode_pmr_sl,cur_month_range,pre_month_range 
                        from(
                        select company_name,brand_name,product_strength,sap_code,p_code,p_name,cmr_sold_qty,cmr_sold_value,0 pmr_sold_qty,
                               0 pmr_sold_value,rownum pcode_cmr_sl,0 pcode_pmr_sl,cur_month_range,pre_month_range
                        from(
                        select company_name,brand_name,product_strength,sap_code,p_code,p_name,cmr_sold_qty,cmr_sold_value,cur_month_range,pre_month_range 
                        from
                        (
                        select company_name,brand_name,product_strength,sap_code,p_code,p_name,sum(nvl(cmr_sold_qty,0)) cmr_sold_qty,
                               sum(nvl(cmr_sold_value,0)) cmr_sold_value,cur_month_range,pre_month_range 
                        from(
                        select 'ALL' all_data,sales_type,cur_month_range,pre_month_range,company_code,company_name,p_group,brand_name,product_strength,sap_code,p_code,p_name,
                               rm_terr_id,am_terr_id,terr_id,cmr_sold_qty,cmr_sold_value,pmr_sold_qty,pmr_sold_value 
                        from mis.brand_wise_sales_data where create_user = '$uid'
                        )where '$channel' = case when '$channel' = 'ALL' then all_data else sales_type end
                        and '$region' = case when '$region' = 'ALL' then all_data else rm_terr_id end
                        and '$terr1' = case when '$terr1' = 'ALL' then all_data else am_terr_id end
                        and '$terr2' = case when '$terr2' = 'ALL' then all_data else terr_id end
                        and '$brand_name' = case when '$brand_name' = 'ALL' then all_data else brand_name end
                        group by company_name,brand_name,product_strength,sap_code,p_code,p_name,cur_month_range,pre_month_range 
                        )order by cmr_sold_value desc)
                        union all
                        select company_name,brand_name,product_strength,sap_code,p_code,p_name,0 cmr_sold_qty,0 cmr_sold_value,pmr_sold_qty,
                               pmr_sold_value,0 pcode_cmr_sl,rownum pcode_pmr_sl,cur_month_range,pre_month_range  
                        from(
                        select company_name,brand_name,product_strength,sap_code,p_code,p_name,pmr_sold_qty,pmr_sold_value,cur_month_range,pre_month_range 
                        from
                        (
                        select company_name,brand_name,cur_month_range,pre_month_range,product_strength,sap_code,p_code,p_name,sum(nvl(pmr_sold_qty,0)) pmr_sold_qty,
                               sum(nvl(pmr_sold_value,0)) pmr_sold_value  
                        from(
                        select 'ALL' all_data,sales_type,cur_month_range,pre_month_range,company_code,company_name,p_group,brand_name,product_strength,sap_code,p_code,p_name,
                               rm_terr_id,am_terr_id,terr_id,cmr_sold_qty,cmr_sold_value,pmr_sold_qty,pmr_sold_value
                        from mis.brand_wise_sales_data where create_user = '$uid'
                        )where '$channel' = case when '$channel' = 'ALL' then all_data else sales_type end
                        and '$region' = case when '$region' = 'ALL' then all_data else rm_terr_id end
                        and '$terr1' = case when '$terr1' = 'ALL' then all_data else am_terr_id end
                        and '$terr2' = case when '$terr2' = 'ALL' then all_data else terr_id end
                        and '$brand_name' = case when '$brand_name' = 'ALL' then all_data else brand_name end
                        group by company_name,brand_name,product_strength,sap_code,p_code,p_name,cur_month_range,pre_month_range
                        )order by pmr_sold_value desc
                        ))group by company_name,brand_name,product_strength,sap_code,p_code,p_name,cur_month_range,pre_month_range ) pc_sd
                        where pc_sd.brand_name = ps_sd.brand_name
                        and pc_sd.product_strength = ps_sd.product_strength
                        and pc_sd.brand_name = pb_sd.brand_name");

        $total_cmr_qty = 0;
        $total_pmr_qty = 0;
        $total_cmr_value = 0;
        $total_pmr_value = 0;

        if($result == true || $result == 1){
            $arr = array();

            $cur_month_range = "";
            $pre_month_range = "";

            $qry = DB::SELECT("SELECT DISTINCT CUR_MONTH_RANGE,PRE_MONTH_RANGE FROM MIS.BRAND_WISE_SALES_REPORT WHERE CREATE_USER = '$uid'");
            $cur_month_range = $qry[0]->cur_month_range;
            $pre_month_range = $qry[0]->pre_month_range;

            $qry1 = DB::SELECT("SELECT SUM(P_CMR_SOLD_QTY) total_cmr_qty, SUM(P_PMR_SOLD_QTY) total_pmr_qty, SUM(P_CMR_SOLD_VALUE) total_cmr_value,  SUM(P_PMR_SOLD_VALUE) total_pmr_value FROM BRAND_WISE_SALES_REPORT WHERE CREATE_USER = '$uid'");
            if(count($qry1) > 0){
                $total_cmr_qty = number_format($qry1[0]->total_cmr_qty,0);
                $total_pmr_qty = number_format($qry1[0]->total_pmr_qty,0);
                $total_cmr_value = number_format($qry1[0]->total_cmr_value,0);
                $total_pmr_value = number_format($qry1[0]->total_pmr_value,0);
            }

            $brands = DB::SELECT("SELECT DISTINCT BRAND_NAME,COMPANY_NAME,PB_CMR_SL,PB_PMR_SL,PB_GROWTH_INDICATE,PB_CMR_CONTRIBUTION,PB_PMR_CONTRIBUTION FROM MIS.BRAND_WISE_SALES_REPORT WHERE CREATE_USER = '$uid' ORDER BY PB_CMR_SL ASC");

            if(count($brands) > 0){
                foreach ($brands as $key1 => $brand){

                    $temp['company_name'] = $brand->company_name;
                    $temp['brand_name'] = $brand->brand_name;
                    $temp['pb_growth_indicate'] = $brand->pb_growth_indicate;

                    $temp['pb_cmr_sl'] = $brand->pb_cmr_sl;
                    $temp['pb_pmr_sl'] = $brand->pb_pmr_sl;

                    $temp['pb_cmr_contribution'] = $brand->pb_cmr_contribution;
                    $temp['pb_pmr_contribution'] = $brand->pb_pmr_contribution;

                    $temp['details'] = array();

                    $ps = DB::SELECT("SELECT DISTINCT PRODUCT_STRENGTH,PS_CMR_SL,PS_PMR_SL,PS_GROWTH_INDICATE,PS_CMR_CONTRIBUTION,PS_PMR_CONTRIBUTION FROM BRAND_WISE_SALES_REPORT WHERE BRAND_NAME = '$brand->brand_name' AND CREATE_USER = '$uid' ORDER BY PS_CMR_SL ASC");

                    if(count($ps) > 0){
                        for($i=0; $i < count($ps);$i++){

                            $temp['details'][$i]['ps'] = $ps[$i]->product_strength;

                            $temp['details'][$i]['ps_growth_indicate'] = $ps[$i]->ps_growth_indicate;

                            $temp['details'][$i]['ps_cmr_sl'] = $ps[$i]->ps_cmr_sl;
                            $temp['details'][$i]['ps_pmr_sl'] = $ps[$i]->ps_pmr_sl;

                            $temp['details'][$i]['ps_cmr_contribution'] = $ps[$i]->ps_cmr_contribution;
                            $temp['details'][$i]['ps_pmr_contribution'] = $ps[$i]->ps_pmr_contribution;

                            $temp['details'][$i]['details'] = array();

                            $pcs = DB::SELECT("SELECT P_NAME,P_CMR_SOLD_QTY,P_PMR_SOLD_QTY,P_CMR_SOLD_VALUE,P_PMR_SOLD_VALUE,P_CODE_CMR_SL,P_CODE_PMR_SL,P_GROWTH_INDICATE,P_CMR_CONTRIBUTION,P_PMR_CONTRIBUTION FROM BRAND_WISE_SALES_REPORT WHERE PRODUCT_STRENGTH = '".$ps[$i]->product_strength."' AND CREATE_USER = '$uid' ORDER BY P_CODE_CMR_SL ASC");
                            if(count($pcs) > 0){
                                for($j=0; $j < count($pcs);$j++){
                                    $temp['details'][$i]['details'][$j]['pc'] = $pcs[$j]->p_name;

                                    $temp['details'][$i]['details'][$j]['p_growth_indicate'] = $pcs[$j]->p_growth_indicate;

                                    $temp['details'][$i]['details'][$j]['p_code_cmr_sl'] = $pcs[$j]->p_code_cmr_sl;
                                    $temp['details'][$i]['details'][$j]['p_code_pmr_sl'] = $pcs[$j]->p_code_pmr_sl;

                                    $temp['details'][$i]['details'][$j]['p_cmr_contribution'] = $pcs[$j]->p_cmr_contribution;
                                    $temp['details'][$i]['details'][$j]['p_pmr_contribution'] = $pcs[$j]->p_pmr_contribution;

                                    $temp['details'][$i]['details'][$j]['cmr_qty'] = number_format($pcs[$j]->p_cmr_sold_qty,0);
                                    $temp['details'][$i]['details'][$j]['pmr_qty'] = number_format($pcs[$j]->p_pmr_sold_qty,0);
                                    $temp['details'][$i]['details'][$j]['cmr_value'] = number_format($pcs[$j]->p_cmr_sold_value,0);
                                    $temp['details'][$i]['details'][$j]['pmr_value'] = number_format($pcs[$j]->p_pmr_sold_value,0);
                                }
                            }
                            $sumData = DB::SELECT("SELECT SUM(P_CMR_SOLD_QTY) total_cmr_qty, SUM(P_PMR_SOLD_QTY) total_pmr_qty, SUM(P_CMR_SOLD_VALUE) total_cmr_value,  SUM                                                        (P_PMR_SOLD_VALUE) total_pmr_value FROM BRAND_WISE_SALES_REPORT WHERE PRODUCT_STRENGTH = '".$ps[$i]->product_strength."' AND                                                 CREATE_USER = '$uid'");
                            if(count($sumData) > 0){
                                $temp['details'][$i]['total_cmr_qty'] = number_format($sumData[0]->total_cmr_qty,0);
                                $temp['details'][$i]['total_pmr_qty'] = number_format($sumData[0]->total_pmr_qty,0);
                                $temp['details'][$i]['total_cmr_value'] = number_format($sumData[0]->total_cmr_value,0);
                                $temp['details'][$i]['total_pmr_value'] = number_format($sumData[0]->total_pmr_value,0);
                            }else{
                                $temp['details'][$i]['total_cmr_qty'] = 0;
                                $temp['details'][$i]['total_pmr_qty'] = 0;
                                $temp['details'][$i]['total_cmr_value'] = 0;
                                $temp['details'][$i]['total_pmr_value'] = 0;
                            }
                        }
                    }
                    $brandTotVal = DB::SELECT("SELECT SUM(P_CMR_SOLD_QTY) total_cmr_qty, SUM(P_PMR_SOLD_QTY) total_pmr_qty, SUM(P_CMR_SOLD_VALUE) total_cmr_value,  SUM(P_PMR_SOLD_VALUE) total_pmr_value FROM BRAND_WISE_SALES_REPORT WHERE BRAND_NAME = '$brand->brand_name' AND CREATE_USER = '$uid'");
                    if(count($brandTotVal) > 0){
                        $temp['total_cmr_qty'] = number_format($brandTotVal[0]->total_cmr_qty,0);
                        $temp['total_pmr_qty'] = number_format($brandTotVal[0]->total_pmr_qty,0);
                        $temp['total_cmr_value'] = number_format($brandTotVal[0]->total_cmr_value,0);
                        $temp['total_pmr_value'] = number_format($brandTotVal[0]->total_pmr_value,0);
                    }else{
                        $temp['total_cmr_qty'] = 0;
                        $temp['total_pmr_qty'] = 0;
                        $temp['total_cmr_value'] = 0;
                        $temp['total_pmr_value'] = 0;
                    }
                    array_push($arr, $temp);
                }
            }
            return response()->json(['mainData'=>$arr,'cur_month_range'=>$cur_month_range,
                'pre_month_range'=>$pre_month_range,'total_cmr_qty'=>$total_cmr_qty,'total_pmr_qty'=>$total_pmr_qty,'total_cmr_value'=>$total_cmr_value,'total_pmr_value'=>$total_pmr_value]);
        }else{
            return response()->json(['mainData'=>[],'cur_month_range'=>"",'pre_month_range'=>"",'total_cmr_qty'=>$total_cmr_qty,'total_pmr_qty'=>$total_pmr_qty,'total_cmr_value'=>$total_cmr_value,'total_pmr_value'=>$total_pmr_value]);
        }
    }
    public function testSample(){
        $uid = Auth::user()->user_id;

        $arr = array();
        $cur_month_range = "";
        $pre_month_range = "";

        $qry = DB::SELECT("SELECT DISTINCT CUR_MONTH_RANGE,PRE_MONTH_RANGE FROM MIS.BRAND_WISE_SALES_REPORT WHERE CREATE_USER = '$uid'");
        $cur_month_range = $qry[0]->cur_month_range;
        $pre_month_range = $qry[0]->pre_month_range;


        $brands = DB::SELECT("SELECT DISTINCT BRAND_NAME,COMPANY_NAME,PB_CMR_SL,PB_PMR_SL,PB_GROWTH_INDICATE,PB_CMR_CONTRIBUTION,PB_PMR_CONTRIBUTION FROM MIS.BRAND_WISE_SALES_REPORT WHERE CREATE_USER = '$uid' ORDER BY PB_CMR_SL ASC");

        if(count($brands) > 0){
            foreach ($brands as $key1 => $brand){

                $temp['company_name'] = $brand->company_name;
                $temp['brand_name'] = $brand->brand_name;
                $temp['pb_growth_indicate'] = $brand->pb_growth_indicate;

                $temp['pb_cmr_sl'] = $brand->pb_cmr_sl;
                $temp['pb_pmr_sl'] = $brand->pb_pmr_sl;

                $temp['pb_cmr_contribution'] = $brand->pb_cmr_contribution;
                $temp['pb_pmr_contribution'] = $brand->pb_pmr_contribution;

                $temp['details'] = array();

                $ps = DB::SELECT("SELECT DISTINCT PRODUCT_STRENGTH,PS_CMR_SL,PS_PMR_SL,PS_GROWTH_INDICATE,PS_CMR_CONTRIBUTION,PS_PMR_CONTRIBUTION FROM BRAND_WISE_SALES_REPORT WHERE BRAND_NAME = '$brand->brand_name' AND CREATE_USER = '$uid' ORDER BY PS_CMR_SL ASC");

                if(count($ps) > 0){
                    for($i=0; $i < count($ps);$i++){

                        $temp['details'][$i]['ps'] = $ps[$i]->product_strength;

                        $temp['details'][$i]['ps_growth_indicate'] = $ps[$i]->ps_growth_indicate;

                        $temp['details'][$i]['ps_cmr_sl'] = $ps[$i]->ps_cmr_sl;
                        $temp['details'][$i]['ps_pmr_sl'] = $ps[$i]->ps_pmr_sl;

                        $temp['details'][$i]['ps_cmr_contribution'] = $ps[$i]->ps_cmr_contribution;
                        $temp['details'][$i]['ps_pmr_contribution'] = $ps[$i]->ps_pmr_contribution;

                        $temp['details'][$i]['details'] = array();

                        $pcs = DB::SELECT("SELECT P_NAME,P_CMR_SOLD_QTY,P_PMR_SOLD_QTY,P_CMR_SOLD_VALUE,P_PMR_SOLD_VALUE,P_CODE_CMR_SL,P_CODE_PMR_SL,P_GROWTH_INDICATE,P_CMR_CONTRIBUTION,P_PMR_CONTRIBUTION FROM BRAND_WISE_SALES_REPORT WHERE PRODUCT_STRENGTH = '".$ps[$i]->product_strength."' AND CREATE_USER = '$uid' ORDER BY P_CODE_CMR_SL ASC");
                        if(count($pcs) > 0){
                            for($j=0; $j < count($pcs);$j++){
                                $temp['details'][$i]['details'][$j]['pc'] = $pcs[$j]->p_name;

                                $temp['details'][$i]['details'][$j]['p_growth_indicate'] = $pcs[$j]->p_growth_indicate;

                                $temp['details'][$i]['details'][$j]['p_code_cmr_sl'] = $pcs[$j]->p_code_cmr_sl;
                                $temp['details'][$i]['details'][$j]['p_code_pmr_sl'] = $pcs[$j]->p_code_pmr_sl;

                                $temp['details'][$i]['details'][$j]['p_cmr_contribution'] = $pcs[$j]->p_cmr_contribution;
                                $temp['details'][$i]['details'][$j]['p_pmr_contribution'] = $pcs[$j]->p_pmr_contribution;

                                $temp['details'][$i]['details'][$j]['cmr_qty'] = number_format($pcs[$j]->p_cmr_sold_qty,2);
                                $temp['details'][$i]['details'][$j]['pmr_qty'] = number_format($pcs[$j]->p_pmr_sold_qty,2);
                                $temp['details'][$i]['details'][$j]['cmr_value'] = number_format($pcs[$j]->p_cmr_sold_value,2);
                                $temp['details'][$i]['details'][$j]['pmr_value'] = number_format($pcs[$j]->p_pmr_sold_value,2);
                            }
                        }
                        $sumData = DB::SELECT("SELECT SUM(P_CMR_SOLD_QTY) total_cmr_qty, SUM(P_PMR_SOLD_QTY) total_pmr_qty, SUM(P_CMR_SOLD_VALUE) total_cmr_value,  SUM                                                        (P_PMR_SOLD_VALUE) total_pmr_value FROM BRAND_WISE_SALES_REPORT WHERE PRODUCT_STRENGTH = '".$ps[$i]->product_strength."' AND                                                 CREATE_USER = '$uid'");
                        if(count($sumData) > 0){
                            $temp['details'][$i]['total_cmr_qty'] = number_format($sumData[0]->total_cmr_qty,2);
                            $temp['details'][$i]['total_pmr_qty'] = number_format($sumData[0]->total_pmr_qty,2);
                            $temp['details'][$i]['total_cmr_value'] = number_format($sumData[0]->total_cmr_value,2);
                            $temp['details'][$i]['total_pmr_value'] = number_format($sumData[0]->total_pmr_value,2);
                        }else{
                            $temp['details'][$i]['total_cmr_qty'] = 0;
                            $temp['details'][$i]['total_pmr_qty'] = 0;
                            $temp['details'][$i]['total_cmr_value'] = 0;
                            $temp['details'][$i]['total_pmr_value'] = 0;
                        }
                    }
                }
                $brandTotVal = DB::SELECT("SELECT SUM(P_CMR_SOLD_QTY) total_cmr_qty, SUM(P_PMR_SOLD_QTY) total_pmr_qty, SUM(P_CMR_SOLD_VALUE) total_cmr_value,  SUM                                                    (P_PMR_SOLD_VALUE) total_pmr_value FROM BRAND_WISE_SALES_REPORT WHERE BRAND_NAME = '$brand->brand_name' AND CREATE_USER = '$uid'");
                if(count($brandTotVal) > 0){
                    $temp['total_cmr_qty'] = number_format($brandTotVal[0]->total_cmr_qty,2);
                    $temp['total_pmr_qty'] = number_format($brandTotVal[0]->total_pmr_qty,2);
                    $temp['total_cmr_value'] = number_format($brandTotVal[0]->total_cmr_value,2);
                    $temp['total_pmr_value'] = number_format($brandTotVal[0]->total_pmr_value,2);
                }else{
                    $temp['total_cmr_qty'] = 0;
                    $temp['total_pmr_qty'] = 0;
                    $temp['total_cmr_value'] = 0;
                    $temp['total_pmr_value'] = 0;
                }
                array_push($arr, $temp);
            }
        }
        return view('testSample',['mainData'=>$arr,'cur_month_range'=>$cur_month_range,'pre_month_range'=>$pre_month_range]);
    }
}


