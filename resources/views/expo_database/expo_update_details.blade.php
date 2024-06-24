<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 17/01/2021
 * Time: 11:36 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Export Country Wise Data')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .form-group.required .control-label:after {
            content: "*";
            color: red;
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

        .help-block {
            color: red;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
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

        .table > thead > tr > th {
            padding: 2px;
            font-size: 9px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 9px;
        }


    </style>
@endsection
@section('right-content')

    @foreach ($rs as $item)
        <div class="col-md-12 col-sm-12" style="padding-top: 1%" id="maintop">
            <section class="panel panel-info">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <input type="hidden" name="line_id" id="line_id" value="{{  $item->line_id }}">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="fi_prod"
                                           class="col-md-5 col-sm-5 control-label"><b>Finish Product</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" autocomplete="off" value="{{ $item->finish_product_code }}"
                                               class="form-control input-sm" autocomplete="off" id="fi_prod"
                                               name="fi_prod">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="local_pcode"
                                           class="col-md-5 col-sm-5 control-label "><b>Product Code</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" id="local_pcode"
                                               value="{{ $item->product_code }}" name="local_pcode">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                {{--<label>Finish Product</label>--}}
                                <div class="form-group">
                                    <label for="brand_name"
                                           class="col-md-5 col-sm-5 control-label "><b>Brand Name</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" autocomplete="off"
                                               id="brand_name"
                                               value="{{ $item->brand_name }}" name="brand_name">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-12 col-sm-12">


                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="exp_country"
                                           class="col-md-5 col-sm-5 control-label "><b>Exp. Country</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" autocomplete="off"
                                               id="exp_country"
                                               value="{{ $item->export_country }}" name="exp_country">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="expo_product_name"
                                           class="col-md-5 col-sm-5 control-label "><b>Product Name</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" autocomplete="off"
                                               id="expo_product_name"
                                               value="{{ $item->expo_product_name }}" name="expo_product_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="gen_name"
                                           class="col-md-5 col-sm-5 control-label "><b>Generic Name</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" autocomplete="off"
                                               id="gen_name"
                                               value="{{ $item->product_generic }}" name="gen_name">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-12 col-sm-12">

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="pack_size"
                                           class="col-md-5 col-sm-5 control-label "><b>Pack Size</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" autocomplete="off"
                                               id="pack_size"
                                               value="{{ $item->pack_size }}" name="pack_size">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4">

                                <div class="form-group">
                                    <label for="com_agent"
                                           class="col-md-5 col-sm-5 control-label "><b>Agent(Company)</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" autocomplete="off"
                                               id="com_agent"
                                               value="{{ $item->company_agent_name }}" name="com_agent">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="contact_name"
                                           class="col-md-5 col-sm-5 control-label "><b>Agent Person</b></label>
                                    <div class="col-md-7 col-sm-7">
                                        <input type="text" class="form-control input-sm" autocomplete="off"
                                               id="contact_name"
                                               value="{{ $item->contact_name }}" name="contact_name">
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-12 col-sm-12">

                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <div class="form-group">
                                    <label for="address"
                                           class="col-md-2 col-sm-2 control-label"><b>Address</b></label>
                                    <div class="col-md-10 col-sm-10">
                                        <input type="text" class="form-control input-sm" autocomplete="off" id="address"
                                               value="{{ $item->address }}" name="address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="contact_name"
                                           class="ol-md-5 col-sm-5 control-label"><b>Plant</b></label>
                                    <div class="col-md-4 col-sm-4">
                                        <input type="text" id="plant_id" value="{{ $item->plant_id }}" name="plant_id">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <div id="entry_body" class="col-md-12 col-sm-12" style="padding-top: 1%;">
                    <section class="panel panel-info">

                        <div class="panel-body" style="padding-top: 2%;background-color: #E5E7E9">

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-3">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-4">
                                                        <i class=""></i>
                                                    </div>
                                                    <div class="col-xs-8" id="form_status">
                                                        <span class="state-title"> {{ $item->form_status }}  </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-horizontal">


                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    {{--IRA STAGE-1--}}
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">IRA STAGE-1</h3>
                                        </div>
                                        <div class="panel-body">

                                            <form id="stage-1" enctype="multipart/form-data">
                                                {{--                                        {{ csrf_field() }}--}}

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="im_team"
                                                                       class="col-lg-4 col-sm-4 col-md-4 control-label control-label">IM
                                                                    Team</label>
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    {{--                                                            <input type="text" class="form-control input-sm"--}}
                                                                    {{--                                                                   id="im_team"--}}
                                                                    {{--                                                                   name="im_team">--}}

                                                                    <select name="im_team" id="im_team"
                                                                            class="form-control input-sm im_team"
                                                                            autocomplete="off">
                                                                        <option value="{{ $item->im_team }}" selected
                                                                                readonlye>{{ $item->im_team }}</option>
                                                                        {{-- <option value="IM-1">IM-1</option>
                                                                        <option value="IM-2">IM-2</option>
                                                                        <option value="Tender">Tender</option>
                                                                        <option value="B2B">B2B</option>
                                                                        <option value="B2B">MAH/Other</option> --}}

                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="sub_to_im_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Submitted
                                                                    TO IM</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">


                                                                    <input type="text" autocomplete="off"
                                                                           value="{{ \Carbon\Carbon::parse($item->submitted_to_im)->format('d-M-Y')}}"
                                                                           class="form-control input-sm" readonly
                                                                           placeholder="Date"
                                                                           name="sub_to_im_date"
                                                                           style="font-size: small; padding-right: 0px;"
                                                                           id="sub_to_im_date">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="sub_name"
                                                                       class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Sub.
                                                                    To
                                                                    Name</label>
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <input type="text" autocomplete="off"
                                                                           value="{{ $item->sub_name }}"
                                                                           class="form-control input-sm"
                                                                           placeholder="Full Name"
                                                                           id="sub_name"
                                                                           name="sub_name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="sub_by_ira"
                                                                       class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Sub.
                                                                    By IRA
                                                                </label>
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <input type="text" autocomplete="off"
                                                                           value="{{ $item->sub_by_ira }}"
                                                                           class="form-control input-sm"
                                                                           placeholder="Full Name"
                                                                           id="sub_by_ira"
                                                                           name="sub_by_ira">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="type_of_dossier"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Dossier
                                                                    Type</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    <select name="type_of_dossier" id="type_of_dossier"
                                                                            autocomplete="off"
                                                                            class="form-control input-sm type_of_dossier">
                                                                        <option value="{{ $item->dossier_type }}"
                                                                                selected
                                                                                readonlye>{{ $item->dossier_type }}</option>
                                                                        {{-- <option value="">SELECT DOSSIER</option>
                                                                        <option value="CTD">CTD</option>
                                                                        <option value="NON_CTD">NON CTD</option>
                                                                        <option value="REUSED_CTD">RE-USED CTD</option> --}}
                                                                    </select>


                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                {{-- <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <button class="btn btn-success" id="stg1_save" type="button"><i
                                                                    class="fa fa-save"></i> Save
                                                        </button>
                                                        <button class="btn btn-info" id="stg1_refresh" type="button"><i
                                                                    class="fa fa-refresh"></i> Refresh
                                                        </button>
                                                    </div>
                                                </div> --}}
                                            </form>

                                        </div>
                                    </div>


                                    {{--files--}}
                                    <div class="row" id="filesLocation" ;>
                                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                            <div class="panel">
                                                <span class="label label-warning">Documents</span>
                                                <span id="pdf_draw">
                                                @if($item->dossier_type == 'NON_CTD')
                                                        @if($item->nonctd_api_source)
                                                            <a href="{{ url('/public'.$item->nonctd_api_source) }}"
                                                               target='_blank'><span style='padding-left: 10px'>NON CTD API Source </span></a>
                                                        @endif
                                                        @if($item->nonctd_fp_spec)
                                                            <a href="{{ url('/public'.$item->nonctd_fp_spec) }}"
                                                               target='_blank'><span style='padding-left: 10px'>NON CTD Specification </span></a>
                                                        @endif
                                                        @if($item->nonctd_manufacturer)
                                                            <a href="{{ url('/public'.$item->nonctd_manufacturer) }}"
                                                               target='_blank'><span style='padding-left: 10px'>NON CTD Manufacturer </span></a>
                                                        @endif
                                                        @if($item->nonctd_stability)
                                                            <a href="{{ url('/public'.$item->nonctd_stability) }}"
                                                               target='_blank'><span style='padding-left: 10px'>NON CTD Stability </span></a>
                                                        @endif
                                                    @elseif($item->dossier_type == 'CTD')
                                                        @if($item->ctd_api_source)
                                                            <a href="{{ url('/public'.$item->ctd_api_source) }}"
                                                               target='_blank'><span style='padding-left: 10px'>CTD API Source </span></a>
                                                        @endif
                                                        @if($item->ctd_fp_spec)
                                                            <a href="{{ url('/public'.$item->ctd_fp_spec) }}"
                                                               target='_blank'><span style='padding-left: 10px'>CTD Specification </span></a>
                                                        @endif
                                                        @if($item->ctd_manufacturer)
                                                            <a href="{{ url('/public'.$item->ctd_manufacturer) }}"
                                                               target='_blank'><span style='padding-left: 10px'>CTD Manufacturer </span></a>
                                                        @endif
                                                        @if($item->ctd_stability)
                                                            <a href="{{ url('/public'.$item->ctd_stability) }}"
                                                               target='_blank'><span style='padding-left: 10px'>CTD Stability </span></a>
                                                        @endif
                                                    @elseif($item->dossier_type == 'REUSED_CTD')
                                                        @if($item->reuse_ctd_api_source)
                                                            <a href="{{ url('/public'.$item->reuse_ctd_api_source) }}"
                                                               target='_blank'><span style='padding-left: 10px'>REUSED CTD API Source </span></a>
                                                        @endif
                                                        @if($item->reuse_ctd_fp_spec)
                                                            <a href="{{ url('/public'.$item->reuse_ctd_fp_spec) }}"
                                                               target='_blank'><span style='padding-left: 10px'>REUSED CTD Specification </span></a>
                                                        @endif
                                                        @if($item->reuse_ctd_manufacturer)
                                                            <a href="{{ url('/public'.$item->reuse_ctd_manufacturer) }}"
                                                               target='_blank'><span style='padding-left: 10px'>REUSED CTD Manufacturer </span></a>
                                                        @endif
                                                        @if($item->reuse_ctd_stability)
                                                            <a href="{{ url('/public'.$item->reuse_ctd_stability) }}"
                                                               target='_blank'><span style='padding-left: 10px'>REUSED CTD Stability </span></a>
                                                        @endif
                                                    @endif
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($item->dossier_type == 'CTD')
                                        <div class="row" id="dosType">
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                <div class="panel">
                                                    <span class="label label-default">Dossier Type</span>
                                                    API TYPE : <b><input type="text" value="{{ $item->api_type }}"
                                                                         id="v_api" disabled
                                                                         style="background-color: #FADBD8;"></b>
                                                    PV : <b><input type="text" id="v_pv" value="{{ $item->pv }}"
                                                                   disabled style="background-color: #FADBD8"></b>
                                                    Impurity of FP : <b><input type="text"
                                                                               value="{{ $item->impurity_of_fp }}"
                                                                               id="v_ipf" disabled
                                                                               style="background-color: #FADBD8"></b>
                                                    CDP Match : <b><input type="text" id="v_cdp_match"
                                                                          value="{{ $item->ctdp_match }}" disabled
                                                                          style="background-color: #FADBD8"></b>
                                                    BE Study : <b><input type="text" id="v_be_study"
                                                                         value="{{ $item->ctd_study }}" disabled
                                                                         style="background-color: #FADBD8"></b>
                                                </div>
                                            </div>
                                        </div>
                                    @endif





                                    {{--IM STAGE-1--}}
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">IM STAGE-1</h3>
                                        </div>
                                        <div class="panel-body">

                                            <form id="imstg-1" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="form-group">
                                                                <label for="name_of_comp_agent"
                                                                       class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Name
                                                                    Of the Agent (Company)
                                                                </label>
                                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <input type="text"
                                                                           value="{{ $item->company_agent_name }}"
                                                                           autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           id="name_of_comp_agent"
                                                                           name="name_of_comp_agent">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="form-group">
                                                                <label for="ct_name"
                                                                       class="col-md-5 col-sm-5 control-label ">Agent Person</label>
                                                                <div class="col-md-7 col-sm-7">
                                                                    <input type="text" class="form-control input-sm" autocomplete="off"
                                                                           id="ct_name"
                                                                           value="{{ $item->contact_name }}" name="contact_name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                                            <div class="form-group">

                                                                <div class="col-md-1 col-sm-1">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" autocomplete="off"
                                                                                   id="subtoag">
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <label for="sub_to_agent_date"
                                                                       class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Sub.
                                                                    To Agent</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">


                                                                    @if(!empty($item->submitted_to_agent))
                                                                        <input type="text" autocomplete="off"
                                                                               value="{{ \Carbon\Carbon::parse($item->submitted_to_agent)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               disabled
                                                                               name="sub_to_agent_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="sub_to_agent_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off" value=""
                                                                               class="form-control input-sm" readonly
                                                                               disabled
                                                                               name="sub_to_agent_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="sub_to_agent_date">
                                                                    @endif

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                                            <div class="form-group">

                                                                <div class="col-md-1 col-sm-1">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" autocomplete="off"
                                                                                   id="subtonra">
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <label for="sub_to_regulatory"
                                                                       class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Sub.To
                                                                    NRA</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->submitted_to_regularity))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->submitted_to_regularity)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               disabled
                                                                               name="sub_to_regulatory" autocomplete="off"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="sub_to_regulatory">
                                                                    @else
                                                                        <input type="text" value=""
                                                                               class="form-control input-sm" readonly
                                                                               disabled
                                                                               name="sub_to_regulatory"
                                                                               autocomplete="off"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="sub_to_regulatory">
                                                                    @endif


                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <button class="btn btn-success" id="imStage1_save"
                                                                type="button"><i
                                                                    class="fa fa-save"></i> Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>


                                    {{--IRA STAGE-2--}}
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">IRA STAGE-2</h3>
                                        </div>
                                        <div class="panel-body">

                                            <form id="IRA_stage-2" enctype="multipart/form-data">

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="ipdg"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">
                                                                    Defi. Gen.
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">


                                                                    <select name="ipdg" id="ipdg" autocomplete="off"
                                                                            class="form-control input-sm ipdg"
                                                                            autocomplete="off">
                                                                        @if($item->in_process_def_gen)
                                                                            <option value="{{ $item->in_process_def_gen }}"
                                                                                    selected> {{ $item->in_process_def_gen }} </option>
                                                                            <option value="NO">NO</option>
                                                                        @else
                                                                            <option value="">SELECT ...</option>
                                                                            <option value="YES">YES</option>
                                                                            <option value="NO">NO</option>
                                                                        @endif


                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="ipdgdate"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Defi.
                                                                    Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">


                                                                    @if(!empty($item->in_process_dg_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->in_process_dg_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="ipdgdate"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="ipdgdate">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm" readonly
                                                                               name="ipdgdate"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="ipdgdate">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="dg_comments"
                                                                       class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Comments</label>
                                                                <div class="col-lg-8 col-md-8 col-sm-8">


                                                                    <select name="dg_comments" autocomplete="off"
                                                                            id="dg_comments"
                                                                            class="form-control input-sm dg_comments">

                                                                        @if($item->dg_comments)
                                                                            <option value="{{ $item->dg_comments }}"
                                                                                    selected> {{ $item->dg_comments }} </option>
                                                                            <option value="1st Deficiency">1st
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="2nd Deficiency">2nd
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="3rd Deficiency">3rd
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="4th Deficiency">4th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="5th Deficiency">5th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="6th Deficiency">6th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="7th Deficiency">7th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="8th Deficiency">8th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="9th Deficiency">9th
                                                                                Deficiency
                                                                            </option>
                                                                        @else
                                                                            <option value="">SELECT ...</option>
                                                                            <option value="1st Deficiency">1st
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="2nd Deficiency">2nd
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="3rd Deficiency">3rd
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="4th Deficiency">4th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="5th Deficiency">5th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="6th Deficiency">6th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="7th Deficiency">7th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="8th Deficiency">8th
                                                                                Deficiency
                                                                            </option>
                                                                            <option value="9th Deficiency">9th
                                                                                Deficiency
                                                                            </option>
                                                                        @endif


                                                                    </select>


                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="def_gen_close"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Defi.
                                                                    Close
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    <select name="def_gen_close" id="def_gen_close"
                                                                            class="form-control input-sm def_gen_close"
                                                                            autocomplete="off">
                                                                        @if($item->def_gen_close)
                                                                            <option value="{{ $item->def_gen_close }}"
                                                                                    selected> {{ $item->def_gen_close }} </option>
                                                                            <option value="NO">NO</option>
                                                                        @else
                                                                            <option value="">SELECT ...</option>
                                                                            <option value="YES">YES</option>
                                                                            <option value="NO">NO</option>
                                                                        @endif
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="dgdateclose"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Defi.
                                                                    Close Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    @if(!empty($item->dg_date_close))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->dg_date_close)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="dgdateclose"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="dgdateclose">
                                                                    @else
                                                                        <input type="text" value=""
                                                                               class="form-control input-sm" readonly
                                                                               name="dgdateclose" autocomplete="off"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="dgdateclose">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="def_gen_close"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">In process
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <select name="inprocess" id="inprocess"
                                                                            class="form-control input-sm inprocess"
                                                                            autocomplete="off">
                                                                        @if($item->inprocess)
                                                                            <option value="">SELECT ...</option>
                                                                            @if($item->inprocess == 'NO')
                                                                                <option value="{{ $item->inprocess }}" selected> {{ $item->inprocess }} </option>
                                                                                <option value="YES">YES</option>
                                                                            @elseif($item->inprocess == 'YES')
                                                                                <option value="{{ $item->inprocess }}" selected> {{ $item->inprocess }} </option>
                                                                                <option value="NO">NO</option>
                                                                            @endif


                                                                        @else
                                                                            <option value="">SELECT ...</option>
                                                                            <option value="YES">YES</option>
                                                                            <option value="NO">NO</option>
                                                                        @endif

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <button class="btn btn-success" id="iraStage2_save"
                                                                type="button"><i
                                                                    class="fa fa-save"></i> Save
                                                        </button>

                                                    </div>
                                                </div>
                                                {{--                                        @endif--}}

                                            </form>

                                        </div>
                                    </div>

                                    {{--IM STAGE-2--}}
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">IM STAGE-2</h3>
                                        </div>
                                        <div class="panel-body">

                                            <form enctype="multipart/form-data" id="IM_stage-2">

                                                <div class="row">


                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                        <div class="form-group">
                                                            <label for="curr_status"
                                                                   class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Current
                                                                Status</label>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <select class="form-control input-sm m-bot15"
                                                                        autocomplete="off" name="curr_status"  id="curr_status">
                                                                    <option value="">Select...</option>
                                                                    @if($item->current_status)

                                                                        <option value="{{ $item->current_status }}" selected>
                                                                            {{-- {{ $item->current_status }}  --}}
                                                                            @if($item->current_status == 'REG') Registered @endif
                                                                            @if($item->current_status == 'DBAM') Dropped by Agent/MAH @endif
                                                                            @if($item->current_status == 'WFRD') Withdrawal From RA Date @endif
                                                                            @if($item->current_status == 'PERMITTED') Permitted @endif
                                                                            @if($item->current_status == 'REJ') Rejected @endif


                                                                        </option>
                                                                        <option value="DBAM">Dropped by Agent/MAH
                                                                        </option>
                                                                        <option value="WFRD">Withdrawal From RA Date
                                                                        </option>
                                                                        <option value="REJ">Rejected</option>
                                                                        <option value="REG">Registered</option>
                                                                        <option value="PERMITTED">Permitted</option>
                                                                    @else
                                                                        <option>Select Status</option>
                                                                        <option value="DBAM">Dropped by Agent/MAH
                                                                        </option>
                                                                        <option value="WFRD">Withdrawal From RA Date
                                                                        </option>
                                                                        <option value="REJ">Rejected</option>
                                                                        <option value="REG">Registered</option>
                                                                        <option value="PERMITTED">Permitted</option>
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($item->current_status == 'DBAM')
                                                        <div class="col-md-5 col-sm-5 col-xs-5" id="dbam_field"
                                                             style="">
                                                            <div class="form-group">
                                                                <label for="mah_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Dropped
                                                                    by Agent/MAH Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    @if(!empty($item->dropped_by_agent_mah))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->dropped_by_agent_mah)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="mah_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="mah_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               name="mah_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="mah_date">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-5 col-sm-5 col-xs-5" id="dbam_field"
                                                             style="display: none;">
                                                            <div class="form-group">
                                                                <label for="mah_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Dropped
                                                                    by Agent/MAH Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    @if(!empty($item->dropped_by_agent_mah))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->dropped_by_agent_mah)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="mah_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="mah_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               name="mah_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="mah_date">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($item->current_status == 'WFRD') Withdrawal From RA Date
                                                    <div class="col-md-5 col-sm-5 col-xs-5" id="wfrd_field"
                                                         style="">
                                                        <div class="form-group">
                                                            <label for="wfr_date"
                                                                   class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Withdrawal
                                                                From RA Date
                                                            </label>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">

                                                                @if(!empty($item->withdrawal_form_ra_date))
                                                                    <input type="text"
                                                                           value="{{  \Carbon\Carbon::parse($item->withdrawal_form_ra_date)->format('d-M-Y')}}"
                                                                           class="form-control input-sm" readonly
                                                                           name="wfr_date"
                                                                           style="font-size: small; padding-right: 0px;"
                                                                           id="wfr_date">
                                                                @else
                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           name="wfr_date"
                                                                           id="wfr_date">
                                                                @endif


                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                        <div class="col-md-5 col-sm-5 col-xs-5" id="wfrd_field"
                                                             style="display: none;">
                                                            <div class="form-group">
                                                                <label for="wfr_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Withdrawal
                                                                    From RA Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    @if(!empty($item->withdrawal_form_ra_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->withdrawal_form_ra_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="wfr_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="wfr_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               name="wfr_date"
                                                                               id="wfr_date">
                                                                    @endif


                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif


                                                    @if($item->current_status == 'REJ') Rejected
                                                    <div class="col-md-4 col-sm-4 col-xs-4" id="rej_field"
                                                         style="">
                                                        <div class="form-group">
                                                            <label for="rejection_date"
                                                                   class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Rejected
                                                                Date
                                                            </label>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">

                                                                @if(!empty($item->rejection_date))
                                                                    <input type="text"
                                                                           value="{{  \Carbon\Carbon::parse($item->rejection_date)->format('d-M-Y')}}"
                                                                           class="form-control input-sm"
                                                                           name="rejection_date"
                                                                           style="font-size: small; padding-right: 0px;"
                                                                           id="rejection_date">
                                                                @else
                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           name="rejection_date"
                                                                           id="rejection_date">
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                        <div class="col-md-4 col-sm-4 col-xs-4" id="rej_field"
                                                             style="display: none;">
                                                            <div class="form-group">
                                                                <label for="rejection_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Rejected
                                                                    Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    @if(!empty($item->rejection_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->rejection_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm"
                                                                               name="rejection_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="rejection_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               name="rejection_date"
                                                                               id="rejection_date">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($item->current_status == 'REG')
                                                        <div class="col-md-4 col-sm-4 col-xs-4" id="reg_field" style="">
                                                            <div class="form-group">
                                                                <label for="approval_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Registered
                                                                    Date</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->approval_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->approval_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm"
                                                                               name="approval_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="approval_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               id="approval_date"
                                                                               name="approval_date">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-4 col-sm-4 col-xs-4" id="reg_field"  style="display: none;">
                                                            <div class="form-group">
                                                                <label for="approval_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Registered
                                                                    Date</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->approval_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->approval_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="approval_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="approval_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               id="approval_date" readonly=""
                                                                               name="approval_date">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif


                                                    @if($item->current_status == 'PERMITTED')
                                                        <div class="col-md-4 col-sm-4 col-xs-4" id="per_field" style="">
                                                            <div class="form-group">
                                                                <label for="permitted_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Permitted
                                                                    Date</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->permitted_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->permitted_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm"
                                                                               name="permitted_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="permitted_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               id="permitted_date"
                                                                               name="permitted_date">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-4 col-sm-4 col-xs-4" id="per_field"  style="display: none;">
                                                            <div class="form-group">
                                                                <label for="permitted_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Permitted
                                                                    Date</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->permitted_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->permitted_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="permitted_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="permitted_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               id="permitted_date" readonly=""
                                                                               name="permitted_date">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif







                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="expiry_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Expiry/Renewal
                                                                    Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->expiry_renewal_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->expiry_renewal_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm"
                                                                               name="expiry_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="expiry_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm"
                                                                               name="expiry_date"
                                                                               id="expiry_date">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="reg_number"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Registration
                                                                    Number
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           name="reg_number"
                                                                           value="{{ $item->registration_number }}"
                                                                           id="reg_number">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="reg_shelf_life_product"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Reg.Shelf
                                                                    Life Product</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">


                                                                    <select class="form-control input-sm m-bot15"
                                                                            autocomplete="off"
                                                                            name="reg_shelf_life_product"
                                                                            id="reg_shelf_life_product">
                                                                        @if($item->reg_shelf_life_product)
                                                                            <option value="{{ $item->reg_shelf_life_product }}"
                                                                                    selected> {{ $item->reg_shelf_life_product }} </option>
                                                                            <option value="6 Month">6 Month</option>
                                                                            <option value="12 Month">12 Month</option>
                                                                            <option value="18 Month">18 Month</option>
                                                                            <option value="24 Month">24 Month</option>
                                                                            <option value="36 Month">36 Month</option>
                                                                            <option value="48 Month">48 Month</option>
                                                                            <option value="60 Month">60 Month</option>
                                                                            <option value="other">Other</option>
                                                                        @else
                                                                            <option>Select Status</option>
                                                                            <option value="6 Month">6 Month</option>
                                                                            <option value="12 Month">12 Month</option>
                                                                            <option value="18 Month">18 Month</option>
                                                                            <option value="24 Month">24 Month</option>
                                                                            <option value="36 Month">36 Month</option>
                                                                            <option value="48 Month">48 Month</option>
                                                                            <option value="60 Month">60 Month</option>
                                                                            <option value="other">Other</option>
                                                                        @endif

                                                                    </select>


                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">


                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="launched_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Launched
                                                                    Date (Date of Marketing) </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->launched_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->launched_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="launched_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="launched_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm" readonly=""
                                                                               name="launched_date"
                                                                               id="launched_date">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="variation_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Variation
                                                                    Gen.
                                                                    Date
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->variation_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->variation_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="variation_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="variation_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm" readonly
                                                                               name="variation_date"
                                                                               id="variation_date">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="var_granted_refused"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Variation
                                                                    Granted/Refused</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    <select class="form-control input-sm m-bot15"
                                                                            autocomplete="off"
                                                                            name="var_granted_refused"
                                                                            id="var_granted_refused">
                                                                        @if($item->variation_granted_refused)
                                                                            <option value="{{ $item->variation_granted_refused }}"
                                                                                    selected> {{ $item->variation_granted_refused }} </option>
                                                                            <option value="Yes">Yes</option>
                                                                            <option value="No">No</option>
                                                                        @else
                                                                            <option>Select ...</option>
                                                                            <option value="Yes">Yes</option>
                                                                            <option value="No">No</option>
                                                                        @endif

                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="var_granted_refused_date"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Variation
                                                                    Granted/Refused (Date) </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    @if(!empty($item->variation_granted_refused_date))
                                                                        <input type="text"
                                                                               value="{{  \Carbon\Carbon::parse($item->variation_granted_refused_date)->format('d-M-Y')}}"
                                                                               class="form-control input-sm" readonly
                                                                               name="var_granted_refused_date"
                                                                               style="font-size: small; padding-right: 0px;"
                                                                               id="var_granted_refused_date">
                                                                    @else
                                                                        <input type="text" autocomplete="off"
                                                                               class="form-control input-sm" readonly=""
                                                                               name="var_granted_refused_date"
                                                                               id="var_granted_refused_date">
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="im_2_remarks"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Remarks
                                                                    (If Any)
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           name="im_2_remarks"
                                                                           value="{{ $item->im_2_remarks }}"
                                                                           id="im_2_remarks">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">

                                                                <label for="reg_cert_upload"
                                                                       class="col-lg-8 col-sm-8 col-md-8control-label control-label">Registration
                                                                    Certificate Upload</label>
                                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                                    <input type="file" autocomplete="off"
                                                                           id="reg_cert_upload"
                                                                           name="reg_cert_upload"/>

                                                                    <input type="hidden" name="reg_cert_path"
                                                                           value="{{ $item->reg_cert_path }}"></input>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <button class="btn btn-success" id="imStage2_save"
                                                                type="button"><i
                                                                    class="fa fa-save"></i> Save
                                                        </button>

                                                    </div>
                                                </div>

                                            </form>


                                        </div>
                                    </div>


                                    {{--files Registration Certificate--}}
                                    <div class="row" id="regCertificateLocation">
                                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                            <div class="panel">
                                                <span class="label label-warning">Documents</span>
                                                <span id="pdf_certificate_draw">
                                                    @if($item->reg_cert_path)
                                                        <a href="{{ url('/public'.$item->reg_cert_path) }}"
                                                           target='_blank'><span style='padding-left: 10px'>Registration Certificate </span></a>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>


                                    {{--IRA STAGE-3--}}
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">IRA STAGE-3</h3>
                                        </div>
                                        <div class="panel-body">

                                            <form id="IRA_stage-3" enctype="multipart/form-data">

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="spl_instruction"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Special
                                                                    Instruction</label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">

                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           id="spl_instruction"
                                                                           name="spl_instruction" value="{{ $item->spl_instruction }}">


                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="pmc"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Post
                                                                    marketing commitments
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm" id="pmc"
                                                                           name="pmc" value="{{ $item->post_marketing_commitments }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                                            <div class="form-group">
                                                                <label for="time_req_for_reg"
                                                                       class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Time
                                                                    required for registration
                                                                </label>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           id="time_req_for_reg"
                                                                           name="time_req_for_reg" value="{{ $item->time_req_for_reg }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                                            <div class="form-group">
                                                                <label for="remarks_by_ira"
                                                                       class="col-lg-3 col-sm-3 col-md-3 control-label control-label">Remarks
                                                                    by IRA</label>
                                                                <div class="col-lg-9 col-md-9 col-sm-9">

                                                                    <input type="text" autocomplete="off"
                                                                           class="form-control input-sm"
                                                                           id="remarks_by_ira"
                                                                           name="remarks_by_ira" value={{ $item->remarks_by_ira }}>


                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <button class="btn btn-success" id="iraStage3_save" type="button"><i
                                                                    class="fa fa-save"></i> Save
                                                        </button>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </section>
        </div>
        @endforeach


        @endsection

        @section('footer-content')
        {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{--Date--}}
    {{Html::script('public/site_resource/js/clockpicker/jquery-clockpicker.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}


    <script>
        $('#sub_to_agent_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#sub_to_regulatory').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#ipdgdate').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#dgdateclose').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $(document).on('click', '#subtoag', function () {

            var check = $(this).prop('checked');
            if (check == true) {
                $("#sub_to_agent_date").prop('disabled', false);
            } else {
                $("#sub_to_agent_date").val('');
                $("#sub_to_agent_date").prop('disabled', true);

            }
        });

        $(document).on('click', '#subtonra', function () {

            var check = $(this).prop('checked');
            if (check == true) {
                $("#sub_to_regulatory").prop('disabled', false);
            } else {
                $("#sub_to_regulatory").val('');
                $("#sub_to_regulatory").prop('disabled', true);

            }
        });

        $('#mah_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#wfr_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#approval_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#permitted_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#expiry_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#rejection_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#launched_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#variation_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $('#var_granted_refused_date').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        });

        $(document).on('click', '#imStage1_save', function () {
            var line_id = $('#line_id').val();
            var name_of_comp_agent = $('#name_of_comp_agent').val();
            var ct_name = $('#ct_name').val();
            var sub_to_agent_date = $('#sub_to_agent_date').val();
            var sub_to_regulatory = $('#sub_to_regulatory').val();
            var auth_id = "{{ Auth::user()->user_id }}";


            console.log(ct_name);


            var URL = "{{ url('expo/saveImStage1') }}";
            $.ajax({
                url: URL,
                type: "get", //send it through get method
                data: {
                    line_id: line_id, name_of_comp_agent: name_of_comp_agent,
                    sub_to_agent_date: sub_to_agent_date, sub_to_regulatory: sub_to_regulatory,
                    auth_id: auth_id,contact_name:ct_name
                },
                success: function (data) {
                    //console.log(data);
                    if (data.success) {
                        toastr.success(data.success, '', {timeOut: 2000});
                        setTimeout(function () {
                        }, 2000);
                    } else {
                        toastr.error(data.error, '', {timeOut: 2000});
                    }
                },
                error: function (data) {
                    toastr.error(data, 'Contact Your administrator', {timeOut: 2000});
                }
            });

        });

        $(document).on('click', '#iraStage2_save', function () {

            var line_id = $('#line_id').val();
            var ipdg = $('#ipdg').val();
            var ipdgdate = $('#ipdgdate').val();
            var dg_comments = $('#dg_comments').val();
            var def_gen_close = $('#def_gen_close').val();
            var dgdateclose = $('#dgdateclose').val();
            var inprocess = $('#inprocess').val();
            var auth_id = "{{ Auth::user()->user_id }}";
            var URL = "{{ url('expo/saveIRAStage2') }}";

            $.ajax({
                url: URL,
                type: "get", //send it through get method
                data: {
                    line_id: line_id,
                    in_process_def_gen: ipdg,
                    in_process_dg_date: ipdgdate,
                    dg_comments: dg_comments,
                    def_gen_close: def_gen_close,
                    dg_date_close: dgdateclose,
                    inprocess: inprocess,
                    auth_id: auth_id
                },
                success: function (data) {
                    //console.log(data);
                    if (data.success) {
                        toastr.success(data.success, '', {timeOut: 2000});
                        setTimeout(function () {
                        }, 2000);
                    } else {
                        toastr.error(data.error, '', {timeOut: 2000});
                    }
                },
                error: function (data) {
                    toastr.error(data, 'Contact Your administrator', {timeOut: 2000});
                }
            });

        });

        $(document).on('change', '#curr_status', function () {
            console.log('yes change..');
            var st = $('#curr_status').val();

            console.log(st);

            if (st === 'DBAM') {
                $('#dbam_field').show();
                $('#wfrd_field').hide();
                $('#rej_field').hide();
                $('#reg_field').hide();
                $('#per_field').hide();

                $('#approval_date').val('');
                $('#permitted_date').val('');
                $('#wfr_date').val('');
                $('#rejection_date').val('');


            } else if (st === 'WFRD') {
                $('#wfrd_field').show();
                $('#dbam_field').hide();
                $('#rej_field').hide();
                $('#reg_field').hide();
                $('#per_field').hide();

                $('#mah_date').val('');
                $('#approval_date').val('');
                $('#permitted_date').val('');
                $('#rejection_date').val('');

            } else if (st === 'REJ') {
                $('#rej_field').show();
                $('#dbam_field').hide();
                $('#wfrd_field').hide();
                $('#reg_field').hide();
                $('#per_field').hide();

                $('#mah_date').val('');
                $('#wfr_date').val('');
                $('#approval_date').val('');
                $('#permitted_date').val('');


            } else if (st === 'REG') {
                $('#reg_field').show();
                $('#dbam_field').hide();
                $('#wfrd_field').hide();
                $('#rej_field').hide();
                $('#per_field').hide();

                $('#mah_date').val('');
                $('#wfr_date').val('');
                $('#rejection_date').val('');
                $('#permitted_date').val('');
            } else if (st === 'PERMITTED') {

                console.log(" In permitted");
                $('#per_field').show();
                $('#reg_field').hide();
                $('#dbam_field').hide();
                $('#wfrd_field').hide();
                $('#rej_field').hide();



                $('#mah_date').val('');
                $('#wfr_date').val('');
                $('#approval_date').val('');
                $('#rejection_date').val('');



            } else {
                $('#reg_field').hide();
                $('#dbam_field').hide();
                $('#wfrd_field').hide();
                $('#rej_field').hide();
                $('#per_field').hide();

                $('#mah_date').val('');
                $('#wfr_date').val('');
                $('#approval_date').val('');
                $('#permitted_date').val('');
                $('#rejection_date').val('');
            }

        });

        $(document).on('click', '#imStage2_save', function () {
            var inprocess = $('#inprocess').val();
            if(inprocess == 'YES'){
                toastr.error('To proceed, select "NO" in the "In process" field.', 'Error', {timeOut: 2000});
            }else{

                var fileArray = new Array();
                var data = $("#IM_stage-2").serialize(); // it will serialize the form data
                var form_data = new FormData();
                var line_id = $('#line_id').val();


                if ($('#reg_cert_upload').get(0).files.length !== 0) {
                    fileArray = [];
                    fileArray.push($('#reg_cert_upload').prop('files')[0]);
                }

                if (fileArray.length !== 0) {
                    var x;
                    for (x = 0; x < fileArray.length; x++) {
                        form_data.append('files', fileArray[x]);
                    }
                }

                var auth_id = "{{ Auth::user()->user_id }}";
                var URL = "{{ url('expo/saveIMStage2') }}";

                form_data.append('_token', $("meta[name='csrf_token']").attr("content"));
                form_data.append('data', data);
                form_data.append('line_id', line_id);
                form_data.append('auth_id', auth_id);

                $.ajax({
                    url: URL,
                    method: 'POST',
                    data: form_data, // added the { } to protect the data
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) { // here we use the success event

                        // console.log(data);

                        if (data.success) {
                            toastr.success(data.success, '', {timeOut: 2000});

                            setTimeout(function () {// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1000);

                        } else {
                            toastr.error(data.error, '', {timeOut: 2000});
                        }

                    },
                    error: function (request, status, error) {
                        console.log(JSON.stringify(request));
                        console.log("AJAX error: " + status + ' : ' + error);
                        alert(error);
                    }
                });
            }

        });

        $(document).on('click', '#iraStage3_save', function () {

            var line_id = $('#line_id').val();
            var auth_id = "{{ Auth::user()->user_id }}";
            var URL = "{{ url('expo/saveIRAStage3') }}";

            var spl_instruction = $('#spl_instruction').val();
            var pmc = $('#pmc').val();
            var time_req_for_reg = $('#time_req_for_reg').val();
            var remarks_by_ira = $('#remarks_by_ira').val();

            $.ajax({
                url: URL,
                type: "get", //send it through get method
                data: {
                    line_id: line_id,
                    spl_instruction: spl_instruction,
                    pmc: pmc,
                    time_req_for_reg: time_req_for_reg,
                    remarks_by_ira: remarks_by_ira,
                    auth_id: auth_id
                },
                success: function (data) {
                    //console.log(data);
                    if (data.success) {
                        toastr.success(data.success, '', {timeOut: 2000});
                    } else {
                        toastr.error(data.error, '', {timeOut: 2000});
                    }
                },
                error: function (data) {
                    toastr.error(data, 'Contact Your administrator', {timeOut: 2000});
                }
            });

        });
    </script>
@endsection