@extends('_layout_shared._master')
@section('title','SM/DSM Wise Sales')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/rowGroup.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/css/fixedHeader.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        th {
            white-space: nowrap;
            overflow: hidden;
            color: #003399;
            font-size: 11px;
        }

        td{
            white-space: nowrap;
            overflow: hidden;
            color: #0c0c0c;
            font-size: 11px;
        }

        .panel{
            padding-bottom: 0px;
        }
        header.panel-heading {
            color: #003399;
            padding: 0px;
        }

        .tot_tar,.tot_sal{
            text-align: right;
        }

        .tot_ach{
            text-align: center;
        }


       /* .dataTables_filter {
            display: none;
        }*/

        .dt-buttons {
            float: right;
        }
        .p_group{
            width: 30%;
            font-size: 11px;
        }

        tr.group, tr.group:hover {
            background-color: #ddd !important;
        }
        .pocell {
            font-weight:bold;
        }

        .dataTables_scroll {
            overflow: auto;
        }
        .my-sticky-element.stuck {
            position:fixed;
            top:39px;
            width: 83%;
            padding-right: 28px;
            padding-left: 30px;

         
        }
        .my-sticky-element {
            z-index: 2;
        }

        @media only screen and (max-width: 600px) {
            .my-sticky-element.stuck {
                position:fixed;
                top:39px;
                width: 100%;
              
            }
        }

        @media screen and (max-width: 767px){
            .table-responsive {
                border: none;
        }
        }

        .removeGrup{
            display: none;
        }

        

    </style>

    <style type="text/css" class="init">
    

        .toolbar {
            float: left;
        }

        /*//10.4.2019-----------------------*/
        /*.wrapper{
            padding-top: 0px;
            position:fixed;
        }*/

        .panel-body{
            padding-top: 0px;
            padding-bottom: 0px;
        }

        body{
            overflow: hidden;
        }

        .panel-heading .table tbody > tr > td, .table tfoot > tr > td {
            padding: 2px;
        }

        footer{
            padding-top: 3px;
            padding-bottom: 3px;
        }


    </style>
    @include('comp_analysis_of_sales.caos_styles')

@endsection

@section('right-content')


    <div class="row" id="fix">

        <div class="col-sm-12 col-md-12 my-sticky-element table-responsive">
            <section class="panel" id="data_table">

                <div class="table-responsive">

                <header class="panel-heading " style="padding-bottom: 0px;">
                        <table class="display table table-bordered table-striped table-responsive"  style="margin-bottom: 0px;">
                            @foreach($pgwsq as $key)
                                <tr>
                                    <td style="background-color: #ADDFFF">REPORT MONTH</td>
                                    <td style="background-color: #ADDFFF">REPORT UPTO</td>
                                    <td style="background-color: #ADDFFF">REPORT DATE</td>
                                    <td style="background-color: #ADDFFF">WORKING DAYS IN MONTH</td>
                                    <td style="background-color: #ADDFFF">DAYS OVER</td>
                                    
                                </tr>
                                <tr>
                                    <td style="background-color:#fde4ea">{{ $key->report_cmonth }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->report_upto }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->report_date }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->twd }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->wd }}</td>
                                  
                                </tr>
                            @endforeach
                        </table>
                </header>
                </div>
            </section>
        </div>
    </div>

   

    <div class="row">

        <div class="col-sm-12">
            <section class="panel" id="data_table">
                <header class="panel-heading" style="background-color: #fde9d9;">
                    <table>
                        <tr>
                            <td style="background-color: #fde9d9; padding: 5px;">
                                <label>SM/ASM/DSM Wise Performance &nbsp; &nbsp; <span id="export_buttons"></span></label>

                                <label class="srcfl" style="text-align:right;width:800px"></label>

                            </td>
                        </tr>
                    </table>

                </header>
                <div class="panel-body">
                    <div class="adv-table  table-responsive">
                        <!-- <div id="tableOne"> -->
                        <table id="smws" class="display table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th style="background-color: #FCD5B4">SM/DSM/SSM ID</th>
                                    <th style="background-color: #FCD5B4">SM/DSM/SSM NAME</th>
                                    <th style="background-color: #FCD5B4">GM ID</th>
                                    <th style="background-color: #FCD5B4">GM</th>
                                    <th style="background-color: #FCD5B4">Product Group</th>
                                    <th style="background-color: #FCD5B4">Total Target</th>
                                    <th style="background-color: #FCD5B4">Total Sales</th>
                                    <th style="background-color: #FCD5B4">Ach%</th>
                                    <th style="background-color: #FCD5B4">Today Product Out</th>
                                    <th style="background-color: #FCD5B4">Total In-Transit</th>
                                </tr>

                            </thead>

                            <tbody>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;" colspan="5">Grand Total</th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
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
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}

    {{Html::script('public/site_resource/js/custom/script_sm_wise_sales.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}

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
       
        var url_sm = "{{url('srep/resp_sm_wise_sales')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";

        initialize_table_sm(url_sm,i_url);

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