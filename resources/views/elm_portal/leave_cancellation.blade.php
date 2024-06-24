<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/29/2019
 * Time: 10:44 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Leave Cancellation Forms')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
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

        input {
            color: black;
            font-size: small;
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


        <div class="col-sm-12 col-md-12">
            @if (session()->has('success'))
                <div class="alert alert-dismissable alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>
                        {!! session()->get('success') !!}
                    </strong>
                </div>
            @endif
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                       Leave Cancellation Form
                    </label>
                </header>

                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{ url('elm_portal/LvCancelReq') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="mgr_id" id="mgr_id" value=" {{Auth::user()->user_id}}" >
                        <input type="hidden" name="plant_id" id="plant_id" >
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Employee ID: </label>
                            <div class="col-sm-6 col-md-6">
                                <select name="lv_emp_id" id="lv_emp_id" class="form-control input-sm lv_emp_id">
                                    <option value=""> Select Employee </option>
                                @foreach( $employees as $emp)
                                        <option value="{{ $emp->emp_id }}"> {{ $emp->emp_id }} </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Employee Name: </label>
                            <div class="col-sm-6 col-md-6">
                                <input type="text" readonly class="form-control" id="ename" name="ename">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Employee Dept: </label>
                            <div class="col-sm-6 col-md-6">
                                <input type="text" readonly class="form-control" id="edept" name="edept">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Date of Leave: </label>
                            <div class="col-sm-6 col-md-6">
                                <input type="text" readonly class="form-control" id="dol" name="dol">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Leave Type</label>
                            <div class="col-sm-6 col-md-6">
                                <input type="text" readonly class="form-control" id="lt" name="lt">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Leave Reason</label>
                            <div class="col-sm-6 col-md-6">
                                <input type="text" readonly class="form-control" id="lr" name="lr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Comments</label>
                            <div class="col-sm-6 col-md-6">
                                <textarea rows="5" cols="60" name="comments" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                <button type="submit" id="btn_submit" class="btn btn-warning btn-sm">
                                    <i class="fa fa-chevron-circle-up"></i> <b>Send</b></button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}
    <script type="text/javascript">


        $('#lv_emp_id').select2();
        $('.lv_emp_id').on('change',function () {
            console.log('Yes Change....',$('#lv_emp_id').val());
            $.ajax({
                type: "post",
                url: '{{url('elm_portal/getRqLeave')}}',
                async: false,
                data: { emp_id: $('#lv_emp_id').val() ,_token: '{{csrf_token()}}' },
                success: function (data) {
                    console.log('LeaveDetails = ',data);
                    $('#plant_id').val(data[0].plant_id);
                    $('#ename').val(data[0].emp_name);
                    $('#edept').val(data[0].emp_dept_name);
                    $('#dol').val(data[0].leave);
                    $('#lt').val(data[0].type_of_leave);
                    $('#lr').val(data[0].purpose_of_leave);

                },
                error: function () {
                    swal({
                        type: 'error',
                        text: 'Contact your administrator.!',
                    });
                }
            });
        });


    </script>
@endsection



