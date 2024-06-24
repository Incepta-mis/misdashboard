@extends('_layout_shared._master')
@section('title','SSD Expense Calculation')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
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
                        SSD Expense Calculation
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

                                    <div class="row">

{{--                                        <div class="col-md-3">--}}
{{--                                            <d+
iv class="form-group">--}}
{{--                                                <label for="bgt_year"--}}
{{--                                                       class="col-md-4 control-label"><b>Year</b></label>--}}
{{--                                                <div class="col-md-8">--}}
{{--                                                    <select name="bgt_year" id="bgt_year"--}}
{{--                                                            class="form-control input-sm">--}}
{{--                                                        <option value="">Select</option>--}}
{{--                                                        @foreach($year as $mn)--}}
{{--                                                            <option value="{{$mn->year}}">{{$mn->year}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>From</b></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control input-sm" name="bgt_month"
                                                           style="padding-right: 0px;" id="bgt_month" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bgt_month_to"
                                                       class="col-md-4 col-sm-6 control-label"><b> To</b></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control input-sm"
                                                           style=""
                                                           name="bgt_month_to" id="bgt_month_to" autocomplete="off">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="gl"
                                                       class="col-md-4 control-label"><b>GL</b></label>
                                                <div class="col-md-8">
                                                    <select name="gl" id="gl"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
{{--                                                        <option value="ALL">ALL</option>--}}
                                                        @foreach($gl as $gl)
                                                            <option value="{{$gl->gl}}">{{$gl->gl}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
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

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ben_type"
                                                       class="col-md-4 control-label"><b>BT</b></label>
                                                <div class="col-md-8">
                                                    <select name="ben_type" id="ben_type"
                                                            class="form-control input-sm">
{{--                                                        <option value="">Select Beneficiary</option>--}}
                                                        <option value="ALL">ALL</option>
                                                        @foreach($dbt as $db)
                                                            <option value="{{$db->dbt_description}}">{{$db->dbt_description}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>




                                    </div>

                                    <div class="row">

{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="don_type"--}}
{{--                                                       class="col-md-4 control-label"><b>DT</b></label>--}}
{{--                                                <div class="col-md-8">--}}
{{--                                                    <select name="don_type" id="don_type"--}}
{{--                                                            class="form-control input-sm">--}}
{{--                                                        <option value="">Select Expense Type</option>--}}
{{--                                                        <option value="ALL">ALL</option>--}}
{{--                                                        @foreach($dtm as $tm)--}}
{{--                                                            <option value="{{$tm->type_name}}"--}}
{{--                                                                    data-tpn="{{$tm->main_cost_center_name}}">{{$tm->type_name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}




                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dsm"
                                                       class="col-md-4 control-label"><b>DSM</b></label>
                                                <div class="col-md-8">
                                                    <select name="dsm" id="dsm"
                                                            class="form-control input-sm">
                                                        <option value="ALL">ALL</option>
                                                        <option value="Verified">Verified</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="sm"
                                                       class="col-md-4 control-label"><b>SM</b></label>
                                                <div class="col-md-8">
                                                    <select name="sm" id="sm"
                                                            class="form-control input-sm">
                                                        <option value="ALL">ALL</option>
                                                        <option value="Verified">Verified</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rm_terr"
                                                       class="col-md-4 col-sm-6 control-label"><b>RM
                                                    </b></label>
                                                <div class="col-md-8">
                                                    <select name="rm_terr" id="rm_terr"
                                                            class="form-control input-sm">
                                                        <option value="ALL">ALL</option>
                                                        @foreach($rm_terr as $terr)
                                                            <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="gm_sales"
                                                       class="col-md-4 control-label"><b>GM Sale</b></label>
                                                <div class="col-md-8">
                                                    <select name="gm_sales" id="gm_sales"
                                                            class="form-control input-sm">
                                                        <option value="ALL">ALL</option>
                                                        <option value="Verified">Verified</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="gm_msd"
                                                       class="col-md-4 control-label"><b>GM MSD</b></label>
                                                <div class="col-md-8">
                                                    <select name="gm_msd" id="gm_msd"
                                                            class="form-control input-sm">
                                                        <option value="ALL">ALL</option>
                                                        <option value="Verified">Verified</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-1">

                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>

                                        </div>

                                    </div>

                                    <div class="row">


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apt"
                                                       class="col-md-4 control-label"><b>Approved Amount</b></label>
                                                <div class="col-md-8">
                                                    <input  id="apt"  readonly>
{{--                                                    <select name="apt" id="apt">--}}
{{--                                                    </select>--}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bgt"
                                                       class="col-md-4 control-label"><b>Budget Amount</b></label>
                                                <div class="col-md-8">
                                                    <input  id="bgt"  readonly>
                                                    {{--                                                    <select name="apt" id="apt">--}}
                                                    {{--                                                    </select>--}}
                                                </div>
                                            </div>
                                        </div>

{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="sm"--}}
{{--                                                       class="col-md-4 control-label"><b>SM</b></label>--}}
{{--                                                <div class="col-md-8">--}}
{{--                                                    <select name="sm" id="sm"--}}
{{--                                                            class="form-control input-sm">--}}
{{--                                                        <option value="ALL">ALL</option>--}}
{{--                                                        <option value="Verified">Verified</option>--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}


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
                <section class ="panel" id="data_table">
                    <div class = "panel-body">
                        <div class="table-responsive">
                            <table id="req_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr style="border: 1px solid #000000;text-align: center;">
                                    <th>REQ_ID</th>
                                    <th>TERR_ID</th>
                                    <th>RM_TERR_ID</th>
                                    <th>D_NAME</th>
                                    <th>DONATION_TYPE</th>
                                    <th>GL</th>
                                    <th>COST_CENTER_ID</th>
                                    <th>SUB_COST_CENTER_ID</th>
                                    <th>SUB_COST_CENTER_NAME</th>
                                    <th>BENEFICIARY_TYPE</th>
                                    <th>BEN_ID</th>
                                    <th>BEN_NAME</th>
                                    <th>INFAVOR</th>
                                    <th>PAYMENT_MONTH</th>
                                    <th>APPROVED_AMOUNT</th>
                                    <th>DSM_EMP_ID</th>
                                    <th>DSM_NAME</th>
                                    <th>DSM_CHECKED_DATE</th>
                                    <th>SM_EMP_ID</th>
                                    <th>SM_NAME</th>
                                    <th>SM_CHECKED_DATE</th>
                                    <th>GM_SALES_EMP_ID</th>
                                    <th>GM_SALES_EMP_NAME</th>
                                    <th>GM_SALES_CHECKED_DATE</th>
                                    <th>GM_MSD_EMP_ID</th>
                                    <th>GM_MSD_EMP_NAME</th>
                                    <th>GM_MSD_CHECKED_DATE</th>
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

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}


    <script type="text/javascript">
        $(document).ready(function () {

            $('#bgt_month').datepicker({
                format: "dd-M-yy",
                todayHighlight: 'TRUE',
                autoclose: true,
                startView: "months",
                minViewMode: "months",
                minDate: 0,
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {
                $('#bgt_month_to').datepicker('setStartDate', $("#bgt_month").val());
            });

            $('#bgt_month_to').datepicker({
                format: "dd-M-yy",
                todayHighlight: 'TRUE',
                autoclose: true,
                startView: "months",
                minViewMode: "months",
                minDate: '0',
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {

                var d1 = $('#bgt_month').datepicker('getDate');
                var d2 = $('#bgt_month_to').datepicker('getDate');
                var diff = 0;
                if (d1 && d2) {
                    diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                }
                $('#dol').val(diff);
            });

                re_year = "{{url('scientific/sci_year')}}";
                tbedata_display = "{{url('donation/ssd_expense_data')}}";

                cc_don = "{{url('donation/don_cc')}}";
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

            $("#btn_display").click(function () {

                // if ($("#bgt_year").val() === "") {
                //     alert("Please select Program Year");
                // }

                    if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }
                    else if ($("#bgt_month_to").val() === "") {
                        alert("Please select Month");
                    }
                else if ($("#gl").val() === "") {
                    alert("Please select GL");
                } else if ($("#cc").val() === "") {
                    alert("Please select Cost center");
                }
                else if ($("#ben_type").val() === "") {
                    toastr.info("Please select Beneficiary type");
                }

                else if ($("#dsm").val() === "") {
                    toastr.info("Please select checked date");
                }
                    else if ($("#sm").val() === "") {
                        toastr.info("Please select checked date");
                    }

                else {
                    // var year = $("#bgt_year").val();
                    var month = $("#bgt_month").val();
                        var month_to = $("#bgt_month_to").val();
                    var cc = $('#cc').val();
                    var gl = $('#gl').val();
                    // var don_type=$("#don_type").val();
                    var beneficiary=$("#ben_type").val();
                    var dsm =$("#dsm").val();
                    var sm =$("#sm").val();
                        let gmsales =$("#gm_sales").val();
                        let gmmsd =$("#gm_msd").val();
                        let region = $("#rm_terr").val();

                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: tbedata_display,
                        data: {
                            // year: year,
                            month: month,
                            month_to:month_to,
                            gl: gl,
                            cc: cc,
                            // don_type: don_type,
                            beneficiary:beneficiary,
                            dsm:dsm,
                            sm:sm,
                            gm_sales:gmsales,
                            gm_msd: gmmsd,
                            region:region,
                            _token: _csrf_token,

                        },
                        success: function (data) {
                            console.log(data['resp']);
                            let n= data['sum'][0]['apt_amount'];
                            let nf = new Intl.NumberFormat('en-US');
                            let bt = data['budget'][0]['bud_amount'];
                            $('#apt').val(nf.format(n));
                            $('#bgt').val(nf.format(bt));

                        // let  selOptsMPO = "<option value='" + data['sum'][0]['apt_amount'] + "'>" + data['sum'][0]['apt_amount'] + "</option>";
                        // $('#apt').empty().append(selOptsMPO);


                            $('#req_list').DataTable().destroy();

                            let table = $('#req_list').DataTable({
                                data: data['resp'],
                                  dom: 'Bfrtip',

                                buttons: [

                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26]
                                        }
                                    }

                                ],



                                columns: [
                                    {data: "req_id"},
                                    {data: "terr_id"},
                                    {data: "rm_terr_id"},
                                    {data: "d_name"},
                                    {data: "donation_type"},
                                    {data: "gl"},
                                    {data: "cost_center_id"},
                                    {data: "sub_cost_center_id"},
                                    {data: "sub_cost_center_name"},
                                    {data: "beneficiary_type"},
                                    {data: "doctor_id"},
                                    {data: "doctor_name"},
                                    {data: "in_favour_of"},
                                    {data: "payment_month"},
                                    {
                                        data: "approved_amount",
                                        render: $.fn.dataTable.render.number(',', 3)
                                    },
                                    {data: "dsm_emp_id"},
                                    {data: "dsm_name"},
                                    {data: "dsm_checked_date"},
                                    {data: "sm_emp_id"},
                                    {data: "sm_name"},
                                    {data: "sm_checked_date"},
                                    {data: "gm_sales_emp_id"},
                                    {data: "gm_sales_emp_name"},
                                    {data: "gm_sales_checked_date"},
                                    {data: "gm_msd_emp_id"},
                                    {data: "gm_msd_emp_name"},
                                    {data: "gm_msd_checked_date"}

                                ],
                                // ordering:false,
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