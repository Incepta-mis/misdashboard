@extends('_layout_shared._master')
@section('title','Scientific Seminar Bill')

@section('styles')

{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.css" rel="stylesheet"></link>--}}

    <link href="{{ url('public/site_resource/dist/slimselect.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>

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

        label {
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 0px;
            margin-top: 0px;
        }

    </style>

@endsection

@section('right-content')

    <script>
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

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary" style="color: white">
                        Scientific Seminar Bill
                    </label>
                </header>

                <div class="panel-body">
                    @if(Auth::user()->desig === 'RM'||Auth::user()->desig === 'ASM'||Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM'|| Auth::user()->urole === '1')

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="bgt_month"
                                           class="control-label"><b>Month of Program</b></label>
                                    <select name="bgt_month" id="bgt_month"
                                            class="form-control input-sm">
                                        <option value="">Select</option>
                                        @foreach($month_name as $mn)
                                            <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class=" col-md-2">
                                <label></label><br>
                                <button type="button" id="direct_bill" class="btn btn-default btn-sm">
                                    <i class="fa fa-check" aria-hidden="true"></i><b>Direct Bill</b>
                                    <i class="fa fa-spinner fa-spin" id="direct_bill_loader"
                                       style="font-size:20px; display:none;"></i>
                                </button>

                            </div>


                            <div class=" col-md-2">
                                <label>Proposal No</label><br>
                                <select name="program_no_for_bill" id="program_no_for_bill"
                                        class="form-control input-sm">
                                    <option value="">select program no</option>
                                    @foreach($program_no as $pn)
                                        <option value="{{$pn->prog_no}}">{{$pn->prog_no}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class=" col-md-2">
                                <label></label><br>
                                <button type="button" id="program_bill" class="btn btn-default btn-sm">
                                    <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                    <i class="fa fa-spinner fa-spin" id="program_bill_loader"
                                       style="font-size:20px; display:none;"></i>
                                </button>
                            </div>

                            <div class=" col-md-2">
                                <label>Bill No</label><br>
                                <select name="bill_no_for_verify" id="bill_no_for_verify"
                                        class="form-control input-sm">
                                    <option value="">select Bill no</option>
                                    @foreach($bill_no as $pn)
                                        <option value="{{$pn->bill_no}}">{{$pn->bill_no}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class=" col-md-1">
                                <label></label><br>
                                <button type="button" id="verify_display" class="btn btn-default btn-sm">
                                    <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                    <i class="fa fa-spinner fa-spin" id="verify_display_loader"
                                       style="font-size:20px; display:none;"></i>
                                </button>
                            </div>


                        </div>

                    @endif

                        @if(Auth::user()->desig === 'HO' ||Auth::user()->desig === 'DSM'||Auth::user()->desig === 'SM'||Auth::user()->desig === 'GM')

                            @if(Auth::user()->urole !== '1')

                            <div class="row">

                                <div class=" col-md-2">
                                    <label>Bill No</label><br>
                                    <select name="bill_no_for_verify" id="bill_no_for_verify"
                                            class="form-control input-sm">
                                        <option value="">select Bill no</option>
                                        @foreach($bill_no as $pn)
                                            <option value="{{$pn->bill_no}}">{{$pn->bill_no}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class=" col-md-1">
                                    <label></label><br>
                                    <button type="button" id="verify_display" class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                        <i class="fa fa-spinner fa-spin" id="verify_display_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>

                            </div>

                            @endif

                        @endif


                </div>
            </section>
        </div>
    </div>

    <div id="direct_bill_form" style="display:none;">

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

                        <form id="program_info_form">

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
                                        <label for="brand_name"
                                               class="control-label"><b>Brand Name</b></label>
                                        <select id="brand_name" multiple>
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

                            <div class="row">

                                <div class=" col-md-1 col-sm-2 col-xs-6" id="save_button_direct_bill"
                                     style="display: none">
                                    <button type="button" id="save" class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Save</b>
                                    </button>

                                </div>

                                <div class=" col-md-1 col-sm-2 col-xs-6" id="save_button_program_bill"
                                     style="display: none;">
                                    <button type="button" id="save_program_bill" class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Save Bill</b>
                                    </button>

                                </div>

                                <div class=" col-md-1 col-sm-2 col-xs-6" id="verify_button" style="display: none;">
                                    <button type="button" id="btn_verify" class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Verify</b>
                                    </button>
                                </div>

                                <div class=" col-md-1 col-sm-2 col-xs-6" id="delete_button" style="display: none;">
                                    <button type="button" id="btn_delete" class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Delete</b>
                                        {{--                                    <i class="fa fa-spinner fa-spin" id="verify_button_loader"--}}
                                        {{--                                       style="font-size:20px; display:none;"></i>--}}
                                    </button>
                                </div>

                            </div>


                        </form>

                    </div>
                </section>
            </div>
        </div>

    </div>

    @include('scientific.delete_requisition')
    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.js"></script>--}}

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

    <script type="text/javascript">

        create_program = "{{url('scientific/create_bill')}}";
        am_change = "{{url('scientific/am_change')}}";
        update_button = "{{url('scientific/update_button')}}";
        save_button_direct_bill = "{{url('scientific/save_button_direct_bill')}}";
        save_button_program_bill = "{{url('scientific/save_button_program_bill')}}";
        program_bill = "{{url('scientific/program_bill')}}";
        insert_cost = "{{url('scientific/insert_cost')}}";
        verify_data = "{{url('scientific/verify_data_show')}}";
        verify_update = "{{url('scientific/verify_update')}}";
        depo = "{{url('scientific/depo')}} ";
        gl_cc = "{{url('scientific/gl_cc')}} ";
        delete_button = "{{url('scientific/delete_button_bill')}}";
        _csrf_token = '{{csrf_token()}}';
        var table;
        var proposal_no_for_delete = '';

        $(document).ready(function () {

                new SlimSelect({
                    select: '#brand_name'
                })

            $("#btn_delete").click(function () {

                proposal_no_for_delete = $("#bill_no").val();
                console.log('delete button clicked');
                // console.log(prog_no);
                $('.deleteRequisitioin').modal('show');

            });

            $('.del-modal-requisition').click(function () {
                console.log('modal delete button clicked');
                console.log(proposal_no_for_delete);
                // table
                //     .row( $(this).parents('tr') )
                //     .remove()
                //     .draw();

                $.ajax({
                    type: "post",
                    url: delete_button,
                    dataType: 'json',
                    data: {req_no: proposal_no_for_delete, _token: _csrf_token},
                    success: function (response) {
                        $('.deleteRequisitioin').modal('hide');

                        // updateTable();
                        console.log(response);
                        // table
                        //     .row( $(this).parents('tr') )
                        //     .remove()
                        //     .draw();
                        toastr.success("Deleted successfully");


                    },
                    error: function (data) {
                        console.log(data);
                        toastr.error("Error deleting row");
                    }
                });

            });

                $('#timing').datetimepicker();

                $('#budget_details tbody').on('change', '.each_budget', function () {

                    console.log('this action has been recorded');
                    var grandTotal = 0;
                    $(".each_budget").each(function () {
                        var stval = parseFloat($(this).val());
                        console.log(stval);
                        grandTotal += isNaN(stval) ? 0 : stval;
                    });
                    console.log("total budget is " + grandTotal);
                    $(".total_budget").val(grandTotal);

                });

                $('#budget_details_bill tbody').on('change', '.each_budget', function () {

                    console.log('this action has been recorded');
                    var grandTotal = 0;
                    $(".each_budget").each(function () {
                        var stval = parseFloat($(this).val());
                        console.log(stval);
                        grandTotal += isNaN(stval) ? 0 : stval;
                    });
                    console.log("total budget is " + grandTotal);
                    $(".total_budget_bill").val(grandTotal);

                });

                $('#cost_details tbody').on('change', '.each_cost', function () {

                    var grandTotal = 0;
                    $(".each_cost").each(function () {
                        var stval = parseFloat($(this).val());
                        console.log(stval);
                        grandTotal += isNaN(stval) ? 0 : stval;
                    });
                    console.log("total cost is " + grandTotal);
                    $(".total_cost").val(grandTotal);

                });

                $('#cost_details_bill tbody').on('change', '.each_cost', function () {

                    var grandTotal = 0;
                    $(".each_cost").each(function () {
                        var stval = parseFloat($(this).val());
                        console.log(stval);
                        grandTotal += isNaN(stval) ? 0 : stval;
                    });
                    console.log("total cost is " + grandTotal);
                    $(".total_cost_bill").val(grandTotal);

                });

                $("#actual_expenditure").change(function () {

                    var actualexpense =  $("#actual_expenditure").val();
                    if ($("#advance_budget").val() != ''){
                        var advance = $("#advance_budget").val();
                        var payable = advance - actualexpense;
                        $("#payable").val(Math.abs(payable));
                    }

                    if ($("#actual_expenditure").val() !== '' && $("#nop_attended").val() !== '') {
                        var nop = $("#nop_attended").val();
                        var cph = actualexpense / nop;
                        console.log(cph);
                        $("#cph_attended").val(cph.toFixed(2));
                    }

                });

            $("#nop_attended").change(function () {
                var actualexpense =  $("#actual_expenditure").val();
                if ($("#actual_expenditure").val() !== '' && $("#nop_attended").val() !== '') {
                    var nop = $("#nop_attended").val();
                    var cph = actualexpense / nop;
                    console.log(cph);
                    $("#cph_attended").val(cph.toFixed(2));
                }
            });

            $("#program_team").on('change', function () {

                if ( ($("#program_team").val() !== "") && ($("#program_type").val() !== "") ) {
                    var program_team = $("#program_team").val();
                    var program_type = $("#program_type").val();

                    console.log(program_team);

                    $.ajax({
                        type: "post",
                        url: gl_cc,
                        dataType: 'json',
                        data: {
                            program_team: program_team,
                            program_type: program_type,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {


                            console.log(response);
                            var budget_data = response.gl_cc;
                            var markup = "";
                            for (var l = 0; l < budget_data.length; l++) {
                                var cct = budget_data[l]['cc_team_name'];
                                var ccn = budget_data[l]['cost_center_id'];
                                var gl = budget_data[l]['gl'];

                                markup += "<tr>" +
                                    "<td>" + cct + "</td>" +
                                    "<td>" + gl + "</td>" +
                                    "<td>" + ccn + "</td>" +
                                    "<td><input type='number' name='total' style='text-transform: uppercase;' class='each_budget form-control' id='total'  autocomplete='off'></td>" +
                                    "</tr>";
                            }

                            $("#budget_details tbody").empty().append(markup);


                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }

            });

            $("#program_type").on('change', function () {

                if ( ($("#program_team").val() !== "") && ($("#program_type").val() !== "") ) {
                    var program_team = $("#program_team").val();
                    var program_type = $("#program_type").val();

                    console.log(program_team);

                    $.ajax({
                        type: "post",
                        url: gl_cc,
                        dataType: 'json',
                        data: {
                            program_team: program_team,
                            program_type: program_type,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {


                            console.log(response);
                            var budget_data = response.gl_cc;
                            var markup = "";
                            for (var l = 0; l < budget_data.length; l++) {
                                var cct = budget_data[l]['cc_team_name'];
                                var ccn = budget_data[l]['cost_center_id'];
                                var gl = budget_data[l]['gl'];

                                markup += "<tr>" +
                                    "<td>" + cct + "</td>" +
                                    "<td>" + gl + "</td>" +
                                    "<td>" + ccn + "</td>" +
                                    "<td><input type='number' name='total' style='text-transform: uppercase;' class='each_budget form-control' id='total'  autocomplete='off'></td>" +
                                    "</tr>";
                            }

                            $("#budget_details tbody").empty().append(markup);


                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
                else{
                    alert("Please select Program Team");
                }

            });

                $("#direct_bill").click(function () {

                    document.getElementById("emp_info_form").reset();
                    document.getElementById("program_info_form").reset();
                    document.getElementById("budget_cost").reset();
                    $('#save_button_direct_bill').show();
                    $('#save_button_program_bill').hide();
                    $('#verify_button').hide();
                    $('#delete_button').hide();
                    $("#direct_bill_loader").show();
                    $('#budget_table_div_bill').hide();
                    $('#cost_table_div_bill').hide();
                    $('#budget_table_div').show();
                    $('#cost_table_div').show();
                    $('#direct_bill_form').hide();

                    $('#nop').prop("disabled", true);
                    $('#nop_attended').prop("disabled", false);
                    $('#cp').prop("disabled", false);
                    $('#depo').prop("disabled", false);
                    $('#mobile').prop("disabled", false);
                    $('#program_team').prop("disabled", false);
                    $('#program_type').prop("disabled", false);
                    $('#program_venue').prop("disabled", false);
                    $('#timing').prop("disabled", false);
                    $('#advance_budget').prop("disabled", true);

                    $('#program_feedback').prop("disabled", false);
                    $('#payable').prop("disabled", true);
                    $('#actual_expenditure').prop("disabled", false);

                    $('#iad').prop("disabled", false);
                    $('#pmr').prop("disabled", false);


                    console.log($("#timing").val());

                    console.log('Create Program button clicked');

                    if ($("#bgt_month").val() === "") {
                        alert("Please select Program Month");
                    } else
                        {
                        var brand_name = $("#brand_name").val();
                        console.log(brand_name);
                        var mon = $('#bgt_month').val();

                        $.ajax({
                            url: create_program,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                mon: mon
                            },

                            success: function (resp) {

                                $("#brand_name_program_bill").hide();
                                $("#brand_name_direct_bill").show();
                                $("#direct_bill_loader").hide();
                                $('#direct_bill_form').show();
                                $('#prog_month').val(mon);
                                console.log(resp);
                                var designation = resp.designation;
                                console.log(designation);
                                var emp_info = resp.emp_info[0];
                                var am_info = resp.am;
                                var budget_data = resp.budget_details;
                                var cost_data = resp.cost_details;
                                if ((resp.length) < 1) {
                                    // $("#loader").hide();
                                    toastr.info('Please reload the page');
                                } else {

                                    if(designation == 'RM' || designation == 'ASM'){

                                        $("#gm").val(emp_info['gm_name']);
                                        $("#sm").val(emp_info['sm_name']);
                                        $("#dsm").val(emp_info['dsm_name']);
                                        $("#rm_terr").val(emp_info['rm_terr_id']);
                                        $("#rm_name").val(emp_info['rm_asm_name']);

                                        var am = "";
                                        am += "<option value=''>Select Territory</option>";
                                        for (var l = 0; l < am_info.length; l++) {
                                            var idl = am_info[l]['am_terr_id'];
                                            var vall = am_info[l]['am_name'];

                                            am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";
                                        }

                                        $('#am_terr').html(am);
                                        $('#mpo_terr').empty();
                                        $('#depo').empty();

                                    }

                                    if(designation == 'AM' || designation == 'Sr. AM'){
                                        console.log('am form fields have been accessed');

                                        $("#gm").val(emp_info['gm_name']);
                                        $("#sm").val(emp_info['sm_name']);
                                        $("#dsm").val(emp_info['dsm_name']);
                                        $("#rm_terr").val(emp_info['rm_terr_id']);
                                        $("#rm_name").val(emp_info['rm_asm_name']);

                                        var am = "";
                                            var idl = emp_info['am_terr_id'];
                                            var vall = emp_info['am_name'];
                                            am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";
                                        $('#am_terr').html(am);

                                        var selOptsMPO = "";
                                        selOptsMPO += "<option value=''>Select Territory</option>";
                                        for (var j = 0; j < am_info.length; j++) {
                                            var id = am_info[j]['mpo_terr_id'];
                                            var val = am_info[j]['mpo_name'];
                                            var pgroup = am_info[j]['p_group'];
                                            var depot_id = am_info[j]['d_id'];
                                            var depot_name = am_info[j]['depot_name'];
                                            selOptsMPO += "<option value='" + id + "' data-mpo_name = '" + val + "' " +
                                                " data-mpo_team = '" + pgroup + "' data-depot_id = '" + depot_id + "'  " +
                                                " data-depot_name = '" + depot_name + "'>" + id + ' ' + val + '-' + pgroup + "</option>";
                                        }

                                        $('#mpo_terr').empty().append(selOptsMPO);
                                        $('#depo').empty();

                                    }


                                    // var markup = "";
                                    // for (var l = 0; l < budget_data.length; l++) {
                                    //     var cct = budget_data[l]['cc_team_name'];
                                    //     var ccn = budget_data[l]['cost_center_id'];
                                    //     var gl = budget_data[l]['gl'];
                                    //
                                    //     markup += "<tr>" +
                                    //         "<td>" + cct + "</td>" +
                                    //         "<td>" + ccn + "</td>" +
                                    //         "<td>" + gl + "</td>" +
                                    //         "<td><input type='number' name='total' style='text-transform: uppercase;' class='each_budget form-control' id='total'  autocomplete='off'></td>" +
                                    //         "</tr>";
                                    // }
                                    //
                                    // $("#budget_details tbody").empty().append(markup);

                                    var markup_cost_table = "";
                                    for (var l = 0; l < cost_data.length; l++) {
                                        var cct = cost_data[l]['ci_name'];

                                        markup_cost_table += "<tr>" +
                                            "<td>" + cct + "</td>" +
                                            "<td><input type='number' name='cost_amount' style='text-transform: uppercase;' class='each_cost form-control' id='cost_amount'  autocomplete='off'></td>" +
                                            "</tr>";
                                    }

                                    $("#cost_details tbody").empty().append(markup_cost_table);


                                }
                            },
                            error: function (err) {
                                // console.log(err);
                                $("#direct_bill_loader").hide();
                            }
                        });

                    }

                });

                $("#program_bill").click(function () {
                    $('#save_program_bill').prop("disabled", false);
                    document.getElementById("emp_info_form").reset();
                    document.getElementById("program_info_form").reset();
                    document.getElementById("budget_cost").reset();

                    $('#save_button_direct_bill').hide();
                    $('#save_button_program_bill').show();
                    $('#verify_button').hide();
                    $('#delete_button').hide();
                    $("#program_bill_loader").show();
                    $('#direct_bill_form').hide();
                    $('#budget_table_div').hide();
                    $('#cost_table_div').hide();
                    $("#brand_name_direct_bill").hide();

                    $('#depo').prop("disabled", true);
                    $('#cp').prop("disabled", true);
                    $('#mobile').prop("disabled", true);
                    $('#program_team').prop("disabled", true);
                    $('#program_type').prop("disabled", true);
                    $('#program_venue').prop("disabled", true);
                    $('#timing').prop("disabled", false);
                    $('#advance_budget').prop("disabled", true);
                    $('#nop').prop("disabled", true);
                    $('#nop_attended').prop("disabled", false);
                    $('#program_feedback').prop("disabled", false);
                    $('#actual_expenditure').prop("disabled", false);
                    $('#iad').prop("disabled", true);
                    $('#pmr').prop("disabled", true);


                    if ($("#program_no_for_bill").val() === "") {
                        alert("Please select Program No");
                    } else {

                        var mon = $('#bgt_month').val();

                        var program = $('#program_no_for_bill').val();

                        $.ajax({
                            url: program_bill,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                program: program
                            },

                            success: function (resp) {

                                $("#brand_name_direct_bill").hide();
                                $('#budget_table_div_bill').show();
                                $('#cost_table_div_bill').show();

                                var program_info = resp.program_info[0];
                                var budget_data = resp.budget_details;
                                var cost_data = resp.cost_details;

                                var brandn = "";
                                var brval = program_info['brand_name'];
                                brandn += "<option value='" + brval + " '>" + brval + "</option>";
                                $('#brand_name_bill').empty().append(brandn);
                                $("#brand_name_program_bill").show();
                                $("#program_bill_loader").hide();
                                $('#direct_bill_form').show();
                                console.log(resp);

                                if ((resp.length) < 1) {
                                    toastr.info('Please reload the page');
                                } else {
                                    $("#gm").val(program_info['gm_name']);
                                    $("#sm").val(program_info['sm_name']);
                                    $("#dsm").val(program_info['dsm_name']);
                                    $("#rm_terr").val(program_info['rm_terr_id']);
                                    $("#rm_name").val(program_info['rm_name']);
                                    $('#prog_month').val(program_info['bill_month']);
                                    $('#cp').val(program_info['contact_person']);
                                    $('#mobile').val(program_info['mobile']);

                                    $('#program_team').val(program_info['prog_team']);
                                    $('#program_type').val(program_info['program_type']);
                                    $('#program_venue').val(program_info['program_venue']);
                                    $('#program_feedback').val(program_info['program_feedback']);

                                    $('#timing').val(program_info['prog_date_time']);

                                    $('#advance_budget').val(program_info['advance_budget']);
                                    $('#nop').val(program_info['nop_proposed']);
                                    $('#cph').val(program_info['cost_per_head']);
                                    $('#program_no').val(program_info['prog_no']);
                                    $('#iad').val(program_info['program_details']);
                                    $('#pmr').val(program_info['pm']);


                                    var am = "";
                                    var idl = program_info['am_terr_id'];
                                    var vall = program_info['am_name'];

                                    am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";

                                    $('#am_terr').empty().append(am);

                                    var selOptsMPO = "";
                                    var id = program_info['mpo_terr_id'];
                                    var val = program_info['mpo_name'];
                                    var pgroup = program_info['mpo_team'];
                                    var depot_id = program_info['depot_id'];
                                    var depot_name = program_info['depot_name'];
                                    selOptsMPO += "<option value='" + id + "' data-mpo_name = '" + val + "' " +
                                        " data-mpo_team = '" + pgroup + "' data-depot_id = '" + depot_id + "'  " +
                                        " data-depot_name = '" + depot_name + "'>" + id + ' ' + val + '-' + pgroup + "</option>";

                                    $('#mpo_terr').empty().append(selOptsMPO);

                                    var depot = "";
                                    var dpid = program_info['depot_id'];
                                    var dpn = program_info['depot_name'];

                                    depot += "<option value='" + dpid + "' data-depot_name = '" + dpn + "'>"  + dpn + "</option>";

                                    $('#depo').empty().append(depot);

                                    var markup = "";
                                    for (var l = 0; l < budget_data.length; l++) {
                                        var cct = budget_data[l]['cc_team_name'];
                                        var ccn = budget_data[l]['cost_center_id'];
                                        var gl = budget_data[l]['gl'];
                                        var pro_amt = budget_data[l]['pro_amt'];

                                        markup += "<tr>" +
                                            "<td>" + cct + "</td>" +
                                            "<td>" + gl + "</td>" +
                                            "<td>" + ccn + "</td>" +
                                            "<td>" + pro_amt + "</td>" +
                                            "<td><input type='number' name='total' style='text-transform: uppercase;' class='each_budget form-control' id='total'  autocomplete='off'></td>" +
                                            "</tr>";
                                    }

                                    $("#budget_details_bill tbody").empty().append(markup);

                                    var markup_cost_table = "";
                                    for (var l = 0; l < cost_data.length; l++) {
                                        var cct = cost_data[l]['ci_name'];
                                        var amt = cost_data[l]['pro_amt'];

                                        markup_cost_table += "<tr>" +
                                            "<td>" + cct + "</td>" +
                                            "<td>" + amt + "</td>" +
                                            "<td><input type='number' name='cost_amount' style='text-transform: uppercase;' class='each_cost form-control' id='cost_amount'  autocomplete='off'></td>" +
                                            "</tr>";
                                    }

                                    $("#cost_details_bill tbody").empty().append(markup_cost_table);

                                }
                            },
                            error: function (err) {
                                // console.log(err);
                                $("#program_bill_loader").hide();
                            }
                        });

                    }

                });

                $("#am_terr").on('change', function () {
                    $('#depo').empty();
                    var am_terr = $("#am_terr").val();
                    var rm_terr = $("#rm_terr").val();
                    console.log(am_terr);
                    console.log(rm_terr);
                    $("#mpo_terr").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        type: "post",
                        url: am_change,
                        dataType: 'json',
                        data: {_token: _csrf_token, amTerr: am_terr, rmTerrId: rm_terr},
                        success: function (response) {
                            console.log(response);

                            var selOptsMPO = "";
                            selOptsMPO += "<option value=''>Select Territory</option>";
                            for (var j = 0; j < response.length; j++) {
                                var id = response[j]['mpo_terr_id'];
                                var val = response[j]['mpo_name'];
                                var pgroup = response[j]['p_group'];
                                var depot_id = response[j]['d_id'];
                                var depot_name = response[j]['depot_name'];
                                selOptsMPO += "<option value='" + id + "' data-mpo_name = '" + val + "' " +
                                    " data-mpo_team = '" + pgroup + "' data-depot_id = '" + depot_id + "'  " +
                                    " data-depot_name = '" + depot_name + "'>" + id + ' ' + val + '-' + pgroup + "</option>";
                            }
                            // $('#mpo_terr').html(selOptsMPO);
                            $('#mpo_terr').empty().append(selOptsMPO);


                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });

            $("#mpo_terr").on('change', function () {

                var mpo_terr = $("#mpo_terr").val();

                console.log(mpo_terr);

                $.ajax({
                    type: "post",
                    url: depo,
                    dataType: 'json',
                    data: {
                        mpo_terr: mpo_terr,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {

                        console.log(response);

                        var selOptsDEPOT = "";
                        selOptsDEPOT += "<option value=''>Select Depot</option>";
                        for (var j = 0; j < response['depo'].length; j++) {
                            var id = response['depo'][j]['depot_id'];
                            var val = response['depo'][j]['depot_name'];
                            selOptsDEPOT += "<option value='" + id + "' data-depot_name = '" + val + "'>" + val + "</option>";
                        }
                        $('#depo').empty().append(selOptsDEPOT);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

                $("#update").click(function () {
                    console.log('update button clicked');
                    $.ajax({
                        url: update_button,
                        method: "post",
                        dataType: 'json',

                        data: {
                            _token: _csrf_token
                        },

                        success: function (resp) {
                            toastr.success('Program updated Successfully');
                            console.log(resp);
                            var program_no = resp[0]['prog_no'];
                            var req_id = resp[0]['req_id'];
                            $("#program_no").val(program_no);
                            $("#req_id").val(req_id);

                        },
                        error: function (err) {
                            console.log(err);
                            // $("#loader").hide();
                        }
                    });
                });

                $("#save").click(function () {

                    console.log('save button clicked');

                    if ($("#bgt_month").val() === "") {
                        toastr.info("Please select Program Month");
                    } else if ($("#brand_name").val() == null) {
                        toastr.info("Please select brand name");
                    }

                    else if ($("#brand_name").val().length> 10) {
                        toastr.info("Brand name can't be more than 10");
                    }

                    else if ($("#am_terr").val() == "") {
                        toastr.info("Please select Area Manager");
                    }
                    else if ($("#mpo_terr").val() == "") {
                        toastr.info("Please select MPO");
                    }
                    else if ($("#cp").val() == "") {
                        toastr.info("Please enter contact Person");
                    }
                    else if ($("#mobile").val() == "") {
                        toastr.info("Please enter mobile number");
                    }
                    else if ($("#depo").val() == "") {
                        toastr.info("Please select a depo");
                    }
                    else if ($("#program_team").val() == "") {
                        toastr.info("Please select Program Team");
                    }
                    else if ($("#program_type").val() == "") {
                        toastr.info("Please select program Type");
                    }
                    else if ($("#program_venue").val() == "") {
                        toastr.info("Please enter venue");
                    }
                    else if ($("#timing").val() == "") {
                        toastr.info("Please enter Date and Time");
                    }
                    else if ($("#program_feedback").val() == "") {
                        toastr.info("Please give feedback");
                    }
                    else if ($("#nop_attended").val() == "") {
                        toastr.info("Please enter number of person attended");
                    }
                    else if ($("#actual_expenditure").val() == "") {
                        toastr.info("Please enter expense");
                    }

                    else if ($("#iad").val() == "") {
                        toastr.info("Please enter Institute/Association/Doctor");
                    }
                    else if ($("#pmr").val() == "") {
                        toastr.info("Please enter Promotional Materials");
                    }

                    else if ($(".total_budget").val() != $('#actual_expenditure').val()) {
                        toastr.info("Total Budget doesn't match actual expenditure");
                    }
                    else if ($('#actual_expenditure').val() != $(".total_cost").val()) {
                        toastr.info("Total cost doesn't match actual expenditure");
                    }
                    else if ($(".total_budget").val() != $(".total_cost").val()) {
                        toastr.info("Total Budget doesn't match Total Cost");
                    } else {

                        var mon = $('#bgt_month').val();
                        var prog_no = $('#program_no').val();
                        var req_id = $('#req_id').val();
                        var gm = $('#gm').val();
                        var sm = $('#sm').val();
                        var dsm = $('#dsm').val();
                        var rm_terr = $('#rm_terr').val();
                        var rm_name = $('#rm_name').val();
                        var am_terr = $('#am_terr').val();
                        var am_name = $("#am_terr option:selected").data('am_name');
                        var mpo_terr = $('#mpo_terr').val();
                        var mpo_name = $("#mpo_terr option:selected").data('mpo_name');
                        var mpo_team = $("#mpo_terr option:selected").data('mpo_team');
                        var depot_id = $("#depo").val();
                        var depot_name = $("#depo option:selected").data('depot_name');
                        var cp = $('#cp').val();
                        var mobile = $('#mobile').val();
                        var program_team = $('#program_team').val();
                        var program_type = $('#program_type').val();
                        var program_venue = $('#program_venue').val();
                        var program_feedback = $('#program_feedback').val();
                        var timing_original = $('#timing').val();
                        var timing = timing_original.replace('T', ' ');
                        var brand_name = $('#brand_name').val();
                        var advance_budget = $('#advance_budget').val();
                        var actual_expenditure = $('#actual_expenditure').val();
                        var nop_attended = $('#nop_attended').val();
                        var nop = $('#nop').val();
                        var cph = $('#cph_attended').val();

                        var iad = $('#iad').val();
                        var pmr = $('#pmr').val();

                        var originalArray = brand_name;

                        var separator = ',';
                        var implodedArray = originalArray.join(separator);
                        console.log(implodedArray);

                        console.log(iad);
                        console.log(pmr);
                        console.log(program_venue);
                        console.log(timing);
                        console.log(brand_name);


                        var budget_table = document.getElementById('budget_details');
                        var tblData = budget_table.rows;
                        console.log(tblData);
                        var insertbudget = [];
                        var tmpData = new Array();
                        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
                        for (i = 1; i < budget_table.rows.length - 1; i++) {

                            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
                            var objCells = budget_table.rows[i].cells;
                            // var objCells = myTab.rows.item(i);
                            // console.log(objCells);
                            if (objCells.item(3).querySelector('#total').value != '') {
                                tmpData[i - 1] = {
                                    "team": objCells.item(0).innerHTML,
                                    "gl": objCells.item(1).innerHTML,
                                    "cc": objCells.item(2).innerHTML,
                                    "amount": objCells.item(3).querySelector('#total').value
                                }
                                insertbudget.push(tmpData[i - 1]);
                            }

                        }
                        console.log(insertbudget);


                        var cost_table = document.getElementById('cost_details');
                        var cost_tblData = cost_table.rows;
                        console.log(cost_tblData);
                        var insertcost = [];
                        var tmpDatacost = new Array();
                        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
                        for (i = 1; i < cost_table.rows.length - 1; i++) {

                            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
                            var objCells = cost_table.rows[i].cells;
                            // var objCells = myTab.rows.item(i);
                            // console.log(objCells);
                            if (objCells.item(1).querySelector('#cost_amount').value != '') {
                                tmpDatacost[i - 1] = {
                                    "item": objCells.item(0).innerHTML,
                                    "cost_amount": objCells.item(1).querySelector('#cost_amount').value
                                }
                                insertcost.push(tmpDatacost[i - 1]);
                            }

                        }
                        console.log(insertcost);

                        if (insertbudget.length !== 0 && insertcost.length !== 0 && depot_name!== '') {
                            $('#save_button_direct_bill').hide();

                            $.ajax({
                                url: save_button_direct_bill,
                                method: "post",
                                dataType: 'json',

                                data: {
                                    mon: mon,
                                    insertBudget: JSON.stringify(insertbudget),
                                    insertCost: JSON.stringify(insertcost),
                                    program_no: prog_no,
                                    req_id: req_id,
                                    gm: gm,
                                    sm: sm,
                                    dsm: dsm,
                                    rm_terr: rm_terr,
                                    rm_name: rm_name,
                                    am_terr: am_terr,
                                    am_name: am_name,
                                    mpo_terr: mpo_terr,
                                    mpo_name: mpo_name,
                                    mpo_team: mpo_team,
                                    depot_id: depot_id,
                                    depot_name: depot_name,
                                    cp: cp,
                                    mobile: mobile,
                                    program_team: program_team,
                                    program_type: program_type,
                                    program_venue: program_venue,
                                    timing: timing,
                                    brand_name: implodedArray,
                                    advance_budget: advance_budget,
                                    nop: nop,
                                    cph: cph,
                                    program_feedback: program_feedback,
                                    actual_expending: actual_expenditure,
                                    nop_attended: nop_attended,
                                    iad: iad,
                                    pmr: pmr,
                                    _token: _csrf_token
                                },

                                success: function (resp) {

                                    if (resp['flag'] == false) {
                                        var separator = ',';
                                        var implodedArray = resp['cc'].join(separator);
                                        console.log(implodedArray);

                                        toastr.info('These cost center - ' + implodedArray + ' doesnot have avialabe budget');
                                        $('#save_button_direct_bill').show();
                                    }
                                    else{

                                    toastr.success('Program Created Successfully');
                                    console.log(resp);
                                    console.log(resp['program']);
                                    console.log(resp['program_no'][0]['bill_no']);
                                    var bill_no = resp['program_no'][0]['bill_no'];
                                    $("#bill_no").val(bill_no);

                                    var pr = "";
                                    var idl = bill_no;
                                    var vall = bill_no;
                                    pr += "<option value='" + idl + "' >" + vall + "</option>";

                                    $('#bill_no_for_verify').append(pr);

                                    if (resp['program']) {
                                        console.log('entered into the loop');
                                        // toastr.success('Program Created Successfully');
                                    }

                                }

                                },
                                error: function (err) {
                                    console.log(err);
                                    toastr.warning('Something went wrong! Please reload the page');
                                    // $("#loader").hide();
                                }
                            });

                        }
                    }

                });

                $("#save_program_bill").click(function () {
                    // $('#save_program_bill').prop("disabled", true);
                    console.log('save button for program bill clicked');

                 if ($("#program_feedback").val() == "") {
                        toastr.info("Please give feedback");
                    }
                 else if ($("#timing").val() == "") {
                     toastr.info("Please enter Date and Time");
                 }
                    else if ($("#nop_attended").val() == "") {
                        toastr.info("Please enter number of person attended");
                    }
                    else if ($("#actual_expenditure").val() == "") {
                        toastr.info("Please enter expense");
                    }

                 else if ($(".total_budget_bill").val() != $('#actual_expenditure').val()) {
                        toastr.info("Total Budget doesn't match actual expenditure");
                    }
                    else if ($('#actual_expenditure').val() != $(".total_cost_bill").val()) {
                        toastr.info("Total cost doesn't match actual expenditure");
                    }

                    else if ($(".total_budget_bill").val() != $(".total_cost_bill").val()) {
                        toastr.info("Total Budget doesn't match Total Cost");
                    } else {


                        var mon = $('#prog_month').val();
                        var prog_no = $('#program_no').val();
                        var req_id = $('#req_id').val();
                        var gm = $('#gm').val();
                        var sm = $('#sm').val();
                        var dsm = $('#dsm').val();
                        var rm_terr = $('#rm_terr').val();
                        var rm_name = $('#rm_name').val();
                        var am_terr = $('#am_terr').val();
                        var am_name = $("#am_terr option:selected").data('am_name');
                        var mpo_terr = $('#mpo_terr').val();
                        var mpo_name = $("#mpo_terr option:selected").data('mpo_name');
                        var mpo_team = $("#mpo_terr option:selected").data('mpo_team');
                     var depot_id = $("#depo").val();
                     var depot_name = $("#depo option:selected").data('depot_name');
                        var cp = $('#cp').val();
                        var mobile = $('#mobile').val();
                        var program_team = $('#program_team').val();
                        var program_type = $('#program_type').val();
                        var program_venue = $('#program_venue').val();
                        var timing_original = $('#timing').val();
                        var timing = timing_original.replace('T', ' ');
                        var brand_name = $('#brand_name_bill').val();
                        var advance_budget = $('#advance_budget').val();
                        var nop = $('#nop').val();
                        var cph = $('#cph_attended').val();

                     var iad = $('#iad').val();
                     var pmr = $('#pmr').val();

                        var program_feedback = $('#program_feedback').val();
                        var payable = $('#payable').val();
                        var actual_expenditure = $('#actual_expenditure').val();
                        var nop_attended = $('#nop_attended').val();

                        var budget_table = document.getElementById('budget_details_bill');
                        var tblData = budget_table.rows;
                        console.log(tblData);
                        var insertbudget = [];
                        var tmpData = new Array();
                        var budget_table_flag = true;
                        var cost_table_flag = true;
                        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
                        for (i = 1; i < budget_table.rows.length - 1; i++) {

                            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
                            var objCells = budget_table.rows[i].cells;
                            // var objCells = myTab.rows.item(i);
                            // console.log(objCells);

                            if (objCells.item(4).querySelector('#total').value == ''){
                                budget_table_flag = false;
                            }
                            if (objCells.item(4).querySelector('#total').value != '') {
                                tmpData[i - 1] = {
                                    "team": objCells.item(0).innerHTML,
                                    "gl": objCells.item(1).innerHTML,
                                    "cc": objCells.item(2).innerHTML,
                                    "pro_amt": objCells.item(3).innerHTML,
                                    "amount": objCells.item(4).querySelector('#total').value
                                }
                                insertbudget.push(tmpData[i - 1]);
                            }

                        }
                        console.log(budget_table_flag);
                        console.log(insertbudget);

                        var cost_table = document.getElementById('cost_details_bill');
                        var cost_tblData = cost_table.rows;
                        console.log(cost_tblData);
                        var insertcost = [];
                        var tmpDatacost = new Array();
                        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
                        for (i = 1; i < cost_table.rows.length - 1; i++) {

                            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
                            var objCells = cost_table.rows[i].cells;
                            // var objCells = myTab.rows.item(i);
                            // console.log(objCells);
                            if (objCells.item(2).querySelector('#cost_amount').value == ''){
                                cost_table_flag = false;
                            }
                            if (objCells.item(2).querySelector('#cost_amount').value != '') {
                                tmpDatacost[i - 1] = {
                                    "item": objCells.item(0).innerHTML,
                                    "pro_amt_cost": objCells.item(1).innerHTML,
                                    "cost_amount": objCells.item(2).querySelector('#cost_amount').value
                                }
                                insertcost.push(tmpDatacost[i - 1]);
                            }

                        }
                        console.log(cost_table_flag);
                        console.log(insertcost);

                        if (insertbudget.length !== 0 && insertcost.length !== 0 && budget_table_flag && cost_table_flag) {

                            $('#save_button_program_bill').hide();

                            $.ajax({
                                url: save_button_program_bill,
                                method: "post",
                                dataType: 'json',
                                data: {

                                    mon: mon,
                                    insertBudget: JSON.stringify(insertbudget),
                                    insertCost: JSON.stringify(insertcost),
                                    program_no: prog_no,
                                    req_id: req_id,
                                    gm: gm,
                                    sm: sm,
                                    dsm: dsm,
                                    rm_terr: rm_terr,
                                    rm_name: rm_name,
                                    am_terr: am_terr,
                                    am_name: am_name,
                                    mpo_terr: mpo_terr,
                                    mpo_name: mpo_name,
                                    mpo_team: mpo_team,
                                    depot_id: depot_id,
                                    depot_name: depot_name,
                                    cp: cp,
                                    mobile: mobile,
                                    program_team: program_team,
                                    program_type: program_type,
                                    program_venue: program_venue,
                                    timing: timing,
                                    brand_name: brand_name,
                                    advance_budget: advance_budget,
                                    nop: nop,
                                    cph: cph,

                                    iad: iad,
                                    pmr: pmr,

                                    payable: payable,
                                    program_feedback: program_feedback,
                                    actual_expending: actual_expenditure,
                                    nop_attended: nop_attended,
                                    _token: _csrf_token
                                },

                                success: function (resp) {

                                    if (resp['flag'] == false) {
                                        var separator = ',';
                                        var implodedArray = resp['cc'].join(separator);
                                        console.log(implodedArray);

                                        toastr.info('These cost center - ' + implodedArray + ' doesnot have avialabe budget');
                                        $('#save_button_program_bill').show();
                                    }

                                    else{
                                    toastr.success('Bill Created Successfully');
                                    console.log(resp);
                                    console.log(resp['prog_no']);
                                    var program = resp['prog_no'];
                                    console.log(resp['program']);
                                    console.log(resp['program_no'][0]['bill_no']);
                                    var bill_no = resp['program_no'][0]['bill_no'];
                                    $("#bill_no").val(bill_no);


                                    var pr = "";
                                    pr += "<option value=''>select program no</option>";
                                    for (var l = 0; l < program.length; l++) {
                                        var idl = program[l]['prog_no'];
                                        var vall = program[l]['prog_no'];

                                        pr += "<option value='" + idl + "' >" + vall + "</option>";
                                    }

                                    $('#program_no_for_bill').empty().append(pr);

                                    var billno = "";
                                    var idl = bill_no;
                                    var vall = bill_no;
                                    billno += "<option value='" + idl + "' >" + vall + "</option>";

                                    $('#bill_no_for_verify').append(billno);


                                    if (resp['program']) {
                                        console.log('entered into the loop');
                                        // toastr.success('Program Created Successfully');
                                    }

                                }

                                },
                                error: function (err) {
                                    console.log(err);
                                    // $("#loader").hide();
                                }
                            });

                        }
                        else {
                            toastr.info('Please fill up all the table rows');
                        }
                    }

                });

                $("#verify_display").click(function () {
                    document.getElementById("emp_info_form").reset();
                    document.getElementById("program_info_form").reset();
                    document.getElementById("budget_cost").reset();

                    $('#save_button_direct_bill').hide();
                    $('#save_button_program_bill').hide();
                    $('#verify_button').show();
                    $('#delete_button').show();

                    $("#verify_display_loader").show();
                    $('#direct_bill_form').hide();
                    $('#budget_table_div').hide();
                    $('#cost_table_div').hide();
                    $("#brand_name_direct_bill").hide();

                    $('#cp').prop("disabled", true);
                    $('#mobile').prop("disabled", true);
                    $('#program_team').prop("disabled", true);
                    $('#program_type').prop("disabled", true);
                    $('#program_venue').prop("disabled", true);
                    $('#timing').prop("disabled", false);
                    $('#advance_budget').prop("disabled", true);
                    $('#depo').prop("disabled", true);

                    $('#program_feedback').prop("disabled", true);
                    $('#payable').prop("disabled", true);
                    $('#actual_expenditure').prop("disabled", true);
                    $('#nop').prop("disabled", true);
                    $('#nop_attended').prop("disabled", true);
                    $('#iad').prop("disabled", true);
                    $('#pmr').prop("disabled", true);


                    if ($("#bill_no_for_verify").val() === "") {
                        alert("Please select Bill No");
                    } else {

                        var mon = $('#bgt_month').val();

                        var bill = $('#bill_no_for_verify').val();

                        $.ajax({
                            url: verify_data,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                bill: bill
                            },

                            success: function (resp) {

                                $("#brand_name_direct_bill").hide();
                                $('#budget_table_div_bill').show();
                                $('#cost_table_div_bill').show();

                                var program_info = resp.program_info[0];
                                var budget_data = resp.budget_details;
                                var cost_data = resp.cost_details;

                                var brandn = "";
                                var brval = program_info['brand_name'];
                                brandn += "<option value='" + brval + " '>" + brval + "</option>";
                                $('#brand_name_bill').empty().append(brandn);
                                $("#brand_name_program_bill").show();
                                $("#verify_display_loader").hide();
                                $('#direct_bill_form').show();
                                console.log(resp);

                                if ((resp.length) < 1) {
                                    toastr.info('Please reload the page');
                                } else {

                                    $("#gm").val(program_info['gm_name']);
                                    $("#sm").val(program_info['sm_name']);
                                    $("#dsm").val(program_info['dsm_name']);
                                    $("#rm_terr").val(program_info['rm_terr_id']);
                                    $("#rm_name").val(program_info['rm_name']);
                                    $('#prog_month').val(program_info['month_of_prog']);
                                    $('#cp').val(program_info['contact_person']);
                                    $('#mobile').val(program_info['mobile']);

                                    $('#program_team').val(program_info['prog_team']);
                                    $('#program_type').val(program_info['program_type']);
                                    $('#program_venue').val(program_info['program_venue']);
                                    $('#program_feedback').val(program_info['program_feedback']);
                                    $('#timing').val(program_info['prog_date_time']);
                                    $('#advance_budget').val(program_info['advance_budget']);
                                    $('#nop').val(program_info['nop_proposed']);
                                    $('#cph').val(program_info['cost_per_head']);
                                    $('#program_no').val(program_info['prog_no']);
                                    $('#bill_no').val(program_info['bill_no']);
                                    $('#program_feedback').val(program_info['program_feedback']);
                                    $('#payable').val(program_info['payable_refundable']);

                                    $('#actual_expenditure').val(program_info['actual_expenditure']);
                                    $('#nop_attended').val(program_info['nop_attended']);

                                    $('#iad').val(program_info['program_details']);
                                    $('#pmr').val(program_info['pm']);


                                    var am = "";
                                    var idl = program_info['am_terr_id'];
                                    var vall = program_info['am_name'];

                                    am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";

                                    $('#am_terr').empty().append(am);

                                    var selOptsMPO = "";
                                    var id = program_info['mpo_terr_id'];
                                    var val = program_info['mpo_name'];
                                    var pgroup = program_info['mpo_team'];
                                    var depot_id = program_info['depot_id'];
                                    var depot_name = program_info['depot_name'];
                                    selOptsMPO += "<option value='" + id + "' data-mpo_name = '" + val + "' " +
                                        " data-mpo_team = '" + pgroup + "' data-depot_id = '" + depot_id + "'  " +
                                        " data-depot_name = '" + depot_name + "'>" + id + ' ' + val + '-' + pgroup + "</option>";

                                    $('#mpo_terr').empty().append(selOptsMPO);

                                    var depot = "";
                                    var dpid = program_info['depot_id'];
                                    var dpn = program_info['depot_name'];

                                    depot += "<option value='" + dpid + "'>"  + dpn + "</option>";

                                    $('#depo').empty().append(depot);

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

                                    $("#budget_details_bill tbody").empty().append(markup);
                                    $(".total_budget_bill").val(IndianLocale.format(total_budget));

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

                                    $("#cost_details_bill tbody").empty().append(markup_cost_table);
                                    $(".total_cost_bill").val(IndianLocale.format(total_cost));

                                }
                            },
                            error: function (err) {
                                // console.log(err);
                                $("#verify_display_loader").hide();
                            }
                        });

                    }

                });

            $("#btn_verify").click(function () {

                $('#save_button_direct_bill').hide();
                $('#save_button_program_bill').hide();
                $('#verify_button').show();

                $("#program_bill_loader").show();


                if ($("#bill_no_for_verify").val() === "") {
                    alert("Please select Bill No");
                }
                else if ($("#timing").val() == "") {
                    toastr.info("Please enter Date and Time");
                }
                else {

                    var mon = $('#bgt_month').val();

                    var bill =  $('#bill_no').val();
                    var program_team = $('#program_team').val();
                    var timing_original = $('#timing').val();
                    var timing = timing_original.replace('T', ' ');

                    $.ajax({
                        url: verify_update,
                        method: "post",
                        dataType: 'json',

                        data: {
                            _token: _csrf_token,
                            bill: bill,
                            program_team: program_team,
                            timing: timing
                        },

                        success: function (resp) {
                            toastr.success('Bill successfully verified');

                            $("#bill_no_for_verify option[value = " + bill +"]").remove();

                            $("#program_bill_loader").hide();

                            console.log(resp);

                            if ((resp.length) < 1) {
                                toastr.info('Please reload the page');
                            } else {

                            }
                        },
                        error: function (err) {
                            // console.log(err);
                            $("#program_bill_loader").hide();
                        }
                    });

                }

            });


            }
        );


    </script>

@endsection