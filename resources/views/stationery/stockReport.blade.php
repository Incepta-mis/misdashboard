@extends('_layout_shared._master')
@section('title','Opening Stock Report')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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
        .unit_div .select2-container{
            margin-bottom: 8px;
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
                            <div class="col-md-6">
                                <label class="text-default">
                                    Opening Stock Report
                                </label>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-success btn-sm" href="{{ url('stationery/form/openingStock') }}"
                                   target="_blank" style="float: right;">Insert Opening Stock Data</a>
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
                                            <label for="plant_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                @if($uid == 'CDMHO_1050' || $uid == 'CDMDB_7150')
                                                    <select id="plant_id" name="plant_id"
                                                            class="form-control input-sm filter-option pull-left">
                                                        <option value="" selected disabled>Select Plant</option>
                                                        <option value="All">All</option>
                                                        @foreach($allPlants as $plant)
                                                            <option value="{{$plant->plant_id}}">{{$plant->plant_name}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="text" class="form-control input-sm"
                                                           value="{{ $plantId }}" name="plant_id" id="plant_id"
                                                           disabled>
                                                @endif
                                            </div>
                                        </div>
                                        <input type="hidden" id="userID" value="{{$uid}}">
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
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="ist_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Subtype ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose an item subtype" name="ist_id"
                                                       id="ist_id" disabled>
                                            </div>
                                        </div>
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
                                    </div>
                                    <div class="form-group">
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
                            <table id="stock_report" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead style="background-color: darkkhaki;">
                                <tr>
                                    <th>Plant ID</th>
                                    <th>Main ID</th>
                                    <th>CWIP ID</th>
                                    <th>PO Number</th>
                                    <th>PR Number</th>
                                    <th>GL</th>
                                    <th>Cost Center</th>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Opening Quantity</th>
                                    <th>Unit</th>
                                    <th>Received Date</th>
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
    <div id="editThisDataModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Opening Stock Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_main_id" class="control-label col-sm-2" >Main ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_main_id" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_cwip_id" class="control-label col-sm-2">CWIP ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_cwip_id" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_po_number" class="control-label col-sm-2">PO Number:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_po_number" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_pr_number" class="control-label col-sm-2">PR Number:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_pr_number" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_gl" class="control-label col-sm-2">GL:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_gl" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_cost_center" class="control-label col-sm-2"><span style="color: red">*</span>Cost Center:</label>
                            <div class="col-sm-10">
                                <select id="edit_cost_center" name="edit_cost_center"
                                        class="form-control input-sm filter-option pull-left">
                                    <option value="" selected>Select a Cost center</option>
                                    @foreach($costCenter as $cc)
                                        <option value="{{$cc->cost_center_id}}">{{$cc->cost_center_id}} - {{$cc->cost_center_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Item ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_id" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_name" class="control-label col-sm-2">Item Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_name" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_opening_qty" class="control-label col-sm-2"><span style="color: red">*</span>Opening Quantity:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_opening_qty" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_unit" class="control-label col-sm-2"><span style="color: red">*</span>Unit:</label>
                            <div class="col-sm-10 unit_div">
                                <select id="edit_unit" name="edit_unit" class="form-control input-sm
                                                filter-option pull-left">
                                    <option value="" selected>Select a unit</option>
                                    <option value="custom">Other</option>
                                    @if(count($units) > 0)
                                        @foreach($units as $u)
                                            <option value="{{$u->unit}}">{{$u->unit}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" class="form-control input-sm"
                                       value="" placeholder="Input a unit"
                                       id="input_unit" style="display: none">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_received_date" class="control-label col-sm-2"><span style="color: red">*</span>Received Date:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_received_date" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_stock_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_stock_id" value="">
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            var date = new Date();

            $('#edit_received_date').datetimepicker({
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#edit_unit').select2();
            $('#it_name').select2();
            $('#ist_name').select2();
            $('#icat_name').select2();
            $('#item_name').select2();
            $('#edit_cost_center').select2();

            $('#edit_unit').change(function () {
                if($('#edit_unit').val() == 'custom'){
                    $('#input_unit').show();
                }else{
                    $('#input_unit').val('');
                    $('#input_unit').hide();
                }
            });

            if($('#userID').val() == 'CDMHO_1050' || $('#userID').val() == 'CDMDB_7150'){
                $('#plant_id').select2();
            }

            $('#it_name').change(function () {
                var it_id = $(this).val();
                $('#it_id').val(it_id);
            });
            $('#icat_name').change(function () {
                var icat_no = $(this).val();
                $('#icat_no').val(icat_no);
            });
            $('#item_name').change(function () {
                var item_id = $(this).val();
                $('#item_id').val(item_id);
            });
            $('#ist_name').change(function () {
                var ist_id = $(this).val();
                $('#ist_id').val(ist_id);
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

            $('#edit_main_id').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_cwip_id').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_po_number').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_pr_number').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_cost_center').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#input_unit').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#edit_stock_btn').on('click', function (e) {
                e.preventDefault();
                var stock_id = $('#edit_stock_id').val();
                var main_id = $('#edit_main_id').val();
                var cwip_id = $('#edit_cwip_id').val();
                var po_number = $('#edit_po_number').val();
                var pr_number = $('#edit_pr_number').val();
                var cost_center = $('#edit_cost_center').val();
                var opening_qty = $('#edit_opening_qty').val();

                if($('#edit_unit').val() == 'custom'){
                    var unit = $('#input_unit').val();
                }else{
                    var unit = $('#edit_unit').val();
                }

                var received_date = $('#edit_received_date').val();

                if(stock_id === "" || received_date === "" || cost_center === "" || opening_qty === "" || unit === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/report/updateStockReport') }}',
                        data: {
                            'stock_id':stock_id, 'main_id': main_id,'cwip_id': cwip_id,
                            'po_number': po_number, 'pr_number': pr_number,'rdate': received_date,'cost_center': cost_center,
                            'opening_qty':opening_qty, 'unit':unit, '_token': "{{ csrf_token() }}" },
                        success: function (data) {
                            $("#editThisDataModal").modal('hide');
                            if (data.response == 1 || data.response == true) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Stock information has been updated successfully',
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

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();
                var item_id = $('#item_id').val();
                var plant_id = $('#plant_id').val();

                if(item_id === "" || plant_id === ""){
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
                        url: '{{  url('stationery/report/getStockReport') }}',
                        data: { 'item_id':item_id, 'plant_id':plant_id, '_token': "{{ csrf_token() }}" },
                        success: function (data) {
                            $("#showTable").show();
                            $("#loader").hide();
                            $("#stock_report").DataTable().destroy();
                            table = $("#stock_report").DataTable({
                                dom: 'Bfrtip',
                                buttons: [],
                                data: data,
                                columns: [
                                    {data: "plant_id"},
                                    {data: "main_id"},
                                    {data: "cwip_id"},
                                    {data: "po_number"},
                                    {data: "pr_number"},
                                    {data: "gl"},
                                    {data: "cost_center"},
                                    {data: "item_id"},
                                    {data: "item_name"},
                                    {data: "opening_qty"},
                                    {data: "unit"},
                                    {data: "received_date"},
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
                                                'onclick="editThisReport('+"'"+row.id+"','"+row.main_id+"','"+row.cwip_id+"','"+row.po_number+"','"+row.pr_number+"','"+row.gl+"'," +
                                                "'"+row.cost_center+"','"+row.item_id+"','"+row.item_name+"','"+row.opening_qty+"','"+row.unit+"','"+row.received_date+"')"+'">EDIT</button>'
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                                'dt-center\" id="' + row.id +'" ' +
                                                'onclick="deleteThisReport('+"'"+row.id+"')"+'">Delete</button>'
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
                                                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                                                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
        });
        function editThisReport(id,main_id,cwip_id,po_number,pr_number,gl,cost_center,item_id,item_name,opening_qty,unit,received_date){
            $('#edit_main_id').val(main_id);
            $('#edit_cwip_id').val(cwip_id);
            $('#edit_po_number').val(po_number);
            $('#edit_pr_number').val(pr_number);
            $('#edit_gl').val(gl);
            $('#edit_cost_center').val(cost_center);
            $('#edit_cost_center').trigger("change");
            $('#edit_item_id').val(item_id);
            $('#edit_item_name').val(item_name);
            $('#edit_opening_qty').val(opening_qty);
            $('#edit_unit').val(unit);
            $('#edit_received_date').val(received_date);
            $('#edit_stock_id').val(id);
            $("#editThisDataModal").modal('show');
        }
        function deleteThisReport(id){
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
                        url: '{{  url('stationery/report/deleteStockData') }}',
                        data: { 'stock_id':id, '_token': "{{ csrf_token () }}"},
                        success: function (data) {
                            if(data.result == 1 || data.result == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Stock data has been deleted Successfully',
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