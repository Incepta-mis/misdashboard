@extends('_layout_shared._master')
@section('title','Interim Stability Data Report')
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
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
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

        #type_all, #m_start_date_time:hover {
            cursor: pointer;
        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <form action="" id="interim_info_data">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Interim Stability Data(Selection Option)</legend>
                                    <form id="monthlyInterimStabilityData">
                                        <div class="col-md-12">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Product Name:</b></label>
                                                    <select name="pname" id="pname" class="pname form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($pname as $p)
                                                            <option value="{{$p->pname}}">{{$p->pname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Batch Number:</b></label>
                                                    <select name="batch_number" id="batch_number"
                                                            class="batch_number form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($batch_number as $b)
                                                            <option value="{{$b->batch_number}}">{{$b->batch_number}}</option>
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

                    </div>
                </div>
                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="myModalLabel"
                     data-keyboard="false" data-backdrop="static"
                     role="dialog" tabindex="-1" id="datePickerModal"
                     class="modal fade">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="bg-primary" style="padding:15px;">
                                {{-- <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>--}}
                                <h5 class="modal-title">Select</h5>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-warning" style="border: 1px dashed #FCB322;">
                                    <span class="badge badge-warning" id="type_all">All</span>
                                </div>
                                <div id="datePicker" style="border: 1px dashed #FCB322;padding: 10px;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-sm" id="btnClose" data-dismiss="modal">
                                    <i class="fa fa-times"></i> Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->

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
    <script src="http://www.datejs.com/build/date.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            function preparereport1(values) {
                var table = '<table id ="tab_report2" class="table table-bordered table-condensed table-striped">';
                table += '<thead><tr><th>SL No.</th><th>Product Name</th><th>Batch No</th><th>R&DA Ref. No.</th>' +
                    '<th>Storage Condition</th><th>Assay</th><th>Assay Method</th><th>Disso</th><th>Disso Method</th><th>pH</th><th>DT</th><th>Description</th>' +
                    '<th>Impurities</th><th>Impurity method</th><th>Option1</th><th>Option2</th><th>Analyst Name</th><th>Report Date</th><th>Create User</th>' +
                    '<th>Create Date</th></tr></thead>';
                table += '<tbody> ';
                var k = 0;


                for (var i = 0; i < values.length; i++) {
                    var $rda_ref_no = values[i].rda_ref_no ? values[i].rda_ref_no : '';
                    var $stor_cond = values[i].stor_cond ? values[i].stor_cond : '';
                    var $assay = values[i].assay ? values[i].assay : '';
                    var $assay_method = values[i].assay_method ? values[i].assay_method : '';
                    var $disso = values[i].disso ? values[i].disso : '';
                    var $disso_methood = values[i].disso_method ? values[i].disso_method : '';
                    var $ph = values[i].ph ? values[i].ph : '';
                    var $dt = values[i].dt ? values[i].dt : '';
                    var $description = values[i].description ? values[i].description : '';
                    var $impurities = values[i].impurities ? values[i].impurities : '';
                    var $impurity_method = values[i].impurity_method ? values[i].impurity_method : '';
                    var $option1 = values[i].option1 ? values[i].option1 : '';
                    var $option2 = values[i].option2 ? values[i].option2 : '';
                    var $analyst_name = values[i].analyst_name ? values[i].analyst_name : '';
                    var $report_date = values[i].report_date ? values[i].report_date : '';
                    var $create_user = values[i].create_user ? values[i].create_user : '';
                    var $create_date = values[i].create_date ? values[i].create_date : '';

                    k++;
                    table += '<tr><td>' + k + '</td><td>' + values[i].pname + '</td><td>' + values[i].batch_number + '</td><td>' + $rda_ref_no + '</td><td>' + $stor_cond + '</td><td>' + $assay +'</td><td>' + $assay_method + '</td><td>' + $disso + '</td><td>' + $disso_methood + '</td><td>' + $ph + '</td><td>' + $dt + '</td><td>' + $description + '</td><td>' + $impurities + '</td><td>' + $impurity_method + '</td><td>' + $option1 + '</td><td>' + $option2 + '</td><td>' + $analyst_name + '</td><td>' + $report_date + '</td><td>' + $create_user + '</td><td>' + $create_date + '</td></tr>'
                }
                table += '</tbody></table>';
                return table;
            }

            $('#btn_display').on('click', function () {
                $.ajax({
                    type: 'get',
                    url: '{{url('ssm/report/interim/getinterimdata')}}',
                    data: {
                        name: $('.pname').val(),
                        batch_number: $('.batch_number').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                        $('#report_body').empty().append(preparereport1(response)).show();

                        $('#tab_report2').dataTable({
                            dom: 'Bfrtip',
                            "scrollX": true,
                            buttons: [
                                'excelHtml5',
                            ]
                        });
                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                    }
                })
            });
        })
    </script>
@endsection
