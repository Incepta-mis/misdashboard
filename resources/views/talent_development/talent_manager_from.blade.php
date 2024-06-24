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
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
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

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <form class="form-horizontal" role="form">
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
                                            @foreach($rs as $e)
                                                <option value="{{$e->emp_id}}">{{$e->emp_id}} - {{$e->emp_name}}</option>
                                            @endforeach
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


    <div class="row" style="display: none">
            <div class="col-sm-12 col-md-12">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
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

                    {{-- <form role="form"> --}}

                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">

                            <form id="" method="post" action="{{ url('talent_development/employeeTdpdf') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="emp_id" value="{{ $emp_his_info[0]->emp_id }}">

                                <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                                    <section class="panel panel-info">


                                        <div class="row">
                                            <div class="col-md-12">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        {{-- PERSONAL INFORMATION --}}
                                                        <td>
                                                            <table border="0" cellpadding="2" cellspacing="2" width="100%">
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <b style="color:#337ab7;">PERSONAL INFORMATION</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Last Name:</td>
                                                                    <td>{{ $emp_his_info[0]->last_name  }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>First Name:</td>
                                                                    <td>{{ $emp_his_info[0]->first_name  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Birth Date:</td>
                                                                    <td>{{ Carbon\Carbon::parse($emp_his_info[0]->birth_dt)->format('d-m-Y')  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Age:</td>
                                                                    <td>30</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Emp. ID :</td>
                                                                    <td>1010112</td>
                                                                </tr>
                                                            </table>
                                                        </td>


                                                        {{-- picture --}}
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


                                                        {{-- CURRENT POSITION --}}
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


                                                        {{-- MANAGER(S):	 --}}
                                                        <td>
                                                            <table border="0" cellpadding="2" cellspacing="2" width="100%">
                                                                <tr>

                                                                    <td colspan="2"><b style="color:#337ab7;">MANAGER(S)</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>DIRECT n+1:</td>
                                                                    <td>{{ $head_dtl[0]->head_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Position:</td>
                                                                    <td> {{ $head_dtl[0]->head_desig }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Date Appointed:</td>
                                                                    <td>{{Carbon\Carbon::parse($head_dtl[0]->joining)->format('d-m-Y')}}</td>
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
                                        {{-- {{ \Illuminate\Support\Facades\Log::info($emp_his_emplment_old) }} --}}


{{--                                        @foreach($emp_his_emplment_old as $empInfo)--}}
{{--                                            @if(substr($empInfo->emplo_comp_name,0,7) == "Incepta")--}}
{{--                                                <tr>--}}
{{--                                                    <td>{{ Carbon\Carbon::parse($empInfo->emplo_from)->format('d-m-Y')  }}</td>--}}
{{--                                                    <td>@if(count($empInfo->emplo_to))--}}
{{--                                                            {{ Carbon\Carbon::parse($empInfo->emplo_to)->format('d-m-Y')  }}--}}
{{--                                                        @else--}}
{{--                                                            Till Now--}}
{{--                                                        @endif--}}
{{--                                                    </td>--}}
{{--                                                    <td>{{ $empInfo->emplo_desig }}</td>--}}
{{--                                                    <td>{{ $empInfo->country }}</td>--}}
{{--                                                </tr>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}


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
                                        {{--                                        {{ \Illuminate\Support\Facades\Log::info($emp_his_emplment_old) }}--}}


{{--                                        @foreach($emp_his_job_last as $empInfoOld)--}}
{{--                                            <tr>--}}
{{--                                                <td>{{ Carbon\Carbon::parse($empInfoOld->emplo_from)->format('d-m-Y')  }}</td>--}}
{{--                                                <td>@if(count($empInfoOld->emplo_to))--}}
{{--                                                        {{ Carbon\Carbon::parse($empInfoOld->emplo_to)->format('d-m-Y')  }}--}}
{{--                                                    @else--}}
{{--                                                        Till Now--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                                <td>{{ $empInfoOld->emplo_desig }} , {{ $empInfoOld->emplo_comp_name }}</td>--}}
{{--                                                <td>{{ $empInfoOld->country }}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}

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
{{--                                                @foreach($emp_his_language as $language)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{{ $language->lang  }}</td>--}}
{{--                                                        <td>{{ $language->lang_level }}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
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
                                                {{-- {{ \Illuminate\Support\Facades\Log::info($emp_his_edu_old) }} --}}


{{--                                                @foreach($emp_his_edu_old as $empedu)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>@if(count($empedu->edu_passing_yr))--}}
{{--                                                                {{ ($empedu->edu_passing_yr)  }}--}}
{{--                                                            @else--}}
{{--                                                                Till Now--}}
{{--                                                            @endif--}}
{{--                                                        </td>--}}
{{--                                                        <td>{{ $empedu->degree_name }}, {{  $empedu->edu_subject }}</td>--}}
{{--                                                        <td>{{ $empedu->edu_marks }}</td>--}}
{{--                                                        <td>{{ $empedu->edu_insti_name }}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}

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
                                        {{-- {{ \Illuminate\Support\Facades\Log::info($emp_his_pro_quali) }} --}}


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

                                <ul class="list-inline pull-right">
                                    <div id="editor"></div>

                                    <li>
                                        <button type="submit" id="btn_displayNP_group" class="btn btn-warning btn-sm">
                                            <i class="fa fa-print"></i> <b>Print Document</b></button>
                                    {{-- <li>
                                        <input type="button" onclick="printDiv('printableArea')" value="Print!" />
                                    </li> --}}
                                    <li>
                                        <button type="button" class="btn btn-primary next-step">Continue</button>
                                    </li>
                                </ul>
                            </form>

                        </div>


                        {{-- second Page    --}}

                        <div class="tab-pane" role="tabpanel" id="step2">
                            <form id="" method="post" action="{{ url('talent_development/') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="emp_id" value="{{ $emp_his_info[0]->emp_id }}">

                                <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                                    <section class="panel panel-info">


                                        <div class="row">
                                            <div class="col-xs-12">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        {{-- PERSONAL INFORMATION --}}
                                                        <td>
                                                            <table border="0" cellpadding="2" cellspacing="2" width="100%">
                                                                <tr>
                                                                    <td colspan="2"><b>PERSONAL INFORMATION</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Last Name:</td>
                                                                    <td>{{ $emp_his_info[0]->last_name  }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>First Name:</td>
                                                                    <td>{{ $emp_his_info[0]->first_name  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Birth Date:</td>
                                                                    <td>{{ Carbon\Carbon::parse($emp_his_info[0]->birth_dt)->format('d-m-Y')  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Age:</td>
                                                                    <td>30</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Emp. ID :</td>
                                                                    <td>1010112</td>
                                                                </tr>
                                                            </table>
                                                        </td>


                                                        {{-- picture --}}
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

                                                        {{-- CURRENT POSITION --}}
                                                        <td>
                                                            <table style="border-right: none;" cellpadding="2"
                                                                   cellspacing="2"
                                                                   width="100%">
                                                                <tr>
                                                                    <td colspan="2"><b>PERSONAL PREFERENCES / MOBILITY</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mobile ?</td>
                                                                    <td>
                                                                        <input type="radio" id="mobiliy" name="mobiliy"
                                                                               value="YES"> YES
                                                                        <input type="radio" id="mobiliy" name="mobiliy"
                                                                               value="NO"> NO
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Position:</td>
                                                                    <td>{{ $emp_his_info[0]->desig_name  }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Possible Positions:</td>
                                                                    <td><input type="text" id="ppositions"
                                                                               class="form-control input-sm"
                                                                               name="ppositions"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Possible Location:</td>
                                                                    <td><input type="text" id="plocation" name="plocation"
                                                                               class="form-control input-sm"></td>
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
                                                                <label class="col-sm-2 col-sm-2 control-label input-sm">Group</label>
                                                                <div class="col-md-10 col-sm-10">
                                                                    <select name="dggroup" id="dggroup"
                                                                            class="form-control input-sm m-bot15 year">
                                                                        <option value="">Select Group</option>
                                                                        @foreach($development_group as $dp)
                                                                            <option value="{{$dp->dg_id}}">{{$dp->dg_name}}</option>
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
                                                    <legend class="scheduler-border">Potentials Explained</legend>
                                                    <div class="form-group">

                                                        <div class="col-md-3 col-sm-3">
                                                            <label class="col-sm-3 col-sm-3 control-label input-sm">
                                                                <button type="button" style="background-color: #FFA07A; color: #ffffff" class=" btn btn-xs pe " data-toggle="modal" data-target="#potentialsModal" id="1">Agility</button>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <select name="agility" id="agility"
                                                                        class="form-control input-sm m-bot15 agility">
                                                                    <option value="">Select ...</option>
                                                                    <option value="Low">Low</option>
                                                                    <option value="Medium">Medium</option>
                                                                    <option value="High">High</option>
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
                                                                    <option value="Low">Low</option>
                                                                    <option value="Medium">Medium</option>
                                                                    <option value="High">High</option>
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
                                                                    <option value="Low">Low</option>
                                                                    <option value="Medium">Medium</option>
                                                                    <option value="High">High</option>
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
                                                                    <option value="Low">Low</option>
                                                                    <option value="Medium">Medium</option>
                                                                    <option value="High">High</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>


                                    </section>
                                </div>
                            </form>


                            <ul class="list-inline pull-right">
                                <li>
                                    <button type="button" class="btn btn-default prev-step">Previous</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-primary next-step">Save and continue</button>
                                </li>
                            </ul>
                        </div>


                        <div class="tab-pane" role="tabpanel" id="complete">
                            <h3>Complete</h3>
                            <p>You have successfully completed all steps.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    {{-- </form> --}}
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


<script type="text/javaScript">
    $('.emp_id').select2();


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

                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);

            });
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

</script>

@endsection