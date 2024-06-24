<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 19/02/2020
 * Time: 12:06 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','Local Application')
@section('styles')

    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

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

        body {
            color: black;
        }

        .help-block {
            color: red;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
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

        x::-webkit-file-upload-button, input[type=file]:after {
            content: 'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border: 0px;
        }

        input {
            color: black;
            font-size: x-small;
        }

        #myTable > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }

        .cnt {
            text-align: center;
        }


        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }

    </style>
@endsection
@section('right-content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->

    <form method="post" id="advanceForm" action="{{ route('local.storeAdvance') }}">
        {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Advance Req. Form (Annex-C)
                    </label>
                </div>
                <div class="panel-body table-responsive table " style="padding-top: 2%">

                    <table class="table table-bordered table-hover" width="100%" id="arf_table">
                        <thead>
                        <tr>
                            <th colspan="4" class="text-center">REQUISITION BY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>NAME</td>
                            <td>{{ $employeeInfo[0]->sur_name }}</td>
                            <td>GRADE</td>
                            <td colspan="2" id="grade">{{ $employeeInfo[0]->grade }}</td>
                        </tr>
                        <tr>
                            <td>EMPLOYEE CODE</td>
                            <td>{{ $employeeInfo[0]->emp_id }}</td>
                            <td>COST CENTER CODE</td>
                            <td colspan="2">{{ $employeeInfo[0]->cost_center_id }}
                                | {{ $employeeInfo[0]->cost_center_name }}</td>
                        </tr>
                        <tr>
                            <td>DESIGNATION</td>
                            <td>{{ $employeeInfo[0]->desig_name }}</td>
                            <td>GL</td>
                            <td colspan="2" style="background-color: #a6e1ec;">
                                <div class="form-group">
                                    <select class="form-control input-sm" id="gl_code" name="gl_code">
                                        <option value="">Please Select GL</option>
                                        <option value="52010880">52010880 | Traveling Expense (employee/local)</option>
                                        <option value="52011180">52011180 | Traveling Expense: Employee/Foreign</option>
                                        <option value="52011370">52011370 | Training Expenses-Foreign</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>DEPARTMENT</td>
                            <td>{{ $employeeInfo[0]->dept_name }}</td>
                            <td>Document No</td>
                            <td>
                                {{ $randomNumber }}

                                <input type="hidden" name="document_no" value="{{ $randomNumber }}">
                                <input type="hidden" name="emp_id" value="{{ $employeeInfo[0]->emp_id }}">
                                <input type="hidden" name="emp_name" value="{{ $employeeInfo[0]->sur_name }}">
                                <input type="hidden" name="grade" value="{{ $employeeInfo[0]->grade }}">
                                <input type="hidden" name="cost_center_id" value="{{ $employeeInfo[0]->cost_center_id }}">
                                <input type="hidden" name="cost_center_name" value="{{ $employeeInfo[0]->cost_center_name }}">
                                <input type="hidden" name="desig_name" value="{{ $employeeInfo[0]->desig_name }}">
                                <input type="hidden" name="dept_name" value="{{ $employeeInfo[0]->dept_name }}">
                            </td>
                        </tr>
                        <tr>
                            <td>PURPOSE</td>
                            <td colspan="2" style="background-color: #a6e1ec;">
                                <div class="form-group">
                                    <select class="form-control input-sm" id="purpose" name="purpose">
                                        <option value="">Please Select GL</option>
                                        <option value="Conference and seminar">Conference and seminar</option>
                                        <option value="Local trade fare">Local trade fare</option>
                                        <option value="Training">Training</option>
                                        <option value="Business strategy tour">Business strategy tour</option>
                                        <option value="Market survey">Market survey</option>
                                        <option value="Business promotion">Business promotion</option>
                                        <option value="Audit and investigation">Audit and investigation</option>
                                        <option value="Follow up of depot activities">Follow up of depot activities</option>
                                        <option value="Legal issues">Legal issues</option>
                                        <option value="Supporting depot operation">Supporting depot <operation></operation></option>
                                    </select>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>

                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-primary">
                <div class="panel-heading">
                    <label class="text-default">
                        Route Information
                    </label>
                </div>
                <div class="panel-body table-responsive table">

                    <table id="myTable" class="table table-bordered table-hover order-list" width="100%">
                        <thead>
                        <tr>
                            <td colspan="2" class="text-center"><b>Route </b></td>
                            <td colspan="2" class="text-center"><b>Date</b></td>
                        </tr>
                        <tr>
                            <td class="text-center">FROM</td>
                            <td class="text-center">TO</td>
                            <td class="text-center">FROM</td>
                            <td class="text-center">TO</td>
                            <td class="text-center">Duration</td>
                            <td style="text-align: center;">
                                <a id="addrow" type="button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </a>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type="hidden" class="days form-control tblrowId" value="1">
                                <select class="form-control input-md  from_loc" name="from_loc[]"></select>
                            </td>
                            <td>
                                <select class="form-control input-md  to_loc" name="to_loc[]">
                                </select>
                            </td>
                            <td>
                                <div class='input-group date datetimepicker1 '><input type='text'
                                                                                      class="form-control  date_from"
                                                                                      name="from_time[]"/><span
                                            class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </td>
                            <td>
                                <div class='input-group date datetimepicker2'><input type='text'
                                                                                     class="form-control  date_to"
                                                                                     name="to_time[]"/><span
                                            class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </td>
                            <td style="text-align: center"><input type="text" name="days[]"
                                                                  class="days form-control duration" readonly=""></td>
                            <td><a class="deleteRow"></a></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>


                </div>
            </section>
        </div>
    </div>

    <div class="row" id="divExpenditure">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-warning">
                <div class="panel-heading">
                    <label class="text-default">
                        EXPENDITURE
                    </label>
                </div>
                <div class="panel-body table-responsive table">
                    @if(
                        $employeeInfo[0]->grade == 'M01-1'
                        || $employeeInfo[0]->grade == 'M01-2'
                        || $employeeInfo[0]->grade == 'M02'
                        || $employeeInfo[0]->grade == 'M03'
                        || $employeeInfo[0]->grade == 'M04'
                        || $employeeInfo[0]->grade == 'M05'
                        || $employeeInfo[0]->grade == 'H00'
                        || $employeeInfo[0]->grade == 'H01'
                        || $employeeInfo[0]->grade == 'H02'
                        || $employeeInfo[0]->grade == 'H03'
                        || $employeeInfo[0]->grade == 'H04-1'
                        || $employeeInfo[0]->grade == 'H04-2'
                     )
                    <table id="expenditure" class="table table-bordered table-hover expenditure-list" width="100%">
                        <thead>
                        <th>ACCOMMODATION CHARGE</th>
                        <th>MEALS</th>
                        <th>INCIDENTALS</th>
                        <th>DAILY ALLOWANCE</th>
                        <th>MEANS OF TRANSPORT</th>
                        <th>TRANSPORT FARE</th>
                        <th>OTHERS</th>
                        <th>Total</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="" class="days form-control tblrowId" value="1">
                                <input type="text" autocomplete="off" name="accommodation[]" class="days form-control accommodation ">
                            </td>
                            <td>
                                <input type="text" autocomplete="off" name="meals[]" class="days form-control meals">
                            </td>
                            <td>
                                <input type="text" autocomplete="off" name="incidentals[]" class="days form-control incidentals">
                            </td>
                            <td>
                                <input type="text" autocomplete="off" readonly name="da[]" class="days form-control da">
                            </td>
                            <td>
                                <select name="means_of_transport[]" id="means_of_transport" class="form-control">
                                    <option value="">Select..</option>
                                    <option value="BUS">BUS</option>
                                    <option value="TRAIN">TRAIN</option>
                                    <option value="AIR">AIR</option>
                                    <option value="OTHERS">OTHERS</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" autocomplete="off" name="transport[]" class="days form-control transport">
                            </td>
                            <td><input type="text" autocomplete="off" name="others[]" class="days form-control others"></td>
                            <td><input type="text" readonly autocomplete="off" name="linetotal[]" class="days form-control linetotal"></td>
                            <td><a class="deleteRow"></a></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    @else
                        <table id="expenditure" class="table table-bordered table-hover expenditure-list" width="100%">
                            <thead>
                            <th>ACCOMMODATION CHARGE</th>
                            <th>MEALS</th>
                            <th>INCIDENTALS</th>
                            <th>DAILY ALLOWANCE</th>
                            <th>MEANS OF TRANSPORT</th>
                            <th>TRANSPORT FARE</th>
                            <th>OTHERS</th>
                            <th>Total</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input type="hidden" name="" class="days form-control tblrowId" value="1">
                                    <input type="text" readonly autocomplete="off" name="accommodation[]" class="days form-control accommodation ">
                                </td>
                                <td>
                                    <input type="text" readonly autocomplete="off" name="meals[]" class="days form-control meals">
                                </td>
                                <td>
                                    <input type="text" readonly autocomplete="off" name="incidentals[]" class="days form-control incidentals">
                                </td>
                                <td>
                                    <input type="text" readonly autocomplete="off" name="da[]" class="days form-control da">
                                </td>
                                <td>
                                    <select name="means_of_transport[]" id="means_of_transport" class="form-control">
                                        <option value="">Select..</option>
                                        <option value="BUS">BUS</option>
                                        <option value="TRAIN">TRAIN</option>
                                        <option value="AIR">AIR</option>
                                        <option value="OTHERS">OTHERS</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" autocomplete="off" name="transport[]" class="days form-control transport">
                                </td>
                                <td><input type="text" autocomplete="off" name="others[]" class="days form-control others"></td>
                                <td><input type="text" readonly autocomplete="off" name="linetotal[]" class="days form-control linetotal"></td>
                                <td><a class="deleteRow"></a></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    @endif
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel">
                <div class="panel-body">
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-inbox"></i> Save </button>
                    <button type="reset" class="btn btn-primary" ><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
                </div>
            </section>
        </div>
    </div>

    </form>

    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">

        var employeeGrade = "{{  $employeeInfo[0]->grade }}";
        console.log(employeeGrade);

        $("button[type='reset']").on("click", function(event){
            event.preventDefault();
            var advanceForm = $(this).closest('form').get(0);
            advanceForm.reset();
            $(".from_loc", advanceForm).each(
                function () {
                    $(this).select2('val',$(this).find('option:selected').val())
                }
            );
            $(".to_loc", advanceForm).each(
                function () {
                    $(this).select2('val',$(this).find('option:selected').val())
                }
            );
        });
        $(document).ready(function () {

            var noOfDays = '';

            // destination
            function initializeSelect2(selectElementObj) {
                selectElementObj.select2({
                    placeholder: 'Select location',
                    minimumInputLength: 3,
                    dropdownAutoWidth: true,
                    width: 'auto',
                    ajax: {
                        url: "{{ route('local.getLocation') }}",
                        dataType: 'json',
                        delay: 150,
                        data: function (term) {
                            return {
                                term: term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.location,
                                        id: item.location
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
            }

            $(".from_loc").each(function () {
                initializeSelect2($(this));
            });
            $(".to_loc").each(function () {
                initializeSelect2($(this));
            });


            // datetime from to
            $('.datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY hh:mm:ss A'
            });
            $('.datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY hh:mm:ss A'
            });

            function getDuration(from, to) {
                var str = '';
                var start = moment(from, "DD/MM/YYYY");
                var end = moment(to, "DD/MM/YYYY");

                var years = end.diff(start, 'year');
                start.add(years, 'years');

                var months = end.diff(start, 'months');
                start.add(months, 'months');

                var days = end.diff(start, 'days');

                noOfDays = days + 1;

                var night = 0;
                var oneDay = 1000 * 60 * 60 * 24;
                night = Math.round((end - start) / oneDay);

                var yearsStr = years ? years + ' years ' : '';
                var monthsStr = months ? months + ' months ' : '';
                var daysStr = days ? parseInt(days + 1) + ' days ' : '';

                if (from === to) {
                    str = '1 day ' + night + ' night';
                } else {
                    str = yearsStr + monthsStr + daysStr + night + ' nights';
                }

                return str;
            }


            $('.datetimepicker2').on('dp.change', function (e) {

                var from = $(this).closest('tr').find('.datetimepicker1').find('.date_from').val();
                var to = $(this).find('.date_to').val();
                if (to && from) {
                    if (getDuration(from, to)) {
                        $(this).closest('tr').find('.days').val(getDuration(from, to));
                    }
                    var user_id = "{{ Auth::user()->user_id }}";
                    var grade = $('#grade').html();
                    var location = $('.to_loc').val();
                    var url = "{{ route('local.getExpenditure') }}";


                    if (location) {

                        $.ajax({
                            // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                            type: "POST",
                            url: url, // you need change it.
                            processing: true,
                            language: {
                                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                            },
                            serverSide: true,
                            data: {
                                'user_id': user_id,
                                'grade': grade,
                                'location': location,
                                'days': noOfDays,
                                'from_day': from,
                                'to_day': to,
                                _token: '{{ csrf_token() }}'
                            }, // high importance!
                            success: function (data) {
                                console.log(data);
                                $('.transport').val(data.transport);
                                $('.accommodation').val(data.accommodation);
                                $('.meals').val(data.meals);
                                $('.incidentals').val(data.incidentals);
                                $('.da').val(data.da);
                                var linetotal = '';
                                linetotal = (
                                    parseInt(data.transport)
                                    + parseInt(data.accommodation)
                                    + parseInt(data.meals)
                                    + parseInt(data.incidentals)
                                    + parseInt(data.da)
                                );
                                $('.linetotal').val(linetotal);
                            }
                        })
                    } else {
                        swal({
                            type: 'error',
                            text: 'Select Location and Date',
                        });
                    }

                }
            });

            var counter = 2;
            $(document).on("click", "#addrow", function () {
                var newRow = $("<tr>");
                var cols = "";
                cols += '<td> <input type="hidden" class="tblrowId" autocomplete="off" value="' + counter + '"> <select class="form-control input-xs  from_loc" name="from_loc[]"></select> </td>';
                cols += '<td> <select class="form-control input-xs  to_loc"  name="to_loc[]"></select> </td>';
                cols += '<td><div class=\'input-group date datetimepicker1 \'><input type=\'text\' autocomplete="off" class="form-control  date_from" name="from_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
                cols += '<td><div class=\'input-group date datetimepicker2\'><input type=\'text\' autocomplete="off" class="form-control  date_to" name="to_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
                cols += '<td  style="text-align: center"> <input type="text" autocomplete="off" name="days[]" class="days form-control" readonly=""> </span></td>';
                cols += '<td><span class="ibtnDel btn btn-danger "><i class="fa fa-trash-o"></i> </span> </td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                // counter++;

                var from_locations = $("#myTable").find(".from_loc").last();
                initializeSelect2(from_locations);

                var to_locations = $("#myTable").find(".to_loc").last();
                initializeSelect2(to_locations);


                $('.datetimepicker1').datetimepicker({
                    format: 'DD/MM/YYYY hh:mm:ss A'
                });

                $('.datetimepicker2').datetimepicker({
                    format: 'DD/MM/YYYY hh:mm:ss A'
                });

                $('.datetimepicker2').on('dp.change', function (e) {
                    var from = $(this).closest('tr').find('.datetimepicker1').find('.date_from').val();
                    var tblrowId = $(this).closest('tr').find('.tblrowId').val();
                    var to = $(this).find('.date_to').val();
                    if (to && from) {
                        if (getDuration(from, to)) {
                            $(this).closest('tr').find('.days').val(getDuration(from, to));
                            console.log('RaqibMasroor == ', tblrowId);
                        }

                        var user_id = "{{ Auth::user()->user_id }}";
                        var grade = $('#grade').html();
                        var location = $('.to_loc').val();
                        var url = "{{ route('local.getExpenditure') }}";


                        if (location) {

                            $.ajax({
                                // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                                type: "POST",
                                url: url, // you need change it.
                                processing: true,
                                language: {
                                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                                },
                                serverSide: true,

                                data: {
                                    'user_id': user_id,
                                    'grade': grade,
                                    'location': location,
                                    'days': noOfDays,
                                    'from_day': from,
                                    'to_day': to,
                                    _token: '{{ csrf_token() }}'
                                }, // high importance!
                                success: function (data) {
                                    console.log(data);

                                    $("table.expenditure-list>tbody>tr").each(function (i, v) {
                                        var expRow = $(this).closest("tr").find('.tblrowId').val();
                                        if (tblrowId === expRow) {

                                            $(this).closest('tr').find('.accommodation').val(data.accommodation);

                                            $(this).closest('tr').find('.transport').val(data.transport);

                                            $(this).closest('tr').find('.meals').val(data.meals);

                                            $(this).closest('tr').find('.incidentals').val(data.incidentals);
                                            $(this).closest('tr').find('.da').val(data.da);

                                            var linetotal = '';
                                            linetotal = (
                                                parseInt(data.transport)
                                                + parseInt(data.accommodation)
                                                + parseInt(data.meals)
                                                + parseInt(data.incidentals)
                                                + parseInt(data.da)
                                            );
                                            $(this).closest('tr').find('.linetotal').val(linetotal);

                                        }
                                    });


                                }
                            })
                        } else {
                            swal({
                                type: 'error',
                                text: 'Select Location and Date',
                            });
                        }
                    }
                });


                var newRowExp = $("<tr>");

                if(
                    employeeGrade ==='H00'
                    || employeeGrade ==='H01'
                    || employeeGrade ==='H02'
                    || employeeGrade ==='H03'
                    || employeeGrade ==='H04-1'
                    || employeeGrade ==='H04-2'
                    || employeeGrade ==='M01-1'
                    || employeeGrade ==='M01-2'
                    || employeeGrade ==='M02'
                    || employeeGrade ==='M03'
                    || employeeGrade ==='M04'
                    || employeeGrade ==='M05'
                )
                {
                    var colsExp = "";
                    colsExp += '<td> <input type="hidden"  autocomplete="off" class="tblrowId" value="' + counter + '"> <input type="text" name="accommodation[]" class="days form-control accommodation "></td>';
                    colsExp += '<td> <input type="text"  autocomplete="off" name="meals[]" class="days form-control meals"></td>';
                    colsExp += '<td><input type="text"  autocomplete="off" name="incidentals[]" class="days form-control incidentals"></td>';
                    colsExp += '<td><input type="text"  autocomplete="off"  name="da[]" class="days form-control da"></td>';
                    colsExp += '<td>\n' +
                        '                                <select name="means_of_transport[]" id="means_of_transport" class="form-control">\n' +
                        '                                    <option value="" >Select..</option>\n' +
                        '                                    <option value="BUS">BUS</option>\n' +
                        '                                    <option value="TRAIN">TRAIN</option>\n' +
                        '                                    <option value="AIR">AIR</option>\n' +
                        '                                    <option value="OTHERS">OTHERS</option>\n' +
                        '                                </select>\n' +
                        '                            </td>';
                    colsExp += '<td><input type="text"  autocomplete="off" name="transport[]" class="days form-control transport"></td>';
                    colsExp += '<td><input type="text"  autocomplete="off" name="others[]" class="days form-control others"></td>';
                    colsExp += '<td><input type="text" readonly autocomplete="off" name="linetotal[]" class="days form-control linetotal"></td>';
                    newRowExp.append(colsExp);
                }
                else
                {
                    var colsExp = "";
                    colsExp += '<td> <input type="hidden"  autocomplete="off" class="tblrowId" value="' + counter + '">' +
                        ' <input type="text" readonly name="accommodation[]" class="days form-control accommodation "></td>';
                    colsExp += '<td> <input type="text" readonly autocomplete="off" name="meals[]" class="days form-control meals"></td>';
                    colsExp += '<td><input type="text" readonly autocomplete="off" name="incidentals[]" class="days form-control incidentals"></td>';
                    colsExp += '<td><input type="text" readonly autocomplete="off"  name="da[]" class="days form-control da"></td>';
                    colsExp += '<td>\n' +
                        '                                <select name="means_of_transport[]" id="means_of_transport" class="form-control">\n' +
                        '                                    <option value="" >Select..</option>\n' +
                        '                                    <option value="BUS">BUS</option>\n' +
                        '                                    <option value="TRAIN">TRAIN</option>\n' +
                        '                                    <option value="AIR">AIR</option>\n' +
                        '                                    <option value="OTHERS">OTHERS</option>\n' +
                        '                                </select>\n' +
                        '                            </td>';
                    colsExp += '<td><input type="text"  autocomplete="off" name="transport[]" class="days form-control transport"></td>';
                    colsExp += '<td><input type="text"  autocomplete="off" name="others[]" class="days form-control others"></td>';
                    colsExp += '<td><input type="text" readonly autocomplete="off" name="linetotal[]" class="days form-control linetotal"></td>';
                    newRowExp.append(colsExp);

                }
                $("table.expenditure-list").append(newRowExp);

                counter++;
            });


            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter -= 1;
                var rowId = $(this).closest("tr").find('.tblrowId').val();
                console.log("table row id", rowId);

                $("table.expenditure-list>tbody>tr").each(function (i, v) {
                    var expRow = $(this).closest("tr").find('.tblrowId').val();
                    if (rowId === expRow) {
                        $(this).closest("tr").remove();
                    }
                });

            });

            $(document).on("keyup change", ".transport", function () {
                var rowId = $(this).closest("tr").find('.tblrowId').val();
                $("table.expenditure-list>tbody>tr").each(function (i, v) {
                    var expRow = $(this).closest("tr").find('.tblrowId').val();
                    if (rowId === expRow) {
                        var accommodation = $(this).closest('tr').find('.accommodation').val();
                        var transport = $(this).closest('tr').find('.transport').val();
                        var meals = $(this).closest('tr').find('.meals').val();
                        var incidentals = $(this).closest('tr').find('.incidentals').val();
                        var da = $(this).closest('tr').find('.da').val();
                        var ot = $(this).closest('tr').find('.others').val();
                        var others = 0;
                        if (!isNaN(parseInt(ot))) {
                            others = parseInt(ot);
                        } else {
                            others = 0;
                        }

                        var linetotal = '';
                        linetotal = (
                            parseInt(transport)
                            + parseInt(accommodation)
                            + parseInt(meals)
                            + parseInt(incidentals)
                            + parseInt(da)
                            + parseInt(others)
                        );
                        $(this).closest('tr').find('.linetotal').val(linetotal);


                    }

                });
            });

            $(document).on("keyup change", ".others", function () {
                var rowId = $(this).closest("tr").find('.tblrowId').val();
                $("table.expenditure-list>tbody>tr").each(function (i, v) {
                    var expRow = $(this).closest("tr").find('.tblrowId').val();
                    if (rowId === expRow) {
                        var accommodation = $(this).closest('tr').find('.accommodation').val();
                        var transport = 0;
                        transport = $(this).closest('tr').find('.transport').val();
                        var meals = $(this).closest('tr').find('.meals').val();
                        var incidentals = $(this).closest('tr').find('.incidentals').val();
                        var da = $(this).closest('tr').find('.da').val();
                        var ot = $(this).closest('tr').find('.others').val();

                        if (!isNaN(parseInt(transport))) {
                            transport = parseInt(transport);
                        } else {
                            transport = 0;
                        }

                        var others = 0;
                        if (!isNaN(parseInt(ot))) {
                            others = parseInt(ot);
                        } else {
                            others = 0;
                        }

                        var linetotal = '';
                        linetotal = (
                            parseInt(transport)
                            + parseInt(accommodation)
                            + parseInt(meals)
                            + parseInt(incidentals)
                            + parseInt(da)
                            + parseInt(others)
                        );
                        $(this).closest('tr').find('.linetotal').val(linetotal);
                    }
                });
            });


        });
    </script>
@endsection
