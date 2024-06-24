@extends('_layout_shared._master')
@section('title','Comparative Master Data Upload')
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
        #upload_file{
            outline: none;
            padding: 2px 2px 2px 7px;
        }
       /* .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }*/
        a:hover{
            text-decoration: none;
        }
    </style>
@endsection
@section('right-content')


    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Comparative Master Data Upload
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {!! Form::open(array('url'=>'scm_portal/uploadComparativeRawMaterialList','method'=>'POST' ,
                                'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label col-md-3" for="upload_file">Select File:</label>
                                        <div class="col-md-6 col-xs-11">
                                            <div class="input-group">
                                                <input type="file" id="upload_file" name="upload_file"
                                                       class="form-control form-control-inline input-medium">
                                                @if ($errors->has('upload_file'))
                                                    <p class="help-block">{{ $errors->first('upload_file') }}</p>
                                                @endif
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
                                        ('scm_portal/scmComparativeFile')}}"><i class="fa fa-hand-o-right"></i> Here </a>to
                                            see the sample file.</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('dup_data'))
                    <?php
                    $val = json_decode(session('dup_data'),true);
                    if(count($val) > 0){
                    ?>
                    <div class="row">
                        <div id="report-body">
                            <div class="col-sm-12 col-md-12">
                                <section class="panel" id="data_table">
                                    <header class="panel-heading" style="text-transform: inherit; color: #e37f52;
                                             font-size: 13px;">
                                        <label class="text-default" style="color: orangered">
                                            Due to the values matching the existing data, these details could not be uploaded.
                                        </label>
                                    </header>
                                    <div class="panel-body">
                                        <div class="col-md-12 col-sm-12 table-responsive">
                                            <table id="listTable" width="100%" class="table table-bordered table-condensed table-striped">
                                                <thead style="background-color: #5e5e5e; color: white">
                                                <tr>

                                                    <th>Material</th>
                                                    <th>Material Desc.</th>
                                                    <th>Supplier / Vendor</th>
                                                    <th>Manufacturer</th>
                                                    <th>Safety</th>
                                                    <th>Mode of shipment</th>
                                                    <th>last unit price/kg</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for ($i = 0; $i < count($val); $i++)
                                                    <tr>
                                                        <td>{{ $val[$i]['material'] }}</td>
                                                        <td>{{ $val[$i]['material_desc'] }}</td>
                                                        <td>{{ $val[$i]['supplier_vendor'] }}</td>
                                                        <td>{{ $val[$i]['manufacturer'] }}</td>
                                                        <td>{{ $val[$i]['safety'] }}</td>
                                                        <td>{{ $val[$i]['mode_of_shipment'] }}</td>
                                                        <td>{{ $val[$i]['last_unit_price_kg'] }}</td>
                                                    </tr>
                                                @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                @endif
            </section>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-warning" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Comparative Master Data View
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">

                        <div class="col-md-12 col-sm-12">
                            <form  method="post" action="">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="matName" class="col-md-2 col-sm-2 control-label"><b>Material Name: </b></label>
<!--                                            <div class="col-md-6 col-sm-6">

                                                <select class="form-control input-sm  matName" id="matName"  name="matName">
                                                </select>
                                            </div>-->

                                            <div class="col-md-6 col-sm-6">
                                                <select class="form-control input-sm  matName" id="matName"  name="matName">
                                                    <option value="" disabled> Select Material </option>
                                                    <option value="All"> All </option>
                                                    @foreach($mat as $c)
                                                        <option value="{{$c->material}}"> {{$c->material}} - {{$c->material_desc}}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>



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
            </section>
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
                                    <th>MATERIAL</th>
                                    <th>MATERIAL_DESC</th>
                                    <th>SUPPLIER_VENDOR</th>
                                    <th>MANUFACTURER</th>
                                    <th>SAFETY</th>
                                    <th>MODE_OF_SHIPMENT</th>
                                    <th>LAST_UNIT_PRICE_KG</th>

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



       {{-- $(document).ready(function () {


            $(".matName").select2();

/*            function initializeSelect2Mat(selectElementObj) {
                selectElementObj.select2({
                    placeholder: 'Select Material',
                    minimumInputLength: 3,
                    dropdownAutoWidth: true,
                    // width: 'auto',
                    ajax: {
                        url: "{{ url('scm_portal/getComMaterialName') }}",
                        dataType: 'json',
                        delay: 150,
                        data: function (term) {
                            return {
                                term: term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {

                                    console.log(item);

                                    return {
                                        text: item.material_desc,
                                        id: item.material_desc
                                    }
                                })
                            };
                        },
                        cache: true
                    },
                    tags: true,
                    selectOnClose: true,

                    //Allow manually entered text in drop down.
                    createSearchChoice: function (term, data) {
                        if ($(data).filter(function () {
                            return this.text.localeCompare(term) === 0;
                        }).length === 0) {
                            return { id: term, text: term };
                        }
                    },
                });
            }

            $(".matName").each(function () {
                initializeSelect2Mat($(this));
            });*/


        });--}}


        $(document).ready(function () {



            $(".matName").select2();



            $("#btn_display").click(function () {

                var matName = $('#matName').val();
                data = { matName: matName, "_token": "{{ csrf_token() }}"};

                $("#loader").show();

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('scm_portal/getComMaterialData') }}",
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
                            responsive: true,
                            aLengthMenu: [
                                [500, 1000,  -1],
                                [500, 1000, "All"]
                            ],
                            columns: [

                                {data: "material"},
                                {data: "material_desc"},
                                {data: "supplier_vendor"},
                                {data: "manufacturer"},
                                {data: "safety"},
                                {data: "mode_of_shipment"},
                                {data: "last_unit_price_kg"},

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

        });

    </script>
@endsection
