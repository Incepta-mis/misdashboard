@extends('_layout_shared._master')
@section('title','Finance Report')
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
                        Finance Report
                    </label>
                </header>
                <div class="panel-body" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="col-md-3 col-sm-3">
                                    <label for="product_type"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Product type</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="product_type"
                                                name="product_type">
                                            <option value="">Select type</option>
                                            <option value="capex">Capex</option>
                                            <option value="raw_pack">Raw-Pack</option>
                                        </select>
                                    </div>
                                </div>
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
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
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
                                <div class="col-md-3 col-sm-3">
                                    <label for="amount" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Amount</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="number" id="amount" name="amount" class="form-control input-xs"
                                               value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12" style="text-align: center;margin-top: 20px">
                            <button type="button" id="btn_display" class="btn btn-warning btn-sm"> <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
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
    <div class="row" id="CapexTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Capex Data
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="CapexTable">
                            <thead style="background-color: #c4c5ff;">
                            <tr>
                                <th class="text-center">Year</th>
                                <th class="text-center">Month</th>
                                <th class="text-center">PI Decision Date</th>
                                <th class="text-center">PR Number</th>
                                <th class="text-center">PO number</th>
                                <th class="text-center">LC open year</th>
                                <th class="text-center">LC open month</th>
                                <th class="text-center">LC open date</th>
                                <th class="text-center">LC Number</th>
                                <th class="text-center">Bank</th>
                                <th class="text-center">LC open status</th>
                                <th class="text-center">Com/Plant</th>
                                <th class="text-center">Material type</th>
                                <th class="text-center">Material</th>
                                <th class="text-center">Terms of payment</th>
                                <th class="text-center">Currency</th>
                                <th class="text-center">FC value</th>
                                <th class="text-center">BDT value</th>
                                <th class="text-center">BDT in million</th>
                                <th class="text-center">Beneficiary</th>
                                <th class="text-center">Payment terms</th>
                                <th class="text-center">Material status</th>
                                <th class="text-center">Tentative received month</th>
                                <th class="text-center">Tentative due month</th>
                                <th class="text-center">Received date</th>
                                <th class="text-center">Acceptance date</th>
                                <th class="text-center">Due date actual</th>
                                <th class="text-center">Due month actual</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Payment date</th>
                                <th class="text-center">Payment month</th>
                                <th class="text-center">Country</th>
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
    <div class="row" id="RawPackTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Raw-pack Data
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="RawPackTable">
                            <thead style="background-color: #c4c5ff;">
                            <tr>
                                <th class="text-center">Year</th>
                                <th class="text-center">Month</th>
                                <th class="text-center">PI Decision Date</th>
                                <th class="text-center">PI/Indent</th>
                                <th class="text-center">LC open month</th>
                                <th class="text-center">LC open date</th>
                                <th class="text-center">LC Number</th>
                                <th class="text-center">Bank</th>
                                <th class="text-center">LC open status</th>
                                <th class="text-center">Com/Plant</th>
                                <th class="text-center">Material type</th>
                                <th class="text-center">Material</th>
                                <th class="text-center">Terms of payment</th>
                                <th class="text-center">LC type</th>
                                <th class="text-center">PI date</th>
                                <th class="text-center">PI/Indent value at sight</th>
                                <th class="text-center">Currency</th>
                                <th class="text-center">FC value</th>
                                <th class="text-center">BDT value</th>
                                <th class="text-center">Beneficiary</th>
                                <th class="text-center">Quoted price</th>
                                <th class="text-center">Payment terms</th>
                                <th class="text-center">Acceptance date</th>
                                <th class="text-center">Due date actual</th>
                                <th class="text-center">Due month actual</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Payment date</th>
                                <th class="text-center">Payment month</th>
                                <th class="text-center">Country</th>
                                <th class="text-center">BDT in million</th>
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
            $('#product_type').select2();
            $('#plant').select2();
            $('#po_num').select2();
            $('#line_item').select2();
            $('#lc_num').select2();

            $('#btn_display').on('click', function () {
                var table;
                if($('#product_type').val() === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'You must choose a product type!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                }else {
                    $('#loader').show();
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/retrieveFinanceReport')}}',
                        data: {
                            product_type: $('#product_type').val(),
                            plant: $('#plant').val(),
                            po_num: $('#po_num').val(),
                            line_item: $('#line_item').val(),
                            lc_num: $('#lc_num').val(),
                            amount: $('#amount').val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            // console.log(response);

                            $('#CapexTableDiv').hide();
                            $('#RawPackTableDiv').hide();

                            if(response.product_type === 'capex'){
                                var res = response.result;
                                if(res.length > 0){

                                    if ($.fn.dataTable.isDataTable( '#CapexTable' ) ) {
                                        $("#CapexTable").DataTable().destroy();
                                    }
                                    $("#CapexTable tbody").html("");

                                    var tr = '';

                                    for(var i = 0; i < res.length; i++){

                                        tr += '<tr class="rowCount">';

                                        if(res[i]['pi_dec_date'] != null){
                                            tr += '<td>'+moment(res[i]['pi_dec_date']).format('YYYY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_dec_date'] != null){
                                            tr += '<td>'+moment(res[i]['pi_dec_date']).format('MMMM')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_dec_date'] != null){
                                            tr += '<td>'+moment(res[i]['pi_dec_date']).format('MM/DD/YYYY')
                                                +'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pr_num'] != null){
                                            tr += '<td>'+res[i]['pr_num']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['po_num'] != null){
                                            tr += '<td>'+res[i]['po_num']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_date'] != null){
                                            tr += '<td>'+moment(res[i]['lc_date']).format('YYYY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_date'] != null){
                                            tr += '<td>'+moment(res[i]['lc_date']).format('MMMM')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_date'] != null){
                                            tr += '<td><p style="width: 65px;">'+moment(res[i]['lc_date']).format
                                            ('MM/DD/YYYY')+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_number'] != null){
                                            tr += '<td>'+res[i]['lc_number']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['bank_name'] != null){
                                            tr += '<td><p style="width: 120px">'+res[i]['bank_name']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_number'] != null){
                                            tr += '<td>Opened</td>';
                                        }else{
                                            tr += '<td>Not Opened</td>';
                                        }

                                        if(res[i]['com_facility'] != null){
                                            tr += '<td>'+res[i]['com_facility']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['mat_heading'] != null){
                                            tr += '<td><p style="width:  200px;">'+res[i]['mat_heading']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['mat_desc'] != null){
                                            tr += '<td><p style="width:  200px;">'+res[i]['mat_desc']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['terms_of_pay'] != null){
                                            tr += '<td>'+res[i]['terms_of_pay']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['currency'] != null){
                                            tr += '<td>'+res[i]['currency']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_value'] != null){
                                            tr += '<td>'+parseFloat(res[i]['pi_value']).toLocaleString("en-US")+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                            var curr_rate = res[i]['currency_rate'];
                                            var getBDTval = parseFloat(res[i]['pi_value'])*parseFloat
                                            (res[i]['currency_rate']);
                                            tr += '<td>'+getBDTval.toLocaleString("en-US")+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                            var curr_rate = res[i]['currency_rate'];
                                            var getBDTvalinMill = (parseFloat(res[i]['pi_value'])*parseFloat
                                            (res[i]['currency_rate']))/1000000;
                                            tr += '<td>'+getBDTvalinMill+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['vendor_name'] != null){
                                            tr += '<td><p style="width:200px;">'+res[i]['vendor_name']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pay_terms'] != null){
                                            tr += '<td>'+res[i]['pay_terms']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['bank_deli_date'] != null){
                                            tr += '<td>Rec</td>';
                                        }else{
                                            tr += '<td>Not Rec</td>';
                                        }

                                        if(res[i]['bank_deli_date'] != null){
                                            tr += '<td>'+ moment(res[i]['bank_deli_date']).format('MMM/YY') +'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['bank_deli_date'] != null && res[i]['pay_terms'] != null){
                                            var payterms = parseInt(res[i]['pay_terms']);
                                            var tentDueMonths = moment(res[i]['bank_deli_date']).add(payterms,'days');

                                            tr += '<td>'+ moment(tentDueMonths).format('MMM-YY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['bank_deli_date'] != null){
                                            tr += '<td>'+moment(res[i]['bank_deli_date']).format('DD-MMM-YY')
                                                +'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['accept_date'] != null){
                                            tr += '<td>'+moment(res[i]['accept_date']).format('DD-MMM-YY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['due_date_actual'] != null){
                                            tr += '<td>'+moment(res[i]['due_date_actual']).format('DD-MMM-YY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['due_date_actual'] != null){
                                            tr += '<td>'+moment(res[i]['due_date_actual']).format('MMM-YY')+'</td>';
                                        }else{
                                            if(res[i]['bank_deli_date'] != null && res[i]['pay_terms'] != null){
                                                var payterms = parseInt(res[i]['pay_terms']);
                                                var tentDueMonths = moment(res[i]['bank_deli_date']).add(payterms,'days');

                                                tr += '<td>'+ moment(tentDueMonths).format('MMM-YY')+'</td>';
                                            }else{
                                                tr += '<td></td>';
                                            }
                                        }

                                        if(res[i]['payment_date'] != null){
                                            tr += '<td>PAID</td>';
                                        }else{
                                            tr += '<td>DUE</td>';
                                        }

                                        if(res[i]['payment_date'] != null){
                                            tr += '<td>'+moment(res[i]['payment_date']).format('DD-MMM-YY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['payment_date'] != null){
                                            tr += '<td>'+moment(res[i]['payment_date']).format('MMMM')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['origin_country'] != null){
                                            tr += '<td><p style="width: 200px">'+res[i]['origin_country']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        tr += '</tr>';
                                    }

                                    $('#CapexTable tbody').html(tr);
                                    $('#CapexTableDiv').show();

                                    table = $("#CapexTable").DataTable({
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
                                                        18, 19, 20, 21, 22, 23 ,24, 25, 26, 27, 28, 29, 30, 31]
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
                                }else{
                                    var tr = '';
                                    tr += '<tr style="text-align: center;color: red">';
                                    tr += '<td colspan="32">There is no data available!</td>';
                                    tr += '</tr>';
                                    $('#CapexTable tbody').html(tr);
                                    $('#CapexTableDiv').show();
                                }
                                $('#loader').hide();
                            }else{
                                var res = response.result;
                                if(res.length > 0){

                                    if ($.fn.dataTable.isDataTable( '#RawPackTable' ) ) {
                                        $("#RawPackTable").DataTable().destroy();
                                    }
                                    $("#RawPackTable tbody").html("");

                                    var tr = '';

                                    for(var i = 0; i < res.length; i++){

                                        tr += '<tr class="rowCount">';

                                        if(res[i]['pi_dec_date'] != null){
                                            tr += '<td>'+moment(res[i]['pi_dec_date']).format('YYYY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_dec_date'] != null){
                                            tr += '<td>'+moment(res[i]['pi_dec_date']).format('MMM')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_dec_date'] != null){
                                            tr += '<td>'+moment(res[i]['pi_dec_date']).format('MM/DD/YYYY')
                                                +'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_num'] != null){
                                            tr += '<td><p style="width: 120px">'+res[i]['pi_num']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_date'] != null){
                                            tr += '<td>'+moment(res[i]['lc_date']).format('MMM')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_date'] != null){
                                            tr += '<td><p style="width: 65px;">'+moment(res[i]['lc_date']).format
                                            ('DD/MMM/YY')+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_number'] != null){
                                            tr += '<td>'+res[i]['lc_number']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['bank_name'] != null){
                                            tr += '<td><p style="width: 120px">'+res[i]['bank_name']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['lc_number'] != null){
                                            tr += '<td>Opened</td>';
                                        }else{
                                            tr += '<td>Not Opened</td>';
                                        }

                                        if(res[i]['com_facility'] != null){
                                            tr += '<td>'+res[i]['com_facility']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['mat_heading'] != null){
                                            tr += '<td><p style="width:  250px;">'+res[i]['mat_heading']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['mat_desc'] != null){
                                            tr += '<td><p style="width:  250px;">'+res[i]['mat_desc']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['terms_of_pay'] != null){
                                            tr += '<td>'+res[i]['terms_of_pay']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['terms_of_pay'] != null){
                                            var lc_type_val = '';
                                            if(res[i]['terms_of_pay'].toUpperCase() == 'UPAS-180'){
                                                lc_type_val = 'DP';
                                            }else if(res[i]['terms_of_pay'].toUpperCase() == 'UPAS-360'){
                                                lc_type_val = 'DP';
                                            }else if(res[i]['terms_of_pay'].toUpperCase() == 'UPAS-270'){
                                                lc_type_val = 'DP';
                                            }else if(res[i]['terms_of_pay'].toUpperCase() == 'SIGHT'){
                                                lc_type_val = 'S';
                                            }else{
                                                lc_type_val = 'S';
                                            }
                                            tr += '<td>'+lc_type_val+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_date'] != null){
                                            tr += '<td><p style="width: 65px;">'+moment(res[i]['pi_date']).format
                                            ('MM/DD/YYYY')+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_value'] != null){
                                            tr += '<td>'+parseFloat(res[i]['pi_value']).toLocaleString("en-US")+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['currency'] != null){
                                            tr += '<td>'+res[i]['currency']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pi_value'] != null){
                                            tr += '<td>'+parseFloat(res[i]['pi_value']).toLocaleString("en-US")+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                            var curr_rate = res[i]['currency_rate'];
                                            var getBDTval = parseFloat(res[i]['pi_value'])*parseFloat
                                            (res[i]['currency_rate']);
                                            tr += '<td>'+getBDTval.toLocaleString("en-US")+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['vendor_name'] != null){
                                            tr += '<td><p style="width:250px;">'+res[i]['vendor_name']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['terms_of_pay'] != null){
                                            tr += '<td>'+res[i]['terms_of_pay']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['pay_terms'] != null){
                                            tr += '<td>'+res[i]['pay_terms']+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['accept_date'] != null){
                                            tr += '<td>'+moment(res[i]['accept_date']).format('MM/DD/YYYY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['due_date_actual'] != null){
                                            tr += '<td>'+moment(res[i]['due_date_actual']).format('MM/DD/YYYY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['due_date_actual'] != null){
                                            tr += '<td>'+moment(res[i]['due_date_actual']).format('MMM-YY')+'</td>';
                                        }else{
                                            if(res[i]['bank_deli_date'] != null && res[i]['pay_terms'] != null){
                                                var payterms = parseInt(res[i]['pay_terms']);
                                                var tentDueMonths = moment(res[i]['bank_deli_date']).add(payterms,'days');

                                                tr += '<td>'+ moment(tentDueMonths).format('MMM-YY')+'</td>';
                                            }else{
                                                tr += '<td></td>';
                                            }
                                        }

                                        if(res[i]['payment_date'] != null){
                                            tr += '<td>PAID</td>';
                                        }else{
                                            tr += '<td>DUE</td>';
                                        }

                                        if(res[i]['payment_date'] != null){
                                            tr += '<td>'+moment(res[i]['payment_date']).format('MM/DD/YYYY')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['payment_date'] != null){
                                            tr += '<td>'+moment(res[i]['payment_date']).format('MMM')+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['origin_country'] != null){
                                            tr += '<td><p style="width: 200px">'+res[i]['origin_country']+'</p></td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                            var curr_rate = res[i]['currency_rate'];
                                            var getBDTvalinMill = (parseFloat(res[i]['pi_value'])*parseFloat
                                            (res[i]['currency_rate']))/1000000;
                                            tr += '<td>'+getBDTvalinMill+'</td>';
                                        }else{
                                            tr += '<td></td>';
                                        }

                                        tr += '</tr>';
                                    }

                                    $('#RawPackTable tbody').html(tr);
                                    $('#RawPackTableDiv').show();

                                    table = $("#RawPackTable").DataTable({
                                        dom: 'Bfrtip',
                                        buttons: [
                                            'copyHtml5',
                                            'csvHtml5',
                                            {
                                                extend: 'excelHtml5',
                                                header: true,
                                                footer: true,
                                                text: 'Excel',
                                                title: 'RawPack_report',
                                                exportOptions : {
                                                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
                                                        18, 19, 20, 21, 22, 23 ,24, 25, 26, 27, 28, 29]
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
                                }else{
                                    var tr = '';
                                    tr += '<tr style="text-align: center;color: red">';
                                    tr += '<td colspan="30">There is no data available!</td>';
                                    tr += '</tr>';
                                    $('#RawPackTable tbody').html(tr);
                                    $('#RawPackTableDiv').show();
                                }
                                $('#loader').hide();
                            }
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
                            $('#CapexTableDiv').hide();
                            $('#RawPackTableDiv').hide();
                        }
                    })
                }
            });
        });
    </script>
@endsection
