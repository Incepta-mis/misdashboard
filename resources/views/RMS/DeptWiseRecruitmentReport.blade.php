@extends('_layout_shared._master')
@section('title','Recruitment Management System')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: #000;
        }

        .btn-primary {
            margin-right: 10px;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/
            /*font-weight: bold;*/

        }

        .s_font {
            font-size: 11px;
            padding: 7px 0;
        }

        .form-group {
            margin-bottom: 0;
        }

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Deptartment Wise Recruitment Report
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form method="post" class="form-horizontal" role="form"
                          action="{{url('dsr/sample_requisition_report_pdf')}}">
                        {{csrf_field()}}
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4" style="padding: 0 5px; margin: 0 0 20px 0;">
                                            <div class="form-group">
                                                <label for="plant_name"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Plant Name</b></label>
                                                <div class="col-md-8">
                                                    <select name="plant_name"
                                                            id="plant_name"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="ALL">ALL</option>
                                                        @foreach($plant_name as $pn)
                                                            <option value="{{$pn->plant_id}}">{{$pn->plant_name}}
                                                                | {{$pn->plant_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="department_name"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Department
                                                        Name</b></label>
                                                <div class="col-md-8">
                                                    <select name="department_name"
                                                            id="department_name"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                        {{--                                                        <option value="ALL">ALL</option>--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4" style="padding: 0 5px; margin: 0 0 20px 0;">
                                            <div class="form-group">
                                                <label for="section_name"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Section
                                                        Name</b></label>
                                                <div class="col-md-8">
                                                    <select name="section_name"
                                                            id="section_name"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                        {{--                                                        <option value="ALL">ALL</option>--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="recruitment_id"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Recruitment
                                                        ID</b></label>
                                                <div class="col-md-8">
                                                    <select name="recruitment_id"
                                                            id="recruitment_id"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                        <option value="" selected disabled>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" col-md-4" style="padding: 0 90px;">
                                            <button type="button" id="display_data_recruitment_report"
                                                    class="btn btn-default btn-sm"
                                                    style="width: 100%; margin: auto;">
                                                <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    {{--This code area is for showing loader image--}}
    <div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
        <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/processing.gif')}}"
                     alt="Loading Report Please wait..."><br>
            </div>
        </div>
    </div>
    {{--This code area is for showing loader image ends here--}}
    {{--Modal starts from here--}}

    <div class="row" id="detail-body" style="display: none">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detail_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Plant Name</th>
                                    <th>Department Name</th>
                                    <th>Section Name</th>
                                    <th>Position</th>
                                    <th>Total No of Position As Per Organogram</th>
                                    <th>Presently Working</th>
                                    <th>Recruitment TNOE</th>
                                    <th>Recruitment Status</th>
                                    <th>Recruitment ID</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
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

    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
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


    <script type="text/javascript">

        $(document).ready(function () {

            //select 2 start
            function customMatcher(term, text) {
                term.term = term.term || '';
                if (text.text.toUpperCase().includes(term.term.toUpperCase())) {
                    return text;
                }
                return false;
            }

            $('#plant_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('#department_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('#section_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $('#recruitment_id').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#plant_name").on('change', function () {

                var plant_info = $("#plant_name").val();
                var plant_id = plant_info.split('|')[0];

                $.ajax({
                    type: "post",
                    url: '{{url('rms/report/get_dept_info')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        plant_id: plant_id
                    },
                    success: function (response) {
                        if (response) {
                            // console.log(response);
                            var data_path_dept = response.get_dept_info;
                            var data_path_recruitment = response.get_recruitment_info;

                            var option_dept = '';
                            var option_recruitment = '';
                            var option_all = '';

                            option_dept += "<option value='ALL'>ALL</option>";
                            option_recruitment += "<option value='ALL'>ALL</option>";
                            option_all += "<option value='ALL'>ALL</option>";

                            for (var j = 0; j < data_path_dept.length; j++) {
                                var id = data_path_dept[j]['dept_id'];
                                var name = data_path_dept[j]['dept_name'];
                                option_dept += "<option value='" + id + "'>" + name + "</option>";
                            }

                            for (var j = 0; j < data_path_recruitment.length; j++) {
                                var id = data_path_recruitment[j]['recruitment_id'];
                                option_recruitment += "<option value='" + id + "'>" + id + "</option>";
                            }

                            $("#department_name").empty().append(option_dept);
                            $("#recruitment_id").empty().append(option_recruitment);
                            $("#section_name").empty().append(option_all);

                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })

            });

            $("#department_name").on('change', function () {

                var dept_id = $("#department_name").val();

                $.ajax({
                    type: "post",
                    url: '{{url('rms/report/get_section_info')}}',
                    datatype: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        dept_id: dept_id
                    },
                    success: function (response) {
                        var data_path = response.get_section_info;
                        var option_section = '';

                        option_section += "<option value='ALL'>ALL</option>";

                        for (var j = 0; j < data_path.length; j++) {
                            var id = data_path[j]['section_id'];
                            var name = data_path[j]['section_name'];
                            option_section += "<option value='" + id + "'>" + name + "</option>";
                        }

                        $("#section_name").empty().append(option_section);
                    }
                })

            });

            $("#display_data_recruitment_report").on('click', function () {

                var plant_id = $("#plant_name").val();
                var dept_id = $("#department_name").val();
                var section_id = $("#section_name").val();
                var recruitment_id = $("#recruitment_id").val();

                if (plant_id === "") {
                    toastr.error("Please Select Plant");
                } else if (dept_id === "") {
                    toastr.error("Please Select Department");
                } else if (section_id === "") {
                    toastr.error("Please Select Section");
                } else if (recruitment_id === "") {
                    toastr.error("Please Select Recruitment ID")
                } else {

                    $("#loader").show();

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/report/get_data_recruitment_report')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            plant_id: plant_id,
                            dept_id: dept_id,
                            section_id: section_id,
                            recruitment_id: recruitment_id
                        },
                        success: function (response) {

                            console.log(response);

                            $("#loader").hide();
                            $("#report-body").show();
                            $("#detail_list").DataTable().destroy();

                            $("#detail-body").show();

                            var var_table = $("#detail_list").DataTable({
                                data: response['get_data_recruitment_report'],
                                dom: '<"toolbar">Bfrtip',
                                buttons: [
                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                                        }
                                    }
                                ],
                                columns: [
                                    {data: "plant_name"},
                                    {data: "dept_name"},
                                    {data: "section_name"},
                                    {data: "desig_name"},
                                    {data: "tnoe_organogram"},
                                    {data: "cur_emp"},
                                    {data: "recruitm_tnoe"},
                                    {data: "recruitm_status"},
                                    {data: "recruitment_id"}
                                ],

                                select: {
                                    style: 'multi',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ],
                                info: false,
                                paging: true,
                                filter: true,
                            })
                        }
                    })
                }
            });

        });

    </script>

@endsection