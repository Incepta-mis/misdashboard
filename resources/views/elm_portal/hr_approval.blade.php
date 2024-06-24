
<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 12/1/2018
 * Time: 4:49 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Application Leave Status')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <!--pickers css-->
    {{--        <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"--}}
    type="text/css"/>

    {{--<link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>


    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">--}}



    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
            font-size: x-small;
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

        .cnt {
            text-align: center;
        }

        /*.hd {*/
        /*height: 100% !important;*/
        /*min-height: 786px;*/
        /*}*/

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .modal {

        }

        .modal-dialog {
            width: 90%;
            height: 90%;

        }

        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
        }

        .vertical-align-center {
            /*To center vertically */
            display: table-cell;
            vertical-align: middle;
        }

        .modal-content {
            height: auto;
            /*min-height: 100%;*/
            border-radius: 0;
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
        }

        .form-control {
            height: 24px;

        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        HR Approval
                    </label>
                </header>

                <div class="panel-body">
                    <div class="table table-responsive">
                        <table id="example" class="display nowrap table table-striped table-bordered" class=""
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Emp ID</th>
                                <th>Name</th>
                                <th>Plant</th>
                                <th>Dept</th>
                                <th>Application Date</th>
                                <th>Leave Date</th>
                                <th>No of Day</th>
                                <th>Type</th>
                                {{--<th>Responsible Person</th>--}}
                                <th>RECOMMEND BY</th>
                                <th>APPROVED BY</th>
                                <th>APPR. NAME</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($appData as $data)
                                <tr>
                                    <td>{{$data->emp_id}}</td>
                                    <td>{{$data->emp_name}}</td>
                                    <td>{{$data->plant_name}}</td>
                                    <td>{{$data->emp_dept_name}}</td>
                                    <td>{{date('d-M-Y', strtotime($data->application_date))}}</td>
                                    <td>{{date('d-M-Y', strtotime($data->leave_from))}}
                                        to {{ date('d-M-Y', strtotime($data->leave_to))}}</td>
                                    <td>{{$data->day_of_leave}}</td>
                                    <td>{{$data->type_of_leave}}</td>

                                    {{--<td>--}}
                                        {{--@if( $data->rejected_id != '' ) <span class="label label-danger">Rejected</span>--}}
                                        {{--@elseif( $data->rsp_accept == 'NO' ) <span--}}
                                                {{--class="label label-warning">Pending</span>--}}
                                        {{--@elseif( $data->rsp_accept == 'YES' ) <span--}}
                                                {{--class="label label-success">Accept</span>--}}
                                        {{--@endif--}}
                                    {{--</td>--}}



                                    <td>
                                        @if( $data->sup_rejected_id != '' ) <span class="label label-danger">Rejected</span>
                                        @elseif( $data->sup_accept == 'NO' ) <span
                                                class="label label-warning">Pending</span>
                                        @elseif( $data->sup_accept == 'YES' ) <span
                                                class="label label-success">Accept</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if( $data->head_rejected_id != '' ) <span class="label label-danger">Rejected</span>
                                        @elseif( $data->rcm_approved_date == '' ) <span
                                                class="label label-warning">Pending</span>
                                        @elseif( $data->rcm_approved_date != '' ) <span
                                                class="label label-success">Accept</span>
                                        @endif
                                    </td>
                                    <td>{{$data->rcm_name}}</td>
                                    <td>
                                        @if( $data->hr_rejected_id != '' ) <span class="label label-danger">Rejected</span>
                                        @elseif( $data->status == 'NO' ) <span
                                                class="label label-warning">Pending</span>
                                        @elseif( $data->status == 'YES' ) <span
                                                class="label label-success">Accept</span>
                                        @endif
                                    </td>

                                    <td>

                                        @if( $data->status == 'NO' )
                                            @if($data->hr_rejected_id != '')
                                                <button type="button" class='btn btn-primary btn-xs  disabled'><span
                                                            class="glyphicon glyphicon-edit"></span> Edit
                                                </button>
                                                <button type="button" class='btn btn-info btn-xs acpt disabled' ><span class="glyphicon glyphicon-ok"></span> Accept</button>
                                                <button type="button" class="btn btn-danger btn-xs rejt disabled" ><span class="glyphicon glyphicon-remove"></span> Reject</button>
                                            @else
                                                <button type="button" data-id="{{$data->line_id}}" data-toggle="modal"
                                                        class='btn btn-primary btn-xs edit-btn'><span
                                                            class="glyphicon glyphicon-edit"></span> Edit
                                                </button>
                                                <button type="button" class='btn btn-info btn-xs accept' id="accept"><span class="glyphicon glyphicon-ok"></span> Accept</button>
                                                <button type="button" class="btn btn-danger btn-xs" id="reject"><span class="glyphicon glyphicon-remove"></span> Reject</button>
                                            @endif
                                        @else
                                            <button type="button" class='btn btn-primary btn-xs  disabled'><span
                                                        class="glyphicon glyphicon-edit"></span> Edit
                                            </button>
                                            <button type="button" class='btn btn-info btn-xs acpt disabled' ><span class="glyphicon glyphicon-ok"></span> Accept</button>
                                            <button type="button" class="btn btn-danger btn-xs rejt disabled" ><span class="glyphicon glyphicon-remove"></span> Reject</button>
                                        @endif

                                    </td>
                                    @if($data->status == 'NO')
                                        <input type="hidden" class="line_id" name="line_id" value="{{ $data->line_id }}">
                                        <input type="hidden" id="emp_id" name="emp_id" value="{{ $data->emp_id }}">
                                        <input type="hidden" id="emp_email" name="emp_email" value="{{ $data->emp_email }}">
                                        <input type="hidden" id="emp_name" name="emp_name" value="{{ $data->emp_name }}">
                                    @endif

                                </tr>
                            @endforeach
                            </tbody>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>



    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">

            <form method="post" role="form" action="{{ url('elm_portal/pleaveapp') }}" id="edfrm">
                {{ csrf_field() }}

                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Form Tittle</h4>
                    </div> -->


                    <div class="modal-body">

                        <input type="hidden" class="form-control" id="line_id" name="line_id">

                        <div class="form-horizontal">

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <section class="panel panel-info" id="data_table">
                                        <header class="panel-heading">
                                            <label class="text-default">
                                                Leave Application Form
                                            </label>
                                            <button aria-hidden="true" style="background-color: red; opacity: initial" data-dismiss="modal" class="close" type="button">×</button>
                                        </header>

                                        <div class="panel-body">

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <h5 class="text-center text-primary"><b> Employee Leave Details</b>
                                                    </h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 table-responsive ">

                                                    <table class="table table-hover table-bordered emp_info">
                                                        <thead>
                                                        <tr>
                                                            <th>Employee Code</th>
                                                            <th>Employee Name</th>
                                                            <th>Designation</th>
                                                            <th>Department</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td id="xemp_id"></td>
                                                            <td id="xemp_name"> </td>
                                                            <td id="desig_name"></td>
                                                            <td id="dept"></td>
                                                            <input type="hidden" class="form-control input-sm" id="applicant_name" name="applicant_name">
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-5 col-md-5">
                                                    <div class="form-group">
                                                        <label for="date"
                                                               class="col-md-4 col-sm-4 control-label fnt_size"><b>Date
                                                                of leave on</b></label>
                                                        <div class="col-sm-4 col-md-4" style="padding-left:45px;">
                                                            <input type="text" class="form-control input-sm"
                                                                   name="st_dt"
                                                                   style="font-size: x-small; padding-right: 0px;"
                                                                   id="date1">
                                                        </div>

                                                        <div class="col-sm-3 col-md-3">
                                                            <input type="text" class="form-control input-sm"
                                                                   style="font-size: x-small;"
                                                                   name="en_dt" id="date2">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-md-3">
                                                    <div class="form-group">
                                                        <label for="contact"
                                                               class="col-sm-6 col-md-6 control-label fnt_size"><b>Day
                                                                of
                                                                leave</b></label>
                                                        <div class="col-md-4 col-sm-4"
                                                             style="padding-left:0px;padding-right:30px;">
                                                            <input type="text" class="form-control input-sm" name="dol"
                                                                   id="dol"
                                                                   readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="cmp"
                                                               class="col-md-4 col-sm-4 control-label fnt_size"><b>Type
                                                                of
                                                                leave</b></label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <select name="tol" id="tol"
                                                                    class="form-control input-sm filter-option pull-left tol">
                                                                <option value="">Select Leave</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="cmp"
                                                               class="col-md-6 col-sm-6 control-label fnt_size"><b>Address
                                                                during leave</b></label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <input type="text" class="form-control input-xs"
                                                                   name="adl"
                                                                   id="adl">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="contact"
                                                               class="col-sm-4 col-md-4 control-label fnt_size"><b>Contact
                                                                No</b></label>
                                                        <div class="col-md-6 col-sm-6">

                                                            <input type="text" class="form-control input-xs"
                                                                   name="mob" id="mob"
                                                            >

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label for="contact"
                                                               class="col-sm-4 col-md-4 control-label fnt_size"><b>Email</b></label>
                                                        <div class="col-md-8 col-sm-8">
                                                            <input type="text" class="form-control input-xs"
                                                                   name="email" id="email">


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="" class="col-md-2 col-sm-2 control-label fnt_size"
                                                               style="padding-right:0px; "><b>Purpose
                                                                of leave</b></label>
                                                        <div class="col-md-10 col-sm-10">
                                                            <input type="text" class="form-control input-sm" name="pol"
                                                                   id="pol" style="padding-left: 5px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($mgt_status != 'NM')
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="col-md-12 col-sm-12">
                                                            <h5 class="text-center text-primary"><b>Duties Will be carried
                                                                    out
                                                                    by
                                                                    (Person)</b></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 table-responsive ">


                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Responsible Persone Name</th>
                                                                <th>Employee Code</th>
                                                                <th>Designation</th>
                                                                <th>Department</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <!-- <input type="text" name="" id="rsp_emp"> -->
                                                                    <select name="rsp_emp" id="rsp_emp"
                                                                            class="form-control input-sm  rsp_emp">
                                                                        <option value="">Select Employees</option>

                                                                    </select>

                                                                </td>

                                                                <td><input type="text" class="form-control input-sm"
                                                                           id="rsp_emp_code"
                                                                           name="rsp_emp_code" readonly></td>
                                                                <td><input type="text" class="form-control input-sm"
                                                                           id="rsp_desig"
                                                                           name="rsp_desig_name" readonly></td>
                                                                <td><input type="text" class="form-control input-sm"
                                                                           id="rsp_dept_name"
                                                                           name="rsp_dept_name" readonly></td>


                                                                <input type="hidden" class="form-control input-sm"
                                                                       id="rsp_emp_name" name="rsp_emp_name">
                                                                <input type="hidden" class="form-control input-sm"
                                                                       id="rsp_desig_id"
                                                                       name="rsp_desig_id">
                                                                <input type="hidden" class="form-control input-sm"
                                                                       id="rsp_dept_id"
                                                                       name="rsp_dept_id">
                                                                <input type="hidden" id="rsp_oldemail" name="rsp_oldemail">
                                                                <input type="hidden" id="rsp_oldname" name="rsp_oldname">



                                                            </tr>
                                                            <tr>
                                                                <td class="cnt " colspan="2"><b>Contact No:</b> <input
                                                                            type="text"
                                                                            class="form-control input-sm"
                                                                            id="rsp_cnt_no" readonly
                                                                            name="rsp_cnt_no"/>
                                                                </td>
                                                                <td class="cnt " colspan="2"><b>Email:</b> <input
                                                                            type="text"
                                                                            class="form-control input-sm"
                                                                            id="rsp_email" readonly
                                                                            name="rsp_email">
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label for=""
                                                                   class="col-md-2 col-sm-2 control-label fnt_size"><b>Responsible
                                                                    Duties</b></label>
                                                            <div class="col-md-10 col-sm-10">
                                                                <input type="text" class="form-control input-sm"
                                                                       name="rsp_duties"
                                                                       id="rsp_duties">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>


                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <section class="panel panel-success">
                                    <header class="panel-heading">
                                        <label class="text-default">
                                            Employee Leave Status
                                        </label>
                                    </header>

                                    <div class="panel-body">
                                        <div class="form-horizontal">
                                            <div class="col-md-12 col-sm-12 table-responsive">
                                                <table class="table table-bordered" id="lvs">
                                                    <thead>
                                                    <tr>
                                                        <th>TYPE</th>
                                                        <th>ANNUAL</th>
                                                        <th>CASUAL</th>
                                                        <th>LWP</th>
                                                        <th>MATERNITY</th>
                                                        <th>MEDICAL</th>
                                                        {{--<th>SL</th>--}}
                                                        <th>ADVANCE</th>
                                                        <th>SPECIAL MEDICAL</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>


    </div>



    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>--}}

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
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{--   {{Html::script('public/site_resource/select2/select2.min.js')}}--}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'Bfrtip',
                "aaSorting": [],
                buttons: [

                    {
                        extend: 'excelHtml5', className: "btn-primary",
                        exportOptions: {
                            columns: [0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5', className: "btn-warning",
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                ],

            });

            var dat1, dat2;
            var rsp_eename, rsp_eemail;

            $('.edit-btn').on("click", function () {


                console.log('Yes Clicked');

                $("#myModal").modal('show');
                var line_id = $(this).data('id');
                $(".modal-body #line_id").val(line_id);

                $.ajax({
                    type: "post",
                    url: "{{url('elm_portal/pappeditEmployee')}}",
                    data: {line_id: line_id, '_token': '{{csrf_token()}}'},
                    success: function (data) {
                        console.log(data);
                        var xxx = data.resp_data[0].emp_name;
                        console.log(xxx);


                        $('#xemp_id').text(data.resp_data[0].emp_id);
                        $('#xemp_name').text(data.resp_data[0].emp_name);
                        $('#applicant_name').val(data.resp_data[0].emp_name);



                        $('#desig_name').text(data.resp_data[0].emp_desig_name);
                        $('#dept').text(data.resp_data[0].emp_dept_name);
                        dt1 = data.resp_data[0].leave_from;
                        dt2 = data.resp_data[0].leave_to;


                        $('#date1').datepicker({
                            format: "dd-M-yyyy",
                            todayHighlight: 'TRUE',
                            autoclose: true,
                            minDate: 0,
                            maxDate: '+1Y+6M'
                        })
                            .datepicker('setDate',dt1)
                            .on('changeDate', function (ev) {
                                $('#date2').datepicker('setStartDate', $("#date1").val());
                                $('#tol').val();
                            });

                        $('#date2').datepicker({
                            format: "dd-M-yyyy",
                            todayHighlight: 'TRUE',
                            autoclose: true,
                            minDate: '0',
                            maxDate: '+1Y+6M'
                        })
                            .datepicker('setDate',dt2)
                            .on('changeDate', function (ev) {

                                var d1 = $('#date1').datepicker('getDate');
                                var d2 = $('#date2').datepicker('getDate');
                                var diff = 0;
                                if (d1 && d2) {
                                    diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                                }
                                $('#dol').val(diff);
                            });
                        $('#dol').val(data.resp_data[0].day_of_leave);
                        $('#adl').val(data.resp_data[0].add_during_leave);
                        $('#mob').val(data.resp_data[0].emp_contact_no);
                        $('#email').val(data.resp_data[0].emp_email);
                        $('#pol').val(data.resp_data[0].purpose_of_leave);
                        $('#rsp_emp_code').val(data.resp_data[0].rsp_emp_id);
                        $('#rsp_desig').val(data.resp_data[0].rsp_desig_name);
                        $('#rsp_emp_name').val(data.resp_data[0].rsp_emp_name);

                        $('#rsp_desig_id').val(data.resp_data[0].rsp_desig_id);
                        $('#rsp_dept_id').val(data.resp_data[0].rsp_dept_id);

                        $('#rsp_dept_name').val(data.resp_data[0].rsp_dept_name);
                        $('#rsp_cnt_no').val(data.resp_data[0].rsp_contact_no);
                        $('#rsp_email').val(data.resp_data[0].rsp_email);
                        $('#rsp_duties').val(data.resp_data[0].rsp_duties);


                        //purpose for sending email for notification of cancel //
                        $('#rsp_oldname').val(data.resp_data[0].rsp_emp_name);
                        $('#rsp_oldemail').val(data.resp_data[0].rsp_email);
                        //purpose for sending email for notification of cancel //



                        var selOpts = "";
                        selOpts += "<option value=''>Select Leave</option>";
                        for (var i = 0; i < data.leavetypes.length; i++) {
                            var id = data.leavetypes[i].leave_type;
                            var val = data.leavetypes[i].leave_type;
                            selOpts += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('select#tol').empty().append(selOpts);
                        $('select#tol').val(data.resp_data[0].type_of_leave);

                        var selOptsRsp = "";
                        selOptsRsp += "<option value=''>Select Employees</option>";
                        for (var j = 0; j < data.rsp_emp.length; j++) {
                            var idx = data.rsp_emp[j].emp_id;
                            var valx = data.rsp_emp[j].sur_name;
                            selOptsRsp += "<option value='" + idx + "'>"+ idx +" - "+ valx + "</option>";
                        }


                        $('select#rsp_emp').empty().append(selOptsRsp);
                        console.log(data.resp_data[0].rsp_emp_id);
                        $('select#rsp_emp').val(data.resp_data[0].rsp_emp_id);

                        // $('#rsp_emp').val(data.resp_data[0].rsp_emp_id);

                        console.log(data.resp_data[0].rsp_emp_id);

                        $("#lvs").DataTable().destroy();
                        $("#lvs").DataTable({
                            data: data.leaveStatus,
                            columns: [
                                {data: "type"},
                                {data: "annual"},
                                {data: "casual",className: 'adv'},
                                {data: "lwp"},
                                {data: "maternity"},
                                {data: "medical"},
                                // {data: "sl"},
                                {data: "advance"},
                                {data: "special_medical"}
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: false,
                            paging: false,
                            filter: false,
                        });

                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Not Found.!',
                        });
                    }
                });
            });


            $('#rsp_emp').on('change', function () {
                // console.log('rsp employee code == ',$('#rsp_emp').val());
                var emp_id = $('#rsp_emp').val();

                if (emp_id === ''){
                    $('#rsp_emp_name').val('');
                    $('#rsp_emp_code').val('');
                    $('#rsp_desig_id').val('');
                    $('#rsp_desig').val('');
                    $('#rsp_dept_id').val('');
                    $('#rsp_dept_name').val('');
                    $('#rsp_cnt_no').val('');
                    $('#rsp_email').val('');
                }





                $.ajax({
                    type: "post",
                    url: "{{url('elm_portal/getRspInfo')}}",
                    data: {emp_id: emp_id, '_token': '{{csrf_token()}}'},
                    success: function (data) {
                        console.log('data=',Object.keys(data).length);
                        if(Object.keys(data).length !== 0){
                            $('#rsp_emp_name').val(data[0].sur_name);
                            $('#rsp_emp_code').val(data[0].emp_id);
                            $('#rsp_desig_id').val(data[0].desig_id);
                            $('#rsp_desig').val(data[0].desig_name);
                            $('#rsp_dept_id').val(data[0].dept_id);
                            $('#rsp_dept_name').val(data[0].dept_name);
                            $('#rsp_cnt_no').val(data[0].contact_no);
                            $('#rsp_email').val(data[0].mail_address);
                        }else {
                            $('#rsp_emp_name').val('');
                            $('#rsp_emp_code').val('');
                            $('#rsp_desig_id').val('');
                            $('#rsp_desig').val('');
                            $('#rsp_dept_id').val('');
                            $('#rsp_dept_name').val('');
                            $('#rsp_cnt_no').val('');
                            $('#rsp_email').val('');
                        }

                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Contact Your Administrator.!',
                        });
                    }
                });
            });

            $('form#edfrm').submit(function (e) {

                // e.preventDefault();
                var st_dt = $('#date1').val();
                var en_dt = $('#date2').val();
                var tol = $('#tol').val();
                var dol = parseInt($('#dol').val());
                var rsp_emp_code = $('#rsp_emp_code').val();
                console.log(rsp_emp_code);


                if(rsp_emp_code === ''){
                    console.log('Yes I am in');

                    swal({
                        type: 'error',
                        text: 'Please Select Responsible Person.!',
                    });
                    return false;

                }

                // var xc = $('#lvs tr:eq(1) > td:eq(0)').text();
                // var dd = $('#lvs tr:eq(2) > td:eq(2)').text();

                // console.log(dd);
                // console.log(xc);
                // console.log(tol);
                if(dol < 1){
                    swal({
                        type: 'error',
                        text: 'Check Your Date From and To!',
                    });
                    return false;
                }else if (tol === ''){
                    swal({
                        type: 'error',
                        text: 'Type of Leave Can\'t be null!',
                    });
                    return false;
                }else if (st_dt === '') {
                    swal({
                        type: 'error',
                        text: 'Check Your From Date.!',
                    });
                    return false;
                } else if (en_dt === '') {
                    swal({
                        type: 'error',
                        text: 'Check Your To Date.!',
                    });
                    return false;
                } else if (tol === 'ANNUAL') {
                    var anl = parseInt($('#lvs tr:eq(2) > td:eq(1)').text());
                    console.log('Anl=',anl);
                    if (dol > anl) {
                        swal({
                            type: 'error',
                            text: 'Check Your Annual Leave Status.!',
                        });
                        return false;
                    }

                }else if (tol === 'CASUAL') {
                    var cas = parseInt($('#lvs tr:eq(2) > td:eq(2)').text());
                    if (dol > cas) {
                        swal({
                            type: 'error',
                            text: 'Check Your Casual Leave Status.!',
                        });
                        return false;
                    }

                }else if (tol === 'LWP') {
                    var lwp = parseInt($('#lvs tr:eq(2) > td:eq(3)').text());
                    console.log('Anl=',lwp);
                    if (dol > lwp) {
                        swal({
                            type: 'error',
                            text: 'Check Your LWP Leave Status.!',
                        });
                        return false;
                    }

                }else if (tol === 'MATERNITY') {
                    var mat = parseInt($('#lvs tr:eq(2) > td:eq(4)').text());
                    console.log('MATERNITY=',mat);
                    if (dol > mat) {
                        swal({
                            type: 'error',
                            text: 'Check Your LWP Leave Status.!',
                        });
                        return false;
                    }

                }else if (tol === 'MEDICAL') {
                    var medical = parseInt($('#lvs tr:eq(2) > td:eq(5)').text());
                    console.log('medical=',medical);
                    if (dol > medical) {
                        swal({
                            type: 'error',
                            text: 'Check Your medical Leave Status.!',
                        });
                        return false;
                    }

                }else if (tol === 'SL') {
                    var medical = parseInt($('#lvs tr:eq(2) > td:eq(6)').text());
                    console.log('SL=',SL);
                    if (dol > SL) {
                        swal({
                            type: 'error',
                            text: 'Check Your SL Leave Status.!',
                        });
                        return false;
                    }

                }else if (tol === 'ADVANCE') {
                    var medical = parseInt($('#lvs tr:eq(2) > td:eq(7)').text());
                    console.log('SL=',SL);
                    if (dol > SL) {
                        swal({
                            type: 'error',
                            text: 'Check Your Advance Leave Status.!',
                        });
                        return false;
                    }

                }else if (tol === 'SPECIAL MEDICAL') {
                    var splmedical = parseInt($('#lvs tr:eq(2) > td:eq(8)').text());
                    console.log('date of leave =',dol);
                    console.log('splmedical=',splmedical);
                    if (dol > splmedical) {
                        swal({
                            type: 'error',
                            text: 'Check Your Special Medical Leave Status.!',
                        });
                        return false;
                    }
                }

            });

        });

        $(function () {


            $(this).attr("disabled","disabled");


            $('#accept').on('click',function(){

                // e.preventDefault();
                this.value = '1';
                var accept_val = $('#accept').val();
                // console.log($('#accept').val());
                var line_id = $('.line_id').val();
                var emp_id = $('#emp_id').val();
                var emp_email = $('#emp_email').val();
                var emp_name = $('#emp_name').val();


                console.log("accept_val=",accept_val);
                console.log("line_id=",line_id);
                console.log("emp_id=",emp_id);
                console.log("emp_email=",emp_email);
                console.log("emp_name=",emp_name);


                $.ajax({
                    type: "post",
                    url: '{{url('elm_portal/app_hr_confirm')}}',
                    data: { accept_val: accept_val,
                        emp_id: emp_id ,
                        _token: '{{csrf_token()}}',
                        emp_email : emp_email,
                        emp_name:emp_name,
                        line_id : line_id },
                    success: function (data) {

                        console.log(data);

                        if (data.success) {
                            toastr.success(data.success, '', {timeOut: 2000})
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }
                        else {
                            toaster.error(data.error, '', {timeOut: 2000});
                            setTimeout(function(){
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


            $('#reject').on('click',function(){
                this.value = '0';
                var reject_val = $('#reject').val();
                var line_id = $('.line_id').val();
                var emp_id = $('#emp_id').val();
                var emp_email = $('#emp_email').val();
                var emp_name = $('#emp_name').val();
                var accept_val = $('#accept').val();

                // console.log("reject_val=",reject_val);
                // console.log("line_id=",line_id);
                // console.log("emp_id=",emp_id);
                // console.log("emp_email=",emp_email);
                // console.log("emp_name=",emp_name);



                $.ajax({
                    type: "post",
                    url: '{{url('elm_portal/hr_app_reject')}}',
                    async: false,
                    data: { reject_val: reject_val,
                        emp_id: emp_id ,_token: '{{csrf_token()}}',
                        emp_email : emp_email, emp_name: emp_name, line_id : line_id},
                    success: function (data) {

                        // console.log('Helloooooooo',data);

                        if (data.success) {
                            toastr.error(data.success, '', {timeOut: 2000})
                            setTimeout(function(){
                                location.reload();
                            }, 1000);


                        }
                        else {
                            toaster.error(data.error, '', {timeOut: 2000});
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


