@extends('_layout_shared._master')
@section('title','Monthly Stability Sample Planner')
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
            border: 1.5px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.1em !important;
            /*font-weight: bold !important;*/
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
        }

        legend {
            color: #337AC7;
            /*margin: 0 auto;*/
            /*margin-bottom: 10px;*/
        }

        .btn-primary {
            background-color: #337AC7;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <form action="" id="monthlystabilitysampleplanner_info_data">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Monthly Stability Sample Planner(Selection Option)
                                    </legend>
                                    <form id="selection">
                                        <div class="col-md-12">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Kept On Month</b></label>
                                                    <select name="kept_on_date" id="kept_on_date" class="form-control input-xs">
                                                        <option value="ALL" >All</option>
                                                        @foreach($date as $d)
                                                            <option value="{{$d->kept_on_date}}">{{$d->kept_on_date}}</option>
                                                        @endforeach

                                                    </select>
                                                    {{--                                <input type="text" class="" id="punit" placeholder="Enter Unit" name="punit">--}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Product Name:</b></label>
                                                    <select name="pname" id="pname" class="form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($pname as $p)
                                                            <option value="{{$p->pname}}">{{$p->pname}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email" title="Chamber Storage Condition"><b>Storage
                                                            Condition:</b></label>

                                                    <select name="chamber_stor_cond" id="chamber_stor_cond"
                                                            class="form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($chamber_stor_cond as $csc)
                                                            <option value="{{$csc->chamber_stor_cond}}">{{$csc->chamber_stor_cond}}</option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>




                                            <div class="col-md-1" style="padding-top: 20px;">
                                                <button type="button" id="btn_display" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-check"></i> <b>DISPLAY</b></button>
                                            </div>

                                        </div>
                                    </form>


                                </fieldset>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="panel-body">
                    <div id="report_body" style="display:none;">
                        <p>
                            i am here
                        </p>
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


        $(document).ready(function () {
            function getoptionlist(values) {
                var options = '<option value="ALL">All</option>';
                for (var i = 0; i < values.length; i++) {
                    options += '<option value="' + values[i].val + '">' + values[i].val + '</option>'
                }
                return options;
            }

            function preparereport1(values) {
                var table = '<table id ="tab_report2" class="table table-bordered table-condensed table-striped">';
                table += '<thead><tr><th>SL No.</th><th>Product Name</th><th>Batch</th><th>Test Duration</th><th>Kept On Date</th><th>Condition:30⁰C+65% RH</th><th>Condition:30⁰C+75% RH</th><th>Condition:40⁰C+75% RH</th><th>Condition: 25⁰C+60% RH</th><th>Condition:2⁰C+8⁰C</th><th>Samle Per Test</th></tr></thead>';
                table += '<tbody> ';
                var k = 0;
                for (var i = 0; i < values.length; i++) {
                    k++;
                    var a = values[i].a3065 ? values[i].a3065 : '';
                    var b = values[i].b3075 ? values[i].b3075 : '';
                    var c = values[i].c4075 ? values[i].c4075 : '';
                    var d = values[i].d2560 ? values[i].d2560 : '';
                    var e = values[i].e53 ? values[i].e53 : '';
                    table += '<tr><td>' + k + '</td><td>' + values[i].pname + '</td><td>' + values[i].batch_number + '</td><td>' + values[i].test_duration + '</td><td>' + values[i].kept_on_date + '</td><td>' + a + '</td><td>' +b + '</td><td>' + c + '</td><td>' + d + '</td><td>' + e+ '</td><td>'+values[i].sample_qc_test+'</td></tr>'
                }
                table += '</tbody></table>';
                return table;

            }

            $('#kept_on_date').on('change', function () {
                if ($(this).val() !== 'ALL') {
                    $.ajax({
                        type: 'get',
                        url: '{{url('ssm/report/sample/getpname')}}',
                        data: {

                            kept_on_date: $(this).val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            $('#pname').empty().append(getoptionlist(response.pname));

                            console.log(response);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    })
                }

            })


            $('#btn_display').on('click', function () {
                console.log('clicked');

                $.ajax({

                    type: 'post',
                    url: '{{url('ssm/report/sample/displayinfoplanner')}}',
                    data: {
                        pname: $('#pname').val(),
                        chamber_stor_cond: $('#chamber_stor_cond').val(),
                        kept_on_date: $('#kept_on_date').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                        $('#report_body').empty().append(preparereport1(response)).show();

                        $('#tab_report2').dataTable({

                            "pageLength": 50,
                            dom: 'Bfrtip',
                            buttons: ['excel','pdf','csv']
                            
                        });

                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                        console.log(error);
                    }
                })

            });
        })
    </script>
@endsection
