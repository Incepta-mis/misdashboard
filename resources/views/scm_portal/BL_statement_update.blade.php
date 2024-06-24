<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2019
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Block List Statement')
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
                        Block List Statement Update
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12 col-sm-12">
                                <form action="" class="form-horizontal" role="form" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
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
                                                <label for="blList" class="col-md-3 col-sm-3 control-label"><b>BlockList: </b></label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select class="form-control input-sm blList" id="blList"  name="blList">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                <i class="fa fa-check"></i> <b>Material Details</b></button>
                                        </div>
                                        <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                            <div id="export_buttons">

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
                            Company : <span id="cname" style="font-size: large; color: white"> </span>. &nbsp; And Selected Blocklist is: <span id="blklistno" style="font-size: large;  color: white"> </span>
                        </div>
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%;">
                                <thead style="background-color: #3CB371">
                                <tr style="color: white">
                                    <th>MATERIAL</th>
                                    <th>MANUFACTURER</th>
                                    <th>SUPPLIER_NAME</th>
                                    <th>APP. QTY</th>
                                    <th>CLR. Qty</th>
                                    <th>AVL. QTY</th>
                                    <th>UOM</th>
                                    <th>RATE</th>
                                    <th>CURR</th>
                                </tr>
                                </thead>
                                <tbody ></tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                            <div>
                                <button type="button" id="up_mat_qty" class="btn btn-info">Update</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="row" id="clear_blk" style="display: none">
        <div class="col-sm-4 col-md4">
            <section class="panel">
                <div class="panel-body">
                    <table id="tbl_clear" class="table table-striped table-bordered" style="width:100%;">
                        <thead>
                        <tr style="color: #761c19">
                            <th>Clear Date</th>
                            <th>Clear Quantity</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
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

                $(".blList").val('');
                var plant = $('#cmp').val();
                console.log(plant);
                $(".blList").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: '{{url('scm_portal/plant_blocklist')}}',
                    dataType: 'json',
                    data: {plant: plant,"_token":"{{ csrf_token() }}"},
                    success: function (response) {

                        var selbllist ='';
                        selbllist += "<option value=''>Select Item</option>";
                        // selbllist += "<option value='All'>All</option>";
                        for (var k = 0; k< response.length; k++) {
                            var id = response[k]['blocklist_no'];
                            var val = response[k]['blocklist_no'];
                            selbllist += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('#blList').empty().append(selbllist);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

                $(".blList").select2();

            });


            $("#btn_display").click(function () {

                $('#clear_blk').hide();
                var plant = $('#cmp').val();
                var blList = $('#blList').val();
                var dataxx;

                var cnm =  $('.cmp').find(":selected").text();
                var blk =  $('.blList').find(":selected").text();
                $('#cname').text(cnm);
                $('#blklistno').text(blk);

                $("#loader").show();

                dataxx = {plant: plant, blList: blList, "_token": "{{ csrf_token() }}"};
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: dataxx,
                    url: "{{ url('scm_portal/get_stm_data') }}",
                    success: function (resp) {

                        console.log(resp);

                        $("#loader").hide();
                        $("#report-body").show();

                        $("#blk_list").DataTable().destroy();
                        table = $("#blk_list").DataTable({
                            data: resp,
                            autoWidth: true,
                            columns: [
                                {data: "material_name"},
                                {data: "manufacturer_name"},
                                {data: "supplier_name"},
                                {data: "qty"},
                                {data: null},
                                {data: "avl_qty"},
                                {data: "uom"},
                                // {data: "out_qty"},
                                {data: "price"},
                                {data: "currency"}
                            ],
                            columnDefs: [
                                { width: '20%', targets: 0 },
                                { width: '20%', targets: 1 },
                                { width: '20%', targets: 2 },
                                { targets: 4,
                                    render: function(data, type, full, meta){
                                            return '<input class="clr_qty" type="number" step="0.01" style="width: 50px;" value="">'
                                    }
                                }
                            ],

                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            scrollCollapse: true,
                            info: true,
                            paging: false,
                            filter: false,
                            searching: false,

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


            $('#up_mat_qty').on('click',function () {
                console.log('Yes Clicked');
                var cells = [];
                var uMatQty = [];
                var rows = $("#blk_list").dataTable().fnGetNodes();
                for(var i=0;i<rows.length;i++)
                {
                    cells.push($(rows[i]).find("td:eq(0)").html());
                }
                $(".clr_qty").each(function () {
                    valuex = $(this).val();
                    uMatQty.push(valuex);
                });
                // console.log(cells,'-',uMatQty);

                var blklist = $('#blList').val();

                // console.log(blklist);

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: {blkListNO: blklist,matData: cells,matQty:uMatQty ,"_token":"{{ csrf_token() }}"},
                    url: "{{ url('scm_portal/postMatData') }}",
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            toastr.success(data.success, '', {timeOut: 2000});
                            var plant = $('#cmp').val();
                            var blList = $('#blList').val();
                            udata = {plant: plant, blList: blList, "_token": "{{ csrf_token() }}"};
                            $.ajax({
                                type: "post",
                                dataType: 'json',
                                data: udata,
                                url: "{{ url('scm_portal/get_stm_data') }}",
                                success: function (resp) {

                                    console.log( 'asdfdasfasdf',resp);

                                    $("#loader").hide();
                                    $("#report-body").show();


                                    $("#blk_list").DataTable().destroy();
                                    table = $("#blk_list").DataTable({
                                        data: resp,
                                        autoWidth: true,
                                        columns: [
                                            {data: "material_name"},
                                            {data: "manufacturer_name"},
                                            {data: "supplier_name"},
                                            {data: "qty"},
                                            {data: null},
                                            {data: "avl_qty"},
                                            {data: "uom"},
                                            // {data: "out_qty"},
                                            {data: "price"},
                                            {data: "currency"}
                                        ],
                                        columnDefs: [
                                            { width: '20%', targets: 0 },
                                            { width: '20%', targets: 1 },
                                            { width: '20%', targets: 2 },
                                            { targets: 4,
                                                render: function(data, type, full, meta){
                                                    return '<input class="clr_qty" type="number" style="width: 50px;" value="">'
                                                }
                                            }
                                        ],

                                        language: {
                                            "emptyTable": "No Matching Records Found."
                                        },
                                        // scrollCollapse: true,
                                        info: true,
                                        paging: false,
                                        filter: false,
                                        searching: false,


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
                        }
                        else {
                            toaster.error(data.error, '', {timeOut: 2000});
                            // setTimeout(function(){
                            //     location.reload();
                            // }, 1000);
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });

            });


            $('#blk_list tbody').on( 'click', 'tr', function () {
                $('#clear_blk').show();

                    $('#blk_list tr').removeClass('highlighted');
                    $(this).addClass('highlighted');

                var data = table.row($(this).closest('tr')).data();
                var blklist_no = data[Object.keys(data)[0]];
                var mat_name = data[Object.keys(data)[1]];
                var xtable;
                data = {blklist_no: blklist_no, mat_name: mat_name, "_token": "{{ csrf_token() }}"};
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('scm_portal/get_clearQty') }}",
                    success: function (resp) {
                        console.log(resp);
                        $("#tbl_clear").DataTable().destroy();
                        xtable = $("#tbl_clear").DataTable({
                            data: resp,
                            autoWidth: true,
                            columns: [
                                {data: "clear_dt"},
                                {data: "clear_qty"}
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            scrollCollapse: false,
                            info: false,
                            paging: false,
                            filter: false,
                            searching: false
                        });
                    },
                    error: function (err) {
                        console.log(err);
                        $('#clear_blk').hide();
                    }
                });

            } );


        });
    </script>

@endsection

