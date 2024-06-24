@extends('_layout_shared._master')
@section('title','Candidate Status For Appoinment')
@section('styles')


    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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
            color: #000;
        }

        .sample_info_panel {
            position: -webkit-sticky;
            top: 0;
        }

        body {
            counter-reset: Serial;
        }

        table {
            border-collapse: collapse;
        }


        /*table tbody tr td:nth-child(2):before {*/
        /*    counter-increment: Serial;*/
        /*    content: "" counter(Serial);*/
        /*}*/

        .s_font {
            font-size: 11px;
            padding: 7px 0;
        }

        .form-group {
            margin-bottom: 0;
        }

        /*input[list] {*/
        /*    color: black;*/
        /*    background-color: white;*/
        /*}*/

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

        .dataTables_filter, .dataTables_paginate  {
            display: none;
        }
        .dataTables_length  {
            position: absolute;
            right: 100px;
            padding: 10px;
        }
        .dataTables_info{
            position: absolute;
            right: 0px;
            width:100px;
        }
        
        span.select2 {
            display         : table;
            table-layout    : fixed;
            width           : 100% !important;
        }

    </style>
@endsection

@section('right-content')

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-turquoise-bg">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#add2" class="t1" data-toggle="tab">Add</a>
                        </li>
                        <li class="">
                            <a href="#update2" class="t2" data-toggle="tab">Update</a>
                        </li>

                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="add2">
                            <div class="row">
                                <div class="wrapper_div">
                                    <div class="col-md-12 col-sm-12 sticky-top">
                                        <section class="sample_info_panel" id="data_table">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 sticky-top">
                                                    <section class="panel sample_info_panel" id="data_table">
                                                        <header class="panel-heading">
                                                            <label class="text-primary">
                                                                Candidate Status For Appoinment
                                                            </label>
                                                        </header>
                                                        <div class="panel-body" style="padding-bottom: 10px;">
                                                            <div class="form-horizontal">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <div class="col-md-12">
                                                                        {{-- <form action="" class="form-horizontal" role="form"> --}}
                                                                            <div class="row">
                                                                                <div class="col-md-4" style="padding: 0 5px;">
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-12" style="margin: 0; padding: 0 12px">
                                                                                            <label for="rm_terr"
                                                                                                class="control-label s_font"
                                                                                                style="padding: 0;"><b>Plant
                                                                                                    Name</b></label>
                                                                                            <select name="search_plant_name" id="search_plant_name"
                                                                                                    class="form-control input-sm search_plant_name"
                                                                                                    style="font-size: 10px; height: 26px; padding: 0;">
                                                                                                <option value="" selected disabled>SELECT
                                                                                                </option>
                                                                                                @foreach($plant_name as $pi)
                                                                                                    <option value="{{$pi->plant_id}}|{{$pi->plant_name}}">{{$pi->plant_name}}
                                                                                                        | {{$pi->plant_id}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4" style="padding: 0 5px;">
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-12" style="margin:  0;">
                                                                                            <label for="rm_terr"
                                                                                                class="control-label s_font"
                                                                                                style="padding: 0;"><b>Department
                                                                                                    Name</b></label>
                                                                                            <select name="search_department_name" id="search_department_name"
                                                                                                    class="form-control input-sm search_department_name"
                                                                                                    style="font-size: 10px; height: 26px; padding: 0;">
                                                                                                <option value="" selected disabled>SELECT
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4" style="padding: 0 5px">
                                                                                    <div class="col-md-9" style="padding: 0">
                                                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-12" style="margin:  0;">
                                                                                                    <label for="search_recruitment"
                                                                                                        class="control-label s_font"
                                                                                                        style="padding: 0;"><b>Recruitment
                                                                                                            ID</b></label>
                                                                                                    <select name="search_recruitment" id="search_recruitment"
                                                                                                            class="form-control input-sm search_recruitment"
                                                                                                            style="font-size: 10px; height: 26px; padding: 0 11px;">
                                                                                                        <option value="" selected disabled>SELECT
                                                                                                        </option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>                                                                
                                                                                    </div>
                                                                                    <div class="col-md-3" style="margin-top: 20px; padding: 0 9px">
                                                                                        <div class="input-group input-group-sm col-md-2">
                                                                                                        <span class="input-group-btn">
                                                                                                            <button class="btn btn-primary btn-get-insert"
                                                                                                                    id="btn_req_id"
                                                                                                                    name="btn_req_id" type="button"
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
                                                                
                                                                        {{-- </form> --}}
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
                        </div>
                        <div class="tab-pane" id="update2">
                            <div class="row">
                                <div class="wrapper_div">
                                    <div class="col-md-12 col-sm-12 sticky-top">
                                        <section class="sample_info_panel" id="data_table">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 sticky-top">
                                                    <section class="panel sample_info_panel" id="data_table">
                                                        <header class="panel-heading">
                                                            <label class="text-primary">
                                                                Candidate Status For Appoinment
                                                            </label>
                                                        </header>
                                                        <div class="panel-body" style="padding-bottom: 10px;">
                                                            <div class="form-horizontal">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <div class="col-md-12">
                                                                        {{-- <form action="" class="form-horizontal" role="form"> --}}
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-4" style="padding: 0 5px;">
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-12" style="margin: 0; padding: 0 12px">
                                                                                            <label for="search_plant_name1"
                                                                                                class="control-label s_font"
                                                                                                style="padding: 0;"><b>Plant
                                                                                                    Name</b></label>
                                                                                            <select name="search_plant_name1" id="search_plant_name1"
                                                                                                    class="form-control input-sm search_plant_name1"
                                                                                                    style="font-size: 10px; height: 26px; padding: 0;">
                                                                                                <option value="" selected disabled>SELECT
                                                                                                </option>
                                                                                                @foreach($plant_name as $pi)
                                                                                                    <option value="{{$pi->plant_id}}|{{$pi->plant_name}}">{{$pi->plant_name}}
                                                                                                        | {{$pi->plant_id}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4" style="padding: 0 5px;">
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-12" style="margin:  0;">
                                                                                            <label for="search_department_name1"
                                                                                                class="control-label s_font"
                                                                                                style="padding: 0;"><b>Department
                                                                                                    Name</b></label>
                                                                                            <select name="search_department_name1" id="search_department_name1"
                                                                                                    class="form-control input-sm search_department_name1"
                                                                                                    style="font-size: 10px; height: 26px; padding: 0;">
                                                                                                <option value="" selected disabled>SELECT
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4" style="padding: 0 5px">
                                                                                    <div class="col-md-12" style="padding: 0">
                                                                                        <div class="col-md-12" style="padding: 0 5px;">
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-12" style="margin:  0;">
                                                                                                    <label for="search_recruitment1"
                                                                                                        class="control-label s_font"
                                                                                                        style="padding: 0;"><b>Recruitment
                                                                                                            ID</b></label>
                                                                                                    <select name="search_recruitment1" id="search_recruitment1"
                                                                                                            class="form-control input-sm search_recruitment1"
                                                                                                            style="font-size: 10px; height: 26px; padding: 0 11px;">
                                                                                                        <option value="" selected disabled>SELECT
                                                                                                        </option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>                                                                
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                        
                                                                            <div class="row">
                                                                                <div class="col-md-4" style="padding: 0 5px;">
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-12" style="margin:  0;">
                                                                                            <label for="source_reference1"
                                                                                                class="control-label s_font"
                                                                                                style="padding: 0;"><b>Reference</b></label>
                                                                                            <select name="source_reference1" id="source_reference1"
                                                                                                    class="form-control input-sm source_reference1"
                                                                                                    style="font-size: 10px; height: 26px; padding: 0;">
                                                                                                <option value="" selected disabled>SELECT</option>
                                                                                                {{-- @foreach($plant_info as $pi)
                                                                                                    <option value="{{$pi->plant_id}}|{{$pi->plant_name}}">{{$pi->plant_name}}
                                                                                                        | {{$pi->plant_id}}</option>
                                                                                                @endforeach --}}
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4" style="padding: 0 5px;">
                                                                                    <div class="form-group">
                                                                                        <div class="col-md-12" style="margin:  0;">
                                                                                            <label for="nid"
                                                                                                class="control-label s_font"
                                                                                                style="padding: 0;"><b>NID</b></label>
                                                                                            <select name="nid" id="nid"
                                                                                                    class="form-control input-sm nid"
                                                                                                    style="font-size: 10px; height: 26px; padding: 0;">
                                                                                                <option value="" selected disabled>SELECT</option>
                        
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3" style="margin-top: 20px; padding: 0 9px">
                                                                                    <div class="input-group input-group-sm col-md-2">
                                                                                                    <span class="input-group-btn">
                                                                                                        <button class="btn btn-primary"
                                                                                                                id="btn_req_id"
                                                                                                                name="btn_req_id" type="button"
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
                        
                                                                            {{-- <hr> --}}
                                                                            
                                                                        {{-- </form> --}}
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
                        </div>

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
                    <form action="" id="myForm" method="post">
                        <div class="table table-responsive">
                            <table id="example" class="display table table-bordered table-striped"
                                style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>REFERENCE</th>
                                    <th>NID</th>
                                    <th>SSC_POINT</th>
                                    <th>HSC_POINT</th>
                                    <th>UNIVERSITY_POINT</th>
                                    <th>WRITTEN_EXAM_POINT</th>
                                    <th>INTERVIEW_POINT</th>
                                    <th>F_INTERVIEW_POINT</th>
                                    <th>TOTAL_POINT</th>
                                    <th>MEDICAL_RESULT</th>
                                    <th>MEDICAL_IMAGE</th>
                                    <th>ASSESSMENT</th>
                                </tr>
                                </thead>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-info" id="stm">Save</button>
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
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

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

    
    

    <script>

        $(document).ready(function () {
                    
            var mode = '';

            $("#btn_update").prop("disabled", true);

            //select 2 start
            function customMatcher(term, text) {
                term.term = term.term || '';
                if (text.text.toUpperCase().includes(term.term.toUpperCase())) {
                    return text;
                }
                return false;
            }

            $('.search_recruitment').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('.search_recruitment1').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('.search_plant_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });
            
            $('.search_plant_name1').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('.search_department_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            }); 
            $('.search_department_name1').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            }); 
            
            $('.source_reference1').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });


            $('.nid').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });


            //disable container page scroll
            //to fix page scroll
            // var isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
            // if (isMobile) {
            //     $('html, body').css({
            //         overflow: 'auto',
            //         height: 'auto'
            //     });
            // } else {
            //     $('html, body').css({
            //         overflow: 'hidden',
            //         height: '100%'
            //     });
            // }
            
        });


        $(document).on('change','.search_plant_name', function (e) {

            var plant_info = $(".search_plant_name").val();
            var plant_id = plant_info.split('|')[0];

            $.ajax({
                type: "post",
                url: '{{url('rms/csfGetDeptInfo')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    plant_id: plant_id
                },
                success: function (response) {
                    console.log("M1=",response);

                    if (response) {
                        var data_path_dept = response.csfGetDeptInfo;

                        var option_dept = '';

                        option_dept += "<option value=''>Select</option>";

                        for (var j = 0; j < data_path_dept.length; j++) {
                            var id = data_path_dept[j]['dept_id'];
                            var name = data_path_dept[j]['dept_name'];
                            option_dept += "<option value='" + id + "'>" + name + "</option>";
                        }

                        $(".search_department_name").empty().append(option_dept);

                    }
                },
                error: function (error) {
                }
            })

        });

        $(document).on('change','.search_department_name', function (e) {

            var dept_id = $(".search_department_name").val();
            var plant_info = $(".search_plant_name").val();
            var plant_id = plant_info.split('|')[0];

            $.ajax({
                type: "post",
                url: '{{url('rms/csf_search_get_rec_id')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    dept_id: dept_id,
                    plant_id: plant_id
                },
                success: function (response) {

                    console.log(response);

                    var data_path = response.csf_search_get_rec_id;
                    var option_vacant = '';

                    option_vacant += "<option value=''>Select</option>";

                    for (var j = 0; j < data_path.length; j++) {
                        var id = data_path[j]['recruitment_id'];
                        option_vacant += "<option value='" + id + "'>" + id + "</option>";
                    }

                    $(".search_recruitment").empty().append(option_vacant);
                }
            })

        });

        var table ='';

        $(document).on('click','.btn-get-insert',function(){

            var recrut_id = $(".search_recruitment").val();
            $("#loader").show();
            $("#report-body").hide();

            $.ajax({
                type: "post",
                url: '{{url('rms/getDataForInsert')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    recrut_id: recrut_id
                   
                },
                success: function (response) {
                    console.log("M1=",response);
                    $("#loader").hide();
                    $("#report-body").show();

                    $("#example").DataTable().destroy();
                    table = $("#example").DataTable({

                        data: response,
                        autoWidth: true,
                        ordering: false,
                        columns: [
                            {
                                data: 'recruitment_id',
                                "render": function (row) {
                                    return '<input id="recruitment_id" name="recruitment_id"  readonly value="'+ row +'" type="text">';
                                }
                            },
                            {
                                data: 'source_reference',
                                "render": function (row) {

                                    if(row === null){
                                        return '<input id="source_reference" name="source_reference" disabled type="text" value="">';
                                    }else{
                                        return '<input id="source_reference" name="source_reference" readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'nid',
                                "render": function (row) {

                                    if(row === null){
                                        return '<input id="nid" name="nid"  type="text">';
                                    }else{
                                        return '<input id="nid" name="nid"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'ssc_point',
                                "render": function (row) {

                                    if(row === null){
                                        return '<input id="ssc_point" name="ssc_point"  type="text">';
                                    }else{
                                        return '<input id="ssc_point" name="ssc_point"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'hsc_point',
                                "render": function (row) {

                                    if(row === null){
                                        return '<input id="hsc_point" name="hsc_point"  type="text">';
                                    }else{
                                        return '<input id="hsc_point" name="hsc_point"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'university_point',
                                "render": function (row) {
                                    if(row === null){
                                        return '<input id="university_point" name="university_point"  type="text">';
                                    }else{
                                        return '<input id="university_point" name="university_point"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'written_exam_point',
                                "render": function (row) {
                                    if(row === null){
                                        return '<input id="written_exam_point" name="written_exam_point"  type="text">';
                                    }else{
                                        return '<input id="written_exam_point" name="written_exam_point"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'interview_point',
                                "render": function (row) {
                                    if(row === null){
                                        return '<input id="interview_point" name="interview_point"  type="text">';
                                    }else{
                                        return '<input id="interview_point" name="interview_point"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'f_interview_point',
                                "render": function (row) {
                                    if(row === null){
                                        return '<input id="f_interview_point" name="f_interview_point"  type="text">';
                                    }else{
                                        return '<input id="f_interview_point" name="f_interview_point"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: 'total_point',
                                "render": function (row) {
                                    if(row === null){
                                        return '<input id="total_point" name="total_point"  type="text">';
                                    }else{
                                        return '<input id="total_point" name="total_point"  readonly value="'+ row +'" type="text">';
                                    }

                                }
                            },
                            {
                                data: null,
                                "render": function (row) {
                                    return '<select name="medical_result" id="medical_result"> <option disable value="" >Select</option> <option value="Positive">Positive</option> <option value="Negative">Negative</option> </select>';
                                }
                            },                     
                            {
                                data: null,
                                "render": function (row) {
                                    return '<div class="custom-file"> <input type=file name="file" id="file" class="custom-file-input"> <label class="custom-file-label" for="file">Choose Images</label> </div>';
                                }
                            },
                            {
                                data: null,
                                "render": function (row) {
                                    return '<select name="assessment" id="assessment"> <option disable value="">Select</option> <option value="Selected">Selected</option> <option value="Waiting">Waiting</option> <option value="Not Selected">Not Selected</option> </select>';
                                }
                            },
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: false,
                        paging: false,
                        filter: false
                    });



                },
                error: function (error) {
                }
            })
        });
        $(document).on('click','#stm',function(){

            var url = "{{ url('rms/subDataForInsert') }}";
            var ar = [];
            var rowData = null;
            $("#example tbody tr").each(function() {
                rowData = $(this).find('input, select, textarea').serializeArray();
                var rowAr = {};
                $.each(rowData, function(e, v) {
                    rowAr[v['name']] = v['value'];
                });
                ar.push(rowAr);
            });


            var fData = new FormData();
            var tr = $('#example tbody').closest('tr');
            var fup = $('tr').find("input[type='file']");
            var parentNID = [];
            table.column( 2 ).data().each( function ( value, index ) {
                console.log( 'Data in index: '+index+' is: '+value );
                parentNID.push(value);
            } );

            var totalFiles = fup.length;//Here, getting total file count
            for (var i = 0; i < totalFiles; i++) {
                var file = fup[i].files[0];//Exception will not occur here
                var candidateNID = parentNID[i];

                fData.append("fupUpdate"+[i], file);
                fData.append("candidateNID"+[i], candidateNID);
                fData.append("total_length", i);
            }

            fData.append("ar", JSON.stringify(ar));



            $.ajax({
                url: url,
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                data:  fData,
                contentType: false,
                processData: false,
                success: function (data, status)
                {
                    if (data.success) {
                        toastr.success(data.success, '', {timeOut: 2000});
                        setTimeout(function(){// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);

                    } else {
                        toastr.error(data.error, '', {timeOut: 2000});
                    }
                },
                error: function (xhr, desc, err)
                {

                }
            });



        });

        $(document).on('change','.search_plant_name1', function (e) {

            var plant_info = $(".search_plant_name1").val();
            var plant_id = plant_info.split('|')[0];

            $.ajax({
                type: "post",
                url: '{{url('rms/csfGetDeptInfo')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    plant_id: plant_id
                },
                success: function (response) {
                    console.log("M1=",response);

                    if (response) {
                        var data_path_dept = response.csfGetDeptInfo;

                        var option_dept = '';

                        option_dept += "<option value='' disabled>Select</option>";

                        for (var j = 0; j < data_path_dept.length; j++) {
                            var id = data_path_dept[j]['dept_id'];
                            var name = data_path_dept[j]['dept_name'];
                            option_dept += "<option value='" + id + "'>" + name + "</option>";
                        }

                        $(".search_department_name1").empty().append(option_dept);

                    }
                },
                error: function (error) {
                }
            })

        });

        $(document).on('change','.search_department_name1', function (e) {

            var dept_id = $(".search_department_name1").val();
            var plant_info = $(".search_plant_name1").val();
            var plant_id = plant_info.split('|')[0];

            $.ajax({
                type: "post",
                url: '{{url('rms/csf_search_get_rec_id')}}',
                datatype: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    dept_id: dept_id,
                    plant_id: plant_id
                },
                success: function (response) {

                    console.log(response);

                    var data_path = response.csf_search_get_rec_id;
                    var option_vacant = '';

                    option_vacant += "<option value='' disabled>Select</option>";

                    for (var j = 0; j < data_path.length; j++) {
                        var id = data_path[j]['recruitment_id'];
                        option_vacant += "<option value='" + id + "'>" + id + "</option>";
                    }

                    $(".search_recruitment1").empty().append(option_vacant);
                }
            })

        });
        
        $(document).on('change','.search_recruitment1', function (e) {

            var search_recruitment = $(".search_recruitment1").val();

            $.ajax({
                type: "post",
                url: '{{url('rms/csf_source_reference')}}',
                datatype: 'json',
                data: {
                    recrut_id: search_recruitment,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {

                    var reference = response.csf_source_reference;
                    var source_reference = '';
                    source_reference += "<option value='' selected disabled>SELECT</option>";
                    source_reference += "<option value='ALL' >ALL</option>";
                    for (var i = 0; i < reference.length; i++) {                       
                        var name = reference[i]['source_reference'];
                        source_reference += "<option value='" + name + "'>" + name + "</option>"
                    }
                    console.log(source_reference);
                    $('.source_reference1').empty().append(source_reference);
                }
            })
        });

        $(document).on('change','.source_reference1', function (e) {


            var recruitment_id = $(".search_recruitment1").val();
            var source_reference = $(".source_reference1").val();

            $.ajax({
                type: "post",
                url: '{{url('rms/csf_nid')}}',
                datatype: 'json',
                data: {
                    recrut_id: recruitment_id,
                    sou_ref: source_reference,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {

                    var rs_nid = response.csf_nid;
                    var vnid = '';
                    vnid += "<option value='' selected disabled>SELECT</option>";
                    vnid += "<option value='ALL' >ALL</option>";
                    for (var i = 0; i < rs_nid.length; i++) {                       
                        var name = rs_nid[i]['nid'];
                        vnid += "<option value='" + name + "'>" + name + "</option>"
                    }
                    $('#nid').empty().append(vnid);
                }
            })
        });

        $(document).on('click','.t1,.t2', function (e){

            $('#report-body').hide();

        });

    </script>

@endsection
