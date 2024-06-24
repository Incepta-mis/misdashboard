@extends('_layout_shared._master')
@section('title','EXPENSE VERIFY/APPROVE Form')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .text-gr{
            text-color:green;
        }
        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 12px;
            color: #1fb5ac;
            font-weight: bold;
        }

        body {
            color: black;
        }

        .table-bordered > thead > tr > th {
            border: 1px solid #0e0d0d;
        }

        .table-bordered > tbody > tr > td {
            border: 1px solid #0e0d0d;
        }

        .table-bordered {
            border: 1px solid #0e0d0d;
        }

        .table-bordered > tfoot > tr > td {
            border: 1px solid #0e0d0d;
        }

        #loading-img {
            background: url(http://preloaders.net/preloaders/360/Velocity.gif) center center no-repeat;
            height: 100%;
            z-index: 20;
        }

        .overlay {
            /*background: #e9e9e9;*/
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.5;
        }

    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-10 col-md-10">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Expense Verify Area Manager
                    </label>
                </header>
                <div class="panel-body" style="padding-left: 5px; padding-right: 5px;">
                    <div class="form-horizontal">

                        <form method="post" id="frmexpense">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="col-sm-12 col-md-12">

                                    <div class="col-sm-4 col-md-4">
                                        <label class="control-label col-md-4 col-sm-4 input-sm" for="p_group">
                                            <b>Month:</b></label>
                                        <div class="col-md-8 col-sm-8 ">
                                            <select  name="e_month" id="e_month_id" class="form-control input-sm">
                                                @foreach($expense_months as $expense_mon)
                                                    <option value="{{$expense_mon->month}}">{{ strtoupper($expense_mon->month) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    @if(Auth::user()->desig!='MPO')

                                    <div class="col-sm-4 col-md-4">
                                        <label class="control-label col-md-4 col-sm-4 input-sm" for="p_group">
                                            <b>Reg.Terr:</b></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select name="e_rm_terr_id" id="e_rm_terr_id" class="form-control input-sm"
                                                    disabled>

{{--                                                <option class="sel_option" value="0" disabled selected="true">--}}
{{--                                                    Loading...--}}
{{--                                                </option>--}}
{{--                                                <option class="sel_rm" value="1" disabled="true">Select RM</option>--}}

{{--                                                <!-- <option value="0" disabled="true" selected="true">Select RM</option> -->--}}
                                                @foreach($rm_terr as $dd)
                                                    <option value="{{$dd->rm_terr_id}}">{{$dd->rm_terr_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @endif


                                </div>

                                <div class="col-sm-12 col-md-12" style="padding-top: 5px;padding-bottom: 5px">
                                    @if(Auth::user()->desig!='MPO')
                                        <div class="col-sm-4 col-md-4">
                                        <label class="control-label col-md-4 col-sm-4 input-sm" for="p_group">
                                        <b>AM Terr:</b></label>
                                        <div class="col-md-8 col-sm-8 input-sm">
                                            <select name="e_am_terr_id" id="e_am_terr_id" class="form-control input-sm">
                                                @foreach($am_terr as $dd)
                                                    <option value="{{$dd->am_terr_id}}">{{$dd->am_terr_id}}</option>
                                                @endforeach

                                            </select>
                                            </div>
                                    </div>

                                            @endif

                                        {{--<div class="form-group">--}}
                                        @if(Auth::user()->desig!='MPO')
                                                <div class="col-sm-4 col-md-4">
                                                <label class="control-label col-md-4 col-sm-4 input-sm" for="p_group">
                                        <b>Emp Code:</b></label>
                                                    <div class="col-md-8 col-sm-8 input-sm">
                                        <select name="e_terr_id" id="e_emp_id" class="form-control input-sm">
                                            @foreach($mpo_terr as $dd)
                                                <option value="{{$dd->mpo_terr_id}}">{{$dd->mpo_terr_id}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                                </div>
                                        @endif
                                        {{--</div>--}}

                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6"
                                             style="margin-left: 3.666667%;">
                                            <button type="submit" id="btn_display_u" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Submit</b></button>
                                        </div>

                                </div>



                        </form>

                    </div>
                </div>
            </section>
        </div>
        <div class="col-sm-2 col-md-2">
            <section class="panel" id="data_table">

                <div class="panel-body" id="summary_tour_table">

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
    <div class="row" id="report-body">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive" id="search_div_id">

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="overlay">
        <div id="loading-img"></div>
    </div>


    @include('expense.modal.edit_expense_verify_data')
    @include('expense.modal.remove_expense_verify_data')
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/jquery-dateFormat.min.js')}}

    <script type="text/javascript">

        $(document).ready(function () {

            //rm loading prob sol
            $("#e_rm_terr_id option[value='0']").remove();
            $("#e_rm_terr_id").prop("disabled", false);
            //            $("select option[value='B']").attr("selected","selected");
            $('select option[class="sel_rm"]').attr("selected", "selected");
            

            // console.log('{!! Auth::user()->name !!}');
            // var log_name = `{{ Auth::user()->name }}`;
            // var log_name = '{{ Auth::user()->name }}';
            var log_name = '{!! Auth::user()->name !!}';
            var log_id = '{{Auth::user()->user_id}}';
            var log_desig = '{{Auth::user()->desig}}';
            var exp_id_g;

            

            $('#e_month_id').change(function () {

                // console.log("month change ");
                // console.log($('#e_month_id').val());
                // console.log($('#e_rm_terr_id').val());
                // console.log($('#e_am_terr_id').val());

                if (($('#e_rm_terr_id').val()) != null && ($('#e_am_terr_id').val()) != null) {
                    // console.log("month change ---u have to do something");

                    //////////////////////Get employee id/////////////////////////////////
                    $('#e_emp_id').empty();
                    $('#e_emp_id').append($('<option></option>').html('Loading...'));

                    var log_desigg = '{{Auth::user()->desig}}';
                    var sc_am_id = $('#e_am_terr_id').val();
                    var sc_rmm_id = $('#e_rm_terr_id').val();
                    var exp_month = $('#e_month_id').val();

                    $.ajax({
                        type: 'get',
                        url: '{!!URL::to('expense/getEmpId')!!}',
                        data: {'rm_id': sc_rmm_id, 'am_id': sc_am_id, 'desig': log_desigg, 'exp_mon': exp_month},
                        success: function (data) {

                            $('#e_emp_id').empty();

                            var op = '';
                            for (var i = 0; i < data.am_data.length; i++) {
                                // op+='<option value="'+data.am_data[i]['emp_id']+'">'+data.am_data[i]['emp_id']+'</option>';
                               // op += '<option value="' + data.am_data[i]['terr_id'] + '">' + data.am_data[i]['terr_id'] + ' <span style="color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';
                                if(data.am_data[i]['approved_status']=='approve'){
                                    op += '<option value="' + data.am_data[i]['terr_id'] + ' " style=" color:green">' + data.am_data[i]['terr_id'] + ' <span style=" color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';
                                }
                                else{
                                    op += '<option value="' + data.am_data[i]['terr_id'] + ' " style=" color:orangered">' + data.am_data[i]['terr_id'] + ' <span style=" color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';
                                }
                            }
                            $('#e_emp_id').html(" ");
                            $('#e_emp_id').append(op);
                        },
                        error: function () {

                        }

                    });
                    // ///////////////////////////////////////////////////////////


                }

            });

            $('#e_rm_terr_id').change(function () {

                console.log('triggered');
                console.log("rm 20.3.2019");
                $('#e_am_name').val('');
                $('#e_emp_id').empty();
                $('#e_am_terr_id').empty();

                $('#e_am_terr_id').append($('<option></option>').html('Loading...'));

                var sc_rm_id = $('#e_rm_terr_id').val();
                var log_desigg = '{{Auth::user()->desig}}';
                $.ajax({
                    type: 'get',
                    url: '{!!URL::to('expense/getAMTerr')!!}',
                    data: {'rm_id': sc_rm_id, 'desig': log_desigg},
                    success: function (data) {
                        $('#e_am_terr_id').empty();


                        if ((data.rm_name.length) > 0) {
                            var rn = data.rm_name[0]['rm_name'];
                            $('#e_rm_name').html(" ");
                            $('#e_rm_name').val(rn);
                            // console.log(data.rm_name);
                        }
                        if ((data.rm_data.length) > 0) {
                            var op = '';
                            op += '<option  value="0" selected disabled>Select AM</option>';
                            for (var i = 0; i < data.rm_data.length; i++) {
                                op += '<option value="' + data.rm_data[i]['am_terr_id'] + '">' + data.rm_data[i]['am_terr_id'] + '</option>';
                            }
//
                            $('#e_am_terr_id').html(" ");
                            $('#e_am_terr_id').html(op);
                            // console.log(data.rm_data);
                        } else {
                            console.log("no data found");
                        }


                    },
                    error: function () {

                    }
                });
            });

            $('#e_am_terr_id').change(function () {

                $('#e_emp_id').empty();
                // $('##e_am_name').empty();
                $('#e_emp_id').append($('<option></option>').html('Loading...'));

                var log_desigg = '{{Auth::user()->desig}}';
                var sc_am_id = $('#e_am_terr_id').val();
                var sc_rmm_id = $('#e_rm_terr_id').val();
                var exp_month = $('#e_month_id').val();

                $.ajax({
                    type: 'get',
                    url: '{!!URL::to('expense/getEmpId')!!}',
                    data: {'rm_id': sc_rmm_id, 'am_id': sc_am_id, 'desig': log_desigg, 'exp_mon': exp_month},
                    success: function (data) {
                        if ((data.am_name.length) > 0) {
                            var an = data.am_name[0]['name'];
                            var as = data.am_data[0]['approved_status'];
                            $('#e_am_name').html(" ");
                            $('#e_am_name').val(an);
                            console.log(data.am_name);
                            console.log(as);
                        }
                        $('#e_emp_id').empty();

                        var op = '';
                        for (var i = 0; i < data.am_data.length; i++) {
                            // op+='<option value="'+data.am_data[i]['emp_id']+'">'+data.am_data[i]['emp_id']+'</option>';
                            // if (data.approved_st[0]['approved_status'] == 'approve')
                            if(data.am_data[i]['approved_status']=='approve'){
                                op += '<option value="' + data.am_data[i]['terr_id'] + ' " style=" color:green">' + data.am_data[i]['terr_id'] + ' <span style=" color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';
                            }
                            else{
                                op += '<option value="' + data.am_data[i]['terr_id'] + ' " style=" color:orangered">' + data.am_data[i]['terr_id'] + ' <span style=" color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';
                            }



                        }
                        $('#e_emp_id').html(" ");
                        $('#e_emp_id').append(op);
                    },
                    error: function () {

                    }
                });
            });

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

            var global_allow_type;
            var global_tour_type;


            var no_oe_img;


            $(document).on('submit', '#frmexpense', function (event) {


                console.log("hmm post method triggering");

                $("#report-body").hide();
                $("#loader").show();
                var div = $(this).parent().parent().parent().parent().parent().parent();

                event.preventDefault();

                var form = $('#frmexpense');
                var formData = form.serialize();

                // console.log(formData);

                var mnth_m = formData.split('&')[1].split('=')[1];
                var empid_m = formData.split('&')[4].split('=')[1];


                var url = "{{URL::to('expense/get_expense_verify_approve')}}";
                var type = 'post';

                $.ajax({
                    type: type,
                    url: url,
                    data: formData,
                    success: function (data) {
                        $("#loader").hide();
                        $("#report-body").show();
                        var len = data.expense.length;

                        global_allow_type = data.g_allowance_typ;
                        global_tour_type = data.g_tour_typ;


                        if (len <= 0) {
                            $('#summary_tour_table').html(" ");
                            div.find('#search_div_id').empty("");

                            if (log_desig == 'MPO') {
                                div.find('#search_div_id').html("<div class='alert alert-danger'><strong>Note:</strong> RM Already Verified this Expense.</div>");
                            } else if (log_desig == 'RM' || log_desig == 'ASM' || log_desig == 'AM') {
                                // console.log(data.table_empty_statusapp);
                                var empty_table = data.table_empty_statusapp;

                                if (empty_table == 'emptytable') {
                                    div.find('#search_div_id').html("<div class='alert alert-danger'><strong>Note:</strong>This Employee has no Expense of " + mnth_m + " .</div>");
                                } else {
                                    div.find('#search_div_id').html("<div class='alert alert-danger'><strong>Note:</strong>Head Office  Already Approved this Expense.</div>");
                                }
                                // div.find('#search_div_id').html("<div class='alert alert-danger'><strong>Note:</strong>Head Office  Already Approved this Expense.</div>");
                            } else {
                                div.find('#search_div_id').html("No Data Found");
                            }

                        } else {

                            ///////////////////////////////////top right side tour type count display///////////////////////////////////////////

                            var tour_table = "";
                            tour_table += "<table class='table table-condensed table-striped table-bordered' height='10' width='10'>";
                            tour_table += "<thead>";
                            tour_table += "<th>Tour Type</th>";
                            tour_table += "<th></th>";
                            tour_table += "</thead>";
                            var summtr = 0;
                            tour_table += "<tbody>";
                            $.each(data.sum_tour_type, function (index, value) {
                                tour_table += " <tr>";
                                tour_table += "<td>" + data.sum_tour_type[index]['tour_type'] + "</td>";
                                tour_table += "<td>" + data.sum_tour_type[index]['countr'] + "</td>";
                                tour_table += " </tr>";
                                summtr = parseInt(data.sum_tour_type[index]['countr']) + summtr;
                            });

                            tour_table += "</tbody>";

                            tour_table += "<tfoot>";
                            tour_table += " <tr>";
                            tour_table += "<td>Total</td>";
                            tour_table += " <td>" + summtr + "</td>";
                            tour_table += "</tr>";
                            tour_table += "</tfoot>";
                            tour_table += "</table>";

                            $('#summary_tour_table').html(" ");
                            $('#summary_tour_table').html(tour_table);
                            ////////////////////////////////////////////////////////////////////////////////////

                            exp_id_g = data.expense[0]['exp_id'];

                            var viewdata = " ";

                            viewdata += "<table id='dvsr_data' class='table table-condensed table-striped table-bordered' width='100%'>";
                            viewdata += "<thead style='background-color:#dcdcdc;white-space:nowrap;'>";


                            viewdata += "<tr>";
                            viewdata += "<th colspan='3'>DEPOT_NAME: <span style='font-size: 11px;color:#885151'>" + data.expense[0]['depot_name'] + "</span></th>";
                            if (data.approved_st[0]['approved_status'] == 'approve') {
                                viewdata += "<th colspan='3'>EMP_ID: <span style='font-size: 11px;color:#008000'>" + data.expense[0]['emp_id'] + "</span></th>";
                            }
                            else{
                                viewdata += "<th colspan='3'>EMP_ID: <span style='font-size: 11px;color:#885151'>" + data.expense[0]['emp_id'] + "</span></th>";
                            }
                            viewdata += "<th colspan='3'>EMP_NAME: <span style='font-size: 11px;color:#885151'>" + data.expense[0]['emp_name'] + "</span></th>";
                            viewdata += "<th colspan='3'>DESIG: <span style='font-size: 11px;color:#885151'>" + data.expense[0]['desig'] + "</span></th>";
                            viewdata += "<th colspan='3'>TERR_ID: <span style='font-size: 11px;color:#885151'>" + data.expense[0]['terr_id'] + "</span></th>";
                            viewdata += "</tr>";

                            viewdata += "<tr>";
                            viewdata += "<th style='text-align:center' rowspan='2'>Exp_Date</th>";
                            viewdata += "<th rowspan='2'>Tour<br>Type</th>";
                            viewdata += "<th rowspan='2'>Tour<br>Details</th>";
                            viewdata += "<th rowspan='2'>Daily<br>Allowance</th>";
                            viewdata += "<th style='text-align:center' colspan='2'>City/Fare Allowance</th>";

                            viewdata += "<th style='text-align:center' colspan='3'>Travel Allowance</th>";

                            viewdata += "<th style='text-align:center' colspan='3'>Other Expense</th>";

                            viewdata += "<th rowspan='2'>Add.<br>Amnt.</th>";
                            viewdata += "<th rowspan='2' >Total</th>";
                            viewdata += "<th style='text-align:center' rowspan='2' >Action</th>";
                            viewdata += "</tr>";


                            viewdata += "<tr>";

                            viewdata += "<th>Type</th>";
                            viewdata += "<th>Allowance</th>";

                            viewdata += "<th>Description</th>";
                            viewdata += "<th>Amount</th>";
                            viewdata += "<th>Image</th>";

                            viewdata += "<th>Description</th>";
                            viewdata += "<th>Amount</th>";
                            viewdata += "<th>Image</th>";

                            viewdata += "</tr>";
                            viewdata += "</thead>";
                            viewdata += "<tbody>";


                            var sum = 0;

                            //define variable initiall for city allowance sum
                            var sum_cityallow = 0;
                            //define variable initiall for travel allowance sum
                            var sum_ta_allow = 0;
                            //define variable initiall for other expense  sum
                            var sum_otherexpense_allow = 0;
                            //Daily Allowance sum   Author:: Sahadat
                            var sum_dailyallow= 0;
                            var sum_addamount =0;

                            $.each(data.expense, function (index, value) {

                                var taimag = data.expense[index]['ta_image_status'];

                                // console.log(taimag);
                                var upstatus = data.expense[index]['update_status'];

                                var guid = data.expense[index]['exp_did'];
                                var imgtypename = 'travelAllowanceImage.jpg';

                                var urlparam = '/' + guid + '/' + imgtypename;
                                var mainurl = "{{route("getImageRoute")}}" + urlparam;

//                                getImageExist
//                                if(taimag=='yes'){
//                                    taimag='<a href="'+mainurl+'" target="_blank">show Image</a>';

//                                }else{
//                                    taimag=taimag;
//                                }


                                if (taimag == 'yes') {
                                    taimag = '<a href="' + mainurl + '" target="_blank">show Image</a>';
//                                    oeimag = '<a href="' + mainurloe + '" target="_blank">show Image</a>';

                                }
                                else {

                                    // console.log(data.expense[index]);
                                    if (!(data.expense[index]['ta_image'] === 'NF')) {
                                        taimag = '<a href="' + data.expense[index]['ta_image'] + '" alt="Travel Allowance image" target="_blank">' +
                                            '<i class="fa fa-picture-o"></i> ' +
                                            'Show Image' +
                                            '</a>';
                                    }
                                    else {
                                        taimag = taimag;
                                    }
                                }

                                var oeimag = data.expense[index]['oe_image_status'];
                                // console.log(oeimag);

                                var imgtypenameoe = 'otherExpenseImage.jpg';
                                var urlparamoe = '/' + guid + '/' + imgtypenameoe;
                                var mainurloe = "{{route("getImageRoute")}}" + urlparamoe;


                                if (oeimag == 'yes') {
                                    oeimag = '<a href="' + mainurloe + '" target="_blank">show Image</a>';

                                }
                                else {

                                    // console.log(data.expense[index]);
                                    if (!(data.expense[index]['oe_image'] === 'NF')) {
                                        oeimag = '<a href="' + data.expense[index]['oe_image'] + '" alt="Other expense image" target="_blank">' +
                                            '<i class="fa fa-picture-o"></i> ' +
                                            'Show Image' +
                                            '</a>';
                                    }
                                    else {
                                        oeimag = oeimag;
                                    }
                                }

                                viewdata += "<tr class='" + data.expense[index]['exp_did'] + "'>";


                                var gd = data.expense[index]['exp_date'];
                                console.log("gd "+gd);
                                var ddsub = data.expense[index]['exp_date'].substring(0, 10);
                                var dateArr = ddsub.split('-');
                                var newDate = dateArr[2] + '/' + dateArr[1] + '/' + dateArr[0];
                                var date = $.format.date(gd, "ddd");
                                var daybar = date;
//                                #  209fa0

                                // tour details null checkup
                                var v_tour_details = data.expense[index]['tour_details'];
                                vv_tour_details = v_tour_details == null ? ' ' : v_tour_details;
                                // console.log('vv_tour_details');
                                // console.log(vv_tour_details);

                                viewdata += "<td>" + newDate + "<br><span style='color:#2287e0'>" + daybar + "</span></td>";

                                // viewdata+="<td>"+data.expense[index]['exp_date'].substring(0,10)+"</td>";
                                viewdata += "<td>" + data.expense[index]['tour_type'] + "</td>";
                                viewdata += "<td>" + vv_tour_details + "</td>";
                                // viewdata+="<td>"+data.expense[index]['tour_details']+"</td>";
                                viewdata += "<td style='text-align: center'>" + data.expense[index]['daily_allowance'] + "</td>";
                                viewdata += "<td>" + data.expense[index]['city_fare_allowance_type'] + "</td>";

                                viewdata += '<td style="text-align: center;background-color:#cae6f3">' + data.expense[index]['city_fare_allowance'] + '<input type="hidden" value="' + data.expense[index]['city_fare_allowance'] + '" class="cityallwhid"></td>';
//                                viewdata+='<td style="text-align: center" class="total_f_sum">'+data.expense[index]['total']+'<input type="hidden" value="'+data.expense[index]['total']+'" class="totalpq"></td>';
                                // ta description null checkup
                                var v_ta_des = data.expense[index]['ta_description'];
                                vv_ta_des = v_ta_des == null ? ' ' : v_ta_des;
                                // console.log('vv_ta_des');
                                // console.log(vv_ta_des);

                                viewdata += "<td>" + vv_ta_des + "</td>";
                                // viewdata+="<td>"+data.expense[index]['ta_description']+"</td>";
//                                viewdata+="<td style='text-align: center;background-color:#d5ca71'>"+data.expense[index]['ta_amount']+"</td>";
                                viewdata += '<td style="text-align: center;background-color:#d5ca71">' + data.expense[index]['ta_amount'] + '<input type="hidden" value="' + data.expense[index]['ta_amount'] + '" class="ta_hid"></td>';
                                viewdata += "<td>" + taimag + "</td>";

                                // oe description null checkup
                                var v_oe_des = data.expense[index]['oe_description'];
                                vv_oe_des = v_oe_des == null ? ' ' : v_oe_des;
                                // console.log('v_oe_des');
                                // console.log(vv_oe_des);

                                viewdata += "<td>" + vv_oe_des + "</td>";
                                // viewdata+="<td>"+data.expense[index]['oe_description']+"</td>";

//                                viewdata+="<td style='text-align: center;background-color:#e6af92'>"+data.expense[index]['oe_amount']+"</td>";
                                viewdata += '<td style="text-align: center;background-color:#e6af92">' + data.expense[index]['oe_amount'] + '<input type="hidden" value="' + data.expense[index]['oe_amount'] + '" class="oe_hid"></td>';
// console.log("final oeimg show"+oeimag);
                                viewdata += "<td>" + oeimag + "</td>";
                                viewdata += "<td style='text-align: center'>" + data.expense[index]['additional_amount'] + "</td>";
                                viewdata += '<td style="text-align: center;background-color:#cfd7d9" class="total_f_sum">' + data.expense[index]['total'] + '<input type="hidden" value="' + data.expense[index]['total'] + '" class="totalpq"></td>';

                                if (data.verified_st[0]['verified_status'] == 'verify'){
                                    viewdata += "<td></td>";
                                }
                                else{
                                    viewdata += "<td><input type='button'  style='margin-right: 4px;' data-oe_img_val='" + oeimag + "' data-ta_img_val='" + taimag + "' data-desigid='" + data.expense[index]['desig'] + "' data-taimgstateid='" + data.expense[index]['ta_image_status'] + "' data-oeimgstateid='" + data.expense[index]['oe_image_status'] + "' data-upstateid='" + data.expense[index]['update_status'] + "' data-citytourtypid='" + data.expense[index]['city_fare_allowance_type'] + "' data-tourtypid='" + data.expense[index]['tour_type'] + "' data-taexpdid='" + data.expense[index]['exp_did'] + "' class='btn-success edit_expense_m' value='Edit'><input type='button' data-tadate='" + newDate + "' data-taexpdid='" + data.expense[index]['exp_did'] + "' class='btn-danger remove_expense_m' value='Del'></td>";
                                }



                                viewdata += "</tr>";

                                sum = sum + parseInt(data.expense[index]['total']);

                                //summing city_allowance one by one
                                sum_cityallow = sum_cityallow + parseInt(data.expense[index]['city_fare_allowance']);
                                //Daily Allowance sum   Author:: Sahadat
                                sum_dailyallow = sum_dailyallow + parseInt(data.expense[index]['daily_allowance']);
                                // console.log(sum_dailyallow);

                                //summing travel_allowance one by one
                                sum_ta_allow = sum_ta_allow + parseInt(data.expense[index]['ta_amount']);

                                //summing other expense one by one
                                sum_otherexpense_allow = sum_otherexpense_allow + parseInt(data.expense[index]['oe_amount']);
                            //    Add amount  sum        Author:: Sahadat
                                sum_addamount = sum_addamount + parseInt(data.expense[index]['additional_amount']);

                            });


                            viewdata += "</tbody>";
                            viewdata += "<tfoot style='background-color:#f5ebdb' >";

                            viewdata += "<tr>";
                            viewdata += "<td colspan='3'>Grand Total:</td>";
//                            Display daily allowance
                            viewdata += "<td id='total_daily_allow' style ='text-align: center;'>" + sum_dailyallow + "</td>";
                            viewdata += "<td></td>";
//                          //display city_allow total sum
                            viewdata += "<td id='total_citysum_final' style='color:#a31813;text-align: center;background-color:#cae6f3'>" + sum_cityallow + "</td>";
                            viewdata += "<td></td>";
                            viewdata += "<td id='total_travelsum_final' style='color:#a31813;text-align: center;background-color:#d5ca71'>" + sum_ta_allow + "</td>";
//                            viewdata+="<td></td>";
                            viewdata += "<td colspan='2'></td>";
                            viewdata += "<td id='total_othersum_final' style='color:#a31813;text-align: center;background-color:#e6af92'>" + sum_otherexpense_allow + "</td>";
                            viewdata += "<td colspan='1'></td>";
                            //                  Display Additional amount
                            viewdata += "<td style = 'text-align: center;'>"+ sum_addamount + "</td>";
                            viewdata += "<td style='color:#a31813;background-color:#cfd7d9' id='total_sum_final'>" + sum + "</td>";
                            viewdata += "<td></td>";

                            viewdata += " </tr>";

                            viewdata += " <tr>";
                            viewdata += " <td colspan='5'>Grand Total In Amount (Tk.) :</td>";
                            viewdata += "<td style='color:#9b0062' colspan='8' class='total_sum_final_inword'>" + convertNumberToWords(sum) + " Take Only</td>";
                            viewdata += "<td colspan='2'></td>";

                            viewdata += "</tr>";

                            if (log_desig != 'MPO') {
                                viewdata += " <tr>";
                                viewdata += "<td colspan='3'>Verified By :</td>";


                                if (!(data.verified_st[0]['verified_by'])) {
                                    viewdata += "<td colspan='2' id='veritext'>" + "<input type='checkbox' id='verifyid' name='verifyname' value='verify'>Verify" + "</td>";
                                }
                                else {
                                    if (data.verified_st[0]['verified_status'] == 'verify') {
                                        viewdata += "<td style='color:#a31813' colspan='2' id='veritext'>Verified</td>";
                                    } else {
                                        viewdata += "<td colspan='2' id='veritext'>" + "<input type='checkbox' id='verifyid' name='verifyname' value='verify'>Verify" + "</td>";
                                    }
                                }

                                if (!(data.verified_st[0]['verified_by'])) {
                                    viewdata += "<td colspan='12' id='veritextlog'></td>";
                                } else {
                                    if (data.verified_st[0]['verified_status'] == 'verify') {
                                        viewdata += "<td style='color:#fa0095' colspan='4' id='veritextlog'><span style='color:#000000'>" + data.verified_st[0]['verified_by'] + "</span> " + "<span>" + data.veri_name[0]['name'] + "</span>"  +  "</td>";
                                        // Verified  Date Added      Author :: Sahadat
                                        viewdata += "<td colspan ='1'> Date :</td>";
                                        viewdata += "<td colspan ='5'>" + "<span style='color:#000000'>"  +  data.verified_st[0]['verified_date'] + "</span>" + "</td>";
                                    } else {
                                        viewdata += "<td colspan='12' id='veritextlog'></td>";
                                    }
                                }


                                viewdata += "</tr>";
                            }

//                            "approved_st" => $approved_st,
//                                    "app_name"=>$name_approved_st
                            if (log_desig == 'HO') {
                                viewdata += " <tr>";
                                viewdata += " <td colspan='3'>Approved By :</td>";

                                if (!(data.approved_st[0]['approved_by'])) {
                                    viewdata += "<td colspan='2' id='apptext'><input type='checkbox' id='approveid' name='approvename' value='approve' value='approve'>Approve</td>";
                                } else {
                                    if (data.approved_st[0]['approved_status'] == 'approve') {
                                        viewdata += "<td colspan='2' style='color:#a31813' id='apptext'>Approved</td>";
                                    } else {
                                        viewdata += "<td colspan='2' style='color:#fa0095' id='apptext'><input type='checkbox' id='approveid' name='approvename' value='approve' value='approve'>Approve</td>";
                                    }
                                }

                                if (!(data.approved_st[0]['approved_by'])) {
                                    viewdata += "<td colspan='12' id='apptextlog'></td>";
                                } else {
                                    if (data.approved_st[0]['approved_status'] == 'approve') {
                                        viewdata += "<td style='color:#fa0095' colspan='4' id='apptextlog'><span style='color:#000000'>" + data.approved_st[0]['approved_by'] + "</span> " + data.app_name[0]['name'] + "</td>";
                                        viewdata += "<td colspan ='1'> Date :</td>";
                                        viewdata += "<td colspan ='5'>" + "<span style='color:#000000'>"  +  data.approved_st[0]['approved_date'] + "</span>" + "</td>";

                                    } else {
                                        viewdata += "<td colspan='12' id='apptextlog'></td>";
                                    }
                                }


                                viewdata += "</tr>";
                            }
//                            if(log_desig!='MPO') {
//                                viewdata += " <tr>";
//                                viewdata += " <td colspan='20'><center><button type='button' class='btn btn-success btn-lg' id='final_whole_sub_btnid'>Submit</button></center></td>";
//
//                                viewdata += "</tr>";
//                            }


                            viewdata += " </tfoot>";
                            viewdata += "</table>";


                            div.find('#search_div_id').empty("");
                            div.find('#search_div_id').html(viewdata);

//                            $('#verifyid').change(function(){
//                                var c = this.checked ? 'yes' : 'no';
//
//                                if(c=='yes'){
//                                    alert("checked");
//                                }
//                            });
                            $('#verifyid').change(function () {

                                var div_app = $('#verifyid').parent().parent();

//                                div_app.css('background-color','yellow');
//                                div_app.find('#veritext').css('background-color','red');
//                                div_app.find('#veritextlog').css('background-color','pink');
                                var c = this.checked ? 'yes' : 'no';
                                if (c == 'yes') {
//                                    alert("checked approve");

                                    var veri_state = $('input[name$="verifyname"]').val();

                                    $.ajax({
                                        type: 'get',
                                        url: '{!!URL::to('expense/finalSubmit')!!}',
                                        data: {'exp_id': exp_id_g, 'status': "verify", 'veri_state': veri_state},
                                        success: function (data) {

                                            div_app.find('#veritext').text("Verified");
                                            div_app.find('#veritextlog').text(log_id + " " + log_name);


//                                            toastr["success"]("Successfully Submit")
//                                              toastr.options = {
//                                                "closeButton": true,
//                                                "debug": false,
//                                                "newestOnTop": false,
//                                                "progressBar": false,
//                                                "positionClass": "toast-top-center",
//                                                "preventDuplicates": false,
//                                                "onclick": null,
//                                                "showDuration": "300",
//                                                "hideDuration": "1000",
//                                                "timeOut": "10000",
//                                                "extendedTimeOut": "1000",
//                                                "showEasing": "swing",
//                                                "hideEasing": "linear",
//                                                "showMethod": "fadeIn",
//                                                "hideMethod": "fadeOut"
//                                            }

                                        },
                                        error: function () {

                                        }
                                    });

                                }
//                                else if(c=='no'){
//                                    alert("checkednoooooooooooooo approve");
//                                }
                            });

                            $('#approveid').change(function () {

                                var div_app = $('#approveid').parent().parent();

//                                div_app.css('background-color','yellow');
//                                div_app.find('#apptext').css('background-color','red');
//                                div_app.find('#apptextlog').css('background-color','pink');
                                var c = this.checked ? 'yes' : 'no';
                                if (c == 'yes') {
//                                    alert("checked approve");

                                    var app_status = $('input[name$="approvename"]').val();

                                    $.ajax({
                                        type: 'get',
                                        url: '{!!URL::to('expense/finalSubmit')!!}',
                                        data: {'exp_id': exp_id_g, 'status': "approve", 'app_state': app_status},
                                        success: function (data) {

                                            div_app.find('#apptext').text("Approved");
                                            div_app.find('#apptextlog').text(log_id + " " + log_name);


//                                            toastr["success"]("Successfully Submit")
//                                              toastr.options = {
//                                                "closeButton": true,
//                                                "debug": false,
//                                                "newestOnTop": false,
//                                                "progressBar": false,
//                                                "positionClass": "toast-top-center",
//                                                "preventDuplicates": false,
//                                                "onclick": null,
//                                                "showDuration": "300",
//                                                "hideDuration": "1000",
//                                                "timeOut": "10000",
//                                                "extendedTimeOut": "1000",
//                                                "showEasing": "swing",
//                                                "hideEasing": "linear",
//                                                "showMethod": "fadeIn",
//                                                "hideMethod": "fadeOut"
//                                            }

                                        },
                                        error: function () {

                                        }
                                    });

                                }
//                                else if(c=='no'){
//                                    alert("checkednoooooooooooooo approve");
//                                }
                            });


                            ////////////Edit Modal////////////////////////////////////////

                            var divk;
                            var rowuid;
                            $(document).on('click', ".edit_expense_m", function () {


                                $(".overlay").show();
                                $("#ta_image").wrap('<form>').parent('form').trigger('reset');
                                $("#ta_image").unwrap();

                                $("#oe_image").wrap('<form>').parent('form').trigger('reset');
                                $("#oe_image").unwrap();

                                divk = $(this);
                                $("#message_ta").empty();
                                $("#message_oe").empty();

                                var url = '{{URL::to('expense/getDataexpense')}}';

                                var uid = $(this).data('taexpdid');
                                rowuid = uid;
                                var tuortyp = $(this).data('tourtypid');
                                var citytuortyp = $(this).data('citytourtypid');
                                var taImgstate = $(this).data('taimgstateid');
                                var oeImgstate = $(this).data('oeimgstateid');
                                var upsatte = $(this).data('upstateid');
                                var desigid = $(this).data('desigid');
                                var img_ta_sh = $(this).data('ta_img_val');
                                var img_oe_sh = $(this).data('oe_img_val');


                                $.ajax({
                                    type: "get",
                                    url: url,
                                    data: {'id': uid, 'citytype': citytuortyp, 'desigid': desigid, 'month':mnth_m},
                                    success: function (data) {

                                        $(".overlay").hide();
                                        $('#udid').val(uid);
                                        if (taImgstate == 'No Image') {
                                            taImgstate = '';
                                        }
                                        if (oeImgstate == 'No Image') {
                                            oeImgstate = '';
                                        }
                                        $('#taimgstate_id').val(taImgstate);
                                        $('#oeimgstate_id').val(oeImgstate);

                                        if (taImgstate == 'yes') {
                                            $('#img_show_link_ta').html(img_ta_sh);
                                        } else {
                                            $('#img_show_link_ta').html(" ");
                                            $('#img_show_link_ta').html("No Image");
                                        }

                                        if (oeImgstate == 'yes') {
                                            $('#img_show_link_oe').html(img_oe_sh);
                                        } else {
                                            $('#img_show_link_oe').html(" ");
                                            $('#img_show_link_oe').html("No Image");
                                        }


                                        $('#upstate_id').val(upsatte);

                                        $('#desig_did').val(desigid);

                                        var depot_name = data.expenses[0]['depot_name'];
                                        $('#depot_nam').html(depot_name);

                                        var emp_idd = data.expenses[0]['emp_id'];
                                        $('#empid').html(emp_idd);

                                        var emp_name = data.expenses[0]['emp_name'];
                                        $('#empname').html(emp_name);

                                        var desig = data.expenses[0]['desig'];
                                        $('#desigg').html(desig);

                                        var terr_id = data.expenses[0]['terr_id'];
                                        $('#terrid').html(terr_id);

                                        var exp_date = data.expenses[0]['exp_date'].substr(0, 11);
                                        $('#expdate').html(exp_date);

                                        var tour_details = data.expenses[0]['tour_details'];
                                        $('#tour_details').val(tour_details);

                                        var daily_allowance = data.expenses[0]['daily_allowance'];
                                        $("#daily_allowance").val(daily_allowance);


                                        var city_fare_allowance = data.expenses[0]['city_fare_allowance'];
                                        $("#city_all").val(city_fare_allowance);


                                        var ta_amount = data.expenses[0]['ta_amount'];
                                        $("#ta_amnt").val(ta_amount);


                                        var ta_description = data.expenses[0]['ta_description'];
                                        $('#ta_des').val(ta_description);

                                        var add_amnt = data.expenses[0]['additional_amount'];
                                        $('#add_amnt').val(add_amnt);

                                        var oe_amount = data.expenses[0]['oe_amount'];
                                        $("#oe_amnt").val(oe_amount);


                                        var oe_description = data.expenses[0]['oe_description'];
                                        $('#oe_des').val(oe_description);


                                        var maxamount = data.expense_ty_max[0]['amount'];
                                        $('#city_all_max').val(maxamount);


                                        var tour_len = data.tour_type.length;
                                        var tour_v = ' ';
                                        tour_v += '<select name="tour_type" id="tour_type" class="form-control">';

                                        for ($k = 0; $k < tour_len; $k++) {

                                            if (data.tour_type[$k]['tour_type_desc'] == tuortyp) {
                                                tour_v += '<option selected value="' + data.tour_type[$k]['tour_type_desc'] + '">' + data.tour_type[$k]['tour_type_desc'] + '</option>';

                                            } else {
                                                tour_v += '<option value="' + data.tour_type[$k]['tour_type_desc'] + '">' + data.tour_type[$k]['tour_type_desc'] + '</option>';

                                            }
                                        }
                                        tour_v += '</select>';


                                        $('#tour_type_id').html(tour_v);


                                        // var allowance_len=data.allowance_typ.length;
                                        // var allow_v=' ';
                                        // allow_v+='<select name="allowance_typ" id="allowance_typ" class="form-control">';
                                        // for($k=0;$k<allowance_len;$k++){

                                        //     if(data.allowance_typ[$k]['allowance_type_desc']==citytuortyp){
                                        //         allow_v+='<option selected value="'+data.allowance_typ[$k]['allowance_type_desc']+'">'+data.allowance_typ[$k]['allowance_type_desc']+'</option>';


                                        //         if(data.allowance_typ[$k]['allowance_type_desc']=='Fare Allowance'){
                                        //             $('#city_all').attr('readonly',false);
                                        //             $('#givencityid').val(city_fare_allowance);
                                        //         }else if(data.allowance_typ[$k]['allowance_type_desc']=='City Allowance'){
                                        //             $('#city_all').attr('readonly',true);
                                        //         }
                                        //     }else{
                                        //         allow_v+='<option value="'+data.allowance_typ[$k]['allowance_type_desc']+'">'+data.allowance_typ[$k]['allowance_type_desc']+'</option>';
                                        //     }
                                        // }

                                        // allow_v+='</select>';

                                        // $('#allowance_type_id').html(allow_v);


                                        // console.log("pi pi");
                                        // console.log(global_allow_type);


//                                        var allowance_len=data.allowance_typ.length;
                                        var allowance_len = global_allow_type.length;
                                        var allow_v = ' ';
                                        allow_v += '<select name="allowance_typ" id="allowance_typ" class="form-control">';
                                        for ($k = 0; $k < allowance_len; $k++) {

                                            if (global_allow_type[$k]['allowance_type_desc'] == citytuortyp) {
                                                allow_v += '<option selected value="' + global_allow_type[$k]['allowance_type_desc'] + '">' + global_allow_type[$k]['allowance_type_desc'] + '</option>';


                                                if (global_allow_type[$k]['allowance_type_desc'] == 'Fare Allowance') {
                                                    $('#city_all').attr('readonly', false);
                                                    $('#givencityid').val(city_fare_allowance);
                                                    // console.log("kere");
                                                } else if (global_allow_type[$k]['allowance_type_desc'] == 'City Allowance') {
                                                    $('#city_all').attr('readonly', true);
                                                    // console.log("bgf yry");
                                                }
                                            } else {
                                                allow_v += '<option value="' + global_allow_type[$k]['allowance_type_desc'] + '">' + global_allow_type[$k]['allowance_type_desc'] + '</option>';
                                            }
//                                            if(data.allowance_typ[$k]['allowance_type_desc']==citytuortyp){
//                                                allow_v+='<option selected value="'+data.allowance_typ[$k]['allowance_type_desc']+'">'+data.allowance_typ[$k]['allowance_type_desc']+'</option>';
//
//
//                                                if(data.allowance_typ[$k]['allowance_type_desc']=='Fare Allowance'){
//                                                    $('#city_all').attr('readonly',false);
//                                                    $('#givencityid').val(city_fare_allowance);
//                                                }else if(data.allowance_typ[$k]['allowance_type_desc']=='City Allowance'){
//                                                    $('#city_all').attr('readonly',true);
//                                                }
//                                            }else{
//                                                allow_v+='<option value="'+data.allowance_typ[$k]['allowance_type_desc']+'">'+data.allowance_typ[$k]['allowance_type_desc']+'</option>';
//                                            }
                                        }

                                        allow_v += '</select>';

                                        $('#allowance_type_id').html(allow_v);


                                        $("#update_expense").modal('show');
//                                        $("#ta_image").empty();
//                                        ('input[type="text"]


                                    },
                                    error: function () {
                                    }
                                });
                            });

                            //////////////removve expense /////////////////////////////////////////
                            $(document).on('click', ".remove_expense_m", function () {
                                // console.log("remove click");
                                var uid = $(this).data('taexpdid');
                                var udate = $(this).data('tadate');
                                // console.log(udate);
                                var divrev = $(this);
                                // console.log(uid);

                                $('#ex_date_m').html(udate);
                                $('#hidden_input_exp_did').val(uid);
                                $('.removeExpense').modal('show');


                                $('.del-modal-expense').click(function () {
                                    // $(this).parent().css('background-color','green');
                                    $(".overlay").show();

                                    // console.log('click successfully');
                                    // console.log(uid);

                                    var dd_id = $('#hidden_input_exp_did').val();

                                    // divrev.parent().parent().css('background-color','yellow');
                                    var divrevove = divrev.parent().parent();
                                    // dvsr_data

                                    // console.log('.'+uid);
                                    // divrevove=divrevove.find('.'+uid);
                                    //  divrevove.css('background-color','green');

                                    $.ajax({
                                        type: 'get',
                                        url: '{!! URL::to('expense/DeleteExpense') !!}',
                                        data: {
                                            'uid': dd_id,
                                            'empid': $('#e_emp_id').val(),
                                            'month_dy': $('#e_month_id').val()
                                        },
                                        success: function (data) {

                                            $(".overlay").hide();
                                            // console.log("data");
                                            // console.log(data);
                                            // divrevove.css('background-color','pink');
                                            // var rr=divrevove.find('.'+data);

                                            var rr = $('#dvsr_data tbody .' + dd_id + '');
                                            // console.log(rr);
                                            // rr.css('background-color','pink');
                                            rr.remove();

                                            //////////////////////
                                            var summation = 0;

                                            $('.totalpq').each(function (i, e) {
                                                var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                summation += amount;
                                            });

                                            var wrd;
                                            wrd = convertNumberToWords(summation);
                                            //after remove button click .......after remove tr ....sum the all 'city allowance'
                                            var city_summation = 0;

                                            $('.cityallwhid').each(function (i, e) {
                                                var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                city_summation += amount;
                                            });

                                            //after remove button click .......after remove tr ....sum the all 'tour allowance'
                                            var tour_summation = 0;

                                            $('.ta_hid').each(function (i, e) {
                                                var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                tour_summation += amount;
                                            });

                                            //after remove button click .......after remove tr ....sum the all 'otherexpense'
                                            var other_summation = 0;

                                            $('.oe_hid').each(function (i, e) {
                                                var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                other_summation += amount;
                                            });


                                            //after remove tr ....text addition
                                            $('#total_sum_final').text(summation);
                                            $('#total_citysum_final').text(city_summation);
                                            $('#total_travelsum_final').text(tour_summation);
                                            $('#total_othersum_final').text(other_summation);

                                            $('.total_sum_final_inword').text(" ");
                                            $('.total_sum_final_inword').text(wrd + " Taka Only");

                                            ///////////////////////////////////after top right side tour type count display///////////////////////////////////////////

                                            var tour_table_Afterremove = "";
                                            tour_table_Afterremove += "<table class='table table-condensed table-striped table-bordered' height='10' width='10'>";
                                            tour_table_Afterremove += "<thead>";
                                            tour_table_Afterremove += "<th>Tour Type</th>";
                                            tour_table_Afterremove += "<th></th>";
                                            tour_table_Afterremove += "</thead>";
                                            var summtr_afterRemove = 0;
                                            tour_table_Afterremove += "<tbody>";
                                            $.each(data.sum_tour_type, function (index, value) {
                                                tour_table_Afterremove += " <tr>";
                                                tour_table_Afterremove += "<td>" + data.sum_tour_type[index]['tour_type'] + "</td>";
                                                tour_table_Afterremove += "<td>" + data.sum_tour_type[index]['countr'] + "</td>";
                                                tour_table_Afterremove += " </tr>";
                                                summtr_afterRemove = parseInt(data.sum_tour_type[index]['countr']) + summtr_afterRemove;
                                            });

                                            tour_table_Afterremove += "</tbody>";

                                            tour_table_Afterremove += "<tfoot>";
                                            tour_table_Afterremove += " <tr>";
                                            tour_table_Afterremove += "<td>Total</td>";
                                            tour_table_Afterremove += " <td>" + summtr_afterRemove + "</td>";
                                            tour_table_Afterremove += "</tr>";
                                            tour_table_Afterremove += "</tfoot>";
                                            tour_table_Afterremove += "</table>";

                                            $('#summary_tour_table').html(" ");
                                            $('#summary_tour_table').html(tour_table_Afterremove);
                                            ////////////////////////////////////////////////////////////////////////////////////


                                            $('.removeExpense').modal('hide');
                                            toastr["danger"]("Successfully Expense Deleted")
                                            toastr.options = {
                                                "closeButton": true,
                                                "debug": false,
                                                "newestOnTop": false,
                                                "progressBar": false,
                                                "positionClass": "toast-top-center",
                                                "preventDuplicates": false,
                                                "onclick": null,
                                                "showDuration": "300",
                                                "hideDuration": "100",
                                                "timeOut": "100",
                                                "extendedTimeOut": "100",
                                                "showEasing": "swing",
                                                "hideEasing": "linear",
                                                "showMethod": "fadeIn",
                                                "hideMethod": "fadeOut"
                                            }


                                        },
                                        error: function () {
                                            console.log('error');
                                        }
                                    });
                                });
                            });


                            //after modal open tour typ val change track


                            //after modal open tour typ val change track

                            $(document).on('change', '#tour_type', function (event) {

                                var tt = $(this).val();


                                // console.log(global_tour_type);

                                var tour_len = global_tour_type.length;
                                var ttindex;
                                var amunt_t;

                                for ($k = 0; $k < tour_len; $k++) {

                                    if (global_tour_type[$k]['expense_type'] == tt) {
                                        amunt_t = global_tour_type[$k]['amount'];
                                        ttindex = $k;
                                    }
                                }


                                $('#daily_allowance').val(amunt_t);


                            });

                            //after modal open tour typ val change track

                            $(document).on('change', '#allowance_typ', function (event) {
                                event.preventDefault();

                                var ct = $(this).val();

                                var desigg = $('#desig_did').val();

                                var allowance_len_c = global_allow_type.length;
                                var amunt_c;

                                var kindex;

                                for ($k = 0; $k < allowance_len_c; $k++) {

                                    if (global_allow_type[$k]['allowance_type_desc'] == ct) {
                                        amunt_c = global_allow_type[$k]['amount'];
                                        kindex = $k;
                                    }
//
                                }
                                // console.log(global_allow_type[kindex]['allowance_type_desc']);

                                if (global_allow_type[kindex]['allowance_type_desc'] == 'City Allowance') {
                                    $('#city_all').val(amunt_c);
                                    $('#city_all').attr("readonly", true);
                                } else if (global_allow_type[kindex]['allowance_type_desc'] == 'Fare Allowance') {
                                    $('#city_all').val(0);
                                    $('#city_all_max').val(amunt_c);
                                    $('#city_all').attr("readonly", false);
                                }
                                // console.log("final amount");
                                // console.log(amunt_c);


                                //get daily allowance based on tour type
                            });

                            $('#city_all').on('keyup keydown', function (e) {

                                var max = parseInt($('#city_all_max').val());

                                if (parseInt($(this).val()) > max) {
//                                    $('#maxerror').html(" Maximum Amount "+max);
                                    $('#maxerror').html(" Maximum Amount Cross");
//                                $('#maxerror').html(parseInt($(this).val())+" > "+max);
                                } else {
//                                $('#maxerror').html(parseInt($(this).val())+" < "+max);
                                    $('#maxerror').html(" ");
                                }
                            });


                            //jpg checking for ta_image
                            $("#ta_image").change(function () {

                                $("#message_ta").empty(); // To remove the previous error message
                                var file = this.files[0];

                                var imagefile = file.type;

//                                var match= ["image/jpeg","image/png","image/jpg"];
                                        {{--if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))--}}

                                var match = ["image/jpeg", "image/jpg"];
                                if (!(imagefile == match[0]) || (imagefile == match[1])) {


                                    $("#message_ta").html("<p id='error' style='color:red'>Please Select A valid Image File</p>" + "<b>Note</b>" + "<span id='error_message'>Only jpg,jpeg Image type allowed</span>");

                                    return false;
                                }
                            });

                            //jpg checking for oe_image
                            $("#oe_image").change(function () {

                                $("#message_oe").empty(); // To remove the previous error message
                                var file = this.files[0];
                                var imagefile = file.type;

//                                var match= ["image/jpeg","image/png","image/jpg"];
                                        {{--if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))--}}

                                var match = ["image/jpeg", "image/jpg"];
                                if (!(imagefile == match[0]) || (imagefile == match[1])) {

                                    $("#message_oe").html("<p id='error' style='color:red'>Please Select A valid Image File</p>" + "<b>Note</b>" + "<span id='error_message'>Only jpg,jpeg Image type allowed</span>");

                                    return false;
                                }
                            });


                            //after submit modal form """"""""""""""""Edit """""""""""
                            $('#frmExpense').on('submit', function (event) {

                                event.preventDefault();

                                var givendata = parseInt($('#city_all').val());
                                var maxdata = parseInt($('#city_all_max').val());

                                if (givendata > maxdata) {
//                                    $('#maxerror').html("Given Amount is greater than "+maxdata+"Please input amount less than "+maxdata);
                                    $('#maxerror').html("Maximun Amount Cross");
                                } else {
                                    var form = $('#frmExpense');
                                    var furl = "{!! URL::to('expense/newExpense') !!}";
                                    var type = 'post';

                                    //ajax23 replace tr

                                    // console.log("replace tr");
                                    // console.log($('#e_emp_id').val());
                                    // console.log($('#e_month_id').val());
                                    $.ajax({
                                        url: furl,
                                        data: new FormData(this),
                                        async: true,
                                        type: "POST",
                                        contentType: false, // high importance!
                                        processData: false, // high importance
                                        success: function (data) {


                                            $.ajax({
                                                type: "get",
                                                url: "{!! URL::to('expense/getrowdata') !!}",
                                                data: {
                                                    'id': rowuid,
                                                    'empid': $('#e_emp_id').val(),
                                                    'month_dy': $('#e_month_id').val()
                                                },
                                                success: function (data) {

                                                    {{--<a href="{{route('getEditPassRoute',$employee->id)}}"--}}

                                                    //                                            if(

                                                    // console.log("newExpense");
                                                    // console.log(data.sum_tour_type);


                                                    ///////////////////////////////////after top right side tour type count display///////////////////////////////////////////

                                                    var tour_table_afteredit = "";
                                                    tour_table_afteredit += "<table class='table table-condensed table-striped table-bordered' height='10' width='10'>";
                                                    tour_table_afteredit += "<thead>";
                                                    tour_table_afteredit += "<th>Tour Type</th>";
                                                    tour_table_afteredit += "<th></th>";
                                                    tour_table_afteredit += "</thead>";
                                                    var summtr_afteredit = 0;
                                                    tour_table_afteredit += "<tbody>";
                                                    $.each(data.sum_tour_type, function (index, value) {
                                                        tour_table_afteredit += " <tr>";
                                                        tour_table_afteredit += "<td>" + data.sum_tour_type[index]['tour_type'] + "</td>";
                                                        tour_table_afteredit += "<td>" + data.sum_tour_type[index]['countr'] + "</td>";
                                                        tour_table_afteredit += " </tr>";
                                                        summtr_afteredit = parseInt(data.sum_tour_type[index]['countr']) + summtr_afteredit;
                                                    });

                                                    tour_table_afteredit += "</tbody>";

                                                    tour_table_afteredit += "<tfoot>";
                                                    tour_table_afteredit += " <tr>";
                                                    tour_table_afteredit += "<td>Total</td>";
                                                    tour_table_afteredit += " <td>" + summtr_afteredit + "</td>";
                                                    tour_table_afteredit += "</tr>";
                                                    tour_table_afteredit += "</tfoot>";
                                                    tour_table_afteredit += "</table>";

                                                    $('#summary_tour_table').html(" ");
                                                    $('#summary_tour_table').html(tour_table_afteredit);
                                                    ////////////////////////////////////////////////////////////////////////////////////

                                                    var viewdata_r;

                                                    var taimag = data.expense[0]['ta_image_status'];
                                                    var guid = data.expense[0]['exp_did'];
                                                    var imgtypename = 'travelAllowanceImage.jpg';
                                                    var urlparam = '/' + guid + '/' + imgtypename;
                                                    var mainurl = "{{route("getImageRoute")}}" + urlparam;

                                                    {{--<a href="{{route('getEditPassRoute',$employee->id)}}" class="btn-floating btn-small waves-effect waves-light pink tooltipped" data-position="bottom" data-delay="50" data-tooltip="Change Password" ><i class="mdi-action-lock"></i></a>--}}

                                                    if (taimag == 'yes') {
                                                        taimag = '<a href="' + mainurl + '" target="_blank">show Image</a>';

                                                    } else {
                                                        taimag = taimag;
                                                    }

                                                    var oeimag = data.expense[0]['oe_image_status'];

                                                    var imgtypenameoe = 'otherExpenseImage.jpg';
                                                    var urlparamoe = '/' + guid + '/' + imgtypenameoe;
                                                    var mainurloe = "{{route("getImageRoute")}}" + urlparamoe;


                                                    if (oeimag == 'yes') {
                                                        oeimag = '<a href="' + mainurloe + '" target="_blank">show Image</a>';

                                                    } else {
                                                        oeimag = oeimag;
                                                    }


                                                    viewdata_r += "<tr class='" + data.expense[0]['exp_did'] + "'>";

//                                                    viewdata_r += "<td>" + data.expense[0]['depot_name'] + "</td>";
//                                                    viewdata_r += "<td>" + data.expense[0]['emp_id'] + "</td>";
//                                                    viewdata_r += "<td>" + data.expense[0]['emp_name'] + "</td>";
//                                                    viewdata_r += "<td>" + data.expense[0]['desig'] + "</td>";
//                                                    viewdata_r += "<td>" + data.expense[0]['terr_id'] + "</td>";

                                                    var gd_r = data.expense[0]['exp_date'];

                                                    var ddsub_r = data.expense[0]['exp_date'].substring(0, 10);
                                                    var dateArr_r = ddsub_r.split('-');
                                                    var newDate_r = dateArr_r[2] + '/' + dateArr_r[1] + '/' + dateArr_r[0];

                                                    var date_r = $.format.date(gd_r, "ddd");
                                                    var daybar_r = date_r;

                                                    viewdata_r += "<td>" + newDate_r + "<br><span style='color:#2287e0'>" + daybar_r + "</span></td>";

                                                    // tour details null checkup viewdata_r
                                                    var v_tour_details_r = data.expense[0]['tour_details'];
                                                    vv_tour_details_r = v_tour_details_r == null ? ' ' : v_tour_details_r;

                                                    // viewdata_r += "<td>" + data.expense[0]['exp_date'].substr(0,11) + "</td>";
                                                    viewdata_r += "<td>" + data.expense[0]['tour_type'] + "</td>";
                                                    viewdata_r += "<td>" + vv_tour_details_r + "</td>";
                                                    // viewdata_r += "<td>" + data.expense[0]['tour_details'] + "</td>";
                                                    viewdata_r += "<td style='text-align: center'>" + data.expense[0]['daily_allowance'] + "</td>";
                                                    viewdata_r += "<td>" + data.expense[0]['city_fare_allowance_type'] + "</td>";

//                                                    viewdata_r+="<td style='text-align: center'>"+data.expense[0]['city_fare_allowance']+"</td>";
                                                    viewdata_r += '<td style="text-align: center;background-color:#cae6f3">' + data.expense[0]['city_fare_allowance'] + '<input type="hidden" value="' + data.expense[0]['city_fare_allowance'] + '" class="cityallwhid"></td>';


                                                    // ta description null checkup
                                                    var v_ta_des_r = data.expense[0]['ta_description'];
                                                    vv_ta_des_r = v_ta_des_r == null ? ' ' : v_ta_des_r;
                                                    // console.log('vv_ta_des_r');
                                                    // console.log(vv_ta_des_r);
                                                    // viewdata_r+="<td>"+data.expense[0]['ta_description']+"</td>";
                                                    viewdata_r += "<td>" + vv_ta_des_r + "</td>";

//                                                    viewdata_r+="<td style='text-align: center'>"+data.expense[0]['ta_amount']+"</td>";
                                                    viewdata_r += '<td style="text-align: center;background-color:#d5ca71">' + data.expense[0]['ta_amount'] + '<input type="hidden" value="' + data.expense[0]['ta_amount'] + '" class="ta_hid"></td>';
                                                    viewdata_r += "<td>" + taimag + "</td>";

                                                    // oe description null checkup
                                                    var v_oe_des_r = data.expense[0]['oe_description'];
                                                    vv_oe_des_r = v_oe_des_r == null ? ' ' : v_oe_des_r;

                                                    viewdata_r += "<td>" + vv_oe_des_r + "</td>";
                                                    // viewdata_r+="<td>"+data.expense[0]['oe_description']+"</td>";

//                                                    viewdata_r+="<td style='text-align: center'>"+data.expense[0]['oe_amount']+"</td>";
                                                    viewdata_r += '<td style="text-align: center;background-color:#e6af92">' + data.expense[0]['oe_amount'] + '<input type="hidden" value="' + data.expense[0]['oe_amount'] + '" class="oe_hid"></td>';
                                                    viewdata_r += "<td>" + oeimag + "</td>";
                                                    viewdata_r += "<td style='text-align: center'>" + data.expense[0]['additional_amount'] + "</td>";
                                                    viewdata_r += '<td style="text-align: center" class="total_f_sum">' + data.expense[0]['total'] + '<input type="hidden" value="' + data.expense[0]['total'] + '" class="totalpq"></td>';

                                                    viewdata_r += "<td><input style='margin-right: 4px;' type='button' data-oe_img_val='" + oeimag + "' data-ta_img_val='" + taimag + "' data-desigid='" + data.expense[0]['desig'] + "' data-taimgstateid='" + data.expense[0]['ta_image_status'] + "' data-oeimgstateid='" + data.expense[0]['oe_image_status'] + "' data-upstateid='" + data.expense[0]['update_status'] + "' data-citytourtypid='" + data.expense[0]['city_fare_allowance_type'] + "' data-tourtypid='" + data.expense[0]['tour_type'] + "' data-taexpdid='" + data.expense[0]['exp_did'] + "' class='btn-success edit_expense_m' value='Edit'><input type='button' data-tadate='" + newDate_r + "' data-taexpdid='" + data.expense[0]['exp_did'] + "' class='btn-danger remove_expense_m' value='Del'></td>";


                                                    viewdata_r += "</tr>";

                                                    divk.parent().parent().replaceWith(viewdata_r);

                                                    //after edit button click .......after replace tr ....sum the all 'total'
                                                    var summation = 0;

                                                    $('.totalpq').each(function (i, e) {
                                                        var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                        summation += amount;
                                                    });

                                                    //after edit button click .......after replace tr ....sum the all 'city allowance'
                                                    var city_summation = 0;

                                                    $('.cityallwhid').each(function (i, e) {
                                                        var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                        city_summation += amount;
                                                    });


                                                    var wrd;
                                                    wrd = convertNumberToWords(summation);

                                                    //after remove button click .......after remove tr ....sum the all 'tour allowance'
                                                    var tour_summation = 0;

                                                    $('.ta_hid').each(function (i, e) {
                                                        var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                        tour_summation += amount;
                                                    });

                                                    //after remove button click .......after remove tr ....sum the all 'otherexpense'
                                                    var other_summation = 0;

                                                    $('.oe_hid').each(function (i, e) {
                                                        var amount = $(this).val() - 0;//current je value ta ta nibe here i holo index no r e holo element
                                                        other_summation += amount;
                                                    });


                                                    //after edit replace ....text addition
                                                    $('#total_sum_final').text(summation);
                                                    $('#total_citysum_final').text(city_summation);
                                                    $('#total_travelsum_final').text(tour_summation);
                                                    $('#total_othersum_final').text(other_summation);

                                                    //after edit replace ....text addition
//                                                    $('#total_sum_final').text(summation);
//                                                    $('#total_citysum_final').text(city_summation);


                                                    $('.total_sum_final_inword').text(" ");
                                                    $('.total_sum_final_inword').text(wrd + " Taka Only");

                                                    $("#update_expense").modal('hide');
                                                },
                                                error: function () {
                                                }
                                            });
                                            ////////////////////////end close btn//////////////////////////////


                                        },
                                        error: function () {

                                        }
                                    });
                                }//endif else givendata maxdata

                            });


                        }//end else


                    },
                    error: function (data) {
                        console.log("fail");
                    }
                });


            });

            ////////////conver no to words //////////////////////////////


        });


    </script>

@endsection
