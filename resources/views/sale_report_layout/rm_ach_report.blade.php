@extends('_layout_shared._master')
@section('title','RM Achievement%')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    
    <style>
        th {
            white-space: nowrap;
            overflow: hidden;
            color: #003399;
            font-size: 11px;
        }

        td {
            white-space: nowrap;
            overflow: hidden;
            color: #0c0c0c;
            font-size: 11px;
        }

        header.panel-heading {
            color: #003399;
        }
/*
        .dataTables_filter {
            display: none;
        }*/

        .dt-buttons {
            float: right;
        }
        .table>tfoot>tr>td{
            background-color: #d9edf7;
        }
        .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td {
            padding: 5px;
        }
        .depot_sales_class{
            background-color: #EEECE1;
        }
        .export_st_total_class{
            background-color: #EEECE1;
        }
        .inst_total_class{
            background-color: #D8E4BC;
        }
        .export_total_class{
            background-color: #DCE6F1;
        }
        .toll_class{
            background-color: #DAEEF3;
        }
        .total_sale_class{
            background-color: #B7DEE8;
        }
        .grp_clss{
            background-color: #e4ddec;
        }
        .terr_id_clss{
            background-color: #f9e4d3;
        }
        /*style2*/

        .tar_vclss{
            text-align: center;
        }
        .nameclss{
            font-weight: bold;
            background-color: #95bff1;
        }
        .remarkclss{
            background-color: #e2e475;
        }
        .tgt_clss{
            background-color: rgb(232, 241, 213)
        }

        .tot_sal_clss{
            background-color: #f3d7d6;
        }
        .ach_clss{
            background-color: #f9e4d3
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
            border:1px solid #d6c5c5;
        }


        section.data_table header label input {
            /*margin-left: 0.5em;*/
            display: inline-block;
            /*width: auto;*/
        }

        /*//10.4.2019*/
       /* .wrapper{
            padding-top: 0px;
            position:fixed;
            width: 77%;
        }*/

        body{
            overflow: hidden;
        }

    </style>
    @include('comp_analysis_of_sales.caos_styles')
@endsection
@section('top-nav-items')
    <div>
        

    </div>
    <div>
        

    </div>
@endsection
@section('right-content')
    <div class="row">

        <div class="col-sm-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label style="float: left;width: 70.0%">RM/ASM Wise Performance &nbsp &nbsp Figures in <span style="color:green">Crore</span><span style="color:blue">&nbsp &nbsp  BDT <span id="export_buttons"></span> &nbsp &nbsp</span></label>
                    <label style="float: right;width:30.0%" class="src_customarea"></label>
                    <br>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <!-- <table id="dtable1" class="table-fixed table table-responsive table-bordered table-condensed table-striped" style="width:60%;"> -->

                             <table id="dtable1" class="table-fixed table table-responsive table-bordered table-condensed table-striped" style="width:60%;">
                                <thead>
                                    <tr>
                                        <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#8db4e2"><center>RM/ASM NAME </center></th>

                                        <th style="text-align:left;vertical-align:middle;background-color:#ccc0da"><center>Group </center></th>
                                        <th style="text-align:left;vertical-align:middle;background-color:#fcd5b4"><center>Territory </center></th>
                                        
                                        <th style="background-color:#D8E4BC"><center>Total TGT_Value <br> <span style="color:green" class="upto_current_month">Upto Current Month</span></center></th>
                                        <th style="background-color:rgb(230, 184, 183)"><center>Total Sales<br> <span style="color:green" class="upto_current_month">Upto Current Month</span> </center></th>
                                        {{--data-orderable="false"--}}
                                        <th  style="background-color:#fcd5b4"><center>Ach%</center></th>
                                        <th data-orderable="false" style="background-color:rgb(216, 218, 109);font-color:#d878f2"><center>Remark</center></th>
                                        
                                    </tr>
                                
                                </thead>
                                <!-- <tbody style="overflow: auto;height: 380px;display: block;width:60%"> -->
                                <tbody>
                                  
                                </tbody>


                           

                            <tfoot>
                                <tr>
                                    <td style="background-color:#8db4e2;font-weight:bold">Grand Total</td>   

                                    <td id="rm_grp" style="text-align: center;background-color:#ccc0da;font-weight:bold"></td>
                                    <td id="rm_terr_id" style="text-align: center;background-color:#fcd5b4;font-weight:bold"></td>

                              
                                    <td id="rm_tot_sales" style="text-align: center;background-color:#D8E4BC;font-weight:bold"></td>
                                    
                                    <td id="rm_tot_tgt_val" style="text-align: center;background-color:rgb(230, 184, 183);font-weight:bold"></td>
                                  
                                    <td id="rm_tot_ach" style="text-align: center;background-color:#fcd5b4;font-weight:bold"></td>
                                    <td style="text-align: center;background-color:rgb(216, 218, 109);font-weight:bold"></td>
                                </tr>
                            </tfoot>


                        </table>
                    </div>
                </div>
            </section>
        </div>

    </div>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    <script src="{{url('public/site_resource/js/jquery.dataTables.min.js')}}"></script>
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}

    {{Html::script('public/site_resource/js/custom/script_rm_ach.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}

    {{--Added for Export--}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Export--}}



    <script>
        var url_rm_ach = "{{url('srep/resp_rm_ach')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";
        rm_ach_func(url_rm_ach,i_url);

        //rm wise

                // var rm_tot_tgt_val=parseFloat($('#rm_tot_tgt_val').html());
                // console.log(rm_tot_tgt_val);
          
                // var rm_tot_sales=parseFloat($('#rm_tot_sales').html());
                // console.log(rm_tot_sales);
         
                // var rm_tot_ach=((rm_tot_sales/rm_tot_tgt_val)*100).toFixed(2);
                // $('#rm_tot_ach').html(rm_tot_ach+"%");

                


    

        // $(document).ready(function(){
               

        //         //rm wise

        //         var rm_tot_tgt_val=parseFloat($('#rm_tot_tgt_val').html());
          
        //         var rm_tot_sales=parseFloat($('#rm_tot_sales').html());
         
        //         var rm_tot_ach=((rm_tot_sales/rm_tot_tgt_val)*100).toFixed(2);
        //         $('#rm_tot_ach').html(rm_tot_ach+"%");

                



                

        // });


           $(document).ready(function(){

             var arrmonth = new Array();
                arrmonth[0] = 'JAN';
                arrmonth[1] ='FEB';
                arrmonth[2] ='MAR';
                arrmonth[3] ='APR';
                arrmonth[4] ='MAY';
                arrmonth[5] ='JUN';
                arrmonth[6] ='JUL',
                arrmonth[7] ='AUG';
                arrmonth[8] ='SEP',
                arrmonth[9] ='OCT',
                arrmonth[10] ='NOV',
                arrmonth[11] ='DEC'



            console.log("hellow");
            //Return today's date and time
            var currentTime =new Date();
            var demo_month;
            var demo;
            var month_ind;
            var month_ind2;

            //Returns the month (from 0 to 11)
                var month = currentTime.getMonth(); //current month-1
                //returns the day of the month (from 1 to 31)
                console.log('current month'+currentTime.getMonth());
               
                //returns the year (four digits)
                //yeartt=2019; yr=19
                var fullyear = currentTime.getFullYear();
                console.log(fullyear);
                var year = currentTime.getFullYear().toString().substr(-2);
                console.log(year);

                if(month==0){
                    //suppose current month january 2019
                    fullyear=fullyear-1;
                       console.log(fullyear);
                    demo_month='Jan to Dec ';
                    demo=demo_month+fullyear;

                }else{
                    fullyear=fullyear;
                    demo_month=month-1;

                    if(month==1){
                         //suppose current month feb 
                    month_ind=arrmonth[parseInt(demo_month)];
                    demo=month_ind+' '+fullyear;
                    console.log(demo);
                    }else{
                        //suppose current month march or april or may...so on
                        demo_month=
                        month_ind=arrmonth[parseInt(demo_month)];
                        demo='JAN to '+month_ind+' '+fullyear;
                        console.log(demo);
                    }
                   
                }

                
                console.log(demo);
                $('.upto_current_month').html(demo);

        });

      </script>
    
 

@endsection