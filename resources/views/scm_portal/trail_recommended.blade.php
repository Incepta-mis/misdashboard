<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/27/2018
 * Time: 12:30 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Request for Trial Recommendation')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

        input {
            color: black;
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }


        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        #loadingDiv{
            margin: 0px;
            display: none;
            padding: 0px;
            position: absolute;
            right: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background-color: rgb(255, 255, 255);
            z-index: 30001;
            opacity: 0.8;
        }

        #loading {
            position: absolute;
            color: White;
            top: 50%;
            left: 45%;
        }

    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Request for Trial Recommendation
                    </label>
                </header>

                <div class="panel-body table-responsive">
                    <div class="table table-responsive">
                        <table id="rap" class="display nowrap table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Ref. No</th>
                                <th>Product Name</th>
                                <th>Item Description</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Supplier Name</th>
                                <th>Concern Product</th>
                                <th>SCM Remarks</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $applicantData as $data)
                                <tr>
                                    <td style="display: none;"><input type="text" class="line_id" name="line_id" value="{{ $data->line_id }}"></td>
                                    <td><span >{{ $data->trial_ref_no }} </span></td>
                                    <td><span >{{ $data->product_name }} </span></td>
                                    <td><span >{{ $data->item_desc }} </span></td>
                                    <td><span >{{ $data->qty }} </span></td>
                                    <td><span >{{ $data->uom }} </span></td>
                                    <td><span >{{ $data->supplier_name }} </span></td>
                                    <td><span >{{ $data->concern_product }} </span></td>
                                    <td><span >{{ $data->scm_remarks }} </span></td>

                                    <td>
                                        @if( $data->rcm_app_date == '' ) <span class="label label-warning">Pending</span>
                                        @elseif( $data->rcm_app_date != '' ) <span class="label label-success">Accept</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if( $data->rcm_app_date == '')
                                            <button type="button" class='btn btn-info btn-xs accept' id="accept"><span
                                                        class="glyphicon glyphicon-ok"></span> Accept
                                            </button>
                                        @else
                                            <button type="button" class='btn btn-info btn-xs disabled'><span
                                                        class="glyphicon glyphicon-ok"></span> Accept
                                            </button>
                                        @endif
                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <div id="loadingDiv">
        <p id="loading">
            <img src="{{url('public/site_resource/images/preloader.gif')}}"
                 alt="Loading Report Please wait..." width="35px" height="35px">
        </p>
    </div>



    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
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

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script type="text/javascript">

        var $loading = $('#loadingDiv').hide();

        $(function () {

            $('.accept').on('click', function () {
                $(this).attr("disabled", true);
                this.value = '1';
                var line_id = $(this).closest("tr").find(".line_id").val();
                var accept_val = $(this).closest("tr").find(".accept").val();

                console.log(line_id);
                console.log(accept_val);

                $loading.show();

               $.ajax({
                    type: "post",
                    url: '{{url('scm_portal/trial_recommended_confirm')}}',
                    data: {
                        accept_val: accept_val,
                        _token: '{{csrf_token()}}',
                        line_id: line_id
                    },
                    success: function (data) {

                        console.log(data);

                        $loading.hide();


                        if (data.success) {
                            toastr.success(data.success, '', {timeOut: 1000})
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(data.error, '', {timeOut: 1000});
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Contact your administrator.!',
                        });
                    }
               });

            });



        });
    </script>

@endsection