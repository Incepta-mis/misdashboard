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

                                        <div class="col-md-4">
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
                                    <th>Month</th>
                                    <th>GL</th>
                                    <th>Cost Center</th>
                                    <th>Depot Id</th>
                                    <th>Depot Name</th>
                                    <th>Territory Name</th>
                                    <th>NOS</th>
                                    <th>Total Amount</th>
                                    <th>Send Email</th>

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

    <div class="row" id="detail_table" style="display:none ;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body" >
                        <div class="table-responsive">
                            <table id="detail_cash_table" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Month</th>
                                    <th>summ id</th>
                                    <th>ref no</th>
                                    <th>fi_doc_no</th>
                                    <th>req_id</th>
                                    <th>beneficiary name</th>
                                    <th>in_favour_of</th>
                                    <th>frequency</th>
                                    <th>amount</th>
                                    <th>purpose</th>
                                    <th>budget_owner</th>
                                    <th>depot</th>
                                    <th>terr_id</th>
                                    <th>am</th>
                                    <th>rm</th>

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
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}



    <script type="text/javascript">
        $(document).ready(function () {

            cash_summary_detail_data = "{{url('donation/cash_summary_detail_data')}}";
            fi_doc_list = "{{url('donation/fi_doc_list')}}";
            depot_list = "{{url('donation/depot_list')}}";

            var insert_row = "{{url('donation/cash_insert_data')}}";

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
                     // console.log(region);

                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: cash_summary_detail_data,
                        data: {
                            month: month,
                            fi_doc: fi_doc,
                            depot: depot,
                            _token: _csrf_token
                        },
                        success: function (data) {
                            console.log("displayt data=")
                            console.log(data);

                            $('#cash_sum_table').DataTable().destroy();

                             table = $('#cash_sum_table').DataTable({
                                 data: data['dis_sum'],

                                columns: [
                                    {data: "payment_month"},
                                    {data: "gl"},
                                    {data: "cc"},
                                    {data: "d_id" },
                                    {data: "d_name"},
                                    {data: "terr_id"},
                                    {data: "tnor"},
                                    {data: "total_value"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return '<button class="btn btn-sm btn btn-info row-edit dt-center" id="' + row.d_id +'" ' +
                                                'onclick="sendMail('+"'"+row.d_id+"','"+row.total_value+"','"+row.terr_id+"','"+row.ref_no+"','"+row.d_name+"')"+'">Send Email</button>'
                                        }
                                    }
                                ],
                                ordering:false,
                                paging:false,
                                // filtering:false,
                                info:false,
                                searching:false,
                                // fixedHeader: true,
                                // "scrollY": "450px",
                                // "scrollX": true,
                                // "scrollCollapse": true
                            });
                            // $("#loader").hide();


                            // table.columns.adjust();

                            $("#detail_cash_table").DataTable().destroy();
                            table2 = $("#detail_cash_table").DataTable({
                                data: data['resp_data'],
                                columns: [
                                    {data: "payment_month"},
                                    {data: "summ_id"},
                                    {data: "ref_no"},
                                    {data: "fi_doc_no"},
                                    {data: "req_id"},
                                    {data: "doctor_name"},
                                    {data: "in_favour_of"},
                                    {data: "frequency"},
                                    {data: "donation_amount"},
                                    {data: "purpose"},
                                    {data: "budget_owner"},
                                    {data: "depot"},
                                    {data: "terr_id"},
                                    {data: "am_name"},
                                    {data: "rm_asm"},

                                ],

                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },

                                info: false,
                                paging: false,
                                filter: false,
                                "scrollY": "450px",
                                "scrollX": true,
                                // "scrollCollapse": true,

                            });
                            $("#loader").hide();
                            $("#sum_portion").show();
                            $("#detail_table").show();
                            $("#process").show();
                            table2.columns.adjust();


                        },
                        error: function () {
                            $("#loader").hide();
                            console.log('fail');
                        }

                    });
                }

            });

            $("#process_button").click(function () {

                $("#process_button").prop("disabled",true);

                var tablength = table2.rows().count();
                console.log(tablength);
                var tblData = table2.rows().data();
                var insertdata = [];
                var tmpData = new Array();

                for (i = 0; i < tablength ; i++) {

                     var tablerows = tblData[i];
                    // console.log(tablerows.req_id);

                    tmpData[i] = {
                        "month": tablerows.payment_month,
                        "request_id": tablerows.req_id
                    }
                    insertdata.push(tmpData[i]);
                    // console.log(tmpData[i]);
                }

                console.log(insertdata);

                if (insertdata.length !== 0) {

                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            insertdata: JSON.stringify(insertdata),
                            _token: _csrf_token
                        },
                        url: insert_row,
                        beforeSend: function () {
                            // Show image container
                            // $("#balance_section").hide();
                            // $("#report-body").hide();
                            $("#loader").show();
                        },
                        success: function (data) {

                            // $("table tbody tr").remove();

                            console.log("data " + data);
                            if (data.error) {
                                toastr.error(data.error, '', {timeOut: 5000});
                            } else if (data.success) {
                                toastr.success(data.success, '', {timeOut: 5000});
                            }

                            $("#loader").hide();

                            // setTimeout(function(){// wait for 3 secs
                            //     window.location.reload(); // then reload the page
                            // }, 3000);

                        },
                        complete: function (data) {
                            // Hide image container
                            $("#loader").hide();

                        },
                        error: function (err) {
                            console.log(err);
                            $("#loader").hide();
                        }
                    });
                }

            });

            $(".toggle-btn").click(function () {
                table2.columns.adjust();
            });


            });
        function sendMail(d_id,total_value,terr_id,ref_no,d_name){



            $.ajax({
                type: "post",
                url: '{{url('donation/send_email')}}',
                dataType: 'json',
                data: {
                    _token: _csrf_token,
                    d_id: d_id,
                    total_value: total_value,
                    terr_id: terr_id,
                    ref_no: ref_no

                },
                success: function (response) {
                    console.log("testing sayla=")
                    console.log(response)

                    if(response == 'success'){
                        $("#"+ d_id ).prop("disabled", true);
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                            text: 'Mail send successfully',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        })
                    }else if(response == 'null'){
                        Swal.fire({
                            title: "Oops..",
                            icon: "error",
                            text: 'Mail Send Failed, Mail Address Missing of This Depot and Territory',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        })
                    }

                    else{
                        Swal.fire({
                            title: "Oops...",
                            icon: "error",
                            text: 'Mail Send Failed',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok'
                        })

                    }
                },
                error: function (data) {
                    Swal.fire({
                        title: "Oops...",
                        icon: "error",
                        text: 'Mail Send Failed',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })
                }
            });

        }

    </script>

@endsection