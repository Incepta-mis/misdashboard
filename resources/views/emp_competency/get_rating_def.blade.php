@extends('_layout_shared._master')
@section('title','Rating Definition')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
        /*.panel-heading {*/
            /*padding: 5px 15px 2px 15px;*/
            /*margin-bottom: 0px;*/
        /*}*/

        /*.form-control {*/
            /*border-radius: 0px;*/
        /*}*/

        /*.input-group-addon {*/
            /*border-radius: 0px;*/
        /*}*/

        /*.table > thead > tr > th {*/
            /*padding: 4px;*/
            /*font-size: 12px;*/

        /*}*/

        /*.table > tbody > tr > td {*/
            /*padding: 4px;*/
            /*font-size: 11px;*/
        /*}*/
        /*.table > tfoot > tr > td {*/
            /*padding: 4px;*/
            /*font-size: 12px;*/
            /*color: #1fb5ac;*/
            /*font-weight: bold;*/
        /*}*/

        body{
            color: black;
        }

        /*.table-bordered>thead>tr>th{*/
            /*border: 1px solid #0e0d0d;*/
        /*}*/
        /*.table-bordered>tbody>tr>td{*/
            /*border: 1px solid #0e0d0d;*/
        /*}*/
        /*.table-bordered{*/
            /*border: 1px solid #0e0d0d;*/
        /*}*/
        /*.table-bordered > tfoot > tr > td {*/
            /*border: 1px solid #0e0d0d;*/
        /*}*/
        /*#loading-img {*/
            /*background: url(http://preloaders.net/preloaders/360/Velocity.gif) center center no-repeat;*/
            /*height: 100%;*/
            /*z-index: 20;*/
        /*}*/

        /*.overlay {*/
            /*!*background: #e9e9e9;*!*/
            /*display: none;*/
            /*position: absolute;*/
            /*top: 0;*/
            /*right: 0;*/
            /*bottom: 0;*/
            /*left: 0;*/
            /*opacity: 0.5;*/
        /*}*/

        /*.form-control{*/
            /*padding:1px 0px;*/

        /*}*/

        /*#dvsr_data button,input,select,textarea{*/
            /*font-size:10px;*/
            /*color:black*/
        /*}*/
        /*#dvsr_data th{*/
            /*font-size:13px;*/
            /*background-color: #CDC1A7;*/
        /*}*/

        /*textarea{*/
            /*margin: 1px 1px;*/
            /*width: 81px;*/
            /*height: 33px;*/
        /*}*/

        /*.error {*/
            /*border: solid 2px #FF0000;*/
        /*}*/

        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #101010;
        }


        tr.c1 { background-color: #DCE6F1; }
        tr.c2 { background-color: #FDE9D9; }
        tr.c3 { background-color: #E4DFEC; }
        tr.c4 { background-color: #DDD9C4; }
        tr.c5 { background-color: #C5D9F1; }

    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <!-- <header class="panel-heading">
                    <label class="text-primary">
                        Rating Definition
                    </label>
                </header> -->
                <div class="panel-body">
                    <table class="table table-responsive table-bordered">
                       
                        <tbody>

                        <tr>
                            <td colspan="2"><center><h4><b>Rating Definition</b></h4></center></td>
                        </tr>

                        <?php $k=0; ?>

                        @foreach($data_ratings as $rating)

                            <?php
                            if($k==5){
                                $k=0;
                            }
                            $k++; ?>
                            <tr class="c<?php echo $k;?>">
                                <td><span style="font-weight: bold">{{$rating->eratc_type}}</span></td>
                                <td>{{$rating->eratc_definition}}</td>

                            </tr>
                        @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!-- <div class="col-sm-2 col-md-2">
            <section class="panel" id="data_table">

                <div class="panel-body" id="summary_tour_table">

                </div>
            </section>
        </div> -->
    </div>

    <!-- <div class="row" id="report-body">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive" id="search_div_id">

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div> -->
    

    @include('expense.modal.edit_expense_verify_data')
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>--}}
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    <script type="text/javascript">

        $(document).ready(function(){ });

    </script>

@endsection
