@extends('_layout_shared._master')
@section('title','Clearance Entry')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--for custom excel using tableexport.v3.travismclarke.com library--}}
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


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Clearance Statement
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form">
                        <form action="" class="form-horizontal" role="form" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <label for="st_date"
                                       class="col-md-2 col-sm-2 control-label"><b>Date:</b></label>
                                <div class="col-md-2 col-sm-2">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' name="cl_date" id="cl_date"
                                               class="form-control input-sm"/>
                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                    </div>
                                </div>
                                 <div class="col-md-2 col-sm-2">
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' name="en_date" id="en_date"
                                               class="form-control input-sm"/>
                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                    </div>
                                </div>
                                <br>
                                <br>
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

                            </div>
                        </form>
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
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>SL</th>
                                    <th>PLANT</th>
                                    <th>MATERIAL_NAME</th>
                                    <th>QTY</th>
                                    <th>UOM</th>
                                    <th>RATE</th>
                                    <th>CURRENCY</th>
                                    <th>BDT</th>
                                    <th>BLOCKLIST_NO</th>
                                    <th>BLOCKLIST_DATE</th>
                                    <th>MANUFACTURER_NAME</th>
                                    <th>LC NO</th>
                                    <th>LC DATE</th>
                                    <th>INV NO</th>
                                    <th>INV DATE</th>
                                    <th>CERTIFICATE DATE</th>

                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>

                                </tfoot>
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

    {{--for custom excel using tableexport.v3.travismclarke.com library--}}
    {{Html::script('public/site_resource/js/table-export/xls.core.min.js')}}
    {{Html::script('public/site_resource/js/table-export/FileSaver.min.js')}}
    {{Html::script('public/site_resource/js/table-export/tableexport.min.js')}}

    <script type="text/javascript">

        $(function () {


            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });


            $("#btn_display").click(function () {

                $("#loader").show();
                var cl_dt = $('#cl_date').val();
                var en_dt = $('#en_date').val();
                var data = {cl_date: cl_dt,en_dt: en_dt, "_token": "{{ csrf_token() }}"};


                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('scm_portal/clstm_data') }}",
                    success: function (resp) {

                        // console.log("Success Data : ", resp);

                        $("#loader").hide();
                        $("#report-body").show();


                        // var xlsBuilder = {
                        //     filename: 'Clearance Statement',
                        //     sheetName: 'Clearance_Statement',
                        //     customize: function(xlsx) {
                        //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //         var downrows = 4;
                        //         var clRow = $('row', sheet);
                        //         var msg;
                        //         //update Row
                        //         clRow.each(function() {
                        //             var attr = $(this).attr('r');
                        //             var ind = parseInt(attr);
                        //             ind = ind + downrows;
                        //             $(this).attr("r", ind);
                        //         });
                        //
                        //         // Update  row > c
                        //         $('row c ', sheet).each(function() {
                        //             var attr = $(this).attr('r');
                        //             var pre = attr.substring(0, 1);
                        //             var ind = parseInt(attr.substring(1, attr.length));
                        //             ind = ind + downrows;
                        //             $(this).attr("r", pre + ind);
                        //         });
                        //
                        //         function Addrow(index, data) {
                        //
                        //             msg = '<row xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" r="' + index + '">';
                        //             for (var i = 0; i < data.length; i++) {
                        //                 var key = data[i].k;
                        //                 var value = data[i].v;
                        //                 msg += '<c t="inlineStr" r="' + key + index + '">';
                        //                 msg += '<is>';
                        //                 msg += '<t>' + value + '</t>';
                        //                 msg += '</is>';
                        //                 msg += '</c>';
                        //             }
                        //             msg += '</row>';
                        //             return msg;
                        //         }
                        //         var r1 = Addrow(1, [{
                        //             k: 'A',
                        //             v: 'Export Date :'
                        //         }, {
                        //             k: 'B',
                        //             v: '10-Jan-2017'
                        //         }]);
                        //         var r2 = Addrow(2, [{
                        //             k: 'A',
                        //             v: 'Account Name :'
                        //         }, {
                        //             k: 'B',
                        //             v: 'Melvin'
                        //         }]);
                        //         var r3 = Addrow(3, [{
                        //             k: 'A',
                        //             v: 'Account Id :'
                        //         }, {
                        //             k: 'B',
                        //             v: '021456321'
                        //         }]);
                        //
                        //         sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + sheet.childNodes[0].childNodes[1].innerHTML;
                        //     },
                        //     exportOptions: {
                        //         columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                        //     }
                        // }



                        $("#blk_list").DataTable().destroy();

                        table = $("#blk_list").DataTable({
                            data: resp,
                            columns: [
                                {data: null},
                                {data: "plant"},
                                {data: "material_name"},
                                {data: "qty"},
                                {data: "uom"},
                                {data: "rate"},
                                {data: "currency"},
                                {data: "bdt"},
                                {data: "blocklist_no"},
                                {data: "blocklist_date"},
                                {data: "manufacturer_name"},
                                {data: "lc_no"},
                                {data: "lc_date"},
                                {data: "inv_no"},
                                {data: "inv_date"},
                                {data: "crtf_date"}

                            ],

                            fixedHeader: {
                                header: true,
                                headerOffset: $('#fix').height()
                                //headerOffset: $('#fix').outerHeight()
                            },
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },

                            info: true,
                            paging: false,
                            filter: true,
                            "columnDefs": [
                                {"visible": false, "targets": 9},
                                {"visible": false, "targets": 10},
                                {"visible": false, "targets": 11},
                                {"visible": false, "targets": 12},
                                {"visible": false, "targets": 13},
                                {"visible": false, "targets": 14}
                            ],

                            "drawCallback": function (settings) {
                                var api = this.api();
                                var rows = api.rows({page: 'current'}).nodes();
                                var last = null;
                                api.column(13, {page: 'current'}).data().each(function (group, i) {
                                   if (last !== group) {
                                        var rowData = api.row(i).data();
                                        $(rows).eq(i).before(
                                            '<tr class="group"><td colspan="12">' + '<b>Inv SL: </b>' + (i+1) + " - " + '<b>Inv No: </b>' + group + " - " + '<b>Inv Dt: </b>' + rowData['inv_date'] + " - " + '<b>Lc No: </b>' + rowData['lc_no'] + " - " + '<b>Lc Dt: </b>' + rowData['lc_date'] + '<b>- Manufacturer : </b>' + rowData['manufacturer_name'] + '</td></tr>'
                                        );
                                        last = group;
                                    }
                                });
                            },
                            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                var index = iDisplayIndex + 1;
                                $('td:eq(0)', nRow).html(index);
                                return nRow;
                            }

                        });

                        $("#blk_list").tableExport({
                            formats: ["xls", "xlsx", "csv", "txt"]
                        }).reset();




                        // Top excel sheet data array
                        // var desc = [
                        //     ['Company','Incepta Pharmaceuticals Ltd.'],
                        //     ['Report Date',$('#cl_date').val()]
                        // ];
                        // table.fixedHeader.enable();
                        // new $.fn.dataTable.Buttons(table, {
                        //     buttons: [
                        //         {
                        //             extend: 'collection',
                        //             text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                        //             buttons: [
                        //                 // $.extend(true, {}, xlsBuilder, {
                        //                 //     extend: 'excel'
                        //                 // }),
                        //                 {
                        //                     extend: 'excel',
                        //                     text: 'Save As Excel',
                        //                     footer: true,
                        //                     action: function (e, dt, node, config) {
                        //                         exportExtension = 'Excel';
                        //                         $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                        //                     },
                        //                     header:false,
                        //                     customize: function ( xlsx ) {
                        //                         var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //                         //Bold Header Row
                        //                         $('row[r=3] c', sheet).attr( 's', '2' );
                        //                         //Make You Input Cells Bold Too
                        //                         $('c[r=A1]', sheet).attr( 's', '2' );
                        //                         $('c[r=A2]', sheet).attr( 's', '2' );
                        //                     },
                        //                     customizeData: function(data){
                        //
                        //                         data.body.unshift(data.header);
                        //                         for (var i = 0; i < desc.length; i++) {
                        //                             data.body.unshift(desc[i]);
                        //                         }
                        //                     }
                        //                  }
                        //                 // , {
                        //                 //     extend: 'pdf',
                        //                 //     text: 'Save As PDF',
                        //                 //     orientation: 'landscape',
                        //                 //     footer: true,
                        //                 //     action: function (e, dt, node, config) {
                        //                 //         exportExtension = 'PDF';
                        //                 //         $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                        //                 //     }
                        //                 // }
                        //             ],
                        //             className: 'btn btn-sm btn-primary'
                        //         }
                        //     ]
                        // }).container().appendTo($('#export_buttons'));

                    },
                    error: function (err) {
                        console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });




            });



        });
    </script>


@endsection
