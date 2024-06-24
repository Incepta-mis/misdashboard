<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 11/27/2018
 * Time: 2:28 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Application Leave Status')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }
        .tx_font{
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


    </style>
@endsection
@section('right-content')
    <div class="row">
        @if($errors->any())
            @foreach($errors->all() as $error)
                {{ dd($error) }}
{{--                toastr.error('{{ $error }}','Error',{--}}
{{--                    closeButton:true,--}}
{{--                    progressBar: true,--}}
{{--                })--}}
            @endforeach
        @endif
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Grades Master Data
                    </label>
                </header>

                <div class="panel-body">
                    <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-user">Add Allowance</a>
                    <div class="table table-responsive">
                        <table class="display nowrap table table-striped table-bordered" style="width:100%"
                               id="laravel_crud">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Grade</th>
                                <th>Location</th>
                                {{--                                <th>Accommodation</th>--}}
                                {{--                                <th>Meals</th>--}}
                                {{--                                <th>Incidentals</th>--}}
                                {{--                                <th>DA</th>--}}
                                {{--                                <th>Transport</th>--}}
                                <td colspan="2">Action</td>
                            </tr>
                            </thead>
                            <tbody id="users-crud">
                            @foreach($grades as $grd_info)
                                <tr id="grade_id_{{ $grd_info->id }}">
                                    <td>{{ $grd_info->id  }}</td>
                                    <td>{{ $grd_info->grade }}</td>
                                    <td>{{ $grd_info->location }}</td>
                                    <td><a href="javascript:void(0)" id="edit-user" data-id="{{ $grd_info->id }}"
                                           class="btn btn-info">Edit</a></td>
                                    <td>
                                        <a href="javascript:void(0)" id="delete-user" data-id="{{ $grd_info->id }}"
                                           class="btn btn-danger delete-user">Delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $grades->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <form id="userForm" name="userForm" class="form-horizontal">
                        <input type="hidden" name="grade_id" id="grade_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Grade</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="grade" name="grade"
                                       placeholder="Enter Grade"
                                       value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Location</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="location" name="location"
                                       placeholder="Enter Email" value="" required="">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save" value="create">Save changes
                    </button>
                </div>
            </div>
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

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    {{--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>--}}

    <script type="text/javascript">

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /*  When user click add user button */
            $('#create-new-user').click(function () {
                $('#btn-save').val("create-user");
                $('#userForm').trigger("reset");
                $('#userCrudModal').html("Add New User");
                $('#ajax-crud-modal').modal('show');
            });

            /* When click edit user */
            $('body').on('click', '#edit-user', function () {
                var grade_id = $(this).data('id');
                $.get("{{ route('masterData.grades')}}" + grade_id + '/edit', function (data) {
                    $('#userCrudModal').html("Edit User");
                    $('#btn-save').val("edit-user");
                    $('#ajax-crud-modal').modal('show');
                    $('#grade_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                })
            });
            //delete user login
            $('body').on('click', '.delete-user', function () {
                var grade_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('masterData.grades')}}" + '/' + grade_id,
                    success: function (data) {
                        $("#grade_id_" + grade_id).remove();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });


        });


        $(document).on('click', '#btn-save', function () {
            console.log('btn-save');

            if ($("#userForm").length > 0) {

                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');


                var formData = $('#userForm').serialize();
                var _token = "{{ csrf_token() }}";

                $.ajax({
                    data: {'formData': formData, '_token': _token},
                    url: "{{  url('travel/masterData/store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        console.log(data);

                        var user = '<tr id="grade_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.grade + '</td><td>' + data.location + '</td>';
                        user += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + data.id + '" class="btn btn-info">Edit</a></td>';
                        user += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';


                        if (actionType == "create-user") {
                            $('#users-crud').prepend(user);
                        } else {
                            $("#grade_id_" + data.id).replaceWith(grade);
                        }

                        $('#userForm').trigger("reset");
                        $('#ajax-crud-modal').modal('hide');
                        $('#btn-save').html('Save Changes');

                    },
                    error: function (data) {
                         console.log('Error:', data);
                        // if( reject.status === 422 ) {
                        //     var errors = $.parseJSON(reject.responseText);
                        //     $.each(errors, function (key, val) {
                        //         toastr.error( val[0], 'Error', {timeOut: 2000});
                        //         // $("#" + key + "_error").text(val[0]);
                        //     });
                        // }

                        $('#btn-save').html('Save Changes');
                    }
                });
                // }
                // })
            }

        });


    </script>