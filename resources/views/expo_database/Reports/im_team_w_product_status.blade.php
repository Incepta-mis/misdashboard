<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 07/07/2020
 * Time: 11:34 AM
 */
?>
@extends('_layout_shared._master')
@section('title','IM Team Wise Product Status')
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
                       IM Team Wise Product Status
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">IM Team</label>
                                        <div class="col-md-6 col-sm-6">

                                            <select name="im_team" id="im_team"
                                                    class="form-control input-sm im_team" autocomplete="off">
                                                <option value="">SELECT TEAM</option>
                                                <option value="All">All</option>
                                                <option value="IM-1">IM-1</option>
                                                <option value="IM-2">IM-2</option>
                                                <option value="Tender">Tender</option>
                                                <option value="B2B">B2B</option>
                                                <option value="MAH">MAH/Other</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Export Country</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select name="expo_country" id="expo_country"
                                                    class="form-control input-sm m-bot15 expo_country">
                                                <option value="">Select Product Code</option>
                                                <option value="All">All</option>

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Product Name</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select name="product_name" id="product_name"
                                                    class="form-control input-sm m-bot15 product_name">
                                                <option value="">Select Name</option>
                                                <option value="All">All</option>

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">

                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 col-sm-4 control-label input-sm">Status</label>
                                                <div class="col-md-6 col-sm-6">

                                                    <select name="im_status" id="im_status"
                                                            class="form-control input-sm im_status" autocomplete="off">
                                                        <option value="">Select Status</option>
                                                        <option value="In-Process">In Process</option>
                                                        <option value="REG">Registered</option>
                                                        <option value="PERMITTED">Permitted</option>
                                                        <option value="DBAM">Dropped by Agent/MAH</option>
                                                        <option value="WFRD">Withdrawal From RA Date</option>
                                                        <option value="REJ">Rejected</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4" id="inpros" style="display: none">
                                            <div class="form-group">
                                                <label class="col-sm-4 col-sm-4 control-label input-sm">In Process Status</label>
                                                <div class="col-md-6 col-sm-6">

                                                    <select name="im_status" id="im_status"
                                                            class="form-control input-sm im_status" autocomplete="off">
                                                        <option value="">Select Status</option>
                                                        <option value="sub_to_im">Sub To IM</option>
                                                        <option value="sub_to_agent">Sub To Agent</option>
                                                        <option value="sub_to_nra">Sub To NRA</option>
                                                        <option value="defi_gen">Defi. Gen</option>
                                                        <option value="defi_close">Defi. Close</option>

                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-4">

                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-check"></i> <b>Display Report</b></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </form>
                        </div>
                    </div>
                </div>

            </section>
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

    <div class="row cnt_status-1">

        <div class="col-md-4 col-md-offset-2">
            <div class="panel" style="background-color: #C39BD3">
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Export Country  </span>
                            <h4 style="color: whitesmoke">{{ $noOfCountry[0]->no_of_country }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel " style="background-color: #4F9FCF">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-eye"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total No. of Export Product </span>
                            <h4 style="color: whitesmoke">{{ $noOfBrand[0]->brand_name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row cnt_status-2" style="display: none;">

        <div class="col-md-4 col-md-offset-2" >
            <div class="panel" style="background-color: #C39BD3">
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Export Country  </span>
                            <h4 style="color: whitesmoke"><span id="noOfCountry"></span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel " style="background-color: #4F9FCF">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-eye"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Number of Brand  </span>
                            <h4 style="color: whitesmoke"><span id="noOfBrand"></span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row states-info st-info-1">

        @foreach($cstatus as $st)

            <div @if($loop->index == 0) class="col-md-2" @else class="col-md-2" @endif >
                <div  @if($st->current_status == 'Registered') class="panel blue-bg"
                      @elseif($st->current_status == 'Permitted')  class="panel turquoise-bg"
                      @elseif($st->current_status == 'In-Process')  class="panel green-bg"
                      @elseif($st->current_status == 'Dropped')  class="panel yellow-bg"
                      @elseif($st->current_status == 'Rejected')  class="panel red-bg"
                      @elseif($st->current_status == 'Withdrawl')  class="panel turquoise-bg"
                        @endif>
                    <div class="panel-body">
                        <div class="row">
                            @if($st->current_status == 'Registered')
                                <div class="col-xs-4">
                                    <i class="fa fa-pencil"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Registered </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @elseif($st->current_status == 'Permitted')
                                <div class="col-xs-4">
                                    <i class="fa fa-check-circle"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Permitted </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @elseif($st->current_status == 'In-Process')
                                <div class="col-xs-4">
                                    <i class="fa fa-tag"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> In-Process </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>

                            @elseif($st->current_status == 'Dropped')
                                <div class="col-xs-4">
                                    <i class="fa fa-trash-o"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Dropped </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @elseif($st->current_status == 'Rejected')
                                <div class="col-xs-4">
                                    <i class="fa fa-trello"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Rejected </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @elseif($st->current_status == 'Withdrawl')
                                <div class="col-xs-4">
                                    <i class="fa fa-external-link-square"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Withdrawl </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
    <div class="row states-info st-info-2" style="display: none;">
        <div class="col-md-12">
            <div class="row states-info">
                <div class="col-md-2">
                    <div class="panel blue-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Registered </span>
                                    <h4><span id="reg"> 0 </span></h4>
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
                                    <h4><span id="per"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel green-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  In-Process  </span>
                                    <h4><span id="inp"> 0 </span></h4>
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
                                    <h4><span id="drp"> 0 </span></h4>
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
                                    <h4><span id="rej"> 0 </span></h4>
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
                                    <h4> <span id="wid"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <th>IM_TEAM</th>
                                    <th>EXPORT_COUNTRY</th>
                                    <th>PRODUCT_NAME</th>
                                    <th>CURRENT_STATUS</th>
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

            $('.im_team').select2();
            $('.product_name').select2();
            $('.im_status').select2();

            $('.im_team').on('change', function () {
                var im_team = $('.im_team').val();

                $('.expo_country').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/ImGetExpoCountry') }}",
                    data: {im_team: im_team,"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data.expoCountryData);
                        if ((data.expoCountryData.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Country</option>';
                            op += '<option value="All" >All</option>';
                            for (var i = 0; i < data.expoCountryData.length; i++) {
                                op += '<option value= " ' + data.expoCountryData[i]['export_country'] + ' ">' + data.expoCountryData[i]['export_country'] + '</option>';
                            }
                            $('.expo_country').html(" ");
                            $('.expo_country').append(op);

                        } else {
                            $('.expo_country').html(" ");
                            $('.expo_country').append('<option value="0" selected disabled>No Country available in this Category</option>');
                        }
                    },
                    error: function () {
                    }
                });

            });

            $('.expo_country').select2();

            $('.expo_country').on('change', function () {
                var expo_country = $('.expo_country').val();
                var im_team = $('.im_team').val();

                $('.product_name').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/ImGetExpoProduct') }}",
                    data: {expo_country: expo_country,im_team:im_team,"_token": "{{ csrf_token() }}"},
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


            $('.product_name').on('change', function () {
                var product_name = $('.product_name').val();

                $('.im_status').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/ImGetProductStatus') }}",
                    data: {product_name: product_name,"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data);

                        if ((data.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Status</option>';
                            op += '<option value="All" >All</option>';
                            for (var i = 0; i < data.length; i++) {
                                op += '<option value= " ' + data[i] + ' ">' + data[i] + '</option>';
                            }
                            $('.im_status').html(" ");
                            $('.im_status').append(op);

                        } else {
                            $('.im_status').html(" ");
                            $('.im_status').append('<option value="0" selected disabled>No Product Status .</option>');
                        }
                    },
                    error: function () {
                    }
                });
            });



            $("#btn_display").click(function () {

                $("#loader").show();

                $(".st-info-1").hide();
                $(".st-info-2").show();

                $(".cnt_status-1").hide();
                $(".cnt_status-2").show();

                $('#noOfCountry').html(0);
                $('#noOfBrand').html(0);

                $('#reg').html(0);
                $('#per').html(0);
                $('#inp').html(0);
                $('#rej').html(0);
                $('#drp').html(0);
                $('#wid').html(0);

                var expo_country = $('.expo_country').val();
                var im_team = $('.im_team').val();
                var im_status = $('.im_status').val();
                var product_name = $('.product_name').val();

                var data = {im_team: im_team, expo_country : expo_country,im_status:im_status,
                    product_name:product_name,"_token": "{{ csrf_token() }}"};

                var table;

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('expo/report/getIMStatusResult') }}",
                    success: function (resp) {
                        console.log("Success Data : ", resp);
                        $("#loader").hide();
                        $("#report-body").show();


                        $('#noOfCountry').html(resp['noOfCountry'][0]['no_of_country']);
                        $('#noOfBrand').html(resp['noOfBrand'][0]['brand_name']);

                        $.each(resp['ssStatus'], function (i,j) {
                            console.log(i,'=>',j);
                            if(j.current_status === 'Registered'){
                                $('#reg').html(j.status);
                            }else if(j.current_status === 'Permitted'){
                                $('#per').html(j.status);
                            }else if(j.current_status === 'In-Process'){
                                $('#inp').html(j.status);
                            }else if(j.current_status === 'Dropped'){
                                $('#drp').html(j.status);
                            }else if(j.current_status === 'Rejected'){
                                $('#rej').html(j.status);
                            }else if(j.current_status === 'Withdrawl'){
                                $('#wid').html(j.status);
                            }

                        });

                        $("#blk_list").DataTable().destroy();
                        $('#blk_list').DataTable({
                            data: resp['rs'],
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'
                            ],
                            columns: [
                                {data: null},
                                {data: "im_team"},
                                {data: "export_country"},
                                {data: "expo_product_name"},
                                {data: "current_status"},
                                {data: "date"},
                            ],
                            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                //debugger;
                                var index = iDisplayIndexFull + 1;
                                $("td:first", nRow).html(index);
                                return nRow;
                            },
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
                    }
                });

            });
        });
    </script>

@endsection