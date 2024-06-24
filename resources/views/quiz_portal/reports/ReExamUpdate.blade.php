<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 5/2/2019
 * Time: 11:39 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Re-Exam' )
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
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

        @media print {
            .header-print {
                display: table-header-group;
            }
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Re-Exam Approved
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label input-sm">Group Name: </label>
                                        <div class="col-md-6 col-sm-6">
                                            <select name="grp_id" id="grp_id"
                                                    class="form-control input-sm m-bot15 gr_id">
                                                <option value="">Select Group</option>
                                                <option value="All">All</option>
                                                @foreach($grp_info as $ei)
                                                    <option value="{{$ei->group_id}}">{{$ei->group_id}} - {{$ei->group_name}}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <div id="export_buttons">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>

    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                <div id="export_buttons">

                </div>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>GROUP_ID</th>
                                    <th>GROUP_NAME</th>
                                    <th>EMP_ID</th>
                                    <th>EMP_NAME</th>
                                    <th>TERR_ID</th>
                                    <th>TERR_GROUP</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{Html::script('public/site_resource/js/bootstrap-lightbox.min.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>--}}
    {{--    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}--}}
    {{Html::script('public/site_resource/updatedatatablesJS/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{--<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>--}}
    {{--    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}--}}
    {{Html::script('public/site_resource/updatedatatablesJS/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}


    {{Html::script('public/site_resource/updatedatatablesJS/jszip.min.js')}}
    {{Html::script('public/site_resource/updatedatatablesJS/pdfmake.min.js')}}
    {{Html::script('public/site_resource/updatedatatablesJS/vfs_fonts.js')}}

    {{Html::script('public/site_resource/updatedatatablesJS/buttons.html5.min.js')}}


    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">



        $('.gr_id').select2();

        $("#btn_display").click(function () {

            $("#loader").show();
            let gr_id = $('#grp_id').val();
            let data = {grp_id: gr_id, "_token": "{{ csrf_token() }}"};
            let grp_id = '';
            let emp_id = '';

            // var today = new Date();
            // var dd = String(today.getDate()).padStart(2, '0');
            // var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            // var yyyy = today.getFullYear();
            //
            // today =dd + '/' + mm + '/' + yyyy;


            let table;
            $.ajax({
                type: "post",
                dataType: 'json',
                data: data,
                url: "{{ url('quiz/getReExamEmpInfo') }}",
                success: function (resp) {
                    console.log("Success Data : ", resp);
                    // console.log("Success Data : ", resp[0]['create_date']);
                    $("#loader").hide();
                    $("#report-body").show();


                    $("#blk_list").DataTable().destroy();

                    table = $('#blk_list').DataTable( {
                        data: resp,
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel'

                            }
                        ],
                        columns: [
                            {data: "group_id",className:"grpId"},
                            {data: "group_name" },
                            {data: "emp_id",className:"empId"},
                            {data: "emp_name"},
                            {data: "terr_id"},
                            {data: "terr_group"},
                            {mRender: function (data, type, row) {
                                // return '<button class="btn-delete" type="button">Active</button>'
                                return '<button class="btn btn-danger btn-sm upBtnEmp"> <i class="fa fa-thumbs-up "></i> Active </button>'
                            }}
                        ],

                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: true,
                        paging: false,
                        filter: true

                    } );

                    $('.upBtnEmp').on('click',function () {
                         grp_id = $(this).closest("tr").find(".grpId").text();
                         emp_id = $(this).closest("tr").find(".empId").text();
                        console.log(grp_id);
                        console.log(emp_id);


                        if($(this).hasClass("btn btn-danger btn-sm upBtnEmp"))
                            $(this).closest("tr").find(".upBtnEmp").removeClass("btn btn-danger btn-sm upBtnEmp").addClass("btn btn-success btn-sm");
                        $(this).addClass("btn btn-success btn-sm");







                        $.ajax({
                                    type: "post",
                                    dataType: 'json',
                                    data: {grp_id : grp_id,emp_id: emp_id, "_token": "{{ csrf_token() }}" },
                                    url: "{{ url('quiz/updateReExamEmployee') }}",
                                    success: function (resp) {
                                        console.log(resp.success);
                                    },
                                    error:function (e) {
                                        console.log("Error = ",e);
                                    }
                                });




                    });


                },
                error: function (err) {
                    // console.log(err);
                    $("#loader").hide();
                    $("#report-body").show();
                }
            });






        });
    </script>

@endsection

