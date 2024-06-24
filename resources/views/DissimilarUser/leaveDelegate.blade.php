@extends('_layout_shared._master')
@section('title', 'Factory Managers Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        input[type=file]::-webkit-file-upload-button {
            width: 0;
            padding: 0;
            margin: 0;
            -webkit-appearance: none;
            border: none;
            border: 0px;
        }

        x::-webkit-file-upload-button,
        input[type=file]:after {
            content: 'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border: 0px;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        /*Here starts styling of table section*/
        .table>thead>tr>th {
            padding: 2px;
            font-size: 12px;
        }

        .table>tbody>tr>td {
            padding: 2px;
            font-size: 11px;
        }

        .table>tfoot>tr>td {
            padding: 2px;
            font-size: 11px;
        }

        body {
            color: #000;
        }

        .odd {
            background-color: #FFF8FB !important;
        }

        .even {
            background-color: #DDEBF8 !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }

        .border-danger {
            border-color: red;
        }
    </style>
@endsection
@section('right-content')

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="leave_delegate_edit_form">
                        {{-- @csrf --}}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                            style="padding-right:0px;"><b>Plant ID</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <select id="plant_id" name="plant_id"
                                                class="form-control input-sm filter-option pull-left" required>
                                                <option value="">Select Plant</option>
                                                {{-- <option value="all">All</option> --}}
                                                @foreach ($plant_info as $plant_infos)
                                                    <option value="{{ $plant_infos->plant_id }}">
                                                        {{ $plant_infos->plant_id }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                                        <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                            style="padding-right:0px;"><b>Employee ID</b></label>
                                        <div class="col-md-7 col-sm-7 ">
                                            <input type="text" class="form-control " name="employee_id" id="employee_id">
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                                        <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                            style="padding-right:0px;"><b>Delegate ID</b></label>
                                        <div class="col-md-7 col-sm-7">
                                            <input type="number" id="delegate_id" name="delegate_id[]" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <button class="btn btn-secondary" type="button" id="plus_btn"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div id="append_div">

                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                                        <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                            style="padding-right:0px;"></label>
                                        {{-- <div class="col-md-2 col-sm-2">
                                            <button class="btn btn-success" type="button" id="plus_btn">Save</button>
                                        </div> --}}
                                        <div class="col-md-7 col-sm-7">
                                            <button class="btn btn-primary" style="float: right"
                                                type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Leave Delegate
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal" id="leave_delegate_form">
                            {{-- @csrf --}}
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-7 col-sm-7 col-xs-7">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                style="padding-right:0px;"><b>Plant ID</b></label>
                                            <div class="col-md-7 col-sm-7">
                                                <select id="plant_id" name="plant_id"
                                                    class="form-control input-sm filter-option pull-left" required>
                                                    <option value="">Select Plant</option>
                                                    {{-- <option value="all">All</option> --}}
                                                    @foreach ($plant_info as $plant_infos)
                                                        <option value="{{ $plant_infos->plant_id }}">
                                                            {{ $plant_infos->plant_id }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger err-mgs"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-7 col-xs-7" style="margin-top: 20px;">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                style="padding-right:0px;"><b>Employee ID</b></label>
                                            <div class="col-md-7 col-sm-7 ">
                                                <input type="text" class="form-control " name="employee_id"
                                                    id="employee_id">
                                                <span class="text-danger err-mgs"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-7 col-xs-7" style="margin-top: 20px;">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                style="padding-right:0px;"><b>Delegate ID</b></label>
                                            <div class="col-md-7 col-sm-7">
                                                <input type="number" name="delegate_id[]" class="form-control" required>
                                                <span class="text-danger err-mgs"></span>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <button class="btn btn-secondary" type="button" id="plus_btn"><i
                                                        class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div id="append_div">

                                        </div>

                                        <div class="col-md-7 col-sm-7 col-xs-7" style="margin-top: 20px;">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                style="padding-right:0px;"></label>
                                            {{-- <div class="col-md-2 col-sm-2">
                                                <button class="btn btn-success" type="button" id="plus_btn">Save</button>
                                            </div> --}}
                                            <div class="col-md-7 col-sm-7">
                                                <button class="btn btn-primary" style="float: right"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{ url('public/site_resource/images/preloader.gif') }}" alt="Loading Report Please wait..."
                        width="35px" height="35px"><br>
                    <span><b><i>Please wait...</i></b></span>
                </div>
                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                    <div id="export_buttons">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="showTable">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <form class="form-horizontal" method="GET" action="">
                                {{-- @csrf --}}
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            {{-- <div class="col-md-7 col-sm-7 col-xs-7">
                                                <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                    style="padding-right:0px;"><b>Plant ID</b></label>
                                                <div class="col-md-7 col-sm-7">
                                                    <select id="plant_id" name="plant_id"
                                                        class="form-control input-sm filter-option pull-left" required>
                                                        <option value="">Select Plant</option>
                                                        @foreach ($plant_info as $plant_infos)
                                                            <option value="{{ $plant_infos->plant_id }}">
                                                                {{ $plant_infos->plant_id }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger err-mgs"></span>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-md-7 col-sm-7 col-xs-7" style="margin-top: 20px;">
                                                <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                    style="padding-right:0px;"><b>Employee ID</b></label>
                                                <div class="col-md-7 col-sm-7 ">
                                                    <input type="text" class="form-control " name="employee_id"
                                                        id="employee_id">
                                                    <span class="text-danger err-mgs"></span>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-7 col-sm-7 col-xs-7" style="margin-top: 20px;">
                                                <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                    style="padding-right:0px;"><b>Select Department</b></label>
                                                <div class="col-md-7 col-sm-7">
                                                    <select id="department"  name="department"
                                                        class="form-control input-sm filter-option pull-left" required>
                                                        @php
                                                            $my_depart = 'All';
                                                            if(isset($_GET['department'])){
                                                                $my_depart = $_GET['department'];
                                                            }
                                                        @endphp
                                                        <option value="All" {{ $my_depart=='All'?'selected':'' }}>All</option>
                                                        
                                                        @foreach ($department_list as $department)
                                                            <option value="{{ $department }}" {{ $my_depart==$department?'selected':'' }}>
                                                                {{ $department }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger err-mgs"></span>
                                                </div>
                                                <div class="col-md-2 col-sm-2">
                                                    <button class="btn btn-primary" style="padding-top: 3px;padding-bottom: 3px;" type="submit"><i class="fa fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <table id="elr" width="100%"
                                class="table table-bordered table-condensed table-striped">
                                <thead style="background-color: darkkhaki;">
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Employee Designation</th>
                                        <th>Joining Date</th>
                                        <th>Person 1</th>
                                        <th>Person 2</th>
                                        <th>Person 3</th>
                                        <th>Person 4</th>
                                        <th>Person 5</th>
                                        <th>Person 6</th>
                                        <th>Person 7</th>
                                        <th>Person 8</th>
                                        <th>Person 9</th>
                                        <th>Person 10</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- {{ dd($leave_delegates) }} --}}
                                    @foreach ($leave_delegates as $leave_delegate)
                                        <tr>
                                            <td>{{ $leave_delegate->emp_id }}</td>
                                            <td>{{ $leave_delegate->emp_name }}</td>
                                            <td> {{ $leave_delegate->designation }}</td>
                                            <td> {{ $leave_delegate->joining_date }}</td>
                                            {{-- <td>
                                                @if ($details[2] ?? null)
                                                    dddd
                                                @endif
                                            </td> --}}
                                            @php
                                                $details = explode(',', $leave_delegate->rsp_person);
                                            @endphp
                                            <td>{{ $details[0] ?? null ? $details[0] : '' }}</td>
                                            <td>{{ $details[1] ?? null ? $details[1] : '' }}</td>
                                            <td>{{ $details[2] ?? null ? $details[2] : '' }}</td>
                                            <td>{{ $details[3] ?? null ? $details[3] : '' }}</td>
                                            <td>{{ $details[4] ?? null ? $details[4] : '' }}</td>
                                            <td>{{ $details[5] ?? null ? $details[5] : '' }}</td>
                                            <td>{{ $details[6] ?? null ? $details[6] : '' }}</td>
                                            <td>{{ $details[7] ?? null ? $details[7] : '' }}</td>
                                            <td>{{ $details[8] ?? null ? $details[8] : '' }}</td>
                                            <td>{{ $details[9] ?? null ? $details[9] : '' }}</td>
                                            <td class="text-center"><button id="edit_btn"
                                                    data-empId="{{ $leave_delegate->emp_id }}"
                                                    data-details="{{ $leave_delegate->rsp_person }}"
                                                    data-plantId="{{ $leave_delegate->plant_id }}" class="btn btn-danger"
                                                    data-toggle="modal" data-target="#myModal"
                                                    style="padding: 0px 2px;"><i style="font-size: 15px;"
                                                        class="fa fa-pencil-square-o"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="createModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

        </div>
    </div>
@endsection

@section('scripts')

    {{ Html::script('public/site_resource/js/toast/toastr.min.js') }}

    {{ Html::script('public/site_resource/js/jquery.dataTables.min.js') }}
    {{ Html::script('public/site_resource/js/dataTables.bootstrap.min.js') }}
    {{ Html::script('public/site_resource/js/dataTables.fixedHeader.min.js') }}

    {{ Html::script('public/site_resource/js/dataTables.buttons.min.js') }}
    {{ Html::script('public/site_resource/js/buttons.bootstrap.min.js') }}
    {{ Html::script('public/site_resource/js/buttons.flash.min.js') }}

    {{ Html::script('public/site_resource/js/jszip.min.js') }}
    {{ Html::script('public/site_resource/js/pdfmake.min.js') }}
    {{ Html::script('public/site_resource/js/vfs_fonts.js') }}

    {{ Html::script('public/site_resource/js/buttons.html5.min.js') }}
    {{ Html::script('public/site_resource/dpicker/moment-with-locales.js') }}
    {{ Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js') }}
    {{-- {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}} --}}
    {{ Html::script('public/site_resource/select2/select2.min.js') }}

    <script type="text/javascript">
        $(document).ready(function() {
            $("#plant").select2();

            $("#elr").DataTable({
                language: {
                    "emptyTable": "No Matching Records Found."
                },
                info: true,
                paging: true,
                filter: true,

            });
        });

        var xtable =

            $('#leave_delegate_form #plus_btn').click(function() {
                $('#leave_delegate_form #append_div').append(`
                <div class="col-md-7 col-sm-7 col-xs-7" style="margin-top: 20px;">
                    <div class="col-md-7 col-sm-7 col-md-offset-3">
                        <input type="number" name="delegate_id[]" class="form-control" required>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button class="btn btn-danger" type="button" id="minus_btn"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            `);
            });

        $(document).on('click', '#leave_delegate_form #minus_btn', function() {
            $(this).parent('div').parent('div').remove();
        })


        $('#leave_delegate_edit_form #plus_btn').click(function() {
            $('#leave_delegate_edit_form #append_div').append(`
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="col-md-7 col-sm-7 col-md-offset-3">
                        <input type="number" name="delegate_id[]" class="form-control" required>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button class="btn btn-danger" type="button" id="minus_btn"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '#leave_delegate_edit_form #minus_btn', function() {
            $(this).parent('div').parent('div').remove();
        })


        $('#leave_delegate_form').on('submit', function(e) {
            $('button[type=submit]', this).addClass('disabled');
            $('button[type=submit]', this).html('Saving...');
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: "{{ url('elm_portal/leave-delegate') }}",
                data: $(this).serialize(),
                success: function(data) {
                    $('button[type=submit]', '#leave_delegate_form').removeClass('disabled');
                    $('button[type=submit]', '#leave_delegate_form').html('Save');
                    $('#leave_delegate_form .err-mgs').each(function(id, val) {
                        $(this).prev('input').removeClass('border-danger')
                        $(this).prev('textarea').removeClass('border-danger')
                        $(this).empty();
                    })
                    $('#leave_delegate_form').trigger('reset');
                    toastr.success('Data saved Successfully', '', {
                        timeOut: 2000,
                        onHidden: () => window.location.reload(),
                    });

                },
                error: function(err) {
                    $('#leave_delegate_form .err-mgs').each(function(id, val) {
                        $(this).prev('input').removeClass('border-danger')
                        $(this).prev('textarea').removeClass('border-danger')
                        $(this).empty();
                    })
                    $.each(err.responseJSON, function(idx, val) {
                        $('#leave_delegate_form #' + idx).addClass('border-danger')
                        $('#leave_delegate_form #' + idx).next('.err-mgs').empty().append(val);
                    })
                    $('button[type=submit]', '#leave_delegate_form').removeClass('disabled');
                    $('button[type=submit]', '#leave_delegate_form').html('Save');
                }
            });
        });

        $(document).on('click', '#edit_btn', function() {
            // console.log($(this).attr('data-plantId'));
            $('#leave_delegate_edit_form #plant_id').val($(this).attr('data-plantId')).trigger('change');
            $('#leave_delegate_edit_form #employee_id').val($(this).attr('data-empId')).attr('readonly', true);
            let details = $(this).attr('data-details').split(",");
            $('#delegate_id').val(details[0]);
            $('#leave_delegate_edit_form #append_div').empty();
            $.each(details, function(i, val) {
                if (i === 0) {
                    return;
                }
                $('#leave_delegate_edit_form #append_div').append(`
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="col-md-7 col-sm-7 col-md-offset-3">
                        <input type="text" name="delegate_id[]" value="${val}" class="form-control" required>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button class="btn btn-danger" type="button" id="minus_btn"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                `);
            })
        })

        $('#leave_delegate_edit_form').on('submit', function(e) {
            $('button[type=submit]', this).addClass('disabled');
            $('button[type=submit]', this).html('Saving...');
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: "{{ url('elm_portal/leave-delegate-update') }}",
                data: $(this).serialize(),
                success: function(data) {
                    $('button[type=submit]', '#leave_delegate_edit_form').removeClass('disabled');
                    $('button[type=submit]', '#leave_delegate_edit_form').html('Save');
                    $('#leave_delegate_edit_form .err-mgs').each(function(id, val) {
                        $(this).prev('input').removeClass('border-danger')
                        $(this).prev('textarea').removeClass('border-danger')
                        $(this).empty();
                    })
                    $('#leave_delegate_edit_form').trigger('reset');
                    $('#myModal').modal('hide');

                    toastr.success('Data saved Successfully', '', {
                        timeOut: 2000,
                        onHidden: () => window.location.reload(),
                    })
                    toastr.options.onHidden = function() {
                        console.log("onHide");
                    };
                    toastr.options.onHidden = function() {
                        alert('goodbye')
                    };

                },
                error: function(err) {
                    $('#leave_delegate_edit_form .err-mgs').each(function(id, val) {
                        $(this).prev('input').removeClass('border-danger')
                        $(this).prev('textarea').removeClass('border-danger')
                        $(this).empty();
                    })
                    $.each(err.responseJSON, function(idx, val) {
                        $('#leave_delegate_edit_form #' + idx).addClass('border-danger')
                        $('#leave_delegate_edit_form #' + idx).next('.err-mgs').empty().append(
                            val);
                    })
                    $('button[type=submit]', '#leave_delegate_edit_form').removeClass('disabled');
                    $('button[type=submit]', '#leave_delegate_edit_form').html('Save');
                }
            });
        });
    </script>
@endsection
@section('footer-content')
    {{ date('Y') }} &copy; Incepta Pharmaceuticals Ltd.
@endsection
