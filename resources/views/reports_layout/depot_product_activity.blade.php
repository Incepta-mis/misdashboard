<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 9/25/2019
 * Time: 2:07 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Depot Product Activity')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/clockpicker/jquery-clockpicker.min.css')}}" rel="stylesheet"
          type="text/css"/>


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


    </style>

@endsection

@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Depot Product Activity
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="comp"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Depot</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="depot" name="depot"
                                                        class="form-control input-sm filter-option pull-left depot">
                                                    <option selected disabled>Select Depot</option>
                                                    @foreach($depots as $c)
                                                        <option value="{{$c->d_id}}">{{$c->depot_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Group</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="group" name="group"
                                                        class="form-control input-sm filter-option pull-left group">
                                                    <option value="">Select Group</option>
                                                    @foreach($groups as $g)
                                                        <option value="{{$g->p_group}}">{{$g->p_group}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Working Date</b></label>
                                            <div class="col-md-7 col-sm-7">
                                                <input type="text" class="form-control input-sm" name="wdt"
                                                       id="date1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                    <button type="button" id="btn_submit" class="btn btn-warning btn-sm">
                                        <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                </div>
                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                    <div id="export_buttons">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
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


        <div class="row" >
            <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12">
                            <table id="elr" width="100%"
                                   class="table table-bordered table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>D_ID</th>
                                    <th>NAME</th>
                                    <th>Work.Date</th>
                                    <th>P_GROUP</th>
                                    <th>TERR_ID</th>
                                    <th>P_CODE</th>
                                    <th>BRAND_NAME</th>
                                    <th>COQ</th>
                                    <th>COV</th>
                                    <th>COVD</th>
                                    <th>INT_QTY</th>
                                    <th>INT_VALUE</th>
                                    <th>SOLD_QTY</th>
                                    <th>SOLD_VALUE</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </section>
            </div>
        </div>
        </div>


    </div>
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

    {{--Time Picker--}}
    {{Html::script('public/site_resource/js/clockpicker/jquery-clockpicker.min.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">
        $(document).ready(function () {
            $(".depot").select2();
            $(".group").select2();
            $('.clockpicker').clockpicker({autoclose: true});
            $('#date1').datepicker({
                format: "dd-M-yy",
                todayHighlight: 'TRUE',
                autoclose: true,
                minDate: 0,
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {
                $('#date2').datepicker('setStartDate', $("#date1").val());
            });

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();
                $("#loader").show();
                var depot = $('#depot').val();
                var grp = $('#group').val();
                var wdt = $('#date1').val();
                console.log('Submit button Clicked', depot, grp, wdt);
                var table;


                $("#elr").DataTable().destroy();
                $.ajax({
                    type: 'post',
                    url: '{!! URL::to('srep/cmrep/getDepotActivity') !!}',
                    data: {'dept_id': depot, 'group': grp, 'wdt': wdt, '_token': "{{ csrf_token() }}"},
                    success: function (data) {

                        // console.log('msg data', data[0].emp_id);
                        console.log('msg data', data);

                        $("#showTable").show();
                        $("#loader").hide();

                        $("#elr").DataTable().destroy();

                        table = $("#elr").DataTable({
                            data: data,
                            columns: [
                                {data: "d_id"},
                                {data: "depot_name"},
                                {data: "wdate"},
                                {data: "p_group"},
                                {data: "terr_id"},
                                {data: "p_code"},
                                {data: "brand_name"},
                                {data: "coq"},
                                {data: "cov"},
                                {data: "covd"},
                                {data: "int_qty"},
                                {data: "int_value"},
                                {data: "sold_qty"},
                                {data: "sold_value"}
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: false,
                            filter: true
                        });

                        // table.fixedHeader.enable();
                        new $.fn.dataTable.Buttons(table, {
                            buttons: [
                                {
                                    extend: 'collection',
                                    text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                    buttons: [
                                        {
                                            extend: 'excel',
                                            text: 'Save As Excel',
                                            footer: true,
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }, {
                                            extend: 'pdf',
                                            text: 'Save As PDF',
                                            orientation: 'landscape',
                                            footer: true,
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'PDF';
                                                $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }
                                    ],
                                    className: 'btn btn-sm btn-primary'
                                }
                            ]
                        }).container().appendTo($('#export_buttons'));

                    },
                    error: function (e) {
                        console.log(e);
                        $("#loader").hide();
                        $("#showTable").show();
                    }
                });

            });

        });

    </script>

@endsection
