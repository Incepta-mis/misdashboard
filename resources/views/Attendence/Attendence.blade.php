@extends('_layout_shared._master')
@section('title','Attendance Status Daily')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>

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

        .swal2-icon.swal2-warning {
            font-size: 14px;
        }

        .swal2-html-container{
            font-size: 1.5em !important;
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
            font-size: 13px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 12px;
            text-align: center;
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

        .cls-req{
            color: red;
            font-weight: bold;
        }

        .form-rounded {
            border-radius: .3rem;
        }

        tr:nth-child(even) {
            background-color: rgba(150, 212, 212, 0.4);
        }


        td:nth-child(even) {
            background-color: rgba(150, 212, 212, 0.4);
        }


    </style>
@endsection
@section('right-content')


    {{-- Filter Option Starts--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Display Attendance History
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Employee:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="select_emp" name="select_emp" class="form-control input-sm filter-option">
                                                    <option selected disabled>Select Employee</option>
                                                    @foreach($empWork as $empWorks)
                                                        <option value="{{$empWorks->emp_id}}">{{$empWorks->emp_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="display_report" class="btn btn-warning btn-sm" disabled>
                                                    <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">
                                                </div>
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

    </div>
    {{-- Filter Option Ends--}}

    {{--Loader--}}
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


    {{--show datatable--}}
    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="elr" width="100%" class="table table-bordered table-condensed table-striped table_style">
                                <thead style="background-color: #5BA4B9; color: white;">
                                <tr>
                                    <th>Employee</th>
                                    <th>Plant Id</th>
                                    <th>Employee Type</th>
                                    <th>Employee Designation</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Status</th>
                                    <th>Reason Type</th>
                                    <th>Reason By Emp</th>
                                    <th>Reason Acceptability</th>
                                    <th>Remark</th>
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


    {{--Form--}}
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Attendance Status Daily
                    </label>
                </header>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <section class="panel panel-info">
                            <div class="panel-body" style="padding-top: 2%">
                                <div class="form-horizontal">
                                    <form class="form-horizontal">

                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Attendance Form</legend>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="com_code"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Employee Name:</b></label>

                                                            <select id="employee_name" name="employee_name" class="form-control input-sm filter-option">
                                                                <option selected disabled>Select Employee</option>
                                                                @foreach($allEmp as $allEmps)
                                                                    <option value="{{$allEmps->emp_id}}">{{$allEmps->emp_id}}-{{$allEmps->sur_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="com_name"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Employee Code:</b></label>

                                                            <input type="" class="form-control input-sm form-rounded"
                                                                   value="" name="emp_code" id="emp_code" readonly>
                                                        </div>

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="plant_id" class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Plant:</b></label>
                                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                                   class="form-control input-xs form-rounded" id="plant_id" min="1"
                                                                   placeholder="" name="plant_id" readonly>
                                                        </div>


                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="main_id"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Department:</b></label>
                                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                                   class="form-control input-xs form-rounded" id="dept_name" min="1"
                                                                   placeholder="" name="dept_name" readonly>
                                                        </div>

                                                    </div>


                                                    <div class="form-group">
                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="wc"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Work Center:</b></label>
                                                            <input type="text" class="form-control input-sm form-rounded" onkeyup="this.value = this.value.toUpperCase();"
                                                                   value="" placeholder="" name="wc"
                                                                   id="wc" readonly>
                                                        </div>

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="wc"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Section:</b></label>
                                                            <input type="" class="form-control input-sm form-rounded" onkeyup="this.value = this.value.toUpperCase();"
                                                                   value="" placeholder="" name="section"
                                                                   id="section" readonly>
                                                        </div>


                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="wc"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Employee Type:</b></label>
                                                            <input type="text" class="form-control input-sm form-rounded" onkeyup="this.value = this.value.toUpperCase();"
                                                                   value="" placeholder="" name="emp_type"
                                                                   id="emp_type" readonly>
                                                        </div>


                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="plant_id" class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Designation:</b></label>

                                                            <input type="text" class="form-control input-sm form-rounded"
                                                                   value="" name="emp_deg"
                                                                   id="emp_deg" disabled>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="from"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>From:</b></label>

                                                            <input type="text" class="form-control input-sm form-rounded"
                                                                   value="" placeholder="" name="date_from"
                                                                   id="date_from">
                                                        </div>

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="date_to" class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>To:</b></label>

                                                            <input type="text" class="form-control input-sm form-rounded" id="date_to"
                                                                   placeholder="" name="date_to">
                                                        </div>

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="status"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Status:</b></label>

                                                            <select id="status" name="status" class="form-control input-sm filter-option form-rounded">
                                                                <option selected >Select Status</option>
                                                                <option value="Absent">Absent</option>
                                                                <option value="earlyOut">Early Out</option>
                                                                <option value="lateIn">Late In</option>

                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="reason_type" class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Reason Type:</b></label>
                                                            <select id="reason_type" name="reason_type" class="form-control input-sm filter-option form-rounded">
                                                                <option selected >Select Reason Type</option>
                                                                <option value="Personal">Personal</option>
                                                                <option value="Medical">Medical</option>
                                                                <option value="Official">Official</option>

                                                            </select>
                                                        </div>


                                                    </div>

                                                    <div class="form-group">

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="reason_by_emp" class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Reason By Employee:</b></label>

                                                            <input type="text" class="form-control input-sm form-rounded"
                                                                   value="" placeholder="" min="1" name="reason_by_emp"
                                                                   id="reason_by_emp">
                                                        </div>

                                                        <div class="col-md-3 col-sm-3">
                                                            <label for="reason_acceptability"
                                                                   class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Reason Acceptability:</b></label>

                                                            <select id="reason_acceptability" name="reason_acceptability" class="form-control input-sm filter-option form-rounded">
                                                                <option selected >Select Acceptability</option>
                                                                <option  value="acceptable">Acceptable</option>
                                                                <option value="unacceptable">Unacceptable</option>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-4 col-sm-4">
                                                            <label for="remarks" class="control-label fnt_size"
                                                                   style="padding-right:0px;"><b>Remarks:</b></label>

                                                            <input type="" class="form-control input-sm form-rounded" id="remarks"
                                                                   placeholder="" name="remarks">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                                            <button type="button" id="submit_form" class="btn btn-info btn-sm"
                                                                    style="float: right">
                                                                <i class="fa fa-chevron-circle-up"></i> <b>Send To HR</b>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
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
            </section>

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
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function () {

            /*chart */
            window.onload = function () {

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,

                    title:{
                        text:"Fortune 500 Companies by Country"
                    },
                    axisX:{
                        interval: 1
                    },
                    axisY2:{
                        interlacedColor: "rgba(1,77,101,.2)",
                        gridColor: "rgba(1,77,101,.1)",
                        title: "Number of Companies"
                    },
                    data: [{
                        type: "bar",
                        name: "companies",
                        axisYType: "secondary",
                        color: "#014D65",
                        dataPoints: [
                            { y: 3, label: "Sweden" },
                            { y: 7, label: "Taiwan" },
                            { y: 5, label: "Russia" },
                            { y: 9, label: "Spain" },
                            { y: 7, label: "Brazil" },
                            { y: 7, label: "India" },
                            { y: 9, label: "Italy" },
                            { y: 8, label: "Australia" },
                            { y: 11, label: "Canada" },
                            { y: 15, label: "South Korea" },
                            { y: 12, label: "Netherlands" },
                            { y: 15, label: "Switzerland" },
                            { y: 25, label: "Britain" },
                            { y: 28, label: "Germany" },
                            { y: 29, label: "France" },
                            { y: 52, label: "Japan" },
                            { y: 103, label: "China" },
                            { y: 134, label: "US" }
                        ]
                    }]
                });
                chart.render();
            }
            /*Chart Ends*/


            var date = new Date();
            $('#date_from').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#date_to').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });


            /*Form Info*/
            $('#employee_name').select2();
            $('#select_emp').select2();


            $('#select_emp').change(function () {
                $('#display_report').prop("disabled", false);
            });


            /*Display datatable*/
            $('#display_report').on('click', function (e) {
                // e.preventDefault();
                $("#loader").show();
                var employee_code = $('#select_emp').val();
                var table = null;


                $.ajax({
                    type: 'post',
                    url: '{{  url('attendenceManagementSys/attendence/getDisplayInfo') }}',
                    data: { 'employee_code': employee_code, '_token': "{{ csrf_token
                    () }}"},
                    success: function (data) {
                        $("#showTable").show();
                        $("#loader").hide();
                        $("#elr").DataTable().destroy();

                        table = $("#elr").DataTable({

                            data: data.empData,
                            columns: [
                                {data: "emp_name"},
                                {data: "plant_id"},
                                {data: "emp_type"},
                                {data: "emp_deg"},
                                {data: "date_from"},
                                {data: "date_to"},
                                {data: "status"},
                                {data: "reason_type"},
                                {data: "reason_of_absence_by_emp"},
                                {data: "reason_acceptability"},
                                {data: "remarks"},

                            ],
                            columnDefs: [
                                {
                                    "defaultContent": " ",
                                    "targets": "_all"
                                }
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
                                                columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
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
                                                columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
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
            });



            /*Auto fill required field*/
            $('#employee_name').change(function () {
                var employee_id = $('#employee_name').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('attendenceManagementSys/attendence/getEmpInfo') }}',
                    data: {'employee_id': employee_id},
                    success: function (data) {

                        if(data.allEmpData.length > 0){
                            $('#emp_code').val(data.allEmpData[0].emp_id);
                            $('#plant_id').val(data.allEmpData[0].plant_id);

                            $('#emp_deg').val(data.allEmpData[0].desig_name);
                            $('#emp_deg').val(data.allEmpData[0].desig_name);

                            $('#dept_id').val(data.allEmpData[0].dept_id);
                            $('#dept_name').val(data.allEmpData[0].dept_id);
                            $('#section').val(data.allEmpData[0].section_id);
                            $('#emp_type').val(data.allEmpData[0].emp_type);

                            $('#wc').val(data.allEmpData[0].work_center_id);

                        }else{
                        }
                    },
                    error: function () {
                    }
                });
            });



            /*Submit Button*/
            $('#submit_form').on('click', function (e) {


                e.preventDefault();
                $("#loader").show();

                var employee_name = $('#employee_name :selected').text();
                var employee_code =  $('#emp_code').val();
                var designation = $('#emp_deg').val();
                var department = $('#dept_name').val();
                var section = $('#section').val();
                var emp_type = $('#emp_type').val();
                var plant = $('#plant_id').val();
                var wc = $('#wc').val();
                var status = $("#status option:selected").text();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                var reason_type = $("#reason_type option:selected").text();
                var reason_by_emp = $('#reason_by_emp').val();
                var reason_acceptability = $("#reason_acceptability option:selected").text();
                var remarks = $('#remarks').val();


                var dataList = {};


                dataList.emp_name=employee_name;
                dataList.emp_id=employee_code;
                dataList.emp_deg=designation;
                dataList.emp_dpt=department;
                dataList.emp_sec=section;
                dataList.emp_type=emp_type;
                dataList.plant_id=plant;
                dataList.wc=wc;
                dataList.status=status;
                dataList.date_from=date_from;
                dataList.date_to=date_to;
                dataList.reason_type=reason_type;
                dataList.REASON_OF_ABSENCE_BY_EMP=reason_by_emp;
                dataList.reason_acceptability=reason_acceptability;
                dataList.remarks=remarks;



                var dataListObject = JSON.stringify(dataList);

                if(employee_name==''||employee_name=='Select Employee')
                {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Select An Employee!!',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                    $("#loader").hide();
                    return 0;
                }else{

                    $.ajax({
                        type: 'post',
                        url: '{{  url('attendenceManagementSys/attendence/saveAttendence') }}',
                        data: { 'dataListObject': dataListObject, '_token': "{{ csrf_token
                    () }}"},
                        success: function (data) {

                            $("#loader").hide();

                            if(data.result=='success'){
                                Swal.fire({

                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Record saved successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok',
                                    timer: 3000

                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                                $("#item_issue_form").trigger('reset');
                                item_id = $('#item_id').val('');

                            }else if(data.result=='exists'){
                                Swal.fire({
                                    title: 'Warning!',
                                    text: 'User Already Exists',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok',
                                    timer: 3000
                                })
                            }
                        },
                        error: function (e) {
                            $("#loader").hide();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something was wrong! Failed to save.',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            })
                            console.log("in error")
                        }
                    });
                }
            });


            $('#ttt').on('click', function (e) {

                e.preventDefault();

                $.ajax({
                    type: 'get',
                    url: '{{  url('attendenceManagementSys/attendence/getHichartData') }}',
                    success: function (data) {

                        $("#loader").hide();
                        if(data.result=='success'){
                            Swal.fire({

                                title: 'Success!',
                                icon: 'success',
                                text: 'Record saved successfully',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',

                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                            $("#item_issue_form").trigger('reset');
                            item_id = $('#item_id').val('');

                        }else if(data.result=='exists'){
                            Swal.fire({
                                title: 'Warning!',
                                text: 'User Already Exists',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            })
                        }
                    },
                    error: function (e) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something was wrong! Failed to save.',
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        })
                        console.log("in error")
                    }
                });
            });

        });


    </script>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection