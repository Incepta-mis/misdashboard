@extends('_layout_shared._master')
@section('title','Recruitment Management System')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}">
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
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

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: #000;
        }

        .sample_info_panel {
            position: -webkit-sticky;
            top: 0;
        }

        .s_font {
            font-size: 11px;
            padding: 7px 0;
        }

        .form-group {
            margin-bottom: 0;
        }

        input[list] {
            color: black;
            background-color: white;
        }

        .btn_form_below_save button {
            font-size: 11px;
            border-radius: 3px;
            margin: 0 5px;
            background-color: #77BB7A;
            color: #FFF;
            border: 1px solid #77BB7A;
        }

        .btn_form_below_update button {
            font-size: 11px;
            border-radius: 3px;
            margin: 0 5px;
            background-color: #08B2E0;
            color: #FFF;
            border: 1px solid #08B2E0;
        }

        .btn_form_below_refresh button {
            font-size: 11px;
            border-radius: 3px;
            margin: 0 5px;
            background-color: #F69448;
            color: #FFF;
            border: 1px solid #F69448;
        }

        .btn_form_below_save button:hover {
            transition: all 0.3s linear;
            color: #FFF;
            border: 1px solid #021D07;
        }

        .btn_form_below_update button:hover {
            transition: all 0.3s linear;
            color: #FFF;
            border: 1px solid #03244A;
        }

        .btn_form_below_refresh button:hover {
            transition: all 0.3s linear;
            color: #FFF;
            border: 1px solid #F73203;
        }

        .select2-container {
            font-size: 10px;
        }

        .req_label_search {
            padding: 0;
            background-color: #374152;
            color: #FFF;
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;

        }

        fieldset.scheduler-border {
            border: 1px groove #000 !important;
            padding: 0 0.4em 0.4em 0.4em !important;
            margin: 0 0 0.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
            margin: 0;
        }

        legend.scheduler-border {
            width: inherit; /* Or auto */
            padding: 0 10px; /* To give a bit of padding on the left and right */
            border-bottom: none;
            font-size: small;
            font-weight: bold;
            margin: 0;
            color: #0075FF;
            text-align: center;
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

        .custom-btn{
            height: 23px;
            line-height: 0.5;
        }

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="wrapper_div">
            <div class="col-md-12 col-sm-12 sticky-top">
                <section class="sample_info_panel" id="data_table">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 sticky-top">
                            <section class="panel sample_info_panel" id="data_table">
                                <header class="panel-heading">
                                    <label class="text-primary">
                                        Department Wise CV Sorting
                                    </label>
                                    <span class="pull-right">
                                        <button class="btn btn-sm btn-success custom-btn" href="#modalUploadExcel" data-toggle="modal"><i class="fa fa-upload"></i> Upload Excel</button>
                                    </span>
                                </header>
                                <div class="panel-body" style="padding-bottom: 10px;">
                                    <div class="form-horizontal">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-12">
                                                <form action="" class="form-horizontal" role="form">
                                                    <div class="row">
                                                        <div class="col-md-3"
                                                             style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12"
                                                                     style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Plant Name</b></label>
                                                                    <select name="search_plant"
                                                                            id="search_plant"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;"
                                                                            required>
                                                                        <option value=""
                                                                                selected
                                                                                disabled>
                                                                            SELECT
                                                                        </option>
                                                                        @foreach($search_plant_info as $pn)
                                                                            <option value="{{$pn->plant_id}}">{{$pn->plant_id}}
                                                                                | {{$pn->plant_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3"
                                                             style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12"
                                                                     style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Department
                                                                            Name</b></label>
                                                                    <select name="search_dept"
                                                                            id="search_dept"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;"
                                                                            required>
                                                                        <option value=""
                                                                                selected
                                                                                disabled>
                                                                            SELECT
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3"
                                                             style="padding: 0 5px;">
                                                            <div class="col-md-12"
                                                                 style="margin:  0;">
                                                                <label for="rm_terr"
                                                                       class="control-label s_font"
                                                                       style="padding: 0;"><b>Recruitment
                                                                        ID</b></label>
                                                                <select name="search_rec"
                                                                        id="search_rec"
                                                                        class="form-control input-sm"
                                                                        style="font-size: 10px; height: 26px; padding: 0;"
                                                                        required>
                                                                    <option value=""
                                                                            selected
                                                                            disabled>
                                                                        SELECT
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="row">
                                                                <div class="col-md-12" style="padding: 0">
                                                                    <div class="col-md-7" style="margin:  0; padding: 0 0 0 16px">
                                                                        <label for="rm_terr"
                                                                               class="control-label s_font"
                                                                               style="padding: 0;"><b>NID</b></label>
                                                                        <select name="search_nid"
                                                                                id="search_nid"
                                                                                class="form-control input-sm"
                                                                                style="font-size: 10px; height: 26px; padding: 0;"
                                                                                required>
                                                                            <option value=""
                                                                                    selected
                                                                                    disabled>
                                                                                SELECT
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-5" style="margin-top: 20px; padding: 0">
                                                                        <span class="input-group-btn" style="padding: 0 0 0 21px">
                                                                        <button class="btn btn-primary"
                                                                                id="btn_search_nid"
                                                                                name="btn_search_nid" type="button"
                                                                                style="height: 28px; padding: 0 8px; border-radius: 3px">
                                                                            <span
                                                                                    style="padding: 0 6px"
                                                                                    class="glyphicon glyphicon-search"
                                                                                    aria-hidden="true">
                                                                        </span>Search
                                                                        </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr/>

                                                    <div class="row">
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>NID</b></label>
                                                                    <input type="text"
                                                                           name="nid"
                                                                           minlength="10"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="nid" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Candidate
                                                                            Name</b></label>
                                                                    <input type="text"
                                                                           name="candidate_name"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="candidate_name" required>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Father's
                                                                            Name</b></label>
                                                                    <input type="text"
                                                                           name="father_name"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="father_name" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Date of
                                                                            Birth</b></label>
                                                                    <div class="col-md-12 col-sm-8">
                                                                        <div class="form-group">
                                                                            <div class="input-group date" id="dob_year">
                                                                                <input id="dob" name="dob"
                                                                                       type="text"
                                                                                       class="form-control input-sm"
                                                                                       style="height: 26px; background-color: white"
                                                                                       autocomplete="off"
                                                                                       required readonly>
                                                                                <span class="input-group-addon"
                                                                                      style="font-size: 11px;">
                                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="am_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>SSC Result</b></label>
                                                                    <input type="number"
                                                                           min="0"
                                                                           max="5"
                                                                           name="ssc_result"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="ssc_result" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>SSC Passing
                                                                            Year</b></label>
                                                                    <div class="col-md-12 col-sm-8">
                                                                        <div class="form-group">
                                                                            <div class="input-group date"
                                                                                 id="ssc_year">
                                                                                <input id="ssc_passing_year"
                                                                                       name="ssc_passing_year"
                                                                                       type="text" class="form-control"
                                                                                       style="height: 26px; background-color: white"
                                                                                       required readonly>
                                                                                <span class="input-group-addon"
                                                                                      style="font-size: 11px;">
                                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                                    </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>HSC Result</b></label>
                                                                    <input type="number"
                                                                           min="0"
                                                                           max="5"
                                                                           name="hsc_result"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="hsc_result" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>HSC Passing
                                                                            Year</b></label>
                                                                    <div class="col-md-12 col-sm-8">
                                                                        <div class="form-group">
                                                                            <div class="input-group date"
                                                                                 id="hsc_year">
                                                                                <input id="hsc_passing_year"
                                                                                       name="hsc_passing_year"
                                                                                       type="text" class="form-control"
                                                                                       style="height: 26px; background-color: white"
                                                                                       required readonly>
                                                                                <span class="input-group-addon"
                                                                                      style="font-size: 11px;">
                                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                                    </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" style="padding-bottom: 10px; padding-top: 0;">
                                    <div class="form-horizontal">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-12" style="padding: 0 5px">
                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">UNDER GRADUATION</legend>

                                                    <form action="" class="form-horizontal" role="form">
                                                        <div class="row">
                                                            <div class="panel-body"
                                                                 style="padding-bottom: 10px; padding-top: 0">
                                                                <div class="form-horizontal">
                                                                    <div class="col-md-12 col-sm-12"
                                                                         style="padding: 0;">
                                                                        <div class="col-md-12">
                                                                            <form action="" class="form-horizontal"
                                                                                  role="form">
                                                                                <div class="row">
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>University/Institution</b></label>
                                                                                                <select name="g_university"
                                                                                                        id="g_university"
                                                                                                        class="form-control input-sm"
                                                                                                        style="font-size: 10px; height: 26px; padding: 0;"
                                                                                                        required>
                                                                                                    <option value=""
                                                                                                            selected
                                                                                                            disabled>
                                                                                                        SELECT
                                                                                                    </option>
                                                                                                    @foreach($g_university as $gu)
                                                                                                        <option value="{{$gu->university_name}}">{{$gu->university_name}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Result</b></label>
                                                                                                <input type="number"
                                                                                                       min="0"
                                                                                                       max="4"
                                                                                                       name="g_result"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="g_result"
                                                                                                       required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Subject</b></label>
                                                                                                <select name="g_subject"
                                                                                                        id="g_subject"
                                                                                                        class="form-control input-sm"
                                                                                                        style="font-size: 10px; height: 26px; padding: 0;"
                                                                                                        required>
                                                                                                    <option value=""
                                                                                                            selected
                                                                                                            disabled>
                                                                                                        SELECT
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin: 0;">
                                                                                                <label for="quant"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Passing
                                                                                                        Year</b></label>
                                                                                                <div class="col-md-12 col-sm-8">
                                                                                                    <div class="form-group">
                                                                                                        <div class="input-group date"
                                                                                                             id="g_year">
                                                                                                            <input id="g_passing_year"
                                                                                                                   name="g_passing_year"
                                                                                                                   type="text"
                                                                                                                   class="form-control"
                                                                                                                   style=" background-color: white; height: 26px"
                                                                                                                   required
                                                                                                                   readonly>
                                                                                                            <span class="input-group-addon"
                                                                                                                  style="font-size: 11px;">
                                                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                                                                </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </fieldset>

                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">POST GRADUATION</legend>

                                                    <form action="" class="form-horizontal" role="form">
                                                        <div class="row">
                                                            <div class="panel-body"
                                                                 style="padding-bottom: 10px; padding-top: 0;">
                                                                <div class="form-horizontal">
                                                                    <div class="col-md-12 col-sm-12" style="padding: 0">
                                                                        <div class="col-md-12">
                                                                            <form action="" class="form-horizontal"
                                                                                  role="form">
                                                                                <div class="row">
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>University/Institution</b></label>
                                                                                                <input type="text"
                                                                                                       name="pg_university"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="pg_university">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Result</b></label>
                                                                                                <input type="text"
                                                                                                       name="pg_result"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="pg_result">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Subject</b></label>
                                                                                                <input type="text"
                                                                                                       name="pg_subject"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="pg_subject">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin: 0;">
                                                                                                <label for="quant"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Passing
                                                                                                        Year</b></label>
                                                                                                <div class="col-md-12 col-sm-8">
                                                                                                    <div class="form-group">
                                                                                                        <div class="input-group date"
                                                                                                             id="pg_year">
                                                                                                            <input id="pg_passing_year"
                                                                                                                   name="pg_passing_year"
                                                                                                                   type="text"
                                                                                                                   class="form-control"
                                                                                                                   style="height: 26px; background-color: white"
                                                                                                                   readonly>
                                                                                                            <span class="input-group-addon"
                                                                                                                  style="font-size: 11px;">
                                                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                                                                </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </fieldset>

                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">OTHERS</legend>

                                                    <form action="" class="form-horizontal" role="form">
                                                        <div class="row">
                                                            <div class="panel-body"
                                                                 style="padding-bottom: 10px; padding-top: 0;">
                                                                <div class="form-horizontal">
                                                                    <div class="col-md-12 col-sm-12" style="padding: 0">
                                                                        <div class="col-md-12">
                                                                            <form action="" class="form-horizontal"
                                                                                  role="form">
                                                                                <div class="row">
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>University/Institution</b></label>
                                                                                                <input type="text"
                                                                                                       name="o_university"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="o_university">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Result</b></label>
                                                                                                <input type="text"
                                                                                                       name="o_result"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="o_result">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="others_subject"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Subject</b></label>
                                                                                                <input type="text"
                                                                                                       name="o_subject"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="o_subject">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin: 0;">
                                                                                                <label for="quant"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Passing
                                                                                                        Year</b></label>
                                                                                                <div class="col-md-12 col-sm-8">
                                                                                                    <div class="form-group">
                                                                                                        <div class="input-group date"
                                                                                                             id="o_year">
                                                                                                            <input id="o_passing_year"
                                                                                                                   name="o_passing_year"
                                                                                                                   type="text"
                                                                                                                   class="form-control"
                                                                                                                   style="height: 26px; background-color: white"
                                                                                                                   readonly>
                                                                                                            <span class="input-group-addon"
                                                                                                                  style="font-size: 11px;">
                                                                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                                                                </span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="email_address"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Email
                                                                                                        Address</b></label>
                                                                                                <input type="text"
                                                                                                       name="email_address"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="email_address">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="contact_no"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Contact
                                                                                                        No</b></label>
                                                                                                <input type="number"
                                                                                                       name="contact_no"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="contact_no"
                                                                                                       autocomplete="off"
                                                                                                       required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="experience"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Experience</b></label>
                                                                                                <input type="text"
                                                                                                       name="experience"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="experience">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Recruitment
                                                                                                        ID</b></label>
                                                                                                <select name="recrutitment_id"
                                                                                                        id="recruitment_id"
                                                                                                        class="form-control input-sm"
                                                                                                        style="font-size: 10px; height: 26px; padding: 0;"
                                                                                                        required>
                                                                                                    <option value=""
                                                                                                            selected
                                                                                                            disabled>
                                                                                                        SELECT
                                                                                                    </option>
                                                                                                    @foreach($recruitment_id as $ri)
                                                                                                        <option value="{{$ri->recruitment_id}}">{{$ri->recruitment_id}}
                                                                                                            - {{$ri->dept_name}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6"
                                                                                         style="padding: 0 5px;">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12"
                                                                                                 style="margin:  0;">
                                                                                                <label for="rm_terr"
                                                                                                       class="control-label s_font"
                                                                                                       style="padding: 0;"><b>Source/References</b></label>
                                                                                                <input type="text"
                                                                                                       name="source_reference"
                                                                                                       style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                                                       class=" form-control"
                                                                                                       id="source_reference">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </fieldset>

                                                <div class="row">
                                                    <div class="col-md-12"
                                                         style="text-align: center; margin: 16px 0;">
                                                        <div class="btn-group btn-group-sm btn_form_below_save btn_form_below"
                                                             role="group" aria-label="Third group">
                                                            <button style="padding: 1px 3px; height: 25px; width: 80px;"
                                                                    type="button" class="btn"
                                                                    id="btn_save"><span
                                                                        style="padding: 0 3px;"
                                                                        class="glyphicon glyphicon-save"></span>Save
                                                            </button>
                                                        </div>
                                                        <div class="btn-group btn-group-sm btn_form_below_update btn_form_below"
                                                             role="group" aria-label="Third group">
                                                            <button style="padding: 1px 3px; height: 25px; width: 80px;"
                                                                    type="button" class="btn"
                                                                    id="btn_update"><span
                                                                        style="padding: 0 3px;"
                                                                        class="glyphicon glyphicon-edit"></span>Update
                                                            </button>
                                                        </div>
                                                        <div class="btn-group btn-group-sm btn_form_below_refresh btn_form_below"
                                                             role="group" aria-label="Third group">
                                                            <button style="padding: 1px 3px; height: 25px; width: 80px;"
                                                                    type="button" class="btn"
                                                                    id="btn_refresh"><span
                                                                        style="padding: 0 3px;"
                                                                        class="glyphicon glyphicon-refresh"></span>Refresh
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="myModalLabel"
                 data-keyboard="false" data-backdrop="static"
                 role="dialog" tabindex="-1" id="modalUploadExcel"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="bg-primary" style="padding:15px;">
                            {{--                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>--}}
                            <h5 class="modal-title">Upload Excel Data</h5>
                        </div>
                        <div class="modal-body" >
                            <div class="progress progress-striped active progress-sm" style="margin-bottom: 5px;display: none;">
                                <div style="width: 100%" aria-valuemax="100" aria-valuemin="0"
                                     aria-valuenow="45" role="progressbar"
                                     class="progress-bar progress-bar-success">
                                </div>
                            </div>
                            <div style="display: none;margin-bottom: 10px;" id="message" class="alert alert-warning">
                            </div>
                            <div class="input-group">
                                <input type="file" id="excel_file" class="form-control" aria-label="...">
                                <div class="input-group-btn">
                                    <button class="btn btn-success" id="btnUploadExcel">Upload</button>
                                </div>
                            </div>
                            <div style="margin-top: 10px;padding: 10px;border: 1px dashed #ff1f4b;">
                                <ul class="list-unstyled">
                                    <li><span class="text-danger"><b>*</b></span>
                                        Please <a href="{{url('public/sample_docs/rms_cv_sorting_excel_format.xlsx')}}" style="text-decoration: none;">
                                            <button type="button" class="btn btn-sm btn-primary custom-btn"><i class="fa fa-download"></i> Download </button>
                                        </a> and use the given excel format for uploading data and don't <span class="text-danger"><b>Rename/Delete</b></span> column from the excel.
                                    </li>
                                    <li>
                                        <span class="text-danger"><b>* NID & Recruitment ID</b></span> column can't be empty. So do check before upload.
                                    </li>
                                    <li>
                                        <span class="text-danger"><b>*</b></span> Date format must be <span class="text-danger"><b>Month(2 digit)/ Day(2 digit)/ Year(4 digit)</b></span> - eg: <span class="text-danger"><b>07/27/2021</b></span>.
                                    </li>
                                    <li>
                                        <span class="text-danger"><b>*</b></span> Total column count must be 25.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="btnClose" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            {{--                            <button type="button" class="btn btn-success">Upload Excel</button>--}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script>

        $(document).ready(function () {

            $("#btn_update").prop("disabled", true);

            $("#ssc_year").datetimepicker({
                viewMode: 'years',
                format: 'YYYY',
                ignoreReadonly: true
            });
            $("#hsc_year").datetimepicker({
                viewMode: 'years',
                format: 'YYYY',
                ignoreReadonly: true
            });
            $("#g_year").datetimepicker({
                viewMode: 'years',
                format: 'YYYY',
                ignoreReadonly: true
            });
            $("#pg_year").datetimepicker({
                viewMode: 'years',
                format: 'YYYY',
                ignoreReadonly: true
            });
            $("#o_year").datetimepicker({
                viewMode: 'years',
                format: 'YYYY',
                ignoreReadonly: true
            });
            $("#dob_year").datetimepicker({
                format: 'DD-MMM-YY',
                ignoreReadonly: true
            });

            //select 2 js
            function customMatcher(term, text) {
                term.term = term.term || '';
                if (text.text.toUpperCase().includes(term.term.toUpperCase())) {
                    return text;
                }
                return false;
            }

            $("#search_nid").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#search_plant").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#search_dept").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#search_rec").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#g_subject").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                },
                tags: true
            });

            $("#g_university").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                },
                tags: true
            });

            $("#recruitment_id").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#search_nid").on('change', function () {
                console.log($(this).val());
            });

            function isNumberKey(evt) {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode != 46 && charCode > 31
                    && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }

            $("#search_plant").on('change', function () {

                var plant_info = $("#search_plant").val();
                var plant_id = plant_info.split('|')[0];

                $.ajax({
                    type: "post",
                    url: '{{url('rms/dwcs_search_dept_info')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        plant_id: plant_id
                    },
                    success: function (response) {
                        if (response) {
                            var data_path_dept = response.dwcs_search_dept_info;

                            var option_dept = '';

                            option_dept += "<option value=''>Select</option>";

                            for (var j = 0; j < data_path_dept.length; j++) {
                                var id = data_path_dept[j]['dept_id'];
                                var name = data_path_dept[j]['dept_name'];
                                option_dept += "<option value='" + id + "'>" + name + "</option>";
                            }

                            $("#search_dept").empty().append(option_dept);

                        }
                    },
                    error: function (error) {
                    }
                })

            });

            $("#search_dept").on('change', function () {

                var dept_id = $("#search_dept").val();
                var plant_info = $("#search_plant").val();
                var plant_id = plant_info.split('|')[0];

                console.log(plant_id);
                console.log(dept_id);

                $.ajax({
                    type: "post",
                    url: '{{url('rms/dwcs_search_rec_id')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        dept_id: dept_id,
                        plant_id: plant_id
                    },
                    success: function (response) {

                        console.log(response);

                        var data_path = response.dwcs_search_rec_id;
                        var option_vacant = '';

                        option_vacant += "<option value=''>Select</option>";

                        for (var j = 0; j < data_path.length; j++) {
                            var id = data_path[j]['recruitment_id'];
                            option_vacant += "<option value='" + id + "'>" + id + "</option>";
                        }

                        $("#search_rec").empty().append(option_vacant);
                    }
                })

            });

            $("#search_rec").on('change', function () {

                $.ajax({
                    type: "post",
                    url: '{{url('rms/dwcs_search_n_id')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        recruitment_id: $("#search_rec").val()
                    },
                    success: function (response) {

                        console.log(response);

                        var data_path = response.dwcs_search_n_id;
                        var option_vacant = '';

                        option_vacant += "<option value=''>Select</option>";

                        for (var j = 0; j < data_path.length; j++) {
                            var id = data_path[j]['nid'];
                            option_vacant += "<option value='" + id + "'>" + id + "</option>";
                        }

                        $("#search_nid").empty().append(option_vacant);
                    }
                })

            });

            $("#btn_search_nid").on('click', function () {

                var nid = $("#search_nid").val();

                console.log(nid);


                $.ajax({
                    type: "post",
                    url: '{{url('rms/search_nid')}}',
                    datatype: 'json',
                    data: {
                        nid: nid,
                        _token: '{{csrf_token()}}',
                    },
                    success: function (response) {
                        console.log(response);

                        var data_path = response.search_nid[0];

                        var subject_list = response.subjects;
                        var select_option_sub = ' ';
                        select_option_sub += "<option value =''>Select</option>";
                        for (var i = 0; i < subject_list.length; i++) {
                            var subject = subject_list[i]['subject'];

                            select_option_sub += "<option value='" + subject + "'>" + subject + "</option>";

                        }

                        $("#g_subject").empty().append(select_option_sub);


                        $("#nid").val(data_path['nid']);
                        $("#candidate_name").val(data_path['candidate_name']);
                        $("#father_name").val(data_path['father_name']);
                        $("#dob").val(moment(data_path['dob']).format('DD-MMM-YY'));
                        $("#ssc_result").val(data_path['ssc_result']);
                        $("#ssc_passing_year").val(data_path['ssc_passing_year']);
                        $("#hsc_result").val(data_path['hsc_result']);
                        $("#hsc_passing_year").val(data_path['hsc_passing_year']);
                        $("#g_subject").val(data_path['g_subject']).trigger('change');
                        $("#g_result").val(data_path['g_result']);
                        $("#g_university").val(data_path['g_university']).trigger('change');
                        $("#g_passing_year").val(data_path['g_passing_year']);
                        $("#pg_subject").val(data_path['pg_subject']);
                        $("#pg_result").val(data_path['pg_result']);
                        $("#pg_university").val(data_path['pg_university']);
                        $("#pg_passing_year").val(data_path['pg_passing_year']);
                        $("#o_subject").val(data_path['o_subject']);
                        $("#o_result").val(data_path['o_result']);
                        $("#o_university").val(data_path['o_university']);
                        $("#o_passing_year").val(data_path['o_passing_year']);
                        $("#email_address").val(data_path['email_address']);
                        $("#contact_no").val(data_path['contact_no']);
                        $("#experience").val(data_path['experience']);
                        $("#recruitment_id").val(data_path['recruitment_id']).trigger('change');
                        $("#source_reference").val(data_path['source_reference']);

                        $("#btn_save").prop("disabled", true);
                        $("#btn_update").prop("disabled", false);

                    }
                });

            });

            $("#g_university").on('select2:select', function () {

                $.ajax({
                    type: "post",
                    url: '{{url('rms/get_subject')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        university_name: $("#g_university").val()
                    },
                    success: function (response) {
                        console.log(response.get_subject);
                        var subject_list = response.get_subject;
                        var select_option_sub = ' ';
                        select_option_sub += "<option value =''>Select</option>";
                        for (var i = 0; i < subject_list.length; i++) {
                            var subject = subject_list[i]['subject'];

                            select_option_sub += "<option value='" + subject + "'>" + subject + "</option>";

                        }

                        $("#g_subject").empty().append(select_option_sub);
                    }
                })

            })

            $("#btn_save").on('click', function () {
                    console.log($("#recruitment_id").val());
                    if ($("#nid").val() == "") {
                        toastr.error("NID Field is Missing");
                    } else if (parseInt($("#nid").val()).length < 10) {
                        toastr.error("Invalid NID")
                    } else if ($("#candidate_name").val() == "") {
                        toastr.error("Candidate Name is Missing");
                    } else if ($("#father_name").val() == "") {
                        toastr.error("Father's Name is Missing");
                    } else if ($("#dob").val() == "") {
                        toastr.error("Date of Birth is Missing");
                    } else if ($("#ssc_result").val() == "") {
                        toastr.error("SSC Result is Missing");
                    } else if ($("#ssc_passing_year").val() == "") {
                        toastr.error("SSC Pass Year is Missing");
                    } else if ($("#hsc_result").val() == "") {
                        toastr.error("HSC Result is Missing");
                    } else if ($("#hsc_passing_year").val() == "") {
                        toastr.error("HSC Pass Year is Missing");
                    } else if ($("#g_subject").val() == "") {
                        toastr.error("Under Grad Subject is Missing");
                    } else if ($("#g_result").val() == "") {
                        toastr.error("Under Grad Result is Missing");
                    } else if ($("#g_university").val() == "") {
                        toastr.error("Under Grade University is Missing");
                    } else if ($("#g_passing_year").val() == "") {
                        toastr.error("Under Grade Pass Year is Missing");
                    } else if ($("#contact_no").val() == "") {
                        toastr.error("Contact No is Missing");
                    } else if ($("#recruitment_id").val() == null) {
                        toastr.error("Recruitment ID is Missing");
                    } else if (parseInt($("#ssc_result").val()) > 5) {
                        console.log($("#ssc_result").val());
                        toastr.info("Invalid Result Value");
                    } else if (parseInt($("#hsc_result").val()) > 5) {
                        console.log($("#hsc_result").val());
                        toastr.info("Invalid Result Value");
                    } else if (parseInt($("#g_result").val()) > 4) {
                        console.log($("#g_result").val());
                        toastr.info("Invalid Result Value");
                    } else if ($("#pg_result").val() !== null && parseInt($("#pg_result").val()) > 4) {

                        toastr.info("Invalid Result Value");
                    } else {

                        $.ajax({
                            type: "post",
                            url: '{{url('rms/cr_save_record')}}',
                            datatype: 'json',

                            data: {
                                _token: '{{csrf_token()}}',
                                nid: $("#nid").val(),
                                candidate_name: $("#candidate_name").val().toUpperCase(),
                                father_name: $("#father_name").val().toUpperCase(),
                                birth_date: $("#dob").val(),
                                ssc_result: $("#ssc_result").val(),
                                ssc_passing_year: $("#ssc_passing_year").val(),
                                hsc_result: $("#hsc_result").val(),
                                hsc_passing_year: $("#hsc_passing_year").val(),
                                g_subject: $("#g_subject").val(),
                                g_result: $("#g_result").val(),
                                g_university: $("#g_university").val(),
                                g_passing_year: $("#g_passing_year").val(),
                                pg_subject: $("#pg_subject").val().toUpperCase(),
                                pg_result: $("#pg_result").val(),
                                pg_university: $("#pg_university").val().toUpperCase(),
                                pg_passing_year: $("#pg_passing_year").val(),
                                o_subject: $("#o_subject").val().toUpperCase(),
                                o_result: $("#o_result").val(),
                                o_university: $("#o_university").val().toUpperCase(),
                                o_passing_year: $("#o_passing_year").val(),
                                email_address: $("#email_address").val().toUpperCase(),
                                contact_no: $("#contact_no").val(),
                                experience: $("#experience").val().toUpperCase(),
                                recruitment_id: $("#recruitment_id").val(),
                                source_reference: $("#source_reference").val().toUpperCase()
                            },
                            success: function (response) {
                                // $("#nid").val('');
                                // $("#candidate_name").val('');
                                // $("#father_name").val('');
                                // $("#dob").val('');
                                // $("#ssc_result").val('');
                                // $("#ssc_passing_year").val('');
                                // $("#hsc_result").val('');
                                // $("#hsc_passing_year").val('');
                                // $("#g_subject").val('').trigger('change');
                                // $("#g_result").val('');
                                // $("#g_university").val('').trigger('change');
                                // $("#g_passing_year").val('');
                                // $("#pg_subject").val('');
                                // $("#pg_result").val('');
                                // $("#pg_university").val('');
                                // $("#pg_passing_year").val('');
                                // $("#o_subject").val('');
                                // $("#o_result").val('');
                                // $("#o_university").val('');
                                // $("#o_passing_year").val('');
                                // $("#email_address").val('');
                                // $("#contact_no").val('');
                                // $("#experience").val('');
                                // $("#recruitment_id").val('').trigger('change');
                                // $("#source_reference").val('');

                                // $("#btn_save").prop("disabled", true);

                                toastr.success("Data Has Been Saved!")
                                window.location.reload();
                            }
                        })
                    }
                }
            );

            $("#btn_update").on('click', function () {

                $.ajax({
                    type: "post",
                    url: '{{url('rms/cr_update_record')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        nid: $("#nid").val(),
                        candidate_name: $("#candidate_name").val().toUpperCase(),
                        father_name: $("#father_name").val().toUpperCase(),
                        birth_date: $("#dob").val(),
                        ssc_result: $("#ssc_result").val(),
                        ssc_passing_year: $("#ssc_passing_year").val(),
                        hsc_result: $("#hsc_result").val(),
                        hsc_passing_year: $("#hsc_passing_year").val(),
                        g_subject: $("#g_subject").val(),
                        g_result: $("#g_result").val(),
                        g_university: $("#g_university").val(),
                        g_passing_year: $("#g_passing_year").val(),
                        pg_subject: $("#pg_subject").val().toUpperCase(),
                        pg_result: $("#pg_result").val(),
                        pg_university: $("#pg_university").val().toUpperCase(),
                        pg_passing_year: $("#pg_passing_year").val(),
                        o_subject: $("#o_subject").val().toUpperCase(),
                        o_result: $("#o_result").val(),
                        o_university: $("#o_university").val().toUpperCase(),
                        o_passing_year: $("#o_passing_year").val(),
                        email_address: $("#email_address").val().toUpperCase(),
                        contact_no: $("#contact_no").val(),
                        experience: $("#experience").val().toUpperCase(),
                        recruitment_id: $("#recruitment_id").val(),
                        source_reference: $("#source_reference").val().toUpperCase()
                    },
                    success: function (response) {
                        toastr.success("Data Has Been Updated!");
                        window.location.reload();
                    }
                })

            });

            $("#btn_refresh").on('click', function () {
                window.location.reload();
            })

            //file upload
            $('#btnUploadExcel').on('click',function () {
                var file = $('#excel_file').prop('files');
                if(file.length > 0){
                    if(file[0].name.search('.xls') !== -1){
                        var data = new FormData();
                        data.append('file',file[0]);

                        if(!$('#message').is(':empty')){
                            $('#message').empty().slideUp("slow");
                        }

                        $.ajax({
                            type:'POST',
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                            },
                            data: data,
                            url: '{{url('rms/upload_bulk_data')}}',
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function (){
                                $('.progress').show();
                                $('#btnClose').attr('disabled',true);
                            },
                            success: function (response) {
                                //console.log(response);
                                if(response.type === 'error'){
                                    toastr.error(response.status);
                                }else{
                                    toastr.success(response.status);
                                    if(response.duplicate_nid.length > 0){
                                        var nids = '<span class="text-danger" style="text-decoration: underline;"><b>Duplicate NID found in excel and skipped:</b></span> <br>';
                                        $.each(response.duplicate_nid,function (i,v) {
                                            nids += '<span class="badge badge-warning">'+v+'</span> ';
                                        })
                                        $('#message').append(nids).slideDown("slow");
                                    }
                                }
                            },
                            error: function (error) {
                                console.log(error);
                                toastr.error(error.status+'|'+error.statusText);
                                $('.progress').show();
                                $('#btnClose').attr('disabled',false);
                            },
                            complete: function () {
                                $('.progress').hide();
                                $('#btnClose').attr('disabled',false);
                            }
                        });

                    }else{
                        toastr.error('File type must be excel');
                    }
                }else{
                    toastr.error('Select excel file!');
                }
                //console.log(file.length);
            });

            $('#btnClose').on('click',function () {
                $('#excel_file').val(null);
                $('#message').empty().hide();
            });

        })

    </script>

@endsection
