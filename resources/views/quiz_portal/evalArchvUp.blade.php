@extends('_layout_shared._master')
@section('title','Upload Evaluation Archive')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/bootstrap-datepicker/css/datepicker-custom.css')}}" rel="stylesheet" type="text/css"/>
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
                        Upload Evaluation Archive
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {!! Form::open(array('url'=>'quiz/uploadEvalArchv','method'=>'POST' ,
                                'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12">
                                        <label  class="col-md-3 col-sm-3 control-label fnt_size" for="year">Select Year:</label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="year" name="year"
                                                    class="form-control input-sm filter-option pull-left">
                                                <option selected disabled value = "">Select Year</option>
                                                @foreach($year as $c)
                                                    <option value="{{$c}}" {{ ($c == $currently_selected) ?
                                                    'selected' : '' }}>{{$c}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('year'))
                                                <p class="help-block">{{ $errors->first('year') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label  class="col-md-3 col-sm-3 control-label fnt_size" for="group">Select
                                            Group:</label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="group" name="group"
                                                    class="form-control input-sm filter-option pull-left">
                                                <option selected disabled value = "">Select Group</option>
                                                @foreach($group as $c)
                                                    <option value="{{$c->p_group}}">{{$c->p_group}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('group'))
                                                <p class="help-block">{{ $errors->first('group') }}</p> @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-md-3 col-sm-3 control-label fnt_size" for="upload_file">Select File:</label>
                                        <div class="col-md-9 col-sm-9">
                                            <div class="input-group" style="width: 100%;">
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
                                        ('quiz/downloadFile')}}"><i class="fa fa-hand-o-right"></i> Here </a>to
                                            see the sample file.</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @if (session('data'))
        <?php
        $val = json_decode(session('data'),true);
        if(count($val) > 0){
        ?>
        <div class="row">
            <div id="report-body">
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <header class="panel-heading" style="text-transform: inherit; color: #e37f52;
                                             font-size: 13px;">
                            <label class="text-default" style="color: darkblue">
                                These data have just been uploaded.:
                            </label>
                        </header>
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 table-responsive">
                                <table id="listTable" width="100%" class="table table-bordered table-condensed table-striped">
                                    <thead style="background-color: #5e5e5e; color: white">
                                    <tr>
                                        <th>SL no.</th>
                                        <th>Emp ID</th>
                                        <th>Trr Code</th>
                                        <th>Name of AM</th>
                                        <th>Group</th>
                                        <th>MCQ Score (<?php echo $val[0]['mcq_total']?>)</th>
                                        <th>Broad Question Score (<?php echo $val[0]['broad_ques_total']?>)</th>
                                        <th>Total (<?php echo $val[0]['total_out_of']?>)</th>
                                        <th>Percentage (%)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = 0; $i < count($val); $i++)
                                        <tr>
                                            <td>{{ ($i+1) }}</td>
                                            <td>{{ $val[$i]['emp_id'] }}</td>
                                            <td>{{ $val[$i]['trr_code'] }}</td>
                                            <td>{{ $val[$i]['am_name'] }}</td>
                                            <td>{{ $val[$i]['p_group'] }}</td>
                                            <td>{{ $val[$i]['mcq_score'] }}</td>
                                            <td>{{ $val[$i]['broad_ques_score'] }}</td>
                                            <td>{{ $val[$i]['total_score'] }}</td>
                                            <td>{{ $val[$i]['percentage'] }}</td>
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script>
        $('#group').select2();
        $('#year').select2();

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
