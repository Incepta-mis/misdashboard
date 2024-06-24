@extends('_layout_shared._master')
@section('title','Recruitment Management System')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
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

        body {
            counter-reset: Serial;
        }

        table {
            border-collapse: separate;
        }

        table tbody tr td:nth-child(2):before {
            counter-increment: Serial;
            content: "" counter(Serial);
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
                                        Department Wise Recruitment
                                    </label>
                                </header>
                                <div class="panel-body" style="padding-bottom: 10px;">
                                    <div class="form-horizontal">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-12">
                                                <form action="" class="form-horizontal" role="form">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0; padding: 0 12px">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Plant
                                                                            Name</b></label>
                                                                    <select name="search_plant_name" id="search_plant_name"
                                                                            class="form-control input-sm"
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
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="padding: 0 5px">
                                                            <div class="col-md-12" style="padding: 0">
                                                                <div class="col-md-9" style="padding: 0 5px;">
                                                                    <div class="form-group">
                                                                        <div class="col-md-12" style="margin:  0;">
                                                                            <label for="rm_terr"
                                                                                   class="control-label s_font"
                                                                                   style="padding: 0;"><b>Recruitment
                                                                                    ID</b></label>
                                                                            <select name="search_recruitment" id="search_recruitment"
                                                                                    class="form-control input-sm"
                                                                                    style="font-size: 10px; height: 26px; padding: 0 11px;">
                                                                                <option value="" selected disabled>SELECT
                                                                                </option>
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
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Plant
                                                                            Name</b></label>
                                                                    <select name="plant_info" id="plant_info"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                        @foreach($plant_info as $pi)
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
                                                                    <select name="dept_info" id="dept_info"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin:  0;">
                                                                    <label for="rm_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Section
                                                                            Name</b></label>
                                                                    <select name="section_info" id="section_info"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="am_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Position</b></label>
                                                                    <select name="position" id="position"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>No Of
                                                                            Position</b></label>
                                                                    <input type="number" min="1"
                                                                           oninput="validity.valid||(value='');"
                                                                           name="quant"
                                                                           style="font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           autocomplete="off" id="position_no">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Presently
                                                                            Working</b></label>
                                                                    <input type="number" min="1"
                                                                           oninput="validity.valid||(value='');"
                                                                           name="presently_working"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px;"
                                                                           class=" form-control"
                                                                           autocomplete="off" id="presently_working" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="am_terr"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Total Employees (As Per Organogram)
                                                                        </b></label>
                                                                    <input type="number" min="1"
                                                                           oninput="validity.valid||(value='');"
                                                                           name="req_TNOE"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           readonly
                                                                           autocomplete="off" id="req_TNOE">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Recruitment
                                                                            Status</b></label>
                                                                    <select name="req_status" id="req_status"
                                                                            class="form-control input-sm"
                                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                                        <option value="" selected disabled>SELECT
                                                                        </option>
                                                                        <option value="VACANT">VACANT</option>
                                                                        <option value="NEW">NEW</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="padding: 0 5px;">
                                                            <div class="form-group">
                                                                <div class="col-md-12" style="margin: 0;">
                                                                    <label for="quant"
                                                                           class="control-label s_font"
                                                                           style="padding: 0;"><b>Recruitment
                                                                            ID</b></label>
                                                                    <input type="test"
                                                                           name="req_id"
                                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0 5px;"
                                                                           class=" form-control"
                                                                           id="req_id"
                                                                           readonly="">
                                                                    {{--                                                                    </select>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" style="display: none;">
                                                        <div class="col-md-8">
                                                            <div class="form-group" style="padding: 0 4px;">
                                                                <label for="quant"
                                                                       class="control-label s_font"
                                                                       style="padding: 0;"><b>Organogram Image
                                                                        ID</b></label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="file"
                                                                           class="form-control input-group-sm"
                                                                           id="organ_img"
                                                                           style="height: 26px; padding: 3px">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary" type="button"
                                                                                style="height: 26px; padding: 0 8px;"
                                                                                id="btn_display_img">
                                                                            <span class="glyphicon glyphicon-picture"
                                                                                  aria-hidden="true">
                                                                        </span> Show
                                                                        </button>
                                                                        </span>
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
                                                                        type="button" class="btn" id="btn_save"><span
                                                                            style="padding: 0 3px;"
                                                                            class="glyphicon glyphicon-save"></span>Save
                                                                </button>
                                                            </div>
                                                            <div class="btn-group btn-group-sm btn_form_below_update btn_form_below"
                                                                 role="group" aria-label="Third group">
                                                                <button style="padding: 1px 3px; height: 25px; width: 80px;"
                                                                        type="button" class="btn" id="btn_update"><span
                                                                            style="padding: 0 3px;"
                                                                            class="glyphicon glyphicon-edit"></span>Update
                                                                </button>
                                                            </div>
                                                            <div class="btn-group btn-group-sm btn_form_below_refresh btn_form_below"
                                                                 role="group" aria-label="Third group">
                                                                <button style="padding: 1px 3px; height: 25px; width: 80px;"
                                                                        type="button" class="btn" id="btn_refresh"><span
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
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog  modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Organogram Image</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="" id="preview_img" width="200px">
                    <iframe id="viewer" frameborder="0" scrolling="no" width="100%" height="600"></iframe>
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

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

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

            $('#search_recruitment').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('#search_plant_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('#search_department_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });


            $('#plant_info').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });


            $('#dept_info').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('#section_info').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('#position').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#search_plant_name").on('change', function () {

                var plant_info = $("#search_plant_name").val();
                var plant_id = plant_info.split('|')[0];

                $.ajax({
                    type: "post",
                    url: '{{url('rms/dwr_get_dept_info_2')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        plant_id: plant_id
                    },
                    success: function (response) {
                        if (response) {
                            var data_path_dept = response.dwr_get_dept_info_2;

                            var option_dept = '';

                            option_dept += "<option value=''>Select</option>";

                            for (var j = 0; j < data_path_dept.length; j++) {
                                var id = data_path_dept[j]['dept_id'];
                                var name = data_path_dept[j]['dept_name'];
                                option_dept += "<option value='" + id + "'>" + name + "</option>";
                            }

                            $("#search_department_name").empty().append(option_dept);

                        }
                    },
                    error: function (error) {
                    }
                })

            });

            $("#search_department_name").on('change', function () {

                var dept_id = $("#search_department_name").val();
                var plant_info = $("#search_plant_name").val();
                var plant_id = plant_info.split('|')[0];

                console.log(plant_id);
                console.log(dept_id);

                $.ajax({
                    type: "post",
                    url: '{{url('rms/search_get_rec_id')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        dept_id: dept_id,
                        plant_id: plant_id
                    },
                    success: function (response) {

                        console.log(response);

                        var data_path = response.search_get_rec_id;
                        var option_vacant = '';

                        option_vacant += "<option value=''>Select</option>";

                        for (var j = 0; j < data_path.length; j++) {
                            var id = data_path[j]['recruitment_id'];
                            option_vacant += "<option value='" + id + "'>" + id + "</option>";
                        }

                        $("#search_recruitment").empty().append(option_vacant);
                    }
                })

            });

            $('#plant_info').on('select2:select', function (e) {
                console.log($(this).val().split('|'));
                var split_data = $(this).val().split('|');
                $.ajax({
                    type: "post",
                    url: '{{url('rms/dept_info')}}',
                    datatype: 'json',
                    data: {
                        plant_id: split_data[0],
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {

                        var deptList = response.dept_info;
                        var selectOptDept = '';
                        selectOptDept += "<option value='' selected disabled>SELECT</option>";
                        for (var i = 0; i < deptList.length; i++) {
                            console.log(deptList[i]['dept_id']);
                            var id = deptList[i]['dept_id'];
                            var name = deptList[i]['dept_name'];
                            selectOptDept += "<option value='" + id + '|' + name + "'>" + name + "</option>"
                        }
                        console.log(selectOptDept);
                        $('#dept_info').empty().append(selectOptDept);
                    }
                })
            });

            $('#dept_info').on('select2:select', function (e) {

                var plant_id = $("#plant_info").val().split('|');
                var dept_id = $(this).val().split('|');
                console.log(plant_id[0]);
                console.log(dept_id[0]);
                $.ajax({
                    type: "post",
                    url: '{{url('rms/section_info')}}',
                    datatype: 'json',
                    data: {
                        plant_id: plant_id[0],
                        dept_id: dept_id[0],
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {

                        var sectionList = response.section_info;
                        var selecOptSection = '';
                        selecOptSection += "<option value='' selected disabled>SELECT</option>"
                        for (var i = 0; i < sectionList.length; i++) {
                            var id = sectionList[i]['section_id'];
                            var name = sectionList[i]['section_name'];
                            selecOptSection += "<option value='" + id + '|' + name + "'>" + name + "</option>";
                        }

                        $('#section_info').empty().append(selecOptSection);
                    }
                })
            });


            $('#section_info').on('select2:select', function (e) {
                var plant_id = $("#plant_info").val().split('|');
                var section = $(this).val();
                $.ajax({
                    type: "post",
                    url: '{{url('rms/position_info')}}',
                    datatype: 'json',
                    data: {
                        plant_id: plant_id[0],
                        dept_id: $('#dept_info').val().split('|')[0],
                        sect_id: $(this).val().split('|')[0],
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        var positionList = response.position_info;
                        var selectOptPosition = '';
                        selectOptPosition += "<option value='' selected disabled>SELECT</option>";
                        for (var i = 0; i < positionList.length; i++) {
                            var id = positionList[i]['desig_id'];
                            var name = positionList[i]['desig_name'];
                            selectOptPosition += "<option value='" + id + '|' + name + "'>" + name + "</option>"
                        }

                        $('#position').empty().append(selectOptPosition);
                        
                        if(response.presently_working.length > 0){
                            $('#presently_working').val(response.presently_working[0].pw);
                            $('#req_TNOE').val(response.presently_working[0].torgan);
                        }   
                        

                    }
                })
            });

            $("#search_recruitment").on('change', function () {
                console.log($(this).val());
            });

            function previewImage(src, target) {
                var fr = new FileReader();
                fr.onload = function () {
                    target.src = fr.result;
                };

                fr.readAsDataURL(src.files[0]);

                console.log(src.files[0]);
            }

            var selectedFile = null;
            $('#organ_img').on('change', function (event) {
                var fileType = event.target.value.substr(event.target.value.lastIndexOf('.') + 1);
                selectedFile = event.target.files[0];
                if (fileType.toUpperCase() === 'PDF') {
                    $('#viewer').attr('src', URL.createObjectURL(event.target.files[0]));
                    $('#viewer').show();
                    $('#preview_img').hide();
                } else {
                    $('#viewer').attr('src', '');
                    $('#viewer').hide();
                    previewImage(event.target, document.getElementById('preview_img'));
                }
            });

            $('#btn_display_img').on('click', function () {
                if ($('#organ_img').val()) {
                    $('#myModal').modal('show');
                }else if(mode == 'U'){
                    $('#myModal').modal('show');
                }
            });


            $('#btn_save').on('click', function () {

                if ($("#plant_info").val() === null){
                    toastr.error("Select Plant")
                }else {

                    var fdata = new FormData();
                    // var selectedFile = null;
                    // selectedFile = target.files[0];

                    fdata.append('file', selectedFile);
                    fdata.append('formData',
                        '{"name":"dipro",' +
                        '"plant_info":"' + $("#plant_info").val() + '", ' +
                        '"dept_info":"' + $("#dept_info").val() + '", ' +
                        '"section_info":"' + $("#section_info").val() + '", ' +
                        '"position":"' + $("#position").val() + '", ' +
                        '"position_no":"' + $("#position_no").val() + '", ' +
                        '"presently_working":"' + $("#presently_working").val() + '", ' +
                        '"req_tnoe":"' + $("#req_TNOE").val() + '", ' +
                        '"req_status":"' + $("#req_status").val() + '" }');

                    $.ajax({
                        headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                        type: 'post',
                        url: '{{url('rms/save_record')}}',
                        async: true,
                        contentType: false,
                        processData: false,
                        data: fdata,
                        success: function (response) {
                            $("#req_id").val(response.rid);
                            toastr.success("Saved Successfully!");

                            $("#btn_save").prop("disabled", true);
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    })
                }
            });


            $("#btn_req_id").on('click', function () {

                var req_id = $("#search_recruitment").val();
                console.log(req_id);

                $.ajax({
                    type: "post",
                    url: '{{url('rms/search_rec_id')}}',
                    datatype: 'json',
                    data: {
                        recruitment_id: req_id,
                        _token: '{{csrf_token()}}',
                    },
                    success: function (response) {

                        var data_path = response.search_recruitment[0];
                        console.log("response");
                        console.log(response);

                        $("#btn_save").prop("disabled", true);
                        $("#btn_update").prop("disabled", false);

                        //department
                        var deptList = response.dept;
                        var selectOptDept = '';
                        selectOptDept += "<option value='' selected disabled>SELECT</option>";
                        for (var i = 0; i < deptList.length; i++) {
                            // console.log(deptList[i]['dept_id']);
                            var id = deptList[i]['dept_id'];
                            var name = deptList[i]['dept_name'];
                            selectOptDept += "<option value='" + id + '|' + name + "'>" + name + "</option>"
                        }
                        //console.log(selectOptDept);
                        $('#dept_info').empty().append(selectOptDept);


                        //section

                        var sectionList = response.sect;
                        var selecOptSection = '';
                        selecOptSection += "<option value='' selected disabled>SELECT</option>"
                        for (var i = 0; i < sectionList.length; i++) {
                            var id = sectionList[i]['section_id'];
                            var name = sectionList[i]['section_name'];
                            selecOptSection += "<option value='" + id + '|' + name + "'>" + name + "</option>";
                        }

                        $('#section_info').empty().append(selecOptSection);
                        //position

                        var positionList = response.pos;
                        var selectOptPosition = '';
                        selectOptPosition += "<option value='' selected disabled>SELECT</option>";
                        for (var i = 0; i < positionList.length; i++) {
                            var id = positionList[i]['desig_id'];
                            var name = positionList[i]['desig_name'];
                            selectOptPosition += "<option value='" + id + '|' + name + "'>" + name + "</option>"
                        }

                        $('#position').empty().append(selectOptPosition);

                        var final_plant_info = data_path['plant_id'] + '|' + data_path['plant_name'];
                        var final_dept_info = data_path['dept_id'] + '|' + data_path['dept_name'];
                        var final_section_info = data_path['section_id'] + '|' + data_path['section_name'];
                        var final_desig_info = data_path['desig_id'] + '|' + data_path['desig_name'];


                        console.log(final_plant_info);
                        $("#plant_info").val(final_plant_info).trigger('change');
                        $("#dept_info").val(final_dept_info).trigger('change');
                        $("#section_info").val(final_section_info).trigger('change');
                        $("#position").val(final_desig_info);
                        $("#position_no").val(data_path['tnoe_organogram']);
                        $("#presently_working").val(response.pworking[0].pw);
                        $("#req_TNOE").val(response.pworking[0].torgan);
                        $("#req_status").val(data_path['recruitm_type']);
                        $("#req_id").val(data_path['recruitment_id']);
                        var path = data_path['image'];
                        if(path){
                            mode = 'U';
                            if(path.substr(path.lastIndexOf('.') + 1).toUpperCase() === 'PDF'){
                                console.log('{{url('')}}'+'/'+path);
                                $('#viewer').attr('src', '{{url('')}}'+'/'+path);
                                $('#viewer').show();
                                $('#preview_img').hide();
                            }else{
                                console.log('{{url('')}}'+'/'+path);
                                $('#viewer').attr('src', '');
                                $('#viewer').hide();
                                $('#preview_img').attr('src','{{url('')}}'+'/'+path);
                            }
                        }


                    }
                })

            });

            $("#btn_update").on('click', function () {

                var plant_info = $("#plant_info").val();
                var dept_info = $("#dept_info").val();
                var section_info = $("#section_info").val();
                var position_info = $("#position").val();
                var position_no = $("#position_no").val();
                var presently_working = $("#presently_working").val();
                var req_TNOE = $("#req_TNOE").val();
                var req_status = $("#req_status").val();
                var req_id = $("#req_id").val();

                var fdata = new FormData();

                console.log('1');

                fdata.append('file', selectedFile);
                fdata.append('formData',
                    '{"plant_info":"' + plant_info + '", ' +
                    '"dept_info":"' + dept_info + '", ' +
                    '"section_info":"' + section_info + '", ' +
                    '"position":"' + position_info + '", ' +
                    '"req_id":"' + req_id + '", ' +
                    '"position_no":"' + position_no+ '", ' +
                    '"presently_working":"' + presently_working + '", ' +
                    '"req_tnoe":"' + req_TNOE + '", ' +
                    '"req_status":"' + req_status + '" }');

                console.log('2');

                if (plant_info.length > 0
                    && dept_info.length > 0
                    && section_info.length > 0
                    && position_info.length > 0
                    && position_no.length > 0
                    && presently_working.length > 0
                    && req_TNOE.length > 0
                    && req_status.length > 0) {

                    console.log('3');
                    $.ajax({
                        headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                        method: "post",
                        url: '{{url('rms/update_record')}}',
                        datatype: 'json',
                        data: fdata,
                        async: true,
                        contentType: false,
                        processData: false,
                        success:function (response) {
                            toastr.success("Data Has Been Updated.");
                            mode = '';

                            $("#plant_info").val('').trigger('change');
                            $("#dept_info").val('').trigger('change');
                            $("#section_info").val('').trigger('change');
                            $("#position").val('').trigger('change');
                            $("#position_no").val('');
                            $("#presently_working").val('');
                            $("#req_TNOE").val('');
                            $("#req_status").val('');
                            $("#organ_img").val('');
                            $("#req_id").val('');
                        },
                        error:function (err) {
                            console.log(err);
                        }
                    })
                }

            });

            $("#btn_refresh").on('click', function () {

                window.location.reload();

            });

            //end

            //disable container page scroll
            //to fix page scroll
            var isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
            if (isMobile) {
                $('html, body').css({
                    overflow: 'auto',
                    height: 'auto'
                });
            } else {
                $('html, body').css({
                    overflow: 'hidden',
                    height: '100%'
                });
            }
        })

    </script>

@endsection
