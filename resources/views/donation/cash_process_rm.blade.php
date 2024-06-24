@extends('_layout_shared._master')
@section('title','Cash Process RM')
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
                       Cash Process RM
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

                                    <div class="row">

                                        @if( Auth::user()->desig == 'RM' || Auth::user()->desig == 'ASM' || Auth::user()->desig == 'HO')

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

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="am_terr"
                                                           class="col-md-3 control-label"><b>AM</b></label>
                                                    <div class="col-md-9">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="assigned"
                                                           class="col-md-5 control-label"><b>Assign Person</b></label>
                                                    <div class="col-md-7">
                                                        <select name="assigned" id="assigned"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif


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

    <div class="col-md-2" id="process" style="display:none; margin-bottom: 7px;" >

        <button type="button" id="process_button" class="btn btn-default btn-sm">
            <i class="fa fa-check"></i> <b>Process</b></button>
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
                                    <th>month</th>
                                    <th>req_id</th>
                                    <th>terr_id</th>
                                    <th>depot</th>
                                    <th>doctor_id</th>
                                    <th>beneficiary_name</th>
                                    <th>in_favour_of</th>
                                    <th>frequency</th>
                                    <th>amount</th>
                                    <th>purpose</th>
                                    <th>assigned_person</th>
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




    <script type="text/javascript">
        $(document).ready(function () {

            cash_summary_detail_data = "{{url('donation/cash_process_rm_data')}}";
            depot_list = "{{url('donation/depot_list_rm')}}";
            var insert_row = "{{url('donation/cash_process_rm_update')}}";

                _csrf_token = '{{csrf_token()}}';
                var table,table2;
            log_desig = '{{Auth::user()->desig}}';
            var verifydata = [];


            $("#bgt_month").on('change', function () {
                console.log('working properly');

                $('#depot').empty();
                $('#assigned').empty();
                var month = $("#bgt_month").val();

                console.log(month);

                $("#depot").empty().append("<option value='loader'>Loading...</option>");
                $("#assigned").empty().append("<option value='loader'>Loading...</option>");
                $("#am_terr").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: depot_list,
                    dataType: 'json',
                    data: {
                        _token: _csrf_token,
                        month: month},
                    success: function (response) {
                        console.log(response['assigned']);

                        var depot = response['depot'];
                        var assigned = response['assigned'];

                        var selOptsMPO = "";
                        selOptsMPO += "<option value=''>Select</option>";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < depot.length; j++) {
                            var id = depot[j]['d_id'];
                            var val = depot[j]['d_name'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#depot').empty().append(selOptsMPO);

                        var person = "";
                        person += "<option value=''>Select</option>";

                        for (var j = 0; j < assigned.length; j++) {
                            var id = assigned[j]['am'];
                            var val = assigned[j]['am'];
                            person += "<option value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#assigned').empty().append(person);

                        var am_terr_id = "";
                        am_terr_id += "<option value=''>Select</option>";

                        for (var j = 0; j < assigned.length; j++) {
                            var assign = assigned[j]['am'];
                            var id = assigned[j]['am_terr_id'];
                            var val = assigned[j]['am_terr_id'] + ' ' + assigned[j]['am_name'] ;
                            am_terr_id += "<option data-assign = '" + assign + "'  value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#am_terr').empty().append(am_terr_id);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            });

            $("#btn_display").click(function () {

                 if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }
                else if ($("#depot").val() === "") {
                    alert("Please select depot");
                }
                 // else if ($("#assigned").val() === "") {
                 //     alert("Please select Assigned Person");
                 // }
                 else if ($("#am_terr").val() === "") {
                     alert("Please select AM Territory");
                 }

                else {

                     $("#process_button").prop("disabled",false);

                    console.log(log_desig);
                     var month = $("#bgt_month").val();

                     var depot = $('#depot').val();
                     var am_terr = $('#am_terr').val();
                     // console.log(region);

                     if ($("#assigned").val() === ""){

                         var assigned = $("#am_terr option:selected").data('assign');

                         console.log(assigned);
                     }
                     else{
                         var assigned = $('#assigned').val();
                         console.log(assigned);
                     }


                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: cash_summary_detail_data,
                        data: {
                            month: month,
                            am_terr: am_terr,
                            assigned: assigned,
                            depot: depot,
                            _token: _csrf_token
                        },
                        success: function (data) {
                            console.log(data);

                            // table.columns.adjust();

                            $("#detail_cash_table").DataTable().destroy();

                            table2 = $("#detail_cash_table").DataTable({
                                data: data['resp_data'],
                                columns: [
                                    {data: "payment_month"},
                                    {data: "req_id"},
                                    {data: "terr_id"},
                                    {data: "depot"},
                                    {data: "doctor_id"},
                                    {data: "doctor_name"},
                                    {data: "in_favour_of"},
                                    {data: "frequency"},
                                    {data: "amount"},
                                    {data: "purpose"},
                                    {data: "assigned"}

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
                        "assigned": tablerows.assigned,
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


            }
        );



    </script>

@endsection