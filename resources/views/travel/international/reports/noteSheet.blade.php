<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 30/09/2020
 * Time: 12:31 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','Note Sheet Reports')
@section('styles')

    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

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

        input {
            color: black;
            font-size: x-small;
        }

        #myTable > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }

        .cnt {
            text-align: center;
        }


        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }

    </style>
@endsection
@section('right-content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close"
                                                                                         data-dismiss="alert"
                                                                                         aria-label="close">&times;</a>
                </p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->


    <form id="noteSheetEditForm" method="post" action="{{ route('international.noteSheetPreview') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel panel-primary">
                    <div class="panel-heading">
                        <label class="text-default">
                            NOTE SHEET EDIT
                        </label>
                    </div>
                    <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="document_no" class="col-md-6 col-sm-6 control-label"><b>Document
                                                Number: </b></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" class="form-control input-sm" id="document_no"
                                                   name="document_no">

                                        </div>
                                    </div>
                                </div>

                                 <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                            <button type="submit" id="btn_display_group" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Document</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                </section>
            </div>
        </div>
    </form>

    <form id="noteSheetFormReports" method="post" action="{{ route('international.noteSheetExportPDF') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel panel-info">
                    <div class="panel-heading">
                        <label class="text-default">
                            NOTE SHEET REPORTS
                        </label>
                    </div>
                    <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="document_no" class="col-md-6 col-sm-6 control-label"><b>Document
                                                Number: </b></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" class="form-control input-sm" id="document_no"
                                                   name="document_no">

                                        </div>
                                    </div>
                                </div>

                                 <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                            <button type="submit" id="btn_displayNP_group" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Document</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                </section>
            </div>
        </div>
    </form>

    <form id="noteSheetDetailsReports" method="post" action="{{ route('international.nsDetailsView') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel panel-warning">
                    <div class="panel-heading">
                        <label class="text-default">
                            NOTE SHEET DETAILS REPORT
                        </label>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="document_no" class="col-md-6 col-sm-6 control-label"><b>Document
                                            Number: </b></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control input-sm" id="id"
                                               name="id">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="submit" id="btn_display_noteSheetDetails" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Document</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </form>

    <form id="noteSheetForm" method="post" action="{{ route('international.noteSheetGroupExportPDF') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel panel-primary">
                    <div class="panel-heading">
                        <label class="text-default">
                            NOTE SHEET REPORTS GROUP Wise
                        </label>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="document_no" class="col-md-6 col-sm-6 control-label"><b>Group Number: </b></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control input-sm" id="group_no"
                                               name="group_no">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="submit" id="btn_display" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Document</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </form>

    <form id="delNoteSheetReports" method="post" action="{{ route('international.noteSheetDelete') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel panel-danger">
                    <div class="panel-heading">
                        <label class="text-default">
                            DELETE NOTE SHEET
                        </label>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="document_no" class="col-md-6 col-sm-6 control-label"><b>Document
                                            Number: </b></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control input-sm" id="document_no"
                                               name="document_no">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="submit" id="btn_display_noteSheetDetails" class="btn btn-danger btn-sm">
                                            <i class="fa fa-check"></i> <b>Delete Document</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </form>

    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script type="text/javascript">

        $('#btn_display').attr('formtarget', '_blank');
        $('#btn_display_group').attr('formtarget', '_blank');
        $('#btn_display_noteSheetDetails').attr('formtarget', '_blank');
        $('#btn_displayNP_group').attr('formtarget', '_blank');

                @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif

    </script>

@endsection