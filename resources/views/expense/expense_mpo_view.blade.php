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
                        Expense View
                    </label>
                </header>
                <div class="panel-body style="padding-left: 5px; padding-right: 5px;">
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



                                    <div class="col-sm-4 col-md-4">
                                        <label class="control-label col-md-4 col-sm-4 input-sm" for="p_group">
                                            <b>Reg.Terr:</b></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select name="e_rm_terr_id" id="e_rm_terr_id" class="form-control input-sm"
                                                    disabled>


{{--                                                <option class="sel_rm" value="1" disabled="true">Select RM</option>--}}

{{--                                                <!-- <option value="0" disabled="true" selected="true">Select RM</option> -->--}}
                                                @foreach($rm_terr as $dd)
                                                    <option value="{{$dd->rm_terr_id}}">{{$dd->rm_terr_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-12 col-md-12" style="padding-top: 5px;padding-bottom: 5px">

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
            // $("#e_rm_terr_id option[value='0']").remove();
            $("#e_rm_terr_id").prop("disabled", false);
            //            $("select option[value='B']").attr("selected","selected");
            $('select option[class="sel_rm"]').attr("selected", "selected");
            //


            var log_name = '{{Auth::user()->name}}';
            var log_id = '{{Auth::user()->user_id}}';
            var log_desig = '{{Auth::user()->desig}}';
            var exp_id_g;

            {{--$('#e_month_id').change(function () {--}}

            {{--    // console.log("month change ");--}}
            {{--    // console.log($('#e_month_id').val());--}}
            {{--    // console.log($('#e_rm_terr_id').val());--}}
            {{--    // console.log($('#e_am_terr_id').val());--}}

            {{--    if (($('#e_rm_terr_id').val()) != null && ($('#e_am_terr_id').val()) != null) {--}}
            {{--        // console.log("month change ---u have to do something");--}}

            {{--        //////////////////////Get employee id/////////////////////////////////--}}
            {{--        $('#e_emp_id').empty();--}}
            {{--        $('#e_emp_id').append($('<option></option>').html('Loading...'));--}}

            {{--        var log_desigg = '{{Auth::user()->desig}}';--}}
            {{--        var sc_am_id = $('#e_am_terr_id').val();--}}
            {{--        var sc_rmm_id = $('#e_rm_terr_id').val();--}}
            {{--        var exp_month = $('#e_month_id').val();--}}

            {{--        $.ajax({--}}
            {{--            type: 'get',--}}
            {{--            url: '{!!URL::to('expense/getEmpId')!!}',--}}
            {{--            data: {'rm_id': sc_rmm_id, 'am_id': sc_am_id, 'desig': log_desigg, 'exp_mon': exp_month},--}}
            {{--            success: function (data) {--}}

            {{--                $('#e_emp_id').empty();--}}

            {{--                var op = '';--}}
            {{--                for (var i = 0; i < data.am_data.length; i++) {--}}
            {{--                    // op+='<option value="'+data.am_data[i]['emp_id']+'">'+data.am_data[i]['emp_id']+'</option>';--}}
            {{--                   // op += '<option value="' + data.am_data[i]['terr_id'] + '">' + data.am_data[i]['terr_id'] + ' <span style="color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';--}}
            {{--                    if(data.am_data[i]['approved_status']=='approve'){--}}
            {{--                        op += '<option value="' + data.am_data[i]['terr_id'] + ' " style=" color:green">' + data.am_data[i]['terr_id'] + ' <span style=" color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';--}}
            {{--                    }--}}
            {{--                    else{--}}
            {{--                        op += '<option value="' + data.am_data[i]['terr_id'] + ' " style=" color:orangered">' + data.am_data[i]['terr_id'] + ' <span style=" color:green"> (' + data.am_data[i]['emp_id'] + ' )  </span> </option>';--}}
            {{--                    }--}}
            {{--                }--}}
            {{--                $('#e_emp_id').html(" ");--}}
            {{--                $('#e_emp_id').append(op);--}}
            {{--            },--}}
            {{--            error: function () {--}}

            {{--            }--}}

            {{--        });--}}
            {{--        // ///////////////////////////////////////////////////////////--}}


            {{--    }--}}

            {{--});--}}



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


                // console.log("hmm finall belocal submity");

                $("#report-body").hide();
                $("#loader").show();
                var div = $(this).parent().parent().parent().parent().parent().parent();

                event.preventDefault();

                var form = $('#frmexpense');
                var formData = form.serialize();

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
                            //
                            // if (log_desig == 'MPO') {
                            //     div.find('#search_div_id').html("<div class='alert alert-danger'><strong>Note:</strong> RM Already Verified this Expense.</div>");
                            // }

                                if (log_desig == 'RM' || log_desig == 'ASM' ) {
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
                            // viewdata += "<th style='text-align:center' rowspan='2' >Action</th>";
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

                                // viewdata += "<td><input type='button' style='margin-right: 4px;' data-oe_img_val='" + oeimag + "' data-ta_img_val='" + taimag + "' data-desigid='" + data.expense[index]['desig'] + "' data-taimgstateid='" + data.expense[index]['ta_image_status'] + "' data-oeimgstateid='" + data.expense[index]['oe_image_status'] + "' data-upstateid='" + data.expense[index]['update_status'] + "' data-citytourtypid='" + data.expense[index]['city_fare_allowance_type'] + "' data-tourtypid='" + data.expense[index]['tour_type'] + "' data-taexpdid='" + data.expense[index]['exp_did'] + "' class='btn-success edit_expense_m' value='Edit'><input type='button' data-tadate='" + newDate + "' data-taexpdid='" + data.expense[index]['exp_did'] + "' class='btn-danger remove_expense_m' value='Del'></td>";


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

                                viewdata += " <tr>";
                                viewdata += "<td colspan='3'>Verified By :</td>";


                                if (!(data.verified_st[0]['verified_by'])) {
                                    viewdata += "<td style='color:#a31813' colspan='12' id='veritext'>Not Verified</td>";
                                }
                                else {
                                    if (data.verified_st[0]['verified_status'] == 'verify') {
                                        viewdata += "<td style='color:#a31813' colspan='12' id='veritext'>Verified</td>";
                                    } else {
                                        viewdata += "<td style='color:#a31813' colspan='12' id='veritext'>N/A</td>";
                                    }
                                }

                                viewdata += "</tr>";


//                            "approved_st" => $approved_st,
//                                    "app_name"=>$name_approved_st

                                viewdata += " <tr>";
                                viewdata += " <td colspan='3'>Approved By :</td>";

                                if (!(data.approved_st[0]['approved_by'])) {
                                    viewdata += "<td colspan='12' style='color:#a31813' id='apptext'>N/A</td>";
                                } else {
                                    if (data.approved_st[0]['approved_status'] == 'approve') {
                                        viewdata += "<td colspan='12' style='color:#a31813' id='apptext'>Approved</td>";
                                    } else {
                                        viewdata += "<td colspan='12' style='color:#a31813' id='apptext'>N/A</td>";
                                    }
                                }




                                viewdata += "</tr>";

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


                            ////////////Edit Modal////////////////////////////////////////

                            var divk;
                            var rowuid;

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
