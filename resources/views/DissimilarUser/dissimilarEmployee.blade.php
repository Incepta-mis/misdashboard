@extends('_layout_shared._master')
@section('title','Factory Managers Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
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

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        /*Here starts styling of table section*/
        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        body {
            color: #000;
        }
        .odd{
            background-color: #FFF8FB !important;
        }
        .even{
            background-color: #DDEBF8 !important;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Dissimilar Employee Details
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">

                                        <div class="col-md-5 col-sm-5 col-xs-5">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Select Plant:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="plant" name="plant"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Plant</option>
                                                    <option value="all">All</option>
                                                    @foreach($plant_info as $plant_infos)
                                                    <option value="{{$plant_infos->plant_id}}">{{$plant_infos->plant_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-5 col-sm-5 col-xs-5">

                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_submit" class="btn btn-warning btn-sm" >
                                                        <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                                </div>
                                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                    <div id="export_buttons">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



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
                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                    <div id="export_buttons">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead style="background-color: darkkhaki;">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Email</th>
                                    <th>Dept Name</th>
                                    <th>Section Name</th>
                                    <th>Plant Id</th>
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
    <div id="createModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

        </div>
    </div>
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
    {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
           $("#plant").select2();
        });

        $('#btn_submit').on('click', function (e) {
            // e.preventDefault();
            $("#loader").show();
            console.log("submit button is clicked");
           var plant_id = $('#plant').val();

            var table = null;

            $.ajax({
                type: 'post',
                url: '{{  url('elm_portal/getAllEmployee') }}',
                data: { 'plant_id': plant_id,
                    '_token': "{{ csrf_token() }}"},
                success: function (data) {


                    $("#showTable").show();
                    $("#loader").hide();



                    $("#elr").DataTable().destroy();

                    table = $("#elr").DataTable({

                        buttons: [
                            {
                                text: '<button class="btn btn-success btn-xs" type="button"><i class="fa fa-plus"></i> Add </button>',
                                action: function ( e, dt, node, config ) {
                                    $("#createModal").modal('show');
                                }
                            }
                        ],
                        data: data.result,
                        columns: [
                            {data: "emp_id"},
                            {data: "sur_name"},
                            {data: "email"},
                            {data: "dept_name"},
                            {data: "section_name"},
                            {data: "plant_id"},

                        ],
                        columnDefs: [
                            {className: "valid", targets: 4},
                            {className: "empy_ID", targets: 1},
                            {className: "designation", targets: 3}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: true,
                        paging: true,
                        filter: true,


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
                                        text: 'Save As Excel',
                                        footer: true,
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4]
                                        },
                                        action: function (e, dt, node, config) {
                                            exportExtension = 'Excel';
                                            $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                        }
                                    }, {
                                        extend: 'pdf',
                                        text: 'Save As PDF',
                                        orientation: 'landscape',
                                        footer: true,
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4]
                                        },
                                        customize : function(doc){
                                            doc.content[1].table.widths =
                                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
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
                    console.log(e);
                    $("#loader").hide();
                    $("#showTable").show();
                }
            });
        });

    </script>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection