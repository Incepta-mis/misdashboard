@extends('_layout_shared._master')
@section('title','Brand Ranking Report')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .help-block {
            color: red;
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

        #insert_itemBtn{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }

        #insert_itemBtn:hover{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }

        .btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
            outline: none;
        }

        .select2-container--default .select2-selection--single{
            border-radius: 0px;
        }

        .hiddenRow {
            padding: 0 !important;
        }

        .table{
            margin-bottom: 0px;
            border-collapse: collapse;
        }
        .fixTableHead {
            overflow-y: auto;
            height: 550px;
            padding-top: 0px;
        }
        .fixTableHead thead {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 2;
        }
        .main-content {
            min-height: 700px;
        }
        .table>thead>tr>th {
            border-bottom: 0px solid #fff;
        }
        .glyphicon {
            position: initial !important;
        }

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding-top: 8px;
            padding-bottom: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: none;
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

        #insert_itemBtn{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }

        #insert_itemBtn:hover{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }

        .btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
            outline: none;
        }

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
            text-align: center !important;
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

        .cls-req{
            color: red;
            font-weight: bold;
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

        .table > thead > tr > th {
            font-size: 12px;
        }

        .table > tbody > tr > td {
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            font-size: 11px;
        }

        .select2-container {
            margin-top: 2px;
        }
        table thead tr th{
            text-align: center;
        }
        .border-solid{
            border:1px solid #ddd;
        }
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
        .fa-arrow-up, .fa-arrow-down{
            font-size: 20px;
            font-weight: 900;
        }
        .fa-arrow-up{
            color: green;
        }
        .fa-arrow-down{
            color: red;
        }
    </style>
@endsection
@section('right-content')
    <div class="row" id="process_div" style="display: block">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-default">
                <div class="panel-heading">
                    <label class="text-default">
                        Brand Ranking Report
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 1%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <div class="col-md-3 text-center control-label fnt_size">
                                                <label for="date_from"><b>Date From:</b></label>
                                            </div>
                                            <div class="col-md-9 text-center">
                                                <div class="input-group">
                                                    <input type="text" id="date_from" name="date_from"
                                                           class="form-control input-sm">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="col-md-3 text-center control-label fnt_size">
                                                <label for="date_to"><b>Date To:</b></label>
                                            </div>
                                            <div class="col-md-9 text-center">
                                                <div class="input-group">
                                                    <input type="text" id="date_to" name="date_to" class="form-control input-sm">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4" style="text-align: center">
                                            <button type="button" id="btn_process" class="btn btn-success btn-md"><b>&nbsp;
                                                    Process Data </b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 3px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/preloader.gif')}}"
                         alt="Processing Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Processing...</i></b></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="filter_options_div" >
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info" style="height: 100px">
                <div class="panel-heading">
                    <label class="text-default">
                        Brand Ranking Report
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 1%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-2 col-sm-2">
                                            <label for="channel"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Channel:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="channel" name="channel"
                                                        class="form-control input-sm filter-option pull-left">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <label for="region"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Region:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="region" name="region"
                                                        class="form-control input-sm filter-option pull-left">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <label for="terr1"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>AM:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="terr1" name="terr1"
                                                        class="form-control input-sm filter-option pull-left">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <label for="terr2"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>MPO:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="terr2" name="terr2"
                                                        class="form-control input-sm filter-option pull-left">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-2">
                                            <label for="brand_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Brand:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="brand_name" name="brand_name"
                                                        class="form-control input-sm filter-option pull-left">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-2">
                                                <div class="col-md-12" style="text-align: center">
                                                    <button type="button" id="btn_submit1" class="btn btn-warning btn-sm" disabled>
                                                        <i class="fa fa-chevron-circle-up"></i> <b>&nbsp;Display Report
                                                        </b></button>
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
        <div class="col-md-12 col-sm-12" id="loader1" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/preloader.gif')}}"
                         alt="Loading Report Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Loading...</i></b></span>
                </div>
            </div>
        </div>

    </div>
    <div class="row" id="report_div" style="display: none">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Brand Information
                </div>
                <div class="panel-body fixTableHead">
                    <table class="table table-condensed table-striped">
                        <thead id="report_div_table_thead">
                        </thead>
                        <tbody id="report_div_table_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}

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

    <script type="text/javascript">
        $(document).ready(function () {

            $('#date_from,#date_to').datetimepicker({
                defaultDate:  new Date(),
                format: 'MM/DD/YYYY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });

            $('#btn_submit1').on('click', function (e) {
                var channel = $('#channel').val();
                var region = $('#region').val();
                var terr1 = $('#terr1').val();
                var terr2 = $('#terr2').val();
                var brand_name = $('#brand_name').val();

                if(channel == "" || region == "" || terr1 == "" || terr2 == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose all required data!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $("#loader1").css('display','block');
                    $.ajax({
                        type: 'post',
                        url: '{{  url('srep/hrep/hbrand/previewBrandData') }}',
                        data: { 'channel':channel,'region':region,'terr1':terr1,'terr2':terr2,'brand_name':brand_name, '_token': "{{ csrf_token () }}"},
                        success: function (data) {
                            $("#loader1").css('display','none');
                            console.log(data);
                            if(data.mainData.length > 0){
                                var cur_month_range = data.cur_month_range;
                                var pre_month_range = data.pre_month_range;

                                var total_cmr_qty = data.total_cmr_qty;
                                var total_pmr_qty = data.total_pmr_qty;
                                var total_cmr_value = data.total_cmr_value;
                                var total_pmr_value = data.total_pmr_value;

                                var thead = "";
                                var tbody = '';
                                var maindata = data.mainData;


                                thead += '<tr><th colspan="3"></th><th colspan="2" class="border-solid">Quantity (Pack)</th><th colspan="2" class="border-solid">Value</th><th class="border-solid">Growth</th><th colspan="2" class="border-solid">Rank (Value Base)</th><th colspan="2" class="border-solid">Contribution%</th></tr>';
                                thead += '<tr>';
                                thead += '<th style="width: 4%;"></th>';
                                thead += '<th class="border-solid" style="width: 13%;">Brand name</th>';
                                thead += '<th class="border-solid" style="width: 5%;">Company</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+cur_month_range+'</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+pre_month_range+'</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+cur_month_range+'</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+pre_month_range+'</th>';
                                thead += '<th class="border-solid" style="width: 1%;">Status</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+cur_month_range+'</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+pre_month_range+'</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+cur_month_range+'</th>';
                                thead += '<th class="border-solid" style="width: 10%;">'+pre_month_range+'</th>';
                                thead += '</tr>';
                                thead += '<tr style="background-color: #7fffd4;"><th ' +
                                    'colspan="3" style="font-weight: 700;text-align: left;padding-left: 10px;"' +
                                    '>Subtotal</th><th style="font-weight: 700;' +
                                    'text-align: center">'+total_cmr_qty+'</th><th style="font-weight: 700;' +
                                    'text-align: center">'+total_pmr_qty+'</th><th' +
                                    ' style="font-weight: 700;text-align: right">'+total_cmr_value+'</th><th' +
                                    ' style="font-weight: 700;text-align: right">'+total_pmr_value+'</th><th ' +
                                    'colspan="5"></th></tr>';

                                $('#report_div_table_thead').html(thead);

                                for (var i = 0; i < maindata.length; i++){
                                    var rand = Math.floor(Math.random() * 9999999) + 1;
                                    tbody += '<tr data-toggle="collapse" data-target="#demo'+rand+'" ' +
                                        'class="accordion-toggle">';
                                    tbody += '<td><button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button></td>';
                                    tbody += '<td>'+maindata[i]['brand_name']+'</td>';
                                    tbody += '<td class="text-center">'+maindata[i]['company_name']+'</td>';
                                    tbody += '<td class="text-center">'+maindata[i]['total_cmr_qty']+'</td>';
                                    tbody += '<td class="text-center">'+maindata[i]['total_pmr_qty']+'</td>';
                                    tbody += '<td class="text-right">'+maindata[i]['total_cmr_value']+'</td>';
                                    tbody += '<td class="text-right">'+maindata[i]['total_pmr_value']+'</td>';
                                    tbody += '<td class="text-center">';
                                    if(maindata[i]['pb_growth_indicate'] == "UP"){
                                        tbody += '<i class="fa fa-arrow-up"></i>';
                                    }else if(maindata[i]['pb_growth_indicate'] == "DOWN"){
                                        tbody += '<i class="fa fa-arrow-down"></i>';
                                    }else{
                                        tbody += maindata[i]['pb_growth_indicate'];
                                    }

                                    tbody += '</td>';
                                    tbody += '<td class="text-center">'+maindata[i]['pb_cmr_sl']+'</td>';
                                    tbody += '<td class="text-center">'+maindata[i]['pb_pmr_sl']+'</td>';
                                    tbody += '<td class="text-center">'+maindata[i]['pb_cmr_contribution']+'</td>';
                                    tbody += '<td class="text-center">'+maindata[i]['pb_pmr_contribution']+'</td>';
                                    tbody += '</tr>';

                                    tbody += '<tr>';

                                    tbody += '<td colspan="12" class="hiddenRow">';
                                    tbody += '<div class="accordion-body collapse" id="demo'+rand+'">';
                                    tbody += '<table class="table table-striped">';
                                    tbody += '<tbody>';
                                    for (var j = 0; j < maindata[i]['details'].length; j++){
                                        var rand1 = Math.floor(Math.random() * 9999999) + 1;
                                        tbody += '<tr data-toggle="collapse"  class="accordion-toggle" ' +
                                            'data-target="#'+rand1+'" style="background-color: #e6e6fa94;">';
                                        tbody += '<td style="width: 5.5%;"><a href="#" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus"></span> </a> </td>';
                                        tbody += '<td style="width: 13%;">'+maindata[i]['details'][j]['ps']+'</td>';
                                        tbody += '<td  style="width: 4%;"></td>';
                                        tbody += '<td class="text-center" style="width: 9%;">'+maindata[i]['details'][j]['total_cmr_qty']+'</td>';
                                        tbody += '<td class="text-center" style="width: 9.5%;">'+maindata[i]['details'][j]['total_pmr_qty']+'</td>';
                                        tbody += '<td class="text-right" style="width: 9.2%;">'+maindata[i]['details'][j]['total_cmr_value']+'</td>';
                                        tbody += '<td class="text-right" style="width: 10.3%;">'+maindata[i]['details'][j]['total_pmr_value']+'</td>';
                                        tbody += '<td class="text-center" style="width: 4.5%;">';
                                        if(maindata[i]['details'][j]['ps_growth_indicate'] == "UP"){
                                            tbody += '<i class="fa fa-arrow-up"></i>';
                                        }else if(maindata[i]['details'][j]['ps_growth_indicate'] == "DOWN"){
                                            tbody += '<i class="fa fa-arrow-down"></i>';
                                        }else{
                                            tbody += maindata[i]['details'][j]['ps_growth_indicate'];
                                        }
                                        tbody += '</td>';
                                        tbody += '<td class="text-center" style="width: 9.5%;">'+maindata[i]['details'][j]['ps_cmr_sl']+'</td>';
                                        tbody += '<td class="text-center" style="width: 9%;">'+maindata[i]['details'][j]['ps_pmr_sl']+'</td>';
                                        tbody += '<td class="text-center" style="width: 10%;">'+maindata[i]['details'][j]['ps_cmr_contribution']+'</td>';
                                        tbody += '<td class="text-center" style="width: 10%;">'+maindata[i]['details'][j]['ps_pmr_contribution']+'</td>';
                                        tbody += '</tr>';

                                        tbody += '<tr>';
                                        tbody += '<td colspan="12" class="hiddenRow">';
                                        tbody += '<div class="accordion-body collapse" id="'+rand1+'">';
                                        tbody += '<table class="table table-striped">';
                                        tbody += '<tbody>';

                                        var pcDetails = maindata[i]['details'][j]['details'];
                                        for (var z = 0; z < pcDetails.length; z++){
                                            tbody += '<tr style="background-color: #ceceffa3">';
                                            tbody += '<td style="width: 20%; padding-left: 80px;' +
                                                '">'+pcDetails[z]['pc']+'</td>';
                                            tbody += '<td style="width: 2.5%;"></td>';
                                            tbody += '<td class="text-center" style="width: 9.5%;">'+pcDetails[z]['cmr_qty']+'</td>';
                                            tbody += '<td class="text-center" style="width: 8.5%;' +
                                                '">'+pcDetails[z]['pmr_qty']+'</td>';
                                            tbody += '<td class="text-right" style="width: 9.7%;' +
                                                '">'+pcDetails[z]['cmr_value']+'</td>';
                                            tbody += '<td class="text-right" style="width: 10.3%;' +
                                                '">'+pcDetails[z]['pmr_value']+'</td>';
                                            tbody += '<td class="text-center" style="width: 4%; padding-left: 9px;">';
                                            if(pcDetails[z]['p_growth_indicate'] == "UP"){
                                                tbody += '<i class="fa fa-arrow-up"></i>';
                                            }else if(pcDetails[z]['p_growth_indicate'] == "DOWN"){
                                                tbody += '<i class="fa fa-arrow-down"></i>';
                                            }else{
                                                tbody += pcDetails[z]['p_growth_indicate'];
                                            }
                                            tbody += '</td>';
                                            tbody += '<td class="text-center" style="width: 10.5%;">'+pcDetails[z]['p_code_cmr_sl']+'</td>';
                                            tbody += '<td class="text-center" style="width: 8%;">'+pcDetails[z]['p_code_pmr_sl']+'</td>';
                                            tbody += '<td class="text-center" style="width: 10.6%;">'+pcDetails[z]['p_cmr_contribution']+'</td>';
                                            tbody += '<td class="text-center" style="width: 10%;">'+pcDetails[z]['p_pmr_contribution']+'</td>';
                                            tbody += '</tr>';
                                        }
                                        tbody += '</tbody>';
                                        tbody += '</table>';
                                        tbody += '</div>';
                                        tbody += '</td>';
                                        tbody += '</tr>';
                                    }
                                    tbody += '</tbody>';
                                    tbody += '</table>';
                                    tbody += '</div>';
                                    tbody += '</td>';
                                    tbody += '</tr>';
                                }
                                $('#report_div_table_tbody').html(tbody);
                            }else{
                                var html = '';
                                html += '<div class="row"><div class="col-md-12" style="text-align:center;color: red;"><p>There is no data available!</p></div></div>';
                                $('#report_div_table_tbody').html(html);
                            }

                            $('#report_div').css('display','block');

                            $('.accordion-toggle').click(function() {
                                var panel = $(this).find('span');

                                $('html, body').animate({
                                    scrollTop: panel.offset().top - 65
                                }, 300);

                                $(this).find('span').toggleClass('glyphicon glyphicon-plus glyphicon glyphicon-minus');
                            });
                        },
                        error: function (e) {
                            $('#report_div').css('display','none');
                            $("#loader1").css('display','none');
                            console.log(e);
                        }
                    });
                }
            });

            $('#btn_process').on('click', function (e) {

                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();

                if(date_from == "" || date_to == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose all required data!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $("#loader").css('display','block');
                    $("#btn_process").attr('disabled','disabled');


                    $.ajax({
                        type: 'post',
                        url: '{{  url('srep/hrep/hbrand/processBrandData') }}',
                        data: { 'date_from':date_from,'date_to':date_to, '_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            $("#loader").css('display','none');
                            $("#btn_process").removeAttr('disabled');
                            $("#btn_submit1").removeAttr('disabled');

                            console.log(data);

                            if(data.response == true || data.response == 1){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Data has been processed.',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                });

                               // $("#process_div").css('display','none');


                                var sales_type = '<option value="ALL" selected>ALL</option>';
                                if(data.sales_type.length > 0){
                                    for (var i = 0; i < data.sales_type.length; i++){
                                        sales_type += '<option value="'+data.sales_type[i].sales_type+'">'+data.sales_type[i].sales_type+'</option>';
                                    }
                                }
                                $('#channel').html(sales_type);
                                $('#channel').select2();


                                var rm_terr_id = '<option value="ALL" selected>ALL</option>';
                                if(data.rm_terr_id.length > 0){
                                    for (var i = 0; i < data.rm_terr_id.length; i++){
                                        if(data.rm_terr_id[i].rm_terr_id != null){
                                            rm_terr_id += '<option value="'+data.rm_terr_id[i].rm_terr_id+'">'+data.rm_terr_id[i].rm_terr_id+'</option>';
                                        }
                                    }
                                }
                                $('#region').html(rm_terr_id);
                                $('#region').select2();


                                var am_terr_id = '<option value="ALL" selected>ALL</option>';
                                if(data.am_terr_id.length > 0){
                                    for (var i = 0; i < data.am_terr_id.length; i++){
                                        if(data.am_terr_id[i].am_terr_id != null){
                                            am_terr_id += '<option value="'+data.am_terr_id[i].am_terr_id+'">'+data.am_terr_id[i].am_terr_id+'</option>';
                                        }
                                    }
                                }
                                $('#terr1').html(am_terr_id);
                                $('#terr1').select2();

                                var terr_id = '<option value="ALL" selected>ALL</option>';
                                if(data.terr_id.length > 0){
                                    for (var i = 0; i < data.terr_id.length; i++){
                                        if(data.terr_id[i].terr_id != null){
                                            terr_id += '<option value="'+data.terr_id[i].terr_id+'">'+data.terr_id[i].terr_id+'</option>';
                                        }
                                    }
                                }
                                $('#terr2').html(terr_id);
                                $('#terr2').select2();


                                var brand_name = '<option value="ALL" selected>ALL</option>';
                                if(data.brand_name.length > 0){
                                    for (var i = 0; i < data.brand_name.length; i++){
                                        if(data.brand_name[i].brand_name != null){
                                            brand_name += '<option value="'+data.brand_name[i].brand_name+'">'+data.brand_name[i].brand_name+'</option>';
                                        }
                                    }
                                }
                                $('#brand_name').html(brand_name);
                                $('#brand_name').select2();



                            }else{
                                alert(data.response);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong!',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        },
                        error: function (e) {
                            $("#loader").css('display','none');
                            console.log(e);
                        }
                    });
                }
            });
        });
    </script>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection