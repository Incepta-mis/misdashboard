@extends('_layout_shared._master')
@section('title','Upload Sales Data')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/bootstrap-datepicker/css/datepicker-custom.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/table-export/tableexport.min.css')}}" rel="stylesheet" type="text/css"/>

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
        #upload_file{
            outline: none;
            padding: 2px 2px 2px 7px;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }
        a:hover{
            text-decoration: none;
        }
        #listTable thead tr{
            font-weight: 600;
        }
        #listTable tbody tr th, #listTable tbody tr td{
            font-weight: 500;
        }
        .select2-container--default .select2-selection--single {
            border-radius: 0px;
        }
        .select2-container .select2-selection--single {
            height: 34px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 33px;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #aaa;
            outline: none;
        }
        table.dataTable {
            font-size: 11px;
        }
        table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting {
            padding-right: 20px;
        }
        .table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
            padding: 3px;
            text-align: center;
            vertical-align: middle;
            font-weight: 700;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-primary">
                <div class="panel-heading">
                    <label class="text-default">
                        Month Wise Report
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label col-md-4" for="report_month">Report Month</label>
                                            <div class="col-md-6 col-xs-11">
                                                <input type="text" readonly="" size="16" class="form-control"
                                                       placeholder="Pick a month" id="monthyear" value="">
                                                <div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="01/2022" class="input-append date report_month">
                                                    <input type="hidden" readonly="" size="16" class="form-control"
                                                           name="report_month" id="report_month" placeholder="Pick a month">
                                                    <span class="input-group-btn add-on">
                                                        <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="button" id="btn_submit" class="btn btn-info btn-sm">
                                        <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div id="export_buttons" style="float: right;">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
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
    </div>
    <div class="row">
        <div id="report-body" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="listTable" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead style="background-color: #64337b; color: white">
                                <tr>
                                    <th>SL.</th>
                                    <th>Sales Month</th>
                                    <th>Company Code</th>
                                    <th>Company Name</th>
                                    <th>SAP Code</th>
                                    <th>Product Name</th>
                                    <th>Country</th>
                                    <th>Sold Qty</th>
                                    <th>Sold Value</th>
                                    <th>Sales Type</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-default" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Upload EXPORT, INSTITUTION, DEEMED EXPORT sales data for BRAND RANKING report
                    </label>
                </header>

                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {!! Form::open(array('url'=>'uploadSalesReport','method'=>'POST' ,
                                'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label col-md-3" for="upload_file">Select File:</label>
                                        <div class="col-md-6 col-xs-11">
                                            <div class="input-group">
                                                <input type="file" id="upload_file" name="upload_file"
                                                       class="form-control form-control-inline input-medium">
                                                @if ($errors->has('upload_file'))
                                                    <p class="help-block">{{ $errors->first('upload_file') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fa fa-check"></i> <b>Upload</b>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12" >
                                        <label class="control-label col-md-6"><span>Click <a href="{{ url
                                        ('downloadSampleFile') }}"><i class="fa fa-hand-o-right"></i> Here </a>to
                                            see the sample file.</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('dup_data'))
                    <?php
                    $val = json_decode(session('dup_data'),true);
                    if(count($val) > 0){
                    ?>
                    <div class="row">
                        <div id="report-body">
                            <div class="col-sm-12 col-md-12">
                                <section class="panel" id="data_table">
                                    <header class="panel-heading" style="text-transform: inherit; color: #e37f52;
                                             font-size: 13px;">
                                        <label class="text-default" style="color: orangered">
                                            Due to some data matching the existing data, these details could not be
                                            uploaded.
                                        </label>
                                    </header>
                                    <div class="panel-body">
                                        <div class="col-md-12 col-sm-12 table-responsive">
                                            <table width="100%" class="table table-bordered table-condensed table-striped">
                                                <thead style="background-color: #5e5e5e; color: white">
                                                <tr>
                                                    <th>SL.</th>
                                                    <th>Sales Month</th>
                                                    <th>Company Code</th>
                                                    <th>Company Name</th>
                                                    <th>SAP Code</th>
                                                    <th>Product Name</th>
                                                    <th>Country</th>
                                                    <th>Sold Qty</th>
                                                    <th>Sold Value</th>
                                                    <th>Sales Type</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for ($i = 0; $i < count($val); $i++)
                                                    <tr>
                                                        <td>{{ $val[$i]['sl'] }}</td>
                                                        <td>{{ $val[$i]['sales_month'] }}</td>
                                                        <td>{{ $val[$i]['company_code'] }}</td>
                                                        <td>{{ $val[$i]['company_name'] }}</td>
                                                        <td>{{ $val[$i]['sap_code'] }}</td>
                                                        <td>{{ $val[$i]['p_name'] }}</td>
                                                        <td>{{ $val[$i]['country'] }}</td>
                                                        <td>{{ $val[$i]['sold_qty'] }}</td>
                                                        <td>{{ $val[$i]['sold_value'] }}</td>
                                                        <td>{{ $val[$i]['sales_type'] }}</td>
                                                    </tr>
                                                @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                @endif
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/table-export/xls.core.min.js')}}
    {{Html::script('public/site_resource/js/table-export/FileSaver.min.js')}}
    {{Html::script('public/site_resource/js/table-export/tableexport.min.js')}}

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif

        $(document).ready(function () {
            $('.report_month').datepicker({
                format: "mm-yyyy",
                autoclose:true
            }).on('changeDate', function(ev) {
                var monthYear = new Date(ev.date);
                var myAr = monthYear.toString().split(" ");
                var mYval = myAr[1]+'-'+myAr[3];
                $('#monthyear').val(mYval.toUpperCase());
            });

            $('#btn_submit').on('click', function (e) {
                $("#loader").show();

                var monthyear = $('#monthyear').val();

                var table = null;

                $.ajax({
                    type: 'post',
                    url: '{{  url('getMonthWiseUploadedReport') }}',
                    data: { 'monthyear':monthyear, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        console.log(data);

                        if ($.fn.dataTable.isDataTable( '#listTable' ) ) {
                            $("#listTable").DataTable().destroy();
                        }
                        $("#listTable tbody").html("");

                        var tbodyHTML = "";

                        for (let j = 0; j < data.report.length; j++) {
                            var count = j+1;
                            tbodyHTML += '<tr>';
                                tbodyHTML += '<th scope="row">'+count+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['sales_month']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['company_code']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['company_name']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['sap_code']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['p_name']+'</th>';
                                if(data.report[j]['country'] == null){
                                    tbodyHTML += '<th scope="row"></th>';
                                }else{
                                    tbodyHTML += '<th scope="row">'+data.report[j]['country']+'</th>';
                                }

                                tbodyHTML += '<th scope="row">'+data.report[j]['sold_qty']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['sold_value']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['sales_type']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['create_user']+'</th>';
                                tbodyHTML += '<th scope="row">'+data.report[j]['create_date']+'</th>';
                            tbodyHTML += '</tr>';
                        }
                        $("#listTable tbody").html(tbodyHTML);

                        $("#report-body").show();
                        $("#loader").hide();

                        table = $("#listTable").DataTable({
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: true,
                            filter: true
                        });
                        table.fixedHeader.enable();

                        new $.fn.dataTable.Buttons(table, {
                            buttons: [
                                {
                                    extend: 'collection',
                                    text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                    buttons: [
                                        {
                                            extend: 'excel',
                                            header: true,
                                            footer: true,
                                            text: 'Save As Excel',
                                            title: "MonthWiseBrandSalesReport_"+$('#monthyear').val(),
                                            exportOptions : {
                                                columns: ':visible'
                                            },
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        },
                                        {
                                            extend: 'pdfHtml5',
                                            text: 'Save As PDF',
                                            orientation: 'landscape',
                                            pageSize: 'LETTER',
                                            title: "MonthWiseBrandSalesReport_"+$('#monthyear').val(),
                                            exportOptions : {
                                                columns: ':visible'
                                            },
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'PDF';
                                                $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }
                                    ],
                                    className: 'btn btn-sm btn-primary'
                                }
                            ]
                        }).container().appendTo($('#export_buttons'));
                    },
                    error: function (e) {
                        alert(e);
                        $("#loader").hide();
                        $("#report-body").hide();
                    }
                });
            });
        });
    </script>
@endsection
