@extends('_layout_shared._master')
@section('title','Factory Managers Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>

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
            text-align: left !important;
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

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }



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

        .cls-req{
            color: red;
            font-weight: bold;
        }
    </style>
@endsection
@section('right-content')

    {{-- Filter Option--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Display Visa Air Ticket Information System
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Employee:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="select_emp" name="select_emp" class="form-control input-sm filter-option">
                                                    <option selected disabled>Select Employee</option>
                                                    @foreach($allEmployee as $allEmployees)
                                                        <option value="{{$allEmployees->employee_code}}">{{$allEmployees->employee_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="display_report" class="btn btn-warning btn-sm" disabled>
                                                    <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">
                                                </div>
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

    {{--show datatable--}}
    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead style="background-color: #454790; color: white;">
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Employee Code</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>Plant</th>
                                    <th>GL</th>
                                    <th>CC</th>
                                    <th>TD NO.</th>
                                    <th>TD Date</th>
                                    <th>Destination</th>
                                    <th>Estimation Cost</th>
                                    <th>Departure Date</th>
                                    <th>Arrival Date</th>
                                    <th>Carrier</th>
                                    <th>Sector</th>
                                    <th>classes</th>
                                    <th>Airlines Name</th>
                                    <th>Agency</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Date</th>
                                    <th>Ticket Cost</th>
                                    <th>Visa Cost</th>
                                    <th>Hotel Cost</th>
                                    <th>Tax Cost</th>
                                    <th>Total Amount</th>
                                    <th>Payment Date</th>
                                    <th>Payment Amount</th>
                                    <th>Due Amount</th>
                                    <th>Payment Status</th>
                                    <th>Bill Ref.</th>
                                    <th>Remarks</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
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

    {{--Modal for update--}}
    <div id="editTypeSubtypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color: #46B8DA">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Item</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_emp_name" class="control-label col-sm-2">Employee Name.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_emp_name" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_emp_code" class="control-label col-sm-2">Employee Code:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_emp_code" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="edit_desig" class="control-label col-sm-2">Designation:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_desig" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_dept" class="control-label col-sm-2">Department:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_dept" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_plant" class="control-label col-sm-2">Plant:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_plant" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_gl" class="control-label col-sm-2">GL:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_gl" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_cc" class="control-label col-sm-2">CC:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_cc" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_td_no" class="control-label col-sm-2">TD No.:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_td_no" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_td_date" class="control-label col-sm-2">TD Date:</label>
                            <div class="col-sm-10">
                                <input type=""  class="form-control" id="edit_td_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_destination" class="control-label col-sm-2">Destination:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_destination" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_estimation_cost" class="control-label col-sm-2">Estimation Cost:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_estimation_cost" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_departure_date" class="control-label col-sm-2">Departure Date:</label>
                            <div class="col-sm-10">
                                <input type="" class="form-control" id="edit_departure_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_arrival_date" class="control-label col-sm-2">Arrival Date:</label>
                            <div class="col-sm-10">
                                <input type=""  class="form-control" id="edit_arrival_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_carrier" class="control-label col-sm-2">Carrier:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_carrier" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_sector" class="control-label col-sm-2">Sector:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_sector" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_class" class="control-label col-sm-2">Classes:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_class" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_airline_names" class="control-label col-sm-2">Airlines Name:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_airline_names" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_agency" class="control-label col-sm-2">Agency:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_agency" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_invoice_no" class="control-label col-sm-2">Invoice No:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_invoice_no" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_invoice_date" class="control-label col-sm-2">Invoice Date:</label>
                            <div class="col-sm-10">
                                <input type="" class="form-control" id="edit_invoice_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_ticket_cost" class="control-label col-sm-2">Ticket Cost:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_ticket_cost" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_visa_cost" class="control-label col-sm-2">Visa Cost:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_visa_cost" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_hotel_cost" class="control-label col-sm-2">Hotel Cost:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_hotel_cost" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_tax_cost" class="control-label col-sm-2">Tax Cost:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_tax_cost" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_total_amount" class="control-label col-sm-2">Total Amount:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_total_amount" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_payment_date" class="control-label col-sm-2">Payment Date:</label>
                            <div class="col-sm-10">
                                <input type="" class="form-control" id="edit_payment_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_payment_amount" class="control-label col-sm-2">Payment Amount:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_payment_amount" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_due_amount" class="control-label col-sm-2">Due Amount:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_due_amount" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_payment_status" class="control-label col-sm-2">Payment Status:</label>
                            <div class="col-sm-10">
                                <input type="text" min="1" class="form-control" id="edit_payment_status" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_bill_ref" class="control-label col-sm-2">Bill Ref:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_bill_ref" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_remarks" class="control-label col-sm-2">Remarks:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_remarks" value="" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="update_record">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--Form--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">

                <div class="panel-body" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Visa And Air Ticket Form</legend>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="col-md-2 col-sm-2">
                                                <label for="com_code"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Employee Name:</b></label>

                                                <select id="employee_name_form" name="employee_name_form" class="form-control input-sm filter-option">
                                                    <option selected disabled>Select Employee</option>
                                                    @foreach($allEmp as $allEmps)
                                                        <option value="{{$allEmps->emp_id}}">{{$allEmps->emp_id}}-{{$allEmps->sur_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="com_name"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Employee Code:</b></label>

                                                <input type="text" class="form-control input-sm"
                                                       value="" name="emp_code_form" id="emp_code_form" disabled>

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="plant_id" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Designation:</b></label>

                                                <input type="text" class="form-control input-sm"
                                                       value="" name="emp_deg_form"
                                                       id="emp_deg_form" disabled>
                                            </div>


                                            <div class="col-md-2 col-sm-2">
                                                <label for="main_id"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Department:</b></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="dept_name_form" min="1"
                                                       placeholder="" name="dept_name_form" readonly>
                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="plant_id" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Plant:</b></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="plant_id_form" min="1"
                                                       placeholder="" name="plant_id_form" readonly>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="gl_form"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>GL:</b></label>
                                                <input type="text" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                       value="" placeholder="" name="gl_form"
                                                       id="gl_form">
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="col-md-2 col-sm-2">
                                                <label for="cc_form"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>CC:</b></label>

                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="" name="cc_form"
                                                       id="cc_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="td_no_form"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>TD No.:</b></label>

                                                <input type="number" class="form-control input-sm"
                                                       value="" placeholder="" name="td_no_form"
                                                       id="td_no_form">
                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="td_date_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>TD Date:</b></label>

                                                <input type="" class="form-control input-sm" id="td_date_form"
                                                       placeholder="" name="td_date_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="destination_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Destination:</b></label>

                                                <input type="text" class="form-control input-sm"  onkeyup="this.value = this.value.toUpperCase();"
                                                       value="" placeholder="" name="destination_form"
                                                       id="destination_form">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="estimate_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Estimate Cost:</b></label>

                                                <input type="number" class="form-control input-sm"
                                                       value="" placeholder="" min="1" name="estimate_cost_form"
                                                       id="estimate_cost_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="dp_date_form"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Departure Date:</b></label>

                                                <input type="" class="form-control input-sm" id="dp_date_form"
                                                       placeholder="" name="dp_date_form">

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-2 col-sm-2">
                                                <label for="arr_date_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Arrival Date:</b></label>

                                                <input type="" class="form-control input-sm" id="arr_date_form"
                                                       placeholder="" name="arr_date_form">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="unit" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Carrier:</b></label>
                                                <input type="text" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                       value="" placeholder="" name="carrier_form"
                                                       id="carrier_form">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="sector_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Sector:</b></label>
                                                <input type="text" class="form-control input-sm" id="sector_form" onkeyup="this.value = this.value.toUpperCase();"
                                                       placeholder="" name="sector_form">
                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="class_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Class:</b></label>
                                                <input type="text" class="form-control input-sm" id="class_form" onkeyup="this.value = this.value.toUpperCase();"
                                                       placeholder="" name="class_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="airline_name_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Airlines Name: </b></label>
                                                <input type="text" class="form-control input-sm" id="airline_name_form" onkeyup="this.value = this.value.toUpperCase();"
                                                       name="airline_name_form" min="1" value="">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="agency_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Agency:</b></label>
                                                <input type="text" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                       value="" placeholder="" name="agency_form"
                                                       id="agency_form">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-2 col-sm-2">
                                                <label for="invoice_no_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Invoice No: </b></label>
                                                <input type="text" class="form-control input-sm" id="invoice_no_form"
                                                       placeholder="" name="invoice_no_form">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="inv_date_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Invoice Date:</b></label>
                                                <input type="" class="form-control input-sm" id="inv_date_form"
                                                       placeholder="" name="inv_date_form">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="ticket_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Ticket Cost:</b> </label>
                                                <input type="number" class="form-control input-sm" id="ticket_cost_form"
                                                       name="ticket_cost_form" min="1"  value="">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="visa_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Visa Cost:</b></label>
                                                <input type="number" class="form-control input-sm"
                                                       value="" placeholder="" min="1"  name="visa_cost_form"
                                                       id="visa_cost_form">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="hotel_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Hotel Cost: </b></label>
                                                <input type="number" class="form-control input-sm" id="hotel_cost_form"
                                                       placeholder="" min="1"  name="hotel_cost_form">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="tax_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Tax Cost:</b></label>
                                                <input type="number" class="form-control input-sm" id="tax_cost_form"
                                                       placeholder="" min="1"  name="tax_cost_form">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-2 col-sm-2">
                                                <label for="total_amnt_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Total Amount: </b></label>
                                                <input type="number" class="form-control input-sm" id="total_amnt_form"
                                                       name="total_amnt_form" min="1"  value="">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="pamt_date_form" class="control-label fnt_size"
                                                       style="padding-right:0px"><b>Payment Date:</b></label>
                                                <input type="" class="form-control input-sm" id="pamt_date_form"
                                                       placeholder="" name="pamt_date_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="payment_amnt_form" class="control-label fnt_size"
                                                       style="padding-right:0px"><b>Payment Amount: </b></label>
                                                <input type="number" class="form-control input-sm" id="payment_amnt_form"
                                                       placeholder="" min="1"  name="payment_amnt_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="due_amnt_form" class="control-label fnt_size"
                                                       style="padding-right:0px"><b>Due Amount:</b></label>
                                                <input type="number" class="form-control input-sm" id="due_amnt_form"
                                                       placeholder="" min="1"  name="due_amnt_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="payment_status_form" class="control-label fnt_size"
                                                       style="padding-right:0px"><b>Payment Status: </b></label>
                                                <input type="text" class="form-control input-sm" id="payment_status_form" onkeyup="this.value = this.value.toUpperCase();"
                                                       name="payment_status_form">

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="bill_ref_form" class="control-label fnt_size"
                                                       style="padding-right:0px"><b>Bill Ref.:</b></label>
                                                <input type="text" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                       value="" placeholder="" name="bill_ref_form"
                                                       id="bill_ref_form">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-5 col-sm-5">
                                                <label for="remarks_form" class="control-label fnt_size"
                                                       style="padding-right:0px"><b>Remarks:</b></label>

                                                <input type="text" class="form-control input-sm" id="remarks_form" onkeyup="this.value = this.value.toUpperCase();"
                                                       placeholder="" name="remarks_form">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-6" >
                                                <button type="button" id="submit_form" class="btn btn-info btn-sm"
                                                        style="float: right">
                                                    <i class="fa fa-chevron-circle-up"></i> <b>Submit</b>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

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
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            var date = new Date();
            $('#td_date_form').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#dp_date_form').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#arr_date_form').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#inv_date_form').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#pamt_date_form').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });


            $('#edit_td_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#edit_departure_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });
            $('#edit_arrival_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });
            $('#edit_invoice_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#edit_payment_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#total_amnt_form').on('keyup change', function(e) {
                var $total_amnt = $("#total_amnt_form").val();
                $("#payment_amnt_form").val($total_amnt)
            });

            $('#ticket_cost_form,#visa_cost_form,#hotel_cost_form,#tax_cost_form').on('keyup change', function(e) {

                var $ticket_cost_form = $("#ticket_cost_form").val();
                var $visa_cost_form = $("#visa_cost_form").val();
                var $hotel_cost_form = $("#hotel_cost_form").val();
                var $tax_cost_form = $("#tax_cost_form").val();

                if($ticket_cost_form||$visa_cost_form||$hotel_cost_form||$tax_cost_form){

                    if(!$ticket_cost_form){
                        $ticket_cost_form=0;
                    }
                    if(!$visa_cost_form){
                        $visa_cost_form=0;
                    }
                    if(!$hotel_cost_form){
                        $hotel_cost_form=0;
                    }
                    if(!$tax_cost_form){
                        $tax_cost_form=0;
                    }

                    var $total_amount = parseInt($ticket_cost_form)+ parseInt($visa_cost_form)+ parseInt($hotel_cost_form)
                        +parseInt($tax_cost_form);


                    $("#total_amnt_form").val($total_amount);
                }

                $("#payment_amnt_form").val($total_amount);

                var $total_amount = $("#total_amnt_form").val();
                var $payment_amount = $("#payment_amnt_form").val();

                if($total_amount && $payment_amount){
                    var $due_amount=parseInt($total_amount)- parseInt($payment_amount);
                    $("#due_amnt_form").val($due_amount);


                    if(parseInt($total_amount) == parseInt($payment_amount)){

                        $("#payment_status_form").val('PAID');

                    }else{
                        $("#payment_status_form").val('DUE');

                    }

                }else {

                    $("#due_amnt_form").val('');
                }


            });

            $('#total_amnt_form,#payment_amnt_form').on('keyup change', function(e) {
                var $total_amount = $("#total_amnt_form").val();
                var $payment_amount = $("#payment_amnt_form").val();

                if($total_amount && $payment_amount){
                    var $due_amount= parseInt($total_amount)- parseInt($payment_amount);
                    $("#due_amnt_form").val($due_amount);
                }else {
                    $("#due_amnt_form").val('');
                }

                if( parseInt($total_amount) == parseInt($payment_amount)){

                    $("#payment_status_form").val('PAID');

                }else {
                    $("#payment_status_form").val('DUE');
                }
            });


            /*Form Info*/
            $('#employee_name_form').select2();
            $('#select_emp').select2();
            $('#select_emp').change(function () {
                $('#display_report').prop("disabled", false);
            });


            $('#employee_name_form').change(function () {

                console.log("employee name has changed")
                var employee_id = $('#employee_name_form').val();

                $.ajax({
                    type: 'get',
                    url: '{{  url('visaAirTicketAndHotelInfoSys/visaAirTicket/getEmpInfo') }}',
                    data: {'employee_id': employee_id},
                    success: function (data) {
                        console.log("sayla Empoyee Data")
                        console.log(data)

                        if(data.allEmpData.length > 0){
                            $('#emp_code_form').val(data.allEmpData[0].emp_id);
                            $('#plant_id_form').val(data.allEmpData[0].plant_id);

                            $('#emp_deg_form').val(data.allEmpData[0].desig_name);

                            $('#dept_id_form').val(data.allEmpData[0].dept_id);
                            $('#dept_name_form').val(data.allEmpData[0].dept_name);

                        }else{
                            /* $('#plant_name_form').html("");
                             $('#plant_name_form').append('<option value="0" selected disabled>No Plant available in this Category' +
                                 '</option>');*/
                        }
                    },
                    error: function () {
                    }
                });
            });

            $('#submit_form').on('click', function (e) {

                e.preventDefault();
                $("#loader").show();

                var employee_name = $('#employee_name_form :selected').text();
                var employee_code =  $('#employee_name_form').val();


                var designation = $('#emp_deg_form').val();
                var department = $('#dept_name_form').val();
                var plant = $('#plant_id_form').val();
                var gl = $('#gl_form').val();
                var cc = $('#cc_form').val();
                var td_no = $('#td_no_form').val();
                var td_date = $('#td_date_form').val();
                var destination = $('#destination_form').val();
                var estimation_cost = $('#estimate_cost_form').val();
                var departure_date = $('#dp_date_form').val();
                var  arrival_date = $('#arr_date_form').val();
                var carrier = $('#carrier_form').val();
                var sector = $('#sector_form').val();
                var classes = $('#class_form').val();
                var airline_names = $('#airline_name_form').val();
                var  agency = $('#agency_form').val();
                var  invoice_no = $('#invoice_no_form').val();
                var  invoice_date = $('#inv_date_form').val();
                var  ticket_cost = $('#ticket_cost_form').val();
                var  visa_cost = $('#visa_cost_form').val();
                var  hotel_cost = $('#hotel_cost_form').val();
                var  tax_cost = $('#tax_cost_form').val();
                var  total_amount = $('#total_amnt_form').val();
                var   payment_date = $('#pamt_date_form').val();
                var   payment_amount = $('#payment_amnt_form').val();
                var   due_amount = $('#due_amnt_form').val();
                var   payment_status = $('#payment_status_form').val();
                var   bill_ref = $('#bill_ref_form').val();
                var   remarks = $('#remarks_form').val();


                var dataList = {};

                dataList.employee_name=employee_name;
                dataList.employee_code=employee_code;
                dataList.designation=designation;
                dataList.department=department;
                dataList.plant=plant;
                dataList.gl=gl;
                dataList.cc=cc;
                dataList.td_no=td_no;
                dataList.td_date=td_date;
                dataList.destination=destination;
                dataList.estimation_cost=estimation_cost;
                dataList.departure_date=departure_date;
                dataList.arrival_date=arrival_date;
                dataList.carrier=carrier;
                dataList.airline_names=airline_names;
                dataList.sector=sector;
                dataList.classes=classes;
                dataList.agency=agency;
                dataList.invoice_no=invoice_no;
                dataList.invoice_date=invoice_date;
                dataList.ticket_cost=ticket_cost;
                dataList.visa_cost=visa_cost;
                dataList.hotel_cost=hotel_cost;
                dataList.tax_cost=tax_cost;
                dataList.total_amount=total_amount;
                dataList.payment_date=payment_date;
                dataList.payment_amount=payment_amount;
                dataList.due_amount=due_amount;
                dataList.payment_status=payment_status;
                dataList.bill_ref=bill_ref;
                dataList.remarks=remarks;


                var dataListObject = JSON.stringify(dataList);

                if(employee_name==''||employee_name=='Select Employee')
                {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Select An Employee!!',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                    $("#loader").hide();
                    return 0;
                }else{

                    $.ajax({
                        type: 'post',
                        url: '{{  url('visaAirTicketAndHotelInfoSys/visaAirTicket/saveAirTicketData') }}',
                        data: { 'dataListObject': dataListObject, '_token': "{{ csrf_token
                    () }}"},
                        success: function (data) {

                            $("#loader").hide();
                            if(data.result=='success'){
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

                            }else if(data.result=='exists'){
                                Swal.fire({
                                    title: 'Warning!',
                                    text: 'User Already Exists',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        },
                        error: function (e) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something was wrong! Failed to save.',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            })
                            console.log("in error")
                        }
                    });
                }
            });

            /*Display datatable*/
            $('#display_report').on('click', function (e) {
                // e.preventDefault();
                $("#loader").show();
                var employee_code = $('#select_emp').val();
                var table = null;

                $.ajax({
                    type: 'post',
                    url: '{{  url('visaAirTicketAndHotelInfoSys/visaAirTicket/getDataTableData') }}',
                    data: { 'employee_code': employee_code, '_token': "{{ csrf_token
                    () }}"},
                    success: function (data) {
                        console.log("datatable data")
                        console.log(data);


                        $("#showTable").show();
                        $("#loader").hide();
                        $("#elr").DataTable().destroy();

                        table = $("#elr").DataTable({

                            data: data.result,
                            columns: [
                                {data: "employee_name"},
                                {data: "employee_code"},
                                {data: "designation"},
                                {data: "department"},
                                {data: "plant"},
                                {data: "gl"},
                                {data: "cc"},
                                {data: "td_no"},
                                {data: "td_date"},
                                {data: "destination"},
                                {data: "estimation_cost"},
                                {data: "departure_date"},
                                {data: "arrival_date"},
                                {data: "carrier"},
                                {data: "sector"},
                                {data: "classes"},
                                {data: "airline_names"},
                                {data: "agency"},
                                {data: "invoice_no"},
                                {data: "invoice_date"},
                                {data: "ticket_cost"},
                                {data: "visa_cost"},
                                {data: "hotel_cost"},
                                {data: "tax_cost"},
                                {data: "total_amount"},
                                {data: "payment_date"},
                                {data: "payment_amount"},
                                {data: "due_amount"},
                                {data: "payment_status"},
                                {data: "bill_ref"},
                                {data: "remarks"},

                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-primary editButton row-edit ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="editThisRecord('+"'"+row.id+"','"+row.employee_name+"','"+row.employee_code+"','"+row.designation+"','"
                                            +row.department+"','"+row.plant+"','"+row.gl+"','"+row.cc+"','"+row.td_no+"','"+row.td_date+"','"+row.destination+"'," +
                                            "'"+row.estimation_cost+"','"+row.departure_date+"','"+row.arrival_date+"','"+row.carrier+"','"+row.sector+"','"+row.classes+"'," +
                                            "'"+row.airline_names+"','"+row.agency+"','"+row.invoice_no+"','"+row.invoice_date+"','"+row.ticket_cost+"','"+row.visa_cost+"','"+row.hotel_cost+"','"+row.tax_cost+"'," +
                                            "'"+row.total_amount+"','"+row.payment_date+"','"+row.payment_amount+"','"+row.due_amount+"','"+row.payment_status+"','"+row.bill_ref+"','"+row.remarks+"')"+'">EDIT</button>'
                                    }
                                },

                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-primary editButton row-edit ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="deleteThisRecord('+"'"+row.id+"')"+'">DELETE</button>'
                                    }
                                },
                            ],
                            columnDefs: [
                                {
                                    "defaultContent": " ",
                                    "targets": "_all"
                                }
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
                                                columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
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
                                                columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
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
            });


            $("#update_record").on('click',function (){

                var table_id= $("#table_id").val();
                var edit_gl  = $("#edit_gl").val();
                var edit_cc  = $("#edit_cc").val();
                var edit_td_no  = $("#edit_td_no").val();
                var edit_td_date  = $("#edit_td_date").val();
                var edit_destination  = $("#edit_destination").val();
                var edit_estimation_cost  = $("#edit_estimation_cost").val();
                var edit_departure_date  = $("#edit_departure_date").val();
                var edit_arrival_date  = $("#edit_arrival_date").val();
                var edit_carrier  = $("#edit_carrier").val();
                var edit_sector  = $("#edit_sector").val();
                var edit_class  = $("#edit_class").val();
                var edit_airline_names  = $("#edit_airline_names").val();
                var edit_agency  = $("#edit_agency").val();
                var edit_invoice_no  = $("#edit_invoice_no").val();
                var edit_invoice_date  = $("#edit_invoice_date").val();
                var edit_ticket_cost  = $("#edit_ticket_cost").val();
                var edit_visa_cost  = $("#edit_visa_cost").val();
                var edit_tax_cost  = $("#edit_tax_cost").val();
                var edit_hotel_cost  = $("#edit_hotel_cost").val();
                var edit_total_amount  = $("#edit_total_amount").val();
                var edit_payment_date  = $("#edit_payment_date").val();
                var edit_payment_amount  = $("#edit_payment_amount").val();
                var edit_due_amount  = $("#edit_due_amount").val();
                var edit_payment_status  = $("#edit_payment_status").val();
                var edit_bill_ref  = $("#edit_bill_ref").val();
                var edit_remarks  = $("#edit_remarks").val();

                var dataList = {};

                dataList.gl=edit_gl;
                dataList.cc=edit_cc;
                dataList.td_no=edit_td_no;
                dataList.td_date=edit_td_date;
                dataList.destination=edit_destination;
                dataList.estimation_cost=edit_estimation_cost;
                dataList.departure_date=edit_departure_date;
                dataList.arrival_date=edit_arrival_date;
                dataList.carrier=edit_carrier;
                dataList.sector=edit_sector;
                dataList.classes=edit_class;
                dataList.airline_names=edit_airline_names;
                dataList.agency=edit_agency;
                dataList.invoice_no=edit_invoice_no;
                dataList.invoice_date=edit_invoice_date;
                dataList.ticket_cost=edit_ticket_cost;
                dataList.visa_cost=edit_visa_cost;
                dataList.hotel_cost=edit_hotel_cost;
                dataList.tax_cost=edit_tax_cost;
                dataList.total_amount=edit_total_amount;
                dataList.payment_date=edit_payment_date;
                dataList.payment_amount=edit_payment_amount;
                dataList.due_amount=edit_due_amount;
                dataList.payment_status=edit_payment_status;
                dataList.bill_ref=edit_bill_ref;
                dataList.remarks=edit_remarks;



                var itemArrayData = JSON.stringify(dataList)


                console.log("display test data")
                console.log(itemArrayData)


                $.ajax({
                    type: 'post',
                    url: '{{  url('visaAirTicketAndHotelInfoSys/visaAirTicket/updateAirTicketData') }}',
                    data: { 'id':table_id, 'itemArray':itemArrayData, '_token': "{{ csrf_token () }}"},
                    success: function (data) {
                        console.log("in update Success")
                        console.log(data)



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

            })

        });


        function deleteThisRecord(id){
            console.log(id);
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
                        url: '{{  url('visaAirTicketAndHotelInfoSys/visaAirTicket/deleteAirTicketData') }}',
                        data: { 'id':id, '_token': "{{ csrf_token () }}"},
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


        function editThisRecord(id,employee_name,employee_code,designation,department,plant,gl,cc,td_no,td_date,
                                destination,estimation_cost,departure_date,arrival_date,carrier,sector,classes,
                                airline_names,agency,invoice_no,invoice_date,ticket_cost,visa_cost,hotel_cost,tax_cost,total_amount,payment_date,payment_amount,
                                due_amount,payment_status,bill_ref,remarks){

            $("#table_id").val(id);

            console.log("console in edit this record")
            console.log(gl)
            console.log(cc)

            if(employee_name=='null'){
                $("#edit_emp_name").val("");
            }else{
                $("#edit_emp_name").val(employee_name);
            }

            if(employee_code=='null'){
                $("#edit_emp_code").val("");
            }else{
                $("#edit_emp_code").val(employee_code);
            }

            if(designation=='null'){
                $("#edit_desig").val("");
            }else{
                $("#edit_desig").val(designation);
            }

            if(department=='null'){
                $("#edit_dept").val("");
            }else{
                $("#edit_dept").val(department);
            }

            if(plant=='null'){
                $("#edit_plant").val("");
            }else{
                $("#edit_plant").val(plant);
            }

            if(gl=='null' ){
                $("#edit_gl").val("");
            }else{
                $("#edit_gl").val(gl);
            }


            if(cc=='null'){
                $("#edit_cc").val("");
            }else{
                $("#edit_cc").val(cc);
            }


            if(td_no=='null'){
                $("#edit_td_no").val("");
            }else{
                $("#edit_td_no").val(td_no);
            }

            if(td_date=='null'){
                $("#edit_td_date").val("");
            }else{
                $("#edit_td_date").val(td_date);
            }

            if(destination=='null'){
                $("#edit_destination").val("");
            }else{
                $("#edit_destination").val(destination);
            }


            if(estimation_cost=='null'){
                $("#edit_estimation_cost").val("");
            }else{
                $("#edit_estimation_cost").val(estimation_cost);
            }

            if(departure_date=='null'){
                $("#edit_departure_date").val("");
            }else{
                $("#edit_departure_date").val(departure_date);
            }

            if(arrival_date=='null'){
                $("#edit_arrival_date").val("");
            }else{
                $("#edit_arrival_date").val(arrival_date);
            }


            if(carrier=='null'){
                $("#edit_carrier").val("");
            }else{
                $("#edit_carrier").val(carrier);
            }


            if(sector=='null'){
                $("#edit_sector").val("");
            }else{
                $("#edit_sector").val(sector);
            }

            if(classes=='null'){
                $("#edit_class").val("");
            }else{
                $("#edit_class").val(classes);
            }

            if(airline_names=='null'){
                $("#edit_airline_names").val("");
            }else{
                $("#edit_airline_names").val(airline_names);
            }

            if(agency=='null'){
                $("#edit_agency").val("");
            }else{
                $("#edit_agency").val(agency);
            }

            if(invoice_no=='null'){
                $("#edit_invoice_no").val("");
            }else{
                $("#edit_invoice_no").val(invoice_no);
            }
            if(invoice_date=='null'){
                $("#edit_invoice_date").val("");
            }else{
                $("#edit_invoice_date").val(invoice_date);
            }

            if(ticket_cost=='null'){
                $("#edit_ticket_cost").val("");
            }else{
                $("#edit_ticket_cost").val(ticket_cost);
            }


            if(visa_cost=='null'){
                $("#edit_visa_cost").val("");
            }else{
                $("#edit_visa_cost").val(visa_cost);
            }

            if(hotel_cost=='null'){
                $("#edit_hotel_cost").val("");
            }else{
                $("#edit_hotel_cost").val(hotel_cost);
            }

            if(tax_cost=='null'){
                $("#edit_tax_cost").val("");
            }else{
                $("#edit_tax_cost").val(tax_cost);
            }

            if(total_amount=='null'){
                $("#edit_total_amount").val("");
            }else{
                $("#edit_total_amount").val(total_amount);
            }

            if(payment_date=='null'){
                $("#edit_payment_date").val("");
            }else{
                $("#edit_payment_date").val(payment_date);
            }

            if(payment_amount=='null'){
                $("#edit_payment_amount").val("");
            }else{
                $("#edit_payment_amount").val(payment_amount);
            }

            if(due_amount=='null'){
                $("#edit_due_amount").val("");
            }else{
                $("#edit_due_amount").val(due_amount);
            }

            if(payment_status=='null'){
                $("#edit_payment_status").val("");
            }else{
                $("#edit_payment_status").val(payment_status);
            }

            if(bill_ref=='null'){
                $("#edit_bill_ref").val("");
            }else{
                $("#edit_bill_ref").val(bill_ref);
            }

            if(remarks=='null'){
                $("#edit_remarks").val("");
            }else{
                $("#edit_remarks").val(remarks);
            }

            $("#editTypeSubtypeModal").modal('show');


            $('#edit_ticket_cost,#edit_visa_cost,#edit_hotel_cost,#edit_tax_cost').on('keyup change', function(e) {

                var $edit_ticket_cost = $("#edit_ticket_cost").val();
                var $edit_visa_cost = $("#edit_visa_cost").val();
                var $edit_hotel_cost = $("#edit_hotel_cost").val();
                var $edit_tax_cost = $("#edit_tax_cost").val();

                if($edit_ticket_cost||$edit_visa_cost||$edit_hotel_cost||$edit_tax_cost){

                    if(!$edit_ticket_cost){
                        $edit_ticket_cost=0;
                    }
                    if(!$edit_visa_cost){
                        $edit_visa_cost=0;
                    }
                    if(!$edit_hotel_cost){
                        $edit_hotel_cost=0;
                    }
                    if(!$edit_tax_cost){
                        $edit_tax_cost=0;
                    }
                    var $total_amount = parseInt($edit_ticket_cost)+  parseInt($edit_visa_cost)+ parseInt($edit_hotel_cost)
                        +parseInt($edit_tax_cost);
                    $("#edit_total_amount").val($total_amount);
                }

                $("#edit_payment_amount").val($total_amount);

                var $total_amount = $("#edit_total_amount").val();
                var $edit_payment_amount = $("#edit_payment_amount").val();

                if($total_amount && $edit_payment_amount){
                    var $due_amount=parseInt($total_amount)- parseInt($edit_payment_amount);
                    $("#edit_due_amount").val($due_amount);

                    if(parseInt($total_amount) == parseInt($edit_payment_amount)){

                        $("#edit_payment_status").val('PAID');

                    }else {
                        $("#edit_payment_status").val('DUE');
                    }
                }else {
                    $("#edit_due_amount").val('');
                }


            });

            $('#edit_total_amount,#edit_payment_amount').on('keyup change', function(e) {
                var $edit_total_amount = $("#edit_total_amount").val();
                var $edit_payment_amount = $("#edit_payment_amount").val();

                if($edit_total_amount && $edit_payment_amount){
                    var $due_amount= parseInt($edit_total_amount)- parseInt($edit_payment_amount);
                    $("#edit_due_amount").val($due_amount);
                }else {
                    $("#edit_due_amount").val('');
                }

                if( parseInt($edit_total_amount) == parseInt($edit_payment_amount)){

                    $("#edit_payment_status").val('PAID');

                }else {
                    $("#edit_payment_status").val('DUE');
                }
            });



            /*  $('#edit_total_amount').on('keyup change', function(e) {
                  var $total_amnt = $("#edit_total_amount").val();
                  $("#edit_payment_amount").val($total_amnt)
              });

              $('#edit_total_amount,#edit_payment_amount').on('keyup change', function(e) {
                  var $total_amount = $("#edit_total_amount").val();
                  var $payment_amount = $("#edit_payment_amount").val();

                  if($total_amount && $payment_amount){
                      var $due_amount=$total_amount-$payment_amount;
                      $("#edit_due_amount").val($due_amount);
                  }else {
                      $("#edit_due_amount").val('');
                  }

                  if($total_amount == $payment_amount){

                      $("#edit_payment_status").val('PAID');

                  }else {
                      $("#edit_payment_status").val('DUE');
                  }
              });*/
        }

    </script>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection