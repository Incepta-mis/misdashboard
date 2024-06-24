@extends('_layout_shared._master')
@section('title','Summary of Stability Monitoring Data Export Country_01')
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
                <form action="" id="stabilitymonitoringdataecountry01_info">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Summary of Stability Monitoring Data Export Country_01(Selection Option)</legend>
                                    <form id="selection">
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email"><b>Product Name:</b></label>
                                                    <select name="pname" id="pname" class="form-control input-xs">
                                                        <option value="" SELECTED disabled="">SELECT PRODUCT</option>
                                                        @foreach($pname as $p)
                                                            <option value="{{$p->pname}}">{{$p->pname}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email"><b>Batch Number:</b></label>
                                                    <select name="batch_number" id="batch_number"
                                                            class="form-control input-xs">
                                                        <option value="" SELECTED disabled="">SELECT BATCH</option>
                                                        @foreach($batch_number as $bn)
                                                            <option value="{{$bn->batch_number}}">{{$bn->batch_number}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Export Country:</b></label>
                                                    <select name="export_country" id="export_country" class="form-control input-xs">
                                                        <option value="" selected>Select Export Country</option>
                                                        @foreach($export_country as $e)

                                                            <option value="{{$e->export_country}}">{{$e->export_country}}</option>
                                                        @endforeach
                                                    </select>
                                                    {{--                                <input type="text" class="" id="excountry" placeholder="Enter Export Country" name="excountry">--}}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email"><b>Test Parameters:</b></label>

                                                    <select name="test_parameters" id="test_parameters"
                                                            class="form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($test_parameters as $tm)
                                                            <option @if($tm->test_parameters == 'DESCRIPTION')selected @endif value="{{$tm->test_parameters}}">{{$tm->test_parameters}}</option>
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

    <table class="table table-bordered">

    </table>

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
            function getoptionlist(values,type){
                var options = '';
                if (type == 'TP') {
                    options = '<option value="ALL">All</option>';
                }


                for (var i=0;i<values.length;i++){
                    options += '<option value="'+values[i].val+'">'+values[i].val+'</option>'
                }
                return options;
            }
            function preparereport1(values)
            {
                var table ='<table id ="tab_report2" class="table table-bordered table-condensed table-striped">';
                table +=' <thead>\n' +
                    '        <tr>\n' +
                    '            <th rowspan="3" style="text-align: center;vertical-align: middle">Tests</th>\n' +
                    '            <th rowspan="3" style="text-align: center;vertical-align: middle">Acceptance Criteria</th>\n' +
                    '            <th colspan="9" class="text-center">Stability Time Points (months)</th>\n' +
                    '        </tr>\n' +
                    '        <tr>\n' +
                    '            <th colspan="7" class="text-center">Long Term Stability Data  <br> (30 °C ± 2 °C/65% RH ± 5% RH)</th>\n' +
                    '            <th colspan="2" class="text-center">Accelerated Stability Data <br> (40 °C ± 2 °C/75% RH ± 5% RH)</th>\n' +
                    '        </tr>\n' +
                    '        <tr>\n' +
                    '            <th class="text-center">initial</th>\n' +
                    '            <th class="text-center">3</th>\n' +
                    '            <th class="text-center">6</th>\n' +
                    '            <th class="text-center">9</th>\n' +
                    '            <th class="text-center">12</th>\n' +
                    '            <th class="text-center">18</th>\n' +
                    '            <th class="text-center">24</th>\n' +
                    '            <th class="text-center">3</th>\n' +
                    '            <th class="text-center">6</th>\n' +
                    '        </tr>\n' +
                    '        </thead>';
                table += '<tbody> ';
                var c = 0;
                for (var i=0;i<values.length;i++){
                    c++;
                    var ini1 = values[i]['a'] ? values[i]['a'] : '';
                    var ini2 = values[i]['b'] ? values[i]['b'] : '';
                    var ini3 = values[i]['c'] ? values[i]['c'] : '';
                    var ini4 = values[i]['d'] ? values[i]['d'] : '';
                    var ini5 = values[i]['e'] ? values[i]['e'] : '';
                    var ini6 = values[i]['f'] ? values[i]['f'] : '';
                    var ini7 = values[i]['g'] ? values[i]['g'] : '';
                    var ini8 = values[i]['h'] ? values[i]['h'] : '';
                    var ini9 = values[i]['i'] ? values[i]['i'] : '';
                    table += '<tr><td>'+values[i].test_parameters+'</td><td>'+values[i].accept_criteria+'</td><td>'+ini1+'</td><td>'+ini2+'</td><td>'+ini3+'</td><td>'+ini4+'</td><td>'+ini5+'</td><td>'+ini6+'</td><td>'+ini7+'</td><td>'+ini8+'</td><td>'+ini9+'</td></tr>'
                }
                table +='</tbody></table>';
                return table;

            }
            $('#pname').on('change', function () {
                if ($(this).val() !== 'ALL') {
                    $.ajax({
                        type: 'get',
                        url: '{{url('ssm/report/result/batchget22')}}',
                        data: {

                            pname: $(this).val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            console.log(getoptionlist(response));
                            $('#batch_number').empty().append(getoptionlist(response.batch_number));
                            $('#test_parameters').empty().append(getoptionlist(response.test_parameters,'TP'));


                            console.log(response);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    })
                }

            });




            $('#btn_display').on('click', function () {
                console.log('clicked');

                $.ajax({

                    type: 'post',
                    url: '{{url('ssm/report/result/displayresult22')}}',
                    data: {


                        pname: $('#pname').val(),
                        batch_number: $('#batch_number').val(),
                        test_parameters: $('#test_parameters').val(),
                        export_country: $('#export_country').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                        $('#report_body').empty().append(preparereport1(response)).show();

                        $('#tab_report2').dataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    text: 'Excel',
                                    className: 'btn btn-primary btn-sm',
                                    action: function () {
                                        // alert($('#sample_info_data').serialize());
                                        window.location = '{{URL::to('ssm/report/result/exportexcel23/')}}' + '/' + $('#stabilitymonitoringdataecountry01_info').serialize();
                                    }
                                },
                                {
                                    text: 'PDF',
                                    className: 'btn btn-primary btn-sm',
                                    action: function () {
                                        // alert($('#sample_info_data').serialize());
                                        window.location = '{{URL::to('ssm/report/result/exportpdf23/')}}' + '/' + $('#stabilitymonitoringdataecountry01_info').serialize();
                                    }
                                }

                            ]
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
