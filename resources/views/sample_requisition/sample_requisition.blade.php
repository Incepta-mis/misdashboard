@extends('_layout_shared._master')
@section('title','Doctor Sample Requisition')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
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

        .sample_info_panel {
            position: -webkit-sticky;
            top: 0;
        }

        body {
            counter-reset: Serial;
        }

        table {
            border-collapse: separate;
        }

        table tbody tr td:nth-child(2):before {
            counter-increment: Serial;
            content: "" counter(Serial);
        }

        .s_font {
            font-size: 11px;
            padding: 7px 0;
        }

        .form-group {
            margin-bottom: 0;
        }

        input[list] {
            color: black;
            background-color: white;
        }
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12 sticky-top">
            <section class="panel sample_info_panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Doctor Sample Requisition
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rm_terr"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>RM
                                                        Terr</b></label>
                                                <div class="col-md-8" style="margin:  0;">
                                                    <select name="rm_terr" id="rm_terr"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0; margin: 2px 0;">
                                                        <option value="" selected disabled>Select</option>
                                                        @foreach($rm_terr as $rt)
                                                            <option style="font-size: 11px"
                                                                    value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="am_terr"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Am
                                                        Terr</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <select name="am_terr" id="am_terr"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0;  margin: 2px 0;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mpo_terr"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>MPO
                                                        Terr</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <select name="mpo_terr" id="mpo_terr"
                                                            class="form-control input-sm"
                                                            style="font-size: 10px; height: 26px; padding: 0;  margin: 2px 0;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">

                                        <div class="col-md-3 col-sm-2 ">
                                            <div class="form-group">
                                                <label for="pcode"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Emp
                                                        ID</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="emp_id" id="emp_id" class="form-control"
                                                           style="font-size: 11px; height: 26px; padding: 0;  margin: 2px 0;"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="emp_name"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Emp
                                                        Name</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="emp_name"
                                                           class=" form-control"
                                                           autocomplete="off" id="emp_name"
                                                           style="font-size: 11px; height: 26px; padding: 0;  margin: 2px 0;"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="docid"
                                                       class="col-md-4 col-sm-6 control-label s_font"
                                                       style="padding: 7px 0;"><b>Emp Number</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="emp_no"
                                                           class=" form-control"
                                                           autocomplete="off" id="emp_no" readonly
                                                           style="font-size: 11px; height: 26px; padding: 0;  margin: 2px 0;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Date</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="monthname"
                                                           class=" form-control"
                                                           value="{{$month_name[0]->monthname}}"
                                                           autocomplete="off" id="req_month" readonly
                                                           style="font-size: 10px; height: 26px; padding: 0;  margin: 2px 0;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="depo"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Depot</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <select name="depo" id="depo"
                                                            style="font-size: 10px; height:26px; padding: 0;  margin: 2px 0;"
                                                            class="form-control input-sm">
                                                        <option value="" style="font-size: 11px">Select Depot</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="requisition_type"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Req
                                                        Type</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="requisition_type"
                                                           class=" form-control" value="Special Promotion"
                                                           autocomplete="off" id="requisition_type" readonly
                                                           style="font-size: 11px; height: 26px; padding: 0;  margin: 2px 0;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="item_sample"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Item
                                                        Code</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input name="i_code" id="i_code" class="form-control input-sm"
                                                           list="item_sample_list" type="text"
                                                           oninput="this.value = this.value.toUpperCase()"
                                                           autocomplete="off"
                                                           style="font-size: 11px; height: 26px; padding: 0; ">
                                                    <datalist id="item_sample_list"
                                                              style="font-size: 11px; margin: 2px 0;">
                                                    </datalist>
                                                    </input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display: none">
                                            <div class="form-group">
                                                <label for="item_name"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>item_name</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="item_name"
                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0;  margin: 2px 0;"
                                                           class="item_name form-control"
                                                           autocomplete="off" readonly="" id="item_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display: none">
                                            <div class="form-group">
                                                <label for="price"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>price</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="price" style="text-transform: uppercase;"
                                                           class="price form-control"
                                                           autocomplete="off" readonly="" id="price">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display: none">
                                            <div class="form-group">
                                                <label for="stock"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>stock</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="stock" style="text-transform: uppercase;"
                                                           class="stock form-control"
                                                           autocomplete="off" readonly="" id="stock">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display: none">
                                            <div class="form-group">
                                                <label for="sample_type"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>sample_type</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="sample_type"
                                                           style="text-transform: uppercase;"
                                                           class="sample_type form-control"
                                                           autocomplete="off" readonly="" id="sample_type">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display: none">
                                            <div class="form-group">
                                                <label for="version_no"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>version_no</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="text" name="version_no"
                                                           style="text-transform: uppercase;"
                                                           class="version_no form-control"
                                                           autocomplete="off" readonly="" id="version_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="quant"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Quantity</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="number" min="1" oninput="validity.valid||(value='');"
                                                           name="quant"
                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; margin: 2px 0;"
                                                           class=" form-control"
                                                           autocomplete="off" id="quant">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="total"
                                                       class="col-md-4 col-sm-6 control-label s_font"><b>Total</b></label>
                                                <div class="col-md-8" style="margin: 0;">
                                                    <input type="number" name="total"
                                                           style="text-transform: uppercase; font-size: 11px; height: 26px; padding: 0;  margin: 2px 0;"
                                                           class=" form-control"
                                                           autocomplete="off" readonly="" id="total">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-1 " style="padding: 0px; margin-left: 62px">
                                            <div class="button-group">
                                                <button id="add_row" value="Add Row"><i
                                                            class="fa fa-plus"></i></button>
                                                <span>&nbsp;&nbsp;</span>
                                                <button id="remove_row" class="button danger"><i
                                                            class="fa fa-minus"></i>
                                                </button>

                                                {{--<button id="insert_button" type="button" class="pull-right">Save--}}
                                                {{--</button>--}}

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remarks"
                                                       class="col-md-1 col-sm-2 control-label"
                                                       style="font-size: 11px; height: 26px; padding: 6px 0 0 0;  text-align:right; margin: 2px 0;"><b>Remarks</b></label>
                                                <div class="col-md-9" style="margin: 0;">
                                                    <input type="text" id="remarks" name="remarks"
                                                           style="text-transform: uppercase; font-size: 11px"
                                                           class=" form-control"
                                                           autocomplete="off">
                                                </div>
                                            </div>
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

    <section class="panel">
        <div class="panel-body">
            <div class="col-md-12 table-responsive" style="padding-left: 5px;padding-right: 5px;">
                <table class="table table-condensed table-bordered" id="product_sample">
                    <thead>
                    <tr>
                        <th></th>
                        <th>SL NO.</th>
                        <th>ITEM CODE</th>
                        <th>ITEM NAME</th>
                        <th>STOCK</th>
                        <th>QUANTITY</th>
                        <th>UNIT PRICE</th>
                        <th>TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($x=0; $x <0; $x++)
                        <tr>
                            <td>
                                <input type="checkbox" name="record">
                                {{--<input type="checkbox" class="chk form-control" name="row_chk" >--}}
                            </td>
                            <td style="white-space: nowrap;">
                                {{--<input type="text" name="doc_id" class="doc_id form-control"--}}
                                {{--ng-model="td.doc_id" autocomplete="off"--}}
                                {{--maxlength="6" size="6">--}}
                            </td>
                            <td>

                            </td>
                            <td>
                                <input type="text" name="item_name" style="text-transform: uppercase;"
                                       class="item_name form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="text" name="stock" style="text-transform: uppercase;"
                                       class="stock form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="number" name="quant" style="text-transform: uppercase;"
                                       class="quant form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="text" name="price" style="text-transform: uppercase;"
                                       class="price form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="number" name="total" style="text-transform: uppercase;"
                                       class="total form-control"
                                       autocomplete="off" readonly="">

                            </td>
                        </tr>
                    @endfor
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7" style="text-align: right;"><b>Total Amount</b></td>
                        <td><b><input type="text" readonly="" class="total_price form-control" autocomplete="off"></b>
                        </td>
                    </tr>

                    </tfoot>

                </table>


            </div>

            <div class="col-md-11 " style="padding: 0px;">
                <div class="button-group">

                    {{--                    <button id="btn_view" type="button" class="pull-left">View--}}
                    {{--                    </button>--}}

                    <button id="btn_insert" type="button" class="pull-right">Save
                    </button>

                </div>
            </div>

        </div>

    </section>

    {{--This code area is for showing loader image--}}
    <div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
        <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/processing.gif')}}"
                     alt="Loading Report Please wait..."><br>
            </div>
        </div>
    </div>
    {{--This code area is for showing loader image ends here--}}

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


    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            var table = null;
            $("#docid").select2();

            servloc_tid = "{{url('dsr/getMpoTerr_DMR')}}";

            insert_row = "{{url('dsr/insert_requisition_info')}}";

            depo_and_doc = "{{url('dsr/depo_and_doc_dmr')}} ";

            item_sample = "{{url('dsr/item_sample')}}";

            item_sample_stock = "{{url('dsr/item_sample_stock')}}";

            _csrf_token = '{{csrf_token()}}';

            var dipro = function () {
                $('#i_code').val('Please Wait...').prop('disabled', true);

                let itemList = null;

                $.ajax({
                    type: 'GET',
                    url: '{{url('dsr/item_sample')}}',
                    data: {},
                    success: function (response) {
                        $('#i_code').val('').prop('disabled', false);
                        for (let i = 0; i < response.length; i++) {
                            itemList += ' <option style="font-size: 11px" value="' + response[i].item_id + '"' +
                                '            data-item_name="' + response[i].item_name + '"' +
                                '            data-price="' + response[i].price + '"' +
                                '            data-stock="' + response[i].stock + '"' +
                                '            data-sample_type="' + response[i].sample_type + '"' +
                                '            data-version_no="' + response[i].version_no + '">' +
                                response[i].item_id + '|' + response[i].item_name + '</option>';
                        }
                        $('#item_sample_list').empty().append(itemList);

                    },
                    error: function (error) {
                        // console.log(error);
                    }
                });


            };


            dipro();

            $("#rm_terr").on('change', function () {
                console.log($(this).val());
                $.ajax({
                    type: "post",
                    url: '{{url('dsr/get_am_terr')}}',
                    datatype: 'json',
                    data: {
                        rm_terr: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log("response");
                        console.log(response);
                        var am = response.am_terr;

                        var selOptsMPO = '';
                        var selOptsAM = '';
                        selOptsAM += "<option value='ALL'>ALL</option>";
                        selOptsMPO = "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < am.length; j++) {
                            var id = am[j]['am_terr_id'];
                            var val = am[j]['am_terr_id'];
                            selOptsAM += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('#am_terr').empty().append(selOptsAM);
                        $('#mpo_terr').empty().append(selOptsMPO);
                        console.log("rm_info");
                        console.log(response.rm_info);
                        $("#emp_id").val(response.rm_info[0].emp_id);
                        $("#emp_name").val(response.rm_info[0].sur_name);
                        $("#emp_no").val(response.rm_info[0].emp_contact_no);


                        var selOptsDEPOT = "";
                        selOptsDEPOT += "<option value='' disabled>Select Depot</option>";
                        for (var j = 0; j < response['depo'].length; j++) {
                            var id = response['depo'][j]['depot_id'];
                            var val = response['depo'][j]['depot_name'];
                            selOptsDEPOT += "<option value='" + id + "|" + val + "'>" + val + "</option>";
                        }

                        $('#depo').empty().append(selOptsDEPOT);


                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

            });

            $("#am_terr").on('change', function () {
                var am_terr = $("#am_terr").val();
                var smrm_id = $("#rm_terr").val();
                console.log(am_terr);
                console.log(smrm_id);
                $("#mpo_terr").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "GET",
                    url: servloc_tid,
                    dataType: 'json',
                    data: {amTerr: am_terr, rmTerrId: smrm_id},
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response.mpo_terr.length; j++) {
                            var id = response.mpo_terr[j]['mpo_terr_id'];
                            var val = response.mpo_terr[j]['mpo_terr_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#mpo_terr').empty().append(selOptsMPO);
                        console.log(response.am_info);
                        $("#emp_id").val(response.am_info[0].emp_id);
                        $("#emp_name").val(response.am_info[0].sur_name);
                        $("#emp_no").val(response.am_info[0].emp_contact_no);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $("#mpo_terr").on('change', function () {
                $("#doc_info").hide();
                var mpo_terr = $("#mpo_terr").val();

                console.log(mpo_terr);

                $("#docid").empty().append("<option value='loader'>Loading...</option>");


                $.ajax({
                    type: "post",
                    url: depo_and_doc,
                    dataType: 'json',
                    data: {
                        mpo_terr: mpo_terr,
                        type_am_mpo: 'mpo',
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        // console.log(response);

                        var selOptsDOC = "";
                        selOptsDOC += "<option value='' disabled>Select Doctor</option>";
                        for (var j = 0; j < response['docid'].length; j++) {
                            var id = response['docid'][j]['doctor_id'];
                            var val = response['docid'][j]['doctor_id'] + '-' + response['docid'][j]['doctor_name'];
                            selOptsDOC += "<option value='" + id + "' data-docname = '" + response['docid'][j]['doctor_name'] + "'>" + val + "</option>";
                        }
                        // $('#docid').empty().append(selOptsDOC);


                        // for Depot
                        var selOptsDEPOT = "";
                        selOptsDEPOT += "<option value='' disabled>Select Depot</option>";
                        for (var j = 0; j < response['depo'].length; j++) {
                            var id = response['depo'][j]['depot_id'];
                            var val = response['depo'][j]['depot_name'];
                            selOptsDEPOT += "<option value='" + id + "|" + val + "'>" + val + "</option>";
                        }
                        $('#depo').empty().append(selOptsDEPOT);
                        $("#emp_id").val(response.mpo_terr[0].emp_id);
                        $("#emp_name").val(response.mpo_terr[0].sur_name);
                        $("#emp_no").val(response.mpo_terr[0].emp_contact_no);

                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });


            });

            $("#i_code").on('change', function () {


                // $(document).on('change', "#pcode", function () {
                // event.preventDefault();
                console.log('product code changed');
                // console.log($('#pcode_list').attr('data-pname'));
                var item_id = $('#i_code').val();

                var item_name = $('#item_sample_list option').filter(function () {
                    return this.value == item_id;
                }).data('item_name');

                console.log("item_name", item_name);
                console.log("item_id", item_id);

                if (item_name == undefined) {
                    $("#i_code").val('');
                    $('#quant').val('');
                    $('#total').val('');
                    alert('Product code does not exist');
                } else {
                    $('#quant').val('');
                    $('#total').val('');

                    var stock = $('#item_sample_list option').filter(function () {
                        return this.value == item_id;
                    }).data('stock');

                    var sample_type = $('#item_sample_list option').filter(function () {
                        return this.value == item_id;
                    }).data('sample_type');

                    var version_no = $('#item_sample_list option').filter(function () {
                        return this.value == item_id;
                    }).data('version_no');

                    var price = $('#item_sample_list option').filter(function () {
                        return this.value == item_id;
                    }).data('price');

                    $('#item_name').val(item_name);
                    $('#price').val(price);
                    $('#stock').val(stock);
                    $('#sample_type').val(sample_type);
                    $('#version_no').val(version_no);

                    // $('#pname').val($('#pcode option:selected').data('pname'));
                    // $('#pack').val($('#pcode option:selected').data('psize'));
                    // $('#spval').val($('#pcode option:selected').data('spval'));
                }

            });

            $("#quant").on('change', function (e) {

                e.preventDefault();
                var item_id = $('#i_code').val();
                // console.log(item_id);

                var total_item_code = $('#price').val() * $('#quant').val();
                $('#total').val(total_item_code.toFixed(2));
                // console.log($('#stock').val());
                // console.log(total_item_code);

            });

            $("#add_row").click(function (event) {
                event.preventDefault();
                //console.log('fired');

                var item_id = $('#i_code').val();

                $.ajax({
                    type: "post",
                    url: item_sample_stock,
                    data: {
                        _token: '{{csrf_token()}}',
                        item_id: item_id
                    },
                    success: function (response) {

                        // console.log(response);
                        // console.log(response[0].qty);

                        $('#stock').val(response[0].qty);

                        // event.preventDefault();
                        var item_code = $("#i_code").val();
                        var item_name = $("#item_name").val();
                        var stock = $("#stock").val();

                        // console.log("dipro stock ", stock);

                        var price = $("#price").val();
                        // var sample_type = $("#sample_type").val();
                        // var version_no = $("#version_no").val();
                        var quantity = $("#quant").val();
                        var flag_p_code = true;
                        var total_price = $("#total").val();

                        if (item_code == null || item_code == '') {
                            toastr.info('Please select a item code');
                        } else if (quantity == '') {
                            toastr.info('Please select quantity');
                        } else if (item_name == '') {
                            toastr.info('Please reload the page');
                        } else if (parseInt(quantity) > parseInt(stock)) {
                            toastr.error(stock, 'Current Stock - ');
                        } else {

                            $(".is_code").each(function () {

                                if (item_code == $(this).text()) {
                                    flag_p_code = false;

                                }
                            });
                            if (flag_p_code) {

                                // console.log('ading stock => ', stock);

                                var markup = "<tr>" +
                                    "<td><input type='checkbox' name='record'></td>" +
                                    "<td style='white-space: nowrap;'></td>" +
                                    "<td class='is_code'>" + item_code + "</td>" +
                                    "<td>" + item_name + "</td>" +
                                    "<td>" + stock + "</td>" +
                                    "<td>" + quantity + "</td>" +
                                    "<td>" + price + "</td>" +
                                    "<td class='total' >" + total_price + "</td>" +
                                    "</tr>";

                                $("table tbody").prepend(markup);

                                $("#i_code").val('');
                                $("#quant").val('');
                                $("#total").val('');

                                var grandTotal = 0;

                                $(".total").each(function () {
                                    var total_price = parseFloat($(this).text());
                                    // console.log("total_price ", total_price);
                                    grandTotal += isNaN(total_price) ? 0 : total_price;
                                });

                                // console.log('total spval is ' + grandTotal);
                                $(".total_price").val(grandTotal.toFixed(2));
                            } else {
                                toastr.info('This product has already been added');
                            }

                        }

                    }


                });


            });

            // Find and remove selected table rows
            $("#remove_row").click(function () {
                // console.log('remove button clicked');
                event.preventDefault();
                $("table tbody").find('input[name="record"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });

                var grandTotal = 0;

                $(".total").each(function () {
                    var price = parseFloat($(this).text());
                    // console.log(price);
                    grandTotal += isNaN(price) ? 0 : price;
                });

                // console.log('total price is ' + grandTotal);
                $(".total_price").val(grandTotal.toFixed(2));

            });

            $("#btn_insert").click(function () {


                if ($("#rm_terr").val() === "") {
                    toastr.info("Please Select RM Territory");
                } else if ($("#am_terr").val() === "") {
                    toastr.info("Please select AM Territory");
                } else if ($("#mpo_terr").val() === "") {
                    toastr.info("Please select MPO Territory");
                } else if ($("#depo").val() === "") {
                    toastr.info("Please Select Depot");
                } else {

                    var rm_terr = $('#rm_terr').val();
                    var am_terr = $('#am_terr').val();
                    var mpo_terr = $('#mpo_terr').val();
                    var emp_id = $('#emp_id').val();
                    var emp_name = $('#emp_name').val();
                    var emp_mobile = $('#emp_no').val();
                    var sample_type = $('#sample_type').val();
                    var version_no = $('#version_no').val();
                    var req_month = $('#req_month').val();
                    var depo = $('#depo').val();
                    var req_type = $('#requisition_type').val();
                    var remarks = $('#remarks').val();

                    // console.log(remarks);

                    var myTab = document.getElementById('product_sample');
                    // var myTab = $("document #myTable");
                    // console.log('insert button clicked');
                    var tblData = myTab.rows;
                    // console.log(tblData);
                    var insertdata = [];
                    var tmpData = new Array();
                    // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
                    for (i = 1; i < myTab.rows.length - 1; i++) {

                        // GET THE CELLS COLLECTION OF THE CURRENT ROW.
                        var objCells = myTab.rows.item(i).cells;
                        // var objCells = myTab.rows.item(i);
                        // console.log(objCells);
                        tmpData[i - 1] = {
                            "i_code": objCells.item(2).innerHTML,
                            "item_name": objCells.item(3).innerHTML,
                            "stock": objCells.item(4).innerHTML,
                            "quant": objCells.item(5).innerHTML,
                            "price": objCells.item(6).innerHTML,
                            "total_price": objCells.item(7).innerHTML
                        };
                        insertdata.push(tmpData[i - 1]);
                        // console.log("TEST: ", tmpData[i - 1]);
                    }

                    // console.log('write ajax code here');

                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            insertdata: insertdata,
                            rm_terr: rm_terr,
                            am_terr: am_terr,
                            mpo_terr: mpo_terr,
                            emp_id: emp_id,
                            emp_name: emp_name,
                            type: sample_type,
                            version_no: version_no,
                            emp_no: emp_mobile,
                            req_month: req_month,
                            req_type: req_type,
                            remarks: remarks,
                            depo: depo,
                            _token: _csrf_token
                        },
                        url: insert_row,
                        beforeSend: function () {
                            // Show image container
                            $("#balance_section").hide();
                            $("#report-body").hide();
                            $("#loader").show();
                        },
                        success: function (data) {

                            $("table tbody tr").remove();
                            $(".total_price").val('');
                            $("#emp_id").val('');
                            $("#emp_name").val('');
                            $("#emp_no").val('');
                            $("#depo").val('');
                            $("#rm_terr").val('');
                            $("#am_terr").val('');
                            $("#mpo_terr").val('');
                            $("#remarks").val('');
                            $("#total_amount").text('');

                            $("#loader").hide();
                            filtered_row = [];


                        },
                        complete: function (data) {
                            // Hide image container
                            $("#loader_submit").hide();
                            $("#loader").hide();
                            toastr.success("The requisition has been completed.")


                        },
                        error: function (err) {
                            // console.log(err);
                            $("#loader").hide();
                        }
                    });
                }
            });
        });
    </script>
@endsection