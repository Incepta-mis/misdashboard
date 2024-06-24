<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 24/02/2019
 * Time: 9:37 AM
 */
?>
@extends('_layout_shared._master')
@section('title','ELM ERROR')
@section('styles')


    <style>
        /*.panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }*/

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
    </style>
@endsection
@section('right-content')

    <div class="row" style="background-color:#65CEA7">
        <div class="col-md-12 col-sm-12">

            <section class="error-wrapper text-center">
                <h1><img alt="" width="600px" height="300px" src="{{ url('public/site_resource/images/warning-stamp-2.png') }}"></h1>
                <!-- <h2>page not found</h2> -->
                <h3>Sorry, you are not authorized to apply leave application</h3>
                <h4>Please contact HR department</h4>
                <a class="back-btn" href="{{url('home')}}"> Back To Home</a>
            </section>

        </div>
    </div>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
    @endsection



    @section('scripts')


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection