@extends('_layout_shared._master')
@section('title','Transfer Items')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>
        .swal2-icon.swal2-warning {
            font-size: 14px;
        }

        .swal2-html-container{
            font-size: 1.5em !important;
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

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove orangered !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: center !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: orangered;
        }
        .cls-req{
            color: red;
            font-weight: bold;
        }


    </style>
@endsection
@section('right-content')

    {{--select cwip id and show details--}}
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" >
                <header class="panel-heading">
                    <label class="text-primary">
                        Show Transfered Item
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12 col-sm-12">
                                <form action="" class="form-horizontal" role="form" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="cmp"
                                                       class="col-md-3 col-sm-3 control-label"><b>IR No.:</b></label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select id="display_transfered_items" class="form-control">

                                                    </select>
                                                    <input type="hidden" id="plant_id" value="{{$plant_id}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <div class="col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="display_ir_datatable" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-check"></i> <b>Material Details</b></button>
                                                </div>
                                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                    <div id="export_buttons">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    {{--Loader--}}
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

    {{--Modal for datatable--}}
    <div id="editItemDisplayModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Transfered Item</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Item Id:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_id" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_item_name" class="control-label col-sm-2">Item Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_name" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_cwip_id" class="control-label col-sm-2">CWIP ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_cwip_id" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_main_id" class="control-label col-sm-2">MAIN ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_main_id" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_po" class="control-label col-sm-2">PO Number:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_po" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_pr" class="control-label col-sm-2">PR Number:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_pr" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_gl" class="control-label col-sm-2">GL:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_gl" value="" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_cc" class="control-label col-sm-2">Cost Center:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_cc" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_transfer_reason" class="control-label col-sm-2">Transfer Reason:</label>
                            <div class="col-sm-10">
                                <select class="form-control input-xs" name="edit_transfer_reason" id="edit_transfer_reason">
                                    <option value="REPAIR">REPAIR</option>
                                    <option value="DAMAGED">DAMAGED</option>
                                    <option value="DESTRUCTION">DESTRUCTION</option>
                                    <option value="SALES">SALES</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_pr_qty" class="control-label col-sm-2">Product Qty<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_pr_qty" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_unit" class="control-label col-sm-2">Unit<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_unit" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_remarks" class="control-label col-sm-2">Remarks</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_remarks" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="update_transfer_item">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel panel-primary" >
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="text-default">
                                        Transferred Items
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%;">
                                <thead style="background-color: #3CB371">
                                    <tr style="color: white">
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>CWIP ID</th>
                                        <th>MAIN ID</th>
                                        <th>PO Number</th>
                                        <th>PR Number</th>
                                        <th>GL</th>
                                        <th>Cost Center</th>
                                        <th>Transfer Reason</th>
                                        <th>Product Qty</th>
                                        <th>Unit</th>
                                        <th>Remarks</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody ></tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label class="text-default">
                                    Transfer Items
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <p style="color: red;">** This section is only for those who want to transfer a item which
                                        he/she has
                                        received from
                                        another plant.</p>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6" style="padding-bottom: 12px;">
                                            <label for="itr_no" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item Transfer Receive no</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="itr_no" name="itr_no" class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select Item Transfer
                                                        Receive no</option>
                                                    @foreach ( $transItems as $val )
                                                        <option value="{{$val->itr_no}}">{{$val->itr_no}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" id="it_no" value="">
                                        <div class="col-md-6 col-sm-6">
                                            <button type="button" id="btn_submit1" class="btn btn-warning btn-sm"
                                                    style="float: left;margin-left: 14px;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Display</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12" id="showTable" style="display: none;">
                                    <section class="panel panel-success" id="data_table">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <label class="text-default">
                                                            Pending to be transferred
                                                        </label>
                                                        <input type="hidden" id = 'row_ids' value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-12 col-sm-12 table-responsive">
                                                <table width="100%" class="table table-bordered table-condensed
                            table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Item ID</th>
                                                        <th>Item Name</th>
                                                        <th>Item Type</th>
                                                        <th>CWIP ID</th>
                                                        <th>Main ID</th>
                                                        <th>PO Number</th>
                                                        <th>PR Number</th>
                                                        <th>GL</th>
                                                        <th>Cost Center</th>
                                                        <th>Transfer Reason</th>
                                                        <th>Item Status</th>
                                                        <th>Qty</th>
                                                        <th>Unit</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
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
                        </form>
                    </div>
                </div>
                <hr>
                <div class="panel-body" style="padding-top: 2%">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="color: red;">** This section is only for those who want to transfer
                                a item to another plant for the first time.</p>
                            <div class="form-group">
                                <div class="col-md-4 col-sm-4">
                                    <label for="transfer_to"
                                           class="col-md-4 col-sm-4 control-label fnt_size"
                                           style="padding-right:0px;"><b>Transfer to</b></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select id="transfer_to" name="transfer_to"
                                                class="form-control input-sm ">
                                            <option value="0" selected >Select Plant ID</option>
                                            @if($plants)
                                                @foreach($plants as $plant)
                                                    <option value="{{$plant->plant_id}}"
                                                    >{{$plant->plant_id}} - {{ $plant->plant_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <form action="#" method="post" id="item_issue_form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Item Name<span class='cls-req'>*</span></th>
                                            <th class="text-center">Item ID<span class='cls-req'>*</span></th>
                                            <th class="text-center">CWIP ID</th>
                                            <th class="text-center">MAIN ID</th>
                                            <th class="text-center">PO Number</th>
                                            <th class="text-center">PR Number</th>
                                            <th class="text-center">GL</th>
                                            <th class="text-center">Cost Center</th>
                                            <th class="text-center">Transfer Reason</th>
                                            <th class="text-center">PR Quantity<span class='cls-req'>*</span></th>
                                            <th class="text-center">Unit<span class='cls-req'>*</span></th>
                                            <th class="text-center">Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        <tr>
                                            <td>
                                                <select id="item_name" name="item_name"
                                                        class="form-control input-sm ">
                                                    <option value="" selected >Select Item Name</option>

                                                    @if($item_name)
                                                        @foreach($item_name as $name)
                                                            <option value="{{$name->gl}}/{{ $name->item_id}}"  >{{$name->item_name}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="item_id"
                                                       placeholder="Choose a Item" name="item_id" readonly>
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="cwip_id"
                                                       placeholder="" name="cwip_id">
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="main_id"
                                                       placeholder="" name="main_id">
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="po"
                                                       placeholder="" name="po">
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="pr"
                                                       placeholder="" name="pr">
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="item_gl"
                                                       placeholder="" name="item_gl">
                                            </td>
                                            <td>
                                                <select id="cc" name="cc"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="0" selected>Select a Cost center</option>
                                                    @foreach($costCenter as $cc)
                                                        <option value="{{$cc->cost_center_id}}">{{$cc->cost_center_id}} - {{$cc->cost_center_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control input-xs" name="transfer_reason" id="transfer_reason">
                                                    <option value="REPAIR">REPAIR</option>
                                                    <option value="DAMAGED">DAMAGED</option>
                                                    <option value="DESTRUCTION">DESTRUCTION</option>
                                                    <option value="SALES">SALES</option>
                                                </select>
                                            </td>
                                            <td id="pr_qty_div">
                                                <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="pr_qty"
                                                       placeholder="" name="pr_qty" min="1" >
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="unit"
                                                       placeholder="" name="unit" >
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="remarks"
                                                       placeholder="" name="remarks" >
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="button" class="add-row btn btn-info" value="Add to List">
                        <input type="hidden" id="uid" value="{{$uid}}">
                    </form>
                </div>
                <div class="panel-body" style="margin-top:20px;display: none;" id="display_data">
                    <form action="#" method="post" id="issue_item_form">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="issueTable">
                                <thead>
                                <tr>
                                    <th class="text-center">Select Item</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Item ID</th>
                                    <th class="text-center">CWIP ID</th>
                                    <th class="text-center">MAIN ID</th>
                                    <th class="text-center">PO Number</th>
                                    <th class="text-center">PR Number</th>
                                    <th class="text-center">GL</th>
                                    <th class="text-center">Cost Center</th>
                                    <th class="text-center">Transfer Reason</th>
                                    <th class="text-center">PR Quantity</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Remarks</th>
                                </tr>
                                </thead>
                                <tbody id="tbody" style="text-align:center">
                                </tbody>
                            </table>
                            <button type="button" class="delete-row btn btn-danger" style="display:none" id="delete_button">Delete Item</button>
                            <button type="button"  class="btn btn-info" style="display:none" id="submit_button">Submit</button>
                        </div>
                    </form>
                </div>
            </section>
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
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#itr_no').select2();
            $('#cc').select2();
            $('#item_name').select2();
            $('#transfer_to').select2();


            /*Display my transfered item select two*/
            $('#display_transfered_items').select2({
                placeholder: 'Select IT No.',
                ajax: {
                    url: '{{  url('stationery/form/transferItem/getMyTransferedItem') }}',
                    method:'get',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.it_no,
                                    id: item.it_no
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            /* Display datatable after button click*/
            $('#display_ir_datatable').on('click', function (e) {

                $("#loader").show();
                $("#report-body").show();

                var it_no = $('#display_transfered_items').select2("val");
                data = { it_no:it_no,"_token": "{{ csrf_token() }}"};
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('stationery/form/transferItem/displayTransferedData') }}",
                    success: function (resp) {

                        $("#loader").hide();
                        $("#report-body").show();

                        $("#blk_list").DataTable().destroy();

                        table = $("#blk_list").DataTable({
                            data: resp.transferedData,
                            autoWidth: true,
                            columns: [
                                {data: "item_id"},
                                {data: "item_name"},
                                {data: "cwip_id"},
                                {data: "main_id"},
                                {data: "po_number"},
                                {data: "pr_number"},
                                {data: "gl"},
                                {data: "cost_center"},
                                {data: "transfer_reason"},
                                {data: "qty"},
                                {data: "unit"},
                                {data: "remarks"},
                                { data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        if(row.receive_date == null){
                                            return '<button class=\"btn btn-sm btn-info row-edit ' +
                                                'dt-center\" id="' + row.id + '" ' +
                                                'onclick="editThisRecord(' + "'" + row.id + "','" + row.item_id + "','" +
                                                row.item_name + "','" + row.cwip_id + "','" + row.main_id + "','" + row
                                                    .po_number + "','" + row.pr_number + "','" + row.gl + "','" + row
                                                    .cost_center + "','" + row.transfer_reason + "','" + row.qty + "','" + row.unit + "','" + row.remarks + "')" + '">EDIT</button>'
                                        }else{
                                            return '<button class=\"btn btn-sm btn-info row-edit ' +
                                                'dt-center\" ' + '" disabled>EDIT</button>'
                                        }
                                    }
                                },
                                { data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {

                                        if(row.receive_date == null){
                                            return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                                'dt-center\" id="' + row.id +'" ' +
                                                'onclick="deleteThisRecord('+"'"+row.id+"','"+row.it_no+"')"+'">Delete</button>'
                                        }else{
                                            return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                                'dt-center\" '+'" disabled>Delete</button>'
                                        }
                                    }
                                }
                            ],
                            columnDefs: [
                                {
                                    "defaultContent": " ",
                                    "targets": "_all"
                                }
                            ],
                            scrollCollapse: true,
                            info: true,
                        });

                        // table.fixedHeader.enable();
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
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }, {
                                            extend: 'pdf',
                                            text: 'Save As PDF',
                                            orientation: 'landscape',
                                            footer: true,
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
                    error: function (err) {
                        console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });
            });

            /*Update transffered data*/
            $("#update_transfer_item").on('click',function (){

                var edit_item_id = $("#edit_item_id").val();
                var edit_item_name = $("#edit_item_name").val();
                var edit_cwip_id = $("#edit_cwip_id").val();
                var edit_main_id = $("#edit_main_id").val();
                var edit_po = $("#edit_po").val();
                var edit_pr = $("#edit_pr").val();
                var edit_gl = $("#edit_gl").val();
                var edit_cc = $("#edit_cc").val();
                var edit_transfer_reason = $("#edit_transfer_reason").val();
                var edit_pr_qty = $("#edit_pr_qty").val();
                var edit_unit = $("#edit_unit").val();
                var edit_remarks = $("#edit_remarks").val();
                var table_id  = $("#table_id").val();

                var itemArray = {};

                itemArray.edit_item_id=edit_item_id;
                itemArray.edit_item_name=edit_item_name;
                itemArray.edit_cwip_id=edit_cwip_id;
                itemArray.edit_main_id=edit_main_id;
                itemArray.edit_po=edit_po;
                itemArray.edit_pr=edit_pr;
                itemArray.edit_gl=edit_gl;
                itemArray.edit_cc=edit_cc;
                itemArray.edit_transfer_reason=edit_transfer_reason;
                itemArray.edit_pr_qty=edit_pr_qty;
                itemArray.edit_unit=edit_unit;
                itemArray.edit_remarks=edit_remarks;

                var itemArrayData = JSON.stringify(itemArray);

                if(!edit_item_id||!edit_item_name||!edit_unit||!edit_pr_qty){
                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please Input Required Field!',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/transferItem/updateTransferedItem') }}',
                        data: { 'id':table_id, 'itemArray':itemArrayData, '_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if(data.result == 1 || data.result == "success"){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item has been updated Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#editItemDisplayModal").modal('hide');
                                        window.location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#editItemDisplayModal").modal('hide');
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

            /* Onselect Item Name*/
            $('#item_name').change(function () {
                var item_id_gl = $(this).val();
                /*split string*/
                var arrVars = item_id_gl.split("/");
                var item_id = arrVars.pop();
                $('#item_id').val(item_id);
                $('#item_id').attr('readonly', true);

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/transferItem/getStockQty') }}',
                    data: {
                        'item_id' :item_id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if(response.status == 1){
                            $('#pr_qty').attr('max', response.qty);
                            $('#pr_qty_div p').remove();
                            $('#pr_qty_div').append("<p style='text-align: center;color: #a54c48; " +
                                "font-weight: " +
                                "600;" +
                                "'>Available quantity:" +
                                " "+response
                                    .qty+"</p>");
                        }else{
                            $('#pr_qty').removeAttr("max");
                            $('#pr_qty_div p').remove();
                            $('#pr_qty_div').append("<p style='text-align: center;color: red; " +
                                "font-weight: " +
                                "600;" +"'>Stock is empty</p>");
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
            $('#itr_no').change(function () {
                var itr_no = $(this).val();
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/transferItem/getIt_no') }}',
                    data: {
                        'itr_no': itr_no,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#it_no').val(response[0]['it_no']);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            /*Add row on button click*/
            $(".add-row").click(function(){
                var item_name = $("#item_name option:selected").text();
                var item_id = $("#item_id").val();
                var cwip_id = $("#cwip_id").val();
                var main_id = $("#main_id").val();
                var po = $("#po").val();
                var pr = $("#pr").val();
                var item_gl = $("#item_gl").val();
                var cc = $("#cc").val();
                var pr_qty = $("#pr_qty").val();
                var unit = $("#unit").val();
                var remarks = $("#remarks").val();
                var transfer_reason = $("#transfer_reason").val();

                if(item_name == 'Select Item Name' || pr_qty == '' || unit == ''){
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please fill up all required fields!',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                }

                var markup = "<tr><td><input type='checkbox' name='record' " +
                    "id='record'></td><td>"+item_name+"</td><td>"+item_id+"</td><td>"+cwip_id+"</td><td>"+main_id
                    +"</td><td>"+po+"</td><td>"+pr+"</td><td>"+item_gl+"</td><td>"+cc
                    +"</td><td>"+transfer_reason+"</td><td>"+pr_qty+"</td><td>"+unit+"</td><td>"+remarks+"</td></tr>";

                var delete_button ="<input type='button' value='Delete'>"

                $("#display_data").show();
                $("#display_data table tbody").append(markup);
                $("#delete_button").css("display","inline-block");
                $("#submit_button").css("display","inline-block");


                $("#cc").select2().val(0).trigger("change");
                $("#item_issue_form").trigger('reset');
                $("#item_name").select2().val(0).trigger("change");

                $("#pr_qty_div p").remove();
                $("#pr_qty").removeAttr('max');

            });

            // Find and remove selected table rows
            $(".delete-row").click(function(){
                count =0
                $("table tbody").find('input[name="record"]').each(function(){
                    if($(this).is(":checked")){
                        count++;
                    }
                });
                if(count!=''){
                    $("table tbody").find('input[name="record"]').each(function(){
                        if($(this).is(":checked")){
                            $(this).parents("tr").remove();
                        }
                    });
                    if($("#display_data table tbody").find('input[name="record"]').length == 0){
                        $('#display_data').hide();
                    }
                }else{
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please select an item',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                }
            });

            // Find and remove selected table rows
            $("#submit_button").click(function(){
                var itemArray = [];
                var transfer_to = $('#transfer_to').val();
                $("#issueTable tbody tr").each(function () {
                    var transferItemData = {};

                    var self = $(this);

                    var item_name = self.find("td:eq(1)").text().trim();
                    var item_id = self.find("td:eq(2)").text().trim();
                    var cwip_id = self.find("td:eq(3)").text().trim();
                    var main_id = self.find("td:eq(4)").text().trim();
                    var po = self.find("td:eq(5)").text().trim();
                    var pr = self.find("td:eq(6)").text().trim();
                    var item_gl = self.find("td:eq(7)").text().trim();
                    var cc = self.find("td:eq(8)").text().trim();
                    var transfer_reason = self.find("td:eq(9)").text().trim();
                    var pr_quantity = self.find("td:eq(10)").text().trim();
                    var unit = self.find("td:eq(11)").text().trim();
                    var remarks = self.find("td:eq(12)").text().trim();

                    transferItemData.item_name = item_name;
                    transferItemData.item_id = item_id;
                    transferItemData.cwip_id = cwip_id;
                    transferItemData.main_id = main_id;
                    transferItemData.po_number = po;
                    transferItemData.pr_number = pr;
                    transferItemData.gl = item_gl;
                    transferItemData.cost_center = cc;
                    transferItemData.transfer_reason = transfer_reason;
                    transferItemData.qty = pr_quantity;
                    transferItemData.unit = unit;
                    transferItemData.remarks = remarks;

                    itemArray.push(transferItemData);

                });
                var itemData = JSON.stringify(itemArray);

                if(transfer_to == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose a plant!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/transferItem/itemTransferSubmit') }}',
                        data: {
                            'transfer_to' :transfer_to,
                            'transferItemData': itemData,
                            '_token': "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if ( response == 1 || response == 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item transfer request has been submitted successfully',
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
                                    text: 'Something was wrong! Item transfer request failed.',
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

            $('#btn_submit1').on('click', function (e) {
                e.preventDefault();

                var itr_no = $('#itr_no').val();
                var it_no = $('#it_no').val();

                if(itr_no === null){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Choose a Transfer Receive Number!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/transferItem/getRecvedItemDetails') }}',
                        data: { 'itr_no':itr_no, '_token': "{{ csrf_token() }}" },
                        success: function (data) {
                            console.log(data);

                            var mData = data.itemDetails;
                            var html = '';
                            var ids = [];

                            if(mData.length > 0){
                                for (var i = 0; i < mData.length; i++){

                                    ids.push(mData[i]['id']);

                                    html += '<tr>';
                                    html += '<td id="item_id_'+mData[i]['id']+'">'+mData[i]['item_id']+'</td>';
                                    html += '<td id="item_name_'+mData[i]['id']+'">'+mData[i]['item_name']+'</td>';
                                    html += '<td id="it_name_'+mData[i]['id']+'">'+mData[i]['it_name']+'</td>';

                                    html += '<td><input class="form-control" type="text" id="cwip_'+mData[i]['id']+'"' +
                                        ' ' + 'name="cwip_'+mData[i]['id']+'" value="'+mData[i]['cwip_id']+'" ' +
                                        'style="width: 70px" onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" type="text" id="main_'+mData[i]['id']+'"' +
                                        ' ' + 'name="main_'+mData[i]['id']+'" value="'+mData[i]['main_id']+'" ' +
                                        'style="width: 70px" onkeyup="this.value = this.value.toUpperCase();"></td>';

                                    html += '<td><input class="form-control" type="text" id="po_'+mData[i]['id']+'" ' +
                                        'name="po_'+mData[i]['id']+'" value="'+mData[i]['po_number']+'" style="width:' +
                                        ' 70px" onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" type="text" id="pr_'+mData[i]['id']+'" ' +
                                        'name="pr_'+mData[i]['id']+'" value="'+mData[i]['pr_number']+'" style="width:' +
                                        ' 70px" onkeyup="this.value = this.value.toUpperCase();"></td>';

                                    html += '<td><input class="form-control" type="text" id="gl_'+mData[i]['id']+'" ' +
                                        'name="gl_'+mData[i]['id']+'" value="'+mData[i]['gl']+'" style="width: ' +
                                        '70px" onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" type="text" id="cc_'+mData[i]['id']+'" ' +
                                        'name="cc_'+mData[i]['id']+'" value="'+mData[i]['cost_center']+'" ' +
                                        'style="width: 70px" onkeyup="this.value = this.value.toUpperCase();" ' +
                                        'disabled></td>';

                                    html += '<td>'+mData[i]['transfer_reason']+'</td>';

                                    html += '<td>' +
                                        '<select class="form-control input-xs" name="tr_'+mData[i]['id']+'" id="tr_'+mData[i]['id']+'">' +
                                        '<option value="REPAIRED">REPAIRED</option>'+
                                        '<option value="DAMAGED">DAMAGED</option>'+
                                        '<option value="DESTRUCTED">DESTRUCTED</option>'+
                                        '<option value="SALES">SALES</option>'+
                                        '</select> </td>';

                                    if(mData[i]['qty'] === null){
                                        html += '<td id="qty_'+mData[i]['id']+'"></td>';
                                    }else{
                                        html += '<td id="qty_'+mData[i]['id']+'">'+mData[i]['qty']+'</td>';
                                    }

                                    if(mData[i]['unit'] === null){
                                        html += '<td id="unit_'+mData[i]['id']+'"></td>';
                                    }else{
                                        html += '<td id="unit_'+mData[i]['id']+'">'+mData[i]['unit']+'</td>';
                                    }

                                    if(mData[i]['remarks'] === null){
                                        html += '<td id="remarks_'+mData[i]['id']+'"></td>';
                                    }else{
                                        html += '<td id="remarks_'+mData[i]['id']+'">'+mData[i]['remarks']+'</td>';
                                    }

                                    html += '<td><button type="button" class="btn btn-success" ' +
                                        'onclick="transferThis('+"'"+mData[i]['id']+"'"+')">Transfer</button></td>';

                                    html += '</tr>';
                                }

                                $('#data_table tbody').html(html);

                                var rowIds = JSON.stringify(ids);
                                $('#data_table #row_ids').val(rowIds);

                            }else{
                                $('#data_table tbody').html('<tr><td colspan="16" style="text-align: center; color: ' +
                                    'red; padding: 7px 0px;">There is no data to display!</td></tr>');
                                $('#data_table #row_ids').val("");
                            }

                            $('#showTable').show();
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
        });
        function transferThis(id){

            var itr_no = $('#itr_no').val();
            var it_no = $('#it_no').val();
            var finalARr = [];

            var it_name = $('#it_name_'+id)[0].innerHTML;
            var item_id = $('#item_id_'+id)[0].innerHTML;
            var item_name = $('#item_name_'+id)[0].innerHTML;
            var qty = $('#qty_'+id)[0].innerHTML;
            var unit = $('#unit_'+id)[0].innerHTML;
            var remarks = $('#remarks_'+id)[0].innerHTML;

            var temp = {};
            temp['id'] = id;
            temp['item_id'] = item_id;
            temp['item_name'] = item_name;
            temp['it_name'] = it_name;
            temp['cwip'] = $('#cwip_'+id).val();
            temp['main'] = $('#main_'+id).val();
            temp['po'] = $('#po_'+id).val();
            temp['pr'] = $('#pr_'+id).val();
            temp['gl'] = $('#gl_'+id).val();
            temp['cc'] = $('#cc_'+id).val();
            temp['tr'] = $('#tr_'+id).val();
            temp['qty'] = qty;
            temp['unit'] = unit;
            temp['remarks'] = remarks;

            finalARr.push(temp);

            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/transferItem/itemTransferbyCDM') }}',
                data: { 'itr_no':itr_no, 'it_no':it_no, 'finalARr':finalARr, '_token': "{{ csrf_token() }}" },
                success: function (res) {

                    if (res.response == 1 || res.response == true) {
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                            text: 'Data has been updated successfully',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    } else if(res.response == 5){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please fill up all required fields.',
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        })
                    }else {
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

        function editThisRecord(id,item_id,item_name,cwip_id, main_id, po, pr, gl, cc, transfer_reason,qty,unit,remarks){

            $("#table_id").val(id);
            $("#edit_item_id").val(item_id);
            $("#edit_item_name").val(item_name);
            $("#edit_cwip_id").val(cwip_id);
            $("#edit_main_id").val(main_id);
            $("#edit_po").val(po);
            $("#edit_pr").val(pr);
            $("#edit_gl").val(gl);
            $("#edit_cc").val(cc);
            $("#edit_transfer_reason").val(transfer_reason);
            $("#edit_pr_qty").val(qty);
            $("#edit_unit").val(unit);
            $("#edit_remarks").val(remarks);


            if(remarks=='null'){
                $("#edit_remarks").val("");
            }else{
                $("#edit_remarks").val(remarks);
            }

            if(unit=='null'){
                $("#edit_unit").val("");
            }else{
                $("#edit_unit").val(unit);
            }

            if(qty=='null'){
                $("#edit_pr_qty").val("");
            }else{
                $("#edit_pr_qty").val(qty);
            }

            if(item_name=='null'){
                $("#edit_item_name").val("");
            }else{
                $("#edit_item_name").val(item_name);
            }


            if(transfer_reason=='null'){
                $("#edit_transfer_reason").val("");
            }else{
                $("#edit_transfer_reason").val(transfer_reason);
            }

            if(cwip_id=='null'){
                $("#edit_cwip_id").val("");
            }else{
                $("#edit_cwip_id").val(cwip_id);
            }

            if(main_id=='null'){
                $("#edit_main_id").val("");
            }else{
                $("#edit_main_id").val(main_id);
            }

            if(po=='null'){
                $("#edit_po").val("");
            }else{
                $("#edit_po").val(po);
            }

            if(pr=='null'){
                $("#edit_pr").val("");
            }else{
                $("#edit_pr").val(pr);
            }

            if(gl=='null'){
                $("#edit_gl").val("");
            }else{
                $("#edit_gl").val(gl);
            }

            $("#editItemDisplayModal").modal('show');

        }

        function deleteThisRecord(id, it_no){
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
                        url: '{{  url('stationery/form/transferItem/deleteTransferItem') }}',
                        data: { 'id':id,'it_no':it_no, '_token': " {{ csrf_token () }} "},
                        success: function (data) {

                            if(data.result == 1 || data.result == true|| data.result == 'true' ){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item has been deleted successfully',
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
