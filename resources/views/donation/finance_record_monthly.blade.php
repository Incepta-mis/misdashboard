<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/8/2018
 * Time: 5:18 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Finance Record')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>

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
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
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

        /*input {*/
            /*color: black;*/
            /*font-size: x-small;*/
        /*}*/

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }



        /*.fnt_size {*/
            /*font-size: 12px;*/
            /*text-align: left;*/
        /*}*/

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }


    </style>


@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Finance Record
                    </label>
                </header>

                <div class="panel-body hd">

                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <form class="form-horizontal" name="myForm"  role="form" id="appfrm" >

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date" class="col-md-2 control-label fnt_size"><b>Range of Months</b></label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control input-sm" name="st_dt"
                                                       style="padding-right: 0px;" id="date1" autocomplete="off">
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" class="form-control input-sm"
                                                       style=""
                                                       name="en_dt" id="date2" autocomplete="off">
                                            </div>

                                        <div class="col-md-1">
                                            <button type="button" id="btn_submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Submit</b></button>
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
                            <table id="req_ccwise" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Month</th>
                                    <th>Total Requests</th>
                                    <th>Total Amount</th>
                                    <th>Cash Req</th>
                                    <th>Cash Amount</th>
                                    <th>Cheque Req</th>
                                    <th>Cheque Amount</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    {{--@endif--}}

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script>

        servloc = "{{url('donation/finance_record_data')}}";
        _csrf_token = '{{csrf_token()}}';

        $(document).ready(function () {

            $('#date1').datepicker({
                format: "dd-M-yy",
                todayHighlight: 'TRUE',
                autoclose: true,
                startView: "months",
                minViewMode: "months",
                minDate: 0,
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {
                $('#date2').datepicker('setStartDate', $("#date1").val());
            });

            $('#date2').datepicker({
                format: "dd-M-yy",
                todayHighlight: 'TRUE',
                autoclose: true,
                startView: "months",
                minViewMode: "months",
                minDate: '0',
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {

                var d1 = $('#date1').datepicker('getDate');
                var d2 = $('#date2').datepicker('getDate');
                var diff = 0;
                if (d1 && d2) {
                    diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                }
                $('#dol').val(diff);
            });


            $('#btn_submit').click(function () {
                // e.preventDefault();
                console.log($('#date1').val());
                console.log($('#date2').val());

                if ($("#date1").val() === "") {
                    toastr.info("Please select Month");
                }
                else if ($("#date2").val() === "") {
                    toastr.info("Please select Month");
                }
                else {
                    var month_from = $("#date1").val();
                    var month_to = $("#date2").val();

                    $("#loader").show();

                    console.log(month_from);
                    console.log(month_to);

                    $.ajax({
                        method:'post',
                        url:servloc,
                        data: {
                            month_from: month_from,
                            month_to:month_to,
                            _token: _csrf_token
                        },
                        success: function (resp) {

                            console.log(resp);

                            $("#loader").hide();
                            $("#report-body").show();


                            $("#req_ccwise").DataTable().destroy();
                            var table = $("#req_ccwise").DataTable({
                                data: resp,
                                "ordering": false,
                                columns: [
                                    {"orderable": false,
                                        data: "payment_month"
                                    },
                                    {data: "total_no_of_req"},
                                    {data: "app_amt",
                                        render: $.fn.dataTable.render.number(',', 3)},
                                    {data: "cash_req"},
                                    {data: "cash_req_amt",
                                        render: $.fn.dataTable.render.number(',', 3)},
                                    {data: "cheque_req"},
                                    {data: "cheque_req_amt",
                                        render: $.fn.dataTable.render.number(',', 3)}
                                ],



                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },

                                info: false,
                                paging: false,
                                filter: false,



                            });


                        },
                        error: function (err) {
                            // console.log(err);
                            $("#loader").hide();
                            $("#report-body").show();
                        }

                    });


                }

            });

        });





    </script>

@endsection

