@extends('_layout_shared._master')
@section('title','SCM Material Purchase Information')
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
        #btn_save {
            color: #fff;
            background-color: #6463a2 !important;
            border-color: #6463a2 !important;
        }
        #btn_save:focus {
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
            font-size: 11px;
        }

        body {
            color: black;
        }

        label {
            font-size: 12px;
        }

        input, select {
            color: #000000;
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
            color: #444;
            line-height: 23px !important;
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
            height: 23px;
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

    </style>
@endsection
@section('right-content')
    <div class="row" id="mainDiv">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        SCM Material Purchase Information
                    </label>
                </header>
                <form action="" id="info_data">
                    <div class="panel-body" style="margin-top: 10px;">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-12">
                                <div class="input-group select2-bootstrap-prepend">
                                    <div class="input-group select2-bootstrap-prepend" style="display: flex">
                                        <select type="text" class="form-control" id="purMatPolist" name="purMatPolist">
                                            <option value="">Select PO Number</option>
                                            @if(count($poData) > 0)
                                                @foreach($poData as $po)
                                                    <option value="{{$po->id}}">{{$po->po_num}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                        <input type="text" value="Or" style="text-align: center; width: 30px; border: none;">
                                        <select type="text" class="form-control" id="purMatPrlist" name="purMatPrlist">
                                            <option value="">Select PR Number</option>
                                            @if(count($prData) > 0)
                                                @foreach($prData as $pr)
                                                    <option value="{{$pr->id}}">{{$pr->pr_num}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" id="btn_display" type="button"
                                                style="height: 25px;font-size: 12px; padding-top: 3px;">Display</button>
                                    </span>
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
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">SPARE PARTS, SERVICE AND CAPITAL MACHINERY</legend>
                                    <input type='hidden' id='tblRowId' name='tblRowId' value="">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="po_num"><b>PO Number:</b></label>
                                                <input type="text" id="po_num" name="po_num" class="form-control
                                                input-xs" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note_sheet_receiving_date"><b>Note Sheet R. date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="note_sheet_receiving_date" name="note_sheet_receiving_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="description"><b>Description:</b></label>
                                                <input type="text" class="form-control input-xs" id="description"
                                                       name="description">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="plant"><b>Plant:</b></label>
                                                <select type="text" class="form-control input-xs" id="plant"
                                                        name="plant">
                                                    <option value="">Select Plant</option>
                                                    @foreach($plants as $plant)
                                                        <option
                                                                value="{{$plant->plant_id}}">{{$plant->plant_id}}
                                                            - {{$plant->plant_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pi_value"><b>PI Value:</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="pi_value" name="pi_value">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pr_num"><b>PR Number:</b></label>
                                                <input type="text" class="form-control input-xs" id="pr_num"
                                                       name="pr_num">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pr_date"><b>PR date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="pr_date" name="pr_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="type_of_doc"><b>Type of doc:</b></label>
                                                <select type="text" class="form-control input-xs" id="type_of_doc"
                                                        name="type_of_doc">
                                                    <option value="">Select a type of document</option>
                                                    $type_of_doc
                                                    @foreach($type_of_doc as $type)
                                                        <option value="{{ strtolower($type->type_of_doc) }}">{{
                                                        $type->type_of_doc }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="currency"><b>Currency:</b></label>
                                                <select type="text" class="form-control input-xs" id="currency"
                                                        name="currency" onchange="setCurrencyRate(this)">
                                                    <option value="">Select Currency</option>
                                                    @foreach($currency_rate as $currData)
                                                        <option value="{{ $currData->currency
                                                        }}-{{ $currData->rate }}">{{ $currData->currency
                                                        }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="currency_rate" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="cer_date"><b>CER Date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="cer_date" name="cer_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="tracking_num"><b>Tracking Number:</b></label>
                                                <input type="text" class="form-control input-xs" id="tracking_num" name="tracking_num">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="vendor_name"><b>Vendor Name:</b></label>
                                                <input type="text" class="form-control input-xs" id="vendor_name"
                                                       name="vendor_name">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="local_agent"><b>Local Agent:</b></label>
                                                <input type="text" class="form-control input-xs" id="local_agent"
                                                       name="local_agent">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="agent_name"><b>Agent Name:</b></label>
                                                <input type="text" class="form-control input-xs" id="agent_name"
                                                       name="agent_name">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="agent_num"><b>Agent Number:</b></label>
                                                <input type="text" class="form-control input-xs" id="agent_num"
                                                       name="agent_num">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="agent_email"><b>Agent Email:</b></label>
                                                <input type="text" class="form-control input-xs" id="agent_email"
                                                       name="agent_email">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="receiver_name"><b>Receiver Name:</b></label>
                                                <input type="text" class="form-control input-xs" id="receiver_name"
                                                       name="receiver_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="receiver_email"><b>Receiver Email:</b></label>
                                                <input type="text" class="form-control input-xs" id="receiver_email"
                                                       name="receiver_email">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="concern_person"><b>Concern Person:</b></label>
                                                <select type="text" class="form-control input-xs" id="concern_person"
                                                        name="concern_person">
                                                    <option value="">Select a concern person</option>
                                                    @foreach($concern_person as $person)
                                                        <option value="{{$person->name}}">{{$person->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pi_req_send_or_correction"><b>PI request send or
                                                        correction:</b></label>
                                                <select type="text" class="form-control input-xs"
                                                        id="pi_req_send_or_correction" name="pi_req_send_or_correction">
                                                    <option value="">Select an option</option>
                                                    <option value="yes">YES</option>
                                                    <option value="no">NO</option>
                                                    <option value="hold">HOLD DUE TO ISSUE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pi_req_send_date"><b>PI request/ correction sending
                                                        date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="pi_req_send_date" name="pi_req_send_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="final_pi_received_date"><b>Final PI received date:</b></label>
                                                <input type="text" class="form-control input-xs" id="final_pi_received_date"
                                                       name="final_pi_received_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="req_for_open_lc_tt_cad_date"><b>Request for open LC/TT/CAD
                                                        date:</b></label>
                                                <input type="text" class="form-control input-xs" id="req_for_open_lc_tt_cad_date"
                                                       name="req_for_open_lc_tt_cad_date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_tt_cad_share"><b>LC/TT/CAD
                                                        Share:</b></label>
                                                <select type="text" class="form-control input-xs"
                                                        id="lc_tt_cad_share" name="lc_tt_cad_share">
                                                    <option value="">Select an option</option>
                                                    <option value="pending">PENDING</option>
                                                    <option value="shared">SHARED</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="draft_ship_doc_rcv_date"><b>Draft ship doc receive
                                                        Date:</b></label>
                                                <input type="text" class="form-control input-xs" id="draft_ship_doc_rcv_date"
                                                       name="draft_ship_doc_rcv_date" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="final_ship_doc_received"><b>Final ship doc
                                                        received:</b></label>
                                                <select type="text" class="form-control input-xs"
                                                        id="final_ship_doc_received" name="final_ship_doc_received">
                                                    <option value="">Select an option</option>
                                                    <option value="yes">YES</option>
                                                    <option value="no">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="final_ship_doc_rcv_date"><b>Final ship doc
                                                        received Date:</b></label>
                                                <input type="text" class="form-control input-xs" id="final_ship_doc_rcv_date"
                                                       name="final_ship_doc_rcv_date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shipment_value"><b>Shipment value:</b></label>
                                                <input type="text" class="form-control input-xs" id="shipment_value"
                                                       name="shipment_value">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="send_for_endorsemnt_date"><b>Send for endorsement date:</b></label>
                                                <input type="text" class="form-control input-xs" id="send_for_endorsemnt_date"
                                                       name="send_for_endorsemnt_date" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border2">
                                    <legend class="scheduler-border2">RAW PACK LAB</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="mat_code" ><b>Material Code:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="mat_code" name="mat_code">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="mat_desc" ><b>Material Desc.:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="mat_desc" name="mat_desc">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="vendor_or_indenter_name" ><b>Vendor/Indenter
                                                        name:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="vendor_or_indenter_name" name="vendor_or_indenter_name">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="manufacturer_name" ><b>Manufacturer Name:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="manufacturer_name" name="manufacturer_name">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="order_qty" ><b>Order Qty:</b></label>
                                                <input type="number" class="form-control input-xs"
                                                       id="order_qty" name="order_qty" min="0" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="order_unit"><b>Order unit:</b></label>
                                                <input type="text" class="form-control input-xs" id="order_unit" name="order_unit">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pi_no"><b>PI no:</b></label>
                                                <input type="text" class="form-control input-xs" id="pi_no"
                                                       name="pi_no">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pi_date"><b>PI Date:</b></label>
                                                <input type="text" class="form-control input-xs" id="pi_date" name="pi_date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="unit_price"><b>Unit Price:</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="unit_price"
                                                       name="unit_price">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="freight"><b>Freight:</b></label>
                                                <input type="text" class="form-control input-xs" id="freight"
                                                       name="freight">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="blocklist_status"><b>Blocklist Status:</b></label>
                                                <input type="text" class="form-control input-xs" id="blocklist_status"
                                                       name="blocklist_status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="shipment_mode"><b>Shipment Mode:</b></label>
                                                <select type="text" class="form-control input-xs" id="shipment_mode"
                                                        name="shipment_mode">
                                                    <option value="">Select a shipment mode:</option>
                                                    <option value="sea">BY SEA</option>
                                                    <option value="air">BY AIR</option>
                                                    <option value="road">BY ROAD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="hs_code"><b>H.S. Code (P):</b></label>
                                                <input type="text" class="form-control input-xs" id="hs_code"
                                                       name="hs_code">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="sent_to_open_lc_tt_cad_dt"><b>SENT TO OPEN LC/TT/CAD DT:</b></label>
                                                <input type="text" class="form-control input-xs" id="sent_to_open_lc_tt_cad_dt"
                                                       name="sent_to_open_lc_tt_cad_dt">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">COMMERCIAL - LC TEAM</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="received_date_of_pi_and_indent"><b>Received date of PI
                                                        and Indent:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="received_date_of_pi_and_indent" name="received_date_of_pi_and_indent">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bank_name"><b>Bank Name:</b></label>
                                                <select type="text" class="form-control input-xs" id="bank_name"
                                                        name="bank_name">
                                                    <option value="">Select a bank</option>
                                                    @foreach($bank_info as $bank)
                                                        <option value="{{$bank->bank_name}}">{{$bank->bank_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="insurance_name"><b>Insurance Name:</b></label>
                                                <select type="text" class="form-control input-xs" id="insurance_name"
                                                        name="insurance_name">
                                                    <option value="">Select an insurance</option>
                                                    @foreach($insu_info as $ins)
                                                        <option
                                                                value="{{$ins->insurance_name}}">{{$ins->insurance_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="insurance_num"><b>Insurance number:</b></label>
                                                <input type="text" class="form-control input-xs" id="insurance_num" name="insurance_num">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bank_delivery_date"><b>Bank delivery date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="bank_delivery_date" name="bank_delivery_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="type_of_lc"><b>Types of LC:</b></label>
                                                <select type="text" class="form-control input-xs" id="type_of_lc"
                                                        name="type_of_lc">
                                                    <option value="">Select a type of lc</option>
                                                    @foreach($lc_type as $lc)
                                                        <option value="{{$lc->lc_type}}">{{$lc->lc_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_num"><b>LC Number:</b></label>
                                                <input type="text" class="form-control input-xs" id="lc_num"
                                                       name="lc_num">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_date"><b>LC date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="lc_date" name="lc_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lds_date"><b>LDS Date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="lds_date" name="lds_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tentative_revd_month"><b>Tentative Received
                                                        Month:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="tentative_revd_month" name="tentative_revd_month">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border2">
                                    <legend class="scheduler-border2">DOCUMENTATION TEAM</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="ship_or_org_doc_rcved_dt" ><b>Ship doc rcvd
                                                        dt / original doc rcvd dt:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="ship_or_org_doc_rcved_dt" name="ship_or_org_doc_rcved_dt">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="passing_days" ><b>Passing Days:</b></label>
                                                <input type="text" class="form-control input-xs" id="passing_days" name="passing_days" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="mawb_tr_or_bl_no" ><b>MAWB/TR/BL No:</b></label>
                                                <input type="text" class="form-control input-xs" id="mawb_tr_or_bl_no" name="mawb_tr_or_bl_no">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="hawb_no" ><b>HAWB No:</b></label>
                                                <input type="text" class="form-control input-xs" id="hawb_no" name="hawb_no">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="awb_or_bl_date" ><b>AWB/BL Date:</b></label>
                                                <input type="text" class="form-control input-xs" autocomplete="off"
                                                       id="awb_or_bl_date" name="awb_or_bl_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="material_arrival_date" ><b>Material Arr. date:</b></label>
                                                <input type="text" class="form-control input-xs" autocomplete="off"
                                                       id="material_arrival_date" name="material_arrival_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bnk_sndng_or_acptnce_dt" ><b>Bank sending date/acceptance date:</b></label>
                                                <input type="text" class="form-control input-xs" autocomplete="off"
                                                       id="bnk_sndng_or_acptnce_dt" name="bnk_sndng_or_acptnce_dt">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="receive_from_bank_date" ><b>Receive from bank date:</b></label>
                                                <input type="text" class="form-control input-xs" autocomplete="off"
                                                       id="receive_from_bank_date" name="receive_from_bank_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="c_and_f" ><b>C&F:</b></label>
                                                <select class="form-control input-xs" id="c_and_f" name="c_and_f">
                                                    <option value="">Select a option</option>
                                                    @foreach($c_and_f as $cf)
                                                        <option value="{{$cf->c_and_f}}">{{$cf->c_and_f}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="c_and_f_date" ><b>C&F Date:</b></label>
                                                <input type="text" class="form-control input-xs" autocomplete="off"
                                                       id="c_and_f_date" name="c_and_f_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="invoice_num" ><b>Invoice Number:</b></label>
                                                <input type="text" class="form-control input-xs" id="invoice_num"
                                                       name="invoice_num">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="remarks" ><b>Remarks:</b></label>
                                                <input type="text" class="form-control input-xs" id="remarks"
                                                       name="remarks">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="release_hs_code" ><b>Release HS Code:</b></label>
                                                <input type="number" class="form-control input-xs" id="release_hs_code"
                                                       name="release_hs_code">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bill_of_entry_num" ><b>Bill of entry no:</b></label>
                                                <input type="text" class="form-control input-xs" id="bill_of_entry_num"
                                                       name="bill_of_entry_num">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bill_of_entry_date" ><b>Bill of entry date:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       autocomplete="off" id="bill_of_entry_date" name="bill_of_entry_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="drug" ><b>Drug:</b></label>
                                                <input type="text" class="form-control input-xs" id="drug"
                                                       name="drug">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="policy" ><b>Policy:</b></label>
                                                <input type="text" class="form-control input-xs" id="policy"
                                                       name="policy">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="status" ><b>Status:</b></label>
                                                <input type="text" class="form-control input-xs" id="status"
                                                       name="status">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="delivery_date" ><b>Delivery Date:</b></label>
                                                <input type="text" class="form-control input-xs" id="delivery_date" name="delivery_date" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">FINANCE</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="year"><b>Year:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="year" name="year" readonly
                                                       placeholder="Choose PI decision date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="month"><b>Month:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="month" name="month" readonly
                                                       placeholder="Choose PI decision date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pi_decision_date"><b>PI decision date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="pi_decision_date" name="pi_decision_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_open_year"><b>LC open year:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="lc_open_year" name="lc_open_year" readonly
                                                       placeholder="Choose LC open date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_open_month"><b>LC open month:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="lc_open_month" name="lc_open_month" readonly
                                                       placeholder="Choose LC open date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_open_date"><b>LC open date:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="lc_open_date" name="lc_open_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_open_status"><b>LC Open status:</b></label>
                                                <input type="text" class="form-control input-xs" id="lc_open_status"
                                                       name="lc_open_status" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="com_or_plant" ><b>Com/Plant:</b></label>
                                                <select class="form-control input-xs" id="com_or_plant" name="com_or_plant">
                                                    <option value="">Select a company</option>
                                                    @foreach($companyData as $company)
                                                        <option value="{{ $company->com_id }}">{{ $company->com_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="division"><b>Division:</b></label>
                                                <input type="text" autocomplete="off" class="form-control input-xs"
                                                       id="division" name="division">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="terms_of_payment"><b>Terms of payment:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="terms_of_payment" name="terms_of_payment" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lc_type_trs"><b>LC Type (TRS):</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="lc_type_trs" name="lc_type_trs" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country_of_origin"><b>Country of Origin:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="country_of_origin" name="country_of_origin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bdt_value"><b>BDT Value:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="bdt_value" name="bdt_value" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bdt_in_million"><b>BDT in Million:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="bdt_in_million" name="bdt_in_million" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mat_rcv_status"><b>Material Receive Status:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="mat_rcv_status" name="mat_rcv_status" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="payment_term"><b>Payment term:</b></label>
                                                <input type="number" class="form-control input-xs"
                                                       id="payment_term" name="payment_term" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tentative_due_month"><b>Tentative Due Month:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="tentative_due_month" name="tentative_due_month" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="acceptance_value"><b>Acceptance Value:</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="acceptance_value" name="acceptance_value">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="acceptance_value_in_bdt"><b>Acceptance Value in BDT:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="acceptance_value_in_bdt" name="acceptance_value_in_bdt" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="acceptance_date"><b>Acceptance Date:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="acceptance_date" name="acceptance_date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="due_date_actu"><b>Due Date ACTU:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="due_date_actu" name="due_date_actu" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="due_month"><b>Due Month Actual:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="due_month" name="due_month" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="payment_date"><b>Payment date:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="payment_date" name="payment_date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pmt_mon"><b>Payment month:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="pmt_mon" name="pmt_mon" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="payment_status"><b>Payment status:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       id="payment_status" name="payment_status" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-8 col-md-offset-2 text-center" style="padding-top: 20px;">
                                <button type="button" id="btn_refresh" class="btn btn-info btn-sm">
                                    <i class="fa fa-rotate-right"></i> <b>REFRESH</b></button>
                                <button type="button" id="btn_save" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> <b>SAVE</b></button>
                                <button type="button" id="btn_update" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> <b>UPDATE</b></button>
                            </div>
                        </div>
                    </div>
                </form>
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
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}

    <script>
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        const ShortMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        $(document).ready(function () {
            $('#btn_update').prop('disabled', true);

            $('#purMatPolist').select2();
            $('#purMatPrlist').select2();
            $('#plant').select2();
            $('#com_or_plant').select2();
            $('#currency').select2();

            $('#note_sheet_receiving_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#pr_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#payment_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#draft_ship_doc_rcv_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#final_ship_doc_rcv_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#send_for_endorsemnt_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#due_date_actu').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#delivery_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#cer_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#bill_of_entry_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#pi_req_send_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#final_pi_received_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#req_for_open_lc_tt_cad_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#pi_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#sent_to_open_lc_tt_cad_dt').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#awb_or_bl_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#material_arrival_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#bnk_sndng_or_acptnce_dt').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#acceptance_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#receive_from_bank_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#c_and_f_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#received_date_of_pi_and_indent').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#bank_delivery_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#lc_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#lds_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#ship_or_org_doc_rcved_dt').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#tentative_revd_month').datepicker({
                format: "M-yy",
                startView: "months",
                minViewMode: "months",
                autoclose:true
            });

            $('#pi_decision_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#lc_open_date').datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: 'TRUE',
                autoclose: true
            });

            $('#pi_decision_date').datepicker().on('change', function (dateText, inst) {
                var date = $(this).datepicker('getDate'),
                    month = date.getMonth() + 1,
                    year =  date.getFullYear();
                $('#year').val(year);
                $('#month').val(monthNames[month-1]);
            });

            $('#due_date_actu').datepicker().on('change', function (dateText, inst) {
                var date = $(this).datepicker('getDate'),
                    month = date.getMonth() + 1,
                    year =  date.getFullYear().toString().substr(-2);
                $('#due_month').val(ShortMonthNames[month-1]+"-"+year);
            });

            if($('#due_date_actu').val() == ''){
                $('#due_month').val($('#tentative_due_month').val());
            }

            $('#payment_date').datepicker().on('change', function (dateText, inst) {
                var date = $(this).datepicker('getDate'),
                    month = date.getMonth() + 1;
                $('#pmt_mon').val(monthNames[month-1]);
            });

            $('#lc_open_date').datepicker().on('change', function (dateText, inst) {
                var date = $(this).datepicker('getDate'),
                    day  = date.getDate(),
                    month = date.getMonth() + 1,
                    year =  date.getFullYear();
                $('#lc_open_year').val(year);
                $('#lc_open_month').val(monthNames[month-1]);
            });

            $('#ship_or_org_doc_rcved_dt').datepicker().on('change', function (ev) {
                var date = new Date();
                var firstDate = $(this).val();

                if(firstDate != "") {
                    var date1 = moment(firstDate);
                    var date2 = moment(date);
                    var diff = date2.diff(date1, 'days');

                    $('#passing_days').val(diff);
                }else{
                    $('#passing_days').val('');
                }
            });

            $('#delivery_date').datepicker().on('change', function (ev) {
                var firstDate = $(this).val();
                if(firstDate == ""){
                    $('#mat_rcv_status').val('Not Rec');
                }else{
                    $('#mat_rcv_status').val('Rec');
                }
            });
            if($('#delivery_date').val() == ''){
                $('#mat_rcv_status').val('Not Rec');
            }else{
                $('#mat_rcv_status').val('Rec');
            }

            $('#payment_date').datepicker().on('change', function (ev) {
                var firstDate = $(this).val();
                if(firstDate == ""){
                    $('#payment_status').val('DUE');
                }else{
                    $('#payment_status').val('PAID');
                }
            });
            if($('#payment_date').val() == ''){
                $('#payment_status').val('DUE');
            }else{
                $('#payment_status').val('PAID');
            }

            $(document).on("change", "#payment_term, #delivery_date, #tentative_due_month, #due_date_actu", function(){
                if($("#payment_term").val() != "" && $("#delivery_date").val() != ""){
                    var term = parseInt($("#payment_term").val());
                    var date = new Date($("#delivery_date").val());
                    date.setDate(date.getDate() + term);
                    var dueMonth = moment(date).format('MM/DD/YYYY');
                    $('#tentative_due_month').val(dueMonth);
                }else{
                    $('#tentative_due_month').val('');
                    if($('#due_date_actu').val() == ''){
                        $('#due_month').val("");
                    }else{
                        $('#due_month').val(moment($('#due_date_actu').val()).format('MMM-YY'));
                    }
                }
                if($('#tentative_due_month').val() != ""){
                    if($('#due_date_actu').val() == ''){
                        $('#due_month').val(moment($('#tentative_due_month').val()).format('MMM-YY'));
                    }
                }
            });

            $(document).on("change", "#pi_value, #currency, #acceptance_value", function(){
                if($('#pi_value').val() != "" && $('#currency').val() != ""){
                    var rate = $('#currency_rate').val();
                    rate = parseInt(rate);
                    var bdt_val = $('#pi_value').val()*rate;
                    $('#bdt_value').val(bdt_val);
                    $('#bdt_in_million').val(bdt_val/1000000);
                }else{
                    $('#bdt_value').val('');
                    $('#bdt_in_million').val('');
                }
                if($('#acceptance_value').val() != "" && $('#currency').val() != ""){
                    var rate = $('#currency_rate').val();
                    rate = parseInt(rate);
                    var acceptance_value = $('#acceptance_value').val()*rate;
                    $('#acceptance_value_in_bdt').val(acceptance_value);
                }else{
                    $('#acceptance_value_in_bdt').val('');
                }
            });

            function objectifyForm(formArray) {
                var returnArray = {};
                for (var i = 0; i < formArray.length; i++) {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
                return returnArray;
            }

            if($('#lc_num').val() == ""){
                $('#lc_open_status').val('Not Opened');
            }else{
                $('#lc_open_status').val('Opened');
            }
            $('input[name=lc_num]').change(function() {
                if($('#lc_num').val() == ""){
                    $('#lc_open_status').val('Not Opened');
                }else{
                    $('#lc_open_status').val('Opened');
                }
            });

            $('input[name=terms_of_payment]').change(function() {
                if($('#terms_of_payment').val() == "UPAS-180"){
                    $('#lc_type_trs').val('DP');
                }else if($('#terms_of_payment').val() == "SIGHT"){
                    $('#lc_type_trs').val('S');
                }else if($('#terms_of_payment').val() == "CAD"){
                    $('#lc_type_trs').val('S');
                }else{
                    $('#lc_type_trs').val('');
                }
            });

            $('#btn_refresh').on('click', function () {
                window.location.reload();
            });
            $('#btn_save').on('click', function () {
                var formdata = $('#info_data').serializeArray();
                var formdat = objectifyForm(formdata);
                // console.log(formdat);

                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/saveMaterialData')}}',
                    data: {
                        fdata: formdat,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);

                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been saved successfully');
                            setTimeout(function(){
                                window.location.reload();
                            }, 2000);
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to save data');
                        console.log(error);
                    }
                });
            });
            $('#btn_update').on('click', function () {
                var formdata = $('#info_data').serializeArray();
                var postdata = objectifyForm(formdata);
                postdata.po_num = $('#po_num').val();
                postdata.pr_num = $('#pr_num').val();
                postdata.bank_name = $('#bank_name').val();
                postdata.c_and_f = $('#c_and_f').val();
                // console.log(postdata);

                $.ajax({
                    type: 'post',
                    url: '{{url('import_management/updateMaterialData')}}',
                    data: {
                        fdata: postdata,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 1 || response.status == true) {
                            toastr.info('Data has been updated successfully');

                            $('#info_data')[0].reset();

                            $('#btn_update').prop('disabled', true);
                            $('#btn_save').prop('disabled', false);

                            $.ajax({
                                type: "get",
                                url: '{{url('import_management/getLatestPoPrList')}}',
                                success: function (data) {
                                    // console.log(data);

                                    var poData = data.poData;
                                    var prData = data.prData;

                                    var poHTML = "";
                                    var prHTML = "";

                                    if(poData.length > 0){
                                        poHTML += '<option value="">Select PO Number</option>';
                                        for(var i = 0; i < poData.length; i++){
                                            poHTML += '<option ' +
                                                'value="'+poData[i]['id']+'">'+poData[i]['po_num']+'</option>';
                                        }
                                    }else{
                                        poHTML += '<option value="" disabled style="text-align: center">There is no data</option>';
                                    }
                                    $("#purMatPolist").html(poHTML);
                                    $("#purMatPolist").select2();

                                    if(prData.length > 0){
                                        prHTML += '<option value="">Select PR Number</option>';
                                        for(var j = 0; j < prData.length; j++){
                                            prHTML += '<option ' +
                                                'value="'+prData[j]['id']+'">'+prData[j]['pr_num']+'</option>';
                                        }
                                    }else{
                                        prHTML += '<option value="" disabled style="text-align: center">There is no data</option>';
                                    }
                                    $("#purMatPrlist").html(prHTML);
                                    $("#purMatPrlist").select2();
                                }
                            });
                        }else{
                            toastr.error(response.result);
                        }
                    },
                    error: function (error) {
                        toastr.info('Unable to update data');
                        console.log(error);
                    }
                })
            });
            $('#btn_display').on('click', function () {
                if($('#purMatPolist').val() == "" && $('#purMatPrlist').val() == ""){
                    toastr.error('Select either PO number or PR number!');
                    $('#btn_update').prop('disabled', true);
                    $('#btn_save').prop('disabled', false);
                }else{
                    $('#loader').show();
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/retrieveMatPurchaseInfo')}}',
                        data: {
                            po: $('#purMatPolist').val(),
                            pr: $('#purMatPrlist').val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            // console.log(response);
                            $('#tblRowId').val(response.result[0].id);

                            $('#plant').val(response.result[0].plant);
                            $("#plant").trigger('change');

                            $('#com_or_plant').val(response.result[0].com_or_plant);
                            $("#com_or_plant").trigger('change');

                            $('#currency').val(response.result[0].currency);
                            $("#currency").trigger('change');

                            if(response.result[0].note_sheet_receiving_date !== null){
                                response.result[0].note_sheet_receiving_date = moment(response.result[0].note_sheet_receiving_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].awb_or_bl_date !== null){
                                response.result[0].awb_or_bl_date = moment(response.result[0].awb_or_bl_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].bank_delivery_date !== null){
                                response.result[0].bank_delivery_date = moment(response.result[0].bank_delivery_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].bill_of_entry_date !== null){
                                response.result[0].bill_of_entry_date = moment(response.result[0].bill_of_entry_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].bnk_sndng_or_acptnce_dt !== null){
                                response.result[0].bnk_sndng_or_acptnce_dt = moment(response.result[0].bnk_sndng_or_acptnce_dt).format('MM/DD/YYYY');
                            }
                            if(response.result[0].c_and_f_date !== null){
                                response.result[0].c_and_f_date = moment(response.result[0].c_and_f_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].cer_date !== null){
                                response.result[0].cer_date = moment(response.result[0].cer_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].delivery_date !== null){
                                response.result[0].delivery_date = moment(response.result[0].delivery_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].final_pi_received_date !== null){
                                response.result[0].final_pi_received_date = moment(response.result[0].final_pi_received_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].lc_date !== null){
                                response.result[0].lc_date = moment(response.result[0].lc_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].lds_date !== null){
                                response.result[0].lds_date = moment(response.result[0].lds_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].material_arrival_date !== null){
                                response.result[0].material_arrival_date = moment(response.result[0].material_arrival_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].pi_date !== null){
                                response.result[0].pi_date = moment(response.result[0].pi_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].pi_req_send_date !== null){
                                response.result[0].pi_req_send_date = moment(response.result[0].pi_req_send_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].pr_date !== null){
                                response.result[0].pr_date = moment(response.result[0].pr_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].receive_from_bank_date !== null){
                                response.result[0].receive_from_bank_date = moment(response.result[0].receive_from_bank_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].req_for_open_lc_tt_cad_date !== null){
                                response.result[0].req_for_open_lc_tt_cad_date = moment(response.result[0].req_for_open_lc_tt_cad_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].sent_to_open_lc_tt_cad_dt !== null){
                                response.result[0].sent_to_open_lc_tt_cad_dt = moment(response.result[0].sent_to_open_lc_tt_cad_dt).format('MM/DD/YYYY');
                            }
                            if(response.result[0].ship_or_org_doc_rcved_dt !== null){
                                response.result[0].ship_or_org_doc_rcved_dt = moment(response.result[0].ship_or_org_doc_rcved_dt).format('MM/DD/YYYY');
                            }
                            if(response.result[0].draft_ship_doc_rcv_date !== null){
                                response.result[0].draft_ship_doc_rcv_date = moment(response.result[0].draft_ship_doc_rcv_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].final_ship_doc_rcv_date !== null){
                                response.result[0].final_ship_doc_rcv_date = moment(response.result[0].final_ship_doc_rcv_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].due_date_actu !== null){
                                response.result[0].due_date_actu = moment(response.result[0].due_date_actu).format('MM/DD/YYYY');
                            }
                            if(response.result[0].lc_open_date !== null){
                                response.result[0].lc_open_date = moment(response.result[0].lc_open_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].payment_date !== null){
                                response.result[0].payment_date = moment(response.result[0].payment_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].pi_decision_date !== null){
                                response.result[0].pi_decision_date = moment(response.result[0].pi_decision_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].send_for_endorsemnt_date !== null){
                                response.result[0].send_for_endorsemnt_date = moment(response.result[0].send_for_endorsemnt_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].received_date_of_pi_and_indent !== null){
                                response.result[0].received_date_of_pi_and_indent = moment(response.result[0].received_date_of_pi_and_indent).format('MM/DD/YYYY');
                            }
                            if(response.result[0].acceptance_date !== null){
                                response.result[0].acceptance_date = moment(response.result[0].acceptance_date).format('MM/DD/YYYY');
                            }
                            if(response.result[0].tentative_due_month !== null){
                                response.result[0].tentative_due_month = moment(response.result[0].tentative_due_month).format('MM/DD/YYYY');
                            }

                            $('#info_data').autofill(response.result[0]);

                            // if(response.result[0].po_num !== null){
                            //     $('#po_num').prop('disabled', true);
                            // }else{
                            //     $('#po_num').prop('disabled', false);
                            // }

                            // if(response.result[0].pr_num !== null){
                            //     $('#pr_num').prop('disabled', true);
                            // }else{
                            //     $('#pr_num').prop('disabled', false);
                            // }

                            $('#btn_update').prop('disabled', false);
                            $('#btn_save').prop('disabled', true);

                            if($('#delivery_date').val() == ''){
                                $('#mat_rcv_status').val('Not Rec');
                            }else{
                                $('#mat_rcv_status').val('Rec');
                            }
                            if($('#payment_date').val() == ''){
                                $('#payment_status').val('DUE');
                            }else{
                                $('#payment_status').val('PAID');
                            }
                            if($('#lc_num').val() == ""){
                                $('#lc_open_status').val('Not Opened');
                            }else{
                                $('#lc_open_status').val('Opened');
                            }

                            $('#loader').hide();
                        },
                        error: function (error) {
                            toastr.info('Unable to fetch data');
                            console.log(error);
                            $('#btn_update').prop('disabled', true);
                            $('#btn_save').prop('disabled', false);
                            $('#loader').hide();
                        }
                    })
                }
            });
        });
        function setCurrencyRate(e){
            var value = $(e).val();
            const myArray = value.split("-");
            let rate = myArray[1];
            $('#currency_rate').val(rate);
        }
    </script>
@endsection
