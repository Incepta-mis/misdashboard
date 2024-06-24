@extends('_layout_shared._master')
@section('title','SSD Process')
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
                        SSD Process
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    @if( Auth::user()->desig === 'All'||  Auth::user()->desig === 'HO')


                                        <div class="row">

                                            <div class="col-md-3 col-sm-2 col-xs-6">
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


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="gl"
                                                           class="col-md-4 col-sm-6 control-label"><b>GL</b></label>
                                                    <div class="col-md-8">
                                                        <select name="gl" id="gl"
                                                                class="form-control input-sm">
                                                            <option value="ALL">ALL</option>
                                                            {{--<option value="">Select GL</option>--}}
                                                            @foreach($gl as $gln)
                                                                <option value="{{$gln->gl}}">{{$gln->gl}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cc"
                                                           class="col-md-4 col-sm-6 control-label"><b>Cost
                                                            Cent</b></label>
                                                    <div class="col-md-8">
                                                        <select name="cc" id="cc"
                                                                class="form-control input-sm">
                                                            <option value="ALL">ALL</option>
                                                            @foreach($cc as $ccid)
                                                                <option value="{{$ccid->cost_center_id}}">{{$ccid->cost_center_id}}
                                                                    - {{$ccid->cost_center_group}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- First row ends here--}}

                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>
                                                            <!-- <option value="ALL">ALL</option> -->
                                                            @foreach($rm_terr as $terr)
                                                                <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="am_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>AM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">AM Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">MPO Territory</option>

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
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="req_ccwise" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Budget Mon</th>
                                    <th>GL</th>
                                    <th>COST CENTER ID</th>
                                    <th>COST CENTER NAME</th>
                                    <th>REQ</th>
                                    <th>TOTAL REQ Amt</th>
                                    <th>TOTAL BUDGET</th>
                                    <th>EXPENSE BUDGET</th>
                                    <th>AVAILABLE BUDGET</th>
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

    <div class="col-md-4" id="prepare_button" style="display: none;">
        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
            <button type="button" id="process_button" class="btn btn-default btn-sm">
                <i class="fa fa-check"></i> <b>Process</b></button>
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

            var am_fetch_ssd, mpo_fetch_ssd, servloc, eid, desig, verify_ssd;
            var exportExtension = '';
            var table;
            var _csrf_token;
            var verifydata = [];
            var ssddate = [];
            var update_mon = '';
            var update_gl = '';
            var update_cc = '';

            am_fetch_ssd = "{{url('dmr/am_fetch_ssd')}}";
            mpo_fetch_ssd = "{{url('dmr/mpo_fetch_ssd')}}";
            servloc = "{{url('dmr/ssd_dmr_data')}}";

            verify_ssd = "{{url('dmr/verify_ssd_dmr')}}";
            eid = "{{Auth::user()->user_id}}";
            desig = "{{Auth::user()->desig}}";
            _csrf_token = '{{csrf_token()}}';


            $("#rm_terr").on('change', function () {
                //$("#rm_terr").live("change", function() {
                var rm_terr = $("#rm_terr").val();
                $("#mpo_terr").html('');

                console.log(rm_terr);

                if (rm_terr == 'ALL') {
                    console.log('In Loop');

                    $('#smrm_name').empty().append("<option value='ALL'>ALL</option>");
                    $('#am_terr').empty().append("<option value='ALL'>ALL</option>");
                    $('#mpo_terr').empty().append("<option value='ALL'>ALL</option>");
                }
                else {
                    $.ajax({
                        type: "post",
                        // url: '{{url('rm_portal/regwTerrListSmRmNameId')}}',
                        url: am_fetch_ssd,
                        dataType: 'json',
                        data: {rmTerr: rm_terr, _token: _csrf_token},
                        success: function (response) {
                            console.log(response);

                            var selOptsAM = "";
                            selOptsAM += "<option value=''>Select Territory</option>";
                            selOptsAM += "<option value='ALL'>ALL</option>";


                            for (var i = 0; i < response.length; i++) {
                                var id = response[i]['am_terr_id'];
                                var val = response[i]['am_terr_id'];

                                selOptsAM += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#am_terr').html(selOptsAM);


                            var selOptsRM = "";
                            for (var d = 0; d < 1; d++) {
                                var idj = response[d]['rmsm_name'];
                                var valj = response[d]['rmsm_name'];

                                selOptsRM += "<option value='" + idj + "'>" + valj + "</option>";
                            }

                            $('#smrm_name').html(selOptsRM);


                            var selOptsRMid = "";
                            for (var l = 0; l < response.length; l++) {
                                var idl = response[l]['rmsm_id'];
                                var vall = response[l]['rmsm_id'];

                                selOptsRMid += "<option value='" + idl + "'>" + vall + "</option>";
                            }
                            $('#smrm_id').html(selOptsRMid);

                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }


            });

            $("#am_terr").on('change', function () {
                var am_terr = $("#am_terr").val();
                var smrm_id = $("#rm_terr").val();
                console.log(am_terr);
                console.log(smrm_id);
                $("#mpo_terr").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    // url: '{{url('rm_portal/regwTerrListSmRmNameId')}}',
                    url: mpo_fetch_ssd,
                    dataType: 'json',
                    data: {_token: _csrf_token, amTerr: am_terr, rmTerrId: smrm_id},
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        selOptsMPO += "<option value=''>Select Territory</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['mpo_terr_id'];
                            var val = response[j]['mpo_terr_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#mpo_terr').empty().append(selOptsMPO);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $("#btn_display").click(function () {
                $("#prepare_button").hide();

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
                    if ($("#report-body").is(":visible")) {
                        $("#report-body").hide();
                    }


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
                        url: servloc,
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

                            console.log($('#fix').height());
                            $("#loader").hide();
                            $("#report-body").show();

                            $("#req_ccwise").DataTable().destroy();
                            table = $("#req_ccwise").DataTable({
                                data: resp,
                                columns: [
                                    {data: "req_month"},
                                    {data: "gl"},
                                    {data: "cost_center_id"},
                                    {data: "cost_center_name"},
                                    {data: "tot_req_qty"},
                                    {data: "tot_req_amt",ClassName: "tot_req_amt"},
                                    {data: "total_budget"},
                                    {data: "exp_amt"},
                                    {data: "available_amt",ClassName: "avail_amt"}
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
                var flag = true;

                table.rows().eq(0).each( function ( index ) {
                    var row = table.row( index );

                    var data = row.data();

                    if(parseInt(data.tot_req_amt)>parseInt(data.available_amt)){
                        flag = false;
                        toastr.info('Available budget not sufficient');
                    }

                    console.log(data.tot_req_amt);
                    // ... do something with data(), or row.node(), etc
                } );

            console.log('clicked');

            if(flag) {


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

            }
            });

        });


    </script>

@endsection