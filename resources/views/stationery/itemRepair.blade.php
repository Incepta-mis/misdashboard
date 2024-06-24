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


    </style>
@endsection
@section('right-content')

    {{--select cwip id and show details--}}
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" >
                <header class="panel-heading">
                    <label class="text-primary">
                        Show All Repaired Item List
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
                                                       class="col-md-3 col-sm-3 control-label"><b>Service No.:</b></label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select class="form-control" id="srvc_no_selectTo" >


                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <div class="col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="display_datatable" class="btn btn-warning btn-sm">
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
                <section class="panel panel-primary" id="data_table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="text-default">
                                        Repaired Item List
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="service_tbl" class="table table-striped table-bordered" style="width:100%;">
                                <thead style="background-color: #3CB371">
                                <tr style="color: white">
                                    <th class="text-center">Requisition NO. </th>
                                    <th class="text-center">Vendor ID</th>
                                    <th class="text-center">Vendor Name </th>
                                    <th class="text-center">Vendor Mobile </th>
                                    <th class="text-center">Vendor Address</th>
                                    <th class="text-center">Bill No.</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">User Name</th>
                                    <th class="text-center">Repair Type</th>
                                    <th class="text-center">Items No.</th>
                                    <th class="text-center">Items Name</th>
                                    <th class="text-center">Product Serail No.</th>
                                    <th class="text-center">Previous Service Date</th>
                                    <th class="text-center">CWIPm Id/Main ID</th>
                                    <th class="text-center">GL</th>
                                    <th class="text-center">Cost Center</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit Cost</th>
                                    <th class="text-center">Total Cost</th>
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

    {{--Item repair form--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label class="text-default">
                                    Item Repair
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 2%">
                    <div style="color: red;font-weight: bold">
                        <p>*(Fields are required)</p>
                    </div>

                    <form action="#" method="post" id="item_issue_form">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">Requisition NO.<span class='cls-req'>*</span> </th>
                                    <th class="text-center">Vendor ID</th>
                                    <th class="text-center">Vendor Name <span class='cls-req'>*</span></th>
                                    <th class="text-center">Vendor Mobile </th>
                                    <th class="text-center">Vendor Address</th>
                                    <th class="text-center">Bill No.<span class='cls-req'>*</span></th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">User Name</th>
                                    <th class="text-center">Repair Type</th>
                                    <th class="text-center">Items Name<span class='cls-req'>*</span></th>
                                    <th class="text-center">Items No.<span class='cls-req'>*</span></th>
                                    <th class="text-center">Product Serail No.</th>
                                    <th class="text-center">Previous Service Date</th>
                                    <th class="text-center">CWIP Id/Main ID</th>
                                    <th class="text-center">GL</th>
                                    <th class="text-center">Cost Center</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit Cost</th>
                                    <th class="text-center">Total Cost</th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                <tr>

                                    <td>
                                        <select id="requisition_no" name="requisition_no"
                                                class="form-control input-sm ">
                                            <option value="0" selected >Select Requisition No.</option>
                                            @if($itr_no)
                                                @foreach($itr_no as $itr_nos)
                                                    <option value="{{$itr_nos->itr_no}}"  >{{$itr_nos->itr_no}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="vendor_id"
                                               placeholder="" name="vendor_id" disabled>
                                    </td>
                                    <td>
                                        <select id="vendor_name" name="vendor_name"
                                                class="form-control input-sm ">
                                            <option value="0" selected >Select Vendor Name.</option>
                                            @if($vendor)
                                                @foreach($vendor as $vendors)
                                                    <option value="{{$vendors->id}}"  >{{$vendors->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="vendor_mobile"
                                               placeholder="" name="vendor_mobile" disabled>
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="vendor_address"
                                               placeholder="" name="vendor_address" disabled>
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="bill_no"
                                               placeholder="" name="bill_no" min="1">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="description"
                                               placeholder="" name="description">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="user_name"
                                               placeholder="" name="user_name">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="repair_type"
                                               placeholder="" name="repair_type">
                                    </td>
                                    <td>

                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="item_name"
                                               placeholder="" name="item_name" disabled>
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="item_id"
                                               placeholder="" name="item_id" disabled>
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="product_serail_no"
                                               placeholder="" name="product_serail_no">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="prev_service_date"
                                               placeholder="" name="prev_service_date">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="cwip_id_or_main_id"
                                               placeholder="" name="cwip_id_or_main_id">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="gl"
                                               placeholder="" name="gl">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="cost_center"
                                               placeholder="" name="cost_center" disabled>
                                    </td>
                                    <td id="qty_div">
                                        <input type="number" class="form-control input-xs" id="quantity"
                                               placeholder="" name="quantity" min="1">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="unit_cost"
                                               placeholder="" name="unit_cost" min="1">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="total_cost"
                                               placeholder="" name="total_cost">
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <input type="button" class="add-row btn btn-info" value="Add To Submit">

                    </form>
                </div>

                <div class="panel-body" style="margin-top:20px;display: none;" id="display_data">
                    <form action="#" method="post" id="issue_item_form">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="issueTable">
                                <thead>
                                <tr>
                                    <th class="text-center">Select Item</th>
                                    <th class="text-center">Requisition NO. </th>
                                    <th class="text-center">Vendor ID</th>
                                    <th class="text-center">Vendor Name </th>
                                    <th class="text-center">Vendor Mobile </th>
                                    <th class="text-center">Vendor Address</th>
                                    <th class="text-center">Bill No.</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">User Name</th>
                                    <th class="text-center">Repair Type</th>
                                    <th class="text-center">Items Name</th>
                                    <th class="text-center">Items No.</th>
                                    <th class="text-center">Product Serail No.</th>
                                    <th class="text-center">Previous Service Date</th>
                                    <th class="text-center">CWIPm Id/Main ID</th>
                                    <th class="text-center">GL</th>
                                    <th class="text-center">Cost Center</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit Cost</th>
                                    <th class="text-center">Total Cost</th>
                                </tr>
                                </thead>
                                <tbody id="req_table_body" style="
                                text-align:center">


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

    {{--Modal for datatable--}}
    <div id="editItemDisplayModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Repair Products</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <label for="edit_req_no" class="control-label col-sm-2">Requisition NO.<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_req_no" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_vendor_id" class="control-label col-sm-2">Vendor ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_vendor_id" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_vendor_name" class="control-label col-sm-2">Vendor Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <select id="edit_vendor_name" name="edit_vendor_name"
                                        class="form-control input-sm ">
                                    <option value="0" selected >Select Vendor Name</option>
                                    @if($vendor)
                                        @foreach($vendor as $vendors)
                                            <option value="{{$vendors->id}}"  >{{$vendors->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="edit_vendor_mobile" class="control-label col-sm-2">Vendor Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_vendor_mobile" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_vendor_address" class="control-label col-sm-2">Vendor Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_vendor_address" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_bill_no" class="control-label col-sm-2">Bill No.<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_bill_no" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_description" class="control-label col-sm-2">Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_description" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_user_name" class="control-label col-sm-2">User Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_user_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_repair_type" class="control-label col-sm-2">Repair Type</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_repair_type" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Items No.<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_id" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_name" class="control-label col-sm-2">Items Name<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_name" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_product_serial_no" class="control-label col-sm-2">Product Serail No.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_product_serial_no" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_prev_srvc_date" class="control-label col-sm-2">Previous Service Date</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_prev_srvc_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_cwip_id_or_main_id" class="control-label col-sm-2">CWIP Id/Main ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_cwip_id_or_main_id" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_gl" class="control-label col-sm-2">GL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_gl" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_cost_center" class="control-label col-sm-2">Cost Center</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_cost_center" value="" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_total_cost" class="control-label col-sm-2">Quantity</label>
                            <div class="col-sm-10" id="edit_pr_qty_div">
                                <input type="number" class="form-control" id="edit_quantity" value="1" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_total_cost" class="control-label col-sm-2">Unit Cost</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="edit_unit_cost" value="1" min="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_unit_cost" class="control-label col-sm-2">Total Cost</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="edit_total_cost" value="1" min="1">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="update_service">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
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

    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#requisition_no').select2();
            $("#vendor_name").select2();
            $("#edit_vendor_name").select2();

            $('#prev_service_date').datetimepicker({
                format: 'DD/MM/YYYY'
            });

            $('#edit_prev_srvc_date').datetimepicker({
                format: 'DD/MM/YYYY'
            });

            $('#quantity, #unit_cost').on('change',function (){
                var quantity = $('#quantity').val();
                var unit_cost = $('#unit_cost').val();

                if(quantity && unit_cost){
                    var total_cost = unit_cost*quantity;
                    $("#total_cost").val(total_cost)
                }else{
                    $("#total_cost").val(0);
                }
            });

            $('#edit_quantity, #edit_unit_cost').on('change',function (){
                var edit_quantity = $('#edit_quantity').val();
                var edit_unit_cost = $('#edit_unit_cost').val();

                if(edit_quantity && edit_unit_cost){
                    var edit_total_cost = edit_unit_cost*edit_quantity;
                    $("#edit_total_cost").val(edit_total_cost)
                }else{
                    $("#edit_total_cost").val(0);
                }
            });

            /*Get requisition onchnage value*/
            $("#requisition_no").on('change',function (){
                var itr_no = $('#requisition_no option:selected').val();
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/itemRepair/getRequisitionData') }}',
                    data: { 'itr_no':itr_no, '_token': "{{ csrf_token () }}"},
                    success: function (data) {
                        if(data.result){
                            $("#item_name").val(data.result[0].item_name);
                            $("#item_id").val(data.result[0].item_id);
                            $("#gl").val(data.result[0].gl);
                            $("#cost_center").val(data.result[0].cost_center);
                        }else{
                            $("#item_name").val("");
                            $("#item_id").val("");
                            $("#gl").val("");
                            $("#cost_center").val("");
                        }
                        if(data.status == 1){
                            $('#quantity').attr('max', data.qty);
                            $('#qty_div p').remove();
                            $('#qty_div').append("<p style='text-align: center;color: #a54c48; " +
                                "font-weight: " +
                                "600;" +
                                "'>Available quantity:" +
                                " "+data.qty+"</p>");
                        }else{
                            $('#quantity').removeAttr("max");
                            $('#qty_div p').remove();
                            $('#qty_div').append("<p style='text-align: center;color: red; " +
                                "font-weight: " +
                                "600;" +"'>Stock is empty</p>");
                        }

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            /*Get vendor onchnage value*/
            $("#vendor_name").on('change',function (){

                var vendor_id = $('#vendor_name option:selected').val();
                console.log("here sayla")
                console.log(vendor_id);

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/itemRepair/getvendordata') }}',
                    data: { 'vendor_id':vendor_id, '_token': "{{ csrf_token () }}"},
                    success: function (data) {
                        console.log("vendor data")
                        console.log(data)
                        if(data.result){
                            $("#vendor_id").val(data.result[0].id);
                            $("#vendor_mobile").val(data.result[0].contact);
                            $("#vendor_address").val(data.result[0].address);
                        }else{
                            $("#vendor_id").val("");
                            $("#vendor_mobile").val("");
                            $("#vendor_address").val("");
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });


            /*Get vendor onchnage value*/
            $("#edit_vendor_name").on("select2:select",function (){
                console.log("edit vendor name changed")

                var vendor_id = $('#edit_vendor_name option:selected').val();
                console.log("here sayla")
                console.log(vendor_id);

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/itemRepair/getItemDetails') }}',
                    data: { 'vendor_id':vendor_id, '_token': "{{ csrf_token () }}"},
                    success: function (data) {

                        console.log(data)
                        if(data.result){
                            $("#edit_vendor_id").val(vendor_id);
                            $("#edit_vendor_mobile").val(data.result[0].contact);
                            $("#edit_vendor_address").val(data.result[0].address);
                        }else{
                            $("#edit_vendor_id").val("");
                            $("#edit_vendor_mobile").val("");
                            $("#edit_vendor_address").val("");
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });



            /*Add row on button click*/
            $(".add-row").click(function(){
                console.log("sayla")

                var requisition_no = $("#requisition_no option:selected").text();
                var vendor_id = $("#vendor_id").val();
                var vendor_name = $("#vendor_name option:selected").text();
                var vendor_mobile = $("#vendor_mobile").val();
                var vendor_address = $("#vendor_address").val();
                var description = $("#description").val();
                var user_name = $("#user_name").val();
                var repair_type = $("#repair_type").val();
                var product_serail_no = $("#product_serail_no").val();
                var prev_service_date = $("#prev_service_date").val();
                var cwip_id_or_main_id = $("#cwip_id_or_main_id").val();
                var gl = $("#gl").val();
                var cost_center = $("#cost_center").val();
                var quantity = $("#quantity").val();
                var unit_cost = $("#unit_cost").val();
                var total_cost = $("#total_cost").val();
                var item_id = $("#item_id").val();
                var item_name = $("#item_name").val();
                var bill_no = $("#bill_no").val();


                if(requisition_no=='' || requisition_no=='Select Requisition No.'||vendor_name==''||vendor_name=='Select Vendor Name.'
                    ||bill_no==''||item_name==''){

                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Input Required Field!',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                }

                var markup = "<tr>" +
                    '<td><input type="checkbox" name="record" id="record"></td>' +
                    '<td>'+requisition_no+'</td>' +
                    '<td>'+vendor_id+'</td>' +
                    '<td>'+vendor_name+'</td>'+
                    '<td>'+vendor_mobile+'</td>' +
                    '<td>'+vendor_address+'</td>'+
                    '<td>'+bill_no+'</td>'+
                    '<td>'+description+'</td>' +
                    '<td>'+user_name+'</td>' +
                    '<td>'+repair_type+'</td>' +
                    '<td>'+item_name+'</td>' +
                    '<td>'+item_id+'</td>' +
                    '<td>'+product_serail_no+'</td>' +
                    '<td>'+prev_service_date+'</td>' +
                    '<td>'+cwip_id_or_main_id+'</td>' +
                    '<td>'+gl+'</td>' +
                    '<td>'+cost_center+'</td>' +
                    '<td>'+quantity+'</td>' +
                    '<td>'+unit_cost+'</td>' +
                    '<td>'+total_cost+'</td>' +
                    "</tr>";

                var delete_button ="<input type='button' value='Delete'>"

                $("#display_data").show();
                $("#display_data table tbody").append(markup);
                $("#delete_button").css("display","inline-block");
                $("#submit_button").css("display","inline-block");


                $('#requisition_no').val('0');
                $('#requisition_no').trigger('change');

                $('#vendor_name').val('0');
                $('#vendor_name').trigger('change');

                $("#item_issue_form").trigger('reset');

            });

            // Find and remove selected table rows
            $("#submit_button").click(function(){
                var itemArray = [];

                $("#issueTable tbody tr").each(function () {
                    var issueItemData = {};

                    var self = $(this);


                    var requisition_no = self.find("td:eq(1)").text().trim();
                    var vendor_id = self.find("td:eq(2)").text().trim();
                    var vendor_name = self.find("td:eq(3)").text().trim();
                    var vendor_mobile = self.find("td:eq(4)").text().trim();
                    var vendor_address = self.find("td:eq(5)").text().trim();
                    var bill_no = self.find("td:eq(6)").text().trim();
                    var description = self.find("td:eq(7)").text().trim();
                    var user_name = self.find("td:eq(8)").text().trim();
                    var repair_type = self.find("td:eq(9)").text().trim();
                    var item_name = self.find("td:eq(10)").text().trim();
                    var item_id = self.find("td:eq(11)").text().trim();
                    var product_serial_no = self.find("td:eq(12)").text().trim();
                    var previous_service_date = self.find("td:eq(13)").text().trim();
                    var cwip_id_or_main_id = self.find("td:eq(14)").text().trim();
                    var gl = self.find("td:eq(15)").text().trim();
                    var cost_center = self.find("td:eq(16)").text().trim();
                    var quantity = self.find("td:eq(17)").text().trim();
                    var unit_cost = self.find("td:eq(18)").text().trim();
                    var total_cost = self.find("td:eq(19)").text().trim();


                    issueItemData.requisition_no = requisition_no;
                    issueItemData.vendor_id = vendor_id;
                    issueItemData.vendor_name = vendor_name;
                    issueItemData.vendor_mobile = vendor_mobile;
                    issueItemData.vendor_address = vendor_address;
                    issueItemData.bill_no = bill_no;
                    issueItemData.description = description;
                    issueItemData.user_name = user_name;
                    issueItemData.repair_type = repair_type;
                    issueItemData.item_name = item_name;
                    issueItemData.item_id = item_id;
                    issueItemData.product_serial_no = product_serial_no;
                    issueItemData.previous_service_date = previous_service_date;
                    issueItemData.cwip_id_or_main_id = cwip_id_or_main_id;
                    issueItemData.gl = gl;
                    issueItemData.cost_center = cost_center;
                    issueItemData.quantity = quantity;
                    issueItemData.unit_cost = unit_cost;
                    issueItemData.total_cost = total_cost;

                    itemArray.push(issueItemData);

                });

                var itemData = JSON.stringify(itemArray);
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/itemRepair/saveItemRepair') }}',
                    data: {
                        'issueItemData': itemData,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if ( response.status == 1 || response.status == 'success') {
                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                text: 'Item Saved Successfully',
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
                                text: 'Something was wrong! Failed to save item .',
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

            /*  Select two val*/
            var data;
            $('#srvc_no_selectTo').select2({
                placeholder: 'Select Service Id No.',
                ajax: {
                    url: '{{  url('stationery/form/itemRepair/getRepaireItem') }}',
                    method:'get',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        console.log("select two data")
                        console.log(data)
                        return {
                            results:  $.map(data, function (item) {
                                console.log("select two item status")
                                console.log(item)
                                return {
                                    text: item.service_id,
                                    id: item.service_id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            /* Display datatable after search*/
            $('#display_datatable').on('click', function (e) {
                $("#loader").show();
                $("#report-body").show();

                var service_no = $('#srvc_no_selectTo').select2("val");
                data = { service_no:service_no,"_token": "{{ csrf_token() }}"};
                $.ajax({
                    type: "get",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('stationery/form/itemRepair/getAllService') }}",
                    success: function (resp) {

                        console.log("ir display sayla");
                        console.log(resp);
                        $("#loader").hide();
                        $("#report-body").show();

                        $("#service_tbl").DataTable().destroy();
                        table = $("#service_tbl").DataTable({
                            data: resp,
                            autoWidth: true,
                            columns: [
                                {data: "requisition_no"},
                                {data: "vendor_id"},
                                {data: "vendor_name"},
                                {data: "vendor_mobile"},
                                {data: "vendor_address"},
                                {data: "bill_no"},
                                {data: "description"},
                                {data: "user_name"},
                                {data: "repair_type"},
                                {data: "item_id"},
                                {data: "item_name"},
                                {data: "product_serial_no"},
                                {data: "previous_service_date"},
                                {data: "cwip_id_or_main_id"},
                                {data: "gl"},
                                {data: "cost_center"},
                                {data: "quantity"},
                                {data: "unit_cost"},
                                {data: "total_cost"},
                                { data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-info row-edit ' +
                                            'dt-center\" id="' + row.id + '" ' +
                                            'onclick="editThisRecord(' + "'" + row.id + "','" + row.requisition_no + "','" + row.vendor_id + "','" + row.vendor_name + "','" + row.vendor_mobile + "','" + row.vendor_address + "','" + row.bill_no + "','" + row.description + "','"
                                            + row.user_name + "','" + row.repair_type + "','" + row.item_id + "','" + row.item_name + "','" + row.product_serial_no + "','" + row.previous_service_date + "','" + row.cwip_id_or_main_id + "','" + row.gl + "','" + row.cost_center + "','" + row.quantity + "','" + row.total_cost + "','" + row.unit_cost + "')" + '">EDIT</button>'
                                    }
                                },


                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="deleteThisRecord('+"'"+row.id+"','"+row.requisition_no+"')"+'">Delete</button>'
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

                console.log(data);
            });

            $("#update_service").on('click',function (){
                var edit_req_no = $("#edit_req_no").val();
                var edit_vendor_id = $("#edit_vendor_id").val();
                //var edit_vendor_name = $("#edit_vendor_name").val();
                var edit_vendor_name = $("#edit_vendor_name option:selected").val();


                var edit_vendor_mobile = $("#edit_vendor_mobile").val();
                var edit_vendor_address = $("#edit_vendor_address").val();
                var edit_bill_no = $("#edit_bill_no").val();
                var edit_description = $("#edit_description").val();
                var edit_user_name = $("#edit_user_name").val();
                var edit_repair_type  = $("#edit_repair_type").val();
                var edit_item_id  = $("#edit_item_id").val();
                var edit_item_name  = $("#edit_item_name").val();
                var edit_product_serial_no  = $("#edit_product_serial_no").val();
                var edit_prev_srvc_date  = $("#edit_prev_srvc_date").val();
                var edit_cwip_id_or_main_id  = $("#edit_cwip_id_or_main_id").val();
                var edit_gl  = $("#edit_gl").val();
                var edit_cost_center  = $("#edit_cost_center").val();
                var edit_quantity  = $("#edit_quantity").val();
                var edit_unit_cost  = $("#edit_unit_cost").val();
                var edit_total_cost  = $("#edit_total_cost").val();
                var table_id  = $("#table_id").val();


                var itemArray = {};

                itemArray.edit_req_no=edit_req_no;
                itemArray.edit_vendor_id=edit_vendor_id;
                itemArray.edit_vendor_name=edit_vendor_name;
                itemArray.edit_vendor_mobile=edit_vendor_mobile;
                itemArray.edit_vendor_address=edit_vendor_address;
                itemArray.edit_bill_no=edit_bill_no;
                itemArray.edit_description=edit_description;
                itemArray.edit_user_name=edit_user_name;
                itemArray.edit_repair_type=edit_repair_type;
                itemArray.edit_item_id=edit_item_id;
                itemArray.edit_item_name=edit_item_name;
                itemArray.edit_product_serial_no=edit_product_serial_no;
                itemArray.edit_prev_srvc_date=edit_prev_srvc_date;
                itemArray.edit_cwip_id_or_main_id=edit_cwip_id_or_main_id;
                itemArray.edit_gl=edit_gl;
                itemArray.edit_cost_center=edit_cost_center;
                itemArray.edit_quantity=edit_quantity;
                itemArray.edit_unit_cost=edit_unit_cost;
                itemArray.edit_total_cost=edit_total_cost;

                var itemArrayData = JSON.stringify(itemArray);


                if(edit_req_no==''||edit_vendor_name==''||edit_vendor_name=='null'||edit_item_id==''||edit_item_name==''||edit_bill_no==''){
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Input Required Field',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/itemRepair/updateRepairItem') }}',
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
                                        window.location.reload();
                                    }
                                })
                            }
                        },
                        error: function (e) {
                            console.log("update response")
                            console.log(e);
                        }
                    });

                }



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
        });

        function deleteThisRecord(id, req_no){
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
                        type: 'delete',
                        url: '{{  url('stationery/form/itemRepair/deleteRepairdItem') }}',
                        data: { 'id':id,'req_no':req_no,'_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if(data.status == 1 || data.status == true|| data.status == 'success' ){
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



        function editThisRecord(id,requisition_no,vendor_id,vendor_name,vendor_mobile,vendor_address,bill_no,description,
                                user_name,repair_type,item_id,item_name,product_serial_no,prev_service_date,cwip_id_or_main_id,gl,
                                cost_center,quantity,total_cost,unit_cost){

            $("#edit_req_no").val(requisition_no);
            $("#edit_vendor_id").val(vendor_id);
            $("#edit_vendor_name").val(vendor_name);
            $("#edit_vendor_mobile").val(vendor_mobile);
            $("#edit_vendor_address").val(vendor_address);
            $("#edit_bill_no").val(bill_no);
            $("#edit_description").val(description);
            $("#edit_user_name").val(user_name);
            $("#edit_repair_type").val(repair_type);
            $("#edit_item_id").val(item_id);
            $("#edit_item_name").val(item_name);
            $("#edit_product_serial_no").val(product_serial_no);
            $("#edit_prev_srvc_date").val(prev_service_date);
            $("#edit_cwip_id_or_main_id").val(cwip_id_or_main_id);
            $("#edit_gl").val(gl);
            $("#edit_cost_center").val(cost_center);
            $("#edit_quantity").val(quantity);
            $("#edit_unit_cost").val(unit_cost);
            $("#edit_total_cost").val(total_cost);
            $("#table_id").val(id);

            console.log(requisition_no)


            if(vendor_name=='null'){
                $("#edit_vendor_name").select2().val("0").trigger("change");
            }else{
                $("#edit_vendor_name").select2().val(vendor_id).trigger("change");
            }

            if(requisition_no=='null'){
                $("#edit_req_no").val("");
            }else{
                $("#edit_req_no").val(requisition_no);
            }

            if(vendor_id=='null'){
                $("#edit_vendor_id").val("");
            }else{
                $("#edit_vendor_id").val(vendor_id);
            }

            if(vendor_name=='null'){
                $("#edit_vendor_name").val("");
            }else{
                $("#edit_vendor_name").val(vendor_name);
            }

            if(vendor_mobile=='null'){
                $("#edit_vendor_mobile").val("");
            }else{
                $("#edit_vendor_mobile").val(vendor_mobile);
            }

            if(vendor_address=='null'){
                $("#edit_vendor_address").val("");
            }else{
                $("#edit_vendor_address").val(vendor_address);
            }

            if(bill_no=='null'){
                $("#edit_bill_no").val("");
            }else{
                $("#edit_bill_no").val(bill_no);
            }

            if(description=='null'){
                $("#edit_description").val("");
            }else{
                $("#edit_description").val(description);
            }

            if(user_name=='null'){
                $("#edit_user_name").val("");
            }else{
                $("#edit_user_name").val(user_name);
            }

            if(repair_type=='null'){
                $("#edit_repair_type").val("");
            }else{
                $("#edit_repair_type").val(repair_type);
            }

            if(item_id=='null'){
                $("#edit_item_id").val("");
            }else{
                $("#edit_item_id").val(item_id);
            }

            if(item_name=='null'){
                $("#edit_item_name").val("");
            }else{
                $("#edit_item_name").val(item_name);
            }
            if(product_serial_no=='null'){
                $("#edit_product_serial_no").val("");
            }else{
                $("#edit_product_serial_no").val(product_serial_no);
            }


            if(prev_service_date=='null'){
                $("#edit_prev_srvc_date").val("");
            }else{
                $("#edit_prev_srvc_date").val(prev_service_date);
            }

            if(cwip_id_or_main_id=='null'){
                $("#edit_cwip_id_or_main_id").val("");
            }else{
                $("#edit_cwip_id_or_main_id").val(cwip_id_or_main_id);
            }

            if(gl=='null'){
                $("#edit_gl").val("");
            }else{
                $("#edit_gl").val(gl);
            }

            if(cost_center=='null'){
                $("#edit_cost_center").val("");
            }else{
                $("#edit_cost_center").val(cost_center);
            }

            if(unit_cost=='null'){
                $("#edit_unit_cost").val("");
            }else{
                $("#edit_unit_cost").val(unit_cost);
            }

            if(total_cost=='null'){
                $("#edit_total_cost").val("");
            }else{
                $("#edit_total_cost").val(total_cost);
            }

            if(quantity=='null'){
                $("#edit_quantity").val("");
            }else{
                $("#edit_quantity").val(quantity);
            }

            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/transferItem/getStockQty') }}',
                data: {
                    'item_id' :item_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    if(response.status == 1){
                        //$('#edit_quantity').attr('max', response.qty);
                        $('#edit_pr_qty_div p').remove();
                        $('#edit_pr_qty_div').append("<p style='text-align: center;color: #a54c48; " +
                            "font-weight: " +
                            "600;" +
                            "'>Available quantity:" +
                            " "+response
                                .qty+"</p>");
                    }else{
                        //$('#edit_quantity').removeAttr("max");
                        $('#edit_pr_qty_div p').remove();
                        $('#edit_pr_qty_div').append("<p style='text-align: center;color: red; " +
                            "font-weight: " +
                            "600;" +"'>Stock is empty</p>");
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });

            $("#editItemDisplayModal").modal('show');
        }
    </script>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection