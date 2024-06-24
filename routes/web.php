<?php

use App\User;

Route::get('/modules_info', 'AssignedController@modules_info');

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm');
Route::get('logout', 'Auth\LoginController@logout');
Route::post('register_user', 'Auth\RegisterController@register');
Route::post('forgot_pass', 'ForgotPassController@check_send_mail');

//menu_display_for_sale_report--28.11.2018

Route::get('get_menu_display','EmpCompetency_Controller@getMenushow');
Route::get('get_menu_display_datapro','EmpCompetency_Controller@getMenushowbtn');


//home after successful login
Route::get('home', 'HomeController@index')->middleware(['auth', 'recheck']);

//user setting/profile
Route::group(['prefix'=>'user', 'middleware' => ['auth','recheck']],function (){
   Route::get('profile','HomeController@profile');
   Route::post('changePass','HomeController@changePassword');
});


//daily reports
Route::group(['prefix' => 'drep', 'middleware' => ['auth', 'recheck']], function () {

    //--------National Stock------------------------------------
    Route::get('nat_stock', 'ReportsController@rep_nat_stock_view');
    Route::get('resp_nat_stock', 'ReportsController@nat_stock_table_data');


});
//sales reports
/////////////////////////////////SALE REPORT 8.05.2019/////////////////////////
///**************************************************************************////
////////////////////////////////////////////////////////////////////////////////

//sales reports--8.05.2019/



////////////////////////////prefix srep////////////////////////////////////////
Route::group(['prefix' => 'srep', 'middleware' => ['auth', 'recheck']], function () {

    //    ---------- RM Sales Modal--------------------------------------
    
    Route::post('rm_sales_modal','ReportsController@rm_sales_modal');

    ////////////////////////////prefix history report////////////////////////////////////////
    Route::group(['prefix' => 'hrep', 'middleware' => ['auth', 'recheck']], function () {
        ////////////////////////////prefix hsaleper////////////////////////////////////////

        ///**
        //**--------historical Report--------Channel wise yearly sales(all company)----------------------------
        //**/
        Route::get('month_daily_sales', 'ReportsController@month_wise_sales_view');

        ///**
        //**--------historical Report--------Channel wise yearly sales(all company)----------------------------
        //**/
        Route::get('summary_of_sales', 'ReportsController@summary_of_sales_view');

        ///**
        //**--------historical Report--------Company wise yearly sales----------------------------
        //**/

        Route::get('sale_report', 'SaleReportController@sale_report_view');
///**
        //**--------historical Report--------Comparative Analysis for Sales Report----------------------------
        //**/
        Route::get('caos_report','ComparativeAnalysisReportController@index');


        ///**
        //**--------historical Report--------Channel & Company wise sales----------------------------
        //**/

        Route::get('sale_report_channelw', 'SaleReportController@sale_report_channelw_view');

        //23.3.2019....................history company base (T-3) will hide
        //    Route::get('dep_teamw_saleHis', 'SaleReportController@dep_teamw_saleHis_view');

        ///**
        //**--------historical Report--------Team Growth%----------------------------
        //**/
        Route::get('team_growth_percent', 'TgpRepController@team_growth_percent');



        ////////////////////////////prefix history report-----sales performance////////////////////////////////////////
        Route::group(['prefix' => 'hsaleper', 'middleware' => ['auth', 'recheck']], function () {
            ///**
            //**--------historical Report---sales performance-----Team wise----------------------------
            //**/
            Route::get('performance_report', 'PerformanceController@performance_report_view');
            ///**
            //**--------historical Report---sales performance-----GM wise----------------------------
            //**/
            Route::get('gm_ach_rep', 'SaleReportController@gm_ach_rep_v');
            ///**
            //**--------historical Report---sales performance-----SM/ASM/DSM wise----------------------------
          Route::get('sm_asm_dsm_ach_rep', 'SaleReportController@sm_asm_dsm_ach_rep_v');
            ///**
            //**--------historical Report---sales performance-----RM wise----------------------------
            //**/
            Route::get('rm_ach_report', 'SaleReportController@rm_ach_report_view');
        });

        ////////////////////////////prefix history report-----branding////////////////////////////////////////
        Route::group(['prefix' => 'hbrand', 'middleware' => ['auth', 'recheck']], function () {
            ////////////////////////////prefix hbrand////////////////////////////////////////

            ///**
            //**--------historical Report--------brand ranking-------Monthly Ranking--------------------
            //**/
            Route::get('depot_wise_product_rank', 'Product_Rank_Controller@product_rank_view');
            //MASROOR
            Route::get('depotWiseProductRankExcel/', 'Product_Rank_Controller@depotWiseProductRankExcel')
            ->name('depotWiseProductRankExcel');
            Route::get('yearlyProductRankExcel/', 'Product_Rank_Controller@yearlyProductRankExcel')
            ->name('yearlyProductRankExcel');
            
            //Raqib 
            Route::get('yearly_product_rank', 'Product_Rank_Controller@yearly_product_rank_view');
            Route::get('resp_year_wise_prank', 'Product_Rank_Controller@year_wise_rank_data');

            Route::get('brand_ranking_report','BrandRankingReportController@index');
            Route::post('processBrandData','BrandRankingReportController@processBrandData');
            Route::post('previewBrandData','BrandRankingReportController@previewBrandData');
        });

       

    });

    //lists of ajax********************************************************

    //****************************************************************************
    //***********************HISTORICAL REPORT************************************
    //****************************************************************************
        //historical Report-------Channel wise yearly sales(all company)--------------------------------------
            Route::get('resp_month_daily_sales', 'ReportsController@month_daily_sales_data');
        //historical Report-------Channel &amp; group wise sales(all company)------------------------------------
            Route::get('resp_summary_data','ReportsController@summary_data');
        //historical Report-------Company wise yearly sales------------------------------------
            Route::get('resp_allcompany_sale','SaleReportController@all_company_sale_table_data');
        //historical Report------Channel & Company wise sales------------------------------------
            Route::get('resp_allcompany_sale_channelw','SaleReportController@allcomp_sale_channelwise_data');
            //Route::get('resp_depot_teamw_sales_history', 'SaleReportController@resp_depot_teamw_sales_history_data');
        //historical Report--------Team Growth%------------------------------------
        Route::get('resp_tgp_data', 'TgpRepController@team_growth_percent_data_upd');

            //historical Report----sales performance----team wise------------------------------------
            Route::get('resp_perform_data', 'PerformanceController@resp_perform_table_data');
            //---historical Report---sales performance-----gm wise----------------------------
            Route::get('resp_gm_achment', 'SaleReportController@resp_gm_achment');
            //---historical Report---sales performance-----SM/ASM/DSM wise----------------------------
            Route::get('resp_sm_dsm_achment', 'SaleReportController@resp_sm_dsm_achment');
           // ----historical Report---sales performance-----RM wise----------------------------
            Route::get('resp_rm_ach', 'SaleReportController@resp_rm_ach_table_data');


            //----historical Report--------brand ranking-------Monthly Ranking--------------------
            Route::get('resp_depot_wise_prank', 'Product_Rank_Controller@product_rank_resp');

    //****************************************************************************
    //***********************current month REPORT************************************
    //****************************************************************************

    ////////////////////////////prefix crep////////////////////////////////////////
    Route::group(['prefix' => 'cmrep', 'middleware' => ['auth', 'recheck']], function () {
        ////////////////////////////prefix CREP////////////////////////////////////////
        ///**
        //**--------current month Report-----------product group wise sales--------------------
        //**/

        Route::get('pgroup_wise_summary', 'ReportsController@pgroup_wise_summary');

        ///**
        //**--------current month Report-----------Depot Wise Sales--------------------
        //**/
        Route::get('depot_wise_sales', 'ReportsController@depot_wise_sales');

        Route::get('depot_product_activity', 'ReportsController@depot_product_activity');
        Route::post('getDepotActivity', 'ReportsController@getDepotActivityData');


        //    /**
        //     **---------current month Report----------dhk grp and mkt Report------------------------------------
        //     **/
        Route::get('dhk_grp_mkt_wise_product', 'PerformanceController@dhk_grp_mkt_report_view');
            ////////////////////////////prefix current month report-----sales performance////////////////////////////////////////
            Route::group(['prefix' => 'csaleper', 'middleware' => ['auth', 'recheck']], function () {
                ///**
                //**--------current month Report------sales performance-----SM Wise--------------------
                //**/
                Route::get('sm_sales', 'ReportsController@sm_wise_summary');
                ///**
                //**--------current month Report------sales performance------rm Wise--------------------
                //**/
                Route::get('rm_sales_dtl', 'ReportsController@rm_sales_dtl');

                ///**
                //**-------current month Report---sales performance------national qty trg arch Report------------------------------------
                //**/
                Route::get('national_qty_trg_arh', 'PerformanceController@national_qty_trg_arh_report_view');
            });

         //Developer: Sadun ajfar rahman
        Route::get('national_report', 'NationalReportController@index');
        Route::get('national_report_output', 'NationalReportController@ss_processing');
        Route::post('national_report_summary', 'NationalReportController@getSummary');
        Route::post('download_excel', 'NationalReportController@download_excel');

        Route::get('national_stock_medicine', 'Dmr\National_Stock_Medicine_Controller@index'); //display view page
        Route::post('national_stock_medicine_data', 'Dmr\National_Stock_Medicine_Controller@data');


    });

    //LIST AJAX
    //**--------current month Report-----------product group wise sales--------------------
    Route::get('resp_pgroup_wise_summary', 'ReportsController@pgroup_wise_summary_data');
    Route::get('resp_gm_wise_sales', 'ReportsController@gm_wise_sales_data');
    //---------current month Report-----------------------Depot Wise Sales--------------------
    Route::get('resp_depot_wise_sales', 'ReportsController@depot_wise_sales_data');
    //-------------current month Report-----------------------sm Wise-------------------
    Route::get('resp_sm_wise_sales', 'ReportsController@sm_wise_sales_data');
    //-------------current month Report-----------------------rm Wise-------------------
    Route::get('resp_rm_sales_dtl', 'ReportsController@rm_sales_dtl_data');
    //-------------current month Report-----------------------quantity achievement-----------------
    Route::get('resp_national_qty_trg', 'PerformanceController@national_qty_trg_arh_data');






});
//performance report reports---8.05.2019/

////////////////////////////prefix prep////////////////////////////////////////
Route::group(['prefix' => 'prep', 'middleware' => ['auth', 'recheck']], function () {
    ////////////////////////////prefix history report////////////////////////////////////////
    Route::group(['prefix' => 'hreper', 'middleware' => ['auth', 'recheck']], function () {
        ////////////////////////////prefix hsaleper////////////////////////////////////////

        ////////////////////////////prefix history report-----sales performance////////////////////////////////////////
        Route::group(['prefix' => 'hsaleper', 'middleware' => ['auth', 'recheck']], function () {
            ///**
            //**--------historical Report---sales performance-----Team wise----------------------------
            //**/
            Route::get('performance_report', 'PerformanceController@performance_report_view');
            ///**
            //**--------historical Report---sales performance-----GM wise----------------------------
            //**/
            Route::get('gm_ach_rep', 'SaleReportController@gm_ach_rep_v');
            ///**
            //**--------historical Report---sales performance-----SM/ASM/DSM wise----------------------------
            //**/
            Route::get('sm_asm_dsm_ach_rep', 'SaleReportController@sm_asm_dsm_ach_rep_v');
            ///**
            //**--------historical Report---sales performance-----RM wise----------------------------
            //**/
            Route::get('rm_ach_report', 'SaleReportController@rm_ach_report_view');
        });


    });

    //lists of ajax********************************************************

    //****************************************************************************
    //***********************HISTORICAL REPORT************************************
    //****************************************************************************


    //historical Report----sales performance----team wise------------------------------------
    Route::get('resp_perform_data', 'PerformanceController@resp_perform_table_data');
    //---historical Report---sales performance-----gm wise----------------------------
    Route::get('resp_gm_achment', 'SaleReportController@resp_gm_achment');
    //---historical Report---sales performance-----SM/ASM/DSM wise----------------------------
    Route::get('resp_sm_dsm_achment', 'SaleReportController@resp_sm_dsm_achment');
    // ----historical Report---sales performance-----RM wise----------------------------
    Route::get('resp_rm_ach', 'SaleReportController@resp_rm_ach_table_data');


    //****************************************************************************
    //***********************current month REPORT************************************
    //****************************************************************************

    ////////////////////////////prefix crep////////////////////////////////////////
    Route::group(['prefix' => 'cmreper', 'middleware' => ['auth', 'recheck']], function () {
        ////////////////////////////prefix CREP////////////////////////////////////////
        ///**
        //**--------current month Report-----------product group wise sales--------------------
        //**/

        ////////////////////////////prefix current month report-----sales performance////////////////////////////////////////
        Route::group(['prefix' => 'csaleper', 'middleware' => ['auth', 'recheck']], function () {
            ///**
            //**--------current month Report------sales performance-----SM Wise--------------------
            //**/
            Route::get('sm_sales', 'ReportsController@sm_wise_summary');
            ///**
            //**--------current month Report------sales performance------rm Wise--------------------
            //**/
            Route::get('rm_sales_dtl', 'ReportsController@rm_sales_dtl');

            ///**
            //**-------current month Report---sales performance------national qty trg arch Report------------------------------------
            //**/
            Route::get('national_qty_trg_arh', 'PerformanceController@national_qty_trg_arh_report_view');
        });




    });

    //LIST AJAX

    //-------------current month Report-----------------------sm Wise-------------------
    Route::get('resp_sm_wise_sales', 'ReportsController@sm_wise_sales_data');
    //-------------current month Report-----------------------rm Wise-------------------
    Route::get('resp_rm_sales_dtl', 'ReportsController@rm_sales_dtl_data');
    //-------------current month Report-----------------------quantity achievement-----------------
    Route::get('resp_national_qty_trg', 'PerformanceController@national_qty_trg_arh_data');






});






//data process report
// Route::group(['prefix' => 'repprocess', 'middleware' => ['auth', 'recheck']], function () {
//     Route::get('daily_data_process', 'SaleReportController@dailyprocess_view');
//     Route::post('daily_data_process_post', 'SaleReportController@dailyprocess_post');
// });

//data process report
Route::group(['prefix' => 'repprocess', 'middleware' => ['auth', 'recheck']], function () {
    Route::get('daily_data_process', 'DataProcess_Controller@dailyprocess_view');
    Route::post('daily_data_process_post', 'DataProcess_Controller@dailyprocess_post');

    //7.3.2019
     Route::post('daily_data_process_dtstatus_post', 'DataProcess_Controller@dt_sta_process_post');

    Route::get('getWorkingDay','DataProcess_Controller@getWorkingDay');
    // Sahadat
    Route::get('monthly_working_day', 'MonthlyWorkingDayController@index');
    Route::post('create_working_day', 'MonthlyWorkingDayController@create_working_day');
    Route::post('display_working_day', 'MonthlyWorkingDayController@display_working_day');
    Route::post('update_working_day','MonthlyWorkingDayController@update_working_day');
});


//Dcr Reports
Route::group(['prefix' => 'dcrep', 'middleware' => ['auth', 'recheck']], function () {
    /*Doctor visit summary report */    
    Route::get('doc_vis_sum_rep', 'Dcr\Dcr_Dvsr_Rep_Controller@dvsr_view');
    Route::get('resp_dvs_rep', 'Dcr\Dcr_Dvsr_Rep_Controller@dvsr_data');
    Route::get('resp_terr_id', 'Dcr\Dcr_Dvsr_Rep_Controller@terr_list');

    /*Item Wise Utilization*/
    Route::get('item_wise_utilize', 'Dcr\Dcr_Iwu_Rep_Controller@item_w_utilize_view');
    Route::get('resp_item_utilize_rep', 'Dcr\Dcr_Iwu_Rep_Controller@item_utilize_data');
    Route::get('resp_item_utilize_terr_id', 'Dcr\Dcr_Iwu_Rep_Controller@item_utilize_terr_list');
    Route::get('resp_item_utilize_items', 'Dcr\Dcr_Iwu_Rep_Controller@get_item_list');

    /*Doctor Wise Item Utilization*/
    Route::get('doc_wise_itm_utl', 'Dcr\Dcr_Dwiu_Rep_Controller@dwiu_view');
    Route::get('resp_dwiu_rep', 'Dcr\Dcr_Dwiu_Rep_Controller@dwui_data');
    Route::get('resp_td_id', 'Dcr\Dcr_Dwiu_Rep_Controller@dwui_terr_doc_list');
    Route::get('resp_terr_list', 'Dcr\Dcr_Dwiu_Rep_Controller@dwiu_terr_list');

    /*Item Wise Doctor details*/
    Route::get('item_wise_doc_details', 'Dcr\Dcr_Iwdd_Rep_Controller@item_w_doc_details_view');
    Route::get('resp_iwdoc_detail_rep', 'Dcr\Dcr_Iwdd_Rep_Controller@item_w_doc_details_item_data');
    Route::get('resp_itemwdoc_item_name', 'Dcr\Dcr_Iwdd_Rep_Controller@item_w_doc_details_item_list');
    Route::get('resp_am_mpo_list', 'Dcr\Dcr_Iwdd_Rep_Controller@resp_am_mpo_list');

    /*Doctor Wise Visit Details*/
    Route::get('doc_wise_visit_dts', 'Dcr\Dcr_Dwvd_Rep_Controller@dwvd_view');
    Route::get('resp_dwvd_rep', 'Dcr\Dcr_Dwvd_Rep_Controller@dwvd_data');
    Route::get('resp_vdtd_id', 'Dcr\Dcr_Dwvd_Rep_Controller@dwvd_terr_doc_list');
    Route::get('resp_terr_list_dwvd', 'Dcr\Dcr_Dwvd_Rep_Controller@dwvd_terr_list');

    /*Terr Wise Plan vs Visit */
    Route::get('terr_wise_plan_visit', 'Dcr\Dcr_Twpv_Rep_Controller@terr_wise_plan_vs_it');
    Route::get('resp_twpvsit_data_rep', 'Dcr\Dcr_Twpv_Rep_Controller@terr_wise_plan_vs_it_data');
    Route::get('resp_twpvsit_data_list', 'Dcr\Dcr_Twpv_Rep_Controller@terr_wise_plan_vs_it_list');

    //    Prescription Survey Report             Author:: Sahadat
    Route::get('prescription_survey_report', 'Dcr\PrescriptionSurveyController@index');
    Route::get('regwMpoTerrList', 'Dcr\PrescriptionSurveyController@regwMpoTerrList');
    Route::get('regWTerrAmList', 'Dcr\PrescriptionSurveyController@regWTerrAmList');

    Route::post('prescripSurveyReport', 'Dcr\PrescriptionSurveyController@prescripSurveyReport');


});



//employee competency
Route::group(['prefix' => 'emp_comp', 'middleware' => ['auth', 'recheck']], function (){

    //Rating Definition --Borna
    Route::get('get_rating_def', 'EmpCompetency_Controller@get_rating_def_view');


    //User Manual  --Borna
    Route::get('get_user_manual', 'EmpCompetency_Controller@get_user_manual_view');

  

    //Employee Rating Entry --Borna
    Route::get('get_emprating_entry', 'EmpCompetency_Controller@get_emprating_entry');
    Route::post('get_srch_rating_entry','EmpCompetency_Controller@display_srch_rating_entry');


    Route::post('empinsert','EmpCompetency_Controller@postempevetuation');

    Route::get('newratesupervisor','EmpCompetency_Controller@getnewrateforsuper');

    Route::post('newratebysupervisor','EmpCompetency_Controller@postnewratebys');

    Route::get('getolderEditdata','EmpCompetency_Controller@getolderEditdata');

    //mail part-20.11.2018

    Route::get('notiEmpByMail','EmpCompetency_Controller@notiEmpByMail');

    //next rating-Fatama
    Route::get('getNextRate','EmpNextRating_Controller@getNextRateinfo');
    Route::post('nextratingfirstsave','EmpNextRating_Controller@postNextRateinfo');




    //Rating Graph --Raqib
    Route::get('er_graph','EmployeeRatingGraph@index');
    Route::get('er_data','EmployeeRatingGraph@get_selection_data');
    Route::get('rtng_data','EmployeeRatingGraph@get_rating_data');

    //Rating Graph --Fatema for all
    Route::get('getDeptList','EmployeeRatingGraph@getDeptList');
    Route::get('getEmpListByDept','EmployeeRatingGraph@getEmpListByDept');

    //Employee Supervisor --Raqib
    Route::get('v_es','Employee_Supervisor_Controller@index');
    Route::post('param_data','Employee_Supervisor_Controller@get_param_data');
    Route::post('dept_data','Employee_Supervisor_Controller@get_dept_data');
    Route::post('emp_data','Employee_Supervisor_Controller@get_data_from_tab');
    Route::post('save_record','Employee_Supervisor_Controller@saveRecord');
    Route::post('update_record','Employee_Supervisor_Controller@updateRecord');

});

//data upload excel---borna
Route::group(['prefix' => 'dataupload', 'middleware' => ['auth', 'recheck']], function () {
    /*UPLOAD_EXPORT_SALES_DATA*/
    Route::get('up_export_sales_data', 'Data_upload_Controller@export_sales_data_view');
    Route::post('/post_export_sales','Data_upload_Controller@postExportSales');

    //UPLOAD_INST_SALES_DATA

    Route::get('inst_sales_data', 'Data_upload_Controller@inst_sales_data_view');
    Route::post('/post_inst_sales_data','Data_upload_Controller@postInstSales');

});


//expense verify upload
Route::group(['prefix' => 'expense', 'middleware' => ['auth', 'recheck']], function () {
    /*UPLOAD_EXPORT_SALES_DATA*/
    // fatama start
    Route::get('get_expense_verify_approve', 'Expense_Controller@expense_verify_approve_view');

    Route::get('expense_verify_approve_am', 'Expense_Controller@expense_am_view');

    Route::get('expense_view_mpo', 'Expense_Controller@expense_mpo_view');

    Route::post('get_expense_verify_approve','Expense_Controller@expense_verify_approve_view_post');

    //expense modal show
    Route::get('getDataexpense', 'Expense_Controller@getexpense_modal_view');

    //expense modal data edit
    Route::post('newExpense', 'Expense_Controller@postexpense_modal_view');

    //expense modal show
    Route::get('getrowdata', 'Expense_Controller@single_expense_row_replace');
    //    Route::get('/showimage/{uid?}/{type?}/{status?}',['as'=>'getImageRoute','uses'=>'Expense_Controller@showimage']);
    Route::get('/showimage/{uid?}/{type?}',['as'=>'getImageRoute','uses'=>'Expense_Controller@showimage']);
    //    getDailyAllowance
      Route::get('getDailyAllowance', 'Expense_Controller@getDailyAllowance');
    //    getCityAllowance
      Route::get('getCityAllowance', 'Expense_Controller@getCityAllowance');

      Route::get('getAMTerr', 'Expense_Controller@getAMTerr');
      Route::get('getEmpId', 'Expense_Controller@getEmpId');


      Route::get('finalSubmit', 'Expense_Controller@finalSubmit');
      //remove expense
      Route::get('/DeleteExpense','Expense_Controller@DeleteExpense');
        // fatama end

    //Field Expense Report-- Raqib/
     Route::get('field_expense','Expense_Report_Controller@get_field_expense_view');
     Route::post('field_Data','Expense_Report_Controller@display_expense_report');
     Route::get('proc_emp_exp','Expense_Report_Controller@process_emp_exp_data');

      
    //Field Expense(Expense Actual vs Corrected) --- Masroor
    Route::get('eac_report','Expense_Report_Controller@regwTerrListEX');
    Route::get('eac_regwTLgmrm', 'Expense_Report_Controller@regwTerrListGmRm');
    Route::get('eac_regWTerrAmList', 'Expense_Report_Controller@regWTerrAmList');
    Route::get('eac_serEmp', 'Expense_Report_Controller@searchEmployeeCode');
    Route::get('eac_actualVsCorrected', 'Expense_Report_Controller@actualVsCorrected');




       // fatama start

         /******************
     ***********Expense Entry Form*********************
     *******************************************************/
        Route::get('get_expense_entry_form', 'ExpenseEntry_Controller@expense_entry_view');
        Route::post('post_searchexpense_entry','ExpenseEntry_Controller@expense_entry_search_post');
        //    getEmpbyMonth
        Route::get('getEmpbyMonth', 'ExpenseEntry_Controller@getEmpbyMonth');

          // fatama end

    /*Expense Verify Approve Report-- Raqib */
     Route::get('eva_report','Expense_Report_Controller@get_eva_report_view');
     Route::post('q_data','Expense_Report_Controller@process_report_output');

      /*Expense Statistics Report-- Raqib */
     Route::get('expense_stat','ExpenseStatistics@index');
     Route::post('get_exp_mon','ExpenseStatistics@get_expense_stat');

       /* Doctor Maintenance Report-- Raqib */
     Route::get('dmr_report','docm_report_controller@index')->name('dmr_report');
     Route::post('search_doc','docm_report_controller@searchDoctorById')->name('search_doc');
     Route::post('doc_info','docm_report_controller@getDoctorInformation')->name('doc_info');

});

//sms api
Route::group(['prefix' => 'sms', 'middleware' => ['auth', 'recheck']], function () {
//sms api routes------------------------------------------------------------------
    Route::get('send_sms','sms\Sms_api_controller@index')->name('send_sms')->middleware('sms_auth');
    Route::post('send','sms\Sms_api_controller@send')->name('soap_send');
    Route::post('upload_save','sms\Sms_api_controller@upload_save')->name('upload_save');
    Route::post('groups','sms\Sms_api_controller@grp_list')->name('grp_list');
    Route::post('save','sms\Sms_api_controller@save_record')->name('save_contact');
    Route::post('get_contacts','sms\Sms_api_controller@get_contacts_data')->name('contacts');
    Route::post('update_contacts','sms\Sms_api_controller@update')->name('update');
    Route::post('delete_contacts','sms\Sms_api_controller@delete')->name('delete');
    Route::post('delete_group','sms\Sms_api_controller@delete_grp')->name('delete_grp');
    Route::post('sms_text','sms\Sms_api_controller@get_sms_text')->name('sms_text');
});



//Rm Portal
Route::group(['prefix' => 'rm_portal', 'middleware' => ['auth', 'recheck']], function () {


//    vacant territory

    Route::get('vacant_territory', 'Donation\Requisition_Controller@vacant_territory_view'); 

    //terr list Report RM->ASM->DSM->SM->NSM->GM
    Route::get('regwtlist_report', 'RmPortalController@regwTerrList'); //display view page
    Route::get('regwTerrList', 'Rmportal\RegionWiseDrEntryVsPlan@regionWiseTerrList'); //generate sm/rm data
    Route::get('regwTerrListGmRm', 'Rmportal\RegionWiseDrEntryVsPlan@regwTerrListGmRm');
    Route::get('regwTerrListSmRmNameId', 'Rmportal\RegionWiseDrEntryVsPlan@regwTerrListSmRmNameId');
    //region wise doctor list
    Route::get('regwDoclist_report', 'RmPortalController@regwDoclist_report');
    Route::get('regwMpoTerrList', 'Rmportal\RegionWiseDoctorList@regwMpoTerrList');
    Route::get('regTerrDocList', 'Rmportal\RegionWiseDoctorList@regTerrDocList');
    Route::get('regWTerrAmList', 'Rmportal\RegionWiseDoctorList@regWTerrAmList');
    //Territory Rearrange
    Route::get('terrRearrange', 'RmPortalController@terrListRearrange'); //display view page
    Route::get('regWTerrRMList', 'Rmportal\TerrRearrangeController@regWTerrRMList');
    Route::get('amWiseData', 'Rmportal\TerrRearrangeController@amWiseData');
    Route::get('mpoWiseData', 'Rmportal\TerrRearrangeController@mpoWiseData');
    Route::get('regWiseTerrAMListNew', 'Rmportal\TerrRearrangeController@regWiseTerrAMListNew');
    Route::get('regwMpoTerrListTr', 'Rmportal\TerrRearrangeController@regwMpoTerrList');
    Route::get('changeTerrHistory', 'Rmportal\TerrRearrangeController@changeTerrHistory');
    //Doctor Brand
    Route::get('doctor_brand', 'RmPortalController@doctorBrandReport'); //display view page
    Route::get('docBrandwList', 'Rmportal\DoctorBrandController@regTerrDocList'); //display view page
    Route::get('docMpoTerrListTr', 'Rmportal\DoctorBrandController@regwMpoTerrList');
    Route::get('doctorBrandName', 'Rmportal\DoctorBrandController@doctorBrandNameBasedOnName');
    Route::get('doctorBrandId', 'Rmportal\DoctorBrandController@doctorBrandNameBasedOnId');
    Route::get('autocomplete', 'Rmportal\DoctorBrandController@index');
    Route::get('searchajax', ['as'=>'searchajax','uses'=>'Rmportal\DoctorBrandController@searchResponse']);
     Route::get('brandCountDoc', 'Rmportal\DoctorBrandController@brandCountDoc');
    //Doctor Brand Summary
    Route::get('doc_brand_sum', 'RmPortalController@doctorBrandSummary'); //display view page
    Route::get('mpo_terr_wise_brand', 'Rmportal\DoctorBrandController@mpoTerrwiseBranddoc');
    //Doctor Visit Plan
    Route::get('doctorVsPlan', 'RmPortalController@doctorVsPlan'); //display view page
    Route::get('regwGetVisitPlan', 'Rmportal\DoctorVisitPlanController@regwGetVisitPlan');


    /*DOCTOR PLAN ROUTES*/
   Route::get('dp_view','Rmportal\DoctorPlanController@index');
   Route::post('doc_search','Rmportal\DoctorPlanController@searchDoctor');
   Route::post('terr_details','Rmportal\DoctorPlanController@get_terr_details');
   Route::post('plan_details','Rmportal\DoctorPlanController@get_plan_details');
   Route::post('brand_details','Rmportal\DoctorPlanController@get_doc_brand_details');
   Route::post('item_info','Rmportal\DoctorPlanController@get_items_data');
   Route::post('save_doctor','Rmportal\DoctorPlanController@saveDoctor');
   Route::post('save_terr','Rmportal\DoctorPlanController@saveTerritory');
   Route::post('save_plan','Rmportal\DoctorPlanController@savePlan');
   Route::post('save_brand','Rmportal\DoctorPlanController@saveBrand');
   Route::post('del_item','Rmportal\DoctorPlanController@deleteItem');
   Route::post('del_brand','Rmportal\DoctorPlanController@deleteBrand');
   Route::get('terrList','Rmportal\DoctorPlanController@get_terr_list');


       //item wise Doctor assign / delete
    Route::get('itemWiseDoc', 'RmPortalController@itemWiseDr'); //display view page
    Route::get('itemWiseMpoTerrList', 'Rmportal\ItemWiseDoctorsController@regwMpoTerrList');
    Route::get('itemWiseDocData', 'Rmportal\ItemWiseDoctorsController@itemWiseDrData');
    Route::get('getBrandsTw', 'Rmportal\ItemWiseDoctorsController@terrWiseDrBrand');
    Route::get('getItems', 'Rmportal\ItemWiseDoctorsController@terrWiseDrBrandItems');
    Route::post('itemWiseDocDelete', 'Rmportal\ItemWiseDoctorsController@itemWiseDocDataDelete');

    //Brand Wise Doctor delete
    Route::get('brandWiseDoc', 'RmPortalController@brandWiseDrDelete'); //display view page
    Route::get('itemWiseMpoTerrList', 'Rmportal\ItemWiseDoctorsController@regwMpoTerrList');
    Route::get('brandWiseDocData', 'Rmportal\BrandWiseDoctorController@brandWiseDrData');
    Route::post('brandWiseDocDelete', 'Rmportal\BrandWiseDoctorController@brandWiseDocDataDelete');

    //Terr wise Brand Exposure
    Route::get('terrbrandWiseExp', 'RmPortalController@terr_wise_brand_exposure'); //display view page
    Route::get('getBrands', 'Rmportal\ItemWiseDoctorsController@rmTerrWiseDrBrand');
    Route::get('brandWiseDocExp', 'Rmportal\ItemWiseDoctorsController@brandWiseDocExposure');

    //Day wise doctor visit plan
    Route::get('dwDocVisitPlan', 'RmPortalController@day_wise_docVisit_plan'); //display view page
    Route::get('dwdvpd', 'Rmportal\DayWiseDoctorVisitPlan@visitPlanData');
    Route::get('dayWiseDocPlan', 'Rmportal\DayWiseDoctorVisitPlan@dayWiseDocPlanUpdate');

    //Doctor terr rearranged
    Route::get('docTerrChange','RmPortalController@docWiseTerrChange'); //display view page
    Route::get('docmpoTerr', 'Rmportal\DoctorsTerrChangeController@docwMpoTerrList');
    Route::get('mpoTerrWDoc', 'Rmportal\DoctorsTerrChangeController@mpoTerrWDoctors');
    Route::post('TerrWDocTrans', 'Rmportal\DoctorsTerrChangeController@TerrWDocTransfer');

    
    //Doctor wise brand assign
    Route::get('docWisebrandAssign','RmPortalController@doc_wise_brand_assign'); //display view page
    Route::get('dwba','Rmportal\DoctorWiseBrandAssignController@getDoctorBrand');
    Route::get('selectGroup','Rmportal\DoctorWiseBrandAssignController@getTerrWisePGroup');
    Route::get('selectTerrDoc','Rmportal\DoctorWiseBrandAssignController@getTerrWiseDoctorList');
    Route::get('getTWDB','Rmportal\DoctorWiseBrandAssignController@getTerrWiseDoctorBrands');
    Route::post('docWBAssign','Rmportal\DoctorWiseBrandAssignController@docWiseBrandAssignUpdate');
    Route::post('twDocDelete', 'Rmportal\DoctorsTerrChangeController@terrWiseDocDataDelete');


    //Brand Wise Regional Doctors
    Route::get('brandwregdoc','RmPortalController@brand_wise_regdoc'); //display view page
    Route::get('bwrdoclist','Rmportal\ItemWiseDoctorsController@brandWiseRegionalDoc');

    // Weekly Visit Report (Day wise doctor visit plan Version 2)
    Route::get('dwDocVisitPlanv2', 'RmPortalController@dwdvp'); //display view page
    Route::get('dwdvpd_new', 'Rmportal\DayWiseDoctorVisitPlanV2@visitPlanData');
    Route::get('dayWiseDocPlanV2', 'Rmportal\DayWiseDoctorVisitPlanV2@dayWiseDocPlanUpdatev2');

    // Doctor Plan Monitoring
    Route::get('docPlanMonitoring', 'Rmportal\DoctorPlanMonitoringController@index');
    Route::get('docPlanGetRMASM', 'Rmportal\DoctorPlanMonitoringController@getRmAsm');
    Route::post('docPlanGetdocPlanData', 'Rmportal\DoctorPlanMonitoringController@getDocPlanData');


    //Terr Wise Sales Achivement
    Route::get('terrWsalesAchIndex', 'RmPortalController@terrWsalesAchIndex'); //display view page
    Route::get('regWTerrAmDataList', 'RmPortalController@regWTerrAmDataList'); 
    Route::get('getPgroup', 'RmPortalController@getPgroup'); 
    Route::get('getProudctNamebyPGroup', 'RmPortalController@getProudctNamebyPGroup'); 
    Route::get('getPgroupByBrand', 'RmPortalController@getPgroupByBrand'); 
    Route::post('getAch', 'RmPortalController@getAch'); 

    /** RM/AM Sales Achievement -----22/04/2024(Md. Mutasim Naib Sumit) */
    Route::get('RmAmWsalesAchIndex', 'RmPortalController@RmAmWsalesAchIndex'); //display view page
    Route::get('getRmAmPgroupByBrand', 'RmPortalController@getRmAmPgroupByBrand'); 
    Route::post('getRmAmAch', 'RmPortalController@getRmAmAch'); 
    Route::post('getRmAmAchRM', 'RmPortalController@getRmAmAchRM'); 
    Route::get('regWDsmTerrAmDataList', 'RmPortalController@regWDsmTerrAmDataList'); 
    Route::get('regWRmTerrAmDataList', 'RmPortalController@regWRmTerrAmDataList'); 


    
    //apk download --Raqib
    Route::get('apk_download','Rmportal\FileController@index')->name('apk_download');
    Route::get('apk_download_td', 'Rmportal\FileController@view_msd_app')->name('apk_download_td');
    Route::get('incepta_nm', 'Rmportal\FileController@view_nm_app')->name('view_nm_app');

    //sale due overdue invoice .....27.4.2019---borna

    Route::get('due_overdue_invoice', 'SaleInvDueController@due_overdue_inv_view'); //display view page
    Route::get('dis_sal_overdue_inv', 'SaleInvDueController@display_overdue_inv');

    //national stock medicine report   13.07.2020 ---- Sahadat
    Route::get('national_stock_medicine', 'Dmr\National_Stock_Medicine_Controller@index'); //display view page
    Route::post('national_stock_medicine_data', 'Dmr\National_Stock_Medicine_Controller@data');
    //national stock medicine report by sahadat
    
    //doctor anniversary/ birthday reminder
    Route::get('dabr_home','Rmportal\DoctorAnnivBdayReminderController@index');
    Route::get('dabr_data','Rmportal\DoctorAnnivBdayReminderController@getDoctorInfo');
    Route::post('get_doc_details','Rmportal\DoctorAnnivBdayReminderController@getDoctorDetails');
    Route::get('dabr_export/{p}','Rmportal\DoctorAnnivBdayReminderController@exportdata');

    //MSFA Maual
    Route::get('msfa_manual','Rmportal\MsfaManualController@index');

    
});




//SCM Portal
Route::group(['prefix' => 'scm_portal', 'middleware' => ['auth', 'recheck']], function () {

    // Material Uploa
    Route::get('material_upload_page', 'SCM\ScmMaterialController@index');
    Route::post('material_up_data','SCM\ScmMaterialController@importExcel');  


    // Route::get('dgda_link', url('scm_portal/Valid Source - DGDA.pdf')); 

    //Company Upload
    Route::get('company_upload_page','SCM\ScmCompanyInfoController@index');
    Route::post('company_up_data','SCM\ScmCompanyInfoController@importExcel');

    //Clearance Entry
    Route::get('clearance_entry_page','SCM\ScmClearanceEntryController@index');
    Route::get('blk_list_no','SCM\ScmClearanceEntryController@blkListNo');
    Route::post('mat_name','SCM\ScmClearanceEntryController@materialName');
    Route::get('manu_fact_name','SCM\ScmClearanceEntryController@manufacturerName');
    Route::post('cr_fn_data','SCM\ScmClearanceEntryController@clearanceReportData');
    Route::post('get_qty','SCM\ScmClearanceEntryController@getQuantity');
    Route::post('get_avl_qty','SCM\ScmClearanceEntryController@getAvailQuantity');
    Route::get('get_rate_cur','SCM\ScmClearanceEntryController@getCurrencyRate');

    //Clearance Report IPL
    Route::get('ipl_cc','SCM\ScmIPLCCController@index');
    Route::post('ipl_cc_pdf','SCM\ScmIPLCCController@CC_pdf');
    Route::get('lc_no','SCM\ScmIPLCCController@getLcNo');
    Route::get('inv_no','SCM\ScmIPLCCController@getInvNo');

    //block List Statement
    Route::get('bl_statement','SCM\ScmBLSTController@index');
    Route::post('material_name','SCM\ScmBLSTController@materialName');
    Route::post('stm_data','SCM\ScmBLSTController@statementData');

    //block List Statement Update
    Route::get('bl_statement_u','SCM\ScmBLSTUController@index');
    Route::post('plant_blocklist','SCM\ScmBLSTUController@plantBlockList');
    Route::post('get_stm_data','SCM\ScmBLSTUController@statementGetData');
    Route::post('postMatData','SCM\ScmBLSTUController@postMaterialData');
    Route::post('get_clearQty','SCM\ScmBLSTUController@get_clearQty');


    
    //Finish Product Entry
    Route::get('bl_fp_entry','SCM\FinishProductController@index');
    Route::post('storeFinishProduct','SCM\FinishProductController@storeFinishProduct');


    //Clarance List Statement
    Route::get('cl_statement','SCM\ScmCLSTController@index');
    Route::post('clstm_data','SCM\ScmCLSTController@CLstatementData');

    //BlockList Statement Summary
    Route::get('bl_statement_summary','SCM\BLSummaryController@index');
    Route::post('plantBlockListWiseMaterials','SCM\BLSummaryController@plantBlockListWiseMaterials');
    Route::post('get_stm_summary_data','SCM\BLSummaryController@get_stm_summary_data');


    //BlockList Warning Material
    Route::get('bl_warning','SCM\BLSummaryController@indexWaring');
    Route::post('get_stm_warning_data','SCM\BLSummaryController@get_stm_warning_data');
    Route::post('send_warning_data','SCM\BLSummaryController@insertWarningData');

    //BlockList Files Upload
    Route::get('blkListFilesUpload','SCM\BlockListFilesUploadController@index');
    Route::post('blkListFilesStore', 'SCM\BlockListFilesUploadController@store')->name('blkListFilesStore');
    Route::get('blkListFilesDelete/{id}', 'SCM\BlockListFilesUploadController@destroy');


    //BlockList Application Form
    Route::get('bl_apply_from','SCM\BlockListApplicationController@index');
    Route::get('getMaterialName','SCM\BlockListApplicationController@getMaterialName');
    Route::get('getManufacturerName','SCM\BlockListApplicationController@getManufacturerName');
    Route::get('getSupplierName','SCM\BlockListApplicationController@getSupplierName');
    Route::get('getFinishProductName','SCM\BlockListApplicationController@getFinishProductName');
    Route::post('saveScmAppForm','SCM\BlockListApplicationController@saveScmAppForm');

    
    //Applied Blocklist
    Route::get('applied_blocklist_rpt', 'SCM\BlockListApplicationController@applied_blocklist_rpt');
    Route::post('getApplicationRpt', 'SCM\BlockListApplicationController@getApplicationRpt');


    //BlockList Application Form Update
    Route::get('bl_from_update','SCM\BlockListApplicationUpdateController@index');
    Route::post('getAppUpdate','SCM\BlockListApplicationUpdateController@getAppUpdate');
    Route::get('getUpMaterialName','SCM\BlockListApplicationUpdateController@getUpMaterialName');
    Route::get('getUpManufacturerName','SCM\BlockListApplicationUpdateController@getUpManufacturerName');
    Route::get('getUpSupplierName','SCM\BlockListApplicationUpdateController@getUpSupplierName');
    Route::get('getUpFinishProductName','SCM\BlockListApplicationUpdateController@getUpFinishProductName');
    Route::post('frmApplicationUpdate','SCM\BlockListApplicationUpdateController@frmApplicationUpdate');
    Route::post('send_apply_rejected_data','SCM\BlockListApplicationUpdateController@send_apply_rejected_data');
    Route::post('scm_transfer_data_to_master','SCM\BlockListApplicationUpdateController@scm_transfer_data_to_master');
    Route::get('insScmApplicationFRM','SCM\BlockListApplicationUpdateController@insScmApplicationFRM');


    //BlockList Application Report
    Route::get('bl_apply_rpt','SCM\BlockListApplicationReportController@index');
    Route::post('blockList_Apply_certificate','SCM\BlockListApplicationReportController@blockList_Apply_certificate');


    //Packaging Material Trail Requesting
    Route::get('scm_pac_req', 'SCM\PackagingMaterialTrialController@index');
    Route::get('getItemDescription', 'SCM\PackagingMaterialTrialController@getItemDescription');
    Route::get('getLocalSupplierName', 'SCM\PackagingMaterialTrialController@getLocalSupplierName');
    Route::post('saveScmTrialReq', 'SCM\PackagingMaterialTrialController@saveScmTrialReq');

    //Packaging Trial Recommended
    Route::get('recommendApproval/{lineid}', 'SCM\PackagingMaterialTrialController@trialRecommendedPage');
    Route::post('trial_recommended_confirm', 'SCM\PackagingMaterialTrialController@trialRecommendedApproved');

    //Packaging Trial Concerned
    Route::get('concernedApproval/{lineid}', 'SCM\PackagingMaterialTrialController@trialConcernedApprovalPage');
    Route::post('trial_rndConcerned_confirm', 'SCM\PackagingMaterialTrialController@trialRndConcernedApproved');
    // Trial Requisition Form Pdf
    Route::post('trialFormPdf', 'SCM\PackagingMaterialTrialController@trialFormPdf')->name('trialFormPdf');

    // Trial Attachment & Share
    Route::get('scm_att_share', 'SCM\PackagingMaterialTrialController@attachmenShareIndexPage');
    Route::get('getConcernedList', 'SCM\PackagingMaterialTrialController@getConcernedList');
    Route::get('concernedAccept', 'SCM\PackagingMaterialTrialController@concernedAccept');
    Route::post('saveSCMShareAttachment', 'SCM\PackagingMaterialTrialController@saveSCMShareAttachment');

    // Machine Trial Report Statement
    Route::get('scm_machine_rpt_page', 'SCM\PackagingMaterialTrialController@machineReportIndex');
    Route::post('getAllTrialReference', 'SCM\PackagingMaterialTrialController@getAllTrialReference');
    Route::post('getScmTrialStatement', 'SCM\PackagingMaterialTrialController@getScmTrialStatement');
    Route::post('sendSupplierInfo', 'SCM\PackagingMaterialTrialController@sendSupplierInfo');

    // Pack Trial Recommended
    Route::get('scm_pacTrialRcm_page', 'SCM\PackagingMaterialTrialController@packTrialRcmPageIndex');
    Route::get('getTrialPackRcmData', 'SCM\PackagingMaterialTrialController@getTrialPackRcmData');
    Route::get('pacTrialrcmAccept', 'SCM\PackagingMaterialTrialController@pacTrialrcmAccept');

     // Amendment Summary
    Route::get('amendment ', 'SCM\AmendmentInformationController@index');
    Route::post('amendment_summary_data', 'SCM\AmendmentInformationController@get_stm_summary_data');
    Route::post('submit_amendment_data', 'SCM\AmendmentInformationController@submitAmendmentData');


    Route::get('purchase_req_for_raw_mat', 'SCM\PurchaseRequisitionController@index');
    Route::post('uploadRawMaterialList', 'SCM\PurchaseRequisitionController@uploadRawMaterialList');
    Route::get('req_for_raw_mat_update', 'SCM\PurchaseRequisitionController@req_for_raw_mat_update');
    Route::post('getMatGroups', 'SCM\PurchaseRequisitionController@getMatGroups');
    Route::post('getReqReport', 'SCM\PurchaseRequisitionController@getReqReport');
    Route::post('qtyUpdate', 'SCM\PurchaseRequisitionController@qtyUpdate');


    Route::get('comparative_master_data', 'SCM\ComparativeMasterDataController@index');
    Route::post('uploadComparativeRawMaterialList', 'SCM\ComparativeMasterDataController@uploadComparativeRawMaterialList');
    Route::post('getComMaterialData', 'SCM\ComparativeMasterDataController@getComMaterialData');

    Route::get('comStatementPage', 'SCM\ComparativeMasterDataController@comStatementPage');
    Route::post('getComparativeStatementData', 'SCM\ComparativeMasterDataController@getComparativeStatementData');
    Route::post('saveComStatementData', 'SCM\ComparativeMasterDataController@saveComparativeStatementData');
    Route::post('comparative_pdf','SCM\ComparativeMasterDataController@getFinalComparativeData');
    Route::post('getComparativeStatementByPlant','SCM\ComparativeMasterDataController@getComparativeStatementByPlant');

    Route::get('scm_notice', 'SCM\ScmNoticeUploadController@index');
    Route::post('uploadSCMnotice', 'SCM\ScmNoticeUploadController@uploadSCMnotice');
    Route::post('deleteThisRecord', 'SCM\ScmNoticeUploadController@deleteThisRecord');
});

Route::group(['prefix' => 'scm_portal', 'middleware' => ['headerSet']], function () {
    Route::get('scmComparativeFile', 'SCM\ComparativeMasterDataController@comparativeSample');
});

Route::group(['prefix' => 'scm_portal', 'middleware' => ['headerSet']], function () {
    Route::get('downloadFile', 'SCM\PurchaseRequisitionController@downloadFile');
});




//EMP Leave Portal
Route::group(['prefix' => 'elm_portal', 'middleware' => ['auth', 'recheck']], function () {

    //apply leave
    Route::get('apply_leave', 'ELM\ApplyLeaveController@index');
    Route::get('getSelectEmp', 'ELM\ApplyLeaveController@getEmpInfo');
    Route::get('getHoliday', 'ELM\ApplyLeaveController@holiday');
    Route::get('checkDeptHead', 'ELM\ApplyLeaveController@checkDeptHead');
    Route::post('userSubmit', 'ELM\ApplyLeaveController@applicantData');
    Route::post('checkFacLeaveData', 'ELM\ApplyLeaveController@checkFacLeaveData');
    
    //My application
    Route::get('my_application', 'ELM\MyApplicationController@index');
    Route::post('editEmployee','ELM\MyApplicationController@getEditedEmpinfo');
    Route::get('getLeaveType','ELM\MyApplicationController@getLeaveType');
    Route::post('getRspInfo','ELM\MyApplicationController@getRspInfo');
    Route::post('upApp','ELM\MyApplicationController@updateApplication');

    Route::get('getMyLeaveHistory','ELM\MyApplicationController@getMyLeaveHistory');

    Route::get('medImageDel', 'ELM\MyApplicationController@medicalImageDelete');

    //My Attendance
    Route::get('my_attendance', 'ELM\Reports\AttendanceReportController@myAttendanceIndex');
    Route::post('getMyAttRpt', 'ELM\Reports\AttendanceReportController@getMyAttRpt');


    //Requested Application
    Route::get('req_application', 'ELM\RequestedApplicationController@index');
    Route::post('getLeaveHistoryByYear', 'ELM\RequestedApplicationController@getLeaveHistoryByYear');
    Route::post('app_confirm', 'ELM\RequestedApplicationController@application_confirmation');
    Route::post('app_reject', 'ELM\RequestedApplicationController@application_rejection');
    Route::get('saveRmUser', 'ELM\RequestedApplicationController@saveRecommendUser');


    //Primary approval application
    Route::get('papproval/{id}/{lineid}', 'ELM\PrimaryApprovalController@index');
    Route::post('pappeditEmployee','ELM\PrimaryApprovalController@getapprovedEditedEmpinfo');
    Route::post('pleaveapp','ELM\PrimaryApprovalController@appupdateApplication');
    Route::post('app_sup_confirm','ELM\PrimaryApprovalController@appl_primary_confirmation');
    Route::post('sup_app_reject','ELM\PrimaryApprovalController@appl_primary_rejection');

    //Secondary approval application
    Route::get('headapproval/{id}/{lineid}', 'ELM\SecondaryApprovalController@index');
    Route::post('app_head_confirm','ELM\SecondaryApprovalController@appl_secondary_confirmation');
    Route::post('head_app_reject','ELM\SecondaryApprovalController@appl_secondary_rejection');

    //Secondary App Master Pending
    Route::get('secondary_aprv_pending','ELM\SecondaryAprvPendingController@index');
    Route::get('secgetPendingList','ELM\SecondaryAprvPendingController@getLeaveList');

    //    Leave Approval by HR  Author: Sahadat
    Route::get('leave_approval_hr','ELM\LeaveApprovalController@index');
    Route::get('get_plant_id','ELM\LeaveApprovalController@getPlant');
    Route::get('get_dept','ELM\LeaveApprovalController@getDept');
    Route::post('list_of_leave','ELM\LeaveApprovalController@listofLeave');
    Route::post('accept_leave_hr','ELM\LeaveApprovalController@leaveAcceptance');
    Route::post('reject_leave_hr','ELM\LeaveApprovalController@leaveRejection');


    //HR approval for mail link
    Route::get('hrapproval/{id}/{lineid}','ELM\HRApprovalController@index');
    Route::post('app_hr_confirm','ELM\HRApprovalController@appl_hr_confirmation');
    Route::post('hr_app_reject','ELM\HRApprovalController@appl_hr_rejection');

    //Primary App Master
    Route::get('primary_aprv_master','ELM\PrimaryAppMasterController@index');
    Route::get('getLeaveList','ELM\PrimaryAppMasterController@getLeaveList');
    Route::get('priAccept','ELM\PrimaryAppMasterController@priAccept');
    Route::get('priReject','ELM\PrimaryAppMasterController@priReject');
    Route::post('masterpleaveapp','ELM\PrimaryAppMasterController@mastereappupdateApplication');
    Route::post('mImageDelete','ELM\PrimaryAppMasterController@mImageDelete');



    //Secondary App Master
    Route::get('secondary_aprv_master','ELM\SecondaryAppMasterController@index');
    Route::get('secgetLeaveList','ELM\SecondaryAppMasterController@getLeaveList');
    Route::get('secAccept','ELM\SecondaryAppMasterController@secAccept');
    Route::get('secReject','ELM\SecondaryAppMasterController@secReject');

    //Special Leave Send to Plan Head
    Route::get('sendtoplan_head','ELM\PlanHeadController@index');
    Route::get('plan_headapproval/{id?}/{lineid?}','ELM\PlanHeadController@plan_headapproval');
    Route::get('getSPLeaveList','ELM\PlanHeadController@getSPLeaveList');

    Route::get('plantHeadAccept','ELM\PlanHeadController@plantHeadAccept');
    Route::get('plantHeadReject','ELM\PlanHeadController@plantHeadReject');


 //Summary Report
    Route::get('LeaveSummary','ELM\LeaveSummaryController@index');
    Route::get('getDeptEmp', 'ELM\LeaveSummaryController@getDeptEmp');
    Route::post('getAppSummary', 'ELM\LeaveSummaryController@applicantSummary');

     //Attendance Report
    Route::get('elmAttenReport','ELM\Reports\AttendanceReportController@index');
    Route::post('getAttRpt', 'ELM\Reports\AttendanceReportController@attendance_reports');

      //Employee Leave Details Report
  Route::get('empLeaveDetails','ELM\Reports\EmpLeaveDetailsController@index');
  Route::post('getEmpDetailsRpt', 'ELM\Reports\EmpLeaveDetailsController@getEmpDetails');
  Route::get('getApplicationFormPdf/{line_id}', 'ELM\Reports\EmpLeaveDetailsController@getApplicationFormPdf');



      //Depot pending leave
      Route::get('depot_pending','ELM\DepotPendingController@index');
      Route::get('getDepotLeave','ELM\DepotPendingController@getDepotLeave');
      Route::get('depotLeaveAccept','ELM\DepotPendingController@depotLeaveAccept');
      Route::get('depotLeaveReject','ELM\DepotPendingController@depotLeaveReject');

          //Depot Transfer
    Route::get('depot_transfer','ELM\DepotEmployeeTransfer@index');
    Route::get('getDepotEmployeeInfo','ELM\DepotEmployeeTransfer@getDepotEmployeeInfo');
    Route::get('setDepotEmployeeInfo','ELM\DepotEmployeeTransfer@setDepotEmployeeInfo');
  

    //Job Card Report
    Route::get('jobReport','ELM\Reports\JobCardController@index');
    Route::post('getJobRpt', 'ELM\Reports\JobCardController@job_reports');
    Route::post('getEmpWorkingStatus', 'ELM\Reports\JobCardController@employeeWorkingStatus');


    
    //Master Data Report / Edit
    Route::get('elmLeveInfo','ELM\ElmMasterController@index');
    Route::post('getElmMasterInfo','ELM\ElmMasterController@getElmMasterInfo');    
    Route::post('elmUpmasterInfo','ELM\ElmMasterController@elmMasterDataUpdate');    
    Route::get('insElmMasterInfo','ELM\ElmMasterController@insertElmMasterInfo');


    //Plant Head Data Report / Edit
    Route::get('elmplheadInfo','ELM\Reports\PLheadReportController@index');
    Route::post('getElmPlMasterInfo','ELM\Reports\PLheadReportController@getElmPLMasterInfo'); 
    Route::post('elmUpPLmasterInfo','ELM\Reports\PLheadReportController@elmPLMasterDataUpdate'); 
    Route::post('plantEdEmployee','ELM\PlanHeadController@getapprovedEditedEmpinfo');

    // For mail
    Route::get('sendbasicemail','MailController@basic_email');
    Route::get('sendhtmlemail','MailController@html_email');
    Route::get('sendattachmentemail','MailController@attachment_email');
    Route::get('insElmPLMasterInfo','ELM\Reports\PLheadReportController@insertElmPLMasterInfo');   

    //Maternity Master Data
    Route::get('elmMatInfo','ELM\Reports\MaternityReportController@index'); 
    Route::post('getElmMaternityMasterInfo','ELM\Reports\MaternityReportController@getElmMaternityMasterInfo');
    Route::post('elmUpMatmasterInfo','ELM\Reports\MaternityReportController@elmMatMasterDataUpdate');
    Route::get('insElmMatMasterInfo','ELM\Reports\MaternityReportController@insElmMatMasterInfo'); 

    //Role Information    
    Route::get('elmRoleInfo','ELM\Reports\RoleReportController@index');
    Route::post('getElmRoleInfo','ELM\Reports\RoleReportController@getElmRoleInfo');
    Route::post('elmUpRoleInfo','ELM\Reports\RoleReportController@elmUpRoleInfo');
    Route::get('insElmRoleInfo','ELM\Reports\RoleReportController@insElmRoleInfo'); 

    //ELM Dashboard    
    Route::get('elmDashboard','ELM\Reports\DashboardController@index');
    Route::post('das_date', 'ELM\Reports\DashboardController@indexChangeDate');
    Route::post('getSHiftndSectionInfo', 'ELM\Reports\DashboardController@getSHiftndSectionInfo');

 //Employee apply Leave Data Delete
    Route::get('empInfo','ELM\Reports\ElmApplyLeaveDataController@index');
    Route::post('getApplicantLeave','ELM\Reports\ElmApplyLeaveDataController@getApplicantLeave');
    Route::get('deleteApplicantLeave','ELM\Reports\ElmApplyLeaveDataController@deleteApplicantLeave');

    //elmLvCancel
    Route::get('elmLvCancel','ELM\LeaveCancellationController@index');
    Route::post('getRqLeave','ELM\LeaveCancellationController@getEmployeesLeave');
    Route::post('LvCancelReq','ELM\LeaveCancellationController@LvCancelReq');

    //Non Mgt Password Recovery
    Route::get('elmNonMgtP','ELM\Reports\NonMgtPasswordController@index');
    Route::post('elmGetNonMgt','ELM\Reports\NonMgtPasswordController@getNonMgtData');
    
    //leave factory manager
    Route::get('facManagerInfo','FactoryManagerInfoController@index');
    Route::post('getFacManagerData','FactoryManagerInfoController@getFacManagerData');
    Route::post('facManagerUpdate','FactoryManagerInfoController@facManagerUpdate');
    Route::get('getPlants','FactoryManagerInfoController@getPlants');
    Route::get('getDepts','FactoryManagerInfoController@getDepts');
    Route::get('getDeptEmpData','FactoryManagerInfoController@getDeptEmpData');
    Route::get('getAllPlants','FactoryManagerInfoController@getAllPlants');
    Route::get('getAllDepts','FactoryManagerInfoController@getAllDepts');
    Route::get('getEmployeeDataByID','FactoryManagerInfoController@getEmployeeDataByID');
    Route::get('getRestDeptEmpData','FactoryManagerInfoController@getRestDeptEmpData');
    Route::post('createNewFacMangr','FactoryManagerInfoController@createNewFacMangr');

    //leave factory RCM User
    Route::get('facRCMuserInfo','FactoryRCMuserInfoController@index');
    Route::get('getRCMPlants','FactoryRCMuserInfoController@getPlants');
    Route::get('getRCMdeptEmpData','FactoryRCMuserInfoController@getDeptEmpData');
    Route::post('getFacRCMuserData','FactoryRCMuserInfoController@getFacRCMuserData');
    Route::post('facRCMuserUpdate','FactoryRCMuserInfoController@facRCMuserUpdate');
    Route::get('getOtherDeptEmpData','FactoryRCMuserInfoController@getOtherDeptEmpData');
    Route::post('createNewFacRCMuser','FactoryRCMuserInfoController@createNewFacRCMuser');

     //Dissimilar Employee
    Route::get('dissimilarEmployee','DisEmp\DissimiliarEmployeeController@index');
    Route::post('getAllEmployee','DisEmp\DissimiliarEmployeeController@getAllEmployee');
});



Route::group(['prefix' => 'quiz', 'middleware' => ['auth', 'recheck']], function () {
    Route::get('quizGrpInfo', 'QuizPortal\GroupInfoController@index');
    Route::get('get_grpName','QuizPortal\GroupInfoController@productGroup');
    Route::post('get_listOfEmp','QuizPortal\GroupInfoController@listOfEmp');
    Route::post('save_group','QuizPortal\GroupInfoController@saveGroup');
    Route::get('ser_emp','QuizPortal\GroupInfoController@searchEmp');
    Route::post('groupDetails','QuizPortal\GroupInfoController@groupDetails');

    Route::get('UpExamMaterial','QuizPortal\ExamMaterialController@index');
    Route::post('exmStore','QuizPortal\ExamMaterialController@fileStore');

    Route::get('examDateTime','QuizPortal\ExamDateTimeController@index');
    Route::post('exmSetTime','QuizPortal\ExamDateTimeController@saveExamTime');
    Route::post('verifyexm','QuizPortal\ExamDateTimeController@ExamTimeVerify');

    Route::get('addQuestions','QuizPortal\QuestionsController@index');

    Route::post('storeQuestions','QuizPortal\QuestionsController@store');

    Route::post('getQuestionsAll','QuizPortal\QuestionsController@getQuestions');
    Route::post('QuesUpdate','QuizPortal\QuestionsController@UpdateQuestions');

    Route::get('grpWiseReport','QuizPortal\QuizReportController@indexGrpWiseRpt');

    Route::post('getQuizResult','QuizPortal\QuizReportController@grpWiseReportDetails');

    Route::get('grpEmpWiseReport','QuizPortal\QuizReportController@indexGrpEmpWiseRpt');
    Route::get('getEmpGrpName','QuizPortal\QuizReportController@empWiseGrpName');
    
    Route::post('getEmpQuizResult','QuizPortal\QuizReportController@empWiseGrpResult');

    Route::get('reExamApprovedIndex','QuizPortal\QuizReportController@reExamApprovedIndex');
    Route::post('getReExamEmpInfo','QuizPortal\QuizReportController@getReExamEmpInfo');
    Route::post('updateReExamEmployee','QuizPortal\QuizReportController@updateReExamEmployee');

    Route::get('employeePasswordIndex','QuizPortal\QuizReportController@employeePasswordIndex');
    Route::post('getEmpInfoPass','QuizPortal\QuizReportController@getEmpInfoPass');

      Route::get('regionWiseResult','QuizPortal\QuizReportController@regionWiseResult')->name('regionWiseResult');
  Route::post('getRegionWiseAchievement','QuizPortal\QuizReportController@getRegionWiseAchievement')->name('getRegionWiseAchievement');

    //raqib

    Route::get('notification_panel','QuizApiController@view_notification')->name('notification_panel');
    Route::post('notification_grp','QuizApiController@get_group_list')->name('get_group_list');
    Route::post('save_notifications','QuizApiController@save_notifications')->name('save_ntf');
    Route::post('notification_data','QuizApiController@get_logs')->name('get_logs');
    Route::post('send_notice','QuizApiController@send_notification_to_groups')->name('send_notice');

    Route::get('evalArchvUp','EvaluationArchiveController@index');
    Route::post('uploadEvalArchv','EvaluationArchiveController@uploadEvalArchv');
    Route::get('evalArchvReport','EvaluationArchiveController@evalArchvReport');
    Route::post('getEvalArchvReport','EvaluationArchiveController@getEvalArchvReport');
    Route::post('getEvalArchvReportEmpWIse','EvaluationArchiveController@getEvalArchvReportEmpWIse');

});
Route::group(['prefix' => 'quiz', 'middleware' => ['headerSet']], function () {
    Route::get('downloadFile', 'EvaluationArchiveController@downloadFile');
});

// Travel Management
    Route::group(['as'=>'local.','prefix'=>'travel/local', 'namespace'=>'Travel' ,'middleware' => ['auth','recheck']],function (){

        //Local Travel Advance
        Route::get('application','LocalTravelController@index')->name('application');
        Route::get('getLocation','LocalTravelController@getFromLocation')->name('getLocation');
        Route::post('getExpenditure','LocalTravelController@getExpenditure')->name('getExpenditure');
        Route::post('storeAdvance','LocalTravelController@storeAdvance')->name('storeAdvance');



        //Local Travel Adjustment
        Route::get('adjustment','LocalTravelAdjustmentController@index')->name('adjustment');
        Route::get('getMyLocalAdjustmentNO','LocalTravelAdjustmentController@getMyLocalAdjustmentDocumentNO')->name('getMyLocalAdjustmentNO');
        Route::get('getMyLocalAdvance','LocalTravelAdjustmentController@getMyLocalAdvanceData')->name('getMyLocalAdvance');
        Route::post('storeAdjustment','LocalTravelAdjustmentController@storeAdjustment')->name('storeAdjustment');

        //Local Travel Adjustment Details
        Route::get('getAdjustDocumentNo','LocalTravelAdjustmentController@getAdjustDocumentNo')->name('getAdjustDocumentNo');
        Route::get('adjustmentDetails','LocalTravelAdjustmentController@adjustmentDetailsIndex')->name('adjustmentDetails');
        Route::get('getAdjustment','LocalTravelAdjustmentController@getAdjustment')->name('getAdjustment');
        Route::post('storeAdjustmentDetails','LocalTravelAdjustmentController@storeAdjustmentDetails')->name('storeAdjustmentDetails');

        //Supervisor
        Route::get('recommended','TravelRecommendedController@localIndex')->name('recommended');
        Route::get('travelList','TravelRecommendedController@getTravelEmpList')->name('travelList');
        Route::get('travelSupApproved','TravelRecommendedController@travelSupApproved')->name('travelSupApproved');
        Route::get('travelSupRejected','TravelRecommendedController@travelSupRejected')->name('travelSupRejected');

        Route::get('primaryEmailApprovalLocal/{empId}/{id}', 'TravelRecommendedController@primaryEmailApprovalLocal');
        Route::get('secondaryEmailApprovalLocal/{empId}/{id}', 'TravelApprovedByController@secondaryEmailApprovalLocal');

        //Dept Head
        Route::get('approved','TravelApprovedByController@localIndex')->name('approved');
        Route::get('getTravelListApr','TravelApprovedByController@getTravelEmpList')->name('getTravelListApr');
        Route::get('travelHeadApproved','TravelApprovedByController@travelHeadApproved')->name('travelHeadApproved');
        Route::get('travelHeadRejected','TravelApprovedByController@travelHeadRejected')->name('travelHeadRejected');

        //Fi Advance
        Route::get('fi_advance','TravelFiAdvanceController@localIndex')->name('fi_advance');
        Route::post('storeFiAdvance','TravelFiAdvanceController@storeFiAdvance')->name('storeFiAdvance');

        //Fi Adjustment fi_adjustment
        Route::get('fi_adjustment','TravelFiAdjustmentController@localIndex')->name('fi_adjustment');
        Route::get('getCompanyId','TravelFiAdjustmentController@getCompanyId')->name('getCompanyId');
        Route::get('getCompWiseEmpAdjustment','TravelFiAdjustmentController@getCompWiseEmpAdjustment')->name('getCompWiseEmpAdjustment');
        Route::get('storeFiAdjustData','TravelFiAdjustmentController@storeFiAdjustData')->name('storeFiAdjustData');


        //Reports
        Route::get('getAdvice','BankAdviceController@Index')->name('getAdvice');
        Route::get('getDocumentNo','BankAdviceController@getDocumentNo')->name('getDocumentNo');
        Route::get('getDocumentCmpId','BankAdviceController@getDocumentCmpId')->name('getDocumentCmpId');
        Route::post('companyWiseAdvice','BankAdviceController@getAdviceCompanyWise')->name('companyWiseAdvice');
        Route::post('comAdviceLetter','BankAdviceController@comAdviceLetter')->name('comAdviceLetter');

        Route::get('getAdviceCompany','BankAdviceController@getAdviceCompany')->name('getAdviceCompany');
        Route::get('getAdviceBankName','BankAdviceController@getAdviceBankName')->name('getAdviceBankName');
        Route::get('getAdviceBranch','BankAdviceController@getAdviceBranch')->name('getAdviceBranch');
        Route::get('getAdviceAccNo','BankAdviceController@getAdviceAccNo')->name('getAdviceAccNo');

        //Local Travel History
        Route::get('history','LocalTravelHistoryController@index')->name('history');
        Route::get('getMyLocalTravel','LocalTravelHistoryController@getMyLocalTravel')->name('getMyLocalTravel');
        Route::get('getMyLocalDocumentNO','LocalTravelHistoryController@getMyLocalDocumentNO')->name('getMyLocalDocumentNO');
        Route::get('getMyLocalExpenditure','LocalTravelHistoryController@getMyLocalExpenditure')->name('getMyLocalExpenditure');

    });
    Route::group(['as'=>'international.','prefix'=>'travel/international', 'namespace'=>'Travel' ,'middleware' => ['auth','recheck']],function (){
        Route::get('application','InternationalTravelController@index')->name('application');
        Route::get('getLocation','InternationalTravelController@getFromLocation')->name('getLocation');
        Route::post('getExpenditure','InternationalTravelController@getExpenditure')->name('getExpenditure');
        Route::post('storeAdvance','InternationalTravelController@storeAdvance')->name('storeAdvance');

        Route::post('getEmployeeName','InternationalTravelController@getEmployeeName')->name('getEmployeeName');

        Route::post('getInfoByDocumentNo','InternationalTravelController@getInfoByDocumentNo')->name('getInfoByDocumentNo');

        //Dept Head
        Route::get('headapproved','TravelApprovedByController@IntlIndex')->name('headapproved');
        Route::get('intlGetTraveler','TravelApprovedByController@intlGetTraveler')->name('intlGetTraveler');                
        Route::get('intlTravelHeadApproved','TravelApprovedByController@intlTravelHeadApproved')->name('intlTravelHeadApproved');
        Route::get('intltravelHeadRejected','TravelApprovedByController@intlTravelHeadRejected')->name('intltravelHeadRejected');
        
        //Dept Head Mail link
        Route::get('deptHead/{empId}/{documentNo}', 'TravelRecommendedController@deptHead');
        //chairman email approved link
        Route::get('intlReqHO/{empId}/{documentNo}', 'TravelRecommendedController@intlReqHO');
        Route::get('intlReqPlant/{empId}/{documentNo}', 'TravelRecommendedController@intlReqPlant');
        //Site head emil approved link
        Route::get('intlReqFactory/{empId}/{documentNo}', 'TravelRecommendedController@intlReqFactory');
        //Plant head emil approved link
        Route::get('intlReqFactoryHead/{empId}/{documentNo}', 'TravelRecommendedController@intlReqFactoryHead');

        //Travel History
        Route::get('history','InternationalNoteSheetController@getTravelHistory')->name('history');


        //Chairman
        Route::get('chairmanApproved','TravelApprovedByController@IntlIndexChairman')->name('chairmanApproved');
        Route::get('chairmanIntlGetTraveler','TravelApprovedByController@chairmanIntlGetTraveler')->name('chairmanIntlGetTraveler');
        Route::get('intlTravelChairmanApproved','TravelApprovedByController@intlTravelChairmanApproved')->name('intlTravelChairmanApproved');
        Route::get('intlTravelChairmanRejected','TravelApprovedByController@intlTravelChairmanRejected')->name('intlTravelChairmanRejected');


        //Site Head
        Route::get('siteHeadApproved','TravelApprovedByController@IntlIndexsiteHead')->name('siteHeadApproved');
        Route::get('siteHeadIntlGetTraveler','TravelApprovedByController@siteHeadIntlGetTraveler')->name('siteHeadIntlGetTraveler');
        Route::get('intlTravelSiteHeadApproved','TravelApprovedByController@intlTravelSiteHeadApproved')->name('intlTravelSiteHeadApproved');
        Route::get('intlTravelSiteHeadRejected','TravelApprovedByController@intlTravelSiteHeadRejected')->name('intlTravelSiteHeadRejected');

        //plant Head
        Route::get('plantHeadApproved','TravelApprovedByController@intlIndexPlantHead')->name('plantHeadApproved');
        Route::get('plantHeadIntlGetTraveler','TravelApprovedByController@plantHeadIntlGetTraveler')->name('plantHeadIntlGetTraveler');
        Route::get('intlTravelPlantHeadApproved','TravelApprovedByController@intlTravelPlantHeadApproved')->name('intlTravelPlantHeadApproved');
        Route::get('intlTravelPlantHeadRejected','TravelApprovedByController@intlTravelPlantHeadRejected')->name('intlTravelPlantHeadRejected');


        //Note Sheet
        Route::get('noteSheetIndex','InternationalNoteSheetController@index')->name('noteSheetIndex');
        Route::get('getDocumentNO','InternationalNoteSheetController@getDocumentNO')->name('getDocumentNO');
        Route::get('getGrpNo','InternationalNoteSheetController@getGrpNo')->name('getGrpNo');        
        Route::get('getGradeWiseAllowance','InternationalNoteSheetController@getGradeWiseAllowance')->name('getGradeWiseAllowance');
        Route::get('getCheckDocument','InternationalNoteSheetController@getCheckDocument')->name('getCheckDocument');

        Route::post('storeNoteSheet','InternationalNoteSheetController@storeNoteSheet')->name('storeNoteSheet');
        Route::post('updateNoteSheet','InternationalNoteSheetController@updateNoteSheet')->name('updateNoteSheet');

        //Note Sheet Reports
        Route::get('noteSheetView','InternationalNoteSheetReportController@index')->name('noteSheetView');
        Route::post('noteSheetExportPDF','InternationalNoteSheetReportController@noteSheetExportPDF')->name('noteSheetExportPDF');
        Route::post('noteSheetGroupExportPDF','InternationalNoteSheetReportController@noteSheetGroupExportPDF')->name('noteSheetGroupExportPDF');

       // send noteSheet to HR head
        Route::get('sendHrHeadEmail','InternationalNoteSheetController@sendHrHeadEmail')->name('sendHrHeadEmail');

        //checked by
        Route::get('emailForm/noteSheet/checked/{id}', 'InternationalNoteSheetReportController@checkedByNoteSheet');
        Route::get('noteSheetDetailsView/{id}', 'InternationalNoteSheetReportController@noteSheetDetailsView')->name('noteSheetDetailsView');
        Route::get('intlTravelNoteSheetCheckedAppr', 'InternationalNoteSheetReportController@intlTravelNoteSheetCheckedAppr')->name('intlTravelNoteSheetCheckedAppr');
        Route::get('intlTravelNoteSheetCheckedNotAppr', 'InternationalNoteSheetReportController@intlTravelNoteSheetCheckedNotAppr')->name('intlTravelNoteSheetCheckedNotAppr');

        //recommended By
        Route::get('emailForm/noteSheet/recommended/{id}', 'InternationalNoteSheetReportController@recommendedByNoteSheet');        
        Route::get('intlTravelNoteSheetRecommAppr', 'InternationalNoteSheetReportController@intlTravelNoteSheetRecommAppr')->name('intlTravelNoteSheetRecommAppr');
        Route::get('intlTravelNoteSheetRecommNotAppr', 'InternationalNoteSheetReportController@intlTravelNoteSheetRecommNotAppr')->name('intlTravelNoteSheetRecommNotAppr');


        //approved By
        Route::get('emailForm/noteSheet/approved/{id}', 'InternationalNoteSheetReportController@approvedByNoteSheet');
        Route::get('intlTravelNoteSheetApprovedAppr', 'InternationalNoteSheetReportController@intlTravelNoteSheetApprovedAppr')->name('intlTravelNoteSheetApprovedAppr');
        Route::get('intlTravelNoteSheetApprovedNotAppr', 'InternationalNoteSheetReportController@intlTravelNoteSheetApprovedNotAppr')->name('intlTravelNoteSheetApprovedNotAppr');

        Route::post('nsDetailsView', 'InternationalNoteSheetReportController@noteSheetDetailsView')->name('nsDetailsView');
        Route::post('noteSheetDelete', 'InternationalNoteSheetReportController@noteSheetDelete')->name('noteSheetDelete');

        Route::post('noteSheetPreview', 'InternationalNoteSheetController@noteSheetPreViewDetails')->name('noteSheetPreview');

        //Update Note Sheet
        Route::post('updatefinalNoteSheet','InternationalNoteSheetController@updatefinalNoteSheet')->name('updatefinalNoteSheet');
        
        //getTravelFacilities
        Route::get('getTravelFacilities','InternationalNoteSheetController@getTravelFacilities')->name('getTravelFacilities');

        //Note Sheet Checked by
        Route::get('noteSheetCheckedBy','InternationalNoteSheetReportController@intlNoteSheetCheckedBy')->name('noteSheetCheckedBy');
        Route::get('intlGetTravelerByDocument','InternationalNoteSheetReportController@intlGetTravelerByDocument')->name('intlGetTravelerByDocument');
        Route::get('intlNoteSheetCheckedApprBy', 'InternationalNoteSheetReportController@intlNoteSheetCheckedApprBy')->name('intlNoteSheetCheckedApprBy');
        Route::get('intlNoteSheetCheckedApprByNotAppr', 'InternationalNoteSheetReportController@intlNoteSheetCheckedApprByNotAppr')->name('intlNoteSheetCheckedApprByNotAppr');

        //Note Sheet RecommendBy by
        Route::get('intlnoteSheetRecommendedBy','InternationalNoteSheetReportController@intlnoteSheetRecommendedBy')->name('intlnoteSheetRecommendedBy');
        Route::get('intlGetTravelerRecByDocument','InternationalNoteSheetReportController@intlGetTravelerRecByDocument')->name('intlGetTravelerRecByDocument');
        Route::get('intlNoteSheetRecommendedApprBy','InternationalNoteSheetReportController@intlNoteSheetRecommendedApprBy')->name('intlNoteSheetRecommendedApprBy');
        Route::get('intlNoteSheetRecommendedNotAppr','InternationalNoteSheetReportController@intlNoteSheetRecommendedNotAppr')->name('intlNoteSheetRecommendedNotAppr');
        
        //Note Sheet Approved by
        Route::get('intlnoteSheetApprovedBy','InternationalNoteSheetReportController@intlnoteSheetApprovedBy')->name('intlnoteSheetApprovedBy');
        Route::get('intlGetTravelerAprByDocument','InternationalNoteSheetReportController@intlGetTravelerAprByDocument')->name('intlGetTravelerAprByDocument');
        Route::get('intlNoteSheetApprovedApprBy','InternationalNoteSheetReportController@intlNoteSheetApprovedApprBy')->name('intlNoteSheetApprovedApprBy');
        Route::get('intlNoteSheetApprovedNotAppr','InternationalNoteSheetReportController@intlNoteSheetApprovedNotAppr')->name('intlNoteSheetApprovedNotAppr');

    });

    Route::group(['as'=>'masterData.','prefix'=>'travel/masterData', 'namespace'=>'Travel' ,'middleware' => ['auth','recheck']],function (){
        Route::get('grades','TravelGradeController@index')->name('grades');
        Route::post('store','TravelGradeController@store')->name('grades.store');
        Route::get('grades/{grade_id}/edit','TravelGradeController@edit')->name('grades.edit');
        Route::PUT('update','TravelGradeController@update')->name('grades.update');
        Route::delete('grades/{id}','TravelGradeController@destroy')->name('grades.destroy');
    });
//End Travel Management








//Employee History Form :: Fatema | modification done after Raqib Hasan  
Route::group(['prefix' => 'ehf', 'middleware' => ['auth', 'recheck']], function () {
       Route::post('ehf_credential','EHF_Controller\Ehf_EntryController@user_credential');
        Route::post('chk_credential','EHF_Controller\Ehf_EntryController@check_credential');
    /*--------------------------------employee insert update pdf download portion*/
        Route::get('emp_history_entry/{valid}', 'EHF_Controller\Ehf_EntryController@eh_viewForm');
        Route::post('/post_export_sales','Data_upload_Controller@postExportSales');

                //-------following url is using instead of three url for present,permanent,emergency address district division
        Route::get('getWholeDistrict', 'EHF_Controller\Ehf_EntryController@getWholeDistrict');
        Route::post('postPageoneForm', 'EHF_Controller\Ehf_EntryController@postPageoneForm');
        Route::post('postPagetwoForm', 'EHF_Controller\Ehf_EntryController@postPagetwoForm');
        Route::post('postPagethreeForm', 'EHF_Controller\Ehf_EntryController@postPagethreeForm');
        Route::post('postPagefourForm', 'EHF_Controller\Ehf_EntryController@postPagefourForm');

        //employee profile file upload and save
        Route::post('ajaxImageUpload','EHF_Controller\Ehf_EntryController@ajaxImageUploadPost');
        Route::post('nomineeImage','EHF_Controller\Ehf_EntryController@nominee_image_upload');

        //notify usermail
        Route::get('Emphistory_mal','EHF_Controller\Ehf_EntryController@notiEmpByMail');

        //pdf preview after clicking download---and hr will get authority after clicking heree--

        Route::post('emp_final_pdfform','EHF_Controller\Ehf_EntryController@emphistory_pdf');

        Route::get('getWholeGroup', 'EHF_Controller\Ehf_EntryController@getWholeGroup');
        Route::get('getWholeDegreeBoard', 'EHF_Controller\Ehf_EntryController@getWholeDegreeBoard');

        //temporalily pdf preview in page 4

        Route::get('emp_final_pdfform_preview','EHF_Controller\Ehf_EntryController@emphistory_pdf_preview');

    //        employee history form editing by HR
    Route::get('emp_history_hr', 'EHF_Controller\Ehf_EntryController_hr@eh_hr_viewForm');
    Route::get('emp_history_admin/{value}', 'EHF_Controller\Ehf_EntryController_hr@eh_hr_user_viewForm');
    Route::get('search_employee_id', 'EHF_Controller\Ehf_EntryController_hr@searchEmployee');
    Route::post('ajaxImageUpload_hr','EHF_Controller\Ehf_EntryController_hr@ajaxImageUploadPost');
    Route::post('nomineeImage_hr','EHF_Controller\Ehf_EntryController_hr@nominee_image_upload');

    Route::post('postPageoneForm_hr', 'EHF_Controller\Ehf_EntryController_hr@postPageoneForm');
    Route::post('postPagetwoForm_hr', 'EHF_Controller\Ehf_EntryController_hr@postPagetwoForm');
    Route::post('postPagethreeForm_hr', 'EHF_Controller\Ehf_EntryController_hr@postPagethreeForm');
    Route::post('postPagefourForm_hr', 'EHF_Controller\Ehf_EntryController_hr@postPagefourForm');

    Route::post('send_mail_hr','EHF_Controller\Ehf_EntryController_hr@mail_pdf');
    Route::post('emp_final_pdfform_hr','EHF_Controller\Ehf_EntryController_hr@emphistory_pdf');
    Route::post('emp_final_pdfform_preview_hr','EHF_Controller\Ehf_EntryController_hr@emphistory_pdf_preview');



    //---HR history report---------------------------------------------------------------
        Route::get('historyWiseReport','EHF_Controller\Ehf_EntryController@indexEmpWiseRpt');
        Route::post('historyWiseReport','EHF_Controller\Ehf_EntryController@getEmpWiseRpt')->name('getEmpWiseRpt');

 //send pdf to mail
        Route::post('send_mail','EHF_Controller\Ehf_EntryController@mail_pdf');

});


//Issuing of Batch Document 
Route::group(['prefix'=>'ibd','middleware'=>['auth','recheck','ibd_url_check']],function (){
    Route::get('ibd_home','ibatchdoc\IssuingBatchDocumentController@index');
    Route::get('initial_folders','ibatchdoc\IssuingBatchDocumentController@getInitialFolders');
    Route::post('handle_ev','ibatchdoc\IssuingBatchDocumentController@handleClick');
    Route::post('navigate','ibatchdoc\IssuingBatchDocumentController@navigateback');
    Route::post('save_log','ibatchdoc\IssuingBatchDocumentController@saveprint_log');
    Route::get('log_view','ibatchdoc\IssuingBatchDocumentController@display_view');
    Route::post('get_log','ibatchdoc\IssuingBatchDocumentController@show_log');
    Route::get('get_excel/{para}','ibatchdoc\IssuingBatchDocumentController@generate_excel');
});


//Analytical reports
Route::group(['prefix' => 'arep', 'middleware' => ['auth', 'recheck']], function () {

});

//graphical reports
Route::group(['prefix' => 'grep'], function () {

});

// test purpose
Route::get('users', function () {
    $retrieved_rows = User::all();
    dd($retrieved_rows);
});

//test if pdo is working or not for oracle plugin
Route::get('phpinfo', function () {
    // dd(DB::connection()->getPdo());
    echo phpinfo();
});

// Donation   Author :: Sahadat

// Route::group(['prefix' => 'donation', 'middleware' => ['headerSet']], function () {
//     Route::get('downloadFile', 'Donation\BeftnMaintainController@downloadFile');
// });

Route::group(['prefix' => 'donation', 'middleware' => ['auth', 'recheck']], function () {

    
// *********  New exception 29/05/2024 Sahadat begin ********

    Route::get('reqexp_n','Donation\Req_Excp_New_Controller@index');
   Route::get('getInitialData_n','Donation\Req_Excp_New_Controller@getInitialData');
   Route::post('getAmTerr_n','Donation\Req_Excp_New_Controller@getAmTerrByDepot');
   Route::post('getMpoTerr','Donation\Req_Excp_New_Controller@getMpoTerr');
   Route::post('getDepot','Donation\Req_Excp_New_Controller@getDepot');  
   Route::post('displayReq','Donation\Req_Excp_New_Controller@displayReq');  
//    Route::post('getDoctorById','Donation\Donation_Req_Excp_Controller@getDoctorInfoTerrById');
//    Route::post('getTerrByDepot','Donation\Donation_Req_Excp_Controller@getDoctorNameWiseTerr');
//    Route::post('getGbrInfo','Donation\Donation_Req_Excp_Controller@getGbrInformation');
   Route::post('saveReq_n','Donation\Req_Excp_New_Controller@save_requisitions');
   Route::post('checkEligibility_n','Donation\Req_Excp_New_Controller@checkDoctorExpenseEligibility');

// *********  New exception 29/05/2024 Sahadat  End ********
        //beftn maintenance

        Route::get('beftn_maintain','Donation\BeftnMaintainController@index');
        Route::post('upload_beftn_master','Donation\BeftnMaintainController@uploadDataFromExcel');
        Route::post('beftn_info','Donation\BeftnMaintainController@beftn_info');
       
    
   Route::get('ssd_expense_calculation', 'Donation\SSD_Expense_Controller@index');
   Route::post('ssd_expense_data', 'Donation\SSD_Expense_Controller@ssd_expense_data');
//
//    // finance miscellaneous starts here
   Route::get('fi_misc', 'Donation\FI_Misc_Controller@index');
   Route::post('pending_data', 'Donation\FI_Misc_Controller@pending_data');
   Route::post('processed_data', 'Donation\FI_Misc_Controller@processed_data');
//// finance miscellaneous ends here
//
//
//    

// cash process starts here
    Route::get('cash_process_view', 'Donation\Cash_Process_Controller@cash_process_view');

    Route::post('fi_doc_list', 'Donation\Cash_Process_Controller@fi_doc_list');
    Route::post('depot_list', 'Donation\Cash_Process_Controller@depot_list');
    Route::post('cash_summary_detail_data', 'Donation\Cash_Process_Controller@cash_summary_detail_data');
    Route::post('cash_insert_data', 'Donation\Cash_Process_Controller@cash_insert_data');
    Route::post('send_email', 'Donation\Cash_Process_Controller@send_email');
    Route::get('cash_process_mail_report', 'Donation\Cash_Process_Controller@cash_process_mail_report');
    Route::post('cash_process_mail_display_data', 'Donation\Cash_Process_Controller@cash_process_mail_display_data');
    // cash process ends here
   
//
//    // cash process rm starts here
   Route::get('cash_process_rm_view', 'Donation\Cash_Process_Controller@cash_process_rm_view');
   Route::post('depot_list_rm', 'Donation\Cash_Process_Controller@depot_list_rm');
   Route::post('cash_process_rm_data', 'Donation\Cash_Process_Controller@cash_process_rm_data');
   Route::post('cash_process_rm_update', 'Donation\Cash_Process_Controller@cash_process_rm_update');
//    // cash process rm ends here
//
//    // cash process depot starts here
   Route::get('cash_process_depot_view', 'Donation\Cash_Process_Controller@cash_process_depot_view');
   Route::post('rm_list', 'Donation\Cash_Process_Controller@rm_list');
   Route::post('cash_process_depot_data', 'Donation\Cash_Process_Controller@cash_process_depot_data');
   Route::post('cash_process_depot_update', 'Donation\Cash_Process_Controller@cash_process_depot_update');
   Route::post('print_cash_depot', 'Donation\Cash_Process_Controller@print_depot_report');
//    // cash process depot ends here
//
//
//    // pay order status starts here
   Route::get('pay_order_status', 'Donation\Pay_Order_Status_Controller@index');
   Route::post('sum_id_list', 'Donation\Pay_Order_Status_Controller@sum_id_list');
   Route::post('region_list', 'Donation\Pay_Order_Status_Controller@region_list');
   Route::post('pay_order_data', 'Donation\Pay_Order_Status_Controller@pay_order_data');
   Route::post('ssd_send', 'Donation\Pay_Order_Status_Controller@ssd_send');
   Route::post('rm_receive', 'Donation\Pay_Order_Status_Controller@rm_receive');
   Route::post('remark_update', 'Donation\Pay_Order_Status_Controller@remark_update');
//    //  pay order statust ends here
//
//    // pay order report starts here
   Route::get('pay_order_report_view', 'Donation\Pay_Order_Status_Controller@pay_order_report_view');
   Route::post('sum_id_list_report', 'Donation\Pay_Order_Status_Controller@sum_id_list_report');
   Route::post('region_list_report', 'Donation\Pay_Order_Status_Controller@region_list_report');
   Route::post('pay_order_report_data', 'Donation\Pay_Order_Status_Controller@pay_order_report_data');
//    // pay order report ends here
//
//    // RE Report FI starts here
   Route::get('re_report_fi', 'Donation\Re_Report_FI_Controller@index');
   Route::post('re_report_data', 'Donation\Re_Report_FI_Controller@re_report_data');
    Route::post('re_year', 'Donation\Re_Report_FI_Controller@re_year');
   Route::post('re_month', 'Donation\Re_Report_FI_Controller@re_month');
   Route::post('re_cc', 'Donation\Re_Report_FI_Controller@re_cc');
   Route::post('re_sum', 'Donation\Re_Report_FI_Controller@re_sum');
//// RE Report FI ends here
//
//    // business promotion report starts here
   Route::get('business_promotion', 'Donation\Business_Promotion_Controller@index');
   Route::post('business_promotion_data', 'Donation\Business_Promotion_Controller@business_promotion_data');
//// Business promotion report ends here
//
//
      Route::get('finance_record_monthly', 'Donation\Finance_Record_Controller@index');
   Route::post('finance_record_data', 'Donation\Finance_Record_Controller@finance_record_data');
//
//
//     //    request_status_for_ssd starts here
//
   Route::get('request_status_for_ssd', 'Donation\Request_Status_For_SSD_Controller@index');
   Route::post('requisition_data_ssd', 'Donation\Request_Status_For_SSD_Controller@requisition_data_ssd');
   Route::post('brandRegion_be_ssd', 'Donation\Request_Status_For_SSD_Controller@brandRegion_be');
//
//    // request_status_for_ssd ends here
//
//
//      //    Donation  Cost Center Budget  starts here
   Route::get('cost_center_budget', 'Donation\Cost_Centre_Budget_Controller@index');
   Route::get('don_cc', 'Donation\Cost_Centre_Budget_Controller@cc_don');
   Route::post('cc_budget_display', 'Donation\Cost_Centre_Budget_Controller@cc_budget_display');
   Route::post('insert_cc_budget', 'Donation\Cost_Centre_Budget_Controller@insert_cc_budget');
   Route::post('subtract_budget_calc', 'Donation\Cost_Centre_Budget_Controller@subtract_budget_calc');
    Route::post('cc_budget_history', 'Donation\Cost_Centre_Budget_Controller@cc_budget_history');
//
//  //    Budget monthly  Report starts here
//
   Route::get('budget_report_monthly', 'Donation\Budget_Monthly_Report_Controller@index');
   Route::post('budget_monthly_report_display', 'Donation\Budget_Monthly_Report_Controller@budget_monthly_report_display');
//
//    // Budget monthly Report ends here
//
//   //    Budget Report  summary starts here
//
   Route::get('budget_report', 'Donation\Budget_Report_Controller@index');
   Route::get('cc_don_sum', 'Donation\Budget_Report_Controller@cc_don');
   Route::post('cc_budget_report', 'Donation\Budget_Report_Controller@cc_budget_report');
//
//    // Budget Report summary ends here
//
//
//    //  Donation  Cost Center Budget ends here
//
//     //    Budget Closing starts here
//
   Route::get('budget_closing', 'Donation\Budget_Closing_Controller@index');
   Route::post('budget_closing_procedure', 'Donation\Budget_Closing_Controller@budget_closing_procedure');
//
//    // Budget Closing ends here
//
//
//      //    Donation Sub Cost Center Budget  starts here
   Route::get('sub_cost_center_budget', 'Donation\Sub_Cost_Center_Budget_Controller@index');
   Route::post('scc_for_budget', 'Donation\Sub_Cost_Center_Budget_Controller@scc_for_budget');
   Route::post('scc_budget_display', 'Donation\Sub_Cost_Center_Budget_Controller@scc_budget_display');
   Route::post('insert_scc_budget', 'Donation\Sub_Cost_Center_Budget_Controller@insert_scc_budget');
//
//    //  Donation Sub Cost Center Budget ends here
//
//
//    Route::get('donation_requisition', 'Donation\Donation_Controller@index');
//    Route::post('brand_region_post', 'Donation\Donation_Controller@brand_region_post');
//    Route::post('doc_info_post', 'Donation\Donation_Controller@doc_info_post');
//    Route::post('insert_data', 'Donation\Donation_Controller@donation_insert');
//    Route::post('cost_center_sales', 'Donation\Donation_Controller@cc_sales');
//    //    Donation Requisition ends here
//
//
//
//    //    Donation Requisition exception starts here
//    Route::get('donation_requisition_exception', 'Donation\Donation_exception_Controller@index');
//    Route::post('depo_and_doc', 'Donation\Donation_exception_Controller@depo_and_doc');
//    Route::post('brand_region_post_exception', 'Donation\Donation_exception_Controller@brand_region_post');
//    Route::post('doc_info_post_exception', 'Donation\Donation_exception_Controller@doc_info_post');
//    Route::post('insert_data_exception', 'Donation\Donation_exception_Controller@donation_insert');
//    Route::post('cost_center_sales_exception', 'Donation\Donation_exception_Controller@cc_sales');
//    //    Donation Requisition exception ends here
//
//
//     //    SSD Donation Requisition exception starts here
   Route::get('ssd_donation_requisition_exception', 'Donation\SSD_Donation_exception_Controller@index');
//
   Route::post('ssd_insert_data_exception', 'Donation\SSD_Donation_exception_Controller@donation_insert');
//
//    //  SSD  Donation Requisition exception ends here
//
//    // Donation Requisition Exception V2 start----------------------------------
//
//    //raqib
   Route::get('reqexp_v','Donation\Donation_Req_Excp_Controller@index');
   Route::get('getInitialData','Donation\Donation_Req_Excp_Controller@getInitialData');
   Route::post('getAmTerr','Donation\Donation_Req_Excp_Controller@getAmTerrByDepot');
   Route::post('getDoctorById','Donation\Donation_Req_Excp_Controller@getDoctorInfoTerrById');
   Route::post('getTerrByDepot','Donation\Donation_Req_Excp_Controller@getDoctorNameWiseTerr');
   Route::post('getGbrInfo','Donation\Donation_Req_Excp_Controller@getGbrInformation');
   Route::post('saveReq','Donation\Donation_Req_Excp_Controller@save_requisitions');
   Route::post('checkEligibility','Donation\Donation_Req_Excp_Controller@checkDoctorExpenseEligibility');


   //hema
    Route::post('getBEFTNmasterData','Donation\Donation_Req_Excp_Controller@getBEFTNmasterData');
    Route::get('beftn_advice','Donation\BEFTN_advice_Controller@index');
    Route::post('beftn_sum_show', 'Donation\BEFTN_advice_Controller@beftn_sum_show');
    Route::post('prepare_beftn_advice', 'Donation\BEFTN_advice_Controller@prepare_beftn_advice');
    Route::post('print_beftn_advice', 'Donation\BEFTN_advice_Controller@print_beftn_advice');
    Route::post('print_beftn_payee', 'Donation\BEFTN_advice_Controller@print_beftn_payee');
    Route::post('send_mail_beftn', 'Donation\BEFTN_advice_Controller@send_mail_beftn');
    Route::post('print_beftn_advice_super', 'Donation\BEFTN_advice_Controller@print_beftn_advice_super');
    Route::post('print_beftn_payee_list_super', 'Donation\BEFTN_advice_Controller@print_beftn_payee_super');
    
//
//    // Donation Requisition exception end---------------------------------
//
////    Requisition verification starts here
   Route::get('requisition_verification', 'Donation\Requisition_Controller@index');
    Route::get('regWTerrAmList', 'Donation\Requisition_Controller@regWTerrAmList');
   Route::get('regwMpoTerrList', 'Donation\Requisition_Controller@regwMpoTerrList');
   Route::post('brandRegion', 'Donation\Requisition_Controller@brandRegion');
   Route::post('requisition_data', 'Donation\Requisition_Controller@requisition_data');
   Route::post('update_row', 'Donation\Requisition_Controller@update_row');
   Route::post('delete_row', 'Donation\Requisition_Controller@delete_row');
   Route::post('verify_row', 'Donation\Requisition_Controller@verify_row');
   Route::get('freq_edit', 'Donation\Requisition_Controller@freq_edit');
   Route::get('get_BrandBy_docId', 'Donation\Requisition_Controller@get_BrandBy_docId');
   Route::post('brandRegion_be', 'Donation\Requisition_Controller@brandRegion_be');
//
//    Route::get('vacant_territory', 'Donation\Requisition_Controller@vacant_territory_view');
    Route::post('verify_donation', 'Donation\Requisition_Controller@verify_donation');
    Route::post('verify_medicine', 'Donation\Requisition_Controller@verify_medicine');
//    Requisition verification ends here
//
//    //    SSD Report Process starts here
//
   Route::get('ssd_report_process', 'Donation\Ssd_Report_Controller@index');
   Route::post('am_fetch_ssd', 'Donation\Ssd_Report_Controller@am_fetch_ssd');
   Route::post('mpo_fetch_ssd', 'Donation\Ssd_Report_Controller@mpo_fetch_ssd');
   Route::post('ccwiswe_req_data', 'Donation\Ssd_Report_Controller@ccwiswe_req_data');
   Route::post('detail_table_fetch', 'Donation\Ssd_Report_Controller@detail_table_fetch');
   Route::post('verify_ssd', 'Donation\Ssd_Report_Controller@verify_ssd');
   Route::post('infavor_update_ssd', 'Donation\Ssd_Report_Controller@infavor_update_ssd');
   Route::post('docname_update_ssd', 'Donation\Ssd_Report_Controller@docname_update_ssd');
   Route::post('bengroup_update', 'Donation\Ssd_Report_Controller@bengroup_update');
//
////    SSD Report Process ends here
//
//      //    /*-----------Doctor wise Donation starts here
//
   Route::get('doc_wise_view', 'Donation\Ssd_Report_Controller@doc_wise_view');
   Route::post('doc_wise_donation', 'Donation\Ssd_Report_Controller@doc_wise_donation');
//
//         //    Doctor wise Donation ends here
//
//    //    /*-----------Infavor correction starts here
//
   Route::get('infavor_correction_view', 'Donation\Ssd_Report_Controller@infavor_correction_view');
   Route::post('infavor_correction', 'Donation\Ssd_Report_Controller@infavor_correction');
   Route::post('infavor_update', 'Donation\Ssd_Report_Controller@infavor_update');
   Route::post('doctor_name_update', 'Donation\Ssd_Report_Controller@doctor_name_update');

   Route::post('update_pom', 'Donation\Ssd_Report_Controller@pay_mode_update');
   Route::post('update_pay_month', 'Donation\Ssd_Report_Controller@pay_month_update');
   Route::post('update_bengroup', 'Donation\Ssd_Report_Controller@update_bengroup');
   Route::post('ssd_check_date_remove', 'Donation\Ssd_Report_Controller@ssd_check_date_remove');
//
//    //    Infavor correctionion ends here
//
//    //    AM GM approval starts here
   Route::get('amgm_approval', 'Donation\Am_Gm_Approval_Controller@index');
    Route::get('get_cc', 'Donation\Am_Gm_Approval_Controller@get_cc');
   Route::get('get_scc', 'Donation\Am_Gm_Approval_Controller@get_scc');
   Route::post('ccwiswe_req_data_agm', 'Donation\Am_Gm_Approval_Controller@ccwiswe_req_data');
   Route::post('detail_table_fetch_agm', 'Donation\Am_Gm_Approval_Controller@detail_table_fetch');
   Route::post('verify_agm', 'Donation\Am_Gm_Approval_Controller@verify_agm');
   Route::post('delete_row_gm', 'Donation\Am_Gm_Approval_Controller@delete_row_gm');
//
////    AM GM approval ends here
//
//     //    FI process starts here
   Route::get('fi_process', 'Donation\FI_Process_Controller@index');
   Route::post('fi_req_data', 'Donation\FI_Process_Controller@fi_req_data');
   Route::post('sum_save', 'Donation\FI_Process_Controller@sum_save');
   Route::post('sum_display', 'Donation\FI_Process_Controller@dis_summary');
   Route::post('doc_update', 'Donation\FI_Process_Controller@doc_update');
   Route::post('print_fi_process', 'Donation\FI_Process_Controller@print_fi_process');
   Route::post('print_fi_process_second', 'Donation\FI_Process_Controller@print_fi_process_second');
   Route::post('print_fi_process_stp', 'Donation\FI_Process_Controller@print_fi_process_stp');
   Route::post('rem_requests', 'Donation\FI_Process_Controller@rem_requests');
//
////    FI process ends here
//
//  //    Cheque Advice starts here
   Route::get('cheque_advice', 'Donation\Cheq_Advice_Controller@index');
   Route::post('sum_show', 'Donation\Cheq_Advice_Controller@sum_show');
   Route::post('prepare_advice', 'Donation\Cheq_Advice_Controller@prepare_advice');
   Route::post('print_advice', 'Donation\Cheq_Advice_Controller@print_advice');
   Route::post('print_payee', 'Donation\Cheq_Advice_Controller@print_payee');
   Route::post('send_mail_cheque', 'Donation\Cheq_Advice_Controller@send_mail_cheque');
   Route::post('print_advice_super', 'Donation\Cheq_Advice_Controller@print_advice_super');
   Route::post('print_payee_list_super', 'Donation\Cheq_Advice_Controller@print_payee_super');
////    Cheque Advice ends here
//
//    //    Cash Advice starts here
   Route::get('cash_advice', 'Donation\Cash_Advice_Controller@index');
   Route::post('depot_detail', 'Donation\Cash_Advice_Controller@depot_detail');
   Route::post('det_process', 'Donation\Cash_Advice_Controller@det_process');
   Route::post('save_proc', 'Donation\Cash_Advice_Controller@save_proc');
   Route::post('print_summary', 'Donation\Cash_Advice_Controller@print_summary');
   Route::post('send_mail_cash', 'Donation\Cash_Advice_Controller@send_mail_cash');
   Route::post('print_summary_super', 'Donation\Cash_Advice_Controller@print_summary_super');
//
//
////    Cash Advice ends here
//
//      //Pay list start
   Route::get('pay_list','Donation\Ssd_Report_Controller@pay_list_view');
   Route::post('pl_selection','Donation\Ssd_Report_Controller@selection_date');
   Route::post('print_paylist','Donation\Ssd_Report_Controller@print_paylist');

   Route::get('pay_list_dw', 'Donation\Ssd_Report_Controller@pay_list_view_dw');
   Route::post('print_paylist_dw', 'Donation\Ssd_Report_Controller@print_paylist_dw');
//
//    //pay list end
//
//
//        //    Donation Budget & Expense  starts here
   Route::get('budget_expense_report', 'Donation\Budget_Expense_Report_Controller@index');
   Route::post('budget_expense_report', 'Donation\Budget_Expense_Report_Controller@budget_expense_report');
//
////    Donation Budget & Expense ends here
//
//    //    pending request starts here
   Route::get('pending_request', 'Donation\Pending_Request_Controller@index');
   Route::post('pending_request_data', 'Donation\Pending_Request_Controller@pending_request_data');
//
////    pending request ends here
//


   //    verified_not_verified starts here

   Route::get('verified_not_verified', 'Donation\Verified_Not_Verified_Controller@index');
   Route::post('verified_not_verified_data', 'Donation\Verified_Not_Verified_Controller@verified_not_verified_data');

//    verified_not_verified ends here

});

//Offer Price   Author :: Sahadat
Route::group(['prefix' => 'offer', 'middleware' => ['auth', 'recheck']], function () {

    //    Offer Price approval  starts here
    Route::get('discount_approval', 'Offer_Price\Offer_Price_Controller@index');
    Route::post('table_data', 'Offer_Price\Offer_Price_Controller@detail_table_fetch');
    Route::post('discount_blp_data', 'Offer_Price\Offer_Price_Controller@discount_blp_data');
    Route::post('verify_and_update', 'Offer_Price\Offer_Price_Controller@verify_and_update');

    //   Offer Price approval ends here


});

//Doctor Medicine Requisition   Author :: Sahadat
Route::group(['prefix' => 'dmr', 'middleware' => ['auth', 'recheck']], function () {

    //    Medicine Requisition  Cost Center Budget  starts here
    Route::get('cost_center_budget_dmr', 'Dmr\Cost_Centre_Budget_Controller@index');
    Route::post('cc_budget_display', 'Dmr\Cost_Centre_Budget_Controller@cc_budget_display');
    Route::post('insert_cc_budget', 'Dmr\Cost_Centre_Budget_Controller@insert_cc_budget');
    Route::post('subtract_budget_calc', 'Dmr\Cost_Centre_Budget_Controller@subtract_budget_calc');
    Route::post('cc_budget_history', 'Dmr\Cost_Centre_Budget_Controller@cc_budget_history');

    //    Medicine Requisition Cost Center Budget ends here

    //    Budget Report  summary starts here
    Route::get('budget_report', 'Dmr\Budget_Report_Controller@index');
    Route::get('don_sum_medicine', 'Dmr\Budget_Report_Controller@cc_don');
    Route::post('cc_budget_report', 'Dmr\Budget_Report_Controller@cc_budget_report');

    // Budget Report summary ends here

    //Doctor medicine requisition starts here
    
        Route::get('doctor_medicine_requisition','Dmr\Doctor_Medicine_Requisition_Controller@index');
        Route::post('prod_code', 'Dmr\Doctor_Medicine_Requisition_Controller@prod_code');
        Route::get('getMpoTerr_DMR','Dmr\Doctor_Medicine_Requisition_Controller@regwMpoTerrList');
        Route::post('depo_and_doc_dmr', 'Dmr\Doctor_Medicine_Requisition_Controller@depo_and_doc');
        Route::post('insert_row_dmr','Dmr\Doctor_Medicine_Requisition_Controller@insert_row_dmr');
    
    //Doctor medicine requisition ends here
    
    
        // medicine requisition verification starts here
    
        Route::get('medicine_requisition_verification','Dmr\Medicine_Requisition_Verification_Controller@index');
        Route::get('fetch_am_dmr','Dmr\Medicine_Requisition_Verification_Controller@fetch_am_dmr');
        Route::get('fetch_mpo_dmr','Dmr\Medicine_Requisition_Verification_Controller@fetch_mpo_dmr');
        Route::post('gl_cc_dmr','Dmr\Medicine_Requisition_Verification_Controller@gl_cc');
        Route::post('display_data_for_dmr_verification','Dmr\Medicine_Requisition_Verification_Controller@display_data');
        Route::post('verify_row_dmr','Dmr\Medicine_Requisition_Verification_Controller@verify_row');
        Route::post('delete_row_dmr','Dmr\Medicine_Requisition_Verification_Controller@delete_row');
        Route::post('update_row_dmr','Dmr\Medicine_Requisition_Verification_Controller@update_row');
    
    // medicine requisition verification ends here
    
    //    SSD Report Process starts here

    Route::get('ssd_process_dmr', 'Dmr\Ssd_Process_Dmr_Controller@index');
    Route::post('am_fetch_ssd', 'Dmr\Ssd_Process_Dmr_Controller@am_fetch_ssd'); 
    Route::post('mpo_fetch_ssd', 'Dmr\Ssd_Process_Dmr_Controller@mpo_fetch_ssd');
    Route::post('ssd_dmr_data', 'Dmr\Ssd_Process_Dmr_Controller@ssd_dmr_data');
    Route::post('verify_ssd_dmr', 'Dmr\Ssd_Process_Dmr_Controller@verify_ssd');

    Route::get('rm_dsm_pending', 'Dmr\Ssd_Process_Dmr_Controller@rm_dsm_pending_view');
    Route::post('rm_dsm_pending_data', 'Dmr\Ssd_Process_Dmr_Controller@rm_dsm_pending_data');

//    SSD Report Process ends here

    //    rm_wise_report starts here

    Route::get('rm_wise_report', 'Dmr\Rm_Wise_Report_Controller@index');
    Route::post('rm_depot', 'Dmr\Rm_Wise_Report_Controller@rm_depot');
    Route::post('rm_wise_data', 'Dmr\Rm_Wise_Report_Controller@rm_wise_data');
     Route::post('rm_wise_report_pdf', 'Dmr\Rm_Wise_Report_Controller@rm_wise_report_pdf');

//    rm_wise_report ends here

    //    depot_wise_report starts here

    Route::get('depot_wise_report', 'Dmr\Depot_Wise_Report_Controller@index');
    Route::post('depot_wise_data', 'Dmr\Depot_Wise_Report_Controller@depot_wise_data');
     Route::post('depot_wise_report_pdf', 'Dmr\Depot_Wise_Report_Controller@depot_wise_report_pdf');

//    depot_wise_report ends here
    
    });

//Scientific Seminar   Author :: Sahadat
Route::group(['prefix' => 'scientific', 'middleware' => ['auth', 'recheck']], function () {

    //    Scientific Seminar proposal starts here
    Route::get('seminar_proposal', 'Scientific_Seminar\Scientific_Seminar_Controller@index');
    Route::post('create_program', 'Scientific_Seminar\Scientific_Seminar_Controller@create_program');
    Route::post('am_change', 'Scientific_Seminar\Scientific_Seminar_Controller@am_change');
    Route::post('depo', 'Scientific_Seminar\Scientific_Seminar_Controller@depo');
    Route::post('delete_button', 'Scientific_Seminar\Scientific_Seminar_Controller@delete_button');
    Route::post('save_button', 'Scientific_Seminar\Scientific_Seminar_Controller@save_button');
    Route::post('insert_budget','Scientific_Seminar\Scientific_Seminar_Controller@insert_budget');
    Route::post('insert_cost','Scientific_Seminar\Scientific_Seminar_Controller@insert_cost');
    Route::post('verify_data_program', 'Scientific_Seminar\Scientific_Seminar_Controller@verify_data_show');
    Route::post('verify_program','Scientific_Seminar\Scientific_Seminar_Controller@verify_update');
    Route::post('brand_update','Scientific_Seminar\Scientific_Seminar_Controller@brand_update');
    Route::post('gl_cc','Scientific_Seminar\Scientific_Seminar_Controller@gl_cc');

    //    Scientific Seminar proposal ends here

    //    Scientific Seminar Bill starts here
    Route::get('seminar_bill', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@index');
    Route::post('create_bill', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@create_program');
    Route::post('save_button_direct_bill', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@save_button_direct_bill');
    Route::post('save_button_program_bill', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@save_button_program_bill');
    Route::post('program_bill', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@program_bill');
    Route::post('verify_data_show', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@verify_data_show');
    Route::post('verify_update', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@verify_update');
    Route::post('delete_button_bill', 'Scientific_Seminar\Scientific_Seminar_Bill_Controller@delete_button');

    //    Scientific Seminar Bill ends here

    //    Scientific Seminar Reports starts here
    Route::get('seminar_reports', 'Scientific_Seminar\Scientific_Seminar_Report_Controller@index');
    Route::get('print_proposal_report', 'Scientific_Seminar\Scientific_Seminar_Report_Controller@print_proposal_report');
    Route::get('print_bill_report', 'Scientific_Seminar\Scientific_Seminar_Report_Controller@print_bill_report');
    Route::post('program_and_bill', 'Scientific_Seminar\Scientific_Seminar_Report_Controller@program_and_bill');
    //    Scientific Seminar Reports ends here


    //    Scientific Seminar voucher starts here
    Route::get('seminar_voucher', 'Scientific_Seminar\Scientific_Seminar_Voucher_Controller@index');
    Route::post('create_proposal_voucher', 'Scientific_Seminar\Scientific_Seminar_Voucher_Controller@create_proposal_voucher');
    Route::post('print_proposal_voucher', 'Scientific_Seminar\Scientific_Seminar_Voucher_Controller@print_proposal_voucher');
    Route::post('print_proposal_voucher_duplicate', 'Scientific_Seminar\Scientific_Seminar_Voucher_Controller@print_proposal_voucher_duplicate');
    Route::post('create_bill_voucher', 'Scientific_Seminar\Scientific_Seminar_Voucher_Controller@create_bill_voucher');
    Route::post('print_bill_voucher', 'Scientific_Seminar\Scientific_Seminar_Voucher_Controller@print_bill_voucher');
    Route::post('print_bill_voucher_duplicate', 'Scientific_Seminar\Scientific_Seminar_Voucher_Controller@print_bill_voucher_duplicate');

    //    Scientific Seminar voucher ends here

    //    pending request starts here
    Route::get('approval_status', 'Scientific_Seminar\Pending_Request_Controller@index');
    Route::post('sci_year', 'Scientific_Seminar\Pending_Request_Controller@re_year');
    Route::get('proposal_and_bill', 'Scientific_Seminar\Pending_Request_Controller@proposal_and_bill');
    Route::post('pending_request_data', 'Scientific_Seminar\Pending_Request_Controller@pending_request_data');

//    pending request ends here

    //     Cost Center Budget  starts here
    Route::get('cost_center_budget', 'Scientific_Seminar\Cost_Centre_Budget_Controller@index');
    Route::get('cc_don', 'Scientific_Seminar\Cost_Centre_Budget_Controller@cc_don');
    Route::post('re_year', 'Scientific_Seminar\Cost_Centre_Budget_Controller@re_year');
    Route::post('cc_budget_display', 'Scientific_Seminar\Cost_Centre_Budget_Controller@cc_budget_display');
    Route::post('insert_cc_budget', 'Scientific_Seminar\Cost_Centre_Budget_Controller@insert_cc_budget');
    Route::post('subtract_budget_calc', 'Scientific_Seminar\Cost_Centre_Budget_Controller@subtract_budget_calc');
    Route::post('cc_budget_history', 'Scientific_Seminar\Cost_Centre_Budget_Controller@cc_budget_history');

    //    Budget Report  summary starts here
    Route::get('budget_report', 'Scientific_Seminar\Budget_Report_Controller@index');
    Route::get('cc_don_sum', 'Scientific_Seminar\Budget_Report_Controller@cc_don');
    Route::post('cc_budget_report', 'Scientific_Seminar\Budget_Report_Controller@cc_budget_report');
    // Budget Report summary ends here

    //    outstanding proposal starts here
    Route::get('outstanding_proposal_view', 'Scientific_Seminar\Reports_Controller@outstanding_proposal_view');
    Route::get('bill_settlement_view', 'Scientific_Seminar\Reports_Controller@bill_settlement_view');
    Route::get('budget_actual_consumption_view', 'Scientific_Seminar\Reports_Controller@budget_actual_consumption_view');
    Route::get('teamwise_budget_expense_view', 'Scientific_Seminar\Reports_Controller@teamwise_budget_expense_view');
    Route::get('depotwise_actual_view', 'Scientific_Seminar\Reports_Controller@depotwise_actual_view');
//    Route::post('sci_year', 'Scientific_Seminar\Pending_Request_Controller@re_year');
//    Route::get('proposal_and_bill', 'Scientific_Seminar\Pending_Request_Controller@proposal_and_bill');
    Route::post('opdata_display', 'Scientific_Seminar\Reports_Controller@opdata_display');
    Route::post('bsdata_display', 'Scientific_Seminar\Reports_Controller@bsdata_display');
    Route::post('bacdata_display', 'Scientific_Seminar\Reports_Controller@budget_actual_consumption_data');
    Route::post('tbedata_display', 'Scientific_Seminar\Reports_Controller@tbedata_display');
    Route::post('depotdata_display', 'Scientific_Seminar\Reports_Controller@depot_wise_data_display');

//    outstanding proposal ends here

//    Group Head & ED Approval starts here
    Route::get('proposal_bill_approval', 'Scientific_Seminar\ProposalBillApprovalController@index');
    Route::post('getProposalDetailInfo', 'Scientific_Seminar\ProposalBillApprovalController@getProposalDetailInfo');
    Route::post('getBillDetailInfo', 'Scientific_Seminar\ProposalBillApprovalController@getBillDetailInfo');
    Route::post('verify_program_data', 'Scientific_Seminar\ProposalBillApprovalController@verify_program_data');
    Route::post('verify_bill_data', 'Scientific_Seminar\ProposalBillApprovalController@verify_bill_data');

//    Group Head & ED Approval ends here
});


//Sadun Ajfar Rahman

Route::group(['prefix' => 'nc', 'middleware' => ['auth', 'recheck']], function () {

    //    Hospital wise chemist entry
    Route::get('chemist_entry', 'Neocare\Hopital_Wise_Chemist_Controller@index');
    Route::get('sample_entry', 'Neocare\Hopital_Wise_Chemist_Controller@sample_entry_view');
    Route::get('sample_info_report', 'Neocare\Hopital_Wise_Chemist_Controller@sample_info_report_view');
    Route::get('hwc_report', 'Neocare\Hopital_Wise_Chemist_Controller@hwc_report_view');

    Route::post('display_query_hwc_report', 'Neocare\Hopital_Wise_Chemist_Controller@display_hwc_report_data');
    Route::post('market_name', 'Neocare\Hopital_Wise_Chemist_Controller@market_retrieve');
    Route::post('hospital_name', 'Neocare\Hopital_Wise_Chemist_Controller@hospital_retrieve');
    Route::post('chemist_name', 'Neocare\Hopital_Wise_Chemist_Controller@chemist_retrieve');
    Route::post('insert_row_nc', 'Neocare\Hopital_Wise_Chemist_Controller@insert_row_nc');
    Route::post('display_query', 'Neocare\Hopital_Wise_Chemist_Controller@display_hwc_data');
    Route::post('delete_row_hwc', 'Neocare\Hopital_Wise_Chemist_Controller@delete_row_hwc');

    Route::post('multiple_row_retrieve', 'Neocare\Hopital_Wise_Chemist_Controller@multiple_row_retrieve');
    Route::post('insert_row_sample', 'Neocare\Hopital_Wise_Chemist_Controller@insert_row_sample');
    Route::post('display_query_sample', 'Neocare\Hopital_Wise_Chemist_Controller@display_sample_data');
    Route::post('display_query_sample_report', 'Neocare\Hopital_Wise_Chemist_Controller@sample_report_data');
    Route::post('delete_row_sample_info', 'Neocare\Hopital_Wise_Chemist_Controller@delete_row_sample_info');


    ///**
    //**--------NEO CARE--------------------
    //**/
    Route::get('Neocare', 'NeocareController@neocare');
    Route::post('save', 'NeocareController@save');
    Route::get('customerinforep','CustomerInfoRepController@customerinforeportview');
    Route::post('getreportdata','CustomerInfoRepController@customerinforeport');
    Route::post('getamid','CustomerInfoRepController@getramterr');
    Route::post('getmpoid','CustomerInfoRepController@getmpoterr');
	
	  //send neo sms
    Route::get('neosms', 'CustomerInfoRepController@neosms');
    Route::get('customersmsdata', 'CustomerInfoRepController@customersmsdata');
    Route::post('reportview1','CustomerInfoRepController@reportview1');
    Route::post('save_group','CustomerInfoRepController@save_group');
    Route::get('getGroupList','CustomerInfoRepController@getGroupList');
    Route::post('neo_send_sms','CustomerInfoRepController@sendSmsToCustomer');
    Route::get('check_stat','CustomerInfoRepController@check_sms_send_stat');
    Route::post('neo_single_sms','CustomerInfoRepController@sendSingleSMS');

});

Route::get('survey', 'NeoSurveyController@index');
Route::post('neosurvey','NeoSurveyController@neosurvey');

//Event  Author :: Dipro
Route::group(['prefix' => 'event', 'middleware' => ['auth', 'recheck']], function () {

    Route::get('room_view', 'EMS\RoomController@index');
    Route::get('event_view', 'EMS\EventController@index');
    //    Event Management System starts here
    Route::post('insert_room_info', 'EMS\RoomController@insert_room');
    Route::post('update_room_info', 'EMS\RoomController@update_room');
    Route::post('search_room', 'EMS\RoomController@search_room');

    //Managing Booking Information
    Route::post('insert_booking_info', 'EMS\EventController@book_event');
    Route::post('roomcardview', 'EMS\EventController@roomCard_view');
    Route::post('cancelbooking', 'EMS\EventController@cancel_booking');

    //Event Booking Report
    Route::get('booking_report_view','EMS\BookingReportController@bookingreportview');
    Route::post('getreportdata','EMS\BookingReportController@bookingreportdata');

    //Request Approval View
    Route::get('admin_panel_view/{eid?}  ', 'EMS\AdminPanelController@adminpanelview');
    Route::post('admin_panel_data', 'EMS\AdminPanelController@adminpaneldata');
    Route::post('admin_panel_single_data', 'EMS\AdminPanelController@adminpanelsingledata');
    Route::post('approve_dorm_booking', 'EMS\AdminPanelController@approvedormbooking');
    Route::post('edit_dorm_booking', 'EMS\AdminPanelController@editdormbooking');
    Route::post('cancel_dorm_booking', 'EMS\AdminPanelController@canceldormbooking');

    Route::post('update_event_time', 'EMS\AdminPanelController@updateeventtime');
    Route::post('dorm_book_info', 'EMS\AdminPanelController@dormbookinfo');
});


//Export Database :: Masroor
Route::group(['prefix' => 'expo', 'middleware' => ['auth', 'recheck']], function () {

    //Expo Entry interface
    Route::get('getExpoView','ExpoDatabase\ExpoDatabaseController@index');
    Route::get('getExpoEntryData','ExpoDatabase\ExpoDatabaseController@getExpoEntryData');

    Route::post('getIRAStage1Data','ExpoDatabase\ExpoDatabaseController@getIRAStage1Data');
    Route::post('nonCtdUpload','ExpoDatabase\ExpoDatabaseController@upload');
    Route::post('ctdUpload','ExpoDatabase\ExpoDatabaseController@upload');
    Route::post('getExpoEntryInfo','ExpoDatabase\ExpoDatabaseController@getExpoEntryInfo');
    Route::post('updateStage1IM','ExpoDatabase\ExpoDatabaseController@updateStage1IM');
    Route::post('updateStage2IRA','ExpoDatabase\ExpoDatabaseController@updateStage2IRA');
    Route::post('UPDATE_STAGE2_IM','ExpoDatabase\ExpoDatabaseController@UPDATE_STAGE2_IM');
    Route::post('UPDATE_STAGE3_IRA','ExpoDatabase\ExpoDatabaseController@UPDATE_STAGE3_IRA');

    //Expo plant Wise products
    Route::get('getPageExpoPlantWiseDataUpload','ExpoDatabase\ExpoPlantWiseProductsController@index');
    Route::post('uploadExpoPlantWiseData','ExpoDatabase\ExpoPlantWiseProductsController@uploadExpoPlantWiseData');
    Route::post('getProductInfo','ExpoDatabase\ExpoPlantWiseProductsController@getProductInfo');

    //Expo Country Wise products
    Route::get('getPageExpoCountryWiseProducts','ExpoDatabase\ExpoCountryWiseProductsController@index');
    Route::post('uploadExpoCountryWiseData','ExpoDatabase\ExpoCountryWiseProductsController@uploadExpoCountryWiseData');
    Route::get('getBulkCode','ExpoDatabase\ExpoCountryWiseProductsController@getBulkCode');
    Route::get('getProductName','ExpoDatabase\ExpoCountryWiseProductsController@productName');
    Route::post('getFinishProductInfo','ExpoDatabase\ExpoCountryWiseProductsController@getFinishProductInfo');
    Route::post('saveExpoCountryWise','ExpoDatabase\ExpoCountryWiseProductsController@saveExpoCountryWise');

    //Expo Entry Update
    Route::get('getExpoEntryInfoUpdate','ExpoDatabase\ExpoDatabaseController@getExpoEntryInfoUpdate');
    Route::get('getProductByExpoCountry','ExpoDatabase\ExpoDatabaseController@getProductByExpoCountry');
    Route::get('getIMExpoData','ExpoDatabase\ExpoDatabaseController@getIMExpoData');
    Route::get('getLineWiseIMData/{line_id}','ExpoDatabase\ExpoDatabaseController@getLineWiseIMData');
    Route::get('saveImStage1','ExpoDatabase\ExpoDatabaseController@saveImStage1');
    Route::get('saveIRAStage2','ExpoDatabase\ExpoDatabaseController@saveIRAStage2');
    Route::post('saveIMStage2','ExpoDatabase\ExpoDatabaseController@saveIMStage2');
    Route::get('saveIRAStage3','ExpoDatabase\ExpoDatabaseController@saveIRAStage3');


    Route::group(['prefix'=>'report'],function(){
        //Reports
        Route::get('AgentListIndex','ExpoDatabase\Reports\AgentInformationController@index');
        Route::post('getAgentByCountry','ExpoDatabase\Reports\AgentInformationController@getAgentByCountry');
        Route::get('marketingIndex','ExpoDatabase\Reports\MarketingInformationController@index');
        Route::post('getExpoCountry','ExpoDatabase\Reports\MarketingInformationController@getExpoCountry');
        Route::post('getExpoMarketingAID','ExpoDatabase\Reports\MarketingInformationController@getExpoMarketingAID');


        Route::get('imTeamWiseProductStatus','ExpoDatabase\Reports\ImTeamWiseProductStatusController@index');
        Route::post('ImGetExpoCountry','ExpoDatabase\Reports\ImTeamWiseProductStatusController@ImGetExpoCountry');
        Route::post('ImGetExpoProduct','ExpoDatabase\Reports\ImTeamWiseProductStatusController@ImGetExpoProduct');
        Route::post('ImGetProductStatus','ExpoDatabase\Reports\ImTeamWiseProductStatusController@ImGetProductStatus');
        Route::post('getIMStatusResult','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getIMStatusResult');

        //Im Team wise Number of Product
        Route::get('cwps','ExpoDatabase\Reports\ImTeamWiseProductStatusController@cwps');
        Route::post('IMCountryWiseProductStatus','ExpoDatabase\Reports\ImTeamWiseProductStatusController@countryWiseProductStatus');

        //Product Current Status
        Route::get('pcs','ExpoDatabase\Reports\ImTeamWiseProductStatusController@pcs');
        Route::post('CountryWiseGetExpoProduct','ExpoDatabase\Reports\ImTeamWiseProductStatusController@CountryWiseGetExpoProduct');
        Route::post('getCWPSResult','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getCWPSResult');
        
        // Graphp - chart
        Route::get('cwbarcharts','ExpoDatabase\Reports\ImTeamWiseProductStatusController@cwbarcharts');

        //expiry Renewal status
        Route::get('ers','ExpoDatabase\Reports\ImTeamWiseProductStatusController@ers');
        Route::post('getErsResult','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getErsResult');

         //Registration certificate of a product
        Route::get('regCertificate','ExpoDatabase\Reports\ImTeamWiseProductStatusController@regCertificate');
        Route::POST('getCOP','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getRegCertificateOfProduct');


        //Year Wise status
        Route::get('yearWiseStatus','ExpoDatabase\Reports\ImTeamWiseProductStatusController@yearWiseStatus');
        Route::post('getYearWiseProductName','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getYearWiseProductName');
        Route::post('getYearWiseExpoCountry','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getYearWiseExpoCountry');
        Route::post('getYearWiseExpoTeam','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getYearWiseExpoTeam');
        Route::post('getYearWiseExpoResult','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getYearWiseExpoResult');

        //QA Product Status
        Route::get('qaps','ExpoDatabase\Reports\ImTeamWiseProductStatusController@qaps');
        Route::post('prodBulkCodeWiseProductName','ExpoDatabase\Reports\ImTeamWiseProductStatusController@prodBulkCodeWiseProductName');
        Route::post('pcodeWiseCountry','ExpoDatabase\Reports\ImTeamWiseProductStatusController@pcodeWiseCountry');
        Route::post('getQAWPSResult','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getQAWPSResult');

        // QA - Product Status Current
        Route::get('qapsCurrent','ExpoDatabase\Reports\ImTeamWiseProductStatusController@qapsCurrent');
        Route::post('getQAWPSCurrentResult','ExpoDatabase\Reports\ImTeamWiseProductStatusController@getQAWPSCurrentResult');

        //Export country count of Incepta
        Route::get('country_count_page','ExpoDatabase\Reports\ExpoReportController@country_count_page');
        Route::post('getExpoCountryByGroup','ExpoDatabase\Reports\ExpoReportController@getExpoCountryByGroup');

        //Submission Datewise product status
        Route::get('subDateProdStatus_page','ExpoDatabase\Reports\ExpoReportController@subDateProdStatus_page');
        Route::post('getSubDateWPStatus','ExpoDatabase\Reports\ExpoReportController@getSubDateWPStatus');
                
        //Year Wise Submission Status

        Route::get('yearWiseSubStatus','ExpoDatabase\Reports\ExpoReportController@yearWiseSubStatus');
        Route::post('getYearWiseSubmissionStatus','ExpoDatabase\Reports\ExpoReportController@getYearWiseSubmissionStatus');

        //bulkProdStatus
        Route::get('bulkProdStatus','ExpoDatabase\Reports\ExpoReportController@bulkProdStatus');
        Route::post('getQABulkProductStatus','ExpoDatabase\Reports\ExpoReportController@getQABulkProductStatus');

        //bulkProdStatus
        Route::get('genericProductForScm','ExpoDatabase\Reports\GenericReportForSCMController@index');
        Route::post('getImTeamName','ExpoDatabase\Reports\GenericReportForSCMController@getImTeamName');
        Route::post('ImScmGetExpoCountry','ExpoDatabase\Reports\GenericReportForSCMController@ImScmGetExpoCountry');
        Route::post('ImScmGetExpoProduct','ExpoDatabase\Reports\GenericReportForSCMController@ImScmGetExpoProduct');
        Route::post('ImScmGetProductStatus','ExpoDatabase\Reports\GenericReportForSCMController@ImScmGetProductStatus');
        Route::post('getSCMReportOnIMDB','ExpoDatabase\Reports\GenericReportForSCMController@getSCMReportOnIMDB');
    });
});


// Developer: Md.Raqib Hasan(1012064)
Route::group(['prefix'=>'damail','middleware'=>['auth','recheck']],function (){
   Route::get('home','DaMail\DailyAttendanceMailController@index');
   Route::get('get_departments','DaMail\DailyAttendanceMailController@get_departments');
   Route::post('process_attn','DaMail\DailyAttendanceMailController@process_attendance_mail');
   Route::post('send_mail','DaMail\DailyAttendanceMailController@send_mail_to_dept');
   Route::get('record_details','DaMail\DailyAttendanceMailController@get_mail_records');
   Route::post('save_record','DaMail\DailyAttendanceMailController@save');
   Route::patch('update_record','DaMail\DailyAttendanceMailController@update');
   Route::post('delete_record','DaMail\DailyAttendanceMailController@delete');
});


//Doctor Sample Requisition Starts Here

Route::group(['prefix' => 'dsr', 'middleware' => ['auth', 'recheck']], function () {

//smaple requisition page
//insert requisition information
Route::get('sample_requisition_view', 'SampleRequisition\SampleRequisitionController@index');
Route::post('get_am_terr', 'SampleRequisition\SampleRequisitionController@get_am_terr');
Route::post('depo_and_doc_dmr', 'SampleRequisition\SampleRequisitionController@depo_and_doc');
Route::get('getMpoTerr_DMR','SampleRequisition\SampleRequisitionController@regwMpoTerrList');
Route::get('item_sample','SampleRequisition\SampleRequisitionController@item_sample');
Route::post('insert_requisition_info','SampleRequisition\SampleRequisitionController@insert_requisition_info');
Route::post('item_sample_stock','SampleRequisition\SampleRequisitionController@item_sample_stock');

//sample requisition verification page
Route::get('sample_req_verification_view', 'SampleRequisition\SampleReqVerificationController@index');
Route::post('be_and_terr_dsr', 'SampleRequisition\SampleReqVerificationController@be_and_terr');
Route::post('display_data_dsr', 'SampleRequisition\SampleReqVerificationController@display_data');
Route::post('verify_row_dsr', 'SampleRequisition\SampleReqVerificationController@verify_row');
Route::post('delete_row_dsr', 'SampleRequisition\SampleReqVerificationController@delete_row');
Route::post('update_row_dsr', 'SampleRequisition\SampleReqVerificationController@update_row');
Route::get('emp_access_status', 'SampleRequisition\SampleReqVerificationController@emp_access_status');
Route::post('summary_data_stock', 'SampleRequisition\SampleReqVerificationController@summary_data_stock');

Route::get('sample_req_report_view', 'SampleRequisition\Sample_req_reportController@index');
Route::post('display_data_dsr_report', 'SampleRequisition\Sample_req_reportController@display_data_report');
});
//Sample Requisition System


//Author(End) :: Dipro


//STABILITY STUDY MANAGEMENT(SADUN AJFAR RAHMAN)
Route::group(['prefix'=>'ssm','middleware' => ['auth','recheck']],function (){
    //SAMPLE
    Route::get('dataupload','SSM\DataUploadController@index');
    Route::post('/post_sample_data','SSM\DataUploadController@postSampleData');
    
    Route::get('sample_info','SSM\SampleInformationController@Index');
    Route::get('search_saved_sample','SSM\SampleInformationController@searchProduct');
    Route::post('save_info','SSM\SampleInformationController@SaveRecord');
    Route::post('update_info','SSM\SampleInformationController@UpdateRecord');
    Route::post('retrieve_info','SSM\SampleInformationController@RetrieveRecord');
    //RESULT
    Route::get('result_info','SSM\ResultInformationController@Index');
    Route::post('resultsave_info','SSM\ResultInformationController@SaveRecord1');
    Route::post('ri_update_info','SSM\ResultInformationController@UpdateRecord1');
    Route::post('ri_retrieve_info','SSM\ResultInformationController@RetrieveRecord1');
    Route::post('ri_retrieve_pinfo','SSM\ResultInformationController@RetrieveSampleRecord');
    Route::post('get_accept','SSM\ResultInformationController@get_accept');
    //DAILY
    Route::get('dailymachinerun_info','SSM\DailyMachineRunController@Index');
    Route::post('dmr_saverecord','SSM\DailyMachineRunController@saverecord2');
    Route::post('dmr_displayrun','SSM\DailyMachineRunController@displayrun');
    Route::post('dmr_updaterun','SSM\DailyMachineRunController@updaterun');

   //INTERIM
    Route::get('interim_info','SSM\InterimStabilityController@Index');
    Route::post('is_saverecord','SSM\InterimStabilityController@saverecord2');
    Route::post('int_update_data','SSM\InterimStabilityController@UpdateRecord1');
    Route::get('search_saved_interim','SSM\InterimStabilityController@searchproduct');
    Route::post('int_retrieve_data','SSM\InterimStabilityController@retriveInfo');
    Route::get('get_product_name','SSM\InterimStabilityController@getProductName');
   
    Route::group(['prefix'=>'report'],function (){
         /**
         * Interim
         */
        Route::group(['prefix'=>'interim'],function (){

            //Interim Stability Data
            Route::get('interimstabilitydatareport','SSM\InterimStabilityReportController@index');
            Route::get('getinterimdata','SSM\InterimStabilityReportController@getInterimData');

        });

       Route::group(['prefix'=>'sample'],function (){

         // sample monthly Sample Planner
            Route::get('monthlystabilitysampleplanner_info','SSM\MonthlyStabilitySamplePlannerController@index');
            Route::get('getpname','SSM\MonthlyStabilitySamplePlannerController@getvalues');
            Route::post('displayinfoplanner','SSM\MonthlyStabilitySamplePlannerController@displayrecord');
            Route::get('exportexcel20/{querypara}','SSM\MonthlyStabilitySamplePlannerController@exportexcel');
            Route::get('exportpdf20/{querypara}','SSM\MonthlyStabilitySamplePlannerController@exportpdf');

    //        sample WORKLOAD
            Route::get('workloadcalc_info','SSM\WorkLoadCalcController@index');
            Route::get('getbatch','SSM\WorkLoadCalcController@getvalues');
            Route::post('displayinfo','SSM\WorkLoadCalcController@displayrecord');
            Route::get('exportexcel/{querypara}','SSM\WorkLoadCalcController@exportexcel');
            Route::get('exportpdf/{querypara}','SSM\WorkLoadCalcController@exportpdf');

    //        sample MACHINEHOUR
            Route::get('machinehour_info','SSM\MachineHourController@index');
            Route::get('batchget','SSM\MachineHourController@getvalues');
            Route::post('displayresult','SSM\MachineHourController@displayrecord');
            Route::get('exportexcel1/{querypara}','SSM\MachineHourController@exportexcel');
            Route::get('exportpdf1/{querypara}','SSM\MachineHourController@exportpdf');
                //sample Machine Utilization Calculation
            Route::get('machineutical_info','SSM\MachineUtilizationCalculationController@index');
            Route::get('batchget1','SSM\MachineUtilizationCalculationController@getvalues');
            Route::post('displayresult1','SSM\MachineUtilizationCalculationController@displayrecord');
            Route::get('exportexcel2/{querypara}','SSM\MachineUtilizationCalculationController@exportexcel');
            Route::get('exportpdf2/{querypara}','SSM\MachineUtilizationCalculationController@exportpdf');


            //Analyst wise Product List
            Route::get('analystwiseprdctlist_info','SSM\AnalystWiseProdyctListController@index');
            Route::get('batchget2','SSM\AnalystWiseProdyctListController@getvalues');
            Route::post('displayresult2','SSM\AnalystWiseProdyctListController@displayrecord');
            Route::get('exportexcel3/{querypara}','SSM\AnalystWiseProdyctListController@exportexcel');
            Route::get('exportpdf3/{querypara}','SSM\AnalystWiseProdyctListController@exportpdf');


            //Time Point wise Product List
            Route::get('timepointwiseprdctlist_info','SSM\TimePointWiseProductListController@index');
            Route::get('batchget3','SSM\TimePointWiseProductListController@getvalues');
            Route::post('displayresult3','SSM\TimePointWiseProductListController@displayrecord');
            Route::get('exportexcel4/{querypara}','SSM\TimePointWiseProductListController@exportexcel');
            Route::get('exportpdf4/{querypara}','SSM\TimePointWiseProductListController@exportpdf');

            //Chamber Wise Productlist
            Route::get('chamberwideproductlist_info','SSM\ChamberWiseProductListController@index');
            Route::get('batchget4','SSM\ChamberWiseProductListController@getvalues');
            Route::post('displayresult4','SSM\ChamberWiseProductListController@displayrecord');
            Route::get('exportexcel5/{querypara}','SSM\ChamberWiseProductListController@exportexcel');
            Route::get('exportpdf5/{querypara}','SSM\ChamberWiseProductListController@exportpdf');
            Route::get('searchProduct','SSM\ChamberWiseProductListController@searchProduct');

            // Product list matured within any time
            Route::get('productlistmaturedwithinanytime_info','SSM\ProductListMaturedWithinAnytimeController@index');
            Route::get('batchget5','SSM\ProductListMaturedWithinAnytimeController@getvalues');
            Route::post('displayresult5','SSM\ProductListMaturedWithinAnytimeController@displayrecord');
            Route::get('exportexcel6/{querypara}','SSM\ProductListMaturedWithinAnytimeController@exportexcel');
            Route::get('exportpdf6/{querypara}','SSM\ProductListMaturedWithinAnytimeController@exportpdf');

            //Product List Matured Today
            Route::get('productlistmaturedtoday_info','SSM\ProductListMaturedTodayController@index');
            Route::get('batchget6','SSM\ProductListMaturedTodayController@getvalues');
            Route::post('displayresult6','SSM\ProductListMaturedTodayController@displayrecord');
            Route::get('exportexcel7/{querypara}','SSM\ProductListMaturedTodayController@exportexcel');
            Route::get('exportpdf7/{querypara}','SSM\ProductListMaturedTodayController@exportpdf');

        });
        Route::group(['prefix'=>'result'],function (){
            // Daily Machine Run Status
            Route::get('dailymachinerunstatus_info','SSM\DailyMachineRunStatusController@index');
            Route::get('batchget7','SSM\DailyMachineRunStatusController@getvalues');
            Route::post('displayresult7','SSM\DailyMachineRunStatusController@displayrecord');
            Route::get('exportexcel8/{querypara}','SSM\DailyMachineRunStatusController@exportexcel');
            Route::get('exportpdf8/{querypara}','SSM\DailyMachineRunStatusController@exportpdf');

             //Summary of Stability Monitoring Data for PQR_24M1
            Route::get('stabilitymonitoringdata_info','SSM\StabilityMonitoringData24M1Controller@index');
            Route::get('batchget8','SSM\StabilityMonitoringData24M1Controller@getvalues');
            Route::post('displayresult8','SSM\StabilityMonitoringData24M1Controller@displayrecord');
            Route::get('exportexcel9/{querypara}','SSM\StabilityMonitoringData24M1Controller@exportexcel');
            Route::get('exportpdf9/{querypara}','SSM\StabilityMonitoringData24M1Controller@exportpdf');


            //Summary of Stability Monitoring Data for PQR_24M2
            Route::get('stabilitymonitoringdata24M2_info','SSM\StabilityMonitoringData24M2Controller@index');
            Route::get('batchget9','SSM\StabilityMonitoringData24M2Controller@getvalues');
            Route::post('displayresult9','SSM\StabilityMonitoringData24M2Controller@displayrecord');
            Route::get('exportexcel10/{querypara}','SSM\StabilityMonitoringData24M2Controller@exportexcel');
            Route::get('exportpdf10/{querypara}','SSM\StabilityMonitoringData24M2Controller@exportpdf');


            //Summary of Stability Monitoring Data for PQR_24M3
            Route::get('stabilitymonitoringdata24M3_info','SSM\StabilityMonitoringData24M3Controller@index');
            Route::get('batchget10','SSM\StabilityMonitoringData24M3Controller@getvalues');
            Route::post('displayresult10','SSM\StabilityMonitoringData24M3Controller@displayrecord');
            Route::get('exportexcel11/{querypara}','SSM\StabilityMonitoringData24M3Controller@exportexcel');
            Route::get('exportpdf11/{querypara}','SSM\StabilityMonitoringData24M3Controller@exportpdf');

            //Summary of Stability Monitoring Data for PQR_36M1
            Route::get('stabilitymonitoringdata36M1_info','SSM\StabilityMonitoringData36M1Controller@index');
            Route::get('batchget11','SSM\StabilityMonitoringData36M1Controller@getvalues');
            Route::post('displayresult11','SSM\StabilityMonitoringData36M1Controller@displayrecord');
            Route::get('exportexcel12/{querypara}','SSM\StabilityMonitoringData36M1Controller@exportexcel');
            Route::get('exportpdf12/{querypara}','SSM\StabilityMonitoringData36M1Controller@exportpdf');

            //Summary of Stability Monitoring Data for PQR_36M2
            Route::get('stabilitymonitoringdata36M2_info','SSM\StabilityMonitoringData36M2Controller@index');
            Route::get('batchget12','SSM\StabilityMonitoringData36M2Controller@getvalues');
            Route::post('displayresult12','SSM\StabilityMonitoringData36M2Controller@displayrecord');
            Route::get('exportexcel13/{querypara}','SSM\StabilityMonitoringData36M2Controller@exportexcel');
            Route::get('exportpdf13/{querypara}','SSM\StabilityMonitoringData36M2Controller@exportpdf');

            //Summary of Stability Monitoring Data for PQR_48M1
            Route::get('stabilitymonitoringdata48M1_info','SSM\StabilityMonitoringData48M1Controller@index');
            Route::get('batchget13','SSM\StabilityMonitoringData48M1Controller@getvalues');
            Route::post('displayresult13','SSM\StabilityMonitoringData48M1Controller@displayrecord');
            Route::get('exportexcel14/{querypara}','SSM\StabilityMonitoringData48M1Controller@exportexcel');
            Route::get('exportpdf14/{querypara}','SSM\StabilityMonitoringData48M1Controller@exportpdf');

            //Summary of Stability Monitoring Data for PQR_48M2
            Route::get('stabilitymonitoringdata48M2_info','SSM\StabilityMonitoringData48M2Controller@index');
            Route::get('batchget14','SSM\StabilityMonitoringData48M2Controller@getvalues');
            Route::post('displayresult14','SSM\StabilityMonitoringData48M2Controller@displayrecord');
            Route::get('exportexcel15/{querypara}','SSM\StabilityMonitoringData48M2Controller@exportexcel');
            Route::get('exportpdf15/{querypara}','SSM\StabilityMonitoringData48M2Controller@exportpdf');

            //Summary of Stability Monitoring Data for PQR_60M1
            Route::get('stabilitymonitoringdata60M1_info','SSM\StabilityMonitoringData60M1Controller@index');
            Route::get('batchget15','SSM\StabilityMonitoringData60M1Controller@getvalues');
            Route::post('displayresult15','SSM\StabilityMonitoringData60M1Controller@displayrecord');
            Route::get('exportexcel16/{querypara}','SSM\StabilityMonitoringData60M1Controller@exportexcel');
            Route::get('exportpdf16/{querypara}','SSM\StabilityMonitoringData60M1Controller@exportpdf');

            //Summary of Stability Monitoring Data for PQR_60M2
            Route::get('stabilitymonitoringdata60M2_info','SSM\StabilityMonitoringData60M2Controller@index');
            Route::get('batchget16','SSM\StabilityMonitoringData60M2Controller@getvalues');
            Route::post('displayresult16','SSM\StabilityMonitoringData60M2Controller@displayrecord');
            Route::get('exportexcel17/{querypara}','SSM\StabilityMonitoringData60M2Controller@exportexcel');
            Route::get('exportpdf17/{querypara}','SSM\StabilityMonitoringData60M2Controller@exportpdf');
             //Summary of Stability Monitoring Data for PD Batch_01
            Route::get('stabilitymonitoringdatapdbatch01_info','SSM\StabilityMonitoringDataPDBatch01Controller@index');
            Route::get('batchget17','SSM\StabilityMonitoringDataPDBatch01Controller@getvalues');
            Route::post('displayresult17','SSM\StabilityMonitoringDataPDBatch01Controller@displayrecord');
            Route::get('exportexcel18/{querypara}','SSM\StabilityMonitoringDataPDBatch01Controller@exportexcel');
            Route::get('exportpdf18/{querypara}','SSM\StabilityMonitoringDataPDBatch01Controller@exportpdf');


            //Summary of Stability Monitoring Data for PD Batch_02
            Route::get('stabilitymonitoringdatapdbatch02_info','SSM\StabilityMonitoringDataPDBatch02Controller@index');
            Route::get('batchget18','SSM\StabilityMonitoringDataPDBatch02Controller@getvalues');
            Route::post('displayresult18','SSM\StabilityMonitoringDataPDBatch02Controller@displayrecord');
            Route::get('exportexcel19/{querypara}','SSM\StabilityMonitoringDataPDBatch02Controller@exportexcel');
            Route::get('exportpdf19/{querypara}','SSM\StabilityMonitoringDataPDBatch02Controller@exportpdf');


            //Summary of Stability Monitoring Data for PD Batch_03
            Route::get('stabilitymonitoringdatapdbatch03_info','SSM\StabilityMonitoringDataPDBatch03Controller@index');
            Route::get('batchget19','SSM\StabilityMonitoringDataPDBatch03Controller@getvalues');
            Route::post('displayresult19','SSM\StabilityMonitoringDataPDBatch03Controller@displayrecord');
            Route::get('exportexcel20/{querypara}','SSM\StabilityMonitoringDataPDBatch03Controller@exportexcel');
            Route::get('exportpdf20/{querypara}','SSM\StabilityMonitoringDataPDBatch03Controller@exportpdf');


            //Summary of Stability Monitoring Data for PD Batch_04
            Route::get('stabilitymonitoringdatapdbatch04_info','SSM\StabilityMonitoringDataPDBatch04Controller@index');
            Route::get('batchget20','SSM\StabilityMonitoringDataPDBatch04Controller@getvalues');
            Route::post('displayresult20','SSM\StabilityMonitoringDataPDBatch04Controller@displayrecord');
            Route::get('exportexcel21/{querypara}','SSM\StabilityMonitoringDataPDBatch04Controller@exportexcel');
            Route::get('exportpdf21/{querypara}','SSM\StabilityMonitoringDataPDBatch04Controller@exportpdf');

            //Summary of Stability Monitoring Data for PD Batch_05
            Route::get('stabilitymonitoringdatapdbatch05_info','SSM\StabilityMonitoringDataPDBatch05Controller@index');
            Route::get('batchget21','SSM\StabilityMonitoringDataPDBatch05Controller@getvalues');
            Route::post('displayresult21','SSM\StabilityMonitoringDataPDBatch05Controller@displayrecord');
            Route::get('exportexcel22/{querypara}','SSM\StabilityMonitoringDataPDBatch05Controller@exportexcel');
            Route::get('exportpdf22/{querypara}','SSM\StabilityMonitoringDataPDBatch05Controller@exportpdf');


            //Summary of Stability Monitoring Data Export Country_01
            Route::get('stabilitymonitoringdataecountry01_info','SSM\StabilityMonitoringDataECountry01Controller@index');
            Route::get('batchget22','SSM\StabilityMonitoringDataECountry01Controller@getvalues');
            Route::post('displayresult22','SSM\StabilityMonitoringDataECountry01Controller@displayrecord');
            Route::get('exportexcel23/{querypara}','SSM\StabilityMonitoringDataECountry01Controller@exportexcel');
            Route::get('exportpdf23/{querypara}','SSM\StabilityMonitoringDataECountry01Controller@exportpdf');


            //Summary of Stability Monitoring Data Export Country_02
            Route::get('stabilitymonitoringdataecountry02_info','SSM\StabilityMonitoringDataECountry02Controller@index');
            Route::get('batchget23','SSM\StabilityMonitoringDataECountry02Controller@getvalues');
            Route::post('displayresult23','SSM\StabilityMonitoringDataECountry02Controller@displayrecord');
            Route::get('exportexcel24/{querypara}','SSM\StabilityMonitoringDataECountry02Controller@exportexcel');
            Route::get('exportpdf24/{querypara}','SSM\StabilityMonitoringDataECountry02Controller@exportpdf');


            //Summary of Stability Monitoring Data Export Country_03
            Route::get('stabilitymonitoringdataecountry03_info','SSM\StabilityMonitoringDataECountry03Controller@index');
            Route::get('batchget24','SSM\StabilityMonitoringDataECountry03Controller@getvalues');
            Route::post('displayresult24','SSM\StabilityMonitoringDataECountry03Controller@displayrecord');
            Route::get('exportexcel25/{querypara}','SSM\StabilityMonitoringDataECountry03Controller@exportexcel');
            Route::get('exportpdf25/{querypara}','SSM\StabilityMonitoringDataECountry03Controller@exportpdf');


              //Summary of Stability Monitoring Data Export Country_04
            Route::get('stabilitymonitoringdataecountry04_info','SSM\StabilityMonitoringDataECountry04Controller@index');
            Route::get('batchget25','SSM\StabilityMonitoringDataECountry04Controller@getvalues');
            Route::post('displayresult25','SSM\StabilityMonitoringDataECountry04Controller@displayrecord');
            Route::get('exportexcel26/{querypara}','SSM\StabilityMonitoringDataECountry04Controller@exportexcel');
            Route::get('exportpdf26/{querypara}','SSM\StabilityMonitoringDataECountry04Controller@exportpdf');


            //Summary of Stability Monitoring Data Export Country_05
            Route::get('stabilitymonitoringdataecountry05_info','SSM\StabilityMonitoringDataECountry05Controller@index');
            Route::get('batchget26','SSM\StabilityMonitoringDataECountry05Controller@getvalues');
            Route::post('displayresult26','SSM\StabilityMonitoringDataECountry05Controller@displayrecord');
            Route::get('exportexcel27/{querypara}','SSM\StabilityMonitoringDataECountry05Controller@exportexcel');
            Route::get('exportpdf27/{querypara}','SSM\StabilityMonitoringDataECountry05Controller@exportpdf');

        });
    });
});


//Talent Development
Route::group(['prefix' => 'talent_development', 'middleware' => ['auth', 'recheck']], function () {
    Route::get('user_guidelines', 'TDS\TalentDevelopmentFormController@user_guidelines');
    Route::get('tds_form/{empId?}', 'TDS\TalentDevelopmentFormController@index');

    //get successors Info
    Route::get('get_successrors_info', 'TDS\TalentDevelopmentFormController@getSuccessorsInfo');
    Route::get('getOtherEmpNamePosition', 'TDS\TalentDevelopmentFormController@getOtherEmpNamePosition');

    //submit form data
    Route::post('tds_post_data', 'TDS\TalentDevelopmentFormController@saveTdsInformation');
    Route::post('tds_put_data', 'TDS\TalentDevelopmentFormController@updateTdsInformation');
    Route::get('EmpInfoPdf/{emp_id?}', 'TDS\TalentDevelopmentFormController@employeeInfopdf');

    Route::post('employeeTdpdf','TDS\TalentDevelopmentFormController@employeeTdPDF')->name('employeeTdpdf');
    Route::get('getGroupText','TDS\TalentDevelopmentFormController@getGroupText')->name('getGroupText');
    Route::get('getPotentialText','TDS\TalentDevelopmentFormController@getPotentialText')->name('getPotentialText');

    //TDS Manager
    Route::get('tds_manager_form', 'TDS\TalentDevelopmentFormController@tds_manager_form');

    /*Send Email*/
    Route::post('send_email', 'TDS\TalentDevelopmentFormController@send_email_to_manager');
    Route::post('send_finish_email', 'TDS\TalentDevelopmentFormController@send_finish_email');
});



//Recruitment Management System Starts

Route::group(['prefix' => 'rms', 'middleware' => ['auth', 'recheck']], function () {

     //Dept Wise Vacant
    Route::get('dept_wise_vacant_view', 'rms\DeptWiseVacantController@index');
    Route::post('dwv_save_record', 'rms\DeptWiseVacantController@dwv_save_record');
    Route::post('search_vacant_id', 'rms\DeptWiseVacantController@search_vacant_id');
    Route::post('dwv_update_record', 'rms\DeptWiseVacantController@dwv_update_record');
    Route::post('dwv_get_dept_info_2', 'rms\DeptWiseVacantController@dwv_get_dept_info_2');
    Route::post('search_get_vacant_id', 'rms\DeptWiseVacantController@search_get_vacant_id');

    //Dept Wise Recruitment
    Route::get('dept_wise_recruitment_view', 'rms\DeptWiseRecruitmentController@index');
    Route::post('search_rec_id', 'rms\DeptWiseRecruitmentController@search_rec_id');
    Route::post('dept_info', 'rms\DeptWiseRecruitmentController@dept_info');
    Route::post('section_info', 'rms\DeptWiseRecruitmentController@section_info');
    Route::post('position_info', 'rms\DeptWiseRecruitmentController@position_info');
    Route::post('save_record', 'rms\DeptWiseRecruitmentController@save_record');
    Route::post('update_record', 'rms\DeptWiseRecruitmentController@update_record');
    Route::post('dwr_get_dept_info_2', 'rms\DeptWiseRecruitmentController@dwr_get_dept_info_2');
    Route::post('search_get_rec_id', 'rms\DeptWiseRecruitmentController@search_get_rec_id');


     //Dept Wise CV Sorting
    Route::get('dept_wise_cv_sorting_view', 'rms\DeptWiseCVSortingController@index');
    Route::post('search_nid', 'rms\DeptWiseCVSortingController@search_nid');
    Route::post('cr_save_record', 'rms\DeptWiseCVSortingController@save_record');
    Route::post('cr_update_record', 'rms\DeptWiseCVSortingController@update_record');
    Route::post('get_subject', 'rms\DeptWiseCVSortingController@get_subject');
    Route::post('dwcs_search_dept_info', 'rms\DeptWiseCVSortingController@dwcs_search_dept_info');
    Route::post('dwcs_search_rec_id', 'rms\DeptWiseCVSortingController@dwcs_search_rec_id');
    Route::post('dwcs_search_n_id', 'rms\DeptWiseCVSortingController@dwcs_search_n_id');
    Route::post('upload_bulk_data','rms\DeptWiseCVSortingController@upload_records');

    //Candidates Exam Records
    Route::get('candidates_exam_records_view', 'rms\CandidatesExamRecordsController@index');
    Route::post('cer_search_nid', 'rms\CandidatesExamRecordsController@search_nid');
    Route::post('search_result', 'rms\CandidatesExamRecordsController@search_result');
    Route::post('update_search_result', 'rms\CandidatesExamRecordsController@update_search_result');
    Route::post('written_exam_points', 'rms\CandidatesExamRecordsController@written_exam_points');
    Route::post('first_interview_point', 'rms\CandidatesExamRecordsController@first_interview_points');
    Route::post('final_interview_points', 'rms\CandidatesExamRecordsController@final_interview_points');
    Route::post('salary_matrix', 'rms\CandidatesExamRecordsController@salary_matrix');
    Route::post('cer_save_record', 'rms\CandidatesExamRecordsController@cer_save_record');
    Route::post('cer_update_record', 'rms\CandidatesExamRecordsController@cer_update_record');

    Route::post('cer_search_dept_info', 'rms\CandidatesExamRecordsController@cer_search_dept_info');
    Route::post('cer_search_rec_id', 'rms\CandidatesExamRecordsController@cer_search_rec_id');


    //Job Offer and Appointment Letter Issue
    Route::get('job_appointment_letter_view', 'rms\JobAppointmentLetterController@index');
    Route::post('joali_search_nid', 'rms\JobAppointmentLetterController@search_nid');
    Route::post('joali_get_rid', 'rms\JobAppointmentLetterController@get_rid');
    Route::post('joali_search_nid_update', 'rms\JobAppointmentLetterController@search_nid_update');
    Route::post('joali_save_record', 'rms\JobAppointmentLetterController@save_record');
    Route::post('joali_update_record', 'rms\JobAppointmentLetterController@update_record');
    Route::post('joali_update_search', 'rms\JobAppointmentLetterController@update_search');

    
    Route::post('jal_search_dept_info', 'rms\JobAppointmentLetterController@jal_search_dept_info');
    Route::post('jal_search_rec_id', 'rms\JobAppointmentLetterController@jal_search_rec_id');
    Route::post('jal_search_nid', 'rms\JobAppointmentLetterController@jal_search_nid');

    //Dept Wise Recruitment Complete
    Route::get('recruitment_confirmation_view', 'rms\RecruitmentConfirmationController@index');
    Route::post('search_result_recruitment', 'rms\RecruitmentConfirmationController@search_result_recruitment');
    Route::post('complete_recruitment', 'rms\RecruitmentConfirmationController@complete_recruitment');
    
    //Candidate Status For Appointment #>Masroor
    //insert
    Route::get('candidateAppointmentStatus', 'rms\CandidateStatusForAppointmentController@index');
    Route::post('csfGetDeptInfo', 'rms\CandidateStatusForAppointmentController@csfGetDeptInfo');
    Route::post('csf_search_get_rec_id', 'rms\CandidateStatusForAppointmentController@csf_search_get_rec_id');
    Route::post('csf_search1_get_rec_id', 'rms\CandidateStatusForAppointmentController@csf_search1_get_rec_id');
    Route::post('csf_source_reference', 'rms\CandidateStatusForAppointmentController@csf_source_reference');
    Route::post('csf_nid', 'rms\CandidateStatusForAppointmentController@csf_nid');
    Route::post('getDataForInsert', 'rms\CandidateStatusForAppointmentController@getDataForInsert');
    
    Route::post('subDataForInsert', 'rms\CandidateStatusForAppointmentController@subDataForInsert');
    Route::post('getDataForUpdate', 'rms\CandidateStatusForAppointmentController@getDataForUpdate');
    //update
    Route::post('csf_post_cas_data','rms\CandidateStatusForAppointmentController@csf_post_cas_data');

    Route::group(['prefix'=>'report'],function (){
        //Dept Wise Recruitment Report
        Route::get('dept_wise_recruitment_report', 'rms\DeptWiseRecruitmentReportController@index');
        Route::post('get_dept_info', 'rms\DeptWiseRecruitmentReportController@get_dept_info');
        Route::post('get_section_info', 'rms\DeptWiseRecruitmentReportController@get_section_info');
        Route::post('get_data_recruitment_report', 'rms\DeptWiseRecruitmentReportController@get_data_recruitment_report');

        //Dept Wise Vacant Report
        Route::get('dept_wise_vacant_report', 'rms\DeptWiseVacantReportController@index');
        Route::post('dwv_get_dept_info', 'rms\DeptWiseVacantReportController@dwv_get_dept_info');
        Route::post('dwv_get_section_info', 'rms\DeptWiseVacantReportController@dwv_get_section_info');
        Route::post('dwv_get_vacant_info', 'rms\DeptWiseVacantReportController@dwv_get_vacant_info');
        Route::post('dwv_get_data_vacant_report', 'rms\DeptWiseVacantReportController@dwv_get_data_vacant_report');

        //Dept Wise Vacant Status
        Route::get('dept_wise_vacant_status', 'rms\DeptWiseVacantStatusController@index');
        Route::post('get_dept_name', 'rms\DeptWiseVacantStatusController@get_dept_name');

        //Final CV Sorting List
        Route::get('cv_sorting_report', 'rms\CVSortingReportController@index');
        Route::post('get_sorting_data_report', 'rms\CVSortingReportController@get_sorting_data_report');

        //Written Interview Result
        Route::get('written_interview_result_report', 'rms\WrittenInterviewResultReportController@index');
        Route::post('wir_get_dept_info', 'rms\WrittenInterviewResultReportController@get_dept_info');
        Route::post('wir_get_section_info', 'rms\WrittenInterviewResultReportController@get_section_info');
        Route::post('wir_get_n_id', 'rms\WrittenInterviewResultReportController@get_n_id');
        Route::post('get_data_exam_record', 'rms\WrittenInterviewResultReportController@get_data_exam_record');

        
    });

   
});


//Recruitment Management System Ends

//Short product portal
Route::group(['prefix' => 'sp_portal', 'middleware' => ['auth', 'recheck']], function () {
    //upload short products
    Route::get('shortProducts','ShortProductUploadController@index');
    Route::post('uploadShortProduct','ShortProductUploadController@uploadDataFromExcel');
    Route::post('getShortProductsData','ShortProductUploadController@getShortProductsData');
    Route::get('monthWiseReport', 'ShortProductUploadController@getMonthWiseReport');
    Route::post('getReport','ShortProductUploadController@getReport');
    Route::get('yearlyMonthSummaryReport', 'ShortProductUploadController@yearlyMonthSummaryReport');
    Route::post('getYearlyMonthReport', 'ShortProductUploadController@getYearlyMonthReport');
});
Route::group(['prefix' => 'sp_portal', 'middleware' => ['headerSet']], function () {
    Route::get('downloadFile', 'ShortProductUploadController@downloadFile');
});

//stationery management system starts
Route::group(['prefix' => 'stationery', 'middleware' => ['auth', 'recheck']], function () {
    Route::group(['prefix' => 'item', 'middleware' => ['auth', 'recheck']], function () {
        Route::get('category', 'Stationery\ItemController@index');
        Route::post('getCategory', 'Stationery\ItemController@getCategory');
        Route::post('editICategory', 'Stationery\ItemController@editICategory');
        Route::post('deleteICategory', 'Stationery\ItemController@deleteICategory');
        Route::post('deleteItypeSubtype', 'Stationery\ItemController@deleteItypeSubtype');
        Route::post('deleteItem', 'Stationery\ItemController@deleteItem');
        Route::post('createIcategory', 'Stationery\ItemController@createIcategory');
        Route::get('itemTypes', 'Stationery\ItemController@itemTypes');
        Route::post('getISTnames', 'Stationery\ItemController@getISTnames');
        Route::post('getItemNames', 'Stationery\ItemController@getItemNames');
        Route::post('getTypeSubtypeData', 'Stationery\ItemController@getTypeSubtypeData');
        Route::post('editTypeSubtypeData', 'Stationery\ItemController@editTypeSubtypeData');
        Route::post('editItemData', 'Stationery\ItemController@editItemData');
        Route::post('createItype', 'Stationery\ItemController@createItype');
        Route::post('createISubtype', 'Stationery\ItemController@createISubtype');
        Route::post('createItem', 'Stationery\ItemController@createItem');
        Route::get('items', 'Stationery\ItemController@getItems');
        Route::post('getItemReport', 'Stationery\ItemController@getItemReport');

    });

    Route::group(['prefix' => 'form', 'middleware' => ['auth', 'recheck']], function () {

        Route::get('openingStock', 'Stationery\ItemController@openingStock');
        Route::post('insertStockData', 'Stationery\ItemController@insertStockData');
        Route::post('uploadStockData', 'Stationery\ItemController@uploadStockData');
        Route::post('getItemGL', 'Stationery\ItemController@getItemGL');
        Route::get('receive', 'Stationery\ItemReceiveController@index');
        Route::post('getItemRequisitions', 'Stationery\ItemReceiveController@getItemRequisitions');
        Route::post('updateReceivedItems', 'Stationery\ItemReceiveController@updateReceivedItems');
        Route::post('updateReceivedItem', 'Stationery\ItemReceiveController@updateReceivedItem');
        Route::get('transferReceive', 'Stationery\ItemTransferReceiveController@index');
        Route::post('getItemTransfers', 'Stationery\ItemTransferReceiveController@getItemTransfers');
        Route::post('updateTransferReceivedItems', 'Stationery\ItemTransferReceiveController@updateTransferReceivedItems');

        
        Route::get('itemDestruction', 'Stationery\ItemDestructionController@index');
        Route::post('insertDestructionData', 'Stationery\ItemDestructionController@insertDestructionData');
        Route::post('getItemDestReport', 'Stationery\ItemDestructionController@getItemDestReport');
        Route::post('editDestructionData', 'Stationery\ItemDestructionController@editDestructionData');
        Route::post('deleteDestructionData', 'Stationery\ItemDestructionController@deleteDestructionData');
        
       
        /*Item sales*/
        Route::get('itemSales', 'Stationery\ItemSalesController@index');
        Route::post('insertSalesData', 'Stationery\ItemSalesController@insertSalesData');
        Route::post('getItemSalesReport', 'Stationery\ItemSalesController@getItemSalesReport');
        Route::post('editSalesData', 'Stationery\ItemSalesController@editSalesData');
        Route::post('deleteSalesData', 'Stationery\ItemSalesController@deleteSalesData');
        Route::get('getCcList', 'Stationery\ItemSalesController@getCcList');

        Route::group(['prefix' => 'issueItem', 'middleware' => ['auth', 'recheck']], function () {
            /*Issue Item Starts*/
            Route::get('itemIssue', 'Stationery\ItemReqController@issueItem');
            Route::get('displayIssueItem', 'Stationery\ItemReqController@displayIssueItem');
            Route::post('createIssue', 'Stationery\ItemReqController@createIssue');
            Route::get('my_issues', 'Stationery\ItemReqController@showMyIssue');
            Route::get('get_my_issues', 'Stationery\ItemReqController@getMyIssues');
            Route::post('updateIssuedItem', 'Stationery\ItemReqController@updateIssuedItem');
            Route::post('delete_my_issues', 'Stationery\ItemReqController@deleteMyIssue');
            Route::get('getIssuedItem', 'Stationery\ItemReqController@getIssuedItem');
            Route::post('showIrdata', 'Stationery\ItemReqController@showIrdata');
            Route::post('approveQtyItem', 'Stationery\ItemReqController@approveQtyItem');
            Route::post('issueQtyItem', 'Stationery\ItemReqController@issueQtyItem');
            Route::post('getProductQty', 'Stationery\ItemReqController@getProductQty');
            Route::post('updateIssueImg', 'Stationery\ItemReqController@updateIssueImg');
            Route::post('getItemName', 'Stationery\ItemReqController@getItemName');
            /* Issue Item Ends*/
        });

         /*Item Transfer Starts*/
        Route::group(['prefix' => 'transferItem', 'middleware' => ['auth', 'recheck']], function () {

            Route::get('itemTransfer', 'Stationery\ItemTransferController@transferItem');
            Route::post('itemTransferSubmit', 'Stationery\ItemTransferController@saveTransferItem');
            Route::post('getRecvedItemDetails', 'Stationery\ItemTransferController@getRecvedItemDetails');
            Route::post('itemTransferbyCDM', 'Stationery\ItemTransferController@itemTransferbyCDM');
            Route::post('getIt_no', 'Stationery\ItemTransferController@getIt_no');
            Route::get('getMyTransferedItem', 'Stationery\ItemTransferController@getMyTransferedItem');
            Route::get('displayTransferedData', 'Stationery\ItemTransferController@displayTransferedData');
            Route::post('updateTransferedItem', 'Stationery\ItemTransferController@updateTransferedItem');
            Route::post('deleteTransferItem', 'Stationery\ItemTransferController@deleteTransferItem');
            Route::post('getStockQty', 'Stationery\ItemTransferController@getStockQty');

        });
        /*Item Transfer Ends*/

        /*Cwip id to main id Starts*/
        Route::group(['prefix' => 'cwiptomainid', 'middleware' => ['auth', 'recheck']], function () {

            /*Convert CWIP ID to Main ID*/
            Route::get('cwipIdToMainID', 'Stationery\CwipToMainIdController@cwipIdToMainID');
            Route::post('saveCwipIdToMainId', 'Stationery\CwipToMainIdController@saveCwipIdToMainID');
            Route::post('updateCwipIdToMainId', 'Stationery\CwipToMainIdController@updateCwipIdToMainId');
            Route::Delete('deleteCwipIdToMainId', 'Stationery\CwipToMainIdController@deleteCwipIdToMainId');
            Route::post('showCwipData', 'Stationery\CwipToMainIdController@showCwipData');
            Route::get('showCwipIds', 'Stationery\CwipToMainIdController@getAllCwipNo');
            Route::get('getCwipRelatedData', 'Stationery\CwipToMainIdController@getCwipRelatedData');//get cwip onchange data

        });


     /*Item Repair Starts*/
        Route::group(['prefix' => 'itemRepair', 'middleware' => ['auth', 'recheck']], function () {
            /*Item Repair*/
            Route::get('itemRepair', 'Stationery\ItemRepairController@itemRepair');// Item Repair
            Route::post('getRequisitionData', 'Stationery\ItemRepairController@getRequisitionData');// Item Repair
            Route::post('getvendordata', 'Stationery\ItemRepairController@getvendordata');// Item Repair
            Route::post('saveItemRepair', 'Stationery\ItemRepairController@saveItemRepair');// Item Repair
            Route::get('getRepaireItem', 'Stationery\ItemRepairController@getRepaireItem');// Item Repair
            Route::get('getAllService', 'Stationery\ItemRepairController@getAllService');// Item Repair
            Route::post('updateRepairItem', 'Stationery\ItemRepairController@updateRepairItem');// Item Repair
            Route::delete('deleteRepairdItem', 'Stationery\ItemRepairController@deleteRepairdItem');// Item Repair

        });



        
         /* Challan Receive starts*/
        Route::group(['prefix' => 'chalan', 'middleware' => ['auth', 'recheck']], function () {

            Route::get('createChalan', 'Stationery\ItemController@displayChalan');
            Route::post('saveReceivedChallan', 'Stationery\ItemController@saveReceivedChallan');
            Route::get('getChallanNo', 'Stationery\ItemController@getChallanNo');
            Route::get('getChallanDetails', 'Stationery\ItemController@getChallanDetails');
            Route::post('updateChallanReceive', 'Stationery\ItemController@updateChallanReceive');
            Route::delete('deleteChalanReceive', 'Stationery\ItemController@deleteChalanReceive');
            Route::post('getProductItName', 'Stationery\ItemController@getProductItName');
            Route::post('checkChallanNo', 'Stationery\ChallanRecvController@checkChallanNo');

        });

        
           /* Challan Receive starts*/
        Route::group(['prefix' => 'chalan', 'middleware' => ['auth', 'recheck']], function () {

            Route::get('createChalan', 'Stationery\ChallanRecvController@displayChalan');
            Route::post('saveReceivedChallan', 'Stationery\ChallanRecvController@saveReceivedChallan');
            Route::get('getChallanNo', 'Stationery\ChallanRecvController@getChallanNo');
            Route::get('getChallanDetails', 'Stationery\ChallanRecvController@getChallanDetails');
            Route::post('updateChallanReceive', 'Stationery\ChallanRecvController@updateChallanReceive');
            Route::delete('deleteChalanReceive', 'Stationery\ChallanRecvController@deleteChalanReceive');
            Route::post('getProductItName', 'Stationery\ChallanRecvController@getProductItName');

        });
         /* Item Uses starts*/
        Route::group(['prefix' => 'item_use', 'middleware' => ['auth', 'recheck']], function () {

            Route::get('useIndex', 'Stationery\ItemUsesController@displayItemUses');
            Route::post('saveUseItem', 'Stationery\ItemUsesController@saveUseItem');
            Route::get('getIURNo', 'Stationery\ItemUsesController@getIURNo');
            Route::post('showIurdata', 'Stationery\ItemUsesController@showIurdata');
            Route::post('updateIusedItem', 'Stationery\ItemUsesController@updateIusedItem');
            Route::post('deleteItemUses', 'Stationery\ItemUsesController@deleteItemUses');
        });


    });
    Route::group(['prefix' => 'report', 'middleware' => ['auth', 'recheck']], function () {
        Route::get('stockReport', 'Stationery\ItemController@stockReport');
        Route::post('getStockReport', 'Stationery\ItemController@getStockReport');
        Route::post('updateStockReport', 'Stationery\ItemController@updateStockReport');
        Route::post('deleteStockData', 'Stationery\ItemController@deleteStockData');
        Route::get('item_stock', 'Stationery\StockReportController@index');
        Route::get('getItemStockData', 'Stationery\StockReportController@getItemStockData');
        Route::get('item_stock_ledger', 'Stationery\StockReportController@item_stock_ledger');
        Route::get('getItemStockLedgerData', 'Stationery\StockReportController@getItemStockLedgerData');
         Route::get('item_uses_report', 'Stationery\itemUsesReportController@item_uses_report');
        Route::get('getReceivedItem', 'Stationery\itemUsesReportController@getReceivedItem');
        Route::post('getUsesDetails', 'Stationery\itemUsesReportController@getUsesDetails');
        Route::get('pr_receive_report', 'Stationery\PrReceiveController@index');
        Route::post('getPrReceiveReport', 'Stationery\PrReceiveController@getPrReceiveReport');
        Route::get('item_transfer_report', 'Stationery\ITransferReportController@index');
        Route::post('getItemTransferReport', 'Stationery\ITransferReportController@getItemTransferReport');
        Route::get('trans_rcv_report', 'Stationery\ITransferRcvReportController@index');
        Route::post('getItemTransferRcvReport', 'Stationery\ITransferRcvReportController@getItemTransferRcvReport');
        Route::get('itemDestReport', 'Stationery\itemDestReportController@index');
        Route::post('getItemDestReport', 'Stationery\itemDestReportController@getItemDestReport');
        
        Route::get('reqReport', 'Stationery\itemReqReportController@reqReport');
        Route::post('getItemReqData', 'Stationery\itemReqReportController@getItemReqData');


        //Challan rcv report
        Route::get('challanRcvReport', 'Stationery\ChallanRcvReportController@challanRcvReport');
        Route::post('getCwipData', 'Stationery\ChallanRcvReportController@getCwipData');

        //CWIP to main ID report
        Route::get('cwipToMainIdReport', 'Stationery\CwipToMainIdReportController@cwipToMainIdReport');
        Route::post('getCwipToMainIdData', 'Stationery\CwipToMainIdReportController@getCwipToMainIdData');

        //Item repair report
        Route::get('itemRepairReport', 'Stationery\ItemRepairReportController@itemRepairReport');
        Route::post('getItemRepairData', 'Stationery\ItemRepairReportController@getItemRepairData');

        //stock report
        Route::get('stockReport', 'Stationery\ItemController@stockReport');
        Route::post('getStockReport', 'Stationery\ItemController@getStockReport');

        //Item Sales Report
        Route::get('itemSalesReport', 'Stationery\ItemSalesReportController@itemSalesReport');
        Route::post('getItemSalesReport', 'Stationery\ItemSalesReportController@getItemSalesReport');


        Route::post('gteItemUsesDetails', 'Stationery\itemUsesReportController@gteItemUsesDetails');
        Route::get('item_uses_report_two', 'Stationery\itemUsesReportController@item_uses_report_two');


    });
});


Route::group(['prefix' => 'stationery', 'middleware' => ['headerSet']], function () {
   Route::get('downloadFile', 'Stationery\ItemController@downloadFile');
});
//stationery management system ends

Route::get('upload_brand_sales_data','InstitutionExportSalesController@index');
Route::post('uploadSalesReport','InstitutionExportSalesController@uploadSalesReport');
Route::get('downloadSampleFile', 'InstitutionExportSalesController@downloadSampleFile');
Route::post('getMonthWiseUploadedReport', 'InstitutionExportSalesController@getMonthWiseUploadedReport');

// Depot employees
Route::group(['prefix' => 'depot', 'middleware' => ['auth', 'recheck']], function () {
    Route::get('depotEmpList', 'DepotEmployeeController@index');
    Route::post('saveDepotEmp', 'DepotEmployeeController@saveDepotEmp');
    Route::get('getDepotEmpList', 'DepotEmployeeController@getDepotEmpList');
    Route::post('editDepotEmpInfo', 'DepotEmployeeController@editDepotEmpInfo');
    Route::post('deleteDepotEmpInfo', 'DepotEmployeeController@deleteDepotEmpInfo');
});



/* Item ext starts*/
Route::group(['prefix' => 'employeeExtention', 'middleware' => ['auth', 'recheck']], function () {

    Route::get('viewEmpExt', 'EmployeeExtentionController@displayEmpExt');
    Route::get('getFacManagerData', 'EmployeeExtentionController@getFacManagerData');
    Route::get('getPlants', 'EmployeeExtentionController@getPlants');
    Route::post('getDepts', 'EmployeeExtentionController@getDepts');
    Route::post('getDeptEmpData', 'EmployeeExtentionController@getDeptEmpData');
    Route::post('saveEmployee', 'EmployeeExtentionController@saveEmployee');
    Route::get('getEmpInfo', 'EmployeeExtentionController@getEmpInfo');


    Route::get('getPlant', 'EmployeeExtentionController@getPlant');
    Route::get('getDept', 'EmployeeExtentionController@getDept');
    Route::get('getDeptEmpDatas', 'EmployeeExtentionController@getDeptEmpDatas');
    Route::post('getFacManagerData', 'EmployeeExtentionController@getFacManagerData');


    Route::delete('deleteEmpExtRecord', 'EmployeeExtentionController@deleteEmpExtRecord');

    //update part
    Route::get('getEmployeeByDept', 'EmployeeExtentionController@getEmployeeByDept');
    Route::post('updateEmpExtData', 'EmployeeExtentionController@updateEmpExtData');

    Route::get('viewEmpExtReport', 'EmployeeExtensionReportController@index');
    Route::post('getDeptEmpDatas', 'EmployeeExtensionReportController@getDeptEmpDatas');
    Route::post('getDepts', 'EmployeeExtensionReportController@getDepts');
    Route::post('getPlantData', 'EmployeeExtensionReportController@getPlantData');
    Route::post('getEmpExtReport', 'EmployeeExtensionReportController@getEmpExtReport');
});




/* Visa and Air Ticket  starts*/
Route::group(['prefix' => 'visaAirTicketAndHotelInfoSys', 'middleware' => ['auth', 'recheck']], function () {


    Route::group(['prefix' => 'visaAirTicket', 'middleware' => ['auth', 'recheck']], function () {
        Route::get('viewAirTicket', 'visaAirTicketAndHotelInfo\VisaAndAirTicketController@viewAirTicket');
        Route::get('getEmpInfo', 'visaAirTicketAndHotelInfo\VisaAndAirTicketController@getEmpInfo');
        Route::post('saveAirTicketData', 'visaAirTicketAndHotelInfo\VisaAndAirTicketController@saveAirTicketData');
        Route::post('getDataTableData', 'visaAirTicketAndHotelInfo\VisaAndAirTicketController@getDataTableData');
        Route::post('updateAirTicketData', 'visaAirTicketAndHotelInfo\VisaAndAirTicketController@updateAirTicketData');
        Route::delete('deleteAirTicketData', 'visaAirTicketAndHotelInfo\VisaAndAirTicketController@deleteAirTicketData');

    });


   
    Route::group(['prefix' => 'hotelManagement', 'middleware' => ['auth', 'recheck']], function () {
        Route::get('viewHotelManagement', 'visaAirTicketAndHotelInfo\HotelManagementController@viewHotelManagement');
        Route::post('saveHotelInfoSystem', 'visaAirTicketAndHotelInfo\HotelManagementController@saveHotelInfoSystem');
        Route::post('getDataTableData', 'visaAirTicketAndHotelInfo\HotelManagementController@getDataTableData');
        Route::post('updateHotelManagementData', 'visaAirTicketAndHotelInfo\HotelManagementController@updateHotelManagementData');
        Route::delete('deleteHotelManagementData', 'visaAirTicketAndHotelInfo\HotelManagementController@deleteHotelManagementData');

    });

});



/* Attendance Management System */
Route::group(['prefix' => 'attendenceManagementSys', 'middleware' => ['auth', 'recheck']], function () {

    Route::group(['prefix' => 'attendence', 'middleware' => ['auth', 'recheck']], function () {

        Route::get('viewAttendence', 'Attendence\AttendenceMngController@viewAttendence');
        Route::get('getEmpInfo', 'Attendence\AttendenceMngController@getEmpInfo');
        Route::post('saveAttendence', 'Attendence\AttendenceMngController@saveAttendence');
        Route::get('shiftTradeRequest', 'Attendence\AttendenceMngController@shiftTradeRequest');
        Route::post('getDataDeptWise', 'Attendence\AttendenceMngController@getDataDeptWise');
        Route::get('getAlldata', 'Attendence\AttendenceMngController@getAlldata');
        Route::post('getDisplayInfo', 'Attendence\AttendenceMngController@getDisplayInfo');

        /*get plants dept designation*/
        Route::get('getPlants', 'Attendence\AttendenceMngController@getPlants');
        Route::get('getDepts', 'Attendence\AttendenceMngController@getDepts');
        Route::get('getSections', 'Attendence\AttendenceMngController@getSections');
        Route::get('getWorkCenters', 'Attendence\AttendenceMngController@getWorkCenters');
        Route::get('getEmpType', 'Attendence\AttendenceMngController@getEmpType');
        Route::get('getEmployeeData', 'Attendence\AttendenceMngController@getEmployeeData');
        Route::get('getEmployee', 'Attendence\AttendenceMngController@getEmployee');

    });

});



    Route::group(['prefix' => 'hotelManagement', 'middleware' => ['auth', 'recheck']], function () {
        Route::get('viewHotelManagement', 'visaAirTicketAndHotelInfo\HotelManagementController@viewHotelManagement');
        Route::post('saveHotelInfoSystem', 'visaAirTicketAndHotelInfo\HotelManagementController@saveHotelInfoSystem');
        Route::post('getDataTableData', 'visaAirTicketAndHotelInfo\HotelManagementController@getDataTableData');
        Route::post('updateHotelManagementData', 'visaAirTicketAndHotelInfo\HotelManagementController@updateHotelManagementData');
        Route::delete('deleteHotelManagementData', 'visaAirTicketAndHotelInfo\HotelManagementController@deleteHotelManagementData');

    });



/* Attendence Management System */
Route::group(['prefix' => 'attendenceManagementSys', 'middleware' => ['auth', 'recheck']], function () {

    Route::group(['prefix' => 'attendence', 'middleware' => ['auth', 'recheck']], function () {

        Route::get('viewAttendence', 'Attendence\AttendenceMngController@viewAttendence');
        Route::get('getEmpInfo', 'Attendence\AttendenceMngController@getEmpInfo');
        Route::post('saveAttendence', 'Attendence\AttendenceMngController@saveAttendence');


        Route::get('shiftTradeRequest', 'Attendence\AttendenceMngController@shiftTradeRequest');


        Route::post('getDataDeptWise', 'Attendence\AttendenceMngController@getDataDeptWise');


        Route::get('getAlldata', 'Attendence\AttendenceMngController@getAlldata');

        /*get plants dept designation*/
        Route::get('getPlants', 'Attendence\AttendenceMngController@getPlants');
        Route::get('getDepts', 'Attendence\AttendenceMngController@getDepts');
        Route::get('getSections', 'Attendence\AttendenceMngController@getSections');
        Route::get('getWorkCenters', 'Attendence\AttendenceMngController@getWorkCenters');
        Route::get('getEmpType', 'Attendence\AttendenceMngController@getEmpType');


        Route::get('getEmployeeData', 'Attendence\AttendenceMngController@getEmployeeData');

        Route::get('getEmployee', 'Attendence\AttendenceMngController@getEmployee');


    });


});


//Import Management Portal
Route::group(['prefix' => 'import_management', 'middleware' => ['auth', 'recheck']], function () {
    Route::get('mat_purchase_info', 'ImportManagement\MaterialPurchaseInfoController@index');
    Route::post('saveMaterialData', 'ImportManagement\MaterialPurchaseInfoController@saveMaterialData');
    Route::post('retrieveMatPurchaseInfo', 'ImportManagement\MaterialPurchaseInfoController@retrieveMatPurchaseInfo');
    Route::post('updateMaterialData', 'ImportManagement\MaterialPurchaseInfoController@updateMaterialData');
    Route::get('mat_purchase_report', 'ImportManagement\MaterialPurchaseReportController@index');
    Route::post('getSCMpurchaseMatReport', 'ImportManagement\MaterialPurchaseReportController@getSCMpurchaseMatReport');
    Route::post('updatePIReqSendDate', 'ImportManagement\MaterialPurchaseReportController@updatePIReqSendDate');
    Route::post('updateFinalpireceiveddate', 'ImportManagement\MaterialPurchaseReportController@updateFinalpireceiveddate');
    Route::post('updateReqforopenlcttcaddate', 'ImportManagement\MaterialPurchaseReportController@updateReqforopenlcttcaddate');
    Route::post('updateLcOpenStatus', 'ImportManagement\MaterialPurchaseReportController@updateLcOpenStatus');
    Route::post('updateDraftShipDocRcvDate', 'ImportManagement\MaterialPurchaseReportController@updateDraftShipDocRcvDate');
    Route::post('updateFinalShipDocRcvDate', 'ImportManagement\MaterialPurchaseReportController@updateFinalShipDocRcvDate');
    Route::post('updateSendForEndorsemntDate', 'ImportManagement\MaterialPurchaseReportController@updateSendForEndorsemntDate');
    Route::get('committed_report', 'ImportManagement\CommittedReportController@index');
    Route::post('getCommittedReport', 'ImportManagement\CommittedReportController@getCommittedReport');
    Route::post('getCommittedReport', 'ImportManagement\CommittedReportController@getCommittedReport');
    Route::get('uncommitted_report', 'ImportManagement\UncommittedReportController@index');
    Route::post('getUncommittedReport', 'ImportManagement\UncommittedReportController@getunCommittedReport');
    Route::get('scmDataModification', 'ImportManagement\SCMMasterDataModificationController@index');
    Route::post('getSCMMasterData', 'ImportManagement\SCMMasterDataModificationController@getSCMMasterData');
    Route::post('updateCurrData', 'ImportManagement\SCMMasterDataModificationController@updateCurrData');
    Route::post('deleteCurrData', 'ImportManagement\SCMMasterDataModificationController@deleteCurrData');
    Route::post('addCurrData', 'ImportManagement\SCMMasterDataModificationController@addCurrData');
    Route::post('updateDocTypeData', 'ImportManagement\SCMMasterDataModificationController@updateDocTypeData');
    Route::post('addDocTypeData', 'ImportManagement\SCMMasterDataModificationController@addDocTypeData');
    Route::post('deleteDocTypeData', 'ImportManagement\SCMMasterDataModificationController@deleteDocTypeData');
    Route::post('addConcernPersonData', 'ImportManagement\SCMMasterDataModificationController@addConcernPersonData');
    Route::post('updateConcernPersonData', 'ImportManagement\SCMMasterDataModificationController@updateConcernPersonData');
    Route::post('deleteConcernPersonData', 'ImportManagement\SCMMasterDataModificationController@deleteConcernPersonData');
    Route::post('updateBankData', 'ImportManagement\SCMMasterDataModificationController@updateBankData');
    Route::post('deleteBankData', 'ImportManagement\SCMMasterDataModificationController@deleteBankData');
    Route::post('addBankData', 'ImportManagement\SCMMasterDataModificationController@addBankData');
    Route::post('updateInsuNameData', 'ImportManagement\SCMMasterDataModificationController@updateInsuNameData');
    Route::post('deleteInsuNameData', 'ImportManagement\SCMMasterDataModificationController@deleteInsuNameData');
    Route::post('addInsuNameData', 'ImportManagement\SCMMasterDataModificationController@addInsuNameData');
    Route::post('updateLCTypeData', 'ImportManagement\SCMMasterDataModificationController@updateLCTypeData');
    Route::post('addLCTypeData', 'ImportManagement\SCMMasterDataModificationController@addLCTypeData');
    Route::post('deleteLCTypeData', 'ImportManagement\SCMMasterDataModificationController@deleteLCTypeData');
    Route::post('updateCandFData', 'ImportManagement\SCMMasterDataModificationController@updateCandFData');
    Route::post('deleteCandFData', 'ImportManagement\SCMMasterDataModificationController@deleteCandFData');
    Route::post('addCandFData', 'ImportManagement\SCMMasterDataModificationController@addCandFData');
    Route::get('getLatestPoPrList', 'ImportManagement\MaterialPurchaseInfoController@getLatestPoPrList');

    Route::get('capex_items', 'ImportManagement\CapexItemsController@index');
    Route::get('getCapexSelectItems', 'ImportManagement\CapexItemsController@getCapexSelectItems');
    Route::post('addVendorData', 'ImportManagement\SCMMasterDataModificationController@addVendorData');
    Route::post('getVendorMasterData', 'ImportManagement\SCMMasterDataModificationController@getVendorMasterData');
    Route::post('updateVendorData', 'ImportManagement\SCMMasterDataModificationController@updateVendorData');
    Route::post('deleteVendorData', 'ImportManagement\SCMMasterDataModificationController@deleteVendorData');
    Route::post('addAgentData', 'ImportManagement\SCMMasterDataModificationController@addAgentData');
    Route::post('getAgentMasterData', 'ImportManagement\SCMMasterDataModificationController@getAgentMasterData');
    Route::post('updateAgentData', 'ImportManagement\SCMMasterDataModificationController@updateAgentData');
    Route::post('deleteAgentData', 'ImportManagement\SCMMasterDataModificationController@deleteAgentData');
    Route::post('getAgentInfo', 'ImportManagement\CapexItemsController@getAgentInfo');
    Route::post('saveCapexData', 'ImportManagement\CapexItemsController@saveCapexData');
    Route::post('retrieveCapexInfo', 'ImportManagement\CapexItemsController@retrieveCapexInfo');
    Route::post('updateCapexData', 'ImportManagement\CapexItemsController@updateCapexData');

    Route::get('raw_pack_lab_planning', 'ImportManagement\CapexItemsController@raw_pack_lab_planning');
    Route::post('retrieveRawPackInfo', 'ImportManagement\CapexItemsController@retrieveRawPackInfo');
    Route::post('updateRawPackData', 'ImportManagement\CapexItemsController@updateRawPackData');

    Route::get('lc_management', 'ImportManagement\CapexItemsController@lc_management');
    Route::post('retrieveRawPackInfoForLC', 'ImportManagement\CapexItemsController@retrieveRawPackInfoForLC');
    Route::post('getRawPackInfo', 'ImportManagement\CapexItemsController@getRawPackInfo');
    Route::post('updateLCData', 'ImportManagement\CapexItemsController@updateLCData');

    Route::get('doc_management', 'ImportManagement\CapexItemsController@doc_management');
    Route::post('retrieveAllInfo', 'ImportManagement\CapexItemsController@retrieveAllInfo');
    Route::post('updateDocumentData', 'ImportManagement\CapexItemsController@updateDocumentData');

    Route::get('duty_management', 'ImportManagement\CapexItemsController@duty_management');
    Route::post('updateDutyData', 'ImportManagement\CapexItemsController@updateDutyData');

    Route::get('finance_management', 'ImportManagement\CapexItemsController@finance_management');
    Route::post('getDataForFinance', 'ImportManagement\CapexItemsController@getDataForFinance');
    Route::post('getFinanceInfo', 'ImportManagement\CapexItemsController@getFinanceInfo');
    Route::post('getFinanceMainRowData', 'ImportManagement\CapexItemsController@getFinanceMainRowData');
    Route::post('updateFinanceData', 'ImportManagement\CapexItemsController@updateFinanceData');

    Route::get('capex_report', 'ImportManagement\SCMReportController@capex_report');
    Route::get('finance_report', 'ImportManagement\SCMReportController@finance_report');
    Route::post('retrieveFinanceReport', 'ImportManagement\SCMReportController@retrieveFinanceReport');
});


/*Service Agreement Notification*/
Route::group(['prefix' => 'serviceAgreementNotification', 'middleware' => ['auth', 'recheck']], function () {


        Route::get('viewService', 'serviceAgreement\ServiceAgreementController@viewService');
        Route::post('savePost', 'serviceAgreement\ServiceAgreementController@savePost');
        Route::post('uploadServiceExcelData', 'serviceAgreement\ServiceAgreementController@uploadServiceExcelData');
        Route::post('getDatatableData', 'serviceAgreement\ServiceAgreementController@getDatatableData');
        Route::post('updateServiceData', 'serviceAgreement\ServiceAgreementController@updateServiceData');
        Route::Delete('deleteServiceData', 'serviceAgreement\ServiceAgreementController@deleteServiceData');

});




