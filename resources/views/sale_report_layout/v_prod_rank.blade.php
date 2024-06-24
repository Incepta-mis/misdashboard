@extends('_layout_shared._master')
@section('title','Brand Ranking Report')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/> -->
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .table {
            color: #000000;
        }

        .brand_nam_clss {
            font-weight: bold;
        }

        .rank-clss {
            text-align: right;
            color: brown;
            /*background-color:#D8E4BC;*/
            font-weight: bold;
        }

        .m1_qty_clss, .m2_qty_clss, .m2_rep_clss, .m1_rep_clss, .m2_con_clss, .m1_con_clss, .cum_clss {
            text-align: center;
        }
        /*.buttons-excel {*/
            /*margin-left: 86%;*/
        /*}*/

        /*//10.4.2019*/
        .wrapper{
            padding-top: 0px;
            /*position:fixed;*/
            /*width: 77%;*/
        }

        .panel-body{
            padding-top: 0px;
            padding-bottom: 0px;
        }

        /*body{*/
            /*overflow: hidden;*/
        /*}*/

        footer{
            padding-top: 3px;
            padding-bottom: 3px;
        }

        .dataTables_paginate {
             padding: 0px;
        }

    </style>

@endsection
@section('right-content')
    <div class="row">

        <div class="col-sm-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label style="float: left;">Brand Ranking Report ( Depot Channel)</label>
                    <div  id="export_buttons" style="margin-left: 87%;">
                        </div>
                    <!-- <div id="customButton" style="width: 22.7%;float: right;"></div> -->
                    <!-- <br> -->
                </header>
                <div class="panel-body">
                    <div class="row">
                        <!-- <div  id="export_buttons" style="margin-left: 87%;">
                        </div> -->

                        {{--<select name="" id=""></select>--}}
                    </div>
                    <div class="adv-table table-responsive">
                        <div id="export_buttons" style="margin-left: 87%;">
                            <div class="dt-buttons btn-group">
                                <a class="btn btn-default buttons-excel buttons-html5 btn-sm btn-primary"
                                   tabindex="0" href="{{ route('depotWiseProductRankExcel') }}" aria-controls="tab_prds" id="rank_excel" >
                                    <span><i class="fa fa-save"></i> Save As Excel</span></a>
                            </div>
                        </div>
                        <table id="tab_prds" class="table table-fixed-header table-fixed table-bordered table-striped "
                               width="100%">

                            <thead style="white-space:nowrap;background-color: #B0E0E6;">

                            <tr>

                                <th>Company</th>
{{--                                <th>P_Group</th>--}}
                                <th>Brand Name</th>

                                <th  colspan="2" style="background-color: #E6B8B7" class="text-center">Quantity</th>
                                <th colspan="2" style="background-color: #D8E4BC" class="text-center">Value
                                    <!-- (Crore) --></th>
                                <th style="background-color: #CCC0DA" class="text-center">Growth(Value Base)</th>
                                <th style="background-color: rgb(249, 237, 180)" colspan="2" class="text-center">
                                    Rank(Value Base)
                                </th>
                                <th style="background-color: #b9ecea" colspan="2" class="text-center">Contri%</th>
                                <th style="background-color: #FCD5B4" class="text-center">Cum%</th>
                            </tr>
                            <tr>
                                <th data-orderable="false"></th>
{{--                                <th data-orderable="false"></th>--}}
                                <th></th>
                                <th style="background-color: #E6B8B7" class="text-center">{{$mon2}}</th>
                                <th style="background-color: #E6B8B7" class="text-center">{{$mon1}}</th>
                                <th style="background-color: #D8E4BC;color: black" class="text-center">{{$mon2}}</th>
                                <th style="background-color: #D8E4BC;color: black" class="text-center">{{$mon1}}</th>
                                <th style="background-color: #CCC0DA" class="text-center">STATUS</th>
                                <th style="background-color: rgb(249, 237, 180)" class="text-center">{{$mon2}}</th>
                                <th style="background-color: rgb(249, 237, 180)" class="text-center">{{$mon1}}</th>
                                <th style="background-color: #b9ecea" class="text-center">{{$mon2}}</th>
                                <th style="background-color: #b9ecea" class="text-center">{{$mon1}}</th>
                                <th style="background-color: #FCD5B4" class="text-center">{{$mon1}}</th>
                            </tr>
                            {{--<tr>--}}
                                {{--<th> </th>--}}
                                {{--<th></th>--}}
                                {{--<th> </th>--}}
                                {{--<th></th>--}}
                                {{--<th> </th>--}}
                                {{--<th></th>--}}
                                {{--<th> </th>--}}
                       {{----}}
                            {{--</tr>--}}
                            </thead>
                            <tbody style="white-space:nowrap;">

                            </tbody>
                            <tfoot>
                            <tr style="background-color:#ccffcc;font-size: 14px;text-align: center">
                                <th style="font-size: 11px;">Subtotal</th>
{{--                                <th style="text-align:center;"></th>--}}
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:right;"></th>
                                <th style="text-align:right;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>

                            </tr>

                            <tr style="background-color:#91c4e8;font-size: 14px;text-align: center">
                                <th style="font-size: 11px;">Total</th>
{{--                                <th style="text-align:center;"></th>--}}
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:right;"></th>
                                <th style="text-align:right;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>
                                <th style="text-align:center;"></th>

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

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/custom/script_product_rank.js')}}

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
        url = "{{url('srep/resp_depot_wise_prank')}}";
        ic_up = "{{url('public/site_resource/images/up.png')}}";
        ic_down = "{{url('public/site_resource/images/down.png')}}";
        ic_loader = "{{url('public/site_resource/images/loading.gif')}}";
        equal1 = "{{url('public/site_resource/images/equal2.png')}}";


    </script>

@endsection
