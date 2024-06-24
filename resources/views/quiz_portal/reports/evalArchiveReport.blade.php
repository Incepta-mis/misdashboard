@extends('_layout_shared._master')
@section('title','Evaluation Archive Report')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
        .swal2-icon.swal2-warning {
            font-size: 14px;
        }

        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
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

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        /*Here starts styling of table section*/
        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        body {
            color: #000;
        }
        .odd{
            background-color: #FFF8FB !important;
        }
        .even{
            background-color: #DDEBF8 !important;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }
        #radioBtn .notActive{
            color: #3276b1;
            background-color: #fff;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label class="text-default">
                                    Evaluation Archive Report
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="filter" class="col-md-3 col-sm-3 control-label
                                            text-right">Filter by</label>
                                            <div class="col-md-9 col-sm-9">
                                                <div class="input-group">
                                                    <div id="radioBtn" class="btn-group">
                                                        <a class="btn btn-primary btn-sm active" data-toggle="filter"
                                                           data-title="YGW">Year and Group Wise</a>
                                                        <a class="btn btn-primary btn-sm notActive"
                                                           data-toggle="filter" data-title="EW">Employee Wise</a>
                                                    </div>
                                                    <input type="hidden" name="happy" id="filter">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12" id="yearGroupWiseDiv">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-12">
                                            <label  class="col-md-3 col-sm-3 control-label fnt_size" for="year">Select Year:</label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="year" name="year"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled value = "">Select Year</option>
                                                    <option value = "All">All</option>
                                                    @foreach($year as $c)
                                                        <option value="{{$c->year}}" >{{$c->year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label  class="col-md-3 col-sm-3 control-label fnt_size" for="group">Select
                                                Group:</label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="group" name="group"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled value = "">Select Group</option>
                                                    <option value = "All">All</option>
                                                    @foreach($group as $c)
                                                        <option value="{{$c->p_group}}">{{$c->p_group}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12" id="employeeWiseDiv" style="display: none">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-12">
                                            <label  class="col-md-3 col-sm-3 control-label fnt_size"
                                                    for="emp">Select Employee</label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="emp" name="emp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled value = "">Select Employee</option>
                                                    <option value = "All">All</option>
                                                    @foreach($emp as $c)
                                                        <option value="{{$c->emp_id}}" >{{$c->emp_id}} -
                                                            {{$c->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id='selVal' value="YGW">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                            <button type="button" id="btn_submit" class="btn btn-warning btn-sm" style="float: right;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b>
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                                            <div id="export_buttons" style="float: left">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/preloader.gif')}}"
                         alt="Loading Report Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Please wait...</i></b></span>
                </div>
                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                    <div id="export_buttons">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="req_report" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead style="background-color: darkkhaki;">
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Trr Code</th>
                                    <th>Name of AM</th>
                                    <th>Year</th>
                                    <th>Group</th>
                                    <th id="mcq_th">MCQ Score</th>
                                    <th id="broad_th">Broad Question Score</th>
                                    <th id="total_th">Total</th>
                                    <th>Percentage (%)</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

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
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}

    <script type="text/javascript">

        $('#radioBtn a').on('click', function(){
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#'+tog).prop('value', sel);

            $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');

            $('#selVal').val(sel);
            if(sel == 'EW'){
                $('#yearGroupWiseDiv').css('display','none');
                $('#employeeWiseDiv').css('display','block');
            }else if(sel == 'YGW'){
                $('#yearGroupWiseDiv').css('display','block');
                $('#employeeWiseDiv').css('display','none');
            }
        })

        $('#group').select2();
        $('#year').select2();
        $('#emp').select2();

        $(document).ready(function () {
            $('#btn_submit').on('click', function (e) {
                e.preventDefault();
                var group = $('#group').val();
                var year = $('#year').val();
                var emp = $('#emp').val();
                var selVal = $('#selVal').val();

                if(selVal === 'YGW'){
                    if(group === null || year === null){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please input required fields!',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }else{
                        $("#loader").show();
                        var table = null;

                        $.ajax({
                            type: 'post',
                            url: '{{  url('quiz/getEvalArchvReport') }}',
                            data: {
                                'group': group,'year': year, '_token': "{{ csrf_token() }}" },
                            success: function (data) {

                                if(data.length > 0){
                                    $("#mcq_th")[0].innerHTML = "MCQ Score ("+data[0]['mcq_total']+")";
                                    $("#broad_th")[0].innerHTML = "Broad Question Score ("+data[0]['broad_ques_total']+")";
                                    $("#total_th")[0].innerHTML = "Total Score ("+data[0]['total_out_of']+")";
                                }else{
                                    $("#mcq_th")[0].innerHTML = "MCQ Score";
                                    $("#broad_th")[0].innerHTML = "Broad Question Score";
                                    $("#total_th")[0].innerHTML = "Total Score";
                                }


                                $("#showTable").show();
                                $("#loader").hide();
                                $("#req_report").DataTable().destroy();

                                table = $("#req_report").DataTable({
                                    dom: 'Bfrtip',
                                    buttons: [],
                                    data: data,
                                    columns: [
                                        {data: "emp_id"},
                                        {data: "trr_code"},
                                        {data: "am_name"},
                                        {data: "year"},
                                        {data: "p_group"},
                                        {data: "mcq_score"},
                                        {data: "broad_ques_score"},
                                        {data: "total_score"},
                                        {data: "percentage"}
                                    ],
                                    language: {
                                        "emptyTable": "No Matching Records Found."
                                    },
                                    info: true,
                                    paging: false,
                                    filter: true,
                                    select: {
                                        style: 'os',
                                        selector: 'td:first-child'
                                    }
                                });

                                table.fixedHeader.enable();

                                new $.fn.dataTable.Buttons(table, {
                                    buttons: [
                                        {
                                            extend: 'collection',
                                            text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                            buttons: [
                                                {
                                                    extend: 'excel',
                                                    text: 'Save As Excel',
                                                    footer: true,
                                                    exportOptions: {
                                                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                                                    },
                                                    action: function (e, dt, node, config) {
                                                        exportExtension = 'Excel';
                                                        $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                                    }
                                                }, {
                                                    extend: 'pdf',
                                                    text: 'Save As PDF',
                                                    orientation: 'landscape',
                                                    footer: true,
                                                    exportOptions: {
                                                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                                                    },
                                                    customize : function(doc){
                                                        doc.content[1].table.widths =
                                                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                                    },
                                                    action: function (e, dt, node, config) {
                                                        exportExtension = 'PDF';
                                                        $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                                    }
                                                }
                                            ],
                                            className: 'btn btn-sm btn-primary'
                                        }
                                    ]
                                }).container().appendTo($('#export_buttons'));
                            },
                            error: function (e) {
                                console.log(e);
                                $("#loader").hide();
                                $("#showTable").show();
                            }
                        });
                    }
                }else if(selVal === 'EW'){
                    if(emp === null){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please choose an employee!',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }else{
                        $("#loader").show();
                        var table = null;

                        $.ajax({
                            type: 'post',
                            url: '{{  url('quiz/getEvalArchvReportEmpWIse') }}',
                            data: {
                                'emp': emp, '_token': "{{ csrf_token() }}" },
                            success: function (data) {

                                if(data.length > 0){
                                    $("#mcq_th")[0].innerHTML = "MCQ Score ("+data[0]['mcq_total']+")";
                                    $("#broad_th")[0].innerHTML = "Broad Question Score ("+data[0]['broad_ques_total']+")";
                                    $("#total_th")[0].innerHTML = "Total Score ("+data[0]['total_out_of']+")";
                                }else{
                                    $("#mcq_th")[0].innerHTML = "MCQ Score";
                                    $("#broad_th")[0].innerHTML = "Broad Question Score";
                                    $("#total_th")[0].innerHTML = "Total Score";
                                }

                                $("#showTable").show();
                                $("#loader").hide();
                                $("#req_report").DataTable().destroy();

                                table = $("#req_report").DataTable({
                                    dom: 'Bfrtip',
                                    buttons: [],
                                    data: data,
                                    columns: [
                                        {data: "emp_id"},
                                        {data: "trr_code"},
                                        {data: "am_name"},
                                        {data: "year"},
                                        {data: "p_group"},
                                        {data: "mcq_score"},
                                        {data: "broad_ques_score"},
                                        {data: "total_score"},
                                        {data: "percentage"}
                                    ],
                                    language: {
                                        "emptyTable": "No Matching Records Found."
                                    },
                                    info: true,
                                    paging: false,
                                    filter: true,
                                    select: {
                                        style: 'os',
                                        selector: 'td:first-child'
                                    }
                                });

                                table.fixedHeader.enable();

                                new $.fn.dataTable.Buttons(table, {
                                    buttons: [
                                        {
                                            extend: 'collection',
                                            text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                            buttons: [
                                                {
                                                    extend: 'excel',
                                                    text: 'Save As Excel',
                                                    footer: true,
                                                    exportOptions: {
                                                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                                                    },
                                                    action: function (e, dt, node, config) {
                                                        exportExtension = 'Excel';
                                                        $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                                    }
                                                }, {
                                                    extend: 'pdf',
                                                    text: 'Save As PDF',
                                                    orientation: 'landscape',
                                                    footer: true,
                                                    exportOptions: {
                                                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                                                    },
                                                    customize : function(doc){
                                                        doc.content[1].table.widths =
                                                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                                    },
                                                    action: function (e, dt, node, config) {
                                                        exportExtension = 'PDF';
                                                        $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                                    }
                                                }
                                            ],
                                            className: 'btn btn-sm btn-primary'
                                        }
                                    ]
                                }).container().appendTo($('#export_buttons'));
                            },
                            error: function (e) {
                                console.log(e);
                                $("#loader").hide();
                                $("#showTable").show();
                            }
                        });
                    }
                }

            });
        });


    </script>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection