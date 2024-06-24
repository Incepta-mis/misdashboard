<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 23/04/2020
 * Time: 12:03 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Adjustment - FI Local')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
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
            padding: 2px;
            font-size: 11px;
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

        .emp_info > thead > tr > th {
            text-align: center;
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

        .modal-dialog {
            width: 98%;
            height: 92%;
            padding: 0;
        }

        .modal-content {
            height: 99%;
        }

        .btn.disabled {
            pointer-events: none;
        }

        /* Hiding the checkbox, but allowing it to be focused */
        .badgebox {
            opacity: 0;
        }

        .badgebox + .badge {
            /* Move the check mark away when unchecked */
            text-indent: -999999px;
            /* Makes the badge's width stay the same checked and unchecked */
            width: 27px;
        }

        .badgebox:focus + .badge {
            /* Set something to make the badge looks focused */
            /* This really depends on the application, in my case it was: */

            /* Adding a light border */
            box-shadow: inset 0px 0px 5px;
            /* Taking the difference out of the padding */
        }

        .badgebox:checked + .badge {
            /* Move the check mark back when checked */
            text-indent: 0;
        }

    </style>
@endsection
@section('right-content')
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
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Travel FI Adjustment
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="company_id"
                                       class="col-md-4 col-sm-4 control-label"><b>Company: </b></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control company_id" id="company_id"
                                            name="company_id">
                                        <option value="">Select Company</option>
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
                <div class="row" id="report-body" style="display: none;">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <section class="panel" id="data_table">
                            <div class="panel-body">
                                <div class="table table-responsive">
                                    <table id="example" class="display table table-bordered table-striped"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                           <th>SL#</th>
                                            <th>EMP_ID</th>
                                            <th>DOCUMENT_NO</th>
                                            <th>ADVANCE_AMT</th>
                                            <th>EXPENSE_AMT</th>
                                            <th>ADJUST_AMT</th>
                                            <th>FI_ADJUST_AMT</th>
                                            <th>SAP_DOCUMENT</th>
                                            <th>ACTION</th>
                                        </tr>
                                        </thead>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
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

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(function () {
            {{--            var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id  }}";--}}
            $(".company_id").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "get",
                url: '{{route('local.getCompanyId')}}',
                // data: {emp_id: emp_id},
                dataType: 'json',
                success: function (response) {
                    var selItems = '';
                    selItems += "<option value=''>Select Company</option>";
                    for (var l = 0; l < response.length; l++) {
                        var id = response[l]['company_id'];
                        var val = response[l]['company_name'];
                        selItems += "<option value='" + id + "'>" + id + ' - ' + val + "</option>";
                    }
                    $('.company_id').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $(".company_id").select2();
        });

        var table = null;

        $('#btn_display').on('click', function () {

            if ($.trim($('#company_id').val()) == '') {
                swal({
                    icon: 'error',
                    type: 'error',
                    text: 'Please select Company..!'
                });
            } else {
                var company_id = $('#company_id').val();
                console.log(company_id);
                        {{--var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id }}";--}}
                var url = "{{ route('local.getCompWiseEmpAdjustment') }}";
                $("#loader").show();
                $("#report-body").hide();


                $.ajax({
                    // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                    type: "get",
                    url: url, // you need change it.
                    data: {
                        'company_id': company_id
                    },
                    success: function (dresponse) {
                        console.log('Yes ....', dresponse);


                        $("#loader").hide();
                        $("#report-body").show();

                        if (table != null) {
                            table.clear().draw();
                        }

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({
                            data: dresponse,
                            dom: 'Bfrtip',
                            buttons: [
                                'excel', 'pdf',
                            ],
                            autoWidth: true,
                            fnRowCallback: function (nRow, aData, iDisplayIndex) {
                                $("td:first", nRow).html(iDisplayIndex + 1);
                                return nRow;
                            },
                            columns: [
                                {data: null},
                                {data: 'emp_id'},
                                {data: 'document_no'},
                                {data: 'adv_amt'},
                                {data: 'exp_amt'},
                                {data: 'emp_adjust_amt'},
                                {
                                    data: "null",
                                    "render": function (data, type, row) {
                                        return '<input type="text" name="fi_adjust_amt" id="fi_adjust_amt">';
                                    }
                                },
                                {
                                    data: "null",
                                    "render": function (data, type, row) {

                                        return '<input type="text" name="fi_sap_doc" id="fi_sap_doc">';
                                    }
                                },
                                {
                                    data: null,
                                    "render": function (data, type, row) {
                                        return "<button  class='ps btn btn-success btn-xs'><span class='glyphicon glyphicon-floppy-save'></span> Post </button>";
                                    }
                                },


                            ],
                            // columnDefs: [{
                            //     targets: 0,
                            //     render: function (data, type, row, meta) {
                            //         // console.log('cross',data);
                            //         // console.log(type == 'export' ? meta.row : data);
                            //         return type == 'export' ? meta.row : data;
                            //     }
                            // }],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },


                            info: true,
                            paging: true,
                            filter: true
                        });
                    },
                    error: function (e) {
                        console.log('Error : ', e);
                    }
                });
            }


        });

        $(document).on("click", ".ps", function () {

            // console.log('button...', table);
            var data = null;
            var closestRow = $(this).closest('tr');
            data = table.row(closestRow).data();
            var fi_adjust_amt = $(this).closest('tr').find('td #fi_adjust_amt').val();
            var fi_sap_doc = $(this).closest('tr').find('td #fi_sap_doc').val();
            $.extend(data, {"fi_adjust_amt": fi_adjust_amt});
            $.extend(data, {"fi_sap_doc": fi_sap_doc});
            // console.log('Yes clicked', data);

            // console.log($(this).closest('tr').find('.ps').html());

            // $(this).closest('tr').find('.ps').attr('disabled', true);

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {fidata: data},
                url: "{{ route('local.storeFiAdjustData') }}",
                success: function (resp) {
                    // console.log(resp);
                    if (resp.success) {
                        toastr.success(resp.success, '', {timeOut: 2000});
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                complete: function () {
                    //Ajax request is finished, so we can enable
                    //the button again.
                    $('.ps').attr("disabled", true);
                },
                error: function () {

                }
            });


        });


    </script>

@endsection