<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/13/2019
 * Time: 9:03 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Depot Pending - Approved')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
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
                        Depot Pending Leave
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Approval Name: </label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control input-sm" value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <div class="col-md-1 col-sm-1 col-xs-1">
                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <section class="panel" id="data_table">
                            <div class="panel-body">
                                <div class="table table-responsive">
                                    <table id="example" class="display table table-bordered table-striped" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Line ID</th>
                                            <th>PLANT NAME</th>
                                            <th>EMP ID</th>
                                            <th>NAME</th>
                                            <th>APPLY DATE</th>
                                            <th>LEAVE ENJOYED</th>
                                            <th>L. TYPE</th>
                                            <th>D.O.F</th>
                                            <th>PURPOSE</th>
                                            <th>APPR. NAME</th>
                                            <th>APPR. STATUS</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
                                        </tr>
                                        </thead>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
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
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
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

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}




    <script type="text/javascript">

        let table ='';

        $(document).ready(function() {

            $("#btn_display").click(function () {

                let emp_id = "{{ Auth::user()->user_id }}";

                if ($("#report-body").is(":visible")) {
                    $("#report-body").hide();
                }

                $("#loader").show();
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    data: {emp_id: emp_id},
                    url: "{{ url('elm_portal/getDepotLeave') }}",
                    success: function (resp) {

                        console.log('Output data: ', resp);

                        $("#loader").hide();
                        $("#report-body").show();

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({

                            data: resp,

                            autoWidth: true,
                            // scrollX:        true,
                            // scrollCollapse: true,
                            columns: [
                                {data: "line_id"},
                                {data: "plant_name"},
                                {data: "emp_id"},
                                {data: "emp_name"},
                                {data: "app_date"},
                                {data: "lv_frm_to"},
                                {data: "type_of_leave"},
                                {data: "dol"},
                                {data: "pol"},
                                {data: "head_name"},
                                {
                                    data: "head_status" ,
                                    "render": function (data, type, row) {

                                        // //console.log(data);

                                        if (data === 'NO') {
                                            return '<span class="label label-warning">Pending</span>';
                                        }
                                        else if (data === 'YES') {
                                            return '<span class="label label-success"> Accepted </span>';
                                        }else {
                                            return '<span class="label label-error">Rejected</span>';
                                        }
                                    }
                                },
                                {
                                    data: "status",
                                    className: "haccept",
                                    "render": function (data, type, row) {

                                        if (row.status === 'NO') {
                                            return '<span class="label label-warning">Pending</span>';
                                        }
                                        else if (data === 'YES') {
                                            return '<span class="label label-success "> Accepted </span>';
                                        }
                                    }
                                },
                                {
                                    data: null,
                                    "render": function (row) {
                                            return "<button  class='btn btn-success btn-xs accept'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                            "<button  class='btn btn-danger btn-xs reject '><span class='glyphicon glyphicon-remove'></span>  </button>";
                                    }
                                }
                            ],
                            fixedHeader: {
                                header: true,
                                headerOffset: $('#fix').height()
                                //headerOffset: $('#fix').outerHeight()
                            },
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            columnDefs: [
                                {
                                    "targets": [ 0 ],
                                    "visible": false
                                }
                            ],
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

        } );

        // for accept button
        $(document).on("click",".accept",function() {

            var closestRow = '';
            var data = '';
            var st = '';
            var line_id = '';
            var self = '';

            closestRow = $(this).closest('tr');
            data = table.row(closestRow).data();
            st = 'accept';
            line_id = data.line_id;
            let emp_name = data.emp_name;
            let emp_email = data.emp_email;
            self = $(this);

            // console.log(data);
            // alert( 'You clicked on '+data.line_id+'\'s row' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {line_id: line_id, st: st,emp_email:emp_email,emp_name:emp_name},
                url: "{{ url('elm_portal/depotLeaveAccept') }}",
                success: function (resp) {
                    console.log(resp);
                    if (resp.success) {
                        // //console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.haccept').html('');
                        self.closest('tr').find('.haccept').html('<span class="label label-success "> Accepted </span>');
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function (e) {
                    //console.log(e);
                }
            });
        } );

        //for reject button
        $(document).on("click",".reject",function() {
            let closestRow = $(this).closest('tr');
            let data = table.row(closestRow).data();
            let st = 'reject';
            let line_id = data.line_id;
            let emp_name = data.emp_name;
            let emp_email = data.emp_email;
            let self = $(this);

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {line_id: line_id, st: st,emp_email:emp_email,emp_name:emp_name},
                url: "{{ url('elm_portal/depotLeaveReject') }}",
                success: function (resp) {
                    // //console.log('rejection data =',resp);
                    if (resp.success) {
                        //console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.haccept').html('');
                        self.closest('tr').find('.haccept').html('<span class="label label-danger "> Rejected </span>');
                        self.closest('tr').find('.accept').attr('disabled',true);
                        self.closest('tr').find('.reject').attr('disabled',true);
                        self.closest('tr').find('.edit-btn').attr('disabled',true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        resp = '';
                    }else{
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function () {

                }
            });
        });


    </script>




@endsection

