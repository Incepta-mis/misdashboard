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
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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
            content:"*";
            color:red;
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
                        Export Product Information
                    </label>
                </header>

                <div class="panel-body">

                    <form class="form-horizontal" method="get" action="">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">

                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label input-sm">Export
                                            Country:</label>
                                        <div class="col-sm-8 col-md-8 col-xs-8">
                                            <select name="expo_country" id="expo_country"
                                                    class="form-control input-sm expo_country ">
                                                <option value="">Select Country</option>
                                                @foreach($expo as $ex)
                                                    <option value="{{$ex->export_country}}">{{$ex->export_country}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 col-xs-4 control-label input-sm">Product
                                            Name:</label>
                                        <div class="col-sm-8 col-md-8 col-xs-8">
                                            <select name="product_name" id="product_name"
                                                    class="form-control input-sm product_name ">
                                                <option value="">Select Product</option>
                                                <option value="All">All</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <div class="col-md-2 col-sm-2">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye"></i> <b>Display</b></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    <div class="table table-responsive">
                        <table id="example" class="display table table-bordered table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>LINE_ID</th>
                                <th>FINISH_P_CODE</th>
                                <th>P_CODE/BULK_CODE</th>
                                <th>BRAND_NAME</th>
                                <th>EXPORT_COUNTRY</th>
                                <th>PRODUCT_NAME</th>
                                <th>GENERIC_NAME</th>
                                <th>PACK_SIZE</th>
                                <th>AGENT_(COMPANY)</th>
                                <th>AGENT_(PERSON)</th>
                                <th>PLANT</th>
                                <th>RENEW</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tfoot>

                            </tfoot>
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

        $(document).ready(function () {

            $('.expo_country').select2();
            $('.product_name').select2();

            $('#expo_country').on('change',function () {
                var expo_country = $('#expo_country').val();
                var URL = "{{ url('expo/getProductByExpoCountry') }}";
                $.ajax({
                    url: URL,
                    type: "get", //send it through get method
                    data: {
                        export_country: expo_country
                    },
                    success: function(response) {
                        $("#product_name").empty().append("<option value='loader'>Loading...</option>");
                        var selOpts = "";
                        selOpts += '<option value="All" disabled>Select Product</option>';
                        selOpts += '<option value="All">All</option>';
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['expo_product_name'];
                            var val = response[j]['expo_product_name'];
                            selOpts += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#product_name').empty().append(selOpts);
                    },
                    error: function(xhr) {
                        console.log('Error: expo_update_view.blade.php page', xhr);
                    }
                });
            });

            $("#btn_display").click(function () {

                if ($("#report-body").is(":visible")) {
                    $("#report-body").hide();
                }
                $("#loader").show();
                $("#loader").hide();
                var export_country = $('#expo_country').val();
                var expo_product_name = $('#product_name').val();
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    data: {export_country: export_country,expo_product_name:expo_product_name},
                    url: "{{ url('expo/getIMExpoData') }}",
                    success: function (resp) {

                        console.log('Output data: ', resp);

                        $("#loader").hide();
                        $("#report-body").show();

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({
                            data: resp,
                            autoWidth: true,
                            columns: [
                                {data: "line_id"},
                                {data: "finish_product_code"},
                                {data: "product_code"},
                                {data: "brand_name"},
                                {data: "export_country"},
                                {data: "expo_product_name"},
                                {data: "product_generic"},
                                {data: "pack_size"},
                                {data: "company_agent_name"},
                                {data: "contact_name"},
                                {data: "plant_id"},  
                                {data: "renew_status"},  
                                {
                                    data: null,
                                    "render": function (row) {                                
                                            return "<button type='submit' formtarget='_blank' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>";                                      
                                    }


                                }                          
                            ],
                            columnDefs: [
                                {
                                    "targets": [ 0 ],
                                    "visible": false                                    
                                },
                                {
                                    "targets": [ 10 ],
                                    "visible": false
                                }
                            ],
                            order:[],
                            fixedHeader: {
                                header: true,
                                headerOffset: $('#fix').height()
                                //headerOffset: $('#fix').outerHeight()
                            },
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: true,
                            filter: true
                        });

                    },
                    error: function (err) {
                        // //console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });


        });

        $(document).on("click",".edit-btn",function() {

            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var line_id = data.line_id;
            console.log(line_id);

            // window.location ="{{ url('expo/getLineWiseIMData') }}/"+line_id;

            window.open("{{ url('expo/getLineWiseIMData') }}/"+line_id,'_blank');

        });

    </script>
@endsection

