@extends('_layout_shared._master')
@section('title','Group Head & ED Approval')

@section('styles')
    <link href="{{ url('public/site_resource/dist/slimselect.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>

        body {
            line-height: 20px;
            font-size: 14px;
        }

        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
            background-color: #46B8DA;
            border-color: #46B8DA;
            color: #fff;
        }

        .form-control {
            border-radius: 0px;
            margin-bottom: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }


        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 10px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }

        body {
            color: #000;
        }

        .btn-primary {
            margin-right: 10px;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/
            /*font-weight: bold;*/

        }

        .tools a:hover {
            background: #337ab7;
        }

        .tools a {
            background: none;
            color: white;
        }

        caption {
            padding-top: 8px;
            padding-bottom: 8px;
            color: black;
            font: caption;
            text-align: center;
        }

        .form-group {
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .s_font {
            font-size: 11px;
            padding: 7px 0;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }
    </style>

@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary" style="color: white">
                        Scientific Seminar Proposal & Bill
                    </label>
                </header>
                <div class="panel-body hd" style="padding-top: 2%">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div class="col-md-4 col-sm-4">
                                        <label for="program_no_for_bill"
                                               class="col-md-3 col-sm-3"
                                               style="padding-right:0px;"><b>Proposal No</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="program_no_for_bill" name="program_no_for_bill"
                                                    class="form-control input-sm filter-option pull-left">
                                                <option value="ALL" selected>All</option>
                                                @foreach($program_no as $pn)
                                                    <option value="{{$pn->prog_no}}">{{$pn->prog_no}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <button type="button" id="verify_display" class="btn btn-default btn-sm" >
                                            <i class="fa fa-chevron-circle-up"></i> <b>Display</b>
                                            <i class="fa fa-spinner fa-spin" id="verify_display_loader"
                                               style="font-size:20px; display:none;"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <label for="bill_no_for_verify"
                                               class="col-md-3 col-sm-3"
                                               style="padding-right:0px;"><b>Bill No</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="bill_no_for_verify" name="bill_no_for_verify"
                                                    class="form-control input-sm filter-option pull-left">
                                                <option value="ALL" selected>All</option>
                                                @foreach($bill_no as $pn)
                                                    <option value="{{$pn->bill_no}}">{{$pn->bill_no}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <button type="button" id="verify_billdisplay" class="btn btn-default btn-sm" >
                                            <i class="fa fa-chevron-circle-up"></i> <b>Display</b>
                                            <i class="fa fa-spinner fa-spin" id="verify_billdisplay_loader"
                                               style="font-size:20px; display:none;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
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

    <div class="row" id="proposalTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary" style="color: white">
                        Proposal List
                    </label>
                </header>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="col-md-12 col-sm-12 table-responsive">
                        <table id="proposalTable" width="100%" class="table table-bordered table-condensed
                        table-striped">
                            <thead style="white-space:nowrap;">
                            <tr>
                                <th style="text-align: center"><input type="checkbox" id="selectAll"><span> </span>All</th>
                                <th>Action</th>
                                <th>Program no.</th>
                                <th>Bill no.</th>
                                <th>RM Name</th>
                                <th>Name of the Institute/Association/Doctor</th>
                                <th>Program Venue</th>
                                <th>Datetime</th>
                                <th>Brand Name</th>
                                <th>Nop Proposed</th>
                                <th>Nop Attended</th>
                                <th>Cost Per Head(Budget)</th>
                                <th>Total Budget Proposal</th>
                                <th>Total Budget Bill</th>
                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;overflow:hidden;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row" id="billTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary" style="color: white">
                        Bill List
                    </label>
                </header>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="col-md-12 col-sm-12 table-responsive">
                        <table id="billTable" width="100%" class="table table-bordered table-condensed
                        table-striped">
                            <thead style="white-space:nowrap;">
                            <tr>
                                <th style="text-align: center"><input type="checkbox" id="selectAllbill"><span> </span>All</th>
                                <th>Action</th>
                                <th>Program no.</th>
                                <th>Bill no.</th>
                                <th>RM Name</th>
                                <th>Name of the Institute/Association/Doctor</th>
                                <th>Program Venue</th>
                                <th>Datetime</th>
                                <th>Brand Name</th>
                                <th>Nop Proposed</th>
                                <th>Nop Attended</th>
                                <th>Cost Per Head(Budget)</th>
                                <th>Total Budget Proposal</th>
                                <th>Total Budget Bill</th>
                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;overflow:hidden;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div aria-hidden="true" aria-labelledby="proposalDetailsLabel" role="dialog" tabindex="-1" id="proposalDetailsModal" class="modal fade">
        <div class="modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Proposal Information</h5>
                    <button type="button" class="btn btn-warning" data-dismiss="modal" style="float: right;">Close</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    <label class="text-primary" style="color: white">
                                        Employee Information
                                    </label>
                                    <span class="tools pull-right">
                                        <a class="fa fa-chevron-up"></a>
                                    </span>
                                </header>
                                <div class="panel-body hd  " id="emp_info">
                                    <form id="emp_info_form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="gm"
                                                       class="control-label"><b>GM</b></label><br/>
                                                <input disabled id="gm" style="width: 100%">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sm"
                                                       class="control-label"><b>SM</b></label>
                                                <div>
                                                    <input id="sm" disabled style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="dsm"
                                                       class="control-label"><b>DSM</b></label><br/>
                                                <input id="dsm" disabled style="width: 100%">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="rm_terr"
                                                       class="control-label"><b>RM Territory</b></label><br>
                                                <input id="rm_terr" disabled style="width: 100%">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="rm_name"
                                                       class="control-label"><b>RM Name</b></label><br>
                                                <input id="rm_name" disabled style="width: 100%">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="am_terr"
                                                       class="control-label"><b>AM</b></label>
                                                <select name="am_terr" id="am_terr"
                                                        class="form-control input-sm">
                                                    <option value="">AM Territory</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="mpo_terr"
                                                       class="control-label"><b>MPO</b></label>
                                                <select name="mpo_terr" id="mpo_terr"
                                                        class="form-control input-sm">
                                                    <option value="">MPO Territory</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="cp"
                                                       class="control-label"><b>Contact Person</b></label><br/>
                                                <input id="cp" style="width: 100%" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="mobile"
                                                       class="control-label"><b>Mobile</b></label><br/>
                                                <input id="mobile" style="width: 100%" type="number">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="depo"
                                                       class="control-label"><b>Depot Name</b></label>
                                                <select name="depo" id="depo"
                                                        class="form-control input-sm">
                                                    <option value="">Select Depot</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="panel" id="data_table">
                                <header class="panel-heading">
                                    <label class="text-primary" style="color: white">
                                        Program Details
                                    </label>
                                </header>
                                <div class="panel-body hd">
                                    <form id="program_info_form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="prog_month"
                                                       class="control-label"><b>Month of Program</b></label>
                                                <input id="prog_month" disabled style="width: 100%">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="program_team"
                                                       class="control-label"><b>Program Team</b></label>
                                                <select name="program_team" id="program_team"
                                                        class="form-control input-sm">
                                                    <option value="">Select</option>
                                                    @foreach($pteam as $team)
                                                        <option value="{{$team->prog_team_name}}">{{$team->prog_team_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="program_type"
                                                       class="control-label"><b>Program Type</b></label><br/>
                                                <select name="program_type" id="program_type"
                                                        class="form-control input-sm">
                                                    <option value="">Select</option>
                                                    @foreach($ptype as $type)
                                                        <option value="{{$type->pt_name}}">{{$type->pt_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="program_no"
                                                       class="control-label"><b>
                                                        Program No</b></label>
                                                <div>
                                                    <input id="program_no" disabled style="width: 100%">
                                                    <input id="req_id" disabled style="display: none;">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="program_venue"
                                                       class="control-label"><b>Program Venue
                                                    </b></label><br/>
                                                <input id="program_venue" style="width: 100%">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="timing"
                                                       class="control-label"><b>Date Time</b></label><br>
                                                <div class='input-group date'>
                                                    <input id='timing' type='text' class="form-control" style="width: 100%" onkeydown="return false">
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="col-md-8 col-sm-8" id="brand_name_direct_bill" style="">
                                                    <label for="brand_name"
                                                           class="control-label"><b>Brand Name</b></label>
                                                    <select id="brand_name" multiple>
                                                        @foreach($brand_name as $bn)
                                                            <option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class=" col-md-1 col-sm-1 "  id="brand_name_edit" style="display: none;text-align: center" >
                                                    <label for="" class="control-label"><b></b></label>
                                                    <br>
                                                    <button type="button" id="edit_brand" class="btn btn-default btn-sm">
                                                        <i class="fa fa-check" aria-hidden="true"></i><b>Update</b>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-10" id="brand_name_program_bill" style="display: none;">
                                                <label for="brand_name_program_bill"
                                                       class="control-label"><b>Brand Name</b></label>
                                                <select id="brand_name_bill">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="advance_budget"
                                                       class="control-label"><b>Advance Budget</b></label> <br/>
                                                <input style="width: 100%" type="number" min="1" id="advance_budget"
                                                       onkeyup="word.innerHTML= convertNumberToWords(this.value)">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="nop"
                                                       class="control-label"><b>Nop proposed</b></label><br/>
                                                <input style="width: 100%" type="number" min="1" id="nop">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="cph"
                                                       class="control-label"><b>Cost Per Head(Budget)</b></label><br/>
                                                <input style="width: 100%" id="cph" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="word" class="control-label"><b>In Word </b></label> <br/>
                                                <div id="word"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="iad"
                                                       class="control-label"><b>Name of the Institute/Association/Doctor</b></label><br/>
                                                <input style="width: 100%" type="text" id="iad">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="pmr"
                                                       class="control-label"><b>Promotional Materials Requisition</b></label><br/>
                                                <input style="width: 100%" type="text" id="pmr">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="panel" id="data_table">
                                <header class="panel-heading">
                                    <label class="text-primary" style="color: white">Expenditure
                                    </label>
                                </header>
                                <div class="panel-body hd  " id="budget_cost_info">
                                    <form id="budget_cost">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-8 table-responsive" id="budget_table_div">
                                                    <table class="table table-condensed table-bordered" id="budget_details">
                                                        <caption>Budget Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Team</th>
                                                            <th>GL</th>
                                                            <th>Cost Center</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="3" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly="" class="total_budget form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-md-8 table-responsive" id="budget_table_div_bill"
                                                     style="display: none">
                                                    <table class="table table-condensed table-bordered" id="budget_details_bill">
                                                        <caption>Budget Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Team</th>
                                                            <th>GL</th>
                                                            <th>Cost Center</th>
                                                            <th>Pro Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="3" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly=""
                                                                          class="total_budget_bill form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 table-responsive" id="cost_table_div">
                                                    <table class="table table-condensed table-bordered" id="cost_details">
                                                        <caption>Cost Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="1" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly="" class="total_cost form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 table-responsive" id="cost_table_div_bill"
                                                     style="display: none">
                                                    <table class="table table-condensed table-bordered" id="cost_details_bill">
                                                        <caption>Cost Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Pro Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="1" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly=""
                                                                          class="total_cost_bill form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div aria-hidden="true" aria-labelledby="billDetailsLabel" role="dialog" tabindex="-1" id="billDetailsModal"
         class="modal fade">
        <div class="modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bill Information</h5>
                    <button type="button" class="btn btn-pr" data-dismiss="modal" style="float: right;">Close</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    <label class="text-primary" style="color: white">
                                        Employee Information
                                    </label>
                                    <span class="tools pull-right"> <a class="fa fa-chevron-up"></a> </span>
                                </header>
                                <div class="panel-body hd  " id="emp_info">
                                    <form id="billemp_info_form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="gm"
                                                           class="control-label"><b>GM</b></label><br/>
                                                    <input readonly id="gm" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sm"
                                                           class="control-label"><b>
                                                            SM</b></label>
                                                    <div>
                                                        <input id="sm" disabled style="width: 100%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dsm"
                                                           class="control-label"><b>DSM
                                                        </b></label><br/>
                                                    <input id="dsm" disabled style="width: 100%">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="control-label"><b>RM Territory</b></label><br>
                                                    <input id="rm_terr" disabled style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="rm_name"
                                                           class="control-label"><b>RM Name</b></label><br>
                                                    <input id="rm_name" disabled style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="am_terr"
                                                           class="control-label"><b>AM</b></label>
                                                    <select name="am_terr" id="am_terr"
                                                            class="form-control input-sm">
                                                        <option value="">AM Territory</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="control-label"><b>MPO</b></label>
                                                    <select name="mpo_terr" id="mpo_terr"
                                                            class="form-control input-sm">
                                                        <option value="">MPO Territory</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cp"
                                                           class="control-label"><b>Contact Person</b></label><br/>
                                                    <input id="cp" style="width: 100%" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mobile"
                                                           class="control-label"><b>Mobile</b></label><br/>
                                                    <input id="mobile" style="width: 100%" type="number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="depo"
                                                           class="control-label"><b>Depot Name</b></label>
                                                    <select name="depo" id="depo"
                                                            class="form-control input-sm">
                                                        <option value="">Select Depot</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="panel" id="data_table">
                                <header class="panel-heading">
                                    <label class="text-primary" style="color: white">
                                        Program Details
                                    </label>
                                </header>
                                <div class="panel-body hd">
                                    <form id="billprogram_info_form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="prog_month"
                                                           class="control-label"><b>Billing Month</b></label>
                                                    <input id="prog_month" disabled style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="program_team"
                                                           class="control-label"><b>Program Team</b></label>
                                                    <select name="program_team" id="program_team"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($pteam as $team)
                                                            <option value="{{$team->prog_team_name}}">{{$team->prog_team_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="program_type"
                                                           class="control-label"><b>Program Type</b></label><br/>
                                                    <select name="program_type" id="program_type"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($ptype as $type)
                                                            <option value="{{$type->pt_name}}">{{$type->pt_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="program_no"
                                                           class="control-label"><b>
                                                            Program No</b></label>
                                                    <div>
                                                        <input id="program_no" disabled style="width: 100%">
                                                        <input id="req_id" disabled style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="bill_no"
                                                           class="control-label"><b>
                                                            Bill No</b></label>
                                                    <div>
                                                        <input id="bill_no" disabled style="width: 100%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="program_venue"
                                                           class="control-label"><b>Program Venue
                                                        </b></label><br/>
                                                    <input id="program_venue" style="width: 100%">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="timing"
                                                           class="control-label"><b>Date Time</b></label><br>
                                                    <div class='input-group date'>
                                                        <input id='timing' type='text' class="form-control" style="width: 100%" onkeydown="return false">
                                                        <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="program_feedback"
                                                           class="control-label"><b>
                                                            Program Feedback</b></label>
                                                    <div>
                                                        <input id="program_feedback" style="width: 100%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="nop"
                                                           class="control-label"><b>Nop proposed</b></label><br/>
                                                    <input style="width: 100%" type="number" min="1" id="nop">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cph"
                                                           class="control-label"><b>Cost Per Head</b></label><br/>
                                                    <input style="width: 100%" id="cph" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="nop_attended"
                                                           class="control-label"><b>Nop Attended</b></label><br/>
                                                    <input style="width: 100%" type="number" min="1" id="nop_attended">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cph_attended"
                                                           class="control-label"><b>Cost Per Head</b></label><br/>
                                                    <input style="width: 100%" id="cph_attended" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10" id="brand_name_direct_bill">
                                                <div class="form-group">
                                                    <label for="billbrand_name"
                                                           class="control-label"><b>Brand Name</b></label>
                                                    <select id="billbrand_name" multiple>
                                                        @foreach($brand_name as $bn)
                                                            <option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-10" id="brand_name_program_bill" style="display: none;">
                                                <div class="form-group">
                                                    <label for="brand_name_program_bill"
                                                           class="control-label"><b>Brand Name</b></label>
                                                    <select id="brand_name_bill">
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- First row ends here--}}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="advance_budget"
                                                           class="control-label"><b>Advance Received</b></label> <br/>
                                                    <input style="width: 100%" type="number" min="1" id="advance_budget"
                                                           onkeyup="word.innerHTML= convertNumberToWords(this.value)">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="actual_expenditure"
                                                           class="control-label"><b>Actual Expenditure</b></label> <br/>
                                                    <input style="width: 100%" type="number" min="1" id="actual_expenditure"
                                                           onkeyup="word.innerHTML= convertNumberToWords(this.value)">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payable"
                                                           class="control-label"><b>Payable/Refundable</b></label><br/>
                                                    <input style="width: 100%" id="payable" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="word"
                                                           class="control-label"><b>In Word </b></label> <br/>
                                                    <div id="word"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="iad"
                                                       class="control-label"><b>Name of the Institute/Association/Doctor</b></label><br/>
                                                <input style="width: 100%" type="text" id="iad">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="pmr"
                                                       class="control-label"><b>Promotional Materials Requisition</b></label><br/>
                                                <input style="width: 100%" type="text" id="pmr">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="panel" id="data_table">
                                <header class="panel-heading">
                                    <label class="text-primary" style="color: white">Expenditure
                                    </label>
                                </header>
                                <div class="panel-body hd  " id="budget_cost_info">
                                    <form id="billbudget_cost">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-8 table-responsive" id="budget_table_div">
                                                    <table class="table table-condensed table-bordered" id="budget_details">
                                                        <caption>Budget Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Team</th>
                                                            <th>GL</th>
                                                            <th>Cost Center</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="3" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly="" class="total_budget form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-md-8 table-responsive" id="budget_table_div_bill"
                                                     style="display: none">
                                                    <table class="table table-condensed table-bordered" id="budget_details_bill">
                                                        <caption>Budget Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Team</th>
                                                            <th>GL</th>
                                                            <th>Cost Center</th>
                                                            <th>Pro Amount</th>
                                                            <th>Actual Expenditure</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="4" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly=""
                                                                          class="total_budget_bill form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 table-responsive" id="cost_table_div">
                                                    <table class="table table-condensed table-bordered" id="cost_details">
                                                        <caption>Cost Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="1" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly="" class="total_cost form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 table-responsive" id="cost_table_div_bill"
                                                     style="display: none">
                                                    <table class="table table-condensed table-bordered" id="cost_details_bill">
                                                        <caption>Cost Details</caption>
                                                        <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Pro Amount</th>
                                                            <th>Actual Expenditure</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="2" style="text-align: right;"><b>Total Amount</b></td>
                                                            <td><b><input type="text" readonly=""
                                                                          class="total_cost_bill form-control"
                                                                          autocomplete="off"></b>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-content')
{{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')
    {{Html::script('public/site_resource/dist/slimselect.min.js')}}

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            var selectf1 =    new SlimSelect({
                select: '#brand_name'
            });

            var selectf2 =    new SlimSelect({
                select: '#billbrand_name'
            });

            var table;
            var table1;
            var verifydata = [];
            var verifybilldata = [];

            $('#program_no_for_bill').select2();
            $('#bill_no_for_verify').select2();

            $("#verify_display").click(function () {
                $('#billTableDiv').hide();
                if ($("#program_no_for_bill").val() === "") {
                    alert("Please select Program No");
                } else {
                    $("#loader").show();
                    var bill = $('#program_no_for_bill').val();

                    $.ajax({
                        url: "{{url('scientific/getProposalDetailInfo')}}",method: "post", dataType: 'json',
                        data: { _token: '{{csrf_token()}}', bill: bill },

                        success: function (resp) {

                            $("#loader").hide();
                            $('#proposalTableDiv').show();

                            $("#proposalTable").DataTable().destroy();

                            table = $("#proposalTable").DataTable({

                                data: resp,
                                dom: '<"toolbar">Bfrtip',
                                buttons: [
                                    {
                                        text: '<span class="accept" >Verify</span>', className: "btn-primary",
                                        action: function (e, dt, node, config) {
                                            var tblData = table.rows('.selected').data();

                                            var tmpData = '';

                                            verifydata.length = 0;

                                            $.each(tblData, function (i, val) {
                                                tmpData = tblData[i];
                                                verifydata.push(tmpData);
                                            });
                                            // console.log(verifydata);

                                            if (verifydata.length !== 0) {
                                                $("#loader").show();
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: 'json',
                                                    data: {
                                                        verifyData: JSON.stringify(verifydata),
                                                        _token: '{{csrf_token()}}'
                                                    },
                                                    url: "{{url('scientific/verify_program_data')}}",
                                                    success: function (data) {
                                                        $("#loader").hide();
                                                        if (data.cost == 1) {
                                                            toastr.success('Programs successfully verified', '',
                                                                {timeOut: 5000});
                                                            window.location.reload();
                                                        } else {
                                                            toastr.error('Could not verify data', '', {timeOut:
                                                                    5000});
                                                        }
                                                    },
                                                    complete: function (data) {
                                                        $("#loader").hide();
                                                    },
                                                    error: function (err) {
                                                        $("#loader").hide();
                                                        console.log(err);
                                                    }
                                                });
                                            }else{
                                                $("#loader").hide();
                                                toastr.error('Choose at least one data', '', {timeOut: 5000});
                                            }
                                        }
                                    },
                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                                        }
                                    }
                                ],
                                columns: [
                                    {data: null},
                                    {
                                        data: null,
                                        "render": function (row) {
                                            return '<button type="button" class="btn btn-warning btn-xs" id="Details"' +
                                                ' onclick="getProposalDetail_data('+"'"+row.prog_no+"'"+')' +
                                            '">Details</button>';
                                        }
                                    },
                                    {data: "prog_no"},
                                    {data: "bill_no"},
                                    {data: "rm_name"},
                                    {data: "program_details"},
                                    {data: "program_venue"},
                                    {data: "prog_date_time"},
                                    {data: "brand_name"},
                                    {data: "nop_proposed"},
                                    {data: "nop_attended"},
                                    {data: "cost_per_head"},
                                    {data: "advance_budget"},
                                    {data: "actual_expenditure"}
                                ],
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                columnDefs: [{
                                    orderable: false,
                                    className: 'select-checkbox',
                                    targets: 0,
                                    render: function (data, type, full, meta) {
                                        return '';
                                    }
                                },
                                {
                                    targets: 12,
                                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                                },
                                {
                                    targets: 13,
                                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                                }],
                                select: {
                                    style: 'multi',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ],
                                info: false,
                                paging: false,
                                "scrollY": true,
                                "scrollX": true
                            });
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                }
            });
            $("#verify_billdisplay").click(function () {
                $('#proposalTableDiv').hide();
                if ($("#bill_no_for_verify").val() === "") {
                    alert("Please select bill no");
                } else {
                    $("#loader").show();
                    var bill = $('#bill_no_for_verify').val();

                    $.ajax({
                        url: "{{url('scientific/getBillDetailInfo')}}",method: "post", dataType: 'json',
                        data: { _token: '{{csrf_token()}}', bill: bill },

                        success: function (resp) {

                            $("#loader").hide();
                            $('#billTableDiv').show();

                            $("#billTable").DataTable().destroy();

                            table1 = $("#billTable").DataTable({

                                data: resp,
                                dom: '<"toolbar">Bfrtip',
                                buttons: [
                                    {
                                        text: '<span class="acceptBill" >Verify</span>', className: "btn-primary",
                                        action: function (e, dt, node, config) {
                                            var tblData = table1.rows('.selected').data();

                                            var tmpData = '';

                                            verifybilldata.length = 0;

                                            $.each(tblData, function (i, val) {
                                                tmpData = tblData[i];
                                                verifybilldata.push(tmpData);
                                            });
                                            // console.log(verifybilldata);

                                            if (verifybilldata.length !== 0) {
                                                $("#loader").show();
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: 'json',
                                                    data: {
                                                        verifybilldata: JSON.stringify(verifybilldata),
                                                        _token: '{{csrf_token()}}'
                                                    },
                                                    url: "{{url('scientific/verify_bill_data')}}",
                                                    success: function (data) {
                                                        $("#loader").hide();
                                                        if (data.cost == 1) {
                                                            toastr.success('Bills successfully verified', '',
                                                                {timeOut: 5000});
                                                            window.location.reload();
                                                        } else {
                                                            toastr.error('Could not verify data', '', {timeOut:
                                                                    5000});
                                                        }
                                                    },
                                                    complete: function (data) {
                                                        $("#loader").hide();
                                                    },
                                                    error: function (err) {
                                                        $("#loader").hide();
                                                        console.log(err);
                                                    }
                                                });
                                            }else{
                                                $("#loader").hide();
                                                toastr.error('Choose at least one data', '', {timeOut: 5000});
                                            }
                                        }
                                    },
                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                                        }
                                    }
                                ],
                                columns: [
                                    {data: null},
                                    {
                                        data: null,
                                        "render": function (row) {
                                            return '<button type="button" class="btn btn-warning btn-xs" id="Details"' +
                                                ' onclick="getBillDetail_data('+"'"+row.bill_no+"'"+')' +
                                                '">Details</button>';
                                        }
                                    },
                                    {data: "prog_no"},
                                    {data: "bill_no"},
                                    {data: "rm_name"},
                                    {data: "program_details"},
                                    {data: "program_venue"},
                                    {data: "prog_date_time"},
                                    {data: "brand_name"},
                                    {data: "nop_proposed"},
                                    {data: "nop_attended"},
                                    {data: "cost_per_head"},
                                    {data: "advance_budget"},
                                    {data: "actual_expenditure"}
                                ],
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                columnDefs: [{
                                    orderable: false,
                                    className: 'select-checkbox',
                                    targets: 0,
                                    render: function (data, type, full, meta) {
                                        return '';
                                    }
                                },
                                {
                                    targets: 12,
                                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                                },
                                {
                                    targets: 13,
                                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                                }],
                                select: {
                                    style: 'multi',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ],
                                info: false,
                                paging: false,
                                "scrollY": true,
                                "scrollX": true
                            });
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                }
            });
            $('#selectAll').on('click', function () {
                if (table.rows('.selected').any()) {
                    table.rows().deselect();
                    $("#selectAll").prop("checked", false);
                } else {
                    table.rows().select();
                }
            });
            $('#selectAllbill').on('click', function () {
                if (table1.rows('.selected').any()) {
                    table1.rows().deselect();
                    $("#selectAllbill").prop("checked", false);
                } else {
                    table1.rows().select();
                }
            });
        });
        function getBillDetail_data(bill){
            document.getElementById("billemp_info_form").reset();
            document.getElementById("billprogram_info_form").reset();
            document.getElementById("billbudget_cost").reset();

            $("#verify_billdisplay_loader").show();

            $('#billDetailsModal #budget_table_div').hide();
            $('#billDetailsModal #cost_table_div').hide();
            $("#billDetailsModal #brand_name_direct_bill").hide();

            $('#billDetailsModal #cp').prop("disabled", true);
            $('#billDetailsModal #mobile').prop("disabled", true);
            $('#billDetailsModal #program_team').prop("disabled", true);
            $('#billDetailsModal #program_type').prop("disabled", true);
            $('#billDetailsModal #program_venue').prop("disabled", true);
            $('#billDetailsModal #timing').prop("disabled", false);
            $('#billDetailsModal #advance_budget').prop("disabled", true);
            $('#billDetailsModal #depo').prop("disabled", true);

            $('#billDetailsModal #program_feedback').prop("disabled", true);
            $('#billDetailsModal #payable').prop("disabled", true);
            $('#billDetailsModal #actual_expenditure').prop("disabled", true);
            $('#billDetailsModal #nop').prop("disabled", true);
            $('#billDetailsModal #nop_attended').prop("disabled", true);
            $('#billDetailsModal #iad').prop("disabled", true);
            $('#billDetailsModal #pmr').prop("disabled", true);


            if (bill === "") {
                alert("Please select Bill No");
            } else {
                $.ajax({
                    url: "{{url('scientific/verify_data_show')}}",
                    method: "post",
                    dataType: 'json',
                    data: {
                        _token: '{{csrf_token()}}',
                        bill: bill
                    },
                    success: function (resp) {
                        var brandn = "";
                        let tr_brn = '';

                        $("#billDetailsModal #brand_name_direct_bill").show();
                        $('#billDetailsModal #budget_table_div_bill').show();
                        $('#billDetailsModal #cost_table_div_bill').show();
                        var program_info = resp.program_info[0];
                        var budget_data = resp.budget_details;

                        var cost_data = resp.cost_details;

                        var brval = program_info['brand_name'];
                        const split_brn = brval.split(",");
                        for(let i=0;i<split_brn.length;i++) {
                            tr_brn += "<option value='" + split_brn[i] + " ' selected>" + split_brn[i] + "</option>";
                        }
                        $('#billbrand_name option:selected').remove();
                        $('#billbrand_name').append(tr_brn);

                        brandn += "<option value='" + brval + " '>" + brval + "</option>";
                        $('#billDetailsModal #brand_name_bill').empty().append(brandn);
                        // $("#billDetailsModal #brand_name_program_bill").show();
                        $("#verify_billdisplay_loader").hide();

                        if ((resp.length) < 1) {
                            toastr.info('Please reload the page');
                        } else {

                            $("#billDetailsModal #gm").val(program_info['gm_name']);
                            $("#billDetailsModal #sm").val(program_info['sm_name']);
                            $("#billDetailsModal #dsm").val(program_info['dsm_name']);
                            $("#billDetailsModal #rm_terr").val(program_info['rm_terr_id']);
                            $("#billDetailsModal #rm_name").val(program_info['rm_name']);
                            $('#billDetailsModal #prog_month').val(program_info['month_of_prog']);
                            $('#billDetailsModal #cp').val(program_info['contact_person']);
                            $('#billDetailsModal #mobile').val(program_info['mobile']);

                            $('#billDetailsModal #program_team').val(program_info['prog_team']);
                            $('#billDetailsModal #program_type').val(program_info['program_type']);
                            $('#billDetailsModal #program_venue').val(program_info['program_venue']);
                            $('#billDetailsModal #program_feedback').val(program_info['program_feedback']);
                            $('#billDetailsModal #timing').val(program_info['prog_date_time']);
                            $('#billDetailsModal #advance_budget').val(program_info['advance_budget']);
                            $('#billDetailsModal #nop').val(program_info['nop_proposed']);
                            $('#billDetailsModal #cph').val(program_info['cost_per_head']);
                            $('#billDetailsModal #program_no').val(program_info['prog_no']);
                            $('#billDetailsModal #bill_no').val(program_info['bill_no']);
                            $('#billDetailsModal #payable').val(program_info['payable_refundable']);

                            $('#billDetailsModal #actual_expenditure').val(program_info['actual_expenditure']);
                            $('#billDetailsModal #nop_attended').val(program_info['nop_attended']);

                            $('#billDetailsModal #iad').val(program_info['program_details']);
                            $('#billDetailsModal #pmr').val(program_info['pm']);


                            var am = "";
                            var idl = program_info['am_terr_id'];
                            var vall = program_info['am_name'];

                            am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";

                            $('#billDetailsModal #am_terr').empty().append(am);

                            var selOptsMPO = "";
                            var id = program_info['mpo_terr_id'];
                            var val = program_info['mpo_name'];
                            var pgroup = program_info['mpo_team'];
                            var depot_id = program_info['depot_id'];
                            var depot_name = program_info['depot_name'];
                            selOptsMPO += "<option value='" + id + "' data-mpo_name = '" + val + "' " +
                                " data-mpo_team = '" + pgroup + "' data-depot_id = '" + depot_id + "'  " +
                                " data-depot_name = '" + depot_name + "'>" + id + ' ' + val + '-' + pgroup + "</option>";

                            $('#billDetailsModal #mpo_terr').empty().append(selOptsMPO);

                            var depot = "";
                            var dpid = program_info['depot_id'];
                            var dpn = program_info['depot_name'];

                            depot += "<option value='" + dpid + "'>"  + dpn + "</option>";

                            $('#billDetailsModal #depo').empty().append(depot);

                            var markup = "";
                            var total_budget = 0;
                            for (var l = 0; l < budget_data.length; l++) {
                                var cct = budget_data[l]['cc_team_name'];
                                var ccn = budget_data[l]['cost_center_id'];
                                var gl = budget_data[l]['gl'];
                                var pro_amt = budget_data[l]['pro_amt'];
                                var bill_amt = budget_data[l]['bill_amt'];
                                total_budget += parseInt(budget_data[l]['bill_amt']);

                                let IndianLocale = Intl.NumberFormat('en-IN');

                                markup += "<tr>" +
                                    "<td>" + cct + "</td>" +
                                    "<td>" + gl + "</td>" +
                                    "<td>" + ccn + "</td>" +
                                    "<td>" + IndianLocale.format(pro_amt) + "</td>" +
                                    "<td>" + IndianLocale.format(bill_amt) + "</td>" +
                                    "</tr>";
                            }

                            let IndianLocale = Intl.NumberFormat('en-IN');

                            $("#billDetailsModal #budget_details_bill tbody").empty().append(markup);
                            $("#billDetailsModal .total_budget_bill").val(IndianLocale.format(total_budget));

                            var markup_cost_table = "";
                            var total_cost = 0;
                            for (var l = 0; l < cost_data.length; l++) {
                                var cct = cost_data[l]['ci_name'];
                                var amt = cost_data[l]['pro_amt'];
                                var bill_amt = cost_data[l]['bill_amt'];
                                total_cost +=  parseInt(cost_data[l]['bill_amt']);

                                let IndianLocale = Intl.NumberFormat('en-IN');

                                markup_cost_table += "<tr>" +
                                    "<td>" + cct + "</td>" +
                                    "<td>" + IndianLocale.format(amt) + "</td>" +
                                    "<td>" + IndianLocale.format(bill_amt) + "</td>" +
                                    "</tr>";
                            }

                            $("#billDetailsModal #cost_details_bill tbody").empty().append(markup_cost_table);
                            $("#billDetailsModal .total_cost_bill").val(IndianLocale.format(total_cost));
                            $('#billDetailsModal').modal('show');
                        }
                    },
                    error: function (err) {
                        $('#billDetailsModal').modal('hide');
                        $("#verify_billdisplay_loader").hide();
                    }
                });
            }

        }
        function getProposalDetail_data(bill){
            $('#brand_name option:selected').remove();
            document.getElementById("emp_info_form").reset();
            document.getElementById("program_info_form").reset();
            document.getElementById("budget_cost").reset();

            $("#verify_display_loader").show();
            $('#proposalDetailsModal #budget_table_div').hide();
            $('#proposalDetailsModal #cost_table_div').hide();

            $('#proposalDetailsModal #cp').prop("disabled", true);
            $('#proposalDetailsModal #mobile').prop("disabled", true);
            $('#proposalDetailsModal #program_team').prop("disabled", true);
            $('#proposalDetailsModal #depo').prop("disabled", true);
            $('#proposalDetailsModal #program_type').prop("disabled", true);
            $('#proposalDetailsModal #program_venue').prop("disabled", true);
            $('#proposalDetailsModal #timing').prop("disabled", true);
            $('#proposalDetailsModal #advance_budget').prop("disabled", true);

            $('#proposalDetailsModal #program_feedback').prop("disabled", true);
            $('#proposalDetailsModal #payable').prop("disabled", true);
            $('#proposalDetailsModal #actual_expenditure').prop("disabled", true);
            $('#proposalDetailsModal #nop').prop("disabled", true);
            $('#proposalDetailsModal #nop_attended').prop("disabled", true);
            $('#proposalDetailsModal #iad').prop("disabled", true);
            $('#proposalDetailsModal #pmr').prop("disabled", true);

            if (bill === "") {
                alert("Please select Program No");
            } else {

                $.ajax({
                    url: "{{url('scientific/verify_data_program')}}",
                    method: "post",
                    dataType: 'json',
                    data: {_token: '{{csrf_token()}}', bill: bill },
                    success: function (resp) {

                        $('#proposalDetailsModal #budget_table_div_bill').show();
                        $('#proposalDetailsModal #cost_table_div_bill').show();

                        var program_info = resp.program_info[0];
                        var budget_data = resp.budget_details;

                        var cost_data = resp.cost_details;
                        var brandn = "";
                        let tr_brn = '';
                        let selbrand = '';
                        var brval = program_info['brand_name'];
                        const split_brn = brval.split(",");

                        for(let i=0;i<split_brn.length;i++) {
                            tr_brn += "<option value='" + split_brn[i] + " ' selected>" + split_brn[i] + "</option>";
                        }

                        $('#proposalDetailsModal #brand_name option:selected').remove();
                        $('#proposalDetailsModal #brand_name').append(tr_brn);

                        brandn += "<option value='" + brval + " '>" + brval + "</option>";
                        $('#proposalDetailsModal #brand_name_bill').empty().append(brandn);
                        // $("#proposalDetailsModal #brand_name_program_bill").show();
                        // $("#proposalDetailsModal #brand_name_edit").show();
                        $("#verify_display_loader").hide();

                        if ((resp.length) < 1) {
                            toastr.info('Please reload the page');
                        } else {

                            $("#proposalDetailsModal #gm").val(program_info['gm_name']);
                            $("#proposalDetailsModal #sm").val(program_info['sm_name']);
                            $("#proposalDetailsModal #dsm").val(program_info['dsm_name']);
                            $("#proposalDetailsModal #rm_terr").val(program_info['rm_terr_id']);
                            $("#proposalDetailsModal #rm_name").val(program_info['rm_name']);
                            $('#proposalDetailsModal #prog_month').val(program_info['month_of_prog']);
                            $('#proposalDetailsModal #cp').val(program_info['contact_person']);
                            $('#proposalDetailsModal #mobile').val(program_info['mobile']);

                            $('#proposalDetailsModal #program_team').val(program_info['prog_team']);
                            $('#proposalDetailsModal #program_type').val(program_info['program_type']);
                            $('#proposalDetailsModal #program_venue').val(program_info['program_venue']);
                            $('#proposalDetailsModal #timing').val(program_info['prog_date_time']);
                            $('#proposalDetailsModal #advance_budget').val(program_info['advance_budget']);
                            $('#proposalDetailsModal #nop').val(program_info['nop_proposed']);
                            $('#proposalDetailsModal #cph').val(program_info['cost_per_head']);
                            $('#proposalDetailsModal #program_no').val(program_info['prog_no']);
                            $('#proposalDetailsModal #bill_no').val(program_info['bill_no']);
                            $('#proposalDetailsModal #program_feedback').val(program_info['program_feedback']);
                            $('#proposalDetailsModal #payable').val(program_info['payable_refundable']);

                            $('#proposalDetailsModal #actual_expenditure').val(program_info['actual_expenditure']);
                            $('#proposalDetailsModal #nop_attended').val(program_info['nop_attended']);

                            $('#proposalDetailsModal #iad').val(program_info['program_details']);
                            $('#proposalDetailsModal #pmr').val(program_info['pm']);


                            var am = "";
                            var idl = program_info['am_terr_id'];
                            var vall = program_info['am_name'];

                            am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";

                            $('#proposalDetailsModal #am_terr').empty().append(am);

                            var selOptsMPO = "";
                            var id = program_info['mpo_terr_id'];
                            var val = program_info['mpo_name'];
                            var pgroup = program_info['mpo_team'];
                            var depot_id = program_info['depot_id'];
                            var depot_name = program_info['depot_name'];
                            selOptsMPO += "<option value='" + id + "' data-mpo_name = '" + val + "' " +
                                " data-mpo_team = '" + pgroup + "' data-depot_id = '" + depot_id + "'  " +
                                " data-depot_name = '" + depot_name + "'>" + id + ' ' + val + '-' + pgroup + "</option>";

                            $('#proposalDetailsModal #mpo_terr').empty().append(selOptsMPO);

                            var depot = "";
                            var dpid = program_info['depot_id'];
                            var dpn = program_info['depot_name'];

                            depot += "<option value='" + dpid + "'>"  + dpn + "</option>";

                            $('#proposalDetailsModal #depo').empty().append(depot);

                            var markup = "";
                            var total_budget = 0;

                            for (var l = 0; l < budget_data.length; l++) {

                                var cct = budget_data[l]['cc_team_name'];
                                var ccn = budget_data[l]['cost_center_id'];
                                var gl = budget_data[l]['gl'];
                                var pro_amt = budget_data[l]['pro_amt'];

                                total_budget += parseInt(budget_data[l]['pro_amt']);

                                let IndianLocale = Intl.NumberFormat('en-IN');

                                markup += "<tr>" +
                                    "<td>" + cct + "</td>" +
                                    "<td>" + gl + "</td>" +
                                    "<td>" + ccn + "</td>" +
                                    "<td>" + IndianLocale.format(pro_amt)  + "</td>" +
                                    "</tr>";
                            }

                            let IndianLocale = Intl.NumberFormat('en-IN');

                            $("#proposalDetailsModal #budget_details_bill tbody").empty().append(markup);
                            $("#proposalDetailsModal .total_budget_bill").val(IndianLocale.format(total_budget));

                            var markup_cost_table = "";
                            var total_cost = 0;
                            for (var l = 0; l < cost_data.length; l++) {
                                var cct = cost_data[l]['ci_name'];
                                var amt = cost_data[l]['pro_amt'];

                                total_cost +=  parseInt(cost_data[l]['pro_amt']);

                                let IndianLocale = Intl.NumberFormat('en-IN');

                                markup_cost_table += "<tr>" +
                                    "<td>" + cct + "</td>" +
                                    "<td>" + IndianLocale.format(amt) + "</td>" +
                                    "</tr>";
                            }

                            $("#proposalDetailsModal #cost_details_bill tbody").empty().append(markup_cost_table);
                            $("#proposalDetailsModal .total_cost_bill").val(IndianLocale.format(total_cost));
                            $('#proposalDetailsModal').modal('show');
                        }
                    },
                    error: function (err) {
                        $('#proposalDetailsModal').modal('hide');
                        $("#verify_display_loader").hide();
                    }
                });

            }
        }
        function convertNumberToWords(amount) {
            var words = new Array();
            words[0] = '';
            words[1] = 'One';
            words[2] = 'Two';
            words[3] = 'Three';
            words[4] = 'Four';
            words[5] = 'Five';
            words[6] = 'Six';
            words[7] = 'Seven';
            words[8] = 'Eight';
            words[9] = 'Nine';
            words[10] = 'Ten';
            words[11] = 'Eleven';
            words[12] = 'Twelve';
            words[13] = 'Thirteen';
            words[14] = 'Fourteen';
            words[15] = 'Fifteen';
            words[16] = 'Sixteen';
            words[17] = 'Seventeen';
            words[18] = 'Eighteen';
            words[19] = 'Nineteen';
            words[20] = 'Twenty';
            words[30] = 'Thirty';
            words[40] = 'Forty';
            words[50] = 'Fifty';
            words[60] = 'Sixty';
            words[70] = 'Seventy';
            words[80] = 'Eighty';
            words[90] = 'Ninety';
            amount = amount.toString();
            var atemp = amount.split(".");
            var number = atemp[0].split(",").join("");
            var n_length = number.length;
            var words_string = "";
            if (n_length <= 9) {
                var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                var received_n_array = new Array();
                for (var i = 0; i < n_length; i++) {
                    received_n_array[i] = number.substr(i, 1);
                }
                for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                    n_array[i] = received_n_array[j];
                }
                for (var i = 0, j = 1; i < 9; i++, j++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        if (n_array[i] == 1) {
                            n_array[j] = 10 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        }
                    }
                }
                value = "";
                for (var i = 0; i < 9; i++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        value = n_array[i] * 10;
                    } else {
                        value = n_array[i];
                    }
                    if (value != 0) {
                        words_string += words[value] + " ";
                    }
                    if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Crores ";
                    }
                    if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Lakhs ";
                    }
                    if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Thousand ";
                    }
                    if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                        words_string += "Hundred and ";
                    } else if (i == 6 && value != 0) {
                        words_string += "Hundred ";
                    }
                }
                words_string = words_string.split("  ").join(" ");
            }
            return words_string;
        }
    </script>
@endsection