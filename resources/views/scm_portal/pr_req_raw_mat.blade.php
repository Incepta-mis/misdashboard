@extends('_layout_shared._master')
@section('title','Purchase Requisition for Raw Materials')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/bootstrap-datepicker/css/datepicker-custom.css')}}" rel="stylesheet" type="text/css"/>

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
        #upload_file{
            outline: none;
            padding: 2px 2px 2px 7px;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }
        a:hover{
            text-decoration: none;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Upload Raw Material List
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {!! Form::open(array('url'=>'scm_portal/uploadRawMaterialList','method'=>'POST' ,
                                'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label col-md-3" for="upload_file">Select File:</label>
                                        <div class="col-md-6 col-xs-11">
                                            <div class="input-group">
                                                <input type="file" id="upload_file" name="upload_file"
                                                       class="form-control form-control-inline input-medium">
                                                @if ($errors->has('upload_file'))
                                                    <p class="help-block">{{ $errors->first('upload_file') }}</p> @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fa fa-check"></i> <b>Upload</b>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12" >
                                        <label class="control-label col-md-6"><span>Click <a href="{{url
                                        ('scm_portal/downloadFile')}}"><i class="fa fa-hand-o-right"></i> Here </a>to
                                            see the sample file.</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('dup_data'))
                    <?php
                        $val = json_decode(session('dup_data'),true);
                        if(count($val) > 0){
                    ?>
                            <div class="row">
                                <div id="report-body">
                                    <div class="col-sm-12 col-md-12">
                                        <section class="panel" id="data_table">
                                            <header class="panel-heading" style="text-transform: inherit; color: #e37f52;
                                             font-size: 13px;">
                                                <label class="text-default" style="color: orangered">
                                                    Due to the Purch Req and Material values matching the existing data, these details could not be uploaded.
                                                </label>
                                            </header>
                                            <div class="panel-body">
                                                <div class="col-md-12 col-sm-12 table-responsive">
                                                    <table id="listTable" width="100%" class="table table-bordered table-condensed table-striped">
                                                        <thead style="background-color: #5e5e5e; color: white">
                                                        <tr>
                                                            <th>Plant ID</th>
                                                            <th>Purch Req</th>
                                                            <th>Material</th>
                                                            <th>Material Desc.</th>
                                                            <th>Material Group</th>
                                                            <th>Quantity</th>
                                                            <th>Unit</th>
                                                            <th>Categories</th>
                                                            <th>Req Date</th>
                                                            <th>Delivery Date</th>
                                                            <th>Requisnr</th>
                                                            <th>Tracking No</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @for ($i = 0; $i < count($val); $i++)
                                                                <tr>
                                                                    <td>{{ $val[$i]['plant_id'] }}</td>
                                                                    <td>{{ $val[$i]['purch_req'] }}</td>
                                                                    <td>{{ $val[$i]['material'] }}</td>
                                                                    <td>{{ $val[$i]['material_desc'] }}</td>
                                                                    <td>{{ $val[$i]['material_group'] }}</td>
                                                                    <td>{{ $val[$i]['quantity'] }}</td>
                                                                    <td>{{ $val[$i]['unit'] }}</td>
                                                                    <td>{{ $val[$i]['categories'] }}</td>
                                                                    <td>{{ $val[$i]['req_date'] }}</td>
                                                                    <td>{{ $val[$i]['delivery_date'] }}</td>
                                                                    <td>{{ $val[$i]['requisnr'] }}</td>
                                                                    <td>{{ $val[$i]['tracking_no'] }}</td>
                                                                </tr>
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                    <?php }?>
                @endif
            </section>
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
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
    {{Html::script('public/site_resource/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}

    <script>
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
