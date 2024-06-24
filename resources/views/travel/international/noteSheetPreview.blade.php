<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 30/09/2020
 * Time: 12:31 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','Note Sheet Preview')
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
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} 
                    <a href="#" class="close"  data-dismiss="alert" aria-label="close">
                        &times;
                    </a>
                </p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->

    <form id="advanceForm">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel">
                    <div class="panel-body">
                        <table class="display table table-bordered table-striped" style="width:100%; border: 1px solid black; ">
                            <thead>
                                <tr>
                                    <th>Doc No</th>
                                    <th>Name</th>
                                    <th>Emp ID</th>
                                    <th>Designation</th>
                                    <th>GL</th>
                                    <th>CC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tvReq as $r)
                                    <tr>
                                        <td>{{ $r->document_no }}
                                            <input type="hidden" id="document_no" name="document_no" value="{{ $r->document_no }}">                                            
                                         </td>
                                        <td>{{ $r->emp_name }}</td>
                                        <td>{{ $r->emp_id }}</td>
                                        <td>{{ $r->desig_name }}</td>
                                        <td>{{ $r->gl_code }}</td>
                                        <td>{{ $r->cost_center_id }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel panel-info">
                    <div class="panel-body">
                        <h3>Route & Time Information</h3>
    
                        <table id="myTable" class="display table table-bordered table-striped" style="width:100%; border: 1px solid black; ">
                            <thead>
                                <tr>
                                    <th colspan="2" class="textcntr">Route</th>
                                    <th colspan="2" class="textcntr">Date</th>
                                    <th colspan="2" class="textcntr">BD Local Time</th>
                                    <th colspan="2" class="textcntr">Local Time Of Visiting Country</th>
                                </tr>
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tvM as $m)
                                    <tr>
                                        <td>
                                            {{ $m->from_loc_text }}, {{ $m->from_loc }}
                                            <input type="hidden" autocomplete="off" value="{{ $m->from_loc }}"
                                                class="form-control  from_loc" name="from_loc[]">
                                            <input type="hidden" autocomplete="off" value="{{ $m->id }}"
                                                   class="form-control  sl" name="sl[]">
                                        </td>
                                        <td>
                                            {{ $m->to_loc_text }}, {{ $m->to_loc }}
                                            <input type="hidden" autocomplete="off" value="{{ $m->to_loc }}"
                                                class="form-control  to_loc" name="to_loc[]">
                                        </td>
                                        <td>
                                            <div class="input-group date datetimepicker1">
                                                <input type="text" autocomplete="off" value=" {{ date('d-m-Y', strtotime($m->from_date)) }}"
                                                class="form-control  date_from" name="from_date[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                           
                                        </td>
                                        <td>
                                            <div class="input-group date datetimepicker2">
                                                <input type="text" autocomplete="off" value=" {{ date('d-m-Y', strtotime($m->to_date)) }}"
                                                class="form-control  date_from" name="to_date[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                             
                                        </td>
                                        <td>
                                            <div class="input-group date datetimepicker3 ">
                                                <input type="text" autocomplete="off" value=" {{ $m->bd_from_time }}" class="form-control date_from" name="bd_from_time[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                           
                                        </td>
                                        <td>
                                            <div class="input-group date datetimepicker4">
                                                <input type="text" autocomplete="off" value="{{ $m->bd_to_time }}" class="form-control  date_to" name="bd_to_time[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                            
                                        </td>
                                        <td>
                                            <div class="input-group date datetimepicker5">
                                                <input type="text" autocomplete="off" value="{{ $m->fg_from_time }}" class="form-control" name="visit_from_time[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                            
                                        </td>
                                        <td>
                                            <div class="input-group date datetimepicker6">
                                                <input type="text" autocomplete="off" value="{{ $m->fg_to_time }}" class="form-control" name="visit_to_time[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                              
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>        
    
        <div class="row">
            <div class="col-md-12 col-sm-12 text-center" style="padding-top: 1%">
                <section class="panel">
                    <div class="panel-body">
                        <button type="button" id="reCalculate" class="btn btn-primary"><i class="glyphicon glyphicon-bed"></i> Re-Calculate </button>
                    </div>
                </section>
            </div>            
        </div>

        <div class="row" id="rsPanel" style="display: none;">
            <div class="col-md-12 col-sm-12">
                <div class="col-md-8 col-sm-8">
                    <div class="panel" >
                        <b>Total Day </b> : <span id="tday" style="background-color: #f7dc6f"></span>,
                        <b>Total DA: </b> <span id="tda" style="background-color: #6fb5f7"></span>,                        
                    </div>
                </div>

            </div>
        </div>



        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel panel-info">
                    <div class="panel-body">
                        <h3>Expenditure Information</h3>
                        <table id="ex_info" class="display table table-bordered table-striped" style="width:100%; border: 1px solid black; ">
                            <tr style="background-color: #d6a7a7">
                                <td style="display: none;"><b>ID</b></td>
                                <td><b>Particulars</b></td>
                                <td><b>Rate</b></td>
                                <td><b>Day</b></td>
                                <td><b>Night</b></td>
                                <td><b>Conversion Rate</b></td>
                                <td><b>Amount (BDT)</b></td>
                            </tr>
                            @for ($i = 0; $i < count($tvD); $i++)
                                
                                <tr>                                
                                    <td style="display: none;">
                                        <input type="text" class="id" name="id[]" value="{{ $tvD[$i]->id }}">
                                        <input type="hidden" id="group_no" name="group_no" value="{{ $tvD[$i]->group_no }}">
                                    </td>
                                    <td>Air Fare</td>
                                    <td colspan="3"> <input type="text"  class="air_fare" name="air_fare[]" value="{{ $tvD[$i]->air_fare }}">  </td>
                                    <td> <input type="text" class="conversion_rate" name="conversion_rate[]" value="{{ $tvD[$i]->conversion_rate }}"> </td>
                                    <td> <input type="text" class="amount_bdt_{{ $tvD[$i]->id }}" name="amount_bdt[]" value="{{ $tvD[$i]->air_fare * $tvD[$i]->conversion_rate }}"></td>
                                </tr>
                                <tr>    
                                    <td style="display: none;"><input type="text" class="id" name="id[]" value="{{ $tvD[$i]->id }}"></td>
                                    <td>Hotel</td>
                                    <td> <input type="text" class="hotel" name="hotel[]" value="{{ $tvD[$i]->hotel }}">  </td>
                                    <td> </td>
                                    <td> <input type="text" class="hotel_night" name="hotel_night[]" value="{{ $tvD[$i]->hotel_night }}"> </td>
                                    <td> <input type="text" class="conversion_rate" name="conversion_rate[]" value="{{ $tvD[$i]->conversion_rate }} "> </td>
                                    <td> <input type="text" class="amount_bdt_{{ $tvD[$i]->id }}" name="amount_bdt[]" value="{{ $tvD[$i]->hotel * $tvD[$i]->hotel_night * $tvD[$i]->conversion_rate }}"></td>
                                </tr>
                                <tr>    
                                    <td style="display: none;"><input type="text" class="id" name="id[]" value="{{ $tvD[$i]->id }}"></td>
                                    <td>Meal</td>
                                    <td> <input type="text" class="meal" name="meal[]" value="{{ $tvD[$i]->meals }}">  </td>
                                    <td> <input type="text" id="meal_day_{{ $tvD[$i]->id }}" class="meal_day" name="meal_day[]" value="{{ $tvD[$i]->meals_day }}">  </td>
                                    <td> </td>
                                    <td> <input type="text"  class="conversion_rate" name="conversion_rate[]" value="{{ $tvD[$i]->conversion_rate }}"> </td>
                                    <td> <input type="text" class="amount_bdt_{{ $tvD[$i]->id }}" name="amount_bdt[]" value="{{ $tvD[$i]->meals * $tvD[$i]->meals_day * $tvD[$i]->conversion_rate }}"></td>
                                </tr>
                                <tr>
                                    <td style="display: none;"><input type="text" class="id" name="id[]" value="{{ $tvD[$i]->id }}"></td>
                                    <td>Incidental</td>
                                    <td> <input type="text" class="incidental" name="incidental[]" value="{{ $tvD[$i]->incidentals }}">  </td>
                                    <td> <input type="text"  class="incidental_day" name="incidental_day[]" value="{{ $tvD[$i]->incidentals_day }}">  </td>
                                    <td> </td>
                                    <td> <input type="text" class="conversion_rate" name="conversion_rate[]" value="{{ $tvD[$i]->conversion_rate }}"> </td>
                                    <td> <input type="text" class="amount_bdt_{{ $tvD[$i]->id }}" name="amount_bdt[]" value="{{$tvD[$i]->incidentals * $tvD[$i]->incidentals_day * $tvD[$i]->conversion_rate}}"></td>
                                </tr>
                                <tr>
                                    <td style="display: none;"><input type="text" class="id" name="id[]" value="{{ $tvD[$i]->id }}"></td>
                                    <td>Daily Allowance</td>
                                    <td> <input type="text" class="da" name="da[]" value="{{ $tvD[$i]->da }}">  </td>
                                    <td> <input type="hidden" class="id" name="id[]" value="{{ $tvD[$i]->id }}"> </td>
                                    <td> <input type="text" class="da_night" style="background-color: yellow" name="da_night[]" value="{{ $tvD[$i]->da_night }} "> </td>
                                    <td> <input type="text" class="conversion_rate" name="conversion_rate[]" value="{{ $tvD[$i]->conversion_rate }}"> </td>
                                    <td> <input type="text" class="amount_bdt_{{ $tvD[$i]->id }}" name="amount_bdt[]" value="{{$tvD[$i]->da * $tvD[$i]->da_night * $tvD[$i]->conversion_rate}}"> </td>
                                </tr>
                                <tr>
                                    <td style="display: none;"><input type="text" class="id" name="id[]" value="{{ $tvD[$i]->id }}"></td>
                                    <td>Other</td>
                                    <td colspan="3"> <input type="text" class="other" name="other[]" value="{{ $tvD[$i]->others }}">  </td>
                                    <td>
                                        @if (!empty($tvD[$i]->others))
                                          <input type="text" class="conversion_rate" name="conversion_rate[]" value="{{ $tvD[$i]->conversion_rate }}"> 
                                        @else
                                        <input type="text" class="conversion_rate" name="conversion_rate[]" value=""> 
                                        @endif
                                    </td>
                                    <td> <input type="text" class="amount_bdt_{{ $tvD[$i]->id }}" name="amount_bdt[]" value="{{$tvD[$i]->others * $tvD[$i]->conversion_rate}}"></td>
                                </tr>
                                <tr>    
                                    <td style="display: none;"><input type="text" class="id" name="id[]" value="{{ $tvD[$i]->id }}"></td>                    
                                    <td colspan="5" style="background-color: #a6e1ec;"> <span style="float: right;"> BDT TAKA</span></td>
                                    <td style="background-color: #a6e1ec">  
                                        <input type="text" class="linetotal_{{ $tvD[$i]->id }}" name="linetotal[]" value="{{ $tvD[$i]->linetotal }}">                                      
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    </div>
                </section>
            </div>
        </div>
    
        <div class="row"  id="saveDiv">
            <div class="col-md-4 col-sm-4 text-center" style="padding-top: 1%">
                <section class="panel">
                    <div class="panel-body">
                        <button type="submit" id="noteSheet_form" class="btn btn-success"><i class="glyphicon glyphicon-inbox"></i> Update </button>
                    </div>
                </section>
            </div>
            <div class="col-md-4 col-sm-4 text-center" style="padding-top: 1%">
                <section class="panel">
                    <div class="panel-body">
                        <button type="button" id="send_email" class="btn btn-warning"><i class="fa fa-location-arrow"></i> Send Email </button>
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




    $('#send_email').on('click',function(e){
        e.preventDefault();
        var group_no = $('#group_no').val();
        console.log('Yes clicked...',group_no);

        $.ajax({
            url: "{{ route('international.sendHrHeadEmail') }}",
            type: 'get',
            data: { group_no : group_no},
            success : function(data){
                console.log('success');
                if (data.success) {
                    toastr.success(data.success, '', {timeOut: 2000});
                    // location.reload();
                } else {
                    toastr.error(data.error, '', {timeOut: 2000});
                }
            },
            error: function(){

            }
        });
        
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


        var cnArray = [];
        var noOfDayArray = [];

        $(document).on("click", "#reCalculate", function () {

            noOfDayArray = [];
            $('#rsPanel').show();
            var fromLoc = $('input[name="from_loc[]"]')
                .map(function () {
                    return $(this).val();
                }).get();

            var toLoc = $('input[name="to_loc[]"]')
                .map(function () {
                    return $(this).val();
                }).get();

            console.log(fromLoc);
            console.log("To Location = ", toLoc);

            function onlyUnique(value, index, self) {
                return self.indexOf(value) === index;
            }

            // Unique Country
            var unique = fromLoc.filter(onlyUnique);
            console.log("Unique Country", unique); // ['a', 1, 2, '1']


            //Array unique count
            var count = fromLoc.reduce(function (values, v) {
                if (!values.set[v]) {
                    values.set[v] = 1;
                    values.count++;
                }
                return values;
            }, {set: {}, count: 0}).count;
            console.log("Country Cont = ",count);


            var f = toLoc[0];
            var l = fromLoc[fromLoc.length - 1];
            console.log('Bangladesh to ', f);
            console.log(l + ' to Bangladesh');

           

            var from_date = $("#myTable input[name='from_date[]']")
                .map(function () {
                    return $(this).val();
                }).get();

            var to_date = $("#myTable input[name='to_date[]']")
                .map(function () {
                    return $(this).val();
                }).get();


             console.log("from_date", from_date);
             console.log("to_date", to_date);

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

            console.log("Country Visit Date = ", cnArray);
            console.log("Country Day = ", noOfDayArray);


        
            $("#ex_info tr td .meal_day").each(function(index,value){                       
                   $(this).val(noOfDayArray[index]);   
                   
                    var meal_day = noOfDayArray[index];
                    var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
                    var meal_rate = $(this).closest('tr').find('.meal').val(); 
                    var id = $(this).closest('tr').find('.id').val();
                    var rs =  parseFloat( conversion_rate)  * parseFloat(meal_rate) * parseFloat(meal_day);
                    
                    $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );      

                    var sum = 0;
                    $(".amount_bdt_"+id).each(function() {
                        sum += +$(this).val() || 0;
                    });
                    $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );                    
            });

            $("#ex_info tr td .incidental_day").each(function(index,value){  
                    $(this).val(noOfDayArray[index]);   
                    var incidental_day = noOfDayArray[index]; 
                    var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
                    var incidental = $(this).closest('tr').find('.incidental').val(); 
                    var id = $(this).closest('tr').find('.id').val();
                    var rs =  parseFloat( conversion_rate)  * parseFloat(incidental) * parseFloat(incidental_day);
                    
                    $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );      

                    var sum = 0;
                    $(".amount_bdt_"+id).each(function() {
                        sum += +$(this).val() || 0;
                    });
                    $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );                      
            });

            $("#ex_info tr td .hotel_night").each(function(index,value){                       
                   $(this).val(noOfDayArray[index]-1); 
                    var hotel_night = noOfDayArray[index]-1;
                    var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
                    var hotel = $(this).closest('tr').find('.hotel').val(); 
                    var id = $(this).closest('tr').find('.id').val();
                    var rs =  parseFloat( conversion_rate)  * parseFloat(hotel) * parseFloat(hotel_night);

                    $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );     

                    var sum = 0;
                        $(".amount_bdt_"+id).each(function() {
                        sum += +$(this).val() || 0;
                    });
                    $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );                      
            });


            $("#ex_info tr td .da_night").each(function(index,value){                       
                    $(this).val(noOfDayArray[index]-1); 
                    var da = $(this).closest('tr').find('td').find('.da').val();
                    var da_night = noOfDayArray[index]-1;
                    var id = $(this).closest('tr').find('.id').val();
                    var conversion_rate = $(this).closest('tr').find('.conversion_rate').val();

                    var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(da_night) * parseFloat(da)).toFixed(2);
                    
                    $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs).toFixed(2)  );     

                    var sum = 0;
                    $(".amount_bdt_"+id).each(function() {
                        sum += +$(this).val();
                    });
                    $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );    
            });
      

            





            var firstdate = from_date[0];
            var lastdate = to_date[to_date.length - 1];
            console.log('Bangladesh to ', firstdate);
            console.log(lastdate + ' to Bangladesh');


            var noOfDay = getDuration(firstdate, lastdate);
            console.log('Total Tour Day = ',noOfDay);


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
            var firstTime = firstdate + ':' + bdfirsttime;
            var LastTime = lastdate + ':' + bdlasttime;
            
            console.log(firstTime);
            console.log(LastTime);

            var da_hours = 0;
            da_hours = gethoursDiff(firstTime, LastTime);
            var da_day = Math.round(da_hours / 24);
            console.log("Total Da Day= ", da_day);


            $('#tday').text(noOfDay);
            $('#tda').text(da_day);
           
           

        });



    
    $(document).on('change', '.air_fare', function () {

        var air_fare = $(this).val();       
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val();        
        var id = $(this).closest('tr').find('.id').val();
        
        var rs =  parseFloat( conversion_rate)  * parseFloat(air_fare) ;
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );     

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 


    });

    $(document).on('change', '.hotel', function () {
        var hotel = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var hotel_night = $(this).closest('tr').find('.hotel_night').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(hotel) * parseFloat(hotel_night);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );      

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 


    });

    $(document).on('change', '.hotel_night', function () {
        var hotel_night = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var hotel = $(this).closest('tr').find('.hotel').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(hotel) * parseFloat(hotel_night);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );

    });

    $(document).on('change', '.meal', function () {
        var meal = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var meal_day = $(this).closest('tr').find('.meal_day').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(meal) * parseFloat(meal_day);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );

    });

    $(document).on('change', '.meal_day', function () {
        var meal_day = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var meal = $(this).closest('tr').find('.meal_day').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(meal) * parseFloat(meal_day);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );      

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );

    });

    $(document).on('change', '.incidental', function () {
        var incidentals = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var incidentals_day = $(this).closest('tr').find('.incidental_day').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(incidentals) * parseFloat(incidentals_day);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.incidental_day', function () {
        var incidentals_day = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var incidentals = $(this).closest('tr').find('.incidental').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(incidentals) * parseFloat(incidentals_day);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );       

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );

    });

    $(document).on('change', '.da', function () {
        var da_allow = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var da_night = $(this).closest('tr').find('.da_night').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(da_allow) * parseFloat(da_night);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );

    });


    $(document).on('change', '.da_night', function () {
        var da_night = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        var da = $(this).closest('tr').find('.da').val(); 
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(da) * parseFloat(da_night);
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );

    });

    $(document).on('change', '.other', function () {
        var other = $(this).val();
        var conversion_rate = $(this).closest('tr').find('.conversion_rate').val(); 
        
        var id = $(this).closest('tr').find('.id').val();
        var rs =  parseFloat( conversion_rate)  * parseFloat(other) ;
        
        $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

        var sum = 0;
        $(".amount_bdt_"+id).each(function() {
            sum += +$(this).val() || 0;
        });
        $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 

    });

    $(document).on('change', '.conversion_rate', function () {

    

        var conversion_rate = $(this).val() || 0;
        var name = $(this).closest('tr').find('td').eq(1).html();
        var id = $(this).closest('tr').find('.id').val();

       
        

        if(name === 'Air Fare'){                
            var air_fare = $(this).closest('tr').find('td').find('.air_fare').val() ||0;
            var rs = parseFloat( parseFloat( conversion_rate )  * parseFloat(air_fare) ).toFixed(2);

            $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

            var sum = 0;
            $(".amount_bdt_"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 

        }else if(name === 'Hotel'){   

            var hotel = $(this).closest('tr').find('td').find('.hotel').val();
            var hotel_night = $(this).closest('tr').find('td').find('.hotel_night').val();
            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(hotel_night) * parseFloat(hotel)).toFixed(2);
            
            $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

            var sum = 0;
            $(".amount_bdt_"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  );    

        }else if(name === 'Meal'){               
            var meal = $(this).closest('tr').find('td').find('.meal').val();
            var meal_day = $(this).closest('tr').find('td').find('.meal_day').val();
            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(meal_day) * parseFloat(meal)).toFixed(2);
            
            $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

            var sum = 0;
            $(".amount_bdt_"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 

        }else if(name === 'Incidental'){     

            var incidental = $(this).closest('tr').find('td').find('.incidental').val();
            var incidental_day = $(this).closest('tr').find('td').find('.incidental_day').val();
            var rs =  parseFloat( conversion_rate)  * parseFloat(incidental_day) * parseFloat(incidental);
            
            // console.log('incidental = ',incidental);    
            // console.log('incidental_day = ',incidental_day);    
            // console.log('rs = ',rs);    


            $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

            var sum = 0;
            $(".amount_bdt_"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 

        }else if(name === 'Daily Allowance'){               
            var da = $(this).closest('tr').find('td').find('.da').val();
            var da_night = $(this).closest('tr').find('td').find('.da_night').val();

            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(da_night) * parseFloat(da)).toFixed(2);
            
            $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

            var sum = 0;
            $(".amount_bdt_"+id).each(function() {
                sum += +$(this).val() || 0;
            });
            $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 

        }else if(name === 'Other'){               
            var other = $(this).closest('tr').find('td').find('.other').val();                
            var rs =  parseFloat( parseFloat( conversion_rate)  * parseFloat(other)).toFixed(2) ;

            console.log('Other = ',other);    
            console.log('rs = ',rs);    


            if(other){
                                      
                $(this).closest('tr').find('.amount_bdt_'+id).val( parseFloat(rs || 0).toFixed(2)  );    

                var sum = 0;
                $(".amount_bdt_"+id).each(function() {
                    sum += +$(this).val() || 0;
                });
                $(".linetotal_"+id).val(  parseFloat(sum).toFixed(2)  ); 

            }else{
                parseFloat( $(".linetotal"+id).val(0));
            }
                
        }                                   
    });

    

    $("#advanceForm").submit(function(e){
        var docNo = $('#document_no').val();
        var formdata = $("#advanceForm").serializeArray(); // here $(this) refere to the form its submitting
        $.ajax({
            type: 'POST',
            url: "{{ route('international.updatefinalNoteSheet') }}",
            data: formdata, // here $(this) refers to the ajax object not form
            success: function(data) {
                console.log('success');
                if (data.success) {
                    toastr.success(data.success, '', {timeOut: 2000});
                    // location.reload();
                } else {
                    toastr.error(data.error, '', {timeOut: 2000});
                }
            },
            error: function(error) {
                console.log('error');
            }
        });
        e.preventDefault();
    });



    </script>
   
@endsection