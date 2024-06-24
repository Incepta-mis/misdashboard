<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 19/02/2020
 * Time: 12:06 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','Adjustment - Local Travel')
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

    <form method="post" id="adjustmentForm" action="{{ route('local.storeAdjustment') }}">
        {{ csrf_field() }}

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                       Adjustment - Local Travel
                    </label>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="advice_no" class="col-md-4 col-sm-4 control-label"><b>Document
                                        Number: </b></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control document_no" id="document_no"
                                            name="document_no">
                                        <option value="">Select Document</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                    <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                        <i class="fa fa-check"></i> <b>Display Document</b></button>
                                </div>
                            </div>
                        </div>
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

    <div class="row" id="routeInformation" style="display: none;">
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
                            <td colspan="3" class="text-center"><b>Route </b></td>
                            <td colspan="2" class="text-center"><b>Date</b></td>
                        </tr>
                        <tr>
                            <td class="text-center">FROM</td>
                            <td class="text-center">TO</td>
                            <td class="text-center">DESTINATION</td>
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



                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>


                </div>
            </section>
        </div>
    </div>

    <div class="row" id="expenditureDiv" style="display: none;">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-primary">
                <div class="panel-heading">
                    <label class="text-default">
                        Expenditure
                    </label>
                </div>
                <div class="panel-body table-responsive table">

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



                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>


                </div>
            </section>
        </div>
    </div>


    <div class="row" style="display: none;" id="saveDiv">
        <div class="col-md-4 col-sm-4 text-center" style="padding-top: 1%">
            <section class="panel">
                <div class="panel-body">
                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-inbox"></i> Save or Update </button>
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
        var counter = 1;
        $('#routeInformation').hide();
        $(function () {
            var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id  }}";
            $(".document_no").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "get",
                url: '{{route('local.getMyLocalAdjustmentNO')}}',
                data: {emp_id: emp_id},
                dataType: 'json',
                success: function (response) {

                    console.log(response);

                    var selItems = '';
                    selItems += "<option value=''>Select Document Number</option>";
                    for (var l = 0; l < response.length; l++) {
                        var id = response[l]['document_no'];
                        var val = response[l]['document_no'];
                        selItems += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.document_no').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $(".document_no").select2();
        });

        $('#btn_display').on('click', function () {
            var document_no = $('#document_no').val();
            var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id }}";
            var url = "{{ route('local.getMyLocalAdvance') }}";
            $("#loader").show();
            $.ajax({
                // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                type: "get",
                url: url, // you need change it.
                data: {
                    'emp_id': emp_id,
                    'document_no': document_no
                },
                success: function (data) {
                    $("#loader").hide();
                    console.log(data);
                    // alert(data[i].to_loc);
                    $("#routeInformation").show();
                    $("#expenditureDiv").show();
                    $("#saveDiv").show();

                    function getDatetime( parameter ) {
                        // European date is dd/mm/yyyy and US is mm/dd/yyyy
                        // console.log(d.toLocaleString("en-US"));
                        // console.log(d.toLocaleString("en-GB"));
                        var d = new Date(parameter);
                        var date = d.toLocaleString("en-AU");
                        //var time = d.toLocaleString([],{ hour: 'numeric', minute: 'numeric', hour12: true });
                        //console.log(date+time);
                        return date;
                    }

                    var htmlTable = '';
                    var htmlExpTable = '';
                    $.each(data, function(i, item) {
                        console.log(data[i]);
                        counter +=i;
                         htmlTable += '<tr>\n' +
                            '                            <td>\n' +
                            '                                <input type="hidden" class="days form-control tblrowId" value="1">\n' +
                            '                                <input type="hidden" name="id[]" value="'+ data[i].id+'"> \n' +
                            '                                <input type="hidden" name="emp_id[]" value="'+ data[i].emp_id+'"> \n' +
                            '                                <input type="hidden" name="emp_name[]" value="'+ data[i].emp_name+'"> \n' +
                            '                                <input type="hidden" name="grade[]" value="'+ data[i].grade+'"> \n' +
                            '                                <input type="hidden" name="dept_name[]" value="'+ data[i].dept_name+'"> \n' +
                            '                                <input type="hidden" name="desig_name[]" value="'+ data[i].desig_name+'"> \n' +
                            '                                <input type="hidden" name="purpose[]" value="'+ data[i].purpose+'"> \n' +
                            '                                <input type="hidden" name="cost_center_id[]" value="'+ data[i].cost_center_id+'"> \n' +
                            '                                <input type="hidden" name="cost_center_name[]" value="'+ data[i].cost_center_name+'"> \n' +
                            '                                <input type="hidden" name="gl_code[]" value="'+ data[i].gl_code+'"> \n' +
                            '                                <input class="form-control input-md  from_loc" readonly="readonly" name="from_loc[]" value="'+data[i].from_loc+'"> \n' +
                            '                            </td>\n' +
                            '                            <td>\n' +
                            '                                <input class="form-control input-md  to_loc" readonly="readonly" value="'+data[i].to_loc+'" name="to_loc[]">\n' +
                            '                            </td>\n' +
                            '                            <td>\n' +
                            '                                <input class="form-control input-md  destination" value="'+data[i].from_loc+'" name="destination[]">\n' +
                            '                                </td>\n' +
                            '                            <td>\n' +
                            '                                <div class=\'input-group date datetimepicker1 \'><input type=\'text\'\n' +
                            '                                                                                      class="form-control  date_from"\n' +
                            '                                                                                      name="from_time[]" autocomplete="off" value="'+getDatetime(data[i].from_time)+'"/><span\n' +
                            '                                            class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>\n' +
                            '                                </div>\n' +
                            '                            </td>\n' +
                            '                            <td>\n' +
                            '                                <div class=\'input-group date datetimepicker2\'><input type=\'text\'\n' +
                            '                                                                                     class="form-control  date_to"\n' +
                            '                                                                                     name="to_time[]" autocomplete="off" value="'+getDatetime(data[i].to_time)+'"/><span\n' +
                            '                                            class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>\n' +
                            '                                </div>\n' +
                            '                            </td>\n' +
                            '                            <td style="text-align: center"><input type="text" name="days[]"\n' +
                            '                                                                  class="days form-control duration" value="'+data[i].days+'" readonly=""></td>\n' +
                            '                            <td><a class="deleteRow"></a></td>\n' +
                            '                        </tr>';

                         htmlExpTable += '<tr>\n' +
                             '                                <td>\n' +
                             '                                    <input type="hidden" name="" class="days form-control tblrowId" value="'+counter+'">\n' +
                             '                                    <input type="text"  autocomplete="off" value="'+data[i].accommodation+'" name="accommodation[]" class="days form-control accommodation ">\n' +
                             '                                </td>\n' +
                             '                                <td>\n' +
                             '                                    <input type="text"  autocomplete="off" value="'+data[i].meals+'" name="meals[]" class="days form-control meals">\n' +
                             '                                </td>\n' +
                             '                                <td>\n' +
                             '                                    <input type="text"  autocomplete="off" value="'+data[i].incidentals+'"  name="incidentals[]" class="days form-control incidentals">\n' +
                             '                                </td>\n' +
                             '                                <td>\n' +
                             '                                    <input type="text"  autocomplete="off"  name="da[]" value="'+data[i].da+'" class="days form-control da">\n' +
                             '                                </td>\n' +
                             '                                <td>\n' +
                             '                                    <select name="means_of_transport[]" id="means_of_transport" class="form-control">\n' +
                             '                                        <option value="'+data[i].means_of_transport+'">'+data[i].means_of_transport+'</option>\n' +
                             '                                        <option value="BUS">BUS</option>\n' +
                             '                                        <option value="TRAIN">TRAIN</option>\n' +
                             '                                        <option value="AIR">AIR</option>\n' +
                             '                                        <option value="OTHERS">OTHERS</option>\n' +
                             '                                    </select>\n' +
                             '                                </td>\n' +
                             '                                <td>\n' +
                             '                                    <input type="text" autocomplete="off" value="'+data[i].transport+'" name="transport[]" class="days form-control transport">\n' +
                             '                                </td>\n' +
                             '                                <td><input type="text" autocomplete="off" value="'+data[i].others+'" name="others[]" class="days form-control others"></td>\n' +
                             '                                <td><input type="text" autocomplete="off" value="'+data[i].linetotal+'" name="linetotal[]" class="days form-control linetotal"></td>\n' +
                             '                                <td><a class="deleteRow"></a></td>\n' +
                             '                            </tr>';

                    });

                    $("#myTable tbody").empty().append(htmlTable);
                    $("#expenditure tbody").empty().append(htmlExpTable);




                    $('.datetimepicker2').on('dp.change', function (e) {
                        var from = $(this).closest('tr').find('.datetimepicker1').find('.date_from').val();
                        var tblrowId = $(this).closest('tr').find('.tblrowId').val();
                        var to = $(this).find('.date_to').val();
                        if (to && from) {
                            if (getDuration(from, to)) {
                                $(this).closest('tr').find('.days').val(getDuration(from, to));
                               // console.log('tblrowId == ', tblrowId);
                            }
                        }});

                },
                error: function (e) {
                    console.log('Error : ', e);
                }
            });
        });


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


        $(document).on("click", "#addrow", function () {
            counter +=1;
            console.log('counter = ',counter);
            var newRow = $("<tr>");
            var cols = "";
            cols += '<td> <input type="hidden" class="tblrowId" autocomplete="off" value="' + counter + '"> <select class="form-control input-xs  from_loc" name="from_loc[]"></select> </td>';
            cols += '<td> <select class="form-control input-xs  to_loc"  name="to_loc[]"></select> </td>';
            cols += '<td> <input class="form-control input-xs  destination"  name="destination[]"> </td>';
            cols += '<td><div class=\'input-group date datetimepicker1 \'><input type=\'text\' autocomplete="off" class="form-control  date_from" name="from_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            cols += '<td><div class=\'input-group date datetimepicker2\'><input type=\'text\' autocomplete="off" class="form-control  date_to" name="to_time[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            cols += '<td  style="text-align: center"> <input type="text" autocomplete="off" name="days[]" class="days form-control" readonly=""> </span></td>';
            cols += '<td><span class="ibtnDel btn btn-danger "><i class="fa fa-trash-o"></i> </span> </td>';
            newRow.append(cols);
            $("table.order-list").append(newRow);


            var newRowExp = $("<tr>");
            var colsExp = "";
            colsExp += '<td> <input type="hidden"  autocomplete="off" class="tblrowId" value="' + counter + '">' +
                ' <input type="text"  name="accommodation[]" class="days form-control accommodation "></td>';
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
            colsExp += '<td><input type="text"  autocomplete="off" name="linetotal[]" class="days form-control linetotal"></td>';
            newRowExp.append(colsExp);
            $("table.expenditure-list").append(newRowExp);

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
                }});

            });



        $(function () {
            $("body").on("click", ".datetimepicker1", function(){
                $(this).datetimepicker({format: 'DD/MM/YYYY hh:mm:ss A'});
                $(this).datetimepicker("show");
            });
            $("body").on("click", ".datetimepicker2", function(){
                $(this).datetimepicker({format: 'DD/MM/YYYY hh:mm:ss A'});
                $(this).datetimepicker("show");
            });
        });



    </script>

@endsection
