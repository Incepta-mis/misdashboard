@extends('_layout_shared._master')
@section('title','Cash Process Depot')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

    <form method="post" action="{{url('donation/print_cash_depot')}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                       Cash Process Depot
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">

{{--                                <form action="" class="form-horizontal" role="form">--}}

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($month as $mt)
                                                            <option value="{{$mt->monthname}}">{{$mt->monthname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="depot"
                                                           class="col-md-4 control-label"><b>Depot</b></label>
                                                    <div class="col-md-8">
                                                        <select name="depot" id="depot"
                                                                class="form-control input-sm">
{{--                                                            <option value="">Select</option>--}}
                                                            @foreach($depot as $mt)
                                                                <option value="{{$mt->depot_id}}">{{$mt->depot_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rm"
                                                       class="col-md-4 control-label"><b>RM Terr</b></label>
                                                <div class="col-md-8">
                                                    <select name="rm" id="rm"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-1">
                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>
                                        </div>


                                    </div>

                                <div class="row" style="display:none">

                                    <div class="col-md-1">
                                        <button type="button" id="btn_seocnd" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i><b> RePrint</b></button>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bgt_month_seond"
                                                   class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                            <div class="col-md-8">
                                                <select name="bgt_month_seond" id="bgt_month_seond"
                                                        class="form-control input-sm">
                                                    <option value="">Select</option>
                                                    @foreach($month_second as $mt)
                                                        <option value="{{$mt->monthname}}">{{$mt->monthname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

{{--                                    <div class="col-md-3">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="depot"--}}
{{--                                                   class="col-md-4 control-label"><b>Depot</b></label>--}}
{{--                                            <div class="col-md-8">--}}
{{--                                                <select name="depot" id="depot"--}}
{{--                                                        class="form-control input-sm">--}}
{{--                                                    --}}{{--                                                            <option value="">Select</option>--}}
{{--                                                    @foreach($depot as $mt)--}}
{{--                                                        <option value="{{$mt->depot_id}}">{{$mt->depot_name}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rm"
                                                   class="col-md-4 control-label"><b>RM Terr</b></label>
                                            <div class="col-md-8">
                                                <select name="rm_second" id="rm_second"
                                                        class="form-control input-sm">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3" id="print_summary" style="">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="submit" id="print_button_second" class="btn btn-default btn-sm" formaction="{{url('donation/print_summary_super')}}" >
                                                <i class="fa fa-check"></i> <b>Print</b></button>
                                        </div>
                                    </div>

                                </div>



{{--                                </form>--}}
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


    <div class="row" id="sum_portion" style="display:none ;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body" >
                        <div class="table-responsive">
                            <table id="cash_sum_table" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>

                                    <th>Month</th>
                                    <th>Depot</th>
                                    <th>RM</th>
                                    <th>Total Request</th>
                                    <th>Total Amount</th>
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

    <div class="col-md-2" id="process" style="display:none; margin-bottom: 7px;" >
        <button type="button" id="process_button" class="btn btn-default btn-sm">
            <i class="fa fa-check"></i> <b>Process</b></button>
    </div>

        <div class="col-md-3" id="print_advice" style="display: none; ">
            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                <button type="submit" id="print_button" class="btn btn-default btn-sm">
                    <i class="fa fa-check"></i> <b>Print </b></button>
            </div>
        </div>

    <div class="row" id="detail_table" style="display:none ;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body" >
                        <div class="table-responsive">
                            <table id="detail_cash_table" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>

                                    <th>Month</th>
                                    <th>summ id</th>
                                    <th>ref no</th>
                                    <th>fi_doc_no</th>
                                    <th>depot</th>
                                    <th>req_id</th>
                                    <th>terr_id</th>
{{--                                    <th>doctor_name</th>--}}
                                    <th>in_favour_of</th>
                                    <th>rm</th>
                                    <th>rm_assigned_person</th>
                                    <th>amount</th>

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
    </form>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{-- Added for selecting all on click--}}

{{--    {{Html::script('public/site_resource/dist/slimselect.min.js')}}--}}

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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}



    <script type="text/javascript">
        $(document).ready(function () {

            $('#print_button').attr('formtarget', '_blank');
            $('#print_button_second').attr('formtarget', '_blank');

            cash_summary_detail_data = "{{url('donation/cash_process_depot_data')}}";
            fi_doc_list = "{{url('donation/rm_list')}}";
            depot_list = "{{url('donation/depot_list')}}";
            var insert_row = "{{url('donation/cash_process_depot_update')}}";


                _csrf_token = '{{csrf_token()}}';
                var table,table2;
            log_desig = '{{Auth::user()->desig}}';
            var verifydata = [];


            $("#bgt_month").on('change', function () {
                console.log('working properly');

                $('#rm').empty();

                var month = $("#bgt_month").val();
                var depot = $("#depot").val();

                console.log(month);

                $("#rm").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: fi_doc_list,
                    dataType: 'json',
                    data: {
                        _token: _csrf_token,
                        month: month,
                        depot: depot
            },
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        // selOptsMPO += "<option value=''>Select</option>";
                        // selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['rm_terr_id'];
                            var val = response[j]['rm_terr_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#rm').empty().append(selOptsMPO);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            });


            $("#btn_display").click(function () {

                 if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }
                else if ($("#rm").val() === "") {
                    alert("Please RM");
                }
                else if ($("#depot").val() === "") {
                    alert("Please select depot");
                }

                else {

                     $("#process_button").prop("disabled",false);

                    console.log(log_desig);
                     var month = $("#bgt_month").val();
                     var rm = $('#rm').val();
                     var depot = $('#depot').val();
                     // console.log(region);

                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: cash_summary_detail_data,
                        data: {
                            month: month,
                            rm_terr: rm,
                            depot: depot,
                            _token: _csrf_token
                        },
                        success: function (data) {
                            console.log(data);

                            $('#cash_sum_table').DataTable().destroy();


                            table = $('#cash_sum_table').DataTable({
                                 data: data['dis_sum'],

                                columns: [
                                    {data: "payment_month"},
                                    {data: "d_name"},
                                    {data: "rm_terr_id"},
                                    {data: "total_req"},
                                    {data: "total_amount"}
                                ],
                                ordering:false,
                                paging:false,
                                // filtering:false,
                                info:false,
                                searching:false,
                                // fixedHeader: true,
                                // "scrollY": "450px",
                                // "scrollX": true,
                                // "scrollCollapse": true
                            });
                            // $("#loader").hide();


                            // table.columns.adjust();

                            $("#detail_cash_table").DataTable().destroy();
                            table2 = $("#detail_cash_table").DataTable({
                                data: data['resp_data'],
                                columns: [

                                    {data: "payment_month"},
                                    {data: "summ_id"},
                                    {data: "ref_no"},
                                    {data: "fi_doc_no"},
                                    {data: "depot"},
                                    {data: "req_id"},
                                    {data: "terr_id"},
                                    // {data: "doctor_name"},
                                    {data: "in_favour_of"},
                                    {data: "rm_asm"},
                                    {data: "rm_assigned_person"},
                                    {data: "donation_amount"}
                                    // {data: "purpose"},

                                ],

                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },

                                info: false,
                                paging: false,
                                filter: false,
                                "scrollY": "450px",
                                "scrollX": true,
                                // "scrollCollapse": true,



                            });
                            $("#loader").hide();
                            $("#sum_portion").show();
                            $("#detail_table").show();
                            $("#process").show();
                            $("#print_advice").show();
                            table2.columns.adjust();


                        },
                        error: function () {
                            $("#loader").hide();
                            console.log('fail');
                        }

                    });

                }

            });

            $("#process_button").click(function () {

                $("#process_button").prop("disabled",true);

                var tablength = table2.rows().count();
                console.log(tablength);
                var tblData = table2.rows().data();
                var insertdata = [];
                var tmpData = new Array();

                for (i = 0; i < tablength ; i++) {

                     var tablerows = tblData[i];
                    // console.log(tablerows.req_id);

                    tmpData[i] = {
                        "month": tablerows.payment_month,
                        "request_id": tablerows.req_id
                    }
                    insertdata.push(tmpData[i]);
                    // console.log(tmpData[i]);
                }

                console.log(insertdata);

                if (insertdata.length !== 0) {

                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            insertdata: JSON.stringify(insertdata),
                            _token: _csrf_token
                        },
                        url: insert_row,
                        beforeSend: function () {
                            // Show image container
                            // $("#balance_section").hide();
                            // $("#report-body").hide();
                            $("#loader").show();
                        },
                        success: function (data) {

                            // $("table tbody tr").remove();

                            console.log("data " + data);
                            if (data.error) {
                                toastr.error(data.error, '', {timeOut: 5000});
                            } else if (data.success) {
                                toastr.success(data.success, '', {timeOut: 5000});
                            }

                            $("#loader").hide();

                            // setTimeout(function(){// wait for 3 secs
                            //     window.location.reload(); // then reload the page
                            // }, 3000);

                        },
                        complete: function (data) {
                            // Hide image container
                            $("#loader").hide();

                        },
                        error: function (err) {
                            console.log(err);
                            $("#loader").hide();
                        }
                    });
                }

            });

            $(".toggle-btn").click(function () {
                table2.columns.adjust();
            });


            }
        );



    </script>

@endsection