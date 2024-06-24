@extends('_layout_shared._master')
@section('title','Budget Monthly Report')
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
    <form>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Budget Monthly Report
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">



                                    <div class="row">

                                        {{--<div class="col-md-5">--}}
                                        {{--<div class="form-group">--}}
                                        <label for="bgt_month"
                                               class="col-md-1 control-label"><b>Year</b></label>
                                        <div class="col-md-2">
                                            <select name="bgt_year" id="bgt_year"
                                                    class="form-control input-sm">
                                                <option value="">Select</option>
                                                @foreach($month_name as $mn)
                                                    <option value="{{$mn->yr}}">{{$mn->yr}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        {{--</div>--}}
                                        {{--</div>--}}


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

                                        <div class="col-md-5">
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
                                        <th>GL</th>
                                        <th>COST CENTER ID</th>
                                        <th>COST CENTER NAME</th>
                                        <th>Month</th>
                                        <th>Budget</th>
                                        <th>Consumption</th>
                                        <th>Available</th>

                                    </tr>
                                    </thead>
                                    <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #EE5E3B; text-align: center;" colspan="4">Grand Total</th>
                                        <th style="background-color: #FFC300 "></th>
                                        <th style="background-color: #FFC300"></th>
                                        <th style="background-color: #FFC300 "></th>
                                    </tr>
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


    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}



    <script type="text/javascript">

        subtract_budget_calc = "{{url('donation/subtract_budget_calc')}}";
        budget_monthly_report_display = "{{url('donation/budget_monthly_report_display')}}";
        cc_don = "{{url('donation/cc_don_sum')}}";
        _csrf_token = '{{csrf_token()}}';
        var table;

        $(document).ready(function () {

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
                        // selOptsMPO += "<option value=''>Select Cost Center</option>";
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
            
                $("#btn_display").click(function () {

                    if ($("#bgt_year").val() === "") {
                        alert("Please select Budget Year");
                    }

                    else if ($("#gl").val() === "") {
                        alert("Please select GL");
                    }
                
                    else if ($("#cc").val() === "") {
                        alert("Please select Cost center");
                    }

                    else {

                        $("#report-body").hide();

                        var bgt_year = $('#bgt_year').val();
                        var cc = $('#cc').val();
                        var gl = $('#gl').val();

                        console.log(bgt_year);
                        console.log(cc);

                        $("#loader").show();
                        $.ajax({
                            url: budget_monthly_report_display,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                bgt_year: bgt_year,
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

                                    // if (table != '') {
                                    //     table
                                    //         .clear()
                                    //         .draw();
                                    // }
                                    //
                                    // else {
                                    $("#budget_table").DataTable().destroy();
                                        table = $("#budget_table").DataTable({
                                            data: resp,
                                            dom: '<"toolbar">Bfrtip',
                                        buttons: [

                                            {
                                                extend: 'excelHtml5', className: "btn-warning",
                                                exportOptions: {
                                                    columns: [0,1,2, 3, 4, 5,6]
                                                }
                                            }
                                        ],
                                            columns: [
                                                {data: "gl"},
                                                {data: "cost_center_id"},
                                                {data: "cost_center_name"

                                                },
                                                {data: "ym"},
                                                {
                                                    data: "cmiba",
                                                    render: $.fn.dataTable.render.number(',', 3)
                                                },
                                                {
                                                    data: "expense_amt",
                                                    render: $.fn.dataTable.render.number(',', 3)
                                                },
                                                {
                                                    data: "avail_amt",
                                                    render: $.fn.dataTable.render.number(',', 3)
                                                }
                                            ],

                                            "columnDefs": [

                                                {className: "text-right", "targets": [4, 5, 6]},
                                                {className: "tot_tar", "targets": [4]},
                                                {className: "tot_sal", "targets": [5]},
                                                {className: "tot_ach", "targets": [6]},
                                                {
                                                    "targets": [4, 5, 6],
                                                    "mRender": function (data, type, full) {

                                                        //console.log("mrender data "+data);
                                                        //its for 0.00 format data
                                                        //atargets need for that
                                                        //eDEfaultcontent need for null

                                                        if (data) {
                                                            return parseFloat(data).toFixed(2);
                                                        }

                                                    }

                                                },

                                            ],


                                            order: [[0, 'asc'],[2, 'asc']],

                                            rowGroup: {
                                                startRender: null,
                                                endRender: function (rows, group) {

                                                    var tgt_total = rows
                                                        .data()
                                                        .pluck('cmiba')
                                                        .reduce(function (a, b) {
                                                            return (parseInt(a) + parseInt(b)).toFixed(2);
                                                        }, 0);


                                                    console.log(tgt_total);

                                                    var sold_total = rows
                                                        .data()
                                                        .pluck('expense_amt')
                                                        .reduce(function (a, b) {
                                                            return (parseInt(a) + parseInt(b)).toFixed(2);
                                                        }, 0);


                                                    var TOT_PROD_OUT_total = rows
                                                        .data()
                                                        .pluck('avail_amt')
                                                        .reduce(function (a, b) {
                                                            return (parseInt(a) + parseInt(b)).toFixed(2);
                                                        }, 0);

                                                    // console.log(int_total);
                                                    if (rows[0].length > 1) {
                                                        // console.log("area");
                                                        return $('<tr>')
                                                            .append('<td colspan="4" style="text-align: left">' + group + ' Total</td>')
                                                            .append('<td style="text-align: right">' + accounting.formatMoney(tgt_total, "") + '</td>')
                                                            .append('<td style="text-align: right">' + accounting.formatMoney(sold_total, "") + '</td>')
                                                            .append('<td style="text-align: right">' + accounting.formatMoney(TOT_PROD_OUT_total, "") + '</td></tr>');
                                                    } else {

                                                        //here main target to give a class for single row ....then it will be display none using css in view
                                                        return $('<tr class="removeGrup">')
                                                            .append('<td colspan="4"></td>')
                                                            .append('<td style="text-align: right"></td>')
                                                            .append('<td style="text-align: right"></td>')
                                                            .append('<td style="text-align: right"></td></tr>');
                                                    }

                                                },
                                                dataSrc: 'cost_center_name'
                                                // dataSrc: [  2 ]
                                            },

                                            "footerCallback": function (row, data, start, end, display) {
                                                var api = this.api(), data;

                                                // Remove the formatting to get integer data for summation
                                                var intVal = function (i) {
                                                    return typeof i === 'string' ?
                                                        i.replace(/[\$,]/g, '') * 1 :
                                                        typeof i === 'number' ?
                                                            i : 0;
                                                };

                                                // Total over this page

                                                pageTotal3 = api
                                                    .column(4, {page: 'current'})
                                                    .data()
                                                    .reduce(function (a, b) {
                                                        return accounting.formatMoney((intVal(a) + intVal(b)).toFixed(2),"");
                                                    }, 0);

                                                pageTotal4 = api
                                                    .column(5, {page: 'current'})
                                                    .data()
                                                    .reduce(function (a, b) {
                                                        return accounting.formatMoney((intVal(a) + intVal(b)).toFixed(2),"");
                                                    }, 0);


                                                pageTotal5 = api
                                                    .column(6, {page: 'current'})
                                                    .data()
                                                    .reduce(function (a, b) {
                                                        // return (intVal(a) + intVal(b)).toFixed(2);
                                                        return accounting.formatMoney((intVal(a) + intVal(b)).toFixed(2),"");
                                                    }, 0);


                                                // Update footer

                                                $(api.column(4).footer()).html(
                                                    pageTotal3
                                                );

                                                $(api.column(5).footer()).html(
                                                    pageTotal4
                                                );

                                                $(api.column(6).footer()).html(
                                                    pageTotal5
                                                );


                                            },

                                            // "rowsGroup": [
                                            //     0, 1
                                            // ],

                                            language: {
                                                "emptyTable": "No Matching Records Found."
                                            },

                                            info: false,
                                            paging: false,
                                            filter: false,


                                        });

                                    // }


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