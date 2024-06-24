<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 8/09/2020
 * Time: 09:25 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Travel Approved')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
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

        .table > thead > tr > th {
            padding: 2px;
            font-size: 11px;
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

        .emp_info > thead > tr > th {
            text-align: center;
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

        .modal-dialog {
            width: 98%;
            height: 92%;
            padding: 0;
        }

        .modal-content {
            height: 99%;
        }

        .btn.disabled {
            pointer-events: none;
        }

        /* Hiding the checkbox, but allowing it to be focused */
        .badgebox
        {
            opacity: 0;
        }

        .badgebox + .badge
        {
            /* Move the check mark away when unchecked */
            text-indent: -999999px;
            /* Makes the badge's width stay the same checked and unchecked */
            width: 27px;
        }

        .badgebox:focus + .badge
        {
            /* Set something to make the badge looks focused */
            /* This really depends on the application, in my case it was: */

            /* Adding a light border */
            box-shadow: inset 0px 0px 5px;
            /* Taking the difference out of the padding */
        }

        .badgebox:checked + .badge
        {
            /* Move the check mark back when checked */
            text-indent: 0;
        }

    </style>

@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        International Travel History
                    </label>
                </header>

                <div class="panel-body">

                    @if(empty($history[0]->plant_id))
                        No record Found                                        
                    @elseif($history[0]->plant_id == '1000' || $history[0]->plant_id == '5000') 
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL#</th>
                                    <th>Document No</th>
                                    <th>Department</th>                                
                                    <th>Req. Appr. Chairman</th>
                                    <th>HR</th>
                                    <th>Finance</th>
                                    <th>Note Sheet Appr. Chairman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $data)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->document_no}}</td>
                                    <td>{{$data->dept_accept}}</td>
                                    <td>{{$data->chairman_accept}}</td>
                                    <td>{{$data->hr_accept}}</td>
                                    <td>{{$data->finance_accept}}</td>
                                    <td>{{$data->nchairman_accept}}</td>
                                </tr>
                                @endforeach            
                            
                            </tbody>                        
                        </table>
                    @elseif($history[0]->plant_id == '1100' || $history[0]->plant_id == '2100') 
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL#</th>
                                    <th>Document No</th>
                                    <th>Department</th>                                
                                    <th>Plant</th>                                
                                    <th>Req. Appr. Chairman</th>
                                    <th>HR</th>
                                    <th>Finance</th>
                                    <th>Note Sheet Appr. Chairman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $data)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->document_no}}</td>
                                    <td>{{$data->dept_accept}}</td>
                                    <td>{{$data->plant_head_accept}}</td>
                                    <td>{{$data->chairman_accept}}</td>
                                    <td>{{$data->hr_accept}}</td>
                                    <td>{{$data->finance_accept}}</td>
                                    <td>{{$data->nchairman_accept}}</td>
                                </tr>
                                @endforeach            
                            
                            </tbody>                        
                        </table>
                    @elseif(
                        $history[0]->plant_id == '1300' || $history[0]->plant_id == '1400' ||
                        $history[0]->plant_id == '2200' || $history[0]->plant_id == '4100' ||
                        $history[0]->plant_id == '5100'
                    )
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL#</th>
                                    <th>Document No</th>
                                    <th>Department</th>                                
                                    <th>Dhamrai Plant</th>                                
                                    <th>Plant Head</th>                                
                                    <th>Req. Appr. Chairman</th>
                                    <th>HR</th>
                                    <th>Finance</th>
                                    <th>Note Sheet Appr. Chairman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $data)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->document_no}}</td>
                                    <td>{{$data->dept_accept}}</td>
                                    <td>{{$data->site_head_accept}}</td>
                                    <td>{{$data->plant_head_accept}}</td>
                                    <td>{{$data->chairman_accept}}</td>
                                    <td>{{$data->hr_accept}}</td>
                                    <td>{{$data->finance_accept}}</td>
                                    <td>{{$data->nchairman_accept}}</td>
                                </tr>
                                @endforeach            
                            
                            </tbody>                        
                        </table>
                      

                    @endif

                </div>
            </section>
        </div>
    </div>
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
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
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "columnDefs": [ {
                "targets": 0,
                "orderable": false
                } ]
            });  
        } );
    </script>
@endsection    