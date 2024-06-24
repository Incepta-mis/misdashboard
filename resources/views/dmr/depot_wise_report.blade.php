@extends('_layout_shared._master')
@section('title','Depot wise Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


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
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Depot wise Report
                    </label>
                </header>
                <div class="panel-body">
                    {{--<div class="form-horizontal">--}}
                    {{--<div class="col-md-12 col-sm-12">--}}
                    {{--<div class="col-md-12">--}}
                    <form method="post" action="{{url('dmr/depot_wise_report_pdf')}}">
                        {{csrf_field()}}
                        {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        @if( Auth::user()->desig === 'All'||  Auth::user()->desig === 'HO')


                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bgt_month"
                                               class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                        <div class="col-md-8">
                                            <select name="bgt_month" id="bgt_month"
                                                    class="form-control input-sm" required>
                                                <option value="">Select</option>
                                                @foreach($month_name as $mn)
                                                    <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cc"
                                               class="col-md-3 col-sm-6 control-label"><b>Cost
                                                Center</b></label>
                                        <div class="col-md-9">
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



                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mpo_terr"
                                               class="col-md-3 col-sm-6 control-label"><b>Depot</b></label>
                                        <div class="col-md-9">
                                            <select name="depot" id="depot"
                                                    class="form-control input-sm">
                                                <option value="">Select</option>
                                                {{--                                                <option value="ALL">ALL</option>--}}
                                                @foreach($depot as $bk)
                                                    <option value="{{$bk->depot_id}}">
                                                        DID - {{$bk->depot_id}} - DN - {{$bk->depot_name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                {{--<div class="form-group">--}}
                                <div class=" col-md-1 col-sm-2 col-xs-6">
                                    <button type="button" id="btn_display"
                                            class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                    </button>
                                    {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
                                </div>

                                <div class="col-md-1" id="print_advice" >
                                    {{--                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                    <button type="submit" id="print_bank_advice" class="btn btn-default btn-sm" >
                                        <i class="fa fa-check"></i> <b>Pdf</b></button>
                                    {{--                                    </div>--}}
                                </div>


                                {{-- First row ends here--}}

                            </div>

                        @endif

                    </form>
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
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
                            <table id="req_ccwise" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Month</th>
                                    <th>Depot</th>
                                    <th>Rm</th>
                                    <th>Code</th>
                                    <th>Product Name</th>
                                    <th>Pack Size</th>
                                    <th>Quantity</th>
                                    <th>Unit Price (TP+VAT)</th>
                                    <th> Total (TP+VAT))</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
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

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

    {{----}}
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

    {{Html::script('public/site_resource/select2/select2.min.js')}}


    <script type="text/javascript">



        $(document).ready(function () {
            /**
             * Created by Sahadat on 17/02/2019.
             */
            $('#print_bank_advice').attr('formtarget', '_blank');

            var servloc, verify_ssd;
            var exportExtension = '';
            var table;
            var _csrf_token;

            servloc = "{{url('dmr/depot_wise_data')}}";


            _csrf_token = '{{csrf_token()}}';





            $("#btn_display").click(function () {
                // $("#prepare_button").hide();

                if ($("#depot").val() === "") {
                    alert("Please select Depot");
                }
                else if ($("#bgt_month").val() === "") {
                    alert("Please select Month");
                }
                else if ($("#cc").val() === "") {
                    alert("Please select Cost center");
                }
                else {
                    if ($("#report-body").is(":visible")) {
                        $("#report-body").hide();
                    }



                    var depot = $('#depot').val();

                    var mon = $('#bgt_month').val();
                    var cc = $('#cc').val();


                    console.log(depot);
                    console.log(mon);
                    console.log(cc);


                    $("#loader").show();
                    $.ajax({
                        url: servloc,
                        method: "post",    // change here for post method
                        dataType: 'json',

                        data: {
                            _token: _csrf_token, // include it in data section
                            depot: depot,
                            mon: mon,
                            cc: cc
                        },


                        success: function (resp) {


                            console.log(resp);

                            console.log($('#fix').height());
                            $("#loader").hide();
                            $("#report-body").show();

                            $("#req_ccwise").DataTable().destroy();
                            table = $("#req_ccwise").DataTable({
                                data: resp,
                                columns: [
                                    {data: "req_month"},
                                    {data: "depot_id" }  ,
                                    {data: "rm_terr_id"},
                                    {data: "p_code"},
                                    {data: "product_name"},
                                    {data: "pack_size"},
                                    {data: "total_qty"},
                                    {data: "unit_price"},
                                    {data: "total_value"}
                                ],



                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },

                                info: false,
                                paging: false,
                                filter: false,


                            });

                            if(resp.length>0){
                                $("#prepare_button").show();
                            }


                            // table.fixedHeader.enable();
                        },
                        error: function (err) {
                            // console.log(err);
                            $("#loader").hide();
                            $("#report-body").show();
                        }
                    });
                }

            });

            $(".toggle-btn").click(function () {
                table.columns.adjust();
            });

            $("#process_button").click(function(){
                console.log('clicked');

                if ($("#rm_terr").val() === "") {
                    alert("Please select RM");
                }
                else if ($("#am_terr").val() === "") {
                    alert("Please select AM");
                }
                else if ($("#mpo_terr").val() === "") {
                    alert("Please select MPO");
                }
                else if ($("#bgt_month").val() === "") {
                    alert("Please select Month");
                }
                else if ($("#gl").val() === "") {
                    alert("Please select GL");
                }

                else if ($("#cc").val() === "") {
                    alert("Please select Cost Center");
                }
                else {

                    var rm_terr = $("#rm_terr").val();
                    var am_terr = $("#am_terr").val();
                    var mpo_id = $('#mpo_terr').val();

                    var mon = $('#bgt_month').val();
                    var gl = $("#gl").val();
                    var cc = $('#cc').val();


                    console.log(rm_terr);
                    console.log(am_terr);
                    console.log(mpo_id);
                    console.log(mon);
                    console.log(gl);
                    console.log(cc);

                    $("#loader").show();
                    $.ajax({
                        url: verify_ssd,
                        method: "post",    // change here for post method
                        dataType: 'json',

                        data: {
                            _token: _csrf_token, // include it in data section
                            rmTerrId: rm_terr,
                            amTerr: am_terr,
                            mpoId: mpo_id,
                            mon: mon,
                            gl: gl,
                            cc: cc
                        },


                        success: function (resp) {

                            console.log(resp);
                            toastr.success('Processed successfully');

                            $("#loader").hide();


                            $("#prepare_button").hide();


                        },
                        error: function (err) {
                            console.log(err);
                            $("#loader").hide();
                            toastr.error('Process failed');
                        }
                    });
                }

            });

        });


    </script>

@endsection