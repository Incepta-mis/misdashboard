@extends('_layout_shared._master')
@section('title','Product Group Wise Summary')
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

        td {
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

        .dataTables_filter {
            display: none;
        }

        .dt-buttons {
            float: right;
        }
        .p_group{
            width: 30%;
            font-size: 11px;
            font-weight: bold;

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
            
            /*box-shadow:0 2px 2px rgba(0, 0, 0, .2);*/
        }
        .my-sticky-element {
            z-index: 1;
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

        .tot_tar{
            text-align: right;
        }

         .tot_sal{
            text-align: right;
        }

         .tot_ach{
            text-align: center;
        }
        /*//10.4.2019*/
        .wrapper{
            padding-top: 0px;
        }

        .panel-body{
            padding-top: 0px;
        }
        .panel {
            margin-bottom: 2px;
        }
        .adv-table table tr td {
            padding: 4px;
        }

    </style>
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
                                    <td style="background-color: #ADDFFF">REPORTED DAYS</td>

                                    <td style="background-color: #98cea6">COMPARED MONTH</td>
                                    <td style="background-color: #98cea6">TOTAL WORKING DAYS</td>
                                    <td style="background-color: #98cea6">REPORT DAYS</td>
                                </tr>
                                <tr>
                                    <td style="background-color: #e6e6e6">{{ $key->report_cmonth }}</td>
                                    <td style="background-color: #e6e6e6">{{ $key->report_upto }}</td>
                                    <td style="background-color: #e6e6e6">{{ $key->report_date }}</td>
                                    <td style="background-color: #e6e6e6">{{ $key->twd }}</td>
                                    <td style="background-color: #e6e6e6">{{ $key->wd }}</td>

                                    <td style="background-color: #e4f7d6">{{ $key->report_pmonth }}</td>
                                    <td style="background-color: #e4f7d6">{{ $key->ptwd }}</td>
                                    <td style="background-color: #e4f7d6">{{ $key->pwd }}</td>
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
                            <td style="background-color: #fde9d9; padding: 5px;"><label>Product Group Wise Sales </label> &nbsp &nbsp &nbsp &nbsp<span id="export_prod" ></span></td>
                        </tr>
                    </table>
                    {{--<label style="float: left;width: 18%; background-color: #ffff00; padding: 5px;">Product Group Wise Sales</label>--}}
                    <div id="customButton" style="width: 22.7%;float: right;"></div>

                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <!-- <div id="tableOne"> -->
                        <table id="pgws" class="display table table-bordered table-striped table-responsive">
                            <thead>

                            <tr>
                                <th rowspan="2" style="background-color: #FCD5B4">GROUP</th>
                                <th rowspan="2" style="background-color: rgb(216, 228, 188)">TODAY SALES</th>
                                <th style="background-color:rgb(204, 192, 218)">Last month sales </th>
                                <th style="background-color: rgb(230, 184, 183)">Current month sales</th>
                                <th rowspan="2" style="background-color: rgb(185, 236, 234)">GROWTH %</th>

                            </tr>
                            <tr>
                                <th style="background-color:rgb(204, 192, 218)">{{ $key->pwd }} working days</th>
                                <th style="background-color: rgb(230, 184, 183)">{{ $key->wd }} working days</th>
                            </tr>

                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="background-color: #CCFFCC">Total</th>
                                <th style="background-color: #CCFFCC"></th>
                                <th style="background-color: #CCFFCC"></th>
                                <th style="background-color: #CCFFCC"></th>
                                <th class="grwth_tot_pgws" style="background-color: #CCFFCC"></th>


                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>

    </div>

    @foreach( $validViewer as $item)
            @if($item == $users)

        <div class="row">

            <div class="col-sm-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color:#fde9d9;">
                        <table>
                            <tr>
                                <td style="background-color:#fde9d9; padding: 5px;"><label>GM Wise Sales</label>&nbsp &nbsp &nbsp &nbsp<span id="export_gm" ></span></td>
                            </tr>
                        </table>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table  table-responsive">
                            <!-- <div id="tableOne"> -->
                            <table id="gmws" class="display table table-bordered table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th style="background-color: #FCD5B4">GM ID</th>
                                    <th style="background-color: #FCD5B4">GM</th>
                                    <th style="background-color: #d8e4bc">Product Group</th>
                                    <th style="background-color: #ccc0da">Total Target</th>
                                    <th style="background-color: #e6b8b7">Total Sales</th>
                                    <th style="background-color: #b9ecea">Ach%</th>
                                    <th style="background-color: rgb(230, 184, 183)">Today Product Out</th>
                                    <th style="background-color: #FCD5B4">Total In-Transit</th>
                                </tr>

                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;" colspan="3">Grand Total</th>
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
    @endif
    @endforeach


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

    {{Html::script('public/site_resource/js/custom/script_pgroup_wise_summary.js')}}
    {{Html::script('public/site_resource/js/custom/script_gm_wise_sales.js')}}

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
        var url = "{{url('srep/resp_pgroup_wise_summary')}}";
        var url_gm = "{{url('srep/resp_gm_wise_sales')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";
        initialize_table(url,i_url);
        initialize_table_gm(url_gm,i_url);

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

         $('table#smws tbody tr.group').each(function () {
                    console.log("g data "+$(this).find('td').text());

                   

                    if($(this).find('td').text()){
                       
                    }else{
                        console.log("people");
                        // $(this).css('display','false');
                        console.log($(this).closest('tr'));
                        $(this).closest('tr').remove();
                    }
         });

    </script>

@endsection