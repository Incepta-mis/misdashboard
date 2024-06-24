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

        #type_all,#m_start_date_time:hover{
            cursor: pointer;
        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <form action="" id="dailymachinerunstatus_info_data">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Daily Machine Run Status(Selection Option)</legend>
                                    <form id="selection">
                                        <div class="col-md-12">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Machine Name:</b></label>
                                                    <select name="m_name" id="m_name" class="form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($m_name as $mn)
                                                            <option value="{{$mn->m_name}}">{{$mn->m_name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Machine ID:</b></label>
                                                    <select name="m_id" id="m_id" class="form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($m_id as $mid)
                                                            <option value="{{$mid->m_id}}">{{$mid->m_id}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email" title="machine start date time"><b>Machine Start
                                                            Time:</b></label>
{{--                                                    <select name="m_start_date_time" id="m_start_date_time"--}}
{{--                                                            class="form-control input-xs">--}}
{{--                                                        <option value="ALL">All</option>--}}
{{--                                                        @foreach($m_start_date_time as $msdt)--}}
{{--                                                            <option value="{{$msdt->m_start_date_time}}">{{$msdt->m_start_date_time}}</option>--}}
{{--                                                        @endforeach--}}

{{--                                                    </select>--}}
                                                    <input type="text" class="form-control input-xs"
                                                           placeholder="" name="m_start_date_time" id="m_start_date_time">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Product Name:</b></label>
                                                    <select name="pname" id="pname"
                                                            class="form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($pname as $p)
                                                            <option value="{{$p->pname}}">{{$p->pname}}</option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="email"><b>Machine Assign To:</b></label>
                                                    <select name="m_a_to" id="m_a_to"
                                                            class="form-control input-xs">
                                                        <option value="ALL">All</option>
                                                        @foreach($m_a_to as $mato)
                                                            <option value="{{$mato->m_a_to}}">{{$mato->m_a_to}}</option>
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

                        </p>
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
                                {{--                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>--}}
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
                                {{--                            <button type="button" class="btn btn-success">Upload Excel</button>--}}
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


        <script>


            $(document).ready(function () {

                $('#m_start_date_time').val(moment().format('DD-MMM-YY').toUpperCase());
                function getoptionlist(values,all){
                    var options = '';
                    if (all)
                    {
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
                    table +='<thead><tr><th>SL No.</th><th>Machine ID</th><th>Machine Name</th><th>Machine Assign To</th><th>Product Name</th><th>Machine Start  Date Time</th><th>Machine Stop Date Time</th><th>Machine Run Time Total</th><th>Machine Idle Time</th><th>Justification of Machine Idle Time</th></tr></thead>';
                    table += '<tbody> ';
                    var c = 0;
                    for (var i=0;i<values.length;i++){
                        c++;
                        var remarks = values[i].remarks ? values[i].remarks : '';
                        var name = values[i].m_name ? values[i].m_name : '';
                        var mit = values[i].m_idle_time ? values[i].m_idle_time : '';
                        var jtime = values[i].jomi_time ? values[i].jomi_time : '';
                        var mrtt = values[i].m_r_time_total ? values[i].m_r_time_total : '';
                        table += '<tr><td>'+c+'</td><td>'+values[i].m_id+'</td><td>'+name+'</td><td>'+values[i].m_a_to+'</td><td>'+values[i].pname+'</td><td>'+values[i].m_start_date_time+'</td><td>'+values[i].m_stop_date_time+'</td><td>'+mrtt+'</td><td>'+mit+'</td><td>'+jtime+'</td></tr>'
                    }
                    table +='</tbody></table>';
                    return table;

                }
                $('#m_name').on('change', function () {
                    if ($(this).val() !== 'ALL') {
                        $.ajax({
                            type: 'get',
                            url: '{{url('ssm/report/result/batchget7')}}',
                            data: {

                                m_name: $(this).val(),
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {
                                console.log(getoptionlist(response));
                                $('#m_id').empty().append(getoptionlist(response.m_id,true));
                                $('#m_start_date_time').empty().append(getoptionlist(response.m_start_date_time,false));
                                $('#pname').empty().append(getoptionlist(response.pname,true));
                                $('#m_a_to').empty().append(getoptionlist(response.m_a_to,true));

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
                        url: '{{url('ssm/report/result/displayresult7')}}',
                        data: {
                            m_name: $('#m_name').val(),
                            m_id: $('#m_id').val(),
                            m_start_date_time: $('#m_start_date_time').val(),
                            pname: $('#pname').val(),
                            m_a_to: $('#m_a_to').val(),
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
                                            window.location = '{{URL::to('ssm/report/result/exportexcel8/')}}' + '/' + $('#dailymachinerunstatus_info_data').serialize();
                                        }
                                    },
                                    {
                                        text: 'PDF',
                                        className: 'btn btn-primary btn-sm',
                                        action: function () {
                                            // alert($('#sample_info_data').serialize());
                                            window.location = '{{URL::to('ssm/report/result/exportpdf8/')}}' + '/' + $('#dailymachinerunstatus_info_data').serialize();
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

                $('#m_start_date_time').on('click',function (e) {
                    e.preventDefault();
                    $('#datePickerModal').modal('show');
                    $('#datePicker').datetimepicker({
                        defaultDate: new Date(),
                        format: 'DD-MMM-YY',
                        inline: true
                    });
                });

                var initial = true;
                $('#datePicker').on('dp.change', function (e) {
                    $('#m_start_date_time').val(moment(e.date).format('DD-MMM-YY').toUpperCase());
                    if(!initial){
                        $('#datePickerModal').modal('hide');
                    }
                    initial = false;
                });

                $('#type_all').on('click',function (){
                   $('#m_start_date_time').val($(this).text().trim());
                   $('#datePickerModal').modal('hide');
                });

            })
        </script>
@endsection
