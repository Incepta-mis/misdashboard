@extends('_layout_shared._master')
@section('title','SCM Notice Management')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
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
        .swal2-icon.swal2-warning {
            font-size: 14px;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        SCM Notice Upload
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {!! Form::open(array('url'=>'scm_portal/uploadSCMnotice','method'=>'POST' ,
                                'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-4 col-sm-12">
                                        <label class="control-label col-md-6" for="notice_name">Notice Name</label>
                                        <div class="col-md-6 col-xs-11">
                                            <div class="input-group">
                                                <input type="text" id="notice_name" name="notice_name"
                                                       class="form-control form-control-inline input-medium">
                                                @if ($errors->has('notice_name'))
                                                    <p class="help-block">{{ $errors->first('notice_name') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label class="control-label col-md-6" for="upload_file">Select File:</label>
                                        <div class="col-md-6 col-xs-11">
                                            <div class="input-group">
                                                <input type="file" id="upload_file" name="upload_file"
                                                       class="form-control form-control-inline input-medium">
                                                @if ($errors->has('upload_file'))
                                                    <p class="help-block">{{ $errors->first('upload_file') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fa fa-check"></i> <b>Upload</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-success">
                <header class="panel-heading">
                    <label class="text-default">
                        Uploaded Notice List
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <?php if(count($data) > 0){?>
                            <div class="row">
                                <div id="report-body">
                                    <div class="col-sm-12 col-md-12">
                                        <section class="panel" id="data_table">
                                            <div class="panel-body">
                                                <div class="col-md-12 col-sm-12 table-responsive">
                                                    <table id="listTable" width="100%" class="table table-bordered table-condensed table-striped">
                                                        <thead style="background-color: #5e5e5e; color: white">
                                                        <tr>
                                                            <th>File Name</th>
                                                            <th>Uploaded at</th>
                                                            <th colspan="2">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($data as $val)
                                                            <tr>
                                                                <td>{{ explode('/', $val->file_path)[2] }}</td>
                                                                <td>{{ $val->created_at }}</td>

                                                                <td><a type='button' class="btn btn-primary btn-xs"
                                                                       href="{{$url}}/misdashboard/storage/<?php echo
                                                                       $val->file_path;
                                                                       ?>" target="_blank">View</a></td>
                                                                <td><a type='button' class="btn btn-danger
                                                                btn-xs" onclick="DeleteThisRecord('{{$val->id}}')
                                                                            ">Delete</a></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        <?php }else{?>
                            <div class="row">
                                <div id="report-body">
                                    <div class="col-sm-12 col-md-12">
                                        <h5 style="color: red; text-align: center;" >There is no data available.</h5>
                                    </div>
                                </div>
                            </div>
                        <?php }?>

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

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}

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

        function DeleteThisRecord(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('scm_portal/deleteThisRecord') }}',
                        data: { 'id':id, '_token': "{{ csrf_token () }}"},
                        success: function (data) {
                            if(data.result == 1 || data.result == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Notice has been deleted Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to Delete',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
    </script>
@endsection
