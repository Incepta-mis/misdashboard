@extends('_layout_shared._master')
@section('title','Doctor Wise Item Utilization')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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

        body{
            color: black;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Doctor Wise Item Utilization
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                <b>Product Group:</b></label>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <select name="p_group" id="p_group" class="form-control input-sm">
                                    @foreach($pgrp as $grp)
                                        <option value="{{$grp->product_group}}">{{$grp->product_group}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if(Auth::user()->desig === 'RM')
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm"
                                       for="rm_terr" style="width: 12%;">
                                    <b>Region Id:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="rm_terr" id="rm_terr" class="form-control input-sm" disabled>
                                        <option value="{{Auth::user()->terr_id}}">{{Auth::user()->terr_id}}</option>
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                       for="am_terr">
                                    <b>AM Terr Id:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="am_terr" id="am_terr" class="form-control input-sm">
                                        <option value="All">All</option>
                                        @forelse($am_terr as $atid)
                                            <option value="{{$atid->am_terr_id}}">{{$atid->am_terr_id}}</option>
                                        @empty
                                            <option value="dummy">.......</option>
                                        @endforelse
                                    </select>
                                </div>
                            @endif

                            @if(Auth::user()->desig === 'AM')
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                       for="rm_terr">
                                    <b>Region Id:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="rm_terr" id="rm_terr" class="form-control input-sm" disabled>
                                        @forelse($rm_terr as $rterr)
                                            <option value="{{$rterr->rm_terr_id}}">{{$rterr->rm_terr_id}}</option>
                                        @empty
                                            <option value="dummy">.......</option>
                                        @endforelse
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                       for="am_terr">
                                    <b>AM Terr Id:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="am_terr" id="am_terr" class="form-control input-sm" disabled>
                                        <option value="{{$am_terr}}">{{$am_terr}}</option>
                                    </select>
                                </div>
                            @endif

                            @if(Auth::user()->desig === 'GM' || Auth::user()->desig === 'NSM' || Auth::user()->desig === 'SM' ||
                                Auth::user()->desig === 'DSM' || Auth::user()->desig === 'ASM'|| Auth::user()->desig === 'All'||
                                Auth::user()->desig === 'HO')

                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                       for="rm_terr">
                                    <b>Region Id:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="rm_terr" id="rm_terr" class="form-control input-sm">
                                        @forelse($rm_terr as $rterr)
                                            <option value="{{$rterr->rm_terr_id}}">{{$rterr->rm_terr_id}}</option>
                                        @empty
                                            <option value="dummy">.......</option>
                                        @endforelse
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                       for="am_terr">
                                    <b>AM Terr Id:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="am_terr" id="am_terr" class="form-control input-sm">
                                        <option value="All">All</option>
                                        @forelse($am_terr as $atid)
                                            <option value="{{$atid->am_terr_id}}">{{$atid->am_terr_id}}</option>
                                        @empty
                                            <option value="dummy">.......</option>
                                        @endforelse
                                    </select>
                                </div>
                            @endif


                        </div>
                        <div class="form-group">

                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm"
                                   for="terr_id">
                                <b>Territory Id:</b></label>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <select name="terr_id" id="terr_id" class="form-control input-sm">
                                    @foreach($terr as $tr)
                                        <option value="{{$tr->terr_id}}">{{$tr->terr_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%"
                                   for="doc_list">
                                <b>Doctor Name:</b></label>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <select name="doctor_list" id="doctor_list" class="form-control input-sm">
                                    <option value="All">All</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="date_from">
                                <b>Date From:</b></label>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <div class="input-group">
                                    <input type="text" id="date_from" class="form-control input-sm">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                   for="date_to">
                                <b>Date To:</b></label>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <div class="input-group">
                                    <input type="text" id="date_to" class="form-control input-sm">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                            </div>
                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                <div  id="export_buttons">

                                </div>
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
                <img src="{{url('public/site_resource/images/preloader.gif')}}" width="35px" height="35px"
                     alt="Loading Report Please wait..."><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>
    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body table-responsive">
                        <table id="dwiu_tab" class="table table-condensed table-striped table-bordered"
                               width="100%">
                            <thead style="white-space:nowrap;">
                            <tr>
                                <th>Product Group</th>
                                <th>Territory Id</th>
                                <th>Employee Id</th>
                                <th>Employee Name</th>
                                <th>Doctor ID</th>
                                <th>Doctor Name</th>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Qty Utilized</th>
                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;"></tbody>
                            <tfoot>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            </tfoot>
                        </table>
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
    {{Html::script('public/site_resource/js/dcr_scripts/dwiu_script2.js')}}
    <script>
        servloc = "{{url('dcrep/resp_dwiu_rep')}}";
        servloc_t = "{{url('dcrep/resp_td_id')}}";
        eid = "{{Auth::user()->user_id}}";desig = "{{Auth::user()->desig}}";
        loc_rterr = "{{url('dcrep/resp_terr_list')}}";
    </script>
@endsection
