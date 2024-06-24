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
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
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
                                <th>Date Of Leave</th>
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
                                    <td> {{ date('d-M-Y', strtotime($data->leave_from)) }}
                                        to {{ date('d-M-Y', strtotime($data->leave_to)) }} </td>
                                    <td> {{ $data->emp_contact_no }}  </td>
                                    <td><span class="emp_email">{{ $data->emp_email }} </span></td>
                                    <td> {{ $data->rsp_duties }}</td>
                                    <td>@if( $data->rejected_id != '' ) <span class="label label-danger">Rejected</span>
                                        @elseif( $data->rsp_accept == 'NO' ) <span
                                                    class="label label-warning">Pending</span>
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

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script type="text/javascript">

        var $loading = $('#loadingDiv').hide();

        $(function () {


            // $('#rap').dataTable( {
            //     scrollY:        '50vh',
            //     scrollCollapse: false,
            //     paging:         false
            // } );

            // $(this).attr("disabled","disabled");


            $('.accept').on('click', function () {
                $(this).attr("disabled", true);

                this.value = '1';

                var line_id = $(this).closest("tr").find(".line_id").val();
                var emp_id = $(this).closest("tr").find(".emp_id").text();
                var emp_email = $(this).closest("tr").find(".emp_email").text();
                var emp_name = $(this).closest("tr").find(".emp_name").text();
                var accept_val = $(this).closest("tr").find(".accept").val();

                console.log(accept_val);
                console.log(line_id);
                console.log(emp_id);
                console.log(emp_email);
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

                        console.log(data);
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
    </script>

@endsection