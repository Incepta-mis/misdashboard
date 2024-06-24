@extends('_layout_shared._master')
@section('title','Team wise budget & actual expense details')
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
                        Team wise budget & actual expense details
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


                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gl"
                                                       class="col-md-6 control-label"><b>GL</b></label>
                                                <div class="col-md-6">
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
                    <div class="panel-body" >
                        <div class="table-responsive">
                            <table id="req_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Month</th>
                                    <th>GL</th>
                                    <th>CC ID</th>
                                    <th>CC NAME</th>
                                    <th>Prop No</th>
                                    <th>Bill No</th>
                                    <th>Prog Date</th>
                                    <th>Withdraw Date</th>
                                    <th>Settle Date</th>
                                    <th>Actual Expense</th>
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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    <script type="text/javascript">
        $(document).ready(function () {

                re_year = "{{url('scientific/sci_year')}}";
                tbedata_display = "{{url('scientific/tbedata_display')}}";

                cc_don = "{{url('scientific/cc_don')}}";
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

                if ($("#bgt_year").val() === "") {
                    alert("Please select Program Year");
                }
                else if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }
                else if ($("#gl").val() === "") {
                    alert("Please select GL");
                } else if ($("#cc").val() === "") {
                    alert("Please select Cost center");
                }

                else {
                    var year = $("#bgt_year").val();
                    var month = $("#bgt_month").val();
                    var cc = $('#cc').val();
                    var gl = $('#gl').val();

                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: tbedata_display,
                        data: {
                            year: year,
                            month: month,
                            gl: gl,
                            cc: cc,
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
                                    {data: "month_of_prog"},
                                    {data: "gl"},
                                    {data: "cost_center_id"},
                                    {data: "cc_team_name"},
                                    {data: "prog_no"},
                                    {data: "bill_no"},
                                    {data: "prog_date_time"},
                                    {data: "withdraw_date"},
                                    {data: "settle_date"},
                                    {
                                        data: "bill_amt",
                                        render: $.fn.dataTable.render.number(',', 3)
                                    }

                                ],
                                ordering:false,
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