<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/25/2018
 * Time: 9:30 AM
 */ ?>
@extends('_layout_shared._master')
@section('title','My Application')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <!--pickers css-->
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/bootstrap-lightbox.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
            font-size: x-small;
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

        .modal {

        }

        .modal-dialog {
            width: 90%;
            height: 90%;

        }

        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
        }

        .vertical-align-center {
            /*To center vertically */
            display: table-cell;
            vertical-align: middle;
        }

        .modal-content {
            height: auto;
            /*min-height: 100%;*/
            border-radius: 0;
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
        }

        .form-control {
            height: 24px;

        }

        .lightbox{
            z-index: 1041;
        }
        .small-img{
            width: 100px;height: 100px;
        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        My Application Status
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
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                        <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                            <div id="export_buttons">

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
    <div class="row">
        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/preloader.gif')}}"
                        alt="Loading Report Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Please wait...</i></b></span>
                </div>
            </div>
        </div>
    </div>

 
    <div class="row" id="report-body" style="display: none;"> 
        <div class="col-sm-12 col-md-12 col-xs-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    <div class="table table-responsive">
                        <table id="leaveTbl" class="display table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>Line ID</th>
                                <th>EMP ID</th>
                                <th>APPLY DATE</th>
                                <th>LEAVE FROM</th>
                                <th>LEAVE TO</th>
                                <th>L. TYPE</th>
                                <th>D.O.L</th>
                                <th>RSP. STATUS</th>
                                <th>RCM. STATUS</th>
                                <th>APPR. STATUS</th>
                                <th>FINAL STATUS</th>
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



    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">

            <form method="post" role="form" action="{{ url('elm_portal/upApp') }}" id="edfrm" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Form Tittle</h4>
                    </div> -->


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



                                            <div class="row" id="mat_show_hide" style="display: none;">
                                                <div class="col-md-12 col-sm-12">
                                                    <b>Maternity Images: </b>
                                                    <div class="col-md-12 col-sm-12">
                                                        <button type="button" class="glyphicon glyphicon-remove-circle btn-danger mat_cls_btn"></button>
                                                        <a data-toggle="lightbox" id="ml_light" data-keyboard="true">
                                                            <div class="col-md-12 col-sm-12">
                                                                <div id="mt_img" class="small-img">
                                                                </div>

                                                            </div>
                                                        </a>


                                                        <div id="matLightbox" class="lightbox fade"  tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class='lightbox-dialog'>
                                                                <div class='lightbox-content'>
                                                                    <img src="" class="small-img" />
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


                                            <div class="row" id="img_show_hide" style="display: none;">
                                                <div class="col-md-12 col-sm-12">
                                                    <b>Medical Images: </b>
                                                    <div class="col-md-12 col-sm-12">
                                                        <button type="button" class="glyphicon glyphicon-remove-circle btn-danger cls_btn"></button>
                                                        <a data-toggle="lightbox" id="cl_light" data-keyboard="true">
                                                            <div class="col-md-12 col-sm-12">
                                                                <div id="m_img" class="small-img">
                                                                </div>

                                                            </div>
                                                        </a>


                                                        <div id="demoLightbox" class="lightbox fade"  tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class='lightbox-dialog'>
                                                                <div class='lightbox-content'>
                                                                    <img src="" class="small-img" />
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
                                                    <div class="col-md-12 col-sm-12 " style="border: 1px solid #761c19; padding: 5px;">
                                                        <a data-toggle="lightbox"  data-keyboard="true">
                                                            <div class="row">
                                                                <div id="" class="col-md-12 col-sm-12 sp_images">

                                                                </div>
                                                            </div>

                                                        </a>
                                                    </div>

                                                    <div id="galaryLightbox" class="lightbox fade"  tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class='lightbox-dialog'>

                                                            <div class='lightbox-content'>
                                                                <button class="btn btn-danger gl_close" style="float: right;" data-dismiss="lightbox">x</button>
                                                                <img  src="" class="small-img" />
                                                                {{--<div class='lightbox-caption'>--}}
                                                                {{--Write here your caption here--}}
                                                                {{--</div>--}}
                                                                {{--<div id="m_img"></div>--}}
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>

                                            <br>
                                            <br>
                                            <br>


                                            <div id="rsp_block">

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
                                                                    <select name="rsp_emp" id="rsp_emp"
                                                                            class="form-control input-sm  rsp_emp">
                                                                        <option value="">Select Employees</option>

                                                                    </select>

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
                                                                <input type="hidden" id="rsp_oldemail" name="rsp_oldemail">
                                                                <input type="hidden" id="rsp_oldname" name="rsp_oldname">

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
                            <button type="submit" class="btn btn-primary">Submit</button>
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

    {{--Date--}}
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">
        
        $(document).ready(function () {

            $('#req_year').select2();

            var rsp_idx;
            var dat1, dat2;
            var rsp_eename, rsp_eemail;
            var current_image = '';

            $('#btn_display').on('click',function(){
                console.log($('#req_year').val());
                var req_year = $('#req_year').val();
                var req_emp_id = "{{ Auth::user()->user_id }}";

                if ($("#report-body").is(":visible")) {
                    $("#report-body").hide();
                }

                $("#loader").show();

                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    data: {emp_id: req_emp_id,req_year:req_year},
                    url: "{{ url('elm_portal/getMyLeaveHistory') }}",
                    success: function (resp) {
                        $("#loader").hide();
                        $("#report-body").show();

                        console.log('Output data: ', resp);

                        $("#leaveTbl").DataTable().destroy();
                        table = $("#leaveTbl").DataTable({
                            data: resp,
                            autoWidth: true,
                            dom: 'Bfrtip',
                            buttons: [
                                'copyHtml5',
                                'excelHtml5',
                                'csvHtml5',
                                'pdfHtml5'
                            ],
                            columns: [
                                {data: "line_id"},
                                {data: "emp_id"},
                                {data: "application_date"},
                                {data: "leave_from"},
                                {data: "leave_to"},
                                {data: "type_of_leave"},
                                {data: "day_of_leave"},
                                {
                                    data: "rsp_accept" ,
                                    "render": function (data, type, row) {

                                        // //console.log(data);

                                        if ((data === 'NO') && (row.rejected_id == null)) {
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
                                    data: "sup_accept",
                                    className: "saccept",
                                    "render": function (data, type, row) {

                                        // //console.log("get row data =",row);

                                        if ((row.sup_accept === 'NO') && (row.sup_rejected_id === null)) {
                                            return '<span class="label label-warning">Pending</span>';
                                        }
                                        else if ((data === 'YES') && (row.sup_rejected_id === null)) {
                                            return '<span class="label label-success "> Accepted </span>';
                                        }
                                        else if ( (row.sup_accept === 'NO') && (row.sup_rejected_id !== null) ){
                                            return '<span class="label label-danger "> Rejected </span>';
                                        }
                                    }
                                },
                                {
                                    data: "head_rejected_id",
                                    className: "haccept",
                                    "render": function (data, type, row) {

                                        //console.log("get row data =",row);

                                        if ((row.head_rejected_id === null) && (row.rcm_approved_date === null)) {
                                            return '<span class="label label-warning">Pending</span>';
                                        }
                                        else if (row.rcm_approved_date !== null) {
                                            return '<span class="label label-success "> Accepted </span>';
                                        }
                                        else if ( (row.head_rejected_id !== null)  && (row.rcm_approved_date === null)) {
                                            return '<span class="label label-danger "> Rejected </span>';
                                        }
                                    }
                                },
                                {
                                    data: "status",
                                    "render": function (data, type, row) {

                                        //console.log("get row data =",row);

                                        if ((row.status === 'NO')) {
                                            return '<span class="label label-warning">Pending</span>';
                                        }
                                        else if (row.status === 'YES') {
                                            return '<span class="label label-success "> Accepted </span>';
                                        }                                        
                                    }
                                },
                                {
                                    data: null,
                                    "render": function (row) {
                                        if ((row.sup_accept === 'NO') && (row.rejected_id === null)) {
                                            return "<button type='button' data-id="+ row.line_id +" class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>";
                                        }                                        
                                        else {
                                            return '<button class="btn btn-info btn-xs edit-btn disabled" disabled="disabled"><span class="glyphicon glyphicon-edit"></span>   </button>';
                                        }

                                    }


                                }
                            ],
                            order:[],
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
                        // //console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });


                        
            });

    
            
            $(document).on('click','.edit-btn', function () {
                // $("#myModal").modal('show');

                    console.log('I am in');


                $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });

                var line_id = $(this).data('id');
                $(".modal-body #line_id").val(line_id);

                $.ajax({
                    type: "post",
                    url: "{{url('elm_portal/editEmployee')}}",
                    data: {line_id: line_id, '_token': '{{csrf_token()}}'},
                    success: function (data) {
                        console.log("edit button data",data);
                        var chk_imgdetials = '';
                        if(data.resp_data[0].type_of_leave){
                            chk_imgdetials = data.resp_data[0].type_of_leave;
                        }else{
                            chk_imgdetials = '';
                        }
                        
                         console.log(chk_imgdetials);


                        $('#emp_id').text(data.resp_data[0].emp_id);
                        $('#emp_name').text(data.resp_data[0].emp_name);
                        $('#desig_name').text(data.resp_data[0].emp_desig_name);
                        $('#dept').text(data.resp_data[0].emp_dept_name);
                        dt1 = data.resp_data[0].leave_from;
                        dt2 = data.resp_data[0].leave_to;


                       rsp_idx =  data.resp_data[0].rsp_emp_id;

                       if(rsp_idx === null){
                           $('#rsp_block').hide();
                       }else {
                           $('#rsp_block').show();
                       }




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
                            // selOptsRsp += "<option value='" + idx + "'>" + idx+' - '+valx + "</option>";
                        }


                        $('select#rsp_emp').empty().append(selOptsRsp);
                        $('select#rsp_emp').val(data.resp_data[0].rsp_emp_id);

                        // $('#rsp_emp').val(data.resp_data[0].rsp_emp_name);

                        if (chk_imgdetials === 'MEDICAL'){
                            $('#spimg_show_hide').hide();
                            $('#img_show_hide').show();
                            if (data.resp_data[0].medicalimages) {
                                var nimg_url = '{{  url('public') }}';
                                var nimg_img = '';
                                nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].medicalimages + '" >';

                                // console.log("medicalimages updated = ",nimg_url + data.resp_data[0].medicalimages);

                                current_image = nimg_url + data.resp_data[0].medicalimages;

                                $('#m_img').empty().append(nimg_img);

                                $('#cl_light').on('click',function () {
                                    // console.log($(this).find('img').attr('src'));
                                    $('.lightbox-content').find('img').attr('src',$(this).find('img').attr('src'));
                                    $('#demoLightbox').lightbox();
                                });


                            }else if(data.resp_data[0].medicalimages === null){
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
                        }else if (chk_imgdetials === 'SPECIAL MEDICAL') {
                            $('#img_show_hide').hide();
                            $('#spimg_show_hide').show();
                            if (data.resp_data[0].sp_medicalimages) {



                                var sp_org_image = data.resp_data[0].sp_medicalimages.split('|');

                                // console.log('sp_images = ',sp_org_image);


                                var sp_url = '{{  url('public') }}';
                                var sp_img = '';
                                for (var k = 0; k < sp_org_image.length; k++) {
                                    sp_img += '<div class="col-md-3 col-md-offset-1 gl_light ">';
                                    sp_img += '<img class="img-rounded " alt="Cinque Terre" width="204" height="136" src="' + sp_url + sp_org_image[k] + '" >';
                                    sp_img += "</div>";
                                }

                                // console.log('sp_images = ', sp_img);

                                $('.sp_images').empty().append(sp_img);

                                $('.gl_light').on('click',function () {
                                    console.log($(this).find('img').attr('src'));
                                    $('.lightbox-content').find('img').attr('src',$(this).find('img').attr('src'));

                                    $('#galaryLightbox').show().lightbox();
                                });

                            } else {
                                $('#spimg_show_hide').hide();
                            }


                            $('.gl_close').on('click',function (event) {
                                event.preventDefault();
                                $("#galaryLightbox").hide();

                            });


                        }else if (chk_imgdetials === 'MATERNITY'){
                            $('#spimg_show_hide').hide();
                            $('#img_show_hide').hide();
                            $('#mat_show_hide').show();
                            if (data.resp_data[0].maternityimage) {
                                var nimg_url = '{{  url('public') }}';
                                var nimg_img = '';
                                nimg_img += '<img class="img-rounded" alt="Cinque Terre" width="204" height="136" src="' + nimg_url + data.resp_data[0].maternityimage + '" >';

                                console.log("maternity updated = ",nimg_url + data.resp_data[0].maternityimage);

                                current_image = nimg_url + data.resp_data[0].maternityimage;

                                $('#mt_img').empty().append(nimg_img);

                                $('#ml_light').on('click',function () {
                                    // console.log($(this).find('img').attr('src'));
                                    $('.lightbox-content').find('img').attr('src',$(this).find('img').attr('src'));
                                    $('#matLightbox').lightbox();
                                });


                            }else if(data.resp_data[0].maternityimage === null){
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
                            filter: false,
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
                            text: 'Not Found.!',
                        });
                    }
                });





                $(document).on('click','.cls_btn',function (e) {
                    e.preventDefault();


                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    }).then(function(isConfirm) {

                        // console.log(isConfirm);

                        if (isConfirm.value === true) {
                            swal({
                                title: 'Success!',
                                text: 'Your Medical Image Deleted!',
                                icon: 'success'
                            }).then(function () {

                                // form.submit(); // <--- submit form programmatically
                                // console.log('closable data =',current_image);
                                // console.log('line_id =',line_id);

                                var url = "{{url('elm_portal/medImageDel')}}";
                                $.ajax({
                                    url: url,
                                    type: 'GET',
                                    dataType: 'json', // added data type
                                    data:{img_path: current_image,line_id: line_id },
                                    success: function(res) {
                                        // console.log(res);
                                        // alert(res.line_id);
                                        if(res.success === "success"){

                                            $('#img_show_hide').empty()
                                                .append('<div class="col-sm-10 col-md-10 col-xs-10">' +
                                                    ' <input type="file" id="medicalFile" name="medicalFile"> ' +
                                                    '</div>');
                                        }
                                    },
                                    error: function(e){
                                        console.log("Error: ",e);
                                    }
                                });

                            });
                        } else {
                            swal("Cancelled", "Your imaginary file is safe :)", "error");
                        }
                    })
                });


                $(document).on('click','.mat_cls_btn',function (e) {
                    e.preventDefault();


                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    }).then(function(isConfirm) {

                        // console.log(isConfirm);

                        if (isConfirm.value === true) {
                            swal({
                                title: 'Success!',
                                text: 'Your Maternity Image Deleted!',
                                icon: 'success'
                            }).then(function () {

                                // form.submit(); // <--- submit form programmatically
                                console.log('closable data =',current_image);
                                console.log('line_id =',line_id);

                                var url = "{{url('elm_portal/matImageDel')}}";
                                $.ajax({
                                    url: url,
                                    type: 'GET',
                                    dataType: 'json', // added data type
                                    data:{img_path: current_image,line_id: line_id },
                                    success: function(res) {
                                        console.log(res);
                                        // alert(res.line_id);
                                        if(res.success === "success"){

                                            $('#mat_show_hide').empty()
                                                .append('<div class="col-sm-10 col-md-10 col-xs-10">' +
                                                    ' <input type="file" id="mtrn_file" name="mtrn_file"> ' +
                                                    '</div>');
                                        }
                                    },
                                    error: function(e){
                                        console.log("Error: ",e);
                                    }
                                });

                            });
                        } else {
                            swal("Cancelled", "Your imaginary file is safe :)", "error");
                        }
                    })
                });




            });

            $('#rsp_emp').on('change', function () {
                console.log('rsp employee code == ', $('#rsp_emp').val());
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
                        console.log('data=', Object.keys(data).length);
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
                            text: 'Contact Your Administrator.!',
                        });
                    }
                });
            });

            $('form#edfrm').submit(function (e) {

                 // e.preventDefault();



                var st_dt = $('#date1').val();
                var en_dt = $('#date2').val();
                var tol = $('#tol').val();
                var dol = parseInt($('#dol').val());
                var rsp_emp_code = $('#rsp_emp_code').val();
                console.log(rsp_emp_code);
                console.log(rsp_idx);

                if(rsp_idx === null){

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
                    console.log('Anl=', anl);
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
                    console.log('Anl=', lwp);
                    if (dol > lwp) {
                        swal({
                            type: 'error',
                            text: 'Check Your LWP Leave Status.!',
                        });
                        return false;
                    }

                } else if (tol === 'MATERNITY') {
                    var mat = parseInt($('#lvs tr:eq(2) > td:eq(4)').text());
                    console.log('MATERNITY=', mat);
                    if (dol > mat) {
                        swal({
                            type: 'error',
                            text: 'Check Your LWP Leave Status.!',
                        });
                        return false;
                    }

                } else if (tol === 'MEDICAL') {
                    var medical = parseInt($('#lvs tr:eq(2) > td:eq(5)').text());                    
                    if (dol > medical) {
                        swal({
                            type: 'error',
                            text: 'Check Your medical Leave Status.!',
                        });
                        return false;
                    }

                } else if (tol === 'SL') {
                    var medical = parseInt($('#lvs tr:eq(2) > td:eq(6)').text());
                    console.log('SL=', SL);
                    if (dol > SL) {
                        swal({
                            type: 'error',
                            text: 'Check Your SL Leave Status.!',
                        });
                        return false;
                    }

                } else if (tol === 'ADVANCE') {
                    var medical = parseInt($('#lvs tr:eq(2) > td:eq(7)').text());
                    console.log('SL=', SL);
                    if (dol > SL) {
                        swal({
                            type: 'error',
                            text: 'Check Your Advane Leave Status.!',
                        });
                        return false;
                    }

                } else if (tol === 'SPECIAL MEDICAL') {
                    var splmedical = parseInt($('#lvs tr:eq(2) > td:eq(8)').text());
                    console.log('date of leave =', dol);
                    console.log('splmedical=', splmedical);
                    if (dol > splmedical) {
                        swal({
                            type: 'error',
                            text: 'Check Your Special Medical Leave Status.!',
                        });
                        return false;
                    }
                }

            });

            $(function () {
                $('#modal').modal('toggle');
            });

        });

        @if(Session::has('message'))
            var type = "";
            type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {

                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                break;
            }
        @endif


    </script>

@endsection
