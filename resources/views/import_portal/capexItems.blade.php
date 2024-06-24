@extends('_layout_shared._master')
@section('title','SPARE PARTS, SERVICE AND CAPITAL MACHINERY')
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
                        SPARE PARTS, SERVICE AND CAPITAL MACHINERY
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
                                <th class="text-center">PLANT</th>
                                <th class="text-center">PR NUMBER</th>
                                <th class="text-center">LINE ITEMS</th>
                                <th class="text-center">PR DATE</th>
                                <th class="text-center">CER (CAPITAL EXPENDITURE REQUEST) DATE</th>
                                <th class="text-center">TRACKING NUMBER</th>
                                <th class="text-center">DESCRIPTION</th>
                                <th class="text-center">PI VALUE</th>
                                <th class="text-center">CURRENCY</th>
                                <th class="text-center">NOTE SHEET SENDING DATE</th>
                                <th class="text-center">PRIORITY</th>
                                <th class="text-center">NOTE SHEET RECEIVING DATE</th>
                                <th class="text-center">PO NUMBER</th>
                                <th class="text-center">PO VALUE</th>
                                <th class="text-center">ADDITIONAL PO</th>
                                <th class="text-center">TYPE OF DOCUMENT</th>
                                <th class="text-center">MATERIAL HEADING</th>
                                <th class="text-center">SHIPMENT MODE</th>
                                <th class="text-center">VENDOR NAME</th>
                                <th class="text-center">LOCAL AGENT</th>
                                <th class="text-center">AGENT CONCERN NAME</th>
                                <th class="text-center">AGENT NUMBER</th>
                                <th class="text-center">AGENT MAIL ADDRESS</th>
                                <th class="text-center">USER/RECEIVER NAME</th>
                                <th class="text-center">RECEIVER MAIL ADDRESS</th>
                                <th class="text-center">CONCERN PERSON(SCM)</th>
                                <th class="text-center">PI REQUEST SEND OR CORRECTION</th>
                                <th class="text-center">PI REQUEST/CORRECTION SENDING DATE</th>
                                <th class="text-center">FINAL PI RECEIVED DATE</th>
                                <th class="text-center">REQUEST FOR OPEN LC/TT/CAD DATE</th>
                                <th class="text-center">LC/TT/CAD SHARE</th>
                                <th class="text-center">LC NUMBER</th>
                                <th class="text-center">DRAFT SHIPPING DOCUMENT RECEIVE DATE</th>
                                <th class="text-center">FINAL SHIPPING DOCUMENT RECEIVED</th>
                                <th class="text-center">SEND FOR ENDORSEMENT DATE</th>
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
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        INSERT DATA
                    </label>
                </header>
                <div class="panel-body">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-6 col-md-6" style="text-align: left;">
                            <button class="btn btn-primary btn-sm rounded-0" id="add_row" type="button">Add Row</button>
                            <button class="btn btn-danger btn-sm rounded-0" id="delete_selected" type="button">Delete</button>
                        </div>
                        <div class="col-sm-6 col-md-6" style="text-align: right;">
                            <button class="btn btn-success btn-sm rounded-0" id="submit_btn" type="button"
                                    style="background-color: #662ca3; border-color: #662ca3;">Submit Data</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="mytable">
                            <input type="hidden" id = 'row_ids' value="">
                            <thead style="background-color: #d6d5ff;">
                                <tr>
                                    <th class="text-center" colspan="12" style="background-color: #8987cc;
                                    color: white;border-color: #8987cc">FACTORY</th>
                                    <th class="text-center" colspan="23" style="background-color: #74aaff;
                                    color: white;border-color: #74aaff">PROCUREMENT</th>
                                </tr>
                                <tr>
                                    <th class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="SelectAll">
                                        </div>
                                    </th>
                                    <th class="text-center">PLANT</th>
                                    <th class="text-center">PR NUMBER</th>
                                    <th class="text-center">LINE ITEMS</th>
                                    <th class="text-center">PR DATE</th>
                                    <th class="text-center">CER (CAPITAL EXPENDITURE REQUEST) DATE</th>
                                    <th class="text-center">TRACKING NUMBER</th>
                                    <th class="text-center">DESCRIPTION</th>
                                    <th class="text-center">PI VALUE</th>
                                    <th class="text-center">CURRENCY</th>
                                    <th class="text-center">NOTE SHEET SENDING DATE</th>
                                    <th class="text-center">PRIORITY</th>
                                    <th class="text-center">NOTE SHEET RECEIVING DATE</th>
                                    <th class="text-center">PO NUMBER</th>
                                    <th class="text-center">PO VALUE</th>
                                    <th class="text-center">ADDITIONAL PO</th>
                                    <th class="text-center">TYPE OF DOCUMENT</th>
                                    <th class="text-center">MATERIAL HEADING</th>
                                    <th class="text-center">SHIPMENT MODE</th>
                                    <th class="text-center">VENDOR NAME</th>
                                    <th class="text-center">LOCAL AGENT</th>
                                    <th class="text-center">AGENT CONCERN NAME</th>
                                    <th class="text-center">AGENT NUMBER</th>
                                    <th class="text-center">AGENT MAIL ADDRESS</th>
                                    <th class="text-center">USER/RECEIVER NAME</th>
                                    <th class="text-center">RECEIVER MAIL ADDRESS</th>
                                    <th class="text-center">CONCERN PERSON(SCM)</th>
                                    <th class="text-center">PI REQUEST SEND OR CORRECTION</th>
                                    <th class="text-center">PI REQUEST/CORRECTION SENDING DATE</th>
                                    <th class="text-center">FINAL PI RECEIVED DATE</th>
                                    <th class="text-center">REQUEST FOR OPEN LC/TT/CAD DATE</th>
                                    <th class="text-center">LC/TT/CAD SHARE</th>
                                    <th class="text-center">DRAFT SHIPPING DOCUMENT RECEIVE DATE</th>
                                    <th class="text-center">FINAL SHIPPING DOCUMENT RECEIVED</th>
                                    <th class="text-center">SEND FOR ENDORSEMENT DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="tableRow_id_1" class="rowCount">
                                    <td class="">
                                        <div class="form-check text-center">
                                            <input class="form-check-input row-item" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <select type="text" class="form-control input-xs"
                                                id="t_plant" name="t_plant" style="width: 130px;">
                                            <option value="">Select Plant</option>
                                            @if(count($plants) > 0)
                                                @foreach($plants as $plant)
                                                    <option value="{{$plant->plant_id}}">{{$plant->plant_id}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control input-xs" id="t_pr_num"
                                               name="t_pr_num" value="" style="width:
                                    100px" onchange="checkPrNumInput(1)"></td>
                                    <td><input type="number" class="form-control input-xs" id="t_line_item" name="t_line_item" value="10" min="10"
                                               style="width: 50px"></td>
                                    <td><input type="date" class="form-control input-xs" id="pr_date" name="pr_date"
                                               style="width: 120px"></td>
                                    <td><input type="date" class="form-control input-xs" id="cer_date" name="cer_date" style="width: 120px"></td>
                                    <td><input type="text" class="form-control input-xs" id="track_no" name="track_no" value="" style="width:
                                    100px"></td>
                                    <td><input type="text" class="form-control input-xs" id="descrp" name="descrp" value="" style="width:
                                    180px"></td>
                                    <td><input type="number" class="form-control input-xs" id="pi_value" name="pi_value" value="" min="0"
                                               style="width:
                                    100px"></td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="currency"
                                                name="currency" style="width: 130px;">
                                            <option value="">Select Currency</option>
                                            @foreach($currency_rate as $currData)
                                                <option value="{{ $currData->currency}}">{{ $currData->currency }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control input-xs" id="note_send_date"
                                               name="note_send_date" style="width:120px"></td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="priority"
                                                name="priority" style="width: 130px;">
                                            <option value="">Select priority</option>
                                            <option value="URGENT">URGENT</option>
                                            <option value="MEDIUM">MEDIUM</option>
                                            <option value="NORMAL">NORMAL</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control input-xs" id="note_rcv_date"
                                               name="note_rcv_date" style="width:120px"></td>
                                    <td><input type="text" class="form-control input-xs" id="po_num" name="po_num"
                                               value="" style="width:
                                    100px"></td>
                                    <td><input type="number" class="form-control input-xs" id="po_value"
                                               name="po_value" value="" style="width:
                                    100px"></td>
                                    <td><input type="text" class="form-control input-xs" id="add_po" name="add_po"
                                               value="" style="width:
                                    180px"></td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="type_of_doc"
                                                name="type_of_doc" style="width:100px">
                                            <option value="">Select Type of doc</option>
                                            @foreach($type_of_doc as $type)
                                                <option value="{{ strtolower($type->type_of_doc) }}">{{ $type->type_of_doc }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="mat_heading"
                                                name="mat_heading" style="width:260px">
                                            <option value="">Select material heading</option>
                                            <option value="PHARMACEUTICAL RAW MATERIAL">PHARMACEUTICAL RAW MATERIAL</option>
                                            <option value="PHARMACEUTICAL PACKING MATERIAL">PHARMACEUTICAL PACKING MATERIAL</option>
                                            <option value="PHARMACEUTICAL LAB MATERIAL">PHARMACEUTICAL LAB MATERIAL</option>
                                            <option value="PHARMACEUTICAL LAB CONSUMABLES">PHARMACEUTICAL LAB CONSUMABLES</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="shipment_mode"
                                                name="shipment_mode" style="width:160px">
                                            <option value="">Select a shipment mode</option>
                                            <option value="BY SEA">BY SEA</option>
                                            <option value="BY AIR">BY AIR</option>
                                            <option value="BY ROAD">BY ROAD</option>
                                            <option value="BY SEA/AIR">BY SEA/AIR</option>
                                            <option value="BY SEA/ROAD">BY SEA/ROAD</option>
                                            <option value="BY AIR/ROAD">BY AIR/ROAD</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="vendor_name"
                                                name="vendor_name" style="width:250px">
                                            <option value="">Select a vendor</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="local_agent"
                                                name="local_agent" style="width:170px" onchange="getAgentInfo(1)">
                                            <option value="">Select a agent</option>
                                            @foreach($agents as $agent)
                                                <option value="{{$agent->id}}">{{$agent->local_agent}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control input-xs" id="agent_name"
                                               name="agent_name" value="" style="width:
                                    100px" disabled></td>
                                    <td><input type="text" class="form-control input-xs" id="agent_num"
                                               name="agent_num" value="" style="width:
                                    100px" disabled></td>
                                    <td><input type="text" class="form-control input-xs" id="agent_email"
                                               name="agent_email" value="" style="width:
                                    180px" disabled></td>
                                    <td><input type="text" class="form-control input-xs" id="rcv_name"
                                               name="rcv_name" value="" style="width:
                                    100px"></td>
                                    <td><input type="text" class="form-control input-xs" id="rcv_email"
                                               name="rcv_email" value="" style="width:
                                    100px"></td>
                                    <td>
                                        <select type="text" class="form-control input-xs filter-option pull-left"
                                                id="t_concern_person" name="t_concern_person" style="width:160px">
                                            <option value="">Select concern person</option>
                                            @foreach($concernPerson as $person)
                                                <option value="{{$person->id}}">{{$person->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="pi_req_send"
                                                name="pi_req_send" style="width:190px">
                                            <option value="">Select a option</option>
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                            <option value="HOLD DUE TO ISSUE">HOLD DUE TO ISSUE</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control input-xs" id="pi_req_send_date"
                                               name="pi_req_send_date" style="width:120px"></td>
                                    <td><input type="date" class="form-control input-xs" id="final_pi_rcv_date"
                                               name="final_pi_rcv_date" style="width: 120px"></td>
                                    <td><input type="date" class="form-control input-xs" id="req_for_open_lc_date"
                                               name="req_for_open_lc_date" style="width: 120px"></td>
                                    <td>
                                        <select type="text" class="form-control input-xs" id="lc_share"
                                                name="lc_share" style="width:100px">
                                            <option value="">Select a option</option>
                                            <option value="YES">YES</option>
                                            <option value="PENDING">PENDING</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control input-xs" id="draft_ship_doc_rcv_date"
                                               name="draft_ship_doc_rcv_date"
                                               style="width: 120px"></td>
                                    <td><input type="date" class="form-control input-xs" id="final_ship_doc_rcved"
                                               name="final_ship_doc_rcved"
                                               style="width: 120px"></td>
                                    <td><input type="date" class="form-control input-xs" id="send_endorsement_date"
                                               name="send_endorsement_date"
                                               style="width: 120px"></td>
                                </tr>
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
            var insertNewRowIds = [];
            insertNewRowIds.push(1);
            var rowIds = JSON.stringify(insertNewRowIds);
            $('#mytable #row_ids').val(rowIds);

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

            $('#add_row').click(function() {
                var rowIDs = $('#mytable #row_ids').val();
                rowIDs = JSON.parse(rowIDs);
                if(rowIDs.length > 0){
                    var max_val = Math.max.apply(Math, rowIDs);
                    max_val++;
                }else{
                    var max_val = 1;
                }
                rowIDs.push(max_val);
                var rowIds = JSON.stringify(rowIDs);
                $('#mytable #row_ids').val(rowIds);

                $.ajax({
                    type: 'get',
                    url: '{{url('import_management/getCapexSelectItems')}}',
                    success: function (data) {
                        // console.log(data);
                        var tr = '';
                        tr += '<tr id="tableRow_id_'+max_val+'" class="rowCount">';
                        tr += "<td><div class='form-check text-center'><input class='form-check-input row-item' " +
                            "type='checkbox'></div></td>";
                        tr += '<td><select type="text" class="form-control input-xs" id="t_plant" name="t_plant" ' +
                        'style="width: 130px;">' +
                            '<option value="">Select Plant</option>';
                        for(var i = 0; i < data.plants.length > 0; i++){
                            tr += '<option value="'+data.plants[i]['plant_id']+'">'+data.plants[i]['plant_id']+'</option>';
                        }
                        tr += '</select></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="t_pr_num" name="t_pr_num" ' +
                            'value="" style="width: 100px" onchange="checkPrNumInput('+max_val+')"></td>';
                        tr += '<td><input type="number" class="form-control input-xs" id="t_line_item" name="t_line_item" ' +
                            'value="10" min="10" style="width: 50px"></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="pr_date" name="pr_date" style="width: 120px"></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="cer_date" name="cer_date" ' +
                            'style="width: 120px"></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="track_no" name="track_no" ' +
                            'value="" style="width: 100px"></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="descrp" name="descrp" value="" style="width:180px"></td>';
                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" name="pi_value" ' +
                            'value="" min="0" style="width: 100px"></td>';

                        tr += '<td><select type="text" class="form-control input-xs" id="currency" name="currency" ' +
                            'style="width: 130px;">' +
                            '<option value="">Select Currency</option>';
                        for(var i = 0; i < data.currency_rate.length > 0; i++){
                            tr += '<option value="'+data.currency_rate[i]['currency']+'">'+data.currency_rate[i]['currency']+'</option>';
                        }
                        tr += '</select></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="note_send_date" name="note_send_date" ' +
                            'style="width: 120px"></td>';
                        tr += '<td><select type="text" class="form-control input-xs" id="priority" name="priority" ' +
                            'style="width: 130px;"><option value="">Select priority</option>' +
                            '<option value="URGENT">URGENT</option>' +
                            '<option value="MEDIUM">MEDIUM</option><option value="NORMAL">NORMAL</option></select></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="note_rcv_date" name="note_rcv_date" ' +
                            'style="width: 120px"></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="po_num" name="po_num" value="" ' +
                            'style="width: 100px"></td>';
                        tr += '<td><input type="number" class="form-control input-xs" id="po_value" name="po_value" value="" ' +
                            'style="width:100px"></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="add_po" name="add_po" value="" ' +
                            'style="width:180px"></td>';
                        tr += '<td><select type="text" class="form-control input-xs" id="type_of_doc" ' +
                            'name="type_of_doc" style="width:100px"><option value="">Select Type of doc</option>';
                        for(var i = 0; i < data.type_of_doc.length > 0; i++){
                            tr += '<option value="'+data.type_of_doc[i]['type_of_doc']+'">'+data.type_of_doc[i]['type_of_doc']+'</option>';
                        }
                        tr += '</select></td>';
                        tr += '<td><select type="text" class="form-control input-xs" id="mat_heading" ' +
                            'name="mat_heading" style="width:260px">' +
                            '<option value="">Select material heading</option><option value="PHARMACEUTICAL RAW MATERIAL">PHARMACEUTICAL RAW ' +
                            'MATERIAL</option>' +
                            '<option value="PHARMACEUTICAL PACKING MATERIAL">PHARMACEUTICAL PACKING MATERIAL</option>' +
                            '<option value="PHARMACEUTICAL LAB MATERIAL">PHARMACEUTICAL LAB MATERIAL</option>' +
                            '<option value="PHARMACEUTICAL LAB CONSUMABLES">PHARMACEUTICAL LAB CONSUMABLES</option></select></td>';

                        tr += '<td><select type="text" class="form-control input-xs" id="shipment_mode" name="shipment_mode" ' +
                            'style="width:160px"><option value="">Select a shipment mode</option>' +
                            '<option value="BY SEA">BY SEA</option>' +
                            '<option value="BY AIR">BY AIR</option>' +
                            '<option value="BY ROAD">BY ROAD</option>' +
                            '<option value="BY SEA/AIR">BY SEA/AIR</option>' +
                            '<option value="BY SEA/ROAD">BY SEA/ROAD</option>' +
                            '<option value="BY AIR/ROAD">BY AIR/ROAD</option>' +
                            '</select></td>';

                        tr += '<td><select type="text" class="form-control input-xs" id="vendor_name" ' +
                            'name="vendor_name" style="width:250px"><option value="">Select a vendor</option>';
                        for(var i = 0; i < data.vendors.length > 0; i++){
                            tr += '<option value="'+data.vendors[i]['id']+'">'+data.vendors[i]['name']+'</option>';
                        }
                        tr += '</select></td>';

                        tr += '<td><select type="text" class="form-control input-xs" id="local_agent" name="local_agent" ' +
                            'style="width:170px" onchange="getAgentInfo('+max_val+')"><option value="">Select a ' +
                        'agent</option>';
                        for(var i = 0; i < data.agents.length > 0; i++){
                            tr += '<option value="'+data.agents[i]['id']+'">'+data.agents[i]['local_agent']+'</option>';
                        }
                        tr += '</select></td>';

                        tr += '<td><input type="text" class="form-control input-xs" id="agent_name" name="agent_name"' +
                            ' value="" style="width: 100px" disabled></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="agent_num" name="agent_num" value="" ' +
                            'style="width: 100px" disabled></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="agent_email" name="agent_email" value="" ' +
                            'style="width:180px" disabled></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="rcv_name" name="rcv_name" value="" ' +
                            'style="width:100px"></td>';
                        tr += '<td><input type="text" class="form-control input-xs" id="rcv_email" name="rcv_email" value="" ' +
                            'style="width:100px"></td>';
                        tr += '<td><select type="text" class="form-control input-xs filter-option pull-left" id="t_concern_person" ' +
                            'name="t_concern_person" style="width:160px"><option value="">Select concern ' +
                            'person</option>';
                        for(var i = 0; i < data.concernPerson.length > 0; i++){
                            tr += '<option value="'+data.concernPerson[i]['id']+'">'+data.concernPerson[i]['name']+'</option>';
                        }
                        tr += '</select></td>';
                        tr += '<td><select type="text" class="form-control input-xs" id="pi_req_send" ' +
                            'name="pi_req_send" style="width:190px"><option value="">Select a option</option>' +
                            '<option value="YES">YES</option><option value="NO">NO</option>' +
                            '<option value="HOLD DUE TO ISSUE">HOLD DUE TO ISSUE</option></select></td>';

                        tr += '<td><input type="date" class="form-control input-xs" id="pi_req_send_date" name="pi_req_send_date" ' +
                            'style="width:120px"></td>';
                        tr += '<td><input type="date" class="form-control input-xs"' +
                            ' id="final_pi_rcv_date" name="final_pi_rcv_date" style="width: 120px"></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="req_for_open_lc_date" ' +
                            'name="req_for_open_lc_date" style="width: 120px"></td>';
                        tr += '<td><select type="text" class="form-control input-xs" id="lc_share" name="lc_share" ' +
                            'style="width:100px"><option value="">Select a option</option>' +
                            '<option value="YES">YES</option><option value="PENDING">PENDING</option></select></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="draft_ship_doc_rcv_date" ' +
                            'name="draft_ship_doc_rcv_date" style="width: 120px"></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="final_ship_doc_rcved" ' +
                            'name="final_ship_doc_rcved" style="width: 120px"></td>';
                        tr += '<td><input type="date" class="form-control input-xs" id="send_endorsement_date" ' +
                            'name="send_endorsement_date" style="width: 120px"></td>';
                        tr += '</tr>';

                        $('#mytable tbody').append(tr);
                        $('#mytable #tableRow_id_'+max_val+' #t_plant').select2();
                        $('#mytable #tableRow_id_'+max_val+' #currency').select2();
                        $('#mytable #tableRow_id_'+max_val+' #priority').select2();
                        $('#mytable #tableRow_id_'+max_val+' #type_of_doc').select2();
                        $('#mytable #tableRow_id_'+max_val+' #mat_heading').select2();
                        $('#mytable #tableRow_id_'+max_val+' #shipment_mode').select2();
                        $('#mytable #tableRow_id_'+max_val+' #vendor_name').select2();
                        $('#mytable #tableRow_id_'+max_val+' #local_agent').select2();
                        $('#mytable #tableRow_id_'+max_val+' #t_concern_person').select2();
                        $('#mytable #tableRow_id_'+max_val+' #pi_req_send').select2();
                        $('#mytable #tableRow_id_'+max_val+' #lc_share').select2();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

                // Row Item Change Event Listener

                $('tr').find('.row-item').change(function() {
                    if ($(".row-item").length == $(".row-item:checked").length) {
                        $('#SelectAll').prop('checked', true)
                    } else {
                        $('#SelectAll').prop('checked', false)
                    }
                })
            });

            $('#delete_selected').click(function() {
                var count = $('.row-item:checked').length
                if (count <= 0) {
                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please select at least one row to remove first.',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                } else {
                    $('.row-item:checked').closest('tr').remove();

                    var rem_ids = [];

                    $('#mytable tbody tr').each(function() {
                        var myID = $(this).attr('id').split("_").pop();
                        myID = parseInt(myID);
                        rem_ids.push(myID);
                    });
                    var rowIds = JSON.stringify(rem_ids);
                    $('#mytable #row_ids').val(rowIds);
                }
            })

            $('#SelectAll').change(function() {
                if ($(this).is(':checked') == true) {
                    $('.row-item').prop("checked", true)
                } else {
                    $('.row-item').prop("checked", false)

                }
            })

            $('.row-item').change(function() {
                if ($(".row-item").length == $(".row-item:checked").length) {
                    $('#SelectAll').prop('checked', true)
                } else {
                    $('#SelectAll').prop('checked', false)
                }
            })

            function objectifyForm(formArray) {
                var returnArray = {};
                for (var i = 0; i < formArray.length; i++) {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
                return returnArray;
            }

            $('#btn_refresh').on('click', function () {
                window.location.reload();
            });

            $('#submit_btn').on('click', function () {
                var finalARr = [];
                var rowIDs = $('#mytable #row_ids').val();
                rowIDs = JSON.parse(rowIDs);
                if(rowIDs.length > 0){

                    $('#submit_btn').empty();
                    $('#submit_btn').html('<i class="fa fa-spinner fa-spin"></i> Submit Data');

                    for (var i = 0; i < rowIDs.length; i++){
                        var id = rowIDs[i];

                        var temp = {};
                        temp['id'] = id;
                        temp['plant'] = $('#mytable #tableRow_id_'+id+' #t_plant').val();
                        temp['pr_num'] = $('#mytable #tableRow_id_'+id+' #t_pr_num').val();
                        temp['line_item'] = $('#mytable #tableRow_id_'+id+' #t_line_item').val();
                        temp['pr_date'] = $('#mytable #tableRow_id_'+id+' #pr_date').val();
                        temp['cer_date'] = $('#mytable #tableRow_id_'+id+' #cer_date').val();
                        temp['track_no'] = $('#mytable #tableRow_id_'+id+' #track_no').val();
                        temp['descrp'] = $('#mytable #tableRow_id_'+id+' #descrp').val();
                        temp['pi_value'] = $('#mytable #tableRow_id_'+id+' #pi_value').val();
                        temp['currency'] = $('#mytable #tableRow_id_'+id+' #currency').val();
                        temp['note_send_date'] = $('#mytable #tableRow_id_'+id+' #note_send_date').val();
                        temp['priority'] = $('#mytable #tableRow_id_'+id+' #priority').val();
                        temp['note_rcv_date'] = $('#mytable #tableRow_id_'+id+' #note_rcv_date').val();
                        temp['po_num'] = $('#mytable #tableRow_id_'+id+' #po_num').val();
                        temp['po_value'] = $('#mytable #tableRow_id_'+id+' #po_value').val();
                        temp['add_po'] = $('#mytable #tableRow_id_'+id+' #add_po').val();
                        temp['type_of_doc'] = $('#mytable #tableRow_id_'+id+' #type_of_doc').val();
                        temp['mat_heading'] = $('#mytable #tableRow_id_'+id+' #mat_heading').val();
                        temp['shipment_mode'] = $('#mytable #tableRow_id_'+id+' #shipment_mode').val();
                        temp['vendor_name'] = $('#mytable #tableRow_id_'+id+' #vendor_name').val();
                        temp['local_agent'] = $('#mytable #tableRow_id_'+id+' #local_agent').val();
                        temp['agent_name'] = $('#mytable #tableRow_id_'+id+' #agent_name').val();
                        temp['agent_num'] = $('#mytable #tableRow_id_'+id+' #agent_num').val();
                        temp['agent_email'] = $('#mytable #tableRow_id_'+id+' #agent_email').val();
                        temp['rcv_name'] = $('#mytable #tableRow_id_'+id+' #rcv_name').val();
                        temp['rcv_email'] = $('#mytable #tableRow_id_'+id+' #rcv_email').val();
                        temp['t_concern_person'] = $('#mytable #tableRow_id_'+id+' #t_concern_person').val();
                        temp['pi_req_send'] = $('#mytable #tableRow_id_'+id+' #pi_req_send').val();
                        temp['pi_req_send_date'] = $('#mytable #tableRow_id_'+id+' #pi_req_send_date').val();
                        temp['final_pi_rcv_date'] = $('#mytable #tableRow_id_'+id+' #final_pi_rcv_date').val();
                        temp['req_for_open_lc_date'] = $('#mytable #tableRow_id_'+id+' #req_for_open_lc_date').val();
                        temp['lc_share'] = $('#mytable #tableRow_id_'+id+' #lc_share').val();
                        temp['draft_ship_doc_rcv_date'] = $('#mytable #tableRow_id_'+id+' #draft_ship_doc_rcv_date').val();
                        temp['final_ship_doc_rcved'] = $('#mytable #tableRow_id_'+id+' #final_ship_doc_rcved').val();
                        temp['send_endorsement_date'] = $('#mytable #tableRow_id_'+id+' #send_endorsement_date').val();

                        finalARr.push(temp);
                    }
                    // console.log(finalARr);
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/saveCapexData')}}',
                        data: {
                            finalData: JSON.stringify(finalARr),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (res) {
                            // console.log(res);
                            if (res.result == 1 || res.result == true) {
                                $('#mytable .rowCount input').css('border','1px solid #ced4da');
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Capex data is inserted successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else if(res.result == 5){

                                var rowID = res.id;
                                $('#mytable .rowCount input').css('border','1px solid #ced4da');
                                $('#mytable #tableRow_id_'+rowID+' #t_plant').css('border','2px solid red');
                                $('#mytable #tableRow_id_'+rowID+' #t_pr_num').css('border','2px solid red');
                                $('#mytable #tableRow_id_'+rowID+' #t_line_item').css('border','2px solid red');
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Please input all required data!',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Data was not saved.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                            $('#submit_btn').empty();
                            $('#submit_btn').html('Submit Data');
                        },
                        error: function (error) {
                            toastr.info('Unable to save data');
                            console.log(error);

                            $('#submit_btn').empty();
                            $('#submit_btn').html('Submit Data');
                        }
                    });
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
                        temp['plant'] = $('#updateMyTable #tableRow_id_'+id+' #t_plant').val();
                        temp['pr_num'] = $('#updateMyTable #tableRow_id_'+id+' #t_pr_num').val();
                        temp['line_item'] = $('#updateMyTable #tableRow_id_'+id+' #t_line_item').val();
                        temp['pr_date'] = $('#updateMyTable #tableRow_id_'+id+' #pr_date').val();
                        temp['cer_date'] = $('#updateMyTable #tableRow_id_'+id+' #cer_date').val();
                        temp['track_no'] = $('#updateMyTable #tableRow_id_'+id+' #track_no').val();
                        temp['descrp'] = $('#updateMyTable #tableRow_id_'+id+' #descrp').val();
                        temp['pi_value'] = $('#updateMyTable #tableRow_id_'+id+' #pi_value').val();
                        temp['currency'] = $('#updateMyTable #tableRow_id_'+id+' #currency').val();
                        temp['note_send_date'] = $('#updateMyTable #tableRow_id_'+id+' #note_send_date').val();
                        temp['priority'] = $('#updateMyTable #tableRow_id_'+id+' #priority').val();
                        temp['note_rcv_date'] = $('#updateMyTable #tableRow_id_'+id+' #note_rcv_date').val();
                        temp['po_num'] = $('#updateMyTable #tableRow_id_'+id+' #po_num').val();
                        temp['po_value'] = $('#updateMyTable #tableRow_id_'+id+' #po_value').val();
                        temp['add_po'] = $('#updateMyTable #tableRow_id_'+id+' #add_po').val();
                        temp['type_of_doc'] = $('#updateMyTable #tableRow_id_'+id+' #type_of_doc').val();
                        temp['mat_heading'] = $('#updateMyTable #tableRow_id_'+id+' #mat_heading').val();
                        temp['shipment_mode'] = $('#updateMyTable #tableRow_id_'+id+' #shipment_mode').val();
                        temp['vendor_name'] = $('#updateMyTable #tableRow_id_'+id+' #vendor_name').val();
                        temp['local_agent'] = $('#updateMyTable #tableRow_id_'+id+' #local_agent').val();
                        temp['agent_name'] = $('#updateMyTable #tableRow_id_'+id+' #agent_name').val();
                        temp['agent_num'] = $('#updateMyTable #tableRow_id_'+id+' #agent_num').val();
                        temp['agent_email'] = $('#updateMyTable #tableRow_id_'+id+' #agent_email').val();
                        temp['rcv_name'] = $('#updateMyTable #tableRow_id_'+id+' #rcv_name').val();
                        temp['rcv_email'] = $('#updateMyTable #tableRow_id_'+id+' #rcv_email').val();
                        temp['t_concern_person'] = $('#updateMyTable #tableRow_id_'+id+' #t_concern_person').val();
                        temp['pi_req_send'] = $('#updateMyTable #tableRow_id_'+id+' #pi_req_send').val();
                        temp['pi_req_send_date'] = $('#updateMyTable #tableRow_id_'+id+' #pi_req_send_date').val();
                        temp['final_pi_rcv_date'] = $('#updateMyTable #tableRow_id_'+id+' #final_pi_rcv_date').val();
                        temp['req_for_open_lc_date'] = $('#updateMyTable #tableRow_id_'+id+' #req_for_open_lc_date').val();
                        temp['lc_share'] = $('#updateMyTable #tableRow_id_'+id+' #lc_share').val();
                        temp['draft_ship_doc_rcv_date'] = $('#updateMyTable #tableRow_id_'+id+' #draft_ship_doc_rcv_date').val();
                        temp['final_ship_doc_rcved'] = $('#updateMyTable #tableRow_id_'+id+' #final_ship_doc_rcved').val();
                        temp['send_endorsement_date'] = $('#updateMyTable #tableRow_id_'+id+' #send_endorsement_date').val();

                        finalARr.push(temp);
                    }
                    // console.log(finalARr);
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/updateCapexData')}}',
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
                                    text: 'Capex data is updated successfully!',
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

            $('#btn_display').on('click', function () {

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

                                    tr += '<td><input type="number" class="form-control input-xs" id="t_line_item" name="t_line_item" ' +
                                        'value="'+res[i]['line_item']+'" style="width: 50px" disabled></td>';

                                    if(res[i]['pr_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="pr_date" ' +
                                            'name="pr_date" style="width: 120px" value="'+moment(res[i]['pr_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="pr_date" ' +
                                            'name="pr_date" style="width: 120px"></td>';
                                    }

                                    if(res[i]['cer_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="cer_date" name="cer_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['cer_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="cer_date" name="cer_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['tracking_num'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="track_no" name="track_no" ' +
                                            'style="width: 100px" value="'+res[i]['tracking_num']+'"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="track_no" name="track_no" ' +
                                            'style="width: 100px" value=""></td>';
                                    }

                                    if(res[i]['description'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="descrp" name="descrp" value="'+res[i]['description']+'" style="width:180px"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="descrp" name="descrp" value="" style="width:180px"></td>';
                                    }

                                    if(res[i]['pi_value'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" name="pi_value" ' +
                                            'value="'+res[i]['pi_value']+'" min="0" style="width: 100px"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" name="pi_value" ' +
                                            'value="" min="0" style="width: 100px"></td>';
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

                                    if(res[i]['note_send_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="note_send_date" name="note_send_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['note_send_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="note_send_date" name="note_send_date" ' +
                                            'style="width: 120px"></td>';
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

                                    if(res[i]['note_rcv_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="note_rcv_date" name="note_rcv_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['note_rcv_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="note_rcv_date" name="note_rcv_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['po_num'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="po_num" ' +
                                            'name="po_num" value="'+res[i]['po_num']+'" style="width: 100px"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="po_num" name="po_num" value="" ' +
                                            'style="width: 100px"></td>';
                                    }

                                    if(res[i]['po_value'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="po_value" ' +
                                            'name="po_value" value="'+res[i]['po_value']+'" style="width: 100px"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="po_value" name="po_value" value="" ' +
                                            'style="width: 100px"></td>';
                                    }

                                    if(res[i]['add_po'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="add_po" ' +
                                            'name="add_po" value="'+res[i]['add_po']+'" style="width: 180px"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="add_po" name="add_po" value="" ' +
                                            'style="width: 180px"></td>';
                                    }

                                    if(res[i]['type_of_doc'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="type_of_doc" name="type_of_doc" ' +
                                            'style="width: 100px;">' +
                                            '<option value="">Select Type of doc</option>';
                                        for(var x = 0; x < response.type_of_doc.length > 0; x++){
                                            if(res[i]['type_of_doc'] == response.type_of_doc[x]['type_of_doc']){
                                                tr += '<option value="'+response.type_of_doc[x]['type_of_doc']+'" ' +
                                                    'selected>'+response.type_of_doc[x]['type_of_doc']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.type_of_doc[x]['type_of_doc']+'">'+response.type_of_doc[x]['type_of_doc']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="type_of_doc" name="type_of_doc" ' +
                                            'style="width: 100px;"><option value="">Select Type of doc</option>';
                                        for(var x = 0; x < response.type_of_doc.length > 0; x++){
                                            tr += '<option value="'+response.type_of_doc[x]['type_of_doc']+'">'+response.type_of_doc[x]['type_of_doc']+'</option>';
                                        }
                                        tr += '</select></td>';
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

                                    if(res[i]['vendor_name'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="vendor_name" name="vendor_name" ' +
                                            'style="width: 250px;"><option value="">Select a vendor</option>';
                                        for(var x = 0; x < response.vendors.length > 0; x++){
                                            if(res[i]['vendor_id'] == response.vendors[x]['id']){
                                                tr += '<option value="'+response.vendors[x]['id']+'" ' +
                                                    'selected>'+response.vendors[x]['name']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.vendors[x]['id']+'">'+response
                                                    .vendors[x]['name']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="vendor_name" name="vendor_name" ' +
                                            'style="width: 250px;"><option value="">Select a vendor</option>';
                                        for(var x = 0; x < response.vendors.length > 0; x++){
                                            tr += '<option value="'+response.vendors[x]['id']+'">'+response
                                                .vendors[x]['name']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['local_agent'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" ' +
                                            'onchange="getAgentInfoDisplay('+res[i]['id']+')" id="local_agent"' +
                                            ' name="local_agent" style="width: 170px;"><option value="">Select a agent</option>';
                                        for(var x = 0; x < response.agents.length > 0; x++){
                                            if(res[i]['agent_id'] == response.agents[x]['id']){
                                                tr += '<option value="'+response.agents[x]['id']+'" ' +
                                                    'selected>'+response.agents[x]['local_agent']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.agents[x]['id']+'">'+response
                                                    .agents[x]['local_agent']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="local_agent"' +
                                            ' onchange="getAgentInfoDisplay('+res[i]['id']+')" name="local_agent" ' +
                                            'style="width: 170px;"><option value="">Select a agent</option>';
                                        for(var x = 0; x < response.agents.length > 0; x++){
                                            tr += '<option value="'+response.agents[x]['id']+'">'+response
                                                .agents[x]['local_agent']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['agent_name'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="agent_name" name="agent_name"' +
                                            ' value="'+res[i]['agent_name']+'" style="width: 100px" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="agent_name" name="agent_name"' +
                                            ' value="" style="width: 100px" disabled></td>';
                                    }

                                    if(res[i]['agent_num'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="agent_num" name="agent_num"' +
                                            ' value="'+res[i]['agent_num']+'" style="width: 100px" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="agent_num" name="agent_num"' +
                                            ' value="" style="width: 100px" disabled></td>';
                                    }

                                    if(res[i]['agent_email'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="agent_email" name="agent_email"' +
                                            ' value="'+res[i]['agent_email']+'" style="width: 180px" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="agent_email" name="agent_email"' +
                                            ' value="" style="width: 180px" disabled></td>';
                                    }

                                    if(res[i]['user_rcv_name'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="rcv_name" name="rcv_name"' +
                                            ' value="'+res[i]['user_rcv_name']+'" style="width: 100px"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="rcv_name" name="rcv_name"' +
                                            ' value="" style="width: 100px"></td>';
                                    }

                                    if(res[i]['user_rcv_email'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="rcv_email" name="rcv_email"' +
                                            ' value="'+res[i]['user_rcv_email']+'" style="width: 100px"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="rcv_email" name="rcv_email"' +
                                            ' value="" style="width: 100px"></td>';
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

                                    if(res[i]['pi_req_send'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="pi_req_send" name="pi_req_send" ' +
                                            'style="width:190px"><option value="">Select a option</option>' +
                                            '<option value="YES" '+(res[i]['pi_req_send'] === "YES" ? 'selected="selected"' : '')+'>YES</option>' +
                                            '<option value="NO" '+(res[i]['pi_req_send'] === "NO" ? 'selected="selected"' : '')+'>NO</option>' +
                                            '<option value="HOLD DUE TO ISSUE" '+(res[i]['pi_req_send'] === "HOLD DUE TO ISSUE" ? 'selected="selected"' : '')+'>HOLD DUE TO ISSUE</option>' +
                                            '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="pi_req_send" name="pi_req_send" ' +
                                            'style="width:190px"><option value="">Select a option</option>' +
                                            '<option value="YES">YES</option>' +
                                            '<option value="NO">NO</option>' +
                                            '<option value="HOLD DUE TO ISSUE">HOLD DUE TO ISSUE</option>' +
                                            '</select></td>';
                                    }

                                    if(res[i]['pi_req_send_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="pi_req_send_date" name="pi_req_send_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['pi_req_send_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="pi_req_send_date" name="pi_req_send_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['final_pi_rcv_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="final_pi_rcv_date" name="final_pi_rcv_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['final_pi_rcv_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="final_pi_rcv_date" name="final_pi_rcv_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['req_lc_tt_cad_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="req_for_open_lc_date" name="req_for_open_lc_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['req_lc_tt_cad_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="req_for_open_lc_date" name="req_for_open_lc_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['lc_tt_cad_share'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="lc_share" name="lc_share" ' +
                                            'style="width:100px"><option value="">Select a option</option>' +
                                            '<option value="YES" '+(res[i]['lc_tt_cad_share'] === "YES" ? 'selected="selected"' : '')+'>YES</option>' +
                                            '<option value="PENDING" '+(res[i]['lc_tt_cad_share'] === "PENDING" ? 'selected="selected"' : '')+'>PENDING</option>' +
                                            '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="lc_share" name="lc_share" ' +
                                            'style="width:100px"><option value="">Select a option</option>' +
                                            '<option value="YES">YES</option>' +
                                            '<option value="PENDING">PENDING</option>' +
                                            '</select></td>';
                                    }

                                    if(res[i]['lc_number'] != null){
                                        tr += '<td>'+res[i]['lc_number']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['draft_ship_doc_rcv_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="draft_ship_doc_rcv_date" name="draft_ship_doc_rcv_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['draft_ship_doc_rcv_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="draft_ship_doc_rcv_date" name="draft_ship_doc_rcv_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['final_ship_doc_rcv_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="final_ship_doc_rcved" name="final_ship_doc_rcved" ' +
                                            'style="width: 120px" value="'+moment(res[i]['final_ship_doc_rcv_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="final_ship_doc_rcved" name="final_ship_doc_rcved" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['send_for_endrsemnt_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="send_endorsement_date" name="send_endorsement_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['send_for_endrsemnt_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="send_endorsement_date" name="send_endorsement_date" ' +
                                            'style="width: 120px"></td>';
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
                                $('#updateMyTable #type_of_doc').select2();
                                $('#updateMyTable #mat_heading').select2();
                                $('#updateMyTable #shipment_mode').select2();
                                $('#updateMyTable #vendor_name').select2();
                                $('#updateMyTable #local_agent').select2();
                                $('#updateMyTable #t_concern_person').select2();
                                $('#updateMyTable #pi_req_send').select2();
                                $('#updateMyTable #lc_share').select2();
                            }else{
                                var tr = '';
                                tr += '<tr style="text-align: center;color: red">';
                                    tr += '<td colspan="35">There is no data available!</td>';
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
        });
        function getAgentInfo(rowID){
            var agent_id = $('#mytable #tableRow_id_'+rowID+' #local_agent').val();
            $.ajax({
                type: 'post',
                url: '{{url('import_management/getAgentInfo')}}',
                data: {
                    agent_id: agent_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (data) {
                    // console.log(data);
                    var result = data.result;
                    if(result.length > 0){
                        $('#mytable #tableRow_id_'+rowID+' #agent_name').val(result[0]['concern_name']);
                        $('#mytable #tableRow_id_'+rowID+' #agent_num').val(result[0]['mob_no']);
                        $('#mytable #tableRow_id_'+rowID+' #agent_email').val(result[0]['email']);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        function getAgentInfoDisplay(rowID){
            var agent_id = $('#updateMyTable #tableRow_id_'+rowID+' #local_agent').val();
            $.ajax({
                type: 'post',
                url: '{{url('import_management/getAgentInfo')}}',
                data: {
                    agent_id: agent_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (data) {
                    // console.log(data);
                    var result = data.result;
                    if(result.length > 0){
                        $('#updateMyTable #tableRow_id_'+rowID+' #agent_name').val(result[0]['concern_name']);
                        $('#updateMyTable #tableRow_id_'+rowID+' #agent_num').val(result[0]['mob_no']);
                        $('#updateMyTable #tableRow_id_'+rowID+' #agent_email').val(result[0]['email']);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        function checkPrNumInput(rowId){
            var pr_no = $('#mytable #tableRow_id_'+rowId+' #t_pr_num').val();
            var rowIDs = $('#mytable #row_ids').val();
            rowIDs = JSON.parse(rowIDs);
            var line_items = [];
            if(rowIDs.length > 0){
                for (var i = 0; i < rowIDs.length; i++){
                    if($('#mytable #tableRow_id_'+rowIDs[i]+' #t_pr_num').val() == pr_no && rowId != rowIDs[i]){
                        if($('#mytable #tableRow_id_'+rowIDs[i]+' #pr_date').val() != ''){
                            $('#mytable #tableRow_id_'+rowId+' #pr_date').val($('#mytable #tableRow_id_'+rowIDs[i]+' #pr_date').val());
                        }
                        line_items.push(parseInt($('#mytable #tableRow_id_'+rowIDs[i]+' #t_line_item').val()));
                    }
                }
            }
            if(line_items.length > 0){
                var max_val = Math.max.apply(Math, line_items);
                max_val = max_val+10;
                $('#mytable #tableRow_id_'+rowId+' #t_line_item').val(max_val);
            }
        }
    </script>
@endsection
