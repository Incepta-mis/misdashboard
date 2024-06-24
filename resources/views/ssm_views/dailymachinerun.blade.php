@extends('_layout_shared._master')
@section('title','Daily Machine Run Status')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        . {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: black;
        }

        label {
            font-size: 12px;
        }

        input, select {
            color: #000000;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 32px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }

        .field-h {
            font-size: 11px;
            resize: both;
            /*background: #ffd73e33;*/
            border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg' %3E %3Cstyle%3Epath%7Banimation:stroke 5s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='red' /%3E%3Cstop offset='25%25' stop-color='red' /%3E%3Cstop offset='50%25' stop-color='red' /%3E%3Cstop offset='100%25' stop-color='red' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
        }

        .input-xs {
            height: 23px;
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 1px;
        }

        .input-group-xs > .form-control,
        .input-group-xs > .input-group-addon,
        .input-group-xs > .input-group-btn > .btn {
            height: 23px;
            padding: 2px 5px;
            font-size: 12px;
            /*line-height: 1.5;*/
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove orangered !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: orangered;
        }

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #337AC7;
        }

        .cls-req{
            color: red;
            font-weight: bold;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Daily Machine Run Status
                    </label>
                </header>
                <form action="" id="dailymachinerun_data">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-lg-12">
                            <div class="input-group select2-bootstrap-prepend">
                                <select type="text" class="form-control" id="productlist">
                                    <option value="">SELECT PRODUCT</option>
                                    @foreach($productinfo as $pi)

                                        <option value="{{$pi->pname}}|{{$pi->batch_number}}|{{$pi->m_id}}|{{$pi->m_start_date_time}}">
                                            {{$pi->pname}}
                                            - {{$pi->batch_number}} - {{$pi->m_id}}
                                            - {{$pi->m_start_date_time}}

                                        </option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                <button class="btn btn-primary" id="btn_display" type="button">Display!</button>
                              </span>
                            </div>
                        </div><!-- /input-group -->
                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Daily Machine Run Status</legend>


                                <div class="col-md-12">
                                    <p class="cls-req">*(Fields are required)</p>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email"><b>Product Name:</b></label>
                                            <input type="text" id="pname2" style="display:none;"
                                                   class="form-control input-xs">
                                            <select name="pname" id="pname" class="form-control input-xs">
                                                <option value="" disabled>Select Product</option>
                                                @foreach($sampleinfo as $si)

                                                    <option value="{{$si->pname}}|{{$si->batch_number}}">{{$si->pname}} {{$si->batch_number}}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email"><b>Batch Number:</b></label>
                                            <input type="text" class="form-control input-xs" id="batch_number"
                                                   placeholder=""
                                                   name="batch_number" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" title="Machine Name"><b>Machine Name:</b></label>
                                            <select name="m_name" id="m_name"
                                                    class="form-control input-xs">
                                                <option value="" selected>Select Machine Name</option>
                                                @foreach($mname as $mn)

                                                    <option value="{{$mn->mn_name}}">{{$mn->mn_name}}</option>
                                                @endforeach
                                            </select>
                                            {{--                                <input type="text" class="" id="M_NAME" placeholder="Enter Machine Name" name="M_NAME">--}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" title="Machine ID"><b>Machine ID:</b><span  class="cls-req">*</span></label>
                                            <select name="m_id" id="m_id" class="form-control input-xs">
                                                <option value="" selected>Enter Machine ID</option>
                                                @foreach($mid as $mi)

                                                    <option value="{{$mi->mi_name}}">{{$mi->mi_name}}</option>
                                                @endforeach
                                            </select>
                                            {{--                                <input type="text" class="" id="M_ID" placeholder="Enter Machine ID" name="M_ID">--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" title="Machine Assign To"><b>Machine Assign
                                                    To:</b></label>
                                            <select name="m_a_to" id="m_a_to" class="form-control input-xs">
                                                <option value="" selected>Select Machine Assign
                                                    To
                                                </option>
                                                @foreach($m_a_to as $mato)

                                                    <option value="{{$mato->emp_name}}">{{$mato->emp_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" title="Machine Start Time"><b>Machine Start
                                                    Time:</b><span  class="cls-req">*</span></label>
                                            <input type="text" class="form-control input-xs" id="m_start_date_time"
                                                   readonly=""
                                                   placeholder="" name="m_start_date_time">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" title="Machine Stop Time"><b>Machine Stop
                                                    Time:</b></label>
                                            <input type="text" class="form-control input-xs" id="m_stop_date_time"
                                                   readonly=""
                                                   placeholder="" name="m_stop_date_time">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email" title="Machine Run Time Total"><b>Machine
                                                    R.T.T:</b></label>
                                            <input type="text" class="form-control input-xs" id="m_r_time_total"
                                                   readonly
                                                   name="m_r_time_total">
                                        </div>
                                    </div>



                                </div>
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email" title="Machine Idle Time"><b>Machine Idle
                                                    Time:</b></label>
                                            <input type="text" class="form-control input-xs" id="m_idle_time"
                                                   placeholder=""
                                                   name="m_idle_time">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email" title="Justification of Machine Idle Time"><b>Justification
                                                    of
                                                    M.I.T:</b></label>
                                            <input type="text" class="form-control input-xs" id="jomi_time"
                                                   placeholder="" name="jomi_time">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email"><b>Machine Breakdown hour:</b></label>
                                            <input type="text" class="form-control input-xs" id="mb_hour"
                                                   placeholder=""
                                                   name="mb_hour">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-2 text-center" style="padding-top: 20px;">
                            <button type="button" id="btn_save" class="btn btn-primary btn-sm">
                                <i class="fa fa-check"></i> <b>SAVE</b></button>

                            <button type="button" id="btn_update" class="btn btn-primary btn-sm">
                                <i class="fa fa-check"></i> <b>UPDATE</b></button>
                            <button type="button" id="btn_refresh" class="btn btn-primary btn-sm">
                                <i class="fa fa-check"></i> <b>REFRESH</b></button>
                        </div>
                    </div>

        </form>
        </section>
    </div>
    </div>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script>
        var totalminutes = 0;
        $.fn.select2.defaults.set("theme", "bootstrap");
        var date = new Date();
        $('#productlist').select2({
            width: null
        });

        function machinertt() {
            var a = moment($('#m_stop_date_time').val());//now
            var b = moment($('#m_start_date_time').val());
            if (a && b) {
                console.log(a.diff(b, 'minutes')); // 44700
                console.log(a.diff(b, 'hours'));// 745
                // $('#m_r_time_total').val(a.diff(b, 'hours'));
                var hours = (a.diff(b, 'minutes') / 60);
                var rhours = Math.floor(hours);
                var minutes = (hours - rhours) * 60;
                var rminutes = Math.round(minutes);
                totalminutes = a.diff(b, 'minutes');
                if (!isNaN(rhours) && !isNaN(rminutes)) {
                    $('#m_r_time_total').val(rhours + ':' + rminutes);
                }

            }


        }

        $('#m_start_date_time,#m_stop_date_time').datetimepicker({
            defaultDate: date,
            format: 'DD-MMM-YY h:mm A',
            ignoreReadonly: true
        });
        $('#m_start_date_time').on('dp.change', function () {
            console.log('date1');
            machinertt();
        });
        $('#m_stop_date_time').on('dp.change', function () {
            console.log('date2');
            machinertt();
        });

        $(document).ready(function () {

            $('#btn_update').prop('disabled', true);

            function objectifyForm(formArray) {
                //serialize data function
                var returnArray = {};
                for (var i = 0; i < formArray.length; i++) {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
                return returnArray;
            }

            function chcecktestparam() {
                var isvalid = true;
                if ($('#test_parameters').val() === 'DESCRIPTION' && $('#m_a_to').val() === '') {
                    toastr.error('"Machine Assign To" CANNOT BE EMPTY');
                    isvalid = false;
                }
                return isvalid;
            }

            $('#btn_save').on('click', function () {
                console.log($('#pname').val(), $('#batch_number').val());
                if ($('#pname').val() && $('#batch_number').val() && $('#m_id').val() && $('#m_start_date_time').val() && $('#m_stop_date_time').val()) {
                    if (chcecktestparam()) {
                        console.log('clicked');
                        var formdata = $('#dailymachinerun_data').serializeArray();


                        console.log(objectifyForm(formdata));
                        var formdat = objectifyForm(formdata);
                        formdat.m_r_time_total = totalminutes;
                        console.log(formdat);
                        $.ajax({
                            type: 'post',
                            url: '{{url('ssm/dmr_saverecord')}}',
                            data: {
                                fdata: formdat,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {
                                if (response.status === 'SAVED') {

                                    toastr.info('SAVED SUCCESSULLY');
                                    $('#dailymachinerun_data')[0].reset();
                                    console.log(response);
                                }

                            },
                            error: function (error) {
                                toastr.info('UNABLE TO SAVE');
                                console.log(error);
                            }
                        })
                    }


                } else {
                    toastr.error('This BATCH NUMBNER , MACHINE ID & MACHINE START/STOP DATE TIME is REQUIRED');
                }
            });
            $('#btn_refresh').on('click', function () {
                console.log('clicked');
                $('#pname').prop('readonly', false);
                $('#dailymachinerun_data')[0].reset();
                $('#btn_update').prop('disabled', true);
                $('#btn_save').prop('disabled', false);
                $('#pname').show();
                $('#pname2').hide();
                $('#pname2').val('').prop('readonly', false);


            });
            $('#btn_update').on('click', function () {
                if (chcecktestparam()) {
                    console.log('clicked');
                    var formdata = $('#dailymachinerun_data').serializeArray();


                    var postdata = objectifyForm(formdata);
                    postdata.pname = $('#pname2').val();
                    postdata.m_r_time_total = totalminutes;
                    console.log(postdata);

                    $.ajax({
                        type: 'post',
                        url: '{{url('ssm/dmr_updaterun')}}',
                        data: {
                            fdata: postdata,
                            param: $('#productlist').val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            if (response.status === 'SUCCESSFULLY') {
                                toastr.info('UPDATED SUCCESSULLY');
                                $('#dailymachinerun_data')[0].reset();
                                $('#pname').show();
                                $('#pname2').hide();
                                $('#pname2').val('').prop('readonly', false);
                                $('#btn_update').prop('disabled', true);
                                $('#btn_save').prop('disabled', false);
                                console.log(response);
                                // $('#result_info_data')[0].reset();
                            }

                        },
                        error: function (error) {
                            toastr.info('UNABLE TO SAVE');
                            console.log(error);
                        }
                    })
                }

            });
            $('#btn_display').on('click', function () {
                console.log('clicked');

                $.ajax({
                    type: 'post',
                    url: '{{url('ssm/dmr_displayrun')}}',
                    data: {
                        fdata: $('#productlist').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response[0]);
                        $('#dailymachinerun_data').autofill(response[0]);
                        $('#pname').hide();
                        $('#pname2').show();
                        $('#pname2').val(response[0].pname).prop('readonly', true);


                        var hours = (response[0].m_r_time_total / 60);
                        var rhours = Math.floor(hours);
                        var minutes = (hours - rhours) * 60;
                        var rminutes = Math.round(minutes);
                        totalminutes = response[0].m_r_time_total;
                        $('#m_r_time_total').val(rhours + ':' + rminutes);

                        $('#pname').prop('readonly', true);
                        $('#btn_update').prop('disabled', false);
                        $('#btn_save').prop('disabled', true);
                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                        console.log(error);
                    }
                })
            });
            $('#pname').on('change', function (e) {
               // console.log($(this).val().split('|')[1]);
               $('#batch_number').val($(this).val().split('|')[1]);
            });
            $('input[type="number"]').on('keyup', function (event) {
                console.log(event.target.value);
                var value = event.target.value;
                var regex = new RegExp(/^\+?[0-9(),.-]+$/);
                if (value.match(regex)) {
                    event.target.value = value;
                } else {
                    event.target.value = '';
                }
                ;
            });


        });
    </script>

@endsection
