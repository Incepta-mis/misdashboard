@extends('_layout_shared._master')
@section('title','Result Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px
        }

        .select2 { text-transform: uppercase; }

        . {
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

        label {
            font-size: 12px;
        }

        input, select {
            color: #000000;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 32px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }

        .field-h {
            font-size: 11px;
            resize: both;
            /*background: #ffd73e33;*/
            border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg' %3E %3Cstyle%3Epath%7Banimation:stroke 5s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='red' /%3E%3Cstop offset='25%25' stop-color='red' /%3E%3Cstop offset='50%25' stop-color='red' /%3E%3Cstop offset='100%25' stop-color='red' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
        }

        .input-xs {
            height: 23px;
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 1px;
        }

        .input-group-xs > .form-control,
        .input-group-xs > .input-group-addon,
        .input-group-xs > .input-group-btn > .btn {
            height: 23px;
            padding: 2px 5px;
            font-size: 12px;
            /*line-height: 1.5;*/
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove orangered !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: orangered;
        }

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #337AC7;
        }

        .cls-req{
            color: red;
            font-weight: bold;
        }

    </style>
@endsection
@section('right-content')
    <div class="row" id="top_ssmrv">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Result Information
                    </label>
                </header>
                <form action="" id="result_info_data">
                    <div class="panel-body" style="margin-top: 10px;">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-12">
                                <div class="input-group select2-bootstrap-prepend">
                                    <select type="text" class="form-control" id="productlist">
                                        <option value="">SELECT PRODUCT</option>
                                        @foreach($productinfo as $pi)

                                            <option value="{{$pi->pname}}|{{$pi->batch_number}}|{{$pi->chamber_stor_cond}}|{{$pi->test_parameters}}|{{$pi->accept_criteria}}|{{$pi->generic_name}}">
                                                {{$pi->pname}} - {{$pi->generic_name}}
                                                - {{$pi->batch_number}} - {{$pi->chamber_stor_cond}}
                                                - {{$pi->test_parameters}}-{{$pi->accept_criteria}}

                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                <button class="btn btn-primary" id="btn_display" type="button">Display!</button>
                              </span>
                                </div>
                            </div><!-- /input-group -->
                        </div>


                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Sample Data</legend>
                                    <div class="col-md-12">
                                        <p class="cls-req">*(Fields are required)</p>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Product Name:</b><span  class="cls-req">*</span></label>
                                                <input type="text" id="pname2" style="display:none;"
                                                       class="form-control input-xs">
                                                <select name="pname" id="pname" class="form-control input-xs">
                                                    <option value="" disabled>Select Product</option>
                                                    @foreach($sampleinfo as $si)

                                                        <option value="{{$si->pname}}|{{$si->batch_number}}|{{$si->chamber_id}}">{{$si->pname}} {{$si->batch_number}} {{$si->chamber_id}}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Chamber ID:</b></label>
                                                <input type="text" class="form-control input-xs" id="chamber_id"
                                                       placeholder=""
                                                       name="chamber_id" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Chamber Storage Location"><b>Chamber
                                                        Location:</b></label>
                                                <input type="text" class="form-control input-xs" id="CHAMBER_STOR_LOC"
                                                       placeholder=""
                                                       name="chamber_stor_loc" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Generic Name:</b><span  class="cls-req">*</span></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="generic_name" placeholder=""
                                                       name="generic_name">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Batch Number:</b><span  class="cls-req">*</span></label>
                                                <input type="text" class="form-control input-xs" id="batch_number"
                                                       placeholder=""
                                                       name= "batch_number" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label for="email"><b>Time Points:</b></label>
                                                <input type="text" class="form-control input-xs" id="time_point"
                                                       placeholder=""
                                                       name="time_point" readonly>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Time Point Tested:</b></label>
                                                <input type="number"
                                                       class="form-control input-xs" id="time_point_tested"
                                                       placeholder="" name="time_point_tested">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Time Points Unit:</b></label>
                                                <input type="text" class="form-control input-xs" id="time_point_unit"
                                                       placeholder="" name="time_point_unit" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Chamber Storage Conditions"><b>Storage
                                                        Conditions:</b><span  class="cls-req">*</span></label>
                                                <input type="text" class="form-control input-xs" id="chamber_stor_cond"
                                                       placeholder=""
                                                       name="chamber_stor_cond" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Product/Sample Information"><b>Prdct/Smpl
                                                        Info:</b></label>
                                                <select name="PROD_SAMP_INFO" id="prod_samp_info"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Select Product/Sample Information</option>
                                                    @foreach($psample as $ps)

                                                        <option value="{{$ps->psi_name}}">{{$ps->psi_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="PROD_SAMP_INFO" placeholder="Enter Product/Sample Information" name="PROD_SAMP_INFO">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label for="email"><b>Mode of Packing:</b></label>
                                                <input type="text" class="form-control input-xs" id="mode_of_pack"
                                                       placeholder=""
                                                       name="mode_of_pack" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Test Parameters:</b><span  class="cls-req">*</span></label>
                                                <select name="test_parameters" id="test_parameters"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Select Test Parameters</option>
                                                    @foreach($resulttp as $rtp)

                                                        <option value="{{$rtp->tp_name}}">{{$rtp->tp_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="TEST_PARAMETERS" placeholder="Enter Test Parameters" name="TEST_PARAMETERS">--}}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Test Method:</b></label>
                                                <select name="test_method" id="test_method"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Select Test Method</option>
                                                    @foreach($resulttm as $rtm)

                                                        <option value="{{$rtm->tm_name}}">{{$rtm->tm_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="TEST_METHOD" placeholder="Enter Test Method" name="TEST_METHOD">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Acceptance Criteria:</b><span  class="cls-req">*</span></label>
{{--                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"--}}
{{--                                                       class="form-control input-xs" id="accept_criteria"--}}
{{--                                                       placeholder=""--}
{{--                                                       name="accept_criteria">--}}
                                                <select style="width: 150px;  overflow: hidden;" oninput="this.value = this.value.toUpperCase()" id="accept_criteria" class="form-control input-sm  accept_criteria" name="accept_criteria" ></select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Stability Types :</b></label>
                                                <input type="text" class="form-control input-xs" id="stab_type"
                                                       placeholder=""
                                                       name="stab_type" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email"><b>Stability Study Reason:</b></label>
                                                <input type="text" class="form-control input-xs" id="stab_study_reason"
                                                       placeholder="" name="stab_study_reason" readonly>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border2">
                                    <legend class="scheduler-border2">Month Wise Result Data(Assay/Average)</legend>

                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Initial /Zero time Result"><b>Intl/zero time
                                                        Result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="AVA_INITIAL_RESULT" class="form-control input-xs"
                                                       id="ava_initial_result"
                                                       placeholder="" name="ava_initial_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1st week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="AVA_WEEK1_RESULT" class="form-control input-xs"
                                                       id="ava_week1_result"
                                                       placeholder=""
                                                       name="ava_week1_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2nd week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="AVA_WEEK2_RESULT" class="form-control input-xs"
                                                       id="ava_week2_result"
                                                       placeholder="" name="ava_week2_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3rd week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="AVA_WEEK3_RESULT" class="form-control input-xs"
                                                       id="ava_week3_result"
                                                       placeholder="" name="ava_week3_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1st month result :</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="AVA_MONTH1_RESULT" class="form-control input-xs"
                                                       id="ava_month1_result"
                                                       placeholder=""
                                                       name="ava_month1_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2nd month result :</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month2_result"
                                                       placeholder="" name="ava_month2_result">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12">


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3rd month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month3_result"
                                                       placeholder="" name="ava_month3_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>6th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month6_result"
                                                       placeholder=""
                                                       name="ava_month6_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>9th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month9_result"
                                                       placeholder="" name="ava_month9_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>12th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month12_result"
                                                       placeholder="" name="ava_month12_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>18th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month18_result"
                                                       placeholder="" name="ava_month18_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>24th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month24_result"
                                                       placeholder="" name="ava_month24_result">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>36th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month36_result"
                                                       placeholder=""
                                                       name="ava_month36_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>48th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month48_result"
                                                       placeholder=""
                                                       name="ava_month48_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>60th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_month60_result"
                                                       placeholder=""
                                                       name="ava_month60_result">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email"><b>Others result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ava_others_result"
                                                       placeholder=""
                                                       name="ava_others_result">
                                            </div>
                                        </div>

                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Month Wise Result Data(Maximum)</legend>

                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Initial /Zero time Result"><b>Intl/zero time
                                                        Result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MAX_INITIAL_RESULT" class="form-control input-xs"
                                                       id="max_initial_result"
                                                       placeholder=""
                                                       name="max_initial_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1st week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MAX_WEEK1_RESULT" class="form-control input-xs"
                                                       id="max_week1_result"
                                                       placeholder=""
                                                       name="max_week1_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2nd week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MAX_WEEK2_RESULT" class="form-control input-xs"
                                                       id="max_week2_result"
                                                       placeholder=""
                                                       name="max_week2_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3rd week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MAX_WEEK3_RESULT" class="form-control input-xs"
                                                       id="max_week3_result"
                                                       placeholder=""
                                                       name="max_week3_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1st month result :</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MAX_MONTH1_RESULT" class="form-control input-xs"
                                                       id="max_month1_result"
                                                       placeholder=""
                                                       name="max_month1_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2nd month result :</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month2_result"
                                                       placeholder="" name="max_month2_result">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12">


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3rd month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month3_result"
                                                       placeholder="" name="max_month3_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>6th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month6_result"
                                                       placeholder=""
                                                       name="max_month6_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>9th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month9_result"
                                                       placeholder="" name="max_month9_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>12th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month12_result"
                                                       placeholder=""
                                                       name="max_month12_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>18th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month18_result"
                                                       placeholder="" name="max_month18_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>24th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month24_result"
                                                       placeholder="" name="max_month24_result">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>36th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month36_result"
                                                       placeholder=""
                                                       name="max_month36_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>48th month result:</b></label>
                                                <input type="text" class="form-control input-xs" id="max_month48_result"
                                                       placeholder=""
                                                       name="max_month48_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>60th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_month60_result"
                                                       placeholder="" name="max_month60_result">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email"><b>Others result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="max_others_result"
                                                       placeholder=""
                                                       name="max_others_result">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border2">
                                    <legend class="scheduler-border2">Month Wise Result Data(Minimum)</legend>


                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Initial /Zero time Result"><b>Intl/zero time
                                                        Result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MIN_INITIAL_RESULT" class="form-control input-xs"
                                                       id="min_initial_result"
                                                       placeholder=""
                                                       name="min_initial_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1st week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MIN_WEEK1_RESULT" class="form-control input-xs"
                                                       id="min_week1_result"
                                                       placeholder=""
                                                       name="min_week1_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2nd week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MIN_WEEK2_RESULT" class="form-control input-xs"
                                                       id="min_week2_result"
                                                       placeholder=""
                                                       name="min_week2_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3rd week result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="MIN_WEEK3_RESULT" class="form-control input-xs"
                                                       id="min_week3_result"
                                                       placeholder=""
                                                       name="min_week3_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1st month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month1_result"
                                                       placeholder=""
                                                       name="max_month1_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2nd month result :</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month2_result"
                                                       placeholder=""
                                                       name="min_month2_result">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12">


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3rd month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month3_result"
                                                       placeholder=""
                                                       name="min_month3_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>6th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month6_result"
                                                       placeholder=""
                                                       name="min_month6_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>9th month result:</b></label>
                                                <input type="text" class="form-control input-xs" id="min_month9_result"
                                                       placeholder=""
                                                       name="min_month9_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>12th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month12_result"
                                                       placeholder=""
                                                       name="min_month12_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>18th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month18_result"
                                                       placeholder=""
                                                       name="min_month18_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>24th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month24_result"
                                                       placeholder=""
                                                       name="min_month24_result">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>36th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month36_result"
                                                       placeholder=""
                                                       name="min_month36_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>48th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month48_result"
                                                       placeholder=""
                                                       name="min_month48_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>60th month result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_month60_result"
                                                       placeholder=""
                                                       name="min_month60_result">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Others result:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="min_others_result"
                                                       placeholder=""
                                                       name="min_others_result">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">EC & B/R Analysis Data</legend>

                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of Initial Analysis"><b>Initial
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br_initial"
                                                       placeholder="" name="ec_br_initial">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 1st week Analysis"><b>1st week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br1_week"
                                                       placeholder=""
                                                       name="ec_br1_week">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 2nd week Analysis"><b>2nd week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br2_week"
                                                       placeholder="" name="ec_br2_week">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 3rd week Analysis"><b>3rd week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br3_week"
                                                       placeholder="" name="ec_br3_week">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 1st month Analysis"><b>1st month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br1_month"
                                                       placeholder="" name="ec_br1_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 2nd month Analysis"><b>2nd month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br2_month"
                                                       placeholder="" name="ec_br2_month">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 3rd month Analysis"><b>3rd month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br3_month"
                                                       placeholder="" name="ec_br3_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 6th month Analysis"><b>6th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br6_month"
                                                       placeholder=""
                                                       name="ec_br6_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 9th month Analysis"><b>9th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br9_month"
                                                       placeholder="" name="ec_br9_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 12th month Analysis"><b>12th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br12_month"
                                                       placeholder="" name="ec_br12_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 18th month Analysis"><b>18th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br18_month"
                                                       placeholder="" name="ec_br18_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 24th month Analysis"><b>24th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br24_month"
                                                       placeholder="" name="ec_br24_month">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 36th month Analysis"><b>36th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="EC_BR36_MONTH"
                                                       placeholder="" name="ec_br36_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 48th month Analysis"><b>48th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br48_month"
                                                       placeholder=""
                                                       name="ec_br48_month">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of 60th month Analysis"><b>60th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br60_month"
                                                       placeholder="" name="ec_br60_month">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" title="EC & B/R of Others Analysis"><b>Others
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ec_br_others"
                                                       placeholder=""
                                                       name="ec_br_others">
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border2">
                                    <legend class="scheduler-border2">Machine ID Analysis Data</legend>

                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of Initial Analysis"><b>Initial
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_initial"
                                                       placeholder="" name="mid_initial">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 1st week Analysis"><b>1st week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_week1"
                                                       placeholder=""
                                                       name="mid_week1">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 2nd week Analysis"><b>2nd week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_week2"
                                                       placeholder="" name="mid_week2">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 3rd week Analysis"><b>3rd week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_week3"
                                                       placeholder="" name="mid_week3">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 1st month Analysis"><b>1st month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month1"
                                                       placeholder="" name="mid_month1">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 2nd month Analysis"><b>2nd month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month2"
                                                       placeholder="" name="mid_month2">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 3rd month Analysis"><b>3rd month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month3"
                                                       placeholder="" name="mid_month3">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 6th month Analysis"><b>6th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month6"
                                                       placeholder=""
                                                       name="mid_month6">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 9th month Analysis"><b>9th month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month9"
                                                       placeholder="" name="mid_month9">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 12th month Analysis"><b>12th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month12"
                                                       placeholder="" name="mid_month12">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 18th month Analysis"><b>18th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month18"
                                                       placeholder="" name="mid_month18">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 24th month Analysis"><b>24th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month24"
                                                       placeholder="" name="mid_month24">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 36th month Analysis"><b>36th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month36"
                                                       placeholder="" name="mid_month36">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 48th month Analysis"><b>48th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month48"
                                                       placeholder=""
                                                       name="mid_month48">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 60th month Analysis"><b>60th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_month60"
                                                       placeholder="" name="mid_month60">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of Others Analysis"><b>Others
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mid_others"
                                                       placeholder=""
                                                       name="mid_others">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border"> Machine Hour Analysis Data</legend>


                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of Initial Analysis"><b>Initial
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_initial"
                                                       placeholder="" name="mhoure_initial">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 1st week Analysis"><b>1st week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_week1"
                                                       placeholder=""
                                                       name="mhoure_week1">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 2nd week Analysis"><b>2nd week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_week2"
                                                       placeholder="" name="mhoure_week2">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 3rd week Analysis"><b>3rd week
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_week3"
                                                       placeholder="" name="mhoure_week3">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 1st month Analysis"><b>1st
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month1"
                                                       placeholder="" name="mhoure_month1">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 2nd month Analysis"><b>2nd
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="MHOURE_MONTH2"
                                                       placeholder="" name="MHOURE_MONTH2">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 3rd month Analysis"><b>3rd
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month3"
                                                       placeholder="" name="mhoure_month3">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 6th month Analysis"><b>6th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month6"
                                                       placeholder=""
                                                       name="mhoure_month6">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 9th month Analysis"><b>9th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month9"
                                                       placeholder="" name="mhoure_month9">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 12th month Analysis"><b>12th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month12"
                                                       placeholder=""
                                                       name="mhoure_month12">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 18th month Analysis"><b>18th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month18"
                                                       placeholder=""
                                                       name="mhoure_month18">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 24th month Analysis"><b>24th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month24"
                                                       placeholder=""
                                                       name="mhoure_month24">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 36th month Analysis"><b>36th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month36"
                                                       placeholder=""
                                                       name="mhoure_month36">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of 48th month Analysis"><b>48th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month48"
                                                       placeholder=""
                                                       name="mhoure_month48">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine ID of 60th month Analysis"><b>60th
                                                        month
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_month60"
                                                       placeholder="" name="mhoure_month60">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" title="Machine Hour of Others Analysis"><b>Others
                                                        Analysis:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mhoure_others"
                                                       placeholder="" name="mhoure_others">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border2">
                                    <legend class="scheduler-border2">Assay Method Data</legend>


                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Assay Method"><b>Assay Method:</b></label>
                                                <select name="assay_method" id="assay_method"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Select Assay Method</option>
                                                    @foreach($assay as $a)

                                                        <option value="{{$a->am_name}}">{{$a->am_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="ASSAY_METHOD" placeholder="Enter Assay Method" name="ASSAY_METHOD">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Dissolution Method"><b>Dissolution Method:</b></label>
                                                <select name="dissolution_method" id="dissolution_method"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Select Assay Method</option>
                                                    @foreach($diss as $d)

                                                        <option value="{{$d->dm_name}}">{{$d->dm_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="DISSOLUTION_METHOD" placeholder="Enter Dissolution Method" name="DISSOLUTION_METHOD">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Impurity method"><b>Impurity
                                                        method:</b></label>
                                                <select name="impurity_method" id="impurity_method"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Select Impurity Method</option>
                                                    @foreach($imp as $im)

                                                        <option value="{{$im->im_name}}">{{$im->im_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="IMPURITY_METHOD" placeholder="Enter Impurity method" name="IMPURITY_METHOD">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Analysis time /product"><b>Analysis
                                                        time/prdct:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ana_time_pro"
                                                       placeholder="" name="ana_time_pro">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Analysis time/next single batch"><b>Analysis
                                                        single batch:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ana_time_nsb"
                                                       placeholder="" name="ana_time_nsb">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine run Time/product"><b>Machine
                                                        R.T/P:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mrun_time_product"
                                                       placeholder="" name="mrun_time_product">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Machine run Time /next batch"><b>Machine
                                                        R.T/NB:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="mrun_time_batch"
                                                       placeholder="" name="mrun_time_batch">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Testing Frequency"><b>Testing
                                                        Frequency:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="testing_frequency"
                                                       placeholder="" name="testing_frequency">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Calculated Machine hour"><b>Calculated
                                                        M/H:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="CALCULATE_MHOURE"
                                                       placeholder="" name="calculate_mhoure">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Actual Machine hour"><b>Actual Machine
                                                        hour:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="ACTUAL_MHOURE"
                                                       placeholder="" name="actual_mhoure">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Sample Orientation"><b>Sample Orientation:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="sample_orientation"
                                                       placeholder="" name="sample_orientation">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Remarks"><b>Remarks:</b></label>
                                                <input onkeyup="this.value = this.value.toUpperCase();"
                                                       type="text" class="form-control input-xs" id="remarks"
                                                       placeholder=""
                                                       name="remarks">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        {{--                        <div class="row" style="margin-bottom: 10px;">--}}
                        {{--                            <div class="col-md-12">--}}
                        {{--                                <fieldset class="scheduler-border">--}}
                        {{--                                    <legend class="scheduler-border">Daily Machine Run Status</legend>--}}


                        {{--                                    <div class="col-md-12">--}}
                        {{--                                        <div class="col-md-2">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Machine Name"><b>Machine Name:</b></label>--}}
                        {{--                                                <select name="assay_method" id="assay_method"--}}
                        {{--                                                        class="form-control input-xs">--}}
                        {{--                                                    <option value="" selected>Select Machine Name</option>--}}
                        {{--                                                    @foreach($mname as $mn)--}}

                        {{--                                                        <option value="{{$mn->mn_name}}">{{$mn->mn_name}}</option>--}}
                        {{--                                                    @endforeach--}}
                        {{--                                                </select>--}}
                        {{--                                                --}}{{--                                <input type="text" class="" id="M_NAME" placeholder="Enter Machine Name" name="M_NAME">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-md-2">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Machine ID"><b>Machine ID:</b></label>--}}
                        {{--                                                <select name="m_id" id="m_id" class="form-control input-xs">--}}
                        {{--                                                    <option value="" selected>Enter Machine ID</option>--}}
                        {{--                                                    @foreach($mid as $mi)--}}

                        {{--                                                        <option value="{{$mi->mi_name}}">{{$mi->mi_name}}</option>--}}
                        {{--                                                    @endforeach--}}
                        {{--                                                </select>--}}
                        {{--                                                --}}{{--                                <input type="text" class="" id="M_ID" placeholder="Enter Machine ID" name="M_ID">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-md-2">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Machine Assign To"><b>Machine Assign--}}
                        {{--                                                        To:</b></label>--}}
                        {{--                                                <select name="m_a_to" id="m_a_to" class="form-control input-xs">--}}
                        {{--                                                    <option value="" selected>Select Machine Assign--}}
                        {{--                                                        To</option>--}}
                        {{--                                                    @foreach($m_a_to as $mato)--}}

                        {{--                                                        <option value="{{$mato->emp_name}}">{{$mato->emp_name}}</option>--}}
                        {{--                                                    @endforeach--}}
                        {{--                                                </select>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-md-2">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Machine Start Time"><b>Machine Start Time:</b></label>--}}
                        {{--                                                <input type="text" class="form-control input-xs" id="m_start_date_time"--}}
                        {{--                                                       readonly=""--}}
                        {{--                                                       placeholder="" name="m_start_date_time">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-md-2">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Machine Stop Time"><b>Machine Stop--}}
                        {{--                                                        Time:</b></label>--}}
                        {{--                                                <input type="text" class="form-control input-xs" id="m_stop_date_time"--}}
                        {{--                                                       readonly=""--}}
                        {{--                                                       placeholder="" name="m_stop_date_time">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-md-2">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Machine Run Time Total"><b>Machine R.T.T:</b></label>--}}
                        {{--                                                <input type="text" class="form-control input-xs" id="m_r_time_total"--}}
                        {{--                                                       readonly--}}
                        {{--                                                       name="m_r_time_total">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}


                        {{--                                    </div>--}}
                        {{--                                    <div class="col-md-12">--}}

                        {{--                                        <div class="col-md-4">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Machine Idle Time"><b>Machine Idle--}}
                        {{--                                                        Time:</b></label>--}}
                        {{--                                                <input type="text" class="form-control input-xs" id="m_idle_time"--}}
                        {{--                                                       placeholder=""--}}
                        {{--                                                       name="m_idle_time">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-md-4">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email" title="Justification of Machine Idle Time"><b>Justification--}}
                        {{--                                                        of--}}
                        {{--                                                        M.I.T:</b></label>--}}
                        {{--                                                <input type="text" class="form-control input-xs" id="jomi_time"--}}
                        {{--                                                       placeholder="" name="jomi_time">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="col-md-4">--}}
                        {{--                                            <div class="form-group">--}}
                        {{--                                                <label for="email"><b>Machine Breakdown hour:</b></label>--}}
                        {{--                                                <input type="text" class="form-control input-xs" id="mb_hour"--}}
                        {{--                                                       placeholder=""--}}
                        {{--                                                       name="mb_hour">--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </fieldset>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}


                        <div class="col-md-12">
                            <div class="col-md-8 col-md-offset-2 text-center" style="padding-top: 20px;">
                                <button type="button" id="btn_save" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> <b>SAVE</b></button>

                                <button type="button" id="btn_update" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> <b>UPDATE</b></button>
                                <button type="button" id="btn_refresh" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> <b>REFRESH</b></button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}

    <script>
        var totalminutes = 0;
        $.fn.select2.defaults.set("theme", "bootstrap");
        var date = new Date();
        $('#productlist').select2({
            width: null
        });

        // function machinertt() {
        //     var a = moment($('#m_stop_date_time').val());//now
        //     var b = moment($('#m_start_date_time').val());
        //     if (a && b) {
        //         console.log(a.diff(b, 'minutes')); // 44700
        //         console.log(a.diff(b, 'hours'));// 745
        //         // $('#m_r_time_total').val(a.diff(b, 'hours'));
        //         var hours = (a.diff(b, 'minutes') / 60);
        //         var rhours = Math.floor(hours);
        //         var minutes = (hours - rhours) * 60;
        //         var rminutes = Math.round(minutes);
        //         totalminutes = a.diff(b, 'minutes');
        //         if (!isNaN(rhours) && !isNaN(rminutes)) {
        //             $('#m_r_time_total').val(rhours + ':' + rminutes);
        //         }
        //
        //     }
        //
        //
        // }

        // $('#m_start_date_time,#m_stop_date_time').datetimepicker({
        //     defaultDate: date,
        //     format: 'DD-MMM-YY h:mm A',
        //     ignoreReadonly: true
        // });
        // $('#m_start_date_time').on('dp.change', function () {
        //     console.log('date1');
        //     machinertt();
        // });
        // $('#m_stop_date_time').on('dp.change', function () {
        //     console.log('date2');
        //     machinertt();
        // });

        $(document).ready(function () {

            $('#btn_update').prop('disabled', true);

            function objectifyForm(formArray) {
                //serialize data function
                var returnArray = {};
                for (var i = 0; i < formArray.length; i++) {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
                return returnArray;
            }

            // function chcecktestparam() {
            //     var isvalid = true;
            //     if ($('#test_parameters').val() === 'DESCRIPTION' && $('#m_a_to').val() === '') {
            //         toastr.error('"Machine Assign To" CANNOT BE EMPTY');
            //         isvalid = false;
            //     }
            //     return isvalid;
            // }

            $('#btn_save').on('click', function () {
                console.log($('#pname').val(), $('#batch_number').val(), $('#chamber_stor_cond').val(), $('#test_parameters').val(), $('#accept_criteria').val(), $('#generic_name').val());
                if ($('#pname').val() && $('#batch_number').val() && $('#chamber_stor_cond').val() && $('#test_parameters').val() && $('#accept_criteria').val() && $('#generic_name').val()) {
                    // if (chcecktestparam())
                    // {
                    console.log('clicked');
                    var formdata = $('#result_info_data').serializeArray();


                    console.log(objectifyForm(formdata));
                    var formdat = objectifyForm(formdata);
                    // formdat.m_r_time_total = totalminutes;
                    $.ajax({
                        type: 'post',
                        url: '{{url('ssm/resultsave_info')}}',
                        data: {
                            fdata: formdat,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            if (response.status === 'SAVED') {
                                var optionlist = '<option value="">SELECT PRODUCT</option>';
                                for (var i = 0; i < response.xyz.length; i++) {

                                    optionlist += '<option value="' + response.xyz[i].pname + '|' + response.xyz[i].batch_number + '|' + response.xyz[i].chamber_stor_cond + '|' + response.xyz[i].test_parameters + '|' + response.xyz[i].accept_criteria + '|' + response.xyz[i].time_point + '">' + response.xyz[i].pname + ' ' + response.xyz[i].batch_number + ' ' + response.xyz[i].chamber_stor_loc + '</option>';
                                }
                                $('#productlist').empty().append(optionlist);
                                toastr.info('SAVED SUCCESSULLY');
                                $('#result_info_data')[0].reset();
                                console.log(response);
                            }

                        },
                        error: function (error) {
                            toastr.info('UNABLE TO SAVE');
                            console.log(error);
                        }
                    })
                    // }


                } else {
                    toastr.error('PRODUCT NAME ,GENERIC NAME, BATCH NUMBNER , CHAMBER STORAGE COND.,TEST PARAMETERS & ACCEPT CRITERIA IS REQUIRED');
                }
            });
            $('#btn_refresh').on('click', function () {
                console.log('clicked');
                $('#pname,#batch_number,#chamber_stor_cond,#accept_criteria,#generic_name').prop('readonly', false);
                $('#test_parameters').attr("style", "pointer-events: auto;");
                $('#productlist').val('').trigger('change');
                $('#result_info_data')[0].reset();
                $('#btn_update').prop('disabled', true);
                $('#btn_save').prop('disabled', false);
                $('#pname').show();
                $('#pname2').hide();
                $('#pname2').val('').prop('readonly', false);
                $('html, body').animate({scrollTop: $("#top_ssmrv").position().top}, 800);

            });
            $('#btn_update').on('click', function () {
                // if (chcecktestparam()){
                console.log('clicked');
                var formdata = $('#result_info_data').serializeArray();

                var postdata = objectifyForm(formdata);
                postdata.pname = $('#pname2').val();
                postdata.m_r_time_total = totalminutes;
                console.log(postdata);

                $.ajax({
                    type: 'post',
                    url: '{{url('ssm/ri_update_info')}}',
                    data: {
                        fdata: postdata,
                        param: $('#productlist').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log("update response");
                        console.log(response);

                        if (response.status === 'SUCCESSFULLY') {
                            toastr.info('UPDATED SUCCESSULLY');
                            $('#result_info_data')[0].reset();
                            $('#pname').show();
                            $('#pname2').hide();
                            $('#pname2').val('').prop('readonly', false);
                            console.log(response);
                            $('#btn_update').prop('disabled', true);
                            $('#btn_save').prop('disabled', false);
                            // $('#result_info_data')[0].reset();
                            $("#productlist").val('').trigger('change')
                        }
                    },
                    error: function (error) {
                        toastr.info('UNABLE TO SAVE');
                        console.log(error);
                    }
                })
                // }

            });
            $('#btn_display').on('click', function () {
                console.log('clicked');

                $.ajax({
                    type: 'post',
                    url: '{{url('ssm/ri_retrieve_info')}}',
                    data: {
                        fdata: $('#productlist').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response[0]);
                        $('#result_info_data').autofill(response[0]);
                        $('#pname').hide();
                        $('#pname2').show();
                        $('#pname2').val(response[0].pname).prop('readonly', true);
                       //$('#accept_criteria').val('dfd').change();
                       //  $("#accept_criteria").val("val2");



                        var $newOption = $("<option selected='selected'></option>").val(response[0]['accept_criteria']).text(response[0]['accept_criteria']);
                        $("#accept_criteria").append($newOption).trigger('change');

                        var hours = (response[0].m_r_time_total / 60);
                        var rhours = Math.floor(hours);
                        var minutes = (hours - rhours) * 60;
                        var rminutes = Math.round(minutes);
                        totalminutes = response[0].m_r_time_total;
                        $('#m_r_time_total').val(rhours + ':' + rminutes);

                        $('#pname,#batch_number,#chamber_stor_cond,#accept_criteria,#generic_name').prop('readonly', true);
                        $('#test_parameters').attr("style", "pointer-events: none;");
                        $('#btn_update').prop('disabled', false);
                        $('#btn_save').prop('disabled', true);
                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                        console.log(error);
                    }
                })
            });

            // product name on change
            $('#pname').on('change', function (e) {
                var selectedProduct = e.target.value;
                $('#result_info_data')[0].reset();
                $('#pname').val(selectedProduct);

                $.ajax({
                    type: 'post',
                    url: '{{url('ssm/get_accept')}}',
                    data: {
                        param: selectedProduct,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response[0]);
                        var selOpts = "";
                        selOpts += "<option value=''>Select Criteria</option>";
                        for (var i = 0; i < response.length; i++) {
                            var id = response[i]['accept_criteria'];
                            var val = response[i]['accept_criteria'];
                            selOpts += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('.accept_criteria').empty().append(selOpts);
                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                        console.log(error);
                    }
                });


                $.ajax({
                    type: 'post',
                    url: '{{url('ssm/ri_retrieve_pinfo')}}',
                    data: {
                        param: selectedProduct,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response[0]);
                        delete response[0]['pname'];
                        $('#result_info_data').autofill(response[0]);
                        // $('#PNAME,#BATCH_NUMBER,#CHAMBER_STOR_COND,#TEST_PARAMETERS,#ACCEPT_CRITERIA').prop('readonly', true);
                        $('#btn_update').prop('disabled', true);
                        $('#btn_save').prop('disabled', false);
                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                        console.log(error);
                    }
                })
            });
            $('input[type="number"]').on('keyup', function (event) {
                console.log(event.target.value);
                var value = event.target.value;
                var regex = new RegExp(/^\+?[0-9(),.-]+$/);
                if (value.match(regex)) {
                    event.target.value = value;
                } else {
                    event.target.value = '';
                }
                ;
            });


        });


        $(".accept_criteria").select2({
            placeholder: 'Select Criteria',
            tags: true,
            selectOnClose: true,
            createSearchChoice: function (term, data) {
                if ($(data).filter(function () {
                    return this.text.localeCompare(term).uppercase === 0;
                }).length === 0) {
                    return { id: term, text: term };
                }
            },
        });
    </script>

@endsection
