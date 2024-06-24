@extends('_layout_shared._master')
@section('title','Book Event')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/select2/select2.min.css')}}">
    {{-- <link rel="stylesheet" href="{{url('public/site_resource/css/tree-style.css')}}">--}}

    <style>
        .booking_details_component {
            margin: 10px 0;
            padding-left: 0;
            padding-right: 0;
        }

        .room_grid {
            background-color: #EFF0F4;
            text-align: center;
            -webkit-box-shadow: 6px 6px 5px 0px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 6px 6px 5px 0px rgba(0, 0, 0, 0.5);
            box-shadow: 6px 6px 5px 0px rgba(0, 0, 0, 0.5);
        }

        .room_grid:hover {
            background-color: #65CEA7;
            color: #FFF;
            transition: 0.2s all linear;
            -webkit-box-shadow: 6px 6px 10px 1px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 6px 6px 10px 1px rgba(0, 0, 0, 0.75);
            box-shadow: 6px 6px 10px 1px rgba(0, 0, 0, 0.75);
        }

        .room_grid_disabled {
            background-color: #FE8484;
            color: #FFF;
            text-align: center;
            -webkit-box-shadow: inset 5px 5px 10px 0px rgba(0, 0, 0, 0.38);
            -moz-box-shadow: inset 5px 5px 10px 0px rgba(0, 0, 0, 0.38);
            box-shadow: inset 5px 5px 10px 0px rgba(0, 0, 0, 0.38);
            pointer-events: none;
        }

        #swal2-content {
            font-size: 16px;
        }

        .swal2-styled {
            font-size: 16px !important;
        }

        #swal2-validation-message {
            font-size: 16px;
        }

        .btnbook_cancel {
            border-radius: 5px;
            background-color: #ff4d4d;
            border: none;
            color: #ffffff;
            text-align: center;
            font-size: 15px;
            padding: 8px;
            width: 80px;
            transition: all 0.5s;
            cursor: pointer;
        }

        .btnbook_cancel span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
            padding-right: 20px
        }

        .btnbook_cancel span:after {
            content: '\2718';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -4px;
            transition: 0.5s;
        }

        .btnbook_cancel:hover span:after {
            opacity: 1;
            right: 0;
        }
    </style>
@endsection

@section('right-content')
    <div class="text-center" style="padding: 8px 0">
        <h3>Book Event</h3>
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
                                       for="type">Start Time:</label>
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker1">
                                            <input id="start_time" name="start_time" type="text" class="form-control">
                                            <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 booking_details_component">
                                <label class="control-label col-md-4" style="padding-top: 0px; margin: 7px 0"
                                       for="type">End Time:</label>
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker2">
                                            <input id="end_time" name="end_time" type="text" class="form-control">
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
                                        <option value="ALL">ALL</option>
                                        <option value="Auditorium">Auditorium</option>
                                        <option value="Conference">Conference</option>
                                        <option value="Dormitory">Dormitory</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-default btn-sm"
                                        style="margin-top: 12px">
                                    <i class="fa fa-check"></i> <b>Submit</b></button>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Booking Events
                </header>
                <div class="panel-body" style="">
                    <section id="unseen">
                        <div id="gallery" class="media-gal">
                            <div class="row" id="room_card"></div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Booking History
                    <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-up"></a>
                </span>
                </header>
                <div class="panel-body" style="display: none">
                    <div class="adv-table">
                        <div class="row">
                            <div class="dataTables_length">
                            </div>
                        </div>
                        <table class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                            <tr>
                                <th>Room Name</th>
                                <th>Room Type</th>
                                <th>Reserved By (Emp ID)</th>
                                <th>Reserved By (Name)</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="booked_room_info">
                            </tbody>
                        </table>

                    </div>
                </div>
            </section>
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

    <script>

        $(function () {
            $('#rls').hide();

            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            $('#datetimepicker1').datetimepicker({
                minDate: today
            });
            $('#datetimepicker2').datetimepicker({
                minDate: today
            });

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

            function prepared_template(roomtype) {
                console.log("")
                console.log(roomtype);
                var template = '';
                var booked_template = '';
                for (var x = 0; x < roomtype.length; x++) {
                    //turner :)
                    var room_class = roomtype[x].booking_status != null && roomtype[x].booking_status == 'Booked' ? 'room_grid_disabled' : 'room_grid';

                    template += '<a class="room_tooltip" href="#" data-toggle="tooltip" data-placement="top" title="Room Location: ' + roomtype[x].room_location + '\nRoom Position: ' + roomtype[x].room_position + '\nSeat Capacity: ' + roomtype[x].room_capacity + '\nAccessories: ' + roomtype[x].room_accessories + '" style="color:#7A768A">' +
                        '<div class="col-lg-4">' +
                        '<section data-room_id="' + roomtype[x].room_id + '" data-room_type="' + roomtype[x].room_type + '" data-room_capacity="' + roomtype[x].room_capacity + '" class="panel ' + room_class + ' room_click_class">' +
                        '<div class="panel-body">' + roomtype[x].room_name + '</div>' +
                        '</section>' +
                        '</div>' +
                        '</a>'
                    if (roomtype[x].booking_status == 'Booked') {

                        var display_button = roomtype[x].c_user === <?php echo "'" . Auth::user()->user_id . "'"; ?> ? 'block' : 'none';

                        booked_template += '<tr class="gradeX">\n' +
                            '<td class="booking_id" style="display: none">' + roomtype[x].book_id + '</td>\n' +
                            '<td>' + roomtype[x].room_name + '</td>\n' +
                            '<td>' + roomtype[x].room_type + '</td>' +
                            '<td>' + roomtype[x].c_user + '</td>' +
                            '<td>' + roomtype[x].name + '</td>' +
                            '<td>' + roomtype[x].start_time + '</td>' +
                            '<td>' + roomtype[x].end_time + '</td>' +
                            '<td ><button class="btnbook_cancel" style="display: ' + display_button + '" name="btnbook_cancel" type="button" value="Cancel"><span>Cancel </span></button></td>' +
                            '</tr>'
                    }
                    //console.log(roomtype[x].room_id);
                }
                $('#room_card').empty().append(template);
                $('#booked_room_info').empty().append(booked_template);

                $(document.body).on('click', '.room_click_class', function (roomtype) {
                    var self = $(this);
                    console.log($(this)[0].dataset.room_id);
                    console.log($(this)[0].dataset.room_type);
                    //console.log($(this)[0].dataset.room_capacity);

                    var room_capacity = $(this)[0].dataset.room_capacity;

                    Swal.fire({
                        title: 'Multiple inputs',
                        html:
                        // '<input type="text" placeholder="Purpose" id="swal-input_purpose" class="swal2-input">' +
                            '<select placeholder="Event Type" id="swal-input_purpose" class="swal2-select" style="width: 100%">' +
                            '<option value="Meeting">Meeting</option>' +
                            '<option value="Visit">Visit</option>' +
                            '<option value="Audit">Audit</option>' +
                            '<option value="In-plant Training">In-plant Training</option>' +
                            '<option value="Training">Training</option>' +
                            '</select>' +
                            '<input  type="number" placeholder="Person Assumption" id="swal-input_person_assumption" class="swal2-input swal2-selct" style="max-width: 19em">' +
                            '<select placeholder="Guest Type" id="swal-input_guest_type" class="swal2-select" style="width: 100%">' +
                            '<option value="Employee">Employee</option>' +
                            '<option value="Employee And Foreign Guests">Employee And Foreign Guests</option>' +
                            '<option value="Employee And Local Guests">Employee And Local Guests</option>' +
                            '<option value="Chairman">Chairman</option>' +
                            '<option value="Director">Director</option>' +
                            '</select>' +
                            '<input placeholder="Remark" id="swal-input_remark" class="swal2-textarea">',
                        focusConfirm: true,
                        showCancelButton: true,
                        preConfirm: function (result) {
                            var purpose = Swal.getPopup().querySelector('#swal-input_purpose').value;
                            var person_assumption = Swal.getPopup().querySelector('#swal-input_person_assumption').value;
                            var guest_type = Swal.getPopup().querySelector('#swal-input_guest_type').value;
                            var remark = Swal.getPopup().querySelector('#swal-input_remark').value;


                            if (purpose === '' || person_assumption === '' || guest_type === '' || remark === '') {
                                Swal.showValidationMessage('All Fields are Required');
                            } else if (parseInt(person_assumption) > parseInt(room_capacity)) {
                                Swal.showValidationMessage('Seat Capacity Exceeded');
                            }

                            return [
                                document.getElementById('swal-input_purpose').value,
                                document.getElementById('swal-input_person_assumption').value,
                                document.getElementById('swal-input_guest_type').value,
                                document.getElementById('swal-input_remark').value
                            ]
                        }
                    }).then(function (result) {

                        console.log(self[0].dataset.room_id);
                        http_request('post', '{{url('event/insert_booking_info')}}', {
                            _token: '{{csrf_token()}}',
                            room_id: self[0].dataset.room_id,
                            room_type: self[0].dataset.room_type,
                            start_time: $('#start_time').val(),
                            end_time: $('#end_time').val(),
                            book_info: result

                        }).then(function (value) {
                            console.log("room booking status");
                            console.log(value);


                            if(value){
                                if(value.status=='booked'){
                                    Swal.fire({
                                        position: 'center',
                                        title: 'Oops...',
                                        text: 'Failed!!..Room Already Booked!',
                                        type: 'warning',
                                        showConfirmButton: true,
                                        confirmButtonText: 'Ok',

                                    });
                                    return 0;
                                }
                            }


                            if (value.status) {
                                //toastr.success('The Room has been booked');
                                Swal.fire({
                                    position: 'center',
                                    title: self[0].dataset.room_type == 'Dormitory' ? 'Your Room has been requested' : 'Your Room has been booked',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                //document.location.reload(true);
                                window.setTimeout(function () {
                                    location.reload()
                                }, 1000);

                            } else {

                                toastr.error('Failed to Book');
                            }

                        });

                    })
                });
                //console.log(template);
            }

            $('#btnSubmit').click(function () {
                console.log('button Clicked test');
                console.log($('#room_type').val());
                var now = moment($('#start_time').val()); //todays date
                var end = moment($('#end_time').val()); // another date
                var duration = moment.duration(end.diff(now));
                var minutes = duration.asMinutes();
                console.log(minutes);



                if ($('#room_type').val() === 'Dormitory') {

                    console.log("this is dormetory");

                    if (minutes < 60) {
                        alert('More Duration needed for this event.');
                    } else if (minutes > 10080) {
                        alert('Less Duration needed for this event.');
                    } else {
                        if ($('#start_time').val().length > 0 && $('#end_time').val().length > 0 && $('#room_type').val() !== null) {

                            console.log('button Clicked for dormetory');

                            http_request('post', '{{url('event/roomcardview')}}', {
                                _token: '{{csrf_token()}}',
                                room_type: $('#room_type').val(),
                                start_time: $('#start_time').val(),
                                end_time: $('#end_time').val()
                            }).then(function (roomType) {
                                prepared_template(roomType.b_info);
                            })
                        } else {
                            alert('Fill up all the Field Properly!!');
                        }
                    }
                } else {
                    if (minutes < 30) {
                        alert('More Duration needed for this event.');
                    } else if (minutes > 720) {
                        alert('Less Duration needed for this event.');
                    } else {
                        if ($('#start_time').val().length > 0 && $('#end_time').val().length > 0 && $('#room_type').val() !== null) {

                            console.log('button sayla');

                            http_request('post', '{{url('event/roomcardview')}}', {
                                _token: '{{csrf_token()}}',
                                room_type: $('#room_type').val(),
                                start_time: $('#start_time').val(),
                                end_time: $('#end_time').val()
                            }).then(function (roomType) {
                                console.log("roomtype is =")
                                console.log(roomType)
                                prepared_template(roomType.b_info);
                            })
                        } else {
                            alert('Fill up all the Field Properly!!');
                        }
                    }

                }


                // var time = $('#start_time').val();
                // //console.log(time);
                // var minute = time.toLocaleTimeString();


            });

            $(document.body).on('click', '.btnbook_cancel', function () {
                console.log($(this).closest('tr').find('.booking_id').text());

                var self = $(this);

                http_request('post', '{{url('event/cancelbooking')}}', {
                    _token: '{{csrf_token()}}',
                    booking_id: self.closest('tr').find('.booking_id').text()
                }).then(function (value) {
                    console.log(value);
                    if (value.status) {
                        self.closest('tr').find('.btnbook_cancel').prop('disabled', true).text('Cancelled').css('' +
                            'background-color', '#F87C7C');
                        toastr.error('Cancelled')
                    }

                })
            })
        });
    </script>

@endsection
