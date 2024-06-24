<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 08/04/2020
 * Time: 12:06 PM
 */ ?>
@extends('_layout_shared._master')
@section('title','Adjustment Details- Local Travel')
@section('styles')

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

        #myTable > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }

        .cnt {
            text-align: center;
        }


        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }

        #pageloader
        {
            background: rgba( 255, 255, 255, 0.8 );
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
        }

        #pageloader img
        {
            left: 50%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
        }

    </style>
@endsection
@section('right-content')
    <div id="pageloader">
{{--        <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />--}}
        <img src="{{ url('public/site_resource/images/loader-large.gif') }}" alt="processing..." />
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Sorry!</strong> There were more problems with your input.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close"
                                                                                         data-dismiss="alert"
                                                                                         aria-label="close">&times;</a>
                </p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->

    <form method="post" id="adjustmentFormDtl" action="{{ route('local.storeAdjustmentDetails') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Adjustment Details - Local Travel
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="advice_no" class="col-md-4 col-sm-4 control-label"><b>Document
                                            Number: </b></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control document_no" id="document_no"
                                                name="document_no">
                                            <option value="">Select Document</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Document</b></button>
                                    </div>
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
                </section>
            </div>
        </div>


        <div id="expenseDetailsDiv"></div>

        <div class="row" id="attachmentDiv"  style="display: none">
            <div class="col-md-12 col-sm-12" style="padding-top: 1%">
                <section class="panel panel-primary">
                    <div class="panel-heading">
                        <label class="text-default">
                            Attached Travel Document
                        </label>
                    </div>
                    <div class="panel-body">
                        <div>
                            <span class="text-center" style="color: red"><b>**Note: Required, Maximum Upload Size 4 MB, Please merge pdf files in single file **</b></span>
                        </div>
                        <div class="control-form" >
                            <input type="file" name="filename" class="form-control">
                        </div>

                    </div>
                </section>
            </div>
        </div>


{{--        <div class="row" id="remarksDiv" style="display: none;">--}}
{{--            <div class="col-md-12 col-sm-12" style="padding-top: 1%">--}}
{{--                <section class="panel panel-primary">--}}
{{--                    <div class="panel-heading">--}}
{{--                        <label class="text-default">--}}
{{--                            Remarks--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                    <div class="panel-body">--}}
{{--                        <div class="form-group">--}}
{{--                            --}}{{--                            <label class="col-sm-2 control-label">Textarea</label>--}}
{{--                            <div class="col-sm-12">--}}
{{--                                <textarea rows="4" name="remarks" class="form-control"></textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </section>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="row" style="display: none; alignment: center" id="saveDiv">
            <div class="col-md-4 col-sm-4 text-center" style="padding-top: 1%">

            </div>
            <div class="col-md-4 col-sm-4 text-center" style="padding-top: 1%">
                <section class="panel">
                    <div class="panel-body">
                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-inbox"></i> Save </button>
                    </div>
                </section>
            </div>
        </div>

    </form>

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

        var counter = 0;


        $(function () {
            var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id  }}";
            $(".document_no").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "get",
                url: '{{route('local.getAdjustDocumentNo')}}',
                data: {emp_id: emp_id},
                dataType: 'json',
                success: function (response) {
                    var selItems = '';
                    selItems += "<option value=''>Select Document Number</option>";
                    for (var l = 0; l < response.length; l++) {
                        var id = response[l]['document_no'];
                        var val = response[l]['document_no'];
                        selItems += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.document_no').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $(".document_no").select2();
        });
        $('#btn_display').on('click', function () {
            var document_no = $('#document_no').val();
            var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id }}";
            var url = "{{ route('local.getAdjustment') }}";
            $("#loader").show();
            $("#expenseBreakDiv").show();
            $("#attachmentDiv").show();
            $("#saveDiv").show();
            $.ajax({
                // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                type: "get",
                url: url, // you need change it.
                data: {
                    'emp_id': emp_id,
                    'document_no': document_no
                },
                success: function (data) {
                    $("#loader").hide();
                    // $("#expenseBreakDiv").show();
                    console.log(Object.keys(data).length);
                    console.log(data);

                    var len = Object.keys(data).length;
                    var expHtml = '';
                    var i;
                    for (i = 0; i < len; i++) {
                        expHtml += '        <div class="row" id="expenseBreakDiv">\n' +
                            '            <div class="col-md-12 col-sm-12" style="padding-top: 1%">\n' +
                            '                <section class="panel panel-primary">\n' +
                            '                    <div class="panel-heading">\n' +
                            '                        <label class="text-default">\n' +
                            '                            Expense Break Down: "' + data[i].from_loc + ' => ' + data[i].to_loc + '=>' + data[i].destination + '" \n' +
                            ' <input type="hidden" name="location[]" value="'+data[i].from_loc +' => '+data[i].to_loc+' => '+data[i].destination+'" ></label>\n' +
                            '</div>\n' +
                            '                    <div class="panel-body table-responsive table" >\n' +

                            '                        <table id="expenditure' + i + '" class="table table-bordered table-hover table-condensed expenditure-list" width="100%">\n' +
                            '                            <thead>\n' +
                            '                            <th class="text-center">DATE  <input type="hidden"  name="id[]" value="' + data[i].id + '"  class=" form-control block"> </th>\n' +
                            '                            <th class="text-center">\n' +
                            '                                ACCOMMODATION CHARGE<br>\n' +
                            '                                <sub>(Hotel/Boarding Rent)</sub>\n' +
                            '                            </th>\n' +
                            '                            <th colspan="4" class="text-center">\n' +
                            '                                MEALS<br>\n' +
                            '                                <sub>Breakfast/Lunch/Dinner/Snacks</sub>\n' +
                            '                            </th>\n' +
                            '                            <th colspan="3" class="text-center">\n' +
                            '                                INCIDENTALS <br>\n' +
                            '                                <sub>Residence/work station to bus stand // Bus Stand to Residence/work station // Local conveyance</sub>\n' +
                            '                            </th>\n' +
                            '                            <th class="text-center">DAILY ALLOWANCE</th>\n' +
                            '                            <th class="text-center">TRANSPORT FARE</th>\n' +
                            '                            <th colspan="2" class="text-center">\n' +
                            '                                OTHERS <br>\n' +
                            '                                <sub>Tips / Miscellaneous</sub>\n' +
                            '                            </th>\n' +
                            '                            <th class="text-center">TOTAL</th>\n' +
                            '                            <th class="text-center">REMARKS</th>\n' +
                            '                            <th style="text-align: center;">\n' +
                            '                                <a class="addrow" type="button">\n' +
                            '                                    <i class="glyphicon glyphicon-plus"></i>\n' +
                            '                                </a>\n' +
                            '                            </th>\n' +
                            '                            </thead>\n' +
                            '                            <tbody>\n' +
                            '\n' +
                            '\n' +
                            '\n' +
                            '                            </tbody>\n' +
                            '                            <tfoot>\n' +
                            '                            </tfoot>\n' +
                            '                        </table>\n' +
                            '\n' +
                            '\n' +
                            '                    </div>\n' +
                            '                </section>\n' +
                            '            </div>\n' +
                            '        </div>';

                    }


                    $('#expenseDetailsDiv').empty().append(expHtml);

                },
                error: function (e) {
                    console.log(e);
                    $("#expenseBreakDiv").hide();
                    $("#remarksDiv").hide();
                    $("#saveDiv").hide();
                }
            });

        });


        $(document).on("click", ".addrow", function () {
            var tableId = $(this).closest('table').attr('id');
            // var tableId = $(this).closest('table').find('.block').val();
            counter += 1;
            // var block_id = $(this).closest('table').find('.block').val();
            // var block_id = $("#" + tableId).find('.block').val();
            var block_id = $(this).closest('table').find('.block').val();

            console.log("Yes clicked Id");
            console.log("tableid =", tableId);
            console.log("Block Id = ",block_id);



            var newRowExp = $("<tr>");
            var colsExp = "";
            colsExp += '<td> <input type="hidden"  autocomplete="off" class="tblrowId" name="counter[]" value="' + counter + '">' +

                ' <div class=\'input-group date datetimepicker1 \'><input type=\'text\' autocomplete="off" class="form-control" name="date[]"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></td>';
            colsExp += '<td> <input type="text"  autocomplete="off" name="accommodation[]" class=" form-control meals"></td>';
            colsExp += '<td> <input type="text"  autocomplete="off" name="breakfast[]" class=" form-control meals"></td>';
            colsExp += '<td> <input type="text"  autocomplete="off" name="launch[]" class=" form-control meals"></td>';
            colsExp += '<td> <input type="text"  autocomplete="off" name="dinner[]" class=" form-control meals"></td>';
            colsExp += '<td> <input type="text"  autocomplete="off" name="snacks[]" class=" form-control meals"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="rw_to_bus[]" class=" form-control incidentals"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="bus_to_rw[]" class=" form-control incidentals"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="lc[]" class=" form-control incidentals"></td>';
            colsExp += '<td><input type="text"  autocomplete="off"  name="da[]" class=" form-control da"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="transport[]" class=" form-control transport"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="tips[]" class=" form-control others"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="miscellaneous[]" class=" form-control others"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="linetotal[]" class=" form-control linetotal"></td>';
            colsExp += '<td><input type="text"  autocomplete="off" name="remarks[]" class=" form-control "></td>';
            colsExp += '<td><input type="hidden"  autocomplete="off" name="idx[]" value="'+block_id+'" class=" form-control "></td>';
            colsExp += '<td><span class="ibtnDel btn btn-danger "><i class="fa fa-trash-o"></i> </span> </td>';
            newRowExp.append(colsExp);
            // $("table.expenditure-list").append(newRowExp);
            $("#" + tableId).append(newRowExp);

        });

        $(document).on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();
        });


        $(function () {
            $("body").on("click", ".datetimepicker1", function () {
                $(this).datetimepicker({format: 'DD/MM/YYYY'});
                $(this).datetimepicker("show");
            });
        });

        $("#adjustmentFormDtl").on("submit", function(){
            $("#pageloader").fadeIn();
        });//submit


    </script>
@endsection