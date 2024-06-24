<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2021
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Block List Application Update Form')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
{{--    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>--}}


    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/clockpicker/jquery-clockpicker.min.css')}}" rel="stylesheet" type="text/css"/>


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
                        Block List Application Update Form
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
                        <form class="form-horizontal" role="form" id="form-id"  method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label for="cmp"
                                               class="col-md-3 col-sm-3 control-label"><b>Application ID:</b></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select name="app_id" id="app_id"
                                                    class="form-control input-sm app_id">
                                                <option value="">Select Application</option>
                                                @foreach($cmp_data as $c)
                                                    <option value="{{$c->app_id}}"> AppID: {{$c->app_id}}, Emp_id: {{$c->create_user}}, Date: {{$c->app_date}}, Company: {{$c->company_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_submit" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>
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

                            <table id="blk_list" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>LINE_ID</th>
                                    <th>APP_ID</th>
                                    <th>PLANT</th>
                                    <th>SL_NO</th>
                                    <th>BL_TYPE</th>
                                    <th>BLOCKLIST_YEAR</th>
                                    <th>BLOCKLIST_DATE</th>
                                    <th>BLOCKLIST_NO</th>
                                    <th>MATERIAL_NAME</th>
                                    <th>MANUFACTURER_NAME</th>
                                    <th>SUPPLIER_NAME</th>
                                    <th>QTY</th>
                                    <th>UOM</th>
                                    <th>AIR_PRICE</th>
                                    <th>ROAD_PRICE</th>
                                    <th>SEA_PRICE</th>
                                    <th>CURRENCY</th>
                                    <th>FINISHED_PRODUCT</th>
                                    <th>QTY_OF_FP</th>
                                    <th>ACTION</th>
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

    <div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
        <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/processing.gif')}}"
                     alt="Loading Report Please wait..."><br>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Block List to Application Form</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="bl_frm" method="get">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="cmp"
                                   class="col-md-6 col-sm-6 control-label"><b>Application ID:</b></label>
                            <div class="col-md-4 col-sm-4">
                                <input type="text" style="text-align: center;" readonly id="apply_id" class="text-info" name="apply_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="bl_type">BL Type:</label>
                            <div class="col-sm-10">
                                <select name="bl_type" id="bl_type" class="form-control input-sm bl_type">
                                    <option value="">Select BlockList Type</option>
                                    <option value="API">API</option>
                                    <option value="Excipient">Excipient</option>
                                    <option value="Packaging">Packaging</option>
                                    <option value="Lab Item">Lab Item</option>
                                    <option value="For R&D">For R&D</option>
                                    <option value="Chemicals">Chemicals</option>
                                    <option value="Bulk">Bulk</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="material">Material:</label>
                            <div class="col-sm-10">
                                <select style="width: 250px; "  class="form-control input-sm  material" name="material"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-right" for="manufacturer">Manufacturer:</label>
                            <div class="col-sm-10">
                                <select  style="width: 250px; "  class="form-control input-sm  manufacturer" name="manufacturer"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-right" for="supplier">Supplier:</label>
                            <div class="col-sm-10">
                                <select  style="width: 250px;" class="form-control input-sm  supplier" name="supplier"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="qty">Quantity:</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.01"  style="width: 80px;"  class="form-control input-sm  qty" name="qty" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="uom">UOM:</label>
                            <div class="col-sm-10">
                                <select  class="form-control input-sm uom" style="width: 250px;" name="uom" id="uom" required>
                                    <option value="">Select</option>
                                    <option value="KG">KG</option>
                                    <option value="GM">GM</option>
                                    <option value="MG">MG</option>
                                    <option value="Million IU">Million IU</option>
                                    <option value="Billion CFU">Billion CFU</option>
                                    <option value="ML">Mole (ML)</option>
                                    <option value="L">L</option>
                                    <option value="ROLL">ROLL</option>
                                    <option value="BOTTLE">Bottle</option>
                                    <option value="MLF">MFL</option>
                                    <option value="DOSE">DOSE</option>
                                    <option value="MT">MT</option>
                                    <option value="PTH">Per Thousand (Per TH)</option>
                                    <option value="Per HUN">Per Hundred (Per HUN)</option>
                                    <option value="Per LAC">Per Lac (Per LAC)</option>
                                    <option value="MM">Millimetre (MM)</option>
                                    <option value="MILLION DOSE">MILLION DOSE</option>
                                    <option value="MILLION LF ">MILLION LF</option>
                                    <option value="ML">ML</option>
                                    <option value="MIC">Micron (MIC)</option>
                                    <option value="Meter">Meter (M)</option>
                                    <option value="PC">Piece (PCS)</option>
                                    <option value="PACK">PACK</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="currency">Currency:</label>
                            <div class="col-sm-10">
                                <select id="currency" name="currency" style="width: 80px;"  class="form-control m-bot15 currency">
                                    <option selected value="USD">$ USD</option>
                                    <option value="EUR" >€ EUR</option>
                                    <option value="GBP" >£ GBP</option>
                                    <option value="YEN" >¥ YEN</option>
                                    <option value="CAD">$ CAD</option>
                                    <option value="AUD">$ AUD</option>
                                    <option value="SEK">kr SEK</option>
                                    <option value="SIN">$ SIN</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="air">Air:</label>
                            <div class="col-sm-10">
                                <input  type="number"  step="0.001"  style="width: 80px;" class="form-control input-sm  air" name="air"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sea">Sea:</label>
                            <div class="col-sm-10">
                                <input type="number"  step="0.001"  style="width: 80px;" class="form-control input-sm  sea" name="sea"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-2" for="road">Road:</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.001"  style="width: 80px;" class="form-control input-sm  road" name="road"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="cfp">Finish Product:</label>
                            <div class="col-sm-10">
                                <select style="width: 120px;" class="form-control input-sm  cfp" name="cfp"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="qty_fp">Qty of FP:</label>
                            <div class="col-sm-10">
                                <input type="number" step="0.001"  style="width: 80px;" class="form-control input-sm  qty_fp" name="qty_fp"/>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info" id="sbt_btn">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
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
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{--Time Picker--}}
    {{Html::script('public/site_resource/js/clockpicker/jquery-clockpicker.min.js')}}



    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}



    <script type="text/javascript">
        let table;



        $(document).ready(function () {

            $('.app_id').select2();

            $('#btn_submit').on('click', function () {
                let app_id = $('#app_id').val();
                console.log("Applicatin ID: ", app_id);

                $("#loader").show();


                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: {app_id: app_id, "_token": "{{ csrf_token() }}"},
                    url: "{{ url('scm_portal/getAppUpdate') }}",
                    success: function (resp) {

                        console.log(resp);

                        $("#loader").hide();
                        $("#report-body").show();

                        $("#blk_list").DataTable().destroy();
                        table = $("#blk_list").DataTable({

                            data: resp,
                            dom: 'Bfrtip',
                            buttons: [
                                'excel',
                                    {
                                        text: '<span class="fa fa-exchange" aria-hidden="true"></span> Transfer ',
                                        attr: {
                                            id: 'btn-add-review'
                                        },
                                        action: function(e, dt, node, config) {

                                            console.log($('#app_id').val());


                                            $.ajax({
                                                type: "POST",
                                                dataType: 'json',
                                                data: {app_id: app_id,"_token": "{{ csrf_token() }}"},
                                                url: "{{ url('scm_portal/scm_transfer_data_to_master') }}",
                                                beforeSend: function(){
                                                    // Show image container
                                                    $("#loader_submit").show();
                                                },
                                                success: function (data) {
                                                    console.log("data "+data);
                                                    if(data.error){
                                                        toastr.error(data.error, 'Contact Adminstrator: Data send not possible.', {timeOut: 5000});
                                                    }else if(data.success){
                                                        toastr.success('success', 'Transfer Successfully', {timeOut: 5000});
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



                                        },
                                        /*initComplete: function() {
                                            console.log('Test');
                                            var btns = $('#btn-add-review');
                                            btns.addClass('btn btn-warning btn-sm');
                                            btns.removeClass('dt-button');
                                        }*/
                                    },
                                    {
                                        text: '<span class="fa fa-plus-circle" id="addrow" aria-hidden="true"></span> Add ',
                                        action: function (e, dt, node, config) {

                                            $('#apply_id').val($('#app_id').val());
                                            $("#myModal").modal('show');

                                        },
                                    },


                                ],



                            columns: [
                                {data: "line_id"},
                                {data: "app_id"},
                                {data: "plant"},
                                {data: "sl_no"},
                                {data: "bl_type", className:"editable"},
                                {data: "blocklist_year", className:"editable"},
                                {data: "blocklist_date", className:"editable"},
                                {data: "blocklist_no", className:"editable"},
                                {data: "material_name", className:"editable"},
                                {data: "manufacturer_name", className:"editable"},
                                {data: "supplier_name", className:"editable"},
                                {data: "qty", className:"editable"},
                                {data: "uom", className:"editable"},
                                {data: "air_price", className:"editable"},
                                {data: "road_price", className:"editable"},
                                {data: "sea_price", className:"editable"},
                                {data: "currency", className:"editable"},
                                {data: "cfp", className:"editable"},
                                {data: "qty_finish_product", className:"editable"},
                                {data: null},

                            ],

                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            columnDefs: [
                                {
                                    "targets": [ 0,1,2 ],
                                    "visible": false,
                                    "searchable": false
                                },
                                {
                                    targets: -1,
                                    data: null,
                                    defaultContent: "<button type='button' class='btn btn-danger btn-xs edit-btn'><span class='glyphicon glyphicon-trash'></span>   </button>"
                                },
                            ],

                            info: true,
                            paging: false,
                            filter: true

                        });



                    },
                    error: function (err) {
                        console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });





            // Inline editing
            let oldValue = null;
            let line_id   = null;
            let colName  = null;
            let clcolName  = null;
            let newValue = null;

            $(document).on('dblclick', '.editable', function(){



                oldValue = $(this).html();
                $(this).removeClass('editable');	// to stop from making repeated request
                clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();

                if(clcolName === 'BL_TYPE')
                {
                     $(this).html('<select name="bl_type" id="bl_type" class="form-control input-sm bl_type">' +
                         '<option value="'+ oldValue +'" selected>'+ oldValue +'</option> ' +
                         '<option value="API">API</option>' +
                         '<option value="Excipient">Excipient</option>' +
                         '<option value="Packaging">Packaging</option>' +
                         '<option value="Lab Item">Lab Item</option>' +
                         '<option value="For R&D">For R&D</option>' +
                         '<option value="Chemicals">Chemicals</option>' +
                         '<option value="Bulk">Bulk</option>' +
                         '</select>');

                    $(this).find('.bl_type').focus();

                    line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);
                    console.log(data.line_id);
                    line_id = data.line_id;


                    //send update select value to database
                    $(document).on('change', '.bl_type', function(){
                        console.log("bl_TYPE");

                        let elem    = $(this);
                        newValue 	= $(this).val();
                        line_id	    = line_id;
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);

                        if(newValue != oldValue)
                        {
                                $.ajax({
                                     url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                    method : 'post',
                                    data :
                                        {
                                            line_id    : line_id,
                                            colName  : colName,
                                            newValue : newValue,
                                            '_token' : '{{csrf_token()}}',
                                        },
                                    success : function(resp)
                                    {
                                        console.log('Update Value = ',resp['success']);
                                        // if(resp['success'] === 'true'){
                                        //     swal({
                                        //         type: 'success',
                                        //         text: 'Record Saved !'
                                        //     });
                                        // }
                                        $(elem).parent().addClass('editable');
                                        $(elem).parent().html(newValue);
                                    },
                                    error : function (e){
                                        swal({
                                            type: 'error',
                                            text: 'Internal Server Error!!!'
                                        });
                                    }
                                });



                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });

                }
                else if(clcolName === 'BLOCKLIST_DATE')
                {

                    $(this).html('<div class=\'input-group date\' id=\'datetimepicker1\'>' +
                        '<input type=\'text\' name="lc_dt" id="lc_dt" class="form-control lc_dt datetimepicker1" required/>' +
                        '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar">' +
                        '</span></span>' +
                        '</div>');


                    $('.datetimepicker1').datepicker({
                        format: 'MM/DD/YY',
                        todayHighlight: 'TRUE',
                        autoclose: true
                    });

                    $(this).find('.lc_dt').focus();
                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    let data = table.row($(this).parents('tr')).data();
                    console.log(data);
                    console.log(data.line_id);
                    line_id = data.line_id;


                    //send update select value to database
                    $(document).on('change', '.lc_dt', function () {

                        let elem = $(this);
                        newValue = $(this).val();
                        line_id = line_id;
                        colName = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ", newValue);
                        console.log(elem, '-', line_id, '-', colName);

                        if (newValue != oldValue) {
                            $.ajax({
                                url: '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method: 'post',
                                data:
                                    {
                                        line_id: line_id,
                                        colName: colName,
                                        newValue: newValue,
                                        '_token': '{{csrf_token()}}',
                                    },
                                success: function (respone) {
                                    // console.log('Update Value = ',respone);
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);

                                    /*if(x){
                                        swal({
                                            type: 'success',
                                            text: 'Record Saved !'
                                        });
                                    }*/

                                },
                                error: function (e) {
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });

                        } else {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }



                    });

                }
                else if(clcolName === 'MATERIAL_NAME')
                {

                  /* $(this).html('<select name="app_id" id="app_id" class="form-control input-sm update" > ' +
                        '<option value="'+ oldValue +'" selected>'+ oldValue +'</option> ' +
                        '</select>'); */

                    $(this).html('<select style="width: 100px;" id="floating" class="form-control input-sm mat"></select>');
                    $('.mat').select2({
                        minimumInputLength: 3,
                        dropdownAutoWidth: true,
                        ajax: {
                        url: "{{ url('scm_portal/getUpMaterialName') }}",
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
                                        text: item.material_name,
                                        id: item.material_name
                                    }
                                })
                            };
                        },
                        cache: false,
                        selectOnClose: true,
                    },
                    });

                    $(this).find('.mat').focus();
                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);
                    console.log(data.line_id);
                    line_id = data.line_id;



                    //send update select value to database
                    $(document).on('change', '.mat', function(){

                        let elem    = $(this);
                        newValue 	= $(this).val();
                        line_id	    = line_id;
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);

                        if(newValue != oldValue)
                        {
                            $.ajax({
                                url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method : 'post',
                                data :
                                    {
                                        line_id    : line_id,
                                        colName  : colName,
                                        newValue : newValue,
                                        '_token' : '{{csrf_token()}}',
                                    },
                                success : function(resp)
                                {
                                    console.log('Update Value = ',resp['success']);
                                    /*if(resp['success'] === 'true'){
                                        swal({
                                            type: 'success',
                                            text: 'Record Saved !'
                                        });
                                    }*/
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);
                                },
                                error : function (e){
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });

                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });


                }
                else if(clcolName ===  'MANUFACTURER_NAME')
                {
                    $(this).html('<select style="width: 100px;" class="form-control input-sm manuf"></select>');
                    $('.manuf').select2({
                        minimumInputLength: 3,
                        dropdownAutoWidth: true,
                        ajax: {
                            url: "{{ url('scm_portal/getUpManufacturerName') }}",
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
                                            text: item.manufacturer_name,
                                            id: item.manufacturer_name
                                        }
                                    })
                                };
                            },
                            cache: false,
                            selectOnClose: true,
                        },
                    });
                    $(this).find('.manuf').focus();
                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);
                    console.log(data.line_id);
                    line_id = data.line_id;


                    //send update select value to database
                    $(document).on('change', '.manuf', function(){


                        let elem    = $(this);
                        newValue 	= $(this).val();
                        line_id	    = line_id;
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);

                        if(newValue != oldValue)
                        {
                            $.ajax({
                                url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method : 'post',
                                data :
                                    {
                                        line_id    : line_id,
                                        colName  : colName,
                                        newValue : newValue,
                                        '_token' : '{{csrf_token()}}',
                                    },
                                success : function(resp)
                                {
                                    console.log('Update Value = ',resp['success']);
                                    /*if(resp['success'] === 'true'){
                                        swal({
                                            type: 'success',
                                            text: 'Record Saved !'
                                        });
                                    }*/
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);
                                },
                                error : function (e){
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });

                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });
                }
                else if(clcolName === 'SUPPLIER_NAME')
                {
                    $(this).html('<select style="width: 100px;" class="form-control input-sm sup"></select>');
                    $('.sup').select2({
                        minimumInputLength: 3,
                        dropdownAutoWidth: true,
                        ajax: {
                            url: "{{ url('scm_portal/getUpManufacturerName') }}",
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
                                            text: item.manufacturer_name,
                                            id: item.manufacturer_name
                                        }
                                    })
                                };
                            },
                            cache: false,
                            selectOnClose: true,
                        },
                    });

                    $(this).find('.sup').focus();
                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);
                    console.log(data.line_id);
                    line_id = data.line_id;


                    //send update select value to database
                    $(document).on('change', '.sup', function(){

                        let elem    = $(this);
                        newValue 	= $(this).val();
                        line_id	    = line_id;
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);

                        if(newValue != oldValue)
                        {
                            $.ajax({
                                url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method : 'post',
                                data :
                                    {
                                        line_id    : line_id,
                                        colName  : colName,
                                        newValue : newValue,
                                        '_token' : '{{csrf_token()}}',
                                    },
                                success : function(resp)
                                {
                                    console.log('Update Value = ',resp['success']);
                                    /*if(resp['success'] === 'true'){
                                        swal({
                                            type: 'success',
                                            text: 'Record Saved !'
                                        });
                                    }*/
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);
                                },
                                error : function (e){
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });

                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });
                }
                else if(clcolName === 'UOM')
                {
                    $(this).html('<select  class="form-control input-sm uom" style="width: 100px;" name="uom[]" id="uom" required>' +
                        '<option value="KG">KG</option>' +
                        '<option value="GM">GM</option>' +
                        '<option value="MG">MG</option>' +
                        '<option value="Million IU">Million IU</option>' +
                        '<option value="Billion CFU">Billion CFU</option>' +
                        '<option value="ML">Mole (ML)</option>' +
                        '<option value="L">L</option>' +
                        '<option value="ROLL">ROLL</option> ' +
                        '<option value="BOTTLE">Bottle</option>' +
                        '<option value="MLF">MFL</option>' +
                        '<option value="DOSE">DOSE</option>' +
                        '<option value="MT">MT</option>' +
                        '<option value="PTH">Per Thousand (Per TH)</option>' +
                        '<option value="Per HUN">Per Hundred (Per HUN)</option>' +
                        '<option value="Per LAC">Per Lac (Per LAC)</option>' +
                        '<option value="MM">Millimetre (MM)</option> ' +
                        '<option value="ML">ML</option>' +
                        '<option value="MIC">Micron (MIC)</option>' +
                        '<option value="Meter">Meter (M)</option>' +
                        '<option value="PC">Piece (PCS)</option>' +
                        '<option value="PACK">PACK</option>' +
                        '</select>');

                    $(this).find('.uom').focus();

                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();

                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);
                    console.log(data.line_id);
                    line_id = data.line_id;


                    //send update select value to database
                    $(document).on('change', '.uom', function(){
                        console.log("uom");
                        console.log(clcolName);

                        let elem    = $(this);
                        newValue 	= $(this).val();
                        line_id	    = data.line_id;
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);

                        if(newValue != oldValue)
                        {
                            $.ajax({
                                url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method : 'post',
                                data :
                                    {
                                        line_id    : line_id,
                                        colName  : colName,
                                        newValue : newValue,
                                        '_token' : '{{csrf_token()}}',
                                    },
                                success : function(resp)
                                {
                                    console.log('Update Value = ',resp['success']);
                                    /*if(resp['success'] === 'true'){
                                        swal({
                                            type: 'success',
                                            text: 'Record Saved !'
                                        });
                                    }*/
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);
                                },
                                error : function (e){
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });

                            $(elem).parent().addClass('editable');
                            $(elem).parent().html(newValue);
                            swal({
                                type: 'success',
                                text: 'Record Saved !'
                            });

                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });
                }
                else if(clcolName === 'CURRENCY')
                {
                    $(this).html('<select id="currency" name="currency[]" style="width: 80px;"  class="form-control m-bot15 currency">' +
                        '<option selected value="USD">$ USD</option>' +
                        '<option value="EUR" >€ EUR</option>' +
                        '<option value="GBP" >£ GBP</option>' +
                        '<option value="YEN" >¥ YEN</option>' +
                        '<option value="CAD">$ CAD</option>' +
                        '<option value="AUD">$ AUD</option>' +
                        '<option value="SEK">kr SEK</option>' +
                        '<option value="SIN">$ SIN</option> ' +
                        '</select>');

                    $(this).find('.currency').focus();

                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    console.log("currency");
                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);

                    //send update select value to database
                    $(document).on('change', '.currency', function(){


                        let elem    = $(this);
                         newValue 	= $(this).val();
                         line_id	    = data.line_id;
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);

                        if(newValue != oldValue)
                        {
                            $.ajax({
                                url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method : 'post',
                                data :
                                    {
                                        line_id    : line_id,
                                        colName  : colName,
                                        newValue : newValue,
                                        '_token' : '{{csrf_token()}}',
                                    },
                                success : function(resp)
                                {
                                    console.log('Update Value = ',resp['success']);
                                    /*if(resp['success'] === 'true'){
                                        swal({
                                            type: 'success',
                                            text: 'Record Saved !'
                                        });
                                    }*/
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);
                                },
                                error : function (e){
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });

                            $(elem).parent().addClass('editable');
                            $(elem).parent().html(newValue);
                            swal({
                                type: 'success',
                                text: 'Record Saved !'
                            });

                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });
                }
                else if(clcolName === 'FINISHED_PRODUCT')
                {
                    $(this).html('<select style="width: 100px;" class="form-control input-sm fp"></select>');
                    $('.fp').select2({
                        minimumInputLength: 3,
                        dropdownAutoWidth: true,
                        ajax: {
                            url: "{{ url('scm_portal/getUpFinishProductName') }}",
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
                                            text: item.product_name,
                                            id: item.product_name
                                        }
                                    })
                                };
                            },
                            cache: false,
                            selectOnClose: true,
                        },
                    });

                    $(this).find('.fp').focus();
                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);
                    console.log(data.line_id);
                    line_id = data.line_id;


                    //send update select value to database
                    $(document).on('change', '.fp', function(){

                        let elem    = $(this);
                        newValue 	= $(this).val();
                        line_id	    = line_id;
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');

                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);

                        if(newValue != oldValue)
                        {
                            $.ajax({
                                url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method : 'post',
                                data :
                                    {
                                        line_id    : line_id,
                                        colName  : colName,
                                        newValue : newValue,
                                        '_token' : '{{csrf_token()}}',
                                    },
                                success : function(resp)
                                {
                                    console.log('Update Value = ',resp['success']);
                                    /*if(resp['success'] === 'true'){
                                        swal({
                                            type: 'success',
                                            text: 'Record Saved !'
                                        });
                                    }*/
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);
                                },
                                error : function (e){
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });

                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });
                }
                else{

                    //All other parameter update

                    $(this).html('<input type="text" style="width:150px;" class="update" value="'+ oldValue +'" />');
                    $(this).find('.update').focus();

                    // line_id  = $(this).parent().find('td').html().trim();
                    clcolName = $('#blk_list thead tr th').eq($(this).index()).html().trim();
                    let data = table.row( $(this).parents('tr') ).data();
                    console.log(data);
                    line_id = data.line_id;

                    $(document).on('blur', '.update', function(){

                        let elem    = $(this);
                        let newValue 	= $(this).val();
                        colName	    = clcolName;

                        // var empId	= $(this).parent().attr('id');
                        // var colName	= $(this).parent().attr('name');
                        console.log("New Value = ",newValue);
                        console.log(elem,'-',line_id,'-',colName);
                        console.log(colName);

                        if(newValue != oldValue)
                        {
                            $.ajax({
                                url : '{{ url("scm_portal/frmApplicationUpdate") }}',
                                method : 'post',
                                data :
                                    {
                                        line_id    : line_id,
                                        colName  : colName,
                                        newValue : newValue,
                                        '_token' : '{{csrf_token()}}',
                                    },
                                success : function(respone)
                                {
                                    // console.log('Update Value = ',respone);
                                    $(elem).parent().addClass('editable');
                                    $(elem).parent().html(newValue);
                                    /*swal({
                                        type: 'success',
                                        text: 'Record Saved !'
                                    });*/
                                },
                                error : function (e){
                                    swal({
                                        type: 'error',
                                        text: 'Internal Server Error!!!'
                                    });
                                }
                            });



                        }
                        else
                        {
                            $(elem).parent().addClass('editable');
                            $(this).parent().html(newValue);
                        }
                    });

                }





            });






            // end inline editing

        });


        $('#blk_list tbody').on( 'click', '.edit-btn', function () {
            var data = table.row( $(this).parents('tr') ).data();
            console.log(data);

            var insetRowData = {data: data, "_token": "{{ csrf_token() }}"};

            $.ajax({
                type: "post",
                dataType: 'json',
                data: insetRowData,
                url: "{{ url('scm_portal/send_apply_rejected_data') }}",
                success: function (resp) {
                    if (resp.success) {
                        toastr.success(resp.success, '', {timeOut: 2000});
                    }else{
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function (e){
                    console.log("Error Sending data")
                }
            });


            //remove row from table
            let row = $(this).parents('tr');
            if ($(row).hasClass('child')) {
                table.row($(row).prev('tr')).remove().draw();
            } else {
                table.row($(this).parents('tr')).remove().draw();
            }

        } );



        function initializeSelect2Mat(selectElementObj) {
            selectElementObj.select2({
                placeholder: 'Select Material',
                minimumInputLength: 3,
                dropdownAutoWidth: true,
                width: 'auto',
                ajax: {
                    url: "{{ url('scm_portal/getMaterialName') }}",
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
                                    text: item.material_name,
                                    id: item.material_name
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

        $(".material").each(function () {

            initializeSelect2Mat($(this));
        });

        function initializeSelect2Manu(selectElementObj) {
            selectElementObj.select2({
                placeholder: 'Select Manufacturer',
                minimumInputLength: 3,
                dropdownAutoWidth: true,
                // width: 'auto',
                ajax: {
                    url: "{{ url('scm_portal/getManufacturerName') }}",
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
                                    text: item.manufacturer_name,
                                    id: item.manufacturer_name
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

        $(".manufacturer").each(function () {
            initializeSelect2Manu($(this));
        });

        function initializeSelect2Suppier(selectElementObj) {
            selectElementObj.select2({
                placeholder: 'Select Supplier',
                minimumInputLength: 3,
                dropdownAutoWidth: true,
                // width: 'auto',
                ajax: {
                    url: "{{ url('scm_portal/getSupplierName') }}",
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
                                    text: item.supplier_name,
                                    id: item.supplier_name
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

        $(".supplier").each(function () {
            initializeSelect2Suppier($(this));
        });

        function initializeSelect2CFP(selectElementObj) {
            selectElementObj.select2({
                placeholder: 'Select Product',
                minimumInputLength: 3,
                dropdownAutoWidth: true,
                // width: 'auto',
                ajax: {
                    url: "{{ url('scm_portal/getFinishProductName') }}",
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
                                    text: item.product_name,
                                    id: item.product_name
                                }
                            })
                        };
                    },
                    cache: true
                },
            });
        }

        $(".cfp").each(function () {
            initializeSelect2CFP($(this));
        });

        $('.uom').select2();
        $('.currency').select2();


        $(function() {
            $('#sbt_btn').on('click',function(e){
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ url('scm_portal/insScmApplicationFRM') }}",
                    data: $('#bl_frm').serialize(),
                    success: function(response) {

                        if(response.success){
                            toastr.success(response.success, '', {timeOut: 5000});
                            $('#myModal').modal('hide');
                        }else{
                            toastr.error(response.error, '', {timeOut: 5000});
                        }

                    },
                    error: function() {
                        toastr.error(response.error, '', {timeOut: 5000});

                    }
                });

                return false;

            });
        });


    </script>
@endsection
