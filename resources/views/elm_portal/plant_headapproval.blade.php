<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 12/12/2018
 * Time: 5:08 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Plant Head Approval')
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
                        Request For Approval ( Only Plant Head )
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
                                            <input type="text" readonly class="form-control input-sm"
                                                   value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label input-sm">Employee:</label>
                                        <div class="col-sm-10">
                                            <select name="req_emp_id" id="req_emp_id"
                                                    class="form-control input-sm m-bot15">
                                                <option value="">Select Employee</option>
                                                <option value="All">All</option>
                                                @foreach($emp_info as $ei)
                                                    <option value="{{$ei->employee_id}}">{{$ei->employee_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Report</b></button>
                                    </div>
                                    <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                        <div id="export_buttons">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="row" id="int_load">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <section class="panel" id="data_table">
                            <div class="panel-body">
                                <div class="table table-responsive">
                                    <table id="int_tbl" class="display table table-bordered table-striped"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th style="display: none">Line ID</th>
                                            <th>EMP ID</th>
                                            <th>NAME</th>
                                            <th>APPLY DATE</th>
                                            <th>LEAVE ENJOYED</th>
                                            <th>D.O.F</th>
                                            <th>L. TYPE</th>
                                            <th>PURPOSE</th>
                                            <th>DEPT. Approved</th>
                                            <th>Status</th>
                                            <th>ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($resp_data as $data)
                                            {{--var_dump($data)--}}
                                            <tr>
                                                <td style="display: none">  {{ $data->line_id }}   </td>
                                                <td>  {{ $data->emp_id }}   </td>
                                                <td>  {{ $data->emp_name }}   </td>
                                                <td>  {{ $data->application_date }}  </td>
                                                <td>  {{ $data->leave_from }} to {{ $data->leave_to }}    </td>
                                                <td>  {{ $data->type_of_leave }}   </td>
                                                <td>  {{ $data->day_of_leave }}   </td>
                                                <td>  {{ $data->purpose_of_leave }}   </td>
                                                <td>  {{ $data->rcm_approved_date }}   </td>
                                                <td>
                                                    @if($data->plant_head_id == '' && $data->plant_head_rejected =='')
                                                        <span class="label label-warning">Pending</span>
                                                    @else
                                                        @if( $data->plant_head_rejected != null)
                                                            <span class="label label-danger">Rejected</span>
                                                        @else
                                                            <span class="label label-success"> Accepted </span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>


                                                    @if($data->plant_head_id == '' && $data->plant_head_rejected =='')
                                                        <div class="form-group">
                                                            <button type='button' class='btn btn-info btn-xs edit-btn'>
                                                                <span class='glyphicon glyphicon-edit'></span></button>
                                                            <button type='button' class='btn btn-success btn-xs approve'
                                                                    id='approve'><span
                                                                        class='glyphicon glyphicon-ok'></span></button>
                                                            <button type='button' class='btn btn-danger btn-xs reject'
                                                                    id='reject'><span
                                                                        class='glyphicon glyphicon-remove'></span>
                                                            </button>
                                                            {{--<button name="approve" class="btn btn-success btn-xs approve"  id="approve">Approve  </button>--}}
                                                            {{--<button name="reject" class="btn btn-danger btn-xs reject"    id="reject">Reject    </button>--}}
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <button class='btn btn-info btn-xs edit-btn disabled'><span
                                                                        class='glyphicon glyphicon-edit'></span>
                                                            </button>
                                                            <button class='btn btn-success btn-xs approve btn.disabled'
                                                                    id="approve" disabled><span
                                                                        class='glyphicon glyphicon-ok'></span></button>
                                                            <button class='btn btn-danger btn-xs reject btn.disabled'
                                                                    id="reject" disabled><span
                                                                        class='glyphicon glyphicon-remove'></span>
                                                            </button>
                                                            {{--<button name="approve" class="btn btn-success btn-xs approve btn.disabled" id="approve" disabled>Approve  </button>--}}
                                                            {{--<button name="reject" class="btn btn-danger btn-xs reject btn.disabled"  id="reject" disabled>Reject      </button>--}}
                                                        </div>
                                                    @endif












                                                    {{--if ((row.plant_head_id === null)) {--}}

                                                    {{--return "<button type='button' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>" + " " +--}}
                                                    {{--"<button type='button' class='btn btn-success btn-xs accept' id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +--}}
                                                    {{--"<button type='button' class='btn btn-danger btn-xs reject' id='reject'><span class='glyphicon glyphicon-remove'></span>  </button>";--}}
                                                    {{--}else {--}}
                                                    {{--if (row.plant_head_approved !== null) {--}}
                                                    {{--return "<button class='btn btn-info btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>" + " " +--}}
                                                    {{--"<button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +--}}
                                                    {{--"<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>";--}}

                                                    {{--}--}}
                                                    {{--else if (row.plant_head_rejected !== null ) {--}}
                                                    {{--return "<button class='btn btn-info btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>" + " " +--}}
                                                    {{--"<button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +--}}
                                                    {{--"<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>";--}}
                                                    {{--}--}}
                                                    {{--}--}}


                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
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
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <section class="panel" id="data_table">
                            <div class="panel-body">
                                <div class="table table-responsive">
                                    <table id="example" class="display table table-bordered table-striped"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th style="display: none">Line ID</th>
                                            <th>EMP ID</th>
                                            <th>NAME</th>
                                            <th>APPLY DATE</th>
                                            <th>LEAVE ENJOYED</th>
                                            <th>D.O.F</th>
                                            <th>L. TYPE</th>
                                            <th>PURPOSE</th>
                                            <th>DEPT. Approved</th>
                                            <th>Status</th>
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

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">

            {{--<form method="post" role="form" action="{{ url('elm_portal/masterpleaveapp') }}" id="edfrm">--}}
            <form role="form" id="edfrm">
                {{ csrf_field() }}

                <div class="modal-content">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="line_id" name="line_id">

                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <section class="panel panel-info" id="data_table">
                                        <header class="panel-heading">
                                            <label class="text-default">
                                                Leave Application Form
                                            </label>
                                            <button aria-hidden="true" style="background-color: red; opacity: initial"
                                                    data-dismiss="modal" class="close" type="button">×
                                            </button>
                                        </header>

                                        <div class="panel-body">

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <h5 class="text-center text-primary"><b> Employee Leave Details</b>
                                                    </h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 table-responsive ">

                                                    <table class="table table-hover table-bordered emp_info">
                                                        <thead>
                                                        <tr>
                                                            <th>Employee Code</th>
                                                            <th>Employee Name</th>
                                                            <th>Designation</th>
                                                            <th>Department</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td id="emp_id"></td>
                                                            <td id="emp_name"></td>
                                                            <td id="desig_name"></td>
                                                            <td id="dept"></td>
                                                            <input type="hidden" class="form-control input-sm"
                                                                   id="applicant_name" name="applicant_name">
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-5 col-md-5">
                                                    <div class="form-group">
                                                        <label for="date"
                                                               class="col-md-4 col-sm-4 control-label fnt_size"><b>Date
                                                                of leave on</b></label>
                                                        <div class="col-sm-4 col-md-4" style="padding-left:45px;">
                                                            <input type="text" class="form-control input-sm"
                                                                   name="st_dt" disabled
                                                                   style="font-size: x-small; padding-right: 0px;"
                                                                   id="date1">
                                                        </div>

                                                        <div class="col-sm-3 col-md-3">
                                                            <input type="text" class="form-control input-sm"
                                                                   style="font-size: x-small;" disabled
                                                                   name="en_dt" id="date2">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-md-3">
                                                    <div class="form-group">
                                                        <label for="contact"
                                                               class="col-sm-6 col-md-6 control-label fnt_size"><b>Day
                                                                of
                                                                leave</b></label>
                                                        <div class="col-md-4 col-sm-4"
                                                             style="padding-left:0px;padding-right:30px;">
                                                            <input type="text" class="form-control input-sm" name="dol"
                                                                   id="dol"
                                                                   readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="cmp"
                                                               class="col-md-4 col-sm-4 control-label fnt_size"><b>Type
                                                                of
                                                                leave</b></label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <select name="tol" id="tol" disabled
                                                                    class="form-control input-sm filter-option pull-left tol">
                                                                <option value="">Select Leave</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="cmp"
                                                               class="col-md-6 col-sm-6 control-label fnt_size"><b>Address
                                                                during leave</b></label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <input type="text" class="form-control input-xs"
                                                                   name="adl" disabled
                                                                   id="adl">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="contact"
                                                               class="col-sm-4 col-md-4 control-label fnt_size"><b>Contact
                                                                No</b></label>
                                                        <div class="col-md-6 col-sm-6">

                                                            <input type="text" class="form-control input-xs" disabled
                                                                   name="mob" id="mob"
                                                            >

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="contact"
                                                               class="col-sm-4 col-md-4 control-label fnt_size"><b>Email</b></label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="text" class="form-control input-xs"
                                                                   name="email" id="email" disabled>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="" class="col-md-2 col-sm-2 control-label fnt_size"
                                                               style="padding-right:0px; "><b>Purpose
                                                                of leave</b></label>
                                                        <div class="col-md-10 col-sm-10">
                                                            <input type="text" class="form-control input-sm" name="pol"
                                                                   id="pol" style="padding-left: 5px;" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row" id="img_show_hide" style="display: none;">
                                                <div class="col-md-12 col-sm-12">
                                                    <b>Medical Images: </b>
                                                    <div class="col-md-12 col-sm-12">
                                                        <button type="button"
                                                                class="glyphicon glyphicon-remove-circle btn-danger cls_btn"></button>
                                                        <a data-toggle="lightbox" id="cl_light" data-keyboard="true">
                                                            <div class="col-md-12 col-sm-12">
                                                                <div id="m_img" class="small-img">
                                                                </div>

                                                            </div>
                                                        </a>


                                                        <div id="demoLightbox" class="lightbox fade" tabindex="-1"
                                                             role="dialog" aria-hidden="true">
                                                            <div class='lightbox-dialog'>
                                                                <div class='lightbox-content'>
                                                                    <img style="width: 400px; height: 400px;" src=""
                                                                         class="small-img"/>
                                                                    {{--<div class='lightbox-caption'>--}}
                                                                    {{--Write here your caption here--}}
                                                                    {{--</div>--}}
                                                                    {{--<div id="m_img"></div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="mat_show_hide" style="display: none;">
                                                <div class="col-md-12 col-sm-12">
                                                    <b>Maternity Images: </b>
                                                    <div class="col-md-12 col-sm-12">
                                                        {{--<button type="button" class="glyphicon glyphicon-remove-circle btn-danger mat_cls_btn"></button>--}}
                                                        <a data-toggle="lightbox" id="ml_light" data-keyboard="true">
                                                            <div class="col-md-12 col-sm-12">
                                                                <div id="mt_img" class="small-img">
                                                                </div>

                                                            </div>
                                                        </a>


                                                        <div id="matLightbox" class="lightbox fade" tabindex="-1"
                                                             role="dialog" aria-hidden="true">
                                                            <div class='lightbox-dialog'>
                                                                <div class='lightbox-content'>
                                                                    <img src="" class="small-img"/>
                                                                    {{--<div class='lightbox-caption'>--}}
                                                                    {{--Write here your caption here--}}
                                                                    {{--</div>--}}
                                                                    {{--<div id="m_img"></div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row" id="spimg_show_hide" style="display: none;">
                                                <div class="col-md-12 col-sm-12">
                                                    Medical Images
                                                    {{--<div class="col-md-12 col-sm-12 sp_images"--}}
                                                    {{--style="border: 1px solid #761c19; padding: 5px;">--}}
                                                    <div class="col-md-12 col-sm-12 "
                                                         style="border: 1px solid #761c19; padding: 5px;">
                                                        <a data-toggle="lightbox" data-keyboard="true">
                                                            <div class="row">
                                                                <div id="" class="col-md-12 col-sm-12 sp_images">

                                                                </div>
                                                            </div>

                                                        </a>
                                                    </div>

                                                    <div id="galaryLightbox" class="lightbox fade" tabindex="-1"
                                                         role="dialog" aria-hidden="true">
                                                        <div class='lightbox-dialog'>

                                                            <div class='lightbox-content'>
                                                                <button class="btn btn-danger gl_close"
                                                                        style="float: right;" data-dismiss="lightbox">x
                                                                </button>
                                                                <img src="" style="width: 400px; height: 400px;"
                                                                     class="small-img"/>
                                                                {{--<div class='lightbox-caption'>--}}
                                                                {{--Write here your caption here--}}
                                                                {{--</div>--}}
                                                                {{--<div id="m_img"></div>--}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="col-md-12 col-sm-12">
                                                        <h5 class="text-center text-primary"><b>Duties Will be carried
                                                                out
                                                                by
                                                                (Person)</b></h5>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 table-responsive ">


                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Responsible Persone Name</th>
                                                            <th>Employee Code</th>
                                                            <th>Designation</th>
                                                            <th>Department</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <!-- <input type="text" name="" id="rsp_emp"> -->
                                                                <select name="rsp_emp" id="rsp_emp" disabled
                                                                        class="form-control input-sm  rsp_emp">
                                                                    <option value="">Select Employees</option>

                                                                </select>

                                                            </td>

                                                            <td><input type="text" class="form-control input-sm"
                                                                       id="rsp_emp_code" disabled
                                                                       name="rsp_emp_code"></td>
                                                            <td><input type="text" class="form-control input-sm"
                                                                       id="rsp_desig" disabled
                                                                       name="rsp_desig_name"></td>
                                                            <td><input type="text" class="form-control input-sm"
                                                                       id="rsp_dept_name" disabled
                                                                       name="rsp_dept_name"></td>


                                                            <input type="hidden" class="form-control input-sm"
                                                                   id="rsp_emp_name" name="rsp_emp_name">
                                                            <input type="hidden" class="form-control input-sm"
                                                                   id="rsp_desig_id"
                                                                   name="rsp_desig_id">
                                                            <input type="hidden" class="form-control input-sm"
                                                                   id="rsp_dept_id"
                                                                   name="rsp_dept_id">
                                                            <input type="hidden" id="rsp_oldemail" name="rsp_oldemail">
                                                            <input type="hidden" id="rsp_oldname" name="rsp_oldname">


                                                        </tr>
                                                        <tr>
                                                            <td class="cnt " colspan="2"><b>Contact No:</b> <input
                                                                        type="text" disabled
                                                                        class="form-control input-sm"
                                                                        id="rsp_cnt_no"
                                                                        name="rsp_cnt_no"/>
                                                            </td>
                                                            <td class="cnt " colspan="2"><b>Email:</b> <input
                                                                        type="text" disabled
                                                                        class="form-control input-sm"
                                                                        id="rsp_email"
                                                                        name="rsp_email">
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for=""
                                                               class="col-md-2 col-sm-2 control-label fnt_size"><b>Responsible
                                                                Duties</b></label>
                                                        <div class="col-md-10 col-sm-10">
                                                            <input type="text" class="form-control input-sm"
                                                                   name="rsp_duties" disabled
                                                                   id="rsp_duties">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <section class="panel panel-success">
                                    <header class="panel-heading">
                                        <label class="text-default">
                                            Employee Leave Status
                                        </label>
                                    </header>

                                    <div class="panel-body">
                                        <div class="form-horizontal">
                                            <div class="col-md-12 col-sm-12 table-responsive">
                                                <table class="table table-bordered" id="lvs">
                                                    <thead>
                                                    <tr>
                                                        <th>TYPE</th>
                                                        <th>ANNUAL</th>
                                                        <th>CASUAL</th>
                                                        <th>LWP</th>
                                                        <th id="persone">MATERNITY</th>
                                                        <th>MEDICAL</th>
                                                        {{--<th>SL</th>--}}
                                                        <th>ADVANCE</th>
                                                        <th>SPECIAL MEDICAL</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>


    </div>



    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    <!-- <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js"></script> -->
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

        var dtable = $("#int_tbl").DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false
        });

        $('#req_emp_id').select2();

        $('#int_tbl tbody').on('click', 'button.approve', function () {
            // console.log('Yes Approved');
            var closestRow = $(this).closest('tr');
            var data = dtable.row(closestRow).data();
            var st = 'accept';
            var line_id = data[0];
            var self = $(this);
            // console.log(line_id);

            var auth_id = "{{ Auth::user()->user_id }}";

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {line_id: line_id, st: st, auth_id : auth_id},
                url: "{{ url('elm_portal/plantHeadAccept') }}",
                success: function (resp) {
                    // console.log('PL accept data =', resp);
                    if (resp.success) {
                        // console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.approved').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function () {

                }
            });
        });

        $('#int_tbl tbody').on('click', 'button.reject', function () {
            // console.log('Yes Rejected');
            var closestRow = $(this).closest('tr');
            var data = dtable.row(closestRow).data();
            var st = 'reject';
            var line_id = data[0];
            var self = $(this);
            // console.log(line_id);

            var auth_id = "{{ Auth::user()->user_id }}";

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {line_id: line_id, st: st , auth_id:auth_id},
                url: "{{ url('elm_portal/plantHeadReject') }}",
                success: function (resp) {
                    // console.log('PL accept data =', resp);
                    if (resp.success) {
                        // console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.approved').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function () {

                }
            });
        });


        $('#int_tbl tbody').on('click', 'button.edit-btn', function () {

            var closestRow = $(this).closest('tr');
            var data = dtable.row(closestRow).data();
            var line_id = data[0];

            $("#myModal").modal('show');
            // var line_id = $(this).data('id');
            $(".modal-body #line_id").val(line_id);

            $.ajax({
                type: "post",
                url: "{{url('elm_portal/plantEdEmployee')}}",
                data: {line_id: line_id, '_token': '{{csrf_token()}}'},
                success: function (data) {
                    // console.log("answer = ",data);
                    var xxx = data.resp_data[0].emp_name;
                    // console.log(xxx);
                    var chk_imgdetials = '';
                    chk_imgdetials = data.resp_data[0].type_of_leave;
                    // console.log(chk_imgdetials);

                    $('#emp_id').text(data.resp_data[0].emp_id);
                    $('#emp_name').text(data.resp_data[0].emp_name);
                    $('#applicant_name').val(data.resp_data[0].emp_name);


                    $('#desig_name').text(data.resp_data[0].emp_desig_name);
                    $('#dept').text(data.resp_data[0].emp_dept_name);
                    dt1 = data.resp_data[0].leave_from;
                    dt2 = data.resp_data[0].leave_to;


                    $('#date1').datepicker({
                        format: "dd-M-yyyy",
                        todayHighlight: 'TRUE',
                        autoclose: true,
                        minDate: 0,
                        maxDate: '+1Y+6M'
                    })
                        .datepicker('setDate', dt1)
                        .on('changeDate', function (ev) {
                            $('#date2').datepicker('setStartDate', $("#date1").val());
                            $('#tol').val();
                        });

                    $('#date2').datepicker({
                        format: "dd-M-yyyy",
                        todayHighlight: 'TRUE',
                        autoclose: true,
                        minDate: '0',
                        maxDate: '+1Y+6M'
                    })
                        .datepicker('setDate', dt2)
                        .on('changeDate', function (ev) {

                            var d1 = $('#date1').datepicker('getDate');
                            var d2 = $('#date2').datepicker('getDate');
                            var diff = 0;
                            if (d1 && d2) {
                                diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                            }
                            $('#dol').val(diff);
                        });
                    $('#dol').val(data.resp_data[0].day_of_leave);
                    $('#adl').val(data.resp_data[0].add_during_leave);
                    $('#mob').val(data.resp_data[0].emp_contact_no);
                    $('#email').val(data.resp_data[0].emp_email);
                    $('#pol').val(data.resp_data[0].purpose_of_leave);
                    $('#rsp_emp_code').val(data.resp_data[0].rsp_emp_id);
                    $('#rsp_desig').val(data.resp_data[0].rsp_desig_name);
                    $('#rsp_emp_name').val(data.resp_data[0].rsp_emp_name);

                    $('#rsp_desig_id').val(data.resp_data[0].rsp_desig_id);
                    $('#rsp_dept_id').val(data.resp_data[0].rsp_dept_id);

                    $('#rsp_dept_name').val(data.resp_data[0].rsp_dept_name);
                    $('#rsp_cnt_no').val(data.resp_data[0].rsp_contact_no);
                    $('#rsp_email').val(data.resp_data[0].rsp_email);
                    $('#rsp_duties').val(data.resp_data[0].rsp_duties);


                    //purpose for sending email for notification of cancel //
                    $('#rsp_oldname').val(data.resp_data[0].rsp_emp_name);
                    $('#rsp_oldemail').val(data.resp_data[0].rsp_email);
                    //purpose for sending email for notification of cancel //


                    var selOpts = "";
                    selOpts += "<option value=''>Select Leave</option>";
                    for (var i = 0; i < data.leavetypes.length; i++) {
                        var id = data.leavetypes[i].leave_type;
                        var val = data.leavetypes[i].leave_type;
                        selOpts += "<option value='" + id + "'>" + val + "</option>";
                    }

                    $('select#tol').empty().append(selOpts);
                    $('select#tol').val(data.resp_data[0].type_of_leave);

                    var selOptsRsp = "";
                    selOptsRsp += "<option value=''>Select Employees</option>";
                    for (var j = 0; j < data.rsp_emp.length; j++) {
                        var idx = data.rsp_emp[j].emp_id;
                        var valx = data.rsp_emp[j].sur_name;
                        selOptsRsp += "<option value='" + idx + "'>" + valx + "</option>";
                    }


                    $('select#rsp_emp').empty().append(selOptsRsp);
                    // console.log(data.resp_data[0].rsp_emp_id);
                    $('select#rsp_emp').val(data.resp_data[0].rsp_emp_id);

                    // $('#rsp_emp').val(data.resp_data[0].rsp_emp_id);

                    // console.log(data.resp_data[0].rsp_emp_id);

                    if (chk_imgdetials === 'MEDICAL') {
                        $('#spimg_show_hide').hide();
                        $('#img_show_hide').show();
                        if (data.resp_data[0].medicalimages) {
                            var nimg_url = '{{  url('public') }}';
                            var nimg_img = '';
                            nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].medicalimages + '" >';

                            // console.log("medicalimages updated = ", nimg_url + data.resp_data[0].medicalimages);

                            current_image = nimg_url + data.resp_data[0].medicalimages;

                            $('#m_img').empty().append(nimg_img);

                            $('#cl_light').on('click', function () {
                                // console.log($(this).find('img').attr('src'));
                                $('.lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));
                                $('#demoLightbox').lightbox();
                            });


                        } else if (data.resp_data[0].medicalimages === null) {
                            // console.log('Medical Image = ',data.resp_data[0].medicalimages);
                            $('#img_show_hide').show();
                            $('#img_show_hide').empty()
                                .append('<div class="col-sm-10 col-md-10 col-xs-10">' +
                                    ' <input type="file" id="medicalFile" name="medicalFile"> ' +
                                    '</div>');
                        }
                        else {
                            $('#img_show_hide').hide();

                        }
                    } else if (chk_imgdetials === 'SPECIAL MEDICAL') {

                        // console.log('======', data.resp_data[0]);
                        // console.log('======',data.resp_data[0].sp_medicalimages);


                        $('#img_show_hide').hide();
                        $('#spimg_show_hide').show();
                        if (data.resp_data[0].sp_medicalimages) {


                            var sp_org_image = data.resp_data[0].sp_medicalimages.split('|');

                            // console.log('sp_images = ', sp_org_image);


                            var sp_url = '{{  url('public') }}';
                            var sp_img = '';
                            for (var k = 0; k < sp_org_image.length; k++) {
                                sp_img += '<div class="col-md-3 col-md-offset-1 gl_light ">';
                                sp_img += '<img class="img-rounded " alt="Cinque Terre" width="204" height="136" src="' + sp_url + sp_org_image[k] + '" >';
                                sp_img += "</div>";
                            }

                            // console.log('sp_images = ', sp_img);

                            $('.sp_images').empty().append(sp_img);

                            $('.gl_light').on('click', function () {
                                // console.log($(this).find('img').attr('src'));
                                $('.lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));

                                $('#galaryLightbox').show().lightbox();
                            });

                        } else {
                            $('#spimg_show_hide').hide();
                        }


                        $('.gl_close').on('click', function (event) {
                            event.preventDefault();
                            $("#galaryLightbox").hide();

                        });


                    }

                    else if (chk_imgdetials === 'MATERNITY') {
                        $('#spimg_show_hide').hide();
                        $('#img_show_hide').hide();
                        $('#mat_show_hide').show();
                        if (data.resp_data[0].maternityimage) {
                            var nimg_url = '{{  url('public') }}';
                            var nimg_img = '';
                            nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].maternityimage + '" >';

                            // console.log("maternity updated = ", nimg_url + data.resp_data[0].maternityimage);

                            current_image = nimg_url + data.resp_data[0].maternityimage;

                            $('#mt_img').empty().append(nimg_img);

                            $('#ml_light').on('click', function () {
                                // console.log($(this).find('img').attr('src'));
                                $('.lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));
                                $('#matLightbox').lightbox();
                            });


                        } else if (data.resp_data[0].maternityimage === null) {
                            // console.log('Medical Image = ',data.resp_data[0].medicalimages);
                            $('#mat_show_hide').show();
                            $('#mat_show_hide').empty()
                                .append('<div class="col-sm-10 col-md-10 col-xs-10">' +
                                    ' <input type="file" id="mtrn_file" name="mtrn_file"> ' +
                                    '</div>');
                        }
                        else {
                            $('#mat_show_hide').hide();

                        }
                    }


                    else {
                        $('#img_show_hide').hide();
                        $('#spimg_show_hide').hide();

                    }


                    $("#lvs").DataTable().destroy();
                    var xtable = $("#lvs").DataTable({
                        data: data.leaveStatus,
                        columns: [
                            {data: "type"},
                            {data: "annual"},
                            {data: "casual", className: 'adv'},
                            {data: "lwp"},
                            {data: "maternity"},
                            {data: "medical"},
                            // {data: "sl"},
                            {data: "advance"},
                            {data: "special_medical"}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: false,
                        paging: false,
                        filter: false

                    });

                     if(data.rsp_emp[0].gender === 'Male'){
                            $('#persone').hide();
                            xtable.column( 4 ).visible( false )
                     }else {
                            $('#persone').show();
                     }

                },
                error: function () {
                    swal({
                        type: 'error',
                        text: 'Not Found.!'
                    });
                }
            });
        });


        var table = '';
        $(document).ready(function () {
            $("#btn_display").click(function () {
                var req_emp_id = $('#req_emp_id').val();
                // console.log("Yes i am in", req_emp_id);

                if ($("#report-body").is(":visible")) {
                    $("#report-body").hide();
                }

                $("#loader").show();
                $("#int_tbl").hide();

                var auth_id = "{{ Auth::user()->user_id }}";

                $.ajax({
                    method: "GET",
                    dataType: 'json',
                    data: {emp_id: req_emp_id, auth_id: auth_id},
                    url: "{{ url('elm_portal/getSPLeaveList') }}",
                    success: function (resp) {
                        console.log('get_data=====', resp);
                        $("#loader").hide();
                        $("#report-body").show();

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({
                            data: resp,
                            autoWidth: true,
                            ordering: false,
                            // scrollY: 200,
                            // scrollX: true,
                                                      
                            columns: [
                                {data: "line_id"},
                                {data: "emp_id"},
                                {data: "emp_name"},
                                {data: "app_date"},
                                {data: "lv_frm_to"},
                                {data: "dol"},
                                {data: "type_of_leave"},
                                {data: "pol"},
                                {data: "rcm_approved_date"},
                                {
                                    data: "plant_head_id",
                                    className: "haccept",
                                    "render": function (data, type, row) {


                                        if ((row.plant_head_id === null)) {
                                            return '<span class="label label-warning">Pending</span>';
                                        } else {
                                            if (row.plant_head_approved !== null) {
                                                return '<span class="label label-success "> Accepted </span>';
                                            }
                                            else if ((row.plant_head_rejected !== null)) {
                                                return '<span class="label label-danger "> Rejected </span>';
                                            }
                                        }

                                    }
                                },
                                {
                                    data: null,
                                    "render": function (row) {
                                        // console.log("get row data =", row);
                                        if ((row.plant_head_id === null)) {

                                             return "<button type='button' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>" + " " +
                                                "<button type='button' class='btn btn-success btn-xs accept' id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                "<button type='button' class='btn btn-danger btn-xs reject' id='reject'><span class='glyphicon glyphicon-remove'></span>  </button>";
                                        } else {


                                            if (row.plant_head_approved !== null) {
                                                 return "<button class='btn btn-info btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>" + " " +
                                                    "<button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>";

                                            }
                                            else if (row.plant_head_rejected !== null) {
                                                 return "<button class='btn btn-info btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>" + " " +
                                                    "<button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>";
                                            }

                                        }

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
                                    "targets": [0],
                                    "visible": false
                                }
                            ],
                            info: true,
                            paging: true,
                            filter: true

                        });

                        table.columns.adjust().draw();
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
                        // console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });

        });

        // for accept button
        $(document).on('click', 'button.accept', function () {
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'accept';
            var line_id = data.line_id;
            var self = $(this);

            console.log(data);
            // alert( 'You clicked on '+data.line_id+'\'s row' + st );

            var auth_id = "{{ Auth::user()->user_id }}";

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {line_id: line_id, st: st, auth_id: auth_id},
                url: "{{ url('elm_portal/plantHeadAccept') }}",
                success: function (resp) {
                    // console.log(resp);
                    if (resp.success) {
                        // console.log(self.closest('tr').find('.saccept').html());
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
                    console.log(e);
                }
            });
        });

        //for reject button
        $(document).on('click', 'button.reject', function () {
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'reject';
            var line_id = data.line_id;
            var self = $(this);

            var auth_id = "{{ Auth::user()->user_id }}";

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {line_id: line_id, st: st, auth_id: auth_id},
                url: "{{ url('elm_portal/plantHeadReject') }}",
                success: function (resp) {
                    // console.log('rejection data =',resp);
                    if (resp.success) {
                        // console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.haccept').html('');
                        self.closest('tr').find('.haccept').html('<span class="label label-danger "> Rejected </span>');
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function () {

                }
            });

        });


        $(document).on('click', 'button.edit-btn', function () {
            // $('.edit-btn').on("click", function () {

            // console.log('Yes i am in modal');
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();

            var line_id = data.line_id;


            // console.log(line_id);


            $("#myModal").modal('show');
            // var line_id = $(this).data('id');
            $(".modal-body #line_id").val(line_id);


            $.ajax({
                type: "post",
                url: "{{url('elm_portal/plantEdEmployee')}}",
                data: {line_id: line_id, '_token': '{{csrf_token()}}'},
                success: function (data) {
                    // console.log("answer = ",data);
                    var xxx = data.resp_data[0].emp_name;
                    // console.log(xxx);
                    var chk_imgdetials = '';
                    chk_imgdetials = data.resp_data[0].type_of_leave;
                    // console.log(chk_imgdetials);

                    $('#emp_id').text(data.resp_data[0].emp_id);
                    $('#emp_name').text(data.resp_data[0].emp_name);
                    $('#applicant_name').val(data.resp_data[0].emp_name);


                    $('#desig_name').text(data.resp_data[0].emp_desig_name);
                    $('#dept').text(data.resp_data[0].emp_dept_name);
                    dt1 = data.resp_data[0].leave_from;
                    dt2 = data.resp_data[0].leave_to;


                    $('#date1').datepicker({
                        format: "dd-M-yyyy",
                        todayHighlight: 'TRUE',
                        autoclose: true,
                        minDate: 0,
                        maxDate: '+1Y+6M'
                    })
                        .datepicker('setDate', dt1)
                        .on('changeDate', function (ev) {
                            $('#date2').datepicker('setStartDate', $("#date1").val());
                            $('#tol').val();
                        });

                    $('#date2').datepicker({
                        format: "dd-M-yyyy",
                        todayHighlight: 'TRUE',
                        autoclose: true,
                        minDate: '0',
                        maxDate: '+1Y+6M'
                    })
                        .datepicker('setDate', dt2)
                        .on('changeDate', function (ev) {

                            var d1 = $('#date1').datepicker('getDate');
                            var d2 = $('#date2').datepicker('getDate');
                            var diff = 0;
                            if (d1 && d2) {
                                diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                            }
                            $('#dol').val(diff);
                        });
                    $('#dol').val(data.resp_data[0].day_of_leave);
                    $('#adl').val(data.resp_data[0].add_during_leave);
                    $('#mob').val(data.resp_data[0].emp_contact_no);
                    $('#email').val(data.resp_data[0].emp_email);
                    $('#pol').val(data.resp_data[0].purpose_of_leave);
                    $('#rsp_emp_code').val(data.resp_data[0].rsp_emp_id);
                    $('#rsp_desig').val(data.resp_data[0].rsp_desig_name);
                    $('#rsp_emp_name').val(data.resp_data[0].rsp_emp_name);

                    $('#rsp_desig_id').val(data.resp_data[0].rsp_desig_id);
                    $('#rsp_dept_id').val(data.resp_data[0].rsp_dept_id);

                    $('#rsp_dept_name').val(data.resp_data[0].rsp_dept_name);
                    $('#rsp_cnt_no').val(data.resp_data[0].rsp_contact_no);
                    $('#rsp_email').val(data.resp_data[0].rsp_email);
                    $('#rsp_duties').val(data.resp_data[0].rsp_duties);


                    //purpose for sending email for notification of cancel //
                    $('#rsp_oldname').val(data.resp_data[0].rsp_emp_name);
                    $('#rsp_oldemail').val(data.resp_data[0].rsp_email);
                    //purpose for sending email for notification of cancel //


                    var selOpts = "";
                    selOpts += "<option value=''>Select Leave</option>";
                    for (var i = 0; i < data.leavetypes.length; i++) {
                        var id = data.leavetypes[i].leave_type;
                        var val = data.leavetypes[i].leave_type;
                        selOpts += "<option value='" + id + "'>" + val + "</option>";
                    }

                    $('select#tol').empty().append(selOpts);
                    $('select#tol').val(data.resp_data[0].type_of_leave);

                    var selOptsRsp = "";
                    selOptsRsp += "<option value=''>Select Employees</option>";
                    for (var j = 0; j < data.rsp_emp.length; j++) {
                        var idx = data.rsp_emp[j].emp_id;
                        var valx = data.rsp_emp[j].sur_name;
                        selOptsRsp += "<option value='" + idx + "'>" + valx + "</option>";
                    }


                    $('select#rsp_emp').empty().append(selOptsRsp);
                    // console.log(data.resp_data[0].rsp_emp_id);
                    $('select#rsp_emp').val(data.resp_data[0].rsp_emp_id);

                    // $('#rsp_emp').val(data.resp_data[0].rsp_emp_id);

                    // console.log(data.resp_data[0].rsp_emp_id);

                    if (chk_imgdetials === 'MEDICAL') {
                        $('#spimg_show_hide').hide();
                        $('#img_show_hide').show();
                        if (data.resp_data[0].medicalimages) {
                            var nimg_url = '{{  url('public') }}';
                            var nimg_img = '';
                            nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].medicalimages + '" >';

                            // console.log("medicalimages updated = ", nimg_url + data.resp_data[0].medicalimages);

                            current_image = nimg_url + data.resp_data[0].medicalimages;

                            $('#m_img').empty().append(nimg_img);

                            $('#cl_light').on('click', function () {
                                // console.log($(this).find('img').attr('src'));
                                $('.lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));
                                $('#demoLightbox').lightbox();
                            });


                        } else if (data.resp_data[0].medicalimages === null) {
                            // console.log('Medical Image = ',data.resp_data[0].medicalimages);
                            $('#img_show_hide').show();
                            $('#img_show_hide').empty()
                                .append('<div class="col-sm-10 col-md-10 col-xs-10">' +
                                    ' <input type="file" id="medicalFile" name="medicalFile"> ' +
                                    '</div>');
                        }
                        else {
                            $('#img_show_hide').hide();

                        }
                    } else if (chk_imgdetials === 'SPECIAL MEDICAL') {

                        // console.log('======', data.resp_data[0]);
                        // console.log('======',data.resp_data[0].sp_medicalimages);


                        $('#img_show_hide').hide();
                        $('#spimg_show_hide').show();
                        if (data.resp_data[0].sp_medicalimages) {


                            var sp_org_image = data.resp_data[0].sp_medicalimages.split('|');

                            // console.log('sp_images = ', sp_org_image);


                            var sp_url = '{{  url('public') }}';
                            var sp_img = '';
                            for (var k = 0; k < sp_org_image.length; k++) {
                                sp_img += '<div class="col-md-3 col-md-offset-1 gl_light ">';
                                sp_img += '<img class="img-rounded " alt="Cinque Terre" width="204" height="136" src="' + sp_url + sp_org_image[k] + '" >';
                                sp_img += "</div>";
                            }

                            // console.log('sp_images = ', sp_img);

                            $('.sp_images').empty().append(sp_img);

                            $('.gl_light').on('click', function () {
                                // console.log($(this).find('img').attr('src'));
                                $('.lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));

                                $('#galaryLightbox').show().lightbox();
                            });

                        } else {
                            $('#spimg_show_hide').hide();
                        }


                        $('.gl_close').on('click', function (event) {
                            event.preventDefault();
                            $("#galaryLightbox").hide();

                        });


                    }

                    else if (chk_imgdetials === 'MATERNITY') {
                        $('#spimg_show_hide').hide();
                        $('#img_show_hide').hide();
                        $('#mat_show_hide').show();
                        if (data.resp_data[0].maternityimage) {
                            var nimg_url = '{{  url('public') }}';
                            var nimg_img = '';
                            nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].maternityimage + '" >';

                            // console.log("maternity updated = ", nimg_url + data.resp_data[0].maternityimage);

                            current_image = nimg_url + data.resp_data[0].maternityimage;

                            $('#mt_img').empty().append(nimg_img);

                            $('#ml_light').on('click', function () {
                                // console.log($(this).find('img').attr('src'));
                                $('.lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));
                                $('#matLightbox').lightbox();
                            });


                        } else if (data.resp_data[0].maternityimage === null) {
                            // console.log('Medical Image = ',data.resp_data[0].medicalimages);
                            $('#mat_show_hide').show();
                            $('#mat_show_hide').empty()
                                .append('<div class="col-sm-10 col-md-10 col-xs-10">' +
                                    ' <input type="file" id="mtrn_file" name="mtrn_file"> ' +
                                    '</div>');
                        }
                        else {
                            $('#mat_show_hide').hide();

                        }
                    }


                    else {
                        $('#img_show_hide').hide();
                        $('#spimg_show_hide').hide();
                        $('#mat_show_hide').hide();

                    }


                    $("#lvs").DataTable().destroy();
                    var xtable = $("#lvs").DataTable({
                        data: data.leaveStatus,
                        columns: [
                            {data: "type"},
                            {data: "annual"},
                            {data: "casual", className: 'adv'},
                            {data: "lwp"},
                            {data: "maternity"},
                            {data: "medical"},
                            // {data: "sl"},
                            {data: "advance"},
                            {data: "special_medical"}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: false,
                        paging: false,
                        filter: false

                    });

                    if(data.rsp_emp[0].gender === 'Male'){
                        $('#persone').hide();
                        xtable.column( 4 ).visible( false )
                    }else {
                        $('#persone').show();
                    }

                },
                error: function () {
                    swal({
                        type: 'error',
                        text: 'Not Found.!'
                    });
                }
            });
        });

    </script>

@endsection

