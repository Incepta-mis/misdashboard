@extends('_layout_shared._master')
@section('title','Insert Item Destruction Information')
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

        .cls-req{
            color: red;
            font-weight: bold;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .help-block {
            color: red;
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
        .select2-container--default .select2-selection--single{
            border-radius: 0px;
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
        #upload_file{
            outline: none;
            padding: 2px 2px 2px 7px;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-warning">
                <div class="panel-heading">
                    <label class="text-default">
                        Item Destruction Report
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="srvc_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Service ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="srvc_id" name="srvc_id"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled>Select Service ID</option>
                                                    <option value="All">All</option>
                                                    @foreach($services as $c)
                                                        <option value="{{$c->service_id}}">{{$c->service_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_submit1" class="btn btn-warning btn-sm">
                                                <i class="fa fa-chevron-circle-up"></i> <b>&nbsp;Display
                                                    Report</b></button>
                                        </div>
                                        <div class="col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-2 col-xs-6">
                                            <div id="export_buttons">
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
        <div class="col-md-12 col-sm-12">
            <div id="showTable" style="display: none;">
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 table-responsive">
                                <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                    <thead style="background-color: darkkhaki;">
                                    <tr>
                                        <th>Service Id</th>
                                        <th>Item Id</th>
                                        <th>Item Name</th>
                                        <th>Main Id</th>
                                        <th>CWIP Id</th>
                                        <th>GL</th>
                                        <th>Cost Center</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Unit Price</th>
                                        <th>Origin Plant</th>
                                        <th>Username</th>
                                        <th>Department</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Created at</th>
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
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-default">
                                Insert Item Destruction Information
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 2%">
                    <div style="color: red;font-weight: bold">
                        <p>*(Fields are required)</p>
                    </div>
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="com_code"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Company Code</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="{{$companyData[0]->sap_com_id}}" name="com_code"
                                                       id="com_code" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="com_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Company Name</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="{{$companyData[0]->com_name}}" name="com_name"
                                                       id="com_name" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <label for="plant_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant ID<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="plant_id" name="plant_id"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select Plant</option>
                                                    @foreach($plants as $i)
                                                        <option value="{{$i->plant_id}}">{{$i->plant_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="item_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item ID<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose an item" name="item_id"
                                                       id="item_id" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="item_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item Name<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="item_name" name="item_name"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select Item</option>
                                                    @foreach($item_data as $i)
                                                        <option value="{{$i->item_id}}">{{$i->item_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="main_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Main ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a main ID" name="main_id"
                                                       id="main_id">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="cwip_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>CWIP ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a CWIP ID" name="cwip_id"
                                                       id="cwip_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="gl" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>GL</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input GL" name="gl"
                                                       id="gl" >
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="cost_center" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Cost Center</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="cost_center" name="cost_center"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected>Select a Cost center</option>
                                                    @foreach($costCenter as $cc)
                                                        <option value="{{$cc->cost_center_id}}">{{$cc->cost_center_id}} - {{$cc->cost_center_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="qty"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Quantity<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9" id="pr_qty_div">
                                                <input type="number" class="form-control input-sm"
                                                       value="1" min="1" name="qty"
                                                       id="qty" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="unit" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Unit<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a unit" name="unit"
                                                       id="unit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="unit_price" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Unit Price<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="number" class="form-control input-sm"
                                                       value="" placeholder="Input a unit price" name="unit_price"
                                                       id="unit_price" value="1" min="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="origin_plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Origin Plant<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input origin plant" name="origin_plant"
                                                       id="origin_plant">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="username" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Username</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a Username" name="username"
                                                       id="username">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Department<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="dept" name="dept"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="reason" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Reason<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a reason" name="reason"
                                                       id="reason">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="status" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Status<span class='cls-req'>*</span></b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a status" name="status"
                                                       id="status">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="remarks" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Remarks</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input Remarks" name="remarks"
                                                       id="remarks">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                            <button type="button" id="btn_submit" class="btn btn-success btn-sm"
                                                    style="float: right;">
                                                <i class="fa fa-chevron-circle-up"></i> &nbsp;<b>Submit</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div id="editItemDestructModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Item Id:</label>
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
                            <label for="edit_main_id" class="control-label col-sm-2">Main ID:</label>
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
                            <label for="edit_gl" class="control-label col-sm-2">GL:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_gl" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_cost_center" class="control-label col-sm-2">Cost Center:</label>
                            <div class="col-sm-10" id="edit_cost_center_div">
                                <input type="text" class="form-control" id="edit_cost_center" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_qty" class="control-label col-sm-2">Quantity<span class='cls-req'>*</span></label>
                            <div class="col-sm-10" id="edit_pr_qty_div">
                                <input type="number" class="form-control input-sm" value="" min="1" id="edit_qty"
                                       value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_unit" class="control-label col-sm-2">Unit<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_unit" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_unit_price" class="control-label col-sm-2">Unit Price<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="edit_unit_price" value="" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_origin_plant" class="control-label col-sm-2">Origin Plant<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_origin_plant" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_username" class="control-label col-sm-2">Username<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_username" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_dept" class="control-label col-sm-2">Department</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_dept" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_reason" class="control-label col-sm-2">Reason<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_reason" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_status" class="control-label col-sm-2">Status<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_status" value="">
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
                                <button type="button" class="btn btn-info" id="update_info">Update</button>
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#cost_center').select2();
            var date = new Date();

            $('#rdate').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#item_name').select2();
            $('#dept').select2();
            $('#plant_id').select2();
            $('#srvc_id').select2();

            $('#plant_id').change(function () {

                $('#dept').empty();
                $('#dept').append($('<option></option>').html('Loading...'));

                var plant_id = $('#plant_id').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('elm_portal/getDepts') }}',
                    data: {'plant_id': plant_id},
                    success: function (data) {
                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            for (var i = 0; i < data.dept.length; i++) {
                                op += '<option value= " ' + data.dept[i]['dept_id'] + ' ">' + data.dept[i]['dept_name'] + '</option>';
                            }
                            $('#dept').html("");
                            $('#dept').append(op);
                        }else {
                            $('#dept').html("");
                            $('#dept').append('<option value="0" selected disabled>No employee tagged under any ' +
                                'department of the selected plant. ' +
                                'Category</option>');
                        }
                    },
                    error: function () {
                    }
                });
            });

            $('#item_name').change(function () {
                var item_id = $(this).val();
                $('#item_id').val(item_id);

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/transferItem/getStockQty') }}',
                    data: {
                        'item_id' :item_id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if(response.status == 1){
                            $('#qty').attr('max', response.qty);
                            $('#pr_qty_div p').remove();
                            $('#pr_qty_div').append("<p style='text-align: center;color: #a54c48; " +
                                "font-weight: " +
                                "600;" +
                                "'>Available quantity:" +
                                " "+response
                                    .qty+"</p>");
                        }else{
                            $('#qty').removeAttr("max");
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

            $('#main_id').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#cwip_id').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#cost_center').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#unit').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#origin_plant').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#btn_submit1').on('click', function (e) {

                $("#loader").css('display','block');
                var service_id = $('#srvc_id').val();
                var table = null;

                if(service_id != null){
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/getItemDestReport') }}',
                        data: { 'service_id': service_id, '_token': "{{ csrf_token() }}"},
                        success: function (data) {
                            $("#showTable").css('display','block');
                            $("#loader").css('display','none');

                            $("#elr").DataTable().destroy();

                            table = $("#elr").DataTable({
                                data: data,
                                columns: [
                                    {data: "service_id"},
                                    {data: "item_id"},
                                    {data: "item_name"},
                                    {data: "main_id"},
                                    {data: "cwip_id"},
                                    {data: "gl"},
                                    {data: "cost_center"},
                                    {data: "qty"},
                                    {data: "unit"},
                                    {data: "unit_price"},
                                    {data: "origin_plant"},
                                    {data: "user_name"},
                                    {data: "department"},
                                    {data: "reason"},
                                    {data: "status"},
                                    {data: "remarks"},
                                    {data: "create_date"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return '<button class=\"btn btn-sm btn-primary ' +
                                                'dt-center\" onclick="editThis('+"'"+row.id+"'"+','+"'"+row
                                                    .item_id+"'"+','+"'"+row.item_name+"'"+','+"'"+row.main_id+"'"+','+"'"+row
                                                    .cwip_id+"'"+','+"'"+row.gl+"'"+','+"'"+row.cost_center+"'"+','+"'"+row.qty+"'"+','+"'"+row.unit+"'"+','+"'"+row.unit_price+"'"+',' +
                                                ''+"'"+row.origin_plant+"'"+','+"'"+row.user_name+"'"+','+"'"+row
                                                    .department+"'"+','+"'"+row.reason+"'"+','+"'"+row
                                                    .status+"'"+','+"'"+row.remarks+"'"+')'+'">EDIT</button>'
                                        }
                                    },
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return '<button class=\"btn btn-sm btn-danger ' +
                                                'dt-center\" onclick="deleteThis('+"'"+row.id+"'"+')">Delete</button>'
                                        }
                                    },
                                ],
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                info: true,
                                paging: false,
                                filter: true
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
                                                    columns: [0,1,3,4,5,6,7,8,9,10,11,13,14]
                                                },
                                                action: function (e, dt, node, config) {
                                                    exportExtension = 'Excel';
                                                    $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                                }
                                            },
                                            {
                                                extend: 'pdfHtml5',
                                                text: 'Save As PDF',
                                                orientation: 'landscape',
                                                pageSize: 'LETTER',
                                                exportOptions: {
                                                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]
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
                            $("#loader").css('display','none');
                            $("#showTable").css('display','block');
                        }
                    });
                }else{
                    $("#loader").css('display','none');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose any service ID!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            });
            $('#btn_submit').on('click', function (e) {
                e.preventDefault();

                var com_code = $('#com_code').val();
                var plant_id = $('#plant_id').val();
                var item_id = $('#item_id').val();
                var item_name = $("#item_name option:selected").text();
                var main_id = $('#main_id').val();
                var cwip_id = $('#cwip_id').val();
                var gl = $('#gl').val();
                var cost_center = $('#cost_center').val();
                var qty = $('#qty').val();
                var unit = $('#unit').val();
                var unit_price = $('#unit_price').val();
                var origin_plant = $('#origin_plant').val();
                var username = $('#username').val();
                var dept = $('#dept').val();
                var reason = $('#reason').val();
                var status = $('#status').val();
                var remarks = $('#remarks').val();

                if(com_code === "" || plant_id === "" || item_id === "" || item_name === "" || qty === "" || unit === "" || unit_price === "" ||
                    origin_plant === "" || dept === "" || reason === "" || status === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/insertDestructionData') }}',
                        data: {
                            'com_code': com_code, 'plant_id': plant_id, 'main_id': main_id,'cwip_id': cwip_id,
                            'gl': gl,'cost_center':cost_center, 'item_id':item_id, 'item_name':item_name, 'qty':qty,
                            'unit':unit,'unit_price':unit_price, 'origin_plant':origin_plant,'username':username,'dept':dept,
                            'reason':reason, 'status':status, 'remarks':remarks, '_token': "{{ csrf_token() }}" },
                        success: function (data) {
                            console.log(data);
                            if (data.response == 1 || data.response == true) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'New data has been inserted successfully',
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
        $('#update_info').on('click', function (e) {

            var table_id = $("#table_id").val();
            var cost_center = $("#edit_cost_center").val();
            var main_id = $("#edit_main_id").val();
            var cwip_id = $("#edit_cwip_id").val();
            var gl = $("#edit_gl").val();
            var qty = $("#edit_qty").val();
            var unit = $("#edit_unit").val();
            var unit_price = $("#edit_unit_price").val();
            var origin_plant = $("#edit_origin_plant").val();
            var username = $("#edit_username").val();
            var reason = $("#edit_reason").val();
            var status = $("#edit_status").val();
            var remarks = $("#edit_remarks").val();

            if(qty === "" || unit === "" || unit_price === "" ||
                origin_plant === "" || reason === "" || status === ""){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please input all required data!',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }else{
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/editDestructionData') }}',
                    data: {
                        'table_id': table_id, 'main_id': main_id,'cwip_id': cwip_id,
                        'cost_center':cost_center, 'qty':qty,'gl':gl,
                        'unit':unit,'unit_price':unit_price, 'origin_plant':origin_plant,'username':username,
                        'reason':reason, 'status':status, 'remarks':remarks, '_token': "{{ csrf_token() }}" },
                    success: function (data) {
                        if (data.response == 1 || data.response == true) {
                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                text: 'New data has been updated successfully',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#editItemDestructModal").modal('hide');
                                    window.location.reload();
                                }
                            })
                        } else {
                            $("#editItemDestructModal").modal('hide');
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
        function editThis(id,item_id,item_name,main_id,cwip_id,gl,cost_center,qty,unit,unit_price,origin_plant,username,dept,reason,status,remarks){

            $("#table_id").val(id);
            $("#edit_item_id").val(item_id);
            $("#edit_item_name").val(item_name);
            $("#edit_gl").val(gl);
            $("#edit_cost_center").val(cost_center);
            $("#edit_main_id").val(main_id);
            $("#edit_cwip_id").val(cwip_id);
            $("#edit_qty").val(qty);
            $("#edit_unit_price").val(unit_price);
            $("#edit_origin_plant").val(origin_plant);
            $("#edit_username").val(username);
            $("#edit_dept").val(dept);
            $("#edit_reason").val(reason);
            $("#edit_status").val(status);

            if(main_id=='null'){
                $("#edit_main_id").val("");
            }else{
                $("#edit_main_id").val(main_id);
            }

            if(cwip_id=='null'){
                $("#edit_cwip_id").val("");
            }else{
                $("#edit_cwip_id").val(cwip_id);
            }

            if(gl=='null'){
                $("#edit_gl").val("");
            }else{
                $("#edit_gl").val(gl);
            }

            if(cost_center=='null'){
                $("#edit_cost_center").val("");
                $.ajax({
                    type: 'get',
                    url: '{{  url('stationery/form/getCcList') }}',
                    success: function (response) {
                        if(response != ""){
                            $('#edit_cost_center_div').html(response);
                            $('#edit_cost_center').select2();
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }else{
                $("#edit_cost_center").val(cost_center);
            }

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

            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/transferItem/getStockQty') }}',
                data: {
                    'item_id' :item_id,
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    if(response.status == 1){
                        $('#edit_qty').attr('max', response.qty);
                        $('#edit_pr_qty_div p').remove();
                        $('#edit_pr_qty_div').append("<p style='text-align: center;color: #a54c48; " +
                            "font-weight: " +
                            "600;" +
                            "'>Available quantity:" +
                            " "+response
                                .qty+"</p>");
                    }else{
                        $('#edit_qty').removeAttr("max");
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
            $("#editItemDestructModal").modal('show');
        }
        function deleteThis(id){
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
                        url: '{{  url('stationery/form/deleteDestructionData') }}',
                        data: { 'id':id,'_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if(data.result == 1 || data.result == true|| data.result == 'true' ){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Information has been deleted Successfully',
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
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection