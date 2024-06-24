@extends('_layout_shared._master')
@section('title','Medicine Requisition Verification')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Medicine Requisition Verification
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 0px">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}


                                    @if(Auth::user()->desig === 'AM'||Auth::user()->desig === 'Sr. AM')

<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label for="bgt_month"
                   class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
            <div class="col-md-8">
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

    <div class="col-md-3">
        <div class="form-group">
            <label for="gl"
                   class="col-md-4 col-sm-6 control-label"><b>GL</b></label>
            <div class="col-md-8">
                <select name="gl" id="gl"
                        class="form-control input-sm">
{{--                    <option value="ALL">ALL</option>--}}

                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="cc"
                   class="col-md-4 col-sm-6 control-label"><b>Cost Cent</b></label>
            <div class="col-md-8">
                <select name="cc" id="cc"
                        class="form-control input-sm">
                    <option value="ALL">ALL</option>
                </select>
            </div>
        </div>
    </div>

    {{-- First row ends here--}}

</div>

<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label for="rm_terr"
                   class="col-md-4 col-sm-6 control-label"><b>RM Terr</b></label>
            <div class="col-md-8">
                <select name="rm_terr" id="rm_terr"
                        class="form-control input-sm" disabled>
                    @if(Auth::user()->desig == 'RM' || Auth::user()->desig == 'ASM')
                        <option value="{{Auth::user()->terr_id}}">{{Auth::user()->terr_id}}</option>
                    @else
                        @foreach($rm_terr as $rt)
                            <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="am_terr"
                   class="col-md-4 col-sm-6 control-label"><b>AM
                    Terr</b></label>
            <div class="col-md-8">
                <select name="am_terr" id="am_terr"
                        class="form-control input-sm" disabled>
                    @foreach($am_terr as $terr)
                        <option value="{{$terr->am_terr_id}}">
                            {{$terr->am_terr_id}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="mpo_terr"
                   class="col-md-4 col-sm-6 control-label"><b>MPO Terr</b></label>
            <div class="col-md-8">
                <select name="mpo_terr" id="mpo_terr"
                        class="form-control input-sm">
                    <option value="">Select Territory</option>
                    <option value='ALL'>ALL</option>
                    @foreach($mpo_terr as $terr)
                        <option value="{{$terr->mpo_terr_id}}">
                            {{$terr->mpo_terr_id}}</option>
                    @endforeach

                </select>
            </div>
        </div>
    </div>



    {{--<div class="form-group">--}}
    <div class=" col-md-1 col-sm-2 col-xs-6">
        <button type="button" id="btn_display_dmr" class="btn btn-default btn-sm">
            <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
        </button>
        {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
    </div>

</div>


@endif

                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM')

                                        <div class="row">


                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label for="bgt_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                    <div class="col-md-8">
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

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="gl"
                                                           class="col-md-4 col-sm-6 control-label"><b>GL</b></label>
                                                    <div class="col-md-8">
                                                        <select name="gl" id="gl"
                                                                class="form-control input-sm">
{{--                                                            <option value="ALL">ALL</option>--}}

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cc"
                                                           class="col-md-4 col-sm-6 control-label"><b>Cost Cent</b></label>
                                                    <div class="col-md-8">
                                                        <select name="cc" id="cc"
                                                                class="form-control input-sm">
                                                            <option value="ALL">ALL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- First row ends here--}}

                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            <option value="{{Auth::user()->terr_id}}">{{Auth::user()->terr_id}}</option>
                                                            {{--<option value="">Select Territory</option>--}}
                                                            {{--<option value="ALL">ALL</option>--}}
                                                            {{--@foreach($rm_terr as $terr)--}}
                                                                {{--<option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="am_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>AM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">AM Territory</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($am_terr as $terr)
                                        
                                                                <option value="{{$terr->am_terr_id}}">
                                                                    {{$terr->am_terr_id}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">MPO Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



                                            {{--<div class="form-group">--}}
                                            <div class=" col-md-1 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display_dmr" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                                </button>
                                                {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
                                            </div>

                                        </div>


                                    @endif

                                    @if(Auth::user()->desig === 'GM' ||Auth::user()->desig === 'AGM' || Auth::user()->desig === 'NSM' || Auth::user()->desig === 'SM' ||
                                                Auth::user()->desig === 'DSM' || Auth::user()->desig === 'All')


                                        <div class="row">


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="bgt_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                    <div class="col-md-8">
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

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="gl"
                                                           class="col-md-4 col-sm-6 control-label"><b>GL</b></label>
                                                    <div class="col-md-8">
                                                        <select name="gl" id="gl"
                                                                class="form-control input-sm">
{{--                                                            <option value="ALL">ALL</option>--}}

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cc"
                                                           class="col-md-4 col-sm-6 control-label"><b>Cost Cent</b></label>
                                                    <div class="col-md-8">
                                                        <select name="cc" id="cc"
                                                                class="form-control input-sm">
                                                            <option value="ALL">ALL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- First row ends here--}}

                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($rm_terr as $terr)
                                                            <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="am_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>AM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">AM Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">MPO Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



                                            {{--<div class="form-group">--}}
                                            <div class=" col-md-1 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display_dmr" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                                </button>
                                                {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
                                            </div>

                                        </div>


                                    @endif




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
                            <table id="summary_table" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Budget Mon</th>
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

    {{--This code area is for showing loader image--}}
    <div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
        <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/processing.gif')}}"
                     alt="Loading Report Please wait..."><br>
            </div>
        </div>
    </div>
    {{--This code area is for showing loader image ends here--}}

    {{--Modal starts from here--}}

    <div class="row" id="detail-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detail_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th style="text-align: center"><input type="checkbox" id="selectAll"><span> </span>All</th>
                                    <th>Action</th>
                                    <th>Req Id</th>
                                    <th>Ter ID</th>
                                    <th>Doc Id</th>
                                    <th>Doc Name</th>
                                    <th>P Code</th>
                                    <th>P Name</th>
                                    <th>qty</th>
                                    <th>App qty</th>
                                    <th>SP</th>
                                    <th>Tot_Val</th>

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

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">


            {{ csrf_field() }}

            <div class="modal-content">
                <!-- <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Form Tittle</h4>
                </div> -->


                <div class="modal-body">

                    <input type="hidden" class="form-control" id="line_id" name="line_id">

                    <div class="form-horizontal">
                        <form role="form" id="edfrm">

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="col-md-12">
                                        <section class="panel panel-info" id="data_table">
                                            <header class="panel-heading">
                                                <label class="text-default">
                                                    Medicine Requisition
                                                </label>
                                                <button aria-hidden="true"
                                                        style="background-color: red; opacity: initial"
                                                        data-dismiss="modal" class="close" type="button">×
                                                </button>
                                            </header>

                                            <div class="panel-body">


                                                <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="p_code"
                                                                   class="col-md-6 col-sm-6 control-label"><b>Product Code</b></label>
                                                            <div class="col-md-6">
                                                                <input class="form-control input-sm" name="p_code"
                                                                       id="p_code" autocomplete="off" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="apr_amount"
                                                                   class="col-md-6 col-sm-6 control-label"><b>Approved Quantity</b></label>
                                                            <div class="col-md-6">
                                                                <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control input-sm" name="apr_amount"
                                                                       id="apr_amount" autocomplete="off">

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="sp_amount"
                                                                   class="col-md-6 col-sm-6 control-label fnt_size"><b>SP Value</b></label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <input type="number" min="1"
                                                                       class="form-control input-sm" name="sp_amount"
                                                                       id="sp_amount" autocomplete="off" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">


                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="total_amount"
                                                                   class="col-sm-6 col-md-6 control-label fnt_size"><b>Total Value</b></label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <input type="number" min="1"
                                                                       class="form-control input-sm" name="total_amount"
                                                                       id="total_amount" autocomplete="off" disabled>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>


                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="update">Submit</button>
                            </div>
                        </form>
                    </div>

                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                    {{--<button type="submit" class="btn btn-primary" >Submit</button>--}}
                    {{--</div>--}}
                </div>
            </div>


        </div>


    </div>
    @include('donation.modal.delete_medicine_requisition_modal')
    {{--Modal ends here--}}
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

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


    <script type="text/javascript">

        $(document).ready(function () {

            var gl_cc = "{{url('dmr/gl_cc_dmr')}}";
            var fetch_mpo = "{{url('dmr/fetch_mpo_dmr')}}";
            var fetch_am = "{{url('dmr/fetch_am_dmr')}}";
            var display_data_dmr = "{{url('dmr/display_data_for_dmr_verification')}}";
            var verify_row_dmr = "{{url('dmr/verify_row_dmr')}}";
            var delete_row_dmr = "{{url('dmr/delete_row_dmr')}}";
            var update_row = "{{url('dmr/update_row_dmr')}}"
            var table;
            var table2;
            var row_html = '';
            var del_row_id = '';
            var verifydata = [];

            log_desig = '{{Auth::user()->desig}}';
            _csrf_token = '{{csrf_token()}}';


            $("#apr_amount").on('change', function (e) {
                e.preventDefault();
                var total_pcode = $('#sp_amount').val() * $('#apr_amount').val();
                $('#total_amount').val(total_pcode.toFixed(2));

            });

            $('form#edfrm').on('click', '#update', function (e) {
                e.preventDefault();
                // $( "#update").unbind( "click" );

                var req_no = '';
                var prod_code = '';
                var approved_quant = '';
                var total_value = '';

                req_no = $('#line_id').val();
                prod_code = $('#p_code').val();
                approved_quant = $('#apr_amount').val();
                total_value = $('#total_amount').val();

                console.log(req_no);
                console.log(prod_code);
                console.log(approved_quant);
                console.log(total_value);


                if ($('#apr_amount').val() == '' || parseInt($('#apr_amount').val()) < 1) {
                    alert('Invalid Quantity !!! ');
                }
                else if ($('#total_amount').val() == '') {
                    alert('Total can not be empty !!! ');
                }
                else {

                    $.ajax({
                        type: "post",
                        url: update_row,
                        dataType: 'json',
                        data: {
                            req_no: req_no,
                            approved_quant: approved_quant,
                            prod_code: prod_code,
                            total_value: total_value,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            row_html.find('.app_quant').html(approved_quant);
                            row_html.find('.total_value').html(total_value);

                            toastr.success("updated successfully");
                            //Code for closing modal on click of update button of modal
                            $(function () {
                                $('#myModal').modal('toggle');
                            });
                            //Code for closing modal on click of update button of modal ends here


                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error updating row");
                        }
                    });

                }


            });


            $("#rm_terr").on('change', function () {
                //$("#rm_terr").live("change", function() {
                var rm_terr = $("#rm_terr").val();
                $("#mpo_terr").html('');

                console.log(rm_terr);

                if (rm_terr == 'ALL') {
                    console.log('In Loop');

                    $('#am_terr').empty().append("<option value='ALL'>ALL</option>");
                    $('#mpo_terr').empty().append("<option value='ALL'>ALL</option>");
                }
                else {
                    $.ajax({
                        type: "GET",
                        url: fetch_am,
                        dataType: 'json',
                        data: {rmTerr: rm_terr},
                        success: function (response) {
                            console.log(response);

                            var selOptsAM = "";
                            selOptsAM += "<option value=''>Select Territory</option>";
                            selOptsAM += "<option value='ALL'>ALL</option>";
                            for (var i = 0; i < response.length; i++) {
                                var id = response[i]['am_terr_id'];
                                var val = response[i]['am_terr_id'];

                                selOptsAM += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#am_terr').html(selOptsAM);

                            var selOptsRM = "";
                            for (var d = 0; d < 1; d++) {
                                var idj = response[d]['rmsm_name'];
                                var valj = response[d]['rmsm_name'];

                                selOptsRM += "<option value='" + idj + "'>" + valj + "</option>";
                            }

                            $('#smrm_name').html(selOptsRM);


                            var selOptsRMid = "";
                            for (var l = 0; l < response.length; l++) {
                                var idl = response[l]['rmsm_id'];
                                var vall = response[l]['rmsm_id'];

                                selOptsRMid += "<option value='" + idl + "'>" + vall + "</option>";
                            }
                            $('#smrm_id').html(selOptsRMid);

                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }


            });

            $("#am_terr").on('change', function () {

                var rm_terr = $("#rm_terr").val();
                var am_terr = $("#am_terr").val();
                console.log(rm_terr);
                console.log(am_terr);
                $("#mpo_terr").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "GET",
                    url: fetch_mpo,
                    dataType: 'json',
                    data: {amTerr: am_terr, rmTerrId: rm_terr},
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        selOptsMPO += "<option value=''>Select Territory</option>";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['mpo_terr_id'];
                            var val = response[j]['mpo_terr_id'];
                            selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#mpo_terr').empty().append(selOptsMPO);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $('#bgt_month').on('change', function () {
                console.log('budget month changed');
                var month = $('#bgt_month').val();
                console.log(month);
                $("#gl").empty().append("<option value=''>Loading...</option>");
                $("#cc").empty().append("<option value=''>Loading...</option>");
                $.ajax({
                    method: 'post',
                    url: gl_cc,
                    dataType: 'json',
                    data: {mon: month, _token: _csrf_token},
                    success: function (response) {
                        console.log('query successful');
                        console.log(response);
                        var selOptsGL = "";
                        // selOptsGL += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response['gl'].length; j++) {
                            var id = response['gl'][j]['gl'];
                            var val = response.gl[j].gl;

                            selOptsGL += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#gl').empty().append(selOptsGL);


                        var selOptsCC = "";
                        selOptsCC += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response['cc'].length; j++) {
                            var id = response['cc'][j]['cost_center_id'];
                            var val = response['cc'][j]['cost_center_group'];

                            selOptsCC += "<option value='" + id + "'>"+ id + ' - ' + val + "</option>";
                        }
                        $('#cc').empty().append(selOptsCC);

                    }

                });
            });

            $('#detail_list tbody').on('click', '.edit-btn', function () {
                console.log(' .edit-btn button clicked');
                var line_id = '';
                line_id = table2.row($(this).parents('tr')).data()['req_id'];
                row_html = $(this).closest('tr');
                // console.log(row_html.html(500));

                // var line_id = $(this).closest('tr').find('.req').text();
                console.log(line_id);

                $("#myModal").modal('show');

                $(".modal-body #line_id").val(line_id);


                //codes for showing the already inputted value in modal
                $('#p_code').val(table2.row($(this).parents('tr')).data()['p_code']);
                $('#apr_amount').val(table2.row($(this).parents('tr')).data()['app_qty']);
                $('#sp_amount').val(table2.row($(this).parents('tr')).data()['s_p']);
                $('#total_amount').val(table2.row($(this).parents('tr')).data()['tot_val']);
                //This portion is for selecting mode of payment

                // the first option value in select tag

                // portion for selecting mode of payment ends here

                // $('#inf_of').val(table.row($(this).parents('tr')).data()['in_favour_of']);


            });

            // $(document).on('change',".change_quantity",function () {
            //     console.log('this function has been triggered');
            //     var tblData = table2.rows('.selected').data();
            //                     var celldata ='';
            //                     verifydata.length = 0;
            //
            //                     $.each(tblData, function (i, val) {
            //                         tmpData = tblData[i];
            //                         // console.log(tmpData.tot_val);
            //
            //                         celldata= table2.cell(i,8).nodes().to$().find('input').val();
            //                         // console.log(celldata);
            //                         tmpData.tot_val = celldata.toString().toUpperCase();
            //                         tmpData.tot_val.val(celldata.toString().toUpperCase());
            //                         // del_row_id = table2.rows('.selected');
            //                         // console.log(del_row_id);
            //                         // del_row_id.draw();
            //
            //                         // console.log(tmpData.tot_val);
            //                         // console.log(tmpData);
            //                         verifydata.push(tmpData);
            //                     });
            // });


            $("#btn_display_dmr").click(function () {

                del_row_id = '';
                if ($("#rm_terr").val() === "") {
                    alert("Please select RM");
                }
                else if ($("#am_terr").val() === "") {
                    alert("Please select AM");
                }
                else if ($("#mpo_terr").val() === "") {
                    alert("Please select MPO");
                }

                else if ($("#bgt_month").val() === "") {
                    alert("Please select Month");
                }
                else {
                    if ($("#report-body").is(":visible")) {
                        $("#report-body").hide();
                    }

                    var mont = $("#bgt_month").val();
                    var gl = $("#gl").val();
                    var cc = $("#cc").val();
                    var rm_terr = $("#rm_terr").val();
                    var am_terr = $("#am_terr").val();
                    var mpo_id = $('#mpo_terr').val();

                    console.log(rm_terr);
                    console.log(am_terr);
                    console.log(mpo_id);

                    $("#loader").show();
                    $.ajax({
                        url: display_data_dmr,
                        method: "post",    // change here for post method
                        dataType: 'json',

                        data: {
                            _token: _csrf_token, // include it in data section
                            rmTerrId: rm_terr,
                            amTerr: am_terr,
                            mpoId: mpo_id,
                            mont: mont,
                            gl: gl,
                            cc: cc

                        },

                        success: function (resp) {
                            // $("#balance_section").show();
                            console.log(resp);
                            // console.log(resp['balance'][0]);
                            console.log(resp.length);

                            $("#loader").hide();
                            $("#report-body").show();
                            // aria-hidden="true"
                            $("#summary_table").DataTable().destroy();

                            table = $("#summary_table").DataTable({
                                data: resp['summary_data'],

                                columns: [
                                    {data: "req_month"},
                                    {data: "gl"},
                                    {data: "cost_center_id"},
                                    {data: "cost_center_name"},
                                    {data: "tot_req_qty"},
                                    {data: "tot_req_amt"},
                                    {data: "total_budget"},
                                    {data: "exp_req_amt"},
                                    {data: "available_budget"}
                                ],
                                order: [[2, 'asc'], [5, 'asc']],
                                "searching": false,
                                "scrollY": "450px",
                                "scrollX": true,
                                "scrollCollapse": true,
                                "paging": false,
                                "info": false,

                                fixedHeader: true

                            });
                            // $("div.toolbar").html('Total number of requests: ' + resp['resp_data'].length);

                            $("#detail-body").show();

                            //
                            $("#detail_list").DataTable().destroy();
                            table2 = $("#detail_list").DataTable({
                                data: resp['detail_data'],
                                dom: '<"toolbar">Bfrtip',
                                buttons: [
                                    {
                                        text: '<span class="accept" >Aprrove</span>', className: "btn-primary",
                                        action: function (e, dt, node, config) {
                                            // data table row select
                                            var tblData = table2.rows('.selected').data();

                                            // $(this).find('td:eq(1)').html();
                                            // var tblData = table2.columns('.selected').data();
                                            console.log(tblData);
                                            var tmpData = '';

                                            verifydata.length = 0;

                                            $.each(tblData, function (i, val) {
                                                tmpData = tblData[i];
                                                verifydata.push(tmpData);
                                                // console.log(tmpData);
                                                //alert(tmpData);
                                            });

                                            console.log(verifydata);

                                            if (verifydata.length !== 0) {

                                                $.ajax({
                                                    type: "POST",
                                                    dataType: 'json',
                                                    data: {
                                                        verifyData: JSON.stringify(verifydata),
                                                        mont: mont,
                                                        _token: _csrf_token
                                                    },
                                                    url: verify_row_dmr,
                                                    beforeSend: function () {
                                                        // Show image container
                                                        // $("#report-body").hide();
                                                        $("#loader").show();
                                                    },
                                                    success: function (data) {
                                                        console.log("data " + data);
                                                        if (data.error) {
                                                            toastr.error(data.error, '', {timeOut: 5000});
                                                        } else if (data.success) {
                                                            toastr.success(data.success, '', {timeOut: 5000});
                                                        }

                                                        // setTimeout(function(){// wait for 3 secs
                                                        //     window.location.reload(); // then reload the page
                                                        // }, 3000);

                                                    },
                                                    complete: function (data) {
                                                        // Hide image container
                                                        $("#loader").hide();
                                                    },
                                                    error: function (err) {
                                                        console.log(err);
                                                    }
                                                });
                                            }
                                        }
                                    },
                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                                        }
                                    },
                                    {
                                        text: '<span class="accept" >Delete</span>', className: "btn-danger",
                                        action: function (e, dt, node, config) {

                                            if (table2.rows('.selected').data().length > 0) {
                                                $('.deleteRequisitioin').modal('show');
                                            }


                                        }
                                    },


                                    // {
                                    //     extend: 'excelHtml5', className: "btn-warning",
                                    //     exportOptions: {
                                    //         columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24]
                                    //     }
                                    // }
                                ],
                                columns: [

                                    {data: null},
                                    {
                                        data: null,

                                        "render": function (row) {

                                            return "<button type='button' class='btn btn-warning btn-xs edit-btn' id='edit'><span class='glyphicon glyphicon-edit'></span>   </button>";


                                        }

                                    },
                                    {data: "req_id"},
                                    {data: "terr_id"},
                                    {data: "doctor_id"},
                                    {data: "doctor_name"},
                                    {data: "p_code"},
                                    {data: "product_name"},
                                    {data: "qty"},
                                    //                             {data: null,
                                    //                                 "render": function (row) {
                                    //                                     // console.log(row);
                                    //                                     // return    '<button type="button" class="form-control datePicker">' + row.ssd_due_date  +   '</button>';
                                    // return    '<input type="number" min="1" oninput="validity.valid||(value=\'\');" style="text-align: center;" class="change_quantity" value="' + row.app_qty + '"  />';
                                    //
                                    //                                 }
                                    //                             },
                                    {data: "app_qty", className: 'app_quant'},
                                    {data: "s_p"},
                                    {data: "tot_val", className: 'total_value'}

                                ],

                                // fixedHeader: {
                                //     header: true,
                                //     headerOffset: $('#fix').height()
                                // },
                                language: {
                                    "emptyTable": "No Matching Records Found."
                                },
                                columnDefs: [{
                                    orderable: false,
                                    className: 'select-checkbox',
                                    targets: 0,
                                    render: function (data, type, full, meta) {

                                        // console.log(data);
                                        return '';
                                    }
                                }],

                                select: {
                                    style: 'multi',
                                    selector: 'td:first-child'
                                },
                                order: [
                                    [1, 'asc']
                                ],
                                info: false,
                                paging: false,
                                // filter: true,
                                "scrollY": "450px",
                                "scrollX": true,

                            });

                        },
                        error: function (err) {
                            console.log(err);
                            $("#loader").hide();
                            $("#report-body").show();
                        }
                    });
                }

            });

            $('#selectAll').on('click', function () {

                if (table2.rows('.selected').any()) {
                    table2.rows().deselect();
                    $("#selectAll").prop("checked", false);
                } else {
                    table2.rows().select();
                }
            });

            $('.del-modal-requisition').click(function () {
                console.log('modal delete button clicked');

                // data table row select
                var tblData = table2.rows('.selected').data();
                var tmpData = '';

                verifydata.length = 0;

                $.each(tblData, function (i, val) {
                    tmpData = tblData[i];
                    verifydata.push(tmpData);
                    // console.log(tmpData);
                    //alert(tmpData);
                });

                console.log(verifydata);

                if (verifydata.length !== 0) {

                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            verifyData: JSON.stringify(verifydata),
                            _token: _csrf_token
                        },
                        url: delete_row_dmr,
                        beforeSend: function () {
                            // Show image container
                            // $("#report-body").hide();
                            $("#loader").show();
                        },
                        success: function (data) {
                            $('.deleteRequisitioin').modal('hide');
                            del_row_id = table2.rows('.selected');
                            console.log(del_row_id);
                            del_row_id.remove().draw();


                            // updateTable();// For reloading the updated table after verifying data
                            console.log("data " + data);
                            if (data.error) {
                                toastr.error(data.error, '', {timeOut: 5000});
                            } else if (data.success) {
                                toastr.success(data.success, '', {timeOut: 5000});
                            }
                        },
                        complete: function (data) {
                            // Hide image container
                            $("#loader").hide();
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                }


            });

            $(".toggle-btn").click(function () {
                table.columns.adjust();
                table2.columns.adjust();
            });

        }
);
    </script>

@endsection