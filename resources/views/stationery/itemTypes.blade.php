@extends('_layout_shared._master')
@section('title','Manage Item Types')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .swal2-icon.swal2-warning {
            font-size: 14px;
        }
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

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
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
        .odd{
            background-color: #FFF8FB !important;
        }
        .even{
            background-color: #DDEBF8 !important;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }
        #insert_typeBtn{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }
        #insert_subtypeBtn{
            color: #fff;
            background-color: #1d6182;
            border-color: #1d6182;
        }
        #insert_typeBtn:hover{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }
        #insert_subtypeBtn:hover{
            color: #fff;
            background-color: #1d6182;
            border-color: #1d6182;
        }
        .btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
            outline: none;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8">
                                <label class="text-default">
                                    Manage Item Types
                                </label>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-warning btn-sm" type="button" id="insert_typeBtn" style="float:
                                right;"><i class="fa
                                fa-plus"></i> Add New Item Type </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success btn-sm" type="button" id="insert_subtypeBtn"
                                        style="float: right;"><i class="fa
                                fa-plus"></i> Add New Item Subtype </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="it_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item type</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="it_name" name="it_name"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select type</option>
                                                    <option value="All">All</option>
                                                    @foreach($types as $c)
                                                        <option value="{{$c->it_id}}">{{$c->type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="it_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Type ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose an item type" name="it_id"
                                                       id="it_id" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="ist_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item Subtype</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="ist_name" name="ist_name"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select subtype</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-md-3 col-sm-3">
                                            <label for="ist_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Subtype ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose an item subtype" name="ist_id"
                                                       id="ist_id" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                            <button type="button" id="btn_submit" class="btn btn-warning btn-sm" style="float: right;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Display</b>
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                                            <div id="export_buttons" style="float: left">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
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
    </div>

    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="item_type_subtypes" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead style="background-color: darkkhaki;">
                                <tr>
                                    <th>Type ID</th>
                                    <th>Type Name</th>
                                    <th>Subtype ID</th>
                                    <th>Subtype Name</th>
                                    <th>GL</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Created by</th>
                                    <th>Updated by</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="createTypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Item Type Insert</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="get">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_itype_name"><span
                                        style="color: red;">*</span>Type
                                Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_itype_name" id="create_itype_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_istID"><span
                                        style="color: red;">*</span>Subtype ID:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control input-sm" name="create_istID"
                                       id="create_istID" value="" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_istName"><span
                                        style="color: red;">*</span>Subtype Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_istName" id="create_istName" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_gl">GL:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_gl" id="create_gl" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info" id="Create_type_btn">Create</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <div id="createSubTypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Item Subtype Insert</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="get">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_oitName">Type Name:</label>
                            <div class="col-sm-10">
                                <select id="create_oitName" name="create_oitName"
                                        class="form-control input-sm filter-option pull-left">
                                    <option value="" selected disabled>Select type</option>
                                    @foreach($types as $c)
                                        <option value="{{$c->it_id}}">{{$c->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_oitID">Type ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_oitID"
                                       id="create_oitID" value="" disabled placeholder="Choose a type">
                            </div>
                        </div>
                        <div class="form-group" id="create_oistID_div">
                            <label class="control-label col-sm-2" for="create_oistID"><span
                                        style="color: red;">*</span>Subtype ID:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control input-sm" name="create_oistID"
                                       id="create_oistID" value="" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_oistName"><span
                                        style="color: red;">*</span>Subtype Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_oistName" id="create_oistName" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_ogl">GL:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_ogl" id="create_ogl" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info" id="Create_subtype_btn">Create</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editTypeSubtypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Item Subtype</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_it_ID" class="control-label col-sm-2">Type ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_it_ID" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_it_name" class="control-label col-sm-2">Type Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_it_name" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ist_id" class="control-label col-sm-2">Subtype ID</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="edit_ist_id" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ist_name" class="control-label col-sm-2"><span
                                        style="color: red;">*</span>Subtype Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_ist_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_gl" class="control-label col-sm-2">GL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_gl" value="">
                            </div>
                        </div>
                        <input type="hidden" id="edit_subtype_tbl_id" value="">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_itype_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#it_name').select2();
            $('#ist_name').select2();
            $('#create_oitName').select2();

            $('#it_name').change(function () {
                var it_id = $(this).val();
                $('#it_id').val(it_id);
            });
            $('#create_oitName').change(function () {
                var it_id = $(this).val();
                $('#create_oitID').val(it_id);
                if($("#create_oitName option:selected").text() == "STATIONERY"){
                    $('#create_oistID_div').css('display','none');
                }else{
                    $('#create_oistID_div').css('display','block');
                }
            });
            $('#insert_typeBtn').on('click', function (e){
                $("#createTypeModal").modal('show');
            });
            $('#insert_subtypeBtn').on('click', function (e){
                $("#createSubTypeModal").modal('show');
            });
            $('#edit_ist_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#create_oistName').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#create_ogl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#create_oistID').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#create_itype_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#create_istID').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#create_istName').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#create_gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#it_name').change(function () {

                $('#ist_name').empty();
                $('#ist_name').append($('<option></option>').html('Loading...'));

                var it_id = $('#it_name').val();

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/item/getISTnames') }}',
                    data: {'it_id': it_id, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        if(data.length > 0){
                            var op = '';
                                op += '<option value="" selected disabled>Select subtype</option>';
                                op += '<option value="All">All</option>';
                            for (var i = 0; i < data.length; i++) {
                                op += '<option value="' + data[i]['ist_id'] + '">' + data[i]['ist_name'] +
                                    '</option>';
                            }
                            $('#ist_name').html("");
                            $('#ist_name').append(op);
                        }else{
                            $('#ist_name').html("");
                            $('#ist_name').append('<option value="" selected disabled>No data found</option>');
                        }
                    },
                    error: function () {
                    }
                });
            });
            $('#ist_name').change(function () {
                var ist_id = $(this).val();
                $('#ist_id').val(ist_id);
            });
            $('#edit_itype_btn').on('click', function (e) {
                e.preventDefault();
                var edit_it_ID = $('#edit_it_ID').val();
                var edit_ist_id = $('#edit_ist_id').val();
                var edit_ist_name = $('#edit_ist_name').val();
                var edit_gl = $('#edit_gl').val();
                var edit_it_name = $('#edit_it_name').val();
                var edit_row_ID = $('#edit_subtype_tbl_id').val();

                if(edit_it_ID === "" || edit_ist_id === "" || edit_ist_name === "" || edit_it_name === "" || edit_row_ID === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/item/editTypeSubtypeData') }}',
                        data: {'edit_it_ID':edit_it_ID, 'edit_ist_id':edit_ist_id,'edit_ist_name':edit_ist_name,
                            'edit_gl':edit_gl, 'edit_it_name':edit_it_name, 'row_ID':edit_row_ID, '_token': "{{
                            csrf_token() }}"},
                        success: function (data) {
                            $("#editTypeSubtypeModal").modal('hide');
                            if(data.response == 1 || data.response == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item subtype has been updated Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else if(data.response == 2){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Insufficient Input',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to Update',
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
            });
            $('#btn_submit').on('click', function (e) {
                // e.preventDefault();
                var it_id = $('#it_id').val();
                var ist_id = $('#ist_id').val();

                if(it_id === "" || ist_id === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $("#loader").show();
                    var table = null;

                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/item/getTypeSubtypeData') }}',
                        data: {'it_id':it_id, 'ist_id':ist_id, '_token': "{{ csrf_token() }}"},
                        success: function (data) {
                            $("#showTable").show();
                            $("#loader").hide();
                            $("#item_type_subtypes").DataTable().destroy();

                            table = $("#item_type_subtypes").DataTable({
                                dom: 'Bfrtip',
                                buttons: [],
                                data: data,
                                columns: [
                                    {data: "it_id"},
                                    {data: "it_name"},
                                    {data: "ist_id"},
                                    {data: "ist_name"},
                                    {data: "gl"},
                                    {data: "create_date"},
                                    {data: "update_date"},
                                    {data: "create_user"},
                                    {data: "update_user"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return '<button class=\"btn btn-sm btn-primary row-edit ' +
                                                'dt-center\" id="' + row.id +'" ' +
                                                'onclick="editThisRecord('+"'"+row.id+"','"+row.it_id+"','"+row.it_name+"','"+row.ist_id+"','"+row.ist_name+"','"+row.gl+"')"+'">EDIT</button>'
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                                'dt-center\" id="' + row.id +'" ' +
                                                'onclick="deleteThisRecord('+"'"+row.id+"')"+'">Delete</button>'
                                        }
                                    },
                                ],
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                info: true,
                                paging: false,
                                filter: true,

                                select: {
                                    style: 'os',
                                    selector: 'td:first-child'
                                }
                            });

                            table.fixedHeader.enable();

                            new $.fn.dataTable.Buttons(table, {
                                buttons: [
                                    {
                                        extend: 'collection',
                                        text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                        buttons: [
                                            {
                                                extend: 'excel',
                                                text: 'Save As Excel',
                                                footer: true,
                                                exportOptions: {
                                                    columns: [0, 1, 2, 3, 4]
                                                },
                                                action: function (e, dt, node, config) {
                                                    exportExtension = 'Excel';
                                                    $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                                }
                                            }, {
                                                extend: 'pdf',
                                                text: 'Save As PDF',
                                                orientation: 'landscape',
                                                footer: true,
                                                exportOptions: {
                                                    columns: [0, 1, 2, 3, 4]
                                                },
                                                customize : function(doc){
                                                    doc.content[1].table.widths =
                                                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                                },
                                                action: function (e, dt, node, config) {
                                                    exportExtension = 'PDF';
                                                    $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                                }
                                            }
                                        ],
                                        className: 'btn btn-sm btn-primary'
                                    }
                                ]
                            }).container().appendTo($('#export_buttons'));
                        },
                        error: function (e) {
                            console.log(e);
                            $("#loader").hide();
                            $("#showTable").show();
                        }
                    });
                }
            });
            $('#Create_subtype_btn').on('click', function (e) {
                e.preventDefault();
                var create_oitID = $('#create_oitID').val();
                var create_oitName = $("#create_oitName option:selected").text();
                var create_oistID = $('#create_oistID').val();
                var create_oistName = $('#create_oistName').val();
                var create_ogl = $('#create_ogl').val();

                if(create_oitID === "" || create_oitName === "" || create_oistName === "" || create_ogl === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/item/createISubtype') }}',
                        data: {
                            'create_oitID': create_oitID, 'create_oitName': create_oitName,
                            'create_oistID': create_oistID,'create_oistName': create_oistName, 'create_ogl': create_ogl, '_token': "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            $("#createSubTypeModal").modal('hide');
                            if (data.response == 1 || data.response == true) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'New item subtype has been inserted successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Data was not saved.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#Create_type_btn').on('click', function (e) {
                e.preventDefault();
                var create_itype_name = $('#create_itype_name').val();
                var create_istID = $('#create_istID').val();
                var create_istName = $('#create_istName').val();
                var create_gl = $('#create_gl').val();
                if(create_itype_name === "" || create_istID === "" || create_istName === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/item/createItype') }}',
                        data: {
                            'itype_name': create_itype_name, 'create_istID': create_istID,
                            'create_istName': create_istName, 'create_gl': create_gl, '_token':
                                "{{ csrf_token()
                        }}"
                        },
                        success: function (data) {
                            $("#createTypeModal").modal('hide');
                            if (data.response == 1 || data.response == true) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'New item type has been inserted successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Data was not saved.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
        });
        function editThisRecord(id, it_id, it_name, ist_id, ist_name, gl){
            $('#edit_it_ID').val(it_id);
            $('#edit_it_name').val(it_name);
            $('#edit_subtype_tbl_id').val(id);
            if(it_name === "CAPEX"){
                $('#edit_ist_id').removeAttr("disabled");
            }else{
                $('#edit_ist_id').attr("disabled","disabled");
            }
            $('#edit_ist_id').val(ist_id);
            $('#edit_ist_name').val(ist_name);
            if(gl === "null"){
                $('#edit_gl').val("");
            }else{
                $('#edit_gl').val(gl);
            }
            $("#editTypeSubtypeModal").modal('show');
        }
        function deleteThisRecord(id){
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
                        url: '{{  url('stationery/item/deleteItypeSubtype') }}',
                        data: { 'id':id, '_token': "{{ csrf_token () }}"},
                        success: function (data) {
                            if(data.result == 1 || data.result == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item subtype has been deleted Successfully',
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
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection