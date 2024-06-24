@extends('_layout_shared._master')
@section('title','Comparative Statement')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


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

        #upload_file {
            outline: none;
            padding: 2px 2px 2px 7px;
        }

        /* .select2-container{
             width: 100%!important;
         }
         .select2-search--dropdown .select2-search__field {
             width: 98%;
         }*/
        a:hover {
            text-decoration: none;
        }
    </style>
@endsection
@section('right-content')


    <div>
        <ul class="nav nav-tabs">
            <li class="active settingshead"><a href="#first" data-toggle="tab"><label class="text-primary">Generate Comparative Statement</label></a></li>
            <li class="settingshead"><a href="#second" data-toggle="tab"><label class="text-success">View / Download Generate Comparative Statement</label></a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="first">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <section class="panel panel-primary" id="data_table">
<!--                        <header class="panel-heading">
                            <label class="text-default">
                                Generate Comparative Statement
                            </label>
                        </header>-->
                        <div class="panel-body">
                            <div class="form-horizontal">

                                <div class="col-md-12 col-sm-12">
                                    <form method="post" action="">
                                        {{ csrf_field() }}

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="ddate"
                                                           class="col-md-2 col-sm-2 control-label"><b>Date: </b></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select class="form-control input-sm  ddate" id="ddate" name="ddate">
                                                            <option value="" disabled> Process Date</option>

                                                            @foreach($selDate as $c)
                                                                <option value="{{$c->ddate}}">  {{$c->ddate}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-check"></i> <b> Process</b></button>
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
                    </section>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="second">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <section class="panel panel-success" id="data_table">
<!--                        <header class="panel-heading">
                            <label class="text-default">
                                View / Download Generate Comparative Statement
                            </label>
                        </header>-->
                        <div class="panel-body">
                            <div class="form-horizontal">

                                <div class="col-md-12 col-sm-12">
<!--                                   <form method="post" action="{{url('scm_portal/comparative_pdf')}}">
                                        {{ csrf_field() }}

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="genDate"
                                                           class="col-md-2 col-sm-2 control-label"><b>Date: </b></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select class="form-control input-sm  genDate" id="genDate" name="genDate">
                                                            <option value="" disabled> Generate Date</option>

                                                            @foreach($rptDate as $d)
                                                                <option value="{{$d->ddate}}">  {{$d->ddate}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="report_display" class="btn btn-success btn-sm">
                                                    <i class="fa fa-check"></i> <b> Display Report </b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">

                                                </div>
                                            </div>
                                        </div>
                                   </form>-->

                                    <form class="form-horizontal" method="post" action="{{url('scm_portal/comparative_pdf')}}">
                                        {{csrf_field()}}
                                        <div class="row">

                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="genDate"
                                                           class="col-md-2 col-sm-2 control-label"><b>Date: </b></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select class="form-control input-sm  genDate" id="genDate" name="genDate">
                                                            <option value="" disabled> Generate Date</option>

                                                            @foreach($rptDate as $d)
                                                                <option value="{{$d->ddate}}">  {{$d->ddate}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                        <button type="submit" id="report_display" class="btn btn-success btn-sm">
                                                            <i class="fa fa-check"></i> <b>Display All Plant Report</b></button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="plant_id"
                                                           class="col-md-2 col-sm-2 control-label"><b>Plant: </b></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select class="form-control input-sm  plant_id" id="plant_id" name="plant_id">
                                                            <option value="" disabled> Select Plant</option>
                                                            <option value="All"> All </option>

                                                            @foreach($plantDate as $p)
                                                                <option value="{{$p->plant_id}}">  {{$p->plant_id}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                        <button type="submit" id="report_plant_display" class="btn btn-warning btn-sm">
                                                            <i class="fa fa-check"></i> <b>Display Plant Wise Report</b></button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="form-group">

                                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                    <div id="export_buttons">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
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


    <div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
        <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/processing.gif')}}"
                     alt="Loading Report Please wait..."><br>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>PLANT_ID</th>
                                    <th>PR</th>
                                    <th>MATERIAL</th>
                                    <th>MATERIAL NAME</th>
                                    <th>PR Qty</th>
                                    <th>QTY PURCH.</th>
                                    <th>SUPPLIER_VENDOR</th>
                                    <th>MANUFACTURER</th>
                                    <th>SAFETY</th>
                                    <th>MODE_OF_SHIPMENT</th>
                                    <th>LAST_UNIT_PRICE_KG</th>
                                    <th>NEW_UNIT_PRICE_KG</th>
                                    <th>REQ_DATE</th>
                                    <th>DELIVERY_DATE</th>
                                    <th>CREATE_DATE</th>
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


    <div class="row" id="vw-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="view_list" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>PLANT_ID</th>
                                    <th>PR</th>
                                    <th>MATERIAL</th>
                                    <th>MATERIAL NAME</th>
                                    <th>PR Qty</th>
                                    <th>QTY PURCH.</th>
                                    <th>SUPPLIER_VENDOR</th>
                                    <th>MANUFACTURER</th>
                                    <th>SAFETY</th>
                                    <th>MODE_OF_SHIPMENT</th>
                                    <th>LAST_UNIT_PRICE_KG</th>
                                    <th>NEW_UNIT_PRICE_KG</th>
                                    <th>REQ_DATE</th>
                                    <th>DELIVERY_DATE</th>
                                    <th>CREATE_DATE</th>
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}


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


        $('#report_display').attr('formtarget', '_blank');
        $(".genDate").select2();


        $(document).ready(function () {


            $(".ddate").select2();
            $(".plant_id").select2();


            $("#btn_display").click(function () {

                var ddate = $('#ddate').val();

                console.log(ddate);


                data = {ddate: ddate, "_token": "{{ csrf_token() }}"};

                $("#loader").show();

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('scm_portal/getComparativeStatementData') }}",
                    success: function (resp) {

                         // console.log(resp);

                        $("#loader").hide();
                        $("#report-body").show();
                        $("#vw-body").hide();


                        $("#blk_list").DataTable().destroy();
                        table = $("#blk_list").DataTable({
                            data: resp,
                            dom: 'Bfrtip',
                            "select": true,
                            buttons: [
                                {
                                    text: 'Saved',
                                    className: 'btn-success',
                                    action: function ( e, dt, node, config ) {
                                        //alert( 'Record Saved' );
                                        toastr.info('Record Saved!');

                                        var insertdata = [];
                                        table.rows().every( function ( rowIdx ) {
                                            var firstVal = $( this.node() ).first().find('input').val();
                                            var lastVal =  $( this.node() ).find("input:last").val();

                                            /*console.log( 'Row ' + (rowIdx+1)  + ' first value: ' + firstVal );
                                            console.log( 'Row ' + (rowIdx+1)  + ' last value: ' + lastVal );*/

                                            insertdata.push({
                                                indexVal : rowIdx+1,
                                                qty_purchase : firstVal.toString(),
                                                new_unit_per_kg : lastVal.toString()
                                            });
                                        } );
                                        // console.log(insertdata);

                                        var data = table.rows().data();
                                        data.each(function(rowData, index) {
                                            rowData['qty_purchase'] = insertdata[index]['qty_purchase'];
                                            rowData['new_unit_per_kg'] = insertdata[index]['new_unit_per_kg'];
                                        });
                                        console.log('In masroor');
                                        console.log(data);

                                        const replacerFunc = () => {
                                            const visited = new WeakSet();
                                            return (key, value) => {
                                                if (typeof value === "object" && value !== null) {
                                                    if (visited.has(value)) {
                                                        return;
                                                    }
                                                    visited.add(value);
                                                }
                                                return value;
                                            };
                                        };



                                        const getCircularReplacer = () => {
                                            const seen = new WeakSet();
                                            return (key, value) => {
                                                if (typeof value === 'object' && value !== null) {
                                                    if (seen.has(value)) {
                                                        return;
                                                    }
                                                    seen.add(value);
                                                }
                                                return value;
                                            };
                                        };



// ✅ Works
//                                         const result = JSON.stringify(data.toArray(), getCircularReplacer());   or
                                        const result = JSON.stringify(data.toArray(), replacerFunc());
                                        console.log(result);










                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            type: "POST",
                                            dataType: 'json',
                                            data: {ComData: result, _token: '{{csrf_token()}}'},
                                            {{--data: {deleteData: JSON.stringify(data,replacerFunc), _token: '{{csrf_token()}}'},--}}
                                            url: '{{url('scm_portal/saveComStatementData')}}',
                                            beforeSend: function(){
                                                // Show image container
                                                $("#loader_submit").show();
                                            },
                                            success: function (data) {
                                                console.log("data "+data);
                                                if(data.error){
                                                    toastr.error(data.error, '', {timeOut: 5000});
                                                }else if(data.success){
                                                    toastr.success(data.success, '', {timeOut: 5000});
                                                }

                                                setTimeout(function(){// wait for 3 secs
                                                    window.location.reload(); // then reload the page
                                                }, 2000);

                                            },
                                            complete:function(data){
                                                // Hide image container
                                                $("#loader_submit").hide();
                                            },
                                            error: function (err) {
                                                console.log(err);
                                            }
                                        });



                                    }
                                }
                            ],
                            /*scrollY: 200,
                            scrollX: true,*/
                            autoWidth: false,
                            responsive: true,
                            aLengthMenu: [
                                [500, 1000, -1],
                                [500, 1000, "All"]
                            ],
                            columns: [

                                {data: "plant_id"},
                                {data: "purch_req"},
                                {data: "material"},
                                {data: "material_desc"},
                                {data: "pr_quantity"},
                                {
                                    data: "pr_quantity",
                                    render: function(data, type, row) {
                                        return '<input  type="text" value="'+data+'" style="color: black;" id="qty_to_purchase" name="qty_to_purchase[]">';
                                    }
                                },
                                {data: "supplier_vendor"},
                                {data: "manufacturer"},
                                {data: "safety"},
                                {data: "mode_of_shipment"},
                                {data: "last_unit_price_kg"},
                                {
                                    data: null,
                                    render: function(data, type, row) {
                                        return '<input  type="text"  value="" style="color: black;" id="new_unit_price" name="new_unit_price[]">';
                                    }
                                },
                                {data: "req_date"},
                                {data: "delivery_date"},
                                {data: "create_date"},

                            ],
                            columnDefs : [
                                //hide the second & fourth column
                                { 'visible': false, 'targets': [12,13,14] }
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },


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

            $("#report_plant_display").click(function (e) {

                e.preventDefault();

                var genDate = $('#genDate').val();
                var plant_id = $('#plant_id').val();

                console.log(ddate);

                if(genDate.length==0){
                    toastr.info('Please select Date!');
                }else if(plant_id.length==0){
                    toastr.info('Please select Plant!');
                }else{


                    data = {genDate: genDate, plant_id: plant_id, "_token": "{{ csrf_token() }}"};

                    $("#loader").show();

                    $.ajax({
                        type: "post",
                        dataType: 'json',
                        data: data,
                        url: "{{ url('scm_portal/getComparativeStatementByPlant') }}",
                        success: function (resp) {

                            // console.log(resp);

                            $("#loader").hide();
                            $("#report-body").hide();
                            $("#vw-body").show();


                            $("#view_list").DataTable().destroy();
                            table = $("#view_list").DataTable({
                                data: resp,
                                autoWidth: false,
                                responsive: true,
                                aLengthMenu: [
                                    [500, 1000, -1],
                                    [500, 1000, "All"]
                                ],
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'excelHtml5',
                                    autoFilter: true,
                                    sheetName: 'Exported data'
                                    },
                                   ],
                                columns: [

                                    {data: "plant_id"},
                                    {data: "purch_req"},
                                    {data: "material"},
                                    {data: "material_desc"},
                                    {data: "pr_quantity"},
                                    {data: "qty_purchase",},
                                    {data: "supplier_vendor"},
                                    {data: "manufacturer"},
                                    {data: "safety"},
                                    {data: "mode_of_shipment"},
                                    {data: "last_unit_price_kg"},
                                    {data: "new_unit_per_kg"},
                                    {data: "req_date"},
                                    {data: "delivery_date"},
                                    {data: "user_created_at"},

                                ],
                                columnDefs : [
                                    //hide the second & fourth column
                                    { 'visible': false, 'targets': [12,13,14] }
                                ],
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },


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

                }




            });

        });

    </script>
@endsection
