<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 5/4/2019
 * Time: 3:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Employee Wise Report')
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

    <!-- <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.css"> -->

    <link href="{{ url('public/site_resource/css/bootstrap-lightbox.min.css')}}" rel="stylesheet" type="text/css"/>

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
            font-size: 9px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 9px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 9px;
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

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Employee Wise Result
                    </label>
                </header>

                <div class="panel-body">


                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label input-sm">Emp ID: </label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="emp_id" id="emp_id"
                                                class="form-control input-sm m-bot15 emp_id">
                                            <option value="">Select Employee</option>
                                            <!-- <option value="All">All</option> -->
                                            @foreach($emp_info as $em)
                                                <option value="{{$em->emp_id}}">{{$em->emp_id}} | {{$em->emp_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-4 col-sm-4 control-label input-sm">Group Name: </label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="grp_id" id="grp_id"
                                                class="form-control input-sm m-bot15 gr_id">
                                            <option value="">Select Group</option>
                                            <option value="All">All</option>
                                            {{--@foreach($grp_info as $ei)--}}
                                                {{--<option value="{{$ei->group_id}}">{{$ei->group_name}}</option>--}}
                                            {{--@endforeach--}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                            </div>
                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                <div id="export_buttons">

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
                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                <div id="export_buttons">

                                </div>
                            </div>
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
            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                <div id="export_buttons">

                </div>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>GROUP_ID</th>
                                    <th>GROUP_NAME</th>
                                    <th>EMP_ID</th>
                                    <th>EMP_NAME</th>
                                    <th>TERR_ID</th>
                                    <th>TERR_GROUP</th>
                                    <th>DESIG</th>
                                    <th>EXAM_DATE</th>
                                    <th>TOPICS</th>
                                    <th>TOTAL_MARK</th>
                                    <th>OBTAIN</th>
                                    <th>ACH%</th>
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


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{Html::script('public/site_resource/js/bootstrap-lightbox.min.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
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
        $('.emp_id').select2();
        $('.gr_id').select2();

        $('#emp_id').on('change',function () {
            var empid = $('#emp_id').val();
            $('#grp_id').empty().append($('<option></option>').html('Loading...'));

            $.ajax({
                type: 'get',
                url: "{{ url('quiz/getEmpGrpName') }}",
                data: {'empid': empid},
                success: function (data) {

                    console.log('result',data);

                    var op = '';
                    op += '<option value="0" selected disabled>Select Group</option>';
                    op += '<option value="All">All</option>';
                    for (var i = 0; i < data.length; i++) {
                        op += '<option value="' + data[i]['group_id'] + '">' + data[i]['group_name'] + '</option>';
                    }
                    $('#grp_id').empty().append(op);
                },
                error: function (e) {
                    console.log('error = ', e);
                }
            });
        });

        $("#btn_display").click(function () {

            $("#loader").show();
            var gr_id = $('#grp_id').val();
            var emp_id = $('#emp_id').val();
            var data = {grp_id: gr_id, emp_id: emp_id, "_token": "{{ csrf_token() }}"};

            $.ajax({
                type: "post",
                dataType: 'json',
                data: data,
                url: "{{ url('quiz/getEmpQuizResult') }}",
                success: function (resp) {
                    // console.log("Success Data : ", resp);

                    $("#loader").hide();
                    $("#report-body").show();
                    $("#blk_list").DataTable().destroy();
                    table = $("#blk_list").DataTable({
                        data: resp,
                        columns: [
                            {data: "group_id"},
                            {data: "group_name"},
                            {data: "emp_id"},
                            {data: "emp_name"},
                            {data: "terr_id"},
                            {data: "terr_group"},
                            {data: "desig"},
                            {data: "exam_date"},
                            {data: "topics"},
                            {data: "total_mark"},
                            {data: "obtain"},
                            {data: "ach"}
                        ],
                        order: [[ 0, "desc" ]],
                        fixedHeader: {
                            header: true,
                            headerOffset: $('#fix').height()
                            //headerOffset: $('#fix').outerHeight()
                        },
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
                error: function (err) {
                    console.log(err);
                    $("#loader").hide();
                    $("#report-body").show();
                }
            });

        });
    </script>

@endsection
