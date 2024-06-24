<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 08/09/2020
 * Time: 3:06 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Requisition - International Dept Head Approved ')
@section('styles')
<link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ url('public/site_resource/css/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css" />



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

    .table>thead>tr>th {
        padding: 2px;
        font-size: 10px;
    }

    .table>tbody>tr>td {
        padding: 2px;
        font-size: 10px;
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

    x::-webkit-file-upload-button,
    input[type=file]:after {
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

    .emp_info>thead>tr>th {
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

    .modal {}

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
                    Travel Approved
                </label>
            </header>

            <div class="panel-body">
                <div class="table table-responsive">
                    <table id="example" class="display nowrap table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="display: none;"></th>
                                <th style="display: none;"></th>
                                <th style="display: none;"></th>
                                <th>Emp ID</th>
                                <th>Name</th>
                                <th>Location</th>

                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rs as $data)

                            {{-- {{ dd($data) }} --}}

                            <tr>


                                <td class="line_id" style="display: none;"> {{$data->id}} </td>
                                <td class="emp_id" style="display: none;"> {{ $data->emp_id }} </td>
                                <td class="emp_name" style="display: none;"> {{ $data->emp_name }} </td>

                                <td>{{$data->emp_id}}</td>
                                <td>{{$data->emp_name}}</td>
                                <td> {{ $data->location }}</td>

                                <td>
                                    @if( $data->dept_accept == 'NO' ) <span class="label label-danger">Rejected</span>
                                    @elseif( $data->dept_accept == '' ) <span class="label label-warning">Pending</span>
                                    @elseif( $data->dept_accept == 'YES' ) <span
                                        class="label label-success">Accept</span>
                                    @endif
                                </td>
                                <td>

                                    @if($data->dept_accept == null)
                                    <button type='button' class='btn btn-success btn-xs accept' id='accept'><span
                                            class='glyphicon glyphicon-ok'></span> </button>
                                    <button type='button' class='btn btn-danger btn-xs reject' id='reject'><span
                                            class='glyphicon glyphicon-remove'></span> </button>
                                    @elseif( $data->dept_accept == 'YES' )
                                    <button class='btn btn-success btn-xs acpt disabled'><span
                                            class='glyphicon glyphicon-ok'></span> </button>
                                    <button class='btn btn-danger btn-xs rejt disabled'><span
                                            class='glyphicon glyphicon-remove'></span> </button>
                                    @elseif ($data->dept_accept == 'NO')
                                    <button class='btn btn-success btn-xs acpt disabled'><span
                                            class='glyphicon glyphicon-ok'></span> </button>
                                    <button class='btn btn-danger btn-xs rejt disabled'><span
                                            class='glyphicon glyphicon-remove'></span> </button>
                                    @endif

                                </td>
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


{{Html::script('public/site_resource/select2/select2.min.js')}}
{{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


<script type="text/javascript">
    $("#example").DataTable({});

        $(document).on("click",".accept",function() {

            $("#example").DataTable().destroy();
            var table = $("#example").DataTable({});
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'accept';
            var id = data[0];
            var empID = data[1];
            var self = $(this);

            // console.log(data);
            // alert( 'You clicked on '+data[0]+'\'s row ' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {id: id, st: st, empID : empID},
                url: "{{ route('international.intlTravelHeadApproved') }}",
                success: function (resp) {
                    // console.log(resp);
                    if (resp.success) {                        
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        location.reload();
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function () {

                }
            });
        });

        //for reject button
        $(document).on("click",".reject",function( ){

            $("#example").DataTable().destroy();
            var table = $("#example").DataTable({});
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'reject';
            var id = data[0];
            var self = $(this);

            console.log(data);
            // alert( 'You clicked on '+data.id+'\'s row' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {id: id, st: st},
                url: "{{ route('international.intltravelHeadRejected') }}",
                success: function (resp) {
                    // console.log('rejection data =',resp);
                    if (resp.success) {
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        location.reload();
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function () {

                }
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