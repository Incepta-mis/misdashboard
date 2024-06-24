<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 8/09/2020
 * Time: 09:25 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Travel Note Sheet Checked By')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>


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
        .badgebox
        {
            opacity: 0;
        }

        .badgebox + .badge
        {
            /* Move the check mark away when unchecked */
            text-indent: -999999px;
            /* Makes the badge's width stay the same checked and unchecked */
            width: 27px;
        }

        .badgebox:focus + .badge
        {
            /* Set something to make the badge looks focused */
            /* This really depends on the application, in my case it was: */

            /* Adding a light border */
            box-shadow: inset 0px 0px 5px;
            /* Taking the difference out of the padding */
        }

        .badgebox:checked + .badge
        {
            /* Move the check mark back when checked */
            text-indent: 0;
        }

    </style>

@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Travel Note Sheet Checked By
                    </label>
                </header>

                <div class="panel-body">

                    <form class="form-horizontal" method="get" action="">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Approval : </label>
                                        <div class="col-md-8">
                                            <input type="text" readonly class="form-control input-sm"
                                                   value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 col-xs-2 control-label input-sm">Document:</label>
                                        <div class="col-sm-10 col-md-10 col-xs-10">
                                            <select name="doc_no" id="doc_no"
                                                    class="form-control input-sm ">
                                                <option value="">Select Document</option>
                                                <option value="All">All</option>
                                                @foreach($doc_info as $ei)
                                                    <option value="{{$ei->document_no}}">{{$ei->document_no}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Status</label>
                                        <div class="col-sm-8 ">
                                            <select name="astatus" id="astatus" class="form-control input-sm m-bot15">
                                                <option value="">Select Status</option>
                                                <option value="All">All</option>
                                                <option value="YES">Accepted</option>
                                                <option value="NO">Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12 col-sm-12">

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                        <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Report</b></button>
                                    </div>
                                    <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                        <div id="export_buttons">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

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
                                            <th>ID</th>
                                            <th>DOCUMENT_NO</th>
                                            <th>EMP ID</th>
                                            <th>NAME</th>
                                            <th>DESIG</th>
                                            <th>DEPT. NAME</th>
                                            <th>LOCATION</th>
                                            <th>STATUS</th>
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

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
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



    {{--Date--}}
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">

        $('#doc_no').select2();



        $('#btn_display').on('click',function () {

            if($.trim($('#doc_no').val()) == '' || $.trim($('#astatus').val()) == '' ){
                swal({
                    icon: 'error',
                    type: 'error',
                    text: 'Please select Document and  Status!'
                });
            }else {
                var doc_no = $('#doc_no').val();
                var status = $('#astatus').val();
                var url = "{{ route('international.intlGetTravelerByDocument') }}";
                $("#loader").show();
                $("#report-body").hide();
                $.ajax({
                    // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                    type: "get",
                    url: url,
                    data: {
                        'doc_no': doc_no,
                        'status': status
                    },
                    success: function (data) {
                        // console.log(data);
                        $("#loader").hide();
                        $("#report-body").show();

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({

                            data: data,
                            autoWidth: true,
                            columns: [
                                {data: 'id'},
                                {data: 'document_no'},
                                {data: 'emp_id'},
                                {data: 'emp_name'},
                                {data: 'desig_name'},
                                {data: 'dept_name'},
                                {data: 'location'},
                                {
                                    data: "checked_accept",
                                    className: "saccept",
                                    "render": function (data, type, row) {
                                        //console.log("get row data =",row.dept_accept);
                                        if (row.checked_accept === null) {
                                            return '<span class="label label-warning">Pending</span>';
                                        } else if (row.checked_accept === 'YES') {
                                            return '<span class="label label-success "> Accepted </span>';
                                        } else if (row.checked_accept === 'NO') {
                                            return '<span class="label label-danger "> Rejected </span>';
                                        }
                                    }
                                },

                                {
                                    data: null,
                                    "render": function (row) {
                                        if (row.checked_accept === null) {
                                            return "<button type='submit' formtarget='_blank' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>"+ " " +
                                            "<button type='button' class='btn btn-success btn-xs accept' id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                "<button type='button' class='btn btn-danger btn-xs reject' id='reject'><span class='glyphicon glyphicon-remove'></span>  </button>";
                                        } else if (row.checked_accept === 'YES') {
                                            return "<button type='submit' formtarget='_blank' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>"+ " " +
                                            "<button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>";
                                        } else if (row.checked_accept === 'NO') {
                                            return "<button type='submit' formtarget='_blank' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'></span>   </button>"+ " " +
                                                "<button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>" + " " +
                                                "<button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>";
                                        }
                                    }
                                }
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            columnDefs: [
                                {
                                    "targets": [0],
                                    "visible": false
                                }
                            ],
                            info: true,
                            paging: true,
                            filter: true
                        });
                    },
                    error: function (e) {
                        console.log('Error : ',e);
                    }
                });
            }
        });

        $(document).on("click",".edit-btn",function() {

            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var document_no = data.document_no;
            console.log(document_no);

            window.open("{{ url('travel/international/noteSheetDetailsView') }}/"+document_no,'_blank');

        });


        //for accept button
        $(document).on("click",".accept",function() {

            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'accept';
            var document_no = data.document_no;
            var self = $(this);

             console.log(data);
             alert( 'You clicked on '+data.document_no+'\'s row' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {document_no: document_no, st: st},
                url: "{{ route('international.intlNoteSheetCheckedApprBy') }}",
                success: function (resp) {
                    // console.log(resp);
                    if (resp.success) {
                        // console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.saccept').html('');
                        self.closest('tr').find('.saccept').html('<span class="label label-success "> Accepted </span>');
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        self.closest('tr').find('.edit-btn').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function () {

                }
            });
        });

        //for reject button
        $(document).on("click",".reject",function( ){

            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'reject';
            var document_no = data.document_no;
            var self = $(this);

            // console.log(data);
            // alert( 'You clicked on '+data.id+'\'s row' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {document_no: document_no, st: st},
                url: "{{ route('international.intlNoteSheetCheckedApprByNotAppr') }}",
                success: function (resp) {
                    // console.log('rejection data =',resp);
                    if (resp.success) {
                        console.log(self.closest('tr').find('.saccept').html());
                        self.closest('tr').find('.saccept').html('');
                        self.closest('tr').find('.saccept').html('<span class="label label-danger "> Rejected </span>');
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        self.closest('tr').find('.edit-btn').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function () {

                }
            });

        });

    </script>



@endsection
