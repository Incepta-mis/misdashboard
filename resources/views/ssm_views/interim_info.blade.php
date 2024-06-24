@extends('_layout_shared._master')
@section('title','Interim Stability Data')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        . {
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

        label {
            font-size: 12px;
        }

        input, select {
            color: #000000;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 32px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }

        .field-h {
            font-size: 11px;
            resize: both;
            /*background: #ffd73e33;*/
            border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg' %3E %3Cstyle%3Epath%7Banimation:stroke 5s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='red' /%3E%3Cstop offset='25%25' stop-color='red' /%3E%3Cstop offset='50%25' stop-color='red' /%3E%3Cstop offset='100%25' stop-color='red' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
        }

        .input-xs {
            height: 23px;
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 1px;
        }

        .input-group-xs > .form-control,
        .input-group-xs > .input-group-addon,
        .input-group-xs > .input-group-btn > .btn {
            height: 23px;
            padding: 2px 5px;
            font-size: 12px;
            /*line-height: 1.5;*/
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove orangered !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: orangered;
        }

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #337AC7;
        }

        .cls-req{
            color: red;
            font-weight: bold;
        }

    </style>
@endsection
@section('right-content')
    <div class="row" id="top_ssmrv">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Interim Stabilty Data
                    </label>
                </header>

                <form action="" id="interim_info_data">
                    <div class="panel-body" style="margin-top: 10px;">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group select2-bootstrap-prepend ">
                                        <select type="text"  id="productlist" class="form-control">
                                            {{--                                            <option value="">SELECT PRODUCT</option>--}}
                                            {{--                                            @foreach($productinfo as $pi)--}}
                                            {{--                                                <option value="{{$pi->pname}}|{{$pi->batch_number}}|{{$pi->chamber_stor_loc}}">{{$pi->pname}} {{$pi->batch_number}} {{$pi->chamber_stor_loc}}</option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                        <span class="input-group-btn">
                                             <button class="btn btn-primary" id="btn_display" type="button">Display!</button>
                                         </span>
                                    </div>
                                </div>
                            </div><!-- /input-group -->
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Sample Data</legend>
                                    <div class="col-md-12">
                                        <p class="cls-req">*(Fields are required)</p>
                                        <div class="col-md-2">
                                            <!--                                            <div class="form-group">
                                                                                            <label for="email"><b>Product Name:</b><span  class="cls-req">*</span></label>
                                                                                                    <select name="pname" id="pname" class="form-control input-xs">
                                                                                                    <option value="">Select Product Name</option>

                                                                                                    </select>
                                                                                        </div>-->
                                            <div class="form-group">
                                                <label for="email"><b>Product Name:</b><span  class="cls-req">*</span></label>
                                                {{--                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"--}}
                                                {{--                                                       class="form-control input-xs" id="accept_criteria"--}}
                                                {{--                                                       placeholder=""--}
                                                {{--                                                       name="accept_criteria">--}}
                                                <select style="width: 150px;  overflow: hidden;" oninput="this.value = this.value.toUpperCase()" id="pname" class="form-control input-sm  pname" name="pname"></select>
                                            </div>

                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Batch Number:</b><span  class="cls-req">*</span></label>
                                                <select name="batch_number" id="batch_number" class="form-control input-xs">
                                                    <option value="">Select Batch Number</option>
                                                    @foreach($batch_number as $b)
                                                        <option value="{{$b->batch_number}}">{{$b->batch_number}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Rda Ref No:</b><span  class="cls-req">*</span></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="rda_ref_no" placeholder=""
                                                       name="rda_ref_no">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Chamber Storage Condition"><b>Storage
                                                        Conditions:</b><span  class="cls-req">*</span></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="stor_cond" placeholder=""
                                                       name="stor_cond">
                                                {{--                                <input type="text" class="" id="storagecond" placeholder="Enter Storage Conditions" name="storagecond">--}}
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Assay"><b>Assay:</b><span  class="cls-req">*</span></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="assay" placeholder=""
                                                       name="assay">
                                                {{--                                <input type="text" class="" id="ASSAY_METHOD" placeholder="Enter Assay Method" name="ASSAY_METHOD">--}}
                                            </div>
                                        </div>

                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label for="email"><b>Assay Methods:</b></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="assay_method" placeholder=""
                                                       name="assay_method">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Dissolution:</b></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="disso"
                                                       placeholder="" name="disso">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dissolutionmethod"><b>Dissolution Method:</b></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="disso_method"
                                                       placeholder="" name="disso_method" >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>pH:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="ph"
                                                       placeholder="" name="ph">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>DT:</b></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="dt"
                                                       placeholder="" name="dt" >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Description:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="description"
                                                       placeholder="" name="description">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Impurities:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="impurities"
                                                       placeholder="" name="impurities">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Impurities Method:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="impurity_method"
                                                       placeholder="" name="impurity_method">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Option1:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="option1"
                                                       placeholder="" name="option1">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Option2:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="option2"
                                                       placeholder="" name="option2">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Remarks:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="remarks"
                                                       placeholder="" name="remarks">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Analyst Name:</b></label>
                                                <input type="text"onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="analyst_name"
                                                       placeholder="" name="analyst_name">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Rerport Date"><b>Report Date:</b><span  class="cls-req"></span></label>
                                                <input type="text" class="form-control input-xs" id="report_date"
                                                       readonly=""
                                                       placeholder="Report Date" name="report_date">
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2 text-center" style="padding-top: 20px;">
                <button type="button" id="btn_save" class="btn btn-primary btn-sm">
                    <i class="fa fa-check"></i> <b>SAVE</b></button>

                <button type="button" id="btn_update" class="btn btn-primary btn-sm">
                    <i class="fa fa-check"></i> <b>UPDATE</b></button>

                <button type="button" id="btn_refresh" class="btn btn-primary btn-sm">
                    <i class="fa fa-check"></i> <b>REFRESH</b></button>
            </div>
        </div>
    </div>
    </form>
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
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}

    <script>

        var old_pname;
        var old_batch_number;
        var old_rda_ref_no;
        var old_stor_cond;
        var old_assay;

        var totalminutes = 0;
        $.fn.select2.defaults.set("theme", "bootstrap");
        var date = new Date();

        $('#report_date').datetimepicker({
            defaultDate: date,
            format: 'DD-MMM-YY',
            ignoreReadonly: true

        });

        $('#productlist').select2({
            width: null
        });

        $(document).ready(function () {
            $('#btn_update').prop('disabled', true);
            function objectifyForm(formArray) {
                //serialize data function
                var returnArray = {};
                for (var i = 0; i < formArray.length; i++) {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
                return returnArray;
            }
            $('input[type="number"]').on('keyup', function (event) {
                var value = event.target.value;
                var regex = new RegExp(/^\+?[0-9(),.-]+$/);
                if (value.match(regex)) {
                    event.target.value = value;
                } else {
                    event.target.value = '';
                }
            });

            /**
             * Save Interim Data
             **/
            $('#btn_save').on('click', function () {

                var $val;
                $.each($(".pname option:selected"), function() {
                    $val = $(this).text();
                });

                if ($val && $('#batch_number').val() && $('#rda_ref_no').val() && $('#stor_cond').val()&& $('#assay').val()) {
                    // if (chcecktestparam())
                    // {
                    var formdata = $('#interim_info_data').serializeArray();
                    var formdat = objectifyForm(formdata);
                    $.ajax({
                        type: 'post',
                        url: '{{url('ssm/is_saverecord')}}',
                        data: {
                            fdata: formdat,
                            pname:$val,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            if (response.status === 'SAVED') {
                                var optionlist = '<option value="">SELECT PRODUCT</option>';
                                for (var i = 0; i < response.xyz.length; i++) {

                                    optionlist += '<option value="' + response.xyz[i].pname + '|' + response.xyz[i].batch_number + '</option>';
                                }
                                $('#productlist').empty().append(optionlist);
                                toastr.info('SAVED SUCCESSULLY');
                                $('#interim_info_data')[0].reset();
                                $(".pname").select2("val", "0");
                            }else if (response.status === 'EXISTS'){
                                toastr.error('ALREADY EXISTS');
                            }

                        },
                        error: function (error) {
                            toastr.info('UNABLE TO SAVE');
                        }
                    })
                    // }
                } else {
                    toastr.error('PRODUCT NAME , BATCH NUMBNER, RDA REFERENCE VALUE, STORAGE CONDITIONS, Assay Is Required');
                }
            });

            /**
             * Display Interim Data
             **/
            $('#btn_display').on('click', function () {
                var sample = $('#productlist :selected').text().trim();
                $.ajax({
                    type: 'post',
                    url: '{{url('ssm/int_retrieve_data')}}',
                    data: {
                        fdata: sample,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        if (response[0]) {
                            old_pname = response[0]['pname'];
                            old_batch_number = response[0]['batch_number'];
                            old_rda_ref_no = response[0]['rda_ref_no'];
                            old_stor_cond = response[0]['stor_cond'];
                            old_assay = response[0]['assay'];

                            $('#interim_info_data').autofill(response[0]);
                            $('#btn_update').prop('disabled', false);
                            $('#btn_save').prop('disabled', true);

                            var $newOption = $("<option selected='selected'></option>").val(response[0]['pname']).text(response[0]['pname']);
                            $("#pname").append($newOption).trigger('change');
                        }

                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                    }
                })
            });

            function chcecktestparam() {
                var $val;
                $.each($(".pname option:selected"), function() {
                    $val = $(this).text();
                });
                var isvalid = true;
                if ($val && $('#batch_number').val() && $('#rda_ref_no').val()) {
                    toastr.error('"Machine Assign To" CANNOT BE EMPTY');
                    isvalid = false;
                }
                return isvalid;
            }

            /**
             * Update Data
             **/
            $('#btn_update').on('click', function () {
                var $val;
                $.each($(".pname option:selected"), function() {
                    $val = $(this).text();
                });

                if ($val && $('#batch_number').val() && $('#rda_ref_no').val() && $('#stor_cond').val()&& $('#assay').val()){

                    var formdata = $('#interim_info_data').serializeArray();
                    var postdata = objectifyForm(formdata);

                    $.ajax({
                        type: 'post',
                        url: '{{url('ssm/int_update_data')}}',
                        data: {
                            old_pname:old_pname,
                            old_batch_number:old_batch_number,
                            old_rda_ref_no:old_rda_ref_no,
                            old_stor_cond:old_stor_cond,
                            old_assay:old_assay,

                            fdata: postdata,
                            pname: $val,
                            batch_number: $('#batch_number').val(),
                            rda_ref_no: $('#rda_ref_no').val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            //console.log(response);
                            if (response.status === 'SUCCESSFULLY') {
                                toastr.info('UPDATED SUCCESSULLY');
                                $('#interim_info_data')[0].reset();
                                $('#btn_update').prop('disabled', true);
                                $('#btn_save').prop('disabled', false);
                                $("#productlist").val('').trigger('change')
                                $(".pname").select2("val", "0");
                            } else if (response.status === 'EXISTS') {
                                toastr.error('ALREADY EXISTS');
                            }
                        },
                        error: function (error) {
                            toastr.info('UNABLE TO UPDATE');
                        }
                    })
                }else {
                    toastr.error('PRODUCT NAME , BATCH NUMBNER, RDA  REFERENCE VALUE, STORAGE CONDITION, Assay Is Required');
                }
            });

        });

        /**
         * Button refresh
         **/
        $(document).on("click","#btn_refresh",function() {
            $(".pname").select2("val", "0");
            $('#interim_info_data')[0].reset();
            $('#btn_update').prop('disabled', true);
            $('#btn_save').prop('disabled', false);
        });

        /**
         * Get Sample Product And Show
         */
        var  lastResults;
        $("#pname").select2({
            tags: true,
            placeholder: 'Select product',
            delay: 250,
            minimumInputLength: 3,
            ajax: {
                multiple: true,
                url: '{{url('ssm/get_product_name')}}',
                data: function (params) {

                    var query = {
                        search: params?.term?.toUpperCase()
                    }
                    return query;
                },
                dataType: "json",
            },
        }).on('select2:closing', function (e) {
            // Preserve typed value
            lastResults = $('.select2-search input').prop('value');

        }).on('select2:open', function (e) {
            // Fill preserved value back into Select2 input field and trigger the AJAX loading (if any)
            $('.select2-search input').val(lastResults).trigger('change').trigger("input");
        });


        /**
         * Get And Show Interim Stability Data In Select Two
         */
        var currentQuery;
        $('#productlist').select2({
            placeholder: 'Select product',
            delay: 250,
            minimumInputLength: 3,
            ajax: {
                url: '{{url('ssm/search_saved_interim')}}',
                data: function (params) {
                    var query = "";
                    query = {
                        search: params?.term?.toUpperCase()
                    }

                    return query;
                }
            },
            datatype:'json'
        }).on('select2:closing', function (e) {
            // Preserve typed value
            currentQuery = $('.select2-search input').prop('value');

        }).on('select2:open', function (e) {
            // Fill preserved value back into Select2 input field and trigger the AJAX loading (if any)
            $('.select2-search input').val(currentQuery).trigger('change').trigger("input");
        });

    </script>

@endsection
