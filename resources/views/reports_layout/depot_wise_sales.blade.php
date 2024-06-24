@extends('_layout_shared._master')
@section('title','Depot Wise Sales')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--    <link href="{{ url('public/site_resource/css/rowGroup.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>--}}

    <link href="{{ url('public/site_resource/css/fixedHeader.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

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

        .panel {
            padding-bottom: 0px;
        }

        header.panel-heading {
            color: #003399;
            padding: 0px;
        }

        .dataTables_filter {
            display: none;
        }

        .dt-buttons {
            float: right;
        }

        .p_group {
            width: 30%;
            font-size: 11px;
        }

        tr.group, tr.group:hover {
            background-color: #ddd !important;
        }

        .pocell {
            font-weight: bold;
        }

        .dataTables_scroll {
            overflow: auto;
        }

        /*#header-fixed {*/
        /*position: fixed;*/
        /*top: 50px; display:none;*/
        /*background-color:#1fb0ab;*/
        /**/
        /*width: 83%;*/
        /*padding-right: 28px;*/
        /*padding-left: 30px;*/
        /*}*/

        .header-fixed {
            width: 100%
        }

        .header-fixed > thead,
        .header-fixed > tbody,
        .header-fixed > thead > tr,
        .header-fixed > tbody > tr,
        .header-fixed > thead > tr > th,
        .header-fixed > tbody > tr > td {
            display: block;
        }

        .header-fixed > tbody > tr:after,
        .header-fixed > thead > tr:after {
            content: ' ';
            display: block;
            visibility: hidden;
            clear: both;
        }

        .header-fixed > tbody {
            overflow-y: auto;
            height: 150px;
        }

        .header-fixed > tbody > tr > td,
        .header-fixed > thead > tr > th {
            width: 20%;
            float: left;
        }

        .scrollStyle {
            overflow-x: auto;
        }

        .dataTables_filter,
        .dataTables_info {
            display: none;
        }

        .my-sticky-element.stuck {
            position:fixed;
            top:39px;
            width: 83%;
            padding-right: 28px;
            padding-left: 30px;

            /*box-shadow:0 2px 2px rgba(0, 0, 0, .2);*/
        }
        .my-sticky-element {
            z-index: 2;
        }

        @media only screen and (max-width: 600px) {
        .my-sticky-element.stuck {
            position:fixed;
            top:39px;
            width: 100%;
           /* padding-right: 28px;
            padding-left: 30px;*/

            /*box-shadow:0 2px 2px rgba(0, 0, 0, .2);*/
        }
        }

        @media screen and (max-width: 767px){
            .table-responsive {
                border: none;
        }
        }

        .p_group{
            font-weight: bold;
        }


        /*//10.4.2019-----------------------*/
        .wrapper{
            padding-top: 0px;
            /*position:fixed;*/
            /*width: 80%;*/
        }

        .panel-body{
            padding-top: 0px;
            padding-bottom: 0px;
        }

        body{
        /*overflow: hidden;*/
        }

        .panel-heading .table tbody > tr > td, .table tfoot > tr > td {
          padding: 2px;
        }

        footer{
            padding-top: 3px;
            padding-bottom: 3px;
        }


    </style>
@endsection

@section('right-content')

    <div class="row" id="fix">

        <div class="col-sm-12 col-md-12 my-sticky-element table-responsive">
            <section class="panel" id="data_table">

                <div class="table-responsive">

                    <header class="panel-heading " style="padding-bottom: 0px;">
                        <table class="display table table-bordered table-striped table-responsive"
                               style="margin-bottom: 0px;">
                            @foreach($pgwsq as $key)
                                <tr>
                                    <td style="background-color: #ADDFFF">REPORT MONTH</td>
                                    <td style="background-color: #ADDFFF">REPORT UPTO</td>
                                    <td style="background-color: #ADDFFF">REPORT DATE</td>
                                    <td style="background-color: #ADDFFF">WORKING DAYS IN MONTH</td>
                                    <td style="background-color: #ADDFFF">DAYS OVER</td>
                                    <!-- <td style="background-color:#fde4ea">REPORT MONTH</td>
                                    <td style="background-color: #C6DEFF">WORKING DAYS IN MONTH</td>
                                    <td style="background-color: #C6DEFF">DAYS OVER</td> -->
                                </tr>
                                <tr>
                                    <td style="background-color:#fde4ea">{{ $key->report_cmonth }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->report_upto }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->report_date }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->twd }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->wd }}</td>
                                   <!--  <td>{{ $key->report_pmonth }}</td>
                                    <td>{{ $key->ptwd }}</td>
                                    <td>{{ $key->pwd }}</td -->
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
                            <td style="background-color: #fde9d9; padding: 5px;"><label>Depot Wise 
                                    Sales</label> &nbsp &nbsp&nbsp <span id="export_buttons"></span></td>
                        </tr>
                    </table>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <div class="table-responsive">
                            <table id="dpot_sls" class="table table-bordered table-responsive table-striped ">
                                <thead>
                                    <tr>
                                        <th>PRODUCT GROUP</th>
                                        <th>TYPE</th>
                                        <th>DHAKA</th>
                                        <th>COMILLA</th>
                                        <th>CHITTAGONG</th>
                                        <th>CHITTAGONG SOUTH</th>
                                        <th>SYLHET</th>
                                        <th>BARISAL</th>
                                        <th>KHULNA</th>
                                        <th>RAJSHAHI</th>
                                        <th>MAGURA</th>
                                        <th>BOGRA</th>
                                        <th>RANGPUR</th>
                                        <th>MYMENSHING</th>
                                        <th>NOAKHALI</th>
                                        <th>COXBAZAR</th>
                                        <th>NARAYANGONJ</th>
                                        <th>TANGAIL</th>
                                        <th>JESSORE</th>
                                        <th>MOULOVIBAZAR</th>
                                        <th>DINAJPUR</th>
                                        <th>FENI</th>
                                        <th>BRAHMANBARIA</th>
                                        <th>PABNA</th>
                                        <th>MADARIPUR</th>
                                        <th>DHK SOUTH</th>
                                        <th>ASHULIA</th>
                                        <th>CHANDPUR</th>
                                        <th>TOTAL</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;" colspan="2">GRAND TOTAL(EXP. SALE)</th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>
                                    <th style="background-color: #CCFFCC"></th>

                                </tr>
                                <tr>
                                    <th style="background-color: #CCFFCC;" colspan="2">GRAND TOTAL(TARGET)</th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>

                                </tr>
                                <tr>
                                    <th style="background-color: #CCFFCC;" colspan="2">GRAND TOTAL(ACHI. %)</th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>
                                    <th style="background-color: #CCFFCC; text-align: right;"></th>

                                </tr>
                                </tfoot>
                            </table>

                        </div>
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



    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}

    {{Html::script('public/site_resource/js/custom/script_depot_wise_sales.js')}}

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


        var url_rm = "{{url('srep/resp_depot_wise_sales')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";
        initialize_table(url_rm, i_url);

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