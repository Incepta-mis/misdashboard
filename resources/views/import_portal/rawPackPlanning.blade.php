@extends('_layout_shared._master')
@section('title','RAW-PACK LAB-PLANNING')
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
        /*.select2-container{*/
        /*    width: 100% !important;*/
        /*}*/
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
        
        #updateMyTable {
            max-height: 500px;
            box-sizing: border-box;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        RAW-PACK LAB-PLANNING
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
                                <div class="col-md-3 col-sm-3">
                                    <label for="indent_num"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>PI/Indent Number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="text" id="indent_num" name="indent_num" class="form-control"
                                               value="" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
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
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-12 col-md-12" style="text-align: right;">
                            <button class="btn btn-success btn-sm rounded-0" id="update_btn" type="button"
                                    style="background-color: #003eff; border-color: #003eff;">Update Data</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="updateMyTable">
                            <input type="hidden" id = 'update_row_ids' value="">
                            <thead style="background-color: #98edf8;">
                                <tr>
                                    <th class="text-center" colspan="25" style="background-color: #177fb5;
                                        color: white;border-color: #177fb5">PLANNING</th>
                                </tr>
                                <tr>
                                    <th class="text-center">PLANT</th>
                                    <th class="text-center">PR NUMBER</th>
                                    <th class="text-center">PR DATE</th>
                                    <th class="text-center">CONCERN PERSON(SCM)</th>
                                    <th class="text-center">LINE ITEMS</th>
                                    <th class="text-center">MATERIAL CODE</th>
                                    <th class="text-center">MATERIAL DESCRIPTION</th>
                                    <th class="text-center">MATERIAL HEADING</th>
                                    <th class="text-center">SUPPLIER NAME</th>
                                    <th class="text-center">MANUFACTURER NAME</th>
                                    <th class="text-center">ORDER QUANTITY</th>
                                    <th class="text-center">UNIT</th>
                                    <th class="text-center">UNIT PRICE</th>
                                    <th class="text-center">PI/INDENT NUMBER</th>
                                    <th class="text-center">PI/INDENT DATE</th>
                                    <th class="text-center">CURRENCY</th>
                                    <th class="text-center">PI VALUE</th>
                                    <th class="text-center">FREIGHT</th>
                                    <th class="text-center">BLOCK LIST/NOC STATUS</th>
                                    <th class="text-center">BLOCK LIST/NOC NUMBER</th>
                                    <th class="text-center">SHIPMENT MODE</th>
                                    <th class="text-center">PRIORITY</th>
                                    <th class="text-center">EXPECTED DELIVERY DATE</th>
                                    <th class="text-center">SEND TO OPEN LC/CAD/TT DATE</th>
                                    <th class="text-center">SEND TO OPEN LC/CAD/TT DATE UPDATED BY</th>
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
            $('#pr_num').select2();
            $('#line_item').select2();
            $('#concern_person').select2();

            $('#btn_display').on('click', function () {

                if($('#plant').val() === "" && $('#pr_num').val() === "" && $('#line_item').val() === "" && $('#concern_person').val() === "" && $('#indent_num').val() === ""){
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
                        url: '{{url('import_management/retrieveRawPackInfo')}}',
                        data: {
                            plant: $('#plant').val(),
                            pr_num: $('#pr_num').val(),
                            indent_num: $('#indent_num').val(),
                            line_item: $('#line_item').val(),
                            concern_person: $('#concern_person').val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            // console.log(response);
                            var res = response.result;

                            if(res.length > 0){
                                var tr = '';
                                var rowIds = [];

                                for(var i = 0; i < res.length; i++){

                                    rowIds.push(res[i]['id']);

                                    tr += '<tr id="tableRow_id_'+res[i]['id']+'" class="rowCount">';

                                    tr += '<td><input type="text" class="form-control input-xs" id="t_plant" ' +
                                        'name="t_plant" style="width: 130px;" value="'+res[i]['plant']+'" disabled></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" id="t_pr_num" name="t_pr_num" ' +
                                        'value="'+res[i]['pr_num']+'" style="width: 100px" disabled></td>';

                                    if(res[i]['pr_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="pr_date" ' +
                                            'name="pr_date" style="width: 120px" value="'+moment(res[i]['pr_date'])
                                                .format('YYYY-MM-DD')+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="pr_date" ' +
                                            'name="pr_date" style="width: 120px" disabled></td>';
                                    }

                                    if(res[i]['concern_person'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="t_concern_person" name="t_concern_person" ' +
                                            'style="width: 170px;"><option value="">Select concern person</option>';
                                        for(var x = 0; x < response.concernPerson.length > 0; x++){
                                            if(res[i]['concern_person'] == response.concernPerson[x]['name']){
                                                tr += '<option value="'+response.concernPerson[x]['id']+'" ' +
                                                    'selected>'+response.concernPerson[x]['name']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.concernPerson[x]['id']+'">'+response
                                                    .concernPerson[x]['name']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="t_concern_person" name="t_concern_person" ' +
                                            'style="width: 170px;"><option value="">Select concern person</option>';
                                        for(var x = 0; x < response.concernPerson.length > 0; x++){
                                            tr += '<option value="'+response.concernPerson[x]['id']+'">'+response
                                                .concernPerson[x]['name']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    tr += '<td><input type="number" class="form-control input-xs" id="t_line_item" name="t_line_item" ' +
                                        'value="'+res[i]['line_item']+'" style="width: 50px" disabled></td>';

                                    if(res[i]['mat_code'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="mat_code" ' +
                                            'name="mat_code" style="width: 120px" value="'+res[i]['mat_code']+'"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="mat_code" name="mat_code" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['mat_desc'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="mat_desc" ' +
                                            'name="mat_desc" ' +
                                            'style="width: 120px" value="'+res[i]['mat_desc']+'"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="mat_desc" name="mat_desc" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['mat_heading'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="mat_heading" ' +
                                            'name="mat_heading" style="width:260px">' +
                                            '<option value="">Select material heading</option><option ' +
                                            'value="PHARMACEUTICAL RAW MATERIAL" '+(res[i]['mat_heading'] === "PHARMACEUTICAL RAW MATERIAL" ? 'selected="selected"' : '')+'>PHARMACEUTICAL RAW ' +
                                            'MATERIAL</option>' +
                                            '<option value="PHARMACEUTICAL PACKING MATERIAL" '+(res[i]['mat_heading'] === "PHARMACEUTICAL PACKING MATERIAL" ? 'selected="selected"' : '')+'>PHARMACEUTICAL PACKING ' +
                                            'MATERIAL</option>' +
                                            '<option value="PHARMACEUTICAL LAB MATERIAL" '+(res[i]['mat_heading'] === "PHARMACEUTICAL LAB MATERIAL" ? 'selected="selected"' : '')+'>PHARMACEUTICAL LAB ' +
                                            'MATERIAL</option>' +
                                            '<option value="PHARMACEUTICAL LAB CONSUMABLES" '+(res[i]['mat_heading'] === "PHARMACEUTICAL LAB CONSUMABLES" ? 'selected="selected"' : '')+'>PHARMACEUTICAL LAB ' +
                                            'CONSUMABLES</option></select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="mat_heading" ' +
                                            'name="mat_heading" style="width:260px">' +
                                            '<option value="">Select material heading</option><option value="PHARMACEUTICAL RAW MATERIAL">PHARMACEUTICAL RAW ' +
                                            'MATERIAL</option>' +
                                            '<option value="PHARMACEUTICAL PACKING MATERIAL">PHARMACEUTICAL PACKING MATERIAL</option>' +
                                            '<option value="PHARMACEUTICAL LAB MATERIAL">PHARMACEUTICAL LAB MATERIAL</option>' +
                                            '<option value="PHARMACEUTICAL LAB CONSUMABLES">PHARMACEUTICAL LAB CONSUMABLES</option></select></td>';
                                    }

                                    if(res[i]['supp_name'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="supp_name" ' +
                                            'name="supp_name" style="width: 270px;"><option value="">Select a ' +
                                            'supplier</option>';
                                        for(var x = 0; x < response.supplier.length > 0; x++){
                                            if(res[i]['supp_name'] == response.supplier[x]['id']){
                                                tr += '<option value="'+response.supplier[x]['id']+'" ' +
                                                    'selected>'+response.supplier[x]['code']+' - '+response
                                                        .supplier[x]['title']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.supplier[x]['id']+'">'+response
                                                    .supplier[x]['code']+' - '+response
                                                    .supplier[x]['title']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="supp_name" name="supp_name" ' +
                                            'style="width: 270px;"><option value="">Select a supplier</option>';
                                        for(var x = 0; x < response.supplier.length > 0; x++){
                                            tr += '<option value="'+response.supplier[x]['id']+'">'+response
                                                .supplier[x]['code']+' - '+response
                                                .supplier[x]['title']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['manufac_name'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="manufac_name" ' +
                                            'name="manufac_name" style="width: 270px;"><option value="">Select a ' +
                                            'manufacturer</option>';
                                        for(var x = 0; x < response.manufacturer.length > 0; x++){
                                            if(res[i]['manufac_name'] == response.manufacturer[x]['id']){
                                                tr += '<option value="'+response.manufacturer[x]['id']+'" ' +
                                                    'selected>'+response.manufacturer[x]['code']+' - '+response
                                                        .manufacturer[x]['title']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.manufacturer[x]['id']+'">'+response
                                                    .manufacturer[x]['code']+' - '+response
                                                    .manufacturer[x]['title']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="manufac_name" name="manufac_name" ' +
                                            'style="width: 270px;"><option value="">Select a manufacturer</option>';
                                        for(var x = 0; x < response.manufacturer.length > 0; x++){
                                            tr += '<option value="'+response.manufacturer[x]['id']+'">'+response
                                                .manufacturer[x]['code']+' - '+response
                                                .manufacturer[x]['title']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['order_qty'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="order_qty" ' +
                                            'name="order_qty" ' +
                                            'style="width: 100px" value="'+res[i]['order_qty']+'"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="order_qty" name="order_qty" ' +
                                            'style="width: 100px" value=""></td>';
                                    }

                                    if(res[i]['unit'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="t_unit" ' +
                                            'name="t_unit" style="width: 270px;"><option value="">Select a ' +
                                            'unit</option>';
                                        for(var x = 0; x < response.units.length > 0; x++){
                                            if(res[i]['unit'] == response.units[x]['id']){
                                                tr += '<option value="'+response.units[x]['id']+'" ' +
                                                    'selected>'+response.units[x]['technical']+' - '+response
                                                        .units[x]['unit_of_measurement_text']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.units[x]['id']+'">'+response.units[x]['technical']+' - '+response
                                                    .units[x]['unit_of_measurement_text']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="t_unit" name="t_unit" ' +
                                            'style="width: 270px;"><option value="">Select a unit</option>';
                                        for(var x = 0; x < response.units.length > 0; x++){
                                            tr += '<option value="'+response.units[x]['id']+'">'+response.units[x]['technical']+' - '+response
                                                .units[x]['unit_of_measurement_text']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['unit_price'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="unit_price" ' +
                                            'name="unit_price" ' +
                                            'style="width: 100px" value="'+res[i]['unit_price']+'"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="unit_price" name="unit_price" ' +
                                            'style="width: 100px" value=""></td>';
                                    }

                                    if(res[i]['pi_num'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="pi_num" ' +
                                            'name="pi_num" value="'+res[i]['pi_num']+'" style="width:150px"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="pi_num" ' +
                                            'name="pi_num" value="" style="width:150px"></td>';
                                    }

                                    if(res[i]['pi_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="pi_date" name="pi_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['pi_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="pi_date" name="pi_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['currency'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="currency" name="currency" ' +
                                            'style="width: 130px;">' +
                                            '<option value="">Select Currency</option>';
                                        for(var x = 0; x < response.currency_rate.length > 0; x++){
                                            if(res[i]['currency'] == response.currency_rate[x]['currency']){
                                                tr += '<option value="'+response.currency_rate[x]['currency']+'" ' +
                                                    'selected>'+response.currency_rate[x]['currency']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.currency_rate[x]['currency']+'">'+response.currency_rate[x]['currency']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="currency" name="currency" ' +
                                            'style="width: 130px;"><option value="">Select Currency</option>';
                                        for(var x = 0; x < response.currency_rate.length > 0; x++){
                                            tr += '<option value="'+response.currency_rate[x]['currency']+'">'+response.currency_rate[x]['currency']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['pi_value'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" name="pi_value" ' +
                                            'value="'+res[i]['pi_value']+'" min="0" style="width: 100px"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" name="pi_value" ' +
                                            'value="" min="0" style="width: 100px"></td>';
                                    }

                                    if(res[i]['freight'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="freight" name="freight" ' +
                                            'value="'+res[i]['freight']+'" min="0" style="width: 100px"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="freight" name="freight" ' +
                                            'value="" min="0" style="width: 100px"></td>';
                                    }

                                    if(res[i]['blocklist_status'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="blocklist_status" ' +
                                            'name="blocklist_status" style="width:260px">' +
                                            '<option value="">Select blocklist status</option><option ' +
                                            'value="OK" '+(res[i]['blocklist_status'] === "OK" ? 'selected="selected"' : '')+'>OK</option>' +
                                            '<option value="AMENDMENT AVAILABLE" '+(res[i]['blocklist_status'] === "AMENDMENT AVAILABLE" ? 'selected="selected"' : '')+'>AMENDMENT AVAILABLE</option>' +
                                            '<option value="APPLY FOR AMENDMENT" '+(res[i]['blocklist_status'] === "APPLY FOR AMENDMENT" ? 'selected="selected"' : '')+'>APPLY FOR AMENDMENT</option>' +
                                            '<option value="NO" '+(res[i]['blocklist_status'] === "NO" ? 'selected="selected"' : '')+'>NO</option>' +
                                            '<option value="NOC" '+(res[i]['blocklist_status'] === "NOC" ?
                                                'selected="selected"' : '')+'>NOC</option></select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="blocklist_status" ' +
                                            'name="blocklist_status" style="width:260px">' +
                                            '<option value="">Select blocklist status</option><option value="OK">OK</option>' +
                                            '<option value="AMENDMENT AVAILABLE">AMENDMENT AVAILABLE</option>' +
                                            '<option value="APPLY FOR AMENDMENT">APPLY FOR AMENDMENT</option>' +
                                            '<option value="NO">NO</option>' +
                                            '<option value="NOC">NOC</option>' +
                                            '</select></td>';
                                    }

                                    if(res[i]['blocklist_num'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="blocklist_num" name="blocklist_num" ' +
                                            'value="'+res[i]['blocklist_num']+'" min="0" style="width: 150px"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="blocklist_num" name="blocklist_num" ' +
                                            'value="" min="0" style="width: 150px"></td>';
                                    }

                                    if(res[i]['ship_mode'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="shipment_mode" name="shipment_mode" ' +
                                            'style="width:160px"><option value="">Select a shipment mode</option>' +
                                            '<option value="BY SEA" '+(res[i]['ship_mode'] === "BY SEA" ? 'selected="selected"' : '')+'>BY SEA</option>' +
                                            '<option value="BY AIR" '+(res[i]['ship_mode'] === "BY AIR" ? 'selected="selected"' : '')+'>BY AIR</option>' +
                                            '<option value="BY ROAD" '+(res[i]['ship_mode'] === "BY ROAD" ? 'selected="selected"' : '')+'>BY ROAD</option>' +
                                            '<option value="BY SEA/AIR" '+(res[i]['ship_mode'] === "BY SEA/AIR" ? 'selected="selected"' : '')+'>BY SEA/AIR</option>' +
                                            '<option value="BY SEA/ROAD" '+(res[i]['ship_mode'] === "BY SEA/ROAD" ? 'selected="selected"' : '')+'>BY SEA/ROAD</option>' +
                                            '<option value="BY AIR/ROAD" '+(res[i]['ship_mode'] === "BY AIR/ROAD" ? 'selected="selected"' : '')+'>BY AIR/ROAD</option>' +
                                            '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="shipment_mode" name="shipment_mode" ' +
                                            'style="width:160px"><option value="">Select a shipment mode</option>' +
                                            '<option value="BY SEA">BY SEA</option>' +
                                            '<option value="BY AIR">BY AIR</option>' +
                                            '<option value="BY ROAD">BY ROAD</option>' +
                                            '<option value="BY SEA/AIR">BY SEA/AIR</option>' +
                                            '<option value="BY SEA/ROAD">BY SEA/ROAD</option>' +
                                            '<option value="BY AIR/ROAD">BY AIR/ROAD</option>' +
                                            '</select></td>';
                                    }

                                    if(res[i]['priorty'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="priority" name="priority" ' +
                                            'style="width: 130px;"><option value="">Select priority</option>' +
                                            '<option value="URGENT" '+(res[i]['priorty'] === "URGENT" ? 'selected="selected"' : '')+'>URGENT</option>' +
                                            '<option value="MEDIUM" '+(res[i]['priorty'] === "MEDIUM" ? 'selected="selected"' : '')+'>MEDIUM</option><option ' +
                                            'value="NORMAL" '+(res[i]['priorty'] === "NORMAL" ? 'selected="selected"' : '')+'>NORMAL</option></select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="priority" name="priority" ' +
                                            'style="width: 130px;"><option value="">Select priority</option>' +
                                            '<option value="URGENT">URGENT</option>' +
                                            '<option value="MEDIUM">MEDIUM</option><option value="NORMAL">NORMAL</option></select></td>';
                                    }

                                    if(res[i]['exp_delivery_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="exp_delivery_date" name="exp_delivery_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['exp_delivery_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="exp_delivery_date" name="exp_delivery_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['send_opn_lc_tt_cad_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="send_opn_lc_tt_cad_date" name="send_opn_lc_tt_cad_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['send_opn_lc_tt_cad_date'])
                                                .format('YYYY-MM-DD')+'" disabled></td>';
                                        tr += '<td><p style="width: 200px;">'+res[i]['opn_lcttcad_date_updated_by']+'</p></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="send_opn_lc_tt_cad_date" name="send_opn_lc_tt_cad_date" ' +
                                            'style="width: 120px"></td>';
                                        tr += '<td style="width: 200px;"></td>';
                                    }

                                    tr += '</tr>';
                                }

                                var finalRowIds = JSON.stringify(rowIds);
                                $('#updateMyTable #update_row_ids').val(finalRowIds);
                                $('#updateMyTable tbody').html(tr);
                                $('#updateTableDiv').show();
                                $('#update_btn').show();

                                $('#updateMyTable #currency').select2();
                                $('#updateMyTable #priority').select2();
                                $('#updateMyTable #mat_heading').select2();
                                $('#updateMyTable #shipment_mode').select2();
                                $('#updateMyTable #t_concern_person').select2();
                                $('#updateMyTable #blocklist_status').select2();
                                $('#updateMyTable #t_unit').select2();
                                $('#updateMyTable #supp_name').select2();
                                $('#updateMyTable #manufac_name').select2();
                            }else{
                                var tr = '';
                                tr += '<tr style="text-align: center;color: red">';
                                tr += '<td colspan="24">There is no data available!</td>';
                                tr += '</tr>';
                                $('#updateMyTable tbody').html(tr);
                                $('#updateTableDiv').show();
                                $('#update_btn').hide();
                            }
                            $('#loader').hide();
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

            $('#update_btn').on('click', function () {
                var finalARr = [];
                var rowIDs = $('#updateMyTable #update_row_ids').val();
                rowIDs = JSON.parse(rowIDs);
                if(rowIDs.length > 0){

                    $('#update_btn').empty();
                    $('#update_btn').html('<i class="fa fa-spinner fa-spin"></i> Update Data');

                    for (var i = 0; i < rowIDs.length; i++){
                        var id = rowIDs[i];

                        var temp = {};
                        temp['id'] = id;
                        temp['concern_person'] = $('#updateMyTable #tableRow_id_'+id+' #t_concern_person').val();
                        temp['mat_code'] = $('#updateMyTable #tableRow_id_'+id+' #mat_code').val();
                        temp['mat_desc'] = $('#updateMyTable #tableRow_id_'+id+' #mat_desc').val();
                        temp['mat_heading'] = $('#updateMyTable #tableRow_id_'+id+' #mat_heading').val();
                        temp['supp_name'] = $('#updateMyTable #tableRow_id_'+id+' #supp_name').val();
                        temp['manufac_name'] = $('#updateMyTable #tableRow_id_'+id+' #manufac_name').val();
                        temp['order_qty'] = $('#updateMyTable #tableRow_id_'+id+' #order_qty').val();
                        temp['unit'] = $('#updateMyTable #tableRow_id_'+id+' #t_unit').val();
                        temp['unit_price'] = $('#updateMyTable #tableRow_id_'+id+' #unit_price').val();
                        temp['pi_num'] = $('#updateMyTable #tableRow_id_'+id+' #pi_num').val();
                        temp['pi_date'] = $('#updateMyTable #tableRow_id_'+id+' #pi_date').val();
                        temp['currency'] = $('#updateMyTable #tableRow_id_'+id+' #currency').val();
                        temp['pi_value'] = $('#updateMyTable #tableRow_id_'+id+' #pi_value').val();
                        temp['freight'] = $('#updateMyTable #tableRow_id_'+id+' #freight').val();
                        temp['blocklist_status'] = $('#updateMyTable #tableRow_id_'+id+' #blocklist_status').val();
                        temp['blocklist_num'] = $('#updateMyTable #tableRow_id_'+id+' #blocklist_num').val();
                        temp['shipment_mode'] = $('#updateMyTable #tableRow_id_'+id+' #shipment_mode').val();
                        temp['priority'] = $('#updateMyTable #tableRow_id_'+id+' #priority').val();
                        temp['exp_delivery_date'] = $('#updateMyTable #tableRow_id_'+id+' #exp_delivery_date').val();
                        temp['send_opn_lc_tt_cad_date'] = $('#updateMyTable #tableRow_id_'+id+' #send_opn_lc_tt_cad_date').val();

                        finalARr.push(temp);
                    }
                    // console.log(finalARr);
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/updateRawPackData')}}',
                        data: {
                            finalData: JSON.stringify(finalARr),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (res) {
                            // console.log(res);
                            if (res.result == 1 || res.result == true) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Raw pack data is updated successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Data was not updated.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                            $('#update_btn').empty();
                            $('#update_btn').html('Update Data');
                        },
                        error: function (error) {
                            toastr.info('Unable to update data');
                            console.log(error);

                            $('#update_btn').empty();
                            $('#update_btn').html('Update Data');
                        }
                    });
                }
            });
        });
    </script>
@endsection
