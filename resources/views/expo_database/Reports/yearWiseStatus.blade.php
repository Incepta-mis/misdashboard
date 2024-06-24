<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 07/07/2020
 * Time: 11:34 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Year Wise Country submission status')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

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
            padding: 2px;
            font-size: 10px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 10px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 10px;
        }

        body {
            color: black;
        }

        .help-block {
            color: red;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        input[type=file]::-webkit-file-upload-button {
            width: 0;
            padding: 0;
            margin: 0;
            -webkit-appearance: none;
            border: none;
            border: 0px;
        }

        x::-webkit-file-upload-button, input[type=file]:after {
            content: 'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border: 0px;
        }

        input {
            color: black;
            font-size: x-small;
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .modal-dialog {
            width: 98%;
            height: 92%;
            padding: 0;
        }

        .modal-content {
            height: 99%;
        }

        .btn.disabled {
            pointer-events: none;
        }

        @media print {
            .header-print {
                display: table-header-group;
            }
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Year Wise Country submission status
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-horizontal" method="get" action="">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 col-sm-4 control-label input-sm">Year</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select name="year" id="year"
                                                            class="form-control input-sm m-bot15 year">
                                                        <option value="">Select Year</option>
                                                        <option value="All">All</option>
                                                        @foreach($rs as $c)
                                                            <option value="{{$c->year}}">{{$c->year}}</option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 col-sm-4 control-label input-sm">Status</label>
                                                <div class="col-md-6 col-sm-6">

                                                    <select name="im_status" id="im_status"
                                                            class="form-control input-sm im_status" autocomplete="off">
                                                        <option value="">Select Status</option>
                                                        <option value="All">All</option>
                                                        <option value="Defi_Gen">Defi_Gen</option>
                                                        <option value="Defi_Close">Defi_Close</option>
                                                        <option value="Sub To NRA">Sub To NRA</option>
                                                        <option value="Sub To AGENT">Sub To AGENT</option>
                                                        <option value="Sub To IM">Sub To IM</option>
                                                        <option value="Registered">Registered</option>
                                                        <option value="Permitted">Permitted</option>
                                                        <option value="Dropped">Dropped by Agent/MAH</option>
                                                        <option value="Withdrawl">Withdrawal From RA Date</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 col-sm-4 control-label input-sm">Product
                                                    Name</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select name="product_name" id="product_name"
                                                            class="form-control input-sm m-bot10 product_name">
                                                        <option value="">Select Name</option>
                                                        <option value="All">All</option>

                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 col-sm-4 control-label input-sm">Export
                                                    Country</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select name="expo_country" id="expo_country"
                                                            class="form-control input-sm m-bot15 expo_country">
                                                        <option value="">Select Country</option>
                                                        <option value="All">All</option>


                                                    </select>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 col-sm-4 control-label input-sm">IM Team</label>
                                                <div class="col-md-6 col-sm-6">

                                                    <select name="im_team" id="im_team"
                                                            class="form-control input-sm im_team" autocomplete="off">
                                                        <option value="">SELECT TEAM</option>
                                                        <option value="All">All</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-sm-4 col-xs-4">

                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_display"
                                                            class="btn btn-warning btn-sm">
                                                        <i class="fa fa-check"></i> <b>Display Report</b></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>


    
    <div class="row" id="sumInfo-1">
        <div class="col-md-12">
            <div class="row states-info">
                <div class="col-md-offset-1 col-md-2">
                    <div class="panel blue-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Registered </span>
                                    <h4><span> @if($status[0]->registered == null) 0 @else{{ $status[0]->registered }} @endif </span></h4>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel turquoise-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Permitted </span>
                                    <h4> <span>@if($status[0]->permitted == null) 0 @else{{ $status[0]->permitted }} @endif </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel yellow-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-trash-o"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">Dropped</span>
                                    <h4><span> @if($status[0]->dropped == null) 0 @else{{ $status[0]->dropped }} @endif  </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel red-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-trello"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Rejected  </span>
                                    <h4><span> @if($status[0]->rejected == null) 0 @else{{ $status[0]->rejected }} @endif</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel turquoise-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-external-link-square"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Withdrawal </span>
                                    <h4> <span> @if($status[0]->withdrawl == null) 0 @else{{ $status[0]->withdrawl }} @endif</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row states-info">
            <div class="col-md-offset-1 col-md-2">
                <div class="panel green-bg">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Sub TO IM </span>
                                <h4><span > @if($status[0]->sub_to_im == null) 0 @else{{ $status[0]->sub_to_im }} @endif</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel" style="background-color: #14DAEA">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-9">
                                <span class="state-title">  Sub TO Agent </span>
                                <h4><span >  @if($status[0]->sub_to_agent == null) 0 @else{{ $status[0]->sub_to_agent }} @endif</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel" style="background-color: #0eb66a">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-9">
                                <span class="state-title">  Sub TO NRA </span>
                                <h4><span > @if($status[0]->sub_to_nra == null) 0 @else{{ $status[0]->sub_to_nra }} @endif</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel" style="background-color: #AD53F0">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-9">
                                <span class="state-title">  Defi. Gen </span>
                                <h4><span id=""> @if($status[0]->defi_gen == null) 0 @else{{ $status[0]->defi_gen }} @endif </span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel" style="background-color: #EA6814">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-9">
                                <span class="state-title">  Defi. Close </span>
                                <h4><span id="">  @if($status[0]->defi_close == null) 0 @else{{ $status[0]->defi_close }} @endif </span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div id="sumInfo-2" style="display: none;">
        <div class="col-md-12">
            <div class="row states-info">
                <div class="col-md-offset-1 col-md-2">
                    <div class="panel blue-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Registered </span>
                                    <h4><span id="reg">    </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel turquoise-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Permitted </span>
                                    <h4><span id="per">    </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel yellow-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-trash-o"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">Dropped</span>
                                    <h4><span id="drp">    </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel red-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-trello"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Rejected  </span>
                                    <h4><span id="rej"> </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel turquoise-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-external-link-square"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Withdrawal </span>
                                    <h4> <span id="wdl">  </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="row states-info">
                <div class="col-md-offset-1 col-md-2">
                    <div class="panel green-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Sub TO IM </span>
                                    <h4><span id="stoim">  </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel" style="background-color: #14DAEA">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <div class="col-xs-9">
                                    <span class="state-title">  Sub TO Agent </span>
                                    <h4><span id="stoAgent"> </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel" style="background-color: #0eb66a">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <div class="col-xs-9">
                                    <span class="state-title">  Sub TO NRA </span>
                                    <h4><span id="stoNRA">  </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel" style="background-color: #AD53F0">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-9">
                                <span class="state-title">  Defi. Gen </span>
                                <h4><span id="defiGen">  </span></h4>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-2">
                    <div class="panel" style="background-color: #EA6814">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <div class="col-xs-9">
                                    <span class="state-title">  Defi. Close </span>
                                    <h4><span id="defiClose">  </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>SL</th>
                                    <th>YEAR</th>
                                    <th>IM_TEAM</th>
                                    <th>EXPORT_COUNTRY</th>
                                    <th>AGENT_COMPANY</th>
                                    <th>PRODUCT_NAME</th>
                                    <th>STATUS</th>
                                    <th>DATE</th>




                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>

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
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}



    <script type="text/javascript">

        $(document).ready(function () {

            $('.year').select2();

            $('.im_status').select2();

            $('.expo_country').select2();
          

            $('.im_status').on('change', function () {
                var im_status = $('.im_status').val();
                var year = $('.year').val();


                $('.product_name').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/getYearWiseProductName') }}",
                    data: {im_status: im_status, year : year, "_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data.expoProductName);
                        if ((data.expoProductName.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Product</option>';
                            op += '<option value="All">All</option>';
                            for (var i = 0; i < data.expoProductName.length; i++) {
                                op += '<option value= " ' + data.expoProductName[i]['expo_product_name'] + ' ">' + data.expoProductName[i]['expo_product_name'] + '</option>';
                            }
                            $('.product_name').html(" ");
                            $('.product_name').append(op);

                        } else {
                            $('.product_name').html(" ");
                            $('.product_name').append('<option value="0" selected disabled>No Product available in this Category</option>');
                        }
                    },
                    error: function () {
                    }
                });

            });

            $('.product_name').select2();


            $('.product_name').on('change', function () {
                var product_name = $('.product_name').val();



                console.log(product_name);

                $('.expo_country').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/getYearWiseExpoCountry') }}",
                    data: {product_name: product_name,"_token": "{{ csrf_token() }}"},
                    success: function (data) {

                        console.log(data.countries[0]);

                        if ((data.countries.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Country</option>';
                            op += '<option value="All">All</option>';
                            for (var i = 0; i < data.countries.length; i++) {
                                op += '<option value= " ' + data.countries[i]['export_country'] + ' ">' + data.countries[i]['export_country'] + '</option>';
                            }
                            $('.expo_country').html(" ");
                            $('.expo_country').append(op);

                        } else {
                            $('.expo_country').html(" ");
                            $('.expo_country').append('<option value="0" selected disabled>No Product available in this Category</option>');
                        }
                    },
                    error: function () {
                    }
                });

            });


            $('.expo_country').on('change', function () {
                var expo_country = $('.expo_country').val();


                $('.im_team').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/getYearWiseExpoTeam') }}",
                    data: {expo_country: expo_country,"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data.imTeamName);
                        if ((data.imTeamName.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Team</option>';
                            op += '<option value="All">All</option>';
                            for (var i = 0; i < data.imTeamName.length; i++) {
                                op += '<option value= " ' + data.imTeamName[i]['im_team'] + ' ">' + data.imTeamName[i]['im_team'] + '</option>';
                            }
                            $('.im_team').html(" ");
                            $('.im_team').append(op);

                        } else {
                            $('.im_team').html(" ");
                            $('.im_team').append('<option value="0" selected disabled>No Product available in this Category</option>');
                        }
                    },
                    error: function () {
                    }
                });

            });




            $("#btn_display").click(function () {

                $("#sumInfo-1").hide();
                $("#loader").show();
               

                var year = $('.year').val();
                var expo_country = $('.expo_country').val();
                var product_name = $('.product_name').val();
                var im_status = $('.im_status').val();
                var im_team = $('.im_team').val();

                var data = { expo_country : expo_country, im_status : im_status,
                    product_name:product_name, im_team: im_team , year : year , "_token": "{{ csrf_token() }}"};

                var table;

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('expo/report/getYearWiseExpoResult') }}",
                    success: function (resp) {
                        console.log("Success Data : ", resp);
                        $("#loader").hide();                       
                        
                        $("#sumInfo-2").show();


                        $.each(resp['ssStatus'], function (i,j) {
                            console.log(i,'=>',j);


                                $('#reg').html( j.registered ? j.registered : '0' );
                                $('#per').html( j.permitted ? j.permitted : '0' );
                                $('#stoim').html( j.sub_to_im ? j.sub_to_im : '0' );
                                $('#stoAgent').html( j.sub_to_agent ? j.sub_to_agent : '0' );
                                $('#stoNRA').html( j.sub_to_nra ? j.sub_to_nra : '0' );
                                $('#drp').html( j.dropped ? j.dropped : '0' );
                                $('#rej').html( j.rejected ? j.rejected : '0' );
                                $('#wdl').html( j.withdrawl ? j.withdrawl : '0' );
                                $('#defiClose').html( j.defi_close ? j.defi_close : '0' );
                                $('#defiGen').html( j.defi_gen ? j.defi_gen : '0' );


                        });


                        $("#report-body").show();



                        $("#blk_list").DataTable().destroy();
                        $('#blk_list').DataTable({
                            data: resp['rs'],
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'
                            ],
                            columns: [
                                {
                                    data: null,
                                    render: function (data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
                                    }
                                },
                                {data: "year"},
                                {data: "im_team"},
                                {data: "export_country"},
                                {data: "company_agent_name"},
                                {data: "expo_product_name"},
                                {data: "current_status"},
                                {data: "status_date"},




                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: true,
                            filter: true
                        });


                    },
                    error: function (err) {
                        $("#loader").hide();
                        $("#report-body").show();
                        $("#sumInfo-2").hide();

                    }
                });

            });
        });
    </script>

@endsection