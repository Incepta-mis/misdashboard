@extends('_layout_shared._master')
@section('title','Requisition Approval')
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

        .btn1:hover{
            cursor: pointer;
        }

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Requisition Approval
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    @if(Auth::user()->desig === 'GM' || Auth::user()->desig === 'All'||Auth::user()->desig === 'HO')

                                        <div class="row">



                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="gl"
                                                           class="col-md-4 control-label"><b>GL</b></label>
                                                    <div class="col-md-8">
                                                        <select name="gl" id="gl"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select GL</option>--}}
                                                            <option value="ALL" data-glname="ALL">ALL</option>
                                                            @foreach($gl as $gln)
                                                                <option value="{{$gln->gl_cat}}" data-glname="{{$gln->main_cost_center_name}}">{{$gln->main_cost_center_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="padding-left: 0px">
                                                <div class="form-group">
                                                    <label for="don_type" class="col-md-4 col-sm-6 control-label"><b>
                                                            Type</b></label>
                                                    <div class="col-md-8">
                                                        <select name="don_type" id="don_type"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Expense Type</option>--}}
                                                            <option value="ALL">ALL</option>
                                                            @foreach($dtm as $tm)
                                                                <option value="{{$tm->type_name}}"
                                                                        data-tpn="{{$tm->type_name}}" data-brn="{{$tm->type}}"data-gl="{{$tm->gl}}">{{$tm->type_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="cc"
                                                           class="col-md-3 col-sm-6 control-label"><b>Cost</b></label>
                                                    <div class="col-md-9">
                                                        <select name="cc" id="cc"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Cost Center</option>--}}
                                                            <option value="">Cost Center</option>
                                                            <option value="ALL">ALL</option>
                                                            {{--@foreach($cc as $ccn)--}}
                                                            {{--@if($ccn->sub_cost_center_id=='')--}}
                                                            {{--<option value="{{$ccn->cost_center_id}}">--}}
                                                            {{--{{$ccn->cost_center_id}}-{{$ccn->sub_cost_center_id}}-{{$ccn->sub_cost_center_name}}</option>--}}

                                                            {{--@else--}}
                                                            {{--<option value="{{$ccn->sub_cost_center_id}}">--}}
                                                            {{--{{$ccn->cost_center_id}}-{{$ccn->sub_cost_center_id}}-{{$ccn->sub_cost_center_name}}</option>--}}

                                                            {{--@endif--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cc"
                                                           class="col-md-2 col-sm-6 control-label"><b>Subcost</b></label>
                                                    <div class="col-md-10">
                                                        <select name="scc" id="scc"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Subcost Center</option>--}}
                                                            <option value="">Subcost Center</option>
                                                            <option value="ALL">ALL</option>
                                                            {{--@foreach($cc as $ccn)--}}
                                                            {{--@if($ccn->sub_cost_center_id=='')--}}
                                                            {{--<option value="{{$ccn->cost_center_id}}">--}}
                                                            {{--{{$ccn->cost_center_id}}-{{$ccn->sub_cost_center_id}}-{{$ccn->sub_cost_center_name}}</option>--}}

                                                            {{--@else--}}
                                                            {{--<option value="{{$ccn->sub_cost_center_id}}">--}}
                                                            {{--{{$ccn->cost_center_id}}-{{$ccn->sub_cost_center_id}}-{{$ccn->sub_cost_center_name}}</option>--}}

                                                            {{--@endif--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>

                                        <div class="row">

                                            <div class="col-md-2">
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
                                                    <label for="rm_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>Region</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Territory</option>--}}
                                                            <option value="ALL">ALL</option>
                                                            @foreach($rm_terr as $terr)
                                                            <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="amount"
                                                           class="col-md-2 col-sm-6 control-label"><b>Amount</b></label>
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
                            <table id="req_ccwise" class="table table-condensed table-striped table-bordered"
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

    {{-- Requisition details based on cost center which will open on click of cost center name --}}
    {{--<div class="row" id="detail-body" style="display: none;">--}}
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
                                    <th>Ter ID</th>
                                    <th>Brand/Region</th>
                                    <th>Ben Id</th>
                                    <th>Ben Name</th>
                                    {{--<th>Inf Of</th>--}}
                                    <th>Pay Mode</th>
                                    <th>Appr Amt</th>
                                    <th>Frequency</th>
                                    {{--<th>SSD Due Dt</th>--}}
                                    <th>ACP</th>
                                    <th>ACMP</th>
                                    <th>ACYP</th>
                                    <th>Req Id</th>

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

    @include('donation.modal.delete_requisition')
    @include('donation.modal.showLastThree')

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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    {{Html::script('public/site_resource/js/donation_script/agm_gm_script.js')}}


    <script type="text/javascript">

        servloc = "{{url('donation/ccwiswe_req_data_agm')}}";
        det_table = "{{url('donation/detail_table_fetch_agm')}}";
        verify_agm = "{{url('donation/verify_agm')}}";
        eid = "{{Auth::user()->user_id}}";
        desig = "{{Auth::user()->desig}}";
        _csrf_token = '{{csrf_token()}}';
        get_cc = "{{url('donation/get_cc')}}";
        get_scc = "{{url('donation/get_scc')}}";
        delete_row_gm = "{{url('donation/delete_row_gm')}}";
        {{--get_don_type = "{{url('donation/get_don_type')}}";--}}
        get_BrandBy_docId = "{{url('donation/get_BrandBy_docId')}}";

    </script>

@endsection