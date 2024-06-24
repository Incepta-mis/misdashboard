<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product_Rank_Controller extends Controller
{
    public function product_rank_view(){
        $months = DB::select('Select distinct month2_name m2,month1_name m1 from MIS.PRODUCT_RANKING_DEPOT_SALES');

        $month1=null;
        $month2=null;

        foreach ($months as $m){
            $month1 = $m->m1;
            $month2 = $m->m2;
        }

        return view('sale_report_layout.v_prod_rank')->with(['mon1'=>$month1,'mon2'=>$month2]);

    }

    public function product_rank_resp(Request $request){
        if($request->ajax()){

            // $responseData = DB::select('select brand_name brand,month2_qty m2_qty,month1_qty m1_qty,
            //                             round(month2_value/10000000,4) m2_val,round(month1_value/10000000,4) m1_val,
            //                             growth_indicate indicat,month2_rank_position m2_rp,month1_rank_position m1_rp,
            //                             month2_contribution m2_con,month1_contribution m1_con,MONTH2_CUMULATIVE cum
            //                             from MIS.PRODUCT_RANKING_DEPOT_SALES
            //                             order by month2_rank_position asc');

//             $responseData = DB::select('select month1_rank_position,upper(brand_name) brand,round(month2_qty,2) m2_qty,
//        month1_qty m1_qty,month2_value m2_val,month1_value m1_val,
//        growth_indicate indicat,month2_rank_position m2_rp,month1_rank_position m1_rp,
//        month2_contribution m2_con,month1_contribution m1_con,month1_cumulative cum
// from mis.product_ranking_depot_sales
// order by month1_rank_position asc');

            // 28.5.2019
$responseData = DB::select('select month1_rank_position,upper(brand_name) brand,round(month2_qty,2) m2_qty,
       month1_qty m1_qty,month2_value m2_val,month1_value m1_val,
       growth_indicate indicat,month2_rank_position m2_rp,month1_rank_position m1_rp,
       month2_contribution m2_con,month1_contribution m1_con,month1_cumulative cum,
       comp_short_name,compnay_code,company_name,comp_short_name||\'-\'||compnay_code s_code,p_group
from mis.PRODUCT_RANKING_DEPOT_SALES
order by month1_rank_position asc');


            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($responseData),
                "iTotalDisplayRecords" => count($responseData),
                "aaData" => $responseData);

            return response()->json($results);
        }
    }


    ////////////////////Product Ranking Year Wise///////////////////
    ////////////////////////05-FEB-2020////////////////////////////
     public function yearly_product_rank_view(){

        $months = DB::select('Select distinct year2_name m2,year1_name m1 
                              from MIS.BRAND_RANKING_YEARLY');

        $month1=null;
        $month2=null;

        foreach ($months as $m){
            $month1 = $m->m1;
            $month2 = $m->m2;
        }

        return view('sale_report_layout.yearly_prod_rank')->with(['mon1'=>$month1,'mon2'=>$month2]);
    }

    public function year_wise_rank_data(){
        $responseData = DB::select('select year1_rank_position,upper(brand_name) brand,round(year2_qty,2) m2_qty,
                       year1_qty m1_qty,year2_value m2_val,year1_value m1_val,
                       growth_indicate indicat,year2_rank_position m2_rp,year1_rank_position m1_rp,
                       year2_contribution m2_con,year1_contribution m1_con,year1_cumulative cum,
                       comp_short_name,company_code,company_name,comp_short_name||\'-\'||company_code s_code,p_group
                from MIS.BRAND_RANKING_YEARLY
                order by year1_rank_position asc');


                        $results = array(
                            "sEcho" => 1,
                            "iTotalRecords" => count($responseData),
                            "iTotalDisplayRecords" => count($responseData),
                            "aaData" => $responseData);

                        return response()->json($results);
    }

//Monthly
    public function depotWiseProductRankExcel()
    {
        $data = DB::select('select month1_rank_position,upper(brand_name) brand_name,round(month2_qty,2) m2_qty,
            month1_qty m1_qty,month2_value m2_val,month1_value m1_val,
            growth_indicate indicat,month2_rank_position m2_rp,month1_rank_position m1_rp,
            month2_contribution m2_con,month1_contribution m1_con,month1_cumulative cum,
            comp_short_name,compnay_code,company_name,comp_short_name||\'-\'||compnay_code s_code
            from mis.product_ranking_depot_sales
            order by month1_rank_position asc');
        $collections = collect($data)->map(function ($x) {
            return (array)$x;
        })->toArray();

        $months = DB::select('Select distinct month2_name m2,month1_name m1 from MIS.PRODUCT_RANKING_DEPOT_SALES');
        $month1 = null;
        $month2 = null;
        foreach ($months as $m) {
            $month1 = $m->m1;
            $month2 = $m->m2;
        }

        \Excel::create('DepotWiseProductRank', function ($excel) use ($collections, $month1, $month2) {
            $excel->sheet('rank', function ($sheet) use ($collections, $month1, $month2) {
                $sheet->loadView('sale_report_layout.excel_layout.monthly_product_rank')
                    ->with('collections', $collections)
                    ->with('mon1', $month1)
                    ->with('mon2', $month2);
                $sheet->setWidth(array(
                    'A' => 5,
                    'B' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                    'J' => 20,
                    'K' => 20,
                    'L' => 20,
                ));
                $sheet->protect('inceptaVision');
//                $sheet->fromArray($collections);
            });
        })->export('xls');


    }

//yearly
    public function yearlyProductRankExcel()
    {
        $data = DB::select('select year1_rank_position,upper(brand_name) brand_name,round(year2_qty,2) m2_qty,
   year1_qty m1_qty,year2_value m2_val,year1_value m1_val,
   growth_indicate indicat,year2_rank_position m2_rp,year1_rank_position m1_rp,
   year2_contribution m2_con,year1_contribution m1_con,year1_cumulative cum,
   comp_short_name,company_code,company_name,comp_short_name||\'-\'||company_code s_code
from MIS.BRAND_RANKING_YEARLY
order by year1_rank_position asc');
        $collections = collect($data)->map(function ($x) {
            return (array)$x;
        })->toArray();

        $months = DB::select('Select distinct year2_name m2,year1_name m1 
                              from MIS.BRAND_RANKING_YEARLY');

        $month1=null;
        $month2=null;

        foreach ($months as $m){
            $month1 = $m->m1;
            $month2 = $m->m2;
        }

        \Excel::create('YearlyProductRank', function ($excel) use ($collections, $month1, $month2) {
            $excel->sheet('rank', function ($sheet) use ($collections, $month1, $month2) {
                $sheet->loadView('sale_report_layout.excel_layout.yearly_product_rank')
                    ->with('collections', $collections)
                    ->with('mon1', $month1)
                    ->with('mon2', $month2);
                $sheet->setWidth(array(
                    'A' => 5,
                    'B' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                    'J' => 20,
                    'K' => 20,
                    'L' => 20,
                ));
                $sheet->protect('inceptaVision');
//                $sheet->fromArray($collections);
            });
        })->export('xls');


    }


}
