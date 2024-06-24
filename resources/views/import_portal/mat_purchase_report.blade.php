@extends('_layout_shared._master')
@section('title','SCM Material Purchase Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>

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
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-default">
                <div class="panel-heading">
                    <label class="text-default">
                        SCM Material Purchase Report
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
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
                                        <div class="col-md-4 col-sm-4">
                                            <label for="pr_num" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>PR Number</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="pr_num" name="pr_num"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected>Select PR Number</option>
                                                    @if(count($prData) > 0)
                                                        <option value="ALL">All</option>
                                                        @foreach($prData as $pr)
                                                            <option value="{{$pr->pr_num}}">{{$pr->pr_num}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="" disabled style="text-align: center">There is no data</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="type_of_doc" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Type Of Document</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select class="form-control input-sm filter-option pull-left" id="type_of_doc"
                                                        name="type_of_doc">
                                                    <option value="" selected>Select a type of document</option>
                                                    <option value="ALL">All</option>
                                                    <option value="raw">RAW</option>
                                                    <option value="pack">PACK</option>
                                                    <option value="lab">LAB</option>
                                                    <option value="service">SERVICE</option>
                                                    <option value="capital">CAPITAL</option>
                                                    <option value="spare">SPARE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-8 col-sm-8">
                                            <label for="note_sheet_receiving_date"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Note Sheet Receiving date:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="note_sheet_receiving_date" name="note_sheet_receiving_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="lc_num"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>LC Number:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-xs" id="lc_num"
                                                       name="lc_num">
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
                                    <div id="export_buttons">
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
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead style="background-color: #d6d5ff;">
                                <tr>
                                    <th>SL.</th>
                                    <th>NOTE SHEET RECEIVING DATE</th>
                                    <th>PO NUMBER</th>
                                    <th>PLANT</th>
                                    <th>PI VALUE</th>
                                    <th>CURRENCY</th>
                                    <th>PR Number</th>
                                    <th>PR DATE</th>
                                    <th>FACTORY TAKEN TIME TO COMPLETE DOCUMENT</th>
                                    <th>TYPE OF DOCUMENT</th>
                                    <th>VENDOR NAME</th>
                                    <th>CONCERN PERSON(SCM)</th>
                                    <th>PI REQUEST SEND OR CORRECTION</th>
                                    <th>TIME PASSED FOR ASKING PI</th>
                                    <th>PI REQUEST/ CORRECTION SENDING DATE</th>
                                    <th>SUPPLIER TAKEN TIME TO SHARE PI</th>
                                    <th>FINAL PI RECEIVED DATE</th>
                                    <th>TIME TAKEN FOR LC/TT/CAD REQUEST</th>
                                    <th>REQUEST FOR OPEN LC/TT/ CAD - DATE</th>
                                    <th>LC OPEN STATUS</th>
                                    <th>LC NUMBER</th>
                                    <th>TAKEN TIME TO OPEN LC</th>
                                    <th>LC DATE</th>
                                    <th>LDS DATE</th>
                                    <th>PASSING TIME</th>
                                    <th>LC SHARE</th>
                                    <th>DRAFT SHIPPING DOCUMENT RECEIVE DATE</th>
                                    <th>FINAL SHIPPING DOCUMENT RECEIVED</th>
                                    <th>TAKE TIME TO SHARE DOCUMENT</th>
                                    <th>SEND FOR ENDORSEMENT DATE</th>
                                    <th>SHIPMENT VALUE</th>
                                    <th>REMAINING</th>
                                    <th>C&F</th>
                                    <th>C&F DATE</th>
                                    <th>C&F TAKE TIME TO RELEASE</th>
                                    <th>RELEASE HS CODE</th>
                                    <th>BILL OF ENTRY NUMBER</th>
                                    <th>DELIVERY DATE</th>
                                    <th>TOTAL TAKEN TIME TO COMPLETE THE FULL PROCEDURE IN MONTHS</th>
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
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#po_num').select2();
            $('#pr_num').select2();
            $('#note_sheet_receiving_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });
            $('#btn_submit').on('click', function (e) {
                // e.preventDefault();
                $("#loader").show();

                var po_num = $('#po_num').val();
                var type_of_doc = $('#type_of_doc').val();
                var pr_num = $('#pr_num').val();
                var lc_num = $('#lc_num').val();
                var note_sheet_receiving_date = $('#note_sheet_receiving_date').val();

                // console.log(po_num);
                // console.log(type_of_doc);
                // console.log(pr_num);
                // console.log(lc_num);
                // console.log(note_sheet_receiving_date);

                if(po_num === "" && type_of_doc === "" && pr_num === "" && lc_num === "" &&
                    note_sheet_receiving_date === ""){
                    $("#loader").hide();
                    $("#showTable").hide();
                    toastr.error("Please input at least one data!");
                }else {
                    var table = null;

                    $.ajax({
                        type: 'post',
                        url: '{{  url('import_management/getSCMpurchaseMatReport') }}',
                        data: {
                            'po_num': po_num, 'type_of_doc': type_of_doc, 'pr_num': pr_num, 'lc_num': lc_num,
                            'note_sheet_receiving_date': note_sheet_receiving_date, '_token': "{{csrf_token () }}"
                        },
                        success: function (data) {
                            // console.log(data);
                            $("#showTable").show();
                            $("#loader").hide();

                            $("#elr").DataTable().destroy();

                            var i = 1;

                            table = $("#elr").DataTable({
                                data: data.result,
                                columns: [
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return i++;
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.note_sheet_receiving_date !== null){
                                                return moment(row.note_sheet_receiving_date).format('YYYY-MM-DD');
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {data: "po_num"},
                                    {data: "plant"},
                                    {data: "pi_value"},
                                    {data: "currency"},
                                    {data: "pr_num"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.pr_date !== null){
                                                return moment(row.pr_date).format('YYYY-MM-DD');
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.note_sheet_receiving_date !== null && row.pr_date!== null){
                                                var date1 = moment(row.note_sheet_receiving_date);
                                                var date2 = moment(row.pr_date);
                                                var diff = date2.diff(date1, 'days');
                                                return diff;
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {data: "type_of_doc"},
                                    {data: "vendor_name"},
                                    {data: "concern_person"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.pi_req_send_or_correction != null){
                                                return row.pi_req_send_or_correction.toUpperCase();
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.pi_req_send_or_correction === "no" && row.pi_req_send_date === null){
                                                var date = new Date();
                                                var firstDate = row.note_sheet_receiving_date;

                                                if(firstDate != null) {
                                                    var date1 = moment(firstDate);
                                                    var date2 = moment(date);
                                                    var diff = date2.diff(date1, 'days');

                                                    return "<div id='ID"+row
                                                        .id+"_timepassedforaskingpi'>"+diff+"</div>";
                                                }else{
                                                    return "<div id='ID"+row.id+"_timepassedforaskingpi'></div>";
                                                }
                                            }else if(row.pi_req_send_or_correction === "yes" || row.pi_req_send_date
                                                !== null){
                                                return "<div id='ID"+row.id+"_timepassedforaskingpi'>ASKED</div>";
                                            }else{
                                                return "<div id='ID"+row.id+"_timepassedforaskingpi'></div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.pi_req_send_date === null){
                                                return '<input type="text" autocomplete="off" class="form-control ' +
                                                    'input-sm" id="ID'+row.id+'_pi_req_send_date" onfocus="(this' +
                                                    '.type='+"'"+"date"+"'"+')" placeholder="PENDING" onblur="(this' +
                                                    '.type='+"'"+"text"+"'"+')" onchange="getPIReqSendDate(this,' +
                                                    ''+"'"+row.id+"'"+')">';
                                            }else{
                                                return "<div id='ID"+row.id+"_pi_req_send_date'>"+moment(row.pi_req_send_date).format('YYYY-MM-DD')+"</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.pi_req_send_date !== null){
                                                var date = new Date();
                                                var firstDate = row.pi_req_send_date;

                                                if(firstDate != null) {
                                                    var date1 = moment(firstDate);
                                                    var date2 = moment(date);
                                                    var diff = date2.diff(date1, 'days');

                                                    return "<div id='ID"+row
                                                        .id+"_suppliertakentimetosharepi'>"+diff+"</div>";
                                                }else{
                                                    return "<div id='ID"+row.id+"_suppliertakentimetosharepi'></div>";
                                                }
                                            }else{
                                                return "<div id='ID"+row.id+"_suppliertakentimetosharepi'></div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.final_pi_received_date === null){
                                                return '<input type="text" autocomplete="off" class="form-control ' +
                                                    'input-sm" id="ID'+row.id+'_final_pi_received_date" onfocus="' +
                                                    '(this' +
                                                    '.type='+"'"+"date"+"'"+')" placeholder="PENDING" onblur="(this' +
                                                    '.type='+"'"+"text"+"'"+')" onchange="getfinalpireceiveddate(this,' +
                                                    ''+"'"+row.id+"'"+')">';
                                            }else{
                                                return "<div id='ID"+row.id+"_final_pi_received_date'>"+moment(row.final_pi_received_date).format('YYYY-MM-DD')+"</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.final_pi_received_date !== null){
                                                var date = new Date();
                                                var firstDate = row.final_pi_received_date;

                                                if(firstDate != null) {
                                                    var date1 = moment(firstDate);
                                                    var date2 = moment(date);
                                                    var diff = date2.diff(date1, 'days');

                                                    return "<div id='ID"+row
                                                        .id+"_timetakenforlc_tt_cadreq'>"+diff+"</div>";
                                                }else{
                                                    return "<div id='ID"+row.id+"_timetakenforlc_tt_cadreq'></div>";
                                                }
                                            }else{
                                                return "<div id='ID"+row.id+"_timetakenforlc_tt_cadreq'></div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.req_for_open_lc_tt_cad_date === null){
                                                return '<input type="text" autocomplete="off" class="form-control ' +
                                                    'input-sm" id="ID'+row.id+'_reqforopenlcttcaddate" onfocus="' +
                                                    '(this' +
                                                    '.type='+"'"+"date"+"'"+')" placeholder="PENDING" onblur="(this' +
                                                    '.type='+"'"+"text"+"'"+')" onchange="getreqforopenlcttcaddate(this,' +
                                                    ''+"'"+row.id+"'"+')">';
                                            }else{
                                                return "<div id='ID"+row.id+"_reqforopenlcttcaddate'>"+moment(row.req_for_open_lc_tt_cad_date).format('YYYY-MM-DD')+"</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.lc_num === null){
                                                return "<div id='ID"+row.id+"_lcopenstatus'>PENDING</div>";
                                            }else{
                                                return "<div id='ID"+row.id+"_lcopenstatus'>OPEN</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.lc_num === null){
                                                return '<input type="text" autocomplete="off" class="form-control ' +
                                                    'input-sm" id="ID'+row.id+'_lc_num" placeholder="Input a lc ' +
                                                    'number" onchange="getLCNum(this,' +
                                                    ''+"'"+row.id+"'"+')">';
                                            }else{
                                                return "<div id='ID"+row.id+"_lc_num'>"+row.lc_num+"</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.lc_date !== null && row.req_for_open_lc_tt_cad_date !== null){
                                                var date1 = moment(row.req_for_open_lc_tt_cad_date);
                                                var date2 = moment(row.lc_date);
                                                var diff = date2.diff(date1, 'days');

                                                return "<div id='ID"+row
                                                        .id+"_takentimetoopenlc'>"+diff+"</div>";
                                            }else{
                                                return "<div id='ID"+row.id+"_takentimetoopenlc'></div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.lc_date !== null){
                                                return "<div id='ID"+row.id+"_lcDate'>"+moment(row.lc_date).format('YYYY-MM-DD')+"</div>";
                                            }else{
                                                return "<div id='ID"+row.id+"_lcDate'></div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.lds_date !== null){
                                                return moment(row.lds_date).format('YYYY-MM-DD');
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.lc_date !== null){
                                                var date = new Date();
                                                var firstDate = row.lc_date;

                                                if(firstDate != null) {
                                                    var date1 = moment(firstDate);
                                                    var date2 = moment(date);
                                                    var diff = date2.diff(date1, 'days');

                                                    return "<div id='ID"+row
                                                        .id+"_passingTime'>"+diff+"</div>";
                                                }else{
                                                    return "<div id='ID"+row.id+"_passingTime'></div>";
                                                }
                                            }else{
                                                return "<div id='ID"+row.id+"_passingTime'></div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.lc_num === null){
                                                return '<select class="form-control input-sm" id="ID'+row
                                                    .id+'_lc_share"><option value="PENDING">PENDING</option><option ' +
                                                    'value="SHARED">SHARED</option></select>';
                                            }else{
                                                return "<div id='ID"+row.id+"_lc_share'>SHARED</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.draft_ship_doc_rcv_date === null){
                                                return '<input type="text" autocomplete="off" class="form-control ' +
                                                    'input-sm" id="ID'+row.id+'_draft_ship_doc_rcv_date" onfocus="(this' +
                                                    '.type='+"'"+"date"+"'"+')" placeholder="PENDING" onblur="(this' +
                                                    '.type='+"'"+"text"+"'"+')" onchange="getdraftShipDocRcvDate' +
                                                    '(this,'+"'"+row.id+"'"+')">';
                                            }else{
                                                return "<div id='ID"+row.id+"_draft_ship_doc_rcv_date'>"+moment(row.draft_ship_doc_rcv_date).format('YYYY-MM-DD')+"</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.final_ship_doc_rcv_date === null){
                                                if(row.draft_ship_doc_rcv_date !== null) {
                                                    return '<input type="text" autocomplete="off" class="form-control ' +
                                                        'input-sm" id="ID' + row.id + '_final_ship_doc_rcv_date" onfocus="(this' +
                                                        '.type=' + "'" + "date" + "'" + ')" placeholder="PENDING" onblur="(this' +
                                                        '.type=' + "'" + "text" + "'" + ')" ' +
                                                        'onchange="getfinalShipDocRcvDate' +
                                                        '(this,' + "'" + row.id + "'" + ')">';
                                                }else{
                                                    return '<input type="text" autocomplete="off" class="form-control ' +
                                                        'input-sm" id="ID' + row.id + '_final_ship_doc_rcv_date" onfocus="(this' +
                                                        '.type=' + "'" + "date" + "'" + ')" placeholder="PENDING" onblur="(this' +
                                                        '.type=' + "'" + "text" + "'" + ')" style="display: none" onchange="getfinalShipDocRcvDate' +
                                                        '(this,' + "'" + row.id + "'" + ')">';
                                                }
                                            }else{
                                                return "<div id='ID"+row.id+"_final_ship_doc_rcv_date'>"+moment(row.final_ship_doc_rcv_date).format('YYYY-MM-DD')+"</div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.final_ship_doc_rcv_date !== null && row.draft_ship_doc_rcv_date
                                                !== null){
                                                var date = row.final_ship_doc_rcv_date;
                                                var firstDate = row.draft_ship_doc_rcv_date;

                                                var date1 = moment(firstDate);
                                                var date2 = moment(date);
                                                var diff = date2.diff(date1, 'days');

                                                return "<div id='ID"+row
                                                        .id+"_tketmetosharedoc'>"+diff+"</div>";

                                            }else{
                                                return "<div id='ID"+row.id+"_tketmetosharedoc'></div>";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.send_for_endorsemnt_date === null){
                                                return '<input type="text" autocomplete="off" class="form-control ' +
                                                    'input-sm" id="ID'+row.id+'_send_for_endorsemnt_date" onfocus="(this' +
                                                    '.type='+"'"+"date"+"'"+')" placeholder="PENDING" onblur="(this' +
                                                    '.type='+"'"+"text"+"'"+')" onchange="getSendForEndorsemntDate' +
                                                    '(this,' + "'" + row.id + "'" + ')">';
                                            }else{
                                                return "<div id='ID"+row.id+"_send_for_endorsemnt_date'>"+moment(row.send_for_endorsemnt_date).format('YYYY-MM-DD')+"</div>";
                                            }
                                        }
                                    },
                                    {data: "shipment_value"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.shipment_value !== null && row.pi_value !== null){
                                                return parseInt(row.pi_value)-parseInt(row.shipment_value);
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {data: "c_and_f"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.c_and_f_date !== null){
                                                return moment(row.c_and_f_date).format('YYYY-MM-DD');
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.delivery_date !== null && row.c_and_f_date !== null){
                                                var date1 = moment(row.c_and_f_date);
                                                var date2 = moment(row.delivery_date);
                                                var diff = date2.diff(date1, 'days');
                                                return diff;
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {data: "release_hs_code"},
                                    {data: "bill_of_entry_num"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.delivery_date !== null){
                                                return moment(row.delivery_date).format('YYYY-MM-DD');
                                            }else{
                                                return "";
                                            }
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            if(row.delivery_date !== null && row.note_sheet_receiving_date !== null){
                                                var date1 = moment(row.note_sheet_receiving_date);
                                                var date2 = moment(row.delivery_date);
                                                var diff = date2.diff(date1, 'days');
                                                return (diff/30).toFixed(3);
                                            }else{
                                                return "";
                                            }
                                        }
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
                                                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                                        21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38]
                                                },
                                                action: function (e, dt, node, config) {
                                                    exportExtension = 'Excel';
                                                    $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
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
            });
        });
        function getPIReqSendDate(e,row_id){
            if(e.value !== ""){
                $('#ID'+row_id+'_timepassedforaskingpi')[0].innerHTML = "ASKED";

                var date = new Date();
                var firstDate = e.value;

                if(firstDate != "") {
                    var date1 = moment(firstDate);
                    var date2 = moment(date);
                    var diff = date2.diff(date1, 'days');

                    $('#ID'+row_id+'_suppliertakentimetosharepi')[0].innerHTML = diff;
                }else{
                    $('#ID'+row_id+'_suppliertakentimetosharepi')[0].innerHTML = "";
                }
                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updatePIReqSendDate')}}',
                    data: {
                        value: e.value,
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            }
        }

        function getfinalpireceiveddate(e,row_id){
            if(e.value !== ""){
                var date = new Date();
                var firstDate = e.value;

                if(firstDate != "") {
                    var date1 = moment(firstDate);
                    var date2 = moment(date);
                    var diff = date2.diff(date1, 'days');

                    $('#ID'+row_id+'_timetakenforlc_tt_cadreq')[0].innerHTML = diff;
                }else{
                    $('#ID'+row_id+'_timetakenforlc_tt_cadreq')[0].innerHTML = "";
                }

                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateFinalpireceiveddate')}}',
                    data: {
                        value: e.value,
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            }
        }
        function getreqforopenlcttcaddate(e,row_id){
            if(e.value !== ""){
                var lcDate = $('#ID'+row_id+'_lcDate')[0].innerHTML;
                if(lcDate !== ""){
                    var date1 = moment(e.value);
                    var date2 = moment(lcDate);
                    var diff = date2.diff(date1, 'days');

                    $('#ID'+row_id+'_takentimetoopenlc')[0].innerHTML = diff;
                }else{
                    $('#ID'+row_id+'_takentimetoopenlc')[0].innerHTML = "";
                }
                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateReqforopenlcttcaddate')}}',
                    data: {
                        value: e.value,
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            }else{
                $('#ID'+row_id+'_takentimetoopenlc')[0].innerHTML = "";
            }
        }
        function getLCNum(e,row_id){
            if(e.value !== ""){
                $('#ID'+row_id+'_lcopenstatus')[0].innerHTML = "OPEN";
                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateLcOpenStatus')}}',
                    data: {
                        lc_num: e.value,
                        value: "Opened",
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            }else{
                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateLcOpenStatus')}}',
                    data: {
                        lc_num: "",
                        value: "Not Opened",
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
                $('#ID'+row_id+'_lcopenstatus')[0].innerHTML = "PENDING";
            }
        }
        function getdraftShipDocRcvDate(e,row_id){
            if(e.value !== ""){
                $('#ID'+row_id+'_final_ship_doc_rcv_date').css('display','block');
                var final_ship_doc_rcv_date = $('#ID'+row_id+'_final_ship_doc_rcv_date').val();
                if(final_ship_doc_rcv_date !== ""){
                    var date1 = moment(e.value);
                    var date2 = moment(final_ship_doc_rcv_date);
                    var diff = date2.diff(date1, 'days');
                    $('#ID'+row_id+'_tketmetosharedoc')[0].innerHTML = diff;
                }else{
                    $('#ID'+row_id+'_tketmetosharedoc')[0].innerHTML = "";
                }
                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateDraftShipDocRcvDate')}}',
                    data: {
                        value: e.value,
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            }else{
                $('#ID'+row_id+'_tketmetosharedoc')[0].innerHTML = "";
            }
        }
        function getfinalShipDocRcvDate(e,row_id){
            if(e.value !== ""){
                $('#ID'+row_id+'_send_for_endorsemnt_date').css('display','block');
                var draft_ship_doc_rcv_date = $('#ID'+row_id+'_draft_ship_doc_rcv_date').val();
                if(draft_ship_doc_rcv_date !== ""){
                    var date1 = moment(draft_ship_doc_rcv_date);
                    var date2 = moment(e.value);
                    var diff = date2.diff(date1, 'days');
                    $('#ID'+row_id+'_tketmetosharedoc')[0].innerHTML = diff;
                }else{
                    $('#ID'+row_id+'_tketmetosharedoc')[0].innerHTML = "";
                }
                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateFinalShipDocRcvDate')}}',
                    data: {
                        value: e.value,
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            }else{
                $('#ID'+row_id+'_tketmetosharedoc')[0].innerHTML = "";
            }
        }
        function getSendForEndorsemntDate(e,row_id){
            if(e.value !== ""){
                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateSendForEndorsemntDate')}}',
                    data: {
                        value: e.value,
                        rowID: row_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endsection

@section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection