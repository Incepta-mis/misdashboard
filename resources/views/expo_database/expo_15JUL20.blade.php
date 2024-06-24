<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/13/2019
 * Time: 11:36 AM
 */
?>

@extends('_layout_shared._master')
@section('title','Export Database')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <!--pickers css-->
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/clockpicker/jquery-clockpicker.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <!--file upload-->
    {{--    <link href="{{ url('public/site_resource/css/bootstrap-fileupload.min.css')}}" rel="stylesheet" type="text/css"/>--}}

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .tx_font {
            font-size: 11px;
        }

        body {
            color: black;
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


    </style>
@endsection


@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Export Database
                    </label>
                </div>

                <div class="panel-body" style="padding-top: 2%">

                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">

                                <div class='col-sm-10 col-md-10'>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12">
                                            <select name="fip" id="fip"
                                                    class="form-control  input-sm fip" autocomplete="off">
                                                <option value="">Select Finish Product</option>
                                                @foreach($expo_data as $l)
                                                    <option value="{{$l->plant_id}},{{ $l->product_code }} ,{{ $l->product_name }} ,{{ $l->export_country }}">{{$l->details}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-2 col-sm-2">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                        <button type="button" id="btn-save" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> <b>Save</b></button>
                                    </div>
                                    <div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 col-xs-4">
                                        <div id="new_export_buttons">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>

            </section>
        </div>

        <div class="col-md-12 col-sm-12" style="padding-top: 1%" id="maintop">
            <section class="panel panel-info">

                <div class="panel-body" style="padding-top: 2%; background-color: #E5E7E9">

                    <form method="post" action="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12 col-sm-12">

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label for="fi_prod"
                                               class="col-md-5 col-sm-5 control-label"><b>Finish Product</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <input type="hidden" id="plant_id" name="plant_id">
                                            <input type="text" autocomplete="off" class="form-control input-sm" autocomplete="off" id="fi_prod"
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
                                                   name="local_pcode">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    {{--<label>Finish Product</label>--}}
                                    <div class="form-group">
                                        <label for="brand_name"
                                               class="col-md-5 col-sm-5 control-label "><b>Brand Name</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="brand_name"
                                                   name="brand_name">
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
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="exp_country"
                                                   name="exp_country">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label for="expo_product_name"
                                               class="col-md-5 col-sm-5 control-label "><b>Product Name</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="expo_product_name"
                                                   name="expo_product_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label for="gen_name"
                                               class="col-md-5 col-sm-5 control-label "><b>Generic Name</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="gen_name"
                                                   name="gen_name">
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
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="pack_size"
                                                   name="pack_size">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">

                                    <div class="form-group">
                                        <label for="com_agent"
                                               class="col-md-5 col-sm-5 control-label "><b>Agent(Company)</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="com_agent"
                                                   name="com_agent">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label for="contact_name"
                                               class="col-md-5 col-sm-5 control-label "><b>Agent Person</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="contact_name"
                                                   name="contact_name">
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-md-12 col-sm-12">

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="address"
                                               class="col-md-1  col-sm-1 control-label "><b>Address</b></label>
                                        <div class="col-md-6 col-sm-6" style="padding-left: 6.2%">
                                            <input type="text" class="form-control input-sm" autocomplete="off" id="address"
                                                   name="address">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>

            </section>
        </div>

        <div id="actionBtn" class="col-md-12 col-sm-12" style="padding-top: 1%">

            <div class="text-center">
                <button class="btn btn-primary btn-sm refreshBtn" type="button"><i class="fa fa-refresh"></i> Refresh
                </button>

                <button class="btn btn-success btn-sm viewBtn " type="button" id="viewEntry" value="Edit"><i
                            class="fa fa-dashboard"></i> View
                </button>
                <button class="btn btn-warning btn-sm newBtn " id="newEntry" value="New Entry" type="button"><i
                            class="fa fa-plus-circle"></i> New
                </button>
                <button class="btn btn-info btn-sm renewBtn" type="button" id="ReNewEntry" value="Renew"><i
                            class="fa fa-pencil-square"></i> Re-New
                </button>

            </div>

        </div>


        <div id="entry_body" class="col-md-12 col-sm-12" style="padding-top: 1%;">
            <section class="panel panel-info">

                <div class="panel-body" style="padding-top: 2%;background-color: #E5E7E9">

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
                                                                    class="form-control input-sm im_team" autocomplete="off">
                                                                <option value="">SELECT TEAM</option>
                                                                <option value="IM-1">IM-1</option>
                                                                <option value="IM-2">IM-2</option>
                                                                <option value="Tender">Tender</option>
                                                                <option value="B2B">B2B</option>
                                                                <option value="B2B">MAH/Other</option>

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


                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly placeholder="Date"
                                                                   name="sub_to_im_date"
                                                                   style="font-size: small; padding-right: 0px;"
                                                                   id="sub_to_im_date">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="sub_name"
                                                               class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Sub. To
                                                            Name</label>
                                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                                            <input type="text" autocomplete="off" class="form-control input-sm" placeholder="Full Name"
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
                                                            <input type="text" autocomplete="off" class="form-control input-sm" placeholder="Full Name"
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

                                                            <select name="type_of_dossier" id="type_of_dossier" autocomplete="off"
                                                                    class="form-control input-sm type_of_dossier">
                                                                <option value="">SELECT DOSSIER</option>
                                                                <option value="CTD">CTD</option>
                                                                <option value="NON_CTD">NON CTD</option>
                                                            </select>


                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        {{--                                        @if($uid == '1010112')--}}

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-success" id="stg1_save" type="button"><i
                                                            class="fa fa-save"></i> Save
                                                </button>
                                                <button class="btn btn-info" id="stg1_refresh" type="button"><i
                                                            class="fa fa-refresh"></i> Refresh
                                                </button>
                                            </div>
                                        </div>

                                        {{--                                        @endif--}}
                                    </form>

                                </div>
                            </div>




                            {{--files--}}
                            <div class="row" id="filesLocation" style="display: none" ;>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <div class="panel">
                                        <span class="label label-warning">Documents</span>
                                        <span id="pdf_draw"></span>
                                    </div>
                                </div>
                            </div>




                            {{--IM STAGE-1--}}
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title">IM STAGE-1</h3>
                                </div>
                                <div class="panel-body">

                                    <form id="imstg-1" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="col-md-10 col-sm-10 col-xs-10">
                                                    <div class="form-group">
                                                        <label for="name_of_comp_agent"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Name
                                                            Of the Agent (Company)
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input type="text" autocomplete="off" class="form-control input-sm"
                                                                   id="name_of_comp_agent"
                                                                   name="name_of_comp_agent">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                    <div class="form-group">

                                                        <div class="col-md-1 col-sm-1">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox"  autocomplete="off" id="subtoag">
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <label for="sub_to_agent_date"
                                                               class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Sub.
                                                            To Agent</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly disabled
                                                                   name="sub_to_agent_date"
                                                                   style="font-size: small; padding-right: 0px;"
                                                                   id="sub_to_agent_date">


                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                    <div class="form-group">

                                                        <div class="col-md-1 col-sm-1">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" autocomplete="off" id="subtonra">
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <label for="sub_to_regulatory"
                                                               class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Sub.To
                                                            NRA</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                                            <input type="text" class="form-control input-sm" readonly disabled
                                                                   name="sub_to_regulatory" autocomplete="off"
                                                                   style="font-size: small; padding-right: 0px;"
                                                                   id="sub_to_regulatory">


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-success" id="stg2_save" type="button"><i
                                                            class="fa fa-save"></i> Save
                                                </button>
                                                <button class="btn btn-info" id="stg2_refresh" type="button"><i
                                                            class="fa fa-refresh"></i> Refresh
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
                                                            {{--                                                            <input type="text" class="form-control input-sm" id="ipdg"--}}
                                                            {{--                                                                   name="ipdg">--}}

                                                            <select name="ipdg" id="ipdg" autocomplete="off"
                                                                    class="form-control input-sm ipdg" autocomplete="off">
                                                                <option value="">SELECT ...</option>
                                                                <option value="YES">YES</option>
                                                                <option value="NO">NO</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="ipdgdate"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Defi. Date
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly=""
                                                                   name="ipdgdate"
                                                                   style="font-size: small; padding-right: 0px;"
                                                                   id="ipdgdate">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="type_of_dossier"
                                                               class="col-lg-4 col-sm-4 col-md-4 control-label control-label">Comments</label>
                                                        <div class="col-lg-8 col-md-8 col-sm-8">


                                                            <select name="dg_comments" autocomplete="off" id="dg_comments"
                                                                    class="form-control input-sm dg_comments">
                                                                <option value="">SELECT ...</option>
                                                                <option value="1st Deficiency">1st Deficiency</option>
                                                                <option value="2nd Deficiency">2nd Deficiency</option>
                                                                <option value="3rd Deficiency">3rd Deficiency</option>
                                                                <option value="4th Deficiency">4th Deficiency</option>
                                                                <option value="5th Deficiency">5th Deficiency</option>
                                                                <option value="6th Deficiency">6th Deficiency</option>
                                                                <option value="7th Deficiency">7th Deficiency</option>
                                                                <option value="8th Deficiency">8th Deficiency</option>
                                                                <option value="9th Deficiency">9th Deficiency</option>
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
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Defi. Close
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            {{--                                                            <input type="text" class="form-control input-sm"--}}
                                                            {{--                                                                   id="def_gen_close"--}}
                                                            {{--                                                                   name="def_gen_close">--}}

                                                            <select name="def_gen_close" id="def_gen_close"
                                                                    class="form-control input-sm def_gen_close" autocomplete="off">
                                                                <option value="">SELECT ...</option>
                                                                <option value="YES">YES</option>
                                                                <option value="NO">NO</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="dgdateclose"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Defi. Close Date
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly=""
                                                                   name="dgdateclose"
                                                                   style="font-size: small; padding-right: 0px;"
                                                                   id="dgdateclose">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="def_gen_close"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Inprocess
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <select name="inprocess" id="inprocess"
                                                                    class="form-control input-sm inprocess" autocomplete="off">
                                                                <option value="">SELECT ...</option>
                                                                <option value="YES">YES</option>
                                                                <option value="NO">NO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        {{--

                                        {{--                                        @if($uid == '1010112')--}}

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-success" id="stg3_save" type="button"><i
                                                            class="fa fa-save"></i> Save
                                                </button>
                                                <button class="btn btn-info" id="stg3_refresh" type="button"><i
                                                            class="fa fa-refresh"></i> Refresh
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



                                            <div class="col-md-12 col-sm-12 col-xs-12">

                                                {{--                                                <div class="col-md-4 col-sm-4 col-xs-4">--}}
                                                {{--                                                    <div class="form-group">--}}
                                                {{--                                                        <label for="curr_status"--}}
                                                {{--                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Current Status</label>--}}
                                                {{--                                                        <div class="col-lg-6 col-md-6 col-sm-6">--}}
                                                {{--                                                            <select class="form-control input-sm m-bot15" name="curr_status" id="curr_status">--}}
                                                {{--                                                                <option>Select Status</option>--}}
                                                {{--                                                                <option value="Approved">Approved</option>--}}
                                                {{--                                                                <option value="Rejected">Rejected</option>--}}
                                                {{--                                                                <option value="Pending">Pending</option>--}}
                                                {{--                                                            </select>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}


                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="curr_status"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Current Status</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <select class="form-control input-sm m-bot15" autocomplete="off" name="curr_status" id="curr_status">
                                                                <option>Select Status</option>
                                                                <option value="DBAM">Dropped by Agent/MAH</option>
                                                                <option value="WFRD">Withdrawal From RA Date</option>
                                                                <option value="REJ">Rejected</option>
                                                                <option value="REG">Registered</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-5 col-sm-5 col-xs-5" id="dbam_field" style="display: none;">
                                                    <div class="form-group">
                                                        <label for="mah_date"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Dropped
                                                            by Agent/MAH Date
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly=""
                                                                   name="mah_date"
                                                                   style="font-size: small; padding-right: 0px;"
                                                                   id="mah_date">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-5 col-sm-5 col-xs-5" id="wfrd_field" style="display: none;">
                                                    <div class="form-group">
                                                        <label for="wfr_date"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Withdrawal
                                                            From RA Date
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly=""
                                                                   name="wfr_date"
                                                                   id="wfr_date">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4 col-xs-4" id="rej_field" style="display: none;">
                                                    <div class="form-group">
                                                        <label for="rejection_date"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Rejected
                                                            Date
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly
                                                                   name="rejection_date"
                                                                   id="rejection_date">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4 col-xs-4" id="reg_field" style="display: none;">
                                                    <div class="form-group">
                                                        <label for="approval_date"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Registered
                                                            Date</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                                            <input type="text" autocomplete="off" class="form-control input-sm"
                                                                   id="approval_date" readonly=""
                                                                   name="approval_date">


                                                        </div>
                                                    </div>
                                                </div>

                                            </div>



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
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly=""
                                                                   name="expiry_date"
                                                                   id="expiry_date">
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
                                                            <input type="text" autocomplete="off" class="form-control input-sm"
                                                                   name="reg_number"
                                                                   id="reg_number">
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--                                                <div class="col-md-4 col-sm-4 col-xs-4">--}}
                                                {{--                                                    <div class="form-group">--}}
                                                {{--                                                        <label for="reg_certificate"--}}
                                                {{--                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Register--}}
                                                {{--                                                            Certificate No</label>--}}
                                                {{--                                                        <div class="col-lg-6 col-md-6 col-sm-6">--}}

                                                {{--                                                            <input type="text" class="form-control input-sm"--}}
                                                {{--                                                                   id="reg_certificate"--}}
                                                {{--                                                                   name="reg_certificate">--}}


                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}

                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="reg_shelf_life_product"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Reg.Shelf
                                                            Life Product</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">


                                                            <select class="form-control input-sm m-bot15" autocomplete="off" name="reg_shelf_life_product" id="reg_shelf_life_product">
                                                                <option>Select Status</option>
                                                                <option value="6 Month">6 Month</option>
                                                                <option value="12 Month">12 Month</option>
                                                                <option value="18 Month">18 Month</option>
                                                                <option value="24 Month">24 Month</option>
                                                                <option value="36 Month">36 Month</option>
                                                                <option value="48 Month">48 Month</option>
                                                                <option value="60 Month">60 Month</option>
                                                                <option value="other">Other</option>
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
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly=""
                                                                   name="launched_date"
                                                                   id="launched_date">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="variation_date"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Variation Gen.
                                                            Date
                                                        </label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly
                                                                   name="variation_date"
                                                                   id="variation_date">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="var_granted_refused"
                                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Variation
                                                            Granted/Refused</label>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                                            <select class="form-control input-sm m-bot15" autocomplete="off" name="var_granted_refused" id="var_granted_refused">
                                                                <option>Select ...</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
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
                                                            <input type="text" autocomplete="off" class="form-control input-sm" readonly=""
                                                                   name="var_granted_refused_date"
                                                                   id="var_granted_refused_date">
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
                                                            <input type="text" autocomplete="off" class="form-control input-sm"
                                                                   name="im_2_remarks"
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
                                                               class="col-lg-8 col-sm-8 col-md-8control-label control-label">Registration Certificate Upload</label>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <input type="file" autocomplete="off" id="reg_cert_upload" name="reg_cert_upload" />
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        {{--                                        @if($uid == '1010112')--}}

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-success" id="stg4_save" type="button"><i
                                                            class="fa fa-save"></i> Save
                                                </button>
                                                <button class="btn btn-info" id="stg4_refresh" type="button"><i
                                                            class="fa fa-refresh"></i> Refresh
                                                </button>
                                            </div>
                                        </div>
                                        {{--                                        @endif--}}

                                    </form>


                                </div>
                            </div>


                            {{--files Registration Certificate--}}
                            <div class="row" id="regCertificateLocation" style="display: none">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <div class="panel">
                                        <span class="label label-warning">Documents</span>
                                        <span id="pdf_certificate_draw"></span>
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

                                                            <input type="text" autocomplete="off" class="form-control input-sm"
                                                                   id="spl_instruction"
                                                                   name="spl_instruction">


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
                                                            <input type="text" autocomplete="off" class="form-control input-sm" id="pmc"
                                                                   name="pmc">
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
                                                            <input type="text" autocomplete="off" class="form-control input-sm"
                                                                   id="time_req_for_reg"
                                                                   name="time_req_for_reg">
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

                                                            <input type="text" autocomplete="off" class="form-control input-sm"
                                                                   id="remarks_by_ira"
                                                                   name="remarks_by_ira">


                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>

                                        {{--                                        @if($uid == '1010112')--}}

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-success" id="stg5_save" type="button"><i
                                                            class="fa fa-save"></i> Save
                                                </button>
                                                <button class="btn btn-info" id="stg5_save" type="button"><i
                                                            class="fa fa-refresh"></i> Refresh
                                                </button>
                                            </div>
                                        </div>
                                        {{--                                        @endif--}}

                                    </form>

                                </div>
                            </div>



                        </div>


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













    {{--<!--CTD Modal -->--}}
    <div id="ctdModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">CTD</h4>
                </div>
                <div class="modal-body">

                    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="api_type" class="col-lg-2 col-sm-2 control-label">API TYPE</label>
                            <div class="col-lg-10">
                                <select name="api_type" id="api_type"
                                        class="form-control input-sm" style="background: antiquewhite;">
                                    <option value="">SELECT API</option>
                                    <option value="API DMF">API DMF</option>
                                    <option value="API CTD">API CTD</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_source" class="col-lg-2 col-sm-2 control-label">API Source</label>
                            <div class="col-lg-10">
                                <input id="api_source" name="api_source" multiple="" type="file"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fp_spec" class="col-lg-2 col-sm-2 control-label">FP Spec</label>
                            <div class="col-lg-10">
                                <input id="fp_spec" name="fp_spec" multiple="" type="file"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer" class="col-lg-2 col-sm-2 control-label">Manufacturer</label>
                            <div class="col-lg-10">
                                <input id="manufacturer" name="manufacturer" multiple="" type="file"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_source" class="col-lg-2 col-sm-2 control-label">Stability</label>
                            <div class="col-lg-10">
                                <input id="stability" name="stability" multiple="" type="file"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">PV</label>
                            <div class="col-lg-10">
                                <select name="type_pv" id="type_pv"
                                        class="form-control input-sm" style="background: antiquewhite;">
                                    <option value="">SELECT PV</option>
                                    <option value="C">C</option>
                                    <option value="R">R</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Impurity of FP</label>
                            <div class="col-lg-10">
                                <select name="impurity" id="impurity"
                                        class="form-control input-sm" style="background: antiquewhite;">
                                    <option value="">SELECT Impurity</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">CDP Match</label>
                            <div class="col-lg-10">
                                <select name="type_cdp" id="type_cdp"
                                        class="form-control input-sm" style="background: antiquewhite;">
                                    <option value="">SELECT CDP Match</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">BE Study</label>
                            <div class="col-lg-10">
                                <select name="beStudy" id="beStudy"
                                        class="form-control input-sm" style="background: antiquewhite;">
                                    <option value="">SELECT BE Study</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>


                        {{--<div class="form-group">--}}
                        {{--<div class="col-lg-offset-2 col-lg-10">--}}
                        {{--<button type="submit" class="btn btn-primary save_Ctd" value="CTDBtn">Save</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!--NON CTD Modal -->
    <div id="nonCTDModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">NON CTD</h4>
                </div>
                <div class="modal-body">

                    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">


                        <div class="form-group">
                            <label for="non_api_source" class="col-lg-2 col-sm-2 control-label">API Source</label>
                            <div class="col-lg-10">
                                <input id="non_api_source" name="non_api_source" multiple="" type="file"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="non_fp_spec" class="col-lg-2 col-sm-2 control-label">FP Spec</label>
                            <div class="col-lg-10">
                                <input id="non_fp_spec" name="non_fp_spec" multiple="" type="file"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="non_manufacturer" class="col-lg-2 col-sm-2 control-label">Manufacturer</label>
                            <div class="col-lg-10">
                                <input id="non_manufacturer" name="non_manufacturer" multiple="" type="file"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="non_stability" class="col-lg-2 col-sm-2 control-label">Stability</label>
                            <div class="col-lg-10">
                                <input id="non_stability" name="non_stability" multiple="" type="file"/>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                        {{--<div class="col-lg-offset-2 col-lg-10">--}}
                        {{--<button type="button" class="btn btn-primary save_nonCtd" value="NonCTDBtn">Save</button>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!--RGS Life Modal -->
    <div id="rgslpModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Reg. Product Shelf Life</h4>
                </div>
                <div class="modal-body">

                    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="non_api_source" class="col-lg-2 col-sm-2 control-label">Others</label>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                                <input type="text" autocomplete="off" name="regShelfLifeProductOthers" id="regShelfLifeProductOthers"/>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>




















    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{--    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}--}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Date--}}
    {{Html::script('public/site_resource/js/clockpicker/jquery-clockpicker.min.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/exportDatabaseJS/entryPage.js')}}




    <script type="text/javascript">
        url = "{{ url('expo/getExpoEntryData') }}";
        stage1_url = "{{ url('expo/getIRAStage1Data') }}";
        nonCtdUrl = "{{ url('expo/nonCtdUpload') }}";
        ctdUrl = "{{ url('expo/ctdUpload') }}";
        _token = "{{csrf_token()}}";
        APP_URL = "{{ url('') }}";
        GET_EXPO = "{{ url('expo/getExpoEntryInfo') }}";
        UPDATE_STAGE1_IRA = "{{ url('expo/updateStage1IM') }}";
        GET_EXPO_STAGE1 = "{{ url('expo/getStage1IM') }}";
        UPDATE_STAGE2_IRA = "{{ url('expo/updateStage2IRA') }}";
        UPDATE_STAGE2_IM = "{{ url('expo/UPDATE_STAGE2_IM') }}";
        UPDATE_STAGE3_IRA = "{{ url('expo/UPDATE_STAGE3_IRA') }}";
    </script>

@endsection

