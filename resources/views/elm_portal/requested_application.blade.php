<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/27/2018
 * Time: 12:30 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Requested Application')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


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
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }

        /*.hd {*/
        /*height: 100% !important;*/
        /*min-height: 786px;*/
        /*}*/

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        #loadingDiv{
            margin: 0px;
            display: none;
            padding: 0px;
            position: absolute;
            right: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background-color: rgb(255, 255, 255);
            z-index: 30001;
            opacity: 0.8;
        }

        #loading {
            position: absolute;
            color: White;
            top: 50%;
            left: 45%;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }
        .line_id_div{
            display: none;
        }
    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-default" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Filter by Year
                    </label>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label input-sm">Year: </label>
                                        <div class="col-sm-6 col-xs-6 col-md-6">
                                            <select name="req_year" id="req_year"
                                                    class="form-control input-sm m-bot15">
                                                <option value="" disabled>Select Year</option>
                                                <option value="All">All</option>
                                                @foreach($appData as $ei)
                                                    <option value="{{$ei->leave_year}}">{{$ei->leave_year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                            <button type="button" id="btn_display" class="btn btn-warning btn-sm" style="float: right;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Display Applications</b>
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                                            <div id="export_buttons" style="float: left">
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
        <div class="col-sm-12 col-md-12" id="req_app_table">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Requested Application
                    </label>
                </header>

                <div class="panel-body table-responsive">
                    <div class="table table-responsive">
                        <table id="rap" class="display nowrap table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Emp Id</th>
                                <th>Name</th>
                                <th>Leave Type</th>
                                <th>Date Of Leave</th>
                                <th>Purpose of Leave</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Duties</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $applicantData as $data)
                                <tr>
                                    <td style="display: none;"><input type="text" class="line_id" name="line_id"
                                                                      value="{{ $data->line_id }}"></td>
                                    <td><span class="emp_id">{{ $data->emp_id }} </span></td>
                                    <td><span class="emp_name">{{ $data->emp_name }} </span></td>
                                    <td><span class="emp_name">{{ $data->type_of_leave }} </span></td>
                                    <td> {{ date('d-M-Y', strtotime($data->leave_from)) }}
                                        to {{ date('d-M-Y', strtotime($data->leave_to)) }} </td>
                                    <td> {{ $data->purpose_of_leave }}  </td>
                                    <td> {{ $data->emp_contact_no }}  </td>
                                    <td><span class="emp_email">{{ $data->emp_email }} </span></td>
                                    <td> {{ $data->rsp_duties }}</td>
                                    <td>@if( $data->rejected_id != '' ) <span class="label label-danger">Rejected</span>
                                        @elseif( $data->rsp_accept == 'NO' ) <span class="label label-warning">Pending</span>
                                        @elseif( $data->rsp_accept == 'YES' ) <span
                                                    class="label label-success">Accept</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if( $data->rsp_accept == 'NO' && $data->rejected_id == '')
                                            <button type="button" class='btn btn-info btn-xs accept' id="accept"><span
                                                        class="glyphicon glyphicon-ok"></span> Accept
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs reject" id="reject"><span
                                                        class="glyphicon glyphicon-remove"></span> Reject
                                            </button>
                                        @else
                                            <button type="button" class='btn btn-info btn-xs acpt disabled'><span
                                                        class="glyphicon glyphicon-ok"></span> Accept
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs rejt disabled"><span
                                                        class="glyphicon glyphicon-remove"></span> Reject
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>
    <div class="row">
        <div id="requested_app" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel panel-info" id="data_table">
                    <header class="panel-heading">
                        <label class="text-default">
                            Requested Application
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="requested_app_report" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead style="background-color: white;color: black">
                                <tr>
                                    <th class="line_id_div">Line Id</th>
                                    <th>Emp Id</th>
                                    <th>Name</th>
                                    <th>Date Of Leave</th>
                                    <th>Purpose of Leave</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Duties</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
    <div id="loadingDiv">
        <p id="loading">
            <img src="{{url('public/site_resource/images/preloader.gif')}}"
                 alt="Loading Report Please wait..." width="35px" height="35px">
        </p>
    </div>



    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')
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

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        var $loading = $('#loadingDiv').hide();
        $(document).ready(function () {
            $('#req_year').select2();

            $('#btn_display').on('click',function(){
                $('#req_app_table').empty();
                var req_year = $('#req_year').val();

                $("#loader").show();
                var table = null;

                $.ajax({
                    type: "post",
                    url: " {{ url('elm_portal/getLeaveHistoryByYear') }} ",
                    data: {req_year:req_year, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        // console.log(data);
                        $("#requested_app").show();
                        $("#loader").hide();
                        $("#requested_app_report").DataTable().destroy();

                        table = $("#requested_app_report").DataTable({
                            dom: 'Bfrtip',
                            buttons: [],
                            data: data,
                            columns: [
                                {
                                    data: null,
                                    orderable: false,
                                    className: 'line_id_div',
                                    'render': function (data, type, row) {
                                        return '<input type="text" class="line_id" name="line_id" value="'+row
                                            .line_id+'">'
                                    }
                                },
                                {data: "emp_id"},
                                {data: "emp_name"},
                                {data: "days"},
                                {data: "purpose_of_leave"},
                                {data: "emp_contact_no"},
                                {data: "emp_email"},
                                {data: "rsp_duties"},
                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        if(row.rejected_id != null){
                                            return '<span class="label label-danger">Rejected</span>'
                                        }else if(row.rsp_accept == 'NO'){
                                            return '<span class="label label-warning">Pending</span>'
                                        }else if(row.rsp_accept == 'YES'){
                                            return '<span class="label label-success">Accept</span>'
                                        }
                                    }
                                },
                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        if(row.rsp_accept == 'NO' && row.rejected_id == null){
                                            return '<button type="button" class="btn btn-info btn-xs accept_val" ' +
                                                ' onclick="acceptThis(this)"><span class="glyphicon ' +
                                                'glyphicon-ok"></span> Accept ' +
                                                '</button> <button type="button" class="btn btn-danger btn-xs ' +
                                                'reject_val"' +
                                                ' onclick="rejectThis(this)"><span class="glyphicon ' +
                                                'glyphicon-remove"></span> Reject</button>'
                                        }else{
                                            return '<button type="button" class="btn btn-info btn-xs acpt ' +
                                                'disabled"><span class="glyphicon glyphicon-ok"></span> ' +
                                                'Accept</button> <button type="button" class="btn btn-danger btn-xs ' +
                                                'rejt disabled"><span class="glyphicon glyphicon-remove"></span> ' +
                                                'Reject </button>'
                                        }
                                    }
                                },
                            ],
                            columnDefs: [
                                {
                                    targets: 1,
                                    className: 'emp_id'
                                },
                                {
                                    targets: 2,
                                    className: 'emp_name'
                                },
                                {
                                    targets: 6,
                                    className: 'emp_email'
                                },
                                {
                                    "width": "15%",
                                    "targets": 9
                                }
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: false,
                            filter: true,

                            select: {
                                style: 'os',
                                selector: 'td:first-child'
                            }
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
                                            exportOptions: {
                                                columns: [1,2,3,4,5,6,7,8]
                                            },
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }, {
                                            extend: 'pdf',
                                            text: 'Save As PDF',
                                            orientation: 'landscape',
                                            footer: true,
                                            exportOptions: {
                                                columns: [1,2,3,4,5,6,7,8]
                                            },
                                            customize : function(doc){
                                                doc.content[1].table.widths =
                                                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                            },
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
                        $("#loader").hide();
                        $("#requested_app").show();
                    }
                });
            });

            $('.accept').on('click', function () {
                $(this).attr("disabled", true);

                this.value = '1';

                var line_id = $(this).closest("tr").find(".line_id").val();
                var emp_id = $(this).closest("tr").find(".emp_id").text();
                var emp_email = $(this).closest("tr").find(".emp_email").text();
                var emp_name = $(this).closest("tr").find(".emp_name").text();
                var accept_val = $(this).closest("tr").find(".accept").val();

                console.log(line_id);
                console.log(emp_id);
                console.log(emp_email);
                console.log(emp_name);
                console.log(accept_val);

                $loading.show();

                $.ajax({
                    type: "post",
                    url: '{{url('elm_portal/app_confirm')}}',
                    data: {
                        accept_val: accept_val,
                        emp_id: emp_id,
                        _token: '{{csrf_token()}}',
                        emp_email: emp_email,
                        emp_name: emp_name,
                        line_id: line_id
                    },
                    success: function (data) {
                        $loading.hide();
                        if (data.success) {
                            toastr.success(data.success, '', {timeOut: 1000})
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        else {
                            toastr.error(data.error, '', {timeOut: 1000});
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Contact your administrator.!',
                        });
                    }
                });

            });

            $('.reject').on('click', function () {

                $loading.show();

                $(this).attr("disabled", true);

                this.value = '0';
                // var line_id = $('.line_id').val();
                var line_id = $(this).closest("tr").find(".line_id").val();
                var emp_id = $(this).closest("tr").find(".emp_id").text();
                var emp_name = $(this).closest("tr").find(".emp_name").text();
                var emp_email = $(this).closest("tr").find(".emp_email").text();
                var reject_val = $('#reject').val();

                $.ajax({
                    type: "post",
                    url: '{{url('elm_portal/app_reject')}}',
                    async: false,
                    data: {
                        reject_val: reject_val,
                        emp_id: emp_id,
                        _token: '{{csrf_token()}}',
                        emp_email: emp_email,
                        emp_name: emp_name,
                        line_id: line_id
                    },
                    success: function (data) {

                        console.log(data);
                        $loading.hide();

                        if (data.success) {
                            toastr.error(data.success, '', {timeOut: 1000})
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        else {
                            toastr.error(data.error, '', {timeOut: 1000});
                        }
                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Contact your administrator.!',
                        });
                    }
                });

            });
        });
        function acceptThis(ele){
            $(ele).attr("disabled", true);

            ele.value = '1';

            var line_id = $(ele).closest("tr").find(".line_id").val();
            var emp_id = $(ele).closest("tr").find(".emp_id").text();
            var emp_email = $(ele).closest("tr").find(".emp_email").text();
            var emp_name = $(ele).closest("tr").find(".emp_name").text();
            var accept_val = $(ele).closest("tr").find(".accept_val").val();

            // console.log(line_id);
            // console.log(emp_id);
            // console.log(emp_email);
            // console.log(emp_name);
            // console.log(accept_val);

            $loading.show();

            $.ajax({
                type: "post",
                url: '{{url('elm_portal/app_confirm')}}',
                data: {
                    accept_val: accept_val,
                    emp_id: emp_id,
                    _token: '{{csrf_token()}}',
                    emp_email: emp_email,
                    emp_name: emp_name,
                    line_id: line_id
                },
                success: function (data) {
                    $loading.hide();
                    if (data.success) {
                        toastr.success(data.success, '', {timeOut: 1000})
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    else {
                        toastr.error(data.error, '', {timeOut: 1000});
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function () {
                    swal({
                        type: 'error',
                        text: 'Contact your administrator.!',
                    });
                }
            });
        }
        function rejectThis(ele){

            $loading.show();
            $(ele).attr("disabled", true);

            ele.value = '0';
            var line_id = $(ele).closest("tr").find(".line_id").val();
            var emp_id = $(ele).closest("tr").find(".emp_id").text();
            var emp_name = $(ele).closest("tr").find(".emp_name").text();
            var emp_email = $(ele).closest("tr").find(".emp_email").text();
            var reject_val = $(ele).closest("tr").find(".reject_val").val();

            // console.log(line_id);
            // console.log(emp_id);
            // console.log(emp_email);
            // console.log(emp_name);
            // console.log(reject_val);

            $.ajax({
                type: "post",
                url: '{{url('elm_portal/app_reject')}}',
                async: false,
                data: {
                    reject_val: reject_val,
                    emp_id: emp_id,
                    _token: '{{csrf_token()}}',
                    emp_email: emp_email,
                    emp_name: emp_name,
                    line_id: line_id
                },
                success: function (data) {
                    $loading.hide();
                    if (data.success) {
                        toastr.error(data.success, '', {timeOut: 1000})
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    else {
                        toastr.error(data.error, '', {timeOut: 1000});
                    }
                },
                error: function () {
                    swal({
                        type: 'error',
                        text: 'Contact your administrator.!',
                    });
                }
            });
        }
    </script>

@endsection