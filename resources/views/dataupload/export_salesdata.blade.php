@extends('_layout_shared._master')
@section('title','UPLOAD EXPORT SALES DATA')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
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

        body{
            color: black;
        }
        .help-block{
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
            border:0px;
        }

        x::-webkit-file-upload-button, input[type=file]:after {
            content:'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border:0px;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Upload Export Sales Data
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">

{{--                        <form action="{{url('dataupload/post_export_sales')}}" method="post" enctype="multipart/form-data">--}}
                        {!! Form::open(array('url'=>'dataupload/post_export_sales','method'=>'POST' ,'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">

                            {{--<form action="postImport" method="post" enctype="multipart/form-data">--}}

                                {{--<input type="file" name="customer">--}}
                                {{--<input type="submit" value="Import">--}}
                            {{--</form>--}}


                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="date_from">
                                <b>Select File:</b>
                            </label>

                                {{--<label class="btn btn-default btn-file">--}}
                                    {{--Browse <input type="file" style="display: none;">--}}
                                {{--</label>--}}


                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="input-group">
                                    {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}

                                        <input type="file" id="date_from" name="export_sales_data_name" class="form-control input-sm">

                                    @if ($errors->has('export_sales_data_name')) <p class="help-block">{{ $errors->first('export_sales_data_name') }}</p> @endif
                                    {{--<span class="input-group-addon"><i class="fa fa-calendar"></i></span>--}}


                                </div>
                            </div>

                        </div>
                            <div class="form-group">
                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                {{--<button type="button" id="btn_display" class="btn btn-default btn-sm">--}}
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-check"></i> <b>Upload</b>
                                </button>


                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <br><b style="color: green;">Excel Demo Format Below:</b> <br>
                                {{Html::image('public/site_resource/images/excel_demo_format1.png')}}


                            </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                                                <label for="">
                                                    <scan style="color:#337ab7"><b> Uploaded Data </b>
                                                    </scan>
                                                </label>

                                                 <table class="table table-bordered education_table">

                                                    <!-- thead -->
                                                    <thead>

                                                    <th>SALES_YEAR</th>
                                                    <th>SALES_MONTH </th>
                                                    <th>SALES_CATA</th>
                                                    <th>COMPANY</th>
                                                    <th>SALES_PERSON</th>
                                                    <th>SALES_BDT</th>
                                                    <th>SALES_USD</th>
                                                   
                                                
                                                    </thead>
                                                    <!-- TBODY -->
                                                    <tbody>

                                                        @forelse($upload_excel_info as $updata)
                                                        <tr>
                                                            
                                                       
                                                        <td>{{$updata->sales_year}}</td>
                                                        <td>{{$updata->sales_month}}</td>
                                                        <td>{{$updata->sales_cata}}</td>
                                                        <td>{{$updata->company}}</td>
                                                        <td>{{$updata->sales_person}}</td>
                                                        <td>{{$updata->sales_bdt}}</td>
                                                        <td>{{$updata->sales_usd}}</td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            Data not upload yet
                                                        </tr>
                                                        @endforelse


                                                   
                                                </tbody>
                                            </table>

                                            </div>
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
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>



    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}
    {{--{{Html::script('public/site_resource/js/dcr_scripts/dvsr_script.js')}}--}}
    {{--<script>--}}
        {{--servloc = "{{url('dcrep/resp_dvs_rep')}}";--}}
        {{--servloc_t = "{{url('dcrep/resp_terr_id')}}";--}}
    {{--</script>--}}
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                console.log("hello");
                // console.log("{{ Session::get('up_data') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>

@endsection
