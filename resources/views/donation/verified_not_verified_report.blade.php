@extends('_layout_shared._master')
@section('title','Verification Check')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>


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
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Verification Check
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-5 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-7">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($month_name as $mn)
                                                            <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="don_type" class="col-md-5 col-sm-6 control-label"><b>Expense
                                                        Type</b></label>
                                                <div class="col-md-7">
                                                    <select name="don_type" id="don_type"
                                                            class="form-control input-sm">
                                                        <option value="">Select Expense Type</option>
                                                        <option value="ALL">ALL</option>
                                                        @foreach($dtm as $tm)
                                                            <option value="{{$tm->type_name}}"
                                                                    >{{$tm->type_mct}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ver"
                                                       class="col-md-5 col-sm-6 control-label"><b>Verification</b></label>
                                                <div class="col-md-7">
                                                    <select name="ver" id="ver"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        <option value="ALL">ALL</option>
                                                            <option value="VERIFIED">VERIFIED</option>
                                                            <option value="NOT VERIFIED">NOT VERIFIED</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-1">
                                            {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>
                                            {{--</div>--}}
                                        </div>


                                        {{-- First row ends here--}}

                                    </div>


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

    <div class="row tot_amt" style="display: none;">
     <div class="col-md-3">Total <input id="tt_amt"></div>
    </div>


    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="req_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>

                                    <th>Month</th>
                                    <th>Status</th>
                                    <th>Emp ID</th>
                                    <th>Emp Name</th>
                                    <th>Rq Id</th>
                                    <th>Terr Id </th>
                                    <th>Depot</th>
                                    <th>amt</th>
                                    {{--<th>Dpo Name</th>--}}
                                    <th>Don Type</th>
                                    <th>GBRN</th>
                                    <th>Ben id</th>
                                    <th>Ben Name</th>
                                    <th>Bentype</th>
                                    <th>Pay Mode</th>
                                    <th>purpose</th>
                                    <th>freq</th>

                                    <th>check_date</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>

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

    {{-- Added for selecting all on click--}}

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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}


    <script type="text/javascript">
        $(document).ready(function () {


                $("#btn_display").click(function () {
                    var dcid= $("#bgt_month").val();
                    var ver_data= $("#ver").val();
                    var don_typ= $("#don_type").val();

                    console.log(dcid);
                    console.log(ver_data);
                    var table = "";
                    $.ajax({
                        method:'post',
                        url:'{{url('donation/verified_not_verified_data')}}',
                        data: {
                            dcid:dcid,
                            ver_data:ver_data,
                            don_typ:don_typ,
                            _token: '{{csrf_token()}}'
                        },
                        success:function (data) {
                            console.log(data);
                            $('#tt_amt').val(data['total_amt'][0].tot_amount);
                            $('.tot_amt').show();
                            $('#req_list').DataTable().destroy();
                            // ,,,,,,,,req_id,
                            //     ,,,,purpose,frequency,amount,

                            var table= $('#req_list').DataTable({
                                data: data['cc'],
                                dom: 'Bfrtip',
                                buttons: [

                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            // columns: [0, 1, 2, 3, 4, 5]
                                        }
                                    }

                                ],
                                columns:[
                                    {data:"payment_month"},
                                    {data:"vf_ntf"},
                                    {data:"emp_id"},
                                    {data:"emp_name"},
                                    {data:"req_id"},
                                    {data:"terr_id"},
                                    {data:"depot"},
                                    {data:"amount"},
                                    // {data:"d_name"},
                                    {data:"donation_type"},
                                    {data:"group_brand_region_name"},
                                    {data:"doctor_id"},
                                    {data:"doctor_name"},
                                    {data:"beneficiary_type"},
                                    {data:"payment_mode"},
                                    {data:"purpose"},
                                    {data:"frequency"},

                                    {data:"check_date"}

                                ],
                                paging:false,
                                filtering:false,
                                info:false,
                                searching:false
                            });

                            $("#report-body").show();
                            table.columns.adjust();
                        },
                        error:function () {
                            console.log('fail');
                        }

                    });

                });


            }
        );



    </script>

@endsection