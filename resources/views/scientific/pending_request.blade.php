@extends('_layout_shared._master')
@section('title','Approval Status')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>


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
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Approval Status
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bgt_year"
                                                       class="col-md-6 control-label"><b>Year</b></label>
                                                <div class="col-md-6">
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

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        <option value="ALL">ALL</option>
                                                        {{--                                                            @foreach($month_name as $mn)--}}
                                                        {{--                                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>--}}
                                                        {{--                                                            @endforeach--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gl"
                                                       class="col-md-3 col-sm-6 control-label"><b>RM</b></label>
                                                <div class="col-md-9">
                                                    <select name="rm_terr" id="rm_terr"
                                                            class="form-control input-sm">
                                                        <option value="">Select Territory</option>
                                                        <option value="ALL">ALL</option>
                                                        @foreach($rm_terr as $terr)
                                                            <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bgt_year"
                                                       class="col-md-6 control-label"><b>Proposal NO</b></label>
                                                <div class="col-md-6">
                                                    <select name="proposal_no" id="proposal_no"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        <option value="ALL">ALL</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Bill No.</b></label>
                                                <div class="col-md-8">
                                                    <select name="bill_no" id="bill_no"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        <option value="ALL">ALL</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1">

                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>

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
    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
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
                            <table id="req_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Prog No</th>
                                    <th>Bill No </th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Team</th>
                                    <th>Program Type</th>

                                    <th>Advance Amount</th>
                                    <th>Actual Expense</th>
                                    <th>Prog Date</th>
                                    <th>RM Terr</th>
                                    <th>AM Terr</th>
                                    <th>MPO Terr</th>
                                    <th>Depot id</th>
                                    <th>Depot Name</th>
                                    <th>rm_check</th>
                                    <th>dsm_check</th>
                                    <th>ms_check</th>
                                    <th>msd_manager_check</th>
                                    <th>group_head_check</th>
                                    <th>gm_sales_check</th>
                                    <th>gm_msd_check</th>
                                    <th>ssd_check</th>

                                    <th>voucher_no</th>
                                    <th>voucher_date</th>

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
    </div>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}
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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    <script type="text/javascript">
        $(document).ready(function () {

            re_year = "{{url('scientific/sci_year')}}";
            cc_budget_display = "{{url('scientific/cc_budget_display')}}";
            proposal_and_bill = "{{url('scientific/proposal_and_bill')}}";
            _csrf_token = '{{csrf_token()}}';
            var table;


            $('#bgt_year').on('change', function () {
                console.log('changed');

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

                            op += "<option value=''>Select</option>";
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

            $("#bgt_month").on('change', function () {
                console.log('working properly');

                if ( ($("#bgt_year").val() !== "") && ($("#bgt_month").val() !== "") && ($("#rm_terr").val() !== "" )) {

                    var year = $("#bgt_year").val();
                    var month = $("#bgt_month").val();
                    var rm_terr = $("#rm_terr").val();


                    $("#proposal_no").empty().append("<option value='loader'>Loading...</option>");
                    $("#bill_no").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        type: "GET",
                        url: proposal_and_bill,
                        dataType: 'json',
                        data: {
                            year: year,
                            month: month,
                            rm_terr: rm_terr
                        },
                        success: function (response) {
                            console.log(response);
                            var proposal = response.proposal;
                            var bill = response.bill;

                            var selOptsMPO = "";
                            selOptsMPO += "<option value='ALL'>ALL</option>";
                            for (var j = 0; j < proposal.length; j++) {
                                var id = proposal[j]['prog_no'];
                                var val = proposal[j]['prog_no'];
                                selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                            }

                            $('#proposal_no').empty().append(selOptsMPO);

                            var selOptsBill = "";
                            selOptsBill += "<option value='ALL'>ALL</option>";
                            for (var j = 0; j < bill.length; j++) {
                                var id = bill[j]['bill_no'];
                                var val = bill[j]['bill_no'];
                                selOptsBill += "<option value='" + id + "'>" + val + "</option>";
                            }

                            $('#bill_no').empty().append(selOptsBill);


                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }

            });

            $("#rm_terr").on('change', function () {
                console.log('working properly');

                if ($("#bgt_year").val() === "") {
                    alert("Please select Program Year");
                } else if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }
                else{


                var year = $("#bgt_year").val();
                var month = $("#bgt_month").val();
                var rm_terr = $("#rm_terr").val();


                $("#proposal_no").empty().append("<option value='loader'>Loading...</option>");
                $("#bill_no").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "GET",
                    url: proposal_and_bill,
                    dataType: 'json',
                    data: {
                        year: year,
                        month: month,
                        rm_terr: rm_terr
                    },
                    success: function (response) {
                        console.log(response);
                        var proposal = response.proposal;
                        var bill = response.bill;

                        var selOptsMPO = "";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < proposal.length; j++) {
                            var id = proposal[j]['prog_no'];
                            var val = proposal[j]['prog_no'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('#proposal_no').empty().append(selOptsMPO);

                        var selOptsBill = "";
                        selOptsBill += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < bill.length; j++) {
                            var id = bill[j]['bill_no'];
                            var val = bill[j]['bill_no'];
                            selOptsBill += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('#bill_no').empty().append(selOptsBill);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            });

            $("#btn_display").click(function () {

                if ($("#bgt_year").val() === "") {
                    alert("Please select Program Year");
                }
                else if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }
                else if ($("#rm_terr").val() === "") {
                    alert("Please select RM Terr");
                }
                else if ($("#proposal_no").val() === "") {
                    alert("Please select Proposal No");
                }
                else if ($("#bill_no").val() === "") {
                    alert("Please select Bill No.");
                }
                else {
                var year = $("#bgt_year").val();
                var month = $("#bgt_month").val();
                var rm_terr = $("#rm_terr").val();
                var prop = $("#proposal_no").val();
                var bill = $("#bill_no").val();

                $("#loader").show();
                $.ajax({
                    method: 'post',
                    url: '{{url('scientific/pending_request_data')}}',
                    data: {
                        year: year,
                        month: month,
                        rm_terr: rm_terr,
                        proposal: prop,
                        bill: bill,
                        _token: _csrf_token,

                    },
                    success: function (data) {
                        console.log(data);

                        $('#req_list').DataTable().destroy();

                        var table = $('#req_list').DataTable({
                            data: data,
                            //   dom: 'Bfrtip',
                            //
                            // buttons: [
                            //
                            //     {
                            //         extend: 'excelHtml5', className: "btn-warning",
                            //         exportOptions: {
                            //             // columns: [0, 1, 2, 3, 4, 5]
                            //         }
                            //     }
                            //
                            // ],

                            columns: [
                                {data: "prog_no"},
                                {data: "bill_no"},
                                {data: "program_year"},
                                {data: "program_month"},
                                {data: "prog_team"},
                                {data: "program_type"},

                                {data: "advance_budget"},
                                {data: "actual_expenditure"},
                                {data: "prog_date_time"},
                                {data: "rm_terr_id"},
                                {data: "am_terr_id"},
                                {data: "mpo_terr_id"},
                                {data: "depot_id"},
                                {data: "depot_name"},
                                {data: "rm_checked_date"},
                                {data: "dsm_checked_date"},
                                {data: "ms_checked_date"},
                                {data: "msd_manager_checked_date"},
                                {data: "group_head_checked_date"},
                                {data: "gm_sales_checked_date"},
                                {data: "gm_msd_checked_date"},
                                {data: "ssd_checked_date"},
                                {data: "voucher_no"},
                                {data: "voucher_date"}
                            ],
                            scrollY:        "300px",
                            scrollX:        true,
                            scrollCollapse: true,
                            // paging:         false,
                            fixedColumns:   {
                                leftColumns: 2,
                                // rightColumns: 2

                            },
                            // paging:false,
                            // filtering:false,
                            // info:false,
                            // searching:false,
                            // fixedHeader: true,
                            // "scrollY": "450px",
                            // "scrollX": true,
                            // "scrollCollapse": true
                        });
                        $("#loader").hide();

                        $("#report-body").show();
                        table.columns.adjust();
                    },
                    error: function () {
                        $("#loader").hide();
                        console.log('fail');
                    }

                });

            }

                });



            }
        );



    </script>

@endsection