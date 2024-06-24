@extends('_layout_shared._master')
@section('title','Finance Process')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">--}}


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
    </style>
@endsection

@section('right-content')
    <form method="post" action="" class="form-horizontal" role="form">
        {{csrf_field()}}
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Finance Process
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">
                                    {{--<form action="" class="form-horizontal" role="form">--}}
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    @if( Auth::user()->desig === 'All'||Auth::user()->desig === 'HO')

                                        <div class="row">

                                            {{--<div class="container">--}}

                                            <div class="col-md-2">
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

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="rqid"
                                                           class="col-md-3 col-sm-6 control-label"><b>Rqid</b></label>
                                                    <div class="col-md-9">
                                                        <input  name="rqid" id="rqid" class="form-control input-sm" value="ALL">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="gl"
                                                           class="col-md-3 col-sm-6 control-label"><b>GL</b></label>
                                                    <div class="col-md-9">
                                                        <select name="gl" id="gl"
                                                                class="form-control input-sm">
{{--                                                            <option value="ALL">ALL</option>--}}
                                                            <option value="">Select GL</option>
                                                    @foreach($gl as $gln)
                                                        <option value="{{$gln->gl}}">{{$gln->gl}}</option>
                                                    @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cc"
                                                           class="col-md-3 col-sm-6 control-label"><b>CC</b></label>
                                                    <div class="col-md-9">
                                                        <select name="cc" id="cc"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Cost Center</option>--}}
                                                            {{--<option value="">Cost Center</option>--}}
                                                            <option value="ALL">ALL</option>
                                                            @foreach($cc as $ccn)
                                                            <option value="{{$ccn->cost_center_id}}">{{$ccn->cost_center_description}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="scc"
                                                           class="col-md-2 col-sm-6 control-label"><b>SCC</b></label>
                                                    <div class="col-md-10">
                                                        <select name="scc" id="scc"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Subcost Center</option>--}}
                                                            {{--<option value="">Subcost Center</option>--}}
                                                            <option value="ALL">ALL</option>
                                                            @foreach($scc as $ccn)
                                                            <option value="{{$ccn->sub_cost_center_id}}">{{$ccn->sub_cost_center_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            {{--</div>--}}

                                        </div>

                                        <div class="row">

{{--                                            <div class="container">--}}

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="nor"
                                                               class="col-md-5 col-sm-6 control-label"><b>Requests</b></label>
                                                        <div class="col-md-7">
                                                            <input type='number' name="nor" id="nor" class="form-control input-sm" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="pay_mode"
                                                               class="col-md-4  control-label"><b>Pay Mode</b></label>
                                                        <div class="col-md-8">
                                                            <select name="pay_mode" id="pay_mode"
                                                                    class="form-control input-sm">
                                                                <option value="ALL">ALL</option>
                                                                <option value="CHEQUE">CHEQUE</option>
                                                                <option value="CASH">CASH</option>
                                                                <option value="BEFTN">BEFTN</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="col-md-3" style="padding-right: 0px">
                                                <div class="form-group">
                                                    <label for="ben_group"
                                                           class="col-md-4  control-label"><b>Beneficiary </b></label>
                                                    <div class="col-md-8">
                                                        <select name="ben_group" id="ben_group"
                                                                class="form-control input-sm">
                                                            <option value="">Select Group</option>
                                                            <option value="ALL">ALL</option>
                                                            <option value="DOCTOR">DOCTOR</option>
                                                            <option value="INSTITUTE SINGLE">INSTITUTE SINGLE</option>
                                                            <option value="INSTITUTE COMBINED">INSTITUTE COMBINED</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="amount"
                                                               class="col-md-2  control-label"><b>Amount</b></label>
                                                        <div class="col-md-5">
                                                            <input type="number" name="ll" id="ll" class="form-control input-sm" placeholder="Lower Limit">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="number" name="ul" id="ul" class="form-control input-sm" placeholder="Upper limit">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-1">
                                                    {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                                    <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                        <i class="fa fa-check"></i> <b>Display</b></button>
                                                    {{--</div>--}}
                                                </div>


{{--                                            </div>--}}

                                        </div>


                                        <div class="row">

                                            <div class="container">


                                            <div class="col-md-2">
                                                <button type="button" id="btn_rr" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Remaining Requests</b></button>
                                            </div>

                                            <div class="col-md-2" style="display: none" id="rr_field">
                                                <input type='number' name="rr" id="rr" class="form-control input-sm" autocomplete="off" disabled>
                                            </div>

        @if(Auth::user()->user_id === '1016856' || Auth::user()->user_id === '1005975' || Auth::user()->user_id === '1004184'|| Auth::user()->user_id === '1000234' || Auth::user()->user_id === '1007284')

                                                    <div class="col-md-2">
                                                        <button type="button" id="btn_stp" class="btn btn-default btn-sm">
                                                            <i class="fa fa-check"></i> <b>Second time print</b></button>
                                                    </div>

                                                    <div id ="stp_div" style = "display:none;">

                                                        <div class="col-md-3"  >
                                                            <div class="form-group">
                                                                <label for="Id_select"
                                                                       class="col-md-5 col-sm-6 control-label"><b>Sum ID</b></label>
                                                                <div class="col-md-7">
                                                                    <select name="Id_select_stp" id="Id_select_stp"
                                                                            class="form-control input-sm">
                                                                        <option value="">Select</option>
                                                                        @foreach($sumid_stp as $sm)
                                                                            <option value="{{$sm->summ_id}}">{{$sm->summ_id}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4" >

                                                            <button type="submit" id="print_fi_process_stp" formaction="{{url('donation/print_fi_process_stp')}}" class="btn btn-default btn-sm">
                                                                <i class="fa fa-check"></i> <b>Print</b></button>

                                                            <button type="button" id="delete_sum"  class="btn btn-default btn-sm" style="margin-left: 40px">
                                                                <i class="fa fa-warning"></i> <b>Delete</b></button>

                                                        </div>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    @endif

                                    {{--</form>--}}
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
                    <img src="{{url('public/site_resource/images/c_loading.gif')}}"
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
                                        <th>GL</th>
                                        <th>COST CENTER ID</th>
                                        <th>COST CENTER NAME</th>
                                        <th>REQ </th>
                                        <th>TOTAL REQ Amt</th>
                                        <th>TOTAL BUDGET</th>
                                        <th>EXPENSE BUDGET</th>
                                        <th>AVAILABLE BUDGET</th>
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

        <div class="row" id="sum_portion" style=" display:none; padding-top: 10px;">
            <div class="">
                <div class="col-sm-10 col-md-10">
                    {{--<section class="panel" id="data_table">--}}
                    {{--<div class="panel-body">--}}
                    <div class="table-responsive">
                        <table id="sum_portion_table" class="table table-condensed table-striped table-bordered"
                               width="100%">
                            <thead style="white-space:nowrap;">
                            <tr>
                                <th>Sum ID</th>
                                <th>Total req</th>
                                <th>Total Req Amount</th>
                                <th>Cheque Req</th>
                                <th>Cheque Amount</th>
                                <th>Cash Req</th>
                                <th>Cash Amount</th>
                                <th>BEFTN Req</th>
                                <th>BEFTN Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;overflow:hidden;">

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>


                    </div>

                </div>
                <div class="col-md-2" id="print_fi" style="display: none">
                    <div class="table-responsive">

                        <table>
                            <tr>
                                <th></th>
                            </tr>
                            <td>
                                <input type="hidden" id="sum_id" name="sum_id" value="">
                                <button type="submit" id="print_fi_process" formaction="{{url('donation/print_fi_process')}}" class="btn btn-default btn-sm">
                                    <i class="fa fa-check"></i> <b>Print</b></button>
                            </td>
                        </table>

                    </div>
                </div>

            </div>
        </div>

        <div class="row" id="sum_detail" style=" padding-top: 10px;">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="Id_select"
                           class="col-md-5 col-sm-6 control-label"><b>Sum ID</b></label>
                    <div class="col-md-7">
                        <select name="Id_select" id="Id_select"
                                class="form-control input-sm">
                            <option value="">Select</option>
                            @foreach($sum_id as $sm)
                                <option value="{{$sm->summ_id}}">{{$sm->summ_id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 col-md-2"> <button type="button" id="btn_sum_dis" class="btn btn-default btn-sm">
                    <i class="fa fa-check"></i> <b>Display</b></button></div>

            <div class="col-md-2" id="print_fi_second" style="display:none">

                <button type="submit" id="print_fi_process_second" formaction="{{url('donation/print_fi_process_second')}}" class="btn btn-default btn-sm">
                    <i class="fa fa-check"></i> <b>Print</b></button>

            </div>

        </div>

    </form>


    {{-- Requisition details based on cost center which will open on click of cost center name --}}
    {{--<div class="row" id="detail-body" style="display: none;">--}}
    <div class="row" id="detail-body" style="display: none; padding-top: 10px;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detail_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Sum ID</th>
                                    <th>Total req</th>
                                    <th>Total Req Amount</th>
                                    <th>Cheque Req</th>
                                    <th>Cheque Amount</th>
                                    <th>Cash Req</th>
                                    <th>Cash Amount</th>
                                    <th>BEFTN Req</th>
                                    <th>BEFTN Amount</th>
                                    <th>FI Doc No</th>

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

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>--}}

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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    {{Html::script('public/site_resource/js/donation_script/fi_process_script.js')}}


    <script type="text/javascript">

        fitable = "{{url('donation/fi_req_data')}}";
        sum_save = "{{url('donation/sum_save')}}";
        sum_display = "{{url('donation/sum_display')}}";
        doc_update = "{{url('donation/doc_update')}}";
        rem_requests = "{{url('donation/rem_requests')}}";
        delete_row  =  "{{url('donation/delete_fi_summary')}}";
        _csrf_token = '{{csrf_token()}}';

        $(document).ready(function (){

            $('#print_fi_process').attr('formtarget', '_blank');
            $('#print_fi_process_second').attr('formtarget', '_blank');
            $('#print_fi_process_stp').attr('formtarget', '_blank');

            $("#btn_stp").click(function (){

                $("#print_fi_second").hide();
                $("#stp_div").show();

            });

            $("#delete_sum").click(function (){

               let  summid = $('#Id_select_stp').val();

                $.ajax({
                    type: "post",
                    url: delete_row,
                    dataType: 'json',
                    data: {summid: summid, _token: _csrf_token},
                    success: function (response) {

                        console.log(response);

                        toastr.success("deleted successfully");


                    },
                    error: function (data) {
                        console.log(data);
                        toastr.error("Error deleting row");
                    }
                });

            });

        });


    </script>

@endsection