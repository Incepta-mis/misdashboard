@extends('_layout_shared._master')
@section('title','Recruitment Management System')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }


        body {
            color: #000;
        }

        .sample_info_panel {
            position: -webkit-sticky;
            top: 0;
        }

        body {
            counter-reset: Serial;
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

        /*increment/decrement button off*/
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
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
                                        Candidate Exam Records
                                    </label>
                                </header>
                                <div class="panel-body" style="padding-bottom: 10px;">
                                    <div class="form-horizontal">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-12">
                                                <form action="" class="form-horizontal" role="form">
                                                    <div class="row">
                                                        <div class="col-md-12"
                                                             style="padding: 0 5px; margin: 0 0 20px 0;">
                                                            <div class="col-md-3"
                                                                 style="padding: 0 ">
                                                                <div class="form-group">
                                                                    <div class="col-md-12"
                                                                         style="margin:  0;">
                                                                        <label for="rm_terr"
                                                                               class="control-label s_font"
                                                                               style="padding: 0;"><b>Plant
                                                                                Name</b></label>
                                                                        <select name="search_plant"
                                                                                id="search_plant"
                                                                                class="form-control input-sm"
                                                                                style="font-size: 10px; height: 26px; padding: 0;"
                                                                        >
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
                                                                 style="padding: 0">
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
                                                                        >
                                                                            <option value=""
                                                                                    selected
                                                                                    disabled>
                                                                                SELECT
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="padding: 0;">
                                                                <label for="search_recruitment_id"
                                                                       class="control-label s_font" style="padding: 0;">
                                                                    Recruitment Id
                                                                </label>
                                                                <select name="search_recruitment_id"
                                                                        id="search_recruitment_id"
                                                                        class="form-control input-sm"
                                                                        style="font-size: 10px; height: 28px; padding: 0;">
                                                                    <option value="" selected disabled>Recruitment
                                                                        ID
                                                                    </option>
{{--                                                                    @foreach($search_recruitment as $sr)--}}
{{--                                                                        <option value="{{$sr->recruitment_id}}">{{$sr->recruitment_id}}</option>--}}
{{--                                                                    @endforeach--}}
                                                                </select>
                                                            </div>
                                                            &nbsp;
                                                            <div class="col-md-2" style="padding: 0;">
                                                                <label for="search_recruitment_id"
                                                                       class="control-label s_font" style="padding: 0;">
                                                                    NID
                                                                </label>
                                                                <select name="search_nid"
                                                                        id="search_nid"
                                                                        class="form-control input-sm"
                                                                        style="font-size: 10px; height: 28px; padding: 0;">
                                                                    <option value="" selected disabled>NID
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">

                                                                <button class="btn btn-primary" id="btn_search_nid"
                                                                        name="btn_search_nid" type="button"
                                                                        style="height: 28px; padding: 0 8px; border-bottom-right-radius: 3px; border-top-right-radius: 3px;">
                                                                    <i class="fa fa-search"></i> Search
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr style="margin: 8px">
                                                    <div class="row">
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Recruitment
                                                                            ID</b></label>
                                                                    <select name="recruitment_id" id="recruitment_id"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                        @foreach($search_recruitment as $sr)
                                                                            <option value="{{$sr->recruitment_id}}">{{$sr->recruitment_id}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>NID</b></label>
                                                                    <select name="nid"
                                                                            id="nid"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 28px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                    </select>
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
                                                                           id="candidate_name" disabled>
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
                                                                           id="father_name" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Date of
                                                                            Birth</b></label>
                                                                    <input type="text"
                                                                           name="dob"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="dob" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>SSC Point</b></label>
                                                                    <input type="text"
                                                                           name="ssc_point"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="ssc_point" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>HSC Point</b></label>
                                                                    <input type="text"
                                                                           name="hsc_point"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="hsc_point" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>University
                                                                            Point</b></label>
                                                                    <input type="text"
                                                                           name="university_point"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="university_point" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Written Exam Marks</b></label>
                                                                    <input type="number"
                                                                           name="written_exam_marks"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="written_exam_marks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Total Exam
                                                                            Marks</b></label>
                                                                    <input type="number"
                                                                           name="total_exam_marks"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="total_exam_marks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Written Exam Point</b></label>
                                                                    <input type="text"
                                                                           name="written_exam_point"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="written_exam_point" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Written Exam Date</b></label>
                                                                    <div class="col-md-12 col-sm-8">
                                                                        <div class="form-group">
                                                                            <div class="input-group date"
                                                                                 id="written_exam_date1">
                                                                                <input id="written_exam_date"
                                                                                       name="written_exam_date"
                                                                                       type="text"
                                                                                       class="form-control input-sm"
                                                                                       style="height: 26px; background-color: white"
                                                                                       autocomplete="off" readonly>
                                                                                <span class="input-group-addon"
                                                                                      style="font-size: 11px">
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
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>First Interview
                                                                            Marks</b></label>
                                                                    <input type="number"
                                                                           name="first_interview_marks"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="first_interview_marks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>First Interview Total
                                                                            Marks</b></label>
                                                                    <input type="number"
                                                                           name="first_interview_total_marks"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="first_interview_total_marks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>First Interview
                                                                            Points</b></label>
                                                                    <input type="text"
                                                                           name="first_interview_points"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="first_interview_points" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>First Interview
                                                                            Date</b></label>
                                                                    <div class="col-md-12 col-sm-8">
                                                                        <div class="form-group">
                                                                            <div class="input-group date"
                                                                                 id="first_interview_date1">
                                                                                <input id="first_interview_date"
                                                                                       name="first_interview_date"
                                                                                       type="text"
                                                                                       class="form-control input-sm"
                                                                                       style="height: 26px; background-color: white"
                                                                                       autocomplete="off" readonly>
                                                                                <span class="input-group-addon"
                                                                                      style="font-size: 11px">
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
                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>First Interview Panel
                                                                            Member</b></label>
                                                                    <input type="text"
                                                                           name="first_interview_panel_member"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="first_interview_panel_member">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Final Interview
                                                                            Marks</b></label>
                                                                    <input type="number"
                                                                           name="final_interview_marks"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="final_interview_marks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Final Interview Total
                                                                            Marks</b></label>
                                                                    <input type="number"
                                                                           name="final_interview_total_marks"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="final_interview_total_marks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Final Interview
                                                                            Points</b></label>
                                                                    <input type="text"
                                                                           name="final_interview_points"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="final_interview_points" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Final Interview
                                                                            Date</b></label>
                                                                    <div class="col-md-12 col-sm-8">
                                                                        <div class="form-group">
                                                                            <div class="input-group date"
                                                                                 id="final_interview_date1">
                                                                                <input id="final_interview_date"
                                                                                       name="final_interview_date"
                                                                                       type="text"
                                                                                       class="form-control input-sm"
                                                                                       style="height: 26px; background-color: white"
                                                                                       autocomplete="off" readonly>
                                                                                <span class="input-group-addon"
                                                                                      style="font-size: 11px">
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
                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Final Interview Panel
                                                                            Member</b></label>
                                                                    <input type="text"
                                                                           name="final_interview_panel_member"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="final_interview_panel_member">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Total
                                                                            Point</b></label>
                                                                    <input type="text"
                                                                           name="total_point"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="total_point" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Salary as per "Salary
                                                                            Matrix"</b></label>
                                                                    <input type="text"
                                                                           name="salary_per_matrix"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="salary_per_matrix" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Notes</b></label>
                                                                    <input type="text"
                                                                           name="notes"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="notes">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Remarks</b></label>
                                                                    <input type="text"
                                                                           name="remarks"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off"
                                                                           id="remarks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
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

            $("#btn_update").prop('disabled', true);

            function total_point() {

                var total_point = parseFloat($("#ssc_point").val())
                    + parseFloat($("#hsc_point").val() ? $("#hsc_point").val() : 0)
                    + parseFloat($("#university_point").val() ? $("#university_point").val() : 0)
                    + parseFloat($("#written_exam_point").val() ? $("#written_exam_point").val() : 0)
                    + parseFloat($("#first_interview_points").val() ? $("#first_interview_points").val() : 0)
                    + parseFloat($("#final_interview_points").val() ? $("#final_interview_points").val() : 0);

                // if (total_point > 59) {

                var nid = $("#nid").val();
                var tot_point = total_point.toFixed(2);

                // console.log(tot_point);

                $.ajax({
                    type: "post",
                    url: '{{url('rms/salary_matrix')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        total_point: parseInt(tot_point),
                        nid: nid
                    },
                    success: function (response) {

                        // console.log("response");
                        // console.log(response.salary_matrix[0]['salary']);
                        $("#salary_per_matrix").val(response.salary_matrix[0]['salary']);
                    }
                });

                // }

                $("#total_point").empty().val(total_point.toFixed(2));
            }

            function customMatcher(term, text) {
                term.term = term.term || '';
                if (text.text.toUpperCase().includes(term.term.toUpperCase())) {
                    return text;
                }
                return false;
            }

            $("#search_recruitment_id").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

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

            $("#nid").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#recruitment_id").select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#written_exam_date1").datetimepicker({
                format: 'DD-MMM-YY',
                ignoreReadonly: true
            });

            $("#first_interview_date1").datetimepicker({
                format: 'DD-MMM-YY',
                ignoreReadonly: true
            });

            $("#final_interview_date1").datetimepicker({
                format: 'DD-MMM-YY',
                ignoreReadonly: true
            });

            $(document).on('keypress', '#written_exam_marks', function (event) {

                if (event.keyCode === 13) {

                    var obtain_mark = $("#written_exam_marks").val();
                    var total_mark = $("#total_exam_marks").val();

                    // console.log(obtain_mark);
                    // console.log(total_mark);

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/written_exam_points')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            obtain_mark: obtain_mark,
                            total_mark: total_mark
                        },
                        success: function (response) {
                            // console.log(response.written_exam_points[0]['written_exam_point']);
                            var written_exam_point = response.written_exam_points[0]['written_exam_point']
                            $("#written_exam_point").empty().val(written_exam_point);

                            total_point();
                        }
                    });


                }

            });

            $(document).on('keypress', '#total_exam_marks', function (event) {

                if (event.keyCode === 13) {

                    var obtain_mark = $("#written_exam_marks").val();
                    var total_mark = $("#total_exam_marks").val();

                    // console.log(obtain_mark);
                    // console.log(total_mark);

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/written_exam_points')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            obtain_mark: obtain_mark,
                            total_mark: total_mark
                        },
                        success: function (response) {
                            // console.log(response.written_exam_points[0]['written_exam_point']);
                            var written_exam_point = response.written_exam_points[0]['written_exam_point']
                            $("#written_exam_point").empty().val(written_exam_point);
                            total_point();
                        }
                    });
                }

            });

            $(document).on('keypress', '#first_interview_marks', function (event) {

                if (event.keyCode === 13) {
                    var obtain_marks = $("#first_interview_marks").val();
                    var total_marks = $("#first_interview_total_marks").val();

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/first_interview_point')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            i_mark_obtain: obtain_marks,
                            i_total_mark: total_marks
                        },
                        success: function (response) {

                            var first_interview_point = response.first_interview_point[0]['first_interview_point']
                            $("#first_interview_points").empty().val(first_interview_point);

                            total_point();

                        }
                    })
                }

            });

            $(document).on('keypress', '#first_interview_total_marks', function (event) {

                if (event.keyCode === 13) {

                    var obtain_marks = $("#first_interview_marks").val();
                    var total_marks = $("#first_interview_total_marks").val();

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/first_interview_point')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            i_mark_obtain: obtain_marks,
                            i_total_mark: total_marks
                        },
                        success: function (response) {

                            var first_interview_point = response.first_interview_point[0]['first_interview_point']
                            $("#first_interview_points").empty().val(first_interview_point);

                            total_point();

                        }
                    })

                }

            });

            $(document).on('keypress', '#final_interview_marks', function (event) {

                if (event.keyCode === 13) {

                    var obtain_marks = $("#final_interview_marks").val();
                    var total_marks = $("#final_interview_total_marks").val();

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/final_interview_points')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            f_mark_obtain: obtain_marks,
                            f_mark_total: total_marks
                        },
                        success: function (response) {

                            var final_interview_point = response.final_interview_point[0]['final_interview_point'];

                            $("#final_interview_points").empty().val(final_interview_point);

                            total_point();

                        }
                    })

                }

            });

            $(document).on('keypress', '#final_interview_total_marks', function (event) {

                if (event.keyCode === 13) {

                    var obtain_marks = $("#final_interview_marks").val();
                    var total_marks = $("#final_interview_total_marks").val();

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/final_interview_points')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            f_mark_obtain: obtain_marks,
                            f_mark_total: total_marks
                        },
                        success: function (response) {

                            var final_interview_point = response.final_interview_point[0]['final_interview_point'];

                            $("#final_interview_points").empty().val(final_interview_point);

                            total_point();

                        }
                    })

                }

            });

            $("#search_recruitment_id").on('change', function () {
                // console.log($(this).val());
                var rec_id = $(this).val();

                $.ajax({
                    type: "post",
                    url: '{{url('rms/cer_search_nid')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        rec_id: rec_id,
                        type: 'srid'
                    },
                    success: function (response) {
                        // console.log(response.search_nid);
                        var nidList = response.search_nid;

                        var select_option_nid = '';
                        select_option_nid += "<option value =''>Select</option>";
                        for (var i = 0; i < nidList.length; i++) {
                            var n_id = nidList[i]['nid'];
                            // console.log(n_id);
                            select_option_nid += "<option value='" + n_id + "'>" + n_id + "</option>";
                            // console.log("nid");
                            // console.log(nid);
                        }

                        $("#search_nid").empty().append(select_option_nid);
                    }
                })
            });

            $("#btn_save").on('click', function () {

                var nid = $("#nid").val();
                var recruitment_id = $("#recruitment_id").val();
                var candidate_name = $("#candidate_name").val();
                var father_name = $("#father_name").val();
                var dob = $("#dob").val();
                var ssc_point = $("#ssc_point").val();
                var hsc_point = $("#hsc_point").val();
                var university_point = $("#university_point").val();
                var written_exam_marks = $("#written_exam_marks").val();
                var total_exam_marks = $("#total_exam_marks").val();
                var written_exam_point = $("#written_exam_point").val();
                var written_exam_date = $("#written_exam_date").val();
                var interview_marks = $("#first_interview_marks").val();
                var interview_tot_marks = $("#first_interview_total_marks").val();
                var interview_point = $("#first_interview_points").val();
                var interview_date = $("#first_interview_date").val();
                var interview_pm = $("#first_interview_panel_member").val();
                var f_interview_marks = $("#final_interview_marks").val();
                var f_interview_tot_marks = $("#final_interview_total_marks").val();
                var f_interview_point = $("#final_interview_points").val();
                var f_interview_date = $("#final_interview_date").val();
                var f_interview_pm = $("#final_interview_panel_member").val();
                var total_point = $("#total_point").val();
                var salary = $("#salary_per_matrix").val();
                var notes = $("#notes").val();
                var remarks = $("#remarks").val();

                $.ajax({
                    type: "post",
                    url: '{{url('rms/cer_save_record')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        nid: nid,
                        recruitment_id: recruitment_id,
                        candidate_name: candidate_name,
                        father_name: father_name,
                        dob: dob,
                        ssc_point: ssc_point,
                        hsc_point: hsc_point,
                        university_point: university_point,
                        written_exam_marks: written_exam_marks,
                        total_exam_marks: total_exam_marks,
                        written_exam_point: written_exam_point,
                        written_exam_date: written_exam_date,
                        interview_marks: interview_marks,
                        interview_tot_marks: interview_tot_marks,
                        interview_point: interview_point,
                        interview_date: interview_date,
                        interview_pm: interview_pm,
                        f_interview_marks: f_interview_marks,
                        f_interview_tot_marks: f_interview_tot_marks,
                        f_interview_point: f_interview_point,
                        f_interview_date: f_interview_date,
                        f_interview_pm: f_interview_pm,
                        total_point: total_point,
                        salary: salary,
                        notes: notes,
                        remarks: remarks
                    },
                    success: function (response) {
                        console.log(response);
                        toastr.success("Record Has Been Saved Successfully.")
                        window.location.reload();
                    }
                });
            });

            $("#btn_refresh").on('click', function () {
                window.location.reload();
            });

            $("#btn_update").on('click', function () {

                var nid = $("#nid").val();
                var recruitment_id = $("#recruitment_id").val();
                var candidate_name = $("#candidate_name").val();
                var father_name = $("#father_name").val();
                var dob = $("#dob").val();
                var ssc_point = $("#ssc_point").val();
                var hsc_point = $("#hsc_point").val();
                var university_point = $("#university_point").val();
                var written_exam_marks = $("#written_exam_marks").val();
                var total_exam_marks = $("#total_exam_marks").val();
                var written_exam_point = $("#written_exam_point").val();
                var written_exam_date = $("#written_exam_date").val();
                var interview_marks = $("#first_interview_marks").val();
                var interview_tot_marks = $("#first_interview_total_marks").val();
                var interview_point = $("#first_interview_points").val();
                var interview_date = $("#first_interview_date").val();
                var interview_pm = $("#first_interview_panel_member").val();
                var f_interview_marks = $("#final_interview_marks").val();
                var f_interview_tot_marks = $("#final_interview_total_marks").val();
                var f_interview_point = $("#final_interview_points").val();
                var f_interview_date = $("#final_interview_date").val();
                var f_interview_pm = $("#final_interview_panel_member").val();
                var total_point = $("#total_point").val();
                var salary = $("#salary_per_matrix").val();
                var notes = $("#notes").val();
                var remarks = $("#remarks").val();

                $.ajax({
                    type: "post",
                    url: '{{url('rms/cer_update_record')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        nid: nid,
                        recruitment_id: recruitment_id,
                        candidate_name: candidate_name,
                        father_name: father_name,
                        dob: dob,
                        ssc_point: ssc_point,
                        hsc_point: hsc_point,
                        university_point: university_point,
                        written_exam_marks: written_exam_marks,
                        total_exam_marks: total_exam_marks,
                        written_exam_point: written_exam_point,
                        written_exam_date: written_exam_date,
                        interview_marks: interview_marks,
                        interview_tot_marks: interview_tot_marks,
                        interview_point: interview_point,
                        interview_date: interview_date,
                        interview_pm: interview_pm,
                        f_interview_marks: f_interview_marks,
                        f_interview_tot_marks: f_interview_tot_marks,
                        f_interview_point: f_interview_point,
                        f_interview_date: f_interview_date,
                        f_interview_pm: f_interview_pm,
                        total_point: total_point,
                        salary: salary,
                        notes: notes,
                        remarks: remarks
                    },
                    success: function (response) {
                        console.log(response);
                        toastr.success("Record Has Been Updated Successfully.")
                        window.location.reload();
                    }
                });

            });

            $("#btn_search_nid").on('click', function () {
                var recruitment_id = $("#search_recruitment_id").val();
                var nid = $("#search_nid").val();
                // console.log(recruitment_id);
                // console.log(nid);

                $("#btn_save").prop('disabled', true);
                $("#btn_update").prop('disabled', false);

                $.ajax({
                    type: "post",
                    url: '{{url('rms/update_search_result')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        recruitment_id: recruitment_id,
                        nid: nid
                    },
                    success: function (response) {

                        var data_path = response.update_search_result[0];

                        console.log(moment(data_path['written_exam_date']).format('DD-MMM-YY'));

                        var req_list = response.nid_list;
                        var selectOptNid = '';
                        selectOptNid += "<option value='' selected disabled>SELECT</option>";
                        for (var i = 0; i < req_list.length; i++) {
                            // console.log(deptList[i]['dept_id']);
                            var id = req_list[i]['nid'];
                            selectOptNid += "<option value='" + id + "'>" + id + "</option>"
                        }
                        // console.log(selectOptNid);
                        $('#nid').empty().append(selectOptNid);
                        $("#nid").val(data_path['nid']).trigger('change');


                        $("#recruitment_id").val(data_path['recruitment_id']).trigger('change');
                        $("#candidate_name").val(data_path['candidate_name']);
                        $("#father_name").val(data_path['father_name']);
                        $("#dob").val(moment(data_path['dob']).format('DD-MMM-YY'));
                        $("#ssc_point").val(data_path['ssc_point']);
                        $("#hsc_point").val(data_path['hsc_point']);
                        $("#university_point").val(data_path['university_point']);
                        $("#written_exam_marks").val(data_path['written_exam_marks']);
                        $("#total_exam_marks").val(data_path['total_exam_marks']);
                        $("#written_exam_point").val(data_path['written_exam_point']);
                        $("#written_exam_date").val(moment(data_path['written_exam_date']).format('DD-MMM-YY'));
                        $("#first_interview_marks").val(data_path['interview_marks']);
                        $("#first_interview_total_marks").val(data_path['interview_tot_marks']);
                        $("#first_interview_points").val(data_path['interview_point']);
                        $("#first_interview_date").val(moment(data_path['interview_date']).format('DD-MMM-YY'));
                        $("#first_interview_panel_member").val(data_path['interview_pm']);
                        $("#final_interview_marks").val(data_path['f_interview_marks']);
                        $("#final_interview_total_marks").val(data_path['f_interview_tot_marks']);
                        $("#final_interview_points").val(data_path['f_interview_point']);
                        $("#final_interview_date").val(moment(data_path['f_interview_date']).format('DD-MMM-YY'));
                        $("#final_interview_panel_member").val(data_path['f_interview_pm']);
                        $("#total_point").val(data_path['total_point']);
                        $("#salary_per_matrix").val(data_path['salary']);
                        $("#notes").val(data_path['notes']);
                        $("#remarks").val(data_path['remarks']);
                    }
                })
            })
        });

        $("#search_plant").on('select2:select', function () {

            var plant_info = $("#search_plant").val();
            var plant_id = plant_info.split('|')[0];

            $.ajax({
                type: "post",
                url: '{{url('rms/cer_search_dept_info')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    plant_id: plant_id
                },
                success: function (response) {
                    if (response) {
                        var data_path_dept = response.cer_search_dept_info;

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

        $("#search_dept").on('select2:select', function () {

            var dept_id = $("#search_dept").val();
            var plant_info = $("#search_plant").val();
            var plant_id = plant_info.split('|')[0];

            console.log(plant_id);
            console.log(dept_id);

            $.ajax({
                type: "post",
                url: '{{url('rms/cer_search_rec_id')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    dept_id: dept_id,
                    plant_id: plant_id
                },
                success: function (response) {

                    console.log(response);

                    var data_path = response.cer_search_rec_id;
                    var option_vacant = '';

                    option_vacant += "<option value=''>Select</option>";

                    for (var j = 0; j < data_path.length; j++) {
                        var id = data_path[j]['recruitment_id'];
                        option_vacant += "<option value='" + id + "'>" + id + "</option>";
                    }

                    $("#search_recruitment_id").empty().append(option_vacant);
                }
            })

        });


        $('#recruitment_id').on('select2:select', function (e) {

            var rec_id = $(this).val();

            $.ajax({
                type: "post",
                url: '{{url('rms/cer_search_nid')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    rec_id: rec_id,
                },
                success: function (response) {
                    // console.log(response.search_nid);
                    var nidList = response.search_nid;

                    var select_option_nid = '';
                    select_option_nid += "<option value =''>Select</option>";
                    for (var i = 0; i < nidList.length; i++) {
                        var n_id = nidList[i]['nid'];
                        // console.log(n_id);
                        select_option_nid += "<option value='" + n_id + "'>" + n_id + "</option>";
                        // console.log("nid");
                        // console.log(nid);
                    }

                    $("#nid").empty().append(select_option_nid);
                    // $("#nid").val(data_path['recruitment_id']).trigger('change');

                }
            })

        });

        $('#nid').on('select2:select', function (e) {

            var recruitment_id = $("#recruitment_id").val();
            var nid = $("#nid").val();

            // console.log(recruitment_id);

            $.ajax({
                type: "post",
                url: '{{url('rms/search_result')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    recruitment_id: recruitment_id,
                    nid: nid,

                },
                success: function (response) {

                    var data_path = response.search_result[0];

                    // console.log(response);
                    console.log(response.exam_point[0]);

                    var req_list = response.search_recruitment;
                    var selectOptDept = '';
                    selectOptDept += "<option value='' selected disabled>SELECT</option>";
                    for (var i = 0; i < req_list.length; i++) {
                        // console.log(deptList[i]['dept_id']);
                        var id = req_list[i]['recruitment_id'];
                        selectOptDept += "<option value='" + id + "'>" + id + "</option>"
                    }

                    // console.log(response.ssc_exam_point[0]['ssc_exam_point']);

                    $('#recruitment_id').empty().append(selectOptDept);

                    $("#recruitment_id").val(data_path['recruitment_id']).trigger('change');
                    $("#nid").val(data_path['nid']);
                    $("#candidate_name").val(data_path['candidate_name']);
                    $("#father_name").val(data_path['father_name']);
                    $("#dob").val(moment(data_path['dob']).format('DD-MMM-YY'));
                    $("#ssc_point").val(response.exam_point[0]['ssc_point']);
                    $("#hsc_point").val(response.exam_point[0]['hsc_point']);
                    $("#university_point").val(response.exam_point[0]['university_point']);
                    $("#written_exam_marks").val(data_path['written_exam_marks']);
                    $("#total_exam_marks").val(data_path['total_exam_marks']);
                    $("#written_exam_point").val(data_path['written_exam_point']);
                    $("#written_exam_date").val(data_path['written_exam_date'] ? moment(data_path['written_exam_date']).format('DD-MMM-YY') : '');
                    $("#first_interview_marks").val(data_path['interview_marks']);
                    $("#first_interview_total_marks").val(data_path['interview_tot_marks']);
                    $("#first_interview_points").val(data_path['interview_point']);
                    $("#first_interview_date").val(data_path['interview_date'] ? moment(data_path['interview_date']).format('DD-MMM-YY') : '');
                    $("#first_interview_panel_member").val(data_path['interview_pm']);
                    $("#final_interview_marks").val(data_path['f_interview_marks']);
                    $("#final_interview_total_marks").val(data_path['f_interview_tot_marks']);
                    $("#final_interview_points").val(data_path['f_interview_point']);
                    $("#final_interview_date").val(data_path['f_interview_date'] ? moment(data_path['f_interview_date']).format('DD-MMM-YY') : '');
                    $("#final_interview_panel_member").val(data_path['f_interview_pm']);
                    $("#total_point").val(data_path['total_point']);
                    $("#salary_per_matrix").val(data_path['salary']);
                    $("#notes").val(data_path['notes']);
                    $("#remarks").val(data_path['remarks']);
                }
            })

        });


    </script>

@endsection
