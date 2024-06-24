<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 17/01/2021
 * Time: 11:36 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Finish Product Entry')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

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
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Finish Product Entry
                    </label>
                </header>


                <div class="panel-body">
                    <form id="fp_entry_frm" class="form-horizontal" role="form" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="form-group">
                            <label for="brand_name" class="col-lg-2 col-sm-2 control-label">Brand Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="brand_name" name="brand_name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dosage_form" class="col-lg-2 col-sm-2 control-label">Dosage Form</label>
                            <div class="col-md-6">
                                <select name="dosage_form" id="dosage_form"
                                        class="form-control input-sm m-bot15 dosage_form">
                                    <option >Select Dosage</option>
                                    @foreach ($fp as  $p)
                                        <option value="{{ $p->dosage_form }}">{{ $p->dosage_form }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="button" id="btn_display" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>
        </div>
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


    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}


    <script>
        $('.dosage_form').select2();
        $("#btn_display").click(function () {

            $("#loader").show();

            $.ajax({
                type: 'POST',
                url: "{{ url('scm_portal/storeFinishProduct') }}",
                data: $('#fp_entry_frm').serialize(),
                success: function (resp) {
                    $("#loader").hide();

                    if (resp.success) {
                        toastr.success(resp.success, '', {timeOut: 2000});
                        window.location.reload();
                    }else{
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function (err) {
                    console.log(err)
                    $("#loader").hide();
                }
            });


        });
    </script>
@endsection