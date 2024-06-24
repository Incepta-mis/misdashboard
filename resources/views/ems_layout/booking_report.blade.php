@extends('_layout_shared._master')
@section('title','Booking Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/select2/select2.min.css')}}">
    {{-- <link rel="stylesheet" href="{{url('public/site_resource/css/tree-style.css')}}">--}}

    <style>
        .booking_details_component {
            margin: 10px 0;
            padding-left: 0;
            padding-right: 0;
        }
        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 12px;
        }

        body {
            color: black;
        }

        .btnapprove_dorm {
            border-radius: 5px;
            background-color: #3B9F00;
            border: none;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            padding: 6px;
            width: 72px;
            transition: all 0.5s;
            cursor: pointer;
        }

        .btnapprove_dorm span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
            padding-right: 15px
        }

        .btnapprove_dorm span:after {
            content: '\2714';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -4px;
            transition: 0.5s;
        }

        .btnapprove_dorm:hover span:after {
            opacity: 1;
            right: 0;
        }

    </style>
@endsection

@section('right-content')
    <div class="text-center" style="padding: 8px 0">
        <h3>Manage Event</h3>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Booking Details
                </header>
                <div class="panel-body">
                    <section id="unseen">
                        <div id="booking_details" class="booking_details">
                            <div class="col-sm-4 booking_details_component">
                                <label class="control-label col-md-4" style="padding-top: 0px; margin: 7px 0"
                                       for="type">Date From:</label>
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker1">
                                            <input id="date_from" name="date_from" type="text" class="form-control">
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 booking_details_component">
                                <label class="control-label col-md-4" style="padding-top: 0px; margin: 7px 0"
                                       for="type">Date To:</label>
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker2">
                                            <input id="date_to" name="date_to" type="text" class="form-control">
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 booking_details_component">
                                <label class="control-label col-sm-4" style="padding-top: 0px; margin: 7px 0"
                                       for="type">Room Type:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="room_type" name="room_type">
                                        <option value=" " disabled selected>Choose your option</option>
                                        <option value="ALL">All</option>
                                        <option value="Auditorium">Auditorium</option>
                                        <option value="Conference">Conference</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" id="btn_display" class="btn btn-default btn-sm"
                                        style="margin-top: 12px">
                                    <i class="fa fa-check"></i> <b>Display</b></button>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>

    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}" width="35px" height="35px"
                     alt="Loading Report Please wait..."><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body table-responsive">
                        <table id="ci_tab" class="table table-condensed table-striped table-bordered"
                               width="100%">
                            <thead style="white-space:nowrap;">
                            <tr>
                                <th>BOOK ID</th>
                                <th>ROOM ID</th>
                                <th>ROOM TYPE</th>
                                <th>START TIME</th>
                                <th>END TIME</th>
                                <th>PURPOSE</th>
                                <th>PERSON ASSUMPTION</th>
                                <th>GUEST TYPE</th>
                                <th>BOOKING STATUS</th>
                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;"></tbody>

                        </table>
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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.hideseek.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    <script>

        $(function () {
            var date = new Date();
            var pdate = date.setDate(date.getDate() - 1);
            $('#datetimepicker1,#datetimepicker2').datetimepicker({
                defaultDate: pdate,
                format: 'DD/MM/YYYY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });
        });

        var url_report_output = '{{url('event/getreportdata')}}';
        $(document).ready(function () {
            $("#btn_display").click(function () {
                console.log("Handler for .click() called.");
                $("#report-body").hide();
                $.ajax({
                    method: "POST",
                    url: url_report_output,
                    data: {
                        _token: '{{csrf_token()}}',
                        date_from: $('#date_from').val(),
                        date_to: $('#date_to').val(),
                        room_type: $('#room_type').val()
                    },
                    beforeSend: function () {
                        $("#loader").show();
                    },
                    success: function (data) {
                        console.log(data);
                        $('#ci_tab').dataTable().fnDestroy();

                        var aprrove_button = <?php echo "'" . Auth::user()->user_id . "'"; ?> ? 'block' : 'none';

                        var table = $('#ci_tab').dataTable({
                            data: data.b_r_info,
                            // "scrollY": 300,
                            // "scrollX": true,
                            "paging": true,

                            columns: [
                                // {data: "sales_area_code", className: 'wd'},
                                {data: "book_id", className: 'day'},
                                {data: "room_id", className: 'day'},
                                {data: "room_type", className: 'day'},
                                {data: "start_time", className: 'day'},
                                {data: "end_time", className: 'wds'},
                                {data: "purpose", className: 'wday'},
                                {data: "person_assumption", className: 'twd'},
                                {data: "guest_type", className: 'wd'},
                                {data: "booking_status", className: 'day'}],

                            // "bLengthChange": true,

                            dom: 'Bfrtip',
                            buttons: [
                                 'excelHtml5',
                            ],

                        });
                        $("#report-body").show();
                    },
                    error: function () {

                    },
                    complete: function () {
                        $("#loader").hide();
                    }
                })


            });

            {{--$('#ci_tab tbody').on( 'click', 'button', function () {--}}
            {{--    console.log('Approval Function Called');--}}

            {{--    var self = $(this);--}}

            {{--    http_request('post', '{{url('event/approvedormbooking')}}', {--}}
            {{--        _token: '{{csrf_token()}}',--}}
            {{--        booking_id: self.closest('tr').find('.booking_id').text()--}}
            {{--    }).then(function (value) {--}}
            {{--        console.log(value);--}}
            {{--        // if (value.status) {--}}
            {{--            self.closest('tr').find('.btnapprove_dorm').prop('disabled', true).text('Cancelled').css('' +--}}
            {{--                'background-color', '#A7D24D');--}}
            {{--            toastr.success('Approved')--}}
            {{--        // }--}}

            {{--    })--}}

            {{--} );--}}

        })
    </script>

@endsection
