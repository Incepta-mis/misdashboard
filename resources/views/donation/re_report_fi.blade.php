@extends('_layout_shared._master')
@section('title','RE Report for FI')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
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
    <form>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                          Research Expense Report
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">



                                    <div class="row">

                                        <label for="bgt_year"
                                               class="col-md-1 control-label"><b>Year</b></label>

                                    <div class="col-md-2">
                                                    <select name="bgt_year" id="bgt_year"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($year as $mn)
                                        <option value="{{$mn->year}}">{{$mn->year}}</option>
                                                        @endforeach
                                            </select>
                                        </div>

                                        <label for="bgt_month"
                                               class="col-md-1 control-label"><b>Month</b></label>

                                    <div class="col-md-2">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="ALL">ALL</option>
                                                        {{--<option value="">Select</option>--}}
                                                        {{--@foreach($month_name as $mn)--}}
                                        {{--<option value="{{$mn->monthname}}">{{$mn->monthname}}</option>--}}
                                                        {{--@endforeach--}}
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="gl"
                                                       class="col-md-3 col-sm-6 control-label"><b>GL</b></label>
                                                <div class="col-md-9">
                                                    <select name="gl" id="gl"
                                                            class="form-control input-sm">

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

                                                <option value="ALL">ALL</option>
@foreach($cc as $ccn)
                                                            <option value="{{$ccn->cost_center_id}}">
                                                                {{$ccn->cost_center_description}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="row">

                                        <label for="summ"
                                               class="col-md-1 control-label"><b>Sum ID</b></label>

                                        <div class="col-md-2">
                                            <select name="summ" id="summ"
                                                    class="form-control input-sm">
                                                <option value="ALL">ALL</option>
                                                {{--<option value="">Select</option>--}}
                                                {{--@foreach($year as $mn)--}}
                                                    {{--<option value="{{$mn->year}}">{{$mn->year}}</option>--}}
                                                {{--@endforeach--}}
                                            </select>
                                        </div>

                                        <label for="doc"
                                               class="col-md-1 control-label"><b>Doc ID</b></label>

                                        <div class="col-md-2">
                                            <select name="doc" id="doc"
                                                    class="form-control input-sm">
                                                <option value="ALL">ALL</option>
                                                {{--<option value="">Select</option>--}}
                                                {{--@foreach($month_name as $mn)--}}
                                                {{--<option value="{{$mn->monthname}}">{{$mn->monthname}}</option>--}}
                                                {{--@endforeach--}}
                                            </select>
                                        </div>



                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="ct"
                                                       class="col-md-4 col-sm-6 control-label"><b>Category</b></label>
                                                <div class="col-md-8">
                                                    <select name="ct" id="ct"
                                                            class="form-control input-sm">

                                                        <option value="ALL">ALL</option>

                                                            <option value="CASH">CASH</option>
                                                        <option value="CHEQUE">CHEQUE</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-1">

                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>

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
                                        {{--<th>Expense Month</th>--}}
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>GL</th>
                                        <th>Cost Center</th>
                                        <th>Sum Id</th>
                                        <th>FI Doc No</th>
                                        <th>Pay Mode</th>
                                        <th>Amount</th>
                                        <th>Fid Post Date</th>

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
                &nbsp;
            </div>


        </div>


    </form>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
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

        subtract_budget_calc = "{{url('donation/subtract_budget_calc')}}";
        re_year = "{{url('donation/re_year')}}";
        re_month = "{{url('donation/re_month')}}";
        re_cc = "{{url('donation/re_cc')}}";
        re_sum = "{{url('donation/re_sum')}}";
        re_report_data = "{{url('donation/re_report_data')}}";
        cc_don = "{{url('donation/cc_don_sum')}}";
        _csrf_token = '{{csrf_token()}}';
        var table;

        $(document).ready(function () {


            $('#bgt_year').on('change',function(){

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


            $('#bgt_month').on('change',function(){

                var year = $('#bgt_year').val();
                var month = $("#bgt_month").val();

                $("#cc").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    method: "post",
                    url: re_month,
                    data: {
                        _token: _csrf_token,
                        year: year,
                        month: month
                    },
                    success: function (data) {
                        console.log(data);
                        // console.log(data.length);
                        if ((data.length) > 0) {
                            var op = '';

                            op += "<option value='ALL'>ALL</option>";

                            for (var i = 0; i < data.length; i++) {
                                op += '<option value= " ' + data[i]['cost_center_id'] + ' " >' + data [i]['cost_center_id'] + '</option>';
                            }
                            $('#cc').html(" ");
                            $('#cc').append(op);
                        }

                    },
                    error: function () {
                        console.log('fail');
                    }
                });

            });

            $("#gl").on('change',function(){
                console.log('working properly');

                $('#cc').empty();

                var gl = $("#gl").val();

                console.log(gl);
                if (gl =='ALL'){
                    $("#cc").empty().append("<option value='ALL'>ALL</option>");
                }
                else{

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

                }

            });

            $('#cc').on('change',function(){

                var year = $('#bgt_year').val();
                var month = $("#bgt_month").val();
                var cc = $('#cc').val();

                $("#summ").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    method: "post",
                    url: re_cc,
                    data: {
                        _token: _csrf_token,
                        year: year,
                        month: month,
                        cc: cc
                    },
                    success: function (data) {
                        console.log(data);
                        // console.log(data.length);
                        if ((data.length) > 0) {
                            var op = '';

                            op += "<option value='ALL'>ALL</option>";

                            for (var i = 0; i < data.length; i++) {
                                op += '<option value= " ' + data[i]['summ_id'] + ' " >' + data [i]['summ_id'] + '</option>';
                            }
                            $('#summ').html(" ");
                            $('#summ').append(op);
                        }

                    },
                    error: function () {
                        console.log('fail');
                    }
                });

            });

            $('#summ').on('change',function(){

                var year = $('#bgt_year').val();
                var month = $("#bgt_month").val();
                var cc = $('#cc').val();
                var sum = $("#summ").val();

                $("#doc").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    method: "post",
                    url: re_sum,
                    data: {
                        _token: _csrf_token,
                        year: year,
                        month: month,
                        cc: cc,
                        sum: sum
                    },
                    success: function (data) {
                        console.log(data);
                        // console.log(data.length);
                        if ((data.length) > 0) {
                            var op = '';

                            op += "<option value='ALL'>ALL</option>";

                            for (var i = 0; i < data.length; i++) {
                                op += '<option value= " ' + data[i]['fi_doc_no'] + ' " >' + data [i]['fi_doc_no'] + '</option>';
                            }
                            $('#doc').html(" ");
                            $('#doc').append(op);
                        }

                    },
                    error: function () {
                        console.log('fail');
                    }
                });


            });


                $("#btn_display").click(function () {


                    if ($("#bgt_year").val() === "") {
                        alert("Please select Expense Year");
                    }
                    else if ($("#bgt_month").val() === "") {
                        alert("Please select Expense Month");
                    }
                    else if ($("#gl").val() === "") {
                        alert("Please select GL");
                    }
                    else if ($("#cc").val() === "") {
                        alert("Please select Cost center");
                    }

                    else {

                        $(".add_budget_ammount").hide();
                        $(".save_budget").hide();
                        $("#report-body").hide();


                      var year = $("#bgt_year").val();
                        var month = $("#bgt_month").val();
                        var gl = $("#gl").val();
                        var cc = $('#cc').val();

                        var sum = $("#summ").val();
                        var fidoc = $("#doc").val();
                        var ct = $('#ct').val();

                        console.log(year);
                        console.log(month);
                        console.log(cc);

                        console.log(sum);
                        console.log(fidoc);
                        console.log(ct);

                        $("#loader").show();

                        $.ajax({
                            url: re_report_data,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                year: year,
                                month: month,
                                gl:gl,
                                cc: cc,
                                sum: sum,
                                fidoc: fidoc,
                                ct: ct

                            },


                            success: function (resp) {

                                console.log(resp);
                                if ((resp.length) < 1) {
                                    $("#loader").hide();
                                    toastr.info('Expense not available in this criteria');
                                }
                                else {

                                    $("#budget_table").DataTable().destroy();

                                    table = $("#budget_table").DataTable({
                                        data: resp,
                                        dom: '<"toolbar">Bfrtip',
                                        buttons: [

                                            {
                                                extend: 'excelHtml5', className: "btn-warning",
                                                exportOptions: {
                                                    columns: [0,1,2, 3, 4, 5, 6, 7,8]
                                                }
                                            }
                                        ],
                                        columns: [

                                            {data: "re_year"},
                                            {data: "payment_month"},
                                            {data: "gl"},
                                            {data: "cost_center_id"},
                                            {data: "summ_id"},
                                            {data: "fi_doc_no"},
                                            {data: "payment_mode"},
                                            {
                                                data: "amount",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {data: "date_of_fid_post"},
                                        ],
                                        order: [[2, 'asc'],[3, 'asc']],

                                        rowGroup: {
                                            startRender: null,
                                            endRender: function (rows, group) {

                                                var tgt_total = rows
                                                    .data()
                                                    .pluck('amount')
                                                    .reduce(function (a, b) {
                                                        return (parseInt(a) + parseInt(b)).toFixed(2);
                                                    }, 0);

                                                console.log(tgt_total);

                                                // console.log(int_total);
                                                if (rows[0].length > 1) {
                                                    // console.log("area");
                                                    return $('<tr>')
                                                        .append('<td colspan="7" style="text-align: center">' + group + ' Total</td>')
                                                        .append('<td style="text-align: left">' + accounting.formatMoney(tgt_total, "") + '</td>')
                                                        .append('<td style="text-align: left"></td></tr>');
                                                } else {

                                                    //here main target to give a class for single row ....then it will be display none using css in view
                                                    return $('<tr class="removeGrup">')
                                                        .append('<td colspan="7"></td>')
                                                        .append('<td style="text-align: right"></td>')
                                                        .append('<td style="text-align: right"></td></tr>');
                                                }


                                            },
                                            dataSrc: 'cost_center_id'
                                        },

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


            }
        );


    </script>

@endsection