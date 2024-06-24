@extends('_layout_shared._master')
@section('title','Doctor Medicine Requisition')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
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

        body {
            counter-reset: Serial; /* Set the Serial counter to 0 */
        }

        table {
            border-collapse: separate;
        }

        table tbody tr td:nth-child(2):before {
            counter-increment: Serial; /* Increment the Serial counter */
            content: "" counter(Serial);
        }

        /* Display the counter */


    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Doctor Medicine Requisition
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}


                                    @if(Auth::user()->user_id === '1016856' || Auth::user()->user_id === '1005975')

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" readonly="">
                                                                @foreach($rm_terr as $rt)
                                                                    <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm"
                                                        >
                                                            <option value="">Select Territory</option>
{{--                                                            @foreach($am_terr as $terr)--}}
{{--                                                                <option value="{{$terr->am_terr_id}}">--}}
{{--                                                                    {{$terr->am_terr_id}}</option>--}}
{{--                                                            @endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
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

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="depo"
                                                           class="col-md-4 col-sm-6 control-label"><b>Depot</b></label>
                                                    <div class="col-md-8">
                                                        <select name="depo" id="depo"
                                                                class="form-control input-sm">
                                                            <option value="">Select Depot</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-4 col-sm-6 control-label"><b>Doctor</b></label>
                                                    <div class="col-md-8">
                                                        <select name="docid" id="docid"
                                                                class="form-control input-sm">
                                                            <option value="">Select Doctor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    @endif


                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM')

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" readonly="">
                                                                @foreach($rm_terr as $rt)
                                                                    <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm"
                                                        >
                                                            <option value="">Select Territory</option>
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
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
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

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="depo"
                                                           class="col-md-4 col-sm-6 control-label"><b>Depot</b></label>
                                                    <div class="col-md-8">
                                                        <select name="depo" id="depo"
                                                                class="form-control input-sm">
                                                            <option value="">Select Depot</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-4 col-sm-6 control-label"><b>Doctor</b></label>
                                                    <div class="col-md-8">
                                                        <select name="docid" id="docid"
                                                                class="form-control input-sm">
                                                            <option value="">Select Doctor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    @endif

                                    @if(Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM')
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" disabled>
                                                                @foreach($rm_terr as $rt)
                                                                    <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
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
                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>
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
                                                            <option value="" disabled>Select</option>
                                                            @foreach($month_name as $mn)
                                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="depo"
                                                           class="col-md-4 col-sm-6 control-label"><b>Depot</b></label>
                                                    <div class="col-md-8">
                                                        <select name="depo" id="depo"
                                                                class="form-control input-sm">
                                                            <option value="">Select Depot</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-4 col-sm-6 control-label"><b>Doctor</b></label>
                                                    <div class="col-md-8">
                                                        <select name="docid" id="docid"
                                                                class="form-control input-sm">
                                                            <option value="">Select Doctor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class=" col-md-2 col-sm-2 ">
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



                                    @endif

                                    @if(Auth::user()->desig === 'MPO'||Auth::user()->desig === 'Sr. MPO')
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" disabled>
                                                                @foreach($rm_terr as $rt)
                                                                    <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
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

                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
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

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="depo"
                                                           class="col-md-4 col-sm-6 control-label"><b>Depot</b></label>
                                                    <div class="col-md-8">
                                                        <select name="depo" id="depo"
                                                                class="form-control input-sm">
                                                            <option value="">Select Depot</option>
                                                            @foreach($depo as $dp)
                                                                <option value="{{$dp->depot_id}}">{{$dp->depot_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-4 col-sm-6 control-label"><b>Doctor</b></label>
                                                    <div class="col-md-8">
                                                        <select name="docid" id="docid"
                                                                class="form-control input-sm">
                                                            <option value="">Select Doctor</option>
                                                            @foreach($dterr as $mn)
                                                                <option value="{{$mn->doctor_id}}"
                                                                        data-docname="{{$mn->doctor_name}}">{{$mn->doctor_id}}
                                                                    - {{$mn->doctor_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    @endif


                                    <div class="row">


                                        <div class="col-md-3 col-sm-2 ">
                                            <div class="form-group">
                                                <label for="pcode"
                                                       class="col-md-4 col-sm-6 control-label"><b>Pcode</b></label>
                                                <div class="col-md-8">
                                                    {{--<select name="pcode" class="form-control" id="pcode">--}}
                                                    <input name="pcode" id="pcode" class="form-control"
                                                           list="pcode_list" type="text"
                                                           oninput="this.value = this.value.toUpperCase()">
                                                    <datalist id="pcode_list">
                                                        <option value="" disabled selected>Code</option>
                                                            @foreach($product as $pro)
                                                           <option value="{{$pro->p_code}}"
                                                                   data-pname="{{$pro->brand_name}}"
                                                                   data-psize="{{$pro->pack_s}}"
                                                                   data-spval="{{$pro->s_p}}">
                                                                {{$pro->p_code}} - {{$pro->brand_name}}</option>
                                                        @endforeach
                                                    </datalist>
                                                    {{--</select>--}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="display: none">
                                            <div class="form-group">
                                                <label for="pname"
                                                       class="col-md-4 col-sm-6 control-label"><b>pname</b></label>
                                                <div class="col-md-8">
                                                    <input type="text" name="pname" style="text-transform: uppercase;"
                                                           class=" form-control"
                                                           autocomplete="off" readonly="" id="pname">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="display: none">
                                            <div class="form-group">
                                                <label for="pack"
                                                       class="col-md-4 col-sm-6 control-label"><b>pack</b></label>
                                                <div class="col-md-8">
                                                    <input type="text" name="pack" style="text-transform: uppercase;"
                                                           class="pack form-control"
                                                           autocomplete="off" readonly="" id="pack">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="display: none">
                                            <div class="form-group">
                                                <label for="spval"
                                                       class="col-md-4 col-sm-6 control-label"><b>spval</b></label>
                                                <div class="col-md-8">
                                                    <input type="text" name="spval" style="text-transform: uppercase;"
                                                           class="spval form-control"
                                                           autocomplete="off" readonly="" id="spval">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="depo"
                                                       class="col-md-4 col-sm-6 control-label"><b>Quantity</b></label>
                                                <div class="col-md-8">
                                                    <input type="number" min="1" oninput="validity.valid||(value='');" name="quant"
                                                           style="text-transform: uppercase;"
                                                           class=" form-control"
                                                           autocomplete="off" id="quant">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total"
                                                       class="col-md-4 col-sm-6 control-label"><b>Total</b></label>
                                                <div class="col-md-8">
                                                    <input type="number" name="total" style="text-transform: uppercase;"
                                                           class=" form-control"
                                                           autocomplete="off" readonly="" id="total">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-2 " style="padding: 0px;">
                                            <div class="button-group">
                                                <button id="add-row" value="Add Row"><i
                                                            class="fa fa-plus"></i></button>
                                                <span>&nbsp;&nbsp;</span>
                                                <button id="remove_row" class="button danger"><i
                                                            class="fa fa-minus"></i>
                                                </button>

                                                {{--<button id="insert_button" type="button" class="pull-right">Save--}}
                                                {{--</button>--}}

                                            </div>
                                        </div>



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

    <section class="panel">
        <div class="panel-body">
            <div class="col-md-12 table-responsive" style="padding-left: 5px;padding-right: 5px;">


                <table class="table table-condensed table-bordered" id="dre">
                    <thead>
                    <tr>
                        <th></th>
                        <th>SL No.</th>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Pack Size</th>
                        <th>Quantity</th>
                        <th>Unit Price </th>
                        <th> Total </th>
                        {{--<th>Frequency(*)</th>--}}
                        {{--<th>Proposed Amt.(*)</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @for($x=0; $x <0; $x++)
                        <tr>
                            <td>
                                <input type="checkbox" name="record">
                                {{--<input type="checkbox" class="chk form-control" name="row_chk" >--}}
                            </td>
                            <td style="white-space: nowrap;">
                                {{--<input type="text" name="doc_id" class="doc_id form-control"--}}
                                {{--ng-model="td.doc_id" autocomplete="off"--}}
                                {{--maxlength="6" size="6">--}}
                            </td>
                            <td>

                            </td>
                            <td>
                                <input type="text" name="pname" style="text-transform: uppercase;"
                                       class="pname form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="text" name="pack" style="text-transform: uppercase;"
                                       class="pack form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="number" name="quant" style="text-transform: uppercase;"
                                       class="quant form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="text" name="spval" style="text-transform: uppercase;"
                                       class="spval form-control"
                                       autocomplete="off" readonly="">
                            </td>
                            <td>
                                <input type="number" name="total" style="text-transform: uppercase;"
                                       class="total form-control"
                                       autocomplete="off" readonly="">

                            </td>

                            {{--<td>--}}
                            {{--<input type="text" name="proposed_amt" class="proposed_amt form-control"--}}
                            {{--ng-model="td.proposed_amt" pattern="\d*"--}}
                            {{--autocomplete="off" maxlength="8" size="8" ng-change="checkval($index,td.proposed_amt)" ng-enter="addAmount()">--}}
                            {{--</td>--}}
                        </tr>
                    @endfor

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7" style="text-align: right;"><b>Total Amount</b></td>
                        <td><b><input type="text" readonly="" class="total_spval form-control" autocomplete="off"></b>
                        </td>
                    </tr>
                    {{--<tr ng-show="showInitProgress">--}}
                    {{--<td colspan="10" class="text-center"></td>--}}
                    {{--<i class="fa fa-spin fa-spinner" style="font-size: 20px;"></i>--}}
                    {{--<span style="font-size: 15px;">  Please Wait..</span></td>--}}
                    {{--</tr>--}}
                    </tfoot>

                </table>


            </div>

            <div class="col-md-11 " style="padding: 0px;" >
                <div class="button-group">

                    <button id="insert_button" type="button" class="pull-right">Save
                    </button>

                </div>
            </div>

        </div>

    </section>


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


    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $("#docid").select2();

            servloc_tid = "{{url('dmr/getMpoTerr_DMR')}}";

            servloc_am = "{{url('dmr/regWTerrAmList')}}";
            insert_row = "{{url('dmr/insert_row_dmr')}}";

            depo_and_doc = "{{url('dmr/depo_and_doc_dmr')}} ";

            var prod_code = "{{url('dmr/prod_code')}}";

            _csrf_token = '{{csrf_token()}}';

            // $("#bgt_month").on('change', function (e) {
            //     e.preventDefault();
            //     var month = $('#bgt_month').val() ;
            //     console.log(month);

            //     $.ajax({
            //         type: "post",
            //         url: prod_code,
            //         dataType: 'json',
            //         data: {
            //             month: month,
            //             _token: '{{csrf_token()}}'
            //         },
            //         success: function (response) {
            //             console.log(response);

            //             var selCode = "";
            //             $("#pcode_list").empty().append("<option value='loader'>Loading...</option>");
            //             for (var j = 0; j < response.length; j++) {
            //                 var id = response[j]['p_code'];
            //                 var val = response[j]['p_code'] + '-' + response[j]['brand_name'];
            //                 selCode += "<option value='" + id + "' data-pname = '" + response[j]['brand_name'] + "' data-psize = '" + response[j]['pack_s'] + "' data-spval = '" + response[j]['cogm'] + "'>" + val + "</option>";
            //             }
            //             $('#pcode_list').empty().append(selCode);

            //         },
            //         error: function (data) {
            //             console.log(data);
            //         }
            //     });


            // });


            $("#add-row").click(function () {
                console.log('add button clicked');
                event.preventDefault();
                var pcode = $("#pcode").val();
                console.log(pcode);
                var pname = $("#pname").val();
                var packsize = $("#pack").val();
                var spval = $("#spval").val();
                var quantity = $("#quant").val();
                var flag_p_code = true;
                console.log(quantity);
                var total_spval = $("#total").val();
                if ($("#pcode").val() == null || $("#pcode").val() == '') {
                    toastr.info('Please select a product code');
                }
                else if ($("#quant").val() == '') {
                    toastr.info('Please select quantity');
                }
                else if ($("#pname").val() == '') {
                    toastr.info('Please try to add the product gain');
                }
                else {

                    $(".pr_code").each(function () {

                        if (pcode == $(this).text()) {
                            flag_p_code = false;

                        }
                    });
                    if (flag_p_code) {

                        var markup = "<tr>" +
                            "<td><input type='checkbox' name='record'></td>" +
                            "<td style='white-space: nowrap;'></td>" +
                            "<td class='pr_code'>" + pcode + "</td>" +
                            "<td>" + pname + "</td>" +
                            "<td>" + packsize + "</td>" +
                            "<td>" + quantity + "</td>" +
                            "<td>" + spval + "</td>" +
                            "<td class='total' >" + total_spval + "</td>" +
                            "</tr>";

                        $("table tbody").prepend(markup);

                        $("#pcode").val('');
                        $("#quant").val('');
                        $("#total").val('');

                        var grandTotal = 0;

                        $(".total").each(function () {
                            var stval = parseFloat($(this).text());
                            console.log(stval);
                            grandTotal += isNaN(stval) ? 0 : stval;
                        });

                        console.log('total spval is ' + grandTotal);
                        $(".total_spval").val(grandTotal.toFixed(2));
                    }
                    else {
                        toastr.info('This product has already been added');
                    }

                }

            });

            // Find and remove selected table rows
            $("#remove_row").click(function () {
                console.log('remove button clicked');
                event.preventDefault();
                $("table tbody").find('input[name="record"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });

                var grandTotal = 0;

                $(".total").each(function () {
                    var stval = parseFloat($(this).text());
                    console.log(stval);
                    grandTotal += isNaN(stval) ? 0 : stval;
                });

                console.log('total spval is ' + grandTotal);
                $(".total_spval").val(grandTotal.toFixed(2));

            });

            $("#insert_button").click(function () {


              if ($("#mpo_terr").val() === "") {
                    alert("Please select MPO Territory");
                }
              else if ($("#bgt_month").val() === "") {
                  alert("Please select Month");
              }
              else if ($("#depo").val() === "") {
                  alert("Please select Depot");
              }
                else if ($("#docid").val() === "") {
                    alert("Please select Doctor");
                }

                else{

                  var mpoterr = $('#mpo_terr').val();
                  var bgt_month = $('#bgt_month').val();
                  var depo = $('#depo').val();
                  var docid = $('#docid').val();
                  var docname = $('#docid option:selected').data('docname');
                  // var gl = $("#docid option:selected").data('gl');
                  console.log(docname);

                  var myTab = document.getElementById('dre');
                  // var myTab = $("document #myTable");
                  console.log('insert button clicked');
                  var tblData = myTab.rows;
                  console.log(tblData);
                  var insertdata = [];
                  var tmpData = new Array();
                  // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
                  for (i = 1; i < myTab.rows.length - 1; i++) {

                      // GET THE CELLS COLLECTION OF THE CURRENT ROW.
                      var objCells = myTab.rows.item(i).cells;
                      // var objCells = myTab.rows.item(i);
                      console.log(objCells);
                      tmpData[i - 1] = {
                          "pcode": objCells.item(2).innerHTML,
                          "pname": objCells.item(3).innerHTML,
                          "psize": objCells.item(4).innerHTML,
                          "quant": objCells.item(5).innerHTML,
                          "sp": objCells.item(6).innerHTML,
                          "sp_total": objCells.item(7).innerHTML
                      }
                      insertdata.push(tmpData[i - 1]);
                      console.log(tmpData[i - 1]);
                      // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
                      // for (var j = 2; j < objCells.length; j++) {
                      //     tmpData =  objCells.item(j).innerHTML;
                      //     console.log(tmpData);
                      // }
                      // info.innerHTML = info.innerHTML + '<br />';     // ADD A BREAK (TAG).
                  }

                  if (insertdata.length !== 0) {


                      console.log('write ajax code here');
                      $.ajax({
                          type: "POST",
                          dataType: 'json',
                          data: {
                              insertdata: JSON.stringify(insertdata),
                              mpoterr: mpoterr,
                              month: bgt_month,
                              depo: depo,
                              doctor: docid,
                              docname: docname,
                              _token: _csrf_token
                          },
                          url: insert_row,
                          beforeSend: function () {
                              // Show image container
                              // $("#balance_section").hide();
                              // $("#report-body").hide();
                              $("#loader").show();
                          },
                          success: function (data) {

                              $("table tbody tr").remove();
                              $(".total_spval").val('');

                              console.log("data " + data);
                              if (data.error) {
                                  toastr.error(data.error, '', {timeOut: 5000});
                              } else if (data.success) {
                                  toastr.success(data.success, '', {timeOut: 5000});
                              }

                              $("#loader").hide();

                              // setTimeout(function(){// wait for 3 secs
                              //     window.location.reload(); // then reload the page
                              // }, 3000);

                          },
                          complete: function (data) {
                              // Hide image container
                              $("#loader_submit").hide();
                              $("#loader").hide();

                          },
                          error: function (err) {
                              console.log(err);
                              $("#loader").hide();
                          }
                      });
                  }

              }

            });

            $("#pcode").on('change', function () {


                // $(document).on('change', "#pcode", function () {
                // event.preventDefault();
                console.log('product code changed');
                console.log($("#pcode").val());
                // console.log($('#pcode_list').attr('data-pname'));
                var val = $('#pcode').val();

                var pname = $('#pcode_list option').filter(function () {
                    return this.value == val;
                }).data('pname');

                console.log(pname);

                if (pname == undefined) {
                    $("#pcode").val('');
                    $('#quant').val('');
                    $('#total').val('');
                    alert('Product code does not exist');
                }
                else {
                    $('#quant').val('');
                    $('#total').val('');

                    var pack = $('#pcode_list option').filter(function () {
                        return this.value == val;
                    }).data('psize');

                    var sp = $('#pcode_list option').filter(function () {
                        return this.value == val;
                    }).data('spval');

                    $('#pname').val(pname);
                    $('#pack').val(pack);
                    $('#spval').val(sp);

                    // $('#pname').val($('#pcode option:selected').data('pname'));
                    // $('#pack').val($('#pcode option:selected').data('psize'));
                    // $('#spval').val($('#pcode option:selected').data('spval'));
                }

            });


            $("#quant").on('change', function (e) {
                e.preventDefault();
                var total_pcode = $('#spval').val() * $('#quant').val();
                $('#total').val(total_pcode.toFixed(2));

            });

            $("#am_terr").on('change', function () {
                $('#depo').empty();
                $('#docid').empty();
                $("#doc_info").hide();
                var am_terr = $("#am_terr").val();
                var smrm_id = $("#rm_terr").val();
                console.log(am_terr);
                console.log(smrm_id);
                $("#mpo_terr").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "GET",
                    url: servloc_tid,
                    dataType: 'json',
                    data: {amTerr: am_terr, rmTerrId: smrm_id},
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        selOptsMPO += "<option value=''>Select Territory</option>";
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

            $("#mpo_terr").on('change', function () {
                $("#doc_info").hide();
                var mpo_terr = $("#mpo_terr").val();

                console.log(mpo_terr);

                $("#docid").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: depo_and_doc,
                    dataType: 'json',
                    data: {
                        mpo_terr: mpo_terr,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);

                        var selOptsDOC = "";
                        selOptsDOC += "<option value='' disabled>Select Doctor</option>";
                        for (var j = 0; j < response['docid'].length; j++) {
                            var id = response['docid'][j]['doctor_id'];
                            var val = response['docid'][j]['doctor_id'] + '-' + response['docid'][j]['doctor_name'];
                            selOptsDOC += "<option value='" + id + "' data-docname = '" + response['docid'][j]['doctor_name'] + "'>" + val + "</option>";
                        }
                        $('#docid').empty().append(selOptsDOC);


                        // for Depot


                        var selOptsDEPOT = "";
                        selOptsDEPOT += "<option value='' disabled>Select Depot</option>";
                        for (var j = 0; j < response['depo'].length; j++) {
                            var id = response['depo'][j]['depot_id'];
                            var val = response['depo'][j]['depot_name'];
                            selOptsDEPOT += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#depo').empty().append(selOptsDEPOT);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });


        });


    </script>



@endsection