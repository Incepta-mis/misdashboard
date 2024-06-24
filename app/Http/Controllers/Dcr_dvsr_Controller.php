<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dcr_dvsr_Controller extends Controller
{
    public function dvsr_view(){

        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        $p_group = DB::select('Select distinct PRODUCT_GROUP
                               from MIS.DCR_DOCTOR_VISIT_SUMMARY
                               order by PRODUCT_GROUP');

        $terr_id = DB::select("Select distinct TERR_ID
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               where PRODUCT_GROUP='ASTER'
                               order by TERR_ID");

        return view('dcr_reports_layout.v_doctor_visit_summary')
               ->with(['pgrp'=>$p_group,'terr_id'=>$terr_id]);
    }

    public function dvsr_data(Request $request){
        if($request->ajax()){

            $resp_data = DB::select("SELECT PRODUCT_GROUP, TERR_ID, 
                                       EMPLOYEE_ID, EMPLOYEE_NAME, sum(nvl(NO_OF_DOCTOR_VISIT,0)) NO_OF_DOCTOR_VISIT, 
                                       sum(nvl(NO_OF_CALL,0)) NO_OF_CALL
                                    FROM MIS.DCR_DOCTOR_VISIT_SUMMARY
                                    where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                    and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                    and dcr_date between to_date('$request->dat1','DD-MM-RR') and to_date('$request->dat2','DD-MM-RR')
                                    group by product_group,terr_id,EMPLOYEE_ID, EMPLOYEE_NAME");

            return response()->json($resp_data);
        }

    }

     public function terr_list(Request $request){
        if($request->ajax()){

            $resp_terr_list = DB::select("select distinct terr_id
                                         from mis.DCR_DOCTOR_VISIT_SUMMARY
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                         order by terr_id");

            $dlist = "<option value='All'>All</option>";
  
            return response()->json($resp_terr_list);
        }
    }


    ////////////////////item wise utilization/////////////////////////////

    
    public function item_w_utilize_view(){

        // DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        $p_group = DB::select('Select distinct PRODUCT_GROUP
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               order by PRODUCT_GROUP');

        $terr_id = DB::select("Select distinct TERR_ID
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               where PRODUCT_GROUP='ASTER'
                               order by TERR_ID");

        $item_name = DB::select("Select distinct ITEM_NAME
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               where PRODUCT_GROUP='ASTER'
                               order by ITEM_NAME");

        $dcr_month = DB::select("select distinct upper(to_char(dcr_mon,'Mon-YY')) mnth
        from MIS.DCR_ITEM_WISE_UTILIZATION order by to_date(mnth,'Mon-YY') desc");


               return view('dcr_reports_layout.v_item_wise_utilization')
               ->with(['pgrp'=>$p_group,'dcr_month'=>$dcr_month,'terr_id'=>$terr_id,'item_name'=>$item_name]);
    }
    
    public function item_utilize_terr_list(Request $request){
        if($request->ajax()){

            $DataList = [];

            $resp_terr_list = DB::select("select distinct terr_id
                                         from mis.DCR_ITEM_WISE_UTILIZATION
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                         order by terr_id");
            $DataList[]=$resp_terr_list;

            $resp_terr_list = DB::select("select distinct item_name
                                         from mis.DCR_ITEM_WISE_UTILIZATION
                                         where PRODUCT_GROUP = decode('$request->item_list','All',product_group,'$request->pgrp')
                                         order by item_name");
            $DataList[]=$resp_terr_list;

            return response($DataList);

            // $dlist = "<option value='All'>All</option>";
  
            // return response()->json($resp_terr_list);
        }
    }

    // public function item_utilize_item_name_list(Request $request){
    //     if($request->ajax()){

    //         $resp_terr_list = DB::select("select distinct item_name
    //                                      from mis.DCR_ITEM_WISE_UTILIZATION
    //                                      where PRODUCT_GROUP = decode('$request->item_list','All',product_group,'$request->pgrp')
    //                                      order by item_name");

    //         $dlist = "<option value='All'>All</option>";
  
    //         return response()->json($resp_terr_list);
    //     }
    // }

    public function item_utilize_data(Request $request){
        if($request->ajax()){

            $resp_data = DB::select("SELECT PRODUCT_GROUP, TERR_ID, 
                                       EMPLOYEE_ID, EMPLOYEE_NAME,ITEM_ID,ITEM_NAME, 
                                       QTY_RECEIVED,QTY_UTILIZED
                                    FROM MIS.DCR_ITEM_WISE_UTILIZATION
                                    where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                    and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                    and item_name = decode('$request->iname','All',item_name,'$request->iname')
                                    and dcr_month = '$request->mnth'
                                    group by product_group,terr_id,EMPLOYEE_ID, EMPLOYEE_NAME,ITEM_ID,ITEM_NAME, 
                                       QTY_RECEIVED,QTY_UTILIZED");
             
             // $resp_data = DB::Select("select * from mis.DCR_ITEM_WISE_UTILIZATION where rownum < 10");

             return response()->json($resp_data);
        }

    }

    // Doctor Wise Item Utilization

    public function dwiu_view(){
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        $p_group = DB::select('Select distinct PRODUCT_GROUP
                               from MIS.DCR_DOC_WISE_ITEM_UTILIZATION
                               order by PRODUCT_GROUP');

        $terr_id = DB::select("Select distinct TERR_ID
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               where PRODUCT_GROUP='ASTER'
                               order by TERR_ID");

        return view('dcr_reports_layout.v_doctor_wise_item_utilization')
            ->with(['pgrp'=>$p_group,'terr'=>$terr_id]);
    }

    public function dwui_data(Request $request){
        if($request->ajax()){
            $responses = DB::select("SELECT PRODUCT_GROUP, TERR_ID, 
                                   EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, 
                                   DOCTOR_NAME, ITEM_ID, ITEM_NAME, 
                                   sum(QTY_UTILIZED) QTY_UTILIZED
                                FROM MIS.DCR_DOC_WISE_ITEM_UTILIZATION
                                where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                and doctor_name = decode('$request->dname','All',doctor_name,'$request->dname')
                                and dcr_date between to_date('$request->dat1','DD-MM-RR') and to_date('$request->dat2','DD-MM-RR')
                                group by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME, ITEM_ID, ITEM_NAME
                                order by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME")
                                ;

           return response()->json($responses);
        }
    }

    public function dwui_terr_doc_list(Request $request){
        if($request->ajax()){
            
            if($request['type'] == 2)
            {

            $resp_doc_list = DB::select("select distinct doctor_name,doctor_id
                                         from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',doctor_name,'$request->pgrp')
                                         and terr_id = '$request->tid'
                                         order by doctor_name");

            return response()->json(['doctors'=>$resp_doc_list]);



            }
            else if($request['type'] == 1){

                $resp_terr_list = DB::select("select distinct terr_id
                                     from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                     where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                     order by terr_id");

                return response()->json(['terr'=>$resp_terr_list]);
            }
            else{

            $resp_terr_list = DB::select("select distinct terr_id
                                         from mis.DCR_DOC_WISE_ITEM_UTILIZATION
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                         order by terr_id");

            $resp_doc_list = DB::select("select distinct doctor_name
                                         from mis.DCR_DOC_WISE_ITEM_UTILIZATION
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',doctor_name,'$request->pgrp')
                                         order by doctor_name");

            return response()->json(['terr'=>$resp_terr_list,'doctors'=>$resp_doc_list]);

        }

        }
    }

    //End doctor wise item utilization

    //start---Item wise Doctor Details ----------------------------
    
    public function item_w_doc_details_view(){
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        $p_group = DB::select('Select distinct PRODUCT_GROUP
                               from MIS.DCR_DOC_WISE_ITEM_UTILIZATION
                               order by PRODUCT_GROUP');

        $terr_id = DB::select("Select distinct TERR_ID
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               where PRODUCT_GROUP='ASTER'
                               order by TERR_ID");

        $item_name = DB::select("Select distinct ITEM_NAME
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               where PRODUCT_GROUP='ASTER'
                               order by ITEM_NAME");

        return view('dcr_reports_layout.v_item_w_doc_details')
            ->with(['pgrp'=>$p_group,'terrs'=>$terr_id,'items'=>$item_name]);
    }

    public function item_w_doc_details_item_data(Request $request){
        if($request->ajax()){
            $responses = DB::select("SELECT PRODUCT_GROUP, TERR_ID, 
                                   EMPLOYEE_ID, EMPLOYEE_NAME, ITEM_ID, ITEM_NAME, DOCTOR_ID, 
                                   DOCTOR_NAME ,sum(QTY_UTILIZED) QTY_UTILIZED
                                FROM MIS.DCR_DOC_WISE_ITEM_UTILIZATION
                                where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                and item_name = decode('$request->itemnam','All',item_name,'$request->itemnam')
                                and dcr_date between to_date('$request->dat1','DD-MM-RR') and to_date('$request->dat2','DD-MM-RR')
                                group by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, ITEM_ID, ITEM_NAME, DOCTOR_ID, DOCTOR_NAME
                                order by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME");

           return response()->json($responses);
        }
    }

    public function item_w_doc_details_item_list(Request $request){
        if($request->ajax()){

            $resp_terr_list = DB::select("select distinct terr_id
                                         from mis.DCR_DOC_WISE_ITEM_UTILIZATION
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                         order by terr_id");

            $resp_item_list = DB::select("select distinct item_name
                                         from mis.DCR_DOC_WISE_ITEM_UTILIZATION
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',doctor_name,'$request->pgrp')
                                         order by item_name");

            return response()->json(['terr'=>$resp_terr_list,'item_name'=>$resp_item_list]);

        }
    }

    //Item wise Doctor Details---------end-------------------

    // Doctor Wise visit details

    public function dwvd_view(){
        DB::statement("alter session set nls_date_format = 'dd-mm-yy'");

        $p_group = DB::select('Select distinct PRODUCT_GROUP
                               from MIS.DCR_DOCTOR_WISE_VISIT_DETAILS
                               order by PRODUCT_GROUP');

        $terr_id = DB::select("Select distinct TERR_ID
                               from MIS.DCR_ITEM_WISE_UTILIZATION
                               where PRODUCT_GROUP='ASTER'
                               order by TERR_ID");

        return view('dcr_reports_layout.v_doctor_wise_visit_details')
            ->with(['pgrp'=>$p_group,'terrs'=>$terr_id]);
    }

    public function dwvd_data(Request $request){
        if($request->ajax()){
            $responses = DB::select("SELECT PRODUCT_GROUP, TERR_ID, 
                                   EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, 
                                   DOCTOR_NAME, sum(NO_OF_CALL) NO_OF_CALL
                                FROM MIS.DCR_DOCTOR_WISE_VISIT_DETAILS
                                where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                and doctor_name = decode('$request->dname','All',doctor_name,'$request->dname')
                                and dcr_date between to_date('$request->dat1','DD-MM-RR') and to_date('$request->dat2','DD-MM-RR')
                                group by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME
                                order by PRODUCT_GROUP, TERR_ID, EMPLOYEE_ID, EMPLOYEE_NAME, DOCTOR_ID, DOCTOR_NAME,NO_OF_CALL");

           return response()->json($responses);
        }
    }

    public function dwvd_terr_doc_list(Request $request){
        if($request->ajax()){


            if($request['type'] == 2)
            {

            $resp_doc_list = DB::select("select distinct doctor_name,doctor_id
                                         from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',doctor_name,'$request->pgrp')
                                         and terr_id = '$request->tid'
                                         order by doctor_name");

            return response()->json(['doctors'=>$resp_doc_list]);



            }
            else if($request['type'] == 1){

                $resp_terr_list = DB::select("select distinct terr_id
                                     from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                     where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                     order by terr_id");

                return response()->json(['terr'=>$resp_terr_list]);
            }
            else
            {
                $resp_terr_list = DB::select("select distinct terr_id
                                     from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                     where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                     order by terr_id");

                $resp_doc_list = DB::select("select distinct doctor_name,doctor_id
                                             from mis.DCR_DOCTOR_WISE_VISIT_DETAILS
                                             where PRODUCT_GROUP = decode('$request->pgrp','All',doctor_name,'$request->pgrp')
                                             order by doctor_name");

            return response()->json(['terr'=>$resp_terr_list,'doctors'=>$resp_doc_list]);
            }

            

        }
    }

    //End doctor wise item utilization

//terr_wise_plan_vs_it

public function terr_wise_plan_vs_it()
    {

        $p_group = DB::select('Select distinct PRODUCT_GROUP
                               from MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                               order by PRODUCT_GROUP');

        $terr_id = DB::select("Select distinct TERR_ID
                               from MIS.DCR_TERR_WISE_PLAN_VS_VISIT                              
                               order by TERR_ID");

        // $dcr_month = DB::select("select distinct upper(to_char(dcr_month,'Mon-YY')) mnth
        // from MIS.DCR_TERR_WISE_PLAN_VS_VISIT order by to_date(mnth,'Mon-YY') desc");

        $dcr_month = DB::select("select distinct to_char(to_date(dcr_month,'MON-RR'),'MM-RR'),dcr_month mnth
                                    from MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                                    order by to_char(to_date(dcr_month,'MON-RR'),'MM-RR') desc");


        return view('dcr_reports_layout.v_terr_wise_plan_visit')
            ->with(['pgrp' => $p_group, 'dcr_month' => $dcr_month, 'terr_id' => $terr_id]);
    }


    public function terr_wise_plan_vs_it_data(Request $request)
    {
        if ($request->ajax()) {

            $resp_data = DB::select("SELECT PRODUCT_GROUP, TERR_ID, 
                                        EMPLOYEE_ID, EMPLOYEE_NAME,DOCTOR_ID,DOCTOR_NAME, 
                                        NO_OF_CALL,NO_OF_VISIT
                                    FROM MIS.DCR_TERR_WISE_PLAN_VS_VISIT
                                    where product_group = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                    and terr_id = decode('$request->terr','All',terr_id,'$request->terr')
                                    and dcr_month = decode('$request->mnth','All',dcr_month,'$request->mnth') 
                                    group by product_group,terr_id,EMPLOYEE_ID, EMPLOYEE_NAME,DOCTOR_ID,DOCTOR_NAME, 
                                       NO_OF_CALL,NO_OF_VISIT");

            return response()->json($resp_data);
        }

    }

    public function terr_wise_plan_vs_it_list(Request $request)
    {
        if ($request->ajax()) {

            $resp_terr_list = DB::select("select distinct terr_id
                                         from mis.DCR_TERR_WISE_PLAN_VS_VISIT
                                         where PRODUCT_GROUP = decode('$request->pgrp','All',product_group,'$request->pgrp')
                                         order by terr_id");

            return response()->json(['terr' => $resp_terr_list]);
        }
    }

}
