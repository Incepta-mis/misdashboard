@extends('_layout_shared._master')
@section('title','Sample Requisition Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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

        .btn-primary {
            margin-right: 10px;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/
            /*font-weight: bold;*/

        }

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Sample Requisition Report
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form method="post" class="form-horizontal" role="form"
                          action="{{url('dsr/sample_requisition_report_pdf')}}">
                        {{csrf_field()}}
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="req_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
                                                    <select name="req_month" id="req_month"
                                                            class="form-control input-sm" required>
                                                        <option value="">Select</option>
                                                        @foreach($month_name as $mn)
                                                            <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{--                                        <div class="col-md-4">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label for="depo"--}}
                                        {{--                                                       class="col-md-4 col-sm-6 control-label"><b>Brand--}}
                                        {{--                                                        Executive</b></label>--}}
                                        {{--                                                <div class="col-md-8">--}}
                                        {{--                                                    <select name="brand_ex" id="brand_ex"--}}
                                        {{--                                                            class="form-control input-sm">--}}
                                        {{--                                                        --}}{{--                                                        <option value="ALL">ALL</option>--}}
                                        {{--                                                    </select>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="rm_terr"
                                                       class="col-md-4 col-sm-6 control-label"><b>RM
                                                        Terr</b></label>
                                                <div class="col-md-8">
                                                    <select name="rm_terr" id="rm_terr"
                                                            class="form-control input-sm">
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="ALL">ALL</option>
                                                        @foreach($rm_terr as $rt)
                                                            <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        {{--                                        <div class="col-md-4">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label for="depo"--}}
                                        {{--                                                       class="col-md-4 col-sm-6 control-label"><b>Requisition--}}
                                        {{--                                                        Type</b></label>--}}
                                        {{--                                                <div class="col-md-8">--}}
                                        {{--                                                    <input type="text" name="requisition_type"--}}
                                        {{--                                                           class=" form-control" value="Special Promotion"--}}
                                        {{--                                                           autocomplete="off" id="requisition_type" readonly>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="am_terr"
                                                       class="col-md-4 col-sm-6 control-label"><b>Am
                                                        Terr</b></label>
                                                <div class="col-md-8">
                                                    <select name="am_terr" id="am_terr"
                                                            class="form-control input-sm">
                                                        {{--                                                        <option value="ALL">ALL</option>--}}
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
                                                        {{--                                                        <option value="ALL">ALL</option>--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" col-md-4" style="padding: 0 90px;">
                                            <button type="button" id="display_data_dsr_report"
                                                    class="btn btn-default btn-sm"
                                                    style="width: 100%; margin: auto;">
                                                <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                            </button>
                                            {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
                                        </div>

                                    </div>

                                    {{--                                    <div class="row">--}}

                                    {{--                                        <div class="col-md-4 col-sm-2 ">--}}
                                    {{--                                            <div class="form-group">--}}
                                    {{--                                                <label for="pcode"--}}
                                    {{--                                                       class="col-md-4 col-sm-6 control-label"><b>Emp ID</b></label>--}}
                                    {{--                                                <div class="col-md-8">--}}

                                    {{--                                                    <input type="text" name="emp_id" id="emp_id" class="form-control"--}}
                                    {{--                                                           type="text" readonly>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    {{--                                        <div class="col-md-4">--}}
                                    {{--                                            <div class="form-group">--}}
                                    {{--                                                <label for="depo"--}}
                                    {{--                                                       class="col-md-4 col-sm-6 control-label"><b>Emp Name</b></label>--}}
                                    {{--                                                <div class="col-md-8">--}}
                                    {{--                                                    <input type="text" name="emp_name"--}}
                                    {{--                                                           class=" form-control"--}}
                                    {{--                                                           autocomplete="off" id="emp_name" readonly>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    {{--                                        <div class="col-md-4">--}}
                                    {{--                                            <div class="form-group">--}}
                                    {{--                                                <label for="docid"--}}
                                    {{--                                                       class="col-md-4 col-sm-6 control-label"><b>Emp Number</b></label>--}}
                                    {{--                                                <div class="col-md-8">--}}
                                    {{--                                                    <input type="text" name="emp_no"--}}
                                    {{--                                                           class=" form-control"--}}
                                    {{--                                                           autocomplete="off" id="emp_no" readonly>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                </div>
                            </div>
                        </div>

                        {{--                        <div class="col-md-2" id="print_advice">--}}
                        {{--                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                        {{--                                <button type="submit" id="print_bank_advice" class="btn btn-default btn-sm">--}}
                        {{--                                    <i class="fa fa-check"></i> <b>Print/View Pdf</b></button>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                    </form>
                </div>
            </section>
        </div>
    </div>

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
    {{--Modal starts from here--}}

    <div class="row" id="detail-body" style="display: none">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    {{--                    <div class="col-md-2" id="print_advice">--}}
                    {{--                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                    {{--                            <button type="submit" id="print_bank_advice" class="btn btn-default btn-sm">--}}
                    {{--                                <i class="fa fa-check"></i> <b>Print/View Pdf</b></button>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detail_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>REQ_ID</th>
                                    <th>RM TERR ID</th>
                                    <th>AM TERR ID</th>
                                    <th>MPO TERR ID</th>
                                    <th>ITEM ID</th>
                                    <th>ITEM NAME</th>
                                    <th>QTY</th>
                                    <th>UNIT PRICE</th>
                                    <th>TOT_VALUE</th>
                                    <th>VERIFIED BY</th>
                                    <th>APPROVED BY</th>
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

    {{--    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">--}}
    {{--        <div class="modal-dialog">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-body">--}}

    {{--                    <input type="hidden" class="form-control" id="line_id" name="line_id">--}}

    {{--                    <div class="form-horizontal">--}}
    {{--                        <form role="form" id="edfrm">--}}
    {{--                            <div class="row">--}}
    {{--                                <div class="col-sm-12 col-md-12">--}}
    {{--                                    <div class="col-md-12">--}}
    {{--                                        <section class="panel panel-info" id="data_table">--}}
    {{--                                            <header class="panel-heading">--}}
    {{--                                                <label class="text-default">--}}
    {{--                                                    Sample Requisition--}}
    {{--                                                </label>--}}
    {{--                                                <button aria-hidden="true"--}}
    {{--                                                        style="background-color: red; opacity: initial"--}}
    {{--                                                        data-dismiss="modal" class="close" type="button">×--}}
    {{--                                                </button>--}}
    {{--                                            </header>--}}

    {{--                                            <div class="panel-body">--}}


    {{--                                                <div class="row">--}}

    {{--                                                    <div class="col-md-10">--}}
    {{--                                                        <div class="form-group">--}}
    {{--                                                            <label for="p_code"--}}
    {{--                                                                   class="col-md-5 col-sm-5 control-label"><b>Item--}}
    {{--                                                                    Code</b></label>--}}
    {{--                                                            <div class="col-md-7">--}}
    {{--                                                                <input class="form-control input-sm" name="item_id"--}}
    {{--                                                                       id="item_id" autocomplete="off" disabled>--}}
    {{--                                                            </div>--}}
    {{--                                                        </div>--}}
    {{--                                                    </div>--}}

    {{--                                                </div>--}}

    {{--                                                <div class="row">--}}

    {{--                                                    <div class="col-md-10">--}}
    {{--                                                        <div class="form-group">--}}
    {{--                                                            <label for="sp_amount"--}}
    {{--                                                                   class="col-md-5 col-sm-5 control-label fnt_size"><b>Item--}}
    {{--                                                                    Name</b></label>--}}
    {{--                                                            <div class="col-md-7 col-sm-7">--}}
    {{--                                                                <input type="text" min="1"--}}
    {{--                                                                       class="form-control input-sm" name="item_name"--}}
    {{--                                                                       id="item_name" autocomplete="off" disabled>--}}
    {{--                                                                <input type="hidden" min="1"--}}
    {{--                                                                       class="form-control input-sm" name="unit_price"--}}
    {{--                                                                       id="unit_price" autocomplete="off" disabled>--}}
    {{--                                                                <input type="hidden" min="1"--}}
    {{--                                                                       class="form-control input-sm" name="req_id"--}}
    {{--                                                                       id="req_id" autocomplete="off" disabled>--}}
    {{--                                                            </div>--}}
    {{--                                                        </div>--}}
    {{--                                                    </div>--}}
    {{--                                                </div>--}}


    {{--                                                <div class="row">--}}

    {{--                                                    <div class="col-md-10">--}}
    {{--                                                        <div class="form-group">--}}
    {{--                                                            <label for="apr_amount"--}}
    {{--                                                                   class="col-md-5 col-sm-5 control-label"><b>Approved--}}
    {{--                                                                    Quantity</b></label>--}}
    {{--                                                            <div class="col-md-7">--}}
    {{--                                                                <input type="number" min="1"--}}
    {{--                                                                       oninput="validity.valid||(value='');"--}}
    {{--                                                                       class="form-control input-sm" name="apr_amount"--}}
    {{--                                                                       id="apr_amount" autocomplete="off">--}}

    {{--                                                            </div>--}}
    {{--                                                        </div>--}}
    {{--                                                    </div>--}}

    {{--                                                </div>--}}

    {{--                                                <div class="row">--}}
    {{--                                                    <div class="col-md-10">--}}
    {{--                                                        <div class="form-group">--}}
    {{--                                                            <label for="total_amount"--}}
    {{--                                                                   class="col-sm-5 col-md-5 control-label fnt_size"><b>Total--}}
    {{--                                                                    Value</b></label>--}}
    {{--                                                            <div class="col-md-7 col-sm-7">--}}
    {{--                                                                <input type="number" min="1"--}}
    {{--                                                                       class="form-control input-sm" name="total_amount"--}}
    {{--                                                                       id="total_amount" autocomplete="off" disabled>--}}

    {{--                                                            </div>--}}
    {{--                                                        </div>--}}
    {{--                                                    </div>--}}
    {{--                                                </div>--}}


    {{--                                            </div>--}}


    {{--                                        </section>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="modal-footer">--}}
    {{--                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
    {{--                                <button type="button" class="btn btn-primary" id="update">Submit</button>--}}
    {{--                            </div>--}}
    {{--                        </form>--}}
    {{--                    </div>--}}

    {{--                    --}}{{--<div class="modal-footer">--}}
    {{--                    --}}{{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
    {{--                    --}}{{--<button type="submit" class="btn btn-primary" >Submit</button>--}}
    {{--                    --}}{{--</div>--}}
    {{--                </div>--}}
    {{--            </div>--}}


    {{--        </div>--}}


    {{--    </div>--}}
    {{--    @include('donation.modal.delete_sample_requisition_modal')--}}
    {{--Modal ends here--}}
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

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

        var table2;
        $(document).ready(function () {

            $('#print_bank_advice').attr('formtarget', '_blank');

            servloc_tid = "{{url('dsr/getMpoTerr_DMR')}}";
            be_and_terr = "{{url('dsr/be_and_terr_dsr')}} ";
            display_data_dsr_report = "{{url('dsr/display_data_dsr_report')}}";
            {{--verify_row_dsr = "{{url('dsr/verify_row_dsr')}}";--}}
            {{--delete_row_dsr = "{{url('dsr/delete_row_dsr')}}";--}}
            {{--update_row_dsr = "{{url('dsr/update_row_dsr')}}";--}}
            {{--emp_access_status = "{{url('dsr/emp_access_status')}}";--}}

            $("#rm_terr").on('change', function () {
                console.log($(this).val());

                $.ajax({
                    type: "post",
                    url: '{{url('dsr/get_am_terr')}}',
                    data: {
                        rm_terr: $(this).val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        if (response) {
                            var selOptsMPO = '';
                            selOptsMPO += "<option value=''>Select</option>";
                            selOptsMPO += "<option value='ALL'>ALL</option>";
                            for (var j = 0; j < response.length; j++) {
                                var id = response[j]['am_terr_id'];
                                var val = response[j]['am_terr_id'];
                                selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                            }

                            $('#am_terr').empty().append(selOptsMPO);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $("#am_terr").on('change', function () {
                $('#brnd_ex').empty();
                $('#docid').empty();
                $("#doc_info").hide();
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
                        selOptsMPO += "<option value=''>Select</option>";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response.mpo_terr.length; j++) {
                            var id = response.mpo_terr[j]['mpo_terr_id'];
                            var val = response.mpo_terr[j]['mpo_terr_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#mpo_terr').empty().append(selOptsMPO);
                        console.log(response.am_info);
                        // $("#emp_id").val(response.am_info[0].emp_id);
                        // $("#emp_name").val(response.am_info[0].sur_name);
                        // $("#emp_no").val(response.am_info[0].emp_contact_no);

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


                var brand_executive = $("#brand_ex").val();

                $.ajax({
                    type: "post",
                    url: be_and_terr,
                    dataType: 'json',
                    data: {
                        mpo_terr: mpo_terr,
                        brand_executive: brand_executive,
                        type_am_mpo: 'mpo',
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);

                        // $("#emp_id").val(response.mpo_terr[0].emp_id);
                        // $("#emp_name").val(response.mpo_terr[0].sur_name);
                        // $("#emp_no").val(response.mpo_terr[0].emp_contact_no);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });


            });

            {{--$(window).on('load', function () {--}}

            {{--    $.ajax({--}}
            {{--        type: "post",--}}
            {{--        url: be_and_terr,--}}
            {{--        dataType: 'json',--}}
            {{--        data: {--}}
            {{--            _token: '{{csrf_token()}}'--}}
            {{--        },--}}
            {{--        success: function (response) {--}}
            {{--            console.log('executed');--}}
            {{--            console.log(response);--}}
            {{--            var selOptsBE = "";--}}

            {{--            selOptsBE += "<option value='' disabled selected>Select Brand Executive</option>";--}}
            {{--            selOptsBE += "<option value='ALL'>ALL</option>";--}}
            {{--            for (var j = 0; j < response.brand_executive.length; j++) {--}}
            {{--                selOptsBE += "<option value='" + response.brand_executive[j].id_name + "'>" + response.brand_executive[j].id_name + "</option>";--}}
            {{--            }--}}

            {{--            $('#brand_ex').empty().append(selOptsBE);--}}

            {{--        }--}}
            {{--    })--}}
            {{--});--}}


            // $('#detail_list tbody').on('click', '.edit-btn', function () {
            //     console.log(' .edit-btn button clicked');
            //     var line_id = '';
            //     console.log(table2.row($(this).parents('tr')).data());
            //
            //     line_id = table2.row($(this).parents('tr')).data()['req_id'];
            //     row_html = $(this).closest('tr');
            //     // console.log(row_html.html(500));
            //
            //     // var line_id = $(this).closest('tr').find('.req').text();
            //     console.log(line_id);
            //
            //     $("#myModal").modal('show');
            //
            //     $(".modal-body #line_id").val(line_id);
            //
            //
            //     //codes for showing the already inputted value in modal
            //     $('#item_id').val(table2.row($(this).parents('tr')).data()['item_id']);
            //     $('#item_name').val(table2.row($(this).parents('tr')).data()['item_name']);
            //     $('#apr_amount').val(table2.row($(this).parents('tr')).data()['qty']);
            //     $('#total_amount').val(table2.row($(this).parents('tr')).data()['tot_value']);
            //     $('#unit_price').val(table2.row($(this).parents('tr')).data()['unit_price']);
            //     $('#req_id').val(table2.row($(this).parents('tr')).data()['req_id']);
            //
            //     console.log("Unit Price ", table2.row($(this).parents('tr')).data()['unit_price'])
            //     //This portion is for selecting mode of payment
            //
            //     // the first option value in select tag
            //
            //     // portion for selecting mode of payment ends here
            //
            //     // $('#inf_of').val(table.row($(this).parents('tr')).data()['in_favour_of']);
            //
            //
            // });

            $("#display_data_dsr_report").click(function () {
                del_row_id = '';

                if ($("#rm_terr").val() === "") {
                    alert("Please select RM");
                } else if ($("#am_terr").val() === "") {
                    alert("Please select AM");
                } else if ($("#mpo_terr").val() === "") {
                    alert("Please select MPO");
                } else if ($("#req_month").val() === "") {
                    alert("Please select Month");
                } else {

                    var req_month = $("#req_month").val();
                    var rm_terr = $("#rm_terr").val();
                    var am_terr = $("#am_terr").val();
                    var mpo_terr = $("#mpo_terr").val();
                    // var brand_executive = $("#brand_ex").val();

                    console.log(req_month);
                    console.log(rm_terr);
                    console.log(am_terr);
                    console.log(mpo_terr);
                    // console.log(brand_executive.split(' ')[0]);

                    $("#loader").show();

                    $.ajax({
                        url: display_data_dsr_report,
                        method: "post",
                        dataType: 'json',
                        data: {
                            _token: '{{csrf_token()}}',
                            rmTerr: rm_terr,
                            amTerr: am_terr,
                            mpoTerr: mpo_terr,
                            reqMonth: req_month
                        },

                        success: function (response) {
                            console.log("response: ", response);

                            $("#loader").hide();
                            $("#report-body").show();
                            $("#detail_list").DataTable().destroy();

                            $("#detail-body").show();

                            $("#detail_list").DataTable().destroy();

                            table2 = $("#detail_list").DataTable({
                                data: response['summary_data'],
                                dom: '<"toolbar">Bfrtip',
                                buttons: [
                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                                        }
                                    }
                                ],
                                columns: [
                                    {data: "req_id"},
                                    {data: "rm_terr_id"},
                                    {data: "am_terr_id"},
                                    {data: "mpo_terr_id"},
                                    {data: "item_id"},
                                    {data: "item_name"},
                                    {data: "qty"},
                                    {data: "unit_price"},
                                    {data: "tot_value"},
                                    {
                                        data: "verified_id",
                                        "render": function (verified_id) {
                                            console.log("verified_id ", verified_id);
                                            if (verified_id === '' || verified_id === null) {
                                                return 'NO';
                                            } else if (verified_id !== '' || verified_id !== null) {
                                                return 'YES';
                                            } else {
                                                return 'Default';
                                            }
                                        }
                                    },
                                    {
                                        data: "approved_id",
                                        "render": function (approved_id) {
                                            console.log("approved_id ", approved_id);
                                            if (approved_id === '' || approved_id === null) {
                                                return 'NO';
                                            } else if (approved_id !== '' || approved_id !== null) {
                                                return 'YES';
                                            } else {
                                                return 'Default';
                                            }
                                        }
                                    }

                                ],

                                // fixedHeader: {
                                //     header: true,
                                //     headerOffset: $('#fix').height()
                                // },
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                // columnDefs: [{
                                //     orderable: false,
                                //     className: 'select-checkbox',
                                //     targets: 0,
                                //     render: function (data, type, full, meta) {
                                //
                                //         // console.log(data);
                                //         return '';
                                //     }
                                // },
                                //     {
                                //         "targets": [1],
                                //         "visible": false,
                                //         "searchable": false
                                //     }
                                // ],

                                select: {
                                    style: 'multi',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ],
                                info: false,
                                paging: true,
                                // filter: true,

                            });

                        }
                    })
                }
            });

            // $('#selectAll').on('click', function () {
            //
            //     if (table2.rows('.selected').any()) {
            //         table2.rows().deselect();
            //         $("#selectAll").prop("checked", false);
            //     } else {
            //         table2.rows().select();
            //     }
            //
            // });

            // $('.del-modal-requisition').click(function () {
            //     console.log('modal delete button clicked');
            //
            //     // data table row select
            //     var tblData = table2.rows('.selected').data();
            //     var tmpData = '';
            //
            //     verifydata.length = 0;
            //
            //     $.each(tblData, function (i, val) {
            //         tmpData = tblData[i];
            //         verifydata.push(tmpData);
            //         // console.log(tmpData);
            //         //alert(tmpData);
            //     });
            //
            //     console.log(verifydata);
            //
            //     if (verifydata.length !== 0) {
            //
            //         $.ajax({
            //             type: "POST",
            //             dataType: 'json',
            //             data: {
            //                 verifyData: JSON.stringify(verifydata),
            //                 _token: _csrf_token
            //             },
            //             url: delete_row_dmr,
            //             beforeSend: function () {
            //                 // Show image container
            //                 // $("#report-body").hide();
            //                 $("#loader").show();
            //             },
            //             success: function (data) {
            //                 $('.deleteRequisitioin').modal('hide');
            //                 del_row_id = table2.rows('.selected');
            //                 console.log(del_row_id);
            //                 del_row_id.remove().draw();
            //
            //
            //                 // updateTable();// For reloading the updated table after verifying data
            //                 console.log("data " + data);
            //                 if (data.error) {
            //                     toastr.error(data.error, '', {timeOut: 5000});
            //                 } else if (data.success) {
            //                     toastr.success(data.success, '', {timeOut: 5000});
            //                 }
            //             },
            //             complete: function (data) {
            //                 // Hide image container
            //                 $("#loader").hide();
            //             },
            //             error: function (err) {
            //                 console.log(err);
            //             }
            //         });
            //     }
            //
            //
            // });
            //
            // $(".toggle-btn").click(function () {
            //     table.columns.adjust();
            //     table2.columns.adjust();
            // });
            //
            // $(document).on('keypress', '#apr_amount', function (event) {
            //
            //     if (event.keyCode === 13) {
            //
            //
            //         // $('#item_id').val(table2.row($(this).parents('tr')).data()['item_id']);
            //
            //         var quantity = event.target.value;
            //         var unit_price = $('#unit_price').val();
            //         var total_value = quantity * unit_price;
            //         var total_value2 = total_value.toFixed(2);
            //
            //         // console.log("unit_price ", unit_price);
            //         // console.log("quantity ", quantity);
            //         // console.log("tr ", tr);
            //
            //         $('#total_amount').val(total_value2);
            //
            //     }
            // });

        });

        {{--$('form#edfrm').on('click', '#update', function (e) {--}}

        {{--    var approved_quantity = $('#apr_amount').val();--}}
        {{--    var total_value = $('#total_amount').val();--}}
        {{--    var req_id = $('#req_id').val();--}}
        {{--    var item_id = $('#item_id').val();--}}

        {{--    // console.log(quantity);--}}
        {{--    // console.log(total_value);--}}
        {{--    // console.log(req_id);--}}
        {{--    // console.log(item_id);--}}
        {{--    e.preventDefault();--}}
        {{--    // $( "#update").unbind( "click" );--}}

        {{--    if ($('#apr_amount').val() == '' || parseInt($('#apr_amount').val()) < 1) {--}}
        {{--        alert('Invalid Quantity !!! ');--}}
        {{--    } else if ($('#total_amount').val() == '') {--}}
        {{--        alert('Total can not be empty !!! ');--}}
        {{--    } else {--}}

        {{--        $.ajax({--}}
        {{--            type: "post",--}}
        {{--            url: update_row_dsr,--}}
        {{--            dataType: 'json',--}}
        {{--            data: {--}}
        {{--                req_id: req_id,--}}
        {{--                qty: approved_quantity,--}}
        {{--                item_id: item_id,--}}
        {{--                tot_value: total_value,--}}
        {{--                _token: '{{csrf_token()}}'--}}
        {{--            },--}}
        {{--            success: function (response) {--}}


        {{--                row_html.find('.app_quant').html(approved_quantity);--}}
        {{--                row_html.find('.total_value').html(total_value);--}}

        {{--                $('#myModal').modal('hide');--}}
        {{--                toastr.success("updated successfully");--}}
        {{--            },--}}
        {{--            error: function (data) {--}}
        {{--                // console.log(data);--}}
        {{--                toastr.error("Error updating row");--}}
        {{--            }--}}
        {{--        });--}}

        {{--    }--}}


        {{--});--}}

    </script>

@endsection