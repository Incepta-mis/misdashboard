<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 07-Nov-18
 * Time: 3:50 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Leave Approval')
@section('styles')
    <link href="{{url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">--}}
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.css"> -->
    <link href="{{ url('public/site_resource/css/bootstrap-lightbox.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
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

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        /*Here starts styling of table section*/
        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        body {
            color: #000;
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
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Leave Approval
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form id="approval_hr">
                            <div class="row">
                                <div class="col-md-4 col-sm-4" style=" padding-right:0px;">
                                    <div class="form-group">
                                        <label for="comp"
                                               class="col-md-3 col-sm-3 control-label fnt_size"
                                               style="padding-right:0px;"><b>Company</b></label>
                                        <div class="col-md-9 col-sm-9" style="padding-left:0px;">
                                            <select id="comp" name="comp"
                                                    class="form-control input-sm filter-option pull-left">
                                                <option selected disabled>Select Company</option>
                                                @foreach($com as $c)
                                                    <option value="{{$c->com_id}}">{{$c->com_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-3">
                                    <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;">Plant </label>
                                    <div class="col-md-9 col-sm-9" style="padding-left:0px;">
                                        <select id="plant" name="plant"
                                                class="form-control input-sm filter-option pull-left">
                                            <option value="">Select Plant</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-5 col-sm-5">
                                    <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;">Department</label>
                                    <div class="col-md-8 col-sm-8" style="padding-left:0px;">
                                        <select id="dept" name="dept"
                                                class="form-control input-sm filter-option pull-left">
                                            <option value="">Select Department</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-sm-4 control-label input-sm"><b>Approve Status</b></label>
                                            <div class="col-sm-8">
                                                <select name="astatus" id="astatus" class="form-control input-sm m-bot15">
                                                    <option value="">Select Status</option>
                                                    <option value="All">All</option>
                                                    <option value="YES">Accepted</option>
                                                    <option value="NO">Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                                        <div class="form-group">
                                            <div class="col-md-8 col-sm-8 col-xs-8 text-center">

                                                <button type="submit" id="btn_submit" class="btn btn-warning btn-sm "
                                                        style="margin-right: 13%;">
                                                    <i class="fa fa-chevron-circle-up"></i> <b>Submit</b></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

    {{-- Table panel starts here --}}
    <div class="row" id="showTable" style="display: none;">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Emp Id</th>
                                <th>Name</th>
                                <th>Date of Leave</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Leave Type</th>
                                <th>D.O.L</th>
                                <th>Rcm. by</th>
                                <th>Appr. by</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>SP Action</th>
                                <th>Details</th>
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
    {{-- Table panel ends here --}}
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">

            <form method="post" role="form" action="{{ url('elm_portal/upApp') }}" id="edfrm">
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
                                                            <td id="dept_name"></td>
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
                                                                   name="st_dt"
                                                                   style="font-size: x-small; padding-right: 0px;"
                                                                   id="date1">
                                                        </div>

                                                        <div class="col-sm-3 col-md-3">
                                                            <input type="text" class="form-control input-sm"
                                                                   style="font-size: x-small;"
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
                                                            <select name="tol" id="tol"
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
                                                                   name="adl"
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
                                                            <input type="text" class="form-control input-xs"
                                                                   name="mob" id="mob">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="contact"
                                                               class="col-sm-4 col-md-4 control-label fnt_size"><b>Email</b></label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="text" class="form-control input-xs"
                                                                   name="email" id="email">
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
                                                                   id="pol" style="padding-left: 5px;">
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
                                                                    <img src="" class="small-img"/>
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="spimg_show_hide" style="display: none;">
                                                <div class="col-md-12 col-sm-12">
                                                    Medical Images
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
                                                                <img src="" class="small-img"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="rsp_block">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="col-md-12 col-sm-12">
                                                            <h5 class="text-center text-primary"><b>Duties Will be
                                                                    carried
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
                                                                    <input type="text" name="" id="rsp_emp">
                                                                </td>
                                                                <td><input type="text" class="form-control input-sm"
                                                                           id="rsp_emp_code"
                                                                           name="rsp_emp_code"></td>
                                                                <td><input type="text" class="form-control input-sm"
                                                                           id="rsp_desig"
                                                                           name="rsp_desig_name"></td>
                                                                <td><input type="text" class="form-control input-sm"
                                                                           id="rsp_dept_name"
                                                                           name="rsp_dept_name"></td>

                                                                <input type="hidden" class="form-control input-sm"
                                                                       id="rsp_emp_name" name="rsp_emp_name">
                                                                <input type="hidden" class="form-control input-sm"
                                                                       id="rsp_desig_id"
                                                                       name="rsp_desig_id">
                                                                <input type="hidden" class="form-control input-sm"
                                                                       id="rsp_dept_id"
                                                                       name="rsp_dept_id">
                                                                <input type="hidden" id="rsp_oldemail"
                                                                       name="rsp_oldemail">
                                                                <input type="hidden" id="rsp_oldname"
                                                                       name="rsp_oldname">
                                                            </tr>
                                                            <tr>
                                                                <td class="cnt " colspan="2"><b>Contact No:</b> <input
                                                                            type="text"
                                                                            class="form-control input-sm"
                                                                            id="rsp_cnt_no"
                                                                            name="rsp_cnt_no"/>
                                                                </td>
                                                                <td class="cnt " colspan="2"><b>Email:</b> <input
                                                                            type="text"
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
                                                                       name="rsp_duties"
                                                                       id="rsp_duties">
                                                            </div>
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="FileModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Medical Image File</h4>
                </div>
                <div class="modal-body">
                    <div class="row" id="medicalimg_modal_div" style="display: none;">
                        <div class="col-md-12 col-sm-12">
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
                                        <img src="" class="small-img"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script>
        $(document).ready(function () {
            let fileArray = new Array();
            let rsp_idx;
            let current_image;

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
                        console.log(data.plant);
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


            //Changing company from option ended here

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
                        console.log(data.dept);
                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            op += '<option value= "ALL">ALL</option>';
                            for (var i = 0; i < data.dept.length; i++) {

                                op += '<option value= " ' + data.dept[i]['dept_id'] + ' ">' + data.dept[i]['dept_name'] + '</option>';
                            }
                            $('#dept').html(" ");
                            $('#dept').append(op);

                        } else {
                            $('#dept').html(" ");
                            $('#dept').append('<option value="0" selected disabled>No Department available in this Category</option>');
                            // console.log("no data found");
                        }

                    },
                    error: function () {

                    }


                });

            });
            var table = "";

            $(document).on('submit', '#approval_hr', function (event) {
                event.preventDefault();
                var plant_id = $('#plant').val();
                var dept_id = $('#dept').val();
                var url = "{{URL::to('elm_portal/list_of_leave')}}";
                var type = 'post';
                if ($("#showTable").is(":visible")) {
                    $("#showTable").hide();
                }

                $("#loader").show();

                $.ajax({
                    url: url,
                    type: type,
                    data: {
                        dept_id: dept_id, plant_id: plant_id,a_status:$('#astatus').val().trim(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        // console.log(data);
                        $("#loader").hide();
                        $("#showTable").show();
                        $('#elr').DataTable().destroy();
                        table = $('#elr').DataTable(
                            {
                                data: data.leaverecord,
                                columns: [
                                    {data: "emp_id"},
                                    {data: "emp_name"},
                                    {data: "dt"},
                                    {data: "emp_contact_no"},
                                    {data: "emp_email"},
                                    {data: "type_of_leave"},
                                    {data: "day_of_leave"},
                                    {data: "recommended_by"},
                                    {data: "approved_by"},
                                    {
                                        data: null,
                                        "render": function (row) {
                                            if ((row.status == 'NO') && (row.hr_rejected_id == null)) {
                                                return '<span class="label label-warning">Pending</span>';
                                            } else if ((row.status == 'YES') && (row.hr_rejected_id == null)) {

                                                return '<span class="label label-success"> Accepted </span>';

                                            } else if ((row.status == 'NO') && ((row.hr_rejected_id) !== null)) {

                                                return '<span class="label label-danger">Rejected</span>';

                                            }else if ((row.status == 'YES') && ((row.hr_rejected_id) !== null)) {

                                                return '<span class="label label-danger">Rejected</span>';

                                            }else{
                                                return '';
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        "render": function (row) {
                                            if ((row.status == 'NO') && (row.hr_rejected_id == null)) {

                                                return "<button type='button' class='btn btn-info btn-xs accept'id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button type='button' class='btn btn-danger btn-xs reject' id='reject'><span class='glyphicon glyphicon-remove'></span>  </button>" + " " +
                                                    "<button type='button' class='btn btn-warning btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>";
                                            } else if ((row.status == 'YES') && (row.hr_rejected_id == null)) {
                                                return "<button  class='btn btn-info btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>" + " " +
                                                    "<button class='btn btn-warning btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>";
                                            } else if ((row.status == 'NO') && ((row.hr_rejected_id) !== null)) {
                                                return "<button  class='btn btn-info btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>" + " " +
                                                    "<button class='btn btn-warning btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>";
                                            }else if ((row.status == 'YES') && ((row.hr_rejected_id) !== null)) {
                                                return "<button  class='btn btn-info btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>" + " " +
                                                    "<button class='btn btn-warning btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>";
                                            }

                                        }
                                    },
                                    {
                                        data: null,
                                        "render": function (row) {

                                            if (((row.status == 'YES') && (row.hr_rejected_id == null)) || ((row.status == 'YES') && ((row.hr_rejected_id) !== null))) {
                                                return "<button  class='btn btn-primary btn-xs sp_accept disabled'><span class='glyphicon glyphicon-fast-forward'></span>  </button>";
                                            } else if ((row.type_of_leave == 'ANNUAL' || row.type_of_leave == 'SPECIAL MEDICAL'
                                                || row.type_of_leave == 'LWP' || row.type_of_leave == 'MATERNITY'
                                                || row.type_of_leave == 'ADVANCE' || row.type_of_leave == 'HAJJ') && ((row.forward_emp) == null)) {
                                                return "<button type='button' class='btn btn-primary btn-xs sp_accept' id='sp_accept'>" +
                                                    "<span class='glyphicon glyphicon-fast-forward'></span>  </button>";
                                            } else {
                                                return "<button class='btn btn-primary btn-xs sp_accept disabled'><span class='glyphicon glyphicon-fast-forward'></span> </button>";
                                            }

                                        }
                                    },
                                    {
                                        data: null,
                                        "render": function (row) {
                                            if(row.type_of_leave == 'MEDICAL' && row.medicalimages != null){
                                                return '<button class="btn btn-info btn-xs" ' +
                                                    'onclick="SeeFile('+"'"+row.line_id+"','"+row.medicalimages+"')"+'"><span ' +
                                                    'class="glyphicon glyphicon glyphicon-file" ' +
                                                    'title="See Medical Image File"></span></button>';
                                            }else if(row.type_of_leave == 'MATERNITY' && row.maternityimage != null){
                                                return '<button class="btn btn-success btn-xs" ' +
                                                    'onclick="SeeFile('+"'"+row.line_id+"','"+row.maternityimage+"')"+'"><span ' +
                                                    'class="glyphicon glyphicon glyphicon-file" ' +
                                                    'title="See Maternity Image File"></span></button>';
                                            }else if(row.type_of_leave == 'SPECIAL MEDICAL' && row.sp_medicalimages != null){
                                                return '<button class="btn btn-warning btn-xs" ' +
                                                    'onclick="SeeFile('+"'"+row.line_id+"','"+row.sp_medicalimages+"')"+'"><span ' +
                                                    'class="glyphicon glyphicon glyphicon-file" ' +
                                                    'title="See Special Medical Image File"></span></button>';
                                            }
                                            else{
                                                return "";
                                            }
                                        }
                                    }
                                ]
                            }
                        );
                        $("#showTable").show();
                        table.columns.adjust();

                    },
                    error: function (data) {
                        console.log("fail");
                    }
                });
            });

            function updateTable() {
                var dept_id = $('#dept').val();
                var url = "{{URL::to('elm_portal/list_of_leave')}}";
                var type = 'post';
                $.ajax({
                    url: url,
                    type: type,
                    data: {
                        dept_id: dept_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        console.log("Testing...", data);
                        $('#elr').DataTable().destroy();
                        table = $('#elr').DataTable(
                            {
                                data: data.leaverecord,
                                columns: [
                                    {data: "emp_id"},
                                    {data: "emp_name"},
                                    {data: "dt"},
                                    {data: "emp_contact_no"},
                                    {data: "emp_email"},
                                    {data: "type_of_leave"},
                                    {data: "day_of_leave"},
                                    {data: "recommended_by"},
                                    {data: "approved_by"},
                                    {
                                        data: null,
                                        "render": function (row) {
                                            if (row.status == 'NO' && row.hr_rejected_id == null) {
                                                return '<span class="label label-warning">Pending</span>';
                                            } else if ((row.status == 'YES') && (row.hr_rejected_id == null)) {

                                                return '<span class="label label-success"> Accepted </span>';

                                            } else if ((row.status == 'YES') && ((row.hr_rejected_id) !== null)) {

                                                return '<span class="label label-danger">Rejected</span>';

                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        "render": function (row) {
                                            if ((row.status == 'NO') && (row.hr_rejected_id == null)) {

                                                return "<button type='button' class='btn btn-info btn-xs accept'id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button type='button' class='btn btn-danger btn-xs reject' id='reject'><span class='glyphicon glyphicon-remove'></span>  </button>" + " " +
                                                    "<button type='button' class='btn btn-warning btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>";

                                            } else if ((row.status == 'YES') && (row.hr_rejected_id == null)) {
                                                return "<button  class='btn btn-info btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>" + " " +
                                                    "<button class='btn btn-warning btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>";
                                            } else if ((row.status == 'YES') && ((row.hr_rejected_id) !== null)) {
                                                return "<button  class='btn btn-info btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                    "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>" + " " +
                                                    "<button class='btn btn-warning btn-xs edit-btn disabled'><span class='glyphicon glyphicon-edit'></span>   </button>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        "render": function (row) {
                                            if (((row.status == 'YES') && (row.hr_rejected_id == null)) || ((row.status == 'YES') && ((row.hr_rejected_id) !== null))) {
                                                return "<button  class='btn btn-primary btn-xs sp_accept disabled'><span class='glyphicon glyphicon-fast-forward'></span>  </button>";
                                            } else if ((row.type_of_leave == 'ANNUAL' || row.type_of_leave == 'SPECIAL MEDICAL'
                                                    || row.type_of_leave == 'LWP' || row.type_of_leave == 'MATERNITY'
                                                    || row.type_of_leave == 'ADVANCE')
                                                && ((row.forward_emp) == null)) {

                                                return "<button type='button' class='btn btn-primary btn-xs sp_accept' id='sp_accept'>" +
                                                    "<span class='glyphicon glyphicon-fast-forward'></span>  </button>";

                                            } else {
                                                return "<button  class='btn btn-primary btn-xs sp_accept disabled'><span class='glyphicon glyphicon-fast-forward'></span>  </button>";
                                            }
                                        }
                                    }
                                ]
                            }
                        );
                        $("#showTable").show();
                        table.columns.adjust();

                    },
                    error: function (data) {
                        console.log("fail");
                    }
                });
            }
            //Accept button starts here
            $('#elr tbody').on('click', '#accept', function () {

                    var value_accept = '';
                    value_accept = table.row($(this).parents('tr')).data()['line_id'];
                    console.log(value_accept);

                    $(this).attr('disabled','disabled');
                    $(this).parents('tr').find('#reject').attr('disabled','disabled');
                    $(this).parents('tr').css('display','none');

                    $.ajax({
                        type: "post",
                        url: '{{url('elm_portal/accept_leave_hr')}}',
                        data: {
                            _token: '{{csrf_token()}}',
                            value_accept: value_accept
                        },
                        success: function (data) {
                            console.log(data);
                            // updateTable();
                            // toastr.success('Leave has been approved');

                        },
                        error: function () {
                            console.log(error);
                        }
                    });
                }
            );
            //     //Accept button finishes here

            //    Reject button starts here
            $('#elr tbody').on('click', '#reject', function () {
                var value_reject = table.row($(this).parents('tr')).data()['line_id'];

                $(this).attr('disabled','disabled');
                $(this).parents('tr').find('#accept').attr('disabled','disabled');
                $(this).parents('tr').css('display','none');
                
                $.ajax({
                    type: "post",
                    url: '{{url('elm_portal/reject_leave_hr')}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        value_reject: value_reject
                    },
                    success: function (data) {
                        console.log("return data = ", data);
                        updateTable();
                    },
                    error: function () {
                        console.log(error);
                    }
                });
            });
            //Reject button finishes here

            $('#elr tbody').on('click', '.edit-btn', function () {
                var line_id = table.row($(this).parents('tr')).data()['line_id'];

                $("#myModal").modal('show');
                $(".modal-body #line_id").val(line_id);

                $.ajax({
                    type: "post",
                    url: "{{url('elm_portal/pappeditEmployee')}}",
                    data: {line_id: line_id, '_token': '{{csrf_token()}}'},
                    success: function (data) {
                        var xxx = data.resp_data[0].emp_name;

                        var chk_imgdetials = '';
                        chk_imgdetials = data.resp_data[0].type_of_leave;

                        $('#emp_id').text(data.resp_data[0].emp_id);
                        $('#emp_name').text(data.resp_data[0].emp_name);
                        $('#applicant_name').val(data.resp_data[0].emp_name);

                        rsp_idx = data.resp_data[0].rsp_emp_id;
                        if (rsp_idx === null) {
                            $('#rsp_block').hide();
                        } else {
                            $('#rsp_block').show();
                        }

                        $('#desig_name').text(data.resp_data[0].emp_desig_name);
                        $('#dept_name').text(data.resp_data[0].emp_dept_name);
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

                        $('#rsp_oldname').val(data.resp_data[0].rsp_emp_name);
                        $('#rsp_oldemail').val(data.resp_data[0].rsp_email);

                        var selOpts = "";
                        selOpts += "<option value=''>Select Leave</option>";
                        for (var i = 0; i < data.leavetypes.length; i++) {
                            var id = data.leavetypes[i].leave_type;
                            var val = data.leavetypes[i].leave_type;
                            selOpts += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('select#tol').empty().append(selOpts);
                        $('select#tol').val(data.resp_data[0].type_of_leave);

                        $('#rsp_emp').val(data.resp_data[0].rsp_emp_name);

                        if (chk_imgdetials === 'MEDICAL') {
                            $('#spimg_show_hide').hide();
                            $('#img_show_hide').show();

                            if (data.resp_data[0].medicalimages) {
                                var nimg_url = '{{  url('public') }}';
                                var nimg_img = '';
                                nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].medicalimages + '" >';

                                current_image = nimg_url + data.resp_data[0].medicalimages;

                                $('#m_img').empty().append(nimg_img);

                                $('#cl_light').on('click', function () {
                                    $('.lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));
                                    $('#demoLightbox').lightbox();
                                });


                            } else if (data.resp_data[0].medicalimages === null) {
                                $('#img_show_hide').show();
                                $('#img_show_hide').empty()
                                    .append('<div class="col-sm-10 col-md-10 col-xs-10">' +
                                        ' <input type="file" id="medicalFile" name="medicalFile"> ' +
                                        '</div>');
                            } else {
                                $('#img_show_hide').hide();

                            }
                        } else if (chk_imgdetials === 'SPECIAL MEDICAL') {
                            $('#img_show_hide').hide();
                            $('#spimg_show_hide').show();
                            if (data.resp_data[0].sp_medicalimages) {
                                var sp_org_image = data.resp_data[0].sp_medicalimages.split('|');
                                var sp_url = '{{  url('public') }}';
                                var sp_img = '';
                                for (var k = 0; k < sp_org_image.length; k++) {
                                    sp_img += '<div class="col-md-3 col-md-offset-1 gl_light ">';
                                    sp_img += '<img class="img-rounded " alt="Cinque Terre" width="204" height="136" src="' + sp_url + sp_org_image[k] + '" >';
                                    sp_img += "</div>";
                                }
                                $('.sp_images').empty().append(sp_img);
                                $('.gl_light').on('click', function () {

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
                        } else if (chk_imgdetials === 'MATERNITY') {
                            $('#spimg_show_hide').hide();
                            $('#img_show_hide').hide();
                            $('#mat_show_hide').show();
                            if (data.resp_data[0].maternityimage) {
                                var nimg_url = '{{  url('public') }}';
                                var nimg_img = '';
                                nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].maternityimage + '" >';

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
                            } else {
                                $('#mat_show_hide').hide();

                            }
                        } else {
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

                        if (data.rsp_emp[0].gender === 'Male') {
                            $('#persone').hide();
                            xtable.column(4).visible(false)
                        } else {
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

                $('#rsp_emp').on('change', function () {
                    // console.log('rsp employee code == ', $('#rsp_emp').val());
                    var emp_id = $('#rsp_emp').val();

                    if (emp_id === '') {
                        $('#rsp_emp_name').val('');
                        $('#rsp_emp_code').val('');
                        $('#rsp_desig_id').val('');
                        $('#rsp_desig').val('');
                        $('#rsp_dept_id').val('');
                        $('#rsp_dept_name').val('');
                        $('#rsp_cnt_no').val('');
                        $('#rsp_email').val('');
                    }

                    $.ajax({
                        type: "post",
                        url: "{{url('elm_portal/getRspInfo')}}",
                        data: {emp_id: emp_id, '_token': '{{csrf_token()}}'},
                        success: function (data) {
                            // console.log('data=', Object.keys(data).length);
                            if (Object.keys(data).length !== 0) {
                                $('#rsp_emp_name').val(data[0].sur_name);
                                $('#rsp_emp_code').val(data[0].emp_id);
                                $('#rsp_desig_id').val(data[0].desig_id);
                                $('#rsp_desig').val(data[0].desig_name);
                                $('#rsp_dept_id').val(data[0].dept_id);
                                $('#rsp_dept_name').val(data[0].dept_name);
                                $('#rsp_cnt_no').val(data[0].contact_no);
                                $('#rsp_email').val(data[0].mail_address);
                            }

                        },
                        error: function () {
                            swal({
                                type: 'error',
                                text: 'Contact Your Administrator.!'
                            });
                        }
                    });
                });

                $('form#edfrm').submit(function (e) {

                    e.preventDefault();

                    var st_dt = $('#date1').val();
                    var en_dt = $('#date2').val();
                    var tol = $('#tol').val();
                    var dol = parseInt($('#dol').val());
                    var rsp_emp_code = $('#rsp_emp_code').val();
                    // console.log(rsp_emp_code);

                    console.log(rsp_idx);
                    if (rsp_idx === null) {

                    } else {
                        if (rsp_emp_code === '') {

                            swal({
                                type: 'error',
                                text: 'Please Select Responsible Person.!',
                            });
                            return false;
                        }
                    }
                    if (dol < 1) {
                        swal({
                            type: 'error',
                            text: 'Check Your Date From and To!',
                        });
                        return false;
                    } else if (tol === '') {
                        swal({
                            type: 'error',
                            text: 'Type of Leave Can\'t be null!',
                        });
                        return false;
                    } else if (st_dt === '') {
                        swal({
                            type: 'error',
                            text: 'Check Your From Date.!',
                        });
                        return false;
                    } else if (en_dt === '') {
                        swal({
                            type: 'error',
                            text: 'Check Your To Date.!',
                        });
                        return false;
                    } else if (tol === 'ANNUAL') {
                        var anl = parseInt($('#lvs tr:eq(2) > td:eq(1)').text());
                        // console.log('Anl=', anl);
                        if (dol > anl) {
                            swal({
                                type: 'error',
                                text: 'Check Your Annual Leave Status.!',
                            });
                            return false;
                        }

                    } else if (tol === 'CASUAL') {
                        var cas = parseInt($('#lvs tr:eq(2) > td:eq(2)').text());
                        if (dol > cas) {
                            swal({
                                type: 'error',
                                text: 'Check Your Casual Leave Status.!',
                            });
                            return false;
                        }

                    } else if (tol === 'LWP') {
                        var lwp = parseInt($('#lvs tr:eq(2) > td:eq(3)').text());
                        // console.log('Anl=', lwp);
                        if (dol > lwp) {
                            swal({
                                type: 'error',
                                text: 'Check Your LWP Leave Status.!',
                            });
                            return false;
                        }

                    } else if (tol === 'MATERNITY') {
                        var mat = parseInt($('#lvs tr:eq(2) > td:eq(4)').text());
                        // console.log('MATERNITY=', mat);
                        if (dol > mat) {
                            swal({
                                type: 'error',
                                text: 'Check Your LWP Leave Status.!',
                            });
                            return false;
                        }

                    } else if (tol === 'MEDICAL') {
                        var medical = parseInt($('#lvs tr:eq(2) > td:eq(5)').text());
                        // console.log('medical=', medical);
                        if (dol > medical) {
                            swal({
                                type: 'error',
                                text: 'Check Your medical Leave Status.!',
                            });
                            return false;
                        }
                    }
                    else if (tol === 'ADVANCE') {
                        var advance = parseInt($('#lvs tr:eq(2) > td:eq(7)').text());
                        if (dol > advance) {
                            swal({
                                type: 'error',
                                text: 'Check Your Advance Leave Status.!',
                            });
                            return false;
                        }

                    } else if (tol === 'SPECIAL MEDICAL') {
                        var splmedical = parseInt($('#lvs tr:eq(2) > td:eq(8)').text());
                        if (dol > splmedical) {
                            swal({
                                type: 'error',
                                text: 'Check Your Special Medical Leave Status.!',
                            });
                            return false;
                        }
                    }

                    let data = $("#edfrm").serialize() ; // it will serialize the form data
                    let form_data = new FormData();

                    let fileInput = $.trim($("#medicalFile").val());
                    console.log("medical file "+fileInput);
                    if (fileInput && fileInput !== '') {
                        if ($('#medicalFile').get(0).files.length !== 0) {
                            fileArray = [];
                            fileArray.push($('#medicalFile').prop('files')[0]);
                        }
                        // return true;
                    }
                    if (tol === 'MATERNITY') {
                        if($('#mtrn_file').length > 0){
                            if( document.getElementById("mtrn_file").files.length !== 0 ){
                                if ($('#mtrn_file').get(0).files.length !== 0) {
                                    fileArray = [];
                                    fileArray.push($('#mtrn_file').prop('files')[0]);
                                }
                            }
                        }
                    }

                    if (fileArray.length >= 0) {
                        var x;
                        for (x = 0; x < fileArray.length; x++) {
                            form_data.append('files[]', fileArray[x]);
                        }
                    }
                    form_data.append('_token','{{csrf_token()}}');
                    form_data.append('data',data);

                    let url = "{{ url('elm_portal/masterpleaveapp') }}";
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: form_data, // added the { } to protect the data
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) { // here we use the success event
                            if (data.success) {
                                toastr.success(data.success, '', {timeOut: 2000});
                                $("#myModal").modal('hide');
                            } else {
                                toaster.error(data.error, '', {timeOut: 2000});
                                $("#myModal").modal('hide');
                            }

                        },
                        error: function (request, status, error) { // handles error
                            // alert(request.responseText); // change alert to whatever you want/need
                            alert(error); // change alert to whatever you want/need
                        }
                    })
                });
            });


            $('#elr tbody').on('click', '.sp_accept', function () {
                var line_id = table.row($(this).parents('tr')).data()['line_id'];
                var emp_id = table.row($(this).parents('tr')).data()['emp_id'];

                var txt;
                var r = confirm("Press a button!\nEither OK or Cancel.");
                if (r == true) {

                    $.ajax({
                        method: "get",
                        url: '{{url('elm_portal/sendtoplan_head')}}',
                        data: {
                            {{--_token: '{{csrf_token()}}',--}}
                            line_id: line_id,
                            emp_id: emp_id
                        },
                        success: function (data) {
                            console.log(data);
                            toastr.success('Leave has been approved');
                            $(this).prop('disabled', true);
                        },
                        error: function () {

                            console.log(error);
                        }
                    });
                } else {

                }
            });

            $('.cls_btn').on('click', function () {
                console.log('Yes Clicked for delete');
                let data = $("#edfrm").serialize() ; // it will serialize the form data
                let form_data = new FormData();
                form_data.append('_token','{{csrf_token()}}');
                form_data.append('data',data);
                let url = "{{ url('elm_portal/mImageDelete') }}";
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.success) {
                            toastr.success(data.success, '', {timeOut: 2000});

                        } else {
                            toaster.error(data.error, '', {timeOut: 2000});
                        }
                    },
                    error: function (request, status, error) {
                        alert(error);
                    }
                })
            });
        });
        function SeeFile( line_id, medicalImages ){
            $('#FileModal').modal('show');
            var nimg_url = '{{  url('public') }}';
            var nimg_img = '';
            nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + medicalImages + '" >';

            current_image = nimg_url + medicalImages;

            $('#medicalimg_modal_div #m_img').empty().append(nimg_img);

            $('#medicalimg_modal_div #cl_light').on('click', function () {
                $('#medicalimg_modal_div .lightbox-content').find('img').attr('src', $(this).find('img').attr('src'));
                $('#medicalimg_modal_div #demoLightbox').lightbox();
            });
            $('#medicalimg_modal_div').show();
        }
    </script>
@endsection