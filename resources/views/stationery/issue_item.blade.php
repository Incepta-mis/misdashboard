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
                        SHow Item Requisition Numbers
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
                            <p style="font-size: 13px;font-weight: bold;color: white">Item Requisition Details</p>
                        </div>
                        <div class="table-responsive">
                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%;">
                                <thead style="background-color: #3CB371">
                                <tr style="color: white">
                                    <th>IR No.</th>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>GL</th>
                                    <th>Cost Center</th>
                                    <th>Request Qty</th>
                                    <th>Approve Qty</th>
                                    <th>Issue Qty</th>
                                    <th>Pending Qty</th>
                                    <th>UNIT</th>
                                    <th>Remarks</th>
                                    @if(Auth::user()->user_id == 'CDMDB_7150')
                                        <th>Approve Qty</th>
                                    @endif

                                    @if(Auth::user()->user_id == 'CDM_IT')
                                        <th>Issue Qty</th>
                                    @endif

                                    @if(Auth::user()->user_id != 'CDM_IT')
                                        <th>Edit</th>
                                    @endif

                                    @if(Auth::user()->user_id != 'CDM_IT' && Auth::user()->user_id != 'CDMDB_7150')
                                        <th>Delete</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody ></tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>


                        <div class="row" style="text-align: center">
                            <img src="" id="dis_issue_image_src" style="height: 50px;width:50px;border: 1px solid grey;border-radius: 2px">
                            <br>
                            <a href="{{url('')}}" id="dis_issue_image_url" target="_blank" style=" text-decoration: underline">View Full Image</a>
                            <br>
                            <br>
                            <button type="button" class="btn btn-info btn-sm" id='image_id_ref' data-toggle="modal" data-target="#myModal">Update Image</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    {{--Form--}}
    @if(Auth::user()->user_id!='CDM_IT' && Auth::user()->user_id!='CDM_ADMIN' && Auth::user()->user_id!='CDM_ENG' &&  Auth::user()->user_id!='CDMDB_7150')
        <div class="row">

            <div class="col-md-12 col-sm-12">
                <section class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="text-default">
                                        Item Requisition
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
                                        <th class="text-center">Item Type<span class='cls-req'>*</span></th>
                                        <th class="text-center">Item Name<span class='cls-req'>*</span></th>
                                        <th class="text-center">Item ID<span class='cls-req'>*</span></th>
                                        <th class="text-center">GL</th>
                                        <th class="text-center">Cost Center<span class='cls-req'>*</span></th>
                                        <th class="text-center">Request Quantity<span class='cls-req'>*</span></th>
                                        {{--   <th class="text-center">Approve Quantity<span class='cls-req'>*</span></th>--}}
                                        <th class="text-center">Unit<span class='cls-req'>*</span></th>
                                        <th class="text-center">Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    <tr>
                                        <td>
                                            <select id="it_name" name="it_name"
                                                    class="form-control input-sm ">
                                                <option value="" selected >Select Item Type</option>

                                                @if($it_name)
                                                    @foreach($it_name as $it_names)
                                                        <option value="{{$it_names->it_name}}" >{{$it_names->it_name}}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </td>
                                        <td>
                                            <select id="item_name" name="item_name"
                                                    class="form-control input-sm ">

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                   class="form-control input-xs" id="item_id"
                                                   placeholder="" name="item_id">
                                        </td>
                                        <td>
                                            <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                                   class="form-control input-xs" id="item_gl"
                                                   placeholder="" name="item_gl">
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
                                                   class="form-control input-xs" id="req_qty"
                                                   placeholder="" name="req_qty" min="1">
                                        </td>
                                        {{--   <td>
                                               <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                                      class="form-control input-xs" id="aprv_qty"
                                                      placeholder="" name="aprv_qty" min="1">
                                           </td>--}}
                                        <td>
                                            <select id="unit" name="unit" class="form-control input-sm
                                                filter-option pull-left">
                                                <option value="" selected>Select a unit</option>
                                                @if(count($units) > 0)
                                                    @foreach($units as $u)
                                                        <option value="{{$u->unit}}">{{$u->unit}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
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
                                        <th class="text-center">GL</th>
                                        <th class="text-center">Cost Center<span class='cls-req'>*</span></th>
                                        <th class="text-center">Request Quantity<span class='cls-req'>*</span></th>
                                        {{--  <th class="text-center">Approve Quantity<span class='cls-req'>*</span></th>--}}
                                        <th class="text-center">Unit<span class='cls-req'>*</span></th>
                                        <th class="text-center">Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody" style="text-align:center">


                                    </tbody>
                                </table>
                                <div style="text-align: center">
                                    <input type="file" style="width: 300px" name="file"  accept=".jpg,.png" placeholder="Choose .jpg/.png type img" id="issue_file" class="center-block form-control">
                                    <label style="color: red;font-size: 12px">Select .jpg/.png type image only</label>

                                </div>
                                <button type="button" class="delete-row btn btn-danger" style="display:none" id="delete_button">Delete Item</button>
                                <button type="button"  type="submit"  class="btn btn-info" style="display:none" id="submit_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    @endif


    {{--Modal for datatable--}}
    <div id="editItemDisplayModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Requisition</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_ir_no" class="control-label col-sm-2">IR NO:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_ir_no" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_item_id" class="control-label col-sm-2">Item ID:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_id" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_name" class="control-label col-sm-2">Item Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_item_name" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_gl" class="control-label col-sm-2">GL</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="edit_gl" value="" >
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
                            <label for="edit_pr_qty" class="control-label col-sm-2">PR Qty:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="edit_pr_qty" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_unit" class="control-label col-sm-2">Unit:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <select id="edit_unit" name="edit_unit" class="form-control input-sm
                                                filter-option pull-left">
                                    <option value="" selected>Select a unit</option>
                                    @if(count($units) > 0)
                                        @foreach($units as $u)
                                            <option value="{{$u->unit}}">{{$u->unit}}</option>
                                        @endforeach
                                    @endif
                                </select>
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
                            <label for="edit_unit" class="control-label col-sm-2">Unit:<span class='cls-req'>*</span></label>
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
                            <label for="aprv_aprv_qty" class="control-label col-sm-2">Approve Qty:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" min="1"    id="aprv_aprv_qty" value="" placeholder="Approve Quantity">
                                <p style="color: red">Available Stock: <label id="apprv_item_qty"></label></p>

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
                                <input type="number" class="form-control" min="1" id="issu_appr_qty" value="" placeholder="Approve Quantity" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="issu_issu_qty" class="control-label col-sm-2">Issue Qty:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="number"  min="1" class="form-control"  id="issu_issu_qty" value="" placeholder="Issue Quantity">
                                <p style="display:block; margin-right:110px;color: red">Available Stock: <label id="max_issue_qty"></label></p>
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
                        <h4 class="modal-title">Update Image</h4>
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
        $(document).ready(function () {
            $('#cost_center').select2();
            $('#edit_cost_center').select2();
            $('#item_name').select2();
            $('#unit').select2();
            $('#edit_unit').select2();

            /*  Select two val*/
            var data;
            var approve_qty;

            $('#req_qty').on('change keyup keypress mouseenter', function (e) {

                req_qty = $("#req_qty").val();
                if (req_qty) {
                    $("#aprv_qty").val(req_qty)

                } else {
                    $("#aprv_qty").val('')

                }
            });

            $('#ir_no_selectTo').select2({
                placeholder: 'Select IR No.',
                ajax: {
                    url: '{{  url('stationery/form/issueItem/getIssuedItem') }}',
                    method: 'get',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {

                                return {
                                    text: item.ir_no,
                                    id: item.ir_no
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
                    url: "{{ url('stationery/form/issueItem/showIrdata') }}",
                    success: function (resp) {

                        if(resp.image_path[0].image_path){
                            var base_url = window.location.origin;
                            var pathArray = window.location.pathname.split('/');

                            var main_url = base_url + "/" + pathArray[1];
                            var image_url = main_url + '/public/' + resp['image_path'][0].image_path;
                            $('#dis_issue_image_url').attr('href', image_url);
                            $('#dis_issue_image_src').attr('src', image_url);
                            $('#issu_ir_no_img').val(ir_no);

                        }else{

                            $("#dis_issue_image_src").attr('href', '#');
                            $("#dis_issue_image_url").html('No Img Found');
                            $("#image_id_ref").html("Upload An Image");
                            $('#issu_ir_no_img').val(ir_no);

                        }

                        $("#loader").hide();
                        $("#report-body").show();


                        $("#blk_list").DataTable().destroy();
                        table = $("#blk_list").DataTable({
                            data: resp.issuedItems,
                            autoWidth: true,
                            columns: [
                                {data: "ir_no"},
                                {data: "item_id"},
                                {data: "item_name"},
                                {data: "gl"},
                                {data: "cost_center"},
                                {data: "req_qty"},
                                {data: "aprv_qty"},
                                {data: "issu_qty"},
                                {data: "pen_qty"},
                                {data: "unit"},
                                {data: "remarks"},
                                    @if(Auth::user()->user_id == 'CDMDB_7150')
                                {
                                    data: 'aprv_qty',
                                    orderable: false,

                                    'render': function (data, type, row) {

                                        if (row.issu_qty==row.aprv_qty) {
                                            return '<button class="btn btn-sm btn-info"  style="background-color: #66CC99" id="btn_approved">Completed</button>'
                                        }else{
                                            return '<button class=\"btn btn-sm btn-info row-edit ' +
                                                'dt-center\" id="' + row.id + '" ' +
                                                'onclick="approveRecord(' + "'" + row.id + "','" + row.ir_no + "','" + row.item_id + "','" + row.item_name + "','" + row.gl + "','" + row.cost_center + "','" + row.req_qty + "','" + row.issu_qty + "','" + row.aprv_qty + "','" + row.unit + "','" + row.remarks + "')" + '">Edit Qty</button>'


                                        }

                                    }
                                },

                                    @endif

                                    @if(Auth::user()->user_id=='CDM_IT' ||Auth::user()->user_id=='CDM_ADMIN' ||Auth::user()->user_id=='CDM_ENG')

                                {
                                    data: 'issu_qty',
                                    orderable: false,

                                    'render': function (data, type, row) {
                                        if (row.issu_qty==row.aprv_qty) {
                                            return '<button class="btn btn-sm btn-info"  style="background-color: #66CC99" id="btn_approved">Issued</button>'
                                        } else {

                                            return '<button class=\"btn btn-sm btn-info row-edit ' +
                                                'dt-center\" id="' + row.id + '" ' +
                                                'onclick="isssueRecord(' + "'" + row.id + "','" + row.ir_no + "','" + row.item_id + "','" + row.item_name + "','" + row.gl + "','" + row.cost_center + "','" + row.req_qty + "','" + row.issu_qty + "','" + row.aprv_qty + "','" + row.unit + "','" + row.remarks + "')" + '">Edit Qty</button>'

                                        }
                                    }
                                },
                                    @endif

                                    @if(Auth::user()->user_id != 'CDM_IT' && Auth::user()->user_id!='CDM_ADMIN' && Auth::user()->user_id!='CDM_ENG')
                                {
                                    data: 'issu_qty',
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        if (row.issu_qty>0) {
                                            return '<button class="btn btn-sm btn-info"   style="background-color: #66CC99" id="btn_approved">Issued</button>'
                                        } else {

                                            return '<button class=\"btn btn-sm btn-info row-edit ' +
                                                'dt-center\" id="' + row.id + '" ' +
                                                'onclick="editThisRecord(' + "'" + row.id + "','" + row.ir_no + "','" + row.item_id + "','" + row.item_name + "','" + row.gl + "','" + row.cost_center + "','" + row.req_qty + "','" + row.unit + "','" + row.remarks + "')" + '">EDIT</button>'

                                        }
                                    }
                                },

                                    @endif

                                    @if(Auth::user()->user_id != 'CDM_IT' && Auth::user()->user_id != 'CDM_ADMIN' && Auth::user()->user_id != 'CDM_ENG' && Auth::user()->user_id != 'CDMDB_7150')
                                {
                                    data: 'issu_qty',
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        if (row.issu_qty>0) {
                                            return '<button class="btn btn-sm btn-info"  style="background-color: #66CC99" id="btn_approved">Issued</button>'
                                        } else {


                                            return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                                'dt-center\" id="' + row.id + '" ' +
                                                'onclick="deleteThisRecord(' + "'" + row.id + "','" + row.ir_no + "')" + '">Delete</button>'
                                        }
                                    }
                                }

                                @endif


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

            /*Onselect Item Name*/
            $('#item_name').change(function () {
                var item_id_gl = $(this).val();
                /*split string*/
                var arrVars = item_id_gl.split("/");
                var item_gl = arrVars.pop();
                var item_id = arrVars.join("/");


                //$('#item_gl').val(item_gl);
                $('#item_id').val(item_id);

                // $('#item_gl').attr('readonly', true);
                $('#item_id').attr('readonly', true);

            });

            /*Onselect Item Name*/
            $('#it_name').change(function () {
                var it_name = $("#it_name option:selected").val();
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/issueItem/getItemName') }}',
                    data: {'it_name': it_name, '_token': "{{ csrf_token () }}"},
                    dataType: 'json',

                    success: function (data) {
                        if ((data.result.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Item</option>';
                            for (var i = 0; i < data.result.length; i++) {
                                op += '<option value= "' + data.result[i]['item_id'] + '/' + data.result[i]['gl']+'">' + data.result[i]['item_name'] + '</option>';
                            }
                            $('#item_name').html("");
                            $('#item_name').append(op);
                        }else {
                            $('#item_name').html("");
                            $('#item_name').append('<option value="0" selected disabled>No employee tagged under any ' +
                                'department of the selected plant. ' +
                                'Category</option>');
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });

            });

            /*Add row on button click*/
            $(".add-row").click(function () {
                var item_name = $("#item_name option:selected").text();
                var it_name = $("#it_name option:selected").text();
                var item_id = $("#item_id").val();
                var item_gl = $("#item_gl").val();
                var cost_center = $("#cost_center option:selected").val();
                var unit = $("#unit option:selected").val();
                var req_qty = $("#req_qty").val();
                var remarks = $("#remarks").val();


                if (item_name == 'Select Item'||item_name == ''||it_name == ''
                    ||item_id == ''||unit == ''||unit == 'Select a Unit'||cost_center == ''||cost_center == 0 ||req_qty == '') {

                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Input Required Field!',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                }

                var markup = "<tr><td><input type='checkbox' name='record' id='record'></td><td>" + item_name + "</td><td>" + item_id + "</td><td>" + item_gl + "</td><td>"
                    + cost_center + "</td><td>" + req_qty + "</td><td>" + unit + "</td><td>" + remarks + "</td></tr>";

                var delete_button = "<input type='button' value='Delete'>"

                $("#display_data table tbody").append(markup);
                $("#delete_button").css("display", "inline-block");
                $("#submit_button").css("display", "inline-block");

                $('#cost_center').val('0');
                $('#cost_center').trigger('change');

                $("#item_issue_form").trigger('reset');

                $("#item_name").empty()

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

            $(document).on("click", "#submit_button", function (e) {

                e.preventDefault();
                var itemArray = [];

                $("#issueTable tbody tr").each(function () {
                    var issueItemData = {};

                    var self = $(this);

                    var item_name = self.find("td:eq(1)").text().trim();
                    var item_id = self.find("td:eq(2)").text().trim();
                    var item_gl = self.find("td:eq(3)").text().trim();
                    var cost_center = self.find("td:eq(4)").text().trim();
                    var req_qty = self.find("td:eq(5)").text().trim();
                    var unit = self.find("td:eq(6)").text().trim();
                    var remarks = self.find("td:eq(7)").text().trim();


                    issueItemData.item_name = item_name;
                    issueItemData.item_id = item_id;
                    issueItemData.gl = item_gl;
                    issueItemData.cost_center = cost_center;
                    issueItemData.req_qty = req_qty;
                    issueItemData.aprv_qty = req_qty;
                    issueItemData.unit = unit;
                    issueItemData.remarks = remarks;

                    itemArray.push(issueItemData);

                });


                var itemData = JSON.stringify(itemArray);


                var formData = new FormData();
                formData.append("file", document.getElementById('issue_file').files[0]);
                formData.append("data", itemData);
                formData.append('_token', '{{ csrf_token() }}');

                var file_data = document.getElementById('issue_file').files[0];

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/issueItem/createIssue') }}',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                text: 'Requisition Created Successfully',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else if (response.error) {
                            if (response.error == 'ext_error') {

                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed!!File type must be jpg or png or jepg',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })

                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Issue creation failed.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something was wrong! Issue creation failed.',
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



            $(document).on("click","#update_issue",function(e) {
                e.preventDefault();
                var edit_ir_no = $("#edit_ir_no").val();
                var edit_item_id = $("#edit_item_id").val();
                var edit_item_name = $("#edit_item_name").val();
                var edit_gl = $("#edit_gl").val();
                var edit_cost_center = $("#edit_cost_center option:selected").val();
                var edit_unit =$("#edit_unit option:selected").val();
                var edit_pr_qty = $("#edit_pr_qty").val();
                var edit_remarks = $("#edit_remarks").val();
                var table_id = $("#table_id").val();


                var itemArray = {};

                itemArray.edit_ir_no = edit_ir_no;
                itemArray.edit_item_id = edit_item_id;
                itemArray.edit_item_name = edit_item_name;
                itemArray.edit_gl = edit_gl;
                itemArray.edit_cost_center = edit_cost_center;
                itemArray.edit_pr_qty = edit_pr_qty;
                itemArray.edit_unit = edit_unit;
                itemArray.edit_remarks = edit_remarks;

                var itemArrayData = JSON.stringify(itemArray);

                if (!edit_ir_no || !edit_item_id || !edit_item_name ||!edit_cost_center || !edit_pr_qty|| !edit_unit|| edit_unit=='Select a unit') {
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
                        url: '{{  url('stationery/form/issueItem/updateIssuedItem') }}',
                        data: {'id': table_id, 'itemArray': itemArrayData, '_token': "{{ csrf_token () }}"},

                        success: function (data) {
                            if (data.result == 1 || data.result == "success") {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item Has Been Updated Successfully',
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

            $("#issue_qty_button").on('click', function () {
                var issu_appr_qty = $("#issu_appr_qty").val();
                var issu_issu_qty = $("#issu_issu_qty").val();
                var issue_item_id = $("#issu_item_id").val();
                var issu_ir_no = $("#issu_ir_no").val();
                var table_id = $("#table_id").val();

                if (issu_appr_qty == '' || issu_issu_qty == '') {
                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please input required field!!',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                }

                if (parseInt(issu_issu_qty) > parseInt(issu_appr_qty)) {
                    Swal.fire({
                        title: 'Opps!!',
                        icon: 'warning',
                        text: 'Issue quantity must be less then or equal to approve quantity',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/issueItem/issueQtyItem') }}',
                        data: {
                            'id': table_id, 'issu_qty': issu_issu_qty, 'aprv_qty': issu_appr_qty, 'ir_no': issu_ir_no,
                            'item_id': issue_item_id, '_token': "{{ csrf_token () }}"
                        },
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
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });

            /*Approve Quantity*/
            $("#approve_qty_button").on('click', function () {


                var aprv_req_qty = $("#aprv_req_qty").val();
                var aprv_aprv_qty = $("#aprv_aprv_qty").val();
                var table_id = $("#table_id").val();
                var aprv_item_id = $("#aprv_item_id").val();

                if (aprv_aprv_qty == 'null' || aprv_aprv_qty == '') {
                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please input approve Qty!!',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                }

                if (parseInt(aprv_aprv_qty) > parseInt(aprv_req_qty)) {
                    Swal.fire({
                        title: 'Opps!!',
                        icon: 'warning',
                        text: 'Approve quantity must be less then or equal to request quantity',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                    return 0;
                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/issueItem/approveQtyItem') }}',
                        data: {
                            'id': table_id,
                            'aprv_item_id': aprv_item_id,
                            'aprv_qty': aprv_aprv_qty, 'req_qty': aprv_req_qty, '_token': "{{ csrf_token () }}"
                        },
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
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });

            $(document).on("click", "#btn_approved", function () {
                Swal.fire({
                    title: 'Great!',
                    icon: 'success',
                    text: 'Already Approved',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok'
                })
            });

            $(document).on("click", "#update_img_button", function (e) {

                e.preventDefault();

                var formData = new FormData();
                formData.append("file", document.getElementById('issue_file_update').files[0]);
                formData.append("ir_no", $('#issu_ir_no_img').val());
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/issueItem/updateIssueImg') }}',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                text: 'Image updated successfully',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else if (response.error) {
                            if (response.error == 'ext_error') {

                                Swal.fire({
                                    title: 'Warning!',
                                    text: 'Failed!!File type must be jpg or png or jepg',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })

                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Issue creation failed.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something was wrong! Issue creation failed.',
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


        })

        function editThisRecord(id, ir_no, item_id, item_name, gl, cost_center, pr_qty, unit, remarks) {

            $("#table_id").val(id);
            $("#edit_ir_no").val(ir_no);
            $("#edit_item_id").val(item_id);
            $("#edit_item_name").val(item_name);
            $("#edit_gl").val(gl);

            $("#edit_cost_center").select2().val(cost_center).trigger("change");
            $("#edit_unit").select2().val(unit).trigger("change");
            $("#edit_pr_qty").val(pr_qty);
            $("#edit_remarks").val(remarks);



            if (ir_no == 'null' || ir_no == '') {
                $("#edit_ir_no").val("");
            } else {
                $("#edit_ir_no").val(ir_no);
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

            if (gl == 'null' || gl == '') {
                $("#edit_gl").val("");
            } else {
                $("#edit_gl").val(gl);
            }

            if (remarks == 'null' || remarks == '') {
                $("#edit_remarks").val("");
            } else {
                $("#edit_remarks").val(remarks);
            }

            if (unit == 'null' || unit == '') {
                $("#edit_unit").val("");
            } else {
                $("#edit_unit").val(unit);
            }

            if (pr_qty == 'null' || pr_qty == '') {
                $("#edit_pr_qty").val("");
            } else {
                $("#edit_pr_qty").val(pr_qty);
            }


            $("#editItemDisplayModal").modal('show');

        }

        function deleteThisRecord(id, ir_no) {

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
                        url: '{{  url('stationery/form/issueItem/delete_my_issues') }}',
                        data: {'id': id, 'ir_no': ir_no, '_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if (data.result == 1 || data.result == true || data.result == 'true') {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item Has Been Deleted Successfully',
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

        function approveRecord(id, ir_no, item_id, item_name, gl, cost_center, req_qty, issu_qty, aprv_qty, unit, remarks) {


            $("#table_id").val(id);


            if (ir_no != 'null' || ir_no != '') {
                $("#aprv_ir_no").val(ir_no);

            } else {
                $("#aprv_ir_no").val("");

            }
            if (item_id != 'null' || item_id != '') {
                $("#aprv_item_id").val(item_id);

            } else {
                $("#aprv_item_id").val("");

            }
            if (item_name != 'null' || item_name != '') {
                $("#aprv_item_name").val(item_name);

            } else {
                $("#aprv_item_name").val("");

            }

            if(unit=='null'||unit ==''){
                $("#aprv_unit").val("");
            }else{
                $("#aprv_unit").val(unit);
            }

            if (req_qty != 'null' || req_qty != '') {
                $("#aprv_req_qty").val(req_qty);

            } else {
                $("#aprv_req_qty").val("");

            }

            if (aprv_qty != 'null' || aprv_qty != '') {
                $("#aprv_aprv_qty").val(aprv_qty);

            } else {
                $("#aprv_aprv_qty").val("");

            }
            $("#aprv_aprv_qty").attr({
                "max": req_qty
            });

            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/issueItem/getProductQty') }}',
                data: {'item_id': item_id,'id': id, '_token': "{{ csrf_token () }}"},

                success: function (data) {
                    if (data.item_qty) {
                        $('#apprv_item_qty').text(data.item_qty)
                    } else {

                        $('#apprv_item_qty').text('0')
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });


            $("#approveQtyDisplayModal").modal('show');

        }

        function isssueRecord(id, ir_no, item_id, item_name, gl, cost_center, req_qty, issu_qty, aprv_qty, unit, remarks) {

            $("#table_id").val(id);
            $("#issu_ir_no").val(ir_no);
            $("#issu_item_id").val(item_id);
            $("#issu_item_name").val(item_name);
            $("#issu_unit").val(unit);
            $("#issu_req_qty").val(req_qty);
            $("#issu_appr_qty").val(aprv_qty);


            if(unit=='null'||unit ==''){
                $("#issu_unit").val("");

            }else{
                $("#issu_unit").val(unit);
            }

            if(aprv_qty=='null'||aprv_qty ==''){
                $("#issu_appr_qty").val("");

            }else{
                $("#issu_appr_qty").val(aprv_qty);
            }

            $("#issu_appr_qty").attr({
                "max": req_qty
            });


            var main_aprv_qty = aprv_qty;


            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/issueItem/getProductQty') }}',
                data: {'id': id,'item_id': item_id, '_token': "{{ csrf_token () }}"},

                success: function (data) {

                    if (data.item_qty) {

                        $("#issu_issu_qty").attr('readonly', false);
                        $('#max_issue_qty').text(data.item_qty)

                        var already_issued = data.already_issued;
                        var avg_issu_qty =   parseInt(main_aprv_qty) - parseInt(already_issued);

                        $("#issu_issu_qty").attr({
                            "max": avg_issu_qty,
                            "min": 1
                        });
                    } else {

                        $("#issu_issu_qty").attr('readonly', true);
                        $('#max_issue_qty').text('0')
                    }
                },
                error: function (e) {
                    console.log(e);
                }

            });
            $("#issueQtyDisplayModal").modal('show');

        }
    </script>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection





