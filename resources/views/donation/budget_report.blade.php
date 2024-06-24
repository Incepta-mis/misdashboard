@extends('_layout_shared._master')
@section('title','Budget Summary Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>



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
                             Budget Summary Report
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">

                                    <div class="row">

                                                <label for="bgt_month"
                                                       class="col-md-1 control-label"><b>Month</b></label>

                                                <!-- <div class="col-md-2">
                                                    <select name="bgt_month_from" id="bgt_month_from"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($month_name as $mn)
                                                            <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> -->

                                                <!-- <div class="col-md-2">
                                                    <select name="bgt_month_to" id="bgt_month_to"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($month_name as $mn)
                                                            <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> -->

                                                <div class="col-md-2">
                                                <input type="text" class="form-control input-sm" name="st_dt"
                                                       style="padding-right: 0px;" id="date1" autocomplete="off">
                                            </div>

                                            <div class="col-md-2">
                                                <input type="text" class="form-control input-sm"
                                                       style=""
                                                       name="en_dt" id="date2" autocomplete="off">
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
                                                        <!-- @foreach($cc as $ccn)
                                                            <option value="{{$ccn->cost_center_id}}">
                                                                {{$ccn->cost_center_description}}</option>
                                                        @endforeach -->
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
                                        <th>COST CENTER ID</th>
                                        <th>COST CENTER NAME</th>
                                        <th>GL</th>
{{--                                        <th>GLN</th>--}}
                                        <th>Initial Budget</th>
                                        <th>CFLM</th>
                                        <th>Total Budget</th>
                                        <th>Consumption</th>
                                        <th>Remaining</th>
                                        <th>CFNM</th>

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

    <script type="text/javascript">

        subtract_budget_calc = "{{url('donation/subtract_budget_calc')}}";
        cc_budget_report = "{{url('donation/cc_budget_report')}}";
        cc_don = "{{url('donation/cc_don_sum')}}";
        _csrf_token = '{{csrf_token()}}';
        var table;

        $(document).ready(function () {


            $('#date1').datepicker({
                format: "dd-M-yy",
                todayHighlight: 'TRUE',
                autoclose: true,
                startView: "months",
                minViewMode: "months",
                minDate: 0,
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {
                $('#date2').datepicker('setStartDate', $("#date1").val());
            });

            $('#date2').datepicker({
                format: "dd-M-yy",
                todayHighlight: 'TRUE',
                autoclose: true,
                startView: "months",
                minViewMode: "months",
                minDate: '0',
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {

                var d1 = $('#date1').datepicker('getDate');
                var d2 = $('#date2').datepicker('getDate');
                var diff = 0;
                if (d1 && d2) {
                    diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                }
                $('#dol').val(diff);
            });

                var mon = '';
                var cc = '';

                
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
                        selOptsMPO += "<option value=''>Select Cost Center</option>";
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


                $("#btn_display").click(function () {


                    if ($("#date1").val() === "") {
                        alert("Please select Expense Month");
                    }
                    else if ($("#date2").val() === "") {
                        alert("Please select Expense Month");
                    }
                    else if ($("#cc").val() === "") {
                        alert("Please select Cost center");
                    }

                    else {

                        $(".add_budget_ammount").hide();
                        $(".save_budget").hide();
                        $("#report-body").hide();


                        // mon_from = $('#bgt_month_from').val();
                        // mon_to = $('#bgt_month_to').val();

                        mon_from = $("#date1").val();
                        mon_to = $("#date2").val();

                        var gl = $("#gl").val();

                        cc = $('#cc').val();

                        console.log(mon_from);
                        console.log(mon_to);
                        console.log(cc);


                        $("#loader").show();
                        $.ajax({
                            url: cc_budget_report,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                mon_from: mon_from,
                                mon_to: mon_to,
                                gl:gl,
                                cc: cc

                            },


                            success: function (resp) {

                                console.log(resp);
                                if ((resp.length) < 1) {
                                    $("#loader").hide();
                                    toastr.info('Budget not available');
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
                                                    columns: [0,1,2, 3, 4, 5, 6, 7, 8]
                                                }
                                            }
                                        ],
                                        columns: [
                                            // {data: "budget_month"},
                                            {data: "cost_center_id"},
                                            {data: "cost_center_name"},
                                            {data: "gl"},
                                            // {data: "gl_name"},
                                            {
                                                data: "cma",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "lma",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "total_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "expense_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "rem_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            },
                                            {
                                                data: "nmcf_amt",
                                                render: $.fn.dataTable.render.number(',', 3)
                                            }
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


            }
        );


    </script>

@endsection