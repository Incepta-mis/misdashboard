@extends('_layout_shared._master')
@section('title','Beneficiary wise Expense')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>

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

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: #000;
        }
        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/

        }
        /*div.dt-buttons{*/
        /*position:relative;*/
        /*float:right;*/

        /*}*/
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Beneficiary wise Expense Report
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    {{--@if(Auth::user()->desig === 'All'|| Auth::user()->desig === 'HO'|| Auth::user()->desig === 'GM')--}}

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="bgt_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>Month</b></label>
                                                    <div class="col-md-6">
                                                        <select name="bgt_month" id="bgt_month"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($month_name as $mn)
                                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dcid"
                                                           class="col-md-5 col-sm-6 control-label"><b>Beneficiary ID</b></label>
                                                    <div class="col-md-7">
                                                        <input name="dcid" id="dcid" class="form-control input-sm" autocomplete="off" >
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-1">
                                                {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display</b></button>
                                                {{--</div>--}}
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                                                <div id="export_buttons">

                                                </div>
                                            </div>


                                        </div>

                                    {{--@endif--}}

                                </form>
                            </div>
                        </div>
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
                            <table id="req_ccwise" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Req ID</th>
                                    <th>Terr Id</th>
                                    <th>Emp Id</th>
                                    <th>Emp Name</th>
                                    <th>Sum id</th>
                                    <th>Ref No</th>
                                    <th>Ben Id</th>
                                    <th>Ben Name</th>
                                    <th>Infavor of</th>
                                    <th>Payment Month</th>
                                    <th>Frequency</th>
                                    <th>Amount</th>
                                    <th>Donation Type </th>
                                    <th>Brand/Region</th>
                                    <th>Payment Mode</th>
                                    <th>AM Check</th>
                                    <th>RM Check</th>
                                    <th>BE Check</th>
                                    <th>DSM Check</th>
                                    <th>SM Check</th>
                                    <th>SSD Check</th>
                                    <th>Head Check</th>
                                    <th>GM Sales Check</th>
                                    <th>GM MSD Check</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

    {{----}}
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
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}



    <script type="text/javascript">

        servloc = "{{url('donation/doc_wise_donation')}}";
        _csrf_token = '{{csrf_token()}}';

        $(document).ready(function () {

$('#btn_display').click(function () {


    if ($("#bgt_month").val() === "") {
        toastr.info("Please select Month");
    }
    else if ($("#dcid").val() === "") {
        toastr.info("Please input Doctor ID");
    }
    else {
        var mont = $("#bgt_month").val();
        var doctor = $("#dcid").val();

        $("#loader").show();

        console.log(mont);
        console.log(doctor);

        $.ajax({
            method:'post',
            url:servloc,
            data: {
                mont: mont,
                doctor:doctor,
                _token: _csrf_token
            },
            success: function (resp) {

                console.log(resp);

                console.log($('#fix').height());
                $("#loader").hide();
                $("#report-body").show();


                $("#req_ccwise").DataTable().destroy();
                var table = $("#req_ccwise").DataTable({
                    data: resp,
                    columns: [
                        {data: "req_id"},
                        {data: "terr_id"},
                        {data: "emp_id"},
                        {data: "emp_name"},
                        {data: "summ_id"},
                        {data: "ref_no"},
                        {data: "doctor_id"},
                        {data: "doctor_name"},
                        {data: "in_favour_of"},
                        {data: "payment_month"},
                        {data: "frequency"},
                        {data: "approved_amount"},
                        {data: "donation_type"},
                        {data: "group_brand_region_name"},
                        {data: "payment_mode"},

                        {data: "am_checked_date"},
                        {data: "rm_checked_date"},
                        {data: "be_checked_date"},
                        {data: "dsm_checked_date"},
                        {data: "sm_checked_date"},
                        {data: "ssd_checked_date"},
                        {data: "group_head_checked_date"},
                        {data: "gm_sales_checked_date"},
                        {data: "gm_msd_checked_date"}
                    ],


                    language: {
                        "emptyTable": "No Matching Records Found."
                    },

                    info: false,
                    paging: false,
                    filter: false,
                    order: false



                });


            },
            error: function (err) {
                // console.log(err);
                $("#loader").hide();
                $("#report-body").show();
            }

        });


    }



});


        });



    </script>


@endsection