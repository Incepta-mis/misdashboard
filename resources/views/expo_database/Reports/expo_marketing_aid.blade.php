<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 07/12/2019
 * Time: 3:18 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Marketing Information Database')
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
                        Marketing Information Database
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Prod Code (Bulk)</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select name="p_code_bulk" id="p_code_bulk"
                                                    class="form-control input-sm m-bot15 p_code_bulk">
                                                <option value="">Select Product Code</option>
                                                <option value="All">All</option>
                                                @foreach($p_code_bulk as $c)
                                                    <option value="{{$c->product_code}}">{{$c->product_code}}</option>
                                                @endforeach
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
                                {{--                                <div class="col-md-4 col-sm-4 col-xs-4">--}}
                                {{--                                    <div class="form-group">--}}
                                {{--                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Prod Code (Bulk)</label>--}}
                                {{--                                        <div class="col-md-6 col-sm-6">--}}
                                {{--                                            <select name="" id=""--}}
                                {{--                                                    class="form-control input-sm m-bot15 ">--}}
                                {{--                                                <option value="">Select Expo Country</option>--}}
                                {{--                                                <option value="All">All</option>--}}
                                {{--                                                --}}{{--                                                @foreach($expo_country as $e)--}}
                                {{--                                                --}}{{--                                                    <option value="{{$e->product_code}}">{{$e->product_code}}</option>--}}
                                {{--                                                --}}{{--                                                @endforeach--}}
                                {{--                                            </select>--}}

                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                <div class="col-md-4 col-sm-4 col-xs-4">

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
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
                                    <th>PRODUCT_CODE</th>
                                    <th>PRODUCT_NAME_DOM</th>
                                    <th>EXPORT_COUNTRY</th>
                                    <th>EXPO_PRODUCT_NAME</th>
                                    <th>PRODUCT_CODE_EXPORT</th>
                                    <th>SUBMISSION_DATE</th>
                                    <th>POST_MARKETING_COMMITMENTS</th>
                                    <th>VARIATION_DATE</th>
                                    <th>VARIATION_GRANTED_REFUSED_DATE</th>
                                    <th>APPROVAL_DATE</th>
                                    <th>LAUNCHED_DATE</th>
                                    <th>EXPIRY_RENEWAL_DATE</th>
                                    <th>CURRENT_STATUS</th>
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

            $('.p_code_bulk').select2();

            $('.p_code_bulk').on('change', function () {
                let p_code_bulk = $('.p_code_bulk').val();
                let bulk_pCode = {p_code_bulk: p_code_bulk, "_token": "{{ csrf_token() }}"};

                $('.expo_country').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: "{{ url('expo/report/getExpoCountry') }}",
                    data: bulk_pCode,
                    success: function (data) {
                        console.log(data.expoCountryData);
                        if ((data.expoCountryData.length) > 0) {
                            let op = '';
                            op += '<option value="0" selected disabled>Select Country</option>';
                            for (let i = 0; i < data.expoCountryData.length; i++) {
                                op += '<option value= " ' + data.expoCountryData[i]['export_country'] + ' ">' + data.expoCountryData[i]['export_country'] + '</option>';
                            }
                            $('.expo_country').html(" ");
                            $('.expo_country').append(op);

                        } else {
                            $('.expo_country').html(" ");
                            $('.expo_country').append('<option value="0" selected disabled>No Department available in this Category</option>');
                        }
                    },
                    error: function () {
                    }
                });

            });

            $('.expo_country').select2();

            $("#btn_display").click(function () {

                $("#loader").show();

                let p_code_bulk = $('.p_code_bulk').val();
                let expo_country = $('.expo_country').val();
                let data = {p_code_bulk: p_code_bulk, expo_country : expo_country, "_token": "{{ csrf_token() }}"};

                let table;

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('expo/report/getExpoMarketingAID') }}",
                    success: function (resp) {
                        console.log("Success Data : ", resp);
                        $("#loader").hide();
                        $("#report-body").show();


                        $("#blk_list").DataTable().destroy();
                        $('#blk_list').DataTable({
                            data: resp,
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'
                            ],
                            columns: [
                                {data: "srno"},
                                {data: "product_code"},
                                {data: "product_name_dom"},
                                {data: "export_country"},
                                {data: "product_name_expo"},
                                {data: "product_code_export"},
                                {data: "submission_date"},
                                {data: "post_marketing_commitments"},
                                {data: "variation_date"},
                                {data: "variation_granted_refused_date"},
                                {data: "approval_date"},
                                {data: "launched_date"},
                                {data: "expiry_renewal_date"},
                                {data: "current_status"}
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
                    }
                });

            });
        });
    </script>

@endsection