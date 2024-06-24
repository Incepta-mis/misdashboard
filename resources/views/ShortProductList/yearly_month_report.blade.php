@extends('_layout_shared._master')
@section('title','Yearly Month Summary Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
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
        }

        .table > tbody > tr > td {
            padding: 4px;
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
        .no_sorting_sign:after {
            content: none !important;
        }
        .no_sorting_sign {
            padding-right: 6px !important;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Yearly Month Summary Report
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label col-md-4" for="report_year">Report Year</label>
                                            <div class="col-md-6 col-xs-11">
                                                <input type="text" class="form-control" id="report_year"
                                                       placeholder="Pick a Year"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label col-md-3" for="pro_name">Product Name</label>
                                            <div class="col-md-6 col-xs-11">
                                                <select id="pro_name" name="pro_name"
                                                        class="form-control form-control-inline input-medium">
                                                    <option value="ALL">All</option>
                                                    @foreach($prod_list as $prod)
                                                        <option value= "{{$prod->p_code}}">{{$prod->p_code}} -
                                                            {{$prod->name}}</option>
                                                    @endforeach
                                                </select>
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
                                <thead style="background-color: darkkhaki;">
                                    <tr>
                                        <th>PRODUCT CODE</th>
                                        <th>NAME OF PRODUCT</th>
                                        <th>SIZE</th>
                                        <th>PRICE</th>
                                        <th class="no_sorting_sign">JAN</th>
                                        <th class="no_sorting_sign">FEB</th>
                                        <th class="no_sorting_sign">MAR</th>
                                        <th class="no_sorting_sign">APR</th>
                                        <th class="no_sorting_sign">MAY</th>
                                        <th class="no_sorting_sign">JUN</th>
                                        <th class="no_sorting_sign">JUL</th>
                                        <th class="no_sorting_sign">AUG</th>
                                        <th class="no_sorting_sign">SEP</th>
                                        <th class="no_sorting_sign">OCT</th>
                                        <th class="no_sorting_sign">NOV</th>
                                        <th class="no_sorting_sign">DEC</th>
                                        <th>TOTAL</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function () {

            $("#report_year").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose:true
            });

            $('#pro_name').select2();

            $('#btn_submit').on('click', function (e) {
                $("#loader").show();

                var year = $('#report_year').val();
                var p_code = $('#pro_name').val();

                var table = null;

                $.ajax({
                    type: 'post',
                    url: '{{  url('sp_portal/getYearlyMonthReport') }}',
                    data: { 'p_code':p_code, 'year':year, '_token': "{{ csrf_token() }}"},
                    success: function (data) {

                        $("#report-body").show();
                        $("#loader").hide();

                        $("#listTable").DataTable().destroy();

                        table = $("#listTable").DataTable({
                            data: data.report,
                            columns: [
                                {data: "p_code"},
                                {data: "description"},
                                {data: "pack_size"},
                                {data: "t_p"},
                                {data: "1"},
                                {data: "2"},
                                {data: "3"},
                                {data: "4"},
                                {data: "5"},
                                {data: "6"},
                                {data: "7"},
                                {data: "8"},
                                {data: "9"},
                                {data: "10"},
                                {data: "11"},
                                {data: "12"},
                                {data: "13"}
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: true,
                            filter: true,
                            select: {
                                style: 'os',
                                selector: 'td:first-child'
                            }
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
                                            title: "YearlyMonthWiseReport_"+$('#report_year').val(),
                                            exportOptions : {
                                                columns: ':visible'
                                            },
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }
                                    ],
                                    className: 'btn btn-sm btn-primary'
                                }
                            ]
                        }).container().appendTo($('#export_buttons'));
                    },
                    error: function (e) {
                        console.log(e);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });
            });
        });
    </script>
@endsection