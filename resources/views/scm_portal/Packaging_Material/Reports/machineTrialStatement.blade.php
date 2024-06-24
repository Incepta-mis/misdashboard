<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2019
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Machine Trial Statement')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .bolded {
            font-weight:bold;
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

        input {
            color: black;
        }

        #blk_list > tbody > tr > td {
            word-break: break-all;
        }

        #blk_list.display {
            margin: 0 auto;
            width: 100%;
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap:break-word;
        }

        #blk_list.dataTable tr.odd  { background-color: #E0FFFF; }
        #blk_list.dataTable tr.even  { background-color: #E6E6FA; }

        tr.highlighted td {
            background: yellow;
        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Machine Trial Statement
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12 col-sm-12">
                                <form action="" class="form-horizontal" role="form" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="cmp"
                                                           class="col-md-3 col-sm-3 control-label"><b>Company:</b></label>
                                                    <div class="col-md-9 col-sm-9">
                                                        <select name="cmp" id="cmp"
                                                                class="form-control input-sm cmp">
                                                            <option value="">Select Company</option>
                                                            @foreach($cmp_data as $c)
                                                                <option value="{{$c->plant}}">{{$c->company}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="ref_no" class="col-md-3 col-sm-3 control-label"><b>Ref. NO: </b></label>
                                                    <div class="col-md-9 col-sm-9">
                                                        <select class="form-control input-sm ref_no" id="ref_no"  name="ref_no">
                                                            <option value="">Select Reference</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="p_name"
                                                           class="col-md-3 col-sm-3 control-label"><b>Product Name:</b></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select name="p_name" id="p_name"
                                                                class="form-control input-sm p_name">
                                                            <option value="">Select Product</option>
                                                            <option value="All" selected>All</option>
                                                            @foreach($p_data as $e)
                                                                <option value="{{$e->product_name}}">{{$e->product_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-group">

                                                    <label for="date" class="col-md-3 col-sm-3 control-label"><b>Date
                                                        </b></label>
                                                    <div class="col-sm-4 col-md-4">
                                                        <input type="text" class="form-control input-sm" autocomplete="off" name="st_dt"
                                                               style="font-size: x-small; padding-right: 0px;" id="datetimepicker1">
                                                    </div>

                                                    <div class="col-sm-4 col-md-4">
                                                        <input type="text" class="form-control input-sm"
                                                               style="font-size: x-small;" autocomplete="off"
                                                               name="en_dt" id="datetimepicker2">
                                                    </div>

                                            </div>
                                        </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <div class="col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-check"></i> <b>Show Reports</b></button>
                                                </div>
                                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                    <div id="export_buttons">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
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
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div style="background-color: #5AB6DF;">
                            {{--Company : <span id="cname" style="font-size: large; color: #761c19"> </span>. &nbsp; And Selected Blocklist is: <span id="blklistno" style="font-size: large;  color: #761c19"> </span>--}}
                            Company : <span id="cname" style="font-size: large; color: white"> </span>
                        </div>
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%;">
                                <thead style="background-color: #3CB371">
                                <tr style="color: white">
                                    <th>Trial Ref Number</th>
                                    <th>File</th>
                                    <th>Date of Trial Request</th>
                                    <th>Product Name</th>
                                    <th>Item Description</th>
                                    <th>Manu/Supplier Name</th>
                                    <th>SCM Concern</th>
                                    <th>SCM Remarks</th>
                                    <th>RCM Appr.</th>
                                    <th>RCM Appr_Date</th>
                                    <th>R&D/QC Concern</th>
                                    <th>Sample Received Date</th>
                                    <th>Report Receiving Date</th>
                                    <th>R&D/QC Remarks</th>
                                    <th>Share</th>
                                </tr>
                                </thead>
                                <tbody ></tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modalTitle"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="idForm" class="form-horizontal" role="form" method="post" action="{{ url('scm_portal/sendSupplierInfo') }}">
                        {{ csrf_field() }}

                        <input type="hidden" class="form-control referenceNO" name="referenceNO" >
                        <div class="form-group">

                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">To</label>
                            <div class="col-lg-10">
                                <select id="inputEmail1" rows="4" name="to_email[]" multiple="multiple" class="form-control input-sm inputEmail1">

                                </select>
{{--                                <input type="email" class="form-control" name="to_email" id="inputEmail1" placeholder="Email">--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">From</label>
                            <div class="col-lg-10">
                                <input type="email" class="form-control" name="frm_email"  readonly id="inputEmail2" placeholder="Email" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-lg-2 col-sm-2 control-label">Subject</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="subject"  id="subject" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Message</label>
                            <div class="col-lg-10">
                                <textarea rows="4" class="form-control" name="body_message" spellcheck="false"></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
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

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script>

        $(document).ready(function () {


            $(".cmp").select2();
            $(".ref_no").select2();
            $(".p_name").select2();

            $('#clear_blk').hide();

            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#cmp').on('change', function () {

                $(".ref_no").val('');
                var plant = $('#cmp').val();
                console.log(plant);
                $(".ref_no").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: '{{url('scm_portal/getAllTrialReference')}}',
                    dataType: 'json',
                    data: {plant: plant,"_token":"{{ csrf_token() }}"},
                    success: function (response) {

                        var selbllist ='';
                        selbllist += "<option value=''>Select Item</option>";
                        selbllist += "<option value='All'>All</option>";
                        for (var k = 0; k< response.length; k++) {
                            var id = response[k]['trial_ref_no'];
                            var val = response[k]['trial_ref_no'];
                            selbllist += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('.ref_no').empty().append(selbllist);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

                $(".ref_no").select2();

            });




            $("#btn_display").click(function () {

                $('#clear_blk').hide();
                var plant = $('#cmp').val();
                var ref_no = $('#ref_no').val();
                var p_name = $('#p_name').val();

                var d1 = $('#datetimepicker1').val();
                var d2 = $('#datetimepicker2').val();


                console.log("Date 1",d1);
                console.log("Date 2",d2);


                var dataxx;

                var cnm =  $('.cmp').find(":selected").text();
                var blk =  $('.blList').find(":selected").text();

                $('#cname').text(cnm);
                $('#blklistno').text(blk);

                $("#loader").show();

                dataxx = { plant: plant, ref_no: ref_no, p_name : p_name, date1: d1, date2: d2, "_token": "{{ csrf_token() }}"};
                var table;
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: dataxx,
                    url: "{{ url('scm_portal/getScmTrialStatement') }}",
                    success: function (resp) {

                        console.log(resp);

                        $("#loader").hide();
                        $("#report-body").show();

                        $("#blk_list").DataTable().destroy();
                        table = $("#blk_list").DataTable({
                            data: resp,
                            autoWidth: true,
                            responsive: true,
                            fixedHeader: true,
                            paging: true,
                            scrollCollapse: true,
                            filter: true,
                            searching: true,

                            columns: [
                                {data: "trial_ref_no"},
                                {
                                    data: "final_trila_file",
                                    render: function(data, type, row, meta){
                                            // return '<a target="_blank" class="btn btn-warning btn-xs lt">' + data + '</a>';
                                        if(data === null){
                                            return '';
                                        }else{
                                            if(type === 'display'){
                                                data = '<a target="_blank" style="color:#0000FF; font-size: small;" href="{{ url('public/SCM/TrialReq/FinalTrialFile') }}' +"/"+ data + '">' + data + '</a>';
                                            }
                                            return data;
                                        }

                                    }


                                },
                                {data: "req_date"},
                                {data: "product_name"},
                                {data: "item_desc"},
                                {data: "supplier_name"},
                                {data: "scm_concern"},
                                {data: "scm_remarks"},
                                {data: "rcm_name"},
                                {data: "rcm_app_date"},
                                {data: "rnd_concern"},
                                {data: "sample_received"},
                                {data: "rpt_date"},
                                {data: "rnd_remarks"},
                                {
                                    data: "null",
                                    render: function(data, type, row, meta) {
                                        return '<button class="btn btn-sm btn-primary" data-toggle="modal" data-id="'+row.trial_ref_no+'" data-Journal="' + data + '" type="button" data-target="#myModal"><span><i class="glyphicon glyphicon-send"></i></span>' + " Email " + '</button>';
                                    }

                                },
                            ],
                            columnDefs: [
                                { width: '10%', targets: 0 },
                            ],

                            language: {
                                "emptyTable": "No Matching Records Found."
                            },


                        });


                        $("#myModal").on('show.bs.modal', function (e) {
                            var triggerLink = $(e.relatedTarget);
                            var id = triggerLink.data("id");
                            $(this).find(".referenceNO").val(id);
                        });

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

            $('#inputEmail1').select2({
                placeholder: " Select an Email",
                allowClear: true,
                width: '100%',
                // selectOnClose: true,
                tags: true,
                // createTag: function (params) {
                //     // Don't offset to create a tag if there is no @ symbol
                //     if (params.term.indexOf('@') === -1) {
                //         // Return null to disable tag creation
                //         return null;
                //     }
                //
                //     return {
                //         id: params.term,
                //         text: params.term
                //     }
                // },
                //Allow manually entered text in drop down.
                createSearchChoice: function (term, data) {
                    if ($(data).filter(function () {
                        return this.text.localeCompare(term) === 0;
                    }).length === 0) {
                        return { id: term, text: term };
                    }
                },
            });



            // this is the id of the form
            $("#idForm").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        alert(data); // show response from the php script.
                    }
                });


            });


        });
    </script>

@endsection

