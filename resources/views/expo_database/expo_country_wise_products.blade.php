@extends('_layout_shared._master')
@section('title','Master Data Entry Form')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
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

    </style>
@endsection
@section('right-content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">

        <section class="panel">
            <header class="panel-heading">
                Master Data Entry Form
            </header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="expoForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group required">
                                    {{--                            --}}
                        <label for="exp_country" class="col-lg-2 col-sm-2 control-label">Export Country</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                                {{--                                <input type="text" class="form-control input-sm" id="exp_country">--}}
                            <select name="exp_country" id="exp_country"
                                    class="form-control input-sm fip">
                                <option value="">Select Country</option>
                                @foreach($country as $c)
                                    <option value="{{$c->country_name}}">( {{ $c->country_code }} ) - {{$c->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="plant_id" class="col-lg-2 col-sm-2 control-label">Plant ID</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <select name="plant_id" id="plant_id"
                                    class="form-control input-sm">
                                <option value="">Select Plant</option>
                                @foreach($plant as $p)
                                    <option value="{{$p->plant_id}}">{{$p->plant_id}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fi_pcode" class="col-lg-2 col-sm-2 control-label">Finish Product Code</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <input type="number" class="form-control input-sm" id="fi_pcode" name="fi_pcode">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="prod_code" class="col-lg-2 col-sm-2 control-label">Product / Bulk Code</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <select name="prod_code" id="prod_code"
                                    class="form-control input-sm">
                                <option value="">Select Product Code</option>
                                {{--                                    @foreach($pbcode as $b)--}}
                                {{--                                        <option value="{{$b->product_code }}">{{$b->plant_id}} - {{  $b->product_code }}</option>--}}
                                {{--                                    @endforeach--}}
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label for="prod_name" class="col-lg-2 col-sm-2 control-label">Product Name</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                                {{--                                <input type="text" class="form-control input-sm" id="prod_name" name="prod_name">--}}

                            <select id="prod_name" name="prod_name"
                                    class="form-control input-sm filter-option pull-left">
                                <option value="">Select Product Name</option>

                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="prod_generic" class="col-lg-2 col-sm-2 control-label">Product Generic</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <input type="text" class="form-control input-sm" id="prod_generic" name="prod_generic">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pack_size" class="col-lg-2 col-sm-2 control-label">Pack Size</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <input type="text" class="form-control input-sm" id="pack_size" name="pack_size">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="com_agentName" class="col-lg-2 col-sm-2 control-label">Company Agent Name</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <input type="text" class="form-control input-sm" id="com_agentName" name="com_agentName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_name" class="col-lg-2 col-sm-2 control-label">Contact Name</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <input type="text" class="form-control input-sm" id="contact_name" name="contact_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-lg-2 col-sm-2 control-label">Address</label>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <input type="text" class="form-control input-sm" id="address" name="address">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="button" class="btn btn-primary sv-expo" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </section>


    </div>
</div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Upload Excel Country Wise Data
                    </label>
                </header>
                <div class="panel-body">

                    <div class="form-horizontal">
                        {!! Form::open(array('url'=>'expo/uploadExpoCountryWiseData','method'=>'POST' ,'enctype'=>'multipart/form-data','class'=>'form-horizontal','files'=>true)) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="date_from">
                                <b>Select File:</b>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="input-group">
                                    <input type="file" id="date_from" name="import_file" class="form-control input-sm">
                                    @if ($errors->has('import_file'))
                                        <p class="help-block">{{ $errors->first('import_file') }}</p> @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-check"></i> <b>Upload</b>
                                </button>
                            </div>
                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                <div id="export_buttons">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <br><b style="color: green;">Excel Demo Format Below:</b> <br>
                                {{Html::image('public/site_resource/images/expo_country_wise_products.png')}}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="panel-body">
            <div class="col-sm-12 col-md-12">
                <div class="form-horizontal">
                    <form class="form-inline" role="form">
                        <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5 input-sm">
                                <b>Finish Product Code:</b>
                            </label>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <input type="text" class="form-control" id="search_productCode"
                                       placeholder="Finish Product Code">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="sr_pcode">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-xs-12">
                <div id="report-body" style="display: none;">
                    <div class="col-sm-12 col-md-12">
                        <section class="panel" id="data_table">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="p_list" class="table table-striped table-bordered"
                                           style="width:100%">
                                        <thead style="white-space:nowrap;">
                                        <tr>
                                            <th>FINISH_PRODUCT_CODE</th>
                                            <th>PLANT_ID</th>
                                            <th>PRODUCT_CODE</th>
                                            <th>PRODUCT_NAME</th>
                                            <th>GENERIC</th>
                                            <th>EXPORT_COUNTRY</th>
                                            <th>PACK_SIZE</th>
                                            <th>COMPANY_AGENT_NAME</th>
                                            <th>CONTACT_NAME</th>
                                            <th>ADDRESS</th>
                                        </tr>
                                        </thead>
                                        <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                        <tfoot></tfoot>
                                    </table>

                                </div>
                            </div>
                        </section>
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
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}

    <script>

        $('#exp_country').select2();
        $('#plant_id').select2();
        $('#prod_code').select2();
        $('#prod_name').select2();

        $(document).ready(function () {
            
                        // Changing Plant option started here
                        $('#plant_id').change(function () {
                $('#prod_code').empty().append($('<option></option>').html('Loading...'));
                var plant_id = $('#plant_id').val();
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('expo/getBulkCode') !!}',
                    data: {'plant_id': plant_id},
                    success: function (data) {

                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Product Code</option>';
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['product_code'] + ' ">' + data[i]['product_code'] + '</option>';
                            }
                            $('#prod_code').html(" ");
                            $('#prod_code').append(em);

                        } else {
                            $('#prod_code').html(" ");
                            $('#prod_code').append('<option value="0" selected disabled>No Records Found.</option>');
                        }
                    },
                    error: function () {
                    }
                });

            });
            // Changing Product code option started here
            $('#prod_code').change(function () {
                $('#prod_name').empty().append($('<option></option>').html('Loading...'));
                var prod_code = $('#prod_code').val();
                var plant_id = $('#plant_id').val();
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('expo/getProductName') !!}',
                    data: {'prod_code': prod_code, 'plant_id' : plant_id},
                    success: function (data) {
                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Product</option>';
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['product_name'] + ' ">'+ data[i]['product_name'] + '</option>';
                            }
                            $('#prod_name').html(" ");
                            $('#prod_name').append(em);

                        } else {
                            $('#prod_name').html(" ");
                            $('#prod_name').append('<option value="0" selected disabled>No Records Found.</option>');
                        }
                    },
                    error: function () {
                    }
                });

            });

            $('.sv-expo').on('click',function () {

                var cntry =  $.trim($('#exp_country').val());
                var plid =  $.trim($('#plant_id').val());
                // var fiCode =  $.trim($('#fi_pcode').val());
                var pcode =  $.trim($('#prod_code').val());
                var pName =  $.trim($('#prod_name').val());


                if( cntry.length === 0 ) {
                    toastr.error("", 'Please Select Country. !!!', {timeOut: 2000});
                }else if(plid.length === 0){
                    toastr.error("", 'Please Enter Plant. !!!', {timeOut: 2000});
                }else if(pcode.length === 0){
                    toastr.error("", 'Please Enter Bulk/Product Code. !!!', {timeOut: 2000});
                }else if(pName.length === 0){
                    toastr.error("", 'Please Enter Product Name. !!!', {timeOut: 2000});
                }else {
                    var data = $('#expoForm').serializeArray();
                    var v_url = "{{ url('expo/saveExpoCountryWise') }}";
                    $.post(v_url, data)
                        .done(function(msg){
                            console.log(msg);
                            $("#expoForm")[0].reset();
                            if(msg.success){
                                toastr.success(msg.success, '', {timeOut: 2000});
                            }else {
                                toastr.error(msg.error, 'Unable to save record.', {timeOut: 2000});
                            }
                        })
                        .fail(function(xhr, status, error) {
                            toastr.error(msg.error, '', {timeOut: 2000});
                        });
                }
            });
            
            
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });

            // new $.fn.dataTable.Buttons(table, {
            //     buttons: [
            //         {
            //             extend: 'collection',
            //             text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
            //             buttons: [
            //                 {
            //                     extend: 'excel',
            //                     text: 'Save As Excel',
            //                     // footer: true,
            //                     action: function (e, dt, node, config) {
            //                         exportExtension = 'Excel';
            //                         $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
            //                     }
            //                 }, {
            //                     extend: 'pdf',
            //                     text: 'Save As PDF',
            //                     orientation: 'landscape',
            //                     // footer: true,
            //                     action: function (e, dt, node, config) {
            //                         exportExtension = 'PDF';
            //                         $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
            //                     }
            //                 }
            //             ],
            //             className: 'btn btn-sm btn-primary'
            //         }
            //     ]
            // }).container().appendTo($('#export_buttons'));
        });


        $('#sr_pcode').on('click',function () {
            var p_code = $('#search_productCode').val();

            $.ajax({
                type: "post",
                url: '{{url('expo/getFinishProductInfo')}}',
                data: { finish_p_code: p_code , _token: '{{csrf_token()}}' },
                success: function (data) {

                    console.log(data);
                    $('#report-body').show();

                    $("#p_list").DataTable().destroy();
                    var table = $("#p_list").DataTable({
                        data:data,
                        columns: [
                            {data: "finish_product_code"},
                            {data: "plant_id"},
                            {data: "product_code"},
                            {data: "product_name"},
                            {data: "product_generic"},
                            {data: "export_country"},
                            {data: "pack_size"},
                            {data: "company_agent_name"},
                            {data: "contact_name"},
                            {data: "address"}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: true,
                        paging: true,
                        filter: false
                    });
                },
                error: function (e) {
                    swal({
                        type: 'error',
                        text: e
                    });
                }
            });
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
