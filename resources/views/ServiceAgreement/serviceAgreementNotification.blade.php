@extends('_layout_shared._master')
@section('title','Service Agreement Notification')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>

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



        .swal2-icon.swal2-warning {
            font-size: 14px;
        }

        .swal2-html-container{
            font-size: 1.5em !important;
        }
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

        .cls-req{
            color: red;
            font-weight: bold;
        }
    </style>
@endsection
@section('right-content')

    {{-- Filter Option--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Display Service Agreement Notification
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Service:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="select_service" name="select_service" class="form-control input-sm filter-option">
                                                    <option selected disabled>Select Service</option>
                                                    <option value="all">ALL</option>
                                                    @foreach($service_name as $service_names)
                                                        <option value="{{$service_names->id}}">{{$service_names->service}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="display_report" class="btn btn-warning btn-sm" disabled>
                                                    <i class="fa fa-chevron-circle-up"></i> <b>Display</b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">
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


    {{--show datatable--}}
    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="service_datatable" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead style="background-color: #454790; color: white;">
                                <tr>

                                    <th>ID</th>

                                    <th>Service Name</th>
                                    <th>Category</th>
                                    <th>Deadline</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
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


   {{-- Upload Excel file--}}
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-warning" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Upload Data
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {!! Form::open(array('url'=>'serviceAgreementNotification/uploadServiceExcelData','method'=>'POST' ,
                                'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label col-md-3" for="upload_file" style="font-weight: bold">Select File:</label>
                                        <div class="col-md-6 col-xs-11">
                                            <div class="input-group">
                                                <input type="file" id="upload_file" name="upload_file"
                                                       class="form-control form-control-inline input-medium">
                                                @if ($errors->has('upload_file'))
                                                    <p style="color: red" class="help-block">{{ $errors->first('upload_file') }}</p> @endif
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

                                        <label class="control-label col-md-6"><span>Click <a href="{{url
                                        ('public/serviceAgreement/SampleData.xlsx')}}"><i class="fa fa-hand-o-right"></i> Here </a>to see the sample file.</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

    {{--Form--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">

                <div class="panel-body" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Service Agreement Notification Form</legend>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="col-md-3 col-sm-3">
                                                <label for="invoice_no_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Service:<span class='cls-req'>*</span> </b></label>
                                                <input type="text" class="form-control input-sm" id="service"
                                                       placeholder="Enter Serviece Name" name="service">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="inv_date_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Category:<span class='cls-req'>*</span></b></label>
                                                <input type="" class="form-control input-sm" id="category"
                                                       placeholder="Enter Category" name="category">
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <label for="visa_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Activity:<span class='cls-req'>submit_form*</span></b></label>
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Enter Activity" min="1"  name="activity"
                                                       id="activity">
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <label for="ticket_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Deadline:<span class='cls-req'>*</span></b> </label>
                                                <input type="" class="form-control input-sm" id="deadline"
                                                       name="deadline" value="">
                                            </div>

                                            <div class="col-md-2 col-sm-2">
                                                <label for="hotel_cost_form" class="control-label fnt_size"
                                                       style="padding-right:0px;"><b>Status: </b></label>
                                                <input type="text" class="form-control input-sm" id="status"
                                                       placeholder="Enter Status" min="1"  name="status">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-6" >
                                                <button type="button" id="submit_form" class="btn btn-info btn-sm"
                                                        style="float: right">
                                                    <i class="fa fa-chevron-circle-up"></i> <b>Submit</b>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{--

                                hadson gems and buthia
                                gini---

                                hadson jemes and buthia
                                hadson gemes and buthia
                                philipine er

                                --}}

                            </fieldset>
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


    {{--Modal for update--}}
    <div id="editServiceNotification" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color: #46B8DA">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Item</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="service_id" class="control-label col-sm-2">ID.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="service_id" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_service_name" class="control-label col-sm-2">Service Name.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_service_name" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_category" class="control-label col-sm-2">Category:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_category" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_activity" class="control-label col-sm-2">Activity:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="" class="form-control" id="edit_activity" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_deadline" class="control-label col-sm-2">Deadline:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type=""  class="form-control" id="edit_deadline" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_status" class="control-label col-sm-2">Status:</label>
                            <div class="col-sm-10">
                                <input type="text"  class="form-control" id="edit_status" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="update_record">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id_update">
                    </form>
                </div>
            </div>
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
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            $('#select_service').select2();

            $('#select_service').change(function () {
                $('#display_report').prop("disabled", false);
            });

            var date = new Date();
            $('#deadline').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });


            $('#edit_deadline').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#submit_form').on('click', function (e) {

                e.preventDefault();
                $("#loader").show();


                var  service = $('#service').val();
                var  category = $('#category').val();
                var  activity = $('#activity').val();
                var   deadline = $('#deadline').val();
                var   status = $('#status').val();



                var dataList = {};


                dataList.service=service;
                dataList.cetegory=category;
                dataList.activity=activity;
                dataList.dead_line=deadline;
                dataList.status=status;


                var dataListObject = JSON.stringify(dataList);

                if(service==''||category==''||activity==''||deadline=='')
                {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Insert Required Field',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                    $("#loader").hide();

                }else{

                    $.ajax({
                        type: 'post',
                        url: '{{  url('serviceAgreementNotification/savePost') }}',
                        data: { 'dataListObject': dataListObject, '_token': "{{ csrf_token
                    () }}"},
                        success: function (data) {

                            $("#loader").hide();

                            if(data.result=='success'){

                                $("#loader").hide();
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item Saved Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'

                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                                $("#item_issue_form").trigger('reset');
                                item_id = $('#item_id').val('');

                            }else if(data.result=='exists'){
                                Swal.fire({
                                    title: 'Warning!',
                                    text: 'User Already Exists',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        },
                        error: function (e) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something was wrong! Failed to save.',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            })
                            console.log("in error")
                        }
                    });
                }
            });

            $('#display_report').on('click', function (e) {
                e.preventDefault();
                $("#loader").show();

                var service_name = $('#select_service').val();
                var table = null;

                $.ajax({
                    type: 'post',
                    url: '{{  url('serviceAgreementNotification/getDatatableData') }}',
                    data: { 'service_name': service_name, '_token': "{{ csrf_token
                    () }}"},
                    success: function (data) {

                        $("#loader").hide();
                        $("#showTable").show();

                        console.log("datatable data")
                        console.log(data);

                        $("#service_datatable").DataTable().destroy();


                        table = $("#service_datatable").DataTable({
                            data: data.result,
                            autoWidth: true,
                            columns: [
                                {data: "id"},
                                {data: "service"},
                                {data: "cetegory"},
                                {data: "dead_line"},
                                {data: "activity"},
                                {data: "status"},
                                { data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-info row-edit ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="editThisRecord('+"'"+row.id+"','"+row.service+"','"+row.cetegory+"','"+row.activity+"','"+row.dead_line+"','"+row.status+"')"+'">EDIT</button>'
                                    }
                                },

                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="deleteThisRecord('+"'"+row.id+"','"+row.challan_no+"')"+'">Delete</button>'
                                    }
                                }

                            ],
                            columnDefs: [
                                {
                                    "defaultContent": " ",
                                    "targets": "_all"
                                }
                            ],

                            scrollCollapse: true,
                            info: true,


                        });

                        // table.fixedHeader.enable();
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
                                            orientation: 'landscape',
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
                        console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });

            $(document).on("click","#update_record",function(e) {
                e.preventDefault();
                var service = $("#edit_service_name").val();
                var cetegory = $("#edit_category").val();
                var activity = $("#edit_activity").val();
                var deadline = $("#edit_deadline").val();
                var status = $("#edit_status").val();

                var table_id = $("#table_id_update").val();


                var itemArray = {};

                itemArray.service = service;
                itemArray.cetegory = cetegory;
                itemArray.activity = activity;
                itemArray.deadline = deadline
                itemArray.status = status;


                var itemArrayData = JSON.stringify(itemArray);

                if (!service || !cetegory || !activity ||!deadline) {
                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please Input Required Field!',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('serviceAgreementNotification/updateServiceData') }}',
                        data: {'id': table_id, 'itemArray': itemArrayData, '_token': "{{ csrf_token () }}"},

                        success: function (data) {


                            if (data.result == 1 || data.result == "success") {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Updated Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e)

                        }
                    });


                    /*
                    *
                    *
                    *
                    * */



                }

            });


        });

        function deleteThisRecord(id){
            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete  it!'
            }).then((result) => {

                if (result.isConfirmed) {


                    $.ajax({
                        type: 'delete',
                        url: '{{  url('serviceAgreementNotification/deleteServiceData') }}',
                        data: { 'id':id, '_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if(data.status == "success"){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item has been deleted Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to Delete',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }
                        },

                        error: function (e) {

                            console.log(e);
                        }
                    });
                }
            })
        }


        function editThisRecord(id,service,category,activity,deadline,status){

            $("#service_id").val(id);
            $("#table_id_update").val(id);

            $("#edit_service_name").val(id);

            if(service=='null'){
                $("#edit_service_name").val("");
            }else{
                $("#edit_service_name").val(service);
            }

            if(category=='null'){
                $("#edit_category").val("");
            }else{
                $("#edit_category").val(category);
            }

            if(activity=='null'){
                $("#edit_activity").val("");
            }else{
                $("#edit_activity").val(activity);
            }

            if(deadline=='null'){
                $("#edit_deadline").val("");
            }else{
                $("#edit_deadline").val(deadline);
            }

            if(edit_status=='null' ){
                $("#edit_status").val("");
            }else{
                $("#edit_status").val(status);
            }


            $("#editServiceNotification").modal('show');


        }





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
    </script>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection