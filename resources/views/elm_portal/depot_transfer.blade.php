<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 25/3/2021
 * Time: 4:40 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Employee Transfer')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/bootstrap-lightbox.min.css')}}" rel="stylesheet" type="text/css"/>


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
            font-size: 9px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 9px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 9px;
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

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Employee Transfer
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Employee Id: </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control input-sm" required autofocus
                                                   name="emp_id" id="emp_id"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <div class="col-md-1 col-sm-1 col-xs-1">
                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
                    <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                        <div class="panel">
                            <img src="{{url('public/site_resource/images/preloader.gif')}}"
                                 alt="Loading Report Please wait..." width="35px" height="35px"><br>
                            <span><b><i>Please wait...</i></b></span>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>

    <div class="row" id="report-body" style="display: flex;  align-items: center; ">


        <div class="col-lg-5">
            <section class="panel">
                <header class="panel-heading">
                    Current Information
                </header>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" id="info_form">
                        <div class="form-group">
                            <label for="plant_id" class="col-lg-4 col-sm-4 control-label">Plant Id</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" id="plant_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-lg-4 col-sm-4 control-label">Email</label>
                            <div class="col-lg-8">
                                <input type="email" class="form-control input-sm" id="email" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_no" class="col-lg-4 col-sm-4 control-label">Contact No</label>
                            <div class="col-lg-8">
                                <input type="email" class="form-control input-sm" id="contact_no" name="contact_no">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="report_supervisor" class="col-lg-4 col-sm-4 control-label">Recommend</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" id="report_supervisor"
                                       name="report_supervisor">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="head_of_dept" class="col-lg-4 col-sm-4 control-label">Approve</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" id="head_of_dept" name="head_of_dept">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hr_officer" class="col-lg-4 col-sm-4 control-label">HR Officer 1</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" id="hr_officer" name="hr_officer">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hr_officer1" class="col-lg-4 col-sm-4 control-label">HR Officer 2</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm " id="hr_officer1" name="hr_officer1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hr_officer2" class="col-lg-4 col-sm-4 control-label">HR Officer 3</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" id="hr_officer2" name="hr_officer2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="head_of_hr" class="col-lg-4 col-sm-4 control-label">HR Head</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" id="head_of_hr" name="head_of_hr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mgt_status" class="col-lg-4 col-sm-4 control-label">Management</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" required autofocus id="mgt_status"
                                       name="mgt_status">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="valid" class="col-lg-4 col-sm-4 control-label">Valid</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" id="valid" name="valid">
                            </div>
                        </div>

                    </form>
                </div>
            </section>
        </div>

        <div class="col-lg-2">
            <div style=" text-align:center;">
                <img src="{{url('public/site_resource/images/transferimg.png')}}"
                     alt="Transfer..." width="100">
            </div>
        </div>

        <div class="col-lg-5">
            <section class="panel">
                <header class="panel-heading">
                    Update / Transfer Information
                </header>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" id="myForm">
                        <div class="form-group">
                            <label for="t_plant_id" class="col-lg-4 col-sm-4 control-label">Plant Id</label>
                            <div class="col-lg-8">
{{--                                <input type="text" class="form-control input-sm" required autofocus id="t_plant_id" name="t_plant_id">--}}
                                <select class="form-control" id="t_plant_id" name="t_plant_id">
                                    <option value="">Select ...</option>
                                    @foreach($rs as $val)
                                        <option value="{{ $val->plant_id }}">{{ $val->plant_id }} - {{ $val->plant_name }}</option>
                                    @endforeach


                                    <option value="M">Management</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" class="form-control input-sm" required autofocus id="c_emp_id"
                               name="c_emp_id">

                        <div class="form-group">
                            <label for="t_email" class="col-lg-4 col-sm-4 control-label">Email</label>
                            <div class="col-lg-8">
                                <input type="email" class="form-control input-sm" required autofocus id="t_email"
                                       name="t_email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_contact_no" class="col-lg-4 col-sm-4 control-label">Contact No</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" required autofocus id="t_contact_no"
                                       name="t_contact_no">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_report_supervisor" class="col-lg-4 col-sm-4 control-label">Recommend</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" required autofocus
                                       id="t_report_supervisor" name="t_report_supervisor">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_head_of_dept" class="col-lg-4 col-sm-4 control-label">Approve</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" required autofocus id="t_head_of_dept"
                                       name="t_head_of_dept">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_hr_officer" class="col-lg-4 col-sm-4 control-label">HR Officer 1</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" required autofocus id="t_hr_officer"
                                       name="t_hr_officer">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_hr_officer1" class="col-lg-4 col-sm-4 control-label">HR Officer 2</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm " required autofocus id="t_hr_officer1"
                                       name="t_hr_officer1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_hr_officer2" class="col-lg-4 col-sm-4 control-label">HR Officer 3</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" required autofocus id="t_hr_officer2"
                                       name="t_hr_officer2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_head_of_hr" class="col-lg-4 col-sm-4 control-label">HR Head</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control input-sm" required autofocus id="t_head_of_hr"
                                       name="t_head_of_hr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_mgt_status" class="col-lg-4 col-sm-4 control-label">Management</label>
                            <div class="col-lg-8">

                                <select class="form-control" id="t_mgt_status" name="t_mgt_status">
                                    <option value="">Select ...</option>
                                    <option value="NM">Non-Management</option>
                                    <option value="M">Management</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="t_valid" class="col-lg-4 col-sm-4 control-label">Valid</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="t_valid" name="t_valid">
                                    <option value="">Select ...</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type="button" id="smt" class="btn btn-warning text-center">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

    </div>



    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/bootstrap-lightbox.min.js')}}
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

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}




    <script type="text/javascript">


        $('#t_plant_id').select2();

        $(document).ready(function () {

            $("#report-body").hide();

            $("#btn_display").click(function () {

                if ($.trim($('#emp_id').val()) === '') {

                    swal({
                        icon: 'error',
                        type: 'error',
                        text: 'Please select Employee!'
                    });
                } else {

                    $("#loader").show();
                    let updatedUser = "{{ Auth::user()->user_id }}";
                    let emp_id = $('#emp_id').val();
                    console.log(emp_id);

                    if ($("#report-body").is(":visible")) {
                        $("#report-body").hide();
                    }

                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        data: {emp_id: emp_id},
                        url: "{{ url('elm_portal/getDepotEmployeeInfo') }}",
                        success: function (data) {


                            if($.trim(data)){
                                $("#loader").hide();
                                $("#report-body").show();
                                console.log('data =', data);
                                let mgt = '';
                                if ($.trim(data[0].mgt_status) === '') {
                                    mgt = 'M';
                                } else {
                                    mgt = 'NM';
                                }

                                $('#plant_id').val(data[0].plant_id);
                                $('#c_emp_id').val(data[0].emp_id);
                                $('#email').val(data[0].mail_address);
                                $('#contact_no').val(data[0].contact_no);
                                $('#report_supervisor').val(data[0].report_supervisor);
                                $('#head_of_dept').val(data[0].head_of_dept);
                                $('#hr_officer').val(data[0].hr_officer);
                                $('#hr_officer1').val(data[0].hr_officer1);
                                $('#hr_officer2').val(data[0].hr_officer2);
                                $('#head_of_hr').val(data[0].head_of_hr);
                                $('#mgt_status').val(mgt);
                                $('#valid').val(data[0].valid);
                            }else{
                                $("#loader").hide();
                                $("#report-body").hide();
                                $("#info_form")[0].reset();
                                toastr.error('Please Enter Valid Employee Id', 'No Record Found!', {timeOut: 4000});
                            }



                        },
                        error: function () {

                        }
                    });
                }


            });

            let form = $("#myForm");
            $("#smt").click(function () {

                if ($.trim($('#t_plant_id').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write Plant ID!'});
                } else if ($.trim($('#t_email').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write valid email!'});
                } else if ($.trim($('#t_contact_no').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write contact no!'});
                } else if ($.trim($('#t_report_supervisor').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write recommend ID!'});
                } else if ($.trim($('#t_head_of_dept').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write approve ID!'});
                } else if ($.trim($('#t_hr_officer').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write HR officer 1!'});
                } else if ($.trim($('#t_hr_officer1').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write HR officer 2!'});
                } else if ($.trim($('#t_hr_officer2').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write HR officer 3!'});
                } else if ($.trim($('#t_head_of_hr').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please write Head Of HR ID!'});
                } else if ($.trim($('#t_mgt_status').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please select Management Status!'});
                } else if ($.trim($('#t_valid').val()) === '') {
                    swal({icon: 'error', type: 'error', text: 'Please select valid!'});
                } else {
                    $.ajax({
                        type: "get",
                        url: "{{ url('elm_portal/setDepotEmployeeInfo') }}",
                        data: $("#myForm input,select").serialize(),//only input
                        success: function (response) {
                            console.log(response);
                            if (response.success) {
                                toastr.success(response.success, '', {timeOut: 2000});
                            } else {
                                toastr.error(response.error, '', {timeOut: 2000});
                            }
                        }
                    });
                }


            });

        });


    </script>




@endsection

