<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 19/02/2020
 * Time: 12:31 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','Talent Development Form')
@section('styles')

    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
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

        body {
            color: black;
        }

        .t_font {
            font-size: 8px;
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

        #myTable > thead > tr > th {
            padding: 4px;
            font-size: 11px;
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

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }

        .form-group.required .control-label:after {
            content: "*";
            color: red;
        }


        .wizard {
            margin: 20px auto;
            background: #fff;
        }

        .wizard .nav-tabs {
            position: relative;
            border-bottom-color: #e0e0e0;
        }

        .wizard > div.wizard-inner {
            position: relative;
        }

        .connecting-line {
            height: 2px;
            background: #e0e0e0;
            position: absolute;
            width: 60%;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: 50%;
            z-index: 1;
        }

        .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
            color: #555555;
            cursor: default;
            border: 0;
            border-bottom-color: transparent;
        }

        span.round-tab {
            width: 70px;
            height: 70px;
            line-height: 70px;
            display: inline-block;
            border-radius: 100px;
            background: #fff;
            border: 2px solid #e0e0e0;
            z-index: 2;
            position: absolute;
            left: 0;
            text-align: center;
            font-size: 25px;
        }

        span.round-tab i {
            color: #555555;
        }

        .wizard li.active span.round-tab {
            background: #fff;
            border: 2px solid #5bc0de;

        }

        .wizard li.active span.round-tab i {
            color: #5bc0de;
        }

        span.round-tab:hover {
            color: #333;
            border: 2px solid #333;
        }

        .wizard .nav-tabs > li {
            width: 33%;
        }

        .wizard li:after {
            content: " ";
            position: absolute;
            left: 46%;
            opacity: 0;
            margin: 0 auto;
            bottom: 0px;
            border: 5px solid transparent;
            border-bottom-color: #5bc0de;
            transition: 0.1s ease-in-out;
        }

        .wizard li.active:after {
            content: " ";
            position: absolute;
            left: 46%;
            opacity: 1;
            margin: 0 auto;
            bottom: 0px;
            border: 10px solid transparent;
            border-bottom-color: #5bc0de;
        }

        .wizard .nav-tabs > li a {
            width: 70px;
            height: 70px;
            margin: 20px auto;
            border-radius: 100%;
            padding: 0;
        }

        .wizard .nav-tabs > li a:hover {
            background: transparent;
        }

        .wizard .tab-pane {
            position: relative;
            /*padding-top: 50px;*/
        }

        .wizard h3 {
            margin-top: 0;
        }

        @media ( max-width: 585px ) {

            .wizard {
                width: 90%;
                height: auto !important;
            }

            span.round-tab {
                font-size: 16px;
                width: 50px;
                height: 50px;
                line-height: 50px;
            }

            .wizard .nav-tabs > li a {
                width: 50px;
                height: 50px;
                line-height: 50px;
            }

            .wizard li.active:after {
                content: " ";
                position: absolute;
                left: 35%;
            }
        }

        #outer {
            width: 100%;
            text-align: center;
        }

        .inner {
            display: inline-block;
            padding: 1%;
        }

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.0em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }


        /*Modal Css Starts*/
        .modal-confirm {
            color: #434e65;
            width: 525px;
        }
        .modal-confirm .modal-content {
            padding: 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }
        .modal-confirm .modal-header {
            background: #47c9a2;
            border-bottom: none;
            position: relative;
            text-align: center;
            margin: -20px -20px 0;
            border-radius: 5px 5px 0 0;
            padding: 35px;
        }
        .modal-confirm h4 {
            text-align: center;
            font-size: 36px;
            margin: 10px 0;
        }
        .modal-confirm .form-control, .modal-confirm .btn {
            min-height: 40px;
            border-radius: 3px;
        }
        .modal-confirm .close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #fff;
            text-shadow: none;
            opacity: 0.5;
        }
        .modal-confirm .close:hover {
            opacity: 0.8;
        }
        .modal-confirm .icon-box {
            color: #fff;
            width: 95px;
            height: 95px;
            display: inline-block;
            border-radius: 50%;
            z-index: 9;
            border: 5px solid #fff;
            padding: 15px;
            text-align: center;
        }
        .modal-confirm .icon-box i {
            font-size: 64px;
            margin: -4px 0 0 -4px;
        }
        .modal-confirm.modal-dialog {
            margin-top: 80px;
        }
        .modal-confirm .btn, .modal-confirm .btn:active {
            color: #fff;
            border-radius: 4px;
            background: #eeb711 !important;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            border-radius: 30px;
            margin-top: 10px;
            padding: 6px 20px;
            border: none;
        }
        .modal-confirm .btn:hover, .modal-confirm .btn:focus {
            background: #eda645 !important;
            outline: none;
        }
        .modal-confirm .btn span {
            margin: 1px 3px 0;
            float: left;
        }
        .modal-confirm .btn i {
            margin-left: 1px;
            font-size: 20px;
            float: right;
        }
        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
        }
        /*Modal Css Ends*/


        .myStyle {
            padding: 3px;
            margin: 1px;
            background-color: #fff;
            width: 500px;
        }


        .info {
            background-color: #e7f3fe;
            border-left: 6px solid #2196F3;
            padding: 20px 0;
            padding-left: 10px;

        }



    </style>
@endsection
@section('right-content')

    {{--Only Supervisor and HOD  View--}}
    @if(!empty($cnt[0]->mgr > 0))
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <form class="form-horizontal" role="form" id="idForm" action="{{ url('talent_development/tds_form') }}">
                    <section class="panel panel-info">
                        <div class="panel-heading">
                            <label class="text-default text-center">
                                Employee Information
                            </label>
                        </div>
                        <div class="panel-body" style="padding-top: 2%">

                            <div class="col-md-8 col-sm-8">
                                <div class="form-group">
                                    <label for="emp_id" class="col-lg-2 col-sm-2 control-label">Employee</label>
                                    <div class="col-lg-10">
                                        <select name="emp_id" id="emp_id" class="form-control input-sm m-bot15 emp_id">
                                            <option value="">Select Employee</option>
                                            @if(!empty($empList))
                                                @foreach($empList as $e)
                                                    <option value="{{$e->emp_id}}">{{$e->emp_id}} - {{$e->emp_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                </form>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="wizard">

                @if(!empty($head_of_dept))
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Page 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Page 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                                </a>
                            </li>
                        </ul>
                    </div>


                @else
                    <div class="wizard-inner" >
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active" style="visibility:hidden">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Page 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                                </a>
                            </li>

                            <li role="presentation" class="active">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Page 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled" style="visibility: hidden">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                <form role="form">
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">

                            <form id="" method="post" action="{{ url('talent_development/employeeTdpdf') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="emp_id" value="{{ $emp_his_info[0]->emp_id }}">

                                <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                                    <section class="panel panel-info">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if($emp_his_info)
                                                    <?php
                                                    $rr= $emp_his_info[0]->birt_dt_ssc;
                                                    $date = new DateTime($rr);
                                                    $now = new DateTime();
                                                    $interval = $now->diff($date);
                                                    $age = $interval->y;
                                                    ?>

                                                @else
                                                    <?php
                                                    $age ='';
                                                    ?>

                                                @endif
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>

                                                        <td>
                                                            <table border="0" cellpadding="2" cellspacing="2" width="100%">
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b style="color:#337ab7;">PERSONAL INFORMATION</b>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Name:</td>
                                                                    <td id="selected_emp_fname">{{ $emp_his_info[0]->sur_name? $emp_his_info[0]->sur_name:''  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Birth Date:</td>
                                                                    <td>{{ $emp_his_info[0]->birt_dt_ssc?(Carbon\Carbon::parse($emp_his_info[0]->birt_dt_ssc)->format('d-m-Y')):''  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Age:</td>
                                                                    <td id="selected_emp_age">{{$age?$age:''}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Emp. ID :</td>
                                                                    <td id="selected_emp_id"> {{ $emp_his_info[0]->emp_id }}</td>
                                                                </tr>
                                                            </table>
                                                        </td>


                                                        <td>
                                                            <table style="border: none;" cellpadding="2" cellspacing="2"
                                                                   width="100%">
                                                                <tr>
                                                                    <td style="text-align: center">
                                                                        <div class="image">
                                                                            @if(empty($emp_his_moreinfoid[0]->emp_img))
                                                                                <img
                                                                                        src="{{url('public/site_resource/images/user.png')}}"
                                                                                        class="rounded" width="100"
                                                                                        height="100">

                                                                            @else
                                                                                <img
                                                                                        src="{{url('public/emp_history_img/'.$emp_his_moreinfoid[0]->emp_img)}}"
                                                                                        class="rounded" width="100"
                                                                                        height="100">
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>


                                                        <td>
                                                            <table style="border-right: none;" cellpadding="2"
                                                                   cellspacing="2" width="100%">
                                                                <tr>
                                                                    <td colspan="2"><b style="color:#337ab7;">CURRENT
                                                                            POSITION</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Position:</td>
                                                                    <td>{{ $emp_his_info[0]->desig_name  }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Country:</td>
                                                                    <td> {{ $emp_his_info[0]->nationality  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Date Appointed:</td>
                                                                    <td>{{Carbon\Carbon::parse($emp_his_info[0]->joining_date)->format('d-m-Y')}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>


                                                        <td>
                                                            <table border="0" cellpadding="2" cellspacing="2" width="100%">
                                                                <tr>

                                                                    <td colspan="2"><b style="color:#337ab7;">MANAGER(S)</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>DIRECT n+1:</td>
                                                                    <td>{{ $head_dtl[0]->sur_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Position:</td>
                                                                    <td> {{ $head_dtl[0]->desig_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Date Appointed:</td>
                                                                    <td>{{Carbon\Carbon::parse($head_dtl[0]->joining_date)->format('d-m-Y')}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>


                                <div class="col-lg-12 col-sm-12">
                                    <label for="">
                                        <scan style="color:#337ab7"><b> <i>INTERNAL CAREER HISTORY </i> </b></scan>
                                    </label>
                                    <table class="table table-bordered table-striped employment_table">
                                        <thead>
                                        <th colspan="2" style="text-align: center;">EMPLOYMENT DATES</th>
                                        <th style="text-align: center;">POSITION / DEPARTMENT</th>
                                        <th style="text-align: center;">COUNTRY</th>
                                        </thead>
                                        <tbody>
                                        {{ \Illuminate\Support\Facades\Log::info($emp_his_emplment_old) }}


                                        @foreach($emp_his_emplment_old as $empInfo)
                                            @if(substr($empInfo->emplo_comp_name,0,7) == "Incepta")
                                                <tr>
                                                    <td>{{ Carbon\Carbon::parse($empInfo->emplo_from)->format('d-m-Y')  }}</td>
                                                    <td>@if(count($empInfo->emplo_to))
                                                            {{ Carbon\Carbon::parse($empInfo->emplo_to)->format('d-m-Y')  }}
                                                        @else
                                                            Till Now
                                                        @endif
                                                    </td>
                                                    <td>{{ $empInfo->emplo_desig}}, {{ $empInfo->department}}</td>
                                                    <td>{{ $empInfo->country?$empInfo->country:'Bangladesh' }}</td>
                                                </tr>
                                            @endif
                                        @endforeach


                                        </tbody>

                                    </table>
                                </div>

                                <div class="col-lg-12 col-sm-12">
                                    <label for="">
                                        <scan style="color:#337ab7"><b> <i>EXTERNAL CAREER HISTORY </i> </b></scan>
                                    </label>
                                    <table class="table table-bordered table-striped employment_table">
                                        <thead>
                                        <th colspan="2" style="text-align: center;">EMPLOYMENT DATES</th>
                                        <th style="text-align: center;">POSITION / DEPARTMENT</th>
                                        <th style="text-align: center;">COUNTRY</th>
                                        </thead>
                                        <tbody>
                                        {{ \Illuminate\Support\Facades\Log::info($emp_his_emplment_old) }}


                                        @foreach($emp_his_job_last as $empInfoOld)
                                            <tr>
                                                <td>{{ Carbon\Carbon::parse($empInfoOld->emplo_from)->format('d-m-Y')  }}</td>
                                                <td>@if(count($empInfoOld->emplo_to))
                                                        {{ Carbon\Carbon::parse($empInfoOld->emplo_to)->format('d-m-Y')  }}
                                                    @else
                                                        Till Now
                                                    @endif
                                                </td>
                                                <td>{{ $empInfoOld->emplo_desig }} , {{ $empInfoOld->emplo_comp_name }}</td>
                                                <td>{{ $empInfoOld->country }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>

                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="col-lg-4 col-sm-4">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <th style="text-align: center;">LANGUAGE</th>
                                                <th style="text-align: center;">LEVEL<sub>(Native / Fluent / Intermed./
                                                        Basic)</sub></th>

                                                </thead>
                                                <tbody>
                                                @foreach($emp_his_language as $language)
                                                    <tr>
                                                        <td>{{ $language->lang  }}</td>
                                                        <td>{{ $language->lang_level }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="col-lg-8 col-sm-8">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <th style="text-align: center;">GRAD. DATE</th>
                                                <th style="text-align: center;">Education DEGREE/MAJOR</th>
                                                <th style="text-align: center;">GPA/CGPA</th>
                                                <th style="text-align: center;">INSTITUTION</th>
                                                </thead>
                                                <tbody>
                                                {{ \Illuminate\Support\Facades\Log::info($emp_his_edu_old) }}


                                                @foreach($emp_his_edu_old as $empedu)
                                                    <tr>
                                                        <td>@if(count($empedu->edu_passing_yr))
                                                                {{ ($empedu->edu_passing_yr)  }}
                                                            @else
                                                                Till Now
                                                            @endif
                                                        </td>
                                                        <td>{{ $empedu->degree_name }}, {{  $empedu->edu_subject }}</td>
                                                        <td>{{ $empedu->edu_marks }}</td>
                                                        <td>{{ $empedu->edu_insti_name }}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-sm-12">
                                    <label for="">
                                        <scan style="color:#337ab7"><b> <i>PROFESSIONAL QUALIFICATION OR SPECIALIZED
                                                    TRAINING </i> </b></scan>
                                    </label>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <th style="text-align: center;">INSTITUTION NAME</th>
                                        <th style="text-align: center;">FROM</th>
                                        <th style="text-align: center;">TO</th>
                                        <th style="text-align: center;">DURATION</th>
                                        <th style="text-align: center;">COURSE NAME</th>
                                        <th style="text-align: center;">RESULT</th>
                                        <th style="text-align: center;">COUNTRY</th>
                                        </thead>
                                        <tbody>
                                        {{ \Illuminate\Support\Facades\Log::info($emp_his_pro_quali) }}


                                        @foreach($emp_his_pro_quali as $emp_his_pro_quali)
                                            <tr>
                                                <td>{{ $emp_his_pro_quali->pro_insti_nam }}</td>
                                                <td>{{ Carbon\Carbon::parse($emp_his_pro_quali->pro_from)->format('d-m-Y') }}</td>
                                                <td>{{ Carbon\Carbon::parse($emp_his_pro_quali->pro_to)->format('d-m-Y') }}</td>
                                                <td>{{ $emp_his_pro_quali->pro_duration }}</td>
                                                <td>{{ $emp_his_pro_quali->pro_cour_nam }}</td>
                                                <td>{{ $emp_his_pro_quali->pro_result }}</td>
                                                <td>{{ $emp_his_pro_quali->pro_cuntry }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>

                                    </table>
                                </div>


                                <div class="col-lg-12 col-sm-12">
                                    <div class="info">
                                        <p style="vertical-align: middle;font-size: 16px;color:red"><strong><i class="fa fa-info-circle" style="font-size:18px;color:dodgerblue;text-align: center"></i>  Info!</strong>
                                            If you need any change please update <strong>Employee History Form</strong>
                                        </p>
                                    </div>
                                </div>

                                <ul class="list-inline pull-right" style="margin-top:10px">

                                    <div id="editor"></div>

                                    <li style="padding-right: 30px">
                                        @if(!empty($head_of_dept))
                                            <button type="button" class="btn btn-primary next-step" >Next</button>
                                        @else
                                            <a href="#myModal" class="btn btn-primary" data-toggle="modal">Next</a>
                                        @endif

                                    </li>
                                </ul>
                            </form>

                        </div>
                        {{--  second Page--}}

                        @if(!empty($head_of_dept))
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <form id="" method="post" action="{{ url('talent_development/tds_data') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="emp_id" value="{{ $emp_his_info[0]->emp_id }}">
                                    <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                                        <section class="panel panel-info">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>

                                                            <td>
                                                                <table border="0" cellpadding="2" cellspacing="2" width="100%">
                                                                    <tr>
                                                                        <td colspan="2"><b>PERSONAL INFORMATION</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Name:</td>
                                                                        <td>{{ $emp_his_info[0]->sur_name?$emp_his_info[0]->sur_name:'' }} </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Birth Date:</td>
                                                                        <td>{{ $emp_his_info[0]->birt_dt_ssc?Carbon\Carbon::parse($emp_his_info[0]->birt_dt_ssc)->format('d-m-Y'):''  }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Age:</td>
                                                                        <td id="selected_emp_age">{{$age?$age:''}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Emp. ID :</td>
                                                                        <td>  {{ $emp_his_info[0]->emp_id?$emp_his_info[0]->emp_id:''}}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>

                                                            <td>
                                                                <table style="border: none;" cellpadding="2" cellspacing="2"
                                                                       width="100%">
                                                                    <tr>
                                                                        <td style="text-align: center">
                                                                            <div class="image">
                                                                                @if(empty($emp_his_moreinfoid[0]->emp_img))
                                                                                    <img src="{{url('public/site_resource/images/user.png')}}"
                                                                                         class="rounded" width="100"
                                                                                         height="100">
                                                                                @else
                                                                                    <img src="{{url('public/emp_history_img/'.$emp_his_moreinfoid[0]->emp_img)}}"
                                                                                         class="rounded" width="100"
                                                                                         height="100">
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <table  id="personal_preferences_table" style="border-right: none;" cellpadding="2"
                                                                        cellspacing="2"
                                                                        width="100%">
                                                                    <tr>
                                                                        <td colspan="2"><b>PERSONAL PREFERENCES / MOBILITY</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Mobile ?<span style="color:#ff0000">*</span></td>
                                                                        <td id="mobility">
                                                                            <input type="radio" name="mobiliy"
                                                                                   value="YES"  {{$tds_dev_info?($tds_dev_info[0]->mobility == 'YES' ?  "checked" : ""):''}}> YES
                                                                            <input type="radio" name="mobiliy"
                                                                                   value="NO"  {{$tds_dev_info?($tds_dev_info[0]->mobility == 'NO' ?  "checked" : ""):''}}> NO
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Position:</td>
                                                                        <td>{{ $emp_his_info[0]->desig_name?$emp_his_info[0]->desig_name:'' }} </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Possible Positions:</td>
                                                                        <td><input type="text" id="ppositions"
                                                                                   class="form-control input-sm"
                                                                                   name="ppositions" value="{{$tds_dev_info?$tds_dev_info[0]->possible_position:''}}"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Possible Location:</td>
                                                                        <td><input type="text" id="plocation" name="plocation"
                                                                                   class="form-control input-sm" value="{{$tds_dev_info?$tds_dev_info[0]->possible_location:''}}"></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row" style="padding-top: 2%">
                                                <div class="col-md-12">
                                                    <section class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <label class="text-default text-center">
                                                                Development Group
                                                            </label>
                                                        </div>
                                                        <div class="panel-body" style="padding-top: 2%">
                                                            <div class="form-group">
                                                                <div class="col-md-4 col-sm-4">
                                                                    <label class="col-sm-2 col-sm-2 control-label input-sm" style="font-weight: bold">Group<span style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-10 col-sm-10">
                                                                        <select name="dggroup" id="dggroup"
                                                                                class="form-control input-sm m-bot15 year">
                                                                            <option value="">Select Group</option>
                                                                            @foreach($development_group as $dp)
                                                                                <option value="{{$dp->dg_id}}" {{$tds_dev_info?(( $tds_dev_info[0]->groupt == $dp->dg_id) ? 'selected' : ''):'' }}>{{$dp->dg_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8 col-sm-8">
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <fieldset class="scheduler-border">
                                                                            <legend class="scheduler-border">Definition</legend>
                                                                            <div id="outer">
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #1ABC9C; color: #ffffff" class=" btn btn-xs gp" id="1">Group Executive Potential</button>
                                                                                </div>
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #3498DB; color: #ffffff" class=" btn btn-xs gp" id="2">Executive Potential</button>
                                                                                </div>
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #8E44AD; color: #ffffff" class=" btn btn-xs gp" id="3">High Potential</button>
                                                                                </div>
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #F4D03F; color: #ffffff" class=" btn btn-xs gp" id="4">Early Potential</button>
                                                                                </div>
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #E67E22; color: #ffffff" class=" btn btn-xs gp" id="5">Expert</button>
                                                                                </div>
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #2E4053; color: #ffffff" class=" btn btn-xs gp" id="6">Contributor</button>
                                                                                </div>
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #FF00FF; color: #ffffff" class=" btn btn-xs gp" id="7">New Entrant</button>
                                                                                </div>
                                                                                <div class="inner">
                                                                                    <button type="button" style="background-color: #1e6135; color: #ffffff" class=" btn btn-xs gp" id="8">Concern</button>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" id="grpTextArea">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 col-sm-12">
                                                                <textarea name="grp_text" id="grp_text" class="form-control" style="min-width: 100%">
                                                                </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <fieldset class="scheduler-border">
                                                        <legend class="scheduler-border">Potentials Explained<span style="color:#ff0000">*</span></legend>
                                                        <div class="form-group">

                                                            <div class="col-md-3 col-sm-3">
                                                                <label class="col-sm-3 col-sm-3 control-label input-sm">
                                                                    <button type="button" style="background-color: #FFA07A; color: #ffffff" class=" btn btn-xs pe " data-toggle="modal" data-target="#potentialsModal" id="1">Agility</button>
                                                                </label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <select name="agility" id="agility"
                                                                            class="form-control input-sm m-bot15 agility">
                                                                        <option value="">Select ...</option>
                                                                        <option value="Low" {{$tds_dev_info?( $tds_dev_info[0]->agility == 'Low' ? 'selected' : ''):''}}>Low</option>
                                                                        <option value="Medium" {{$tds_dev_info?( $tds_dev_info[0]->agility == 'Medium' ? 'selected' : ''):''}}>Medium</option>
                                                                        <option value="High"{{$tds_dev_info?( $tds_dev_info[0]->agility == 'High' ? 'selected' : ''):''}}>High</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3">
                                                                <label class="col-sm-3 col-sm-3 control-label input-sm">
                                                                    <button type="button" style="background-color: #FFA07A; color: #ffffff" class=" btn btn-xs pe " data-toggle="modal" data-target="#potentialsModal" id="2">Ability</button>
                                                                </label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <select name="ability" id="ability"
                                                                            class="form-control input-sm m-bot15 ability">
                                                                        <option value="">Select ...</option>
                                                                        <option value="Low" {{$tds_dev_info?( $tds_dev_info[0]->ability == 'Low' ? 'selected' : ''):''}}>Low</option>
                                                                        <option value="Medium" {{$tds_dev_info?( $tds_dev_info[0]->ability == 'Medium' ? 'selected' : ''):''}}>Medium</option>
                                                                        <option value="High" {{$tds_dev_info?( $tds_dev_info[0]->ability == 'High' ? 'selected' : ''):''}}>High</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3">
                                                                <label class="col-sm-4 col-sm-4 control-label input-sm">
                                                                    <button type="button" style="background-color: #FFA07A; color: #ffffff" class=" btn btn-xs pe " data-toggle="modal" data-target="#potentialsModal" id="3">Aspiration</button>
                                                                </label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <select name="aspiration" id="aspiration"
                                                                            class="form-control input-sm m-bot15 aspiration">
                                                                        <option value="">Select ...</option>
                                                                        <option value="Low"{{$tds_dev_info?( $tds_dev_info[0]->aspiration == 'Low' ? 'selected' : ''):''}}>Low</option>
                                                                        <option value="Medium" {{$tds_dev_info?( $tds_dev_info[0]->aspiration == 'Medium' ? 'selected' : ''):''}}>Medium</option>
                                                                        <option value="High" {{$tds_dev_info?( $tds_dev_info[0]->aspiration == 'High' ? 'selected' : ''):''}}>High</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3">
                                                                <label class="col-sm-5 col-sm-5 control-label input-sm">
                                                                    <button type="button" style="background-color: #FFA07A; color: #ffffff" class=" btn btn-xs pe " data-toggle="modal" data-target="#potentialsModal" id="4">Engagement</button>
                                                                </label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <select name="engagement" id="engagement"
                                                                            class="form-control input-sm m-bot15 Engagement">
                                                                        <option value="">Select ...</option>
                                                                        <option value="Low" {{$tds_dev_info?( $tds_dev_info[0]->engagement == 'Low' ? 'selected' : ''):''}}>Low</option>
                                                                        <option value="Medium"{{$tds_dev_info?( $tds_dev_info[0]->engagement == 'Medium' ? 'selected' : ''):''}}>Medium</option>
                                                                        <option value="High" {{$tds_dev_info?( $tds_dev_info[0]->engagement == 'High' ? 'selected' : ''):''}}>High</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align: center">PPM:<span style="color:#ff0000">*</span>
                                                                <span class="ppm_number">{{$tds_dev_info?($tds_dev_info[0]->ppm_val?$tds_dev_info[0]->ppm_val:''):''}}</span></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td style="text-align: center">  <button type="button" class="ppmModalButton btn btn-info">
                                                                    Show PPM</button></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 12px">Date: {{date('d-m-Y')}}</td>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!--ppm modal-->
                                                <div id="ppmModalContent" class="modal fade" tabindex="-1" >
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Select PPM</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" id="selected_ppm_val" name="selected_ppm_val" value="{{$tds_dev_info?$tds_dev_info[0]->ppm_val:''}}">
                                                                <input type="hidden" id="selected_ppm_txt" name="selected_ppm_txt" value="{{$tds_dev_info?$tds_dev_info[0]->ppm_text:''}}">
                                                                <section class="panel panel-info">

                                                                    <div class="panel-body table-responsive" style="padding-top: 2%">

                                                                        <table border="1" cellspacing="0" cellpadding="0" align="left" width="100%">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td width="77"  style="text-align: center">
                                                                                    <p align="center">
                                                                                        <strong><span class="rotated"> High</span></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td id="ppm7"  width="190" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>7</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center"id="ppm7_text">
                                                                                        Consistently produces exceptional results and
                                                                                        high-performance ratings. Knows current job extremely well.
                                                                                        Good fit to role.
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td id="ppm8" width="197" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>8</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center" id="ppm8_text">
                                                                                        Consistently produces exceptional results. Knows the job
                                                                                        extremely well and motivated to enhance skills. Adapts to
                                                                                        new situations.
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td id="ppm9" width="278" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>9</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center"  id="ppm9_text">
                                                                                        Clearest example of high performance and potential. Has the
                                                                                        ability to take on major stretch assignments in new areas
                                                                                        and move into key positions. Will challenge the
                                                                                        organization to provide growth opportunity.
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="77" valign="top">
                                                                                    <p align="center">
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="190" valign="top">
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td width="197" valign="top">
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td width="278" valign="top">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="77" style="text-align: center">
                                                                                    <p align="center">
                                                                                        <strong><span class="rotated">Medium</span></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td id="ppm4" width="190" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>4</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center" id="ppm4_text">
                                                                                        Consistently meets expectations. Knows current job well.
                                                                                        Most effective in known role/environment.
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td id="ppm5" width="197" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>5</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center"  id="ppm5_text">
                                                                                        Consistently meets expectations. Knows current job well and
                                                                                        enhances skill as appropriate. Moderate adaptability to new
                                                                                        situations.
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td  id="ppm6" width="278" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>6</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center" id="ppm6_text">
                                                                                        Consistently meets expectations. Knows current job well and
                                                                                        enhances skill as appropriate. Has the ability to take on
                                                                                        new and different challenges on a consistent basis.
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="77" valign="top">
                                                                                    <p align="center">
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="190" valign="top">
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td width="197" valign="top">
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td width="278" valign="top">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="77" style="text-align: center; padding-top: 2px" >
                                                                                    <p>
                                                                                        <strong><span class="rotated"> Performance Low</span></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td id="ppm1" width="190" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>1</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center"  id="ppm1_text">
                                                                                        Not delivering on results as expected. Action Plan required
                                                                                        to address performance concern. May need to re-scope or
                                                                                        re-assign.
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td id="ppm2" width="197" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>2</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center"  id="ppm2_text">
                                                                                        Delivers result inconsistently due to skills/knowledge
                                                                                        gaps; may be on learning curve; expected to succeed in
                                                                                        time.
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="top">
                                                                                </td>
                                                                                <td id="ppm3" width="278" valign="top" style="background-color: #ffdb99">
                                                                                    <p align="center">
                                                                                        <strong>3</strong>
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                    <p align="center" id="ppm3_text">
                                                                                        Yet to demonstrate performance, either on a new position or
                                                                                        stretch assignment. Has previously demonstrated high
                                                                                        performance/ potential with high level of engagement and
                                                                                        aspiration.
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="77" valign="top">
                                                                                    <p align="center">
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="190" valign="bottom">
                                                                                    <p align="center">
                                                                                        <strong>Potential Low</strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="bottom">
                                                                                    <p align="center">
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="197" valign="bottom">
                                                                                    <p align="center">
                                                                                        <strong>Medium</strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="15" valign="bottom">
                                                                                    <p align="center">
                                                                                        <strong></strong>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="278" valign="bottom">
                                                                                    <p align="center">
                                                                                        <strong>High</strong>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary ppm_modal_cancel" data-dismiss="modal">Cancel</button>
                                                                <button type="button" class="btn btn-primary ppm_modal_save" >Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <table class="table table-bordered" id="myTable">
                                                        <thead>
                                                        <tr>
                                                            <td bgcolor="#FFFFFF" style="line-height:10px" colspan=5>SUCCESORS</td>
                                                        </tr>
                                                        <tr style="line-height: 10px">
                                                            <th>No.</th>
                                                            <th>EMP ID</th>
                                                            <th>SUCCESSORS NAME</th>
                                                            <th>CURRENT POSITION</th>
                                                            <th>READINESS</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @if($successor)
                                                            @if($users_successor || $another_user_successor)
                                                                @for($i=1;$i<=3;$i++)
                                                                    @if($users_successor && $i<=sizeof($users_successor))
                                                                        <tr id="successor_table_row">
                                                                            <td class="serial_no">{{$i}}</td>
                                                                            <td id="{{"emp_id_".$i}}" class="empId">{{$users_successor[$i-1]->successor_id}}</td>
                                                                            <td class="successors_info">
                                                                                <select name="successors_id" id="{{"successors_id_".$i}}"
                                                                                        class="form-control input-sm suc_emp select_class successors_info emp_name">
                                                                                    <option value="">Select Employee</option>
                                                                                    @foreach($successor as $successors)
                                                                                        <option class="employee_name" value="{{$successors->employee_id}}" {{($users_successor[$i-1]->successor_id == $successors->employee_id)? 'selected' : ''}}>{{$successors->emp_name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td class="successors_designation"  id="{{"successors_designation_".$i}}">{{$users_successor[$i-1]->emp_designation}}</td>
                                                                            <td>
                                                                                <select class="emp_readiness"  id="{{"successor_readiness_".$i}}">>
                                                                                    <option value="1" {{$users_successor?( $users_successor[$i-1]->successor_readiness == 1 ? 'selected' : ''):''}}>(0-1)</option>
                                                                                    <option value="2" {{$users_successor?( $users_successor[$i-1]->successor_readiness == 2 ? 'selected' : ''):''}}>(1-2)</option>
                                                                                    <option value="3" {{$users_successor?( $users_successor[$i-1]->successor_readiness == 3 ? 'selected' : ''):''}}>(2+)</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        <tr id="successor_table_row">
                                                                            <td class="serial_no">{{$i}}</td>
                                                                            <td id="{{"emp_id_".$i}}" class="empId"></td>
                                                                            <td class="successors_info">
                                                                                <select name="successors_id" id="{{"successors_id_".$i}}"
                                                                                        class="form-control input-sm suc_emp select_class successors_info emp_name">
                                                                                    <option value="">Select Employee</option>
                                                                                    @foreach($successor as $successors)
                                                                                        <option class="employee_name" value="{{$successors->employee_id}}">{{$successors->emp_name}}</option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </td>
                                                                            <td class="successors_designation"  id="{{"successors_designation_".$i}}"></td>
                                                                            <td>
                                                                                <select class="emp_readiness"  id="{{"successor_readiness_".$i}}">>
                                                                                    <option value="1">(0-1)</option>
                                                                                    <option value="2"  >(1-2)</option>
                                                                                    <option value="3" >(2+)</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endfor
                                                                <tr class="other_emp_tr">
                                                                    <td id="other_serial_no">4</td>
                                                                    <td><input type="number"  placeholder="Enter Successor ID (Only Numbers)" class="form-control" id="other_emp_id"  value="{{$another_user_successor?$another_user_successor[0]->successor_id:''}}"></td>
                                                                    <td><input type="text"  placeholder="Enter Successor Name" class="form-control" id="other_emp_name"  value="{{$another_user_successor?$another_user_successor[0]->emp_name:''}}"></td>
                                                                    <td><input type="text"   placeholder="Enter Current Position" class="form-control" id="other_emp_cp"  value="{{$another_user_successor?$another_user_successor[0]->emp_designation:''}}"></td>
                                                                    <td>
                                                                        <select class="emp_readiness"  id="other_emp_readiness">
                                                                            <option value="1" {{$another_user_successor?($another_user_successor[0]->successor_readiness == 1 ? 'selected' : ''):''}}>(0-1)</option>
                                                                            <option value="2" {{$another_user_successor?($another_user_successor[0]->successor_readiness == 2 ? 'selected' : ''):''}}>(1-2)</option>
                                                                            <option value="3" {{$another_user_successor?($another_user_successor[0]->successor_readiness == 3 ? 'selected' : ''):''}}>(2+)</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>

                                                            @else
                                                                @for($i=1;$i<=3;$i++)
                                                                    <tr id="successor_table_row">
                                                                        <td class="serial_no">{{$i}}</td>
                                                                        <td id="{{"emp_id_".$i}}" class="empId"></td>
                                                                        <td class="successors_info">
                                                                            <select name="successors_id" id="{{"successors_id_".$i}}"
                                                                                    class="form-control input-sm suc_emp select_class successors_info emp_name">
                                                                                <option value="">Select Employee</option>
                                                                                @foreach($successor as $successors)
                                                                                    <option class="employee_name" value="{{$successors->employee_id}}">{{$successors->emp_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td class="successors_designation"  id="{{"successors_designation_".$i}}"></td>
                                                                        <td>
                                                                            -
                                                                            <select class="emp_readiness"  id="{{"successor_readiness_".$i}}">>
                                                                                <option value="1">(0-1)</option>
                                                                                <option value="2"  >(1-2)</option>
                                                                                <option value="3" >(2+)</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>

                                                                @endfor
                                                                <tr class="other_emp_tr">
                                                                    <td id="other_serial_no">4</td>
                                                                    <td><input type="number" placeholder="Enter Successor ID" class="form-control" id="other_emp_id"></td>
                                                                    <td><input type="text" placeholder="Enter Successor Name" class="form-control" id="other_emp_name"></td>
                                                                    <td><input type="text" placeholder="Enter Current Position" class="form-control" id="other_emp_cp"></td>
                                                                    <td>
                                                                        <select class="emp_readiness"  id="other_emp_readiness">
                                                                            <option value="1">(0-1)</option>
                                                                            <option value="2">(1-2)</option>
                                                                            <option value="3">(2+)</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @else
                                                            @for ($i=1;$i<=3;$i++)
                                                                <tr id="successor_table_row" >
                                                                    <td class="serial_no">{{$i}}</td>
                                                                    <td id="{{"emp_id_".$i}}" class="empId"></td>
                                                                    <td class="successors_info">
                                                                        <select name="successors_id" id="{{"successors_id_".$i}}"
                                                                                class="form-control input-sm suc_emp select_class successors_info emp_name">
                                                                            <option  value="">Select Employee</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="successors_designation"  id="{{"successors_designation_".$i}}"></td>
                                                                    <td>
                                                                        <select class="emp_readiness"  id="{{"successor_readiness_".$i}}">>
                                                                            <option value="1">(0-1)</option>
                                                                            <option value="2">(1-2)</option>
                                                                            <option value="3">(2+)</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                            <tr class="other_emp_tr">
                                                                <td>4</td>
                                                                <td><input type="number"  placeholder="Enter Successor Id" class="form-control" id="other_emp_id"></td>
                                                                <td><input type="text"  placeholder="Enter Successor Name" class="form-control" id="other_emp_name"></td>
                                                                <td><input type="text"  placeholder="Enter Current Position" class="form-control" id="other_emp_cp"></td>
                                                                <td>
                                                                    <select class="emp_readiness"  id="other_emp_readiness">
                                                                        <option value="1">(0-1)</option>
                                                                        <option value="2">(1-2)</option>
                                                                        <option value="3">(2+)</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <h2 style="padding:6px;border: 2px solid #337AC7;font-size:11px;font-style: italic">YEAR-END OVERALL PERFORMANCE ASSESSMENT</h2>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="col-md-6 col-sm-6">
                                                        <header style="padding:1%;text-align: center;border: 1px solid #46B8DA;background: #46B8DA;color: whitesmoke;font-weight: bold">MANAGER'S CONCLUSION <span style="color:#ff0000">*</span></header>
                                                        <textarea rows="6" class="form-control" placeholder=""
                                                                  id="managers_conclution">{{$tds_dev_info?$tds_dev_info[0]->managers_conclution:''}}</textarea>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <header style="padding:1%;text-align: center;border: 1px solid #46B8DA;background: #46B8DA;color: whitesmoke;font-weight: bold">DEMONSTRATED STRENGTHS <span style="color:#ff0000">*</span> </header>
                                                        <textarea rows="6" class="form-control" placeholder=""
                                                                  id="demonstrated_strength"> {{$tds_dev_info?$tds_dev_info[0]->demonstrated_strength:''}}</textarea>
                                                    </div>

                                                </div>
                                                <div class="col-md-12 col-sm-12" style="margin-top: 2%">
                                                    <div class="col-md-6 col-sm-6" >
                                                        <header style="padding:1%;text-align: center;border: 1px solid #46B8DA;background: #46B8DA;color: whitesmoke;font-weight: bold">PROPOSED DEVELOPMENT ACTIVITY </header>
                                                        <div style="border:1px solid #BEBEBE;padding:2%">

                                                            <div class="row">
                                                                <div class="col-md-6" style=" border-right: 1px solid #BEBEBE">
                                                                    <header style="text-align: center;border: 1px solid #BEBEBE;color: #555;font-weight: bold;font-size:13px">Technical Knowledge </header>

                                                                    <textarea rows="6" class="form-control" placeholder=""
                                                                              id="pdev_activity_tec"> {{$tds_dev_info?$tds_dev_info[0]->pdev_activity_tec:''}}</textarea>

                                                                </div>

                                                                <div class="col-md-6">
                                                                    <header style="text-align: center;border: 1px solid #BEBEBE;color: #555;font-weight: bold;font-size:13px">SOFT SKILL<span style="color:#ff0000">*</span></header>
                                                                    <textarea rows="6" class="form-control" placeholder=""
                                                                              id="pdev_activity_com"> {{$tds_dev_info?$tds_dev_info[0]->pdev_activity_com:''}}</textarea>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6 col-sm-6">
                                                        <header style="padding:1%;text-align: center;border: 1px solid #46B8DA;background: #46B8DA;color: whitesmoke;font-weight: bold">IDENTIFIED DEVELOPMENT NEEDS FOR FUTURE POSITIONS </header>
                                                        <div style="border:1px solid #BEBEBE;padding:2%">

                                                            <div class="row">
                                                                <div class="col-md-6" style=" border-right: 1px solid #BEBEBE">
                                                                    <header style="text-align: center;border: 1px solid #BEBEBE;color: #555;font-weight: bold;font-size:13px">Technical Knowledge </header>

                                                                    <textarea rows="6" class="form-control" placeholder=""
                                                                              id="identified_dev_tec">{{$tds_dev_info?$tds_dev_info[0]->identified_dev_tec:''}}</textarea>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <header style="text-align: center;border: 1px solid #BEBEBE;color: #555;font-weight: bold;font-size:13px">SOFT SKILL<span style="color:#ff0000">*</span></header>
                                                                    <textarea rows="6" class="form-control" placeholder=""
                                                                              id="identified_dev_com">{{$tds_dev_info?$tds_dev_info[0]->identified_dev_com:''}} </textarea>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                                <ul class="list-inline pull-right">
                                    <li>
                                        <button type="button" class="btn btn-default prev-step">Previous</button>
                                    </li>
                                    @if($tds_dev_info)
                                        <li>
                                            <button type="button" class="btn btn-primary next-step2" id="tds_update_button">Save And Continue..</button>
                                        </li>
                                    @else
                                        <li>
                                            <button type="button" class="btn btn-primary next-step2" id="submit_button">Save and continue</button>
                                            <input type="hidden" id="check_for_save" value="{{$check_for_search}}"  />
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @else

                        <!-- Modal HTML -->
                            <div id="myModal" class="modal fade">
                                <div class="modal-dialog modal-confirm">
                                    <div class="modal-content">
                                        <div class="modal-header justify-content-center">
                                            <div class="icon-box">
                                                <span class="glyphicon glyphicon-ok" style="font-size: 50px;"></span>
                                            </div>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4>Great!</h4>
                                            <p>Information is up-to-date.</p>
                                            <button class="btn btn-success" id="send_email_button" style="text-align: center"><span>Notify Manager</span> <span class="glyphicon glyphicon-envelope"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{--Last Page--}}
                        <div class="tab-pane" role="tabpanel" id="complete">
                            <div class="row" style="padding: 5%" >
                                <h3 class="alert alert-success">Complete</h3>
                                <p class="alert alert-success">You have successfully completed all steps.</p>
                                <ul class="list-inline pull-left">
                                    <li>
                                        <button type="button" class="btn btn-default prev-step">Previous</button>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-end mb-4">
                                            <a target="_blank" class="btn btn-warning btn-sm" href="{{ URL('talent_development/EmpInfoPdf/'. $emp_his_info[0]->emp_id) }}">
                                                <i class="fa fa-print"></i>Export to PDF</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="" class="form-horizontal" role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4> Development Group - <span id="gpHeader"></span></h4>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div id="modal-body-brandChange">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" id="fn-close" data-dismiss="modal" value="Close">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Potentials Explained Modal -->
    <div id="potentialsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>Potentials explained - <span id="gpHeader-pe"></span> </h4>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="modal-body-pe">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script type="text/javascript">
        var ppm_val='',ppm_text='';
        ppm='';
        var check_select;
        $('.emp_id').select2();

        $('#btn_displayNP_group').attr('formtarget', '_blank');

        /*function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }*/

        /*Send Email*/
        $("#send_email_button").on('click',function(e){
            e.preventDefault();
            var user_id = $('#selected_emp_id').text();

            $.ajax({
                url: '{{url('talent_development/send_email')}}',
                type: "POST",
                data: {
                    emp_id:user_id,
                    _token: '{{csrf_token()}}'
                },
                cache: false,
                success: function(response){

                    if(response=='success'){
                        toastr.info('Email Sent Successfully');
                    }
                },
                error: function (error) {

                    toastr.error('Cannot Send Emails');

                }
            });

        });


        /*Send Email By Finish Button*/
        $("#finish_button").on('click',function(e){
            e.preventDefault();

            $.ajax({
                url: '{{url('talent_development/send_finish_email')}}',
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}'
                },
                cache: false,
                success: function(response){
                    if(response=='success'){
                        toastr.info('Email Sent Successfully');
                    }
                },
                error: function (error) {
                    toastr.error('Cannot Send Emails');
                }
            });

        });





        $(document).ready(function () {

            //Initialize tooltips
            $('.nav-tabs > li a[title]').tooltip();

            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                var $target = $(e.target);

                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {
                $rr = $('.user_id').val();


                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);

            });
            /* $(".next-step2").click(function (e) {

                 console.log("next step button TWO");

                 var $active = $('.wizard .nav-tabs li.active');
                 $active.next().removeClass('disabled');
                 nextTab($active);

             });*/
            $(".prev-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        $('#grpTextArea').hide();
        $(document).on('change', '#dggroup', function () {
            let grpId = $('#dggroup').val();
            if (grpId.length === 0) {
                $('#grpTextArea').hide();
            } else {
                $('#grpTextArea').show();
            }
            //ajax request and get value from group table and set value to #group_text field
            $.ajax({
                type: "get",
                dataType: 'json',
                data: {group_id: $('#dggroup').val()},
                url: "{{ url('talent_development/getGroupText') }}",
                success: function (resp) {
                    $('#grp_text').text(resp[0].dg_text);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        });

        $(document).on('click', '.gp', function () {
            let infoModal = $('#myModal');
            $.ajax({
                type: "get",
                dataType: 'json',
                data: {group_id: this.id},
                url: "{{ url('talent_development/getGroupText') }}",
                success: function (resp) {
                    /*     $('#grp_text').text('');
                         $('#grp_text').text(resp[0].dg_text);*/
                    $('#gpHeader').text(resp[0].dg_name);
                    $('#modal-body-brandChange').text(resp[0].dg_text);
                    infoModal.modal('show');
                },
                error: function (e) {

                }
            });
        });

        $(document).on('click', '.pe', function () {
            let potenModal = $('#potentialsModal');
            $.ajax({
                type: "get",
                dataType: 'json',
                data: {pe_id: this.id},
                url: "{{ url('talent_development/getPotentialText') }}",
                success: function (resp) {
                    /*     $('#grp_text').text('');
                         $('#grp_text').text(resp[0].dg_text);*/
                    $('#gpHeader-pe').text(resp[0].pe_name);
                    $('#modal-body-pe').text(resp[0].pe_text);
                    potenModal.modal('show');
                },
                error: function (e) {

                }
            });
        });


        /*
        * Other Emp Info
        * */
        $("#other_emp_id").keypress(function(e){
            var key = e.which;
            if(key == 13){
                emp_id = $("#other_emp_id").val();
                $("#other_emp_name").val("");
                $("#other_emp_cp").val("");

                $.ajax({
                    type: "get",
                    dataType: 'json',
                    data: {emp_id: emp_id},

                    url: "{{ url('talent_development/getOtherEmpNamePosition') }}",
                    success: function (resp) {
                        console.log("teh result= ");
                        console.log(resp[0].desig_name)
                        console.log(resp[0].sur_name)


                        $("#other_emp_name").val(resp[0].desig_name);
                        $("#other_emp_cp").val(resp[0].sur_name);

                    },
                    error: function (e) {

                    }
                });
            }

        });

        /**
         * Select successsors from table
         */
        $('.select_class').on('click', function () {

            var $id = $(this).closest('tr').find('.serial_no').text();
            check_select=$id;
            $emp_id = $('#successors_id_'+$id).val();


            if($id==2){
                $emp1 = $('#successors_id_1').val();
                if(!$emp1){
                    alert("Please Select Previous Option!!");
                    return false;
                }
            }else if($id==3){
                $emp2 = $('#successors_id_2').val();
                if(!$emp2){
                    alert("please Select Previous Option!!");
                    return false;
                }
            }

            if($emp_id.length){

                $.ajax({
                    type: "get",
                    url: "{{url('talent_development/get_successrors_info')}}",
                    data: {emp_id: $emp_id, '_token': '{{csrf_token()}}'},
                    success: function (response) {
                        var employee_id = response[0].employee_id;
                        var designation = response[0].desig;

                        $('#successors_designation_'+$id).val(designation);
                        $('#successors_designation_'+$id).text(designation);
                        $('#emp_id_'+$id).val(employee_id);
                        $('#emp_id_'+$id).text(employee_id);
                    },
                    error: function () {
                        toastr.error('UNABLE TO FETCH');
                    }
                });
            }else{

                $('#successors_designation_'+$id).val("");
                $('#successors_designation_'+$id).text("");
                $('#emp_id_'+$id).val("");
                $('#emp_id_'+$id).text("");
            }
        });

        /**
         * Submit all data
         */
        $("#submit_button").on('click',function(e){

            e.preventDefault();
            var emp_ids=[];
            var emp_readiness=[];
            var serial_numbers=[];
            var emp_designation=[];
            var emp_name=[];

            var $check_save = $("#check_for_save").val();

            //for other employee
            var other_emp_id = $("#other_emp_id").val();
            var other_emp_name = $("#other_emp_name").val();
            var other_emp_designation = $("#other_emp_cp").val();
            var other_emp_readiness = $("#other_emp_readiness").val();
            var other_emp_seroal_no = $("#other_serial_no").text();


            if($check_save=='no'){
                toastr.error('Please Search An Employee First!!');
            }else if($check_save=='yes'){

                $("#myTable >tbody > tr").each(function (i,value) {
                    var empID = $(this).find('.empId').text();
                    var empDesignation = $(this).find('.successors_designation').text();
                    var serial_no = $(this).find('.serial_no').text();
                    var emp_readi = $(this).find('.emp_readiness').val();
                    var employee_name = $(this).find('.emp_name').find('option:selected').text();
                    //var employee_name ='';

                    if(empID){
                        emp_ids.push(empID);
                        emp_readiness.push(emp_readi);
                        serial_numbers.push(serial_no);
                        emp_designation.push(empDesignation);
                        emp_name.push(employee_name);
                    }
                });

                if(other_emp_id){
                    emp_ids.push(other_emp_id);
                    emp_readiness.push(other_emp_readiness);
                    emp_designation.push(other_emp_designation);
                    serial_numbers.push(other_emp_seroal_no);
                    emp_name.push(other_emp_name);
                }

                var $payload = {
                    employee_id : $("#selected_emp_id").text(),
                    employee_last_name : $("#selected_emp_lname").text(),
                    employee_first_name : $("#selected_emp_fname").text(),
                    employee_birth_date : $("#selected_emp_DOB").text(),
                    employee_birth_date : $("#selected_emp_DOB").text(),
                    selected_emp_age : $("#selected_emp_age").text(),
                    mobility :  $('input[name="mobiliy"]:checked').val(),
                    possible_location : $("#ppositions").val(),
                    possible_position : $("#plocation").val(),
                    groupt : $("#dggroup").val(),
                    agility : $("#agility").val(),
                    ability : $("#ability").val(),
                    aspiration : $("#aspiration").val(),
                    engagement : $("#engagement").val(),
                    managers_conclution : $("#managers_conclution").val(),
                    demonstrated_strength : $("#demonstrated_strength").val(),
                    identified_dev_tec : $("#identified_dev_tec").val(),
                    identified_dev_com : $("#identified_dev_com").val(),
                    pdev_activity_tec : $("#pdev_activity_tec").val(),
                    pdev_activity_com : $("#pdev_activity_com").val(),
                    ppm_val : ppm_val,
                    ppm_text : ppm_text,
                    ppm_date : $.datepicker.formatDate('dd/mm/yy', new Date()),
                }



                if($('input[name="mobiliy"]:checked').val() && $("#dggroup").val()&&
                    $("#agility").val() && $("#ability").val() && $("#aspiration").val() && $("#engagement").val()
                    && ppm_text.length && (ppm_val!=null) && $("#managers_conclution").val().length
                    && $("#demonstrated_strength").val().length>1 &&  $("#identified_dev_com").val().length>1
                    && $("#pdev_activity_com").val().length>1 ){
                    {
                        $.ajax({
                            url: '{{url('talent_development/tds_post_data')}}',
                            type: "POST",
                            data: {
                                tds_data:$payload,
                                successors_id:emp_ids,
                                successors_readiness:emp_readiness,
                                emp_designation:emp_designation,
                                serial_no:serial_numbers,
                                emp_name:emp_name,
                                _token: '{{csrf_token()}}'

                            },
                            cache: false,
                            success: function(response){
                                if(response['status']=='SAVED'){
                                    toastr.info('SAVED SUCCESSFULLY');


                                    var $active = $('.wizard .nav-tabs li.active');
                                    $active.next().removeClass('disabled');
                                    nextTab($active);

                                }else{
                                    toastr.error('UNABLE TO SAVE');
                                }
                            },
                            error: function (error) {
                                toastr.error('UNABLE TO SAVE');
                            }
                        });
                    }

                }else{
                    toastr.error('Please Fill The Required Field!!');
                }

            }

        });

        /**
         * Update TDS Info
         **/
        $("#tds_update_button").on('click',function(e){
            e.preventDefault();
            var emp_ids=[];
            var emp_readiness=[];
            var serial_numbers=[];
            var emp_designation=[];
            var emp_name=[];



            //for other employee
            var other_emp_id = $("#other_emp_id").val();
            var other_emp_name = $("#other_emp_name").val();
            var other_emp_designation = $("#other_emp_cp").val();
            var other_emp_readiness = $("#other_emp_readiness").val();
            var other_emp_seroal_no = $("#other_serial_no").text();


            $("#myTable >tbody > tr").each(function (i,value) {
                var empID = $(this).find('.empId').text();
                var empDesignation = $(this).find('.successors_designation').text();
                var serial_no = $(this).find('.serial_no').text();
                var emp_readi = $(this).find('.emp_readiness').val();
                var employee_name = $(this).find('.emp_name').find('option:selected').text();
                if(empID){
                    emp_ids.push(empID);
                    emp_readiness.push(emp_readi);
                    serial_numbers.push(serial_no);
                    emp_designation.push(empDesignation);
                    emp_name.push(employee_name);
                }
            });

            if(other_emp_id){
                emp_ids.push(other_emp_id);
                emp_readiness.push(other_emp_readiness);
                emp_designation.push(other_emp_designation);
                serial_numbers.push(other_emp_seroal_no);
                emp_name.push(other_emp_name);
            }


            var $payload = {
                employee_id : $("#selected_emp_id").text(),
                employee_last_name : $("#selected_emp_lname").text(),
                employee_first_name : $("#selected_emp_fname").text(),
                employee_birth_date : $("#selected_emp_DOB").text(),
                employee_birth_date : $("#selected_emp_DOB").text(),
                selected_emp_age : $("#selected_emp_age").text(),
                mobility :  $('input[name="mobiliy"]:checked').val(),
                possible_location : $("#ppositions").val(),
                possible_position : $("#plocation").val(),
                groupt : $("#dggroup").val(),
                agility : $("#agility").val(),
                ability : $("#ability").val(),
                aspiration : $("#aspiration").val(),
                engagement : $("#engagement").val(),
                managers_conclution : $("#managers_conclution").val(),
                demonstrated_strength : $("#demonstrated_strength").val(),
                identified_dev_tec : $("#identified_dev_tec").val(),
                identified_dev_com : $("#identified_dev_com").val(),
                pdev_activity_tec : $("#pdev_activity_tec").val(),
                pdev_activity_com : $("#pdev_activity_com").val(),
                ppm_val : ppm_val,
                ppm_text : ppm_text,
                ppm_date : $.datepicker.formatDate('dd/mm/yy', new Date()),
            }

            /* console.log("update tds data");
             console.log($payload);
             return 0;*/

            if($('input[name="mobiliy"]:checked').val() && $("#dggroup").val()&&
                $("#agility").val() && $("#ability").val() && $("#aspiration").val() && $("#engagement").val()
                && ppm_text.length && (ppm_val!=null) && $("#managers_conclution").val().length
                && $("#demonstrated_strength").val().length>1  && $("#identified_dev_com").val().length>1
                && $("#pdev_activity_com").val().length>1 ){
                {
                    $.ajax({
                        url: '{{url('talent_development/tds_put_data')}}',
                        type: "POST",
                        data: {
                            tds_data:$payload,
                            successors_id:emp_ids,
                            successors_readiness:emp_readiness,
                            emp_designation:emp_designation,
                            emp_name:emp_name,
                            serial_numbers:serial_numbers,
                            _token: '{{csrf_token()}}'
                        },
                        cache: false,
                        success: function(response){
                            if(response['status']=='UPDATED'){
                                toastr.info('UPDATED SUCCESSFULLY')
                                var $active = $('.wizard .nav-tabs li.active');
                                $active.next().removeClass('disabled');
                                nextTab($active);
                            }else {
                                toastr.error('UNABLE TO UPDATE');
                            }
                        },
                        error: function (error) {
                            toastr.error('UNABLE TO UPDATE');
                        }
                    });
                }
            }else{
                toastr.error('Please Fill The Required Field!!');
            }

        });

        $(document).ready(function(){
            var ppm_selected_val = $("#selected_ppm_val").val();
            var ppm_selected_text=  $("#selected_ppm_txt").val();
            if(ppm_selected_val && ppm_selected_text){
                ppm_val=ppm_selected_val;
                ppm_text=ppm_selected_text;

            }


            $(".ppmModalButton").click(function(){
                $("#ppmModalContent").modal('show');
                document.querySelector("body").style.overflow = 'hidden';
                var ppm_selected_val = $("#selected_ppm_val").val();
                $("#ppm"+ppm_selected_val).css("backgroundColor", "#F2ED47");
            });
        });
        var d = new Date();
        var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();

        /**
         * Set PPm Value
         */
        $("#ppm7").on('click',function(e){
            $("#ppm7").css("opacity", "0.7");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm8").css("opacity", "1");
            $("#ppm9").css("opacity", "1");

            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=7;
                ppm_text= $("#ppm7_text").text();
                $('.ppm_number').text(ppm_val);
            });

        });
        $("#ppm8").on('click',function(e){

            $("#ppm8").css("opacity", "0.7");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");

            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=8;
                ppm_text= $("#ppm8_text").text();
                $('.ppm_number').text(ppm_val);
            });

        });
        $("#ppm9").on('click',function(e){
            $("#ppm9").css("opacity", "0.7");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm8").css("opacity", "1");

            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=9;
                ppm_text= $("#ppm9_text").text();
                $('.ppm_number').text(ppm_val);
            });


        });
        $("#ppm1").on('click',function(e){
            $("#ppm1").css("opacity", "0.7");
            $("#ppm8").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");
            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=1;
                ppm_text= $("#ppm1_text").text();
                $('.ppm_number').text(ppm_val);
            });

        });
        $("#ppm2").on('click',function(e){
            $("#ppm2").css("opacity", "0.7");
            $("#ppm8").css("opacity", "1");
            $("#ppm1").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");

            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=2;
                ppm_text= $("#ppm2_text").text();
                $('.ppm_number').text(ppm_val);
            });

        });
        $("#ppm3").on('click',function(e){

            $("#ppm3").css("opacity", "0.7");
            $("#ppm8").css("opacity", "1");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");

            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=3;
                ppm_text= $("#ppm3_text").text();
                $('.ppm_number').text(ppm_val);
            });

        });
        $("#ppm4").on('click',function(e){

            $("#ppm4").css("opacity", "0.7");
            $("#ppm8").css("opacity", "1");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");
            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=4;
                ppm_text= $("#ppm4_text").text();
                $('.ppm_number').text(ppm_val);
            });


        });
        $("#ppm5").on('click',function(e){

            $("#ppm5").css("opacity", "0.7");
            $("#ppm8").css("opacity", "1");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");

            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=5;
                ppm_text= $("#ppm5_text").text();
                $('.ppm_number').text(ppm_val);
            });

        });
        $("#ppm6").on('click',function(e){
            $("#ppm6").css("opacity", "0.7");
            $("#ppm8").css("opacity", "1");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm5").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");

            $('.ppm_modal_save').click(function(){
                $('#ppmModalContent').modal('hide');
                ppm_val=6;
                ppm_text= $("#ppm6_text").text();
                $('.ppm_number').text(ppm_val);
            });

        });
        $('.ppm_modal_cancel').click(function(){
            ppm_text='';
            ppm_val='';

            $('#ppmModalContent').modal('hide');
            $('.ppm_number').text("");
            $("#ppm5").css("opacity", "1");
            $("#ppm8").css("opacity", "1");
            $("#ppm1").css("opacity", "1");
            $("#ppm2").css("opacity", "1");
            $("#ppm3").css("opacity", "1");
            $("#ppm4").css("opacity", "1");
            $("#ppm6").css("opacity", "1");
            $("#ppm7").css("opacity", "1");
            $("#ppm9").css("opacity", "1");
        });


    </script>
@endsection