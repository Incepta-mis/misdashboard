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
                        Deptartment Wise CV Sorting Report
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
                                                <label for="dept_name"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Department Name</b></label>
                                                <div class="col-md-8">
                                                    <select name="dept_name"
                                                            id="dept_name"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0;">
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="ALL">ALL</option>
                                                        @foreach($dept_name as $dn)
                                                            <option value="{{$dn->dept_name}}">{{$dn->dept_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" col-md-4" style="padding: 0 90px;">
                                            <button type="button" id="display_sorting_data_report"
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
                                    <th>Recruitment ID</th>
                                    <th>Plant ID</th>
                                    <th>Plant Name</th>
                                    <th>Department Name</th>
                                    <th>Section Name</th>
                                    <th>Position</th>
                                    <th>NID</th>
                                    <th>Candidate Name</th>
                                    <th>Father Name</th>
                                    <th>Date of Birth</th>
                                    <th>SSC Result</th>
                                    <th>HSC Result</th>
                                    <th>Under Graduation Result</th>
                                    <th>Post Graduation Result</th>
                                    <th>Other Result</th>
                                    <th>Email Address</th>
                                    <th>Contact No</th>
                                    <th>Experience</th>
                                    <th>Source/Reference</th>
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

            $('#dept_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            $("#display_sorting_data_report").on('click', function () {

                var dept_name = $("#dept_name").val();

                if (dept_name === "") {
                    toastr.error("Please Select Department");
                } else {

                    $("#loader").show();

                    $.ajax({
                        type: "post",
                        url: '{{url('rms/report/get_sorting_data_report')}}',
                        datatype: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            dept_name: dept_name,
                        },
                        success: function (response) {

                            console.log(response);

                            $("#loader").hide();
                            $("#report-body").show();
                            $("#detail_list").DataTable().destroy();

                            $("#detail-body").show();

                            var var_table = $("#detail_list").DataTable({
                                data: response['get_sorting_data_report'],
                                dom: '<"toolbar">Bfrtip',
                                buttons: [
                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
                                        }
                                    }
                                ],
                                columns: [
                                    {data: "recruitment_id"},
                                    {data: "plant_id"},
                                    {data: "plant_name"},
                                    {data: "dept_name"},
                                    {data: "section_name"},
                                    {data: "desig_name"},
                                    {data: "nid"},
                                    {data: "candidate_name"},
                                    {data: "father_name"},
                                    {data: "dob"},
                                    {data: "ssc_result"},
                                    {data: "hsc_result"},
                                    {data: "g_result"},
                                    {data: "pg_result"},
                                    {data: "o_result"},
                                    {data: "email_address"},
                                    {data: "contact_no"},
                                    {data: "experience"},
                                    {data: "source_reference"}
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