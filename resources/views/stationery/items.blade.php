@extends('_layout_shared._master')
@section('title','Manage Items')
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
        #insert_itemBtn{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }
        #insert_itemBtn:hover{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
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
                            <div class="col-md-10">
                                <label class="text-default">
                                    Manage Items
                                </label>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-warning btn-sm" type="button" id="insert_itemBtn" style="float:
                                right;"><i class="fa fa-plus"></i> Add New Item</button>
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
                                                   style="padding-right:0px;"><b>Item Type</b></label>
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
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="icat_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Category Name</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="icat_name" name="icat_name"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select Category</option>
                                                    <option value="All">All</option>
                                                    @foreach($cats as $c)
                                                        <option value="{{$c->icat_no}}">{{$c->icat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="icat_no"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Category ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose a category" name="icat_no"
                                                       id="icat_no" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="item_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item Name</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="item_name" name="item_name"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select Item</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="item_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose an item" name="item_id"
                                                       id="item_id" disabled>
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
                            <table id="item_table" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead style="background-color: darkkhaki;">
                                <tr>
                                    <th>Type ID</th>
                                    <th>Type Name</th>
                                    <th>Subtype ID</th>
                                    <th>Subtype Name</th>
                                    <th>Category No</th>
                                    <th>Category Name</th>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
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
    <div id="createItemModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Item Insert</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="get">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_itype_name">Type Name:</label>
                            <div class="col-sm-10">
                                <select id="create_itype_name" name="create_itype_name"
                                        class="form-control input-sm filter-option pull-left">
                                    <option value="" selected disabled>Select type</option>
                                    <option value="All">All</option>
                                    @foreach($types as $c)
                                        <option value="{{$c->it_id}}">{{$c->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_itype_id">Type ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_itype_id"
                                       id="create_itype_id"  placeholder="Choose an item type" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_istName">Subtype Name:</label>
                            <div class="col-sm-10">
                                <select id="create_istName" name="create_istName"
                                        class="form-control input-sm filter-option pull-left">
                                    <option value="" selected disabled>Select subtype</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_istID">Subtype ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_istID"
                                       id="create_istID" value="" placeholder="Choose an item subtype" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_icatName">Category Name:</label>
                            <div class="col-sm-10">
                                <select id="create_icatName" name="create_icatName"
                                        class="form-control input-sm filter-option pull-left">
                                    <option value="" selected disabled>Select Category</option>
                                    <option value="All">All</option>
                                    @foreach($cats as $c)
                                        <option value="{{$c->icat_no}}">{{$c->icat_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_icatNo">Category No:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_icatNo"
                                       id="create_icatNo" value="" placeholder="Choose a Category" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="create_itemName">Item Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="create_itemName"
                                       id="create_itemName" value="">
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
                                <button type="submit" class="btn btn-info" id="Create_item_btn">Create</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editItemModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Item</h4>
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
                                <input type="text" class="form-control" id="edit_ist_id" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ist_name" class="control-label col-sm-2">Subtype Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_ist_name" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_icat_no" class="control-label col-sm-2">Category No</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_icat_no" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_icat_name" class="control-label col-sm-2">Category Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_icat_name" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Item ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_id" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_name" class="control-label col-sm-2">Item Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_gl" class="control-label col-sm-2">GL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_gl" value="">
                            </div>
                        </div>
                        <input type="hidden" id="edit_item_tbl_id" value="">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_item_btn">Save</button>
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
            $('#icat_name').select2();
            $('#item_name').select2();
              
            $('#create_itype_name').select2();
            $('#create_istName').select2();
            $('#create_icatName').select2();

            $('#it_name').change(function () {
                var it_id = $(this).val();
                $('#it_id').val(it_id);
            });
            $('#create_itype_name').change(function () {
                var it_id = $(this).val();
                $('#create_itype_id').val(it_id);
            });
            $('#create_istName').change(function () {
                var ist_id = $(this).val();
                $('#create_istID').val(ist_id);
            });
            $('#create_icatName').change(function () {
                var icat_id = $(this).val();
                $('#create_icatNo').val(icat_id);
            });

            $('#icat_name').change(function () {
                var icat_no = $(this).val();
                $('#icat_no').val(icat_no);
            });

            $('#edit_gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#edit_item_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#create_itemName').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#create_gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#item_name').change(function () {
                var item_id = $(this).val();
                $('#item_id').val(item_id);
            });

            $('#insert_itemBtn').on('click', function (e){
                $("#createItemModal").modal('show');
            });

            $('#icat_name').change(function () {
                var it_id = $('#it_id').val();
                var ist_id = $('#ist_id').val();
                var icat_no = $('#icat_no').val();

                $('#item_name').empty();
                $('#item_name').append($('<option></option>').html('Loading...'));

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/item/getItemNames') }}',
                    data: {'it_id': it_id, 'ist_id':ist_id, 'icat_no':icat_no, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        if(data.length > 0){
                            var op = '';
                            op += '<option value="" selected disabled>Select Item</option>';
                            op += '<option value="All">All</option>';
                            for (var i = 0; i < data.length; i++) {
                                op += '<option value="' + data[i]['item_id'] + '">' + data[i]['item_name'] +
                                    '</option>';
                            }
                            $('#item_name').html("");
                            $('#item_name').append(op);
                        }else{
                            $('#item_id').val("");
                            $('#item_name').html("");
                            $('#item_name').append('<option value="" selected disabled>No data found</option>');
                        }
                    },
                    error: function () {

                    }
                });
            });

            $('#create_itype_name').change(function () {
                $('#create_istName').empty();
                $('#create_istName').append($('<option></option>').html('Loading...'));

                var it_id = $('#create_itype_name').val();

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
                            $('#create_istName').html("");
                            $('#create_istName').append(op);
                        }else{
                            $('#create_istID').val("");
                            $('#create_istName').html("");
                            $('#create_istName').append('<option value="" selected disabled>No data found</option>');
                        }
                    },
                    error: function () {

                    }
                });
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
                            $('#ist_id').val("");
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

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();
                var it_id = $('#it_id').val();
                var ist_id = $('#ist_id').val();
                var icat_no = $('#icat_no').val();
                var item_id = $('#item_id').val();

                if(it_id === "" || ist_id === "" || icat_no === "" || item_id === ""){
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
                        url: '{{  url('stationery/item/getItemReport') }}',
                        data: {'it_id': it_id, 'ist_id':ist_id, 'icat_no':icat_no, 'item_id':item_id, '_token': "{{ csrf_token() }}"},
                        success: function (data) {
                            $("#showTable").show();
                            $("#loader").hide();
                            $("#item_table").DataTable().destroy();

                            table = $("#item_table").DataTable({
                                dom: 'Bfrtip',
                                buttons: [],
                                data: data,
                                columns: [
                                    {data: "it_id"},
                                    {data: "it_name"},
                                    {data: "ist_id"},
                                    {data: "ist_name"},
                                    {data: "icat_no"},
                                    {data: "icat_name"},
                                    {data: "item_id"},
                                    {data: "item_name"},
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
                                                'onclick="editThisRecord('+"'"+row.id+"','"+row.it_id+"','"+row.it_name+"','"+row.ist_id+"','"+row.ist_name+"','"+row.icat_no+"','"+row.icat_name+"','"+row.item_id+"','"+row.item_name+"','"+row.gl+"')"+'">EDIT</button>'
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
                                                    columns: [0, 1, 2, 3, 4,5,6,7,8]
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
                                                    columns: [0, 1, 2, 3, 4,5,6,7,8]
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

            $('#Create_item_btn').on('click', function (e) {
                e.preventDefault();
                var create_itype_id = $('#create_itype_id').val();
                var create_itype_name = $("#create_itype_name option:selected").text();
                var create_istID = $('#create_istID').val();
                var create_istName = $("#create_istName option:selected").text();
                var create_icatNo = $('#create_icatNo').val();
                var create_icatName = $("#create_icatName option:selected").text();
                var create_itemName = $('#create_itemName').val();
                var create_gl = $('#create_gl').val();

                if(create_itype_id === "" || create_itype_name === "" || create_istID === "" || create_istName === "" || create_icatNo === ""
                    || create_icatName === "" || create_itemName === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/item/createItem') }}',
                        data: {
                            'itype_id': create_itype_id, 'itype_name': create_itype_name,
                            'istID': create_istID,'istName': create_istName, 'icatNo': create_icatNo,
                            'icatName': create_icatName,'itemName': create_itemName,'gl':
                            create_gl, '_token': "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            $("#createItemModal").modal('hide');
                            if (data.response == 1 || data.response == true) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'New item has been inserted successfully',
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

            $('#edit_item_btn').on('click', function (e) {
                e.preventDefault();
                var edit_item_tbl_id = $('#edit_item_tbl_id').val();
                var edit_item_name = $('#edit_item_name').val();
                var edit_gl = $('#edit_gl').val();

                if(edit_item_tbl_id === "" || edit_item_name === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/item/editItemData') }}',
                        data: {'edit_item_tbl_id':edit_item_tbl_id, 'edit_item_name':edit_item_name,'edit_gl':edit_gl, '_token': "{{
                            csrf_token() }}"},
                        success: function (data) {
                            $("#editItemModal").modal('hide');
                            if(data.response == 1 || data.response == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item has been updated Successfully',
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
        });
        function editThisRecord(id, it_id, it_name, ist_id, ist_name, icat_no, icat_name, item_id, item_name, gl){
            $('#edit_it_ID').val(it_id);
            $('#edit_it_name').val(it_name);
            $('#edit_ist_id').val(ist_id);
            $('#edit_ist_name').val(ist_name);
            $('#edit_icat_no').val(icat_no);
            $('#edit_icat_name').val(icat_name);
            $('#edit_item_id').val(item_id);
            $('#edit_item_name').val(item_name);
            $('#edit_item_tbl_id').val(id);

            if(gl === "null"){
                $('#edit_gl').val("");
            }else{
                $('#edit_gl').val(gl);
            }
            $("#editItemModal").modal('show');
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
                        url: '{{  url('stationery/item/deleteItem') }}',
                        data: { 'id':id, '_token': "{{ csrf_token () }}"},
                        success: function (data) {
                            if(data.result == 1 || data.result == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item has been deleted Successfully',
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