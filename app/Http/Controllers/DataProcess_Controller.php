<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;
use Illuminate\Support\Facades\Log;
use App\Menu_Display;

class DataProcess_Controller extends Controller
{
    //

    public function dailyprocess_view(){

        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

        $current_datedb=DB::select("select TO_CHAR(sysdate,'DD-MM-YY') sy_date,TO_CHAR(sysdate-1,'DD-MM-YY') sy_date2,TO_CHAR(sysdate-2,'DD-MM-YY') sy_date3,TO_CHAR(sysdate-3,'DD-MM-YY') sy_date4 from dual");


        $arrdaybar = array(
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday'
        );

        // dd($arrdaybar[date('w')]);
        if($arrdaybar[date('w')]=='Saturday'){
            // var_dump("yes saturday");
            $current_monthly_wd=DB::select("select working_day,working_date,day,working_day_status,total_working_day
 from mis.monthly_working_day
 where to_date(working_date,'DD-MON-RR') = to_date(sysdate-2,'DD-MON-RR')");

        }
        else{
            // var_dump("noooo saturday");
            $current_monthly_wd=DB::select("select working_day,working_date,day,working_day_status,total_working_day
 from mis.monthly_working_day
 where to_date(working_date,'DD-MON-RR') = to_date(sysdate-1,'DD-MON-RR')");

        }
        // dd($current_monthly_wd);

        $working_day_submit='no';

        if(empty($current_monthly_wd)){

            // dd("yes");

            $working_day_submit='yes';
            $menu_show_sta='no';

            return view('data_process.daily_data_process',compact('working_day_submit','menu_show_sta'));
            // dd($working_day_submit);

        }
        else{

            $dayy=(int)explode('-',$current_monthly_wd[0]->working_date)[0];
            $monn=explode('-',$current_monthly_wd[0]->working_date)[1];
            $yr=explode('-',$current_monthly_wd[0]->working_date)[2];

//        dd($current_monthly_wd);

//        $dayy=25;

            $credit_date=" ";

            if($dayy >= 25){
                $credit_date="25-".$monn."-".$yr;
            }else{
                $credit_date=" ";
            }

            $wd=$current_monthly_wd[0]->working_day;

//        var_dump($wd);





            //suppose today 01-oct-2018 or 1st day of month ...but  iam working with previous month so
            if(date('j')==1){

                $info_baseday=DB::select("SELECT
            M.WORKING_DAY, M.WORKING_DATE,to_char(M.WORKING_DATE,'DD-MON-RR') as format_working_date, to_char(M.WORKING_DATE,'MON') as wd, M.DAY,
               M.WORKING_DAY_STATUS, M.TOTAL_WORKING_DAY, M.CREATE_DATE
            FROM MIS.MONTHLY_WORKING_DAY M
            where to_char(M.WORKING_DATE,'MON-RR')=to_char(trunc(trunc(sysdate-1,'MM')-1,'MM'),'MON-RR')
            and M.WORKING_DAY=?",[$wd]);

            }else{

                $info_baseday=DB::select("SELECT
            M.WORKING_DAY, M.WORKING_DATE,to_char(M.WORKING_DATE,'DD-MON-RR') as format_working_date, to_char(M.WORKING_DATE,'MON') as wd, M.DAY,
               M.WORKING_DAY_STATUS, M.TOTAL_WORKING_DAY, M.CREATE_DATE
            FROM MIS.MONTHLY_WORKING_DAY M
            where to_char(M.WORKING_DATE,'MON-RR')=to_char(trunc(trunc(sysdate,'MM')-1,'MM'),'MON-RR')
            and M.WORKING_DAY=?",[$wd]);

            }



            //if current wday 23 but prev wday 23 not ...then we will take last wday..27.09.2018
            if(empty($info_baseday)){

                if(date('j')==1){

                    $info_baseday=DB::select("SELECT
                M.WORKING_DAY, M.WORKING_DATE,to_char(M.WORKING_DATE,'DD-MON-RR') as format_working_date, to_char(M.WORKING_DATE,'MON') as wd, M.DAY,
                   M.WORKING_DAY_STATUS, M.TOTAL_WORKING_DAY, M.CREATE_DATE
                FROM MIS.MONTHLY_WORKING_DAY M
                where to_char(M.WORKING_DATE,'MON')=to_char(trunc(trunc(sysdate-1,'MM')-1,'MM'),'MON')
                and
                M.WORKING_DAY=(SELECT MAX(TOTAL_WORKING_DAY) FROM MIS.MONTHLY_WORKING_DAY where to_char(WORKING_DATE,'MON')=to_char(trunc(trunc(sysdate-1,'MM')-1,'MM'),'MON')
                )");

                }else{

                    $info_baseday=DB::select("SELECT
                M.WORKING_DAY, M.WORKING_DATE,to_char(M.WORKING_DATE,'DD-MON-RR') as format_working_date, to_char(M.WORKING_DATE,'MON') as wd, M.DAY,
                   M.WORKING_DAY_STATUS, M.TOTAL_WORKING_DAY, M.CREATE_DATE
                FROM MIS.MONTHLY_WORKING_DAY M
                where to_char(M.WORKING_DATE,'MON')=to_char(trunc(trunc(sysdate,'MM')-1,'MM'),'MON')
                and
                M.WORKING_DAY=(SELECT MAX(TOTAL_WORKING_DAY) FROM MIS.MONTHLY_WORKING_DAY where to_char(WORKING_DATE,'MON')=to_char(trunc(trunc(sysdate,'MM')-1,'MM'),'MON')
                )");
                }


            }

//        dd($info_baseday[0]);

            //closing report-----

            if(date('j')==1){
                $cls_last_wrday=DB::select("select WORKING_DATE wd,to_char(WORKING_DATE,'DD-MON-RR') wdword,DAY,WORKING_DAY_STATUS wds,
                                  WORKING_DAY wday,TOTAL_WORKING_DAY twd
                            from MIS.MONTHLY_WORKING_DAY 
                            where to_char(WORKING_DATE,'MON-RR')=to_char(trunc(trunc(sysdate-1,'MM'),'MM'),'MON-RR')
                            and WORKING_DAY=TOTAL_WORKING_DAY
                            order by wday desc");
            }else{
                $cls_last_wrday=DB::select("select WORKING_DATE wd,to_char(WORKING_DATE,'DD-MON-RR') wdword,DAY,WORKING_DAY_STATUS wds,
                                  WORKING_DAY wday,TOTAL_WORKING_DAY twd
                            from MIS.MONTHLY_WORKING_DAY 
                            where to_char(WORKING_DATE,'MON-RR')=to_char(trunc(trunc(sysdate-1,'MM')-1,'MM'),'MON-RR')
                            and WORKING_DAY=TOTAL_WORKING_DAY
                            order by wday desc");
            }


//            dd($cls_last_wrday[0]);


            //29.11.2018
            $menu_data=Menu_Display::all();
            $menu_show_sta=$menu_data[0]->menu_show_sta;

            return view('data_process.daily_data_process',compact('current_datedb','current_monthly_wd','credit_date','info_baseday','working_day_submit','menu_show_sta','cls_last_wrday'));


        }//empty na
    }


    public function dailyprocess_post(Request $request){

        ini_set('max_execution_time', 3600);
        set_time_limit(0);
        DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
        $logs = [];

        if($request->ajax()){

            // 7.4.2019

            DB::delete('delete from mis.data_proc_status');

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

            $total_message='DTotal';


            $statuscr = '';
            $resultcr = '';

            $statusdt='';
            $resultdt='';

            $statusdt28 = '';
            $result28dt='';

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

            $statuscr10 = '';
            $resultcr10 = '';

            $statuscr11 = '';
            $resultcr11 = '';

            $statuscr12 = '';
            $resultcr12 = '';

            $statuscr13 = '';
            $resultcr13 = '';


            $statuscr14 = '';
            $resultcr14 = '';

            $statuscr15 = '';
            $resultcr15 = '';

            $statuspt16 = '';
            $resultpt16 = '';

            $statuscr17 = '';
            $resultcr17 = '';

            $statuscr18 = '';
            $resultcr18 = '';

            $statuscr19 = '';
            $resultcr19 = '';

            $statuscr20 = '';
            $resultcr20 = '';

            $statuscr21 = '';
            $resultcr21 = '';

            $statuscr22 = '';
            $resultcr22 = '';

            $statuscr23 = '';
            $resultcr23 = '';


            $statuscr24 = '';
            $resultcr24 = '';

            $statuscr25 = '';
            $resultcr25 = '';

            $statuscr26 = '';
            $resultcr26 = '';

            $statuscr27 = '';
            $resultcr27 = '';

            $statusdt28 = '';
            $resultdt28 = '';
            $result28dt='';
            $dayy='';

            $statuscr29 = '';
            $resultcr29 = '';

            $statuscr30 = '';
            $resultcr30 = '';

            $statuscr31 = '';
            $resultcr31 = '';

            $statuscr32 = '';
            $resultcr32 = '';

            $statuscr33 = '';
            $resultcr33 = '';

            $statuscr34 = '';
            $resultcr34 = '';

            $statuscr35 = '';
            $resultcr35 = '';

            $statuscr36 = '';
            $resultcr36 = '';

            $statuscr37 = '';
            $resultcr37 = '';

            $statuscr38 = '';
            $resultcr38 = '';

            $resultcr39 = '';
            $statuscr39 = '';

            $error_msg_dt='';




            //organize form data
            //data transfer start from here---------------------------------

            if($request->dt=='yes'){
                $dt='you can do this data transfer';
                Log::info('procedure data transfer enter if');


                /////////////-procedure 10 start/////////////////////////////

                //                7.3.2019

                if($testarr['working_multi_dt']=='yes_multi_wd'){
                    $procedure10 = 'MIS.pro_insert_depot_sales_dwh_hd';
                }else if($testarr['working_multi_dt']=='no_multi_wd'){
                    $procedure10 = 'MIS.pro_insert_depot_sales_dwh';
                }

                // $procedure10 = 'MIS.pro_insert_depot_sales_dwh';
                $procedure28='MIS.pro_daily_sales_sms';

                $bindings10 = [
                    'fdom' => $testarr['1st_day_rep_mon_dt'],
                    'wday' => $testarr['work_day_dt'],
                    'wdt' => $testarr['work_date_dt'],
                    'rdate' => $testarr['rep_date_dt'],
                    'wdt1' => $testarr['2nd_work_day_dt'],
                    'pwdate' => $testarr['prev_work_day_dt'],
                    'rmonth'=> $testarr['rep_mon_dt']
                ];

                $dayy=(int)((explode('-',$testarr['work_date_dt']))[0]);

                // $bindings28=[];

                if($dayy >= 25){
                    Log::info('procedure data transfer 25days');
                    $bindings28 = [
                        'wday' => $testarr['work_date_dt'],
                        'wdt1'=> $testarr['2nd_work_day_dt'],
                        'pmwdt' => $testarr['prev_month_work_day_dt'],
                        'atc_date' => $testarr['credit_date_dt'],
                        'rdate' => $testarr['rep_date_dt'],
                        'rp_type' => $testarr['rep_type_dt']
                    ];
                }else{
                    Log::info('procedure data transfer 25days nothing');
                    $bindings28 = [
                        'wdt'=>$testarr['work_date_dt'],
                        'wdt1'=>$testarr['2nd_work_day_dt'],
                        'pmwdt'=>$testarr['prev_month_work_day_dt'],
                        'atc_date'=>'',
                        'rdate'=>$testarr['rep_date_dt'],
                        'rp_type'=>$testarr['rep_type_dt']
                    ];
                }

                //-----comment following 3.7.2019---------------------------

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure10." | Data Transfer";
                $run_status = 0;
                $endTime = null;
                $sl = 1;
                try{
                    $resultdt = DB::executeProcedure($procedure10,$bindings10);
                    Log::info('procedure 1 pro_insert_depot_sales_dwh'.$resultdt);
                    $statusdt = 'done dt pro_insert_depot_sales_dwh';
                    $error_msg_dt='done_suc';

                    $run_status = 1;
                }catch (Oci8Exception $e){
                    Log::info('procedure 1 pro_insert ERROR');
                    $statusdt = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';

                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];


//                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//                $procedure_name = $procedure28." | Data Transfer";;
//                $run_status = 0;
//                $endTime = null;
//                $sl++;
//
//                try{
//                    $result28dt = DB::executeProcedure($procedure28,$bindings28);
//                    Log::info('procedure 1 pro_daily_sales_sms'.$result28dt);
//                    $statusdt28 = 'done dt pro_daily_sales_sms';
//                    $error_msg_dt='done_suc';
//
//                    $run_status = 1;
//                }catch (Oci8Exception $e){
//                    Log::info('procedure 1 PRO_SMS ERROR');
//                    $statusdt28 =$e->getMessage();
//                    $total_message='NotDTotal';
//                    $error_msg_dt='done_error';
//
//                    $run_status = 0;
//                }
//
//                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//
//                $logs[] = [
//                    'sl' => $sl,
//                    'proc_name' => $procedure_name,
//                    'status' => $run_status,
//                    'stime' => $startTime,
//                    'etime' => $endTime
//                ];

                DB::delete('delete from mis.data_proc_status');

                DB::table('mis.data_proc_status')->insert([
                    'dt_status'=>$error_msg_dt
                ]);


                //national report

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = 'mis.pro_national_report | Data Transfer';
                $run_status = 0;
                $endTime = null;
                $sl++;

                try{

                    DB::setDateFormat('DD-MON-RR');
                    $total_work_day = DB::select("select distinct total_working_day twd
                                                    from mis.monthly_working_day
                                                    where trunc(working_date,'MM') = trunc(to_date(?,'DD-MON-RR'),'MM')",
                        [$testarr['work_date_dt']]);

                    if(count($total_work_day) > 0){
                        Log::info($testarr['work_date_dt'].'|'.$testarr['work_day_dt'].'|'.$total_work_day[0]->twd);

                        $nr_status = DB::executeProcedure(
                            'mis.pro_national_report',
                            [
                                'wdt' => $testarr['work_date_dt'],
                                'cwd' => $testarr['work_day_dt'],
                                'twd' => $total_work_day[0]->twd,
                                'tgt_mon' => $testarr['1st_day_rep_mon_dt']
                            ]);
                        if($nr_status){
                            Log::info('national report procedure executed  ');
                            $run_status = 1;
                        }
                    }

                }catch(\Exception $ex){
                    Log::info('Error NR:');
                    Log::info($ex->getMessage());
                    $run_status = 0;
                }

                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $this->create_log($logs);

                /////////////-procedure 10 end/////////////////////////////

            }

            if($request->cd=='yes'){
                $cd='you can do this';
                // $cd_closing_dd_sale_year=$testarr['closing_dd_sale_year'];


                /////////////-procedure 3 start/////////////////////////////
                DB::statement("alter session set nls_date_format = 'DD-MON-RR'");

                $procedure3 = 'MIS.pro_month_closing_data';
                $bindings3 = [
                    'sales_month' => trim($testarr['closing_dd_sale_year'])
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure3." | Data Transfer";;
                $run_status = 0;
                $endTime = null;
                $sl = 1;

                try{

                    $resultcr3 = DB::executeProcedure($procedure3,$bindings3);
                    $statuscr3 = 'done cd';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr3 = $e->getMessage();
                    $total_message='NotDTotal';
                    $run_status = 0;
                }

                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $this->create_log($logs);
                /////////////-procedure 3 end/////////////////////////////

            }
            //product target start from here---------------------------------


            if($request->pt=='yes'){
                $pt='you can do this';

//                procedure parameters (sreport_month)
//                target_mon_pt
//
//                execute mis.pro_month_wise_product_target('01-JUL-18');

                /////////////-procedure 16 start/////////////////////////////

                $procedure16='mis.pro_month_wise_product_target';
                $bindings16=[
                    'sreport_month' => trim($testarr['target_mon_pt'])
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure16." | Target Share";;
                $run_status = 0;
                $endTime = null;
                $sl = 1;

                try{

                    $resultpt16 = DB::executeProcedure($procedure16,$bindings16);
                    $statuspt16 = 'done pt';
                    $run_status = 1;

                }catch (Oci8Exception $e){
                    $statuspt16 = $e->getMessage();
                    $total_message='NotDTotal';
                    $run_status = 0;
                }

                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $this->create_log($logs);
                /////////////-procedure 16 end/////////////////////////////

            }
            //daily report start from here---------------------------------

            if($request->dr=='yes'){
                $dr='you can do this';



                /////////////-procedure 11 to 15 start/////////////////////////////

                $procedure11 = 'MIS.pro_product_group_wise_sales';
//                wdt date,prm varchar,rp_type varchar
                $procedure12 = 'MIS.pro_group_wise_sales_rm_to_gm';
//                rp_type varchar,wdt date
                $procedure13 = 'MIS.pro_depot_group_wise_sales';
//                wdt date,rp_type varchar
                $procedure14 = 'MIS.pro_dhk_grp_mkt_wise_sales';
//                wdt date,rp_type varchar,wdt1 date
                $procedure15 = 'MIS.pro_national_tgt_sales_ach';
//                wdt date,rp_type varchar


                //new peocedure 31.10.2018
                // MIS.pro_rm_product_wise_sales(wdt date)
                $procedure37 = 'MIS.pro_rm_product_wise_sales';

                $procedure_pns = 'mis.PROC_NATIONAL_STOCK';


                $work_date_dr= trim($testarr['work_date_dr']);
                $rep_type_dr=trim($testarr['rep_type_dr']);
                $sec_work_day_dr=trim($testarr['2nd_work_day_dr']);
                $prev_rep_mon_dr=trim($testarr['prev_rep_mon_dr']);


                //execute mis.pro_product_group_wise_sales('11-AUG-18','JUL-18','DAILY');
                $bindings11 = [
                    'wdt' =>$work_date_dr,
                    'prm'=>$prev_rep_mon_dr,
                    'rp_type'=>$rep_type_dr
                ];

                //execute mis.pro_group_wise_sales_rm_to_gm('DAILY','11-AUG-18');
                $bindings12 = [
                    'rp_type' =>$rep_type_dr,
                    'wdt'=>$work_date_dr
                ];

                //execute mis.pro_depot_group_wise_sales('11-AUG-18','DAILY');
                $bindings13 = [

                    'wdt'=>$work_date_dr,
                    'rp_type'=>$rep_type_dr
                ];

                //execute mis.pro_dhk_grp_mkt_wise_sales('11-AUG-18','DAILY','11-AUG-18');

                $bindings14 = [
                    'wdt' => $work_date_dr,
                    'rp_type'=>$rep_type_dr,
                    'wdt1'=>$sec_work_day_dr
                ];

                //execute mis.pro_national_tgt_sales_ach('11-AUG-18','DAILY');
                $bindings15 =$bindings13;

                $bindings37 = [
                    'wdt' =>$work_date_dr
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure11." | Daily Report";;
                $run_status = 0;
                $endTime = null;
                $sl = 1;

                try{

                    $resultcr11 = DB::executeProcedure($procedure11,$bindings11);
                    $statuscr11 = 'done 11';

                    $error_msg_dt='done_suc';
                    $run_status = 1;

                }catch (Oci8Exception $e){
                    $statuscr11 = $e->getMessage();
                    $total_message='NotDTotal';

                    $error_msg_dt='done_error';
                    $run_status = 0;
                }

                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];


                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure12." | Daily Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    $resultcr12 = DB::executeProcedure($procedure12,$bindings12);
                    $statuscr12 = 'done 12';

                    $error_msg_dt='done_suc';
                    $run_status = 1;

                }catch (Oci8Exception $e){
                    $statuscr12 = $e->getMessage();
                    $total_message='NotDTotal';

                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];


                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure13." | Daily Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    $resultcr13 = DB::executeProcedure($procedure13,$bindings13);
                    $statuscr13 = 'done 13';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr13 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure14." | Daily Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    $resultcr14 = DB::executeProcedure($procedure14,$bindings14);
                    $statuscr14 = 'done 14';

                    $error_msg_dt='done_suc';

                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr14 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];


                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure15." | Daily Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    $resultcr15 = DB::executeProcedure($procedure15,$bindings15);
                    $statuscr15 = 'done 15';

                    $error_msg_dt='done_suc';
                    $run_status = 1;

                }catch (Oci8Exception $e){
                    $statuscr15 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure37." | Daily Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                //31.10.2018
                try{

                    $resultcr37 = DB::executeProcedure($procedure37,$bindings37);
                    $statuscr37 = 'done 37';
                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr37 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

//                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//                $procedure_name = $procedure_pns." | Daily Report";;
//                $run_status = 0;
//                $endTime = null;
//                $sl++;
//                //procedure natinal stock
//                try{
//                    $result_pns = DB::executeProcedure($procedure_pns,[]);
//                    if($result_pns){
//                        Log::info('Procedure National Stock completed');
//                    }
//                    $run_status = 1;
//                }catch (Oci8Exception $e){
//                    Log::info('Procedure National Stock Not completed');
//                    Log::info($e->getMessage());
//                    $run_status = 0;
//                }
//                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//
//                $logs[] = [
//                    'sl' => $sl,
//                    'proc_name' => $procedure_name,
//                    'status' => $run_status,
//                    'stime' => $startTime,
//                    'etime' => $endTime
//                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = "MIS.pro_daily_sales_achivement | Daily Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                //procedure daily sales achievement
                try{
                    $result_dpdsa = DB::executeProcedure('MIS.pro_daily_sales_achivement',[
                        'work_date' => $work_date_dr,
                        'rp_type' => $rep_type_dr
                    ]);
                    if($result_dpdsa){
                        Log::info('Procedure daily sales achievement completed | daily report');
                        $run_status = 1;
                    }
                }catch (Oci8Exception $e){
                    Log::info('Procedure daily sales achievement Not completed | daily report');
                    Log::info($e->getMessage());
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $this->create_log($logs);

                DB::delete('delete from mis.data_proc_status');

                DB::table('mis.data_proc_status')->insert([
                    'dt_status'=>$error_msg_dt
                ]);

                /////////////-procedure 11 to 15 end/////////////////////////////


            }

            if($request->ycr=='yes'){
                $ycr='you can do this';
            }

            //closing report start from here---------------------------------

            if($request->cr=='yes'){




                $cr='you can do this';

                ///////////////process 2 7 8 9-- //////////////////////


                $closing_sale_year=$testarr['closing_sale_year'];  //2018
                $closing_sale_month=$testarr['closing_sale_month']; //jul-18

                $closing_prev_sale_month=$testarr['closing_prev_sale_month'];
                $closing_rep_type=$testarr['closing_rep_type'];

                $closing_report_month=$testarr['closing_report_month']; //01-jul-18

                $closing_working_date=$testarr['closing_working_date'];
                $closing_2nd_working_date=$testarr['closing_2nd_working_date'];


                ////////////


                $bindings = [
                    'sr_year' => $testarr['closing_sale_year'],
                    'sr_month' => $testarr['closing_sale_month']
                ];


                $bindings27 = [
                    'sr_month'=> $testarr['closing_sale_month'],
                    'wdt' =>$closing_working_date
                ];

                $bindings2 = [
                    'sr_year' => $testarr['closing_sale_year']
                ];

                $bindings29 = [
                    'sr_year' => $testarr['closing_sale_year'],
                    'sreport_month' => $testarr['closing_report_month']
                ];

                $bindings9 = [
                    'sr_year' => $testarr['closing_sale_year'],
                    'sr_month' => $testarr['closing_sale_month'],
                    'sreport_month' => $testarr['closing_report_month']
                ];

                $bindings17 = [
                    'sr_year'=>$closing_sale_year,
                    'sreport_month'=>$closing_report_month

                ];

                $bindings18 = [
                    'sr_year'=>$closing_sale_year,
                    'sr_month'=>$closing_prev_sale_month

                ];

                //execute mis.pro_product_group_wise_sales('11-AUG-18','JUL-18','DAILY');
                $bindings21 = [
                    'wdt' =>$closing_working_date,
                    'prm'=>$closing_prev_sale_month,
                    'rp_type'=>$closing_rep_type
                ];

                //execute mis.pro_group_wise_sales_rm_to_gm('DAILY','11-AUG-18');
                $bindings22 = [
                    'rp_type'=>$closing_rep_type,
                    'wdt' =>$closing_working_date
                ];

                //execute mis.pro_depot_group_wise_sales('11-AUG-18','DAILY');
                $bindings23 = [

                    'wdt'=>$closing_working_date,
                    'rp_type'=>$closing_rep_type
                ];

                //execute mis.pro_dhk_grp_mkt_wise_sales('11-AUG-18','DAILY','11-AUG-18');

                $bindings24 = [
                    'wdt' => $closing_working_date,
                    'rp_type'=>$closing_rep_type,
                    'wdt1'=>$closing_2nd_working_date
                ];

                //execute mis.pro_national_tgt_sales_ach('11-AUG-18','DAILY');
                $bindings25 =$bindings23;

                $bindings26 = [
                    'prm'=>$closing_prev_sale_month,
                    'sr_month'=>$closing_sale_month

                ];

                // MIS.pro_rm_product_wise_sales(wdt date)

                $bindings38=[
                    'wdt'=>$closing_working_date
                ];

                $bindingYearWiseRanking = [
                    'sr_month' => $closing_sale_month
                ];


                $procedure = 'MIS.pro_month_wise_sales_report';
                $procedure27 = 'MIS.pro_month_closing_data';
                $procedure2 = 'MIS.pro_summary_of_sales';

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
                $procedure17 = 'MIS.pro_gm_sm_sales_analysis_ach';
                $procedure18 = 'MIS.pro_rm_sales_analysis_ach';
                $procedure19 = 'MIS.pro_year_wise_team_performance';
                $procedure20 = 'MIS.pro_company_wise_sales_summary';
                $procedure21 = 'MIS.pro_product_group_wise_sales';
//                wdt date,prm varchar,rp_type varchar
                $procedure22 = 'MIS.pro_group_wise_sales_rm_to_gm';
//                rp_type varchar,wdt date
                $procedure23 = 'MIS.pro_depot_group_wise_sales';
//                wdt date,rp_type varchar
                $procedure24 = 'MIS.pro_dhk_grp_mkt_wise_sales';
//                wdt date,rp_type varchar,wdt1 date
                $procedure25 = 'MIS.pro_national_tgt_sales_ach';
//                wdt date,rp_type varchar

                $procedure26 = 'MIS.pro_product_rank_depot_sales';

                $procedure29 = 'MIS.PRO_yearw_sdata_ieus_wb03_b04';
                $procedure30 = 'MIS.pro_yearwise_team_per_wb03_b04';
                $procedure31 = 'MIS.pro_summary_of_sales_wb03_b04';
                $procedure32 = 'MIS.pro_month_wise_sales_rp_b03b04';
                $procedure33 = 'MIS.pro_DEPot_TEAM_WS_HIS_wb03_b04';
                $procedure34 = 'MIS.pro_compw_sales_sum_WB03_B04';
                $procedure35 = 'MIS.pro_all_comp_sales_cw_wb03_b04';
                $procedure36 = 'MIS.pro_all_company_sales_wb03_b04';


                $procedure38 = 'MIS.pro_rm_product_wise_sales';

                $procedureYearWiseRanking = 'mis.pro_brand_ranking_yearly';

                $procedure_cpns   = 'mis.PROC_NATIONAL_STOCK';
                $procedure_cpysa  = 'mis.PRO_YEARLY_SALES_ANALYSIS';
                $procedure_cpysaw = 'mis.PRO_YEARLY_SALES_ANALYSIS_WEB';
                $procedure_cpcsw  = 'mis.PRO_YEARLY_COM_SALES_WEB';


                ////////////////////////////
                // --total proce 19 + new 8=27proedures

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure27." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl = 1;

                try{

                    $resultcr27= DB::executeProcedure($procedure27,$bindings27);
                    $statuscr27 = 'done closing19';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 27 '.$resultcr27);
                    $run_status = 1;

                }catch (Oci8Exception $e){
                    $statuscr27 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];


                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    Log::info($bindings);
                    $resultcr = DB::executeProcedure($procedure,$bindings);
                    Log::info('procedure 1 '.$resultcr);
                    $statuscr = 'done closing1';
                    $run_status = 1;
                    $error_msg_dt='done_suc';

                }catch (Oci8Exception $e){
                    $statuscr = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure2." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr2 = DB::executeProcedure($procedure2,$bindings2);
                    Log::info('procedure 2 '.$resultcr2);
                    $statuscr2 = 'done closing2';

                    $error_msg_dt='done_suc';
                    $run_status = 1;

                }catch (Oci8Exception $e){
                    $statuscr2 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];
                // ----------------------------------
                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure4." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr4 = DB::executeProcedure($procedure4,$bindings2);
                    Log::info('procedure 4 '.$resultcr4);
                    $statuscr4 = 'done closing3';

                    $error_msg_dt='done_suc';
                    $run_status = 1;

                }catch (Oci8Exception $e){
                    $statuscr4 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure5." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr5 = DB::executeProcedure($procedure5,$bindings2);
                    Log::info('procedure 5 '.$resultcr5);
                    $statuscr5 = 'done closing4';

                    $error_msg_dt='done_suc';
                    $run_status =1;
                }catch (Oci8Exception $e){
                    $statuscr5 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure6." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr6 = DB::executeProcedure($procedure6,$bindings2);
                    Log::info('procedure 6 '.$resultcr6);
                    $statuscr6 = 'done closing5';
                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr6 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure7." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr7 = DB::executeProcedure($procedure7,$bindings29);
                    Log::info('procedure 7 '.$resultcr7);
                    $statuscr7 = 'done closing6';
                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr7 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure8." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr8 = DB::executeProcedure($procedure8,$bindings29);
                    Log::info('procedure 8 '.$resultcr8);
                    $statuscr8 = 'done closing7';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr8 = $e->getMessage();
                    // Log::info($e->getMessage());
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure9." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    // Log::info();
                    $resultcr9 = DB::executeProcedure($procedure9,$bindings9);
                    Log::info('procedure 9 '.$resultcr9);
                    $statuscr9 = 'done closing8';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr9 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure17." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr17 = DB::executeProcedure($procedure17,$bindings17);
                    Log::info('procedure 17 '.$resultcr17);
                    $statuscr17 = 'done closing9';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr17 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure18." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr18 = DB::executeProcedure($procedure18,$bindings17);
                    Log::info('procedure 18 '.$resultcr18);
                    $statuscr18 = 'done closing10';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr18 = $e->getMessage();
                    // Log::info($e->getMessage());
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure19." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    // Log::info();
                    $resultcr19 = DB::executeProcedure($procedure19,$bindings17);
                    Log::info('procedure 19 '.$resultcr19);
                    $statuscr19 = 'done closing11';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr19 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];
                //$bindings18 to $bindings------------------------------------------

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure20." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr20 = DB::executeProcedure($procedure20,$bindings);
                    Log::info('procedure 20 '.$resultcr20);
                    $statuscr20 = 'done closing12';
                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr20 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure21." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr21 = DB::executeProcedure($procedure21,$bindings21);
                    Log::info('procedure 21 '.$resultcr21);
                    $statuscr21 = 'done closing113';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr21 = $e->getMessage();
                    // Log::info($e->getMessage());
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure22." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr22 = DB::executeProcedure($procedure22,$bindings22);
                    $statuscr22= 'done closing14';

                    $error_msg_dt='done_suc';
                    $run_status = 1;
                    Log::info('procedure 22 '.$resultcr22);
                }catch (Oci8Exception $e){
                    $statuscr22 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure23." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr23 = DB::executeProcedure($procedure23,$bindings23);
                    $statuscr23 = 'done closing15';
                    $error_msg_dt='done_suc';
                    $run_status = 1;
                    Log::info('procedure 23 '.$resultcr23);
                }catch (Oci8Exception $e){
                    $statuscr23 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure24." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    // Log::info();
                    $resultcr24 = DB::executeProcedure($procedure24,$bindings24);
                    $statuscr24= 'done closing16';
                    $error_msg_dt='done_suc';
                    $run_status = 1;
                    Log::info('procedure 24 '.$resultcr24);
                }catch (Oci8Exception $e){
                    $statuscr24 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure25." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    // Log::info();
                    $resultcr25 = DB::executeProcedure($procedure25,$bindings25);
                    $statuscr25 = 'done closing17';
                    $error_msg_dt='done_suc';
                    $run_status = 1;
                    Log::info('procedure 25 '.$resultcr25);
                }catch (Oci8Exception $e){
                    $statuscr25 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure26." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{


                    $resultcr26 = DB::executeProcedure($procedure26,$bindings26);
                    $statuscr26 = 'done closing18';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 26 '.$resultcr26);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr26 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];


                //new procedure 9 for dubpicate modules

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure29." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr29= DB::executeProcedure($procedure29,$bindings29);
                    // Log::info('procedure 2 '.$resultcr2);
                    $statuscr29 = 'done closing20';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 29 '.$resultcr29);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr29 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure30." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{

                    // Log::info();
                    $resultcr30 = DB::executeProcedure($procedure30,$bindings17);
                    $statuscr30 = 'done closing21';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 30 '.$resultcr30);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr30 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure31." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr31 = DB::executeProcedure($procedure31,$bindings2);
                    // Log::info('procedure 1 '.$resultcr);
                    $statuscr31 = 'done closing22';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 31 '.$resultcr31);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr31 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure32." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr32 = DB::executeProcedure($procedure32,$bindings);
                    // Log::info('procedure 1 '.$resultcr);
                    $statuscr32 = 'done closing23';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 32 '.$resultcr32);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr32 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;

                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure33." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr33 = DB::executeProcedure($procedure33,$bindings2);
                    // Log::info('procedure 1 '.$resultcr);
                    $statuscr33 = 'done closing24';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 33 '.$resultcr33);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr33 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure34." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr34 = DB::executeProcedure($procedure34,$bindings);
                    // Log::info('procedure 1 '.$resultcr);
                    $statuscr34 = 'done closing25';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 34 '.$resultcr34);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr34 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure35." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr35 = DB::executeProcedure($procedure35,$bindings2);
                    // Log::info('procedure 1 '.$resultcr);
                    $statuscr35 = 'done closing26';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 35 '.$resultcr35);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr35 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;

                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure36." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr36 = DB::executeProcedure($procedure36,$bindings2);
                    // Log::info('procedure 1 '.$resultcr);
                    $statuscr36 = 'done closing27';
                    Log::info('procedure 36 '.$resultcr36);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr36 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure38." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try{
                    $resultcr38 = DB::executeProcedure($procedure38,$bindings38);
                    $statuscr38 = 'done closing38';
                    $error_msg_dt='done_suc';
                    Log::info('procedure 38 '.$resultcr38);
                    $run_status = 1;
                }catch (Oci8Exception $e){
                    $statuscr38 = $e->getMessage();
                    $total_message='NotDTotal';
                    $error_msg_dt='done_error';
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                //Year wise brand ranking
                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedureYearWiseRanking." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                try {
                    $resultcr39 = DB::executeProcedure($procedureYearWiseRanking, $bindingYearWiseRanking);
                    $statuscr39 = 'done closing39';
                    $error_msg_dt = 'done_suc';
                    Log::info('Year ranking ' . $resultcr39);
                    $run_status = 1;
                } catch (Oci8Exception $e) {
                    Log::info('Year ranking ' . $e->getMessage());
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure_cpysa." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                //added on 21.07.20
                //procedure yearly sales analysis
                try{
                    $result_cpysa = DB::executeProcedure($procedure_cpysa,[
                        'sr_year' => $closing_sale_year,
                        'rep_month' => $closing_sale_month
                    ]);

                    if($result_cpysa){
                        Log::info('Closing | Procedure Yealy sales analysis completed');
                        $run_status = 1;
                    }
                }catch (Oci8Exception $e){
                    Log::info('Closing | Procedure Yealy sales analysis completed');
                    Log::info($e->getMessage());
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure_cpysaw." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                //procedure yearly sales analysis web
                try{
                    $result_cpysaw = DB::executeProcedure($procedure_cpysaw,[]);
                    if($result_cpysaw){
                        Log::info('Closing |Procedure Yealy sales analysis web completed');
                        $run_status = 1;
                    }
                }catch (Oci8Exception $e){
                    Log::info('Closing | Procedure Yealy sales analysis web completed');
                    Log::info($e->getMessage());
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];


                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = $procedure_cpcsw." | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                //procedure yearly company sales web
                try{
                    $result_cpcsw = DB::executeProcedure($procedure_cpcsw,[]);
                    if($result_cpcsw){
                        Log::info('Closing | Procedure yearly company sales web completed');
                        $run_status = 1;
                    }
                }catch (Oci8Exception $e){
                    Log::info('Closing | Procedure yearly company sales web Not completed');
                    Log::info($e->getMessage());
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

//                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//                $procedure_name = $procedure_cpns." | Closing Report";;
//                $run_status = 0;
//                $endTime = null;
//                $sl++;
//                //procedure natinal stock
//                try{
//                    $result_cpns = DB::executeProcedure($procedure_cpns,[]);
//                    if($result_cpns){
//                        Log::info('Closing | Procedure National Stock completed');
//                        $run_status = 1;
//                    }
//                }catch (Oci8Exception $e){
//                    Log::info('Closing | Procedure National Stock Not completed');
//                    Log::info($e->getMessage());
//                    $run_status = 0;
//                }
//                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
//
//                $logs[] = [
//                    'sl' => $sl,
//                    'proc_name' => $procedure_name,
//                    'status' => $run_status,
//                    'stime' => $startTime,
//                    'etime' => $endTime
//                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = "MIS.pro_daily_sales_achivement | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                //procedure daily sales achievement
                try{
                    $result_cpdsa = DB::executeProcedure('MIS.pro_daily_sales_achivement',[
                        'work_date' => $closing_working_date,
                        'rp_type' => $closing_rep_type
                    ]);
                    if($result_cpdsa){
                        Log::info('Procedure daily sales achievement completed | closing report');
                        $run_status = 1;
                    }
                }catch (Oci8Exception $e){
                    Log::info('Procedure daily sales achievement Not completed | closing report');
                    Log::info($e->getMessage());
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $startTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');
                $procedure_name = "mis.pro_yearly_tm_wise_sale_growth | Closing Report";;
                $run_status = 0;
                $endTime = null;
                $sl++;
                //procedure yearly team wise sales growth --30.05.2021
                try{
                    $result_pytwsg = DB::executeProcedure('mis.pro_yearly_tm_wise_sale_growth',[
                        'sr_year' => $closing_sale_year,
                        'sreport_month' => $closing_report_month
                    ]);

                    if($result_pytwsg){
                        Log::info('Closing | procedure yearly team wise sales growth completed');
                        $run_status = 1;
                    }
                }catch (Oci8Exception $e){
                    Log::info('Closing | procedure yearly team wise sales growth failed');
                    Log::info($e->getMessage());
                    $run_status = 0;
                }
                $endTime = Carbon::now('Asia/Dhaka')->format('Y/m/d H:i:s');

                $logs[] = [
                    'sl' => $sl,
                    'proc_name' => $procedure_name,
                    'status' => $run_status,
                    'stime' => $startTime,
                    'etime' => $endTime
                ];

                $this->create_log($logs);
                //end

                DB::delete('delete from mis.data_proc_status');

                DB::table('mis.data_proc_status')->insert([
                    'dt_status'=>$error_msg_dt
                ]);

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
                    'dt_status1'=>$statusdt,
                    'result_dt1'=>$resultdt,
                    'dt_status2_sms'=>$statusdt28,
                    'result_dt2_sms'=>$resultdt28,

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
                    'subform'=>$testarr,
                    'message_status11'=>$statuscr11,
                    'message_status12'=>$statuscr12,
                    'message_status13'=>$statuscr13,
                    'message_status14'=>$statuscr14,
                    'message_status15'=>$statuscr15,
                    'message_status16'=>$statuspt16,
                    'message_status17'=>$statuscr17,
                    'message_status18'=>$statuscr18,
                    'message_status19'=>$statuscr19,
                    'message_status20'=>$statuscr20,
                    'message_status21'=>$statuscr21,
                    'message_status22'=>$statuscr22,
                    'message_status23'=>$statuscr23,
                    'message_status24'=>$statuscr24,
                    'message_status25'=>$statuscr25,
                    'message_status26'=>$statuscr26,
                    'message_status27'=>$statuscr27,
                    'message_status28'=>$statusdt28,

                    'message_status29'=>$statuscr29,
                    'message_status30'=>$statuscr30,
                    'message_status31'=>$statuscr31,
                    'message_status32'=>$statuscr32,
                    'message_status33'=>$statuscr33,
                    'message_status34'=>$statuscr34,
                    'message_status35'=>$statuscr35,
                    'message_status36'=>$statuscr36,
                    'message_status37'=>$statuscr37,
                    'message_status38'=>$statuscr38,

                    'result28'=>$result28dt,
                    'total_message'=>$total_message,
//                    'tg_pt'=>trim($testarr['target_mon_pt'])
//                    'bindings'=>$bindings,
//                    'bindings2'=>$bindings2,
//                    'bindings9'=>$bindings9,
//                    'bindings17'=>$bindings17,
// //                    'bindings18'=>$bindings18,
//                    'bindings21'=>$bindings21,
//                    'bindings22'=>$bindings22,
//                    'bindings23'=>$bindings23,
//                    'bindings24'=>$bindings24,
//                    'bindings25'=>$bindings25,
//                    'bindings26'=>$bindings26,
//                    'bindings27'=>$bindings27,
                    // 'bindings28'=>$bindings28,
                    // 'dayy'=>$dayy
                ]);
        }//ajax end

    }//function end

    public function create_log($logs){
        DB::setDateFormat('YYYY-MM-DD HH24:MI:SS');
        foreach ($logs as $log){
            DB::table('mis.daily_data_process_log')->insert(
                [
                    'PROCESS_DATE' => Carbon::now('Asia/Dhaka')->format('Y-m-d'),
                    'SL' => $log['sl'],
                    'PROCEDURE_NAME' => $log['proc_name'],
                    'START_TIME' => $log['stime'],
                    'END_TIME' => $log['etime'],
                    'STATUS' => $log['status']
                ]
            );
        }

    }
    //
    public function getWorkingDay(Request $request){
        if($request->ajax()){

            DB::statement("alter session set nls_date_format = 'DD-MON-RR'");
            $current_monthly_wd=DB::select("select working_day,working_date,day,working_day_status,total_working_day
 from mis.monthly_working_day
 where to_date(working_date,'DD-MON-RR')=?",[$request->text]);

            $info_baseday=0;
            $monn=strtoupper(explode('-',$request->text)[1]);
            $yr=explode('-',$request->text)[2];


            $arrdaybar = array(
                'JAN'=>1,
                'FEB'=>2,
                'MAR'=>3,
                'APR'=>4,
                'MAY'=>5,
                'JUN'=>6,
                'JUL'=>7,
                'AUG'=>8,
                'SEP'=>9,
                'OCT'=>10,
                'NOV'=>11,
                'DEC'=>12
            );
            $arrmonth = array(
                1 => 'JAN',
                2 =>'FEB',
                3 =>'MAR',
                4 =>'APR',
                5 =>'MAY',
                6 =>'JUN',
                7 =>'JUL',
                8 =>'AUG',
                9 =>'SEP',
                10 =>'OCT',
                11 =>'NOV',
                12 =>'DEC'

            );
            $monthnumber=$arrdaybar[$monn];

            if($monthnumber==1){
                $monthnumber=12;
                $yr=$yr-1;
            }else{
                $monthnumber=$monthnumber-1;
                $monthnumber=$arrmonth[$monthnumber];
                $yr=$yr;
            }


            if($request->rep_type=='DAILY'){

                $info_baseday=DB::select("SELECT
            M.WORKING_DAY, M.WORKING_DATE,to_char(M.WORKING_DATE,'RR') yy,to_char(M.WORKING_DATE,'DD-MON-RR') as format_working_date, to_char(M.WORKING_DATE,'MON') as wd, M.DAY,
               M.WORKING_DAY_STATUS, M.TOTAL_WORKING_DAY, M.CREATE_DATE
            FROM MIS.MONTHLY_WORKING_DAY M
            where to_char(M.WORKING_DATE,'MON')=?
            and to_char(M.WORKING_DATE,'RR')=?
            and M.WORKING_DAY=?",[$monthnumber,$yr,$current_monthly_wd[0]->working_day]);

            }else if($request->rep_type=='CLOSING'){

                $info_baseday=DB::select(" SELECT
                M.WORKING_DAY, M.WORKING_DATE,to_char(M.WORKING_DATE,'RR') yy,to_char(M.WORKING_DATE,'DD-MON-RR') as format_working_date, to_char(M.WORKING_DATE,'MON') as wd, M.DAY,
                   M.WORKING_DAY_STATUS, M.TOTAL_WORKING_DAY, M.CREATE_DATE
                FROM MIS.MONTHLY_WORKING_DAY M
                where to_char(M.WORKING_DATE,'MON')=?
                and to_char(M.WORKING_DATE,'RR')=?
                and WORKING_DAY_STATUS='Y'
                and WORKING_DAY=(SELECT MAX(TOTAL_WORKING_DAY) FROM MIS.MONTHLY_WORKING_DAY where to_char(WORKING_DATE,'MON')=?
                and to_char(WORKING_DATE,'RR')=?)",[$monthnumber,$yr,$monthnumber,$yr]);
            }


            return response()->json([
                'cmwd'=>$current_monthly_wd,
                'infobaseday'=>$info_baseday,
                'paredata'=>$request->text,
                'monthnumber'=>$monthnumber,
                'year'=>$yr,
                'total_day'=>$current_monthly_wd[0]->working_day
            ]);
        }
    }

    //7/3/2019-----

    public function dt_sta_process_post(Request $request){

        if($request->ajax()){

            $dt_status=DB::select("select dt_status
 from mis.data_proc_status");

            if($dt_status){
                return response()->json([
                    'dtstatus'=>$dt_status[0]->dt_status
                ]);

            }else{

                return response()->json([
                    'dtstatus'=>"no_status"
                ]);

            }




        }

    }
}
