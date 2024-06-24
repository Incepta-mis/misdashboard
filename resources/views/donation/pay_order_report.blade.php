@extends('_layout_shared._master')
@section('title','Pay Order Report')
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
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Pay Order Report
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

                                    @if(Auth::user()->desig == 'HO')

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
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="region"
                                                       class="col-md-4 control-label"><b>Region</b></label>
                                                <div class="col-md-8">
                                                    <select name="region" id="region"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        <option value="ALL">ALL</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="sum_id"
                                                       class="col-md-4 control-label"><b>Sum Id</b></label>
                                                <div class="col-md-8">
                                                    <select name="sum_id" id="sum_id"
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


                                    @endif


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
                    <div class="panel-body" >
                        <div class="table-responsive">
                            <table id="req_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>

                                    <th>Depot</th>
                                    <th>Rm Terr</th>
                                    <th>RM Name</th>
                                    <th>Desig</th>
                                    <th>Pay Mode</th>
                                    <th>Sum ID</th>
                                    <th>SSD nopo</th>
                                    <th>send date</th>
                                    <th>RM nopo</th>
                                    <th>remarks</th>
                                    <th>receive date</th>
{{--                                    <th>SSD send</th>--}}
{{--                                    <th>RM receive</th>--}}
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
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    <script type="text/javascript">
        $(document).ready(function () {


                // new SlimSelect({
                //     select: '#region',
                //     closeOnSelect: false
                // })

                re_year = "{{url('scientific/sci_year')}}";
                pay_order_report_data = "{{url('donation/pay_order_report_data')}}";

            sum_id_list = "{{url('donation/sum_id_list_report')}}";
            region_list = "{{url('donation/region_list_report')}}";

                _csrf_token = '{{csrf_token()}}';
                var table;
            log_desig = '{{Auth::user()->desig}}';

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
                                // op += "<option value='ALL'>ALL</option>";

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

                $('#region').empty();

                var month = $("#bgt_month").val();

                console.log(month);

                $("#region").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: sum_id_list,
                    dataType: 'json',
                    data: {
                        _token: _csrf_token,
                        month: month},
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        selOptsMPO += "<option value=''>Select</option>";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['rm_terr_id'];
                            var val = response[j]['rm_terr_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#region').empty().append(selOptsMPO);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            });

            $("#region").on('change', function () {

                $('#sum_id').empty();

                var month = $("#bgt_month").val();
                var region = $('#region').val();

                console.log(month);

                if($("#region").val()== 'ALL'){

                    $("#sum_id").empty().append("<option value='ALL'>ALL</option>");
                }

                else{

                    $("#sum_id").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        type: "post",
                        url: region_list,
                        dataType: 'json',
                        data: {
                            _token: _csrf_token,
                            month: month,
                            region: region
                        },
                        success: function (response) {
                            console.log(response);
                            var selOptsMPO = "";
                            // selOptsMPO += "<option value=''>Select</option>";
                            selOptsMPO += "<option value='ALL'>ALL</option>";
                            for (var j = 0; j < response.length; j++) {
                                var id = response[j]['summ_id'];
                                var val = response[j]['summ_id'];
                                selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#sum_id').empty().append(selOptsMPO);

                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });



                }


            });

            $("#btn_display").click(function () {

                 if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }
                else if ($("#sum_id").val() === "") {
                    alert("Please select summary Id");
                }
                else if ($("#region").val() === "") {
                    alert("Please select region");
                }

                else {

                    console.log(log_desig);
                    var month = $("#bgt_month").val();
                    var sum_id = $("#sum_id").val();
                     var region = $('#region').val();
                     console.log(region);

                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: pay_order_report_data,
                        data: {
                            month: month,
                            sum_id: sum_id,
                            region: region,
                            _token: _csrf_token,

                        },
                        success: function (data) {
                            console.log(data);

                            $('#req_list').DataTable().destroy();

                             table = $('#req_list').DataTable({
                                data: data,
                                //   dom: 'Bfrtip',
                                //
                                // buttons: [
                                //
                                //     {
                                //         extend: 'excelHtml5', className: "btn-warning",
                                //         exportOptions: {
                                //             columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15]
                                //         }
                                //     }
                                //
                                // ],

                                columns: [
                                    {data: "depot_name"},
                                    {data: "rm_terr_id"},
                                    {data: "rm_name"},
                                    {data: "desig"},
                                    {data: "payment_mode"},
                                    {data: "summ_id"},
                                    {data: "ssd_nopo"},
                                    {data: "ssd_send_date"},
                                    {data: "rm_nopo"},
                                    {data: "remarks"},
                                    {data: "rm_received_date"},
                                ],
                                ordering:false,
                                paging:false,
                                // filtering:false,
                                info:false,
                                searching:false,
                                // fixedHeader: true,
                                "scrollY": "450px",
                                "scrollX": true,
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