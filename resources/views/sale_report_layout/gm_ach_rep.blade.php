@extends('_layout_shared._master')
@section('title','ED & SM Achievement%')
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

        .dataTables_filter {
            display: none;
        }

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
        .smname{
            width: 4%;
        }

        .smtarget_value{
            width: 4%;
        }

        .smsales_value{
            width: 4%;
        }


        .smachievement{
            width: 2%;
        }

        .gmname{
            width: 4%;
        }

        .gmtarget_value{
            width: 4%;
        }

        .gmsales_value{
            width: 4%;
        }


        .gmachievement{
            width: 2%;
        }
        /*.dtable3>thead>tr>th>.firstth{
            width: 52px;
        }*/
        table #dtable3 thead {
            display:table;
            width: 60%;
            background-color: lightblue;
            position: fixed;
        }
        table#dtable3{
            /*table-layout:fixed;*/
            margin-bottom: -7px;

        }
        /*table#dtable1{
          table-layout:fixed;
          margin-bottom: -7px;

        }*/
        /*table #dtable3 thead .nameth{

           width: 4%;
        }*/
        .sales_person_clss{
            font-weight: bold;
            background-color: #c1e5ea;
        }
        .remarkclss{
            text-align: center;
        }
        .achclss{
            text-align: center;
        }
        /*//10.4.2019*/

        /*for reduce top space+postion fixed so no scroll*/
        /*.wrapper{
            padding-top: 0px;
            position:fixed;
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
                    <label style="float:left;width:96.0%">ED Wise Performance
                        &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp Figures in <span style="color:green">Crore</span>&nbsp&nbsp &nbsp  &nbsp &nbsp<span style="color:blue">BDT</span> </label>


                    <br>
                    <span id="export_buttons"></span>
                </header>
                <div class="panel-body">
                    <div class="adv-table">

                        <table id="sm_gm_dsm_table" class="display table table-bordered table-striped table-responsive" style="width:80%">
                            <thead>

                            <tr>
                                <th style="background-color: #FCD5B4"></th>
                                <th style="background-color:rgb(204, 192, 218)">Name</th>
                                <th style="background-color:#D8E4BC"><center>Total TGT_Value <br> <span style="color:green" class="upto_current_month">Upto Current Month</span></center></th>
                                <th style="background-color:#fcd5b4;"><center>Total Sales<br> <span style="color:green" class="upto_current_month">Upto Current Month</span></center></th>
                                <th style="background-color:rgb(204, 192, 218)"><center>Ach%</center></th>
                                <th style="background-color:rgb(216, 218, 109)"><center>Remark</center></th>

                            </tr>

                            </thead>
                            <tbody>
                            </tbody>

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
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}


    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}


    {{Html::script('public/site_resource/js/custom/script_dsm_gm_sm_wise_ach.js')}}

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
        var dsm_wise_url = "{{url('srep/resp_gm_achment')}}";
        var dsm_wise_i_url = "{{url('public/site_resource/images/loading.gif')}}";
        initialize_table_sm_dsm_gm_ach(dsm_wise_url,dsm_wise_i_url);

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