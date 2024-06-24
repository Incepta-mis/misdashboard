<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2019
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Packaging Material Requisition Form')
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

        select + .select2-container {
            width: 100% !important;
        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Packaging Material Machine Trial
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
                        <form action="{{ url('scm_portal/saveScmTrialReq') }}" class="form-horizontal"
                              enctype="multipart/form-data" role="form" id="form-id" onsubmit="return validateForm()" method="post">
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
                                        <label for="ref_no" class="col-md-4 col-sm-4 control-label"><b>Trial Ref. No:</b></label>
                                        <div class="col-sm-6 col-md-6">
                                            <input type="text" readonly class="form-control input-sm" name="ref_no" value="{{ $ref_no[0]->reference }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="rnd_email"
                                               class="col-md-3 col-sm-3 control-label"><b>R&D/QC Concern:</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="rnd_email" name="rnd_email[]" multiple="multiple" class="form-control input-sm rnd_email">
                                                @foreach($rnd_email as $r)
                                                    <option value="{{$r->emp_email}}">{{$r->emp_email}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="cmp" class="col-md-4 col-sm-4 control-label"><b>Add File:</b></label>
                                        <div class="col-sm-6 col-md-6">
                                            <div style="position:relative;">
                                                <a class='btn btn-primary btn-sm' href='javascript:;'>
                                                    Choose File...
                                                    <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter:
                                                     alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
                                                     opacity:0;background-color:transparent;color:transparent;'
                                                           id="file_source" name="file_source" size="40"
                                                           onchange='$("#upload-file-info").html($(this).val());'>
                                                </a>
                                                &nbsp;
                                                <span class='label label-info' id="upload-file-info"></span>
                                                <p class="help-block">e.g: PACK_706_130721.pdf (max: 3mb)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="recommend_emp_id"
                                               class="col-md-3 col-sm-3 control-label"><b>Recommended By:</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select id="recommend_emp_id" name="recommend_emp_id" class="form-control input-sm recommend_emp_id">
                                                <option value="">Select Recommended </option>
                                                @foreach($rcm_email as $rc)
                                                    <option value="{{$rc->emp_id}}">{{$rc->emp_name}} - {{$rc->emp_email}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="recommend_emp_id"
                                        class="col-md-3 col-sm-3 control-label"><b>Test Request For:</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select name="test_request_for" id="test_request_for" class="form-control input-sm  test_request_for"  style="border-radius: 4px">
                                                <option value="">Select Test Request For</option>
                                                <option value="dummy_check">Dummy (Dimension) Check</option>
                                                <option value="analysis">Analysis as per COA</option>
                                                <option value="text_check">Text Check</option>
                                                <option value="trial">Trial</option>
                                                <option value="stability">Stability</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
<!--                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">

                                          <label for="ref_no" class="col-md-3 col-sm-3 control-label"><b>Packaging Material Ref. No. :</b></label>
                                            <div class="col-sm-9 col-md-9">
                                                <input type="text"  class="form-control input-sm packaging_material_rtef_no" name="packaging_material_rtef_no"
                                                       id='packaging_material_rtef_no' value="{{ $ref_no[0]->reference }}"  style="border-radius: 4px">
                                            </div>
                                    </div>
                                </div>-->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="recommend_emp_id"
                                               class="col-md-3 col-sm-3 control-label"><b>Change Control Form(CCF) Raised:</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <div class="form-check">

                                                <input class="form-check-input change_control_form" type="radio" name="change_control_form" id="change_control_form" value="yes">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>

                                                <input class="form-check-input change_control_form" type="radio" name="change_control_form" id="change_control_form" value="no">
                                                <label class="form-check-label" for="inlineRadio2">No</label>

                                                <input class="form-check-input change_control_form" type="radio" name="change_control_form" id="change_control_form" value="y/n" >
                                                <label class="form-check-label" for="inlineRadio3">N/A</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="mat_type"
                                               class="col-md-3 col-sm-3 control-label"><b>Material Type:</b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <div class="form-check">

                                                <input class="form-check-input mat_type" type="radio" name="mat_type"
                                                       id="mat_type" value="new">
                                                <label class="form-check-label" for="inlineRadio1">New</label>

                                                <input class="form-check-input mat_type" type="radio" name="mat_type"
                                                       id="mat_type" value="alt">
                                                <label class="form-check-label" for="inlineRadio2">Alternative</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row ccf_ref_no_class" style="display: none">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="ref_no" class="col-md-6 col-sm-6 control-label"><b>CCF Ref. No.(If raiesed):</b></label>
                                        <div class="col-sm-6 col-md-6">
                                            <input type="text"  class="form-control input-sm ccf_ref_no" name="ccf_ref_no"
                                                   id='ccf_ref_no' value="" placeholder="Enter CCF Ref. No.">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 ccf_status_class" style="display: none">
                                    <div class="form-group">
                                        <label for="recommend_emp_id"
                                               class="col-md-3 col-sm-3 control-label"><b>CCF Status:</b></label>
                                        <div class="form-check">
                                            <input class="form-check-input ccf_status" type="radio" value="approved" name="ccf_status" id="ccf_status">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Approved
                                            </label>
                                            <input class="form-check-input ccf_status" type="radio" value="not_approved" name="ccf_status" id="ccf_status" >
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Not Approved
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >

                                <div class="col-md-11 col-sm-11">
                                    <div class="form-group">
                                        <label for="recommend_emp_id"
                                               class="col-md-8 col-sm-8 control-label"><b>Attached Documents(Product Proposal/Product Brief/Annexure/COA/Other's):</b></label>
                                        <div class="col-md-3 col-sm-3">
                                            <input class="form-check-input attached_document" type="radio" name="attached_document" id="attached_document" value="attached">
                                            <label class="form-check-label" for="inlineRadio1">Attached</label>

                                            <input class="form-check-input attached_document" type="radio" name="attached_document" id="attached_document" value="not_attached">
                                            <label class="form-check-label" for="inlineRadio2">Not Attached</label>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="panel-body table-responsive">
                                    <table id="myTable" class="table table-bordered table-hover order-list">
                                        <tr>
                                            <td class="text-center">Product Name</td>
                                            <td class="text-center">Item Description</td>
                                            <td class="text-center" style="width: 100px;">Qty</td>
                                            <td class="text-center">UOM</td>
                                            <td class="text-center">Supplier</td>
                                            <td class="text-center">Concern Product</td>
                                            <td class="text-center">SCM Remarks</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="form-control input-sm  cfp" name="cfp"></select>
                                            </td>

                                            <td>
                                                <select  class="form-control input-sm  item_desc" name="item_desc"></select>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01"  class="form-control input-sm  qty" name="qty" />
                                            </td>
                                            <td>
                                                <select  class="form-control input-sm uom"  name="uom" id="uom" required>
                                                    <option value="">Select</option>
                                                    <option value="KG">KG</option>
                                                    <option value="PC">PC</option>
                                                    <option value="PACK">PACK</option>
                                                    <option value="TUBE">TUBE</option>
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
                                                    <option value="ML">ML</option>
                                                    <option value="MIC">Micron (MIC)</option>
                                                    <option value="Meter">Meter (M)</option>

                                                </select>
                                            </td>
                                            <td>
                                                <select  style="width: 150px;" class="form-control input-sm  supplier" name="supplier"></select>
                                            </td>


                                            <td>
                                                <select class="form-control input-sm  concern_product" id="concern_product" name="concern_product">
                                                    {{--                                                    <option value="">Select Product</option>--}}
                                                    <option value="For Trial With Relevant Product">For Trial With Relevant Product</option>

                                                </select>
                                            </td>
                                            <td>
                                                <input  type="text"  class="form-control input-sm  scm_remarks" name="scm_remarks"/>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
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
        var changeControlFormVal;

        $(document).ready(function () {

            $("input[name='change_control_form']").change(function(){
                //let changeControlForm = $('.change_control_form').val();
                changeControlFormVal = $("input[name='change_control_form']:checked").val();
                console.log(changeControlFormVal);
                if(changeControlFormVal=='yes'){
                    $(".ccf_status_class").css("display", "block");
                    $(".ccf_ref_no_class").css("display", "block");
                }else if(changeControlFormVal=='no'){
                    $(".ccf_status_class").css("display", "none");
                    $(".ccf_ref_no_class").css("display", "none");
                }else if(changeControlFormVal=='y/n'){
                    $(".ccf_status_class").css("display", "none");
                    $(".ccf_ref_no_class").css("display", "none");
                }
            });


            $('.cmp').select2();
            $('.recommend_emp_id').select2();

            $('.rnd_email').select2({
                placeholder: " Select an Email",
                allowClear: true,
                // selectOnClose: true,
                tags: true,
                createTag: function (params) {
                    // Don't offset to create a tag if there is no @ symbol
                    if (params.term.indexOf('@') === -1) {
                        // Return null to disable tag creation
                        return null;
                    }

                    return {
                        id: params.term,
                        text: params.term
                    }
                },
                //Allow manually entered text in drop down.
                createSearchChoice: function (term, data) {
                    if ($(data).filter(function () {
                        return this.text.localeCompare(term) === 0;
                    }).length === 0) {
                        return { id: term, text: term };
                    }
                },
            });

            function initializeSelect2CFP(selectElementObj) {
                selectElementObj.select2({
                    placeholder: 'Select Product',
                    allowClear: true,
                    minimumInputLength: 3,
                    dropdownAutoWidth: true,
                    width: 'auto',
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

            $('.cfp').on('change', function() {
                var data = $(".cfp option:selected").text();
                console.log("concern_product",data);
                console.log("concern_product",data.length);

                if(data.length === 0){

                    $('.concern_product').children('option:not(:first)').remove();


                    // $('.concern_product').val(null).trigger('change');
                }else{
                    var $newOption = $("<option selected='selected'></option>").val("For Trial With "+data).text("For Trial With "+data);
                    $(".concern_product").append($newOption).trigger('change');
                }

            });

            $(".concern_product").select2({
                allowClear: true,
                dropdownAutoWidth: true,
                width: 'auto',
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

            function initializeSelect2Item(selectElementObj) {
                selectElementObj.select2({
                    placeholder: 'Select Item',
                    allowClear: true,
                    minimumInputLength: 3,
                    dropdownAutoWidth: true,
                    width: 'auto',
                    ajax: {
                        url: "{{ url('scm_portal/getItemDescription') }}",
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
                                        text: item.item_desc,
                                        id: item.item_desc
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
            $(".item_desc").each(function () {
                initializeSelect2Item($(this));
            });

            function initializeSelect2Supplier(selectElementObj) {
                selectElementObj.select2({
                    placeholder: 'Select Supplier',
                    minimumInputLength: 3,
                    dropdownAutoWidth: true,
                    allowClear: true,
                    // width: 'auto',
                    ajax: {
                        url: "{{ url('scm_portal/getLocalSupplierName') }}",
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
                initializeSelect2Supplier($(this));
            });

            $('.uom').select2({
                dropdownAutoWidth: true,
                width: 'auto',}
            );

        });

        $(document).on('click', 'form button[type=submit]', function(e) {

            let company = $('.cmp').val();
            if(  company === ''){
                swal({
                    type: 'error',
                    text: 'Please Select Company'
                });
                e.preventDefault();
                return false;
            }

            if (jQuery('.rnd_email').val() == null) {
                swal({
                    type: 'error',
                    text: 'Please Select R&D Concern'
                });
                e.preventDefault();
                return false;
            }

            let recommendEmpId = $('.recommend_emp_id').val();
            if(  recommendEmpId === ''){
                swal({
                    type: 'error',
                    text: 'Please Select Recommended'
                });
                e.preventDefault();
                return false;
            }


            let testReqFor = $('.test_request_for').val();
            console.log(testReqFor);
            if(  testReqFor === ''){
                swal({
                    type: 'error',
                    text: 'Please Select Test Request For'
                });
                e.preventDefault();
                return false;
            }else{
                console.log("not null");
            }

            // var packagingMaterialRtefNo = $('.packaging_material_rtef_no').val();
            // console.log(packagingMaterialRtefNo);
            // if(  packagingMaterialRtefNo == null){
            //     swal({
            //         type: 'error',
            //         text: 'Please Select Packaging Material RTEF No.'
            //     });
            //     e.preventDefault();
            //     return false;
            // }

            var changeControlForm = $("input[name='change_control_form']:checked").val();
            if(  changeControlForm == null){
                swal({
                    type: 'error',
                    text: 'Please Select Change Control Form'
                });
                e.preventDefault();
                return false;
            }

            var mat_type = $("input[name='mat_type']:checked").val();
            if(  mat_type == null){
                swal({
                    type: 'error',
                    text: 'Please Select Material Type'
                });
                e.preventDefault();
                return false;
            }
            // let ccfRefNo = $('.ccf_ref_no').val();
            // if(  ccfRefNo === ''){
            //     swal({
            //         type: 'error',
            //         text: 'Please Put CCF Ref. No.'
            //     });
            //     e.preventDefault();
            //     return false;
            // }

            var attached_document = $("input[name='attached_document']:checked").val();
            if(  attached_document == null){
                swal({
                    type: 'error',
                    text: 'Please Check Attached Document'
                });
                e.preventDefault();
                return false;
            }

            //ccf_status
            console.log("saylaaaaaaaaaaaaaaa");
            console.log(changeControlFormVal);
            if(changeControlFormVal=='yes'){
                console.log("chnage control form val yes")
                var ccfStatus = $("input[name='ccf_status']:checked").val();
                console.log("ccf status");
                console.log(typeof (ccfStatus));
                if(  ccfStatus == null){
                    swal({
                        type: 'error',
                        text: 'Please Select CCF Status'
                    });
                    e.preventDefault();
                    return false;
                }


                let ccfRefNo = $('.ccf_ref_no').val();
                if(  ccfRefNo === ''){
                    swal({
                        type: 'error',
                        text: 'Please Put CCF Ref. No.'
                    });
                    e.preventDefault();
                    return false;
                }

            }


            // if( document.getElementById("file_source").files.length == 0 ){
            //     swal({
            //         type: 'error',
            //         text: 'Please Select File'
            //     });
            //     e.preventDefault();
            //     return false;
            // }

            $('table.order-list > tbody  > tr').last().each(function (i, el) {   //get last row


                var supplier = $(this).find('.supplier :selected').eq(0).text();
                var qty = $(this).find('.qty').val();
                var scm_remarks = $(this).find('.scm_remarks').val();
                var uom = $(this).find('.uom :selected').eq(0).val();
                var item_desc = $(this).find('.item_desc :selected').eq(0).text();


                if( item_desc === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Item Description'
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
                }
                else if(  supplier === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Supplier Name'
                    });
                    e.preventDefault();
                    return false;
                }else if(  scm_remarks === ''){
                    swal({
                        type: 'error',
                        text: 'Please Enter Remarks'
                    });
                    e.preventDefault();
                    return false;
                }
                else {
                    return true;
                }
            });




        });

    </script>
@endsection
