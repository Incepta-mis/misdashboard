@extends('_layout_shared._master')
@section('title','UPLOAD MATERIAL DATA')
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
                        Upload Material Data
                    </label>
                </header>
                <div class="panel-body">

                    <div class="form-horizontal">
                        {!! Form::open(array('url'=>'scm_portal/material_up_data','method'=>'POST' ,'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="date_from">
                                <b>Select File:</b>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="input-group">
                                    <input type="file" id="date_from" name="import_file" class="form-control input-sm">
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
                                {{Html::image('public/site_resource/images/Material_upload_formate.png')}}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- @if( !empty($materials) )

        <div class="row" id="report-body">
            <div class="">
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div class="table-responsive">

                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>BLOCKLIST_YEAR</th>
                                        <th>BLOCKLIST_DATE</th>
                                        <th>PLANT</th>
                                        <th>BLOCKLIST_NO</th>
                                        <th>MATERIAL_NAME</th>
                                        <th>MANUFACTURER_NAME</th>
                                        <th>SUPPLIER_NAME</th>
                                        <th>QTY</th>
                                        <th>UOM</th>
                                        <th>AIR_PRICE</th>
                                        <th>ROAD_PRICE</th>
                                        <th>SEA_PRICE</th>
                                        <th>CURRENCY</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $materials as $mat)
                                        <tr>
                                            <td>{{$mat->blocklist_year}}</td>
                                            <td>{{date('d-m-Y', strtotime($mat->blocklist_date))}}</td>
                                            <td>{{$mat->plant}}</td>
                                            <td>{{$mat->blocklist_no}}</td>
                                            <td>{{$mat->material_name}}</td>
                                            <td>{{$mat->manufacturer_name}}</td>
                                            <td>{{$mat->supplier_name}}</td>
                                            <td>{{$mat->qty}}</td>
                                            <td>{{$mat->uom}}</td>
                                            <td>{{$mat->air_price}}</td>
                                            <td>{{$mat->road_price}}</td>
                                            <td>{{$mat->sea_price}}</td>
                                            <td>{{$mat->currency}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @endif -->

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

    <script>

        $(document).ready(function () {
            table = $('#example').DataTable();

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
    </script>

@endsection
