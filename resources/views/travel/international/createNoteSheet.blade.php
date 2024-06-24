<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 30/09/2020
 * Time: 12:31 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','Note Sheet')
@section('styles')

    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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

        .trans {
            color: transparent;
        }

    </style>
@endsection
@section('right-content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close"
                                                                                         data-dismiss="alert"
                                                                                         aria-label="close">&times;</a>
                </p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->

    <form id="advanceForm">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel panel-info">
                    <div class="panel-heading">
                        <label class="text-default">
                            NOTE SHEET
                        </label>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="document_no" class="col-md-6 col-sm-6 control-label"><b>Document
                                            Number: </b></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control input-sm" id="document_no"
                                               name="document_no">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="group_no" class="col-md-6 col-sm-6 control-label checkbox-inline">
                                        <input type="checkbox" id="grp" value=""><b>Group Number: </b>
                                    </label>
                                    <div class="col-md-4 col-sm-4">
                                        <input type="text" class="form-control input-sm" disabled id="group_no"
                                               name="group_no">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Document</b></button>
                                    </div>
                                </div>
                            </div> --}}
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
                </section>
            </div>
        </div>

        <div class="row" id="routeInformation">
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
                                <td colspan="4" class="text-center"><b>Route </b></td>
                                <td colspan="2" class="text-center"><b>Date</b></td>
                                <td colspan="2" class="text-center"><b>BD Local Time</b></td>
                                <td colspan="2" class="text-center"><b>Local Time of visiting country</b></td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">FROM</td>
                                <td class="text-center" colspan="2">TO</td>
                                <td class="text-center">FROM</td>
                                <td class="text-center">TO</td>
                                <td class="text-center">FROM</td>
                                <td class="text-center">TO</td>
                                <td class="text-center">FROM</td>
                                <td class="text-center">TO</td>
                                {{--                                <td class="text-center">Duration</td>--}}
                                <td colspan="2" style="text-align: center;">
                                    <a id="addrow" type="button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </a>
                                </td>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>


                    </div>
                </section>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-md-4 col-sm-4">
                    <div class="col-md-4 col-sm-4 text-center" style="padding-top: 1%">
                        <button type="button" id="showInfo" class="btn btn-info"><i
                                    class="glyphicon glyphicon-inbox"></i>
                            Show
                        </button>

                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="panel" id="rsPanel">
                        <b>Total Day </b> : <span id="tday" style="background-color: #f7dc6f"></span>,
                        <b>Total DA: </b> <span id="tda" style="background-color: #6fb5f7"></span>,
                        <b>Transport :</b> <span id="tp" style="background-color: #f7dc6f"></span> ,
                        <b>Hotel: </b> <span id="ht" style="background-color: #f7dc6f"></span> ,
                        <b>Meal : </b> <span id="ml" style="background-color: #f7dc6f"></span>
                    </div>
                </div>

            </div>
        </div>

        {{-- <div class="facilities" style="display: none">
            <div class="col-md-12 col-sm-12 text-center" style="padding-top: 1%">
                <section class="panel">
                    <div class="panel-body">
                        
                    </div>
                </section>
            </div>
        </div> --}}


        <div class="exp" id="exp">

        </div>


        <div class="row"  id="saveDiv" style="display: none;">
            <div class="col-md-4 col-sm-4 text-center" style="padding-top: 1%">
                <section class="panel">
                    <div class="panel-body">
                        <button type="submit" id="noteSheet_form" class="btn btn-success"><i class="glyphicon glyphicon-inbox"></i> Save </button>
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

        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                return false;
                }
            });
        });

        var counter = 0;
        // $('#routeInformation').hide();
        // $('#expenditureDiv').hide();
        var actualDay = [];


        $("#rsPanel").hide();

        //group no get
        $(function () {

            $('#grp').change(function () {
                if (this.checked) {
                    $('#group_no').prop('disabled', false);
                    var docNo = $('#document_no').val();
                    var url = "{{ route('international.getGrpNo') }}";
                    $.ajax({
                        // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                        type: "GET",
                        url: url, // you need change it.
                        data: {'docNo' : docNo},
                        success: function (data) {

                            if(data.error){
                                $('#group_no').prop('disabled', true);
                                swal({
                                    type: 'error',
                                    text: 'Document Already Exist !'
                                });
                                return false;
                            }else{
                                $('#group_no').val(data[0].group_no);
                            }
                        }
                    });
                } else {
                    $('#group_no').val('');
                    $('#group_no').prop('disabled', true);
                }
            });
        });


        $('#btn_display').on('click', function () {

            $('#btn_display').prop('disabled', true);

            var document_no = $('#document_no').val();
            var group_no = $('#group_no').val();
            var auth_emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id }}";
            var url = "{{ route('international.storeNoteSheet') }}";
            $.ajax({
                // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                type: "post",
                url: url, // you need change it.
                data: {
                    'auth_id': auth_emp_id,
                    'document_no': document_no,
                    'group_no': group_no,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    console.log(data);

                }
            });

            $("#loader").hide();
            // alert(data[i].to_loc);
            $("#routeInformation").show();

            $("#saveDiv").show();

            function getDatetime(parameter) {
                // European date is dd/mm/yyyy and US is mm/dd/yyyy
                // console.log(d.toLocaleString("en-US"));
                // console.log(d.toLocaleString("en-GB"));
                var d = new Date(parameter);
                var date = d.toLocaleString("en-AU");
                //var time = d.toLocaleString([],{ hour: 'numeric', minute: 'numeric', hour12: true });
                //console.log(date+time);
                return date;
            }


        });

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
                                // console.log(item);
                                return {
                                    text: item.countries,
                                    id: item.countries
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


        function getDuration(from, to) {
            var str = '';
            var start = moment(from, "DD/MM/YYYY");
            var end = moment(to, "DD/MM/YYYY");

            var years = end.diff(start, 'year');
            start.add(years, 'years');

            var months = end.diff(start, 'months');
            start.add(months, 'months');

            var days = end.diff(start, 'days');

            // noOfDays = days + 1;
            noOfDays = days;

            var night = 0;
            var oneDay = 1000 * 60 * 60 * 24;
            night = Math.round((end - start) / oneDay);

            var yearsStr = years ? years + ' years ' : '';
            var monthsStr = months ? months + ' months ' : '';
            var daysStr = days ? parseInt(days + 1) : '';

            /*if (from === to) {
                str = '1 day ' + night + ' night';
            } else {
                str = yearsStr + monthsStr + daysStr + night + ' nights';
            }*/


            if (from === to) {
                str = '1';
            } else {
                str = yearsStr + monthsStr + daysStr;
            }

            return str;
        }


        function gethoursDiff(timeStart, timeEnd) {
            var start = moment(timeStart, "DD/MM/YYYY:hh:mm A");
            var end = moment(timeEnd, "DD/MM/YYYY:hh:mm A");

            var duration = moment.duration(end.diff(start));
            var hours = duration.asHours();

            return hours;
        }


        $(document).on("click", "#addrow", function () {
            counter += 1;
            console.log('counter = ', counter);
            var newRow = $("<tr>");
            var cols = "";
            cols += '<td> <input type="hidden" class="tblrowId" autocomplete="off" value="' + counter + '"> ' +
                '<select class="form-control input-xs  from_loc" name="from_loc[]"></select> ' +
                '</td>';
            cols += '<td><input type=\'text\' autocomplete="off" class="form-control input-sm " name="from_loc_text[]"/></td>';
            cols += '<td> <select class="form-control input-xs  to_loc"  name="to_loc[]"></select> </td>';
            cols += '<td><input type=\'text\' autocomplete="off" class="form-control input-sm " name="to_loc_text[]"/></td>';
            cols += '<td><div class=\'input-group date datetimepicker1 \'><input type=\'text\' autocomplete="off" class="form-control  date_from" name="from_date[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            cols += '<td><div class=\'input-group date datetimepicker2\'><input type=\'text\' autocomplete="off" class="form-control  date_to" name="to_date[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            cols += '<td><div class=\'input-group date datetimepicker3 \'><input type=\'text\' autocomplete="off" class="form-control  date_from" name="bd_from_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            cols += '<td><div class=\'input-group date datetimepicker4\'><input type=\'text\' autocomplete="off" class="form-control  date_to" name="bd_to_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            cols += '<td><div class=\'input-group date datetimepicker5 \'><input type=\'text\' autocomplete="off" class="form-control  date_from" name="visit_from_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            cols += '<td><div class=\'input-group date datetimepicker6\'><input type=\'text\' autocomplete="off" class="form-control  date_to" name="visit_to_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            // cols += '<td  style="text-align: center"> <input type="text" autocomplete="off" name="days[]" class="days form-control" readonly=""> </span></td>';
            // cols += '<td><span class="ibtnInfo btn btn-info "><i class="fa fa-info-circle"></i> </span> </td>';
            cols += '<td><span class="ibtnDel btn btn-danger "><i class="fa fa-trash-o"></i> </span> </td>';
            newRow.append(cols);
            $("table.order-list").append(newRow);


            var from_locations = $("#myTable").find(".from_loc").last();
            initializeSelect2(from_locations);

            var to_locations = $("#myTable").find(".to_loc").last();
            initializeSelect2(to_locations);


            $('.datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY'
            });

            $('.datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY'
            });

            $('.datetimepicker3').datetimepicker({
                format: 'hh:mm A'
            });


            $('.datetimepicker4').datetimepicker({
                format: 'hh:mm A'
            });


            $('.datetimepicker5').datetimepicker({
                format: 'hh:mm A'
            });


            $('.datetimepicker6').datetimepicker({
                format: 'hh:mm A'
            });


        });

        $("table.order-list").on("click", ".ibtnDel", function (event) {
            // console.log("counter value is = ",counter);
            $(this).closest("tr").remove();
            // counter -= 1;
            var rowId = $(this).closest("tr").find('.tblrowId').val();
            // console.log("table row id", rowId);


            // $('#expenditureDiv_' + rowId).remove();


        });

        $("table.order-list").on("click", ".ibtnInfo", function (event) {
            var document_no = $('#document_no').val();
            var to_loc = $(this).closest("tr").find('.to_loc').val();

            // console.log("counter value is = ",counter);

            if (document_no === null || to_loc === null) {
                swal({
                    type: 'error',
                    text: 'Document NO and Location must be filled out!',
                });
                return false;
            } else {
                console.log('docuemnt: ', document_no);
                console.log('to_loc: ', to_loc);

                var url = "{{ route('international.getGradeWiseAllowance') }}";
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        'to_loc': to_loc,
                        'document_no': document_no
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.error) {
                            swal({
                                type: 'error',
                                text: data.error
                            });
                            return false;
                        } else {

                        }

                    }
                });
            }

        });


        var cnArray = [];
        var noOfDayArray = [];

        $(document).on("click", "#showInfo", function () {

           

noOfDayArray = [];

var fromLoc = $('select[name="from_loc[]"] option:selected')
    .map(function () {
        return $(this).val();
    }).get();

var toLoc = $('select[name="to_loc[]"] option:selected')
    .map(function () {
        return $(this).val();
    }).get();
// console.log(fromLoc);
// console.log("To Location = ", toLoc);

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

// Unique Country
var unique = fromLoc.filter(onlyUnique);
//console.log("Unique Country", unique); // ['a', 1, 2, '1']


//Array unique count
var count = fromLoc.reduce(function (values, v) {
    if (!values.set[v]) {
        values.set[v] = 1;
        values.count++;
    }
    return values;
}, {set: {}, count: 0}).count;
// console.log("Country Cont = ",count);


var f = toLoc[0];
var l = fromLoc[fromLoc.length - 1];
// console.log('Bangladesh to ', f);
// console.log(l + ' to Bangladesh');

var from_date = $("#myTable input[name='from_date[]']")
    .map(function () {
        return $(this).val();
    }).get();

var to_date = $("#myTable input[name='to_date[]']")
    .map(function () {
        return $(this).val();
    }).get();


// console.log("UN", unique[0]);


var temp = unique[1];
var tempDay = to_date[0];

for (var j = 0; j < toLoc.length; j++) {
    if (toLoc[j] === temp) {
        continue;
    } else {
        var d = getDuration(tempDay, to_date[j]);
        noOfDayArray.push( d );

        temp = toLoc[j];


        var dateMomentObject = moment(to_date[j], "DD/MM/YYYY");
        var mydate = dateMomentObject.add(1, "days").format("DD/MM/YYYY");
       // tempDay = to_date[j];

        tempDay = mydate;

        //console.log('tempDay',tempDay);
        cnArray.push(to_date[j]);
    }
}
// console.log("Country Visit Date = ", cnArray);
//console.log("Country Day = ", noOfDayArray);


var firstdate = from_date[0];
var lastdate = to_date[to_date.length - 1];
// console.log('Bangladesh to ', firstdate);
// console.log(lastdate + ' to Bangladesh');








var noOfDay = getDuration(firstdate, lastdate);
// console.log(noOfDay);


var bd_from_time = $("#myTable input[name='bd_from_time[]']")
    .map(function () {
        return $(this).val();
    }).get();

var bd_to_time = $("#myTable input[name='bd_to_time[]']")
    .map(function () {
        return $(this).val();
    }).get();


var bdfirsttime = bd_from_time[0];
var bdlasttime = bd_to_time[bd_to_time.length - 1];
// console.log('Bangladesh to ', firstdate);
// console.log(lastdate + ' to Bangladesh');


var firstTime = firstdate + ':' + bdfirsttime;
// console.log(firstTime);
var LastTime = lastdate + ':' + bdlasttime;
// console.log(LastTime);

var da_hours = 0;
da_hours = gethoursDiff(firstTime, LastTime);
var da_day = Math.round(da_hours / 24);

// console.log("Da Day ", da_day);


var document_no = $('#document_no').val();
var url = "{{ route('international.getGradeWiseAllowance') }}";

$.ajax({
    type: "get",
    url: url,
    data: {
        'countries': unique,
        'document_no': document_no
    },
    success: function (data) {
        // console.log(data);

        if (data.error) {
            toastr.error(data.error, 'Error !', {timeOut: 2000});                   
        } else {
            $('#saveDiv').show();
            $("#expenditureDiv").show();
        $("#rsPanel").show();
        var htmlExpTable = '';
        for (var expCounter = 0; expCounter < count - 1; expCounter++) {

            console.log('expCounter = ', expCounter);


            htmlExpTable += '<div class="row expeneDiv" id="expenditureDiv_' + expCounter + '" >\n' +
                '            <div class="col-md-12 col-sm-12" style="padding-top: 1%">\n' +
                '                <section class="panel panel-warning">\n' +
                '                    <div class="panel-heading">\n' +
                '                        <label class="text-default">\n' +
                '                            Estimate Cost\n' +
                '                        </label>\n' +
                '                    </div>\n' +
                '                    <div class="panel-body">\n' +
                '                        <div class="table-responsive">\n' +
                '                            <table class="table table-bordered table-striped table-condensed expenditure_' + expCounter + '" >\n' +
                '                                <tbody>\n' +
                '                                <tr>\n' +
                '                                    <th style="display: none;">exp</th>\n' +
                '                                    <th>SL</th>\n' +
                '                                    <th>Particulars</th>\n' +
                '                                    <th>Rate</th>\n' +
                '                                    <th>Day</th>\n' +
                '                                    <th>Night</th>\n' +
                '                                    <th>Conversion Rate</th>\n' +
                '                                    <th>Amount (BDT)</th>\n' +
                '                                </tr>\n' +
                '                                <tr>\n' +
                '                                    <td style="display: none;"> <input type="text" class="idx" value="' + expCounter + '"</td>\n' +
                '                                    <td>1</td>\n' +
                '                                    <td>Air Fare</td>\n' +
                '                                    <td colspan="3"> <input type="hidden" class="idx" value="' + expCounter + '">\n' +                                                                     
                '                                        <input type="text" class="form-control input-sm air_fare"  name="air_fare[]">\n' +
                '                                    </td>\n' +
                '                                    <td>\n' +
                '                                        <input type="text" class="form-control input-sm conversion_rate"  name="conversion_rate[]">\n' +
                '                                    </td>\n' +
                '                                    <td>\n' +
                '                                        <input type="text" class="form-control input-sm amount_bdt' + expCounter + '"  name="amount_bdt[]">\n' +
                '                                    </td>\n' +
                '                                </tr>\n' +
                '                               <tr>\n' +
                '                                    <td style="display: none;"> <input type="text" class="idx" value="' + expCounter + '"</td>\n' +                            
                '                                    <td>2</td>\n' +
                '                                    <td>Hotel</td>\n' +
                '                                    <td>\n' +
                '                                        <input type="text" class="form-control input-sm  accommodation" id="accommodation" name="accommodation[]" value="' + data[expCounter].map(a => a.accommodation
        )
            +'">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" readonly class="form-control input-sm  trans day_' + expCounter + '"  name="hotel_day[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm hotel_night night_' + expCounter + '"   name="hotel_night[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm conversion_rate" id="conversion_rate" name="conversion_rate[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm amount_bdt' + expCounter + '" id="amount_bdt" name="amount_bdt[]">\n' +
            '                                    </td>\n' +
            '                                </tr>\n' +
            '                                <tr>\n' +
                '                                    <td style="display: none;"> <input type="text" class="idx" value="' + expCounter + '"</td>\n' +
            '                                    <td>3</td>\n' +
            '                                    <td>Meal</td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm meal" id="meal" name="meal[]" value="' + data[expCounter].map(a => a.meals
        )
            +'" >\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm meal_day day_' + expCounter + '"  name="meal_day[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" readonly class="form-control input-sm  trans  night_' + expCounter + '"   name="meal_night[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm conversion_rate" id="conversion_rate" name="conversion_rate[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm amount_bdt' + expCounter + '" id="amount_bdt" name="amount_bdt[]">\n' +
            '                                    </td>\n' +
            '                                </tr>\n' +
            '                                <tr>\n' +
                '                                    <td style="display: none;"> <input type="text" class="idx" value="' + expCounter + '"</td>\n' +
            '                                    <td>4</td>\n' +
            '                                    <td>Incidentals</td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm incidentals" id="incidentals" name="incidentals[]" value="' + data[expCounter].map(a => a.incidentals
        )
            +'" >\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm incidentals_day day_' + expCounter + '"  name="incidentals_day[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" readonly class="form-control input-sm trans night_' + expCounter + '"   name="incidentals_night[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm conversion_rate" id="conversion_rate" name="conversion_rate[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm amount_bdt' + expCounter + '" id="amount_bdt" name="amount_bdt[]">\n' +
            '                                    </td>\n' +
            '                                </tr>\n' +
            '                                <tr>\n' +
                '                                    <td style="display: none;"> <input type="text" class="idx" value="' + expCounter + '"</td>\n' +
            '                                    <td>5</td>\n' +
            '                                    <td>Daily Allowance</td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm da_allow" id="da_allow" name="da_allow[]" value="' + data[expCounter].map(a => a.da
        )
            +'">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" readonly class="form-control input-sm trans da_day"  name="da_day[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            // '                                        <input type="text" class="form-control input-sm da_night night_' + expCounter + '"   name="da_night[]">\n' +
            '                                        <input type="text" style="background-color:#00ffff;" class="form-control input-sm da_night "   name="da_night[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm conversion_rate" id="conversion_rate" name="conversion_rate[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm amount_bdt' + expCounter + '" id="amount_bdt" name="amount_bdt[]">\n' +
            '                                    </td>\n' +
            '                                </tr>\n' +
            '                               <tr>\n' +
                '                                    <td style="display: none;"> <input type="text" class="idx" value="' + expCounter + '"</td>\n' +
            '                                    <td>6</td>\n' +
            '                                    <td>Other</td>\n' +
            '                                    <td colspan="3">\n' +
            '                                        <input type="text" class="form-control input-sm other" id="other" name="other[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm conversion_rate" id="conversion_rate" name="conversion_rate[]">\n' +
            '                                    </td>\n' +
            '                                    <td>\n' +
            '                                        <input type="text" class="form-control input-sm amount_bdt' + expCounter + '" id="amount_bdt" name="amount_bdt[]">\n' +
            '                                    </td>\n' +

            '                                </tr>\n' +
            '                                <tr>\n' +
                '                                    <td style="display: none;"> <input type="text" class="idx" value="' + expCounter + '"</td>\n' +
            '                                    <td colspan="6">Total</td>\n' +
            '                                        <td><input type="text" readonly id="linetotal" class="form-control input-sm linetotal' + expCounter + '" autocomplete="" name="linetotal[]"></td>\n' +
            '                                </tr>\n' +
            '\n' +
            '\n' +
            '                                </tbody>\n' +
            '                                <tfoot>\n' +
            '                                </tfoot>\n' +
            '                            </table>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </section>\n' +
            '            </div>\n' +
            '        </div>';

        }
        $(".exp").empty().append(htmlExpTable);


        for(var i = 0; i < noOfDayArray.length; i++){
            console.log('yes=',noOfDayArray[i]);

            actualDay.push(noOfDayArray[i]);

            $(".exp").find('.day_'+i).val(noOfDayArray[i]);
            $(".exp").find('.night_'+i).val(parseInt(noOfDayArray[i])-1);
        }

        //set da to window
        $('.da_day').val(da_day);
        }

    }
});
$('#tday').text(noOfDay);
$('#tda').text(da_day);


var url = "{{ route('international.getTravelFacilities') }}";
$.ajax({
    type: "get",
    url: url,
    data: {
        'document_no': document_no
    },
    success: function (data) {   
        if (data.error) {
            // toastr.error(data.error, 'Error !', {timeOut: 2000});                   
        } else {
            $('#tp').html(data[0].transport);
            $('#ht').html(data[0].accommodation);
            $('#ml').html(data[0].meal);
        }                     
           
    }
});

});







    $(document).on('change', '.conversion_rate', function () {
        var conversion_rate = $(this).val() || 0;
        var name = $(this).closest('tr').find('td').eq(2).html();
        var id = $(this).closest('tr').find('.idx').val();

        if(name === 'Air Fare'){                
            var air_fare = $(this).closest('tr').find('td').find('.air_fare').val() ||0;
            var rs = parseFloat( parseFloat( conversion_rate )  * parseFloat(air_fare) ).toFixed(2);
            
            parseFloat($(this).closest('tr').find('.amount_bdt'+id).val( rs || 0  )).toFixed(2);             
            var sum = 0;
            $(".amount_bdt"+id).each(function() {
                sum += +$(this).val() || 0;
            });


            $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  );   

        }else if(name === 'Hotel'){   

            var hotel = $(this).closest('tr').find('td').find('.accommodation').val();
            var hotel_night = $(this).closest('tr').find('td').find('.hotel_night').val();
            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(hotel_night) * parseFloat(hotel)).toFixed(2);
            
            $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

            var sum = 0;
            $(".amount_bdt"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  );    

        }else if(name === 'Meal'){               
            var meal = $(this).closest('tr').find('td').find('.meal').val();
            var meal_day = $(this).closest('tr').find('td').find('.meal_day').val();
            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(meal_day) * parseFloat(meal)).toFixed(2);
            
            $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

            var sum = 0;
            $(".amount_bdt"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

        }else if(name === 'Incidentals'){     

            var incidental = $(this).closest('tr').find('td').find('.incidentals').val();
            var incidental_day = $(this).closest('tr').find('td').find('.incidentals_day').val();
            var rs =  parseFloat( conversion_rate)  * parseFloat(incidental_day) * parseFloat(incidental);
            
            console.log('incidental = ',incidental);    
            console.log('incidental_day = ',incidental_day);    
            console.log('rs = ',rs);    


            $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

            var sum = 0;
            $(".amount_bdt"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  );  

        }else if(name === 'Daily Allowance'){               
            var da = $(this).closest('tr').find('td').find('.da_allow').val();
            var da_night = $(this).closest('tr').find('td').find('.da_night').val();

            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(da_night) * parseFloat(da)).toFixed(2);
            
            $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

            var sum = 0;
            $(".amount_bdt"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

        }else if(name === 'Other'){               
            var other = $(this).closest('tr').find('td').find('.other').val();                
            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(other)).toFixed(2) ;

            console.log('Other = ',other);    
            console.log('rs = ',rs);    


            if(other){
                $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );                          
                var sum = 0;
                $(".amount_bdt"+id).each(function() {
                    sum += +$(this).val() || 0;
                });
                $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

            }else{
                parseFloat( $(".linetotal"+id).val(0));
            }
                
        }                                   
    });

        
    $(document).on('change', '.air_fare', function () {
        var air_fare = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var name = $(this).closest('tr').find('td').eq(2).html();
        var id = $(this).closest('tr').find('.idx').val();


        var rs =  parseFloat( conversion_rate)  * parseFloat(air_fare) ;
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 


    });

    $(document).on('change', '.accommodation', function () {
        var hotel = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var hotel_night = $(this).closest('tr').find('.hotel_night').val(); 
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(hotel) * parseFloat(hotel_night);
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 


    });

    $(document).on('change', '.hotel_night', function () {
        var hotel_night = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var hotel = $(this).closest('tr').find('.accommodation').val(); 
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(hotel) * parseFloat(hotel_night);
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.meal', function () {
        var meal = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var meal_day = $(this).closest('tr').find('.meal_day').val(); 
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(meal) * parseFloat(meal_day);
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.meal_day', function () {
        var meal_day = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var meal = $(this).closest('tr').find('.meal_day').val(); 
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(meal) * parseFloat(meal_day);
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.incidentals', function () {
        var incidentals = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var incidentals_day = $(this).closest('tr').find('.incidentals_day').val(); 
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(incidentals) * parseFloat(incidentals_day);
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.incidentals_day', function () {
        var incidentals_day = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var incidentals = $(this).closest('tr').find('.incidentals').val(); 
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(incidentals) * parseFloat(incidentals_day);
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.da_allow', function () {
        var da_allow = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var da_night = $(this).closest('tr').find('.da_night').val(); 
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(da_allow) * parseFloat(da_night);
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.other', function () {
        var other = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        
        var id = $(this).closest('tr').find('.idx').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(other) ;
        
        $(this).closest('tr').find('.amount_bdt'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $("#advanceForm").submit(function(e){
        var grpNo = $('#group_no').val();
        if(grpNo) {
            var docNo = $('#document_no').val();
            var url = "{{ route('international.getCheckDocument') }}";
            $.ajax({
                // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                type: "GET",
                url: url, // you need change it.
                data: {'docNo' : docNo},
                success: function (data) {

                    if(data.error){
                        swal({
                            type: 'error',
                            text: 'Document Already Exist !'
                        });
                        return false;
                    }else{

                        var formdata = $("#advanceForm").serializeArray(); // here $(this) refere to the form its submitting
                        formdata.push( {name: "acctualDay", value: actualDay} );
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('international.updateNoteSheet') }}",
                            data: formdata, // here $(this) refers to the ajax object not form
                            success: function(data) {
                                console.log('success');
                                if (data.success) {
                                    toastr.success(data.success, '', {timeOut: 2000});
                                    location.reload();
                                } else {
                                    toastr.error(data.error, '', {timeOut: 2000});
                                }
                            },
                            error: function(error) {
                                console.log('error');
                            }
                        });

                    }


                }
            });
        }else{
            swal({
                type: 'error',
                text: 'Group Number Not Found !'
            });
            return false;
        }
        e.preventDefault();
    });


    </script>
@endsection