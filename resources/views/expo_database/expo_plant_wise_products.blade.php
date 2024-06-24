@extends('_layout_shared._master')
@section('title','UPLOAD Export Wise Plant Data')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Upload Export Plant Wise Data
                    </label>
                </header>
                <div class="panel-body">

                    <div class="col-sm-6 col-md-6">

                        <div class="form-horizontal">
                            {!! Form::open(array('url'=>'expo/uploadExpoPlantWiseData','method'=>'POST' ,'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="date_from">
                                    <b>Select File:</b>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="input-group">
                                        <input type="file" id="date_from" name="import_file"
                                               class="form-control input-sm">
                                        @if ($errors->has('import_file'))
                                            <p class="help-block">{{ $errors->first('import_file') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-check"></i> <b>Upload</b>
                                    </button>
                                </div>
                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                    <div id="export_buttons">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <br><b style="color: green;">Excel Demo Format Below:</b> <br>
                                    {{Html::image('public/site_resource/images/expo_plant_wise_products.png')}}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6 col-md-6">
                        <div class="form-horizontal">
                            <form class="form-inline" role="form">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-4 input-sm">
                                        <b>Product Code:</b>
                                    </label>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <input type="text" class="form-control" id="search_productCode"
                                               placeholder="Enter Product Code">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="sr_pcode">Search</button>
                            </form>


                            <div id="report-body" style="display: none;">
                                <div class="col-sm-12 col-md-12">
                                    <section class="panel" id="data_table">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="p_list" class="table table-striped table-bordered"
                                                       style="width:100%">
                                                    <thead style="white-space:nowrap;">
                                                    <tr>
                                                        <th>PLANT_ID</th>
                                                        <th>PRODUCT_CODE</th>
                                                        <th>PRODUCT_NAME</th>
                                                        <th>GENERIC</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                                    <tfoot></tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>







@endsection
@section('footer-content')
    {{date('Y')}} <span>&copy; Incepta Pharmaceuticals Ltd.</span>
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

    <script>

        $(document).ready(function () {
            var table = $('#example').DataTable();

            new $.fn.dataTable.Buttons(table, {
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Save As Excel',
                                // footer: true,
                                action: function (e, dt, node, config) {
                                    exportExtension = 'Excel';
                                    $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                }
                            }, {
                                extend: 'pdf',
                                text: 'Save As PDF',
                                orientation: 'landscape',
                                // footer: true,
                                action: function (e, dt, node, config) {
                                    exportExtension = 'PDF';
                                    $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                }
                            }
                        ],
                        className: 'btn btn-sm btn-primary'
                    }
                ]
            }).container().appendTo($('#export_buttons'));
        });

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


        $('#sr_pcode').on('click',function () {
           var p_code = $('#search_productCode').val();

            $.ajax({
                type: "post",
                url: '{{url('expo/getProductInfo')}}',
                data: { product_code: p_code , _token: '{{csrf_token()}}' },
                success: function (data) {

                    console.log(data);
                    $('#report-body').show();

                    $("#p_list").DataTable().destroy();
                    var table = $("#p_list").DataTable({
                        data:data,
                        columns: [
                            {data: "plant_id"},
                            {data: "product_code"},
                            {data: "product_name"},
                            {data: "product_generic"}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: true,
                        paging: true,
                        filter: false
                    });
                },
                error: function (e) {
                    swal({
                        type: 'error',
                        text: e
                    });
                }
            });
        });

    </script>

@endsection
