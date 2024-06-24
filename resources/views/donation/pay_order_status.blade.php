@extends('_layout_shared._master')
@section('title','Pay Order Status')
@section('styles')

    <link href="{{ url('public/site_resource/dist/slimselect.min.css')}}" rel="stylesheet" type="text/css"/>

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
                        Pay Order Status
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

                                    @if(Auth::user()->desig == 'HO')

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bgt_year"
                                                       class="col-md-4 control-label"><b>Year</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_year" id="bgt_year"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($year as $mn)
                                                            <option value="{{$mn->year}}">{{$mn->year}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="sum_id"
                                                       class="col-md-4 control-label"><b>Sum Id</b></label>
                                                <div class="col-md-8">
                                                    <select name="sum_id" id="sum_id"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                        <div class="row">

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="region"
                                                           class="col-md-1 control-label"><b>Region</b></label>
                                                    <div class="col-md-11">

                                                        <select name="region" id="region" multiple >

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-1">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display</b></button>
                                            </div>

                                        </div>

                                    @endif

                                    <div class="row">

                                        @if(Auth::user()->desig == 'RM' || Auth::user()->desig == 'ASM' )

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sum_id"
                                                           class="col-md-4 control-label"><b>Sum Id</b></label>
                                                    <div class="col-md-8">
                                                        <select name="sum_id" id="sum_id"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($sum_id as $mn)
                                                                <option value="{{$mn->summ_id}}">{{$mn->summ_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1" style = "display: none;">
                                                <div class="form-group">
                                                    <label for="region"
                                                           class="col-md-1 control-label"><b>Region</b></label>
                                                    <div class="col-md-11">

                                                        <select name="region" id="region" multiple >

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display</b></button>
                                            </div>

                                        @endif

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

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body" >
                        <div class="table-responsive">
                            <table id="req_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>

                                    <th>Depot</th>
                                    <th>Rm Terr</th>
                                    <th>RM Name</th>
                                    <th>Desig</th>
                                    <th>Pay Mode</th>
                                    <th>Sum ID</th>
                                    <th>SSD nopo</th>
                                    <th>ssd send date</th>
{{--                                    <th>RM nopo</th>--}}
{{--                                    <th>remarks</th>--}}
{{--                                    <th>receive date</th>--}}
                                    @if(Auth::user()->desig == 'RM' || Auth::user()->desig == 'ASM' )
                                        <th>RM receive</th>
                                    @else
                                    <th>SSD send</th>
                                   @endif
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

    {{Html::script('public/site_resource/dist/slimselect.min.js')}}

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
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    <script type="text/javascript">
        $(document).ready(function () {


                new SlimSelect({
                    select: '#region',
                    closeOnSelect: false
                })

                re_year = "{{url('scientific/sci_year')}}";
            pay_order_data = "{{url('donation/pay_order_data')}}";

            sum_id_list = "{{url('donation/sum_id_list')}}";
            region_list = "{{url('donation/region_list')}}";
            ssd_send = "{{url('donation/ssd_send')}}";
            rm_receive = "{{url('donation/rm_receive')}}";
                remark_update = "{{url('donation/remark_update')}}";
                _csrf_token = '{{csrf_token()}}';
                var table;
            log_desig = '{{Auth::user()->desig}}';


                $('#bgt_year').on('change', function () {
                    console.log('changed');

                    var year = $('#bgt_year').val();
                    $("#bgt_month").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        method: "post",
                        url: re_year,
                        data: {
                            _token: _csrf_token,
                            year: year
                        },
                        success: function (data) {
                            console.log(data);
                            // console.log(data.length);
                            if ((data.length) > 0) {
                                var op = '';

                                op += "<option value=''>Select</option>";
                                // op += "<option value='ALL'>ALL</option>";

                                for (var i = 0; i < data.length; i++) {
                                    op += '<option value= " ' + data[i]['payment_month'] + ' " >' + data [i]['payment_month'] + '</option>';
                                }
                                $('#bgt_month').html(" ");
                                $('#bgt_month').append(op);
                            }

                        },
                        error: function () {
                            console.log('fail');
                        }
                    });
                });

            $("#bgt_month").on('change', function () {
                console.log('working properly');

                $('#sum_id').empty();

                var month = $("#bgt_month").val();

                console.log(month);

                $("#sum_id").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: sum_id_list,
                    dataType: 'json',
                    data: {
                        _token: _csrf_token,
                        month: month},
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        selOptsMPO += "<option value=''>Select</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['summ_id'];
                            var val = response[j]['summ_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#sum_id').empty().append(selOptsMPO);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            });

            $("#sum_id").on('change', function () {

                $('#region').empty();

                var month = $("#bgt_month").val();
                var sum_id = $("#sum_id").val();

                console.log(month);

                $("#region").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: region_list,
                    dataType: 'json',
                    data: {
                        _token: _csrf_token,
                        month: month,
                        sum_id: sum_id
                    },
                    success: function (response) {
                        console.log(response);
                        var selOptsMPO = "";
                        // selOptsMPO += "<option value=''>Select</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['rm_terr_id'];
                            var val = response[j]['rm_terr_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#region').empty().append(selOptsMPO);

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
                else if ($("#sum_id").val() === "") {
                    alert("Please select summary Id");
                }
                else if ($("#region").val() === "") {
                    alert("Please select region");
                }

                else {


                    console.log(log_desig);
                    var month = $("#bgt_month").val();
                    var sum_id = $("#sum_id").val();
                     var region = $('#region').val();
                     console.log(region);
                     var implodedArray = '';

                     if(log_desig =='HO'){

                         var originalArray = region;

                         var separator = '\'' + ','  + '\'';


                         implodedArray = originalArray.join(`','`);

                         console.log(implodedArray);
                     }


                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: pay_order_data,
                        data: {
                            month: month,
                            sum_id: sum_id,
                            region: implodedArray,
                            _token: _csrf_token,

                        },
                        success: function (data) {
                            console.log(data);

                            $('#req_list').DataTable().destroy();

                             table = $('#req_list').DataTable({
                                data: data,
                                //   dom: 'Bfrtip',
                                //
                                // buttons: [
                                //
                                //     {
                                //         extend: 'excelHtml5', className: "btn-warning",
                                //         exportOptions: {
                                //             columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15]
                                //         }
                                //     }
                                //
                                // ],

                                columns: [
                                    {data: "depot_name"},
                                    {data: "rm_terr_id"},
                                    {data: "name"},
                                    {data: "desig"},
                                    {data: "payment_mode"},
                                    {data: "summ_id"},
                                    {data: "ssd_nopo"},
                                    {data: "ssd_send_date"},
                                    // {data: "rm_nopo"},
                                    // {data: null,
                                    //     "render": function (row) {
                                    //         return    '<input type="number"  class="rm_nopo" value="' + row.rm_nopo + '"  />';
                                    //
                                    //     }
                                    // },
                                    // {data: null,
                                    //     "render": function (row) {
                                    //         return    '<input type="text"  class="remarks" value="' + row.remarks + '"  />';
                                    //
                                    //     }
                                    // },
                                    // {data: "remarks", className:"editable"},
                                    // {data: "rm_received_date"},


                                    // {
                                    //     data: null,
                                    //
                                    //     "render": function (row) {
                                    //
                                    //         return "<button type='button' class='btn btn-danger btn-xs ssd_accept' id='ssd_accept'><span class='glyphicon glyphicon-ok'></span>  </button>" ;
                                    //
                                    //     }
                                    // },


                                    {
                                        data: null,

                                        "render": function (row) {

                                            if(log_desig =='HO'){

                                                return "<button type='button' class='btn btn-danger btn-xs ssd_accept' id='ssd_accept'><span class='glyphicon glyphicon-ok'></span>  </button>" ;
                                            }

                                            else{

                                                return "<button type='button' class='btn btn-danger btn-xs rm_accept' id='rm_accept'><span class='glyphicon glyphicon-ok'></span>  </button>" ;
                                            }



                                        }

                                    }
                                ],
                                ordering:false,
                                paging:false,
                                // filtering:false,
                                info:false,
                                searching:false,
                                // fixedHeader: true,
                                "scrollY": "450px",
                                "scrollX": true,
                                // "scrollCollapse": true
                            });
                            $("#loader").hide();

                            $("#report-body").show();
                            table.columns.adjust();
                        },
                        error: function () {
                            $("#loader").hide();
                            console.log('fail');
                        }

                    });

                }

            });

            $('#req_list tbody').on('click', '#ssd_accept', function () {

                 $(this).closest('tr').find('.ssd_accept').prop('disabled', true);

                if(log_desig == 'HO'){

                    var tblData = table.row($(this).parents('tr')).data();
                    console.log(tblData);
                    var tmpData = '';


                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            tblData: tblData,
                            _token: _csrf_token
                        },
                        url: ssd_send,
                        beforeSend: function () {
                            // Show image container
                            $("#loader").show();
                        },
                        success: function (data) {

                            $("#loader").hide();

                            if (data.error) {
                                toastr.error(data.error, '', {timeOut: 5000});
                            } else if (data.success) {
                                toastr.success(data.success, '', {timeOut: 5000});
                            }

                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });

                }
                else{
                    toastr.info('Your are not authorised');
                }


            });

            $('#req_list tbody').on('click', '#rm_accept', function () {

                $(this).closest('tr').find('.rm_accept').prop('disabled', true);

                // var rm_nopo = $(this).closest('tr').find('.rm_nopo').val();
                // var remarks = $(this).closest('tr').find('.remarks').val();
                // console.log(rm_nopo);
                // console.log(remarks);

                if(log_desig == 'RM' || log_desig == 'ASM'){

                    var tblData = table.row($(this).parents('tr')).data();
                    console.log(tblData);
                    var tmpData = '';


                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            tblData: tblData,
                            _token: _csrf_token
                        },
                        url: rm_receive,
                        beforeSend: function () {

                            $("#loader").show();
                        },
                        success: function (data) {

                            $("#loader").hide();

                            if (data.error) {
                                toastr.error(data.error, '', {timeOut: 5000});
                            } else if (data.success) {
                                toastr.success(data.success, '', {timeOut: 5000});
                            }

                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });

                }
                else{
                    toastr.info('Your are not authorised');
                }

            });


            }
        );



    </script>

@endsection