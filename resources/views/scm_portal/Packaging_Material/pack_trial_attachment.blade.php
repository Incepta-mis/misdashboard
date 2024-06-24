<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2019
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Packaging Material Requisition Form')
@section('styles')


    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>


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

        #myTable {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        #myTable tbody {
            display: table;
            width: 100%;
        }
        #myTable > thead > tr > th {
            padding: 2px;
            font-size: 11px;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }


        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }

        .form-group.required .control-label:after {
            content: "*";
            color: red;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        select + .select2-container {
            width: 100% !important;
        }


    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Packaging Material Machine Trial
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

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="ref_no" class="col-md-3 col-sm-3 control-label"><b>Reference:</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select name="ref_no" id="ref_no"
                                                    class="form-control input-sm ref_no">
                                                <option value="">Select Reference</option>
                                                @foreach($ref_no as $c)
                                                    <option value="{{$c->trial_ref_no}}">{{$c->trial_ref_no}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <button type="button" id="btn_display"  class="btn btn-info btn-sm">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                    </button>
                                </div>
                            </div>

                    </div>
                </div>
            </section>
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
                        <table id="example" class="display table table-bordered table-striped"  style="width:100%">
                            <thead>
                            <tr>
                                <th>Line ID</th>
                                <th>Ref. No</th>
                                <th>Product Name</th>
                                <th>Item Description</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Supplier Name</th>
                                <th>Concern Product</th>
                                <th>SCM Remarks</th>
                                <th>Status</th>
                                <th>Sample Received</th>
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

{{--    <div class="row" id="trialFromCoa">--}}
{{--        <div class="col-md-12 col-sm-12">--}}
{{--            <div id="trialPdfForm"></div>--}}
{{--            <div id="coaFile"></div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div id="trialFromCoa" style="display: none;">
        <div class="row" >
            <div class="row">
                <div class="col-md-12 col-sm-12">

                    <div class="col-md-4 col-sm-4">
                        <form id="" method="post" action="{{ url('scm_portal/trialFormPdf') }}">
                            {{ csrf_field() }}

                            <div class="col-sm-12 col-md-12">
                                <input type="hidden" name="line_id" id="l_id" >
                                <button type="submit" formtarget="_blank" class="btn btn-warning btn-sm">
                                    <i class="fa fa-download"></i> <b>Download Trial Form</b>
                                </button>

                            </div>
                        </form>
                    </div>

                    <div class="col-md-4 col-sm-4">

                        <div class="col-sm-12 col-md-12">
                            <div id="coaFile"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <header class="panel-heading">
                            <label class="text-primary">
                                Add Attachment & Share
                            </label>
                        </header>
                        <br>

                        <form method="post" enctype="multipart/form-data" action="{{ url('scm_portal/saveSCMShareAttachment') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="ref_no" id="sel_lid" >

                            <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div style="position:relative;">
                                            <a class='btn btn-primary btn-sm' href='javascript:;'>
                                                Choose File...
                                                <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter:
                                                         alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
                                                         opacity:0;background-color:transparent;color:transparent;'
                                                       name="final_pdf" size="40" id="inputGroupFile01" required = 'required'
                                                       onchange='$("#upload-final").html($(this).val());'>
                                            </a>
                                            &nbsp;
                                            <span class='label label-info upload-final' id="upload-final"></span>
                                            <button type="button" id="clear" class="btn btn-sm btn-primary">Clear!</button>
                                        </div>
                                    </div>
                                <p class="help-block">e.g: PACK_706_130721.pdf (max: 3mb)</p>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="scm_email"
                                                   class="col-md-3 col-sm-3 control-label"><b>Concern (SCM):</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="scm_email" name="scm_email[]" required multiple="multiple" class="form-control input-sm scm_email">
                                                    @foreach($scm_email as $r)
                                                        <option value="{{$r->emp_email}}">{{$r->emp_email}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="remarks" class="col-md-4 col-sm-4 control-label"><b>Remarks/Comments:</b></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="remarks" name="remarks"  class="form-control input-sm remarks">
                                                        <option value="">Select ...</option>
                                                        <option value="Trial Ok">Trial Ok</option>
                                                        <option value="Trial Not Ok">Trial Not Ok</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="col-sm-12 col-md-12">
                                <input type="submit"  class="btn btn-info btn-sm fa fa-share" value="Sent">
                                
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')



    {{Html::script('public/site_resource/js/bootstrap-lightbox.min.js')}}
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

        $(document).ready(function () {



            $("#clear").click(function() {
                $(".upload-final").html('');
                $("#inputGroupFile01").val('');
            })

            $('.ref_no').select2();

            $('.ref_no').on('change', function() {
                $("#sel_lid").val($('.ref_no').val());
            })
            $('#trialFromCoa').hide();


            $("#btn_display").click(function () {

                $('#trialFromCoa').hide();

                var ref_no = $('.ref_no').val();
                console.log(ref_no);


                if ($("#report-body").is(":visible")) {
                    $("#report-body").hide();
                }

                $("#loader").show();
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    data: {ref_no: ref_no},
                    url: "{{ url('scm_portal/getConcernedList') }}",
                    success: function (resp) {
                        console.log('super visor', resp);
                        $("#loader").hide();
                        $("#report-body").show();

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({
                            data: resp,
                            autoWidth: true,
                            paging:  false,
                            columns: [
                                {data: "line_id"},
                                {data: "trial_ref_no"},
                                {data: "product_name"},
                                {data: "item_desc"},
                                {data: "qty"},
                                {data: "uom"},
                                {data: "supplier_name"},
                                {data: "concern_product"},
                                {data: "scm_remarks"},

                                {
                                    data: "rcm_emp_id",
                                    className: "saccept",
                                    "render": function (data, type, row) {

                                        console.log("get row data =",row);

                                        if  (row.rnd_emp_id === null) {
                                            return '<span class="label label-warning">Pending</span>';
                                        }
                                        else if (row.rnd_emp_id !== null) {
                                            return '<span class="label label-success "> Accepted </span>';
                                        }
                                    }
                                },
                                {
                                    data: null,
                                    "render": function (row) {
                                        if (row.rnd_emp_id !== null) {
                                            return "<button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>";
                                        }
                                        else{
                                            return "<button type='button' class='btn btn-success btn-xs accept' id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>";
                                        }
                                    }
                                }
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            columnDefs: [
                                {
                                    "targets": [0],
                                    "visible": false
                                }
                            ],
                            bFilter: false,
                            info: false,
                        });

                        var quafile = resp[0].qua_file;
                        var coaUrlPdf = "{{ asset('/public/SCM/TrialReq') }}"+'/'+quafile;
                        $('#l_id').val(resp[0].line_id);

                        $('#coaFile').empty().append('<a target="_blank" class="btn btn-primary btn-sm" href="'+coaUrlPdf+'"' +
                            '<i class="fa fa-download"></i> <b>Download COA</b>' +
                            '</a>');


                        if( resp[0].rnd_emp_id !== null ){
                            $('#trialFromCoa').show();
                        }else{
                            $('#trialFromCoa').hide();
                        }



                    },
                    error: function (err) {
                        // console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });
        });
        $(document).on("click",".accept",function(e) {
           
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();

            var st = 'accept';
            var line_id = data.line_id;
            var quafile = data.qua_file;
            var self = $(this);
            var rcm_emp_id = data.rcm_emp_id;
            var rcm_app_date = data.rcm_app_date;

            if(rcm_app_date === null){
                swal({
                    type: 'error',
                    text: 'Still not recommended. Please contact at supply chain.'
                });
            }else{
                $(this).prop("disabled",true);

                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    data: {line_id: line_id, st: st},
                    url: "{{ url('scm_portal/concernedAccept') }}",
                    success: function (resp) {
                        // console.log(resp);
                        if (resp.success) {
                            // console.log(self.closest('tr').find('.saccept').html());
                            self.closest('tr').find('.saccept').html('');
                            self.closest('tr').find('.saccept').html('<span class="label label-success "> Accepted </span>');
                            self.closest('tr').find('.accept').attr('disabled', true);
                            toastr.success(resp.success, '', {timeOut: 2000});
                            resp = '';
                            console.log(resp);

                            $('#trialFromCoa').show();

                        } else {
                            toastr.error(resp.error, '', {timeOut: 2000});
                        }
                    },
                    error: function () {

                    }
                });
            }
        });

        $('#remarks').select2({
            placeholder: " Select Remarks",
            allowClear: true,
            // selectOnClose: true,
            tags: true,
            createTag: function (params) {
                // Don't offset to create a tag if there is no @ symbol

                return {
                    id: params.term,
                    text: params.term
                }
            },
            //Allow manually entered text in drop down.
            createSearchChoice: function (term, data) {
                if ($(data).filter(function () {
                    return this.text.localeCompare(term) === 0;
                }).length === 0) {
                    return { id: term, text: term };
                }
            },
        });

        $('.scm_email').select2({
            placeholder: " Select an Email",
            allowClear: true,
            // selectOnClose: true,
            tags: true,
            createTag: function (params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {
                    id: params.term,
                    text: params.term
                }
            },
            //Allow manually entered text in drop down.
            createSearchChoice: function (term, data) {
                if ($(data).filter(function () {
                    return this.text.localeCompare(term) === 0;
                }).length === 0) {
                    return { id: term, text: term };
                }
            },
        });

        $(document).on('click', 'form input[type=submit]', function(e) {

                var fileScm = $('#inputGroupFile01').val();
                var scm_email = $('#scm_email').val();
                var remarks = $('#remarks').val();


                if(  fileScm === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter File'
                    });
                    e.preventDefault();
                    return false;
                }else if(  scm_email === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Email'
                    });
                    e.preventDefault();
                    return false;
                }else if(  remarks === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Remarks'
                    });
                    e.preventDefault();
                    return false;
                }else {
                    return true;
                }

        });


    </script>
@endsection
