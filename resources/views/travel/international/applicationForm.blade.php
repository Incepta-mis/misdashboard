<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 19/02/2020
 * Time: 12:31 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','My Application')
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

        .form-group.required .control-label:after {
            content:"*";
            color:red;
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

    <form method="post" id="advanceForm" action="{{ route('international.storeAdvance') }}">
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
                                <td>GL <span style="color: red" > * </span></td>
                                <td colspan="2" style="background-color: #a6e1ec;">
                                    <div class="form-group">
                                        <select class="form-control input-sm" id="gl_code" name="gl_code">
                                            <option value="">Please Select GL</option>
                                            <option value="52011180">52011180 | Traveling Expense: Employee/Foreign</option>
                                            <option value="52011370">52011370 | Training Expenses-Foreign</option>
                                            <option value="51010190">51010190 | Incentive Tour Expense-Foreign</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>PASSPORT NO <span style="color: red" > * </span></td>
                                <td><input type="text"  class="form-control" autocomplete="off"  minlength="9" maxlength="9" name="passport_no" id="passport_no"></td>
                                <td>DATE OF ISSUE <span style="color: red" > * </span>
                                    <div class="input-group date date_of_issue ">
                                        <input  type="text" class="form-control date_from" name="date_of_issue" id="date_of_issue">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </td>


                                <td>DATE OF EXPIRY <span style="color: red" > * </span>
                                    <div class="input-group date date_of_expiry ">
                                        <input type="text" class="form-control  date_from" name="date_of_expiry" id="date_of_expiry">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
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
                                <td>Travel Type <span style="color: red" > * </span></td>
                                <td colspan="1">
                                    <div class="form-group">
                                        <select class="form-control input-sm" id="travel_type" name="travel_type">
                                            <option value="">Please Select Travel Type</option>
                                            <option value="Training">Training</option>
                                            <option value="Export Market Expansion Oriented">Export Market Expansion Oriented</option>
                                            <option value="Business Strategy Tour">Business Strategy Tour</option>
                                            <option value="Source/Vendor Audit">Source/Vendor Audit</option>
                                            <option value="Factory Visit">Factory Visit</option>
                                            <option value="Seminar, Symposium">Seminar, Symposium</option>
                                            <option value="International Trade Fare">International Trade Fare</option>
                                            <option value="Contact with suppliers">Contact with suppliers</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </td>
                                <td>PURPOSE <span style="color: red" > * </span></td>
                                <td colspan="1" style="background-color: #a6e1ec;">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" name="purpose" id="purpose"></textarea>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Hotel Rent Born  <span style="color: red" > * </span></td>
                                <td colspan="1">
                                    <div class="form-group required">
                                        <label class="checkbox-inline">
                                            <input type="checkbox"  name="hotel_rent_born[]" id="hotel_rent_born1" value="Company">Company
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="hotel_rent_born[]" id="hotel_rent_born2" value="Vendor">Vendor
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox"  name="hotel_rent_born[]" id="hotel_rent_born3" value="Others">Others
                                        </label>
                                    </div>
                                </td>
                                <td>Meal Expense Born By <span style="color: red" > * </span></td>
                                <td colspan="1">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="meal_expense_born[]" value="Company">Company
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="meal_expense_born[]" value="Vendor">Vendor
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="meal_expense_born[]" value="Others">Others
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>Transport Born By <span style="color: red" > * </span></td>
                                <td colspan="1">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="transport_born[]" value="Company">Company
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="transport_born[]" value="Vendor">Vendor
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="transport_born[]" value="Others">Others
                                    </label>
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
{{--                                <td class="text-center">Duration</td>--}}
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
                                    <div class='input-group date datetimepicker1 '><input type='text' autocomplete="off"
                                                                                          class="form-control  date_from"
                                                                                          name="from_time[]"/><span
                                                class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </td>
                                <td>
                                    <div class='input-group date datetimepicker2'><input type='text' autocomplete="off"
                                                                                         class="form-control  date_to"
                                                                                         name="to_time[]"/><span
                                                class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </td>
{{--                                <td style="text-align: center"><input type="text" name="days[]"--}}
{{--                                                                      class="days form-control duration" readonly=""></td>--}}
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
                            CWIP ASSET RELATED INFO
                        </label>
                    </div>
                    <div class="panel-body table-responsive table">
                        <table class="table table-bordered table-striped table-condensed">
                            <tbody>
                            <tr>
                                <td><p class="text-left">MRP. No.</p></td>
                                <td><input type="text" class="form-control" id="" name="mrp_no" ></td>
                                <td>MRP. Date</td>
                                <td>
                                    <div class="input-group date datetimepicker3 ">
                                        <input type="text" autocomplete="off" class="form-control  date_from" name="mrp_date">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="text-left">SAP PR No.</p></td>
                                <td><input type="text" class="form-control" id="" name="sap_pr_no" ></td>
                                <td>SAP PR Date</td>
                                <td><div class="input-group  date datetimepicker3 ">
                                        <input type="text" autocomplete="off" class="form-control  date_from" name="sap_pr_date">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="text-left">L/C No.</p></td>
                                <td><input type="text" class="form-control" id="" name="lc_no" ></td>
                                <td><p class="text-left">L/C Date.</p></td>
                                <td>
                                    <div class="input-group date datetimepicker3 ">
                                        <input type="text" autocomplete="off" class="form-control  date_from" name="lc_date">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="text-left">PO No.</p></td>
                                <td><input type="text" class="form-control" id="" name="po_no" ></td>
                                <td><p class="text-left">PO Date.</p></td>
                                <td>
                                    <div class="input-group date datetimepicker3 ">
                                        <input type="text" autocomplete="off" class="form-control  date_from" name="po_date">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p class="text-left">CWIP Asset No.</p></td>
                                <td><input type="text" class="form-control" id="" name="cwip_asset_no" ></td>
                                <td><p class="text-left">CWIP Asset Name</p></td>
                                <td><input type="text" class="form-control" id="" name="cwip_asset_name" ></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel">
                    <div class="panel-body">
                        <button type="submit"  class="btn btn-success"><i class="glyphicon glyphicon-inbox"></i> Save </button>
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


        $("#advanceForm").submit(function(){
            var passportNumber = $('#passport_no').val();
            var gl_code = $('#gl_code').val();
            var date_of_issue = $('#date_of_issue').val();
            var date_of_expiry = $('#date_of_expiry').val();
            var travel_type = $('#travel_type').val();
            var purpose = $('#purpose').val();
            var hotel_rent_born1 = $('#hotel_rent_born1').val();
            var hotel_rent_born2 = $('#hotel_rent_born2').val();
            var hotel_rent_born3 = $('#hotel_rent_born3').val();
            
            var hotel_rent_born = $('input[name="hotel_rent_born[]"]:checked').length;
            var meal_expense_born = $('input[name="meal_expense_born[]"]:checked').length;
            var transport_born = $('input[name="transport_born[]"]:checked').length;

            if(!gl_code){
                swal({
                    type: 'error',
                    text: 'Please Select GL Code'
                });
                return false;
            }else if(!passportNumber){
                swal({
                    type: 'error',
                    text: 'Please Enter Valid Passport Number'
                });
                return false;

            }else if(!date_of_issue){
                swal({
                    type: 'error',
                    text: 'Please Enter Passport Issue Date'
                });
                return false;

            }else if(!date_of_expiry){
                swal({
                    type: 'error',
                    text: 'Please Enter Passport Expiry Date'
                });
                return false;

            }else if(!travel_type){
                swal({
                    type: 'error',
                    text: 'Please Select Travel Type'
                });
                return false;

            }else if(!purpose){
                swal({
                    type: 'error',
                    text: 'Please Type Travel Purpose'
                });
                return false;

            }else if (!hotel_rent_born) {
                swal({
                    type: 'error',
                    text: 'Please Select Hotel Born By'
                });
                return false;

            }else if (!meal_expense_born) {
                swal({
                    type: 'error',
                    text: 'Please Select Meal Expense Born By'
                });
                return false;

            }else if (!transport_born) {
                swal({
                    type: 'error',
                    text: 'Please Select Transport Born By'
                });
                return false;

            }else if (!$('.from_loc').val()) {
                swal({
                    type: 'error',
                    text: 'Please Select From Location'
                });
                return false;

            }else if (!$('.to_loc').val()) {
                swal({
                    type: 'error',
                    text: 'Please Select To Location'
                });
                return false;

            }else if (!$('.date_from').val()) {
                swal({
                    type: 'error',
                    text: 'Please Select From Date'
                });
                return false;

            }else if (!$('.date_to').val()) {
                swal({
                    type: 'error',
                    text: 'Please Select To Date'
                });
                return false;

            }else{
                return true;
            }
        });


        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-3d'
        });

        $('.datetimepicker3').datetimepicker({
            format: 'DD/MM/YYYY'
        });


        $('.date_of_issue').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('.date_of_expiry').datetimepicker({
            format: 'DD/MM/YYYY'
        });

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

        $(document).on('change','#passport_no',function () {
            var passportNumber = $('#passport_no').val();
            if(passportNumber.length < 9 ){
                swal({
                    type: 'error',
                    text: 'Passport Minimum and Maximum Length is 9 !'
                });
                return false;
            }
        });

        $(document).ready(function () {

            var noOfDays = '';

            // destination
            function initializeSelect2(selectElementObj) {
                selectElementObj.select2({
                    placeholder: 'Select Country',
                    minimumInputLength: 3,
                    dropdownAutoWidth: true,
                    width: 'auto',
                    ajax: {
                        url: "{{ route('international.getLocation') }}",
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
                                    // return {
                                    //     text: item.airport_name+', '+item.country,
                                    //     id: item.airport_name+', '+item.country,
                                    // }

                                    return {
                                        text: item.countries,
                                        id: item.countries,
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
                format: 'DD/MM/YYYY'
            });
            $('.datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY'
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
                    var url = "{{ route('international.getExpenditure') }}";


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
                // cols += '<td  style="text-align: center"> <input type="text" autocomplete="off" name="days[]" class="days form-control" readonly=""> </span></td>';
                cols += '<td><span class="ibtnDel btn btn-danger "><i class="fa fa-trash-o"></i> </span> </td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                // counter++;

                var from_locations = $("#myTable").find(".from_loc").last();
                initializeSelect2(from_locations);

                var to_locations = $("#myTable").find(".to_loc").last();
                initializeSelect2(to_locations);


                $('.datetimepicker1').datetimepicker({
                    // format: 'DD/MM/YYYY hh:mm:ss A'
                    format: 'DD/MM/YYYY'
                });

                $('.datetimepicker2').datetimepicker({
                    format: 'DD/MM/YYYY'
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
                        var url = "{{ route('international.getExpenditure') }}";


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

        });
    </script>
@endsection
