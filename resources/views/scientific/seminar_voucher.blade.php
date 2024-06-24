@extends('_layout_shared._master')
@section('title','Scientific Seminar Voucher')

@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>

    <style>

        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
            background-color: #46B8DA;
            border-color: #46B8DA;
            color: #fff;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 10px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }


        body {
            color: #000;
        }

        .btn-primary {
            margin-right: 10px;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/
            /*font-weight: bold;*/

        }

        .tools a:hover {
            background: #337ab7;
        }

        .tools a {
            background: none;
            color: white;
        }

        caption {
            padding-top: 8px;
            padding-bottom: 8px;
            color: black;
            font: caption;
            text-align: center;
        }

    </style>

@endsection

@section('right-content')


    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary" style="color: white">
                        Depot Account Process
                    </label>
                </header>

                @if( Auth::user()->urole === '1' ||Auth::user()->urole === '53' || Auth::user()->urole === '54')

                <div class="panel-body">

                        <div class="row">

                            {{--                                <div class="col-md-2">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label for="bgt_month"--}}
                            {{--                                               class="control-label"><b>Month of Program</b></label>--}}
                            {{--                                        <select name="bgt_month" id="bgt_month"--}}
                            {{--                                                class="form-control input-sm">--}}
                            {{--                                            <option value="">Select</option>--}}
                            {{--                                            @foreach($month_name as $mn)--}}
                            {{--                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>--}}
                            {{--                                            @endforeach--}}
                            {{--                                        </select>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}


                            <form method="post" action="">
                                {{csrf_field()}}
                                <div class=" col-md-2">
                                    <label>Proposal No</label><br>
                                    <select name="program_no_for_voucher" id="program_no_for_voucher"
                                            class="form-control input-sm" required>
                                        <option value="">select proposal no</option>
                                        @foreach($program_no as $pn)
                                            <option value="{{$pn->prog_no}}">{{$pn->prog_no}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class=" col-md-2">
                                    <label></label><br>
                                    <button type="button" id="create_voucher" class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Create Voucher</b>
                                        <i class="fa fa-spinner fa-spin" id="program_bill_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>

                                <div class=" col-md-1">
                                    <label></label><br>
                                    <button type="submit" id="proposal_report" class="btn btn-default btn-sm"
                                            formaction="{{url('scientific/print_proposal_voucher')}}">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Print</b>
                                        <i class="fa fa-spinner fa-spin" id="program_bill_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>
                            </form>

                            <form method="post" action="">
                                {{csrf_field()}}

                                <div class=" col-md-2">
                                    <label>Bill No</label><br>
                                    <select name="bill_no_for_voucher" id="bill_no_for_voucher"
                                            class="form-control input-sm" required>
                                        <option value="">select Bill no</option>
                                        @foreach($bill_no as $pn)
                                            <option value="{{$pn->bill_no}}">{{$pn->bill_no}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class=" col-md-2">
                                    <label></label><br>
                                    <button type="button" id="create_bill_voucher" class="btn btn-default btn-sm">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Create Voucher</b>
                                        <i class="fa fa-spinner fa-spin" id="program_bill_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>

                                <div class=" col-md-1">
                                    <label></label><br>
                                    <button type="submit" id="bill_report" class="btn btn-default btn-sm"
                                            formaction="{{url('scientific/print_bill_voucher')}}">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Print</b>
                                        <i class="fa fa-spinner fa-spin" id="verify_display_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>
                            </form>

                        </div>

                </div>
            </section>

            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary" style="color: white">
                        Duplicate Printing Process
                    </label>
                </header>
                        <div class="panel-body">
                        <div class="row">

                            <form method="post" action="">
                                {{csrf_field()}}

                                <div class=" col-md-2">
                                    <label>Proposal No</label><br>
                                    <select name="program_no_for_voucher_duplicate"
                                            id="program_no_for_voucher_duplicate"
                                            class="form-control input-sm" required>
                                        <option value="">select proposal no</option>
                                        @foreach($program_no_duplicate as $pn)
                                            <option value="{{$pn->proposal_bill_no}}">{{$pn->proposal_bill_no}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class=" col-md-2">
                                    <label></label><br>
                                    <button type="submit" id="proposal_report_duplicate" class="btn btn-default btn-sm"
                                            formaction="{{url('scientific/print_proposal_voucher_duplicate')}}">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Print Duplicate</b>
                                        <i class="fa fa-spinner fa-spin" id="program_bill_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>

                            </form>

                            <form method="post" action="">
                                {{csrf_field()}}

                                <div class=" col-md-2">
                                    <label>Bill No</label><br>
                                    <select name="bill_no_for_voucher_duplicate" id="bill_no_for_voucher_duplicate"
                                            class="form-control input-sm" required>
                                        <option value="">select Bill no</option>
                                        @foreach($bill_no_duplicate as $pn)
                                            <option value="{{$pn->proposal_bill_no}}">{{$pn->proposal_bill_no}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class=" col-md-2">
                                    <label></label><br>
                                    <button type="submit" id="bill_report_duplicate" class="btn btn-default btn-sm"
                                            formaction="{{url('scientific/print_bill_voucher_duplicate')}}">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Print Duplicate</b>
                                        <i class="fa fa-spinner fa-spin" id="verify_display_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                </div>
                @endif

            </section>
        </div>
    </div>

    <div id="direct_bill_form" style="display:;">

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
    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    <script type="text/javascript">

        create_proposal_voucher = "{{url('scientific/create_proposal_voucher')}}";
        create_bill_voucher = "{{url('scientific/create_bill_voucher')}}";

        _csrf_token = '{{csrf_token()}}';
        var table;

        $(document).ready(function () {

                $('#proposal_report').attr('formtarget', '_blank');

                $('#proposal_report_duplicate').attr('formtarget', '_blank');

            $('#bill_report_duplicate').attr('formtarget', '_blank');

                $('#bill_report').attr('formtarget', '_blank');

                $('#bgt_month').on('change', function () {
                    console.log('month changed');

                    var month = $('#bgt_month').val();
                    $("#program_no_for_report").empty().append("<option value='loader'>Loading...</option>");
                    $("#bill_no_for_report").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        method: "post",
                        url: program_and_bill,
                        data: {
                            _token: _csrf_token,
                            mon: month
                        },
                        success: function (data) {
                            console.log(data);
                            var proposal = data['proposal'];
                            var bill = data['bill'];
                            // console.log(data.length);
                            // if ((data.length) > 0) {
                            var pr = '';

                            for (var i = 0; i < proposal.length; i++) {
                                pr += '<option value= " ' + proposal[i]['prog_no'] + ' " >' + proposal [i]['prog_no'] + '</option>';
                            }
                            $("#program_no_for_report").empty().append(pr);

                            var bl = '';

                            for (var i = 0; i < bill.length; i++) {
                                bl += '<option value= " ' + bill[i]['bill_no'] + ' " >' + bill [i]['bill_no'] + '</option>';
                            }
                            $("#bill_no_for_report").empty().append(bl);

                            // }

                        },
                        error: function () {
                            console.log('fail');
                        }
                    });
                });

                $("#create_voucher").click(function () {

                    console.log('Create voucher button clicked');

                    if ($("#program_no_for_voucher").val() === "") {
                        alert("Please select Proposal No.");
                    } else {
                        var prog_no = $("#program_no_for_voucher").val();

                        $.ajax({
                            url: create_proposal_voucher,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                proposal_no: prog_no
                            },

                            success: function (resp) {

                                console.log(resp);
                                var count = resp.occurance[0]['times'];
                                console.log(count);
                                if (count == 1) {
                                    toastr.info('Voucher has already been created for this proposal');
                                }
                                var insert_job = resp.insert_proposal_voucher;
                                console.log(insert_job);
                                if (insert_job == true) {
                                    toastr.success('Voucher has been created successfully');
                                }

                            },
                            error: function (err) {
                                toastr.info('Something went wrong! Please try again');

                            }
                        });

                    }

                });

                $("#create_bill_voucher").click(function () {

                    console.log('Create voucher button clicked');

                    if ($("#bill_no_for_voucher").val() === "") {
                        alert("Please select Bill No.");
                    } else {
                        var prog_no = $("#bill_no_for_voucher").val();

                        $.ajax({
                            url: create_bill_voucher,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                proposal_no: prog_no
                            },

                            success: function (resp) {

                                console.log(resp);
                                var count = resp.occurance[0]['times'];
                                console.log(count);
                                if (count == 1) {
                                    toastr.info('Voucher has already been created for this Bill');
                                }
                                var insert_job = resp.insert_proposal_voucher;
                                console.log(insert_job);
                                if (insert_job == true) {
                                    toastr.success('Voucher has been created successfully');
                                }

                            },
                            error: function (err) {
                                toastr.info('Something went wrong! Please try again');

                            }
                        });

                    }

                });


            }
        );


    </script>

@endsection