@extends('_layout_shared._master')
@section('title','Performance')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>

        table.dataTable tbody th,
        table.dataTable tbody td {
            white-space: nowrap;
            padding: 2px;
        }

        table.dataTable tfoot th {
            padding: 2px;
        }

        table th {
            white-space: nowrap;
            overflow: hidden;
            color: #003399;
            font-size: 10px;
            padding: 2px;
        }

        table td {
            white-space: nowrap;
            overflow: hidden;
            color: #0c0c0c;
            font-size: 10px;
            padding: 2px;
        }

        .table > tbody > tr > td {
            padding: 0px;
        }

        .col-sm-11, .col-sm-4, .col-sm-2 {
            padding-left: 0px;
            padding-right: 0px;
        }

        .col-sm-11, .col-md-4, .col-md-2 {
            padding-left: 0px;
            padding-right: 0px;
        }

        header.panel-heading {
            color: #003399;
        }

        .dataTables_filter {
            display: none;
        }

        .dt-buttons {
            float: right;
        }

        table {
            margin: 0 auto;
            /*width: 100%;*/
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
        / / * * * * * * * * * * * add this word-wrap: break-word;
        / / * * * * * * * * * * * and this
        }

        .month {
            width: 55%;
        }

        .pgr {
            width: 50%;
        }

        .fixed {
            position: fixed;
            z-index: 1;
            top: 50px
        }

        .cmColor {
            background-color: #FDE9D9;
            color: darkblue;
        }

        .hColor {
            background-color: #CCFFCC;
        }

        .dataTables_scroll {
            overflow: auto;
        }

        .my-sticky-element.stuck {
            position: fixed;
            top: 50px;
            /*box-shadow:0 2px 4px rgba(0, 0, 0, .3);*/
        }

        .my-sticky-element {
            z-index: 1;
        }

        #task_flyout {
            top: 50px;
        }

        /*.fontcen{
            class="text-center"
        }*/


        /*//------------------------------aster gyrus*/
        table#team_ast_gyr_5y tbody tr td{
          text-align: center;
          background-color: #CCFFFF;
        }

        table#team_ast_gyr_5y tbody tr td.mon_clss{
          text-align: center;
          background-color: #ffe8d4;
        }


        table#team_ast_gyr_4y tbody tr td{
          text-align: center;
          background-color: #e4ddec;
        }
        table#team_ast_gyr_3y tbody tr td{
          text-align: center;
          background-color: #f9e4d3;
        }

       


        /*...............*/
        table#team_ast_gyr_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_ast_gyr_5y tfoot tr td.mon_clss{
        
          background-color: #ffe8d4;
        }
        table#team_ast_gyr_4y tfoot tr td{
          
          background-color:#ccc0da;
        }
        table#team_ast_gyr_3y tfoot tr td{
      
          background-color:#fcd5b4;
        }


        
   

        /*/---------------------------------------------*/
        
        table#team_opr_xen_5y tbody tr td{
          text-align: center;
          background-color: #CCFFFF;
        }

        table#team_opr_xen_5y tbody tr td.mon_clss{
          text-align: center;
          background-color: #ffe8d4;
        }


        table#team_opr_xen_4y tbody tr td{
          text-align: center;
          background-color: #e4ddec;
        }
        table#team_opr_xen_3y tbody tr td{
          text-align: center;
          background-color: #f9e4d3;
        }



        

         /*...............*/
        table#team_opr_xen_5y tfoot tr td{
        
          background-color: #B7DEE8;
        }

        table#team_opr_xen_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_opr_xen_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_opr_xen_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }

        


        /*/---------------------------------------------*/
    
        table#team_spe_5y tbody tr td{
          text-align: center;
          background-color: #CCFFFF;
        }

        table#team_spe_5y tbody tr td.mon_clss{
          text-align: center;
          background-color:#ffe8d4;
        }

        table#team_spe_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_spe_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

        

         /*...............*/
        table#team_spe_5y tfoot tr td{
        
          background-color: #B7DEE8;
        }

         table#team_spe_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_spe_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_spe_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }

        

        
        /*/---------------------------------------------*/
        /*team_ihhl_mpo_5y*/
         table#team_ihhl_mpo_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }
        table#team_ihhl_mpo_5y tbody tr td.mon_clss{
          text-align: center;
          background-color:#ffe8d4;
        }
        table#team_ihhl_mpo_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_ihhl_mpo_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

        

         /*...............*/
        table#team_ihhl_mpo_5y tfoot tr td{
        
          background-color: #f69d3c;
        }
        table#team_ihhl_mpo_4y tfoot tr td{
          
          background-color: #f69d3c;
        }
        table#team_ihhl_mpo_3y tfoot tr td{
      
          background-color: #f69d3c;
        }

        

        /*/---------------------------------------------*/
        
        /*team_ihhl_tso_5y*/
         table#team_ihhl_tso_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }
        table#team_ihhl_tso_5y tbody tr td.mon_clss{
          text-align: center;
           background-color: #CCFFFF;
        }
        table#team_ihhl_tso_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_ihhl_tso_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

       

        /*...............*/
        table#team_ihhl_tso_5y tfoot tr td{
        
          background-color: #f69d3c;
        }
        table#team_ihhl_tso_4y tfoot tr td{
          
          background-color: #f69d3c;
        }
        table#team_ihhl_tso_3y tfoot tr td{
      
          background-color: #f69d3c;
        }

        

        /*/---------------------Total depot salesss---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

        /*team_ihhl_tso_5y*/
        table#team_tot_depo_sale_5y tbody tr td{
            text-align: center;
            background-color:#e4f7d6;
        }

        table#team_tot_depo_sale_4y tbody tr td{
            text-align: center;
             background-color: #e4f7d6;
        }
        table#team_tot_depo_sale_3y tbody tr td{
            text-align: center;
            background-color: #e4f7d6;
        }


        /*team_ihhl_tso_5y*/
       

        

        table#team_tot_depo_sale_5y tfoot tr td{
        
          background-color:#98cea6;
        }

        /*table#team_tot_depo_sale_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }*/
        table#team_tot_depo_sale_4y tfoot tr td{
          
          background-color: #98cea6;
        }
        table#team_tot_depo_sale_3y tfoot tr td{
      
          background-color: #98cea6;
        }

        .mon_clss{
            font-weight: bold;
        }

        /*/---------------CELLBIOTIC (incl. Human,Vaccine)------------------------------*/
        

        table#team_cellbiotic_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }

        table#team_cellbiotic_5y tbody tr td.mon_clss{
          text-align: center;
           background-color: #ffe8d4;
        }


        table#team_cellbiotic_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_cellbiotic_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

    

        /*......-----------------------------------.........*/
       

        table#team_cellbiotic_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_cellbiotic_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_cellbiotic_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_cellbiotic_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }





        /*/--------------------KINETIX (incl. HOSPICARE ) -------------------------*/


        table#team_kinetix_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }
        table#team_kinetix_5y tbody tr td.mon_clss{
          text-align: center;
          background-color:#ffe8d4;
        }
     
        table#team_kinetix_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_kinetix_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

        


            /*...............*/
       
        table#team_kinetix_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_kinetix_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_kinetix_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_kinetix_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }


         /*/------------------ZYMOS (incl. Herbal & Nutricare)---------------------------*/

        table#team_zymos_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }

        table#team_zymos_5y tbody tr td.mon_clss{
          text-align: center;
          background-color:#ffe8d4;
        }
        table#team_zymos_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_zymos_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }



       
        /*........................................*/
        

        

        table#team_zymos_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_zymos_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_zymos_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_zymos_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }




        /*/-----------------------------------------TOTAL GENERAL---------------------------------------*/
        /*team_totgeneral_5y*/
        table#team_totgeneral_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }
        table#team_totgeneral_5y tbody tr td.mon_clss{
          text-align: center;
          background-color:#ffe8d4;
        }
        table#team_totgeneral_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_totgeneral_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

       

          /*...............*/
        
         table#team_totgeneral_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_totgeneral_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_totgeneral_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_totgeneral_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }


        



        /*/----------------------------------------HYGIENE (Diaper)-------------------------------*/
        /*team_ihhl_mpo_5y*/
         table#team_total_ihhl_5y tbody tr td{
          text-align: center;
           background-color:#CCFFFF;
        }
        table#team_total_ihhl_5y tbody tr td.mon_clss{
          text-align: center;
           background-color: #ffe8d4;
        }
        table#team_total_ihhl_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_total_ihhl_3y tbody tr td{
          text-align: center;
           background-color:#f9e4d3;
        }

        
        /*...............*/
        

        table#team_total_ihhl_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_total_ihhl_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_total_ihhl_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_total_ihhl_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }




        

        /*/------------------------AHVD-------------------------------------------------*/
        
        /*team_ahvd_5y*/
         table#team_ahvd_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }
        table#team_ahvd_5y tbody tr td.mon_clss{
          text-align: center;
           background-color:#ffe8d4;
        }
        table#team_ahvd_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_ahvd_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

        
          /*...............*/
     

        table#team_ahvd_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_ahvd_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_ahvd_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_ahvd_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }


        

        /*/------------------------------IHNL----------------------------------------------------------*/
        /*team_ihnl_5y*/
         table#team_ihnl_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }
        table#team_ihnl_5y tbody tr td.mon_clss{
          text-align: center;
           background-color: #ffe8d4;
        }
        table#team_ihnl_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_ihnl_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

        table#team_ihnl_2y tbody tr td{
          text-align: center;
           background-color: #ffe8d4;
        }

        table#team_ihnl_1y tbody tr td{
          text-align: center;
           background-color: #ffe8d4;
        }


        /*...............*/
        /*table#team_ihnl_5y tfoot tr td{
        
          background-color:#CCFFFF;
        }
        table#team_ihnl_4y tfoot tr td{
          
          background-color: #f69d3c;
        }
        table#team_ihnl_3y tfoot tr td{
      
          background-color: #f69d3c;
        }*/

         table#team_ihnl_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_ihnl_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_ihnl_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_ihnl_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }


        table#team_ihnl_2y tfoot tr td{
   
          background-color: #f69d3c;
        }

        table#team_ihnl_1y tfoot tr td{
     
          background-color: #f69d3c;
        }


        /*//------------IVL-----------------*/
        table#team_ivl_5y tbody tr td{
            text-align: center;
            background-color: #CCFFFF;
        }

        table#team_ivl_5y tbody tr td.mon_clss{
            text-align: center;
            background-color: #ffe8d4;
        }


        table#team_ivl_4y tbody tr td{
            text-align: center;
            background-color: #e4ddec;
        }
        table#team_ivl_3y tbody tr td{
            text-align: center;
            background-color: #f9e4d3;
        }


        /*...............*/
        table#team_ivl_5y tfoot tr td{

            background-color:#B7DEE8;
        }

        table#team_ivl_5y tfoot tr td.mon_clss{

            background-color: #ffe8d4;
        }
        table#team_ivl_4y tfoot tr td{

            background-color:#ccc0da;
        }
        table#team_ivl_3y tfoot tr td{

            background-color:#fcd5b4;
        }


        /*/-------------IVL END--------------*/






        /*/---------------------INSTITUTION------------------------*/
        /*team_inst_5y*/
         table#team_inst_5y tbody tr td{
          text-align: center;
           background-color: #CCFFFF;
        }

        table#team_inst_5y tbody tr td.mon_clss{
          text-align: center;
           background-color:#ffe8d4;
        }
        table#team_inst_4y tbody tr td{
          text-align: center;
           background-color: #e4ddec;
        }
        table#team_inst_3y tbody tr td{
          text-align: center;
           background-color: #f9e4d3;
        }

        
        /*...............*/
        table#team_inst_5y tfoot tr td{
        
          background-color:#B7DEE8;
        }

        table#team_inst_5y tfoot tr td.mon_clss{
        
          background-color:#ffe8d4;
        }
        table#team_inst_4y tfoot tr td{
          
          background-color: #ccc0da;
        }
        table#team_inst_3y tfoot tr td{
      
          background-color: #fcd5b4;
        }

       




        /*.....................................................*/
        table#company_wise_sale_t1 tbody tr td{
          text-align: center;
           /*background-color: #ffe8d4;*/
        }
        table#company_wise_sale_t2 tbody tr td{
          text-align: center;
        }

        table#company_wise_sale_t3 tbody tr td{
            text-align: center;
             /*background-color: #ffe8d4;*/
        }

        .ipl_total_class{
            background-color:rgb(216, 228, 188);
            font-weight:bold;
            /*border-right:1px solid black;*/

        }
        /*.ipl_inst_class{*/
            /*background-color:#c4d79b;*/
        /*}*/
        .total_class{
            background-color:rosybrown;
            font-weight:bold;
            /*border-right:1px solid black;*/
        }

        .ivl_total_class{
            background-color:rgb(234, 200, 173);
            font-weight:bold;
        }

        .ihhl_total_class{
            background-color:rgb(183, 222, 232);
            font-weight:bold;
        }

        .ihnl_total_class{
            background-color:rgb(241, 238, 164);
            font-weight:bold;

        }

        .month_class{
            font-weight:bold;
        }

        .month_class_summary{
             font-weight:bold;
             background-color:#8db4e2;
        }


        /*/---------------------------------------------*/

        /*.paneltest1 .wrtest {
            display:flex;
        }
        .paneltest1 .wrcol {
            flex:1;
        }*/
        /*$('.paneltest1 .wrcol').height($('.paneltest1 .wrtest').height());*/
        /*$(".paneltest1 .wrtest").height($(".paneltest1 .wrcol").height());*/


        /*/------------28.10.2018------------*/
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #d2cfcf;
}
        /*//10.4.2019*/
        .wrapper {
            padding-top: 0px;
        }
        .panel{
            margin-bottom: 0px;
        }
        .panel-body{
            padding: 1px;
        }
        .panel-heading{
            padding-bottom: 0px;
            border-bottom: none;
            padding-top: 0px;
        }
        footer{
            padding:5px;
        }

        /*.panel-heading {*/
           /**/
        /*}*/

    </style>
@endsection

@section('right-content')

    <div class="row">

        <div>
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <div style="float:left;" class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                            Team Wise PERFORMANCE  &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp
                            Figures in <span style="color:green">Crore</span> &nbsp &nbsp &nbsp<span style="color:blue">BDT</span></label>

                        </div>
                        <br>
                    </header>
                </section>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="task_flyout" class="my-sticky-element">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <div>
                            <div class="col-sm-1 col-md-1">
                                <table class="display table table-condensed table-bordered table-striped table-responsive">
                                    <tr>

                                    <tr style="height:9%">
                                        <td  style="background-color:#fde9d9;color:#8f34ff" class="text-center">Team</td>
                                    </tr>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-11 col-md-11">
                                <div class="col-sm-4 col-md-4">
                                    <table class="display table  table-bordered table-striped table-responsive">
                                        <tr>
                                        <tr>
                                            <td class="text-center" style="background-color:#f7c9a2">Year</td>
                                            <td colspan="3" style="background-color:#B7DEE8" class="text-center">
                                            <!-- {{ date('Y')}} -->
                                            {{$result->sales_year}}
                                          </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#ffe8d4;color:#0066ff" class="text-center">Month</td>
                                            <td style="background-color:#CCFFFF;color:#0066ff" class="text-center">Target</td>
                                            <td style="background-color:#CCFFFF;color:#0066ff" class="text-center">Actual Sales</td>
                                            <td style="background-color:#CCFFFF;color:#0066ff" class="text-center">Achv%</td>
                                        </tr>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                    <table class="display table table-bordered table-striped table-responsive">
                                        <tr>
                                        <tr>
                                            <td colspan="4" style="background-color:#ccc0da" class="text-center">
                                            <!-- {{ date('Y') -1}} -->
                                            {{$result->sales_year-1}}
                                          </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#e4ddec;color:#0066ff" class="text-center">Target</td>
                                            <td style="background-color:#e4ddec;color:#0066ff" colspan="2" class="text-center">Actual Sales</td>
                                            <td style="background-color:#e4ddec;color:#0066ff" class="text-center">Achv%</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                    <table class="display table table-bordered table-striped table-responsive">
                                        <tr>
                                        <tr>
                                            <td style="background-color:#fcd5b4" colspan="4" class="text-center">
                                            <!-- {{ date('Y') -2}} -->
                                            {{$result->sales_year-2}}

                                          </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#f9e4d3;color:#0066ff" class="text-center">Target</td>
                                            <td style="background-color:#f9e4d3;color:#0066ff" colspan="2" class="text-center">Actual Sales</td>
                                            <td style="background-color:#f9e4d3;color:#0066ff" class="text-center">Achv%</td>
                                        </tr>
                                    </table>
                                </div>


                            </div>

                        </div>
                        <br>
                        <br>
                    </header>
                </section>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>

    <div id="main_content">

        {{--ast_gyr--}}

        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel paneltest1" id="data_table">

                        <div class="panel-body">
                            <div class="wrtest">
                                <div class="wrcol col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                        <tr></tr>
                                            <tr>
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>ASTER<br>-GYRUS</b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="wrcol col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_ast_gyr_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                     <td class="aster_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="aster_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="aster_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ast_gyr_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                             <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="aster_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="aster_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="aster_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ast_gyr_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="aster_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="aster_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="aster_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                            </div>

                            </div>

                            </div>

                    </section>
                </div>
            </div>
        </div>

        {{--opr xen--}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>OPE-XEN
                                                        <br> (incl. <br> Hormone)</b></td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_opr_xen_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ope-zen_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ope-zen_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ope-zen_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_opr_xen_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ope-zen_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ope-zen_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ope-zen_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_opr_xen_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ope-zen_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ope-zen_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ope-zen_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                            <!-- <br>
                            <br> -->
                            </div>
                        <!-- </header> -->
                    </section>
                </div>
            </div>
        </div>

        {{--TOTAL SPECIAL --}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>TOTAL <br>SPECIAL</b></td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_spe_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="totspecial_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totspecial_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totspecial_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_spe_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                             <tbody>
                                        </tbody>
                                        <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="totspecial_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totspecial_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totspecial_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_spe_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                             <tbody>
                                        </tbody>
                                        <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="totspecial_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totspecial_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totspecial_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>


                                </div>

                            </div>
                            <!-- <br>
                            <br> -->
                        </div>
                    </section>
                </div>
            </div>
        </div>

        {{--CELLBIOTIC --}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>CELL<br>-BIOTIC<br> (incl. <br>Human,<br> Vaccine)</b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_cellbiotic_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody></tbody>
                                             <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="cell_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="cell_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="cell_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_cellbiotic_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                             <tbody>
                                        </tbody>
                                        <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="cell_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="cell_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="cell_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_cellbiotic_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                             <tbody>
                                        </tbody>
                                        <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="cell_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="cell_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="cell_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>


                                </div>

                            </div>
                            <!-- <br>
                            <br> -->
                        </div>
                    </section>
                </div>
            </div>
        </div>

        {{--KINETIX --}}
        <div class="row"> {{--1--}}
            <div>{{--2--}}
                <div class="col-sm-12 col-md-12">{{--3--}}
                    <section class="panel" id="data_table">
                        <div class="panel-body">{{--4--}}
                            <div>{{--5--}}
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">{{--6--}}
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>KINETIX <br> (incl.<br> HOSPICARE) </b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>{{--6end--}}

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_kinetix_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="kinetix_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="kinetix_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="kinetix_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_kinetix_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="kinetix_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="kinetix_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="kinetix_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_kinetix_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                             <tbody>
                                        </tbody>
                                        <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="kinetix_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="kinetix_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="kinetix_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>{{--5end--}}

                        </div>
                    </section>
                </div>
            </div>
        </div>

        {{--ZYMOS --}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>ZYMOS  <br>  (incl.<br> Herbal &<br> Nutricare)</b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_zymos_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="zymos_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="zymos_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="zymos_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_zymos_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>

                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="zymos_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="zymos_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="zymos_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_zymos_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="zymos_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="zymos_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="zymos_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                           <!--  <br>
                            <br> -->
                        </div>
                    </section>
                </div>
            </div>
        </div>


        {{--TOTAL GENERAL --}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>TOTAL <br>GENERAL</b></td>


                                            </tr>

                                        </tbody>

                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_totgeneral_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="totgeneral_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totgeneral_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totgeneral_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_totgeneral_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="totgeneral_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totgeneral_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totgeneral_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_totgeneral_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                             <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="totgeneral_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totgeneral_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="totgeneral_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                            <!-- <br>
                            <br> -->
                        </div>
                    </section>
                </div>
            </div>
        </div>



        {{--HYGIENE(Diaper) //TOTAL IHHL--}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <!-- <td class="text-center">TOTAL IHHL</td> -->
                                                 {{--<td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>TOTAL IHHL</b></td>--}}
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>HYGIENE <br>(Diaper)</b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_total_ihhl_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="hygen_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="hygen_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="hygen_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_total_ihhl_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="hygen_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="hygen_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="hygen_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_total_ihhl_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="hygen_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="hygen_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="hygen_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                            <br>
                            <br>

                        </div>
                    </section>
                </div>
            </div>
        </div>

        {{--AHVD--}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                        <tr rowspan="12">
                                            <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>AHVD</b></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_ahvd_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td class="ahvd_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                <td class="ahvd_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                <td class="ahvd_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ahvd_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td class="ahvd_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                <td class="ahvd_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                <td class="ahvd_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ahvd_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td class="ahvd_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                <td class="ahvd_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                <td class="ahvd_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                            <!-- <br>
                            <br> -->
                        </div>
                    </section>
                </div>
            </div>
        </div>

        {{--total depot sales--}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                        <tr rowspan="12">
                                            <!-- <td class="text-center">IHNL</td> -->
                                            <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>Total <br> Depot <br> Sales</b></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_tot_depo_sale_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td class="totdepot_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                <td class="totdepot_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                <td class="totdepot_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_tot_depo_sale_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td class="totdepot_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                <td class="totdepot_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                <td class="totdepot_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_tot_depo_sale_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td class="totdepot_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                <td class="totdepot_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                <td class="totdepot_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>


                                </div>

                            </div>
                            <br>
                            <br>
                        </div>
                    </section>
                </div>
            </div>
        </div>



        {{--Kinetix-Inter Company Sales (Hospicare)--}}
        {{--<div class="row">--}}
            {{--<div>--}}
                {{--<div class="col-sm-12 col-md-12">--}}
                    {{--<section class="panel" id="data_table">--}}
                        {{--<div class="panel-body">--}}
                            {{--<div>--}}
                                {{--<div class="col-sm-1 col-md-1" style="margin-top:0px;">--}}
                                    {{--<table class="display table table-condensed table-bordered table-striped table-responsive">--}}
                                        {{--<thead style="display:none;"></thead>--}}
                                        {{--<tbody>--}}
                                        {{--<tr rowspan="12">--}}
                                            {{--<!-- <td class="text-center">IHNL</td> -->--}}
                                            {{--<td class="text-center" style="background-color:#FDE9D9;color:#005DE6"> <b> Kinetix<br>-Inter<br> Company <br>Sales <br>(Hospicare)</b></td>--}}
                                            {{--<td class="text-center" style="background-color:#FDE9D9;color:#005DE6">Kinetix-Inter Company Sales (Hospicare)</td>--}}


                                        {{--</tr>--}}

                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                {{--</div>--}}

                                {{--<div class="col-sm-11 col-md-11">--}}
                                    {{--<div class="col-sm-4 col-md-4">--}}
                                        {{--<table id="kinetix_inter_com_sale_5y" class="display table  table-bordered table-striped table-responsive">--}}
                                            {{--<thead style="display:none;"></thead>--}}
                                            {{--<tbody>--}}
                                                {{--<tr>--}}
                                                    {{--<td></td>--}}
                                                    {{--<td></td>--}}
                                                    {{--<td></td>--}}
                                                    {{--<td>.52</td>--}}
                                                    {{--<td></td>--}}
                                                {{--</tr>--}}
                                            {{--</tbody>--}}
                                            {{--<tfoot>--}}
                                            {{--<tr>--}}
                                                {{--<td style="text-align:center"></td>--}}
                                                {{--<td style="text-align:center"></td>--}}
                                                {{--<td id="kinetix_inter_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="kinetix_inter_curr_3yr_acl_sale" style="text-align:center;font-weight: bold">{{$kinetix_r[0]->syear2}}</td>--}}
                                                {{--<td id="kinetix_inter_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>--}}

                                            {{--</tr>--}}
                                            {{--</tfoot>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-4 col-md-4" style="padding-left:3px;">--}}
                                        {{--<table id="kinetix_inter_com_sale_4y" class="display table  table-bordered table-striped table-responsive">--}}
                                            {{--<thead style="display:none;"></thead>--}}
                                            {{--<tbody>--}}
                                            {{--<tr>--}}
                                                {{--<td></td>--}}
                                                {{--<td></td>--}}
                                                {{--<td>.52</td>--}}
                                                {{--<td></td>--}}
                                            {{--</tr>--}}
                                            {{--</tbody>--}}
                                            {{--<tfoot>--}}
                                            {{--<tr>--}}
                                                {{--<td style="text-align:center"></td>--}}

                                                {{--<td style="text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="kinetix_inter_curr_2yr" style="text-align:center;font-weight: bold">{{$kinetix_r[0]->syear1}}</td>--}}
                                                {{--<td style="text-align:center;font-weight: bold"></td>--}}

                                                {{--<td id="kinetix_inter_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="kinetix_inter_curr_2yr_acl_sale" style="text-align:center;font-weight: bold">{{$kinetix_r[0]->syear1}}</td>--}}
                                                {{--<td id="kinetix_inter_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>--}}


                                            {{--</tr>--}}
                                            {{--</tfoot>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-sm-4 col-md-4" style="padding-left:3px;">--}}
                                        {{--<table id="kinetix_inter_com_sale_3y" class="display table  table-bordered table-striped table-responsive">--}}
                                            {{--<thead style="display:none;"></thead>--}}
                                            {{--<tbody>--}}
                                            {{--<tr>--}}
                                                {{--<td></td>--}}
                                                {{--<td></td>--}}
                                                {{--<td>.52</td>--}}
                                                {{--<td></td>--}}
                                            {{--</tr>--}}
                                            {{--</tbody>--}}
                                            {{--<tfoot>--}}
                                            {{--<tr>--}}
                                                {{--<td style="text-align:center"></td>--}}

                                                {{--<td style="text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="kinetix_inter_curr_1yr" style="text-align:center;font-weight: bold">{{$kinetix_r[0]->syear}}</td>--}}
                                                {{--<td style="text-align:center;font-weight: bold"></td>--}}

                                                {{--<td id="kinetix_inter_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="kinetix_inter_curr_1yr_acl_sale" style="text-align:center;font-weight: bold">{{$kinetix_r[0]->syear}}</td>--}}
                                                {{--<td id="kinetix_inter_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>--}}


                                            {{--</tr>--}}
                                            {{--</tfoot>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}


                                {{--</div>--}}

                            {{--</div>--}}
                            {{--<br>--}}
                            {{--<br>--}}
                        {{--</div>--}}
                    {{--</section>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--sum--}}
        {{--<div class="row">--}}
            {{--<div>--}}
                {{--<div class="col-sm-12 col-md-12">--}}
                    {{--<section class="panel" id="data_table">--}}
                        {{--<div class="panel-body">--}}
                            {{--<div>--}}
                                {{--<div class="col-sm-1 col-md-1" style="margin-top:0px;">--}}
                                    {{--<table class="display table table-condensed table-bordered table-striped table-responsive">--}}
                                        {{--<thead style="display:none;"></thead>--}}
                                        {{--<tbody>--}}
                                        {{--<tr rowspan="12">--}}
                                            {{--<!-- <td class="text-center">IHNL</td> -->--}}
                                            {{--<td class="text-center" style="background-color:#FDE9D9;color:#005DE6"> <b> Team    <br>wise<br> total <br>Sales</b></td>--}}
                                            {{--<td class="text-center" style="background-color:#FDE9D9;color:#005DE6">Kinetix-Inter Company Sales (Hospicare)</td>--}}


                                        {{--</tr>--}}

                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                {{--</div>--}}

                                {{--<div class="col-sm-11 col-md-11">--}}
                                    {{--<div class="col-sm-4 col-md-4">--}}
                                        {{--<table  class="display table  table-bordered table-striped table-responsive">--}}
                                            {{--<thead style="display:none;"></thead>--}}
                                            {{--<tbody>--}}
                                            {{--<tr>--}}
                                            {{--<td></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td>.52</td>--}}
                                            {{--<td></td>--}}
                                            {{--</tr>--}}
                                            {{--</tbody>--}}
                                            {{--<tfoot>--}}
                                            {{--<tr>--}}
                                                {{--<td style="text-align:center"></td>--}}
                                                {{--<td style="text-align:center;background-color:#FDE9D9;"></td>--}}
                                                {{--<td style="text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="team_wise_sum_curr_3yr" style="text-align:center;font-weight: bold">{{$kinetix_r[0]->syear2}}</td>--}}
                                                {{--<td style="text-align:center;font-weight: bold"></td>--}}

                                                {{--<td id="team_wise_sum_curr_3yr_tar" style="background-color:#FDE9D9;text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="team_wise_sum_curr_3yr_acl_sale" style="background-color:#FDE9D9;text-align:center;font-weight: bold">{{$kinetix_r[0]->syear2}}</td>--}}
                                                {{--<td id="team_wise_sum_curr_3yr_ach" style="background-color:#FDE9D9;text-align:center;font-weight: bold"></td>--}}


                                            {{--</tr>--}}
                                            {{--</tfoot>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-4 col-md-4" style="padding-left:3px;">--}}
                                        {{--<table  class="display table  table-bordered table-striped table-responsive">--}}
                                            {{--<thead style="display:none;"></thead>--}}
                                            {{--<tbody>--}}
                                            {{--<tr>--}}
                                            {{--<td></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td>.52</td>--}}
                                            {{--<td></td>--}}
                                            {{--</tr>--}}
                                            {{--</tbody>--}}
                                            {{--<tfoot>--}}
                                            {{--<tr>--}}
                                                {{--<td style="text-align:center"></td>--}}

                                                {{--<td id="team_wise_sum_curr_2yr_tar" style="background-color:#FDE9D9;text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="team_wise_sum_curr_2yr_acl_sale" style="background-color:#FDE9D9;text-align:center;font-weight: bold">{{$kinetix_r[0]->syear1}}</td>--}}
                                                {{--<td id="team_wise_sum_curr_2yr_ach" style="background-color:#FDE9D9;text-align:center;font-weight: bold"></td>--}}


                                            {{--</tr>--}}
                                            {{--</tfoot>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-sm-4 col-md-4" style="padding-left:3px;">--}}
                                        {{--<table  class="display table  table-bordered table-striped table-responsive">--}}
                                            {{--<thead style="display:none;"></thead>--}}
                                            {{--<tbody>--}}
                                            {{--<tr>--}}
                                            {{--<td></td>--}}
                                            {{--<td></td>--}}
                                            {{--<td>.52</td>--}}
                                            {{--<td></td>--}}
                                            {{--</tr>--}}
                                            {{--</tbody>--}}
                                            {{--<tfoot>--}}
                                            {{--<tr>--}}
                                                {{--<td style="text-align:center"></td>--}}

                                                {{--<td id="team_wise_sum_curr_1yr_tar"  style="background-color:#FDE9D9;text-align:center;font-weight: bold"></td>--}}
                                                {{--<td id="team_wise_sum_curr_1yr_acl_sale" style="background-color:#FDE9D9;text-align:center;font-weight: bold">{{$kinetix_r[0]->syear}}</td>--}}
                                                {{--<td id="team_wise_sum_curr_1yr_ach"  style="background-color:#FDE9D9;text-align:center;font-weight: bold"></td>--}}


                                            {{--</tr>--}}
                                            {{--</tfoot>--}}
                                        {{--</table>--}}
                                    {{--</div>--}}


                                {{--</div>--}}

                            {{--</div>--}}
                            {{--<br>--}}
                            {{--<br>--}}
                        {{--</div>--}}
                    {{--</section>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--IHNL--}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <!-- <td class="text-center">IHNL</td> -->
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>IHNL</b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_ihnl_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ihnl_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ihnl_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ihnl_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ihnl_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ihnl_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ihnl_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ihnl_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ihnl_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ihnl_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ihnl_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ihnl_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                            <br>
                            <br>
                        </div>
                    </section>
                </div>
            </div>
        </div>

          {{--IVL--}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <!-- <td class="text-center">IHNL</td> -->
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>IVL <br>(Human <br> Vaccine)</b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_ivl_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ivl_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ivl_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ivl_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ivl_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ivl_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ivl_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ivl_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_ivl_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="ivl_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ivl_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="ivl_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                            <br>
                            <br>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        {{--INSTITUTION--}}
        <div class="row">
            <div>
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div>
                                <div class="col-sm-1 col-md-1" style="margin-top:8px;">
                                    <table class="display table table-condensed table-bordered table-striped table-responsive">
                                        <thead style="display:none;"></thead>
                                        <tbody>
                                            <tr rowspan="12">
                                                <td class="text-center" style="background-color:#FDE9D9;color:#005DE6"><b>INSTITU<br>-TION</b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-11 col-md-11">
                                    <div class="col-sm-4 col-md-4">
                                        <table id="team_inst_5y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="inst_curr_3yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="inst_curr_3yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="inst_curr_3yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_inst_4y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="inst_curr_2yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="inst_curr_2yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="inst_curr_2yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-sm-4 col-md-4" style="padding-left:3px;">
                                        <table id="team_inst_3y" class="display table  table-bordered table-striped table-responsive">
                                            <thead style="display:none;"></thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td style="text-align:center"></td>
                                                    <td style="text-align:center"></td>
                                                    <td class="inst_curr_1yr_tar" style="text-align:center;font-weight: bold"></td>
                                                    <td class="inst_curr_1yr_act_sale" style="text-align:center;font-weight: bold"></td>
                                                    <td class="inst_curr_1yr_ach" style="text-align:center;font-weight: bold"></td>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>

                            </div>
                           <!--  <br>
                            <br> -->
                        </div>
                    </section>
                </div>
            </div>
        </div>

        {{--company wise sale--}}
        <div class="row" id="scroll-to-div">

            <div class="col-sm-12">
                <section class="panel" id="data_table">

                    <div class="panel-body">
                        <div class="adv-table">
                            <!-- <div id="tableOne"> -->
                            <table id="company_wise_sale_t1" class="table table-responsive table-bordered table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th colspan="14" style="font-size:85%;background-color:#afafaa;text-align:left;vertical-align:middle;color:#2e00ff;font-weight: bold;"><center>COMPANY WISE SALES SUMMARY (<span style="color:brown">{{$result->sales_year}}</span>) (excl. Intr Com. Sale, Export, Service Export & Toll Mfg.)</center></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="font-size: 82%;background-color:#8db4e2;text-align:left;vertical-align:middle;color:#2e00ff;"><center>Month</center></th>
                                    <th colspan="4" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle; background-color:#c3d598;color:#2e00ff;"><center>IPL</center></th>
                                    <th colspan="4" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle; background-color:#fabf8f;color:#2e00ff"><center>IVL</center></th>
                                    <!-- <th colspan="3" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#87d8ec;color:#2e00ff"><center>Healthcare</center></th>

                                    <th colspan="1" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#d8da6d;color:#2e00ff"><center>Nutricare</center></th> -->
                                    <th colspan="3" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#87d8ec;color:#2e00ff"><center>IHHL</center></th>

                                    <th colspan="1" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#d8da6d;color:#2e00ff"><center>IHNL</center></th>

                                    <th rowspan="2" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rosybrown;color:#6f192c">Total</th>


                                </tr>
                                <tr>

                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">General</th>
                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">Institute</th>
                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">Animal<br> Health</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);color:#6f192c" data-orderable="false">Total</th>

                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Human</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Animal</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Institute</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#6f192c" data-orderable="false">Total</th>

                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#2e00ff" data-orderable="false">
                                      <!-- Diaper -->
                                      Hygiene
                                      <!-- <br>(Diaper) -->
                                    </th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#2e00ff" data-orderable="false">
                                    <!-- Infusion -->
                                    Hospicare
                                  <!--   <br>(Infusion+<br>Suture) -->
                                  </th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#6f192c" data-orderable="false">Total</th>

                                    <th data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(241, 238, 164);color:#6f192c">Total</th>


                                </tr>


                                </thead>
                                <tbody>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td style="text-align:center;vertical-align:middle;font-weight:bold;background-color:#8db4e2;">Total</td>

                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>


                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>


                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>


                                    <td style="font-weight:bold;text-align:center;vertical-align:middle;background-color:rgb(241, 238, 164)"></td>

                                    <td style="font-weight:bold;text-align:center;vertical-align:middle;background-color:rosybrown"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

        </div>

        {{--company wise sale year 2--}}
        <div class="row">
            <div class="col-sm-12">
                <section class="panel" id="data_table">

                    <div class="panel-body">
                        <div class="adv-table">
                            <!-- <div id="tableOne"> -->
                            <table id="company_wise_sale_t2" class="table table-responsive table-bordered table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th colspan="14" style="font-size:85%;background-color:#afafaa;text-align:left;vertical-align:middle;color:#2e00ff;font-weight: bold;"><center>COMPANY WISE SALES SUMMARY (<span style="color:brown">{{$result->sales_year-1}}</span>) (excl. Intr Com. Sale, Export, Service Export & Toll Mfg.)</center></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="font-size: 82%;background-color:#8db4e2;text-align:left;vertical-align:middle;color:#2e00ff"><center>Month</center></th>
                                    <th colspan="4" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle; background-color:#c3d598;color:#2e00ff;"><center>IPL</center></th>
                                    <th colspan="4" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle; background-color:#fabf8f;color:#2e00ff"><center>IVL</center></th>
                                 <!--    <th colspan="3" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#87d8ec;color:#2e00ff"><center>Healthcare</center></th>

                                    <th colspan="1" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#d8da6d;color:#2e00ff"><center>Nutricare</center></th> -->

                                     <th colspan="3" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#87d8ec;color:#2e00ff"><center>IHHL</center></th>

                                    <th colspan="1" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#d8da6d;color:#2e00ff"><center>IHNL</center></th>


                                    <th rowspan="2" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rosybrown;color:#6f192c">Total</th>


                                </tr>
                                <tr>

                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">General</th>
                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">Institute</th>
                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">Animal<br> Health</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);color:#6f192c" data-orderable="false">Total</th>

                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Human</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Animal</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Institute</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#6f192c" data-orderable="false">Total</th>

                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#2e00ff" data-orderable="false">
                                      <!-- Diaper -->
                                      Hygiene
                                      <!-- <br>(Diaper) -->
                                    </th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#2e00ff" data-orderable="false">

                                    <!-- Infusion -->
                                      Hospicare
                                    <!-- <br>(Infusion+<br>Suture) -->

                                  </th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#6f192c" data-orderable="false">Total</th>

                                    <th data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(241, 238, 164);color:#6f192c">Total</th>


                                </tr>


                                </thead>
                                <tbody>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td style="text-align:center;vertical-align:middle;background-color:#8db4e2;font-weight:bold">Total</td>

                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>


                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>


                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>


                                    <td style="font-weight:bold;text-align:center;vertical-align:middle;background-color:rgb(241, 238, 164)"></td>

                                    <td style="font-weight:bold;text-align:center;vertical-align:middle;background-color:rosybrown"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{--company wise sale year 3--}}
        <div class="row">


            <div class="col-sm-12">
                <section class="panel" id="data_table">

                    <div class="panel-body">
                        <div class="adv-table">
                            <!-- <div id="tableOne"> -->
                            <table id="company_wise_sale_t3" class="table table-responsive table-bordered table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th colspan="14" style="font-size:85%;background-color:#afafaa;text-align:left;vertical-align:middle;color:#2e00ff;font-weight: bold;"><center>COMPANY WISE SALES SUMMARY (<span style="color:brown">{{$result->sales_year-2}}</span>) (excl. Intr Com. Sale, Export, Service Export & Toll Mfg.)</center></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="font-size: 82%;background-color:#8db4e2;text-align:left;vertical-align:middle;color:#2e00ff"><center>Month</center></th>
                                    <th colspan="4" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle; background-color:#c3d598;color:#2e00ff;"><center>IPL</center></th>
                                    <th colspan="4" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle; background-color:#fabf8f;color:#2e00ff"><center>IVL</center></th>
                                   <!--  <th colspan="3" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#87d8ec;color:#2e00ff"><center>Healthcare</center></th>

                                    <th colspan="1" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#d8da6d;color:#2e00ff"><center>Nutricare</center></th> -->

                                    <th colspan="3" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#87d8ec;color:#2e00ff"><center>IHHL</center></th>

                                    <th colspan="1" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:#d8da6d;color:#2e00ff"><center>IHNL</center></th>

                                    <th rowspan="2" data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rosybrown;color:#6f192c">Total</th>


                                </tr>
                                <tr>

                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">General</th>
                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">Institute</th>
                                    <th style="font-size: 82%;background-color:rgb(216, 228, 188);text-align:center;vertical-align:middle;color:#2e00ff" data-orderable="false">Animal<br> Health</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);color:#6f192c" data-orderable="false">Total</th>

                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Human</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Animal</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#2e00ff" data-orderable="false">Institute</th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);color:#6f192c" data-orderable="false">Total</th>

                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#2e00ff" data-orderable="false">
                                    <!-- Diaper -->
                                    Hygiene
                                     <!--  <br>(Diaper) -->
                                  </th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#2e00ff" data-orderable="false">
                                    <!-- Infusion -->
                                    Hospicare
                                    <!-- <br>(Infusion+<br>Suture) -->

                                  </th>
                                    <th style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);color:#6f192c" data-orderable="false">Total</th>

                                    <th data-orderable="false" style="font-size: 82%;text-align:center;vertical-align:middle;background-color:rgb(241, 238, 164);color:#6f192c">Total</th>


                                </tr>


                                </thead>
                                <tbody>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td style="text-align:center;vertical-align:middle;font-weight:bold;background-color:#8db4e2;">Total</td>

                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(216, 228, 188);font-weight:bold"></td>


                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(234, 200, 173);font-weight:bold"></td>


                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>
                                    <td style="text-align:center;vertical-align:middle;background-color:rgb(183, 222, 232);font-weight:bold"></td>


                                    <td style="font-weight:bold;text-align:center;vertical-align:middle;background-color:rgb(241, 238, 164)"></td>

                                    <td style="font-weight:bold;text-align:center;vertical-align:middle;background-color:rosybrown"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
    @endsection
    @section('scripts')

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}

    
    {{Html::script('public/site_resource/js/custom/script_perform.js')}}

    <script>
        $("#main_content").hide();
        $("#loader").show();

        $(window).load(function () {
            $.ajax({
                url: "{{url('srep/resp_perform_data')}}",
                type: "GET",
                success: function (response) {

                    load_tables(response[0],response[1],response[2],response[3],response[4],
                            response[5],response[6],response[7],response[8],response[9],response[10],
                            response[11],response[12],response[13],response[14],response[15],response[16],
                            response[17],response[18],response[19],response[20],response[21],response[22],
                            response[23],response[24],response[25],response[26],response[27],response[28],
                            response[29],response[30],response[31],response[32],response[33],
                            response[34],response[35],response[36],response[37],response[38],
                        response[39],response[40],response[41]);



                    //aster gyrus----------------------------------------------------------
                    // actualsale/target=ach

//                    //aster gyrus currentyear-1 like 2018

                    var aster_curr_3yr_ach=((parseFloat($('.aster_curr_3yr_act_sale').html())/parseFloat($('.aster_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".aster_curr_3yr_ach").html(aster_curr_3yr_ach+"%");

                    //aster gyrus currentyear-1 like 2018-1=2017

                    var aster_curr_2yr_ach=((parseFloat($('.aster_curr_2yr_act_sale').html())/parseFloat($('.aster_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".aster_curr_2yr_ach").html(aster_curr_2yr_ach+"%");

                    //aster gyrus currentyear-1 like 2018-2=2016

                    var aster_curr_1yr_ach=((parseFloat($('.aster_curr_1yr_act_sale').html())/parseFloat($('.aster_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".aster_curr_1yr_ach").html(aster_curr_1yr_ach+"%");

                    //ope zen----------------------------------------------------------
                    // actualsale/target=ach

//                    //ope zen currentyear-1 like 2018

                    var ope_zen_curr_3yr_ach=((parseFloat($('.ope-zen_curr_3yr_act_sale').html())/parseFloat($('.ope-zen_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".ope-zen_curr_3yr_ach").html(ope_zen_curr_3yr_ach+"%");

                    //ope zen currentyear-1 like 2018-1=2017

                    var ope_zen_curr_2yr_ach=((parseFloat($('.ope-zen_curr_2yr_act_sale').html())/parseFloat($('.ope-zen_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".ope-zen_curr_2yr_ach").html(ope_zen_curr_2yr_ach+"%");

                    //ope zen currentyear-1 like 2018-2=2016

                    var ope_zen_curr_1yr_ach=((parseFloat($('.ope-zen_curr_1yr_act_sale').html())/parseFloat($('.ope-zen_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".ope-zen_curr_1yr_ach").html(ope_zen_curr_1yr_ach+"%");

                    //total special ----------------------------------------------------------
                    // actualsale/target=ach

                    ////totspecial currentyear-1 like 2018

                    var totspecial_curr_3yr_ach=((parseFloat($('.totspecial_curr_3yr_act_sale').html())/parseFloat($('.totspecial_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".totspecial_curr_3yr_ach").html(totspecial_curr_3yr_ach+"%");

                    //totspecial currentyear-1 like 2018-1=2017

                    var totspecial_curr_2yr_ach=((parseFloat($('.totspecial_curr_2yr_act_sale').html())/parseFloat($('.totspecial_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".totspecial_curr_2yr_ach").html(totspecial_curr_2yr_ach+"%");

                    //aster gyrus currentyear-1 like 2018-2=2016

                    var totspecial_curr_1yr_ach=((parseFloat($('.totspecial_curr_1yr_act_sale').html())/parseFloat($('.totspecial_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".totspecial_curr_1yr_ach").html(totspecial_curr_1yr_ach+"%");


                    //cellbiotic ----------------------------------------------------------
                    // actualsale/target=ach

                    ////cellbiotic currentyear-1 like 2018

                    var cell_curr_3yr_ach=((parseFloat($('.cell_curr_3yr_act_sale').html())/parseFloat($('.cell_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".cell_curr_3yr_ach").html(cell_curr_3yr_ach+"%");

                    //cellbiotic currentyear-1 like 2018-1=2017

                    var cell_curr_2yr_ach =((parseFloat($('.cell_curr_2yr_act_sale').html())/parseFloat($('.cell_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".cell_curr_2yr_ach").html(cell_curr_2yr_ach+"%");

                    //cellbiotic currentyear-1 like 2018-2=2016

                    var cell_curr_1yr_ach=((parseFloat($('.cell_curr_1yr_act_sale').html())/parseFloat($('.cell_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".cell_curr_1yr_ach").html(cell_curr_1yr_ach+"%");

//                    kinetix--------------------------------------------------------------------------
                    ////kinetix currentyear-1 like 2018

                    var kinetix_curr_3yr_ach=((parseFloat($('.kinetix_curr_3yr_act_sale').html())/parseFloat($('.kinetix_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".kinetix_curr_3yr_ach").html(kinetix_curr_3yr_ach+"%");

                    //kinetix currentyear-1 like 2018-1=2017

                    var kinetix_curr_2yr_ach=((parseFloat($('.kinetix_curr_2yr_act_sale').html())/parseFloat($('.kinetix_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".kinetix_curr_2yr_ach").html(kinetix_curr_2yr_ach+"%");


                    //kinetix currentyear-1 like 2018-2=2016

                    var kinetix_curr_1yr_ach=((parseFloat($('.kinetix_curr_1yr_act_sale').html())/parseFloat($('.kinetix_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".kinetix_curr_1yr_ach").html(kinetix_curr_1yr_ach+"%");

//                    zymos--------------------------------------------------------------------
                    ////zymos currentyear-1 like 2018

                    var zymos_curr_3yr_ach=((parseFloat($('.zymos_curr_3yr_act_sale').html())/parseFloat($('.zymos_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".zymos_curr_3yr_ach").html(zymos_curr_3yr_ach+"%");

                    //zymos currentyear-1 like 2018-1=2017

                    var zymos_curr_2yr_ach=((parseFloat($('.zymos_curr_2yr_act_sale').html())/parseFloat($('.zymos_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".zymos_curr_2yr_ach").html(zymos_curr_2yr_ach+"%");


                    //zymos currentyear-1 like 2018-2=2016

                    var zymos_curr_1yr_ach=((parseFloat($('.zymos_curr_1yr_act_sale').html())/parseFloat($('.zymos_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".zymos_curr_1yr_ach").html(zymos_curr_1yr_ach+"%");




//                    total general--------------------------------------------------------------------
                    ////total general currentyear-1 like 2018

                    // console.log("a "+$('.totgeneral_curr_3yr_act_sale').html().replace(/,/g, ''));
                    // console.log("b "+$('.totgeneral_curr_3yr_tar').html().replace(/,/g, ''));

                    var totgeneral_curr_3yr_ach=((parseFloat($('.totgeneral_curr_3yr_act_sale').html().replace(/,/g, ''))/parseFloat($('.totgeneral_curr_3yr_tar').html().replace(/,/g, '')))*100).toFixed(2);
                    $(".totgeneral_curr_3yr_ach").html(totgeneral_curr_3yr_ach+"%");

                    //totgeneral currentyear-1 like 2018-1=2017

                    var totgeneral_curr_2yr_ach=((parseFloat($('.totgeneral_curr_2yr_act_sale').html().replace(/,/g, ''))/parseFloat($('.totgeneral_curr_2yr_tar').html().replace(/,/g, '')))*100).toFixed(2);
                    $(".totgeneral_curr_2yr_ach").html(totgeneral_curr_2yr_ach+"%");


                    //totgeneral currentyear-1 like 2018-2=2016

                    var totgeneral_curr_1yr_ach=((parseFloat($('.totgeneral_curr_1yr_act_sale').html().replace(/,/g, ''))/parseFloat($('.totgeneral_curr_1yr_tar').html().replace(/,/g, '')))*100).toFixed(2);
                    $(".totgeneral_curr_1yr_ach").html(totgeneral_curr_1yr_ach+"%");


//                    HYGIENE (Diaper)--------------------------------------------------------------------
                    ////HYGIENE (Diaper)  currentyear-1 like 2018

                    var hygen_curr_3yr_ach=((parseFloat($('.hygen_curr_3yr_act_sale').html())/parseFloat($('.hygen_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".hygen_curr_3yr_ach").html(hygen_curr_3yr_ach+"%");

                    //HYGIENE (Diaper) currentyear-1 like 2018-1=2017

                    var hygen_curr_2yr_ach=((parseFloat($('.hygen_curr_2yr_act_sale').html())/parseFloat($('.hygen_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".hygen_curr_2yr_ach").html(hygen_curr_2yr_ach+"%");


                    //HYGIENE (Diaper) currentyear-1 like 2018-2=2016

                    var hygen_curr_1yr_ach=((parseFloat($('.hygen_curr_1yr_act_sale').html())/parseFloat($('.hygen_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".hygen_curr_1yr_ach").html(hygen_curr_1yr_ach+"%");

                    //AHVD --------------------------------------------------------------------
                    ////AHVD  currentyear-1 like 2018

                    var ahvd_curr_3yr_ach=((parseFloat($('.ahvd_curr_3yr_act_sale').html())/parseFloat($('.ahvd_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".ahvd_curr_3yr_ach").html(ahvd_curr_3yr_ach+"%");

                    //AHVD currentyear-1 like 2018-1=2017

                    var ahvd_curr_2yr_ach=((parseFloat($('.ahvd_curr_2yr_act_sale').html())/parseFloat($('.ahvd_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".ahvd_curr_2yr_ach").html(ahvd_curr_2yr_ach+"%");


                    //AHVD currentyear-1 like 2018-2=2016

                    var ahvd_curr_1yr_ach=((parseFloat($('.ahvd_curr_1yr_act_sale').html())/parseFloat($('.ahvd_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".ahvd_curr_1yr_ach").html(ahvd_curr_1yr_ach+"%");


                    //total depot sales --------------------------------------------------------------------
                    ////total depot sales  currentyear-1 like 2018

                    var totdepot_curr_3yr_ach=((parseFloat($('.totdepot_curr_3yr_act_sale').html().replace(/,/g, ''))/parseFloat($('.totdepot_curr_3yr_tar').html().replace(/,/g, '')))*100).toFixed(2);
                    $(".totdepot_curr_3yr_ach").html(totdepot_curr_3yr_ach+"%");

                    //total depot sales currentyear-1 like 2018-1=2017

                    var totdepot_curr_2yr_ach=((parseFloat($('.totdepot_curr_2yr_act_sale').html().replace(/,/g, ''))/parseFloat($('.totdepot_curr_2yr_tar').html().replace(/,/g, '')))*100).toFixed(2);
                    $(".totdepot_curr_2yr_ach").html(totdepot_curr_2yr_ach+"%");


                    //total depot sales currentyear-1 like 2018-2=2016

                    var totdepot_curr_1yr_ach=((parseFloat($('.totdepot_curr_1yr_act_sale').html().replace(/,/g, ''))/parseFloat($('.totdepot_curr_1yr_tar').html().replace(/,/g, '')))*100).toFixed(2);
                    $(".totdepot_curr_1yr_ach").html(totdepot_curr_1yr_ach+"%");


                    //ihnl--------------------------------------------------------------------
                    ////ihnl currentyear-1 like 2018

                    var ihnl_curr_3yr_ach=((parseFloat($('.ihnl_curr_3yr_act_sale').html())/parseFloat($('.ihnl_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".ihnl_curr_3yr_ach").html(ihnl_curr_3yr_ach+"%");

                    //ihnl currentyear-1 like 2018-1=2017

                    var ihnl_curr_2yr_ach=((parseFloat($('.ihnl_curr_2yr_act_sale').html())/parseFloat($('.ihnl_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".ihnl_curr_2yr_ach").html(ihnl_curr_2yr_ach+"%");


                    //ihnl currentyear-1 like 2018-2=2016

                    var ihnl_curr_1yr_ach=((parseFloat($('.ihnl_curr_1yr_act_sale').html())/parseFloat($('.ihnl_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".ihnl_curr_1yr_ach").html(ihnl_curr_1yr_ach+"%");


                    // ivl achievement calculation

                    var ivl_curr_3yr_ach=((parseFloat($('.ivl_curr_3yr_act_sale').html())/parseFloat($('.ivl_curr_3yr_tar').html()))*100).toFixed(2);
                    $(".ivl_curr_3yr_ach").html(ivl_curr_3yr_ach+"%");

                    //aster gyrus currentyear-1 like 2018-1=2017

                    var ivl_curr_2yr_ach=((parseFloat($('.ivl_curr_2yr_act_sale').html())/parseFloat($('.ivl_curr_2yr_tar').html()))*100).toFixed(2);
                    $(".ivl_curr_2yr_ach").html(ivl_curr_2yr_ach+"%");

                    //aster gyrus currentyear-1 like 2018-2=2016

                    var ivl_curr_1yr_ach=((parseFloat($('.ivl_curr_1yr_act_sale').html())/parseFloat($('.ivl_curr_1yr_tar').html()))*100).toFixed(2);
                    $(".ivl_curr_1yr_ach").html(ivl_curr_1yr_ach+"%");

                    // ivl end


                    //inst--------------------------------------------------------------------
                    ////inst currentyear-1 like 2018


                    if(parseFloat($('.inst_curr_3yr_tar').html())!=0){

                        var inst_curr_3yr_ach=((parseFloat($('.inst_curr_3yr_act_sale').html())/parseFloat($('.inst_curr_3yr_tar').html()))*100).toFixed(2);
                        $(".inst_curr_3yr_ach").html(inst_curr_3yr_ach+"%");

                    }



                    //inst currentyear-1 like 2018-1=2017

                    if(parseFloat($('.inst_curr_3yr_tar').html())!=0) {
                        var inst_curr_2yr_ach = ((parseFloat($('.inst_curr_2yr_act_sale').html()) / parseFloat($('.inst_curr_2yr_tar').html())) * 100).toFixed(2);
                        $(".inst_curr_2yr_ach").html(inst_curr_2yr_ach + "%");
                    }

                    //inst currentyear-1 like 2018-2=2016
                    if(parseFloat($('.inst_curr_3yr_tar').html())!=0) {
                        var inst_curr_1yr_ach = ((parseFloat($('.inst_curr_1yr_act_sale').html()) / parseFloat($('.inst_curr_1yr_tar').html())) * 100).toFixed(2);
                        $(".inst_curr_1yr_ach").html(inst_curr_1yr_ach + "%");
                    }

                     if(parseFloat($('.inst_curr_3yr_tar').html())==0) {
                      $('.inst_curr_3yr_tar').html(" ");
                     }

                       if(parseFloat($('.inst_curr_2yr_tar').html())==0) {
                      $('.inst_curr_2yr_tar').html(" ");
                     }

                       if(parseFloat($('.inst_curr_1yr_tar').html())==0) {
                      $('.inst_curr_1yr_tar').html(" ");
                     }
//---------------------------------------------




                    //target-----------------

                    if(!($('#kinetix_inter_curr_3yr_tar').html())){
                        $('#team_wise_sum_curr_3yr_tar').html(parseFloat($('.totdepot_curr_3yr_tar').html().replace(/,/g, '')).toFixed(2));
                    }else{
                        var sum_curr_3y_tar=parseFloat($('.totdepot_curr_3yr_tar').html().replace(/,/g, ''))+parseFloat($('#kinetix_inter_curr_3yr_tar').html().replace(/,/g, ''));
                        $('#team_wise_sum_curr_3yr_tar').html(sum_curr_3y_tar.toFixed(2));
                    }


                    if(!($('#kinetix_inter_curr_2yr_tar').html())){
                        $('#team_wise_sum_curr_2yr_tar').html(parseFloat($('.totdepot_curr_2yr_tar').html().replace(/,/g, '')).toFixed(2));
                    }else{
                        var sum_curr_2y_tar=parseFloat($('.totdepot_curr_2yr_tar').html().replace(/,/g, ''))+parseFloat($('#kinetix_inter_curr_2yr_tar').html().replace(/,/g, ''));
                        $('#team_wise_sum_curr_2yr_tar').html(sum_curr_2y_tar.toFixed(2));
                    }


                    if(!($('#kinetix_inter_curr_1yr_tar').html())){
                        $('#team_wise_sum_curr_1yr_tar').html(parseFloat($('.totdepot_curr_1yr_tar').html()).toFixed(2));
                    }else{
                        var sum_curr_1y_tar=parseFloat($('.totdepot_curr_1yr_tar').html())+parseFloat($('#kinetix_inter_curr_1yr_tar').html());
                        $('#team_wise_sum_curr_1yr_tar').html(sum_curr_1y_tar.toFixed(2));
                    }

                    //actual sales---------------------------------------------------------------------------------------
                    var sum_curr_3y=parseFloat($('.totdepot_curr_3yr_act_sale').html())+parseFloat($('#kinetix_inter_curr_3yr_acl_sale').html());
                    $('#team_wise_sum_curr_3yr_acl_sale').html(sum_curr_3y.toFixed(2));

                    var sum_curr_2y=parseFloat($('.totdepot_curr_2yr_act_sale').html())+parseFloat($('#kinetix_inter_curr_2yr_acl_sale').html());
                    $('#team_wise_sum_curr_2yr_acl_sale').html(sum_curr_2y.toFixed(2));

                    var sum_curr_1y=parseFloat($('.totdepot_curr_1yr_act_sale').html())+parseFloat($('#kinetix_inter_curr_1yr_acl_sale').html());
                    $('#team_wise_sum_curr_1yr_acl_sale').html(sum_curr_1y.toFixed(2));

                    //ach
//                    var sum_curr_3y=parseFloat($('.totdepot_curr_3yr_act_sale').html())+parseFloat($('#kinetix_inter_curr_3yr').html());
//                    $('#team_wise_sum_curr_3yr').html(sum_curr_3y.toFixed(2));
//
//                    var sum_curr_2y=parseFloat($('.totdepot_curr_2yr_act_sale').html())+parseFloat($('#kinetix_inter_curr_2yr').html());
//                    $('#team_wise_sum_curr_2yr').html(sum_curr_2y.toFixed(2));
//
//                    var sum_curr_1y=parseFloat($('.totdepot_curr_1yr_act_sale').html())+parseFloat($('#kinetix_inter_curr_1yr').html());
//                    $('#team_wise_sum_curr_1yr').html(sum_curr_1y.toFixed(2));
                    if(!($('#kinetix_inter_curr_3yr_ach').html())){
                        $('#team_wise_sum_curr_3yr_ach').html(parseFloat($('.totdepot_curr_3yr_ach').html()).toFixed(2));
                    }else{
                        var sum_curr_3y_tar=parseFloat($('.totdepot_curr_3yr_ach').html())+parseFloat($('#kinetix_inter_curr_3yr_ach').html());
                        $('#team_wise_sum_curr_3yr_ach').html(sum_curr_3y_tar.toFixed(2));
                    }


                    if(!($('#kinetix_inter_curr_2yr_ach').html())){
                        $('#team_wise_sum_curr_2yr_ach').html(parseFloat($('.totdepot_curr_2yr_ach').html()).toFixed(2));
                    }else{
                        var sum_curr_2y_ach=parseFloat($('.totdepot_curr_2yr_ach').html())+parseFloat($('#kinetix_inter_curr_2yr_ach').html());
                        $('#team_wise_sum_curr_2yr_ach').html(sum_curr_2y_ach.toFixed(2));
                    }


                    if(!($('#kinetix_inter_curr_1yr_ach').html())){
                        $('#team_wise_sum_curr_1yr_ach').html(parseFloat($('.totdepot_curr_1yr_ach').html()).toFixed(2));
                    }else{
                        var sum_curr_1y_ach=parseFloat($('.totdepot_curr_1yr_ach').html())+parseFloat($('#kinetix_inter_curr_1yr_ach').html());
                        $('#team_wise_sum_curr_1yr_ach').html(sum_curr_1y_ach.toFixed(2));
                    }


                    $("#loader").hide();
                    $("#main_content").show();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        var $cache = $('.my-sticky-element');

        //store the initial position of the element
        var vTop = $cache.offset().top - parseFloat($cache.css('margin-top').replace(/auto/, 0));
        $(window).scroll(function (event) {
            // what the y position of the scroll is
            var y = $(this).scrollTop();

            // whether that's below the form
            if (y >= vTop) {
                // if so, ad the fixed class
                $cache.addClass('stuck');
            } else {
                // otherwise remove it
                $cache.removeClass('stuck');
            }
        });


    </script>


@endsection