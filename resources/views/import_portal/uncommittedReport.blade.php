@extends('_layout_shared._master')
@section('title','Capex Uncommitted Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ url('public/site_resource/js/xlsx.full.min.js')}}"></script>
    <style>
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

        .tableFixHead {
            overflow-y: auto;
            max-height: 600px;
        }
        .tableFixHead thead th {
            position: sticky !important;
            top: 0;
            background-color: #d6d5ff;
        }
        .tableFixHead tbody #lastRowDiv {
            position: sticky !important;
            top: 56px;
            background-color: #d0ffb3;
        }
        table {
            position: relative;
            border-collapse: collapse;
            width: 100%;
        }
        th,td {
            font-size: 12px;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-default">
                <div class="panel-heading">
                    <label class="text-default">
                        Capex Uncommitted Report
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="po_num"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>PO Number</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="po_num" name="po_num"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected value="">Select PO Number</option>
                                                    @if(count($poData) > 0)
                                                        <option value="ALL">All</option>
                                                        @foreach($poData as $po)
                                                            <option value="{{$po->po_num}}">{{$po->po_num}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="" disabled style="text-align: center">There is no data</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <label for="acc_date"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Acceptance date:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" autocomplete="off" class="form-control input-sm"
                                                       id="acc_date" name="acc_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="payment_status" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Payment Status</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select class="form-control input-sm filter-option pull-left" id="payment_status"
                                                        name="payment_status">
                                                    <option value="blank" selected>Due</option>
                                                    <option value="paid">Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6">
                                            <label for="due_date_act_from"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Due Month Actual (From):</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" autocomplete="off" class="form-control input-sm"
                                                       id="due_date_act_from" name="due_date_act_from">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for="due_date_act_to"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Due Month Actual (To):</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" autocomplete="off" class="form-control input-sm"
                                                       id="due_date_act_to" name="due_date_act_to">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 col-xs-6">
                                    <button type="button" id="btn_submit" class="btn btn-warning btn-sm" style="float: right;">
                                        <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <div id="export_buttons" style="display: none;">
                                        <button type='button' class="btn
                                    btn-info btn-sm" onclick="ExportToExcel('xlsx')" style="font-weight: 700;" ><i
                                                    class="fa fa-download" style="color:white;"></i> Export as
                                            excel</button>
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
            </div>
        </div>
    </div>

    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive tableFixHead" >
                            <table id="elr" class="table table-bordered table-condensed table-striped">
                                <thead>
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
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#po_num').select2();
            $('#acc_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });
            $('#due_date_act_from').datepicker({
                format: "M-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose:true
            });
            $('#due_date_act_to').datepicker({
                format: "M-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose:true
            });
            $("#acc_date").change(function() {
                if($("#acc_date").val() !== ''){
                    $('#due_date_act_from').attr('disabled',true);
                    $('#due_date_act_to').attr('disabled',true);
                }else{
                    $('#due_date_act_from').attr('disabled',false);
                    $('#due_date_act_to').attr('disabled',false);
                }
            });
            $("#due_date_act_from").change(function() {
                if($("#due_date_act_from").val() !== '' || $("#due_date_act_to").val() !== ''){
                    $('#acc_date').attr('disabled',true);
                }else{
                    $('#acc_date').attr('disabled',false);
                }
            });
            $("#due_date_act_to").change(function() {
                if($("#due_date_act_from").val() !== '' || $("#due_date_act_to").val() !== ''){
                    $('#acc_date').attr('disabled',true);
                }else{
                    $('#acc_date').attr('disabled',false);
                }
            });
            $('#btn_submit').on('click', function (e) {
                $("#loader").show();
                $('#showTable').hide();
                $('#export_buttons').hide();

                var po_num = $('#po_num').val();
                var acc_date = $('#acc_date').val();
                var payment_status = $('#payment_status').val();
                var due_date_act_from = $('#due_date_act_from').val();
                var due_date_act_to = $('#due_date_act_to').val();
                var checkdateFrom = new Date(due_date_act_from);
                var checkdateTo = new Date(due_date_act_to);

                if(po_num === "" && acc_date === "" && payment_status === "" && due_date_act_from === "" && due_date_act_to === ""){
                    $("#loader").hide();
                    toastr.error("Please input at least one data!");
                }else {
                    if(po_num === ""){
                        $("#loader").hide();
                        toastr.error("You must select a po num");
                    }else if (due_date_act_from !== "" && due_date_act_to === "") {
                        $("#loader").hide();
                        toastr.error("You must choose a date range");
                    } else if (due_date_act_from === "" && due_date_act_to !== "") {
                        $("#loader").hide();
                        toastr.error("You must choose a date range");
                    } else if (due_date_act_from !== "" && due_date_act_to !== "" && (checkdateFrom >= checkdateTo)) {
                        $("#loader").hide();
                        toastr.error("First date must be greater than the second date!");
                    }else if (po_num === "ALL" && (due_date_act_from === "" && due_date_act_to === "" && acc_date === "")) {
                        $("#loader").hide();
                        toastr.error("For all PO number, you must choose a date range or acceptance date");
                    } else {
                        $.ajax({
                            type: 'post',
                            url: '{{  url('import_management/getUncommittedReport') }}',
                            data:{'po_num':po_num, 'acc_date':acc_date, 'payment_status':payment_status,
                                'due_date_act_from':due_date_act_from,'due_date_act_to':due_date_act_to, '_token':"{{csrf_token () }}"},
                            success: function (data) {
                                // console.log(data);
                                if (data.result.length > 0) {
                                    $('#export_buttons').show();
                                    if (data.acc_date == 0) {
                                        var timeArr = data.timeArr;
                                        var theadhtml = "";
                                        theadhtml += "<tr>";
                                        theadhtml += "<th>Com/Plant</th>";

                                        for (var i = 0; i < timeArr.length; i++) {
                                            theadhtml += "<th>" + timeArr[i]['month_year'] + "</th>";
                                        }
                                        theadhtml += "<th>Grand Total</th>";
                                        theadhtml += "</tr>";
                                        $('#elr thead').html(theadhtml);

                                        tbodyhtml = "";
                                        var totalGrandTotal = 0;

                                        tbodyhtml += "<tr id='lastRowDiv' style='background-color: #d0ffb3 " +
                                            "!important'>";
                                        for (var p = 0; p < data.lastRow.length; p++) {
                                            tbodyhtml += "<td style='font-weight: bolder'>" + data.lastRow[p] + "</td>";
                                        }
                                        tbodyhtml += "<td style='font-weight: bolder' id='lastRowGrandTotal'></td>";
                                        tbodyhtml += "</tr>";

                                        for (var j = 0; j < data.result.length; j++) {
                                            var totalAccptValueInBDT = 0;
                                            tbodyhtml += "<tr>";
                                            tbodyhtml += "<td>" + data.result[j]['com_or_plant'] + "</td>";
                                            var dataResult = data.result[j]['result'];
                                            for (var z = 0; z < dataResult.length; z++) {
                                                if (dataResult[z]['result'].length > 0) {
                                                    var bdt_value = 0;
                                                    for (var y = 0; y < dataResult[z]['result'].length; y++) {
                                                        if(dataResult[z]['result'][y]['bdt_value'] != null){
                                                            bdt_value = parseFloat(bdt_value) + parseFloat(dataResult[z]['result'][y]['bdt_value']);
                                                        }
                                                    }
                                                    totalAccptValueInBDT = parseFloat(totalAccptValueInBDT) + parseFloat(bdt_value);
                                                    tbodyhtml += "<td>" + bdt_value + "</td>";
                                                } else {
                                                    tbodyhtml += "<td></td>";
                                                }
                                            }
                                            if (totalAccptValueInBDT == 0) {
                                                tbodyhtml += "<td></td>";
                                            } else {
                                                tbodyhtml += "<td>" + totalAccptValueInBDT + "</td>";
                                            }
                                            tbodyhtml += "</tr>";
                                            totalGrandTotal = parseFloat(totalGrandTotal) + parseFloat(totalAccptValueInBDT);
                                        }
                                        $('#elr tbody').html(tbodyhtml);

                                        if (totalGrandTotal == 0) {
                                            $('#lastRowGrandTotal')[0].innerHTML = "";
                                        } else {
                                            $('#lastRowGrandTotal')[0].innerHTML = totalGrandTotal;
                                        }

                                    } else {
                                        var timeArr = data.timeArr;
                                        var theadhtml = "";
                                        theadhtml += "<tr>";
                                        theadhtml += "<th>Com/Plant</th>";
                                        for (var i = 0; i < timeArr.length; i++) {
                                            theadhtml += "<th>" + timeArr[i]['month_year'] + "</th>";
                                        }
                                        theadhtml += "</tr>";
                                        $('#elr thead').html(theadhtml);

                                        tbodyhtml = "";

                                        tbodyhtml += "<tr id='lastRowDiv' style='background-color: #d0ffb3 !important'>";
                                        for (var p = 0; p < data.lastRow.length; p++) {
                                            tbodyhtml += "<td style='font-weight: bolder'>" + data.lastRow[p] + "</td>";
                                        }
                                        tbodyhtml += "</tr>";

                                        for (var j = 0; j < data.result.length; j++) {
                                            tbodyhtml += "<tr>";
                                            tbodyhtml += "<td>" + data.result[j]['com_or_plant'] + "</td>";
                                            var dataResult = data.result[j]['result'];
                                            for (var z = 0; z < dataResult.length; z++) {
                                                if (dataResult[z]['result'].length > 0) {
                                                    var bdt_value = 0;
                                                    for (var y = 0; y < dataResult[z]['result'].length; y++) {
                                                        if (dataResult[z]['result'][y]['bdt_value'] != null) {
                                                            bdt_value = parseFloat(bdt_value) + parseFloat(dataResult[z]['result'][y]['bdt_value']);
                                                        }
                                                    }
                                                    tbodyhtml += "<td>" + bdt_value + "</td>";
                                                } else {
                                                    tbodyhtml += "<td></td>";
                                                }
                                            }
                                            tbodyhtml += "</tr>";
                                        }
                                        $('#elr tbody').html(tbodyhtml);
                                    }
                                    $('#elr').dataTable();

                                    $('#showTable').show();
                                } else {
                                    $('#elr tbody').html('<p style="color: red">There is no data available.</p>');
                                    $('#elr').css('text-align', 'center');
                                    $('#showTable').show();
                                }
                                $("#loader").hide();
                            }
                            ,
                            error: function (e) {
                                console.log(e);
                                $("#loader").hide();
                            }
                        })
                        ;
                    }
                }
            });
        });
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('elr');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1", raw: true });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('uncommitted_capex.' + (type || 'xlsx')));
        }
    </script>
    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection