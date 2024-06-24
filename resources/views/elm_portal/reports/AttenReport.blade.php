<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 8/31/2019
 * Time: 2:25 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Attendance Report')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/clockpicker/jquery-clockpicker.min.css')}}" rel="stylesheet" type="text/css"/>


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
                        Attendance Reports
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
                                                   style="padding-right:0px;"><b>Company</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="comp" name="comp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled>Select Company</option>
                                                    @foreach($com as $c)
                                                        <option value="{{$c->com_id}}">{{$c->com_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="plant" name="plant"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Plant</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Department</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="dept" name="dept"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Department</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="emp" class="col-md-2 col-sm-2 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Employee</b></label>
                                            <div class="col-md-10 col-sm-10">
                                                <select id="emp" name="emp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Employee</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="date" class="col-md-2 col-sm-2 control-label fnt_size"><b>Date
                                                    </b></label>
                                            <div class="col-sm-4 col-md-4">
                                                <input type="text" autocomplete="off" class="form-control input-sm" name="st_dt"
                                                       style="font-size: x-small; padding-right: 0px;" id="date1">
                                            </div>

                                            <div class="col-sm-4 col-md-4">
                                                <input type="text" autocomplete="off" class="form-control input-sm"
                                                       style="font-size: x-small;"
                                                       name="en_dt" id="date2">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
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
                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                    <div id="export_buttons">

                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12">
                            <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>EMP ID</th>
                                    <th>NAME</th>
                                    <th>DESIGNATION</th>
                                    <th>DEPT</th>
                                    <th>DATE</th>
                                    <th>START TIME</th>
                                    <th>IN TIME</th>
                                    <th>END TIME</th>
                                    <th>OUT TIME</th>
                                    <th>STATUS</th>
                                    <th>WORKING HOURS</th>
                                    <th>COMPLETED</th>
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


            $('.clockpicker').clockpicker({ autoclose: true });
            $('.clockpicker2').clockpicker({ autoclose: true });

            $('#date1').datepicker({
                format: "dd-M-yyyy",
                todayHighlight: 'TRUE',
                autoclose: true,
                minDate: 0,
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {
                $('#date2').datepicker('setStartDate', $("#date1").val());
            });

            $('#date2').datepicker({
                format: "dd-M-yyyy",
                todayHighlight: 'TRUE',
                autoclose: true,
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



            // $("#date1").select2();
            // $("#date2").select2();

            //Changing company from option
            $('#comp').change(function () {
                $('#plant').empty();
                $('#dept').empty();
                $('#emp').empty();
                $('#plant').append($('<option></option>').html('Loading...'));

                var comp_id = $('#comp').val();
                $.ajax({
                    type: 'get',
                    url: '{!!URL::to('elm_portal/get_plant_id') !!}',
                    data: {'c_id': comp_id},
                    success: function (data) {
                        // console.log(data.plant);
                        var op = '';
                        op += '<option value="0" selected disabled>Select Plant</option>';
                        for (var i = 0; i < data.plant.length; i++) {
                            op += '<option value="' + data.plant[i]['plant_id'] + '">' + data.plant[i]['plant_name'] + '</option>';
                        }
                        $('#plant').html(" ");
                        $('#plant').append(op);
                    },
                    error: function () {

                    }
                });
            });

            // Changing plant option started here
            $('#plant').change(function () {
                $('#dept').empty();
                $('#emp').empty();
                $('#dept').append($('<option></option>').html('Loading...'));

                var plant_id = $('#plant').val();
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('elm_portal/get_dept') !!}',
                    data: {'plant_id': plant_id},
                    success: function (data) {
                        // console.log(data.dept);
                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            for (var i = 0; i < data.dept.length; i++) {
                                op += '<option value= " ' + data.dept[i]['dept_id'] + ' ">' + data.dept[i]['dept_name'] + '</option>';
                            }
                            $('#dept').html(" ");
                            $('#dept').append(op);

                        }
                        else {
                            $('#dept').html(" ");
                            $('#dept').append('<option value="0" selected disabled>No Department available in this Category</option>');
                            // console.log("no data found");
                        }
                    },
                    error: function () {
                    }
                });
            });

            // Changing Dept option started here
            $('#dept').change(function () {
                $('#emp').empty().append($('<option></option>').html('Loading...'));
                var dept_id = $('#dept').val();

                // console.log('dept_id',dept_id);

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('elm_portal/getDeptEmp') !!}',
                    data: {'dept_id': dept_id},
                    success: function (data) {
                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Employees</option>';
                            em += '<option value="All">All</option>'
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['emp_id'] + ' ">' + data[i]['emp_id'] + '-' + data[i]['sur_name'] + '</option>';
                            }
                            $('#emp').html(" ");
                            $('#emp').append(em);

                        }
                        else {
                            $('#emp').html(" ");
                            $('#emp').append('<option value="0" selected disabled>No Employee available in this Category</option>');
                            // console.log("no data found");
                        }
                    },
                    error: function () {
                    }
                });

            });

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();
                $("#loader").show();
                var pl = $('#plant').val();
                var dpt = $('#dept').val();
                var emp = $('#emp').val();
                var date_1 = $('#date1').val();
                var date_2 = $('#date2').val();
                console.log('Submit button Clicked', pl, dpt, emp);
                var table;
                $.ajax({
                    type: 'post',
                    url: '{!! URL::to('elm_portal/getAttRpt') !!}',
                    data: {'dept_id': dpt, 'plant_id': pl, 'emp_id': emp, 'dt_1' : date_1, 'dt_2': date_2 ,'_token': "{{ csrf_token() }}"},
                    success: function (data) {

                        // console.log('msg data', data[0].emp_id);
                        // console.log('msg data', data);

                        $("#showTable").show();
                        $("#loader").hide();

                        $("#elr").DataTable().destroy();
                        table = $("#elr").DataTable({
                            data: data,
                            dom: 'Bfrtip',
                            buttons: [
                                'excelHtml5'
                            ],
                            columns: [
                                {data: "emp_id"},
                                {data: "emp_name"},
                                {data: "desig_name"},
                                {data: "dept_name"},
                                {data: "working_date"},
                                {data: "scedule_start_time"},
                                {data: "first_in_time"},
                                {data: "scedule_end_time"},
                                {data: "last_out_time"},
                                {data: "working_status"},
                                {data: "working_hour"},
                                {data: "completed"}

                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: false,
                            filter: true
                        });

                        table.fixedHeader.enable();
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

            jQuery('.toggle-btn').click(function () {
                table.fixedHeader.enable();
            });
        });
    </script>

@endsection
