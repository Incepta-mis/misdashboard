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
            margin: 0 2px;
            border-radius: 5px;
            background-color: #3B9F00;
            border: none;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            padding: 6px;
            width: 22px;
            transition: all 0.5s;
            cursor: pointer;
        }

        /*.btnapprove_dorm span {*/
        /*    cursor: pointer;*/
        /*    display: inline-block;*/
        /*    position: relative;*/
        /*    transition: 0.5s;*/
        /*    padding-right: 15px*/
        /*}*/

        /*.btnapprove_dorm span:after {*/
        /*    content: '\2714';*/
        /*    position: absolute;*/
        /*    opacity: 0;*/
        /*    top: 0;*/
        /*    right: -4px;*/
        /*    transition: 0.5s;*/
        /*}*/

        /*.btnapprove_dorm:hover span:after {*/
        /*    opacity: 1;*/
        /*    right: 0;*/
        /*}*/


        .btnedit_dorm {
            margin: 0 2px;
            border-radius: 5px;
            background-color: #1034A6;
            border: none;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            padding: 6px;
            width: 22px;
            transition: all 0.5s;
            cursor: pointer;
        }

        /*.btnedit_dorm span {*/
        /*    cursor: pointer;*/
        /*    display: inline-block;*/
        /*    position: relative;*/
        /*    transition: 0.5s;*/
        /*    padding-right: 15px*/
        /*}*/

        /*.btnedit_dorm span:after {*/
        /*    content: '\270E';*/
        /*    position: absolute;*/
        /*    opacity: 0;*/
        /*    top: 0;*/
        /*    right: -4px;*/
        /*    transition: 0.5s;*/
        /*}*/

        /*.btnedit_dorm:hover span:after {*/
        /*    opacity: 1;*/
        /*    right: 0;*/
        /*}*/

        .btncancel_dorm {
            margin: 0 2px;
            border-radius: 5px;
            background-color: #ff4d4d;
            border: none;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            padding: 6px;
            width: 22px;
            transition: all 0.5s;
            cursor: pointer;
        }

        /*.btncancel_dorm span {*/
        /*    cursor: pointer;*/
        /*    display: inline-block;*/
        /*    position: relative;*/
        /*    transition: 0.5s;*/
        /*    padding-right: 15px*/
        /*}*/

        /*.btncancel_dorm span:after {*/
        /*    content: '\2718';*/
        /*    position: absolute;*/
        /*    opacity: 0;*/
        /*    top: 0;*/
        /*    right: -4px;*/
        /*    transition: 0.5s;*/
        /*}*/

        /*.btncancel_dorm:hover span:after {*/
        /*    opacity: 1;*/
        /*    right: 0;*/
        /*}*/

    </style>
@endsection

@section('right-content')
    <div class="text-center" style="padding: 8px 0">
        <h3>Admin Panel</h3>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Search Details
                </header>
                <div class="panel-body">
                    <section id="unseen">
                        <div id="booking_details" class="booking_details">
                            <div class="col-sm-3 booking_details_component">
                                <label class="control-label col-md-4"
                                       style="padding: 0px; margin: 7px 0; font-size: 12px"
                                       for="type">Date From:</label>
                                <div class="col-md-7 col-sm-7" style="padding: 0px">
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
                            <div class="col-sm-3 booking_details_component">
                                <label class="control-label col-md-4"
                                       style="padding-top: 0px; margin: 7px 0; font-size: 12px"
                                       for="type">Date To:</label>
                                <div class="col-md-7 col-sm-7" style="padding: 0px">
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
                                <label class="control-label col-sm-4"
                                       style="padding: 0px; margin: 7px 0; font-size: 12px"
                                       for="type">Room Type:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="room_type" name="room_type">
                                        <option value=" " disabled selected>Choose your option</option>
                                        <option value="ALL">All</option>
                                        <option value="Auditorium">Auditorium</option>
                                        <option value="Conference">Conference</option>
                                        <option value="Dormitory">Dormitory</option>
                                    </select>
                                </div>
                            </div>
                            {{--                            <div class="col-sm-3 booking_details_component">--}}
                            {{--                                <label class="control-label col-sm-3" style="padding: 0px; margin: 7px 0; font-size: 12px"--}}
                            {{--                                       for="type">Emp ID:</label>--}}
                            {{--                                <div class="col-sm-8">--}}
                            {{--                                    <input type="text"  class="form-control" id="search_emp" name="search_emp" style="width: 100%;" value=''--}}
                            {{--                                           placeholder="Enter Room ID" maxlength="20" class="err_input_empty form-control">--}}
                            {{--                                    <select class="form-control" id="room_type" name="room_type">--}}
                            {{--                                        <option value=" " disabled selected>Choose your option</option>--}}
                            {{--                                        <option value="ALL">All</option>--}}
                            {{--                                        <option value="Auditorium">Auditorium</option>--}}
                            {{--                                        <option value="Conference">Conference</option>--}}
                            {{--                                        <option value="Dormitory">Dormitory</option>--}}
                            {{--                                    </select>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="col-sm-3 booking_details_component">--}}
                            {{--                                <label class="control-label col-sm-4" style="padding-top: 0px; margin: 7px 0; font-size: 12px"--}}
                            {{--                                       for="type">Emp ID:</label>--}}
                            {{--                                <div class="col-sm-8">--}}
                            {{--                                    <select class="form-control" id="booking_status" name="booking_status">--}}
                            {{--                                        <option value=" " disabled selected>Choose your option</option>--}}
                            {{--                                        <option value="ALL">All</option>--}}
                            {{--                                        <option value="Auditorium">Auditorium</option>--}}
                            {{--                                        <option value="Conference">Conference</option>--}}
                            {{--                                        <option value="Dormitory">Dormitory</option>--}}
                            {{--                                    </select>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
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
                    <div class="panel-body">
                        <div class="table-responsive">
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
                                    <th>PERSON</th>
                                    <th>GUEST TYPE</th>
                                    <th>BOOKING STATUS</th>
                                    <th>ACTION</th>

                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;"></tbody>

                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Date and Time</h4>
                </div>
                <div class="modal-body">
                    <form id="booking_update">
                        <input type="text" value="" name="booking_id" id="booking_id" readonly="">
                        {{--                    // here you will add your input fields--}}
                        <p>Start Time</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker11">
                                <input id="m_start_time" name="start_time" type="text" class="form-control">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                        <p>End Time</p>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker21">
                                <input id="m_end_time" name="end_time" type="text" class="form-control">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{--                    // and here will be button for update--}}
                    <button id="btnSuccess" name="btnSuccess" type="button" class="btn btn-default">Update
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
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
            //disable past dates
            $('#rls').hide();

            var date = new Date();
            var pdate = date.setDate(date.getDate() - 1);
            $('#datetimepicker1,#datetimepicker2').datetimepicker({
                defaultDate: pdate,
                format: 'DD/MM/YYYY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });

            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            $('#datetimepicker11').datetimepicker({
                minDate: today
            });
            $('#datetimepicker21').datetimepicker({
                minDate: today
            });
        });

        var url_report_output = '{{url('event/admin_panel_data')}}';
        var url_report_output2= '{{url('event/admin_panel_single_data')}}';
        $(document).ready(function () {

            var eid = '{{$eid}}';
            var row_data = null;
            console.log(eid);


            //xhttp request
            var http_request = function (type, url, data) {
                var response_data = new Promise(function (resolve, reject) {
                    $.ajax({
                        type: type,
                        url: url,
                        data: data,
                        success: function (response) {
                            // console.log(response);
                            resolve(response);
                        },
                        error: function (error) {
                            // console.log(error);
                            reject(error);
                        }
                    });
                });

                return response_data;
            };


            var table = null;
            var init_datatable = function (tableData) {
                $('#ci_tab').DataTable().destroy();

                var aprrove_button = <?php echo "'" . Auth::user()->user_id . "'"; ?> ? 'block' : 'none';

                table = $('#ci_tab').DataTable({
                    data: tableData,
                    // "scrollY": 300,
                    // "scrollX": true,
                    "paging": true,

                    columns: [
                        // {data: "sales_area_code", className: 'wd'},
                        {data: "book_id", className: 'book_id'},
                        {data: "room_id", className: 'day'},
                        {data: "room_type", className: 'day'},
                        {data: "start_time", className: 'start_time'},
                        {data: "end_time", className: 'end_time'},
                        {data: "purpose", className: 'wday'},
                        {data: "person_assumption", className: 'twd'},
                        {data: "guest_type", className: 'wd'},
                        {data: "booking_status", className: 'booking_status'},
                        {data: null}],

                    // "bLengthChange": true,

                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                    ],
                    "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "render": function (row) {
                            //console.log(row.booking_status);

                            var a_disabled = row.booking_status === 'Booked' ? 'disabled' : '';
                            var d_disabled = (row.booking_status === 'Rejected' || row.booking_status === 'Cancelled') ? 'disabled' : '';
                            var css_a_disabled = row.booking_status === 'Booked' ? ';background-color: #A7D24D; ' : '';
                            var css_d_disabled = (row.booking_status === 'Rejected' || row.booking_status === 'Cancelled') ? ';background-color: #F87C7C; ' : '';

                            if (row.room_type === 'Dormitory') {

                                return '<button title="Approve Booking" class="btnapprove_dorm" ' + a_disabled + ' style="display: none ' + aprrove_button + css_a_disabled + '" name="btnapprove_dorm" type="button" value="Approve"><span<i class="fa fa-check"></i></span></button>' +
                                    '<button title="Edit Booking" class="btnedit_dorm" style="display: none ' + aprrove_button + '" name="btnedit_dorm" type="button" value="Edit"><span><i class="fa fa-repeat"></i></span></button>' +
                                    '<button title="Delete Booking" class="btncancel_dorm" ' + d_disabled + ' style="display: none ' + aprrove_button + css_d_disabled + '" name="btncancel_dorm" type="button" value="Cancel"><span><i class="fa fa-trash-o"></i></span></button>'
                            } else {
                                return '<button title="Edit Booking" class="btnedit_dorm" style="display: none ' + aprrove_button + '" name="btnedit_dorm" type="button" value="Edit"><span><i class="fa fa-repeat"></i></span></button>' +
                                    '<button title="Delete Booking" class="btncancel_dorm" ' + d_disabled + ' style="display: none ' + aprrove_button + css_d_disabled + '" name="btncancel_dorm" type="button" value="Cancel"><span><i class="fa fa-trash-o"></i></span></button>'
                            }

                        },
                    }]
                });
            };

            if(eid !== 'Not Applicable'){
                $.ajax({
                    method: "POST",
                    url: url_report_output2,
                    data: {
                        _token: '{{csrf_token()}}',
                        book_id : eid
                    },
                    beforeSend: function () {
                        $("#loader").show();
                    },
                    success: function (data) {
                        console.log(data);
                        init_datatable(data.b_r_info);
                        $("#report-body").show();
                    },
                    error: function () {

                    },
                    complete: function () {
                        $("#loader").hide();
                    }
                });
            }

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
                        init_datatable(data.b_r_info);
                        $("#report-body").show();
                    },
                    error: function () {

                    },
                    complete: function () {
                        $("#loader").hide();
                    }
                });


            });

            $(document).on('click', '.btnapprove_dorm', function () {
                console.log('Approval Function Called');

                var self = $(this);
                var rowData = table.row( self.parents('tr') ).data();

                //console.log(table.row( self.parents('tr') ).data());
                //console.log(self.closest('tr').find('.book_id').text());
                // console.log(rowData.book_id);

                    http_request('post', '{{url('event/approve_dorm_booking')}}', {
                        _token: '{{csrf_token()}}',
                        room_id: rowData.room_id,
                        booking_id: rowData.book_id,
                        start_time: rowData.start_time,
                        end_time: rowData.end_time,
                        com_id: rowData.com_id,
                        plant_id: rowData.plant_id


                    }).then(function (value) {
                        console.log("Value of status");
                        console.log(value.status);
                        if (value.status) {
                            self.closest('tr').find('.btnapprove_dorm').prop('disabled', true).css('' +
                                'background-color', '#A7D24D');
                            toastr.success("Booked!");
                            self.closest('tr').find('.booking_status').text(value.update);
                        }else{
                            toastr.error("Double Approval for same dorm is not Allowed")
                        }

                    });



                //console.log(rowData.book_info);

            });

            $(document).on('click', '.btnedit_dorm', function () {
                console.log('Edit Function Called');

                var self = $(this);
                row_data = table.row( self.parents('tr') ).data();
                console.log(row_data);

                var start_time = self.closest('tr').find('.start_time').text();
                var end_time = self.closest('tr').find('.end_time').text();

                console.log(start_time);
                console.log(end_time);
                $('#m_start_time').val(start_time);
                $('#m_end_time').val(end_time);

                $('#myModal').modal('show');

            });
            $(document).on('click', '.btncancel_dorm', function () {
                console.log('Cancel Function Called');

                var self = $(this);
                console.log(self.closest('tr').find('.book_id').text());

                http_request('post', '{{url('event/cancel_dorm_booking')}}', {
                    _token: '{{csrf_token()}}',
                    booking_id: self.closest('tr').find('.book_id').text()
                }).then(function (value) {
                    console.log(value);
                    if (value.status) {
                        self.closest('tr').find('.btncancel_dorm').prop('disabled', true).css('' +
                            'background-color', '#F87C7C');
                        toastr.error('Rejected');
                        self.closest('tr').find('.booking_status').text(value.update);
                    }

                })

            });

            $('#btnSuccess').click(function () {
                console.log('clicked');
                console.log($('#booking_update').serialize());

                var now = moment($('#m_start_time').val()); //todays date
                var end = moment($('#m_end_time').val()); // another date
                var duration = moment.duration(end.diff(now));
                var minutes = duration.asMinutes();
                console.log(minutes);

                console.log(row_data);


                if (minutes < 31 || minutes > 1439) {
                    alert('Time Duration is not enough');
                } else {

                    console.log($('#booking_id').val());


                    http_request('post', '{{url('event/update_event_time')}}', {
                        _token: '{{csrf_token()}}',
                        fdata: $('#booking_update').serialize(),
                        room_id: row_data.room_id,
                        booking_id: row_data.book_id,
                        start_time: row_data.start_time,
                        end_time: row_data.end_time,
                        com_id: row_data.com_id,
                        plant_id: row_data.plant_id
                    }).then(function (value) {
                        console.log(value);
                        if (value.status) {
                            // self.closest('tr').find('.btnapprove_dorm').prop('disabled', true).css('' +
                            //     'background-color', '#A7D24D');
                            toastr.success('Updated & Booked');
                            // self.closest('tr').find('.booking_status').text(value.update);

                            //re-initialize table
                            if(eid !== 'Not Applicable'){
                                $.ajax({
                                    method: "POST",
                                    url: url_report_output2,
                                    data: {
                                        _token: '{{csrf_token()}}',
                                        book_id : eid
                                    },
                                    beforeSend: function () {
                                        $("#loader").show();
                                    },
                                    success: function (data) {
                                        console.log(data);
                                        init_datatable(data.b_r_info);
                                        $("#report-body").show();
                                    },
                                    error: function () {

                                    },
                                    complete: function () {
                                        $("#loader").hide();
                                    }
                                });
                            }else{
                                console.log('inside else block ');
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
                                    },
                                    success: function (data) {
                                        console.log(data);
                                        init_datatable(data.b_r_info);
                                    },
                                    error: function () {

                                    },
                                    complete: function () {
                                    }
                                });
                            }

                        }else {
                            toastr.error('Double Approval for same dorm is not Allowed');
                        }
                    });

                    //hide modal box
                    $('#myModal').modal('hide');

                }


            });


        })
    </script>

@endsection
