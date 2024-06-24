@extends('_layout_shared._master')
@section('title','Insert Room Info')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/select2/select2.min.css')}}">
    {{--    <link rel="stylesheet" href="{{url('public/site_resource/css/tree-style.css')}}">--}}

    <style>
        .body {
            background-color: white;
        }

        .header {
            height: 50px;
            width: 100%;
        }

        .header p {
            font-size: 20px;
            color: #323234;
            text-align: center;
            padding-top: 10px;
        }

        .top-content {
            height: 100px;
            width: 100%;
            text-align: center;
        }

        .top-content button {
            background-color: #323234;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            padding: 4px 24px;
            border-radius: 5px;
            border: 2px solid #424F63;
        }

        .top-content button:hover {
            background-color: #FFF;
            color: #424F63;
            transition: all linear 0.3s;
            border: 2px solid #424F63;
        }

        .form-horizontal .form-group {
            margin: 10px 30px;
        }

        #result {
            background-color: #FFF;

        }

        #result ul {
            /*padding: 0 0 15px 0;*/
            list-style-type: none;
            position: absolute;
            z-index: 5;
            color: #FFF;
            background-color: #424F63;
            opacity: 80%;
            left: 50%;
            top: 98%;
            width: 267px;
            border: 1px lightgrey solid;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            height: 142px;
            overflow-y: auto;
            cursor: grab;

        }

        #result ul li {
            padding: 0 5px 20px 5px;
            border-radius: 3px;
            cursor: grabbing;
        }

        #result ul li:hover {
            background-color: #A2AEC7;
            transition: 0.3s all linear;
        }

        #swal2-title {
            font-size: 18px;
        }

        .swal2-success {
            display: block !important;
        }

        .swal2-image {
            display: block !important;
        }

    </style>
@endsection

@section('right-content')
    <div class="text-center" style="padding: 8px 0">
        <h3>Room Information</h3>
    </div>
    <div class="row">
        <div class="input-group col-sm-12" style="display: inline-block">
            <div class="col-sm-6 col-sm-offset-3">
                <Select class="form-control" id="search_type" name="search_type" style="width: 50%;">
                    <option value="room_id">Room ID</option>
                    <option value="room_name">Room Name</option>
                </Select>
                <input type="text" id="search_value" name="search_value" style="width: 50%;" value=''
                       placeholder="Enter Room ID" maxlength="20" class="err_input_empty form-control">
                {{--                search div--}}
                <div id="result" style="list-style-type: none">
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="background-color: white">
            <form class="form-horizontal" action="/action_page.php">
                <div class="form-group">
                    <label class="control-label col-sm-2" style="padding-top: 0px;" for="name">Room Name:</label>
                    <div class="col-sm-10">
                        <input type="name" class="form-control" id="room_name" name="room_name"
                               placeholder="Enter Room Name">
                        <input type="hidden" class="form-control" id="room_id" name="room_id"
                               placeholder="Enter Room Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" style="padding-top: 0px;" for="type">Room Type:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="room_type" name="room_type">
                            <option value="" disabled selected>Choose your option</option>
                            <option value="Auditorium">Auditorium</option>
                            <option value="Conference">Conference</option>
                            <option value="Dormitory">Dormitory</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" style="padding-top: 0px;" for="type">Room Location:</label>
                    <div class="col-sm-10">
                        <label for="" id="room_location" name="room_location">@if($plant === '1000')
                                        {{ 'Head Office'}}
                                      @elseif($plant === '1100')
                                        {{ 'Savar (Factory)'}}
                                      @elseif($plant === '1300')
                                        {{ 'Dhamrai (Factory)'}}
                                      @endif
                            </label>
{{--                        <select class="form-control" id="room_location" name="room_location">--}}
{{--                            <option value="" disabled selected>Choose your option</option>--}}
{{--                            <option value="Head Office">Head Office</option>--}}
{{--                            <option value="Dhamrai">Dhamrai (Factory)</option>--}}
{{--                            <option value="Savar">Savar (Factory)</option>--}}
{{--                        </select>--}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" style="padding-top: 0px;" for="type">Room Position:</label>
                    <div class="col-sm-10">
                        <input type="type" class="form-control" id="room_position" name="room_position"
                               placeholder="Enter Room Position">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" style="padding-top: 0px;" for="type">Seat Capacity:</label>
                    <div class="col-sm-10">
                        <input type="type" class="form-control" id="seat_capacity" name="seat_capacity"
                               placeholder="Enter Seat Capacity">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" style="padding-top: 0px;" for="type">Accessories:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" id="accessories" name="accessories"
                                  placeholder="Enter Accessories"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding: 10px 0">
            <form action="/action_page.php">
                <div class="form-inline col-sm-6">
                    <div class="col-sm-offset-5 col-sm-1">
                        <button type="button" class="btn btn-primary" style="padding: 6px 30px" name="btn_insert"
                                id="btn_insert">Add
                        </button>
                    </div>
                </div>
                <div class="form-inline col-sm-6">
                    <div class="col-sm-offset-1 col-sm-1">
                        <button type="button" class="btn btn-primary" style="padding: 6px 30px" name="btn_update"
                                id="btn_update" disabled>Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer-content')
{{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{--    {{Html::script('public/site_resource/js/jquery.hideseek.min.js')}}--}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}}

    <script>

        // Material Select Initialization
        $(document).ready(function () {

            $("#btn_insert").click(function () {
                if ($("#room_name").val() && $("#room_type").val() != null  && $("#room_position").val()
                    && $("#seat_capacity").val() && $("#accessories").val()) {

                    var room_id = $("#room_id").val();
                    console.log(room_id);


                    var room_name = $("#room_name").val();
                    console.log(room_name);
                    $("#room_name").val(null);

                    var room_type = $("#room_type").val();
                    console.log(room_type);
                    $("#room_type").val(null);

                    var room_location = $("#room_location").text();
                    console.log(room_location);

                    var room_position = $("#room_position").val();
                    console.log(room_position);
                    $("#room_position").val(null);

                    var seat_capacity = $("#seat_capacity").val();
                    console.log(seat_capacity);
                    $("#seat_capacity").val(null);

                    var accessories = $("#accessories").val();
                    console.log(accessories);
                    $("#accessories").val(null);

                    // if ($(room_name).val() === ''){
                    //     alert("Please fill all the fields!")
                    // }
                    // else {
                    $.ajax({
                        method: 'post',
                        url: '{{url('event/insert_room_info')}}',
                        data: {
                            _token: '{{csrf_token()}}',
                            room_name: room_name,
                            room_type: room_type,
                            room_location: room_location,
                            room_position: room_position,
                            seat_capacity: seat_capacity,
                            accessories: accessories
                        },
                        success: function (data) {
                            toastr.success('Data has been saved successfully');
                        },
                        error: function () {
                            toastr.error('Failed to save Data');
                        }
                    });

                } else {
                    toastr.warning('Fill up All the Fields!');
                }
                // }

            });


                $('#btn_update').click(function () {

                    if ($("#room_name").val().length > 0 && $("#room_type").val() !== null && $("#room_location").val() !== null && $("#room_position").val().length > 0 && $("#seat_capacity").val().length > 0 && $("#accessories").val().length > 0) {

                    var room_id = $("#room_id").val();
                    console.log(room_id);

                    var room_name = $("#room_name").val();
                    console.log(room_name);
                    $("#room_name").val(null);

                    var room_type = $("#room_type").val();
                    console.log(room_type);
                    $("#room_type").val(null);

                    var room_location = $("#room_location").val();
                    console.log(room_location);
                    $("#room_location").val(null);

                    var room_position = $("#room_position").val();
                    console.log(room_position);
                    $("#room_position").val(null);

                    var seat_capacity = $("#seat_capacity").val();
                    console.log(seat_capacity);
                    $("#seat_capacity").val(null);

                    var accessories = $("#accessories").val();
                    console.log(accessories);
                    $("#accessories").val(null);

                    $("#search_value").val(null);

                    $("#btn_insert").prop("disabled", false);
                    $("#btn_update").prop("disabled", true);
                    //$("#form").trigger('reset');

                    $.ajax({
                        method: 'post',
                        url: '{{url('event/update_room_info')}}',
                        data: {
                            _token: '{{csrf_token()}}',
                            room_id: room_id,
                            room_name: room_name,
                            room_type: room_type,
                            room_location: room_location,
                            room_position: room_position,
                            seat_capacity: seat_capacity,
                            accessories: accessories
                        },
                        success: function (data) {
                            // console.log(data[0]['req_id']);
                            toastr.success('Data has been updated successfully ');
                        },
                        error: function () {
                            toastr.error('Failed to update Data ');

                        }
                    });
                }else{
                   alert('Fill up all the Field!!');
            }
                });

                //Search Jquery
                $('#room_list').select2({
                    ajax: {
                        url: 'https://api.github.com/orgs/select2/repos',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: 'public'
                            };

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        }
                    }
                });
            }
        );

        $('#search_type').on('change', function (e) {
            e.target.value === 'room_id' ?
                $('#search_value').attr('placeholder', 'Enter Room ID') : $('#search_value').attr('placeholder', 'Enter Room Name');

        });

        $('#search_value').on('keyup', function (e) {

            console.log("console " + $("#search_value").val().length);

            if ($("#search_value").val().length > 0) {
                console.log($('#search_type').val());
                console.log(e.target.value);

                $.ajax({
                    method: 'post',
                    url: '{{url('event/search_room')}}',
                    data: {
                        _token: '{{csrf_token()}}', type: $('#search_type').val(), s_query: e.target.value.toUpperCase()
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.results.length > 0) {
                            var s_result = '<ul>';
                            for (var i = 0; i < data.results.length; i++) {
                                s_result += '<li class="room_name_val" data-value="' + data.results[i].room_id + "|" + data.results[i].room_name + "|" + data.results[i].room_type + "|" + data.results[i].room_location + "|" + data.results[i].room_position + "|" + data.results[i].room_capacity + "|" + data.results[i].room_accessories + '">' + data.results[i].room_id + '  ' + data.results[i].room_name + '</li>';

                            }
                            s_result += '</ul>';
                            console.log(s_result);
                            $('#result').empty().append(s_result);
                            $("#result").show();
                        }
                    },
                    error: function () {
                        toastr.error('Error in Search');
                    }
                })
            } else {
                $("#result").hide();
            }
        });

        $(document.body).on('click', '.room_name_val', function (e) {
            console.log($(this).context.dataset.value.split('|'));
            var split_data = $(this).context.dataset.value.split('|');
            $("#room_id").val(split_data[0]);
            $("#room_name").val(split_data[1]);
            $("#room_type").val(split_data[2]);
            $("#room_location").val(split_data[3]);
            $("#room_position").val(split_data[4]);
            $("#seat_capacity").val(split_data[5]);
            $("#accessories").val(split_data[6]);

            $("#btn_insert").prop("disabled", true);
            $("#btn_update").prop("disabled", false);
            $("#result").hide();
            $("#search_value").val(split_data[0] + '    ' + split_data[1]);


        })

    </script>

@endsection
