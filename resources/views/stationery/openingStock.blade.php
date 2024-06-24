@extends('_layout_shared._master')
@section('title','Insert Opening Stock Information')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>
        .swal2-icon.swal2-warning {
            font-size: 14px;
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

        .help-block {
            color: red;
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
        #insert_itemBtn{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }
        #insert_itemBtn:hover{
            color: #fff;
            background-color: #9a4ef0;
            border-color: #9a4ef0;
        }
        .btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
            outline: none;
        }
        .select2-container--default .select2-selection--single{
            border-radius: 0px;
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

        .unit_div .select2-container{
            margin-bottom: 8px;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-warning" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Upload Opening Stock Information
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                {!! Form::open(array('url'=>'stationery/form/uploadStockData','method'=>'POST' ,
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
                                                    <p class="help-block">{{ $errors->first('upload_file') }}</p> @endif
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
                                    <div class="col-md-6 col-sm-12">
                                        <label class="control-label col-md-6">
                                            <span>Click <a href="{{ url('stationery/downloadFile') }}"><i class="fa
                                            fa-hand-o-right"></i> Here </a>to see the sample file.
                                            </span>
                                        </label>
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
                                            Due to the plant ID and item values matching the existing data, the
                                            data could not be uploaded. Please remove them from the file and try
                                            uploading again.
                                        </label>
                                    </header>
                                    <div class="panel-body">
                                        <div class="col-md-12 col-sm-12 table-responsive">
                                            <table id="listTable" width="100%" class="table table-bordered table-condensed table-striped">
                                                <thead style="background-color: #5e5e5e; color: white">
                                                <tr>
                                                    <th>Plant ID</th>
                                                    <th>Main ID</th>
                                                    <th>CWIP ID</th>
                                                    <th>PO Number</th>
                                                    <th>PR Number</th>
                                                    <th>GL</th>
                                                    <th>Cost Center</th>
                                                    <th>Item ID</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Received Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for ($i = 0; $i < count($val); $i++)
                                                    <tr>
                                                        <td>{{ $val[$i]['plant_id'] }}</td>
                                                        <td>{{ $val[$i]['main_id'] }}</td>
                                                        <td>{{ $val[$i]['cwip_id'] }}</td>
                                                        <td>{{ $val[$i]['po_number'] }}</td>
                                                        <td>{{ $val[$i]['pr_number'] }}</td>
                                                        <td>{{ $val[$i]['gl'] }}</td>
                                                        <td>{{ $val[$i]['cost_center'] }}</td>
                                                        <td>{{ $val[$i]['item_id'] }}</td>
                                                        <td>{{ $val[$i]['item_name'] }}</td>
                                                        <td>{{ $val[$i]['opening_quantity'] }}</td>
                                                        <td>{{ $val[$i]['unit'] }}</td>
                                                        <td>{{ $val[$i]['received_date'] }}</td>
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

                @if (session('missingItem'))
                    <?php
                    $val = json_decode(session('missingItem'),true);
                    if(count($val) > 0){
                    ?>
                    <div class="row">
                        <div id="report-body">
                            <div class="col-sm-12 col-md-12">
                                <section class="panel" id="data_table">
                                    <header class="panel-heading" style="text-transform: inherit; color: #e37f52;
                                             font-size: 13px;">
                                        <label class="text-default" style="color: orangered">
                                            Due to these following missing items from the database, the
                                            data could not be uploaded. Please remove them from the file and try
                                            uploading again.
                                        </label>
                                    </header>
                                    <div class="panel-body">
                                        <div class="col-md-12 col-sm-12 table-responsive">
                                            <table id="listTable" width="100%" class="table table-bordered table-condensed table-striped">
                                                <thead style="background-color: #5e5e5e; color: white">
                                                <tr>
                                                    <th>Plant ID</th>
                                                    <th>Main ID</th>
                                                    <th>CWIP ID</th>
                                                    <th>PO Number</th>
                                                    <th>PR Number</th>
                                                    <th>GL</th>
                                                    <th>Cost Center</th>
                                                    <th>Item ID</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Received Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for ($i = 0; $i < count($val); $i++)
                                                    <tr>
                                                        <td>{{ $val[$i]['plant_id'] }}</td>
                                                        <td>{{ $val[$i]['main_id'] }}</td>
                                                        <td>{{ $val[$i]['cwip_id'] }}</td>
                                                        <td>{{ $val[$i]['po_number'] }}</td>
                                                        <td>{{ $val[$i]['pr_number'] }}</td>
                                                        <td>{{ $val[$i]['gl'] }}</td>
                                                        <td>{{ $val[$i]['cost_center'] }}</td>
                                                        <td>{{ $val[$i]['item_id'] }}</td>
                                                        <td>{{ $val[$i]['item_name'] }}</td>
                                                        <td>{{ $val[$i]['opening_quantity'] }}</td>
                                                        <td>{{ $val[$i]['unit'] }}</td>
                                                        <td>{{ $val[$i]['received_date'] }}</td>
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
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-default">
                                Insert Opening Stock Information
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="com_code"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Company Code</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="{{$companyData[0]->sap_com_id}}" name="com_code"
                                                       id="com_code" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="com_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Company Name</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="{{$companyData[0]->com_name}}" name="com_name"
                                                       id="com_name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="plant_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="{{$plant_id}}" name="plant_id"
                                                       id="plant_id" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="main_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Main ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a main ID" name="main_id"
                                                       id="main_id">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="cwip_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>CWIP ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a CWIP ID" name="cwip_id"
                                                       id="cwip_id">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="po_number"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>PO Number</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a PO Number" name="po_number"
                                                       id="po_number">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="pr_number"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>PR Number</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a PR Number" name="pr_number"
                                                       id="pr_number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="gl" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>GL</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose an Item" name="gl"
                                                       id="gl" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="cost_center" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Cost Center</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="cost_center" name="cost_center"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected>Select a Cost center</option>
                                                    @foreach($costCenter as $cc)
                                                        <option value="{{$cc->cost_center_id}}">{{$cc->cost_center_id}} - {{$cc->cost_center_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="item_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Choose an item" name="item_id"
                                                       id="item_id" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="item_name"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item Name</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="item_name" name="item_name"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select Item</option>
                                                    @foreach($item_data as $i)
                                                        <option value="{{$i->item_id}}">{{$i->item_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3 col-sm-3">
                                            <label for="oqty" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Opening Qty</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="number" class="form-control input-sm" id="oqty"
                                                       name="oqty" min="1" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="unit" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Unit</b></label>
                                            <div class="col-md-9 col-sm-9 unit_div">
                                                <select id="unit" name="unit" class="form-control input-sm
                                                filter-option pull-left">
                                                    <option value="" selected>Select a unit</option>
                                                    <option value="custom">Other</option>
                                                    @if(count($units) > 0)
                                                        @foreach($units as $u)
                                                            <option value="{{$u->unit}}">{{$u->unit}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <input type="text" class="form-control input-sm"
                                                           value="" placeholder="Input a unit"
                                                           id="input_unit" style="display: none">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="rdate" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Received Date</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm" id="rdate"
                                                       placeholder="" name="rdate">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="it_name" id="it_name" value="">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                            <button type="button" id="btn_submit" class="btn btn-success btn-sm"
                                                    style="float: right;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Submit</b>
                                            </button>
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            $('#unit').change(function () {
                if($('#unit').val() == 'custom'){
                    $('#input_unit').show();
                }else{
                    $('#input_unit').val('');
                    $('#input_unit').hide();
                }
            });

            var date = new Date();

            $('#cost_center').select2();
            $('#unit').select2();

            $('#rdate').datetimepicker({
                defaultDate: date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true
            });

            $('#item_name').select2();
            $('#item_name').change(function () {
                var item_id = $(this).val();
                $('#item_id').val(item_id);

                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/getItemGL') }}',
                    data: {
                        'item_id': item_id,'_token': "{{ csrf_token() }}" },
                    success: function (data) {
                        if(data != "" && data[0]['gl'] != "" && data[0]['it_name'] != ""){
                            $('#gl').val(data[0]['gl']);
                            $('#it_name').val(data[0]['it_name']);
                        }else{
                            $('#gl').val("");
                            $('#it_name').val("");
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            $('#main_id').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#cwip_id').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#po_number').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#pr_number').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#gl').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#cost_center').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('#input_unit').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();

                var com_code = $('#com_code').val();
                var plant_id = $('#plant_id').val();
                var main_id = $('#main_id').val();
                var cwip_id = $('#cwip_id').val();
                var po_number = $('#po_number').val();
                var pr_number = $('#pr_number').val();
                var gl = $('#gl').val();
                var cost_center = $('#cost_center').val();
                var item_id = $('#item_id').val();
                var item_name = $("#item_name option:selected").text();
                var oqty = $('#oqty').val();

                if($('#unit').val() == 'custom'){
                    var unit = $('#input_unit').val();
                }else{
                    var unit = $('#unit').val();
                }

                var rdate = $('#rdate').val();

                var it_name = $('#it_name').val();
                var status = 0;

                if(it_name == 'STATIONERY'){
                    if(gl != "" && cost_center != ""){
                        status = 1;
                    }else{
                        status = 0;
                    }
                }else if(it_name == 'CAPEX'){
                    if(cwip_id != "" && main_id != ""){
                        status = 1;
                    }else{
                        status = 0;
                    }
                }

                if(status == 0){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    if(com_code === "" || plant_id === "" || rdate === "" || item_id === "" || item_name === "" ||
                        oqty === "" || unit === ""){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please input all required data!',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }else{
                        $.ajax({
                            type: 'post',
                            url: '{{  url('stationery/form/insertStockData') }}',
                            data: {
                                'com_code': com_code, 'plant_id': plant_id, 'main_id': main_id, 'cwip_id': cwip_id,
                                'po_number': po_number, 'pr_number': pr_number, 'rdate': rdate, 'gl': gl,
                                'cost_center':cost_center, 'item_id':item_id, 'item_name':item_name, 'oqty':oqty,
                                'unit':unit, '_token': "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                if (data.response == 1 || data.response == true) {
                                    Swal.fire({
                                        title: 'Success!',
                                        icon: 'success',
                                        text: 'New data has been inserted successfully',
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
                                        text: 'Something was wrong! Data was not saved.',
                                        icon: 'error',
                                        showConfirmButton: true,
                                        confirmButtonText: 'Ok'
                                    })
                                }
                            },
                            error: function (e) {
                                console.log(e);
                            }
                        });
                    }
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
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection