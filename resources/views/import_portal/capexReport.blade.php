@extends('_layout_shared._master')
@section('title','Capex Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #btn_refresh {
            color: #fff;
            background-color: #4796ad !important;
            border-color: #4796ad !important;
        }
        #btn_refresh:focus {
            outline: none !important;
        }
        #btn_update {
            background-color: #ff4300d1 !important;
            border-color: #ff4300d1 !important;
            color: #FFFFFF;
        }
        #btn_update:focus {
            outline: none !important;
        }
        .main-content{
            height: 100% !important;
        }
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px
        }

        .select2 { text-transform: uppercase; }

        . {
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
            font-size: 12px;
        }

        body {
            color: black;
        }

        label {
            font-size: 12px;
        }

        input, select {
            color: #000000;
            padding: 3px;
            border: 1px solid #ccc;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2-container .select2-selection--single {
            font-size: 12px;
            height: auto !important;
        }
        .select2-container{
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            /*color: #444;*/
            line-height: 24px !important;
            border-color: #ccc;
        }
        .select2-container--default .select2-selection--single{
            border-radius: 0px;
        }

        .field-h {
            font-size: 11px;
            resize: both;
            /*background: #ffd73e33;*/
            border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg' %3E %3Cstyle%3Epath%7Banimation:stroke 5s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='red' /%3E%3Cstop offset='25%25' stop-color='red' /%3E%3Cstop offset='50%25' stop-color='red' /%3E%3Cstop offset='100%25' stop-color='red' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
        }

        .input-xs {
            height: 27px;
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 1px;
        }

        .input-group-xs > .form-control,
        .input-group-xs > .input-group-addon,
        .input-group-xs > .input-group-btn > .btn {
            height: 23px;
            padding: 2px 5px;
            font-size: 12px;
            /*line-height: 1.5;*/
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

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove #cc5495 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #cc5495;
        }

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #337AC7;
        }

        .cls-req{
            color: red;
            font-weight: bold;
        }

        .panel-heading label{
            font-size: 14px;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Capex Report
                    </label>
                </header>
                <div class="panel-body" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="col-md-3 col-sm-3">
                                    <label for="plant"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Plant</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="plant"
                                                name="plant">
                                            <option value="">Select Plant</option>
                                            @if(count($plants) > 0)
                                                <option value="All">All</option>
                                                @foreach($plants as $plant)
                                                    <option value="{{$plant->plant_id}}">{{$plant->plant_id}}
                                                        - {{$plant->plant_name}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="po_num"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>PO Number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="po_num"
                                                name="po_num">
                                            <option value="">Select PO number</option>
                                            @if(count($poData) > 0)
                                                <option value="All">All</option>
                                                @foreach($poData as $po)
                                                    <option value="{{$po->po_num}}">{{$po->po_num}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="pr_num" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>PR Number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select id="pr_num" name="pr_num"
                                                class="form-control input-xs filter-option pull-left">
                                            <option value="" selected>Select PR number</option>
                                            @if(count($prData) > 0)
                                                <option value="All">All</option>
                                                @foreach($prData as $pr)
                                                    <option value="{{$pr->pr_num}}">{{$pr->pr_num}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="line_item" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Line Item</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select class="form-control input-xs filter-option pull-left" id="line_item"
                                                name="line_item">
                                            <option value="" selected>Select line item</option>
                                            @if(count($lineItem) > 0)
                                                <option value="All">All</option>
                                                @foreach($lineItem as $item)
                                                    <option value="{{$item->line_item}}">{{$item->line_item}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="col-md-3 col-sm-3">
                                    <label for="lc_num"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>LC number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="lc_num"
                                                name="lc_num">
                                            <option value="">Select LC</option>
                                            @if(count($lcNo) > 0)
                                                <option value="All">All</option>
                                                @foreach($lcNo as $lc)
                                                    <option value="{{$lc->lc_number}}">{{$lc->lc_number}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="concern_person"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Concern person</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="concern_person"
                                                name="concern_person">
                                            <option value="">Select concern person</option>
                                            @if(count($concernPerson) > 0)
                                                <option value="All">All</option>
                                                @foreach($concernPerson as $person)
                                                    <option value="{{$person->id}}">{{$person->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 col-xs-6">
                            <button type="button" id="btn_display" class="btn btn-warning btn-sm" style="float: right;">
                                <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <div id="export_buttons">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
                        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                            <div class="panel">
                                <img src="<?php echo e(url('public/site_resource/images/preloader.gif')); ?>"
                                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                                <span><b><i>Please wait...</i></b></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row" id="updateTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        UPDATE DATA
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="updateMyTable">
                            <input type="hidden" id = 'update_row_ids' value="">
                            <thead style="background-color: #c5e4f2;">
                            <tr>
                                <th class="text-center">PLANT</th>
                                <th class="text-center">CONCERN PERSON(SCM)</th>
                                <th class="text-center">PR NUMBER</th>
                                <th class="text-center">PR DATE</th>
                                <th class="text-center">CER (CAPITAL EXPENDITURE REQUEST) DATE</th>
                                <th class="text-center">TAKING TIME TO CREATE PR FROM CER</th>
                                <th class="text-center">TRACKING NUMBER</th>
                                <th class="text-center">DESCRIPTION</th>
                                <th class="text-center">PI VALUE</th>
                                <th class="text-center">CURRENCY</th>
                                <th class="text-center">NOTE SHEET SENDING DATE</th>
                                <th class="text-center">PRIORITY</th>
                                <th class="text-center">NOTE SHEET RECEIVING DATE</th>
                                <th class="text-center">TAKEN TIME TO PROCESS NOTESHEET</th>
                                <th class="text-center">PO NUMBER</th>
                                <th class="text-center">PO VALUE</th>
                                <th class="text-center">TYPE OF DOCUMENT</th>
                                <th class="text-center">SHIPMENT MODE</th>
                                <th class="text-center">VENDOR NAME</th>
                                <th class="text-center">LOCAL AGENT</th>
                                <th class="text-center">USER/RECEIVER NAME</th>
                                <th class="text-center">RECEIVER MAIL ADDRESS</th>
                                <th class="text-center">PI REQUEST SEND OR CORRECTION</th>
                                <th class="text-center">TIME TAKEN TO ASK PI</th>
                                <th class="text-center">PI REQUEST/CORRECTION SENDING DATE</th>
                                <th class="text-center">VENDOR TAKEN TIME TO SHARE PI</th>
                                <th class="text-center">FINAL PI RECEIVED DATE</th>
                                <th class="text-center">REQUEST FOR OPEN LC/TT/CAD DATE</th>
                                <th class="text-center">LC/TT/CAD SHARE</th>
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
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
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
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}}

    <script>
        $(document).ready(function () {
            $('#plant').select2();
            $('#po_num').select2();
            $('#pr_num').select2();
            $('#line_item').select2();
            $('#concern_person').select2();
            $('#lc_num').select2();

            $('#t_plant').select2();
            $('#currency').select2();
            $('#priority').select2();
            $('#type_of_doc').select2();
            $('#mat_heading').select2();
            $('#shipment_mode').select2();
            $('#vendor_name').select2();
            $('#local_agent').select2();
            $('#t_concern_person').select2();
            $('#pi_req_send').select2();
            $('#lc_share').select2();

            $('#btn_display').on('click', function () {
                var table;
                if($('#plant').val() === "" && $('#po_num').val() === "" && $('#pr_num').val() === "" && $
                    ('#line_item').val() === "" && $('#lc_num').val() === ""
                    && $('#concern_person').val() === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose at least one data!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                }else{
                    $('#loader').show();
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/retrieveCapexInfo')}}',
                        data: {
                            plant: $('#plant').val(),
                            po_num: $('#po_num').val(),
                            pr_num: $('#pr_num').val(),
                            line_item: $('#line_item').val(),
                            lc_num: $('#lc_num').val(),
                            concern_person: $('#concern_person').val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {

                            if ($.fn.dataTable.isDataTable( '#updateMyTable' ) ) {
                                $("#updateMyTable").DataTable().destroy();
                            }

                            $("#updateMyTable tbody").html("");

                            var res = response.result;

                            if(res.length > 0){
                                var tr = '';
                                var rowIds = [];

                                for(var i = 0; i < res.length; i++){

                                    rowIds.push(res[i]['id']);

                                    tr += '<tr id="tableRow_id_'+res[i]['id']+'" class="rowCount">';

                                    tr += '<td>'+res[i]['plant']+'</td>';

                                    if(res[i]['concern_person'] != null){
                                        tr += '<td>'+res[i]['concern_person']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    tr += '<td>'+res[i]['pr_num']+'</td>';

                                    if(res[i]['pr_date'] != null){
                                        tr += '<td><p style="width: 120px;">'+moment(res[i]['pr_date']).format('YYYY-MM-DD')+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['cer_date'] != null){
                                        tr += '<td>'+moment(res[i]['cer_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['cer_date'] != null && res[i]['pr_date'] != null){
                                        var startDate = moment(res[i]['pr_date']);
                                        var endDate = moment(res[i]['cer_date']);
                                        var resultDays = endDate.diff(startDate, 'days');
                                        tr += '<td>'+resultDays+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['tracking_num'] != null){
                                        tr += '<td>'+res[i]['tracking_num']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['description'] != null){
                                        tr += '<td>'+res[i]['description']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_value'] != null){
                                        tr += '<td>'+res[i]['pi_value']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['currency'] != null){
                                        tr += '<td>'+res[i]['currency']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['note_send_date'] != null){
                                        tr += '<td>'+moment(res[i]['note_send_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['priorty'] != null){
                                        tr += '<td>'+res[i]['priorty']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['note_rcv_date'] != null){
                                        tr += '<td>'+moment(res[i]['note_rcv_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['note_rcv_date'] != null && res[i]['note_send_date'] != null){
                                        var startDate = moment(res[i]['note_send_date']);
                                        var endDate = moment(res[i]['note_rcv_date']);
                                        var resultDays = endDate.diff(startDate, 'days');
                                        tr += '<td>'+resultDays+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['po_num'] != null){
                                        tr += '<td>'+res[i]['po_num']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['po_value'] != null){
                                        tr += '<td>'+res[i]['po_value']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['type_of_doc'] != null){
                                        tr += '<td>'+res[i]['type_of_doc']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['ship_mode'] != null){
                                        tr += '<td><p style="width: 200px;">'+res[i]['ship_mode']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['vendor_name'] != null){
                                        tr += '<td><p style="width: 200px;">'+res[i]['vendor_name']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['agent_name'] != null){
                                        tr += '<td><p style="width: 220px;">'+res[i]['agent_name']+' - ' +
                                            ''+res[i]['agent_num']+' - '+res[i]['agent_email']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['user_rcv_name'] != null){
                                        tr += '<td>'+res[i]['user_rcv_name']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['user_rcv_email'] != null){
                                        tr += '<td><p style="width: 150px;">'+res[i]['user_rcv_email']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_req_send'] != null){
                                        tr += '<td>'+res[i]['pi_req_send']+'</td>';
                                    }else{
                                        tr += '<td>PENDING</td>';
                                    }

                                    tr += '<td>CALCULATION BUJINAI</td>';

                                    if(res[i]['pi_req_send_date'] != null){
                                        tr += '<td>'+moment(res[i]['pi_req_send_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['final_pi_rcv_date'] != null && res[i]['pi_req_send_date'] != null){
                                        var startDate = moment(res[i]['pi_req_send_date']);
                                        var endDate = moment(res[i]['final_pi_rcv_date']);
                                        var resultDays = endDate.diff(startDate, 'days');
                                        tr += '<td>'+resultDays+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['final_pi_rcv_date'] != null){
                                        tr += '<td>'+moment(res[i]['final_pi_rcv_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td>PENDING</td>';
                                    }

                                    if(res[i]['req_lc_tt_cad_date'] != null){
                                        tr += '<td>'+moment(res[i]['req_lc_tt_cad_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_tt_cad_share'] != null){
                                        tr += '<td>'+res[i]['lc_tt_cad_share']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    tr += '</tr>';
                                }

                                var finalRowIds = JSON.stringify(rowIds);
                                $('#updateMyTable #update_row_ids').val(finalRowIds);
                                $('#updateMyTable tbody').html(tr);
                                $('#updateTableDiv').show();
                            }else{
                                var tr = '';
                                tr += '<tr style="text-align: center;color: red">';
                                tr += '<td colspan="29">There is no data available!</td>';
                                tr += '</tr>';
                                $('#updateMyTable tbody').html(tr);
                                $('#updateTableDiv').show();
                            }
                            $('#loader').hide();

                            table = $("#updateMyTable").DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'copyHtml5',
                                    'csvHtml5',
                                    {
                                        extend: 'excelHtml5',
                                        header: true,
                                        footer: true,
                                        text: 'Excel',
                                        title: 'Capex_report',
                                        exportOptions : {
                                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
                                                18, 19, 20, 21, 22, 23 ,24, 25, 26, 27, 28]
                                        },
                                        action: function (e, dt, node, config) {
                                            exportExtension = 'Excel';
                                            $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                        }
                                    }
                                ],
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                info: true,
                                paging: true,
                                filter: true
                            });
                        },
                        error: function (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Unable to fetch data!',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            });
                            console.log(error);
                            $('#loader').hide();
                            $('#updateTableDiv').hide();
                        }
                    })
                }
            });
        });
    </script>
@endsection
