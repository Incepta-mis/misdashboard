<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 22/3/2022
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Packaging Material Recommended')
    @section('styles')
        <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/css/bootstrap-lightbox.min.css')}}" rel="stylesheet" type="text/css"/>


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
                padding: 2px;
                font-size: 10px;
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

            .emp_info > thead > tr > th {
                text-align: center;
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


            .modal-dialog {
                width: 98%;
                height: 92%;
                padding: 0;
            }

            .modal-content {
                height: 99%;
            }

            .btn.disabled {
                pointer-events: none;
            }

        </style>
    @endsection
    @section('right-content')
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Packaging Material Machine Trial Recommend
                        </label>
                    </header>
                    <div class="panel-body">
                        @if(session()->has('status'))
                            <div class="alert alert-success">
                                {{ session()->get('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="form-horizontal">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Approval Name: </label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control input-sm" value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label input-sm">Employee:</label>
                                        <div class="col-sm-10">
                                                <select name="pack_id" id="pack_id" class="form-control input-sm m-bot15">
                                                    <option value="" disabled>Select </option>
                                                    <option value="All" selected>All</option>
                                                </select>
{{--                                            <select name="req_emp_id" id="req_emp_id" class="form-control input-sm m-bot15">--}}
{{--                                                <option value="">Select Employee</option>--}}
{{--                                                <option value="All">All</option>--}}
{{--                                                @foreach($emps as $ei)--}}
{{--                                                    <option value="{{$ei->employee_id}}">{{$ei->employee_name}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Report</b></button>
                                    </div>
                                    <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                        <div id="export_buttons">

                                        </div>
                                    </div>
                                </div>
                            </form>
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


                    <div class="row" id="report-body" style="display: none;">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <section class="panel" id="data_table">
                                <div class="panel-body">
                                    <div class="table table-responsive">
                                        <table id="example" class="display table table-bordered table-striped" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>LINE ID</th>
                                                <th>PLANT_ID</th>
                                                <th>TRIAL_REF_NO</th>
                                                <th>PRODUCT_NAME</th>
                                                <th>ITEM_DESC</th>
                                                <th>QTY</th>
                                                <th>UOM</th>
                                                <th>SUPPLIER_NAME</th>
                                                <th>CONCERN_PRODUCT</th>
                                                <th>SCM_REMARKS</th>
                                                <th>REC. STATUS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            </thead>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </section>
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

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
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
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script type="text/javascript">

        $(document).ready(function() {
            $('#pack_id').select2();

            $("#btn_display").click(function () {


                let pack_id = $('#pack_id').val();

                if ($("#report-body").is(":visible")) {
                     $("#report-body").hide();
                }


                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    data: {pack_id: pack_id},
                    url: "{{ url('scm_portal/getTrialPackRcmData') }}",
                    success: function (resp) {

                        // console.log('Output data: ', resp);


                        $("#loader").hide();
                        $("#report-body").show();

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({

                            data: resp,
                            order: [],
                            autoWidth: true,
                            // scrollX:        true,
                            // scrollCollapse: true,
                            columns: [
                                {data: "line_id"},
                                {data: "plant_id"},
                                {data: "trial_ref_no"},
                                {data: "product_name"},
                                {data: "item_desc"},
                                {data: "qty"},
                                {data: "uom"},
                                {data: "supplier_name"},
                                {data: "concern_product"},
                                {data: "scm_remarks"},
                                {
                                    data: "rcm_app_date" ,
                                    className: "haccept",
                                    "render": function (data, type, row) {

                                        // //console.log(data);

                                        if (row.rcm_app_date == null) {
                                            return '<span class="label label-warning" >Pending</span>';
                                        }
                                        else {
                                            return '<span class="label label-success"> Accepted </span>';
                                        }
                                    }
                                },
                                {
                                    data: null,
                                    "render": function (row) {
                                        if (row.rcm_app_date === null) {

                                            return "<button type='button' class='btn btn-success btn-xs accept' id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>";

                                        }
                                        else if (row.rcm_app_date !== null)  {
                                            return "<button  class='btn btn-success btn-xs accept disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" ;
                                        }

                                    }


                                }

                            ],
                            fixedHeader: {
                                header: true,
                                headerOffset: $('#fix').height()
                                //headerOffset: $('#fix').outerHeight()
                            },
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            columnDefs: [
                                {
                                    "targets": [ 0 , 1 ],
                                    "visible": false
                                },
                                // {
                                //     "order": [[2, 'desc' ]],
                                //     "orderable": false, targets: 2
                                // }

                            ],
                            info: true,
                            paging: true,
                            filter: true

                        });


                        table.columns.adjust().draw();
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
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }, {
                                            extend: 'pdf',
                                            text: 'Save As PDF',
                                            footer: true,
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
                    error: function (err) {
                        // //console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });

        });


        // for accept button
        $(document).on("click",".accept",function() {


            var closestRow = '';
            var data = '';
            var st = '';
            var line_id = '';
            var self = '';

            closestRow = $(this).closest('tr');
            data = table.row(closestRow).data();
            st = 'accept';
            line_id = data.line_id;
            self = $(this);

            // console.log(data);
            // alert( 'You clicked on '+data.line_id+'\'s row' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {line_id: line_id, st: st},
                url: "{{ url('scm_portal/pacTrialrcmAccept') }}",
                success: function (resp) {
                    //console.log(resp);
                    if (resp.success) {
                        // //console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.haccept').html('');
                        self.closest('tr').find('.haccept').html('<span class="label label-success "> Accepted </span>');
                        self.closest('tr').find('.accept').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function (e) {
                    //console.log(e);
                }
            });
        } );

    </script>

@endsection