<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ReportsController extends Controller
{
    //
    //--------National Stock......daily report------------------------------------
    public function rep_nat_stock_view()
    {

        //company list itmes
        $cLitems = DB::select('select distinct company_code ccode,company_name company from mis.DASH_NATIONAL_STOCK order by company_code asc');
        //pgroup list items
        $pgLitems = DB::select('select distinct decode(p_group,\'ANIMAL HEALTH & VACCINE DIVISION\',\'ANIMAL HEALTH AND VACCINE DIVISION\',p_group) p_group from mis.DASH_NATIONAL_STOCK order by p_group asc');

        return view('reports_layout.national_stock')->with(['company' => $cLitems, 'pgroup' => $pgLitems]);
    }

    public function nat_stock_table_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("SELECT SAP_CODE, P_CODE, NAME,  PACK_S, DHK, COM, CTG, SYL, BSL, 
                KHL, RAJ, MAG, BOG, RAN, MYM, NOA, COX, NAR, TNG, JSR, MOU, DNP, FNI, BBR, PAB, CWH, FAC
                FROM mis.DASH_NATIONAL_STOCK D
                where company_code = decode('$request->code','All',company_code,'$request->code')
                and p_group = decode('$request->pgrp','All',p_group,'ANIMAL HEALTH AND VACCINE DIVISION','ANIMAL HEALTH & VACCINE DIVISION','$request->pgrp')");

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

//month_wise_sales_view
    //history channel base(T-1) view

    public function month_wise_sales_view()
    {


        $user_id = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user_id]);

        return view('reports_layout.month_wise_sales',compact('data'));
    }

    //history channel base(T-2) view
    public function summary_of_sales_view(){
        $user_id = Auth::user()->user_id;

        $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user_id]);
        return view('reports_layout.summary_of_sales',compact('data'));
    }

    public function month_daily_sales_data(Request $request)
    {


        if ($request->ajax()) {
            $user_id = Auth::user()->user_id;

            $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user_id]);


//            return response()->json($data);

            if ($data[0]->cnt) {
                $queryData = DB::select("Select sales_year,Round(jan,2) as jan,Round(feb,2) as feb,
                    Round(mar,2) as mar,Round(apr,2) as apr,Round(may,2) as may,Round(jun,2) as jun,
                    Round(jul,2) as jul,Round(aug,2) as aug,Round(sep,2) as sep,
                    Round(oct,2) as oct,Round(nov,2) as nov,Round(dec,2) as dec,
                    Round(depo_total,2) as depo_total,Round(special_sales,2) as special_sales,
                    Round(inst_sales,2) as inst_sales,Round(export_product,2) as export_product,
                    Round(export_service,2) as export_service,Round(toll_mfg,2) as toll_mfg,
                    Round(kinetix_inter,2) as kinetix_inter,Round(grand_total,2) as grand_total,
                    Round(grand_growth,2) as grand_growth
                     from MIS.MONTH_WISE_SALES_REPORT");
            } else {
                $queryData = DB::select("Select sales_year,Round(jan,2) as jan,Round(feb,2) as feb,
                    Round(mar,2) as mar,Round(apr,2) as apr,Round(may,2) as may,Round(jun,2) as jun,
                    Round(jul,2) as jul,Round(aug,2) as aug,Round(sep,2) as sep,
                    Round(oct,2) as oct,Round(nov,2) as nov,Round(dec,2) as dec,
                    Round(depo_total,2) as depo_total,Round(special_sales,2) as special_sales,
                    Round(inst_sales,2) as inst_sales,Round(export_product,2) as export_product,
                    Round(export_service,2) as export_service,Round(toll_mfg,2) as toll_mfg,
                    Round(kinetix_inter,2) as kinetix_inter,Round(grand_total,2) as grand_total,
                    Round(grand_growth,2) as grand_growth
                     from MIS.MONTH_WISE_SALES_RP_WB03_B04");
            }


//
//            $queryData =DB::select("Select sales_year,Round(jan,2) as jan,Round(feb,2) as feb,
//                    Round(mar,2) as mar,Round(apr,2) as apr,Round(may,2) as may,Round(jun,2) as jun,
//                    Round(jul,2) as jul,Round(aug,2) as aug,Round(sep,2) as sep,
//                    Round(oct,2) as oct,Round(nov,2) as nov,Round(dec,2) as dec,
//                    Round(depo_total,2) as depo_total,Round(depo_growth,2) as depo_growth,
//                    Round(inst_sales,2) as inst_sales,Round(export_product,2) as export_product,
//                    Round(export_service,2) as export_service,Round(toll_mfg,2) as toll_mfg,
//                    Round(kinetix_inter,2) as kinetix_inter,Round(grand_total,2) as grand_total,
//                    Round(grand_growth,2) as grand_growth
//                     from MIS.MONTH_WISE_SALES_REPORT");
            // $queryData =DB::select("Select * from MIS.MONTH_WISE_SALES_REPORT");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

    public function export_sale_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("select sales_year,Round(sales_usd,2) as sales_usd,sales_bdt,growth from mis.export_sales_growth");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

    public function inst_sale_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("select sales_year,sales_bdt,growth from mis.institute_sales_growth");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

    public function ser_tech_export_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("select sales_year,sales_bdt from mis.service_export_growth");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

    public function toll_mfg_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("select sales_year,sales_bdt from mis.toll_mfg_growth");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

//    Summary of Sales Table---9.5.2019 update
     public function summary_data(Request $request)
    {

        if ($request->ajax()) {

            $user_id = Auth::user()->user_id;

            $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user_id]);

            if ($data[0]->cnt) {
                $queryData = DB::select("Select sales_year,Round(depot_sales,2) as depot_sales,
                Round(inst_b01,2) as inst_b01,Round(inst_b02,2) as inst_b02,Round(inst_b03,2) as inst_b03,
                Round(inst_b04,2) as inst_b04,NVL(inst_b03,0)+NVL(inst_b04,0) as special_tot,NVL(inst_b01,0)+NVL(inst_b02,0) as inst_total,
                Round(export_a01,2) as export_a01,Round(export_a02,2) as export_a02,
                Round(export_a03,2) as export_a03,Round(export_total_bdt,2) as export_total_bdt,
                Round(export_total_usd,2) as export_total_usd,Round(export_service,2) as export_service,
                Round(export_tech,2) as export_tech,Round(export_st_total,2) as export_st_total,
                Round(toll_mfg,2) as toll_mfg,Round(kinetix_inter,2) as kinetix_inter,
                Round(grand_total,2) as grand_total from mis.summary_of_sales");
            }
            else{
                $queryData = DB::select("Select sales_year,Round(depot_sales,2) as depot_sales,
                Round(inst_b01,2) as inst_b01,Round(inst_b02,2) as inst_b02,Round(inst_b03,2) as inst_b03,
                Round(inst_b04,2) as inst_b04,NVL(inst_b03,0)+NVL(inst_b04,0) as special_tot,NVL(inst_b01,0)+NVL(inst_b02,0) as inst_total,
                Round(export_a01,2) as export_a01,Round(export_a02,2) as export_a02,
                Round(export_a03,2) as export_a03,Round(export_total_bdt,2) as export_total_bdt,
                Round(export_total_usd,2) as export_total_usd,Round(export_service,2) as export_service,
                Round(export_tech,2) as export_tech,Round(export_st_total,2) as export_st_total,
                Round(toll_mfg,2) as toll_mfg,Round(kinetix_inter,2) as kinetix_inter,
                Round(grand_total,2) as grand_total from mis.SUMMARY_OF_SALES_WB03_B04");
            }
                        $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }


    }


//product_group_wise_summary--- start -----
    public function pgroup_wise_summary()
    {
        $queryData = DB::select("select distinct report_cmonth, report_pmonth,to_char(report_upto,'DD-Mon-RR') report_upto,
                        to_char(report_date,'DD-Mon-RR') report_date, twd, wd, ptwd, pwd
                        from mis.product_group_wise_sales");



        $uid = Auth::user()->user_id;
        $validViewer = ['1005975','1000000','2000000','1000081','1010112','1000353',
            '1000298','1000001','1000085','1004181','1000069','1016022'];

        return view('reports_layout.product_groupwise_summary')->with("pgwsq", $queryData)
            ->with("users",$uid)->with("validViewer" ,$validViewer);
    }

    public function pgroup_wise_summary_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("select p_group,today_sales,last_month_sales,current_month_sales,growth
                                    from product_group_wise_sales");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

    public function gm_wise_sales_data(Request $request)
    {

        if ($request->ajax()) {
//
            $queryData = DB::select("select GM_ID,GM_NAME,P_GROUP,SUM(NVL(TGT_value,0))TGT_value,SUM(NVL(sales_value,0))sales_value,
SUM(NVL(ach,0))ach,SUM(NVL(today_product_out,0))today_product_out,
SUM(NVL(total_in_transit,0))total_in_transit
                            from group_wise_sales_rm_to_gm
                            GROUP BY GM_ID,GM_NAME,P_GROUP
                            order by GM_NAME");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

    //product_group_wise_summary--- end -----
    //SM wise--- start -----
    public function sm_wise_summary()
    {
        $queryData = DB::select("select distinct report_cmonth, report_pmonth,to_char(report_upto,'DD-Mon-RR') report_upto,
                        to_char(report_date,'DD-Mon-RR') report_date, twd, wd, ptwd, pwd
                        from mis.product_group_wise_sales");
        return view('reports_layout.sm_sales')->with("pgwsq", $queryData);
    }

    public function sm_wise_sales_data(Request $request)
    {

        if ($request->ajax()) {
//             $queryData =DB::select("select case when sm_id is null then dsm_id else sm_id end dsm_sm_id, case when sm_id is null then dsm_name else sm_name end dsm_sm_name,
// gm_id,gm_name,p_group,tgt_value,sales_value,ach,today_product_out,total_in_transit
//                             from group_wise_sales_rm_to_gm
//                             order by gm_name,dsm_sm_name");

            $queryData = DB::select("select case when sm_id is null then dsm_id else sm_id end dsm_sm_id,
                       case when sm_id is null then dsm_name else sm_name end dsm_sm_name,
                gm_id,gm_name,p_group,sum(nvl(tgt_value,0))tgt_value,sum(nvl(sales_value,0))sales_value,sum(nvl(ach,0))ach,
                          sum(nvl(today_product_out,0))today_product_out,sum(nvl(total_in_transit,0))total_in_transit
                from group_wise_sales_rm_to_gm
                group by case when sm_id is null then dsm_id else sm_id end,
                case when sm_id is null then dsm_name else sm_name end ,gm_id,gm_name,p_group
                order by gm_name,dsm_sm_name");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);
            return response()->json($results);
        }
    }

    //SM wise--- end -----

    //RM wise--- start -----
    public function rm_wise_summary()
    {
        $queryData = DB::select("select distinct report_cmonth, report_pmonth,to_char(report_upto,'DD-Mon-RR') report_upto,
                        to_char(report_date,'DD-Mon-RR') report_date, twd, wd, ptwd, pwd
                        from mis.product_group_wise_sales");
        return view('reports_layout.rm_sales')->with("pgwsq", $queryData);
    }

    public function rm_wise_sales_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("select asm_rm_name,rm_terr_id,dsm_sm_id,dsm_sm_name,gm_id,gm_name,sum(nvl(tgt_value,0)) tgt_value ,sum(nvl(sales_value,0)) sales_value,
                sum(nvl(ach,0)) ach,sum(nvl(today_product_out,0)) today_product_out,sum(nvl(total_in_transit,0)) total_in_transit
            from
            (
            select case when asm_id is null then rm_name else asm_name end asm_rm_name,rm_terr_id,
            case when sm_id is null then dsm_id else sm_id end dsm_sm_id, case when sm_id is null then dsm_name else sm_name end dsm_sm_name,
            gm_id,gm_name,tgt_value,sales_value,ach,today_product_out,total_in_transit
                                        from group_wise_sales_rm_to_gm
                                        order by gm_name,dsm_sm_name,asm_rm_name)
            group by   asm_rm_name,rm_terr_id,dsm_sm_id,dsm_sm_name,gm_id,gm_name
            order by  gm_name,dsm_sm_name,asm_rm_name");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);
            return response()->json($results);
        }
    }

    //RM wise--- end -----


     //    RM Sales Modal    Author :: Sahadat

    public function rm_sales_modal(Request $request)
    {
        if ($request->ajax()) {
            $rm_id=$request->rm_id;
            $data = DB::select("SELECT
                                  RM_TERR_ID,    
                                  P_CODE,    
                                  BRAND_NAME,   
                                  P_GROUP, 
                                  TGT_QTY , 
                                  SOLD_QTY,
                                  INT_QTY ,
                                  TGT_VALUE,
                                  SOLD_VAL,
                                  INT_VAL,
                                  VAL_EXP_SALE,
                                  INT_DIS_AMT,
                                  SOLD_DIS_AMT,
                                  TODAY_OUT_VAL,
                                  TOTAL_INT_VAL
                                        FROM 
                                        MIS.RM_PRODUCT_WISE_SALES
                                        WHERE RM_TERR_ID=?",[$rm_id]);
            return response()->json(
                [
                    'report_data'=>$data

                ]);
        }
    }

//   RM-_Sales_modal ends here
    //RM DTL--- start -----

    public function rm_sales_dtl()
    {
        $queryData = DB::select("select distinct report_cmonth, report_pmonth,to_char(report_upto,'DD-Mon-RR') report_upto,
                        to_char(report_date,'DD-Mon-RR') report_date, twd, wd, ptwd, pwd
                        from mis.product_group_wise_sales");
        return view('reports_layout.rm_sales_dtl')->with("pgwsq", $queryData);
    }

    public function rm_sales_dtl_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("select case when asm_id is null then rm_name else asm_name end asm_rm_name,rm_terr_id, 
case when sm_id is null then dsm_id else sm_id end dsm_sm_id, case when sm_id is null then dsm_name else sm_name end dsm_sm_name,
gm_id,gm_name,p_group,tgt_value,sales_value,ach,today_product_out,total_in_transit
                            from group_wise_sales_rm_to_gm
                            order by gm_name,dsm_sm_name,asm_rm_name");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);
            return response()->json($results);
        }
    }

    //RM DTL--- end -----

    //Depot Wise Sales ---- start-------
    public function depot_wise_sales()
    {

        $queryData = DB::select("select distinct report_cmonth, report_pmonth,to_char(report_upto,'DD-Mon-RR') report_upto,
                        to_char(report_date,'DD-Mon-RR') report_date, twd, wd, ptwd, pwd
                        from mis.product_group_wise_sales");
        return view('reports_layout.depot_wise_sales')->with("pgwsq", $queryData);
    }

   
  public function depot_wise_sales_data(Request $request)
    {

        if ($request->ajax()) {
            $queryData = DB::select("
                              
                                select p_group,
                                type,dhaka,
                                comilla,
                                chittagong,
                                sylhet,
                                barishal,
                                khulna,
                                rajshahi,
                                magura,
                                bogra,
                                rangpur,
                                mymenshing,
                                noakhali,
                                coxsbazar,
                                narayangonj,
                                tangail,
                                jessore,
                                moulovibazar,
                                dinajpur,
                                feni,
                                brahmanbaria,
                                pabna,
                                madaripur,
                                dhaka_south,
                                ashulia,chandpur,chittagong_south,
               
                                nvl(dhaka,0)+nvl(comilla,0)+nvl(chittagong,0)+nvl(sylhet,0)+nvl(barishal,0)+nvl(khulna,0)+nvl(rajshahi,0)+nvl(magura,0)+
                                nvl(bogra,0)+nvl(rangpur,0)+nvl(mymenshing,0)+nvl(noakhali,0)+nvl(coxsbazar,0)+nvl(narayangonj,0)+nvl(tangail,0)+nvl(jessore,0)+
                                nvl(moulovibazar,0)+nvl(dinajpur,0)+nvl(feni,0)+nvl(brahmanbaria,0)+nvl(pabna,0)+nvl(madaripur,0)+nvl(dhaka_south,0)+nvl(ashulia,0)+nvl(chandpur,0)
                                ++nvl(chittagong_south,0)
                                total 
                                
                                from(
                            select *
                            from(                 
                            select report_month,report_upto,report_date,twd,wd,d_id,p_group,'SALES' Type , sum(nvl(sales_value,0)) value
                            from mis.depot_group_wise_sales
                            group by report_month,report_upto,report_date,twd,wd,d_id,p_group
                            ) pivot (sum(value)for d_id in (1 as DHAKA ,2 as COMILLA,3 as CHITTAGONG,4 as SYLHET,5 as BARISHAL,6 as KHULNA,7 as RAJSHAHI,8 as MAGURA,
                                    9 as BOGRA,10 as RANGPUR,11 as MYMENSHING,12 as NOAKHALI,13 as COXSBAZAR,14 as NARAYANGONJ,15 as TANGAIL,16 as JESSORE,
                                    17 as MOULOVIBAZAR,18 as DINAJPUR,19 as FENI,20 as BRAHMANBARIA,21 as PABNA,22 as DHAKA_SOUTH,23 as MADARIPUR,24 as ASHULIA,25 as CHANDPUR,26 as CHITTAGONG_SOUTH))
                            union all
                            select *
                            from(                 
                            select report_month,report_upto,report_date,twd,wd,d_id,p_group,'TARGET' Type, sum(nvl(target_value,0)) value
                            from mis.depot_group_wise_sales
                            group by report_month,report_upto,report_date,twd,wd,d_id,p_group
                            ) pivot (sum(value)for d_id in (1 as DHAKA ,2 as COMILLA,3 as CHITTAGONG,4 as SYLHET,5 as BARISHAL,6 as KHULNA,7 as RAJSHAHI,8 as MAGURA,
                                    9 as BOGRA,10 as RANGPUR,11 as MYMENSHING,12 as NOAKHALI,13 as COXSBAZAR,14 as NARAYANGONJ,15 as TANGAIL,16 as JESSORE,
                                    17 as MOULOVIBAZAR,18 as DINAJPUR,19 as FENI,20 as BRAHMANBARIA,21 as PABNA,22 as DHAKA_SOUTH,23 as MADARIPUR,24 as ASHULIA,25 as CHANDPUR,26 as CHITTAGONG_SOUTH))
                            )order by p_group,type   
                ");
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);
            return response()->json($results);
        }
    }
   
    //Depot Wise Sales ---- End-------




public function depot_product_activity()
    {

        $depot = DB::select("select d_id,d_id ||'-'|| name  depot_name from depot@web_to_imsfa order by d_id");
        $groups = DB::select("
                                select distinct p_group 
                                from dwh.product_info_m @web_to_ipldw2
                                where valid='YES'
                                order by p_group
        ");


        return view('reports_layout.depot_product_activity',[
            'depots' => $depot,
            'groups' => $groups
        ]);
    }

    public function getDepotActivityData(Request $request){
//        return response()->json($request->all());

        $depot = $request->dept_id;
        $grpName = $request->group;
        $wDate = $request->wdt;

        try{
            $rs = DB::select("
                select d_id,depot_name,wdate,wday,p_group,terr_id,p_code,brand_name,coq,cov,covd,int_qty,int_value,int_volume_dis,sold_qty,sold_value,sold_volume_dis
                from(
                select 'ALL' all_data,ds.d_id,depot_name,wdate,wday,ds.p_group,terr_id,pim.p_code,brand_name,sum(nvl(cum_out_qty,0)) coq,sum(nvl(cum_out_value,0)) cov,
                       sum(nvl(cum_out_volume_dis,0)) covd,sum(nvl(int_qty,0)) int_qty,sum(nvl(int_value,0)) int_value,sum(nvl(int_volume_dis,0)) int_volume_dis,
                       sum(nvl(sold_qty,0)) sold_qty,sum(nvl(sold_value,0)) sold_value,sum(nvl(sold_volume_dis,0)) sold_volume_dis
                from mis.depot_sale ds,dwh.product_info_m@web_to_ipldw2 pim,(select d_id,name depot_name from depot@web_to_imsfa) di
                where ds.p_code = pim.p_code
                and ds.d_id = di.d_id
                and to_char(wdate,'DD-Mon-RR') = '$wDate'
                group by ds.d_id,depot_name,ds.p_group,wdate,wday,terr_id,pim.p_code,brand_name
                )where '$depot' = case when '$depot' = 'ALL' then all_data else to_char(d_id) end
                and '$grpName' = case when '$grpName' = 'ALL' then all_data else p_group end
            ");
            return response()->json($rs);
        }catch (Oci8Exception $e){
            $rs = $e->getMessage();
            return response()->json($rs);
        }
    }



}
