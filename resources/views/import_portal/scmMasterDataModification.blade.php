@extends('_layout_shared._master')
@section('title','SCM Master Data Modification Portal')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
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

        .tableFixHead {
            overflow-y: auto;
            max-height: 600px;
        }
        .tableFixHead thead th {
            position: sticky !important;
            top: 0;
            background-color: #d6d5ff;
        }
        table {
            position: relative;
            border-collapse: collapse;
            width: 100%;
        }
        th,td {
            font-size: 12px;
        }
        .swal2-icon.swal2-warning {
            font-size: 14px;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-default">
                <div class="panel-heading">
                    <label class="text-default">
                        SCM Master Data Modification Portal
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6">
                                        <label for="type"
                                               class="col-md-3 col-sm-3 control-label fnt_size"
                                               style="padding-right:0px;"><b>Choose a type</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="type" name="type"
                                                    class="form-control input-sm filter-option pull-left">
                                                <option selected value="">Select a type</option>
                                                <option value="currency">Currency</option>
                                                <option value="type_of_doc">Type of Document</option>
                                                <option value="concern_person">Concern Person(SCM)</option>
                                                <option value="bank_name">Bank name</option>
                                                <option value="insurance_name">Insurance name</option>
                                                <option value="types_of_lc">Types of LC</option>
                                                <option value="c_and_f">C&F</option>
                                                <option value="vendor">Vendor</option>
                                                <option value="agent">Local agent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <button type="button" id="btn_submit" class="btn btn-warning btn-sm"
                                                style="float: left;">
                                            <i class="fa fa-chevron-circle-up"></i> <b>Display</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
            </div>
        </div>
    </div>

    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 ">
                            <button id="createBTNdiv" type="button" class="btn btn-success" data-type = ""
                            style="margin-bottom: 10px">Insert new data</button>
                        </div>
                        <div class="col-md-12 col-sm-12 table-responsive tableFixHead">
                            <table id="table_div" class="table table-bordered table-condensed table-striped">
                                <thead>
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
    <div id="editCurrencyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Currency Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_curr" class="control-label col-sm-2" >Currency:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_curr" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_rate" class="control-label col-sm-2">Rate:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_rate" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_curr_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_curr_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editBankModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Bank Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_bank_name" class="control-label col-sm-2" >Bank name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_bank_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_bank_add" class="control-label col-sm-2">Address:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_bank_add" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_bank_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_bank_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editDocTypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Document Type</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_doctype" class="control-label col-sm-2" >Document Type:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_doctype" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_doc_type_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_docType_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editLCTypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit LC Type</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_lctype" class="control-label col-sm-2" >LC Type:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_lctype" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_lc_type_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_lcType_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editCandFModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit C&F</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_candf" class="control-label col-sm-2" >C&F:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_candf" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_candf_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_candf_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editInsuNameModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Insurance Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_insu_name" class="control-label col-sm-2" >Insurance Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_insu_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_insu_name_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_insu_name_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editConcernPersonModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit concern person's name</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_concernPName" class="control-label col-sm-2" >Concern person name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_concernPName" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_concernP_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_concernP_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editVendorModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit vendor information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_ven_name" class="control-label col-sm-2" >Vendor name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_ven_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ven_code" class="control-label col-sm-2" >Code:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_ven_code" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ven_add" class="control-label col-sm-2" >Address:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_ven_add" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_ven_valid" class="control-label col-sm-2" >Valid:</label>
                            <div class="col-sm-10">
                                <select name="edit_ven_valid" id="edit_ven_valid" class="form-control">
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_vendor_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_vendor_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="editAgentModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit agent information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_local_agent" class="control-label col-sm-2" >Local agent:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_local_agent" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_concern_name" class="control-label col-sm-2" >Concern name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_concern_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_mob_no" class="control-label col-sm-2" >Mobile no:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_mob_no" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_email" class="control-label col-sm-2" >Mail address:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_email" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_agent_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="edit_agent_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createCurrencyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert Currency Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_curr" class="control-label col-sm-2" >Currency:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_curr" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_rate" class="control-label col-sm-2">Rate:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_rate" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_curr_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createBankInfoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert Bank Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_bank_name" class="control-label col-sm-2" >Bank name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_bank_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_bank_add" class="control-label col-sm-2">Address:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_bank_add" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_bank_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createDocTypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert Type of Documentation</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_docType" class="control-label col-sm-2" >Type:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_docType" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_docType_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createCandFModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert C&F Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_candf" class="control-label col-sm-2" >C&F:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_candf" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_candf_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createLCtypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert Type of LC</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_lcType" class="control-label col-sm-2" >LC Type:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_lcType" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_lcType_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createInsuInfoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert Insurance information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_insu_name" class="control-label col-sm-2" >Insurance name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_insu_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_insu_name_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createConcernPersonModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert Concern Person</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_concernPerson" class="control-label col-sm-2" >Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_concernPerson" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_concernPerson_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createVendorModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert vendor information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_ven_name" class="control-label col-sm-2" >Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_ven_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_ven_code" class="control-label col-sm-2" >Code:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_ven_code" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_ven_add" class="control-label col-sm-2" >Address:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_ven_add" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_ven_valid" class="control-label col-sm-2" >Valid:</label>
                            <div class="col-sm-10">
                                <select name="add_ven_valid" id="add_ven_valid" class="form-control">
                                    <option value="">Choose a option</option>
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_vendor_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="createAgentModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insert agent information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="add_local_agent" class="control-label col-sm-2" >Local agent:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_local_agent" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_concern_name" class="control-label col-sm-2" >Concern name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_concern_name" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_mob_no" class="control-label col-sm-2" >Mobile no.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_mob_no" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_agent_email" class="control-label col-sm-2" >Mail address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_agent_email" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="add_agent_btn">Save</button>
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
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#edit_doctype').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_curr').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_docType').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_curr').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_concernPerson').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_concernPName').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_bank_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_bank_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_insu_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_insu_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_lctype').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_lcType').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_candf').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_candf').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_ven_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_ven_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_local_agent').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#add_concern_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_local_agent').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#edit_concern_name').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#type').select2();
            $('#add_curr_btn').on('click', function (e) {
                var add_curr = $('#add_curr').val();
                var add_rate = $('#add_rate').val();
                if(add_curr === "" && add_rate === "" ){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addCurrData') }}',
                        data:{'add_curr':add_curr,'add_rate':add_rate,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createCurrencyModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_bank_btn').on('click', function (e) {
                var add_bank_name = $('#add_bank_name').val();
                var add_bank_add = $('#add_bank_add').val();
                if(add_bank_name === "" && add_bank_add === "" ){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addBankData') }}',
                        data:{'add_bank_name':add_bank_name,'add_bank_add':add_bank_add,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createBankInfoModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_docType_btn').on('click', function (e) {
                var add_docType = $('#add_docType').val();
                if(add_docType === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addDocTypeData') }}',
                        data:{'add_docType':add_docType,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createDocTypeModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_candf_btn').on('click', function (e) {
                var add_candf = $('#add_candf').val();
                if(add_candf === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addCandFData') }}',
                        data:{'add_candf':add_candf,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createCandFModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_lcType_btn').on('click', function (e) {
                var add_lcType = $('#add_lcType').val();
                if(add_lcType === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addLCTypeData') }}',
                        data:{'add_lcType':add_lcType,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createLCTypeModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_insu_name_btn').on('click', function (e) {
                var add_insu_name = $('#add_insu_name').val();
                if(add_insu_name === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addInsuNameData') }}',
                        data:{'add_insu_name':add_insu_name,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createInsuInfoModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_concernPerson_btn').on('click', function (e) {
                var add_concernPerson = $('#add_concernPerson').val();
                if(add_concernPerson === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addConcernPersonData') }}',
                        data:{'add_concernPerson':add_concernPerson,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createConcernPersonModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_vendor_btn').on('click', function (e) {
                var add_ven_name = $('#add_ven_name').val();
                var add_ven_code = $('#add_ven_code').val();
                var add_ven_add = $('#add_ven_add').val();
                var add_ven_valid = $('#add_ven_valid').val();
                if(add_ven_name === "" || add_ven_code === "" || add_ven_add === "" || add_ven_valid === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addVendorData') }}',
                        data:{'add_ven_name':add_ven_name,'add_ven_code':add_ven_code,'add_ven_add':add_ven_add,'add_ven_valid':add_ven_valid,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createVendorModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#add_agent_btn').on('click', function (e) {
                var add_local_agent = $('#add_local_agent').val();
                var add_concern_name = $('#add_concern_name').val();
                var add_mob_no = $('#add_mob_no').val();
                var add_agent_email = $('#add_agent_email').val();
                if(add_local_agent === "" || add_concern_name === "" || add_mob_no === "" || add_agent_email === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/addAgentData') }}',
                        data:{'add_local_agent':add_local_agent,'add_concern_name':add_concern_name,'add_mob_no':add_mob_no,'add_agent_email':add_agent_email,'_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#createAgentModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#createBTNdiv').on('click', function (e) {
                var type = $('#createBTNdiv').attr('data-type');
                if(type === 'currency'){
                    $("#createCurrencyModal").modal('show');
                }else if(type === 'type_of_doc'){
                    $("#createDocTypeModal").modal('show');
                }else if(type === 'concern_person'){
                    $("#createConcernPersonModal").modal('show');
                }else if(type === 'bank_name'){
                    $("#createBankInfoModal").modal('show');
                }else if(type === 'insurance_name'){
                    $("#createInsuInfoModal").modal('show');
                }else if(type === 'types_of_lc'){
                    $("#createLCtypeModal").modal('show');
                }else if(type === 'c_and_f'){
                    $("#createCandFModal").modal('show');
                }else if(type === 'vendor'){
                    $("#createVendorModal").modal('show');
                }else if(type === 'agent'){
                    $("#createAgentModal").modal('show');
                }
            });
            $('#edit_curr_btn').on('click', function (e) {
                var edit_curr = $('#edit_curr').val();
                var edit_rate = $('#edit_rate').val();
                var edit_curr_id = $('#edit_curr_id').val();
                if(edit_curr === "" && edit_rate === "" && edit_curr_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateCurrData') }}',
                        data:{'edit_curr_id':edit_curr_id,'edit_rate':edit_rate,'edit_curr':edit_curr, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editCurrencyModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_bank_btn').on('click', function (e) {
                var edit_bank_name = $('#edit_bank_name').val();
                var edit_bank_add = $('#edit_bank_add').val();
                var edit_bank_id = $('#edit_bank_id').val();
                if(edit_bank_name === "" && edit_bank_add === "" && edit_bank_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateBankData') }}',
                        data:{'edit_bank_name':edit_bank_name,'edit_bank_add':edit_bank_add,'edit_bank_id':edit_bank_id, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editBankModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_doc_type_btn').on('click', function (e) {
                var edit_doctype = $('#edit_doctype').val();
                var edit_docType_id = $('#edit_docType_id').val();
                if(edit_doctype === "" && edit_docType_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateDocTypeData') }}',
                        data:{'edit_doctype':edit_doctype,'edit_docType_id':edit_docType_id, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editDocTypeModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_candf_btn').on('click', function (e) {
                var edit_candf = $('#edit_candf').val();
                var edit_candf_id = $('#edit_candf_id').val();
                if(edit_candf === "" && edit_candf_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateCandFData') }}',
                        data:{'edit_candf':edit_candf,'edit_candf_id':edit_candf_id, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editCandFModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_lc_type_btn').on('click', function (e) {
                var edit_lctype = $('#edit_lctype').val();
                var edit_lcType_id = $('#edit_lcType_id').val();
                if(edit_lctype === "" && edit_lcType_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateLCTypeData') }}',
                        data:{'edit_lctype':edit_lctype,'edit_lcType_id':edit_lcType_id, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editLCTypeModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_insu_name_btn').on('click', function (e) {
                var edit_insu_name = $('#edit_insu_name').val();
                var edit_insu_name_id = $('#edit_insu_name_id').val();
                if(edit_insu_name === "" && edit_insu_name_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateInsuNameData') }}',
                        data:{'edit_insu_name':edit_insu_name,'edit_insu_name_id':edit_insu_name_id, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editInsuNameModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_concernP_btn').on('click', function (e) {
                var edit_concernPName = $('#edit_concernPName').val();
                var edit_concernP_id = $('#edit_concernP_id').val();
                if(edit_concernPName === "" && edit_concernP_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateConcernPersonData') }}',
                        data:{'edit_concernPName':edit_concernPName,'edit_concernP_id':edit_concernP_id, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editConcernPersonModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_vendor_btn').on('click', function (e) {
                var edit_vendor_id = $('#edit_vendor_id').val();
                var edit_ven_name = $('#edit_ven_name').val();
                var edit_ven_code = $('#edit_ven_code').val();
                var edit_ven_add = $('#edit_ven_add').val();
                var edit_ven_valid = $('#edit_ven_valid').val();
                if(edit_vendor_id === "" || edit_ven_name === "" || edit_ven_code === "" || edit_ven_add === "" || edit_ven_valid === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateVendorData') }}',
                        data:{'edit_vendor_id':edit_vendor_id,'edit_ven_name':edit_ven_name,
                            'edit_ven_code':edit_ven_code,'edit_ven_add':edit_ven_add,
                            'edit_ven_valid':edit_ven_valid, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editVendorModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
            $('#edit_agent_btn').on('click', function (e) {
                var edit_local_agent = $('#edit_local_agent').val();
                var edit_concern_name = $('#edit_concern_name').val();
                var edit_mob_no = $('#edit_mob_no').val();
                var edit_email = $('#edit_email').val();
                var edit_agent_id = $('#edit_agent_id').val();
                if(edit_local_agent === "" || edit_concern_name === "" || edit_mob_no === "" || edit_email === "" || edit_agent_id === ""){
                    $("#loader").hide();
                    toastr.error("Please input all data");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/updateAgentData') }}',
                        data:{'edit_local_agent':edit_local_agent,'edit_concern_name':edit_concern_name,
                            'edit_mob_no':edit_mob_no,'edit_email':edit_email,
                            'edit_agent_id':edit_agent_id, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data saved successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                            $("#editAgentModal").modal('hide');
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });

            $('#btn_submit').on('click', function (e) {
                $("#loader").show();
                $('#showTable').hide();

                var type = $('#type').val();

                if(type === ""){
                    $("#loader").hide();
                    toastr.error("Please choose a type!");
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('import_management/getSCMMasterData') }}',
                        data:{'type':type, '_token':"{{csrf_token () }}"},
                        success: function (data) {
                            // console.log(data);
                            if(data.result.length > 0){
                                var res = data.result;
                                if(type === 'type_of_doc'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                    theadHTML += "<th>Type of Doc</th>";
                                    theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                        tbodyHTML += "<td>" + res[i]['type_of_doc'] + "</td>";
                                        tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                            'onclick="editThisDocType('+"'"+res[i]['type_of_doc']+"',"+res[i]['id']+')">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                            'onclick="deleteThisDocType('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'c_and_f'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                    theadHTML += "<th>C&F</th>";
                                    theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                        tbodyHTML += "<td>" + res[i]['c_and_f'] + "</td>";
                                        tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                            'onclick="editThisCandF('+"'"+res[i]['c_and_f']+"',"+res[i]['id']+')' +
                                            '">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                            'onclick="deleteThisCandF('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'types_of_lc'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                    theadHTML += "<th>Type of LC</th>";
                                    theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                        tbodyHTML += "<td>" + res[i]['lc_type'] + "</td>";
                                        tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                            'onclick="editThisLCType('+"'"+res[i]['lc_type']+"',"+res[i]['id']+')' +
                                            '">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                            'onclick="deleteThisLCType('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'insurance_name'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                    theadHTML += "<th>Insurance name</th>";
                                    theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                        tbodyHTML += "<td>" + res[i]['insurance_name'] + "</td>";
                                        tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                            'onclick="editThisInsuName('+"'"+res[i]['insurance_name']+"'," +
                                            ""+res[i]['id']+')">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                            'onclick="deleteThisInsuName('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'currency'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                        theadHTML += "<th>Currency</th>";
                                        theadHTML += "<th>Rate</th>";
                                        theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                            tbodyHTML += "<td>" + res[i]['currency'] + "</td>";
                                            tbodyHTML += "<td>" + res[i]['rate'] + "</td>";
                                            tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                                'onclick="editThisCurrency('+"'"+res[i]['currency']+"','" +
                                                ""+res[i]['rate']+"',"+res[i]['id']+')">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                                'onclick="deleteThisCurrency('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'bank_name'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                        theadHTML += "<th>Bank Name</th>";
                                        theadHTML += "<th>Address</th>";
                                        theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                            tbodyHTML += "<td>" + res[i]['bank_name'] + "</td>";
                                            tbodyHTML += "<td>" + res[i]['address'] + "</td>";
                                            tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                                'onclick="editThisBank('+"'"+res[i]['bank_name']+"','" +
                                                ""+res[i]['address']+"',"+res[i]['id']+')">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                                'onclick="deleteThisBank('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'concern_person'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                    theadHTML += "<th>Name</th>";
                                    theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                        tbodyHTML += "<td>" + res[i]['name'] + "</td>";
                                        tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                            'onclick="editThisConcernPerson('+"'"+res[i]['name']+"'," +
                                            ""+res[i]['id']+')">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                            'onclick="deleteThisConcernPerson('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'vendor'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                    theadHTML += "<th>Name</th>";
                                    theadHTML += "<th>Code</th>";
                                    theadHTML += "<th>Address</th>";
                                    theadHTML += "<th>Valid</th>";
                                    theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                        tbodyHTML += "<td>" + res[i]['name'] + "</td>";
                                        tbodyHTML += "<td>" + res[i]['code'] + "</td>";
                                        tbodyHTML += "<td>" + res[i]['address'] + "</td>";
                                        tbodyHTML += "<td>" + res[i]['valid'] + "</td>";
                                        tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                            'onclick="editThisVendor('+res[i]['id']+')">EDIT</button> '+" <button class='btn btn-sm btn-danger' "+
                                            'onclick="deleteThisVendor('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                                if(type === 'agent'){
                                    var theadHTML = "";
                                    theadHTML += '<tr>';
                                    theadHTML += "<th>Local agent</th>";
                                    theadHTML += "<th>Concern name</th>";
                                    theadHTML += "<th>Mobile no.</th>";
                                    theadHTML += "<th>Mail address</th>";
                                    theadHTML += "<th>Action</th>";
                                    theadHTML += '</tr>';
                                    $('#table_div thead').html(theadHTML);

                                    var tbodyHTML = "";
                                    for (var i = 0; i < res.length; i++) {
                                        tbodyHTML += "<tr>";
                                        tbodyHTML += "<td>" + res[i]['local_agent'] + "</td>";
                                        tbodyHTML += "<td>" + res[i]['concern_name'] + "</td>";
                                        tbodyHTML += "<td>" + res[i]['mob_no'] + "</td>";
                                        tbodyHTML += "<td>" + res[i]['email'] + "</td>";
                                        tbodyHTML += "<td><button class='btn btn-sm btn-info' "+
                                            'onclick="editThisAgent('+res[i]['id']+')">EDIT</button> '+" <button " +
                                            "class='btn btn-sm btn-danger' "+
                                            'onclick="deleteThisAgent('+res[i]['id']+')">DELETE</button></td>';
                                        tbodyHTML += "</tr>";
                                    }
                                    $('#table_div tbody').html(tbodyHTML);
                                    $('#table_div').dataTable();
                                }
                            }else{
                                if ($.fn.dataTable.isDataTable( '#table_div') ) {
                                    $("#table_div").DataTable().destroy();
                                }
                                $("#table_div thead").html("");
                                $("#table_div tbody").html("");

                                $('#table_div tbody').html('<tr><td><p style="color: red;margin-bottom: 0px;">There is no data available' +
                                    '.</p></td></tr>');
                                $('#table_div').css('text-align', 'center');
                            }
                            $('#createBTNdiv').attr('data-type',type);
                            $('#showTable').show();
                            $("#loader").hide();
                        },
                        error: function (e) {
                            console.log(e);
                            $("#loader").hide();
                            $('#showTable').hide();
                        }
                    });
                }
            });
        });
        function editThisCurrency (curr,rate,id) {
           $('#edit_curr_id').val(id);
           $('#edit_curr').val(curr);
           $('#edit_rate').val(rate);
           $("#editCurrencyModal").modal('show');
        }
        function editThisBank (name,add,id) {
           $('#edit_bank_id').val(id);
           $('#edit_bank_name').val(name);
           $('#edit_bank_add').val(add);
           $("#editBankModal").modal('show');
        }
        function editThisDocType (type_of_doc,id) {
           $('#edit_doctype').val(type_of_doc);
           $('#edit_docType_id').val(id);
           $("#editDocTypeModal").modal('show');
        }
        function editThisCandF (c_and_if,id) {
           $('#edit_candf').val(c_and_if);
           $('#edit_candf_id').val(id);
           $("#editCandFModal").modal('show');
        }
        function editThisLCType (lc_type,id) {
           $('#edit_lctype').val(lc_type);
           $('#edit_lcType_id').val(id);
           $("#editLCTypeModal").modal('show');
        }
        function editThisConcernPerson (name,id) {
           $('#edit_concernPName').val(name);
           $('#edit_concernP_id').val(id);
           $("#editConcernPersonModal").modal('show');
        }
        function editThisVendor (id) {
            $.ajax({
                type: 'post',
                url: '{{ url('import_management/getVendorMasterData') }}',
                data:{'id':id, '_token':"{{csrf_token () }}"},
                success: function (data) {
                    // console.log(data);
                    var res = data.result;
                    $('#edit_ven_name').val(res[0]['name']);
                    $('#edit_ven_code').val(res[0]['code']);
                    $('#edit_ven_add').val(res[0]['address']);
                    $('#edit_ven_valid').val(res[0]['valid']);
                    $('#edit_vendor_id').val(id);
                    $("#editVendorModal").modal('show');
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
        function editThisAgent (id) {
            $.ajax({
                type: 'post',
                url: '{{ url('import_management/getAgentMasterData') }}',
                data:{'id':id, '_token':"{{csrf_token () }}"},
                success: function (data) {
                    // console.log(data);
                    var res = data.result;
                    $('#edit_local_agent').val(res[0]['local_agent']);
                    $('#edit_concern_name').val(res[0]['concern_name']);
                    $('#edit_mob_no').val(res[0]['mob_no']);
                    $('#edit_email').val(res[0]['email']);
                    $('#edit_agent_id').val(id);
                    $("#editAgentModal").modal('show');
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
        function editThisInsuName (name,id) {
           $('#edit_insu_name').val(name);
           $('#edit_insu_name_id').val(id);
           $("#editInsuNameModal").modal('show');
        }
        function deleteThisConcernPerson(id){
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
                        url: '{{  url('import_management/deleteConcernPersonData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisDocType(id){
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
                        url: '{{  url('import_management/deleteDocTypeData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisCandF(id){
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
                        url: '{{  url('import_management/deleteCandFData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisLCType(id){
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
                        url: '{{  url('import_management/deleteLCTypeData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisInsuName(id){
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
                        url: '{{  url('import_management/deleteInsuNameData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisCurrency(id){
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
                        url: '{{  url('import_management/deleteCurrData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisBank(id){
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
                        url: '{{  url('import_management/deleteBankData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisVendor(id){
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
                        url: '{{  url('import_management/deleteVendorData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            })
        }
        function deleteThisAgent(id){
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
                        url: '{{  url('import_management/deleteAgentData') }}',
                        data: { 'id':id, '_token': " {{ csrf_token () }} "},
                        success: function (data) {
                            // console.log(data);
                            if(data.status === 1 && (data.result === 1 || data.result === true)){
                                toastr.success("Data deleted successfully");
                                window.location.reload();
                            }else{
                                toastr.error(data.result);
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