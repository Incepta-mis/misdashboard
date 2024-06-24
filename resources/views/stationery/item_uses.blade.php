@extends('_layout_shared._master')
@section('title','Manage Items')
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
        .center-block {
            margin: auto;
            display: block;
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
                        SHow Used Items
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
                                                    <select class="form-control" id="ir_no_selectTo" >


                                                    </select>
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

    {{-- Datatable html--}}
    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div style="background-color: #5AB6DF;">
                            <p style="font-size: 13px;font-weight: bold;color: white">Item Uses Detsils</p>
                        </div>
                        <div class="table-responsive">
                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%;">
                                <thead style="background-color: #3CB371">
                                <tr style="color: white">
                                    <th class="text-center">IUR Name</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Item ID</th>
                                    <th class="text-center">IR No.</th>
                                    <th class="text-center">CWIP ID</th>
                                    <th class="text-center">Main ID</th>
                                    <th class="text-center">PO Number</th>
                                    <th class="text-center">PR Number</th>
                                    <th class="text-center">GL</th>
                                    <th class="text-center">Cost Center</th>
                                    <th class="text-center">Use Qty</th>
                                    <th class="text-center">Remark</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>


                                </tr>
                                </thead>
                                <tbody ></tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    {{--Form--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label class="text-default">
                                    Item Uses
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="panel-body">
                    <div class="panel-body" style="padding-top: 2%">
                        <div style="color: red;font-weight: bold">
                            <p>*(Fields are required)</p>
                        </div>
                    </div>
                    <form action="#" method="post" id="item_issue_form">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">Item Name<span class='cls-req'>*</span></th>
                                    <th class="text-center">Item ID<span class='cls-req'>*</span></th>
                                    <th class="text-center">IR No.<span class='cls-req'>*</span></th>
                                    <th class="text-center">CWIP ID<span class='cls-req'>*</span></th>
                                    <th class="text-center">Main ID<span class='cls-req'>*</span></th>
                                    <th class="text-center">PO Number</th>
                                    <th class="text-center">PR Number</th>
                                    <th class="text-center">GL</th>
                                    <th class="text-center">Cost Center<span class='cls-req'>*</span></th>
                                    <th class="text-center">Use Qty<span class='cls-req'>*</span></th>
                                    <th class="text-center">Remark</th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                <tr>
                                    <td>
                                        <select id="item_name" name="item_name"
                                                class="form-control input-sm ">
                                            <option value="0" selected >Select Item Name</option>

                                            @if($item_name)
                                                @foreach($item_name as $name)
                                                    <option value="{{ $name->item_id}}" >{{$name->item_name}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="item_id"
                                               placeholder="" name="item_id">
                                    </td>
                                    <td>
                                        <select id="ir_no" name="ir_no"
                                                class="form-control input-sm ">
                                            <option value="0" selected >Select Item Name</option>

                                            @if($ir_no)
                                                @foreach($ir_no as $ir_nos)
                                                    <option value="{{ $ir_nos->ir_no}}" >{{$ir_nos->ir_no}}</option>
                                                @endforeach
                                            @endif

                                        </select>



                                      {{--  <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="ir_no"
                                               placeholder="" name="ir_no">--}}
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="cwip_id"
                                               placeholder="" name="cwip_id" min="1">

                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="main_id"
                                               placeholder="" name="main_id" min="1">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="po_number"
                                               placeholder="" name="po_number" min="1">
                                    </td>

                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="pr_number"
                                               placeholder="" name="pr_number" min="1">
                                    </td>

                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="gl"
                                               placeholder="" name="gl" min="1">
                                    </td>

                                    <td style="width: 200px !important;">
                                        <select id="cost_center" name="cost_center"
                                                class="form-control input-sm ">
                                            <option value="0" selected >Select Cost Center</option>

                                            @if($cost_center_id_name)
                                                @foreach($cost_center_id_name as $id_name)
                                                    <option value="{{$id_name->cost_center_id}}"  >{{$id_name->cost_center_name}}-{{$id_name->cost_center_id}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="use_qty" min="1"
                                               placeholder="" name="use_qty" >
                                        <div id="pr_qty_div"></div>
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="remark"
                                               placeholder="" name="remark"  min="1">
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <input type="button" class="add-row btn btn-info" value="Add To Submit">
                    </form>

                </div>

                {{--after adding data in table--}}
                <div class="panel-body" style="margin-top:20px" id="display_data">
                    <form  enctype="multipart/form-data" method="POST" id="issue_item_form" action="javascript:void(0)">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="issueTable">
                                <thead>
                                <tr>
                                    <th class="text-center">Select Item</th>
                                    <th class="text-center">Item Name<span class='cls-req'>*</span></th>
                                    <th class="text-center">Item ID<span class='cls-req'>*</span></th>
                                    <th class="text-center">IR No.<span class='cls-req'>*</span></th>
                                    <th class="text-center">CWIP ID<span class='cls-req'>*</span></th>
                                    <th class="text-center">Main ID<span class='cls-req'>*</span></th>
                                    <th class="text-center">PO Number</th>
                                    <th class="text-center">PR Number</th>
                                    <th class="text-center">GL</th>
                                    <th class="text-center">Cost Center</th>
                                    <th class="text-center">Use Qty<span class='cls-req'>*</span></th>
                                    <th class="text-center">Remark</th>
                                </tr>
                                </thead>
                                <tbody id="tbody" style="text-align:center">


                                </tbody>
                            </table>

                            <button type="button" class="delete-row btn btn-danger" style="display:none" id="delete_button">Delete Item</button>
                            <button type="button"  type="submit"  class="btn btn-info" style="display:none" id="submit_button">Submit</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    {{--Modal for datatable--}}
    <div id="editItemDisplayModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Used Item</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_ir_no" class="control-label col-sm-2">IR NO:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_iur_no" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Item ID:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_id" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_name" class="control-label col-sm-2">Item Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_name" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ir_no" class="control-label col-sm-2">IR No.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_ir_no" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_cwip_id" class="control-label col-sm-2">CWIP Id:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_cwip_id" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_main_id" class="control-label col-sm-2">Main Id:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_main_id" value="" readonly>
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
                                <input type="text" class="form-control" id="edit_gl" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_cost_center" class="control-label col-sm-2">Cost Center:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <select id="edit_cost_center" name="edit_cost_center"
                                        class="form-control input-sm ">
                                    @if($cost_center_id_name)
                                        @foreach($cost_center_id_name as $id_name)
                                            <option value="{{$id_name->cost_center_id}}"  >{{$id_name->cost_center_name}}-{{$id_name->cost_center_id}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_use_qty" class="control-label col-sm-2">Use Quantity:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10" id="add_qty">
                                <input type="number" class="form-control" id="edit_use_qty" value="" min="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_remarks" class="control-label col-sm-2">Remarks:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_remarks" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="update_issue">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--Modal for approve qty--}}
    <div id="approveQtyDisplayModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Approve Quantity</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_ir_no" class="control-label col-sm-2">IR NO:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="aprv_ir_no" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Item ID:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="aprv_item_id" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_item_name" class="control-label col-sm-2">Item Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="aprv_item_name" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_unit" class="control-label col-sm-2">Unit:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="aprv_unit" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_pr_qty" class="control-label col-sm-2">Request Quantity:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="aprv_req_qty" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_remarks" class="control-label col-sm-2">Approve Qty:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" min="1"    id="aprv_aprv_qty" value="" placeholder="Approve Quantity">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="approve_qty_button">Approve</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--Modal for issued qty--}}
    <div id="issueQtyDisplayModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Accept Issue Quantity</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="issu_ir_no" class="control-label col-sm-2">IR NO:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="issu_ir_no" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="issue_item_id" class="control-label col-sm-2">Item ID:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="issu_item_id" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="issu_item_name" class="control-label col-sm-2">Item Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="issu_item_name" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="issu_unit" class="control-label col-sm-2">Unit:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="issu_unit" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="issu_req_qty" class="control-label col-sm-2">Request Quantity:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="issu_req_qty" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="issu_appr_qty" class="control-label col-sm-2">Approve Qty:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="issu_appr_qty" value="" placeholder="Approve Quantity">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="issu_issu_qty" class="control-label col-sm-2">Issue Qty:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control"  id="issu_issu_qty" value="" placeholder="Issue Quantity">
                                <p style="display:block; margin-right:110px;color: red">Item Qty <label id="max_issue_qty"></label></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="issue_qty_button">Issue</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{--Modal for update image--}}
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Image

                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="issu_ir_no" class="control-label col-sm-2">IR NO:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="issu_ir_no_img" value="" disabled="disabled">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="update_img" class="control-label col-sm-2">Upload Img:</label>
                                <div class="col-sm-10">
                                    <input type="file" style="width: 300px" name="file" placeholder="Choose Img File" id="issue_file_update" class="center-block form-control">
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-info" id="update_img_button">Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </form>
                    </div>
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

    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}

    <script type="text/javascript">
        var edit_actual_pr_type;

        $(document).ready(function () {
            var actual_qty;
            var actual_pr_type;
            var edit_actual_qty;


            $('#cost_center').select2();
            $('#edit_cost_center').select2();
            $('#item_name').select2();
            $('#ir_no').select2();

            $("#item_name").on("select2:select",function (){
                var item_id = $('#item_name option:selected').val();
                $('#item_id').val(item_id);

                if(item_id==0){
                    $('#item_id').val('');
                }
                $('#item_id').attr('readonly', true);
            })

            /*Onselect Item Name*/
        /*    $("#item_name").on("select2:select",function (){
                console.log("here is teh trigger")
                var item_id = $('#item_name option:selected').val();
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/item_use/getItemDetails') }}',
                    data: {'item_id': item_id, '_token': "{{ csrf_token () }}"},

                    success: function (data) {
                        console.log("hello kw")
                        var ir_no = data[0]
                        console.log(ir_no)

                        if(data){
                            $('#item_id').val(item_id);
                            $('#item_id').attr('readonly', true);

                            $('#ir_no').val(data[0]['ir_no']);
                            $('#ir_no').attr('readonly', true);

                           /!* $('#cwip_id').val(data[0]['cwip_id']);
                            $('#cwip_id').attr('readonly', true);

                            $('#main_id').val(data[0]['main_id']);
                            $('#main_id').attr('readonly', true);

                            $('#pr_number').val(data[0]['sap_pr']);

                            $('#gl').val(data[0]['gl']);

                            $("#cost_center").select2().val(data[0]['cost_center']).trigger("change");*!/

                        }else{
                            $('#item_id').val('');
                            $('#item_id').attr('readonly', true);

                            $('#ir_no').val('');
                            $('#ir_no').attr('readonly', true);

                          /!*  $('#cwip_id').val('');
                            $('#cwip_id').attr('readonly', true);

                            $('#main_id').val('');
                            $('#main_id').attr('readonly', true);

                            $('#pr_number').val('');

                            $('#gl').val('');

                            $("#cost_center").select2().val('0').trigger("change");*!/

                        }

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });

            });*/

            /*Add row on button click*/
            $(".add-row").click(function () {

                var item_name = $("#item_name option:selected").text();
                var item_id = $("#item_id").val();
                var ir_no = $("#ir_no option:selected").val();
                var cwip_id = $("#cwip_id").val();
                var main_id = $("#main_id").val();
                var po_number = $("#po_number").val();
                var pr_number = $("#pr_number").val();
                var gl = $("#gl").val();
                var cost_center = $("#cost_center option:selected").val();
                var use_qty = $("#use_qty").val();
                var remark = $("#remark").val();

                if ((item_name== 'Select Item Name' ||item_name== '' || item_id==''|| ir_no==''|| ir_no==0||  use_qty==''||  cost_center=='') ||((cwip_id==''||main_id=='')&& actual_pr_type=='CAPEX')){
                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please Input Required Field!',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                }
                var markup = "<tr><td><input type='checkbox' name='record' id='record'></td><td>" + item_name + "</td><td>" + item_id + "</td><td>" + ir_no + "</td><td>"
                    + cwip_id + "</td><td>" + main_id + "</td><td>" + po_number + "</td><td>" + pr_number + "</td><td>" + gl + "</td><td>" + cost_center + "</td><td>" + use_qty + "</td><td>" + remark + "</td></tr>";

                var delete_button = "<input type='button' value='Delete'>"

                $("#display_data table tbody").append(markup);
                $("#delete_button").css("display", "inline-block");
                $("#submit_button").css("display", "inline-block");


                $('#cost_center').val('0');
                $('#cost_center').trigger('change');


                $('#item_name').val('0');
                $('#item_name').trigger('change');

                $('#ir_no').val('0');
                $('#ir_no').trigger('change');

                $('#item_id').attr('readonly', false);

                $('#item_issue_form')[0].reset();

            });

            // Find and remove selected table rows
            $(".delete-row").click(function () {
                count = 0

                $("table tbody").find('input[name="record"]').each(function () {
                    if ($(this).is(":checked")) {
                        count++;
                    }
                });

                if (count != '') {
                    $("table tbody").find('input[name="record"]').each(function () {
                        if ($(this).is(":checked")) {
                            $(this).parents("tr").remove();
                        }
                    });
                } else {
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

            /*Submit Form*/
            $(document).on("click", "#submit_button", function (e) {

                e.preventDefault();
                var itemArray = [];

                $("#issueTable tbody tr").each(function () {
                    var issueItemData = {};

                    var self = $(this);

                    var item_name = self.find("td:eq(1)").text().trim();
                    var item_id = self.find("td:eq(2)").text().trim();
                    var ir_no = self.find("td:eq(3)").text().trim();
                    var cwip_id = self.find("td:eq(4)").text().trim();
                    var main_id = self.find("td:eq(5)").text().trim();
                    var po_number = self.find("td:eq(6)").text().trim();
                    var pr_number = self.find("td:eq(7)").text().trim();
                    var gl = self.find("td:eq(8)").text().trim();
                    var cost_center = self.find("td:eq(9)").text().trim();
                    var use_qty = self.find("td:eq(10)").text().trim();
                    var remarks = self.find("td:eq(11)").text().trim();


                    issueItemData.item_name = item_name;
                    issueItemData.item_id = item_id;
                    issueItemData.ir_no = ir_no;
                    issueItemData.cwip_id = cwip_id;
                    issueItemData.main_id = main_id;
                    issueItemData.po_number = po_number;
                    issueItemData.pr_number = pr_number;
                    issueItemData.gl = gl;
                    issueItemData.cost_center = cost_center;
                    issueItemData.use_qty = use_qty;
                    issueItemData.remarks = remarks;

                    itemArray.push(issueItemData);

                });


                var itemData = JSON.stringify(itemArray);

                var formData = new FormData();
                formData.append("data", itemData);
                formData.append('_token', '{{ csrf_token() }}');


                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/item_use/saveUseItem') }}',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        if (response.result=='success') {
                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                text: 'Item Saved successfully',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })

                        } else if(response.result=='error') {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something was wrong!Failed to save item',
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
            });

            /*Get value in select two*/
            $('#ir_no_selectTo').select2({
                placeholder: 'Select IR No.',
                ajax: {
                    url: '{{  url('stationery/form/item_use/getIURNo') }}',
                    method: 'get',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {

                                return {
                                    text: item.iur_no,
                                    id: item.iur_no
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            /* Display datatable after search*/
            $('#display_ir_datatable').on('click', function (e) {
                $("#loader").show();
                $("#report-body").show();

                var ir_no = $('#ir_no_selectTo').select2("val");
                data = {ir_no: ir_no, "_token": "{{ csrf_token() }}"};
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('stationery/form/item_use/showIurdata') }}",
                    success: function (resp) {

                        $("#loader").hide();
                        $("#report-body").show();

                        $("#blk_list").DataTable().destroy();
                        table = $("#blk_list").DataTable({
                            data: resp.usedItems,
                            autoWidth: true,
                            columns: [
                                {data: "iur_no"},
                                {data: "item_id"},
                                {data: "item_name"},
                                {data: "ir_no"},
                                {data: "cwip_id"},
                                {data: "main_id"},
                                {data: "po_number"},
                                {data: "pr_number"},
                                {data: "gl"},
                                {data: "cost_center"},
                                {data: "use_qty"},
                                {data: "remarks"},
                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-info row-edit ' +
                                            'dt-center\" id="' + row.id + '" ' +
                                            'onclick="editThisRecord(' + "'" + row.id + "','" + row.iur_no + "','" + row.item_id + "','" + row.item_name + "','" + row.ir_no + "','" + row.cwip_id
                                            + "','" + row.main_id + "','" + row.po_number + "','" + row.pr_number + "','" + row.gl + "','" + row.cost_center + "','" + row.use_qty + "','" + row.remarks + "')" + '">EDIT</button>'
                                    }
                                },
                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                            'dt-center\" id="' + row.id + '" ' +
                                            'onclick="deleteThisRecord(' + "'" + row.id + "','" + row.iur_no + "')" + '">Delete</button>'
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
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });


            /*Update Issue*/
            $("#update_issue").on('click', function () {
                var edit_iur_no = $("#edit_iur_no").val();
                var edit_item_id = $("#edit_item_id").val();
                var edit_item_name = $("#edit_item_name").val();
                var edit_ir_no = $("#edit_ir_no").val();
                var edit_cwip_id = $("#edit_cwip_id").val();
                var edit_main_id = $("#edit_main_id").val();
                var edit_po_number = $("#edit_po_number").val();
                var edit_pr_number = $("#edit_pr_number").val();
                var edit_gl = $("#edit_gl").val();
                var edit_cost_center = $("#edit_cost_center option:selected").val();
                var edit_use_qty = $("#edit_use_qty").val();
                var edit_remarks = $("#edit_remarks").val();


                var table_id = $("#table_id").val();

                var itemArray = {};

                itemArray.edit_iur_no = edit_iur_no;
                itemArray.edit_item_id = edit_item_id;
                itemArray.edit_item_name = edit_item_name;
                itemArray.edit_ir_no = edit_ir_no;
                itemArray.edit_cwip_id = edit_cwip_id;
                itemArray.edit_main_id = edit_main_id;
                itemArray.edit_po_number = edit_po_number;
                itemArray.edit_pr_number = edit_pr_number;
                itemArray.edit_gl = edit_gl;
                itemArray.edit_cost_center = edit_cost_center;
                itemArray.edit_use_qty = edit_use_qty;
                itemArray.edit_remarks = edit_remarks;

                var itemArrayData = JSON.stringify(itemArray);


                if (!edit_iur_no || !edit_item_id || !edit_item_name || !edit_ir_no||!edit_cost_center|| !edit_use_qty ||(edit_cwip_id=='' && edit_actual_pr_type==='CAPEX')||(edit_main_id==''&&  edit_actual_pr_type==='CAPEX') ) {

                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please Input Required Field!',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/item_use/updateIusedItem') }}',
                        data: {'id': table_id, 'itemArray': itemArrayData, '_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if (data.result == 1 || data.result == "success") {
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
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update',
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
                            console.log(e)

                        }
                    });

                }

            });

        });
        function editThisRecord(id,iur_no, item_id, item_name, ir_no, cwip_id, main_id, po_number, pr_number, gl,cost_center,use_qty,remarks ) {

            //console.log("here is actual pr type")



            $("#table_id").val(id);
          /*  $("#edit_iur_no").val(iur_no);
            $("#edit_item_id").val(item_id);
            $("#edit_item_name").val(item_name);
            $("#edit_ir_no").val(ir_no);
            $("#edit_cwip_id").val(cwip_id);
            $("#edit_main_id").val(main_id);
            $("#edit_po_number").val(po_number);
            $("#edit_pr_number").val(pr_number);
            $("#edit_gl").val(gl);
            $("#edit_cost_center").val(cost_center);
            $("#edit_use_qty").val(use_qty);
            $("#edit_remarks").val(remarks);
*/

            if (iur_no == 'null' || iur_no == '') {
                $("#edit_iur_no").val("");
            } else {
                $("#edit_iur_no").val(iur_no);
            }

            if (item_id == 'null' || item_id == '') {
                $("#edit_item_id").val("");
            } else {
                $("#edit_item_id").val(item_id);
            }

            if (item_name == 'null' || item_name == '') {
                $("#edit_item_name").val("");
            } else {
                $("#edit_item_name").val(item_name);
            }

            if (ir_no == 'null' || ir_no == '') {
                $("#edit_ir_no").val("");
            } else {
                $("#edit_ir_no").val(ir_no);
            }

            if (cwip_id == 'null' || cwip_id == '') {
                $("#edit_cwip_id").val("");
            } else {
                $("#edit_cwip_id").val(cwip_id);
            }

            if (main_id == 'null' || main_id == '') {
                $("#edit_main_id").val("");
            } else {
                $("#edit_main_id").val(main_id);
            }

            if (po_number == 'null' || po_number == '') {
                $("#edit_po_number").val("");
            } else {
                $("#edit_po_number").val(po_number);
            }


            if (pr_number == 'null' || pr_number == '') {
                $("#edit_pr_number").val("");
            } else {
                $("#edit_pr_number").val(pr_number);
            }

            if (gl == 'null' || gl == '') {
                $("#edit_gl").val("");
            } else {
                $("#edit_gl").val(gl);
            }

            if (cost_center == 'null' || cost_center == '') {

                $("#edit_cost_center").select2().val("").trigger("change");
            } else {
                $("#edit_cost_center").select2().val(cost_center).trigger("change");

            }


            if (use_qty == 'null' || use_qty == '') {
                $("#edit_use_qty").val("");
            } else {
                $("#edit_use_qty").val(use_qty);
            }

            if (remarks == 'null' || remarks == '') {
                $("#edit_remarks").val("");
            } else {
                $("#edit_remarks").val(remarks);
            }

            var item_id_new = item_id
            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/issueItem/getProductQty') }}',
                data: {'item_id': item_id_new, '_token': "{{ csrf_token () }}"},

                success: function (data) {
                    edit_actual_qty = data.item_qty;
                    edit_actual_pr_type = data.item_type;

                    if(data.item_qty){
                        $('#edit_use_qty').attr('max', data.item_qty);
                        $('#add_qty p').remove();
                        $('#add_qty').append("<p style='font-size:11px;text-align:center;color: #a54c48;font-weight:600'>Avaiable Qty: "+data.item_qty+"</p>");

                    }else{
                        $('#edit_use_qty').removeAttr("max");
                        $('#add_qty p').remove();
                        $('#add_qty').append("<p style='font-size:11px;text-align: center;color: red; " +
                            "font-weight: " +
                            "600;" +"'>Stock is empty</p>");
                    }

                    if(data.item_type!='CAPEX'){
                        $('#edit_cwip_id').attr('readonly',true);
                        $('#edit_main_id').attr('readonly',true);
                    }else{
                        $('#edit_cwip_id').attr('readonly',false);
                        $('#edit_main_id').attr('readonly',false);

                    }

                },
                error: function (e) {
                    console.log(e);
                }
            });

            $("#editItemDisplayModal").modal('show');

        }

        function deleteThisRecord(id, iur_no) {

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
                        url: '{{  url('stationery/form/item_use/deleteItemUses') }}',
                        data: {'id': id, 'iur_no': iur_no, '_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if (data.result == 1 || data.result == true || data.result == 'true') {
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
                            } else {
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

