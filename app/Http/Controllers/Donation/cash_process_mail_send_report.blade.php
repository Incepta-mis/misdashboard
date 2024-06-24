@extends('_layout_shared._master')
@section('title','Cash Process')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .swal2-popup {
            font-size: 12px !important;
        }
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
                        Cash Process
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($month as $mt)
                                                            <option value="{{$mt->monthname}}">{{$mt->monthname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fi_doc"
                                                       class="col-md-4 control-label"><b>FI Doc No</b></label>
                                                <div class="col-md-8">
                                                    <select name="fi_doc" id="fi_doc"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        <option value="ALL">ALL</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="depot"
                                                       class="col-md-4 control-label"><b>Depot</b></label>
                                                <div class="col-md-8">
                                                    <select name="depot" id="depot"
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

                                        <div class="col-md-1">
                                            <div id="export_buttons">
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
            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                <div id="export_buttons">
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="sum_portion" style="display:none ;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body" >
                        <div class="table-responsive">
                            <table id="cash_sum_table" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>REF#</th>
                                    <th>Ben Information</th>
                                    <th>DESIG</th>
                                    <th>Mail Id</th>
                                    <th>Depot Name</th>
                                    <th>Amount to be Transferred</th>
                                    <th>Authorised Person</th>
                                    <th>DEG AP</th>
                                    <th>Issued By</th>
                                    <th>Process Date</th>
                                    <th>Sum ID</th>
                                    <th>CC Code</th>
                                    <th>CC Owner</th>
                                    <th>Confirmation Person</th>

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
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}



    <script type="text/javascript">
        $(document).ready(function () {

            cash_process_mail_report = "{{url('donation/cash_process_mail_display_data')}}"

            fi_doc_list = "{{url('donation/fi_doc_list')}}";
            depot_list = "{{url('donation/depot_list')}}";

            _csrf_token = '{{csrf_token()}}';
            var table,table2;
            log_desig = '{{Auth::user()->desig}}';
            var verifydata = [];


            $("#bgt_month").on('change', function () {
                console.log('working properly');

                $('#fi_doc').empty();

                var month = $("#bgt_month").val();

                console.log(month);

                $("#fi_doc").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: fi_doc_list,
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
                            var id = response[j]['fi_doc_no'];
                            var val = response[j]['summ_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + '   -  ' + id + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#fi_doc').empty().append(selOptsMPO);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            });

            $("#fi_doc").on('change', function () {

                $('#depot').empty();

                var month = $("#bgt_month").val();
                var fi_doc = $('#fi_doc').val();

                console.log(month);

                if($("#fi_doc").val()== 'ALL'){

                    $("#depot").empty().append("<option value='ALL'>ALL</option>");
                }

                else{

                    $("#depot").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        type: "post",
                        url: depot_list,
                        dataType: 'json',
                        data: {
                            _token: _csrf_token,
                            month: month,
                            fi_doc: fi_doc
                        },
                        success: function (response) {
                            console.log("testing sayla=")
                            console.log(response);
                            var selOptsMPO = "";
                            // selOptsMPO += "<option value=''>Select</option>";
                            selOptsMPO += "<option value='ALL'>ALL</option>";
                            for (var j = 0; j < response.length; j++) {
                                var id = response[j]['d_id'];
                                var val = response[j]['depot_name'];
                                selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#depot').empty().append(selOptsMPO);

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
                else if ($("#fi_doc").val() === "") {
                    alert("Please select Fi Doc no");
                }
                else if ($("#depot").val() === "") {
                    alert("Please select depot");
                }

                else {

                    $("#process_button").prop("disabled",false);
                    console.log(log_desig);
                    var month = $("#bgt_month").val();
                    var fi_doc = $('#fi_doc').val();
                    var depot = $('#depot').val();


                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: cash_process_mail_report,
                        data: {
                            month: month,
                            fi_doc: fi_doc,
                            depot: depot,
                            _token: _csrf_token
                        },
                        success: function (data) {
                            console.log("mail report data=")
                            console.log(data);

                            $("#loader").hide();
                            $("#sum_portion").show();
                            $('#cash_sum_table').DataTable().destroy();

                            table = $('#cash_sum_table').DataTable({
                                data: data['resp_data'],
                                columns: [
                                    {data: "ref_no"},
                                    {data: "ben_name"},
                                    {data: "ben_desig"},
                                    {data: "ben_email" },
                                    {data: "d_name"},
                                    {data: "total_value"},
                                    {data: "authorised_person"},
                                    {data: "auth_desig"},
                                    {data: "issued_by"},
                                    {data: "mail_time"},
                                    {data: "summ_id"},
                                    {data: "cc_code"},
                                    {data: "cc_owner"},
                                    {data: "fi_person"},

                                ],
                                columnDefs: [
                                    {
                                        "defaultContent": " ",
                                        "targets": "_all",
                                    }
                                ],
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                info: true,
                                paging: false,
                                filter: true,

                                select: {
                                    style: 'os',
                                    selector: 'td:first-child'
                                }

                            });

                            table.fixedHeader.enable();

                            new $.fn.dataTable.Buttons(table, {
                                buttons: [
                                    {
                                        extend: 'collection',
                                        text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                        buttons: [
                                            {
                                                extend: 'excel',
                                                text: 'Save As Excel',
                                                footer: true,
                                                exportOptions: {
                                                    columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12]
                                                },
                                                action: function (e, dt, node, config) {
                                                    exportExtension = 'Excel';
                                                    $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                                }
                                            }, {
                                                extend: 'pdf',
                                                text: 'Save As PDF',
                                                orientation: 'landscape',
                                                footer: true,
                                                exportOptions: {
                                                    columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12]
                                                },
                                                customize : function(doc){
                                                    doc.content[1].table.widths =
                                                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                                },
                                                action: function (e, dt, node, config) {
                                                    exportExtension = 'PDF';
                                                    $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                                }
                                            }
                                        ],
                                        className: 'btn btn-sm btn-primary'
                                    }
                                ]
                            }).container().appendTo($('#export_buttons'));


                        },
                        error: function () {
                            $("#loader").hide();
                            console.log('fail');
                        }
                    });
                }
            });

            $(".toggle-btn").click(function () {
                table2.columns.adjust();
            });


        });


    </script>

@endsection