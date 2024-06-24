<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 11/27/2018
 * Time: 2:28 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Grade Wise Allownace')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .tx_font {
            font-size: 11px;
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
        .fixedHeader-floating {
            overflow: hidden;
        }

    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Grade Wise Allowance
                    <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive">
                        <!-- Image loader -->
                        <div id='loader' style='display: none; text-align: center'>
                            <img src='{{url('public/site_resource/images/preloader.gif')}}' width='32px' height='32px'>
                        </div>
                        <!-- Image loader -->
                        <table class="table table-bordered" id="lvs">
                            <thead>
                            <tr>
                                <th>SL#</th>
                                <th>GRADE</th>
                                <th>GRADE_NAME</th>
                                <th>LOCATION</th>
                                <th>ACCOMMODATION</th>
                                <th>MEALS</th>
                                <th>INCIDENTALS</th>
                                <th>DA</th>
                                <th>TRANSPORT</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grades as $key=>$value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->grade }}</td>
                                    <td>{{ $value->grade_name }}</td>
                                    <td>{{ $value->location }}</td>
                                    <td>{{ $value->accommodation }}</td>
                                    <td>{{ $value->meals }}</td>
                                    <td>{{ $value->incidentals }}</td>
                                    <td>{{ $value->da }}</td>
                                    <td>{{ $value->transport }}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="edit-grade" data-id="{{ $value->id }}"
                                           class="btn btn-info btn-xs">Edit</a>
                                        <a href="javascript:void(0)" id="delete-user" data-id="{{ $value->id }}"
                                           class="btn btn-danger btn-xs delete-user">Delete</a></td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Allowance</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form id="gradesForm" class="form-horizontal" role="form">
                                    <input type="hidden" name="grade_id" id="grade_id">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Grade</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="grade" id="grade" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Grade_Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="grade_name" id="grade_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Location</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="location" id="location" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Accommodation</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="accommodation" id="accommodation"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Meals</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="meals" id="meals" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Incidentals</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="incidentals" id="incidentals" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">DA</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="da" id="da" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Transport</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="transport" id="transport" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="button" class="btn btn-primary" id="btn-save">Save</button>
                                            <button type="button" class="btn btn-warning" id="btn-update">Update
                                            </button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="modal-footer">--}}
                {{--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{--                    <button type="button" class="btn btn-primary">Save</button>--}}
                {{--                </div>--}}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">

        $(document).ready(function () {

            $('#btn-update').hide();

            $('#lvs').DataTable({
                // scrollY: "300px",
                // fixedHeader: true,
                // scrollCollapse: true,
                paging: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-save"></i> Export',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        text: ' <i class="fa fa-plus"></i> New Allowance',
                        className: 'btn-success',
                        action: function (e, dt, node, config) {
                            $('#gradesForm').trigger("reset");
                            $("#myModal").modal("show");
                        }
                    }]
            });

        });

        $(function () {

            $('#btn-save').on('click', function (e) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');

                $.ajax({
                    type: "POST",
                    url: "{{ route('masterData.grades.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "form_data": $('#gradesForm').serialize(),
                    },
                    success: function (response) {
                        toastr.success(response.success);
                        $('#gradesForm').trigger("reset");
                        $('#myModal').modal('hide');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    },
                    error: function () {
                        alert('Error');
                    }
                });
                return false;
            });

            /* When click edit grade */
            $('body').on('click', '#edit-grade', function () {
                var grade_id = '';
                grade_id = $(this).data('id');
                $('#loader').show();
                $.get("{{ url('travel/masterData/grades')}}" + '/' + grade_id + '/edit', function (data) {
                    $('#loader').hide();
                    $('#btn-save').hide();
                    $('#btn-update').show();
                    $('#myModal').modal('show');
                    $('#grade_id').val(data.id);
                    $('#grade').val(data.grade);
                    $('#grade_name').val(data.grade_name);
                    $('#location').val(data.location);
                    $('#accommodation').val(data.accommodation);
                    $('#meals').val(data.meals);
                    $('#incidentals').val(data.incidentals);
                    $('#da').val(data.da);
                    $('#transport').val(data.transport);
                });
            });
            /* Update grade */
            $('#btn-update').on('click', function () {

                var id = parseInt($('#grade_id').val());
                var url = '{{route('masterData.grades.update')}}';

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                        grade_id: id,
                        "form_data": $('#gradesForm').serialize()
                    },
                    success: function (response) {
                        toastr.success(response.success);
                        $('#gradesForm').trigger("reset");
                        $('#myModal').modal('hide');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    },
                    error: function (e) {
                        console.log("Error :", e);
                    }
                });

            });

            /* delete grade  */
            $('body').on('click', '.delete-user', function () {
                var grade_id = $(this).data("id");
                swal({
                    title: "Delete?",
                    text: "Please ensure and then confirm!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function (e) {

                    if (e.value === true) {
                        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            type: 'DELETE',
                            url: "{{ route('masterData.grades')}}" + '/' + grade_id,
                            data: {"_token": "{{ csrf_token() }}"},
                            dataType: 'JSON',
                            success: function (results) {

                                if (results.success === true) {
                                    swal("Done!", results.message, "success");
                                    setTimeout(function () {
                                        location.reload();
                                    }, 500);
                                } else {
                                    swal("Error!", results.message, "error");
                                }
                            }
                        });
                    } else {
                        e.dismiss;
                    }

                }, function (dismiss) {
                    return false;
                })


            }); // end here
        });


    </script>

@endsection