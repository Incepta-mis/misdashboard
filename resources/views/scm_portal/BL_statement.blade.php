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
                        Block List Statement
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12 col-sm-12">
                                <form action="" class="form-horizontal" role="form" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="cmp"
                                                       class="col-md-2 col-sm-2 control-label"><b>Company:</b></label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select name="cmp" id="cmp"
                                                            class="form-control input-sm">
                                                        <option value="">Select Company</option>
                                                        @foreach($cmp_data as $c)
                                                            <option value="{{$c->plant}}">{{$c->company}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="matName" class="col-md-2 col-sm-2 control-label"><b>Material
                                                        Name: </b></label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select class="form-control input-sm matName  " id="matName"  name="matName">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="row">--}}
                                        {{--<div class="col-md-12">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<label for="st_date"--}}
                                                       {{--class="col-md-2 col-sm-2 control-label"><b>Start--}}
                                                        {{--Date:</b></label>--}}
                                                {{--<div class="col-md-2 col-sm-2">--}}
                                                    {{--<div class='input-group date' id='datetimepicker1'>--}}
                                                        {{--<input type='text' name="st_date" id="st_date"--}}
                                                               {{--class="form-control input-sm"/>--}}
                                                        {{--<span class="input-group-addon">--}}
                                                            {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                                                        {{--</span>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<label for="en_date"--}}
                                                       {{--class="col-md-2 col-sm-2 control-label"><b>End Date:</b></label>--}}
                                                {{--<div class="col-md-2 col-sm-2">--}}
                                                    {{--<div class='input-group date' id='datetimepicker2'>--}}
                                                        {{--<input type='text' name="en_date" id="en_date"--}}
                                                               {{--class="form-control input-sm"/>--}}
                                                        {{--<span class="input-group-addon">--}}
                                                            {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                                                        {{--</span>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
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
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{--    @if( !empty($materials) )--}}
    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>

    <div id="target">

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>BLOCKLIST_YEAR</th>
                                    <th>BLOCKLIST_DATE</th>
                                    <th>PLANT</th>
                                    <th>BLOCKLIST_NO</th>
                                    <th>MATERIAL_NAME</th>
                                    <th>MANUFACTURER_NAME</th>
                                    <th>SUPPLIER_NAME</th>
                                    <th>QTY</th>
                                    <th>AVL. QTY</th>
                                    <th>UOM</th>
                                    <th>OUT. QTY</th>
                                    <th>OUT. UOM</th>
                                    <th>AIR_PRICE</th>
                                    <th>ROAD_PRICE</th>
                                    <th>SEA_PRICE</th>
                                    <th>CURRENCY</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
        {{--@endif--}}
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






            $('#cmp').on('change', function () {

                $(".matName").val('');
                var plant = $('#cmp').val();
                $(".matName").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: '{{url('scm_portal/material_name')}}',
                    dataType: 'json',
                    data: {plant: plant,"_token":"{{ csrf_token() }}"},
                    success: function (response) {
                        var selItems ='';
                        selItems += "<option value=''>Select Item</option>";
                        selItems += "<option value='All'>All</option>";
                        for (var l = 0; l< response.length; l++) {
                            var id = response[l]['material_name'];
                            var val = response[l]['material_name'];
                            selItems += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#matName').empty().append(selItems);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

                $(".matName").select2();

            });





            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });


            $("#btn_display").click(function () {

                var plant = $('#cmp').val();
                // var st_dt = $('#st_date').val();
                // var en_dt = $('#en_date').val();
                var matName = $('#matName').val();
                var data;

                {{--if (st_dt === '' && en_dt === '') {--}}
                    {{--data = {plant: plant, matName: matName, "_token": "{{ csrf_token() }}"};--}}
                {{--} else if (st_dt === '' && en_dt === '' && matName === '') {--}}
                    {{--data = {plant: plant, "_token": "{{ csrf_token() }}"};--}}
                {{--} else {--}}
                    {{--data = {plant: plant, matName: matName, "_token": "{{ csrf_token() }}"};--}}
                {{--}--}}

                data = {plant: plant, matName: matName, "_token": "{{ csrf_token() }}"};

                $("#loader").show();


                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('scm_portal/stm_data') }}",
                    success: function (resp) {

                        // console.log(resp);

                        $("#loader").hide();
                        $("#report-body").show();


                        $("#blk_list").DataTable().destroy();
                        table = $("#blk_list").DataTable({
                            data: resp,
                            scrollY: 200,
                            scrollX: true,
                            autoWidth: false,
                            fixedHeader: true,
                            responsive: true,
                            aLengthMenu: [
                                [500, 1000,  -1],
                                [500, 1000, "All"]
                            ],
                            columns: [
                                {data: "blocklist_year"},
                                {data: "blocklist_date"},
                                {data: "plant"},
                                {data: "blocklist_no"},
                                {data: "material_name"},
                                {data: "manufacturer_name"},
                                {data: "supplier_name"},
                                {data: "qty"},
                                {data: "avl_qty"},
                                {data: "uom"},
                                {data: "out_qty"},
                                {data: "out_uom"},
                                {data: "air_price"},
                                {data: "road_price"},
                                {data: "sea_price"},
                                {data: "currency"}
                            ],

                            /*fixedHeader: {
                                header: true,
                                headerOffset: $('#fix').height()
                                //headerOffset: $('#fix').outerHeight()
                            },*/
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            columnDefs: [
                                {
                                    "targets": [ 2 ],
                                    "visible": false,
                                    "searchable": false
                                },
                            ],

                            info: true,
                            paging: false,
                            filter: true

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

            $('#blk_list tbody').on( 'click', 'tr', function () {
                $('#blk_list tr').removeClass('highlighted');
                $(this).addClass('highlighted');
            });

            /*jQuery(function($) {
                $(window).scroll(function fix_element() {
                    $('#target').css(
                        $(window).scrollTop() > 100
                            ? { 'position': 'fixed', 'top': '10px' }
                            : { 'position': 'relative', 'top': 'auto' }
                    );
                    return fix_element;
                }());
            });*/

        });

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
