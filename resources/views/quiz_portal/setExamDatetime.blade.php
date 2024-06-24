<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 4/7/2019
 * Time: 11:58 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Exam Date and Time')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
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


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Set Exam Date & Time
                    </label>
                </div>
                <div class="panel-body" style="padding-top: 2%">

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> {{ session()->get('message') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Error!</strong> {{ session()->get('error') }}
                        </div>
                    @endif

                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">

                                <div class='col-sm-4'>
                                    <div class="form-group">
                                        <label for="region"
                                               class="col-md-2 col-sm-2 control-label"><b>Group:</b></label>
                                        <div class="col-md-10 col-sm-10">
                                            <select name="grp" id="grp"
                                                    class="form-control input-sm grp">
                                                <option value="">Select Group</option>
                                                @foreach($grpInfo as $l)
                                                    <option value="{{$l->group_id}}">{{$l->group_id}}
                                                        - {{$l->group_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class='col-sm-8 col-md-8'>
                                    <div class='col-md-10 col-sm-10'>
                                        <label for="Date"
                                               class="col-md-1 col-sm-1 control-label"><b>Date:</b></label>
                                        <div class='col-md-5 col-sm-5'>
                                            <div class="form-group">
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input type='text' class="form-control"/>
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-5 col-sm-5'>
                                            <div class="form-group">
                                                <div class='input-group date' id='datetimepicker2'>
                                                    <input type='text' class="form-control"/>
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label for="region"
                                               class="col-md-2 col-sm-2 control-label"><b>Minutes:</b></label>
                                        <div class="col-md-10 col-sm-10">
                                            <input type="number"  id="ex_time" name="ex_time" >
                                        </div>
                                    </div>
                                </div>

                                <div class='col-sm-4'>
                                    <div class="form-group">
                                        <div class="col-md-10 col-sm-10">
                                            <input type="button" id="btn-exm" name="Set Exam" class="btn btn-primary btn-sm"
                                                   value="Set Exam">
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

    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-warning">
                <div class="panel-heading">
                    <label class="text-default">
                        Verify Exam Date & Time
                    </label>
                </div>
                <div class="panel-body" style="padding-top: 2%">

                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">

                                <div class='col-sm-4'>
                                    <div class="form-group">
                                        <label for="region"
                                               class="col-md-2 col-sm-2 control-label"><b>Group:</b></label>
                                        <div class="col-md-10 col-sm-10">
                                            <select name="v_grp" id="v_grp"
                                                    class="form-control input-sm v_grp">
                                                <option value="">Select Group</option>
                                                @foreach($grpInfo as $l)
                                                    <option value="{{$l->group_id}}">{{$l->group_id}}
                                                        - {{$l->group_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class='col-sm-4 col-md-4'>

                                    <input type="button" id="btn-verifyexm" name="" class="btn btn-primary btn-sm"
                                           value="Verify Exam">
                                </div>


                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </div>

    <div class="row" id="rls" style="display: none">

        <div class="col-md-12">
            <div class="panel panel-success">
                <header class="panel-heading">
                    Exam Details
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive">
                        <table class="table table-bordered" id="lvs">
                            <thead>
                            <tr>
                                <th>GROUP_ID</th>
                                <th>GROUP_NAME</th>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>DURATION</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>




@endsection
@section('footer-content')
{{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
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

    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script type="text/javascript">
        $(function () {
            $('#rls').hide();

            $('#datetimepicker1').datetimepicker();
            $('#datetimepicker2').datetimepicker();

            $('.grp').select2();
            $('.v_grp').select2();

            $('#btn-exm').on('click', function () {

                var grp = $('#grp').val();
                var dat1 = $('#datetimepicker1').data('date');
                var dat2 = $('#datetimepicker2').data('date');
                var ex_time = $('#ex_time').val();


                if (!$.trim(grp).length) {
                    toastr.error('Please Select Group', {timeOut: 2000});
                } else if ( !$.trim(dat1).length ) {
                    toastr.error('Start Date Time Not Found!', {timeOut: 2000});
                } else if (!$.trim(dat2).length ) {
                    toastr.error('End Date Time Not Found!', {timeOut: 2000});
                } else if ( !$.trim(ex_time).length ) {

                    console.log(ex_time);
                    toastr.error('Exam Time!', {timeOut: 2000});
                }
                else {
                    $.ajax({
                        type: "post",
                        url: "{{ url('quiz/exmSetTime') }}",
                        data: {
                            grp: grp,
                            dat1: dat1,
                            dat2: dat2,
                            ex_time: ex_time,
                            '_token': '{{csrf_token()}}'
                        },
                        success: function (data) {
                            //console.log(data);
                            if (data.success) {
                                toastr.success(data.success, '', {timeOut: 2000});
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.error(data.error, '', {timeOut: 2000});
                            }
                        },
                        error: function (data) {
                            toastr.error(data, 'Contact Your administrator', {timeOut: 2000});
                        }
                    });
                }

            });

            $('#btn-verifyexm').on('click', function () {
                //console.log('Yes Clicked');
                $('#rls').show();
                var v_grp = $('#v_grp').val();
                $.ajax({
                    type: "post",
                    url: "{{ url('quiz/verifyexm') }}",
                    data: {
                        v_grp: v_grp,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (data) {
                        //console.log(data);


                        $("#lvs").DataTable().destroy();
                        var xtable = $("#lvs").DataTable({
                            data: data,
                            columns: [
                                {data: "group_id"},
                                {data: "group_name"},
                                {data: "start_date_time"},
                                {data: "end_date_time"},
                                {data: "exam_duration"}
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: false,
                            paging: false,
                            filter: false
                        });

                    },
                    error: function (data) {
                        toastr.error(data, 'Contact Your administrator', {timeOut: 2000});
                    }
                });
            });

        });
    </script>

@endsection
