<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 07/07/2020
 * Time: 11:34 AM
 */
?>
@extends('_layout_shared._master')
@section('title','IM Team Wise Generic Reports')
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
                        Generic Product Information
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">


                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Generic Name</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select name="generic_name" id="generic_name"
                                                    class="form-control input-sm m-bot15 generic_name">
                                                <option value="">Select Generic</option>
                                                @foreach($allGeneric as $val)
                                                    <option value="{{ $val->product_generic }}"> {{ $val->product_generic }} </option>
                                                @endforeach

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
                                                <option value="">Select Team</option>

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
                                                <option value="">Select Country</option>
                                                <option value="All">All</option>

                                            </select>

                                        </div>
                                    </div>
                                </div>





                                <div class="row">
                                    <div class="col-md-12 col-sm-12">

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
                                    <th>CERTIFICATE</th>
                                    <th>CERTIFICATE PATH</th>
                                    {{-- <th>DATE</th> --}}
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
            $('.generic_name').select2();
            $('.im_status').select2();
            $('.expo_country').select2();
            $('.product_name').select2();


            $('.generic_name').on('change', function () {
                var generic_name = $('.generic_name').val();

                console.log(generic_name);

                $('.im_team').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/getImTeamName') }}",
                    data: {generic_name: generic_name,"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data);

                        if ((data.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select IM Team</option>';
                            op += '<option value="All" selected >All</option>';

                            for (var i = 0; i < data.length; i++) {
                                op += '<option value= " ' + data[i].im_team + ' ">' + data[i].im_team + '</option>';
                            }
                            $('.im_team').html(" ");
                            $('.im_team').append(op);

                        } else {
                            $('.im_team').html(" ");
                            $('.im_team').append('<option value="0" selected disabled>No Product Status .</option>');
                        }
                    },
                    error: function () {
                    }
                });
            });


            $('.im_team').on('change', function () {
                var im_team = $('.im_team').val();
                var generic_name = $('.generic_name').val();

                $('.expo_country').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/ImScmGetExpoCountry') }}",
                    data: {im_team: im_team, generic_name:generic_name ,"_token": "{{ csrf_token() }}"},
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


            $('.expo_country').on('change', function () {
                var expo_country = $('.expo_country').val();
                var im_team = $('.im_team').val();
                var generic_name = $('.generic_name').val();

                $('.product_name').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/ImScmGetExpoProduct') }}",
                    data: {expo_country: expo_country,im_team:im_team, generic_name:generic_name,"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data.expoProductName);
                        if ((data.expoProductName.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected >Select Product</option>';
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
                var expo_country = $('.expo_country').val();
                var im_team = $('.im_team').val();
                var generic_name = $('.generic_name').val();

                $('.im_status').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/ImScmGetProductStatus') }}",
                    data: {product_name: product_name, expo_country:expo_country, im_team:im_team, generic_name:generic_name, "_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data);

                        if ((data.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Status</option>';
                            op += '<option selected value="All" >All</option>';
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

                var generic_name = $('.generic_name').val();
                var expo_country = $('.expo_country').val();
                var im_team = $('.im_team').val();
                var im_status = $('.im_status').val();
                var product_name = $('.product_name').val();

                var data = {im_team: im_team, expo_country : expo_country,im_status:im_status, generic_name : generic_name,
                    product_name:product_name,"_token": "{{ csrf_token() }}"};

                var table;

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('expo/report/getSCMReportOnIMDB') }}",
                    success: function (resp) {
                        console.log("Success Data : ", resp);
                        $("#loader").hide();
                        $("#report-body").show();


                        // $('#noOfCountry').html(resp['noOfCountry'][0]['no_of_country']);
                        // $('#noOfBrand').html(resp['noOfBrand'][0]['brand_name']);

                        // $.each(resp['ssStatus'], function (i,j) {
                        //     console.log(i,'=>',j);
                        //     if(j.current_status === 'Registered'){
                        //         $('#reg').html(j.status);
                        //     }else if(j.current_status === 'Permitted'){
                        //         $('#per').html(j.status);
                        //     }else if(j.current_status === 'In-Process'){
                        //         $('#inp').html(j.status);
                        //     }else if(j.current_status === 'Dropped'){
                        //         $('#drp').html(j.status);
                        //     }else if(j.current_status === 'Rejected'){
                        //         $('#rej').html(j.status);
                        //     }else if(j.current_status === 'Withdrawl'){
                        //         $('#wid').html(j.status);
                        //     }

                        // });

                        $("#blk_list").DataTable().destroy();
                        $('#blk_list').DataTable({
                            data: resp,
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'
                            ],
                            columns: [
                                {data:null},
                                {data: "im_team"},
                                {data: "export_country"},
                                {data: "expo_product_name"},
                                {data: "current_status"},
                                {data: "registration_certificate"},
                                // {data: "registration_certificate"},
                                {
                                  data : "reg_cert_path",
                                    render: function ( data, type, row, meta ) {
                                        if(data===null){
                                            return '';
                                        }else{
                                            ll = window.location.origin+"/misdashboard/public";
                                            return '<a href="'+ll+data+'" target="_blank">'+ 'Open Certificate' +'</a>';
                                        }
                                  }
                                },
                                // {data: "date"},
                            ],
                            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                //debugger;
                                var index = iDisplayIndexFull  + 1;
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