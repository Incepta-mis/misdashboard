@extends('_layout_shared._master')
@section('title','Cost Center Budget')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/rowGroup.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
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
            font-size: 11px;
        }

        body {
            color: #000;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/

        }


    </style>
@endsection

@section('right-content')
    <form method="post" action="{{url('donation/print_advice')}}">
        {{csrf_field()}}
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Cost Center Budget
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bgt_year"
                                                       class="col-md-4 control-label"><b>Year</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_year" id="bgt_year"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($year as $mn)
                                                            <option value="{{$mn->year}}">{{$mn->year}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        {{--                                                            @foreach($month_name as $mn)--}}
                                                        {{--                                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>--}}
                                                        {{--                                                            @endforeach--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="gl"
                                                       class="col-md-3 col-sm-6 control-label"><b>GL</b></label>
                                                <div class="col-md-9">
                                                    <select name="gl" id="gl"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        <option value="ALL">ALL</option>
                                                        @foreach($gl as $gl)
                                                            <option value="{{$gl->gl}}">{{$gl->gl}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cc"
                                                       class="col-md-4 col-sm-6 control-label"><b>Cost
                                                        Center</b></label>
                                                <div class="col-md-8">
                                                    <select name="cc" id="cc"
                                                            class="form-control input-sm">

                                                        <option value="">Select Cost Center</option>
                                                        <option value="ALL">ALL</option>
                                                        {{--                                                            @foreach($cc as $ccn)--}}
                                                        {{--                                                                <option value="{{$ccn->cost_center_id}}">--}}
                                                        {{--                                                                    {{$ccn->cost_center_description}}</option>--}}
                                                        {{--                                                            @endforeach--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-1">

                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>

                                        </div>


                                        <div class="col-md-1" style="margin-left: 5%;">

                                            <button type="button" id="btn_history" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>History</b></button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/c_loading.gif')}}"
                         alt="Loading Report Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Please wait...</i></b></span>
                </div>
            </div>
        </div>

        <div class="row" id="report-body" style="display: none;">

            <div class="">
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="budget_table" class="table table-condensed table-striped table-bordered"
                                       width="100%">
                                    <thead style="white-space:nowrap;">
                                    <tr>
                                        <th>Expense Month</th>
                                        <th>GL</th>
                                        <th>COST CENTER ID</th>
                                        <th>COST CENTER NAME</th>
                                        <th>Carry Forward Amount</th>
                                        <th>Current Month Amount</th>
                                        <th>Total Budget</th>


                                    </tr>
                                    </thead>
                                    <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="col-md-2">
                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                            <button type="button" id="add_budget" class="btn btn-default btn-sm">
                                <i class="fa fa-check"></i> <b>Add Budget</b></button>
                        </div>
                    </div>

                    <div class="col-md-4 add_budget_ammount" style="display: none;">
                        <div class="col-md-5">Current Amount</div>
                        <div class="col-md-7"><input id="add_current_amount" value="0" type="number"
                                                     style=" padding: 3px 10px;"></div>
                    </div>

                    <div class="col-md-4 add_budget_ammount" style="display: none;">
                        <div class="col-md-5">Carry Amount</div>
                        <div class="col-md-7"><input id="add_carry_amount" value="0" type="number"
                                                     style=" padding: 3px 10px;"></div>
                    </div>

                </div>
            </div>

            <div class="row">
                &nbsp;
            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="col-md-8 add_budget_ammount" style="display: none;">

                        <div class="col-md-2">Remarks</div>
                        <div class="col-md-10">

                            <input id="comment" value="" type="text" style=" padding: 12px 20px; width: 100%;">


                        </div>

                    </div>


                    <div class="col-md-2 save_budget" style="display: none;">
                        <div class=" col-md-2 ">
                            <button type="button" id="save_budget" class="btn btn-default btn-sm">
                                <i class="fa fa-check"></i> <b>Save</b></button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <section class="panel-body">
        </section>

        <div class="row " style="display: none;" id='div_budget_history'>
            <div class="col-sm-12 col-md-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="table_budget_history" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th> Month</th>
                                    <th>COST CENTER ID</th>
                                    <th>COST CENTER NAME</th>
                                    <th>Carry Forward</th>
                                    <th>Current Month Amount</th>
                                    <th>Remarks</th>
                                    <th>Time</th>
                                    <th>User</th>

                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>

                            </table>
                        </div>
                    </div>

                </section>
            </div>
        </div>

    </form>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

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
    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}

    <script type="text/javascript">
        re_year = "{{url('scientific/re_year')}}";
        subtract_budget_calc = "{{url('scientific/subtract_budget_calc')}}";
        cc_budget_display = "{{url('scientific/cc_budget_display')}}";
        insert_cc_budget = "{{url('scientific/insert_cc_budget')}}";
        cc_budget_history = "{{url('scientific/cc_budget_history')}}";
        cc_don = "{{url('scientific/cc_don')}}";
        _csrf_token = '{{csrf_token()}}';
        var table;

        $(document).ready(function () {

                var mon = '';
                var cc = '';
                var gl = '';

                $('#bgt_year').on('change', function () {

                    var year = $('#bgt_year').val();
                    $("#bgt_month").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        method: "post",
                        url: re_year,
                        data: {
                            _token: _csrf_token,
                            year: year
                        },
                        success: function (data) {
                            console.log(data);
                            // console.log(data.length);
                            if ((data.length) > 0) {
                                var op = '';

                                op += "<option value='ALL'>ALL</option>";

                                for (var i = 0; i < data.length; i++) {
                                    op += '<option value= " ' + data[i]['payment_month'] + ' " >' + data [i]['payment_month'] + '</option>';
                                }
                                $('#bgt_month').html(" ");
                                $('#bgt_month').append(op);
                            }

                        },
                        error: function () {
                            console.log('fail');
                        }
                    });
                });

                $("#gl").on('change', function () {
                    console.log('working properly');

                    $('#cc').empty();

                    var gl = $("#gl").val();

                    console.log(gl);

                    $("#cc").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        type: "GET",
                        url: cc_don,
                        dataType: 'json',
                        data: {gl: gl},
                        success: function (response) {
                            console.log(response);

                            var selOptsMPO = "";
                            selOptsMPO += "<option value='ALL'>ALL</option>";
                            for (var j = 0; j < response.length; j++) {
                                var id = response[j]['cost_center_id'];
                                var val = response[j]['cost_center_description'];
                                selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                            }
                            // $('#mpo_terr').html(selOptsMPO);
                            $('#cc').empty().append(selOptsMPO);


                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });

                });

                $("#add_budget").click(function () {

                    $('#save_budget').prop('disabled', false);
                    $("#add_current_amount").val('0');
                    $("#add_carry_amount").val('0');
                    $("#comment").val('');
                    $(".add_budget_ammount").show();
                    $(".save_budget").show();

                });

                $("#btn_history").click(function () {

                    if ($("#bgt_month").val() === "") {
                        alert("Please select Expense Month");
                    } else if ($("#gl").val() === "") {
                        alert("Please select GL");
                    } else if ($("#cc").val() === "") {
                        alert("Please select Cost center");
                    } else if ($("#bgt_year").val() === "") {
                        alert("Please select Year");
                    } else {


                        $("#div_budget_history").hide();

                        var year = $("#bgt_year").val();
                        mon = $('#bgt_month').val();
                        cc = $('#cc').val();
                        var gl = $('#gl').val();

                        console.log(mon);
                        console.log(gl);
                        console.log(cc);


                        $("#loader").show();
                        $.ajax({
                            url: cc_budget_history,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                mon: mon,
                                gl: gl,
                                cc: cc,
                                year: year

                            },


                            success: function (resp) {

                                console.log(resp);
                                if ((resp.length) < 1) {
                                    $("#loader").hide();
                                    toastr.info('Budget history not available');
                                } else {
                                    console.log('else block accessed');


                                    $("#table_budget_history").DataTable().destroy();

                                    $("#table_budget_history").DataTable({
                                        data: resp,
                                        columns: [
                                            {data: "budget_month"},
                                            {data: "cost_center_id"},
                                            {data: "cost_center_name"},
                                            {
                                                data: "lm_available_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "cur_month_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {data: "comment_text"},
                                            {data: "create_date"},
                                            {data: "create_user"}

                                        ],

                                        rowGroup: {
                                            startRender: null,
                                            endRender: function (rows, group) {

                                                var tgt_total = rows
                                                    .data()
                                                    .pluck('lm_available_amt')
                                                    .reduce(function (a, b) {
                                                        return (parseInt(a) + parseInt(b)).toFixed(2);
                                                    }, 0);


                                                console.log(tgt_total);

                                                var sold_total = rows
                                                    .data()
                                                    .pluck('cur_month_amt')
                                                    .reduce(function (a, b) {
                                                        return (parseInt(a) + parseInt(b)).toFixed(2);
                                                    }, 0);


                                                // console.log(int_total);
                                                if (rows[0].length > 1) {
                                                    // console.log("area");
                                                    return $('<tr>')
                                                        .append('<td colspan="3" style="text-align: center">' + group + ' Total</td>')
                                                        .append('<td style="text-align: left">' + accounting.formatMoney(tgt_total, "") + '</td>')
                                                        .append('<td style="text-align: left">' + accounting.formatMoney(sold_total, "") + '</td>')
                                                        .append('<td style="text-align: left"></td>')
                                                        .append('<td style="text-align: lrft"></td>')
                                                        .append('<td style="text-align: left"></td></tr>');
                                                } else {

                                                    //here main target to give a class for single row ....then it will be display none using css in view
                                                    return $('<tr class="removeGrup">')
                                                        .append('<td colspan="3"></td>')
                                                        .append('<td style="text-align: right"></td>')
                                                        .append('<td style="text-align: right"></td>')
                                                        .append('<td style="text-align: right"></td></tr>');
                                                }


                                            },
                                            dataSrc: 'cost_center_name'
                                        },

                                        language: {
                                            "emptyTable": "No Matching Records Found."
                                        },

                                        info: false,
                                        paging: false,
                                        filter: false,
                                        order: false


                                    });
                                    $("#loader").hide();

                                    $("#div_budget_history").show();
                                }


                            },
                            error: function (err) {
                                // console.log(err);
                                $("#loader").hide();
                                $("#report-body").show();
                            }
                        });

                    }

                });

                $("#btn_display").click(function () {

                    if ($("#bgt_month").val() === "") {
                        alert("Please select Expense Month");
                    } else if ($("#bgt_month").val() === "ALL") {
                        alert("Please select specific Month");
                    } else if ($("#gl").val() === "") {
                        alert("Please select GL");
                    } else if ($("#cc").val() === "") {
                        alert("Please select Cost center");
                    }
                    else if ($("#gl").val() === "ALL") {
                        alert("Please select specific GL");
                    }
                    else if ($("#cc").val() === "ALL") {
                        alert("Please select specific Cost center");
                    } else {

                        $(".add_budget_ammount").hide();
                        $(".save_budget").hide();
                        $("#report-body").hide();


                        mon = $('#bgt_month').val();
                        cc = $('#cc').val();
                        gl = $("#gl").val();

                        console.log(mon);
                        console.log(gl);
                        console.log(cc);


                        $("#loader").show();
                        $.ajax({
                            url: cc_budget_display,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                mon: mon,
                                gl: gl,
                                cc: cc

                            },


                            success: function (resp) {

                                console.log(resp);
                                if ((resp.length) < 1) {
                                    $("#loader").hide();
                                    toastr.info('Budget not available');
                                } else {


                                    $("#budget_table").DataTable().destroy();

                                    table = $("#budget_table").DataTable({
                                        data: resp,
                                        columns: [
                                            {data: "budget_month"},
                                            {data: "gl"},
                                            {data: "cost_center_id"},
                                            {data: "cost_center_description"},
                                            {
                                                data: "lm_available_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "cur_month_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "total_budget",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            }

                                            // {
                                            //     data: "expense_amt",
                                            //     render: $.fn.dataTable.render.number(',', 3)
                                            // }
                                        ],


                                        language: {
                                            "emptyTable": "No Matching Records Found."
                                        },

                                        info: false,
                                        paging: false,
                                        filter: false,


                                    });
                                    $("#loader").hide();

                                    $("#report-body").show();
                                }


                            },
                            error: function (err) {
                                // console.log(err);
                                $("#loader").hide();
                                $("#report-body").show();
                            }
                        });

                    }

                });

                $("#save_budget").click(function () {


                    var add_current_amount = $("#add_current_amount").val();
                    var add_carry_amount = $("#add_carry_amount").val();
                    var comment = $("#comment").val();
                    console.log(add_current_amount);

                    console.log(add_carry_amount);
                    console.log(comment);
                    console.log((parseInt(add_current_amount) + parseInt(add_carry_amount)));


                    if (add_current_amount == '') {
                        toastr.info('Invalid current amount Null');
                    } else if (add_carry_amount == '') {
                        toastr.info('Invalid carry amount Null');
                    } else if (add_current_amount == '0' && add_carry_amount == '0') {
                        toastr.info('Please allocate budget first');
                    } else if (comment == '') {
                        toastr.info('Remarks field is required');
                    } else if (parseInt(add_carry_amount) < 0) {

                        toastr.info('Carry amount can"t be negative');
                    } else if ((parseInt(add_current_amount) + parseInt(add_carry_amount)) == 0) {
                        console.log((parseInt(add_current_amount) + parseInt(add_carry_amount)));
                        toastr.info('Invalid budget amount Zero');
                    } else if ((parseInt(add_current_amount) + parseInt(add_carry_amount)) < 1) {

                        var proposed_negative_amount = parseInt(add_current_amount) + parseInt(add_carry_amount);
                        console.log(proposed_negative_amount);
                        // toastr.info('Negative budget amount');

                        var tblData = table.rows().data()[0];
                        // console.log(tblData);

                        $("#loader").show();
                        $.ajax({
                            url: subtract_budget_calc,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                mon: mon,
                                cc: cc

                            },


                            success: function (resp) {

                                console.log(resp[0]);

                                var subtract_adv_amount = resp[0]['subtract_adv_amount'];
                                var subtract_bill_amount = resp[0]['subtract_bill_amount'];
                                console.log(subtract_adv_amount);
                                console.log(subtract_bill_amount);
                                if ((Math.abs(proposed_negative_amount) <= subtract_adv_amount) && (Math.abs(proposed_negative_amount) <= subtract_bill_amount))
                                {
                                // if (Math.abs(proposed_negative_amount) <= subtract_bill_amount) {
                                    console.log(Math.abs(proposed_negative_amount));
                                    console.log('permissible subtraction');

                                    $.ajax({
                                        method: "post",
                                        url: insert_cc_budget,
                                        data: {
                                            _token: _csrf_token,
                                            insertData: JSON.stringify(tblData),
                                            add_current_amount: add_current_amount,
                                            add_carry_amount: add_carry_amount,
                                            remarks: comment

                                        },
                                        success: function (data) {
                                            $('#save_budget').prop('disabled', true);
                                            console.log(data);
                                            console.log(data.length);
                                            if (data) {
                                                toastr.success('Budget allocated successfully');
                                                updateTable();

                                            }

                                        },
                                        error: function () {
                                            toastr.error(' Failed ');
                                            console.log('fail');
                                        }
                                    });

                                } else {
                                    toastr.info('Subtraction amount exceeds advance amount or bill amount');
                                }

                                $("#loader").hide();

                                $("#report-body").show();


                            },
                            error: function (err) {
                                // console.log(err);
                                $("#loader").hide();
                                $("#report-body").show();
                            }
                        });

                    } else if ((parseInt(add_current_amount) + parseInt(add_carry_amount)) > 1) {

                        console.log('Save button clicked');
                        console.log('Proposed budget ' + (parseInt(add_current_amount) + parseInt(add_carry_amount)));

                        var tblData = table.rows().data()[0];
                        console.log(tblData);

                        $.ajax({
                            method: "post",
                            url: insert_cc_budget,
                            data: {
                                _token: _csrf_token,
                                insertData: JSON.stringify(tblData),
                                add_current_amount: add_current_amount,
                                add_carry_amount: add_carry_amount,
                                remarks: comment

                            },
                            success: function (data) {
                                $('#save_budget').prop('disabled', true);
                                console.log(data);
                                console.log(data.length);
                                if (data) {
                                    toastr.success('Budget allocated successfully');
                                    updateTable();

                                }

                            },
                            error: function () {
                                toastr.error(' Failed ');
                                console.log('fail');
                            }
                        });


                    } else {
                        toastr.info('Allocation exceeds available budget');
                    }

                });


                function updateTable() {


                    $(".add_budget_ammount").hide();
                    $(".save_budget").hide();
                    $("#report-body").hide();


                    // var mon = $('#bgt_month').val();
                    // var cc = $('#cc').val();

                    console.log(mon);
                    console.log(cc);


                    $("#loader").show();
                    $.ajax({
                        url: cc_budget_display,
                        method: "post",
                        dataType: 'json',

                        data: {
                            _token: _csrf_token,
                            mon: mon,
                            gl: gl,
                            cc: cc

                        },


                        success: function (resp) {

                            console.log(resp);
                            if ((resp.length) < 1) {
                                $("#loader").hide();
                                toastr.info('Budget not available');
                            } else {


                                $("#budget_table").DataTable().destroy();

                                table = $("#budget_table").DataTable({
                                    data: resp,
                                    columns: [
                                        {data: "budget_month"},
                                        {data: "gl"},
                                        {data: "cost_center_id"},
                                        {data: "cost_center_description"},
                                        {
                                            data: "lm_available_amt",
                                            render: $.fn.dataTable.render.number(',', 3)
                                        },
                                        {
                                            data: "cur_month_amt",
                                            render: $.fn.dataTable.render.number(',', 3)
                                        },
                                        {
                                            data: "total_budget",
                                            render: $.fn.dataTable.render.number(',', 3)
                                        }

                                        // {
                                        //     data: "expense_amt",
                                        //     render: $.fn.dataTable.render.number(',', 3)
                                        // }
                                    ],


                                    language: {
                                        "emptyTable": "No Matching Records Found."
                                    },

                                    info: false,
                                    paging: false,
                                    filter: false,


                                });
                                $("#loader").hide();

                                $("#report-body").show();
                            }


                        },
                        error: function (err) {
                            // console.log(err);
                            $("#loader").hide();
                            $("#report-body").show();
                        }
                    });


                }


            }
        );


    </script>

@endsection