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




    </style>
@endsection
@section('right-content')

    {{-- Filter Option--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Display Hotel Management System Data
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
                                                   style="padding-right:0px;"><b>Guest Name:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="select_guest" name="select_guest" class="form-control input-sm filter-option">
                                                    <option selected disabled>Select Guest Name</option>
                                                    @foreach($allEmployee as $allEmployees)
                                                        <option value="{{$allEmployees->guest_name}}">{{$allEmployees->guest_name}}</option>
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
                                    <th>Guest Name</th>
                                    <th>Reference</th>
                                    <th>Country</th>
                                    <th>Hotel Name</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Room Type</th>
                                    <th>Duration Of Stay</th>
                                    <th>Payment By</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Date</th>
                                    <th>Invoice Amount</th>
                                    <th>Payment Date</th>
                                    <th>Payment Amount</th>
                                    <th>Payment Status</th>
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
                            <label for="edit_guest_name" class="control-label col-sm-2">Guest Name.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_guest_name"  onkeyup="this.value = this.value.toUpperCase();" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_reference" class="control-label col-sm-2">Reference:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_reference"  onkeyup="this.value = this.value.toUpperCase();" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="edit_country" class="control-label col-sm-2">Country:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_country"  onkeyup="this.value = this.value.toUpperCase();" value="" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_hotel_name" class="control-label col-sm-2">Hotel Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_hotel_name" onkeyup="this.value = this.value.toUpperCase();" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_check_in" class="control-label col-sm-2">Check in:</label>
                            <div class="col-sm-10">
                                <input type="" class="form-control" id="edit_check_in" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_check_out" class="control-label col-sm-2">Check Out:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_check_out" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_room_type" class="control-label col-sm-2">Room Type:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_room_type" onkeyup="this.value = this.value.toUpperCase();" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_duration" class="control-label col-sm-2">Duration Of Stay.:</label>
                            <div class="col-sm-10">
                                <input type="" class="form-control" id="edit_duration" onkeyup="this.value = this.value.toUpperCase();"  value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_payment_by" class="control-label col-sm-2">Payment By:</label>
                            <div class="col-sm-10">
                                <input type=""  class="form-control" id="edit_payment_by" onkeyup="this.value = this.value.toUpperCase();" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_invoice_no" class="control-label col-sm-2">Invoice No:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_invoice_no" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_invoice_date" class="control-label col-sm-2">Invoice Date:</label>
                            <div class="col-sm-10">
                                <input type=""  class="form-control" id="edit_invoice_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_invoice_amount" class="control-label col-sm-2">Invoice Amount:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_invoice_amount" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_payment_date" class="control-label col-sm-2">Payment Date:</label>
                            <div class="col-sm-10">
                                <input type=""  class="form-control" id="edit_payment_date" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_payment_amount" class="control-label col-sm-2">Payment Amount:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_payment_amount" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_payment_status" class="control-label col-sm-2">Payment Status:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_payment_status" onkeyup="this.value = this.value.toUpperCase();" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_remarks" class="control-label col-sm-2">Remarks:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_remarks" onkeyup="this.value = this.value.toUpperCase();" value="">
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



    {{--From--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-body" style="padding-top: 2%">

                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Hotel Management Form</legend>
                        <div class="form-horizontal">
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">

                                            <div class="col-md-2 col-sm-2">
                                                <label for="com_name"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Guest Name:</b><span class='cls-req'>*</span></label>

                                                <input type="text" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                       value="" name="guest_name"
                                                       id="guest_name" >

                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="reference" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Reference:</b><span class='cls-req'>*</span></label>

                                                <input type="text" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                       value="" name="reference"
                                                       id="reference" >

                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="country"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Country:</b></label>

                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="country" min="1"
                                                       placeholder="" name="country" >

                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="hotel_name"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Hotel Name:</b></label>

                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="hotel_name" min="1"
                                                       placeholder="" name="hotel_name" >

                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="com_name"
                                                       class=" control-label fnt_size"
                                                       style="padding-right:0px;"><b>Check In:</b></label>
                                                    <input type="" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                           value="" name="check_in" min='1'
                                                           id="check_in" >

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="plant_id" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Check Out:</b></label>

                                                    <input type="" class="form-control input-sm"
                                                           value="" name="check_out"
                                                           id="check_out" >
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <div class="col-md-2 col-sm-2">
                                                <label for="room_type"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Room Type:</b></label>


                                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                           class="form-control input-xs" id="room_type" min="1"
                                                           placeholder="" name="room_type" >

                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="duration"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Duration of Stay:</b></label>

                                                <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="duration" min="1"
                                                       placeholder="" name="duration" >

                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="com_name"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Payment By:</b></label>

                                                    <input type="text" class="form-control input-sm" onkeyup="this.value = this.value.toUpperCase();"
                                                           value="" name="payment_by"
                                                           id="payment_by" >
                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="invoice_no" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Invoice No.:</b></label>

                                                    <input type="number" class="form-control input-sm"
                                                           value="" name="invoice_no" min="1"
                                                           id="invoice_no" >

                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Invoice Date:</b></label>

                                                <input type="" class="form-control input-sm"
                                                       value="" name="invoice_date"
                                                       id="invoice_date" >

                                            </div>


                                            <div class="col-md-2 col-sm-2">
                                                <label for="invoice_amount"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Invoice Amount:</b></label>

                                                    <input type="number"  min='1' onkeyup="this.value = this.value.toUpperCase();"
                                                           class="form-control input-xs" id="invoice_amount" min="1"
                                                           placeholder="" name="invoice_amount" >
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-2 col-sm-2">
                                                <label for="payment_date"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Payment Date:</b></label>

                                                    <input type="" class="form-control input-sm"
                                                           value="" name="payment_date"
                                                           id="payment_date" >

                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="payment_amount" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Payment Amount:</b></label>

                                                    <input type="number" class="form-control input-sm"
                                                           value="" min="1"  name="payment_amount"
                                                           id="payment_amount" >

                                            </div>


                                            <div class="col-md-2 col-sm-2">
                                                <label for="payment_status"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Payment Status:</b></label>

                                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                           class="form-control input-xs" id="payment_status" min="1"
                                                           placeholder="" name="payment_status" >
                                            </div>


                                            <div class="col-md-2 col-sm-2">
                                                <label for="remarks"
                                                       class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Remarks:</b></label>

                                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                           class="form-control input-xs" id="remarks" min="1"
                                                           placeholder="" name="remarks">
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
                            </form>
                        </div>

                    </fieldset>

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

            $('#select_guest').change(function () {
                $('#display_report').prop("disabled", false);
            });

            var date = new Date();
            $('#check_in').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });


            $('#check_out').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#invoice_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#payment_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });


            $('#edit_check_in').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });


            $('#edit_check_out').datetimepicker({
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
            $('#edit_invoice_date').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });


            $('#invoice_amount').on('keyup change', function(e) {
                            var $invoice_amount = $("#invoice_amount").val();
                            $("#payment_amount").val($invoice_amount)
            });


            $('#invoice_amount,#payment_amount').on('keyup change', function(e) {
                            var $payment_amount = $("#payment_amount").val();

                            if($payment_amount==''){
                                $("#payment_status").val('DUE');

                            }else {
                                $("#payment_status").val('PAID');
                            }
            });


            /*Form Info*/

            $('#submit_form').on('click', function (e) {

                e.preventDefault();
                $("#loader").show();

                var  guest_name = $('#guest_name').val();
                var  reference = $('#reference').val();
                var  country = $('#country').val();
                var  hotel_name = $('#hotel_name').val();
                var  check_in = $('#check_in').val();
                var  check_out = $('#check_out').val();
                var  room_type = $('#room_type').val();
                var  duration = $('#duration').val();
                var  payment_by = $('#payment_by').val();
                var  invoice_no = $('#invoice_no').val();
                var  invoice_date = $('#invoice_date').val();
                var  invoice_amount = $('#invoice_amount').val();
                var  payment_date = $('#payment_date').val();
                var  payment_amount = $('#payment_amount').val();
                var  payment_status = $('#payment_status').val();
                var  remarks = $('#remarks').val();


                var dataList = {};


                dataList.guest_name=guest_name;
                dataList.reference=reference;
                dataList.country=country;
                dataList.hotel_name=hotel_name;
                dataList.check_in_date=check_in;
                dataList.check_out_date=check_out;
                dataList.room_type=room_type;
                dataList.duration_of_stay=duration;
                dataList.payment_by=payment_by;
                dataList.invoice_no=invoice_no;
                dataList.invoice_date=invoice_date;
                dataList.invoice_amount=invoice_amount;
                dataList.payment_date=payment_date;
                dataList.payment_amount=payment_amount;
                dataList.payment_status=payment_status;
                dataList.remarks=remarks;


                var dataListObject = JSON.stringify(dataList);

                if(guest_name==''||reference=='')
                {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Input Required Field!!',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                    $("#loader").hide();
                    return 0;
                }else{

                    $.ajax({
                        type: 'post',
                        url: '{{  url('visaAirTicketAndHotelInfoSys/hotelManagement/saveHotelInfoSystem') }}',
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

                            }else if(data.result=='error'){
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

                $("#loader").show();
                var guest_name = $('#select_guest').val();
                var table = null;

                console.log("guest name")
                console.log(guest_name)

                $.ajax({
                    type: 'post',
                    url: '{{  url('visaAirTicketAndHotelInfoSys/hotelManagement/getDataTableData') }}',
                    data: { 'guest_name': guest_name, '_token': "{{ csrf_token
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
                                {data: "guest_name"},
                                {data: "reference"},
                                {data: "country"},
                                {data: "hotel_name"},
                                {data: "check_in_date"},
                                {data: "check_out_date"},
                                {data: "room_type"},
                                {data: "duration_of_stay"},
                                {data: "payment_by"},
                                {data: "invoice_no"},
                                {data: "invoice_date"},
                                {data: "invoice_amount"},
                                {data: "payment_date"},
                                {data: "payment_amount"},
                                {data: "payment_status"},
                                {data: "remarks"},
                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-primary editButton row-edit ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="editThisRecord('+"'"+row.id+"','"+row.guest_name+"','"+row.reference+"','"+row.country+"','"
                                            +row.hotel_name+"','"+row.check_in_date+"','"+row.check_out_date+"','"+row.room_type+"','"+row.duration_of_stay+"','"+row.payment_by+"','"+row.invoice_no+"'," +
                                            "'"+row.invoice_date+"','"+row.invoice_amount+"','"+row.payment_date+"','"+row.payment_amount+"','"+row.payment_status+"','"+row.remarks+"')"+'">EDIT</button>'
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
                                                columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15]
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
                                                columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14,15]
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

                var edit_guest_name= $("#edit_guest_name").val();
                var edit_reference  = $("#edit_reference").val();
                var edit_country  = $("#edit_country").val();
                var edit_hotel_name  = $("#edit_hotel_name").val();
                var edit_check_in  = $("#edit_check_in").val();
                var edit_check_out  = $("#edit_check_out").val();
                var edit_room_type  = $("#edit_room_type").val();
                var edit_duration  = $("#edit_duration").val();
                var edit_payment_by  = $("#edit_payment_by").val();
                var edit_invoice_no  = $("#edit_invoice_no").val();
                var edit_invoice_date  = $("#edit_invoice_date").val();
                var edit_invoice_amount  = $("#edit_invoice_amount").val();
                var edit_payment_date  = $("#edit_payment_date").val();
                var edit_payment_amount  = $("#edit_payment_amount").val();
                var edit_payment_status  = $("#edit_payment_status").val();
                var edit_remarks  = $("#edit_remarks").val();

                var dataList = {};

                dataList.edit_guest_name=edit_guest_name;
                dataList.edit_reference=edit_reference;
                dataList.edit_country=edit_country;
                dataList.edit_hotel_name=edit_hotel_name;
                dataList.edit_check_in=edit_check_in;
                dataList.edit_check_out=edit_check_out;
                dataList.edit_room_type=edit_room_type;
                dataList.edit_duration=edit_duration;
                dataList.edit_payment_by=edit_payment_by;
                dataList.edit_invoice_no=edit_invoice_no;
                dataList.edit_invoice_date=edit_invoice_date;
                dataList.edit_invoice_amount=edit_invoice_amount;
                dataList.edit_payment_date=edit_payment_date;
                dataList.edit_payment_amount=edit_payment_amount;
                dataList.edit_payment_status=edit_payment_status;
                dataList.edit_remarks=edit_remarks;


                var itemArrayData = JSON.stringify(dataList)


                $.ajax({
                        type: 'post',
                        url: '{{  url('visaAirTicketAndHotelInfoSys/hotelManagement/updateHotelManagementData') }}',
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
                        url: '{{  url('visaAirTicketAndHotelInfoSys/hotelManagement/deleteHotelManagementData') }}',
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



        function editThisRecord(id,guest_name,reference,country,hotel_name,check_in_date,check_out_date,room_type,duration_of_stay,payment_by,
                                invoice_no,invoice_date,invoice_amount,payment_date,payment_amount,payment_status,remarks
                               ){


            $("#table_id").val(id);

            if(guest_name=='null'){
                $("#edit_guest_name").val("");
            }else{
                $("#edit_guest_name").val(guest_name);
            }

            if(reference=='null'){
                $("#edit_reference").val("");
            }else{
                $("#edit_reference").val(reference);
            }

            if(country=='null'){
                $("#edit_country").val("");
            }else{
                $("#edit_country").val(country);
            }

            if(hotel_name=='null'){
                $("#edit_hotel_name").val("");
            }else{
                $("#edit_hotel_name").val(hotel_name);
            }

            if(check_in_date=='null'){
                $("#edit_check_in").val("");
            }else{
                $("#edit_check_in").val(check_in_date);
            }

            if(check_out_date=='null'){
                $("#edit_check_out").val("");
            }else{
                $("#edit_check_out").val(check_out_date);
            }

            if(room_type=='null'){
                $("#edit_room_type").val("");
            }else{
                $("#edit_room_type").val(room_type);
            }

            if(duration_of_stay=='null'){
                $("#edit_duration").val("");
            }else{
                $("#edit_duration").val(duration_of_stay);
            }

            if(payment_by=='null'){
                $("#edit_payment_by").val("");
            }else{
                $("#edit_payment_by").val(payment_by);
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

            if(invoice_amount=='null'){
                $("#edit_invoice_amount").val("");
            }else{
                $("#edit_invoice_amount").val(invoice_amount);
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

            if(payment_status=='null'){
                $("#edit_payment_status").val("");
            }else{
                $("#edit_payment_status").val(payment_status);
            }

            if(remarks=='null'){
                $("#edit_remarks").val("");
            }else{
                $("#edit_remarks").val(remarks);
            }

            $("#editTypeSubtypeModal").modal('show');

            $('#edit_invoice_amount').on('keyup change', function(e) {
                var $invoice_amount = $("#edit_invoice_amount").val();
                $("#edit_payment_amount").val($invoice_amount)
            });


            $('#edit_invoice_amount,#edit_payment_amount').on('keyup change', function(e) {
                var $payment_amount = $("#edit_payment_amount").val();

                if($payment_amount==''){
                    $("#edit_payment_status").val('DUE');

                }else {
                    $("#edit_payment_status").val('PAID');
                }
            });



        }

    </script>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection