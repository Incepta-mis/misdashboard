<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Log;
use Auth;

class SaleReportController extends Controller
{


    //23.3.2019....................history company base (T-1)
    public function sale_report_view(){

        return view('sale_report_layout.sale_report');
    }
    //23.3.2019....................history company base (T-2)
    public function sale_report_channelw_view(){

        return view('sale_report_layout.sale_report_channelw');
    }
    //23.3.2019....................history company base (T-3) will hide
    public function dep_teamw_saleHis_view(){

        return view('sale_report_layout.dep_teamw_saleHis');
    }

    public function all_company_sale_table_data(Request $request){

        if($request->ajax())
        {
            $user = Auth::user()->user_id;

            $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);

            // $queryData =DB::select("select sales_year,Round(ipl_sales,2) as ipl_sales,Round(ipl_growth,2) as ipl_growth,Round(ivl_sales,2) as ivl_sales,Round(ivl_growth,2) as ivl_growth,Round(ihhl_sales,2) as ihhl_sales,Round(ihhl_growth,2) as ihhl_growth,
            //     Round(ihnl_sales,2) as ihnl_sales,Round(ihnl_growth,2) as ihnl_growth,
            //     Round(tot_sales,2) as tot_sales,Round(tot_growth,2) as tot_growth from mis.all_company_sales order by sales_year");
            if($data[0]->cnt){
                $queryData=DB::select("select sales_year,Round(ipl_sales,2) as ipl_sales,
                Round(ipl_growth,2) as ipl_growth,
                Round(ivl_sales,2) as ivl_sales,Round(ivl_growth,2) as ivl_growth,
                Round(ihhl_sales,2) as ihhl_sales,Round(ihhl_growth,2) as ihhl_growth,
                Round(ihnl_sales,2) as ihnl_sales,
                Round(ihnl_growth,2) as ihnl_growth,
                Round(tot_sales,2) as tot_sales,Round(tot_growth,2) as tot_growth ,
                Round(inter_com_sales,2) as inter_com_sales, 
                Round(inter_com_growth,2) as inter_com_growth,
                Round(net_sales,2) as net_sales,
                Round(net_growth,2) as net_growth from mis.all_company_sales order by sales_year");
            }
            else{
                $queryData=DB::select("select sales_year,Round(ipl_sales,2) as ipl_sales,
                Round(ipl_growth,2) as ipl_growth,
                Round(ivl_sales,2) as ivl_sales,Round(ivl_growth,2) as ivl_growth,
                Round(ihhl_sales,2) as ihhl_sales,Round(ihhl_growth,2) as ihhl_growth,
                Round(ihnl_sales,2) as ihnl_sales,
                Round(ihnl_growth,2) as ihnl_growth,
                Round(tot_sales,2) as tot_sales,Round(tot_growth,2) as tot_growth ,
                Round(inter_com_sales,2) as inter_com_sales, 
                Round(inter_com_growth,2) as inter_com_growth,
                Round(net_sales,2) as net_sales,
                Round(net_growth,2) as net_growth from mis.all_company_sales_wb03_b04 order by sales_year");
            }




            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }

    public function allcomp_sale_channelwise_data(Request $request){

        if($request->ajax()){

            $user = Auth::user()->user_id;

            $data = DB::select("select count(*) cnt from mis.dashboard_users_info 
                            where  sales_report='ALL'
                            AND
                            user_id =?
                          ", [$user]);


                if($data[0]->cnt){
            $queryData =DB::select("select sales_year,
                                    Round(depot_ipl,2) as depot_ipl,
                                    Round(depot_ivl,2) as depot_ivl,
                                    Round(depot_ihhl,2) as depot_ihhl,
                                    Round(depot_ihnl,2) as depot_ihnl,
                                    Round(depot_total,2) as depot_total,

                                    Round(inst_ipl,2) as inst_ipl,
                                    Round(inst_ivl,2) as inst_ivl,
                                    Round(inst_ihhl,2) as inst_ihhl,
                                    Round(inst_ihnl,4) as inst_ihnl,
                                    Round(inst_total,2) as inst_total,


                                    Round(expot_ipl,2) as expot_ipl,
                                    Round(expot_ivl,2) as expot_ivl,
                                    Round(expot_ihhl,2) as expot_ihhl,
                                    Round(expot_ihnl,2) as expot_ihnl,
                                    Round(expot_total,2) as expot_total,

                                    Round(ser_expot_ipl,2) as ser_expot_ipl,
                                    Round(ser_expot_ivl,2) as ser_expot_ivl,
                                    Round(ser_expot_total,2) as ser_expot_total,

                                    Round(toll_mfg_ipl,2) as toll_mfg_ipl,
                                    Round(toll_mfg_ivl,2) as toll_mfg_ivl,

                                    Round(all_com_total,2) as all_com_total 
                                    from mis.all_company_sales_channel_wise order by sales_year");
                }
              else{
                                        $queryData =DB::select("select sales_year,
                                    Round(depot_ipl,2) as depot_ipl,
                                    Round(depot_ivl,2) as depot_ivl,
                                    Round(depot_ihhl,2) as depot_ihhl,
                                    Round(depot_ihnl,2) as depot_ihnl,
                                    Round(depot_total,2) as depot_total,

                                    Round(inst_ipl,2) as inst_ipl,
                                    Round(inst_ivl,2) as inst_ivl,
                                    Round(inst_ihhl,2) as inst_ihhl,
                                    Round(inst_ihnl,4) as inst_ihnl,
                                    Round(inst_total,2) as inst_total,


                                    Round(expot_ipl,2) as expot_ipl,
                                    Round(expot_ivl,2) as expot_ivl,
                                    Round(expot_ihhl,2) as expot_ihhl,
                                    Round(expot_ihnl,2) as expot_ihnl,
                                    Round(expot_total,2) as expot_total,

                                    Round(ser_expot_ipl,2) as ser_expot_ipl,
                                    Round(ser_expot_ivl,2) as ser_expot_ivl,
                                    Round(ser_expot_total,2) as ser_expot_total,

                                    Round(toll_mfg_ipl,2) as toll_mfg_ipl,
                                    Round(toll_mfg_ivl,2) as toll_mfg_ivl,

                                    Round(all_com_total,2) as all_com_total 
                                    from mis.all_comp_sales_cwise_wb03_b04 order by sales_year");
                                    }
            $results = array(
                "sEcho" => 1,
                "iTotalRecordys" => count($queryData),
                "iTotalDisplaRecords" => count($queryData),
                "aaData" => $queryData);



            return response()->json($results);
        }
    }

    public function resp_depot_teamw_sales_history_data(Request $request){
        if($request->ajax()) {
            $user = Auth::user()->user_id;
            $data = DB::select("select count(*) cnt from mis.dashboard_users_info
                                  where sales_report='ALL'
                                  AND user_id =?",
                                    [$user]) ;
            if ($data[0]->cnt){
                $queryData = DB::select("select sales_year,
                            Round(special,2) as special,
                            Round(cellbiotic,2) as cellbiotic,
                            Round(kinetix,2) as kinetix,
                            Round(zymos,2) as zymos,
                            Round(ahvd,2) as ahvd,
                            Round(hygiene_diaper,2) as hygiene_diaper,
                            Round(inst_b01,2) as inst_b01,
                            Round(inst_b02,2) as inst_b02,
                            Round(inst_b03,2) as inst_b03,
                            Round(inst_b04,2) as inst_b04,
                            Round(team_total,2) as team_total,
                            Round(special_gp,2) as special_gp,
                            Round(cellbiotic_gp,2) as cellbiotic_gp,
                            Round(kinetix_gp,2) as kinetix_gp,
                            Round(zymos_gp,2) as zymos_gp,
                            Round(ahvd_gp,2) as ahvd_gp,
                            Round(hygiene_diaper_gp,2) as hygiene_diaper_gp,
                            Round(inst_b01_gp,2) as inst_b01_gp,
                            Round(inst_b02_gp,2) as inst_b02_gp,
                            Round(inst_b03_gp,2) as inst_b03_gp,
                            Round(inst_b04_gp,2) as inst_b04_gp
                             from mis.depot_team_wise_sales_history order by sales_year");
            }
            else{
                $queryData = DB::select("select sales_year,
                            Round(special,2) as special,
                            Round(cellbiotic,2) as cellbiotic,
                            Round(kinetix,2) as kinetix,
                            Round(zymos,2) as zymos,
                            Round(ahvd,2) as ahvd,
                            Round(hygiene_diaper,2) as hygiene_diaper,
                            Round(inst_b01,2) as inst_b01,
                            Round(inst_b02,2) as inst_b02,
                            Round(inst_b03,2) as inst_b03,
                            Round(inst_b04,2) as inst_b04,
                            Round(team_total,2) as team_total,
                            Round(special_gp,2) as special_gp,
                            Round(cellbiotic_gp,2) as cellbiotic_gp,
                            Round(kinetix_gp,2) as kinetix_gp,
                            Round(zymos_gp,2) as zymos_gp,
                            Round(ahvd_gp,2) as ahvd_gp,
                            Round(hygiene_diaper_gp,2) as hygiene_diaper_gp,
                            Round(inst_b01_gp,2) as inst_b01_gp,
                            Round(inst_b02_gp,2) as inst_b02_gp,
                            Round(inst_b03_gp,2) as inst_b03_gp,
                            Round(inst_b04_gp,2) as inst_b04_gp
                             from mis.depot_team_wsales_his_wb03_b04 order by sales_year");
            }

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }


    //23.3.2019------------GM wise-----------------
    public function gm_ach_rep_v(){

        return view('sale_report_layout.gm_ach_rep');

    }

    //23.3.2019-------------SM ASM DSM wise----------------
    public function gm_sm_ach_report_view(){

        return view('sale_report_layout.gm_sm_ach_report');

    }

    public function sm_asm_dsm_ach_rep_v(){

        return view('sale_report_layout.sm_asm_dsm_ach_rep');

    }

    public function resp_gm_sm_dsm_achment(Request $request){

        if($request->ajax())
        {
            // $currentYear = date('Y');

            //2 jan 2019...change current year to max year

            $maxyear=DB::select("select max(sales_year) max_year from mis.gm_sm_sales_analysis_ach");


      $currentYear=(int)$maxyear[0]->max_year;


            // $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
            //                     case when sales_person='SM' then 1 
            //                     when sales_person='GM' then 2 
            //                     when sales_person='DSM' then 3 end sl
            //                      from mis.gm_sm_sales_analysis_ach 
            //                      where sales_year='".$currentYear."' order by sl");

            $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
                                case when sales_person='SM' then 2 
                                when sales_person='GM' then 1 
                                when sales_person='DSM' then 3 end sl
                                 from mis.gm_sm_sales_analysis_ach 
                                 where sales_year='".$currentYear."' order by sl");
            
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }


    //23.3.2019---------------gm---------------
    public function resp_gm_achment(Request $request){

        if($request->ajax())
        {
            // $currentYear = date('Y');

            //2 jan 2019...change current year to max year

            $maxyear=DB::select("select max(sales_year) max_year from mis.gm_sm_sales_analysis_ach");


            $currentYear=(int)$maxyear[0]->max_year;


            // $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
            //                     case when sales_person='SM' then 1
            //                     when sales_person='GM' then 2
            //                     when sales_person='DSM' then 3 end sl
            //                      from mis.gm_sm_sales_analysis_ach
            //                      where sales_year='".$currentYear."' order by sl");

//            $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
//                                case when sales_person='SM' then 2
//                                when sales_person='GM' then 1
//                                when sales_person='DSM' then 3 end sl
//                                 from mis.gm_sm_sales_analysis_ach
//                                 where sales_year='".$currentYear."' order by sl");

            // $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
            //                     case when sales_person='SM' then 1 
            //                     when sales_person='DSM' then 2 end sl
            //                      from mis.gm_sm_sales_analysis_ach 
            //                      where sales_year='".$currentYear."'
            //                       and sales_person ='GM'
            //                       order by sl");

            $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person
                                
                                 from mis.gm_sm_sales_analysis_ach 
                                 where sales_year='".$currentYear."'
                                  and sales_person ='GM'
                                  order by achievement desc ");

            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }



    //23.3.2019----------------sm asm dsm---------------
    public function resp_sm_dsm_achment(Request $request){

        if($request->ajax())
        {
            // $currentYear = date('Y');

            //2 jan 2019...change current year to max year

            $maxyear=DB::select("select max(sales_year) max_year from mis.gm_sm_sales_analysis_ach");


            $currentYear=(int)$maxyear[0]->max_year;


            // $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
            //                     case when sales_person='SM' then 1
            //                     when sales_person='GM' then 2
            //                     when sales_person='DSM' then 3 end sl
            //                      from mis.gm_sm_sales_analysis_ach
            //                      where sales_year='".$currentYear."' order by sl");

//            $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
//                                case when sales_person='SM' then 2
//                                when sales_person='GM' then 1
//                                when sales_person='DSM' then 3 end sl
//                                 from mis.gm_sm_sales_analysis_ach
//                                 where sales_year='".$currentYear."' order by sl");

            $queryData=DB::select("select name,target_value,sales_value,achievement,remark,sales_year,sales_person ,
                                case when sales_person='SM' then 1 
                                when sales_person='DSM' then 2 end sl
                                 from mis.gm_sm_sales_analysis_ach 
                                 where sales_year='".$currentYear."'
                                  and sales_person !='GM'
                                  order by sl");


            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }


    // public function resp_gm_ach_table_data(Request $request){

    //     if($request->ajax())
    //     {
    //         $currentYear = date('Y');

    //         $queryData =DB::select("select name,target_value,sales_value,achievement from mis.gm_sm_sales_analysis_ach where sales_person='GM' and sales_year='".$currentYear."' ");
    //         $results = array(
    //             "sEcho" => 1,
    //             "iTotalRecords" => count($queryData),
    //             "iTotalDisplayRecords" => count($queryData),
    //             "aaData" => $queryData);

    //         return response()->json($results);
    //     }
    // }

    // public function resp_sm_ach_table_data(Request $request){

    //     if($request->ajax())
    //     {
    //         $currentYear = date('Y');

    //         $queryData=DB::select("select name,target_value,sales_value,achievement from mis.gm_sm_sales_analysis_ach where sales_person='SM' and sales_year='".$currentYear."' ");
    //         $results = array(
    //             "sEcho" => 1,
    //             "iTotalRecords" => count($queryData),
    //             "iTotalDisplayRecords" => count($queryData),
    //             "aaData" => $queryData);

    //         return response()->json($results);
    //     }
    // }


    public function rm_ach_report_view(){

        // $currentYear = date('Y');

        // $queryData =DB::select("select name,rm_terr_id,Round(target_value,2) as target_value,Round(sales_value,2) as sales_value,achievement from mis.rm_sales_analysis_ach where sales_year='".$currentYear."' ");

        //edit 1.08.2018 by borna

        // $queryData =DB::select("select name,remark,Round(target_value,2) as target_value,Round(sales_value,2) as sales_value,achievement from mis.rm_sales_analysis_ach where sales_year='".$currentYear."' ");


        // $queryDatasum =DB::select("select sum(Round(target_value,2)) as total_target_value,sum(Round(sales_value,2)) as total_sales_value from mis.rm_sales_analysis_ach where sales_year='".$currentYear."' ");

        return view('sale_report_layout.rm_ach_report');
        // ->with('rmdata',$queryData)
        // ->with('rmdatatotal',$queryDatasum);
        // echo "fdf";
    }
    //unlock 12.08.2018
    //6/4/2019
    public function resp_rm_ach_table_data(Request $request){

        if($request->ajax())
        {
            // $queryData =DB::select("select name,rm_terr_id,Round(target_value,2) as target_value,Round(sales_value,2) as sales_value,achievement from mis.rm_sales_analysis_ach");

            //2 jan 2019 ---change current year to max year

            // $currentYear=date('Y');

            $maxyear=DB::select("select max(sales_year) max_year from mis.rm_sales_analysis_ach");

            $currentYear=(int)$maxyear[0]->max_year;

//            $queryData=DB::select("select name,remark,Round(target_value,2) as target_value,Round(sales_value,2) as sales_value,achievement from mis.rm_sales_analysis_ach where sales_year='".$currentYear."' ");
            //6.4.2019............coding
            $queryData=DB::select("select name,remark,Round(target_value,2) as target_value,Round(sales_value,2) as sales_value,achievement,p_group,rm_terr_id from mis.rm_sales_analysis_ach where sales_year='".$currentYear."' order by achievement");


            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($queryData),
                "iTotalDisplayRecords" => count($queryData),
                "aaData" => $queryData);

            return response()->json($results);
        }
    }


    public function dailyprocess_view(){
        return view('data_process.daily_data_process');
    }


    public function dailyprocess_post(Request $request){


        set_time_limit(0);

        if($request->ajax()){

            $dt='no d';
            $pt='no d';
            $dr='no d';
            $ycr='no d';
            $cr='no d';
            $cd='no d';


            //organize form data

            $coln=explode('&',$request->fd);
            $testarr=[];

            $el='';
            foreach($coln as $el){


                $keyy=(explode('=',$el)[0]);
                $vall= (explode('=',$el)[1]);
                $testarr+=[ $keyy => $vall ];
            }//end foreach


                        $statuscr = '';
                        $resultcr = '';

                        $statuscr2 = '';
                        $resultcr2 = '';
                        $statuscr3 = '';
                        $resultcr3 = '';


                        $statuscr4 = '';
                        $resultcr4 = '';

                        $statuscr5 = '';
                        $resultcr5 = '';

                        $statuscr6 = '';
                        $resultcr6 = '';


                        $statuscr7 = '';
                        $resultcr7 = '';

                        $statuscr8 = '';
                        $resultcr8 = '';

                        $statuscr9 = '';
                        $resultcr9 = '';




            //organize form data

            if($request->dt=='yes'){
                $dt='you can do this';
            }

            if($request->cd=='yes'){
                $cd='you can do this';
                // $cd_closing_dd_sale_year=$testarr['closing_dd_sale_year'];
               

                $procedure3 = 'MIS.pro_month_closing_data';
                $bindings3 = [
                    'sales_month' => trim($testarr['closing_dd_sale_year'])
                ];

        

                try{

                    $resultcr3 = DB::executeProcedure($procedure3,$bindings3);
                    $statuscr3 = 'done';

                }catch (Oci8Exception $e){
                    $statuscr3 = $e->getMessage();
                }

            }


            if($request->pt=='yes'){
                $pt='you can do this';
            }

            if($request->dr=='yes'){
                $dr='you can do this';
            }

            if($request->ycr=='yes'){
                $ycr='you can do this';
            }

            if($request->cr=='yes'){

                


                    $cr='you can do this';

                   
                    ///////////////process//////////////////////
                           


                    $procedure = 'MIS.pro_month_wise_sales_report';


                    $bindings = [
                        'sr_year' => $testarr['closing_sale_year'],
                        'sr_month' => $testarr['closing_sale_month']
                    ];

                    $procedure2 = 'MIS.pro_summary_of_sales';
                    $bindings2 = [
                        'sr_year' => $testarr['closing_sale_year']
                    ];

                            
                    // History Company Base
                    // ====================
                    $procedure4 = 'MIS.pro_all_company_sales';
                    $procedure5 = 'MIS.pro_all_company_sales_channel';
                    $procedure6 = 'MIS.pro_depot_team_wise_sales_gwth';



                    // Team Growth
                    // ===========

                   

                    $procedure7 = 'MIS.pro_year_wise_summary_data';
                    $procedure8 = 'MIS.pro_year_wise_sum_data_ieus';
                    $procedure9 = 'MIS.pro_team_wise_sales_growth';


                    $bindings9 = [
                        'sr_year' => $testarr['closing_sale_year'],
                        'sr_month' => $testarr['closing_sale_month'],
                        'sreport_month' => $testarr['closing_report_month'] 
                    ];



                    try{
                        $resultcr = DB::executeProcedure($procedure,$bindings);
                        // Log::info('procedure 1 '.$resultcr);
                        $statuscr = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr = $e->getMessage();
                    }

                    try{
                        $resultcr2 = DB::executeProcedure($procedure2,$bindings2);
                        // Log::info('procedure 2 '.$resultcr2);
                        $statuscr2 = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr2 = $e->getMessage();
                    }

                    // ----------------------------------

                    try{
                        $resultcr4 = DB::executeProcedure($procedure4,$bindings2);
                        // Log::info('procedure 4 '.$resultcr4);
                        $statuscr4 = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr4 = $e->getMessage();
                    }

                    try{
                        $resultcr5 = DB::executeProcedure($procedure5,$bindings2);
                        // Log::info('procedure 5 '.$resultcr5);
                        $statuscr5 = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr5 = $e->getMessage();
                    }

                    try{
                        $resultcr6 = DB::executeProcedure($procedure6,$bindings2);
                        Log::info('procedure 6 '.$resultcr6);
                        $statuscr6 = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr6 = $e->getMessage();
                    }

                    // // // ----------------------------
                    try{
                        $resultcr7 = DB::executeProcedure($procedure7,$bindings2);
                        // Log::info('procedure 7 '.$resultcr7);
                        $statuscr7 = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr7 = $e->getMessage();
                    }

                    try{
                        $resultcr8 = DB::executeProcedure($procedure8,$bindings2);
                        // Log::info('procedure 8 '.$resultcr8);
                        $statuscr8 = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr8 = $e->getMessage();
                        // Log::info($e->getMessage());
                    }

                    try{

                        // Log::info();
                        $resultcr9 = DB::executeProcedure($procedure9,$bindings9);
                        $statuscr9 = 'done';
                    }catch (Oci8Exception $e){
                        $statuscr9 = $e->getMessage();
                    }


                    //--------------------------------





    //                //////////////end process/////////////////////
            }



            return response()->json(
                [
//                  'closing_sale_year'=>explode('=',explode('&',$request->fd)[1])[1],
//                  'closing_sale_month'=>explode('=',explode('&',$request->fd)[2])[1],
                    'dt'=>$dt,
                    'cd'=>$cd,
                    'pt'=>$pt,
                    'dr'=>$dr,
                    'ycr'=>$ycr,
                    'cr'=>$cr,
//                  'rep'=>$testarr['closing_sale_month'],
                 // 'rep1'=>$testarr['closing_dd_sale_year'],
//                  'rep3'=>$testarr['closing_sale_year']
                    'message_status'=>$statuscr,
                    'result'=>$resultcr,
                    'message_status2'=>$statuscr2,
                    'result2'=>$resultcr2,
                    'message_status3'=>$statuscr3,
                    'result3'=>$resultcr3,
                    'message_status'=>$statuscr4,
                    'result'=>$resultcr4,
                    'message_status2'=>$statuscr5,
                    'result2'=>$resultcr5,
                    'message_status3'=>$statuscr6,
                    'result3'=>$resultcr6,
                    'message_status'=>$statuscr7,
                    'result'=>$resultcr7,
                    'message_status2'=>$statuscr8,
                    'result2'=>$resultcr8,
                    'message_status3'=>$statuscr9,
                    'result3'=>$resultcr9,
                    'subform'=>$testarr
                ]);
        }//ajax end

    }//function end
    
    
}
