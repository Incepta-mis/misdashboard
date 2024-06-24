@extends('_layout_shared._master')
@section('title','Requisition Verification')
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
                        Requisition Verification
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 0px">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

                                    @if(Auth::user()->desig === 'HO')

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>Region</b></label>
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
                                                    <label for="rm_terr"
                                                           class="col-md-3 col-sm-6 control-label"><b>
                                                            Name</b></label>
                                                    <div class="col-md-9">

                                                        <select name="smrm_name" id="smrm_name"
                                                                class="form-control input-sm">
                                                            <option value="">RM Name
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            {{--<select name="smrm_name" id="smrm_name"--}}
                                            {{--class="form-control input-sm" disabled>--}}

                                            {{--It has benn hidden..  it has been kept to retrieve the rm/asm id to get the list of Mpo terr id  --}}

                                            <div class="col-md-4" style="display: none">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>RM/ASM
                                                            ID:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="smrm_id" id="smrm_id"
                                                                class="form-control input-sm" disabled>
                                                            <option value="{{Auth::user()->user_id}}">{{Auth::user()->user_id}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
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

                                            <div class="col-md-2 col-sm-2 col-xs-6">
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

                                            {{-- First row ends here--}}

                                        </div>

                                        <div class="row">


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">MPO Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3" style="display: none;">
                                                <div class="form-group">
                                                    <label for="team"
                                                           class="col-md-4 col-sm-6 control-label"><b>Team</b></label>
                                                    <div class="col-md-8">
                                                        <select name="team" id="team"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Team</option>--}}
                                                            {{--<option value="ALL">ALL</option>--}}
                                                            {{--<option value="SALES">SALES</option>--}}
                                                            <option value="MSD">MSD</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="don_typ"
                                                           class="col-md-3 col-sm-6 control-label"><b>Type</b></label>
                                                    <div class="col-md-9">
                                                        <select name="don_typ" id="don_typ"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Donation Type</option>--}}
                                                            <option value="">Donation Type</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($don_type as $dt)
                                                                <option value="{{$dt->type_name}}">{{$dt->type_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="brand_name"
                                                           class="col-md-4 col-sm-6 control-label"><b>Brand/Region</b></label>
                                                    <div class="col-md-8">
                                                        {{--<select name="brand_name" id="brand_name"--}}
                                                        {{--class="form-control input-xs select2_search">--}}
                                                        <select name="brand_name" id="brand_name"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="ALL">ALL</option>
                                                            {{--@foreach($brand_name as $bn)--}}
                                                            {{--<option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="frequency"
                                                           class="col-md-3 col-sm-6 control-label"><b>Frequency</b></label>
                                                    <div class="col-md-9">
                                                        <select name="frequency" id="frequency"
                                                                class="form-control input-sm">
                                                            <option value="ALL">ALL</option>
                                                            @foreach($freq as $dt)
                                                                <option value="{{$dt->df_description}}">{{$dt->df_description}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            {{--<div class="form-group">--}}
                                            <div class=" col-md-1 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
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
                                                    <label for="rm_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>Region</b></label>
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
                                                    <label for="rm_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>
                                                            Name</b></label>
                                                    <div class="col-md-8">

                                                        <select name="smrm_name" id="smrm_name"
                                                                class="form-control input-sm">
                                                            <option value="">RM Name
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            {{--<select name="smrm_name" id="smrm_name"--}}
                                            {{--class="form-control input-sm" disabled>--}}

                                            {{--It has benn hidden..  it has been kept to retrieve the rm/asm id to get the list of Mpo terr id  --}}

                                            <div class="col-md-4" style="display: none">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>RM/ASM
                                                            ID:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="smrm_id" id="smrm_id"
                                                                class="form-control input-sm" disabled>
                                                            <option value="{{Auth::user()->user_id}}">{{Auth::user()->user_id}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="am_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>AM
                                                            Territory</b></label>
                                                    <div class="col-md-6">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">AM Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-sm-2 col-xs-6">
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

                                            {{-- First row ends here--}}

                                        </div>

                                        <div class="row">


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr" class="form-control input-sm">
                                                            <option value="">MPO Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3" style="display: none;">
                                                <div class="form-group">
                                                    <label for="team"
                                                           class="col-md-4 col-sm-6 control-label"><b>Team</b></label>
                                                    <div class="col-md-8">
                                                        <select name="team" id="team"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Team</option>--}}
                                                            <option value="ALL">ALL</option>
                                                            {{--<option value="SALES">SALES</option>--}}
{{--                                                            <option value="MSD">MSD</option>--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="don_typ"
                                                           class="col-md-3 col-sm-6 control-label"><b>Type</b></label>
                                                    <div class="col-md-9">
                                                        <select name="don_typ" id="don_typ"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Donation Type</option>--}}
                                                            <option value="">Donation Type</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($don_type as $dt)
                                                                <option value="{{$dt->type_name}}">{{$dt->type_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="brand_name"
                                                           class="col-md-6 col-sm-6 control-label"><b>Brand/Region</b></label>
                                                    <div class="col-md-6">
                                                        {{--<select name="brand_name" id="brand_name"--}}
                                                        {{--class="form-control input-xs select2_search">--}}
                                                        <select name="brand_name" id="brand_name"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="ALL">ALL</option>
                                                            {{--@foreach($brand_name as $bn)--}}
                                                            {{--<option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            {{--<div class="form-group">--}}
                                            <div class=" col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check" aria-hidden="true"></i><b>Display Data</b>
                                                </button>
                                                {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
                                            </div>
                                            {{--<div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">--}}
                                            {{--<div id="export_buttons">--}}

                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}


                                        </div>





                                        {{--<div class="form-group">--}}
                                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                        {{--<button type="button" id="btn_display" class="btn btn-default btn-sm">--}}
                                        {{--<i class="fa fa-check" aria-hidden="true"></i><b>Display Data</b></button>--}}
                                        {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">--}}
                                        {{--<div id="export_buttons">--}}

                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                    @endif

                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM')

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Region</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" readonly="">
                                                            @if(Auth::user()->desig !== 'MPO' && Auth::user()->desig !== 'AM')
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
                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                            Id</b></label>
                                                    <div class="col-md-6">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm"
                                                        >
                                                            <option value="">Select Territory</option>
                                                            <option value='ALL'>ALL</option>
                                                            @foreach($am_terr as $terr)
                                                                <option value="{{$terr->am_terr_id}}">
                                                                    {{$terr->am_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                            Id</b></label>
                                                    <div class="col-md-6">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">


                                            <div class="col-md-3 col-sm-2 ">
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

                                            <div class="col-md-3" style="display: none;">
                                                <div class="form-group">
                                                    <label for="team"
                                                           class="col-md-4 col-sm-6 control-label"><b>Team</b></label>
                                                    <div class="col-md-8">
                                                        <select name="team" id="team"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Team</option>--}}
                                                            <option value="ALL">ALL</option>
                                                            {{--<option value="SALES">SALES</option>--}}
                                                            {{--                                                            <option value="MSD">MSD</option>--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="don_typ"
                                                           class="col-md-3 col-sm-6 control-label"><b>Type</b></label>
                                                    <div class="col-md-9">
                                                        <select name="don_typ" id="don_typ"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Donation Type</option>--}}
                                                            <option value="">Donation Type</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($don_type as $dt)
                                                                <option value="{{$dt->type_name}}">{{$dt->type_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="brand_name"
                                                           class="col-md-6 col-sm-6 control-label"><b>Brand/Region</b></label>
                                                    <div class="col-md-6">
                                                        {{--<select name="brand_name" id="brand_name"--}}
                                                        {{--class="form-control input-xs select2_search">--}}
                                                        <select name="brand_name" id="brand_name"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="ALL">ALL</option>
                                                            {{--@foreach($brand_name as $bn)--}}
                                                            {{--<option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class=" col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_display"
                                                            class="btn btn-default btn-sm">
                                                        <i class="fa fa-check"></i> <b>Display</b></button>
                                                </div>
                                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                    <div id="export_buttons">

                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        {{--<div class="form-group">--}}
                                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                        {{--<button type="button" id="btn_display" class="btn btn-default btn-sm">--}}
                                        {{--<i class="fa fa-check"></i> <b>Display</b></button>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">--}}
                                        {{--<div id="export_buttons">--}}

                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                    @endif

                                    @if(Auth::user()->desig === 'AM')
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Region</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" disabled>
                                                            @if(Auth::user()->desig !== 'MPO' && Auth::user()->desig !== 'AM')
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
                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
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
                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
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


                                        </div>

                                        <div class="row">


                                            <div class="col-md-3 col-sm-2 ">
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

                                            <div class="col-md-3" style="display: none;">
                                                <div class="form-group">
                                                    <label for="team"
                                                           class="col-md-4 col-sm-6 control-label"><b>Team</b></label>
                                                    <div class="col-md-8">
                                                        <select name="team" id="team"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Select Team</option>--}}
                                                            <option value="ALL">ALL</option>
                                                            {{--<option value="SALES">SALES</option>--}}
                                                            {{--                                                            <option value="MSD">MSD</option>--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="don_typ"
                                                           class="col-md-3 col-sm-6 control-label"><b>Type</b></label>
                                                    <div class="col-md-9">
                                                        <select name="don_typ" id="don_typ"
                                                                class="form-control input-sm">
                                                            {{--<option value="">Donation Type</option>--}}
                                                            <option value="">Donation Type</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($don_type as $dt)
                                                                <option value="{{$dt->type_name}}">{{$dt->type_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="brand_name"
                                                           class="col-md-6 col-sm-6 control-label"><b>Brand/Region:</b></label>
                                                    <div class="col-md-6">
                                                        {{--<select name="brand_name" id="brand_name"--}}
                                                        {{--class="form-control input-xs select2_search">--}}
                                                        <select name="brand_name" id="brand_name"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="ALL">ALL</option>
                                                            {{--@foreach($brand_name as $bn)--}}
                                                            {{--<option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class=" col-md-2 col-sm-2 ">
                                                    <button type="button" id="btn_display"
                                                            class="btn btn-default btn-sm">
                                                        <i class="fa fa-check"></i> <b>Display Data</b></button>
                                                </div>
                                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                    <div id="export_buttons">

                                                    </div>
                                                </div>
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
    @if(Auth::user()->desig === 'RM'||Auth::user()->desig === 'HO'|| Auth::user()->desig === 'AM'|| Auth::user()->desig === 'ASM'|| Auth::user()->desig ==='DSM'|| Auth::user()->desig ==='SM'||Auth::user()->desig ==='AGM')
        <div class="row" id="balance_section" style="display:none;">
            <section class="panel-body" style="padding-top: 0px">

                <div class="col-md-1">Pending Cheque</div>
                <div class="col-md-2"><input id="pmck" disabled style="width: 100%;"></div>
                <div class="col-md-1">Pending Cash</div>
                <div class="col-md-2"><input id="pmcs" disabled style="width: 100%;"></div>
                <div class="col-md-1">Approved Cheque</div>
                <div class="col-md-2"><input id="amck" disabled style="width: 100%;"></div>
                <div class="col-md-1">Approved Cash</div>
                <div class="col-md-2"><input id="amcs" disabled style="width: 100%;"></div>
            </section>
        </div>

    @endif


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

                                    <th style="text-align: center"><input type="checkbox" id="selectAll"><span> </span>All
                                    </th>
                                    {{--<th>All</th>--}}
                                    <th>Action</th>
                                    <th>Pay Month</th>
                                    <th>Terr Id</th>
                                    <th>Don Type</th>
                                    <th>Brand/Region</th>
                                    <th>DSM Check</th>
                                    <th>BenId</th>
                                    <th>Ben Name</th>
                                    <th>Pro Amt</th>
                                    <th>App Amt</th>
                                    <th>Pay Mode</th>
                                    <th>Inf of</th>
                                    <th>Freq</th>

                                    <th>L App Amt</th>
                                    <th>L Freq</th>
                                    <th>L Pay Month</th>

                                    <th>Speciality</th>

                                    <th>Rq No</th>
                                    <th>Address</th>
                                    <th>Bentype</th>
                                    <th>Purpose</th>
                                    <th>NoP</th>
                                    <th>Mob</th>
                                    <th>Rq Dt</th>

                                    <th>Remarks</th>
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
                                                    Requistion Verification
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
                                                            <label for="apr_amount"
                                                                   class="col-md-6 col-sm-6 control-label"><b>Approved
                                                                    Amount
                                                                    :</b></label>
                                                            <div class="col-md-6">
                                                                <input type="number" min="1"
                                                                       class="form-control input-sm" name="apr_amount"
                                                                       id="apr_amount" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>


                                                <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="mop"
                                                                   class="col-md-6 col-sm-6 control-label fnt_size"><b>Mode
                                                                    of payment</b></label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <select name="mop" id="mop"
                                                                        class="form-control input-sm filter-option pull-left tol">
                                                                    <option value="">Select</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">


                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="inf_of"
                                                                   class="col-sm-6 col-md-6 control-label fnt_size"><b>Infavour
                                                                    of</b></label>
                                                            <div class="col-md-6 col-sm-6">

                                                                <input type="text" class="form-control input-xs"
                                                                       name="inf_of" id="inf_of"
                                                                >

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="freq"
                                                                   class="col-md-6 col-sm-6 control-label fnt_size"><b>Frequency</b></label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <select name="freq" id="freq"
                                                                        class="form-control input-sm filter-option pull-left tol">
                                                                    <option value="">Select</option>

                                                                </select>
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
    @include('donation.modal.delete_requisition')
    @include('donation.modal.showLastThree')
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

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    {{--{{Html::script('public/site_resource/CellEdit-master/js/dataTables.cellEdit.js')}}--}}
    {{--<script src="public/site_resource/CellEdit-master/js/dataTables.cellEdit.js"></script>--}}
    {{Html::script('public/site_resource/js/donation_script/requisition_script.js')}}


    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}

    <script type="text/javascript">

        servloc_tid = "{{url('donation/regwMpoTerrList')}}";
        servloc = "{{url('dcrep/prescripSurveyReport')}}";
        servloc_am = "{{url('donation/regWTerrAmList')}}";
        brand_region = "{{url('donation/brandRegion')}}";
        display_data = "{{url('donation/requisition_data')}}";
        update_row = "{{url('donation/update_row')}}";
        delete_row = "{{url('donation/delete_row')}}";
        verify_row = "{{url('donation/verify_row')}}";
        freq_edit = "{{url('donation/freq_edit')}}";
        brand_region_be = "{{url('donation/brandRegion_be')}}";
        get_BrandBy_docId = "{{url('donation/get_BrandBy_docId')}}";

        eid = "{{Auth::user()->user_id}}";
        {{--log_name = '{{Auth::user()->name}}';--}}
            log_id = '{{Auth::user()->user_id}}';
        log_desig = '{{Auth::user()->desig}}';
        _csrf_token = '{{csrf_token()}}';
    </script>

@endsection