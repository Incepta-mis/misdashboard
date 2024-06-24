@extends('_layout_shared._master')
@section('title','Sub Cost Center Budget')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>



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
                            Sub Cost Center Budget
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">

                                    @if( Auth::user()->desig === 'All'||Auth::user()->desig === 'HO')

                                        <div class="row">

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="bgt_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                    <div class="col-md-8">
                                                        <select name="bgt_month" id="bgt_month"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            @foreach($month_name as $mn)
                                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                            @endforeach
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
                                                           class="col-md-4 col-sm-6 control-label"><b>Cost Center</b></label>
                                                    <div class="col-md-8">
                                                        <select name="cc" id="cc"
                                                                class="form-control input-sm">

                                                            <option value="">Select Cost Center</option>
                                                            @foreach($cc as $ccn)
                                                            <option value="{{$ccn->cost_center_id}}">
                                                            {{$ccn->cost_center_description}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="scc"
                                                           class="col-md-4 col-sm-6 control-label"><b>Sub Cost Center</b></label>
                                                    <div class="col-md-8">
                                                        <select name="scc" id="scc"
                                                                class="form-control input-sm">

                                                            <option value="">Select Sub cost Center</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display</b></button>
                                                {{--</div>--}}
                                            </div>




                                        </div>

                                    @endif

                                    {{--</form>--}}
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
                                <table id="budget_table"class="table table-condensed table-striped table-bordered"
                                       width="100%">
                                    <thead style="white-space:nowrap;">
                                    <tr>
                                        <th>Expense Month</th>
                                        <th>GL</th>
                                        <th>COST CENTER ID</th>
                                        <th>COST CENTER NAME</th>
                                        <th>SUB COST CCENTER ID</th>
                                        <th>SUB COST CCENTER NAME</th>
                                        <th>Available Budget</th>
                                        <th>Allocated Budget</th>
                                        <th>SM Exp</th>
                                        <th>Diff</th>

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

                    <div class="col-md-3 add_budget_ammount" style="display: none;">
                        <div class=" col-md-12 ">
                            <div class="col-md-4">Amount</div>
                            <div class="col-md-8"><input id="add_budget_ammount" name="add_budget_ammount" value="" type="number" min="1"></div>
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

    <script type="text/javascript">

        scc_for_budget = "{{url('donation/scc_for_budget')}}";
        scc_budget_display = "{{url('donation/scc_budget_display')}}";
        insert_scc_budget = "{{url('donation/insert_scc_budget')}}";
        _csrf_token = '{{csrf_token()}}';
        var table;

        $(document).ready(function () {

            var available_budget='0';


                $("#cc").on('change', function () {
                    ccid = $('#cc').val();
                    console.log(ccid);
                    $.ajax({
                        method: "post",
                        url: scc_for_budget,
                        data: {
                            _token: _csrf_token,
                            ccid: ccid
                        },
                        success: function (data) {
                            console.log(data);
                            console.log(data.length);
                            if ((data.length) > 0) {
                                var op = '';

                                // op += '<option value="" selected disabled>Select Sub cost Center</option>';


                                for (var i = 0; i < data.length; i++) {
                                    op += '<option value= " ' + data[i]['sub_cost_center_id'] + ' " >' + data [i]['sub_cost_center_name'] + '</option>';
                                }
                                $('#scc').html(" ");
                                $('#scc').append(op);

                            }






                        },
                        error: function () {
                            console.log('fail');
                        }
                    });
                });

            $("#add_budget").click(function (){

                $('#save_budget').prop('disabled', false);
                $("#add_budget_ammount").val('');
                 $(".add_budget_ammount").show();
                $(".save_budget").show();

            });

            $("#save_budget").click(function (){


                var proposed_budget = $("#add_budget_ammount").val();

                if(proposed_budget ==''){
                    toastr.info('Please allocate budget first');
                }

                else if(parseInt(proposed_budget) <1){
                    toastr.info('Invalid budget amount');
                }

                else if(parseInt(proposed_budget) <= parseInt(available_budget))
                {
                    $('#save_budget').prop('disabled', true);
                    console.log('Save button clicked');
                 console.log('Proposed budget '+proposed_budget);

                    var tblData = table.rows().data()[0];
                    console.log(tblData);

                    $.ajax({
                        method: "post",
                        url: insert_scc_budget,
                        data: {
                            _token: _csrf_token,
                            insertData: JSON.stringify(tblData),
                            proposed_budget:proposed_budget
                        },
                        success: function (data) {
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


                }
                else {
                    toastr.info('Allocation exceeds available budget');
                }

            });

            $("#btn_display").click(function () {


                if ($("#bgt_month").val() === "") {
                    alert("Please select Expense Month");
                }
                else if ($("#gl").val() === "") {
                    alert("Please select GL");
                }
                else if ($("#cc").val() === "") {
                    alert("Please select Cost center");
                }
                else if ($("#scc").val() === "") {
                    alert("Please select Sub cost center ");
                }

                else {

                    $(".add_budget_ammount").hide();
                    $(".save_budget").hide();
                        $("#report-body").hide();




                    var mon = $('#bgt_month').val();
                    var gl = $('#gl').val();
                    var cc = $('#cc').val();
                    var scc = $("#scc").val();

                    console.log(mon);
                    console.log(gl);
                    console.log(cc);
                    console.log(scc);


                    $("#loader").show();
                    $.ajax({
                        url: scc_budget_display,
                        method: "post",
                        dataType: 'json',

                        data: {
                            _token: _csrf_token,
                            mon: mon,
                            gl:gl,
                            cc:cc,
                            scc:scc
                        },


                        success: function (resp) {

                            console.log(resp);
                            if ((resp.length) < 1){
                                $("#loader").hide();
                                toastr.info('Budget not available');
                            }
                           else{
                                available_budget = resp[0]['avai_budget'];
                               console.log(available_budget);




                                $("#budget_table").DataTable().destroy();

                                table = $("#budget_table").DataTable({
                                    data: resp,
                                    columns: [
                                        {data: "budget_month"},
                                        {data: "gl"},
                                        {data: "cost_center_id"},
                                        {data: "cost_center_name"},
                                        {data: "sub_cost_center_id"},
                                        {data: "sub_cost_center_name"},
                                        {data: "avai_budget",
                                            render: $.fn.dataTable.render.number( ',', 3 )
                                        },
                                        {data: "scc_budget",
                                            render: $.fn.dataTable.render.number( ',', 3 )
                                        },
                                        {data: "sum_sm",
                                            render: $.fn.dataTable.render.number( ',', 3 )
                                        },
                                        {data: "exp_sm",
                                            render: $.fn.dataTable.render.number( ',', 3 )
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

            function updateTable() {


                $(".add_budget_ammount").hide();
                $(".save_budget").hide();
                $("#report-body").hide();


                var mon = $('#bgt_month').val();
                var gl = $('#gl').val();
                var cc = $('#cc').val();
                var scc = $("#scc").val();

                console.log(mon);
                console.log(gl);
                console.log(cc);
                console.log(scc);


                $("#loader").show();
                $.ajax({
                    url: scc_budget_display,
                    method: "post",
                    dataType: 'json',

                    data: {
                        _token: _csrf_token,
                        mon: mon,
                        gl:gl,
                        cc:cc,
                        scc:scc
                    },


                    success: function (resp) {

                        console.log(resp);
                        if ((resp.length) < 1){
                            toastr.info('Budget not available');
                        }
                        else{
                            available_budget = resp[0]['avai_budget'];
                            console.log(available_budget);




                            $("#budget_table").DataTable().destroy();

                            table = $("#budget_table").DataTable({
                                data: resp,
                                columns: [
                                    {data: "budget_month"},
                                    {data: "gl"},
                                    {data: "cost_center_id"},
                                    {data: "cost_center_name"},
                                    {data: "sub_cost_center_id"},
                                    {data: "sub_cost_center_name"},
                                    {data: "avai_budget",
                                        render: $.fn.dataTable.render.number( ',', 3 )
                                    },
                                    {data: "scc_budget",
                                        render: $.fn.dataTable.render.number( ',', 3 )
                                    },
                                    {data: "sum_sm",
                                        render: $.fn.dataTable.render.number( ',', 3 )
                                    },
                                    {data: "exp_sm",
                                        render: $.fn.dataTable.render.number( ',', 3 )
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


            }
        );



    </script>

@endsection