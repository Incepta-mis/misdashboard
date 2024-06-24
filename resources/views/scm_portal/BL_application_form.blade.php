<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2019
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Block List Application Form')
@section('styles')
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
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

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Block List Application Form
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
                        <form action="{{ url('scm_portal/saveScmAppForm') }}" class="form-horizontal" role="form" id="form-id" onsubmit="return validateForm()" method="post">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
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
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="cmp"
                                                   class="col-md-6 col-sm-6 control-label"><b>Application ID:</b></label>
                                            <div class="col-md-4 col-sm-4">

                                                    {{-- <input type="text" style="text-align: center;" id="app_id" class="text-info" name="app_id" value="{{ $appId[0]->apid }}"> --}}
                                                    <input type="text" style="text-align: center;" id="app_id" class="text-info" name="app_id" value="{{ $appId }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="cmp"
                                                   class="col-md-3 col-sm-3 control-label"><b>Bl Type:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select name="bl_type" id="bl_type"
                                                        class="form-control input-sm bl_type">
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
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="panel-body table-responsive">

                                        <table id="myTable" class="table table-bordered table-hover order-list">
                                            <tr>
                                                <td class="text-center">Raw/Packing Materials</td>
                                                <td class="text-center">Manufacturer</td>
                                                <td class="text-center">Supplier</td>
                                                <td class="text-center">Qty</td>
                                                <td class="text-center">UOM</td>
                                                <td class="text-center">Currency</td>
                                                <td class="text-center">Air</td>
                                                <td class="text-center">Sea</td>
                                                <td class="text-center">Road</td>
{{--                                                <td class="text-center">BDT</td>--}}
                                                <td class="text-center">Finished Product</td>
                                                <td class="text-center">Quantity Of FP</td>
                                                <!--<td class="text-center">DML/Receipe Approved</td>
                                                <td class="text-center">Quantity Imported Last Year</td>
                                                <td class="text-center">Quantity Approved This Year</td>
                                                <td class="text-center">Total Quantity required this Year</td>-->
                                                <td style="text-align: center;">
                                                    <a id="addrow" type="button">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" class="days form-control tblrowId" value="1">
                                                    <select style="width: 150px; overflow: hidden;" class="form-control input-sm  material" name="material[]">

                                                    </select>
                                                </td>
                                                <td>
                                                    <select  style="width: 150px;" class="form-control input-sm  manufacturer" name="manufacturer[]">
                                                    </select>
                                                </td>
                                                <td>
                                                    <select  style="width: 150px;" class="form-control input-sm  supplier" name="supplier[]">
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01"  style="width: 80px;" class="form-control input-sm  qty" name="qty[]" />
                                                </td>
                                                <td>
{{--                                                    <input type="text" style="width: 50px;" class="form-control input-sm  uom" name="uom[]" />--}}
                                                    <select  class="form-control input-sm uom" style="width: 100px;" name="uom[]" id="uom" required>
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
                                                        <option value="BOU">BOU</option>
                                                        <option value="MLF">MFL</option>
                                                        <option value="DOSE">DOSE</option>
                                                        <option value="MILLION DOSE">MILLION DOSE</option>
                                                        <option value="MILLION LF ">MILLION LF</option>
                                                        <option value="MT">MT</option>
                                                        <option value="PTH">Per Thousand (Per TH)</option>
                                                        <option value="Per HUN">Per Hundred (Per HUN)</option>
                                                        <option value="Per LAC">Per Lac (Per LAC)</option>
                                                        <option value="MM">Millimetre (MM)</option>
                                                        <option value="ML">ML</option>
                                                        <option value="MIC">Micron (MIC)</option>
                                                        <option value="Meter">Meter (M)</option>
                                                        <option value="PC">Piece (PCS)</option>
                                                        <option value="PACK">PACK</option>
                                                    </select>
                                                </td>

                                                <td>

                                                    <select id="currency" name="currency[]" style="width: 80px;"  class="form-control m-bot15 currency">
                                                        <option selected value="USD">$ USD</option>
                                                        <option value="EUR" >€ EUR</option>
                                                        <option value="GBP" >£ GBP</option>
                                                        <option value="YEN" >¥ YEN</option>
                                                        <option value="CAD">$ CAD</option>
                                                        <option value="AUD">$ AUD</option>
                                                        <option value="SEK">kr SEK</option>
                                                        <option value="SIN">$ SIN</option>

                                                    </select>
                                                </td>
                                                <td>
                                                    <input  type="number"  step="0.001"  style="width: 80px;" class="form-control input-sm  air" name="air[]"/>

                                                </td>
                                                <td>
                                                    <input type="number"  step="0.001"  style="width: 80px;" class="form-control input-sm  sea" name="sea[]"/>

                                                </td>
                                                <td>
                                                    <input type="number" step="0.001"  style="width: 80px;" class="form-control input-sm  road" name="road[]"/>
                                                </td>

                                                <td>
                                                    <select style="width: 120px;" class="form-control input-sm  cfp" name="cfp[]"></select>
                                                </td>
                                                <td>
                                                    <input type="number"  style="width: 80px;" class="form-control input-sm  qty_fp" name="qty_fp[]">

{{--                                                    <input type="hidden" class="form-control input-sm  dml_approved" name="dml_approved[]">--}}
{{--                                                    <input type="hidden" class="form-control input-sm  qty_imp_last_yr" name="qty_imp_last_yr[]">--}}
{{--                                                    <input type="hidden" class="form-control input-sm  qty_appr_this_yr" name="qty_appr_this_yr[]">--}}
{{--                                                    <input type="hidden" class="form-control input-sm  Total_qty_req_this_yr" name="Total_qty_req_this_yr[]">--}}
                                                </td>

                                                <td><a class="deleteRow"></a></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center">

{{--                                            <input type="submit" class="btn btn-info" value="Save">--}}

                                            <button type="submit" class="btn btn-info">
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Save
                                            </button>
                                        </div>
                                    </div>

                                </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">

        $(document).ready(function () {


            function initializeSelect2Mat(selectElementObj) {
                selectElementObj.select2({
                    placeholder: 'Select Material',
                    minimumInputLength: 3,
                    dropdownAutoWidth: true,
                    // width: 'auto',
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

            var counter = 2;
            $(document).on("click", "#addrow", function () {


                // $('table.order-list > tbody  > tr').not(":first").each(function (i, el) {   //Not First Row
                $('table.order-list > tbody  > tr').last().each(function (i, el) {   //get last row

                    var material = $(this).find('.material :selected').eq(0).text();
                    var manufacturer = $(this).find('.manufacturer :selected').eq(0).text();
                    var supplier = $(this).find('.supplier :selected').eq(0).text();
                    var qty = $(this).find('.qty').val();
                    var uom = $(this).find('.uom :selected').eq(0).val();

                    console.log(i);
                    console.log(uom);

                    var cfp = $(this).find('.cfp :selected').eq(0).text();

                    var air = $(this).find('.air').val();
                    var sea = $(this).find('.sea').val();
                    var road = $(this).find('.road').val();


                    if (material === ''){
                        swal({
                            type: 'error',
                            text: 'Please Enter Material Name'
                        });
                        return false;
                    }else if( manufacturer === ''){
                        swal({
                            type: 'error',
                            text: 'Please Enter Manufacturer Name'
                        });
                        return false;
                    }else if(  supplier === ''){
                        swal({
                            type: 'error',
                            text: 'Please Enter Supplier Name'
                        });
                        return false;
                    }else if(  qty === ''){
                        swal({
                            type: 'error',
                            text: 'Please Enter Quantity'
                        });
                        return false;
                    }else if( uom === ''){
                        swal({
                            type: 'error',
                            text: 'Please Enter unit of measurement'
                        });
                        return false;
                    }else if(  cfp === ''){
                        swal({
                            type: 'error',
                            text: 'Please Enter Finished Product'
                        });
                        return false;
                    }else if( air === '' && road === '' && sea === ''){
                        swal({
                            type: 'error',
                            text: 'Please Enter At least one Air, Sea or Road Value!'
                        });
                        return false;
                    }
                    else{
                        if (counter < 8) {
                            var newRow = $("<tr>");
                            var cols = "";
                            cols += '<td> <input type="hidden" class="tblrowId" autocomplete="off" value="' + counter + '"> ' +
                                '<select class="form-control input-xs  material"  name="material[]"></select> </td>';
                            cols += '<td> <select class="form-control input-xs  manufacturer"  name="manufacturer[]"></select> </td>';
                            cols += '<td> <select class="form-control input-xs  supplier"  name="supplier[]"></select> </td>';
                            cols += '<td><input type="number" step="0.01" style="width: 80px;" class="form-control input-sm  qty" name="qty[]" /></td>';
                            cols += '<td> <select  class="form-control m-bot15 uom" style="width: 100px;" name="uom[]" id="uom" required>' +
                                '<option value="">Select</option>' +
                                '<option value="KG">KG</option>' +
                                '<option value="GM">GM</option>' +
                                '<option value="MG">MG</option>' +
                                '<option value="Million IU">Million IU</option>' +
                                '<option value="Billion CFU">Billion CFU</option>' +
                                '<option value="ML">Mole (ML)</option>' +
                                '<option value="L">L</option>' +
                                '<option value="ROLL">ROLL</option>' +
                                '<option value="BOTTLE">Bottle</option>' +
                                '<option value="MLF">MFL</option>' +
                                '<option value="DOSE">DOSE</option>' +
                                '<option value="MILLION LF">MILLION LF</option>' +
                                '<option value="MT">MT</option>' +
                                '<option value="PTH">Per Thousand (Per TH)</option>' +
                                '<option value="Per HUN">Per Hundred (Per HUN)</option>' +
                                '<option value="Per LAC">Per Lac (Per LAC)</option>' +
                                '<option value="MM">Millimetre (MM)</option>' +
                                '<option value="ML">ML</option>' +
                                '<option value="MIC">Micron (MIC)</option>' +
                                '<option value="Meter">Meter (M)</option>' +
                                '<option value="PC">Piece (PCS)</option>' +
                                '<option value="PACK">PACK</option>' +
                                '</td>';
                            cols += '<td><select id="currency" style="width: 80px;" name="currency[]" class="form-control m-bot15 currency">' +
                                ' <option selected value="USD">$ USD</option>' +
                                '<option value="EUR">€ EUR</option>' +
                                '<option value="GBP">£ GBP</option>' +
                                '<option value="JPY">¥ JPY</option>' +
                                '<option value="CAD">$ CAD</option>' +
                                '<option value="AUD">$ AUD</option></td>';

                            cols += '<td><input type="number" step="0.001"  style="width: 80px;" class="form-control input-sm  air" name="air[]"/></td>';
                            cols += '<td><input type="number" step="0.001" style="width: 80px;" class="form-control input-sm  sea" name="sea[]"/></td>';
                            cols += '<td><input type="number" step="0.001" style="width: 80px;" class="form-control input-sm  road" name="road[]"/></td>';
                            cols += '<td><select style="width: 120px;" class="form-control input-sm  cfp" name="cfp[]"></select></td>';
                            cols += '<td><input type="number"  style="width: 80px;" class="form-control input-sm  qty_fp" name="qty_fp[]"></td>';
                            cols += '<td><span class="ibtnDel btn btn-danger btn-sm "><i class="fa fa-trash-o"></i> </span> </td>';
                            cols += '</tr>';
                            newRow.append(cols);
                            $("table.order-list").append(newRow);
                        }
                        else {
                            swal({
                                type: 'error',
                                text: 'Maximum 5 Entry!'
                            });
                            return false;
                        }

                        counter++;

                        $(".material").each(function () {
                            initializeSelect2Mat($(this));
                        });

                        $(".manufacturer").each(function () {
                            initializeSelect2Manu($(this));
                        });

                        $(".supplier").each(function () {
                            initializeSelect2Suppier($(this));
                        });

                        $(".cfp").each(function () {
                            initializeSelect2CFP($(this));
                        });

                        $('.uom').select2();
                        $('.currency').select2();
                    }

                });

            });

            $("table.order-list").on("click", ".ibtnDel", function (event) {


                $(this).closest("tr").remove();
                counter -= 1;
                var rowId = $(this).closest("tr").find('.tblrowId').val();
                console.log("table row id", rowId);

                $("table.expenditure-list>tbody>tr").each(function (i, v) {
                    var expRow = $(this).closest("tr").find('.tblrowId').val();
                    if (rowId === expRow) {
                        $(this).closest("tr").remove();
                    }
                });

            });

            $("table.order-list").on("change", ".air", function (event) {
                var airPrice = $(this).closest("tr").find('.air').val();
                if(airPrice){
                    $(this).closest("tr").find('.sea').prop('readOnly', true);
                    $(this).closest("tr").find('.road').prop('readOnly', true);
                }else{
                    $(this).closest("tr").find('.sea').prop('readOnly', false);
                    $(this).closest("tr").find('.road').prop('readOnly', false);
                }
                console.log("Air Price = ",airPrice);
            });

            $("table.order-list").on("change", ".sea", function (event) {
                var seaPrice = $(this).closest("tr").find('.sea').val();
                if(seaPrice){
                    $(this).closest("tr").find('.air').prop('readOnly', true);
                    $(this).closest("tr").find('.road').prop('readOnly', true);
                }else{
                    $(this).closest("tr").find('.air').prop('readOnly', false);
                    $(this).closest("tr").find('.road').prop('readOnly', false);
                }
                console.log("Sea Price = ",seaPrice);
            });

            $("table.order-list").on("change", ".road", function (event) {
                var roadPrice = $(this).closest("tr").find('.road').val();
                if(roadPrice){
                    $(this).closest("tr").find('.air').prop('readOnly', true);
                    $(this).closest("tr").find('.sea').prop('readOnly', true);
                }else{
                    $(this).closest("tr").find('.air').prop('readOnly', false);
                    $(this).closest("tr").find('.sea').prop('readOnly', false);
                }
                console.log("Road Price = ",roadPrice);
            });

        });

        $(document).on('click', 'form button[type=submit]', function(e) {

                $('table.order-list > tbody  > tr').last().each(function (i, el) {   //get last row

                var material = $(this).find('.material :selected').eq(0).text();
                var manufacturer = $(this).find('.manufacturer :selected').eq(0).text();
                var supplier = $(this).find('.supplier :selected').eq(0).text();
                var qty = $(this).find('.qty').val();
                var uom = $(this).find('.uom :selected').eq(0).val();
                var cfp = $(this).find('.cfp :selected').eq(0).text();
                var air = $(this).find('.air').val();
                var sea = $(this).find('.sea').val();
                var road = $(this).find('.road').val();


                if (material === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Material Name'
                    });
                    e.preventDefault();
                    return false;

                }else if( manufacturer === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Manufacturer Name'
                    });
                    e.preventDefault();
                    return false;
                }else if(  supplier === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Supplier Name'
                    });
                    e.preventDefault();
                    return false;
                }else if(  qty === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Quantity'
                    });
                    e.preventDefault();
                    return false;
                }else if( uom === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter unit of measurement'
                    });
                    e.preventDefault();
                    return false;
                }else if(  cfp === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Finished Product'
                    });
                    e.preventDefault();
                    return false;
                }else if( air === '' && road === '' && sea === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter At least one Air, Sea or Road Value!'
                    });
                    e.preventDefault();
                    return false;
                }else {
                    return true;
                }
            });

         });

    </script>
@endsection
