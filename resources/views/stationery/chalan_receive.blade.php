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

    {{--select challan no and show details--}}
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" >
                <header class="panel-heading">
                    <label class="text-primary">
                        Show All Challan Details
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
                                                       class="col-md-3 col-sm-3 control-label"><b>Challan No.:</b></label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select class="form-control" id="challan_no_select_two" >


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
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div style="background-color: #5AB6DF;">
                            <p style="font-size: 13px;font-weight: bold;color: white">Challan Receive Details</p>
                        </div>
                        <div class="table-responsive">
                            <table id="challan_datatable" class="table table-striped table-bordered" style="width:100%;">
                                <thead style="background-color: #3CB371">
                                <tr style="color: white">
                                    <th class="text-center">Challan No </th>
                                    <th class="text-center">Item ID</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">SAP PR</th>
                                    <th class="text-center">SAP PO</th>
                                    <th class="text-center">SAP GL</th>
                                    <th class="text-center">SAP CC</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Expire Date</th>
                                    <th class="text-center">Product Serial</th>
                                    <th class="text-center">Warrenty Type</th>
                                    <th class="text-center">Warrenty</th>
                                    <th class="text-center">SAP CWIP Id</th>
                                    <th class="text-center">Supplier Invoice/Chalan No</th>
                                    <th class="text-center">Supplier Name</th>
                                    <th class="text-center">PR Quantity</th>
                                    <th class="text-center">Remarks</th>
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


    {{--Modal for datatable--}}
    <div id="editTypeSubtypeModal" class="modal fade" role="dialog">
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
                            <label for="cwip_id_edit" class="control-label col-sm-2">Challan No.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_challan_no" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ist_id" class="control-label col-sm-2">Item Id:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_id" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ist_name" class="control-label col-sm-2">Item Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_name" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_unit" class="control-label col-sm-2">Unit:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_unit" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">SAP Pr:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_sap_pr" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_gr_qty" class="control-label col-sm-2">SAP PO:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_sap_po" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_unit" class="control-label col-sm-2">SAP Gl:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" min="0" class="form-control" id="edit_sap_gl" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_sap_cc" class="control-label col-sm-2">SAP CC:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <select id="edit_sap_cc" name="edit_sap_cc"
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
                            <label for="edit_exist_plant" class="control-label col-sm-2">Unit Price:</label>
                            <div class="col-sm-10">
                                <input type="number"  min="0" class="form-control" id="edit_unit_price" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_split_qty" class="control-label col-sm-2">Total Price:</label>
                            <div class="col-sm-10">
                                <input type="number"  min="0" class="form-control" id="edit_total_price" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_main_id" class="control-label col-sm-2">Expire Date:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_expire_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_new_plant" class="control-label col-sm-2">Product Serial:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_product_searial" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_warrenty_type" class="control-label col-sm-2">Warrenty Type:</label>
                            <div class="col-sm-10">
                                <select id="edit_warrenty_type" name="edit_warrenty_type"
                                        class="form-control input-sm ">
                                    <option value="month" selected >Month</option>
                                    <option value="year" >Year</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="edit_new_plant" class="control-label col-sm-2">Warrenty:</label>
                            <div class="col-sm-10">
                                <input type="number" min="0" class="form-control" id="edit_warrenty" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_new_plant" class="control-label col-sm-2">SAP CWIP Id:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" min="0" class="form-control" id="edit_sap_cwip_id" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_new_plant" class="control-label col-sm-2">Supplier Invc or Challan No.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" min="0" class="form-control" id="edit_supp_inv_or_chal_no" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_new_plant" class="control-label col-sm-2">Supplier Name:</label>
                            <div class="col-sm-10">

                                <select id="edit_supplier_name" name="edit_supplier_name"
                                        class="form-control input-sm ">
                                    <option value="0" selected >Select Supplier Name</option>
                                    @if($supplier_name)
                                        @foreach($supplier_name as $supplier_names)
                                            <option value="{{$supplier_names->name}}"  >{{$supplier_names->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_new_plant" class="control-label col-sm-2">Product Quantity:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" min="0"  class="form-control" id="edit_pr_qty" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_new_plant" class="control-label col-sm-2">Remarks:</label>
                            <div class="col-sm-10">
                                <input type="text" min="0" class="form-control" id="edit_remarks" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="update_cwip_details">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--Form Details and Master Data--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <section class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <label class="text-default">
                                Challan Receive
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{--Input Challan Master data and details data--}}
            <div class="panel-body" style="padding-top: 2%">

                {{--Input Challan Master Data--}}
                <div style="font-weight: bold">
                    <p> Input Challan Master Data <span style="color: red;font-size: 12px">*(Fields are required)</span> </p>
                </div>
                <form action="#" method="post" id="item_issue_form">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">Challan No <span class='cls-req'>*</span></th>
                                <th class="text-center">SAP PR <span class='cls-req'>*</span></th>
                                <th class="text-center">SAP PO <span class='cls-req'>*</span></th>
                                <th class="text-center">Supplier Invoice/Challan No.<span class='cls-req'>*</span></th>
                                <th class="text-center">Supplier Name</th>
                                <th class="text-center">Remarks</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <tr>
                                <td  id ='challan_warning'>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="challan_no_master"
                                           placeholder="" name="challan_no_master">

                                </td>

                                <td>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="sap_pr"
                                           placeholder="" name="sap_pr">
                                </td>
                                <td>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="sap_po"
                                           placeholder="" name="sap_po">
                                </td>
                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="supp_invoice_or_chalan_no"
                                           placeholder="" name="supp_invoice_or_chalan_no">
                                </td>
                                <td>
                                    <select id="supplier_name" name="supplier_name"
                                            class="form-control input-sm ">
                                        <option value="" selected >Select Supplier Name</option>

                                        @if($supplier_name)
                                            @foreach($supplier_name as $supplier_names)
                                                <option value="{{$supplier_names->name}}"  >{{$supplier_names->name}}</option>
                                            @endforeach
                                        @endif

                                    </select>

                                </td>
                                <td>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="remarks"
                                           placeholder="" name="remarks">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <input type="button" id="add_details_info"  value="Add Details Data" class="btn btn-info">
                </form>

                {{--Input Challan Details Data--}}
                <form action="#" method="post" id="item_details_form" style="display: none">
                    <div style="font-weight: bold; margin-top: 20px" >
                        <p> Input Challan Details Data</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">Challan No <span class='cls-req'>*</span></th>
                                <th class="text-center">Item ID <span class='cls-req'>*</span></th>
                                <th class="text-center">Item Name <span class='cls-req'>*</span></th>
                                <th class="text-center">Unit<span class='cls-req'>*</span></th>
                                <th class="text-center">Quantity<span class='cls-req'>*</span></th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Expire Date</th>
                                <th class="text-center">Select Warranty</th>
                                <th class="text-center">Warranty</th>
                                <th class="text-center">SAP CWIP ID<span class='cls-req'>*</span></th>
                                <th class="text-center">SAP GL<span class='cls-req'>*</span></th>
                                <th class="text-center">SAP CC<span class='cls-req'>*</span></th>
                                <th class="text-center">Product Serial</th>

                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <tr>
                                <td>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="challan_no_details"
                                           placeholder="" name="challan_no_details" >
                                </td>
                                <td>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="item_id_d"
                                           placeholder="" name="item_id_d" onfocus="this.value=''">
                                </td>
                                <td id="border_change_name">
                                    <select id="item_name_d" name="item_name_d"
                                            class="form-control input-sm ">
                                        <option value="" selected >Select Item Name</option>
                                        @if($item_name)
                                            @foreach($item_name as $name)
                                                <option value="{{ $name->item_id}}">{{$name->item_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="unit_d"
                                           placeholder="" name="unit_d" onfocus="this.value=''">
                                </td>
                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="quantity_d"
                                           placeholder=""  min="0" name="quantity_d" onfocus="this.value=''">
                                </td>


                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="unit_price_d"
                                           placeholder=""  min="0" name="unit_price_d" onfocus="this.value=''">
                                </td>
                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="total_price_d"
                                           placeholder=""  min="0" name="total_price_d" onfocus="this.value=''">
                                </td>
                                <td>
                                    <input type="text" name="expire_date_d" id="expire_date_d" class="form-control datepicker" placeholder="Select Date"/>
                                </td>
                                <td>
                                    <select id="warrenty_d_type" name="warrenty_d_type"
                                            class="form-control input-sm ">
                                        <option value="month" selected >Month</option>
                                        <option value="year"  >Year</option>

                                    </select>
                                </td>

                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" min="0" id="warrenty_d">

                                </td>
                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="sap_cwip_id_d"
                                           placeholder="" name="sap_cwip_id_d" onfocus="this.value=''">
                                </td>

                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="sap_gl_d"  min="0"
                                           placeholder="" name="sap_gl_d" onfocus="this.value=''">
                                </td>

                                <td style="width: 200px !important;" id="border_change_cc">
                                    <select id="sap_cc_d" name="sap_cc_d"
                                            class="form-control input-sm ">
                                        <option value="" selected >Select SAP Cost Center</option>

                                        @if($cost_center_id_name)
                                            @foreach($cost_center_id_name as $id_name)
                                                <option value="{{$id_name->cost_center_id}}"  >{{$id_name->cost_center_name}}-{{$id_name->cost_center_id}}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </td>
                                <td>
                                    <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                           class="form-control input-xs" id="product_serial_d"
                                           placeholder="" name="product_serial_d" min="1" onfocus="this.value=''">
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="button"  class="add-row btn btn-info" value="Add To Submit">

                </form>
            </div>

            {{--Challan receive submit form --}}
            <div class="panel-body" style="margin-top:20px" id="display_data">
                <form action="#" method="post" id="issue_item_form">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="issueTable">
                            <thead>
                            <tr>
                                <th class="text-center">Select Item </th>
                                <th class="text-center">Challan No </th>
                                <th class="text-center">Item ID</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">SAP PR</th>
                                <th class="text-center">SAP PO</th>
                                <th class="text-center">SAP GL</th>
                                <th class="text-center">SAP CC</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Expire Date</th>
                                <th class="text-center">Product Serial</th>
                                <th class="text-center">Warrenty Unit</th>
                                <th class="text-center">Warrenty</th>
                                <th class="text-center">SAP CWIP Id</th>
                                <th class="text-center">Supplier Invoice/Chalan No</th>
                                <th class="text-center">Supplier Name</th>
                                <th class="text-center">PR Quantity</th>
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>


<script type="text/javascript">
    var edit_challan_it_name

    $(function(){
        $('.datepicker').datepicker({
            format: "dd-M-yyyy",
            todayHighlight: 'TRUE',
            autoclose: true,
            minDate: '0',
            maxDate: '+1Y+6M'

        });
    });

    $(document).ready(function () {

        var challan_it_name;

        $('#item_name_d').select2();
        $('#sap_cc_d').select2();
        $('#supplier_name').select2();

        $('#challan_no_master').on('change keyup', function () {
            $('#challan_warning > p').html("");

            var challan_no_master = $("#challan_no_master").val();

            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/chalan/checkChallanNo') }}',
                data: {
                    'challan_no_master': challan_no_master,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    console.log("sayla test")
                    console.log(response)

                    if (response.status == 'true') {
                       /* Swal.fire({
                            title: 'Warning!',
                            text: 'Opps! Challan Number Already Exists',
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        })*/


                        $("#challan_no_master").val('');
                        $('#challan_warning').append('<p style="color: red">Already Exists</p>');
                        return 0;

                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });

            if(challan_no_master != ''){
                $('#challan_no_master').css("border", "1px solid #ccc");
                $('#challan_no_details').val(challan_no_master);

            }



        })
        $('#supp_invoice_or_chalan_no').on('change keyup', function () {
            var supp_invoice_or_chalan_no = $("#supp_invoice_or_chalan_no").val();
            if(supp_invoice_or_chalan_no != ''){
                $('#supp_invoice_or_chalan_no').css("border", "1px solid #ccc");
            }

        })

        $("#sap_pr").keyup(function (){
            var sap_pr = $("#sap_pr").val();
            if(sap_pr != ''){
                $('#sap_pr').css("border", "1px solid #ccc");
            }

        })
        $("#sap_po").keyup(function (){
            var sap_po = $("#sap_po").val();
            if(sap_po != ''){
                $('#sap_po').css("border", "1px solid #ccc");
            }

        })


   /*     $("#item_name_d").change(function (){
            var item_name_d =  $("#item_name_d").val();
            if(item_name_d != ''){
                $('#border_change_name .select2-container ').css("border", "1px solid #ccc");
            }
        })

        $('#sap_cc_d').on('change', function () {
            var sap_cc_d =  $("#sap_cc_d").val();
            if(sap_cc_d != ''){
                $('#border_change_cc .select2-container ').css("border", "1px solid #ccc");
            }
        })

        $('#sap_gl_d').on('change', function () {
            var sap_gl_d =  $("#sap_gl_d").val();
            if(sap_gl_d != ''){
                $('#sap_gl_d').css("border", "1px solid #ccc");
            }
        })


        $('#sap_cwip_id_d').on('change', function () {
            var sap_cwip_id_d =  $("#sap_cwip_id_d").val();
            if(sap_cwip_id_d != ''){
                $('#sap_cwip_id_d').css("border", "1px solid #ccc");
            }
        })
*/


        /*Total cost calculation*/
        $("#unit_price_d,#quantity_d").on('keyup keydown mouseenter change',function () {
            var total_price_d;
            var unit_price_d = $('#unit_price_d').val();
            var quantity_d = $('#quantity_d').val();

            if(unit_price_d && quantity_d){
                 total_price_d = unit_price_d*quantity_d;
                $("#total_price_d").val(total_price_d)
            }else if(unit_price_d=='' || quantity_d==''){
                total_price_d='';
                $("#total_price_d").val(total_price_d)
            }
        });


        /*Add Details Button Click*/
        $("#add_details_info").click(function (){
            var challan_no = $('#challan_no_master').val();
            var sap_pr = $("#sap_pr").val();
            var sap_po = $("#sap_po").val();
            var supp_invoice_or_chalan_no = $("#supp_invoice_or_chalan_no").val();
            var supplier_name= $("#supplier_name option:selected" ).val();
            var remarks = $("#remarks").val();

            if(challan_no==''||sap_pr==''||sap_po==''||supp_invoice_or_chalan_no==''){

                if(challan_no==''){
                    $('#challan_no_master').css("border", "1px solid red");
                }
                if(sap_pr==''){
                    $('#sap_pr').css("border", "1px solid red");
                }
                 if(sap_po==''){
                    $('#sap_po').css("border", "1px solid red");
                }
                if(supp_invoice_or_chalan_no==''){
                    $('#supp_invoice_or_chalan_no').css("border", "1px solid red");
                }


                Swal.fire({
                    title: 'Warning!',
                    text: 'Please Input Required Field',
                    icon: 'warning',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok'
                })
                return 0;
            }else{
                $("#item_details_form").css("display","block")
                var challanNo = $('#challan_no_master').val();
                $('#challan_no_details').val(challanNo);
                $('#challan_no_details').attr('readonly', true);

            }
        });

        /* Onselect Item Name*/
        $('#item_name_d').change(function () {
            var item_id =   $("#item_name_d option:selected" ).val();
            $('#item_id_d').val(item_id);
            $('#item_id_d').attr('readonly', true);
            var item_id = $("#item_name_d option:selected" ).val();
            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/chalan/getProductItName') }}',
                data: {
                    'item_id': item_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {

                    challan_it_name = response.status[0]['it_name'];

                    if (challan_it_name) {
                        if(challan_it_name=='CAPEX'){
                            $('#sap_cwip_id_d').attr('readonly', false);

                        }else if(challan_it_name=='STATIONERY'){
                            $('#sap_cwip_id_d').attr('readonly', true);
                        }

                    }

                },
                error: function (e) {
                    console.log(e);
                }
            });

        });

        /*Add row on button click*/
        $(".add-row").click(function(){


            var challan_no_master = $("#challan_no_master").val();

            var challan_no = $("#challan_no_details").val();
            var item_id_d = $("#item_id_d").val();
            var item_name_d = $("#item_name_d option:selected" ).text();
            var quantity_d = $("#quantity_d").val();
            var unit_price_d = $("#unit_price_d").val();
            var total_price_d = $("#total_price_d").val();
            var expire_date_d = $("#expire_date_d").val();
            var warrenty_d = $("#warrenty_d").val();
            var warrenty_d_type = $("#warrenty_d_type option:selected" ).val();
            var sap_cwip_id_d = $("#sap_cwip_id_d").val();
            var sap_gl_d = $("#sap_gl_d").val();
            var sap_cc_d = $("#sap_cc_d option:selected").val();
            var product_serial_d = $("#product_serial_d").val();
            var unit_d = $("#unit_d").val();


            /*Master Table Data*/

            var supplier_name= $("#supplier_name option:selected").text();
            if(supplier_name=='Select Supplier Name'){
                supplier_name='';
            }

            var remarks = $("#remarks").val();
            var sap_pr = $("#sap_pr").val();
            var sap_po = $("#sap_po").val();
            var supp_invoice_or_chalan_no = $("#supp_invoice_or_chalan_no").val();



            if((challan_no==''||item_name_d=='Select Item Name'||item_id_d==''||unit_d==''||item_name_d==''||quantity_d==''||sap_gl_d==''||sap_cc_d=='')||
                (sap_cwip_id_d==''&& challan_it_name=='CAPEX')){

              /*  if(challan_no==''){
                    $('#challan_no_details').css("border", "1px solid red");
                }
                if(item_name_d=='Select Item Name'){
                    $('#border_change_name .select2-container ').css("border", "1px solid red");
                }
                if(sap_cwip_id_d=='' && challan_it_name=='CAPEX'){
                    $('#sap_cwip_id_d').css("border", "1px solid red");
                }
                if(sap_gl_d==''){
                    $('#sap_gl_d').css("border", "1px solid red");
                }
                if(sap_cc_d==''){

                    $('#border_change_cc .select2-container ').css("border", "1px solid red");
                }


*/
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please Input Required Field',
                    icon: 'warning',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok'
                })
                return 0;
            }

            var markup = "<tr><td><input type='checkbox' name='record' id='record'></td><td>"+challan_no+"</td><td>"+item_id_d+"</td><td>"+item_name_d+"</td><td>"+unit_d+"</td><td>"+sap_pr+"</td><td>"
                +sap_po+"</td><td>"+sap_gl_d+"</td><td>"+sap_cc_d+"</td><td>"+unit_price_d+"</td><td>"+total_price_d+"</td><td>"+expire_date_d+"</td><td>"+product_serial_d+"</td><td>"
                +warrenty_d_type+"</td><td>"+warrenty_d+"</td><td>"+sap_cwip_id_d+"</td><td>"+supp_invoice_or_chalan_no+"</td><td>"+supplier_name+"</td><td>"+quantity_d+"</td><td>"+remarks+"</td></tr>";

            var delete_button ="<input type='button' value='Delete'>"

            $("#display_data table tbody").append(markup);

            $("#delete_button").css("display","inline-block");
            $("#submit_button").css("display","inline-block");

            $("#item_id_d").val("");
            $("#sap_cwip_id_d").val("");
            $("#sap_gl_d").val("");
            $("#unit_d").val("");
            $("#warrenty_d").val("");

            $('#sap_cc_d').val('0');
            $('#sap_cc_d').trigger('change');

            $('#item_name_d').val('0');
            $('#item_name_d').trigger('change');



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
        // Save Received Challan
        $("#submit_button").click(function(){

            var itemArrayMaster={} ;
            var challan_no = $("#challan_no_master").val();
            var sap_pr = $("#sap_pr").val();
            var sap_po = $("#sap_po").val();
            var supp_invoice_or_chalan_no = $("#supp_invoice_or_chalan_no").val();
            var supplier_name = $("#supplier_name").val();
            var remarks = $("#remarks").val();


            /*if(challan_no==''||sap_pr==''||sap_po==''||item_name_d=='Select Item Name'){

                if(challan_no==''){
                    $('#challan_no_master').css("border", "1px solid red");
                }
                if(sap_pr==''){
                    $('#sap_pr').css("border", "1px solid red");
                }
                if(sap_po==''){
                    $('#sap_po').css("border", "1px solid red");
                }
                if(item_name_d=='Select Item Name'){
                    $('#item_name_d').css("border", "1px solid red");
                }

                Swal.fire({
                    title: 'Warning!',
                    text: 'Please Input Required Field',
                    icon: 'warning',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok'
                })
                return 0;
            }
*/



            itemArrayMaster.challan_no=challan_no;
            itemArrayMaster.sap_pr=sap_pr;
            itemArrayMaster.sap_po=sap_po;
            itemArrayMaster.sup_invoice_or_ch_no=supp_invoice_or_chalan_no;
            itemArrayMaster.supplier_name=supplier_name;
            itemArrayMaster.remarks=remarks;


            var itemArrayDetails = [];

            $("#issueTable tbody tr").each(function () {
                var challanItemData = {};

                var self = $(this);

                var challan_no = self.find("td:eq(1)").text().trim();
                var item_id = self.find("td:eq(2)").text().trim();
                var item_name = self.find("td:eq(3)").text().trim();
                var unit = self.find("td:eq(4)").text().trim();
                var sap_pr = self.find("td:eq(5)").text().trim();
                var sap_po = self.find("td:eq(6)").text().trim();
                var sap_gl = self.find("td:eq(7)").text().trim();
                var sap_cc = self.find("td:eq(8)").text().trim();
                var unit_price = self.find("td:eq(9)").text().trim();
                var total_price = self.find("td:eq(10)").text().trim();
                var expire_date = self.find("td:eq(11)").text().trim();
                var product_serial = self.find("td:eq(12)").text().trim();
                var warrenty_unit = self.find("td:eq(13)").text().trim();
                var warrenty = self.find("td:eq(14)").text().trim();
                var sap_cwip_id = self.find("td:eq(15)").text().trim();
                var sup_invoice_or_ch_no = self.find("td:eq(16)").text().trim();
                var supplier_name = self.find("td:eq(17)").text().trim();
                var pr_qty = self.find("td:eq(18)").text().trim();
                var remarks = self.find("td:eq(19)").text().trim();



                challanItemData.challan_no = challan_no;
                challanItemData.item_id = item_id;
                challanItemData.item_name = item_name;
                challanItemData.unit = unit;
                challanItemData.sap_pr = sap_pr;
                challanItemData.sap_po = sap_po;
                challanItemData.sap_gl = sap_gl;
                challanItemData.sap_cc = sap_cc;
                challanItemData.unit_price = unit_price;
                challanItemData.total_price = total_price;
                challanItemData.expire_date = expire_date;
                challanItemData.product_serial = product_serial;
                challanItemData.warrenty_unit = warrenty_unit;
                challanItemData.warrenty = warrenty;
                challanItemData.sap_cwip_id = sap_cwip_id;
                challanItemData.sup_invoice_or_ch_no = sup_invoice_or_ch_no;
                challanItemData.supplier_name = supplier_name;
                challanItemData.qty = pr_qty;
                challanItemData.remarks = remarks;


                itemArrayDetails.push(challanItemData);

            });


            var itemArrayDetailsData = JSON.stringify(itemArrayDetails);

            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/chalan/saveReceivedChallan') }}',
                data: {
                    'challanReceiveMaster': itemArrayMaster,  'challanReceiveDetails': itemArrayDetailsData,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    if ( response == 1 || response == 'success') {
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                            text: 'Item saved successfully',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                        $("#item_issue_form").trigger('reset');
                        item_id = $('#item_id').val('');
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something was wrong! Challan creation failed.',
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

        /*  Select two val of challan no.*/
        var data;
        $('#challan_no_select_two').select2({
            placeholder: 'Select Challan No.',
            ajax: {
                url: '{{  url('stationery/form/chalan/getChallanNo') }}',
                method:'get',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data.challan_no, function (item) {
                            return {
                                text: item.challan_no,
                                id: item.challan_no
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

            var challan_no = $('#challan_no_select_two').select2("val");
            data = { challan_no:challan_no,"_token": "{{ csrf_token() }}"};
            $.ajax({
                type: "get",
                dataType: 'json',
                data: data,
                url: "{{ url('stationery/form/chalan/getChallanDetails') }}",
                success: function (resp) {

                    $("#loader").hide();
                    $("#report-body").show();


                    $("#challan_datatable").DataTable().destroy();
                    table = $("#challan_datatable").DataTable({
                        data: resp,
                        autoWidth: true,
                        columns: [
                            {data: "challan_no"},
                            {data: "item_id"},
                            {data: "item_name"},
                            {data: "unit"},
                            {data: "sap_pr"},
                            {data: "sap_po"},
                            {data: "sap_gl"},
                            {data: "sap_cc"},
                            {data: "unit_price"},
                            {data: "total_price"},
                            {data: "expire_date"},
                            {data: "product_serial"},
                            {data: "warranty_unit"},
                            {data: "warrenty"},
                            {data: "sap_cwip_id"},
                            {data: "sup_invoice_or_ch_no"},
                            {data: "supplier_name"},
                            {data: "qty"},
                            {data: "remarks"},
                            { data: null,
                                orderable: false,
                                'render': function (data, type, row) {
                                    return '<button class=\"btn btn-sm btn-info row-edit ' +
                                        'dt-center\" id="' + row.id +'" ' +
                                        'onclick="editThisRecord('+"'"+row.id+"','"+row.challan_no+"','"+row.item_id+"','"+row.item_name+"','"+row.unit+"','"+row.sap_pr+"','"+row.sap_po+"','"+row.sap_gl+"','"+row.sap_cc+"','"
                                        +row.unit_price+"','"+row.total_price+"','"+row.expire_date+"','"+row.product_serial+"','"+row.warrenty_type+"','"+row.warrenty+"','"+row.sap_cwip_id+"','"+row.sup_invoice_or_ch_no+"','"+row.supplier_name+"'," +
                                        "'"+row.qty+"','"+row.remarks+"')"+'">EDIT</button>'
                                }
                            },

                            {
                                data: null,
                                orderable: false,
                                'render': function (data, type, row) {
                                    return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                        'dt-center\" id="' + row.id +'" ' +
                                        'onclick="deleteThisRecord('+"'"+row.id+"','"+row.challan_no+"')"+'">Delete</button>'
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
        //update item
        $("#update_cwip_details").on('click',function (){

            var edit_challan_no =  $("#edit_challan_no").val();


            var edit_item_id =  $("#edit_item_id").val();
            var edit_item_name = $("#edit_item_name").val();
            var edit_sap_pr =    $("#edit_sap_pr").val();
            var edit_sap_po =    $("#edit_sap_po").val();
            var edit_sap_gl =    $("#edit_sap_gl").val();
            var edit_sap_cc =    $("#edit_sap_cc option:selected").val();
            var edit_unit_price =    $("#edit_unit_price").val();
            var edit_total_price =   $("#edit_total_price").val();
            var edit_expire_date =   $("#edit_expire_date").val();
            var edit_unit =   $("#edit_unit").val();
            var edit_product_searial =   $("#edit_product_searial").val();
            var edit_warrenty =    $("#edit_warrenty").val();
            var edit_warrenty_unit = $('#edit_warrenty_type').find(":selected").val();
            if(!edit_warrenty_unit){
                edit_warrenty_unit='';
            }
            var edit_sap_cwip_id =  $("#edit_sap_cwip_id").val();
            var edit_supp_inv_or_chal_no = $("#edit_supp_inv_or_chal_no").val();
        /*    var edit_supplier_name = $("#edit_supplier_name").val();*/
            var edit_supplier_name = $('#edit_supplier_name').find(":selected").val();
            var edit_pr_qty = $("#edit_pr_qty").val();
            var edit_remarks = $("#edit_remarks").val();
            var table_id  = $("#table_id").val();
            var edit_warrenty  = $("#edit_warrenty").val();

            var itemArray = {};

            itemArray.edit_challan_no=edit_challan_no;
            itemArray.edit_item_id=edit_item_id;
            itemArray.edit_item_name=edit_item_name;
            itemArray.edit_unit=edit_unit;
            itemArray.edit_sap_pr=edit_sap_pr;
            itemArray.edit_sap_po=edit_sap_po;
            itemArray.edit_sap_gl=edit_sap_gl;
            itemArray.edit_sap_cc=edit_sap_cc;
            itemArray.edit_unit_price=edit_unit_price;
            itemArray.edit_total_price=edit_total_price;
            itemArray.edit_expire_date=edit_expire_date;
            itemArray.edit_product_searial=edit_product_searial;
            itemArray.edit_warrenty=edit_warrenty;
            itemArray.edit_warrenty_unit=edit_warrenty_unit;
            itemArray.edit_sap_cwip_id=edit_sap_cwip_id;
            itemArray.edit_supp_inv_or_chal_no=edit_supp_inv_or_chal_no;
            itemArray.edit_supplier_name=edit_supplier_name;
            itemArray.edit_pr_qty=edit_pr_qty;
            itemArray.edit_remarks=edit_remarks;

            var itemArrayData = JSON.stringify(itemArray);


            if(edit_challan_no==''||edit_item_id==''||edit_item_name==''||edit_sap_pr==''||edit_supplier_name==''||edit_pr_qty==''||edit_unit==''||
                edit_sap_po==''||edit_sap_gl==''||edit_sap_cc==''||edit_supp_inv_or_chal_no==''||(edit_challan_it_name==='CAPEX' && edit_sap_cwip_id=='')) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please Input Required Field',
                    icon: 'warning',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok'
                })
                return 0;

            }else{
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/chalan/updateChallanReceive') }}',
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

                        console.log(e);
                    }
                });
            }
        })

        });


    function editThisRecord(id,challan_no,item_id,item_name,unit,sap_pr,sap_po,sap_gl,sap_cc,unit_price,total_price,expire_date,product_serial,warrenty_unit,warrenty,
                            sap_cwip_id,sup_invoice_or_ch_no,supplier_name,qty,remarks){

        $("#edit_sap_cc").select2().val(sap_cc).trigger("change");



        $("#table_id").val(id);

        if(challan_no=='null'){
            $("#edit_challan_no").val("");
        }else{
            $("#edit_challan_no").val(challan_no);
        }

        if(unit=='null'){
            $("#edit_unit").val("");
        }else{
            $("#edit_unit").val(unit);
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

        if(sap_pr=='null'){
            $("#edit_sap_pr").val("");
        }else{
            $("#edit_sap_pr").val(sap_pr);
        }

        if(sap_po=='null'){
            $("#edit_sap_po").val("");
        }else{
            $("#edit_sap_po").val(sap_po);
        }
        if(sap_gl=='null'){
            $("#edit_sap_gl").val("");
        }else{
            $("#edit_sap_gl").val(sap_gl);
        }



       if(sap_cc=='null'||sap_cc==''){
           $("#edit_sap_cc").select2().val("").trigger("change");

        }else{

           $("#edit_sap_cc").select2().val(sap_cc).trigger("change");

        }

        if(unit_price=='null'){
            $("#edit_unit_price").val("");

        }else{
            $("#edit_unit_price").val(unit_price);
        }

        if(total_price=='null'){
            $("#edit_total_price").val("");

        }else{
            $("#edit_total_price").val(total_price);
        }
        if(expire_date=='null'){
            $("#edit_expire_date").val("");
        }else{
            $("#edit_expire_date").val(expire_date);
        }
        if(product_serial=='null'){
            $("#edit_product_searial").val("");
        }else{
            $("#edit_product_searial").val(product_serial);
        }

        if(warrenty=='null'){
            $("#edit_warrenty").val("");
        }else{
            $("#edit_warrenty").val(warrenty);
        }

        if(warrenty_unit=='null'){

            $("#edit_warrenty_type option[value='']").attr('selected', 'selected');
        }else{
            $("#edit_warrenty_type option[value="+warrenty_unit+"]").attr('selected', 'selected');
        }

        if(sap_cwip_id=='null'){
            $("#edit_sap_cwip_id").val("");
        }else{
            $("#edit_sap_cwip_id").val(sap_cwip_id);
        }

        if(sup_invoice_or_ch_no=='null'){
            $("#edit_supp_inv_or_chal_no").val("");

        }else{
            $("#edit_supp_inv_or_chal_no").val(sup_invoice_or_ch_no);

        }

        $("#edit_supplier_name").select2().val(supplier_name).trigger("change");

        if(qty=='null'){
            $("#edit_pr_qty").val("");

        }else{
            $("#edit_pr_qty").val(qty);
        }

        if(remarks=='null'){
            $("#edit_remarks").val("");
        }else{
            $("#edit_remarks").val(remarks);
        }

        $.ajax({
            type: 'post',
            url: '{{  url('stationery/form/chalan/getProductItName') }}',
            data: {
                'item_id': item_id,
                '_token': "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response.status[0].it_name)

                edit_challan_it_name = response.status[0].it_name

                if (edit_challan_it_name) {
                    if(edit_challan_it_name=='CAPEX'){
                        $('#edit_sap_cwip_id').attr('readonly', false);

                    }else if(edit_challan_it_name=='STATIONERY'){

                        $('#edit_sap_cwip_id').attr('readonly', true);
                    }

                }

            },
            error: function (e) {
                console.log(e);
            }
        });


        $("#editTypeSubtypeModal").modal('show');
    }

    function deleteThisRecord(id,challan_no){

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete  it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'delete',
                    url: '{{  url('stationery/form/chalan/deleteChalanReceive') }}',
                    data: { 'id':id,'challan_no':challan_no, '_token': "{{ csrf_token () }}"},
                    success: function (data) {

                        if(data.status == "success"){
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